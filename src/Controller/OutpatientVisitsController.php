<?php

declare(strict_types=1);

namespace App\Controller;

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
                'OutpatientVisits.room_name LIKE'           => '%' . $q . '%',
            ];
        }

        $this->paginate = [
            'contain'    => ['Patients', 'Doctors', 'Registrations' => ['Rooms']],
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

// ── No Rekam Medis: ambil dari tabel MedicalRecords berdasarkan registration_id ──
$medicalRecordsByRegistration = [];
$registrationIds = [];
foreach ($visits as $v) {
    if (!empty($v->registration_id)) {
        $registrationIds[] = $v->registration_id;
    }
}
$registrationIds = array_unique($registrationIds);

if (!empty($registrationIds)) {
    try {
        $this->loadModel('MedicalRecords');
        $mrRows = $this->MedicalRecords->find()
            ->where(['registration_id IN' => $registrationIds])
            ->all();
        foreach ($mrRows as $mr) {
            $medicalRecordsByRegistration[$mr->registration_id] = $mr;
        }
    } catch (\Throwable $e) {
        $medicalRecordsByRegistration = [];
    }
}

$this->set(compact(
    'visits', 'summary', 'poliList', 'doctors',
    'filterDateFrom', 'filterDateTo',
    'filterPoli', 'filterDoctor', 'filterStatus', 'q',
    'medicalRecordsByRegistration'
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
                'doctor_id', 'queue_number', 'polyclinic_name', 'room_name',
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

            // Nomor antrian rawat jalan otomatis per hari.
            // Data pertama hari ini = 1, berikutnya 2, 3, 4, dst.
            // Besok otomatis reset lagi karena filter berdasarkan visit_date.
            if (empty($data['queue_number'])) {
                $lastQueue = $this->OutpatientVisits->find()
                    ->select(['queue_number'])
                    ->where([
                        'OutpatientVisits.visit_date' => $data['visit_date'],
                        'OutpatientVisits.queue_number IS NOT' => null,
                    ])
                    ->order(['OutpatientVisits.queue_number' => 'DESC'])
                    ->first();

                $data['queue_number'] = $lastQueue && !empty($lastQueue->queue_number)
                    ? ((int)$lastQueue->queue_number + 1)
                    : 1;
            }

            // Kalau ruang belum keisi di outpatient_visits, ambil dari data registrasi.
            if (empty($data['room_name']) && !empty($registration)) {
                $data['room_name'] = $registration->room_name ?? null;
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
                'doctor_id', 'queue_number', 'polyclinic_name', 'room_name',
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
    // CPPT — Tampilan seperti aplikasi lama: input SOAP/SBAR + instruksi + riwayat
    // ─────────────────────────────────────────────────────────────────────────
    public function cppt($id = null)
    {
        if (empty($id)) {
            $this->Flash->error(__('ID kunjungan tidak ditemukan.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('OutpatientCpptNotes');

        $visit = $this->OutpatientVisits->get($id, [
            'contain' => ['Patients', 'Doctors', 'Registrations', 'OutpatientActions'],
        ]);

        $cpptNotes = $this->OutpatientCpptNotes->find()
            ->where(['outpatient_visit_id' => $visit->id])
            ->order(['noted_at' => 'ASC', 'id' => 'ASC'])
            ->all();

        $this->set(compact('visit', 'cpptNotes'));
    }

    public function addCppt($id = null)
    {
        $this->request->allowMethod(['post']);

        if (empty($id)) {
            $this->Flash->error(__('ID kunjungan tidak ditemukan.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('OutpatientCpptNotes');

        $visit = $this->OutpatientVisits->get($id);
        $data  = $this->request->getData();

        $assessmentText = trim((string)($data['assessment_text'] ?? ''));
        $instruction    = trim((string)($data['instruction'] ?? ''));

        if ($assessmentText === '' && $instruction === '') {
            $this->Flash->error(__('Asesmen atau instruksi wajib diisi.'));
            return $this->redirect(['action' => 'cppt', $id]);
        }

        $note = $this->OutpatientCpptNotes->newEmptyEntity();

        $noteData = [
            'outpatient_visit_id' => $visit->id,
            'registration_id'     => $visit->registration_id ?? null,
            'patient_id'          => $visit->patient_id ?? null,
            'doctor_id'           => !empty($data['doctor_id']) ? (int)$data['doctor_id'] : ($visit->doctor_id ?? null),
            'noted_at'            => !empty($data['noted_at'])
                ? str_replace('T', ' ', $data['noted_at']) . ':00'
                : date('Y-m-d H:i:s'),
            'health_worker_name'  => $data['health_worker_name'] ?? null,
            'doctor_name'         => $data['doctor_name'] ?? null,
            'nurse_name'          => $data['nurse_name'] ?? null,
            'assessment_text'     => $assessmentText,
            'instruction'         => $instruction,
            'created_by'          => $this->request->getSession()->read('Auth.User.username') ?? null,
        ];

        $note = $this->OutpatientCpptNotes->patchEntity($note, $noteData);

        if ($this->OutpatientCpptNotes->save($note)) {
            if (in_array($visit->status, ['waiting', 'called'])) {
                $visit->status = 'in_progress';
                if (empty($visit->start_time)) {
                    $visit->start_time = date('Y-m-d H:i:s');
                }
               $this->OutpatientVisits->save($visit);
        }

        $this->Flash->success(__('CPPT berhasil ditambahkan.'));
        } else {
            $err = json_encode($note->getErrors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $this->Flash->error(__('Gagal menyimpan CPPT. Error: ' . $err));
        }

        return $this->redirect(['action' => 'cppt', $id]);
    }
    public function deleteCppt($noteId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->loadModel('OutpatientCpptNotes');

        $note = $this->OutpatientCpptNotes->get($noteId);
        $visitId = $note->outpatient_visit_id;

        if ($this->OutpatientCpptNotes->delete($note)) {
            $this->Flash->success(__('Catatan CPPT berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Catatan CPPT gagal dihapus.'));
        }

        return $this->redirect(['action' => 'cppt', $visitId]);
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
            $this->Flash->success(__('Kunjungan ditandai selesai.'));
        } else {
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

        if (!in_array($visit->status, ['waiting', 'called'])) {
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
// DATANG — Tandai pasien sudah datang setelah dipanggil (status → in_progress)
// ─────────────────────────────────────────────────────────────────────────
public function datang($id = null)
{
    $this->request->allowMethod(['post']);

    $visit = $this->OutpatientVisits->get($id);

    if (!in_array($visit->status, ['called', 'waiting'])) {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Status tidak valid untuk ditandai datang']));
        }
        $this->Flash->error(__('Status pasien tidak valid.'));
        return $this->redirect(['action' => 'index']);
    }

    $visit->status = 'in_progress';
    if (empty($visit->start_time)) {
        $visit->start_time = date('Y-m-d H:i:s');
    }

    $saved = $this->OutpatientVisits->save($visit);

    if ($this->request->is('ajax')) {
        $this->autoRender = false;
        return $this->response->withType('application/json')
            ->withStringBody(json_encode([
                'success'  => (bool)$saved,
                'message'  => $saved ? 'Pasien sudah datang, status diperbarui' : 'Gagal memperbarui status pasien',
                'visit_id' => $visit->id,
                'status'   => $visit->status,
            ]));
    }

    if ($saved) {
        $this->Flash->success(__('Status pasien diperbarui.'));
    } else {
        $this->Flash->error(__('Gagal memperbarui status pasien.'));
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
            $this->Flash->success(__('Kunjungan dibatalkan.'));
        } else {
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
    // RESUME MEDIS — Ringkasan medis rawat jalan
    // Data auto-fill diambil dari OutpatientVisitEmr (data yang sudah diisi
    // dokter di halaman EMR), bukan dari input manual di resume ini.
    // ─────────────────────────────────────────────────────────────────────────
    public function resumeMedis($id = null)
    {
        if (empty($id)) {
            $this->Flash->error(__('ID kunjungan rawat jalan tidak ditemukan.'));
            return $this->redirect(['action' => 'index']);
        }

        $visit = $this->OutpatientVisits->get($id, [
            'contain' => [
                'Patients',
                'Doctors',
                'Registrations',
                'OutpatientActions',
            ],
        ]);

        // ── Ambil data EMR yang sudah diisi dokter — inilah sumber auto-fill ──
        // Sebelumnya variabel $emr dipakai di bawah (ICD, obat, prognosis, dll)
        // dan juga di view resume_medis.php, tapi tidak pernah diquery di sini,
        // sehingga semua field yang seharusnya auto-fill dari EMR selalu kosong.
        $this->loadModel('OutpatientVisitEmr');

        $emr = $this->OutpatientVisitEmr->find()
            ->where(['outpatient_visit_id' => $visit->id])
            ->first();

        if (!$emr) {
            $emr = $this->OutpatientVisitEmr->newEmptyEntity();
            $emr->outpatient_visit_id = $visit->id;
        }

        // Resume medis tetap bisa dibuka walaupun tabel MedicalResumes belum ada.
        $medicalResume = null;
        try {
            $this->loadModel('MedicalResumes');

            $medicalResume = $this->MedicalResumes->find()
                ->where(['outpatient_visit_id' => $visit->id])
                ->first();

            if (!$medicalResume) {
                $medicalResume = $this->MedicalResumes->newEmptyEntity();
                $medicalResume->outpatient_visit_id = $visit->id;
                $medicalResume->registration_id = $visit->registration_id ?? null;
                $medicalResume->patient_id = $visit->patient_id ?? null;
            }

            if ($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();

                $data['outpatient_visit_id'] = $visit->id;
                $data['registration_id']     = $visit->registration_id ?? null;
                $data['patient_id']          = $visit->patient_id ?? null;
                $data['doctor1_id']          = $visit->doctor_id ?? null;

                foreach (['print_classic', 'send_digital_claim'] as $flag) {
                    $data[$flag] = !empty($data[$flag]) ? 1 : 0;
                }

                $medicalResume = $this->MedicalResumes->patchEntity($medicalResume, $data);

                if ($this->MedicalResumes->save($medicalResume)) {
                    $this->Flash->success(__('Resume medis berhasil disimpan.'));
                    return $this->redirect(['action' => 'resumeMedis', $visit->id]);
                }

                $err = json_encode($medicalResume->getErrors(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                $this->Flash->error(__('Gagal menyimpan resume medis. Error: ' . $err));
            }
        } catch (\Throwable $e) {
            $medicalResume = null;
        }

        // Normalisasi ICD: hanya tampilkan data yang berasal dari pilihan ICD master.
        // Data manual seperti Diagnosa Utama/Tindakan Utama tidak dipakai untuk tabel ICD.
        $normalizeIcdItems = function ($rawItems) {
            $items = [];

            if (empty($rawItems)) {
                return $items;
            }

            if (is_string($rawItems)) {
                $decoded = json_decode($rawItems, true);
                $rawItems = is_array($decoded) ? $decoded : [];
            }

            foreach ((array)$rawItems as $item) {
                if (is_object($item)) {
                    $item = (array)$item;
                }

                $kode = trim((string)(
                    $item['kode'] ??
                    $item['code'] ??
                    $item['icd_code'] ??
                    $item['icd10_code'] ??
                    $item['icd9_code'] ??
                    ''
                ));

                $nama = trim((string)(
                    $item['nama'] ??
                    $item['name'] ??
                    $item['diagnosa'] ??
                    $item['diagnosis'] ??
                    $item['description'] ??
                    $item['diagnosis_name'] ??
                    $item['icd_name'] ??
                    $item['action_name'] ??
                    $item['title'] ??
                    ''
                ));

                // Syarat agar dianggap dari master: kode dan nama harus sama-sama ada.
                // Kalau hanya ada tulisan manual, jangan tampilkan di Resume Medis.
                if ($kode === '' || $nama === '') {
                    continue;
                }

                $items[] = [
                    'kode'  => $kode,
                    'nama'  => $nama,
                    'utama' => !empty($item['utama']) || !empty($item['is_primary']) ? 1 : 0,
                ];
            }

            if (!empty($items)) {
                $hasPrimary = false;
                foreach ($items as $row) {
                    if (!empty($row['utama'])) {
                        $hasPrimary = true;
                        break;
                    }
                }
                if (!$hasPrimary) {
                    $items[0]['utama'] = 1;
                }
            }

            return $items;
        };

        $icd10Items = $normalizeIcdItems($emr->icd10_items ?? []);
        $icd9Items  = $normalizeIcdItems($emr->icd9_items ?? []);

        // Obat/Terapi lanjutan hanya ambil dari order resep/master obat, bukan dari Tindakan & Tarif.
        $medicineItems = [];

        $appendMedicine = function ($rx) use (&$medicineItems) {
            $medicine = $rx->medicine ?? null;

            $name = trim((string)(
                $rx->medicine_name ??
                $rx->drug_name ??
                $rx->nama_obat ??
                $rx->name ??
                $rx->item_name ??
                $rx->prescription_name ??
                ($medicine->medicine_name ?? null) ??
                ($medicine->name ?? null) ??
                ($medicine->generic_name ?? null) ??
                ''
            ));

            if ($name === '') {
                return;
            }

            $medicineItems[] = [
                'name'  => $name,
                'qty'   => $rx->quantity ?? $rx->qty ?? '',
                'dose'  => $rx->dose ?? $rx->dosis ?? '',
                'route' => $rx->route ?? $rx->cara_pemberian ?? $rx->instruction ?? $rx->notes ?? '',
            ];
        };

        // Cara 1: lewat Orders -> OrderPrescriptions -> Medicines
        try {
            $this->loadModel('Orders');

            $ordersQuery = $this->Orders->find();

            if (!empty($visit->registration_id)) {
                $ordersQuery->where(['Orders.registration_id' => $visit->registration_id]);
            } elseif (!empty($visit->registration_no)) {
                $ordersQuery->where(['Orders.registration_no' => $visit->registration_no]);
            } else {
                $ordersQuery->where(['Orders.patient_id' => $visit->patient_id]);
            }

            try {
                $ordersQuery->contain(['OrderPrescriptions' => ['Medicines']]);
            } catch (\Throwable $e) {
                try {
                    $ordersQuery->contain(['OrderPrescriptions']);
                } catch (\Throwable $e2) {
                }
            }

            foreach ($ordersQuery->all() as $order) {
                foreach (($order->order_prescriptions ?? []) as $rx) {
                    $appendMedicine($rx);
                }
            }
        } catch (\Throwable $e) {
        }

        // Cara 2: langsung dari OrderPrescriptions kalau asosiasi Orders belum jalan.
        if (empty($medicineItems)) {
            try {
                $this->loadModel('OrderPrescriptions');

                $rxQuery = $this->OrderPrescriptions->find();

                if (!empty($visit->registration_id)) {
                    $rxQuery->where(['OrderPrescriptions.registration_id' => $visit->registration_id]);
                } elseif (!empty($visit->registration_no)) {
                    $rxQuery->where(['OrderPrescriptions.registration_no' => $visit->registration_no]);
                } else {
                    $rxQuery->where(['OrderPrescriptions.patient_id' => $visit->patient_id]);
                }

                try {
                    $rxQuery->contain(['Medicines']);
                } catch (\Throwable $e) {
                }

                foreach ($rxQuery->all() as $rx) {
                    $appendMedicine($rx);
                }
            } catch (\Throwable $e) {
            }
        }


        // Fallback terakhir: kalau belum ada tabel resep/order, ambil dari prescription_notes agar tidak kosong.
        // Nanti kalau order resep sudah tersambung penuh, bagian ini tetap aman karena hanya jalan saat medicineItems kosong.
        if (empty($medicineItems) && !empty($emr->prescription_notes)) {
            $lines = preg_split('/\r\n|\r|\n/', (string)$emr->prescription_notes);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line !== '') {
                    $medicineItems[] = [
                        'name'  => $line,
                        'qty'   => '',
                        'dose'  => '',
                        'route' => '',
                    ];
                }
            }
        }

        $this->set(compact('visit', 'emr', 'medicalResume', 'icd10Items', 'icd9Items', 'medicineItems'));
    }

    public function emr($id = null)
    {
        return $this->redirect([
            'controller' => 'OutpatientVisitEmr',
            'action' => 'emr',
            $id,
        ]);
    }


    public function searchIcd10()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $rows = [];

        if ($q !== '') {
            try {
                $this->loadModel('MasterIcd10');
                $query = $this->MasterIcd10->find()
                    ->select(['id', 'kode', 'nama'])
                    ->where([
                        'MasterIcd10.is_active' => 1,
                        'OR' => [
                            'MasterIcd10.kode LIKE' => '%' . $q . '%',
                            'MasterIcd10.nama LIKE' => '%' . $q . '%',
                        ],
                    ])
                    ->order(['MasterIcd10.kode' => 'ASC'])
                    ->limit(20)
                    ->enableHydration(false)
                    ->toArray();

                foreach ($query as $row) {
                    $rows[] = [
                        'id' => $row['id'] ?? null,
                        'kode' => $row['kode'] ?? '',
                        'nama' => $row['nama'] ?? '',
                    ];
                }
            } catch (\Throwable $e) {
                $rows = [];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'results' => $rows], JSON_UNESCAPED_UNICODE));
    }

    public function searchIcd9()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q', ''));
        $rows = [];

        if ($q !== '') {
            try {
                $this->loadModel('MasterIcd9');
                $query = $this->MasterIcd9->find()
                    ->select(['id', 'kode', 'nama'])
                    ->where([
                        'MasterIcd9.is_active' => 1,
                        'OR' => [
                            'MasterIcd9.kode LIKE' => '%' . $q . '%',
                            'MasterIcd9.nama LIKE' => '%' . $q . '%',
                        ],
                    ])
                    ->order(['MasterIcd9.kode' => 'ASC'])
                    ->limit(20)
                    ->enableHydration(false)
                    ->toArray();

                foreach ($query as $row) {
                    $rows[] = [
                        'id' => $row['id'] ?? null,
                        'kode' => $row['kode'] ?? '',
                        'nama' => $row['nama'] ?? '',
                    ];
                }
            } catch (\Throwable $e) {
                $rows = [];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'results' => $rows], JSON_UNESCAPED_UNICODE));
    }

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

    public function selesaiPeriksa($id = null)
    {
        $this->request->allowMethod(['post']);
    
        $this->loadModel('OutpatientBillings');
        $this->loadModel('OutpatientBillingItems');
    
        $visit = $this->OutpatientVisits->get($id, [
            'contain' => [
                'Patients',
                'Doctors',
                'Registrations',
                'OutpatientActions',
            ],
        ]);
    
        $existing = $this->OutpatientBillings->find()
            ->where(['outpatient_visit_id' => $visit->id])
            ->first();
    
        if ($existing) {
            $this->Flash->success('Pemeriksaan sudah selesai. Tagihan sudah ada.');
            return $this->redirect([
                'controller' => 'OutpatientBillings',
                'action' => 'kasir',
                $existing->id,
            ]);
        }
    
        $conn = $this->OutpatientBillings->getConnection();
        $billingId = null;
    
        $conn->transactional(function () use ($visit, &$billingId) {
    
            $subtotal = 0;
            $itemsData = [];
    
            foreach ($visit->outpatient_actions ?? [] as $action) {
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
                    'item_name' => $action->action_name ?? 'Tindakan',
                    'quantity' => $qty,
                    'unit' => null,
                    'unit_price' => $price,
                    'total_price' => $total,
                    'discount_amount' => 0,
                    'final_price' => $total,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                ];
            }
    
            $billing = $this->OutpatientBillings->newEntity([
                'billing_no' => 'RJ-' . date('YmdHis') . '-' . $visit->id,
                'outpatient_visit_id' => $visit->id,
                'registration_id' => $visit->registration_id ?? null,
                'patient_id' => $visit->patient_id ?? null,
                'doctor_id' => $visit->doctor_id ?? null,
                'visit_date' => $visit->visit_date ?? date('Y-m-d'),
                'polyclinic_name' => $visit->polyclinic_name ?? null,
                'insurance_type' => $visit->insurance_type ?? 'Umum',
                'subtotal' => $subtotal,
                'discount_type' => 'nominal',
                'discount_value' => 0,
                'discount_amount' => 0,
                'grand_total' => $subtotal,
                'paid_amount' => 0,
                'change_amount' => 0,
                'status' => 'waiting_payment',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ]);
    
            if (!$this->OutpatientBillings->save($billing)) {
                throw new \Exception('Gagal membuat billing.');
            }
    
            $billingId = $billing->id;
    
            foreach ($itemsData as $row) {
                $row['billing_id'] = $billing->id;
                $item = $this->OutpatientBillingItems->newEntity($row);
    
                if (!$this->OutpatientBillingItems->save($item)) {
                    throw new \Exception('Gagal menyimpan item billing.');
                }
            }
    
            $visit->status = 'done';
            $visit->end_time = date('Y-m-d H:i:s');
    
            if (!$this->OutpatientVisits->save($visit)) {
                throw new \Exception('Gagal update status pemeriksaan.');
            }
        });
    
        $this->Flash->success('Pemeriksaan selesai. Tagihan berhasil dibuat.');
    
        return $this->redirect([
            'controller' => 'OutpatientBillings',
            'action' => 'kasir',
            $billingId,
        ]);
    }

    public function hasilPemeriksaan($id = null)
{
    if (empty($id)) {
        $this->Flash->error(__('ID kunjungan tidak ditemukan.'));
        return $this->redirect(['action' => 'index']);
    }

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

    public function getSuratSakit($id = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
        $this->loadModel('OutpatientLetters');

        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => (int)$id,
                'letter_type' => 'sakit',
            ])
            ->first();

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'data'    => $letter ? [
                'letter_id'      => $letter->id,
                'letter_no'      => $letter->letter_no,
                'weight'         => $letter->weight,
                'height'         => $letter->height,
                'blood_pressure' => $letter->blood_pressure,
                'temperature'    => $letter->temperature,
                'color_blind'    => $letter->color_blind,
                'blood_type'     => $letter->blood_type,
                'leave_days'     => $letter->leave_days,
                'leave_from'     => $letter->leave_from ? (string)$letter->leave_from : null,
                'leave_to'       => $letter->leave_to ? (string)$letter->leave_to : null,
                'diagnosis'      => $letter->diagnosis,
                'is_normal'      => (int)$letter->is_normal,
            ] : null,
        ]));
    }

    public function simpanSuratSakit($id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;
        $this->loadModel('OutpatientLetters');

        $visit = $this->OutpatientVisits->get($id);
        $data  = $this->request->getData();

        // Cari surat yang sudah ada untuk kunjungan ini (kalau ada, akan di-update, bukan bikin baru)
        $entity = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'sakit',
            ])
            ->first();

        $isNew = false;
        if (!$entity) {
            $isNew = true;
            $entity = $this->OutpatientLetters->newEmptyEntity();
            $entity->outpatient_visit_id = $visit->id;
            $entity->registration_id     = $visit->registration_id ?? null;
            $entity->patient_id          = $visit->patient_id ?? null;
            $entity->doctor_id           = $visit->doctor_id ?? null;
            $entity->letter_type         = 'sakit';
            $entity->letter_no           = 'SKS-' . date('Ymd') . '-' . str_pad((string)$visit->id, 5, '0', STR_PAD_LEFT);
        }

        // Field boleh kosong — tidak wajib diisi semua.
        // Kalau field tidak dikirim / kosong, tetap disimpan sebagai kosong (bukan gagal).
        $fields = [
            'weight'         => $data['weight'] ?? null,
            'height'         => $data['height'] ?? null,
            'blood_pressure' => $data['blood_pressure'] ?? null,
            'temperature'    => $data['temperature'] ?? null,
            'color_blind'    => $data['color_blind'] ?? null,
            'blood_type'     => $data['blood_type'] ?? null,
            'leave_days'     => $data['leave_days'] ?? null,
            'leave_from'     => !empty($data['leave_from']) ? $data['leave_from'] : null,
            'leave_to'       => !empty($data['leave_to']) ? $data['leave_to'] : null,
            'diagnosis'      => $data['diagnosis'] ?? null,
            'is_normal'      => !empty($data['is_normal']) ? 1 : 0,
            'examined_at'    => !empty($data['examined_at']) ? $data['examined_at'] : date('Y-m-d'),
        ];

        $entity = $this->OutpatientLetters->patchEntity($entity, $fields, [
            'validate' => false, // supaya field kosong tidak dianggap error
        ]);

        if ($this->OutpatientLetters->save($entity)) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success'   => true,
                'is_new'    => $isNew,
                'letter_id' => $entity->id,
                'letter_no' => $entity->letter_no,
            ]));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan surat.',
            'errors'  => $entity->getErrors(),
        ]));
    }
}
