<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * DaerahJenis Controller
 *
 * @property \App\Model\Table\DaerahJenisTable $DaerahJenis
 * @method \App\Model\Entity\DaerahJeni[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DaerahJenisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $daerahJenis = $this->paginate($this->DaerahJenis);

        $this->set(compact('daerahJenis'));
    }

    /**
     * View method
     *
     * @param string|null $id Daerah Jeni id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $daerahJeni = $this->DaerahJenis->get($id, contain: []);

        $this->set(compact('daerahJeni'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $daerahJeni = $this->DaerahJenis->newEmptyEntity();
        if ($this->request->is('post')) {
            $daerahJeni = $this->DaerahJenis->patchEntity($daerahJeni, $this->request->getData());
            if ($this->DaerahJenis->save($daerahJeni)) {
                $this->Flash->success(__('The daerah jeni has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah jeni could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahJeni'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Daerah Jeni id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $daerahJeni = $this->DaerahJenis->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $daerahJeni = $this->DaerahJenis->patchEntity($daerahJeni, $this->request->getData());
            if ($this->DaerahJenis->save($daerahJeni)) {
                $this->Flash->success(__('The daerah jeni has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah jeni could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahJeni'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Daerah Jeni id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $daerahJeni = $this->DaerahJenis->get($id);
        if ($this->DaerahJenis->delete($daerahJeni)) {
            $this->Flash->success(__('The daerah jeni has been deleted.'));
        } else {
            $this->Flash->error(__('The daerah jeni could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
