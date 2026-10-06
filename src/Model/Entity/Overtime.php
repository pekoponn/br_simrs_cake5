<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Overtime Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string $code
 * @property string|null $devision
 * @property string|null $position
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $time_from
 * @property string|null $time_end
 * @property string|null $description
 * @property int|null $applicant
 * @property int|null $approved
 * @property \Cake\I18n\FrozenTime|null $approved_date
 * @property int|null $knowing
 * @property \Cake\I18n\FrozenTime|null $knowing_date
 * @property string|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Branch $branch
 */
class Overtime extends Entity
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
        'branch_id' => true,
        'work_order_id' => true,
        'code' => true,
        'devision' => true,
        'position' => true,
        'date' => true,
        'time_from' => true,
        'time_end' => true,
        'description' => true,
        'knowing_description' => true,
        'approved_description' => true,
        'time_from_approve' => true,
        'time_end_approve' => true,
        'applicant' => true,
        'approved' => true,
        'status_approve' => true,
        'approved_date' => true,
        'knowing' => true,
        'status_knowing' => true,
        'knowing_date' => true,
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
