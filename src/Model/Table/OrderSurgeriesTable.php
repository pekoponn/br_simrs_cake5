<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderSurgeries Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\MasterSurgeryOperatorsTable&\Cake\ORM\Association\BelongsTo $MasterSurgeryOperators
 * @property \App\Model\Table\MasterOperationTypesTable&\Cake\ORM\Association\BelongsTo $MasterOperationTypes
 *
 * @method \App\Model\Entity\OrderSurgery newEmptyEntity()
 * @method \App\Model\Entity\OrderSurgery newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OrderSurgery[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderSurgery get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderSurgery findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OrderSurgery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderSurgery[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderSurgery|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderSurgery saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderSurgery[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderSurgery[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderSurgery[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderSurgery[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderSurgeriesTable extends Table
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

        $this->setTable('order_surgeries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
        ]);
        $this->belongsTo('MasterSurgeryOperators', [
            'foreignKey' => 'operator_id',
        ]);
        $this->belongsTo('MasterOperationTypes', [
            'foreignKey' => 'operation_type_id',
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
            ->date('surgery_date')
            ->allowEmptyDate('surgery_date');

        $validator
            ->time('surgery_time')
            ->allowEmptyTime('surgery_time');

        $validator
            ->scalar('operator_name')
            ->maxLength('operator_name', 150)
            ->allowEmptyString('operator_name');

        $validator
            ->scalar('surgery_code')
            ->maxLength('surgery_code', 30)
            ->allowEmptyString('surgery_code');

        $validator
            ->scalar('surgery_name')
            ->maxLength('surgery_name', 150)
            ->allowEmptyString('surgery_name');

        $validator
            ->decimal('tariff')
            ->notEmptyString('tariff');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 50)
            ->allowEmptyString('unit');

        $validator
            ->scalar('approval_note')
            ->maxLength('approval_note', 255)
            ->allowEmptyString('approval_note');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('approved_queue_no')
            ->maxLength('approved_queue_no', 30)
            ->allowEmptyString('approved_queue_no');

        $validator
            ->date('approved_date')
            ->allowEmptyDate('approved_date');

        $validator
            ->time('approved_time')
            ->allowEmptyTime('approved_time');

        $validator
            ->scalar('operating_room')
            ->maxLength('operating_room', 100)
            ->allowEmptyString('operating_room');

        $validator
            ->scalar('approved_operator')
            ->maxLength('approved_operator', 150)
            ->allowEmptyString('approved_operator');

        $validator
            ->scalar('approved_surgery_name')
            ->maxLength('approved_surgery_name', 150)
            ->allowEmptyString('approved_surgery_name');

        $validator
            ->scalar('anesthesia_type')
            ->maxLength('anesthesia_type', 100)
            ->allowEmptyString('anesthesia_type');

        $validator
            ->scalar('approved_by')
            ->maxLength('approved_by', 100)
            ->allowEmptyString('approved_by');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->boolean('is_delete')
            ->notEmptyString('is_delete');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);
        $rules->add($rules->existsIn(['operator_id'], 'MasterSurgeryOperators'), ['errorField' => 'operator_id']);
        $rules->add($rules->existsIn(['operation_type_id'], 'MasterOperationTypes'), ['errorField' => 'operation_type_id']);

        return $rules;
    }
}
