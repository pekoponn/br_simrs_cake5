<?php
declare(strict_types=1);

namespace App\Controller\Kasir;

use App\Controller\AppController;

/**
 * OutpatientBillingPayments Controller
 *
 * @method \App\Model\Entity\OutpatientBillingPayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutpatientBillingPaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $outpatientBillingPayments = $this->paginate($this->OutpatientBillingPayments);

        $this->set(compact('outpatientBillingPayments'));
    }

    /**
     * View method
     *
     * @param string|null $id Outpatient Billing Payment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outpatientBillingPayment = $this->OutpatientBillingPayments->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('outpatientBillingPayment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $outpatientBillingPayment = $this->OutpatientBillingPayments->newEmptyEntity();
        if ($this->request->is('post')) {
            $outpatientBillingPayment = $this->OutpatientBillingPayments->patchEntity($outpatientBillingPayment, $this->request->getData());
            if ($this->OutpatientBillingPayments->save($outpatientBillingPayment)) {
                $this->Flash->success(__('The outpatient billing payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient billing payment could not be saved. Please, try again.'));
        }
        $this->set(compact('outpatientBillingPayment'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Outpatient Billing Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outpatientBillingPayment = $this->OutpatientBillingPayments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outpatientBillingPayment = $this->OutpatientBillingPayments->patchEntity($outpatientBillingPayment, $this->request->getData());
            if ($this->OutpatientBillingPayments->save($outpatientBillingPayment)) {
                $this->Flash->success(__('The outpatient billing payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient billing payment could not be saved. Please, try again.'));
        }
        $this->set(compact('outpatientBillingPayment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Outpatient Billing Payment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outpatientBillingPayment = $this->OutpatientBillingPayments->get($id);
        if ($this->OutpatientBillingPayments->delete($outpatientBillingPayment)) {
            $this->Flash->success(__('The outpatient billing payment has been deleted.'));
        } else {
            $this->Flash->error(__('The outpatient billing payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}