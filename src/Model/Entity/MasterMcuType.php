<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterMcuType Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string $name
 * @property string|null $description
 * @property bool $is_active
 * @property bool $is_delete
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class MasterMcuType extends Entity
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
        'code' => true,
        'name' => true,
        'description' => true,
        'is_active' => true,
        'is_delete' => true,
        'created' => true,
        'modified' => true,
    ];
}
