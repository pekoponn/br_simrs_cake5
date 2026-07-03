<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OrderRadiologies Controller
 *
 * @property \App\Model\Table\OrderRadiologiesTable $OrderRadiologies
 * @method \App\Model\Entity\OrderRadiology[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderRadiologiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders', 'Registrations', 'Patients', 'Doctors', 'MasterRadiologies'],
        ];
        $orderRadiologies = $this->paginate($this->OrderRadiologies);

        $this->set(compact('orderRadiologies'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Radiology id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderRadiology = $this->OrderRadiologies->get($id, [
            'contain' => ['Orders', 'Registrations', 'Patients', 'Doctors', 'MasterRadiologies'],
        ]);

        $this->set(compact('orderRadiology'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderRadiology = $this->OrderRadiologies->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderRadiology = $this->OrderRadiologies->patchEntity($orderRadiology, $this->request->getData());
            if ($this->OrderRadiologies->save($orderRadiology)) {
                $this->Flash->success(__('The order radiology has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order radiology could not be saved. Please, try again.'));
        }
        $orders = $this->OrderRadiologies->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderRadiologies->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderRadiologies->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderRadiologies->Doctors->find('list', ['limit' => 200]);
        $masterRadiologies = $this->OrderRadiologies->MasterRadiologies->find('list', ['limit' => 200]);
        $this->set(compact('orderRadiology', 'orders', 'registrations', 'patients', 'doctors', 'masterRadiologies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Radiology id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderRadiology = $this->OrderRadiologies->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderRadiology = $this->OrderRadiologies->patchEntity($orderRadiology, $this->request->getData());
            if ($this->OrderRadiologies->save($orderRadiology)) {
                $this->Flash->success(__('The order radiology has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order radiology could not be saved. Please, try again.'));
        }
        $orders = $this->OrderRadiologies->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderRadiologies->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderRadiologies->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderRadiologies->Doctors->find('list', ['limit' => 200]);
        $masterRadiologies = $this->OrderRadiologies->MasterRadiologies->find('list', ['limit' => 200]);
        $this->set(compact('orderRadiology', 'orders', 'registrations', 'patients', 'doctors', 'masterRadiologies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Radiology id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderRadiology = $this->OrderRadiologies->get($id);
        if ($this->OrderRadiologies->delete($orderRadiology)) {
            $this->Flash->success(__('The order radiology has been deleted.'));
        } else {
            $this->Flash->error(__('The order radiology could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}