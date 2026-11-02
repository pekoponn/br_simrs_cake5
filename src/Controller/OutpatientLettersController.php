<?php
declare(strict_types=1);

namespace App\Controller;
use App\Traits\PdfRenderTrait;

/**
 * OutpatientLetters Controller
 *
 * @property \App\Model\Table\OutpatientLettersTable $OutpatientLetters
 * @method \App\Model\Entity\OutpatientLetter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutpatientLettersController extends AppController
{
    use PdfRenderTrait;
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['OutpatientVisits', 'Registrations', 'Patients', 'Doctors'],
        ];
        $outpatientLetters = $this->paginate($this->OutpatientLetters);

        $this->set(compact('outpatientLetters'));
    }

    /**
     * View method
     *
     * @param string|null $id Outpatient Letter id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outpatientLetter = $this->OutpatientLetters->get($id, contain: ['OutpatientVisits', 'Registrations', 'Patients', 'Doctors']);

        $this->set(compact('outpatientLetter'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $outpatientLetter = $this->OutpatientLetters->newEmptyEntity();
        if ($this->request->is('post')) {
            $outpatientLetter = $this->OutpatientLetters->patchEntity($outpatientLetter, $this->request->getData());
            if ($this->OutpatientLetters->save($outpatientLetter)) {
                $this->Flash->success(__('The outpatient letter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient letter could not be saved. Please, try again.'));
        }
        $outpatientVisits = $this->OutpatientLetters->OutpatientVisits->find('list', ['limit' => 200]);
        $registrations = $this->OutpatientLetters->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OutpatientLetters->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OutpatientLetters->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('outpatientLetter', 'outpatientVisits', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Outpatient Letter id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outpatientLetter = $this->OutpatientLetters->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outpatientLetter = $this->OutpatientLetters->patchEntity($outpatientLetter, $this->request->getData());
            if ($this->OutpatientLetters->save($outpatientLetter)) {
                $this->Flash->success(__('The outpatient letter has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient letter could not be saved. Please, try again.'));
        }
        $outpatientVisits = $this->OutpatientLetters->OutpatientVisits->find('list', ['limit' => 200]);
        $registrations = $this->OutpatientLetters->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OutpatientLetters->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OutpatientLetters->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('outpatientLetter', 'outpatientVisits', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Outpatient Letter id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outpatientLetter = $this->OutpatientLetters->get($id);
        if ($this->OutpatientLetters->delete($outpatientLetter)) {
            $this->Flash->success(__('The outpatient letter has been deleted.'));
        } else {
            $this->Flash->error(__('The outpatient letter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AMBIL — Surat Keterangan Sakit (untuk auto-fill saat modal EMR dibuka lagi)
    // Dipanggil dari emr.ctp lewat GET_SKS_URL
    // ─────────────────────────────────────────────────────────────────────────
    public function getSuratSakit($visitId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => (int)$visitId,
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
                'leave_from'     => $letter->leave_from ? $letter->leave_from->format('Y-m-d') : null,
                'leave_to'       => $letter->leave_to ? $letter->leave_to->format('Y-m-d') : null,
                'diagnosis'      => $letter->diagnosis,
                'is_normal'      => (int)$letter->is_normal,
            ] : null,
        ]));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SIMPAN — Surat Keterangan Sakit (UPSERT: boleh disimpan sebagian dulu)
    // $visitId di sini adalah ID dari outpatient_visits (bukan ID surat).
    // Dipanggil dari emr.ctp lewat SIMPAN_SKS_URL
    // ─────────────────────────────────────────────────────────────────────────
    public function simpanSuratSakit($visitId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        // OutpatientVisits tidak otomatis ter-load di controller ini, jadi harus load manual.
        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $visit = $this->OutpatientVisits->get($visitId);

        $data = $this->request->getData();

        // Cari surat yang sudah ada untuk kunjungan ini (kalau ada → update, bukan bikin baru)
        $entity = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'sakit',
            ])
            ->first();

        if (!$entity) {
            $entity = $this->OutpatientLetters->newEmptyEntity();
            $entity->outpatient_visit_id = $visit->id;
            $entity->registration_id     = $visit->registration_id ?? null;
            $entity->patient_id          = $visit->patient_id ?? null;
            $entity->doctor_id           = $visit->doctor_id ?? null;
            $entity->letter_type         = 'sakit';
            $entity->letter_no           = null;
        }

        // Semua field opsional — boleh disimpan meski belum lengkap.
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
            'validate' => false,
        ]);

        if ($this->OutpatientLetters->save($entity, ['checkRules' => false])) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success'   => true,
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

    public function getSuratKonsultasi($id = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
 
        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => (int)$id,
                'letter_type' => 'konsultasi',
            ])
            ->first();
 
        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'data'    => $letter ? [
                'letter_id' => $letter->id,
                'letter_no' => $letter->letter_no,
                'diagnosis' => $letter->diagnosis,
                'notes'     => $letter->notes,
                'consultation_answer' => $letter->consultation_answer,
                'is_consultation_locked' => trim((string)$letter->notes) !== '',
                'is_answer_locked' => trim((string)$letter->consultation_answer) !== '',
            ] : null,
        ]));
    }
 
    public function simpanSuratKonsultasi($id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;
 
        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $visit = $this->OutpatientVisits->get($id);
        $data  = $this->request->getData();
 
        // Cari surat konsultasi yang sudah ada untuk kunjungan ini
        // (kalau ada, di-update, bukan bikin baru)
        $entity = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'konsultasi',
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
            $entity->letter_type         = 'konsultasi';
            $entity->letter_no           = null;
        }
 
        $notes = $data['notes'] ?? null;
        if (!$isNew && trim((string)$entity->notes) !== '') {
            $notes = $entity->notes;
        }

        $fields = [
            'diagnosis' => $data['diagnosis'] ?? null,
            'notes'     => $notes,
        ];
 
        $entity = $this->OutpatientLetters->patchEntity($entity, $fields, [
            'validate' => false,
        ]);
 
        if ($this->OutpatientLetters->save($entity)) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success'   => true,
                'is_new'    => $isNew,
                'letter_id' => $entity->id,
                'letter_no' => $entity->letter_no,
                'is_consultation_locked' => trim((string)$entity->notes) !== '',
                'is_answer_locked' => trim((string)$entity->consultation_answer) !== '',
            ]));
        }
 
        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan surat konsultasi.',
            'errors'  => $entity->getErrors(),
        ]));
    }

    public function getSuratJawabanKonsultasi($id = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => (int)$id,
                'letter_type' => 'konsultasi',
            ])
            ->first();

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'data'    => $letter ? [
                'letter_id' => $letter->id,
                'letter_no' => $letter->letter_no,
                'diagnosis' => $letter->diagnosis,
                'saran'     => $letter->consultation_answer,
                'is_consultation_locked' => trim((string)$letter->notes) !== '',
                'is_answer_locked' => trim((string)$letter->consultation_answer) !== '',
            ] : null,
        ]));
    }

    public function simpanSuratJawabanKonsultasi($id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $visit = $this->OutpatientVisits->get($id);
        $data  = $this->request->getData();

        $entity = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'konsultasi',
            ])
            ->first();

        if (!$entity || trim((string)$entity->notes) === '') {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => false,
                'message' => 'Keterangan konsultasi harus disimpan terlebih dahulu.',
            ]));
        }

        $answer = $data['saran'] ?? null;
        if (trim((string)$entity->consultation_answer) !== '') {
            $answer = $entity->consultation_answer;
        }

        $entity = $this->OutpatientLetters->patchEntity($entity, [
            'diagnosis' => $data['diagnosis'] ?? $entity->diagnosis,
            'consultation_answer' => $answer,
        ], [
            'validate' => false,
        ]);

        if ($this->OutpatientLetters->save($entity)) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success'   => true,
                'letter_id' => $entity->id,
                'letter_no' => $entity->letter_no,
                'is_consultation_locked' => trim((string)$entity->notes) !== '',
                'is_answer_locked' => trim((string)$entity->consultation_answer) !== '',
            ]));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan jawaban konsultasi.',
            'errors'  => $entity->getErrors(),
        ]));
    }

    /**
     * Cetak Surat Keterangan Sakit.
     * $letterId di sini adalah ID dari outpatient_letters (bukan ID kunjungan).
     */
    public function cetakSuratSakit($letterId = null)
    {
        $letter = $this->OutpatientLetters->get($letterId, contain: ['Patients', 'Doctors', 'OutpatientVisits']);

        $this->assignSequentialLetterNo($letter, 'SKS');

        return $this->streamPdf(
            'cetak_surat_sakit',
            compact('letter'),
            'Surat-Keterangan-Sakit-' . $letter->letter_no . '.pdf',
            'A5',
            'portrait',
            'attachment' 
        );
    }

    public function cetakSuratKonsultasi($letterId = null)
    {
        $letter = $this->OutpatientLetters->get($letterId, contain: ['Patients', 'Doctors', 'OutpatientVisits']);

        if ($letter->letter_type !== 'konsultasi') {
            throw new \Cake\Http\Exception\NotFoundException('Surat konsultasi tidak ditemukan.');
        }

        $this->assignSequentialLetterNo($letter, 'KSL');

        return $this->streamPdf(
            'cetak_surat_konsultasi',
            compact('letter'),
            'Surat-Konsultasi-' . $letter->letter_no . '.pdf',
            'A4',
            'portrait',
            'attachment'
        );
    }


    public function getSuratPengantarRawat($visitId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => (int)$visitId,
                'letter_type' => 'pengantar_rawat',
            ])
            ->first();

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'data'    => $letter ? [
                'letter_id' => $letter->id,
                'letter_no' => $letter->letter_no,
                'reason'    => $letter->notes,
                'diagnosis' => $letter->diagnosis,
            ] : null,
        ]));
    }

    public function simpanSuratPengantarRawat($visitId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $visit = $this->OutpatientVisits->get($visitId);
        $data  = $this->request->getData();

        $entity = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'pengantar_rawat',
            ])
            ->first();

        if (!$entity) {
            $entity = $this->OutpatientLetters->newEmptyEntity();
            $entity->outpatient_visit_id = $visit->id;
            $entity->registration_id     = $visit->registration_id ?? null;
            $entity->patient_id          = $visit->patient_id ?? null;
            $entity->doctor_id           = $visit->doctor_id ?? null;
            $entity->letter_type         = 'pengantar_rawat';
            $entity->letter_no           = null;
        }

        $entity = $this->OutpatientLetters->patchEntity($entity, [
            'diagnosis' => $entity->diagnosis ?: ($visit->diagnosis_primary ?? null),
            'notes'     => $data['reason'] ?? null,
        ], ['validate' => false]);

        if ($this->OutpatientLetters->save($entity, ['checkRules' => false])) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success'   => true,
                'letter_id' => $entity->id,
                'letter_no' => $entity->letter_no,
            ]));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan alasan rujukan.',
            'errors'  => $entity->getErrors(),
        ]));
    }

    public function cetakSuratPengantarRawat($visitId = null)
    {
        $this->request->allowMethod(['get']);

        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $visit = $this->OutpatientVisits->get($visitId, [
            'contain' => ['Patients', 'Doctors', 'Registrations'],
        ]);

        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'pengantar_rawat',
            ])
            ->first();

        if (!$letter) {
            $letter = $this->OutpatientLetters->newEmptyEntity();
            $letter->outpatient_visit_id = $visit->id;
            $letter->registration_id     = $visit->registration_id ?? null;
            $letter->patient_id          = $visit->patient_id ?? null;
            $letter->doctor_id           = $visit->doctor_id ?? null;
            $letter->letter_type         = 'pengantar_rawat';
            $letter->letter_no           = 'SPRI-' . date('Ymd') . '-' . str_pad((string)$visit->id, 5, '0', STR_PAD_LEFT);
            $letter->diagnosis = $visit->diagnosis_primary ?? null;

            $this->OutpatientLetters->save($letter, ['checkRules' => false]);
        }

        $letter = $this->OutpatientLetters->get($letter->id, contain: ['Patients', 'Doctors', 'OutpatientVisits']);

        $this->assignSequentialLetterNo($letter, 'SPRI');

        $this->viewBuilder()->setLayout('print');
        $this->set(compact('letter', 'visit'));
    }

    public function getSuratBuktiRajal($visitId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => (int)$visitId,
                'letter_type' => 'bukti_rajal',
            ])
            ->first();

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'data'    => $letter ? [
                'letter_id'                 => $letter->id,
                'letter_no'                 => $letter->letter_no,
                'anamnesa'                  => $letter->anamnesa,
                'diagnosis_primary_text'    => $letter->diagnosis_primary_text,
                'diagnosis_secondary_text'  => $letter->diagnosis_secondary_text,
                'action_primary_text'       => $letter->action_primary_text,
                'action_secondary_text'     => $letter->action_secondary_text,
                'supporting_diagnosis'      => $letter->supporting_diagnosis,
                'is_autopsy'                => (int)$letter->is_autopsy,
                'special_actions'           => $letter->special_actions ? json_decode($letter->special_actions, true) : [],
                'prescription'              => $letter->prescription,
                'advice_notes'              => $letter->advice_notes,
                'discharged_by_doctor_id'   => $letter->discharged_by_doctor_id,
                'completing_doctor_id'      => $letter->completing_doctor_id,
                'patient_or_family_name'    => $letter->patient_or_family_name,
            ] : null,
        ]));
    }

    public function simpanSuratBuktiRajal($visitId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $visit = $this->OutpatientVisits->get($visitId);
        $data  = $this->request->getData();

        $entity = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'bukti_rajal',
            ])
            ->first();

        if (!$entity) {
            $entity = $this->OutpatientLetters->newEmptyEntity();
            $entity->outpatient_visit_id = $visit->id;
            $entity->registration_id     = $visit->registration_id ?? null;
            $entity->patient_id          = $visit->patient_id ?? null;
            $entity->doctor_id           = $visit->doctor_id ?? null;
            $entity->letter_type         = 'bukti_rajal';
            $entity->letter_no           = null;
        }

        $specialActions = $data['special_actions'] ?? [];
        $specialActionsJson = !empty($specialActions)
            ? json_encode($specialActions, JSON_UNESCAPED_UNICODE)
            : null;

        $fields = [
            'anamnesa'                 => $data['anamnesa'] ?? null,
            'diagnosis_primary_text'   => $data['diagnosis_primary_text'] ?? null,
            'diagnosis_secondary_text' => $data['diagnosis_secondary_text'] ?? null,
            'action_primary_text'      => $data['action_primary_text'] ?? null,
            'action_secondary_text'    => $data['action_secondary_text'] ?? null,
            'supporting_diagnosis'     => $data['supporting_diagnosis'] ?? null,
            'is_autopsy'               => !empty($data['is_autopsy']) ? 1 : 0,
            'special_actions'          => $specialActionsJson,
            'prescription'             => $data['prescription'] ?? null,
            'advice_notes'             => $data['advice_notes'] ?? null,
            'discharged_by_doctor_id'  => !empty($data['discharged_by_doctor_id']) ? (int)$data['discharged_by_doctor_id'] : null,
            'completing_doctor_id'     => !empty($data['completing_doctor_id']) ? (int)$data['completing_doctor_id'] : null,
            'patient_or_family_name'   => $data['patient_or_family_name'] ?? null,
            'examined_at'              => !empty($data['examined_at']) ? $data['examined_at'] : date('Y-m-d'),
        ];

        $entity = $this->OutpatientLetters->patchEntity($entity, $fields, [
            'validate' => false,
        ]);

        if ($this->OutpatientLetters->save($entity, ['checkRules' => false])) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success'   => true,
                'letter_id' => $entity->id,
                'letter_no' => $entity->letter_no,
            ]));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan surat bukti rawat jalan.',
            'errors'  => $entity->getErrors(),
        ]));
    }

    public function cetakSuratBuktiRajal($letterId = null)
    {
        $letter = $this->OutpatientLetters->get($letterId, contain: ['Patients', 'Doctors', 'OutpatientVisits']);

        if ($letter->letter_type !== 'bukti_rajal') {
            throw new \Cake\Http\Exception\NotFoundException('Surat bukti rawat jalan tidak ditemukan.');
        }

        $this->assignSequentialLetterNo($letter, 'SBRJ');

        $this->Doctors = $this->fetchTable('Doctors');
        $dischargedByDoctor = !empty($letter->discharged_by_doctor_id)
            ? $this->Doctors->find()->where(['id' => $letter->discharged_by_doctor_id])->first()
            : null;
        $completingDoctor = !empty($letter->completing_doctor_id)
            ? $this->Doctors->find()->where(['id' => $letter->completing_doctor_id])->first()
            : null;

        $emr = null;
        if (!empty($letter->outpatient_visit_id)) {
            try {
                $emrTable = \Cake\ORM\TableRegistry::getTableLocator()->get('OutpatientVisitEmr');
                $emr = $emrTable->find()
                    ->where(['outpatient_visit_id' => $letter->outpatient_visit_id])
                    ->first();
            } catch (\Throwable $e) {
            }
        }

        $noRekamMedis = $letter->patient->code ?? '-';
        try {
            $medicalRecordsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('MedicalRecords');
            $mrRow = $medicalRecordsTable->find()
                ->where(['registration_id' => $letter->outpatient_visit->registration_id ?? 0])
                ->first();
            if ($mrRow && !empty($mrRow->medical_record_no)) {
                $noRekamMedis = $mrRow->medical_record_no;
            }
        } catch (\Throwable $e) {
        }
        return $this->streamPdf(
        'cetak_surat_bukti_rajal',
        compact('letter', 'dischargedByDoctor', 'completingDoctor', 'emr', 'noRekamMedis'),
        'Surat-Bukti-Rawat-Jalan-' . $letter->letter_no . '.pdf',
        'A4',
        'portrait',
        'attachment'
        );  
    }

    public function getSuratSkdp($visitId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => (int)$visitId,
                'letter_type' => 'skdp',
            ])
            ->first();

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'data'    => $letter ? [
                'letter_id'     => $letter->id,
                'letter_no'     => $letter->letter_no,
                'control_date'  => $letter->leave_from ? (string)$letter->leave_from : null,
                'control_notes' => $letter->notes,
                'control_plan'  => $letter->advice_notes,
                'reason'        => $letter->diagnosis,
                'bpjs_card_no'  => $letter->bpjs_card_no,
            ] : null,
        ]));
    }

    public function simpanSuratSkdp($visitId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $visit = $this->OutpatientVisits->get($visitId);
        $data  = $this->request->getData();

        $entity = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'skdp',
            ])
            ->first();

        if (!$entity) {
            $entity = $this->OutpatientLetters->newEmptyEntity();
            $entity->outpatient_visit_id = $visit->id;
            $entity->registration_id     = $visit->registration_id ?? null;
            $entity->patient_id          = $visit->patient_id ?? null;
            $entity->doctor_id           = $visit->doctor_id ?? null;
            $entity->letter_type         = 'skdp';
            $entity->letter_no           = null;
        }

        $fields = [
            'diagnosis'                => $data['diagnosis'] ?? null,
            'prescription'             => $data['therapy'] ?? null,
            'leave_from'               => !empty($data['referral_date']) ? $data['referral_date'] : null,
            'leave_to'                 => !empty($data['control_date']) ? $data['control_date'] : null,
            'referral_doctor_name'     => $data['referral_no'] ?? null,
            'bpjs_card_no'             => $data['bpjs_card_no'] ?? null,
            'notes'                    => $data['reason'] ?? null,
            'advice_notes'             => $data['control_plan'] ?? null,
            'diagnosis_secondary_text' => $data['control_notes'] ?? null,
            'examined_at'              => !empty($data['examined_at']) ? $data['examined_at'] : date('Y-m-d'),
        ];

        $entity = $this->OutpatientLetters->patchEntity($entity, $fields, ['validate' => false]);

        if ($this->OutpatientLetters->save($entity, ['checkRules' => false])) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success'   => true,
                'letter_id' => $entity->id,
                'letter_no' => $entity->letter_no,
            ]));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan SKDP.',
            'errors'  => $entity->getErrors(),
        ]));
    }

    public function cetakSuratSkdp($letterId = null)
    {
        $letter = $this->OutpatientLetters->get($letterId, contain: ['Patients', 'Doctors', 'OutpatientVisits']);

        if ($letter->letter_type !== 'skdp') {
            throw new \Cake\Http\Exception\NotFoundException('Surat SKDP tidak ditemukan.');
        }

        $this->assignSequentialLetterNo($letter, 'SKDP');

        $noRekamMedis = $letter->patient->code ?? '-';
        try {
            $medicalRecordsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('MedicalRecords');
            $mrRow = $medicalRecordsTable->find()
                ->where(['registration_id' => $letter->outpatient_visit->registration_id ?? 0])
                ->first();
            if ($mrRow && !empty($mrRow->medical_record_no)) {
                $noRekamMedis = $mrRow->medical_record_no;
            }
        } catch (\Throwable $e) {
        }

        return $this->streamPdf(
            'cetak_surat_skdp',
            compact('letter', 'noRekamMedis'),
            'Surat-SKDP-' . $letter->letter_no . '.pdf',
            'A5',
            'portrait',
            'attachment'
        );
    }

    public function getSuratKontrolBpjs($visitId = null)
{
    $this->request->allowMethod(['get']);
    $this->autoRender = false;

    $letter = $this->OutpatientLetters->find()
        ->where([
            'outpatient_visit_id' => (int)$visitId,
            'letter_type' => 'kontrol_bpjs',
        ])
        ->first();

    return $this->response->withType('application/json')->withStringBody(json_encode([
        'success' => true,
        'data'    => $letter ? [
            'letter_id'                  => $letter->id,
            'letter_no'                  => $letter->letter_no,
            'control_date'               => $letter->leave_from ? $letter->leave_from->format('Y-m-d') : null,
            'notes'                      => $letter->notes,
            'bpjs_card_no'               => $letter->bpjs_card_no,
            'diagnosis'                  => $letter->diagnosis,
            'referral_doctor_id'         => $letter->referral_doctor_id,
            'referral_doctor_name'       => $letter->referral_doctor_name,
            'referral_doctor_specialist' => $letter->referral_doctor_specialist,
        ] : null,
    ]));
}

