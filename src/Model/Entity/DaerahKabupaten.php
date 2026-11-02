<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DaerahKabupaten Entity
 *
 * @property string $id_kab
 * @property string $id_prov
 * @property string $nama
 * @property int $id_jenis
 */
class DaerahKabupaten extends Entity
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
        'id_prov' => true,
        'nama' => true,
        'id_jenis' => true,
    ];
}
