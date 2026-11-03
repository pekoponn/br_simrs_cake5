<?php
declare(strict_types=1);

namespace App\Controller\RekamMedis;

use App\Controller\AppController;

/**
 * MedicalRecordInpatients Controller
 *
 * @property \App\Model\Table\MedicalRecordInpatientsTable $MedicalRecordInpatients
 * @method \App\Model\Entity\MedicalRecordInpatient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicalRecordInpatientsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['MedicalRecords'],
        ];
        $medicalRecordInpatients = $this->paginate($this->MedicalRecordInpatients);

        $this->set(compact('medicalRecordInpatients'));
    }

    /**
     * View method
     *
     * @param string|null $id Medical Record Inpatient id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicalRecordInpatient = $this->MedicalRecordInpatients->get($id, contain: ['MedicalRecords']);

        $this->set(compact('medicalRecordInpatient'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicalRecordInpatient = $this->MedicalRecordInpatients->newEmptyEntity();
        if ($this->request->is('post')) {
            $medicalRecordInpatient = $this->MedicalRecordInpatients->patchEntity($medicalRecordInpatient, $this->request->getData());
            if ($this->MedicalRecordInpatients->save($medicalRecordInpatient)) {
                $this->Flash->success(__('The medical record inpatient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medical record inpatient could not be saved. Please, try again.'));
        }
        $medicalRecords = $this->MedicalRecordInpatients->MedicalRecords->find('list', ['limit' => 200]);
        $this->set(compact('medicalRecordInpatient', 'medicalRecords'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medical Record Inpatient id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicalRecordInpatient = $this->MedicalRecordInpatients->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicalRecordInpatient = $this->MedicalRecordInpatients->patchEntity($medicalRecordInpatient, $this->request->getData());
            if ($this->MedicalRecordInpatients->save($medicalRecordInpatient)) {
                $this->Flash->success(__('The medical record inpatient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medical record inpatient could not be saved. Please, try again.'));
        }
        $medicalRecords = $this->MedicalRecordInpatients->MedicalRecords->find('list', ['limit' => 200]);
        $this->set(compact('medicalRecordInpatient', 'medicalRecords'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medical Record Inpatient id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicalRecordInpatient = $this->MedicalRecordInpatients->get($id);
        if ($this->MedicalRecordInpatients->delete($medicalRecordInpatient)) {
            $this->Flash->success(__('The medical record inpatient has been deleted.'));
        } else {
            $this->Flash->error(__('The medical record inpatient could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
