<?php
declare(strict_types=1);

namespace App\Controller\Farmasi;

use App\Controller\AppController;

/**
 * OrderPrescriptions Controller
 *
 * @property \App\Model\Table\OrderPrescriptionsTable $OrderPrescriptions
 * @method \App\Model\Entity\OrderPrescription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderPrescriptionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Medicines'],
        ];
        $orderPrescriptions = $this->paginate($this->OrderPrescriptions);

        $this->set(compact('orderPrescriptions'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Prescription id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderPrescription = $this->OrderPrescriptions->get($id, contain: ['Orders', 'Medicines']);

        $this->set(compact('orderPrescription'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderPrescription = $this->OrderPrescriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderPrescription = $this->OrderPrescriptions->patchEntity($orderPrescription, $this->request->getData());
            if ($this->OrderPrescriptions->save($orderPrescription)) {
                $this->Flash->success(__('The order prescription has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order prescription could not be saved. Please, try again.'));
        }
        $orders = $this->OrderPrescriptions->Orders->find('list', ['limit' => 200]);
        $medicines = $this->OrderPrescriptions->Medicines->find('list', ['limit' => 200]);
        $this->set(compact('orderPrescription', 'orders', 'medicines'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Prescription id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderPrescription = $this->OrderPrescriptions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderPrescription = $this->OrderPrescriptions->patchEntity($orderPrescription, $this->request->getData());
            if ($this->OrderPrescriptions->save($orderPrescription)) {
                $this->Flash->success(__('The order prescription has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order prescription could not be saved. Please, try again.'));
        }
        $orders = $this->OrderPrescriptions->Orders->find('list', ['limit' => 200]);
        $medicines = $this->OrderPrescriptions->Medicines->find('list', ['limit' => 200]);
        $this->set(compact('orderPrescription', 'orders', 'medicines'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Prescription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderPrescription = $this->OrderPrescriptions->get($id);
        if ($this->OrderPrescriptions->delete($orderPrescription)) {
            $this->Flash->success(__('The order prescription has been deleted.'));
        } else {
            $this->Flash->error(__('The order prescription could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
