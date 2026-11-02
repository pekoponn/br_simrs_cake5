<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LicenseEarlyLeave Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string $code
 * @property string|null $devision
 * @property string|null $position
 * @property \Cake\I18n\Date|null $date
 * @property string|null $time_from
 * @property string|null $type
 * @property string|null $files
 * @property string|null $description
 * @property int|null $is_approved
 * @property \Cake\I18n\DateTime|null $approved
 * @property int|null $is_knowing
 * @property \Cake\I18n\DateTime|null $knowing
 * @property string|null $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Branch $branch
 */
class LicenseEarlyLeave extends Entity
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
        'branch_id' => true,
        'code' => true,
        'devision' => true,
        'position' => true,
        'date' => true,
        'time_from' => true,
        'type' => true,
        'files' => true,
        'description' => true,
        'is_approved' => true,
        'approved' => true,
        'desc_approve' => true,
        'status_approve' => true,
        'is_knowing' => true,
        'knowing' => true,
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
        'branch' => true,
    ];
}
