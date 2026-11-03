<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * BedHistories Controller
 *
 * @property \App\Model\Table\BedHistoriesTable $BedHistories
 * @method \App\Model\Entity\BedHistory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BedHistoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Beds', 'Rooms'],
        ];
        $bedHistories = $this->paginate($this->BedHistories);

        $this->set(compact('bedHistories'));
    }

    /**
     * View method
     *
     * @param string|null $id Bed History id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bedHistory = $this->BedHistories->get($id, contain: ['Beds', 'Rooms']);

        $this->set(compact('bedHistory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bedHistory = $this->BedHistories->newEmptyEntity();
        if ($this->request->is('post')) {
            $bedHistory = $this->BedHistories->patchEntity($bedHistory, $this->request->getData());
            if ($this->BedHistories->save($bedHistory)) {
                $this->Flash->success(__('The bed history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bed history could not be saved. Please, try again.'));
        }
        $beds = $this->BedHistories->Beds->find('list', ['limit' => 200]);
        $rooms = $this->BedHistories->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('bedHistory', 'beds', 'rooms'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bed History id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bedHistory = $this->BedHistories->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bedHistory = $this->BedHistories->patchEntity($bedHistory, $this->request->getData());
            if ($this->BedHistories->save($bedHistory)) {
                $this->Flash->success(__('The bed history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bed history could not be saved. Please, try again.'));
        }
        $beds = $this->BedHistories->Beds->find('list', ['limit' => 200]);
        $rooms = $this->BedHistories->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('bedHistory', 'beds', 'rooms'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bed History id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bedHistory = $this->BedHistories->get($id);
        if ($this->BedHistories->delete($bedHistory)) {
            $this->Flash->success(__('The bed history has been deleted.'));
        } else {
            $this->Flash->error(__('The bed history could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
