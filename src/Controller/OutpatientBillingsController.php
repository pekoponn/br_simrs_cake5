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

    $paidRow = $this->OutpatientBillingPayments->find()
        ->where(['billing_id' => $billing->id])
        ->select(['total' => $this->OutpatientBillingPayments->find()->func()->sum('amount')])
        ->enableHydration(false)
        ->first();
    $totalPaidSoFar = (float)($paidRow['total'] ?? 0);
    $outstandingAmount = max(0, (float)$billing->grand_total - $totalPaidSoFar);

    $this->set(compact('billing', 'items', 'payments', 'totalPaidSoFar', 'outstandingAmount'));
}

public function kwitansi($id = null)
{
    $this->viewBuilder()->disableAutoLayout();

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
        'contain' => ['Patients', 'Doctors', 'Registrations'],
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
    // TOGGLE READY TO TRANSFER — checkbox "Sudah siap ditransfer ke rawat inap"
    // ─────────────────────────────────────────────────────────────────────────
    public function toggleReadyTransfer($id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $billing = $this->OutpatientBillings->get($id);
        $billing->ready_to_transfer = (bool)$this->request->getData('ready_to_transfer');

        if (!$this->OutpatientBillings->save($billing)) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Gagal menyimpan status.']));
        }

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
        $paidBy        = $data['paid_by'] ?? null;

        $paymentProofFilename = $billing->payment_proof ?? null;
        $uploadedProof = $this->request->getUploadedFile('payment_proof');

        if ($uploadedProof && $uploadedProof->getError() === UPLOAD_ERR_OK) {
            $uploadDir = WWW_ROOT . 'uploads' . DS . 'payment_proofs' . DS;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $ext = pathinfo($uploadedProof->getClientFilename(), PATHINFO_EXTENSION);
            $paymentProofFilename = 'proof_' . $billing->id . '_' . time() . '.' . $ext;

            $uploadedProof->moveTo($uploadDir . $paymentProofFilename);
        }

        $jaminanFields = [
            'insurance_partner_name' => $data['insurance_partner_name'] ?? null,
            'policy_no'              => $data['policy_no'] ?? null,
            'admin_fee'              => (float)($data['admin_fee'] ?? 0),
            'inacbg_amount'          => (float)($data['inacbg_amount'] ?? 0),
            'cbg_code'               => $data['cbg_code'] ?? null,
            'guarantor2_name'        => $data['guarantor2_name'] ?? null,
            'guarantor2_amount'      => (float)($data['guarantor2_amount'] ?? 0),
            'guarantor3_name'        => $data['guarantor3_name'] ?? null,
            'guarantor3_amount'      => (float)($data['guarantor3_amount'] ?? 0),
            'uncollectible_amount'   => (float)($data['uncollectible_amount'] ?? 0),
        ];

        $transferFields = [
            'transfer_card_no'       => $data['transfer_card_no'] ?? null,
            'transfer_bank_auth_no'  => $data['transfer_bank_auth_no'] ?? null,
            'transfer_card_type'     => $data['transfer_card_type'] ?? 'transfer',
            'transfer_admin_percent' => (float)($data['transfer_admin_percent'] ?? 0),
            'transfer_bank_dest'     => $data['transfer_bank_dest'] ?? null,
        ];

        $receiptNo = trim((string)($data['receipt_no'] ?? ''));
        if ($receiptNo === '') {
            $todayPrefix = 'KW-' . date('Ymd') . '-';

            $lastReceipt = $this->OutpatientBillings->find()
                ->select(['receipt_no'])
                ->where(['receipt_no LIKE' => $todayPrefix . '%'])
                ->order(['receipt_no' => 'DESC'])
                ->epilog('FOR UPDATE')
                ->first();

            $nextSeq = 1;
            if ($lastReceipt && $lastReceipt->receipt_no) {
                $lastSeq = (int)substr($lastReceipt->receipt_no, strlen($todayPrefix));
                $nextSeq = $lastSeq + 1;
            }

            $receiptNo = $todayPrefix . str_pad((string)$nextSeq, 4, '0', STR_PAD_LEFT);
        }

                // Hitung diskon
        $discountAmount = 0;
        if ($discountType === 'percent') {
            $discountAmount = round($billing->subtotal * $discountValue / 100, 2);
        } else {
            $discountAmount = $discountValue;
        }

        $grandTotal = max(0, $billing->subtotal - $discountAmount);

        $paidRow = $this->OutpatientBillingPayments->find()
            ->where(['billing_id' => $billing->id])
            ->select(['total' => $this->OutpatientBillingPayments->find()->func()->sum('amount')])
            ->enableHydration(false)
            ->first();
        $totalPreviouslyPaid = (float)($paidRow['total'] ?? 0);
        $outstanding = max(0, $grandTotal - $totalPreviouslyPaid);

        $changeAmount = max(0, $paidAmount - $outstanding);

        if ($paymentMethod === 'tunai' && $paidAmount < $outstanding) {
            $this->Flash->error(__('Jumlah bayar kurang dari sisa tagihan. Sisa tagihan: Rp ' . number_format($outstanding, 0, ',', '.')));
            return $this->redirect(['action' => 'kasir', $id]);
        }

        $paymentSeq = $this->OutpatientBillingPayments->find()
            ->where(['billing_id' => $billing->id])
            ->count() + 1;
        $paymentNo = 'PAY-' . date('Ymd') . '-' . str_pad((string)$id, 6, '0', STR_PAD_LEFT) . '-' . $paymentSeq;

        $payment = $this->OutpatientBillingPayments->newEmptyEntity();
        $payment = $this->OutpatientBillingPayments->patchEntity($payment, [
            'billing_id'     => $billing->id,
            'payment_no'     => $paymentNo,
            'payment_method' => $paymentMethod,
            'amount'         => $outstanding,
            'verified'       => 1,
            'verified_at'    => date('Y-m-d H:i:s'),
            'notes'          => $notes,
            'created_by'     => $this->request->getSession()->read('Auth.User.id') ?? null,
        ]);
        $this->OutpatientBillingPayments->save($payment);

        $billing->discount_type   = $discountType;
        $billing->discount_value  = $discountValue;
        $billing->discount_amount = $discountAmount;
        $billing->grand_total     = $grandTotal;
        $billing->payment_method  = $paymentMethod;
        $billing->paid_amount     = $totalPreviouslyPaid + $outstanding;
        $billing->change_amount   = $changeAmount;
        $billing->status          = 'paid';
        $billing->paid_at         = date('Y-m-d H:i:s');
        $billing->notes           = $notes;
        $billing->paid_by         = $paidBy;
        $billing->receipt_no      = $receiptNo;
        $billing->payment_proof   = $paymentProofFilename;

        if (in_array($paymentMethod, ['bpjs', 'asuransi'], true)) {
            $billing = $this->OutpatientBillings->patchEntity($billing, $jaminanFields, [
                'validate' => false,
            ]);
        }

        if ($paymentMethod === 'transfer') {
            $billing = $this->OutpatientBillings->patchEntity($billing, $transferFields, [
                'validate' => false,
            ]);
        }

        $this->OutpatientBillings->save($billing);

                $this->Flash->success(__('Pembayaran berhasil! Kembalian: Rp ' . number_format($changeAmount, 0, ',', '.')));
        return $this->redirect(['action' => 'kwitansi', $billing->id]);
    }

    public function reopen($id = null)
    {
        $this->request->allowMethod(['post']);

        $billing = $this->OutpatientBillings->get($id, [
            'contain' => ['Patients'],
        ]);

        if (!in_array($billing->status, ['paid', 'void', 'cancelled'], true)) {
            $this->Flash->error(__('Tagihan ini belum lunas/ditutup, tidak perlu dibuka kembali.'));
            return $this->redirect($this->referer());
        }

        $reason = trim((string)$this->request->getData('reopen_reason'));
        if ($reason === '') {
            $this->Flash->error(__('Alasan pembukaan akses wajib diisi.'));
            return $this->redirect($this->referer());
        }

        $billing->reopen_reason = $reason;
        $billing->reopened_at   = date('Y-m-d H:i:s');
        $billing->reopened_by   = $this->request->getSession()->read('Auth.User.id') ?? null;
        $billing->reopen_count  = (int)($billing->reopen_count ?? 0) + 1;

        if (!empty($billing->outpatient_visit_id)) {
            $this->loadModel('OutpatientVisits');
            $visit = $this->OutpatientVisits->find()
                ->where(['id' => $billing->outpatient_visit_id])
                ->first();
            if ($visit) {
                $visit->status = 'in_progress';
                $this->OutpatientVisits->save($visit, ['checkRules' => false]);
            }
        }

        if ($this->OutpatientBillings->save($billing, ['checkRules' => false])) {
            $this->Flash->success(__('Akses pemeriksaan (EMR/CPPT/Resume) berhasil dibuka kembali. Status kasir tetap Lunas sampai ada perubahan tindakan/obat yang menambah tagihan.'));
        } else {
            $this->Flash->error(__('Gagal membuka akses tagihan.'));
        }

        return $this->redirect([
            'controller' => 'PaymentHistories',
            'action' => 'index',
            '?' => ['patient_id' => $billing->patient_id, 'billing_id' => $billing->id],
        ]);
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