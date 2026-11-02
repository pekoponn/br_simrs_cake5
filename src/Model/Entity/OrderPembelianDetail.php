<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderPembelianDetail Entity
 *
 * @property int $id
 * @property int $order_pembelian_id
 * @property int|null $barang_id
 * @property string|null $kode_barang
 * @property string|null $nama_barang
 * @property string $qty_rencana
 * @property string $qty_po
 * @property string|null $satuan
 * @property string $harga
 * @property string $discount
 * @property string $tax
 * @property string $total_harga
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\OrderPembelian $order_pembelian
 * @property \App\Model\Entity\Barang $barang
 */
class OrderPembelianDetail extends Entity
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
        'order_pembelian_id' => true,
        'barang_id' => true,
        'kode_barang' => true,
        'nama_barang' => true,
        'qty_rencana' => true,
        'qty_po' => true,
        'satuan' => true,
        'harga' => true,
        'discount' => true,
        'tax' => true,
        'total_harga' => true,
        'created' => true,
        'modified' => true,
        'order_pembelian' => true,
        'barang' => true,
    ];
}
