<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderPrescription Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $medicine_id
 * @property string|null $medicine_unit
 * @property bool|null $is_kronis
 * @property string|null $jml_per_hari
 * @property string|null $qty_min
 * @property int|null $jml_hari
 * @property string|null $qty_satuan
 * @property string|null $aturan_pakai
 * @property string|null $harga
 * @property string|null $total_harga
 * @property string|null $keterangan
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Medicine $medicine
 */
class OrderPrescription extends Entity
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
        'order_id' => true,
        'medicine_id' => true,
        'medicine_unit' => true,
        'is_kronis' => true,
        'jml_per_hari' => true,
        'qty_min' => true,
        'jml_hari' => true,
        'qty_satuan' => true,
        'aturan_pakai' => true,
        'harga' => true,
        'total_harga' => true,
        'keterangan' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'medicine' => true,
    ];
}
