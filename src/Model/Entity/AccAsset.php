<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccAsset Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property \Cake\I18n\FrozenDate|null $date
 * @property int|null $periode
 * @property string|null $group
 * @property int|null $quantity
 * @property float|null $price
 * @property int|null $is_create
 * @property int|null $is_update
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\AccAssetLine[] $acc_asset_lines
 */
class AccAsset extends Entity
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
        'name' => true,
        'description' => true,
        'date' => true,
        'periode' => true,
        'category' => true,
        'quantity' => true,
        'price' => true,
        'is_create' => true,
        'is_update' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'acc_asset_lines' => true,
    ];
}
