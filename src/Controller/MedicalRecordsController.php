<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use Throwable;

class MedicalRecordsController extends AppController
{
    /**
     * Detail kegagalan penyimpanan EMR untuk pesan dan log.
     *
     * @var array|null
     */
    private $detailSaveError;

    public function index()
    {
        $this->loadModel('OutpatientVisits');

        $dateFrom = $this->request->getQuery('date_from', date('Y-m-d'));
        $dateTo = $this->request->getQuery('date_to', date('Y-m-d'));
        $q = $this->request->getQuery('q');
        $status = $this->request->getQuery('status');

        if ($dateTo < $dateFrom) {
            $dateTo = $dateFrom;
        }

        $conditions = [
            'OutpatientVisits.visit_date >=' => $dateFrom,
            'OutpatientVisits.visit_date <=' => $dateTo,
        ];

        if (!empty($status)) {
            $conditions['OutpatientVisits.status'] = $status;
        }

        if (!empty($q)) {
            $conditions['OR'] = [
                'OutpatientVisits.registration_no LIKE' => '%' . $q . '%',
                'Patients.full_name LIKE' => '%' . $q . '%',
                'Doctors.doctor_name LIKE' => '%' . $q . '%',
            ];
        }

        $this->paginate = [
            'contain' => ['Patients', 'Doctors', 'Registrations'],
            'conditions' => $conditions,
            'order' => ['OutpatientVisits.visit_date' => 'ASC', 'OutpatientVisits.queue_number' => 'ASC'],
            'limit' => 50,
        ];

        $visits = $this->paginate($this->OutpatientVisits);

        $this->set(compact('visits', 'dateFrom', 'dateTo', 'q', 'status'));
    }

