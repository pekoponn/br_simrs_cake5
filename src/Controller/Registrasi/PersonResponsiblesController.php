<?php
declare(strict_types=1);

namespace App\Controller\Registrasi;

use App\Controller\AppController;

/**
 * PersonResponsibles Controller
 *
 * @property \App\Model\Table\PersonResponsiblesTable $PersonResponsibles
 * @method \App\Model\Entity\PersonResponsible[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PersonResponsiblesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->PersonResponsibles = $this->fetchTable('PersonResponsibles');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $personResponsibles = $this->paginate($this->PersonResponsibles);

        $this->set(compact('personResponsibles'));
    }

    /**
     * View method
     *
     * @param string|null $id Person Responsible id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $personResponsible = $this->PersonResponsibles->get($id, contain: ['Registrations']);

        $this->set(compact('personResponsible'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $personResponsible = $this->PersonResponsibles->newEmptyEntity();
        if ($this->request->is('post')) {
            $personResponsible = $this->PersonResponsibles->patchEntity($personResponsible, $this->request->getData());
            if ($this->PersonResponsibles->save($personResponsible)) {
                $this->Flash->success(__('The person responsible has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The person responsible could not be saved. Please, try again.'));
        }
        $this->set(compact('personResponsible'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Person Responsible id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $personResponsible = $this->PersonResponsibles->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $personResponsible = $this->PersonResponsibles->patchEntity($personResponsible, $this->request->getData());
            if ($this->PersonResponsibles->save($personResponsible)) {
                $this->Flash->success(__('The person responsible has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The person responsible could not be saved. Please, try again.'));
        }
        $this->set(compact('personResponsible'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Person Responsible id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $personResponsible = $this->PersonResponsibles->get($id);
        if ($this->PersonResponsibles->delete($personResponsible)) {
            $this->Flash->success(__('The person responsible has been deleted.'));
        } else {
            $this->Flash->error(__('The person responsible could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
