<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * QueuePolys Controller
 *
 * @property \App\Model\Table\QueuePolysTable $QueuePolys
 * @method \App\Model\Entity\QueuePoly[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QueuePolysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $queuePolys = $this->paginate($this->QueuePolys);

        $this->set(compact('queuePolys'));
    }

    /**
     * View method
     *
     * @param string|null $id Queue Poly id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $queuePoly = $this->QueuePolys->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('queuePoly'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $queuePoly = $this->QueuePolys->newEmptyEntity();
        if ($this->request->is('post')) {
            $queuePoly = $this->QueuePolys->patchEntity($queuePoly, $this->request->getData());
            if ($this->QueuePolys->save($queuePoly)) {
                $this->Flash->success(__('The queue poly has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The queue poly could not be saved. Please, try again.'));
        }
        $this->set(compact('queuePoly'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Queue Poly id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $queuePoly = $this->QueuePolys->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $queuePoly = $this->QueuePolys->patchEntity($queuePoly, $this->request->getData());
            if ($this->QueuePolys->save($queuePoly)) {
                $this->Flash->success(__('The queue poly has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The queue poly could not be saved. Please, try again.'));
        }
        $this->set(compact('queuePoly'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Queue Poly id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $queuePoly = $this->QueuePolys->get($id);
        if ($this->QueuePolys->delete($queuePoly)) {
            $this->Flash->success(__('The queue poly has been deleted.'));
        } else {
            $this->Flash->error(__('The queue poly could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
