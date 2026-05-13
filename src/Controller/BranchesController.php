<?php
declare(strict_types=1);

namespace App\Controller;

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
}
