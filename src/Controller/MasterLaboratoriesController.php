<?php

declare(strict_types=1);

namespace App\Controller;

class MasterLaboratoriesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadModel('MasterLaboratories');
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

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'MasterLaboratories.id' => 'DESC',
            ],
        ];

        $masterLaboratories = $this->paginate($query);

        $this->set(compact('masterLaboratories', 'q', 'isActive'));
    }

    public function view($id = null)
    {
        $masterLaboratory = $this->MasterLaboratories->get($id);

        if ($this->request->is('ajax')) {

            $this->viewBuilder()->setClassName('Json');

            $this->set([
                'success' => true,
                'data' => $masterLaboratory,
                '_serialize' => ['success', 'data']
            ]);

            return;
        }

        $this->set(compact('masterLaboratory'));
    }

    public function add()
    {
        $masterLaboratory = $this->MasterLaboratories->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['code'])) {
                $data['code'] = $this->generateLabCode();
            }

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 1;
            }

            $masterLaboratory = $this->MasterLaboratories->patchEntity($masterLaboratory, $data);

            if ($this->MasterLaboratories->save($masterLaboratory)) {
                $this->Flash->success('Master laboratorium berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Master laboratorium gagal disimpan.');
        }

        $this->set(compact('masterLaboratory'));
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

    private function generateLabCode(): string
    {
        $last = $this->MasterLaboratories->find()
            ->select(['id'])
            ->order(['MasterLaboratories.id' => 'DESC'])
            ->first();

        $next = $last ? ((int)$last->id + 1) : 1;

        return 'LAB' . str_pad((string)$next, 5, '0', STR_PAD_LEFT);
    }
    // public function viewAjax($id)
    // {
    //     $this->request->allowMethod(['get']);

    //     $data = $this->MasterLaboratories->get($id);

    //     $this->viewBuilder()->setClassName('Json');

    //     $this->set([
    //         'success' => true,
    //         'data' => $data,
    //         '_serialize' => ['success','data']
    //     ]);
    // }
}
