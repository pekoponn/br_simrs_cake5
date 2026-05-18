<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MedicineGroup Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $type
 * @property string|null $description
 * @property string|null $img
 * @property int $qty_unit
 * @property string|null $unit
 * @property int $qty_packaging
 * @property string|null $packaging
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_print
 * @property \Cake\I18n\FrozenTime|null $printed
 * @property string|null $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Medicine[] $medicines
 */
class MedicineGroup extends Entity
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
        'name' => true,
        'type' => true,
        'description' => true,
        'img' => true,
        'qty_unit' => true,
        'unit' => true,
        'qty_packaging' => true,
        'packaging' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_print' => true,
        'printed' => true,
        'is_active' => true,
        'is_log' => true,
        'branch' => true,
        'medicines' => true,
    ];
}
