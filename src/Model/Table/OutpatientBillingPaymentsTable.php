<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutpatientBillingPayments Model
 *
 * @property \App\Model\Table\OutpatientBillingsTable&\Cake\ORM\Association\BelongsTo $OutpatientBillings
 *
 * @method \App\Model\Entity\OutpatientBillingPayment newEmptyEntity()
 * @method \App\Model\Entity\OutpatientBillingPayment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBillingPayment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutpatientBillingPaymentsTable extends Table
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

        $this->setTable('outpatient_billing_payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OutpatientBillings', [
            'foreignKey' => 'billing_id',
            'joinType' => 'INNER',
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
            ->scalar('payment_no')
            ->maxLength('payment_no', 30)
            ->requirePresence('payment_no', 'create')
            ->notEmptyString('payment_no')
            ->add('payment_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('payment_method')
            ->notEmptyString('payment_method');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 50)
            ->allowEmptyString('bank_name');

        $validator
            ->scalar('account_no')
            ->maxLength('account_no', 50)
            ->allowEmptyString('account_no');

        $validator
            ->decimal('amount')
            ->notEmptyString('amount');

        $validator
            ->boolean('verified')
            ->notEmptyString('verified');

        $validator
            ->dateTime('verified_at')
            ->allowEmptyDateTime('verified_at');

        $validator
            ->nonNegativeInteger('verified_by')
            ->allowEmptyString('verified_by');

        $validator
            ->scalar('notes')
            ->maxLength('notes', 255)
            ->allowEmptyString('notes');

        $validator
            ->nonNegativeInteger('created_by')
            ->allowEmptyString('created_by');

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
        $rules->add($rules->isUnique(['payment_no']), ['errorField' => 'payment_no']);
        $rules->add($rules->existsIn(['billing_id'], 'OutpatientBillings'), ['errorField' => 'billing_id']);

        return $rules;
    }
}
