<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use Throwable;

class PatientHistoriesController extends AppController
{
    /**
     * Detail kegagalan penyimpanan EMR untuk pesan dan log.
     *
     * @var array|null
     */
    private $detailSaveError;

    public function index()
    {
        $this->Patients = $this->fetchTable('Patients');
        $this->Registrations = $this->fetchTable('Registrations');
        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $this->OutpatientVisitEmr = $this->fetchTable('OutpatientVisitEmr');

        // q dipakai ketika pasien sudah dipilih dari modal.
        // patient_search dipakai untuk isi pencarian di modal cari pasien.
        $q = trim((string)$this->request->getQuery('q', ''));
        $patientSearch = trim((string)$this->request->getQuery('patient_search', ''));

        $patient = null;
        $patientResults = [];
        $registrations = [];
        $detailData = [];
        $notFound = false;

        if ($patientSearch !== '') {
            $patientResults = $this->Patients->find()
                ->where([
                    'OR' => [
                        ['Patients.is_delete !=' => 1],
                        ['Patients.is_delete IS' => null],
                    ],
                ])
                ->where([
                    'OR' => [
                        'Patients.code LIKE' => '%' . $patientSearch . '%',
                        'Patients.full_name LIKE' => '%' . $patientSearch . '%',
                        'Patients.identity_number LIKE' => '%' . $patientSearch . '%',
                        'Patients.phone_number LIKE' => '%' . $patientSearch . '%',
                        'Patients.address LIKE' => '%' . $patientSearch . '%',
                        'Patients.mother_name LIKE' => '%' . $patientSearch . '%',
                        'Patients.father_name LIKE' => '%' . $patientSearch . '%',
                    ],
                ])
                ->order(['Patients.full_name' => 'ASC'])
                ->limit(50)
                ->all();
        }

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
                $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());
                $hasTable = function (string $table) use ($tables): bool {
                    return in_array(strtolower($table), $tables, true);
                };

                $registrationSchema = $connection->getSchemaCollection()->describe('registrations');
                $order = [];
                if ($registrationSchema->hasColumn('registration_date')) {
                    $order['Registrations.registration_date'] = 'DESC';
                }
                if ($registrationSchema->hasColumn('admission_time')) {
                    $order['Registrations.admission_time'] = 'DESC';
                }
                if ($registrationSchema->hasColumn('created')) {
                    $order['Registrations.created'] = 'DESC';
                }
                $order['Registrations.id'] = 'DESC';

                $contain = ['Patients'];
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
                    ->all();

                $detailTables = [
                    'examinations' => 'medical_record_examinations',
                    'prescriptions' => 'medical_record_prescriptions',
                    'laboratories' => 'medical_record_laboratories',
                    'radiologies' => 'medical_record_radiologies',
                    'surgeries' => 'medical_record_surgeries',
                    'integrations' => 'medical_record_integrations',
                    'icares' => 'medical_record_icares',
                    'documents' => 'medical_record_documents',
                    'referrals' => 'medical_record_referrals',
                ];

