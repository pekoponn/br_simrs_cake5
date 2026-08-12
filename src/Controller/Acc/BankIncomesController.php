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
 * BankIncomes Controller
 *
 * @property \App\Model\Table\BankIncomesTable $BankIncomes
 * @method \App\Model\Entity\BankIncome[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BankIncomesController extends AppController
{
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
            $dataWhere['BankIncomes.payment_type LIKE'] = '%'.$filterName.'%';
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
            $dataWhere['BankIncomes.created >='] = $filterDateFrom . ' 00:00:00';
            $dataWhere['BankIncomes.created <='] = $filterDateEnd . ' 23:59:59';
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
                'BankIncomes.ubs IN' => $dataDev
            ];
        }
       
        $query = $this->BankIncomes->find('all', [
            'contain' => ['Users', 'AccChartOfAccounts']
        ]);
        if (!empty($arrayProject)) {
            $query->where($arrayProject);
        }
        if (!empty($dataWhere)) {
            $query->where($dataWhere);
        }

        // $query = $this->BankIncomes->find('all', [
        //     'conditions' => $dataWhere,
        //     'contain' => ['Users', 'AccChartOfAccounts', 'AccChartOfAccountTo'],
        // ]);
        $this->paginate = ['order' => ['BankIncomes.created' => 'DESC'], 'limit' => 10];
        $bankIncomes = $this->paginate($query);

        $this->set(compact('bankIncomes'));
    }

    /**
     * View method
     *
     * @param string|null $id Bank Income id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bankIncome = $this->BankIncomes->get($id, [
            'contain' => ['AccChartOfAccounts', 'Users'],
        ]);

        $this->set(compact('bankIncome'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bankIncome = $this->BankIncomes->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog("Bank Incomes", 'N',  $isUser, "Bank Incomes add");
            $dataAuditLog = array('is_log' => $auditLog);
            $dataNominal = $this->Krs->nom2Dec($dataRow['nominal']);
            $accCoaId = $dataRow['acc_coa_id'];
            $dataCoa = array('acc_coa_id' => $accCoaId);
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
            $bankIncome = $this->BankIncomes->patchEntity($bankIncome, array_merge($dataRow, $dataAuditLog, $dataCoa));
            if ($this->BankIncomes->save($bankIncome)) {
                $coaFrom = $this->BankIncomes->AccChartOfAccounts->get($dataRow['acc_coa_id']);
                $coaFrom->ending_balance_bank += $dataNominal;
                $this->BankIncomes->AccChartOfAccounts->save($coaFrom);

                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        // $branches = $this->BankIncomes->Branches->find('list', ['limit' => 200]);
        // $accCoas = $this->BankIncomes->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('bankIncome'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bank Income id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bankIncome = $this->BankIncomes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bankIncome = $this->BankIncomes->patchEntity($bankIncome, $this->request->getData());
            if ($this->BankIncomes->save($bankIncome)) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        $branches = $this->BankIncomes->Branches->find('list', ['limit' => 200]);
        $accCoas = $this->BankIncomes->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('bankIncome', 'branches', 'accCoas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bank Income id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bankIncome = $this->BankIncomes->get($id);
        if ($this->BankIncomes->delete($bankIncome)) {
            $this->Flash->success(__('The bank income has been deleted.'));
        } else {
            $this->Flash->error(__('The bank income could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function xls()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);

        $filterName = $this->request->getQuery('filterName');
        $filterTujuan = $this->request->getQuery('filterTujuan');
        $filterDateFrom = $this->request->getQuery('filterDateFrom');
        $filterDateEnd = $this->request->getQuery('filterDateEnd');

        $query = $this->BankIncomes->find()
            ->contain(['Users', 'AccChartOfAccounts'])
            ->innerJoinWith('AccChartOfAccounts');

        if (!empty($filterName)) {
            $query->where([
                'BankIncomes.payment_type LIKE' => '%' . $filterName . '%'
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
                'BankIncomes.created >=' => $filterDateFrom . ' 00:00:00',
                'BankIncomes.created <=' => $filterDateEnd . ' 23:59:59',
            ]);
        }

        $query->order([
            'BankIncomes.created' => 'DESC'
        ]);
        $rows = $query->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Mutasi Bank TopUp');

        $sheet->setCellValue('A1', 'Rekap Dana Masuk');
        $sheet->mergeCells('A1:G1');

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
        $sheet->setCellValue('D2', 'Dana Masuk (COA)');
        $sheet->setCellValue('E2', 'Nominal');
        $sheet->setCellValue('F2', 'Tanggal TopUp');
        $sheet->setCellValue('G2', 'PIC');

        // =========================
        // DATA
        // =========================
        $rowNum = 3;
        foreach ($rows as $i => $r) {
            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue( 'B' . $rowNum, $r->ubs ?? '-');
            $sheet->setCellValue( 'C' . $rowNum, $r->payment_type ?? '-');
            $sheet->setCellValue('D' . $rowNum,$r->acc_chart_of_account->code . ' - ' . $r->acc_chart_of_account->name ?? '-');
            $sheet->setCellValue('E' . $rowNum,$this->Krs->nom($r->nominal) ?? '-');
            $sheet->setCellValue('F' . $rowNum,!empty($r->created)? $r->created->format('d-m-Y H:i:s') : '-');
            $sheet->setCellValue('G' . $rowNum, !empty($r->user) ? $r->user->name : '-');
            $rowNum++;
        }
        foreach (range('A', 'G') as $columnID) {
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

        $sheet->getStyle("A1:G{$lastRow}")
            ->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Rekap Dana Masuk-' . date('Ymd-His') . '.xlsx';

        return $this->response
            ->withType('xlsx')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$filename}\""
            )
            ->withBody($stream);
    }
}
