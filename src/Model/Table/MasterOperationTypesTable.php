<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterOperationTypes Model
 *
 * @method \App\Model\Entity\MasterOperationType newEmptyEntity()
 * @method \App\Model\Entity\MasterOperationType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MasterOperationType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterOperationType get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterOperationType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MasterOperationType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterOperationType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterOperationType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterOperationType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterOperationType[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterOperationType[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterOperationType[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterOperationType[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MasterOperationTypesTable extends Table
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

        $this->setTable('master_operation_types');
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
            ->maxLength('code', 30)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('category')
            ->maxLength('category', 100)
            ->allowEmptyString('category');

        $validator
            ->decimal('tariff')
            ->allowEmptyString('tariff');

        $validator
            ->decimal('jasa_rs')
            ->notEmptyString('jasa_rs');

        $validator
            ->decimal('jasa_dr')
            ->notEmptyString('jasa_dr');

        $validator
            ->decimal('jasa_paramedis')
            ->notEmptyString('jasa_paramedis');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 50)
            ->allowEmptyString('unit');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('is_active')
            ->allowEmptyString('is_active');

        return $validator;
    }
}
