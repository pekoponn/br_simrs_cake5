<?php
declare(strict_types=1);

namespace App\Controller\Penunjang;

use App\Controller\AppController;
use Cake\I18n\DateTime;

/**
 * Informasi Stock (persediaan laboratorium).
 *
 * Key hak akses (users/access): labstocks -> index, warehouses, stock, validateDepot
 */
class LabStocksController extends AppController
{
    private const PER_PAGE = 100;

    public function index()
    {
    }

    /** AJAX: daftar gudang (Cari Gudang). */
    public function warehouses()
    {
        $this->request->allowMethod(['get']);

        $q = trim((string)$this->request->getQuery('q'));
        $query = $this->fetchTable('StockWarehouses')->find()
            ->where(['is_active' => 1])
            ->orderBy(['code' => 'ASC'])
            ->limit(200);

        if ($q !== '') {
            $like = '%' . $q . '%';
            $query->where(['OR' => ['code LIKE' => $like, 'name LIKE' => $like]]);
        }

        $rows = [];
        foreach ($query->all() as $w) {
            $rows[] = [
                'id' => (int)$w->id,
                'code' => (string)$w->code,
                'name' => (string)$w->name,
                'validated_at' => $w->validated_at ? $w->validated_at->format('d-m-Y H:i') : '',
                'validated_by' => (string)$w->validated_by,
            ];
        }

        return $this->respondJson(['ok' => true, 'rows' => $rows]);
    }

    /** AJAX: daftar stok satu gudang. mode: '' | 'min' | 'minus' */
    public function stock()
    {
        $this->request->allowMethod(['get']);

        $wid = (int)$this->request->getQuery('warehouse_id');
        if ($wid <= 0) {
            return $this->respondJson(['ok' => false, 'message' => 'Pilih gudang terlebih dahulu.']);
        }

        $q = trim((string)$this->request->getQuery('q'));
        $nonzero = (string)$this->request->getQuery('nonzero') === '1';
        $mode = (string)$this->request->getQuery('mode');
        $order = (string)$this->request->getQuery('order');
        $page = max(1, (int)$this->request->getQuery('page'));

        $query = $this->fetchTable('StockSummaries')->find()->where(['warehouse_id' => $wid]);

        if ($q !== '') {
            $like = '%' . $q . '%';
            $query->where(['OR' => ['item_code LIKE' => $like, 'item_name LIKE' => $like]]);
        }
        if ($nonzero) {
            $query->where(['closing_qty >' => 0]);
        }
        if ($mode === 'minus') {
            $query->where(['closing_qty <' => 0]);
        } elseif ($mode === 'min') {
            $query->where(fn($exp) => $exp->gt('min_stock', 0)->lteFields('closing_qty', 'min_stock'));
        }

        $total = $query->count();

        $orderCol = ['code' => 'item_code', 'name' => 'item_name', 'balance' => 'closing_qty'][$order] ?? 'item_code';
        $rows = $query
            ->orderBy([$orderCol => 'ASC', 'item_code' => 'ASC'])
            ->limit(self::PER_PAGE)
            ->offset(($page - 1) * self::PER_PAGE)
            ->disableHydration()
            ->all();

        $out = [];
        foreach ($rows as $r) {
            $out[] = [
                'code' => (string)$r['item_code'],
                'name' => (string)$r['item_name'],
                'unit' => (string)$r['unit'],
                'so_date' => $r['last_so_date'] ? $r['last_so_date']->format('d-m-Y') : '',
                'so' => (float)$r['so_qty'],
                'adj' => (float)$r['adjustment_qty'],
                'in' => (float)$r['received_qty'],
                'out' => (float)$r['issued_qty'],
                'balance' => (float)$r['closing_qty'],
                'min' => (float)$r['min_stock'],
                'max' => (float)$r['max_stock'],
            ];
        }

        return $this->respondJson([
            'ok' => true,
            'rows' => $out,
            'total' => $total,
            'page' => $page,
            'per_page' => self::PER_PAGE,
        ]);
    }

    /**
     * AJAX POST: Validasi Depo Ini — memeriksa gudang lalu menandai waktu validasi.
     */
    public function validateDepot()
    {
        $this->request->allowMethod(['post']);

        $wid = (int)$this->request->getData('warehouse_id');
        $warehouses = $this->fetchTable('StockWarehouses');
        $warehouse = $warehouses->find()->where(['id' => $wid])->first();
        if ($warehouse === null) {
            return $this->respondJson(['ok' => false, 'message' => 'Gudang tidak ditemukan.']);
        }

        $summary = $this->fetchTable('StockSummaries');
        $base = fn() => $summary->find()->where(['warehouse_id' => $wid]);

        $total = $base()->count();
        $minus = $base()->where(['closing_qty <' => 0])->count();
        $belowMin = $base()->where(fn($exp) => $exp->gt('min_stock', 0)->lteFields('closing_qty', 'min_stock'))->count();

        $warehouse->validated_at = DateTime::now();
        $warehouse->validated_by = $this->currentUserName();
        $warehouses->save($warehouse);

        return $this->respondJson([
            'ok' => true,
            'total' => $total,
            'minus' => $minus,
            'below_min' => $belowMin,
            'validated_at' => $warehouse->validated_at->format('d-m-Y H:i'),
        ]);
    }

    /** Nama user login. SESUAIKAN dengan cara aplikasi Anda menyimpan user. */
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