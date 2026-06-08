<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class MedicalRecordsController extends AppController
{
    public function history($patientId = null)
    {
        $this->loadModel('Patients');
        $this->loadModel('Registrations');

        $patient = $this->Patients->get($patientId);
        $connection = ConnectionManager::get('default');
        $tables = array_map('strtolower', $connection->getSchemaCollection()->listTables());
        $hasTable = function (string $table) use ($tables): bool {
            return in_array(strtolower($table), $tables, true);
        };

        $contain = ['Doctors', 'Rooms', 'Beds'];
        if ($hasTable('medical_records')) {
            $contain[] = 'MedicalRecords';
        }

        $registrations = $this->Registrations->find()
            ->contain($contain)
            ->where(['Registrations.patient_id' => (int)$patientId])
            ->order(['Registrations.registration_date' => 'DESC', 'Registrations.id' => 'DESC'])
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
        foreach ($registrations as $registration) {
            $medicalRecord = $registration->medical_record ?? null;
            $detailData[$registration->id] = [];

            foreach ($detailTables as $key => $table) {
                $detailData[$registration->id][$key] = $this->readDetailRows(
                    $connection,
                    $hasTable,
                    $table,
                    $registration->id,
                    $medicalRecord->id ?? null
                );
            }
        }

        $this->set(compact('patient', 'registrations', 'detailData'));
    }

    private function readDetailRows($connection, callable $hasTable, string $table, int $registrationId, $medicalRecordId): array
    {
        if (!$hasTable($table)) {
            return [];
        }

        $schema = $connection->getSchemaCollection()->describe($table);
        if ($medicalRecordId && $schema->hasColumn('medical_record_id')) {
            $foreignKey = 'medical_record_id';
            $foreignValue = (int)$medicalRecordId;
        } elseif ($schema->hasColumn('registration_id')) {
            $foreignKey = 'registration_id';
            $foreignValue = $registrationId;
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
