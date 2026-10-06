<?php
declare(strict_types=1);

namespace App\Controller;

class LabRoResultsController extends AppController
{
    public function get($registrationId = null)
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $jenis = (string)$this->request->getQuery('jenis', 'laboratorium');
        $data = [];

        try {
            if ($jenis === 'laboratorium') {
                $this->loadModel('LaboratoryTransactions');
                $rows = $this->LaboratoryTransactions->find()
                    ->contain(['Doctors'])
                    ->where(['LaboratoryTransactions.registration_id' => (int)$registrationId])
                    ->order(['LaboratoryTransactions.id' => 'DESC'])
                    ->all();

                foreach ($rows as $row) {
                    $data[] = [
                        'no_pemeriksaan' => $row->transaction_no ?? $row->id,
                        'tanggal' => !empty($row->created)
                            ? (is_object($row->created) ? $row->created->format('d-m-Y H:i') : (string)$row->created)
                            : '-',
                        'hasil' => $row->result ?? $row->result_notes ?? '-',
                        'dokter' => $row->doctor->doctor_name ?? '-',
                    ];
                }
            } elseif ($jenis === 'radiologi') {
                $this->loadModel('RadiologyTransactions');
                $rows = $this->RadiologyTransactions->find()
                    ->contain(['Doctors'])
                    ->where(['RadiologyTransactions.registration_id' => (int)$registrationId])
                    ->order(['RadiologyTransactions.id' => 'DESC'])
                    ->all();

                foreach ($rows as $row) {
                    $data[] = [
                        'no_pemeriksaan' => $row->transaction_no ?? $row->id,
                        'tanggal' => !empty($row->created)
                            ? (is_object($row->created) ? $row->created->format('d-m-Y H:i') : (string)$row->created)
                            : '-',
                        'hasil' => $row->result ?? $row->result_notes ?? '-',
                        'dokter' => $row->doctor->doctor_name ?? '-',
                    ];
                }
            }
            // 'penunjang' sengaja dikosongkan dulu, belum ada tabel sumbernya
        } catch (\Throwable $e) {
            $data = [];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'data' => $data]));
    }
}