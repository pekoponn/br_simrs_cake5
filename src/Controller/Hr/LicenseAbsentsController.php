<?php
declare(strict_types=1);

namespace App\Controller\Hr;
use App\Controller\AppController;
use Cake\Chronos\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Laminas\Diactoros\CallbackStream;
use Cake\Core\Configure;

/**
 * LicenseAbsents Controller
 *
 * @property \App\Model\Table\LicenseAbsentsTable $LicenseAbsents
 * @method \App\Model\Entity\LicenseAbsent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LicenseAbsentsController extends AppController
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
        // $this->paginate = [
        //     'contain' => ['Branches'],
        // ];
        // $licenseAbsents = $this->paginate($this->LicenseAbsents);

        // $this->set(compact('licenseAbsents'));

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
            $arrayDevision = array('LicenseAbsents.devision'=>$dataDevisions); 
        } else {
            $arrayDevision = array('LicenseAbsents.applicant'=>$dataId);           
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
            $dataWhere[] = 'DATE(LicenseAbsents.date_from) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '"';
        }

        if (!empty($filterApplicant)) {
            $data['filterApplicant'] = $filterApplicant;
            $dataWhere['Users.name like'] = '%' . $filterApplicant . '%';
        }
        if (!empty($filterDevision)) {
            $data['filterDevision'] = $filterDevision;
            $dataWhere['LicenseAbsents.devision'] = $filterDevision;
        }
        
        // Auth user & rules
        $currentUserId = $dataSession['id']; 
        $rulesString   = $dataSession['rules'];
        $rules         = $this->Krs->_rule($rulesString);
        $canViewAll    = isset($rules['licenseabsents']['viewAll']) ? $rules['licenseabsents']['viewAll'] : 0;
        $canViewDevision = isset($rules['licenseabsents']['viewDevision']) ? $rules['licenseabsents']['viewDevision'] : 0;
        // pr($canViewDevision);

        $dataRow = $this->LicenseAbsents->find('all')->contain(['Users','Mengetahui','Menyetujui'])->order(['DATE(LicenseAbsents.date_from)' => 'DESC', 'Users.name' => 'DESC']);

        if ($canViewAll == '1') {
            // $dataRow->where(['LicenseAbsents.is_create' => $currentUserId]);
        } elseif ($canViewDevision == '1') {
            // $dataDevisionNow = [$dataDevision];
            // $dataPettycashDevision = explode(",", $dataPettyCashDevision);
            // $dataDevisions = array_merge($dataDevisionNow, $dataPettycashDevision);
            // $dataRow->where(['LicenseAbsents.devision IN' => $dataDevisions]);
            $dataTeamIds = array_filter(array_map('trim', explode(',', (string)$dataUserTeam)));
            $dataTeamIds[] = $currentUserId;
            $dataTeamIds = array_unique($dataTeamIds);
            $dataRow->where(['LicenseAbsents.is_create IN' => $dataTeamIds]);
        } else {
             $dataRow->where(['LicenseAbsents.is_create' => $currentUserId]);
        }
        // pr($dataPettycashDevision);
        // pr($dataDevisions);

        $queries = (!empty($dataWhere)) ? $dataRow->where([$dataWhere]) : $dataRow;
        $paginateRow = $this->paginate($queries, ['limit' => '15']);
        $data['dataRows'] = $paginateRow;
        //->toArray()

        $data['filterLink'] = $this->Krs->fEncode($dataWhere);
        $this->set(['dataRows'=>$paginateRow, 'data'=> $data]);

        /*$licenseAbsents = $this->LicenseAbsents->find('all')->contain(['Users','Menyetujui','Mengetahui']);
        $key = $this->request->getQuery('key');
        if ($key) {
            $queries = $licenseAbsents->where(['OR' => ['LicenseAbsents.title like' => '%' . $key . '%', 'LicenseAbsents.description like' => '%' . $key . '%', 'Users.name like' => '%' . $key . '%', $arrayDevision]]);
        } else {
            $queries = $licenseAbsents->order(['LicenseAbsents.id' => 'DESC'])->where($arrayDevision);
        }

        // $this->set('licenseAbsents', $this->paginate($queries, ['limit' => '10']));
        $this->set(['licenseAbsents'=>$this->paginate($queries, ['limit' => '10']), 'data'=> $data]);*/
        
    }

    /**
     * View method
     *
     * @param string|null $id License Absent id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        list($dataId, $dataUserId) = explode('^', $this->Krs->fDecode($id));
        $licenseAbsent = $this->LicenseAbsents->get($dataId, [
            'contain' => ['Users','Mengetahui','Menyetujui'],
        ]);
        $data['dataRows'] = $licenseAbsent;
        $this->set(compact('data'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $licenseAbsent = $this->LicenseAbsents->newEmptyEntity();
        if ($this->request->is('post')) {
            
            $dataRow = $this->request->getData();
            unset($dataRow['files']);  // Remove UploadedFile object
            list($typeName, $typeDay) = explode('^', $dataRow['type']);

            $isUser = $dataRow['is_create'];

            $auditLog = $this->Krs->auditLog("LicenseAbsents", 'N',  $isUser, "LicenseAbsents add");
            $dataAuditLog = array('is_log' => $auditLog);

            // $dataAuditLog['type'] = $typeName;
            // $dataAuditLog['licenseAbsent_days'] = $typeDay;
            $dataAuditLog['type'] = $typeName;
            $dataAuditLog['absent_days'] = $typeDay;

            $dataDateFrom = array('date_from' => $this->Krs->dateTo($dataRow['date_from']));
            $dataDateEnd = array('date_end' => $this->Krs->dateTo($dataRow['date_end']));
            // $dataType = array('type' => $dataRow['type']);
            $dataApplicant = array('applicant' => $isUser);
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

            $licenseAbsent = $this->LicenseAbsents->patchEntity($licenseAbsent, array_merge($dataRow, $dataAuditLog, $dataDateFrom, $dataDateEnd, $dataApplicant, $dataDesc, $fileData));
            // debug($licenseAbsent);
            // die;
            if ($this->LicenseAbsents->save($licenseAbsent)) {
                $pemohon = $this->Users->get($isUser);
                $atasan = $this->Users->find()
                    ->where([
                        "FIND_IN_SET($isUser, user_team)"
                    ])
                    ->first();
                if ($atasan && !empty($atasan->telegram_chat_id)) {
                    $url = 'https://rssby.brgroup.id/hr/license-absents';
                    $pesan =
                        "📢 TIDAK MASUK \n\n" .
                        "👤 Pemohon : {$pemohon->name}\n" .
                        "📅 Tanggal : {$dataRow['date_from']} s/d {$dataRow['date_end']}\n\n" .
                        "Silakan melakukan approval/mengetahui melalui link berikut:\n" .
                        $url;
                    $this->Telegram->sendMessage($atasan->telegram_chat_id, $pesan);
                    $this->Telegram->notifyKnowing('license_absents', $pesan);
                }
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        $this->set(compact('licenseAbsent'));
    }

    /**
     * Edit method
     *
     * @param string|null $id License Absent id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $licenseAbsent = $this->LicenseAbsents->get($id, [
            'contain' => [],
        ]);
        if ($licenseAbsent->approved !== null) {
            $this->Flash->error('Data sudah disetujui, tidak bisa diedit.');
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            unset($dataRow['files']);
            [$typeName, $typeDay] = array_pad(explode('^', (string)($dataRow['type'] ?? ''), 2), 2, null);
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog("LicenseAbsents", $id, $isUser, "LicenseAbsents edit");
            $dataAuditLog = array('is_log' => $auditLog); 
            $dataType = array(
                'type' => $typeName,
                'absent_days' => $typeDay ?? $licenseAbsent->absent_days,
            );
            $dataDateFrom = array('date_from' => $this->Krs->dateTo($dataRow['date_from']));
            $dataDateEnd = array('date_end' => $this->Krs->dateTo($dataRow['date_end']));
            $dataDesc = array('description' => $this->Krs->fEncode($dataRow['description']));
            $fieldName = 'files';
            $file = $this->request->getData($fieldName);
            $fileData = [];
            if (
                is_object($file) &&
                method_exists($file, 'getError') &&
                $file->getError() === 0
            ) {
                if (!empty($licenseAbsent->files)) {
                    $oldPath = WWW_ROOT . 'files' . DS . $licenseAbsent->files;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientFilename());
                $targetPath = WWW_ROOT . 'files' . DS . $filename;
                $file->moveTo($targetPath);
                $fileData[$fieldName] = $filename;
            }

            $licenseAbsent = $this->LicenseAbsents->patchEntity($licenseAbsent, array_merge($dataRow, $dataAuditLog, $dataType, $dataDateFrom, $dataDateEnd, $dataDesc, $fileData));
            if ($this->LicenseAbsents->save($licenseAbsent)) {
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        $this->set(compact('licenseAbsent'));
    }

    /**
     * Delete method
     *
     * @param string|null $id License Absent id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $licenseAbsent = $this->LicenseAbsents->get($id);
        if ($this->LicenseAbsents->delete($licenseAbsent)) {
            $this->Flash->success(__('The license absent has been deleted.'));
        } else {
            $this->Flash->error(__('The license absent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function approve($id = null)
    {
        $licenseAbsent = $this->LicenseAbsents->get($id, [
            'contain' => ['Users'],
        ]);
        if ($licenseAbsent->approved_date !== null) {
            $this->Flash->error('Data ini sudah disetujui sebelumnya.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isApprove = $dataRow['approved'];
            $date = ['approved_date' => new \DateTime()];
            $auditLog = $this->Krs->auditLog("LicenseAbsents", 'N', $isApprove, "LicenseAbsents approve");
            $dataAuditLog = ['is_log' => $auditLog];
            $licenseAbsent = $this->LicenseAbsents->patchEntity($licenseAbsent, array_merge($dataRow, $date, $dataAuditLog));

            if ($this->LicenseAbsents->save($licenseAbsent)) {
                $this->Flash->success('Data berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf, data gagal disimpan. Silakan periksa kembali.');
        }
        // $getUser = $this->Auth->user();
        $users = $this->LicenseAbsents->Users->find('all', ['limit' => 200]);
        $this->set(compact('licenseAbsent', 'users'));
    }

    public function knowing($id = null)
    {
        $licenseAbsent = $this->LicenseAbsents->get($id, [
            'contain' => ['Users'],
        ]);
        if ($licenseAbsent->approved === null) {
            $this->Flash->error('Data belum disetujui, belum bisa diketahui.');
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            // pr($dataRow);
            $isUser = $dataRow['knowing'];
            // $isApprove = $dataRow['knowing'];
            $date = array('knowing_date' => new \DateTime());
            $auditLog = $this->Krs->auditLog("LicenseAbsents", 'N', $isUser, "LicenseAbsents knowing");
            $dataAuditLog = array('is_log' => $auditLog);

            $licenseAbsent = $this->LicenseAbsents->patchEntity($licenseAbsent, array_merge($dataRow, $date, $dataAuditLog));

            // pr($licenseAbsent);
            if ($this->LicenseAbsents->save($licenseAbsent)) {
                $this->Flash->success('Terima kasih, Data berhasil disimpan.');                
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf data gagal disimpan, silakan masukkan data dengan benar!.');
        }
        // $users = $this->LicenseAbsents->Users->find('all', ['limit' => 200]); , 'users' 
        $this->set(compact('licenseAbsent'));
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
        $dataUserTeam = $dataSession['user_team'];

        $filterDateFrom  = $this->request->getQuery('filterDateFrom');
        $filterDateEnd   = $this->request->getQuery('filterDateEnd');
        $filterApplicant = $this->request->getQuery('filterApplicant');
        $filterDevision  = $this->request->getQuery('filterDevision');
        $dataWhere = [];
        if (!empty($filterDateFrom) && !empty($filterDateEnd)) {
            $dateFrom = $this->Krs->dateTo($filterDateFrom);
            $dateEnd  = $this->Krs->dateTo($filterDateEnd);
            $dataWhere[] ='DATE(LicenseAbsents.date_from) BETWEEN "' . $dateFrom .'" AND "' . $dateEnd .'"';
        }
        if (!empty($filterApplicant)) {
            $dataWhere['Users.name like'] ='%' . $filterApplicant . '%';
        }

        if (!empty($filterDevision)) {
            $dataWhere['LicenseAbsents.devision'] = $filterDevision;
        }

        $rulesString = $dataSession['rules'];
        $rules = $this->Krs->_rule($rulesString);

        $canViewAll = isset($rules['licenseabsents']['viewAll']) ? $rules['licenseabsents']['viewAll'] : 0;

        $canViewDevision = isset($rules['licenseabsents']['viewDevision']) ? $rules['licenseabsents']['viewDevision'] : 0;

        $query = $this->LicenseAbsents->find('all')
            ->contain(['Users', 'Mengetahui', 'Menyetujui'])
            ->order([
                'DATE(LicenseAbsents.date_from)' => 'DESC',
                'Users.name' => 'DESC'
            ]);

        if ($canViewAll == '1') {
            // $dataRow->where(['LicenseAbsents.is_create' => $currentUserId]);
        }
        if ($canViewAll == '0' && $canViewDevision == '1') {
            $dataDevisions = !empty($dataUserTeam) ? explode(',', $dataUserTeam) : [];
            $dataDevisions[] = $dataId;
            $dataDevisions = array_unique($dataDevisions);
            $query->where(['LicenseAbsents.is_create IN' => $dataDevisions]);
        } elseif ($canViewAll == '1' && $canViewDevision == '0') {
            // full access
        } else {
            $query->where(['LicenseAbsents.is_create' => $dataId]);
        }
        if (!empty($dataWhere)) {
            $query->where($dataWhere);
        }
        $rows = $query->toArray();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Izin Tidak Masuk');

        $sheet->setCellValue('A1', 'Rekap Izin Tidak Masuk');
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
        $sheet->setCellValue('D2', 'Tanggal Dari');
        $sheet->setCellValue('E2', 'Tanggal Sampai');
        $sheet->setCellValue('F2', 'Jenis Izin');
        $sheet->setCellValue('G2', 'Keterangan');
        $sheet->setCellValue('H2', 'Tanggal Pengajuan');
        $sheet->setCellValue('I2', 'Mengetahui');
        $sheet->setCellValue('J2', 'Menyetujui');

        $rowNum = 3;
        foreach ($rows as $i => $r) {
            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue('B' . $rowNum, $r->user->name ?? '-');
            $sheet->setCellValue('C' . $rowNum, $r->devision ?? '-');
            $sheet->setCellValue('D' . $rowNum, !empty($r->date_from) ? $r->date_from->format('d-m-Y') : '-');
            $sheet->setCellValue('E' . $rowNum, !empty($r->date_end) ? $r->date_end->format('d-m-Y') : '-');
            $sheet->setCellValue('F' . $rowNum, $r->type ?? '-');
            $sheet->setCellValue('G' . $rowNum, !empty($r->description) ? $this->Krs->fDecode($r->description) : '-');
            $sheet->setCellValue('H' . $rowNum, !empty($r->created) ? $r->created->format('d-m-Y H:i:s') : '-');
            $sheet->setCellValue('I' . $rowNum, (!empty($r->mengetahui) ? $r->mengetahui->name : '-') . "\n" . (!empty($r->knowing_date) ? $r->knowing_date->format('d-m-Y') : '-'));
            $sheet->setCellValue('J' . $rowNum, (!empty($r->menyetujui) ? $r->menyetujui->name : '-') . "\n" .(!empty($r->approved_date) ? $r->approved_date->format('d-m-Y') : '-'));
            $rowNum++;
        }
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID) ->setAutoSize(true);
        }

        $styleArray = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $lastRow = $rowNum - 1;
        $sheet->getStyle("A1:J{$lastRow}")
            ->applyFromArray($styleArray);

        // =========================
        // EXPORT
        // =========================
        $writer = new Xlsx($spreadsheet);

        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename =
            'Rekap Tidak Masuk-' .
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
