<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * PharmacyItems Controller
 *
 * @property \App\Model\Table\PharmacyItemsTable $PharmacyItems
 * @method \App\Model\Entity\PharmacyItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PharmacyItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $pharmacyItems = $this->paginate($this->PharmacyItems);

        $this->set(compact('pharmacyItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Pharmacy Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pharmacyItem = $this->PharmacyItems->get($id, contain: []);

        $this->set(compact('pharmacyItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pharmacyItem = $this->PharmacyItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $pharmacyItem = $this->PharmacyItems->patchEntity($pharmacyItem, $this->request->getData());
            if ($this->PharmacyItems->save($pharmacyItem)) {
                $this->Flash->success(__('The pharmacy item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pharmacy item could not be saved. Please, try again.'));
        }
        $this->set(compact('pharmacyItem'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pharmacy Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pharmacyItem = $this->PharmacyItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pharmacyItem = $this->PharmacyItems->patchEntity($pharmacyItem, $this->request->getData());
            if ($this->PharmacyItems->save($pharmacyItem)) {
                $this->Flash->success(__('The pharmacy item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pharmacy item could not be saved. Please, try again.'));
        }
        $this->set(compact('pharmacyItem'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pharmacy Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pharmacyItem = $this->PharmacyItems->get($id);
        if ($this->PharmacyItems->delete($pharmacyItem)) {
            $this->Flash->success(__('The pharmacy item has been deleted.'));
        } else {
            $this->Flash->error(__('The pharmacy item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
