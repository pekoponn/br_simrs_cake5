<?php
declare(strict_types=1);

namespace App\Controller\Registrasi;

use App\Controller\AppController;

/**
 * Polyclinics Controller
 *
 * @property \App\Model\Table\PolyclinicsTable $Polyclinics
 * @method \App\Model\Entity\Polyclinic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PolyclinicsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $polyclinics = $this->paginate($this->Polyclinics);

        $this->set(compact('polyclinics'));
    }

    /**
     * View method
     *
     * @param string|null $id Polyclinic id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $polyclinic = $this->Polyclinics->get($id, contain: ['Doctors']);

        $this->set(compact('polyclinic'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $polyclinic = $this->Polyclinics->newEmptyEntity();
        if ($this->request->is('post')) {
            $polyclinic = $this->Polyclinics->patchEntity($polyclinic, $this->request->getData());
            if ($this->Polyclinics->save($polyclinic)) {
                $this->Flash->success(__('The polyclinic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The polyclinic could not be saved. Please, try again.'));
        }
        $this->set(compact('polyclinic'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Polyclinic id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $polyclinic = $this->Polyclinics->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $polyclinic = $this->Polyclinics->patchEntity($polyclinic, $this->request->getData());
            if ($this->Polyclinics->save($polyclinic)) {
                $this->Flash->success(__('The polyclinic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The polyclinic could not be saved. Please, try again.'));
        }
        $this->set(compact('polyclinic'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Polyclinic id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $polyclinic = $this->Polyclinics->get($id);
        if ($this->Polyclinics->delete($polyclinic)) {
            $this->Flash->success(__('The polyclinic has been deleted.'));
        } else {
            $this->Flash->error(__('The polyclinic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