                foreach ($registrations as $registration) {
                    $outpatientVisit = null;
                    if ($hasTable('outpatient_visits')) {
                        $outpatientVisit = $this->OutpatientVisits->find()
                            ->where(['OutpatientVisits.registration_id' => (int)$registration->id])
                            ->order(['OutpatientVisits.id' => 'DESC'])
                            ->first();
                    }

                    $emrRowsAll = [];
                if ($outpatientVisit) {
                    $registration->set('outpatient_visit', $outpatientVisit);

                    if ($hasTable('outpatient_visit_emr')) {
                        $emrRowsAll = $this->OutpatientVisitEmr->find()
                            ->where(['OutpatientVisitEmr.outpatient_visit_id' => (int)$outpatientVisit->id])
                            ->order(['OutpatientVisitEmr.id' => 'ASC'])
                            ->all()
                            ->toArray();

                        if (!empty($emrRowsAll)) {
                            $registration->set('outpatient_visit_emr', end($emrRowsAll));
                            $registration->set('outpatient_visit_emr_all', $emrRowsAll);
                        }
                    }
                }

                    $cpptRows = [];
                    if ($outpatientVisit && $hasTable('outpatient_cppt_notes')) {
                        $this->OutpatientCpptNotes = $this->fetchTable('OutpatientCpptNotes');
                        $cpptRows = $this->OutpatientCpptNotes->find()
                            ->where(['OutpatientCpptNotes.outpatient_visit_id' => (int)$outpatientVisit->id])
                            ->order(['OutpatientCpptNotes.noted_at' => 'ASC', 'OutpatientCpptNotes.id' => 'ASC'])
                            ->all()
                            ->toArray();
                    }
                    
                    $PatientHistory = $this->readPatientHistoryRow($connection, $hasTable, $registration->id);
                    if ($PatientHistory) {
                        $registration->set('medical_record', $PatientHistory);
                    }

                    if (!empty($outpatientVisit) && !empty($registration->outpatient_visit_emr)) {
                        $visitEmrUserId = is_object($registration->outpatient_visit_emr)
                            ? ($registration->outpatient_visit_emr->created_by_user_id ?? null)
                            : ($registration->outpatient_visit_emr['created_by_user_id'] ?? null);

                        $creatorName = $this->resolveUserName($connection, $hasTable, $visitEmrUserId);
                        if ($creatorName) {
                            $registration->set('history_created_by', $creatorName);
                        }
                    }

                    $detailData[$registration->id] = [];
                    foreach ($detailTables as $key => $table) {
                        $detailData[$registration->id][$key] = $this->readDetailRows(
                            $connection,
                            $hasTable,
                            $table,
                            $PatientHistory['id'] ?? $PatientHistory->id ?? null
                        );
                    }
                    $detailData[$registration->id]['emr_all'] = $emrRowsAll; 
                    $detailData[$registration->id]['cppt'] = $cpptRows;
                }
            } else {
                $notFound = true;
            }
        }

        $historyGroups = [];
        foreach ($registrations as $registration) {
            $details = $detailData[$registration->id] ?? [];

            $PatientHistory = $registration->medical_record ?? null;
            $historyId = null;
            $storedHistoryNo = null;
            if (is_array($PatientHistory)) {
                $historyId = $PatientHistory['id'] ?? null;
                $storedHistoryNo = $PatientHistory['history_no'] ?? null;
            } elseif (is_object($PatientHistory)) {
                $historyId = $PatientHistory->id ?? null;
                $storedHistoryNo = $PatientHistory->history_no ?? null;
            }

            $regDate = $registration->registration_date
                ?? $registration->visit_date
                ?? $registration->created
                ?? null;

            $dateForCode = (is_object($regDate) && method_exists($regDate, 'format'))
                ? $regDate->format('ymd')
                : ($regDate ? date('ymd', strtotime((string)$regDate)) : date('ymd'));

            // NO REGISTRASI ASLI (mis. "RJ2026-0000005" untuk Rawat Jalan,
            // beda prefix untuk IGD/Rawat Inap sesuai jenis pelayanan).
            // Ini HARUS sama persis dengan yang tampil di menu Daftar Registrasi
            // Pasien, jadi jangan generate kode sendiri kalau nomor aslinya ada.
            $realRegistrationNo = $registration->registration_no
                ?? $registration->registration_number
                ?? $registration->no_registrasi
                ?? $registration->code
                ?? null;

            $regCode = $realRegistrationNo
                ?: ($storedHistoryNo
                    ? str_replace('RWT', 'REG', $storedHistoryNo)
                    : ('REG' . $dateForCode . sprintf('%04d', (int)($historyId ?? $registration->id))));

            // Setiap JENIS data (tab) yang punya isi -> jadi satu (atau beberapa)
            // entri RWT tersendiri, diberi label jenisnya. Tab yang belum pernah
            // diisi untuk registrasi ini TIDAK memunculkan entri sama sekali.
            $typeConfig = [
                'soap'         => ['label' => 'soap', 'keys' => ['examinations', 'emr_all'], 'date_fields' => ['created', 'noted_at', 'date'], 'collapse' => true],
                'resep'        => ['label' => 'resep', 'keys' => ['prescriptions'], 'date_fields' => ['tgl_resep', 'tanggal_resep', 'prescription_date', 'date', 'created'], 'collapse' => true],
                'penunjang'    => ['label' => 'penunjang medis', 'keys' => ['penunjang'], 'date_fields' => ['tanggal', 'date', 'created'], 'collapse' => false],
                'laboratorium' => ['label' => 'laboratorium', 'keys' => ['laboratories'], 'date_fields' => ['tanggal', 'date', 'created'], 'collapse' => false],
                'radiologi'    => ['label' => 'radiologi', 'keys' => ['radiologies'], 'date_fields' => ['tanggal', 'date', 'created'], 'collapse' => false],
                'bedah'        => ['label' => 'tindakan bedah', 'keys' => ['surgeries'], 'date_fields' => ['created', 'tanggal', 'date'], 'collapse' => false],
                'integrasi'    => ['label' => 'form integrasi', 'keys' => ['cppt'], 'date_fields' => ['noted_at', 'created'], 'collapse' => false],
                'icare'        => ['label' => 'icare', 'keys' => ['icares'], 'date_fields' => ['date', 'created'], 'collapse' => false],
            ];

            $entries = [];
            foreach ($typeConfig as $type => $cfg) {
                $rows = [];
                foreach ($cfg['keys'] as $key) {
                    $rows = array_merge($rows, $details[$key] ?? []);
                }

                if ($type === 'resep') {
                    foreach ($details['emr_all'] ?? [] as $emrRow) {
                        $emrValues = (is_object($emrRow) && method_exists($emrRow, 'toArray'))
                            ? $emrRow->toArray()
                            : (array)$emrRow;

                        if (!empty($emrValues['prescription_notes'])) {
                            $rows[] = $emrRow;
                        }
                    }
                }

                if (empty($rows)) {
                    continue;
                }

                $typeEntries = $this->buildTypeEntries($rows, $cfg['date_fields']);

                if (!empty($cfg['collapse']) && !empty($typeEntries)) {
                    usort($typeEntries, function ($a, $b) {
                        $ta = $a['ts'] ? (is_numeric($a['ts']) ? (int)$a['ts'] : strtotime((string)$a['ts'])) : 0;
                        $tb = $b['ts'] ? (is_numeric($b['ts']) ? (int)$b['ts'] : strtotime((string)$b['ts'])) : 0;
                        return $ta <=> $tb;
                    });

                    $firstEntry = $typeEntries[0];
                    $lastEntry  = end($typeEntries);

                    $codeDate = $firstEntry['ts']
                        ? date('ymd', is_numeric($firstEntry['ts']) ? (int)$firstEntry['ts'] : strtotime((string)$firstEntry['ts']))
                        : $dateForCode;

                    $entries[] = [
                        'id' => $registration->id,
                        'type' => $type,
                        'type_label' => $cfg['label'],
                        'history_no' => 'RWT' . $codeDate . sprintf('%04d', (int)($firstEntry['id'] ?? $registration->id)),
                        'date' => $lastEntry['ts'],
                        'time' => $lastEntry['ts'],
                    ];

                    continue;
                }

                foreach ($typeEntries as $row) {
                    $ts = $row['ts'];
                    $sourceId = $row['id'] ?? $registration->id;

                    $codeDate = $ts
                        ? date('ymd', is_numeric($ts) ? (int)$ts : strtotime((string)$ts))
                        : $dateForCode;

                    $entries[] = [
                        'id' => $registration->id,
                        'type' => $type,
                        'type_label' => $cfg['label'],
                        'history_no' => 'RWT' . $codeDate . sprintf('%04d', (int)$sourceId),
                        'date' => $ts,
                        'time' => $ts,
                    ];
                }
            }

            if (empty($entries) && $storedHistoryNo) {
                $entries[] = [
                    'id' => $registration->id,
                    'type' => 'soap',
                    'type_label' => 'soap',
                    'history_no' => $storedHistoryNo,
                    'date' => $regDate,
                    'time' => $registration->admission_time ?? $registration->visit_time ?? null,
                ];
            }

            // Urutkan dari aktivitas paling lama ke paling baru dalam satu REG.
            usort($entries, function ($a, $b) {
                $ta = $a['date'] ? (is_numeric($a['date']) ? (int)$a['date'] : strtotime((string)$a['date'])) : 0;
                $tb = $b['date'] ? (is_numeric($b['date']) ? (int)$b['date'] : strtotime((string)$b['date'])) : 0;
                return $ta <=> $tb;
            });

            $historyGroups[] = [
                'reg_id' => $registration->id,
                'reg_code' => $regCode,
                'entries' => $entries,
            ];
        }

                $this->set(compact(
                    'q',
                    'patientSearch',
                    'patientResults',
                    'patient',
                    'registrations',
                    'detailData',
                    'notFound',
                    'historyGroups'
                ));
            }

