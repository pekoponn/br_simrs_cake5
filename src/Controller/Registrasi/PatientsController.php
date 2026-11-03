<?php
declare(strict_types=1);

namespace App\Controller\Registrasi;

use App\Controller\AppController;

/**
 * Patients Controller
 *
 * @property \App\Model\Table\PatientsTable $Patients
 */
class PatientsController extends AppController
{
    /**
     * INDEX — dengan search & filter
     */
    public function index()
    {
        $query = $this->Patients->find()
            ->where([
                'OR' => [
                    ['Patients.is_delete !=' => 1],
                    ['Patients.is_delete IS' => null],
                ],
            ])
            ->orderBy(['Patients.id' => 'ASC']);

        // Filter pencarian
        $key = $this->request->getQuery('key');
        if (!empty($key)) {
            $query->where([
                'OR' => [
                    'Patients.code LIKE'             => '%' . $key . '%',
                    'Patients.full_name LIKE'        => '%' . $key . '%',
                    'Patients.identity_number LIKE'  => '%' . $key . '%',
                    'Patients.phone_number LIKE'     => '%' . $key . '%',
                ],
            ]);
        }

        // Filter gender
        $gender = $this->request->getQuery('gender');
        if (!empty($gender)) {
            $query->where(['Patients.gender' => $gender]);
        }

        // Filter is_active
        $isActive = $this->request->getQuery('is_active');
        if ($isActive !== null && $isActive !== '') {
            $query->where(['Patients.is_active' => $isActive]);
        }

        $numberingQuery = (clone $query)
            ->select(['Patients.id'])
            ->orderBy(['Patients.id' => 'ASC'])
            ->enableHydration(false);

        $idOrderMap = [];
        $rank = 1;
        foreach ($numberingQuery->all() as $row) {
            $idOrderMap[$row['id']] = $rank++;
        }

        $this->paginate = ['limit' => 15];
        $patients = $this->paginate($query);

        $this->set(compact('patients', 'key', 'gender', 'isActive', 'idOrderMap'));
    }

    /**
     * VIEW
     */
public function view($id = null)
{
    $patient = $this->Patients->get($id, contain: ['Registrations.Doctors']);

    $this->set(compact('patient'));
}
    /**
     * ADD
     */
    public function add()
    {
        $patient = $this->Patients->newEmptyEntity();

        $previewCode = '';
        $patient->code = $previewCode;

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $data['code'] = $this->Patients->generatePatientCode($data['birth_date'] ?? '');

            // Rekam medis tidak disimpan di master pasien.
            // Nanti rekam medis/riwayat medis dibuat dari module EMR/PatientHistorys sendiri.
            unset($data['medical_record_no']);

            if (empty($data['is_active'])) {
                $data['is_active'] = 'Y';
            }

            $patient = $this->Patients->patchEntity($patient, $data);

            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('Data pasien berhasil disimpan.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Data pasien gagal disimpan. Periksa kembali isian form.'));

            if (empty($patient->code)) {
                $patient->code = $previewCode;
            }
        }

        $this->set(compact('patient', 'previewCode'));
    }

    /**
     * EDIT
     */
    public function edit($id = null)
    {
        $patient = $this->Patients->get($id, contain: []);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (!empty($patient->code)) {
                $data['code'] = $patient->code;
            } else {
                $data['code'] = $this->Patients->generatePatientCode($data['birth_date'] ?? $patient->birth_date ?? '');
            }

            // Rekam medis tidak diubah dari master pasien.
            unset($data['medical_record_no']);

            $patient = $this->Patients->patchEntity($patient, $data);

            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('Data pasien berhasil diupdate.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Data pasien gagal diupdate.'));
        }

        $this->set(compact('patient'));
    }

    /**
     * DELETE — soft delete
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $patient = $this->Patients->get($id);
        $patient->is_delete = 1;

        if ($this->Patients->save($patient)) {
            $this->Flash->success(__('Data pasien berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Data pasien gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}