<?php
declare(strict_types=1);

namespace App\Controller\Farmasi;

use App\Controller\AppController;

/**
 * Stock Logistik dan Umum: daftar stok barang per gudang.
 * Terima / Keluar diisi oleh modul lain (penerimaan, pemakaian logistik);
 * halaman ini mengelola Hasil SO, Adjustment, Min/Max, dan validasi.
 */
class LogisticStocksController extends AppController
{
    public function index()
    {
    }

    // JSON: daftar gudang (Cari Gudang)
    public function warehouses()
    {
        $this->request->allowMethod(['get']);
        $q = trim((string)$this->request->getQuery('q'));

        $query = $this->fetchTable('LogisticWarehouses')->find()
            ->select(['code', 'name'])
            ->where(['is_active' => 'Y'])
            ->orderBy(['code' => 'ASC'])
            ->limit(300);

        if ($q !== '') {
            $query->where(['OR' => ['code LIKE' => "%$q%", 'name LIKE' => "%$q%"]]);
        }

        return $this->jsonOut($query->disableHydration()->all()->toList());
    }

    // JSON: stok barang di satu gudang (Cari Barang)
    public function stocks()
    {
        $this->request->allowMethod(['get']);
        $wh = trim((string)$this->request->getQuery('warehouse_code'));
        $q = trim((string)$this->request->getQuery('q'));
        if ($wh === '') {
            return $this->jsonOut([]);
        }

        $query = $this->LogisticStocks->find()
            ->where(['warehouse_code' => $wh])
            ->orderBy(['item_code' => 'ASC'])
            ->limit(1000);

        if ($q !== '') {
            $query->where(['OR' => ['item_code LIKE' => "%$q%", 'item_name LIKE' => "%$q%"]]);
        }

        return $this->jsonOut($query->disableHydration()->all()->toList());
    }

    // POST: tambah / ubah stok (upsert per gudang + barang)
    public function save()
    {
        $this->request->allowMethod(['post']);
        $d = $this->request->getData();

        $wh = trim((string)($d['warehouse_code'] ?? ''));
        $code = trim((string)($d['item_code'] ?? ''));
        $name = trim((string)($d['item_name'] ?? ''));
        if ($wh === '' || $code === '' || $name === '') {
            return $this->jsonOut(['ok' => false, 'message' => 'Gudang dan barang wajib diisi.'], 422);
        }

        $soQty = (float)($d['so_qty'] ?? 0);
        $adj = (float)($d['adjustment'] ?? 0);
        $min = (float)($d['min_stock'] ?? 0);
        $max = (float)($d['max_stock'] ?? 0);
        if ($min < 0 || $max < 0 || ($max > 0 && $min > $max)) {
            return $this->jsonOut(['ok' => false, 'message' => 'Min stok / Max stok tidak valid.'], 422);
        }

        $row = $this->LogisticStocks->find()
            ->where(['warehouse_code' => $wh, 'item_code' => $code])
            ->first();
        $row ??= $this->LogisticStocks->newEmptyEntity();

        $received = $row->isNew() ? 0.0 : (float)$row->received;
        $issued = $row->isNew() ? 0.0 : (float)$row->issued;

        $row = $this->LogisticStocks->patchEntity($row, [
            'warehouse_code' => $wh,
            'item_id' => ($d['item_id'] ?? '') !== '' ? (int)$d['item_id'] : null,
            'item_code' => $code,
            'item_name' => $name,
            'unit' => $d['unit'] ?? null,
            'so_qty' => $soQty,
            'adjustment' => $adj,
            'received' => $received,
            'issued' => $issued,
            'balance' => $soQty + $adj + $received - $issued,
            'min_stock' => $min,
            'max_stock' => $max,
            'is_valid' => 0, // perubahan membuat stok perlu divalidasi ulang
        ]);

        if (!$this->LogisticStocks->save($row)) {
            return $this->jsonOut(['ok' => false, 'message' => 'Gagal menyimpan stok.'], 500);
        }
        return $this->jsonOut(['ok' => true]);
    }

    // POST: validasi stok satu gudang (tandai VALID + Tgl SO terakhir = hari ini)
    public function validateStock()
    {
        $this->request->allowMethod(['post']);
        $wh = trim((string)$this->request->getData('warehouse_code'));
        if ($wh === '') {
            return $this->jsonOut(['ok' => false, 'message' => 'Pilih gudang dulu.'], 422);
        }

        $n = $this->LogisticStocks->updateAll(
            ['is_valid' => 1, 'last_so_date' => date('Y-m-d')],
            ['warehouse_code' => $wh]
        );
        return $this->jsonOut(['ok' => true, 'count' => $n]);
    }

    // JSON: autocomplete master barang logistik
    public function searchItems()
    {
        $this->request->allowMethod(['get']);
        $q = trim((string)$this->request->getQuery('q'));
        $rows = [];
        if (mb_strlen($q) >= 2) {
            $rows = $this->fetchTable('LogisticItems')->find() // TODO: sesuaikan bila master barang Anda berbeda
                ->select(['id', 'code', 'name', 'unit'])
                ->where(['OR' => ['name LIKE' => "%$q%", 'code LIKE' => "%$q%"]])
                ->limit(20)->disableHydration()->all()->toList();
        }
        return $this->jsonOut($rows);
    }

    private function jsonOut($data, int $status = 200)
    {
        return $this->response
            ->withStatus($status)
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }
}