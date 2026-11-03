<?php
declare(strict_types=1);

namespace App\Controller\Registrasi;

use App\Controller\AppController;

/**
 * InpatientEntries Controller
 *
 * @property \App\Model\Table\InpatientEntriesTable $InpatientEntries
 * @method \App\Model\Entity\InpatientEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InpatientEntriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Registrations = $this->fetchTable('Registrations');
        $this->Rooms = $this->fetchTable('Rooms');

        $q = trim((string)$this->request->getQuery('q'));
        $roomId = $this->request->getQuery('room_id');

        $query = $this->Registrations->find()
            ->contain([
                'Patients',
                'Doctors',
                'Rooms',
                'Beds',
            ])
            ->where([
                'Registrations.service_type' => 'rawat_inap',
            ]);

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'Registrations.registration_no LIKE' => '%' . $q . '%',
                    'Registrations.registration_number LIKE' => '%' . $q . '%',
                    'Patients.code LIKE' => '%' . $q . '%',
                    'Patients.full_name LIKE' => '%' . $q . '%',
                    'Doctors.doctor_name LIKE' => '%' . $q . '%',
                    'Doctors.name LIKE' => '%' . $q . '%',
                    'Rooms.room_name LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        if (!empty($roomId)) {
            $query->where([
                'Registrations.room_id' => $roomId,
            ]);
        }

        $this->paginate = [
            'limit' => 50,
            'order' => [
                'Registrations.id' => 'DESC',
            ],
        ];

        $registrations = $this->paginate($query);

        $rooms = $this->Rooms->find('list', [
            'keyField' => 'id',
            'valueField' => 'room_name',
        ])
        ->order(['Rooms.room_name' => 'ASC'])
        ->toArray();

        $this->set(compact(
            'registrations',
            'rooms',
            'q',
            'roomId'
        ));
    }

    /**
     * View method
     *
     * @param string|null $id Inpatient Entry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inpatientEntry = $this->InpatientEntries->get($id, contain: ['Registrations', 'Patients', 'Doctors', 'Rooms', 'Beds']);

        $this->set(compact('inpatientEntry'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inpatientEntry = $this->InpatientEntries->newEmptyEntity();
        if ($this->request->is('post')) {
            $inpatientEntry = $this->InpatientEntries->patchEntity($inpatientEntry, $this->request->getData());
            if ($this->InpatientEntries->save($inpatientEntry)) {
                $this->Flash->success(__('The inpatient entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inpatient entry could not be saved. Please, try again.'));
        }
        $registrations = $this->InpatientEntries->Registrations->find('list', ['limit' => 200]);
        $patients = $this->InpatientEntries->Patients->find('list', ['limit' => 200]);
        $doctors = $this->InpatientEntries->Doctors->find('list', ['limit' => 200]);
        $rooms = $this->InpatientEntries->Rooms->find('list', ['limit' => 200]);
        $beds = $this->InpatientEntries->Beds->find('list', ['limit' => 200]);
        $this->set(compact('inpatientEntry', 'registrations', 'patients', 'doctors', 'rooms', 'beds'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inpatient Entry id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inpatientEntry = $this->InpatientEntries->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inpatientEntry = $this->InpatientEntries->patchEntity($inpatientEntry, $this->request->getData());
            if ($this->InpatientEntries->save($inpatientEntry)) {
                $this->Flash->success(__('The inpatient entry has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inpatient entry could not be saved. Please, try again.'));
        }
        $registrations = $this->InpatientEntries->Registrations->find('list', ['limit' => 200]);
        $patients = $this->InpatientEntries->Patients->find('list', ['limit' => 200]);
        $doctors = $this->InpatientEntries->Doctors->find('list', ['limit' => 200]);
        $rooms = $this->InpatientEntries->Rooms->find('list', ['limit' => 200]);
        $beds = $this->InpatientEntries->Beds->find('list', ['limit' => 200]);
        $this->set(compact('inpatientEntry', 'registrations', 'patients', 'doctors', 'rooms', 'beds'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inpatient Entry id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inpatientEntry = $this->InpatientEntries->get($id);
        if ($this->InpatientEntries->delete($inpatientEntry)) {
            $this->Flash->success(__('The inpatient entry has been deleted.'));
        } else {
            $this->Flash->error(__('The inpatient entry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
