<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
// use Cake\Datasource\ConnectionManager;
// use Cake\I18n\FrozenTime;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Krs');

        // Tambahan untuk Auth untuk mengkunci website
        // Add this line to check authentication result and lock your site
        $this->loadComponent('Authentication.Authentication');
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login']); // Kondisi untuk mengakses halaman tanpa perlu auth
        //,'index','resetPassword'
        
        set_time_limit(0);

        ini_set('memory_limit','2048M');

        $this->response = $this->response->cors($this->request)
            ->allowOrigin(['*'])
            ->allowMethods(['GET', 'POST'])
            ->allowHeaders(['X-CSRF-Token'])
            ->allowCredentials()
            ->exposeHeaders(['Link'])
            ->maxAge(300)
            ->build();
            
        //Membuat hak akses pada setiap halaman
        $result = $this->Authentication->getResult();
        $getController = strtolower($this->request->getParam('controller'));
        //$this->Authentication->allowUnauthenticated(['login']);
        if ($result->getStatus() === "SUCCESS") {
          $getUser = $result->getData();
          $dataRule = explode(';', $getUser->rules);
          $checkUrl = array();
          foreach ($dataRule as $idRule => $valRule) {
            $dataAction = explode('=', $valRule);
            $controlRule = array($dataAction[0] => $dataAction[1]);
            $_act = array();
            foreach ($controlRule as $keyControlRule => $valControlRule) {
              $getAction = explode(',', $valControlRule);
              foreach ($getAction as $key => $act) {
                $splitAct = explode(':', $act);
                $_act[$splitAct[0]] = $splitAct[1];
              }
              $checkUrl[$dataAction[0]] = $_act;
            }
          }
          $getAction = $this->request->getParam('action');
          $resultCheck = $checkUrl[$getController] ?? [];
          $registrationHelperActions = [
            'searchPatients',
            'getKabupatens',
            'getKecamatans',
            'getKelurahans',
            'getBedClass',
            'getAvailableBeds',
            'getDoctorSchedules',
          ];

          $canAccessRegistrationHelper = $getController === 'registrations'
            && in_array($getAction, $registrationHelperActions, true)
            && (
              !empty($resultCheck['add'])
              || !empty($resultCheck['edit'])
            );

          $canAccessRegistrationView = $getController === 'registrations'
            && $getAction === 'view'
            && (
              !empty($resultCheck['index'])
              || !empty($resultCheck['add'])
              || !empty($resultCheck['edit'])
              || !empty($checkUrl['polyclinicqueues']['index'])
            );

          $bedHelperActions = [
            'monitoring',
            'view',
            'searchPatients',
            'updateStatus',
          ];

          $canAccessBedHelper = $getController === 'beds'
            && in_array($getAction, $bedHelperActions, true)
            && (
              !empty($resultCheck['index'])
              || !empty($resultCheck['edit'])
            );

          $polyclinicQueueHelperActions = [
            'view',
            'pdf',
            'display',
          ];

          $canAccessPolyclinicQueueHelper = $getController === 'polyclinicqueues'
            && in_array($getAction, $polyclinicQueueHelperActions, true)
            && !empty($resultCheck['index']);

          $polyclinicQueueEntryActions = [
            'mobileJkn',
            'checkIn',
            'callQueue',
          ];

          $canAccessPolyclinicQueueEntry = $getController === 'polyclinicqueues'
            && in_array($getAction, $polyclinicQueueEntryActions, true)
            && (
              !empty($resultCheck['index'])
              || !empty($resultCheck['add'])
            );

          if(!$canAccessRegistrationHelper && !$canAccessRegistrationView && !$canAccessBedHelper && !$canAccessPolyclinicQueueHelper && !$canAccessPolyclinicQueueEntry && (empty($resultCheck[$getAction]) || $resultCheck[$getAction]==0)) {
           return $this->redirect($this->referer()); // Halaman akan tidak bisa diakses
          }

          $this->set('getController', $getController);
          $this->set('checkUrl', $checkUrl);
          $this->set(compact('getUser', 'getAction'));

        }        
    }
    
    public function json($data){
        $json_data = json_encode($data);
        $response = $this->response->withType('json')->withStringBody($json_data);
        return $response;

    }
}
