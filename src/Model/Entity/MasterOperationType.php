<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterOperationType Entity
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $category
 * @property string|null $tariff
 * @property string $jasa_rs
 * @property string $jasa_dr
 * @property string $jasa_paramedis
 * @property string|null $unit
 * @property string|null $description
 * @property bool|null $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class MasterOperationType extends Entity
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
        'name' => true,
        'category' => true,
        'tariff' => true,
        'jasa_rs' => true,
        'jasa_dr' => true,
        'jasa_paramedis' => true,
        'unit' => true,
        'description' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
    ];
}
