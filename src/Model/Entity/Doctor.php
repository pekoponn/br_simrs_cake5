<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Doctor Entity
 *
 * @property int $id
 * @property string $code
 * @property string $region
 * @property string $nik_login
 * @property string $nik
 * @property string $doctor_name
 * @property string $specialist
 * @property string $polyclinic_name
 * @property string $religion
 * @property string $sip_number
 * @property string $str_number
 * @property \Cake\I18n\Date $str_issue_date
 * @property string $str_expiry_date
 * @property string $phone_number
 * @property string|null $address
 * @property string|null $gender
 * @property int $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 *
 * @property \App\Model\Entity\DoctorSchedule[] $doctor_schedules
 */
class Doctor extends Entity
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
        'region' => true,
        'nik_login' => true,
        'nik' => true,
        'doctor_name' => true,
        'specialist' => true,
        'polyclinic_name' => true,
        'religion' => true,
        'sip_number' => true,
        'str_number' => true,
        'str_issue_date' => true,
        'str_expiry_date' => true,
        'phone_number' => true,
        'address' => true,
        'gender' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'doctor_schedules' => true,
    ];
}
