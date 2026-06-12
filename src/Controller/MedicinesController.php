<?php
declare(strict_types=1);

namespace App\Controller;

class MedicinesController extends AppController
{
    public function index()
    {
        $query = $this->Medicines->find()
            ->order(['Medicines.name' => 'ASC']);
    
        $filterActive = $this->request->getQuery('is_active', '');
        if ($filterActive !== '') {
            $query->where(['Medicines.is_active' => $filterActive]);
        }
    
        $filterGroup = $this->request->getQuery('medicine_group_id', '');
        if ($filterGroup !== '') {
            $query->where(['Medicines.inventory_category' => $filterGroup]);
        }
    
        $keyword = trim((string)$this->request->getQuery('key', ''));
        if ($keyword !== '') {
            $query->where([
                'OR' => [
                    'Medicines.name LIKE' => '%' . $keyword . '%',
                    'Medicines.code LIKE' => '%' . $keyword . '%',
                    'Medicines.code_kfa LIKE' => '%' . $keyword . '%',
                    'Medicines.code_ifrs LIKE' => '%' . $keyword . '%',
                    'Medicines.generic_name LIKE' => '%' . $keyword . '%',
                    'Medicines.inventory_category LIKE' => '%' . $keyword . '%',
                    'Medicines.gol LIKE' => '%' . $keyword . '%',
                    'Medicines.therapy_class LIKE' => '%' . $keyword . '%',
                    'Medicines.golongan LIKE' => '%' . $keyword . '%',
                    'Medicines.pabrik LIKE' => '%' . $keyword . '%',
                    'Medicines.sediaan LIKE' => '%' . $keyword . '%',
                    'Medicines.supplier LIKE' => '%' . $keyword . '%',
                ],
            ]);
        }
    
        $this->paginate = ['limit' => 20];
        $medicines = $this->paginate($query);
    
        $medicineGroups = $this->Medicines->find('list', [
            'keyField' => 'inventory_category',
            'valueField' => 'inventory_category',
        ])
            ->where(['inventory_category IS NOT' => null])
            ->group(['inventory_category'])
            ->order(['inventory_category' => 'ASC'])
            ->toArray();
    
        $this->set(compact(
            'medicines',
            'medicineGroups',
            'filterGroup',
            'filterActive',
            'keyword'
        ));
    }

    public function view($id = null)
    {
        if (empty($id) || !is_numeric($id)) {
            $this->Flash->error('ID obat tidak valid.');
            return $this->redirect(['action' => 'index']);
        }
    
        $medicine = $this->Medicines->find()
            ->where(['Medicines.id' => (int)$id])
            ->first();
    
        if (!$medicine) {
            $this->Flash->error('Data obat tidak ditemukan atau sudah terhapus.');
            return $this->redirect(['action' => 'index']);
        }
    
        $this->set(compact('medicine'));
    }

    public function add()
    {
        $medicine = $this->Medicines->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // $data['branch_id'] = 1;
            $data['code'] = $this->generateMedicineCode();
            $data['is_create'] = 1;
            $data['is_update'] = 0;
            $data['is_print'] = 0;

            if (empty($data['unit_2_qty'])) {
                $data['unit_2_qty'] = 10;
            }

            if (empty($data['unit_3_qty'])) {
                $data['unit_3_qty'] = 100;
            }

            if (empty($data['lead_time'])) {
                $data['lead_time'] = 0;
            }

            if (empty($data['jenis_harga'])) {
                $data['jenis_harga'] = 'PROSENTASE';
            }

            if (empty($data['ppn_status'])) {
                $data['ppn_status'] = 'N';
            }

            if (empty($data['is_active'])) {
                $data['is_active'] = 'N';
            }

            $medicine = $this->Medicines->patchEntity($medicine, $data);

            if ($this->Medicines->save($medicine)) {
                $this->Flash->success('Data obat berhasil disimpan.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Data obat gagal disimpan. Silakan coba lagi.');
        }

        $createdByName = $this->getLoginName();

        $this->set(compact('medicine', 'createdByName'));
    }

    public function edit($id = null)
{
    if (empty($id) || !is_numeric($id)) {
        $this->Flash->error('ID obat tidak valid.');
        return $this->redirect(['action' => 'index']);
    }

    $medicine = $this->Medicines->find()
        ->where(['Medicines.id' => (int)$id])
        ->first();

    if (!$medicine) {
        $this->Flash->error('Data obat tidak ditemukan atau sudah terhapus.');
        return $this->redirect(['action' => 'index']);
    }

    if ($this->request->is(['patch', 'post', 'put'])) {
        $data = $this->request->getData();

        // $data['branch_id'] = $medicine->branch_id ?? 1;
        $data['is_update'] = 1;

        if (empty($data['unit_2_qty'])) {
            $data['unit_2_qty'] = 10;
        }

        if (empty($data['unit_3_qty'])) {
            $data['unit_3_qty'] = 100;
        }

        if (empty($data['lead_time'])) {
            $data['lead_time'] = 0;
        }

        if (empty($data['jenis_harga'])) {
            $data['jenis_harga'] = 'PROSENTASE';
        }

        if (empty($data['ppn_status'])) {
            $data['ppn_status'] = 'N';
        }

        if (empty($data['is_active'])) {
            $data['is_active'] = 'N';
        }

        $medicine = $this->Medicines->patchEntity($medicine, $data);

        if ($this->Medicines->save($medicine)) {
            $this->Flash->success('Data obat berhasil diupdate.');
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('Data obat gagal diupdate. Silakan coba lagi.');
    }

    $createdByName = $this->getLoginName();

    $this->set(compact('medicine', 'createdByName'));
}

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        if (empty($id)) {
            $this->Flash->error('ID obat tidak ditemukan.');
            return $this->redirect(['action' => 'index']);
        }

        $medicine = $this->Medicines->get($id);

        if ($this->Medicines->delete($medicine)) {
            $this->Flash->success('Data obat berhasil dihapus.');
        } else {
            $this->Flash->error('Data obat gagal dihapus. Silakan coba lagi.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getGroupInfo()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $name = trim((string)$this->request->getQuery('name', ''));
        $data = [];

        if ($name !== '') {
            $medicine = $this->Medicines->find()
                ->where(['Medicines.inventory_category' => $name])
                ->first();

            if ($medicine) {
                $data = [
                    'name' => $medicine->inventory_category,
                    'unit' => $medicine->unit_1,
                    'qty_unit' => $medicine->unit_2_qty,
                    'packaging' => $medicine->unit_2,
                    'qty_packaging' => $medicine->unit_3_qty,
                ];
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    private function getLoginName(): string
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity) {
            return 'Admin';
        }

        return $identity->name
            ?? $identity->full_name
            ?? $identity->username
            ?? $identity->email
            ?? 'Admin';
    }

    private function generateMedicineCode(): string
    {
        $prefix = 'FAR';

        $last = $this->Medicines->find()
            ->select(['id', 'code'])
            ->order(['Medicines.id' => 'DESC'])
            ->first();

        $next = $last ? ((int)$last->id + 1) : 1;

        return $prefix . str_pad((string)$next, 7, '0', STR_PAD_LEFT);
    }
}