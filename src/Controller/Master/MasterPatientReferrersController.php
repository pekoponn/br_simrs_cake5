<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

/**
 * MasterPatientReferrers Controller
 *
 * @property \App\Model\Table\MasterPatientReferrersTable $MasterPatientReferrers
 * @method \App\Model\Entity\MasterPatientReferrer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterPatientReferrersController extends AppController
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

        $query = $this->MasterPatientReferrers->find();

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'MasterPatientReferrers.code LIKE' => '%' . $q . '%',
                    'MasterPatientReferrers.name LIKE' => '%' . $q . '%',
                    'MasterPatientReferrers.referral_origin LIKE' => '%' . $q . '%',
                    'MasterPatientReferrers.doctor_sender LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        if ($isActive !== '') {
            $query->where([
                'MasterPatientReferrers.is_active' => $isActive,
            ]);
        }

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'MasterPatientReferrers.id' => 'DESC',
            ],
        ];

        $masterPatientReferrers = $this->paginate($query);

        $this->set(compact(
            'masterPatientReferrers',
            'q',
            'isActive'
        ));
    }

    /**
     * View method
     *
     * @param string|null $id Master Patient Referrer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterPatientReferrer = $this->MasterPatientReferrers->get($id);

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setClassName('Json');

            $this->set([
                'success' => true,
                'data' => $masterPatientReferrer,
                '_serialize' => ['success', 'data'],
            ]);

            return;
        }

        $this->set(compact('masterPatientReferrer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterPatientReferrer = $this->MasterPatientReferrers->newEmptyEntity();

        $masterPatientReferrer->code = $this->generateReferrerCode();
        $masterPatientReferrer->is_active = 'Y';

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty($data['code'])) {
                $data['code'] = $this->generateReferrerCode();
            }

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 'Y';
            }

            $masterPatientReferrer = $this->MasterPatientReferrers->patchEntity(
                $masterPatientReferrer,
                $data
            );

            if ($this->MasterPatientReferrers->save($masterPatientReferrer)) {
                $this->Flash->success('Master perujuk pasien berhasil disimpan.');

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Master perujuk pasien gagal disimpan.');
        }

        $this->set(compact('masterPatientReferrer'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master Patient Referrer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterPatientReferrer = $this->MasterPatientReferrers->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (!isset($data['is_active']) || $data['is_active'] === '') {
                $data['is_active'] = 'N';
            }

            $masterPatientReferrer = $this->MasterPatientReferrers->patchEntity(
                $masterPatientReferrer,
                $data
            );

            if ($this->MasterPatientReferrers->save($masterPatientReferrer)) {
                $this->Flash->success('Master perujuk pasien berhasil diubah.');

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Master perujuk pasien gagal diubah.');
        }

        $this->set(compact('masterPatientReferrer'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master Patient Referrer id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $masterPatientReferrer = $this->MasterPatientReferrers->get($id);
        $masterPatientReferrer->is_active = 'N';

        if ($this->MasterPatientReferrers->save($masterPatientReferrer)) {
            $this->Flash->success('Master perujuk pasien berhasil dinonaktifkan.');
        } else {
            $this->Flash->error('Master perujuk pasien gagal dinonaktifkan.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function toggleActive($id = null)
    {
        $this->request->allowMethod(['post']);

        $masterPatientReferrer = $this->MasterPatientReferrers->get($id);

        $masterPatientReferrer->is_active = $masterPatientReferrer->is_active === 'Y'
            ? 'N'
            : 'Y';

        $success = $this->MasterPatientReferrers->save($masterPatientReferrer);

        $this->viewBuilder()->setClassName('Json');

        $this->set([
            'success' => (bool)$success,
            'is_active' => $masterPatientReferrer->is_active,
            '_serialize' => ['success', 'is_active'],
        ]);
    }

    private function generateReferrerCode(): string
    {
        $last = $this->MasterPatientReferrers
            ->find()
            ->select(['id'])
            ->orderBy([
                'MasterPatientReferrers.id' => 'DESC',
            ])
            ->first();

        $next = $last
            ? ((int)$last->id + 1)
            : 1;

        return 'PRJ-' . str_pad(
            (string)$next,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
}
