<?php
declare(strict_types=1);

namespace App\Controller\Hr;
use App\Controller\AppController;
use Cake\Core\Configure;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Laminas\Diactoros\CallbackStream;

/**
 * PermissionLates Controller
 *
 * @property \App\Model\Table\PermissionLatesTable $PermissionLates
 * @method \App\Model\Entity\PermissionLate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PermissionLatesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadComponent('Telegram');
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
            $arrayDevision = array('PermissionLates.devision'=>$dataDevisions); 
        } else {
            $arrayDevision = array('PermissionLates.applicant'=>$dataId);           
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
            $dataWhere[] = 'DATE(PermissionLates.date) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '"';
        }

        if (!empty($filterApplicant)) {
            $data['filterApplicant'] = $filterApplicant;
            $dataWhere['Users.name like'] = '%' . $filterApplicant . '%';
        }
        if (!empty($filterDevision)) {
            $data['filterDevision'] = $filterDevision;
            $dataWhere['PermissionLates.devision'] = $filterDevision;
        }
        
        // Auth user & rules
        $currentUserId = $dataSession['id']; 
        $rulesString   = $dataSession['rules'];
        $rules         = $this->Krs->_rule($rulesString);
        $canViewAll    = isset($rules['permissionlates']['viewAll']) ? $rules['permissionlates']['viewAll'] : 0;
        $canViewDevision = isset($rules['permissionlates']['viewDevision']) ? $rules['permissionlates']['viewDevision'] : 0;
        // pr($canViewDevision);

        $dataRow = $this->PermissionLates->find('all')->contain(['Users','Mengetahui','Menyetujui'])->order(['DATE(PermissionLates.date)' => 'DESC', 'Users.name' => 'DESC']);

        if ($canViewAll == '1') {
            // $dataRow->where(['PermissionLates.is_create' => $currentUserId]);
        } elseif ($canViewDevision == '1') {
            $dataTeamIds = array_filter(array_map('trim', explode(',', (string)$dataUserTeam)));
            $dataTeamIds[] = $currentUserId;
            $dataTeamIds = array_unique($dataTeamIds);
            $dataRow->where(['PermissionLates.is_create IN' => $dataTeamIds]);
        } else {
             $dataRow->where(['PermissionLates.is_create' => $currentUserId]);
        }
        // pr($dataPettycashDevision);
        // pr($dataDevisions);

        $queries = (!empty($dataWhere)) ? $dataRow->where([$dataWhere]) : $dataRow;
        $paginateRow = $this->paginate($queries, ['limit' => '15']);
        $data['dataRows'] = $paginateRow;
        //->toArray()

        $data['filterLink'] = $this->Krs->fEncode($dataWhere);
        $this->set(['dataRows'=>$paginateRow, 'data'=> $data]);
    }

    /**
     * View method
     *
     * @param string|null $id Permission Late id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        list($dataId, $dataUserId) = explode('^', $this->Krs->fDecode($id));
        $permissionLate = $this->PermissionLates->get($dataId, [
            'contain' => ['Users','Mengetahui','Menyetujui'],
        ]);
        $data['dataRows'] = $permissionLate;
        $this->set(compact('data'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permissionLate = $this->PermissionLates->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            unset($dataRow['files']);
            $isUser = $dataRow['is_create'];
            $dataRow['date'] = date('d-m-Y');

            $auditLog = $this->Krs->auditLog("PermissionLates", 'N',  $isUser, "PermissionLates add");
            $dataAuditLog = array('is_log' => $auditLog);

            $dataDate = array('date' => $this->Krs->dateTo($dataRow['date']));
            $dataTimeFrom = array('time_in' => $dataRow['time_in']);
            $dataDesc = array('description' => $this->Krs->fEncode($dataRow['description']));
            $fieldName = 'files';
            $file = $this->request->getData($fieldName);
            $fileData = [];

            if (is_object($file) && method_exists($file, 'getError') && $file->getError() === 0) {
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientFilename());
                $targetPath = WWW_ROOT . 'files' . DS . $filename;
                $file->moveTo($targetPath);
                $fileData[$fieldName] = $filename;
            }

            $permissionLate = $this->PermissionLates->patchEntity($permissionLate, array_merge($dataRow, $dataAuditLog, $dataDate,$dataTimeFrom, $dataDesc, $fileData));
            // debug($permissionLate); // Debug the entity to check the data
            // die;
            if ($this->PermissionLates->save($permissionLate)) {
                $pemohon = $this->Users->get($isUser);
                $atasan = $this->Users->find()
                    ->where([
                        "FIND_IN_SET($isUser, user_team)"
                    ])
                    ->first();
                if ($atasan && !empty($atasan->telegram_chat_id)) {
                    $url = 'https://rssby.brgroup.id/hr/permission-lates';
                    $pesan =
                        "📢 PERMINTAAN IJIN TERLAMBAT\n\n" .
                        "👤 Pemohon : {$pemohon->name}\n" .
                        "📅 Tanggal : {$dataRow['date']}\n" .
                        "🕒 Jam : {$dataRow['time_in']}\n\n" .
                        "Silakan melakukan approval/mengetahui melalui link berikut:\n" .
                        $url;
                    $this->Telegram->sendMessage($atasan->telegram_chat_id, $pesan);
                    $this->Telegram->notifyKnowing('permission_lates', $pesan);
                }
                $this->Flash->success(__('Terima kasih, Data berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf data gagal disimpan, silakan masukkan data dengan benar!.'));
        }
        $branches = $this->PermissionLates->Branches->find('list', ['limit' => 200]);
        $this->set(compact('permissionLate', 'branches'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Permission Late id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permissionLate = $this->PermissionLates->get($id, [
            'contain' => [],
        ]);
        if ($permissionLate->approved !== null) {
            $this->Flash->error('Data sudah disetujui, tidak bisa diedit.');
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permissionLate = $this->PermissionLates->patchEntity($permissionLate, $this->request->getData());
            if ($this->PermissionLates->save($permissionLate)) {
                $this->Flash->success(__('The permission late has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permission late could not be saved. Please, try again.'));
        }
        $branches = $this->PermissionLates->Branches->find('list', ['limit' => 200]);
        $this->set(compact('permissionLate', 'branches'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permission Late id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permissionLate = $this->PermissionLates->get($id);
        if ($this->PermissionLates->delete($permissionLate)) {
            $this->Flash->success(__('The permission late has been deleted.'));
        } else {
            $this->Flash->error(__('The permission late could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function approve($id = null)
    {
        $permissionLate = $this->PermissionLates->get($id, [
            'contain' => ['Users'],
        ]);
        // if ($permissionLate->approved === null) {
        //     $this->Flash->error('Data belum disetujui, belum bisa diketahui.');
        //     return $this->redirect(['action' => 'index']);
        // }
        // if ($permissionLate->approved_date !== null) {
        //     $this->Flash->error('Data ini sudah disetujui sebelumnya.');
        //     return $this->redirect(['action' => 'index']);
        // }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isApprove = $dataRow['is_approved'];
            $date = ['approved' => new \DateTime()];
            $dataNote = ['desc_approve' => trim((string)($dataRow['desc_approve'] ?? ''))];
            $auditLog = $this->Krs->auditLog("PermissionLates", 'N', $isApprove, "PermissionLates approve");
            $dataAuditLog = ['is_log' => $auditLog];
            $permissionLate = $this->PermissionLates->patchEntity($permissionLate, array_merge($dataRow, $date, $dataNote, $dataAuditLog));
            // debug($permissionLate);
            // die;
            if ($this->PermissionLates->save($permissionLate)) {
                $this->Flash->success('Data berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf, data gagal disimpan. Silakan periksa kembali.');
            debug($permissionLate->getErrors());
        }
        // $getUser = $this->Auth->user();
        $users = $this->PermissionLates->Users->find('all', ['limit' => 200]);
        $this->set(compact('permissionLate', 'users'));
    }

    public function knowing($id = null)
    {
        $permissionLate = $this->PermissionLates->get($id, [
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_knowing'];
            $date = array('knowing' => new \DateTime());
            $dataNote = ['desc_knowing' => trim((string)($dataRow['desc_knowing'] ?? ''))];
            $auditLog = $this->Krs->auditLog("PermissionLates", 'N', $isUser, "PermissionLates knowing");
            $dataAuditLog = array('is_log' => $auditLog);
            $permissionLate = $this->PermissionLates->patchEntity($permissionLate, array_merge($dataRow, $date, $dataNote, $dataAuditLog));
            // debug($permissionLate); die;
            // pr($permissionLate);
            if ($this->PermissionLates->save($permissionLate)) {
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');                
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        // $users = $this->LicenseAbsents->Users->find('all', ['limit' => 200]); , 'users' 
        $this->set(compact('permissionLate'));
    }

    public function excel()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);

        $session = $this->getRequest()->getSession();
        $dataSession = $session->read('Auth');
        $dataId                = $dataSession['id'];
        $dataDevision          = $dataSession['devision'];
        $dataPettyCashDevision = $dataSession['pettycash_devision'];
        $dataUserTeam          = $dataSession['user_team'] ?? '';

        $filterDateFrom  = $this->request->getQuery('filterDateFrom');
        $filterDateEnd   = $this->request->getQuery('filterDateEnd');
        $filterApplicant = $this->request->getQuery('filterApplicant');
        $filterDevision  = $this->request->getQuery('filterDevision');
        $dataWhere = [];
        if (!empty($filterDateFrom) && !empty($filterDateEnd)) {
            $dateFrom = $this->Krs->dateTo($filterDateFrom);
            $dateEnd  = $this->Krs->dateTo($filterDateEnd);
            $dataWhere[] ='DATE(PermissionLates.date) BETWEEN "' . $dateFrom .'" AND "' . $dateEnd .'"';
        }
        if (!empty($filterApplicant)) {
            $dataWhere['Users.name like'] ='%' . $filterApplicant . '%';
        }

        if (!empty($filterDevision)) {
            $dataWhere['PermissionLates.devision'] = $filterDevision;
        }

        $rulesString = $dataSession['rules'];
        $rules = $this->Krs->_rule($rulesString);

        $canViewAll = isset($rules['licenseearlyleaves']['viewAll']) ? $rules['licenseearlyleaves']['viewAll'] : 0;

        $canViewDevision = isset($rules['licenseearlyleaves']['viewDevision']) ? $rules['licenseearlyleaves']['viewDevision'] : 0;

        $query = $this->PermissionLates->find('all')
            ->contain(['Users', 'Mengetahui', 'Menyetujui'])
            ->order([
                'DATE(PermissionLates.date)' => 'DESC',
                'Users.name' => 'DESC'
            ]);

        if ($canViewAll == '0' && $canViewDevision == '1') {
            $dataDevisions = !empty($dataUserTeam) ? explode(',', $dataUserTeam) : [];
            $dataDevisions[] = $dataId;
            $dataDevisions = array_unique($dataDevisions);
            $query->where(['PermissionLates.is_create IN' => $dataDevisions]);
        } elseif ($canViewAll == '1' && $canViewDevision == '0') {
            // full access
        } else {
            $query->where(['PermissionLates.is_create' => $dataId]);
        }
        if (!empty($dataWhere)) {
            $query->where($dataWhere);
        }
        $rows = $query->toArray();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Izin Pulang');

        $sheet->setCellValue('A1', 'Rekap Izin Pulang');
        $sheet->mergeCells('A1:H1');
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
        $sheet->setCellValue('D2', 'Tanggal');
        $sheet->setCellValue('E2', 'Jam Pulang');
        $sheet->setCellValue('F2', 'Jenis Izin');
        $sheet->setCellValue('G2', 'Keterangan');
        $sheet->setCellValue('H2', 'Tanggal Pengajuan');

        $rowNum = 3;
        foreach ($rows as $i => $r) {
            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue('B' . $rowNum, $r->user->name ?? '-');
            $sheet->setCellValue('C' . $rowNum, $r->devision ?? '-');
            $sheet->setCellValue('D' . $rowNum, !empty($r->date) ? $r->date->format('d-m-Y') : '-');
            $sheet->setCellValue('E' . $rowNum, !empty($r->time_from) ? $r->time_from : '-');
            $sheet->setCellValue('F' . $rowNum, $r->type ?? '-');
            $sheet->setCellValue('G' . $rowNum, !empty($r->description) ? $this->Krs->fDecode($r->description) : '-');
            $sheet->setCellValue('H' . $rowNum, !empty($r->created) ? $r->created->format('d-m-Y H:i:s') : '-');
            $rowNum++;
        }
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID) ->setAutoSize(true);
        }

        $styleArray = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $lastRow = $rowNum - 1;
        $sheet->getStyle("A1:H{$lastRow}")
            ->applyFromArray($styleArray);

        // =========================
        // EXPORT
        // =========================
        $writer = new Xlsx($spreadsheet);

        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename =
            'Rekap Izin Pulang-' .
            date('Ymd-His') .
            '.xlsx';

        return $this->response
            ->withType('xlsx')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$filename}\""
            )
            ->withBody($stream);
    }
}