    public function periksa($outpatientVisitId = null)
    {
        $this->loadModel('OutpatientVisits');
        $this->loadModel('MedicalRecords');

        $visit = $this->OutpatientVisits->get($outpatientVisitId, [
            'contain' => ['Patients', 'Doctors', 'Registrations'],
        ]);

        $medicalRecord = null;
        $connection = $this->MedicalRecords->getConnection();
        $savedDetail = false;
        $this->detailSaveError = null;

        if ($this->request->is(['patch', 'post', 'put']) && !$this->hasRequiredEmrFields($this->request->getData())) {
            $medicalRecord = $this->findOrCreateMedicalRecord((int)$visit->registration_id);
            $details = $medicalRecord ? $this->readMedicalRecordDetails((int)$medicalRecord->id) : [];
            $this->Flash->error(__('Keluhan awal dan diagnosa wajib diisi sebelum EMR disimpan.'));
            $this->set(compact('visit', 'medicalRecord', 'details'));
            return;
        }

        try {
            $success = $connection->transactional(function () use ($visit, &$medicalRecord, &$savedDetail) {
                $medicalRecord = $this->findOrCreateMedicalRecord((int)$visit->registration_id);

                if (!$medicalRecord) {
                    $this->detailSaveError = [
                        'table' => 'medical_records',
                        'reason' => 'medical_record_save_failed',
                        'columns' => [],
                    ];

                    return false;
                }

                if ($this->request->is(['patch', 'post', 'put'])) {
                    $savedDetail = $this->saveMedicalRecordDetails(
                        (int)$medicalRecord->id,
                        $this->request->getData()
                    );

                    if (!$savedDetail) {
                        return false;
                    }
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
                'medical_record_id' => $medicalRecord->id ?? null,
                'error' => $this->detailSaveError,
            ]);
            $this->Flash->error(__(
                'Medical record gagal disimpan karena struktur database EMR belum lengkap atau terjadi kesalahan. '
                . 'Tidak ada perubahan data yang disimpan.'
            ));

            return $this->redirect(['action' => 'periksa', $outpatientVisitId]);
        }

        if ($savedDetail) {
            $this->Flash->success(__('Data pemeriksaan berhasil disimpan.'));
            return $this->redirect(['action' => 'periksa', $outpatientVisitId]);
        }

        $details = $this->readMedicalRecordDetails((int)$medicalRecord->id);
        $this->set(compact('visit', 'medicalRecord', 'details'));
    }

    private function findOrCreateMedicalRecord(int $registrationId)
    {
        if (empty($registrationId)) {
            return null;
        }

        $medicalRecord = $this->MedicalRecords->find()
            ->where([
                'MedicalRecords.registration_id' => $registrationId,
                'OR' => [
                    ['MedicalRecords.is_delete' => 0],
                    ['MedicalRecords.is_delete IS' => null],
                ],
            ])
            ->order(['MedicalRecords.id' => 'DESC'])
            ->first();

        if ($medicalRecord) {
            return $medicalRecord;
        }

        $medicalRecord = $this->MedicalRecords->newEmptyEntity();
        $medicalRecord = $this->MedicalRecords->patchEntity($medicalRecord, [
            'registration_id' => $registrationId,
            'status' => 'Draft',
            'is_create' => 1,
            'is_update' => 0,
            'is_delete' => 0,
            'is_active' => 'Y',
            'created' => date('Y-m-d H:i:s'),
        ]);

        return $this->MedicalRecords->save($medicalRecord);
    }

    private function hasRequiredEmrFields(array $data): bool
    {
        $complaint = $data['chief_complaint'] ?? $data['subjective'] ?? null;
        $diagnosis = $data['diagnosis_primary'] ?? $data['admission_diagnosis'] ?? $data['assessment'] ?? null;

        return trim((string)$complaint) !== '' && trim((string)$diagnosis) !== '';
    }

    private function saveMedicalRecordDetails(int $medicalRecordId, array $data): bool
    {
        $status = $data['status'] ?? 'Draft';
        $saved = true;
        $examinationNote = $this->buildExaminationNote($data);

        if ($examinationNote !== '') {
            $saved = $saved && $this->saveDetailRow('medical_record_examinations', [
                'medical_record_id' => $medicalRecordId,
                'status' => $status,
                'note' => $examinationNote,
            ]);
        }

        if (!empty($data['prescription_notes'])) {
            $saved = $saved && $this->saveDetailRow('medical_record_prescriptions', [
                'medical_record_id' => $medicalRecordId,
                'status' => $status,
                'note' => trim((string)$data['prescription_notes']),
            ]);
        }

        if (!empty($data['laboratory_note'])) {
            $saved = $saved && $this->saveDetailRow('medical_record_laboratories', [
                'medical_record_id' => $medicalRecordId,
                'status' => $status,
                'note' => trim((string)$data['laboratory_note']),
            ]);
        }

        if (!empty($data['radiology_note'])) {
            $saved = $saved && $this->saveDetailRow('medical_record_radiologies', [
                'medical_record_id' => $medicalRecordId,
                'status' => $status,
                'note' => trim((string)$data['radiology_note']),
            ]);
        }

        $hasReferral = !empty($data['referral_no'])
            || !empty($data['referral_type'])
            || !empty($data['referral_note']);

        if ($hasReferral) {
            $saved = $saved && $this->saveDetailRow('medical_record_referrals', [
                'medical_record_id' => $medicalRecordId,
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

    private function saveDetailRow(string $table, array $data): bool
    {
        $connection = ConnectionManager::get('default');
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());

        if (!in_array(strtolower($table), $tables, true)) {
            return $this->failDetailSave($table, 'table_missing');
        }

        $schema = $connection->getSchemaCollection()->describe($table);
        if (!$schema->hasColumn('medical_record_id')) {
            return $this->failDetailSave($table, 'column_missing', ['medical_record_id']);
        }

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

        if ($this->isRecentDuplicateDetail($connection, $table, $data, $schema)) {
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

        return (bool)$connection->execute($sql, [
            'medical_record_id' => (int)$data['medical_record_id'],
            'compare_value' => (string)$data[$compareColumn],
        ])->fetch('assoc');
    }

    private function readMedicalRecordDetails(int $medicalRecordId): array
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
            if (!$schema->hasColumn('medical_record_id')) {
                $details[$key] = [];
                continue;
            }

            $orderSql = $schema->hasColumn('id') ? ' ORDER BY ' . $connection->quoteIdentifier('id') . ' DESC' : '';
            $sql = 'SELECT * FROM ' . $connection->quoteIdentifier($table)
                . ' WHERE ' . $connection->quoteIdentifier('medical_record_id') . ' = :medical_record_id'
                . $orderSql
                . ' LIMIT 50';

            $details[$key] = $connection->execute($sql, ['medical_record_id' => $medicalRecordId])->fetchAll('assoc');
        }

        return $details;
    }

    public function history($patientId = null)
    {
        $this->loadModel('Patients');
        $this->loadModel('OutpatientVisits');

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
            $medicalRecord = $this->readMedicalRecordRow(
                $connection,
                $hasTable,
                $visit->registration_id ?? null
            );

            if ($medicalRecord) {
                $visit->set('medical_record', $medicalRecord);
            }

            $detailData[$visit->id] = [];

            foreach ($detailTables as $key => $table) {
                $detailData[$visit->id][$key] = $this->readDetailRows(
                    $connection,
                    $hasTable,
                    $table,
                    $medicalRecord['id'] ?? $medicalRecord->id ?? null
                );
            }
        }

        $registrations = $visits;
        $this->set(compact('patient', 'registrations', 'detailData'));
    }

    private function readMedicalRecordRow($connection, callable $hasTable, $registrationId)
    {
        if (!$hasTable('medical_records')) {
            return null;
        }

        $schema = $connection->getSchemaCollection()->describe('medical_records');
        if ($registrationId && $schema->hasColumn('registration_id')) {
            $foreignKey = 'registration_id';
            $foreignValue = (int)$registrationId;
        } else {
            return null;
        }

        $sql = 'SELECT * FROM ' . $connection->quoteIdentifier('medical_records')
            . ' WHERE ' . $connection->quoteIdentifier($foreignKey) . ' = :foreign_value'
            . ' ORDER BY ' . $connection->quoteIdentifier('id') . ' DESC'
            . ' LIMIT 1';

        return $connection->execute($sql, ['foreign_value' => $foreignValue])->fetch('assoc') ?: null;
    }

    private function readDetailRows($connection, callable $hasTable, string $table, $medicalRecordId): array
    {
        if (!$hasTable($table)) {
            return [];
        }

        $schema = $connection->getSchemaCollection()->describe($table);
        if ($medicalRecordId && $schema->hasColumn('medical_record_id')) {
            $foreignKey = 'medical_record_id';
            $foreignValue = (int)$medicalRecordId;
        } else {
            return [];
        }

        $orderSql = $schema->hasColumn('id') ? ' ORDER BY ' . $connection->quoteIdentifier('id') . ' DESC' : '';
        $sql = 'SELECT * FROM ' . $connection->quoteIdentifier($table)
            . ' WHERE ' . $connection->quoteIdentifier($foreignKey) . ' = :foreign_value'
            . $orderSql
            . ' LIMIT 50';

        return $connection->execute($sql, ['foreign_value' => $foreignValue])->fetchAll('assoc');
    }
}
