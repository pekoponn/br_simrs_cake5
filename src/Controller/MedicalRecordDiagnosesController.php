<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MedicalRecordDiagnoses Controller
 *
 * @property \App\Model\Table\MedicalRecordDiagnosesTable $MedicalRecordDiagnoses
 * @method \App\Model\Entity\MedicalRecordDiagnosis[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicalRecordDiagnosesController extends AppController
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
        $medicalRecordDiagnoses = $this->paginate($this->MedicalRecordDiagnoses);

        $this->set(compact('medicalRecordDiagnoses'));
    }

    /**
     * View method
     *
     * @param string|null $id Medical Record Diagnosis id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicalRecordDiagnosis = $this->MedicalRecordDiagnoses->get($id, contain: ['MedicalRecords']);

        $this->set(compact('medicalRecordDiagnosis'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicalRecordDiagnosis = $this->MedicalRecordDiagnoses->newEmptyEntity();
        if ($this->request->is('post')) {
            $medicalRecordDiagnosis = $this->MedicalRecordDiagnoses->patchEntity($medicalRecordDiagnosis, $this->request->getData());
            if ($this->MedicalRecordDiagnoses->save($medicalRecordDiagnosis)) {
                $this->Flash->success(__('The medical record diagnosis has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medical record diagnosis could not be saved. Please, try again.'));
        }
        $medicalRecords = $this->MedicalRecordDiagnoses->MedicalRecords->find('list', ['limit' => 200]);
        $this->set(compact('medicalRecordDiagnosis', 'medicalRecords'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medical Record Diagnosis id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicalRecordDiagnosis = $this->MedicalRecordDiagnoses->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicalRecordDiagnosis = $this->MedicalRecordDiagnoses->patchEntity($medicalRecordDiagnosis, $this->request->getData());
            if ($this->MedicalRecordDiagnoses->save($medicalRecordDiagnosis)) {
                $this->Flash->success(__('The medical record diagnosis has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medical record diagnosis could not be saved. Please, try again.'));
        }
        $medicalRecords = $this->MedicalRecordDiagnoses->MedicalRecords->find('list', ['limit' => 200]);
        $this->set(compact('medicalRecordDiagnosis', 'medicalRecords'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medical Record Diagnosis id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicalRecordDiagnosis = $this->MedicalRecordDiagnoses->get($id);
        if ($this->MedicalRecordDiagnoses->delete($medicalRecordDiagnosis)) {
            $this->Flash->success(__('The medical record diagnosis has been deleted.'));
        } else {
            $this->Flash->error(__('The medical record diagnosis could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
