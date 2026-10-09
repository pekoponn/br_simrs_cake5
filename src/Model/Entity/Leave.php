<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Leave Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string $code
 * @property string|null $devision
 * @property string|null $position
 * @property \Cake\I18n\FrozenDate|null $date_from
 * @property \Cake\I18n\FrozenDate|null $date_end
 * @property string|null $type
 * @property int|null $leave_days
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
class Leave extends Entity
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
        'code' => true,
        'devision' => true,
        'position' => true,
        'date_from' => true,
        'date_end' => true,
        'date_1' => true,
        'date_2' => true,
        'date_3' => true,
        'type' => true,
        'leave_days' => true,
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
        'is_cancel' => true,
        'canceled' => true,
        'cancel_reason' => true,
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
