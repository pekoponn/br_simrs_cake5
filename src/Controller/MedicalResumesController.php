<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MedicalResumes Controller
 *
 * @property \App\Model\Table\MedicalResumesTable $MedicalResumes
 * @method \App\Model\Entity\MedicalResume[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicalResumesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['OutpatientVisits', 'Registrations', 'Patients', 'Doctor1s'],
        ];
        $medicalResumes = $this->paginate($this->MedicalResumes);

        $this->set(compact('medicalResumes'));
    }

    /**
     * View method
     *
     * @param string|null $id Medical Resume id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicalResume = $this->MedicalResumes->get($id, contain: ['OutpatientVisits', 'Registrations', 'Patients', 'Doctor1s']);

        $this->set(compact('medicalResume'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicalResume = $this->MedicalResumes->newEmptyEntity();
        if ($this->request->is('post')) {
            $medicalResume = $this->MedicalResumes->patchEntity($medicalResume, $this->request->getData());
            if ($this->MedicalResumes->save($medicalResume)) {
                $this->Flash->success(__('The medical resume has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medical resume could not be saved. Please, try again.'));
        }
        $outpatientVisits = $this->MedicalResumes->OutpatientVisits->find('list', ['limit' => 200]);
        $registrations = $this->MedicalResumes->Registrations->find('list', ['limit' => 200]);
        $patients = $this->MedicalResumes->Patients->find('list', ['limit' => 200]);
        $doctor1s = $this->MedicalResumes->Doctor1s->find('list', ['limit' => 200]);
        $this->set(compact('medicalResume', 'outpatientVisits', 'registrations', 'patients', 'doctor1s'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medical Resume id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicalResume = $this->MedicalResumes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicalResume = $this->MedicalResumes->patchEntity($medicalResume, $this->request->getData());
            if ($this->MedicalResumes->save($medicalResume)) {
                $this->Flash->success(__('The medical resume has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medical resume could not be saved. Please, try again.'));
        }
        $outpatientVisits = $this->MedicalResumes->OutpatientVisits->find('list', ['limit' => 200]);
        $registrations = $this->MedicalResumes->Registrations->find('list', ['limit' => 200]);
        $patients = $this->MedicalResumes->Patients->find('list', ['limit' => 200]);
        $doctor1s = $this->MedicalResumes->Doctor1s->find('list', ['limit' => 200]);
        $this->set(compact('medicalResume', 'outpatientVisits', 'registrations', 'patients', 'doctor1s'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medical Resume id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicalResume = $this->MedicalResumes->get($id);
        if ($this->MedicalResumes->delete($medicalResume)) {
            $this->Flash->success(__('The medical resume has been deleted.'));
        } else {
            $this->Flash->error(__('The medical resume could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
