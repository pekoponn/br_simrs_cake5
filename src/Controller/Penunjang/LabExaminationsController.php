<?php
declare(strict_types=1);

namespace App\Controller\Penunjang;

use App\Controller\AppController;

class LabExaminationsController extends AppController
{
    public function index()
    {
        $q = trim((string)$this->request->getQuery('q'));
        $by = (string)$this->request->getQuery('by', 'patient_name');
        $dateFrom = (string)$this->request->getQuery('date_from', date('Y-m-d'));

        if (!in_array($by, ['patient_name', 'medical_record_no', 'lab_no'], true)) {
            $by = 'patient_name';
        }

        $query = $this->LabExaminations->find()
            ->where([
                'LabExaminations.is_active' => 'Y',
                'DATE(LabExaminations.received_at) >=' => $dateFrom,
            ])
            ->orderBy(['LabExaminations.received_at' => 'DESC', 'LabExaminations.id' => 'DESC']);

        if ($q !== '') {
            $query->where(["LabExaminations.$by LIKE" => '%' . $q . '%']);
        }

        $examinations = $this->paginate($query, ['limit' => 50]);
        $officer = $this->request->getAttribute('identity')?->get('name') ?? '-';

        // Permintaan masuk: order yang punya item lab dan belum diproses
        $processed = $this->LabExaminations->find()
            ->select(['order_id'])
            ->where(['order_id IS NOT' => null]);

        $ordersQuery = $this->fetchTable('Orders')->find();

        $requests = $ordersQuery
            ->select([
                'id' => 'Orders.id',
                'no_order' => 'Orders.no_order',
                'tgl_order' => 'Orders.tgl_order',
                'pesan' => 'Orders.pesan',
                'rm' => 'p.code',
                'patient_name' => 'p.full_name',
                'doctor_name' => 'd.doctor_name',
                'service_type' => 'r.service_type',
                'lab_names' => $ordersQuery->newExpr('GROUP_CONCAT(ol.examination_name SEPARATOR ", ")'),
            ])
            ->join([
                'ol' => ['table' => 'order_laboratories', 'type' => 'INNER', 'conditions' => 'ol.order_id = Orders.id'],
                'p' => ['table' => 'patients', 'type' => 'LEFT', 'conditions' => 'p.id = Orders.patient_id'],
                'd' => ['table' => 'doctors', 'type' => 'LEFT', 'conditions' => 'd.id = Orders.doctor_id'],
                'r' => ['table' => 'registrations', 'type' => 'LEFT', 'conditions' => 'r.id = Orders.registration_id'],
            ])
            ->where(['Orders.id NOT IN' => $processed])
            ->groupBy([
                'Orders.id', 'Orders.no_order', 'Orders.tgl_order', 'Orders.pesan',
                'p.code', 'p.full_name', 'd.doctor_name', 'r.service_type',
            ])
            ->orderBy(['Orders.id' => 'DESC'])
            ->disableHydration()
            ->all();

        $this->set(compact('examinations', 'q', 'by', 'dateFrom', 'officer', 'requests'));
    }

    public function proses($orderId = null)
    {
        $this->request->allowMethod(['post']);

        $orderId = (int)$orderId;

        $order = $this->fetchTable('Orders')->find()
            ->select([
                'id' => 'Orders.id',
                'patient_id' => 'Orders.patient_id',
                'registration_id' => 'Orders.registration_id',
                'rm' => 'p.code',
                'patient_name' => 'p.full_name',
                'doctor_name' => 'd.doctor_name',
                'service_type' => 'r.service_type',
            ])
            ->join([
                'p' => ['table' => 'patients', 'type' => 'LEFT', 'conditions' => 'p.id = Orders.patient_id'],
                'd' => ['table' => 'doctors', 'type' => 'LEFT', 'conditions' => 'd.id = Orders.doctor_id'],
                'r' => ['table' => 'registrations', 'type' => 'LEFT', 'conditions' => 'r.id = Orders.registration_id'],
            ])
            ->where(['Orders.id' => $orderId])
            ->disableHydration()
            ->first();

        if (!$order) {
            $this->Flash->error('Order tidak ditemukan.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->LabExaminations->exists(['order_id' => $orderId])) {
            $this->Flash->warning('Order ini sudah diproses.');
            return $this->redirect(['action' => 'index']);
        }

        $items = $this->fetchTable('OrderLaboratories')->find()
            ->where(['order_id' => $orderId])
            ->disableHydration()
            ->all()
            ->toList();

        $ok = $this->LabExaminations->getConnection()->transactional(function () use ($items, $order, $orderId) {
            $map = ['rawat_jalan' => 'Rawat Jalan', 'rawat_inap' => 'Rawat Inap', 'igd' => 'IGD'];
            $last = (int)($this->LabExaminations->find()->orderBy(['id' => 'DESC'])->first()?->id ?? 0);

            foreach ($items as $it) {
                $last++;
                $row = $this->LabExaminations->newEntity([
                    'lab_no' => 'L' . date('Y') . str_pad((string)$last, 11, '0', STR_PAD_LEFT),
                    'order_id' => $orderId,
                    'registration_id' => $order['registration_id'],
                    'patient_id' => $order['patient_id'],
                    'medical_record_no' => $order['rm'],
                    'patient_name' => $order['patient_name'] ?? '-',
                    'examination_name' => $it['examination_name'] ?? '-',
                    'patient_type' => $map[$order['service_type']] ?? $order['service_type'],
                    'sender_doctor' => $order['doctor_name'],
                    'received_at' => date('Y-m-d H:i:s'),
                    'status' => 'received',
                    'is_active' => 'Y',
                ], ['validate' => false]);

                if (!$this->LabExaminations->save($row)) {
                    return false;
                }
            }
            return true;
        });

        $ok ? $this->Flash->success('Permintaan diproses ke daftar pemeriksaan.')
            : $this->Flash->error('Gagal memproses permintaan.');

        return $this->redirect(['action' => 'index']);
    }

    public function tindakan($id = null)
{
    if ($this->request->is('post')) {
        $data = $this->request->getData();
        // TODO: simpan header ($data) + $data['items'] + $data['inventory']
        // lalu generate lab_no (misal LAB + tanggal + urutan)
        $this->Flash->success('Tindakan laboratorium tersimpan.');
        return $this->redirect(['action' => 'index']);
    }

    // isi dropdown sesuai tabel Anda
    $this->set([
        'payMethods'         => [],
        'classes'            => [],
        'responsibleDoctors' => [],
        'senderDoctors'      => [],
        'officers'           => [],
    ]);
}
}