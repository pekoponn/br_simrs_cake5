<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MedicineMerks Controller
 *
 * @property \App\Model\Table\MedicineMerksTable $MedicineMerks
 * @method \App\Model\Entity\MedicineMerk[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicineMerksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Branches'],
        ];
        $medicineMerks = $this->paginate($this->MedicineMerks);

        $this->set(compact('medicineMerks'));
    }

    /**
     * View method
     *
     * @param string|null $id Medicine Merk id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicineMerk = $this->MedicineMerks->get($id, contain: ['Branches', 'Medicines']);

        $this->set(compact('medicineMerk'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicineMerk = $this->MedicineMerks->newEmptyEntity();
        if ($this->request->is('post')) {
            $medicineMerk = $this->MedicineMerks->patchEntity($medicineMerk, $this->request->getData());
            if ($this->MedicineMerks->save($medicineMerk)) {
                $this->Flash->success(__('The medicine merk has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicine merk could not be saved. Please, try again.'));
        }
        $branches = $this->MedicineMerks->Branches->find('list', ['limit' => 200]);
        $this->set(compact('medicineMerk', 'branches'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medicine Merk id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicineMerk = $this->MedicineMerks->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicineMerk = $this->MedicineMerks->patchEntity($medicineMerk, $this->request->getData());
            if ($this->MedicineMerks->save($medicineMerk)) {
                $this->Flash->success(__('The medicine merk has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicine merk could not be saved. Please, try again.'));
        }
        $branches = $this->MedicineMerks->Branches->find('list', ['limit' => 200]);
        $this->set(compact('medicineMerk', 'branches'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medicine Merk id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicineMerk = $this->MedicineMerks->get($id);
        if ($this->MedicineMerks->delete($medicineMerk)) {
            $this->Flash->success(__('The medicine merk has been deleted.'));
        } else {
            $this->Flash->error(__('The medicine merk could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
