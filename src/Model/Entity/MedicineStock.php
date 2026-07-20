<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MedicineStock Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int $medicine_id
 * @property \Cake\I18n\FrozenDate|null $last_so_date
 * @property string $hasil_so
 * @property string $adjustment
 * @property string $terima
 * @property string $keluar
 * @property string $saldo_akhir
 * @property string $max_stock
 * @property string $is_valid
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Medicine $medicine
 */
class MedicineStock extends Entity
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
        'branch_id' => true,
        'medicine_id' => true,
        'last_so_date' => true,
        'hasil_so' => true,
        'adjustment' => true,
        'terima' => true,
        'keluar' => true,
        'saldo_akhir' => true,
        'max_stock' => true,
        'is_valid' => true,
        'created' => true,
        'modified' => true,
        'branch' => true,
        'medicine' => true,
    ];
}
