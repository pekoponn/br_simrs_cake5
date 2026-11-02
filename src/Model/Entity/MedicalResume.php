<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MedicalResume Entity
 *
 * @property int $id
 * @property int $outpatient_visit_id
 * @property int|null $registration_id
 * @property int|null $patient_id
 * @property int|null $doctor1_id
 * @property string|null $doctor2_name
 * @property string|null $doctor3_name
 * @property string|null $doctor4_name
 * @property string|null $doctor5_name
 * @property string|null $consultant1_name
 * @property string|null $consultant2_name
 * @property string|null $sender_name
 * @property \Cake\I18n\Date|null $planned_discharge_date
 * @property string|null $risk_note
 * @property string|null $summary_history
 * @property string|null $inpatient_indication
 * @property string|null $physical_exam
 * @property string|null $supporting_exam
 * @property string|null $therapy_during_treatment
 * @property string|null $consultation_result
 * @property string|null $admission_diagnosis
 * @property string|null $lab_unfinished
 * @property string|null $diet
 * @property string|null $education_instruction
 * @property string|null $primary_diagnosis
 * @property string|null $secondary_diagnosis
 * @property string|null $medical_action
 * @property string|null $condition_on_discharge
 * @property string|null $prognosis
 * @property string|null $letter_type
 * @property string|null $follow_up_treatment
 * @property \Cake\I18n\Date|null $control_date
 * @property string|null $control_note
 * @property string|null $control_plan
 * @property string|null $return_reason
 * @property bool $print_classic
 * @property bool $send_digital_claim
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\OutpatientVisit $outpatient_visit
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 */
class MedicalResume extends Entity
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
        'doctor1_id' => true,
        'doctor2_name' => true,
        'doctor3_name' => true,
        'doctor4_name' => true,
        'doctor5_name' => true,
        'consultant1_name' => true,
        'consultant2_name' => true,
        'sender_name' => true,
        'planned_discharge_date' => true,
        'risk_note' => true,
        'summary_history' => true,
        'inpatient_indication' => true,
        'physical_exam' => true,
        'supporting_exam' => true,
        'therapy_during_treatment' => true,
        'consultation_result' => true,
        'admission_diagnosis' => true,
        'lab_unfinished' => true,
        'diet' => true,
        'education_instruction' => true,
        'primary_diagnosis' => true,
        'secondary_diagnosis' => true,
        'medical_action' => true,
        'condition_on_discharge' => true,
        'prognosis' => true,
        'follow_up_treatment' => true,
        'control_date' => true,
        'control_note' => true,
        'control_plan' => true,
        'return_reason' => true,
        'print_classic' => true,
        'send_digital_claim' => true,
        'created' => true,
        'modified' => true,
        'outpatient_visit' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
        'letter_type' => true,
    ];
}