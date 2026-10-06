<?php
declare(strict_types=1);

namespace App\Controller\Hr;
use App\Controller\AppController;
use Cake\I18n\FrozenTime;

/**
 * WorkOrders Controller
 *
 * @property \App\Model\Table\WorkOrdersTable $WorkOrders
 * @method \App\Model\Entity\WorkOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkOrdersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('WorkOrders');
        $this->loadModel('WorkOrderLines');
        $this->loadModel('Users');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $workOrders = $this->paginate($this->WorkOrders);

        $this->set(compact('workOrders'));
    }

    /**
     * View method
     *
     * @param string|null $id Work Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workOrder = $this->WorkOrders->get($id, [
            'contain' => ['WorkOrderLines'],
        ]);

        $this->set(compact('workOrder'));
    }

    public function get_last_number()
    {
        $row = $this->WorkOrders->find()
            ->select(['code'])
            ->order(['WorkOrders.id' => 'DESC'])
            ->first();

        $lastCode = $row->code ?? '';

        // Default 0
        $numberPart = 0;

        if ($lastCode !== '') {
            if (preg_match('/(\d+)/', $lastCode, $matches)) {
                $numberPart = (int)$matches[1]; 
            }
        }

        // Increment
        $next = $numberPart + 1;

        // Pad kiri sampai 5 digit
        $result = str_pad((string)$next, 5, '0', STR_PAD_LEFT);

        $number = $result . '/SPKL/' . $this->Krs->noOfRome(date('m')) . '/' . date('Y');
        return $number;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workOrder = $this->WorkOrders->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'] ?? $this->request->getSession()->read('Auth.id');
            $auditLog = $this->Krs->auditLog("WorkOrders", 'N', $this->request->getParam('controller'),  $isUser, "WorkOrders add");
            $dataAuditLog = array('is_log' => $auditLog);
            $code = array('code' => $this->get_last_number());
            $date = $this->Krs->dateTo($dataRow['date']);

            $lines = [];
            foreach ($dataRow['work_order_lines'] as $line) {

                if (!empty($line['user_id']) && !empty($line['task'])) {

                    // DECODE user_id
                    $decode = $this->Krs->fDecode($line['user_id']);
                    list($userId, $userCode) = explode('^', $decode);
                    $line['user_id'] = (int) $userId;
                    $lines[] = $line;
                }
            }
            // debug($lines);
            // die;
            $dataLines = array('work_order_lines' => $lines);
            $workOrder = $this->WorkOrders->patchEntity($workOrder, array_merge($dataRow, $code, $dataAuditLog, array('date' => $date), $dataLines), [
                'associated' => ['WorkOrderLines']
            ]);
            // debug($workOrder);
            // die;
            if ($this->WorkOrders->save($workOrder)) {
                $this->Flash->success(__('Surat Perintah Kerja Lembur berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Surat Perintah Kerja Lembur gagal disimpan. Silakan coba lagi.'));
        }
        
        $data['lastNumber'] = $this->get_last_number();
        $this->set(compact('workOrder', 'data'));
    }

    // public function addSpt($id = null)
    // {
    //     $workOrder = $this->WorkOrders->newEmptyEntity();
    //     if ($id) {
    //         $taskOrder = $this->WorkOrders->TaskOrders->get($id, [
    //             'contain' => ['TaskOrderLines', 'TaskOrderLines.Users']
    //         ]);

    //         $mappedLines = [];
    //         foreach ($taskOrder->task_order_lines as $line) {
    //             $mappedLines[] = [
    //                 'user_id' => $line->user_id, // Ambil ID user dari relasi
    //                 'task' => $line->task,
    //                 'time_from' => $line->time_from ?? null,
    //                 'time_end' => $line->time_end ?? null,
    //                 'start_date' => $line->start_date ?? null,
    //                 'end_date' => $line->end_date ?? null,
    //             ];
    //         }

    //         $workOrder = $this->WorkOrders->patchEntity($workOrder, [
    //             'business_unit' => $taskOrder->business_unit,
    //             'description' => $taskOrder->description,
    //             'work_order_lines' => $mappedLines
    //         ], [
    //             'associated' => ['WorkOrderLines']
    //         ]);

    //         $this->set(compact('taskOrder'));
    //     }

    //     if ($this->request->is('post')) {
    //         $dataRow = $this->request->getData();
    //         $isUser = $dataRow['is_create'] ?? $this->request->getSession()->read('Auth.id');
    //         $auditLog = $this->Krs->auditLog("WorkOrders", 'N', $this->request->getParam('controller'),  $isUser, "WorkOrders add");
    //         $dataAuditLog = array('is_log' => $auditLog);
    //         $code = array('code' => $this->get_last_number());
    //         $date = $this->Krs->dateTo($dataRow['date']);

    //         $lines = [];
    //         foreach ($dataRow['work_order_lines'] as $line) {

    //             if (!empty($line['user_id']) && !empty($line['task'])) {

    //             // debug($line['user_id']);
    //                 // DECODE user_id
    //                 // $decode = $this->Krs->fDecode($line['user_id']);
    //                 // list($userId, $userCode) = explode('^', $decode);
    //                 // $line['user_id'] = (int) $userId;
    //                 $line['user_id'] = (int) $line['user_id'];
    //                 $lines[] = $line;
    //             }
    //         }
    //         // debug($lines);
    //         // die;
    //         $dataLines = array('work_order_lines' => $lines);
    //         $workOrder = $this->WorkOrders->patchEntity($workOrder, array_merge($dataRow, $code, $dataAuditLog, array('date' => $date), $dataLines), [
    //             'associated' => ['WorkOrderLines']
    //         ]);
    //         // debug($workOrder);
    //         // die;
    //         if ($this->WorkOrders->save($workOrder)) {
    //             $this->Flash->success(__('Surat Perintah Kerja Lembur berhasil disimpan.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('Surat Perintah Kerja Lembur gagal disimpan. Silakan coba lagi.'));
    //     }
        
    //     $data['lastNumber'] = $this->get_last_number();
    //     $this->set(compact('workOrder', 'data'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Work Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workOrder = $this->WorkOrders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $workOrder = $this->WorkOrders->patchEntity($workOrder, $this->request->getData());
            if ($this->WorkOrders->save($workOrder)) {
                $this->Flash->success(__('The work order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The work order could not be saved. Please, try again.'));
        }
        $this->set(compact('workOrder'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Work Order id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $workOrder = $this->WorkOrders->get($id);
        if ($this->WorkOrders->delete($workOrder)) {
            $this->Flash->success(__('The work order has been deleted.'));
        } else {
            $this->Flash->error(__('The work order could not be deleted. Please, try again.'));
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

        $start_date = $this->request->getQuery('start_date');
        $end_date   = $this->request->getQuery('end_date');
        // $NamaAsetSearch = $this->request->getQuery('NamaAsetSearch');
        $nomorSuratSearch = $this->request->getQuery('nomorSuratSearch');
        $businessUnitSearch = $this->request->getQuery('businessUnitSearch');
        // $form_type = $this->request->getQuery('form_type');

        $query = $this->WorkOrders->find()
        ->contain([
            'WorkOrderLines'=> [
                'Users' => function ($q) {
                    return $q->select(['id', 'name']);
                }
            ],
            'ApproveUsers' => function ($q) {
                return $q->select(['id', 'name']);
            },
            'CreateUsers' => function ($q) {
                return $q->select(['id', 'name']);
            },
            'CancelUsers' => function ($q) {
                return $q->select(['id', 'name']);
            },
        ])
        ->where(['WorkOrders.is_active' => 'Y']);

        // if (!empty($NamaAsetSearch)) {
        //     $query->where(['WorkOrders.hrga_asset_id' => $NamaAsetSearch]);
        // }

        if (!empty($nomorSuratSearch)) {
            $query->where(['WorkOrders.code LIKE' => '%' . $nomorSuratSearch . '%']);
        }

        if (!empty($businessUnitSearch)) {
            $query->where(['WorkOrders.business_unit LIKE' => '%' . $businessUnitSearch . '%']);
        }

        if (!empty($start_date) && !empty($end_date)) {
            $query->where(function ($exp) use ($start_date, $end_date) {
                return $exp->between(
                    'WorkOrders.date',
                    date('Y-m-d', strtotime($start_date)),
                    date('Y-m-d', strtotime($end_date))
                );
            });
        }

        // Hitung total data (tanpa limit & offset)
        $recordsTotal = $query->count();

        // $query->order(['WorkOrders.created' => 'DESC']);
        $query->limit($length)
            ->offset($start)
            ->order(['WorkOrders.created' => 'DESC']);

        // // Tambahkan pagination
        // $query->limit($length)->offset($start)->order(['AccLoans.date' => 'DESC']);

        $data = $query->toArray();
        // debug($data); // Tambahkan ini untuk melihat data yang diambil

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
        $workOrder = $this->WorkOrders->get($id, [
            'contain' => ['WorkOrderLines' => ['Users']]
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // User yang melakukan approve
            $approveUser = $data['is_approve'] 
                ?? $this->request->getSession()->read('Auth.id');

            // status_approve dari checkbox: 'Y' atau 'N'
            $statusApprove = $data['status_approve'] ?? 'N';

            // Audit log - append ke is_log yang sudah ada
            $existingLog = json_decode($workOrder->is_log ?? '{}', true);
            if (!is_array($existingLog)) {
                $existingLog = [];
            }
            
            // Tambahkan entry baru untuk approve
            $existingLog['approve'] = [
                'user_id' => $approveUser,
                'status' => $statusApprove,
                'date' => date('Y-m-d H:i:s')
            ];
            
            $auditLog = json_encode($existingLog);

            $workOrder = $this->WorkOrders->patchEntity($workOrder, [
                'status_approve' => $statusApprove,
                'is_approve'     => $approveUser,
                'approved'       => date('Y-m-d H:i:s'), 
                'is_log'         => $auditLog
            ]);

            // debug($workOrder);
            // die;
            if ($workOrder->hasErrors()) {
                debug($workOrder->getErrors());
                die;
            }
            if ($this->WorkOrders->save($workOrder)) {
                $this->Flash->success(
                    __('Surat Perintah Kerja Lembur berhasil ' .
                    ($statusApprove === 'Y' ? 'disetujui' : 'ditolak') . '.')
                );

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Gagal menyimpan persetujuan. Silakan coba lagi.'));
        }

        $data['lastNumber'] = $workOrder->code;
        $this->set(compact('workOrder', 'data'));
    }

    public function cancel($id = null)
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
                $workOrder = $this->WorkOrders->get($id);
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
                    'data' => $workOrder
                ]));
        }
        if ($this->request->is(['post', 'patch', 'put'])) {

            $data = $this->request->getData();
            $postId = $id ?? ($data['id'] ?? null);

            if (!$postId) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => false,
                        'message' => 'Missing id for update'
                    ]));
            }
            try {
                $workOrder = $this->WorkOrders->get($postId);
            } catch (\Exception $e) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => false,
                        'message' => 'Record not found'
                    ]));
            }

            // Field tambahan / override
            // $data['status'] = 'Cancel';
            $workOrder = $this->WorkOrders->patchEntity($workOrder, $data);
            $workOrder->canceled = FrozenTime::now();

            // debug($workOrder);
            // die;
            if ($this->WorkOrders->save($workOrder)) {
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'status' => true,
                        'data' => $workOrder
                    ]));
            }

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'status' => false,
                    'errors' => $workOrder->getErrors()
                ]));
        }
        if ($id) {
            try {
                $workOrder = $this->WorkOrders->get($id);
            } catch (\Exception $e) {
                $workOrder = null;
            }
            $this->set(compact('workOrder'));
        }
    }


}
