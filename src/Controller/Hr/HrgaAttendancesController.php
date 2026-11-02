<?php

declare(strict_types=1);

namespace App\Controller\Hr;

use App\Controller\AppController;

use Cake\Utility\Hash;
use Cake\Datasource\ConnectionManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * HrgaAttendances Controller
 *
 * @property \App\Model\Table\HrgaAttendancesTable $HrgaAttendances
 * @method \App\Model\Entity\HrgaAttendance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HrgaAttendancesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $filterDateFrom = $this->request->getQuery('filterDateFrom');
        $filterDateEnd = $this->request->getQuery('filterDateEnd');
        $filterEmployee = $this->request->getQuery('filterEmployee');

        $data['filterDateFrom'] = array();
        $data['filterDateEnd'] = array();
        $data['filterEmployee'] = array();

        $dataWhere = array();
        if (!empty($filterDateFrom) && !empty($filterDateEnd)) {
            $data['filterDateFrom'] = $filterDateFrom;
            $data['filterDateEnd'] = $filterDateEnd;
            $dataWhere[] = 'DATE(HrgaAttendanceLines.start_date) BETWEEN "' . $this->Krs->dateTo($filterDateFrom) . '" AND "' . $this->Krs->dateTo($filterDateEnd) . '"';
        }

        if (!empty($filterEmployee)) {
            $data['filterEmployee'] = $filterEmployee;
            $dataWhere['HrgaEmployees.name like'] = '%' . $filterEmployee . '%';
        }

        $dataRow = $this->HrgaAttendances->HrgaAttendanceLines->find('all')->contain(['HrgaEmployees'])->order(['DATE(HrgaAttendanceLines.start_date)' => 'DESC', 'HrgaEmployees.nip' => 'DESC']);

        $queries = (!empty($dataWhere)) ? $dataRow->where([$dataWhere]) : $dataRow;
        $paginateRow = $this->paginate($queries, ['limit' => '15']);
        $data['dataRows'] = $paginateRow;

        $data['filterLink'] = $this->Krs->fEncode($dataWhere);
        $this->set(['dataRows'=>$paginateRow, 'data'=> $data]);

        /*$attendances = $this->HrgaAttendances->find('all')->contain(['HrgaEmployees']);
        $key = $this->request->getQuery('key');
        if ($key) {
            $queries = $attendances->where(['OR' => ['HrgaAttendances.description like' => '%' . $key . '%', 'HrgaEmployees.name like' => '%' . $key . '%']]);
        } else {
            $queries = $attendances->order(['HrgaAttendances.id' => 'ASC']);
        }
        $this->set('attendances', $this->paginate($queries, ['limit' => '10']));*/
    }

    /**
     * View method
     *
     * @param string|null $id Hrga Attendance id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $hrgaAttendance = $this->HrgaAttendances->get($id, contain: []);

        $this->set(compact('hrgaAttendance'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {

    //     $hrgaAttendance = $this->HrgaAttendances->newEmptyEntity();
    //     if ($this->request->is('post')) {

    //         $dataRow = $this->request->getData();
    //         // debug($this->request->getData());
    //         // die;
    //         $date = $dataRow['date'];
    //         $split = explode(' - ', $date);
    //         $s_date = rtrim($split[0]);
    //         $s_stamp = strtotime(str_replace('/', '-', $s_date));
    //         $start = date('Y-m-d', $s_stamp);
    //         $dataStart = array('start_date' => $start);

    //         $e_date = ltrim($split[1]);
    //         $e_stamp = strtotime(str_replace('/', '-', $e_date));
    //         $end = date('Y-m-d', $e_stamp);
    //         $dataEnd = array('end_date' => $end);

    //         $isUser = $dataRow['is_create'];

    //         $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N',  $isUser, "Hrga Attendances add");
    //         $dataAuditLog = array('is_log' => $auditLog);

    //         // save the original date range as the attendance name (e.g. "20/05/2026 - 21/06/2026")
    //         $datePeriode = isset($dataRow['date']) ? $dataRow['date'] : null;
    //         $dataName = ['name' => $datePeriode];

    //         $patchData = array_merge($dataRow, $dataStart, $dataEnd, $dataName, $dataAuditLog);
    //         $hrgaAttendance = $this->HrgaAttendances->patchEntity($hrgaAttendance, $patchData, ['associated' => ['HrgaAttendanceLines']]);
    //         // pr($hrgaAttendance);
    //         debug($hrgaAttendance); die;
    //         if ($this->HrgaAttendances->save($hrgaAttendance, ['associated' => ['HrgaAttendanceLines']])) {
    //             $this->Flash->success(__('The hrga attendance has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The hrga attendance could not be saved. Please, try again.'));
    //     }

    //     $dataEmployees = $this->HrgaAttendances->HrgaEmployees->find('all')->select(['id', 'pin', 'user_id', 'name', 'no_ktp', 'devisi', 'position'])->where(['is_active'=>'Y'])->order(['name' => 'ASC']);
    //     $dataEmployee = $this->paginate($dataEmployees, ['limit' => '10'])->toArray();
    //     //$dataRows = $paginateRow->toArray();
    //     // $employees = $this->HrgaAttendances->HrgaEmployees->find('list', ['limit' => 200]);
    //     $this->set(compact('hrgaAttendance', 'dataEmployee'));
    // }

    public function add()
    {
        $hrgaAttendance = $this->HrgaAttendances->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
            $dateRange = $dataRow['date'] ?? null;
            $startDate = null;
            $endDate = null;
            if ($dateRange) {
                $split = explode(' - ', $dateRange);
                if (count($split) == 2) {
                    $startDate = date('Y-m-d', strtotime(str_replace('/', '-', trim($split[0]))));
                    $endDate = date('Y-m-d', strtotime(str_replace('/', '-', trim($split[1]))));
                }
            }
            $attendanceData = [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'name' => $dateRange,
                'is_create' => $dataRow['is_create'] ?? null,
                'is_log' => $this->Krs->auditLog(
                    $this->request->getParam('controller'), 
                    'N',  
                    $dataRow['is_create'] ?? null, 
                    "Hrga Attendances add"
                )
            ];
            $attendanceLines = [];
            if (isset($dataRow['hrga_attendance_lines']) && is_array($dataRow['hrga_attendance_lines'])) {
                foreach ($dataRow['hrga_attendance_lines'] as $line) {
                    if (!empty($line['hrga_employee_id'])) {
                        $attendanceLines[] = [
                            'hrga_employee_id' => $line['hrga_employee_id'],
                            'qty' => !empty($line['qty']) ? (int)$line['qty'] : 0,
                            'qty_lateness' => !empty($line['qty_lateness']) ? (int)$line['qty_lateness'] : 0,
                            'start_date' => $startDate,
                            'end_date' => $endDate
                        ];
                    }
                }
            }
            $saveData = array_merge($attendanceData, ['hrga_attendance_lines' => $attendanceLines]);
            $hrgaAttendance = $this->HrgaAttendances->patchEntity(
                $hrgaAttendance, 
                $saveData, 
                ['associated' => ['HrgaAttendanceLines']]
            );
            // debug($hrgaAttendance); die;
            if ($this->HrgaAttendances->save($hrgaAttendance, ['associated' => ['HrgaAttendanceLines']])) {
                $this->Flash->success('Data kehadiran berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error('Data kehadiran gagal disimpan. Silakan coba lagi.');
            debug($hrgaAttendance->getErrors());
        }
        $dataEmployees = $this->HrgaAttendances->HrgaEmployees->find('all')
            ->select(['id', 'pin', 'user_id', 'name', 'no_ktp', 'devisi', 'position'])
            ->where(['is_active' => 'Y'])
            ->order(['name' => 'ASC']);
        $dataEmployee = $this->paginate($dataEmployees, ['limit' => '10'])->toArray();
        $this->set(compact('hrgaAttendance', 'dataEmployee'));
    }

    public function getAbsences()
    {
        $this->autoRender = false;

        $date = $this->request->getQuery('date');

        $split = explode('-', $date);

        $s_date = trim($split[0]);
        $s_stamp = strtotime(str_replace('/', '-', $s_date));
        $start = date('Y-m-d', $s_stamp);

        $e_date = trim($split[1]);
        $e_stamp = strtotime(str_replace('/', '-', $e_date));
        $end = date('Y-m-d', $e_stamp);

        $this->Absences = $this->fetchTable('Absences');

         $attendanceRows = $this->Absences->find()
            ->select([
                'user_id',
                'date'
            ])
            ->where([
                'date >=' => $start,
                'date <=' => $end,
                'inout_mode' => 'I'
            ])
            ->group([
                'user_id',
                'date'
            ])
            ->enableHydration(false)
            ->toArray();

        $attendanceMap = [];

        foreach ($attendanceRows as $row) {
            if (!isset($attendanceMap[$row['user_id']])) {
                $attendanceMap[$row['user_id']] = 0;
            }

            $attendanceMap[$row['user_id']]++;
        }

        // TERLAMBAT
        $lateRows = $this->Absences->find()
            ->select([
                'user_id',
                'date'
            ])
            ->where([
                'date >=' => $start,
                'date <=' => $end,
                'inout_mode' => 'I',
                'time_in >' => '08:00:00' // sesuaikan jam masuk kantor
            ])
            ->group([
                'user_id',
                'date'
            ])
            ->enableHydration(false)
            ->toArray();

        $lateMap = [];
        foreach ($lateRows as $row) {
            if (!isset($lateMap[$row['user_id']])) {
                $lateMap[$row['user_id']] = 0;
            }
            $lateMap[$row['user_id']]++;
        }
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'attendance' => $attendanceMap,
                'late' => $lateMap
            ]));
    }

    /**
     * Edit method
     *
     * @param string|null $id Hrga Attendance id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit_ori($id = null)
    {
        $id = (int)$id;
        try {
            $hrgaAttendance = $this->HrgaAttendances->get($id, contain: ['HrgaAttendanceLines' => ['HrgaEmployees']]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Record tidak ditemukan.'));
            return $this->redirect(['action' => 'index']);
        }

        // compute start/end from lines (min start_date, max end_date)
        $start = null;
        $end = null;
        foreach ($hrgaAttendance->hrga_attendance_lines as $line) {
            if (!empty($line->start_date)) {
                if ($start === null || $line->start_date < $start) {
                    $start = $line->start_date;
                }
            }
            if (!empty($line->end_date)) {
                if ($end === null || $line->end_date > $end) {
                    $end = $line->end_date;
                }
            }
        }

        $this->set(compact('hrgaAttendance', 'start', 'end'));
        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();

            $dataRow['start_date'] = FrozenDate::createFromFormat('d/m/Y', $s_date);
            $dataRow['end_date']   = FrozenDate::createFromFormat('d/m/Y', $e_date);

            // if (!empty($dataRow['date'])) {
            //     [$s_date, $e_date] = array_map('trim', explode('-', $dataRow['date']));

            //     $dataRow['start_date'] = FrozenDate::createFromFormat('d/m/Y', $s_date);
            //     $dataRow['end_date']   = FrozenDate::createFromFormat('d/m/Y', $e_date);
            // }

            $auditLog = $this->Krs->auditLog(
                $this->request->getParam('controller'),
                $id,
                $dataRow['is_update'],
                "Hrga Attendances edit"
            );
            $dataRow['is_log'] = $auditLog;

            $hrgaAttendance = $this->HrgaAttendances->patchEntity($hrgaAttendance, $dataRow);
            if ($this->HrgaAttendances->save($hrgaAttendance)) {
                $this->Flash->success(__('The hrga attendance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga attendance could not be saved. Please, try again.'));
        }
        $employees = $this->HrgaAttendances->HrgaEmployees->find('all')->where(['HrgaEmployees.id' => $hrgaAttendance->hrga_employee_id])->first();        
        $this->HrgaHolidays = $this->fetchTable('HrgaHolidays');
        // $getHoliday = $this->HrgaHolidays->find('all')->where(['date BETWEEN "' . date_format($hrgaAttendance->start_date, 'Y-m-d') . '" AND "' . date_format($hrgaAttendance->end_date, 'Y-m-d') . '"'])->toArray();
        $this->set(compact('hrgaAttendance', 'employees'/*, 'getHoliday'*/));
    }

    /**
     * Delete method
     *
     * @param string|null $id Hrga Attendance id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hrgaAttendance = $this->HrgaAttendances->get($id);
        if ($this->HrgaAttendances->delete($hrgaAttendance)) {
            $this->Flash->success(__('The hrga attendance has been deleted.'));
        } else {
            $this->Flash->error(__('The hrga attendance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getemployee()
    {
        $this->autoRender = false;
        $this->HrgaEmployees = $this->fetchTable('HrgaEmployees');

        $search = $this->request->getQuery('search');

        $employee = $this->HrgaEmployees->find('all')->where(['OR' => ['name like' => '%' . $search . '%', 'nip like' => '%' . $search . '%']]);

        $result = array();
        foreach ($employee as $key => $data) {
            $result[$key]['id'] = (int) $data['id'];
            $result[$key]['text'] = '(' . $data['nip'] . ') - ' . $data['name'];
        }
        $employee = $result;

        echo json_encode($employee);
    }

    public function getdatetotal()
    {
        $date = $this->request->getQuery('date');
        $split = explode('-', $date);
        $s_date = rtrim($split[0]);
        $s_stamp = strtotime(str_replace('/', '-', $s_date));
        $start = date('Y-m-d', $s_stamp);

        $e_date = ltrim($split[1]);
        $e_stamp = strtotime(str_replace('/', '-', $e_date));
        $end = date('Y-m-d', $e_stamp);

        $div = abs($e_stamp - $s_stamp);
        $totalDays = $div / 86400;
        $totalDays = intval($totalDays);

        $daterange = $this->GetDays($s_stamp, $e_stamp);

        $this->HrgaHolidays = $this->fetchTable('HrgaHolidays');
        $getHoliday = $this->HrgaHolidays->find('all')->where(['date BETWEEN "' . $start . '" AND "' . $end . '"'])->order(['HrgaHolidays.date' => 'ASC'])->toArray();

        $dataArr = array();
        foreach ($daterange as $index => $value) {
            if (date('l', strtotime($value)) !== 'Sunday' && date('l', strtotime($value)) !== 'Saturday') {
                $dataArr[] = $value;
            }
        }

        $tot = count($dataArr) - count($getHoliday);

        return $this->response->withType("application/json")->withStringBody(json_encode([$tot, $getHoliday, $dataArr]));
    }

    public function GetDays($sStartDate, $sEndDate)
    {
        $array = array();
        for (
            $currentDate = $sStartDate;
            $currentDate <= $sEndDate;
            $currentDate += (86400)
        ) {

            $Store = date('Y-m-d', $currentDate);
            $array[] = $Store;
        }

        return $array;
    }

    //Rekap Invoice Excel
    public function importExcel($dataLink='')
    {
        $this->HrgaEmployees = $this->fetchTable('HrgaEmployees');
        //Memanggil data Karyawan
        $rowEmployee = $this->HrgaEmployees->find('all')->contain([])->where(['is_active'=>'Y'])->order(['nip'=>'ASC'])->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set default font 
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        $spreadsheet->setActiveSheetIndex(0);
        // for($a=0;$a<16;$a++){
        //     $_chr = chr(65+$a);
        //     $sheet->getColumnDimension($_chr)->setAutoSize(true);
        // }

        $styleArray = [
            'font'  => [
                'bold'  => true,
                'size'  => 11,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'argb' => 'FFEFEFEF',
                ],

            ],
        ]; 

        $styleArrayInfo = [
            'font'  => [
                'color' => ['argb' => 'FF757575'],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'argb' => 'FFEFEFEF',
                ],
            ],
        ]; 

        $sheet->getStyle('A1:F1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:F2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        // Add some data, resembling some different data types  
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('A2', 'Jangan mengubah data dikolom ini, sebagai informasi');
        $sheet->setCellValue('B1', 'Nama Karyawan');
        $sheet->setCellValue('B2', 'Jangan mengubah data dikolom ini, sebagai informasi');
        $sheet->setCellValue('C1', 'NIP');
        $sheet->setCellValue('C2', 'Jangan mengubah data dikolom ini, sebagai informasi');
        $sheet->setCellValue('D1', 'Jumlah Kehadiran');
        $sheet->setCellValue('D2', 'Masukkan data Jumlah Kehadiran pada kolom ini');
        $sheet->setCellValue('E1', 'Jumlah Keterlambatan');
        $sheet->setCellValue('E2', 'Masukkan data Jumlah Keterlambatan pada kolom ini');
        $sheet->setCellValue('F1', 'Jumlah Lembur');
        $sheet->setCellValue('F2', 'Masukkan data Jumlah Lembur pada kolom ini');

        $row = 3;
        foreach ($rowEmployee as $dataRowKey => $dataRow) {
            $sheet->setCellValue('A' . $row, $dataRow->id);
            $sheet->setCellValue('B' . $row, $dataRow->name);
            $sheet->setCellValue('C' . $row, $dataRow->nip);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Rekap_Kehadiran-' . date('ymd');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);

        // $this->set(compact('data'));
    }

    public function importExcelSave($condition=null)
    {
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            // $triataAccChartOfAccount = $this->TriataAccChartOfAccounts->newEmptyEntity();
            // pr($condition);
            if($condition=="save") {
                $maxFile = "502400";

                $dataRow = $this->request->getData();
                $isUser = $dataRow['user_id'];
                $datePeriode = $dataRow['datePeriode'];

                $dateSplit = explode('-', $datePeriode);
                $startDate = rtrim($dateSplit[0]);
                $startDateStamp = strtotime(str_replace('/', '-', $startDate));
                $dataDateStart = date('Y-m-d', $startDateStamp);
                //$dataDateStart = array('start_date' => $dataDateStarts);

                $endDate = ltrim($dateSplit[1]);
                $endDateStamp = strtotime(str_replace('/', '-', $endDate));
                $dataDateEnd = date('Y-m-d', $endDateStamp);
                //$dataDateEnd = array('end_date' => $dataDateEnds);

                // $filename = $dataRow['filename'];
                $files = $this->request->getUploadedFiles();
                $fileNameUpload = $files['filename']->getClientFileName();

                if(!empty($fileNameUpload)) {
                    $files['filename']->getStream();
                    $sizeFile = $files['filename']->getSize();
                    
                    if($maxFile>=$sizeFile){
                        // Mengambil data pada form
                        $myname = $this->request->getData()['filename']->getClientFileName();
                        $myext = substr(strchr($myname, "."), 1);
                        $mypath = "upload_files/".$myname; //Path untuk menaruh file yg akan diupload

                        // Kodisi untuk menaruh file upload
                        $files['filename']->moveTo(WWW_ROOT.$mypath);
                        // Kodisi pemisahan extention excel
                        if ($myext == 'xls') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                        } elseif($myext == 'xlsx') {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }

                        $spreadsheet = $reader->load(WWW_ROOT.$mypath); // Membaca file yg sudah diupload
                        $sheets = $spreadsheet->getActiveSheet()->toArray(); // Membaca data dan membuat menjadi array

                        $hrgaAttendances = $this->HrgaAttendances->newEmptyEntity();
                        // $dataName = $dataDateStart.'-'.$dataDateStart;
                        $dataUserId = array('is_create' => $isUser);
                        $dataName = array('name' => $datePeriode);
                        $dataAuditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Import excel");
                        $dataIsLog = array('is_log' => $dataAuditLog);

                        $hrgaAttendances = $this->HrgaAttendances->patchEntity($hrgaAttendances, array_merge($dataUserId, $dataName, $dataIsLog));
                        // pr($hrgaAtendances);
                        if ($this->HrgaAttendances->save($hrgaAttendances)) {
                            $hrgaAttendanceId = $hrgaAttendances->id;

                            $this->HrgaAttendanceLines = $this->fetchTable('HrgaAttendanceLines');

                            $sheet = array_splice($sheets, 1);
                            $dataSave = array();
                            foreach ($sheet as $keys => $excel){
                                if ($keys == 0) {
                                    continue;
                                }

                                if(!empty($excel[0]) && !empty($excel[3])) {
                                    $checkData = $this->HrgaAttendanceLines->find()->where(['hrga_employee_id' => $excel[0], 'start_date' => $dataDateStart, 'end_date' => $dataDateEnd])->count();

                                    if($checkData==0) {
                                        $auditLog = $this->Krs->auditLog('HrgaAttendanceLines', 'N', $isUser, "Import excel");

                                        $dataSave = $this->HrgaAttendanceLines->newEmptyEntity();
                                        $dataSave->hrga_attendance_id = $hrgaAttendanceId;
                                        $dataSave->hrga_employee_id = $excel[0];
                                        $dataSave->qty = $excel[3];
                                        $dataSave->qty_lateness = (empty($excel[4])) ? 0: $excel[4];
                                        $dataSave->qty_overtime = (empty($excel[5])) ? 0: $excel[5];
                                        $dataSave->start_date = $dataDateStart;
                                        $dataSave->end_date = $dataDateEnd;
                                        $dataSave->is_create = $isUser;
                                        $dataSave->is_log = $auditLog;

                                        $this->HrgaAttendanceLines->save($dataSave, array('callbacks' => false));
                                    }
                                    //pr($dataSave);


                                }

                            }

                            $this->Flash->success(__('Terima kasih, data Upload berhasil disimpan.'));
                            return $this->redirect(['action' => 'index']);
                        }
                        // return $this->redirect(['action' => 'dataBalanceExportImport']);

                    }
                } else {
                    $this->Flash->error(__('Maaf data Upload tidak dapat disimpan, silakan coba kembali.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }

    public function edit()
    {
        if ($this->request->is(['post', 'put'])) {
            $rows = $this->request->getData('rows');

            if (!empty($rows)) {
                foreach ($rows as $row) {
                    if (empty($row['id'])) {
                        continue;
                    }

                    $line = $this->HrgaAttendances->HrgaAttendanceLines->get($row['id']);

                    $line->qty = (int)$row['qty'];
                    $line->qty_lateness = (int)$row['qty_lateness'];
                    $line->qty_overtime = (int)$row['qty_overtime'];

                    $this->HrgaAttendances->HrgaAttendanceLines->save($line);
                }

                $this->Flash->success('Data kehadiran berhasil disimpan.');
            }
        }

        return $this->redirect([
            'action' => 'index',
            '?' => $this->request->getQuery()
        ]);
    }

}
