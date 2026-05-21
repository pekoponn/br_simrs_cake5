<?php

declare(strict_types=1);

namespace App\Controller;

class RegistrationsController extends AppController
{
    public function index()
    {
        $this->paginate = [
            'contain' => ['Patients', 'Doctors', 'Rooms', 'Beds'],
        ];

        $registrations = $this->paginate($this->Registrations);

        $this->set(compact('registrations'));
    }

    public function view($id = null)
    {
        $registration = $this->Registrations->get($id, [
            'contain' => ['Patients', 'Doctors', 'Rooms', 'Beds'],
        ]);

        $this->set(compact('registration'));
    }

    public function add()
    {
        $this->loadModel('DaerahProvinsis');
        $registration = $this->Registrations->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $this->loadModel('Patients');

            $patientFields = [
                'full_name',
                'identity_type',
                'identity_number',
                'gender',
                'blood_type',
                'birth_date',
                'address',
                'father_name',
                'mother_name',
                'phone_number',
                'nationality',
                'citizenship',
                'id_prov',
                'id_kab',
                'id_kec',
                'id_kel',
                'occupation',
                'religion',
                'education',
                'ethnic_group',
                'marital_status'
            ];

            if (!empty($data['patient_id'])) {
                // PASIEN LAMA: update hanya field yang masih kosong
                $patient = $this->Patients->get($data['patient_id']);

                foreach ($patientFields as $field) {
                    if (empty($patient->{$field}) && !empty($data['patient'][$field])) {
                        $patient->{$field} = $data['patient'][$field];
                    }
                }

                $this->Patients->save($patient);
            } else {
                // PASIEN BARU: buat patient baru + generate code otomatis
                if (!empty($data['patient']['full_name'])) {
                    $patientData = [];

                    foreach ($patientFields as $field) {
                        $patientData[$field] = $data['patient'][$field] ?? null;
                    }

                    $title = $data['patient_title'] ?? '';

                    $fullName = trim($data['patient']['full_name']);

                    if (!empty($title)) {
                        $patientData['full_name'] = $title . ' ' . $fullName;
                    } else {
                        $patientData['full_name'] = $fullName;
                    }

                    if (!empty($data['patient']['identity_number'])) {
                        $existingPatient = $this->Patients->find()
                            ->where([
                                'identity_number' => $data['patient']['identity_number']
                            ])
                            ->first();

                        if ($existingPatient) {
                            $this->Flash->error(__('No identitas sudah terdaftar. Silakan cari pasien melalui tombol Cari.'));
                            return;
                        }
                    }

                    $patientData['code'] = $this->Patients->generateCode();

                    $patient = $this->Patients->newEmptyEntity();
                    $patient = $this->Patients->patchEntity($patient, $patientData);

                    if ($this->Patients->save($patient)) {
                        $data['patient_id'] = $patient->id;
                    } else {
                        $this->Flash->error(__('Data pasien baru gagal disimpan.'));
                        return;
                    }
                } else {
                    $this->Flash->error(__('Pasien belum dipilih atau nama pasien baru belum diisi.'));
                    return;
                }
            }

            // Simpan data penanggung jawab//
            if (!empty($data['person_responsible']['name'])) {
                $this->loadModel('PersonResponsibles');

                $personResponsibles = $this->PersonResponsibles->newEmptyEntity();
                $personResponsibles = $this->PersonResponsibles->patchEntity(
                    $personResponsibles,
                    $data['person_responsible']
                );

                if ($this->PersonResponsibles->save($personResponsibles)) {
                    $data['person_responsible_id'] = $personResponsibles->id;
                } else {
                    $this->Flash->error(__('Data penanggung jawab gagal disimpan.'));
                    return $this->redirect(['action' => 'add']);
                }
            }

            $registration = $this->Registrations->patchEntity($registration, $data);

            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Data registrasi berhasil disimpan.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Data registrasi gagal disimpan.'));
        }

        $provinces = $this->DaerahProvinsis->find('list', [
            'keyField' => 'id_prov',
            'valueField' => 'nama',
            'order' => ['nama' => 'ASC']
        ])->all();

        $doctors = $this->Registrations->Doctors->find('list', [
            'limit' => 200
        ])->all();

        $rooms = $this->Registrations->Rooms->find('list', [
            'limit' => 200
        ])->all();

