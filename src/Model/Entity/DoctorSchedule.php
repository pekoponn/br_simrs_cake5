<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DoctorSchedule Entity
 *
 * @property int $id
 * @property string $code
 * @property int $doctor_id
 * @property string $day
 * @property \Cake\I18n\Time $start_time
 * @property \Cake\I18n\Time $end_time
 * @property int|null $quota
 * @property string|null $note
 * @property int|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $delete_log
 * @property string|null $is_active
 *
 * @property \App\Model\Entity\Doctor $doctor
 */
class DoctorSchedule extends Entity
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
        'code' => true,
        'doctor_id' => true,
        'day' => true,
        'start_time' => true,
        'end_time' => true,
        'quota' => true,
        'quota_used' => true,
        'estimated_minutes' => true,
        'note' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'doctor' => true,
    ];
}
