<?php

declare(strict_types=1);

namespace App\Controller;

class RegistrationsController extends AppController
{
    protected array $lastOutpatientVisitErrors = [];

    public function index()
{
    $q            = $this->request->getQuery('q');
    $filterStatus = $this->request->getQuery('status');
    $filterSvc    = $this->request->getQuery('service_type');
    $filterPay    = $this->request->getQuery('payment_method');
    $filterDateFrom = $this->request->getQuery('date_from');
$filterDateTo   = $this->request->getQuery('date_to');

if (empty($filterDateFrom) && empty($filterDateTo)) {
    // Default: tampilkan hari ini saja
    $filterDateFrom = date('Y-m-d');
    $filterDateTo   = date('Y-m-d');
} elseif (empty($filterDateFrom)) {
    $filterDateFrom = $filterDateTo;
} elseif (empty($filterDateTo)) {
    $filterDateTo = $filterDateFrom;
}

$conditions['DATE(Registrations.registration_date) >='] = $filterDateFrom;
$conditions['DATE(Registrations.registration_date) <='] = $filterDateTo;

    $this->paginate = [
        'contain' => [
            'Patients',
            'Doctors',
            'Rooms',
            'Beds',
        ],
        'conditions' => $conditions,
        'order' => [
            'Registrations.id' => 'DESC'
        ],
        'limit' => 25,
    ];

    $registrations = $this->paginate($this->Registrations);

    $this->set(compact('registrations'));
}

    public function getSummary()
{
    $this->request->allowMethod(['get']);
    $this->autoRender = false;

    $filterDateFrom = $this->request->getQuery('date_from');
    $filterDateTo   = $this->request->getQuery('date_to');

    if (empty($filterDateFrom) && empty($filterDateTo)) {
        $filterDateFrom = date('Y-m-d');
        $filterDateTo   = date('Y-m-d');
    } elseif (empty($filterDateFrom)) {
        $filterDateFrom = $filterDateTo;
    } elseif (empty($filterDateTo)) {
        $filterDateTo = $filterDateFrom;
    }

    $base = $this->Registrations->find()->where([
        'DATE(Registrations.registration_date) >=' => $filterDateFrom,
        'DATE(Registrations.registration_date) <=' => $filterDateTo,
    ]);

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
            'contain' => ['Patients', 'Doctors', 'Rooms', 'Beds', 'PersonResponsibles'],
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
    $queuePatientId = null;
    $queuePatientData = [];

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
            $queueNumber = $queue->queue_number ?? ($queue->queue_no ?? '');
            $queueCode = $queue->code;
            $polyclinicName = $queue->poly_name;
            $queuePatientName = $queue->patients_name ?? '';
            $queuePhoneNumber = $queue->no_telp ?? '';
            $queueIdentityNumber = $queue->identity_number ?? '';
            $queueBpjsNumber = $queue->bpjs_number ?? '';
            $queueSource = $queue->source ?? '';

            if ($this->PolyclinicQueues->getSchema()->hasColumn('patient_id') && !empty($queue->patient_id)) {
                $queuePatientId = (int)$queue->patient_id;

                $this->loadModel('Patients');
                $patientSchema = $this->Patients->getSchema();
                $queuePatientFields = [
                    'id',
                    'code',
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

                foreach (['title', 'province', 'city', 'district', 'subdistrict', 'id_prov', 'id_kab', 'id_kec', 'id_kel'] as $optionalField) {
                    if ($patientSchema->hasColumn($optionalField)) {
                        $queuePatientFields[] = $optionalField;
                    }
                }

                $queuePatient = $this->Patients->find()
                    ->select(array_values(array_unique($queuePatientFields)))
                    ->where(['Patients.id' => $queuePatientId])
                    ->first();

                if ($queuePatient) {
                    $queuePatientName = $queuePatient->full_name ?: $queuePatientName;
                    $queuePhoneNumber = $queuePatient->phone_number ?: $queuePhoneNumber;
                    $queueIdentityNumber = $queuePatient->identity_number ?: $queueIdentityNumber;

                    foreach (array_values(array_unique($queuePatientFields)) as $field) {
                        $value = $queuePatient->{$field} ?? '';
                        $queuePatientData[$field] = is_object($value) && method_exists($value, 'format')
                            ? $value->format('Y-m-d')
                            : (string)$value;
                    }
                }
            }
        }

        $fromQueue = true;
    }

$registrationNo = $this->_generateRegistrationNo('rawat_jalan');

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        if (empty($data['registration_date'])) {
    $data['registration_date'] = date('Y-m-d');
        } else {
            $tmpRegDate = strtotime((string)$data['registration_date']);
            if ($tmpRegDate) {
                $data['registration_date'] = date('Y-m-d', $tmpRegDate);
            }
        }
        if (empty($data['service_type'])) {
            $data['service_type'] = 'rawat_jalan';
        }

        // Nomor registrasi SELALU dihitung ulang di server sesuai jenis pelayanan
        // yang dipilih, supaya kodenya (RJ/IGD/RI) pasti benar walau field
        // registration_no di form telat ter-update oleh JS.
        $data['registration_no'] = $this->_generateRegistrationNo($data['service_type']);

        // Normalisasi Cara Bayar sesuai permintaan client:
        // hanya 4 jenis pasien: PERORANGAN, ASURANSI, PERUSAHAAN_AFILIASI, KARYAWAN.
        $allowedPaymentMethods = ['PERORANGAN', 'ASURANSI', 'PERUSAHAAN_AFILIASI', 'KARYAWAN'];
        if (!in_array(($data['payment_method'] ?? ''), $allowedPaymentMethods, true)) {
            $data['payment_method'] = null;
        }

        if (($data['payment_method'] ?? '') === 'PERORANGAN') {
            foreach ([
                'insurance_type',
                'insurance_category',
                'insurance_card_no',
                'refferal_no',
                'sep_no',
                'bpjs_nik',
                'bpjs_name',
                'bpjs_group',
                'bpjs_type',
                'bpjs_class',
                'patient_group',
                'patient_class',
                'provider'
            ] as $paymentField) {
                $data[$paymentField] = null;
            }
        }

