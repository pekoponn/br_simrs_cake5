<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NutritionCombine Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $description
 * @property string|null $nutrition_content_name
 * @property string|null $nutritional_value
 * @property string|null $content_unit
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_print
 * @property \Cake\I18n\FrozenTime|null $printed
 * @property string|null $is_active
 * @property string|null $is_log
 */
class NutritionCombine extends Entity
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
        'description' => true,
        'nutrition_content_name' => true,
        'nutritional_value' => true,
        'content_unit' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_print' => true,
        'printed' => true,
        'is_active' => true,
        'is_log' => true,
    ];
}
