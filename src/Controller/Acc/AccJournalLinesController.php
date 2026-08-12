<?php
declare(strict_types=1);

namespace App\Controller\Acc;

use App\Controller\AppController;
use CakePdf\Pdf\CakePdf;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;

/**
 * AccJournalLines Controller
 *
 * @property \App\Model\Table\AccJournalLinesTable $accJournalLines
 * @method \App\Model\Entity\AccJournalLine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccJournalLinesController extends AppController
{
    public function getGeneralJournal()
    {
        // $this->loadModel("AccChartOfAccount");
        // $this->loadModel("AccJournal");
        // $this->autoRender=false;
        $db = ConnectionManager::get('default');

        $params['draw'] = (isset($_REQUEST['draw'])) ? $_REQUEST['draw'] : 1;
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 1;
        $length = (isset($_REQUEST['length'])) ? $_REQUEST['length'] : 1;

        // Used when ajax loads data
        $dateJournal = (isset($_REQUEST['date-journal'])) ? $_REQUEST['date-journal'] : "^";
        // $dateJournal = (isset($_REQUEST['dateJournal'])) ? $_REQUEST['dateJournal'] : "^";
        // pr($_REQUEST);
        list($filterDateFrom, $filterDateEnd) = explode("^", $dateJournal);

        $dateFrom = $this->Krs->dateTo($filterDateFrom);
        $dateTo = $this->Krs->dateTo($filterDateEnd);
        $filterCondition = (empty($dateFrom) && empty($dateTo)) ? array() : 'Aj.date BETWEEN "'.$dateFrom.'" AND "'.$dateTo.'"';


        $total_count = $db->execute("SELECT * FROM acc_journal_lines Ajl LEFT JOIN acc_chart_of_accounts Acoa ON Acoa.id = Ajl.acc_chart_of_account_id LEFT JOIN acc_journals Aj ON Aj.id = Ajl.acc_journal_id WHERE Aj.journal_type= 'Memorial' AND $filterCondition ORDER BY Ajl.position ASC")->fetchAll('assoc');

        // $totalRow = Hash::format($total_count, ['{n}.debet', '{n}.credit'], '%2$d, %1$s');
        // $totalRow = Hash::combine($total_count, '{n}.id', ['%s^%s', '{n}.User.Data.user', '{n}.User.Data.name']);
        // $totalRow = Hash::combine($total_count, '{n}.debet', '{n}.credit', '{n}.id');
        $totalRow = array();
        foreach ($total_count as $rowValue) {
            $totalRow['debet'][] = $rowValue['debet'];
            $totalRow['credit'][] = $rowValue['credit'];
        }
        $totalRowDebet = (!empty($totalRow['debet'])) ? array_sum($totalRow['debet']) : 0;
        $totalRowCredit = (!empty($totalRow['credit'])) ? array_sum($totalRow['credit']) : 0;
        // $totalRowDebet = array_sum($totalRow['debet']);
        // $totalRowCredit = array_sum($totalRow['credit']);
        // pr($totalRowDebet);

        if(!empty($total_count)) { 
            $data = $db->execute("SELECT Ajl.id, Ajl.acc_journal_id, Aj.recipient_payer_name AS recipientPayerName, Aj.date, DATE_FORMAT(Aj.date,'%d/%m/%Y') AS dateJournal, IF(Ajl.ledger_dc='D','Debit','Credit') AS ledgerdc, Ajl.ledger_dc, Ajl.name, Ajl.position, Ajl.debet, Ajl.credit, Acoa.code, Acoa.name, Acoa.customer_id, IFNULL(Ajl.name, CONCAT(Cs.title,' ',Cs.name)) AS coaCustomerName, CONCAT('(', Acoa.code, ') ',IFNULL(Acoa.name, CONCAT(Cs.title,' ',Cs.name))) AS coaName FROM acc_journal_lines Ajl LEFT JOIN acc_chart_of_accounts Acoa ON Acoa.id = Ajl.acc_chart_of_account_id LEFT JOIN acc_journals Aj ON Aj.id = Ajl.acc_journal_id LEFT JOIN customers Cs ON Cs.id = Acoa.customer_id WHERE Aj.journal_type= 'Memorial' AND $filterCondition ORDER BY Ajl.position ASC LIMIT $start, $length")->fetchAll('assoc');

            $json_data = array(
                "draw" => intval($params['draw']),
                "recordsTotal" => count($total_count),
                "recordsFiltered" => count($total_count),
                "data" => $data,   // total data array
                "totalDebet" => $totalRowDebet,
                "totalCredit" => $totalRowCredit,
            );
        } else {
            $json_data = array(
                "draw" => 1,
                "recordsTotal" => 1,
                "recordsFiltered" => 1,
                "data" => [],   // total data array
                "totalDebet" => 0,
                "totalCredit" => 0,
            );
        }
        
        // pr($data);

        return $this->response->withType("application/json")->withStringBody(json_encode($json_data));


            
        /*    $dateJournal = $this->params["url"]["dateJournal"];
            //pr($dateJournal);
            list($filterDateFrom, $filterDateEnd) = explode("^", $dateJournal);

            $dateFrom = $this->KrsCom->_convertDate($filterDateFrom);
            $dateTo = $this->KrsCom->_convertDate($filterDateEnd);
            $filterCondition = (empty($dateFrom) && empty($dateTo)) ? array() : array('AccJournal.date BETWEEN ? AND ?' => array($dateFrom, $dateTo));

            $this->AccChartOfAccount->virtualFields = array(
                'customer_name' => "",
                'coa_name' => "",
            );
            $this->AccJournalLine->virtualFields = array(
                'ledgerdc' => "",
            );
             $this->AccJournal->virtualFields = array(
                'dateJournal' => "",
            );
            $this->paginate = array(
                //'link' => array(
                    "fields" => array(
                        "AccJournalLine.acc_journal_id", "AccJournalLine.id", "AccJournal.date", "DATE_FORMAT(AccJournal.date,'%d/%m/%Y') AS AccJournal__dateJournal", "AccJournalLine.acc_chart_of_account_id", "IF(AccJournalLine.ledger_dc='D','Debit','Credit') AS AccJournalLine__ledgerdc", "AccJournalLine.ledger_dc", "AccJournalLine.name", "AccJournalLine.position", "AccJournalLine.debet", "AccJournalLine.credit", "AccChartOfAccount.id", "AccChartOfAccount.code", "AccChartOfAccount.name", "AccChartOfAccount.customer_id", "CustomerCoa.title", "CustomerCoa.name", "CONCAT('(', AccChartOfAccount.code, ') ',IFNULL(AccChartOfAccount.name, CONCAT(CustomerCoa.title,' ',CustomerCoa.name))) AS AccChartOfAccount__customer_name"),
                    
                    "conditions" => array("AccJournal.journal_type" => "Memorial", $filterCondition),
                    "order" => array("AccJournal.date" => 'DESC', "AccJournal.code" => 'ASC', "AccJournalLine.id" => 'ASC'),
                    "recursive" => 0,
                    'limit' => 10,
              // ),

            );
            
            $this->AccJournal->virtualFields['totalDebet'] = 0;
            $this->AccJournal->virtualFields['totalCredit'] = 0;
            $dataJournalLines = $this->AccJournalLine->find("first", array(
                            "fields" => array("SUM(AccJournalLine.debet) AS totalDebet", "SUM(AccJournalLine.credit) AS totalCredit"),
                            "conditions" => array("AccJournal.journal_type" => "Memorial", $filterCondition),
                            "recursive" => 0
                        ));

            $dataJournalLine['aaDataTotal'] = $dataJournalLines[0];
            $this->DataTable->mDataProp = true;
            $dataTableGets = $this->DataTable->getResponse();
            $dataTableGet = array_merge($dataJournalLine, $dataTableGets);


            $this->set('response', $dataTableGet);
           // pr($dataTableGet);

            $this->set('_serialize','response');*/
    }

    public function editManyDatatable()
    {
        $this->autoRender=false;

        $db = ConnectionManager::get('default');

        // if ($this->request->is("ajax")) {
            // Used when ajax loads data
            $params['draw'] = (isset($_REQUEST['draw'])) ? $_REQUEST['draw'] : 1;
            $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 1;
            $length = (isset($_REQUEST['length'])) ? $_REQUEST['length'] : 1;
            
            $idJournal = $_REQUEST['id-journal'];
            // pr($idJournal);
            
            /* If we pass any extra data in request from ajax */
            //$value1 = isset($_REQUEST['key1'])?$_REQUEST['key1']:"";

            /* Value we will get from typing in search */
            // $search_value = $_REQUEST['search']['value'];

            // If we have value in search, searching by id, name, email, mobile
            /*if (!empty($search_value)) 
            {
                $condWhere = " UAs.code LIKE '%$search_value%'";
            } 
            else 
            {
                $condWhere = "";
            }*/
                

            // count all data
            // LEFT JOIN customers Cs ON Cs.id = Ajl.customer_id
            $total_count = $db->execute("SELECT * FROM acc_journal_lines Ajl LEFT JOIN acc_chart_of_accounts Acoa ON Acoa.id = Ajl.acc_chart_of_account_id WHERE Ajl.acc_journal_id=$idJournal ORDER BY Ajl.position ASC")->fetchAll('assoc');

                // $total_count = $db->execute("SELECT * FROM petty_cashes $where")->fetchAll('assoc');
            
            // if(!empty($total_count)) { 
            //     $data = $db->execute("SELECT Ajl.id, Ajl.acc_journal_id, IF(Ajl.ledger_dc='D','Debit','Credit') AS ledgerdc, Ajl.ledger_dc, Ajl.name, Ajl.position, Ajl.debet, Ajl.credit, Acoa.code, CONCAT('(',Acoa.code,') ',Acoa.name) AS coaName, Acoa.customer_id, IFNULL(Ajl.name, CONCAT(Cs.title,' ',Cs.name)) AS coaCustomerName FROM acc_journal_lines Ajl LEFT JOIN acc_chart_of_accounts Acoa ON Acoa.id = Ajl.acc_chart_of_account_id LEFT JOIN customers Cs ON Cs.id = Acoa.customer_id WHERE Ajl.acc_journal_id=$idJournal ORDER BY Ajl.position ASC")->fetchAll('assoc');

            //     $json_data = array(
            //         "draw" => intval($params['draw']),
            //         "recordsTotal" => count($total_count),
            //         "recordsFiltered" => count($total_count),
            //         "data" => $data   // total data array
            //     );
            // } else {
            //     $json_data = array(
            //         "draw" => 1,
            //         "recordsTotal" => 1,
            //         "recordsFiltered" => 1,
            //         "data" => []   // total data array
            //     );
            // }
            if (!empty($total_count)) {
                $data = $db->execute("SELECT Ajl.id, Ajl.acc_journal_id, IF(Ajl.ledger_dc='D','Debit','Credit') AS ledgerdc, Ajl.ledger_dc, Ajl.name, Ajl.position, Ajl.debet, Ajl.credit, Acoa.code, CONCAT('(', Acoa.code, ') ', Acoa.name) AS coaName, Acoa.customer_id, IFNULL(Ajl.name, CONCAT('(', Acoa.code, ') ', Acoa.name)) AS coaCustomerName FROM acc_journal_lines Ajl LEFT JOIN acc_chart_of_accounts Acoa ON Acoa.id = Ajl.acc_chart_of_account_id WHERE Ajl.acc_journal_id = $idJournal ORDER BY Ajl.position ASC")->fetchAll('assoc');
                $json_data = array("draw" => intval($params['draw']), "recordsTotal" => count($total_count),"recordsFiltered" => count($total_count),"data" => $data);
            } else {
                $json_data = array(
                    "draw" => 1,
                    "recordsTotal" => 1,
                    "recordsFiltered" => 1,
                    "data" => []
                );
            }
            
            // pr($data);

            return $this->response->withType("application/json")->withStringBody(json_encode($json_data));
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Branches', 'AccJournals', 'AccChartOfAccounts'],
        ];
        $accJournalLines = $this->paginate($this->AccJournalLines);

        $this->set(compact('accJournalLines'));
    }

    /**
     * View method
     *
     * @param string|null $id Acc Journal Line id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accJournalLine = $this->AccJournalLines->get($id, [
            'contain' => ['Branches', 'AccJournals', 'AccChartOfAccounts'],
        ]);

        $this->set(compact('accJournalLine'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accJournalLine = $this->AccJournalLines->newEmptyEntity();
        if ($this->request->is('post')) {
            $accJournalLine = $this->AccJournalLines->patchEntity($accJournalLine, $this->request->getData());
            if ($this->AccJournalLines->save($accJournalLine)) {
                $this->Flash->success(__('The acc journal line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc journal line could not be saved. Please, try again.'));
        }
        $branches = $this->AccJournalLines->Branches->find('list', ['limit' => 200]);
        $accJournals = $this->AccJournalLines->AccJournals->find('list', ['limit' => 200]);
        $accChartOfAccounts = $this->AccJournalLines->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('accJournalLine', 'branches', 'accJournals', 'accChartOfAccounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Acc Journal Line id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
       /* $accJournalLine = $this->AccJournalLines->get($id, [
            'contain' => ['AccJournals', 'AccChartOfAccounts'],
            'select' => ['coaGroupId' => "CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups,'^',IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name)))", 'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name))"]
        ]);*/
        $accJournalLine = $this->AccJournalLines->find()
            ->select(['AccJournalLines.id', 'AccJournalLines.name', 'AccJournalLines.debet', 'AccJournalLines.credit', 'AccJournals.code', 'coaGroupId' => "CONCAT(AccChartOfAccounts.id,'^', AccChartOfAccounts.code,'^',AccChartOfAccounts.header_account,'^',AccChartOfAccounts.sub_header_account,'^',AccChartOfAccounts.groups,'^',IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name)))", 'coaGroupName' => "IFNULL(CONCAT('(',AccChartOfAccounts.code,') ', AccChartOfAccounts.name), CONCAT('(',AccChartOfAccounts.code,') ', Customers.title,' ',Customers.name))"])
            ->where(['AccJournalLines.id' => $id])
            ->contain(['AccJournals', 'AccChartOfAccounts', 'AccChartOfAccounts.Customers'])
            ->first();

        // pr($accJournalLine);
        // if ($this->request->is('post')) {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();

            $isUser = $dataRow['is_update'];
            list($coaId, $coaCode, $coaHeaderCode, $coaSubHeaderCode, $coaGroup, $coaName) = explode("^", $dataRow['coa_id']);
            $debetAmount = (isset($dataRow['debet_amount'])) ? $this->Krs->nom2Dec($dataRow['debet_amount']) : "";
            $creditAmount = (isset($dataRow['credit_amount'])) ? $this->Krs->nom2Dec($dataRow['credit_amount']) : "";

            $dataUserId = array('is_update' => $isUser);
            $dataName = array('name' => $dataRow['desc']);
            $dataDebet = array('debet' => $debetAmount);
            $dataCredit = array('credit' => $creditAmount);
            $dataCoaId = array('acc_chart_of_account_id' => $coaId);

            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id,  $isUser, "Edit Jurnal Line"); 
            $dataAuditLog = array('is_log' => $auditLog);

            $accJournalLine = $this->AccJournalLines->patchEntity($accJournalLine, array_merge($dataUserId, $dataName, $dataDebet, $dataCredit, $dataCoaId, $dataAuditLog));

            // $accJournalLine = $this->AccJournalLines->patchEntity($accJournalLine, $this->request->getData());
            // pr($accJournalLine);
            if ($this->AccJournalLines->save($accJournalLine)) {
                // $this->Flash->success(__('The acc journal line has been saved.'));

                // return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc journal line could not be saved. Please, try again.'));
        }
        $branches = $this->AccJournalLines->Branches->find('list', ['limit' => 200]);
        $accJournals = $this->AccJournalLines->AccJournals->find('list', ['limit' => 200]);
        // $journalSubs = $this->AccJournalLines->JournalSubs->find('list', ['limit' => 200]);
        // $journalSubLines = $this->AccJournalLines->JournalSubLines->find('list', ['limit' => 200]);
        $accChartOfAccounts = $this->AccJournalLines->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('accJournalLine', 'branches', 'accJournals', 'accChartOfAccounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Acc Journal Line id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accJournalLine = $this->AccJournalLines->get($id);
        if ($this->AccJournalLines->delete($accJournalLine)) {
            $this->Flash->success(__('The acc journal line has been deleted.'));
        } else {
            $this->Flash->error(__('The acc journal line could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
