<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MasterTindakan Controller
 *
 * @property \App\Model\Table\MasterTindakanTable $MasterTindakan
 * @method \App\Model\Entity\MasterTindakan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MasterTindakanController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        $q          = $this->request->getQuery('q', '');
        $kategori   = $this->request->getQuery('kategori', '');
        $isActive   = $this->request->getQuery('is_active', '');

        $conditions = [];

        if (!empty($q)) {
            $conditions['OR'] = [
                'MasterTindakan.nama LIKE'      => '%' . $q . '%',
                'MasterTindakan.kode LIKE'      => '%' . $q . '%',
                'MasterTindakan.keterangan LIKE'=> '%' . $q . '%',
            ];
        }

        if (!empty($kategori)) {
            $conditions['MasterTindakan.kategori'] = $kategori;
        }

        if ($isActive !== '') {
            $conditions['MasterTindakan.is_active'] = (int)$isActive;
        }

        $this->paginate = [
            'conditions' => $conditions,
            'order'      => ['MasterTindakan.nama' => 'ASC'],
            'limit'      => 50,
        ];

        $masterTindakan = $this->paginate($this->MasterTindakan);

        // Daftar kategori unik untuk filter
        $kategoriList = $this->MasterTindakan->find()
            ->select(['kategori'])
            ->where(['kategori IS NOT' => null, 'kategori !=' => ''])
            ->enableHydration(false)
            ->groupBy('kategori')
            ->toArray();

        $this->set(compact('masterTindakan', 'kategoriList', 'q', 'kategori', 'isActive'));
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $masterTindakan = $this->MasterTindakan->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('masterTindakan'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $masterTindakan = $this->MasterTindakan->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Normalize
            $data = $this->_normalizeData($data);

            $masterTindakan = $this->MasterTindakan->patchEntity($masterTindakan, $data);

            if ($this->MasterTindakan->save($masterTindakan)) {
                $this->Flash->success(__('Tindakan berhasil disimpan.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Gagal menyimpan tindakan. Silakan coba lagi.'));
        }

        $this->set(compact('masterTindakan'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $masterTindakan = $this->MasterTindakan->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Normalize
            $data = $this->_normalizeData($data);

            $masterTindakan = $this->MasterTindakan->patchEntity($masterTindakan, $data);

            if ($this->MasterTindakan->save($masterTindakan)) {
                $this->Flash->success(__('Tindakan berhasil diubah.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Gagal mengubah tindakan. Silakan coba lagi.'));
        }

        $this->set(compact('masterTindakan'));
    }

    /**
     * Toggle aktif/nonaktif via AJAX
     */
    public function toggleActive($id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        try {
            $masterTindakan = $this->MasterTindakan->get($id);
            $masterTindakan->is_active = $masterTindakan->is_active ? 0 : 1;

            $saved = $this->MasterTindakan->save($masterTindakan);

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success'   => (bool)$saved,
                    'is_active' => $masterTindakan->is_active,
                    'message'   => $saved
                        ? ($masterTindakan->is_active ? 'Diaktifkan' : 'Dinonaktifkan')
                        : 'Gagal mengubah status',
                ]));
        } catch (\Exception $e) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => $e->getMessage(),
                ]));
        }
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $masterTindakan = $this->MasterTindakan->get($id);

        if ($this->MasterTindakan->delete($masterTindakan)) {
            $this->Flash->success(__('Tindakan berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Gagal menghapus tindakan.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AJAX: search — Autocomplete untuk EMR
    // GET /master-tindakan/search?q=konsul&kategori=Konsultasi&limit=30
    // ─────────────────────────────────────────────────────────────────────────
    public function search()
    {
        // Izinkan GET dan juga akses AJAX lintas controller
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        // ── Nonaktifkan CSRF untuk endpoint AJAX ini ──────────────────────────
        // (Pastikan AppController tidak memaksakan CSRF pada GET request)

        $q        = trim((string)$this->request->getQuery('q', ''));
        $kategori = trim((string)$this->request->getQuery('kategori', ''));

        // Default limit dibedakan:
        // - kalau q kosong (modal minta load semua data), kasih limit lebih besar
        // - kalau q ada (autocomplete inline per-baris), tetap limit kecil biar ringan
        $defaultLimit = ($q === '') ? 500 : 30;
        $limit        = min((int)$this->request->getQuery('limit', $defaultLimit), 500);

        try {
            $conditions = [
                'MasterTindakan.is_active' => 1,
            ];

            // Hanya tambahkan filter pencarian kalau q tidak kosong.
            // Kalau q kosong, kembalikan semua tindakan aktif (dibatasi $limit).
            if ($q !== '') {
                $conditions['OR'] = [
                    'MasterTindakan.nama LIKE' => '%' . $q . '%',
                    'MasterTindakan.kode LIKE' => '%' . $q . '%',
                ];
            }

            if (!empty($kategori)) {
                $conditions['MasterTindakan.kategori'] = $kategori;
            }

            $query = $this->MasterTindakan->find()
                ->select([
                    'id',
                    'kode',
                    'nama',
                    'kategori',
                    'harga',
                    'satuan',
                    'keterangan',
                ])
                ->where($conditions)
                ->order([
                    'MasterTindakan.nama' => 'ASC',
                ])
                ->limit($limit)
                ->enableHydration(false);

            // Prioritaskan yang namanya dimulai dengan query — hanya relevan kalau q ada.
            if ($q !== '') {
                $query->order([
                    'CASE WHEN MasterTindakan.nama LIKE \'' . $q . '%\' THEN 0 ELSE 1 END' => 'ASC',
                ], true); // true = prepend, jadi urutan prioritas ini didahulukan sebelum nama ASC
            }

            $results = $query->toArray();

            // Pastikan harga selalu numerik (bukan string null)
            foreach ($results as &$row) {
                $row['harga']      = $row['harga'] !== null ? (float)$row['harga'] : 0;
                $row['kode']       = $row['kode']       ?? '';
                $row['satuan']     = $row['satuan']     ?? 'Kali';
                $row['kategori']   = $row['kategori']   ?? 'Lainnya';
                $row['keterangan'] = $row['keterangan'] ?? '';
            }
            unset($row);

            return $this->_jsonResponse($results);

        } catch (\Exception $e) {
            // Jangan expose detail error ke client di production
            return $this->_jsonResponse([
                '_error' => true,
                '_message' => 'Database error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AJAX: searchDebug — Endpoint debug (hapus di production)
    // GET /master-tindakan/search-debug
    // ─────────────────────────────────────────────────────────────────────────
    public function searchDebug()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        // Cek apakah tabel ada dan ada datanya
        try {
            $total = $this->MasterTindakan->find()->count();
            $aktif = $this->MasterTindakan->find()->where(['is_active' => 1])->count();

            $columns = $this->MasterTindakan->getSchema()->columns();

            $sample = $this->MasterTindakan->find()
                ->limit(3)
                ->enableHydration(false)
                ->toArray();

            return $this->_jsonResponse([
                'status'         => 'ok',
                'total_records'  => $total,
                'aktif_records'  => $aktif,
                'columns'        => $columns,
                'sample'         => $sample,
            ]);

        } catch (\Exception $e) {
            return $this->_jsonResponse([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Normalize & cast input data sebelum save
     */
    private function _normalizeData(array $data): array
    {
        // Default is_active ke 1 jika tidak diisi
        if (!isset($data['is_active'])) {
            $data['is_active'] = 1;
        }

        // Cast numerik
        if (isset($data['harga']) && $data['harga'] !== '') {
            $data['harga'] = (float)str_replace(['.', ','], ['', '.'], (string)$data['harga']);
        } else {
            $data['harga'] = 0;
        }

        $data['is_active'] = (int)$data['is_active'];

        // Trim string fields
        foreach (['kode', 'nama', 'kategori', 'satuan', 'keterangan'] as $f) {
            if (isset($data[$f])) {
                $data[$f] = trim((string)$data[$f]);
                if ($data[$f] === '') {
                    $data[$f] = null;
                }
            }
        }

        return $data;
    }

    /**
     * Helper: kembalikan JSON response
     */
    private function _jsonResponse($data, int $status = 200): \Cake\Http\Response
    {
        return $this->response
            ->withStatus($status)
            ->withType('application/json')
            ->withHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->withStringBody(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK));
    }
}
