<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Registrations Model
 *
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\BelongsTo $Rooms
 * @property \App\Model\Table\BedsTable&\Cake\ORM\Association\BelongsTo $Beds
 * @property \App\Model\Table\PersonResponsiblesTable&\Cake\ORM\Association\BelongsTo $PersonResponsibles
 * @property \App\Model\Table\PersonResponsiblesTable&\Cake\ORM\Association\HasMany $PersonResponsible
 *
 * @method \App\Model\Entity\Registration newEmptyEntity()
 * @method \App\Model\Entity\Registration newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Registration[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Registration get($primaryKey, $options = [])
 * @method \App\Model\Entity\Registration findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Registration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Registration[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Registration|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Registration saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RegistrationsTable extends Table
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

        $this->setTable('registrations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Beds', [
            'foreignKey' => 'bed_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('PersonResponsibles', [
            'foreignKey' => 'person_responsible_id',
            'joinType' => 'LEFT',
        ]);
        //     $this->hasMany('PersonResponsible', [
        //         'foreignKey' => 'registration_id',
        //     ]);
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
            ->notEmptyString('registration_no');

        $validator
            ->scalar('registration_date')
            ->maxLength('registration_date', 255)
            ->requirePresence('registration_date', 'create')
            ->notEmptyString('registration_date');

        $validator
            ->scalar('service_type')
            ->maxLength('service_type', 255)
            ->requirePresence('service_type', 'create')
            ->notEmptyString('service_type');

        $validator
            ->scalar('polyclinic_name')
            ->maxLength('polyclinic_name', 255)
            ->requirePresence('polyclinic_name', 'create')
            ->notEmptyString('polyclinic_name');

        $validator
            ->scalar('class_name')
            ->maxLength('class_name', 100)
            ->allowEmptyString('class_name')
            ->add('class_name', 'requiredForRawatInap', [
                'rule' => function ($value, $context) {
                    if (($context['data']['service_type'] ?? '') === 'rawat_inap') {
                        return !empty($value);
                    }

                    return true;
                },
                'message' => 'Kelas wajib diisi untuk rawat inap'
            ]);

        $validator
            ->scalar('entry_process')
            ->maxLength('entry_process', 255)
            ->requirePresence('entry_process', 'create')
            ->notEmptyString('entry_process');

        $validator
            ->scalar('entry_method')
            ->maxLength('entry_method', 255)
            ->requirePresence('entry_method', 'create')
            ->notEmptyString('entry_method');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 255)
            ->requirePresence('payment_method', 'create')
            ->notEmptyString('payment_method');

        $validator
            ->scalar('insurance_type')
            ->maxLength('insurance_type', 255)
            ->requirePresence('insurance_type', 'create')
            ->notEmptyString('insurance_type');

        $validator
            ->scalar('insurance_card_no')
            ->maxLength('insurance_card_no', 30)
            ->requirePresence('insurance_card_no', 'create')
            ->notEmptyString('insurance_card_no');

        $validator
            ->scalar('refferal_no')
            ->maxLength('refferal_no', 30)
            ->requirePresence('refferal_no', 'create')
            ->notEmptyString('refferal_no');

        $validator
            ->scalar('sep_no')
            ->maxLength('sep_no', 50)
            ->requirePresence('sep_no', 'create')
            ->notEmptyString('sep_no');

        $validator
            ->scalar('treatment_type')
            ->maxLength('treatment_type', 50)
            ->notEmptyString('treatment_type');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->integer('is_delete')
            ->notEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('delete_log')
            ->allowEmptyString('delete_log');

        $validator
            ->scalar('is_active')
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
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);
        // $rules->add($rules->existsIn(['room_id'], 'Rooms'), ['errorField' => 'room_id']);
        // $rules->add($rules->existsIn(['bed_id'], 'Beds'), ['errorField' => 'bed_id']);
        $rules->add($rules->existsIn(['person_responsible_id'], 'PersonResponsibles'), ['errorField' => 'person_responsible_id']);

        return $rules;
    }
}
