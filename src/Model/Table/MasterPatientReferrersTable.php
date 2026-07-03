<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterPatientReferrers Model
 *
 * @method \App\Model\Entity\MasterPatientReferrer newEmptyEntity()
 * @method \App\Model\Entity\MasterPatientReferrer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterPatientReferrer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MasterPatientReferrersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('master_patient_referrers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('referral_origin')
            ->maxLength('referral_origin', 255)
            ->allowEmptyString('referral_origin');

        $validator
            ->scalar('doctor_sender')
            ->maxLength('doctor_sender', 255)
            ->allowEmptyString('doctor_sender');

        $validator
            ->scalar('is_active')
            ->maxLength('is_active', 1)
            ->allowEmptyString('is_active');

        return $validator;
    }
}
