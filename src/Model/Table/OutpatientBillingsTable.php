<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OutpatientBillingsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('outpatient_billings');
        $this->setDisplayField('billing_no');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OutpatientVisits', [
            'foreignKey' => 'outpatient_visit_id',
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

        $this->hasMany('OutpatientBillingItems', [
            'foreignKey' => 'billing_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        
        $this->hasMany('OutpatientBillingPayments', [
            'foreignKey' => 'billing_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

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
            ->add('billing_no', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
            ]);

        $validator
            ->nonNegativeInteger('outpatient_visit_id')
            ->allowEmptyString('outpatient_visit_id');

        $validator
            ->nonNegativeInteger('registration_id')
            ->allowEmptyString('registration_id');

        $validator
            ->nonNegativeInteger('patient_id')
            ->allowEmptyString('patient_id');

        $validator
            ->nonNegativeInteger('doctor_id')
            ->allowEmptyString('doctor_id');

        $validator
            ->date('visit_date')
            ->allowEmptyDate('visit_date');

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
            ->maxLength('status', 30)
            ->allowEmptyString('status');

        $validator
            ->decimal('total_action')
            ->allowEmptyString('total_action');

        $validator
            ->decimal('total_medicine')
            ->allowEmptyString('total_medicine');

        $validator
            ->decimal('total_lab')
            ->allowEmptyString('total_lab');

        $validator
            ->decimal('total_radiology')
            ->allowEmptyString('total_radiology');

        $validator
            ->decimal('total_other')
            ->allowEmptyString('total_other');

        $validator
            ->scalar('transfer_card_no')
            ->maxLength('transfer_card_no', 100)
            ->allowEmptyString('transfer_card_no');

        $validator
            ->scalar('transfer_bank_auth_no')
            ->maxLength('transfer_bank_auth_no', 100)
            ->allowEmptyString('transfer_bank_auth_no');

        $validator
            ->scalar('transfer_card_type')
            ->maxLength('transfer_card_type', 20)
            ->allowEmptyString('transfer_card_type');

        $validator
            ->decimal('transfer_admin_percent')
            ->allowEmptyString('transfer_admin_percent');

        $validator
            ->scalar('transfer_bank_dest')
            ->maxLength('transfer_bank_dest', 100)
            ->allowEmptyString('transfer_bank_dest');

        $validator
            ->scalar('payment_proof')
            ->maxLength('payment_proof', 255)
            ->allowEmptyString('payment_proof');

        $validator
            ->decimal('subtotal')
            ->allowEmptyString('subtotal');

        $validator
            ->decimal('subtotal')
            ->allowEmptyString('subtotal');

        $validator
            ->scalar('discount_type')
            ->maxLength('discount_type', 20)
            ->allowEmptyString('discount_type');

        $validator
            ->decimal('discount_value')
            ->allowEmptyString('discount_value');

        $validator
            ->decimal('discount_amount')
            ->allowEmptyString('discount_amount');

        $validator
            ->decimal('grand_total')
            ->allowEmptyString('grand_total');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 30)
            ->allowEmptyString('payment_method');

        $validator
            ->decimal('paid_amount')
            ->allowEmptyString('paid_amount');

        $validator
            ->decimal('change_amount')
            ->allowEmptyString('change_amount');

        $validator
            ->dateTime('paid_at')
            ->allowEmptyDateTime('paid_at');

        $validator
            ->scalar('cashier_name')
            ->maxLength('cashier_name', 100)
            ->allowEmptyString('cashier_name');

        $validator
            ->boolean('is_referred')
            ->allowEmptyString('is_referred');

        $validator
            ->scalar('referred_to')
            ->maxLength('referred_to', 100)
            ->allowEmptyString('referred_to');

        $validator
            ->boolean('is_inpatient')
            ->allowEmptyString('is_inpatient');

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

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['billing_no']), [
            'errorField' => 'billing_no',
        ]);

        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), [
            'errorField' => 'registration_id',
        ]);

        $rules->add($rules->existsIn(['patient_id'], 'Patients'), [
            'errorField' => 'patient_id',
        ]);

        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), [
            'errorField' => 'doctor_id',
        ]);

        return $rules;
    }
}