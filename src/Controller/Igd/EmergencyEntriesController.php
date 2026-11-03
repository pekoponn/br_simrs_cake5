<?php
declare(strict_types=1);

namespace App\Controller\Igd;

use App\Controller\AppController;

class EmergencyEntriesController extends AppController
{
    private const TINDAKAN_CATEGORIES = [
        'tindakan_medis',
        'obat',
        'bedah',
        'laboratorium',
        'radiologi',
        'penunjang_medis',
    ];

    public function index()
    {
        $this->Registrations = $this->fetchTable('Registrations');
        $this->Doctors = $this->fetchTable('Doctors');
        $this->MasterTenagaMedis = $this->fetchTable('MasterTenagaMedis');

            $q = trim((string)$this->request->getQuery('q'));
            $dateFrom = $this->request->getQuery('date_from', date('Y-m-d'));
            $dateTo = $this->request->getQuery('date_to', date('Y-m-d'));

            if ($dateTo < $dateFrom) {
                $dateTo = $dateFrom;
            }

            $query = $this->Registrations->find()
                ->contain(['Patients', 'Doctors'])
                ->where(['Registrations.service_type' => 'igd']);

            if (!empty($dateFrom)) {
                $query->where(['DATE(Registrations.modified) >=' => $dateFrom]);
            }

            if (!empty($dateTo)) {
                $query->where(['DATE(Registrations.modified) <=' => $dateTo]);
            }

            if ($q !== '') {
                $query->where([
                    'OR' => [
                        'Registrations.registration_no LIKE' => '%' . $q . '%',
                        'Registrations.registration_number LIKE' => '%' . $q . '%',
                        'Patients.code LIKE' => '%' . $q . '%',
                        'Patients.full_name LIKE' => '%' . $q . '%',
                        'Doctors.doctor_name LIKE' => '%' . $q . '%',
                        'Doctors.name LIKE' => '%' . $q . '%',
                    ],
                ]);
            }

            $this->paginate = [
                'limit' => 50,
                'order' => ['Registrations.modified' => 'DESC', 'Registrations.id' => 'DESC'],
            ];

            $registrations = $this->paginate($query);

            $medicalRecordNos = [];
            try {
                $regIds = $registrations->extract('id')->toList();
                if (!empty($regIds)) {
                    $this->MedicalRecords = $this->fetchTable('MedicalRecords');
                    $medicalRecordNos = $this->MedicalRecords->find('list', [
                        'keyField' => 'registration_id',
                        'valueField' => 'medical_record_no',
                    ])->where(['registration_id IN' => $regIds])->toArray();
                }
            } catch (\Throwable $e) {
                $medicalRecordNos = [];
            }

            $doctorsList = $this->Doctors->find()
                ->select(['id', 'doctor_name', 'code'])
                ->where(['is_active' => 'Y'])
                ->order(['doctor_name' => 'ASC'])
                ->all();

            $triageNurses = $this->MasterTenagaMedis->find()
                ->select(['id', 'nama', 'kode'])
                ->where(['is_active' => 1])
                ->order(['nama' => 'ASC'])
                ->all();

            $this->set(compact('registrations', 'q', 'dateFrom', 'dateTo', 'doctorsList', 'triageNurses', 'medicalRecordNos'));
        }

            public function view($id = null)
    {
        return $this->redirect(['action' => 'resumeMedis', $id]);
    }

