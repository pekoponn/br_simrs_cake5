<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Beds Controller
 *
 * @property \App\Model\Table\BedsTable $Beds
 * @method \App\Model\Entity\Bed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BedsController extends AppController
{
    /**
     * INDEX
     */
    public function index()
    {
        $query = $this->Beds->find()
            ->contain(['Rooms'])
            ->where([
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null]
                ]
            ])
            ->order([
                'Beds.id' => 'DESC'
            ]);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        $key = $this->request->getQuery('key');

        if (!empty($key)) {
            $query->where([
                'OR' => [
                    'Beds.code LIKE'       => '%' . $key . '%',
                    'Beds.bed_no LIKE'     => '%' . $key . '%',
                    'Beds.name LIKE'       => '%' . $key . '%',
                    'Beds.class_name LIKE' => '%' . $key . '%',
                    'Rooms.room_name LIKE' => '%' . $key . '%',
                ]
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER ROOM
        |--------------------------------------------------------------------------
        */
        $roomId = $this->request->getQuery('room_id');

        if (!empty($roomId)) {
            $query->where([
                'Beds.room_id' => $roomId
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER CLASS
        |--------------------------------------------------------------------------
        */
        $className = $this->request->getQuery('class_name');

        if (!empty($className)) {
            $query->where([
                'Beds.class_name' => $className
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */
        $status = $this->request->getQuery('status');

        if ($status !== null && $status !== '') {
            $query->where([
                'Beds.status' => $status
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $this->paginate = [
            'limit' => 10
        ];

        $beds = $this->paginate($query);

        /*
        |--------------------------------------------------------------------------
        | ROOM LIST
        |--------------------------------------------------------------------------
        */
        $rooms = $this->Beds->Rooms->find('list', [
            'keyField'   => 'id',
            'valueField' => 'room_name'
        ])
            ->order([
                'Rooms.room_name' => 'ASC'
            ])
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | CLASS LIST
        |--------------------------------------------------------------------------
        */
        $classList = $this->Beds->getClassList();

        /*
        |--------------------------------------------------------------------------
        | STATUS LIST
        |--------------------------------------------------------------------------
        */
        $statusList = $this->Beds->getStatusList();

        $this->set(compact(
            'beds',
            'rooms',
            'classList',
            'statusList',
            'key',
            'roomId',
            'className',
            'status'
        ));
    }

    /**
     * VIEW
     */
    public function view($id = null)
    {
        $bed = $this->Beds->get($id, [
            'contain' => ['Rooms'],
        ]);

        $this->set(compact('bed'));
    }

    /**
     * ADD
     */
    public function add()
    {
        $bed = $this->Beds->newEmptyEntity();

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            /*
            |--------------------------------------------------------------------------
            | AUTO GENERATE CODE
            |--------------------------------------------------------------------------
            */
            if (empty($data['code'])) {

                $lastBed = $this->Beds
                    ->find()
                    ->order([
                        'Beds.id' => 'DESC'
                    ])
                    ->first();

                $lastId = $lastBed ? ($lastBed->id + 1) : 1;

                $data['code'] =
                    'BED-' . str_pad((string)$lastId, 4, '0', STR_PAD_LEFT);
            }

            /*
            |--------------------------------------------------------------------------
            | DEFAULT VALUE
            |--------------------------------------------------------------------------
            */
            $data['is_create'] = 1;

            if (empty($data['is_active'])) {
                $data['is_active'] = 'Y';
            }

            if (!isset($data['status'])) {
                $data['status'] = 0;
            }

            $bed = $this->Beds->patchEntity($bed, $data);

            if ($this->Beds->save($bed)) {

                $this->Flash->success(__('Bed berhasil disimpan.'));

                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('Bed gagal disimpan.'));
        }

        /*
        |--------------------------------------------------------------------------
        | ROOM LIST
        |--------------------------------------------------------------------------
        */
        $rooms = $this->Beds->Rooms->find('list', [
            'keyField'   => 'id',
            'valueField' => 'room_name'
        ])
            ->order([
                'Rooms.room_name' => 'ASC'
            ])
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN LIST
        |--------------------------------------------------------------------------
        */
        $classList  = $this->Beds->getClassList();
        $statusList = $this->Beds->getStatusList();
        $activeList = $this->Beds->getActiveList();

        $this->set(compact(
            'bed',
            'rooms',
            'classList',
            'statusList',
            'activeList'
        ));
    }

    /**
     * EDIT
     */
    public function edit($id = null)
    {
        $bed = $this->Beds->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            /*
            |--------------------------------------------------------------------------
            | UPDATE FLAG
            |--------------------------------------------------------------------------
            */
            $data['is_update'] = 1;

            $bed = $this->Beds->patchEntity($bed, $data);

            if ($this->Beds->save($bed)) {

                $this->Flash->success(__('Bed berhasil diupdate.'));

                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('Bed gagal diupdate.'));
        }

        /*
        |--------------------------------------------------------------------------
        | ROOM LIST
        |--------------------------------------------------------------------------
        */
        $rooms = $this->Beds->Rooms->find('list', [
            'keyField'   => 'id',
            'valueField' => 'room_name'
        ])
            ->order([
                'Rooms.room_name' => 'ASC'
            ])
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN LIST
        |--------------------------------------------------------------------------
        */
        $classList  = $this->Beds->getClassList();
        $statusList = $this->Beds->getStatusList();
        $activeList = $this->Beds->getActiveList();

        $this->set(compact(
            'bed',
            'rooms',
            'classList',
            'statusList',
            'activeList'
        ));
    }

    /**
     * DELETE
     */
    public function delete($id = null)
    {
        $this->request->allowMethod([
            'post',
            'delete'
        ]);

        $bed = $this->Beds->get($id);

        /*
        |--------------------------------------------------------------------------
        | SOFT DELETE
        |--------------------------------------------------------------------------
        */
        $bed->is_delete = 1;
        $bed->deleted   = date('Y-m-d H:i:s');
        $bed->delete_log = 'Deleted by user';

        if ($this->Beds->save($bed)) {

            $this->Flash->success(__('Bed berhasil dihapus.'));
        } else {

            $this->Flash->error(__('Bed gagal dihapus.'));
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * MONITORING
     */
    public function monitoring()
    {
        $beds = $this->Beds->find()
            ->contain(['Rooms'])
            ->where([
                'Beds.is_active' => 'Y',
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null]
                ]
            ])
            ->order([
                'Rooms.room_name' => 'ASC',
                'Beds.bed_no'     => 'ASC'
            ])
            ->all();

        $this->set(compact('beds'));
    }
}
