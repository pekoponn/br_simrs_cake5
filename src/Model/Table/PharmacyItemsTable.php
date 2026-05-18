<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PharmacyItems Model
 *
 * @method \App\Model\Entity\PharmacyItem newEmptyEntity()
 * @method \App\Model\Entity\PharmacyItem newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PharmacyItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PharmacyItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\PharmacyItem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PharmacyItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PharmacyItem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PharmacyItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PharmacyItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PharmacyItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PharmacyItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PharmacyItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PharmacyItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PharmacyItemsTable extends Table
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

        $this->setTable('pharmacy_items');
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
            ->notEmptyString('code');

        $validator
            ->scalar('region')
            ->maxLength('region', 50)
            ->notEmptyString('region');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('purchase_unit')
            ->maxLength('purchase_unit', 50)
            ->requirePresence('purchase_unit', 'create')
            ->notEmptyString('purchase_unit');

        $validator
            ->scalar('sale_unit')
            ->maxLength('sale_unit', 50)
            ->requirePresence('sale_unit', 'create')
            ->notEmptyString('sale_unit');

        $validator
            ->decimal('qjb')
            ->allowEmptyString('qjb');

        $validator
            ->scalar('therapy_class')
            ->maxLength('therapy_class', 255)
            ->requirePresence('therapy_class', 'create')
            ->notEmptyString('therapy_class');

        $validator
            ->scalar('group_name')
            ->maxLength('group_name', 255)
            ->requirePresence('group_name', 'create')
            ->notEmptyString('group_name');

        $validator
            ->scalar('producer')
            ->maxLength('producer', 255)
            ->requirePresence('producer', 'create')
            ->notEmptyString('producer');

        $validator
            ->scalar('medicine_type')
            ->maxLength('medicine_type', 255)
            ->requirePresence('medicine_type', 'create')
            ->notEmptyString('medicine_type');

        $validator
            ->decimal('cbg_rate')
            ->allowEmptyString('cbg_rate');

        $validator
            ->scalar('formula_name')
            ->maxLength('formula_name', 255)
            ->requirePresence('formula_name', 'create')
            ->notEmptyString('formula_name');

        $validator
            ->decimal('formula_percentage')
            ->allowEmptyString('formula_percentage');

        $validator
            ->decimal('hpp')
            ->allowEmptyString('hpp');

        $validator
            ->decimal('sale_price')
            ->allowEmptyString('sale_price');

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
}
