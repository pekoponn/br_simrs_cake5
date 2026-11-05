<?php
declare(strict_types=1);

namespace App\Controller\Penunjang;

use App\Controller\AppController;

class LabSenderDoctorsController extends AppController
{

    public function index()
    {
        $q = trim((string)$this->request->getQuery('q'));

        $query = $this->LabSenderDoctors->find()->orderBy(['LabSenderDoctors.name' => 'ASC']);
        if ($q !== '') {
            $query->where(['OR' => [
                'LabSenderDoctors.code LIKE' => '%' . $q . '%',
                'LabSenderDoctors.name LIKE' => '%' . $q . '%',
                'LabSenderDoctors.address LIKE' => '%' . $q . '%',
            ]]);
        }

        $this->set('doctors', $this->paginate($query, ['limit' => 50]));
        $this->set('doctors', $this->paginate($query));
        $this->set(compact('q'));
    }

    /**
     * Tambah (tanpa id) atau ubah (dengan id) — dipanggil dari modal.
     */
    public function save()
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();
        $id = (int)($data['id'] ?? 0);
        unset($data['id']);

        if ($id > 0) {
            $doctor = $this->LabSenderDoctors->get($id);
        } else {
            $doctor = $this->LabSenderDoctors->newEmptyEntity();
            if (trim((string)($data['code'] ?? '')) === '') {
                $row = $this->LabSenderDoctors->find()->select(['max_id' => 'MAX(id)'])->disableHydration()->first();
                $data['code'] = 'DL' . str_pad((string)(((int)($row['max_id'] ?? 0)) + 1), 6, '0', STR_PAD_LEFT);
            }
        }

        $data['name'] = strtoupper(trim((string)($data['name'] ?? '')));
        $data['is_active'] = !empty($data['is_active']) ? 1 : 0;

        $doctor = $this->LabSenderDoctors->patchEntity($doctor, $data);
        if ($this->LabSenderDoctors->save($doctor)) {
            $this->Flash->success('Data dokter pengirim tersimpan.');
        } else {
            $messages = [];
            foreach ($doctor->getErrors() as $errs) {
                $messages = array_merge($messages, array_values((array)$errs));
            }
            $this->Flash->error('Gagal menyimpan: ' . implode(', ', $messages));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $doctor = $this->LabSenderDoctors->get($id);
        if ($this->LabSenderDoctors->delete($doctor)) {
            $this->Flash->success('Data dokter pengirim dihapus.');
        } else {
            $this->Flash->error('Data tidak dapat dihapus.');
        }

        return $this->redirect(['action' => 'index']);
    }
}