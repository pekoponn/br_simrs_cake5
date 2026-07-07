<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OrderSurgeries Controller
 *
 * @property \App\Model\Table\OrderSurgeriesTable $OrderSurgeries
 * @method \App\Model\Entity\OrderSurgery[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderSurgeriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Registrations', 'Patients', 'Doctors', 'Operators', 'OperationTypes'],
        ];
        $orderSurgeries = $this->paginate($this->OrderSurgeries);

        $this->set(compact('orderSurgeries'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Surgery id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderSurgery = $this->OrderSurgeries->get($id, [
            'contain' => ['Orders', 'Registrations', 'Patients', 'Doctors', 'Operators', 'OperationTypes'],
        ]);

        $this->set(compact('orderSurgery'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderSurgery = $this->OrderSurgeries->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderSurgery = $this->OrderSurgeries->patchEntity($orderSurgery, $this->request->getData());
            if ($this->OrderSurgeries->save($orderSurgery)) {
                $this->Flash->success(__('The order surgery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order surgery could not be saved. Please, try again.'));
        }
        $orders = $this->OrderSurgeries->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderSurgeries->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderSurgeries->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderSurgeries->Doctors->find('list', ['limit' => 200]);
        $operators = $this->OrderSurgeries->Operators->find('list', ['limit' => 200]);
        $operationTypes = $this->OrderSurgeries->OperationTypes->find('list', ['limit' => 200]);
        $this->set(compact('orderSurgery', 'orders', 'registrations', 'patients', 'doctors', 'operators', 'operationTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Surgery id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderSurgery = $this->OrderSurgeries->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderSurgery = $this->OrderSurgeries->patchEntity($orderSurgery, $this->request->getData());
            if ($this->OrderSurgeries->save($orderSurgery)) {
                $this->Flash->success(__('The order surgery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order surgery could not be saved. Please, try again.'));
        }
        $orders = $this->OrderSurgeries->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderSurgeries->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderSurgeries->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderSurgeries->Doctors->find('list', ['limit' => 200]);
        $operators = $this->OrderSurgeries->Operators->find('list', ['limit' => 200]);
        $operationTypes = $this->OrderSurgeries->OperationTypes->find('list', ['limit' => 200]);
        $this->set(compact('orderSurgery', 'orders', 'registrations', 'patients', 'doctors', 'operators', 'operationTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Surgery id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderSurgery = $this->OrderSurgeries->get($id);
        if ($this->OrderSurgeries->delete($orderSurgery)) {
            $this->Flash->success(__('The order surgery has been deleted.'));
        } else {
            $this->Flash->error(__('The order surgery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