        $beds = $this->Registrations->Beds->find('list', [
            'limit' => 200,
        ])->all();

        $this->set(compact(
            'registration',
            'doctors',
            'rooms',
            'beds',
            'provinces'
        ));
    }

    public function edit($id = null)
    {
        $registration = $this->Registrations->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Data registrasi berhasil diubah.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Data registrasi gagal diubah.'));
        }

        $patients = $this->Registrations->Patients->find('list', [
            'limit' => 200
        ])->all();

        $doctors = $this->Registrations->Doctors->find('list', [
            'limit' => 200
        ])->all();

        $rooms = $this->Registrations->Rooms->find('list', [
            'limit' => 200
        ])->all();

        $beds = $this->Registrations->Beds->find('list', [
            'limit' => 200
        ])->all();

        $this->set(compact('registration', 'patients', 'doctors', 'rooms', 'beds'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $registration = $this->Registrations->get($id);

        if ($this->Registrations->delete($registration)) {
            $this->Flash->success(__('Data registrasi berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Data registrasi gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function searchPatients()
    {
        $this->request->allowMethod(['get']);

        $keyword = $this->request->getQuery('q');

        $this->loadModel('Patients');

        $patients = [];

        if (!empty($keyword)) {
            $patients = $this->Patients->find()
                ->select([
                    'id',
                    'code',
                    'full_name',
                    'identity_type',
                    'identity_number',
                    'gender',
                    'blood_type',
                    'birth_date',
                    'address',
                    'father_name',
                    'mother_name',
                    'phone_number',
                    'nationality',
                    'citizenship',
                    'id_prov',
                    'id_kab',
                    'id_kec',
                    'id_kel',
                    'occupation',
                    'religion',
                    'education',
                    'ethnic_group',
                    'marital_status'
                ])
                ->where([
                    'OR' => [
                        'Patients.code LIKE' => '%' . $keyword . '%',
                        'Patients.identity_number LIKE' => '%' . $keyword . '%',
                        'Patients.full_name LIKE' => '%' . $keyword . '%',
                    ]
                ])
                ->limit(10)
                ->enableHydration(false)
                ->toArray();
        }

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($patients));
    }

    public function getKabupatens()
    {
        $this->request->allowMethod(['get']);

        $idProv = $this->request->getQuery('id_prov');

        $this->loadModel('DaerahKabupatens');

        $kabupatens = $this->DaerahKabupatens->find()
            ->select(['id_kab', 'nama'])
            ->where(['id_prov' => $idProv])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($kabupatens));
    }

    public function getKecamatans()
    {
        $this->request->allowMethod(['get']);

        $idKab = $this->request->getQuery('id_kab');

        $this->loadModel('DaerahKecamatans');

        $kecamatans = $this->DaerahKecamatans->find()
            ->select(['id_kec', 'nama'])
            ->where(['id_kab' => $idKab])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($kecamatans));
    }

    public function getKelurahans()
    {
        $this->request->allowMethod(['get']);

        $idKec = $this->request->getQuery('id_kec');

        $this->loadModel('DaerahKelurahans');

        $kelurahans = $this->DaerahKelurahans->find()
            ->select(['id_kel', 'nama'])
            ->where(['id_kec' => $idKec])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($kelurahans));
    }

    public function getBedClass()
    {
        $this->request->allowMethod(['get']);

        $bedId = $this->request->getQuery('bed_id');

        $bed = $this->Registrations->Beds->find()
            ->select([
                'id',
                'class_name'
            ])
            ->where([
                'id' => $bedId
            ])
            ->first();

        $this->autoRender = false;

        // FIXED: tambah ->toArray() agar entity bisa di-encode JSON dengan benar
        return $this->response
            ->withType('application/json')
            ->withStringBody(
                json_encode($bed ? $bed->toArray() : ['class_name' => ''])
            );
    }

    public function getDoctorSchedules()
    {
        $this->request->allowMethod(['get']);

        $doctorId = $this->request->getQuery('doctor_id');

        $this->loadModel('DoctorSchedules');

        $schedules = $this->DoctorSchedules->find()
            ->select(['id', 'code', 'day', 'start_time', 'end_time', 'quota'])
            ->where(['DoctorSchedules.doctor_id' => $doctorId])
            ->order(['DoctorSchedules.day' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->autoRender = false;

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($schedules));
    }
}
