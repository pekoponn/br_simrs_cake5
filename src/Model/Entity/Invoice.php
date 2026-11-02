<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $id
 * @property string $bapb_no
 * @property string|null $nama_supplier
 * @property int|null $supplier_id
 * @property \Cake\I18n\Date $tgl_terima
 * @property string|null $no_faktur
 * @property string|null $sj_no
 * @property \Cake\I18n\Date|null $tgl_tukar_faktur
 * @property string $kurs
 * @property string $rate
 * @property string $pembayaran
 * @property \Cake\I18n\Date|null $tgl_jatuh_tempo
 * @property string|null $diterima_lokasi_gudang
 * @property string $materai
 * @property string $discount_percent
 * @property string $discount_rp
 * @property string $ongkos_kirim
 * @property string $total
 * @property string $grand_total
 * @property string|null $catatan
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\InvoiceDetail[] $invoice_details
 */
class Invoice extends Entity
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
        'bapb_no' => true,
        'nama_supplier' => true,
        'supplier_id' => true,
        'tgl_terima' => true,
        'no_faktur' => true,
        'sj_no' => true,
        'tgl_tukar_faktur' => true,
        'kurs' => true,
        'rate' => true,
        'pembayaran' => true,
        'tgl_jatuh_tempo' => true,
        'diterima_lokasi_gudang' => true,
        'materai' => true,
        'discount_percent' => true,
        'discount_rp' => true,
        'ongkos_kirim' => true,
        'total' => true,
        'grand_total' => true,
        'catatan' => true,
        'created' => true,
        'modified' => true,
        'supplier' => true,
        'invoice_details' => true,
    ];
}
