<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OrderLaboratories Controller
 *
 * @property \App\Model\Table\OrderLaboratoriesTable $OrderLaboratories
 * @method \App\Model\Entity\OrderLaboratory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderLaboratoriesController extends AppController
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
        $orderLaboratories = $this->paginate($this->OrderLaboratories);

        $this->set(compact('orderLaboratories'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Laboratory id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderLaboratory = $this->OrderLaboratories->get($id, [
            'contain' => ['Orders', 'Registrations', 'Patients', 'Doctors'],
        ]);

        $this->set(compact('orderLaboratory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderLaboratory = $this->OrderLaboratories->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderLaboratory = $this->OrderLaboratories->patchEntity($orderLaboratory, $this->request->getData());
            if ($this->OrderLaboratories->save($orderLaboratory)) {
                $this->Flash->success(__('The order laboratory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order laboratory could not be saved. Please, try again.'));
        }
        $orders = $this->OrderLaboratories->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderLaboratories->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderLaboratories->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderLaboratories->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('orderLaboratory', 'orders', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Laboratory id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderLaboratory = $this->OrderLaboratories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderLaboratory = $this->OrderLaboratories->patchEntity($orderLaboratory, $this->request->getData());
            if ($this->OrderLaboratories->save($orderLaboratory)) {
                $this->Flash->success(__('The order laboratory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order laboratory could not be saved. Please, try again.'));
        }
        $orders = $this->OrderLaboratories->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderLaboratories->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderLaboratories->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderLaboratories->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('orderLaboratory', 'orders', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Laboratory id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderLaboratory = $this->OrderLaboratories->get($id);
        if ($this->OrderLaboratories->delete($orderLaboratory)) {
            $this->Flash->success(__('The order laboratory has been deleted.'));
        } else {
            $this->Flash->error(__('The order laboratory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}