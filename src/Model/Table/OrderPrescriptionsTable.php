<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderPrescriptions Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\MedicinesTable&\Cake\ORM\Association\BelongsTo $Medicines
 *
 * @method \App\Model\Entity\OrderPrescription newEmptyEntity()
 * @method \App\Model\Entity\OrderPrescription newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OrderPrescription[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderPrescription get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderPrescription findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OrderPrescription patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderPrescription[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderPrescription|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderPrescription saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderPrescription[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPrescription[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPrescription[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPrescription[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderPrescriptionsTable extends Table
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

        $this->setTable('order_prescriptions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Medicines', [
            'foreignKey' => 'medicine_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('medicine_id')
            ->requirePresence('medicine_id', 'create')
            ->notEmptyString('medicine_id');

        $validator
            ->scalar('medicine_unit')
            ->maxLength('medicine_unit', 100)
            ->allowEmptyString('medicine_unit');

        $validator
            ->boolean('is_kronis')
            ->allowEmptyString('is_kronis');

        $validator
            ->decimal('jml_per_hari')
            ->allowEmptyString('jml_per_hari');

        $validator
            ->decimal('qty_min')
            ->allowEmptyString('qty_min');

        $validator
            ->integer('jml_hari')
            ->allowEmptyString('jml_hari');

        $validator
            ->decimal('qty_satuan')
            ->allowEmptyString('qty_satuan');

        $validator
            ->scalar('aturan_pakai')
            ->maxLength('aturan_pakai', 100)
            ->allowEmptyString('aturan_pakai');

        $validator
            ->decimal('harga')
            ->allowEmptyString('harga');

        $validator
            ->decimal('total_harga')
            ->allowEmptyString('total_harga');

        $validator
            ->scalar('keterangan')
            ->allowEmptyString('keterangan');

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
        $rules->add($rules->existsIn(['medicine_id'], 'Medicines'), ['errorField' => 'medicine_id']);

        return $rules;
    }
}
