<?php
declare(strict_types=1);

namespace App\Controller\Penunjang;

use App\Controller\AppController;

class LabUsagesController extends AppController
{
    public function index()
    {
        $from = (string)$this->request->getQuery('date_from', date('Y-m-01'));
        $to = (string)$this->request->getQuery('date_to', date('Y-m-d'));

        $query = $this->LabUsages->find()
            ->where(['is_active' => 'Y', 'usage_date >=' => $from, 'usage_date <=' => $to])
            ->orderBy(['usage_date' => 'DESC', 'id' => 'DESC']);

        $usages = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('usages', 'from', 'to'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $d = $this->request->getData();
            $rows = (array)($d['items'] ?? []);

            $items = [];
            $grand = 0.0;
            foreach ($rows as $r) {
                $name = trim((string)($r['item_name'] ?? ''));
                if ($name === '') {
                    continue;
                }
                $qty = (float)($r['qty'] ?? 0);
                $price = (float)($r['price'] ?? 0);
                $total = $qty * $price;
                $grand += $total;
                $items[] = [
                    'item_id' => $r['item_id'] ?: null,
                    'item_code' => $r['item_code'] ?? null,
                    'item_name' => $name,
                    'qty' => $qty,
                    'unit' => $r['unit'] ?? null,
                    'price' => $price,
                    'total' => $total,
                ];
            }

            if (!$items) {
                $this->Flash->error('Isi minimal satu barang.');
                return $this->redirect(['action' => 'add']);
            }

            $charge = !empty($d['charge_to_patient']);

            $usage = $this->LabUsages->newEntity([
                'usage_no' => $this->nextUsageNo(),
                'usage_date' => $d['usage_date'] ?: date('Y-m-d'),
                'warehouse' => $d['warehouse'] ?? null,
                'cost_centre' => $d['cost_centre'] ?? null,
                'notes' => $d['notes'] ?? null,
                'charge_to_patient' => $charge ? 1 : 0,
                'registration_no' => $charge ? ($d['registration_no'] ?? null) : null,
                'medical_record_no' => $charge ? ($d['medical_record_no'] ?? null) : null,
                'patient_name' => $charge ? ($d['patient_name'] ?? null) : null,
                'origin' => $charge ? ($d['origin'] ?? null) : null,
                'grand_total' => $grand,
                'lab_usage_items' => $items,
            ], ['associated' => ['LabUsageItems']]);

            if ($this->LabUsages->save($usage)) {
                $this->Flash->success('Pemakaian logistik tersimpan: ' . $usage->usage_no);
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error('Gagal menyimpan.');
        }

        $nextNo = $this->nextUsageNo();
        $warehouses = ['LABORATORIUM', 'FARMASI', 'GUDANG UMUM'];
        $costCentres = ['LABORATORIUM', 'INSTALASI GAWAT DARURAT', 'RAWAT INAP', 'RAWAT JALAN'];
        $this->set(compact('nextNo', 'warehouses', 'costCentres'));
    }

        private function nextUsageNo(): string
    {
        $row = $this->LabUsages->find()
            ->select(['max_id' => 'MAX(id)'])
            ->disableHydration()
            ->first();
        $next = ((int)($row['max_id'] ?? 0)) + 1;

        return 'LGK' . date('Y') . '-' . str_pad((string)$next, 8, '0', STR_PAD_LEFT);
    }

    public function view($id = null)
    {
        $usage = $this->LabUsages->get((int)$id, contain: ['LabUsageItems']);
        $this->set(compact('usage'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post']);
        $u = $this->LabUsages->get((int)$id);
        $u->is_active = 'N';
        $u->is_delete = 1;
        $this->LabUsages->save($u);
        $this->Flash->success('Data dihapus.');
        return $this->redirect(['action' => 'index']);
    }

    // Cari barang untuk autocomplete
    public function searchItems()
    {
        $this->request->allowMethod(['get']);
        $q = trim((string)$this->request->getQuery('q'));
        $rows = [];
        if (mb_strlen($q) >= 2) {
            $rows = $this->fetchTable('PharmacyItems')->find()
                ->select(['id', 'code', 'name', 'unit', 'price'])
                ->where(['OR' => ['name LIKE' => "%$q%", 'code LIKE' => "%$q%"]])
                ->limit(20)->disableHydration()->all()->toList();
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($rows));
    }

    // Cari registrasi pasien (untuk dibebankan ke pasien)
    public function searchRegistration()
    {
        $this->request->allowMethod(['get']);
        $q = trim((string)$this->request->getQuery('q'));
        $rows = [];
        if (mb_strlen($q) >= 2) {
            $rows = $this->fetchTable('Registrations')->find()
                ->select([
                    'id' => 'Registrations.id',
                    'registration_no' => 'Registrations.registration_no',
                    'service_type' => 'Registrations.service_type',
                    'rm' => 'p.code',
                    'patient_name' => 'p.full_name',
                ])
                ->join(['p' => ['table' => 'patients', 'type' => 'LEFT', 'conditions' => 'p.id = Registrations.patient_id']])
                ->where(['OR' => [
                    'Registrations.registration_no LIKE' => "%$q%",
                    'p.full_name LIKE' => "%$q%",
                    'p.code LIKE' => "%$q%",
                ]])
                ->orderBy(['Registrations.id' => 'DESC'])
                ->limit(15)->disableHydration()->all()->toList();
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($rows));
    }
}