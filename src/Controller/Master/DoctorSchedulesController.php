<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

class DoctorSchedulesController extends AppController
{
        public function index()
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

        $query = $this->DoctorSchedules->find()
            ->contain(['Doctors'])
             ->select([
                'DoctorSchedules.id',
                'DoctorSchedules.code',
                'DoctorSchedules.doctor_id',
                'DoctorSchedules.day',
                'DoctorSchedules.start_time',
                'DoctorSchedules.end_time',
                'DoctorSchedules.quota',
                'DoctorSchedules.quota_used',
                'DoctorSchedules.estimated_minutes',
                'DoctorSchedules.note',
                'DoctorSchedules.is_active',
                'Doctors.id',
                'Doctors.doctor_name',
                'Doctors.polyclinic_name',
                'day_order' => $dayOrderCase,
            ])
            ->order([
                'Doctors.doctor_name' => 'ASC',
                'day_order' => 'ASC',
            ]);
        
        $q = trim((string)$this->request->getQuery('q'));
        $dayFilter = $this->request->getQuery('day');
        $activeFilter = $this->request->getQuery('is_active');

        if ($q !== '') {
            $query->andWhere(['OR' => [
                'DoctorSchedules.code LIKE' => '%' . $q . '%',
                'Doctors.doctor_name LIKE' => '%' . $q . '%',
                'Doctors.polyclinic_name LIKE' => '%' . $q . '%',
            ]]);
        }

        if ($dayFilter !== null && $dayFilter !== '') {
            $query->andWhere(['DoctorSchedules.day' => $dayFilter]);
        }

        if ($activeFilter !== null && $activeFilter !== '') {
            if ($activeFilter === '1') {
                $query->andWhere(['DoctorSchedules.is_active IN' => [1, '1', 'Y', true]]);
            } else {
                $query->andWhere(['DoctorSchedules.is_active IN' => [0, '0', 'N', false]]);
            }
        }

        $this->paginate = [
            'limit' => 200,
            'order' => [],
        ];

        $doctorSchedules = $this->paginate($query);

        foreach ($doctorSchedules as $ds) {
            $ds->effective_quota_used = $this->getEffectiveQuotaUsed($ds);
        }

