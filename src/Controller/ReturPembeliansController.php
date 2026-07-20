<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class ReturPembeliansController extends AppController
{
    public function index()
    {
        $query = $this->ReturPembelians->find()
            ->order(['ReturPembelians.tgl_retur' => 'DESC']);

        $returPembelians = $this->paginate($query);

        $this->set(compact('returPembelians'));
    }

    public function view($id = null)
    {
        $returPembelian = $this->ReturPembelians->get($id, [
            'contain' => ['ReturPembelianDetails'],
        ]);

        $this->set(compact('returPembelian'));
    }

    public function add()
    {
        $returPembelian = $this->ReturPembelians->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data = $this->calculateTotals($data);
            $data['retur_no'] = $this->generateReturNo();

            $returPembelian = $this->ReturPembelians->patchEntity($returPembelian, $data, [
                'associated' => ['ReturPembelianDetails'],
            ]);

            if ($this->ReturPembelians->save($returPembelian, ['associated' => ['ReturPembelianDetails']])) {
                $this->Flash->success(__('Retur Pembelian berhasil disimpan.'));

                return $this->redirect(['action' => 'view', $returPembelian->id]);
            }
            $this->Flash->error(__('Retur Pembelian gagal disimpan. Silakan cek kembali data yang diisi.'));
        }

        $medicines = TableRegistry::getTableLocator()->get('Medicines')
            ->find()
            ->select(['id', 'code', 'name', 'generic_name', 'unit_1', 'hna'])
            ->where(['is_active' => 'Y'])
            ->order(['name' => 'ASC'])
            ->all();

        // TODO: ganti dengan tabel gudang/depo yang sebenarnya kalau sudah ada
        $depoList = [
            'GUDANG FARMASI' => 'GUDANG FARMASI',
            'FARMASI 1 RAJAL DEPO' => 'FARMASI 1 RAJAL DEPO',
            'FARMASI 2 RAJAL DEPO' => 'FARMASI 2 RAJAL DEPO',
            'DEPO RANAP' => 'DEPO RANAP',
            'DEPO IGD' => 'DEPO IGD',
        ];

        $this->set(compact('returPembelian', 'medicines', 'depoList'));
    }

    public function edit($id = null)
    {
        $returPembelian = $this->ReturPembelians->get($id, [
            'contain' => ['ReturPembelianDetails'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->calculateTotals($this->request->getData());

            $returPembelian = $this->ReturPembelians->patchEntity($returPembelian, $data, [
                'associated' => ['ReturPembelianDetails'],
            ]);

            if ($this->ReturPembelians->save($returPembelian, ['associated' => ['ReturPembelianDetails']])) {
                $this->Flash->success(__('Retur Pembelian berhasil diupdate.'));

                return $this->redirect(['action' => 'view', $returPembelian->id]);
            }
            $this->Flash->error(__('Retur Pembelian gagal diupdate. Silakan cek kembali data yang diisi.'));
        }

        $medicines = TableRegistry::getTableLocator()->get('Medicines')
            ->find()
            ->select(['id', 'code', 'name', 'generic_name', 'unit_1', 'hna'])
            ->where(['is_active' => 'Y'])
            ->order(['name' => 'ASC'])
            ->all();

        $depoList = [
            'GUDANG FARMASI' => 'GUDANG FARMASI',
            'FARMASI 1 RAJAL DEPO' => 'FARMASI 1 RAJAL DEPO',
            'FARMASI 2 RAJAL DEPO' => 'FARMASI 2 RAJAL DEPO',
            'DEPO RANAP' => 'DEPO RANAP',
            'DEPO IGD' => 'DEPO IGD',
        ];

        $this->set(compact('returPembelian', 'medicines', 'depoList'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $returPembelian = $this->ReturPembelians->get($id);

        if ($this->ReturPembelians->delete($returPembelian)) {
            $this->Flash->success(__('Retur Pembelian berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Retur Pembelian gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * No. Retur otomatis, format: RTB-YYYYMMDD-0001
     */
    private function generateReturNo(): string
    {
        $today = date('Ymd');
        $prefix = 'RTB-' . $today . '-';

        $countToday = $this->ReturPembelians->find()
            ->where(['retur_no LIKE' => $prefix . '%'])
            ->count();

        $next = str_pad((string)($countToday + 1), 4, '0', STR_PAD_LEFT);

        return $prefix . $next;
    }

    /**
     * Hitung total_harga tiap baris (qty x harga - discount + tax + ppn)
     * dan total keseluruhan header, sebelum data disimpan.
     */
    private function calculateTotals(array $data): array
    {
        $grandTotal = 0;

        if (!empty($data['retur_pembelian_details'])) {
            foreach ($data['retur_pembelian_details'] as $i => $line) {
                $qty = (float)($line['qty'] ?? 0);
                $harga = (float)($line['harga'] ?? 0);
                $tax = (float)($line['tax'] ?? 0);
                $ppn = (float)($line['ppn_rp'] ?? 0);
                $discount = (float)($line['discount'] ?? 0);

                $subtotal = ($qty * $harga) - $discount;
                $subtotal += $subtotal * ($tax / 100);
                $subtotal += $ppn;

                $data['retur_pembelian_details'][$i]['total_harga'] = $subtotal;
                $grandTotal += $subtotal;
            }
        }

        $data['total'] = $grandTotal;

        return $data;
    }
}