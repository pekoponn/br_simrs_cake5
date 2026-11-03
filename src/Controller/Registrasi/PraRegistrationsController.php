<?php
declare(strict_types=1);

namespace App\Controller\Registrasi;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;

/**
 * PraRegistrations Controller
 *
 * @property \App\Model\Table\PraRegistrationsTable $PraRegistrations
 * @method \App\Model\Entity\PraRegistration[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PraRegistrationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {   
    $this->expireOverduePraRegistrations();

    $status = (string)$this->request->getQuery('status', 'belum_diproses');
        $allowedStatuses = ['belum_diproses', 'diteruskan', 'sudah_diproses', 'batal', 'all'];
        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'belum_diproses';
        }

        $key = trim((string)$this->request->getQuery('key', ''));
        $keyLabel = trim((string)$this->request->getQuery('key_label', ''));
        $appointmentDate = trim((string)$this->request->getQuery('appointment_date', ''));
        $doctorScheduleId = trim((string)$this->request->getQuery('doctor_schedule_id', ''));

        $query = $this->PraRegistrations->find()
    ->contain(['Patients', 'Doctors']);

    $query->select([
        'daily_queue_number' => $query->newExpr(
        'ROW_NUMBER() OVER (PARTITION BY PraRegistrations.doctor_id, PraRegistrations.appointment_date, PraRegistrations.appointment_time ORDER BY PraRegistrations.created ASC, PraRegistrations.id ASC)'
        ),
    ])
    ->enableAutoFields(true)
    ->order([
        'PraRegistrations.appointment_date' => 'ASC',
        'PraRegistrations.appointment_time' => 'ASC',
        'daily_queue_number' => 'ASC',
    ]);

        if ($status === 'sudah_diproses') {
            $query->where(['PraRegistrations.registration_status' => 'sudah_diproses']);
        } elseif ($status === 'diteruskan') {
            $query->where(['PraRegistrations.registration_status' => 'diteruskan']);
        } elseif ($status === 'batal') {
            $query->where(['PraRegistrations.registration_status' => 'batal']);
        } elseif ($status === 'belum_diproses') {
            $query->where(function ($exp) {
                return $exp->or([
                    'PraRegistrations.registration_status IS' => null,
                    'PraRegistrations.registration_status' => 'belum_diproses',
                ]);
            });
        }
        // $status === 'all' -> tidak difilter sama sekali.

        if ($key !== '') {
            $query->where(['PraRegistrations.reservation_code LIKE' => '%' . $key . '%']);
        }

        if ($keyLabel !== '') {
            $like = '%' . $keyLabel . '%';
            $query->where(function ($exp) use ($like) {
                return $exp->or_([
                    'PraRegistrations.patient_name LIKE' => $like,
                    'PraRegistrations.medical_record_no LIKE' => $like,
                    'PraRegistrations.card_number LIKE' => $like,
                ]);
            });
        }

        if ($appointmentDate !== '') {
            $query->where(['PraRegistrations.appointment_date' => $appointmentDate]);
        }

        if ($doctorScheduleId !== '') {
            $this->DoctorSchedules = $this->fetchTable('DoctorSchedules');
            $selectedSchedule = $this->DoctorSchedules->find()
                ->where(['DoctorSchedules.id' => (int)$doctorScheduleId])
                ->first();

            if ($selectedSchedule) {
                $query->where(['PraRegistrations.doctor_id' => $selectedSchedule->doctor_id]);
                $query->where(['PraRegistrations.appointment_time' => $selectedSchedule->start_time]);
                $query->where(function ($exp, $q) use ($selectedSchedule) {
                    return $exp->eq(
                        $q->newExpr('DAYNAME(PraRegistrations.appointment_date)'),
                        $this->toEnglishDay((string)$selectedSchedule->day)
                    );
                });
            }
        }

        $this->paginate = [
            'limit' => 20,
        ];

        $praRegistrations = $this->paginate($query);

        $this->attachEstimatedCallTime($praRegistrations);

        $doctorSchedulesForModal = $this->buildDoctorScheduleList();

        $this->set(compact('praRegistrations', 'doctorSchedulesForModal', 'doctorScheduleId', 'appointmentDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Pra Registration id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $praRegistration = $this->PraRegistrations->get($id, [
            'contain' => ['Patients', 'Doctors'],
        ]);

        $this->set(compact('praRegistration'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $praRegistration = $this->PraRegistrations->newEmptyEntity();
        $rescheduleGuarantor = null;

        $rescheduleFromId = $this->request->getQuery('reschedule_from');
        if (!$this->request->is('post') && !empty($rescheduleFromId)) {
            $oldPraRegistration = $this->PraRegistrations->find()
                ->where(['PraRegistrations.id' => (int)$rescheduleFromId])
                ->first();

            if ($oldPraRegistration) {
                $rescheduleBirthDate = !empty($oldPraRegistration->birth_date)
                    ? $oldPraRegistration->birth_date->format('Y-m-d')
                    : null;

                $praRegistration = $this->PraRegistrations->patchEntity($praRegistration, [
                    'patient_id' => $oldPraRegistration->patient_id ?? null,
                    'patients_name' => $oldPraRegistration->patient_name,
                    'medical_record_no' => $oldPraRegistration->medical_record_no,
                    'birth_date' => $rescheduleBirthDate,
                    'phone_number' => $oldPraRegistration->phone_number,
                    'nik' => $oldPraRegistration->nik ?? null,
                    'address' => $oldPraRegistration->address ?? null,
                    'card_number' => $oldPraRegistration->card_number,
                    'referral_number' => $oldPraRegistration->referral_number,
                    'referral_type' => $oldPraRegistration->referral_type ?? null,
                    'channel' => $oldPraRegistration->channel ?? null,
                    'planned_action' => $oldPraRegistration->planned_action ?? null,
                    'notes' => $oldPraRegistration->notes,
                ], ['validate' => false]);

                $praRegistration->patients_name = $oldPraRegistration->patient_name;
                $praRegistration->birth_date = $rescheduleBirthDate;
                $rescheduleGuarantor = $oldPraRegistration->guarantor ?? null;

                $this->Flash->success(__('Data pasien diisi ulang dari pra registrasi sebelumnya. Silakan pilih jadwal baru.'));
            }
        }

        if ($this->request->is('post')) {
            $data = $this->prepareRegistrationData($this->request->getData());
            $praRegistration = $this->PraRegistrations->patchEntity($praRegistration, $data);
            if ($this->PraRegistrations->save($praRegistration)) {
                $this->Flash->success(__('The pra registration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pra registration could not be saved. Please, try again.'));
            // Tampilkan detail error field agar mudah ditelusuri (aman dihapus setelah selesai debug).
            $errors = $praRegistration->getErrors();
            if (!empty($errors)) {
                $this->Flash->error('Detail error: ' . json_encode($errors));
            }
        }
        $patients = $this->PraRegistrations->Patients->find('list', ['limit' => 200]);
        $doctors = $this->PraRegistrations->Doctors->find('list', ['limit' => 200]);
        $masterPenjamins = $this->getMasterPenjaminList();
        $this->set(compact('praRegistration', 'patients', 'doctors', 'masterPenjamins', 'rescheduleGuarantor'));
    }

    /**
     * Lengkapi/normalisasi data dari form sebelum di-patch ke entity, supaya
     * kolom-kolom wajib (reservation_code, patient_name, doctor_name,
     * appointment_date, appointment_time) selalu terisi meski nama field
     * di form beda / bergantung pada pilihan kartu poli & sesi di UI.
     *
     * @param array $data Data mentah dari request POST.
     * @return array
     */
    private function prepareRegistrationData(array $data): array
    {
        // Form pakai nama field "patients_name" (ada huruf s), sedangkan
        // kolom tabel adalah "patient_name". Petakan di sini.
        if (empty($data['patient_name']) && !empty($data['patients_name'])) {
            $data['patient_name'] = $data['patients_name'];
        }

        // Input tanggal kunjungan bernama "visit_date" di form,
        // sedangkan kolom tabel adalah "appointment_date".
        if (empty($data['appointment_date']) && !empty($data['visit_date'])) {
            $data['appointment_date'] = $data['visit_date'];
            $data['appointment_day'] = date('l', strtotime($data['visit_date']));
        }

        // Simpan pilihan jenis asuransi sebagai penjamin, kalau kolom
        // guarantor belum diisi manual.
        if (empty($data['guarantor']) && !empty($data['insurance_type'])) {
            $data['guarantor'] = $data['insurance_type'];
        }

        // No. Reservasi diisi otomatis oleh sistem (readonly di form).
        if (empty($data['reservation_code'])) {
            $data['reservation_code'] = $this->generateReservationCode();
        }

        return $data;
    }

    /**
     * Generate kode reservasi unik, format: PRA-YYMMDD-XXXXX
     *
     * @return string
     */
    private function generateReservationCode(): string
    {
        do {
            $code = 'PRA-' . date('ymd') . '-' . strtoupper(substr(uniqid(), -5));
        } while ($this->PraRegistrations->exists(['reservation_code' => $code]));

        return $code;
    }

    /**
 * @param string $englishDay
 * @return string
 */
