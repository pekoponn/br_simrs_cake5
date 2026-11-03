<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * HealthFacilities Controller
 *
 * @property \App\Model\Table\HealthFacilitiesTable $HealthFacilities
 * @method \App\Model\Entity\HealthFacility[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HealthFacilitiesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->HealthFacilities = $this->fetchTable('HealthFacilities');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $healthFacilities = $this->paginate($this->HealthFacilities);

        $this->set(compact('healthFacilities'));
    }

    /**
     * View method
     *
     * @param string|null $id Health Facility id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $healthFacility = $this->HealthFacilities->get($id, contain: []);

        $this->set(compact('healthFacility'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $healthFacility = $this->HealthFacilities->newEmptyEntity();
        if ($this->request->is('post')) {
            $healthFacility = $this->HealthFacilities->patchEntity($healthFacility, $this->request->getData());
            if ($this->HealthFacilities->save($healthFacility)) {
                $this->Flash->success(__('The health facility has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The health facility could not be saved. Please, try again.'));
        }
        $this->set(compact('healthFacility'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Health Facility id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $healthFacility = $this->HealthFacilities->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $healthFacility = $this->HealthFacilities->patchEntity($healthFacility, $this->request->getData());
            if ($this->HealthFacilities->save($healthFacility)) {
                $this->Flash->success(__('The health facility has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The health facility could not be saved. Please, try again.'));
        }
        $this->set(compact('healthFacility'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Health Facility id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $healthFacility = $this->HealthFacilities->get($id);
        if ($this->HealthFacilities->delete($healthFacility)) {
            $this->Flash->success(__('The health facility has been deleted.'));
        } else {
            $this->Flash->error(__('The health facility could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
