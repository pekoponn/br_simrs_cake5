<?php
declare(strict_types=1);

namespace App\Controller\Hr;
use App\Controller\AppController;

use Cake\I18n\FrozenTime;

/**
 * AbsentIssues Controller
 *
 * @property \App\Model\Table\AbsentIssuesTable $AbsentIssues
 * @method \App\Model\Entity\AbsentIssue[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AbsentIssuesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AbsentIssues->find()
            ->contain(['Users']);

        $absentIssues = $this->paginate($query);

        $this->set(compact('absentIssues'));
    }

    /**
     * View method
     *
     * @param string|null $id Absent Issue id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $absentIssue = $this->AbsentIssues->get($id, contain: ['Users']);

        $this->set(compact('absentIssue'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $absentIssue = $this->AbsentIssues->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['user_id']; 
            $dataStatus = array('status' => 'W');
            $dataUserId = array('is_create' => $isUser);
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Add"); 
            $dataAuditLog = array('is_log' => $auditLog);
            for ($i = 1; $i <= 2; $i++) {
                $field = "file_$i";
                $file = $dataRow[$field] ?? null;
                if (is_object($file) && method_exists($file, 'getError') && $file->getError() === 0) {
                    $filename = time() . '_' . str_replace(' ', '_', $file->getClientFilename());
                    $targetPath = WWW_ROOT . 'files' . DS . $filename;
                    $file->moveTo($targetPath);
                    $dataRow[$field] = $filename;
                } else {
                    unset($dataRow[$field]);
                }
            }
            $absentIssue = $this->AbsentIssues->patchEntity($absentIssue, array_merge($dataRow, $dataUserId, $dataAuditLog, $dataStatus));
            if ($this->AbsentIssues->save($absentIssue)) {
                $this->Flash->success(__('Terima kasih, data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf Data gagal disimpan, Silakan coba kembali.'));
        }
        $users = $this->AbsentIssues->Users->find('list', ['limit' => 200]);
        $this->set(compact('absentIssue', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Absent Issue id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $absentIssue = $this->AbsentIssues->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $absentIssue = $this->AbsentIssues->patchEntity($absentIssue, $this->request->getData());
            if ($this->AbsentIssues->save($absentIssue)) {
                $this->Flash->success(__('The absent issue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The absent issue could not be saved. Please, try again.'));
        }
        $users = $this->AbsentIssues->Users->find('list', ['limit' => 200]);
        $this->set(compact('absentIssue', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Absent Issue id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $absentIssue = $this->AbsentIssues->get($id);
        if ($this->AbsentIssues->delete($absentIssue)) {
            $this->Flash->success(__('The absent issue has been deleted.'));
        } else {
            $this->Flash->error(__('The absent issue could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getHistory()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);

        $session = $this->getRequest()->getSession();
        $authData = $session->read('Auth');

        // DataTables pagination params
        $draw   = (int)$this->request->getQuery('draw');
        $start  = (int)$this->request->getQuery('start', 0);
        $length = (int)$this->request->getQuery('length', 10);

        // Filter parameters
        $start_date  = $this->request->getQuery('start_date');
        $end_date    = $this->request->getQuery('end_date');
        // Auth user & rules
        $currentUserId = $authData['id']; 
        $rulesString   = $authData['rules'];
        $rules         = $this->Krs->_rule($rulesString);
        $canViewAll    = isset($rules['absentissues']['viewAll']) ? $rules['absentissues']['viewAll'] : 0;

        // Query builder
        $query = $this->AbsentIssues->find()
            ->contain([
                'IsCreateUser' => function ($q) {
                    return $q->select(['id', 'name']); // Ambil ID dan nama pengguna
                },
                'IsDoneUser' => function ($q) {
                    return $q->select(['id', 'name']);
                },
            ]);

        // Filter: nama pengguna
        if (!empty($name)) {
            $query->matching('Users', function ($q) use ($name) {
                return $q->where(['Users.name LIKE' => '%' . $name . '%']);
            });
        }

        // Filter: ekspresi
        // if (!empty($expression)) {
        //     $query->where(['Absences.expression LIKE' => '%' . $expression . '%']);
        // }

        // Filter: inout mode
        // if (!empty($inout_mode)) {
        //     $query->where(['AbsencentIssues.inout_mode' => $inout_mode]);
        // }

        // Filter: rentang tanggal
        if (!empty($start_date) && !empty($end_date)) {
            $query->where(function ($exp) use ($start_date, $end_date) {
                return $exp->between(
                    'AbsentIssues.created',
                    date('Y-m-d', strtotime($start_date)),
                    date('Y-m-d', strtotime($end_date))
                );
            });
        }

        // Filter: akses pengguna (jika tidak boleh lihat semua)
        if ($canViewAll != '1') {
            $query->where(['AbsentIssues.is_create' => $currentUserId]);
        }

        // Hitung total sebelum paginasi
        $recordsTotal = $query->count();

        // Pagination dan urutan data
        $query->limit($length)
            ->offset($start)
            ->order(['AbsentIssues.created' => 'DESC']);

        // Ambil hasil query
        $data = $query->toArray();

        //proses reverse Geocoding
        foreach ($data as $row) {
            // if (!empty($row->latitude) && !empty($row->longitude)) {
            //     $mapsLink = "https://www.google.com/maps?q={$row->latitude},{$row->longitude}";
            //     $row->set('location', $mapsLink);
            // } else {
            //     $row->set('location', '-');
            // }
            if (!empty($row->address)) {
                $row->set('address', $row->address);
                continue;
            }
        }

        $data = array_map(fn($row) => $row->toArray(), $data);
        // JSON response untuk DataTables
        $response = [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data'            => $data ?? []
        ];

        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    public function status()
    {
        $this->request->allowMethod(['post']);
        try {

            $id = $this->request->getData('id');
            $status = $this->request->getData('status');

            if (!$id) {
                throw new \Exception('ID tidak ditemukan');
            }

            $absentIssue = $this->AbsentIssues->get($id);
            // debug($this->Authentication->getIdentity());
            // die;    
            $absentIssue->status = $status;
            $absentIssue->is_done = $this->Authentication->getIdentity()->id;
            $absentIssue->doned = FrozenTime::now();

            if (!$this->AbsentIssues->save($absentIssue)) {
                throw new \Exception('Gagal menyimpan data');
            }

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'status' => true,
                    'message' => 'Berhasil update status'
                ]));

        } catch (\Exception $e) {

            return $this->response
                ->withStatus(500)
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'status' => false,
                    'message' => $e->getMessage()
                ]));
        }
    }
}
