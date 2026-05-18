<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PolyclinicQueue Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $source
 * @property string|null $poly_name
 * @property string|null $patients_name
 * @property string|null $no_telp
 * @property int|null $queue_number
 * @property int|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $delete_log
 * @property string|null $is_active
 */
class PolyclinicQueue extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'code' => true,
        'source' => true,
        'poly_name' => true,
        'patients_name' => true,
        'no_telp' => true,
        'queue_number' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
    ];
}