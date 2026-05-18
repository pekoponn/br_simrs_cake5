<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Medicines Controller
 *
 * @property \App\Model\Table\MedicinesTable $Medicines
 * @method \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicinesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['MedicineMerks', 'MedicineGroups'],
        ];
        $medicines = $this->paginate($this->Medicines);

        $this->set(compact('medicines'));
    }

    /**
     * View method
     *
     * @param string|null $id Medicine id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicine = $this->Medicines->get($id, [
            'contain' => ['MedicineMerks', 'MedicineGroups'],
        ]);

        $this->set(compact('medicine'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicine = $this->Medicines->newEmptyEntity();
        if ($this->request->is('post')) {
            $medicine = $this->Medicines->patchEntity($medicine, $this->request->getData());
            if ($this->Medicines->save($medicine)) {
                $this->Flash->success(__('The medicine has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicine could not be saved. Please, try again.'));
        }
        $medicineMerks = $this->Medicines->MedicineMerks->find('list', ['limit' => 200]);
        $medicineGroups = $this->Medicines->MedicineGroups->find('list', ['limit' => 200]);
        $this->set(compact('medicine', 'medicineMerks', 'medicineGroups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medicine id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicine = $this->Medicines->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicine = $this->Medicines->patchEntity($medicine, $this->request->getData());
            if ($this->Medicines->save($medicine)) {
                $this->Flash->success(__('The medicine has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicine could not be saved. Please, try again.'));
        }
        $medicineMerks = $this->Medicines->MedicineMerks->find('list', ['limit' => 200]);
        $medicineGroups = $this->Medicines->MedicineGroups->find('list', ['limit' => 200]);
        $this->set(compact('medicine', 'medicineMerks', 'medicineGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medicine id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicine = $this->Medicines->get($id);
        if ($this->Medicines->delete($medicine)) {
            $this->Flash->success(__('The medicine has been deleted.'));
        } else {
            $this->Flash->error(__('The medicine could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
