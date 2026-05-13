<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Auth\DefaultPasswordHasher; //Memanggil PasswordHaser
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
        //$this->Authentication->addUnauthenticatedActions(['add']);
        parent::beforeFilter($event);
        
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
            $this->Users->updateAll(['last_login' => $dateNow, 'visited' => $getData['visited']+1], ['id' => $getData['id']]); 

            $this->Flash->success('Selamat datang '.$getData->name.', silakan menggunakan aplikasi ini.');

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
        $key = $this->request->getQuery('key');
        if ($key) {
          $query = $this->Users->find('all')
                        ->where(['OR'=>['Users.name like' => '%' . $key . '%', 'Users.staff like' => '%' . $key . '%', 'Users.devision like' => '%' . $key . '%', 'Users.last_login like' => '%' . $key . '%']]);
        } else {
          $query = $this->Users;
        }

        // debug($query);

        $this->paginate = [
            'contain' => ['Branches'],
        ];

        $settings = [
            'limit' => 10,
            'order' => [
                'code' => 'asc',
            ],
        ];
        $users = $this->paginate($query, $settings);
        
        $this->set(compact('users'));
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
            $hasher = new DefaultPasswordHasher(); // Memanggil class PasswordHasher
           
            $dataRow = $this->request->getData();
            $isUser = $dataRow['user_id'];

            $dataHint = array('help_hint_pwd' => $dataRow['passwordNew']);
            $dataUserId = array('is_create' => $isUser);
            $dataBranchId = (!empty($dataRow['branchId'])) ? array('branch_id' => implode(",", $dataRow['branchId'])) : array();
           
            $dataRules = array('rules' => "dashboard=index:0;purchaseprices=getDataFromSupplier:0;users=logout:1,changePassword:1,status:0,login:1,home:0,index:0,add:0,edit:0,access:0,resetPassword:0,delete:0;waste_prices=getAjaxData:0;customers=getLastNumber:0,getSearch:0,getAjaxType:0,getKabupaten:0,index:0,add:0,edit:0,editAdmin:0,preview:0,status:0,delete:0,xls:0;materials=getSelect:0,index:0,add:0,edit:0,preview:0,status:0,delete:0,xls:0;daerahkabupatens=getList:0;purchasepasses=index:0,add:0,edit:0,preview:0,printing:0,pdf:0,delete:0,xls:0,payment:0,stock:0,payment_edit:0,payment_cancel:0;suppliers=index:0,add:0,edit:0,preview:0,status:0,delete:0,xls:0;trucks=index:0,add:0,edit:0,delete:0;warehouses=index:0,add:0,edit:0,delete:0;branchs=index:0,add:0,edit:0,delete:0;settings=index:0,add:0,edit:0;pettycashes=index:0,add:0,edit:0,preview:0,printing:0,pdf:0,delete:0,status:0,approve:0,approve_ceo:0,edit_all:0,accountability:0,xls:0,payment:0");

            $dataPassword = (empty($dataRow['passwordNew'])) ? array() : array('password_new' => $hasher->hash($dataRow['passwordNew']));
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), 'N', $isUser, "User add"); 
            $dataAuditLog = array('is_log' => "'".$auditLog."'");
            
            $user = $this->Users->patchEntity($user, array_merge($dataUserId, $dataBranchId, $dataPassword, $dataHint, $dataRow, $dataRules, $dataAuditLog));
            
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
            
            if ($this->Users->save($user)) {
                //$this->Krs->setFlash("Terima kasih, Data berhasil disimpan.", "success");
                // $this->Flash->success('Data berhasil disimpan.');
                //$this->Flash->success(__('The user has been saved.'));

                 return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Maaf, data gagal disimpan!!'));
        }
        $branches = $this->Users->Branches->find('list', ['limit' => 200]);
        $this->set(compact('user', 'branches'));
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
            
            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $isUser);
            $dataPassword = (empty($dataRow['passwordNew'])) ? array() : array('password_new' => $hasher->hash($dataRow['passwordNew']));
            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id, $isUser, "Reset Password"); 
            $dataAuditLog = array('is_log' => $auditLog);
            
            $user = $this->Users->patchEntity($user, array_merge($dataUserId, $dataPassword, $dataAuditLog));
            
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

        $this->loadModel('Branches');
        $rowBranch = $this->Branches
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])
            ->toArray();
                    
        $users = $this->Users->get($id, [
            
        ]);

        $rules = $this->Krs->_rule($users->rules);
        
        $this->set(compact('users', 'rowBranch', 'rules'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $dataRow = $this->request->getData();
            $isUser = $dataRow['user_id'];
            $dataUserId = array('is_update' => $dataRow['user_id']);
            $dataProject = array('project' => $dataRow['project']);
            $dataUbs = array('ubs' => $dataRow['ubs']);
            $dataProjectStatus = array('project_status' => $dataRow['projectStatus']);

            $auditLog = $this->Krs->auditLog($this->request->getParam('controller'), $id, $isUser, "Edit Access"); 
            $dataRules = $this->Krs->createRule($dataRow['Rules']);

            $dataAuditLog = array('is_log' => $auditLog);
            $dataRule = array('rules' => $dataRules);
            $dataRadiusId = array('radius_id' => $dataRow['radius_id']);

            $users = $this->Users->patchEntity($users, array_merge($dataUserId, $dataProject, $dataUbs, $dataProjectStatus, $dataAuditLog, $dataRule, $dataRadiusId));
            
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
}
