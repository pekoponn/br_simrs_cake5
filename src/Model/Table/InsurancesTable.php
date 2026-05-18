<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Insurances Model
 *
 * @method \App\Model\Entity\Insurance newEmptyEntity()
 * @method \App\Model\Entity\Insurance newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Insurance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Insurance get($primaryKey, $options = [])
 * @method \App\Model\Entity\Insurance findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Insurance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Insurance[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Insurance|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Insurance saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Insurance[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Insurance[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Insurance[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Insurance[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InsurancesTable extends Table
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

        $this->setTable('insurances');
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 255)
            ->requirePresence('bank_name', 'create')
            ->notEmptyString('bank_name');

        $validator
            ->scalar('bank_account_number')
            ->maxLength('bank_account_number', 50)
            ->requirePresence('bank_account_number', 'create')
            ->notEmptyString('bank_account_number');

        $validator
            ->scalar('bank_account_name')
            ->maxLength('bank_account_name', 50)
            ->requirePresence('bank_account_name', 'create')
            ->notEmptyString('bank_account_name');

        $validator
            ->scalar('phone_number_rs')
            ->maxLength('phone_number_rs', 50)
            ->requirePresence('phone_number_rs', 'create')
            ->notEmptyString('phone_number_rs');

        $validator
            ->scalar('email_rs')
            ->maxLength('email_rs', 50)
            ->requirePresence('email_rs', 'create')
            ->notEmptyString('email_rs');

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
