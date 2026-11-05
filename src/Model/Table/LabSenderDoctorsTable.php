<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LabSenderDoctorsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('lab_sender_doctors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('code')->maxLength('code', 30)->requirePresence('code', 'create')->notEmptyString('code', 'Kode wajib diisi')
            ->scalar('name')->maxLength('name', 150)->requirePresence('name', 'create')->notEmptyString('name', 'Nama dokter wajib diisi')
            ->scalar('address')->maxLength('address', 255)->allowEmptyString('address')
            ->scalar('phone')->maxLength('phone', 30)->allowEmptyString('phone')
            ->scalar('mobile')->maxLength('mobile', 30)->allowEmptyString('mobile')
            ->boolean('is_active')->allowEmptyString('is_active');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['code'], 'Kode sudah dipakai'), ['errorField' => 'code']);

        return $rules;
    }
}