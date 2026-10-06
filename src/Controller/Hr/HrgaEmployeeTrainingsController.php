<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * HrgaEmployeeTrainings Controller
 *
 * @property \App\Model\Table\HrgaEmployeeTrainingsTable $HrgaEmployeeTrainings
 * @method \App\Model\Entity\HrgaEmployeeTraining[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HrgaEmployeeTrainingsController extends AppController
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
        $hrgaEmployeeTrainings = $this->paginate($this->HrgaEmployeeTrainings);

        $this->set(compact('hrgaEmployeeTrainings'));
    }

    /**
     * View method
     *
     * @param string|null $id Hrga Employee Training id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $hrgaEmployeeTraining = $this->HrgaEmployeeTrainings->get($id, [
            'contain' => ['HrgaEmployees'],
        ]);

        $this->set(compact('hrgaEmployeeTraining'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $hrgaEmployeeTraining = $this->HrgaEmployeeTrainings->newEmptyEntity();
        if ($this->request->is('post')) {
            $hrgaEmployeeTraining = $this->HrgaEmployeeTrainings->patchEntity($hrgaEmployeeTraining, $this->request->getData());
            if ($this->HrgaEmployeeTrainings->save($hrgaEmployeeTraining)) {
                $this->Flash->success(__('The hrga employee training has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga employee training could not be saved. Please, try again.'));
        }
        $hrgaEmployees = $this->HrgaEmployeeTrainings->HrgaEmployees->find('list', ['limit' => 200]);
        $this->set(compact('hrgaEmployeeTraining', 'hrgaEmployees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Hrga Employee Training id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $hrgaEmployeeTraining = $this->HrgaEmployeeTrainings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hrgaEmployeeTraining = $this->HrgaEmployeeTrainings->patchEntity($hrgaEmployeeTraining, $this->request->getData());
            if ($this->HrgaEmployeeTrainings->save($hrgaEmployeeTraining)) {
                $this->Flash->success(__('The hrga employee training has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga employee training could not be saved. Please, try again.'));
        }
        $hrgaEmployees = $this->HrgaEmployeeTrainings->HrgaEmployees->find('list', ['limit' => 200]);
        $this->set(compact('hrgaEmployeeTraining', 'hrgaEmployees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Hrga Employee Training id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hrgaEmployeeTraining = $this->HrgaEmployeeTrainings->get($id);
        if ($this->HrgaEmployeeTrainings->delete($hrgaEmployeeTraining)) {
            $this->Flash->success(__('The hrga employee training has been deleted.'));
        } else {
            $this->Flash->error(__('The hrga employee training could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
