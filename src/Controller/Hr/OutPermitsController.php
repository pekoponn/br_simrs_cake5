<?php
declare(strict_types=1);

namespace App\Controller\Hr;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;

/**
 * OutPermits Controller
 *
 * @property \App\Model\Table\OutPermitsTable $OutPermits
 * @method \App\Model\Entity\OutPermit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutPermitsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->OutPermits = $this->fetchTable('OutPermits');
        $this->Users = $this->fetchTable('Users');
        $this->loadComponent('Telegram');
      
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Branches'],
        ];
        $outPermits = $this->paginate($this->OutPermits);

        $this->set(compact('outPermits'));
    }

    /**
     * View method
     *
     * @param string|null $id Out Permit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outPermit = $this->OutPermits->get($id, [
            'contain' => ['Branches'],
        ]);

        $this->set(compact('outPermit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $outPermit = $this->OutPermits->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog("OutPermits", 'N',  $isUser, "OutPermits add");
            $dataAuditLog = array('is_log' => $auditLog);
            $dataDate = array('date' => $this->Krs->dateTo($dataRow['date']));
            $dataTimeFrom = array('time_from' => $dataRow['time_from']);
            $dataTimeEnd = array('time_end' => $dataRow['time_end']);
            $fieldName = 'files';
            $file = $this->request->getData($fieldName);
            $fileData = [];
            if (is_object($file) && method_exists($file, 'getError') && $file->getError() === 0) {
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientFilename());
                $targetPath = WWW_ROOT . 'files' . DS . $filename;
                $file->moveTo($targetPath);
                $fileData[$fieldName] = $filename;
            }
            unset($dataRow['files']);
            $outPermit = $this->OutPermits->patchEntity($outPermit, array_merge($dataRow, $dataDate, $dataTimeFrom, $dataTimeEnd, $fileData, $dataAuditLog));
            // debug($outPermit); die;
            if ($this->OutPermits->save($outPermit)) {
                $pemohon = $this->Users->get($isUser);
                $atasan = $this->Users->find()
                    ->where([
                        "FIND_IN_SET($isUser, user_team)"
                    ])
                    ->first();
                if ($atasan && !empty($atasan->telegram_chat_id)) {
                    $url = 'https://rssby.brgroup.id/hr/out-permits';
                    $pesan =
                        "📢 IJIN KELUAR SEMENTARA\n\n" .
                        "👤 Pemohon : {$pemohon->name}\n" .
                        "📅 Tanggal : {$dataRow['date']} \n" .
                        "🕒 Jam : {$dataRow['time_from']} s/d {$dataRow['time_end']}\n\n" .
                        "Silakan melakukan approval/mengetahui melalui link berikut:\n" .
                        $url;
                    $this->Telegram->sendMessage($atasan->telegram_chat_id, $pesan);
                    $this->Telegram->notifyKnowing('out_permits', $pesan);
                }
                $this->Flash->success(__('Terima kasih, Data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf data gagal disimpan, silakan masukkan data dengan benar!.'));
        }
        $branches = $this->OutPermits->Branches->find('list', ['limit' => 200]);
        $this->set(compact('outPermit', 'branches'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Out Permit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outPermit = $this->OutPermits->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outPermit = $this->OutPermits->patchEntity($outPermit, $this->request->getData());
            if ($this->OutPermits->save($outPermit)) {
                $this->Flash->success(__('Terima kasih, Data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf data gagal disimpan, silakan masukkan data dengan benar!.'));
        }
        $branches = $this->OutPermits->Branches->find('list', ['limit' => 200]);
        $this->set(compact('outPermit', 'branches'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Out Permit id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outPermit = $this->OutPermits->get($id);
        if ($this->OutPermits->delete($outPermit)) {
            $this->Flash->success(__('The out permit has been deleted.'));
        } else {
            $this->Flash->error(__('The out permit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getHistory()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);
        $draw   = $this->request->getQuery('draw');
        $start  = (int)$this->request->getQuery('start', 0);
        $length = (int)$this->request->getQuery('length', 10);
        // Filters 
        $name       = $this->request->getQuery('name'); 
        $start_date = $this->request->getQuery('start_date');
        $end_date   = $this->request->getQuery('end_date');
        // identitas user dan cek hak lihat semua (approve2) — disingkat
        $user = $this->request->getAttribute('identity');
        // $canViewAll = false;
        // if (!empty($user)) {
        //     $rulesString = is_array($user) ? ($user['rules'] ?? null) : ($user->rules ?? null);
        //     $rules = !empty($rulesString) ? $this->Krs->_rule($rulesString) : [];

        //     $ruleFlag = (
        //         (!empty($rules['assignments']['viewAll']) && (int)$rules['assignments']['viewAll'] === 1) 
        //         // || (!empty($rules['ithelpdesks']['approve']) && (int)$rules['ithelpdesks']['approve'] === 1)
        //     );

        //     // $userApprove2 = is_array($user) ? ($user['approve2'] ?? 0) : ($user->approve2 ?? 0);

        //     // $imApprove2 = 0;
        //     // if (is_array($user) && isset($user['ithelpdesks'])) {
        //     //     $imApprove2 = is_array($user['ithelpdesks']) ? ($user['ithelpdesks']['approve'] ?? 0) : 0;
        //     // } elseif (is_object($user) && isset($user->ithelpdesks)) {
        //     //     $im = $user->ithelpdesks;
        //     //     $imApprove2 = is_array($im) ? ($im['approve'] ?? 0) : ($im->approve ?? 0);
        //     // }

        //     // $canViewAll = $ruleFlag || ((int)$userApprove2 === 1) || ((int)$imApprove2 === 1);
        // }
 
        $query = $this->OutPermits->find()
        ->contain([
            'IsKnowingUser' => function ($q) {
                return $q->select(['id', 'name']);
            },
            'IsApproveUser' => function ($q) {
                return $q->select(['id', 'name']);
            },
            'IsCreateUser' => function ($q) {
                return $q->select(['id', 'name']);
            },
            // 'IsCancelUser' => function ($q) {
            //     return $q->select(['id', 'name']);
            // },
        ])
        ->where(['OutPermits.is_active' => 'Y']);

        // if (!$canViewAll && !empty($user->id)) {
        //     $query->where(['OutPermits.is_create' => $user->id]);
        // }
        if (!empty($name)) {
            $query->matching('IsCreateUser', function ($q) use ($name) {
                return $q->where(['IsCreateUser.name LIKE' => '%' . $name . '%']);
            });
        }
        if (!empty($start_date) && !empty($end_date)) {
            $query->where(function ($exp) use ($start_date, $end_date) {
                return $exp->between(
                    'OutPermits.date',
                    date('Y-m-d', strtotime($start_date)),
                    date('Y-m-d', strtotime($end_date))
                );
            });
        }
        $recordsTotal = $query->count();
        $query
            ->order([
                'OutPermits.created' => 'DESC',
            ])
            ->limit($length)
            ->offset($start);
        $data = $query->toArray();
        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $data ?? []
        ];
        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
        return $this->response;
    }

    public function approve($id = null)
    {
        if ($this->request->is('get')) {

            $id = $id ?? $this->request->getQuery('id');
            if (!$id) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => false,
                        'message' => 'Missing id'
                    ]));
            }
            try {
                $assignment = $this->OutPermits->get($id);
            } catch (\Exception $e) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => false,
                        'message' => 'Record not found'
                    ]));
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'status' => true,
                    'data' => $assignment
                ]));
        }
        if ($this->request->is(['post', 'patch', 'put'])) {

             $data = $this->request->getData();

            $assignment = $this->OutPermits->get($data['id']);
            $assignment->is_approve = $data['is_approve'];
            $assignment->approved = FrozenTime::now();
            $assignment->approved_description = $data['approved_description'];
            $assignment->status_approve = $data['status_approve'];
            // debug($assignment); die;
            if ($this->OutPermits->save($assignment)) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => true
                    ]));
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'status' => false,
                    'errors' => $assignment->getErrors()
                ]));
        }
        if ($id) {
            try {
                $assignment = $this->OutPermits->get($id);
            } catch (\Exception $e) {
                $assignment = null;
            }
            $this->set(compact('assignment'));
        }
    }

    public function knowing($id = null)
    {
        if ($this->request->is('get')) {

            $id = $id ?? $this->request->getQuery('id');
            if (!$id) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => false,
                        'message' => 'Missing id'
                    ]));
            }
            try {
                $assignment = $this->OutPermits->get($id);
            } catch (\Exception $e) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => false,
                        'message' => 'Record not found'
                    ]));
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'status' => true,
                    'data' => $assignment
                ]));
        }
        if ($this->request->is(['post', 'patch', 'put'])) {

             $data = $this->request->getData();

            $assignment = $this->OutPermits->get($data['id']);
            $assignment->is_knowing = $data['is_knowing'];
            $assignment->knowing = FrozenTime::now();
            $assignment->knowing_description = $data['knowing_description'];
            $assignment->status_knowing = $data['status_knowing'];
            // debug($assignment); die;
            if ($this->OutPermits->save($assignment)) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => true
                    ]));
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'status' => false,
                    'errors' => $assignment->getErrors()
                ]));
        }
        if ($id) {
            try {
                $assignment = $this->OutPermits->get($id);
            } catch (\Exception $e) {
                $assignment = null;
            }
            $this->set(compact('assignment'));
        }
    }
}
