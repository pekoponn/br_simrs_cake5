<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DaerahKelurahans Controller
 *
 * @property \App\Model\Table\DaerahKelurahansTable $DaerahKelurahans
 * @method \App\Model\Entity\DaerahKelurahan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DaerahKelurahansController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $daerahKelurahans = $this->paginate($this->DaerahKelurahans);

        $this->set(compact('daerahKelurahans'));
    }

    /**
     * View method
     *
     * @param string|null $id Daerah Kelurahan id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $daerahKelurahan = $this->DaerahKelurahans->get($id, contain: []);

        $this->set(compact('daerahKelurahan'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $daerahKelurahan = $this->DaerahKelurahans->newEmptyEntity();
        if ($this->request->is('post')) {
            $daerahKelurahan = $this->DaerahKelurahans->patchEntity($daerahKelurahan, $this->request->getData());
            if ($this->DaerahKelurahans->save($daerahKelurahan)) {
                $this->Flash->success(__('The daerah kelurahan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah kelurahan could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahKelurahan'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Daerah Kelurahan id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $daerahKelurahan = $this->DaerahKelurahans->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $daerahKelurahan = $this->DaerahKelurahans->patchEntity($daerahKelurahan, $this->request->getData());
            if ($this->DaerahKelurahans->save($daerahKelurahan)) {
                $this->Flash->success(__('The daerah kelurahan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah kelurahan could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahKelurahan'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Daerah Kelurahan id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $daerahKelurahan = $this->DaerahKelurahans->get($id);
        if ($this->DaerahKelurahans->delete($daerahKelurahan)) {
            $this->Flash->success(__('The daerah kelurahan has been deleted.'));
        } else {
            $this->Flash->error(__('The daerah kelurahan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
