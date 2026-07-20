<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Doctors Controller
 *
 * @property \App\Model\Table\DoctorsTable $Doctors
 * @method \App\Model\Entity\Doctor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DoctorsController extends AppController
{
    public function index()
    {
        $key = $this->request->getQuery('key');
        $gender = $this->request->getQuery('gender');
        $isActive = $this->request->getQuery('is_active');

        $query = $this->Doctors->find();

        if (!empty($key)) {
            $query->where([
                'OR' => [
                    'Doctors.code LIKE' => '%' . $key . '%',
                    'Doctors.doctor_name LIKE' => '%' . $key . '%',
                    'Doctors.nik LIKE' => '%' . $key . '%',
                    'Doctors.specialist LIKE' => '%' . $key . '%',
                    'Doctors.polyclinic_name LIKE' => '%' . $key . '%',
                    'Doctors.phone_number LIKE' => '%' . $key . '%',
                ],
            ]);
        }

        if (!empty($gender)) {
            $query->where(['Doctors.gender' => $gender]);
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where(['Doctors.is_active' => $isActive]);
        }

        $this->paginate = [
            'order' => ['Doctors.id' => 'DESC'],
        ];

        $doctors = $this->paginate($query);

        $this->set(compact('doctors', 'key', 'gender', 'isActive'));
    }

    public function view($id = null)
    {
        $doctor = $this->Doctors->get($id, [
            'contain' => ['DoctorSchedules'],
        ]);

        $this->set(compact('doctor'));
    }

    public function add()
    {
        $doctor = $this->Doctors->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            unset($data['polyclinic_id']);

            // Kode SELALU otomatis, input manual dari form diabaikan
            $data['code'] = $this->generateDoctorCode();

            $data['is_create'] = $data['is_create'] ?? 1;
            $data['is_update'] = $data['is_update'] ?? 0;
            $data['is_delete'] = $data['is_delete'] ?? 0;
            $data['is_active'] = $data['is_active'] ?? 'Y';

            $doctor = $this->Doctors->patchEntity($doctor, $data);

            if ($this->Doctors->save($doctor)) {
                $this->Flash->success(__('The doctor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The doctor could not be saved. Please, try again.'));
        }

        // polyclinics, religions, specialists diambil di view lewat $this->Krs->...()
        $this->set(compact('doctor'));
    }

    public function edit($id = null)
    {
        $doctor = $this->Doctors->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            unset($data['polyclinic_id']);

            // Kode tidak diubah saat edit, tetap pakai kode lama
            unset($data['code']);

            $data['is_update'] = 1;

            $doctor = $this->Doctors->patchEntity($doctor, $data);

            if ($this->Doctors->save($doctor)) {
                $this->Flash->success(__('The doctor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The doctor could not be saved. Please, try again.'));
        }

        $this->set(compact('doctor'));
    }

    public function searchByPolyclinic()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $polyName = trim((string)$this->request->getQuery('poly_name'));
        $q = trim((string)$this->request->getQuery('q'));

        $query = $this->Doctors->find()
            ->select([
                'id',
                'doctor_name',
                'specialist',
                'polyclinic_name',
            ])
            ->where([
                'Doctors.is_active' => 'Y',
            ])
            ->order([
                'Doctors.doctor_name' => 'ASC',
            ])
            ->limit(20);

        if ($polyName !== '') {
            $query->where(function ($exp) use ($polyName) {
                return $exp->eq('LOWER(Doctors.polyclinic_name)', mb_strtolower($polyName));
            });
        }

        if ($q !== '') {
            $query->where([
                'Doctors.doctor_name LIKE' => '%' . $q . '%',
            ]);
        }

        $data = [];

        foreach ($query->all() as $doctor) {
            $data[] = [
                'id' => $doctor->id,
                'doctor_name' => $doctor->doctor_name,
                'specialist' => $doctor->specialist,
                'polyclinic_name' => $doctor->polyclinic_name,
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    /**
     * Generate kode dokter otomatis berdasarkan id terakhir.
     * Format: DR-0001, DR-0002, dst.
     */
    private function generateDoctorCode(): string
    {
        $lastDoctor = $this->Doctors->find()
            ->select(['id'])
            ->order(['Doctors.id' => 'DESC'])
            ->first();

        $nextId = $lastDoctor ? ((int)$lastDoctor->id + 1) : 1;

        return 'DR-' . str_pad((string)$nextId, 4, '0', STR_PAD_LEFT);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $doctor = $this->Doctors->get($id);

        if ($this->Doctors->delete($doctor)) {
            $this->Flash->success(__('The doctor has been deleted.'));
        } else {
            $this->Flash->error(__('The doctor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}