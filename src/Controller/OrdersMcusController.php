<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OrderMcus Controller
 *
 * @property \App\Model\Table\OrderMcusTable $OrderMcus
 * @method \App\Model\Entity\OrderMcus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderMcusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Registrations', 'Patients', 'Doctors'],
        ];
        $orderMcus = $this->paginate($this->OrderMcus);

        $this->set(compact('orderMcus'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Mcus id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderMcus = $this->OrderMcus->get($id, [
            'contain' => ['Orders', 'Registrations', 'Patients', 'Doctors'],
        ]);

        $this->set(compact('orderMcus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderMcus = $this->OrderMcus->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderMcus = $this->OrderMcus->patchEntity($orderMcus, $this->request->getData());
            if ($this->OrderMcus->save($orderMcus)) {
                $this->Flash->success(__('The order mcus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order mcus could not be saved. Please, try again.'));
        }
        $orders = $this->OrderMcus->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderMcus->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderMcus->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderMcus->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('orderMcus', 'orders', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Mcus id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderMcus = $this->OrderMcus->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderMcus = $this->OrderMcus->patchEntity($orderMcus, $this->request->getData());
            if ($this->OrderMcus->save($orderMcus)) {
                $this->Flash->success(__('The order mcus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order mcus could not be saved. Please, try again.'));
        }
        $orders = $this->OrderMcus->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderMcus->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderMcus->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderMcus->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('orderMcus', 'orders', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Mcus id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderMcus = $this->OrderMcus->get($id);
        if ($this->OrderMcus->delete($orderMcus)) {
            $this->Flash->success(__('The order mcus has been deleted.'));
        } else {
            $this->Flash->error(__('The order mcus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}