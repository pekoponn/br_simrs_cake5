<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderSupport Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $registration_id
 * @property int|null $patient_id
 * @property int|null $doctor_id
 * @property string|null $support_code
 * @property string $support_name
 * @property string $tariff
 * @property int $qty
 * @property string $total
 * @property string|null $unit
 * @property string|null $approval_note
 * @property string|null $notes
 * @property string $status
 * @property bool $is_active
 * @property bool $is_delete
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 */
class OrderSupport extends Entity
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
        'order_id' => true,
        'registration_id' => true,
        'patient_id' => true,
        'doctor_id' => true,
        'support_code' => true,
        'support_name' => true,
        'tariff' => true,
        'qty' => true,
        'total' => true,
        'unit' => true,
        'approval_note' => true,
        'notes' => true,
        'status' => true,
        'is_active' => true,
        'is_delete' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
    ];
}
