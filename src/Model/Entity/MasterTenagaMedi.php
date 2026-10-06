<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterTenagaMedi Entity
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string $status
 * @property bool $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class MasterTenagaMedi extends Entity
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
        'kode' => true,
        'nama' => true,
        'status' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
    ];
}
