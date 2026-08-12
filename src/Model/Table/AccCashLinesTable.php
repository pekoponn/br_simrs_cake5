<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccCashLines Model
 *
 * @property \App\Model\Table\AccCashesTable&\Cake\ORM\Association\BelongsTo $AccCashes
 * @property \App\Model\Table\AccAccountsTable&\Cake\ORM\Association\BelongsTo $AccAccounts
 *
 * @method \App\Model\Entity\AccCashLine newEmptyEntity()
 * @method \App\Model\Entity\AccCashLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccCashLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccCashLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccCashLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccCashLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccCashLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccCashLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccCashLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccCashLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccCashLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccCashLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccCashLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccCashLinesTable extends Table
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

        $this->setTable('acc_cash_lines');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('AccCashes', [
            'foreignKey' => 'acc_cash_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('AccAccounts', [
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
            ->scalar('acc_account_code')
            ->maxLength('acc_account_code', 255)
            ->requirePresence('acc_account_code', 'create')
            ->notEmptyString('acc_account_code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('debet')
            ->maxLength('debet', 255)
            ->allowEmptyString('debet');

        $validator
            ->integer('credit')
            ->allowEmptyString('credit');

        $validator
            ->scalar('job')
            ->maxLength('job', 50)
            ->requirePresence('job', 'create')
            ->notEmptyString('job');

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
        $rules->add($rules->existsIn(['acc_cash_id'], 'AccCashes'), ['errorField' => 'acc_cash_id']);
        $rules->add($rules->existsIn(['acc_account_id'], 'AccAccounts'), ['errorField' => 'acc_account_id']);

        return $rules;
    }
}
