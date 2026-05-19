<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Beds Controller
 *
 * @property \App\Model\Table\BedsTable $Beds
 * @method \App\Model\Entity\Bed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BedsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rooms'],
        ];
        $beds = $this->paginate($this->Beds);

        $this->set(compact('beds'));
    }

    /**
     * View method
     *
     * @param string|null $id Bed id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bed = $this->Beds->get($id, [
            'contain' => ['Rooms', 'Registrations'],
        ]);

        $this->set(compact('bed'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bed = $this->Beds->newEmptyEntity();
        if ($this->request->is('post')) {
            $bed = $this->Beds->patchEntity($bed, $this->request->getData());
            if ($this->Beds->save($bed)) {
                $this->Flash->success(__('The bed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bed could not be saved. Please, try again.'));
        }
        $rooms = $this->Beds->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('bed', 'rooms'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bed id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bed = $this->Beds->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bed = $this->Beds->patchEntity($bed, $this->request->getData());
            if ($this->Beds->save($bed)) {
                $this->Flash->success(__('The bed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bed could not be saved. Please, try again.'));
        }
        $rooms = $this->Beds->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('bed', 'rooms'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bed id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bed = $this->Beds->get($id);
        if ($this->Beds->delete($bed)) {
            $this->Flash->success(__('The bed has been deleted.'));
        } else {
            $this->Flash->error(__('The bed could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
