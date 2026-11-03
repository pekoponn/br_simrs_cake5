<?php
declare(strict_types=1);

namespace App\Controller\Farmasi;

use App\Controller\AppController;

/**
 * KartuStokController
 *
 * Halaman "Kartu Stock" per obat.
 *
 * CATATAN PENTING:
 * Alur transaksi mutasi stok (terima/keluar/adjust/saldo) belum ada tabelnya,
 * jadi bagian $stockMovements sengaja masih placeholder (array kosong).
 * Begitu tabel/alur mutasi stoknya sudah fix, tinggal ganti method
 * getStockMovements() di bawah ini dengan query ke tabel yang sesuai.
 *
 * Saran struktur tabel mutasi stok nanti (contoh, sesuaikan lagi):
 * stock_movements
 *  - id
 *  - branch_id
 *  - medicine_id      (FK ke medicines.id)
 *  - no_bukti          varchar
 *  - tanggal            date
 *  - keterangan         varchar   (mis: "SALDO AWAL", "R/ ...")
 *  - nama_dokter_distributor varchar
 *  - nilai_pembelian    decimal(15,2)
 *  - adjust             decimal(15,2)
 *  - terima             decimal(15,2)
 *  - keluar             decimal(15,2)
 *  - saldo_akhir        decimal(15,2)
 *  - persediaan_nilai   decimal(15,2)
 *  - persediaan_total_nilai decimal(15,2)
 *  - created
 */
class KartuStokController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Medicines = $this->fetchTable('Medicines');
    }

    /**
     * Halaman utama Kartu Stock.
     * Query string yang dipakai:
     *  - medicine_id
     *  - date_from (Y-m-d)
     *  - date_to   (Y-m-d)
     */
    public function index()
    {
        $medicineId = $this->request->getQuery('medicine_id', '');
        $dateFrom = $this->request->getQuery('date_from', date('Y-m-01'));
        $dateTo = $this->request->getQuery('date_to', date('Y-m-d'));

        $medicine = null;

        if ($medicineId !== '' && is_numeric($medicineId)) {
            $medicine = $this->Medicines->find()
                ->where(['Medicines.id' => (int)$medicineId])
                ->first();
        }

        // TODO: ganti dengan query mutasi stok asli begitu alurnya sudah ada
        $stockMovements = $this->getStockMovements($medicine, $dateFrom, $dateTo);

        $this->set(compact('medicine', 'dateFrom', 'dateTo', 'stockMovements'));
    }

    /**
     * AJAX endpoint untuk modal "Cari Obat" (mirip modal di aplikasi lama).
     * Dipanggil dari JS di templates/KartuStok/index.php
     *
     * - Kalau keyword kosong -> tampilkan semua obat (dibatasi $limit), sesuai
     *   perilaku modal lama yang langsung nampilin seluruh list obat.
     * - Kalau ada keyword -> filter berdasarkan kode/nama/generic/kfa.
     *
     * Return: JSON array of {id, code, name, generic_name, unit_1}
     */
    public function searchMedicine()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $keyword = trim((string)$this->request->getQuery('key', ''));
        $limit = 300; // batas aman biar query & response gak terlalu berat

        $query = $this->Medicines->find()
            ->select(['id', 'code', 'code_kfa', 'name', 'generic_name', 'unit_1'])
            ->order(['Medicines.name' => 'ASC'])
            ->limit($limit);

        if ($keyword !== '') {
            $query->where([
                'OR' => [
                    'Medicines.name LIKE' => '%' . $keyword . '%',
                    'Medicines.code LIKE' => '%' . $keyword . '%',
                    'Medicines.code_kfa LIKE' => '%' . $keyword . '%',
                    'Medicines.generic_name LIKE' => '%' . $keyword . '%',
                ],
            ]);
        }

        $result = [];

        foreach ($query->all() as $m) {
            $result[] = [
                'id' => $m->id,
                'code' => $m->code,
                'name' => $m->name,
                'generic_name' => $m->generic_name,
                'unit_1' => $m->unit_1,
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    /**
     * Placeholder mutasi stok. Sengaja return array kosong dulu
     * sampai alur penambahan/pengurangan stok jelas.
     */
    private function getStockMovements($medicine, string $dateFrom, string $dateTo): array
    {
        if (!$medicine) {
            return [];
        }

        // return [] artinya "belum ada data" -> ditangani di view.
        return [];
    }
}