private function toIndonesianDay(string $englishDay): string
{
    $map = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu',
    ];

    return $map[$englishDay] ?? $englishDay;
}

/**
 * @param string $indonesianDay
 * @return string
 */
private function toEnglishDay(string $indonesianDay): string
{
    $map = [
        'Senin'  => 'Monday',
        'Selasa' => 'Tuesday',
        'Rabu'   => 'Wednesday',
        'Kamis'  => 'Thursday',
        'Jumat'  => 'Friday',
        'Sabtu'  => 'Saturday',
        'Minggu' => 'Sunday',
    ];

    return $map[$indonesianDay] ?? $indonesianDay;
}

/**
 * @return array<int, string>
 */

/**
 * @return array<int, array<string, mixed>>
 */
private function buildDoctorScheduleList(): array
{
    $dayOrderCase = "CASE DoctorSchedules.day
        WHEN 'Senin' THEN 1
        WHEN 'Selasa' THEN 2
        WHEN 'Rabu' THEN 3
        WHEN 'Kamis' THEN 4
        WHEN 'Jumat' THEN 5
        WHEN 'Sabtu' THEN 6
        WHEN 'Minggu' THEN 7
        ELSE 8
    END";

    /** @var \App\Model\Table\DoctorSchedulesTable $doctorSchedulesTable */
    $doctorSchedulesTable = TableRegistry::getTableLocator()->get('DoctorSchedules');

    $schedules = $doctorSchedulesTable->find()
        ->contain(['Doctors'])
        ->select([
            'DoctorSchedules.id',
            'DoctorSchedules.day',
            'DoctorSchedules.start_time',
            'DoctorSchedules.end_time',
            'DoctorSchedules.quota',
            'DoctorSchedules.quota_used',
            'Doctors.id',
            'Doctors.doctor_name',
            'Doctors.polyclinic_name',
            'day_order' => $dayOrderCase,
        ])
        ->where(['DoctorSchedules.is_active' => 'Y'])
        ->order([
            'day_order' => 'ASC',
            'Doctors.doctor_name' => 'ASC',
        ])
        ->all();

    $list = [];
    foreach ($schedules as $schedule) {
        $list[] = [
            'id' => (int)$schedule->id,
            'doctor_name' => $schedule->doctor->doctor_name ?? '-',
            'poly_name' => $schedule->doctor->polyclinic_name ?? '-',
            'day' => $schedule->day,
            'start_time' => substr((string)$schedule->start_time, 0, 5),
            'end_time' => substr((string)$schedule->end_time, 0, 5),
            'quota' => (int)$schedule->quota,
            'quota_used' => (int)($schedule->quota_used ?? 0),
        ];
    }

    return $list;
}

