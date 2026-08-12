<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccJournals Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\JournalSubsTable&\Cake\ORM\Association\BelongsTo $JournalSubs
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\RecipientPayersTable&\Cake\ORM\Association\BelongsTo $RecipientPayers
 * @property \App\Model\Table\AccJournalLinesTable&\Cake\ORM\Association\HasMany $AccJournalLines
 *
 * @method \App\Model\Entity\AccJournal newEmptyEntity()
 * @method \App\Model\Entity\AccJournal newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccJournal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccJournal get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccJournal findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccJournal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccJournal[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccJournal|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccJournal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccJournal[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournal[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournal[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccJournal[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccJournalsTable extends Table
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

        $this->setTable('acc_journals');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        // $this->belongsTo('Customers', [
        //     'foreignKey' => 'customer_id',
        // ]);
        $this->hasMany('AccJournalLines', [
            'foreignKey' => 'acc_journal_id',
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

        // $validator
        //     ->scalar('code_old')
        //     ->maxLength('code_old', 50)
        //     ->allowEmptyString('code_old');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        // $validator
        //     ->integer('customer_id_ori')
        //     ->allowEmptyString('customer_id_ori');

        $validator
            ->scalar('journal_type')
            ->allowEmptyString('journal_type');

        $validator
            ->scalar('tax')
            ->allowEmptyString('tax');

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
            ->scalar('recipient_payer_name')
            ->maxLength('recipient_payer_name', 100)
            ->allowEmptyString('recipient_payer_name');

        $validator
            ->scalar('recipient_payer_code')
            ->maxLength('recipient_payer_code', 50)
            ->allowEmptyString('recipient_payer_code');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->date('date_posting')
            ->allowEmptyDate('date_posting');

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
            ->allowEmptyString('status');

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
        // $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        //$rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        
        return $rules;
    }

    public function getMax($type, $monthYear=null) {
        $month = date("m");
        $year = date("y");
        $dateNow = date("ymd");
        $yearMonth = (isset($monthYear)) ? $monthYear : $dateNow;
        //$yearMonth = (isset($monthYear)) ? $monthYear : $year.$month;

        $dataRows = $this->find('all',[
            'fields' => array('codes' => 'MAX(RIGHT(AccJournals.code, 3))+1'),
            'conditions' => array('SUBSTRING(AccJournals.code, 1, 6) =' => $yearMonth, 'AccJournals.journal_type' => $type)
        ]); 

        $dataRows = $dataRows->first();
        $dataResult = $dataRows->codes;
        $results = (empty($dataResult)) ? "1": $dataResult;
        $resultCode = str_pad($results, 3, "0", STR_PAD_LEFT);
        //$resultCode = str_pad($results, 4, "0", STR_PAD_LEFT);
        $result = $yearMonth."-".$resultCode;
        return $result;

        /*
        $row = $model->find("first", array("fields" => array("MAX(RIGHT($tables.code, 4)) AS max"), "conditions" => array("SUBSTRING($tables.code, 1, 4)" => $yearMonth, "$tables.journal_type" => $type), "recursive" => -1));
        // $row = $model->find("first", array("fields" => array("RIGHT($tables.code, 4) AS max"), "conditions" => array("LEFT($tables.code, 5)" => $condCode), "recursive" => -1));
        // SUBSTRING('Quadratically',5);

        if(empty($row)) {
            $code = 1;
        } else {
            $dataRow = $row[0];
            // $dataRow = $row[$tables];
            $rowCode = intval($dataRow['max']);
            $code = ($rowCode==0) ? 1 : $rowCode+1;
        }
        $resultCode = str_pad($code, 4, "0", STR_PAD_LEFT);
        // $journalType = $this->journalTypeCode($type);

        $result = $yearMonth."-".$resultCode;
        //$result = $journalType.$yearMonth."-".$resultCode;
        return $result;
        */
    }

    public function checkCode($branchId=null, $code=null, $journalType=null) {
        // $results = array();
        //"AccJournal.branch_id" => $branchId, 
        $results = $this->find()->where(["AccJournals.branch_id" => $branchId, "AccJournals.code" => $code, "AccJournals.journal_type" => $journalType])->count();

        // $results = $this->find("count", array(
                                // "conditions" => array("AccJournal.code" => $code, "AccJournal.journal_type" => $journalType),
                                // "recursive" => -1));

        return $results;
    }
}
