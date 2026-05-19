<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bed Entity
 *
 * @property int $id
 * @property string $code
 * @property string $room_id
 * @property string $bed_no
 * @property string $name
 * @property string $class_name
 * @property string $status
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 *
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\Registration[] $registrations
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
    protected $_accessible = [
        'code' => true,
        'room_id' => true,
        'bed_no' => true,
        'name' => true,
        'class_name' => true,
        'status' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'room' => true,
        'registrations' => true,
    ];
}
