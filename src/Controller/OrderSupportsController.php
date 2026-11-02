<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OrderSupports Controller
 *
 * @property \App\Model\Table\OrderSupportsTable $OrderSupports
 * @method \App\Model\Entity\OrderSupport[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderSupportsController extends AppController
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
        $orderSupports = $this->paginate($this->OrderSupports);

        $this->set(compact('orderSupports'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Support id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderSupport = $this->OrderSupports->get($id, contain: ['Orders', 'Registrations', 'Patients', 'Doctors']);

        $this->set(compact('orderSupport'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderSupport = $this->OrderSupports->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderSupport = $this->OrderSupports->patchEntity($orderSupport, $this->request->getData());
            if ($this->OrderSupports->save($orderSupport)) {
                $this->Flash->success(__('The order support has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order support could not be saved. Please, try again.'));
        }
        $orders = $this->OrderSupports->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderSupports->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderSupports->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderSupports->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('orderSupport', 'orders', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Support id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderSupport = $this->OrderSupports->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderSupport = $this->OrderSupports->patchEntity($orderSupport, $this->request->getData());
            if ($this->OrderSupports->save($orderSupport)) {
                $this->Flash->success(__('The order support has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order support could not be saved. Please, try again.'));
        }
        $orders = $this->OrderSupports->Orders->find('list', ['limit' => 200]);
        $registrations = $this->OrderSupports->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OrderSupports->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OrderSupports->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('orderSupport', 'orders', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Support id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderSupport = $this->OrderSupports->get($id);
        if ($this->OrderSupports->delete($orderSupport)) {
            $this->Flash->success(__('The order support has been deleted.'));
        } else {
            $this->Flash->error(__('The order support could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
