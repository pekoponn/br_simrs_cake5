<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderPembelian Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property string $po_no
 * @property \Cake\I18n\Date $tgl_po
 * @property string|null $ref_no
 * @property \Cake\I18n\Date|null $tgl_kirim
 * @property string|null $barang_dikirim_ke
 * @property string|null $kirim_via
 * @property string|null $jenis
 * @property string $total
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\OrderPembelianDetail[] $order_pembelian_details
 */
class OrderPembelian extends Entity
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
        'supplier_id' => true,
        'po_no' => true,
        'tgl_po' => true,
        'ref_no' => true,
        'tgl_kirim' => true,
        'barang_dikirim_ke' => true,
        'kirim_via' => true,
        'jenis' => true,
        'total' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'supplier' => true,
        'order_pembelian_details' => true,
    ];
}
