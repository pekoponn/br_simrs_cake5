<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Log\Log;
use Throwable;

class OrdersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        $this->loadModel('Orders');
        $this->loadModel('Registrations');
        $this->loadModel('Patients');
        $this->loadModel('Doctors');
        $this->loadModel('OrderStatuses');
        $this->loadModel('OrderPrescriptions');
        $this->loadModel('OrderLaboratories');
        $this->loadModel('OrderRadiologies');
        $this->loadModel('Medicines');
        $this->loadModel('MasterTindakan');
        $this->loadModel('Users');
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Patients', 'Doctors', 'OrderStatuses', 'Registrations'],
            'order' => ['Orders.tgl_order' => 'DESC'],
            'limit' => 30,
        ];

        $orders = $this->paginate($this->Orders);
        $this->set(compact('orders'));
    }

    public function form($registrationId = null)
    {
        $registration = null;
        $registrationNo = trim((string)$this->request->getQuery('registration_no', ''));

        if (!empty($registrationId) && is_numeric($registrationId)) {
            $registration = $this->Registrations->find()
                ->contain(['Patients'])
                ->where(['Registrations.id' => (int)$registrationId])
                ->first();
        }

        if (empty($registration) && $registrationNo !== '') {
            $registration = $this->Registrations->find()
                ->contain(['Patients'])
                ->where([
                    'OR' => [
                        'Registrations.registration_no' => $registrationNo,
                        'Registrations.registration_number' => $registrationNo,
                    ],
                ])
                ->first();
        }

        if (empty($registration)) {
            $this->Flash->error('No Registrasi tidak ditemukan. Buka E-Order dari EMR pasien.');
            return $this->redirect(['action' => 'index']);
        }

        $patient = $registration->patient ?? null;

        if (empty($patient)) {
            $this->Flash->error('Data pasien dari registrasi ini tidak ditemukan.');
            return $this->redirect(['action' => 'index']);
        }

        $historyOrders = $this->Orders->find()
            ->contain(['OrderStatuses'])
            ->where(['Orders.patient_id' => $patient->id])
            ->order(['Orders.tgl_order' => 'DESC'])
            ->all();

        $order = $this->Orders->newEmptyEntity();
        $order->registration_id = $registration->id;
        $order->patient_id = $patient->id;
        $order->doctor_id = null;
        $order->tgl_order = date('Y-m-d H:i:s');
        $order->lokasi_depo = 'FARMASI 2 RAJAL DEPO';

        $identity = $this->request->getAttribute('identity');
        $userId = $identity ? ($identity->id ?? null) : null;
        $createdByName = 'Admin';

        if (!empty($userId)) {
            $user = $this->Users->find()
                ->where(['Users.id' => $userId])
                ->first();

            if ($user) {
                $createdByName = $user->name
                    ?? $user->full_name
                    ?? $user->username
                    ?? $user->email
                    ?? 'Admin';
            }
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $data['pesan'] = $this->request->getData('pesan') ?? null;
            $data['registration_id'] = $registration->id;
            $data['patient_id'] = $patient->id;
            $data['doctor_id'] = !empty($data['doctor_id']) ? (int)$data['doctor_id'] : null;
            $data['tgl_order'] = date('Y-m-d H:i:s');

            if (!empty($userId)) {
                $data['created_by'] = (int)$userId;
            }

            $order = $this->Orders->patchEntity($order, $data);
            $order->pesan = $data['pesan'] ?? null;

            $order->created_by = !empty($userId) ? (int)$userId : 1;
            $order->status_id = 1;

            $prescriptions = [];
            $laboratories = [];
            $radiologies = [];

            if (!empty($data['prescriptions'])) {
                foreach ($data['prescriptions'] as $row) {
                    $medicineId = !empty($row['medicine_id']) ? (int)$row['medicine_id'] : 0;

                    if ($medicineId <= 0) {
                        continue;
                    }

                    if (!$this->Medicines->exists(['Medicines.id' => $medicineId])) {
                        continue;
                    }

                    $totalHarga = $row['total_harga'] ?? 0;
                    $totalHarga = str_replace(['Rp', '.', ','], ['', '', '.'], (string)$totalHarga);

                    $prescriptions[] = [
                        'medicine_id' => $medicineId,
                        'medicine_unit' => $row['medicine_unit'] ?? null,
                        'is_kronis' => !empty($row['is_kronis']) ? 1 : 0,
                        'jml_per_hari' => (float)($row['jml_per_hari'] ?? 0),
                        'qty_min' => (float)($row['qty_min'] ?? 0),
                        'jml_hari' => (int)($row['jml_hari'] ?? 0),
                        'qty_satuan' => (float)($row['qty_satuan'] ?? 0),
                        'aturan_pakai' => $row['aturan_pakai'] ?? '',
                        'harga' => (float)($row['harga'] ?? 0),
                        'total_harga' => (float)$totalHarga,
                        'keterangan' => $row['keterangan'] ?? '',
                    ];
                }
            }

            if (!empty($data['laboratories'])) {
                foreach ($data['laboratories'] as $row) {
                    $code = trim((string)($row['code'] ?? ''));
                    $name = trim((string)($row['examination_name'] ?? ''));

                    if ($code === '' && $name === '') {
                        continue;
                    }

                    if ($name === '') {
                        continue;
                    }

                    $laboratories[] = [
                        'master_tindakan_id' => !empty($row['master_tindakan_id'])
                            ? (int)$row['master_tindakan_id']
                            : null,
                        'code' => $code !== '' ? $code : null,
                        'examination_name' => $name,
                        'price' => $this->normalizeCurrency($row['price'] ?? 0),
                        'approval_note' => trim((string)($row['approval_note'] ?? '')),
                    ];
                }
            }

            if (!empty($data['radiologies'])) {
                foreach ($data['radiologies'] as $row) {
                    $code = trim((string)($row['code'] ?? ''));
                    $name = trim((string)($row['examination_name'] ?? ''));

                    if ($code === '' && $name === '') {
                        continue;
                    }

                    if ($name === '') {
                        continue;
                    }

                    $radiologies[] = [
                        'master_tindakan_id' => !empty($row['master_tindakan_id'])
                            ? (int)$row['master_tindakan_id']
                            : null,
                        'code' => $code !== '' ? $code : null,
                        'examination_name' => $name,
                        'price' => $this->normalizeCurrency($row['price'] ?? 0),
                        'approval_note' => trim((string)($row['approval_note'] ?? '')),
                    ];
                }
            }

            if (
                empty($prescriptions)
                && empty($data['obat_lain'])
                && empty($laboratories)
                && empty($radiologies)
            ) {
                $this->Flash->error('Isi minimal satu resep, pemeriksaan laboratorium, atau radiologi.');

                return $this->redirect($this->referer());
            }

            $connection = $this->Orders->getConnection();
            $saveError = null;
            $orderNumberLockAcquired = false;

            try {
                $this->Orders->acquireOrderNumberLock();
                $orderNumberLockAcquired = true;

                $saved = (bool)$connection->transactional(function () use (
                    $order,
                    $prescriptions,
                    $laboratories,
                    $radiologies,
                    &$saveError
                ) {
                    if (empty($order->no_order)) {
                        $order->no_order = $this->Orders->generateOrderNumber();
                        $order->setError('no_order', [], true);
                    }

                    if (!$this->Orders->save($order)) {
                        $saveError = [
                            'stage' => 'order',
                            'errors' => $order->getErrors(),
                        ];

                        return false;
                    }

                    foreach ($prescriptions as $index => $prescription) {
                        $prescription['order_id'] = $order->id;
                        $entity = $this->OrderPrescriptions->newEntity($prescription);

                        if (!$this->OrderPrescriptions->save($entity)) {
                            $saveError = [
                                'stage' => 'prescription',
                                'row' => $index + 1,
                                'medicine_id' => $prescription['medicine_id'] ?? null,
                                'errors' => $entity->getErrors(),
                            ];

                            return false;
                        }
                    }

                    foreach ($laboratories as $index => $laboratory) {
                        $laboratory['order_id'] = $order->id;
                        $entity = $this->OrderLaboratories->newEntity($laboratory);

                        if (!$this->OrderLaboratories->save($entity)) {
                            $saveError = [
                                'stage' => 'laboratory',
                                'row' => $index + 1,
                                'code' => $laboratory['code'] ?? null,
                                'errors' => $entity->getErrors(),
                            ];

                            return false;
                        }
                    }

                    foreach ($radiologies as $index => $radiology) {
                        $radiology['order_id'] = $order->id;
                        $entity = $this->OrderRadiologies->newEntity($radiology);

                        if (!$this->OrderRadiologies->save($entity)) {
                            $saveError = [
                                'stage' => 'radiology',
                                'row' => $index + 1,
                                'code' => $radiology['code'] ?? null,
                                'errors' => $entity->getErrors(),
                            ];

                            return false;
                        }
                    }

                    return true;
                });
            } catch (Throwable $exception) {
                $saved = false;
                $saveError = [
                    'stage' => 'exception',
                    'message' => $exception->getMessage(),
                ];
            } finally {
                if ($orderNumberLockAcquired) {
                    try {
                        $this->Orders->releaseOrderNumberLock();
                    } catch (Throwable $exception) {
                        Log::warning('Gagal melepas lock nomor E-Order.', [
                            'message' => $exception->getMessage(),
                        ]);
                    }
                }
            }

            if (!$saved) {
                Log::error('Gagal menyimpan E-Order secara atomik.', [
                    'registration_id' => $registration->id,
                    'patient_id' => $patient->id,
                    'user_id' => $userId,
                    'error' => $saveError,
                ]);
                $this->Flash->error(
                    'Order gagal disimpan. Tidak ada data order atau resep yang disimpan. '
                    . 'Silakan periksa kembali isian.'
                );
            } else {
                $this->Flash->success('Order berhasil dibuat. No Order: ' . $order->no_order);

                return $this->redirect([
                    'action' => 'form',
                    $registration->id,
                ]);
            }
        }

        $doctorNameField = $this->Doctors->getSchema()->hasColumn('doctor_name') ? 'doctor_name' : 'name';

        $doctorList = $this->Doctors->find('list', [
            'keyField' => 'id',
            'valueField' => $doctorNameField,
        ])
            ->order(['Doctors.' . $doctorNameField => 'ASC'])
            ->toArray();

        $statuses = $this->OrderStatuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'nama',
        ])
            ->order(['urutan' => 'ASC'])
            ->toArray();

        $depoList = [
            'FARMASI 2 RAJAL DEPO',
            'FARMASI 1 RAWAT INAP',
            'FARMASI IGD',
        ];

        $this->set(compact(
            'order',
            'registration',
            'patient',
            'historyOrders',
            'statuses',
            'depoList',
            'doctorList',
            'createdByName'
        ));
    }

    public function detail($id = null)
    {
        if (empty($id)) {
            $this->Flash->error('ID order tidak ditemukan.');
            return $this->redirect(['action' => 'index']);
        }

        $order = $this->Orders->get($id, [
            'contain' => [
                'Patients',
                'Doctors',
                'OrderStatuses',
                'Registrations',
                'OrderPrescriptions' => ['Medicines'],
                'OrderLaboratories',
                'OrderRadiologies',
            ],
        ]);

        $this->set(compact('order'));
    }

    public function historyPasien($patientId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        if (empty($patientId)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([]));
        }

        $rows = $this->Orders->find()
            ->contain(['OrderStatuses'])
            ->where(['Orders.patient_id' => $patientId])
            ->order(['Orders.tgl_order' => 'DESC'])
            ->limit(50)
            ->all();

        $results = [];

        foreach ($rows as $o) {
            $results[] = [
                'id' => $o->id,
                'no_order' => $o->no_order,
                'tgl_order' => !empty($o->tgl_order) ? $o->tgl_order->format('d-m-Y H:i') : '-',
                'status' => $o->order_status->nama ?? '-',
                'warna' => $o->order_status->warna ?? '#6c757d',
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }

    public function historyOrderDetail($id = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        if (empty($id) || !is_numeric($id)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'ID order tidak valid.',
                ], JSON_UNESCAPED_UNICODE));
        }

        $order = $this->Orders->find()
            ->contain([
                'Patients',
                'Doctors',
                'OrderStatuses',
                'Registrations',
                'OrderPrescriptions' => ['Medicines'],
                'OrderLaboratories',
                'OrderRadiologies',
            ])
            ->where(['Orders.id' => (int)$id])
            ->first();

        if (!$order) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Order tidak ditemukan.',
                ], JSON_UNESCAPED_UNICODE));
        }

        $patient = $order->patient ?? null;
        $doctor = $order->doctor ?? null;
        $registration = $order->registration ?? null;
        $status = $order->order_status ?? null;

        $serviceType = $registration->service_type ?? '-';

        if ($serviceType === 'rawat_jalan') {
            $asalPasien = 'Rawat Jalan';
        } elseif ($serviceType === 'rawat_inap') {
            $asalPasien = 'Rawat Inap';
        } elseif ($serviceType === 'igd') {
            $asalPasien = 'Rawat IGD';
        } else {
            $asalPasien = ucwords(str_replace('_', ' ', (string)$serviceType));
        }

        $items = [];
        $laboratories = [];
        $radiologies = [];

        foreach (($order->order_prescriptions ?? []) as $rx) {
            $medicine = $rx->medicine ?? null;

            $items[] = [
                'kode' => $medicine->code ?? '-',
                'nama' => $medicine->name ?? '-',
                'generic' => $medicine->generic_name ?? '',
                'satuan' => $rx->medicine_unit ?? $medicine->unit_1 ?? '-',
                'is_kronis' => !empty($rx->is_kronis) ? 1 : 0,
                'jml_per_hari' => $rx->jml_per_hari ?? 0,
                'qty_min' => $rx->qty_min ?? 0,
                'jml_hari' => $rx->jml_hari ?? 0,
                'qty_satuan' => $rx->qty_satuan ?? 0,
                'aturan_pakai' => $rx->aturan_pakai ?? '',
                'harga' => (float)($rx->harga ?? 0),
                'total_harga' => (float)($rx->total_harga ?? 0),
            ];
        }

        foreach (($order->order_laboratories ?? []) as $laboratory) {
            $laboratories[] = [
                'master_tindakan_id' => $laboratory->master_tindakan_id ?? null,
                'code' => $laboratory->code ?? '',
                'examination_name' => $laboratory->examination_name ?? '',
                'price' => (float)($laboratory->price ?? 0),
                'approval_note' => $laboratory->approval_note ?? '',
            ];
        }

        foreach (($order->order_radiologies ?? []) as $radiology) {
            $radiologies[] = [
                'master_tindakan_id' => $radiology->master_tindakan_id ?? null,
                'code' => $radiology->code ?? '',
                'examination_name' => $radiology->examination_name ?? '',
                'price' => (float)($radiology->price ?? 0),
                'approval_note' => $radiology->approval_note ?? '',
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'no_order' => $order->no_order ?? '-',
                    'tgl_order' => !empty($order->tgl_order) ? $order->tgl_order->format('d-m-Y') : '-',
                    'jam_order' => !empty($order->tgl_order) ? $order->tgl_order->format('H:i:s') : '-',
                    'lokasi_depo' => $order->lokasi_depo ?? '-',
                    'pesan' => $order->pesan ?? '',
                    'catatan' => $order->catatan ?? '',
                    'laboratory_note' => $order->laboratory_note ?? '',
                    'radiology_note' => $order->radiology_note ?? '',
                    'doctor_id' => $order->doctor_id ?? '',
                    'doctor_name' => $doctor->doctor_name ?? $doctor->name ?? $doctor->nama ?? '-',
                    'status' => $status->nama ?? '-',
                    'status_warna' => $status->warna ?? '#6c757d',
                ],
                'patient' => [
                    'id' => $patient->id ?? '',
                    'no_rm' => $patient->code ?? '-',
                    'nama' => $patient->full_name ?? '-',
                    'jaminan' => $registration->insurance_type ?? $registration->payment_method ?? 'UMUM',
                    'asal_pasien' => $asalPasien,
                ],
                'items' => $items,
                'laboratories' => $laboratories,
                'radiologies' => $radiologies,
            ], JSON_UNESCAPED_UNICODE));
    }

    public function cariPasien()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $results = [];

        if (strlen($q) >= 2) {
            $rows = $this->Patients->find()
                ->where([
                    'OR' => [
                        'Patients.code LIKE' => '%' . $q . '%',
                        'Patients.full_name LIKE' => '%' . $q . '%',
                    ],
                ])
                ->limit(20)
                ->all();

            foreach ($rows as $p) {
                $results[] = [
                    'id' => $p->id,
                    'no_rm' => $p->code ?? '',
                    'nama' => $p->full_name ?? '',
                    'jaminan' => $p->jaminan ?? 'Umum',
                ];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }

    public function cariObat()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $results = [];

        if (strlen($q) >= 2) {
            $rows = $this->Medicines->find()
                ->where([
                    'OR' => [
                        'Medicines.code LIKE' => '%' . $q . '%',
                        'Medicines.code_kfa LIKE' => '%' . $q . '%',
                        'Medicines.name LIKE' => '%' . $q . '%',
                        'Medicines.generic_name LIKE' => '%' . $q . '%',
                        'Medicines.inventory_category LIKE' => '%' . $q . '%',
                    ],
                ])
                ->order(['Medicines.name' => 'ASC'])
                ->limit(30)
                ->all();

            foreach ($rows as $m) {
                $results[] = [
                    'id' => $m->id,
                    'kode' => $m->code ?? '',
                    'nama' => $m->name ?? '',
                    'generic' => $m->generic_name ?? '',
                    'kategori' => $m->inventory_category ?? '',
                    'harga' => (float)($m->harga_jual ?? $m->hna ?? 0),
                    'unit' => $m->unit_1 ?? '',
                ];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }

    public function searchLaboratoryActions()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $conditions = [
            'MasterTindakan.kategori' => 'Laboratorium',
            'MasterTindakan.is_active' => 1,
        ];

        if ($q !== '') {
            $conditions['OR'] = [
                'MasterTindakan.kode LIKE' => '%' . $q . '%',
                'MasterTindakan.nama LIKE' => '%' . $q . '%',
            ];
        }

        $rows = $this->MasterTindakan->find()
            ->select(['id', 'kode', 'nama', 'harga', 'keterangan'])
            ->where($conditions)
            ->order(['MasterTindakan.nama' => 'ASC'])
            ->limit(100)
            ->enableHydration(false)
            ->toArray();

        foreach ($rows as &$row) {
            $row['harga'] = (float)($row['harga'] ?? 0);
            $row['keterangan'] = $row['keterangan'] ?? '';
        }
        unset($row);

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($rows, JSON_UNESCAPED_UNICODE));
    }

    public function searchRadiologyActions()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $conditions = [
            'MasterTindakan.kategori' => 'Radiologi',
            'MasterTindakan.is_active' => 1,
        ];

        if ($q !== '') {
            $conditions['OR'] = [
                'MasterTindakan.kode LIKE' => '%' . $q . '%',
                'MasterTindakan.nama LIKE' => '%' . $q . '%',
            ];
        }

        $rows = $this->MasterTindakan->find()
            ->select(['id', 'kode', 'nama', 'harga', 'keterangan'])
            ->where($conditions)
            ->order(['MasterTindakan.nama' => 'ASC'])
            ->limit(100)
            ->enableHydration(false)
            ->toArray();

        foreach ($rows as &$row) {
            $row['harga'] = (float)($row['harga'] ?? 0);
            $row['keterangan'] = $row['keterangan'] ?? '';
        }
        unset($row);

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($rows, JSON_UNESCAPED_UNICODE));
    }

    private function normalizeCurrency($value): float
    {
        $value = trim((string)$value);
        if ($value === '') {
            return 0.0;
        }

        $value = str_replace(['Rp', ' '], '', $value);
        if (strpos($value, ',') !== false) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        } else {
            $value = str_replace('.', '', $value);
        }

        return (float)$value;
    }

}
