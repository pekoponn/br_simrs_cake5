<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class LabInternalMemosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('lab_internal_memos');
        $this->setDisplayField('patient_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('memo')->requirePresence('memo', 'create')->notEmptyString('memo', 'Isi memo wajib diisi')
            ->scalar('registration_no')->maxLength('registration_no', 50)->allowEmptyString('registration_no')
            ->scalar('medical_record_no')->maxLength('medical_record_no', 50)->allowEmptyString('medical_record_no')
            ->scalar('patient_name')->maxLength('patient_name', 150)->allowEmptyString('patient_name');

        return $validator;
    }
}