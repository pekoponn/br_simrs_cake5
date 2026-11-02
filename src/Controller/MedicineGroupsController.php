<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MedicineGroups Controller
 *
 * @property \App\Model\Table\MedicineGroupsTable $MedicineGroups
 * @method \App\Model\Entity\MedicineGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MedicineGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [],
        ];
        $medicineGroups = $this->paginate($this->MedicineGroups);

        $this->set(compact('medicineGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Medicine Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicineGroup = $this->MedicineGroups->get($id, contain: ['Medicines']);

        $this->set(compact('medicineGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicineGroup = $this->MedicineGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $medicineGroup = $this->MedicineGroups->patchEntity($medicineGroup, $this->request->getData());
            if ($this->MedicineGroups->save($medicineGroup)) {
                $this->Flash->success(__('The medicine group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicine group could not be saved. Please, try again.'));
        }
        $this->set(compact('medicineGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Medicine Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicineGroup = $this->MedicineGroups->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicineGroup = $this->MedicineGroups->patchEntity($medicineGroup, $this->request->getData());
            if ($this->MedicineGroups->save($medicineGroup)) {
                $this->Flash->success(__('The medicine group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The medicine group could not be saved. Please, try again.'));
        }
        $this->set(compact('medicineGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Medicine Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicineGroup = $this->MedicineGroups->get($id);
        if ($this->MedicineGroups->delete($medicineGroup)) {
            $this->Flash->success(__('The medicine group has been deleted.'));
        } else {
            $this->Flash->error(__('The medicine group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
