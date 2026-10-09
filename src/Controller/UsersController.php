<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Auth\DefaultPasswordHasher; //Memanggil PasswordHaser
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Http\CallbackStream;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

//use Cake\I18n\FrozenDate;

class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        //$this->Authentication->allowUnauthenticated(['index']);

        //$this->Authentication->addUnauthenticatedActions(['add']);
        parent::beforeFilter($event);
        //$this->loadComponent('Security');

        /*// Memanggil action yang aktif
        $action = $this->request->getParam('action');

        // Memanggil controller yang aktif
        $controller = $this->request->getParam('controller');
        // pr($this->request->getParam('controller'));
        // pr($this->request->getParam('action'));

        // Memanggil nilai dari Authentication
        $result = $this->Authentication->getResult();
        //pr($result);

        // Nilai dari hak akses yang diberikan
        $a=array("index"=>1,"add"=>1,"edit"=>1,'login'=>1,'logout'=>1);

        if ($result->getStatus() === "SUCCESS") {
            //if($action=='edit') {
            //pr($a[$action]);
            if($a[$action]==0) {
            //if(array_key_exists($action,$a)) {
                //$this->Flash->error(__('maaf halaman tidak dapat diakses'));
                return $this->redirect($this->referer()); // Halaman akan tidak bisa diakses
                //return $this->redirect(['controller' => 'Error', 'action' => 'error400']);
            }
        }*/

        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        //$this->Authentication->addUnauthenticatedActions(['login']); //Untuk memberikan halaman yg bisa diakses
        //$this->Authentication->addUnauthenticatedActions(['add']);

        //$this->Auth->deny('add');
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // memanggil data dari Authenctication
            $getData = $result->getData();
            $dateNow = date('Y-m-d H:i:s');

            // mengupdate last_login dan visited
            $this->Users->updateAll(['last_login' => $dateNow, 'visited' => $getData['visited'] + 1], ['id' => $getData['id']]);

            $this->Flash->success('Selamat datang ' . $getData->name . ', silakan menggunakan aplikasi ini.');

            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', ['controller' => 'Dashboard', 'action' => 'index',]);
            return $this->redirect($redirect);
        }

        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Maaf, Password yang anda masukkan salah!!');
        }


    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in

        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // $key = $this->request->getQuery('key');
        // if ($key) {
        //   $query = $this->Users->find('all')
        //                 ->where(['OR'=>['Users.name like' => '%' . $key . '%', 'Users.staff like' => '%' . $key . '%', 'Users.devision like' => '%' . $key . '%', 'Users.last_login like' => '%' . $key . '%']]);
        // } else {
        //   $query = $this->Users;
        // }
        $users = $this->Users->find('all')->contain([]);
        $code = $this->request->getQuery('filtercode');
        $name = $this->request->getQuery('filtername');
        $status = $this->request->getQuery('filterstatus');
        // $driver = $this->request->getQuery('filterDriver');
        $devision = $this->request->getQuery('filterDivisi');


        $dataWhere = array();
        if (!empty($code)) {
            $dataWhere['Users.code like'] = '%' . $code . '%';
        }
        if (!empty($name)) {
            $dataWhere['Users.name like'] = '%' . $name . '%';
        }
        if (!empty($status)) {
            $dataWhere['Users.status'] = $status;
        }
        if (!empty($devision)) {
            $dataWhere['Users.devision like'] = '%' . $devision . '%';
        }

        // $dataWheres = (!empty($dataWheres)) ? $dataWheres : '';
        // $queries = $users->where([$dataWheres])->order(['Users.code' => 'ASC']);

                
        $conditions = !empty($dataWhere) ? $dataWhere : [];
        $query = $this->Users->find()->contain(['CreatedUsers'])->where($conditions)->order(['Users.code' => 'ASC']);
        $users = $this->paginate($query);
        $this->set('users', $this->paginate($query, ['limit' => '10']));

        // debug($query);

        // $this->paginate = [
        //     'contain' => ['Branches'],
        // ];

        // $settings = [
        //     'limit' => 10,
        //     'order' => [
        //         'code' => 'asc',
        //     ],
        // ];
        // $users = $this->paginate($query, $settings);
        
        //$data['setFlash'] = array();        
        
        // $this->set(compact('users'));

        //$users = $this->paginate($this->Users, $settings);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Branches', 'Creditors', 'Customers', 'CustomersOri', 'Logs', 'Suppliers', 'Transporters'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            //$password = "My Password String";
            $hasher = new DefaultPasswordHasher(); // Memanggil class PasswordHasher
            // $newPassword = $hasher->hash($password);
            //$newPassword = $hasher->hash($password);
            //pr($newPassword);

            $dataRow = $this->request->getData();
            $isUser = $dataRow['user_id'];

            $dataHint = array('help_hint_pwd' => $dataRow['passwordNew']);
            $dataUserId = array('is_create' => $isUser);
            $dataBranchId = (!empty($dataRow['branchId'])) ? array('branch_id' => implode(",", $dataRow['branchId'])) : array();
            //$dataPassword = (empty($dataRow['passwordNew'])) ? "" : array('password_new' => $user->_setPassword($dataRow['passwordNew']));
            $defaultRules = [
                'dashboard=index:0',
                'purchaseprices=getDataFromSupplier:0',
                'users=logout:1,changePassword:1,status:0,login:1,home:0,index:0,add:0,edit:0,access:0,resetPassword:0,delete:0',
                'medicalrecords=index:0,history:0,searchPatients:0,backfillNoRm:0',
                'medicalrecorddiagnoses=index:0,view:0,add:0,edit:0,delete:0',
                'medicalrecordinpatients=index:0,view:0,add:0,edit:0,delete:0',
                'medicalrecordoutpatientigds=index:0,view:0,add:0,edit:0,delete:0',
                'medicalresumes=index:0,view:0,add:0,edit:0,delete:0',
                'patients=index:0,add:0,edit:0,view:0,delete:0,getKabupatens:0,getKecamatans:0,getKelurahans:0',
                'registrations=index:0,getSummary:0,view:0,add:0,edit:0,delete:0,searchPatients:0,getKabupatens:0,getKecamatans:0,getKelurahans:0,getBedClass:0,getAvailableBeds:0,getDoctorSchedules:0',
                'praregistrations=index:0,view:0,add:0,edit:0,delete:0,register:0',
                'patientadmissions=index:0',
                'patienthistories=index:0,searchPatients:0,periksa:0,history:0',
                'outpatientvisits=index:0,view:0,add:0,edit:0,cppt:0,emr:0,resumeMedis:0,doctorQueue:0,selesai:0,panggil:0,batal:0,getSummary:0,liveData:0,searchIcd10:0,searchIcd9:0,selesaiPeriksa:0,hasilPemeriksaan:0,delete:0',
                'outpatientbillings=index:0,kasir:0,kwitansi:0,tambahItem:0,hapusItem:0,toggleReadyTransfer:0,prosesBayar:0',
                'paymenthistories=index:0,searchPatients:0',
                'reportattendances=index:0,view:0,excel:0,excelSummary:0,getReport:1',
                'assignments=index:0,add:0,edit:0,delete:0,view:0,approve:0,knowing:0,getHistory:1',
                'outpatientvisitemr=emr:0',
                'outpatientletters=index:0,view:0,add:0,edit:0,delete:0,getSuratSakit:0,simpanSuratSakit:0,getSuratKonsultasi:0,simpanSuratKonsultasi:0,getSuratJawabanKonsultasi:0,simpanSuratJawabanKonsultasi:0,cetakSuratKonsultasi:0,cetakSuratSakit:0',
                'outpatientcpptnotes=index:0,view:0,add:0,edit:0,delete:0',
                'inpatiententries=index:0,view:0,add:0,edit:0,delete:0',
                'orders=index:0,view:0,antrianFarmasi:0,proses:0,form:0,detail:0,cariPasien:0,cariObat:0,cariLaboratorium:0,cariRadiologi:0,cariPenunjang:0,cariNutritionCombine:0,cariJenisMcu:0,cariJenisOperasi:0,historyPasien:0,historyOrderDetail:0',
                'rencanapembelians=index:0,view:0,add:0,edit:0,delete:0,ambilDetail:0',
                'orderpembelians=index:0,view:0,add:0,edit:0,delete:0',
                'returpembelians=index:0,view:0,add:0,edit:0,delete:0',
                'invoices=index:0,view:0,add:0,edit:0,delete:0,cariBapb:0',
                'invoicedetails=index:0,view:0,add:0,edit:0,delete:0',
                'medicinestocks=index:0,toggleValid:0',
                'kartustok=index:0,searchMedicine:0',
                'ordermcus=index:0,view:0,add:0,edit:0,delete:0',
                'ordersmcus=index:0,view:0,add:0,edit:0,delete:0',
                'ordersupports=index:0,view:0,add:0,edit:0,delete:0',
                'ordersurgeries=index:0,view:0,add:0,edit:0,delete:0',
                'mastertindakan=index:0,view:0,add:0,edit:0,toggleActive:0,search:0,searchDebug:0,delete:0',
                'mastericd9=index:0,view:0,add:0,edit:0,import:0,toggleActive:0,search:0,delete:0',
                'mastericd10=index:0,view:0,add:0,edit:0,import:0,toggleActive:0,search:0,delete:0',
                'mastermcutypes=index:0,view:0,add:0,edit:0,delete:0',
                'masteroperationtypes=index:0,view:0,add:0,edit:0,delete:0',
                'mastersupports=index:0,view:0,add:0,edit:0,delete:0',
                'mastersurgeryoperators=index:0,view:0,add:0,edit:0,delete:0',
                'waste_prices=getAjaxData:0',
                'customers=getLastNumber:0,getSearch:0,getAjaxType:0,getKabupaten:0,index:0,add:0,edit:0,editAdmin:0,preview:0,status:0,delete:0,xls:0',
                'materials=getSelect:0,index:0,add:0,edit:0,preview:0,status:0,delete:0,xls:0',
                'daerahkabupatens=getList:0',
                'purchasepasses=index:0,add:0,edit:0,preview:0,printing:0,pdf:0,delete:0,xls:0,payment:0,stock:0,payment_edit:0,payment_cancel:0',
                'suppliers=index:0,add:0,edit:0,preview:0,status:0,delete:0,xls:0',
                'trucks=index:0,add:0,edit:0,delete:0',
                'warehouses=index:0,add:0,edit:0,delete:0',
                'branchs=index:0,add:0,edit:0,delete:0',
                'settings=index:0,add:0,edit:0',
                'pettycashes=index:0,add:0,edit:0,preview:0,printing:0,pdf:0,delete:0,status:0,approve:0,approve_ceo:0,edit_all:0,accountability:0,xls:0,payment:0',
            ];
            $dataRules = ['rules' => implode(';', $defaultRules)];

            $dataPassword = (empty($dataRow['passwordNew'])) ? array() : array('password_new' => $hasher->hash($dataRow['passwordNew']));
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "User add");
            $dataAuditLog = array('is_log' => "'" . $auditLog . "'");
            // $sha1 = Security::hash('CakePHP Framework');
            // pr($sha1);
            //$dataHint = array('help_hint_pwd' => $dataRow['password']);

            $user = $this->Users->patchEntity($user, array_merge($dataUserId, $dataBranchId, $dataPassword, $dataHint, $dataRow, $dataRules, $dataAuditLog));

            //pr($user);
            if ($this->Users->save($user)) {
                $this->Flash->success('Data berhasil disimpan.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Maaf, data anda tidak dapat disimpan. Silakan, coba kembali beberapa saat !!.');
        }
        $branches = $this->Users->Branches->find('list', ['limit' => 100]);
        $this->set(compact('user', 'branches'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            pr($user);
            //if ($this->Users->save($user)) {
            //$this->Krs->setFlash("Terima kasih, Data berhasil disimpan.", "success");
            // $this->Flash->success('Data berhasil disimpan.');
            //$this->Flash->success(__('The user has been saved.'));

            //     return $this->redirect(['action' => 'index']);
            // }
            $this->Flash->error(__('Maaf, data gagal disimpan!!'));
            // $this->Krs->setFlash("Maaf, data tidak dapat disimpan.", "error");
        }
        $branches = $this->Users->Branches->find('list', ['limit' => 200]);
        $this->set(compact('user', 'branches'));
        //pr($this->request->getSession());
    }

    public function changePassword($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hasher = new DefaultPasswordHasher(); // Memanggil class PasswordHasher
            $dataRow = $this->request->getData();
            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $isUser);
            $dataPassword = (empty($dataRow['passwordNew'])) ? array() : array('password' => $dataRow['passwordNew']);
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id, $isUser, "Change Password");
            $dataAuditLog = array('is_log' => $auditLog);

            $user = $this->Users->patchEntity($user, array_merge($dataUserId, $dataPassword, $dataAuditLog));

            if ($this->Users->save($user)) {
                $this->Flash->success('Terima kasih, sandi berhasil disimpan');

                return $this->redirect(['controller' => 'dashboard']);
            }
            $this->Flash->error('Maaf, sandi tidak dapat disimpan!');
        }
        $this->set(compact('user'));
    }

    public function resetPassword($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hasher = new DefaultPasswordHasher(); // Memanggil class PasswordHasher
            $dataRow = $this->request->getData();
            // $getController = strtolower($this->request->getParam('controller'));

            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $isUser);
            $dataPassword = (empty($dataRow['passwordNew'])) ? array() : array('password_new' => $hasher->hash($dataRow['passwordNew']));
            //$dataPassword = (empty($dataRow['passwordNew'])) ? array() : array('password_new' => $this->hasher($dataRow['passwordNew']));
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id, $isUser, "Reset Password");
            $dataAuditLog = array('is_log' => $auditLog);

            $user = $this->Users->patchEntity($user, array_merge($dataUserId, $dataPassword, $dataAuditLog));
            //pr($user);

            if ($this->Users->save($user)) {
                $this->Flash->success('Terima kasih, sandi berhasil disimpan');

                return $this->redirect(['controller' => 'users']);
            }
            $this->Flash->error('Maaf, sandi tidak dapat disimpan!');

        }
        $this->set(compact('user'));
    }

    public function access($id = null)
    {
        $userData = $this->request->getAttribute('identity');

        $rowUsers = $this->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
        ->where([
            'Users.is_active' => 'Y',
            // 'Users.id !=' => $userData->id
        ])
        ->order(['Users.name' => 'ASC'])
        ->toArray();
        $users = $this->Users->get($id, [
            'contain' => [/*'Division'*/],
        ]);

        $users = $this->Users->get($id, [
            //'contain' => ['Division'],
        ]);

        $rules = $this->Krs->_rule($users->rules);
        // pr($rule);
        //pr($rules);
        $this->set(compact('users', 'rules', 'rowUsers'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            // pr($dataRow['Rules']);
            // die;
            $isUser = $dataRow['user_id'];

            $dataUserId = [
                'is_update' => $dataRow['user_id']
            ];

            $dataProject = [
                'project' => $dataRow['project'] ?? $users->project
            ];

            $dataUbs = [
                'ubs' => $dataRow['ubs'] ?? $users->ubs
            ];

            $dataProjectStatus = [
                'project_status' => $dataRow['projectStatus'] ?? $users->project_status
            ];

            $dataRadius = [
                'radius_id' => $dataRow['radius_id'] ?? $users->radius_id
            ];

            $dataStaff = [
                'staff' => $dataRow['staff'] ?? $users->staff
            ];

            $dataDevision = [
                'devision' => $dataRow['devision'] ?? $users->devision
            ];

            $dataWorkingHours = [
                'working_hours' => (isset($dataRow['working_hours']) && $dataRow['working_hours'] !== '')
                    ? (int)$dataRow['working_hours']
                    : null
            ];

            $d_teamGroup = (empty($dataRow['user_team'])) ? "" : implode(",", $dataRow['user_team']);
            $dataTeamGroup = array('user_team' => $d_teamGroup);

            $auditLog = $this->Krs->auditLog(
                $this->request->getParam('controller'),
                $id,
                $isUser,
                "Edit Access"
            );

            $oldRules = $this->Krs->_rule($users->rules);
            $newRules = $dataRow['Rules'] ?? [];

            // Checkbox yang tidak dicentang bisa tidak ikut terkirim.
            // Untuk group yang dikirim form, action yang tidak ada harus dianggap 0,
            // bukan mempertahankan nilai permission lama.
            foreach ($newRules as $controller => $actions) {
                if (!isset($oldRules[$controller]) || !is_array($actions)) {
                    continue;
                }

                foreach ($oldRules[$controller] as $action => $value) {
                    if (!array_key_exists($action, $actions)) {
                        $newRules[$controller][$action] = 0;
                    }
                }
            }

            $ruleDefaults = [
                'reportattendances' => [
                    'index' => 0,
                    'view' => 0,
                    'excel' => 0,
                    'excelSummary' => 0,
                    'getReport' => 1,
                ],
                'assignments' => [
                    'index' => 0,
                    'add' => 0,
                    'edit' => 0,
                    'delete' => 0,
                    'view' => 0,
                    'approve' => 0,
                    'knowing' => 0,
                    'getHistory' => 1,
                ],
            ];

            $mergedRules = array_replace_recursive(
                $ruleDefaults,
                $oldRules,
                $newRules
            );

            $dataRules = $this->Krs->createRule($mergedRules);

            $dataAuditLog = [
                'is_log' => $auditLog
            ];

            $dataRule = [
                'rules' => $dataRules
            ];

            $users = $this->Users->patchEntity(
                $users,
                array_merge(
                    $dataUserId,
                    $dataProject,
                    $dataUbs,
                    $dataProjectStatus,
                    $dataRadius,
                    $dataStaff,
                    $dataDevision,
                    $dataWorkingHours,
                    $dataTeamGroup,
                    $dataAuditLog,
                    $dataRule
                )
            );

            if ($this->Users->save($users)) {
                $this->Flash->success('Terima kasih, Hak Akses berhasil disimpan');

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Maaf, Hak Akses tidak dapat disimpan!');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function addFace($id = null)
    {
        $user = $this->Users->get($id);

        if ($this->request->is(['post', 'put'])) {
            $dataRow = $this->request->getData();
            $faceImage = trim((string)($dataRow['face_image'] ?? ''));

            if ($faceImage === '') {
                $this->Flash->error('Foto wajah belum diambil.');
                $this->set(compact('user'));
                return;
            }

            if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $faceImage, $matches)) {
                $this->Flash->error('Format foto tidak valid.');
                $this->set(compact('user'));
                return;
            }

            $extension = strtolower($matches[1] === 'jpeg' ? 'jpg' : $matches[1]);
            $faceImage = substr($faceImage, strpos($faceImage, ',') + 1);
            $binaryImage = base64_decode(str_replace(' ', '+', $faceImage), true);

            if ($binaryImage === false) {
                $this->Flash->error('Foto wajah tidak bisa diproses.');
                $this->set(compact('user'));
                return;
            }

            $targetDir = WWW_ROOT . 'uploads' . DS . 'faces' . DS;
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0775, true);
            }

            $filename = 'user-' . $id . '-' . time() . '.' . $extension;
            $relativePath = 'uploads/faces/' . $filename;

            if (file_put_contents($targetDir . $filename, $binaryImage) === false) {
                $this->Flash->error('Foto wajah gagal disimpan ke folder upload.');
                $this->set(compact('user'));
                return;
            }

            $oldRelativePath = (string)$user->face;
            $user = $this->Users->patchEntity($user, [
                'face' => $relativePath,
            ]);

            // This action only changes the face path. Do not block it with
            // unrelated user-form validation rules such as password fields.
            if ($this->Users->save($user, ['validate' => false])) {
                if ($oldRelativePath !== '' && $oldRelativePath !== $relativePath) {
                    $oldPath = WWW_ROOT . str_replace(
                        ['/', '\\'],
                        DS,
                        ltrim($oldRelativePath, '/\\')
                    );
                    if (is_file($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $this->Flash->success('Foto wajah berhasil disimpan.');

                // return $this->redirect(['action' => 'index']);
                return $this->redirect(['controller' => 'dashboard']);
            }

            // Avoid leaving an orphaned upload when the database update fails.
            $newPath = $targetDir . $filename;
            if (is_file($newPath)) {
                unlink($newPath);
            }
            $this->Flash->error('Maaf, foto wajah tidak dapat disimpan.');
        }

        $this->set(compact('user'));
    }

    public function resetFace($id = null)
    {
        $this->request->allowMethod(['post', 'get']);
        $user = $this->Users->get($id);
        $isUser = $this->Authentication->getIdentity()->id;
        $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id, $isUser, "Reset Face");

        $dataAuditLog = ['is_log' => $auditLog];
        if (!empty($user->face)) {
            $path = WWW_ROOT . str_replace(
                ['/', '\\'],
                DS,
                ltrim((string)$user->face, '/\\')
            );
            if (is_file($path)) {
                unlink($path);
            }
        }
        $dataSave = ['face' => null];
        $user = $this->Users->patchEntity($user, array_merge($dataSave, $dataAuditLog));
        if ($this->Users->save($user, ['validate' => false])) {
            $this->Flash->success(__('Data wajah berhasil dihapus.'));

        } else {
            $this->Flash->error(__('Data wajah gagal dihapus.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getSelect($typeUser=null)
    {
        $this->autoRender = false;

        $search = $this->request->getQuery('search');
        // $typeUser = ($typeUser=='Marketing') ? :;
        $dataWhere = array();
        if (!empty($search)) {
            if($typeUser=='Marketing') {
                $dataWhere['Users.marketing_code IS NOT'] = NULL;
            }

            $dataWhere['Users.name like'] = '%' . $search . '%';
            $dataRow = $this->Users->find('all')->contain([])->select(['id', 'code', 'name'])->where([$dataWhere])->toList();           
        } else {
            $dataRow = array();
        }

        $result = array();
        foreach ($dataRow as $key => $data) {
            $result[$key]['id'] = $this->Krs->fEncode((int) $data['id'].'^'.$data['code']);
            $result[$key]['text'] = $data['code'];
        }

        return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }
    
    public function getUsers()
    {
        $this->request->is(['get']); 

        $query = $this->request->getQuery('q'); 
        $user = $this->Users->find()
            ->select(['id', 'name'])
            ->where([
                'name LIKE' => '%' . $query . '%',
                'is_active' => 'Y'
            ])
            ->limit(20)
            ->all()
            ->toList();

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'data' => $user
        ]));
    }

    public function templateExcel($dataLink='')
    {       
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

        $sheet->getStyle('A1:C1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:C2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);

        // sheet peratama
        $sheet->setTitle('Sheet 1');
        // Add some data, resembling some different data types  
        $sheet->setCellValue('A1', 'code');
        $sheet->setCellValue('A2', 'Kode user harus unik, huruf kecil tanpa spasi. Contoh: tsabitah');
        $sheet->setCellValue('B1', 'Nama Karyawan');
        $sheet->setCellValue('B2', 'Masukkan nama lengkap karyawan pada kolom ini, sebagai informasi');
        $sheet->setCellValue('C1', 'Sandi');
        $sheet->setCellValue('C2', 'Masukkan data Sandi pada kolom ini, sebagai informasi');

        $row = 3;
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Template_Users-' . date('ymd');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);

        // $this->set(compact('data'));
    }
}
