<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * HrgaAbsents Controller
 *
 * @property \App\Model\Table\HrgaAbsentsTable $HrgaAbsents
 * @method \App\Model\Entity\HrgaAbsent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HrgaAbsentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees'],
        ];
        $hrgaAbsents = $this->paginate($this->HrgaAbsents);

        $this->set(compact('hrgaAbsents'));
    }

    /**
     * View method
     *
     * @param string|null $id Hrga Absent id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $hrgaAbsent = $this->HrgaAbsents->get($id, contain: ['Employees']);

        $this->set(compact('hrgaAbsent'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $hrgaAbsent = $this->HrgaAbsents->newEmptyEntity();
        if ($this->request->is('post')) {
            $hrgaAbsent = $this->HrgaAbsents->patchEntity($hrgaAbsent, $this->request->getData());
            if ($this->HrgaAbsents->save($hrgaAbsent)) {
                $this->Flash->success(__('The hrga absent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga absent could not be saved. Please, try again.'));
        }
        $employees = $this->HrgaAbsents->Employees->find('list', limit: 200);
        $this->set(compact('hrgaAbsent', 'employees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Hrga Absent id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $hrgaAbsent = $this->HrgaAbsents->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hrgaAbsent = $this->HrgaAbsents->patchEntity($hrgaAbsent, $this->request->getData());
            if ($this->HrgaAbsents->save($hrgaAbsent)) {
                $this->Flash->success(__('The hrga absent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga absent could not be saved. Please, try again.'));
        }
        $employees = $this->HrgaAbsents->Employees->find('list', limit: 200);
        $this->set(compact('hrgaAbsent', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Hrga Absent id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hrgaAbsent = $this->HrgaAbsents->get($id);
        if ($this->HrgaAbsents->delete($hrgaAbsent)) {
            $this->Flash->success(__('The hrga absent has been deleted.'));
        } else {
            $this->Flash->error(__('The hrga absent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
