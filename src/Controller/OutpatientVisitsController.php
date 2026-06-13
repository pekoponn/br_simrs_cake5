<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class OutpatientVisitsController extends AppController
{
    // ─────────────────────────────────────────────────────────────────────────
    // INDEX — Daftar antrian rawat jalan
    // ─────────────────────────────────────────────────────────────────────────
    public function index()
    {
        $filterDateFrom = $this->request->getQuery('date_from', date('Y-m-d'));
        $filterDateTo   = $this->request->getQuery('date_to',   date('Y-m-d'));
        $filterPoli     = $this->request->getQuery('poli');
        $filterDoctor   = $this->request->getQuery('doctor_id');
        $filterStatus   = $this->request->getQuery('status');
        $q              = $this->request->getQuery('q');

        // Pastikan date_to >= date_from
        if ($filterDateTo < $filterDateFrom) {
            $filterDateTo = $filterDateFrom;
        }

        $this->_syncMissingVisitsFromRegistrations($filterDateFrom, $filterDateTo);

        $conditions = [
            'OutpatientVisits.visit_date >=' => $filterDateFrom,
            'OutpatientVisits.visit_date <=' => $filterDateTo,
        ];

        if (!empty($filterPoli)) {
            $conditions['OutpatientVisits.polyclinic_name'] = $filterPoli;
        }

        if (!empty($filterDoctor)) {
            $conditions['OutpatientVisits.doctor_id'] = (int)$filterDoctor;
        }

        if (!empty($filterStatus)) {
            $conditions['OutpatientVisits.status'] = $filterStatus;
        }

        if (!empty($q)) {
            $conditions['OR'] = [
                'Patients.full_name LIKE'                   => '%' . $q . '%',
                'OutpatientVisits.registration_no LIKE'     => '%' . $q . '%',
            ];
        }

        $this->paginate = [
            'contain'    => ['Patients', 'Doctors', 'Registrations'],
            'conditions' => $conditions,
            'order'      => [
                'OutpatientVisits.visit_date'    => 'ASC',
                'OutpatientVisits.queue_number'  => 'ASC',
            ],
            'limit'      => 50,
        ];

        $visits = $this->paginate($this->OutpatientVisits);

        // ── Daftar poli unik untuk filter tab ────────────────────────────────
        $poliList = $this->OutpatientVisits->find()
            ->select(['polyclinic_name'])
            ->where([
                'OutpatientVisits.visit_date >=' => $filterDateFrom,
                'OutpatientVisits.visit_date <=' => $filterDateTo,
            ])
            ->where(['OutpatientVisits.polyclinic_name IS NOT' => null])
            ->enableHydration(false)
            ->groupBy('polyclinic_name')
            ->toArray();

        // ── Dokter list untuk filter ──────────────────────────────────────────
        $doctors = $this->OutpatientVisits->Doctors->find('list', [
            'keyField'   => 'id',
            'valueField' => 'doctor_name',
        ])->limit(200)->all()->toArray();

        // ── Summary counts ────────────────────────────────────────────────────
        $base = $this->OutpatientVisits->find()
            ->where([
                'OutpatientVisits.visit_date >=' => $filterDateFrom,
                'OutpatientVisits.visit_date <=' => $filterDateTo,
            ]);

        $summary = [
            'waiting'     => (clone $base)->where(['status' => 'waiting'])->count(),
            'called'      => (clone $base)->where(['status' => 'called'])->count(),
            'in_progress' => (clone $base)->where(['status' => 'in_progress'])->count(),
            'done'        => (clone $base)->where(['status' => 'done'])->count(),
            'total'       => (clone $base)->count(),
        ];

        $this->set(compact(
            'visits', 'summary', 'poliList', 'doctors',
            'filterDateFrom', 'filterDateTo',
            'filterPoli', 'filterDoctor', 'filterStatus', 'q'
        ));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // VIEW — Detail kunjungan
    // ─────────────────────────────────────────────────────────────────────────
    public function view($id = null)
    {
        $visit = $this->OutpatientVisits->get($id, [
            'contain' => [
                'Patients',
                'Doctors',
                'Registrations',
                'OutpatientActions',
            ],
        ]);

        $this->set(compact('visit'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // ADD — Buat kunjungan rawat jalan dari registrasi
    // ─────────────────────────────────────────────────────────────────────────
    public function add()
    {
        $visit = $this->OutpatientVisits->newEmptyEntity();

        $registrationId = $this->request->getQuery('registration_id');
        $registration   = null;

        if (!empty($registrationId)) {
            $this->loadModel('Registrations');
            try {
                $registration = $this->Registrations->get((int)$registrationId, [
                    'contain' => ['Patients', 'Doctors'],
                ]);
            } catch (\Exception $e) {
                $registration = null;
            }
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $nullableFields = [
                'doctor_id', 'queue_number', 'polyclinic_name',
                'blood_pressure', 'pulse', 'temperature', 'respiratory_rate',
                'oxygen_saturation', 'weight', 'height',
                'chief_complaint', 'illness_history', 'allergy', 'pain_scale',
                'diagnosis_primary', 'diagnosis_secondary', 'diagnosis_desc',
                'action_notes', 'doctor_notes', 'prescription_notes',
                'follow_up_date', 'referral_to', 'referral_reason',
            ];

            foreach ($nullableFields as $field) {
                if (isset($data[$field]) && $data[$field] === '') {
                    $data[$field] = null;
                }
            }

            foreach (['registration_id', 'patient_id', 'doctor_id', 'queue_number', 'pain_scale', 'pulse', 'respiratory_rate', 'oxygen_saturation'] as $f) {
                if (!empty($data[$f])) {
                    $data[$f] = (int)$data[$f];
                }
            }

            foreach (['weight', 'height', 'temperature', 'total_fee'] as $f) {
                if (!empty($data[$f])) {
                    $data[$f] = (float)$data[$f];
                }
            }

            if (empty($data['status'])) {
                $data['status'] = 'waiting';
            }

            if (empty($data['visit_date'])) {
                $data['visit_date'] = date('Y-m-d');
            }

            if (empty($data['queue_number']) && !empty($data['polyclinic_name'])) {
                $lastQueue = $this->OutpatientVisits->find()
                    ->select(['queue_number'])
                    ->where([
                        'visit_date'      => $data['visit_date'],
                        'polyclinic_name' => $data['polyclinic_name'],
                    ])
                    ->order(['queue_number' => 'DESC'])
                    ->first();
                $data['queue_number'] = $lastQueue ? ($lastQueue->queue_number + 1) : 1;
            }

            $visit = $this->OutpatientVisits->patchEntity($visit, $data);

            if ($this->OutpatientVisits->save($visit)) {
                $this->Flash->success(__('Kunjungan rawat jalan berhasil dibuat.'));
                return $this->redirect(['action' => 'index', '?' => ['date_from' => $data['visit_date'], 'date_to' => $data['visit_date']]]);
            }

            $err = json_encode($visit->getErrors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $this->Flash->error(__('Gagal menyimpan. Error: ' . $err));
        }

        $doctors = $this->OutpatientVisits->Doctors->find('list', [
            'keyField'   => 'id',
            'valueField' => 'doctor_name',
        ])->limit(200)->all()->toArray();

        $this->set(compact('visit', 'doctors', 'registration', 'registrationId'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EDIT — Edit data kunjungan
    // ─────────────────────────────────────────────────────────────────────────
    public function edit($id = null)
    {
        $visit = $this->OutpatientVisits->get($id, [
            'contain' => ['Patients', 'Doctors', 'Registrations', 'OutpatientActions'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $nullableFields = [
                'doctor_id', 'queue_number', 'polyclinic_name',
                'blood_pressure', 'pulse', 'temperature', 'respiratory_rate',
                'oxygen_saturation', 'weight', 'height',
                'chief_complaint', 'illness_history', 'allergy', 'pain_scale',
                'diagnosis_primary', 'diagnosis_secondary', 'diagnosis_desc',
                'action_notes', 'doctor_notes', 'prescription_notes',
                'follow_up_date', 'referral_to', 'referral_reason',
            ];

            foreach ($nullableFields as $field) {
                if (isset($data[$field]) && $data[$field] === '') {
                    $data[$field] = null;
                }
            }

            foreach (['patient_id', 'doctor_id', 'queue_number', 'pain_scale', 'pulse', 'respiratory_rate', 'oxygen_saturation'] as $f) {
                if (!empty($data[$f])) {
                    $data[$f] = (int)$data[$f];
                }
            }

            foreach (['weight', 'height', 'temperature', 'total_fee'] as $f) {
                if (!empty($data[$f])) {
                    $data[$f] = (float)$data[$f];
                }
            }

            $visit = $this->OutpatientVisits->patchEntity($visit, $data);

            if ($this->OutpatientVisits->save($visit)) {
                $this->Flash->success(__('Data kunjungan berhasil diubah.'));
                return $this->redirect(['action' => 'index']);
            }

            $err = json_encode($visit->getErrors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $this->Flash->error(__('Gagal mengubah. Error: ' . $err));
        }

        $doctors = $this->OutpatientVisits->Doctors->find('list', [
            'keyField'   => 'id',
            'valueField' => 'doctor_name',
        ])->limit(200)->all()->toArray();

        $this->set(compact('visit', 'doctors'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CPPT — Catatan Perkembangan Pasien Terintegrasi
    // ─────────────────────────────────────────────────────────────────────────
    public function cppt($id = null)
    {
        $visit = $this->OutpatientVisits->get($id, [
            'contain' => ['Patients', 'Doctors', 'Registrations', 'OutpatientActions'],
        ]);

        $connection = ConnectionManager::get('default');
        $medicalRecordId = $this->findOrCreateMedicalRecordId($connection, (int)$visit->registration_id);
        $cpptNotes = $this->readIntegrationRows($connection, $medicalRecordId);
        $doctors = $this->OutpatientVisits->Doctors->find('list', [
            'keyField' => 'id',
            'valueField' => 'doctor_name',
        ])->limit(200)->all()->toArray();
        $currentUser = $this->currentUserData();
        $currentUserName = $currentUser['name'] ?? '-';

        $this->set(compact('visit', 'cpptNotes', 'doctors', 'currentUserName'));
    }

    public function addCppt($id = null)
    {
        $this->request->allowMethod(['post']);

        $visit = $this->OutpatientVisits->get($id, [
            'contain' => ['Doctors'],
        ]);
        $data = $this->request->getData();

        if (empty($data['doctor_id']) || trim((string)($data['soap_sbar'] ?? '')) === '') {
            $this->Flash->error(__('Dokter dan SOAP SBAR wajib diisi.'));
            return $this->redirect(['action' => 'cppt', $id]);
        }

        $connection = ConnectionManager::get('default');
        $currentUser = $this->currentUserData();
        $doctor = null;

        if (!empty($data['doctor_id'])) {
            try {
                $doctor = $this->OutpatientVisits->Doctors->get((int)$data['doctor_id']);
            } catch (\Exception $e) {
                $doctor = null;
            }
        }

        $saved = $connection->transactional(function () use ($connection, $visit, $data, $currentUser, $doctor) {
            $medicalRecordId = $this->findOrCreateMedicalRecordId($connection, (int)$visit->registration_id);
            if (!$medicalRecordId) {
                return false;
            }

            $notedAt = !empty($data['noted_at'])
                ? date('Y-m-d H:i:s', strtotime((string)$data['noted_at']))
                : date('Y-m-d H:i:s');
            $healthWorkerName = $currentUser['name'] ?? 'User';
            $doctorName = $doctor->doctor_name ?? $visit->doctor->doctor_name ?? null;
            $soapSbar = trim((string)($data['soap_sbar'] ?? ''));
            $instruction = trim((string)($data['instruction'] ?? ''));

            $payload = [
                'noted_at' => $notedAt,
                'health_worker_name' => $healthWorkerName,
                'doctor_name' => $doctorName,
                'soap_sbar' => $soapSbar,
                'instruction' => $instruction,
            ];

            return $this->insertSchemaAware($connection, 'medical_record_integrations', [
                'medical_record_id' => $medicalRecordId,
                'noted_at' => $notedAt,
                'user_id' => $currentUser['id'] ?? null,
                'health_worker_name' => $healthWorkerName,
                'profession' => $currentUser['staff'] ?? $currentUser['devision'] ?? null,
                'doctor_id' => $doctor->id ?? $visit->doctor_id ?? null,
                'doctor_name' => $doctorName,
                'soap_sbar' => $soapSbar,
                'instruction' => $instruction,
                'status' => 'Draft',
                'note' => trim("SOAP SBAR:\n" . $soapSbar . "\n\nInstruksi:\n" . $instruction),
                'payload_json' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'is_create' => 1,
                'is_update' => 0,
                'is_delete' => 0,
                'is_active' => 'Y',
                'created' => date('Y-m-d H:i:s'),
            ]);
        });

        if ($saved) {
            if (in_array($visit->status, ['waiting', 'called'], true)) {
                $visit->status = 'in_progress';
                $visit->start_time = date('Y-m-d H:i:s');
                $this->OutpatientVisits->save($visit);
            }

            $this->Flash->success(__('Catatan CPPT berhasil disimpan ke Form Integrasi rekam medis.'));
        } else {
            $this->Flash->error(__('Catatan CPPT gagal disimpan.'));
        }

        return $this->redirect(['action' => 'cppt', $id]);
    }

    public function deleteCppt($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $connection = ConnectionManager::get('default');
        $row = $connection->execute(
            'SELECT mri.id, ov.id AS outpatient_visit_id
            FROM medical_record_integrations mri
            INNER JOIN medical_records mr ON mr.id = mri.medical_record_id
            INNER JOIN outpatient_visits ov ON ov.registration_id = mr.registration_id
            WHERE mri.id = :id
            LIMIT 1',
            ['id' => (int)$id]
        )->fetch('assoc');

        if (!$row) {
            $this->Flash->error(__('Catatan CPPT tidak ditemukan.'));
            return $this->redirect(['action' => 'index']);
        }

        $connection->update('medical_record_integrations', [
            'is_delete' => 1,
            'deleted' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        ], ['id' => (int)$id]);

        $this->Flash->success(__('Catatan CPPT berhasil dihapus.'));
        return $this->redirect(['action' => 'cppt', (int)$row['outpatient_visit_id']]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SELESAI — Tandai kunjungan selesai
    // ─────────────────────────────────────────────────────────────────────────
    public function selesai($id = null)
    {
        $this->request->allowMethod(['post']);

        $visit = $this->OutpatientVisits->get($id);
        $visit->status   = 'done';
        $visit->end_time = date('Y-m-d H:i:s');

        if ($this->OutpatientVisits->save($visit)) {
            if ($this->request->is('ajax')) {
                $this->autoRender = false;
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['success' => true, 'message' => 'Kunjungan ditandai selesai']));
            }
            $this->Flash->success(__('Kunjungan ditandai selesai.'));
        } else {
            if ($this->request->is('ajax')) {
                $this->autoRender = false;
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['success' => false, 'message' => 'Gagal menandai selesai']));
            }
            $this->Flash->error(__('Gagal menandai selesai.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PANGGIL — Panggil pasien (update status → called)
    // ─────────────────────────────────────────────────────────────────────────
    public function panggil($id = null)
    {
        $this->request->allowMethod(['post']);

        $visit = $this->OutpatientVisits->get($id);

        if ($visit->status !== 'waiting') {
            if ($this->request->is('ajax')) {
                $this->autoRender = false;
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['success' => false, 'message' => 'Status bukan waiting']));
            }
            $this->Flash->error(__('Pasien sudah dipanggil atau sedang diperiksa.'));
            return $this->redirect(['action' => 'index']);
        }

        $visit->status    = 'called';
        $visit->called_at = date('Y-m-d H:i:s');

        $saved = $this->OutpatientVisits->save($visit);

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            return $this->response->withType('application/json')
                ->withStringBody(json_encode([
                    'success'  => (bool)$saved,
                    'message'  => $saved ? 'Pasien berhasil dipanggil' : 'Gagal memanggil pasien',
                    'visit_id' => $visit->id,
                    'status'   => $visit->status,
                ]));
        }

        if ($saved) {
            $this->Flash->success(__('Pasien berhasil dipanggil.'));
        } else {
            $this->Flash->error(__('Gagal memanggil pasien.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // BATAL — Batalkan kunjungan
    // ─────────────────────────────────────────────────────────────────────────
    public function batal($id = null)
    {
        $this->request->allowMethod(['post']);

        $visit = $this->OutpatientVisits->get($id);
        $visit->status = 'cancelled';

        if ($this->OutpatientVisits->save($visit)) {
            if ($this->request->is('ajax')) {
                $this->autoRender = false;
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['success' => true, 'message' => 'Kunjungan dibatalkan']));
            }
            $this->Flash->success(__('Kunjungan dibatalkan.'));
        } else {
            if ($this->request->is('ajax')) {
                $this->autoRender = false;
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['success' => false, 'message' => 'Gagal membatalkan kunjungan']));
            }
            $this->Flash->error(__('Gagal membatalkan kunjungan.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AJAX: getSummary — Summary harian untuk kartu realtime
    // ─────────────────────────────────────────────────────────────────────────
    public function getSummary()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $dateFrom = $this->request->getQuery('date_from', date('Y-m-d'));
        $dateTo   = $this->request->getQuery('date_to',   date('Y-m-d'));

        $base = $this->OutpatientVisits->find()
            ->where([
                'OutpatientVisits.visit_date >=' => $dateFrom,
                'OutpatientVisits.visit_date <=' => $dateTo,
            ]);

        $summary = [
            'waiting'     => (clone $base)->where(['status' => 'waiting'])->count(),
            'called'      => (clone $base)->where(['status' => 'called'])->count(),
            'in_progress' => (clone $base)->where(['status' => 'in_progress'])->count(),
            'done'        => (clone $base)->where(['status' => 'done'])->count(),
            'total'       => (clone $base)->count(),
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($summary));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EMR — Electronic Medical Record
    // ─────────────────────────────────────────────────────────────────────────
    public function liveData()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $filterDateFrom = $this->request->getQuery('date_from', date('Y-m-d'));
        $filterDateTo = $this->request->getQuery('date_to', date('Y-m-d'));
        $filterPoli = $this->request->getQuery('poli');
        $filterDoctor = $this->request->getQuery('doctor_id');
        $filterStatus = $this->request->getQuery('status');
        $q = $this->request->getQuery('q');

        if ($filterDateTo < $filterDateFrom) {
            $filterDateTo = $filterDateFrom;
        }

        $this->_syncMissingVisitsFromRegistrations($filterDateFrom, $filterDateTo);

        $conditions = [
            'OutpatientVisits.visit_date >=' => $filterDateFrom,
            'OutpatientVisits.visit_date <=' => $filterDateTo,
        ];

        if (!empty($filterPoli)) {
            $conditions['OutpatientVisits.polyclinic_name'] = $filterPoli;
        }

        if (!empty($filterDoctor)) {
            $conditions['OutpatientVisits.doctor_id'] = (int)$filterDoctor;
        }

        if (!empty($filterStatus)) {
            $conditions['OutpatientVisits.status'] = $filterStatus;
        }

        if (!empty($q)) {
            $conditions['OR'] = [
                'Patients.full_name LIKE' => '%' . $q . '%',
                'OutpatientVisits.registration_no LIKE' => '%' . $q . '%',
            ];
        }

        $visits = $this->OutpatientVisits->find()
            ->contain(['Patients', 'Doctors', 'Registrations'])
            ->where($conditions)
            ->order([
                'OutpatientVisits.visit_date' => 'ASC',
                'OutpatientVisits.queue_number' => 'ASC',
            ])
            ->limit(50)
            ->all();

        $base = $this->OutpatientVisits->find()
            ->where([
                'OutpatientVisits.visit_date >=' => $filterDateFrom,
                'OutpatientVisits.visit_date <=' => $filterDateTo,
            ]);

        $summary = [
            'waiting' => (clone $base)->where(['status' => 'waiting'])->count(),
            'called' => (clone $base)->where(['status' => 'called'])->count(),
            'in_progress' => (clone $base)->where(['status' => 'in_progress'])->count(),
            'done' => (clone $base)->where(['status' => 'done'])->count(),
            'total' => (clone $base)->count(),
        ];

        $rows = [];
        foreach ($visits as $visit) {
            $visitDate = $visit->visit_date;
            $rows[] = [
                'id' => $visit->id,
                'queue_number' => $visit->queue_number,
                'status' => $visit->status,
                'registration_no' => $visit->registration_no,
                'polyclinic_name' => $visit->polyclinic_name,
                'visit_date' => is_object($visitDate) ? $visitDate->format('d-m-Y') : date('d-m-Y', strtotime((string)$visitDate)),
                'visit_time' => !empty($visit->visit_time) ? substr((string)$visit->visit_time, 0, 5) : null,
                'chief_complaint' => $visit->chief_complaint,
                'patient_name' => $visit->patient->full_name ?? '-',
                'patient_medical_record_no' => $visit->patient->medical_record_no ?? '-',
                'doctor_name' => $visit->doctor->doctor_name ?? '-',
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'summary' => $summary,
                'rows' => $rows,
                'server_time' => date('H:i:s'),
            ], JSON_UNESCAPED_UNICODE));
    }

    public function emr($id = null)
    {
        $visit = $this->OutpatientVisits->get($id, [
            'contain' => [
                'Patients',
                'Doctors',
                'Registrations',
                'OutpatientActions',
            ],
        ]);

        if (!$this->request->is(['patch', 'post', 'put'])) {
            $this->hydrateVisitFromLatestMedicalRecord($visit);
        }
        $emrMeta = $this->readLatestEmrMeta($visit);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // ── Pisahkan tindakan dari data utama ─────────────────────────────
            $actionsRaw = $data['outpatient_actions'] ?? [];
            unset($data['outpatient_actions']);

            $data = $this->normalizeLegacyIcdSelections($data);

            if (!$this->hasText($data['chief_complaint'] ?? null) || !$this->hasText($data['diagnosis_primary'] ?? null)) {
                $this->Flash->error(__('Keluhan awal dan diagnosa utama wajib diisi sebelum EMR disimpan.'));
                $visit = $this->OutpatientVisits->patchEntity($visit, $data);
                $this->set(compact('visit', 'emrMeta'));
                return;
            }

            // ── Nullable fields ───────────────────────────────────────────────
            $nullableFields = [
                'blood_pressure', 'pulse', 'temperature', 'respiratory_rate',
                'oxygen_saturation', 'weight', 'height', 'bmi', 'bmi_category',
                'pain_scale', 'chief_complaint', 'illness_history', 'allergy',
                'diagnosis_primary', 'diagnosis_secondary', 'diagnosis_desc',
                'action_notes', 'doctor_notes', 'prescription_notes',
                'body_chart_notes', 'follow_up_date', 'referral_to', 'referral_reason',
                'inpatient_referral_no',
            ];

            foreach ($nullableFields as $field) {
                if (isset($data[$field]) && $data[$field] === '') {
                    $data[$field] = null;
                }
            }

            // ── Cast tipe ─────────────────────────────────────────────────────
            foreach (['pain_scale', 'pulse', 'respiratory_rate', 'oxygen_saturation'] as $f) {
                if (!empty($data[$f])) { $data[$f] = (int)$data[$f]; }
            }
            foreach (['weight', 'height', 'temperature', 'bmi', 'total_fee'] as $f) {
                if (!empty($data[$f])) { $data[$f] = (float)$data[$f]; }
            }

            // ── Hitung BMI otomatis di sisi server juga ───────────────────────
            if (!empty($data['weight']) && !empty($data['height'])) {
                $hm              = $data['height'] / 100;
                $bmi             = round($data['weight'] / ($hm * $hm), 2);
                $data['bmi']     = $bmi;

                if ($bmi < 18.5)      $data['bmi_category'] = 'Underweight';
                elseif ($bmi < 25.0)  $data['bmi_category'] = 'NormalWeight';
                elseif ($bmi < 30.0)  $data['bmi_category'] = 'Overweight';
                else                  $data['bmi_category'] = 'Obese';
            }

            // ── Update status ke in_progress jika masih waiting/called ────────
            if (in_array($visit->status, ['waiting', 'called'])) {
                $data['status']     = 'in_progress';
                $data['start_time'] = date('Y-m-d H:i:s');
            }

            $medicalRecordSaved = $this->saveLegacyEmrToMedicalRecord($visit, $data, $actionsRaw);
            $visit = $this->OutpatientVisits->patchEntity($visit, $this->filterOutpatientVisitUpdateData($data));

            // ── Proses tindakan ───────────────────────────────────────────────
            $actionsToSave = [];
            foreach ($actionsRaw as $actionData) {
                if (empty($actionData['action_name'])) {
                    continue;
                }
                $actionEntity = $this->OutpatientVisits->OutpatientActions->newEmptyEntity();
                $actionEntity->outpatient_visit_id = $visit->id;
                $actionEntity->action_code         = $actionData['action_code']     ?? null;
                $actionEntity->action_name         = $actionData['action_name'];
                $actionEntity->action_category     = $actionData['action_category'] ?? 'tindakan_medis';
                $actionEntity->quantity            = (int)($actionData['quantity']  ?? 1);
                $actionEntity->unit_price          = !empty($actionData['unit_price'])
                    ? (float)$actionData['unit_price'] : null;
                $actionEntity->total_price         = $actionEntity->unit_price
                    ? $actionEntity->unit_price * $actionEntity->quantity : null;
                $actionEntity->notes               = $actionData['notes']        ?? null;
                $actionEntity->performed_by        = $actionData['performed_by'] ?? null;
                $actionsToSave[] = $actionEntity;
            }

            // Hapus tindakan lama lalu simpan ulang
            $this->OutpatientVisits->OutpatientActions->deleteAll([
                'outpatient_visit_id' => $visit->id,
            ]);

            if ($medicalRecordSaved && $this->OutpatientVisits->save($visit)) {
                if (!empty($actionsToSave)) {
                    $this->OutpatientVisits->OutpatientActions->saveMany($actionsToSave);
                }
                $this->Flash->success(__('EMR berhasil disimpan.'));
                return $this->redirect(['action' => 'emr', $visit->id]);
            }

            $err = json_encode($visit->getErrors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $this->Flash->error(__('Gagal menyimpan EMR. Error: ' . $err));
        }

        $this->set(compact('visit', 'emrMeta'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DELETE
    // ─────────────────────────────────────────────────────────────────────────
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $visit = $this->OutpatientVisits->get($id);

        if ($this->OutpatientVisits->delete($visit)) {
            $this->Flash->success(__('Data kunjungan berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Data kunjungan gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    protected function _syncMissingVisitsFromRegistrations(string $dateFrom, string $dateTo): void
    {
        $this->loadModel('Registrations');

        $registrations = $this->Registrations->find()
            ->where([
                'Registrations.service_type' => 'rawat_jalan',
                'Registrations.registration_date >=' => $dateFrom,
                'Registrations.registration_date <=' => $dateTo,
            ])
            ->limit(300)
            ->all();

        foreach ($registrations as $registration) {
            if (empty($registration->id) || empty($registration->patient_id)) {
                continue;
            }

            $this->OutpatientVisits->syncFromRegistration($registration);
        }
    }

    protected function _formatRegistrationDate($date, string $fallback): string
    {
        if (empty($date)) {
            return $fallback;
        }

        if (is_object($date) && method_exists($date, 'format')) {
            return $date->format('Y-m-d');
        }

        return date('Y-m-d', strtotime((string)$date));
    }

    private function hydrateVisitFromLatestMedicalRecord($visit): void
    {
        $registrationId = (int)($visit->registration_id ?? 0);
        if (!$registrationId) {
            return;
        }

        $connection = ConnectionManager::get('default');
        if (!$this->tableHasColumn($connection, 'medical_record_examinations', 'payload_json')) {
            return;
        }

        $sql = 'SELECT mre.payload_json
            FROM medical_record_examinations mre
            INNER JOIN medical_records mr ON mr.id = mre.medical_record_id
            WHERE mr.registration_id = :registration_id
                AND (mr.is_delete = 0 OR mr.is_delete IS NULL)
                AND (mre.is_delete = 0 OR mre.is_delete IS NULL)
                AND mre.payload_json IS NOT NULL
            ORDER BY mre.id DESC
            LIMIT 1';

        $row = $connection->execute($sql, ['registration_id' => $registrationId])->fetch('assoc');
        if (empty($row['payload_json'])) {
            return;
        }

        $payload = json_decode((string)$row['payload_json'], true);
        if (!is_array($payload)) {
            return;
        }

        $associationFields = [
            'outpatient_actions',
            'patient',
            'doctor',
            'registration',
            'polyclinic_queue',
        ];

        foreach ($payload as $field => $value) {
            if (in_array($field, $associationFields, true)) {
                continue;
            }

            $visit->set($field, $value);
        }
    }

    private function readLatestEmrMeta($visit): array
    {
        $registrationId = (int)($visit->registration_id ?? 0);
        if (!$registrationId) {
            return [];
        }

        $connection = ConnectionManager::get('default');
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());
        if (!in_array('medical_records', $tables, true)) {
            return [];
        }

        if (!in_array('medical_record_examinations', $tables, true)) {
            $sql = 'SELECT id AS medical_record_id,
                    status AS medical_record_status,
                    COALESCE(modified, created) AS last_saved
                FROM medical_records
                WHERE registration_id = :registration_id
                    AND (is_delete = 0 OR is_delete IS NULL)
                ORDER BY id DESC
                LIMIT 1';

            return $connection->execute($sql, ['registration_id' => $registrationId])->fetch('assoc') ?: [];
        }

        $sql = 'SELECT mr.id AS medical_record_id,
                mr.status AS medical_record_status,
                mre.id AS examination_id,
                mre.status AS examination_status,
                COALESCE(mre.modified, mre.created, mr.modified, mr.created) AS last_saved
            FROM medical_records mr
            LEFT JOIN medical_record_examinations mre
                ON mre.medical_record_id = mr.id
                AND (mre.is_delete = 0 OR mre.is_delete IS NULL)
            WHERE mr.registration_id = :registration_id
                AND (mr.is_delete = 0 OR mr.is_delete IS NULL)
            ORDER BY mre.id DESC, mr.id DESC
            LIMIT 1';

        return $connection->execute($sql, ['registration_id' => $registrationId])->fetch('assoc') ?: [];
    }

    private function readIntegrationRows($connection, ?int $medicalRecordId): array
    {
        if (!$medicalRecordId || !$this->tableHasColumn($connection, 'medical_record_integrations', 'medical_record_id')) {
            return [];
        }

        return $connection->execute(
            'SELECT *
            FROM medical_record_integrations
            WHERE medical_record_id = :medical_record_id
                AND (is_delete = 0 OR is_delete IS NULL)
            ORDER BY COALESCE(noted_at, created) DESC, id DESC
            LIMIT 100',
            ['medical_record_id' => $medicalRecordId]
        )->fetchAll('assoc');
    }

    private function currentUserData(): array
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity && method_exists($identity, 'getOriginalData')) {
            $identity = $identity->getOriginalData();
        }

        if ($identity && method_exists($identity, 'toArray')) {
            return $identity->toArray();
        }

        if (is_array($identity)) {
            return $identity;
        }

        return [];
    }

    private function hasText($value): bool
    {
        return trim((string)$value) !== '';
    }

    private function saveLegacyEmrToMedicalRecord($visit, array $data, array $actionsRaw): bool
    {
        $registrationId = (int)($visit->registration_id ?? 0);
        if (!$registrationId) {
            return false;
        }

        $connection = ConnectionManager::get('default');

        return (bool)$connection->transactional(function () use ($connection, $registrationId, $data, $actionsRaw) {
            $medicalRecordId = $this->findOrCreateMedicalRecordId($connection, $registrationId);
            if (!$medicalRecordId) {
                return false;
            }

            $payload = $this->buildLegacyEmrPayload($data, $actionsRaw);
            $payloadJson = json_encode($payload, JSON_UNESCAPED_UNICODE);
            $examination = [
                'medical_record_id' => $medicalRecordId,
                'status' => 'Draft',
                'note' => $this->buildLegacyEmrNote($payload),
                'payload_json' => $payloadJson,
                'is_create' => 1,
                'is_update' => 0,
                'is_delete' => 0,
                'is_active' => 'Y',
                'created' => date('Y-m-d H:i:s'),
            ];

            if (!$this->saveOrUpdateLatestDraftDetail($connection, 'medical_record_examinations', $examination)) {
                return false;
            }

            if (!empty($data['prescription_notes'])) {
                $this->saveOrUpdateLatestDraftDetail($connection, 'medical_record_prescriptions', [
                    'medical_record_id' => $medicalRecordId,
                    'status' => 'Draft',
                    'note' => trim((string)$data['prescription_notes']),
                    'is_create' => 1,
                    'is_update' => 0,
                    'is_delete' => 0,
                    'is_active' => 'Y',
                    'created' => date('Y-m-d H:i:s'),
                ]);
            }

            $hasReferral = !empty($data['referral_note'])
                || !empty($data['referral_polyclinic'])
                || !empty($data['referral_doctor']);

            if ($hasReferral) {
                $this->saveOrUpdateLatestDraftDetail($connection, 'medical_record_referrals', [
                    'medical_record_id' => $medicalRecordId,
                    'referral_type' => trim((string)($data['referral_polyclinic'] ?? '')),
                    'note' => trim((string)($data['referral_note'] ?? $data['referral_doctor'] ?? '')),
                    'status' => 'Draft',
                    'is_create' => 1,
                    'is_update' => 0,
                    'is_delete' => 0,
                    'is_active' => 'Y',
                    'created' => date('Y-m-d H:i:s'),
                ]);
            }

            return true;
        });
    }

    private function findOrCreateMedicalRecordId($connection, int $registrationId): ?int
    {
        $row = $connection->execute(
            'SELECT id FROM medical_records
            WHERE registration_id = :registration_id
                AND (is_delete = 0 OR is_delete IS NULL)
            ORDER BY id DESC
            LIMIT 1',
            ['registration_id' => $registrationId]
        )->fetch('assoc');

        if (!empty($row['id'])) {
            return (int)$row['id'];
        }

        $connection->insert('medical_records', [
            'registration_id' => $registrationId,
            'status' => 'Draft',
            'is_create' => 1,
            'is_update' => 0,
            'is_delete' => 0,
            'is_active' => 'Y',
            'created' => date('Y-m-d H:i:s'),
        ]);

        return (int)$connection->execute('SELECT LAST_INSERT_ID() AS id')->fetch('assoc')['id'];
    }

    private function buildLegacyEmrPayload(array $data, array $actionsRaw): array
    {
        $fields = [
                'allergy', 'referral_polyclinic', 'referral_doctor', 'referral_date', 'referral_time',
                'referral_queue_no', 'praktek2', 'referral_inpatient', 'inpatient_referral_no', 'referral_note',
            'bpjs_control_date', 'bpjs_control_notes', 'bpjs_control_plan', 'skdp_notes',
            'diagnosis_primary', 'diagnosis_secondary', 'action_notes',
            'pulse', 'respiratory_rate', 'blood_pressure', 'temperature', 'oxygen_saturation',
            'pain_scale', 'weight', 'height', 'bmi', 'bmi_category',
            'chief_complaint', 'illness_history', 'admission_diagnosis',
            'prescription_notes', 'doctor_notes', 'total_fee',
        ];

        $payload = [];
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $payload[$field] = $data[$field];
            }
        }

        foreach (['icd10_items', 'icd9_items', 'icd10_selected', 'icd10_utama', 'icd10_code', 'icd10_nama', 'icd9_selected', 'icd9_utama', 'icd9_kategori', 'icd9_code', 'icd9_nama'] as $field) {
            if (array_key_exists($field, $data)) {
                $payload[$field] = $data[$field];
            }
        }

        if (!empty($actionsRaw)) {
            $payload['outpatient_actions'] = $actionsRaw;
        }

        return $payload;
    }

    private function normalizeLegacyIcdSelections(array $data): array
    {
        $icd10Items = $this->buildIcdItems(
            (array)($data['icd10_code'] ?? []),
            (array)($data['icd10_nama'] ?? []),
            [],
            (string)($data['icd10_utama'] ?? '')
        );

        $icd9Items = $this->buildIcdItems(
            (array)($data['icd9_code'] ?? []),
            (array)($data['icd9_nama'] ?? []),
            (array)($data['icd9_kategori'] ?? []),
            (string)($data['icd9_utama'] ?? '')
        );

        if (!empty($icd10Items)) {
            $data['icd10_items'] = $icd10Items;
            $primary = $this->firstPrimaryIcdItem($icd10Items);
            if (!$this->hasText($data['diagnosis_primary'] ?? null)) {
                $data['diagnosis_primary'] = $this->formatIcdItemLabel($primary);
            }
            if (!$this->hasText($data['diagnosis_desc'] ?? null)) {
                $data['diagnosis_desc'] = $primary['nama'] ?? null;
            }
        }

        if (!empty($icd9Items)) {
            $data['icd9_items'] = $icd9Items;
        }

        return $data;
    }

    private function buildIcdItems(array $codes, array $names, array $categories, string $primaryIndex): array
    {
        $items = [];

        foreach ($codes as $index => $code) {
            $code = trim((string)$code);
            $name = trim((string)($names[$index] ?? ''));

            if ($code === '' && $name === '') {
                continue;
            }

            $items[] = [
                'kode' => $code,
                'nama' => $name,
                'kategori' => trim((string)($categories[$index] ?? '')),
                'utama' => (string)$index === $primaryIndex,
            ];
        }

        if (!empty($items) && !in_array(true, array_column($items, 'utama'), true)) {
            $items[0]['utama'] = true;
        }

        return $items;
    }

    private function firstPrimaryIcdItem(array $items): array
    {
        foreach ($items as $item) {
            if (!empty($item['utama'])) {
                return $item;
            }
        }

        return $items[0] ?? [];
    }

    private function formatIcdItemLabel(array $item): ?string
    {
        $code = trim((string)($item['kode'] ?? ''));
        $name = trim((string)($item['nama'] ?? ''));

        if ($code !== '' && $name !== '') {
            return $code . ' - ' . $name;
        }

        return $code !== '' ? $code : ($name !== '' ? $name : null);
    }

    private function buildLegacyEmrNote(array $payload): string
    {
        $blocks = [
            'Keluhan Awal' => $payload['chief_complaint'] ?? null,
            'Pemeriksaan' => $payload['illness_history'] ?? null,
            'Diagnosa Saat Masuk' => $payload['admission_diagnosis'] ?? null,
            'Diagnosa Utama' => $payload['diagnosis_primary'] ?? null,
            'Diagnosa Sekunder' => $payload['diagnosis_secondary'] ?? null,
            'Tindakan Utama' => $payload['action_notes'] ?? null,
            'Obat / Resep' => $payload['prescription_notes'] ?? null,
            'Saran / Anjuran' => $payload['doctor_notes'] ?? null,
            'Alergi' => $payload['allergy'] ?? null,
        ];

        $vitals = [
            'Tekanan darah' => $payload['blood_pressure'] ?? null,
            'Nadi' => $payload['pulse'] ?? null,
            'Respirasi' => $payload['respiratory_rate'] ?? null,
            'Suhu' => $payload['temperature'] ?? null,
            'SpO2' => $payload['oxygen_saturation'] ?? null,
            'BB' => $payload['weight'] ?? null,
            'TB' => $payload['height'] ?? null,
            'Skala nyeri' => $payload['pain_scale'] ?? null,
        ];

        $lines = ['EMR Rawat Jalan'];
        foreach ($vitals as $label => $value) {
            $value = trim((string)$value);
            if ($value !== '') {
                $lines[] = $label . ': ' . $value;
            }
        }

        foreach ($blocks as $label => $value) {
            $value = trim((string)$value);
            if ($value !== '') {
                $lines[] = "\n" . $label . ":\n" . $value;
            }
        }

        if (!empty($payload['icd10_items']) && is_array($payload['icd10_items'])) {
            $lines[] = "\nICD-10:\n" . $this->formatIcdItemsForNote($payload['icd10_items']);
        }

        if (!empty($payload['icd9_items']) && is_array($payload['icd9_items'])) {
            $lines[] = "\nICD-9 CM:\n" . $this->formatIcdItemsForNote($payload['icd9_items']);
        }

        return trim(implode("\n", $lines));
    }

    private function formatIcdItemsForNote(array $items): string
    {
        $lines = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $label = $this->formatIcdItemLabel($item);
            if ($label === null) {
                continue;
            }

            $lines[] = !empty($item['utama']) ? '* ' . $label : '- ' . $label;
        }

        return implode("\n", $lines);
    }

    private function filterOutpatientVisitUpdateData(array $data): array
    {
        $allowed = [
            'status',
            'start_time',
            'end_time',
            'total_fee',
        ];

        return array_intersect_key($data, array_flip($allowed));
    }

    private function insertSchemaAware($connection, string $table, array $data): bool
    {
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());
        if (!in_array(strtolower($table), $tables, true)) {
            return true;
        }

        $schema = $connection->getSchemaCollection()->describe($table);
        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });
        $data = array_intersect_key($data, array_flip($schema->columns()));

        if (empty($data)) {
            return true;
        }

        if ($this->isRecentDuplicateDetail($connection, $table, $data, $schema)) {
            return true;
        }

        return (bool)$connection->insert($table, $data);
    }

    private function saveOrUpdateLatestDraftDetail($connection, string $table, array $data): bool
    {
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());
        if (!in_array(strtolower($table), $tables, true)) {
            return true;
        }

        $schema = $connection->getSchemaCollection()->describe($table);
        if (empty($data['medical_record_id']) || !$schema->hasColumn('medical_record_id')) {
            return true;
        }

        $statusCondition = $schema->hasColumn('status')
            ? ' AND (`status` = :status OR `status` IS NULL)'
            : '';
        $deleteCondition = $schema->hasColumn('is_delete')
            ? ' AND (`is_delete` = 0 OR `is_delete` IS NULL)'
            : '';
        $params = [
            'medical_record_id' => (int)$data['medical_record_id'],
        ];
        if ($schema->hasColumn('status')) {
            $params['status'] = $data['status'] ?? 'Draft';
        }

        $sql = 'SELECT `id` FROM `' . $table . '`
            WHERE `medical_record_id` = :medical_record_id
                ' . $statusCondition . '
                ' . $deleteCondition . '
            ORDER BY `id` DESC
            LIMIT 1';
        $existing = $connection->execute($sql, $params)->fetch('assoc');

        if (!$existing) {
            return $this->insertSchemaAware($connection, $table, $data);
        }

        $update = $data;
        unset($update['id'], $update['medical_record_id'], $update['created'], $update['is_create']);
        $update['is_update'] = 1;
        $update['modified'] = date('Y-m-d H:i:s');
        $update = array_filter($update, function ($value) {
            return $value !== null && $value !== '';
        });
        $update = array_intersect_key($update, array_flip($schema->columns()));

        if (empty($update)) {
            return true;
        }

        return (bool)$connection->update($table, $update, ['id' => (int)$existing['id']]);
    }

    private function isRecentDuplicateDetail($connection, string $table, array $data, $schema): bool
    {
        if (empty($data['medical_record_id']) || !$schema->hasColumn('created')) {
            return false;
        }

        $compareColumn = null;
        if (!empty($data['payload_json']) && $schema->hasColumn('payload_json')) {
            $compareColumn = 'payload_json';
        } elseif (!empty($data['note']) && $schema->hasColumn('note')) {
            $compareColumn = 'note';
        }

        if ($compareColumn === null) {
            return false;
        }

        $conditions = [
            'medical_record_id' => (int)$data['medical_record_id'],
            'compare_value' => (string)$data[$compareColumn],
        ];

        $deleteCondition = $schema->hasColumn('is_delete')
            ? ' AND (`is_delete` = 0 OR `is_delete` IS NULL)'
            : '';

        $sql = 'SELECT id FROM `' . $table . '`
            WHERE `medical_record_id` = :medical_record_id
                AND `' . $compareColumn . '` = :compare_value
                ' . $deleteCondition . '
                AND `created` >= DATE_SUB(NOW(), INTERVAL 30 SECOND)
            ORDER BY `id` DESC
            LIMIT 1';

        return (bool)$connection->execute($sql, $conditions)->fetch('assoc');
    }

    private function tableHasColumn($connection, string $table, string $column): bool
    {
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());
        if (!in_array(strtolower($table), $tables, true)) {
            return false;
        }

        return $connection->getSchemaCollection()->describe($table)->hasColumn($column);
    }
}
