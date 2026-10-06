<?php
declare(strict_types=1);

namespace App\Controller\Hr;
use App\Controller\AppController;
use Cake\I18n\FrozenDate;
use Cake\Chronos\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Laminas\Diactoros\CallbackStream;
use Cake\Core\Configure;

/**
 * Leaves Controller
 *
 * @property \App\Model\Table\LeavesTable $Leaves
 * @method \App\Model\Entity\Leave[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeavesController extends AppController
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
        // $this->paginate = [
        //     'contain' => ['Branches'],
        // ];
        // $leaves = $this->paginate($this->Leaves);

        // $this->set(compact('leaves'));

        $session = $this->getRequest()->getSession();
        $dataSession = $session->read('Auth');

        $dataId = $dataSession['id'];
        $dataDevision = $dataSession['devision'];
        $dataPettyCashDevision = $dataSession['pettycash_devision'];
        $dataUserTeam = $dataSession['user_team'] ?? '';
        $data['HRISApproved'] = $dataSession->hris_approved;
        $data['HRISKnowing'] = $dataSession->hris_knowing;
        $data['HRISFullAccess'] = $dataSession->hris_full_access;
        
        if($data['HRISKnowing']=='Y' || $data['HRISFullAccess']=='Y') {
            $arrayDevision = array();
        } elseif($data['HRISApproved']=='Y') {
            $dataDevisions = explode(",", $dataDevision);
            $arrayDevision = array('Leaves.devision'=>$dataDevisions); 
        } else {
            $arrayDevision = array('Leaves.applicant'=>$dataId);           
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
            // $dataWhere[] = 'DATE(Leaves.date_from) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '"';
            $dataWhere[] = '(
                DATE(Leaves.date_1) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '" 
                OR DATE(Leaves.date_2) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '" 
                OR DATE(Leaves.date_3) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '" 
                OR (
                    Leaves.date_1 IS NULL
                    AND Leaves.date_2 IS NULL
                    AND Leaves.date_3 IS NULL
                    AND DATE(Leaves.date_from) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '"
                )
            )';
        }

        if (!empty($filterApplicant)) {
            $data['filterApplicant'] = $filterApplicant;
            $dataWhere['Users.name like'] = '%' . $filterApplicant . '%';
        }
        if (!empty($filterDevision)) {
            $data['filterDevision'] = $filterDevision;
            $dataWhere['Leaves.devision'] = $filterDevision;
        }
        
        // Auth user & rules
        $currentUserId = $dataSession['id']; 
        $rulesString   = $dataSession['rules'];
        $rules         = $this->Krs->_rule($rulesString);
        $canViewAll    = isset($rules['leaves']['viewAll']) ? $rules['leaves']['viewAll'] : 0;
        $canViewDevision = isset($rules['leaves']['viewDevision']) ? $rules['leaves']['viewDevision'] : 0;
        // pr($canViewDevision);

        $dataRow = $this->Leaves->find('all')->contain(['Users','Mengetahui','Menyetujui'])->order(['Leaves.created' => 'DESC', 'Users.name' => 'DESC']);

        if ($canViewAll == '1') {
            // $dataRow->where(['Leaves.is_create' => $currentUserId]);
        } elseif ($canViewDevision == '1') {
            $dataTeamIds = array_filter(array_map('trim', explode(',', (string)$dataUserTeam)));
            $dataTeamIds[] = $currentUserId;
            $dataTeamIds = array_unique($dataTeamIds);
            $dataRow->where(['Leaves.is_create IN' => $dataTeamIds]);
        } else {
             $dataRow->where(['Leaves.is_create' => $currentUserId]);
        }
        // pr($dataPettycashDevision);
        // pr($dataDevisions);

        $queries = (!empty($dataWhere)) ? $dataRow->where([$dataWhere]) : $dataRow;
        $paginateRow = $this->paginate($queries, ['limit' => '10']);
        $data['dataRows'] = $paginateRow;
        //->toArray()
//         debug($queries->sql());
// die;
//         debug($dataWhere); die;
        $data['filterLink'] = $this->Krs->fEncode($dataWhere);
        $this->set(['dataRows'=>$paginateRow, 'data'=> $data]);
        


        /*$leaves = $this->Leaves->find('all')->contain(['Users','Menyetujui','Mengetahui']);
        $key = $this->request->getQuery('key');
        if ($key) {
            $queries = $leaves->where(['OR' => ['Leaves.title like' => '%' . $key . '%', 'Leaves.description like' => '%' . $key . '%', 'Users.name like' => '%' . $key . '%', $arrayDevision]]);
        } else {
            $queries = $leaves->order(['Leaves.id' => 'DESC'])->where($arrayDevision);
        }

        // $this->set('leaves', $this->paginate($queries, ['limit' => '10']));
        $this->set(['leaves'=>$this->paginate($queries, ['limit' => '10']), 'data'=> $data]);*/
        
    }

    /**
     * View method
     *
     * @param string|null $id Leave id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        list($dataId, $dataUserId) = explode('^', $this->Krs->fDecode($id));
        $leave = $this->Leaves->get($dataId, [
            'contain' => ['Users','Mengetahui','Menyetujui'],
        ]);
        $data['dataRows'] = $leave;
        $this->set(compact('data'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leave = $this->Leaves->newEmptyEntity();
        if ($this->request->is('post')) {
            
            $dataRow = $this->request->getData();
            // list($typeName, $typeDay) = explode('^', $dataRow['type']);

            $isUser = $dataRow['is_create'];

            $auditLog = $this->Krs->auditLog("Leaves", 'N',  $isUser, "Leaves add");
            $dataAuditLog = array('is_log' => $auditLog);

            // $dataAuditLog['type'] = $typeName;
            // $dataAuditLog['leave_days'] = $typeDay;
            // $dataLeaveDays['leave_days'] =
            // (new \DateTime($this->Krs->dateTo($dataRow['date_from'])))
            //     ->diff(new \DateTime($this->Krs->dateTo($dataRow['date_end'])))
            //     ->days + 1;
            // $dataLeaveDays['leave_days'] = $leaveDays;

            // $dataDateFrom = array('date_from' => $this->Krs->dateTo($dataRow['date_from']));
            // $dataDateEnd = array('date_end' => $this->Krs->dateTo($dataRow['date_end']));
            $dataDate1 = array('date_1' => $this->Krs->dateTo($dataRow['date_1']));
            $dataDate2 = array('date_2' => $this->Krs->dateTo($dataRow['date_2']));
            $dataDate3 = array('date_3' => $this->Krs->dateTo($dataRow['date_3']));
            $dataApplicant = array('applicant' => $isUser);
            $dataDesc = array('description' => $this->Krs->fEncode($dataRow['description']));

            $leave = $this->Leaves->patchEntity($leave, array_merge($dataRow, $dataApplicant, $dataDesc, $dataAuditLog, $dataDate1, $dataDate2, $dataDate3));
            // $dataDateFrom, $dataDateEnd, $dataLeaveDays,
            if ($this->Leaves->save($leave)) {
                $pemohon = $this->Users->get($isUser);
                $atasan = $this->Users->find()
                    ->where([
                        "FIND_IN_SET($isUser, user_team)"
                    ])
                    ->first();
                if ($atasan && !empty($atasan->telegram_chat_id)) {
                    $url = 'group.brgroup.id/hr/leaves';
                    $pesan =
                        "📢 PERMINTAAN CUTI\n\n" .
                        "👤 Pemohon : {$pemohon->name}\n" .
                        "📅 Tanggal : {$dataRow['date_from']} s/d {$dataRow['date_end']}\n\n" .
                        "Silakan melakukan approval/mengetahui melalui link berikut:\n" .
                        $url;
                    $this->Telegram->sendMessage($atasan->telegram_chat_id, $pesan);
                    $this->Telegram->notifyKnowing('leaves', $pesan);
                }
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        // $branches = $this->Leaves->Branches->find('list', ['limit' => 200]);
        $this->set(compact('leave'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Leave id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leave = $this->Leaves->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            // list($typeName, $typeDay) = explode('^', $dataRow['type']);
            // $dataType['type'] = $typeName;
            // $dataLeaveDays['leave_days'] = $typeDay;
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog("Leaves", $id, $isUser, "Leaves edit");
            $dataAuditLog = array('is_log' => $auditLog); 
            // $dataDateFrom = array('date_from' => $this->Krs->dateTo($dataRow['date_from']));
            // $dataDateEnd = array('date_end' => $this->Krs->dateTo($dataRow['date_end']));
            $dataDate1 = array('date_1' => $this->Krs->dateTo($dataRow['date_1']));
            $dataDate2 = array('date_2' => $this->Krs->dateTo($dataRow['date_2']));
            $dataDate3 = array('date_3' => $this->Krs->dateTo($dataRow['date_3']));
            $dataDesc = array('description' => $this->Krs->fEncode($dataRow['description']));

            $leave = $this->Leaves->patchEntity($leave, array_merge($dataRow, $dataAuditLog, $dataDate1, $dataDate2, $dataDate3, $dataDesc));
            // , $dataType, $dataLeaveDays
            if ($this->Leaves->save($leave)) {
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        $this->set(compact('leave'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Leave id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leave = $this->Leaves->get($id);
        if ($this->Leaves->delete($leave)) {
            $this->Flash->success(__('The leave has been deleted.'));
        } else {
            $this->Flash->error(__('The leave could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function approve($id = null)
    {
        $leave = $this->Leaves->get($id, [
            'contain' => ['Users'],
        ]);
        if ($leave->approved_date !== null) {
            $this->Flash->error('Data ini sudah disetujui sebelumnya.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isApprove = $dataRow['approved'];
            $date = ['approved_date' => new Date()];
            $auditLog = $this->Krs->auditLog("Leaves", 'N', $isApprove, "Leaves approve");
            $dataAuditLog = ['is_log' => $auditLog];
            $leave = $this->Leaves->patchEntity($leave, array_merge($dataRow, $date, $dataAuditLog));

            if ($this->Leaves->save($leave)) {
                $usersTable = $this->getTableLocator()->get('Users');
                $employeesTable = $this->getTableLocator()->get('HrgaEmployees');
                $user = $usersTable->find()
                    ->where(['id' => $leave->applicant])
                    ->first();

                if (!empty($user) && !empty($user->hrga_employee_id) && $leave->status_approve == 'Y') {
                    $employee = $employeesTable->find()
                        ->where(['id' => $user->hrga_employee_id])
                        ->first();

                    if ($employee) {
                        $dates = array_filter([$leave->date_1, $leave->date_2, $leave->date_3]);
                        $jumlahHari = count(array_unique($dates));
                        $employee->jml_cuti = max(0, $employee->jml_cuti - $jumlahHari);
                        $employeesTable->save($employee);
                        // Simpan log
                        $logMsg = "Cuti atas nama {$leave->user->name} disetujui oleh HRGA (User ID: {$isApprove}) pada ". date('Y-m-d H:i:s') . ". Pengurangan cuti: {$jumlahHari} hari.";
                        $leave->is_log = trim(($leave->is_log ?? '') . "\n" . $logMsg);
                        $this->Leaves->save($leave);
                    }
                }
                $this->Flash->success('Data cuti berhasil disetujui dan jatah cuti diperbarui.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf, data gagal disimpan. Silakan periksa kembali.');
        }
        // $getUser = $this->Auth->user();
        $users = $this->Leaves->Users->find('all', ['limit' => 200]);
        $this->set(compact('leave', 'users'));
    }

    public function knowing($id = null)
    {
        $leave = $this->Leaves->get($id, [
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            // pr($dataRow);
            $isUser = $dataRow['knowing'];
            // $isApprove = $dataRow['knowing'];
            $date = array('knowing_date' => new Date());
            $auditLog = $this->Krs->auditLog("Leaves", 'N', $isUser, "Leaves knowing");
            $dataAuditLog = array('is_log' => $auditLog);

            $leave = $this->Leaves->patchEntity($leave, array_merge($dataRow, $date, $dataAuditLog));

            // pr($leave);
            if ($this->Leaves->save($leave)) {
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        // $users = $this->Leaves->Users->find('all', ['limit' => 200]); , 'users' 
        $this->set(compact('leave'));
    }

    public function excel()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);
        $session = $this->getRequest()->getSession();
        $dataSession = $session->read('Auth');

        $dataId                 = $dataSession['id'];
        $dataDevision           = $dataSession['devision'];
        $dataPettyCashDevision  = $dataSession['pettycash_devision'];
        $dataUserTeam = $dataSession['user_team'];
        $filterDateFrom = $this->request->getQuery('filterDateFrom');
        $filterDateEnd  = $this->request->getQuery('filterDateEnd');
        $filterApplicant = $this->request->getQuery('filterApplicant');
        $filterDevision = $this->request->getQuery('filterDevision');

        $dataWhere = [];

        if (!empty($filterDateFrom) && !empty($filterDateEnd)) {
            $dateFrom = $this->Krs->dateTo($filterDateFrom);
            $dateEnd  = $this->Krs->dateTo($filterDateEnd);
            $dataWhere[] ='DATE(Leaves.date_from) BETWEEN "' . $dateFrom . '" AND "' . $dateEnd .'"';
        }
        if (!empty($filterApplicant)) {
            $dataWhere['Users.name like'] = '%' . $filterApplicant . '%';
        }
        if (!empty($filterDevision)) {
            $dataWhere['Leaves.devision'] = $filterDevision;
        }

        $rulesString = $dataSession['rules'];
        $rules = $this->Krs->_rule($rulesString);

        $canViewAll = isset($rules['leaves']['viewAll']) ? $rules['leaves']['viewAll'] : 0;

        $canViewDevision = isset($rules['leaves']['viewDevision']) ? $rules['leaves']['viewDevision'] : 0;

        $query = $this->Leaves->find('all')
            ->contain(['Users', 'Mengetahui', 'Menyetujui'])
            ->order([
                'DATE(Leaves.date_from)' => 'DESC',
                'Users.name' => 'DESC'
            ]);

        if ($canViewAll == '1') {
            // $dataRow->where(['Leaves.is_create' => $currentUserId]);
        }
        
        if ($canViewAll == '0' && $canViewDevision == '1') {
            $dataDevisions = !empty($dataUserTeam) ? explode(',', $dataUserTeam) : [];
            $dataDevisions[] = $dataId;
            $dataDevisions = array_unique($dataDevisions);
            $query->where(['Leaves.is_create IN' => $dataDevisions]);
        } elseif ($canViewAll == '1' && $canViewDevision == '0') {
            // view all, tidak perlu filter
        } else {
            $query->where(['Leaves.is_create' => $dataId]);
        }
        if (!empty($dataWhere)) {
            $query->where($dataWhere);
        }
        $rows = $query->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Cuti');

        $sheet->setCellValue('A1', 'Rekap Cuti Karyawan');
        $sheet->mergeCells('A1:J1');

        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A1')->getFont()
            ->setBold(true)
            ->setSize(12);

        // =========================
        // HEADER
        // =========================
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama');
        $sheet->setCellValue('C2', 'Divisi');
        $sheet->setCellValue('D2', 'Lama Cuti');
        $sheet->setCellValue('E2', 'Tanggal Dari');
        $sheet->setCellValue('F2', 'Tanggal Sampai');
        $sheet->setCellValue('G2', 'Keperluan');
        $sheet->setCellValue('H2', 'Tanggal Pengajuan');
        $sheet->setCellValue('I2', 'Mengetahui');
        $sheet->setCellValue('J2', 'Menyetujui');

        // =========================
        // DATA
        // =========================
        $rowNum = 3;
        foreach ($rows as $i => $r) {
            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue( 'B' . $rowNum, $r->user->name ?? '-');
            $sheet->setCellValue('C' . $rowNum,$r->devision ?? '-');
            $sheet->setCellValue('D' . $rowNum,$r->leave_days.' Hari' ?? '-');
            $sheet->setCellValue('E' . $rowNum,!empty($r->date_from)? $r->date_from->format('d-m-Y') : '-');
            $sheet->setCellValue('F' . $rowNum, !empty($r->date_end) ? $r->date_end->format('d-m-Y') : '-');
            $sheet->setCellValue('G' . $rowNum,$r->type ?? '-');
            // $sheet->setCellValue('F' . $rowNum, $this->Krs->fDecode($r->description) ?? '-');
            // $sheet->setCellValue('G' . $rowNum, $r->mengetahui->name ?? '-');
            // $sheet->setCellValue('H' . $rowNum, $r->menyetujui->name ?? '-');
            // $sheet->setCellValue('I' . $rowNum, $r->status ?? '-');
              
            $sheet->setCellValue('H' . $rowNum, !empty($r->created) ? $r->created->format('d-m-Y H:i:s') : '-');
            $sheet->setCellValue('I' . $rowNum, (!empty($r->mengetahui) ? $r->mengetahui->name : '-') . "\n" . (!empty($r->knowing_date) ? $r->knowing_date->format('d-m-Y') : '-'));
            $sheet->setCellValue('J' . $rowNum, (!empty($r->menyetujui) ? $r->menyetujui->name : '-') . "\n" .(!empty($r->approved_date) ? $r->approved_date->format('d-m-Y') : '-'));
            $rowNum++;
        }
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $lastRow = $rowNum - 1;

        $sheet->getStyle("A1:J{$lastRow}")
            ->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Cuti-' . date('Ymd-His') . '.xlsx';

        return $this->response
            ->withType('xlsx')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$filename}\""
            )
            ->withBody($stream);
    }

    public function cancel($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $id = $this->request->getData('id') ?? $id;
            $session = $this->getRequest()->getSession();
            $dataSession = $session->read('Auth');
            $userId = $dataSession['id'];
            $leave = $this->Leaves->get($id);
            $leave = $this->Leaves->patchEntity($leave, [
                'is_cancel'     => $userId,
                'canceled'      => $this->Krs->dateNow(),
                'cancel_reason' => $this->request->getData('cancel_reason'),
                'is_log'        => $this->Krs->auditLog($this->request->getParam('controller'), $id, $userId, 'Leave cancel')
            ]);
            // debug($leave);
            // die;

            if ($this->Leaves->save($leave)) {
                $this->Flash->success(__('Pengajuan cuti berhasil dibatalkan.'));
            } else {
                $this->Flash->error(__('Pengajuan cuti gagal dibatalkan.'));
            }
        }

        return $this->redirect($this->referer());
    }
}
