<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class InvoicesController extends AppController
{
    public function index()
    {
        $query = $this->Invoices->find()
            ->order(['Invoices.tgl_terima' => 'DESC']);

        $invoices = $this->paginate($query);

        $this->set(compact('invoices'));
    }

    public function view($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['InvoiceDetails'],
        ]);

        $this->set(compact('invoice'));
    }

    public function add()
    {
        $invoice = $this->Invoices->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data = $this->calculateTotals($data);
            $data['bapb_no'] = $this->generateBapbNo();

            $invoice = $this->Invoices->patchEntity($invoice, $data, [
                'associated' => ['InvoiceDetails'],
            ]);

            if ($this->Invoices->save($invoice, ['associated' => ['InvoiceDetails']])) {
                $this->Flash->success(__('Invoice / BAPB berhasil disimpan.'));

                return $this->redirect(['action' => 'view', $invoice->id]);
            }
            $this->Flash->error(__('Invoice / BAPB gagal disimpan. Silakan cek kembali data yang diisi.'));
        }

        $medicines = TableRegistry::getTableLocator()->get('Medicines')
            ->find()
            ->select(['id', 'code', 'name', 'generic_name', 'unit_1', 'hna'])
            ->where(['is_active' => 'Y'])
            ->orderBy(['name' => 'ASC'])
            ->all();

        // TODO: ganti dengan tabel gudang/depo & mata uang yang sebenarnya kalau sudah ada
        $lokasiList = [
            'GUDANG FARMASI' => 'GUDANG FARMASI',
            'FARMASI 1 RAJAL DEPO' => 'FARMASI 1 RAJAL DEPO',
            'FARMASI 2 RAJAL DEPO' => 'FARMASI 2 RAJAL DEPO',
            'DEPO RANAP' => 'DEPO RANAP',
            'DEPO IGD' => 'DEPO IGD',
        ];

        $kursList = [
            'IDR' => 'IDR',
            'USD' => 'USD',
        ];

        $this->set(compact('invoice', 'medicines', 'lokasiList', 'kursList'));
    }

    public function edit($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['InvoiceDetails'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->calculateTotals($this->request->getData());

            $invoice = $this->Invoices->patchEntity($invoice, $data, [
                'associated' => ['InvoiceDetails'],
            ]);

            if ($this->Invoices->save($invoice, ['associated' => ['InvoiceDetails']])) {
                $this->Flash->success(__('Invoice / BAPB berhasil diupdate.'));

                return $this->redirect(['action' => 'view', $invoice->id]);
            }
            $this->Flash->error(__('Invoice / BAPB gagal diupdate. Silakan cek kembali data yang diisi.'));
        }

        $medicines = TableRegistry::getTableLocator()->get('Medicines')
            ->find()
            ->select(['id', 'code', 'name', 'generic_name', 'unit_1', 'hna'])
            ->where(['is_active' => 'Y'])
            ->orderBy(['name' => 'ASC'])
            ->all();

        $lokasiList = [
            'GUDANG FARMASI' => 'GUDANG FARMASI',
            'FARMASI 1 RAJAL DEPO' => 'FARMASI 1 RAJAL DEPO',
            'FARMASI 2 RAJAL DEPO' => 'FARMASI 2 RAJAL DEPO',
            'DEPO RANAP' => 'DEPO RANAP',
            'DEPO IGD' => 'DEPO IGD',
        ];

        $kursList = [
            'IDR' => 'IDR',
            'USD' => 'USD',
        ];

        $this->set(compact('invoice', 'medicines', 'lokasiList', 'kursList'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoice = $this->Invoices->get($id);

        if ($this->Invoices->delete($invoice)) {
            $this->Flash->success(__('Invoice / BAPB berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Invoice / BAPB gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Endpoint AJAX untuk tombol "cari BAPB" di form Retur Pembelian.
     * Mengembalikan header + detail 1 invoice berdasarkan BAPB No.
     */
    public function cariBapb()
    {
        $this->request->allowMethod(['get']);
        $this->viewBuilder()->setClassName('Json');

        $q = trim((string)$this->request->getQuery('q'));

        $query = $this->Invoices->find()
            ->select(['id', 'bapb_no', 'nama_supplier', 'no_faktur', 'tgl_terima', 'diterima_lokasi_gudang'])
            ->order(['tgl_terima' => 'DESC'])
            ->limit(20);

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'bapb_no LIKE' => '%' . $q . '%',
                    'nama_supplier LIKE' => '%' . $q . '%',
                    'no_faktur LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        $result = $query->all()->toArray();

        $this->set(compact('result'));
        $this->viewBuilder()->setOption('serialize', ['result']);
    }

    /**
     * No. BAPB otomatis, format: BAPB-YYYYMMDD-0001
     */
    private function generateBapbNo(): string
    {
        $today = date('Ymd');
        $prefix = 'BAPB-' . $today . '-';

        $countToday = $this->Invoices->find()
            ->where(['bapb_no LIKE' => $prefix . '%'])
            ->count();

        $next = str_pad((string)($countToday + 1), 4, '0', STR_PAD_LEFT);

        return $prefix . $next;
    }

    /**
     * Hitung total_harga tiap baris, total keseluruhan sebelum discount
     * invoice, dan grand_total setelah discount invoice + ongkos kirim.
     */
    private function calculateTotals(array $data): array
    {
        $subGrandTotal = 0;

        if (!empty($data['invoice_details'])) {
            foreach ($data['invoice_details'] as $i => $line) {
                $qty = (float)($line['qty'] ?? 0);
                $harga = (float)($line['harga'] ?? 0);
                $discountPercent = (float)($line['discount_percent'] ?? 0);
                $discountRp = (float)($line['discount_rp'] ?? 0);
                $tax = (float)($line['tax'] ?? 0);

                $lineSubtotal = $qty * $harga;
                $lineSubtotal -= $lineSubtotal * ($discountPercent / 100);
                $lineSubtotal -= $discountRp;
                $lineSubtotal += $lineSubtotal * ($tax / 100);

                $data['invoice_details'][$i]['total_harga'] = $lineSubtotal;
                $subGrandTotal += $lineSubtotal;
            }
        }

        $discountPercentInvoice = (float)($data['discount_percent'] ?? 0);
        $discountRpInvoice = (float)($data['discount_rp'] ?? 0);
        $ongkosKirim = (float)($data['ongkos_kirim'] ?? 0);

        $grandTotal = $subGrandTotal;
        $grandTotal -= $grandTotal * ($discountPercentInvoice / 100);
        $grandTotal -= $discountRpInvoice;
        $grandTotal += $ongkosKirim;

        $data['total'] = $subGrandTotal;
        $data['grand_total'] = $grandTotal;

        return $data;
    }
}