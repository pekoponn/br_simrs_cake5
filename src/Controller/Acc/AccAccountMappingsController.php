<?php
declare(strict_types=1);

namespace App\Controller\Acc;

use App\Controller\AppController;
use CakePdf\Pdf\CakePdf;
/**
 * AccAccountMappings Controller
 *
 * @property \App\Model\Table\AccAccountMappingsTable $AccAccountMappings
 * @method \App\Model\Entity\AccAccountMapping[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccAccountMappingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Branches', 'AccChartOfAccounts'],
        ];
        $accAccountMappings = $this->paginate($this->AccAccountMappings);

        $this->set(compact('accAccountMappings'));
    }

    /**
     * View method
     *
     * @param string|null $id Acc Account Mapping id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accAccountMapping = $this->AccAccountMappings->get($id, contain: ['Branches', 'AccChartOfAccounts']);

        $this->set(compact('accAccountMapping'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accAccountMapping = $this->AccAccountMappings->newEmptyEntity();
        if ($this->request->is('post')) {
            $accAccountMapping = $this->AccAccountMappings->patchEntity($accAccountMapping, $this->request->getData());
            if ($this->AccAccountMappings->save($accAccountMapping)) {
                $this->Flash->success(__('The acc account mapping has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc account mapping could not be saved. Please, try again.'));
        }
        $branches = $this->AccAccountMappings->Branches->find('list', ['limit' => 200]);
        $accChartOfAccounts = $this->AccAccountMappings->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('accAccountMapping', 'branches', 'accChartOfAccounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Acc Account Mapping id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accAccountMapping = $this->AccAccountMappings->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accAccountMapping = $this->AccAccountMappings->patchEntity($accAccountMapping, $this->request->getData());
            if ($this->AccAccountMappings->save($accAccountMapping)) {
                $this->Flash->success(__('The acc account mapping has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc account mapping could not be saved. Please, try again.'));
        }
        $branches = $this->AccAccountMappings->Branches->find('list', ['limit' => 200]);
        $accChartOfAccounts = $this->AccAccountMappings->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('accAccountMapping', 'branches', 'accChartOfAccounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Acc Account Mapping id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accAccountMapping = $this->AccAccountMappings->get($id);
        if ($this->AccAccountMappings->delete($accAccountMapping)) {
            $this->Flash->success(__('The acc account mapping has been deleted.'));
        } else {
            $this->Flash->error(__('The acc account mapping could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
