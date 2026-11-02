<?php
declare(strict_types=1);

namespace App\Controller\Master;
use App\Controller\AppController;
use Cake\I18n\FrozenDate;
use Cake\Chronos\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Laminas\Diactoros\CallbackStream;
use Cake\Log\Log;
/**
 * BankAccounts Controller
 *
 * @property \App\Model\Table\BankAccountsTable $BankAccounts
 * @method \App\Model\Entity\BankAccount[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BankAccountsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $filterName = $this->request->getQuery('filterName');
        $filterNamaRekening = $this->request->getQuery('filterNamaRekening');

        $dataWhere = array();
        if(!empty($filterName)){
            $dataWhere['BankAccounts.bank_name LIKE'] = '%'.$filterName.'%';
        }
        if(!empty($filterNamaRekening)){
            $dataWhere['BankAccounts.account_holder LIKE'] = '%'.$filterNamaRekening.'%';
        }
    
        $query = $this->BankAccounts->find('all',
        conditions: $dataWhere,
        contain: []);
        $this->paginate = ['order' => ['BankAccounts.created' => 'DESC'], 'limit' => 10];
        $bankAccounts = $this->paginate($query);

        // $bankAccounts = $this->paginate($this->BankAccounts);

        $this->set(compact('bankAccounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Bank Account id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bankAccount = $this->BankAccounts->get($id, contain: []);

        $this->set(compact('bankAccount'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bankAccount = $this->BankAccounts->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog("Bank Accounts", 'N',  $isUser, "Bank Accounts add");
            $dataAuditLog = array('is_log' => $auditLog);
            // $dataOpeningBalance = $this->Krs->nom2Dec($dataRow['opening_balance']);
            // $dataRow['opening_balance'] = $dataOpeningBalance;
            // $dataRow['ending_balance'] = $dataOpeningBalance;
            $dataNameRekening = strtoupper($dataRow['account_holder']);
            $dataAccountHolder['account_holder'] = $dataNameRekening;
            $bankAccount = $this->BankAccounts->patchEntity($bankAccount, array_merge($dataRow, $dataAuditLog, $dataAccountHolder));
            // debug($bankAccount); die;
            if ($this->BankAccounts->save($bankAccount)) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
            // debug($bankAccount->getErrors()); die;
        }
        $branches = $this->BankAccounts->Branches->find('list', ['limit' => 200]);
        $this->set(compact('bankAccount', 'branches'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bank Account id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bankAccount = $this->BankAccounts->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // debug($this->request->getData()); die;
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog("Assignments", 'N',  $isUser, "Assignments edit");
            $dataAuditLog = array('is_log' => $auditLog);
            // $dataOpeningBalance = $this->Krs->nom2Dec($dataRow['opening_balance']);
            // $dataRow['opening_balance'] = $dataOpeningBalance;
            // $dataRow['ending_balance'] = $dataOpeningBalance;
            $dataNameRekening = strtoupper($dataRow['account_holder']);
            $dataAccountHolder['account_holder'] = $dataNameRekening;
            $dataIsActive = array('is_active' => $dataRow['is_active']);
            // $dataRow['is_active'] = $dataIsActive;
            $bankAccount = $this->BankAccounts->patchEntity($bankAccount, array_merge($dataRow, $dataAuditLog, $dataAccountHolder, $dataIsActive));
            // debug($bankAccount); die;
            if ($this->BankAccounts->save($bankAccount)) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        $branches = $this->BankAccounts->Branches->find('list', ['limit' => 200]);
        $this->set(compact('bankAccount', 'branches'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bank Account id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bankAccount = $this->BankAccounts->get($id);
        if ($this->BankAccounts->delete($bankAccount)) {
            $this->Flash->success(__('The bank account has been deleted.'));
        } else {
            $this->Flash->error(__('The bank account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
        
    //     // Debug: cek apakah ID ada
    //     if (!$id) {
    //         $this->Flash->error(__('Invalid ID provided.'));
    //         return $this->redirect(['action' => 'index']);
    //     }
        
    //     try {
    //         $bankAccount = $this->BankAccounts->get($id);
            
    //         // Debug: cek data sebelum delete
    //         debug($bankAccount->toArray()); // Hapus setelah debugging
            
    //         if ($this->BankAccounts->delete($bankAccount)) {
    //             $this->Flash->success(__('Bank account has been deleted.'));
    //         } else {
    //             // Tampilkan error detail
    //             $errors = $bankAccount->getErrors();
    //             if (!empty($errors)) {
    //                 $this->Flash->error(__('Cannot delete: ') . json_encode($errors));
    //             } else {
    //                 $this->Flash->error(__('Bank account could not be deleted. Please, try again.'));
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         // Tangkap exception
    //         $this->Flash->error(__('Error: ') . $e->getMessage());
    //     }
        
    //     return $this->redirect(['action' => 'index']);
    // }

    public function getBankAccount()
    {
        $this->request->allowMethod(['ajax']);
        $this->autoRender = false;
        $dataSearch = $this->request->getQuery('dataSearch');
        $bankAccounts = $this->BankAccounts->find()
            ->select(['id', 'account_holder', 'bank_name', 'account_number'])
            ->where(['is_active' => 'Y', 'OR' => ['account_holder LIKE' => "%{$dataSearch}%", 'bank_name LIKE'      => "%{$dataSearch}%", 'account_number LIKE' => "%{$dataSearch}%"]])
            ->orderBy(['account_holder' => 'ASC']);
        $result = [];
        foreach ($bankAccounts as $row) {
            $result[] = [
                'id'   => $row->id,
                'text' => $row->account_holder . ' - ' . $row->bank_name . ' - ' . $row->account_number,];
                }
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($result));
    }

    public function xls()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);

        $filterName = $this->request->getQuery('filterName');
        $filterNamaRekening = $this->request->getQuery('filterNamaRekening');

        $query = $this->BankAccounts->find();

        if(!empty($filterName)){
            $query->where(['BankAccounts.bank_name LIKE' => '%'.$filterName.'%']);
        }
        if(!empty($filterNamaRekening)){
            $query->where(['BankAccounts.account_holder LIKE' => '%'.$filterNamaRekening.'%']);
        }

        $query->orderBy([
            'BankAccounts.created' => 'DESC'
        ]);
        $rows = $query->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Akun Bank');

        $sheet->setCellValue('A1', 'Rekap Akun Bank');
        $sheet->mergeCells('A1:E1');

        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A1')->getFont()
            ->setBold(true)
            ->setSize(12);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', ' Nama Bank');
        $sheet->setCellValue('C2', 'Nama Pemilik');
        $sheet->setCellValue('D2', 'Nomor Rekekening');
        $sheet->setCellValue('E2', 'Aktif');

        $rowNum = 3;
        foreach ($rows as $i => $r) {
            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue( 'B' . $rowNum, $r->bank_name ?? '-');
            $sheet->setCellValue('C' . $rowNum,$r->account_holder ?? '-');
            $sheet->setCellValue('D' . $rowNum,$r->account_number ?? '-');
            $sheet->setCellValue('E' . $rowNum, $r->is_active === 'Y' ? 'Ya' : 'Tidak');
            $rowNum++;
        }
        foreach (range('A', 'E') as $columnID) {
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

        $sheet->getStyle("A1:E{$lastRow}")
            ->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Rekap Akun Bank-' . date('Ymd-His') . '.xlsx';

        return $this->response
            ->withType('xlsx')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$filename}\""
            )
            ->withBody($stream);
    }

    public function templateExcel()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Akun Bank');

        $sheet->setCellValue('A1', 'Template Akun Bank');
        $sheet->mergeCells('A1:C1');

        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A1')->getFont()
            ->setBold(true)
            ->setSize(12);

        // $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('A2', ' Nama Bank');
        $sheet->setCellValue('B2', 'Nama Pemilik');
        $sheet->setCellValue('C2', 'Nomor Rekekening');
        // $sheet->setCellValue('D2', 'Aktif');

        foreach (range('A', 'C') as $columnID) {
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

        $lastRow = 2;

        $sheet->getStyle("A1:C{$lastRow}")
            ->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Template Akun Bank-' . date('Ymd-His') . '.xlsx';

        return $this->response
            ->withType('xlsx')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$filename}\""
            )
            ->withBody($stream);
    }

    public function importExcel()
    {
        $this->request->allowMethod(['post']);
        $file = $this->request->getData('filename');
        if (empty($file) || $file->getError() != UPLOAD_ERR_OK) {
            $this->Flash->error(__('File tidak ditemukan.'));
            return $this->redirect(['action' => 'index']);
        }
        $filePath = $file->getStream()->getMetadata('uri');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        $userId = $this->Authentication->getIdentity()->id;
        // atau
        // $userId = $this->request->getSession()->read('Auth.id');
        $success = 0;
        $failed = 0;
        foreach ($rows as $key => $row) {
            // Skip Judul + Header
            if ($key < 2) {
                continue;
            }
            $bankName = trim($row[0]);
            $holder   = trim($row[1]);
            $number   = trim($row[2]);
            // Lewati jika kosong semua
            if ($bankName == '' && $holder == '' && $number == '') {
                continue;
            }
            $auditLog = $this->Krs->auditLog("Bank Accounts", 'N', $userId, "Import Excel");
            $data = [
                'bank_name'      => strtoupper($bankName),
                'account_holder' => strtoupper($holder),
                'account_number' => $number,
                'is_active'      => 'Y',
                'is_create'      => $userId,
                'is_log'         => $auditLog
            ];
            $entity = $this->BankAccounts->newEmptyEntity();
            $entity = $this->BankAccounts->patchEntity($entity, $data);
            if ($this->BankAccounts->save($entity)) {
                $success++;
            } else {
                $failed++;
            }
        }
        if ($failed == 0) {
            $this->Flash->success(__("Berhasil mengimport {$success} data."));
        } else {
            $this->Flash->warning(__("{$success} data berhasil diimport, {$failed} data gagal."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
