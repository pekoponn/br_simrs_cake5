<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class OutpatientBillingsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('OutpatientBillings');
        $this->loadModel('OutpatientBillingItems');
        $this->loadModel('OutpatientBillingPayments');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // INDEX — Daftar tagihan rawat jalan (Antrian Kasir)
    // ─────────────────────────────────────────────────────────────────────────
    public function index()
    {
        $dateFrom = $this->request->getQuery('date_from');
        $dateTo   = $this->request->getQuery('date_to');
        $status   = $this->request->getQuery('status');
        $q        = $this->request->getQuery('q');
    
        if (empty($dateFrom)) {
            $dateFrom = date('Y-m-d');
        }
    
        if (empty($dateTo)) {
            $dateTo = date('Y-m-d');
        }
    
        $conditions = [];

        if (!empty($dateFrom)) {
            $conditions[] = [
                'DATE(OutpatientBillings.created) >=' => $dateFrom
            ];
        }
        
        if (!empty($dateTo)) {
            $conditions[] = [
                'DATE(OutpatientBillings.created) <=' => $dateTo
            ];
        }
    
        if (!empty($status)) {
            $conditions['OutpatientBillings.status'] = $status;
        }
    
        if (!empty($q)) {
            $conditions['OR'] = [
                'OutpatientBillings.billing_no LIKE' => '%' . $q . '%',
                'Registrations.registration_no LIKE' => '%' . $q . '%',
                'Registrations.registration_number LIKE' => '%' . $q . '%',
                'Patients.code LIKE' => '%' . $q . '%',
                'Patients.full_name LIKE' => '%' . $q . '%',
            ];
        }
    
        $query = $this->OutpatientBillings->find()
            ->contain(['Patients', 'Doctors', 'Registrations'])
            ->where($conditions)
            ->order(['OutpatientBillings.id' => 'DESC']);
    
        $billings = $this->paginate($query);
    
        $base = $this->OutpatientBillings->find();

        if (!empty($dateFrom)) {
            $base->where([
                'DATE(OutpatientBillings.created) >=' => $dateFrom
            ]);
        }
        
        if (!empty($dateTo)) {
            $base->where([
                'DATE(OutpatientBillings.created) <=' => $dateTo
            ]);
        }
        $summary = [
            'total' => (clone $base)->count(),
            'waiting' => (clone $base)->where(['status' => 'waiting_payment'])->count(),
            'paid' => (clone $base)->where(['status' => 'paid'])->count(),
            'revenue' => (float)(clone $base)->where(['status' => 'paid'])->sumOf('grand_total'),
        ];
    
        $this->set(compact(
            'billings',
            'summary',
            'dateFrom',
            'dateTo',
            'status',
            'q'
        ));
    }

    public function kasir($id = null)
{
    if (empty($id)) {
        $billing = $this->OutpatientBillings->find()
            ->where([
                'OR' => [
                    ['OutpatientBillings.is_delete' => 0],
                    ['OutpatientBillings.is_delete IS' => null],
                ],
            ])
            ->order(['OutpatientBillings.id' => 'DESC'])
            ->first();

        if (!$billing) {
            $this->Flash->error(__('Belum ada tagihan rawat jalan.'));
            return $this->redirect(['action' => 'index']);
        }

        return $this->redirect(['action' => 'kasir', $billing->id]);
    }

    $billing = $this->OutpatientBillings->get($id, [
        'contain' => ['Patients', 'Doctors'],
    ]);

    $items = $this->OutpatientBillingItems->find()
        ->where([
            'billing_id' => $billing->id,
            'OR' => [
                ['is_delete' => 0],
                ['is_delete IS' => null],
            ],
        ])
        ->order(['sort_order' => 'ASC', 'id' => 'ASC'])
        ->all();

    $payments = $this->OutpatientBillingPayments->find()
        ->where(['billing_id' => $billing->id])
        ->order(['created' => 'DESC'])
        ->all();

    $this->set(compact('billing', 'items', 'payments'));
}

