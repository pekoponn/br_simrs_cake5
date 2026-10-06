<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PraRegistrations Model
 *
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 *
 * @method \App\Model\Entity\PraRegistration newEmptyEntity()
 * @method \App\Model\Entity\PraRegistration newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PraRegistration[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PraRegistration get($primaryKey, $options = [])
 * @method \App\Model\Entity\PraRegistration findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PraRegistration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PraRegistration[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PraRegistration|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PraRegistration saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PraRegistration[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PraRegistration[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PraRegistration[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PraRegistration[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PraRegistrationsTable extends Table
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

        $this->setTable('pra_registrations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
        ]);
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('reservation_code')
            ->maxLength('reservation_code', 30)
            ->requirePresence('reservation_code', 'create')
            ->notEmptyString('reservation_code')
            ->add('reservation_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('medical_record_no')
            ->maxLength('medical_record_no', 20)
            ->allowEmptyString('medical_record_no');

        $validator
            ->scalar('patient_name')
            ->maxLength('patient_name', 150)
            ->requirePresence('patient_name', 'create')
            ->notEmptyString('patient_name');

        $validator
            ->date('birth_date')
            ->allowEmptyDate('birth_date');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 20)
            ->allowEmptyString('phone_number');

        $validator
            ->scalar('nik')
            ->maxLength('nik', 20)
            ->allowEmptyString('nik');

        $validator
            ->scalar('doctor_name')
            ->maxLength('doctor_name', 150)
            ->requirePresence('doctor_name', 'create')
            ->notEmptyString('doctor_name');

        $validator
            ->scalar('poly_name')
            ->maxLength('poly_name', 100)
            ->requirePresence('poly_name', 'create')
            ->notEmptyString('poly_name');

        $validator
            ->date('appointment_date')
            ->requirePresence('appointment_date', 'create')
            ->notEmptyDate('appointment_date');

        $validator
            ->scalar('appointment_day')
            ->maxLength('appointment_day', 15)
            ->allowEmptyString('appointment_day');

        $validator
            ->time('appointment_time')
            ->requirePresence('appointment_time', 'create')
            ->notEmptyTime('appointment_time');

        $validator
            ->nonNegativeInteger('patient_queue_number')
            ->allowEmptyString('patient_queue_number');

        $validator
            ->scalar('guarantor')
            ->maxLength('guarantor', 100)
            ->allowEmptyString('guarantor');

        $validator
            ->scalar('planned_action')
            ->maxLength('planned_action', 255)
            ->allowEmptyString('planned_action');

        $validator
            ->scalar('referral_type')
            ->allowEmptyString('referral_type');

        $validator
            ->scalar('card_number')
            ->maxLength('card_number', 30)
            ->allowEmptyString('card_number');

        $validator
            ->scalar('referral_number')
            ->maxLength('referral_number', 50)
            ->allowEmptyString('referral_number');

        $validator
            ->scalar('channel')
            ->notEmptyString('channel');

        $validator
            ->scalar('notes')
            ->maxLength('notes', 255)
            ->allowEmptyString('notes');

        $validator
            ->scalar('registration_status')
            ->notEmptyString('registration_status');

        $validator
            ->dateTime('registered_at')
            ->allowEmptyDateTime('registered_at');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 100)
            ->allowEmptyString('created_by');

        $validator
            ->scalar('modified_by')
            ->maxLength('modified_by', 100)
            ->allowEmptyString('modified_by');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['reservation_code']), ['errorField' => 'reservation_code']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);

        return $rules;
    }
}