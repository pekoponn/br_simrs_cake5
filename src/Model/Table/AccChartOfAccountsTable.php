<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;


/**
 * AccChartOfAccounts Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\AccChartOfAccountsTable&\Cake\ORM\Association\BelongsTo $ParentAccChartOfAccounts
 * @property \App\Model\Table\AccAccountMappingsTable&\Cake\ORM\Association\HasMany $AccAccountMappings
 * @property \App\Model\Table\AccBeginningBalancesTable&\Cake\ORM\Association\HasMany $AccBeginningBalances
 * @property \App\Model\Table\AccChartOfAccountsTable&\Cake\ORM\Association\HasMany $ChildAccChartOfAccounts
 * @property \App\Model\Table\AccJournalBankLinesTable&\Cake\ORM\Association\HasMany $AccJournalBankLines
 * @property \App\Model\Table\AccJournalCashLinesTable&\Cake\ORM\Association\HasMany $AccJournalCashLines
 * @property \App\Model\Table\AccJournalLinesTable&\Cake\ORM\Association\HasMany $AccJournalLines
 * @property \App\Model\Table\AccJournalMappingsTable&\Cake\ORM\Association\HasMany $AccJournalMappings
 * @property \App\Model\Table\AccJournalMemorialLinesTable&\Cake\ORM\Association\HasMany $AccJournalMemorialLines
 * @property \App\Model\Table\CalksTable&\Cake\ORM\Association\HasMany $Calks
 *
 * @method \App\Model\Entity\AccChartOfAccount newEmptyEntity()
 * @method \App\Model\Entity\AccChartOfAccount newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccChartOfAccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccChartOfAccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccChartOfAccount findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccChartOfAccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccChartOfAccount[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccChartOfAccount|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccChartOfAccount saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccChartOfAccount[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccChartOfAccount[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccChartOfAccount[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccChartOfAccount[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class AccChartOfAccountsTable extends Table
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

        $this->setTable('acc_chart_of_accounts');
        $this->getSchema()->setColumnType('groups', 'string');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Customers', [
            'className' => 'Customers',
            'foreignKey' => 'customer_id',
        ]);
        $this->belongsTo('ParentAccChartOfAccounts', [
            'className' => 'AccChartOfAccounts',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('AccAccountMappings', [
            'foreignKey' => 'acc_chart_of_account_id',
        ]);
        $this->hasMany('AccBeginningBalances', [
            'foreignKey' => 'acc_chart_of_account_id',
        ]);
        $this->hasMany('ChildAccChartOfAccounts', [
            'className' => 'AccChartOfAccounts',
            'foreignKey' => 'parent_id',
        ]);
        /*$this->hasMany('AccJournalBankLines', [
            'foreignKey' => 'acc_chart_of_account_id',
        ]);
        $this->hasMany('AccJournalMemorialLines', [
            'foreignKey' => 'acc_chart_of_account_id',
        ]);
        $this->hasMany('Calks', [
            'foreignKey' => 'acc_chart_of_account_id',
        ]);*/
        $this->hasMany('AccJournalCashLines', [
            'foreignKey' => 'acc_chart_of_account_id',
        ]);
        $this->hasMany('AccJournalLines', [
            'foreignKey' => 'acc_chart_of_account_id',
        ]);
        $this->hasMany('AccJournalMappings', [
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
            ->integer('level')
            ->allowEmptyString('level');

         $validator
            ->integer('parent_id')
            ->allowEmptyString('parent_id');

        $validator
            ->scalar('parent_account')
            ->maxLength('parent_account', 50)
            ->allowEmptyString('parent_account');

        $validator
            ->scalar('header_account')
            ->maxLength('header_account', 50)
            ->allowEmptyString('header_account');

        $validator
            ->scalar('sub_header_account')
            ->maxLength('sub_header_account', 50)
            ->allowEmptyString('sub_header_account');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('type')
            ->maxLength('type', 50)
            ->allowEmptyString('type');

        $validator
            ->scalar('normal_balance')
            ->maxLength('normal_balance', 50)
            ->allowEmptyString('normal_balance');

        $validator
            ->scalar('contra_account')
            ->allowEmptyString('contra_account');

        $validator
            ->scalar('mapping')
            ->maxLength('mapping', 50)
            ->allowEmptyString('mapping');

        $validator
            ->scalar('groups')
            ->maxLength('groups', 50)
            ->allowEmptyString('groups');

        $validator
            ->scalar('sub_group')
            ->maxLength('sub_group', 50)
            //->requirePresence('sub_group', 'create')
            ->allowEmptyString('sub_group');

        $validator
            ->scalar('sub_group_no')
            ->maxLength('sub_group_no', 50)
            //->requirePresence('sub_group_no', 'create')
            ->allowEmptyString('sub_group_no');

        $validator
            ->scalar('default')
            ->maxLength('default', 150)
            ->allowEmptyString('default');

        $validator
            ->scalar('journal_type')
            ->allowEmptyString('journal_type');

        $validator
            ->scalar('transaction')
            ->maxLength('transaction', 50)
            ->notEmptyString('transaction');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            // ->requirePresence('description', 'create')
            ->allowEmptyString('description');

        $validator
            ->scalar('character')
            ->maxLength('character', 50)
            ->allowEmptyString('character');

        $validator
            ->scalar('code_additional')
            ->maxLength('code_additional', 50)
            ->allowEmptyString('code_additional');

        $validator
            ->integer('additional')
            ->allowEmptyString('additional');

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
        //$rules->add($rules->existsIn(['parent_id'], 'ParentAccChartOfAccounts'), ['errorField' => 'parent_id']);

        return $rules;
    }

    public function getMaxParent($codeParent=null, $levelParent=null) 
    {
        if(!empty($codeParent))
        {
            $condLevel = (isset($levelParent)) ? $levelParent:'-1';
            $dataRows = $this->find('all',[
            'fields' => array('codes' => 'MAX(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(code, ".", '.$levelParent.'), ".", -1) AS SIGNED INTEGER))+1'),
            'conditions' => array('parent_account' => $codeParent)
            ]); 

            $dataRows = $dataRows->first();
            $dataResult = $dataRows->codes;
            $result = (empty($dataResult)) ? "1": $dataResult;

           /* if($countLevel==2 || $countLevel==4) {
                $padCode = 2;
            } elseif($countLevel==5) {
                $padCode = 4;
            } else {
                $padCode = 1;
            }*/

            // $result = str_pad($codeCOA, $padCode , "0", STR_PAD_LEFT);

            //$result = str_pad($results, 5, "0", STR_PAD_LEFT);            
        } 
        else 
        {
            $result = "1"; 
        }
        return $result; 
    }

    public function getCoaData($level=null, $dataSearch=null) {
        $condLevel = (isset($level)) ? $level:array(1,2,3,4);
        $condDataName = (empty($dataSearch)) ? array() : array('AccChartOfAccounts.name LIKE' => '%'.$dataSearch.'%');

        $queries = $this->find()->select(['coaGroupId' => "CONCAT(AccChartOfAccounts.id,'^',AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups,'^','(',AccChartOfAccounts.code,')',AccChartOfAccounts.name)",'coaGroupName' => "CONCAT('(',AccChartOfAccounts.code,')',AccChartOfAccounts.name)"])->where([$condDataName, 'AccChartOfAccounts.level IN' => $condLevel]) ->order(['AccChartOfAccounts.lft' => 'ASC']);

        // $queries = $this->find()
        //             ->select(['coaGroupId' => "CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups,'^',IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name)))", 'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name))"])
        //             ->where([$condDataName, 'AccChartOfAccounts.level IN'=>$condLevel])
        //             ->order(['AccChartOfAccounts.lft' => 'ASC'])
        //             ->contain(['Customers']);

        $result = array();
        foreach ($queries as $key => $data) {
            $result[$key]['id'] = $data['coaGroupId'];
            $result[$key]['text'] = $data['coaGroupName'];
        }
        $queries = $result;

        return $result;
        // return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function datarowCOA($level=null, $typeCOA=null) {
        $condLevel = (isset($level)) ? $level:array(4,5);
        $condDataName = (empty($typeCOA)) ? array() : array('AccChartOfAccounts.journal_type LIKE' => '%'.$typeCOA.'%');

        $result = $this->find()
                    ->select([
                        'AccChartOfAccounts.id', 'AccChartOfAccounts.parent_id', 'AccChartOfAccounts.code', 'AccChartOfAccounts.name', 'AccChartOfAccounts.level', 'AccChartOfAccounts.groups', 'AccChartOfAccounts.type', 'AccChartOfAccounts.default', 'AccChartOfAccounts.beginning_balance', 'AccChartOfAccounts.beginning_balance_debet', 'AccChartOfAccounts.beginning_balance_credit','AccChartOfAccounts.journal_type', 'AccChartOfAccounts.normal_balance', 'AccChartOfAccounts.parent_account', 'AccChartOfAccounts.header_account', 'AccChartOfAccounts.sub_header_account',
                        'codeUnique' => "CONCAT(REPLACE(AccChartOfAccounts.parent_account, '.', ''), RIGHT(AccChartOfAccounts.code, 3))",
                        'coaGroupId' => "CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups,'^',IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name)))", 
                        'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name))"])
                    ->where([$condDataName, 'AccChartOfAccounts.level IN'=>$condLevel])
                    ->order(['AccChartOfAccounts.code' => 'ASC', 'AccChartOfAccounts.lft' => 'ASC'])
                    ->contain(['Customers'])->toArray();
                    
        return $result;
        /*$result = array();
        foreach ($queries as $key => $data) {
            $result[$key]['id'] = $data['coaGroupId'];
            $result[$key]['text'] = $data['coaGroupName'];
        }
        $queries = $result;*/

        
        // return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }
}
