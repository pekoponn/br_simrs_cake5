<?php
declare(strict_types=1);

namespace App\Controller\Farmasi;

use App\Controller\AppController;

use Cake\Database\Expression\IdentifierExpression;

/**
 * InformasiStockController
 *
 * Halaman "Informasi Stock" -- daftar SEMUA obat dari master (`medicines`)
 * di-LEFT JOIN dengan `medicine_stocks`. Karena pakai LEFT JOIN, begitu ada
 * obat baru ditambahkan lewat MedicinesController::add(), obat itu otomatis
 * muncul di sini dengan saldo/nilai default 0 -- tanpa perlu proses insert
 * manual ke medicine_stocks.
 *
 * SYARAT ASOSIASI (tambahkan ini di src/Model/Table/MedicinesTable.php,
 * di dalam method initialize(), kalau belum ada):
 *
 *   $this->hasOne('MedicineStocks', [
 *       'foreignKey' => 'medicine_id',
 *   ]);
 *
 * hasOne di CakePHP defaultnya pakai strategy 'join' (LEFT JOIN), jadi
 * baris obat yang belum punya data stock tetap ikut tampil.
 */
class MedicineStocksController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Medicines = $this->fetchTable('Medicines');
        $this->MedicineStocks = $this->fetchTable('MedicineStocks');
    }

    public function index()
    {
        $keyword = trim((string)$this->request->getQuery('key', ''));
        $onlyPositive = $this->request->getQuery('only_positive', '') === '1';
        $preset = $this->request->getQuery('preset', ''); // '', 'min_stock', 'minus'
        $sortBy = $this->request->getQuery('sort', 'code'); // code | name | saldo_akhir

        $query = $this->Medicines->find()
            ->contain(['MedicineStocks']);

        if ($keyword !== '') {
            $query->where([
                'OR' => [
                    'Medicines.name LIKE' => '%' . $keyword . '%',
                    'Medicines.code LIKE' => '%' . $keyword . '%',
                    'Medicines.generic_name LIKE' => '%' . $keyword . '%',
                ],
            ]);
        }

        if ($onlyPositive) {
            $query->where(['MedicineStocks.saldo_akhir >' => 0]);
        }

        if ($preset === 'min_stock') {
            // saldo akhir <= minimum_stock (dari master obat)
            $query->where(function ($exp) {
                return $exp->lte('MedicineStocks.saldo_akhir', new IdentifierExpression('Medicines.minimum_stock'));
            });
        } elseif ($preset === 'minus') {
            $query->where(['MedicineStocks.saldo_akhir <' => 0]);
        }

        switch ($sortBy) {
            case 'name':
                $query->order(['Medicines.name' => 'ASC']);
                break;
            case 'saldo_akhir':
                $query->order(['MedicineStocks.saldo_akhir' => 'DESC']);
                break;
            case 'code':
            default:
                $query->order(['Medicines.code' => 'ASC']);
                break;
        }

        $this->paginate = ['limit' => 25];
        $medicines = $this->paginate($query);

        $this->set(compact('medicines', 'keyword', 'onlyPositive', 'preset', 'sortBy'));
    }

    /**
     * Toggle status Valid / Non-Valid untuk 1 obat (dipanggil via AJAX
     * dari tombol "VALID" di kolom tabel). Kalau baris medicine_stocks
     * untuk obat itu belum ada, otomatis dibuat dulu (default lainnya 0).
     */
    public function toggleValid()
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $medicineId = (int)$this->request->getData('medicine_id');
        $branchId = 1; // TODO: ganti kalau nanti sudah multi-branch/gudang

        if ($medicineId <= 0) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'medicine_id tidak valid']));
        }

        $stock = $this->MedicineStocks->findOrNewForMedicine($medicineId, $branchId);
        $stock->is_valid = ($stock->is_valid === 'Y') ? 'N' : 'Y';

        $saved = $this->MedicineStocks->save($stock);

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'success' => (bool)$saved,
                'is_valid' => $saved ? $stock->is_valid : null,
            ]));
    }
}