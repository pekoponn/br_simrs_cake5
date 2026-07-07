<?php
declare(strict_types=1);

namespace App\Controller;

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
        $this->loadModel('Medicines');
        $this->loadModel('Users');
        $this->loadModel('OrderLaboratories');
        $this->loadModel('MasterLaboratories');
        $this->loadModel('OrderRadiologies');
        $this->loadModel('MasterRadiologies');
        $this->loadModel('OrderSupports');
        $this->loadModel('MasterSupports');
        $this->loadModel('OrderSurgeries');
        $this->loadModel('OrderMcus');
        $this->loadModel('MasterOperationTypes');
        $this->loadModel('MasterMcuTypes');
        $this->loadModel('NutritionCombine');
    }

    public function index()
    {
        $q = trim((string)$this->request->getQuery('q', ''));
        $dateFrom = $this->request->getQuery('date_from', date('Y-m-d'));
        $dateTo = $this->request->getQuery('date_to', date('Y-m-d'));
        $statusId = $this->request->getQuery('status_id', '');
        $depo = $this->request->getQuery('depo', '');

        if (empty($dateFrom)) {
            $dateFrom = date('Y-m-d');
        }

        if (empty($dateTo)) {
            $dateTo = date('Y-m-d');
        }

        if ($dateTo < $dateFrom) {
            $dateTo = $dateFrom;
        }

        $query = $this->Orders->find()
            ->contain(['Patients', 'Doctors', 'OrderStatuses', 'Registrations'])
            ->where([
                'DATE(Orders.tgl_order) >=' => $dateFrom,
                'DATE(Orders.tgl_order) <=' => $dateTo,
            ]);

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'Orders.no_order LIKE' => '%' . $q . '%',
                    'Patients.code LIKE' => '%' . $q . '%',
                    'Patients.full_name LIKE' => '%' . $q . '%',
                    'Doctors.doctor_name LIKE' => '%' . $q . '%',
                    'Doctors.name LIKE' => '%' . $q . '%',
                    'Registrations.registration_no LIKE' => '%' . $q . '%',
                    'Registrations.registration_number LIKE' => '%' . $q . '%',
                    'Orders.lokasi_depo LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        if ($statusId !== '' && $statusId !== null) {
            $query->where(['Orders.status_id' => $statusId]);
        }

        if ($depo !== '' && $depo !== null) {
            $query->where(['Orders.lokasi_depo' => $depo]);
        }

        $this->paginate = [
            'contain' => ['Patients', 'Doctors', 'OrderStatuses', 'Registrations'],
            'order' => ['Orders.tgl_order' => 'DESC', 'Orders.id' => 'DESC'],
            'limit' => 30,
        ];

        $orders = $this->paginate($query);

        $statuses = $this->OrderStatuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'nama',
        ])
            ->order(['OrderStatuses.urutan' => 'ASC', 'OrderStatuses.id' => 'ASC'])
            ->toArray();

        $depoList = $this->Orders->find()
            ->select(['lokasi_depo'])
            ->where([
                'lokasi_depo IS NOT' => null,
                'lokasi_depo !=' => '',
            ])
            ->distinct(['lokasi_depo'])
            ->order(['lokasi_depo' => 'ASC'])
            ->enableHydration(false)
            ->all()
            ->extract('lokasi_depo')
            ->toList();

        if (empty($depoList)) {
            $depoList = [
                'FARMASI 2 RAJAL DEPO',
                'FARMASI 1 RAWAT INAP',
                'FARMASI IGD',
            ];
        }

        $this->set(compact(
            'orders',
            'q',
            'dateFrom',
            'dateTo',
            'statusId',
            'depo',
            'statuses',
            'depoList'
        ));
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

            if (empty($order->no_order)) {
                $order->no_order = $this->generateOrderNumber();
            }

            $order->created_by = !empty($userId) ? (int)$userId : 1;
            $order->status_id = 1;

            $prescriptions = [];

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

            $laboratories = [];

            if (!empty($data['laboratories'])) {
                foreach ($data['laboratories'] as $row) {
                    $labName = trim((string)($row['lab_name'] ?? ''));

                    if ($labName === '') {
                        continue;
                    }

                    $tariff = $row['tariff'] ?? 0;
                    $tariff = str_replace(['Rp', '.', ','], ['', '', '.'], (string)$tariff);

                    $laboratories[] = [
                        'registration_id' => $registration->id,
                        'patient_id' => $patient->id,
                        'doctor_id' => !empty($data['doctor_id']) ? (int)$data['doctor_id'] : null,
                        'lab_code' => trim((string)($row['lab_code'] ?? '')),
                        'lab_name' => $labName,
                        'tariff' => (float)$tariff,
                        'approval_note' => $row['approval_note'] ?? '',
                        'notes' => $row['notes'] ?? '',
                        'status' => 'draft',
                        'is_active' => 1,
                        'is_delete' => 0,
                    ];
                }
            }

            $radiologies = [];

            if (!empty($data['radiologies'])) {
                foreach ($data['radiologies'] as $row) {
                    $radioName = trim((string)($row['examination_name'] ?? ''));

                    if ($radioName === '') {
                        continue;
                    }

                    $tariff = $row['tariff'] ?? 0;
                    $tariff = str_replace(['Rp', '.', ','], ['', '', '.'], (string)$tariff);

                    $qty = !empty($row['qty']) ? (int)$row['qty'] : 1;
                    if ($qty <= 0) {
                        $qty = 1;
                    }

                    $total = $row['total'] ?? ((float)$tariff * $qty);
                    $total = str_replace(['Rp', '.', ','], ['', '', '.'], (string)$total);

                    $radiologies[] = [
                        'registration_id' => $registration->id,
                        'patient_id' => $patient->id,
                        'doctor_id' => !empty($data['doctor_id']) ? (int)$data['doctor_id'] : null,
                        'code' => trim((string)($row['code'] ?? '')),
                        'examination_name' => $radioName,
                        'tariff' => (float)$tariff,
                        'qty' => $qty,
                        'total' => (float)$total,
                        'approval_note' => $row['approval_note'] ?? '',
                        'notes' => $row['notes'] ?? '',
                        'status' => 'draft',
                        'is_active' => 1,
                        'is_delete' => 0,
                    ];
                }
            }

            $supports = [];

            if (!empty($data['supports'])) {
                foreach ($data['supports'] as $row) {
                    $supportName = trim((string)($row['support_name'] ?? ''));

                    if ($supportName === '') {
                        continue;
                    }

                    $tariff = $row['tariff'] ?? 0;
                    $tariff = str_replace(['Rp', '.', ','], ['', '', '.'], (string)$tariff);

                    $qty = !empty($row['qty']) ? (int)$row['qty'] : 1;
                    if ($qty <= 0) {
                        $qty = 1;
                    }

                    $total = $row['total'] ?? ((float)$tariff * $qty);
                    $total = str_replace(['Rp', '.', ','], ['', '', '.'], (string)$total);

                    $supports[] = [
                        'registration_id' => $registration->id,
                        'patient_id' => $patient->id,
                        'doctor_id' => !empty($data['doctor_id']) ? (int)$data['doctor_id'] : null,
                        'support_code' => trim((string)($row['support_code'] ?? '')),
                        'support_name' => $supportName,
                        'tariff' => (float)$tariff,
                        'qty' => $qty,
                        'total' => (float)$total,
                        'unit' => trim((string)($row['unit'] ?? '')),
                        'approval_note' => $row['approval_note'] ?? '',
                        'notes' => $row['notes'] ?? '',
                        'status' => 'draft',
                        'is_active' => 1,
                        'is_delete' => 0,
                    ];
                }
            }

            $surgery = null;

            if (!empty($data['surgery']) && is_array($data['surgery'])) {
                $surgeryData = $data['surgery'];

                $hasSurgery = false;
                foreach ($surgeryData as $sv) {
                    if (trim((string)$sv) !== '') {
                        $hasSurgery = true;
                        break;
                    }
                }

                if ($hasSurgery) {
                    $surgery = [
                        'registration_id' => $registration->id,
                        'patient_id' => $patient->id,
                        'doctor_id' => !empty($surgeryData['operator_id'])
                            ? (int)$surgeryData['operator_id']
                            : (!empty($data['doctor_id']) ? (int)$data['doctor_id'] : null),
                        'surgery_date' => date('Y-m-d'),
                        'surgery_time' => date('H:i:s'),
                        'operator_name' => trim((string)($surgeryData['operator_name'] ?? '')),

                        'operation_type_id' => !empty($surgeryData['operation_type_id']) ? (int)$surgeryData['operation_type_id'] : null,
                        'surgery_code' => trim((string)($surgeryData['surgery_code'] ?? '')),
                        'surgery_name' => trim((string)($surgeryData['surgery_name'] ?? $surgeryData['operation_type'] ?? '')),
                        'operation_type' => trim((string)($surgeryData['operation_type'] ?? $surgeryData['surgery_name'] ?? '')),
                        'tariff' => $this->cleanMoney($surgeryData['tariff'] ?? 0),
                        'jasa_rs' => $this->cleanMoney($surgeryData['jasa_rs'] ?? 0),
                        'jasa_dr' => $this->cleanMoney($surgeryData['jasa_dr'] ?? 0),
                        'jasa_paramedis' => $this->cleanMoney($surgeryData['jasa_paramedis'] ?? 0),
                        'unit' => trim((string)($surgeryData['unit'] ?? '')),

                        'notes' => $surgeryData['notes'] ?? '',
                        'approval_queue_no' => trim((string)($surgeryData['approval_queue_no'] ?? '')),
                        'approval_date' => !empty($surgeryData['approval_date']) ? $surgeryData['approval_date'] : null,
                        'approval_time' => !empty($surgeryData['approval_time']) ? $surgeryData['approval_time'] : null,
                        'operating_room' => trim((string)($surgeryData['operating_room'] ?? '')),
                        'approved_operator' => trim((string)($surgeryData['approved_operator'] ?? '')),
                        'approved_operation_type' => trim((string)($surgeryData['approved_operation_type'] ?? '')),
                        'anesthesia_type' => trim((string)($surgeryData['anesthesia_type'] ?? '')),
                        'approved_by' => trim((string)($surgeryData['approved_by'] ?? $createdByName)),
                        'status' => 'draft',
                        'is_active' => 1,
                        'is_delete' => 0,
                    ];
                }
            }

            $mcu = null;

            if (!empty($data['mcu']) && is_array($data['mcu'])) {
                $mcuData = $data['mcu'];

                // MCU mengikuti form client RS: hanya Jenis dan Keterangan yang menentukan order MCU diisi.
                // Tanggal dan jam otomatis mengikuti waktu order dibuat, jadi tidak dipakai untuk validasi kosong.
                $hasMcu = (
                    trim((string)($mcuData['mcu_type'] ?? '')) !== ''
                    || trim((string)($mcuData['notes'] ?? '')) !== ''
                );

                if ($hasMcu) {
                    $mcu = [
                        'registration_id' => $registration->id,
                        'patient_id' => $patient->id,
                        'doctor_id' => !empty($data['doctor_id']) ? (int)$data['doctor_id'] : null,
                        'mcu_date' => date('Y-m-d'),
                        'mcu_time' => date('H:i:s'),
                        'mcu_type' => trim((string)($mcuData['mcu_type'] ?? '')),
                        'notes' => $mcuData['notes'] ?? '',
                        'status' => 'draft',
                        'is_active' => 1,
                        'is_delete' => 0,
                    ];
                }
            }

            if (
                empty($prescriptions)
                && empty($data['obat_lain'])
                && empty($laboratories)
                && empty($radiologies)
                && empty($supports)
                && empty($surgery)
                && empty($mcu)
            ) {
                $this->Flash->error('Pilih obat, pemeriksaan laboratorium, pemeriksaan radiologi, penunjang, isi jadwal bedah, atau isi MCU terlebih dahulu.');
                return $this->redirect($this->referer());
            }

            if (!$this->Orders->save($order)) {
                debug($order->getErrors());
                die;
            }

            foreach ($prescriptions as $prescription) {
                $prescription['order_id'] = $order->id;
                $entity = $this->OrderPrescriptions->newEntity($prescription);

                if (!$this->OrderPrescriptions->save($entity)) {
                    debug($entity);
                    debug($entity->getErrors());
                    die;
                }
            }

            foreach ($laboratories as $laboratory) {
                $laboratory['order_id'] = $order->id;
                $entity = $this->OrderLaboratories->newEntity($laboratory);

                if (!$this->OrderLaboratories->save($entity)) {
                    debug($entity);
                    debug($entity->getErrors());
                    die;
                }
            }

            foreach ($radiologies as $radiology) {
                $radiology['order_id'] = $order->id;
                $entity = $this->OrderRadiologies->newEntity($radiology);

                if (!$this->OrderRadiologies->save($entity)) {
                    debug($entity);
                    debug($entity->getErrors());
                    die;
                }
            }

            foreach ($supports as $support) {
                $support['order_id'] = $order->id;
                $entity = $this->OrderSupports->newEntity($support);

                if (!$this->OrderSupports->save($entity)) {
                    debug($entity);
                    debug($entity->getErrors());
                    die;
                }
            }

            if (!empty($surgery)) {
                $surgery['order_id'] = $order->id;
                $entity = $this->OrderSurgeries->newEntity($surgery);

                if (!$this->OrderSurgeries->save($entity)) {
                    debug($entity);
                    debug($entity->getErrors());
                    die;
                }
            }

            if (!empty($mcu)) {
                $mcu['order_id'] = $order->id;
                $entity = $this->OrderMcus->newEntity($mcu);

                if (!$this->OrderMcus->save($entity)) {
                    debug($entity);
                    debug($entity->getErrors());
                    die;
                }
            }

            $this->Flash->success('Order berhasil dibuat. No Order: ' . $order->no_order);

            return $this->redirect([
                'action' => 'form',
                $registration->id
            ]);
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

        $this->loadModel('OutpatientVisits');

        $outpatientVisit = null;

        $outpatientVisit = $this->OutpatientVisits->find()
            ->where(['OutpatientVisits.registration_id' => $registration->id])
            ->first();

            $this->set(compact(
                'order',
                'registration',
                'patient',
                'historyOrders',
                'statuses',
                'depoList',
                'doctorList',
                'createdByName',
                'outpatientVisit'
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
                'OrderSupports',
                'OrderMcus',
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
                'OrderSupports',
                'OrderMcus',
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

        foreach (($order->order_prescriptions ?? []) as $rx) {
            $medicine = $rx->medicine ?? null;

            $items[] = [
                'kode' => $medicine->code ?? '-',
                'nama' => $medicine->name ?? '-',
                'generic' => $medicine->generic_name ?? '',
                'satuan' => $medicine->unit_1 ?? '-',
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

        $labs = [];

        foreach (($order->order_laboratories ?? []) as $lab) {
            $labs[] = [
                'kode' => $lab->lab_code ?? '',
                'nama' => $lab->lab_name ?? '',
                'tarif' => (float)($lab->tariff ?? 0),
                'approval' => $lab->approval_note ?? '',
                'notes' => $lab->notes ?? '',
            ];
        }

        $radios = [];

        foreach (($order->order_radiologies ?? []) as $radio) {
            $radios[] = [
                'kode' => $radio->code ?? '',
                'nama' => $radio->examination_name ?? '',
                'tarif' => (float)($radio->tariff ?? 0),
                'qty' => (int)($radio->qty ?? 1),
                'total' => (float)($radio->total ?? 0),
                'approval' => $radio->approval_note ?? '',
                'notes' => $radio->notes ?? '',
            ];
        }

        $supports = [];

        foreach (($order->order_supports ?? []) as $support) {
            $supports[] = [
                'kode' => $support->support_code ?? '',
                'nama' => $support->support_name ?? '',
                'tarif' => (float)($support->tariff ?? 0),
                'qty' => (int)($support->qty ?? 1),
                'total' => (float)($support->total ?? 0),
                'unit' => $support->unit ?? '',
                'approval' => $support->approval_note ?? '',
                'notes' => $support->notes ?? '',
            ];
        }

        $surgery = null; 

        $surgeryEntity = $this->OrderSurgeries->find()
            ->where(['OrderSurgeries.order_id' => (int)$id])
            ->order(['OrderSurgeries.id' => 'DESC'])
            ->first();

        if ($surgeryEntity) {
            $fmtDate = function ($v) {
                return !empty($v) && is_object($v) && method_exists($v, 'format') ? $v->format('Y-m-d') : ($v ?? '');
            };
            $fmtTime = function ($v) {
                return !empty($v) && is_object($v) && method_exists($v, 'format') ? $v->format('H:i') : ($v ?? '');
            };

            $surgery = [
                'surgery_date' => $fmtDate($surgeryEntity->surgery_date ?? null),
                'surgery_time' => $fmtTime($surgeryEntity->surgery_time ?? null),
                'operator_name' => $surgeryEntity->operator_name ?? '',
                'operation_type_id' => $surgeryEntity->operation_type_id ?? '',
                'surgery_code' => $surgeryEntity->surgery_code ?? '',
                'surgery_name' => $surgeryEntity->surgery_name ?? ($surgeryEntity->operation_type ?? ''),
                'operation_type' => $surgeryEntity->operation_type ?? ($surgeryEntity->surgery_name ?? ''),
                'tariff' => (float)($surgeryEntity->tariff ?? 0),
                'jasa_rs' => (float)($surgeryEntity->jasa_rs ?? 0),
                'jasa_dr' => (float)($surgeryEntity->jasa_dr ?? 0),
                'jasa_paramedis' => (float)($surgeryEntity->jasa_paramedis ?? 0),
                'unit' => $surgeryEntity->unit ?? '',
                'notes' => $surgeryEntity->notes ?? '',
                'approval_queue_no' => $surgeryEntity->approval_queue_no ?? '',
                'approval_date' => $fmtDate($surgeryEntity->approval_date ?? null),
                'approval_time' => $fmtTime($surgeryEntity->approval_time ?? null),
                'operating_room' => $surgeryEntity->operating_room ?? '',
                'approved_operator' => $surgeryEntity->approved_operator ?? '',
                'approved_operation_type' => $surgeryEntity->approved_operation_type ?? '',
                'anesthesia_type' => $surgeryEntity->anesthesia_type ?? '',
                'approved_by' => $surgeryEntity->approved_by ?? '',
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
                    'doctor_id' => $order->doctor_id ?? '',
                    'doctor_name' => $doctor->doctor_name ?? $doctor->name ?? $doctor->nama ?? '-',
                    'status' => $status->nama ?? '-',
                    'status_warna' => $status->warna ?? '#6c757d',
                ],
                'patient' => [
                    'id' => $patient->id ?? '',
                    'medical_record_no' => $patient->code ?? '-',
                    'nama' => $patient->full_name ?? '-',
                    'jaminan' => $registration->insurance_type ?? $registration->payment_method ?? 'UMUM',
                    'asal_pasien' => $asalPasien,
                ],
                'items' => $items,
                'labs' => $labs,
                'radios' => $radios,
                'supports' => $supports,
                'surgery' => $surgery,
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
                    'medical_record_no' => $p->code ?? '',
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

    public function cariLaboratorium()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $results = [];

        if (strlen($q) >= 2) {
            $rows = $this->MasterLaboratories->find()
                ->where([
                    'OR' => [
                        'MasterLaboratories.code LIKE' => '%' . $q . '%',
                        'MasterLaboratories.name LIKE' => '%' . $q . '%',
                        'MasterLaboratories.category LIKE' => '%' . $q . '%',
                    ],
                    'MasterLaboratories.is_active' => 1,
                ])
                ->order(['MasterLaboratories.name' => 'ASC'])
                ->limit(30)
                ->all();

            foreach ($rows as $lab) {
                $results[] = [
                    'id' => $lab->id,
                    'kode' => $lab->code ?? '',
                    'nama' => $lab->name ?? '',
                    'tarif' => (float)($lab->tariff ?? 0),
                    'kategori' => $lab->category ?? '',
                ];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }

    public function cariRadiologi()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $results = [];

        if (strlen($q) >= 2) {
            $rows = $this->MasterRadiologies->find()
                ->where([
                    'OR' => [
                        'MasterRadiologies.code LIKE' => '%' . $q . '%',
                        'MasterRadiologies.name LIKE' => '%' . $q . '%',
                        'MasterRadiologies.category LIKE' => '%' . $q . '%',
                    ],
                    'MasterRadiologies.is_active' => 1,
                ])
                ->order(['MasterRadiologies.name' => 'ASC'])
                ->limit(30)
                ->all();

            foreach ($rows as $radio) {
                $results[] = [
                    'id' => $radio->id,
                    'kode' => $radio->code ?? '',
                    'nama' => $radio->name ?? '',
                    'tarif' => (float)($radio->tariff ?? 0),
                    'kategori' => $radio->category ?? '',
                    'modality' => $radio->modality ?? '',
                ];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }

    public function cariPenunjang()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $results = [];

        if (strlen($q) >= 2) {
            $rows = $this->MasterSupports->find()
                ->where([
                    'OR' => [
                        'MasterSupports.code LIKE' => '%' . $q . '%',
                        'MasterSupports.name LIKE' => '%' . $q . '%',
                        'MasterSupports.category LIKE' => '%' . $q . '%',
                    ],
                    'MasterSupports.is_active' => 1,
                ])
                ->order(['MasterSupports.name' => 'ASC'])
                ->limit(30)
                ->all();

            foreach ($rows as $support) {
                $results[] = [
                    'id' => $support->id,
                    'kode' => $support->code ?? '',
                    'nama' => $support->name ?? '',
                    'tarif' => (float)($support->tariff ?? 0),
                    'unit' => $support->unit ?? '',
                    'kategori' => $support->category ?? '',
                ];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }




    public function cariNutritionCombine()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $mode = trim((string)$this->request->getQuery('mode', 'menu'));
        $results = [];

        try {
            $query = $this->NutritionCombine->find();
            $schema = $this->NutritionCombine->getSchema();

            /*
             * FIX MASTER GIZI:
             * Di database kamu nama kolom kandungan adalah nutrition_content_name,
             * bukan nutrition_content. Kalau tetap pakai nutrition_content, query SQL error
             * lalu masuk catch dan hasilnya kosong: "Data gizi tidak ditemukan".
             * Bagian ini dibuat fleksibel supaya tetap aman kalau nama kolom berbeda.
             */
            $contentField = null;
            foreach (['nutrition_content_name', 'nutrition_content', 'content_name', 'kandungan'] as $field) {
                if ($schema->hasColumn($field)) {
                    $contentField = $field;
                    break;
                }
            }

            $valueField = null;
            foreach (['nutritional_value', 'nutrition_value', 'value', 'nilai'] as $field) {
                if ($schema->hasColumn($field)) {
                    $valueField = $field;
                    break;
                }
            }

            $unitField = null;
            foreach (['content_unit', 'nutrition_unit', 'unit', 'satuan'] as $field) {
                if ($schema->hasColumn($field)) {
                    $unitField = $field;
                    break;
                }
            }

            if ($schema->hasColumn('is_active')) {
                $type = strtolower((string)$schema->getColumnType('is_active'));

                if (in_array($type, ['integer', 'tinyinteger', 'smallinteger', 'boolean'], true)) {
                    $query->where(['NutritionCombine.is_active' => 1]);
                } else {
                    $query->where(function ($exp) {
                        return $exp->in('NutritionCombine.is_active', ['Y', 'y', '1', 1]);
                    });
                }
            }

            if ($schema->hasColumn('is_delete')) {
                $query->where(['NutritionCombine.is_delete' => 0]);
            }

            if ($q !== '') {
                $or = [];

                foreach (['code', 'name', 'description'] as $field) {
                    if ($schema->hasColumn($field)) {
                        $or['NutritionCombine.' . $field . ' LIKE'] = '%' . $q . '%';
                    }
                }

                if (!empty($contentField)) {
                    $or['NutritionCombine.' . $contentField . ' LIKE'] = '%' . $q . '%';
                }

                if (!empty($unitField)) {
                    $or['NutritionCombine.' . $unitField . ' LIKE'] = '%' . $q . '%';
                }

                if (!empty($or)) {
                    $query->where(['OR' => $or]);
                }
            }

            $orderBy = ['NutritionCombine.name' => 'ASC'];
            if (!empty($contentField)) {
                $orderBy['NutritionCombine.' . $contentField] = 'ASC';
            }
            $orderBy['NutritionCombine.id'] = 'ASC';

            $rows = $query
                ->order($orderBy)
                ->limit(300)
                ->all();

            if ($mode === 'menu') {
                $grouped = [];

                foreach ($rows as $row) {
                    $name = trim((string)($row->name ?? ''));
                    if ($name === '') {
                        continue;
                    }

                    if (!isset($grouped[$name])) {
                        $grouped[$name] = [
                            'id' => (int)($row->id ?? 0),
                            'code' => trim((string)($row->code ?? '')),
                            'name' => $name,
                            'description' => trim((string)($row->description ?? '')),
                            'nutrition_content' => '',
                            'nutritional_value' => '',
                            'content_unit' => '',
                            'energy' => 0,
                            'protein' => 0,
                            'fat' => 0,
                            'carbohydrate' => 0,
                            'mode' => $mode,
                        ];
                    }

                    $content = !empty($contentField) ? strtolower(trim((string)($row->{$contentField} ?? ''))) : '';
                    $value = !empty($valueField) ? (float)($row->{$valueField} ?? 0) : 0;

                    if (strpos($content, 'energi') !== false || strpos($content, 'energy') !== false) {
                        $grouped[$name]['energy'] = $value;
                    } elseif (strpos($content, 'protein') !== false) {
                        $grouped[$name]['protein'] = $value;
                    } elseif (strpos($content, 'lemak') !== false || strpos($content, 'fat') !== false) {
                        $grouped[$name]['fat'] = $value;
                    } elseif (strpos($content, 'karbo') !== false || strpos($content, 'carbo') !== false) {
                        $grouped[$name]['carbohydrate'] = $value;
                    }
                }

                $results = array_values($grouped);
            } else {
                foreach ($rows as $row) {
                    $results[] = [
                        'id' => (int)($row->id ?? 0),
                        'code' => trim((string)($row->code ?? '')),
                        'name' => trim((string)($row->name ?? '')),
                        'description' => trim((string)($row->description ?? '')),
                        'nutrition_content' => !empty($contentField) ? trim((string)($row->{$contentField} ?? '')) : '',
                        'nutritional_value' => !empty($valueField) ? (string)($row->{$valueField} ?? '') : '',
                        'content_unit' => !empty($unitField) ? trim((string)($row->{$unitField} ?? '')) : '',
                        'mode' => $mode,
                    ];
                }
            }
        } catch (\Throwable $e) {
            $results = [];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }


    public function cariJenisMcu()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $results = [];

        $query = $this->MasterMcuTypes->find()
            ->where([
                'MasterMcuTypes.is_active' => 1,
                'MasterMcuTypes.is_delete' => 0,
            ]);

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'MasterMcuTypes.code LIKE' => '%' . $q . '%',
                    'MasterMcuTypes.name LIKE' => '%' . $q . '%',
                    'MasterMcuTypes.description LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        $rows = $query
            ->order(['MasterMcuTypes.name' => 'ASC'])
            ->limit(100)
            ->all();

        foreach ($rows as $row) {
            $results[] = [
                'id' => (int)$row->id,
                'kode' => $row->code ?? '',
                'nama' => $row->name ?? '',
                'description' => $row->description ?? '',
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }

    public function cariJenisOperasi()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $results = [];

        if (strlen($q) >= 1) {
            $rows = $this->MasterOperationTypes->find()
                ->where([
                    'OR' => [
                        'MasterOperationTypes.code LIKE' => '%' . $q . '%',
                        'MasterOperationTypes.name LIKE' => '%' . $q . '%',
                        'MasterOperationTypes.category LIKE' => '%' . $q . '%',
                    ],
                    'MasterOperationTypes.is_active' => 1,
                ])
                ->order(['MasterOperationTypes.name' => 'ASC'])
                ->limit(100)
                ->all();

            foreach ($rows as $row) {
                $jasaRs = (float)($row->jasa_rs ?? 0);
                $jasaDr = (float)($row->jasa_dr ?? 0);
                $jasaParamedis = (float)($row->jasa_paramedis ?? 0);
                $tariff = (float)($row->tariff ?? 0);

                if ($tariff <= 0) {
                    $tariff = $jasaRs + $jasaDr + $jasaParamedis;
                }

                $results[] = [
                    'id' => $row->id,
                    'kode' => $row->code ?? '',
                    'nama' => $row->name ?? '',
                    'kategori' => $row->category ?? '',
                    'jasa_rs' => $jasaRs,
                    'jasa_dr' => $jasaDr,
                    'jasa_paramedis' => $jasaParamedis,
                    'tarif' => $tariff,
                    'unit' => $row->unit ?? '',
                ];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($results, JSON_UNESCAPED_UNICODE));
    }

    private function cleanMoney($value): float
    {
        $value = str_replace(['Rp', ' ', '.'], ['', '', ''], (string)$value);
        $value = str_replace(',', '.', $value);

        return (float)$value;
    }

    private function generateOrderNumber(): string
    {
        $prefix = 'ORD' . date('Ymd');

        $lastOrder = $this->Orders->find()
            ->select(['id'])
            ->order(['Orders.id' => 'DESC'])
            ->first();

        $next = $lastOrder ? ((int)$lastOrder->id + 1) : 1;

        return $prefix . str_pad((string)$next, 6, '0', STR_PAD_LEFT);
    }
}