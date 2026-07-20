<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceDetail Entity
 *
 * @property int $id
 * @property int $invoice_id
 * @property int|null $medicine_id
 * @property string|null $kode_barang
 * @property string|null $nama_barang
 * @property string $qty
 * @property string|null $satuan
 * @property string $harga
 * @property string $discount_percent
 * @property string $discount_rp
 * @property string $tax
 * @property string $total_harga
 * @property \Cake\I18n\FrozenDate|null $tgl_kadaluarsa
 * @property string|null $po_no
 * @property string|null $histori
 * @property string $nilai_diskon
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Medicine $medicine
 */
class InvoiceDetail extends Entity
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
        'invoice_id' => true,
        'medicine_id' => true,
        'kode_barang' => true,
        'nama_barang' => true,
        'qty' => true,
        'satuan' => true,
        'harga' => true,
        'discount_percent' => true,
        'discount_rp' => true,
        'tax' => true,
        'total_harga' => true,
        'tgl_kadaluarsa' => true,
        'po_no' => true,
        'histori' => true,
        'nilai_diskon' => true,
        'created' => true,
        'modified' => true,
        'invoice' => true,
        'medicine' => true,
    ];
}
