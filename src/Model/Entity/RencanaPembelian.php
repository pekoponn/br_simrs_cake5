<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RencanaPembelian Entity
 *
 * @property int $id
 * @property string $no_perencanaan
 * @property \Cake\I18n\FrozenDate $tgl_perencanaan
 * @property string|null $no_dokumen
 * @property string $status
 * @property int|null $supplier_id
 * @property string|null $nama_supplier
 * @property string|null $diminta_oleh
 * @property string $total_qty_permintaan
 * @property string $total_permintaan
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\RencanaPembelianDetail[] $rencana_pembelian_details
 */
class RencanaPembelian extends Entity
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
        'no_perencanaan' => true,
        'tgl_perencanaan' => true,
        'no_dokumen' => true,
        'status' => true,
        'supplier_id' => true,
        'nama_supplier' => true,
        'diminta_oleh' => true,
        'total_qty_permintaan' => true,
        'total_permintaan' => true,
        'created' => true,
        'modified' => true,
        'supplier' => true,
        'rencana_pembelian_details' => true,
    ];
}