/**
 * @param iterable $praRegistrations
 * @return void
 */
private function attachEstimatedCallTime(iterable $praRegistrations): void
{
    /** @var \App\Model\Table\DoctorSchedulesTable $doctorSchedulesTable */
    $doctorSchedulesTable = TableRegistry::getTableLocator()->get('DoctorSchedules');
    $scheduleCache = [];

    foreach ($praRegistrations as $item) {
        $doctorId = $item->doctor_id ?? null;
        $appointmentDate = $item->appointment_date ?? null;
        $appointmentTime = $item->appointment_time ?? null;

        if (empty($doctorId) || empty($appointmentDate) || empty($appointmentTime)) {
            $item->estimated_call_time = null;
            continue;
        }

        $dateTimestamp = is_object($appointmentDate) && method_exists($appointmentDate, 'format')
            ? strtotime($appointmentDate->format('Y-m-d'))
            : strtotime((string)$appointmentDate);

        $timeString = is_object($appointmentTime) && method_exists($appointmentTime, 'format')
            ? $appointmentTime->format('H:i:s')
            : (string)$appointmentTime;

        if (!$dateTimestamp || $timeString === '') {
            $item->estimated_call_time = null;
            continue;
        }

        $dayName = $this->toIndonesianDay(date('l', $dateTimestamp));
        $cacheKey = $doctorId . '|' . $dayName . '|' . $timeString;

        if (!array_key_exists($cacheKey, $scheduleCache)) {
            $scheduleCache[$cacheKey] = $doctorSchedulesTable->find()
                ->select(['estimated_minutes'])
                ->where([
                    'doctor_id' => $doctorId,
                    'day' => $dayName,
                    'start_time' => $timeString,
                ])
                ->first();
        }

        $schedule = $scheduleCache[$cacheKey];
        $estimatedMinutes = (int)($schedule->estimated_minutes ?? 0);
        $queueNumber = (int)($item->daily_queue_number ?? 1);

        if ($estimatedMinutes <= 0) {
            // Tidak ada estimasi tersimpan, tampilkan jam asli jadwal saja.
            $item->estimated_call_time = date('H:i', strtotime($timeString));
            continue;
        }

        $baseTimestamp = strtotime($timeString);
        $offsetMinutes = ($queueNumber - 1) * $estimatedMinutes;

        $item->estimated_call_time = date('H:i', $baseTimestamp + ($offsetMinutes * 60));
    }
}

    /**
     * Edit method
     *
     * @param string|null $id Pra Registration id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $praRegistration = $this->PraRegistrations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $praRegistration = $this->PraRegistrations->patchEntity($praRegistration, $this->request->getData());
            if ($this->PraRegistrations->save($praRegistration)) {
                $this->Flash->success(__('The pra registration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pra registration could not be saved. Please, try again.'));
        }
        $patients = $this->PraRegistrations->Patients->find('list', ['limit' => 200]);
        $doctors = $this->PraRegistrations->Doctors->find('list', ['limit' => 200]);
        $masterPenjamins = $this->getMasterPenjaminList();
        $this->set(compact('praRegistration', 'patients', 'doctors', 'masterPenjamins'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pra Registration id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $praRegistration = $this->PraRegistrations->get($id);
        if ($this->PraRegistrations->delete($praRegistration)) {
            $this->Flash->success(__('The pra registration has been deleted.'));
        } else {
            $this->Flash->error(__('The pra registration could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Register method — dipanggil dari tombol "Daftarkan" di index.
     *
     * Tidak membuat data apa pun di sini. Pra registrasi yang belum
     * diproses SUDAH otomatis muncul di halaman Pendaftaran Pasien
     * (PatientAdmissions) tab "Pra Registrasi", karena tab itu query
     * langsung ke tabel pra_registrations (lihat
     * PatientAdmissionsController::buildPraRegistrasiQuery()).
     *
     * Jadi "Daftarkan" di sini cuma mengarahkan petugas ke tab tersebut.
     * Dari situ petugas klik "Proses" per baris untuk baru masuk ke
     * Registrations/add dan melengkapi registrasi resminya.
     *
     * Alurnya: Daftarkan -> Pendaftaran Pasien (tab Pra Registrasi) -> klik
     * baris/tombol Proses -> Registrations/add.
     *
     * Catatan: registration_status baru ditandai 'sudah_diproses' saat
     * Registrations/add berhasil menyimpan registrasi resmi dengan
     * source_pra_registration_id ini (perlu ditambahkan di
     * RegistrationsController::add()).
     *
     * @param string|null $id Pra Registration id.
     * @return \Cake\Http\Response|null
     */
    public function initialize(): void
{
    parent::initialize();
    $this->PolyclinicQueues = $this->fetchTable('PolyclinicQueues');
}

