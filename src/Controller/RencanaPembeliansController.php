<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class RencanaPembeliansController extends AppController
{
    public function index()
    {
        $query = $this->RencanaPembelians->find()
            ->order(['RencanaPembelians.tgl_perencanaan' => 'DESC']);

        $rencanaPembelians = $this->paginate($query);

        $this->set(compact('rencanaPembelians'));
    }

    public function view($id = null)
    {
        $rencanaPembelian = $this->RencanaPembelians->get($id, [
            'contain' => ['RencanaPembelianDetails'],
        ]);

        $this->set(compact('rencanaPembelian'));
    }

    public function add()
    {
        $rencanaPembelian = $this->RencanaPembelians->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data = $this->calculateTotals($data);
            $data['no_perencanaan'] = $this->generateNoPerencanaan();

            $rencanaPembelian = $this->RencanaPembelians->patchEntity($rencanaPembelian, $data, [
                'associated' => ['RencanaPembelianDetails'],
            ]);

            if ($this->RencanaPembelians->save($rencanaPembelian, ['associated' => ['RencanaPembelianDetails']])) {
                $this->Flash->success(__('Rencana Pembelian berhasil disimpan.'));

                return $this->redirect(['action' => 'view', $rencanaPembelian->id]);
            }
            $this->Flash->error(__('Rencana Pembelian gagal disimpan. Silakan cek kembali data yang diisi.'));
        }

        $medicines = TableRegistry::getTableLocator()->get('Medicines')
            ->find()
            ->select(['id', 'code', 'name', 'generic_name', 'unit_1', 'hna'])
            ->where(['is_active' => 'Y'])
            ->order(['name' => 'ASC'])
            ->all();

        $this->set(compact('rencanaPembelian', 'medicines'));
    }

    public function edit($id = null)
    {
        $rencanaPembelian = $this->RencanaPembelians->get($id, [
            'contain' => ['RencanaPembelianDetails'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->calculateTotals($this->request->getData());

            $rencanaPembelian = $this->RencanaPembelians->patchEntity($rencanaPembelian, $data, [
                'associated' => ['RencanaPembelianDetails'],
            ]);

            if ($this->RencanaPembelians->save($rencanaPembelian, ['associated' => ['RencanaPembelianDetails']])) {
                $this->Flash->success(__('Rencana Pembelian berhasil diupdate.'));

                return $this->redirect(['action' => 'view', $rencanaPembelian->id]);
            }
            $this->Flash->error(__('Rencana Pembelian gagal diupdate. Silakan cek kembali data yang diisi.'));
        }

        $medicines = TableRegistry::getTableLocator()->get('Medicines')
            ->find()
            ->select(['id', 'code', 'name', 'generic_name', 'unit_1', 'hna'])
            ->where(['is_active' => 'Y'])
            ->order(['name' => 'ASC'])
            ->all();

        $this->set(compact('rencanaPembelian', 'medicines'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rencanaPembelian = $this->RencanaPembelians->get($id);

        if ($this->RencanaPembelians->delete($rencanaPembelian)) {
            $this->Flash->success(__('Rencana Pembelian berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Rencana Pembelian gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Endpoint AJAX untuk tombol "Ambil dari list Rencana Pembelian"
     * di form Order Pembelian. Mengembalikan detail barang dari satu
     * Rencana Pembelian yang sudah disetujui, siap dimasukkan ke grid PO.
     */
    public function ambilDetail($id = null)
    {
        $this->request->allowMethod(['get']);
        $this->viewBuilder()->setClassName('Json');

        $rencanaPembelian = $this->RencanaPembelians->get($id, [
            'contain' => ['RencanaPembelianDetails'],
        ]);

        $result = [];
        foreach ($rencanaPembelian->rencana_pembelian_details as $item) {
            $result[] = [
                'medicine_id' => $item->medicine_id,
                'kode_barang' => $item->kode_barang,
                'nama_barang' => $item->nama_barang,
                'qty_rencana' => $item->qty,
                'satuan' => $item->satuan,
                'harga' => $item->harga,
            ];
        }

        $this->set(compact('result'));
        $this->viewBuilder()->setOption('serialize', ['result']);
    }

    /**
     * No. Perencanaan otomatis, format: RP-YYYYMMDD-0001
     */
    private function generateNoPerencanaan(): string
    {
        $today = date('Ymd');
        $prefix = 'RP-' . $today . '-';

        $countToday = $this->RencanaPembelians->find()
            ->where(['no_perencanaan LIKE' => $prefix . '%'])
            ->count();

        $next = str_pad((string)($countToday + 1), 4, '0', STR_PAD_LEFT);

        return $prefix . $next;
    }

    /**
     * Hitung total per baris (qty x harga) dan total header,
     * sebelum data disimpan.
     */
    private function calculateTotals(array $data): array
    {
        $grandQty = 0;
        $grandTotal = 0;

        if (!empty($data['rencana_pembelian_details'])) {
            foreach ($data['rencana_pembelian_details'] as $i => $line) {
                $qty = (float)($line['qty'] ?? 0);
                $harga = (float)($line['harga'] ?? 0);
                $total = $qty * $harga;

                $data['rencana_pembelian_details'][$i]['total'] = $total;

                $grandQty += $qty;
                $grandTotal += $total;
            }
        }

        $data['total_qty_permintaan'] = $grandQty;
        $data['total_permintaan'] = $grandTotal;

        return $data;
    }
}