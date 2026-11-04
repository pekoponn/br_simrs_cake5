<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabExamination Entity
 *
 * @property int $id
 * @property string $lab_no
 * @property int|null $registration_id
 * @property int|null $patient_id
 * @property string|null $medical_record_no
 * @property string $patient_name
 * @property string $examination_name
 * @property string|null $patient_type
 * @property string|null $sender_doctor
 * @property string|null $origin
 * @property \Cake\I18n\DateTime|null $received_at
 * @property \Cake\I18n\DateTime|null $finished_at
 * @property string $status
 * @property bool $integration_status
 * @property bool $is_create
 * @property bool $is_update
 * @property bool $is_delete
 * @property string $is_active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 */
class LabExamination extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'lab_no' => true,
        'registration_id' => true,
        'order_id' => true,
        'patient_id' => true,
        'medical_record_no' => true,
        'patient_name' => true,
        'examination_name' => true,
        'patient_type' => true,
        'sender_doctor' => true,
        'origin' => true,
        'received_at' => true,
        'finished_at' => true,
        'status' => true,
        'integration_status' => true,
        'is_create' => true,
        'is_update' => true,
        'is_delete' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'registration' => true,
        'patient' => true,
    ];
}
