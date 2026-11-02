<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Rooms Controller
 *
 * @property \App\Model\Table\RoomsTable $Rooms
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoomsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Rooms->find()
            ->contain([
                'Beds' => function ($q) {
                    return $q
                        ->where([
                            'Beds.is_active' => 'Y',
                            'OR' => [
                                ['Beds.is_delete !=' => 1],
                                ['Beds.is_delete IS' => null],
                            ],
                        ])
                        ->order(['Beds.bed_no' => 'ASC']);
                },
            ]);

        $filterCode = $this->request->getQuery('filterCode');
        if (!empty($filterCode)) {
            $query->where(['Rooms.room_code LIKE' => '%' . $filterCode . '%']);
        }

        $filterName = $this->request->getQuery('filterName');
        if (!empty($filterName)) {
            $query->where(['Rooms.room_name LIKE' => '%' . $filterName . '%']);
        }

        $rooms = $this->paginate($query);

        $this->set(compact('rooms'));
    }

    /**
     * View method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $room = $this->Rooms->get($id, contain: []);

        $this->set(compact('room'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $room = $this->Rooms->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (!empty($data['auto_room_code']) || empty($data['room_code'])) {
                $data['room_code'] = $this->generateRoomCode();
            }

            $room = $this->Rooms->patchEntity($room, $data);

            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The room could not be saved. Please, try again.'));
        }

        $this->set(compact('room'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $room = $this->Rooms->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $room = $this->Rooms->patchEntity($room, $this->request->getData());
            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The room could not be saved. Please, try again.'));
        }
        $this->set(compact('room'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $room = $this->Rooms->get($id);
        if ($this->Rooms->delete($room)) {
            $this->Flash->success(__('The room has been deleted.'));
        } else {
            $this->Flash->error(__('The room could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function generateRoomCode()
    {
        $lastRoom = $this->Rooms->find()
            ->orderBy(['id' => 'DESC'])
            ->first();

        $next = $lastRoom ? ((int)$lastRoom->id + 1) : 1;

        return 'RM' . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
    }

    public function monitoring()
    {
        $selectedClass = $this->request->getQuery('class');
    
        $query = $this->Rooms->find()
            ->contain(['Beds'])
            ->where([
                'OR' => [
                    ['Rooms.is_active' => 'Y'],
                    ['Rooms.is_active' => 1],
                    ['Rooms.is_active IS' => null],
                ]
            ])
            ->orderBy([
                'Rooms.room_class' => 'ASC',
                'Rooms.floor' => 'ASC',
                'Rooms.room_name' => 'ASC',
            ]);
    
        if ($selectedClass !== null && $selectedClass !== '') {
            $query->where(['Rooms.room_class' => $selectedClass]);
        }
    
        $rooms = $query->all();
    
        $roomGroups = [];
        $summary = [
            'rooms' => 0,
            'beds' => 0,
            'used' => 0,
            'free' => 0,
        ];
    
        foreach ($rooms as $room) {
            $className = $room->room_class ?: 'Tanpa Kelas';
    
            if (!isset($roomGroups[$className])) {
                $roomGroups[$className] = [
                    'rooms' => [],
                    'beds' => 0,
                    'used' => 0,
                    'free' => 0,
                ];
            }
    
            $summary['rooms']++;
            $roomGroups[$className]['rooms'][] = $room;
    
            foreach (($room->beds ?? []) as $bed) {
                $summary['beds']++;
                $roomGroups[$className]['beds']++;
    
                if ((int)($bed->status ?? 0) === 1) {
                    $summary['used']++;
                    $roomGroups[$className]['used']++;
                } else {
                    $summary['free']++;
                    $roomGroups[$className]['free']++;
                }
            }
        }
    
        $this->set(compact('rooms', 'roomGroups', 'summary', 'selectedClass'));
    }
}
