<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OutpatientLetters Controller
 *
 * @property \App\Model\Table\OutpatientLettersTable $OutpatientLetters
 * @method \App\Model\Entity\OutpatientLetter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutpatientLettersController extends AppController
{
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
        $outpatientLetter = $this->OutpatientLetters->get($id, [
            'contain' => ['OutpatientVisits', 'Registrations', 'Patients', 'Doctors'],
        ]);

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
        $outpatientLetter = $this->OutpatientLetters->get($id, [
            'contain' => [],
        ]);
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
                'leave_from'     => $letter->leave_from ? (string)$letter->leave_from : null,
                'leave_to'       => $letter->leave_to ? (string)$letter->leave_to : null,
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
        $this->loadModel('OutpatientVisits');
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
            $entity->letter_no           = 'SKS-' . date('Ymd') . '-' . str_pad((string)$visit->id, 5, '0', STR_PAD_LEFT);
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
 
        $this->loadModel('OutpatientVisits');
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
            $entity->letter_no           = 'KSL-' . date('Ymd') . '-' . str_pad((string)$visit->id, 5, '0', STR_PAD_LEFT);
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

        $this->loadModel('OutpatientVisits');
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
        $letter = $this->OutpatientLetters->get($letterId, [
            'contain' => ['Patients', 'Doctors', 'OutpatientVisits'],
        ]);

        $this->viewBuilder()->setLayout('print'); // pastikan layout 'print' sudah ada, atau ganti ke layout kosong
        $this->set(compact('letter'));
    }

    public function cetakSuratKonsultasi($letterId = null)
    {
        $letter = $this->OutpatientLetters->get($letterId, [
            'contain' => ['Patients', 'Doctors', 'OutpatientVisits'],
        ]);

        if ($letter->letter_type !== 'konsultasi') {
            throw new \Cake\Http\Exception\NotFoundException('Surat konsultasi tidak ditemukan.');
        }

        $this->viewBuilder()->setLayout('print');
        $this->set(compact('letter'));
    }

}
