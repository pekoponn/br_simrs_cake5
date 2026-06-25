<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InpatientEntry Entity
 *
 * @property int $id
 * @property int|null $registration_id
 * @property string|null $registration_no
 * @property int|null $patient_id
 * @property string|null $patient_name
 * @property string|null $patient_rm
 * @property int|null $doctor_id
 * @property string|null $doctor_name
 * @property int|null $room_id
 * @property string|null $room_name
 * @property int|null $bed_id
 * @property string|null $bed_no
 * @property \Cake\I18n\FrozenTime|null $check_in_date
 * @property \Cake\I18n\FrozenDate|null $planned_discharge_date
 * @property \Cake\I18n\FrozenTime|null $check_out_date
 * @property string|null $notes
 * @property string $status
 * @property bool $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\Bed $bed
 */
class InpatientEntry extends Entity
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
        'patient_name' => true,
        'patient_rm' => true,
        'doctor_id' => true,
        'doctor_name' => true,
        'room_id' => true,
        'room_name' => true,
        'bed_id' => true,
        'bed_no' => true,
        'check_in_date' => true,
        'planned_discharge_date' => true,
        'check_out_date' => true,
        'notes' => true,
        'status' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
        'room' => true,
        'bed' => true,
    ];
}
