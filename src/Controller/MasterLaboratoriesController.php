<?php
declare(strict_types=1);

namespace App\Controller;

class MasterLaboratoriesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->MasterLaboratories = $this->fetchTable('MasterLaboratories');
    }

    public function index()
    {
        $q = trim((string)$this->request->getQuery('q', ''));
        $isActive = $this->request->getQuery('is_active', '');

        $query = $this->MasterLaboratories->find();

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'MasterLaboratories.code LIKE' => '%' . $q . '%',
                    'MasterLaboratories.name LIKE' => '%' . $q . '%',
                    'MasterLaboratories.category LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        if ($isActive !== '') {
            $query->where([
                'MasterLaboratories.is_active' => (int)$isActive,
            ]);
        }

        $sortableFields = [
            'id',
            'code',
            'name',
            'tariff',
            'jasa_rs',
            'jasa_dr',
            'jasa_perawat',
            'category',
            'is_active',
            'created',
            'modified',
        ];

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'id' => 'ASC',
            ],
            'sortableFields' => $sortableFields,
            'sortWhitelist' => $sortableFields,
        ];

        $masterLaboratories = $this->paginate($query);

        $this->set(compact('masterLaboratories', 'q', 'isActive'));
    }

    public function view($id = null)
    {
        $masterLaboratory = $this->MasterLaboratories->get($id);

        $this->set(compact('masterLaboratory'));
    }

    public function add()
    {
        $masterLaboratory = $this->MasterLaboratories->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Kode selalu digenerate server-side, tidak boleh diisi dari form
            // (field di UI readonly, tapi tetap dibuang di sini untuk keamanan).
            unset($data['code']);

            $masterLaboratory = $this->MasterLaboratories->patchEntity($masterLaboratory, $data);
            $masterLaboratory->code = $this->generateLabCode();

            if ($this->MasterLaboratories->save($masterLaboratory)) {
                $this->Flash->success(__('Data laboratorium berhasil disimpan.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Data laboratorium gagal disimpan. Silakan coba lagi.'));
        }

        $this->set(compact('masterLaboratory'));
    }

    private function generateLabCode(): string
    {
        $lastRow = $this->MasterLaboratories->find()
            ->select(['id'])
            ->order(['MasterLaboratories.id' => 'DESC'])
            ->first();

        $next = $lastRow ? ((int)$lastRow->id + 1) : 1;

        return 'LAB' . str_pad((string)$next, 5, '0', STR_PAD_LEFT);
    }

    public function edit($id = null)
    {
        $masterLaboratory = $this->MasterLaboratories->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 0;
            }

            $masterLaboratory = $this->MasterLaboratories->patchEntity($masterLaboratory, $data);

            if ($this->MasterLaboratories->save($masterLaboratory)) {
                $this->Flash->success('Master laboratorium berhasil diubah.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Master laboratorium gagal diubah.');
        }

        $this->set(compact('masterLaboratory'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $masterLaboratory = $this->MasterLaboratories->get($id);
        $masterLaboratory->is_active = 0;

        if ($this->MasterLaboratories->save($masterLaboratory)) {
            $this->Flash->success('Master laboratorium berhasil dinonaktifkan.');
        } else {
            $this->Flash->error('Master laboratorium gagal dinonaktifkan.');
        }

        return $this->redirect(['action' => 'index']);
    }
}