<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccJournalLines Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\AccJournalsTable&\Cake\ORM\Association\BelongsTo $AccJournals
 * @property \App\Model\Table\JournalSubsTable&\Cake\ORM\Association\BelongsTo $JournalSubs
 * @property \App\Model\Table\JournalSubLinesTable&\Cake\ORM\Association\BelongsTo $JournalSubLines
 * @property \App\Model\Table\AccChartOfAccountsTable&\Cake\ORM\Association\BelongsTo $AccChartOfAccounts
 *
 * @method \App\Model\Entity\AccJournalLine newEmptyEntity()
 * @method \App\Model\Entity\AccJournalLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccJournalLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccJournalLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccJournalLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccJournalLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccJournalLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccJournalLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccJournalLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccJournalLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournalLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournalLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournalLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccJournalLinesTable extends Table
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

        $this->setTable('acc_journal_lines');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('AccJournals', [
            'foreignKey' => 'acc_journal_id',
            'joinType' => 'INNER',
        ]);
        // $this->belongsTo('JournalSubs', [
        //     'foreignKey' => 'journal_sub_id',
        //     'joinType' => 'INNER',
        // ]);
        // $this->belongsTo('JournalSubLines', [
        //     'foreignKey' => 'journal_sub_line_id',
        //     'joinType' => 'INNER',
        // ]);
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

        // $validator
        //     ->scalar('acc_chart_of_account_code')
        //     ->maxLength('acc_chart_of_account_code', 255)
        //     ->allowEmptyString('acc_chart_of_account_code');

        $validator
            ->integer('position')
            ->requirePresence('position', 'create')
            ->notEmptyString('position');

        $validator
            ->scalar('ledger_dc')
            ->allowEmptyString('ledger_dc');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->decimal('debet')
            ->allowEmptyString('debet');

        $validator
            ->decimal('credit')
            ->allowEmptyString('credit');

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
        $rules->add($rules->existsIn(['acc_journal_id'], 'AccJournals'), ['errorField' => 'acc_journal_id']);
        // $rules->add($rules->existsIn(['journal_sub_id'], 'JournalSubs'), ['errorField' => 'journal_sub_id']);
        // $rules->add($rules->existsIn(['journal_sub_line_id'], 'JournalSubLines'), ['errorField' => 'journal_sub_line_id']);
        // $rules->add($rules->existsIn(['acc_chart_of_account_id'], 'AccChartOfAccounts'), ['errorField' => 'acc_chart_of_account_id']);

        return $rules;
    }
}
