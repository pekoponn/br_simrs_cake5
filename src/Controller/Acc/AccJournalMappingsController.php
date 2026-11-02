<?php
declare(strict_types=1);

namespace App\Controller\Acc;

use App\Controller\AppController;
use CakePdf\Pdf\CakePdf;

/**
 * AccJournalMappings Controller
 *
 * @property \App\Model\Table\AccJournalMappingsTable $AccJournalMappings
 * @method \App\Model\Entity\AccJournalMapping[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccJournalMappingsController extends AppController
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
        $accJournalMappings = $this->paginate($this->AccJournalMappings);

        $this->set(compact('accJournalMappings'));
    }

    /**
     * View method
     *
     * @param string|null $id Acc Journal Mapping id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accJournalMapping = $this->AccJournalMappings->get($id, contain: ['Branches', 'AccChartOfAccounts']);

        $this->set(compact('accJournalMapping'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accJournalMapping = $this->AccJournalMappings->newEmptyEntity();
        if ($this->request->is('post')) {
            $accJournalMapping = $this->AccJournalMappings->patchEntity($accJournalMapping, $this->request->getData());
            if ($this->AccJournalMappings->save($accJournalMapping)) {
                $this->Flash->success(__('The acc journal mapping has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc journal mapping could not be saved. Please, try again.'));
        }
        $branches = $this->AccJournalMappings->Branches->find('list', ['limit' => 200]);
        $accChartOfAccounts = $this->AccJournalMappings->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('accJournalMapping', 'branches', 'accChartOfAccounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Acc Journal Mapping id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accJournalMapping = $this->AccJournalMappings->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accJournalMapping = $this->AccJournalMappings->patchEntity($accJournalMapping, $this->request->getData());
            if ($this->AccJournalMappings->save($accJournalMapping)) {
                $this->Flash->success(__('The acc journal mapping has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The acc journal mapping could not be saved. Please, try again.'));
        }
        $branches = $this->AccJournalMappings->Branches->find('list', ['limit' => 200]);
        $accChartOfAccounts = $this->AccJournalMappings->AccChartOfAccounts->find('list', ['limit' => 200]);
        $this->set(compact('accJournalMapping', 'branches', 'accChartOfAccounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Acc Journal Mapping id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accJournalMapping = $this->AccJournalMappings->get($id);
        if ($this->AccJournalMappings->delete($accJournalMapping)) {
            $this->Flash->success(__('The acc journal mapping has been deleted.'));
        } else {
            $this->Flash->error(__('The acc journal mapping could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
