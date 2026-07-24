<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

/**
 * MedicalRecords Controller
 *
 * @property \App\Model\Table\MedicalRecordsTable $MedicalRecords
 */
class MedicalRecordsController extends AppController
{
    public function index()
    {
        $this->loadModel('Patients');
        $this->loadModel('Registrations');
        $this->loadModel('OutpatientVisits');
        $this->loadModel('MedicalRecords');
        $this->loadModel('MedicalRecordInpatients');
        $this->loadModel('MedicalRecordOutpatientIgds');
        $this->loadModel('MedicalRecordDiagnoses');

        $q = trim((string)$this->request->getQuery('q', ''));

        $patient = null;
        $registrations = [];
        $medicalRecordsByRegistration = [];
        $notFound = false;

        if ($q !== '') {
            $patient = $this->Patients->find()
                ->where([
                    'OR' => [
                        ['Patients.is_delete !=' => 1],
                        ['Patients.is_delete IS' => null],
                    ],
                ])
                ->where([
                    'OR' => [
                        'Patients.code' => $q,
                        'Patients.identity_number' => $q,
                        'Patients.phone_number' => $q,
                        'Patients.code LIKE' => '%' . $q . '%',
                        'Patients.full_name LIKE' => '%' . $q . '%',
                        'Patients.identity_number LIKE' => '%' . $q . '%',
                        'Patients.phone_number LIKE' => '%' . $q . '%',
                    ],
                ])
                ->order(['Patients.id' => 'DESC'])
                ->first();

            if ($patient) {
                $connection = ConnectionManager::get('default');
                $schema = $connection->getSchemaCollection()->describe('registrations');

                $order = [];
                if ($schema->hasColumn('registration_date')) {
                    $order['Registrations.registration_date'] = 'DESC';
                }
                if ($schema->hasColumn('admission_time')) {
                    $order['Registrations.admission_time'] = 'DESC';
                }
                if ($schema->hasColumn('created')) {
                    $order['Registrations.created'] = 'DESC';
                }
                $order['Registrations.id'] = 'DESC';

                $contain = [];
                if ($this->Registrations->associations()->has('Doctors')) {
                    $contain[] = 'Doctors';
                }
                if ($this->Registrations->associations()->has('Rooms')) {
                    $contain[] = 'Rooms';
                }
                if ($this->Registrations->associations()->has('Beds')) {
                    $contain[] = 'Beds';
                }

                $registrations = $this->Registrations->find()
                    ->contain($contain)
                    ->where(['Registrations.patient_id' => (int)$patient->id])
                    ->order($order)
                    ->all()
                    ->toList();

                foreach ($registrations as $registration) {
                    $outpatientVisit = $this->OutpatientVisits->find()
                        ->where(['OutpatientVisits.registration_id' => (int)$registration->id])
                        ->order(['OutpatientVisits.id' => 'DESC'])
                        ->first();

                    if ($outpatientVisit) {
                        $registration->set('outpatient_visit', $outpatientVisit);
                    }

                    $medicalRecord = $this->MedicalRecords->find()
                        ->contain([
                            'MedicalRecordInpatients',
                            'MedicalRecordOutpatientIgds',
                            'MedicalRecordDiagnoses',
                        ])
                        ->where([
                            'MedicalRecords.registration_id' => (int)$registration->id,
                            'OR' => [
                                ['MedicalRecords.is_delete' => 0],
                                ['MedicalRecords.is_delete IS' => null],
                            ],
                        ])
                        ->order(['MedicalRecords.id' => 'DESC'])
                        ->first();

                    $medicalRecordsByRegistration[$registration->id] = $medicalRecord;
                }
            } else {
                $notFound = true;
            }
        }

        $this->set(compact('q', 'patient', 'registrations', 'medicalRecordsByRegistration', 'notFound'));
    }

     public function searchPatients()
    {
    $this->request->allowMethod(['get']);
    $this->loadModel('Patients');

    $term = trim((string)$this->request->getQuery('term', ''));
    $limit = (int)$this->request->getQuery('limit', 50);
    if ($limit < 1 || $limit > 100) {
        $limit = 50;
    }

    $query = $this->Patients->find()
        ->select([
            'id',
            'code',
            'full_name',
            'birth_date',
            'gender',
            'address',
            'phone_number',
            'identity_number',
            'blood_type',
        ])
        ->where([
            'OR' => [
                ['Patients.is_delete !=' => 1],
                ['Patients.is_delete IS' => null],
            ],
        ]);

    if ($term !== '') {
        $query->where([
            'OR' => [
                'Patients.code LIKE' => '%' . $term . '%',
                'Patients.full_name LIKE' => '%' . $term . '%',
                'Patients.identity_number LIKE' => '%' . $term . '%',
                'Patients.phone_number LIKE' => '%' . $term . '%',
                'Patients.address LIKE' => '%' . $term . '%',
            ],
        ]);
    }

    $patients = $query
        ->order(['Patients.full_name' => 'ASC'])
        ->limit($limit);

    $rows = [];
    foreach ($patients as $p) {
        $birthDate = '';
        if (!empty($p->birth_date) && is_object($p->birth_date) && method_exists($p->birth_date, 'format')) {
            $birthDate = $p->birth_date->format('d-m-Y');
        } elseif (!empty($p->birth_date)) {
            $birthDate = date('d-m-Y', strtotime((string)$p->birth_date));
        }

        $gender = strtolower((string)($p->gender ?? ''));
        $genderText = in_array($gender, ['female', 'f', 'p', 'perempuan', 'wanita'], true) ? 'W' : 'P';

        $rows[] = [
            'id' => $p->id,
            'code' => (string)($p->code ?? ''),
            'full_name' => (string)($p->full_name ?? ''),
            'birth_date' => $birthDate,
            'gender' => $genderText,
            'address' => (string)($p->address ?? ''),
            'phone_number' => (string)($p->phone_number ?? ''),
            'identity_number' => (string)($p->identity_number ?? ''),
            'blood_type' => (string)($p->blood_type ?? ''),
            'card_no' => '',
        ];
    }

    $this->autoRender = false;
    return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode(['success' => true, 'data' => $rows], JSON_UNESCAPED_UNICODE));
    }

