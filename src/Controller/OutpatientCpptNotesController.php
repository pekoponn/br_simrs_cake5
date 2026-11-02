<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OutpatientCpptNotes Controller
 *
 * @property \App\Model\Table\OutpatientCpptNotesTable $OutpatientCpptNotes
 * @method \App\Model\Entity\OutpatientCpptNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutpatientCpptNotesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['OutpatientVisits', 'Registrations', 'Patients', 'Doctors'],
        ];
        $outpatientCpptNotes = $this->paginate($this->OutpatientCpptNotes);

        $this->set(compact('outpatientCpptNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Outpatient Cppt Note id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outpatientCpptNote = $this->OutpatientCpptNotes->get($id, contain: ['OutpatientVisits', 'Registrations', 'Patients', 'Doctors']);

        $this->set(compact('outpatientCpptNote'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $outpatientCpptNote = $this->OutpatientCpptNotes->newEmptyEntity();
        if ($this->request->is('post')) {
            $outpatientCpptNote = $this->OutpatientCpptNotes->patchEntity($outpatientCpptNote, $this->request->getData());
            if ($this->OutpatientCpptNotes->save($outpatientCpptNote)) {
                $this->Flash->success(__('The outpatient cppt note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient cppt note could not be saved. Please, try again.'));
        }
        $outpatientVisits = $this->OutpatientCpptNotes->OutpatientVisits->find('list', ['limit' => 200]);
        $registrations = $this->OutpatientCpptNotes->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OutpatientCpptNotes->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OutpatientCpptNotes->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('outpatientCpptNote', 'outpatientVisits', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Outpatient Cppt Note id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outpatientCpptNote = $this->OutpatientCpptNotes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outpatientCpptNote = $this->OutpatientCpptNotes->patchEntity($outpatientCpptNote, $this->request->getData());
            if ($this->OutpatientCpptNotes->save($outpatientCpptNote)) {
                $this->Flash->success(__('The outpatient cppt note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient cppt note could not be saved. Please, try again.'));
        }
        $outpatientVisits = $this->OutpatientCpptNotes->OutpatientVisits->find('list', ['limit' => 200]);
        $registrations = $this->OutpatientCpptNotes->Registrations->find('list', ['limit' => 200]);
        $patients = $this->OutpatientCpptNotes->Patients->find('list', ['limit' => 200]);
        $doctors = $this->OutpatientCpptNotes->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('outpatientCpptNote', 'outpatientVisits', 'registrations', 'patients', 'doctors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Outpatient Cppt Note id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outpatientCpptNote = $this->OutpatientCpptNotes->get($id);
        if ($this->OutpatientCpptNotes->delete($outpatientCpptNote)) {
            $this->Flash->success(__('The outpatient cppt note has been deleted.'));
        } else {
            $this->Flash->error(__('The outpatient cppt note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
