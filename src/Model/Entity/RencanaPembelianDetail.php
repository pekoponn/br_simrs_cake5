<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RencanaPembelianDetail Entity
 *
 * @property int $id
 * @property int $rencana_pembelian_id
 * @property int|null $medicine_id
 * @property string|null $kode_barang
 * @property string|null $nama_barang
 * @property string $qty
 * @property string $harga
 * @property string|null $satuan
 * @property string $total
 * @property string $total_approv
 * @property string $is_obat
 * @property string|null $keterangan
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\RencanaPembelian $rencana_pembelian
 * @property \App\Model\Entity\Medicine $medicine
 */
class RencanaPembelianDetail extends Entity
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
        'rencana_pembelian_id' => true,
        'medicine_id' => true,
        'kode_barang' => true,
        'nama_barang' => true,
        'qty' => true,
        'harga' => true,
        'satuan' => true,
        'total' => true,
        'total_approv' => true,
        'is_obat' => true,
        'keterangan' => true,
        'created' => true,
        'modified' => true,
        'rencana_pembelian' => true,
        'medicine' => true,
    ];
}
