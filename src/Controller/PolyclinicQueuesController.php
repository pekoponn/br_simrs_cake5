<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PolyclinicQueues Controller
 *
 * @property \App\Model\Table\PolyclinicQueuesTable $PolyclinicQueues
 */
class PolyclinicQueuesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('PolyclinicQueues');
    }

    public function index()
    {
        $polyclinicQueues = $this->paginate($this->PolyclinicQueues);

        $this->set(compact('polyclinicQueues'));
    }

    public function view($id = null)
    {
        $polyclinicQueue = $this->PolyclinicQueues->get($id);

        $this->set(compact('polyclinicQueue'));
    }

    public function add()
    {
        $polyclinicQueue = $this->PolyclinicQueues->newEmptyEntity();

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            // RESET NOMOR SETIAP HARI
            $startDate = date('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:59');

            $lastQueue = $this->PolyclinicQueues
                ->find()
                ->where([
                    'created >=' => $startDate,
                    'created <=' => $endDate
                ])
                ->order([
                    'queue_number' => 'DESC'
                ])
                ->first();

            $nextNumber = $lastQueue
                ? $lastQueue->queue_number + 1
                : 1;

            $data['queue_number'] = $nextNumber;

            $data['code'] = 'A-' . str_pad(
                (string) $nextNumber,
                3,
                '0',
                STR_PAD_LEFT
            );

            // SOURCE WA
            $data['source'] = 'WA';

            $data['is_create'] = 1;
            $data['is_update'] = 0;
            $data['is_delete'] = 0;
            $data['is_active'] = 'Y';

            $polyclinicQueue = $this->PolyclinicQueues
                ->patchEntity($polyclinicQueue, $data);

            if ($this->PolyclinicQueues->save($polyclinicQueue)) {

                $this->Flash->success(
                    __('Pendaftaran WA berhasil.')
                );

                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(
                __('Pendaftaran WA gagal.')
            );
        }

        $this->set(compact(
            'polyclinicQueue'
        ));
    }

    public function edit($id = null)
    {
        $polyclinicQueue = $this->PolyclinicQueues->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $data['is_update'] = 1;

            $polyclinicQueue = $this->PolyclinicQueues->patchEntity(
                $polyclinicQueue,
                $data
            );

            if ($this->PolyclinicQueues->save($polyclinicQueue)) {
                $this->Flash->success(__('The polyclinic queue has been updated.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The polyclinic queue could not be updated.'));
        }

        $this->set(compact('polyclinicQueue'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod([
            'post',
            'delete'
        ]);

        $polyclinicQueue = $this->PolyclinicQueues->get($id);

        $polyclinicQueue->is_delete = 1;
        $polyclinicQueue->is_active = 'N';
        $polyclinicQueue->deleted = date('Y-m-d H:i:s');
        $polyclinicQueue->delete_log = 'Deleted by user';

        if ($this->PolyclinicQueues->save($polyclinicQueue)) {
            $this->Flash->success(__('The polyclinic queue has been deleted.'));
        } else {
            $this->Flash->error(__('The polyclinic queue could not be deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function kiosk()
    {
        $queueNumber = null;
        $queueCode = null;

        if ($this->request->is('post')) {
            $polyName = $this->request->getData('poly_name');

            $startDate = date('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:59');

            $lastQueue = $this->PolyclinicQueues
                ->find()
                ->where([
                    'created >=' => $startDate,
                    'created <=' => $endDate
                ])
                ->order([
                    'queue_number' => 'DESC'
                ])
                ->first();

            $nextNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;

            $queue = $this->PolyclinicQueues->newEmptyEntity();

            $queue->code = 'A-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
            $queue->source = 'KIOSK';
            $queue->poly_name = $polyName;
            $queue->queue_number = $nextNumber;
            $queue->is_create = 1;
            $queue->is_update = 0;
            $queue->is_delete = 0;
            $queue->is_active = 'Y';

            if ($this->PolyclinicQueues->save($queue)) {
                $queueNumber = $nextNumber;
                $queueCode = $queue->code;
            }
        }

        $this->set(compact(
            'queueNumber',
            'queueCode'
        ));
    }

    // public function wa()
    // {
    //     $polyclinicQueue = $this->PolyclinicQueues->newEmptyEntity();

    //     if ($this->request->is('post')) {
    //         $data = $this->request->getData();

    //         $polyName = $data['poly_name'];

    //         $lastQueue = $this->PolyclinicQueues
    //             ->find()
    //             ->order([
    //                 'queue_number' => 'DESC'
    //             ])
    //             ->first();

    //         $nextNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;

    //         $nextNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;

    //         $data['code'] = 'A-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    //         $data['source'] = 'WA';
    //         $data['queue_number'] = $nextNumber;
    //         $data['is_create'] = 1;
    //         $data['is_update'] = 0;
    //         $data['is_delete'] = 0;
    //         $data['is_active'] = 'Y';

    //         $polyclinicQueue = $this->PolyclinicQueues->patchEntity(
    //             $polyclinicQueue,
    //             $data
    //         );

    //         if ($this->PolyclinicQueues->save($polyclinicQueue)) {
    //             $this->Flash->success(__('Pendaftaran antrean via WA berhasil.'));

    //             return $this->redirect(['action' => 'index']);
    //         }

    //         $this->Flash->error(__('Pendaftaran antrean via WA gagal.'));
    //     }

    //     $this->set(compact('polyclinicQueue'));
    // }
}