<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Medicines Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\MedicineMerksTable&\Cake\ORM\Association\BelongsTo $MedicineMerks
 * @property \App\Model\Table\MedicineGroupsTable&\Cake\ORM\Association\BelongsTo $MedicineGroups
 *
 * @method \App\Model\Entity\Medicine newEmptyEntity()
 * @method \App\Model\Entity\Medicine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Medicine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Medicine get($primaryKey, $options = [])
 * @method \App\Model\Entity\Medicine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Medicine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Medicine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Medicine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Medicine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MedicinesTable extends Table
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

        $this->setTable('medicines');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('MedicineMerks', [
            'foreignKey' => 'medicine_merk_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('MedicineGroups', [
            'foreignKey' => 'medicine_group_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('MedicineStocks', [
            'foreignKey' => 'medicine_id',
            'strategy' => 'join',   
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
            ->scalar('medicine_merk_name')
            ->maxLength('medicine_merk_name', 255)
            ->allowEmptyString('medicine_merk_name');

        $validator
            ->scalar('medicine_group_name')
            ->maxLength('medicine_group_name', 255)
            ->allowEmptyString('medicine_group_name');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code')
            ->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('code_kfa')
            ->maxLength('code_kfa', 50)
            ->allowEmptyString('code_kfa');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('code_ifrs')
            ->maxLength('code_ifrs', 255)
            ->allowEmptyString('code_ifrs');

        $validator
            ->scalar('merk')
            ->maxLength('merk', 255)
            ->allowEmptyString('merk');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('img')
            ->maxLength('img', 255)
            ->allowEmptyString('img');

        $validator
            ->integer('qty_unit')
            ->notEmptyString('qty_unit');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 100)
            ->allowEmptyString('unit');

        $validator
            ->integer('qty_packaging')
            ->notEmptyString('qty_packaging');

        $validator
            ->scalar('packaging')
            ->maxLength('packaging', 100)
            ->allowEmptyString('packaging');

        $validator
            ->decimal('cogs')
            ->notEmptyString('cogs');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->integer('is_print')
            ->notEmptyString('is_print');

        $validator
            ->dateTime('printed')
            ->allowEmptyDateTime('printed');

        $validator
            ->scalar('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

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
        $rules->add($rules->isUnique(['code']), ['errorField' => 'code']);
        $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn(['medicine_merk_id'], 'MedicineMerks'), ['errorField' => 'medicine_merk_id']);
        $rules->add($rules->existsIn(['medicine_group_id'], 'MedicineGroups'), ['errorField' => 'medicine_group_id']);

        return $rules;
    }
}
