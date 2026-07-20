<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReturPembelian Entity
 *
 * @property int $id
 * @property string $retur_no
 * @property \Cake\I18n\FrozenDate $tgl_retur
 * @property string|null $bapb_no
 * @property string|null $no_faktur
 * @property string|null $gudang_depo
 * @property int|null $supplier_id
 * @property string|null $nama_supplier
 * @property string|null $catatan
 * @property string $total
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\ReturPembelianDetail[] $retur_pembelian_details
 */
class ReturPembelian extends Entity
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
        'retur_no' => true,
        'tgl_retur' => true,
        'bapb_no' => true,
        'no_faktur' => true,
        'gudang_depo' => true,
        'supplier_id' => true,
        'nama_supplier' => true,
        'catatan' => true,
        'total' => true,
        'created' => true,
        'modified' => true,
        'supplier' => true,
        'retur_pembelian_details' => true,
    ];
}
