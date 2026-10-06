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

    public function getNextKode()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $kategoriConfig = $this->_kategoriConfig();

        $kategori = trim((string)$this->request->getQuery('kategori', ''));
        $prefix   = $kategoriConfig[$kategori]['prefix'] ?? null;

        if (empty($kategori) || $prefix === null) {
            return $this->_jsonResponse([
                'success' => false,
                'message' => 'Kategori tidak valid.',
            ], 400);
        }

        // Cari kode terakhir dengan prefix ini, urutkan berdasarkan angka terbesar
        $lastRow = $this->MasterTindakan->find()
            ->select(['kode'])
            ->where(['MasterTindakan.kode LIKE' => $prefix . '-%'])
            ->enableHydration(false)
            ->toArray();

        $maxNo = 0;
        foreach ($lastRow as $row) {
            if (preg_match('/-(\d+)$/', $row['kode'], $m)) {
                $maxNo = max($maxNo, (int)$m[1]);
            }
        }

        $nextNo   = $maxNo + 1;
        $nextKode = $prefix . '-' . str_pad((string)$nextNo, 3, '0', STR_PAD_LEFT);

        return $this->_jsonResponse([
            'success'  => true,
            'kode'     => $nextKode,
            'prefix'   => $prefix,
            'next_no'  => $nextNo,
        ]);
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

        $q         = trim((string)$this->request->getQuery('q', ''));
        $kategori  = trim((string)$this->request->getQuery('kategori', ''));
        $visitType = trim((string)$this->request->getQuery('visit_type', 'rawat_jalan'));
        $insurance = strtolower(trim((string)$this->request->getQuery('insurance_type', 'umum')));

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

            if ($visitType !== 'igd' && in_array($visitType, ['rawat_jalan', 'rawat_inap'], true)) {
            $conditions['MasterTindakan.applies_' . $visitType] = 1;
            }

            $query = $this->MasterTindakan->find()
                ->select([
                    'id',
                    'kode',
                    'nama',
                    'kategori',
                    'harga_umum',
                    'harga_bpjs',
                    'harga_reimbes',
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

            $priceField = 'harga_umum';
            if (str_contains($insurance, 'bpjs')) {
                $priceField = 'harga_bpjs';
            } elseif (str_contains($insurance, 'reimbes') || str_contains($insurance, 'reimburse')) {
                $priceField = 'harga_reimbes';
            }

            foreach ($results as &$row) {
                $row['harga']      = isset($row[$priceField]) ? (float)$row[$priceField] : 0;
                $row['kode']       = $row['kode']       ?? '';
                $row['satuan']     = 'Kali';    
                $row['kategori']   = $row['kategori']   ?? 'Lainnya';
                $row['keterangan'] = $row['keterangan'] ?? '';
                unset($row['harga_umum'], $row['harga_bpjs'], $row['harga_reimbes']);
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

        foreach (['harga_umum', 'harga_bpjs', 'harga_reimbes'] as $hf) {
            $data[$hf] = isset($data[$hf]) && $data[$hf] !== ''
                ? (float)str_replace(['.', ','], ['', '.'], (string)$data[$hf])
                : 0;
        }
        foreach (['persen_dokter_umum', 'persen_dokter_bpjs', 'persen_dokter_reimbes'] as $pf) {
            $val = isset($data[$pf]) && $data[$pf] !== '' ? (float)$data[$pf] : 0;
            $data[$pf] = max(0, min(100, $val));
        }

        $kategoriConfig = $this->_kategoriConfig();
        $kategori = trim((string)($data['kategori'] ?? ''));
        $cfg = $kategoriConfig[$kategori] ?? ['rj' => 1, 'ri' => 0, 'igd' => 0];

        $data['applies_rawat_jalan'] = (int)$cfg['rj'];
        $data['applies_rawat_inap']  = (int)$cfg['ri'];
        $data['applies_igd']         = (int)$cfg['igd'];

        foreach (['share_type_umum', 'share_type_bpjs', 'share_type_reimbes'] as $sf) {
            $val = $data[$sf] ?? 'rs_dr';
            if (!in_array($val, ['rs_dr', 'rs', 'dr'], true)) {
                $val = 'rs_dr';
            }
            $data[$sf] = $val;
        }

        $data['is_active'] = (int)$data['is_active'];

        // Trim string fields
        foreach (['kode', 'nama', 'kategori', 'keterangan'] as $f) {
            if (isset($data[$f])) {
                $data[$f] = trim((string)$data[$f]);
                if ($data[$f] === '') {
                    $data[$f] = null;
                }
            }
        }

        return $data;
    }

     private function _kategoriConfig(): array
    {
        return [
            'Konsultasi'            => ['prefix' => 'KON', 'rj' => 1, 'ri' => 0, 'igd' => 0],
            'Tindakan Rawat Jalan'  => ['prefix' => 'TRJ', 'rj' => 1, 'ri' => 0, 'igd' => 0],
            'Tindakan Rawat Inap'   => ['prefix' => 'TRI', 'rj' => 0, 'ri' => 1, 'igd' => 0],
            'Laboratorium'          => ['prefix' => 'LAB', 'rj' => 1, 'ri' => 1, 'igd' => 0],
            'Radiologi'             => ['prefix' => 'RAD', 'rj' => 1, 'ri' => 1, 'igd' => 0],
            'Farmasi'               => ['prefix' => 'FAR', 'rj' => 1, 'ri' => 1, 'igd' => 0],
            'Operasi'               => ['prefix' => 'OPR', 'rj' => 0, 'ri' => 1, 'igd' => 0],
            'Administrasi'          => ['prefix' => 'ADM', 'rj' => 1, 'ri' => 1, 'igd' => 0],
            'IGD'                   => ['prefix' => 'IGD', 'rj' => 0, 'ri' => 0, 'igd' => 1],
            'Lainnya'               => ['prefix' => 'LAN', 'rj' => 1, 'ri' => 1, 'igd' => 1],
        ];
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
