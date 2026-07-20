<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MedicineStocks Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\MedicinesTable&\Cake\ORM\Association\BelongsTo $Medicines
 *
 * @method \App\Model\Entity\MedicineStock newEmptyEntity()
 * @method \App\Model\Entity\MedicineStock newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MedicineStock[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MedicineStock get($primaryKey, $options = [])
 * @method \App\Model\Entity\MedicineStock findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MedicineStock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MedicineStock[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MedicineStock|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicineStock saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicineStock[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicineStock[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicineStock[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicineStock[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MedicineStocksTable extends Table
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

        $this->setTable('medicine_stocks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->date('last_so_date')
            ->allowEmptyDate('last_so_date');

        $validator
            ->decimal('hasil_so')
            ->notEmptyString('hasil_so');

        $validator
            ->decimal('adjustment')
            ->notEmptyString('adjustment');

        $validator
            ->decimal('terima')
            ->notEmptyString('terima');

        $validator
            ->decimal('keluar')
            ->notEmptyString('keluar');

        $validator
            ->decimal('saldo_akhir')
            ->notEmptyString('saldo_akhir');

        $validator
            ->decimal('max_stock')
            ->notEmptyString('max_stock');

        $validator
            ->scalar('is_valid')
            ->notEmptyString('is_valid');

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
        $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn(['medicine_id'], 'Medicines'), ['errorField' => 'medicine_id']);

        return $rules;
    }
}
