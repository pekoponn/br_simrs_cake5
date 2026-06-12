<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterTindakan Entity
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string $kategori
 * @property string $harga
 * @property string|null $satuan
 * @property string|null $keterangan
 * @property bool $is_active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\OutpatientAction[] $outpatient_actions
 */
class MasterTindakan extends Entity
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
        'kategori' => true,
        'harga' => true,
        'satuan' => true,
        'keterangan' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'outpatient_actions' => true,
    ];
}
