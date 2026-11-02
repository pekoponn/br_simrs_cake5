<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PraRegistration Entity
 *
 * @property int $id
 * @property string $reservation_code
 * @property int|null $patient_id
 * @property string|null $medical_record_no
 * @property string $patient_name
 * @property \Cake\I18n\Date|null $birth_date
 * @property string|null $address
 * @property string|null $phone_number
 * @property string|null $nik
 * @property int|null $doctor_id
 * @property string $doctor_name
 * @property string $poly_name
 * @property \Cake\I18n\Date $appointment_date
 * @property string|null $appointment_day
 * @property \Cake\I18n\Time $appointment_time
 * @property int|null $patient_queue_number
 * @property string|null $guarantor
 * @property string|null $planned_action
 * @property string|null $referral_type
 * @property string|null $card_number
 * @property string|null $referral_number
 * @property string $channel
 * @property string|null $notes
 * @property string $registration_status
 * @property \Cake\I18n\DateTime|null $registered_at
 * @property \Cake\I18n\DateTime $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $modified_by
 *
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 */
class PraRegistration extends Entity
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
        'reservation_code' => true,
        'patient_id' => true,
        'medical_record_no' => true,
        'patient_name' => true,
        'birth_date' => true,
        'address' => true,
        'phone_number' => true,
        'nik' => true,
        'doctor_id' => true,
        'doctor_name' => true,
        'poly_name' => true,
        'appointment_date' => true,
        'appointment_day' => true,
        'appointment_time' => true,
        'patient_queue_number' => true,
        'guarantor' => true,
        'planned_action' => true,
        'referral_type' => true,
        'card_number' => true,
        'referral_number' => true,
        'channel' => true,
        'notes' => true,
        'registration_status' => true,
        'registered_at' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'patient' => true,
        'doctor' => true,
    ];
}