<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutpatientBillings Model
 *
 * @property \App\Model\Table\OutpatientVisitsTable&\Cake\ORM\Association\BelongsTo $OutpatientVisits
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\CashiersTable&\Cake\ORM\Association\BelongsTo $Cashiers
 *
 * @method \App\Model\Entity\OutpatientBilling newEmptyEntity()
 * @method \App\Model\Entity\OutpatientBilling newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBilling[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBilling get($primaryKey, $options = [])
 * @method \App\Model\Entity\OutpatientBilling findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OutpatientBilling patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBilling[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBilling|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientBilling saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientBilling[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBilling[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBilling[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBilling[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutpatientBillingsTable extends Table
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

        $this->setTable('outpatient_billings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OutpatientVisits', [
            'foreignKey' => 'outpatient_visit_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
        ]);
        $this->belongsTo('Cashiers', [
            'foreignKey' => 'cashier_id',
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
            ->scalar('billing_no')
            ->maxLength('billing_no', 30)
            ->requirePresence('billing_no', 'create')
            ->notEmptyString('billing_no')
            ->add('billing_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('visit_date')
            ->requirePresence('visit_date', 'create')
            ->notEmptyDate('visit_date');

        $validator
            ->scalar('polyclinic_name')
            ->maxLength('polyclinic_name', 100)
            ->allowEmptyString('polyclinic_name');

        $validator
            ->scalar('insurance_type')
            ->maxLength('insurance_type', 50)
            ->allowEmptyString('insurance_type');

        $validator
            ->scalar('insurance_no')
            ->maxLength('insurance_no', 50)
            ->allowEmptyString('insurance_no');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->decimal('total_action')
            ->notEmptyString('total_action');

        $validator
            ->decimal('total_medicine')
            ->notEmptyString('total_medicine');

        $validator
            ->decimal('total_lab')
            ->notEmptyString('total_lab');

        $validator
            ->decimal('total_radiology')
            ->notEmptyString('total_radiology');

        $validator
            ->decimal('total_other')
            ->notEmptyString('total_other');

        $validator
            ->decimal('subtotal')
            ->notEmptyString('subtotal');

        $validator
            ->scalar('discount_type')
            ->allowEmptyString('discount_type');

        $validator
            ->decimal('discount_value')
            ->notEmptyString('discount_value');

        $validator
            ->decimal('discount_amount')
            ->notEmptyString('discount_amount');

        $validator
            ->decimal('grand_total')
            ->notEmptyString('grand_total');

        $validator
            ->scalar('payment_method')
            ->allowEmptyString('payment_method');

        $validator
            ->decimal('paid_amount')
            ->notEmptyString('paid_amount');

        $validator
            ->decimal('change_amount')
            ->notEmptyString('change_amount');

        $validator
            ->dateTime('paid_at')
            ->allowEmptyDateTime('paid_at');

        $validator
            ->scalar('cashier_name')
            ->maxLength('cashier_name', 100)
            ->allowEmptyString('cashier_name');

        $validator
            ->boolean('is_referred')
            ->notEmptyString('is_referred');

        $validator
            ->scalar('referred_to')
            ->maxLength('referred_to', 100)
            ->allowEmptyString('referred_to');

        $validator
            ->boolean('is_inpatient')
            ->notEmptyString('is_inpatient');

        $validator
            ->scalar('inpatient_referral_no')
            ->maxLength('inpatient_referral_no', 50)
            ->allowEmptyString('inpatient_referral_no');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('void_reason')
            ->maxLength('void_reason', 255)
            ->allowEmptyString('void_reason');

        $validator
            ->dateTime('voided_at')
            ->allowEmptyDateTime('voided_at');

        $validator
            ->nonNegativeInteger('voided_by')
            ->allowEmptyString('voided_by');

        $validator
            ->boolean('is_create')
            ->allowEmptyString('is_create');

        $validator
            ->boolean('is_update')
            ->allowEmptyString('is_update');

        $validator
            ->boolean('is_delete')
            ->allowEmptyString('is_delete');

        $validator
            ->scalar('is_active')
            ->maxLength('is_active', 1)
            ->allowEmptyString('is_active');

        $validator
            ->nonNegativeInteger('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->nonNegativeInteger('modified_by')
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
        $rules->add($rules->isUnique(['billing_no']), ['errorField' => 'billing_no']);
        $rules->add($rules->existsIn(['outpatient_visit_id'], 'OutpatientVisits'), ['errorField' => 'outpatient_visit_id']);
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);
        $rules->add($rules->existsIn(['cashier_id'], 'Cashiers'), ['errorField' => 'cashier_id']);

        return $rules;
    }
}
