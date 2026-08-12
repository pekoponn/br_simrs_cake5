<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccAssetLines Model
 *
 * @method \App\Model\Entity\AccAssetLine newEmptyEntity()
 * @method \App\Model\Entity\AccAssetLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccAssetLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccAssetLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccAssetLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccAssetLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccAssetLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccAssetLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccAssetLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccAssetLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAssetLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAssetLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAssetLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccAssetLinesTable extends Table
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

        $this->setTable('acc_asset_lines');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('AccAssets', [
            'foreignKey' => 'asset_id',
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
            ->numeric('mutasi_tambah')
            ->notEmptyString('mutasi_tambah');

        $validator
            ->numeric('mutasi_kurang')
            ->notEmptyString('mutasi_kurang');

        $validator
            ->numeric('depresiasi')
            ->notEmptyString('depresiasi');

        $validator
            ->numeric('akumulasi')
            ->notEmptyString('akumulasi');

        $validator
            ->date('date_periode')
            ->notEmptyDate('date_periode');

        $validator
            ->numeric('nilai_buku')
            ->notEmptyString('nilai_buku');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

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
        $rules->add($rules->existsIn(['asset_id'], 'AccAssets'), ['errorField' => 'asset_id']);

        return $rules;
    }
}
