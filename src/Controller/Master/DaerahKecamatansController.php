<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * DaerahKecamatans Controller
 *
 * @property \App\Model\Table\DaerahKecamatansTable $DaerahKecamatans
 * @method \App\Model\Entity\DaerahKecamatan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DaerahKecamatansController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $daerahKecamatans = $this->paginate($this->DaerahKecamatans);

        $this->set(compact('daerahKecamatans'));
    }

    /**
     * View method
     *
     * @param string|null $id Daerah Kecamatan id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $daerahKecamatan = $this->DaerahKecamatans->get($id, contain: []);

        $this->set(compact('daerahKecamatan'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $daerahKecamatan = $this->DaerahKecamatans->newEmptyEntity();
        if ($this->request->is('post')) {
            $daerahKecamatan = $this->DaerahKecamatans->patchEntity($daerahKecamatan, $this->request->getData());
            if ($this->DaerahKecamatans->save($daerahKecamatan)) {
                $this->Flash->success(__('The daerah kecamatan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah kecamatan could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahKecamatan'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Daerah Kecamatan id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $daerahKecamatan = $this->DaerahKecamatans->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $daerahKecamatan = $this->DaerahKecamatans->patchEntity($daerahKecamatan, $this->request->getData());
            if ($this->DaerahKecamatans->save($daerahKecamatan)) {
                $this->Flash->success(__('The daerah kecamatan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah kecamatan could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahKecamatan'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Daerah Kecamatan id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $daerahKecamatan = $this->DaerahKecamatans->get($id);
        if ($this->DaerahKecamatans->delete($daerahKecamatan)) {
            $this->Flash->success(__('The daerah kecamatan has been deleted.'));
        } else {
            $this->Flash->error(__('The daerah kecamatan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
