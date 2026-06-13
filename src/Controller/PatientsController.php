<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Patients Controller
 *
 * @property \App\Model\Table\PatientsTable $Patients
 * @method \App\Model\Entity\Patient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PatientsController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        $schema = $this->Patients->getSchema();
        $query = $this->Patients->find()
            ->where([
                'OR' => [
                    ['Patients.is_delete !=' => 1],
                    ['Patients.is_delete IS' => null],
                ],
            ])
            ->order(['Patients.id' => 'DESC']);

        $filterCode = trim((string)$this->request->getQuery('filterCode', ''));
        $filterName = trim((string)$this->request->getQuery('filterName', ''));
        $filterIdentity = trim((string)$this->request->getQuery('filterIdentity', ''));
        $filterPhone = trim((string)$this->request->getQuery('filterPhone', ''));
        $filterStatus = $this->request->getQuery('filterStatus');

        $key = trim((string)$this->request->getQuery('key', ''));
        if ($key !== '') {
            $searchConditions = [
                'Patients.code LIKE' => '%' . $key . '%',
                'Patients.full_name LIKE' => '%' . $key . '%',
                'Patients.identity_number LIKE' => '%' . $key . '%',
                'Patients.phone_number LIKE' => '%' . $key . '%',
            ];

            if ($schema->hasColumn('medical_record_no')) {
                $searchConditions[] = ['Patients.medical_record_no LIKE' => '%' . $key . '%'];
            }

            $query->where([
                'OR' => $searchConditions,
            ]);
        }

        if ($filterCode !== '') {
            $codeConditions = [
                'Patients.code LIKE' => '%' . $filterCode . '%',
            ];

            if ($schema->hasColumn('medical_record_no')) {
                $codeConditions[] = ['Patients.medical_record_no LIKE' => '%' . $filterCode . '%'];
            }

            $query->where(['OR' => $codeConditions]);
        }

        if ($filterName !== '') {
            $query->where(['Patients.full_name LIKE' => '%' . $filterName . '%']);
        }

        if ($filterIdentity !== '') {
            $query->where(['Patients.identity_number LIKE' => '%' . $filterIdentity . '%']);
        }

        if ($filterPhone !== '') {
            $query->where(['Patients.phone_number LIKE' => '%' . $filterPhone . '%']);
        }

        $gender = $this->request->getQuery('gender');
        if (!empty($gender)) {
            $query->where(['Patients.gender' => $gender]);
        }

        $isActive = $filterStatus !== null && $filterStatus !== ''
            ? $filterStatus
            : $this->request->getQuery('is_active');
        if ($isActive !== null && $isActive !== '') {
            $query->where(['Patients.is_active' => $isActive]);
        }

        $this->paginate = [
            'limit' => 15,
        ];

        $patients = $this->paginate($query);

        $this->set(compact(
            'patients',
            'key',
            'filterCode',
            'filterName',
            'filterIdentity',
            'filterPhone',
            'filterStatus',
            'gender',
            'isActive'
        ));
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $patient = $this->Patients->get($id, [
            'contain' => [
                'Registrations' => [
                    'PersonResponsibles',
                ],
            ],
        ]);

        $this->set(compact('patient'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $patient = $this->Patients->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data = $this->normalizeRegionNames($data);
            $schema = $this->Patients->getSchema();

            if (empty($data['code'])) {
                $data['code'] = $this->Patients->generateCode();
            }

            if ($schema->hasColumn('medical_record_no') && empty($data['medical_record_no'])) {
                $data['medical_record_no'] = $this->Patients->generateMedicalRecordNo();
            }

            if (empty($data['is_active'])) {
                $data['is_active'] = 'Y';
            }

            $patient = $this->Patients->patchEntity($patient, $data);

            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('Data pasien berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Data pasien gagal disimpan. Periksa kembali isian form.'));
        }

        $this->loadModel('DaerahProvinsis');

        $provinces = $this->DaerahProvinsis->find()
            ->select(['id_prov', 'nama'])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->set(compact('patient', 'provinces'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $patient = $this->Patients->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data = $this->normalizeRegionNames($data);
            $schema = $this->Patients->getSchema();

            if ($schema->hasColumn('medical_record_no') && empty($data['medical_record_no'])) {
                $data['medical_record_no'] = $patient->medical_record_no ?: $this->Patients->generateMedicalRecordNo();
            }

            if (!$schema->hasColumn('medical_record_no')) {
                unset($data['medical_record_no']);
            }

            $patient = $this->Patients->patchEntity($patient, $data);

            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('Data pasien berhasil diupdate.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Data pasien gagal diupdate. Periksa kembali isian form.'));
        }

        $this->loadModel('DaerahProvinsis');

        $provinces = $this->DaerahProvinsis->find()
            ->select(['id_prov', 'nama'])
            ->order(['nama' => 'ASC'])
            ->enableHydration(false)
            ->toArray();

        $this->set(compact('patient', 'provinces'));
    }

    /**
     * Delete method — soft delete
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

    private function normalizeRegionNames(array $data): array
    {
        $regionFields = [
            'id_prov' => ['model' => 'DaerahProvinsis', 'key' => 'id_prov'],
            'id_kab' => ['model' => 'DaerahKabupatens', 'key' => 'id_kab'],
            'id_kec' => ['model' => 'DaerahKecamatans', 'key' => 'id_kec'],
            'id_kel' => ['model' => 'DaerahKelurahans', 'key' => 'id_kel'],
        ];

        foreach ($regionFields as $field => $config) {
            if (empty($data[$field]) || !is_numeric($data[$field])) {
                continue;
            }

            $this->loadModel($config['model']);
            $region = $this->{$config['model']}->find()
                ->select(['nama'])
                ->where([$config['key'] => (string)$data[$field]])
                ->enableHydration(false)
                ->first();

            if (!empty($region['nama'])) {
                $data[$field] = $region['nama'];
            }
        }

        return $data;
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
}
