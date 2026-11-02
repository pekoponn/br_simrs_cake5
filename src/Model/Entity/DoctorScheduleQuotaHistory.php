<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DoctorScheduleQuotaHistory Entity
 *
 * @property int $id
 * @property int $doctor_schedule_id
 * @property \Cake\I18n\Date $cycle_date
 * @property int $quota
 * @property int $quota_used
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\DoctorSchedule $doctor_schedule
 */
class DoctorScheduleQuotaHistory extends Entity
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
        'doctor_schedule_id' => true,
        'cycle_date' => true,
        'quota' => true,
        'quota_used' => true,
        'created' => true,
        'modified' => true,
        'doctor_schedule' => true,
    ];
}
