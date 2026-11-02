<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LicenseAbsent Entity
 *
 * @property int $id
 * @property string $code
 * @property string|null $devision
 * @property string|null $position
 * @property \Cake\I18n\Date|null $date_from
 * @property \Cake\I18n\Date|null $date_end
 * @property string|null $type
 * @property string|null $files
 * @property string|null $description
 * @property int|null $applicant
 * @property int|null $approved
 * @property \Cake\I18n\DateTime|null $approved_date
 * @property int|null $knowing
 * @property \Cake\I18n\DateTime|null $knowing_date
 * @property string|null $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string $is_active
 * @property string|null $is_log
 */
class LicenseAbsent extends Entity
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
        'devision' => true,
        'position' => true,
        'date_from' => true,
        'date_end' => true,
        'type' => true,
        'absent_days' => true,
        'files' => true,
        'check_status' => true,
        'description' => true,
        'applicant' => true,
        'approved' => true,
        'approved_date' => true,
        'desc_approve' => true,
        'status_approve' => true,
        'knowing' => true,
        'knowing_date' => true,
        'desc_knowing' => true,
        'status_knowing' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
    ];
}
