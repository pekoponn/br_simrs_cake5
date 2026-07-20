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
}