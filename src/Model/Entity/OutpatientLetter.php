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
 * @property \Cake\I18n\FrozenDate|null $leave_from
 * @property \Cake\I18n\FrozenDate|null $leave_to
 * @property string|null $diagnosis
 * @property string|null $notes
 * @property string|null $consultation_answer
 * @property bool|null $is_normal
 * @property \Cake\I18n\FrozenDate|null $examined_at
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
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
    protected $_accessible = [
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
        'created' => true,
        'modified' => true,
        'outpatient_visit' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
    ];
}
