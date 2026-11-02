<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmergencyEntry Entity
 *
 * @property int $id
 * @property int|null $registration_id
 * @property string|null $registration_no
 * @property int|null $patient_id
 * @property string|null $patient_rm
 * @property string|null $patient_name
 * @property int|null $doctor_id
 * @property string|null $doctor_name
 * @property int|null $nurse_id
 * @property string|null $nurse_name
 * @property string|null $allergy_status
 * @property string|null $allergy_detail
 * @property string|null $perilaku
 * @property int|null $gcs_e
 * @property int|null $gcs_v
 * @property int|null $gcs_m
 * @property string|null $pupil_kanan
 * @property string|null $pupil_kiri
 * @property string|null $reflex_kanan
 * @property string|null $reflex_kiri
 * @property string|null $nadi_jenis
 * @property string|null $akral
 * @property int|null $pain_scale
 * @property int|null $flacc_wajah
 * @property int|null $flacc_kaki
 * @property int|null $flacc_aktifitas
 * @property int|null $flacc_menangis
 * @property int|null $flacc_bersuara
 * @property int|null $flacc_total
 * @property \Cake\I18n\Date|null $service_date
 * @property \Cake\I18n\Time|null $service_time
 * @property string|null $chief_complaint
 * @property string|null $triage_category
 * @property string|null $triage_notes
 * @property string|null $blood_pressure
 * @property string|null $temperature
 * @property string|null $pulse
 * @property string|null $respiration
 * @property string|null $spo2
 * @property string|null $diagnosis
 * @property string|null $notes
 * @property string $status
 * @property bool $is_active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 */
class EmergencyEntry extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        'registration_id' => true,
        'registration_no' => true,
        'triase_no' => true,
        'patient_id' => true,
        'patient_rm' => true,
        'patient_name' => true,
        'doctor_id' => true,
        'doctor_name' => true,
        'nurse_id' => true,
        'nurse_name' => true,
        'allergy_status' => true,
        'allergy_detail' => true,
        'perilaku' => true,
        'gcs_e' => true,
        'gcs_v' => true,
        'gcs_m' => true,
        'pupil_kanan' => true,
        'pupil_kiri' => true,
        'reflex_kanan' => true,
        'reflex_kiri' => true,
        'nadi_jenis' => true,
        'akral' => true,
        'pain_scale' => true,
        'flacc_wajah' => true,
        'flacc_kaki' => true,
        'flacc_aktifitas' => true,
        'flacc_menangis' => true,
        'flacc_bersuara' => true,
        'flacc_total' => true,
        'service_date' => true,
        'service_time' => true,
        'chief_complaint' => true,
        'triage_category' => true,
        'triage_notes' => true,
        'blood_pressure' => true,
        'temperature' => true,
        'pulse' => true,
        'respiration' => true,
        'spo2' => true,
        'diagnosis' => true,
        'notes' => true,
        'status' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
        'master_tenaga_medi' => true,
    ];
}