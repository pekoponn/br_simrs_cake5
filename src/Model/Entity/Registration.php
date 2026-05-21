<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Chronos\Date;
use Cake\ORM\Entity;

/**
 * Registration Entity
 *
 * @property int $id
 * @property string $registration_no
 * @property string $patient_id
 * @property Date $registration_date
 * @property string $service_type
 * @property string $doctor_id
 * @property string $polyclinic_name
 * @property int $room_id
 * @property int $bed_id
 * @property string $class_name
 * @property string $entry_process
 * @property string $entry_method
 * @property string $payment_method
 * @property string $insurance_type
 * @property string $insurance_category
 * @property string $insurance_card_no
 * @property string $refferal_no
 * @property string $skdp_no
 * @property string $reference_type
 * @property string $sep_no
 * @property string $bpjs_nik
 * @property string $bpjs_name
 * @property string $bpjs_group
 * @property string $bpjs_type
 * @property string $provider
 * @property int $person_responsible_id
 * @property string $treatment_type
 * @property string $status
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 *
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\Bed $bed
 * @property \App\Model\Entity\PersonResponsible[] $person_responsible
 */
class Registration extends Entity
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
        'registration_no' => true,
        'patient_id' => true,
        'registration_date' => true,
        'admission_time' => true,
        'service_type' => true,
        'doctor_id' => true,
        'doctor_schedule_id' => true,
        'polyclinic_queue_id' => true,
        'queue_number' => true,
        'polyclinic_name' => true,
        'room_id' => true,
        'bed_id' => true,
        'class_name' => true,
        'entry_process' => true,
        'entry_method' => true,
        'payment_method' => true,
        'insurance_type' => true,
        'insurance_category' => true,
        'insurance_card_no' => true,
        'refferal_no' => true,
        'skdp_no' => true,
        'reference_type' => true,
        'sep_no' => true,
        'bpjs_nik' => true,
        'bpjs_name' => true,
        'bpjs_group' => true,
        'bpjs_type' => true,
        'bpjs_class' => true,
        'provider' => true,
        'person_responsible_id' => true,
        'treatment_type' => true,
        'status' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'updated' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true
    ];
}