public function simpanSuratKontrolBpjs($visitId = null)
{
    $this->request->allowMethod(['post']);
    $this->autoRender = false;

    $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
    $visit = $this->OutpatientVisits->get($visitId);
    $data  = $this->request->getData();

    $entity = $this->OutpatientLetters->find()
        ->where([
            'outpatient_visit_id' => $visit->id,
            'letter_type' => 'kontrol_bpjs',
        ])
        ->first();

    if (!$entity) {
        $entity = $this->OutpatientLetters->newEmptyEntity();
        $entity->outpatient_visit_id = $visit->id;
        $entity->registration_id     = $visit->registration_id ?? null;
        $entity->patient_id          = $visit->patient_id ?? null;
        $entity->doctor_id           = $visit->doctor_id ?? null;
        $entity->letter_type         = 'kontrol_bpjs';
        $entity->letter_no           = null;
    }

    $fields = [
        'leave_from'                 => !empty($data['control_date']) ? $data['control_date'] : null,
        'notes'                      => $data['notes'] ?? null,
        'bpjs_card_no'               => $data['bpjs_card_no'] ?? null,
        'diagnosis'                  => $data['diagnosis'] ?? null,
        'referral_doctor_id'         => !empty($data['referral_doctor_id']) ? (int)$data['referral_doctor_id'] : null,
        'referral_doctor_name'       => $data['referral_doctor_name'] ?? null,
        'referral_doctor_specialist' => $data['referral_doctor_specialist'] ?? null,
        'examined_at'                => !empty($data['examined_at']) ? $data['examined_at'] : date('Y-m-d'),
    ];

    $entity = $this->OutpatientLetters->patchEntity($entity, $fields, ['validate' => false]);

    if ($this->OutpatientLetters->save($entity, ['checkRules' => false])) {
        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success'   => true,
            'letter_id' => $entity->id,
            'letter_no' => $entity->letter_no,
        ]));
    }

    return $this->response->withType('application/json')->withStringBody(json_encode([
        'success' => false,
        'message' => 'Gagal menyimpan surat kontrol BPJS.',
        'errors'  => $entity->getErrors(),
    ]));
}

    public function cetakSuratKontrolBpjs($letterId = null)
    {
        $letter = $this->OutpatientLetters->get($letterId, contain: ['Patients', 'Doctors', 'OutpatientVisits']);

        $this->assignSequentialLetterNo($letter, 'SKB');

        return $this->streamPdf(
            'cetak_surat_kontrol_bpjs',
            compact('letter'),
            'Surat-Kontrol-BPJS-' . $letter->letter_no . '.pdf',
            'A5',
            'portrait',
            'attachment'
        );
    }

    public function getSuratSehat($visitId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
 
        $letter = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => (int)$visitId,
                'letter_type' => 'sehat',
            ])
            ->first();
 
        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'data'    => $letter ? [
                'letter_id'           => $letter->id,
                'letter_no'           => $letter->letter_no,
                'weight'              => $letter->weight,
                'height'              => $letter->height,
                'blood_pressure'      => $letter->blood_pressure,
                'temperature'         => $letter->temperature,
                'color_blind'         => $letter->color_blind,
                'blood_type'          => $letter->blood_type,
                'result'              => $letter->diagnosis,
                'result_detail'       => $letter->notes,
                'statement_notes'     => $letter->consultation_answer,
                'is_normal'           => (int)$letter->is_normal,
            ] : null,
        ]));
    }
 
    public function simpanSuratSehat($visitId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;
 
        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $visit = $this->OutpatientVisits->get($visitId);
 
        $data = $this->request->getData();
 
        $entity = $this->OutpatientLetters->find()
            ->where([
                'outpatient_visit_id' => $visit->id,
                'letter_type' => 'sehat',
            ])
            ->first();
 
        if (!$entity) {
            $entity = $this->OutpatientLetters->newEmptyEntity();
            $entity->outpatient_visit_id = $visit->id;
            $entity->registration_id     = $visit->registration_id ?? null;
            $entity->patient_id          = $visit->patient_id ?? null;
            $entity->doctor_id           = $visit->doctor_id ?? null;
            $entity->letter_type         = 'sehat';
            $entity->letter_no           = null;
        }
 
        $fields = [
            'weight'              => $data['weight'] ?? null,
            'height'              => $data['height'] ?? null,
            'blood_pressure'      => $data['blood_pressure'] ?? null,
            'temperature'         => $data['temperature'] ?? null,
            'color_blind'         => $data['color_blind'] ?? null,
            'blood_type'          => $data['blood_type'] ?? null,
            'diagnosis'           => $data['result'] ?? 'SEHAT',
            'notes'               => $data['result_detail'] ?? null,
            'consultation_answer' => $data['statement_notes'] ?? null,
            'is_normal'           => !empty($data['is_normal']) ? 1 : 0,
            'examined_at'         => !empty($data['examined_at']) ? $data['examined_at'] : date('Y-m-d'),
        ];
 
        $entity = $this->OutpatientLetters->patchEntity($entity, $fields, [
            'validate' => false,
        ]);
 
        if ($this->OutpatientLetters->save($entity, ['checkRules' => false])) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success'   => true,
                'letter_id' => $entity->id,
                'letter_no' => $entity->letter_no,
            ]));
        }
 
        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan surat keterangan sehat.',
            'errors'  => $entity->getErrors(),
        ]));
    }
 
    public function cetakSuratSehat($letterId = null)
    {
        $letter = $this->OutpatientLetters->get($letterId, contain: ['Patients', 'Doctors', 'OutpatientVisits']);
 
        if ($letter->letter_type !== 'sehat') {
            throw new \Cake\Http\Exception\NotFoundException('Surat keterangan sehat tidak ditemukan.');
        }

        $this->assignSequentialLetterNo($letter, 'SKH');
 
        return $this->streamPdf(
            'cetak_surat_sehat',
            compact('letter'),
            'Surat-Keterangan-Sehat-' . $letter->letter_no . '.pdf',
            'A5',
            'portrait',
            'attachment'
        );
    }

    private function assignSequentialLetterNo(\App\Model\Entity\OutpatientLetter $letter, string $prefix): string
    {
        if (!empty($letter->letter_no) && $letter->letter_no !== 'AUTO') {
            return $letter->letter_no;
        }

        $today = date('Ymd');
        $likePattern = $prefix . '-' . $today . '-%';

        $last = $this->OutpatientLetters->find()
            ->where([
                'letter_type' => $letter->letter_type,
                'letter_no LIKE' => $likePattern,
            ])
            ->orderBy(['id' => 'DESC'])
            ->first();

        $nextSeq = 1;
        if ($last && preg_match('/-(\d+)$/', (string)$last->letter_no, $m)) {
            $nextSeq = (int)$m[1] + 1;
        }

        $letter->letter_no = $prefix . '-' . $today . '-' . str_pad((string)$nextSeq, 5, '0', STR_PAD_LEFT);
        $this->OutpatientLetters->save($letter, ['checkRules' => false, 'validate' => false]);

        return $letter->letter_no;
    }

}
