<?php
declare(strict_types=1);

namespace App\Controller\Farmasi;

use App\Controller\AppController;

/**
 * Permohonan Permintaan Barang (depo/bagian meminta barang ke bagian lain).
 * Tabel: item_requests (header), item_request_items (detail).
 */
class ItemRequestsController extends AppController
{
    public function index()
    {
        $from = (string)$this->request->getQuery('date_from', date('Y-m-01'));
        $to = (string)$this->request->getQuery('date_to', date('Y-m-d'));
        $q = trim((string)$this->request->getQuery('q'));

        $query = $this->ItemRequests->find()
            ->where(['is_active' => 'Y', 'request_date >=' => $from, 'request_date <=' => $to])
            ->orderBy(['request_date' => 'DESC', 'id' => 'DESC']);

        if ($q !== '') {
            $query->where(['OR' => [
                'request_no LIKE' => "%$q%",
                'from_depo LIKE' => "%$q%",
                'to_depo LIKE' => "%$q%",
            ]]);
        }

        $requests = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('requests', 'from', 'to', 'q'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $d = $this->request->getData();

            $items = [];
            foreach ((array)($d['items'] ?? []) as $r) {
                $name = trim((string)($r['item_name'] ?? ''));
                $qty = (float)($r['qty'] ?? 0);
                if ($name === '' || $qty <= 0) {
                    continue;
                }
                $items[] = [
                    'item_id' => $r['item_id'] ?: null,
                    'item_code' => $r['item_code'] ?? null,
                    'item_name' => $name,
                    'qty' => $qty,
                    'unit' => $r['unit'] ?? null,
                    'notes' => $r['notes'] ?? null,
                ];
            }

            $fromDepo = trim((string)($d['from_depo'] ?? ''));
            $toDepo = trim((string)($d['to_depo'] ?? ''));

            if ($fromDepo === '' || $toDepo === '') {
                $this->Flash->error('Pilih "Dari Bagian" dan "Ke bagian".');
                return $this->redirect(['action' => 'add']);
            }
            if ($fromDepo === $toDepo) {
                $this->Flash->error('"Dari Bagian" dan "Ke bagian" tidak boleh sama.');
                return $this->redirect(['action' => 'add']);
            }
            if (!$items) {
                $this->Flash->error('Isi minimal satu barang dengan qty lebih dari 0.');
                return $this->redirect(['action' => 'add']);
            }

            $request = $this->ItemRequests->newEntity([
                'request_no' => $this->nextRequestNo(),
                'request_date' => $d['request_date'] ?: date('Y-m-d'),
                'from_depo' => $fromDepo,
                'to_depo' => $toDepo,
                'notes' => $d['notes'] ?? null,
                'status' => 'diajukan',
                'item_request_items' => $items,
            ], ['associated' => ['ItemRequestItems']]);

            if ($this->ItemRequests->save($request)) {
                $this->Flash->success('Permohonan tersimpan: ' . $request->request_no);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Gagal menyimpan.');
        }

        $nextNo = $this->nextRequestNo();
        // TODO: idealnya diambil dari master depo / bagian
        $depos = ['ATEM DEPO', 'DEPO FARMASI', 'GUDANG UMUM', 'GUDANG FARMASI', 'LABORATORIUM'];
        $this->set(compact('nextNo', 'depos'));
    }

    public function view($id = null)
    {
        $request = $this->ItemRequests->get((int)$id, contain: ['ItemRequestItems']);
        $this->set(compact('request'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post']);
        $r = $this->ItemRequests->get((int)$id);
        $r->is_active = 'N';
        $r->is_delete = 1;
        $this->ItemRequests->save($r);
        $this->Flash->success('Data dihapus.');
        return $this->redirect(['action' => 'index']);
    }

    // Autocomplete barang (master barang farmasi)
    public function searchItems()
    {
        $this->request->allowMethod(['get']);
        $q = trim((string)$this->request->getQuery('q'));
        $rows = [];
        if (mb_strlen($q) >= 2) {
            $rows = $this->fetchTable('PharmacyItems')->find()
                ->select(['id', 'code', 'name', 'unit'])
                ->where(['OR' => ['name LIKE' => "%$q%", 'code LIKE' => "%$q%"]])
                ->limit(20)->disableHydration()->all()->toList();
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($rows));
    }

    /** Nomor berikutnya: MHN2026-00000001 */
    private function nextRequestNo(): string
    {
        $last = (int)($this->ItemRequests->find()
            ->select(['id'])
            ->orderBy(['id' => 'DESC'])
            ->first()?->id ?? 0);

        return 'MHN' . date('Y') . '-' . str_pad((string)($last + 1), 8, '0', STR_PAD_LEFT);
    }
}