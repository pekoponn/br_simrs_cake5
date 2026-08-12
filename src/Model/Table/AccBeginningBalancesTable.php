<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccBeginningBalances Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\AccChartOfAccountsTable&\Cake\ORM\Association\BelongsTo $AccChartOfAccounts
 *
 * @method \App\Model\Entity\AccBeginningBalance newEmptyEntity()
 * @method \App\Model\Entity\AccBeginningBalance newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccBeginningBalance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccBeginningBalance get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccBeginningBalance findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccBeginningBalance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccBeginningBalance[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccBeginningBalance|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccBeginningBalance saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccBeginningBalance[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccBeginningBalance[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccBeginningBalance[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccBeginningBalance[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccBeginningBalancesTable extends Table
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

        $this->setTable('acc_beginning_balances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('AccChartOfAccounts', [
            'foreignKey' => 'acc_chart_of_account_id',
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
            ->date('dates')
            ->allowEmptyDate('dates');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        $validator
            ->scalar('ledger_dc')
            ->allowEmptyString('ledger_dc');

        $validator
            ->decimal('debet')
            ->allowEmptyString('debet');

        $validator
            ->decimal('credit')
            ->allowEmptyString('credit');

        $validator
            ->integer('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 50)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 50)
            ->allowEmptyString('is_update');

        $validator
            ->scalar('is_delete')
            ->maxLength('is_delete', 50)
            ->allowEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

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
        $rules->add($rules->existsIn(['acc_chart_of_account_id'], 'AccChartOfAccounts'), ['errorField' => 'acc_chart_of_account_id']);

        return $rules;
    }
}
