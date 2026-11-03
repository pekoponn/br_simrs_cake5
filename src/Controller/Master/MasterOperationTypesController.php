<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * MasterOperationTypes Controller
 *
 * @property \App\Model\Table\MasterOperationTypesTable $MasterOperationTypes
 * @method \App\Model\Entity\MasterOperationType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterOperationTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $masterOperationTypes = $this->paginate($this->MasterOperationTypes);

        $this->set(compact('masterOperationTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Master Operation Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterOperationType = $this->MasterOperationTypes->get($id, contain: []);

        $this->set(compact('masterOperationType'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterOperationType = $this->MasterOperationTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $masterOperationType = $this->MasterOperationTypes->patchEntity($masterOperationType, $this->request->getData());
            if ($this->MasterOperationTypes->save($masterOperationType)) {
                $this->Flash->success(__('The master operation type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master operation type could not be saved. Please, try again.'));
        }
        $this->set(compact('masterOperationType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Operation Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterOperationType = $this->MasterOperationTypes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $masterOperationType = $this->MasterOperationTypes->patchEntity($masterOperationType, $this->request->getData());
            if ($this->MasterOperationTypes->save($masterOperationType)) {
                $this->Flash->success(__('The master operation type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master operation type could not be saved. Please, try again.'));
        }
        $this->set(compact('masterOperationType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Operation Type id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $masterOperationType = $this->MasterOperationTypes->get($id);
        if ($this->MasterOperationTypes->delete($masterOperationType)) {
            $this->Flash->success(__('The master operation type has been deleted.'));
        } else {
            $this->Flash->error(__('The master operation type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
