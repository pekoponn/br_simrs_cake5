<?php
declare(strict_types=1);

namespace App\Controller\Kasir;

use App\Controller\AppController;

/**
 * OutpatientBillingItems Controller
 *
 * @method \App\Model\Entity\OutpatientBillingItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutpatientBillingItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $outpatientBillingItems = $this->paginate($this->OutpatientBillingItems);

        $this->set(compact('outpatientBillingItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Outpatient Billing Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outpatientBillingItem = $this->OutpatientBillingItems->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('outpatientBillingItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $outpatientBillingItem = $this->OutpatientBillingItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $outpatientBillingItem = $this->OutpatientBillingItems->patchEntity($outpatientBillingItem, $this->request->getData());
            if ($this->OutpatientBillingItems->save($outpatientBillingItem)) {
                $this->Flash->success(__('The outpatient billing item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient billing item could not be saved. Please, try again.'));
        }
        $this->set(compact('outpatientBillingItem'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Outpatient Billing Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outpatientBillingItem = $this->OutpatientBillingItems->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outpatientBillingItem = $this->OutpatientBillingItems->patchEntity($outpatientBillingItem, $this->request->getData());
            if ($this->OutpatientBillingItems->save($outpatientBillingItem)) {
                $this->Flash->success(__('The outpatient billing item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient billing item could not be saved. Please, try again.'));
        }
        $this->set(compact('outpatientBillingItem'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Outpatient Billing Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outpatientBillingItem = $this->OutpatientBillingItems->get($id);
        if ($this->OutpatientBillingItems->delete($outpatientBillingItem)) {
            $this->Flash->success(__('The outpatient billing item has been deleted.'));
        } else {
            $this->Flash->error(__('The outpatient billing item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}