<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * MasterTreatmentPackages Controller
 *
 * @property \App\Model\Table\MasterTreatmentPackagesTable $MasterTreatmentPackages
 * @method \App\Model\Entity\MasterTreatmentPackage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterTreatmentPackagesController extends AppController
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

        $query = $this->MasterTreatmentPackages->find();

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'MasterTreatmentPackages.code LIKE' => '%' . $q . '%',
                    'MasterTreatmentPackages.name LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        if ($isActive !== '') {
            $query->where([
                'MasterTreatmentPackages.is_active' => $isActive,
            ]);
        }

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'MasterTreatmentPackages.id' => 'DESC',
            ],
        ];

        $masterTreatmentPackages = $this->paginate($query);

        $this->set(compact(
            'masterTreatmentPackages',
            'q',
            'isActive'
        ));
    }

    /**
     * View method
     *
     * @param string|null $id Master Treatment Package id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterTreatmentPackage = $this->MasterTreatmentPackages->get($id);

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setClassName('Json');

            $this->set([
                'success' => true,
                'data' => $masterTreatmentPackage,
                '_serialize' => ['success', 'data'],
            ]);

            return;
        }

        $this->set(compact('masterTreatmentPackage'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterTreatmentPackage = $this->MasterTreatmentPackages->newEmptyEntity();

        $masterTreatmentPackage->code = $this->generatePackageCode();
        $masterTreatmentPackage->is_active = 'Y';

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['code'])) {
                $data['code'] = $this->generatePackageCode();
            }

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 'Y';
            }

            $masterTreatmentPackage = $this->MasterTreatmentPackages->patchEntity(
                $masterTreatmentPackage,
                $data
            );

            if ($this->MasterTreatmentPackages->save($masterTreatmentPackage)) {
                $this->Flash->success('Master paket treatment berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Master paket treatment gagal disimpan.');
        }

        $this->set(compact('masterTreatmentPackage'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Treatment Package id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterTreatmentPackage = $this->MasterTreatmentPackages->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 'N';
            }

            $masterTreatmentPackage = $this->MasterTreatmentPackages->patchEntity(
                $masterTreatmentPackage,
                $data
            );

            if ($this->MasterTreatmentPackages->save($masterTreatmentPackage)) {
                $this->Flash->success('Master paket treatment berhasil diubah.');

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Master paket treatment gagal diubah.');
        }

        $this->set(compact('masterTreatmentPackage'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Treatment Package id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $masterTreatmentPackage = $this->MasterTreatmentPackages->get($id);

        $masterTreatmentPackage->is_active = 'N';

        if ($this->MasterTreatmentPackages->save($masterTreatmentPackage)) {
            $this->Flash->success('Master paket treatment berhasil dinonaktifkan.');
        } else {
            $this->Flash->error('Master paket treatment gagal dinonaktifkan.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function toggleActive($id = null)
    {
        $this->request->allowMethod(['post']);

        $masterTreatmentPackage = $this->MasterTreatmentPackages->get($id);

        $masterTreatmentPackage->is_active = $masterTreatmentPackage->is_active === 'Y'
            ? 'N'
            : 'Y';

        $success = $this->MasterTreatmentPackages->save($masterTreatmentPackage);

        $this->viewBuilder()->setClassName('Json');

        $this->set([
            'success' => (bool)$success,
            'is_active' => $masterTreatmentPackage->is_active,
            '_serialize' => ['success', 'is_active'],
        ]);
    }

    private function generatePackageCode(): string
    {
        $last = $this->MasterTreatmentPackages
            ->find()
            ->select(['id'])
            ->orderBy([
                'MasterTreatmentPackages.id' => 'DESC',
            ])
            ->first();

        $next = $last
            ? ((int)$last->id + 1)
            : 1;

        return 'PKT-' . str_pad(
            (string)$next,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
}
