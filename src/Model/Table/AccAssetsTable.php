<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccAssets Model
 *
 * @method \App\Model\Entity\AccAsset newEmptyEntity()
 * @method \App\Model\Entity\AccAsset newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccAsset[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccAsset get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccAsset findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccAsset patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccAsset[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccAsset|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccAsset saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccAsset[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAsset[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAsset[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAsset[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccAssetsTable extends Table
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

        $this->setTable('acc_assets');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('AccAssetLines', ['dependent' => true])->setForeignKey('asset_id')->setDependent(true);

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
            ->scalar('name')
            ->maxLength('name', 50)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->allowEmptyString('description');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->integer('periode')
            ->allowEmptyString('periode');

        $validator
            ->scalar('category')
            ->allowEmptyString('category');

        $validator
            ->integer('quantity')
            ->allowEmptyString('quantity');

        $validator
            ->numeric('price')
            ->allowEmptyString('price');

        $validator
            ->integer('is_create')
            ->allowEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->allowEmptyString('is_update');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        return $validator;
    }
}
