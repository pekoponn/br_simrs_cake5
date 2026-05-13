<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\CreditorsTable&\Cake\ORM\Association\HasMany $Creditors
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\HasMany $Customers
 * @property \App\Model\Table\CustomersOriTable&\Cake\ORM\Association\HasMany $CustomersOri
 * @property \App\Model\Table\LogsTable&\Cake\ORM\Association\HasMany $Logs
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\HasMany $Suppliers
 * @property \App\Model\Table\TransportersTable&\Cake\ORM\Association\HasMany $Transporters
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
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
            ->scalar('branch_id')
            ->maxLength('branch_id', 255)
            ->allowEmptyString('branch_id');

        $validator
            ->scalar('code')
            ->maxLength('code', 20)
            ->allowEmptyString('code');

        $validator
            ->scalar('staff')
            ->maxLength('staff', 20)
            ->allowEmptyString('staff');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');

        $validator
            ->scalar('password_new')
            ->maxLength('password_new', 255)            
            ->notEmptyString('password_new');

        $validator
            ->sameAs('retype_password', 'password_new', 'Sandi tidak cocok!');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->scalar('help_hint_pwd')
            ->maxLength('help_hint_pwd', 255)
            ->allowEmptyString('help_hint_pwd');

        $validator
            ->scalar('telp')
            ->maxLength('telp', 255)
            ->allowEmptyString('telp');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('devision')
            ->maxLength('devision', 255)
            ->allowEmptyString('devision');

        $validator
            ->scalar('position')
            ->maxLength('position', 255)
            ->allowEmptyString('position');

        $validator
            ->scalar('marketing_code')
            ->maxLength('marketing_code', 255)
            ->allowEmptyString('marketing_code');

        $validator
            ->scalar('approved')
            ->allowEmptyString('approved');

        $validator
            ->scalar('approved_ceo')
            ->allowEmptyString('approved_ceo');

        $validator
            ->scalar('payment')
            ->allowEmptyString('payment');

        $validator
            ->scalar('pettycash_full_access')
            ->allowEmptyString('pettycash_full_access');

        $validator
            ->scalar('hris_approved')
            ->allowEmptyString('hris_approved');

        $validator
            ->scalar('hris_knowing')
            ->allowEmptyString('hris_knowing');

        $validator
            ->scalar('hris_full_access')
            ->allowEmptyString('hris_full_access');

        $validator
            ->scalar('rule')
            ->allowEmptyString('rule');

        $validator
            ->scalar('rules')
            ->allowEmptyString('rules');

        $validator
            ->scalar('rule_acc')
            ->allowEmptyString('rule_acc');

        $validator
            ->scalar('jurnal_type_acc')
            ->maxLength('jurnal_type_acc', 255)
            ->allowEmptyString('jurnal_type_acc');

        $validator
            ->scalar('change_password')
            ->allowEmptyString('change_password');

        $validator
            ->dateTime('change_password_date')
            ->allowEmptyDateTime('change_password_date');

        $validator
            ->integer('reset')
            ->allowEmptyString('reset');

        $validator
            ->dateTime('reset_date')
            ->allowEmptyDateTime('reset_date');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 15)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 15)
            ->allowEmptyString('is_update');

        $validator
            ->scalar('is_delete')
            ->maxLength('is_delete', 15)
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

        $validator
            ->scalar('who_create')
            ->maxLength('who_create', 50)
            ->allowEmptyString('who_create');

        $validator
            ->scalar('who_update')
            ->maxLength('who_update', 50)
            ->allowEmptyString('who_update');

        $validator
            ->dateTime('last_login')
            ->allowEmptyDateTime('last_login');

        $validator
            ->scalar('status')
            ->maxLength('status', 5)
            ->allowEmptyString('status');

        $validator
            ->scalar('level')
            ->maxLength('level', 5)
            ->allowEmptyString('level');

        $validator
            ->integer('visited')
            ->allowEmptyString('visited');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        
        return $rules;
    }
}
