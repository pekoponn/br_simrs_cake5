<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutpatientVisit Entity
 *
 * @property int $id
 * @property int $registration_id
 * @property string $registration_no
 * @property int $patient_id
 * @property int|null $doctor_id
 * @property int|null $queue_id
 * @property int|null $queue_number
 * @property string|null $polyclinic_name
 * @property \Cake\I18n\FrozenDate $visit_date
 * @property \Cake\I18n\Time|null $visit_time
 * @property string $status
 * @property \Cake\I18n\FrozenTime|null $called_at
 * @property \Cake\I18n\FrozenTime|null $start_time
 * @property \Cake\I18n\FrozenTime|null $end_time
 * @property string|null $blood_pressure
 * @property int|null $pulse
 * @property string|null $temperature
 * @property int|null $respiratory_rate
 * @property int|null $oxygen_saturation
 * @property string|null $weight
 * @property string|null $height
 * @property string|null $bmi
 * @property string|null $chief_complaint
 * @property string|null $illness_history
 * @property string|null $admission_diagnosis
 * @property string|null $allergy
 * @property int|null $pain_scale
 * @property string|null $diagnosis_primary
 * @property string|null $diagnosis_secondary
 * @property string|null $diagnosis_desc
 * @property string|null $action_notes
 * @property string|null $doctor_notes
 * @property string|null $prescription_notes
 * @property \Cake\I18n\FrozenDate|null $follow_up_date
 * @property string|null $referral_to
 * @property string|null $referral_reason
 * @property string|null $payment_method
 * @property string $total_fee
 * @property bool $paid
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\OutpatientAction[] $outpatient_actions
 */
class OutpatientVisit extends Entity
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
    protected $_accessible = [
        'registration_id' => true,
        'registration_no' => true,
        'patient_id' => true,
        'doctor_id' => true,
        'queue_id' => true,
        'queue_number' => true,
        'polyclinic_name' => true,
        'visit_date' => true,
        'visit_time' => true,
        'status' => true,
        'called_at' => true,
        'start_time' => true,
        'end_time' => true,
        'blood_pressure' => true,
        'pulse' => true,
        'temperature' => true,
        'respiratory_rate' => true,
        'oxygen_saturation' => true,
        'weight' => true,
        'height' => true,
        'bmi' => true,
        'chief_complaint' => true,
        'illness_history' => true,
        'admission_diagnosis' => true,
        'allergy' => true,
        'pain_scale' => true,
        'diagnosis_primary' => true,
        'diagnosis_secondary' => true,
        'diagnosis_desc' => true,
        'action_notes' => true,
        'doctor_notes' => true,
        'prescription_notes' => true,
        'follow_up_date' => true,
        'referral_to' => true,
        'referral_reason' => true,
        'payment_method' => true,
        'total_fee' => true,
        'paid' => true,
        'created_by' => true,
        'updated_by' => true,
        'created' => true,
        'modified' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
        'outpatient_actions' => true,
    ];
}
