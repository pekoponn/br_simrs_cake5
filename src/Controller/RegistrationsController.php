<?php

declare(strict_types=1);

namespace App\Controller;

class RegistrationsController extends AppController
{
    public function index()
    {
        $q              = $this->request->getQuery('q');
        $filterStatus   = $this->request->getQuery('status');
        $filterSvc      = $this->request->getQuery('service_type');
        $filterPay      = $this->request->getQuery('payment_method');
        $filterDate     = $this->request->getQuery('date');

        $conditions = [];

        if (!empty($q)) {
            $conditions['OR'] = [
                'Registrations.registration_no LIKE' => '%' . $q . '%',
                'Patients.full_name LIKE' => '%' . $q . '%',
            ];
        }

        if (!empty($filterStatus)) {
            if ($filterStatus === 'aktif') {
                $conditions['OR'] = [
                    ['Registrations.status' => 'aktif'],
                    ['Registrations.status' => ''],
                    ['Registrations.status IS' => null],
                ];
            } else {
                $conditions['Registrations.status'] = $filterStatus;
            }
        }

        if (!empty($filterSvc)) {
            $conditions['Registrations.service_type'] = $filterSvc;
        }

        if (!empty($filterPay)) {
            $conditions['Registrations.payment_method'] = $filterPay;
        }

        if (!empty($filterDate)) {
            $conditions['Registrations.registration_date'] = $filterDate;
        }

        $this->paginate = [
            'contain' => ['Patients', 'Doctors', 'Rooms', 'Beds', 'PolyclinicQueues'],
            'conditions' => $conditions,
            'order' => ['Registrations.id' => 'DESC'],
            'limit' => 25,
        ];

        $registrations = $this->paginate($this->Registrations);

        $this->set(compact('registrations'));
    }

    public function getSummary()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $base = $this->Registrations->find();

        $aktifQuery = (clone $base)->where([
            'OR' => [
                ['Registrations.status' => 'aktif'],
                ['Registrations.status' => ''],
                ['Registrations.status IS' => null],
            ]
        ]);

