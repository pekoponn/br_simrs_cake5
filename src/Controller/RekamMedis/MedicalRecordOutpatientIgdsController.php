<?php
declare(strict_types=1);

namespace App\Controller\RekamMedis;

use App\Controller\AppController;

/**
 * MedicalRecordOutpatientIgds Controller
 *
 * @property \App\Model\Table\MedicalRecordOutpatientIgdsTable $MedicalRecordOutpatientIgds
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicalRecordOutpatientIgdsController extends AppController
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
        $medicalRecordOutpatientIgds = $this->paginate($this->MedicalRecordOutpatientIgds);

        $this->set(compact('medicalRecordOutpatientIgds'));
    }

    /**
     * View method
     *
     * @param string|null $id Medical Record Outpatient Igd id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicalRecordOutpatientIgd = $this->MedicalRecordOutpatientIgds->get($id, contain: ['MedicalRecords']);

        $this->set(compact('medicalRecordOutpatientIgd'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicalRecordOutpatientIgd = $this->MedicalRecordOutpatientIgds->newEmptyEntity();
        if ($this->request->is('post')) {
            $medicalRecordOutpatientIgd = $this->MedicalRecordOutpatientIgds->patchEntity($medicalRecordOutpatientIgd, $this->request->getData());
            if ($this->MedicalRecordOutpatientIgds->save($medicalRecordOutpatientIgd)) {
                $this->Flash->success(__('The medical record outpatient igd has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medical record outpatient igd could not be saved. Please, try again.'));
        }
        $medicalRecords = $this->MedicalRecordOutpatientIgds->MedicalRecords->find('list', ['limit' => 200]);
        $this->set(compact('medicalRecordOutpatientIgd', 'medicalRecords'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medical Record Outpatient Igd id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicalRecordOutpatientIgd = $this->MedicalRecordOutpatientIgds->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicalRecordOutpatientIgd = $this->MedicalRecordOutpatientIgds->patchEntity($medicalRecordOutpatientIgd, $this->request->getData());
            if ($this->MedicalRecordOutpatientIgds->save($medicalRecordOutpatientIgd)) {
                $this->Flash->success(__('The medical record outpatient igd has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medical record outpatient igd could not be saved. Please, try again.'));
        }
        $medicalRecords = $this->MedicalRecordOutpatientIgds->MedicalRecords->find('list', ['limit' => 200]);
        $this->set(compact('medicalRecordOutpatientIgd', 'medicalRecords'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medical Record Outpatient Igd id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicalRecordOutpatientIgd = $this->MedicalRecordOutpatientIgds->get($id);
        if ($this->MedicalRecordOutpatientIgds->delete($medicalRecordOutpatientIgd)) {
            $this->Flash->success(__('The medical record outpatient igd has been deleted.'));
        } else {
            $this->Flash->error(__('The medical record outpatient igd could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
