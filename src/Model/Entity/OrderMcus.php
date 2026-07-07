<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderMcus Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $registration_id
 * @property int|null $patient_id
 * @property int|null $doctor_id
 * @property \Cake\I18n\FrozenDate|null $mcu_date
 * @property \Cake\I18n\Time|null $mcu_time
 * @property string|null $mcu_type
 * @property string|null $notes
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
 */
class OrderMcus extends Entity
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
        'mcu_date' => true,
        'mcu_time' => true,
        'mcu_type' => true,
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
