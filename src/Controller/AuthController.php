<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher; //Memanggil PasswordHaser

class AuthController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // pr($result);
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // memanggil data dari Authenctication
            $getData = $result->getData();
            $dateNow = date('Y-m-d H:i:s');

            $this->Users = $this->fetchTable('Users');
            // mengupdate last_login dan visited
            $this->Users->updateAll(['last_login' => $dateNow, 'visited' => $getData['visited'] + 1], ['id' => $getData['id']]);

            $this->Flash->success('Selamat datang ' . $getData->name . ', silakan menggunakan aplikasi ini.');

            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', ['controller' => 'Dashboard', 'action' => 'index',]);
           // $redirect = $this->request->getQuery('redirect', ['controller' => 'Home', 'action' => 'index',]);
            return $this->redirect($redirect);
        }

        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Maaf, Password yang anda masukkan salah!!');
            //$this->Flash->error('Maaf, Password yang anda masukkan salah!!');
            
        }
    }

    public function index()
    {
        $redirect = $this->request->getQuery('redirect', ['controller' => 'Home', 'action' => 'index',]);
        return $this->redirect($redirect);
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in

        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Auth', 'action' => 'login']);
        }
    }
}
