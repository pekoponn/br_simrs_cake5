<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InvoiceDetails Controller
 *
 * @property \App\Model\Table\InvoiceDetailsTable $InvoiceDetails
 * @method \App\Model\Entity\InvoiceDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoiceDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Invoices', 'Medicines'],
        ];
        $invoiceDetails = $this->paginate($this->InvoiceDetails);

        $this->set(compact('invoiceDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoice Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoiceDetail = $this->InvoiceDetails->get($id, contain: ['Invoices', 'Medicines']);

        $this->set(compact('invoiceDetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoiceDetail = $this->InvoiceDetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $invoiceDetail = $this->InvoiceDetails->patchEntity($invoiceDetail, $this->request->getData());
            if ($this->InvoiceDetails->save($invoiceDetail)) {
                $this->Flash->success(__('The invoice detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice detail could not be saved. Please, try again.'));
        }
        $invoices = $this->InvoiceDetails->Invoices->find('list', ['limit' => 200]);
        $medicines = $this->InvoiceDetails->Medicines->find('list', ['limit' => 200]);
        $this->set(compact('invoiceDetail', 'invoices', 'medicines'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoiceDetail = $this->InvoiceDetails->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoiceDetail = $this->InvoiceDetails->patchEntity($invoiceDetail, $this->request->getData());
            if ($this->InvoiceDetails->save($invoiceDetail)) {
                $this->Flash->success(__('The invoice detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice detail could not be saved. Please, try again.'));
        }
        $invoices = $this->InvoiceDetails->Invoices->find('list', ['limit' => 200]);
        $medicines = $this->InvoiceDetails->Medicines->find('list', ['limit' => 200]);
        $this->set(compact('invoiceDetail', 'invoices', 'medicines'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoiceDetail = $this->InvoiceDetails->get($id);
        if ($this->InvoiceDetails->delete($invoiceDetail)) {
            $this->Flash->success(__('The invoice detail has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
