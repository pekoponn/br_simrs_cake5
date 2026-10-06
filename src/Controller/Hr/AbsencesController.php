<?php
declare(strict_types=1);

namespace App\Controller\Hr;
use App\Controller\AppController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Laminas\Diactoros\CallbackStream;
use Cake\Log\Log;
use Detection\MobileDetect;
use Cake\Core\Configure;    

/**
 * Absences Controller
 *
 * @property \App\Model\Table\AbsencesTable $Absences
 * @method \App\Model\Entity\Absence[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AbsencesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Absences');
      
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // $this->paginate = [
        //     'contain' => ['Branches', 'Users'],
        // ];
        // $absences = $this->paginate($this->Absences);

        // $this->set(compact('absences'));
    }

    /**
     * View method
     *
     * @param string|null $id Absence id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $absence = $this->Absences->get($id, [
            'contain' => ['Branches', 'Users'],
        ]);

        $this->set(compact('absence'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $absence = $this->Absences->newEmptyEntity();
        if ($this->request->is('post')) {
            $absence = $this->Absences->patchEntity($absence, $this->request->getData());
            if ($this->Absences->save($absence)) {
                $this->Flash->success(__('The absence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The absence could not be saved. Please, try again.'));
        }
        // $branches = $this->Absences->Branches->find('list', ['limit' => 200]);
        $users = $this->Absences->Users->find('list', ['limit' => 200]);
        $this->set(compact('absence', 'users'));
        $identity = $this->request->getAttribute('identity');
        $currentUserId = $identity ? $identity->getIdentifier() : null;
        // The authentication identity can be stale after a face is added.
        // Reload the current user so the attendance page reads the latest face path.
        $getUser = $currentUserId
            ? $this->Absences->Users->get($currentUserId)
            : $this->request->getAttribute('identity');
        $user = $getUser;
        $this->set('getUser', $getUser);
        $timezone = $this->Krs->getTimezoneUser($user->zona ?? 'WIB');
        $dateNow = new \DateTime('now', new \DateTimeZone($timezone));
        $this->loadModel('Assignments');
        $checkAssignmentToday = null;
        if (!empty($currentUserId)) {
            $checkAssignmentToday = $this->Assignments->find()
                ->where([
                    'Assignments.is_create' => $currentUserId,
                    'Assignments.date_from <=' => $dateNow->format('Y-m-d'),
                    'Assignments.date_end >=' => $dateNow->format('Y-m-d'),
                    'Assignments.is_knowing IS NOT' => null , // Hanya yang sudah disetujui
                ])
                ->first();
        }

        $this->set(compact('absence', 'users', 'checkAssignmentToday'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Absence id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $absence = $this->Absences->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $absence = $this->Absences->patchEntity($absence, $this->request->getData());
            if ($this->Absences->save($absence)) {
                $this->Flash->success(__('The absence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The absence could not be saved. Please, try again.'));
        }
        $branches = $this->Absences->Branches->find('list', ['limit' => 200]);
        $users = $this->Absences->Users->find('list', ['limit' => 200]);
        $this->set(compact('absence', 'branches', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Absence id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $absence = $this->Absences->get($id);
        if ($this->Absences->delete($absence)) {
            $this->Flash->success(__('The absence has been deleted.'));
        } else {
            $this->Flash->error(__('The absence could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function saveData()
    {
        // $dataKeyAll = $this->request->getQueryParams();
        $this->autoRender=false;
        $result = "errors";

        $getLink = (array)$this->request->getQueryParams();
        $dataRow = (array)$this->request->getData();

        $dataId = $dataRow['id'] ?? $getLink['id'] ?? null;
        $dataStatus = $dataRow['status'] ?? $getLink['status'] ?? null;
        $dataLat = $dataRow['lat'] ?? $getLink['lat'] ?? null;
        $dataLong = $dataRow['long'] ?? $getLink['long'] ?? null;
        $dataSimilarity = $dataRow['similarity'] ?? $getLink['similarity'] ?? null;
        $dataCondition = $dataRow['conditions'] ?? $getLink['conditions'] ?? null;
        // $dataUserCond = (empty($dataRow)) ? $getLink['userCond'] : $dataRow['userCond'];
        
        // $leave = $this->Absences->get($id, [
        //     'contain' => [],
        // ]);

        if (!empty($dataId) && !empty($dataStatus) && !empty($dataLat) && !empty($dataLong) && $dataSimilarity !== null) {
            // pr($dataLat);
            // pr($dataLong);

            $threshold = 50;
            $similarityValue = is_numeric($dataSimilarity) ? (float)$dataSimilarity : -1;
            $registeredUser = $this->Absences->Users->find()
                ->select(['id', 'face'])
                ->where(['Users.id' => $dataId])
                ->first();

            if (empty($registeredUser) || empty($registeredUser->face)) {
                $result = "NF";

                return $this->response->withType("application/json")->withStringBody(json_encode($result));
            }

            if ($similarityValue < $threshold) {
                $result = "F";

                return $this->response->withType("application/json")->withStringBody(json_encode($result));
            }
            $userData = $this->Absences->Users->find()
                ->select(['id', 'zona'])
                ->where(['Users.id' => $dataId])
                ->first();
            $timezone = $this->Krs->getTimezoneUser($userData->zona ?? 'WIB');
            $dateNow = new \DateTime('now', new \DateTimeZone($timezone));
            // $dataTimeNow = date("H:i");
            $dataTimeNow = $dateNow->format("H:i");
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $dataId, "Absences user");
            $dataAuditLog = array('is_log' => $auditLog);
            $dataUserId = array('user_id' => $dataId);
            $dataIsCreate = array('is_create' => $dataId);
            $dataLatitude = array('latitude' => $dataLat);
            $dataLongitude = array('longitude' => $dataLong);

            // $dataDate = array('date' => date("Y-m-d"));
            $dataDate = array('date' => $dateNow->format("Y-m-d"));
            // pr($dataTimeNow);

            // $today = date('N'); // 1=Senin, 6=Sabtu, 7=Minggu
            $today = $dateNow->format('N');
            if ($today >= 1 && $today <= 5) {
                // Senin - Jumat
                $limitOut = "15:00";
            } elseif ($today == 6) {
                // Sabtu
                $limitOut = "11:00";
            } else {                
                // Minggu
                $limitOut = "00:00";
            }
            $dataIO = $dataRow['inout_mode'] ?? $getLink['inout_mode'] ?? $dataStatus;
            if (!in_array($dataIO, ['I', 'O'], true)) {
                return $this->response->withType("application/json")->withStringBody(json_encode($result));
            }
            // cek user dynamic radius
            $radiusOffice = $this->Absences->Users->find()
                ->select(['id', 'radius_id'])
                ->where(['Users.id' => $dataId])
                ->first();
            // cek izin keluar / meeting luar
            $this->loadModel('Assignments');
            $checkAssignment = $this->Assignments->find()
                ->where([
                    'Assignments.is_create' => $dataId,
                    'Assignments.date_from <=' => $dateNow->format('Y-m-d'),
                    'Assignments.date_end >=' => $dateNow->format('Y-m-d'),
                ])
                ->first();

            // user dianggap dinamis jika:
            // 1. radius kosong
            // 2. atau ada izin keluar hari ini
            $isDynamis = empty($radiusOffice->radius_id) || !empty($checkAssignment);
            // $currentTime = strtotime(date("H:i"));
            $currentTime = strtotime($dateNow->format("H:i"));
            $limitTime = strtotime("15:00");
            // if (!$isDynamis) {
            //     // user radius normal
            //     if ($dataIO == 'I' && $currentTime) {
            //         // >= $limitTime
            //         return $this->response
            //             ->withType("application/json")
            //             ->withStringBody(json_encode("LIMIT_IN"));
            //     }
            //     if ($dataIO == 'O' && $currentTime ) {
            //         // && $currentTime < $limitTime
            //         return $this->response
            //             ->withType("application/json")
            //             ->withStringBody(json_encode("LIMIT_OUT"));
            //     }
            // }

            // set jam berdasarkan tombol
            if ($dataIO == 'I') {
                $dataTimeIn = [
                    // 'time_in' => date("H:i:s")
                    'time_in' => $dateNow->format("H:i:s")
                ];
                $dataTimeOut = [];
            } else {
                $dataTimeIn = [];
                $dataTimeOut = [
                    // 'time_out' => date("H:i:s")
                    'time_out' => $dateNow->format("H:i:s")
                ];
            }

            $dataInOut = ['inout_mode' => $dataIO];
            $dataConditionField = ['conditions' => $dataCondition];
            // $dataInOut = array('inout_mode' => $dataIO);
            // $dataExpression = array('expression' => $dataStatus);
            $detect = new MobileDetect();
            if ($detect->isTablet()) {
                $deviceType = 'Tablet';
            } elseif ($detect->isMobile()) {
                $deviceType = 'Mobile';
            } else {
                $deviceType = 'Desktop';
            }
            $dataDeviceType = ['device' => $deviceType];
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if (stripos($userAgent, 'Chrome') !== false && stripos($userAgent, 'Edg') === false) {
                $browserType = 'Chrome';
            } elseif (stripos($userAgent, 'Safari') !== false && stripos($userAgent, 'Chrome') === false) {
                $browserType = 'Safari';
            } elseif (stripos($userAgent, 'Firefox') !== false) {
                $browserType = 'Firefox';
            } else {
                $browserType = 'Other';
            }
            $dataBrowserType = ['browser_type' => $browserType];
            $fullAddress = '-';
            if (!empty($dataLat) && !empty($dataLong)) {
                try {
                    $url = "https://nominatim.openstreetmap.org/reverse?lat={$dataLat}&lon={$dataLong}&format=json&addressdetails=1";

                    $options = ["http" => ["header" => "User-Agent: MyApp/1.0\r\n"]];
                    $context = stream_context_create($options);
                    $response = @file_get_contents($url, false, $context);
                    $geo = json_decode($response, true);

                    if (!empty($geo)) {
                        $addr = $geo['address'] ?? [];

                        $road     = $addr['road'] ?? '';
                        $village  = $addr['village'] ?? $addr['suburb'] ?? '';
                        $city     = $addr['city'] ?? $addr['town'] ?? $addr['county'] ?? '';
                        $state    = $addr['state'] ?? '';
                        $country  = $addr['country'] ?? '';

                        $parts = array_filter([$road, $village, $city, $state, $country]);
                        $fullAddress = implode(', ', $parts);

                        if (empty($fullAddress)) {
                            $fullAddress = $geo['display_name'] ?? '-';
                        }
                    }
                } catch (\Exception $e) {
                    $fullAddress = '-';
                }
            }

            $mapsLink = '-';
            if (!empty($dataLat) && !empty($dataLong)) {
                $mapsLink = "https://www.google.com/maps?q={$dataLat},{$dataLong}";
            }
            $dataAddress = ['address' => $fullAddress, 'location' => $mapsLink];
            $dataZona = ['zona' => $userData->zona ?? 'WIB'];
            
            // $dataTimeIn = array('time_in' => date("H:i:s"));
            // $dataTimeOut = array('time_out' => date("H:i:s"));
            
            $absences = $this->Absences->newEmptyEntity();
            $absences = $this->Absences->patchEntity($absences, array_merge($dataRow, $dataAuditLog, $dataUserId, $dataIsCreate, $dataDate, $dataTimeIn, $dataTimeOut, $dataLatitude,$dataLongitude, $dataInOut, $dataDeviceType, $dataBrowserType, $dataAddress, $dataConditionField, $dataZona));
            // pr($rowCheck);

            // debug ($absences);
            // die;
            $rowCheck = $this->Absences->find('all', [])->where(['user_id'=>$dataId,/*'date' => date("Y-m-d")])*/'date' => $dateNow->format("Y-m-d")])->order(['id'=>'desc'])->first();
            if ($isDynamis) {
                $allowSave = true;
                if (!empty($rowCheck) && $rowCheck->inout_mode == $dataIO) {
                    $lastTime = !empty($rowCheck->time_out)
                        ? strtotime($rowCheck->time_out)
                        : strtotime($rowCheck->time_in);
                    // $nowTime = strtotime(date("H:i:s"));
                    $nowTime = strtotime($dateNow->format("H:i:s"));
                    $diffMinutes = ($nowTime - $lastTime) / 60;
                    if ($diffMinutes < 10) {
                        $allowSave = false;
                    }
                }
                if ($allowSave) {
                    if ($this->Absences->save($absences)) {
                        $result = "Y";
                    }
                } else {
                    $result = "S";
                }
            } else {
                // normal user tidak boleh I-I atau O-O
                if (empty($rowCheck) || ($rowCheck->inout_mode != $dataIO)) {
                    if ($this->Absences->save($absences)) {
                        $result = "Y";
                    }
                } else {
                    $result = "S";
                }
            }
        } else {
            $result = "errors";
        }
        return $this->response->withType("application/json")->withStringBody(json_encode($result));
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
        $name        = $this->request->getQuery('name');
        $start_date  = $this->request->getQuery('start_date');
        $end_date    = $this->request->getQuery('end_date');
        $expression  = $this->request->getQuery('expression');
        $inout_mode  = $this->request->getQuery('inout_mode');

        // Auth user & rules
        $currentUserId = $authData['id']; 
        $rulesString   = $authData['rules'];
        $rules         = $this->Krs->_rule($rulesString);
        $canViewAll    = isset($rules['absences']['viewAll']) ? $rules['absences']['viewAll'] : 0;

        // Query builder
        $query = $this->Absences->find()
            ->contain([
                'Users' => function ($q) {
                    return $q->select(['Users.id', 'Users.name']);
                }
            ]);

        // Filter: nama pengguna
        if (!empty($name)) {
            $query->matching('Users', function ($q) use ($name) {
                return $q->where(['Users.name LIKE' => '%' . $name . '%']);
            });
        }

        // Filter: ekspresi
        if (!empty($expression)) {
            $query->where(['Absences.expression LIKE' => '%' . $expression . '%']);
        }

        // Filter: inout mode
        if (!empty($inout_mode)) {
            $query->where(['Absences.inout_mode' => $inout_mode]);
        }

        // Filter: rentang tanggal
        if (!empty($start_date) && !empty($end_date)) {
            $query->where(function ($exp) use ($start_date, $end_date) {
                return $exp->between(
                    'Absences.date',
                    date('Y-m-d', strtotime($start_date)),
                    date('Y-m-d', strtotime($end_date))
                );
            });
        }

        // Filter: akses pengguna (jika tidak boleh lihat semua)
        if ($canViewAll != '1') {
            $query->where(['Absences.is_create' => $currentUserId]);
        }

        // Hitung total sebelum paginasi
        $recordsTotal = $query->count();

        // Pagination dan urutan data
        $query->limit($length)
            ->offset($start)
            ->order(['Absences.date' => 'DESC']);

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
            // ❗ Kalau belum ada address tapi ada latlong → baru ambil dari API
            if (!empty($row->latitude) && !empty($row->longitude)) {
                try {
                    $url = "https://nominatim.openstreetmap.org/reverse?lat={$row->latitude}&lon={$row->longitude}&format=json&addressdetails=1";

                    $options = [
                        "http" => [
                            "header" => "User-Agent: MyApp/1.0\r\n"
                        ]
                    ];
                    $context = stream_context_create($options);
                    $response = @file_get_contents($url, false, $context);
                    $geo = json_decode($response, true);

                    if (!empty($geo)) {
                        $addr = $geo['address'] ?? [];

                        $road     = $addr['road'] ?? '';
                        $village  = $addr['village'] ?? $addr['suburb'] ?? '';
                        $city     = $addr['city'] ?? $addr['town'] ?? $addr['county'] ?? '';
                        $state    = $addr['state'] ?? '';
                        $country  = $addr['country'] ?? '';

                        $parts = array_filter([$road, $village, $city, $state, $country]);
                        $fullAddress = implode(', ', $parts);

                        if (empty($fullAddress)) {
                            $fullAddress = $geo['display_name'] ?? '-';
                        }
                        $row->set('address', $fullAddress);
                        $this->Absences->updateAll(
                            ['address' => $fullAddress/*, 'location' => $mapsLink*/],
                            ['id' => $row->id]
                        );

                    } else {
                        $row->set('address', '-');
                    }

                } catch (\Exception $e) {
                    $row->set('address', '-');
                }

                usleep(300000); // biar nggak kena limit
            } else {
                $row->set('address', '-');
            }
        }

        // 🔥 penting biar kebaca di JSON
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

    public function excel()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['get']);

        // ambil filter seperti di getHistory
        $name       = $this->request->getQuery('name');
        $start_date = $this->request->getQuery('start_date');
        $end_date   = $this->request->getQuery('end_date');
        $expression = $this->request->getQuery('expression');
        $inout_mode = $this->request->getQuery('inout_mode');

        // --- normalize dates: accept d-m-Y or Y-m-d ---
        $normalize = function (?string $d) {
            if ($d === null || trim($d) === '') {
                return null;
            }
            $d = trim($d);
            // try d-m-Y
            $dt = \DateTime::createFromFormat('d-m-Y', $d);
            if ($dt !== false) {
                return $dt->format('Y-m-d');
            }
            // try d/m/Y
            $dt = \DateTime::createFromFormat('d/m/Y', $d);
            if ($dt !== false) {
                return $dt->format('Y-m-d');
            }
            // try Y-m-d
            $dt = \DateTime::createFromFormat('Y-m-d', $d);
            if ($dt !== false) {
                return $dt->format('Y-m-d');
            }
            // fallback to strtotime
            $ts = strtotime($d);
            return $ts ? date('Y-m-d', $ts) : null;
        };

        $start_date = $normalize($start_date);
        $end_date = $normalize($end_date);

        // if only one date provided, make it a single-day range
        if ($start_date && !$end_date) {
            $end_date = $start_date;
        } elseif (!$start_date && $end_date) {
            $start_date = $end_date;
        }


        // hak akses user (sama seperti getHistory)
        $session = $this->getRequest()->getSession();
        $authData = $session->read('Auth');
        $currentUserId = $authData['id'] ?? null;
        $rulesString = $authData['rules'] ?? '';
        $rules = $this->Krs->_rule($rulesString);
        $canViewAll = isset($rules['absences']['viewAll']) ? $rules['absences']['viewAll'] : 0;

        // build query dengan filter
        $query = $this->Absences->find()
            ->contain(['Users' => function ($q) {
                return $q->select(['Users.id', 'Users.name']);
            }]);

        if (!empty($name)) {
            $query->matching('Users', function ($q) use ($name) {
                return $q->where(['Users.name LIKE' => '%' . $name . '%']);
            });
        }
        if (!empty($expression)) {
            $query->where(['Absences.expression LIKE' => '%' . $expression . '%']);
        }
        if (!empty($inout_mode)) {
            $query->where(['Absences.inout_mode' => $inout_mode]);
        }

        // apply date range correctly
        if (!empty($start_date) && !empty($end_date)) {
            // if 'date' column is DATE type this is fine; if DATETIME use boundaries
            $query->where(function ($exp) use ($start_date, $end_date) {
                // include whole end day
                $start = $start_date . ' 00:00:00';
                $end   = $end_date . ' 23:59:59';
                return $exp->between('Absences.date', $start, $end);
            });
        }

        if ($canViewAll != '1') {
            $query->where(['Absences.is_create' => $currentUserId]);
        }

        $rows = $query->order(['Absences.date' => 'DESC'])->toArray();

        // buat spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Absences');

        // --- NEW: Title row merged A1:I1, centered, bold ---
        // $filterLabel = !empty($name) ? $name : 'Semua';
        $title = 'Rekap absensi';
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                         ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        // --- END NEW ---

        // header (pindah ke baris 2 karena title di baris 1)
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama');
        // $sheet->setCellValue('C2', 'NIP');
        $sheet->setCellValue('C2', 'Tanggal');
        $sheet->setCellValue('D2', 'InOut');
        $sheet->setCellValue('E2', 'Time In');
        $sheet->setCellValue('F2', 'Time Out');
        $sheet->setCellValue('G2', 'Latitude');
        $sheet->setCellValue('H2', 'Longitude');
        $sheet->setCellValue('I2', 'Alamat');
        $sheet->setCellValue('J2', 'Maps Link');

        // data mulai dari baris 3
        $rowNum = 3;

        // mapping untuk inout_mode dan expression
        $inoutLabels = [
            'I' => 'Masuk',
            'O' => 'Keluar',
            'D' => 'Dynamis'
        ];
        $expressionLabels = [
            'H' => 'Senang',
            'I' => 'Biasa Saja'
        ];
        // $limitTime = new \DateTime('08:00:00');

        foreach ($rows as $i => $r) {
            $sheet->setCellValue('A' . $rowNum, $i + 1);

            $name = '-';
            if (isset($r->user) && isset($r->user->name) && $r->user->name !== null) {
                $name = $r->user->name;
            }
            $sheet->setCellValue('B' . $rowNum, $name);
            $sheet->setCellValue('C' . $rowNum, $r->date ? $r->date->format('Y-m-d') : '-');
            $rawInOut = isset($r->inout_mode) ? $r->inout_mode : null;
            $labelInOut = isset($inoutLabels[$rawInOut]) ? $inoutLabels[$rawInOut] : ($rawInOut ?? '-');
            $sheet->setCellValue('D' . $rowNum, $labelInOut);

            $timeInDisplay = '-';
            $isLate = false;

            // if (!empty($r->time_in)) {
            //     $timeIn = new \DateTime($r->time_in);

            //     if ($timeIn > $limitTime) {
            //         $isLate = true;
            //         $timeInDisplay = $r->time_in . ' (Terlambat)';
            //     } else {
            //         $timeInDisplay = $r->time_in;
            //     }
            // }

            // $sheet->setCellValue('E' . $rowNum, $timeInDisplay);
            $sheet->setCellValue('E' . $rowNum, $r->time_in .'('. (isset($r->zone) ? $r->zone : '-') .')'?? '-');
            $sheet->setCellValue('F' . $rowNum, $r->time_out .'('. (isset($r->zone) ? $r->zone : '-') .')'?? '-');
            $sheet->setCellValue('G' . $rowNum, $r->latitude ?? '-');
            $sheet->setCellValue('H' . $rowNum, $r->longitude ?? '-');
            $sheet->setCellValue('I' . $rowNum, $r->address ?? '-');
            $sheet->setCellValue('J' . $rowNum, $r->location ?? '-');

            // $rawExpr = isset($r->expression) ? $r->expression : null;
            // $labelExpr = isset($expressionLabels[$rawExpr]) ? $expressionLabels[$rawExpr] : ($rawExpr ?? '-');
            // $sheet->setCellValue('J' . $rowNum, $labelExpr);

            // if ($isLate) {
            //     $sheet->getStyle("A{$rowNum}:J{$rowNum}")
            //         ->getFill()
            //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            //         ->getStartColor()
            //         ->setARGB('FFFFCCCC'); // merah soft
            // }
            $rowNum++;
        }

        foreach (range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
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
        // gunakan sampai kolom I atau L sesuai kebutuhan; disini pakai A sampai I (kolom data)
        $sheet->getStyle("A1:J{$lastRow}")->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'Absences-' . date('Ymd-His') . '.xlsx';

        return $this->response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment; filename=\"{$filename}\"")
            ->withBody($stream);
    } 
}
