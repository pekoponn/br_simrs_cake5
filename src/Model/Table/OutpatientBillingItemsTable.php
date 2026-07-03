<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutpatientBillingItems Model
 *
 * @property \App\Model\Table\OutpatientBillingsTable&\Cake\ORM\Association\BelongsTo $OutpatientBillings
 *
 * @method \App\Model\Entity\OutpatientBillingItem newEmptyEntity()
 * @method \App\Model\Entity\OutpatientBillingItem newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientBillingItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutpatientBillingItemsTable extends Table
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

        $this->setTable('outpatient_billing_items');
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
            ->scalar('item_type')
            ->notEmptyString('item_type');

        $validator
            ->scalar('item_code')
            ->maxLength('item_code', 50)
            ->allowEmptyString('item_code');

        $validator
            ->scalar('item_name')
            ->maxLength('item_name', 255)
            ->requirePresence('item_name', 'create')
            ->notEmptyString('item_name');

        $validator
            ->decimal('quantity')
            ->notEmptyString('quantity');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 20)
            ->allowEmptyString('unit');

        $validator
            ->decimal('unit_price')
            ->notEmptyString('unit_price');

        $validator
            ->decimal('total_price')
            ->notEmptyString('total_price');

        $validator
            ->decimal('discount_amount')
            ->notEmptyString('discount_amount');

        $validator
            ->decimal('final_price')
            ->notEmptyString('final_price');

        $validator
            ->scalar('notes')
            ->maxLength('notes', 255)
            ->allowEmptyString('notes');

        $validator
            ->boolean('is_covered')
            ->notEmptyString('is_covered');

        $validator
            ->integer('sort_order')
            ->notEmptyString('sort_order');

        $validator
            ->boolean('is_delete')
            ->allowEmptyString('is_delete');

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
        $rules->add($rules->existsIn(['billing_id'], 'OutpatientBillings'), ['errorField' => 'billing_id']);

        return $rules;
    }
}
