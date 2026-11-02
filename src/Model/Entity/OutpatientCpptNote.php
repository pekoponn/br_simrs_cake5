<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutpatientCpptNote Entity
 *
 * @property int $id
 * @property int $outpatient_visit_id
 * @property int|null $registration_id
 * @property int|null $patient_id
 * @property int|null $doctor_id
 * @property \Cake\I18n\DateTime|null $noted_at
 * @property string|null $health_worker_name
 * @property string|null $doctor_name
 * @property string|null $nurse_name
 * @property string|null $assessment_text
 * @property string|null $instruction
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\OutpatientVisit $outpatient_visit
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 */
class OutpatientCpptNote extends Entity
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
        'noted_at' => true,
        'health_worker_name' => true,
        'doctor_name' => true,
        'nurse_name' => true,
        'assessment_text' => true,
        'instruction' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
        'outpatient_visit' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
    ];
}
