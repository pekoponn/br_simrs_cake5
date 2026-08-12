<?php
declare(strict_types=1);

namespace App\Controller\Acc;
// namespace App\Http\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash; // Memanggil fungsi Hash, untuk filter
use CakePdf\Pdf\CakePdf;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query;
// use Cake\ORM\TableRegistry;

// Call PhpOffice for Excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Http\CallbackStream;


use Cake\Http\Exception\NotFoundException;
// App::import('Controller', 'AccChartOfAccounts');
// use App\Http\Controller\AccChartOfAccountsController;

/**
 * AccJournals Controller
 *
 * @property \App\Model\Table\AccJournalsTable $accJournals
 * @method \App\Model\Entity\AccJournal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccJournalsController extends AppController
{
    

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        /*$this->paginate = [
            'contain' => ['Branches', 'Customers'],
        ];
        $accJournals = $this->paginate($this->AccJournals);

        $this->set(compact('accJournals'));*/

        $dataKeyAll = $this->request->getQueryParams();
        $getSearch = $this->request->getQuery('search');
        $getLink = $this->request->getQuery();
        //if ($this->request->is(['patch', 'post', 'put'])) {
        if ($this->request->is(['post'])) {
            $dataRow = $this->request->getData();
            // pr($dataRow);

            $dataLink = array();
            $dataWhere = array();
            $dataWhereLine = array();
            if(!empty($dataRow['filterBranch'])) {
                $dataWhere['Branches.name LIKE'] = '%'.$dataRow['filterBranch'].'%';
                $dataLink['filterBranch'] = $dataRow['filterBranch'];
            }
            if(!empty($dataRow['filterCode'])) {
                $dataWhere['AccJournals.code LIKE'] = '%'.$dataRow['filterCode'].'%';
                $dataLink['filterCode'] = $dataRow['filterCode'];                
            }
            if(!empty($dataRow['filterJournalType'])) {
                $dataWhere['AccJournals.journal_type'] = $dataRow['filterJournalType'];
                $dataLink['filterJournalType'] = $dataRow['filterJournalType'];           
            }
            if(!empty($dataRow['filterDateFrom'])) {
                $dataWhere[] = 'DATE(AccJournals.date) BETWEEN "' . $this->Krs->dateTo($dataRow['filterDateFrom']) . '" AND "' . $this->Krs->dateTo($dataRow['filterDateEnd']) . '"';
                $dataLink['filterDateFrom'] = $dataRow['filterDateFrom'];
                $dataLink['filterDateEnd'] = $dataRow['filterDateEnd'];
            }
            if(!empty($dataRow['filterCustomer'])) {
                $dataWhere['AccJournals.recipient_payer_name LIKE'] = '%'.$dataRow['filterCustomer'].'%';
                $dataLink['filterCustomer'] = $dataRow['filterCustomer'];                
            }
            if(!empty($dataRow['filterSubject'])) {
                $dataWhere['AccJournals.subject LIKE'] = '%'.$dataRow['filterSubject'].'%';
                $dataLink['filterSubject'] = $dataRow['filterSubject'];                
            }
            if(!empty($dataRow['filterDesc'])) {
                //$dataWhereLine['name'] = $dataRow['filterDesc'];
                $dataWhereLine['AccJournalLines.name LIKE'] = '%'.$dataRow['filterDesc'].'%';
                $dataLink['filterDesc'] = $dataRow['filterDesc'];                
            }
            if(!empty($dataRow['filterGrandTotal'])) {
                $dataWhere['AccJournals.grand_total'] = '%'.$dataRow['filterGrandTotal'] . '%';
                $dataLink['filterGrandTotal'] = $dataRow['filterGrandTotal'];                
            }
            if(!empty($dataRow['filterStatusPosting'])) {
                $dataWhere['AccJournals.status'] = $dataRow['filterStatusPosting'];
                $dataLink['filterStatusPosting'] = $dataRow['filterStatusPosting'];           
            }

            $dataSearchLines = $this->Krs->fEncode($dataWhereLine);
            $dataSearchs = $this->Krs->fEncode($dataWhere);
            $dataLinks = $this->Krs->fEncode($dataLink);
            return $this->redirect(['action' => 'index', '?' => ['search' => $dataSearchs, 'searchLine' => $dataSearchLines, 'link' => $dataLinks]]);
        } 

        if(!empty($getLink['link'])) {
            $dataLinks = $this->Krs->fdecode($getLink['link']);
            //pr($dataLinks);
            $dataLink['filterBranch'] = (isset($dataLinks['filterBranch'])) ? $dataLinks['filterBranch'] : "";
            $dataLink['filterCode'] = (isset($dataLinks['filterCode'])) ? $dataLinks['filterCode'] : "";
            $dataLink['filterJournalType'] = (isset($dataLinks['filterJournalType'])) ? $dataLinks['filterJournalType'] : "";
            $dataLink['filterDateFrom'] = (isset($dataLinks['filterDateFrom'])) ? $dataLinks['filterDateFrom'] : "";
            $dataLink['filterDateEnd'] = (isset($dataLinks['filterDateEnd'])) ? $dataLinks['filterDateEnd'] : "";
            $dataLink['filterCustomer'] = (isset($dataLinks['filterCustomer'])) ? $dataLinks['filterCustomer'] : "";
            $dataLink['filterDesc'] = (isset($dataLinks['filterDesc'])) ? $dataLinks['filterDesc'] : "";
            $dataLink['filterSubject'] = (isset($dataLinks['filterSubject'])) ? $dataLinks['filterSubject'] : "";
            $dataLink['filterGrandTotal'] = (isset($dataLinks['filterGrandTotal'])) ? $dataLinks['filterGrandTotal'] : "";
            $dataLink['filterStatusPosting'] = (isset($dataLinks['filterStatusPosting'])) ? $dataLinks['filterStatusPosting'] : "";
        } else {
            $dataLink['filterBranch'] = "";
            $dataLink['filterCode'] = "";
            $dataLink['filterJournalType'] = "";
            $dataLink['filterDateFrom'] = "";
            $dataLink['filterDateEnd'] = "";            
            $dataLink['filterCustomer'] = "";
            $dataLink['filterDesc'] = "";
            $dataLink['filterSubject'] = "";
            $dataLink['filterGrandTotal'] = "";
            $dataLink['filterStatusPosting'] = "";
        }        

        
         // => function(\Cake\ORM\Query $q) { return $q->where(['AccJournalLines.name LIKE ' => '%'.$dataRow['filterDesc'].'%']); }
        $dataWheres = (empty($getLink['search'])) ? "" : $this->Krs->fdecode($getLink['search']);
        $dataWhereLines = (empty($getLink['searchLine'])) ? "" : $this->Krs->fdecode($getLink['searchLine']);
        //$dataWhereLines = (empty($getLink['searchLine'])) ? array() : function(\Cake\ORM\Query $q) { return $q->where([$this->Krs->fdecode($getLink['searchLine'])])};
       // pr($dataWhereLines);
        $accJournals = $this->AccJournals->find('all')->contain(['Branches', 'AccJournalLines' => 
            (!empty($dataWhereLines)) ? function(Query $q) use ($dataWhereLines) { return $q->where([$dataWhereLines]); } : array(), 'AccJournalLines.AccChartOfAccounts']);
        $queries = (!empty($dataWheres)) ? $accJournals->where([$dataWheres]) : $accJournals;
        //'AccJournalLines.name LIKE ' => '%'.$dataWhereLines['name'].'%'
        $settings = [
            'limit' => 15,
            'order' => [
                'date' => 'desc',
                'code' => 'asc',
            ],
        ];
        
        $accJournals = $this->paginate($queries, $settings);
        
        $this->set(compact('accJournals', 'dataLink'));
        // pr($accJournals);

    }

    public function indexShort()
    {
        $dataKeyAll = $this->request->getQueryParams();
        $getSearch = $this->request->getQuery('search');
        $getLink = $this->request->getQuery();
        //if ($this->request->is(['patch', 'post', 'put'])) {
        if ($this->request->is(['post'])) {
            $dataRow = $this->request->getData();
            // pr($dataRow);

            $dataLink = array();
            $dataWhere = array();
            if(!empty($dataRow['filterBranch'])) {
                $dataWhere['Branches.name LIKE'] = '%'.$dataRow['filterBranch'].'%';
                $dataLink['filterBranch'] = $dataRow['filterBranch'];
            }
            if(!empty($dataRow['filterCode'])) {
                $dataWhere['AccJournals.code LIKE'] = '%'.$dataRow['filterCode'].'%';
                $dataLink['filterCode'] = $dataRow['filterCode'];                
            }
            if(!empty($dataRow['filterJournalType'])) {
                $dataWhere['AccJournals.journal_type'] = $dataRow['filterJournalType'];
                $dataLink['filterJournalType'] = $dataRow['filterJournalType'];           
            }
            if(!empty($dataRow['filterDateFrom'])) {
                $dataWhere[] = 'DATE(AccJournals.date) BETWEEN "' . $this->Krs->dateTo($dataRow['filterDateFrom']) . '" AND "' . $this->Krs->dateTo($dataRow['filterDateEnd']) . '"';
                $dataLink['filterDateFrom'] = $dataRow['filterDateFrom'];
                $dataLink['filterDateEnd'] = $dataRow['filterDateEnd'];
            }
            if(!empty($dataRow['filterCustomer'])) {
                $dataWhere['AccJournals.recipient_payer_name LIKE'] = '%'.$dataRow['filterCustomer'].'%';
                $dataLink['filterCustomer'] = $dataRow['filterCustomer'];                
            }
            if(!empty($dataRow['filterSubject'])) {
                $dataWhere['AccJournals.subject LIKE'] = '%'.$dataRow['filterSubject'].'%';
                $dataLink['filterSubject'] = $dataRow['filterSubject'];                
            }
             if(!empty($dataRow['filterDesc'])) {
                //$dataWhereLine['name'] = $dataRow['filterDesc'];
                $dataWhereLine['AccJournalLines.name LIKE'] = '%'.$dataRow['filterDesc'].'%';
                $dataLink['filterDesc'] = $dataRow['filterDesc'];                
            }
            if(!empty($dataRow['filterGrandTotal'])) {
                $dataWhere['AccJournals.grand_total'] = '%'.$dataRow['filterGrandTotal'] . '%';
                $dataLink['filterGrandTotal'] = $dataRow['filterGrandTotal'];                
            }
            if(!empty($dataRow['filterStatusPosting'])) {
                $dataWhere['AccJournals.status'] = $dataRow['filterStatusPosting'];
                $dataLink['filterStatusPosting'] = $dataRow['filterStatusPosting'];           
            }

            $dataSearchs = $this->Krs->fEncode($dataWhere);
            $dataLinks = $this->Krs->fEncode($dataLink);
            return $this->redirect(['action' => 'index', '?' => ['search' => $dataSearchs, 'link' => $dataLinks]]);
        } 

        if(!empty($getLink['link'])) {
            $dataLinks = $this->Krs->fdecode($getLink['link']);
            //pr($dataLinks);
            $dataLink['filterBranch'] = (isset($dataLinks['filterBranch'])) ? $dataLinks['filterBranch'] : "";
            $dataLink['filterCode'] = (isset($dataLinks['filterCode'])) ? $dataLinks['filterCode'] : "";
            $dataLink['filterJournalType'] = (isset($dataLinks['filterJournalType'])) ? $dataLinks['filterJournalType'] : "";
            $dataLink['filterDateFrom'] = (isset($dataLinks['filterDateFrom'])) ? $dataLinks['filterDateFrom'] : "";
            $dataLink['filterDateEnd'] = (isset($dataLinks['filterDateEnd'])) ? $dataLinks['filterDateEnd'] : "";
            $dataLink['filterCustomer'] = (isset($dataLinks['filterCustomer'])) ? $dataLinks['filterCustomer'] : "";
            $dataLink['filterDesc'] = (isset($dataLinks['filterDesc'])) ? $dataLinks['filterDesc'] : "";
            $dataLink['filterSubject'] = (isset($dataLinks['filterSubject'])) ? $dataLinks['filterSubject'] : "";
            $dataLink['filterGrandTotal'] = (isset($dataLinks['filterGrandTotal'])) ? $dataLinks['filterGrandTotal'] : "";
            $dataLink['filterStatusPosting'] = (isset($dataLinks['filterStatusPosting'])) ? $dataLinks['filterStatusPosting'] : "";
        } else {
            $dataLink['filterBranch'] = "";
            $dataLink['filterCode'] = "";
            $dataLink['filterJournalType'] = "";
            $dataLink['filterDateFrom'] = "";
            $dataLink['filterDateEnd'] = "";            
            $dataLink['filterCustomer'] = "";
            $dataLink['filterDesc'] = "";
            $dataLink['filterSubject'] = "";
            $dataLink['filterGrandTotal'] = "";
            $dataLink['filterStatusPosting'] = "";
        }        

        $accJournals = $this->AccJournals->find('all')->contain(['Branches', 'AccJournalLines', 'AccJournalLines.AccChartOfAccounts']);

        $dataWheres = (empty($getLink['search'])) ? "" : $this->Krs->fdecode($getLink['search']);

        $queries = (!empty($dataWheres)) ? $accJournals->where([$dataWheres]) : $accJournals;

        $settings = [
            'limit' => 15,
            'order' => [
                'date' => 'desc',
                'code' => 'asc',
            ],
        ];
        
        $accJournals = $this->paginate($queries, $settings);
        
        $this->set(compact('accJournals', 'dataLink'));
    }


    
    /**
     * View method
     *
     * @param string|null $id Acc Journal id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accJournal = $this->AccJournals->get($id, [
            'contain' => ['Branches', 'Customers', 'RecipientPayers', 'AccJournalLines'],
        ]);

        $this->set(compact('accJournal'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accJournal = $this->AccJournals->newEmptyEntity();
        if ($this->request->is('post')) {
            $accJournal = $this->AccJournals->patchEntity($accJournal, $this->request->getData());
            if ($this->AccJournals->save($accJournal)) {
                $this->Flash->success(__('The acc journal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc journal could not be saved. Please, try again.'));
        }
        $branches = $this->AccJournals->Branches->find('list', ['limit' => 200]);
        //$journalSubs = $this->AccJournals->JournalSubs->find('list', ['limit' => 200]);
        $customers = $this->AccJournals->Customers->find('list', ['limit' => 200]);
        $recipientPayers = $this->AccJournals->RecipientPayers->find('list', ['limit' => 200]);
        $this->set(compact('accJournal', 'branches', 'customers', 'recipientPayers'));
    }

    public function addMany()
    {
        
        $this->loadModel('AccJournalLines');

        $accJournal = $this->AccJournals->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['user_id'];
            $rowDateJournal = (empty($dataRow['date_journal']))? NULL:$this->Krs->dateTo($dataRow['date_journal']);
            $rowBranchId = $dataRow['branch_id'];

            $dataBranchId = array('branch_id' => $rowBranchId);
            $dataUserId = array('is_create' => $isUser);
            $dataCode = array('code' => $dataRow['codes']);
            $dataRecipientPayerName = array('recipient_payer_name' => $dataRow['recipient_payer_name']);

            $dataFrom = array('came_from' => 'Journal');
            $dataSubject = array('subject' => $dataRow['subject']);
            // $dataCekBg = array('cek_bg' => $dataRow['cek_bg']);
            // $dataNoRef = array('no_ref' => $dataRow['no_ref']);
            $dataJournalType = array('journal_type' => $dataRow['journal_type']);           
            $dataDate = array('date' => $rowDateJournal);
            $dataJournalSubId = array('journal_sub_id' => 0);

            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add"); 
            $dataAuditLog = array('is_log' => $auditLog);

            $checkCode = $this->AccJournals->checkCode(1, $dataRow["codes"], $dataRow['journal_type']);
            if($checkCode<1) {
                $session = $this->request->getSession();
                $session = $this->request->getAttribute('session');

                $dataSessionCart = $session->read('JurnalCart');

                if(!empty($dataSessionCart)) {
                    $cartBox = "";
                    $dkArray = array("D"=>"Debit", "C"=>"Kredit");
                    $cartDebetAmount = array();
                    $c = 0;
                    $dataLine = array();
                    foreach ($dataSessionCart as $cartId => $dataCarts) {
                        $encodeCart = base64_decode(urldecode(base64_decode($dataCarts)));
                        $decodeCart = json_decode($encodeCart, true);

                        $decodeCarts = Hash::combine($decodeCart, '{n}.name', '{n}.value');
                        $dataCarts = array_splice($decodeCarts, 8);

                        $dataCart = array();
                        foreach ($dataCarts as $keyCart => $valueCart) {
                            $filterKeywordReplace1 = str_replace( array( '[' ), '.', $keyCart);
                            $filterKeywordReplace2 = str_replace( array( ']' ), '', $filterKeywordReplace1);
                            
                            list($nameCart, $field, $number) = explode(".", $filterKeywordReplace2);
                            
                            $dataCart[$cartId.$number]['noCart'] = $number;
                            $dataCart[$cartId.$number]['idCart'] = $cartId;
                            $dataCart[$cartId.$number][$field] = $valueCart;
                        }

                                                
                        //pr($decodeCart);
                        //$a = 0;
                        
                        foreach ($dataCart as $cartValue) {
                            $noCart = (isset($cartValue['noCart'])) ? $cartValue['noCart'] : "";
                            $idCart = (isset($cartValue['idCart'])) ? $cartValue['idCart'] : "";
                            $dcStatus = (isset($cartValue['dc_status'])) ? $cartValue['dc_status'] : "";

                            $debetAmount = (isset($cartValue['debet_amount'])) ? $this->Krs->nom2Dec($cartValue['debet_amount']) : "";
                            $creditAmount = (isset($cartValue['credit_amount'])) ? $this->Krs->nom2Dec($cartValue['credit_amount']) : "";
                            $ledgerId = (isset($cartValue['ledger_id'])) ? $cartValue['ledger_id'] : "";
                                
                            if(!empty($ledgerId)) {
                                list($coaId, $coaCode, $coaHeaderCode, $coaSubHeaderCode, $coaGroup, $coaName) = explode("^", $ledgerId);
                            } else {
                                $coaName = '';
                            }

                            $showDCStatus = (empty($dcStatus)) ? '' : $dkArray[$dcStatus];
                            $showDesc = (empty($cartValue['desc'])) ? '' : $cartValue['desc'];
                            $auditLogLine = $this->Krs->auditLog('AccJournalLines', 'N',  $isUser, "Add"); 
                            // $dataAuditLogLine = array('is_log' => $auditLogLine);

                            $dataLine[$c]['branch_id'] = $rowBranchId;
                            $dataLine[$c]['journal_sub_id'] = 0;
                            $dataLine[$c]['is_create'] = $isUser;
                            $dataLine[$c]['ledger_dc'] = $dcStatus;
                            $dataLine[$c]['acc_chart_of_account_id'] = $coaId;
                            $dataLine[$c]['name'] = $showDesc;
                            $dataLine[$c]['position'] = $c;
                            $dataLine[$c]['debet'] = $debetAmount;
                            $dataLine[$c]['credit'] = $creditAmount;
                            $dataLine[$c]['is_log'] = $auditLogLine;

                            $cartDebetAmount[] = $debetAmount;
                            $c++;
                        }
                        //$b++;
                    }

                    $totalDebetAccount = array_sum($cartDebetAmount);

                    $dataGrandTotal = array('grand_total' => $totalDebetAccount);
                    //, $dataCekBg, $dataNoRef
                    $accJournal = $this->AccJournals->patchEntity($accJournal, array_merge($dataBranchId, $dataCode, $dataSubject, $dataFrom, $dataUserId, $dataJournalType, $dataDate, $dataJournalSubId, $dataRecipientPayerName, $dataGrandTotal, $dataAuditLog));

                    // pr($accJournalLine);
                    if ($this->AccJournals->save($accJournal)) {

                        $accJournalId = $accJournal->id;

                        $dataLine = Hash::insert($dataLine, '{n}.acc_journal_id', $accJournalId);
                        $accJournalLine = $this->AccJournalLines->newEntities($dataLine);
                       
                        // $accJournalLine = Hash::insert($accJournalLine, '{n}', ['acc_journal_id'=>$accJournalId]);

                        $accJournalLineResult = $this->AccJournalLines->saveMany($accJournalLine, array('deep'=>false, 'validate'=>false, 'atomic' => false));

                        $session->delete('JurnalCart');
                        //pr($accJournalLine);
                        $this->Flash->success(__('Data berhasil disimpan.'));

                        return $this->redirect(['action' => 'addMany']);
                    }
                    $this->Flash->error(__('The acc journal could not be saved. Please, try again.'));
                }
            }

            


            /*$accJournal = $this->AccJournals->patchEntity($accJournal, $this->request->getData());
            if ($this->AccJournals->save($accJournal)) {
                $this->Flash->success(__('The acc journal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc journal could not be saved. Please, try again.'));*/
        }
        //Call for Branch
        // $data['getListBranch'] = $this->Krs->getDataBranch();

        // // Call for Chart Of Account
        // $data['rowAccount'] = $this->Krs->datarowCOA();

        // // Call for number.
        // $data['maxNumber'] = $this->Krs->getMaxCodeJournal("AccJournal", "Memorial");
        $data['maxNumber'] = $this->AccJournals->getMax('Memorial');
        $this->loadModel('RecipientPayers');
        $this->loadModel('Customers');

        $data['getListBranch'] = $this->AccJournals->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['is_active' => 'Y'])->toArray();
        // $rowRecipientPayers = $this->RecipientPayers->find('list', ['keyField' => 'name', 'valueField' => 'name'])->where(['is_active' => 'Y'])->toArray();
        // $rowCustomers = $this->Customers->find('list', ['keyField' => 'name_invoice', 'valueField' => 'name_invoice'])->where(['is_active' => 'Y'])->toArray();
        // $dataRowRecipientPayer = array_merge($rowRecipientPayers, $rowCustomers);

        // pr($rowCustomers);
        //, 'dataRowRecipientPayer'

        $this->set(compact('accJournal', 'data'));

    }

    public function editMany($id)
    {
        
        $this->loadModel('AccJournalLines');
        $this->loadModel('AccChartOfAccounts');
        $this->loadModel('RecipientPayers');
        // $this->loadModel('Customers');

        $accJournal = $this->AccJournals->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

        //$accJournal = $this->AccJournals->newEmptyEntity();
        // if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            // pr($dataRow);
            $isUser = $dataRow['user_id'];
            $rowDateJournal = (empty($dataRow['date_journal']))? NULL:$this->Krs->dateTo($dataRow['date_journal']);

            $dataBranchId = array('branch_id' => $dataRow['branch_id']);
            $dataUserId = array('is_create' => $isUser);
            
            // $dataCekBg = array('cek_bg' => $dataRow['cek_bg']);
            // $dataNoRef = array('no_ref' => $dataRow['no_ref']);
            $dataRecipientPayerName = array('recipient_payer_name' => $dataRow['recipient_payer_name']);
            $dataSubject = array('subject' => $dataRow['subject']);
            $dataJournalType = array('journal_type' => $dataRow['journal_type']);

            if($rowDateJournal==$dataRow['date_journal_old']) {
                $dataCodeRevision = array();
                $dataCodes = $dataRow['codes'];
            } else {
                $dataCodeRevision = array('code_revision'=> (!empty($dataRow['code_revisions'])) ? implode(', ', array($dataRow['code_revisions'], $dataRow['codes'])) : $dataRow['codes']);

                // getMax $this->AccJournals->getMax('Memorial')
                $yymmdd = substr(str_replace("-", "", $rowDateJournal), 2, 6);
                // pr($yymmdd);
                $dataCodes = $this->AccJournals->getMax($dataRow['journal_type'], $yymmdd);
            }
            $dataCode = array('code' => $dataCodes);
            
            $dataDate = array('date' => $rowDateJournal);
            $dataGrandTotal = array('grand_total' => $dataRow['totalLine']);          

            //$dataJournalSubId = array('journal_sub_id' => 0);

            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Edit Many"); 
            $dataAuditLog = array('is_log' => $auditLog);

            $accJournal = $this->AccJournals->patchEntity($accJournal, array_merge($dataBranchId, $dataCode, $dataUserId, $dataJournalType, $dataDate, $dataSubject, $dataRecipientPayerName, $dataCodeRevision, $dataGrandTotal, $dataAuditLog));

            // pr($accJournal);
            if ($this->AccJournals->save($accJournal)) {

                // $accJournalId = $accJournal->id;

                // $dataLine = Hash::insert($dataLine, '{n}.acc_journal_id', $accJournalId);
                // $accJournalLine = $this->AccJournalLines->newEntities($dataLine);

                // $accJournalLineResult = $this->AccJournalLines->saveMany($accJournalLine, array('deep'=>false, 'validate'=>false, 'atomic' => false));

                // $session->delete('JurnalCart');
                //pr($accJournalLine);
                $this->Flash->success(__('Data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf, data gagal disimpan. Silakan, coba kembali.'));
            //     }
            // }
        }
        //Call for Branch
        // $data['getListBranch'] = $this->Krs->getDataBranch();

        // // Call for Chart Of Account
        // $data['rowAccount'] = $this->Krs->datarowCOA();

        // // Call for number.
        // $data['maxNumber'] = $this->Krs->getMaxCodeJournal("AccJournal", "Memorial");
        $data['maxNumber'] = $this->AccJournals->getMax('Memorial');

        // $accCoas = TableRegistry::getTableLocator()->get('AccChartOfAccounts');
        // $accCoasObj = new AccChartOfAccounts;
        // $accCoasObj = TableRegistry::get('AccChartOfAccounts');
        // $accCoasObj->constructClasses();
        $data['rowCOA'] = $this->AccChartOfAccounts->getCoaData();

        // pr($this->AccJournalLines->AccChartOfAccounts->getCoa());
        // $accCoas = TableRegistry::get('AccChartOfAccounts');
        //$accCoas = TableRegistry::get('AccChartOfAccounts');
        // pr($accCoas->getCoa());

        // $data['rowCOA'] = Set::combine($this->AccChartOfAccounts->getCoa(), '{n}.AccChartOfAccount.id', array('({0}) {1}', '{n}.AccChartOfAccount.code', '{n}.AccChartOfAccount.customer_name'));
        

        $data['getListBranch'] = $this->AccJournals->Branches->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['is_active' => 'Y'])->toArray();
        // $rowRecipientPayers = $this->RecipientPayers->find('list', ['keyField' => 'name', 'valueField' => 'name'])->where(['is_active' => 'Y'])->toArray();
        // $rowCustomers = $this->Customers->find('list', ['keyField' => 'name_invoice', 'valueField' => 'name_invoice'])->where(['is_active' => 'Y'])->toArray();
        // $dataRowRecipientPayer = array_merge($rowRecipientPayers, $rowCustomers);
        //, 'dataRowRecipientPayer'
        $this->set(compact('accJournal', 'data'));

    }

    public function postingSave() {
        // $pages = (empty($this->params['named']['page'])) ? '' : '/page:'.$this->params['named']['page'];
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $userId = $dataRow['user_id'];
            // pr($dataRow);
            // $decodeCarts = Hash::combine($decodeCart, '{n}.name', '{n}.value');

            $dataGridCek = Hash::combine($dataRow['dataGrid'], '{n}.journalId', '{n}.cek');
            if(!empty($dataGridCek)) {
                $countData = array_count_values($dataGridCek);
                $dataYes = (empty($countData['y'])) ? 0 : $countData['y'];
                
                if($dataYes>0) {
                    $dataDate = (!empty($dataRow['date_journals'])) ? $this->Krs->dateTo($dataRow['date_journals']) : '';

                    foreach ($dataGridCek as $journalMemorialId => $journalMemorialCek) {
                        if($journalMemorialCek=='y') {
                            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $journalMemorialId, $userId, "Posting"); 

                            //$dataGrid = $dataRow['dataGrid'];
                            //$dataJournalPosting = $dataGrid[$journalMemorialId];
                            // pr($journalMemorialId);
                            // pr($dataDate);
                            // pr($auditLog);
                            $this->AccJournals->updateAll(['status' => 'posting', 'date_posting' => $dataDate, 'is_log' => $auditLog], ['id' => $journalMemorialId]);

                            // $this->AccJournal->updateAll(array("AccJournal.status" => "'posting'", "AccJournal.date_posting" => "'".$dataDate."'"), array("AccJournal.id" =>$dataJournalPosting['journalId']), -1);
                        }                   
                    }

                    $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                    return $this->redirect($this->referer());
                    // pr($dataGridCek);
                    // pr($dataRow);
                } else {
                    $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
        // $this->set(compact('pettyCash'));
        /*if ($this->request->is('post') || $this->request->is('put')) {
            $accJournal = $this->request->data['accJournal'];
            
            $dataGridCek = Set::combine($accJournal['dataGrid'], '{n}.journalId', '{n}.cek');
            
            // pr($dataGridCek);
            
            if(!empty($dataGridCek)) {
                $countData = array_count_values($dataGridCek);
                $dataYes = (empty($countData['y'])) ? 0 : $countData['y'];
                
                if($dataYes>0) {
                    // $this->loadModel('accJournal');
                    // $this->loadModel('AccJournalLine');

                    // pr($dataGridCek);

                    $dataDate = (!empty($accJournal['date_journal'])) ? $this->Krs->_convertDate($accJournal['date_journal']) : '';
                    
                    // $dataJournal = array();
                    // $a = 0;
                    foreach ($dataGridCek as $journalMemorialId => $journalMemorialCek) {
                        if($journalMemorialCek=='y') {
                            $dataGrid = $accJournal['dataGrid'];
                            $dataJournalPosting = $dataGrid[$journalMemorialId];

                            $this->AccJournal->updateAll(array("AccJournal.status" => "'posting'", "AccJournal.date_posting" => "'".$dataDate."'"), array("AccJournal.id" =>$dataJournalPosting['journalId']), -1);
                        }                   
                    }

                    $this->Krs->setFlash('Data berhasil di-Posting.', 'success');
                    $this->redirect(array('event_id' => $this->uuid, 'controller' => 'acc_journals', 'action' => 'index'.$pages));
                } else {
                    $this->Krs->setFlash('Data tidak disimpan. Silakan masukkan data dengan benar!', 'error');
                }
            } else {
                $this->Krs->setFlash('Data gagal disimpan. Silakan masukkan data dengan benar!', 'error');
            }
        } else {
            $this->Krs->setFlash('Data gagal disimpan. Silakan masukkan data dengan benar!', 'error');
        }*/
    }

    public function generalLedgerReport() {
        $accJournal = $this->AccJournals->newEmptyEntity();
        $this->loadModel('RecipientPayers');
        // $this->loadModel('Customers');
        
        $dataLink = array();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            // pr($dataRow);
            
            $dataWhere = array();
            $dataLink['filterCheckShow'] = $dataRow['filterCheckShow'];

            if(!empty($dataRow['filterLedgerMulti']) && empty($dataRow['filterLedgerGroupMulti'])) {
                // debug($dataRow['filterLedgerGroupMulti']);
                // die;
                $coaMultiId = array();
                foreach ($dataRow['filterLedgerMulti'] as $keyCoaMulti => $valueCoaMulti) {
                    $coaMultiData = explode('^', $valueCoaMulti);
                    $coaMultiId[$keyCoaMulti] = $coaMultiData[0];
                }
                $coaMultiIds = implode(",", $coaMultiId);
                // $dataWhere['AccJournalLines.acc_chart_of_account_id IN'] = $coaMultiIds;
                //$condCoaMultiId = 'AccJournalLines.acc_chart_of_account_id IN ('.$coaMultiIds.')';
                $dataWhere[] = 'AccJournalLines.acc_chart_of_account_id IN ('.$coaMultiIds.')';

                $dataLink['filterLedgerMulti'] = $dataRow['filterLedgerMulti'];
                $data['dateTitle'] = '';
            } elseif(empty($dataRow['filterLedgerMulti']) && !empty($dataRow['filterLedgerGroupMulti'])) {
                $value = $this->Krs->fDecode($dataRow['filterLedgerGroupMulti']);
                // list($coaId, $coaCode, $coaHeaderAccount, $coaSubHeaderAccount, $coaGroup, $coaName) = explode('^', $dataRow['filterLedgerGroupMulti']);
                list($coaId, $coaCode, $coaHeaderAccount, $coaSubHeaderAccount, $coaGroup, $coaName) = explode('^', $value);

                $this->loadModel('AccChartOfAccounts');
                $queryCoa = $this->AccChartOfAccounts->find()
                    ->select(['AccChartOfAccounts.id', 'AccChartOfAccounts.code'])
                    ->where(['AccChartOfAccounts.parent_id'=>$coaId])
                    ->order(['AccChartOfAccounts.lft' => 'ASC'])->toArray();
                // $coaMultiIds = Hash::extract($queryCoa, '{n}.id');
                // $coaMultiId = implode(",", $coaMultiIds);
                $coaMultiIds = Hash::extract($queryCoa, '{n}.id');
                if(empty($coaMultiIds)){ $coaMultiIds = [$coaId];}
                $coaMultiId = implode(",", $coaMultiIds);    
                // pr($coaMultiIds);
                $dataLink['filterLedgerGroupMulti'] = $dataRow['filterLedgerGroupMulti'];
                $dataWhere[] = 'AccJournalLines.acc_chart_of_account_id IN ('.$coaMultiId.')';
                $data['dateTitle'] = '';
            } else {
                $condCoaMultiId = '';
                $dataWhereLdgerMulti = '';
                $data['dateTitle'] = '';
                $dataLink['filterLedgerMulti'] = '';
                $dataLink['filterLedgerGroupMulti'] = '';
            }

            if(!empty($dataRow['filterRecipientPayerName'])) {
                $dataWhere[] = 'AccJournals.recipient_payer_name LIKE "%'.$dataRow['filterRecipientPayerName'].'%"';

                $dataLink['filterRecipientPayerName'] = $dataRow['filterRecipientPayerName'];
                $data['dateTitle'] = '';
            } else {
                $dataLink['filterRecipientPayerName'] = '';
                $data['dateTitle'] = '';
            }

            //$filterLedgerFrom = (empty($accJournalLedgerFrom)) ? array() : array("CAST(REPLACE(AccChartOfAccount.code,'.','') as SIGNED INTEGER)>="=> $accJournalLedgerFrom);
            //$filterLedgerEnd = (empty($accJournalLedgerEnd)) ? array() : array("CAST(REPLACE(AccChartOfAccount.code,'.','') as SIGNED INTEGER)<=" => $accJournalLedgerEnd);
            //CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups,'^',IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name)))

            if(!empty($dataRow['filterLedgerStart'])) {
                list($coaLSId, $coaLSCode, $coaLSHeader, $coaLSSubHeader, $coaLSGroup, $coaLSName) = explode('^', $dataRow['filterLedgerStart']);
                $dataWhere[] = "CAST(REPLACE(AccChartOfAccounts.code,'.','') as SIGNED INTEGER) >= '".str_replace('.','',$coaLSCode)."'";

                // $dataWhere['AccJournalLines.acc_chart_of_account_id'] = $coaLedgerFrom;
                $dataLink['filterLedgerStart'] = $dataRow['filterLedgerStart'];
                $data['dateTitle'] = '';
            }

            if(!empty($dataRow['filterLedgerEnd'])) {
                list($coaLEId, $coaLECode, $coaLEHeader, $coaLESubHeader, $coaLEGroup, $coaLEName) = explode('^', $dataRow['filterLedgerEnd']);
                $dataWhere[] = "CAST(REPLACE(AccChartOfAccounts.code,'.','') as SIGNED INTEGER) <= '".str_replace('.','',$coaLECode)."'";
                // $dataWhere['AccJournalLines.acc_chart_of_account_id'] = $coaLedgerEnd;
                $dataLink['filterLedgerEnd'] = $dataRow['filterLedgerEnd'];
                $data['dateTitle'] = '';
            }

            if(!empty($dataRow['filterMYDate'])) {
                $dataWhere[] = 'DATE_FORMAT(AccJournals.date,"%Y-%m") <= "'.$this->Krs->monthYearTo($dataRow['filterMYDate']).'"';

                // $dataWheres['DATE_FORMAT(AccJournals.date,"%Y-%m")'] = $this->Krs->monthYearTo($dataRow['filterMYDate']);
                $dataLink['filterMYDate'] = $dataRow['filterMYDate'];
                $data['dateTitle'] = $this->Krs->monthYearTo($dataRow['filterMYDate']);
            } elseif(!empty($dataRow['filterDateFrom'])) {
                $filterDateFroms = $this->Krs->dateTo($dataRow['filterDateFrom']);
                $filterDateEnds = $this->Krs->dateTo($dataRow['filterDateEnd']);

                $dataWhere[] = 'DATE(AccJournals.date) BETWEEN "' . $filterDateFroms . '" AND "' . $filterDateEnds . '"';
                $dataLink['filterDateFrom'] = $dataRow['filterDateFrom'];
                $dataLink['filterDateEnd'] = $dataRow['filterDateEnd'];
                // pr($filterDateFroms);
                // $data['dateTitle'] = '';
                
                $data['dateTitle'] = $this->Krs->fDate($filterDateFroms, 'd M Y').' Sampai '.$this->Krs->fDate($filterDateEnds, 'd M Y');
                // $data['dateTitle'] = date_format(date_create($filterDateFroms), 'd M Y').' Sampai '.date_format(date_create($filterDateEnds), 'd M Y');
            } else {
                $dataWheres = array();
            }

            //pr($dataWhere);
            

            // pr(implode(' AND ', $dataWhere));
            $this->loadModel('AccJournalLines');
            //, 'accJournalLineDebet' => 'FORMAT(AccJournalLines.debet, 2, "de_DE")', 'accJournalLineCredit' => 'FORMAT(AccJournalLines.credit, 2, "de_DE")'
            $dataRows = $this->AccJournalLines->find()
            ->select(['AccJournalLines.id', 'AccJournalLines.acc_chart_of_account_id', 'AccJournalLines.ledger_dc', 'AccJournalLines.name', 'AccJournalLines.debet', 'AccJournalLines.credit'])
            ->where([$dataWhere])
            ->order(['AccChartOfAccounts.code' => 'ASC', 'AccJournals.code' => 'ASC', 'AccJournals.date' => 'ASC', 'AccJournalLines.id' => 'ASC'])
            //-->orders' => ['coaGroupName' => 'ASC']
            // ->limit(600)
            ->contain([
                'Branches' => [
                    'fields' => [
                       'Branches.id', 'Branches.code', 'Branches.name'
                    ],
                ],
                'AccJournals' => ['AccJournalLines',
                    'fields' => [
                       'AccJournals.id', 'AccJournals.branch_id', 'AccJournals.journal_sub_id', 'AccJournals.code', 'AccJournals.journal_type', 'AccJournals.name', 'accJournalDate' => 'DATE_FORMAT(AccJournals.date, "%d %b %Y")', 'AccJournals.date_posting', 'AccJournals.grand_total', 'AccJournals.balance', 'AccJournals.recipient_payer_name'
                    ],
                    // 'where' => [$dataWheres]
                ],
                'AccChartOfAccounts' => ['Customers',
                    'fields' => [
                       'AccChartOfAccounts.beginning_balance', 'AccChartOfAccounts.beginning_balance_debet', 'AccChartOfAccounts.beginning_balance_credit', 'AccChartOfAccounts.id', 'AccChartOfAccounts.code', 'AccChartOfAccounts.name', 'AccChartOfAccounts.groups', 'AccChartOfAccounts.type', 'AccChartOfAccounts.journal_type', 'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name))"
                    ],
                    // 'order' => ['coaGroupName' => 'ASC']
                    // 'contain' => ['Customers']
                    // 'where' => [$dataWheres]
                ], 
                //'Customers'
            ])->toArray();

            // pr($dataRows);

            $rowData = array();
            foreach ($dataRows as $dataRow) {
                $accCoa = $dataRow['acc_chart_of_account'];
                $accJournal = $dataRow['acc_journal'];
                $accBranch = $dataRow['branch'];
                $accJournalLine = $accJournal['acc_journal_lines'];

                $coaJournalLine = Hash::extract($accJournalLine, '{n}.acc_chart_of_account_id');
                $coaLineId = $dataRow['acc_chart_of_account_id'];
                $coaLineLawan = implode(',', array_diff($coaJournalLine, [$coaLineId]));
                // pr($dataRow['acc_chart_of_account_id']);

                // pr(Hash::remove($coaJournalLine, '{n}[3567]'));
                // pr(array_diff($coaJournalLine, ['3567'] ));
                // pr(implode(',', array_diff($coaJournalLine, [$coaLineId])));
                // $del_val = 
                // if (($key = array_search($del_val, $messages)) !== false) {
                //     unset($messages[$key]);
                // }

                // pr(Hash::remove(Hash::extract($accJournalLine, '{n}.acc_chart_of_account_id'), '{n}['.$accCoa['acc_chart_of_account_id'].']'));

                // pr()    
                $dataRowId = str_replace('.','',$accCoa['code']);
                $totalBeginningBalance = $accCoa['beginning_balance_debet']-$accCoa['beginning_balance_credit'];
                
                $rowData[$dataRowId]['title'] = $accCoa['code'].'^'.$accCoa['name'].'^'.$dataRow['coaGroupName'].'^'.$totalBeginningBalance.'^'.$accCoa['groups'].'^'.$accCoa['journal_type'];
                // $rowData[$dataRowId]['recipient'][$dataRow['id']] = $accJournal['recipient_payer_name'];
                $rowData[$dataRowId]['data'][$dataRow['id']] = $accBranch['name'].'^'.$dataRow['id'].'^'.$accJournal['code'].'^'.$dataRow['accJournalDate'].'^'.$dataRow['name'].'^'.$dataRow['ledger_dc'].'^'.$dataRow['debet'].'^'.$dataRow['credit'].'^'.$accJournal['recipient_payer_name'].'^'.$coaLineLawan;
                //['%s^%s^%s^%s^%s^%s', '{n}.acc_chart_of_account.code', '{n}.acc_chart_of_account.name', '{n}.coaGroupName', '{n}.acc_chart_of_account.beginning_balance', '{n}.acc_chart_of_account.groups', '{n}.acc_chart_of_account.journal_type']);
            }
            ksort($rowData);
            // pr($rowData);

            //pr($dataRows->all());
            // pr($dataRows);
        } else {
            $rowData = '';
            $data = '';
        }


        /*
        230728
        $rowRecipientPayers = $this->RecipientPayers->find('list', ['keyField' => 'name', 'valueField' => 'name'])->where(['is_active' => 'Y'])->toArray();
        $rowCustomers = $this->Customers->find('list', ['keyField' => 'name_invoice', 'valueField' => 'name_invoice'])->where(['is_active' => 'Y'])->toArray();
        $dataRowRecipientPayer = array_merge($rowRecipientPayers, $rowCustomers);*/
         $dataRowRecipientPayer = array();
        // $dataLinks = $this->Krs->fEncode($dataLink);

        $this->set(compact('accJournal', 'rowData', 'data', 'dataRowRecipientPayer', 'dataLink'));
            /*cara terakhir $db = ConnectionManager::get('default');
        
            $dataRows = $db->execute("SELECT AccJournals.id, AccJournals.branch_id, AccJournals.journal_sub_id, AccJournals.code, AccJournals.journal_type, AccJournals.name, AccJournals.date, AccJournals.date_posting, AccJournals.grand_total, AccJournals.balance, AccJournalLines.id, AccJournalLines.acc_chart_of_account_id, AccJournalLines.ledger_dc, AccJournalLines.name, AccJournalLines.debet, AccJournalLines.credit, AccChartOfAccounts.beginning_balance, AccChartOfAccounts.id, AccChartOfAccounts.code, AccChartOfAccounts.name, AccChartOfAccounts.groups, AccChartOfAccounts.type, AccChartOfAccounts.journal_type, IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name)) AS coaGroupName FROM acc_journal_lines AccJournalLines INNER JOIN acc_journals AccJournals ON AccJournals.id = (AccJournalLines.acc_journal_id) LEFT JOIN acc_chart_of_accounts AccChartOfAccounts ON AccChartOfAccounts.id = (AccJournalLines.acc_chart_of_account_id) LEFT JOIN customers Customers ON Customers.id = (AccChartOfAccounts.customer_id) WHERE $condCoaMultiId LIMIT 10")->fetchAll('assoc');*/
            //->select(['AccJournals.id', 'AccJournals.branch_id', 'AccJournals.journal_sub_id', 'AccJournals.code', 'AccJournals.journal_type', 'AccJournals.name', 'AccJournals.date', 'AccJournals.date_posting', 'AccJournals.grand_total', 'AccJournals.balance', 'AccJournalLines.id', 'AccJournalLines.acc_chart_of_account_id', 'AccJournalLines.ledger_dc', 'AccJournalLines.name', 'AccJournalLines.debet', 'AccJournalLines.credit', 'AccChartOfAccounts.beginning_balance', 'AccChartOfAccounts.id', 'AccChartOfAccounts.code', 'AccChartOfAccounts.name', 'AccChartOfAccounts.group', 'AccChartOfAccounts.type', 'AccChartOfAccounts.journal_type'])
            
            //->order(['AccChartOfAccounts.code' => 'ASC', 'AccJournals.code' => 'ASC', 'AccJournals.date' => 'ASC', 'AccJournalLines.id' => 'ASC'])
            
            //'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name))"
            //'contain' => ['Bids' => ['Users' => ['Drivers']]]

            /*foreach ($dataRows as $haaa) {
                pr($haaa);
            }*/
            // ->contain(['Customers']);
            //->select(['codes' => 'MAX(CAST(SUBSTR(AccJournals.code, 7) AS UNSIGNED))+1'])
            // debug($dataRows);
            // foreach ($dataRows->all() as $row) {
            // debug($row);
            // }
            
            // pr($dataRows);
            /*$data['rows'] = $this->AccJournal->AccJournalLine->find('all', array(
                            'fields' => array('AccJournals.id', 'AccJournals.branch_id', 'AccJournals.journal_sub_id', 'AccJournals.code', 'AccJournals.journal_type', 'AccJournals.name', 'AccJournals.date', 'AccJournals.date_posting', 'AccJournals.grand_total', 'AccJournals.balance', 'AccJournalLine.id', 'AccJournalLine.acc_chart_of_account_id', 'AccJournalLine.ledger_dc', 'AccJournalLine.name', 'AccJournalLine.debet', 'AccJournalLine.credit', 'AccChartOfAccount.beginning_balance', 'AccChartOfAccount.id', 'AccChartOfAccount.code', 'AccChartOfAccount.name', 'AccChartOfAccount.group', 'AccChartOfAccount.type', 'AccChartOfAccount.journal_type', 'CustomerCoa.title', 'CustomerCoa.name'),
                            'conditions' => array($filterCondition),
                            'order' => array('AccChartOfAccount.code' => 'asc', 'AccJournals.code' => 'asc', 'AccJournals.date' => 'asc', 'AccJournalLine.id' => 'asc'),
                            'recursive' => 1
                        ));*/



        /*if ($this->request->is('post')) {
            $accJournal = $this->request->data['accJournal'];
            $dateFrom = $this->Krs->_convertDate($accJournal['filterDateFrom']);
            $dateTo = $this->Krs->_convertDate($accJournal['filterDateEnd']);

            if (($dateFrom!="" && $dateTo!="") || ($dateFrom!="" && $dateTo=="")) {

                //$filterBranch = (empty($accJournal['filterBranch'])) ? array() : array('AccJournals.branch_id' => $accJournal['filterBranch']);
                $filterDate = (empty($dateFrom) && empty($dateTo)) ? array() : array('AccJournals.date BETWEEN ? AND ?' => array($dateFrom, $dateTo));
                $filterCondition = array_merge($filterDate);

            
                $data['rows'] = $this->AccJournal->AccJournalLine->find('all', array(
                            'fields' => array('AccJournals.id', 'AccJournals.branch_id', 'AccJournals.journal_sub_id', 'AccJournals.code', 'AccJournals.journal_type', 'AccJournals.name', 'AccJournals.date', 'AccJournals.date_posting', 'AccJournals.grand_total', 'AccJournals.balance', 'AccJournalLine.id', 'AccJournalLine.acc_chart_of_account_id', 'AccJournalLine.ledger_dc', 'AccJournalLine.name', 'AccJournalLine.debet', 'AccJournalLine.credit', 'AccChartOfAccount.id', 'AccChartOfAccount.code', 'AccChartOfAccount.name', 'AccChartOfAccount.type'),
                            'conditions' => array('AccJournals.journal_type' => 'Memorial', $filterCondition),
                            'order' => array('AccJournals.date' => 'desc', 'AccJournals.code' => 'asc', 'AccJournalLine.id' => 'asc'),
                            'recursive' => 1
                        ));

                $data['rowDate'] = base64_encode($dateFrom.'^'.$dateTo);
                //$this->set(compact('data', 'dataDate'));

                $data['show'] = 'Y';
            } else {
                $data['show'] = 'N';
                $this->Krs->setFlash('Maaf Tanggal tidak boleh kosong. Data tidak dapat diproses!!', 'error');
            }
        } else {
            $data['show'] = 'N';
        }

        //Call for Branch
        $data['getListBranch'] = $this->Krs->getDataBranch();*/
        
        
    }

     public function generalLedgerPdf() {
        $print = $this->Cots->find('all')->contain(['Branches', 'Customers'])->where(['Cots.id' => $id])->first();

        $manifest = $this->Cots->Manifests->find('all')->contain(['Wastes.WasteTypes', 'Trucks', 'Paket'])->where(['Manifests.cot_id' => $id])->toArray();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->set(array('report' => $print, 'manifest' => $manifest));
    }

     public function generalLedgerXls() {
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
                'color' => ['argb' => 'FF757575'],
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

        $spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
        // $spreadsheet->getActiveSheet()->getColumnDimension('A1')->setWidth(15); 
        $spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->mergeCells('A3:I3');
        // $spreadsheet->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFEFEFEF');
        // $spreadsheet->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Cabang');
        $sheet->setCellValue('B1', 'Kode');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Penanggung Jawab');
        $sheet->setCellValue('E1', 'Uraian');
        $sheet->setCellValue('F1', 'D/K');
        $sheet->setCellValue('H1', 'Debet');
        $sheet->setCellValue('I1', 'Kredit');

        /*$report = $this->AccChartOfAccounts->find('all')->where(['AccChartOfAccounts.level' => '5'])->order(['AccChartOfAccounts.lft' => 'ASC'])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->id);
            $sheet->setCellValue('B' . $row, $data->code);
            $sheet->setCellValue('C' . $row, $data->name);
            $sheet->setCellValue('D' . $row, $data->beginning_balance);
            $row++;
        }*/
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'buku-besar';
        //$filename = 'customers-' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function generalJournalReport() {
        $accJournal = $this->AccJournals->newEmptyEntity();

        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
        } 
        else
        {   
            $data = '';
        }
        $this->set(compact('accJournal', 'data')); 
    }

    /*public function getCoaByJournal($dataCOA, $type=null) 
    {
        //pr($dataCOAs);
        if($type=='LR')
        {
            // Mengambil Id Pendapatan
            $dataCOAPendapatan = Hash::extract($dataCOA, '{n}[journal_type=pendapatan][level=5]', '{n}.id');
            $extractCOALevelPendapatan = (!empty($dataCOAPendapatan)) ? Hash::extract($dataCOAPendapatan, '{n}.id') : array();
            
            // Mengambil Id Potongan Penjualan
            $dataCOAPotonganPenjualan = Hash::extract($dataCOA, '{n}[journal_type=potongan_penjualan][level=5]', '{n}.id');
            $extractCOALevelPotonganPenjualan = (!empty($dataCOAPotonganPenjualan)) ? Hash::extract($dataCOAPotonganPenjualan, '{n}.id') : array();

            // Mengambil Id Beban
            $dataCOABeban = Hash::extract($dataCOA, '{n}[journal_type=beban][level=5]', '{n}.id');
            $extractCOALevelBeban = (!empty($dataCOABeban)) ? Hash::extract($dataCOABeban, '{n}.id') : array();

            // Mengambil Id Pendapatan Lain
            $dataCOAPendapatanLain = Hash::extract($dataCOA, '{n}[journal_type=pendapatan_lain][level=5]', '{n}.id');
            $extractCOALevelPendapatanLain = (!empty($dataCOAPendapatanLain)) ? Hash::extract($dataCOAPendapatanLain, '{n}.id') : array();

            // Mengambil Id Harga Pokok Penjualan
            $dataCOAHargaPokokPenjualan = Hash::extract($dataCOA, '{n}[journal_type=harga_pokok_penjualan][level=5]', '{n}.id');
            $extractCOALevelHargaPokokPenjualan = (!empty($dataCOAHargaPokokPenjualan)) ? Hash::extract($dataCOAHargaPokokPenjualan, '{n}.id') : array();

            // Mengambil Id Beban Lain Lain
            $dataCOABebanLainLain = Hash::extract($dataCOA, '{n}[journal_type=beban_lain_lain][level=5]', '{n}.id');
            $extractCOALevelBebanLainLain = (!empty($dataCOABebanLainLain)) ? Hash::extract($dataCOABebanLainLain, '{n}.id') : array();

            // Mengambil Id Beban Pemasaran
            $dataCOABebanPemasaran = Hash::extract($dataCOA, '{n}[journal_type=beban_pemasaran][level=5]', '{n}.id');
            $extractCOALevelBebanPemasaran = (!empty($dataCOABebanPemasaran)) ? Hash::extract($dataCOABebanPemasaran, '{n}.id') : array();

            $result = array_merge($extractCOALevelPendapatan,$extractCOALevelPotonganPenjualan,$extractCOALevelBeban,$extractCOALevelPendapatanLain,$extractCOALevelHargaPokokPenjualan,$extractCOALevelBebanLainLain, $extractCOALevelBebanPemasaran);
            // pr($extractCOALevel);

        } 
        else 
        {
            $result = '';
        }
        return $result;
    }*/

    public function import260727($condition=null) {
        $accJournal = $this->AccJournals->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            // $accChartOfAccount = $this->AccChartOfAccounts->newEmptyEntity();
            if($condition=="preview") {
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
                        $mypath = "uploads/import/".$myname; //Path untuk menaruh file yg akan diupload

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

                        $sheet = array_splice($sheets, 3);
                        // pr(array_splice($sheet, 3));
                        $accChartOfAccounts = array();
                        $a = 0;
                        foreach ($sheet as $key => $excel){
                            /*if ($key == 0) {
                                continue;
                            } */
                            if($excel[0]=='^' || $excel[0]=='') {
                                $a = 1+$a;
                            } else {
                                $xlsBranchId = $excel[0];
                                $xlsJournalType = $excel[1];
                                $xlsTanggal = $excel[2];
                                $xlsPenanggungJawab = $excel[3];
                                $xlsJudul = $excel[4];
                                $xlsCodeCoa = $excel[5];
                                $xlsUraian = $excel[6];
                                $xlsDebet = $excel[7];
                                $xlsKredit = $excel[8];
                                $data['showExl'][$a][] = $xlsBranchId.'^'.$xlsJournalType.'^'.$xlsTanggal.'^'.$xlsPenanggungJawab.'^'.$xlsJudul.'^'.$xlsCodeCoa.'^'.$xlsUraian.'^'.$xlsDebet.'^'.$xlsKredit;
                                //$data['showExl'][$a][] = $excel[0].'^'.$excel[1].'^'.$excel[2].'^'.$excel[3].'^'.$excel[4].'^'.$excel[5].'^'.$excel[6].'^'.$excel[7];
                            }
                            

                            // $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $xlsId,  $isUser, "edit from upload excel"); 
                            // $dataAuditLog = array('is_log' => $auditLog);
                            // $dataBeginningBalance = array('beginning_balance' => $xlsBeginningBalance);

                            // $dataAccChartOfAccount = array_merge($dataBeginningBalance, $dataAuditLog);

                            // pr($dataAccChartOfAccount);
                            // $this->AccChartOfAccounts->updateAll([$dataAccChartOfAccount], ['id' => $xlsId]);

                        }
                    }
                    // $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));
                    // return $this->redirect(['action' => 'beginningBalanceExportImport']);
                } else {
                     return $this->redirect(['action' => 'beginningBalanceExportImport']);
                }
                // $results = $this->Krs->uploadXls($filename, 0, 4, $strConfirmUpload);
            } elseif($condition=="save") {
                // $accJournal = $this->AccJournals->newEmptyEntity();
                if ($this->request->is('post')) {
                    $dataRows = $this->request->getData();

                    $isUser = $dataRows['user_id'];

                    // $accJournald = $this->AccJournals->newEmptyEntity();
                    // Memanggil data
                    $g = 0;
                    // $accJournals = array();
                    $accJournals = array();
                    foreach($dataRows['datas'] as $dataRow) {
                        $accJournal = $this->AccJournals->newEmptyEntity();
                        
                        $rowDate = (empty($dataRow['dates']))? NULL:$this->Krs->dateTo($dataRow['dates']);
                        $rowDateForCode = substr(str_replace("-", "", $rowDate), 2);


                        $codeMax = $this->AccJournals->getMax('Memorial', $rowDateForCode);
                        $branchId = $dataRow['branch_id'];
                        $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Import from Excel"); 

                        // $accJournals['acc_journals'][$g]['is_create'] = $isUser;
                        // $accJournals['acc_journals'][$g]['branch_id'] = $branchId;
                        // $accJournals['acc_journals'][$g]['recipient_payer_name'] = $dataRow['recipient_payer_name'];
                        // $accJournals['acc_journals'][$g]['subject'] = $dataRow['subject'];
                        // $accJournals['acc_journals'][$g]['date'] = $rowDate;
                        // $accJournals['acc_journals'][$g]['status'] = 'draft';
                        // $accJournals['acc_journals'][$g]['tax'] = 'D';
                        // $accJournals['acc_journals'][$g]['journal_type'] = 'Memorial';
                        // $accJournals['acc_journals'][$g]['code'] = $codeMax;
                        // $accJournals['acc_journals'][$g]['is_log'] = $auditLog;

                        $journalType = (empty($dataRow['journal_type'])) ? 'Memorial': $dataRow['journal_type'];
                        $dataUserId = array('is_create' => $isUser);
                        $dataBranchId = array('branch_id' => $branchId);
                        $dataRecipientPayerName = array('recipient_payer_name' => $dataRow['recipient_payer_name']);
                        $dataSubject = array('subject' => $dataRow['subject']);
                        $dataDate = array('date' => $rowDate);
                        $dataCameFrom = array('came_from' => 'Import');
                        $dataStatus = array('status' => 'draft');
                        $dataTax = array('tax' => 'D');
                        $dataJournalType = array('journal_type' => $journalType);
                        $dataCode = array('code' => $codeMax);
                        $dataAuditLog = array('is_log' => $auditLog);

                        // Memanggil data line
                        $accJournalLine = array();
                        $totalLine = array();
                        // $creditLine = array();
                        $positions = 0;
                        foreach($dataRow['line'] as $dataLine) {
                            $debetLine = $this->Krs->nom2Dec($dataLine['debet']);
                            $creditLine = $this->Krs->nom2Dec($dataLine['credit']);
                            $auditLogLine = $this->Krs->auditLog('AccJournalLines', 'N',  $isUser, "Import from Excel");
                           
                            $accJournalLine['acc_journal_lines'][$positions]['branch_id'] = $branchId;
                            $ledgerDCLine = ($debetLine>0) ? 'D':'C';
                            // $dataAccJournalId = array('acc_journal_id' => $dataLine['']);
                            $accJournalLine['acc_journal_lines'][$positions]['acc_chart_of_account_id'] = $dataLine['codecoa'];
                            $accJournalLine['acc_journal_lines'][$positions]['position'] = $positions;
                            $accJournalLine['acc_journal_lines'][$positions]['ledger_dc'] = $ledgerDCLine;
                            $accJournalLine['acc_journal_lines'][$positions]['name'] = $dataLine['uraian'];
                            $accJournalLine['acc_journal_lines'][$positions]['debet'] = $debetLine;
                            $accJournalLine['acc_journal_lines'][$positions]['credit'] = $creditLine;
                            $accJournalLine['acc_journal_lines'][$positions]['is_create'] = $isUser;
                            // $accJournalLine['acc_journal_lines'][$positions]['is_log'] = $auditLogLine;
                            $totalLine[] = $debetLine;
                            //$pettyCashLine['petty_cash_lines'][$key]
                            $positions++;
                        }

                        $totalDebetLine = array_sum($totalLine);
                        // $totalCreditLine = array_sum($creditLine);
                        // $grandTotalLine = $totalDebetLine;
                        $dataGrandTotal = array('grand_total' => $totalDebetLine);
                        // $accJournals['acc_journals'][$g]['grand_total'] = $totalDebetLine;

                        // $accJournal['acc_journals'][$g] = $this->AccJournals->patchEntity($accJournal, array_merge($dataUserId, $dataBranchId, $dataRecipientPayerName, $dataSubject, $dataDate, $dataStatus, $dataTax, $dataJournalType, $dataCode, $dataGrandTotal, $dataAuditLog, $accJournalLine));
                        // $accJournal = $this->AccJournals->patchEntity($accJournal, array_merge($accJournals, $accJournalLine));
                        $accJournal = $this->AccJournals->patchEntity($accJournal, array_merge($dataUserId, $dataCameFrom, $dataBranchId, $dataRecipientPayerName, $dataSubject, $dataDate, $dataStatus, $dataTax, $dataJournalType, $dataCode, $dataGrandTotal, $dataAuditLog, $accJournalLine));
                        //pr($accJournal);

                        // Simpan data Journal dari Excel
                        // try {
                            $this->AccJournals->save($accJournal, array('callbacks' => false));
                        // } catch (RecordNotFoundException $ex) {
                        //    throw new NotFoundException('User not found', null, $ex);
                        // }
     // catch (NotFoundException $e) {
     //                       // $errors[$i-1] = $g[$i];
     //                        $this->Flash->error('All rows are successfully imported. ');
     //                        // $this->Flash->error(__('Terima kasih, data berhasil disimpan.'));
     //                        // $this->Flash->error('Gagalll. ');
     //                        // debug($errors);
     //                    }
                        // } finally {
                        //     if(count($errors) == 0)
                        //         $this->Flash->success('All rows are successfully imported. ');
                        //     else {
                        //         $this->Flash->error('Not all rows are successfully imported. ');
                        //         debug($errors);
                        //     }
                        // }

                        // $this->AccJournals->save($accJournals[$g], array('callbacks' => true));
                        //$accJournal[$g] = $this->AccJournals->patchEntity($accJournald, array_merge($dataUserId, $dataBranchId, $dataRecipientPayerName, $dataSubject, $dataDate, $dataStatus, $dataTax, $dataJournalType, $dataCode, $dataGrandTotal, $dataAuditLog, $accJournalLine));

                        // foreach ($accJournal as $entity) {
                            // if (!$accJournal->getErrors()) {
                            //     pr($accJournal);
                            // }
                        // }


                        
                        // if ($this->AccJournals->save($accJournal, array('callbacks' => true))) {
                        //      // pr($accJournal);
                        // }

                    // pr($accJournal);
                        //$accJournal = $this->AccJournals->patchEntity($accJournal, array_merge($accJournals, $accJournalLine));

                        $g++;
                    }
                    // pr($accJournals);

                    // $accJournal = $this->AccJournals->patchEntity($accJournal, $accJournals);
                    // pr($accJournal);

                    // $this->AccJournals->save($accJournal, array('callbacks' => true));
                    // $accJournal = $this->AccJournals->patchEntity($accJournal, array_merge($accJournals, $accJournalLine));
                    // foreach($accJournals as $accJournalsd) {
                    //     // pr($accJournalsd);
                    //     // $this->AccJournals->save($accJournalsd, array('callbacks' => true));
                    // }
                    
                    // if ($this->AccJournals->save($accJournals, array('callbacks' => true))) {
                    //         pr($accJournals);
                    // }
                    
                    
                    $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));
                    return $this->redirect(['action' => 'import']);
                }
            }
            $data['show'] = 'Y';
        } else {
            $data['show'] = 'N';
        }

        $this->set(compact('accJournal', 'data'));
    }

    public function import($condition=null) {
        $accJournal = $this->AccJournals->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            // $accChartOfAccount = $this->AccChartOfAccounts->newEmptyEntity();
            if($condition=="preview") {
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
                        $mypath = "uploads/import/".$myname; //Path untuk menaruh file yg akan diupload

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
                        $sheet = array_splice($sheets, 3);
                        // pr(array_splice($sheet, 3));
                        $accChartOfAccounts = array();
                        $a = 0;
                        foreach ($sheet as $key => $excel){
                            /*if ($key == 0) {
                                continue;
                            } */
                            if($excel[0]=='^' || $excel[0]=='') {
                                $a = 1+$a;
                            } else {
                                $xlsBranchId = $excel[0];
                                $xlsJournalType = $excel[1];
                                $xlsTanggal = $excel[2];
                                $xlsPenanggungJawab = $excel[3];
                                $xlsJudul = $excel[4];
                                $xlsCodeCoa = $excel[5];
                                $xlsUraian = $excel[6];
                                $xlsDebet = $excel[7];
                                $xlsKredit = $excel[8];
                                $data['showExl'][$a][] = $xlsBranchId.'^'.$xlsJournalType.'^'.$xlsTanggal.'^'.$xlsPenanggungJawab.'^'.$xlsJudul.'^'.$xlsCodeCoa.'^'.$xlsUraian.'^'.$xlsDebet.'^'.$xlsKredit;
                                //$data['showExl'][$a][] = $excel[0].'^'.$excel[1].'^'.$excel[2].'^'.$excel[3].'^'.$excel[4].'^'.$excel[5].'^'.$excel[6].'^'.$excel[7];
                            }
                            

                            // $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $xlsId,  $isUser, "edit from upload excel"); 
                            // $dataAuditLog = array('is_log' => $auditLog);
                            // $dataBeginningBalance = array('beginning_balance' => $xlsBeginningBalance);

                            // $dataAccChartOfAccount = array_merge($dataBeginningBalance, $dataAuditLog);

                            // pr($dataAccChartOfAccount);
                            // $this->AccChartOfAccounts->updateAll([$dataAccChartOfAccount], ['id' => $xlsId]);

                        }
                    }
                    // $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));
                    // return $this->redirect(['action' => 'beginningBalanceExportImport']);
                } else {
                     return $this->redirect(['action' => 'beginningBalanceExportImport']);
                }
                // $results = $this->Krs->uploadXls($filename, 0, 4, $strConfirmUpload);
            } elseif ($condition == "save") {
                if ($this->request->is('post')) {
                    $dataRows = $this->request->getData();
                    // debug($dataRows); die;
                    $isUser = $dataRows['user_id'];

                    // ==========================================================
                    // BANGUN PETA KODE COA -> ID (sekali saja, di luar loop)
                    // ==========================================================
                    $this->loadModel('AccChartOfAccounts');
                    $coaMap = $this->AccChartOfAccounts
                        ->find('list', ['keyField' => 'code', 'valueField' => 'id'])
                        ->toArray();

                    // ==========================================================
                    // VALIDASI DULU SEMUA KODE COA SEBELUM SIMPAN APAPUN
                    // Supaya tidak ada data "setengah tersimpan" kalau ada kode salah
                    // ==========================================================
                    $missingCodes = [];
                    foreach ($dataRows['datas'] as $rowIndex => $dataRow) {
                        foreach ($dataRow['line'] as $lineIndex => $dataLine) {
                            $code = trim($dataLine['codecoa'] ?? '');
                            if ($code === '' || !isset($coaMap[$code])) {
                                $missingCodes[] = sprintf(
                                    'Baris Excel #%d, Line #%d: kode COA "%s" tidak ditemukan',
                                    $rowIndex + 1,
                                    $lineIndex + 1,
                                    $code
                                );
                            }
                        }
                    }

                    if (!empty($missingCodes)) {
                        $this->Flash->error(
                            __('Import gagal, ada kode COA yang tidak ditemukan:') 
                            . '<br>' . implode('<br>', $missingCodes)
                        );
                        return $this->redirect(['action' => 'import']);
                    }

                    // ==========================================================
                    // BARU SIMPAN (semua kode sudah divalidasi valid)
                    // ==========================================================
                    $g = 0;
                    foreach ($dataRows['datas'] as $dataRow) {
                        $accJournal = $this->AccJournals->newEmptyEntity();

                        $rowDate = (empty($dataRow['dates'])) ? null : $this->Krs->dateTo($dataRow['dates']);
                        $rowDateForCode = substr(str_replace("-", "", $rowDate), 2);

                        $codeMax = $this->AccJournals->getMax('Memorial', $rowDateForCode);
                        $branchId = $dataRow['branch_id'];
                        $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Import from Excel");

                        $journalType = (empty($dataRow['journal_type'])) ? 'Memorial' : $dataRow['journal_type'];
                        $dataUserId = ['is_create' => $isUser];
                        $dataBranchId = ['branch_id' => $branchId];
                        $dataRecipientPayerName = ['recipient_payer_name' => $dataRow['recipient_payer_name']];
                        $dataSubject = ['subject' => $dataRow['subject']];
                        $dataDate = ['date' => $rowDate];
                        $dataCameFrom = ['came_from' => 'Import'];
                        $dataStatus = ['status' => 'draft'];
                        $dataTax = ['tax' => 'D'];
                        $dataJournalType = ['journal_type' => $journalType];
                        $dataCode = ['code' => $codeMax];
                        $dataAuditLog = ['is_log' => $auditLog];

                        $accJournalLine = [];
                        $totalLine = [];
                        $positions = 0;
                        foreach ($dataRow['line'] as $dataLine) {
                            $debetLine = $this->Krs->nom2Dec($dataLine['debet']);
                            $creditLine = $this->Krs->nom2Dec($dataLine['credit']);

                            // LOOKUP: kode COA -> id, sudah pasti ada karena sudah divalidasi di atas
                            $code = trim($dataLine['codecoa']);
                            $coaId = $coaMap[$code];

                            $accJournalLine['acc_journal_lines'][$positions]['branch_id'] = $branchId;
                            $ledgerDCLine = ($debetLine > 0) ? 'D' : 'C';
                            $accJournalLine['acc_journal_lines'][$positions]['acc_chart_of_account_id'] = $coaId;
                            $accJournalLine['acc_journal_lines'][$positions]['position'] = $positions;
                            $accJournalLine['acc_journal_lines'][$positions]['ledger_dc'] = $ledgerDCLine;
                            $accJournalLine['acc_journal_lines'][$positions]['name'] = $dataLine['uraian'];
                            $accJournalLine['acc_journal_lines'][$positions]['debet'] = $debetLine;
                            $accJournalLine['acc_journal_lines'][$positions]['credit'] = $creditLine;
                            $accJournalLine['acc_journal_lines'][$positions]['is_create'] = $isUser;
                            $totalLine[] = $debetLine;
                            $positions++;
                        }

                        $totalDebetLine = array_sum($totalLine);
                        $dataGrandTotal = ['grand_total' => $totalDebetLine];

                        $accJournal = $this->AccJournals->patchEntity(
                            $accJournal,
                            array_merge($dataUserId, $dataCameFrom, $dataBranchId, $dataRecipientPayerName, $dataSubject, $dataDate, $dataStatus, $dataTax, $dataJournalType, $dataCode, $dataGrandTotal, $dataAuditLog, $accJournalLine)
                        );
                        // debug($accJournal); die;

                        $this->AccJournals->save($accJournal, ['callbacks' => false]);
                        // $resultSave = $this->AccJournals->save(
                        //     $accJournal,
                        //     [
                        //         'callbacks' => false,
                        //         'associated' => ['AccJournalLines']
                        //     ]
                        // );

                        // if (!$resultSave) {

                        //     debug('SAVE GAGAL');

                        //     debug([
                        //         'journal_errors' => $accJournal->getErrors()
                        //     ]);

                        //     if (!empty($accJournal->acc_journal_lines)) {
                        //         foreach ($accJournal->acc_journal_lines as $index => $line) {
                        //             debug([
                        //                 'line' => $index,
                        //                 'errors' => $line->getErrors(),
                        //                 'data' => $line
                        //             ]);
                        //         }
                        //     }

                        //     die;
                        // }

                        // debug('SAVE BERHASIL');
                        // debug($resultSave);
                        // die;

                        $g++;
                    }

                    $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));
                    return $this->redirect(['action' => 'import']);
                }
            }
            $data['show'] = 'Y';
        } else {
            $data['show'] = 'N';
        }

        $this->set(compact('accJournal', 'data'));
    }

    public function importExampleXls() {
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

        $spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
        // $spreadsheet->getActiveSheet()->getColumnDimension('A1')->setWidth(15); 
        $spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->mergeCells('A3:I3');
        // $spreadsheet->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFEFEFEF');
        // $spreadsheet->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Cabang');
        $sheet->setCellValue('B1', 'Jenis Jurnal');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Penanggung Jawab');
        $sheet->setCellValue('E1', 'Judul');
        $sheet->setCellValue('F1', 'Id COA/Perkiraan');
        $sheet->setCellValue('G1', 'Uraian');
        $sheet->setCellValue('H1', 'Debet');
        $sheet->setCellValue('I1', 'Kredit');

        $sheet->setCellValue('A2', 'Kolom ini berisi ID cabang');
        $sheet->setCellValue('B2', 'Kolom ini berisi Jenis Jurnal nb(BKM, BKK, Bank Debet, Bank Credit, Memorial, Adjustment, Closing, Beginning Balance, Invoice, Invoice Masuk, Operational)');
        $sheet->setCellValue('C2', 'Kolom ini berisi tanggal dengan format "dd-mm-yyyy / 30-12-2020"');
        $sheet->setCellValue('D2', 'Masukkan untuk "Penanggung Jawab"');
        $sheet->setCellValue('E2', 'Masukkan untuk Judul pada Jurnal');
        $sheet->setCellValue('F2', 'Masukkan id COA yang terdapat pada "Contoh COA"');
        $sheet->setCellValue('G2', 'Masukkan sesuai Uraian pada Jurnal');
        $sheet->setCellValue('H2', 'Masukkan nominal Debit');
        $sheet->setCellValue('I2', 'Masukkan nominal Kredit');

        $sheet->setCellValue('A3', 'Setelah memasukkan data jurnal per-transaksi, kolom selanjutnya di beri karakter "^", sebagai pemisah antara transaksi Jurnal');

        /*$report = $this->AccChartOfAccounts->find('all')->where(['AccChartOfAccounts.level' => '5'])->order(['AccChartOfAccounts.lft' => 'ASC'])->toArray();

        $row = 2;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->id);
            $sheet->setCellValue('B' . $row, $data->code);
            $sheet->setCellValue('C' . $row, $data->name);
            $sheet->setCellValue('D' . $row, $data->beginning_balance);
            $row++;
        }*/
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'contoh-inputan-jurnal';
        //$filename = 'customers-' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

   


    public function incomeMultiReport() {
        $accJournal = $this->AccJournals->newEmptyEntity();
        $this->loadModel('AccChartOfAccounts');

        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();

            $monthYearFrom = $dataRow['filterDateFrom'];
            $monthYearEnd = $dataRow['filterDateEnd'];

            
            // $filterDateStart = "";
            // $filterDateEnd = "";

            list($monthFroms, $yearFroms) = explode("-", $monthYearFrom);
            list($monthEnds, $yearEnds) = explode("-", $monthYearEnd);

            $monthFrom = intval($monthFroms);
            $yearFrom = intval($yearFroms);
            $monthEnd = intval($monthEnds);
            $yearEnd = intval($yearEnds);


            $condYearFrom = $yearFrom."-".$monthFrom;
            $condYearEnd = $yearEnd."-".$monthEnd;

            // pr($monthFrom);

            $filterDateStartShow = date("t-M-Y", mktime(0, 0, 0, $monthFrom, 0, $yearFrom));
            $filterDateEndShow = date("d-M-Y", mktime(0, 0, 0, $monthEnd, 1, $yearEnd));
            $filterDateEnd = date("Y-m-t", mktime(0, 0, 0, $monthEnd, 0, $yearEnd));
            $filterDateStart = date("Y-m-d", mktime(0, 0, 0, $monthFrom, 1, $yearFrom));

            // $filterDateStartShow = date("t-M-Y", mktime(0, 0, 0, $month+1, 0, $year));
            // $filterDateEndShow = date("d-M-Y", mktime(0, 0, 0, $month, 1, $year));
            // $filterDateEnd = date("Y-m-t", mktime(0, 0, 0, $month+1, 0, $year));
            // $filterDateStart = date("Y-m-d", mktime(0, 0, 0, $month, 1, $year));

            if($filterDateStart!="" && $filterDateEnd!="") {
                $filterConditionDateNow = ($filterDateEnd!="") ? array("SUBSTRING(AccJournals.date, 1, 7) BETWEEN '".$condYearFrom."' AND '".$condYearEnd."'") : array();

                $dateFilter = $filterDateStart."^".$filterDateEnd;
                $dataDate = $this->Krs->fEncode($dateFilter);

                // Memanggil data COA.
                $dataCOAs = $this->AccChartOfAccounts->datarowCOA();             

                // Mengambil data COA Id
                // $extractCOALevel = $this->getCoaByJournal($dataCOAs, 'LR');
                
                // Mengambil Id Pendapatan
                $dataCOAPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan]');
                $dataCOAPendapatans = Hash::extract($dataCOAPendapatan, '{n}[level=5]');
                $extractCOALevelPendapatan = (!empty($dataCOAPendapatans)) ? Hash::extract($dataCOAPendapatans, '{n}.id') : array();

                // Mengambil Id Retur Pendapatan
                $dataCOAReturPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=retur_pendapatan]');
                $dataCOAReturPendapatans = Hash::extract($dataCOAReturPendapatan, '{n}[level=5]');
                $extractCOALevelReturPendapatan = (!empty($dataCOAReturPendapatans)) ? Hash::extract($dataCOAReturPendapatans, '{n}.id') : array();

                // Mengambil Id Potongan Pendapatan
                $dataCOAPotonganPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=potongan_pendapatan]');
                $dataCOAPotonganPendapatans = Hash::extract($dataCOAPotonganPendapatan, '{n}[level=5]');
                $extractCOALevelPotonganPendapatan = (!empty($dataCOAPotonganPendapatans)) ? Hash::extract($dataCOAPotonganPendapatans, '{n}.id') : array();

                // Mengambil Id Beban Pokok Pendapatan
                $dataCOABebanPokokPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=beban_pokok_pendapatan]');
                $dataCOABebanPokokPendapatans = Hash::extract($dataCOABebanPokokPendapatan, '{n}[level=5]');
                $extractCOALevelBebanPokokPendapatan = (!empty($dataCOABebanPokokPendapatans)) ? Hash::extract($dataCOABebanPokokPendapatans, '{n}.id') : array();

                // Mengambil Id Beban Pendapatan
                $dataCOABebanPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=beban_pendapatan]');
                $dataCOABebanPendapatans = Hash::extract($dataCOABebanPendapatan, '{n}[level=5]');
                $extractCOALevelBebanPendapatan = (!empty($dataCOABebanPendapatans)) ? Hash::extract($dataCOABebanPendapatans, '{n}.id') : array();

                // Mengambil Id Beban Administrasi Umum
                $dataCOABebanAdministrasiUmum = Hash::extract($dataCOAs, '{n}[journal_type=beban_administrasi_umum]');
                $dataCOABebanAdministrasiUmums = Hash::extract($dataCOABebanAdministrasiUmum, '{n}[level=5]');
                $extractCOALevelBebanAdministrasiUmum = (!empty($dataCOABebanAdministrasiUmums)) ? Hash::extract($dataCOABebanAdministrasiUmums, '{n}.id') : array();

                // Mengambil Id Pendapatan Non Operasional
                $dataCOAPendapatanNonOperasional = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan_non_operasional]');
                $dataCOAPendapatanNonOperasionals = Hash::extract($dataCOAPendapatanNonOperasional, '{n}[level=5]');
                $extractCOALevelPendapatanNonOperasional = (!empty($dataCOAPendapatanNonOperasionals)) ? Hash::extract($dataCOAPendapatanNonOperasionals, '{n}.id') : array();

                // Mengambil Id Beban Non Operasional
                $dataCOABebanNonOperasional = Hash::extract($dataCOAs, '{n}[journal_type=beban_non_operasional]');
                $dataCOABebanNonOperasionals = Hash::extract($dataCOABebanNonOperasional, '{n}[level=5]');
                $extractCOALevelBebanNonOperasional = (!empty($dataCOABebanNonOperasionals)) ? Hash::extract($dataCOABebanNonOperasionals, '{n}.id') : array();

                $extractCOALevel = array_merge($extractCOALevelPendapatan,$extractCOALevelReturPendapatan,$extractCOALevelPotonganPendapatan,$extractCOALevelBebanPokokPendapatan,$extractCOALevelBebanPendapatan,$extractCOALevelBebanAdministrasiUmum, $extractCOALevelPendapatanNonOperasional, $extractCOALevelBebanNonOperasional);

                $dataJournalCOA = array();
                for ($i=$monthFrom; $i <= $monthEnd; $i++) {
                    $bln = strval($i);
                    $monthData = str_pad($bln, 2, '0', STR_PAD_LEFT);
                    // pr($monthData);
                    $monthYearData = $yearFrom.'-'.$monthData;

                    $data['rows'][$monthData] = $this->AccJournals->find('all')
                                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                                    ->where(["AccJournalLines.acc_chart_of_account_id IN" => count($extractCOALevel) > 0 ?  $extractCOALevel : [null], "SUBSTRING(AccJournals.date, 1, 7) ="=>$monthYearData])
                                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                                    //->contain(['AccJournalLines'])
                                    ->leftJoinWith('AccJournalLines')
                                    // ->enableAutoFields(true)
                                    ->toArray();
                    $dataJournalCOA[$monthData] = Hash::combine($data['rows'][$monthData], '{n}.coaId',['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                }                

                $month = $monthFrom.'^'.$monthEnd;

                $listCOAPendapatan = $this->Krs->GetSchemaCOAGlobalMultiShow($dataCOAPendapatan, $dataJournalCOA, $month, '', 'creditMinusdebet');
                asort($listCOAPendapatan);

                $listCOAReturPendapatan = $this->Krs->GetSchemaCOAGlobalMultiShow($dataCOAReturPendapatan, $dataJournalCOA, $month, '', 'debet');
                asort($listCOAReturPendapatan);

                $listCOAPotonganPendapatan = $this->Krs->GetSchemaCOAGlobalMultiShow($dataCOAPotonganPendapatan, $dataJournalCOA, $month, '', 'creditMinusdebet');
                asort($listCOAPotonganPendapatan);                

                $listCOABebanPokokPendapatan = $this->Krs->GetSchemaCOAGlobalMultiShow($dataCOABebanPokokPendapatan, $dataJournalCOA, $month, '', 'debet');
                asort($listCOABebanPokokPendapatan);

                $listCOABebanPendapatan = $this->Krs->GetSchemaCOAGlobalMultiShow($dataCOABebanPendapatan, $dataJournalCOA, $month, '', 'debet');
                asort($listCOABebanPendapatan);

                $listCOABebanAdministrasiUmum = $this->Krs->GetSchemaCOAGlobalMultiShow($dataCOABebanAdministrasiUmum, $dataJournalCOA, $month, '', 'debet');
                asort($listCOABebanAdministrasiUmum);

                $listCOAPendapatanNonOperasional = $this->Krs->GetSchemaCOAGlobalMultiShow($dataCOAPendapatanNonOperasional, $dataJournalCOA, $month, '', 'creditMinusdebet');
                //debet
                asort($listCOAPendapatanNonOperasional);

                $listCOABebanNonOperasional = $this->Krs->GetSchemaCOAGlobalMultiShow($dataCOABebanNonOperasional, $dataJournalCOA, $month, '', 'debet');
                asort($listCOABebanNonOperasional);

                $this->set(compact('listCOAPendapatan','listCOAReturPendapatan','listCOAPotonganPendapatan', 'listCOABebanPokokPendapatan', 'listCOABebanPendapatan', 'listCOABebanAdministrasiUmum', 'listCOAPendapatanNonOperasional', 'listCOABebanNonOperasional'));

                $dateFilter = $monthYearFrom."^".$monthYearEnd;
                $dataDate = $this->Krs->fEncode($dateFilter);

                // $this->set(compact('dataDate', 'listCOAPendapatan', 'listCOAPotonganPenjualan', 'listCOAPendapatanLain', 'listCOAHargaPokokPenjualan', 'listCOABeban', 'listCOABebanLainLain', 'listCOABebanPemasaran'));
                //'dataCOAPendapatan', 'dataCOAPotonganPenjualan','dataCOAPendapatanLain', 'dataCOAHargaPokokPenjualan', 'dataCOABebanLainLain','dataCOABeban','dataCOABebanPemasaran','dataJournal', 'dataDate', 
                $this->set(compact('dataCOAPendapatan', 'dataCOAReturPendapatan','dataCOAPotonganPendapatan', 'dataCOABebanPokokPendapatan', 'dataCOABebanPendapatan','dataCOABebanAdministrasiUmum','dataCOAPendapatanNonOperasional', 'dataCOABebanNonOperasional', 'dataDate', 'monthFrom', 'monthEnd', 'monthYearFrom', 'monthYearEnd'));

                $data['show'] = 'Y';
            } 
            else 
            {
                $data['show'] = 'N';
            }
        } 
        else
        {   
            $data['show'] = 'N';
        }
        $this->set(compact('accJournal', 'data')); 
    }

     public function trialBalanceReport()
    {
        $accJournal = $this->AccJournals->newEmptyEntity();       

        if ($this->request->is('post')) {
            $this->loadModel('AccChartOfAccounts');
            $dataRow = $this->request->getData();

            $dataFilterDate = $dataRow['filterDate'];
            $filterDate = $this->Krs->dateTo($dataFilterDate);
            
            // $dataFilterDateFrom = $dataRow['filterDateFrom'];
            // $dataFilterDateEnd = $dataRow['filterDateEnd'];
            // $filterDateFrom = $this->Krs->dateTo($dataFilterDateFrom);
            // $filterDateEnd = $this->Krs->dateTo($dataFilterDateEnd);

            $year = substr($filterDate, 0, 4);
            $beforeDate = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year-1));
            $beforeYear = date("Y", mktime(0, 0, 0, 12, 31, $year-1));

            $filterConditionDate = ($filterDate!="") ? array("AccJournals.date <="=>$filterDate):array();
            //$filterConditionDate = ($filterDateFrom!="") ? array('DATE(AccJournals.date) BETWEEN "' . $filterDateFrom . '" AND "' . $filterDateEnd . '"'):array();
            
            // Memanggil data COA.
            $dataCOAs = $this->AccChartOfAccounts->datarowCOA(5);


            $data['rows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where([$filterConditionDate, 'AccJournals.status'=>'posting', 'AccJournals.journal_type IS NOT' => 'Adjustment'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    // ->enableAutoFields(false)
                    ->toArray();
            // pr($data['rows']);
            
            $data['rowsAdjustment'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where([$filterConditionDate, 'AccJournals.status'=>'posting', 'AccJournals.journal_type' => 'Adjustment'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    // ->enableAutoFields(false)
                    ->toArray();
               
            $data['show'] = 'Y';

            $this->set(compact('dataCOAs'));
        } else {
            $data['show'] = 'N';
        }

        $this->set(compact('accJournal', 'data'));
    }



    public function trialBalanceReport_230703()
    {
        $accJournal = $this->AccJournals->newEmptyEntity();
        $this->loadModel('AccChartOfAccounts');

        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();

            $dataFilterDate = $dataRow['filterDate'];
            $filterDate = $this->Krs->dateTo($dataFilterDate);
            $year = substr($filterDate, 0, 4);
            $beforeDate = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year-1));
            $beforeYear = date("Y", mktime(0, 0, 0, 12, 31, $year-1));

            $filterConditionDate = ($filterDate!="") ? array("AccJournals.date <="=>$filterDate):array();
            //pr($filterDate);
            $filterConditionDateBeforePrive = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$beforeDate):array();
            $filterConditionDateBeforeSaldoDitahan = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$beforeDate):array();
            $filterConditionDateBeforeLabaRugiBerjalan = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$beforeDate):array();

            $filterConditionDatePrive = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();
            $filterConditionDateSaldoDitahan = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();
            $filterConditionDateLabaRugiBerjalan = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();

            // Memanggil data COA.
            $dataCOAs = $this->AccChartOfAccounts->datarowCOA();             

            // Mengambil data COA Id
            // $extractCOALevel = $this->getCoaByJournal($dataCOAs, 'LR');
            
            // Mengambil Id Kas Bank
            $dataCOAKasBank = Hash::extract($dataCOAs, '{n}[journal_type=kas_bank]');
            $dataCOAKasBanks = Hash::extract($dataCOAKasBank, '{n}[level=5]');
            $extractCOALevelKasBank = (!empty($dataCOAKasBanks)) ? Hash::extract($dataCOAKasBanks, '{n}.id') : array();

            // Piutang
            $dataCOAPiutang = Hash::extract($dataCOAs, '{n}[journal_type=akun_piutang]');
            $dataCOAPiutangs = Hash::extract($dataCOAPiutang, '{n}[level=5]');
            $extractCOALevelPiutang = (!empty($dataCOAPiutangs)) ? Hash::extract($dataCOAPiutangs, '{n}.id') : array();

            // Aktiva Tetap
            $dataCOAAktivaTetap = Hash::extract($dataCOAs, '{n}[journal_type=aktiva_tetap]');
            $dataCOAAktivaTetaps = Hash::extract($dataCOAAktivaTetap, '{n}[level=5]');
            $extractCOALevelAktivaTetap = (!empty($dataCOAAktivaTetaps)) ? Hash::extract($dataCOAAktivaTetaps, '{n}.id') : array();

            // Akumulasi Penyusutan
            $dataCOAAkumulasiPenyusutan = Hash::extract($dataCOAs, '{n}[journal_type=akumulasi_penyusutan]');
            $dataCOAAkumulasiPenyusutans = Hash::extract($dataCOAAkumulasiPenyusutan, '{n}[level=5]');
            $extractCOALevelAkumulasiPenyusutan = (!empty($dataCOAAkumulasiPenyusutans)) ? Hash::extract($dataCOAAkumulasiPenyusutans, '{n}.id') : array();

            // Hutang
            $dataCOAHutang = Hash::extract($dataCOAs, '{n}[journal_type=akun_hutang]');
            $dataCOAHutangs = Hash::extract($dataCOAHutang, '{n}[level=5]');
            $extractCOALevelHutang = (!empty($dataCOAHutangs)) ? Hash::extract($dataCOAHutangs, '{n}.id') : array();

            // Hutang Lancar
            $dataCOAHutangLancar = Hash::extract($dataCOAs, '{n}[journal_type=hutang_lancar_lainnya]');
            $dataCOAHutangLancars = Hash::extract($dataCOAHutangLancar, '{n}[level=5]');
            $extractCOALevelHutangLancar = (!empty($dataCOAHutangLancars)) ? Hash::extract($dataCOAHutangLancars, '{n}.id') : array();

            // Modal
            $dataCOAModal = Hash::extract($dataCOAs, '{n}[journal_type=modal]');
            $dataCOAModals = Hash::extract($dataCOAModal, '{n}[level=5]');
            $extractCOALevelModal = (!empty($dataCOAModals)) ? Hash::extract($dataCOAModals, '{n}.id') : array();
            
            // Saldo Ditahan
            $dataCOASaldoDitahan = Hash::extract($dataCOAs, '{n}[journal_type=saldo_ditahan]');
            $dataCOASaldoDitahans = Hash::extract($dataCOASaldoDitahan, '{n}[level=5]');
            $extractCOALevelSaldoDitahan = (!empty($dataCOASaldoDitahans)) ? Hash::extract($dataCOASaldoDitahans, '{n}.id') : array();

            // Prive
            $dataCOAPrive = Hash::extract($dataCOAs, '{n}[journal_type=prive]');
            $dataCOAPrives = Hash::extract($dataCOAPrive, '{n}[level=5]');
            $extractCOALevelPrive = (!empty($dataCOAPrives)) ? Hash::extract($dataCOAPrives, '{n}.id') : array();

            $extractCOAAktivaPasivaId = array_merge($extractCOALevelKasBank, $extractCOALevelPiutang, $extractCOALevelAktivaTetap, $extractCOALevelAkumulasiPenyusutan, $extractCOALevelHutang, $extractCOALevelHutangLancar, $extractCOALevelModal, $extractCOALevelSaldoDitahan, $extractCOALevelPrive);

            // Laba/Rugi Berjalan
            // Pendapatan
            $dataCOAPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan]');
            $dataCOAPendapatans = Hash::extract($dataCOAPendapatan, '{n}[level=5]');
            $extractCOALevelPendapatan = (!empty($dataCOAPendapatans)) ? Hash::extract($dataCOAPendapatans, '{n}.id') : array();

            // Pendapatan Lain
            $dataCOAPendapatanLain = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan_lain]');
            $dataCOAPendapatanLains = Hash::extract($dataCOAPendapatanLain, '{n}[level=5]');
            $extractCOALevelPendapatanLain = (!empty($dataCOAPendapatanLains)) ? Hash::extract($dataCOAPendapatanLains, '{n}.id') : array();

            // Harga Pokok Penjualan
            $dataCOAHargaPokokPenjualan = Hash::extract($dataCOAs, '{n}[journal_type=harga_pokok_penjualan]');
            $dataCOAHargaPokokPenjualans = Hash::extract($dataCOAHargaPokokPenjualan, '{n}[level=5]');
            $extractCOALevelHargaPokokPenjualan = (!empty($dataCOAHargaPokokPenjualans)) ? Hash::extract($dataCOAHargaPokokPenjualans, '{n}.id') : array();

            // Beban Lain Lain
            $dataCOABebanLainLain = Hash::extract($dataCOAs, '{n}[journal_type=beban_lain_lain]');
            $dataCOABebanLainLains = Hash::extract($dataCOABebanLainLain, '{n}[level=5]');
            $extractCOALevelBebanLainLain = (!empty($dataCOABebanLainLains)) ? Hash::extract($dataCOABebanLainLains, '{n}.id') : array();

            // Beban
            $dataCOABeban = Hash::extract($dataCOAs, '{n}[journal_type=beban]');
            $dataCOABebans = Hash::extract($dataCOABeban, '{n}[level=5]');
            $extractCOALevelBeban = (!empty($dataCOABebans)) ? Hash::extract($dataCOABebans, '{n}.id') : array();

            // Beban Pemasaran
            $dataCOABebanPemasaran = Hash::extract($dataCOAs, '{n}[journal_type=beban_pemasaran]');
            $dataCOABebanPemasarans = Hash::extract($dataCOABebanPemasaran, '{n}[level=5]');
            $extractCOALevelBebanPemasaran = (!empty($dataCOABebanPemasarans)) ? Hash::extract($dataCOABebanPemasarans, '{n}.id') : array();

            $extractCOALabaRugiBerjalanId = array_merge($extractCOALevelPendapatan, $extractCOALevelPendapatanLain, $extractCOALevelHargaPokokPenjualan, $extractCOALevelBebanLainLain, $extractCOALevelBeban, $extractCOALevelBebanPemasaran);

            $filterDateJournal = (empty($filterDate)) ? array() : array("AccJournals.date <=" => $filterDate);

            $data['rows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOAAktivaPasivaId) > 0 ?  $extractCOAAktivaPasivaId : [null], $filterDateJournal, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])

                    // ->order(['AccChartOfAccounts.lft'=>'ASC', 'AccChartOfAccounts.rght'=>'ASC'])
                    // ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    /*->join([
                        'AccJournalLines' => [
                            'table' => 'acc_journal_lines',
                            'type' => 'LEFT',
                            'conditions' => 'AccJournalLines.acc_journal_id = AccJournals.id',
                        ],
                        'AccChartOfAccounts' => [
                            'table' => 'acc_chart_of_accounts',
                            'type' => 'LEFT',
                            'conditions' => 'AccChartOfAccounts.id = AccJournalLines.acc_chart_of_account_id',
                        ],
                        'Customers' => [
                            'table' => 'customers',
                            'type' => 'INNER',
                            'conditions' => 'Customers.id = AccChartOfAccounts.customer_id',
                        ]
                    ])*/
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['priveRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelPrive) > 0 ?  $extractCOALevelPrive : [null], $filterConditionDatePrive, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['saldoDitahanRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelSaldoDitahan) > 0 ?  $extractCOALevelSaldoDitahan : [null], $filterConditionDateSaldoDitahan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['labaRugiBerjalanRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALabaRugiBerjalanId) > 0 ?  $extractCOALabaRugiBerjalanId : [null], $filterConditionDateLabaRugiBerjalan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['priveBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelPrive) > 0 ?  $extractCOALevelPrive : [null], $filterConditionDateBeforePrive, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['saldoDitahanBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelSaldoDitahan) > 0 ?  $extractCOALevelSaldoDitahan : [null], $filterConditionDateBeforeSaldoDitahan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['labaRugiBerjalanBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALabaRugiBerjalanId) > 0 ?  $extractCOALabaRugiBerjalanId : [null], $filterConditionDateBeforeLabaRugiBerjalan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $dataJournalCOA = Hash::combine($data['rows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOALabaRugiBerjalan = Hash::combine($data['labaRugiBerjalanRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOAPrive = Hash::combine($data['priveRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOASaldoDitahan = Hash::combine($data['saldoDitahanRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOABeforeLabaRugiBerjalan = Hash::combine($data['labaRugiBerjalanBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOABeforePrive = Hash::combine($data['priveBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOABeforeSaldoDitahan = Hash::combine($data['saldoDitahanBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);


                $listCOAKasBank = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAKasBank, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAKasBank);
                // pr($listCOAKasBank);

                $listCOAPiutang = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPiutang, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAPiutang);

                $listCOAAktivaTetap = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAAktivaTetap, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAAktivaTetap);

                $listCOAAkumulasiPenyusutan = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAAkumulasiPenyusutan, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAAkumulasiPenyusutan);

                //Pasiva
                $listCOAHutang = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAHutang, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAHutang);

                $listCOAHutangLancar = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAHutangLancar, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAHutangLancar);

                $listCOAModal = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAModal, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAModal);

                
                $listCOASaldoDitahan = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOASaldoDitahan, $dataJournalCOASaldoDitahan, 'debetMinuscredit');
                asort($listCOASaldoDitahan);

                $listCOAPrive = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPrive, $dataJournalCOAPrive, 'debetMinuscredit');
                asort($listCOAPrive);
                //pr($listCOAPrive);

                //Laba Rugi Berjalan
                $listCOAPendapatan = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPendapatan, $dataJournalCOALabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOAPendapatan);

                $listCOAPendapatanShow = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPendapatan, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOAPendapatanShow);
                //pr($listCOAPendapatan);

                $listCOAPendapatanLainBerjalan = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPendapatanLain, $dataJournalCOALabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOAPendapatanLainBerjalan);

                $listCOAPendapatanLain = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPendapatanLain, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOAPendapatanLain);

                $listCOAPendapatanLainShow = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPendapatanLain, $dataJournalCOALabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOAPendapatanLainShow);

                $listCOAHargaPokokPenjualan = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAHargaPokokPenjualan, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOAHargaPokokPenjualan);

                $listCOABebanLainLain = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOABebanLainLain, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABebanLainLain);

                $listCOABeban = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOABeban, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABeban);

                $listCOABebanPemasaran = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOABebanPemasaran, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABebanPemasaran);


                //Total Laba Rugi Berjalan
                $totalDetailPendapatan = $this->Krs->totalCOADetail($listCOAPendapatan);
                $grandTotalPendapatan = (empty($totalDetailPendapatan)) ? 0 : round(array_sum($totalDetailPendapatan),2);

                $totalDetailPendapatanLain = $this->Krs->totalCOADetail($listCOAPendapatanLainBerjalan);
                $grandTotalPendapatanLain = (empty($totalDetailPendapatanLain)) ? 0 : round(array_sum($totalDetailPendapatanLain),2);

                $totalDetailHargaPokokPenjualan = $this->Krs->totalCOADetail($listCOAHargaPokokPenjualan);
                $grandTotalHargaPokokPenjualan = (empty($totalDetailHargaPokokPenjualan)) ? 0 : round(array_sum($totalDetailHargaPokokPenjualan),2);

                $totalDetailBeban = $this->Krs->totalCOADetail($listCOABeban);
                $grandTotalBeban = (empty($totalDetailBeban)) ? 0 : round(array_sum($totalDetailBeban),2);

                $totalDetailBebanPemasaran = $this->Krs->totalCOADetail($listCOABebanPemasaran);
                $grandTotalBebanPemasaran = (empty($totalDetailBebanPemasaran)) ? 0 : round(array_sum($totalDetailBebanPemasaran),2);

                $totalDetailBebanLainLain = $this->Krs->totalCOADetail($listCOABebanLainLain);
                $grandTotalBebanLainLain = (empty($totalDetailBebanLainLain)) ? 0 : round(array_sum($totalDetailBebanLainLain),2);

                $totalGrandPendapatan = $grandTotalPendapatan+$grandTotalPendapatanLain;
                $totalGrandLabaKotor = $totalGrandPendapatan-$grandTotalHargaPokokPenjualan;
                $totalGrandLabaOperasional = $totalGrandLabaKotor-($grandTotalBeban+$grandTotalBebanPemasaran);
                $totalGrandLabaRugiBerjalan = $totalGrandLabaOperasional-$grandTotalBebanLainLain;

                //Before Date
                $listCOABeforeSaldoDitahan = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOASaldoDitahan, $dataJournalCOABeforeSaldoDitahan, 'debetMinuscredit');
                asort($listCOABeforeSaldoDitahan);

                $listCOABeforePrive = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPrive, $dataJournalCOABeforePrive, 'debetMinuscredit');
                asort($listCOABeforePrive);

                //Laba Rugi Berjalan sebelum
                $listCOABeforePendapatan = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPendapatan, $dataJournalCOABeforeLabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABeforePendapatan);

                $listCOABeforePendapatanLain = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAPendapatanLain, $dataJournalCOABeforeLabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABeforePendapatanLain);

                $listCOABeforeHargaPokokPenjualan = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOAHargaPokokPenjualan, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforeHargaPokokPenjualan);

                $listCOABeforeBebanLainLain = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOABebanLainLain, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforeBebanLainLain);

                $listCOABeforeBeban = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOABeban, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforeBeban);

                $listCOABeforeBebanPemasaran = $this->Krs->GetSchemaCOAShowForTrialBalance($dataCOABebanPemasaran, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforeBebanPemasaran);

                //Total Laba Rugi Berjalan
                //pr($listCOABeforePendapatanLain);

                $totalDetailBeforePendapatan = $this->Krs->totalCOADetailShow($listCOABeforePendapatan, $debetDetailBeforePendapatan, $creditDetailBeforePendapatan);
                $grandTotalBeforePendapatan = (empty($totalDetailBeforePendapatan)) ? 0 : round(array_sum($totalDetailBeforePendapatan),2);
                $grandTotalBeforeDebetPendapatan = (empty($debetDetailBeforePendapatan)) ? 0 : round(array_sum($debetDetailBeforePendapatan),2);
                $grandTotalBeforeCreditPendapatan = (empty($creditDetailBeforePendapatan)) ? 0 : round(array_sum($creditDetailBeforePendapatan),2);
                //pr($totalDetailBeforePendapatan);


                $totalDetailBeforePendapatanLain = $this->Krs->totalCOADetailShow($listCOABeforePendapatanLain, $debetDetailBeforePendapatanLain, $creditDetailBeforePendapatanLain);
                $grandTotalBeforePendapatanLain = (empty($totalDetailBeforePendapatanLain)) ? 0 : round(array_sum($totalDetailBeforePendapatanLain),2);
                $grandTotalBeforeDebetPendapatanLain = (empty($debetDetailBeforePendapatanLain)) ? 0 : round(array_sum($debetDetailBeforePendapatanLain),2);
                $grandTotalBeforeCreditPendapatanLain = (empty($creditDetailBeforePendapatanLain)) ? 0 : round(array_sum($creditDetailBeforePendapatanLain),2);

                //pr($listCOABeforeBebanLainLain);
                $totalDetailBeforeHargaPokokPenjualan = $this->Krs->totalCOADetailShow($listCOABeforeHargaPokokPenjualan, $debetDetailBeforeHargaPokokPenjualan, $creditDetailBeforeHargaPokokPenjualan);
                $grandTotalBeforeHargaPokokPenjualan = (empty($totalDetailBeforeHargaPokokPenjualan)) ? 0 : round(array_sum($totalDetailBeforeHargaPokokPenjualan),2);
                $grandTotalBeforeDebetHargaPokokPenjualan = (empty($debetDetailBeforeHargaPokokPenjualan)) ? 0 : round(array_sum($debetDetailBeforeHargaPokokPenjualan),2);
                $grandTotalBeforeCreditHargaPokokPenjualan = (empty($creditDetailBeforeHargaPokokPenjualan)) ? 0 : round(array_sum($creditDetailBeforeHargaPokokPenjualan),2);

                $totalDetailBeforeBeban = $this->Krs->totalCOADetailShow($listCOABeforeBeban, $debetDetailBeforeBeban, $creditDetailBeforeBeban);
                $grandTotalBeforeBeban = (empty($totalDetailBeforeBeban)) ? 0 : round(array_sum($totalDetailBeforeBeban),2);
                $grandTotalBeforeDebetBeban = (empty($debetDetailBeforeBeban)) ? 0 : round(array_sum($debetDetailBeforeBeban),2);
                $grandTotalBeforeCreditBeban = (empty($creditDetailBeforeBeban)) ? 0 : round(array_sum($creditDetailBeforeBeban),2);

                $totalDetailBeforeBebanPemasaran = $this->Krs->totalCOADetailShow($listCOABeforeBebanPemasaran, $debetDetailBeforeBebanPemasaran, $creditDetailBeforeBebanPemasaran);
                $grandTotalBeforeBebanPemasaran = (empty($totalDetailBeforeBebanPemasaran)) ? 0 : round(array_sum($totalDetailBeforeBebanPemasaran),2);
                $grandTotalBeforeDebetBebanPemasaran = (empty($debetDetailBeforeBebanPemasaran)) ? 0 : round(array_sum($debetDetailBeforeBebanPemasaran),2);
                $grandTotalBeforeCreditBebanPemasaran = (empty($creditDetailBeforeBebanPemasaran)) ? 0 : round(array_sum($creditDetailBeforeBebanPemasaran),2);

                $totalDetailBeforeBebanLainLain = $this->Krs->totalCOADetailShow($listCOABeforeBebanLainLain, $debetDetailBeforeBebanLainLain, $creditDetailBeforeBebanLainLain);
                $grandTotalBeforeBebanLainLain = (empty($totalDetailBeforeBebanLainLain)) ? 0 : round(array_sum($totalDetailBeforeBebanLainLain),2);
                $grandTotalBeforeDebetBebanLainLain = (empty($debetDetailBeforeBebanLainLain)) ? 0 : round(array_sum($debetDetailBeforeBebanLainLain),2);
                $grandTotalBeforeCreditBebanLainLain = (empty($creditDetailBeforeBebanLainLain)) ? 0 : round(array_sum($creditDetailBeforeBebanLainLain),2);

                // pr($listCOABeforeBebanLainLain);
                // pr($debetDetailBeforeBebanLainLain);
                // pr($creditDetailBeforeBebanLainLain);
                // pr($grandTotalBeforeDebetBebanLainLain.'-'.$grandTotalBeforeCreditBebanLainLain.'='.$grandTotalBeforeBebanLainLain);

                $totalGrandBeforePendapatan = $grandTotalBeforePendapatan+$grandTotalBeforePendapatanLain;
                $totalGrandBeforeLabaKotor = $totalGrandBeforePendapatan-$grandTotalBeforeHargaPokokPenjualan;
                $totalGrandBeforeLabaOperasional = $totalGrandBeforeLabaKotor-($grandTotalBeforeBeban+$grandTotalBeforeBebanPemasaran);
                $totalGrandBeforeLabaRugiBerjalan = $totalGrandBeforeLabaOperasional-$grandTotalBeforeBebanLainLain;

                

                $totalBeforeLabaRugiBerjalanInfo = $grandTotalBeforePendapatan.'^'.$grandTotalBeforePendapatanLain.'^'.$grandTotalBeforeHargaPokokPenjualan.'^'.$grandTotalBeforeBeban.'^'.$grandTotalBeforeBebanPemasaran.'^'.$grandTotalBeforeBebanLainLain;
                // pr($totalBeforeLabaRugiBerjalanInfo);
                // pr($totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePendapatanLain);

                $totalGrandBeforeDebetPendapatan = $grandTotalBeforeDebetPendapatan+$grandTotalBeforeDebetPendapatanLain;
                $totalGrandBeforeDebetLabaKotor = $totalGrandBeforeDebetPendapatan-$this->Krs->flipTheValue($grandTotalBeforeDebetHargaPokokPenjualan);
                $totalGrandBeforeDebetLabaOperasional = $totalGrandBeforeDebetLabaKotor-($this->Krs->flipTheValue($grandTotalBeforeDebetBeban)+$this->Krs->flipTheValue($grandTotalBeforeDebetBebanPemasaran));
                $totalGrandBeforeDebetLabaRugiBerjalan = $totalGrandBeforeDebetLabaOperasional-$this->Krs->flipTheValue($grandTotalBeforeDebetBebanLainLain);

                $totalBeforeDebetLabaRugiBerjalanInfo = $grandTotalBeforeDebetPendapatan.'^'.$grandTotalBeforeDebetPendapatanLain.'^'.$grandTotalBeforeDebetHargaPokokPenjualan.'^'.$grandTotalBeforeDebetBeban.'^'.$grandTotalBeforeDebetBebanPemasaran.'^'.$grandTotalBeforeDebetBebanLainLain;
                /*
                $totalGrandBeforeDebetPendapatan = $grandTotalBeforeDebetPendapatan+$grandTotalBeforeDebetPendapatanLain;
                $totalGrandBeforeDebetLabaKotor = $totalGrandBeforeDebetPendapatan-$grandTotalBeforeDebetHargaPokokPenjualan;
                $totalGrandBeforeDebetLabaOperasional = $totalGrandBeforeDebetLabaKotor-($grandTotalBeforeDebetBeban+$grandTotalBeforeDebetBebanPemasaran);
                */
                //$totalGrandBeforeDebetLabaRugiBerjalan = $totalGrandBeforeDebetLabaOperasional-$grandTotalBeforeDebetBebanLainLain;

                //$totalGrandBeforeDebetLabaRugiBerjalan = $grandTotalBeforeDebetPendapatan+$grandTotalBeforeDebetPendapatanLain-$grandTotalBeforeDebetHargaPokokPenjualan-($grandTotalBeforeDebetBeban+$grandTotalBeforeDebetBebanPemasaran)+$grandTotalBeforeDebetBebanLainLain;


                $totalGrandBeforeCreditPendapatan = $grandTotalBeforeCreditPendapatan+$grandTotalBeforeCreditPendapatanLain;
                $totalGrandBeforeCreditLabaKotor = $totalGrandBeforeCreditPendapatan-$this->Krs->flipTheValue($grandTotalBeforeCreditHargaPokokPenjualan);
                $totalGrandBeforeCreditLabaOperasional = $totalGrandBeforeCreditLabaKotor-($this->Krs->flipTheValue($grandTotalBeforeCreditBeban)+$this->Krs->flipTheValue($grandTotalBeforeCreditBebanPemasaran));
                
                $totalGrandBeforeCreditLabaRugiBerjalan = $totalGrandBeforeCreditLabaOperasional-$this->Krs->flipTheValue($grandTotalBeforeCreditBebanLainLain);

                $totalBeforeCreditLabaRugiBerjalanInfo = $grandTotalBeforeCreditPendapatan.'^'.$grandTotalBeforeCreditPendapatanLain.'^'.$grandTotalBeforeCreditHargaPokokPenjualan.'^'.$grandTotalBeforeCreditBeban.'^'.$grandTotalBeforeCreditBebanPemasaran.'^'.$grandTotalBeforeCreditBebanLainLain;

                $dataFilter = $this->Krs->fEncode($filterDate);

                $totalGrandLabaRugiBerjalan = 0;

                $this->set(compact('listCOAKasBank', 'listCOAPiutang', 'listCOAAktivaTetap', 'listCOAAkumulasiPenyusutan', 'listCOAHutang', 'listCOAHutangLancar', 'listCOAModal', 'listCOASaldoDitahan', 'listCOAPrive', 'listCOAPendapatanShow', 'listCOAPendapatanLain', 'listCOAHargaPokokPenjualan', 'listCOABebanLainLain', 'listCOABeban', 'listCOABebanPemasaran', 'totalGrandLabaRugiBerjalan', 'listCOABeforeSaldoDitahan', 'listCOABeforePrive', 'totalGrandBeforeLabaRugiBerjalan', 'totalGrandBeforeDebetLabaRugiBerjalan', 'totalGrandBeforeCreditLabaRugiBerjalan', 'filterDate', 'dataFilter', 'totalBeforeDebetLabaRugiBerjalanInfo', 'totalBeforeCreditLabaRugiBerjalanInfo', 'totalBeforeLabaRugiBerjalanInfo'));




                    // pr($data['rows']);
                    //,'AccChartOfAccounts'
                //"AccJournalLines.acc_chart_of_account_id IN" => $extractCOALevel, 
            // pr($data['rows']);

            $data['filterDate'] = $dataFilterDate;

            $data['show'] = 'Y';
        } else {
            $data['show'] = 'N';
        }
        $this->set(compact('accJournal', 'data'));
    }

     public function workSheetBalanceReport()
    {
        $accJournal = $this->AccJournals->newEmptyEntity();       

        if ($this->request->is('post')) {
             $this->loadModel('AccChartOfAccounts');
            $dataRow = $this->request->getData();

            $dataFilterDateFrom = $dataRow['filterDateFrom'];
            $dataFilterDateEnd = $dataRow['filterDateEnd'];
            $filterDateFrom = $this->Krs->dateTo($dataFilterDateFrom);
            $filterDateEnd = $this->Krs->dateTo($dataFilterDateEnd);

            $year = substr($filterDateFrom, 0, 4);
            $beforeDate = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year-1));
            $beforeYear = date("Y", mktime(0, 0, 0, 12, 31, $year-1));

            $filterConditionDate = ($filterDateFrom!="") ? array('DATE(AccJournals.date) BETWEEN "' . $filterDateFrom . '" AND "' . $filterDateEnd . '"'):array();
            //$filterConditionDate = ($filterDateFrom!="") ? array("AccJournals.date <="=>$filterDateFrom):array();
            
            //pr($filterDate);
            // $filterConditionDateBeforePrive = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$filterDateFrom):array();
            // $filterConditionDateBeforeSaldoDitahan = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$filterDateFrom):array();
            // $filterConditionDateBeforeLabaRugiBerjalan = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$filterDateFrom):array();

            // $filterConditionDatePrive = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateFrom):array();
            // $filterConditionDateSaldoDitahan = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateFrom):array();
            // $filterConditionDateLabaRugiBerjalan = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateFrom):array();

            // Memanggil data COA.
            $dataCOAs = $this->AccChartOfAccounts->datarowCOA(5);


            $data['rows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where([$filterConditionDate, 'AccJournals.status'=>'posting', 'AccJournals.journal_type IS NOT' => 'Adjustment'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    ->enableAutoFields(false)
                    ->toArray();

            $data['rowsAdjustment'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where([$filterConditionDate, 'AccJournals.status'=>'posting', 'AccJournals.journal_type' => 'Adjustment'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    ->enableAutoFields(false)
                    ->toArray();
            //->enableAutoFields(false) menampilkan semua kolom
            //'AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOAAktivaPasivaId) > 0 ?  $extractCOAAktivaPasivaId : [null]

            // pr($data['rows']);
               
            // pr($dataCOAs);
            $data['show'] = 'Y';

            $this->set(compact('dataCOAs'));
        } else {
            $data['show'] = 'N';
        }

        $this->set(compact('accJournal', 'data'));
    }

    public function workSheetBalanceReport230306()
    {
        $accJournal = $this->AccJournals->newEmptyEntity();
        $this->loadModel('AccChartOfAccounts');

        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();

            $dataFilterDateFrom = $dataRow['filterDateFrom'];
            $dataFilterDateEnd = $dataRow['filterDateEnd'];
            $filterDateFrom = $this->Krs->dateTo($dataFilterDateFrom);
            $filterDateEnd = $this->Krs->dateTo($dataFilterDateEnd);

            $year = substr($filterDateFrom, 0, 4);
            $beforeDate = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year-1));
            $beforeYear = date("Y", mktime(0, 0, 0, 12, 31, $year-1));

            $filterConditionDate = ($filterDateFrom!="") ? array('DATE(AccJournals.date) BETWEEN "' . $filterDateFrom . '" AND "' . $filterDateEnd . '"'):array();
            //$filterConditionDate = ($filterDateFrom!="") ? array("AccJournals.date <="=>$filterDateFrom):array();
            
            //pr($filterDate);
            $filterConditionDateBeforePrive = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$filterDateFrom):array();
            $filterConditionDateBeforeSaldoDitahan = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$filterDateFrom):array();
            $filterConditionDateBeforeLabaRugiBerjalan = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$filterDateFrom):array();

            $filterConditionDatePrive = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateFrom):array();
            $filterConditionDateSaldoDitahan = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateFrom):array();
            $filterConditionDateLabaRugiBerjalan = ($filterDateFrom!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateFrom):array();

            // Memanggil data COA.
            $dataCOAs = $this->AccChartOfAccounts->datarowCOA();             

            // Mengambil data COA Id
            // $extractCOALevel = $this->getCoaByJournal($dataCOAs, 'LR');
            
            // Mengambil Id Kas Bank
            $dataCOAKasBank = Hash::extract($dataCOAs, '{n}[journal_type=kas_bank]');
            $dataCOAKasBanks = Hash::extract($dataCOAKasBank, '{n}[level=5]');
            $extractCOALevelKasBank = (!empty($dataCOAKasBanks)) ? Hash::extract($dataCOAKasBanks, '{n}.id') : array();

            // Piutang
            $dataCOAPiutang = Hash::extract($dataCOAs, '{n}[journal_type=akun_piutang]');
            $dataCOAPiutangs = Hash::extract($dataCOAPiutang, '{n}[level=5]');
            $extractCOALevelPiutang = (!empty($dataCOAPiutangs)) ? Hash::extract($dataCOAPiutangs, '{n}.id') : array();

            // Aktiva Tetap
            $dataCOAAktivaTetap = Hash::extract($dataCOAs, '{n}[journal_type=aktiva_tetap]');
            $dataCOAAktivaTetaps = Hash::extract($dataCOAAktivaTetap, '{n}[level=5]');
            $extractCOALevelAktivaTetap = (!empty($dataCOAAktivaTetaps)) ? Hash::extract($dataCOAAktivaTetaps, '{n}.id') : array();

            // Akumulasi Penyusutan
            $dataCOAAkumulasiPenyusutan = Hash::extract($dataCOAs, '{n}[journal_type=akumulasi_penyusutan]');
            $dataCOAAkumulasiPenyusutans = Hash::extract($dataCOAAkumulasiPenyusutan, '{n}[level=5]');
            $extractCOALevelAkumulasiPenyusutan = (!empty($dataCOAAkumulasiPenyusutans)) ? Hash::extract($dataCOAAkumulasiPenyusutans, '{n}.id') : array();

            // Hutang
            $dataCOAHutang = Hash::extract($dataCOAs, '{n}[journal_type=akun_hutang]');
            $dataCOAHutangs = Hash::extract($dataCOAHutang, '{n}[level=5]');
            $extractCOALevelHutang = (!empty($dataCOAHutangs)) ? Hash::extract($dataCOAHutangs, '{n}.id') : array();

            // Hutang Lancar
            $dataCOAHutangLancar = Hash::extract($dataCOAs, '{n}[journal_type=hutang_lancar_lainnya]');
            $dataCOAHutangLancars = Hash::extract($dataCOAHutangLancar, '{n}[level=5]');
            $extractCOALevelHutangLancar = (!empty($dataCOAHutangLancars)) ? Hash::extract($dataCOAHutangLancars, '{n}.id') : array();

            // Modal
            $dataCOAModal = Hash::extract($dataCOAs, '{n}[journal_type=modal]');
            $dataCOAModals = Hash::extract($dataCOAModal, '{n}[level=5]');
            $extractCOALevelModal = (!empty($dataCOAModals)) ? Hash::extract($dataCOAModals, '{n}.id') : array();
            
            // Saldo Ditahan
            $dataCOASaldoDitahan = Hash::extract($dataCOAs, '{n}[journal_type=saldo_ditahan]');
            $dataCOASaldoDitahans = Hash::extract($dataCOASaldoDitahan, '{n}[level=5]');
            $extractCOALevelSaldoDitahan = (!empty($dataCOASaldoDitahans)) ? Hash::extract($dataCOASaldoDitahans, '{n}.id') : array();

            // Prive
            $dataCOAPrive = Hash::extract($dataCOAs, '{n}[journal_type=prive]');
            $dataCOAPrives = Hash::extract($dataCOAPrive, '{n}[level=5]');
            $extractCOALevelPrive = (!empty($dataCOAPrives)) ? Hash::extract($dataCOAPrives, '{n}.id') : array();

            $extractCOAAktivaPasivaId = array_merge($extractCOALevelKasBank, $extractCOALevelPiutang, $extractCOALevelAktivaTetap, $extractCOALevelAkumulasiPenyusutan, $extractCOALevelHutang, $extractCOALevelHutangLancar, $extractCOALevelModal, $extractCOALevelSaldoDitahan, $extractCOALevelPrive);

            // Laba/Rugi Berjalan
            // Pendapatan
            $dataCOAPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan]');
            $dataCOAPendapatans = Hash::extract($dataCOAPendapatan, '{n}[level=5]');
            $extractCOALevelPendapatan = (!empty($dataCOAPendapatans)) ? Hash::extract($dataCOAPendapatans, '{n}.id') : array();

            // Pendapatan Lain
            $dataCOAPendapatanLain = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan_lain]');
            $dataCOAPendapatanLains = Hash::extract($dataCOAPendapatanLain, '{n}[level=5]');
            $extractCOALevelPendapatanLain = (!empty($dataCOAPendapatanLains)) ? Hash::extract($dataCOAPendapatanLains, '{n}.id') : array();

            // Harga Pokok Penjualan
            $dataCOAHargaPokokPenjualan = Hash::extract($dataCOAs, '{n}[journal_type=harga_pokok_penjualan]');
            $dataCOAHargaPokokPenjualans = Hash::extract($dataCOAHargaPokokPenjualan, '{n}[level=5]');
            $extractCOALevelHargaPokokPenjualan = (!empty($dataCOAHargaPokokPenjualans)) ? Hash::extract($dataCOAHargaPokokPenjualans, '{n}.id') : array();

            // Beban Lain Lain
            $dataCOABebanLainLain = Hash::extract($dataCOAs, '{n}[journal_type=beban_lain_lain]');
            $dataCOABebanLainLains = Hash::extract($dataCOABebanLainLain, '{n}[level=5]');
            $extractCOALevelBebanLainLain = (!empty($dataCOABebanLainLains)) ? Hash::extract($dataCOABebanLainLains, '{n}.id') : array();

            // Beban
            $dataCOABeban = Hash::extract($dataCOAs, '{n}[journal_type=beban]');
            $dataCOABebans = Hash::extract($dataCOABeban, '{n}[level=5]');
            $extractCOALevelBeban = (!empty($dataCOABebans)) ? Hash::extract($dataCOABebans, '{n}.id') : array();

            // Beban Pemasaran
            $dataCOABebanPemasaran = Hash::extract($dataCOAs, '{n}[journal_type=beban_pemasaran]');
            $dataCOABebanPemasarans = Hash::extract($dataCOABebanPemasaran, '{n}[level=5]');
            $extractCOALevelBebanPemasaran = (!empty($dataCOABebanPemasarans)) ? Hash::extract($dataCOABebanPemasarans, '{n}.id') : array();

            $extractCOALabaRugiBerjalanId = array_merge($extractCOALevelPendapatan, $extractCOALevelPendapatanLain, $extractCOALevelHargaPokokPenjualan, $extractCOALevelBebanLainLain, $extractCOALevelBeban, $extractCOALevelBebanPemasaran);

            $filterDateJournal = (empty($filterDateFrom)) ? array() : array("AccJournals.date <=" => $filterDateFrom);

            $data['rows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOAAktivaPasivaId) > 0 ?  $extractCOAAktivaPasivaId : [null], $filterDateJournal, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])

                    // ->order(['AccChartOfAccounts.lft'=>'ASC', 'AccChartOfAccounts.rght'=>'ASC'])
                    // ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    /*->join([
                        'AccJournalLines' => [
                            'table' => 'acc_journal_lines',
                            'type' => 'LEFT',
                            'conditions' => 'AccJournalLines.acc_journal_id = AccJournals.id',
                        ],
                        'AccChartOfAccounts' => [
                            'table' => 'acc_chart_of_accounts',
                            'type' => 'LEFT',
                            'conditions' => 'AccChartOfAccounts.id = AccJournalLines.acc_chart_of_account_id',
                        ],
                        'Customers' => [
                            'table' => 'customers',
                            'type' => 'INNER',
                            'conditions' => 'Customers.id = AccChartOfAccounts.customer_id',
                        ]
                    ])*/
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['priveRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelPrive) > 0 ?  $extractCOALevelPrive : [null], $filterConditionDatePrive, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['saldoDitahanRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelSaldoDitahan) > 0 ?  $extractCOALevelSaldoDitahan : [null], $filterConditionDateSaldoDitahan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['labaRugiBerjalanRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALabaRugiBerjalanId) > 0 ?  $extractCOALabaRugiBerjalanId : [null], $filterConditionDateLabaRugiBerjalan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['priveBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelPrive) > 0 ?  $extractCOALevelPrive : [null], $filterConditionDateBeforePrive, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['saldoDitahanBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelSaldoDitahan) > 0 ?  $extractCOALevelSaldoDitahan : [null], $filterConditionDateBeforeSaldoDitahan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $data['labaRugiBerjalanBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALabaRugiBerjalanId) > 0 ?  $extractCOALabaRugiBerjalanId : [null], $filterConditionDateBeforeLabaRugiBerjalan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    //->innerJoinWith('AccChartOfAccounts')
                    ->enableAutoFields(true)
                    ->toArray();

                $dataJournalCOA = Hash::combine($data['rows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOALabaRugiBerjalan = Hash::combine($data['labaRugiBerjalanRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOAPrive = Hash::combine($data['priveRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOASaldoDitahan = Hash::combine($data['saldoDitahanRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOABeforeLabaRugiBerjalan = Hash::combine($data['labaRugiBerjalanBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOABeforePrive = Hash::combine($data['priveBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
                $dataJournalCOABeforeSaldoDitahan = Hash::combine($data['saldoDitahanBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);


                $listCOAKasBank = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAKasBank, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAKasBank);
                // pr($listCOAKasBank);

                $listCOAPiutang = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPiutang, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAPiutang);

                $listCOAAktivaTetap = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAAktivaTetap, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAAktivaTetap);

                $listCOAAkumulasiPenyusutan = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAAkumulasiPenyusutan, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAAkumulasiPenyusutan);

                //Pasiva
                $listCOAHutang = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAHutang, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAHutang);

                $listCOAHutangLancar = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAHutangLancar, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAHutangLancar);

                $listCOAModal = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAModal, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAModal);

                
                $listCOASaldoDitahan = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOASaldoDitahan, $dataJournalCOASaldoDitahan, 'debetMinuscredit');
                asort($listCOASaldoDitahan);

                $listCOAPrive = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPrive, $dataJournalCOAPrive, 'debetMinuscredit');
                asort($listCOAPrive);
                //pr($listCOAPrive);

                //Laba Rugi Berjalan
                $listCOAPendapatan = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPendapatan, $dataJournalCOALabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOAPendapatan);

                $listCOAPendapatanShow = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPendapatan, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOAPendapatanShow);
                //pr($listCOAPendapatan);

                $listCOAPendapatanLainBerjalan = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPendapatanLain, $dataJournalCOALabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOAPendapatanLainBerjalan);

                $listCOAPendapatanLain = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPendapatanLain, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOAPendapatanLain);

                $listCOAPendapatanLainShow = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPendapatanLain, $dataJournalCOALabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOAPendapatanLainShow);

                $listCOAHargaPokokPenjualan = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAHargaPokokPenjualan, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOAHargaPokokPenjualan);

                $listCOABebanLainLain = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOABebanLainLain, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABebanLainLain);

                $listCOABeban = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOABeban, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABeban);

                $listCOABebanPemasaran = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOABebanPemasaran, $dataJournalCOALabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABebanPemasaran);


                //Total Laba Rugi Berjalan
                $totalDetailPendapatan = $this->Krs->totalCOADetail($listCOAPendapatan);
                $grandTotalPendapatan = (empty($totalDetailPendapatan)) ? 0 : round(array_sum($totalDetailPendapatan),2);

                $totalDetailPendapatanLain = $this->Krs->totalCOADetail($listCOAPendapatanLainBerjalan);
                $grandTotalPendapatanLain = (empty($totalDetailPendapatanLain)) ? 0 : round(array_sum($totalDetailPendapatanLain),2);

                $totalDetailHargaPokokPenjualan = $this->Krs->totalCOADetail($listCOAHargaPokokPenjualan);
                $grandTotalHargaPokokPenjualan = (empty($totalDetailHargaPokokPenjualan)) ? 0 : round(array_sum($totalDetailHargaPokokPenjualan),2);

                $totalDetailBeban = $this->Krs->totalCOADetail($listCOABeban);
                $grandTotalBeban = (empty($totalDetailBeban)) ? 0 : round(array_sum($totalDetailBeban),2);

                $totalDetailBebanPemasaran = $this->Krs->totalCOADetail($listCOABebanPemasaran);
                $grandTotalBebanPemasaran = (empty($totalDetailBebanPemasaran)) ? 0 : round(array_sum($totalDetailBebanPemasaran),2);

                $totalDetailBebanLainLain = $this->Krs->totalCOADetail($listCOABebanLainLain);
                $grandTotalBebanLainLain = (empty($totalDetailBebanLainLain)) ? 0 : round(array_sum($totalDetailBebanLainLain),2);

                $totalGrandPendapatan = $grandTotalPendapatan+$grandTotalPendapatanLain;
                $totalGrandLabaKotor = $totalGrandPendapatan-$grandTotalHargaPokokPenjualan;
                $totalGrandLabaOperasional = $totalGrandLabaKotor-($grandTotalBeban+$grandTotalBebanPemasaran);
                $totalGrandLabaRugiBerjalan = $totalGrandLabaOperasional-$grandTotalBebanLainLain;

                //Before Date
                $listCOABeforeSaldoDitahan = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOASaldoDitahan, $dataJournalCOABeforeSaldoDitahan, 'debetMinuscredit');
                asort($listCOABeforeSaldoDitahan);

                $listCOABeforePrive = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPrive, $dataJournalCOABeforePrive, 'debetMinuscredit');
                asort($listCOABeforePrive);

                //Laba Rugi Berjalan sebelum
                $listCOABeforePendapatan = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPendapatan, $dataJournalCOABeforeLabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABeforePendapatan);

                $listCOABeforePendapatanLain = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAPendapatanLain, $dataJournalCOABeforeLabaRugiBerjalan, 'debetMinuscredit');
                asort($listCOABeforePendapatanLain);

                $listCOABeforeHargaPokokPenjualan = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOAHargaPokokPenjualan, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforeHargaPokokPenjualan);

                $listCOABeforeBebanLainLain = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOABebanLainLain, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforeBebanLainLain);

                $listCOABeforeBeban = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOABeban, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforeBeban);

                $listCOABeforeBebanPemasaran = $this->Krs->GetSchemaCOAShowForTrialBalanceWorkSheet($dataCOABebanPemasaran, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforeBebanPemasaran);

                //Total Laba Rugi Berjalan
                //pr($listCOABeforePendapatanLain);

                $totalDetailBeforePendapatan = $this->Krs->totalCOADetailShow($listCOABeforePendapatan, $debetDetailBeforePendapatan, $creditDetailBeforePendapatan);
                $grandTotalBeforePendapatan = (empty($totalDetailBeforePendapatan)) ? 0 : round(array_sum($totalDetailBeforePendapatan),2);
                $grandTotalBeforeDebetPendapatan = (empty($debetDetailBeforePendapatan)) ? 0 : round(array_sum($debetDetailBeforePendapatan),2);
                $grandTotalBeforeCreditPendapatan = (empty($creditDetailBeforePendapatan)) ? 0 : round(array_sum($creditDetailBeforePendapatan),2);
                //pr($totalDetailBeforePendapatan);


                $totalDetailBeforePendapatanLain = $this->Krs->totalCOADetailShow($listCOABeforePendapatanLain, $debetDetailBeforePendapatanLain, $creditDetailBeforePendapatanLain);
                $grandTotalBeforePendapatanLain = (empty($totalDetailBeforePendapatanLain)) ? 0 : round(array_sum($totalDetailBeforePendapatanLain),2);
                $grandTotalBeforeDebetPendapatanLain = (empty($debetDetailBeforePendapatanLain)) ? 0 : round(array_sum($debetDetailBeforePendapatanLain),2);
                $grandTotalBeforeCreditPendapatanLain = (empty($creditDetailBeforePendapatanLain)) ? 0 : round(array_sum($creditDetailBeforePendapatanLain),2);

                //pr($listCOABeforeBebanLainLain);
                $totalDetailBeforeHargaPokokPenjualan = $this->Krs->totalCOADetailShow($listCOABeforeHargaPokokPenjualan, $debetDetailBeforeHargaPokokPenjualan, $creditDetailBeforeHargaPokokPenjualan);
                $grandTotalBeforeHargaPokokPenjualan = (empty($totalDetailBeforeHargaPokokPenjualan)) ? 0 : round(array_sum($totalDetailBeforeHargaPokokPenjualan),2);
                $grandTotalBeforeDebetHargaPokokPenjualan = (empty($debetDetailBeforeHargaPokokPenjualan)) ? 0 : round(array_sum($debetDetailBeforeHargaPokokPenjualan),2);
                $grandTotalBeforeCreditHargaPokokPenjualan = (empty($creditDetailBeforeHargaPokokPenjualan)) ? 0 : round(array_sum($creditDetailBeforeHargaPokokPenjualan),2);

                $totalDetailBeforeBeban = $this->Krs->totalCOADetailShow($listCOABeforeBeban, $debetDetailBeforeBeban, $creditDetailBeforeBeban);
                $grandTotalBeforeBeban = (empty($totalDetailBeforeBeban)) ? 0 : round(array_sum($totalDetailBeforeBeban),2);
                $grandTotalBeforeDebetBeban = (empty($debetDetailBeforeBeban)) ? 0 : round(array_sum($debetDetailBeforeBeban),2);
                $grandTotalBeforeCreditBeban = (empty($creditDetailBeforeBeban)) ? 0 : round(array_sum($creditDetailBeforeBeban),2);

                $totalDetailBeforeBebanPemasaran = $this->Krs->totalCOADetailShow($listCOABeforeBebanPemasaran, $debetDetailBeforeBebanPemasaran, $creditDetailBeforeBebanPemasaran);
                $grandTotalBeforeBebanPemasaran = (empty($totalDetailBeforeBebanPemasaran)) ? 0 : round(array_sum($totalDetailBeforeBebanPemasaran),2);
                $grandTotalBeforeDebetBebanPemasaran = (empty($debetDetailBeforeBebanPemasaran)) ? 0 : round(array_sum($debetDetailBeforeBebanPemasaran),2);
                $grandTotalBeforeCreditBebanPemasaran = (empty($creditDetailBeforeBebanPemasaran)) ? 0 : round(array_sum($creditDetailBeforeBebanPemasaran),2);

                $totalDetailBeforeBebanLainLain = $this->Krs->totalCOADetailShow($listCOABeforeBebanLainLain, $debetDetailBeforeBebanLainLain, $creditDetailBeforeBebanLainLain);
                $grandTotalBeforeBebanLainLain = (empty($totalDetailBeforeBebanLainLain)) ? 0 : round(array_sum($totalDetailBeforeBebanLainLain),2);
                $grandTotalBeforeDebetBebanLainLain = (empty($debetDetailBeforeBebanLainLain)) ? 0 : round(array_sum($debetDetailBeforeBebanLainLain),2);
                $grandTotalBeforeCreditBebanLainLain = (empty($creditDetailBeforeBebanLainLain)) ? 0 : round(array_sum($creditDetailBeforeBebanLainLain),2);

                // pr($listCOABeforeBebanLainLain);
                // pr($debetDetailBeforeBebanLainLain);
                // pr($creditDetailBeforeBebanLainLain);
                // pr($grandTotalBeforeDebetBebanLainLain.'-'.$grandTotalBeforeCreditBebanLainLain.'='.$grandTotalBeforeBebanLainLain);

                $totalGrandBeforePendapatan = $grandTotalBeforePendapatan+$grandTotalBeforePendapatanLain;
                $totalGrandBeforeLabaKotor = $totalGrandBeforePendapatan-$grandTotalBeforeHargaPokokPenjualan;
                $totalGrandBeforeLabaOperasional = $totalGrandBeforeLabaKotor-($grandTotalBeforeBeban+$grandTotalBeforeBebanPemasaran);
                $totalGrandBeforeLabaRugiBerjalan = $totalGrandBeforeLabaOperasional-$grandTotalBeforeBebanLainLain;

                

                $totalBeforeLabaRugiBerjalanInfo = $grandTotalBeforePendapatan.'^'.$grandTotalBeforePendapatanLain.'^'.$grandTotalBeforeHargaPokokPenjualan.'^'.$grandTotalBeforeBeban.'^'.$grandTotalBeforeBebanPemasaran.'^'.$grandTotalBeforeBebanLainLain;
                // pr($totalBeforeLabaRugiBerjalanInfo);
                // pr($totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePendapatanLain);

                $totalGrandBeforeDebetPendapatan = $grandTotalBeforeDebetPendapatan+$grandTotalBeforeDebetPendapatanLain;
                $totalGrandBeforeDebetLabaKotor = $totalGrandBeforeDebetPendapatan-$this->Krs->flipTheValue($grandTotalBeforeDebetHargaPokokPenjualan);
                $totalGrandBeforeDebetLabaOperasional = $totalGrandBeforeDebetLabaKotor-($this->Krs->flipTheValue($grandTotalBeforeDebetBeban)+$this->Krs->flipTheValue($grandTotalBeforeDebetBebanPemasaran));
                $totalGrandBeforeDebetLabaRugiBerjalan = $totalGrandBeforeDebetLabaOperasional-$this->Krs->flipTheValue($grandTotalBeforeDebetBebanLainLain);

                $totalBeforeDebetLabaRugiBerjalanInfo = $grandTotalBeforeDebetPendapatan.'^'.$grandTotalBeforeDebetPendapatanLain.'^'.$grandTotalBeforeDebetHargaPokokPenjualan.'^'.$grandTotalBeforeDebetBeban.'^'.$grandTotalBeforeDebetBebanPemasaran.'^'.$grandTotalBeforeDebetBebanLainLain;
                /*
                $totalGrandBeforeDebetPendapatan = $grandTotalBeforeDebetPendapatan+$grandTotalBeforeDebetPendapatanLain;
                $totalGrandBeforeDebetLabaKotor = $totalGrandBeforeDebetPendapatan-$grandTotalBeforeDebetHargaPokokPenjualan;
                $totalGrandBeforeDebetLabaOperasional = $totalGrandBeforeDebetLabaKotor-($grandTotalBeforeDebetBeban+$grandTotalBeforeDebetBebanPemasaran);
                */
                //$totalGrandBeforeDebetLabaRugiBerjalan = $totalGrandBeforeDebetLabaOperasional-$grandTotalBeforeDebetBebanLainLain;

                //$totalGrandBeforeDebetLabaRugiBerjalan = $grandTotalBeforeDebetPendapatan+$grandTotalBeforeDebetPendapatanLain-$grandTotalBeforeDebetHargaPokokPenjualan-($grandTotalBeforeDebetBeban+$grandTotalBeforeDebetBebanPemasaran)+$grandTotalBeforeDebetBebanLainLain;


                $totalGrandBeforeCreditPendapatan = $grandTotalBeforeCreditPendapatan+$grandTotalBeforeCreditPendapatanLain;
                $totalGrandBeforeCreditLabaKotor = $totalGrandBeforeCreditPendapatan-$this->Krs->flipTheValue($grandTotalBeforeCreditHargaPokokPenjualan);
                $totalGrandBeforeCreditLabaOperasional = $totalGrandBeforeCreditLabaKotor-($this->Krs->flipTheValue($grandTotalBeforeCreditBeban)+$this->Krs->flipTheValue($grandTotalBeforeCreditBebanPemasaran));
                
                $totalGrandBeforeCreditLabaRugiBerjalan = $totalGrandBeforeCreditLabaOperasional-$this->Krs->flipTheValue($grandTotalBeforeCreditBebanLainLain);

                $totalBeforeCreditLabaRugiBerjalanInfo = $grandTotalBeforeCreditPendapatan.'^'.$grandTotalBeforeCreditPendapatanLain.'^'.$grandTotalBeforeCreditHargaPokokPenjualan.'^'.$grandTotalBeforeCreditBeban.'^'.$grandTotalBeforeCreditBebanPemasaran.'^'.$grandTotalBeforeCreditBebanLainLain;

                $dataFilter = $this->Krs->fEncode($filterDate);

                $totalGrandLabaRugiBerjalan = 0;

                $this->set(compact('listCOAKasBank', 'listCOAPiutang', 'listCOAAktivaTetap', 'listCOAAkumulasiPenyusutan', 'listCOAHutang', 'listCOAHutangLancar', 'listCOAModal', 'listCOASaldoDitahan', 'listCOAPrive', 'listCOAPendapatanShow', 'listCOAPendapatanLain', 'listCOAHargaPokokPenjualan', 'listCOABebanLainLain', 'listCOABeban', 'listCOABebanPemasaran', 'totalGrandLabaRugiBerjalan', 'listCOABeforeSaldoDitahan', 'listCOABeforePrive', 'totalGrandBeforeLabaRugiBerjalan', 'totalGrandBeforeDebetLabaRugiBerjalan', 'totalGrandBeforeCreditLabaRugiBerjalan', 'filterDate', 'dataFilter', 'totalBeforeDebetLabaRugiBerjalanInfo', 'totalBeforeCreditLabaRugiBerjalanInfo', 'totalBeforeLabaRugiBerjalanInfo'));




                    // pr($data['rows']);
                    //,'AccChartOfAccounts'
                //"AccJournalLines.acc_chart_of_account_id IN" => $extractCOALevel, 
            // pr($data['rows']);

            $data['filterDate'] = $dataFilterDate;

            $data['show'] = 'Y';
        } else {
            $data['show'] = 'N';
        }
        $this->set(compact('accJournal', 'data'));
    }

    

    //Saldo Ditahan sebelumnya
    public function rowSaldoDitahan($filterDate='', &$grandTotalBeforeSaldoDitahan=null, &$grandTotalBeforePrive=null, &$totalGrandBeforeLabaRugiBerjalan=null) {
                    
        $year = substr($filterDate, 0, 4);
        $beforeDate = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year-2));
        $beforeYear = date("Y", mktime(0, 0, 0, 12, 31, $year-2));
        $beforeYearDitahan = date("Y", mktime(0, 0, 0, 12, 31, $year-1));
        
        $filterConditionDate = ($filterDate!="") ? array("AccJournals.date <="=>$filterDate):array();
        //pr($filterDate);

        $filterConditionDateBeforePrive = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$beforeDate):array();
        //$filterConditionDateBeforeSaldoDitahan = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>'2021', "AccJournals.date <="=>$beforeDate):array();
        $filterConditionDateBeforeSaldoDitahan = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$beforeDate):array();
        $filterConditionDateBeforeLabaRugiBerjalan = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$beforeDate):array();

        $filterConditionDatePrive = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();
        $filterConditionDateSaldoDitahan = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();
        $filterConditionDateLabaRugiBerjalan = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();
        //pr($filterConditionDateBeforePrive);
        // Memanggil data COA.
        $dataCOAs = $this->AccChartOfAccounts->datarowCOA(); 

        // Aktiva Tetap
        $dataCOAAktivaTetap = Hash::extract($dataCOAs, '{n}[journal_type=aktiva_tetap]');
        $dataCOAAktivaTetaps = Hash::extract($dataCOAAktivaTetap, '{n}[level=5]');
        $extractCOALevelAktivaTetap = (!empty($dataCOAAktivaTetaps)) ? Hash::extract($dataCOAAktivaTetaps, '{n}.id') : array();

        // Saldo Ditahan
        $dataCOASaldoDitahan = Hash::extract($dataCOAs, '{n}[journal_type=saldo_ditahan]');
        $dataCOASaldoDitahans = Hash::extract($dataCOASaldoDitahan, '{n}[level=5]');
        $extractCOALevelSaldoDitahan = (!empty($dataCOASaldoDitahans)) ? Hash::extract($dataCOASaldoDitahans, '{n}.id') : array();

        // Prive
        $dataCOAPrive = Hash::extract($dataCOAs, '{n}[journal_type=prive]');
        $dataCOAPrives = Hash::extract($dataCOAPrive, '{n}[level=5]');
        $extractCOALevelPrive = (!empty($dataCOAPrives)) ? Hash::extract($dataCOAPrives, '{n}.id') : array();

        // Laba/Rugi Berjalan
        // Pendapatan
        $dataCOAPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan]');
        $dataCOAPendapatans = Hash::extract($dataCOAPendapatan, '{n}[level=5]');
        $extractCOALevelPendapatan = (!empty($dataCOAPendapatans)) ? Hash::extract($dataCOAPendapatans, '{n}.id') : array();

        // Pendapatan Lain
        $dataCOAPendapatanLain = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan_lain]');
        $dataCOAPendapatanLains = Hash::extract($dataCOAPendapatanLain, '{n}[level=5]');
        $extractCOALevelPendapatanLain = (!empty($dataCOAPendapatanLains)) ? Hash::extract($dataCOAPendapatanLains, '{n}.id') : array();

        // Harga Pokok Penjualan
        $dataCOAHargaPokokPenjualan = Hash::extract($dataCOAs, '{n}[journal_type=harga_pokok_penjualan]');
        $dataCOAHargaPokokPenjualans = Hash::extract($dataCOAHargaPokokPenjualan, '{n}[level=5]');
        $extractCOALevelHargaPokokPenjualan = (!empty($dataCOAHargaPokokPenjualans)) ? Hash::extract($dataCOAHargaPokokPenjualans, '{n}.id') : array();

        // Beban Lain Lain
        $dataCOABebanLainLain = Hash::extract($dataCOAs, '{n}[journal_type=beban_lain_lain]');
        $dataCOABebanLainLains = Hash::extract($dataCOABebanLainLain, '{n}[level=5]');
        $extractCOALevelBebanLainLain = (!empty($dataCOABebanLainLains)) ? Hash::extract($dataCOABebanLainLains, '{n}.id') : array();

        // Beban
        $dataCOABeban = Hash::extract($dataCOAs, '{n}[journal_type=beban]');
        $dataCOABebans = Hash::extract($dataCOABeban, '{n}[level=5]');
        $extractCOALevelBeban = (!empty($dataCOABebans)) ? Hash::extract($dataCOABebans, '{n}.id') : array();

        // Beban Pemasaran
        $dataCOABebanPemasaran = Hash::extract($dataCOAs, '{n}[journal_type=beban_pemasaran]');
        $dataCOABebanPemasarans = Hash::extract($dataCOABebanPemasaran, '{n}[level=5]');
        $extractCOALevelBebanPemasaran = (!empty($dataCOABebanPemasarans)) ? Hash::extract($dataCOABebanPemasarans, '{n}.id') : array();

        $extractCOALabaRugiBerjalanId = array_merge($extractCOALevelPendapatan, $extractCOALevelPendapatanLain, $extractCOALevelHargaPokokPenjualan, $extractCOALevelBebanLainLain, $extractCOALevelBeban, $extractCOALevelBebanPemasaran);

        //, $extractCOALevelPiutangUsaha

        // --- PASIVA ---
        $data['priveBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelPrive) > 0 ?  $extractCOALevelPrive : [null], $filterConditionDateBeforePrive, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    ->enableAutoFields(true)
                    ->toArray();

        $data['saldoDitahanBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelSaldoDitahan) > 0 ?  $extractCOALevelSaldoDitahan : [null], $filterConditionDateBeforeSaldoDitahan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    ->enableAutoFields(true)
                    ->toArray();

        $data['labaRugiBerjalanBeforeRows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALabaRugiBerjalanId) > 0 ?  $extractCOALabaRugiBerjalanId : [null], $filterConditionDateBeforeLabaRugiBerjalan, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    ->enableAutoFields(true)
                    ->toArray();

        $dataJournalCOABeforeLabaRugiBerjalan = Hash::combine($data['labaRugiBerjalanBeforeRows'], '{n}.coaId',['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
        $dataJournalCOABeforePrive = Hash::combine($data['priveBeforeRows'], '{n}.coaId',['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
        $dataJournalCOABeforeSaldoDitahan = Hash::combine($data['saldoDitahanBeforeRows'], '{n}.coaId',['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);

        //Before Date
        //pr($dataCOASaldoDitahan);
        //pr($dataJournalCOABeforeSaldoDitahan);
        $listCOABeforeSaldoDitahan = $this->Krs->GetSchemaCOAShow($dataCOASaldoDitahan, $dataJournalCOABeforeSaldoDitahan, 'debetMinuscredit', true);
        asort($listCOABeforeSaldoDitahan);

        $listCOABeforePrive = $this->Krs->GetSchemaCOAShow($dataCOAPrive, $dataJournalCOABeforePrive, 'debetMinuscredit', true);
        asort($listCOABeforePrive);

        //Laba Rugi Berjalan
        $listCOABeforePendapatan = $this->Krs->GetSchemaCOAShow($dataCOAPendapatan, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
        asort($listCOABeforePendapatan);
        //pr($listCOABeforePendapatan);

        $listCOABeforePendapatanLain = $this->Krs->GetSchemaCOAShow($dataCOAPendapatanLain, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
        asort($listCOABeforePendapatanLain);

        $listCOABeforeHargaPokokPenjualan = $this->Krs->GetSchemaCOAShow($dataCOAHargaPokokPenjualan, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
        asort($listCOABeforeHargaPokokPenjualan);

        $listCOABeforeBebanLainLain = $this->Krs->GetSchemaCOAShow($dataCOABebanLainLain, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
        asort($listCOABeforeBebanLainLain);

        $listCOABeforeBeban = $this->Krs->GetSchemaCOAShow($dataCOABeban, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
        asort($listCOABeforeBeban);

        $listCOABeforeBebanPemasaran = $this->Krs->GetSchemaCOAShow($dataCOABebanPemasaran, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
        asort($listCOABeforeBebanPemasaran);

        //pr($listCOABeforeBebanPemasaran);

        //Total Laba Rugi Berjalan
        $totalDetailBeforePendapatan = $this->Krs->totalCOADetail($listCOABeforePendapatan);
        $grandTotalBeforePendapatan = (empty($totalDetailBeforePendapatan)) ? 0 : round(array_sum($totalDetailBeforePendapatan),2);

        $totalDetailBeforePendapatanLain = $this->Krs->totalCOADetail($listCOABeforePendapatanLain);
        $grandTotalBeforePendapatanLain = (empty($totalDetailBeforePendapatanLain)) ? 0 : round(array_sum($totalDetailBeforePendapatanLain),2);

        $totalDetailBeforeHargaPokokPenjualan = $this->Krs->totalCOADetail($listCOABeforeHargaPokokPenjualan);
        $grandTotalBeforeHargaPokokPenjualan = (empty($totalDetailBeforeHargaPokokPenjualan)) ? 0 : round(array_sum($totalDetailBeforeHargaPokokPenjualan),2);

        $totalDetailBeforeBeban = $this->Krs->totalCOADetail($listCOABeforeBeban);
        $grandTotalBeforeBeban = (empty($totalDetailBeforeBeban)) ? 0 : round(array_sum($totalDetailBeforeBeban),2);

        $totalDetailBeforeBebanPemasaran = $this->Krs->totalCOADetail($listCOABeforeBebanPemasaran);
        $grandTotalBeforeBebanPemasaran = (empty($totalDetailBeforeBebanPemasaran)) ? 0 : round(array_sum($totalDetailBeforeBebanPemasaran),2);

        $totalDetailBeforeBebanLainLain = $this->Krs->totalCOADetail($listCOABeforeBebanLainLain);
        $grandTotalBeforeBebanLainLain = (empty($totalDetailBeforeBebanLainLain)) ? 0 : round(array_sum($totalDetailBeforeBebanLainLain),2);

        $totalGrandBeforePendapatan = $grandTotalBeforePendapatan+$grandTotalBeforePendapatanLain;
        $totalGrandBeforeLabaKotor = $totalGrandBeforePendapatan-$grandTotalBeforeHargaPokokPenjualan;
        $totalGrandBeforeLabaOperasional = $totalGrandBeforeLabaKotor-($grandTotalBeforeBeban+$grandTotalBeforeBebanPemasaran);
        $totalGrandBeforeLabaRugiBerjalan = $totalGrandBeforeLabaOperasional-$grandTotalBeforeBebanLainLain;
        //pr($totalGrandBeforeLabaOperasional.'-'.$grandTotalBeforeBebanLainLain);
        //pr($totalGrandBeforeLabaKotor.'-'.$grandTotalBeforeBeban.'+'.$grandTotalBeforeBebanPemasaran);

        $grandTotalSaldoDitahans = array();
        foreach ($listCOABeforeSaldoDitahan as $idBeforeSaldoDitahan => $detailBeforeSaldoDitahan) {
            if(isset($detailBeforeSaldoDitahan['Level5']) && $detailBeforeSaldoDitahan['Level5']) {
                $debetCreditDetailBeforeSaldoDitahans = array();
                foreach ($detailBeforeSaldoDitahan['Level5'] as $dataCOABeforeSaldoDitahan) {
                    list($codeDetailBeforeSaldoDitahan, $nameDetailBeforeSaldoDitahan, $debetCreditDetailBeforeSaldoDitahan, $beginningBalanceDetailBeforeSaldoDitahan, $subTotalDetailBeforeSaldoDitahan) = explode('^', $dataCOABeforeSaldoDitahan);
                    $debetCreditDetailBeforeSaldoDitahans[] = $subTotalDetailBeforeSaldoDitahan;
                }
            }

            if(isset($detailBeforeSaldoDitahan['Level5']) && $detailBeforeSaldoDitahan['Level4']) {
                list($codeBeforeSaldoDitahan, $nameBeforeSaldoDitahan) = explode('^', $detailBeforeSaldoDitahan['Level4']);

                if(!empty($codeBeforeSaldoDitahan)) {
                    $totalLevel4BeforeSaldoDitahan = array_sum($debetCreditDetailBeforeSaldoDitahans);
                    $grandTotalBeforeSaldoDitahans[] = $totalLevel4BeforeSaldoDitahan;          
                }
            }
        }
        //pr($listCOABeforeSaldoDitahan);
        //pr($grandTotalBeforeSaldoDitahans);
        $grandTotalBeforeSaldoDitahan = (empty($grandTotalBeforeSaldoDitahans)) ? 0 : round(array_sum($grandTotalBeforeSaldoDitahans),2);

        $grandTotalBeforePrives = array();
        foreach ($listCOABeforePrive as $idBeforePrive => $detailBeforePrive) {
            if(isset($detailBeforePrive['Level5']) && $detailBeforePrive['Level5']) {
                $debetCreditDetailBeforePrives = array();
                foreach ($detailBeforePrive['Level5'] as $dataCOABeforePrive) {
                    list($codeDetailBeforePrive, $nameDetailBeforePrive, $debetCreditDetailBeforePrive, $beginningBalanceDetailBeforePrive, $subTotalDetailBeforePrive) = explode('^', $dataCOABeforePrive);
                    $debetCreditDetailBeforePrives[] = $subTotalDetailBeforePrive;
                }
            }

            if(isset($detailBeforePrive['Level5']) && $detailBeforePrive['Level4']) {
                list($codeBeforePrive, $nameBeforePrive) = explode('^', $detailBeforePrive['Level4']);

                if(!empty($codeBeforePrive)) {
                    $totalLevel4BeforePrive = array_sum($debetCreditDetailBeforePrives);
                    $grandTotalBeforePrives[] = $totalLevel4BeforePrive;            
                }
            }
        }
        $grandTotalBeforePrive = (empty($grandTotalBeforePrives)) ? 0 : round(array_sum($grandTotalBeforePrives),2);
        $resultBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$grandTotalBeforePrive+$totalGrandBeforeLabaRugiBerjalan;
        //pr($grandTotalBeforeSaldoDitahan.'+'.$grandTotalBeforePrive.'+'.$totalGrandBeforeLabaRugiBerjalan);
        return $resultBeforeSaldoDitahan;

    }


    public function addCart() {
        $session = $this->request->getSession();
        $session = $this->request->getAttribute('session');

        //$sessionCart = $session->read('JurnalCart');
        $condData = $this->request->getQuery('cond');
        $jsonData = $this->request->getQuery('dataCart');
        $idData = $this->request->getQuery('idData');

        $idDataGrids = $session->read('Config');
        $idDataGrid = $idDataGrids['time'];

        if($condData=='add' && !empty($jsonData)) {
            $jsonDecode = json_decode(base64_decode(urldecode(base64_decode($jsonData))));
            $session->write('JurnalCart.'.$idDataGrid, $jsonData);
        //    $dataSessionCart = $session->read('JurnalCart');
        } elseif($condData=='view' && empty($jsonData)) {
        //    $dataSessionCart = $session->read('JurnalCart');
        } elseif($condData=='delete' && !empty($idData)) {
            $session->delete('JurnalCart.'.$idData);
        //    $dataSessionCart = $session->read('JurnalCart');
        } else {
        //    $dataSessionCart = $session->read('JurnalCart');
        }
        
        $dataSessionCart = $session->read('JurnalCart');

        $countData = (!empty($session->read('JurnalCart'))) ? count($session->read('JurnalCart')) : 0;
        //, 'data'
        $this->set(compact('countData', 'dataSessionCart', 'condData'));


            //$data[] = "";
        // return $this->response->withType("application/json")->withStringBody(json_encode($dataSessionCart));
        /*
        // $condData = (empty($this->params['url']['cond'])) ? '' : $this->params['url']['cond'];
        // $jsonData = (empty($this->params['url']['dataCart'])) ? '' : $this->params['url']['dataCart'];
        // $idData = (empty($this->params['url']['idData'])) ? '' : $this->params['url']['idData'];
        // pr($session->read('JurnalCart'));
        // pr($data);
            // pr($data['rowAccount']);

            // $this->set(compact('data'));
        //} elseif($condData=='delete' && !empty($idData)) {
            // $session->delete('JurnalCart');
            //$data[] = "";
            //$data[] = "";
            //$dataManifest = "";
            //'dataManifest', 
            // use \App\Controller\Acc\AccChartOfAccountsController;
            // $accController = new AccChartOfAccountsController;

            //$data['rowAccount'] = $this->Krs->datarowCOA(5);
            /*
            sementara dulu
            $this->loadModel('AccChartOfAccounts');
            $data['rowAccount'] = $this->AccChartOfAccounts->getCoaData(5);*/
            
            // $accController =  new \App\Controller\acc\AccChartOfAccountsController(); 
            //$data['rowAccount'] = $this->AccChartOfAccounts->getCoa(5);
            // $data['rowAccount'] = $accController->getCoa(5);
            // pr($data['rowAccount']);
            // pr($accController->getValue()); 
        
    }

    public function checkcodeByType() {
                        
        // if($this->RequestHandler->isAjax()) {
            $this->autoRender=false;
            
            $getBranch = $this->request->getQuery('branch');
            $getType = $this->request->getQuery('type');
            $getDate = $this->Krs->dateTo($this->request->getQuery('dates'), 'A');
            // pr($getDate);
            // $date = date("ymd");

            //$date = date('ym');
           
            // $result = $this->AccJournals->find('all',[
            // 'fields' => array('codes' => 'MAX(CAST(SUBSTR(AccJournals.code, 7) AS UNSIGNED))+1'),
            // 'conditions' => array('AccJournals.branch_id' => $getBranch, 'AccJournals.journal_type' => $getType, 'SUBSTRING(AccJournals.code, 1, 4)' => $date, 'AccJournals.deleted ='=>NULL)
            // ]); 

            //MAX(CAST(SUBSTR(AccJournals.code, 7) AS UNSIGNED))+1
            $dataRows = $this->AccJournals->find('all')
            ->select(['codes' => 'MAX(RIGHT(AccJournals.code, 3))+1'])
            ->where(['AccJournals.branch_id' => $getBranch, 'AccJournals.journal_type' => $getType, 'SUBSTRING(AccJournals.code, 1, 6) =' => $getDate, 'AccJournals.deleted IS NULL']);
            //pr($getDate);

            $dataRows = $dataRows->first();
            $dataResult = $dataRows->codes;
            $dataCode = (empty($dataResult)) ? "1": $dataResult;

           // $_code = ($result[0]['codes']==0) ? 1 : $result[0]['codes'];
            $result['code']= $getDate.'-'.str_pad($dataCode, 3, "0", STR_PAD_LEFT);
            //$result = json_encode($results);
            // pr($result);
            return $this->response->withType("application/json")->withStringBody(json_encode($result));

            //$this->set(compact("result", "date")); 
            // $queries = $this->find()
            //         ->select(['coaGroupId' => "CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups)", 'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name))"])
            //         ->where([$condDataName, 'AccChartOfAccounts.level IN'=>$condLevel])
            //         ->order(['AccChartOfAccounts.lft' => 'ASC'])
            //         ->contain(['Customers']);
            // $this->set("result", $this->AccJournal->find("first", array("fields" => array("MAX(CAST(SUBSTR(AccJournals.code, 7) AS UNSIGNED))+1 AS codes"), "conditions" => array("AccJournals.branch_id" => $getBranch, "AccJournals.journal_type" => $getType, "SUBSTRING(AccJournals.code, 1, 4)" => $date, 'AccJournals.deleted'=>NULL), "recursive" => -1)));
            // $this->set("result", $this->AccJournalCash->find("first", array("fields" => array("MAX(SUBSTR(Customer.code, 2))+1 AS code"), "conditions" => array("Customer.group" => $get_id), "recursive" => -1)));
                  
            // pr($result);
        // }
    }

    /**
     * Edit method
     *
     * @param string|null $id Acc Journal id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accJournal = $this->AccJournals->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accJournal = $this->AccJournals->patchEntity($accJournal, $this->request->getData());
            if ($this->AccJournals->save($accJournal)) {
                $this->Flash->success(__('The acc journal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc journal could not be saved. Please, try again.'));
        }
        $branches = $this->AccJournals->Branches->find('list', ['limit' => 200]);
        // $customers = $this->AccJournals->Customers->find('list', ['limit' => 200]);
        $this->set(compact('accJournal', 'branches'));
    }

   



    public function incomeGlobalReport() {
        $accJournal = $this->AccJournals->newEmptyEntity();
        $this->loadModel('AccChartOfAccounts');

        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $monthYear = $dataRow['filterMYDate'];            
            
            $month = intval(substr($monthYear, 0, 2));
            $year = intval(substr($monthYear, 3, 4));
            // pr($year);
            $filterDateStartShow = date("t-M-Y", mktime(0, 0, 0, $month+1, 0, $year));
            $filterDateEndShow = date("d-M-Y", mktime(0, 0, 0, $month, 1, $year));
            $filterDateEnd = date("Y-m-t", mktime(0, 0, 0, $month+1, 0, $year));
            $filterDateStart = date("Y-m-d", mktime(0, 0, 0, $month, 1, $year));
            if($filterDateStart!="" && $filterDateEnd!="") {
                $filterConditionDateNow = ($filterDateEnd!="") ? array("AccJournals.date BETWEEN '".$filterDateStart."' AND '".$filterDateEnd."'"):array();
                $filterConditionDateAfter = ($filterDateEnd!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateEnd):array();

                $dateFilter = $filterDateStart."^".$filterDateEnd;
                $dataDate = $this->Krs->fEncode($dateFilter);

                $this->dataLabaRugi($filterConditionDateNow, $filterConditionDateAfter, $listCOAPendapatan, $listCOAReturPendapatan, $listCOAPotonganPendapatan, $listCOABebanPokokPendapatan, $listCOABebanPendapatan, $listCOABebanAdministrasiUmum, $listCOAPendapatanNonOperasional, $listCOABebanNonOperasional);

                $this->set(compact('dataDate', 'listCOAPendapatan', 'listCOAReturPendapatan', 'listCOAPotonganPendapatan', 'listCOABebanPokokPendapatan', 'listCOABebanPendapatan', 'listCOABebanAdministrasiUmum', 'listCOAPendapatanNonOperasional', 'listCOABebanNonOperasional'));

                $data['show'] = 'Y';
            } 
            else 
            {
                $data['show'] = 'N';
            }
        } 
        else
        {   
            $data['show'] = 'N';
        }
        $this->set(compact('accJournal', 'data')); 
    }


    // Function untuk Laba/Rugi
    public function dataLabaRugi($filterConditionDateNow='', $filterConditionDateAfter='', &$listCOAPendapatan, &$listCOAReturPendapatan, &$listCOAPotonganPendapatan, &$listCOABebanPokokPendapatan, &$listCOABebanPendapatan, &$listCOABebanAdministrasiUmum, &$listCOAPendapatanNonOperasional, &$listCOABebanNonOperasional)
    {
        // Memanggil data COA.
        $dataCOAs = $this->AccChartOfAccounts->datarowCOA();             

        // Mengambil data COA Id
        // $extractCOALevel = $this->getCoaByJournal($dataCOAs, 'LR');

        //Rev.230505 @office
        // Mengambil Id Pendapatan
        $dataCOAPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan]');
        $dataCOAPendapatans = Hash::extract($dataCOAPendapatan, '{n}[level=5]');
        $extractCOALevelPendapatan = (!empty($dataCOAPendapatans)) ? Hash::extract($dataCOAPendapatans, '{n}.id') : array();
        
        // Mengambil Id Retur Pendapatan
        $dataCOAReturPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=retur_pendapatan]');
        $dataCOAReturPendapatans = Hash::extract($dataCOAReturPendapatan, '{n}[level=5]');
        $extractCOALevelReturPendapatan = (!empty($dataCOAReturPendapatans)) ? Hash::extract($dataCOAReturPendapatans, '{n}.id') : array();

        // Mengambil Id Potongan Pendapatan
        $dataCOAPotonganPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=potongan_pendapatan]');
        $dataCOAPotonganPendapatans = Hash::extract($dataCOAPotonganPendapatan, '{n}[level=5]');
        $extractCOALevelPotonganPendapatan = (!empty($dataCOAPotonganPendapatans)) ? Hash::extract($dataCOAPotonganPendapatans, '{n}.id') : array();

        // Mengambil Id Beban Pokok Pendapatan
        $dataCOABebanPokokPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=beban_pokok_pendapatan]');
        $dataCOABebanPokokPendapatans = Hash::extract($dataCOABebanPokokPendapatan, '{n}[level=5]');
        $extractCOALevelBebanPokokPendapatan = (!empty($dataCOABebanPokokPendapatans)) ? Hash::extract($dataCOABebanPokokPendapatans, '{n}.id') : array();

        // Mengambil Id Beban Pendapatan
        $dataCOABebanPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=beban_pendapatan]');
        $dataCOABebanPendapatans = Hash::extract($dataCOABebanPendapatan, '{n}[level=5]');
        $extractCOALevelBebanPendapatan = (!empty($dataCOABebanPendapatans)) ? Hash::extract($dataCOABebanPendapatans, '{n}.id') : array();

        // Mengambil Id Beban Administrasi Umum
        $dataCOABebanAdministrasiUmum = Hash::extract($dataCOAs, '{n}[journal_type=beban_administrasi_umum]');
        $dataCOABebanAdministrasiUmums = Hash::extract($dataCOABebanAdministrasiUmum, '{n}[level=5]');
        $extractCOALevelBebanAdministrasiUmum = (!empty($dataCOABebanAdministrasiUmums)) ? Hash::extract($dataCOABebanAdministrasiUmums, '{n}.id') : array();

        // Mengambil Id Pendapatan Non Operasional
        $dataCOAPendapatanNonOperasional = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan_non_operasional]');
        $dataCOAPendapatanNonOperasionals = Hash::extract($dataCOAPendapatanNonOperasional, '{n}[level=5]');
        $extractCOALevelPendapatanNonOperasional = (!empty($dataCOAPendapatanNonOperasionals)) ? Hash::extract($dataCOAPendapatanNonOperasionals, '{n}.id') : array();
        //pr($extractCOALevelPendapatanNonOperasional);

        // Mengambil Id Beban Non Operasional
        $dataCOABebanNonOperasional = Hash::extract($dataCOAs, '{n}[journal_type=beban_non_operasional]');
        $dataCOABebanNonOperasionals = Hash::extract($dataCOABebanNonOperasional, '{n}[level=5]');
        $extractCOALevelBebanNonOperasional = (!empty($dataCOABebanNonOperasionals)) ? Hash::extract($dataCOABebanNonOperasionals, '{n}.id') : array();

        $extractCOALevel = array_merge($extractCOALevelPendapatan,$extractCOALevelReturPendapatan,$extractCOALevelPotonganPendapatan,$extractCOALevelBebanPokokPendapatan,$extractCOALevelBebanPendapatan,$extractCOALevelBebanAdministrasiUmum, $extractCOALevelPendapatanNonOperasional, $extractCOALevelBebanNonOperasional);

        $data['rows'] = $this->AccJournals->find('all')
            ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
            ->where(["AccJournalLines.acc_chart_of_account_id IN" => count($extractCOALevel) > 0 ?  $extractCOALevel : [null], $filterConditionDateNow])
            ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
            ->group(['AccJournalLines.acc_chart_of_account_id'])
            //->contain(['AccJournalLines'])
            ->leftJoinWith('AccJournalLines')
            // ->enableAutoFields(true)
            ->toArray();

        $data['rowAfter'] = $this->AccJournals->find('all')
            ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
            ->where(["AccJournalLines.acc_chart_of_account_id IN" => count($extractCOALevel) > 0 ?  $extractCOALevel : [null], $filterConditionDateAfter])
            ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
            ->group(['AccJournalLines.acc_chart_of_account_id'])
            //->contain(['AccJournalLines'])
            ->leftJoinWith('AccJournalLines')
            // ->enableAutoFields(true)
            ->toArray();
            //->contain(['AccJournalLines', 'AccJournalLines.AccChartOfAccounts']);

        $dataJournalCOA = Hash::combine($data['rows'], '{n}.coaId',['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
        $dataJournalCOAAfter = Hash::combine($data['rowAfter'], '{n}.coaId',['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);

        // pr($dataJournalCOA);

        $listCOAPendapatan = $this->Krs->GetSchemaCOAGlobalShow($dataCOAPendapatan, $dataJournalCOA, $dataJournalCOAAfter, 'creditMinusdebet');
        asort($listCOAPendapatan);

        $listCOAReturPendapatan = $this->Krs->GetSchemaCOAGlobalShow($dataCOAReturPendapatan, $dataJournalCOA, $dataJournalCOAAfter, 'debet');
        asort($listCOAReturPendapatan);

        $listCOAPotonganPendapatan = $this->Krs->GetSchemaCOAGlobalShow($dataCOAPotonganPendapatan, $dataJournalCOA, $dataJournalCOAAfter, 'creditMinusdebet');
        asort($listCOAPotonganPendapatan);                

        $listCOABebanPokokPendapatan = $this->Krs->GetSchemaCOAGlobalShow($dataCOABebanPokokPendapatan, $dataJournalCOA, $dataJournalCOAAfter, 'debet');
        asort($listCOABebanPokokPendapatan);

        $listCOABebanPendapatan = $this->Krs->GetSchemaCOAGlobalShow($dataCOABebanPendapatan, $dataJournalCOA, $dataJournalCOAAfter, 'debet');
        asort($listCOABebanPendapatan);

        $listCOABebanAdministrasiUmum = $this->Krs->GetSchemaCOAGlobalShow($dataCOABebanAdministrasiUmum, $dataJournalCOA, $dataJournalCOAAfter, 'debet');
        asort($listCOABebanAdministrasiUmum);

        $listCOAPendapatanNonOperasional = $this->Krs->GetSchemaCOAGlobalShow($dataCOAPendapatanNonOperasional, $dataJournalCOA, $dataJournalCOAAfter, 'creditMinusdebet');
        asort($listCOAPendapatanNonOperasional);
        // pr($dataCOAPendapatanNonOperasional);

        $listCOABebanNonOperasional = $this->Krs->GetSchemaCOAGlobalShow($dataCOABebanNonOperasional, $dataJournalCOA, $dataJournalCOAAfter, 'debet');
        asort($listCOABebanNonOperasional);
        // pr($dataCOABebanNonOperasional);
        //$this->set(compact('listCOAPendapatan', 'listCOAReturPendapatan', 'listCOAPotonganPendapatan', 'listCOABebanPokokPendapatan', 'listCOABebanPendapatan', 'listCOABebanAdministrasiUmum', 'listCOAPendapatanNonOperasional', 'listCOABebanNonOperasional'));
    }




    public function balanceSheetPercentReport()
    {
        $accJournal = $this->AccJournals->newEmptyEntity();
        $this->loadModel('AccChartOfAccounts');

        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            // pr($dataRow);
            
            $dataFilterDate = $dataRow['filterDate'];
            $filterCheckGlobal = $dataRow['checkGlobal'];
            $filterDate = $this->Krs->dateTo($dataFilterDate);

            $dateFilter = $filterDate."^".$filterCheckGlobal;            

            // $year = substr($filterDate, 0, 4);
            // $beforeDate = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year-1));
            // $beforeYear = date("Y", mktime(0, 0, 0, 12, 31, $year-1));

            // Memanggil function dataBalance.
            $this->dataBalance($filterDate, $filterCheckGlobal);

            $data['show'] = 'Y';
        } else {
            $dateFilter = '^';
            $data['show'] = 'N';
           // $dataFilters = '^';
        }
        
        $dataFilter = $this->Krs->fEncode($dateFilter);
        //$dataFilter = $this->Krs->fEncode($dataFilters);
        //
        $this->set(compact('accJournal', 'data', 'dataFilter'));
    }

    public function dataBalance($filterDate=null, $filterCheckGlobal=null) {
        if(!empty($filterDate) && !empty($filterCheckGlobal)) {
            $year = substr($filterDate, 0, 4);
            $month = substr($filterDate, 5, 2);
            $beforeDate = date("Y-m-d", mktime(0, 0, 0, 12, 31, (int)$year-1));
            $beforeYear = date("Y", mktime(0, 0, 0, 12, 31, (int)$year-1));

            $filterConditionDate = ($filterDate!="") ? array("AccJournals.date <="=>$filterDate):array();

            $filterCondition = array_merge($filterConditionDate);

            // Memanggil data COA.
            $dateFilter = $filterDate."^".$filterCheckGlobal;
            $dataDate = $this->Krs->fEncode($dateFilter);

            $this->dataBalanceActivaPasiva($filterConditionDate, $listCOAAset, $listCOAAsetLancar, $listCOAKasSetaraKas, $listCOAInvestasi, $listCOAInvestasiJangkaPanjang, $listCOAPiutang, $listCOAPiutangPemegangSaham, $listCOAPiutangAfiliasi, $listCOAPiutangKaryawan, $listCOAPiutangLainLain, $listCOAPiutangPajak, $listCOAPersediaanBarang, $listCOAUangMukaPembelian, $listCOAPajakDibayarDimuka, $listCOABebanDibayarDimuka, $listCOAAsetTidakLancar, $listCOAAsetTetap, $listCOAAkumulasiDepresiasi, $listCOAAsetLainLain, $listCOAKewajiban, $listCOAKewajibanLancar, $listCOAHutangUsaha, $listCOAHutangAfiliasi, $listCOAPendapatanDiterimaDimuka, $listCOABiayaYangMasihHarusDibayar, $listCOAHutangPajak, $listCOAHutangBank, $listCOAHutangLeasing, $listCOAHutangPemegangSaham, $listCOAHutangKaryawan, $listCOAHutangLainLain, $listCOAKewajibanTidakLancar, $listCOAKewajibanPajakTangguhan, $listCOAEkuitas, $countData);


            //Laba-Rugi Berjalan
            $filterDateStart = date("Y-m-d", mktime(0, 0, 0, (int)$month, 1, (int)$year));
            $filterDateEnd = date("Y-m-t", mktime(0, 0, 0, (int)$month+1, 0, (int)$year));
            $filterDateEndAfter = date("Y-m-t", mktime(0, 0, 0, (int)$month, 0, (int)$year));

            $filterConditionDateNow = ($filterDateEnd!="") ? array("AccJournals.date BETWEEN '".$filterDateStart."' AND '".$filterDateEnd."'"):array();
            $filterConditionDateAfter = ($filterDateEnd!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateEnd):array();


            // $filterConditionDateNow = ($filterDateEnd!="") ? array("AccJournals.date BETWEEN ? AND ?"=>array($filterDateStart, $filterDateEnd)):array();
            // $filterConditionDateAfter = ($filterDateEnd!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDateEnd):array();
            
            //Memanggil function Laba/Rugi Berjalan
            $this->dataLabaRugiBerjalan($filterConditionDateNow, $filterConditionDateAfter, $grandTotalLabaRugiBerjalan);
            // pr($grandTotalLabaRugiBerjalan);
            //pr($filterConditionDateAfter);
            /*sementara
            

            //Untuk mengambil data LabaRugiBerjalanSebelumnya
            if($year=='2023') {
                $filterDateStart23 = date("Y-m-d", mktime(0, 0, 0, 1, 1, 2022));
                $filterDateEnd23 = date("Y-m-t", mktime(0, 0, 0, 13, 0, 2022));
            
                $filterConditionDateNow23 = ($filterDateEnd23!="") ? array("AccJournal.date BETWEEN ? AND ?"=>array($filterDateStart23, $filterDateEnd23)):array();
                $filterConditionDateAfter23 = ($filterDateEnd23!="") ? array("YEAR(AccJournal.date) ="=>'2022', "AccJournal.date <="=>$filterDateEnd23):array();

                //Memanggil function Laba/Rugi Berjalan
                $this->dataLabaRugiBerjalan($filterConditionDateNow23, $filterConditionDateAfter23, $grandTotalLabaRugiDitahan);
                //pr($grandTotalLabaRugiDitahan);
                //pr($filterDateStart23.' - '.$filterDateEnd23);
            } else {
                */
                // $grandTotalLabaRugiBerjalan = 0;
                $grandTotalLabaRugiDitahan = 0;
            //}
        
            $this->set(compact('listCOAAset', 'listCOAAsetLancar', 'listCOAKasSetaraKas', 'listCOAInvestasi', 'listCOAInvestasiJangkaPanjang', 'listCOAPiutang', 'listCOAPiutangPemegangSaham', 'listCOAPiutangAfiliasi', 'listCOAPiutangKaryawan', 'listCOAPiutangLainLain', 'listCOAPiutangPajak', 'listCOAPersediaanBarang', 'listCOAUangMukaPembelian', 'listCOAPajakDibayarDimuka', 'listCOABebanDibayarDimuka', 'listCOAAsetTidakLancar', 'listCOAAsetTetap', 'listCOAAkumulasiDepresiasi', 'listCOAAsetLainLain', 'listCOAKewajiban', 'listCOAKewajibanLancar', 'listCOAHutangUsaha', 'listCOAHutangAfiliasi', 'listCOAPendapatanDiterimaDimuka', 'listCOABiayaYangMasihHarusDibayar', 'listCOAHutangPajak', 'listCOAHutangBank', 'listCOAHutangLeasing', 'listCOAHutangPemegangSaham', 'listCOAHutangKaryawan', 'listCOAHutangLainLain', 'listCOAKewajibanTidakLancar', 'listCOAKewajibanPajakTangguhan', 'listCOAEkuitas', 'dataDate', 'countData', 'grandTotalLabaRugiBerjalan', 'grandTotalLabaRugiDitahan'));
        } else {
            return false;
        }
    }



    // #Update 230405
    public function dataBalanceActivaPasiva($filterConditionDate=null, &$listCOAAset, &$listCOAAsetLancar, &$listCOAKasSetaraKas, &$listCOAInvestasi, &$listCOAInvestasiJangkaPanjang, &$listCOAPiutang, &$listCOAPiutangPemegangSaham, &$listCOAPiutangAfiliasi, &$listCOAPiutangKaryawan, &$listCOAPiutangLainLain, &$listCOAPiutangPajak, &$listCOAPersediaanBarang, &$listCOAUangMukaPembelian, &$listCOAPajakDibayarDimuka, &$listCOABebanDibayarDimuka, &$listCOAAsetTidakLancar, &$listCOAAsetTetap, &$listCOAAkumulasiDepresiasi, &$listCOAAsetLainLain, &$listCOAKewajiban, &$listCOAKewajibanLancar, &$listCOAHutangUsaha, &$listCOAHutangAfiliasi, &$listCOAPendapatanDiterimaDimuka, &$listCOABiayaYangMasihHarusDibayar, &$listCOAHutangPajak, &$listCOAHutangBank, &$listCOAHutangLeasing, &$listCOAHutangPemegangSaham, &$listCOAHutangKaryawan, &$listCOAHutangLainLain, &$listCOAKewajibanTidakLancar, &$listCOAKewajibanPajakTangguhan, &$listCOAEkuitas, &$countData) {
        if(!empty($filterConditionDate)) {
            // Memanggil data COA.
            $dataCOAs = $this->AccChartOfAccounts->datarowCOA();  

            // -------- AKTIVA ID --------
            // Mengambil Id Aset
            $dataCOAAset = Hash::extract($dataCOAs, '{n}[journal_type=aset]');
            $dataCOAAsets = Hash::extract($dataCOAAset, '{n}[level=5]');
            $extractCOALevelAset = (!empty($dataCOAAsets)) ? Hash::extract($dataCOAAsets, '{n}.id') : array();

            // Mengambil Id Aset Lancar
            $dataCOAAsetLancar = Hash::extract($dataCOAs, '{n}[journal_type=aset_lancar]');
            $dataCOAAsetLancars = Hash::extract($dataCOAAsetLancar, '{n}[level=5]');
            $extractCOALevelAsetLancar = (!empty($dataCOAAsetLancars)) ? Hash::extract($dataCOAAsetLancars, '{n}.id') : array();

            // Mengambil Id Kas Setara Kas
            $dataCOAKasSetaraKas = Hash::extract($dataCOAs, '{n}[journal_type=kas_setara_kas]');
            $dataCOAKasSetaraKass = Hash::extract($dataCOAKasSetaraKas, '{n}[level=5]');
            $extractCOALevelKasSetaraKas = (!empty($dataCOAKasSetaraKass)) ? Hash::extract($dataCOAKasSetaraKass, '{n}.id') : array();

            // Mengambil Id Investasi
            $dataCOAInvestasi = Hash::extract($dataCOAs, '{n}[journal_type=investasi]');
            $dataCOAInvestasis = Hash::extract($dataCOAInvestasi, '{n}[level=5]');
            $extractCOALevelInvestasi = (!empty($dataCOAInvestasis)) ? Hash::extract($dataCOAInvestasis, '{n}.id') : array();

            // Mengambil Id InvestasiJangkaPanjang
            $dataCOAInvestasiJangkaPanjang = Hash::extract($dataCOAs, '{n}[journal_type=InvestasiJangkaPanjang]');
            $dataCOAInvestasiJangkaPanjangs = Hash::extract($dataCOAInvestasiJangkaPanjang, '{n}[level=5]');
            $extractCOALevelInvestasiJangkaPanjang = (!empty($dataCOAInvestasiJangkaPanjangs)) ? Hash::extract($dataCOAInvestasiJangkaPanjangs, '{n}.id') : array();

            // Mengambil Id Piutang
            $dataCOAPiutang = Hash::extract($dataCOAs, '{n}[journal_type=piutang]');
            $dataCOAPiutangs = Hash::extract($dataCOAPiutang, '{n}[level=5]');
            $extractCOALevelPiutang = (!empty($dataCOAPiutangs)) ? Hash::extract($dataCOAPiutangs, '{n}.id') : array();

            // Mengambil Id Piutang Pemegang Saham
            $dataCOAPiutangPemegangSaham = Hash::extract($dataCOAs, '{n}[journal_type=piutang_pemegang_saham]');
            $dataCOAPiutangPemegangSahams = Hash::extract($dataCOAPiutangPemegangSaham, '{n}[level=5]');
            $extractCOALevelPiutangPemegangSaham = (!empty($dataCOAPiutangPemegangSahams)) ? Hash::extract($dataCOAPiutangPemegangSahams, '{n}.id') : array();

            // Mengambil Id Piutang Afiliasi
            $dataCOAPiutangAfiliasi = Hash::extract($dataCOAs, '{n}[journal_type=piutang_afiliasi]');
            $dataCOAPiutangAfiliasis = Hash::extract($dataCOAPiutangAfiliasi, '{n}[level=5]');
            $extractCOALevelPiutangAfiliasi = (!empty($dataCOAPiutangAfiliasis)) ? Hash::extract($dataCOAPiutangAfiliasis, '{n}.id') : array();

            // Mengambil Id Piutang Karyawan
            $dataCOAPiutangKaryawan = Hash::extract($dataCOAs, '{n}[journal_type=piutang_karyawan]');
            $dataCOAPiutangKaryawans = Hash::extract($dataCOAPiutangKaryawan, '{n}[level=5]');
            $extractCOALevelPiutangKaryawan = (!empty($dataCOAPiutangKaryawans)) ? Hash::extract($dataCOAPiutangKaryawans, '{n}.id') : array();

            // Mengambil Id Piutang Lain Lain
            $dataCOAPiutangLainLain = Hash::extract($dataCOAs, '{n}[journal_type=piutang_lain_lain]');
            $dataCOAPiutangLainLains = Hash::extract($dataCOAPiutangLainLain, '{n}[level=5]');
            $extractCOALevelPiutangLainLain = (!empty($dataCOAPiutangLainLains)) ? Hash::extract($dataCOAPiutangLainLains, '{n}.id') : array();

            // Mengambil Id Piutang Pajak
            $dataCOAPiutangPajak = Hash::extract($dataCOAs, '{n}[journal_type=piutang_pajak]');
            $dataCOAPiutangPajaks = Hash::extract($dataCOAPiutangPajak, '{n}[level=5]');
            $extractCOALevelPiutangPajak = (!empty($dataCOAPiutangPajaks)) ? Hash::extract($dataCOAPiutangPajaks, '{n}.id') : array();

            // Mengambil Id Persediaan Barang
            $dataCOAPersediaanBarang = Hash::extract($dataCOAs, '{n}[journal_type=persediaan_barang]');
            $dataCOAPersediaanBarangs = Hash::extract($dataCOAPersediaanBarang, '{n}[level=5]');
            $extractCOALevelPersediaanBarang = (!empty($dataCOAPersediaanBarangs)) ? Hash::extract($dataCOAPersediaanBarangs, '{n}.id') : array();

            // Mengambil Id Uang Muka Pembelian
            $dataCOAUangMukaPembelian = Hash::extract($dataCOAs, '{n}[journal_type=uang_muka_pembelian]');
            $dataCOAUangMukaPembelians = Hash::extract($dataCOAUangMukaPembelian, '{n}[level=5]');
            $extractCOALevelUangMukaPembelian = (!empty($dataCOAUangMukaPembelians)) ? Hash::extract($dataCOAUangMukaPembelians, '{n}.id') : array();

            // Mengambil Id Pajak Dibayar Dimuka
            $dataCOAPajakDibayarDimuka = Hash::extract($dataCOAs, '{n}[journal_type=pajak_dibayar_dimuka]');
            $dataCOAPajakDibayarDimukas = Hash::extract($dataCOAPajakDibayarDimuka, '{n}[level=5]');
            $extractCOALevelPajakDibayarDimuka = (!empty($dataCOAPajakDibayarDimukas)) ? Hash::extract($dataCOAPajakDibayarDimukas, '{n}.id') : array();

            // Mengambil Id Beban Dibayar Dimuka
            $dataCOABebanDibayarDimuka = Hash::extract($dataCOAs, '{n}[journal_type=beban_dibayar_dimuka]');
            $dataCOABebanDibayarDimukas = Hash::extract($dataCOABebanDibayarDimuka, '{n}[level=5]');
            $extractCOALevelBebanDibayarDimuka = (!empty($dataCOABebanDibayarDimukas)) ? Hash::extract($dataCOABebanDibayarDimukas, '{n}.id') : array();

            // Mengambil Id Aset Tidak Lancar
            $dataCOAAsetTidakLancar = Hash::extract($dataCOAs, '{n}[journal_type=AsetTidakLancar_tidak_lancar]');
            $dataCOAAsetTidakLancars = Hash::extract($dataCOAAsetTidakLancar, '{n}[level=5]');
            $extractCOALevelAsetTidakLancar = (!empty($dataCOAAsetTidakLancars)) ? Hash::extract($dataCOAAsetTidakLancars, '{n}.id') : array();

            // Mengambil Id Aset Tetap
            $dataCOAAsetTetap = Hash::extract($dataCOAs, '{n}[journal_type=aset_tetap]');
            $dataCOAAsetTetaps = Hash::extract($dataCOAAsetTetap, '{n}[level=5]');
            $extractCOALevelAsetTetap = (!empty($dataCOAAsetTetaps)) ? Hash::extract($dataCOAAsetTetaps, '{n}.id') : array();

            // Mengambil Id Akumulasi Depresiasi
            $dataCOAAkumulasiDepresiasi = Hash::extract($dataCOAs, '{n}[journal_type=akumulasi_depresiasi]');
            $dataCOAAkumulasiDepresiasis = Hash::extract($dataCOAAkumulasiDepresiasi, '{n}[level=5]');
            $extractCOALevelAkumulasiDepresiasi = (!empty($dataCOAAkumulasiDepresiasis)) ? Hash::extract($dataCOAAkumulasiDepresiasis, '{n}.id') : array();

            // Mengambil Id Aset Lain Lain
            $dataCOAAsetLainLain = Hash::extract($dataCOAs, '{n}[journal_type=aset_lain_lain]');
            $dataCOAAsetLainLains = Hash::extract($dataCOAAsetLainLain, '{n}[level=5]');
            $extractCOALevelAsetLainLain = (!empty($dataCOAAsetLainLains)) ? Hash::extract($dataCOAAsetLainLains, '{n}.id') : array();


            //-------- PASIVA ID --------
            // Mengambil Id Kewajiban
            $dataCOAKewajiban = Hash::extract($dataCOAs, '{n}[journal_type=kewajiban]');
            $dataCOAKewajibans = Hash::extract($dataCOAKewajiban, '{n}[level=5]');
            $extractCOALevelKewajiban = (!empty($dataCOAKewajibans)) ? Hash::extract($dataCOAKewajibans, '{n}.id') : array();

            // Mengambil Id Kewajiban Lancar
            $dataCOAKewajibanLancar = Hash::extract($dataCOAs, '{n}[journal_type=kewajiban_lancar]');
            $dataCOAKewajibanLancars = Hash::extract($dataCOAKewajibanLancar, '{n}[level=5]');
            $extractCOALevelKewajibanLancar = (!empty($dataCOAKewajibanLancars)) ? Hash::extract($dataCOAKewajibanLancars, '{n}.id') : array();

            // Mengambil Id Hutang Usaha
            $dataCOAHutangUsaha = Hash::extract($dataCOAs, '{n}[journal_type=hutang_usaha]');
            $dataCOAHutangUsahas = Hash::extract($dataCOAHutangUsaha, '{n}[level=5]');
            $extractCOALevelHutangUsaha = (!empty($dataCOAHutangUsahas)) ? Hash::extract($dataCOAHutangUsahas, '{n}.id') : array();

            // Mengambil Id Hutang Afiliasi
            $dataCOAHutangAfiliasi = Hash::extract($dataCOAs, '{n}[journal_type=hutang_afiliasi]');
            $dataCOAHutangAfiliasis = Hash::extract($dataCOAHutangAfiliasi, '{n}[level=5]');
            $extractCOALevelHutangAfiliasi = (!empty($dataCOAHutangAfiliasis)) ? Hash::extract($dataCOAHutangAfiliasis, '{n}.id') : array();

            // Mengambil Id Pendapatan Diterima Dimuka
            $dataCOAPendapatanDiterimaDimuka = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan_diterima_dimuka]');
            $dataCOAPendapatanDiterimaDimukas = Hash::extract($dataCOAPendapatanDiterimaDimuka, '{n}[level=5]');
            $extractCOALevelPendapatanDiterimaDimuka = (!empty($dataCOAPendapatanDiterimaDimukas)) ? Hash::extract($dataCOAPendapatanDiterimaDimukas, '{n}.id') : array();

            // Mengambil Id Biaya Yang Masih Harus Dibayar
            $dataCOABiayaYangMasihHarusDibayar = Hash::extract($dataCOAs, '{n}[journal_type=biaya_yang_masih_harus_dibayar]');
            $dataCOABiayaYangMasihHarusDibayars = Hash::extract($dataCOABiayaYangMasihHarusDibayar, '{n}[level=5]');
            $extractCOALevelBiayaYangMasihHarusDibayar = (!empty($dataCOABiayaYangMasihHarusDibayars)) ? Hash::extract($dataCOABiayaYangMasihHarusDibayars, '{n}.id') : array();

            // Mengambil Id Hutang Pajak
            $dataCOAHutangPajak = Hash::extract($dataCOAs, '{n}[journal_type=hutang_pajak]');
            $dataCOAHutangPajaks = Hash::extract($dataCOAHutangPajak, '{n}[level=5]');
            $extractCOALevelHutangPajak = (!empty($dataCOAHutangPajaks)) ? Hash::extract($dataCOAHutangPajaks, '{n}.id') : array();

            // Mengambil Id Hutang Bank
            $dataCOAHutangBank = Hash::extract($dataCOAs, '{n}[journal_type=hutang_bank]');
            $dataCOAHutangBanks = Hash::extract($dataCOAHutangBank, '{n}[level=5]');
            $extractCOALevelHutangBank = (!empty($dataCOAHutangBanks)) ? Hash::extract($dataCOAHutangBanks, '{n}.id') : array();

            // Mengambil Id Hutang Leasing
            $dataCOAHutangLeasing = Hash::extract($dataCOAs, '{n}[journal_type=hutang_leasing]');
            $dataCOAHutangLeasings = Hash::extract($dataCOAHutangLeasing, '{n}[level=5]');
            $extractCOALevelHutangLeasing = (!empty($dataCOAHutangLeasings)) ? Hash::extract($dataCOAHutangLeasings, '{n}.id') : array();

            // Mengambil Id Hutang Pemegang Saham
            $dataCOAHutangPemegangSaham = Hash::extract($dataCOAs, '{n}[journal_type=hutang_pemegang_saham]');
            $dataCOAHutangPemegangSahams = Hash::extract($dataCOAHutangPemegangSaham, '{n}[level=5]');
            $extractCOALevelHutangPemegangSaham = (!empty($dataCOAHutangPemegangSahams)) ? Hash::extract($dataCOAHutangPemegangSahams, '{n}.id') : array();

            // Mengambil Id Hutang Karyawan
            $dataCOAHutangKaryawan = Hash::extract($dataCOAs, '{n}[journal_type=hutang_karyawan]');
            $dataCOAHutangKaryawans = Hash::extract($dataCOAHutangKaryawan, '{n}[level=5]');
            $extractCOALevelHutangKaryawan = (!empty($dataCOAHutangKaryawans)) ? Hash::extract($dataCOAHutangKaryawans, '{n}.id') : array();

            // Mengambil Id Hutang Lain Lain
            $dataCOAHutangLainLain = Hash::extract($dataCOAs, '{n}[journal_type=hutang_lain_lain]');
            $dataCOAHutangLainLains = Hash::extract($dataCOAHutangLainLain, '{n}[level=5]');
            $extractCOALevelHutangLainLain = (!empty($dataCOAHutangLainLains)) ? Hash::extract($dataCOAHutangLainLains, '{n}.id') : array();

            // Mengambil Id Kewajiban Tidak Lancar
            $dataCOAKewajibanTidakLancar = Hash::extract($dataCOAs, '{n}[journal_type=kewajiban_tidak_lancar]');
            $dataCOAKewajibanTidakLancars = Hash::extract($dataCOAKewajibanTidakLancar, '{n}[level=5]');
            $extractCOALevelKewajibanTidakLancar = (!empty($dataCOAKewajibanTidakLancars)) ? Hash::extract($dataCOAKewajibanTidakLancars, '{n}.id') : array();

            // Mengambil Id KewajibanPajakTangguhan
            $dataCOAKewajibanPajakTangguhan = Hash::extract($dataCOAs, '{n}[journal_type=kewajiban_pajak_tangguhan]');
            $dataCOAKewajibanPajakTangguhans = Hash::extract($dataCOAKewajibanPajakTangguhan, '{n}[level=5]');
            $extractCOALevelKewajibanPajakTangguhan = (!empty($dataCOAKewajibanPajakTangguhans)) ? Hash::extract($dataCOAKewajibanPajakTangguhans, '{n}.id') : array();

            // Mengambil Id Ekuitas
            $dataCOAEkuitas = Hash::extract($dataCOAs, '{n}[journal_type=ekuitas]');
            $dataCOAEkuitass = Hash::extract($dataCOAEkuitas, '{n}[level=5]');
            $extractCOALevelEkuitas = (!empty($dataCOAEkuitass)) ? Hash::extract($dataCOAEkuitass, '{n}.id') : array();

            $extractCOAAktivaPasivaId = array_merge($extractCOALevelAset, $extractCOALevelAsetLancar, $extractCOALevelKasSetaraKas, $extractCOALevelInvestasi, $extractCOALevelInvestasiJangkaPanjang, $extractCOALevelPiutang, $extractCOALevelPiutangPemegangSaham, $extractCOALevelPiutangAfiliasi, $extractCOALevelPiutangKaryawan, $extractCOALevelPiutangLainLain, $extractCOALevelPiutangPajak, $extractCOALevelPersediaanBarang, $extractCOALevelUangMukaPembelian, $extractCOALevelPajakDibayarDimuka, $extractCOALevelBebanDibayarDimuka, $extractCOALevelAsetTidakLancar, $extractCOALevelAsetTetap, $extractCOALevelAkumulasiDepresiasi, $extractCOALevelAsetLainLain, $extractCOALevelKewajiban, $extractCOALevelKewajibanLancar, $extractCOALevelHutangUsaha, $extractCOALevelHutangAfiliasi, $extractCOALevelPendapatanDiterimaDimuka, $extractCOALevelBiayaYangMasihHarusDibayar, $extractCOALevelHutangPajak, $extractCOALevelHutangBank, $extractCOALevelHutangLeasing, $extractCOALevelHutangPemegangSaham, $extractCOALevelHutangKaryawan, $extractCOALevelHutangLainLain, $extractCOALevelKewajibanTidakLancar, $extractCOALevelKewajibanPajakTangguhan, $extractCOALevelEkuitas);

            //pr($extractCOALevelKasSetaraKas);

            $data['rows'] = $this->AccJournals->find('all')
            ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
            ->where(["AccJournalLines.acc_chart_of_account_id IN" => count($extractCOAAktivaPasivaId) > 0 ?  $extractCOAAktivaPasivaId : [null], $filterConditionDate])
            ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
            ->group(['AccJournalLines.acc_chart_of_account_id'])
            //->contain(['AccJournalLines'])
            ->leftJoinWith('AccJournalLines')
            // ->enableAutoFields(true)
            ->toArray();

            $dataJournalCOA = Hash::combine($data['rows'], '{n}.coaId',['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);

            // ---------------- AKTIVA ----------------
            // Aset
            $listCOAAset = $this->Krs->GetSchemaCOAShow($dataCOAAset, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAAset);

            // AsetLancar
            $listCOAAsetLancar = $this->Krs->GetSchemaCOAShow($dataCOAAsetLancar, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAAsetLancar);

            // KasSetaraKas
            $listCOAKasSetaraKas = $this->Krs->GetSchemaCOAShow($dataCOAKasSetaraKas, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAKasSetaraKas);

            // Investasi
            $listCOAInvestasi = $this->Krs->GetSchemaCOAShow($dataCOAInvestasi, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAInvestasi);

            // InvestasiJangkaPanjang
            $listCOAInvestasiJangkaPanjang = $this->Krs->GetSchemaCOAShow($dataCOAInvestasiJangkaPanjang, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAInvestasiJangkaPanjang);

            // Piutang
            $listCOAPiutang = $this->Krs->GetSchemaCOAShow($dataCOAPiutang, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAPiutang);

            // PiutangPemegangSaham
            $listCOAPiutangPemegangSaham = $this->Krs->GetSchemaCOAShow($dataCOAPiutangPemegangSaham, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAPiutangPemegangSaham);

            // PiutangAfiliasi
            $listCOAPiutangAfiliasi = $this->Krs->GetSchemaCOAShow($dataCOAPiutangAfiliasi, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAPiutangAfiliasi);

            // PiutangKaryawan
            $listCOAPiutangKaryawan = $this->Krs->GetSchemaCOAShow($dataCOAPiutangKaryawan, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAPiutangKaryawan);

            // PiutangLainLain
            $listCOAPiutangLainLain = $this->Krs->GetSchemaCOAShow($dataCOAPiutangLainLain, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAPiutangLainLain);

            // PiutangPajak
            $listCOAPiutangPajak = $this->Krs->GetSchemaCOAShow($dataCOAPiutangPajak, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAPiutangPajak);

            // PersediaanBarang
            $listCOAPersediaanBarang = $this->Krs->GetSchemaCOAShow($dataCOAPersediaanBarang, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAPersediaanBarang);

            // UangMukaPembelian
            $listCOAUangMukaPembelian = $this->Krs->GetSchemaCOAShow($dataCOAUangMukaPembelian, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAUangMukaPembelian);

            // PajakDibayarDimuka
            $listCOAPajakDibayarDimuka = $this->Krs->GetSchemaCOAShow($dataCOAPajakDibayarDimuka, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAPajakDibayarDimuka);

            // BebanDibayarDimuka
            $listCOABebanDibayarDimuka = $this->Krs->GetSchemaCOAShow($dataCOABebanDibayarDimuka, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOABebanDibayarDimuka);

            // AsetTidakLancar
            $listCOAAsetTidakLancar = $this->Krs->GetSchemaCOAShow($dataCOAAsetTidakLancar, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAAsetTidakLancar);

            // AsetTetap
            $listCOAAsetTetap = $this->Krs->GetSchemaCOAShow($dataCOAAsetTetap, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAAsetTetap);

            // AkumulasiDepresiasi
            $listCOAAkumulasiDepresiasi = $this->Krs->GetSchemaCOAShow($dataCOAAkumulasiDepresiasi, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAAkumulasiDepresiasi);

            // AsetLainLain
            $listCOAAsetLainLain = $this->Krs->GetSchemaCOAShow($dataCOAAsetLainLain, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAAsetLainLain);

            
            // ---------------- PASIVA ----------------
            // Kewajiban
            $listCOAKewajiban = $this->Krs->GetSchemaCOAShow($dataCOAKewajiban, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAKewajiban);

            // KewajibanLancar
            $listCOAKewajibanLancar = $this->Krs->GetSchemaCOAShow($dataCOAKewajibanLancar, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAKewajibanLancar);

            // HutangUsaha
            $listCOAHutangUsaha = $this->Krs->GetSchemaCOAShow($dataCOAHutangUsaha, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAHutangUsaha);

            // pr($dataCOAHutangUsaha);

            // HutangAfiliasi
            $listCOAHutangAfiliasi = $this->Krs->GetSchemaCOAShow($dataCOAHutangAfiliasi, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAHutangAfiliasi);

            // PendapatanDiterimaDimuka
            $listCOAPendapatanDiterimaDimuka = $this->Krs->GetSchemaCOAShow($dataCOAPendapatanDiterimaDimuka, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAPendapatanDiterimaDimuka);

            // BiayaYangMasihHarusDibayar
            $listCOABiayaYangMasihHarusDibayar = $this->Krs->GetSchemaCOAShow($dataCOABiayaYangMasihHarusDibayar, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOABiayaYangMasihHarusDibayar);

            // HutangPajak
            $listCOAHutangPajak = $this->Krs->GetSchemaCOAShow($dataCOAHutangPajak, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAHutangPajak);

            // HutangBank
            $listCOAHutangBank = $this->Krs->GetSchemaCOAShow($dataCOAHutangBank, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAHutangBank);

            // HutangLeasing
            $listCOAHutangLeasing = $this->Krs->GetSchemaCOAShow($dataCOAHutangLeasing, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAHutangLeasing);

            // HutangPemegangSaham
            $listCOAHutangPemegangSaham = $this->Krs->GetSchemaCOAShow($dataCOAHutangPemegangSaham, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAHutangPemegangSaham);

            // HutangKaryawan
            $listCOAHutangKaryawan = $this->Krs->GetSchemaCOAShow($dataCOAHutangKaryawan, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAHutangKaryawan);

            // HutangLainLain
            $listCOAHutangLainLain = $this->Krs->GetSchemaCOAShow($dataCOAHutangLainLain, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAHutangLainLain);

            // KewajibanTidakLancar
            $listCOAKewajibanTidakLancar = $this->Krs->GetSchemaCOAShow($dataCOAKewajibanTidakLancar, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAKewajibanTidakLancar);

            // KewajibanPajakTangguhan
            $listCOAKewajibanPajakTangguhan = $this->Krs->GetSchemaCOAShow($dataCOAKewajibanPajakTangguhan, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAKewajibanPajakTangguhan);

            // Ekuitas
            $listCOAEkuitas = $this->Krs->GetSchemaCOAShow($dataCOAEkuitas, $dataJournalCOA, 'creditMinusdebet');
            asort($listCOAEkuitas);

            $countData = count($data['rows']);
        } else {
            $listCOAAset = array();
            $listCOAAsetLancar = array();
            $listCOAKasSetaraKas = array();
            $listCOAInvestasi = array();
            $listCOAInvestasiJangkaPanjang = array();
            $listCOAPiutang = array();
            $listCOAPiutangPemegangSaham = array();
            $listCOAPiutangAfiliasi = array();
            $listCOAPiutangKaryawan = array();
            $listCOAPiutangLainLain = array();
            $listCOAPiutangPajak = array();
            $listCOAPersediaanBarang = array();
            $listCOAUangMukaPembelian = array();
            $listCOAPajakDibayarDimuka = array();
            $listCOABebanDibayarDimuka = array();
            $listCOAAsetTidakLancar = array();
            $listCOAAsetTetap = array();
            $listCOAAkumulasiDepresiasi = array();
            $listCOAAsetLainLain = array();
            $listCOAKewajiban = array();
            $listCOAKewajibanLancar = array();
            $listCOAHutangUsaha = array();
            $listCOAHutangAfiliasi = array();
            $listCOAPendapatanDiterimaDimuka = array();
            $listCOABiayaYangMasihHarusDibayar = array();
            $listCOAHutangPajak = array();
            $listCOAHutangBank = array();
            $listCOAHutangLeasing = array();
            $listCOAHutangPemegangSaham = array();
            $listCOAHutangKaryawan = array();
            $listCOAHutangLainLain = array();
            $listCOAKewajibanTidakLancar = array();
            $listCOAKewajibanPajakTangguhan = array();
            $listCOAEkuitas = array();
            $countData = 0;
        }
    }


    // #Update 230409
    public function dataLabaRugiBerjalan($filterConditionDateNow=null, $filterConditionDateAfter=null, &$grandTotalLabaRugiBerjalan) {

        $this->dataLabaRugi($filterConditionDateNow, $filterConditionDateAfter, $listCOAPendapatan, $listCOAReturPendapatan, $listCOAPotonganPendapatan, $listCOABebanPokokPendapatan, $listCOABebanPendapatan, $listCOABebanAdministrasiUmum, $listCOAPendapatanNonOperasional, $listCOABebanNonOperasional);

        //pr($listCOAPendapatan);
        //Total Laba Rugi Berjalan
        //Pendapatan
        $totalDetailPendapatan = $this->Krs->totalLabaRugi($listCOAPendapatan, 'after');
        $grandTotalPendapatan = (empty($totalDetailPendapatan)) ? 0 : round(array_sum($totalDetailPendapatan),2);

        //ReturPendapatan
        $totalDetailReturPendapatan = $this->Krs->totalLabaRugi($listCOAReturPendapatan, 'after');
        $grandTotalReturPendapatan = (empty($totalDetailReturPendapatan)) ? 0 : round(array_sum($totalDetailReturPendapatan),2);

        //PotonganPendapatan
        $totalDetailPotonganPendapatan = $this->Krs->totalLabaRugi($listCOAPotonganPendapatan, 'after');
        $grandTotalPotonganPendapatan = (empty($totalDetailPotonganPendapatan)) ? 0 : round(array_sum($totalDetailPotonganPendapatan),2);

        //BebanPokokPendapatan
        $totalDetailBebanPokokPendapatan = $this->Krs->totalLabaRugi($listCOABebanPokokPendapatan, 'after');
        $grandTotalBebanPokokPendapatan = (empty($totalDetailBebanPokokPendapatan)) ? 0 : round(array_sum($totalDetailBebanPokokPendapatan),2);

        //BebanPendapatan
        $totalDetailBebanPendapatan = $this->Krs->totalLabaRugi($listCOABebanPendapatan, 'after');
        $grandTotalBebanPendapatan = (empty($totalDetailBebanPendapatan)) ? 0 : round(array_sum($totalDetailBebanPendapatan),2);

        //BebanAdministrasiUmum
        $totalDetailBebanAdministrasiUmum = $this->Krs->totalLabaRugi($listCOABebanAdministrasiUmum, 'after');
        $grandTotalBebanAdministrasiUmum = (empty($totalDetailBebanAdministrasiUmum)) ? 0 : round(array_sum($totalDetailBebanAdministrasiUmum),2);

        //PendapatanNonOperasional
        $totalDetailPendapatanNonOperasional = $this->Krs->totalLabaRugi($listCOAPendapatanNonOperasional, 'after');
        $grandTotalPendapatanNonOperasional = (empty($totalDetailPendapatanNonOperasional)) ? 0 : round(array_sum($totalDetailPendapatanNonOperasional),2);

        //BebanNonOperasional
        $totalDetailBebanNonOperasional = $this->Krs->totalLabaRugi($listCOABebanNonOperasional, 'after');
        $grandTotalBebanNonOperasional = (empty($totalDetailBebanNonOperasional)) ? 0 : round(array_sum($totalDetailBebanNonOperasional),2);

        $totalPendapatanBersih = $grandTotalPendapatan-($grandTotalReturPendapatan+$grandTotalPotonganPendapatan);
        $totalLabaKotor = $totalPendapatanBersih-$grandTotalBebanPokokPendapatan;
        $totalLabaOperasional = $totalLabaKotor-($grandTotalBebanPendapatan+$grandTotalBebanAdministrasiUmum);
        $grandTotalLabaRugiBerjalan = ($totalLabaOperasional+$grandTotalPendapatanNonOperasional)-$grandTotalBebanNonOperasional;
    }



    // #Update 230325
   /* public function dataLabaRugi230511($filterConditionDateNow=null, $filterConditionDateAfter=null, &$listCOAPendapatanUsaha, &$listCOAPendapatanLainLain, &$listCOABiayaUmum, &$listCOABiayaPemasaran, &$listCOABebanLainLain, &$listCOAHargaPokokPenjualan, &$listCOABiayaOperasional, &$countData) {
        
        //$this->set(compact('listCOAPendapatanUsaha', 'listCOAPendapatanLainLain', 'listCOABiayaUmum', 'listCOABiayaPemasaran', 'listCOABebanLainLain', 'listCOAHargaPokokPenjualan', 'listCOABiayaOperasional', 'dataDate'));

        if(!empty($filterConditionDateNow) && !empty($filterConditionDateAfter)) {
            // Memanggil data COA.
            //$dataCOAs = $this->Krs->_getDataCOA();
            $dataCOAs = $this->Krs->datarowCOA();
            //$dataCOAs = $this->Krs->datarowCOA(5);

            //pr($dataCOAs);

            // Pendapatan Usaha
            $dataCOAPendapatanUsaha = $this->Krs->getDataCOAByJournalType($dataCOAs, 'pendapatan_usaha');
            $extractCOALevelPendapatanUsaha = $this->Krs->getIdCoaForReport($dataCOAPendapatanUsaha);

            // Pendapatan Lain Lain
            $dataCOAPendapatanLainLain = $this->Krs->getDataCOAByJournalType($dataCOAs, 'pendapatan_lain_lain');
            $extractCOALevelPendapatanLainLain = $this->Krs->getIdCoaForReport($dataCOAPendapatanLainLain);

            // Biaya Umum
            $dataCOABiayaUmum = $this->Krs->getDataCOAByJournalType($dataCOAs, 'biaya_umum');
            $extractCOALevelBiayaUmum = $this->Krs->getIdCoaForReport($dataCOABiayaUmum);

            // Biaya Pemasaran
            $dataCOABiayaPemasaran = $this->Krs->getDataCOAByJournalType($dataCOAs, 'biaya_pemasaran');
            $extractCOALevelBiayaPemasaran = $this->Krs->getIdCoaForReport($dataCOABiayaPemasaran);

            // Beban Lain Lain
            $dataCOABebanLainLain = $this->Krs->getDataCOAByJournalType($dataCOAs, 'beban_lain_lain');
            $extractCOALevelBebanLainLain = $this->Krs->getIdCoaForReport($dataCOABebanLainLain);

            // Harga Pokok Penjualan
            $dataCOAHargaPokokPenjualan = $this->Krs->getDataCOAByJournalType($dataCOAs, 'harga_pokok_penjualan');
            $extractCOALevelHargaPokokPenjualan = $this->Krs->getIdCoaForReport($dataCOAHargaPokokPenjualan);

            // Biaya Operasional
            $dataCOABiayaOperasional = $this->Krs->getDataCOAByJournalType($dataCOAs, 'biaya_operasional');
            $extractCOALevelBiayaOperasional = $this->Krs->getIdCoaForReport($dataCOABiayaOperasional);

            $extractCOALevel = array_merge($extractCOALevelPendapatanUsaha, $extractCOALevelPendapatanLainLain, $extractCOALevelBiayaUmum, $extractCOALevelBiayaPemasaran, $extractCOALevelBebanLainLain,$extractCOALevelHargaPokokPenjualan, $extractCOALevelBiayaOperasional);                

            $this->AccJournal->unbindModel(array('belongsTo' => array('Customer', 'RecipientPayer', 'Branch')));

            $this->AccJournal->virtualFields['coaId'] = 0;
            $this->AccJournal->virtualFields['totalDebet'] = 0;
            $this->AccJournal->virtualFields['totalCredit'] = 0;
            $data['rows'] = $this->AccJournal->find("all", array(
                                "fields" => array("AccJournalLine.acc_chart_of_account_id AS AccJournal__coaId", "SUM(AccJournalLine.debet) AS AccJournal__totalDebet", "SUM(AccJournalLine.credit) AS AccJournal__totalCredit"),
                                "joins" => array(
                                    array(
                                        "table" => "acc_journal_lines",
                                        "alias" => "AccJournalLine",
                                        "type"  => "LEFT",
                                        "foreignKey" => false,
                                        "conditions" => array("AccJournalLine.acc_journal_id = AccJournal.id"),
                                    ),                                      
                                ),                                      
                                "conditions" => array("AccJournalLine.acc_chart_of_account_id" => $extractCOALevel, $filterConditionDateNow),
                                'group' => array('AccJournalLine.acc_chart_of_account_id'),
                                "recursive" => 0
                            ));

            $this->AccJournal->virtualFields['coaId'] = 0;
            $this->AccJournal->virtualFields['totalDebet'] = 0;
            $this->AccJournal->virtualFields['totalCredit'] = 0;
            $data['rowAfter'] = $this->AccJournal->find("all", array(
                                "fields" => array("AccJournalLine.acc_chart_of_account_id AS AccJournal__coaId", "SUM(AccJournalLine.debet) AS AccJournal__totalDebet", "SUM(AccJournalLine.credit) AS AccJournal__totalCredit"),
                                "joins" => array(
                                    array(
                                        "table" => "acc_journal_lines",
                                        "alias" => "AccJournalLine",
                                        "type"  => "LEFT",
                                        "foreignKey" => false,
                                        "conditions" => array("AccJournalLine.acc_journal_id = AccJournal.id"),
                                    ),                                      
                                ),                                      
                                "conditions" => array("AccJournalLine.acc_chart_of_account_id" => $extractCOALevel, $filterConditionDateAfter),
                                'group' => array('AccJournalLine.acc_chart_of_account_id'),
                                "recursive" => 0
                            ));

            $data['show'] = 'Y';

            // $dateFilter = $filterDateStart."^".$filterDateEnd;
            // $dataDate = $this->Krs->fEncode($dateFilter);
            //$this->set(compact('dataCOAPendapatan', 'dataCOAPendapatanLain', 'dataCOAHargaPokokPenjualan', 'dataCOABebanLainLain','dataCOABeban','dataCOABebanPemasaran','dataJournal', 'dates'));

            // 200307
            $dataJournalCOA = Set::combine($data['rows'], '{n}.AccJournal.coaId', array('{0}^{1}', '{n}.AccJournal.totalDebet', '{n}.AccJournal.totalCredit'));
            $dataJournalCOAAfter = Set::combine($data['rowAfter'], '{n}.AccJournal.coaId', array('{0}^{1}', '{n}.AccJournal.totalDebet', '{n}.AccJournal.totalCredit'));

            // Pendapatan Usaha
            $listCOAPendapatanUsaha = $this->Krs->GetSchemaCOAGlobalShow($dataCOAPendapatanUsaha, $dataJournalCOA, $dataJournalCOAAfter, 'credit');
            asort($listCOAPendapatanUsaha);
            // pr($listCOAPendapatanUsaha);

            // Pendapatan Lain Lain
            $listCOAPendapatanLainLain = $this->Krs->GetSchemaCOAGlobalShow($dataCOAPendapatanLainLain, $dataJournalCOA, $dataJournalCOAAfter, 'credit');
            asort($listCOAPendapatanLainLain);

            // Biaya Umum
            $listCOABiayaUmum = $this->Krs->GetSchemaCOAGlobalShow($dataCOABiayaUmum, $dataJournalCOA, $dataJournalCOAAfter, 'debetMinuscredit');
            asort($listCOABiayaUmum);

            // Biaya Pemasaran
            $listCOABiayaPemasaran = $this->Krs->GetSchemaCOAGlobalShow($dataCOABiayaPemasaran, $dataJournalCOA, $dataJournalCOAAfter, 'debetMinuscredit');
            asort($listCOABiayaPemasaran);

            // Beban Lain Lain
            $listCOABebanLainLain = $this->Krs->GetSchemaCOAGlobalShow($dataCOABebanLainLain, $dataJournalCOA, $dataJournalCOAAfter, 'debetMinuscredit');
            asort($listCOABebanLainLain);

            // Harga Pokok Penjualan
            $listCOAHargaPokokPenjualan = $this->Krs->GetSchemaCOAGlobalShow($dataCOAHargaPokokPenjualan, $dataJournalCOA, $dataJournalCOAAfter, 'debetMinuscredit');
            asort($listCOAHargaPokokPenjualan);

            // Biaya Operasional
            $listCOABiayaOperasional = $this->Krs->GetSchemaCOAGlobalShow($dataCOABiayaOperasional, $dataJournalCOA, $dataJournalCOAAfter, 'debetMinuscredit');
            asort($listCOABiayaOperasional);

            $countData = count($data['rows']);              
        } else {
            $listCOAPendapatanUsaha = array();
            $listCOAPendapatanLainLain = array();
            $listCOABiayaUmum = array();
            $listCOABiayaPemasaran = array();
            $listCOABebanLainLain = array();
            $listCOAHargaPokokPenjualan = array();
            $listCOABiayaOperasional = array();
            $countData = 0;
            // $dataDate = array();
        }
        // $this->set(compact('listCOAPendapatanUsaha', 'listCOAPendapatanLainLain', 'listCOABiayaUmum', 'listCOABiayaPemasaran', 'listCOABebanLainLain', 'listCOAHargaPokokPenjualan', 'listCOABiayaOperasional', 'dataDate'));
    }*/
    
    



    /*public function balanceSheetPercentReport230511()
    {
        $accJournal = $this->AccJournals->newEmptyEntity();
        $this->loadModel('AccChartOfAccounts');

        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            // pr($dataRow);
            
            $dataFilterDate = $dataRow['filterDate'];
            $filterCheckGlobal = $dataRow['checkGlobal'];
            $filterDate = $this->Krs->dateTo($dataFilterDate);
            $year = substr($filterDate, 0, 4);
            $beforeDate = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year-1));
            $beforeYear = date("Y", mktime(0, 0, 0, 12, 31, $year-1));

            if($year=='2021') {
                $beforeLabaRugiBerjalanDate = array("YEAR(AccJournals.date) ="=> '2020');
            } elseif($year=='2022') {
                $beforeLabaRugiBerjalanDate =  array("YEAR(AccJournals.date) BETWEEN '2020' AND '2021'");
            } else {
                $beforeLabaRugiBerjalanDate = array("YEAR(AccJournals.date) ="=> '2020');
            }

            $filterConditionDate = ($filterDate!="") ? array("AccJournals.date <="=>$filterDate):array();            
            $filterConditionDateBeforePrive = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$beforeDate):array();
            $filterConditionDateBeforeLabaRugiBerjalan = ($beforeDate!="") ? array("YEAR(AccJournals.date) ="=>$beforeYear, "AccJournals.date <="=>$beforeDate):array();
            $filterConditionDatePrive = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();
            $filterConditionDateSaldoDitahan = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();
            $filterConditionDateLabaRugiBerjalan = ($filterDate!="") ? array("YEAR(AccJournals.date) ="=>$year, "AccJournals.date <="=>$filterDate):array();

            // Memanggil data COA.
            $dataCOAs = $this->AccChartOfAccounts->datarowCOA();             

            // Mengambil data COA Id
            // $extractCOALevel = $this->getCoaByJournal($dataCOAs, 'LR');
            
            // --- AKTIVA ---
            // Kas & Bank
            $dataCOAKasBank = Hash::extract($dataCOAs, '{n}[journal_type=kas_bank]');
            $dataCOAKasBanks = Hash::extract($dataCOAKasBank, '{n}[level=5]');
            $extractCOALevelKasBank = (!empty($dataCOAKasBanks)) ? Hash::extract($dataCOAKasBanks, '{n}.id') : array();

            // Piutang
            $dataCOAPiutang = Hash::extract($dataCOAs, '{n}[journal_type=akun_piutang]');
            $dataCOAPiutangs = Hash::extract($dataCOAPiutang, '{n}[level=5]');
            $extractCOALevelPiutang = (!empty($dataCOAPiutangs)) ? Hash::extract($dataCOAPiutangs, '{n}.id') : array();

            // Aktiva Tetap
            $dataCOAAktivaTetap = Hash::extract($dataCOAs, '{n}[journal_type=aktiva_tetap]');
            $dataCOAAktivaTetaps = Hash::extract($dataCOAAktivaTetap, '{n}[level=5]');
            $extractCOALevelAktivaTetap = (!empty($dataCOAAktivaTetaps)) ? Hash::extract($dataCOAAktivaTetaps, '{n}.id') : array();

            // Aktiva Lancar Lainnya
            $dataCOAAktivaLancarLainnya = Hash::extract($dataCOAs, '{n}[journal_type=aktiva_lancar_lainnya]');
            $dataCOAAktivaLancarLainnyas = Hash::extract($dataCOAAktivaLancarLainnya, '{n}[level=5]');
            $extractCOALevelAktivaLancarLainnya = (!empty($dataCOAAktivaLancarLainnyas)) ? Hash::extract($dataCOAAktivaLancarLainnyas, '{n}.id') : array();

            // Akumulasi Penyusutan
            $dataCOAAkumulasiPenyusutan = Hash::extract($dataCOAs, '{n}[journal_type=akumulasi_penyusutan]');
            $dataCOAAkumulasiPenyusutans = Hash::extract($dataCOAAkumulasiPenyusutan, '{n}[level=5]');
            $extractCOALevelAkumulasiPenyusutan = (!empty($dataCOAAkumulasiPenyusutans)) ? Hash::extract($dataCOAAkumulasiPenyusutans, '{n}.id') : array();

            // Hutang
            $dataCOAHutang = Hash::extract($dataCOAs, '{n}[journal_type=akun_hutang]');
            $dataCOAHutangs = Hash::extract($dataCOAHutang, '{n}[level=5]');
            $extractCOALevelHutang = (!empty($dataCOAHutangs)) ? Hash::extract($dataCOAHutangs, '{n}.id') : array();

            // Hutang Lancar
            $dataCOAHutangLancar = Hash::extract($dataCOAs, '{n}[journal_type=hutang_lancar_lainnya]');
            $dataCOAHutangLancars = Hash::extract($dataCOAHutangLancar, '{n}[level=5]');
            $extractCOALevelHutangLancar = (!empty($dataCOAHutangLancars)) ? Hash::extract($dataCOAHutangLancars, '{n}.id') : array();

            // Modal
            $dataCOAModal = Hash::extract($dataCOAs, '{n}[journal_type=modal]');
            $dataCOAModals = Hash::extract($dataCOAModal, '{n}[level=5]');
            $extractCOALevelModal = (!empty($dataCOAModals)) ? Hash::extract($dataCOAModals, '{n}.id') : array();
            
            // Saldo Ditahan
            $dataCOASaldoDitahan = Hash::extract($dataCOAs, '{n}[journal_type=saldo_ditahan]');
            $dataCOASaldoDitahans = Hash::extract($dataCOASaldoDitahan, '{n}[level=5]');
            $extractCOALevelSaldoDitahan = (!empty($dataCOASaldoDitahans)) ? Hash::extract($dataCOASaldoDitahans, '{n}.id') : array();

            // Prive
            $dataCOAPrive = Hash::extract($dataCOAs, '{n}[journal_type=prive]');
            $dataCOAPrives = Hash::extract($dataCOAPrive, '{n}[level=5]');
            $extractCOALevelPrive = (!empty($dataCOAPrives)) ? Hash::extract($dataCOAPrives, '{n}.id') : array();

            $extractCOAAktivaPasivaId = array_merge($extractCOALevelKasBank, $extractCOALevelPiutang, $extractCOALevelAktivaTetap, $extractCOALevelAktivaLancarLainnya, $extractCOALevelAkumulasiPenyusutan, $extractCOALevelHutang, $extractCOALevelHutangLancar, $extractCOALevelModal);


            // Laba/Rugi Berjalan
            // Pendapatan
            $dataCOAPendapatan = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan]');
            $dataCOAPendapatans = Hash::extract($dataCOAPendapatan, '{n}[level=5]');
            $extractCOALevelPendapatan = (!empty($dataCOAPendapatans)) ? Hash::extract($dataCOAPendapatans, '{n}.id') : array();

            // PotonganPenjualan
            $dataCOAPotonganPenjualan = Hash::extract($dataCOAs, '{n}[journal_type=potongan_penjualan]');
            $dataCOAPotonganPenjualans = Hash::extract($dataCOAPotonganPenjualan, '{n}[level=5]');
            $extractCOALevelPotonganPenjualan = (!empty($dataCOAPotonganPenjualans)) ? Hash::extract($dataCOAPotonganPenjualans, '{n}.id') : array();

            // Pendapatan Lain
            $dataCOAPendapatanLain = Hash::extract($dataCOAs, '{n}[journal_type=pendapatan_lain]');
            $dataCOAPendapatanLains = Hash::extract($dataCOAPendapatanLain, '{n}[level=5]');
            $extractCOALevelPendapatanLain = (!empty($dataCOAPendapatanLains)) ? Hash::extract($dataCOAPendapatanLains, '{n}.id') : array();

            // Harga Pokok Penjualan
            $dataCOAHargaPokokPenjualan = Hash::extract($dataCOAs, '{n}[journal_type=harga_pokok_penjualan]');
            $dataCOAHargaPokokPenjualans = Hash::extract($dataCOAHargaPokokPenjualan, '{n}[level=5]');
            $extractCOALevelHargaPokokPenjualan = (!empty($dataCOAHargaPokokPenjualans)) ? Hash::extract($dataCOAHargaPokokPenjualans, '{n}.id') : array();

            // Beban Lain Lain
            $dataCOABebanLainLain = Hash::extract($dataCOAs, '{n}[journal_type=beban_lain_lain]');
            $dataCOABebanLainLains = Hash::extract($dataCOABebanLainLain, '{n}[level=5]');
            $extractCOALevelBebanLainLain = (!empty($dataCOABebanLainLains)) ? Hash::extract($dataCOABebanLainLains, '{n}.id') : array();

            // Beban
            $dataCOABeban = Hash::extract($dataCOAs, '{n}[journal_type=beban]');
            $dataCOABebans = Hash::extract($dataCOABeban, '{n}[level=5]');
            $extractCOALevelBeban = (!empty($dataCOABebans)) ? Hash::extract($dataCOABebans, '{n}.id') : array();

            // Beban Pemasaran
            $dataCOABebanPemasaran = Hash::extract($dataCOAs, '{n}[journal_type=beban_pemasaran]');
            $dataCOABebanPemasarans = Hash::extract($dataCOABebanPemasaran, '{n}[level=5]');
            $extractCOALevelBebanPemasaran = (!empty($dataCOABebanPemasarans)) ? Hash::extract($dataCOABebanPemasarans, '{n}.id') : array();

            $extractCOALabaRugiBerjalanId = array_merge($extractCOALevelPendapatan, $extractCOALevelPotonganPenjualan, $extractCOALevelPendapatanLain, $extractCOALevelHargaPokokPenjualan, $extractCOALevelBebanLainLain, $extractCOALevelBeban, $extractCOALevelBebanPemasaran);

            // --- PASIVA ---
            //count($extractCOALabaRugiBerjalanId) > 0 ?  $extractCOALabaRugiBerjalanId : [null]
            $data['rows'] = $this->AccJournals->find('all')
                    ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                    ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOAAktivaPasivaId) > 0 ?  $extractCOAAktivaPasivaId : [null], $filterConditionDate, 'AccJournals.status'=>'posting'])
                    ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                    ->group(['AccJournalLines.acc_chart_of_account_id'])
                    ->leftJoinWith('AccJournalLines')
                    ->enableAutoFields(true)
                    ->toArray();

            $data['priveRows'] = $this->AccJournals->find('all')
                ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelPrive) > 0 ?  $extractCOALevelPrive : [null], $filterConditionDatePrive, 'AccJournals.status'=>'posting'])
                ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                ->group(['AccJournalLines.acc_chart_of_account_id'])
                ->leftJoinWith('AccJournalLines')
                //->innerJoinWith('AccChartOfAccounts')
                ->enableAutoFields(true)
                ->toArray();

            $data['saldoDitahanRows'] = $this->AccJournals->find('all')
                ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelSaldoDitahan) > 0 ?  $extractCOALevelSaldoDitahan : [null], $filterConditionDateSaldoDitahan, 'AccJournals.status'=>'posting'])
                ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                ->group(['AccJournalLines.acc_chart_of_account_id'])
                ->leftJoinWith('AccJournalLines')
                //->innerJoinWith('AccChartOfAccounts')
                ->enableAutoFields(true)
                ->toArray();

            $data['labaRugiBerjalanRows'] = $this->AccJournals->find('all')
                ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALabaRugiBerjalanId) > 0 ?  $extractCOALabaRugiBerjalanId : [null], $filterConditionDateLabaRugiBerjalan, 'AccJournals.status'=>'posting'])
                ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                ->group(['AccJournalLines.acc_chart_of_account_id'])
                ->leftJoinWith('AccJournalLines')
                //->innerJoinWith('AccChartOfAccounts')
                ->enableAutoFields(true)
                ->toArray();

            $data['priveBeforeRows'] = $this->AccJournals->find('all')
                ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALevelPrive) > 0 ?  $extractCOALevelPrive : [null], $filterConditionDateBeforePrive, 'AccJournals.status'=>'posting'])
                ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                ->group(['AccJournalLines.acc_chart_of_account_id'])
                ->leftJoinWith('AccJournalLines')
                //->innerJoinWith('AccChartOfAccounts')
                ->enableAutoFields(true)
                ->toArray();

            

            $data['labaRugiBerjalanBeforeRows'] = $this->AccJournals->find('all')
                ->select(['coaId' => "AccJournalLines.acc_chart_of_account_id", 'totalDebet' => "SUM(AccJournalLines.debet)", 'totalCredit' => "SUM(AccJournalLines.credit)"])
                ->where(['AccJournalLines.acc_chart_of_account_id IN'=>count($extractCOALabaRugiBerjalanId) > 0 ?  $extractCOALabaRugiBerjalanId : [null], $filterConditionDateBeforeLabaRugiBerjalan, 'AccJournals.status'=>'posting'])
                ->order(['AccJournalLines.acc_chart_of_account_id' => 'ASC'])
                ->group(['AccJournalLines.acc_chart_of_account_id'])
                ->leftJoinWith('AccJournalLines')
                //->innerJoinWith('AccChartOfAccounts')
                ->enableAutoFields(true)
                ->toArray();

            $dataJournalCOA = Hash::combine($data['rows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
            $dataJournalCOALabaRugiBerjalan = Hash::combine($data['labaRugiBerjalanRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
            $dataJournalCOAPrive = Hash::combine($data['priveRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
            $dataJournalCOASaldoDitahan = Hash::combine($data['saldoDitahanRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
            $dataJournalCOABeforeLabaRugiBerjalan = Hash::combine($data['labaRugiBerjalanBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
            $dataJournalCOABeforePrive = Hash::combine($data['priveBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);
            // $dataJournalCOABeforeSaldoDitahan = Hash::combine($data['saldoDitahanBeforeRows'], '{n}.coaId', ['%s^%s', '{n}.totalDebet', '{n}.totalCredit']);

            $listCOAKasBank = $this->Krs->GetSchemaCOAShow($dataCOAKasBank, $dataJournalCOA, 'debetMinuscredit');
            asort($listCOAKasBank);

            $listCOAPiutang = $this->Krs->GetSchemaCOAShow($dataCOAPiutang, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAPiutang);

                //pr($listCOAPiutang);
                // $listCOAPiutangUsaha = $this->Krs->GetSchemaCOAShow($dataCOALevelPiutangUsaha, $dataJournalCOA, 'debetMinuscredit');
                // asort($listCOAPiutangUsaha);

                $listCOAAktivaTetap = $this->Krs->GetSchemaCOAShow($dataCOAAktivaTetap, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAAktivaTetap);

                $listCOAAktivaLancarLainnya = $this->Krs->GetSchemaCOAShow($dataCOAAktivaLancarLainnya, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAAktivaLancarLainnya);

                $listCOAAkumulasiPenyusutan = $this->Krs->GetSchemaCOAShow($dataCOAAkumulasiPenyusutan, $dataJournalCOA, 'debetMinuscredit');
                asort($listCOAAkumulasiPenyusutan);

                //Pasiva
                $listCOAHutang = $this->Krs->GetSchemaCOAShow($dataCOAHutang, $dataJournalCOA, 'debetMinuscredit', true);
                asort($listCOAHutang);

                $listCOAHutangLancar = $this->Krs->GetSchemaCOAShow($dataCOAHutangLancar, $dataJournalCOA, 'debetMinuscredit', true);
                asort($listCOAHutangLancar);

                $listCOAModal = $this->Krs->GetSchemaCOAShow($dataCOAModal, $dataJournalCOA, 'debetMinuscredit', true);
                asort($listCOAModal);

                
                $listCOASaldoDitahan = $this->Krs->GetSchemaCOAShow($dataCOASaldoDitahan, $dataJournalCOASaldoDitahan, 'debetMinuscredit', true);
                asort($listCOASaldoDitahan);

                $listCOAPrive = $this->Krs->GetSchemaCOAShow($dataCOAPrive, $dataJournalCOAPrive, 'debetMinuscredit', true);
                asort($listCOAPrive);

                //Laba Rugi Berjalan
                $listCOAPendapatan = $this->Krs->GetSchemaCOAShow($dataCOAPendapatan, $dataJournalCOALabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOAPendapatan);

                $listCOAPotonganPenjualan = $this->Krs->GetSchemaCOAShow($dataCOAPotonganPenjualan, $dataJournalCOALabaRugiBerjalan, 'debet');
                asort($listCOAPotonganPenjualan);
                //pr($listCOAPendapatan);

                $listCOAPendapatanLain = $this->Krs->GetSchemaCOAShow($dataCOAPendapatanLain, $dataJournalCOALabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOAPendapatanLain);

                $listCOAHargaPokokPenjualan = $this->Krs->GetSchemaCOAShow($dataCOAHargaPokokPenjualan, $dataJournalCOALabaRugiBerjalan, 'debet');
                asort($listCOAHargaPokokPenjualan);

                $listCOABebanLainLain = $this->Krs->GetSchemaCOAShow($dataCOABebanLainLain, $dataJournalCOALabaRugiBerjalan, 'debet');
                asort($listCOABebanLainLain);

                $listCOABeban = $this->Krs->GetSchemaCOAShow($dataCOABeban, $dataJournalCOALabaRugiBerjalan, 'debet');
                asort($listCOABeban);

                $listCOABebanPemasaran = $this->Krs->GetSchemaCOAShow($dataCOABebanPemasaran, $dataJournalCOALabaRugiBerjalan, 'debet');
                asort($listCOABebanPemasaran);

                //Total Laba Rugi Berjalan
                $totalDetailPendapatan = $this->Krs->totalCOADetail($listCOAPendapatan);
                $grandTotalPendapatan = (empty($totalDetailPendapatan)) ? 0 : round(array_sum($totalDetailPendapatan),2);

                $totalDetailPotonganPenjualan = $this->Krs->totalCOADetail($listCOAPotonganPenjualan);
                $grandTotalPotonganPenjualan = (empty($totalDetailPotonganPenjualan)) ? 0 : round(array_sum($totalDetailPotonganPenjualan),2);

                $totalDetailPendapatanLain = $this->Krs->totalCOADetail($listCOAPendapatanLain);
                $grandTotalPendapatanLain = (empty($totalDetailPendapatanLain)) ? 0 : round(array_sum($totalDetailPendapatanLain),2);

                $totalDetailHargaPokokPenjualan = $this->Krs->totalCOADetail($listCOAHargaPokokPenjualan);
                $grandTotalHargaPokokPenjualan = (empty($totalDetailHargaPokokPenjualan)) ? 0 : round(array_sum($totalDetailHargaPokokPenjualan),2);

                $totalDetailBeban = $this->Krs->totalCOADetail($listCOABeban);
                $grandTotalBeban = (empty($totalDetailBeban)) ? 0 : round(array_sum($totalDetailBeban),2);

                $totalDetailBebanPemasaran = $this->Krs->totalCOADetail($listCOABebanPemasaran);
                $grandTotalBebanPemasaran = (empty($totalDetailBebanPemasaran)) ? 0 : round(array_sum($totalDetailBebanPemasaran),2);

                $totalDetailBebanLainLain = $this->Krs->totalCOADetail($listCOABebanLainLain);
                $grandTotalBebanLainLain = (empty($totalDetailBebanLainLain)) ? 0 : round(array_sum($totalDetailBebanLainLain),2);

               $totalGrandPendapatan = ($grandTotalPendapatan+$grandTotalPendapatanLain)-$grandTotalPotonganPenjualan;
                $totalGrandLabaKotor = $totalGrandPendapatan-$grandTotalHargaPokokPenjualan;
                $totalGrandLabaOperasional = $totalGrandLabaKotor-($grandTotalBeban+$grandTotalBebanPemasaran);
                $totalGrandLabaRugiBerjalan = $totalGrandLabaOperasional-$grandTotalBebanLainLain;
               // pr($totalGrandLabaKotor.'-('.$grandTotalBeban.'+'.$grandTotalBebanPemasaran.')');
                //Before Date
                //pr($dataCOASaldoDitahan);
                //$listCOABeforeSaldoDitahan = $this->Krs->GetSchemaCOAShow($dataCOASaldoDitahan, $dataJournalCOABeforeSaldoDitahan, 'debetMinuscredit', true);
                //asort($listCOABeforeSaldoDitahan);

                $listCOABeforePrive = $this->Krs->GetSchemaCOAShow($dataCOAPrive, $dataJournalCOABeforePrive, 'debetMinuscredit', true);
                asort($listCOABeforePrive);

                //Laba Rugi Berjalan
                $listCOABeforePendapatan = $this->Krs->GetSchemaCOAShow($dataCOAPendapatan, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforePendapatan);

                $listCOABeforePotonganPenjualan = $this->Krs->GetSchemaCOAShow($dataCOAPotonganPenjualan, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
                asort($listCOABeforePotonganPenjualan);
                //pr($listCOABeforePendapatan);

                $listCOABeforePendapatanLain = $this->Krs->GetSchemaCOAShow($dataCOAPendapatanLain, $dataJournalCOABeforeLabaRugiBerjalan, 'creditMinusdebet');
                asort($listCOABeforePendapatanLain);

                $listCOABeforeHargaPokokPenjualan = $this->Krs->GetSchemaCOAShow($dataCOAHargaPokokPenjualan, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
                asort($listCOABeforeHargaPokokPenjualan);

                $listCOABeforeBebanLainLain = $this->Krs->GetSchemaCOAShow($dataCOABebanLainLain, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
                asort($listCOABeforeBebanLainLain);

                $listCOABeforeBeban = $this->Krs->GetSchemaCOAShow($dataCOABeban, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
                asort($listCOABeforeBeban);

                $listCOABeforeBebanPemasaran = $this->Krs->GetSchemaCOAShow($dataCOABebanPemasaran, $dataJournalCOABeforeLabaRugiBerjalan, 'debet');
                asort($listCOABeforeBebanPemasaran);

                //Total Laba Rugi Berjalan
                $totalDetailBeforePendapatan = $this->Krs->totalCOADetail($listCOABeforePendapatan);
                $grandTotalBeforePendapatan = (empty($totalDetailBeforePendapatan)) ? 0 : round(array_sum($totalDetailBeforePendapatan),2);

                $totalDetailBeforePotonganPenjualan = $this->Krs->totalCOADetail($listCOABeforePotonganPenjualan);
                $grandTotalBeforePotonganPenjualan = (empty($totalDetailBeforePotonganPenjualan)) ? 0 : round(array_sum($totalDetailBeforePotonganPenjualan),2);

                $totalDetailBeforePendapatanLain = $this->Krs->totalCOADetail($listCOABeforePendapatanLain);
                $grandTotalBeforePendapatanLain = (empty($totalDetailBeforePendapatanLain)) ? 0 : round(array_sum($totalDetailBeforePendapatanLain),2);

                $totalDetailBeforeHargaPokokPenjualan = $this->Krs->totalCOADetail($listCOABeforeHargaPokokPenjualan);
                $grandTotalBeforeHargaPokokPenjualan = (empty($totalDetailBeforeHargaPokokPenjualan)) ? 0 : round(array_sum($totalDetailBeforeHargaPokokPenjualan),2);

                $totalDetailBeforeBeban = $this->Krs->totalCOADetail($listCOABeforeBeban);
                $grandTotalBeforeBeban = (empty($totalDetailBeforeBeban)) ? 0 : round(array_sum($totalDetailBeforeBeban),2);

                $totalDetailBeforeBebanPemasaran = $this->Krs->totalCOADetail($listCOABeforeBebanPemasaran);
                $grandTotalBeforeBebanPemasaran = (empty($totalDetailBeforeBebanPemasaran)) ? 0 : round(array_sum($totalDetailBeforeBebanPemasaran),2);

                $totalDetailBeforeBebanLainLain = $this->Krs->totalCOADetail($listCOABeforeBebanLainLain);
                $grandTotalBeforeBebanLainLain = (empty($totalDetailBeforeBebanLainLain)) ? 0 : round(array_sum($totalDetailBeforeBebanLainLain),2);

                $totalGrandBeforePendapatan = ($grandTotalBeforePendapatan+$grandTotalBeforePendapatanLain)-$grandTotalBeforePotonganPenjualan;
                $totalGrandBeforeLabaKotor = $totalGrandBeforePendapatan-$grandTotalBeforeHargaPokokPenjualan;
                $totalGrandBeforeLabaOperasional = $totalGrandBeforeLabaKotor-($grandTotalBeforeBeban+$grandTotalBeforeBebanPemasaran);
                $totalGrandBeforeLabaRugiBerjalan = $totalGrandBeforeLabaOperasional-$grandTotalBeforeBebanLainLain;

                //Untuk mengambil data LabaRugiBerjalanSebelumnya
                if($year=='2022') {
                    $yearBefore = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year-1));
                    //$yearBefore = $year-1;
                    $this->rowSaldoDitahan($yearBefore, $totalSaldoDitahanBefore, $totalBeforePrive, $totalBeforeLabaRugiBerjalan);
                    $this->rowSaldoDitahan($filterDate, $totalSaldoDitahanBefore2, $totalBeforePrive2, $totalBeforeLabaRugiBerjalan2);
                    $total2021 = $totalSaldoDitahanBefore+$totalBeforePrive+$totalBeforeLabaRugiBerjalan;

                    $grandTotalBeforeSaldoDitahan = $total2021+$totalBeforePrive2+$totalBeforeLabaRugiBerjalan2;
                } else {
                    $grandTotalBeforeSaldoDitahan = $this->rowSaldoDitahan($filterDate);
                }
                
                // pr($grandTotalBeforeSaldoDitahan);
                $dataFilters = $filterDate.'^'.$filterCheckGlobal;
                
                //grandTotalBeforeSaldoDitahan
                $this->set(compact('listCOAKasBank', 'listCOAPiutang', 'listCOAAktivaTetap', 'listCOAAktivaLancarLainnya', 'listCOAAkumulasiPenyusutan', 'listCOAHutang', 'listCOAHutangLancar', 'listCOAModal', 'listCOASaldoDitahan', 'listCOAPrive', 'listCOAPendapatan', 'listCOAPotonganPenjualan', 'listCOAPendapatanLain', 'listCOAHargaPokokPenjualan', 'listCOABebanLainLain', 'listCOABeban', 'listCOABebanPemasaran', 'totalGrandLabaRugiBerjalan', 'listCOABeforePrive', 'totalGrandBeforeLabaRugiBerjalan', 'grandTotalBeforeSaldoDitahan'));
                //, 'filterCheckGlobal'

            $data['show'] = 'Y';
        } else {
            $data['show'] = 'N';
            $dataFilters = '^';
        }
        $dataFilter = $this->Krs->fEncode($dataFilters);
        $this->set(compact('accJournal', 'data', 'dataFilter'));
    }*/



    /**
     * Delete method
     *
     * @param string|null $id Acc Journal id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accJournal = $this->AccJournals->get($id);
        if ($this->AccJournals->delete($accJournal)) {
            $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));
            //$this->Flash->success(__('The acc journal has been deleted.'));
        } else {
            $this->Flash->error(__('Maaf, data gagal disimpan. Silakan, coba kembali.'));
            // $this->Flash->error(__('The acc journal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
