<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MedicalRecordDiagnosis Entity
 *
 * @property int $id
 * @property int $medical_record_id
 * @property string $type
 * @property string|null $code
 * @property string|null $diagnosis
 * @property bool|null $is_primary
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\MedicalRecord $medical_record
 */
class MedicalRecordDiagnosis extends Entity
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
        'type' => true,
        'code' => true,
        'diagnosis' => true,
        'is_primary' => true,
        'created' => true,
        'modified' => true,
        'medical_record' => true,
    ];
}
