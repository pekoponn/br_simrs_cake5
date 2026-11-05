<?php
declare(strict_types=1);

namespace App\Controller\Penunjang;

use App\Controller\AppController;

/**
 * Permohonan Logistik (Permohonan Pengambilan Barang).
 *
 * Key hak akses (users/access): labrequisitions -> index, add, view, delete, searchItems
 */
class LabRequisitionsController extends AppController
{
    public function index()
    {
        $from = (string)$this->request->getQuery('date_from', date('Y-m-01'));
        $to = (string)$this->request->getQuery('date_to', date('Y-m-d'));

        $query = $this->LabRequisitions->find()
            ->where(['is_active' => 'Y', 'request_date >=' => $from, 'request_date <=' => $to])
            ->orderBy(['request_date' => 'DESC', 'id' => 'DESC']);

        $requisitions = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('requisitions', 'from', 'to'));
    }

    public function add()
    {
        $old = [];
        $oldItems = [];

        if ($this->request->is('post')) {
            $d = $this->request->getData();
            $old = $d;
            $oldItems = array_values((array)($d['items'] ?? []));

            $items = [];
            foreach ($oldItems as $r) {
                $name = trim((string)($r['item_name'] ?? ''));
                $qty = (float)($r['qty'] ?? 0);
                if ($name === '' || $qty <= 0) {
                    continue;
                }
                $items[] = [
                    'item_id' => !empty($r['item_id']) ? (int)$r['item_id'] : null,
                    'item_code' => $r['item_code'] ?? null,
                    'item_name' => $name,
                    'qty' => $qty,
                    'unit' => $r['unit'] ?? null,
                    'notes' => $r['notes'] ?? null,
                ];
            }

            $fromDept = trim((string)($d['from_dept'] ?? ''));
            $toDept = trim((string)($d['to_dept'] ?? ''));

            if ($fromDept === '' || $toDept === '') {
                $this->Flash->error('Pilih "Dari Bagian [Depo]" dan "Ke bagian".');
            } elseif (!$items) {
                $this->Flash->error('Isi minimal satu barang dengan qty lebih dari 0.');
            } else {
                $requisition = $this->LabRequisitions->newEntity([
                    'request_no' => $this->nextRequestNo(),
                    'request_date' => ($d['request_date'] ?? '') ?: date('Y-m-d'),
                    'from_dept' => $fromDept,
                    'to_dept' => $toDept,
                    'notes' => trim((string)($d['notes'] ?? '')),
                    'status' => 'diajukan',
                    'item_count' => count($items),
                    'lab_requisition_items' => $items,
                ], ['associated' => ['LabRequisitionItems']]);

                if ($this->LabRequisitions->save($requisition)) {
                    $this->Flash->success('Permohonan tersimpan: ' . $requisition->request_no);

                    return $this->redirect(['action' => 'add']);
                }
                $this->Flash->error('Gagal menyimpan permohonan.');
            }
        }

        $this->set([
            'nextNo' => $this->nextRequestNo(),
            'depotList' => $this->depotList(),
            'destList' => $this->destList(),
            'old' => $old,
            'oldItems' => $oldItems,
        ]);
    }

    public function view($id = null)
    {
        $requisition = $this->LabRequisitions->get((int)$id, contain: ['LabRequisitionItems']);
        $this->set(compact('requisition'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post']);

        $r = $this->LabRequisitions->get((int)$id);
        $r->is_active = 'N';
        $this->LabRequisitions->save($r);
        $this->Flash->success('Permohonan dihapus.');

        return $this->redirect(['action' => 'index']);
    }

    /**
     * AJAX: cari barang. SESUAIKAN tabel/kolom jika master barang Anda berbeda.
     * Asumsi: tabel PharmacyItems dengan kolom id, code, name, unit.
     */
    public function searchItems()
    {
        $this->request->allowMethod(['get']);

        $q = trim((string)$this->request->getQuery('q'));
        $rows = [];

        try {
            if (mb_strlen($q) >= 2) {
                $rows = $this->fetchTable('PharmacyItems')->find()
                    ->select(['id', 'code', 'name', 'unit'])
                    ->where(['OR' => ['name LIKE' => '%' . $q . '%', 'code LIKE' => '%' . $q . '%']])
                    ->orderBy(['name' => 'ASC'])
                    ->limit(20)
                    ->disableHydration()
                    ->all()
                    ->toList();
            }
        } catch (\Throwable $e) {
            return $this->respondJson(['error' => $e->getMessage()], 500);
        }

        return $this->respondJson($rows);
    }

    private function nextRequestNo(): string
    {
        $row = $this->LabRequisitions->find()
            ->select(['max_id' => 'MAX(id)'])
            ->disableHydration()
            ->first();
        $next = ((int)($row['max_id'] ?? 0)) + 1;

        return 'MHN' . date('Y') . '-' . str_pad((string)$next, 8, '0', STR_PAD_LEFT);
    }

    /** Depo sumber barang. Ganti dengan data master bila sudah ada. */
    private function depotList(): array
    {
        return ['FARMASI', 'GUDANG UMUM', 'GUDANG LOGISTIK'];
    }

    /** Bagian peminta. Ganti dengan data master bila sudah ada. */
    private function destList(): array
    {
        return ['LABORATORIUM', 'INSTALASI GAWAT DARURAT', 'RAWAT INAP', 'RAWAT JALAN'];
    }

    private function respondJson($data, int $status = 200)
    {
        return $this->response
            ->withStatus($status)
            ->withType('application/json')
            ->withStringBody((string)json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE));
    }
}