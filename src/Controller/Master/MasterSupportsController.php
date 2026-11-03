<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * MasterSupports Controller
 *
 * @property \App\Model\Table\MasterSupportsTable $MasterSupports
 * @method \App\Model\Entity\MasterSupport[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterSupportsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $masterSupports = $this->paginate($this->MasterSupports);

        $this->set(compact('masterSupports'));
    }

    /**
     * View method
     *
     * @param string|null $id Master Support id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterSupport = $this->MasterSupports->get($id, contain: []);

        $this->set(compact('masterSupport'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterSupport = $this->MasterSupports->newEmptyEntity();
        if ($this->request->is('post')) {
            $masterSupport = $this->MasterSupports->patchEntity($masterSupport, $this->request->getData());
            if ($this->MasterSupports->save($masterSupport)) {
                $this->Flash->success(__('The master support has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master support could not be saved. Please, try again.'));
        }
        $this->set(compact('masterSupport'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Support id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterSupport = $this->MasterSupports->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $masterSupport = $this->MasterSupports->patchEntity($masterSupport, $this->request->getData());
            if ($this->MasterSupports->save($masterSupport)) {
                $this->Flash->success(__('The master support has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master support could not be saved. Please, try again.'));
        }
        $this->set(compact('masterSupport'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Support id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $masterSupport = $this->MasterSupports->get($id);
        if ($this->MasterSupports->delete($masterSupport)) {
            $this->Flash->success(__('The master support has been deleted.'));
        } else {
            $this->Flash->error(__('The master support could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
