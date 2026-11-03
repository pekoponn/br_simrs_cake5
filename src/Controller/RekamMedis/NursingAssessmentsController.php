<?php
declare(strict_types=1);

namespace App\Controller\RekamMedis;

use App\Controller\AppController;

class NursingAssessmentsController extends AppController
{
    public function add()
    {
        $this->request->allowMethod(['post']);
        $this->EmergencyNursingAssessments = $this->fetchTable('EmergencyNursingAssessments');
        $this->Registrations = $this->fetchTable('Registrations');
        $this->MasterTenagaMedis = $this->fetchTable('MasterTenagaMedis');

        $data = $this->request->getData();
        $registrationId = (int)($data['registration_id'] ?? 0);

        if (!$registrationId) {
            return $this->response->withType('application/json')->withStringBody(
                json_encode(['success' => false, 'message' => 'registration_id kosong.'])
            );
        }

        $registration = $this->Registrations->find()
            ->where(['id' => $registrationId])
            ->first();

        if (!$registration) {
            return $this->response->withType('application/json')->withStringBody(
                json_encode(['success' => false, 'message' => 'Registrasi tidak ditemukan.'])
            );
        }

        $nurseId = !empty($data['nurse_id']) ? (int)$data['nurse_id'] : null;
        $nurseName = null;
        if ($nurseId) {
            $nurse = $this->MasterTenagaMedis->find()->where(['id' => $nurseId])->first();
            $nurseName = $nurse->nama ?? null;
        }

        $fallIntervention = implode(',', (array)($data['fall_intervention'] ?? []));

        $assessment = $this->EmergencyNursingAssessments->newEntity([
            'registration_id' => $registrationId,
            'patient_id' => $registration->patient_id ?? null,
            'nurse_id' => $nurseId,
            'nurse_name' => $nurseName,
            'info_type' => $data['info_type'] ?? null,
            'info_name' => $data['info_name'] ?? null,
            'info_relation' => $data['info_relation'] ?? null,
            'admission_mode' => $data['admission_mode'] ?? null,
            'admission_origin' => $data['admission_origin'] ?? null,
            'current_illness_history' => $data['current_illness_history'] ?? null,
            'past_illness_history' => $data['past_illness_history'] ?? null,
            'previous_treatment_history' => $data['previous_treatment_history'] ?? null,
            'weight' => $data['weight'] ?? null,
            'height' => $data['height'] ?? null,
            'pain_scale' => $data['pain_scale'] ?? 0,
            'pain_frequency' => $data['pain_frequency'] ?? null,
            'pain_duration' => $data['pain_duration'] ?? null,
            'pain_radiating' => $data['pain_radiating'] ?? null,
            'pain_radiating_to' => $data['pain_radiating_to'] ?? null,
            'pain_quality' => $data['pain_quality'] ?? null,
            'pain_trigger_factor' => $data['pain_trigger_factor'] ?? null,
            'pain_relieving_factor' => $data['pain_relieving_factor'] ?? null,
            'daily_activity' => $data['daily_activity'] ?? null,
            'fall_risk_recent' => $data['fall_risk_recent'] ?? null,
            'fall_risk_device' => $data['fall_risk_device'] ?? null,
            'fall_risk_walk_difficulty' => $data['fall_risk_walk_difficulty'] ?? null,
            'fall_intervention' => $fallIntervention,
            'decubitus_wheelchair' => $data['decubitus_wheelchair'] ?? null,
            'decubitus_incontinence' => $data['decubitus_incontinence'] ?? null,
            'decubitus_history' => $data['decubitus_history'] ?? null,
            'decubitus_over_65' => $data['decubitus_over_65'] ?? null,
            'decubitus_extremity_mismatch' => $data['decubitus_extremity_mismatch'] ?? null,
            'decubitus_education' => $data['decubitus_education'] ?? null,
            'status' => 'aktif',
            'is_active' => 1,
        ]);

        if ($this->EmergencyNursingAssessments->save($assessment)) {
            return $this->response->withType('application/json')->withStringBody(
                json_encode(['success' => true, 'id' => $assessment->id])
            );
        }

        return $this->response->withType('application/json')->withStringBody(
            json_encode(['success' => false, 'message' => 'Gagal menyimpan.', 'errors' => $assessment->getErrors()])
        );
    }

    public function get($registrationId = null)
    {
        $this->request->allowMethod(['get']);
        $this->EmergencyNursingAssessments = $this->fetchTable('EmergencyNursingAssessments');

        $assessment = $this->EmergencyNursingAssessments->find()
            ->where([
                'registration_id' => (int)$registrationId,
                'is_active' => 1,
            ])
            ->order(['created' => 'DESC'])
            ->first();

        if (!$assessment) {
            return $this->response->withType('application/json')->withStringBody(
                json_encode(['success' => true, 'data' => null])
            );
        }

        return $this->response->withType('application/json')->withStringBody(
            json_encode(['success' => true, 'data' => $assessment])
        );
    }
}