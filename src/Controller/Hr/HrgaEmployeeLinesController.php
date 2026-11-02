<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * HrgaEmployeeLines Controller
 *
 * @property \App\Model\Table\HrgaEmployeeLinesTable $HrgaEmployeeLines
 * @method \App\Model\Entity\HrgaEmployeeLine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HrgaEmployeeLinesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['HrgaEmployees'],
        ];
        $hrgaEmployeeLines = $this->paginate($this->HrgaEmployeeLines);

        $this->set(compact('hrgaEmployeeLines'));
    }

    /**
     * View method
     *
     * @param string|null $id Hrga Employee Line id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $hrgaEmployeeLine = $this->HrgaEmployeeLines->get($id, contain: ['HrgaEmployees']);

        $this->set(compact('hrgaEmployeeLine'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $hrgaEmployeeLine = $this->HrgaEmployeeLines->newEmptyEntity();
        if ($this->request->is('post')) {
            $hrgaEmployeeLine = $this->HrgaEmployeeLines->patchEntity($hrgaEmployeeLine, $this->request->getData());
            if ($this->HrgaEmployeeLines->save($hrgaEmployeeLine)) {
                $this->Flash->success(__('The hrga employee line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga employee line could not be saved. Please, try again.'));
        }
        $hrgaEmployees = $this->HrgaEmployeeLines->HrgaEmployees->find('list', ['limit' => 200]);
        $this->set(compact('hrgaEmployeeLine', 'hrgaEmployees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Hrga Employee Line id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $hrgaEmployeeLine = $this->HrgaEmployeeLines->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hrgaEmployeeLine = $this->HrgaEmployeeLines->patchEntity($hrgaEmployeeLine, $this->request->getData());
            if ($this->HrgaEmployeeLines->save($hrgaEmployeeLine)) {
                $this->Flash->success(__('The hrga employee line has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga employee line could not be saved. Please, try again.'));
        }
        $hrgaEmployees = $this->HrgaEmployeeLines->HrgaEmployees->find('list', ['limit' => 200]);
        $this->set(compact('hrgaEmployeeLine', 'hrgaEmployees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Hrga Employee Line id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hrgaEmployeeLine = $this->HrgaEmployeeLines->get($id);
        if ($this->HrgaEmployeeLines->delete($hrgaEmployeeLine)) {
            $this->Flash->success(__('The hrga employee line has been deleted.'));
        } else {
            $this->Flash->error(__('The hrga employee line could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
