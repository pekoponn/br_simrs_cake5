<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Medicine Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int $medicine_merk_id
 * @property string|null $medicine_merk_name
 * @property int $medicine_group_id
 * @property string|null $medicine_group_name
 * @property string|null $code
 * @property string|null $code_kfa
 * @property string|null $name
 * @property string|null $code_ifrs
 * @property string|null $merk
 * @property string|null $type
 * @property string|null $description
 * @property string|null $img
 * @property int $qty_unit
 * @property string|null $unit
 * @property int $qty_packaging
 * @property string|null $packaging
 * @property string $cogs
 * @property int $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $is_print
 * @property \Cake\I18n\DateTime|null $printed
 * @property string|null $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\MedicineMerk $medicine_merk
 * @property \App\Model\Entity\MedicineGroup $medicine_group
 */
class Medicine extends Entity
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
        'medicine_merk_id' => true,
        'medicine_merk_name' => true,
        'medicine_group_id' => true,
        'medicine_group_name' => true,
        'code' => true,
        'code_kfa' => true,
        'name' => true,
        'code_ifrs' => true,
        'merk' => true,
        'type' => true,
        'description' => true,
        'img' => true,
        'qty_unit' => true,
        'unit' => true,
        'qty_packaging' => true,
        'packaging' => true,
        'cogs' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_print' => true,
        'printed' => true,
        'is_active' => true,
        'is_log' => true,
        'branch' => true,
        'medicine_merk' => true,
        'medicine_group' => true,
    ];
}
