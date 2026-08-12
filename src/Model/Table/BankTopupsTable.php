<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BankTopups Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\AccChartOfAccountsTable&\Cake\ORM\Association\BelongsTo $AccChartOfAccounts
 *
 * @method \App\Model\Entity\BankTopup newEmptyEntity()
 * @method \App\Model\Entity\BankTopup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BankTopup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BankTopup get($primaryKey, $options = [])
 * @method \App\Model\Entity\BankTopup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BankTopup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BankTopup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BankTopup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BankTopup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BankTopup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BankTopup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BankTopup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BankTopup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BankTopupsTable extends Table
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

        $this->setTable('bank_topups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('AccChartOfAccounts', [
            'foreignKey' => 'acc_coa_id',
        ]);
        $this->belongsTo('AccChartOfAccountTo', [
            'className' => 'AccChartOfAccounts',
            'foreignKey' => 'acc_coa_to_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'is_create',
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
            ->scalar('payment_type')
            ->maxLength('payment_type', 255)
            ->allowEmptyString('payment_type');

        $validator
            ->decimal('nominal')
            ->notEmptyString('nominal');

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
            ->notEmptyString('is_active');

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
    // public function buildRules(RulesChecker $rules): RulesChecker
    // {
    //     $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
    //     $rules->add($rules->existsIn(['acc_coa_id'], 'AccChartOfAccounts'), ['errorField' => 'acc_coa_id']);

    //     return $rules;
    // }
}
