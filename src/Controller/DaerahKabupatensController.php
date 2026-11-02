<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DaerahKabupatens Controller
 *
 * @property \App\Model\Table\DaerahKabupatensTable $DaerahKabupatens
 * @method \App\Model\Entity\DaerahKabupaten[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DaerahKabupatensController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $daerahKabupatens = $this->paginate($this->DaerahKabupatens);

        $this->set(compact('daerahKabupatens'));
    }

    /**
     * View method
     *
     * @param string|null $id Daerah Kabupaten id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $daerahKabupaten = $this->DaerahKabupatens->get($id, contain: []);

        $this->set(compact('daerahKabupaten'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $daerahKabupaten = $this->DaerahKabupatens->newEmptyEntity();
        if ($this->request->is('post')) {
            $daerahKabupaten = $this->DaerahKabupatens->patchEntity($daerahKabupaten, $this->request->getData());
            if ($this->DaerahKabupatens->save($daerahKabupaten)) {
                $this->Flash->success(__('The daerah kabupaten has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah kabupaten could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahKabupaten'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Daerah Kabupaten id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $daerahKabupaten = $this->DaerahKabupatens->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $daerahKabupaten = $this->DaerahKabupatens->patchEntity($daerahKabupaten, $this->request->getData());
            if ($this->DaerahKabupatens->save($daerahKabupaten)) {
                $this->Flash->success(__('The daerah kabupaten has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah kabupaten could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahKabupaten'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Daerah Kabupaten id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $daerahKabupaten = $this->DaerahKabupatens->get($id);
        if ($this->DaerahKabupatens->delete($daerahKabupaten)) {
            $this->Flash->success(__('The daerah kabupaten has been deleted.'));
        } else {
            $this->Flash->error(__('The daerah kabupaten could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
