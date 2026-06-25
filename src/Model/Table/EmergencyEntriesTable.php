<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmergencyEntries Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 *
 * @method \App\Model\Entity\EmergencyEntry newEmptyEntity()
 * @method \App\Model\Entity\EmergencyEntry newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyEntry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyEntry get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmergencyEntry findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EmergencyEntry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyEntry[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyEntry|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmergencyEntry saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmergencyEntriesTable extends Table
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

        $this->setTable('emergency_entries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
        ]);
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('registration_no')
            ->maxLength('registration_no', 50)
            ->allowEmptyString('registration_no');

        $validator
            ->scalar('patient_rm')
            ->maxLength('patient_rm', 50)
            ->allowEmptyString('patient_rm');

        $validator
            ->scalar('patient_name')
            ->maxLength('patient_name', 255)
            ->allowEmptyString('patient_name');

        $validator
            ->scalar('doctor_name')
            ->maxLength('doctor_name', 255)
            ->allowEmptyString('doctor_name');

        $validator
            ->date('service_date')
            ->allowEmptyDate('service_date');

        $validator
            ->time('service_time')
            ->allowEmptyTime('service_time');

        $validator
            ->scalar('chief_complaint')
            ->allowEmptyString('chief_complaint');

        $validator
            ->scalar('triage_category')
            ->maxLength('triage_category', 50)
            ->allowEmptyString('triage_category');

        $validator
            ->scalar('triage_notes')
            ->allowEmptyString('triage_notes');

        $validator
            ->scalar('blood_pressure')
            ->maxLength('blood_pressure', 50)
            ->allowEmptyString('blood_pressure');

        $validator
            ->scalar('temperature')
            ->maxLength('temperature', 50)
            ->allowEmptyString('temperature');

        $validator
            ->scalar('pulse')
            ->maxLength('pulse', 50)
            ->allowEmptyString('pulse');

        $validator
            ->scalar('respiration')
            ->maxLength('respiration', 50)
            ->allowEmptyString('respiration');

        $validator
            ->scalar('spo2')
            ->maxLength('spo2', 50)
            ->allowEmptyString('spo2');

        $validator
            ->scalar('diagnosis')
            ->allowEmptyString('diagnosis');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

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
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);

        return $rules;
    }
}
