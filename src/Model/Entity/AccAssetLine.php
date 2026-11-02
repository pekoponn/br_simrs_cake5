<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccAssetLine Entity
 *
 * @property int $id
 * @property int $asset_id
 * @property float $mutasi_tambah
 * @property float $mutasi_kurang
 * @property float $akumulasi
 * @property \Cake\I18n\Date $date_periode
 * @property float $nilai_buku
 * @property int $is_create
 * @property int $is_update
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property string $status
 *
 * @property \App\Model\Entity\AccAsset $acc_asset
 */
class AccAssetLine extends Entity
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
        'asset_id' => true,
        'mutasi_tambah' => true,
        'mutasi_kurang' => true,
        'akumulasi' => true,
        'depresiasi' => true,
        'date_periode' => true,
        'nilai_buku' => true,
        'is_create' => true,
        'is_update' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'acc_asset' => true,
    ];
}
