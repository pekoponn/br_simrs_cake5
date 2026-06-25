<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EmergencyEntries Controller
 *
 * @property \App\Model\Table\EmergencyEntriesTable $EmergencyEntries
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmergencyEntriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Registrations', 'Patients', 'Doctors'],
        ];
        $emergencyEntries = $this->paginate($this->EmergencyEntries);

        $this->set(compact('emergencyEntries'));
    }

    /**
     * View method
     *
     * @param string|null $id Emergency Entry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emergencyEntry = $this->EmergencyEntries->get($id, [
            'contain' => ['Registrations', 'Patients', 'Doctors'],
        ]);

        $this->set(compact('emergencyEntry'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emergencyEntry = $this->EmergencyEntries->newEmptyEntity();
        if ($this->request->is('post')) {
            $emergencyEntry = $this->EmergencyEntries->patchEntity($emergencyEntry, $this->request->getData());
            if ($this->EmergencyEntries->save($emergencyEntry)) {
                $this->Flash->success(__('The emergency entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emergency entry could not be saved. Please, try again.'));
        }
        $registrations = $this->EmergencyEntries->Registrations->find('list', ['limit' => 200]);
        $patients = $this->EmergencyEntries->Patients->find('list', ['limit' => 200]);
        $doctors = $this->EmergencyEntries->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('emergencyEntry', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Emergency Entry id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emergencyEntry = $this->EmergencyEntries->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emergencyEntry = $this->EmergencyEntries->patchEntity($emergencyEntry, $this->request->getData());
            if ($this->EmergencyEntries->save($emergencyEntry)) {
                $this->Flash->success(__('The emergency entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emergency entry could not be saved. Please, try again.'));
        }
        $registrations = $this->EmergencyEntries->Registrations->find('list', ['limit' => 200]);
        $patients = $this->EmergencyEntries->Patients->find('list', ['limit' => 200]);
        $doctors = $this->EmergencyEntries->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('emergencyEntry', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Emergency Entry id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emergencyEntry = $this->EmergencyEntries->get($id);
        if ($this->EmergencyEntries->delete($emergencyEntry)) {
            $this->Flash->success(__('The emergency entry has been deleted.'));
        } else {
            $this->Flash->error(__('The emergency entry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}