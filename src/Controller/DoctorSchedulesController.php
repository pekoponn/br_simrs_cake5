<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DoctorSchedules Controller
 *
 * @property \App\Model\Table\DoctorSchedulesTable $DoctorSchedules
 * @method \App\Model\Entity\DoctorSchedule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DoctorSchedulesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('DoctorSchedules');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Doctors'],
        ];
        $doctorSchedules = $this->paginate($this->DoctorSchedules);

        $this->set(compact('doctorSchedules'));
    }

    /**
     * View method
     *
     * @param string|null $id Doctor Schedule id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $doctorSchedule = $this->DoctorSchedules->get($id, [
            'contain' => ['Doctors'],
        ]);

        $this->set(compact('doctorSchedule'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $doctorSchedule = $this->DoctorSchedules->newEmptyEntity();
        if ($this->request->is('post')) {
            $doctorSchedule = $this->DoctorSchedules->patchEntity($doctorSchedule, $this->request->getData());
            if ($this->DoctorSchedules->save($doctorSchedule)) {
                $this->Flash->success(__('The doctor schedule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The doctor schedule could not be saved. Please, try again.'));
        }
        $doctors = $this->DoctorSchedules->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('doctorSchedule', 'doctors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Doctor Schedule id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $doctorSchedule = $this->DoctorSchedules->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $doctorSchedule = $this->DoctorSchedules->patchEntity($doctorSchedule, $this->request->getData());
            if ($this->DoctorSchedules->save($doctorSchedule)) {
                $this->Flash->success(__('The doctor schedule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The doctor schedule could not be saved. Please, try again.'));
        }
        $doctors = $this->DoctorSchedules->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('doctorSchedule', 'doctors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Doctor Schedule id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $doctorSchedule = $this->DoctorSchedules->get($id);
        if ($this->DoctorSchedules->delete($doctorSchedule)) {
            $this->Flash->success(__('The doctor schedule has been deleted.'));
        } else {
            $this->Flash->error(__('The doctor schedule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
