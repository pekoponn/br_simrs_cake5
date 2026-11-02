<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MedicalRecordOutpatientIgd Entity
 *
 * @property int $id
 * @property int $medical_record_id
 * @property string|null $triage
 * @property string|null $keadaan_keluar
 * @property string|null $cara_bayar
 * @property string|null $cara_masuk
 * @property string|null $catatan
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\MedicalRecord $medical_record
 */
class MedicalRecordOutpatientIgd extends Entity
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
        'medical_record_id' => true,
        'triage' => true,
        'keadaan_keluar' => true,
        'cara_bayar' => true,
        'cara_masuk' => true,
        'catatan' => true,
        'created' => true,
        'modified' => true,
        'medical_record' => true,
    ];
}
