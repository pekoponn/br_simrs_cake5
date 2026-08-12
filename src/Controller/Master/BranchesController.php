<?php
declare(strict_types=1);

namespace App\Controller\Master;
use App\Controller\AppController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Http\CallbackStream;

use Cake\Utility\Hash; // Memanggil fungsi Hash, untuk filter

/**
 * Branches Controller
 *
 * @property \App\Model\Table\BranchesTable $Branches
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BranchesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $branches = $this->paginate($this->Branches);

        $this->set(compact('branches'));
    }

    /**
     * View method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $branch = $this->Branches->get($id, [
            'contain' => ['Transporters', 'AccAccountMappings', 'AccAccounts', 'AccBeginningBalances', 'AccChartOfAccounts', 'AccJournalBankLines', 'AccJournalBanks', 'AccJournalCashLines', 'AccJournalCashes', 'AccJournalLines', 'AccJournalMappings', 'AccJournalMemorialLines', 'AccJournalMemorials', 'AccJournals', 'Calks', 'Certificates', 'CommissionDetails', 'Commissions', 'Creditors', 'Customers', 'CustomersOri', 'DataInvoices', 'DataTaxes', 'Deposits', 'Depreciations', 'Depreciationse', 'Depreciationss', 'Drivers', 'InvoiceDeposits', 'InvoiceEntries', 'InvoiceHutangs', 'InvoiceOuts', 'Invoices', 'Logs', 'ManifestDirects', 'ManifestInsides', 'ManifestLogbooks', 'ManifestProcessors', 'Manifests', 'MouCs', 'Mouses', 'Numbers', 'Offers', 'OperationalLines', 'Operationals', 'OrderRegulars', 'Orders', 'Orders230129', 'OrdersOri', 'Payments', 'Permits', 'PettyCashBankTopups', 'PettyCashBanks', 'PettyCashTopups', 'PettyCashes', 'ProcessorPrices', 'Processors', 'Projects', 'RecipientPayers', 'Settings', 'Templates', 'TransporterPrices', 'TruckInspections', 'TruckSchedules', 'Trucks', 'TrucksOri', 'UnidentifiedIncomes', 'Users', 'WastePrices', 'WasteTypes', 'Wastes'],
        ]);

        $this->set(compact('branch'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $branch = $this->Branches->newEmptyEntity();
        if ($this->request->is('post')) {
            $branch = $this->Branches->patchEntity($branch, $this->request->getData());
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch could not be saved. Please, try again.'));
        }
        $this->set(compact('branch'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $branch = $this->Branches->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $branch = $this->Branches->patchEntity($branch, $this->request->getData());
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch could not be saved. Please, try again.'));
        }
        $this->set(compact('branch'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $branch = $this->Branches->get($id);
        if ($this->Branches->delete($branch)) {
            $this->Flash->success(__('The branch has been deleted.'));
        } else {
            $this->Flash->error(__('The branch could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function xls($condition=null) {
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
                'color' => [
                    'argb' => 'FFEFEFEF',
                ],
                
            ],
        ]; 

        $spreadsheet->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArray);
        // $spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('A2', 'Informasi ID Cabang');
        $sheet->setCellValue('B1', 'Kode');
        $sheet->setCellValue('B2', 'Informasi Kode Cabang');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('C2', 'Informasi Nama Cabang');
        

        $report = $this->Branches->find('all')->where(['Branches.is_active' => 'Y'])->order(['Branches.name' => 'ASC'])->toArray();

        $row = 3;
        foreach ($report as $index => $data) {
            $sheet->setCellValue('A' . $row, $data->id);
            $sheet->setCellValue('B' . $row, $data->code);
            $sheet->setCellValue('C' . $row, $data->name);

            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'daftar-cabang';        
        //$filename = 'customers-' . date('dmy-His');

        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
