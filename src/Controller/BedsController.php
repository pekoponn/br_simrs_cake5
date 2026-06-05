<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

/**
 * Beds Controller
 *
 * @property \App\Model\Table\BedsTable $Beds
 * @method \App\Model\Entity\Bed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BedsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        if ($this->components()->has('Security')) {
            $this->Security->setConfig('unlockedActions', ['updateStatus', 'searchPatients']);
        }
    }

    private function tableExists(string $tableName): bool
    {
        try {
            return in_array($tableName, ConnectionManager::get('default')->getSchemaCollection()->listTables(), true);
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function bedHasColumn(string $column): bool
    {
        return $this->Beds->getSchema()->hasColumn($column);
    }

    private function buildBedContain(bool $withHistories = false): array
    {
        $contain = ['Rooms'];

        if ($this->bedHasColumn('patient_id')) {
            $contain[] = 'Patients';
        }

        if ($withHistories && $this->tableExists('bed_histories')) {
            $contain['BedHistories'] = [
                'sort' => ['BedHistories.created' => 'DESC'],
            ];
        }

        return $contain;
    }

    private function statusLabels(): array
    {
        return method_exists($this->Beds, 'getStatusLabel')
            ? $this->Beds->getStatusLabel()
            : $this->Beds->getStatusList();
    }

    private function buildAutoNotes(int $statusAfter, int $statusBefore, ?string $patientName, string $now): ?string
    {
        $tgl = date('d-m-Y H:i', strtotime($now));

        if ($statusAfter === 1) {
            $nama = !empty($patientName) ? $patientName : 'pasien';

            return "Pasien {$nama} masuk pada {$tgl} WIB";
        }

        if ($statusAfter === 0) {
            if ($statusBefore === 1 && !empty($patientName)) {
                return "Pasien {$patientName} keluar pada {$tgl} WIB";
            }

            return "Bed tersedia sejak {$tgl} WIB";
        }

        return null;
    }

    public function index()
    {
        $query = $this->Beds->find()
            ->contain($this->buildBedContain(true))
            ->where([
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null],
                ],
            ])
            ->order(['Beds.id' => 'DESC']);

        $key = $this->request->getQuery('key');
        if (!empty($key)) {
            $search = [
                'Beds.code LIKE' => '%' . $key . '%',
                'Beds.bed_no LIKE' => '%' . $key . '%',
                'Beds.name LIKE' => '%' . $key . '%',
                'Beds.class_name LIKE' => '%' . $key . '%',
                'Rooms.room_name LIKE' => '%' . $key . '%',
            ];

            if ($this->bedHasColumn('patient_id')) {
                $search['Patients.full_name LIKE'] = '%' . $key . '%';
            }

            $query->where(['OR' => $search]);
        }

        $roomId = $this->request->getQuery('room_id');
        if (!empty($roomId)) {
            $query->where(['Beds.room_id' => $roomId]);
        }

        $className = $this->request->getQuery('class_name');
        if (!empty($className)) {
            $query->where(['Beds.class_name' => $className]);
        }

        $status = $this->request->getQuery('status');
        if ($status !== null && $status !== '') {
            $query->where(['Beds.status' => $status]);
        }

        $this->paginate = ['limit' => 10];
        $beds = $this->paginate($query);

        $rooms = $this->Beds->Rooms->find('list', [
            'keyField' => 'id',
            'valueField' => 'room_name',
        ])->order(['Rooms.room_name' => 'ASC'])->toArray();

        $classList = $this->Beds->getClassList();
        $statusList = $this->Beds->getStatusList();
        $statusLabel = $this->statusLabels();

        $this->set(compact(
            'beds',
            'rooms',
            'classList',
            'statusList',
            'statusLabel',
            'key',
            'roomId',
            'className',
            'status'
        ));
    }

    public function view($id = null)
    {
        $bed = $this->Beds->get($id, [
            'contain' => $this->buildBedContain(true),
        ]);

        $statusLabel = $this->statusLabels();

        $this->set(compact('bed', 'statusLabel'));
    }

    public function add()
    {
        $bed = $this->Beds->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $roomId = !empty($data['room_id']) ? (int)$data['room_id'] : null;

            if (!empty($data['auto_code']) || empty($data['code'])) {
                $lastBed = $this->Beds->find()->order(['Beds.id' => 'DESC'])->first();
                $lastId = $lastBed ? ($lastBed->id + 1) : 1;
                $data['code'] = 'BED-' . str_pad((string)$lastId, 4, '0', STR_PAD_LEFT);
            }
            unset($data['auto_code']);

            if ($roomId) {
                $room = $this->Beds->Rooms->get($roomId);
                $data['class_name'] = $room->room_class;

                $nextBedNo = $this->generateBedNoForRoom($roomId);
                if ($nextBedNo === null) {
                    $this->Flash->error(__('Kapasitas ruangan sudah penuh. Tidak bisa menambah bed lagi.'));

                    return $this->redirect(['action' => 'add']);
                }

                $data['bed_no'] = $nextBedNo;
            }

            if (empty($data['is_active'])) {
                $data['is_active'] = 'Y';
            }

            if (!isset($data['status']) || $data['status'] === '') {
                $data['status'] = 0;
            }

            $data['status'] = (int)$data['status'];

            $bed = $this->Beds->patchEntity($bed, $data);

            if ($this->Beds->save($bed)) {
                $this->Flash->success(__('Bed berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Bed gagal disimpan.'));
        }

        $rooms = $this->Beds->Rooms->find('list', [
            'keyField' => 'id',
            'valueField' => 'room_name',
        ])->order(['Rooms.room_name' => 'ASC'])->toArray();

        $roomsMeta = $this->buildRoomsMeta();

        $classList = $this->Beds->getClassList();
        $statusList = $this->Beds->getStatusList();
        $activeList = $this->Beds->getActiveList();

        $this->set(compact('bed', 'rooms', 'roomsMeta', 'classList', 'statusList', 'activeList'));
    }

    public function edit($id = null)
    {
        $bed = $this->Beds->get($id, [
            'contain' => $this->buildBedContain(),
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (!isset($data['status']) || $data['status'] === '') {
                $data['status'] = $bed->status;
            }

            $data['status'] = (int)$data['status'];

            $statusBefore = (int)$bed->status;
            $statusAfter = $data['status'];
            $patientNameBefore = $bed->patient_name ?? null;
            $patientIdBefore = $bed->patient_id ?? null;
            $checkInBefore = $bed->check_in_date ?? null;
            $now = date('Y-m-d H:i:s');

            unset($data['check_in_date'], $data['check_out_date']);

            if ($this->bedHasColumn('patient_id') && $statusAfter === 1) {
                if (empty($bed->check_in_date)) {
                    $data['check_in_date'] = $now;
                }
                $data['check_out_date'] = null;

                $patientId = !empty($data['patient_id']) ? (int)$data['patient_id'] : null;
                $data['patient_id'] = $patientId;

                if ($patientId) {
                    $this->loadModel('Patients');
                    try {
                        $patient = $this->Patients->get($patientId, ['fields' => ['id', 'full_name', 'code']]);
                        $data['patient_name'] = $patient->full_name;
                    } catch (\Throwable $e) {
                    }
                }

                $data['notes'] = $this->buildAutoNotes($statusAfter, $statusBefore, $data['patient_name'] ?? null, $now);
            } elseif ($this->bedHasColumn('patient_id')) {
                $data['patient_id'] = null;
                $data['patient_name'] = null;

                if ($statusBefore === 1) {
                    $data['check_out_date'] = $now;
                }

                $autoNotes = $this->buildAutoNotes($statusAfter, $statusBefore, $patientNameBefore, $now);
                if ($autoNotes !== null) {
                    $data['notes'] = $autoNotes;
                }
            }

            $bed = $this->Beds->patchEntity($bed, $data);

            if ($this->Beds->save($bed)) {
                $this->saveBedHistory($bed, $data, $statusBefore, $statusAfter, $patientIdBefore, $patientNameBefore, $checkInBefore);

                $this->Flash->success(__('Bed berhasil diupdate.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Bed gagal diupdate.'));
        }

        $rooms = $this->Beds->Rooms->find('list', [
            'keyField' => 'id',
            'valueField' => 'room_name',
        ])->order(['Rooms.room_name' => 'ASC'])->toArray();

        $classList = $this->Beds->getClassList();
        $statusList = $this->Beds->getStatusList();
        $activeList = $this->Beds->getActiveList();

        $this->set(compact('bed', 'rooms', 'classList', 'statusList', 'activeList'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $bed = $this->Beds->get($id);
        $bed->is_delete = 1;

        if ($this->Beds->save($bed)) {
            $this->Flash->success(__('Bed berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Bed gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function monitoring()
    {
        $beds = $this->Beds->find()
            ->contain($this->buildBedContain())
            ->where([
                'Beds.is_active' => 'Y',
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null],
                ],
            ])
            ->order([
                'Rooms.room_name' => 'ASC',
                'Beds.bed_no' => 'ASC',
            ])
            ->all();

        $statusLabel = $this->statusLabels();
        $grouped = [];

        foreach ($beds as $bed) {
            $roomName = $bed->room->room_name ?? 'Tanpa Room';
            $grouped[$roomName][] = $bed;
        }

        $this->set(compact('beds', 'grouped', 'statusLabel'));
    }

    public function searchPatients()
    {
        $this->request->allowMethod(['get', 'ajax']);
        $this->viewBuilder()->setClassName('Json');

        $key = trim((string)$this->request->getQuery('q', ''));
        $patients = [];

        if ($key !== '') {
            $this->loadModel('Patients');
            $results = $this->Patients->find()
                ->select(['id', 'code', 'full_name'])
                ->where([
                    'OR' => [
                        'Patients.full_name LIKE' => '%' . $key . '%',
                        'Patients.code LIKE' => '%' . $key . '%',
                    ],
                ])
                ->limit(15)
                ->order(['Patients.full_name' => 'ASC'])
                ->toArray();

            foreach ($results as $patient) {
                $patients[] = [
                    'id' => $patient->id,
                    'code' => $patient->code,
                    'full_name' => $patient->full_name,
                    'label' => $patient->full_name . ' (' . $patient->code . ')',
                ];
            }
        }

        $this->set(['patients' => $patients]);
        $this->viewBuilder()->setOption('serialize', ['patients']);
    }

    public function updateStatus($id = null)
    {
        $this->request->allowMethod(['post', 'ajax']);
        $this->viewBuilder()->setClassName('Json');
        $this->response = $this->response->withHeader('X-Content-Type-Options', 'nosniff');

        try {
            $bed = $this->Beds->get($id);
        } catch (\Throwable $e) {
            $this->set(['success' => false, 'message' => 'Bed tidak ditemukan.']);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);

            return;
        }

        $data = $this->request->getData();

        if (!isset($data['status']) || $data['status'] === '') {
            $this->set(['success' => false, 'message' => 'Status wajib dipilih.']);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);

            return;
        }

        $statusBefore = (int)$bed->status;
        $statusAfter = (int)$data['status'];
        $patientNameBefore = $bed->patient_name ?? null;
        $patientIdBefore = $bed->patient_id ?? null;
        $checkInBefore = $bed->check_in_date ?? null;
        $now = date('Y-m-d H:i:s');

        $saveData = [
            'status' => $statusAfter,
        ];

        if ($this->bedHasColumn('patient_id') && $statusAfter === 1) {
            $patientId = !empty($data['patient_id']) ? (int)$data['patient_id'] : null;
            $saveData['patient_id'] = $patientId;
            $saveData['patient_name'] = $data['patient_name'] ?? null;
            $saveData['check_in_date'] = $now;
            $saveData['check_out_date'] = null;

            if ($patientId) {
                $this->loadModel('Patients');
                try {
                    $patient = $this->Patients->get($patientId, ['fields' => ['id', 'full_name', 'code']]);
                    $saveData['patient_name'] = $patient->full_name;
                } catch (\Throwable $e) {
                }
            }

            $saveData['notes'] = $this->buildAutoNotes($statusAfter, $statusBefore, $saveData['patient_name'] ?? null, $now);
        } elseif ($this->bedHasColumn('patient_id')) {
            $saveData['patient_id'] = null;
            $saveData['patient_name'] = null;

            if ($statusBefore === 1) {
                $saveData['check_out_date'] = $now;
            }

            $autoNotes = $this->buildAutoNotes($statusAfter, $statusBefore, $patientNameBefore, $now);
            $saveData['notes'] = $autoNotes !== null ? $autoNotes : ($data['notes'] ?? null);
        }

        $bed = $this->Beds->patchEntity($bed, $saveData);

        if (!$this->Beds->save($bed)) {
            $this->set([
                'success' => false,
                'message' => 'Status bed gagal diupdate.',
                'errors' => $bed->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message', 'errors']);

            return;
        }

        $bedSaved = $this->Beds->get($bed->id);
        $this->saveBedHistory($bedSaved, $data, $statusBefore, $statusAfter, $patientIdBefore, $patientNameBefore, $checkInBefore);

        $this->set(['success' => true, 'message' => 'Status bed berhasil diupdate.']);
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);
    }

    private function saveBedHistory($bed, array $data, int $statusBefore, int $statusAfter, $patientIdBefore, $patientNameBefore, $checkInBefore): void
    {
        if ($statusBefore === $statusAfter || !$this->tableExists('bed_histories')) {
            return;
        }

        $this->loadModel('BedHistories');

        $history = $this->BedHistories->newEmptyEntity();
        $history->bed_id = $bed->id;
        $history->room_id = $bed->room_id;
        $history->registration_no = $data['registration_no'] ?? null;
        $history->status_before = $statusBefore;
        $history->status_after = $statusAfter;
        $history->notes = $bed->notes ?? null;
        $history->created_by = 'system';

        if ($statusAfter === 1) {
            $history->patient_id = $bed->patient_id ?? null;
            $history->patient_name = $bed->patient_name ?? null;
            $history->check_in_date = $bed->check_in_date ?? null;
            $history->check_out_date = null;
        } else {
            $history->patient_id = $patientIdBefore;
            $history->patient_name = $patientNameBefore;
            $history->check_in_date = $checkInBefore;
            $history->check_out_date = $statusBefore === 1 ? ($bed->check_out_date ?? null) : null;
        }

        $this->BedHistories->save($history);
    }

    private function buildRoomsMeta(): array
    {
        $rooms = $this->Beds->Rooms->find()
            ->select(['id', 'room_class', 'capacity'])
            ->where([
                'OR' => [
                    ['Rooms.is_delete !=' => 1],
                    ['Rooms.is_delete IS' => null],
                ],
            ])
            ->all();

        $meta = [];
        foreach ($rooms as $room) {
            $nextBedNo = $this->generateBedNoForRoom((int)$room->id);
            $used = $this->countBedsInRoom((int)$room->id);

            $meta[$room->id] = [
                'class_name' => $room->room_class,
                'capacity' => (int)$room->capacity,
                'used' => $used,
                'remaining' => max(0, (int)$room->capacity - $used),
                'next_bed_no' => $nextBedNo,
            ];
        }

        return $meta;
    }

    private function generateBedNoForRoom(int $roomId): ?string
    {
        $room = $this->Beds->Rooms->get($roomId, [
            'fields' => ['id', 'capacity'],
        ]);

        $capacity = (int)$room->capacity;
        if ($capacity <= 0) {
            return null;
        }

        $usedNumbers = [];
        $beds = $this->Beds->find()
            ->select(['bed_no'])
            ->where([
                'Beds.room_id' => $roomId,
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null],
                ],
            ])
            ->all();

        foreach ($beds as $bed) {
            if (preg_match('/(\d+)$/', (string)$bed->bed_no, $matches)) {
                $usedNumbers[(int)$matches[1]] = true;
            }
        }

        for ($number = 1; $number <= $capacity; $number++) {
            if (empty($usedNumbers[$number])) {
                return 'TT' . str_pad((string)$number, 2, '0', STR_PAD_LEFT);
            }
        }

        return null;
    }

    private function countBedsInRoom(int $roomId): int
    {
        return $this->Beds->find()
            ->where([
                'Beds.room_id' => $roomId,
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null],
                ],
            ])
            ->count();
    }
}
