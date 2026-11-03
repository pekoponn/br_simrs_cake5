<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * Insurances Controller
 *
 * @property \App\Model\Table\InsurancesTable $Insurances
 * @method \App\Model\Entity\Insurance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InsurancesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $insurances = $this->paginate($this->Insurances);

        $this->set(compact('insurances'));
    }

    /**
     * View method
     *
     * @param string|null $id Insurance id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $insurance = $this->Insurances->get($id, contain: []);

        $this->set(compact('insurance'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $insurance = $this->Insurances->newEmptyEntity();
        if ($this->request->is('post')) {
            $insurance = $this->Insurances->patchEntity($insurance, $this->request->getData());
            if ($this->Insurances->save($insurance)) {
                $this->Flash->success(__('The insurance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The insurance could not be saved. Please, try again.'));
        }
        $this->set(compact('insurance'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Insurance id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $insurance = $this->Insurances->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $insurance = $this->Insurances->patchEntity($insurance, $this->request->getData());
            if ($this->Insurances->save($insurance)) {
                $this->Flash->success(__('The insurance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The insurance could not be saved. Please, try again.'));
        }
        $this->set(compact('insurance'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Insurance id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $insurance = $this->Insurances->get($id);
        if ($this->Insurances->delete($insurance)) {
            $this->Flash->success(__('The insurance has been deleted.'));
        } else {
            $this->Flash->error(__('The insurance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
