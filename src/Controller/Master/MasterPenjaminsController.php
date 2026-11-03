<?php

declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * MasterPenjamins Controller
 *
 * @property \App\Model\Table\MasterPenjaminsTable $MasterPenjamins
 * @method \App\Model\Entity\MasterPenjamin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterPenjaminsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $q = trim((string)$this->request->getQuery('q', ''));
        $isActive = $this->request->getQuery('is_active', '');

        $query = $this->MasterPenjamins->find();

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'MasterPenjamins.code LIKE' => '%' . $q . '%',
                    'MasterPenjamins.name LIKE' => '%' . $q . '%',
                    'MasterPenjamins.type LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        if ($isActive !== '') {
            $query->where([
                'MasterPenjamins.is_active' => (int)$isActive,
            ]);
        }

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'MasterPenjamins.id' => 'DESC',
            ],
        ];

        $masterPenjamins = $this->paginate($query);

        $this->set(compact(
            'masterPenjamins',
            'q',
            'isActive'
        ));
    }

    /**
     * View method
     *
     * @param string|null $id Master Penjamin id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterPenjamin = $this->MasterPenjamins->get($id);

        if ($this->request->is('ajax')) {

            $this->viewBuilder()->setClassName('Json');

            $this->set([
                'success' => true,
                'data' => $masterPenjamin,
                '_serialize' => ['success', 'data']
            ]);

            return;
        }

        $this->set(compact('masterPenjamin'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterPenjamin = $this->MasterPenjamins->newEmptyEntity();

        // Generate kode saat halaman pertama kali dibuka
        $masterPenjamin->code = $this->generatePenjaminCode();
        $masterPenjamin->is_active = 1;

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            // Kalau code kosong, isi lagi
            if (empty($data['code'])) {
                $data['code'] = $this->generatePenjaminCode();
            }

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 1;
            }

            $masterPenjamin = $this->MasterPenjamins->patchEntity(
                $masterPenjamin,
                $data
            );

            if ($this->MasterPenjamins->save($masterPenjamin)) {
                $this->Flash->success('Master penjamin berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Master penjamin gagal disimpan.');
        }

        $this->set(compact('masterPenjamin'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Penjamin id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterPenjamin = $this->MasterPenjamins->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 0;
            }

            $masterPenjamin = $this->MasterPenjamins->patchEntity(
                $masterPenjamin,
                $data
            );

            if ($this->MasterPenjamins->save($masterPenjamin)) {

                $this->Flash->success(
                    'Master penjamin berhasil diubah.'
                );

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(
                'Master penjamin gagal diubah.'
            );
        }

        $this->set(compact('masterPenjamin'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Penjamin id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $masterPenjamin = $this->MasterPenjamins->get($id);

        $masterPenjamin->is_active = 0;

        if ($this->MasterPenjamins->save($masterPenjamin)) {

            $this->Flash->success(
                'Master penjamin berhasil dinonaktifkan.'
            );
        } else {

            $this->Flash->error(
                'Master penjamin gagal dinonaktifkan.'
            );
        }

        return $this->redirect(['action' => 'index']);
    }

    public function toggleActive($id = null)
    {
        $this->request->allowMethod(['post']);

        $masterPenjamin = $this->MasterPenjamins->get($id);

        $masterPenjamin->is_active = !$masterPenjamin->is_active;

        $success = $this->MasterPenjamins->save($masterPenjamin);

        $this->viewBuilder()->setClassName('Json');

        $this->set([
            'success' => (bool)$success,
            'is_active' => (int)$masterPenjamin->is_active,
            '_serialize' => ['success', 'is_active']
        ]);
    }

    private function generatePenjaminCode(): string
    {
        $last = $this->MasterPenjamins
            ->find()
            ->select(['id'])
            ->orderBy([
                'MasterPenjamins.id' => 'DESC'
            ])
            ->first();

        $next = $last
            ? ((int)$last->id + 1)
            : 1;

        return 'PJM-' . str_pad(
            (string)$next,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
}
