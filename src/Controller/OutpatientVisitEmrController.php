<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OutpatientVisitEmr Controller
 *
 * @property \App\Model\Table\OutpatientVisitEmrTable $OutpatientVisitEmr
 * @method \App\Model\Entity\OutpatientVisitEmr[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutpatientVisitEmrController extends AppController
{
    // ─────────────────────────────────────────────────────────────────────────
    // EMR — Electronic Medical Record
    // $id di sini adalah outpatient_visit_id (bukan id tabel outpatient_visit_emr)
    // ─────────────────────────────────────────────────────────────────────────
    public function emr($id = null)
    {
        if (empty($id)) {
            $this->Flash->error(__('ID kunjungan rawat jalan tidak ditemukan.'));
            return $this->redirect(['controller' => 'OutpatientVisits', 'action' => 'index']);
        }

        $this->loadModel('OutpatientVisits');

        $visit = $this->OutpatientVisits->get($id, [
            'contain' => [
                'Patients',
                'Doctors',
                'Registrations',
                'OutpatientActions',
            ],
        ]);

        // ── Cari data EMR yang sudah ada untuk kunjungan ini, atau siapkan baru ──
        $emr = $this->OutpatientVisitEmr->find()
            ->where(['outpatient_visit_id' => $visit->id])
            ->first();

        if (!$emr) {
            $emr = $this->OutpatientVisitEmr->newEmptyEntity();
            $emr->outpatient_visit_id = $visit->id;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // ── Pisahkan tindakan dari data utama (tindakan tetap milik OutpatientVisits/OutpatientActions) ──
            $actionsRaw = $data['outpatient_actions'] ?? [];
            unset($data['outpatient_actions']);

            $schema = $this->OutpatientVisitEmr->getSchema();

            // ── ICD-10 ────────────────────────────────────────────────────────
            $icd10Items = [];
            $icd10Codes = $data['icd10_code'] ?? [];
            $icd10Names = $data['icd10_nama'] ?? ($data['icd10_name'] ?? []);
            $icd10Utama = $data['icd10_utama'] ?? null;

            if (is_array($icd10Codes) || is_array($icd10Names)) {
                $maxIcd10 = max(count((array)$icd10Codes), count((array)$icd10Names));
                for ($i = 0; $i < $maxIcd10; $i++) {
                    $kode = trim((string)($icd10Codes[$i] ?? ''));
                    $nama = trim((string)($icd10Names[$i] ?? ''));
                    if ($kode === '' && $nama === '') {
                        continue;
                    }
                    $isUtama = is_array($icd10Utama)
                        ? !empty($icd10Utama[$i])
                        : ((string)$icd10Utama === (string)$i);
                    $icd10Items[] = [
                        'kode'  => $kode,
                        'nama'  => $nama,
                        'utama' => $isUtama ? 1 : 0,
                    ];
                }
            }

            $icd10Json = null;
            if ($schema->hasColumn('icd10_items')) {
                $icd10Json = !empty($icd10Items)
                    ? json_encode($icd10Items, JSON_UNESCAPED_UNICODE)
                    : null;
                $data['icd10_items'] = $icd10Json;
            }
            unset($data['icd10_selected'], $data['icd10_code'], $data['icd10_nama'], $data['icd10_name'], $data['icd10_utama']);

            // ── ICD-9 ─────────────────────────────────────────────────────────
            $icd9Items = [];
            $icd9Codes = $data['icd9_code'] ?? [];
            $icd9Names = $data['icd9_nama'] ?? ($data['icd9_name'] ?? []);
            $icd9Utama = $data['icd9_utama'] ?? null;

            if (is_array($icd9Codes) || is_array($icd9Names)) {
                $maxIcd9 = max(count((array)$icd9Codes), count((array)$icd9Names));
                for ($i = 0; $i < $maxIcd9; $i++) {
                    $kode = trim((string)($icd9Codes[$i] ?? ''));
                    $nama = trim((string)($icd9Names[$i] ?? ''));
                    if ($kode === '' && $nama === '') {
                        continue;
                    }
                    $isUtama = is_array($icd9Utama)
                        ? !empty($icd9Utama[$i])
                        : ((string)$icd9Utama === (string)$i);
                    $icd9Items[] = [
                        'kode'  => $kode,
                        'nama'  => $nama,
                        'utama' => $isUtama ? 1 : 0,
                    ];
                }
            }

            $icd9Json = null;
            if ($schema->hasColumn('icd9_items')) {
                $icd9Json = !empty($icd9Items)
                    ? json_encode($icd9Items, JSON_UNESCAPED_UNICODE)
                    : null;
                $data['icd9_items'] = $icd9Json;
            }
            unset($data['icd9_selected'], $data['icd9_code'], $data['icd9_nama'], $data['icd9_name'], $data['icd9_utama'], $data['icd9_kategori']);

            // ── Nullable fields ───────────────────────────────────────────────
            $nullableFields = [
                'blood_pressure', 'pulse', 'temperature', 'respiratory_rate',
                'oxygen_saturation', 'weight', 'height', 'bmi', 'bmi_category',
                'pain_scale', 'chief_complaint', 'illness_history', 'allergy',
                'diagnosis_primary', 'diagnosis_secondary', 'diagnosis_desc',
                'admission_diagnosis', 'action_notes', 'doctor_notes', 'prescription_notes',
                'follow_up_date', 'referral_to', 'referral_reason',
            ];

            foreach ($nullableFields as $field) {
                if (isset($data[$field]) && $data[$field] === '') {
                    $data[$field] = null;
                }
            }

            // ── Cast tipe ─────────────────────────────────────────────────────
            foreach (['pain_scale', 'pulse', 'respiratory_rate', 'oxygen_saturation'] as $f) {
                if (!empty($data[$f])) {
                    $data[$f] = (int)$data[$f];
                }
            }
            foreach (['weight', 'height', 'temperature', 'bmi', 'total_fee'] as $f) {
                if (!empty($data[$f])) {
                    $data[$f] = (float)$data[$f];
                }
            }

            // ── Hitung BMI otomatis di server ─────────────────────────────────
            if (!empty($data['weight']) && !empty($data['height'])) {
                $hm  = $data['height'] / 100;
                $bmi = round($data['weight'] / ($hm * $hm), 2);
                $data['bmi'] = $bmi;

                if ($bmi < 18.5) {
                    $data['bmi_category'] = 'Underweight';
                } elseif ($bmi < 25.0) {
                    $data['bmi_category'] = 'NormalWeight';
                } elseif ($bmi < 30.0) {
                    $data['bmi_category'] = 'Overweight';
                } else {
                    $data['bmi_category'] = 'Obese';
                }
            }

            // ── Pastikan foreign key selalu ikut ke-set ───────────────────────
            $data['outpatient_visit_id'] = $visit->id;

            if (empty($emr->created_by_user_id)) {
                $data['created_by_user_id'] = $this->getCurrentUserId();
            }

            $emr = $this->OutpatientVisitEmr->patchEntity($emr, $data);

            if ($schema->hasColumn('icd10_items')) {
                $emr->icd10_items = $icd10Json;
            }
            if ($schema->hasColumn('icd9_items')) {
                $emr->icd9_items = $icd9Json;
            }

            // ── Update status kunjungan (ini tetap punya OutpatientVisits) ────
            if (in_array($visit->status, ['waiting', 'called'])) {
                $visit->status     = 'in_progress';
                $visit->start_time = date('Y-m-d H:i:s');
            }

            // ── Proses tindakan (tetap milik OutpatientVisits/OutpatientActions) ──
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

            $this->OutpatientVisits->OutpatientActions->deleteAll([
                'outpatient_visit_id' => $visit->id,
            ]);

            $conn = $this->OutpatientVisitEmr->getConnection();
            $saved = false;

            try {
                $conn->transactional(function () use (&$saved, $emr, $visit, $actionsToSave) {
                    if (!$this->OutpatientVisitEmr->save($emr)) {
                        throw new \Exception('emr');
                    }
                    if (!$this->OutpatientVisits->save($visit)) {
                        throw new \Exception('visit');
                    }
                    if (!empty($actionsToSave)) {
                        if (!$this->OutpatientVisits->OutpatientActions->saveMany($actionsToSave)) {
                            throw new \Exception('actions');
                        }
                    }
                    $saved = true;
                });
            } catch (\Throwable $e) {
                $saved = false;
            }

            if ($saved) {
                $this->syncExistingKajianVitals((int)$visit->id, $emr);
                $this->Flash->success(__('EMR berhasil disimpan.'));
                return $this->redirect(['action' => 'emr', $visit->id]);
            }

            $err = json_encode(
                array_merge($emr->getErrors(), $visit->getErrors()),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );
            $this->Flash->error(__('Gagal menyimpan EMR. Error: ' . $err));
        }

        $this->set(compact('visit', 'emr'));
    }

    public function createReferralQueue()
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->loadModel('PolyclinicQueues');

        $polyName    = trim((string)$this->request->getData('poly_name'));
        $patientName = trim((string)$this->request->getData('patient_name'));
        $phoneNumber = trim((string)$this->request->getData('phone_number'));
        $visitDate   = $this->request->getData('visit_date') ?: date('Y-m-d');

        if (empty($polyName) || empty($patientName)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Data pasien atau poli tidak lengkap.'
                ]));
        }

        $existingQueue = $this->PolyclinicQueues->find()
        ->where([
                'visit_date' => $visitDate,
                'patients_name' => $patientName,
                'poly_name' => $polyName,
                'call_status !=' => 'Selesai',
                'is_delete' => 0,
        ])
        ->first();

        if ($existingQueue) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Pasien sudah memiliki antrian pada poli tersebut.'
                ]));
        }

        $connection = $this->PolyclinicQueues->getConnection();

        try {

            $result = $connection->transactional(function () use (
                $visitDate,
                $polyName,
                $patientName,
                $phoneNumber
            ) {

                $lastQueue = $this->PolyclinicQueues->find()
                    ->where([
                        'visit_date' => $visitDate,
                        'is_delete' => 0
                    ])
                    ->order([
                        'queue_number' => 'DESC',
                        'id' => 'DESC'
                    ])
                    ->first();

                $queueNumber = $lastQueue
                    ? ((int)$lastQueue->queue_number + 1)
                    : 1;

                $queueCode = 'A-' . str_pad((string)$queueNumber, 3, '0', STR_PAD_LEFT);

                $queue = $this->PolyclinicQueues->newEmptyEntity();

                $queue->code            = $queueCode;
                $queue->source          = 'Rujukan';

                $queue->visit_date      = $visitDate;

                $queue->poly_name       = $polyName;
                $queue->patients_name   = $patientName;
                $queue->no_telp         = $phoneNumber;

                $queue->queue_number    = $queueNumber;

                $queue->checkin_status  = 'Belum Check-in';
                $queue->call_status     = 'Menunggu';
                $queue->call_count      = 0;

                $queue->is_create       = 1;
                $queue->is_update       = 0;
                $queue->is_delete       = 0;
                $queue->is_active       = 'Y';

                if (!$this->PolyclinicQueues->save($queue)) {
                    throw new \Exception(json_encode($queue->getErrors()));
                }

                return [
                    'code' => $queueCode,
                    'queue_number' => $queueNumber
                ];
            });

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => true,
                    'code' => $result['code'],
                    'queue_number' => $result['queue_number']
                ]));

        } catch (\Throwable $e) {

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Gagal membuat nomor antrian.',
                    'error' => $e->getMessage()
                ]));
        }
    }

    /**
     * Simpan gambar anatomi pasien dari canvas Fabric.js.
     *
     * @param int|null $visitId ID kunjungan rawat jalan.
     * @return \Cake\Http\Response
     */
    public function saveAnatomy($visitId = null): \Cake\Http\Response
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->loadModel('OutpatientInitialMedicalAssessments');
        $side = (string)$this->request->getData('side');
        $source = (string)$this->request->getData('source', 'emr');
        $imageData = (string)$this->request->getData('image');
        $allowedSides = ['front' => 'anatomy_front', 'back' => 'anatomy_back'];

        // Validasi sisi anatomi agar hanya field yang disiapkan yang bisa diubah.
        if (empty($visitId) || !array_key_exists($side, $allowedSides)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Data anatomi tidak valid.',
            ], 422);
        }

        // Pastikan kolom database sudah ditambahkan sebelum mencoba menyimpan nama file.
        $schema = $this->OutpatientVisitEmr->getSchema();
        $field = $allowedSides[$side];
        if (!$schema->hasColumn($field)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Kolom database anatomi belum tersedia. Jalankan SQL ALTER TABLE terlebih dahulu.',
            ], 422);
        }

        // Terima hanya PNG data URL dari canvas.toDataURL().
        if (!preg_match('/^data:image\/png;base64,/', $imageData)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Format gambar anatomi harus PNG base64.',
            ], 422);
        }

        $binary = base64_decode((string)preg_replace('/^data:image\/png;base64,/', '', $imageData), true);
        if ($binary === false || $binary === '') {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Gambar anatomi tidak dapat dibaca.',
            ], 422);
        }

        $emr = $this->OutpatientVisitEmr->find()
            ->where(['outpatient_visit_id' => $visitId])
            ->first();

        // Jika dokter menyimpan anatomi sebelum form EMR utama disimpan, buat row EMR minimal.
        if (!$emr) {
            $emr = $this->OutpatientVisitEmr->newEmptyEntity();
            $emr->outpatient_visit_id = (int)$visitId;
            $emr->created_by_user_id = $this->getCurrentUserId();
            $emr->total_fee = 0;
            $emr->paid = false;
        }

        $directory = WWW_ROOT . 'uploads' . DS . 'anatomy' . DS;
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Folder upload anatomi tidak dapat dibuat.',
            ], 500);
        }

        // Nama file dibuat unik agar cache browser tidak menampilkan gambar lama setelah edit ulang.
        $fileName = sprintf(
            'visit_%s_%s_%s.png',
            (int)$visitId,
            $side,
            date('YmdHis')
        );
        $filePath = $directory . $fileName;

        if (file_put_contents($filePath, $binary) === false) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'File gambar anatomi gagal disimpan.',
            ], 500);
        }

        $oldFileName = (string)($emr->{$field} ?? '');
        $emr->{$field} = $fileName;
        $emr->modified_by_user_id = $this->getCurrentUserId();

        if (!$this->OutpatientVisitEmr->save($emr, ['validate' => false])) {
            @unlink($filePath);

            return $this->jsonResponse([
                'success' => false,
                'message' => 'Nama file anatomi gagal disimpan ke database.',
                'errors' => $emr->getErrors(),
            ], 422);
        }

        if ($source === 'kajian') {

            $assessment = $this->OutpatientInitialMedicalAssessments
                ->find()
                ->where([
                    'outpatient_visit_id' => $visitId
                ])
                ->first();

            if ($assessment) {

                $assessment->{$field} = $fileName;

                $this->OutpatientInitialMedicalAssessments
                    ->save($assessment, [
                        'validate' => false
                    ]);

            }

        }

        // Hapus file versi lama setelah database berhasil diarahkan ke file baru.
        if ($oldFileName !== '' && $oldFileName !== $fileName) {
            $oldFilePath = $directory . basename($oldFileName);
            if (is_file($oldFilePath)) {
                @unlink($oldFilePath);
            }
        }

        return $this->jsonResponse([
            'success' => true,
            'message' => 'Gambar anatomi berhasil disimpan.',
            'file_name' => $fileName,
            'file_url' => $this->request->getAttribute('webroot') . 'uploads/anatomy/' . $fileName,
        ]);
    }

    public function kajianAwal($visitId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $this->loadModel('OutpatientVisits');
        $this->loadModel('OutpatientInitialMedicalAssessments');

        $visit = $this->OutpatientVisits->get($visitId, [
            'contain' => ['Patients', 'Doctors', 'Registrations'],
        ]);

        $assessment = $this->OutpatientInitialMedicalAssessments->find()
            ->where(['outpatient_visit_id' => $visit->id])
            ->first();

        $emr = $this->OutpatientVisitEmr->find()
            ->where(['outpatient_visit_id' => $visit->id])
            ->first();
        $dataDasar = $this->syncKajianVitalsFromEmr(
            $this->decodeAssessmentSection($assessment->data_dasar ?? null),
            $emr
        );

        return $this->jsonResponse([
            'success' => true,
            'data' => [
                'id' => $assessment->id ?? null,
                'assessment_no' => $assessment->assessment_no ?? $this->buildKajianAwalNo((int)$visit->id),
                'assessment_date' => $this->formatAssessmentDate($assessment->assessment_date ?? null),
                'assessment_time' => $this->formatAssessmentTime($assessment->assessment_time ?? null),
                'data_dasar' => $dataDasar,
                'subjektif' => $this->decodeAssessmentSection($assessment->subjektif ?? null),
                'observasi' => $this->decodeAssessmentSection($assessment->observasi ?? null),
            ],
            'patient' => [
                'registration_no' => $visit->registration_no ?? ($visit->registration->registration_no ?? '-'),
                'medical_record_no' => $visit->patient->code ?? '-',
                'name' => $visit->patient->full_name ?? '-',
                'doctor' => $visit->doctor->doctor_name ?? '-',
            ],
        ]);
    }

    public function simpanKajianAwal($visitId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->loadModel('OutpatientVisits');
        $this->loadModel('OutpatientInitialMedicalAssessments');

        $visit = $this->OutpatientVisits->get($visitId);
        $data = $this->request->getData();

        $assessment = $this->OutpatientInitialMedicalAssessments->find()
            ->where(['outpatient_visit_id' => $visit->id])
            ->first();

        if (!$assessment) {
            $assessment = $this->OutpatientInitialMedicalAssessments->newEmptyEntity();
            $assessment->outpatient_visit_id = $visit->id;
            $assessment->registration_id = $visit->registration_id ?? null;
            $assessment->patient_id = $visit->patient_id ?? null;
            $assessment->doctor_id = $visit->doctor_id ?? null;
            $assessment->assessment_no = $this->buildKajianAwalNo((int)$visit->id);
            $assessment->created_by_user_id = $this->getCurrentUserId();
        }

        $assessment->modified_by_user_id = $this->getCurrentUserId();
        $assessment->assessment_date = !empty($data['assessment_date']) ? $data['assessment_date'] : date('Y-m-d');
        $assessment->assessment_time = !empty($data['assessment_time']) ? $data['assessment_time'] : date('H:i:s');
        $assessment->data_dasar = $this->encodeAssessmentSection($data['data_dasar'] ?? []);
        $assessment->subjektif = $this->encodeAssessmentSection($data['subjektif'] ?? []);
        $assessment->observasi = $this->encodeAssessmentSection($data['observasi'] ?? []);

        $emr = $this->OutpatientVisitEmr->find()
            ->where(['outpatient_visit_id' => $visit->id])
            ->first();
        if (!$emr) {
            $emr = $this->OutpatientVisitEmr->newEmptyEntity();
            $emr->outpatient_visit_id = $visit->id;
            $emr->created_by_user_id = $this->getCurrentUserId();
        }
        $this->applyKajianVitalsToEmr($emr, $data['data_dasar'] ?? []);

        $saved = false;
        $conn = $this->OutpatientInitialMedicalAssessments->getConnection();
        try {
            $conn->transactional(function () use (&$saved, $assessment, $emr) {
                if (!$this->OutpatientInitialMedicalAssessments->save($assessment, ['checkRules' => false])) {
                    throw new \Exception('assessment');
                }
                if (!$this->OutpatientVisitEmr->save($emr, ['checkRules' => false])) {
                    throw new \Exception('emr');
                }
                $saved = true;
            });
        } catch (\Throwable $e) {
            $saved = false;
        }

        if ($saved) {
            return $this->jsonResponse([
                'success' => true,
                'message' => 'Kajian medis awal berhasil disimpan.',
                'id' => $assessment->id,
                'assessment_no' => $assessment->assessment_no,
            ]);
        }

        return $this->jsonResponse([
            'success' => false,
            'message' => 'Gagal menyimpan kajian medis awal.',
            'errors' => $assessment->getErrors(),
        ], 422);
    }

    private function syncExistingKajianVitals(int $visitId, $emr): void
    {
        $this->loadModel('OutpatientInitialMedicalAssessments');

        $assessment = $this->OutpatientInitialMedicalAssessments->find()
            ->where(['outpatient_visit_id' => $visitId])
            ->first();
        if (!$assessment) {
            return;
        }

        $dataDasar = $this->syncKajianVitalsFromEmr(
            $this->decodeAssessmentSection($assessment->data_dasar ?? null),
            $emr
        );
        $assessment->data_dasar = $this->encodeAssessmentSection($dataDasar);
        $assessment->modified_by_user_id = $this->getCurrentUserId();

        $this->OutpatientInitialMedicalAssessments->save($assessment, ['checkRules' => false]);
    }

    private function syncKajianVitalsFromEmr(array $dataDasar, $emr): array
    {
        if (!$emr) {
            return $dataDasar;
        }

        $map = [
            'tekanan_darah' => 'blood_pressure',
            'nadi' => 'pulse',
            'napas' => 'respiratory_rate',
            'suhu' => 'temperature',
            'bb' => 'weight',
            'tb' => 'height',
            'spo2' => 'oxygen_saturation',
            'skala_nyeri' => 'pain_scale',
        ];

        foreach ($map as $kajianField => $emrField) {
            $value = $emr->{$emrField} ?? null;
            if ($value !== null && $value !== '') {
                $dataDasar[$kajianField] = $value;
            }
        }

        return $dataDasar;
    }

    private function applyKajianVitalsToEmr($emr, array $dataDasar): void
    {
        $map = [
            'tekanan_darah' => ['field' => 'blood_pressure', 'type' => 'string'],
            'nadi' => ['field' => 'pulse', 'type' => 'int'],
            'napas' => ['field' => 'respiratory_rate', 'type' => 'int'],
            'suhu' => ['field' => 'temperature', 'type' => 'float'],
            'bb' => ['field' => 'weight', 'type' => 'float'],
            'tb' => ['field' => 'height', 'type' => 'float'],
            'spo2' => ['field' => 'oxygen_saturation', 'type' => 'int'],
            'skala_nyeri' => ['field' => 'pain_scale', 'type' => 'int'],
        ];

        foreach ($map as $kajianField => $emrMeta) {
            if (!array_key_exists($kajianField, $dataDasar)) {
                continue;
            }

            $value = trim((string)$dataDasar[$kajianField]);
            if ($value === '') {
                $emr->{$emrMeta['field']} = null;
                continue;
            }

            if ($emrMeta['type'] === 'int') {
                $emr->{$emrMeta['field']} = (int)$value;
            } elseif ($emrMeta['type'] === 'float') {
                $emr->{$emrMeta['field']} = (float)$value;
            } else {
                $emr->{$emrMeta['field']} = $value;
            }
        }

        if (!empty($emr->weight) && !empty($emr->height)) {
            $hm = $emr->height / 100;
            $emr->bmi = round($emr->weight / ($hm * $hm), 2);
            if ($emr->bmi < 18.5) {
                $emr->bmi_category = 'Underweight';
            } elseif ($emr->bmi < 25.0) {
                $emr->bmi_category = 'NormalWeight';
            } elseif ($emr->bmi < 30.0) {
                $emr->bmi_category = 'Overweight';
            } else {
                $emr->bmi_category = 'Obese';
            }
        } else {
            $emr->bmi = null;
            $emr->bmi_category = null;
        }

        $emr->modified_by_user_id = $this->getCurrentUserId();
    }

    private function buildKajianAwalNo(int $visitId): string
    {
        return 'KMA-' . date('Ymd') . '-' . str_pad((string)$visitId, 5, '0', STR_PAD_LEFT);
    }

    private function encodeAssessmentSection($section): ?string
    {
        if (!is_array($section) || empty($section)) {
            return null;
        }

        return json_encode($section, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function decodeAssessmentSection($section): array
    {
        if (empty($section)) {
            return [];
        }

        $decoded = json_decode((string)$section, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function formatAssessmentDate($value): string
    {
        if (empty($value)) {
            return date('Y-m-d');
        }

        if (is_object($value) && method_exists($value, 'format')) {
            return $value->format('Y-m-d');
        }

        return substr((string)$value, 0, 10);
    }

    private function formatAssessmentTime($value): string
    {
        if (empty($value)) {
            return date('H:i');
        }

        if (is_object($value) && method_exists($value, 'format')) {
            return $value->format('H:i');
        }

        return substr((string)$value, 0, 5);
    }

    private function jsonResponse(array $payload, int $status = 200): \Cake\Http\Response
    {
        return $this->response
            ->withStatus($status)
            ->withType('application/json')
            ->withStringBody(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
