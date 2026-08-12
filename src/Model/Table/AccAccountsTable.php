<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccAccounts Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\AccAccountsTable&\Cake\ORM\Association\BelongsTo $ParentAccAccounts
 * @property \App\Model\Table\AccAccountsTable&\Cake\ORM\Association\HasMany $ChildAccAccounts
 * @property \App\Model\Table\AccCashLinesTable&\Cake\ORM\Association\HasMany $AccCashLines
 *
 * @method \App\Model\Entity\AccAccount newEmptyEntity()
 * @method \App\Model\Entity\AccAccount newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccAccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccAccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccAccount findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccAccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccAccount[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccAccount|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccAccount saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccAccount[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAccount[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAccount[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccAccount[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class AccAccountsTable extends Table
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

        $this->setTable('acc_accounts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ParentAccAccounts', [
            'className' => 'AccAccounts',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildAccAccounts', [
            'className' => 'AccAccounts',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('AccCashLines', [
            'foreignKey' => 'acc_account_id',
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
            ->integer('level')
            ->allowEmptyString('level');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code');

        $validator
            ->scalar('parent_code')
            ->maxLength('parent_code', 50)
            ->allowEmptyString('parent_code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('type')
            ->allowEmptyString('type');

        $validator
            ->scalar('group')
            ->maxLength('group', 50)
            ->requirePresence('group', 'create')
            ->notEmptyString('group');

        $validator
            ->scalar('journal_type')
            ->allowEmptyString('journal_type');

        $validator
            ->scalar('transaction')
            ->notEmptyString('transaction');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('character')
            ->maxLength('character', 50)
            ->requirePresence('character', 'create')
            ->notEmptyString('character');

        $validator
            ->scalar('code_additional')
            ->maxLength('code_additional', 50)
            ->requirePresence('code_additional', 'create')
            ->notEmptyString('code_additional');

        $validator
            ->integer('additional')
            ->requirePresence('additional', 'create')
            ->notEmptyString('additional');

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
            ->scalar('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->scalar('who_create')
            ->maxLength('who_create', 50)
            ->allowEmptyString('who_create');

        $validator
            ->scalar('who_update')
            ->maxLength('who_update', 50)
            ->allowEmptyString('who_update');

        $validator
            ->scalar('who_delete')
            ->maxLength('who_delete', 50)
            ->allowEmptyString('who_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentAccAccounts'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
