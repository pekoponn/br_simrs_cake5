<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MasterMcuTypes Controller
 *
 * @property \App\Model\Table\MasterMcuTypesTable $MasterMcuTypes
 * @method \App\Model\Entity\MasterMcuType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterMcuTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $masterMcuTypes = $this->paginate($this->MasterMcuTypes);

        $this->set(compact('masterMcuTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Master Mcu Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterMcuType = $this->MasterMcuTypes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('masterMcuType'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterMcuType = $this->MasterMcuTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $masterMcuType = $this->MasterMcuTypes->patchEntity($masterMcuType, $this->request->getData());
            if ($this->MasterMcuTypes->save($masterMcuType)) {
                $this->Flash->success(__('The master mcu type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master mcu type could not be saved. Please, try again.'));
        }
        $this->set(compact('masterMcuType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Mcu Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterMcuType = $this->MasterMcuTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $masterMcuType = $this->MasterMcuTypes->patchEntity($masterMcuType, $this->request->getData());
            if ($this->MasterMcuTypes->save($masterMcuType)) {
                $this->Flash->success(__('The master mcu type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master mcu type could not be saved. Please, try again.'));
        }
        $this->set(compact('masterMcuType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Mcu Type id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $masterMcuType = $this->MasterMcuTypes->get($id);
        if ($this->MasterMcuTypes->delete($masterMcuType)) {
            $this->Flash->success(__('The master mcu type has been deleted.'));
        } else {
            $this->Flash->error(__('The master mcu type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
