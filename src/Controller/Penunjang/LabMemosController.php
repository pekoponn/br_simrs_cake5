<?php
declare(strict_types=1);

namespace App\Controller\Penunjang;

use App\Controller\AppController;
use Cake\I18n\DateTime;

/**
 * Internal Memo Laboratorium (semua action mengembalikan JSON untuk modal).
 *
 * Key hak akses (users/access): labmemos -> index, add, delete
 */
class LabMemosController extends AppController
{
    public function index()
    {
        $this->request->allowMethod(['get']);

        $q = trim((string)$this->request->getQuery('q'));
        $query = $this->fetchTable('LabInternalMemos')->find()
            ->orderBy(['memo_date' => 'DESC', 'id' => 'DESC'])
            ->limit(200);

        if ($q !== '') {
            $like = '%' . $q . '%';
            $query->where(['OR' => [
                'registration_no LIKE' => $like,
                'medical_record_no LIKE' => $like,
                'patient_name LIKE' => $like,
                'memo LIKE' => $like,
            ]]);
        }

        $rows = [];
        foreach ($query->all() as $m) {
            $rows[] = [
                'id' => (int)$m->id,
                'noreg' => (string)$m->registration_no,
                'rm' => (string)$m->medical_record_no,
                'name' => (string)$m->patient_name,
                'date' => $m->memo_date ? $m->memo_date->format('d-m-Y H:i') : '-',
                'memo' => (string)$m->memo,
                'by' => (string)$m->created_by,
            ];
        }

        return $this->respondJson(['ok' => true, 'rows' => $rows]);
    }

    public function add()
    {
        $this->request->allowMethod(['post']);

        $table = $this->fetchTable('LabInternalMemos');
        $data = $this->request->getData();
        $data = [
            'registration_no' => trim((string)($data['registration_no'] ?? '')),
            'medical_record_no' => trim((string)($data['medical_record_no'] ?? '')),
            'patient_name' => trim((string)($data['patient_name'] ?? '')),
            'memo' => trim((string)($data['memo'] ?? '')),
        ];

        $memo = $table->newEntity($data);
        $memo->memo_date = DateTime::now();
        $memo->created_by = $this->currentUserName();

        if (!$table->save($memo)) {
            $messages = [];
            foreach ($memo->getErrors() as $errs) {
                $messages = array_merge($messages, array_values((array)$errs));
            }

            return $this->respondJson(['ok' => false, 'message' => implode(', ', $messages) ?: 'Gagal menyimpan memo.']);
        }

        return $this->respondJson(['ok' => true]);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $table = $this->fetchTable('LabInternalMemos');
        $memo = $table->find()->where(['id' => (int)$id])->first();
        if ($memo === null) {
            return $this->respondJson(['ok' => false, 'message' => 'Memo tidak ditemukan.']);
        }

        if (!$table->delete($memo)) {
            return $this->respondJson(['ok' => false, 'message' => 'Memo tidak dapat dihapus.']);
        }

        return $this->respondJson(['ok' => true]);
    }

    /**
     * Nama user yang membuat memo. SESUAIKAN dengan cara aplikasi Anda menyimpan user login.
     */
    private function currentUserName(): string
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity && method_exists($identity, 'get')) {
            return (string)($identity->get('name') ?? '');
        }

        return '';
    }

    private function respondJson(array $data)
    {
        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE));
    }
}