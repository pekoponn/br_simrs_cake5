<?php

declare(strict_types=1);

namespace App\Controller;

class PaymentHistoriesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Patients = $this->fetchTable('Patients');
        $this->OutpatientBillings = $this->fetchTable('OutpatientBillings');
        $this->OutpatientBillingItems = $this->fetchTable('OutpatientBillingItems');
        $this->OutpatientBillingPayments = $this->fetchTable('OutpatientBillingPayments');
    }

    public function index()
    {
        $patientId = $this->request->getQuery('patient_id');
        $billingId = $this->request->getQuery('billing_id');

        // ── Pasien terpilih ──
        $patient = null;
        if (!empty($patientId)) {
            try {
                $patient = $this->Patients->get($patientId);
            } catch (\Exception $e) {
                $patient = null;
            }
        }

                // ── History kwitansi milik pasien (status paid) ──
        $billingHistory = [];
        $paymentNoMap   = [];
        if ($patient) {
            $billingHistory = $this->OutpatientBillings->find()
                ->where([
                    'OutpatientBillings.patient_id' => $patient->id,
                    'OutpatientBillings.status'      => 'paid',
                ])
                ->order(['OutpatientBillings.paid_at' => 'DESC'])
                ->all()
                ->toArray();

            if (!empty($billingHistory)) {
                $billingIds = array_map(fn($b) => $b->id, $billingHistory);
                $payments = $this->OutpatientBillingPayments->find()
                    ->select(['billing_id', 'payment_no', 'created'])
                    ->where(['billing_id IN' => $billingIds])
                    ->order(['created' => 'DESC'])
                    ->all();
                foreach ($payments as $pay) {
                    if (!isset($paymentNoMap[$pay->billing_id])) {
                        $paymentNoMap[$pay->billing_id] = $pay->payment_no;
                    }
                }
            }
        }
        

        // ── Detail kwitansi terpilih, dikelompokkan per kategori ──
        $selectedBilling = null;
        $groupedItems    = [];
        $typeLabels = [
            'tindakan'     => 'Pemeriksaan & Tindakan Dokter Poli',
            'obat'         => 'Obat / Resep',
            'laboratorium' => 'Laboratorium',
            'radiologi'    => 'Radiologi',
            'lainnya'      => 'Bedah / ODC / Penunjang Medis',
        ];

        if (!empty($billingId)) {
            try {
                $selectedBilling = $this->OutpatientBillings->get($billingId, [
                    'contain' => ['Patients', 'Doctors'],
                ]);

                $items = $this->OutpatientBillingItems->find()
                    ->where([
                        'billing_id' => $selectedBilling->id,
                        'OR' => [
                            ['is_delete' => 0],
                            ['is_delete IS' => null],
                        ],
                    ])
                    ->order(['sort_order' => 'ASC', 'id' => 'ASC'])
                    ->all();

                foreach ($items as $item) {
                    $type = $item->item_type ?? 'lainnya';
                    if (!isset($typeLabels[$type])) {
                        $type = 'lainnya';
                    }
                    $groupedItems[$type][] = $item;
                }
            } catch (\Exception $e) {
                $selectedBilling = null;
            }
        }

        $this->set(compact(
            'patient',
            'billingHistory',
            'selectedBilling',
            'groupedItems',
            'typeLabels',
            'billingId',
            'paymentNoMap'
        ));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AJAX: cari pasien untuk modal (sama pola dengan PatientHistoriesController)
    // ─────────────────────────────────────────────────────────────────────────
    public function searchPatients()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $term = trim((string)$this->request->getQuery('term', ''));
        $limit = (int)$this->request->getQuery('limit', 50);
        if ($limit <= 0 || $limit > 100) {
            $limit = 50;
        }

        $query = $this->Patients->find()
            ->select([
                'id', 'code', 'full_name', 'birth_date', 'gender',
                'address', 'phone_number', 'identity_number',
            ])
            ->where([
                'OR' => [
                    ['Patients.is_delete !=' => 1],
                    ['Patients.is_delete IS' => null],
                ],
            ]);

        if ($term !== '') {
            $query->where([
                'OR' => [
                    'Patients.code LIKE'             => '%' . $term . '%',
                    'Patients.full_name LIKE'        => '%' . $term . '%',
                    'Patients.identity_number LIKE'  => '%' . $term . '%',
                    'Patients.phone_number LIKE'     => '%' . $term . '%',
                    'Patients.address LIKE'          => '%' . $term . '%',
                ],
            ]);
        }

        $query->order([
            'Patients.full_name' => 'ASC',
            'Patients.id' => 'DESC',
        ])->limit($limit);

        $patients = [];
        foreach ($query as $row) {
            $birthDate = '';
            if (!empty($row->birth_date) && is_object($row->birth_date) && method_exists($row->birth_date, 'format')) {
                $birthDate = $row->birth_date->format('d-m-Y');
            } elseif (!empty($row->birth_date)) {
                $birthDate = date('d-m-Y', strtotime((string)$row->birth_date));
            }

            $gender = strtolower((string)($row->gender ?? ''));
            if (in_array($gender, ['male', 'm', 'l', 'laki-laki', 'pria'], true)) {
                $genderText = 'P';
            } elseif (in_array($gender, ['female', 'f', 'p', 'perempuan', 'wanita'], true)) {
                $genderText = 'W';
            } else {
                $genderText = $row->gender ? strtoupper(substr((string)$row->gender, 0, 1)) : '';
            }

            $patients[] = [
                'id'              => $row->id,
                'code'            => (string)($row->code ?? ''),
                'full_name'       => (string)($row->full_name ?? ''),
                'birth_date'      => $birthDate,
                'gender'          => $genderText,
                'address'         => (string)($row->address ?? ''),
                'phone_number'    => (string)($row->phone_number ?? ''),
                'identity_number' => (string)($row->identity_number ?? ''),
            ];
        }

        $payload = [
            'success' => true,
            'term'    => $term,
            'data'    => $patients,
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($payload, JSON_UNESCAPED_UNICODE));
    }
}