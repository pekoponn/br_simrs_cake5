<?php
declare(strict_types=1);

namespace App\Controller;

class TriageEntriesController extends AppController
{
    public function add()
    {
        $this->request->allowMethod(['post']);
        $this->EmergencyEntries = $this->fetchTable('EmergencyEntries');
        $this->Registrations = $this->fetchTable('Registrations');
        $this->Doctors = $this->fetchTable('Doctors');
        $this->MasterTenagaMedis = $this->fetchTable('MasterTenagaMedis');

        $data = $this->request->getData();

        $registrationId = (int)($data['registration_id'] ?? 0);
        if (!$registrationId) {
            return $this->response->withType('application/json')->withStringBody(
                json_encode(['success' => false, 'message' => 'registration_id kosong.'])
            );
        }

        $registration = $this->Registrations->find()
            ->contain(['Patients'])
            ->where(['Registrations.id' => $registrationId])
            ->first();

        if (!$registration) {
            return $this->response->withType('application/json')->withStringBody(
                json_encode(['success' => false, 'message' => 'Registrasi tidak ditemukan.'])
            );
        }

        $doctorId = !empty($data['doctor_name']) ? (int)$data['doctor_name'] : null;
        $doctorName = null;
        if ($doctorId) {
            $doctor = $this->Doctors->find()->where(['id' => $doctorId])->first();
            $doctorName = $doctor->doctor_name ?? null;
        }

        $nurseId = !empty($data['triage_nurse']) ? (int)$data['triage_nurse'] : null;
        $nurseName = null;
        if ($nurseId) {
            $nurse = $this->MasterTenagaMedis->find()->where(['id' => $nurseId])->first();
            $nurseName = $nurse->nama ?? null;
        }

        $perilaku = $data['perilaku'] ?? [];
        $flacc = $data['flacc'] ?? [];

        $flaccTotal = 0;
        foreach (['wajah', 'kaki', 'aktifitas', 'menangis', 'bersuara'] as $key) {
            $flaccTotal += (int)($flacc[$key] ?? 0);
        }

        $bloodPressure = null;
        if (!empty($data['td_sistol']) || !empty($data['td_diastol'])) {
            $bloodPressure = ($data['td_sistol'] ?? '-') . '/' . ($data['td_diastol'] ?? '-');
        }

        // Hitung urutan ke berapa triase ini untuk registrasi yang sama (untuk re-assessment berulang).
        $existingCount = $this->EmergencyEntries->find()
            ->where(['registration_id' => $registrationId])
            ->count();

        $triaseNo = ($registration->registration_no ?? 'TRI') . '-T' . ($existingCount + 1);

        $entry = $this->EmergencyEntries->newEntity([
            'registration_id'  => $registrationId,
            'registration_no'  => $registration->registration_no ?? null,
            'triase_no'        => $triaseNo,
            'patient_id'       => $registration->patient_id ?? null,
            'patient_rm'       => $registration->patient->code ?? null,
            'patient_name'     => $registration->patient->full_name ?? null,
            'doctor_id'        => $doctorId,
            'doctor_name'      => $doctorName,
            'nurse_id'         => $nurseId,
            'nurse_name'       => $nurseName,
            'service_date'     => date('Y-m-d'),
            'service_time'     => date('H:i:s'),
            'chief_complaint'  => $data['chief_complaint'] ?? null,
            'triage_category'  => $data['triage_category'] ?? null,
            'triage_notes'     => $data['triage_notes'] ?? null,
            'allergy_status'   => $data['allergy_status'] ?? 'tidak',
            'allergy_detail'   => $data['allergy_detail'] ?? null,
            'perilaku'         => implode(',', (array)$perilaku),
            'gcs_e'            => $data['gcs_e'] ?? null,
            'gcs_v'            => $data['gcs_v'] ?? null,
            'gcs_m'            => $data['gcs_m'] ?? null,
            'pupil_kanan'      => $data['pupil_kanan'] ?? null,
            'pupil_kiri'       => $data['pupil_kiri'] ?? null,
            'reflex_kanan'     => $data['reflex_kanan'] ?? null,
            'reflex_kiri'      => $data['reflex_kiri'] ?? null,
            'blood_pressure'   => $bloodPressure,
            'temperature'      => $data['temperature'] ?? null,
            'pulse'            => $data['pulse'] ?? null,
            'nadi_jenis'       => $data['nadi_jenis'] ?? 'reguler',
            'akral'            => $data['akral'] ?? null,
            'pain_scale'       => $data['pain_scale'] ?? 0,
            'respiration'      => $data['respiratory_rate'] ?? null,
            'spo2'             => $data['oxygen_saturation'] ?? null,
            'flacc_wajah'      => $flacc['wajah'] ?? 0,
            'flacc_kaki'       => $flacc['kaki'] ?? 0,
            'flacc_aktifitas'  => $flacc['aktifitas'] ?? 0,
            'flacc_menangis'   => $flacc['menangis'] ?? 0,
            'flacc_bersuara'   => $flacc['bersuara'] ?? 0,
            'flacc_total'      => $flaccTotal,
            'status'           => 'waiting',
            'is_active'        => 1,
            'created'          => date('Y-m-d H:i:s'),
            'modified'         => date('Y-m-d H:i:s'),
        ]);

        if ($this->EmergencyEntries->save($entry)) {
            return $this->response->withType('application/json')->withStringBody(
                json_encode(['success' => true, 'id' => $entry->id, 'triase_no' => $entry->triase_no])
            );
        }

        return $this->response->withType('application/json')->withStringBody(
            json_encode(['success' => false, 'message' => 'Gagal menyimpan.', 'errors' => $entry->getErrors()])
        );
    }

    public function history($registrationId = null)
    {
        $this->request->allowMethod(['get']);
        $this->EmergencyEntries = $this->fetchTable('EmergencyEntries');

        $entries = $this->EmergencyEntries->find()
            ->where([
                'EmergencyEntries.registration_id' => (int)$registrationId,
                'EmergencyEntries.is_active' => 1,
            ])
            ->order(['EmergencyEntries.created' => 'DESC'])
            ->all();

        $result = [];
        foreach ($entries as $e) {
            $result[] = [
                'id'          => $e->id,
                'triase_no'   => $e->triase_no,
                'tanggal'     => $e->service_date . ' ' . $e->service_time,
                'kategori'    => $e->triage_category,
                'keluhan'     => $e->chief_complaint,
                'dokter'      => $e->doctor_name ?? '-',
                'perawat'     => $e->nurse_name ?? '-',
                'nadi'        => $e->pulse,
                'td'          => $e->blood_pressure,
                'suhu'        => $e->temperature,
                'spo2'        => $e->spo2,
                'pain_scale'  => $e->pain_scale,
                'flacc_total' => $e->flacc_total,
            ];
        }

        return $this->response->withType('application/json')->withStringBody(
            json_encode(['success' => true, 'data' => $result])
        );
    }
}