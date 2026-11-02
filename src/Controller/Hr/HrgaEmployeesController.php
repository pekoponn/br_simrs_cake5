<?php
declare(strict_types=1);

namespace App\Controller\Hr;
use App\Controller\AppController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

/**
 * HrgaEmployees Controller
 *
 * @property \App\Model\Table\HrgaEmployeesTable $HrgaEmployees
 * @method \App\Model\Entity\HrgaEmployee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HrgaEmployeesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->HrgaEmployees = $this->fetchTable('HrgaEmployees');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $hrgaEmployees = $this->HrgaEmployees->find('all')->contain(['Users']);
        $identity = $this->request->getAttribute('identity');
        $viewAll = $this->canViewAll();

        if (!$viewAll) {
            // paksa hanya data milik sendiri
            $hrgaEmployees->where(['HrgaEmployees.id' => (int)($identity->hrga_employee_id ?? 0)]);
        }

        $nip = $this->request->getQuery('filternip');
        $name = $this->request->getQuery('filtername');
        // $branch = $this->request->getQuery('filterbranch');
        $unit = $this->request->getQuery('filterunit');
        $kepegawaian = $this->request->getQuery('filterkepegawaian');
        $status = $this->request->getQuery('filterstatus');

        $dataWhere = array();
        if (!empty($nip)) {
            $dataWhere['HrgaEmployees.nip like'] = '%' . $nip . '%';
        }
        if (!empty($name)) {
            $dataWhere['HrgaEmployees.name like'] = '%' . $name . '%';
        }
        // if (!empty($branch)) {
        //     $dataWhere['HrgaEmployees.branch like'] = '%' . $branch . '%';
        // }
        if (!empty($unit)) {
            $dataWhere['HrgaEmployees.business_unit like'] = '%' . $unit . '%';
        }
        if (!empty($kepegawaian)) {
            $dataWhere['HrgaEmployees.status like'] = '%' . $kepegawaian . '%';
        }
        if (!empty($status)) {
            $dataWhere['HrgaEmployees.is_active like'] = '%' . $status . '%';
        }

        $queries = (!empty($dataWhere)) ? $hrgaEmployees->where([$dataWhere])->order(['HrgaEmployees.created' => 'Desc']) : $hrgaEmployees->order(['HrgaEmployees.created' => 'DESC']);

        // $expired = $this->HrgaEmployees->find('all')
        // ->where(['OR' => [
        //     'HrgaEmployees.contract_end_date BETWEEN NOW() AND NOW() + INTERVAL 30 DAY', 'HrgaEmployees.is_active' => 'N'],
        //     'HrgaEmployees.status NOT IN' => ['Resign', 'Non-Aktif', 'PHK', 'Pensiun']])
        // ->toArray();
        $expiredQuery = $this->HrgaEmployees->find('all')
            ->where(['OR' => [
                'HrgaEmployees.contract_end_date BETWEEN NOW() AND NOW() + INTERVAL 30 DAY',
                'HrgaEmployees.is_active' => 'N'],
                'HrgaEmployees.status NOT IN' => ['Resign', 'Non-Aktif', 'PHK', 'Pensiun']]);

        if (!$viewAll) {
            $expiredQuery->where(['HrgaEmployees.id' => (int)($identity->hrga_employee_id ?? 0)]);
        }

        $expired = $expiredQuery->toArray();

        $this->set(['hrgaEmployees' => $this->paginate($queries, ['limit' => '10']), 'expired' => $expired]);
    }

    /**
     * View method
     *
     * @param string|null $id Hrga Employee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $hrgaEmployee = $this->HrgaEmployees->get($id, [
    //         'contain' => ['Users', 'HrgaAttendances', 'HrgaEmployeeLines'],
    //     ]);

    //     $this->set(compact('hrgaEmployee'));
    // }
    public function view($id = null)
    {
        if (!$this->canViewAll()) {
            $identity = $this->request->getAttribute('identity');
            if ((int)$id !== (int)($identity->hrga_employee_id ?? 0)) {
                throw new \Cake\Http\Exception\ForbiddenException(__('Anda hanya dapat melihat data sendiri.'));
            }
        }

        $hrgaEmployee = $this->HrgaEmployees->get($id, [
            'contain' => ['Users', 'HrgaAttendances', 'HrgaEmployeeLines'],
        ]);

        $this->set(compact('hrgaEmployee'));
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $this->HrgaEmployees = $this->fetchTable('HrgaEmployees');
        $hrgaEmployee = $this->HrgaEmployees->newEmptyEntity();
        if ($this->request->is('post')) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_create'];
            $auditLog = $this->Krs->auditLog("HrgaEmployees", 'N', $this->request->getParam('controller'),  $isUser, "HrgaEmployees add");
            $dataAuditLog = array('is_log' => $auditLog);
            $date_of_birth = array('date_of_birth' => $this->Krs->dateTo($dataRow['date_of_births']));
            $work_date = array('work_date' => $this->Krs->dateTo($dataRow['work_dates']));
            $contract_start_date = array('contract_start_date' => !empty($dataRow['contract_start_dates'])  ? $this->Krs->dateTo($dataRow['contract_start_dates']) : null);
            $contract_end_date = array('contract_end_date' => !empty($dataRow['contract_end_dates'])  ? $this->Krs->dateTo($dataRow['contract_end_dates']) : null);
            $bpjs_kesehatan_date = array('bpjs_kesehatan_date' => $this->Krs->dateTo($dataRow['bpjs_kesehatan_dates']));
            $bpjs_ketenagakerjaan_date = array('bpjs_ketenagakerjaan_date' => $this->Krs->dateTo($dataRow['bpjs_ketenagakerjaan_dates']));
            $telepon = array('telp' => str_replace("_", "", $dataRow['telp']));
            $divisionData = [];
            if (!empty($dataRow['devisi'])) {
                $explodeDiv = explode('^', $dataRow['devisi']);

                $divisionData = [
                    'devisi' => $explodeDiv[0] ?? null,
                    'sub_devisi' => $explodeDiv[1] ?? null,
                ];
            }

            $photo_path = WWW_ROOT . 'upload/employees' . DS;
            $photo_ = $dataRow['photo_path'];
            if ($photo_->getClientFilename()) {
                $photo_img = $this->Image->uploadimage($photo_path, $photo_);
                $photo = array('photo_path' => $photo_img);
            } else {
                $photo = array('photo_path' => null);
            }

            // berkas lamaran
            $suratLamaran_ = $dataRow['berkas_surat_lamaran'];
            if ($suratLamaran_->getClientFilename()) {
                $suratLamaran_img = $this->Image->uploadimage($photo_path, $suratLamaran_);
                $suratLamaran = array('berkas_surat_lamaran' => $suratLamaran_img);
            } else {
                $suratLamaran = array('berkas_surat_lamaran' => null);
            }

            // berkas cv
            $cv_ = $dataRow['berkas_cv'];
            if ($cv_->getClientFilename()) {
                $cv_img = $this->Image->uploadimage($photo_path, $cv_);
                $cv = array('berkas_cv' => $cv_img);
            } else {
                $cv = array('berkas_cv' => null);
            }


            // berkas ktp
            $ktp_ = $dataRow['berkas_ktp'];
            if ($ktp_->getClientFilename()) {
                $ktp_img = $this->Image->uploadimage($photo_path, $ktp_);
                $ktp = array('berkas_ktp' => $ktp_img);
            } else {
                $ktp = array('berkas_ktp' => null);
            }


            // berkas ijazah
            $ijazah_ = $dataRow['berkas_ijasah'];
            if ($ijazah_->getClientFilename()) {
                $ijazah_img = $this->Image->uploadimage($photo_path, $ijazah_);
                $ijazah = array('berkas_ijasah' => $ijazah_img);
            } else {
                $ijazah = array('berkas_ijasah' => null);
            }


            // berkas kk
            $kk_ = $dataRow['berkas_kk'];
            if ($kk_->getClientFilename()) {
                $kk_img = $this->Image->uploadimage($photo_path, $kk_);
                $kk = array('berkas_kk' => $kk_img);
            } else {
                $kk = array('berkas_kk' => null);
            }


            // berkas skck
            $skck_ = $dataRow['berkas_skck'];
            if ($skck_->getClientFilename()) {
                $skck_img = $this->Image->uploadimage($photo_path, $skck_);
                $skck = array('berkas_skck' => $skck_img);
            } else {
                $skck = array('berkas_skck' => null);
            }


            // berkas sd
            $suratDokter_ = $dataRow['berkas_surat_dokter'];
            if ($suratDokter_->getClientFilename()) {
                $suratDokter_img = $this->Image->uploadimage($photo_path, $suratDokter_);
                $suratDokter = array('berkas_surat_dokter' => $suratDokter_img);
            } else {
                $suratDokter = array('berkas_surat_dokter' => null);
            }


            // berkas vaksin 1
            $vaksin1_ = $dataRow['berkas_kartu_vaksin_1'];
            if ($vaksin1_->getClientFilename()) {
                $vaksin1_img = $this->Image->uploadimage($photo_path, $vaksin1_);
                $vaksin1 = array('berkas_kartu_vaksin_1' => $vaksin1_img);
            } else {
                $vaksin1 = array('berkas_kartu_vaksin_1' => null);
            }


            // berkas vaksin 2
            $vaksin2_ = $dataRow['berkas_kartu_vaksin_2'];
            if ($vaksin2_->getClientFilename()) {
                $vaksin2_img = $this->Image->uploadimage($photo_path, $vaksin2_);
                $vaksin2 = array('berkas_kartu_vaksin_2' => $vaksin2_img);
            } else {
                $vaksin2 = array('berkas_kartu_vaksin_2' => null);
            }


            // berkas vaksin 3
            $vaksin3_ = $dataRow['berkas_kartu_vaksin_3'];
            if ($vaksin3_->getClientFilename()) {
                $vaksin3_img = $this->Image->uploadimage($photo_path, $vaksin3_);
                $vaksin3 = array('berkas_kartu_vaksin_3' => $vaksin3_img);
            } else {
                $vaksin3 = array('berkas_kartu_vaksin_3' => null);
            }


            // berkas vaksin 4
            $vaksin4_ = $dataRow['berkas_kartu_vaksin_4'];
            if ($vaksin4_->getClientFilename()) {
                $vaksin4_img = $this->Image->uploadimage($photo_path, $vaksin4_);
                $vaksin4 = array('berkas_kartu_vaksin_4' => $vaksin4_img);
            } else {
                $vaksin4 = array('berkas_kartu_vaksin_4' => null);
            }

            // berkas kontrak 1
            $kontrak1_ = $dataRow['berkas_kontrak_1'];
            if ($kontrak1_->getClientFilename()) {
                $kontrak1_img = $this->Image->uploadimage($photo_path, $kontrak1_);
                $kontrak1 = array('berkas_kontrak_1' => $kontrak1_img);
            } else {
                $kontrak1 = array('berkas_kontrak_1' => null);
            }

            // berkas kontrak 2
            $kontrak2_ = $dataRow['berkas_kontrak_2'];
            if ($kontrak2_->getClientFilename()) {
                $kontrak2_img = $this->Image->uploadimage($photo_path, $kontrak2_);
                $kontrak2 = array('berkas_kontrak_2' => $kontrak2_img);
            } else {
                $kontrak2 = array('berkas_kontrak_2' => null);
            }

            $families = array();
            foreach ($dataRow['hrga_employee_lines'] as $index => $employee_families) {
                if (!empty($employee_families['name']) && !empty($employee_families['no_ktp'])) {
                    $families['hrga_employee_lines'][$index]['name'] = $employee_families['name'];
                    $families['hrga_employee_lines'][$index]['status_family'] = $employee_families['status_family'];
                    $families['hrga_employee_lines'][$index]['place_of_birth'] = $employee_families['place_of_birth'];
                    $families['hrga_employee_lines'][$index]['birthday'] = $this->Krs->dateTo($employee_families['birthday']);
                    $families['hrga_employee_lines'][$index]['clothes_size'] = $employee_families['clothes_size'];
                    $families['hrga_employee_lines'][$index]['address'] = $employee_families['address'];
                    $families['hrga_employee_lines'][$index]['no_ktp'] = $employee_families['no_ktp'];
                    $families['hrga_employee_lines'][$index]['telp'] = $employee_families['telp'];
                    $families['hrga_employee_lines'][$index]['pekerjaan'] = $employee_families['pekerjaan'];
                    $families['hrga_employee_lines'][$index]['bpjs_kesehatan'] = $employee_families['bpjs_kesehatan'];
                    $families['hrga_employee_lines'][$index]['bpjs_kesehatan_status'] = $employee_families['bpjs_kesehatan_status'];
                    $families['hrga_employee_lines'][$index]['bpjs_kesehatan_date'] = $this->Krs->dateTo($employee_families['bpjs_kesehatan_dates']);
                    $families['hrga_employee_lines'][$index]['riwayat_sakit'] = $employee_families['riwayat_sakit'];
                } else {
                    $families['hrga_employee_lines'] = array();
                }
            }

            $trainings = array();
            foreach ($dataRow['hrga_employee_trainings'] as $index => $trayRow) {
                if (!empty($trayRow['skill']) && !empty($trayRow['start_date']) && !empty($trayRow['end_date']) && !empty($trayRow['grade']) && !empty($trayRow['organizer'])) {
                    $trainings['hrga_employee_trainings'][$index]['skill'] = $trayRow['skill'];
                    $trainings['hrga_employee_trainings'][$index]['start_date'] = $this->Krs->dateTo($trayRow['start_date']);
                    $trainings['hrga_employee_trainings'][$index]['end_date'] = $this->Krs->dateTo($trayRow['end_date']);
                    $trainings['hrga_employee_trainings'][$index]['grade'] = $trayRow['grade'];
                    $trainings['hrga_employee_trainings'][$index]['organizer'] = $trayRow['organizer'];
                } else {
                    $trainings['hrga_employee_trainings'] = array();
                }
            }

            // $salaryTable = $this->getTableLocator()->get('AccSalaries');
            // $salaries = $salaryTable->newEmptyEntity();

            $userTable = $this->getTableLocator()->get('Users');
            $user = $userTable->get($dataRow['user_id']);

            $hrgaEmployee = $this->HrgaEmployees->patchEntity($hrgaEmployee, array_merge($dataRow, $telepon, $dataAuditLog, $date_of_birth, $contract_start_date, $contract_end_date, $work_date, $bpjs_kesehatan_date, $bpjs_ketenagakerjaan_date, $photo, $suratLamaran, $cv, $ktp, $ijazah, $kk, $skck, $suratDokter, $vaksin1, $vaksin2, $vaksin3, $vaksin4, $kontrak1, $kontrak2, $families, $trainings, $divisionData));

            // pr($hrgaEmployee);
            // debug($divisionData);
            // debug($hrgaEmployee);
            // die;
            if ($this->HrgaEmployees->save($hrgaEmployee)) {
                $id = $hrgaEmployee->id;

                // $salaries['employee_id'] = $id;
                // $salaries['gaji_pokok'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['gaji_pokok']);
                // $salaries['tunjangan_operasional'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_operasional']);
                // $salaries['tunjangan_fungsi_group'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_fungsi_group']);
                // $salaries['tunjangan_lain'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_lain']);
                // $salaries['tunjangan_hadir'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_hadir']);
                // $salaries['tunjangan_jabatan'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_jabatan']);
                // $salaries['tunjangan_penanggung_jawab'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_penanggung_jawab']);
                // $salaries['jasa_pelayanan'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['jasa_pelayanan']);
                // $salaries['insentif'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['insentif']);
                // $salaries['insentif_hadir'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['insentif_hadir']);
                // $salaries['hadir_harian'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['hadir_harian']);
                // $salaries['lembur_harian'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['lembur_harian']);

                // $salaryTable->save($salaries);

                $user['hrga_employee_id'] = $id;
                // debug($user);
                // die;
                $userTable->save($user);

                $this->Flash->success(__('The hrga employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga employee could not be saved. Please, try again.'));
            // // debug($hrgaEmployee->getErrors());
            // die;
        }
        $users = $this->HrgaEmployees->Users->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Users.hrga_employee_id' => 0]);

        $this->DaerahKabupatens = $this->fetchTable('DaerahKabupatens');
        $kabupaten = $this->DaerahKabupatens->find('list', ['keyField' => 'nama', 'valueField' => 'nama']);
        $this->set(compact('hrgaEmployee', 'users', 'kabupaten'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Hrga Employee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $hrgaEmployee = $this->HrgaEmployees->get($id, [
            'contain' => ['HrgaEmployeeLines', 'HrgaEmployeeTrainings'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $dataRow = $this->request->getData();
            $isUser = $dataRow['is_update'];
            $auditLog = $this->Krs->auditLog("HrgaEmployees", 'N', $this->request->getParam('controller'),  $isUser, "HrgaEmployees edit");
            $dataAuditLog = array('is_log' => $auditLog);
            $date_of_birth = array('date_of_birth' => $this->Krs->dateTo($dataRow['date_of_births']));
            $work_date = array('work_date' => $this->Krs->dateTo($dataRow['work_dates']));
            $contract_start_date = array('contract_start_date' => !empty($dataRow['contract_start_dates'])  ? $this->Krs->dateTo($dataRow['contract_start_dates']) : null);
            $contract_end_date = array('contract_end_date' => !empty($dataRow['contract_end_dates'])  ? $this->Krs->dateTo($dataRow['contract_end_dates']) : null);
            $bpjs_kesehatan_date = array('bpjs_kesehatan_date' => $this->Krs->dateTo($dataRow['bpjs_kesehatan_dates'])?? null);
            $bpjs_ketenagakerjaan_date = array('bpjs_ketenagakerjaan_date' => $this->Krs->dateTo($dataRow['bpjs_ketenagakerjaan_dates'])?? null);
            $status = $dataRow['status'];
            $active = array('is_active' => in_array(strtolower($dataRow['status']), ['Resign', 'Non-Aktif', 'PHK', 'Pensiun']) ? 'N' : 'Y' );   
            $telepon = array('telp' => str_replace("_", "", $dataRow['telp']));
            $divisionData = [];
            if (!empty($dataRow['devisi'])) {
                $explodeDiv = explode('^', $dataRow['devisi']);

                $divisionData = [
                    'devisi' => $explodeDiv[0] ?? null,
                    'sub_devisi' => $explodeDiv[1] ?? null,
                ];
            }

            // // optional biar gak double
            // unset($dataRow['division']);

            $photo_path = WWW_ROOT . 'upload/employees' . DS;
            $photo_ = $dataRow['photo_path'];
            if ($photo_->getClientFilename()) {
                $photo_img = $this->Image->uploadimage($photo_path, $photo_);
                $photo = array('photo_path' => $photo_img);
            } else if ($hrgaEmployee['photo_path'] !== null) {
                $photo = array('photo_path' => $hrgaEmployee['photo_path']);
            } else {
                $photo = array('photo_path' => null);
            }

            // berkas lamaran
            $suratLamaran_ = $dataRow['berkas_surat_lamaran'];
            if ($suratLamaran_->getClientFilename()) {
                $suratLamaran_img = $this->Image->uploadimage($photo_path, $suratLamaran_);
                $suratLamaran = array('berkas_surat_lamaran' => $suratLamaran_img);
            } else if ($hrgaEmployee['berkas_surat_lamaran'] !== null) {
                $suratLamaran = array('berkas_surat_lamaran' => $hrgaEmployee['berkas_surat_lamaran']);
            } else {
                $suratLamaran = array('berkas_surat_lamaran' => null);
            }

            // berkas cv
            $cv_ = $dataRow['berkas_cv'];
            if ($cv_->getClientFilename()) {
                $cv_img = $this->Image->uploadimage($photo_path, $cv_);
                $cv = array('berkas_cv' => $cv_img);
            } else if ($hrgaEmployee['berkas_cv'] !== null) {
                $cv = array('berkas_cv' => $hrgaEmployee['berkas_cv']);
            } else {
                $cv = array('berkas_cv' => null);
            }


            // berkas ktp
            $ktp_ = $dataRow['berkas_ktp'];
            if ($ktp_->getClientFilename()) {
                $ktp_img = $this->Image->uploadimage($photo_path, $ktp_);
                $ktp = array('berkas_ktp' => $ktp_img);
            } else if ($hrgaEmployee['berkas_ktp'] !== null) {
                $ktp = array('berkas_ktp' => $hrgaEmployee['berkas_ktp']);
            } else {
                $ktp = array('berkas_ktp' => null);
            }


            // berkas ijazah
            $ijazah_ = $dataRow['berkas_ijasah'];
            if ($ijazah_->getClientFilename()) {
                $ijazah_img = $this->Image->uploadimage($photo_path, $ijazah_);
                $ijazah = array('berkas_ijasah' => $ijazah_img);
            } else if ($hrgaEmployee['berkas_ijasah'] !== null) {
                $ijazah = array('berkas_ijasah' => $hrgaEmployee['berkas_ijasah']);
            } else {
                $ijazah = array('berkas_ijasah' => null);
            }


            // berkas kk
            $kk_ = $dataRow['berkas_kk'];
            if ($kk_->getClientFilename()) {
                $kk_img = $this->Image->uploadimage($photo_path, $kk_);
                $kk = array('berkas_kk' => $kk_img);
            } else if ($hrgaEmployee['berkas_kk'] !== null) {
                $kk = array('berkas_kk' => $hrgaEmployee['berkas_kk']);
            } else {
                $kk = array('berkas_kk' => null);
            }


            // berkas skck
            $skck_ = $dataRow['berkas_skck'];
            if ($skck_->getClientFilename()) {
                $skck_img = $this->Image->uploadimage($photo_path, $skck_);
                $skck = array('berkas_skck' => $skck_img);
            } else if ($hrgaEmployee['berkas_skck'] !== null) {
                $skck = array('berkas_skck' => $hrgaEmployee['berkas_skck']);
            } else {
                $skck = array('berkas_skck' => null);
            }


            // berkas sd
            $suratDokter_ = $dataRow['berkas_surat_dokter'];
            if ($suratDokter_->getClientFilename()) {
                $suratDokter_img = $this->Image->uploadimage($photo_path, $suratDokter_);
                $suratDokter = array('berkas_surat_dokter' => $suratDokter_img);
            } else if ($hrgaEmployee['berkas_surat_dokter'] !== null) {
                $suratDokter = array('berkas_surat_dokter' => $hrgaEmployee['berkas_surat_dokter']);
            } else {
                $suratDokter = array('berkas_surat_dokter' => null);
            }


            // berkas vaksin 1
            $vaksin1_ = $dataRow['berkas_kartu_vaksin_1'];
            if ($vaksin1_->getClientFilename()) {
                $vaksin1_img = $this->Image->uploadimage($photo_path, $vaksin1_);
                $vaksin1 = array('berkas_kartu_vaksin_1' => $vaksin1_img);
            } else if ($hrgaEmployee['berkas_kartu_vaksin_1'] !== null) {
                $vaksin1 = array('berkas_kartu_vaksin_1' => $hrgaEmployee['berkas_kartu_vaksin_1']);
            } else {
                $vaksin1 = array('berkas_kartu_vaksin_1' => null);
            }


            // berkas vaksin 2
            $vaksin2_ = $dataRow['berkas_kartu_vaksin_2'];
            if ($vaksin2_->getClientFilename()) {
                $vaksin2_img = $this->Image->uploadimage($photo_path, $vaksin2_);
                $vaksin2 = array('berkas_kartu_vaksin_2' => $vaksin2_img);
            } else if ($hrgaEmployee['berkas_kartu_vaksin_2'] !== null) {
                $vaksin2 = array('berkas_kartu_vaksin_2' => $hrgaEmployee['berkas_kartu_vaksin_2']);
            } else {
                $vaksin2 = array('berkas_kartu_vaksin_2' => null);
            }


            // berkas vaksin 3
            $vaksin3_ = $dataRow['berkas_kartu_vaksin_3'];
            if ($vaksin3_->getClientFilename()) {
                $vaksin3_img = $this->Image->uploadimage($photo_path, $vaksin3_);
                $vaksin3 = array('berkas_kartu_vaksin_3' => $vaksin3_img);
            } else if ($hrgaEmployee['berkas_kartu_vaksin_3'] !== null) {
                $vaksin3 = array('berkas_kartu_vaksin_3' => $hrgaEmployee['berkas_kartu_vaksin_3']);
            } else {
                $vaksin3 = array('berkas_kartu_vaksin_3' => null);
            }


            // berkas vaksin 3
            $vaksin4_ = $dataRow['berkas_kartu_vaksin_4'];
            if ($vaksin4_->getClientFilename()) {
                $vaksin4_img = $this->Image->uploadimage($photo_path, $vaksin4_);
                $vaksin4 = array('berkas_kartu_vaksin_4' => $vaksin4_img);
            } else if ($hrgaEmployee['berkas_kartu_vaksin_4'] !== null) {
                $vaksin4 = array('berkas_kartu_vaksin_4' => $hrgaEmployee['berkas_kartu_vaksin_4']);
            } else {
                $vaksin4 = array('berkas_kartu_vaksin_4' => null);
            }
            
            // berkas kontrak 1
            $kontrak1_ = $dataRow['berkas_kontrak_1'];
            if ($kontrak1_->getClientFilename()) {
                $kontrak1_img = $this->Image->uploadimage($photo_path, $kontrak1_);
                $kontrak1 = array('berkas_kontrak_1' => $kontrak1_img);
            } else if ($hrgaEmployee['berkas_kontrak_1'] !== null) {
                $kontrak1 = array('berkas_kontrak_1' => $hrgaEmployee['berkas_kontrak_1']);
            } else {
                $kontrak1 = array('berkas_kontrak_1' => null);
            }

            // berkas kontrak 2
            $kontrak2_ = $dataRow['berkas_kontrak_2'];
            if ($kontrak2_->getClientFilename()) {
                $kontrak2_img = $this->Image->uploadimage($photo_path, $kontrak2_);
                $kontrak2 = array('berkas_kontrak_2' => $kontrak2_img);
            } else if ($hrgaEmployee['berkas_kontrak_2'] !== null) {
                $kontrak2 = array('berkas_kontrak_2' => $hrgaEmployee['berkas_kontrak_2']);
            } else {
                $kontrak2 = array('berkas_kontrak_2' => null);
            }
        

            $families = array();
            foreach ($dataRow['hrga_employee_lines'] as $index => $employee_families) {
                if (!empty($employee_families['name']) && !empty($employee_families['no_ktp'])) {
                    $families['hrga_employee_lines'][$index]['id'] = $employee_families['id'] == '' ? '' :  $employee_families['id'];
                    $families['hrga_employee_lines'][$index]['name'] = $employee_families['name'];
                    $families['hrga_employee_lines'][$index]['status_family'] = $employee_families['status_family'];
                    $families['hrga_employee_lines'][$index]['place_of_birth'] = $employee_families['place_of_birth'];
                    $families['hrga_employee_lines'][$index]['birthday'] = $this->Krs->dateTo($employee_families['birthday']);
                    $families['hrga_employee_lines'][$index]['clothes_size'] = $employee_families['clothes_size'];
                    $families['hrga_employee_lines'][$index]['address'] = $employee_families['address'];
                    $families['hrga_employee_lines'][$index]['no_ktp'] = $employee_families['no_ktp'];
                    $families['hrga_employee_lines'][$index]['telp'] = $employee_families['telp'];
                    $families['hrga_employee_lines'][$index]['pekerjaan'] = $employee_families['pekerjaan'];
                    $families['hrga_employee_lines'][$index]['bpjs_kesehatan'] = $employee_families['bpjs_kesehatan'];
                    $families['hrga_employee_lines'][$index]['bpjs_kesehatan_status'] = $employee_families['bpjs_kesehatan_status'];
                    $families['hrga_employee_lines'][$index]['bpjs_kesehatan_date'] = $this->Krs->dateTo($employee_families['bpjs_kesehatan_dates']);
                    $families['hrga_employee_lines'][$index]['riwayat_sakit'] = $employee_families['riwayat_sakit'];
                } else {
                    $families['hrga_employee_lines'] = array();
                }
            }

            $trainings = array();
            foreach ($dataRow['hrga_employee_trainings'] as $index => $trayRow) {
                if (!empty($trayRow['skill']) && !empty($trayRow['start_date']) && !empty($trayRow['end_date']) && !empty($trayRow['grade']) && !empty($trayRow['organizer'])) {
                    $trainings['hrga_employee_trainings'][$index]['id'] = $trayRow['id'] == '' ? '' :  $trayRow['id'];
                    $trainings['hrga_employee_trainings'][$index]['skill'] = $trayRow['skill'];
                    $trainings['hrga_employee_trainings'][$index]['start_date'] = $this->Krs->dateTo($trayRow['start_date']);
                    $trainings['hrga_employee_trainings'][$index]['end_date'] = $this->Krs->dateTo($trayRow['end_date']);
                    $trainings['hrga_employee_trainings'][$index]['grade'] = $trayRow['grade'];
                    $trainings['hrga_employee_trainings'][$index]['organizer'] = $trayRow['organizer'];
                } else {
                    $trainings['hrga_employee_trainings'] = array();
                }
            }

            $userTable = $this->getTableLocator()->get('Users');
            $user = $userTable->get($dataRow['user_id']);

            // $salaries = array();
            // $salaries['acc_salary']['gaji_pokok'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['gaji_pokok']);
            // $salaries['acc_salary']['tunjangan_operasional'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_operasional']);
            // $salaries['acc_salary']['tunjangan_fungsi_group'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_fungsi_group']);
            // $salaries['acc_salary']['tunjangan_lain'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_lain']);
            // $salaries['acc_salary']['tunjangan_hadir'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_hadir']);
            // $salaries['acc_salary']['tunjangan_jabatan'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_jabatan']);
            // $salaries['acc_salary']['tunjangan_penanggung_jawab'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['tunjangan_penanggung_jawab']);
            // $salaries['acc_salary']['jasa_pelayanan'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['jasa_pelayanan']);
            // $salaries['acc_salary']['insentif'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['insentif']);
            // $salaries['acc_salary']['insentif_hadir'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['insentif_hadir']);
            // $salaries['acc_salary']['hadir_harian'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['hadir_harian']);
            // $salaries['acc_salary']['lembur_harian'] = $this->Krs->nom2Dec($dataRow['acc_salaries']['lembur_harian']);


            $hrgaEmployee = $this->HrgaEmployees->patchEntity($hrgaEmployee, array_merge($dataRow, $telepon, $active, $dataAuditLog, $date_of_birth, $work_date, $contract_start_date, $contract_end_date, $bpjs_kesehatan_date, $bpjs_ketenagakerjaan_date, $photo, $suratLamaran, $cv, $ktp, $ijazah, $kk, $skck, $suratDokter, $vaksin1, $vaksin2, $vaksin3, $vaksin4,$kontrak1, $kontrak2, $families, $trainings, $divisionData));
            // debug($hrgaEmployee);
            // die;

            if ($this->HrgaEmployees->save($hrgaEmployee)) {

                $user['hrga_employee_id'] = $id;
                $userTable->save($user);

                $this->Flash->success(__('The hrga employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hrga employee could not be saved. Please, try again.'));
            debug($hrgaEmployee->getErrors()); die;
        }
        $users = $this->HrgaEmployees->Users->find('list', ['keyField' => 'id', 'valueField' => 'name']);

        $this->DaerahKabupatens = $this->fetchTable('DaerahKabupatens');
        $kabupaten = $this->DaerahKabupatens->find('list', ['keyField' => 'nama', 'valueField' => 'nama'])->toArray();
        if (!empty($hrgaEmployee->devisi) && !empty($hrgaEmployee->sub_devisi)) {
            $hrgaEmployee->devisi = $hrgaEmployee->devisi . '^' . $hrgaEmployee->sub_devisi;
        }
        $this->set(compact('hrgaEmployee', 'users', 'kabupaten'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Hrga Employee id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hrgaEmployee = $this->HrgaEmployees->get($id);
        if ($this->HrgaEmployees->delete($hrgaEmployee)) {
            $this->Flash->success(__('The hrga employee has been deleted.'));
        } else {
            $this->Flash->error(__('The hrga employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function excel()
    {
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // sheet peratama
        $sheet->setTitle('Sheet 1');
        $sheet->setCellValue('A1', 'Nama Pegawai');
        $sheet->setCellValue('B1', 'NIP');
        $sheet->setCellValue('C1', 'Devisi');
        $sheet->setCellValue('D1', 'Jabatan');
        $sheet->setCellValue('E1', 'NPWP');
        $sheet->setCellValue('F1', 'No. KTP');
        $sheet->setCellValue('G1', 'No. KK');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'Telepon');
        $sheet->setCellValue('J1', 'No. BPJS Kesehatan');
        $sheet->setCellValue('K1', 'Status BPJS Kesehatan');
        $sheet->setCellValue('L1', 'No. BPJS Ketenagakerjaan');
        $sheet->setCellValue('M1', 'Status BPJS Ketenagakerjaan');

        $row = 1;
        $col = 'N';
        for ($i = 0; $i < 5; $i++) {
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Nama Keluarga');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Status Keluarga');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Tempat/Tgl. Lahir');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Telepon');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Pekerjaan');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Ukuran Baju');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'No. KTP');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'No. BPJS');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Status BPJS');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Aktif Sampai');
            $spreadsheet->getActiveSheet()->setCellValue($col++ . $row, 'Riwayat Sakit');
        }

        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D5D5D5');
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . $row)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK)->setColor(new Color('000000'));

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $vn = $this->HrgaEmployees->find('all')->contain(['HrgaEmployeeLines'])->toArray();
        $rows = 2;
        $cols = 'N';
        foreach ($vn as $index => $data) {
            $sheet->setCellValue('A' . $rows, $data->name);
            $sheet->setCellValue('B' . $rows, $data->nip);
            $sheet->setCellValue('C' . $rows, $data->devisi);
            $sheet->setCellValue('D' . $rows, $data->position);
            $sheet->setCellValue('E' . $rows, $data->npwp);
            $sheet->setCellValue('F' . $rows, $data->no_ktp);
            $sheet->setCellValue('G' . $rows, $data->no_kk);
            $sheet->setCellValue('H' . $rows, $data->email);
            $sheet->setCellValue('I' . $rows, $data->telp);
            $sheet->setCellValue('J' . $rows, $data->bpjs_kesehatan);
            $sheet->setCellValue('K' . $rows, $data->bpjs_kesehatan_status == 'Y' ? 'Aktif' : 'Non-aktif');
            $sheet->setCellValue('L' . $rows, $data->bpjs_ketenagakerjaan);
            $sheet->setCellValue('M' . $rows, $data->bpjs_ketenagakerjaan_status == 'Y' ? 'Aktif' : 'Non-aktif');

            foreach ($data->hrga_employee_lines as $key => $value) {
                $sheet->setCellValue($cols++ . $rows, $value->name);
                $sheet->setCellValue($cols++ . $rows, $value->status_family);
                $sheet->setCellValue($cols++ . $rows, $value->place_of_birth . '/' . $value->birthday == null ? '-' : $this->Krs->fDate($value->birthday, 'd F Y'));
                $sheet->setCellValue($cols++ . $rows, $value->telp);
                $sheet->setCellValue($cols++ . $rows, $value->pekerjaan);
                $sheet->setCellValue($cols++ . $rows, $value->clothes_size);
                $sheet->setCellValue($cols++ . $rows, $value->no_ktp);
                $sheet->setCellValue($cols++ . $rows, $value->bpjs_kesehatan);
                $sheet->setCellValue($cols++ . $rows, $value->bpjs_kesehatan_status == 'Y' ? 'Aktif' : 'Non-aktif');
                $sheet->setCellValue($cols++ . $rows, $value->bpjs_kesehatan_date == null ? '-' : $this->Krs->fDate($value->bpjs_kesehatan_date, 'd-m-Y'));
                $sheet->setCellValue($cols++ . $rows, $value->riwayat_sakit);
            }
            $rows++;
        }
        $writer = new Xlsx($spreadsheet);
        // ↓↓ Added new code from here in the eariler sample code
        // Save the file in a stream
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'Pegawai-' . date('dmy-His');
        $response = $this->response;
        // Return the stream in a response
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
    
    public function addCuti()
    {
        $this->request->allowMethod(['post', 'ajax']);
        $this->autoRender = false;

        // Ambil data dari request
        $jumlahCuti = (int)$this->request->getData('jml_cuti');

        // Validasi input
        if ($jumlahCuti > 0) {
            try {
                // Update semua karyawan aktif → timpa jml_cuti
                $query = $this->HrgaEmployees->query();
                $query->update()
                    ->set(['jml_cuti' => $jumlahCuti]) // langsung timpa nilai
                    ->where(['is_active' => 'Y'])
                    ->execute();

                // Respons sukses
                $responseBody = json_encode([
                    'status' => true,
                    'message' => 'Jumlah cuti berhasil diperbarui untuk semua karyawan aktif.'
                ]);
            } catch (\Exception $e) {
                // Respons gagal dengan pesan error
                $responseBody = json_encode([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data.',
                    'errors' => $e->getMessage()
                ]);
            }
        } else {
            // Respons gagal karena validasi input
            $responseBody = json_encode([
                'status' => false,
                'message' => 'Jumlah cuti tidak valid. Harus lebih dari 0.'
            ]);
        }

        // Kembalikan JSON ke frontend (AJAX)
        return $this->response
            ->withType('application/json')
            ->withStringBody($responseBody);
    }

    private function hrgaTemplateColumns(): array
    {
        return [
            'user_id' => [
                'ID User',
                'Opsional. ID akun user, lihat sheet "Referensi User ID". Kosongkan jika pegawai belum punya akun.',
            ],
            'name' => [
                'Nama Lengkap',
                'Nama lengkap pegawai.',
            ],
            'gender' => [
                'Jenis Kelamin',
                'Isi: Male atau Female.',
            ],
            'religion' => [
                'Agama',
                'Isi salah satu: Islam, Kristen, Katolik, Hindu, Buddha, Khonghucu.',
            ],
            'status_tanggungan' => [
                'Status Tanggungan',
                'Isi salah satu kode: TK/0 (Tidak Kawin), K/0 (Kawin Tidak Punya Anak), K/1 (Kawin Anak 1), K/2 (Kawin Anak 2), K/3 (Kawin Anak 3), K/4 (Kawin Anak 4), K/5 (Kawin Anak 5), K/6 (Kawin Anak 6).',
            ],
            'place_of_birth' => [
                'Tempat Lahir',
                'Nama kabupaten/kota tempat lahir.',
            ],
            'date_of_birth' => [
                'Tanggal Lahir',
                'Format dd-mm-yyyy, contoh: 17-08-1995.',
            ],
            'address' => [
                'Alamat',
                'Alamat domisili saat ini.',
            ],
            'no_ktp' => [
                'No. KTP',
                'Nomor KTP (16 digit).',
            ],
            'no_kk' => [
                'No. KK',
                'Nomor Kartu Keluarga.',
            ],
            'address_ktp' => [
                'Alamat KTP',
                'Alamat sesuai KTP/KK.',
            ],
            'nip' => [
                'NIP',
                'Nomor Induk Pegawai (bebas, sesuai penomoran internal).',
            ],
            'pin' => [
                'PIN',
                'PIN yang terdaftar di mesin fingerprint.',
            ],
            'devisi' => [
                'Divisi',
                'Isi sesuai nama divisi di sheet "Referensi Divisi". Contoh: IT',
            ],
            'position' => [
                'Posisi / Jabatan',
                'Nama posisi/jabatan pegawai.',
            ],
            'work_date' => [
                'Tanggal Masuk Kerja',
                'Format dd-mm-yyyy.',
            ],
            'status' => [
                'Status Karyawan',
                'Isi salah satu kode, lihat daftar lengkap di sheet "Referensi Status Karyawan". Contoh: tetap, 1, 2, Resign, dst.',
            ],
            'contract_start_date' => [
                'Tgl Mulai Kontrak',
                'Format dd-mm-yyyy. Kosongkan jika bukan status kontrak.',
            ],
            'contract_end_date' => [
                'Tgl Akhir Kontrak',
                'Format dd-mm-yyyy. Kosongkan jika bukan status kontrak.',
            ],
            'email' => [
                'Email',
                'Alamat email pegawai.',
            ],
            'telp' => [
                'Telepon',
                'Nomor telepon/HP.',
            ],
            'bank_name' => [
                'Nama Bank',
                'Nama bank untuk transfer gaji.',
            ],
            'rek_name' => [
                'an. Rekening',
                'Nama pemilik rekening.',
            ],
            'rek_no' => [
                'No. Rekening',
                'Nomor rekening bank.',
            ],
            'npwp' => [
                'NPWP',
                'Nomor NPWP, format: 99.999.999.9-999.999.',
            ],
            'jml_cuti' => [
                'Jumlah Cuti',
                'PENTING. Isi angka jumlah cuti (hari). Kosongkan = dianggap 0.',
            ],
            'bpjs_kesehatan' => [
                'No. BPJS Kesehatan',
                'Nomor BPJS Kesehatan.',
            ],
            'bpjs_kesehatan_date' => [
                'Tgl BPJS Kesehatan',
                'Format dd-mm-yyyy.',
            ],
            'bpjs_kesehatan_status' => [
                'Status BPJS Kesehatan',
                'Isi: Y (aktif) atau N (tidak aktif).',
            ],
            'bpjs_ketenagakerjaan' => [
                'No. BPJS Ketenagakerjaan',
                'Nomor BPJS Ketenagakerjaan.',
            ],
            'bpjs_ketenagakerjaan_date' => [
                'Tgl BPJS Ketenagakerjaan',
                'Format dd-mm-yyyy.',
            ],
            'bpjs_ketenagakerjaan_status' => [
                'Status BPJS Ketenagakerjaan',
                'Isi: Y (aktif) atau N (tidak aktif).',
            ],
            'pendidikan' => [
                'Sekolah / Universitas',
                'Nama sekolah/universitas terakhir.',
            ],
            'jurusan' => [
                'Jurusan',
                'Jurusan pendidikan terakhir.',
            ],
            'graduation_year' => [
                'Tahun Kelulusan',
                'Format yyyy, contoh: 2013.',
            ],
            'title' => [
                'Gelar',
                'Gelar akademik (jika ada).',
            ],
        ];
    }
    
    /**
     * Data referensi Status Karyawan — disalin manual dari Krs::employeeStatus(),
     * dipakai untuk isi sheet "Referensi Status Karyawan" saja (bukan untuk
     * memvalidasi input saat import).
     */
    private function refEmployeeStatus(): array
    {
        return [
            '1' => 'Kontrak 1 (3 bulan)',
            '2' => 'Kontrak 1 (6 bulan)',
            '3' => 'Kontrak 1 (12 bulan)',
            '4' => 'Kontrak 2 (3 bulan)',
            '5' => 'Kontrak 2 (6 bulan)',
            '6' => 'Kontrak 2 (12 bulan)',
            '7' => 'Kontrak 3 (3 bulan)',
            '8' => 'Kontrak 3 (6 bulan)',
            '9' => 'Kontrak 3 (12 bulan)',
            'tetap' => 'Tetap',
            'Non-Aktif' => 'Non-Aktif',
            'Resign' => 'Resign',
            'PHK' => 'PHK',
            'Pensiun' => 'Pensiun',
        ];
    }
    
    /**
     * Data referensi Divisi^SubDivisi — disalin manual dari Krs::subDivision(),
     * dipakai untuk isi sheet "Referensi Divisi" saja (bukan untuk memvalidasi
     * input saat import). Key = value persis yang harus diisi di kolom "devisi".
     */
    // 
    private function refDivisions(): array
    {
        return [
            'FARMASI' => 'FARMASI', 'SECURITY' => 'SECURITY', 'LABORATORIUM' => 'LABORATORIUM',
            'REKAM MEDIS' => 'REKAM MEDIS', 'PARKIR' => 'PARKIR', 'RAWAT JALAN' => 'RAWAT JALAN',
            'UGD' => 'UGD', 'CLEANING SERVICE' => 'CLEANING SERVICE', 'DRIVER' => 'DRIVER',
            'KASIR' => 'KASIR', 'RADIOLOGI' => 'RADIOLOGI', 'UBS' => 'UBS', 'KLAMER' => 'KLAMER',
            'KEBIDANAN & PERINATOLOGI' => 'KEBIDANAN & PERINATOLOGI', 'UPI' => 'UPI',
            'RAWAT INAP' => 'RAWAT INAP', 'GIZI' => 'GIZI', 'AHLI GIZI' => 'AHLI GIZI',
            'LAUNDRY' => 'LAUNDRY', 'LOGISTIK' => 'LOGISTIK', 'KEUANGAN' => 'KEUANGAN',
            'ATEM' => 'ATEM', 'KESLING' => 'KESLING', 'PROMKES' => 'PROMKES',
            'CASE MANAGER' => 'CASE MANAGER', 'TEKNISI' => 'TEKNISI', 'PUJASERA' => 'PUJASERA',
            'PT. BHAKTI RAHAYU' => 'PT. BHAKTI RAHAYU', 'MANAGERIAL' => 'MANAGERIAL',
            'IT' => 'IT', 'SDM' => 'SDM', 'SEKDIR' => 'SEKDIR',
        ];
    }
    
    /**
     * GET /hr/hrga-employees/download-template
     * Generate & download file Excel template (hanya bio data hrga_employees).
     */
    public function templateExcel()
    {
        $this->request->allowMethod(['get']);
    
        $columns = $this->hrgaTemplateColumns();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pegawai');
    
        $styleArray = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ];
        $styleArrayInfo = [
            'font' => ['color' => ['argb' => 'FF757575']],
            'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'FFEFEFEF'],
            ],
        ];
    
        $colIndex = 1;
        foreach ($columns as $field => [$label, $keterangan]) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter . '1', $field);
            $sheet->setCellValue($colLetter . '2', $keterangan);
            $sheet->getColumnDimension($colLetter)->setWidth(24);
            $colIndex++;
        }
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($columns));
    
        $sheet->getStyle('A1:' . $lastCol . '1')->applyFromArray($styleArray);
        $sheet->getStyle('A2:' . $lastCol . '2')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);
        $sheet->getRowDimension(2)->setRowHeight(45);
        $sheet->freezePane('A3');
    
        // catatan tambahan (baris 4, digabung/merge, gaya sama dengan A3 pada importExampleXls)
        // $sheet->setCellValue('A4', 'Catatan: baris 1 = nama field sistem (jangan diubah), baris 2 = keterangan. Mulai isi data pegawai dari baris 3 ke bawah, satu baris = satu pegawai. Semua kolom boleh dikosongkan. Data keluarga & riwayat pelatihan dilengkapi lewat menu Edit setelah data pegawai berhasil diimport.');
        // $sheet->getStyle('A4')->applyFromArray($styleArrayInfo)->getAlignment()->setWrapText(true);
        // $sheet->mergeCells('A4:' . $lastCol . '4');
        // $sheet->getRowDimension(4)->setRowHeight(30);
    
        // ---------------- Sheet: Referensi User ID (dari database, live) ----------------
        $sheetUser = $spreadsheet->createSheet();
        $sheetUser->setTitle('Referensi User ID');
        $sheetUser->setCellValue('A1', 'id');
        $sheetUser->setCellValue('B1', 'code');
        $sheetUser->setCellValue('C1', 'name');
        $sheetUser->getStyle('A1:C1')->applyFromArray($styleArray);
        $sheetUser->getColumnDimension('A')->setWidth(10);
        $sheetUser->getColumnDimension('B')->setWidth(28);
        $sheetUser->getColumnDimension('C')->setWidth(22);
    
        $userTable = $this->getTableLocator()->get('Users');
        $users = $userTable->find()
            ->select(['id', 'code', 'name'])
            ->where(['hrga_employee_id' => 0])
            ->orderAsc('name')
            ->all();
    
        $row = 2;
        foreach ($users as $user) {
            $sheetUser->setCellValue('A' . $row, $user->id);
            $sheetUser->setCellValue('B' . $row, $user->code);
            $sheetUser->setCellValue('C' . $row, $user->name);
            $row++;
        }
        $sheetUser->freezePane('A2');
    
        // ---------------- Sheet: Referensi Status Karyawan (statis, dari Krs) ----------------
        $sheetStatus = $spreadsheet->createSheet();
        $sheetStatus->setTitle('Referensi Status Karyawan');
        $sheetStatus->setCellValue('A1', 'kode (isi di kolom status)');
        $sheetStatus->setCellValue('B1', 'keterangan');
        $sheetStatus->getStyle('A1:B1')->applyFromArray($styleArray);
        $sheetStatus->getColumnDimension('A')->setWidth(28);
        $sheetStatus->getColumnDimension('B')->setWidth(28);
        $row = 2;
        foreach ($this->refEmployeeStatus() as $kode => $ket) {
            $sheetStatus->setCellValue('A' . $row, $kode);
            $sheetStatus->setCellValue('B' . $row, $ket);
            $row++;
        }
        $sheetStatus->freezePane('A2');
    
        // ---------------- Sheet: Referensi Divisi (statis, dari Krs) ----------------
        $sheetDiv = $spreadsheet->createSheet();
        $sheetDiv->setTitle('Referensi Divisi');
        $sheetDiv->setCellValue('A1', 'kode (isi di kolom devisi)');
        $sheetDiv->setCellValue('B1', 'keterangan');
        $sheetDiv->getStyle('A1:B1')->applyFromArray($styleArray);
        $sheetDiv->getColumnDimension('A')->setWidth(55);
        $sheetDiv->getColumnDimension('B')->setWidth(45);
        $row = 2;
        foreach ($this->refDivisions() as $kode => $ket) {
            $sheetDiv->setCellValue('A' . $row, $kode);
            $sheetDiv->setCellValue('B' . $row, $ket);
            $row++;
        }
        $sheetDiv->freezePane('A2');
    
        $spreadsheet->setActiveSheetIndex(0);
    
        $writer = new Xlsx($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });
        $filename = 'template-import-pegawai-' . date('Ymd-His');
    
        return $this->response
            ->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
    
    /**
     * GET  /hr/hrga-employees/import  -> tampilkan form upload
     * POST /hr/hrga-employees/import  -> proses baca file & insert massal ke hrga_employees
     *
     * SENGAJA TANPA FILTER/VALIDASI NILAI. Apa pun yang user isi di Excel
     * (gender, status, bpjs status, dll) langsung disimpan apa adanya.
     * Kalau tidak cocok ENUM di database, biar ditolak oleh DB sendiri —
     * baris itu masuk ke daftar gagal & baris lain tetap lanjut diproses.
     */
    public function import($condition = null)
    {
        if (!$this->request->is(['patch', 'post', 'put'])) {
            return $this->redirect(['action' => 'index']);
        }
        if ($condition !== 'save') {
            return $this->redirect(['action' => 'index']);
        }
        $maxFile = 502400;
        // Ambil user yang sedang login
        $identity = $this->request->getAttribute('identity');
        $isUser = $identity ? $identity->id : 0;
        // Ambil file upload, mengikuti pola existing code
        $files = $this->request->getUploadedFiles();
        $file = $files['filename'] ?? null;
        if (!$file || !$file->getClientFileName()) {
            $this->Flash->error(__('Silakan pilih file Excel terlebih dahulu.'));
            return $this->redirect(['action' => 'index']);
        }

        // Cek ukuran file
        $sizeFile = $file->getSize();

        if ($sizeFile > $maxFile) {
            $this->Flash->error(__('Ukuran file terlalu besar.'));
            return $this->redirect(['action' => 'index']);
        }

        // Nama dan extension file
        $fileName = $file->getClientFileName();
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($extension, ['xls', 'xlsx'], true)) {
            $this->Flash->error(__('File harus berformat .xls atau .xlsx.'));
            return $this->redirect(['action' => 'index']);
        }

        // Simpan sementara file upload
        $uploadPath = WWW_ROOT . 'upload/imports/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $savedFileName = uniqid('hrga_', true) . '.' . $extension;
        $filePath = $uploadPath . $savedFileName;

        try {
            $file->moveTo($filePath);
        } catch (\Exception $e) {
            $this->Flash->error(__('File gagal diupload.'));
            return $this->redirect(['action' => 'index']);
        }

        // Tentukan reader Excel
        try {
            if ($extension === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($filePath);
        } catch (\Exception $e) {
            $this->Flash->error(
                __('File Excel tidak dapat dibaca. Pastikan file sesuai template.')
            );

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            return $this->redirect(['action' => 'index']);
        }

        // Ambil sheet Data Pegawai
        $sheet = $spreadsheet->getSheetByName('Data Pegawai');

        if (!$sheet) {
            $sheet = $spreadsheet->getSheet(0);
        }

        $fieldKeys = array_keys($this->hrgaTemplateColumns());

        $highestRow = $sheet->getHighestDataRow();

        $employeeTable = $this->HrgaEmployees;
        $userTable = $this->getTableLocator()->get('Users');

        $success = 0;
        $failed = [];

        // Data mulai baris 3
        for ($r = 3; $r <= $highestRow; $r++) {

            $rowData = [];

            foreach ($fieldKeys as $i => $field) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);

                $value = $sheet->getCell($colLetter . $r)->getValue();

                $rowData[$field] = is_string($value)
                    ? trim($value)
                    : $value;
            }

            // Lewati baris kosong
            if (count(array_filter(
                $rowData,
                fn($v) => $v !== null && $v !== ''
            )) === 0) {
                continue;
            }

            // Pecah devisi menjadi devisi + sub_devisi
            $divisionData = [];

            if (!empty($rowData['devisi'])) {
                $explodeDiv = explode('^', $rowData['devisi']);

                $divisionData = [
                    'devisi' => $explodeDiv[0] ?? null,
                    'sub_devisi' => $explodeDiv[1] ?? null,
                ];
            }

            // Convert tanggal
            $dateFields = [
                'date_of_birth',
                'work_date',
                'contract_start_date',
                'contract_end_date',
                'bpjs_kesehatan_date',
                'bpjs_ketenagakerjaan_date',
            ];

            $datesConverted = [];

            foreach ($dateFields as $df) {
                $value = $rowData[$df];

                if (empty($value)) {
                    $datesConverted[$df] = null;
                    continue;
                }

                if (is_numeric($value)) {
                    $value = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                    $value = $value->format('d-m-Y');
                }

                $datesConverted[$df] = $this->Krs->dateTo($value);
            }

            // Data yang akan disimpan
            $patchData = array_merge(
                $rowData,
                $datesConverted,
                $divisionData,
                [
                    'user_id' => !empty($rowData['user_id'])
                        ? (int)$rowData['user_id']
                        : 0,

                    'jml_cuti' => (
                        $rowData['jml_cuti'] !== null &&
                        $rowData['jml_cuti'] !== ''
                    )
                        ? (int)$rowData['jml_cuti']
                        : 0,

                    'is_create' => $isUser,
                ]
            );

            // String kosong menjadi null
            $patchData = array_map(
                fn($v) => $v === '' ? null : $v,
                $patchData
            );

            // Buat entity
            $entity = $employeeTable->newEmptyEntity();

            $entity = $employeeTable->patchEntity(
                $entity,
                $patchData
            );

            // Simpan
            if ($employeeTable->save($entity)) {

                $success++;

                // Hubungkan user dengan employee
                if (!empty($patchData['user_id'])) {

                    $user = $userTable
                        ->find()
                        ->where([
                            'id' => $patchData['user_id']
                        ])
                        ->first();

                    if ($user) {
                        $user->hrga_employee_id = $entity->id;
                        $userTable->save($user);
                    }
                }

            } else {

                $errMsgs = [];

                foreach ($entity->getErrors() as $field => $errs) {

                    $errMsgs[] =
                        $field . ': ' .
                        implode(', ', array_values($errs));
                }

                $name = $rowData['name'] ?? '-';

                $failed[] =
                    'Baris ' . $r .
                    ' (' . $name . '): ' .
                    implode(' | ', $errMsgs);
            }
        }

        // Hapus file temporary
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Flash
        if ($success > 0) {
            $this->Flash->success(
                __('{0} data pegawai berhasil diimport.', $success)
            );
        }

        if (!empty($failed)) {
            $this->Flash->error(
                __('Sebagian data gagal diimport: ') .
                implode(' | ', $failed)
            );
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    private function canViewAll(): bool
    {
        $identity = $this->request->getAttribute('identity');
        $rules = $this->Krs->_rule($identity->rules);

        return ($rules['hrgaemployees']['viewAll'] ?? 0) == 1;
    }

}