public function register($id = null)
{
    $this->request->allowMethod(['post']);

    $praRegistration = $this->PraRegistrations->get($id);

    $status = $praRegistration->registration_status ?? 'belum_diproses';
    if (in_array($status, ['diteruskan', 'sudah_diproses'], true)) {
        $this->Flash->error(__('Pra registrasi ini sudah pernah didaftarkan.'));
        return $this->redirect(['action' => 'index']);
    }
    if ($status === 'batal') {
        $this->Flash->error(__('Pra registrasi ini sudah dibatalkan karena jadwal terlewat. Silakan daftarkan ulang dengan jadwal baru.'));
        return $this->redirect(['action' => 'index']);
    }

    $conn = $this->PraRegistrations->getConnection();
    $saved = false;
    $queue = null;

    try {
        $conn->transactional(function () use (&$saved, &$queue, $praRegistration) {
            $visitDate = !empty($praRegistration->appointment_date)
                ? (is_object($praRegistration->appointment_date) && method_exists($praRegistration->appointment_date, 'format')
                    ? $praRegistration->appointment_date->format('Y-m-d')
                    : (string)$praRegistration->appointment_date)
                : date('Y-m-d');

            $apptTimeStr = !empty($praRegistration->appointment_time)
                ? (is_object($praRegistration->appointment_time) && method_exists($praRegistration->appointment_time, 'format')
                    ? $praRegistration->appointment_time->format('H:i')
                    : substr((string)$praRegistration->appointment_time, 0, 5))
                : '';
            $codePrefix = ($apptTimeStr !== '' && $apptTimeStr < '12:00') ? 'A' : 'B';
            $lastQueue = $this->PolyclinicQueues->find()
                ->where(['PolyclinicQueues.code LIKE' => $codePrefix . '-%'])
                ->where(function ($exp) use ($visitDate) {
                    $startDate = $visitDate . ' 00:00:00';
                    $endDate = $visitDate . ' 23:59:59';

                    return $exp->or_([
                        'PolyclinicQueues.visit_date' => $visitDate,
                        $exp->and_([
                            'PolyclinicQueues.visit_date IS' => null,
                            'PolyclinicQueues.created >=' => $startDate,
                            'PolyclinicQueues.created <=' => $endDate,
                        ]),
                    ]);
                })
                ->order(['PolyclinicQueues.queue_number' => 'DESC', 'PolyclinicQueues.id' => 'DESC'])
                ->epilog('FOR UPDATE')
                ->first();

            $nextNumber = $lastQueue ? ((int)$lastQueue->queue_number + 1) : 1;

                        $queue = $this->PolyclinicQueues->newEmptyEntity();
            $queue = $this->PolyclinicQueues->patchEntity($queue, [
                'code' => $codePrefix . '-' . str_pad((string)$nextNumber, 3, '0', STR_PAD_LEFT),
                'source' => 'Rujukan',
                'poly_name' => $praRegistration->poly_name,
                'patients_name' => $praRegistration->patient_name,
                'no_telp' => $praRegistration->phone_number,
                'patient_id' => $praRegistration->patient_id,
                'medical_record_no' => $praRegistration->medical_record_no,
                'doctor_id' => $praRegistration->doctor_id,
                'doctor_name' => $praRegistration->doctor_name,
                'queue_number' => $nextNumber,
                'visit_date' => $visitDate,
                'checkin_status' => 'Belum Check-in',
                'call_status' => 'Menunggu',
                'call_count' => 0,
                'is_create' => 1,
                'is_update' => 0,
                'is_delete' => 0,
                'is_active' => 'Y',
            ], ['validate' => false]);

            if (!$this->PolyclinicQueues->save($queue, ['checkRules' => false])) {
                throw new \Exception('queue-save-failed');
            }

            $praRegistration->polyclinic_queue_id = $queue->id;
            $praRegistration->registration_status = 'diteruskan';

            if (!$this->PraRegistrations->save($praRegistration, ['checkRules' => false])) {
                throw new \Exception('pra-save-failed');
            }

            $saved = true;
        });
    } catch (\Throwable $e) {
        $saved = false;
    }

    if (!$saved) {
        $this->Flash->error(__('Gagal meneruskan pra registrasi ke Pendaftaran Pasien. Silakan coba lagi.'));
        return $this->redirect(['action' => 'index']);
    }

    $this->Flash->success(__(
        'Pasien ' . $praRegistration->patient_name . ' masuk ke daftar Pendaftaran Pasien '
        . '(tab Instalasi Rawat Jalan) dengan nomor antrian ' . $queue->code . '. Silakan lengkapi registrasinya di sana.'
    ));

    return $this->redirect([
        'controller' => 'PatientAdmissions',
        'action' => 'index',
        '?' => ['tab' => 'rawat_jalan'],
    ]);
}

    /**
     * Ambil daftar master penjamin aktif untuk dropdown "Jenis Asuransi".
     * key   = code (mis. PJM-0001)
     * value = "NAMA PENJAMIN (JENIS)"
     *
     * @return array<string, string>
     */
    private function getMasterPenjaminList(): array
    {
        /** @var \App\Model\Table\MasterPenjaminsTable $masterPenjaminsTable */
        $masterPenjaminsTable = TableRegistry::getTableLocator()->get('MasterPenjamins');

        $rows = $masterPenjaminsTable->find()
            ->select(['code', 'name', 'type'])
            ->where(['is_active' => 'Y'])
            ->order(['name' => 'ASC'])
            ->all();

        $list = [];
        foreach ($rows as $row) {
            $list[$row->code] = $row->name . ' (' . str_replace('_', ' ', (string)$row->type) . ')';
        }

        return $list;
    }

    /**
     * Cancel method — dipanggil dari tombol "Batalkan" di index, untuk
     * membatalkan pra registrasi secara manual (mis. pasien berhalangan/
     * keluar kota), tanpa harus menunggu auto-expire oleh
     * expireOverduePraRegistrations().
     *
     * @param string|null $id Pra Registration id.
     * @return \Cake\Http\Response|null
     */
    public function cancel($id = null)
    {
        $this->request->allowMethod(['post']);

        $praRegistration = $this->PraRegistrations->get($id);

        $status = $praRegistration->registration_status ?? 'belum_diproses';
        if (in_array($status, ['diteruskan', 'sudah_diproses'], true)) {
            $this->Flash->error(__('Pra registrasi ini sudah diproses, tidak bisa dibatalkan dari sini.'));

            return $this->redirect(['action' => 'index']);
        }
        if ($status === 'batal') {
            $this->Flash->error(__('Pra registrasi ini sudah dibatalkan sebelumnya.'));

            return $this->redirect(['action' => 'index']);
        }

        $praRegistration->registration_status = 'batal';

        if (!$this->PraRegistrations->save($praRegistration, ['checkRules' => false])) {
            $this->Flash->error(__('Gagal membatalkan pra registrasi. Silakan coba lagi.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->success(__('Pra registrasi ' . $praRegistration->patient_name . ' berhasil dibatalkan.'));

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Tandai pra registrasi yang jadwalnya (appointment_date + appointment_time)
     * sudah lewat dari sekarang, tapi belum pernah diproses/diteruskan
     * (masih NULL atau 'belum_diproses'), jadi 'batal'. Dijalankan tiap kali
     * halaman index dibuka supaya data lama otomatis "expired".
     *
     * @return void
     */
        private function expireOverduePraRegistrations(): void
    {
        $today = date('Y-m-d');
        $nowTime = date('H:i:s');

        $dayCase = "CASE DAYNAME(pr.appointment_date)
            WHEN 'Monday' THEN 'Senin'
            WHEN 'Tuesday' THEN 'Selasa'
            WHEN 'Wednesday' THEN 'Rabu'
            WHEN 'Thursday' THEN 'Kamis'
            WHEN 'Friday' THEN 'Jumat'
            WHEN 'Saturday' THEN 'Sabtu'
            WHEN 'Sunday' THEN 'Minggu'
        END";

        $sql = "
            UPDATE pra_registrations pr
            LEFT JOIN doctor_schedules ds
                ON ds.doctor_id = pr.doctor_id
               AND ds.day = ($dayCase)
               AND ds.start_time = pr.appointment_time
            SET pr.registration_status = 'batal'
            WHERE (pr.registration_status IS NULL OR pr.registration_status = 'belum_diproses')
              AND (
                    pr.appointment_date < :today
                    OR (
                        pr.appointment_date = :today
                        AND ds.end_time IS NOT NULL
                        AND ds.end_time < :nowTime
                    )
                  )
        ";

        $this->PraRegistrations->getConnection()->execute($sql, [
            'today' => $today,
            'nowTime' => $nowTime,
        ]);
    }
}