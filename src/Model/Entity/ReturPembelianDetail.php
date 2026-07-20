<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReturPembelianDetail Entity
 *
 * @property int $id
 * @property int $retur_pembelian_id
 * @property int|null $medicine_id
 * @property string|null $kode_barang
 * @property string|null $nama_barang
 * @property string $qty
 * @property string|null $unit
 * @property string $harga
 * @property string $tax
 * @property string $ppn_rp
 * @property string $discount
 * @property string $total_harga
 * @property \Cake\I18n\FrozenDate|null $tgl_kadaluarsa
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ReturPembelian $retur_pembelian
 * @property \App\Model\Entity\Medicine $medicine
 */
class ReturPembelianDetail extends Entity
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
        'retur_pembelian_id' => true,
        'medicine_id' => true,
        'kode_barang' => true,
        'nama_barang' => true,
        'qty' => true,
        'unit' => true,
        'harga' => true,
        'tax' => true,
        'ppn_rp' => true,
        'discount' => true,
        'total_harga' => true,
        'tgl_kadaluarsa' => true,
        'created' => true,
        'modified' => true,
        'retur_pembelian' => true,
        'medicine' => true,
    ];
}
