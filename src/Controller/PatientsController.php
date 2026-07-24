<?php
declare(strict_types=1);

namespace App\Controller;

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
            ->order(['Patients.id' => 'DESC']);

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

        $this->paginate = ['limit' => 15];
        $patients = $this->paginate($query);

        $this->set(compact('patients', 'key', 'gender', 'isActive'));
    }

    /**
     * VIEW
     */
    public function view($id = null)
    {
        $patient = $this->Patients->get($id, [
            'contain' => ['Registrations.Doctors'],
        ]);

        $this->set(compact('patient'));
    }

    /**
     * ADD
     */
    public function add()
    {
        $patient = $this->Patients->newEmptyEntity();

        // Preview kode otomatis untuk tampilan form.
        // Kode pasien ini hanya untuk master pasien, bukan nomor rekam medis.
        $previewCode = $this->generatePatientCode();
        $patient->code = $previewCode;

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Kode pasien dibuat otomatis agar tidak tersimpan 0/kosong.
            $data['code'] = $this->generatePatientCode();

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
        $patient = $this->Patients->get($id, ['contain' => []]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Jangan izinkan kode pasien berubah dari form edit.
            // Kalau data lama kosong, baru bantu isi otomatis.
            if (!empty($patient->code)) {
                $data['code'] = $patient->code;
            } else {
                $data['code'] = $this->generatePatientCode();
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

    /**
     * Kode pasien internal master pasien.
     * Contoh: P000001, P000002, dst.
     */
    private function generatePatientCode(): string
    {
        $last = $this->Patients->find()
            ->select(['code'])
            ->where([
                'Patients.code IS NOT' => null,
                'Patients.code !=' => '',
                'Patients.code LIKE' => 'P%',
            ])
            ->order(['Patients.id' => 'DESC'])
            ->first();

        $next = 1;
        if ($last && !empty($last->code) && preg_match('/^P(\d+)$/i', (string)$last->code, $match)) {
            $next = ((int)$match[1]) + 1;
        } else {
            $lastPatient = $this->Patients->find()->order(['Patients.id' => 'DESC'])->first();
            $next = $lastPatient ? ((int)$lastPatient->id + 1) : 1;
        }

        do {
            $code = 'P' . str_pad((string)$next, 6, '0', STR_PAD_LEFT);
            $exists = $this->Patients->exists(['Patients.code' => $code]);
            $next++;
        } while ($exists);

        return $code;
    }
}