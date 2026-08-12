<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RecipientPayers Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\AccJournalBanksTable&\Cake\ORM\Association\HasMany $AccJournalBanks
 * @property \App\Model\Table\AccJournalCashesTable&\Cake\ORM\Association\HasMany $AccJournalCashes
 * @property \App\Model\Table\AccJournalMemorialsTable&\Cake\ORM\Association\HasMany $AccJournalMemorials
 * @property \App\Model\Table\AccJournalsTable&\Cake\ORM\Association\HasMany $AccJournals
 *
 * @method \App\Model\Entity\RecipientPayer newEmptyEntity()
 * @method \App\Model\Entity\RecipientPayer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RecipientPayer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RecipientPayer get($primaryKey, $options = [])
 * @method \App\Model\Entity\RecipientPayer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RecipientPayer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RecipientPayer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RecipientPayer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RecipientPayer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RecipientPayer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RecipientPayer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RecipientPayer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RecipientPayer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecipientPayersTable extends Table
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

        $this->setTable('recipient_payers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('AccJournalBanks', [
            'foreignKey' => 'recipient_payer_id',
        ]);
        $this->hasMany('AccJournalCashes', [
            'foreignKey' => 'recipient_payer_id',
        ]);
        $this->hasMany('AccJournalMemorials', [
            'foreignKey' => 'recipient_payer_id',
        ]);
        $this->hasMany('AccJournals', [
            'foreignKey' => 'recipient_payer_id',
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
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        $validator
            ->scalar('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

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

        return $rules;
    }
}
