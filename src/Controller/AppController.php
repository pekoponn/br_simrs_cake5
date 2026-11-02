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
#[\AllowDynamicProperties]
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

          $canAccessRegistrationSummary = $getController === 'registrations'
            && $getAction === 'getSummary'
            && !empty($resultCheck['index']);

          $patientRegionActions = [
            'getKabupatens',
            'getKecamatans',
            'getKelurahans',
            'get-kabupatens',
            'get-kecamatans',
            'get-kelurahans',
          ];

          $canAccessPatientRegionHelper = $getController === 'patients'
            && in_array($getAction, $patientRegionActions, true)
            && (
              !empty($resultCheck['add'])
              || !empty($resultCheck['edit'])
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
            'searchPatients',
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
            'panggil',
            'datang',
          ];

          $canAccessOutpatientVisitHelper = $getController === 'outpatientvisits'
            && in_array($getAction, $outpatientVisitHelperActions, true)
            && !empty($resultCheck['index']);

          $outpatientBillingViewActions = [
            'kasir',
            'kwitansi',
          ];

          $outpatientBillingMutationActions = [
            'tambahItem',
            'hapusItem',
            'toggleReadyTransfer',
            'prosesBayar',
          ];

          $canAccessOutpatientBillingHelper = $getController === 'outpatientbillings'
            && (
              (
                in_array($getAction, $outpatientBillingViewActions, true)
                && (
                  !empty($resultCheck['index'])
                  || !empty($resultCheck['kasir'])
                  || !empty($resultCheck[$getAction])
                )
              )
              || (
                in_array($getAction, $outpatientBillingMutationActions, true)
                && !empty($resultCheck[$getAction])
              )
            );

          $outpatientVisitCpptActions = [
            'addCppt',
            'deleteCppt',
          ];

          $canAccessOutpatientVisitCppt = $getController === 'outpatientvisits'
            && in_array($getAction, $outpatientVisitCpptActions, true)
            && !empty($resultCheck['cppt']);

          $outpatientVisitEmrHelperActions = [
            'searchIcd10',
            'searchIcd9',
            'hasilPemeriksaan',
          ];

          $canAccessOutpatientVisitEmrHelper = $getController === 'outpatientvisits'
            && in_array($getAction, $outpatientVisitEmrHelperActions, true)
            && !empty($resultCheck['emr']);

          $canAccessOutpatientVisitEmrPage = $getController === 'outpatientvisitemr'
            && $getAction === 'emr'
            && (
              !empty($resultCheck['emr'])
              || !empty($checkUrl['outpatientvisits']['emr'])
            );

          $outpatientVisitEmrAjaxActions = [
            'kajianAwal',
            'saveAnatomy',
            'simpanKajianAwal',
          ];

          $canAccessOutpatientVisitEmrAjax = $getController === 'outpatientvisitemr'
            && in_array($getAction, $outpatientVisitEmrAjaxActions, true)
            && (
              !empty($resultCheck['emr'])
              || !empty($checkUrl['outpatientvisits']['emr'])
            );

          $outpatientLetterHelperActions = [
            'getSuratSakit',
            'simpanSuratSakit',
            'getSuratKonsultasi',
            'simpanSuratKonsultasi',
            'getSuratJawabanKonsultasi',
            'simpanSuratJawabanKonsultasi',
            'getSuratPengantarRawat',
            'simpanSuratPengantarRawat',
            'cetakSuratPengantarRawat',
            'getSuratBuktiRajal',
            'simpanSuratBuktiRajal',
            'cetakSuratBuktiRajal',
            'getSuratSkdp',
            'simpanSuratSkdp',
            'cetakSuratSkdp',
            'getSuratKontrolBpjs',
            'simpanSuratKontrolBpjs',
            'cetakSuratKontrolBpjs',
            'getSuratSehat',
            'simpanSuratSehat',
            'cetakSuratSehat',
            'cetakSuratKonsultasi',
            'cetakSuratSakit',
          ];

          $canAccessOutpatientLetterHelper = $getController === 'outpatientletters'
            && in_array($getAction, $outpatientLetterHelperActions, true)
            && (
              !empty($resultCheck['add'])
              || !empty($resultCheck['edit'])
              || !empty($checkUrl['outpatientvisits']['emr'])
              || !empty($checkUrl['outpatientvisitemr']['emr'])
            );

          $medicalRecordHelperActions = [
            'searchPatients',
          ];

          $canAccessMedicalRecordHelper = $getController === 'medicalrecords'
            && in_array($getAction, $medicalRecordHelperActions, true)
            && (
              !empty($resultCheck['index'])
              || !empty($resultCheck['history'])
            );

          $patientHistoryHelperActions = [
            'searchPatients',
          ];

          $canAccessPatientHistoryHelper = $getController === 'patienthistories'
            && in_array($getAction, $patientHistoryHelperActions, true)
            && (
              !empty($resultCheck['index'])
              || !empty($resultCheck['periksa'])
              || !empty($resultCheck['history'])
            );

          $paymentHistoryHelperActions = [
            'searchPatients',
          ];

          $canAccessPaymentHistoryHelper = $getController === 'paymenthistories'
            && in_array($getAction, $paymentHistoryHelperActions, true)
            && !empty($resultCheck['index']);

          $canAccessPatientAdmissionPlan = $getController === 'patientadmissions'
            && $getAction === 'planInpatient'
            && (
              !empty($resultCheck['index'])
              || !empty($checkUrl['outpatientvisits']['emr'])
              || !empty($checkUrl['outpatientvisitemr']['emr'])
            );

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

          $masterTenagaMedisHelperActions = [
            'nextKode',
            'searchModal',
            'toggleActive',
          ];

          $canAccessMasterTenagaMedisHelper = $getController === 'mastertenagamedis'
            && in_array($getAction, $masterTenagaMedisHelperActions, true)
            && (
              !empty($resultCheck['index'])
              || !empty($resultCheck['add'])
              || !empty($resultCheck['edit'])
            );

          $orderFormHelperActions = [
            'cariPasien',
            'cariObat',
            'cariLaboratorium',
            'cariRadiologi',
            'cariPenunjang',
            'cariNutritionCombine',
            'cariJenisMcu',
            'cariJenisOperasi',
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

          $canAccessOrderPharmacy = $getController === 'orders'
            && in_array($getAction, ['antrianFarmasi', 'proses'], true)
            && (
              !empty($resultCheck['antrianFarmasi'])
              || !empty($resultCheck['proses'])
            );

          $canAccessStockHelper = (
              $getController === 'kartustok'
              && $getAction === 'searchMedicine'
              && !empty($resultCheck['index'])
            )
            || (
              $getController === 'medicinestocks'
              && $getAction === 'toggleValid'
              && !empty($resultCheck['index'])
            );

          $canAccessPurchaseHelper = (
              $getController === 'rencanapembelians'
              && $getAction === 'ambilDetail'
              && (
                !empty($resultCheck['index'])
                || !empty($resultCheck['view'])
                || !empty($checkUrl['orderpembelians']['add'])
                || !empty($checkUrl['orderpembelians']['edit'])
              )
            )
            || (
              $getController === 'invoices'
              && $getAction === 'cariBapb'
              && (
                !empty($resultCheck['index'])
                || !empty($checkUrl['returpembelians']['add'])
                || !empty($checkUrl['returpembelians']['edit'])
              )
            );

          $hasDirectAccess = !empty($resultCheck[$getAction]);
          $hasRelatedAccess = $canAccessRegistrationHelper
            || $canAccessRegistrationView
            || $canAccessRegistrationSummary
            || $canAccessPatientRegionHelper
            || $canAccessBedHelper
            || $canAccessPolyclinicQueueHelper
            || $canAccessPolyclinicQueueEntry
            || $canAccessDoctorHelper
            || $canAccessOutpatientVisitHelper
            || $canAccessOutpatientBillingHelper
            || $canAccessOutpatientVisitCppt
            || $canAccessOutpatientVisitEmrHelper
            || $canAccessOutpatientVisitEmrPage
            || $canAccessOutpatientVisitEmrAjax
            || $canAccessOutpatientLetterHelper
            || $canAccessMedicalRecordHelper
            || $canAccessPatientHistoryHelper
            || $canAccessPaymentHistoryHelper
            || $canAccessPatientAdmissionPlan
            || $canAccessMasterDataView
            || $canAccessEmrMasterSearch
            || $canAccessMasterTenagaMedisHelper
            || $canAccessOrderForm
            || $canAccessOrderFormHelper
            || $canAccessOrderDetail
            || $canAccessOrderPharmacy
            || $canAccessStockHelper
            || $canAccessPurchaseHelper;

          if (!$hasDirectAccess && !$hasRelatedAccess) {
            $jsonEndpointActions = [
              'doctors' => ['searchByPolyclinic'],
              'mastericd9' => ['search', 'toggleActive'],
              'mastericd10' => ['search', 'toggleActive'],
              'mastertindakan' => ['search', 'searchDebug', 'toggleActive'],
              'mastertenagamedis' => ['nextKode', 'searchModal', 'toggleActive'],
              'medicalrecords' => ['searchPatients'],
              'orders' => [
                'cariPasien',
                'cariObat',
                'cariLaboratorium',
                'cariRadiologi',
                'cariPenunjang',
                'cariNutritionCombine',
                'cariJenisMcu',
                'cariJenisOperasi',
                'historyPasien',
                'historyOrderDetail',
              ],
              'invoices' => ['cariBapb'],
              'kartustok' => ['searchMedicine'],
              'medicinestocks' => ['toggleValid'],
              'outpatientbillings' => ['tambahItem', 'hapusItem', 'toggleReadyTransfer'],
              'outpatientletters' => ['getSuratSakit', 'simpanSuratSakit', 'getSuratKonsultasi', 'simpanSuratKonsultasi', 'getSuratJawabanKonsultasi', 'simpanSuratJawabanKonsultasi', 'getSuratPengantarRawat', 'simpanSuratPengantarRawat', 'cetakSuratPengantarRawat', 'getSuratBuktiRajal', 'simpanSuratBuktiRajal', 'cetakSuratBuktiRajal', 'getSuratSkdp', 'simpanSuratSkdp', 'cetakSuratSkdp', 'getSuratKontrolBpjs', 'simpanSuratKontrolBpjs', 'cetakSuratKontrolBpjs', 'getSuratSehat', 'simpanSuratSehat', 'cetakSuratSehat', 'cetakSuratKonsultasi', 'cetakSuratSakit'],
              'outpatientvisitemr' => ['kajianAwal', 'saveAnatomy', 'simpanKajianAwal'],
              'outpatientvisits' => ['getSummary', 'liveData', 'addCppt', 'deleteCppt', 'panggil', 'datang', 'searchIcd10', 'searchIcd9', 'hasilPemeriksaan'],
              'patientadmissions' => ['planInpatient'],
              'patienthistories' => ['searchPatients'],
              'paymenthistories' => ['searchPatients'],
              'patients' => ['getKabupatens', 'getKecamatans', 'getKelurahans', 'get-kabupatens', 'get-kecamatans', 'get-kelurahans'],
              'polyclinicqueues' => ['searchPoly', 'searchPolyQueue', 'callQueue', 'createReferralQueue', 'searchPatients'],
              'rencanapembelians' => ['ambilDetail'],
              'registrations' => ['getSummary', 'searchPatients', 'getKabupatens', 'getKecamatans', 'getKelurahans', 'getBedClass', 'getAvailableBeds', 'getDoctorSchedules'],
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
    protected function getCurrentUserId(): ?int
    {
        $result = $this->Authentication->getResult();

        if ($result && $result->getStatus() === 'SUCCESS') {
            $getUser = $result->getData();
            if (!empty($getUser->id)) {
                return (int)$getUser->id;
            }
        }

        return null;
    }

    /**
 * Cari tanggal kejadian TERAKHIR (boleh hari ini) yang jatuh pada $dayName.
 * Dipakai sebagai penanda "minggu praktik berjalan" untuk kuota jadwal dokter.
 * Misal hari ini Rabu, $dayName = 'Senin' -> hasilnya tanggal Senin kemarin.
 * Kalau hari ini Senin, $dayName = 'Senin' -> hasilnya hari ini juga.
 */
    protected function getDoctorScheduleCycleDate(string $dayName): string
    {
        $dayIsoMap = [
            'senin' => 1, 'monday' => 1,
            'selasa' => 2, 'tuesday' => 2,
            'rabu' => 3, 'wednesday' => 3,
            'kamis' => 4, 'thursday' => 4,
            'jumat' => 5, 'friday' => 5,
            'sabtu' => 6, 'saturday' => 6,
            'minggu' => 7, 'sunday' => 7,
        ];

        $targetIso = $dayIsoMap[mb_strtolower(trim($dayName))] ?? (int)date('N');
        $todayIso = (int)date('N');
        $diff = ($targetIso - $todayIso + 7) % 7;

        return date('Y-m-d', strtotime("+{$diff} days"));
    }

    /**
     * Kuota yang seharusnya ditampilkan sekarang: kalau quota_reset_at jadwal
     * bukan siklus berjalan (minggu sudah lewat), anggap quota_used = 0.
     */
    protected function getEffectiveQuotaUsed($schedule): int
    {
        $cycleDate = $this->getDoctorScheduleCycleDate((string)($schedule->day ?? ''));
        $storedResetDate = !empty($schedule->quota_reset_at)
            ? (is_object($schedule->quota_reset_at) ? $schedule->quota_reset_at->format('Y-m-d') : (string)$schedule->quota_reset_at)
            : null;

        return $storedResetDate === $cycleDate ? (int)($schedule->quota_used ?? 0) : 0;
    }

    protected function archiveExpiredDoctorScheduleCycle($schedule): void
    {
        $activeCycleDate = $this->getDoctorScheduleCycleDate((string)($schedule->day ?? ''));

        $storedResetDate = !empty($schedule->quota_reset_at)
            ? (is_object($schedule->quota_reset_at) ? $schedule->quota_reset_at->format('Y-m-d') : (string)$schedule->quota_reset_at)
            : null;

        if ($storedResetDate === null || $storedResetDate === $activeCycleDate) {
            return;
        }

        if ((int)($schedule->quota_used ?? 0) > 0) {
            $historiesTable = $this->fetchTable('DoctorScheduleQuotaHistories');

            $exists = $historiesTable->exists([
                'doctor_schedule_id' => $schedule->id,
                'cycle_date' => $storedResetDate,
            ]);

            if (!$exists) {
                $now = date('Y-m-d H:i:s');

                $history = $historiesTable->newEntity([
                    'doctor_schedule_id' => $schedule->id,
                    'cycle_date' => $storedResetDate,
                    'quota' => $schedule->quota,
                    'quota_used' => $schedule->quota_used,
                    'created' => $now,
                    'modified' => $now,
                ]);

                $historiesTable->save($history);
            }
        }

        $schedule->quota_used = 0;
        $schedule->quota_reset_at = $activeCycleDate;

        $this->fetchTable('DoctorSchedules')->save($schedule);
    }
}
