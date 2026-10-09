<?php

declare(strict_types=1);

namespace App\Controller\Hr;

use App\Controller\AppController;
use Cake\Chronos\Date;
use Cake\Chronos\Chronos;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;

/**
 * Overtimes Controller
 *
 * @property \App\Model\Table\OvertimesTable $Overtimes
 * @method \App\Model\Entity\Overtime[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OvertimesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users');
        // $this->loadComponent('Telegram');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession();
        $dataSession = $session->read('Auth');

        // pr($dataSession);

        $dataId = $dataSession['id'];
        $dataDevision = $dataSession->devision;
        $dataPettyCashDevision = $dataSession->pettycash_devision;
        $dataUserTeam = $dataSession['user_team'] ?? '';
        
        $data['HRISApproved'] = $dataSession->hris_approved;
        $data['HRISKnowing'] = $dataSession->hris_knowing;
        $data['HRISFullAccess'] = $dataSession->hris_full_access;
        $data['UBSFullAccess'] = $dataSession->project_status;
        
        if($data['HRISKnowing']=='Y' || $data['HRISFullAccess']=='Y') {
            $arrayDevision = array();
        } elseif($data['HRISApproved']=='Y') {
            $dataDevisions = explode(",", $dataDevision);
            $arrayDevision = array('Overtimes.devision'=>$dataDevisions); 
        } else {
            $arrayDevision = array('Overtimes.applicant'=>$dataId);           
        }

        $filterDateFrom = $this->request->getQuery('filterDateFrom');
        $filterDateEnd = $this->request->getQuery('filterDateEnd');
        $filterApplicant = $this->request->getQuery('filterApplicant');
        $filterDevision = $this->request->getQuery('filterDevision');
        
        $data['filterDateFrom'] = array();
        $data['filterDateEnd'] = array();
        $data['filterApplicant'] = array();
        $data['filterDevision'] = array();        

        $dataWhere = array();
        if (!empty($filterDateFrom) && !empty($filterDateEnd)) {
            $data['filterDateFrom'] = $filterDateFrom;
            $data['filterDateEnd'] = $filterDateEnd;
            $dataWhere[] = 'DATE(Overtimes.date) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '"';
        }

        if (!empty($filterApplicant)) {
            $data['filterApplicant'] = $filterApplicant;
            $dataWhere['Users.name like'] = '%' . $filterApplicant . '%';
        }
        if (!empty($filterDevision)) {
            $data['filterDevision'] = $filterDevision;
            $dataWhere['Overtimes.devision'] = $filterDevision;
        }

        
         // Auth user & rules
        $currentUserId = $dataSession['id']; 
        $rulesString   = $dataSession['rules'];
        $rules         = $this->Krs->_rule($rulesString);
        $canViewAll    = isset($rules['overtimes']['viewAll']) ? $rules['overtimes']['viewAll'] : 0;
        $canViewDevision = isset($rules['overtimes']['viewDevision']) ? $rules['overtimes']['viewDevision'] : 0;
        // $canViewUbs = isset($rules['overtimes']['viewUbs']) ? $rules['overtimes']['viewUbs'] : 0;

        $dataRow = $this->Overtimes->find('all')->contain(['Users','Mengetahui','Menyetujui'])->order(['DATE(Overtimes.date)' => 'DESC', 'Users.name' => 'DESC']);

        // pr($canViewAll);
        // pr($canViewDevision);
        if ($canViewAll == '1') {
            // $dataRow->where(['overtimes.is_create' => $currentUserId]);
        } elseif ($canViewDevision == '1') {
            $dataTeamIds = array_filter(array_map('trim', explode(',', (string)$dataUserTeam)));
            $dataTeamIds[] = $currentUserId;
            $dataTeamIds = array_unique($dataTeamIds);
            $dataRow->where(['overtimes.is_create IN' => $dataTeamIds]);
        } else {
             $dataRow->where(['overtimes.is_create' => $currentUserId]);
        }
        // if ($canViewAll == '0' && $canViewDevision == '1') {
        //     $dataTeamIds = array_filter(array_map('trim', explode(',', (string)$dataUserTeam)));
        //     $dataTeamIds[] = $currentUserId;
        //     $dataTeamIds = array_unique($dataTeamIds);
        //     $dataRow->where(['overtimes.is_create IN' => $dataTeamIds]);
        // } elseif ($canViewAll == '1' && $canViewDevision == '0') {
        // } elseif ($canViewAll == '1' && $canViewDevision == '1') {
        // } else {
        //      $dataRow->where(['overtimes.is_create' => $currentUserId]);
        // }

        // if ($canViewUbs != '1') {
        //     $dataBusinessUnit = array_filter(
        //         array_map('trim', explode(',', (string)$dataSession->ubs))
        //     );
        //     $dataRow->where([
        //         'Overtimes.business_unit IN' => $dataBusinessUnit
        //     ]);
        // }
        $queries = (!empty($dataWhere)) ? $dataRow->where([$dataWhere]) : $dataRow;
        $paginateRow = $this->paginate($queries, ['limit' => '15']);
        $data['dataRows'] = $paginateRow;
        //->toArray()

        $data['filterLink'] = $this->Krs->fEncode($dataWhere);
        $this->set(['dataRows'=>$paginateRow, 'data'=> $data]);

        /*
        $overtimes = $this->Overtimes->find('all')->contain(['Users','Mengetahui','Menyetujui']);
        $key = $this->request->getQuery('key');
        if ($key) {
            $queries = $overtimes->where(['OR' => ['Overtimes.title like' => '%' . $key . '%', 'Overtimes.description like' => '%' . $key . '%', 'Users.name like' => '%'. $key . '%', $arrayDevision]]);
        } else {
            $queries = $overtimes->order(['Overtimes.id' => 'DESC'])->where($arrayDevision);
        }

        // $this->set('overtimes', $this->paginate($queries, ['limit' => '10']));
        $this->set(['overtimes'=>$this->paginate($queries, ['limit' => '10']), 'data'=> $data]);
        */
    }

    /**
     * View method
     *
     * @param string|null $id Overtime id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        list($dataId, $dataUserId) = explode('^', $this->Krs->fDecode($id));
        $overtime = $this->Overtimes->get($dataId, [
            'contain' => ['Users','Mengetahui','Menyetujui', 'WorkOrders', 'WorkOrders.WorkOrderLines'],
        ]);
        $data['dataRows'] = $overtime;
        // pr($licenseLate);
        $this->set(compact('data'));


        // $overtime = $this->Overtimes->get($id, [
        //     'contain' => ['Branches'],
        // ]);

        // $this->set(compact('overtime'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $overtime = $this->Overtimes->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();

            $session = $this->getRequest()->getSession();
            $auth = $session->read('Auth');
            $userId = $auth['id'] ?? null;
            $devision = $auth['devision'] ?? null;
            $position = $auth['position'] ?? null;

            $auditLog = $this->Krs->auditLog("Overtimes", 'N', $userId, "Overtimes add");

            if (empty($dataRow['lines']) || !is_array($dataRow['lines'])) {
                $this->Flash->error('Maaf, data lembur kosong.');
                return $this->redirect(['action' => 'add']);
            }

            foreach ($dataRow['lines'] as $firstLine) {
                $overtimes = [
                    'work_order_id' => $dataRow['work_order_id'] ?? null,
                    'is_create'     => $userId,
                    'applicant'     => $userId,
                    'devision'      => $devision,
                    'position'      => $position,
                    'is_log'        => $auditLog,
                    'date'          => $this->Krs->dateTo($firstLine['date'] ?? null),
                    'time_from'     => $firstLine['time_from'] ?? null,
                    'time_end'      => $firstLine['time_end'] ?? null,
                    'description'   => $this->Krs->fEncode($firstLine['description'] ?? null),
                ];

                $entity = $this->Overtimes->patchEntity($this->Overtimes->newEmptyEntity(), $overtimes);
                // debug($entity); die;

                if (!$this->Overtimes->save($entity)) {
                    $pemohon = $this->Users->get($userId);
                    $atasan = $this->Users->find()
                        ->where([
                            "FIND_IN_SET($userId, user_team)"
                        ])
                        ->first();
                    if ($atasan && !empty($atasan->telegram_chat_id)) {
                        $url =  'group.brgroup.id/hr/overtimes';
                        $pesan =
                            "📢 LEMBUR\n\n" .
                            "👤 Pemohon : {$pemohon->name}\n" .
                            "📅 Tanggal : {$dataRow['date']}\n" .
                            "⏰ Jam : {$dataRow['time_from']} s/d {$dataRow['time_end']}\n\n" .
                            "Silakan melakukan approval/mengetahui melalui link berikut:\n" .
                            $url;
                        $this->Telegram->sendMessage($atasan->telegram_chat_id, $pesan);
                        $this->Telegram->notifyKnowing('overtimes', $pesan);
                    }
                    $this->Flash->success('Terima kasih, Data berhasil disimpan.');
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error('Maaf, ada data yang gagal disimpan.');
            }

            $this->Flash->success('Terima kasih, Data berhasil disimpan.');
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('overtime'));


    }

    /**
     * Edit method
     *
     * @param string|null $id Overtime id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $overtime = $this->Overtimes->get($id, [
            'contain' => [],
        ]);

        if ($overtime->approved !== null) {
            $this->Flash->error('Data sudah disetujui, tidak bisa diedit.');
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $updateDate = array('modified' => Chronos::now());  // Ganti ke Chronos::now()
            $auditLog = $this->Krs->auditLog("Overtimes", $id, $isUser, "Overtimes edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $dataDate = array('date' => $this->Krs->dateTo($dataRow['date']));
            $dataDesc = array('description' => $this->Krs->fEncode($dataRow['description']));

            $overtime = $this->Overtimes->patchEntity($overtime, array_merge($dataRow, $dataAuditLog, $dataDate, $dataDesc, $updateDate));
            if ($this->Overtimes->save($overtime)) {
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        // $branches = $this->Overtimes->Branches->find('list', ['limit' => 200]);
        //, 'branches'
        $this->set(compact('overtime'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Overtime id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $overtime = $this->Overtimes->get($id);
        if ($this->Overtimes->delete($overtime)) {
            $this->Flash->success(__('The overtime has been deleted.'));
        } else {
            $this->Flash->error(__('The overtime could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getWorkOrder()
    {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $code = $this->request->getQuery('code');

            if (!$code) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => 'error',
                        'message' => 'Kode Work Order tidak dikirim'
                    ]));
            }

            $this->loadModel('WorkOrders');
            $this->loadModel('Overtimes');

            // ambil user session
            $session = $this->getRequest()->getSession();
            $auth = $session->read('Auth');
            $userId = $auth['id'] ?? null;

            if (!$userId) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => 'error',
                        'message' => 'User tidak terautentikasi'
                    ]));
            }

            $workOrder = $this->WorkOrders->find()
                ->where(['WorkOrders.status_approve' => 'Y', 'WorkOrders.code LIKE' => '%' . $code . '%'])
                ->contain([
                    'WorkOrderLines' => ['Users']
                ])
                ->first();

            if (!$workOrder) {
                $response = [
                    'status' => 'error',
                    'message' => 'Work Order tidak ditemukan'
                ];
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));
            }

            // filter lines: hanya user yang login dan yang belum memiliki overtime untuk work_order ini
            $filteredLines = [];
            foreach ($workOrder->work_order_lines as $line) {
                $lineUserId = $line->user->id ?? ($line->user_id ?? null);
                if ($lineUserId != $userId) {
                    continue; // hanya tampilkan user yang login
                }

                $exists = (int)$this->Overtimes->find()
                    ->where(['work_order_id' => $workOrder->id, 'applicant' => $lineUserId])
                    ->count();

                if ($exists > 0) {
                    continue; // sudah bikin lembur -> jangan tampilkan
                }

                $filteredLines[] = $line;
            }

            if (!empty($filteredLines)) {
                $response = [
                    'status' => 'success',
                    'work_order' => [
                        'id' => $workOrder->id,
                        'date' => ($workOrder->date instanceof \DateTimeInterface) ? $workOrder->date->format('d-m-Y') : $workOrder->date
                    ],
                    'data' => $filteredLines
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Tidak ada data karyawan yang sesuai atau sudah membuat lembur'
                ];
            }

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($response));
        }
    }


    /**
     * Approve method
     *
     * @param string|null $id Form Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * // $date = array('approved_date' => new Date());
     */
    public function approve($id = null)
    {
        $overtime = $this->Overtimes->get($id, [
            'contain' => ['Users', 'WorkOrders', 'WorkOrders.WorkOrderLines'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['approved'];
            $date = array('approved_date' => Chronos::now());  // Ganti ke Chronos::now()
            $auditLog = $this->Krs->auditLog("Overtimes", $id, $isUser, "Overtimes approve");
            $dataAuditLog = array('is_log' => $auditLog);

            $overtime = $this->Overtimes->patchEntity($overtime, array_merge($dataRow, $date, $dataAuditLog));
            // debug($overtime); die;
            if ($this->Overtimes->save($overtime)) {
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        $this->set(compact('overtime'));
    }

    /**
     * Approve method
     *
     * @param string|null $id Form Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function knowing($id = null)
    {
        $overtime = $this->Overtimes->get($id, [
            'contain' => ['Users', 'WorkOrders', 'WorkOrders.WorkOrderLines'],
        ]);
        if ($overtime->approved === null) {
            $this->Flash->error('Data belum disetujui, belum bisa diketahui.');
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['knowing'];
            $date = array('knowing_date' => Chronos::now());  // Ganti ke Chronos::now()
            $auditLog = $this->Krs->auditLog("Overtimes", $id, $isUser, "Overtimes knowing");
            $dataAuditLog = array('is_log' => $auditLog);

            $overtime = $this->Overtimes->patchEntity($overtime, array_merge($dataRow, $date, $dataAuditLog));

            if ($this->Overtimes->save($overtime)) {
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        $this->set(compact('overtime'));
    }
}
