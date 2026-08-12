<?php
declare(strict_types=1);

namespace App\Controller\Acc;

use App\Controller\AppController;
use CakePdf\Pdf\CakePdf;
use Cake\Utility\Hash;

// Call PhpOffice for Excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Http\CallbackStream;


/**
 * AccChartOfAccounts Controller
 *
 * @property \App\Model\Table\AccChartOfAccountsTable $accChartOfAccounts
 * @method \App\Model\Entity\AccChartOfAccount[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccChartOfAccountsController extends AppController
{
    public function getCoa($level=null) {
        $condLevel = (isset($level)) ? $level:array(1,2,3,4);
        // pr($this->request->getQuery());
        $this->autoRender=false;
        //$dataName = $this->request->getQuery('search');
        $dataName = $this->request->getQuery('dataSearch');
        $condDataName = (empty($dataName)) ? array() : array('AccChartOfAccounts.name LIKE' => '%'.$dataName.'%');
        // $queries = $this->AccChartOfAccounts->find()
        //             ->select(['AccChartOfAccounts.id', 'AccChartOfAccounts.code', 'AccChartOfAccounts.header_account', 'AccChartOfAccounts.sub_header_account', 'AccChartOfAccounts.groups', 'coaGroupId' => "CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups,'^',IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name)))", 'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name))"])
        //             ->where([$condDataName, 'AccChartOfAccounts.level IN'=>$condLevel])
        //             ->order(['AccChartOfAccounts.lft' => 'ASC'])
        //             ->contain(['Customers']);
        $queries = $this->AccChartOfAccounts->find()
                    ->select(['AccChartOfAccounts.id', 'AccChartOfAccounts.code', 'AccChartOfAccounts.header_account', 'AccChartOfAccounts.sub_header_account', 'AccChartOfAccounts.groups', 'coaGroupId' => "CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups,'^',IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ')))", 'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') '))"])
                    ->where([$condDataName, 'AccChartOfAccounts.level IN'=>$condLevel])
                    ->order(['AccChartOfAccounts.lft' => 'ASC'])
                    ->contain([]);
                // pr($queries);

        $result = array();
        foreach ($queries as $key => $data) {
            $result[$key]['id'] = $this->Krs->fEncode((int) $data['id'].'^'.$data['code'].'^'.$data['header_account'].'^'.$data['sub_header_account'].'^'.$data['groups'].'^'.$data['coaGroupName']);

            // $result[$key]['id'] = $data['coaGroupId'];
            $result[$key]['text'] = $data['coaGroupName'];
        }
        $queries = $result;

        // $result = Hash::combine($queries, '{n}.coaGroupId', '{n}.coaGroupName');
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $dataKeyAll = $this->request->getQueryParams();
        $getSearch = $this->request->getQuery('search');
        $getLink = $this->request->getQuery();

        if ($this->request->is(['post'])) {
            $dataRow = $this->request->getData();
            // pr($dataRow);

            $dataLink = array();
            $dataWhere = array();
            // $filterData = array('project LIKE'=> '%'.$dataRow['filterProject'].'%');
            if(!empty($dataRow['filterId'])) {
                $dataWhere['AccChartOfAccounts.id'] = $dataRow['filterId'];
                $dataLink['filterId'] = $dataRow['filterId'];
            }
            if(!empty($dataRow['filterCode'])) {
                $dataWhere['AccChartOfAccounts.code LIKE'] = '%'.$dataRow['filterCode'] . '%';
                $dataLink['filterCode'] = $dataRow['filterCode'];                
            }
            if(!empty($dataRow['filterName'])) {
                $dataWhere['AccChartOfAccounts.name LIKE'] = '%'.$dataRow['filterName'] . '%';
                $dataLink['filterName'] = $dataRow['filterName'];           
            }
            
            $dataSearchs = $this->Krs->fEncode($dataWhere);
            $dataLinks = $this->Krs->fEncode($dataLink);
            return $this->redirect(['action' => 'index', '?' => ['search' => $dataSearchs, 'link' => $dataLinks]]);
        } 

        if(!empty($getLink['link'])) {
            $dataLinks = $this->Krs->fdecode($getLink['link']);
            //pr($dataLinks);
            $dataLink['filterId'] = (isset($dataLinks['filterId'])) ? $dataLinks['filterId'] : "";
            $dataLink['filterCode'] = (isset($dataLinks['filterCode'])) ? $dataLinks['filterCode'] : "";
            $dataLink['filterName'] = (isset($dataLinks['filterName'])) ? $dataLinks['filterName'] : "";
        } else {
            $dataLink['filterId'] = "";
            $dataLink['filterCode'] = "";
            $dataLink['filterName'] = "";
        }

        $accChartOfAccounts = $this->AccChartOfAccounts->find('all');
        //->contain(['Accept', 'UserApplicant', 'PettyCashLines']);
        $dataWheres = (empty($getLink['search'])) ? "" : $this->Krs->fdecode($getLink['search']);

        $queries = (!empty($dataWheres)) ? $accChartOfAccounts->where([$dataWheres]) : $accChartOfAccounts;

        $settings = [
            'limit' => 15,
            'order' => [
                'lft' => 'asc',
            ],
        ];

        $accChartOfAccounts = $this->paginate($queries, $settings);
        
        $this->set(compact('accChartOfAccounts', 'dataLink'));

        /*
        'IF(due_date = DATE(NOW()), 0, 1)',
                'due_date' => 'desc',
                "FIELD(payment_status, 'Y', 'NP', 'N') desc",
                'approved_date' => 'asc',
                */
        /*$key = $this->request->getQuery('key');
        if ($key) {
          $query = $this->AccChartOfAccounts->find('all')
                        ->where(['OR'=>['AccChartOfAccounts.name like' => '%' . $key . '%']]);
        } else {
          $query = $this->AccChartOfAccounts;
        }

        $settings = [
            //'conditions' => ['AccChartOfAccounts.level' => 1],
            'limit' => 15,
            'order' => [
                'lft' => 'asc',
            ],
        ];

        $this->paginate = [
            //'contain' => ['Branches', 'ParentAccChartOfAccounts'],
        ];
        $accChartOfAccounts = $this->paginate($query, $settings);

        $this->set(compact('accChartOfAccounts'));*/
    }

    public function group()
    {
        $key = $this->request->getQuery('key');
        if ($key) {
          $query = $this->AccChartOfAccounts->find('all')
                        ->where(['OR'=>['AccChartOfAccounts.name like' => '%' . $key . '%']]);
        } else {
          $query = $this->AccChartOfAccounts;
        }

        $settings = [
            'conditions' => ['AccChartOfAccounts.level' => 1],
            'limit' => 15,
            'order' => [
                'name' => 'asc',
            ],
        ];

        $this->paginate = [
            //'contain' => ['Branches', 'ParentAccChartOfAccounts'],
        ];
        $accChartOfAccounts = $this->paginate($query, $settings);

        $this->set(compact('accChartOfAccounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Acc Chart Of Account id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accChartOfAccount = $this->AccChartOfAccounts->get($id, [
            'contain' => ['Branches', 'ParentAccChartOfAccounts', 'AccAccountMappings', 'AccBeginningBalances', 'ChildAccChartOfAccounts', 'AccJournalBankLines', 'AccJournalCashLines', 'AccJournalLines', 'AccJournalMappings', 'AccJournalMemorialLines', 'Calks'],
        ]);

        $this->set(compact('accChartOfAccount'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accChartOfAccount = $this->AccChartOfAccounts->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();

            $isUser = $dataRow['user_id'];

            // if($dataRow["level"]==1) {
            //     $countLevel = 1;
            //     $parentId = 0;
            //     $codeParent = null;
            //     $headerAccount = $countLevel;
            //     $subHeaderAccount = null;
            //     $group = $dataRow["groups"];
            // } else {
            // 1^1.0.00.00 1^(1.0.00.00) ASET
            //$data['id'].'^'.$data['code'].'^'.$data['header_account'].'^'.$data['sub_header_account'].'^'.$data['groups'].'^'.$data['header_account'].'^'.$data['coaGroupName']

                list($parentId, $codeParent, $headerAccount, $subHeaderAccount, $group, $coaGroupName) = explode("^", $this->Krs->fDecode($dataRow["parent"]));
                // pr($this->Krs->fDecode($dataRow["parent"]));
                //Memanggil Path pada Tree
                $countLevel = count($this->AccChartOfAccounts->find('path', ['for' => $parentId])->all())+1;
            // }
            // pr($countLevel);

            // list($parentId, $codeParent, $headerAccount, $subHeaderAccount, $group) = explode("^", $dataRow["parent"]);
            // pr($dataRow["parent"]);
            //Memanggil Path pada Tree
            // $countLevel = count($this->AccChartOfAccounts->find('path', ['for' => $parentId])->all())+1;
            if($countLevel<5){
                $dataLevel = array('level' => $countLevel);
                $dataParent = array('parent_account' => $codeParent);
                $dataBranchId = array('branch_id' => 0);
                $dataHeader = array('header_account' => $headerAccount);
                $dataUserId = array('is_create' => $isUser);
                $COACodeArray = explode('.', $codeParent);
                // pr($COACodeArray);

                //________Menentukan jumlah digit pada bilangan, untuk level 3 & 4 ada 2 digit
                if($countLevel==2 || $countLevel==3) {
                    $padCode = 2;
                } elseif($countLevel==4) {
                    $padCode = 4;
                } else {
                    $padCode = 1;
                }

                if($dataRow['check_coa']=='N') {
                    $codeCOAs = $this->AccChartOfAccounts->getMaxParent($codeParent, $countLevel);
                } else {
                    $codeCOAs = $dataRow["code"];
                }

                $codeCOA = str_pad($codeCOAs, $padCode , "0", STR_PAD_LEFT);

                if($countLevel==1) {
                    $coaCode = $codeCOAs.'.0.00.00';
                } elseif($countLevel==2) {
                    $coaCode = $COACodeArray[0].'.'.$codeCOA.'.00.00';
                } elseif($countLevel==3) {
                    $coaCode = $COACodeArray[0].'.'.$COACodeArray[1].'.'.$codeCOA.'.00';
                } elseif($countLevel==4) {
                    $coaCode = $COACodeArray[0].'.'.$COACodeArray[1].'.'.$COACodeArray[2].'.'.$codeCOA;
                } else {
                    $coaCode = '0.0.00.00';
                }

                $dataCode = array('code' => $coaCode);
                // $dataCode = array('code' => $codeParent.".".$codeCOA);
                $rowNames = (isset($dataRow['name'])) ? $dataRow['name']:NULL;
                // $rowCodes = (isset($dataRow['code'])) ? $dataRow['code']:NULL;

                
                if($countLevel==2){
                    $rowSubHeaderAccount = '';
                    $dataNames = (empty($rowNames)) ? NULL :$rowNames;
                    //$dataNames = (empty($rowNames)) ? NULL :strtoupper($rowNames);
                } else {
                    //$codeCOAs
                    $subHeaderAccounts = (empty($subHeaderAccount))?$headerAccount.".".$COACodeArray[1]:$subHeaderAccount;
                    //$subHeaderAccounts = (empty($subHeaderAccount))?$headerAccount.".".$rowCodes:$subHeaderAccount;

                    $rowSubHeaderAccount = $subHeaderAccounts;
                    $dataNames = (empty($rowNames)) ? NULL : $rowNames;
                    // $dataNames = (empty($rowNames)) ? NULL : ucwords(strtolower($rowNames));
                }

                if($dataRow['check_customer']=='Y') {
                    $COAName = NULL;
                    // $dataCode = array('code' => $codeParent.".".$codeCOA);
                    // $rowCustomerId = $dataRow['customer_id'];
                    $rowName = $dataRow['customer_id'];
                } else {
                    $COAName = $rowNames;
                    $rowName = $dataNames;
                    //$rowCustomerId = NULL$rowNames;
                }
                // $dataCustomerId = array('customer_id' => $rowCustomerId);

                $rowBeginningBalanceDebet = (empty($dataRow['beginning_balance_debets'])) ? NULL : $this->Krs->nom2Dec($dataRow['beginning_balance_debets']);
                $rowBeginningBalanceCredit = (empty($dataRow['beginning_balance_credits'])) ? NULL : $this->Krs->nom2Dec($dataRow['beginning_balance_credits']);
                $rowBeginningBalanceDate = (empty($dataRow['beginning_balance_dates']))? NULL:$this->Krs->dateTo($dataRow['beginning_balance_dates']);
                
                $dataSubHeaderAccount = array('sub_header_account' => $rowSubHeaderAccount);
                // if($countLevel==2) {
                //     $dataRowName = ucwords(strtolower($rowName));
                // } else {
                    $dataRowName = $rowName;
                // }

                $dataName = array('name' => $dataRowName);
                $dataJournalType = array('journal_type' => $dataRow['journal_type']);
                $dataNormalBalance = array('normal_balance' => $dataRow['normal_balance']);
                $dataGroup = array('`groups`' => $dataRow['groups']);
                $dataParentId = array('parent_id' => $parentId);
                // $dataGroup = array('groups' => $group);
                $dataAdditional = array('additional' => 0);
                $dataSubGroup = array('sub_group' => "");
                $dataSubGroupNo = array('sub_group_no' => "");
                $dataDescription = array('description' => "");
                // $dataCharacter = array('character' => "");
                $dataCodeAdditional = array('code_additional' => "");
                //$dataCodes = $codeParent.".".$codeCOA;  
                // $dataCode = array('code' => $codeParent.".".$codeCOA);
                $dataBeginningBalanceDebet = array('beginning_balance_debet' => $rowBeginningBalanceDebet);
                $dataBeginningBalanceCredit = array('beginning_balance_credit' => $rowBeginningBalanceCredit);
                $dataBeginningBalanceDate = array('beginning_balance_date' => $rowBeginningBalanceDate);

                $rowTransaction = ($countLevel==4)?'y':'n';
                $dataTransaction = array('transaction' => $rowTransaction);
                $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add"); 
                $dataAuditLog = array('is_log' => $auditLog);

                //, $dataCustomerId
                $accChartOfAccount = $this->AccChartOfAccounts->patchEntity($accChartOfAccount, array_merge($dataBranchId, $dataUserId, $dataJournalType, $dataLevel, $dataParent, $dataHeader, $dataCode, $dataSubHeaderAccount, $dataName, $dataParentId, $dataGroup, $dataAdditional, $dataSubGroup, $dataSubGroupNo, $dataDescription, $dataCodeAdditional, $dataBeginningBalanceDebet, $dataBeginningBalanceCredit, $dataBeginningBalanceDate, $dataTransaction, $dataNormalBalance, $dataAuditLog));

                // Check duplicate data
                $checkCountDuplicate = $this->AccChartOfAccounts->find()->where(['SUBSTRING_INDEX(code, ".", 3) =' => $codeParent, 'name' => $rowName])->count();
                if($checkCountDuplicate==0) {
                    // pr($accChartOfAccount);
                    // debug($accChartOfAccount);
                    // die;
                    if ($this->AccChartOfAccounts->save($accChartOfAccount)) {
                    $this->Flash->success(__('Data berhasil disimpan.'));

                    return $this->redirect(['action' => 'add']);
                    }
                    $this->Flash->error(__('Data gagal disimpan, silakan coba kembali.'));
                } else {
                    $this->Flash->error(__('Data tidak boleh sama, silakan coba kembali.'));
                }
                // $query = $this->AccChartOfAccounts->find()->where(['code'=>$dataCodes, 'name' => $rowName]);
                // $query = $this->AccChartOfAccounts->find()->matching('accChartOfAccounts', function ($q) use ($rowName) {
                //     return $q->where(['name' => $rowName]);
                // });


                // pr($total);
                // pr($accChartOfAccount);
                //journal_type
               
            } else {
                $this->Flash->error(__('Maaf Level tidak boleh melebihi dari Level 5!..'));
            }
                       
        }
        $branches = $this->AccChartOfAccounts->Branches->find('list', ['limit' => 200]);
        //$parentAccChartOfAccounts = $this->AccChartOfAccounts->ParentAccChartOfAccounts->find('list', ['limit' => 200]);
        //, 'parentAccChartOfAccounts'
        $this->set(compact('accChartOfAccount', 'branches'));
    }

    public function addGroup()
    {
        $accChartOfAccount = $this->AccChartOfAccounts->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();

            $isUser = $dataRow['user_id'];
    
            if($dataRow['check_coa']=='N') {
                $rowMax = $this->AccChartOfAccounts->find('all',[
                    'fields' => array('codes' => 'MAX(code)+1'),
                    'conditions' => array('level' => 1)
                    ]);
                $rowMax = $rowMax->first();
                $dataMax = $rowMax->codes;
                $codeCOAs = (empty($dataMax)) ? "1": $dataMax;

            } else {
                $codeCOAs = $dataRow["code"];
            }
            $countLevel = 1;
            $padCode = 1;
            $codeCOA = str_pad($codeCOAs, $padCode , "0", STR_PAD_LEFT);
            $rowNames = (isset($dataRow['name'])) ? $dataRow['name']:NULL;
                
            $rowName = (empty($rowNames)) ? NULL : strtoupper($rowNames);
            
            $dataUserId = array('is_create' => $isUser);
            $dataName = array('name' => $rowName);
            $dataParentId = array('parent_id' => 0);
            $dataHeader = array('header_account' => $codeCOA);
            $dataLevel= array('level' => 1);
            $dataAdditional = array('additional' => 0);
            $dataSubGroup = array('sub_group' => "");
            $dataSubGroupNo = array('sub_group_no' => "");
            $dataSubHeaderAccount = array('sub_header_account' => "");
            $dataDescription = array('description' => "");
            $dataCodeAdditional = array('code_additional' => "");
            $dataCode = array('code' => $codeCOA);
            $dataTransaction = array('transaction' => 'n');
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add"); 
            $dataAuditLog = array('is_log' => $auditLog);

            $dataAccChartOfAccount = $this->AccChartOfAccounts->patchEntity($accChartOfAccount, array_merge($dataUserId, $dataLevel, $dataHeader, $dataCode, $dataName, $dataParentId, $dataAdditional, $dataSubGroup, $dataSubGroupNo, $dataSubHeaderAccount, $dataDescription, $dataCodeAdditional, $dataTransaction, $dataAuditLog));

            // pr($dataAccChartOfAccount);
            if ($this->AccChartOfAccounts->save($accChartOfAccount)) {
                $this->Flash->success(__('Data berhasil disimpan.'));

                return $this->redirect(['action' => 'add_group']);
            }
            $this->Flash->error(__('Data gagal disimpan, silakan coba kembali.'));
                       
        }
       // $branches = $this->AccChartOfAccounts->Branches->find('list', ['limit' => 200]);
        $this->set(compact('accChartOfAccount'));
    }

    public function moveUp($id=null) {
        $this->request->allowMethod(['post', 'put', 'get']);
        $accChartOfAccount = $this->AccChartOfAccounts->get($id);
        if ($this->AccChartOfAccounts->moveUp($accChartOfAccount)) {
            $this->Flash->success('Data berhasil digeser ke Atas.');
        } else {
            $this->Flash->error('Maaf, data gagal digeser ke Atas, silakan coba kembali !!');
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function moveDown($id = null)
    {
        $this->request->allowMethod(['post', 'put', 'get']);
        $accChartOfAccount = $this->AccChartOfAccounts->get($id);
        if ($this->AccChartOfAccounts->moveDown($accChartOfAccount)) {
            $this->Flash->success('Data berhasil digeser ke Bawah.');
        } else {
            $this->Flash->error('Maaf, data gagal digeser ke Bawah, silakan coba kembali !!');
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Edit method
     *
     * @param string|null $id Acc Chart Of Account id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null, $pages=null)
    {
        $accChartOfAccount = $this->AccChartOfAccounts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();

            $isUser = $dataRow['user_id'];

            if($dataRow["level"]==1) {
                $countLevel = 1;
                $parentId = 0;
                $codeParent = null;
                $headerAccount = $countLevel;
                $subHeaderAccount = null;
                $group = $dataRow["groups"];
            } else {
                list($parentId,$codeParent,$headerAccount,$subHeaderAccount,$group,$coaGroupName) = explode("^", $this->Krs->fDecode($dataRow["parent"]));
                $countLevel = count($this->AccChartOfAccounts->find('path', ['for' => $parentId])->all()) + 1;
                // list($parentId, $codeParent, $headerAccount, $subHeaderAccount, $group) = explode("^", $dataRow["parent"]);
                // // pr($dataRow["parent"]);
                // //Memanggil Path pada Tree
                // $countLevel = count($this->AccChartOfAccounts->find('path', ['for' => $parentId])->all())+1;
            }

            if($countLevel<5){
                $dataLevel = array('level' => $countLevel);
                $dataParent = array('parent_account' => $codeParent);
                $dataBranchId = array('branch_id' => 0);
                $dataHeader = array('header_account' => $headerAccount);
                $dataUserId = array('is_update' => $isUser);
                $COACodeArray = explode('.', (string)$codeParent);
                // if($dataRow['check_coa']=='N') {
                //     $codeCOAs = $this->AccChartOfAccounts->getMaxParent($codeParent);
                // } else {
                    $codeCOAs = $dataRow["code"];
                // }
                $codeCOAOld = $dataRow["code_old"];    
                if($countLevel==2 || $countLevel==3) {
                    $padCode = 2;
                } elseif($countLevel==4) {
                    $padCode = 4;
                } else {
                    $padCode = 1;
                }

                $codeCOA = str_pad($codeCOAs, $padCode , "0", STR_PAD_LEFT);
                if($countLevel==1) {
                    $coaCode = $codeCOAs.'.00.00.0000';
                } elseif($countLevel==2) {
                    $coaCode = $COACodeArray[0].'.'.$codeCOA.'.00.00';
                } elseif($countLevel==3) {
                    $coaCode = $COACodeArray[0].'.'.$COACodeArray[1].'.'.$codeCOA.'.00';
                } elseif($countLevel==4) {
                    $coaCode = $COACodeArray[0].'.'.$COACodeArray[1].'.'.$COACodeArray[2].'.'.$codeCOA;
                } else {
                    $coaCode = '0.0.00.00';
                }

                // if($countLevel==1) {
                //     $coaCode = $codeCOAs.'.00.0.00.0000';
                // } elseif($countLevel==2) {
                //     $coaCode = $COACodeArray[0].'.'.$codeCOA.'.0.00.0000';
                // } elseif($countLevel==3) {
                //     $coaCode = $COACodeArray[0].'.'.$COACodeArray[1].'.'.$codeCOA.'.00.0000';
                // } elseif($countLevel==4) {
                //     $coaCode = $COACodeArray[0].'.'.$COACodeArray[1].'.'.$COACodeArray[2].'.'.$codeCOA.'.0000';
                // } elseif($countLevel==5) {
                //     $coaCode = $COACodeArray[0].'.'.$COACodeArray[1].'.'.$COACodeArray[2].'.'.$COACodeArray[3].'.'.$codeCOA;
                // } else {
                //     $coaCode = '0.00.0.00.0000';
                // }


                //1.00.0.00.0000
                // if($countLevel==1) {
                //     $coaCode = $codeCOAs.'.00.0.00.0000';
                // } elseif($countLevel==2) {
                //     //$codeParent
                //     $coaCode = $codeCOAs.'.00.0.00.0000';
                // } elseif($countLevel==3) {
                //     $coaCode = $codeCOAs.'.00.0.00.0000';
                // } elseif($countLevel==4) {
                //     $coaCode = $codeCOAs.'.00.0.00.0000';
                // } elseif($countLevel==5) {
                //     $coaCode = $codeCOAs.'.00.0.00.0000';
                // } else {
                //     $coaCode = '0.00.0.00.0000';
                // }

                // $codeCOA = str_pad($codeCOAs, $padCode , "0", STR_PAD_LEFT);
                $dataCode = array('code' => $coaCode);
                //$dataCode = array('code' => $codeParent.".".$codeCOA);
                $rowNames = (isset($dataRow['name'])) ? $dataRow['name']:NULL;
                // $rowCodes = (isset($dataRow['code'])) ? $dataRow['code']:NULL;

                // if($dataRow['check_customer']=='Y') {
                //     $COAName = NULL;
                //     // $dataCode = array('code' => $codeParent.".".$codeCOA);
                //     $rowCustomerId = $dataRow['customer_id'];
                // } else {
                //     $COAName = $rowNames;
                //     $rowCustomerId = NULL;
                // }
                // $dataCustomerId = array('customer_id' => $rowCustomerId);

                if($countLevel==2){
                    $rowSubHeaderAccount = '';
                    $dataNames = (empty($rowNames)) ? NULL :$rowNames;
                    //$dataNames = (empty($rowNames)) ? NULL :strtoupper($rowNames);
                } else {
                    if($dataRow["level"]==1) {
                        $subHeaderAccounts = '';
                    } else {
                        $subHeaderAccounts = (empty($subHeaderAccount))?$headerAccount.".".$codeCOAs:$subHeaderAccount;
                    }

                    $rowSubHeaderAccount = $subHeaderAccounts;
                    $dataNames = (empty($rowNames)) ? NULL : $rowNames;
                    //$dataNames = (empty($rowNames)) ? NULL : ucwords(strtolower($rowNames));
                }

                if($dataRow['check_customer']=='Y') {
                    $COAName = NULL;
                    // $dataCode = array('code' => $codeParent.".".$codeCOA);
                    // $rowCustomerId = $dataRow['customer_id'];
                    $rowName = $dataRow['customer_id'];
                } else {
                    $COAName = $rowNames;
                    $rowName = $dataNames;
                    //$rowCustomerId = NULL$rowNames;
                }

                $rowBeginningBalanceDebet = (empty($dataRow['beginning_balance_debets'])) ? NULL : $this->Krs->nom2Dec($dataRow['beginning_balance_debets']);
                $rowBeginningBalanceCredit = (empty($dataRow['beginning_balance_credits'])) ? NULL : $this->Krs->nom2Dec($dataRow['beginning_balance_credits']);
                $rowBeginningBalanceDate = (empty($dataRow['beginning_balance_dates']))? NULL:$this->Krs->dateTo($dataRow['beginning_balance_dates']);
                $rowTransaction = ($countLevel==4)?'y':'n';

                $dataSubHeaderAccount = array('sub_header_account' => $rowSubHeaderAccount);
                $dataName = array('name' => $rowName);
                $dataJournalType = array('journal_type' => $dataRow['journal_type']);
                $dataParentId = array('parent_id' => $parentId);
                $dataNormalBalance = array('normal_balance' => $dataRow['normal_balance']);
                $dataGroup = array('groups' => $dataRow['groups']);
                // $dataGroup = array('groups' => $group);
                $dataAdditional = array('additional' => 0);
                $dataSubGroup = array('sub_group' => "");
                $dataSubGroupNo = array('sub_group_no' => "");
                $dataDescription = array('description' => "");
                // $dataCharacter = array('character' => "");
                $dataCodeAdditional = array('code_additional' => "");
                // $dataCodes = $codeParent.".".$codeCOA;           
                // $dataCode = array('code' => $dataCodes);
                $dataBeginningBalanceDebet = array('beginning_balance_debet' => $rowBeginningBalanceDebet);
                $dataBeginningBalanceCredit = array('beginning_balance_credit' => $rowBeginningBalanceCredit);
                $dataBeginningBalanceDate = array('beginning_balance_date' => $rowBeginningBalanceDate);
                $dataTransaction = array('transaction' => $rowTransaction);
                $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Edit"); 
                $dataAuditLog = array('is_log' => $auditLog);

                //, $dataCustomerId
                $accChartOfAccount = $this->AccChartOfAccounts->patchEntity($accChartOfAccount, array_merge($dataBranchId, $dataUserId, $dataJournalType, $dataLevel, $dataParent, $dataHeader, $dataCode, $dataSubHeaderAccount, $dataName, $dataParentId, $dataGroup, $dataAdditional, $dataSubGroup, $dataSubGroupNo, $dataDescription, $dataCodeAdditional, $dataBeginningBalanceDebet, $dataBeginningBalanceCredit, $dataBeginningBalanceDate, $dataTransaction, $dataNormalBalance, $dataAuditLog));
                // pr($accChartOfAccount);
                // debug($accChartOfAccount); die;
                //230804
                if ($this->AccChartOfAccounts->save($accChartOfAccount)) {
                    $this->Flash->success(__('Data berhasil disimpan.'));

                    if(!empty($pages)) {
                        return $this->redirect(['action' => 'index', '?' => ['page'=>$pages]]);
                    } else {
                        return $this->redirect(['action' => 'index']);
                    }
                    
                    // return $this->redirect($this->referer());
                }
                $this->Flash->error(__('Data gagal disimpan, silakan coba kembali.'));

                // pr($accChartOfAccount);
                //journal_type
                // Check duplicate data
                // $codeCOAOld
                // dataCodes
                // $dataSameCode = ($codeCOAOld==$dataCodes)
                /*if($codeCOAOld!=$dataCodes) {
                    $checkCountDuplicate = $this->AccChartOfAccounts->find()->where(['SUBSTRING_INDEX(code, ".", 4) =' => $codeParent, 'name' => $rowName])->count();
                } else {

                }*/
                // 
                // pr($pages);
                
                // if($checkCountDuplicate==0) {

                // } else {
                //     $this->Flash->error(__('Data tidak boleh sama, silakan coba kembali.'));
                // }
            } else {
                $this->Flash->error(__('Maaf Level tidak boleh melebihi dari Level 4!..'));
            }


            // $accChartOfAccount = $this->AccChartOfAccounts->patchEntity($accChartOfAccount, $this->request->getData());
            // if ($this->AccChartOfAccounts->save($accChartOfAccount)) {
            //     $this->Flash->success(__('The acc chart of account has been saved.'));

            //     return $this->redirect(['action' => 'index']);
            // }
            // $this->Flash->error(__('The acc chart of account could not be saved. Please, try again.'));
        }
        // $branches = $this->AccChartOfAccounts->Branches->find('list', ['limit' => 200]);
        $parentAccChartOfAccounts = $this->AccChartOfAccounts->ParentAccChartOfAccounts->find('list', ['limit' => 200]);

        // $aCategory->parent_id = 5;
        // $rowParentData = $this->AccChartOfAccounts->find('path', ['for' => $accChartOfAccount['parent_id']])->first();
        $rowParentData = $this->AccChartOfAccounts->find('all')->where(['AccChartOfAccounts.id' => $accChartOfAccount['parent_id']])->first();
        //pr($accChartOfAccount['parent_id']);
        if(isset($rowParentData)) {
            // $data['dataParentId'] = $rowParentData['id'].'^'.$rowParentData['code'].'^'.$rowParentData['header_account'].'^'.$rowParentData['sub_header_account'].'^'.$rowParentData['group'];
            $data['dataParentId'] = $this->Krs->fEncode($rowParentData['id'].'^'.$rowParentData['code'].'^'.$rowParentData['header_account'].'^'.$rowParentData['sub_header_account'].'^'.$rowParentData['groups'].'^'.$rowParentData['coaGroupName']);
            $data['dataParentData'] = '('.$rowParentData['code'].') '.$rowParentData['name'];
        } else {
            $data['dataParentId'] = '^^^^';
            $data['dataParentData'] = "";
        }
        // $rowParentData = $this->AccChartOfAccounts->parent_id($accChartOfAccount['parent_id']);
        // pr($rowParentData);

        $this->set(compact('accChartOfAccount', 'parentAccChartOfAccounts', 'data'));
    }

    public function beginningBalanceExportImport($condition=null) {
        // $accChartOfAccount = $this->AccChartOfAccounts->get($id, [
        //     'contain' => [],
        // ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // $accChartOfAccount = $this->AccChartOfAccounts->newEmptyEntity();
            if($condition=="save") {
                $maxFile = "502400";

                $dataRow = $this->request->getData();
                $isUser = $dataRow['user_id'];

                // $filename = $dataRow['filename'];
                $files = $this->request->getUploadedFiles();
                $fileNameUpload = $files['filename']->getClientFileName();

                if(!empty($fileNameUpload)) {
                    $files['filename']->getStream();
                    $sizeFile = $files['filename']->getSize();
                    // $files['filename']->getClientFileName();
                    // pr($fileNameUpload);
                    // pr($_FILES['upfile']['error']);

                    if($maxFile>=$sizeFile){
                        // $stream = $uploadedFile->getStream();
                        // $tmpFilePath = $stream->getMetadata('uri');
                        // Mengambil data pada form
                        $myname = $this->request->getData()['filename']->getClientFileName();
                        $myext = substr(strchr($myname, "."), 1);
                        $mypath = "upload/imports/".$myname; //Path untuk menaruh file yg akan diupload

                        // Kodisi untuk menaruh file upload
                        $files['filename']->moveTo(WWW_ROOT.$mypath);
                        // Kodisi pemisahan extention excel
                        if ($myext == 'xls') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                        } elseif($myext == 'xlsx') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }

                        $spreadsheet = $reader->load(WWW_ROOT.$mypath); // Membaca file yg sudah diupload
                        $sheets = $spreadsheet->getActiveSheet()->toArray(); // Membaca data dan membuat menjadi array

                        $sheet = array_splice($sheets, 1);
                        $accChartOfAccounts = array();
                        // pr($sheet);
                        foreach ($sheet as $keys => $excel){
                            if ($keys == 0) {
                                continue;
                            } 

                            
                            // if($excel[3]==0 || empty($excel[3])) {
                                
                            // } else {
                                
                            $xlsId = $excel[0];
                            $xlsCode = $excel[1];
                            $xlsName = $excel[2];
                            //$xlsBeginningBalance = $excel[3];
                            $xlsBeginningBalanceDebet = ($excel[3]==0 || empty($excel[3])) ? null : $excel[3];
                            $xlsBeginningBalanceCredit = ($excel[4]==0 || empty($excel[4])) ? null : $excel[4];

                            // pr($xlsId);
                            // $data = [
                            //     'id' => $excel[0],
                            //     'code' => $excel[1],
                            //     'name' => $excel[2],
                            //     'beginning_balances' => $excel[3],
                            //     //'group_id' => $group_id,
                            // ];
                            // pr($data);
                            // $dataId = array('id' => $xlsId);
                            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $xlsId,  $isUser, "edit from upload excel"); 
                            //$dataAuditLog = array('is_log' => $auditLog);
                            //$dataBeginningBalance = array('beginning_balance' => $xlsBeginningBalance);

                            //$dataAccChartOfAccount = array_merge($dataBeginningBalance, $dataAuditLog);

                            // pr($dataAccChartOfAccount);
                            $this->AccChartOfAccounts->updateAll(['beginning_balance_debet' => $xlsBeginningBalanceDebet, 'beginning_balance_credit' => $xlsBeginningBalanceCredit, 'is_log' => $auditLog], ['id' => $xlsId]);
                            // }

                            // $accChartOfAccount = $this->AccChartOfAccounts->get($xlsId, [
                            //     'contain' => [],
                            // ]);
                            // $accChartOfAccounts[] = $this->AccChartOfAccounts->patchEntity($accChartOfAccount, array_merge($dataBeginningBalance, $dataAuditLog));
                            

                            // pr($accChartOfAccount);
                        //     $auditLog = $this->KrsCom->auditLog("AccChartOfAccount", $coaId, $this->params['controller'],  $isUser, "edit from upload excel");
                        
                        // $dataEditCOA["AccChartOfAccount"]["is_update"] = $isUser;
                        // $dataEditCOA['AccChartOfAccount']['is_log'] = "'".$auditLog."'";
                        // $dataEditCOA['AccChartOfAccount']['beginning_balance'] = $coaSaldoAwal;

                            // debug($data);
                            // die();
                            //$student = $this->Students->newEmptyEntity();
                            //$student = $this->Students->patchEntity($student, $data);
                            //if ($excel[1] != null AND $excel[2] != null) {
                            //    pr($student);
                                // if ($this->Students->save($student)) {
                                //     $this->Flash->success(__('The student has been saved.'));
                                // }
                            //}else{
                            //    $this->Flash->error(__('The student could not be saved. Please, try again.'));
                            //}

                        }

                        $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));
                        return $this->redirect(['action' => 'beginningBalanceExportImport']);





                        // pr($accChartOfAccounts);
                        /*if ($this->AccChartOfAccounts->save($accChartOfAccount, array('callbacks' => false))) {
                            $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                            
                        }
                        $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));*/
                        // return $this->redirect(['action' => 'index']);


                        // pr($myext);
                    }
                } else {
                     return $this->redirect(['action' => 'beginningBalanceExportImport']);
                }
                // $results = $this->Krs->uploadXls($filename, 0, 4, $strConfirmUpload);
            }
        }

        $key = $this->request->getQuery('key');
        if ($key) {
          $query = $this->AccChartOfAccounts->find('all')
                        ->where(['OR'=>['AccChartOfAccounts.name like' => '%' . $key . '%']]);
        } else {
          $query = $this->AccChartOfAccounts;
        }

        $settings = [
            'conditions' => ['AccChartOfAccounts.level' => 4],
            'limit' => 45,
            'order' => [
                'lft' => 'asc',
            ],
        ];

        $this->paginate = [
            //'contain' => ['Branches', 'ParentAccChartOfAccounts'],
        ];
        $accChartOfAccounts = $this->paginate($query, $settings);

        $this->set(compact('accChartOfAccounts'));

        //$accChartOfAccount = $this->AccChartOfAccounts->find('all')->where(['AccChartOfAccounts.level' => 5])->all();

        // $data['dataParentId'] = $rowParentData['id'].'^'.$rowParentData['code'].'^'.$rowParentData['header_account'].'^'.$rowParentData['sub_header_account'].'^'.$rowParentData['group'];
        // $data['dataParentData'] = '('.$rowParentData['code'].') '.$rowParentData['name'];
        // $rowParentData = $this->AccChartOfAccounts->parent_id($accChartOfAccount['parent_id']);
        // pr($rowParentData);

        // $this->set(compact('accChartOfAccount'));

        /*$data['page'] = 'Export/Import';
        $data["breadcrumb"] = 'Saldo Awal';
        $data['titleForLayout'] = $data["breadcrumb"].' - '.$data['page'];
        
        //$data['page'] = 'Perkiraan - Saldo Awal';
        //$data['titleForLayout'] = 'Daftar - '.$data['page'];

        //$this->set("title_for_layout", "Daftar Perkiraan &nbsp;&raquo;&nbsp;");
        
        $this->helpers[] = "FilterResults.Search";
        
        $this->Filter->setPaginate("fields", "AccChartOfAccount.id, AccChartOfAccount.parent_id, AccChartOfAccount.name, AccChartOfAccount.code, AccChartOfAccount.type, AccChartOfAccount.journal_type, AccChartOfAccount.group, AccChartOfAccount.level, AccChartOfAccount.transaction, AccChartOfAccount.contra_account, AccChartOfAccount.beginning_balance, AccChartOfAccount.beginning_balance_date, Customer.id, Customer.title, Customer.name");

        $this->Filter->setPaginate("order", "AccChartOfAccount.lft ASC, AccChartOfAccount.rght ASC"); 
        $this->Filter->setPaginate("limit", 20); 
        $this->Filter->setPaginate("recursive", 1);              
        // Define conditions
        $this->Filter->setPaginate("conditions", array('AccChartOfAccount.level'=>5 ,$this->Filter->getConditions()));

        //$this->set("data", $this->paginate());

        if ($this->request->is('post') || $this->request->is('put')) {
            if($condition=="save") {
                $uploadExcel = $this->request->data['UploadExcel'];
                $filename = $uploadExcel['filename'];

                if(empty($filename['name'])) {
                    $this->KrsCom->setFlash("Maaf file tidak ditemukan!..", "error");
                    //$this->redirect(array('event_id' => $this->uuid, "controller"=>"acc_chart_of_accounts", "action" => "export_import_saldo_awal"));
                    
                } else {
                    $results = $this->KrsCom->__upload($filename, 0, 4, $strConfirmUpload);
                    //pr($results);
                    $isUser = (isset($uploadExcel['is_update'])) ? $uploadExcel['is_update'] : '';

                    // pr($this->request->data);

                    // $isUser = "";
                    foreach ($results as $dataExcel) {
                        $coaId = $dataExcel['A'];
                        $coaSaldoAwal = $dataExcel['D'];

                        $auditLog = $this->KrsCom->auditLog("AccChartOfAccount", $coaId, $this->params['controller'],  $isUser, "edit from upload excel");
                        
                        $dataEditCOA["AccChartOfAccount"]["is_update"] = $isUser;
                        $dataEditCOA['AccChartOfAccount']['is_log'] = "'".$auditLog."'";
                        $dataEditCOA['AccChartOfAccount']['beginning_balance'] = $coaSaldoAwal;

                        //pr($dataEditCOA);

                        //pr($coaId.' - '.$coaSaldoAwal);
                        $updateCOA = $this->AccChartOfAccount->updateAll($dataEditCOA["AccChartOfAccount"], array('AccChartOfAccount.id' => $coaId), -1);
                        $this->AccChartOfAccount->commit();
                    }
                    $this->KrsCom->setFlash("Data Perkiraan berhasil disimpan. ".$strConfirmUpload, "success");
                    //pr($uploadExcel);
                }
                $this->redirect(array('event_id' => $this->uuid, "controller"=>"acc_chart_of_accounts", "action" => "export_import_saldo_awal"));

                //$this->KrsCom->setFlash("Maaf Level tidak boleh melebihi dari Level 5!..", "error");

                //$this->Session->setFlash($strConfirmUpload, 'default', array('class' => 'message'));
                

                
            }
        }

        $data['rows'] = $this->paginate();

        $data['condLink'] = 'data^exportImport^saldoAwal^';
        $this->set(compact('data'));*/
    }

    public function xls() {
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                // 'wrapText' => true,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $styleArrayInfo = [
            'font'  => [
                // 'bold'  => true,
                'color' => ['argb' => 'FF757575'],
                // 'size'  => 15,
                // 'name'  => 'Verdana'
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                // 'rotation' => 90,
                'color' => [
                    'argb' => 'FFEFEFEF',
                ],
                
            ],
        ]; 

        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray);
        // $spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Kode Perkiraan');
        $sheet->setCellValue('C1', 'Nama Perkiraan');
        $sheet->setCellValue('D1', 'Saldo Awal Debet');
        $sheet->setCellValue('E1', 'Saldo Awal Credit');
        
        $report = $this->AccChartOfAccounts->find('all')->order(['AccChartOfAccounts.lft' => 'ASC'])->toArray();
        //->where(['AccChartOfAccounts.level' => '5'])

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->id);
            $sheet->setCellValue('B' . $row, $data->code);
            $sheet->setCellValue('C' . $row, $data->name);
            
            $sheet->setCellValue('D' . $row, $data->beginning_balance_debet);
            $sheet->setCellValue('E' . $row, $data->beginning_balance_credit);
            
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'daftar-coa';

        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function beginningBalanceExportImportXls($condition=null) {
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                // 'wrapText' => true,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            /*'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],*/
        ];

        $styleArrayInfo = [
            'font'  => [
                // 'bold'  => true,
                'color' => ['argb' => 'FF757575'],
                // 'size'  => 15,
                // 'name'  => 'Verdana'
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                // 'rotation' => 90,
                'color' => [
                    'argb' => 'FFEFEFEF',
                ],
                
            ],
        ]; 

        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray);
        // $spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('A2', 'Jangan ubah informasi pada kolom ini');
        $sheet->setCellValue('B1', 'Kode Perkiraan');
        $sheet->setCellValue('B2', 'Jangan ubah informasi pada kolom ini');
        $sheet->setCellValue('C1', 'Nama Perkiraan');
        $sheet->setCellValue('C2', 'Jangan ubah informasi pada kolom ini');
        if(empty($condition)) {
        $sheet->setCellValue('D1', 'Saldo Awal Debet');
        $sheet->setCellValue('D2', 'Masukan data Saldo Awall Debet');
        $sheet->setCellValue('E1', 'Saldo Awal Credit');
        $sheet->setCellValue('E2', 'Masukan data Saldo Awal Credit');
        }

        $report = $this->AccChartOfAccounts->find('all')->where(['AccChartOfAccounts.level' => '4'])->order(['AccChartOfAccounts.lft' => 'ASC'])->toArray();

        $row = 3;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->id);
            $sheet->setCellValue('B' . $row, $data->code);
            $sheet->setCellValue('C' . $row, $data->name);
            
            if(empty($condition)) {
            $sheet->setCellValue('D' . $row, $data->beginning_balance_debet);
            $sheet->setCellValue('E' . $row, $data->beginning_balance_credit);
            }

            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'daftar-perkiraan';        
        //$filename = 'customers-' . date('dmy-His');

        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }


    /**
     * Delete method
     *
     * @param string|null $id Acc Chart Of Account id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accChartOfAccount = $this->AccChartOfAccounts->get($id);
        if ($this->AccChartOfAccounts->delete($accChartOfAccount)) {
            $this->Flash->success(__('Data berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Data gagal dihapus, silakan coba kembali.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function statusSubmission($level=null) {
        // pr($this->request->getQuery());
        $this->autoRender=false;
        
        // Memanggil data dengan method POST
        $getLink = $this->request->getQuery();
        // Memanggil data dengan method GET
        $dataRow = $this->request->getData();
        
        $filterId = (empty($dataRow)) ? $getLink['id'] : $dataRow['id'];
        $filterCond = (empty($dataRow)) ? $getLink['cond'] : $dataRow['cond'];
        $filterValue = (empty($dataRow)) ? $getLink['yn'] : $dataRow['yn'];
        $filterUserId = (empty($dataRow)) ? $getLink['user'] : $dataRow['user'];

        if (!empty($filterId) && $filterCond=='debet') {
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $filterId, $filterUserId, "Active Submission Debet"); 

            $this->AccChartOfAccounts->updateAll(['submission_debet' => $filterValue, 'is_log' => $auditLog], ['id' => $filterId]);

            // pr($auditLog);
            $result = $filterValue;
        } elseif (!empty($filterId) && $filterCond=='credit') {
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $filterId, $filterUserId, "Active Submission Credit"); 

            $this->AccChartOfAccounts->updateAll(['submission_credit' => $filterValue, 'is_log' => $auditLog], ['id' => $filterId]);

            $result = $filterValue;
        } else {
            $result = "errors";
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
        // pr($this->request->getQuery());
    }

    // Memanggil data List
    public function getList($usingDefault=null)
    {
        $this->autoRender = false;
        // $this->loadModel('Customers');

        $dataSearch = $this->request->getQuery('dataSearch');

        if($usingDefault=='submissionDebet') {
            $usingSubmission = array('AccChartOfAccounts.submission_debet'=>'Y');
        } elseif($usingDefault=='submissionCredit') {
            $usingSubmission = array('AccChartOfAccounts.submission_credit'=>'Y');
        } else {
            $usingSubmission = array();
        }
        // pr($dataSearch);
        $dataRows = $this->AccChartOfAccounts->find('all')->contain(['Customers'])->select(['coaId' => "CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code)", 'AccChartOfAccounts.id', 'AccChartOfAccounts.code', 'AccChartOfAccounts.default', 'AccChartOfAccounts.name', 'AccChartOfAccounts.journal_type', 'AccChartOfAccounts.ending_balance_bank', 'AccChartOfAccounts.header_account', 'coaName' => "IFNULL(AccChartOfAccounts.name, CONCAT(Customers.title,' ',Customers.name))"])->where([$usingSubmission, 'AccChartOfAccounts.level' => 4, 'IFNULL(AccChartOfAccounts.name, Customers.name) LIKE' => "%".$dataSearch."%", ['OR' => [['OR' => [['LEFT(AccChartOfAccounts.code,1) IN' => [1,2,3],'AccChartOfAccounts.ending_balance_bank >' => 0], ['LEFT(AccChartOfAccounts.code,1) IN' => [5,6,8]], ['AccChartOfAccounts.code LIKE' => '1.08%']]]]]])->order(['AccChartOfAccounts.lft' => 'ASC']);

        // $dataRows = $this->AccChartOfAccounts->find('all')->contain(['Customers'])->select(['coaId'=>"CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code)", "AccChartOfAccounts.id", "AccChartOfAccounts.code", "AccChartOfAccounts.default", "AccChartOfAccounts.name", "AccChartOfAccounts.journal_type", "AccChartOfAccounts.ending_balance_bank", 'coaName'=>"IFNULL(AccChartOfAccounts.name, CONCAT(Customers.title,' ',Customers.name))"])->where([$usingSubmission, 'AccChartOfAccounts.level' => 4,'AccChartOfAccounts.ending_balance_bank >' => 0, 'IFNULL(AccChartOfAccounts.name, Customers.name) LIKE' =>"%".$dataSearch."%"])->order(['AccChartOfAccounts.lft'=>'ASC']);
        //, 'coaName'=>"CONCAT('( ',AccChartOfAccounts.code,') ', AccChartOfAccounts.name)"

        // "fields" => array("CONCAT(AccChartOfAccount.id,'^', AccChartOfAccount.code) AS AccChartOfAccount__coaId", "AccChartOfAccount.id", "AccChartOfAccount.code", "AccChartOfAccount.default", "AccChartOfAccount.name", "AccChartOfAccount.journal_type", 
        
        // "CONCAT('( ',AccChartOfAccount.code,') ', AccChartOfAccount.name)", "IFNULL(AccChartOfAccount.name, CONCAT(Customer.title,' ',Customer.name)) AS AccChartOfAccount__coaName"),
        // pr($dataRows);

        $result = array();
        foreach ($dataRows as $key => $data) {
            // $result[$key]['id'] = (int) $data['coaId'];
            $result[$key]['id'] = $data['coaId'];
            $result[$key]['text'] = '('.$data['code'] . ') ' . $data['coaName'].' - Saldo Akhir Rp.'.$this->Krs->nom($data['ending_balance_bank']);
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
        // pr($result);
        /* $dataRows = $this->Items->find('all')->where(['name like' => '%' . $dataSearch . '%'])->order(['Items.name' => 'ASC']);
        
        $result = array();
        foreach ($dataRows as $key => $data) {
            $result[$key]['id'] = (int) $data['id'];
            $result[$key]['text'] = $data['title'] . ' ' . $data['name'];
        }
        
         */
    }

    // public function templateExcel()
    // {
    //     $spreadsheet = new Spreadsheet();
    //     // ── Sheet 1: Template COA ────────────────────────────────
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setTitle('Template COA');
    //     // Header kolom
    //     $headers = ['Header', 'Sub Header', 'Group', 'Detail', 'Nama COA'];
    //     foreach ($headers as $col => $label) {
    //         $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . '1';
    //         $sheet->setCellValue($cell, $label);
    //     }
    //     $sheet->getStyle('A1:E1')->applyFromArray([
    //         'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
    //         'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E5F9A']],
    //         'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    //         'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
    //     ]);
    //     // Contoh data
    //     $examples = [
    //         [1,    null, null, null,   'AKTIVA'],
    //         [1,    '01', null, null,   'KAS'],
    //         [1,    '01', '01', null,   'KAS KECIL'],
    //         [1,    '01', '01', '0001', 'KAS KECIL A'],
    //         [1,    '02', null, null,   'BANK'],
    //         [1,    '02', '01', null,   'BANK MANDIRI'],
    //         [1,    '02', '01', '0001', 'BM REK_000123'],
    //         [2,    null, null, null,   'HUTANG'],
    //         [2,    '01', null, null,   'HUTANG USAHA'],
    //         [2,    '01', '01', null,   'HUTANG DAGANG'],
    //         [2,    '01', '01', '0001', 'HUTANG DAGANG A'],
    //         [3,    null, null, null,   'MODAL'],
    //         [3,    '01', null, null,   'MODAL DISETOR'],
    //         [3,    '01', '01', null,   'MODAL SAHAM'],
    //         [3,    '01', '01', '0001', 'SAHAM BIASA'],
    //     ];
    //     // Warna per level
    //     $levelColors = [
    //         1 => 'D9E1F2',
    //         2 => 'E2EFDA',
    //         3 => 'FFF2CC',
    //         4 => 'FFFFFF',
    //     ];
    //     $row = 2;
    //     foreach ($examples as $data) {
    //         if (!empty($data[3])) {
    //             $level = 4;
    //         } elseif (!empty($data[2])) {
    //             $level = 3;
    //         } elseif (!empty($data[1])) {
    //             $level = 2;
    //         } else {
    //             $level = 1;
    //         }
    //         $sheet->fromArray($data, null, 'A' . $row);
    //         $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
    //             'font'    => ['bold' => ($level == 1), 'size' => 10],
    //             'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $levelColors[$level]]],
    //             'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
    //         ]);
    //         $sheet->getStyle("E{$row}")->getAlignment()->setIndent($level - 1);
    //         $row++;
    //     }
    //     $sheet->getColumnDimension('A')->setWidth(10);
    //     $sheet->getColumnDimension('B')->setWidth(12);
    //     $sheet->getColumnDimension('C')->setWidth(10);
    //     $sheet->getColumnDimension('D')->setWidth(10);
    //     $sheet->getColumnDimension('E')->setWidth(45);
    //     $sheet->freezePane('A2');
    //     // ── Sheet 2: Petunjuk ────────────────────────────────────
    //     $guide = $spreadsheet->createSheet();
    //     $guide->setTitle('Petunjuk');
    //     $guideData = [
    //         ['PETUNJUK PENGISIAN TEMPLATE IMPORT COA'],
    //         [''],
    //         ['Kolom',        'Keterangan',                                              'Contoh'],
    //         ['Header',       'Nomor kelompok utama (angka bulat)',                      '1, 2, 3'],
    //         ['Sub Header',   'Kode sub-kelompok 2 digit',                              '01, 02'],
    //         ['Group',        'Kode grup 2 digit, isi jika ada level group',            '01, 02'],
    //         ['Detail',       'Kode detail akun 4 digit, isi jika level terdalam',      '0001, 0002'],
    //         ['Nama COA',     'Nama akun — wajib diisi di semua baris',                 'NAMA AKUN'],
    //         [''],
    //         ['ATURAN LEVEL:'],
    //         ['Level 1 (Header)',     '→ Isi kolom Header saja, kolom lain KOSONG'],
    //         ['Level 2 (Sub Header)', '→ Isi Header + Sub Header, Group & Detail KOSONG'],
    //         ['Level 3 (Group)',      '→ Isi Header + Sub Header + Group, Detail KOSONG'],
    //         ['Level 4 (Detail)',     '→ Isi semua kolom: Header, Sub Header, Group, Detail'],
    //         [''],
    //         ['CONTOH KODE YANG DIHASILKAN:'],
    //         ['Level 1: Header=1                           → Kode: 1.0.00.00'],
    //         ['Level 2: Header=1, SubHeader=01             → Kode: 1.01.00.00'],
    //         ['Level 3: Header=1, Sub=01, Group=01         → Kode: 1.01.01.00'],
    //         ['Level 4: Header=1, Sub=01, Grp=01, Det=0001 → Kode: 1.01.01.0001'],
    //         [''],
    //         ['CATATAN:'],
    //         ['- Baris yang kolom Nama COA-nya kosong akan dilewati (skip)'],
    //         ['- Data duplikat (kode sama) akan dilewati otomatis'],
    //         ['- Hapus atau biarkan baris contoh — duplikat akan di-skip saat import'],
    //     ];
    //     foreach ($guideData as $i => $rowData) {
    //         $guide->fromArray($rowData, null, 'A' . ($i + 1));
    //     }
    //     $guide->getStyle('A1')->applyFromArray([
    //         'font' => ['bold' => true, 'size' => 13, 'color' => ['rgb' => '2E5F9A']],
    //     ]);
    //     $guide->getStyle('A3:C3')->applyFromArray([
    //         'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    //         'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E5F9A']],
    //     ]);
    //     $guide->getColumnDimension('A')->setWidth(55);
    //     $guide->getColumnDimension('B')->setWidth(55);
    //     $guide->getColumnDimension('C')->setWidth(20);
    //     // ── Output ───────────────────────────────────────────────
    //     $filename = 'Template_Import_COA.xlsx';
    //     ob_end_clean();
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="' . $filename . '"');
    //     header('Cache-Control: max-age=0');
    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('php://output');
    //     exit;
    // }

    // public function importExcel($condition = null)
    // {
    //     $accChartOfAccount = $this->AccChartOfAccounts->newEmptyEntity();
    //     $show = 'N';
    //     $rows = [];

    //     if ($this->request->is(['post', 'patch', 'put'])) {
    //         if ($condition == 'preview') {
    //             $file = $this->request->getData('filename');
    //             if (empty($file) || $file->getError() !== UPLOAD_ERR_OK) {
    //                 $this->Flash->error('File belum dipilih');
    //                 return $this->redirect($this->referer());
    //             }
    //             try {
    //                 $spreadsheet = IOFactory::load($file->getStream()->getMetadata('uri'));
    //                 $sheet = $spreadsheet->getSheetByName('Template COA');
    //                 if (!$sheet) {
    //                     foreach ($spreadsheet->getAllSheets() as $candidate) {
    //                         if (stripos($candidate->getTitle(), 'petunjuk') === false) {
    //                             $sheet = $candidate;
    //                             break;
    //                         }
    //                     }
    //                 }
    //                 if (!$sheet) {
    //                     $sheet = $spreadsheet->getSheet(0);
    //                 }
    //                 $sheetRows = $sheet->toArray();
    //                 unset($sheetRows[0]); // buang baris header (Header, Sub Header, Group, Detail, Nama COA)
    //                 $previewRows = [];
    //                 foreach ($sheetRows as $row) {
    //                     $header     = trim((string)($row[0] ?? ''));
    //                     $subHeader  = trim((string)($row[1] ?? ''));
    //                     $groupCode  = trim((string)($row[2] ?? ''));
    //                     $detailCode = trim((string)($row[3] ?? ''));
    //                     $name       = trim((string)($row[4] ?? ''));
    //                     if (empty($name) || empty($header)) {
    //                         continue; // baris kosong tidak perlu ditampilkan
    //                     }
    //                     if (!empty($detailCode)) {
    //                         $level = 4;
    //                     } elseif (!empty($groupCode)) {
    //                         $level = 3;
    //                     } elseif (!empty($subHeader)) {
    //                         $level = 2;
    //                     } else {
    //                         $level = 1;
    //                     }
    //                     if ($level == 1) {
    //                         $code             = $header . '.0.00.00';
    //                         $parentCode       = null;
    //                         $headerAccount    = $header;
    //                         $subHeaderAccount = '';
    //                     } elseif ($level == 2) {
    //                         $code             = $header . '.' . str_pad($subHeader, 2, '0', STR_PAD_LEFT) . '.00.00';
    //                         $parentCode       = $header . '.0.00.00';
    //                         $headerAccount    = $header;
    //                         $subHeaderAccount = '';
    //                     } elseif ($level == 3) {
    //                         $code             = $header . '.' . $subHeader . '.' . str_pad($groupCode, 2, '0', STR_PAD_LEFT) . '.00';
    //                         $parentCode       = $header . '.' . str_pad($subHeader, 2, '0', STR_PAD_LEFT) . '.00.00';
    //                         $headerAccount    = $header;
    //                         $subHeaderAccount = $header . '.' . $subHeader;
    //                     } else { // level 4
    //                         $code             = $header . '.' . $subHeader . '.' . str_pad($groupCode, 2, '0', STR_PAD_LEFT) . '.' . str_pad($detailCode, 4, '0', STR_PAD_LEFT);
    //                         $parentCode       = $header . '.' . $subHeader . '.' . str_pad($groupCode, 2, '0', STR_PAD_LEFT) . '.00';
    //                         $headerAccount    = $header;
    //                         $subHeaderAccount = $header . '.' . $subHeader;
    //                     }
    //                     $parent   = $parentCode ? $this->AccChartOfAccounts->find()->where(['code' => $parentCode])->first() : null;
    //                     $parentId = $parent->id ?? 0;
    //                     $isDuplicate = $this->AccChartOfAccounts->find()->where(['code' => $code])->count() > 0;
    //                     $previewRows[] = [
    //                         'header'             => $header,
    //                         'sub_header'         => $subHeader,
    //                         'group'              => $groupCode,
    //                         'detail'             => $detailCode,
    //                         'name'               => $name,
    //                         'level'              => $level,
    //                         'code'               => $code,
    //                         'parent_id'          => $parentId,
    //                         'parent_account'     => $parentCode,
    //                         'header_account'     => $headerAccount,
    //                         'sub_header_account' => $subHeaderAccount,
    //                         'is_duplicate'       => $isDuplicate,
    //                     ];
    //                 }
    //                 if (empty($previewRows)) {
    //                     $this->Flash->error('Tidak ada data valid pada file Excel.');
    //                     return $this->redirect($this->referer());
    //                 }
    //                 $rows = $previewRows;
    //                 $show = 'Y';
    //             } catch (\Exception $e) {
    //                 $this->Flash->error('Gagal membaca file: ' . $e->getMessage());
    //                 return $this->redirect($this->referer());
    //             }
    //         } elseif ($condition == 'save') {
    //             $rowsJson = $this->request->getData('rows_json');
    //             $datas = json_decode((string)$rowsJson, true);

    //             if (empty($datas) || !is_array($datas)) {
    //                 $this->Flash->error('Tidak ada data untuk disimpan.');
    //                 return $this->redirect(['action' => 'importExcel']);
    //             }
    //             $successCount = 0;
    //             $skipCount    = 0;
    //             foreach ($datas as $data) {
    //                 if (($data['published'] ?? 'N') !== 'Y') {
    //                     $skipCount++;
    //                     continue;
    //                 }
    //                 $name = trim((string)($data['name'] ?? ''));
    //                 $code = trim((string)($data['code'] ?? ''));
    //                 if (empty($name) || empty($code)) {
    //                     $skipCount++;
    //                     continue;
    //                 }
    //                 $isDuplicate = $this->AccChartOfAccounts->find()->where(['code' => $code])->count();
    //                 if ($isDuplicate > 0) {
    //                     $skipCount++;
    //                     continue;
    //                 }
    //                 $level = (int)($data['level'] ?? 1);
    //                 $entity = $this->AccChartOfAccounts->newEmptyEntity();
    //                 $entity = $this->AccChartOfAccounts->patchEntity($entity, [
    //                     'branch_id'          => 0,
    //                     'parent_id'          => $data['parent_id'] ?? 0,
    //                     'level'              => $level,
    //                     'parent_account'     => $data['parent_account'] ?? null,
    //                     'header_account'     => $data['header_account'] ?? '',
    //                     'sub_header_account' => $data['sub_header_account'] ?? '',
    //                     'code'               => $code,
    //                     'name'               => strtoupper($name),
    //                     'journal_type'       => '',
    //                     'normal_balance'     => '',
    //                     'transaction'        => ($level == 4 ? 'y' : 'n'),
    //                     'additional'         => 0,
    //                     'sub_group'          => '',
    //                     'sub_group_no'       => '',
    //                     'description'        => '',
    //                     'code_additional'    => '',
    //                     'is_create'          => $this->Authentication->getIdentity()->id,
    //                     'is_active'          => 'y',
    //                 ]);
    //                 $entities[] = $entity;
                    
    //                 if ($this->AccChartOfAccounts->save($entity)) {
    //                     $successCount++;
    //                 } else {
    //                     $skipCount++;
    //                 }
    //             }
    //             // debug($entities); die;
    //             $this->Flash->success(
    //                 "Import berhasil. {$successCount} data disimpan, {$skipCount} baris dilewati (kosong/duplikat)."
    //             );
    //             return $this->redirect(['action' => 'index']);
    //         }
    //     }
    //     // Request GET (buka halaman pertama kali) -> render import_excel.php
    //     $this->set(compact('accChartOfAccount', 'show', 'rows'));
    // }
    public function templateExcel()
    {
        $spreadsheet = new Spreadsheet();

        // ── Sheet 1: Template COA ────────────────────────────────
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template COA');

        // Header kolom
        $headers = ['Header', 'Sub Header', 'Group', 'Detail', 'Nama COA', 'Jenis Jurnal', 'Saldo Normal', 'Post'];
        foreach ($headers as $col => $label) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . '1';
            $sheet->setCellValue($cell, $label);
        }
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E5F9A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
        ]);

        // Contoh data
        // Kolom Jenis Jurnal / Saldo Normal / Post hanya diisi di baris Level 4 (akun transaksi)
        $examples = [
            [1,    null, null, null,   'AKTIVA',          null,                   null,     null],
            [1,    '01', null, null,   'KAS',              null,                  null,     null],
            [1,    '01', '01', null,   'KAS KECIL',        null,                  null,     null],
            [1,    '01', '01', '0001', 'KAS KECIL A',      'Kas dan Setara Kas',  'Debit',  'Neraca'],
            [1,    '02', null, null,   'BANK',              null,                 null,     null],
            [1,    '02', '01', null,   'BANK MANDIRI',      null,                 null,     null],
            [1,    '02', '01', '0001', 'BM REK_000123',     'Bank',               'Debit',  'Neraca'],
            [2,    null, null, null,   'HUTANG',            null,                 null,     null],
            [2,    '01', null, null,   'HUTANG USAHA',      null,                 null,     null],
            [2,    '01', '01', null,   'HUTANG DAGANG',     null,                 null,     null],
            [2,    '01', '01', '0001', 'HUTANG DAGANG A',   'Hutang Usaha',       'Kredit', 'Neraca'],
            [3,    null, null, null,   'MODAL',             null,                 null,     null],
            [3,    '01', null, null,   'MODAL DISETOR',     null,                 null,     null],
            [3,    '01', '01', null,   'MODAL SAHAM',       null,                 null,     null],
            [3,    '01', '01', '0001', 'SAHAM BIASA',       'Ekuitas',            'Kredit', 'Neraca'],
        ];

        // Warna per level
        $levelColors = [
            1 => 'D9E1F2',
            2 => 'E2EFDA',
            3 => 'FFF2CC',
            4 => 'FFFFFF',
        ];
        $row = 2;
        foreach ($examples as $data) {
            if (!empty($data[3])) {
                $level = 4;
            } elseif (!empty($data[2])) {
                $level = 3;
            } elseif (!empty($data[1])) {
                $level = 2;
            } else {
                $level = 1;
            }
            $sheet->fromArray($data, null, 'A' . $row);
            $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                'font'    => ['bold' => ($level == 1), 'size' => 10],
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $levelColors[$level]]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
            ]);
            $sheet->getStyle("E{$row}")->getAlignment()->setIndent($level - 1);
            $row++;
        }
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(45);
        $sheet->getColumnDimension('F')->setWidth(24);
        $sheet->getColumnDimension('G')->setWidth(14);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->freezePane('A2');

        // ── Sheet 2: Petunjuk ────────────────────────────────────
        $guide = $spreadsheet->createSheet();
        $guide->setTitle('Petunjuk');
        $guideData = [
            ['PETUNJUK PENGISIAN TEMPLATE IMPORT COA'],
            [''],
            ['Kolom',        'Keterangan',                                              'Contoh'],
            ['Header',       'Nomor kelompok utama (angka bulat)',                      '1, 2, 3'],
            ['Sub Header',   'Kode sub-kelompok 2 digit',                              '01, 02'],
            ['Group',        'Kode grup 2 digit, isi jika ada level group',            '01, 02'],
            ['Detail',       'Kode detail akun 4 digit, isi jika level terdalam',      '0001, 0002'],
            ['Nama COA',     'Nama akun — wajib diisi di semua baris',                 'NAMA AKUN'],
            ['Jenis Jurnal', 'Kategori akun untuk laporan. HANYA diisi di baris Level 4', 'Kas dan Setara Kas'],
            ['Saldo Normal', 'Debit atau Kredit. HANYA diisi di baris Level 4',         'Debit'],
            ['Post',         'Neraca atau Laba/Rugi. HANYA diisi di baris Level 4',     'Neraca'],
            [''],
            ['ATURAN LEVEL:'],
            ['Level 1 (Header)',     '→ Isi kolom Header saja, kolom lain KOSONG'],
            ['Level 2 (Sub Header)', '→ Isi Header + Sub Header, sisanya KOSONG'],
            ['Level 3 (Group)',      '→ Isi Header + Sub Header + Group, sisanya KOSONG'],
            ['Level 4 (Detail)',     '→ Isi semua kolom, termasuk Jenis Jurnal, Saldo Normal, Post'],
            [''],
            ['CONTOH KODE YANG DIHASILKAN:'],
            ['Level 1: Header=1                           → Kode: 1.0.00.00'],
            ['Level 2: Header=1, SubHeader=01             → Kode: 1.01.00.00'],
            ['Level 3: Header=1, Sub=01, Group=01         → Kode: 1.01.01.00'],
            ['Level 4: Header=1, Sub=01, Grp=01, Det=0001 → Kode: 1.01.01.0001'],
            [''],
            ['PENTING: Ketik / salin PERSIS sesuai daftar di bawah ini. Huruf besar-kecil dan spasi harus sama.'],
            ['Kalau salah ketik, kolom tetap tersimpan sebagai teks bebas dan bisa diperbaiki manual di layar preview sebelum disimpan.'],
            [''],
            ['DAFTAR PILIHAN "Saldo Normal":'],
            ['- Debit'],
            ['- Kredit'],
            [''],
            ['DAFTAR PILIHAN "Post":'],
            ['- Neraca'],
            ['- Laba/Rugi'],
            [''],
            ['DAFTAR PILIHAN "Jenis Jurnal":'],
            ['- Aset'],
            ['- Aset Lancar'],
            ['- Kas dan Setara Kas'],
            ['- Investasi'],
            ['- Investasi Jangka Panjang'],
            ['- Piutang'],
            ['- Piutang Pemegang Saham'],
            ['- Piutang Afiliasi'],
            ['- Piutang Karyawan'],
            ['- Piutang Lain-Lain'],
            ['- Piutang Pajak'],
            ['- Persediaan Barang'],
            ['- Uang Muka Pembelian'],
            ['- Pajak Dibayar Dimuka'],
            ['- Beban Dibayar Dimuka'],
            ['- Aset Tidak Lancar'],
            ['- Aset Tetap'],
            ['- Akumulasi Depresiasi'],
            ['- Aset Lain-Lain'],
            ['- Kewajiban'],
            ['- Kewajiban Lancar'],
            ['- Hutang Usaha'],
            ['- Hutang Afiliasi'],
            ['- Pendapatan Diterima Dimuka'],
            ['- Biaya yang Masih Harus Dibayar'],
            ['- Hutang Pajak'],
            ['- Hutang Bank'],
            ['- Hutang Leasing'],
            ['- Hutang Pemegang Saham'],
            ['- Hutang Karyawan'],
            ['- Hutang Lain-Lain'],
            ['- Kewajiban Tidak Lancar'],
            ['- Kewajiban Pajak Tangguhan'],
            ['- Ekuitas'],
            ['- Pendapatan'],
            ['- Retur Pendapatan'],
            ['- Potongan Pendapatan'],
            ['- Beban Pokok Pendapatan'],
            ['- Beban Pendapatan'],
            ['- Beban Administrasi & Umum'],
            ['- Pendapatan Non Operasional'],
            ['- Beban Non Operasional'],
            ['- Bank'],
            ['- Biaya Operasional'],
            ['- HPP'],
            [''],
            ['CATATAN:'],
            ['- Baris yang kolom Nama COA-nya kosong akan dilewati (skip)'],
            ['- Data duplikat (kode sama) akan dilewati otomatis'],
            ['- Hapus atau biarkan baris contoh — duplikat akan di-skip saat import'],
        ];
        foreach ($guideData as $i => $rowData) {
            $guide->fromArray($rowData, null, 'A' . ($i + 1));
        }
        $guide->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 13, 'color' => ['rgb' => '2E5F9A']],
        ]);
        $guide->getStyle('A3:C3')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E5F9A']],
        ]);
        $guide->getColumnDimension('A')->setWidth(55);
        $guide->getColumnDimension('B')->setWidth(55);
        $guide->getColumnDimension('C')->setWidth(20);

        // ── Output ───────────────────────────────────────────────
        $spreadsheet->setActiveSheetIndex(0); // pastikan Template COA yang kebuka pertama
        $filename = 'Template_Import_COA.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function importExcel($condition = null)
    {
        $accChartOfAccount = $this->AccChartOfAccounts->newEmptyEntity();
        $show = 'N';
        $rows = [];

        if ($this->request->is(['post', 'patch', 'put'])) {
            if ($condition == 'preview') {
                $file = $this->request->getData('filename');
                if (empty($file) || $file->getError() !== UPLOAD_ERR_OK) {
                    $this->Flash->error('File belum dipilih');
                    return $this->redirect($this->referer());
                }
                try {
                    $spreadsheet = IOFactory::load($file->getStream()->getMetadata('uri'));
                    $sheet = $spreadsheet->getSheetByName('Template COA');
                    if (!$sheet) {
                        foreach ($spreadsheet->getAllSheets() as $candidate) {
                            if (stripos($candidate->getTitle(), 'petunjuk') === false) {
                                $sheet = $candidate;
                                break;
                            }
                        }
                    }
                    if (!$sheet) {
                        $sheet = $spreadsheet->getSheet(0);
                    }
                    $sheetRows = $sheet->toArray();
                    // debug(count($sheetRows)); die;
                    unset($sheetRows[0]); // buang baris header
                    $previewRows = [];
                    foreach ($sheetRows as $row) {
                        $header     = trim((string)($row[0] ?? ''));
                        $subHeader  = trim((string)($row[1] ?? ''));
                        $groupCode  = trim((string)($row[2] ?? ''));
                        $detailCode = trim((string)($row[3] ?? ''));
                        $name       = trim((string)($row[4] ?? ''));

                        // Kolom baru — disimpan apa adanya (teks bebas), user koreksi manual di preview kalau typo
                        $journalType   = trim((string)($row[5] ?? ''));
                        $normalBalance = trim((string)($row[6] ?? ''));
                        $groups          = trim((string)($row[7] ?? ''));

                        if (empty($name) || empty($header)) {
                            continue; // baris kosong tidak perlu ditampilkan
                        }
                        if (!empty($detailCode)) {
                            $level = 4;
                        } elseif (!empty($groupCode)) {
                            $level = 3;
                        } elseif (!empty($subHeader)) {
                            $level = 2;
                        } else {
                            $level = 1;
                        }
                        if ($level == 1) {
                            $code             = $header . '.0.00.00';
                            $parentCode       = null;
                            $headerAccount    = $header;
                            $subHeaderAccount = '';
                        } elseif ($level == 2) {
                            $code             = $header . '.' . str_pad($subHeader, 2, '0', STR_PAD_LEFT) . '.00.00';
                            $parentCode       = $header . '.0.00.00';
                            $headerAccount    = $header;
                            $subHeaderAccount = '';
                        } elseif ($level == 3) {
                            $code             = $header . '.' . $subHeader . '.' . str_pad($groupCode, 2, '0', STR_PAD_LEFT) . '.00';
                            $parentCode       = $header . '.' . str_pad($subHeader, 2, '0', STR_PAD_LEFT) . '.00.00';
                            $headerAccount    = $header;
                            $subHeaderAccount = $header . '.' . $subHeader;
                        } else { // level 4
                            $code             = $header . '.' . $subHeader . '.' . str_pad($groupCode, 2, '0', STR_PAD_LEFT) . '.' . str_pad($detailCode, 4, '0', STR_PAD_LEFT);
                            $parentCode       = $header . '.' . $subHeader . '.' . str_pad($groupCode, 2, '0', STR_PAD_LEFT) . '.00';
                            $headerAccount    = $header;
                            $subHeaderAccount = $header . '.' . $subHeader;
                        }
                        $parent   = $parentCode ? $this->AccChartOfAccounts->find()->where(['code' => $parentCode])->first() : null;
                        $parentId = $parent->id ?? 0;
                        $isDuplicate = $this->AccChartOfAccounts->find()->where(['code' => $code])->count() > 0;
                        $previewRows[] = [
                            'header'             => $header,
                            'sub_header'         => $subHeader,
                            'group'              => $groupCode,
                            'detail'             => $detailCode,
                            'name'               => $name,
                            'level'              => $level,
                            'code'               => $code,
                            'parent_id'          => $parentId,
                            'parent_account'     => $parentCode,
                            'header_account'     => $headerAccount,
                            'sub_header_account' => $subHeaderAccount,
                            'journal_type'       => $journalType,
                            'normal_balance'     => $normalBalance,
                            'groups'               => $groups,
                            'is_duplicate'       => $isDuplicate,
                        ];
                    }
                    if (empty($previewRows)) {
                        $this->Flash->error('Tidak ada data valid pada file Excel.');
                        return $this->redirect($this->referer());
                    }
                    $rows = $previewRows;
                    $show = 'Y';
                } catch (\Exception $e) {
                    $this->Flash->error('Gagal membaca file: ' . $e->getMessage());
                    return $this->redirect($this->referer());
                }
            } elseif ($condition == 'save') {
                $rowsJson = $this->request->getData('rows_json');
                $datas = json_decode((string)$rowsJson, true);

                if (empty($datas) || !is_array($datas)) {
                    $this->Flash->error('Tidak ada data untuk disimpan.');
                    return $this->redirect(['action' => 'importExcel']);
                }
                $successCount = 0;
                $skipCount    = 0;
                foreach ($datas as $data) {
                    if (($data['published'] ?? 'N') !== 'Y') {
                        $skipCount++;
                        continue;
                    }
                    $name = trim((string)($data['name'] ?? ''));
                    $code = trim((string)($data['code'] ?? ''));
                    if (empty($name) || empty($code)) {
                        $skipCount++;
                        continue;
                    }
                    $isDuplicate = $this->AccChartOfAccounts->find()->where(['code' => $code])->count();
                    if ($isDuplicate > 0) {
                        $skipCount++;
                        continue;
                    }
                    $level = (int)($data['level'] ?? 1);
                    $entity = $this->AccChartOfAccounts->newEmptyEntity();
                    $entity = $this->AccChartOfAccounts->patchEntity($entity, [
                        'branch_id'          => 0,
                        'parent_id'          => $data['parent_id'] ?? 0,
                        'level'              => $level,
                        'parent_account'     => $data['parent_account'] ?? null,
                        'header_account'     => $data['header_account'] ?? '',
                        'sub_header_account' => $data['sub_header_account'] ?? '',
                        'code'               => $code,
                        'name'               => strtoupper($name),
                        'journal_type'       => trim((string)($data['journal_type'] ?? '')),
                        'normal_balance'     => trim((string)($data['normal_balance'] ?? '')),
                        'groups'             => trim((string)($data['groups'] ?? '')),
                        'transaction'        => ($level == 4 ? 'y' : 'n'),
                        'additional'         => 0,
                        'sub_group'          => '',
                        'sub_group_no'       => '',
                        'description'        => '',
                        'code_additional'    => '',
                        'is_create'          => $this->Authentication->getIdentity()->id,
                        'is_active'          => 'y',
                    ]);
                    $saveData['groups'] = trim((string)($data['groups'] ?? ''));

                    // debug($entity->toArray());
                    // debug($entity->get('groups'));
                    // debug($entity->get('`groups`'));
                    // die;


                    $entities[] = $entity;
                    // debug($entity->toArray()); die;
                    if ($this->AccChartOfAccounts->save($entity, $saveData)) {
                        // debug($entity->toArray()); die;
                        $successCount++;
                    } else {
                        $skipCount++;
                    }
                }
                // debug($entities); die;
                $this->Flash->success(
                    "Import berhasil. {$successCount} data disimpan, {$skipCount} baris dilewati (kosong/duplikat)."
                );
                return $this->redirect(['action' => 'index']);
            }
        }
        // Request GET (buka halaman pertama kali) -> render import_excel.php
        // debug(count($rows));
        // debug($rows[0]);
        // die;

        $this->set(compact('accChartOfAccount', 'show', 'rows'));
    }

    public function endingBalance($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $id = $this->request->getData('id') ?? $id;
            $session = $this->getRequest()->getSession();
            $dataSession = $session->read('Auth');
            $userId = $dataSession['id'];
            $accChartOfAccount = $this->AccChartOfAccounts->get($id);
            $accChartOfAccount = $this->AccChartOfAccounts->patchEntity($accChartOfAccount, [
                'is_update'     => $userId,
                'modified'      => $this->Krs->dateNow(),
                'ending_balance_bank' => $this->Krs->nom2Dec($this->request->getData('ending_balance_bank')),
                'is_log'        => $this->Krs->auditLog($this->request->getParam('controller'), $id, $userId, 'COA Ending Balance Update'),
            ]);
            // debug($accChartOfAccount);
            // die;

            if ($this->AccChartOfAccounts->save($accChartOfAccount)) {
                $this->Flash->success(__('Saldo akhir berhasil diperbarui.'));
            } else {
                $this->Flash->error(__('Gagal memperbarui saldo akhir.'));
            }
        }

        return $this->redirect($this->referer());
    }
}
