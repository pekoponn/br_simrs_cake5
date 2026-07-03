<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * MasterRadiologies Controller
 *
 * @property \App\Model\Table\MasterRadiologiesTable $MasterRadiologies
 * @method \App\Model\Entity\MasterRadiology[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterRadiologiesController extends AppController
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

        $query = $this->MasterRadiologies->find();

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'MasterRadiologies.code LIKE' => '%' . $q . '%',
                    'MasterRadiologies.name LIKE' => '%' . $q . '%',
                    'MasterRadiologies.category LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        if ($isActive !== '') {
            $query->where([
                'MasterRadiologies.is_active' => (int)$isActive,
            ]);
        }

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'MasterRadiologies.id' => 'DESC',
            ],
        ];

        $masterRadiologies = $this->paginate($query);

        $this->set(compact(
            'masterRadiologies',
            'q',
            'isActive'
        ));
    }

    /**
     * View method
     *
     * @param string|null $id Master Radiology id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterRadiology = $this->MasterRadiologies->get($id);

        if ($this->request->is('ajax')) {

            $this->viewBuilder()->setClassName('Json');

            $this->set([
                'success' => true,
                'data' => $masterRadiology,
                '_serialize' => ['success', 'data']
            ]);

            return;
        }

        $this->set(compact('masterRadiology'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterRadiology = $this->MasterRadiologies->newEmptyEntity();

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            if (empty($data['code'])) {
                $data['code'] = $this->generateRadiologyCode();
            }

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 1;
            }

            $masterRadiology = $this->MasterRadiologies->patchEntity(
                $masterRadiology,
                $data
            );

            if ($this->MasterRadiologies->save($masterRadiology)) {

                $this->Flash->success(
                    'Master radiologi berhasil disimpan.'
                );

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(
                'Master radiologi gagal disimpan.'
            );
        }

        $this->set(compact('masterRadiology'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Radiology id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterRadiology = $this->MasterRadiologies->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 0;
            }

            $masterRadiology = $this->MasterRadiologies->patchEntity(
                $masterRadiology,
                $data
            );

            if ($this->MasterRadiologies->save($masterRadiology)) {

                $this->Flash->success(
                    'Master radiologi berhasil diubah.'
                );

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(
                'Master radiologi gagal diubah.'
            );
        }

        $this->set(compact('masterRadiology'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Radiology id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $masterRadiology = $this->MasterRadiologies->get($id);

        $masterRadiology->is_active = 0;

        if ($this->MasterRadiologies->save($masterRadiology)) {
            $this->Flash->success('Master radiologi berhasil dinonaktifkan.');
        } else {
            $this->Flash->error('Master radiologi gagal dinonaktifkan.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function toggleActive($id = null)
    {
        $this->request->allowMethod(['post']);

        $masterRadiology = $this->MasterRadiologies->get($id);

        $masterRadiology->is_active = !$masterRadiology->is_active;

        $success = $this->MasterRadiologies->save($masterRadiology);

        $this->viewBuilder()->setClassName('Json');

        $this->set([
            'success' => (bool)$success,
            'is_active' => (int)$masterRadiology->is_active,
            '_serialize' => ['success', 'is_active']
        ]);
    }
}
