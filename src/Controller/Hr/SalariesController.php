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
 * Salaries Controller
 *
 * @property \App\Model\Table\SalariesTable $Salaries
 * @method \App\Model\Entity\Salary[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalariesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $filterUnitBusiness = $this->request->getQuery('filterUnitBusiness');
        $filterEmployee = $this->request->getQuery('filterEmployee');

        $data['filterUnitBusiness'] = array();
        $data['filterEmployee'] = array();

        $dataWhere = array();
        if (!empty($filterEmployee)) {
            $data['filterEmployee'] = $filterEmployee;
            $dataWhere['HrgaEmployees.name like'] = '%' . $filterEmployee . '%';
        }

        if (!empty($filterUnitBusiness)) {
            $data['filterUnitBusiness'] = $filterUnitBusiness;
            $dataWhere['HrgaEmployees.business_unit like'] = '%' . $filterUnitBusiness . '%';
        }

        $dataRow = $this->Salaries->find('all')->contain(['HrgaEmployees'])->order(['HrgaEmployees.nip' => 'DESC']);

        $queries = (!empty($dataWhere)) ? $dataRow->where([$dataWhere]) : $dataRow;
        $paginateRow = $this->paginate($queries, ['limit' => '15']);
        $data['dataRows'] = $paginateRow;

        $data['filterLink'] = $this->Krs->fEncode($dataWhere);
        $this->set(['dataRows'=>$paginateRow, 'data'=> $data]);


        /*$salaries = $this->Salaries->find('all')->contain(['HrgaEmployees'])->order(['HrgaEmployees.nip' => 'Desc']);

        $nip = $this->request->getQuery('filternip');
        $name = $this->request->getQuery('filtername');
        $branch = $this->request->getQuery('filterbranch');
        $unit = $this->request->getQuery('filterunit');
        $kepegawaian = $this->request->getQuery('filterkepegawaian');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($nip)) {
            $dataWhere['Salaries.nip like'] = '%' . $nip . '%';
        }
        if (!empty($name)) {
            $dataWhere['Salaries.name like'] = '%' . $name . '%';
        }
        if (!empty($branch)) {
            $dataWhere['Salaries.branch like'] = '%' . $branch . '%';
        }
        if (!empty($unit)) {
            $dataWhere['Salaries.business_unit like'] = '%' . $unit . '%';
        }
        if (!empty($kepegawaian)) {
            $dataWhere['Salaries.status like'] = '%' . $kepegawaian . '%';
        }
        if (!empty($status)) {
            $dataWhere['Salaries.is_active like'] = '%' . $status . '%';
        }*/

        // $queries = (!empty($dataWhere)) ? $salaries->where([$dataWhere]): $salaries;       
        // $this->set(['salaries' => $this->paginate($queries, ['limit' => '10'])]);





        /*$this->paginate = [
            'contain' => ['Employees'],
        ];
        $salaries = $this->paginate($this->Salaries);

        $this->set(compact('salaries'));*/
    }

    /**
     * View method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $salary = $this->Salaries->get($id, [
            'contain' => ['HrgaEmployees'],
        ]);

        $this->set(compact('salary'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $salary = $this->Salaries->newEmptyEntity();
        if ($this->request->is('post')) {
            $dataRow = $this->request->getData();
        
            $isUser = $dataRow['is_create'];
            $dataRow['hrga_employee_id'] = !empty($dataRow['hrga_employee_id']) ? (int)$dataRow['hrga_employee_id'] : null;
            $dataRow['gaji_pokok'] = !empty($dataRow['gaji_pokok']) ? $this->Krs->nom2Dec($dataRow['gaji_pokok']) : 0;
            $dataRow['tunjangan_harian'] = !empty($dataRow['tunjangan_harian']) ? $this->Krs->nom2Dec($dataRow['tunjangan_harian']) : 0;
            $dataRow['tunjangan_jabatan'] = !empty($dataRow['tunjangan_jabatan']) ? $this->Krs->nom2Dec($dataRow['tunjangan_jabatan']) : 0;
            $dataRow['tunjangan_makan'] = !empty($dataRow['tunjangan_makan']) ? $this->Krs->nom2Dec($dataRow['tunjangan_makan']) : 0;
            $dataRow['tunjangan_produktifitas'] = !empty($dataRow['tunjangan_produktifitas']) ? $this->Krs->nom2Dec($dataRow['tunjangan_produktifitas']) : 0;
            $dataRow['tunjangan_struktural'] = !empty($dataRow['tunjangan_struktural']) ? $this->Krs->nom2Dec($dataRow['tunjangan_struktural']) : 0;
            $dataRow['bpjs_kesehatan'] = !empty($dataRow['bpjs_kesehatan']) ? $this->Krs->nom2Dec($dataRow['bpjs_kesehatan']) : 0;
            $dataRow['bpjs_ketenagakerjaan'] = !empty($dataRow['bpjs_ketenagakerjaan']) ? $this->Krs->nom2Dec($dataRow['bpjs_ketenagakerjaan']) : 0;
            $dataRow['bpjs_pensiun'] = !empty($dataRow['bpjs_pensiun']) ? $this->Krs->nom2Dec($dataRow['bpjs_pensiun']) : 0;
            $dataRow['total_gaji'] = !empty($dataRow['total_gaji']) ? $this->Krs->nom2Dec($dataRow['total_gaji']) : 0;

            // Audit log
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Add");
            $dataRow['is_log'] = $auditLog;
            $dataRow['is_create'] = $isUser;
            $dataRow['created'] = date('Y-m-d H:i:s');

            $salary = $this->Salaries->patchEntity($salary, $dataRow);
            if ($this->Salaries->save($salary)) {
                $this->Flash->success(__('The salary has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salary could not be saved. Please, try again.'));
        }
        $hrgaEmployees = $this->Salaries->HrgaEmployees->find('list', ['limit' => 200]);
        $this->set(compact('salary', 'hrgaEmployees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salary = $this->Salaries->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $this->Authentication->getIdentity()->id;
            $dataRow['gaji_pokok'] = !empty($dataRow['gaji_pokok']) ? $this->Krs->nom2Dec($dataRow['gaji_pokok']) : 0;
            $dataRow['tunjangan_harian'] = !empty($dataRow['tunjangan_harian']) ? $this->Krs->nom2Dec($dataRow['tunjangan_harian']) : 0;
            $dataRow['tunjangan_jabatan'] = !empty($dataRow['tunjangan_jabatan']) ? $this->Krs->nom2Dec($dataRow['tunjangan_jabatan']) : 0;
            $dataRow['tunjangan_makan'] = !empty($dataRow['tunjangan_makan']) ? $this->Krs->nom2Dec($dataRow['tunjangan_makan']) : 0;
            $dataRow['tunjangan_produktifitas'] = !empty($dataRow['tunjangan_produktifitas']) ? $this->Krs->nom2Dec($dataRow['tunjangan_produktifitas']) : 0;
            $dataRow['tunjangan_struktural'] = !empty($dataRow['tunjangan_struktural']) ? $this->Krs->nom2Dec($dataRow['tunjangan_struktural']) : 0;
            
            $auditLog = $this->Krs->auditLog("Salaries", 'N', $this->request->getParam('controller'),  $isUser, "Salaries edit");
            // $dataRow = array('is_log' => $auditLog);

            $dataRow['is_log'] = $auditLog;
            $dataRow['is_update'] = $isUser;
            $dataRow['modified'] = date('Y-m-d H:i:s');
            // debug($dataRow);
            // die;

            $salary = $this->Salaries->patchEntity($salary, $dataRow);
            // debug($salary->getErrors());
            // debug($salary->toArray());
            // die;
            if ($this->Salaries->save($salary)) {
                $this->Flash->success(__('The salary has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salary could not be saved. Please, try again.'));
        }
        $hrgaEmployees = $this->Salaries->HrgaEmployees->find('list', ['limit' => 200]);
        $this->set(compact('salary', 'hrgaEmployees'));
    }

    public function editbug($id = null)
    {
        $salary = $this->Salaries->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            /** ===============================
             * 1. DEBUG DATA REQUEST MENTAH
             * =============================== */
            $dataRow = $this->request->getData();

            debug('===== RAW REQUEST DATA =====');
            debug($dataRow);

            /** ===============================
             * 2. USER UPDATE
             * =============================== */
            $isUser = $this->Authentication->getIdentity()->id ?? 0;
            $dataRow['is_update'] = $isUser;

            /** ===============================
             * 3. CAST & NORMALISASI DATA
             * =============================== */

            // ID (INT)
            $dataRow['hrga_employee_id'] = !empty($dataRow['hrga_employee_id'])
                ? (int)$dataRow['hrga_employee_id']
                : null;

            // DECIMAL FIELDS
            $decimalFields = [
                'gaji_pokok',
                'tunjangan_harian',
                'tunjangan_jabatan',
                'tunjangan_makan',
                'tunjangan_produktifitas',
                'tunjangan_struktural',
                // 'bpjs_kesehatan',
                // 'bpjs_ketenagakerjaan',
                // 'bpjs_pensiun',
            ];

            foreach ($decimalFields as $field) {
                // Jangan cast ke float — simpan string numerik dari nom2Dec untuk DECIMAL DB
                $dataRow[$field] = isset($dataRow[$field]) && $dataRow[$field] !== ''
                    ? (string)$this->Krs->nom2Dec($dataRow[$field])
                    : '0.00';
            }

            /** ===============================
             * 4. DEBUG SETELAH KONVERSI
             * =============================== */
            debug('===== AFTER CASTING =====');

            $checkFields = array_merge(['hrga_employee_id'], $decimalFields);

            foreach ($checkFields as $field) {
                debug([
                    'field' => $field,
                    'value' => $dataRow[$field],
                    'type'  => gettype($dataRow[$field]),
                ]);
            }

            /** ===============================
             * 5. AUDIT LOG
             * =============================== */
            $auditLog = $this->Krs->auditLog(
                $this->request->getParam('controller'),
                'U',
                $isUser,
                'Edit'
            );

            $dataRow['is_log'] = $auditLog;
            $dataRow['modified'] = date('Y-m-d H:i:s');

            /** ===============================
             * 6. PATCH ENTITY
             * =============================== */
            $salary = $this->Salaries->patchEntity($salary, $dataRow);

            /** ===============================
             * 7. DEBUG ENTITY
             * =============================== */
            debug('===== ENTITY ERRORS =====');
            debug($salary->getErrors());

            debug('===== ENTITY DATA =====');
            debug($salary->toArray());

            die; // ⛔ STOP di sini untuk lihat hasil debug

            /** ===============================
             * 8. SAVE
             * =============================== */
            if ($this->Salaries->save($salary)) {
                $this->Flash->success(__('The salary has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The salary could not be saved. Please, try again.'));
        }

        $hrgaEmployees = $this->Salaries->HrgaEmployees->find('list', ['limit' => 200]);
        $this->set(compact('salary', 'hrgaEmployees'));
    }

    public function editcc($id = null)
    {
        // Ambil data salary berdasarkan ID
        $salary = $this->Salaries->get($id, [
            'contain' => [],
        ]);

        // Ambil data request
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();

            /** ===============================
             * CAST HRGA EMPLOYEE ID
             * =============================== */
            $dataRow['hrga_employee_id'] = isset($dataRow['hrga_employee_id']) && is_numeric($dataRow['hrga_employee_id'])
                ? (int)$dataRow['hrga_employee_id']
                : 0; // default 0 karena NOT NULL

            /** ===============================
             * CAST USER ID (nullable)
             * =============================== */
            $dataRow['user_id'] = isset($dataRow['user_id']) && is_numeric($dataRow['user_id'])
                ? (int)$dataRow['user_id']
                : null;

            /** ===============================
             * CAST is_update
             * =============================== */
            $currentUserId = $this->Authentication->getIdentity()->id ?? 0;
            $dataRow['is_update'] = (int)$currentUserId;

            /** ===============================
             * CAST NUMERIC FIELDS KE FLOAT
             * =============================== */
            $decimalFields = [
                'gaji_pokok',
                'tunjangan_harian',
                'tunjangan_jabatan',
                'tunjangan_makan',
                'tunjangan_produktifitas',
                'tunjangan_struktural',
                'bpjs_kesehatan',
                'bpjs_ketenagakerjaan',
                'bpjs_pensiun',
            ];

            foreach ($decimalFields as $field) {
                $dataRow[$field] = isset($dataRow[$field]) && $dataRow[$field] !== ''
                    ? (float)$this->Krs->nom2Dec($dataRow[$field])
                    : 0.0;
            }

            /** ===============================
             * AUDIT LOG
             * =============================== */
            $auditLog = $this->Krs->auditLog(
                $this->request->getParam('controller'),
                'U',
                $currentUserId,
                'Edit'
            );
            $dataRow['is_log'] = !empty($auditLog) ? (int)$auditLog : 0;
            $dataRow['modified'] = date('Y-m-d H:i:s');

            /** ===============================
             * DEBUG DATA SEBELUM PATCH ENTITY
             * =============================== */
            debug('===== DATA RAW BEFORE PATCH =====');
            debug($dataRow);

            /** ===============================
             * PATCH ENTITY MANUAL
             * =============================== */
            $salary = $this->Salaries->patchEntity($salary, $dataRow);

            debug('===== ENTITY ERRORS =====');
            debug($salary->getErrors());
            die; // Hentikan sementara untuk debug

            /** ===============================
             * SAVE
             * =============================== */
            if ($this->Salaries->save($salary)) {
                $this->Flash->success(__('The salary has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The salary could not be saved. Please, try again.'));
        }

        /** ===============================
         * LIST HRGA EMPLOYEES UNTUK DROPDOWN
         * =============================== */
        $hrgaEmployees = $this->Salaries->HrgaEmployees->find('list', ['limit' => 200]);
        $this->set(compact('salary', 'hrgaEmployees'));
    }



    // public function edit($id = null)
    // {
    //     $salary = $this->Salaries->get($id, [
    //         'contain' => [],
    //     ]);

    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $dataRow = $this->request->getData();

    //         // remove any debug/die here (they cause headers already sent)
    //         // automatic sanitization using table schema
    //         $schema = $this->Salaries->getSchema();
    //         foreach ($dataRow as $field => $value) {
    //             // ignore display-only fields
    //             if (substr($field, -8) === '_display') {
    //                 // if corresponding real field exists and value present, map it
    //                 $real = substr($field, 0, -8);
    //                 if ($schema->hasColumn($real)) {
    //                     $dataRow[$real] = $value;
    //                 }
    //                 unset($dataRow[$field]);
    //                 continue;
    //             }

    //             if (!$schema->hasColumn($field)) {
    //                 continue;
    //             }

    //             $type = $schema->getColumnType($field);
    //             if ($type === 'integer') {
    //                 // keep only digits and cast to int (null allowed if empty)
    //                 $digits = preg_replace('/\D+/', '', (string)$value);
    //                 $dataRow[$field] = $digits === '' ? null : (int)$digits;
    //             } elseif ($type === 'float' || $type === 'decimal' || $type === 'biginteger') {
    //                 // use existing nom2Dec to clean localized formats like "4.200.000,00"
    //                 $clean = $this->Krs->nom2Dec($value);
    //                 $dataRow[$field] = is_numeric($clean) ? (float)$clean : 0;
    //             } else {
    //                 // leave as-is for other types (string, datetime, etc.)
    //                 $dataRow[$field] = $value;
    //             }
    //         }

    //         // replace parsed body so patchEntity sees cleaned values
    //         $this->request = $this->request->withParsedBody($dataRow);

    //         // continue with audit log / patchEntity / save...
    //         $isUser = $dataRow['is_update'] ?? $dataRow['is_create'] ?? $dataRow['user_id'] ?? 0;
    //         $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'U', $isUser, "Edit");
    //         $dataRow['is_log'] = $auditLog;
    //         $dataRow['is_update'] = $isUser;
    //         $dataRow['modified'] = date('Y-m-d H:i:s');

    //         $salary = $this->Salaries->patchEntity($salary, $dataRow);
    //         debug($salary);
    //         die;

    //         if ($this->Salaries->save($salary)) {
    //             $this->Flash->success(__('The salary has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The salary could not be saved. Please, try again.'));
    //     }
    //     $hrgaEmployees = $this->Salaries->HrgaEmployees->find('list', ['limit' => 200]);
    //     $this->set(compact('salary', 'hrgaEmployees'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salary = $this->Salaries->get($id);
        if ($this->Salaries->delete($salary)) {
            $this->Flash->success(__('The salary has been deleted.'));
        } else {
            $this->Flash->error(__('The salary could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

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
        /*for($a=0;$a<16;$a++){
            $_chr = chr(65+$a);
            $sheet->getColumnDimension($_chr)->setAutoSize(true);
        }*/

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

        $sheet->getStyle('A1:L1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:L2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        // Add some data, resembling some different data types  
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('A2', 'Jangan mengubah data dikolom ini, sebagai informasi');
        $sheet->setCellValue('B1', 'Nama Karyawan');
        $sheet->setCellValue('B2', 'Jangan mengubah data dikolom ini, sebagai informasi');
        $sheet->setCellValue('C1', 'NIP');
        $sheet->setCellValue('C2', 'Jangan mengubah data dikolom ini, sebagai informasi');
        $sheet->setCellValue('D1', 'Gaji Pokok');
        $sheet->setCellValue('D2', 'Masukkan data Gaji Pokok pada kolom ini');
        $sheet->setCellValue('E1', 'Tunjangan Harian');
        $sheet->setCellValue('E2', 'Masukkan data Tunjangan Harian pada kolom ini');
        $sheet->setCellValue('F1', 'Tunjangan Jabatan');
        $sheet->setCellValue('F2', 'Masukkan data Tunjangan Jabatan pada kolom ini');
        $sheet->setCellValue('G1', 'Tunjangan Makan');
        $sheet->setCellValue('G2', 'Masukkan data Tunjangan Makan pada kolom ini');
        $sheet->setCellValue('H1', 'Tunjangan Produktifitas');
        $sheet->setCellValue('H2', 'Masukkan data Tunjangan Produktifitas pada kolom ini');
        $sheet->setCellValue('I1', 'Tunjangan Struktural');
        $sheet->setCellValue('I2', 'Masukkan data Tunjangan Struktural pada kolom ini');
        // $sheet->setCellValue('J1', 'BPJS Kesehatan');
        // $sheet->setCellValue('J2', 'Masukkan data BPJS Kesehatan pada kolom ini');
        // $sheet->setCellValue('K1', 'BPJS Ketenagakerjaan');
        // $sheet->setCellValue('K2', 'Masukkan data BPJS Ketenagakerjaan pada kolom ini');
        // $sheet->setCellValue('L1', 'BPJS Pensiun');
        // $sheet->setCellValue('L2', 'Masukkan data BPJS Pensiun pada kolom ini');


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
        $filename = 'Rekap_Gaji-' . date('ymd');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);

        // $this->set(compact('data'));
    }

    public function importExcelSave($condition=null)
    {
        // $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            // $triataAccChartOfAccount = $this->TriataAccChartOfAccounts->newEmptyEntity();
            // pr($condition);
            if($condition=="save") {
                $maxFile = "502400";

                $dataRow = $this->request->getData();
                $isUser = $dataRow['user_id'];
                /*$datePeriode = $dataRow['datePeriode'];

                $dateSplit = explode('-', $datePeriode);
                $startDate = rtrim($dateSplit[0]);
                $startDateStamp = strtotime(str_replace('/', '-', $startDate));
                $dataDateStart = date('Y-m-d', $startDateStamp);
                //$dataDateStart = array('start_date' => $dataDateStarts);

                $endDate = ltrim($dateSplit[1]);
                $endDateStamp = strtotime(str_replace('/', '-', $endDate));
                $dataDateEnd = date('Y-m-d', $endDateStamp);*/
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
                        $mypath = "upload/imports/".$myname; //Path untuk menaruh file yg akan diupload

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

                        $sheet = array_splice($sheets, 1);
                        $dataSave = array();
                        foreach ($sheet as $keys => $excel){
                            if ($keys == 0) {
                                continue;
                            }

                            if(!empty($excel[0]) && !empty($excel[3])) {
                                $checkData = $this->Salaries->find()->where(['hrga_employee_id' => $excel[0]])->count();

                                if($checkData==0) {
                                    $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "Import excel");

                                    $dataSave = $this->Salaries->newEmptyEntity();
                                    $dataSave->hrga_employee_id = $excel[0];
                                    $dataSave->gaji_pokok = $excel[3];
                                    $dataSave->tujungan_harian = (empty($excel[4])) ? 0: $excel[4];
                                    $dataSave->tunjangan_jabatan = (empty($excel[5])) ? 0: $excel[5];
                                    $dataSave->tunjangan_makan = (empty($excel[6])) ? 0: $excel[6];
                                    $dataSave->tunjangan_produktifitas = (empty($excel[7])) ? 0: $excel[7];
                                    $dataSave->tunjangan_struktural = (empty($excel[8])) ? 0: $excel[8];
                                    // $dataSave->bpjs_kesehatan = (empty($excel[9])) ? 0: $excel[9];
                                    // $dataSave->bpjs_ketenagakerjaan = (empty($excel[10])) ? 0: $excel[10];
                                    // $dataSave->bpjs_pensiun = (empty($excel[11])) ? 0: $excel[11];
                                    $dataSave->is_create = $isUser;
                                    $dataSave->is_log = $auditLog;

                                    $this->Salaries->save($dataSave, array('callbacks' => false));
                                }
                                // pr($dataSave);

                            }

                        }

                        $this->Flash->success(__('Terima kasih, data Upload berhasil disimpan.'));
                        return $this->redirect(['action' => 'index']);
                        // return $this->redirect(['action' => 'dataBalanceExportImport']);

                    }
                } else {
                    $this->Flash->error(__('Maaf data Upload tidak dapat disimpan, silakan coba kembali.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
}
