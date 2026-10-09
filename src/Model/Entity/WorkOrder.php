<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WorkOrder Entity
 *
 * @property int $id
 * @property string|null $business_unit
 * @property string|null $devision
 * @property string|null $code
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $description
 * @property int $is_approve
 * @property string|null $status_approve
 * @property \Cake\I18n\FrozenTime|null $approved
 * @property int $is_cancel
 * @property \Cake\I18n\FrozenTime|null $canceled
 * @property string|null $cancel_reason
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Overtime[] $overtimes
 * @property \App\Model\Entity\WorkOrderLine[] $work_order_lines
 */
class WorkOrder extends Entity
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
        'business_unit' => true,
        'devision' => true,
        'code' => true,
        'date' => true,
        'description' => true,
        'is_approve' => true,
        'status_approve' => true,
        'approved' => true,
        'is_cancel' => true,
        'canceled' => true,
        'cancel_reason' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'is_log' => true,
        'overtimes' => true,
        'work_order_lines' => true,
    ];
}
