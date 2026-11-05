<?php
declare(strict_types=1);

namespace App\Controller\Penunjang;

use App\Controller\AppController;

/**
 * History Pemeriksaan Pasien (Laboratorium).
 *
 * Key hak akses (users/access): labhistories -> index, searchPatient, detail
 */
class LabHistoriesController extends AppController
{
    public function index()
    {
    }

    /**
     * AJAX: data pasien + daftar pemeriksaannya berdasarkan No. Rekam Medis.
     */
    public function searchPatient()
    {
        $this->request->allowMethod(['get']);

        $rm = trim((string)$this->request->getQuery('rm'));
        if ($rm === '') {
            return $this->json(['ok' => false, 'message' => 'Isi nomor rekam medis terlebih dahulu.']);
        }

        $exams = $this->fetchTable('LabExaminations')->find()
            ->where(['medical_record_no' => $rm])
            ->orderBy(['received_at' => 'DESC', 'id' => 'DESC'])
            ->all();

        $first = $exams->first();
        $patient = $this->findPatient($rm, $first);

        if ($first === null && $patient['name'] === '') {
            return $this->json(['ok' => false, 'message' => 'Pasien dengan rekam medis ' . $rm . ' tidak ditemukan.']);
        }

        $list = [];
        foreach ($exams as $e) {
            $list[] = [
                'id' => (int)$e->id,
                'lab_no' => (string)$e->lab_no,
                'name' => (string)$e->examination_name,
                'date' => $e->received_at ? $e->received_at->format('d-m-Y H:i') : '-',
            ];
        }

        return $this->json(['ok' => true, 'patient' => $patient, 'exams' => $list]);
    }

    /**
     * AJAX: hasil (parameter) dan catatan satu pemeriksaan.
     */
    public function detail($id = null)
    {
        $this->request->allowMethod(['get']);

        $exam = $this->fetchTable('LabExaminations')->find()->where(['id' => (int)$id])->first();
        if ($exam === null) {
            return $this->json(['ok' => false, 'message' => 'Pemeriksaan tidak ditemukan.']);
        }

        $rows = $this->fetchTable('LabExaminationResults')->find()
            ->where(['lab_examination_id' => (int)$id])
            ->orderBy(['sort_order' => 'ASC', 'id' => 'ASC'])
            ->all();

        $results = [];
        foreach ($rows as $r) {
            $results[] = [
                'parameter' => (string)$r->parameter_name,
                'result' => (string)$r->result,
                'unit' => (string)$r->unit,
                'reference' => (string)$r->reference_range,
                'remarks' => (string)$r->remarks,
            ];
        }

        return $this->json([
            'ok' => true,
            'note' => (string)($exam->note ?? ''),
            'results' => $results,
        ]);
    }

    /**
     * Data pasien. SESUAIKAN nama tabel/kolom di bawah dengan tabel pasien Anda.
     * Asumsi: tabel Patients dengan kolom medical_record_no, name, birth_date, gender, address.
     * Jika tabel itu tidak ada, nama diambil dari data pemeriksaan terakhir.
     */
    private function findPatient(string $rm, $firstExam): array
    {
        $info = [
            'name' => $firstExam ? (string)$firstExam->patient_name : '',
            'birth_date' => '',
            'gender' => '',
            'address' => '',
        ];

        try {
            $p = $this->fetchTable('Patients')->find()->where(['medical_record_no' => $rm])->first();
            if ($p) {
                $info['name'] = (string)($p->name ?? $info['name']);
                $bd = $p->birth_date ?? null;
                $info['birth_date'] = $bd instanceof \DateTimeInterface ? $bd->format('d-m-Y') : (string)$bd;
                $g = strtoupper(substr((string)($p->gender ?? ''), 0, 1));
                $info['gender'] = in_array($g, ['L', 'M'], true) ? 'L' : (in_array($g, ['P', 'F', 'W'], true) ? 'P' : '');
                $info['address'] = (string)($p->address ?? '');
            }
        } catch (\Throwable $e) {
            // tabel pasien tidak tersedia: pakai data dari pemeriksaan
        }

        return $info;
    }

    private function json(array $data)
    {
        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE));
    }
}