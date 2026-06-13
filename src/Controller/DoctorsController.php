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
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $doctors = $this->paginate($this->Doctors);

        $this->set(compact('doctors'));
    }

    /**
     * View method
     *
     * @param string|null $id Doctor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $doctor = $this->Doctors->get($id, [
            'contain' => ['DoctorSchedules'],
        ]);

        $this->set(compact('doctor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $doctor = $this->Doctors->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (isset($data['code']) && is_string($data['code'])) {
                $data['code'] = trim($data['code']);
            }

            if (empty($data['code'])) {
                $data['code'] = $this->Doctors->generateCode();
            }

            $doctor = $this->Doctors->patchEntity($doctor, $data);
            if ($this->Doctors->save($doctor)) {
                $this->Flash->success(__('The doctor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The doctor could not be saved. Please, try again.'));
        }

        $polyclinics = $this->getPolyclinicOptions();
        $religions = $this->getReligionOptions();

        $this->set(compact('doctor', 'polyclinics', 'religions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Doctor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $doctor = $this->Doctors->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $doctor = $this->Doctors->patchEntity($doctor, $data);
            if ($this->Doctors->save($doctor)) {
                $this->Flash->success(__('The doctor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The doctor could not be saved. Please, try again.'));
        }
        $polyclinics = $this->getPolyclinicOptions();
        $religions = $this->getReligionOptions();
        $this->set(compact('doctor', 'polyclinics', 'religions'));
    }

    private function getPolyclinicOptions(): array
    {
        return [
            'Poli Umum' => 'Poli Umum',
            'Poli Gigi' => 'Poli Gigi',
            'Poli Anak' => 'Poli Anak',
            'Poli Kandungan' => 'Poli Kandungan',
            'Poli Penyakit Dalam' => 'Poli Penyakit Dalam',
            'Poli Mata' => 'Poli Mata',
            'Poli THT' => 'Poli THT',
            'Poli Bedah' => 'Poli Bedah',
            'Poli Saraf' => 'Poli Saraf',
            'Poli Kulit' => 'Poli Kulit',
            'Poli Jantung' => 'Poli Jantung',
        ];
    }

    private function getReligionOptions(): array
    {
        return [
            'Islam' => 'Islam',
            'Kristen' => 'Kristen',
            'Katolik' => 'Katolik',
            'Hindu' => 'Hindu',
            'Buddha' => 'Buddha',
            'Konghucu' => 'Konghucu',
            'Lainnya' => 'Lainnya',
        ];
    }

    public function searchByPolyclinic()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $polyName = trim((string)$this->request->getQuery('poly_name', ''));
        $q = trim((string)$this->request->getQuery('q', ''));

        if ($polyName === '') {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([], JSON_UNESCAPED_UNICODE));
        }

        $conditions = [
            'Doctors.polyclinic_name' => $polyName,
        ];

        if ($q !== '') {
            $conditions['OR'] = [
                'Doctors.doctor_name LIKE' => '%' . $q . '%',
                'Doctors.specialist LIKE' => '%' . $q . '%',
            ];
        }

        $rows = $this->Doctors->find()
            ->select(['id', 'doctor_name', 'specialist', 'polyclinic_name'])
            ->where($conditions)
            ->order(['Doctors.doctor_name' => 'ASC'])
            ->limit(50)
            ->enableHydration(false)
            ->toArray();

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($rows, JSON_UNESCAPED_UNICODE));
    }

    /**
     * Delete method
     *
     * @param string|null $id Doctor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
