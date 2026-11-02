<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HealthFacility Entity
 *
 * @property int $id
 * @property string $code
 * @property string $code_int
 * @property string $name
 * @property string $type
 * @property string $address
 * @property string|null $code_ppk
 * @property int $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 */
class HealthFacility extends Entity
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
        'code_int' => true,
        'name' => true,
        'type' => true,
        'address' => true,
        'code_ppk' => true,
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
