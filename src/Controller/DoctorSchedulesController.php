<?php
declare(strict_types=1);

namespace App\Controller;

class DoctorSchedulesController extends AppController
{
    public function index()
    {
        $this->paginate = [
            'contain' => ['Doctors'],
        ];

        $doctorSchedules = $this->paginate($this->DoctorSchedules);

        $this->set(compact('doctorSchedules'));
    }

    public function view($id = null)
    {
        $doctorSchedule = $this->DoctorSchedules->get($id, [
            'contain' => ['Doctors'],
        ]);

        $currentCycleDate = $this->getDoctorScheduleCycleDate((string)$doctorSchedule->day);
        $currentQuotaUsed = $this->getEffectiveQuotaUsed($doctorSchedule);

        $this->loadModel('DoctorScheduleQuotaHistories');
        $quotaHistories = $this->DoctorScheduleQuotaHistories->find()
            ->where(['doctor_schedule_id' => $doctorSchedule->id])
            ->order(['cycle_date' => 'DESC'])
            ->limit(30)
            ->all();

        $this->set(compact('doctorSchedule', 'currentCycleDate', 'currentQuotaUsed', 'quotaHistories'));
    }

    public function add()
    {
        $doctorSchedule = $this->DoctorSchedules->newEmptyEntity();

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            // otomatis generate data
            $data['code'] = 'DS-' . date('YmdHis');
            $data['is_create'] = 1;
            $data['is_update'] = 0;
            $data['is_delete'] = 0;
            $data['delete_log'] = null;

            $doctorSchedule = $this->DoctorSchedules->patchEntity(
                $doctorSchedule,
                $data
            );

            if ($this->DoctorSchedules->save($doctorSchedule)) {

                $this->Flash->success(
                    __('Jadwal dokter berhasil disimpan.')
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
                __('Jadwal dokter gagal disimpan: ' . $errors)
            );
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
            'doctorPolyclinics'
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

            // update otomatis
            $data['is_update'] = 1;

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