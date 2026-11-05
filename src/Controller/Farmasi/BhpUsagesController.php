<?php
declare(strict_types=1);

namespace App\Controller\Farmasi;

use App\Controller\AppController;

class BhpUsagesController extends AppController
{
    public function index()
    {
        $from = (string)$this->request->getQuery('date_from', date('Y-m-01'));
        $to = (string)$this->request->getQuery('date_to', date('Y-m-d'));
        $q = trim((string)$this->request->getQuery('q'));

        $query = $this->BhpUsages->find()
            ->where(['is_active' => 'Y', 'usage_date >=' => $from, 'usage_date <=' => $to])
            ->orderBy(['usage_date' => 'DESC', 'id' => 'DESC']);

        if ($q !== '') {
            $query->where(['OR' => [
                'usage_no LIKE' => "%$q%",
                'patient_name LIKE' => "%$q%",
                'medical_record_no LIKE' => "%$q%",
            ]]);
        }

        $usages = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('usages', 'from', 'to', 'q'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $d = $this->request->getData();
            $rows = (array)($d['items'] ?? []);

            // Hitung ulang di server, angka dari browser tidak dipercaya
            $items = [];
            $subtotal = $discTotal = $taxTotal = 0.0;
            foreach ($rows as $r) {
                $name = trim((string)($r['item_name'] ?? ''));
                $qty = (float)($r['qty'] ?? 0);
                if ($name === '' || $qty <= 0) {
                    continue;
                }
                $price = (float)($r['price'] ?? 0);
                $discPct = (float)($r['disc_percent'] ?? 0);
                $ppnPct = (float)($r['ppn_percent'] ?? 0);

                $gross = $qty * $price;
                $discAmt = $gross * $discPct / 100;
                $ppnAmt = ($gross - $discAmt) * $ppnPct / 100;

                $subtotal += $gross;
                $discTotal += $discAmt;
                $taxTotal += $ppnAmt;

                $items[] = [
                    'item_id' => $r['item_id'] ?: null,
                    'item_code' => $r['item_code'] ?? null,
                    'item_name' => $name,
                    'qty' => $qty,
                    'unit' => $r['unit'] ?? null,
                    'price' => $price,
                    'disc_percent' => $discPct,
                    'ppn_percent' => $ppnPct,
                    'ppn_amount' => $ppnAmt,
                    'total' => $gross - $discAmt + $ppnAmt,
                    'expired_date' => !empty($r['expired_date']) ? $r['expired_date'] : null,
                    'usage_rule' => $r['usage_rule'] ?? null,
                    'shelf_no' => $r['shelf_no'] ?? null,
                ];
            }

            if (!$items) {
                $this->Flash->error('Isi minimal satu barang.');
                return $this->redirect(['action' => 'add']);
            }

            $buyer = ($d['buyer_type'] ?? 'pasien') === 'unit' ? 'unit' : 'pasien';
            $isPatient = $buyer === 'pasien';

            $usage = $this->BhpUsages->newEntity([
                'usage_no' => $this->nextUsageNo(),
                'usage_date' => $d['usage_date'] ?: date('Y-m-d'),
                'usage_time' => $d['usage_time'] ?: date('H:i:s'),
                'depo' => $d['depo'] ?? null,
                'queue_no' => (int)($d['queue_no'] ?? 0),
                'buyer_type' => $buyer,
                'unit_name' => $isPatient ? null : ($d['unit_name'] ?? null),
                'registration_id' => $isPatient ? ($d['registration_id'] ?: null) : null,
                'registration_no' => $isPatient ? ($d['registration_no'] ?? null) : null,
                'medical_record_no' => $isPatient ? ($d['medical_record_no'] ?? null) : null,
                'patient_name' => $isPatient ? ($d['patient_name'] ?? null) : null,
                'origin' => $d['origin'] ?? null,
                'class_name' => $d['class_name'] ?? null,
                'doctor_name' => $d['doctor_name'] ?? null,
                'phone' => $d['phone'] ?? null,
                'subtotal' => $subtotal,
                'discount_total' => $discTotal,
                'tax_total' => $taxTotal,
                'grand_total' => $subtotal - $discTotal + $taxTotal,
                'bhp_usage_items' => $items,
            ], ['associated' => ['BhpUsageItems']]);

            if ($this->BhpUsages->save($usage)) {
                $this->Flash->success('Pemakaian BHP tersimpan: ' . $usage->usage_no);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Gagal menyimpan.');
        }

        $nextNo = $this->nextUsageNo();
        // TODO: idealnya diambil dari master depo / unit
        $depos = ['ATEM DEPO', 'DEPO FARMASI', 'GUDANG UMUM'];
        $units = ['LABORATORIUM', 'INSTALASI GAWAT DARURAT', 'RAWAT INAP', 'RAWAT JALAN'];
        $this->set(compact('nextNo', 'depos', 'units'));
    }

    public function view($id = null)
    {
        $usage = $this->BhpUsages->get((int)$id, contain: ['BhpUsageItems']);
        $this->set(compact('usage'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post']);
        $u = $this->BhpUsages->get((int)$id);
        $u->is_active = 'N';
        $u->is_delete = 1;
        $this->BhpUsages->save($u);
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
                ->select(['id', 'code', 'name', 'unit', 'price'])
                ->where(['OR' => ['name LIKE' => "%$q%", 'code LIKE' => "%$q%"]])
                ->limit(20)->disableHydration()->all()->toList();
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($rows));
    }

    // Autocomplete registrasi pasien
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
                    'doctor_name' => 'd.doctor_name',
                ])
                ->join([
                    'p' => ['table' => 'patients', 'type' => 'LEFT', 'conditions' => 'p.id = Registrations.patient_id'],
                    'd' => ['table' => 'doctors', 'type' => 'LEFT', 'conditions' => 'd.id = Registrations.doctor_id'],
                ])
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

    /** Nomor transaksi berikutnya: BHP2026-00000001 */
    private function nextUsageNo(): string
    {
        $last = (int)($this->BhpUsages->find()
            ->select(['id'])
            ->orderBy(['id' => 'DESC'])
            ->first()?->id ?? 0);

        return 'BHP' . date('Y') . '-' . str_pad((string)($last + 1), 8, '0', STR_PAD_LEFT);
    }
}