    public function resumeMedis($id = null)
    {
        $this->Registrations = $this->fetchTable('Registrations');
        $this->MedicalResumes = $this->fetchTable('MedicalResumes');

        $containRelations = ['Patients', 'Doctors'];

        if ($this->Registrations->hasAssociation('EmergencyActions')) {
            $containRelations[] = 'EmergencyActions';
        }

        $registration = $this->Registrations->get($id, [
            'contain' => $containRelations,
        ]);

        // Resume IGD = baris medical_resumes dengan outpatient_visit_id kosong
        $medicalResume = $this->MedicalResumes->find()
            ->where([
                'MedicalResumes.registration_id' => $registration->id,
                'MedicalResumes.outpatient_visit_id IS' => null,
            ])
            ->first();

        if (!$medicalResume) {
            $medicalResume = $this->MedicalResumes->newEmptyEntity();
            $medicalResume->registration_id = $registration->id;
            $medicalResume->patient_id = $registration->patient_id ?? null;
            if (!empty($registration->doctor_id)) {
                $medicalResume->doctor1_id = $registration->doctor_id;
            }
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            // Field kunci tidak boleh diubah dari form
            unset($data['registration_id'], $data['patient_id'], $data['outpatient_visit_id'], $data['doctor1_id']);

            $medicalResume = $this->MedicalResumes->patchEntity($medicalResume, $data);

            if ($this->MedicalResumes->save($medicalResume)) {
                $this->Flash->success('Resume medis IGD berhasil disimpan.');
                return $this->redirect(['action' => 'resumeMedis', $registration->id]);
            }

            $this->Flash->error('Resume medis IGD gagal disimpan. Periksa kembali isian form.');
        }

        $icd10Items = [];
        if (!empty($registration->icd10_items)) {
            $icd10Items = is_string($registration->icd10_items)
                ? (json_decode($registration->icd10_items, true) ?: [])
                : (array)$registration->icd10_items;
        }

        $icd9Items = [];
        if (!empty($registration->icd9_items)) {
            $icd9Items = is_string($registration->icd9_items)
                ? (json_decode($registration->icd9_items, true) ?: [])
                : (array)$registration->icd9_items;
        }

        $medicineItems = [];

        $this->set(compact('registration', 'medicalResume', 'icd10Items', 'icd9Items', 'medicineItems'));
    }

    public function emr($id = null)
    {
        $this->Registrations = $this->fetchTable('Registrations');

        $containRelations = ['Patients', 'Doctors'];

        if ($this->Registrations->hasAssociation('EmergencyActions')) {
            $containRelations[] = 'EmergencyActions';
        }

        $registration = $this->Registrations->get($id, [
            'contain' => $containRelations,
        ]);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            $emergencyActions = $data['emergency_actions'] ?? [];
            unset($data['emergency_actions']);

            $icd10Codes = $data['icd10_code'] ?? [];
            $icd10Namas = $data['icd10_nama'] ?? [];
            $icd10Utama = (int)($data['icd10_utama'] ?? 0);
            unset($data['icd10_code'], $data['icd10_nama'], $data['icd10_selected'], $data['icd10_utama']);

            $icd10Items = [];
            foreach ($icd10Codes as $idx => $kode) {
                if (empty($kode) && empty($icd10Namas[$idx] ?? '')) {
                    continue;
                }

                $icd10Items[] = [
                    'kode'  => trim((string)$kode),
                    'nama'  => trim((string)($icd10Namas[$idx] ?? '')),
                    'utama' => ((int)$idx === $icd10Utama) ? 1 : 0,
                ];
            }

            $data['icd10_items'] = json_encode($icd10Items);

            foreach ($icd10Items as $item) {
                if (!empty($item['utama'])) {
                    $data['diagnosis_primary'] = $data['diagnosis_primary'] ?? $item['kode'];
                    break;
                }
            }

            $icd9Codes = $data['icd9_code'] ?? [];
            $icd9Namas = $data['icd9_nama'] ?? [];
            $icd9Kategori = $data['icd9_kategori'] ?? [];
            $icd9Utama = (int)($data['icd9_utama'] ?? 0);
            unset($data['icd9_code'], $data['icd9_nama'], $data['icd9_kategori'], $data['icd9_selected'], $data['icd9_utama']);

            $icd9Items = [];
            foreach ($icd9Codes as $idx => $kode) {
                if (empty($kode) && empty($icd9Namas[$idx] ?? '')) {
                    continue;
                }

                $icd9Items[] = [
                    'kode'     => trim((string)$kode),
                    'nama'     => trim((string)($icd9Namas[$idx] ?? '')),
                    'kategori' => trim((string)($icd9Kategori[$idx] ?? '')),
                    'utama'    => ((int)$idx === $icd9Utama) ? 1 : 0,
                ];
            }

            $data['icd9_items'] = json_encode($icd9Items);

            $registration = $this->Registrations->patchEntity($registration, $data);

            if ($this->Registrations->save($registration)) {
                if (!empty($emergencyActions) && $this->Registrations->hasAssociation('EmergencyActions')) {
                    $this->EmergencyActions = $this->fetchTable('EmergencyActions');

                    $this->EmergencyActions->deleteAll([
                        'registration_id' => $registration->id,
                    ]);

                    foreach ($emergencyActions as $action) {
                        if (empty(trim((string)($action['action_name'] ?? '')))) {
                            continue;
                        }

                        $qty = (int)($action['quantity'] ?? 1);
                        $price = (float)($action['unit_price'] ?? 0);

                        $actionEntity = $this->EmergencyActions->newEntity([
                            'registration_id'  => $registration->id,
                            'action_code'      => $action['action_code'] ?? '',
                            'action_name'      => $action['action_name'] ?? '',
                            'action_category'  => $action['action_category'] ?? 'tindakan_medis',
                            'quantity'         => $qty,
                            'unit_price'       => $price,
                            'total_price'      => $qty * $price,
                            'notes'            => $action['notes'] ?? '',
                        ]);

                        $this->EmergencyActions->save($actionEntity);
                    }
                }

                $this->Flash->success('Data EMR IGD berhasil disimpan.');
                return $this->redirect(['action' => 'emr', $registration->id]);
            }

            $this->Flash->error('Gagal menyimpan data EMR IGD. Periksa kembali isian form.');
        }