public function kwitansi($id = null)
{
    if (empty($id)) {
        $billing = $this->OutpatientBillings->find()
            ->where([
                'OR' => [
                    ['OutpatientBillings.is_delete' => 0],
                    ['OutpatientBillings.is_delete IS' => null],
                ],
            ])
            ->order(['OutpatientBillings.id' => 'DESC'])
            ->first();

        if (!$billing) {
            $this->Flash->error(__('Belum ada kwitansi/tagihan rawat jalan.'));
            return $this->redirect(['action' => 'index']);
        }

        return $this->redirect(['action' => 'kwitansi', $billing->id]);
    }

    $billing = $this->OutpatientBillings->get($id, [
        'contain' => ['Patients', 'Doctors'],
    ]);

    $items = $this->OutpatientBillingItems->find()
        ->where([
            'billing_id' => $billing->id,
            'OR' => [
                ['is_delete' => 0],
                ['is_delete IS' => null],
            ],
        ])
        ->order(['sort_order' => 'ASC', 'id' => 'ASC'])
        ->all();

    $this->set(compact('billing', 'items'));
}

    // ─────────────────────────────────────────────────────────────────────────
    // TAMBAH ITEM — Tambah item tagihan via AJAX
    // ─────────────────────────────────────────────────────────────────────────
    public function tambahItem($billingId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $billing = $this->OutpatientBillings->get($billingId);

        if (in_array($billing->status, ['paid', 'void', 'cancelled'])) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Tagihan sudah tidak bisa diubah.']));
        }

        $data = $this->request->getData();

        $item = $this->OutpatientBillingItems->newEmptyEntity();
        $item = $this->OutpatientBillingItems->patchEntity($item, [
            'billing_id'  => $billing->id,
            'item_type'   => $data['item_type']  ?? 'tindakan',
            'item_code'   => $data['item_code']  ?? null,
            'item_name'   => $data['item_name']  ?? '',
            'quantity'    => (float)($data['quantity']   ?? 1),
            'unit'        => $data['unit']        ?? 'kali',
            'unit_price'  => (float)($data['unit_price'] ?? 0),
            'total_price' => (float)($data['unit_price'] ?? 0) * (float)($data['quantity'] ?? 1),
            'final_price' => (float)($data['unit_price'] ?? 0) * (float)($data['quantity'] ?? 1),
            'is_delete'   => 0,
        ]);

        if (!$this->OutpatientBillingItems->save($item)) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Gagal menyimpan item.']));
        }

        $this->recalcBilling($billing->id);

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'item_id' => $item->id]));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // HAPUS ITEM
    // ─────────────────────────────────────────────────────────────────────────
    public function hapusItem($itemId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $item    = $this->OutpatientBillingItems->get($itemId);
        $billing = $this->OutpatientBillings->get($item->billing_id);

        if (in_array($billing->status, ['paid', 'void'])) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Tagihan sudah lunas.']));
        }

        $item->is_delete = 1;
        $this->OutpatientBillingItems->save($item);
        $this->recalcBilling($billing->id);

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => true]));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PROSES BAYAR
    // ─────────────────────────────────────────────────────────────────────────
    public function prosesBayar($id = null)
    {
        $this->request->allowMethod(['post']);

        $billing = $this->OutpatientBillings->get($id, [
            'contain' => ['Patients'],
        ]);

        if ($billing->status === 'paid') {
            $this->Flash->error(__('Tagihan ini sudah lunas.'));
            return $this->redirect(['action' => 'kasir', $id]);
        }

        $data          = $this->request->getData();
        $paymentMethod = $data['payment_method'] ?? 'tunai';
        $paidAmount    = (float)($data['paid_amount'] ?? 0);
        $discountType  = $data['discount_type']  ?? 'nominal';
        $discountValue = (float)($data['discount_value'] ?? 0);
        $notes         = $data['notes'] ?? null;

        // Hitung diskon
        $discountAmount = 0;
        if ($discountType === 'percent') {
            $discountAmount = round($billing->subtotal * $discountValue / 100, 2);
        } else {
            $discountAmount = $discountValue;
        }

        $grandTotal   = max(0, $billing->subtotal - $discountAmount);
        $changeAmount = max(0, $paidAmount - $grandTotal);

        if ($paymentMethod === 'tunai' && $paidAmount < $grandTotal) {
            $this->Flash->error(__('Jumlah bayar kurang dari total tagihan.'));
            return $this->redirect(['action' => 'kasir', $id]);
        }

        // Nomor pembayaran
        $paymentNo = 'PAY-' . date('Ymd') . '-' . str_pad((string)$id, 6, '0', STR_PAD_LEFT);

        // Simpan pembayaran
        $payment = $this->OutpatientBillingPayments->newEmptyEntity();
        $payment = $this->OutpatientBillingPayments->patchEntity($payment, [
            'billing_id'     => $billing->id,
            'payment_no'     => $paymentNo,
            'payment_method' => $paymentMethod,
            'amount'         => $grandTotal,
            'verified'       => 1,
            'verified_at'    => date('Y-m-d H:i:s'),
            'notes'          => $notes,
            'created_by'     => $this->Auth->user('id') ?? null,
        ]);
        $this->OutpatientBillingPayments->save($payment);

        // Update billing
        $billing->discount_type   = $discountType;
        $billing->discount_value  = $discountValue;
        $billing->discount_amount = $discountAmount;
        $billing->grand_total     = $grandTotal;
        $billing->payment_method  = $paymentMethod;
        $billing->paid_amount     = $paidAmount;
        $billing->change_amount   = $changeAmount;
        $billing->status          = 'paid';
        $billing->paid_at         = date('Y-m-d H:i:s');
        $billing->notes           = $notes;
        $this->OutpatientBillings->save($billing);

        $this->Flash->success(__('Pembayaran berhasil! Kembalian: Rp ' . number_format($changeAmount, 0, ',', '.')));
        return $this->redirect(['action' => 'kwitansi', $billing->id]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE: Recalculate total billing
    // ─────────────────────────────────────────────────────────────────────────
    private function recalcBilling(int $billingId): void
    {
        $billing = $this->OutpatientBillings->get($billingId);

        $items = $this->OutpatientBillingItems->find()
            ->where(['billing_id' => $billingId, 'is_delete' => 0])
            ->all();

        $totalAction = 0;
        $totalMed    = 0;
        $totalLab    = 0;
        $totalRad    = 0;
        $totalOther  = 0;

        foreach ($items as $item) {
            switch ($item->item_type) {
                case 'tindakan':      $totalAction += $item->final_price; break;
                case 'obat':         $totalMed    += $item->final_price; break;
                case 'laboratorium': $totalLab    += $item->final_price; break;
                case 'radiologi':    $totalRad    += $item->final_price; break;
                default:             $totalOther  += $item->final_price; break;
            }
        }

        $subtotal   = $totalAction + $totalMed + $totalLab + $totalRad + $totalOther;
        $grandTotal = max(0, $subtotal - $billing->discount_amount);

        $billing->total_action  = $totalAction;
        $billing->total_medicine = $totalMed;
        $billing->total_lab     = $totalLab;
        $billing->total_radiology = $totalRad;
        $billing->total_other   = $totalOther;
        $billing->subtotal      = $subtotal;
        $billing->grand_total   = $grandTotal;

        $this->OutpatientBillings->save($billing);
    }
}