        $this->set(compact('doctorSchedules'));
    }

        public function view($id = null)
    {
        $doctorSchedule = $this->DoctorSchedules->get($id, [
            'contain' => ['Doctors'],
        ]);

        $this->archiveExpiredDoctorScheduleCycle($doctorSchedule);

        $currentCycleDate = $this->getDoctorScheduleCycleDate((string)$doctorSchedule->day);
        $currentQuotaUsed = (int)($doctorSchedule->quota_used ?? 0);

        $this->DoctorScheduleQuotaHistories = $this->fetchTable('DoctorScheduleQuotaHistories');
        $quotaHistories = $this->DoctorScheduleQuotaHistories->find()
            ->where(['doctor_schedule_id' => $doctorSchedule->id])
            ->order(['cycle_date' => 'DESC'])
            ->limit(30)
            ->all();

        $this->set(compact('doctorSchedule', 'currentCycleDate', 'currentQuotaUsed', 'quotaHistories'));
    }

       /**
     * Urutan hari dalam seminggu, dipakai untuk loop checkbox di form
     * dan untuk validasi nama hari yang dikirim dari form.
     */
    private function getWeekDayOrder(): array
    {
        return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    }

    private function calculateEstimatedMinutes(string $startTime, string $endTime, int $quota): ?int
    {
        if ($quota <= 0) {
            return null;
        }

        $start = strtotime($startTime);
        $end = strtotime($endTime);

        if ($start === false || $end === false || $end <= $start) {
            return null;
        }

        $totalMinutes = ($end - $start) / 60;

        return (int) round($totalMinutes / $quota);
    }

    public function add()
    {
        $doctorSchedule = $this->DoctorSchedules->newEmptyEntity();
        $weekDays = $this->getWeekDayOrder();

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            $doctorId = $data['doctor_id'] ?? null;
            $isActive = $data['is_active'] ?? 'Y';
            $note = $data['note'] ?? null;
            $daysData = $data['days'] ?? [];

            if (empty($doctorId)) {
                $this->Flash->error(__('Dokter belum dipilih.'));

                return $this->redirect(['action' => 'add']);
            }

            // Kumpulkan hari yang dicentang beserta jam & kuotanya.
            $selectedDays = [];
            foreach ($weekDays as $dayName) {
                $dayRow = $daysData[$dayName] ?? null;

                if (empty($dayRow['checked'])) {
                    continue;
                }

                $startTime = trim((string)($dayRow['start_time'] ?? ''));
                $endTime = trim((string)($dayRow['end_time'] ?? ''));

                if ($startTime === '' || $endTime === '') {
                    $this->Flash->error(__('Jam mulai & jam selesai wajib diisi untuk hari ' . $dayName . '.'));

                    return $this->redirect(['action' => 'add']);
                }

                $selectedDays[] = [
                    'day' => $dayName,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'quota' => (int)($dayRow['quota'] ?? 0),
                ];
            }

            if (empty($selectedDays)) {
                $this->Flash->error(__('Pilih minimal satu hari jadwal praktik.'));

                return $this->redirect(['action' => 'add']);
            }

            $connection = $this->DoctorSchedules->getConnection();
            $connection->begin();

            $savedCount = 0;
            $saveErrors = [];

            foreach ($selectedDays as $index => $row) {
                $entity = $this->DoctorSchedules->newEmptyEntity();

                $entityData = [
                    'doctor_id' => $doctorId,
                    'day' => $row['day'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time'],
                    'quota' => $row['quota'],
                    'estimated_minutes' => $this->calculateEstimatedMinutes(
                        $row['start_time'],
                        $row['end_time'],
                        $row['quota']
                    ),
                    'note' => $note,
                    'is_active' => $isActive,
                    'code' => 'DS-' . date('YmdHis') . '-' . strtoupper(substr($row['day'], 0, 3)),
                    'is_create' => 1,
                    'is_update' => 0,
                    'is_delete' => 0,
                    'delete_log' => null,
                ];

                $entity = $this->DoctorSchedules->patchEntity($entity, $entityData);

                if ($this->DoctorSchedules->save($entity)) {
                    $savedCount++;
                } else {
                    $saveErrors[$row['day']] = $entity->getErrors();
                }
            }

            if (!empty($saveErrors)) {
                $connection->rollback();

                $this->Flash->error(__('Sebagian jadwal gagal disimpan: ' . json_encode($saveErrors, JSON_PRETTY_PRINT)));

                return $this->redirect(['action' => 'add']);
            }

            $connection->commit();

            $this->Flash->success(__($savedCount . ' jadwal dokter berhasil disimpan untuk 1 minggu.'));

            return $this->redirect(['action' => 'index']);
        }

        // tampilkan nama dokter
        $doctors = $this->DoctorSchedules->Doctors
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'doctor_name' // ganti jika nama field berbeda
            ])
            ->toArray();

        // mapping doctor_id => nama poli, dipakai JS untuk auto-isi field Poli
        $doctorPolyclinics = $this->DoctorSchedules->Doctors
            ->find()
            ->select(['id', 'polyclinic_name'])
            ->all()
            ->combine('id', 'polyclinic_name')
            ->toArray();

        $this->set(compact(
            'doctorSchedule',
            'doctors',
            'doctorPolyclinics',
            'weekDays'
        ));
    }

    public function edit($id = null)
    {
        $doctorSchedule = $this->DoctorSchedules->get($id);

        if ($this->request->is([
            'patch',
            'post',
            'put'
        ])) {

            $data = $this->request->getData();

        $data['is_update'] = 1;

        if (!empty($data['start_time']) && !empty($data['end_time']) && isset($data['quota'])) {
            $data['estimated_minutes'] = $this->calculateEstimatedMinutes(
                (string)$data['start_time'],
                (string)$data['end_time'],
                (int)$data['quota']
            );
        }

        $doctorSchedule = $this->DoctorSchedules->patchEntity(
            $doctorSchedule,
            $data
        );

            if ($this->DoctorSchedules->save($doctorSchedule)) {

                $this->Flash->success(
                    __('Jadwal dokter berhasil diubah.')
                );

                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $errors = json_encode(
                $doctorSchedule->getErrors(),
                JSON_PRETTY_PRINT
            );

            $this->Flash->error(
                __('Jadwal dokter gagal diubah: ' . $errors)
            );
        }

        $doctors = $this->DoctorSchedules->Doctors
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'doctor_name' // ganti jika berbeda
            ])
            ->toArray();

        $this->set(compact(
            'doctorSchedule',
            'doctors'
        ));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod([
            'post',
            'delete'
        ]);

        $doctorSchedule = $this->DoctorSchedules->get($id);

        // soft delete
        $doctorSchedule->is_delete = 1;
        $doctorSchedule->delete_log = date('Y-m-d H:i:s');

        if ($this->DoctorSchedules->save($doctorSchedule)) {

            $this->Flash->success(
                __('Jadwal dokter berhasil dihapus.')
            );

        } else {

            $this->Flash->error(
                __('Jadwal dokter gagal dihapus.')
            );
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }
}