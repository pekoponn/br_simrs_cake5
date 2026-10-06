<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmergencyNursingAssessment Entity
 *
 * @property int $id
 * @property int $registration_id
 * @property int|null $patient_id
 * @property int|null $nurse_id
 * @property string|null $nurse_name
 * @property string|null $info_type
 * @property string|null $info_name
 * @property string|null $info_relation
 * @property string|null $admission_mode
 * @property string|null $admission_origin
 * @property string|null $current_illness_history
 * @property string|null $past_illness_history
 * @property string|null $previous_treatment_history
 * @property string|null $weight
 * @property string|null $height
 * @property int|null $pain_scale
 * @property string|null $pain_frequency
 * @property string|null $pain_duration
 * @property string|null $pain_radiating
 * @property string|null $pain_radiating_to
 * @property string|null $pain_quality
 * @property string|null $pain_trigger_factor
 * @property string|null $pain_relieving_factor
 * @property string|null $daily_activity
 * @property string|null $fall_risk_recent
 * @property string|null $fall_risk_device
 * @property string|null $fall_risk_walk_difficulty
 * @property string|null $fall_intervention
 * @property string|null $decubitus_wheelchair
 * @property string|null $decubitus_incontinence
 * @property string|null $decubitus_history
 * @property string|null $decubitus_over_65
 * @property string|null $decubitus_extremity_mismatch
 * @property string|null $decubitus_education
 * @property string|null $status
 * @property bool|null $is_active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Nurse $nurse
 */
class EmergencyNursingAssessment extends Entity
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
        'patient_id' => true,
        'nurse_id' => true,
        'nurse_name' => true,
        'info_type' => true,
        'info_name' => true,
        'info_relation' => true,
        'admission_mode' => true,
        'admission_origin' => true,
        'current_illness_history' => true,
        'past_illness_history' => true,
        'previous_treatment_history' => true,
        'weight' => true,
        'height' => true,
        'pain_scale' => true,
        'pain_frequency' => true,
        'pain_duration' => true,
        'pain_radiating' => true,
        'pain_radiating_to' => true,
        'pain_quality' => true,
        'pain_trigger_factor' => true,
        'pain_relieving_factor' => true,
        'daily_activity' => true,
        'fall_risk_recent' => true,
        'fall_risk_device' => true,
        'fall_risk_walk_difficulty' => true,
        'fall_intervention' => true,
        'decubitus_wheelchair' => true,
        'decubitus_incontinence' => true,
        'decubitus_history' => true,
        'decubitus_over_65' => true,
        'decubitus_extremity_mismatch' => true,
        'decubitus_education' => true,
        'status' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'registration' => true,
        'patient' => true,
        'nurse' => true,
    ];
}