        if (($data['treatment_type'] ?? 'BIASA') !== 'PAKET') {
            $data['package_name'] = null;
        }

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

            // Cek status antrian hanya kalau kolom is_active memang ada.
            $queueSchema = $this->PolyclinicQueues->getSchema();

            if ($queueSchema->hasColumn('is_active')) {
                $queueActive = strtoupper(trim((string)($queue->is_active ?? '')));
                if (!in_array($queueActive, ['Y', '1', 'TRUE', 'AKTIF'], true)) {
                    $this->Flash->error(__('Antrian ini sudah diproses atau tidak aktif. Status antrian: ' . ($queue->is_active ?? '-')));
                    goto renderRegistrationAddForm;
                }
            }

            $data['polyclinic_queue_id'] = (int)$queue->id;
            $data['queue_number'] = $queue->queue_number ?? ($queue->queue_no ?? ($data['queue_number'] ?? null));
            $data['polyclinic_name'] = $queue->poly_name ?? ($queue->polyclinic_name ?? ($data['polyclinic_name'] ?? null));

            if (empty($data['room_name'])) {
                foreach (['room_name', 'room', 'unit_name', 'service_room'] as $queueRoomField) {
                    if ($queueSchema->hasColumn($queueRoomField) && !empty($queue->{$queueRoomField})) {
                        $data['room_name'] = $queue->{$queueRoomField};
                        break;
                    }
                }
            }
        }

        // ============================================================
        // Pasien baru cuma DISIAPKAN di sini (belum ditulis ke DB).
        // Proses simpan pasien baru ada DI DALAM transaction yang sama
        // dengan registrasi, supaya kalau ada yang gagal, semuanya
        // rollback bersama-sama (atomic), tidak ada pasien "yatim".
        // ============================================================

        $this->loadModel('Patients');

        $patientFields = [
            'title',
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

        // Simpan salinan input pasien SEBELUM $data['patient'] di-unset nanti,
        // supaya masih bisa dipakai di dalam transaction.
        $patientInputForMerge = $data['patient'];

        $isNewPatient = empty($data['patient_id']);

        if ($isNewPatient && empty($data['patient']['full_name'])) {
            $this->Flash->error(__('Pasien belum dipilih atau nama pasien baru belum diisi.'));
            goto renderRegistrationAddForm;
        }

        $patientIdentityNumber = trim((string)($data['patient']['identity_number'] ?? ''));

        // Cek duplikat No Identitas HANYA sebagai validasi cepat (tidak menulis ke DB).
        if ($isNewPatient && $patientIdentityNumber !== '') {
            $existingPatient = $this->Patients->find()
                ->where(['identity_number' => $patientIdentityNumber])
                ->first();

            if ($existingPatient) {
                $this->Flash->error(__(
                    'No identitas ' . $patientIdentityNumber . ' sudah terdaftar atas nama "'
                    . $existingPatient->full_name . '" (Kode: ' . $existingPatient->code . '). '
                    . 'Silakan cari pasien tersebut lewat tombol Cari, atau perbaiki nomor identitas kalau ini pasien yang berbeda.'
                ));
                goto renderRegistrationAddForm;
            }
        }

        // Siapkan payload pasien baru (kalau memang pasien baru). Field 'code' baru
        // di-generate & disimpan nanti DI DALAM transaction supaya benar-benar atomic.
        $newPatientData = null;

        if ($isNewPatient) {
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

            // ============================================================
            // FIX: kolom province/city/district/subdistrict wajib diisi
            // di database, tapi form cuma kirim id_prov/id_kab/id_kec/id_kel
            // (yang isinya sudah berupa NAMA wilayah, bukan angka ID).
            // Jadi salin nilainya ke kolom province/city/district/subdistrict
            // kalau kolom itu masih kosong.
            // ============================================================
            $regionNameMap = [
                'province'    => 'id_prov',
                'city'        => 'id_kab',
                'district'    => 'id_kec',
                'subdistrict' => 'id_kel',
            ];
            foreach ($regionNameMap as $nameField => $idField) {
                if (
                    $patientSchema->hasColumn($nameField) &&
                    empty($patientData[$nameField]) &&
                    !empty($data['patient'][$idField])
                ) {
                    $patientData[$nameField] = $data['patient'][$idField];
                }
            }

            // Normalisasi field kosong ('' / hanya spasi) jadi null supaya tidak bentrok
            // dengan unique index di database.
            foreach ($patientData as $pField => $pValue) {
                if (is_string($pValue) && trim($pValue) === '') {
                    $patientData[$pField] = null;
                }
            }
            $patientData['full_name'] = $title !== '' ? $title . ' ' . $fullName : $fullName;

            $newPatientData = $patientData;
        }

        // Data penanggung jawab disimpan setelah registrasi tersimpan,
        // karena tabel person_responsibles punya registration_id.
        $personResponsibleData = [];
        if (!empty($data['person_responsible']) && is_array($data['person_responsible'])) {
            foreach ($data['person_responsible'] as $key => $value) {
                if (is_string($value)) {
                    $value = trim($value);
                }
                $personResponsibleData[$key] = $value;
            }

            $hasPersonResponsible = false;
            foreach ($personResponsibleData as $value) {
                if (trim((string)$value) !== '') {
                    $hasPersonResponsible = true;
                    break;
                }
            }

            if (!$hasPersonResponsible) {
                $personResponsibleData = [];
            }
        }

        $this->syncMasterPatientReferrerFromRegistrationData($data);

        $nullableFields = [
            'room_id',
            'bed_id',
            'person_responsible_id',
            'doctor_id',
            'doctor_schedule_id',
            'polyclinic_queue_id',
            'queue_number',
            'polyclinic_name',
            'room_name',
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
            'patient_group',
            'patient_class',
            'provider',
            'package_name',
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
        $data['treatment_type'] = $data['treatment_type'] ?? 'BIASA';
        $data['is_create'] = $data['is_create'] ?? 1;
        $data['is_update'] = $data['is_update'] ?? 0;
        $data['is_delete'] = $data['is_delete'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? 'Y';

        $regSchemaBeforePatch = $this->Registrations->getSchema();

        // registrations kamu memakai kolom queue_no, sedangkan form memakai queue_number.
        if (
            $regSchemaBeforePatch->hasColumn('queue_no')
            && empty($data['queue_no'])
            && !empty($data['queue_number'])
        ) {
            $data['queue_no'] = (string)$data['queue_number'];
        }

        $registrationColumns = array_flip($regSchemaBeforePatch->columns());
        $data = array_intersect_key($data, $registrationColumns);

        $registration = $this->Registrations->patchEntity($registration, $data);
        $registration->queue_no = $data['queue_no'] ?? null;
        $registration->room_id = $data['room_id'] ?? null;
        $registration->bed_id = $data['bed_id'] ?? null;
        $registration->class_name = $data['class_name'] ?? null;
        $registration->person_responsible_id = $data['person_responsible_id'] ?? null;

        // Paksa field penting masuk ke entity walau $_accessible Entity belum lengkap.
        foreach (['queue_no', 'queue_number', 'room_name', 'polyclinic_name', 'doctor_schedule_id', 'skdp_no'] as $forceField) {
            if (array_key_exists($forceField, $data)) {
                $registration->{$forceField} = $data[$forceField];
            }
        }

        $queueErrors = [];
        $personResponsibleErrors = [];
        $patientErrors = [];

        $saved = $this->Registrations->getConnection()->transactional(function () use (
            &$registration,
            $queue,
            &$queueErrors,
            &$personResponsibleErrors,
            &$patientErrors,
            $data,
            $personResponsibleData,
            $isNewPatient,
            $newPatientData,
            $patientInputForMerge,
            $patientFields
        ) {
            // ── Simpan / update pasien DI DALAM transaction ───────────────
            if ($isNewPatient) {
                $newPatientData['code'] = $this->Patients->generateCode();
                $patient = $this->Patients->newEmptyEntity();
                $patient = $this->Patients->patchEntity($patient, $newPatientData);

                try {
                    $patientSaved = $this->Patients->save($patient);
                } catch (\Throwable $e) {
                    $this->log(
                        'Exception saat menyimpan pasien baru dari registrasi: ' . $e->getMessage(),
                        'error'
                    );
                    $patientErrors = ['_exception' => $e->getMessage()];
                    return false;
                }

                if (!$patientSaved) {
                    $patientErrors = $patient->getErrors();
                    return false;
                }

                $registration->patient_id = (int)$patient->id;
            } elseif (!empty($data['patient_id'])) {
                try {
                    $patient = $this->Patients->get((int)$data['patient_id']);
                } catch (\Throwable $e) {
                    $patientErrors = ['patient_id' => ['notFound' => 'Pasien tidak ditemukan.']];
                    return false;
                }

                $patientSchema = $this->Patients->getSchema();

                foreach ($patientFields as $field) {
                    if (
                        $patientSchema->hasColumn($field) &&
                        empty($patient->{$field}) &&
                        !empty($patientInputForMerge[$field] ?? null)
                    ) {
                        $patient->{$field} = $patientInputForMerge[$field];
                    }
                }

                // FIX yang sama: pasien lama yang belum punya province/city/district/
                // subdistrict juga dilengkapi dari id_prov/id_kab/id_kec/id_kel.
                $regionNameMapExisting = [
                    'province'    => 'id_prov',
                    'city'        => 'id_kab',
                    'district'    => 'id_kec',
                    'subdistrict' => 'id_kel',
                ];
                foreach ($regionNameMapExisting as $nameField => $idField) {
                    if (
                        $patientSchema->hasColumn($nameField) &&
                        empty($patient->{$nameField}) &&
                        !empty($patientInputForMerge[$idField] ?? null)
                    ) {
                        $patient->{$nameField} = $patientInputForMerge[$idField];
                    }
                }

                if (!$this->Patients->save($patient)) {
                    $patientErrors = $patient->getErrors();
                    return false;
                }

                $registration->patient_id = (int)$patient->id;
            }

            // ── Simpan registrasi ──────────────────────────────────────────
            if (!$this->Registrations->save($registration)) {
                return false;
            }

            // Setiap registrasi berhasil dibuat, otomatis buatkan
            // (atau pastikan sudah ada) rekam medis dengan No Rekam Medis auto-generate.

            $this->_createMedicalRecordForRegistration($registration);

            if (!empty($personResponsibleData)) {
                $this->loadModel('PersonResponsibles');
                $personSchema = $this->PersonResponsibles->getSchema();

                $personData = $personResponsibleData;
                $personData['registration_id'] = (int)$registration->id;

                if ($personSchema->hasColumn('is_create') && !isset($personData['is_create'])) {
                    $personData['is_create'] = 1;
                }
                if ($personSchema->hasColumn('is_update') && !isset($personData['is_update'])) {
                    $personData['is_update'] = 0;
                }
                if ($personSchema->hasColumn('is_delete') && !isset($personData['is_delete'])) {
                    $personData['is_delete'] = 0;
                }
                if ($personSchema->hasColumn('is_active') && empty($personData['is_active'])) {
                    $personData['is_active'] = 'Y';
                }

                $personColumns = array_flip($personSchema->columns());
                $personData = array_intersect_key($personData, $personColumns);

                $personResponsible = $this->PersonResponsibles->newEmptyEntity();
                $personResponsible = $this->PersonResponsibles->patchEntity($personResponsible, $personData);

                foreach (['registration_id', 'name', 'identity_type', 'identity_no', 'relation', 'age', 'job', 'address', 'phone'] as $forcePersonField) {
                    if (array_key_exists($forcePersonField, $personData)) {
                        $personResponsible->{$forcePersonField} = $personData[$forcePersonField];
                    }
                }

                if (!$this->PersonResponsibles->save($personResponsible)) {
                    $personResponsibleErrors = $personResponsible->getErrors();
                    return false;
                }

                if ($this->Registrations->getSchema()->hasColumn('person_responsible_id')) {
                    $registration->person_responsible_id = (int)$personResponsible->id;
                    if (!$this->Registrations->save($registration)) {
                        return false;
                    }
                }
            }

            if ($queue) {
                // Jangan gagalkan simpan registrasi hanya karena update status antrian gagal.
                $queueSchema = $this->PolyclinicQueues->getSchema();

                if ($queueSchema->hasColumn('is_active')) {
                    $isActiveType = $queueSchema->getColumnType('is_active');

                    if (in_array($isActiveType, ['boolean', 'integer', 'tinyinteger', 'smallinteger'], true)) {
                        $queue->is_active = 0;
                    } else {
                        $queue->is_active = 'N';
                    }
                }

                if ($queueSchema->hasColumn('checkin_status')) {
                    $queue->checkin_status = 'Sudah Check-in';
                }

                if ($queueSchema->hasColumn('call_status')) {
                    $queue->call_status = 'Selesai';
                }

                if ($queueSchema->hasColumn('is_update')) {
                    $queue->is_update = 1;
                }

                if (!$this->PolyclinicQueues->save($queue)) {
                    $queueErrors = $queue->getErrors();
                    $this->log('Gagal update status antrian setelah registrasi: ' . json_encode($queueErrors), 'error');
                }
            }

            if (
                ($data['service_type'] ?? '') === 'rawat_inap'
                && !empty($data['bed_id'])
                && !empty($registration->patient_id)
            ) {
                $this->_updateBedOccupied(
                    (int)$data['bed_id'],
                    (int)$registration->patient_id,
                    $registration->registration_no
                );
            }

            return true;
        });

        if ($saved) {
            if (($registration->service_type ?? '') === 'rawat_jalan') {
                try {
                    $this->_syncOutpatientVisitFromRegistration($registration);
                } catch (\Throwable $e) {
                    // Registrasi tetap berhasil. Kunjungan rawat jalan bisa diperbaiki belakangan.
                    $this->Flash->warning(__('Registrasi tersimpan, tetapi sinkron Instansi Rawat Jalan gagal: ' . $e->getMessage()));
                }
            }

            $this->Flash->success(__('Data registrasi berhasil disimpan.'));
            return $this->redirect(['action' => 'index']);
        }

        $errors = $registration->getErrors();
        $errorSource = !empty($patientErrors)
            ? $patientErrors
            : (!empty($errors) ? $errors : (!empty($personResponsibleErrors) ? $personResponsibleErrors : $queueErrors));

        $errorDetail = json_encode($errorSource, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($errorDetail === '[]' || $errorDetail === 'null' || $errorDetail === '') {
            $errorDetail = 'Tidak ada detail validasi dari CakePHP. Cek field wajib di database atau tipe kolom.';
        }
        $this->Flash->error(__('Data registrasi gagal disimpan. Error: ' . $errorDetail));
    }

    renderRegistrationAddForm:

    // Kalau proses save gagal dan kembali ke form, isi entity dengan data POST
    // agar form tidak terlihat kosong dan error validasi bisa dibaca.
    if ($this->request->is('post') && !empty($data) && is_array($data)) {
        $safeDataForEntity = $data;
        unset($safeDataForEntity['patient'], $safeDataForEntity['patient_title'], $safeDataForEntity['person_responsible'], $safeDataForEntity['poly_name']);
        $registrationColumnsForEntity = array_flip($this->Registrations->getSchema()->columns());
        $safeDataForEntity = array_intersect_key($safeDataForEntity, $registrationColumnsForEntity);
        $registration = $this->Registrations->patchEntity($registration, $safeDataForEntity);
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

    $this->loadModel('MasterPenjamins');
    $masterPenjamins = $this->MasterPenjamins->find('list', [
        'keyField' => 'name',
        'valueField' => 'name',
    ])
        ->where(['MasterPenjamins.is_active' => 'Y'])
        ->order(['MasterPenjamins.name' => 'ASC'])
        ->toArray();

    $this->loadModel('MasterTreatmentPackages');
    $masterTreatmentPackages = $this->MasterTreatmentPackages->find('list', [
        'keyField' => 'name',
        'valueField' => 'name',
    ])
        ->where(['MasterTreatmentPackages.is_active' => 'Y'])
        ->order(['MasterTreatmentPackages.name' => 'ASC'])
        ->toArray();

    $masterPatientReferrers = $this->getMasterPatientReferrerOptions();

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
        'queueSource',
        'queuePatientId',
        'queuePatientData',
        'masterPenjamins',
        'masterTreatmentPackages',
        'masterPatientReferrers'
    ));
}


    public function edit($id = null)
    {
        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients', 'PersonResponsibles', 'Beds'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Ambil data penanggung jawab saat edit.
            // Disimpan/update ke tabel person_responsibles berdasarkan registration_id.
            $personResponsibleData = [];
            if (!empty($data['person_responsible']) && is_array($data['person_responsible'])) {
                foreach ($data['person_responsible'] as $key => $value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                    $personResponsibleData[$key] = $value;
                }

                $hasPersonResponsible = false;
                foreach ($personResponsibleData as $value) {
                    if (trim((string)$value) !== '') {
                        $hasPersonResponsible = true;
                        break;
                    }
                }

                if (!$hasPersonResponsible) {
                    $personResponsibleData = [];
                }
            }

            // Normalisasi Cara Bayar ketika edit registrasi sesuai permintaan client:
            // hanya 4 jenis pasien: PERORANGAN, ASURANSI, PERUSAHAAN_AFILIASI, KARYAWAN.
            $allowedPaymentMethods = ['PERORANGAN', 'ASURANSI', 'PERUSAHAAN_AFILIASI', 'KARYAWAN'];
            if (!in_array(($data['payment_method'] ?? ''), $allowedPaymentMethods, true)) {
                $data['payment_method'] = null;
            }

            if (($data['payment_method'] ?? '') === 'PERORANGAN') {
                foreach ([
                    'insurance_type',
                    'insurance_category',
                    'insurance_card_no',
                    'refferal_no',
                    'sep_no',
                    'bpjs_nik',
                    'bpjs_name',
                    'bpjs_group',
                    'bpjs_type',
                    'bpjs_class',
                    'patient_group',
                    'patient_class',
                    'provider'
                ] as $paymentField) {
                    $data[$paymentField] = null;
                }
            }

            if (($data['treatment_type'] ?? 'BIASA') !== 'PAKET') {
                $data['package_name'] = null;
            }

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
                'room_name',
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
                'patient_group',
                'patient_class',
                'provider',
                'package_name',
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
                $data['person_responsible'],
                $data['poly_name']
            );

            $newBedId = !empty($data['bed_id']) ? (int)$data['bed_id'] : null;
            $newServiceType = $data['service_type'] ?? '';
            $patientId = !empty($data['patient_id'])
                ? (int)$data['patient_id']
                : (int)$registration->patient_id;

            $regSchemaBeforePatch = $this->Registrations->getSchema();
            if (
                $regSchemaBeforePatch->hasColumn('queue_no')
                && empty($data['queue_no'])
                && !empty($data['queue_number'])
            ) {
                $data['queue_no'] = (string)$data['queue_number'];
            }

            $registration = $this->Registrations->patchEntity($registration, $data);
            $registration->queue_no = $data['queue_no'] ?? null;
            $registration->room_id = $data['room_id'] ?? null;
            $registration->bed_id = $data['bed_id'] ?? null;
            $registration->class_name = $data['class_name'] ?? null;
            $registration->person_responsible_id = $data['person_responsible_id'] ?? null;

            foreach (['queue_no', 'queue_number', 'room_name', 'polyclinic_name', 'doctor_schedule_id', 'skdp_no'] as $forceField) {
                if (array_key_exists($forceField, $data)) {
                    $registration->{$forceField} = $data[$forceField];
                }
            }

            $personResponsibleErrors = [];
            $savedEdit = $this->Registrations->getConnection()->transactional(function () use (&$registration, $personResponsibleData, &$personResponsibleErrors) {
                if (!$this->Registrations->save($registration)) {
                    return false;
                }

                // Pastikan rekam medis tetap ada walaupun registrasi ini dibuat sebelum
                // fitur auto-generate No Rekam Medis aktif (data lama).
                $this->_createMedicalRecordForRegistration($registration);

                if (!empty($personResponsibleData)) {
                    $this->loadModel('PersonResponsibles');
                    $personSchema = $this->PersonResponsibles->getSchema();

                    $personResponsible = $this->PersonResponsibles->find()
                        ->where(['PersonResponsibles.registration_id' => (int)$registration->id])
                        ->first();

                    if (!$personResponsible && !empty($registration->person_responsible_id)) {
                        $personResponsible = $this->PersonResponsibles->find()
                            ->where(['PersonResponsibles.id' => (int)$registration->person_responsible_id])
                            ->first();
                    }

                    if (!$personResponsible) {
                        $personResponsible = $this->PersonResponsibles->newEmptyEntity();
                    }

                    $personData = $personResponsibleData;
                    $personData['registration_id'] = (int)$registration->id;

                    if ($personSchema->hasColumn('is_create') && empty($personResponsible->id) && !isset($personData['is_create'])) {
                        $personData['is_create'] = 1;
                    }
                    if ($personSchema->hasColumn('is_update')) {
                        $personData['is_update'] = !empty($personResponsible->id) ? 1 : 0;
                    }
                    if ($personSchema->hasColumn('is_delete') && !isset($personData['is_delete'])) {
                        $personData['is_delete'] = 0;
                    }
                    if ($personSchema->hasColumn('is_active') && empty($personData['is_active'])) {
                        $personData['is_active'] = 'Y';
                    }

                    $personColumns = array_flip($personSchema->columns());
                    $personData = array_intersect_key($personData, $personColumns);

                    $personResponsible = $this->PersonResponsibles->patchEntity($personResponsible, $personData);

                    foreach (['registration_id', 'name', 'identity_type', 'identity_no', 'relation', 'age', 'job', 'address', 'phone'] as $forcePersonField) {
                        if (array_key_exists($forcePersonField, $personData)) {
                            $personResponsible->{$forcePersonField} = $personData[$forcePersonField];
                        }
                    }

                    if (!$this->PersonResponsibles->save($personResponsible)) {
                        $personResponsibleErrors = $personResponsible->getErrors();
                        return false;
                    }

                    if ($this->Registrations->getSchema()->hasColumn('person_responsible_id')) {
                        $registration->person_responsible_id = (int)$personResponsible->id;
                        if (!$this->Registrations->save($registration)) {
                            return false;
                        }
                    }
                }

                return true;
            });

            if ($savedEdit) {
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

                if ($newServiceType === 'rawat_jalan') {
                    $this->_syncOutpatientVisitFromRegistration($registration);
                } elseif ($oldServiceType === 'rawat_jalan') {
                    $this->_cancelOutpatientVisitFromRegistration($registration);
                }

                $this->Flash->success(__('Data registrasi berhasil diubah.'));
                return $this->redirect(['action' => 'index']);
            }

            $errors = $registration->getErrors();
            $errorSource = !empty($errors) ? $errors : $personResponsibleErrors;
            $errorDetail = json_encode($errorSource, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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

        $bedQuery = $this->Registrations->Beds->find()
            ->select(['id', 'bed_no', 'name', 'class_name', 'room_id', 'status'])
            ->limit(200);

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

        if (!empty($registration->room_id)) {
            $bedQuery->andWhere(['Beds.room_id' => (int)$registration->room_id]);
        }

        $beds = $bedQuery->order(['Beds.name' => 'ASC'])->enableHydration(false)->toArray();

        $this->loadModel('MasterPenjamins');
        $masterPenjamins = $this->MasterPenjamins->find('list', [
            'keyField' => 'name',
            'valueField' => 'name',
        ])
            ->where(['MasterPenjamins.is_active' => 'Y'])
            ->order(['MasterPenjamins.name' => 'ASC'])
            ->toArray();

        $this->loadModel('MasterTreatmentPackages');
        $masterTreatmentPackages = $this->MasterTreatmentPackages->find('list', [
            'keyField' => 'name',
            'valueField' => 'name',
        ])
            ->where(['MasterTreatmentPackages.is_active' => 'Y'])
            ->order(['MasterTreatmentPackages.name' => 'ASC'])
            ->toArray();

        $masterPatientReferrers = $this->getMasterPatientReferrerOptions();

        $this->set(compact(
            'registration',
            'patients',
            'doctors',
            'rooms',
            'beds',
            'masterPenjamins',
            'masterTreatmentPackages',
            'masterPatientReferrers'
        ));
    }

    protected function _generateRegistrationNo(string $serviceType): string
{
    $prefixMap = [
        'rawat_jalan' => 'RJ',
        'igd'         => 'IGD',
        'rawat_inap'  => 'RI',
    ];

    $code = $prefixMap[$serviceType] ?? 'REG';
    $year = date('Y');
    $fullPrefix = $code . $year . '-';

    $last = $this->Registrations->find()
        ->where(['registration_no LIKE' => $fullPrefix . '%'])
        ->order(['id' => 'DESC'])
        ->first();

    $lastSeq = $last
        ? (int)substr((string)$last->registration_no, strlen($fullPrefix))
        : 0;

    return $fullPrefix . str_pad((string)($lastSeq + 1), 7, '0', STR_PAD_LEFT);
}

   protected function _createMedicalRecordForRegistration($registration): void
{
    $this->loadModel('MedicalRecords');

    $existing = $this->MedicalRecords->find()
        ->where([
            'registration_id' => (int)$registration->id
        ])
        ->first();

    if ($existing) {
        return;
    }

    $medicalRecord = $this->MedicalRecords->newEmptyEntity();

    $medicalRecord->registration_id = (int)$registration->id;
    $medicalRecord->patient_id       = (int)$registration->patient_id;

    $medicalRecord->medical_record_no = $this->MedicalRecords->generateMedicalRecordNo();

    if (!$this->MedicalRecords->save($medicalRecord, ['atomic' => false])) {
        throw new \RuntimeException(json_encode($medicalRecord->getErrors()));
    }
}

    /**
     * Generate No Rekam Medis otomatis, format: RM-YYYYMMDD-0001
     * Urutan reset per tanggal registrasi. Sesuaikan format ini kalau
     * kebutuhannya beda (misal per-pasien, atau tanpa reset per tanggal).
     */
    protected function _generateNoRm($registration): string
    {
        $this->loadModel('MedicalRecords');

        $regDate = $registration->registration_date ?? date('Y-m-d');
        $ymd = (is_object($regDate) && method_exists($regDate, 'format'))
            ? $regDate->format('Ymd')
            : date('Ymd', strtotime((string)$regDate));

        $prefix = 'RM-' . $ymd . '-';

        $last = $this->MedicalRecords->find()
            ->where(['medical_record_no LIKE' => $prefix . '%'])
            ->order(['id' => 'DESC'])
            ->first();

        $lastSeq = $last ? (int)substr((string)$last->medical_record_no, strlen($prefix)) : 0;

        return $prefix . str_pad((string)($lastSeq + 1), 4, '0', STR_PAD_LEFT);
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

    protected function _syncOutpatientVisitFromRegistration($registration): bool
    {
        $this->loadModel('OutpatientVisits');

        $schema = $this->OutpatientVisits->getSchema();

        $visitDate = $this->_formatRegistrationDate($registration->registration_date ?? date('Y-m-d'));
        $visitTime = null;
        if (!empty($registration->admission_time)) {
            $visitTime = is_object($registration->admission_time) && method_exists($registration->admission_time, 'format')
                ? $registration->admission_time->format('H:i:s')
                : (strlen((string)$registration->admission_time) <= 5 ? (string)$registration->admission_time . ':00' : (string)$registration->admission_time);
        }

        $visit = $this->OutpatientVisits->find()
            ->where(['OutpatientVisits.registration_id' => (int)$registration->id])
            ->first();

        if (!$visit) {
            $visit = $this->OutpatientVisits->newEmptyEntity();
        }

        // Nomor antrian rawat jalan otomatis per tanggal.
        // Hari ini mulai dari 1, pasien berikutnya 2, 3, dst. Besok reset lagi dari 1.
        $queueNumber = $registration->queue_number
            ?? $registration->queue_no
            ?? null;

        if (empty($queueNumber)) {
            $lastQueue = $this->OutpatientVisits->find()
                ->select(['max_queue' => $this->OutpatientVisits->find()->func()->max('OutpatientVisits.queue_number')])
                ->where(['OutpatientVisits.visit_date' => $visitDate])
                ->enableHydration(false)
                ->first();

            $queueNumber = ((int)($lastQueue['max_queue'] ?? 0)) + 1;
        }

        $roomName = $registration->room_name
            ?? ($registration->room->room_name ?? null)
            ?? ($registration->room->name ?? null)
            ?? null;

        $visitData = [];

        if ($schema->hasColumn('registration_id')) {
            $visitData['registration_id'] = (int)$registration->id;
        }
        if ($schema->hasColumn('registration_no')) {
            $visitData['registration_no'] = (string)($registration->registration_no ?? '');
        }
        if ($schema->hasColumn('patient_id')) {
            $visitData['patient_id'] = !empty($registration->patient_id) ? (int)$registration->patient_id : null;
        }
        if ($schema->hasColumn('doctor_id')) {
            $visitData['doctor_id'] = !empty($registration->doctor_id) ? (int)$registration->doctor_id : null;
        }
        if ($schema->hasColumn('queue_number')) {
            $visitData['queue_number'] = (int)$queueNumber;
        }
        if ($schema->hasColumn('polyclinic_name')) {
            $visitData['polyclinic_name'] = $registration->polyclinic_name ?? null;
        }
        if ($schema->hasColumn('room_name')) {
            $visitData['room_name'] = $roomName;
        }
        if ($schema->hasColumn('visit_date')) {
            $visitData['visit_date'] = $visitDate;
        }
        if ($schema->hasColumn('visit_time')) {
            $visitData['visit_time'] = $visitTime ?: date('H:i:s');
        }
        if ($schema->hasColumn('status') && empty($visit->status)) {
            $visitData['status'] = 'waiting';
        }
        if ($schema->hasColumn('billing_status') && empty($visit->billing_status)) {
            $visitData['billing_status'] = 'unpaid';
        }
        if ($schema->hasColumn('created') && empty($visit->created)) {
            $visitData['created'] = date('Y-m-d H:i:s');
        }
        if ($schema->hasColumn('modified')) {
            $visitData['modified'] = date('Y-m-d H:i:s');
        }

        // Jangan pakai patchEntity di sini karena beberapa field seperti queue_number/room_name
        // bisa tidak masuk kalau $_accessible Entity belum diizinkan.
        foreach ($visitData as $field => $value) {
            $visit->{$field} = $value;
        }

        if (!$this->OutpatientVisits->save($visit)) {
            $this->lastOutpatientVisitErrors = $visit->getErrors();
            $this->log('Gagal sync outpatient visit dari registrasi: ' . json_encode($this->lastOutpatientVisitErrors), 'error');
            return false;
        }

        // Simpan juga nomor antrian ke registrations kalau tabel punya kolom queue_no.
        // Ini supaya data di halaman pendaftaran pasien tetap konsisten.
        try {
            $regSchema = $this->Registrations->getSchema();
            $needSaveReg = false;

            if ($regSchema->hasColumn('queue_no') && empty($registration->queue_no)) {
                $registration->queue_no = (string)$queueNumber;
                $needSaveReg = true;
            }
            if ($regSchema->hasColumn('queue_number') && empty($registration->queue_number)) {
                $registration->queue_number = (string)$queueNumber;
                $needSaveReg = true;
            }
            if ($regSchema->hasColumn('room_name') && empty($registration->room_name) && !empty($roomName)) {
                $registration->room_name = $roomName;
                $needSaveReg = true;
            }

            if ($needSaveReg) {
                $this->Registrations->save($registration);
            }
        } catch (\Throwable $e) {
            $this->log('Registrasi tersimpan, tetapi update queue_no/room_name registrasi gagal: ' . $e->getMessage(), 'warning');
        }

        return true;
    }

    protected function _cancelOutpatientVisitFromRegistration($registration): void
    {
        $this->loadModel('OutpatientVisits');

        $visit = $this->OutpatientVisits->find()
            ->where(['registration_id' => $registration->id])
            ->first();

        if (!$visit || in_array($visit->status, ['done', 'cancelled'], true)) {
            return;
        }

        $visit->status = 'cancelled';
        $this->OutpatientVisits->save($visit);
    }

    protected function _formatRegistrationDate($date): string
    {
        if (empty($date)) {
            return date('Y-m-d');
        }

        if (is_object($date) && method_exists($date, 'format')) {
            return $date->format('Y-m-d');
        }

        return date('Y-m-d', strtotime((string)$date));
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

    private function getMasterPatientReferrerOptions(): array
    {
        try {
            $this->loadModel('MasterPatientReferrers');
        } catch (\Throwable $e) {
            return [];
        }

        try {
            $schema = $this->MasterPatientReferrers->getSchema();
            $fields = ['id'];

            foreach ([
                'code',
                'name',
                'referral_origin',
                'doctor_sender',
                'type',
                'origin',
                'phone',
                'address',
                'is_active',
            ] as $field) {
                if ($schema->hasColumn($field)) {
                    $fields[] = $field;
                }
            }

            $query = $this->MasterPatientReferrers->find()
                ->select(array_values(array_unique($fields)))
                ->order([
                    $schema->hasColumn('referral_origin') ? 'MasterPatientReferrers.referral_origin' : 'MasterPatientReferrers.name' => 'ASC',
                    'MasterPatientReferrers.name' => 'ASC',
                ])
                ->enableHydration(false);

            if ($schema->hasColumn('is_active')) {
                $query->where(['MasterPatientReferrers.is_active' => 'Y']);
            }

            return $query->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    private function syncMasterPatientReferrerFromRegistrationData(array $data): void
    {
        $referralType = trim((string)($data['referral_type'] ?? ''));
        $referralName = trim((string)($data['referral_name'] ?? ''));
        $referralOrigin = trim((string)($data['referral_origin'] ?? ''));
        $doctorSender = trim((string)($data['referral_doctor'] ?? ''));

        if ($referralType === '' || $referralType === 'None') {
            return;
        }

        if ($referralName === '' && $referralOrigin === '' && $doctorSender === '') {
            return;
        }

        try {
            $this->loadModel('MasterPatientReferrers');
        } catch (\Throwable $e) {
            return;
        }

        try {
            $schema = $this->MasterPatientReferrers->getSchema();

            $conditions = [];

            if ($schema->hasColumn('name')) {
                $conditions['MasterPatientReferrers.name'] = $referralName;
            }

            if ($schema->hasColumn('referral_origin')) {
                $conditions['MasterPatientReferrers.referral_origin'] = $referralOrigin;
            } elseif ($schema->hasColumn('origin')) {
                $conditions['MasterPatientReferrers.origin'] = $referralOrigin;
            } elseif ($schema->hasColumn('type')) {
                $conditions['MasterPatientReferrers.type'] = $referralOrigin;
            } elseif ($schema->hasColumn('address')) {
                $conditions['MasterPatientReferrers.address'] = $referralOrigin;
            }

            if ($schema->hasColumn('doctor_sender')) {
                $conditions['MasterPatientReferrers.doctor_sender'] = $doctorSender;
            }

            $conditions = array_filter($conditions, static function ($value) {
                return $value !== null;
            });

            if (empty($conditions)) {
                return;
            }

            $existing = $this->MasterPatientReferrers->find()
                ->where($conditions)
                ->first();

            if ($existing) {
                $changed = false;

                if ($schema->hasColumn('is_active') && empty($existing->is_active)) {
                    $existing->is_active = 'Y';
                    $changed = true;
                }

                if ($changed) {
                    $this->MasterPatientReferrers->save($existing);
                }

                return;
            }

            $newData = [];

            if ($schema->hasColumn('code')) {
                $last = $this->MasterPatientReferrers->find()
                    ->select(['id'])
                    ->order(['id' => 'DESC'])
                    ->first();
                $next = $last ? ((int)$last->id + 1) : 1;
                $newData['code'] = 'PRJ-' . str_pad((string)$next, 4, '0', STR_PAD_LEFT);
            }

            if ($schema->hasColumn('name')) {
                $newData['name'] = $referralName !== '' ? $referralName : ($doctorSender !== '' ? $doctorSender : $referralOrigin);
            }

            if ($referralOrigin !== '') {
                if ($schema->hasColumn('referral_origin')) {
                    $newData['referral_origin'] = $referralOrigin;
                } elseif ($schema->hasColumn('origin')) {
                    $newData['origin'] = $referralOrigin;
                } elseif ($schema->hasColumn('type')) {
                    $newData['type'] = $referralOrigin;
                } elseif ($schema->hasColumn('address')) {
                    $newData['address'] = $referralOrigin;
                }
            }

            if ($doctorSender !== '' && $schema->hasColumn('doctor_sender')) {
                $newData['doctor_sender'] = $doctorSender;
            }

            if ($schema->hasColumn('is_active')) {
                $newData['is_active'] = 'Y';
            }

            if (!empty($newData)) {
                $masterPatientReferrer = $this->MasterPatientReferrers->newEmptyEntity();
                $masterPatientReferrer = $this->MasterPatientReferrers->patchEntity($masterPatientReferrer, $newData);
                $this->MasterPatientReferrers->save($masterPatientReferrer);
            }
        } catch (\Throwable $e) {
            return;
        }
    }

    public function searchPatients()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $keyword = trim((string)$this->request->getQuery('q'));

        $this->loadModel('Patients');

        $schema = $this->Patients->getSchema();

        $selectFields = [
            'id',
            'code',
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
        
        foreach ([
            'title',
            'age',
            'province',
            'city',
            'district',
            'subdistrict',
            'id_prov',
            'id_kab',
            'id_kec',
            'id_kel'
        ] as $optionalField) {
            if ($schema->hasColumn($optionalField)) {
                $selectFields[] = $optionalField;
            }
        }

        $query = $this->Patients->find()
            ->select(array_values(array_unique($selectFields)))
            ->order(['Patients.id' => 'DESC'])
            ->limit(50)
            ->enableHydration(false);

        if ($keyword !== '') {
            $searchConditions = [
                'Patients.code LIKE' => '%' . $keyword . '%',
                'Patients.identity_number LIKE' => '%' . $keyword . '%',
                'Patients.full_name LIKE' => '%' . $keyword . '%',
            ];

            if ($schema->hasColumn('phone_number')) {
                $searchConditions[] = ['Patients.phone_number LIKE' => '%' . $keyword . '%'];
            }

            $query->where(['OR' => $searchConditions]);
        }

        $patients = $query->toArray();

        if (!empty($patients)) {
            foreach ($patients as &$patient) {
                foreach (['birth_date', 'created', 'modified'] as $dateField) {
                    if (!empty($patient[$dateField]) && is_object($patient[$dateField]) && method_exists($patient[$dateField], 'format')) {
                        $patient[$dateField] = $patient[$dateField]->format('Y-m-d');
                    }
                }
            }
            unset($patient);

            $regionFields = [
                'id_prov' => ['model' => 'DaerahProvinsis', 'key' => 'id_prov', 'nameField' => 'province'],
                'id_kab' => ['model' => 'DaerahKabupatens', 'key' => 'id_kab', 'nameField' => 'city'],
                'id_kec' => ['model' => 'DaerahKecamatans', 'key' => 'id_kec', 'nameField' => 'district'],
                'id_kel' => ['model' => 'DaerahKelurahans', 'key' => 'id_kel', 'nameField' => 'subdistrict'],
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
                    $nameField = $config['nameField'];

                    if (is_numeric($value) && isset($map[(string)$value]) && empty($patient[$nameField])) {
                        $patient[$nameField] = $map[(string)$value];
                    }
                }
                unset($patient);
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
        $currentBedId = $this->request->getQuery('current_bed_id');

        $conditions = ['OR' => [['Beds.status' => 0]]];
        if (!empty($currentBedId)) {
            $conditions['OR'][] = ['Beds.id' => (int)$currentBedId];
        }

        $query = $this->Registrations->Beds->find()
            ->select(['id', 'bed_no', 'name', 'class_name', 'status'])
            ->where($conditions)
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

    public function previewRegistrationNo()
{
    $this->request->allowMethod(['get']);
    $this->autoRender = false;

    $serviceType = (string)$this->request->getQuery('service_type');
    if (!in_array($serviceType, ['rawat_jalan', 'igd', 'rawat_inap'], true)) {
        $serviceType = 'rawat_jalan';
    }

    $registrationNo = $this->_generateRegistrationNo($serviceType);

    return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode(['registration_no' => $registrationNo]));
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