<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WorkOrderLine Entity
 *
 * @property int $id
 * @property int $work_order_id
 * @property int $user_id
 * @property string|null $time_from
 * @property string|null $time_end
 * @property string|null $task
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
 * @property \App\Model\Entity\WorkOrder $work_order
 * @property \App\Model\Entity\User $user
 */
class WorkOrderLine extends Entity
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
        'work_order_id' => true,
        'user_id' => true,
        'time_from' => true,
        'time_end' => true,
        'task' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'is_log' => true,
        'work_order' => true,
        'user' => true,
    ];
}
