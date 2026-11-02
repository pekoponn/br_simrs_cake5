<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bed Entity
 *
 * @property int $id
 * @property string $code
 * @property int $room_id
 * @property string $bed_no
 * @property string $name
 * @property string $class_name
 * @property int $status
 * @property string $is_active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\DateTime|null $check_in_date
 * @property \Cake\I18n\DateTime|null $check_out_date
 * @property string|null $patient_name
 * @property int|null $patient_id
 * @property string|null $notes_patient
 * @property string|null $notes
 *
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\Patient|null $patient
 */
class Bed extends Entity
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
        'code' => true,
        'room_id' => true,
        'bed_no' => true,
        'name' => true,
        'class_name' => true,
        'status' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'is_delete' => true,
        'patient_id' => true,
        'patient_name' => true,
        'check_in_date' => true,
        'check_out_date' => true,
        'notes_patient' => true,
        'notes' => true,
        'room' => true,
        'patient' => true,
    ];
}
