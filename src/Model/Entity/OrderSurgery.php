<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderSurgery Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $registration_id
 * @property int|null $patient_id
 * @property int|null $doctor_id
 * @property \Cake\I18n\FrozenDate|null $surgery_date
 * @property \Cake\I18n\Time|null $surgery_time
 * @property int|null $operator_id
 * @property string|null $operator_name
 * @property int|null $operation_type_id
 * @property string|null $surgery_code
 * @property string|null $surgery_name
 * @property string $tariff
 * @property string|null $unit
 * @property string|null $approval_note
 * @property string|null $notes
 * @property string|null $approved_queue_no
 * @property \Cake\I18n\FrozenDate|null $approved_date
 * @property \Cake\I18n\Time|null $approved_time
 * @property string|null $operating_room
 * @property string|null $approved_operator
 * @property string|null $approved_surgery_name
 * @property string|null $anesthesia_type
 * @property string|null $approved_by
 * @property string $status
 * @property bool $is_active
 * @property bool $is_delete
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\Operator $operator
 * @property \App\Model\Entity\OperationType $operation_type
 */
class OrderSurgery extends Entity
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
        'registration_id' => true,
        'patient_id' => true,
        'doctor_id' => true,
        'surgery_date' => true,
        'surgery_time' => true,
        'operator_id' => true,
        'operator_name' => true,
        'operation_type_id' => true,
        'surgery_code' => true,
        'surgery_name' => true,
        'tariff' => true,
        'unit' => true,
        'approval_note' => true,
        'notes' => true,
        'approved_queue_no' => true,
        'approved_date' => true,
        'approved_time' => true,
        'operating_room' => true,
        'approved_operator' => true,
        'approved_surgery_name' => true,
        'anesthesia_type' => true,
        'approved_by' => true,
        'status' => true,
        'is_active' => true,
        'is_delete' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
        'operator' => true,
        'operation_type' => true,
    ];
}
