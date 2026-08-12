<?php
declare(strict_types=1);

namespace App\Controller\Acc;
use App\Controller\AppController;
use Cake\I18n\FrozenDate;
use Cake\Chronos\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Laminas\Diactoros\CallbackStream;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
/**
 * BankTopups Controller
 *
 * @property \App\Model\Table\BankTopupsTable $BankTopups
 * @method \App\Model\Entity\BankTopup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BankTopupsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $sessions = $this->request->getSession();
        $this->session = $sessions->read('Auth');
        $this->loadModel('Users');

        $this->loadModel('AccChartOfAccounts');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $sessionCheck = $this->Authentication->getResult();
        $dataSession = $sessionCheck->getData();
        // pr($dataSession);
        // die;
        $session = $this->getRequest()->getSession();
        $filterName = $this->request->getQuery('filterName');
        $filterTujuan = $this->request->getQuery('filterTujuan');
        $filterDateFrom = $this->request->getQuery('filterDateFrom');
        $filterDateEnd = $this->request->getQuery('filterDateEnd');

        $dataWhere = [];
        if(!empty($filterName)){
            $dataWhere['BankTopups.payment_type LIKE'] = '%'.$filterName.'%';
        }
        if(!empty($filterTujuan)){
            $dataWhere['AccChartOfAccounts.name LIKE'] = '%'.$filterTujuan.'%';
        }
        if (!empty($filterDateFrom)) {
            $filterDateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $filterDateFrom)));
        }

        if (!empty($filterDateEnd)) {
            $filterDateEnd = date('Y-m-d', strtotime(str_replace('/', '-', $filterDateEnd)));
        }

        if (!empty($filterDateFrom) && !empty($filterDateEnd)) {
            $dataWhere['BankTopups.created >='] = $filterDateFrom . ' 00:00:00';
            $dataWhere['BankTopups.created <='] = $filterDateEnd . ' 23:59:59';
        }
        $session->write(['condition' => $dataWhere]);
        $dataProject = $dataSession['project'];
        $dataDevisionPCA = $dataSession['submission_devision'];
        $dataApproved = $dataSession['approved'];
        $dataApprovedAcc = $dataSession['approved_acc'];
        $dataApprovedCeo = $dataSession['approved_ceo'];
        $dataPayment = $dataSession['payment'];
        $dataSubmissionFullAccess = $dataSession['pettycash_full_access'];

        if (!empty($dataProject) && ($dataApproved == 'Y' ||$dataApprovedAcc == 'Y' || $dataApprovedCeo == 'Y' || $dataPayment == 'Y' || $dataSubmissionFullAccess == 'Y')) {
            $arrayProject = [];
        } else {
            $dataProjects = empty($dataProject) ? [] : explode(',', $dataProject);
            $dataDevisionPCAs = empty($dataDevisionPCA) ? [] : explode(',', $dataDevisionPCA);
            $dataDev = array_merge($dataProjects, $dataDevisionPCAs);
            $arrayProject = [
                'BankTopups.ubs IN' => $dataDev
            ];
        }
       
        $query = $this->BankTopups->find('all', [
            'contain' => ['Users', 'AccChartOfAccounts', 'AccChartOfAccountTo']
        ]);
        if (!empty($arrayProject)) {
            $query->where($arrayProject);
        }
        if (!empty($dataWhere)) {
            $query->where($dataWhere);
        }

        // $query = $this->BankTopups->find('all', [
        //     'conditions' => $dataWhere,
        //     'contain' => ['Users', 'AccChartOfAccounts', 'AccChartOfAccountTo'],
        // ]);
        $this->paginate = ['order' => ['BankTopups.created' => 'DESC'], 'limit' => 10];
        $bankTopups = $this->paginate($query);

        $this->set(compact('bankTopups'));
    }

    /**
     * View method
     *
     * @param string|null $id Bank Topup id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bankTopup = $this->BankTopups->get($id, [
            'contain' => ['AccChartOfAccounts', 'Users', 'AccChartOfAccountTo'],
        ]);

        $this->set(compact('bankTopup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bankTopup = $this->BankTopups->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog("Bank Topups", 'N',  $isUser, "Bank Topups add");
            $dataAuditLog = array('is_log' => $auditLog);
            $dataNominal = $this->Krs->nom2Dec($dataRow['nominal']);
            $accCoaId = $dataRow['acc_coa_id'];
            $dataCoa = array('acc_coa_id' => $accCoaId);
            $accCoaToId = $dataRow['acc_coa_to_id'];
            $dataCoaTo = array('acc_coa_to_id' => $accCoaToId);
            // $dataUbs = array('ubs' => $dataRow['ubs']);
            $dataRow['nominal'] = $dataNominal;
            for ($i = 1; $i <= 2; $i++) {
                $field = "file_$i";
                $file = $dataRow[$field] ?? null;
                if (is_object($file) && method_exists($file, 'getError') && $file->getError() === 0) {
                    $filename = time() . '_' . str_replace(' ', '_', $file->getClientFilename());
                    $targetPath = WWW_ROOT . 'files' . DS . $filename;
                    $file->moveTo($targetPath);
                    $dataRow[$field] = $filename;
                } else {
                    unset($dataRow[$field]);
                }
            }
            if ($dataRow['acc_coa_id'] == $dataRow['acc_coa_to_id']) {
                $this->Flash->error(__('COA asal dan COA tujuan tidak boleh sama.'));
                return $this->redirect(['action' => 'add']);
            }
            $coaFrom = $this->BankTopups->AccChartOfAccounts->get($dataRow['acc_coa_id']);
            if ($coaFrom->ending_balance_bank < $dataNominal) {
                $this->Flash->error(__('Saldo COA asal tidak mencukupi.'));
                return $this->redirect(['action' => 'add']);
            }
            $bankTopup = $this->BankTopups->patchEntity($bankTopup, array_merge($dataRow, $dataAuditLog, $dataCoa, $dataCoaTo));
            // debug($bankTopup); die;
            if ($this->BankTopups->save($bankTopup)) {
                $coaFrom->ending_balance_bank -= $dataNominal;
                $this->BankTopups->AccChartOfAccounts->save($coaFrom);

                // ===========================
                // TAMBAH COA TUJUAN
                // ===========================

                $coaTo = $this->BankTopups->AccChartOfAccounts->get($dataRow['acc_coa_to_id']);
                $coaTo->ending_balance_bank += $dataNominal;
                $this->BankTopups->AccChartOfAccounts->save($coaTo);
        
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        // $branches = $this->BankTopups->Branches->find('list', ['limit' => 200]);
        // $accCoas = $this->BankTopups->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('bankTopup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bank Topup id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bankTopup = $this->BankTopups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bankTopup = $this->BankTopups->patchEntity($bankTopup, $this->request->getData());
            if ($this->BankTopups->save($bankTopup)) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        $branches = $this->BankTopups->Branches->find('list', ['limit' => 200]);
        $accCoas = $this->BankTopups->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('bankTopup', 'branches', 'accCoas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bank Topup id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bankTopup = $this->BankTopups->get($id);
        if ($this->BankTopups->delete($bankTopup)) {
            $this->Flash->success(__('The bank topup has been deleted.'));
        } else {
            $this->Flash->error(__('The bank topup could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getList()
    {
        $this->autoRender = false;
        // $this->loadModel('Customers');
        // debug($this->request->getQuery());
        // die();
        $dataSearch = $this->request->getQuery('dataSearch');
        
        // if($usingDefault=='submissionDebet') {
        //     $usingSubmission = array('AccChartOfAccounts.submission_debet'=>'Y');
        // } elseif($usingDefault=='submissionCredit') {
        //     $usingSubmission = array('AccChartOfAccounts.submission_credit'=>'Y');
        // } else {
        //     $usingSubmission = array();
        // }
        // // pr($dataSearch);
        $dataRows = $this->AccChartOfAccounts->find('all')->contain([])->select(['coaId' => "CONCAT(AccChartOfAccounts.id)", 'AccChartOfAccounts.id','AccChartOfAccounts.code', 'AccChartOfAccounts.default', 'AccChartOfAccounts.name', 'AccChartOfAccounts.journal_type', 'AccChartOfAccounts.ending_balance_bank', 'coaName' => 'AccChartOfAccounts.name'])->where(['AccChartOfAccounts.level' => 4, 'AccChartOfAccounts.name LIKE' => '%' . $dataSearch . '%'])->order(['AccChartOfAccounts.lft' => 'ASC']);

        // $dataRows = $this->AccChartOfAccounts->find('all')->contain(['Customers'])->select(['coaId'=>"CONCAT(AccChartOfAccounts.id)", "AccChartOfAccounts.id", "AccChartOfAccounts.code", "AccChartOfAccounts.default", "AccChartOfAccounts.name", "AccChartOfAccounts.journal_type", "AccChartOfAccounts.ending_balance_bank", 'coaName'=>"IFNULL(AccChartOfAccounts.name, CONCAT(Customers.title,' ',Customers.name))"])->where(['AccChartOfAccounts.level' => 4, 'IFNULL(AccChartOfAccounts.name, Customers.name) LIKE' =>"%".$dataSearch."%"])->order(['AccChartOfAccounts.lft'=>'ASC']);
        //, 'coaName'=>"CONCAT('( ',AccChartOfAccounts.code,') ', AccChartOfAccounts.name)"
        // ,'^', AccChartOfAccounts.code

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
    public function xls()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);

        $filterName = $this->request->getQuery('filterName');
        $filterTujuan = $this->request->getQuery('filterTujuan');
        $filterDateFrom = $this->request->getQuery('filterDateFrom');
        $filterDateEnd = $this->request->getQuery('filterDateEnd');

        $query = $this->BankTopups->find()
            ->contain(['Users', 'AccChartOfAccounts', 'AccChartOfAccountTo'])
            ->innerJoinWith('AccChartOfAccounts');

        if (!empty($filterName)) {
            $query->where([
                'BankTopups.payment_type LIKE' => '%' . $filterName . '%'
            ]);
        }

        if (!empty($filterTujuan)) {
            $query->where([
                'AccChartOfAccounts.name LIKE' => '%' . $filterTujuan . '%'
            ]);
        }

        if (!empty($filterDateFrom)) {
            $filterDateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $filterDateFrom)));
        }

        if (!empty($filterDateEnd)) {
            $filterDateEnd = date('Y-m-d', strtotime(str_replace('/', '-', $filterDateEnd)));
        }

        if (!empty($filterDateFrom) && !empty($filterDateEnd)) {
            $query->where([
                'BankTopups.created >=' => $filterDateFrom . ' 00:00:00',
                'BankTopups.created <=' => $filterDateEnd . ' 23:59:59',
            ]);
        }

        $query->order([
            'BankTopups.created' => 'DESC'
        ]);
        $rows = $query->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Mutasi Bank TopUp');

        $sheet->setCellValue('A1', 'Rekap Mutasi Bank TopUp');
        $sheet->mergeCells('A1:H1');

        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A1')->getFont()
            ->setBold(true)
            ->setSize(12);

        // =========================
        // HEADER
        // =========================
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'UBS');
        $sheet->setCellValue('C2', 'Nama Bank');
        $sheet->setCellValue('D2', 'Tujuan TopUp');
        $sheet->setCellValue('E2', 'COA Penyetor');
        $sheet->setCellValue('F2', 'Nominal');
        $sheet->setCellValue('G2', 'Tanggal TopUp');
        $sheet->setCellValue('H2', 'PIC');

        // =========================
        // DATA
        // =========================
        $rowNum = 3;
        foreach ($rows as $i => $r) {
            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue( 'B' . $rowNum, $r->ubs ?? '-');
            $sheet->setCellValue( 'C' . $rowNum, $r->payment_type ?? '-');
            $sheet->setCellValue('D' . $rowNum,$r->acc_chart_of_account->code . ' - ' . $r->acc_chart_of_account->name ?? '-');
            $sheet->setCellValue('E' . $rowNum,$r->acc_chart_of_account_to->code . ' - ' . $r->acc_chart_of_account_to->name ?? '-');
            $sheet->setCellValue('F' . $rowNum,$this->Krs->nom($r->nominal) ?? '-');
            $sheet->setCellValue('G' . $rowNum,!empty($r->created)? $r->created->format('d-m-Y H:i:s') : '-');
            $sheet->setCellValue('H' . $rowNum, !empty($r->user) ? $r->user->name : '-');
            $rowNum++;
        }
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $lastRow = $rowNum - 1;

        $sheet->getStyle("A1:H{$lastRow}")
            ->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Rekap Bank TopUp-' . date('Ymd-His') . '.xlsx';

        return $this->response
            ->withType('xlsx')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$filename}\""
            )
            ->withBody($stream);
    }
}
