<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;

class MedicalRecordsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('medical_records');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('MedicalRecordExaminations', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordPrescriptions', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordLaboratories', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordRadiologies', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordSurgeries', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordIntegrations', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordIcares', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordDocuments', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordReferrals', [
            'foreignKey' => 'medical_record_id',
        ]);
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add(function ($entity) {
            if (empty($entity->registration_id)) {
                return false;
            }

            $conditions = [
                'registration_id' => (int)$entity->registration_id,
                'OR' => [
                    ['is_delete' => 0],
                    ['is_delete IS' => null],
                ],
            ];

            if (!empty($entity->id)) {
                $conditions['id !='] = (int)$entity->id;
            }

            return !$this->exists($conditions);
        }, 'uniqueActiveRegistration', [
            'errorField' => 'registration_id',
            'message' => 'Medical record untuk registrasi ini sudah ada.',
        ]);

        return $rules;
    }
}
