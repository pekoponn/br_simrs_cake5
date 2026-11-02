<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MasterSurgeryOperators Controller
 *
 * @property \App\Model\Table\MasterSurgeryOperatorsTable $MasterSurgeryOperators
 * @method \App\Model\Entity\MasterSurgeryOperator[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterSurgeryOperatorsController extends AppController
{
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
        $masterSurgeryOperators = $this->paginate($this->MasterSurgeryOperators);

        $this->set(compact('masterSurgeryOperators'));
    }

    /**
     * View method
     *
     * @param string|null $id Master Surgery Operator id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterSurgeryOperator = $this->MasterSurgeryOperators->get($id, contain: ['Doctors']);

        $this->set(compact('masterSurgeryOperator'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterSurgeryOperator = $this->MasterSurgeryOperators->newEmptyEntity();
        if ($this->request->is('post')) {
            $masterSurgeryOperator = $this->MasterSurgeryOperators->patchEntity($masterSurgeryOperator, $this->request->getData());
            if ($this->MasterSurgeryOperators->save($masterSurgeryOperator)) {
                $this->Flash->success(__('The master surgery operator has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master surgery operator could not be saved. Please, try again.'));
        }
        $doctors = $this->MasterSurgeryOperators->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('masterSurgeryOperator', 'doctors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Surgery Operator id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterSurgeryOperator = $this->MasterSurgeryOperators->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $masterSurgeryOperator = $this->MasterSurgeryOperators->patchEntity($masterSurgeryOperator, $this->request->getData());
            if ($this->MasterSurgeryOperators->save($masterSurgeryOperator)) {
                $this->Flash->success(__('The master surgery operator has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master surgery operator could not be saved. Please, try again.'));
        }
        $doctors = $this->MasterSurgeryOperators->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('masterSurgeryOperator', 'doctors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Surgery Operator id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $masterSurgeryOperator = $this->MasterSurgeryOperators->get($id);
        if ($this->MasterSurgeryOperators->delete($masterSurgeryOperator)) {
            $this->Flash->success(__('The master surgery operator has been deleted.'));
        } else {
            $this->Flash->error(__('The master surgery operator could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
