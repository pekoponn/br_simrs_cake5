<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutpatientLetter Entity
 *
 * @property int $id
 * @property int $outpatient_visit_id
 * @property int|null $registration_id
 * @property int|null $patient_id
 * @property int|null $doctor_id
 * @property string $letter_type
 * @property string|null $letter_no
 * @property string|null $weight
 * @property string|null $height
 * @property string|null $blood_pressure
 * @property string|null $temperature
 * @property string|null $color_blind
 * @property string|null $blood_type
 * @property int|null $leave_days
 * @property \Cake\I18n\Date|null $leave_from
 * @property \Cake\I18n\Date|null $leave_to
 * @property string|null $diagnosis
 * @property string|null $notes
 * @property string|null $consultation_answer
 * @property bool|null $is_normal
 * @property \Cake\I18n\Date|null $examined_at
 *
 *
 * // Dipakai oleh Surat Kontrol BPJS (letter_type = 'kontrol_bpjs')
 * @property string|null $bpjs_card_no
 * @property int|null $referral_doctor_id
 * @property string|null $referral_doctor_name
 * @property string|null $referral_doctor_specialist
 *
 * // Dipakai oleh Surat Bukti Rawat Jalan (letter_type = 'bukti_rajal')
 * @property string|null $anamnesa
 * @property string|null $diagnosis_primary_text
 * @property string|null $diagnosis_secondary_text
 * @property string|null $action_primary_text
 * @property string|null $action_secondary_text
 * @property string|null $supporting_diagnosis
 * @property bool|null $is_autopsy
 * @property string|null $special_actions
 * @property string|null $prescription
 * @property string|null $advice_notes
 * @property int|null $discharged_by_doctor_id
 * @property int|null $completing_doctor_id
 * @property string|null $patient_or_family_name
 *
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\OutpatientVisit $outpatient_visit
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 */
class OutpatientLetter extends Entity
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
        'outpatient_visit_id' => true,
        'registration_id' => true,
        'patient_id' => true,
        'doctor_id' => true,
        'letter_type' => true,
        'letter_no' => true,
        'weight' => true,
        'height' => true,
        'blood_pressure' => true,
        'temperature' => true,
        'color_blind' => true,
        'blood_type' => true,
        'leave_days' => true,
        'leave_from' => true,
        'leave_to' => true,
        'diagnosis' => true,
        'notes' => true,
        'consultation_answer' => true,
        'is_normal' => true,
        'examined_at' => true,
        // Surat Kontrol BPJS — sebelumnya belum accessible sehingga
        // patchEntity() diam-diam membuang nilai ini saat disimpan.
        'bpjs_card_no' => true,
        'referral_doctor_id' => true,
        'referral_doctor_name' => true,
        'referral_doctor_specialist' => true,

        // Surat Bukti Rawat Jalan
        'anamnesa' => true,
        'diagnosis_primary_text' => true,
        'diagnosis_secondary_text' => true,
        'action_primary_text' => true,
        'action_secondary_text' => true,
        'supporting_diagnosis' => true,
        'is_autopsy' => true,
        'special_actions' => true,
        'prescription' => true,
        'advice_notes' => true,
        'discharged_by_doctor_id' => true,
        'completing_doctor_id' => true,
        'patient_or_family_name' => true,

        
        'created' => true,
        'modified' => true,
        'outpatient_visit' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
    ];
}
