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
use Cake\Http\Exception\ForbiddenException;
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
            $dataAction = explode('=', trim($valRule), 2);
            if (count($dataAction) !== 2 || $dataAction[0] === '') {
              continue;
            }

            $_act = array();
            $getActions = explode(',', $dataAction[1]);
            foreach ($getActions as $act) {
              $splitAct = explode(':', trim($act), 2);
              if (count($splitAct) !== 2 || $splitAct[0] === '') {
                continue;
              }

              $_act[$splitAct[0]] = $splitAct[1];
            }

            $checkUrl[strtolower($dataAction[0])] = $_act;
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
            'searchPoly',
            'searchPolyQueue',
          ];

          $canAccessPolyclinicQueueHelper = $getController === 'polyclinicqueues'
            && in_array($getAction, $polyclinicQueueHelperActions, true)
            && (
              !empty($resultCheck['index'])
              || !empty($checkUrl['outpatientvisits']['emr'])
            );

          $polyclinicQueueEntryActions = [
            'mobileJkn',
            'checkIn',
            'callQueue',
            'createReferralQueue',
          ];

          $canAccessPolyclinicQueueEntry = $getController === 'polyclinicqueues'
            && in_array($getAction, $polyclinicQueueEntryActions, true)
            && (
              !empty($resultCheck['index'])
              || !empty($resultCheck['add'])
              || !empty($checkUrl['outpatientvisits']['emr'])
            );

          $canAccessDoctorHelper = $getController === 'doctors'
            && $getAction === 'searchByPolyclinic'
            && (
              !empty($resultCheck['index'])
              || !empty($checkUrl['outpatientvisits']['emr'])
            );

          $outpatientVisitHelperActions = [
            'getSummary',
            'liveData',
          ];

          $canAccessOutpatientVisitHelper = $getController === 'outpatientvisits'
            && in_array($getAction, $outpatientVisitHelperActions, true)
            && !empty($resultCheck['index']);

          $outpatientVisitCpptActions = [
            'addCppt',
            'deleteCppt',
          ];

          $canAccessOutpatientVisitCppt = $getController === 'outpatientvisits'
            && in_array($getAction, $outpatientVisitCpptActions, true)
            && !empty($resultCheck['cppt']);

          $masterDataControllers = [
            'mastericd9',
            'mastericd10',
            'mastertindakan',
          ];

          $canAccessMasterDataView = in_array($getController, $masterDataControllers, true)
            && $getAction === 'view'
            && !empty($resultCheck['index']);

          $canAccessEmrMasterSearch = in_array($getController, $masterDataControllers, true)
            && $getAction === 'search'
            && !empty($checkUrl['outpatientvisits']['emr']);

          $orderFormHelperActions = [
            'cariPasien',
            'cariObat',
            'searchLaboratoryActions',
            'searchRadiologyActions',
            'historyPasien',
            'historyOrderDetail',
          ];

          $canAccessOrderForm = $getController === 'orders'
            && $getAction === 'form'
            && (
              !empty($resultCheck['form'])
              || !empty($checkUrl['outpatientvisits']['emr'])
            );

          $canAccessOrderFormHelper = $getController === 'orders'
            && in_array($getAction, $orderFormHelperActions, true)
            && (
              !empty($resultCheck['form'])
              || !empty($checkUrl['outpatientvisits']['emr'])
            );

          $canAccessOrderDetail = $getController === 'orders'
            && in_array($getAction, ['view', 'detail'], true)
            && (
              !empty($resultCheck['index'])
              || !empty($resultCheck['view'])
              || !empty($resultCheck['detail'])
              || !empty($resultCheck['form'])
              || !empty($checkUrl['outpatientvisits']['emr'])
            );

          $hasDirectAccess = !empty($resultCheck[$getAction]);
          $hasRelatedAccess = $canAccessRegistrationHelper
            || $canAccessRegistrationView
            || $canAccessBedHelper
            || $canAccessPolyclinicQueueHelper
            || $canAccessPolyclinicQueueEntry
            || $canAccessDoctorHelper
            || $canAccessOutpatientVisitHelper
            || $canAccessOutpatientVisitCppt
            || $canAccessMasterDataView
            || $canAccessEmrMasterSearch
            || $canAccessOrderForm
            || $canAccessOrderFormHelper
            || $canAccessOrderDetail;

          if (!$hasDirectAccess && !$hasRelatedAccess) {
            $jsonEndpointActions = [
              'doctors' => ['searchByPolyclinic'],
              'mastericd9' => ['search', 'toggleActive'],
              'mastericd10' => ['search', 'toggleActive'],
              'mastertindakan' => ['search', 'searchDebug', 'toggleActive'],
              'orders' => [
                'cariPasien',
                'cariObat',
                'searchLaboratoryActions',
                'searchRadiologyActions',
                'historyPasien',
                'historyOrderDetail',
              ],
              'outpatientvisits' => ['getSummary', 'liveData', 'addCppt', 'deleteCppt', 'panggil'],
              'polyclinicqueues' => ['searchPoly', 'searchPolyQueue', 'callQueue', 'createReferralQueue'],
            ];
            $expectsJson = $this->request->is('ajax')
              || in_array($getAction, $jsonEndpointActions[$getController] ?? [], true);

            if ($expectsJson) {
              return $this->response
                ->withStatus(403)
                ->withType('application/json')
                ->withStringBody(json_encode([
                  'success' => false,
                  'message' => 'Anda tidak memiliki hak akses untuk action ini.',
                ]));
            }

            throw new ForbiddenException('Anda tidak memiliki hak akses untuk membuka halaman tersebut.');
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