        $summary = [
            'aktif' => $aktifQuery->count(),
            'rawat_jalan' => (clone $base)->where(['service_type' => 'rawat_jalan'])->count(),
            'igd' => (clone $base)->where(['service_type' => 'igd'])->count(),
            'rawat_inap' => (clone $base)->where(['service_type' => 'rawat_inap'])->count(),
            'total' => (clone $base)->count(),
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($summary));
    }

    public function view($id = null)
    {
        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients', 'Doctors', 'Rooms', 'Beds', 'PersonResponsibles', 'PolyclinicQueues'],
        ]);

        $this->set(compact('registration'));
    }

    public function add()
    {
        $registration = $this->Registrations->newEmptyEntity();

        $fromQueue = false;
        $queueId = $this->request->getQuery('queue_id');
        $queueNumber = $this->request->getQuery('queue_number');
        $queueCode = $this->request->getQuery('queue_code');

        $polyclinicName = $this->request->getQuery('polyclinic_name');
        $queuePatientName = '';
        $queuePhoneNumber = '';
        $queueIdentityNumber = '';
        $queueBpjsNumber = '';
        $queueSource = '';

        if (empty($polyclinicName)) {
            $polyclinicName = $this->request->getQuery('poly_name');
        }

        $queue = null;

        if (!empty($queueId)) {
            $this->loadModel('PolyclinicQueues');
            $queue = $this->PolyclinicQueues->find()
                ->where(['PolyclinicQueues.id' => (int)$queueId])
                ->first();

            if ($queue) {
                $queueNumber = $queue->queue_number;
                $queueCode = $queue->code;
                $polyclinicName = $queue->poly_name;
                $queuePatientName = $queue->patients_name ?? '';
                $queuePhoneNumber = $queue->no_telp ?? '';
                $queueIdentityNumber = $queue->identity_number ?? '';
                $queueBpjsNumber = $queue->bpjs_number ?? '';
                $queueSource = $queue->source ?? '';
            }

            $fromQueue = true;
        }

        $today = date('Ymd');
        $prefix = 'REG-' . $today . '-';

        $lastReg = $this->Registrations->find()
            ->where(['registration_no LIKE' => $prefix . '%'])
            ->order(['id' => 'DESC'])
            ->first();

        $lastSeq = $lastReg
            ? (int)substr($lastReg->registration_no, strlen($prefix))
            : 0;

        $registrationNo = $prefix . str_pad((string)($lastSeq + 1), 4, '0', STR_PAD_LEFT);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['polyclinic_name']) && !empty($data['poly_name'])) {
                $data['polyclinic_name'] = $data['poly_name'];
            }

            if (empty($data['polyclinic_name']) && !empty($polyclinicName)) {
                $data['polyclinic_name'] = $polyclinicName;
            }

            $queue = null;
            if (!empty($data['polyclinic_queue_id'])) {
                $this->loadModel('PolyclinicQueues');
                $queue = $this->PolyclinicQueues->find()
                    ->where(['PolyclinicQueues.id' => (int)$data['polyclinic_queue_id']])
                    ->first();

                if (!$queue) {
                    $this->Flash->error(__('Data antrian tidak ditemukan.'));
                    return $this->redirect(['controller' => 'PolyclinicQueues', 'action' => 'index']);
                }

                if ($queue->is_active !== 'Y') {
                    $this->Flash->error(__('Antrian ini sudah diproses atau tidak aktif.'));
                    return $this->redirect(['controller' => 'PolyclinicQueues', 'action' => 'index']);
                }

                $data['polyclinic_queue_id'] = (int)$queue->id;
                $data['queue_number'] = $queue->queue_number;
                $data['polyclinic_name'] = $queue->poly_name;
            }

            $this->loadModel('Patients');

            $patientFields = [
                'title',
                'medical_record_no',
                'full_name',
                'identity_type',
                'identity_number',
                'gender',
                'blood_type',
                'birth_date',
                'age',
                'address',
                'father_name',
                'mother_name',
                'phone_number',
                'nationality',
                'citizenship',
                'province',
                'city',
                'district',
                'subdistrict',
                'id_prov',
                'id_kab',
                'id_kec',
                'id_kel',
                'occupation',
                'religion',
                'education',
                'ethnic_group',
                'marital_status',
            ];

            $patientSchema = $this->Patients->getSchema();
            $data['patient'] = $this->normalizePatientRegionNames($data['patient'] ?? []);

            if (!empty($data['patient_id'])) {
                $patient = $this->Patients->get((int)$data['patient_id']);

                foreach ($patientFields as $field) {
                    if (
                        $patientSchema->hasColumn($field) &&
                        empty($patient->{$field}) &&
                        !empty($data['patient'][$field])
                    ) {
                        $patient->{$field} = $data['patient'][$field];
                    }
                }

                if (!$this->Patients->save($patient)) {
                    $this->Flash->error(__('Gagal memperbarui data pasien lama.'));
                    return $this->redirect(['action' => 'add']);
                }
            } else {
                if (empty($data['patient']['full_name'])) {
                    $this->Flash->error(__('Pasien belum dipilih atau nama pasien baru belum diisi.'));
                    return $this->redirect(['action' => 'add']);
                }

                $patientData = [];

                foreach ($patientFields as $field) {
                    if ($patientSchema->hasColumn($field)) {
                        $patientData[$field] = $data['patient'][$field] ?? null;
                    }
                }

                $title = trim($data['patient_title'] ?? '');
                $fullName = trim($data['patient']['full_name']);
                if ($patientSchema->hasColumn('title')) {
                    $patientData['title'] = $title;
                }
                $patientData['full_name'] = $title !== '' ? $title . ' ' . $fullName : $fullName;

                if (!empty($data['patient']['identity_number'])) {
                    $existing = $this->Patients->find()
                        ->where(['identity_number' => $data['patient']['identity_number']])
                        ->first();

                    if ($existing) {
                        $this->Flash->error(__('No identitas sudah terdaftar. Silakan cari pasien melalui tombol Cari.'));
                        return $this->redirect(['action' => 'add']);
                    }
                }

                $patientData['code'] = $this->Patients->generateCode();
                if ($patientSchema->hasColumn('medical_record_no') && empty($patientData['medical_record_no'])) {
                    $patientData['medical_record_no'] = $this->Patients->generateMedicalRecordNo();
                }

                $patient = $this->Patients->newEmptyEntity();
                $patient = $this->Patients->patchEntity($patient, $patientData);

                if (!$this->Patients->save($patient)) {
                    $err = json_encode($patient->getErrors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    $this->Flash->error(__('Data pasien baru gagal disimpan. Error: ' . $err));
                    return $this->redirect(['action' => 'add']);
                }

                $data['patient_id'] = $patient->id;
            }

            if (!empty($data['person_responsible']['name'])) {
                $this->loadModel('PersonResponsibles');

                $personResponsible = $this->PersonResponsibles->newEmptyEntity();
                $personResponsible = $this->PersonResponsibles->patchEntity(
                    $personResponsible,
                    $data['person_responsible']
                );

                if ($this->PersonResponsibles->save($personResponsible)) {
                    $data['person_responsible_id'] = $personResponsible->id;
                } else {
                    $this->Flash->error(__('Data penanggung jawab gagal disimpan.'));
                    return $this->redirect(['action' => 'add']);
                }
            }

            $nullableFields = [
                'room_id',
                'bed_id',
                'person_responsible_id',
                'doctor_id',
                'doctor_schedule_id',
                'polyclinic_queue_id',
                'queue_number',
                'polyclinic_name',
                'class_name',
                'insurance_type',
                'insurance_card_no',
                'insurance_category',
                'refferal_no',
                'sep_no',
                'skdp_no',
                'reference_type',
                'bpjs_nik',
                'bpjs_name',
                'bpjs_group',
                'bpjs_type',
                'bpjs_class',
                'provider',
                'entry_process',
                'entry_method',
                'referral_type',
                'referral_doctor',
                'referral_origin',
                'referral_name',
            ];

            foreach ($nullableFields as $field) {
                if (isset($data[$field]) && $data[$field] === '') {
                    $data[$field] = null;
                }
            }

            $integerFields = [
                'patient_id',
                'room_id',
                'bed_id',
                'person_responsible_id',
                'doctor_id',
                'doctor_schedule_id',
                'polyclinic_queue_id',
            ];

            foreach ($integerFields as $field) {
                if (!empty($data[$field])) {
                    $data[$field] = (int)$data[$field];
                }
            }

            unset(
                $data['patient'],
                $data['patient_title'],
                $data['person_responsible'],
                $data['poly_name']
            );

            if (empty($data['status'])) {
                $data['status'] = 'aktif';
            }

            $registration = $this->Registrations->patchEntity($registration, $data);

            $queueErrors = [];
            $saved = $this->Registrations->getConnection()->transactional(function () use (&$registration, $queue, &$queueErrors, $data) {
                if (!$this->Registrations->save($registration)) {
                    return false;
                }

                if ($queue) {
                    $queue->is_active = 'N';
                    $queue->is_update = 1;

                    if (!$this->PolyclinicQueues->save($queue)) {
                        $queueErrors = $queue->getErrors();

                        return false;
                    }
                }

                if (
                    ($data['service_type'] ?? '') === 'rawat_inap'
                    && !empty($data['bed_id'])
                    && !empty($data['patient_id'])
                ) {
                    $this->_updateBedOccupied(
                        (int)$data['bed_id'],
                        (int)$data['patient_id'],
                        $registration->registration_no
                    );
                }

                return true;
            });

            if ($saved) {
                $this->Flash->success(__('Data registrasi berhasil disimpan.'));
                return $this->redirect(['action' => 'index']);
            }

            $errors = $registration->getErrors();
            $errorDetail = json_encode(!empty($errors) ? $errors : $queueErrors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $this->Flash->error(__('Data registrasi gagal disimpan. Error: ' . $errorDetail));
        }

        $this->loadModel('DaerahProvinsis');

        $provinces = $this->DaerahProvinsis->find()
            ->select(['id_prov', 'nama'])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $doctors = $this->Registrations->Doctors->find('list', [
            'keyField' => 'id',
            'valueField' => 'doctor_name',
        ])->limit(200)->all()->toArray();

        $rooms = $this->Registrations->Rooms->find('list', [
            'keyField' => 'id',
            'valueField' => 'room_name',
        ])->order(['Rooms.room_name' => 'ASC'])->limit(200)->all()->toArray();

        $beds = $this->Registrations->Beds->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->where(['Beds.status' => 0])->limit(200)->all()->toArray();

        $this->set(compact(
            'registration',
            'doctors',
            'rooms',
            'beds',
            'provinces',
            'registrationNo',
            'fromQueue',
            'queueId',
            'queueNumber',
            'queueCode',
            'polyclinicName',
            'queuePatientName',
            'queuePhoneNumber',
            'queueIdentityNumber',
            'queueBpjsNumber',
            'queueSource'
        ));
    }

    public function edit($id = null)
    {
        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $oldBedId = !empty($registration->bed_id) ? (int)$registration->bed_id : null;
            $oldServiceType = $registration->service_type;

            if (empty($data['polyclinic_name']) && !empty($data['poly_name'])) {
                $data['polyclinic_name'] = $data['poly_name'];
            }

            $nullableFields = [
                'room_id',
                'bed_id',
                'person_responsible_id',
                'doctor_id',
                'doctor_schedule_id',
                'queue_number',
                'polyclinic_name',
                'class_name',
                'insurance_type',
                'insurance_card_no',
                'insurance_category',
                'refferal_no',
                'sep_no',
                'skdp_no',
                'reference_type',
                'bpjs_nik',
                'bpjs_name',
                'bpjs_group',
                'bpjs_type',
                'bpjs_class',
                'provider',
                'entry_process',
                'entry_method',
                'referral_type',
                'referral_doctor',
                'referral_origin',
                'referral_name',
            ];

            foreach ($nullableFields as $field) {
                if (isset($data[$field]) && $data[$field] === '') {
                    $data[$field] = null;
                }
            }

            $integerFields = [
                'patient_id',
                'room_id',
                'bed_id',
                'person_responsible_id',
                'doctor_id',
                'doctor_schedule_id',
            ];

            foreach ($integerFields as $field) {
                if (!empty($data[$field])) {
                    $data[$field] = (int)$data[$field];
                }
            }

            unset(
                $data['polyclinic_queue_id'],
                $data['poly_name']
            );

            $newBedId = !empty($data['bed_id']) ? (int)$data['bed_id'] : null;
            $newServiceType = $data['service_type'] ?? '';
            $patientId = !empty($data['patient_id'])
                ? (int)$data['patient_id']
                : (int)$registration->patient_id;

            $registration = $this->Registrations->patchEntity($registration, $data);

            if ($this->Registrations->save($registration)) {
                $wasRawatInap = $oldServiceType === 'rawat_inap';
                $isRawatInap = $newServiceType === 'rawat_inap';

                if ($wasRawatInap && !empty($oldBedId)) {
                    if (!$isRawatInap) {
                        $this->_releaseBed((int)$oldBedId, $registration->registration_no);
                    } elseif ($oldBedId !== $newBedId) {
                        $this->_releaseBed((int)$oldBedId, $registration->registration_no);
                        if (!empty($newBedId)) {
                            $this->_updateBedOccupied(
                                (int)$newBedId,
                                $patientId,
                                $registration->registration_no
                            );
                        }
                    }
                } elseif ($isRawatInap && !empty($newBedId)) {
                    $this->_updateBedOccupied(
                        (int)$newBedId,
                        $patientId,
                        $registration->registration_no
                    );
                }

                $this->Flash->success(__('Data registrasi berhasil diubah.'));
                return $this->redirect(['action' => 'index']);
            }

            $errors = $registration->getErrors();
            $errorDetail = json_encode($errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $this->Flash->error(__('Data registrasi gagal diubah. Error: ' . $errorDetail));
        }

        $patients = $this->Registrations->Patients->find('list', [
            'limit' => 200,
        ])->all()->toArray();

        $doctors = $this->Registrations->Doctors->find('list', [
            'keyField' => 'id',
            'valueField' => 'doctor_name',
        ])->limit(200)->all()->toArray();

        $rooms = $this->Registrations->Rooms->find('list', [
            'keyField' => 'id',
            'valueField' => 'room_name',
        ])->order(['Rooms.room_name' => 'ASC'])->limit(200)->all()->toArray();

        $currentBedId = $registration->bed_id;

        $bedQuery = $this->Registrations->Beds->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->limit(200);

        if ($currentBedId) {
            $bedQuery->where([
                'OR' => [
                    ['Beds.status' => 0],
                    ['Beds.id' => $currentBedId],
                ],
            ]);
        } else {
            $bedQuery->where(['Beds.status' => 0]);
        }

        $beds = $bedQuery->all()->toArray();

        $this->set(compact(
            'registration',
            'patients',
            'doctors',
            'rooms',
            'beds'
        ));
    }

    protected function _updateBedOccupied(int $bedId, int $patientId, string $registrationNo): void
    {
        $this->loadModel('Beds');
        $this->loadModel('Patients');

        try {
            $bed = $this->Beds->get($bedId);
            $patient = $this->Patients->get($patientId, ['fields' => ['id', 'full_name', 'code']]);
        } catch (\Throwable $e) {
            return;
        }

        $statusBefore = (int)$bed->status;
        $now = date('Y-m-d H:i:s');

        $bed->status = 1;
        $bed->patient_id = $patientId;
        $bed->patient_name = $patient->full_name;
        $bed->check_in_date = $now;
        $bed->check_out_date = null;
        $bed->notes = 'Pasien ' . $patient->full_name
            . ' (No. Reg: ' . $registrationNo . ')'
            . ' masuk ' . date('d-m-Y H:i');

        if (!$this->Beds->save($bed)) {
            return;
        }

        if ($statusBefore !== 1) {
            $this->saveBedHistoryFromRegistration($bed, [
                'registration_no' => $registrationNo,
                'status_before' => $statusBefore,
                'status_after' => 1,
                'patient_name' => $patient->full_name,
                'check_in_date' => $now,
                'check_out_date' => null,
                'notes' => 'Otomatis terisi dari registrasi ' . $registrationNo,
            ]);
        }
    }

    protected function _releaseBed(int $bedId, string $registrationNo): void
    {
        $this->loadModel('Beds');

        try {
            $bed = $this->Beds->get($bedId);
        } catch (\Throwable $e) {
            return;
        }

        $statusBefore = (int)$bed->status;
        $patientNameBefore = $bed->patient_name ?? null;
        $checkInBefore = $bed->check_in_date ?? null;
        $now = date('Y-m-d H:i:s');

        $bed->status = 0;
        $bed->patient_id = null;
        $bed->patient_name = null;
        $bed->check_out_date = $now;
        $bed->notes = ($patientNameBefore ? 'Pasien ' . $patientNameBefore . ' keluar' : 'Pasien keluar')
            . ' (No. Reg: ' . $registrationNo . ')'
            . ' ' . date('d-m-Y H:i');

        if (!$this->Beds->save($bed)) {
            return;
        }

        if ($statusBefore !== 0) {
            $this->saveBedHistoryFromRegistration($bed, [
                'registration_no' => $registrationNo,
                'status_before' => $statusBefore,
                'status_after' => 0,
                'patient_name' => $patientNameBefore,
                'check_in_date' => $checkInBefore,
                'check_out_date' => $now,
                'notes' => 'Otomatis dilepas dari registrasi ' . $registrationNo,
            ]);
        }
    }

    private function saveBedHistoryFromRegistration($bed, array $data): void
    {
        try {
            $this->loadModel('BedHistories');
            $history = $this->BedHistories->newEmptyEntity();
            $history->bed_id = $bed->id;
            $history->room_id = $bed->room_id;
            $history->registration_no = $data['registration_no'] ?? null;
            $history->status_before = $data['status_before'] ?? null;
            $history->status_after = $data['status_after'] ?? null;
            $history->patient_name = $data['patient_name'] ?? null;
            $history->check_in_date = $data['check_in_date'] ?? null;
            $history->check_out_date = $data['check_out_date'] ?? null;
            $history->notes = $data['notes'] ?? null;
            $history->created_by = 'system';

            $this->BedHistories->save($history);
        } catch (\Throwable $e) {
            return;
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $registration = $this->Registrations->get($id);

        if (
            $registration->service_type === 'rawat_inap'
            && !empty($registration->bed_id)
        ) {
            $this->_releaseBed(
                (int)$registration->bed_id,
                $registration->registration_no
            );
        }

        if ($this->Registrations->delete($registration)) {
            $this->Flash->success(__('Data registrasi berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Data registrasi gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function normalizePatientRegionNames(array $patientData): array
    {
        $regionFields = [
            'id_prov' => ['model' => 'DaerahProvinsis', 'key' => 'id_prov'],
            'id_kab' => ['model' => 'DaerahKabupatens', 'key' => 'id_kab'],
            'id_kec' => ['model' => 'DaerahKecamatans', 'key' => 'id_kec'],
            'id_kel' => ['model' => 'DaerahKelurahans', 'key' => 'id_kel'],
        ];

        foreach ($regionFields as $field => $config) {
            if (empty($patientData[$field]) || !is_numeric($patientData[$field])) {
                continue;
            }

            $this->loadModel($config['model']);
            $region = $this->{$config['model']}->find()
                ->select(['nama'])
                ->where([$config['key'] => (string)$patientData[$field]])
                ->enableHydration(false)
                ->first();

            if (!empty($region['nama'])) {
                $patientData[$field] = $region['nama'];
            }
        }

        return $patientData;
    }

    public function searchPatients()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $keyword = $this->request->getQuery('q');

        $this->loadModel('Patients');

        $patients = [];

        if (!empty($keyword)) {
            $schema = $this->Patients->getSchema();

            $selectFields = [
                'id',
                'code',
                'title',
                'full_name',
                'identity_type',
                'identity_number',
                'gender',
                'blood_type',
                'birth_date',
                'address',
                'father_name',
                'mother_name',
                'phone_number',
                'nationality',
                'citizenship',
                'occupation',
                'religion',
                'education',
                'ethnic_group',
                'marital_status',
            ];

            if ($schema->hasColumn('medical_record_no')) {
                $selectFields[] = 'medical_record_no';
            }

            $optionalFields = [
                'province',
                'city',
                'district',
                'subdistrict',
                'id_prov',
                'id_kab',
                'id_kec',
                'id_kel',
            ];

            foreach ($optionalFields as $field) {
                if ($schema->hasColumn($field)) {
                    $selectFields[] = $field;
                }
            }

            $searchConditions = [
                'Patients.code LIKE' => '%' . $keyword . '%',
                'Patients.identity_number LIKE' => '%' . $keyword . '%',
                'Patients.full_name LIKE' => '%' . $keyword . '%',
            ];

            if ($schema->hasColumn('medical_record_no')) {
                $searchConditions[] = ['Patients.medical_record_no LIKE' => '%' . $keyword . '%'];
            }

            $patients = $this->Patients->find()
                ->select($selectFields)
                ->where([
                    'OR' => $searchConditions,
                ])
                ->limit(10)
                ->enableHydration(false)
                ->toArray();

            if (!empty($patients)) {
                $regionFields = [
                    'id_prov' => ['model' => 'DaerahProvinsis', 'key' => 'id_prov'],
                    'id_kab' => ['model' => 'DaerahKabupatens', 'key' => 'id_kab'],
                    'id_kec' => ['model' => 'DaerahKecamatans', 'key' => 'id_kec'],
                    'id_kel' => ['model' => 'DaerahKelurahans', 'key' => 'id_kel'],
                ];

                foreach ($regionFields as $field => $config) {
                    if (!in_array($field, $selectFields, true)) {
                        continue;
                    }

                    $ids = array_values(array_unique(array_filter(array_map(
                        static function ($patient) use ($field) {
                            $value = $patient[$field] ?? null;

                            return is_numeric($value) ? (string)$value : null;
                        },
                        $patients
                    ))));

                    if (empty($ids)) {
                        continue;
                    }

                    $this->loadModel($config['model']);
                    $map = $this->{$config['model']}->find()
                        ->select([$config['key'], 'nama'])
                        ->where([$config['key'] . ' IN' => $ids])
                        ->enableHydration(false)
                        ->all()
                        ->combine($config['key'], 'nama')
                        ->toArray();

                    foreach ($patients as &$patient) {
                        $value = $patient[$field] ?? null;

                        if (is_numeric($value) && isset($map[(string)$value])) {
                            $patient[$field] = $map[(string)$value];
                        }
                    }
                    unset($patient);
                }
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($patients));
    }

    public function getKabupatens()
    {
        $this->request->allowMethod(['get']);

        $idProv = $this->request->getQuery('id_prov');

        $this->loadModel('DaerahKabupatens');

        $kabupatens = $this->DaerahKabupatens->find()
            ->select(['id_kab', 'nama'])
            ->where(['id_prov' => $idProv])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($kabupatens));
    }

    public function getKecamatans()
    {
        $this->request->allowMethod(['get']);

        $idKab = $this->request->getQuery('id_kab');

        $this->loadModel('DaerahKecamatans');

        $kecamatans = $this->DaerahKecamatans->find()
            ->select(['id_kec', 'nama'])
            ->where(['id_kab' => $idKab])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($kecamatans));
    }

    public function getKelurahans()
    {
        $this->request->allowMethod(['get']);

        $idKec = $this->request->getQuery('id_kec');

        $this->loadModel('DaerahKelurahans');

        $kelurahans = $this->DaerahKelurahans->find()
            ->select(['id_kel', 'nama'])
            ->where(['id_kec' => $idKec])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($kelurahans));
    }

    public function getBedClass()
    {
        $this->request->allowMethod(['get']);

        $bedId = $this->request->getQuery('bed_id');

        $bed = $this->Registrations->Beds->find()
            ->select(['id', 'class_name'])
            ->where(['id' => $bedId])
            ->first();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(
                json_encode($bed ? $bed->toArray() : ['class_name' => ''])
            );
    }

    public function getAvailableBeds()
    {
        $this->request->allowMethod(['get']);

        $roomId = $this->request->getQuery('room_id');

        $query = $this->Registrations->Beds->find()
            ->select(['id', 'bed_no', 'name', 'class_name', 'status'])
            ->where(['Beds.status' => 0])
            ->order(['Beds.name' => 'ASC'])
            ->enableHydration(false);

        if (!empty($roomId)) {
            $query->andWhere(['Beds.room_id' => (int)$roomId]);
        }

        $beds = $query->limit(200)->toArray();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($beds));
    }

    public function getDoctorSchedules()
    {
        $this->request->allowMethod(['get']);

        $doctorId = $this->request->getQuery('doctor_id');

        $this->loadModel('DoctorSchedules');

        $schedules = $this->DoctorSchedules->find()
            ->select([
                'id',
                'code',
                'day',
                'start_time',
                'end_time',
                'quota',
                'is_active',
            ])
            ->where([
                'DoctorSchedules.doctor_id' => $doctorId,
                'DoctorSchedules.is_active' => 'Y',
            ])
            ->order(['DoctorSchedules.day' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        foreach ($schedules as &$schedule) {
            $schedule['start_time'] = !empty($schedule['start_time'])
                ? (is_object($schedule['start_time']) ? $schedule['start_time']->format('H:i') : substr((string)$schedule['start_time'], 0, 5))
                : '';
            $schedule['end_time'] = !empty($schedule['end_time'])
                ? (is_object($schedule['end_time']) ? $schedule['end_time']->format('H:i') : substr((string)$schedule['end_time'], 0, 5))
                : '';
        }
        unset($schedule);

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($schedules));
    }
}
