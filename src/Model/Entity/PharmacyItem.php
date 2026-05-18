<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PharmacyItem Entity
 *
 * @property int $id
 * @property string $code
 * @property string $region
 * @property string $type
 * @property string $name
 * @property string $purchase_unit
 * @property string $sale_unit
 * @property string|null $qjb
 * @property string $therapy_class
 * @property string $group_name
 * @property string $producer
 * @property string $medicine_type
 * @property string|null $cbg_rate
 * @property string $formula_name
 * @property string|null $formula_percentage
 * @property string|null $hpp
 * @property string|null $sale_price
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 */
class PharmacyItem extends Entity
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
        'region' => true,
        'type' => true,
        'name' => true,
        'purchase_unit' => true,
        'sale_unit' => true,
        'qjb' => true,
        'therapy_class' => true,
        'group_name' => true,
        'producer' => true,
        'medicine_type' => true,
        'cbg_rate' => true,
        'formula_name' => true,
        'formula_percentage' => true,
        'hpp' => true,
        'sale_price' => true,
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