/**
 * ============================================================
 * TEMPEL METHOD INI DI DALAM MedicalRecordsController.php
 * (letakkan di bawah method searchPatients(), sebelum tanda "}" penutup class)
 * ============================================================
 *
 * CARA PAKAI:
 * 1. Tempel method di bawah ini ke MedicalRecordsController.php
 * 2. Buka di browser: http://localhost/nama-project/medical-records/backfillNoRm
 * 3. Lihat hasilnya di halaman (jumlah berhasil / gagal)
 * 4. Setelah selesai dan berhasil, HAPUS method ini lagi dari controller
 *    (supaya tidak bisa diakses orang lain / tidak jalan dobel).
 */

public function backfillNoRm()
{
    $this->autoRender = false;
    $this->loadModel('MedicalRecords');
    $this->loadModel('Registrations');

    $schema = $this->MedicalRecords->getSchema();

    if (!$schema->hasColumn('medical_record_no')) {
        return $this->response->withStringBody(
            '<h3 style="color:red;">Kolom medical_record_no belum ada di tabel medical_records. '
            . 'Jalankan ALTER TABLE dulu, baru buka halaman ini lagi.</h3>'
        );
    }

    $emptyRecords = $this->MedicalRecords->find()
        ->where([
            'OR' => [
                ['MedicalRecords.medical_record_no IS' => null],
                ['MedicalRecords.medical_record_no' => ''],
            ],
        ])
        ->order(['MedicalRecords.id' => 'ASC'])
        ->all();

    $total = $emptyRecords->count();

    $log = [];
    $updated = 0;
    $failed = 0;

    if ($total === 0) {
        $log[] = 'Tidak ada rekam medis yang perlu di-backfill. Semua sudah punya medical_record_no.';
    }

    foreach ($emptyRecords as $medicalRecord) {
        $registration = null;

        if (!empty($medicalRecord->registration_id)) {
            try {
                $registration = $this->Registrations->get((int)$medicalRecord->registration_id);
            } catch (\Throwable $e) {
                $registration = null;
            }
        }

        $regDate = $registration->registration_date ?? ($medicalRecord->created ?? date('Y-m-d'));
        $ymd = (is_object($regDate) && method_exists($regDate, 'format'))
            ? $regDate->format('Ymd')
            : date('Ymd', strtotime((string)$regDate));

        $prefix = 'RM-' . $ymd . '-';

        $last = $this->MedicalRecords->find()
            ->where(['medical_record_no LIKE' => $prefix . '%'])
            ->order(['id' => 'DESC'])
            ->first();

        $lastSeq = $last ? (int)substr((string)$last->medical_record_no, strlen($prefix)) : 0;
        $noRm = $prefix . str_pad((string)($lastSeq + 1), 4, '0', STR_PAD_LEFT);

        $medicalRecord->medical_record_no = $noRm;

        if ($this->MedicalRecords->save($medicalRecord, ['atomic' => false])) {
            $updated++;
            $log[] = "OK &nbsp; registration_id={$medicalRecord->registration_id} &rarr; medical_record_no={$noRm}";
        } else {
            $failed++;
            $errorDetail = json_encode($medicalRecord->getErrors(), JSON_UNESCAPED_UNICODE);
            $log[] = "<span style='color:red;'>GAGAL registration_id={$medicalRecord->registration_id}: {$errorDetail}</span>";
        }
    }

    $html = '<div style="font-family:monospace; padding:20px; font-size:13px; line-height:1.6;">';
    $html .= '<h3>Backfill No Rekam Medis</h3>';
    $html .= '<p>Total diproses: <strong>' . $total . '</strong> | ';
    $html .= 'Berhasil: <strong style="color:green;">' . $updated . '</strong> | ';
    $html .= 'Gagal: <strong style="color:red;">' . $failed . '</strong></p>';
    $html .= '<hr>';
    $html .= implode('<br>', $log);
    $html .= '<hr><p style="color:#888;">Selesai. Sekarang hapus method backfillNoRm() ini dari controller.</p>';
    $html .= '</div>';

    return $this->response->withStringBody($html);
}
}