<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MedicalRecordInpatient Entity
 *
 * @property int $id
 * @property int $medical_record_id
 * @property string|null $jenis
 * @property string|null $pelayanan
 * @property string|null $kelas
 * @property string|null $ruang
 * @property \Cake\I18n\FrozenDate|null $tgl_masuk
 * @property \Cake\I18n\FrozenDate|null $tgl_keluar
 * @property \Cake\I18n\FrozenDate|null $tgl_operasi
 * @property string|null $nama_dokter
 * @property string|null $keadaan_keluar_rs
 * @property string|null $cara_keluar
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\MedicalRecord $medical_record
 */
class MedicalRecordInpatient extends Entity
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
        'medical_record_id' => true,
        'jenis' => true,
        'pelayanan' => true,
        'kelas' => true,
        'ruang' => true,
        'tgl_masuk' => true,
        'tgl_keluar' => true,
        'tgl_operasi' => true,
        'nama_dokter' => true,
        'keadaan_keluar_rs' => true,
        'cara_keluar' => true,
        'created' => true,
        'modified' => true,
        'medical_record' => true,
    ];
}