        $this->set(compact('registration'));
    }

    public function selesaiPeriksa($id = null)
    {
        $this->request->allowMethod(['post']);

        $this->Registrations = $this->fetchTable('Registrations');
        $this->OutpatientBillings = $this->fetchTable('OutpatientBillings');
        $this->OutpatientBillingItems = $this->fetchTable('OutpatientBillingItems');

        $contain = ['Patients', 'Doctors'];

        if ($this->Registrations->hasAssociation('EmergencyActions')) {
            $contain[] = 'EmergencyActions';
        }

        $registration = $this->Registrations->get($id, [
            'contain' => $contain,
        ]);

        $existing = $this->OutpatientBillings->find()
            ->where([
                'registration_id' => $registration->id,
                'billing_no LIKE' => 'IGD-%',
            ])
            ->first();

        if ($existing) {
            $this->Flash->success('Pemeriksaan IGD sudah selesai. Tagihan sudah ada.');
            return $this->redirect(['prefix' => 'Kasir', 'controller' => 'OutpatientBillings',
                'action' => 'kasir',
                $existing->id,
            ]);
        }

        $conn = $this->OutpatientBillings->getConnection();
        $billingId = null;

        $conn->transactional(function () use ($registration, &$billingId) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($registration->emergency_actions ?? [] as $action) {
                $qty = (int)($action->quantity ?? 1);
                $price = (float)($action->unit_price ?? 0);
                $total = $qty * $price;

                if ($total <= 0) {
                    continue;
                }

                $subtotal += $total;

                $itemsData[] = [
                    'item_type' => 'tindakan',
                    'item_code' => $action->action_code ?? null,
                    'item_name' => $action->action_name ?? 'Tindakan IGD',
                    'quantity' => $qty,
                    'unit' => 'kali',
                    'unit_price' => $price,
                    'total_price' => $total,
                    'discount_amount' => 0,
                    'final_price' => $total,
                    'is_delete' => 0,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                ];
            }

            if ($subtotal <= 0 && !empty($registration->total_fee)) {
                $subtotal = (float)$registration->total_fee;

                $itemsData[] = [
                    'item_type' => 'tindakan',
                    'item_code' => 'IGD',
                    'item_name' => 'Pelayanan IGD',
                    'quantity' => 1,
                    'unit' => 'kali',
                    'unit_price' => $subtotal,
                    'total_price' => $subtotal,
                    'discount_amount' => 0,
                    'final_price' => $subtotal,
                    'is_delete' => 0,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                ];
            }

            $billing = $this->OutpatientBillings->newEntity([
                'billing_no' => 'IGD-' . date('YmdHis') . '-' . $registration->id,
                'outpatient_visit_id' => null,
                'registration_id' => $registration->id,
                'patient_id' => $registration->patient_id ?? null,
                'doctor_id' => $registration->doctor_id ?? null,
                'visit_date' => $registration->registration_date ?? date('Y-m-d'),
                'polyclinic_name' => 'IGD',
                'insurance_type' => $registration->insurance_type ?? $registration->payment_method ?? 'Umum',
                'total_action' => $subtotal,
                'total_medicine' => 0,
                'total_lab' => 0,
                'total_radiology' => 0,
                'total_other' => 0,
                'subtotal' => $subtotal,
                'discount_type' => 'nominal',
                'discount_value' => 0,
                'discount_amount' => 0,
                'grand_total' => $subtotal,
                'paid_amount' => 0,
                'change_amount' => 0,
                'status' => 'waiting_payment',
                'is_referred' => 0,
                'is_inpatient' => 0,
                'is_active' => '1',
                'is_create' => 1,
                'is_update' => 0,
                'is_delete' => 0,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ]);

            if (!$this->OutpatientBillings->save($billing)) {
                debug($billing->getErrors());
                die;
            }
            $billingId = $billing->id;

            foreach ($itemsData as $row) {
                $row['billing_id'] = $billing->id;

                $item = $this->OutpatientBillingItems->newEntity($row);

                if (!$this->OutpatientBillingItems->save($item)) {
                    throw new \Exception('Gagal menyimpan item billing IGD.');
                }
            }

            $registration->status = 'done';
            $registration->modified = date('Y-m-d H:i:s');

            if (!$this->Registrations->save($registration)) {
                throw new \Exception('Gagal update status IGD.');
            }
        });

        $this->Flash->success('Pemeriksaan IGD selesai. Tagihan IGD berhasil dibuat.');

        return $this->redirect(['prefix' => 'Kasir', 'controller' => 'OutpatientBillings',
            'action' => 'kasir',
            $billingId,
        ]);
    }

    public function cppt($id = null)
    {
        $this->Registrations = $this->fetchTable('Registrations');

        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients', 'Doctors'],
        ]);

        $this->set(compact('registration'));
    }

    public function add()
    {
        return $this->redirect(['prefix' => 'Registrasi', 'controller' => 'Registrations',
            'action' => 'add',
        ]);
    }

    public function edit($id = null)
    {
        return $this->redirect(['prefix' => 'Registrasi', 'controller' => 'Registrations',
            'action' => 'edit',
            $id,
        ]);
    }

    public function observasi($id = null)
    {
        $this->Registrations = $this->fetchTable('Registrations');

        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients', 'Doctors'],
        ]);

        $this->set(compact('registration'));
    }

    public function tindakan($id = null)
    {
        $this->Registrations = $this->fetchTable('Registrations');
        $this->EmergencyActions = $this->fetchTable('EmergencyActions');

        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients', 'Doctors'],
        ]);

        $actions = $this->EmergencyActions->find()
            ->where(['EmergencyActions.registration_id' => $registration->id])
            ->order(['EmergencyActions.id' => 'ASC'])
            ->all();

        $this->set(compact('registration', 'actions'));
    }

    public function tambahTindakan($id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->Registrations = $this->fetchTable('Registrations');
        $this->EmergencyActions = $this->fetchTable('EmergencyActions');

        $registration = $this->Registrations->get($id);

        if (($registration->status ?? '') === 'done') {
            return $this->jsonResult(false, 'Pemeriksaan sudah selesai, item tidak bisa ditambah.');
        }

        $category = (string)$this->request->getData('action_category');
        $name     = trim((string)$this->request->getData('action_name'));
        $code     = trim((string)$this->request->getData('action_code'));
        $notes    = trim((string)$this->request->getData('notes'));
        $qty      = (int)$this->request->getData('quantity');
        $price    = (float)$this->request->getData('unit_price');

        if (!in_array($category, self::TINDAKAN_CATEGORIES, true)) {
            return $this->jsonResult(false, 'Kategori tidak valid.');
        }
        if ($name === '') {
            return $this->jsonResult(false, 'Nama item wajib diisi.');
        }
        if ($qty < 1) {
            $qty = 1;
        }
        if ($price < 0) {
            $price = 0;
        }

        $entity = $this->EmergencyActions->newEntity([
            'registration_id' => $registration->id,
            'action_code'     => $code,
            'action_name'     => $name,
            'action_category' => $category,
            'quantity'        => $qty,
            'unit_price'      => $price,
            'total_price'     => $qty * $price,
            'notes'           => $notes,
        ]);

        if (!$this->EmergencyActions->save($entity)) {
            return $this->jsonResult(false, 'Gagal menyimpan item.', ['errors' => $entity->getErrors()]);
        }

        return $this->jsonResult(true, 'Item berhasil ditambahkan.', ['id' => $entity->id]);
    }

    public function hapusTindakan($actionId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->autoRender = false;

        $this->Registrations = $this->fetchTable('Registrations');
        $this->EmergencyActions = $this->fetchTable('EmergencyActions');

        $action = $this->EmergencyActions->get($actionId);
        $registration = $this->Registrations->get($action->registration_id);

        if (($registration->status ?? '') === 'done') {
            return $this->jsonResult(false, 'Pemeriksaan sudah selesai, item tidak bisa dihapus.');
        }

        if (!$this->EmergencyActions->delete($action)) {
            return $this->jsonResult(false, 'Gagal menghapus item.');
        }

        return $this->jsonResult(true, 'Item dihapus.');
    }

    private function jsonResult(bool $success, string $message, array $extra = [])
    {
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['success' => $success, 'message' => $message] + $extra));
    }

    public function cariMaster()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $type = (string)$this->request->getQuery('type');
        $q    = trim((string)$this->request->getQuery('q'));
        $like = '%' . $q . '%';
        $limit = $q === '' ? 50 : 20;
        $data = [];

        try {
            if ($type === 'tindakan_medis') {
                $priceField = [
                    'bpjs'    => 'harga_bpjs',
                    'reimbes' => 'harga_reimbes',
                    'umum'    => 'harga_umum',
                ][(string)$this->request->getQuery('price_type', 'umum')] ?? 'harga_umum';

                $this->MasterTindakan = $this->fetchTable('MasterTindakan');

                $query = $this->MasterTindakan->find()
                    ->where(['MasterTindakan.is_active' => 1])
                    ->order(['MasterTindakan.nama' => 'ASC'])
                    ->limit($limit);

                if ($q !== '') {
                    $query->where([
                        'OR' => [
                            'MasterTindakan.nama LIKE' => $like,
                            'MasterTindakan.kode LIKE' => $like,
                        ],
                    ]);
                }

                foreach ($query->all() as $row) {
                    $data[] = [
                        'code'  => (string)$row->kode,
                        'name'  => (string)$row->nama,
                        'price' => (float)$row->get($priceField),
                    ];
                }
            } elseif ($type === 'obat') {
                $this->Medicines = $this->fetchTable('Medicines');

                $query = $this->Medicines->find()
                    ->where(['Medicines.is_active IN' => ['Y', '1']])
                    ->order(['Medicines.name' => 'ASC'])
                    ->limit($limit);

                if ($q !== '') {
                    $query->where([
                        'OR' => [
                            'Medicines.name LIKE' => $like,
                            'Medicines.code LIKE' => $like,
                            'Medicines.generic_name LIKE' => $like,
                        ],
                    ]);
                }

                foreach ($query->all() as $row) {
                    $data[] = [
                        'code'  => (string)$row->code,
                        'name'  => (string)$row->name,
                        'price' => (float)$row->harga_jual,
                    ];
                }
            } else {
                return $this->jsonResult(false, 'Jenis master tidak dikenal.');
            }
        } catch (\Throwable $e) {
            return $this->jsonResult(false, 'Gagal membaca data master. (' . $e->getMessage() . ')');
        }

        return $this->jsonResult(true, 'OK', ['data' => $data]);
    }

    public function labRo($id = null)
    {
        $this->Registrations = $this->fetchTable('Registrations');

        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients', 'Doctors'],
        ]);

        $this->set(compact('registration'));
    }

    public function kajianKeperawatan($id = null)
    {
        $this->Registrations = $this->fetchTable('Registrations');

        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients', 'Doctors'],
        ]);

        $this->set(compact('registration'));
    }

    public function delete($id = null)
    {
        $this->Flash->error('Data IGD tidak dihapus dari sini. Hapus dari Registrasi.');
        return $this->redirect(['action' => 'index']);
    }
}