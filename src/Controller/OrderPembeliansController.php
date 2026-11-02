<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class OrderPembeliansController extends AppController
{
    public function index()
    {
        $query = $this->OrderPembelians->find()
            // TODO: tambahkan ->contain(['Suppliers']) setelah tabel Suppliers ada
            ->order(['OrderPembelians.tgl_po' => 'DESC']);

        $orderPembelians = $this->paginate($query);

        $this->set(compact('orderPembelians'));
    }

    public function view($id = null)
    {
        $orderPembelian = $this->OrderPembelians->get($id, [
            // TODO: tambahkan 'Suppliers', 'OrderPembelianDetails.Barangs' ke contain
            // setelah tabel Suppliers & Barangs ada
            'contain' => ['OrderPembelianDetails'],
        ]);

        $this->set(compact('orderPembelian'));
    }

    public function add()
{
    $orderPembelian = $this->OrderPembelians->newEmptyEntity();

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        // Hitung total_harga per baris & total header sebelum disimpan
        $data = $this->calculateTotals($data);

        $orderPembelian = $this->OrderPembelians->patchEntity($orderPembelian, $data, [
            'associated' => ['OrderPembelianDetails'],
        ]);

        if ($this->OrderPembelians->save($orderPembelian, ['associated' => ['OrderPembelianDetails']])) {
            $this->Flash->success(__('Order Pembelian berhasil disimpan.'));

            return $this->redirect(['action' => 'view', $orderPembelian->id]);
        }
        $this->Flash->error(__('Order Pembelian gagal disimpan. Silakan cek kembali data yang diisi.'));
    }

$medicines = TableRegistry::getTableLocator()->get('Medicines')
    ->find()
    ->select(['id', 'code', 'name', 'generic_name', 'unit_1', 'hna'])
    ->where(['is_active' => 'Y'])
    ->orderBy(['name' => 'ASC'])
    ->all();

    $this->set(compact('orderPembelian', 'medicines'));
}

    public function edit($id = null)
{
    $orderPembelian = $this->OrderPembelians->get($id, [
        'contain' => ['OrderPembelianDetails'],
    ]);

    if ($this->request->is(['patch', 'post', 'put'])) {
        $data = $this->calculateTotals($this->request->getData());

        $orderPembelian = $this->OrderPembelians->patchEntity($orderPembelian, $data, [
            'associated' => ['OrderPembelianDetails'],
        ]);

        if ($this->OrderPembelians->save($orderPembelian, ['associated' => ['OrderPembelianDetails']])) {
            $this->Flash->success(__('Order Pembelian berhasil diupdate.'));

            return $this->redirect(['action' => 'view', $orderPembelian->id]);
        }
        $this->Flash->error(__('Order Pembelian gagal diupdate. Silakan cek kembali data yang diisi.'));
    }

    // Sama seperti add(): kirim Master Data Obat untuk modal "Pilih Obat"
    $medicines = $this->fetchTable('Medicines')
        ->find()
        ->select(['id', 'code', 'name', 'generic_name', 'unit_1', 'hna'])
        ->where(['is_active' => 'Y'])
        ->orderBy(['name' => 'ASC'])
        ->all();

    $this->set(compact('orderPembelian', 'medicines'));
}

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderPembelian = $this->OrderPembelians->get($id);

        if ($this->OrderPembelians->delete($orderPembelian)) {
            $this->Flash->success(__('Order Pembelian berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Order Pembelian gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Ambil data dari Rencana Pembelian (tombol "Ambil dari list Rencana Pembelian")
     * Endpoint AJAX -> return json baris barang yang siap dimasukkan ke grid.
     *
     * NONAKTIF SEMENTARA: butuh tabel rencana_pembelian + Barangs yang belum
     * dibuat (nunggu analisis alur pembelian RS). Aktifkan lagi nanti setelah
     * tabel-tabel referensi itu dibuat, dan sesuaikan nama tabel/kolomnya.
     */
    // public function ambilRencana($rencanaPembelianId = null)
    // {
    //     $this->request->allowMethod(['get']);
    //     $this->viewBuilder()->setClassName('Json');
    //
    //     $rencanaTable = $this->fetchTable('RencanaPembelianDetails');
    //     $items = $rencanaTable->find()
    //         ->where(['rencana_pembelian_id' => $rencanaPembelianId])
    //         ->contain(['Barangs'])
    //         ->all();
    //
    //     $result = [];
    //     foreach ($items as $item) {
    //         $result[] = [
    //             'barang_id' => $item->barang_id,
    //             'kode_barang' => $item->barang->kode_barang,
    //             'nama_barang' => $item->barang->nama_barang,
    //             'qty_rencana' => $item->qty,
    //             'satuan' => $item->barang->satuan ?? '',
    //         ];
    //     }
    //
    //     $this->set(compact('result'));
    //     $this->viewBuilder()->setOption('serialize', ['result']);
    // }

    /**
     * Hitung total_harga tiap baris (qty x harga - discount + tax)
     * dan total keseluruhan header, sebelum data disimpan.
     */
    private function calculateTotals(array $data): array
    {
        $grandTotal = 0;

        if (!empty($data['order_pembelian_details'])) {
            foreach ($data['order_pembelian_details'] as $i => $line) {
                $qty = (float)($line['qty_po'] ?? 0);
                $harga = (float)($line['harga'] ?? 0);
                $discount = (float)($line['discount'] ?? 0);
                $tax = (float)($line['tax'] ?? 0);

                $subtotal = ($qty * $harga) - $discount;
                $subtotal += $subtotal * ($tax / 100);

                $data['order_pembelian_details'][$i]['total_harga'] = $subtotal;
                $grandTotal += $subtotal;
            }
        }

        $data['total'] = $grandTotal;

        return $data;
    }
}