private function buildTypeEntries(array $rows, array $dateFields): array
{
    $out = [];
    foreach ($rows as $row) {
        if (is_object($row) && method_exists($row, 'toArray')) {
            $values = $row->toArray();
        } else {
            $values = is_array($row) ? $row : (array)$row;
        }

        $id = $values['id'] ?? null;
        $ts = null;
        foreach ($dateFields as $field) {
            if (!empty($values[$field])) {
                $ts = $values[$field];
                break;
            }
        }

        $out[] = ['id' => $id, 'ts' => $ts];
    }
    return $out;
}

private function resolveUserName($connection, callable $hasTable, $userId): ?string
{
    if (empty($userId) || !$hasTable('users')) {
        return null;
    }

    static $cache = [];
    if (array_key_exists((int)$userId, $cache)) {
        return $cache[(int)$userId];
    }

    $schema = $connection->getSchemaCollection()->describe('users');
    $nameColumn = null;
    foreach (['full_name', 'name', 'username'] as $candidate) {
        if ($schema->hasColumn($candidate)) {
            $nameColumn = $candidate;
            break;
        }
    }

    if (!$nameColumn) {
        $cache[(int)$userId] = null;
        return null;
    }

    $sql = 'SELECT ' . $connection->quoteIdentifier($nameColumn) . ' AS name'
        . ' FROM ' . $connection->quoteIdentifier('users')
        . ' WHERE ' . $connection->quoteIdentifier('id') . ' = :id'
        . ' LIMIT 1';

    $row = $connection->execute($sql, ['id' => (int)$userId])->fetch('assoc');
    $cache[(int)$userId] = $row['name'] ?? null;

    return $cache[(int)$userId];
}

    public function searchPatients()
{
    $this->request->allowMethod(['get']);
    $this->Patients = $this->fetchTable('Patients');

    $term = trim((string)$this->request->getQuery('term', ''));
    $limit = (int)$this->request->getQuery('limit', 50);
    if ($limit <= 0 || $limit > 100) {
        $limit = 50;
    }

    $query = $this->Patients->find()
        ->select([
            'id', 'code', 'full_name', 'birth_date', 'gender', 'address',
            'phone_number', 'identity_type', 'identity_number', 'blood_type',
            'city', 'province', 'subdistrict', 'district',
            'mother_name', 'father_name', 'is_active',
        ])
        ->where([
            'OR' => [
                ['Patients.is_delete !=' => 1],
                ['Patients.is_delete IS' => null],
            ],
        ]);

    // Hanya filter kalau term diisi. Kalau kosong, tampilkan daftar default.
    if ($term !== '') {
        $query->where([
            'OR' => [
                'Patients.code LIKE' => '%' . $term . '%',
                'Patients.full_name LIKE' => '%' . $term . '%',
                'Patients.identity_number LIKE' => '%' . $term . '%',
                'Patients.phone_number LIKE' => '%' . $term . '%',
                'Patients.address LIKE' => '%' . $term . '%',
                'Patients.mother_name LIKE' => '%' . $term . '%',
                'Patients.father_name LIKE' => '%' . $term . '%',
                'Patients.city LIKE' => '%' . $term . '%',
                'Patients.province LIKE' => '%' . $term . '%',
                'Patients.subdistrict LIKE' => '%' . $term . '%',
                'Patients.district LIKE' => '%' . $term . '%',
            ],
        ]);
    }

    $query->order([
        'Patients.full_name' => 'ASC',
        'Patients.id' => 'DESC',
    ])->limit($limit);

    $patients = [];
    foreach ($query as $row) {
        $birthDate = '';
        if (!empty($row->birth_date) && is_object($row->birth_date) && method_exists($row->birth_date, 'format')) {
            $birthDate = $row->birth_date->format('d-m-Y');
        } elseif (!empty($row->birth_date)) {
            $birthDate = date('d-m-Y', strtotime((string)$row->birth_date));
        }

        $gender = strtolower((string)($row->gender ?? ''));
        if (in_array($gender, ['male', 'm', 'l', 'laki-laki', 'pria'], true)) {
            $genderText = 'P';
        } elseif (in_array($gender, ['female', 'f', 'p', 'perempuan', 'wanita'], true)) {
            $genderText = 'W';
        } else {
            $genderText = $row->gender ? strtoupper(substr((string)$row->gender, 0, 1)) : '';
        }

        $patients[] = [
            'id' => $row->id,
            'code' => (string)($row->code ?? ''),
            'full_name' => (string)($row->full_name ?? ''),
            'birth_date' => $birthDate,
            'gender' => $genderText,
            'address' => (string)($row->address ?? ''),
            'phone_number' => (string)($row->phone_number ?? ''),
            'identity_number' => (string)($row->identity_number ?? ''),
            'card_no' => '',
        ];
    }

    $payload = [
        'success' => true,
        'term' => $term,
        'data' => $patients,
    ];

    $this->autoRender = false;
    return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($payload, JSON_UNESCAPED_UNICODE));
}

    public function periksa($outpatientVisitId = null)
    {
        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $this->PatientHistorys = $this->fetchTable('PatientHistorys');

        $visit = $this->OutpatientVisits->get($outpatientVisitId, [
            'contain' => ['Patients', 'Doctors', 'Registrations'],
        ]);

        $PatientHistory = null;
        $connection = $this->PatientHistorys->getConnection();
        $savedDetail = false;
        $this->detailSaveError = null;

        $isSubmit = $this->request->is(['patch', 'post', 'put']);

        // GET (baru buka halaman periksa) ATAU POST dengan data belum valid:
        // JANGAN bikin baris patient_histories baru. Cuma tampilkan yang sudah
        // ada (kalau memang sudah pernah disimpan sebelumnya). Ini supaya
        // riwayat pasien tidak muncul duluan sebelum EMR benar-benar disimpan.
        if (!$isSubmit || !$this->hasRequiredEmrFields($this->request->getData())) {
            $PatientHistory = $this->findPatientHistory((int)$visit->registration_id);
            $details = $PatientHistory ? $this->readPatientHistoryDetails((int)$PatientHistory->id) : [];

            if ($isSubmit) {
                $this->Flash->error(__('Keluhan awal dan diagnosa wajib diisi sebelum EMR disimpan.'));
            }

            $this->set(compact('visit', 'PatientHistory', 'details'));
            return;
        }

        // Dari sini hanya jalan kalau POST/PATCH/PUT dan data sudah valid.
        // Baris patient_histories baru DIBUAT DI SINI, di dalam transaction yang
        // sama dengan penyimpanan detail EMR-nya.
        try {
            $success = $connection->transactional(function () use ($visit, &$PatientHistory, &$savedDetail) {
                $PatientHistory = $this->findOrCreatePatientHistory((int)$visit->registration_id);

                if (!$PatientHistory) {
                    $this->detailSaveError = [
                        'table' => 'patient_histories',
                        'reason' => 'medical_record_save_failed',
                        'columns' => [],
                    ];

                    return false;
                }

                $savedDetail = $this->savePatientHistoryDetails(
                    (int)$PatientHistory->id,
                    $this->request->getData()
                );

                if (!$savedDetail) {
                    return false;
                }

                return true;
            });
        } catch (Throwable $exception) {
            $success = false;
            $this->detailSaveError = [
                'reason' => 'exception',
                'message' => $exception->getMessage(),
            ];
        }

        if (!$success) {
            Log::error('Gagal menyimpan detail medical record.', [
                'outpatient_visit_id' => $outpatientVisitId,
                'registration_id' => $visit->registration_id,
                'patient_history_id' => $PatientHistory->id ?? null,
                'error' => $this->detailSaveError,
            ]);
            $this->Flash->error(__(
                'Medical record gagal disimpan karena struktur database EMR belum lengkap atau terjadi kesalahan. '
                . 'Tidak ada perubahan data yang disimpan.'
            ));

            return $this->redirect(['action' => 'periksa', $outpatientVisitId]);
        }

        $this->Flash->success(__('Data pemeriksaan berhasil disimpan.'));
        return $this->redirect(['action' => 'periksa', $outpatientVisitId]);
    }

    /**
     * Cari riwayat (patient_histories) yang SUDAH ADA untuk registrasi ini.
     * TIDAK membuat baris baru — dipakai untuk GET / data belum valid, supaya
     * riwayat tidak muncul di tab Riwayat Pasien sebelum EMR benar-benar disimpan.
     */
    private function findPatientHistory(int $registrationId)
    {
        if (empty($registrationId)) {
            return null;
        }

        return $this->PatientHistorys->find()
            ->where([
                'PatientHistorys.registration_id' => $registrationId,
                'OR' => [
                    ['PatientHistorys.is_delete' => 0],
                    ['PatientHistorys.is_delete IS' => null],
                ],
            ])
            ->order(['PatientHistorys.id' => 'DESC'])
            ->first();
    }

    private function findOrCreatePatientHistory(int $registrationId)
    {
        if (empty($registrationId)) {
            return null;
        }

        $PatientHistory = $this->findPatientHistory($registrationId);

        if ($PatientHistory) {
            return $PatientHistory;
        }

        // Generate kode riwayat (RWT...) sekali saat baris pertama kali dibuat,
        // lalu disimpan permanen di kolom patient_histories.history_no.
        $historyNo = $this->generateHistoryNo($registrationId);

        $PatientHistory = $this->PatientHistorys->newEmptyEntity();
        $PatientHistory = $this->PatientHistorys->patchEntity($PatientHistory, [
            'registration_id' => $registrationId,
            'user_id' => $this->getCurrentUserId(),
            'status' => 'Draft',
            'history_no' => $historyNo,
            'is_create' => 1,
            'is_update' => 0,
            'is_delete' => 0,
            'is_active' => 'Y',
            'created' => date('Y-m-d H:i:s'),
        ]);

        return $this->PatientHistorys->save($PatientHistory);
    }

    /**
     * Generate kode riwayat (RWT...) berbasis tanggal hari ini + id registrasi asli.
     * Dipanggil SEKALI saja saat baris patient_histories pertama kali dibuat, lalu disimpan permanen
     * di kolom patient_histories.history_no (tidak dihitung ulang setiap request).
     */
    private function generateHistoryNo(int $registrationId): string
    {
        return 'RWT' . date('ymd') . sprintf('%04d', $registrationId);
    }

    private function hasRequiredEmrFields(array $data): bool
    {
        $complaint = $data['chief_complaint'] ?? $data['subjective'] ?? null;
        $diagnosis = $data['diagnosis_primary'] ?? $data['admission_diagnosis'] ?? $data['assessment'] ?? null;

        return trim((string)$complaint) !== '' && trim((string)$diagnosis) !== '';
    }

    private function savePatientHistoryDetails(int $PatientHistoryId, array $data): bool
    {
        $status = $data['status'] ?? 'Draft';
        $saved = true;
        $examinationNote = $this->buildExaminationNote($data);

        if ($examinationNote !== '') {
            $saved = $saved && $this->saveDetailRow('medical_record_examinations', $PatientHistoryId, [
                'status' => $status,
                'note' => $examinationNote,
            ]);
        }

        if (!empty($data['prescription_notes'])) {
            $saved = $saved && $this->saveDetailRow('medical_record_prescriptions', $PatientHistoryId, [
                'status' => $status,
                'note' => trim((string)$data['prescription_notes']),
            ]);
        }

        if (!empty($data['laboratory_note'])) {
            $saved = $saved && $this->saveDetailRow('medical_record_laboratories', $PatientHistoryId, [
                'status' => $status,
                'note' => trim((string)$data['laboratory_note']),
            ]);
        }

        if (!empty($data['radiology_note'])) {
            $saved = $saved && $this->saveDetailRow('medical_record_radiologies', $PatientHistoryId, [
                'status' => $status,
                'note' => trim((string)$data['radiology_note']),
            ]);
        }

        $hasReferral = !empty($data['referral_no'])
            || !empty($data['referral_type'])
            || !empty($data['referral_note']);

        if ($hasReferral) {
            $saved = $saved && $this->saveDetailRow('medical_record_referrals', $PatientHistoryId, [
                'status' => $status,
                'referral_no' => $data['referral_no'] ?? null,
                'referral_type' => $data['referral_type'] ?? null,
                'note' => $data['referral_note'] ?? null,
            ]);
        }

        return $saved;
    }

    private function buildExaminationNote(array $data): string
    {
        $sections = [];
        $cpptMeta = [];

        foreach ([
            'noted_at' => 'Waktu CPPT',
            'profession' => 'Profesi',
            'officer_name' => 'Petugas',
            'str_number' => 'STR',
        ] as $field => $label) {
            if (!empty($data[$field])) {
                $cpptMeta[] = $label . ': ' . trim((string)$data[$field]);
            }
        }

        if ($cpptMeta) {
            $sections[] = "CPPT\n" . implode("\n", $cpptMeta);
        }

        $soap = [
            'Subjective' => $data['subjective'] ?? null,
            'Objective' => $data['objective'] ?? null,
            'Assessment' => $data['assessment'] ?? null,
            'Plan' => $data['plan'] ?? null,
        ];

        $soapNote = $this->formatNoteBlock($soap);
        if ($soapNote !== '') {
            $sections[] = "SOAP\n" . $soapNote;
        }

        $vitals = [
            'Tekanan Darah' => $data['blood_pressure'] ?? null,
            'Nadi' => $data['pulse'] ?? null,
            'Respirasi' => $data['respiratory_rate'] ?? null,
            'Suhu' => $data['temperature'] ?? null,
            'SpO2' => $data['oxygen_saturation'] ?? null,
            'Berat Badan' => $data['weight'] ?? null,
            'Tinggi Badan' => $data['height'] ?? null,
            'Skala Nyeri' => $data['pain_scale'] ?? null,
        ];

        $vitalNote = $this->formatNoteBlock($vitals);
        if ($vitalNote !== '') {
            $sections[] = "Tanda Vital\n" . $vitalNote;
        }

        $clinical = [
            'Alergi' => $data['allergy'] ?? null,
            'Diagnosa Utama' => $data['diagnosis_primary'] ?? null,
            'Diagnosa Sekunder' => $data['diagnosis_secondary'] ?? null,
            'Tindakan' => $data['action_notes'] ?? null,
            'Catatan Dokter' => $data['doctor_notes'] ?? null,
            'Catatan Pemeriksaan' => $data['note'] ?? null,
        ];

        $clinicalNote = $this->formatNoteBlock($clinical);
        if ($clinicalNote !== '') {
            $sections[] = "Klinis\n" . $clinicalNote;
        }

        return trim(implode("\n\n", $sections));
    }

    private function formatNoteBlock(array $items): string
    {
        $lines = [];
        foreach ($items as $label => $value) {
            $value = trim((string)$value);
            if ($value !== '') {
                $lines[] = $label . ': ' . $value;
            }
        }

        return implode("\n", $lines);
    }

    /**
     * Beberapa tabel detail EMR memakai nama kolom FK yang berbeda-beda
     * (medical_record_id, patient_history_id, dst). Cek yang benar-benar ada di skema.
     */
    private function resolveForeignKeyColumn($schema): ?string
    {
        foreach (['medical_record_id', 'patient_history_id'] as $candidate) {
            if ($schema->hasColumn($candidate)) {
                return $candidate;
            }
        }
        return null;
    }

    private function saveDetailRow(string $table, int $PatientHistoryId, array $data): bool
    {
        $connection = ConnectionManager::get('default');
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());

        if (!in_array(strtolower($table), $tables, true)) {
            return $this->failDetailSave($table, 'table_missing');
        }

        $schema = $connection->getSchemaCollection()->describe($table);
        $foreignKey = $this->resolveForeignKeyColumn($schema);

        if (!$foreignKey) {
            return $this->failDetailSave($table, 'column_missing', ['medical_record_id']);
        }

        $data[$foreignKey] = $PatientHistoryId;

        $data += [
            'is_create' => 1,
            'is_update' => 0,
            'is_delete' => 0,
            'is_active' => 'Y',
            'created' => date('Y-m-d H:i:s'),
        ];

        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        $optionalColumns = ['is_create', 'is_update', 'is_delete', 'is_active', 'created'];
        $requiredColumns = array_diff(array_keys($data), $optionalColumns);
        $missingColumns = array_values(array_filter($requiredColumns, function ($column) use ($schema) {
            return !$schema->hasColumn($column);
        }));

        if ($missingColumns) {
            return $this->failDetailSave($table, 'column_missing', $missingColumns);
        }

        $data = array_intersect_key($data, array_flip($schema->columns()));

        if (empty($data)) {
            return $this->failDetailSave($table, 'empty_payload');
        }

        if ($this->isRecentDuplicateDetail($connection, $table, $foreignKey, $data, $schema)) {
            return true;
        }

        $inserted = (bool)$connection->insert($table, $data);
        if (!$inserted) {
            return $this->failDetailSave($table, 'insert_failed');
        }

        return true;
    }

    private function failDetailSave(string $table, string $reason, array $columns = []): bool
    {
        $this->detailSaveError = [
            'table' => $table,
            'reason' => $reason,
            'columns' => $columns,
        ];

        return false;
    }

    private function isRecentDuplicateDetail($connection, string $table, string $foreignKey, array $data, $schema): bool
    {
        if (empty($data[$foreignKey]) || !$schema->hasColumn('created')) {
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

        $deleteCondition = $schema->hasColumn('is_delete')
            ? ' AND (`is_delete` = 0 OR `is_delete` IS NULL)'
            : '';

        $sql = 'SELECT id FROM `' . $table . '`
            WHERE `' . $foreignKey . '` = :foreign_value
                AND `' . $compareColumn . '` = :compare_value
                ' . $deleteCondition . '
                AND `created` >= DATE_SUB(NOW(), INTERVAL 30 SECOND)
            ORDER BY `id` DESC
            LIMIT 1';

        return (bool)$connection->execute($sql, [
            'foreign_value' => (int)$data[$foreignKey],
            'compare_value' => (string)$data[$compareColumn],
        ])->fetch('assoc');
    }

    private function readPatientHistoryDetails(int $PatientHistoryId): array
    {
        $connection = ConnectionManager::get('default');
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());
        $detailTables = [
            'examinations' => 'medical_record_examinations',
            'prescriptions' => 'medical_record_prescriptions',
            'laboratories' => 'medical_record_laboratories',
            'radiologies' => 'medical_record_radiologies',
            'surgeries' => 'medical_record_surgeries',
            'integrations' => 'medical_record_integrations',
            'icares' => 'medical_record_icares',
            'documents' => 'medical_record_documents',
            'referrals' => 'medical_record_referrals',
        ];

        $details = [];
        foreach ($detailTables as $key => $table) {
            if (!in_array($table, $tables, true)) {
                $details[$key] = [];
                continue;
            }

            $schema = $connection->getSchemaCollection()->describe($table);
            $foreignKey = $this->resolveForeignKeyColumn($schema);

            if (!$foreignKey) {
                $details[$key] = [];
                continue;
            }

            $orderSql = $schema->hasColumn('id') ? ' ORDER BY ' . $connection->quoteIdentifier('id') . ' DESC' : '';
            $sql = 'SELECT * FROM ' . $connection->quoteIdentifier($table)
                . ' WHERE ' . $connection->quoteIdentifier($foreignKey) . ' = :foreign_value'
                . $orderSql
                . ' LIMIT 50';

            $details[$key] = $connection->execute($sql, ['foreign_value' => $PatientHistoryId])->fetchAll('assoc');
        }

        return $details;
    }

    public function history($patientId = null)
    {
        $this->Patients = $this->fetchTable('Patients');
        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $this->OutpatientVisitEmr = $this->fetchTable('OutpatientVisitEmr');

        $patient = $this->Patients->get($patientId);
        $connection = ConnectionManager::get('default');
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());
        $hasTable = function (string $table) use ($tables): bool {
            return in_array(strtolower($table), $tables, true);
        };
        $hasColumn = function (string $table, string $column) use ($connection, $hasTable): bool {
            if (!$hasTable($table)) {
                return false;
            }

            return $connection->getSchemaCollection()->describe($table)->hasColumn($column);
        };

        $contain = ['Patients', 'Doctors', 'Registrations'];

        $visits = $this->OutpatientVisits->find()
            ->contain($contain)
            ->where(['OutpatientVisits.patient_id' => (int)$patientId])
            ->order(['OutpatientVisits.visit_date' => 'DESC', 'OutpatientVisits.id' => 'DESC'])
            ->all();

        $detailTables = [
            'examinations' => 'medical_record_examinations',
            'prescriptions' => 'medical_record_prescriptions',
            'laboratories' => 'medical_record_laboratories',
            'radiologies' => 'medical_record_radiologies',
            'surgeries' => 'medical_record_surgeries',
            'integrations' => 'medical_record_integrations',
            'icares' => 'medical_record_icares',
        ];

        $detailData = [];
        foreach ($visits as $visit) {
            $PatientHistory = $this->readPatientHistoryRow(
                $connection,
                $hasTable,
                $visit->registration_id ?? null
            );

            if ($PatientHistory) {
                $visit->set('medical_record', $PatientHistory);
            }

            $detailData[$visit->id] = [];
            $emrRowsAll = [];
            if ($hasTable('outpatient_visit_emr')) {
                $emrRowsAll = $this->OutpatientVisitEmr->find()
                    ->where(['OutpatientVisitEmr.outpatient_visit_id' => (int)$visit->id])
                    ->order(['OutpatientVisitEmr.id' => 'ASC'])
                    ->all()
                    ->toArray();
            }

            foreach ($detailTables as $key => $table) {
                $detailData[$visit->id][$key] = $this->readDetailRows(
                    $connection,
                    $hasTable,
                    $table,
                    $PatientHistory['id'] ?? $PatientHistory->id ?? null
                );
            }

            $detailData[$visit->id]['emr_all'] = $emrRowsAll;
        }

        $registrations = $visits;
        $this->set(compact('patient', 'registrations', 'detailData'));
    }

    private function readPatientHistoryRow($connection, callable $hasTable, $registrationId)
    {
        if (!$hasTable('patient_histories')) {
            return null;
        }

        $schema = $connection->getSchemaCollection()->describe('patient_histories');
        if ($registrationId && $schema->hasColumn('registration_id')) {
            $foreignKey = 'registration_id';
            $foreignValue = (int)$registrationId;
        } else {
            return null;
        }

        $sql = 'SELECT * FROM ' . $connection->quoteIdentifier('patient_histories')
            . ' WHERE ' . $connection->quoteIdentifier($foreignKey) . ' = :foreign_value'
            . ' ORDER BY ' . $connection->quoteIdentifier('id') . ' DESC'
            . ' LIMIT 1';

        return $connection->execute($sql, ['foreign_value' => $foreignValue])->fetch('assoc') ?: null;
    }

    private function readDetailRows($connection, callable $hasTable, string $table, $PatientHistoryId): array
    {
        if (!$hasTable($table)) {
            return [];
        }

        $schema = $connection->getSchemaCollection()->describe($table);
        $foreignKey = $this->resolveForeignKeyColumn($schema);

        if (!$PatientHistoryId || !$foreignKey) {
            return [];
        }

        $orderSql = $schema->hasColumn('id') ? ' ORDER BY ' . $connection->quoteIdentifier('id') . ' DESC' : '';
        $sql = 'SELECT * FROM ' . $connection->quoteIdentifier($table)
            . ' WHERE ' . $connection->quoteIdentifier($foreignKey) . ' = :foreign_value'
            . $orderSql
            . ' LIMIT 50';

        return $connection->execute($sql, ['foreign_value' => (int)$PatientHistoryId])->fetchAll('assoc');
    }

    
}
