<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BankAccounts Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 *
 * @method \App\Model\Entity\BankAccount newEmptyEntity()
 * @method \App\Model\Entity\BankAccount newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BankAccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BankAccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\BankAccount findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BankAccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BankAccount[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BankAccount|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BankAccount saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BankAccount[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BankAccount[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BankAccount[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BankAccount[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BankAccountsTable extends Table
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

        $this->setTable('bank_accounts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
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
            ->scalar('code')
            ->maxLength('code', 100)
            // ->requirePresence('code', 'create')
            ->allowEmptyString('code');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 100)
            ->requirePresence('bank_name', 'create')
            ->notEmptyString('bank_name');

        $validator
            ->scalar('account_holder')
            ->maxLength('account_holder', 100)
            ->requirePresence('account_holder', 'create')
            ->notEmptyString('account_holder');

        $validator
            ->scalar('account_number')
            ->maxLength('account_number', 50)
            ->requirePresence('account_number', 'create')
            ->notEmptyString('account_number')
            ->add('account_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Nomor rekening sudah terdaftar.']);

        $validator
            ->decimal('opening_balance')
            ->notEmptyString('opening_balance');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('is_create')
            ->allowEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->allowEmptyString('is_update');

        $validator
            ->integer('is_delete')
            ->allowEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

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
        $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->isUnique(['account_number'], 'Nomor rekening sudah terdaftar.'));

        return $rules;
    }
}
