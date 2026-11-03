<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * DaerahProvinsis Controller
 *
 * @property \App\Model\Table\DaerahProvinsisTable $DaerahProvinsis
 * @method \App\Model\Entity\DaerahProvinsi[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DaerahProvinsisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $daerahProvinsis = $this->paginate($this->DaerahProvinsis);

        $this->set(compact('daerahProvinsis'));
    }

    /**
     * View method
     *
     * @param string|null $id Daerah Provinsi id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $daerahProvinsi = $this->DaerahProvinsis->get($id, contain: []);

        $this->set(compact('daerahProvinsi'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $daerahProvinsi = $this->DaerahProvinsis->newEmptyEntity();
        if ($this->request->is('post')) {
            $daerahProvinsi = $this->DaerahProvinsis->patchEntity($daerahProvinsi, $this->request->getData());
            if ($this->DaerahProvinsis->save($daerahProvinsi)) {
                $this->Flash->success(__('The daerah provinsi has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah provinsi could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahProvinsi'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Daerah Provinsi id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $daerahProvinsi = $this->DaerahProvinsis->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $daerahProvinsi = $this->DaerahProvinsis->patchEntity($daerahProvinsi, $this->request->getData());
            if ($this->DaerahProvinsis->save($daerahProvinsi)) {
                $this->Flash->success(__('The daerah provinsi has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The daerah provinsi could not be saved. Please, try again.'));
        }
        $this->set(compact('daerahProvinsi'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Daerah Provinsi id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $daerahProvinsi = $this->DaerahProvinsis->get($id);
        if ($this->DaerahProvinsis->delete($daerahProvinsi)) {
            $this->Flash->success(__('The daerah provinsi has been deleted.'));
        } else {
            $this->Flash->error(__('The daerah provinsi could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
