<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OutpatientActions Controller
 *
 * @property \App\Model\Table\OutpatientActionsTable $OutpatientActions
 * @method \App\Model\Entity\OutpatientAction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutpatientActionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['OutpatientVisits', 'MasterTindakan'],
        ];
        $outpatientActions = $this->paginate($this->OutpatientActions);

        $this->set(compact('outpatientActions'));
    }

    /**
     * View method
     *
     * @param string|null $id Outpatient Action id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outpatientAction = $this->OutpatientActions->get($id, [
            'contain' => ['OutpatientVisits', 'MasterTindakan'],
        ]);

        $this->set(compact('outpatientAction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $outpatientAction = $this->OutpatientActions->newEmptyEntity();
        if ($this->request->is('post')) {
            $outpatientAction = $this->OutpatientActions->patchEntity($outpatientAction, $this->request->getData());
            if ($this->OutpatientActions->save($outpatientAction)) {
                $this->Flash->success(__('The outpatient action has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient action could not be saved. Please, try again.'));
        }
        $outpatientVisits = $this->OutpatientActions->OutpatientVisits->find('list', ['limit' => 200]);
        $masterTindakan = $this->OutpatientActions->MasterTindakan->find('list', ['limit' => 200]);
        $this->set(compact('outpatientAction', 'outpatientVisits', 'masterTindakan'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Outpatient Action id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outpatientAction = $this->OutpatientActions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outpatientAction = $this->OutpatientActions->patchEntity($outpatientAction, $this->request->getData());
            if ($this->OutpatientActions->save($outpatientAction)) {
                $this->Flash->success(__('The outpatient action has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outpatient action could not be saved. Please, try again.'));
        }
        $outpatientVisits = $this->OutpatientActions->OutpatientVisits->find('list', ['limit' => 200]);
        $masterTindakan = $this->OutpatientActions->MasterTindakan->find('list', ['limit' => 200]);
        $this->set(compact('outpatientAction', 'outpatientVisits', 'masterTindakan'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Outpatient Action id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outpatientAction = $this->OutpatientActions->get($id);
        if ($this->OutpatientActions->delete($outpatientAction)) {
            $this->Flash->success(__('The outpatient action has been deleted.'));
        } else {
            $this->Flash->error(__('The outpatient action could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
