<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property string $no_order
 * @property int $registration_id
 * @property int $patient_id
 * @property int|null $doctor_id
 * @property int|null $created_by
 * @property int $status_id
 * @property \Cake\I18n\FrozenTime $tgl_order
 * @property string|null $lokasi_depo
 * @property string|null $catatan
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\OrderStatus $order_status
 * @property \App\Model\Entity\OrderPrescription[] $order_prescriptions
 */
class Order extends Entity
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
        'no_order' => true,
        'registration_id' => true,
        'patient_id' => true,
        'doctor_id' => true,
        'created_by' => true,
        'status_id' => true,
        'tgl_order' => true,
        'lokasi_depo' => true,
        'pesan' => true,
        'catatan' => true,
        'laboratory_note' => true,
        'radiology_note' => true,
        'created' => true,
        'modified' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
        'order_status' => true,
        'order_prescriptions' => true,
        'order_laboratories' => true,
        'order_radiologies' => true,
    ];
}
