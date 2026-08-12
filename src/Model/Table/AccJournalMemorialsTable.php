<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccJournalMemorials Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\RecipientPayersTable&\Cake\ORM\Association\BelongsTo $RecipientPayers
 * @property \App\Model\Table\AccJournalMemorialLinesTable&\Cake\ORM\Association\HasMany $AccJournalMemorialLines
 *
 * @method \App\Model\Entity\AccJournalMemorial newEmptyEntity()
 * @method \App\Model\Entity\AccJournalMemorial newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccJournalMemorial[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccJournalMemorial get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccJournalMemorial findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccJournalMemorial patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccJournalMemorial[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccJournalMemorial|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccJournalMemorial saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccJournalMemorial[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournalMemorial[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournalMemorial[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournalMemorial[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccJournalMemorialsTable extends Table
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

        $this->setTable('acc_journal_memorials');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
        ]);
        $this->belongsTo('RecipientPayers', [
            'foreignKey' => 'recipient_payer_id',
        ]);
        $this->hasMany('AccJournalMemorialLines', [
            'foreignKey' => 'acc_journal_memorial_id',
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
            ->scalar('number')
            ->maxLength('number', 50)
            ->allowEmptyString('number');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->integer('customer_id_old')
            ->allowEmptyString('customer_id_old');

        $validator
            ->scalar('journal_type')
            ->allowEmptyString('journal_type');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->allowEmptyString('subject');

        $validator
            ->scalar('cek_bg')
            ->maxLength('cek_bg', 255)
            ->allowEmptyString('cek_bg');

        $validator
            ->scalar('recipient_payer_code')
            ->maxLength('recipient_payer_code', 50)
            ->allowEmptyString('recipient_payer_code');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('payment_type')
            ->maxLength('payment_type', 50)
            ->allowEmptyString('payment_type');

        $validator
            ->scalar('no_cek')
            ->maxLength('no_cek', 50)
            ->allowEmptyString('no_cek');

        $validator
            ->scalar('no_ref')
            ->maxLength('no_ref', 50)
            ->allowEmptyString('no_ref');

        $validator
            ->date('warkat_date')
            ->allowEmptyDate('warkat_date');

        $validator
            ->scalar('job')
            ->maxLength('job', 50)
            ->allowEmptyString('job');

        $validator
            ->integer('balance')
            ->allowEmptyString('balance');

        $validator
            ->decimal('grand_total')
            ->allowEmptyString('grand_total');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

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
            ->scalar('is_active')
            ->allowEmptyString('is_active');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['recipient_payer_id'], 'RecipientPayers'), ['errorField' => 'recipient_payer_id']);

        return $rules;
    }
}
