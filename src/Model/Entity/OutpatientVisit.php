<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutpatientVisit Entity
 *
 * Tabel ini sekarang berfungsi sebagai index/induk kunjungan rawat jalan.
 * Data klinis (tanda vital, diagnosa, ICD, resep, rujukan, billing tindakan)
 * dipisah ke entity/tabel OutpatientVisitEmr (relasi hasOne / belongsTo).
 *
 * @property int $id
 * @property int $registration_id
 * @property string $registration_no
 * @property int $patient_id
 * @property int|null $doctor_id
 * @property int|null $queue_number
 * @property string|null $polyclinic_name
 * @property string|null $room_name
 * @property \Cake\I18n\FrozenDate $visit_date
 * @property \Cake\I18n\Time|null $visit_time
 * @property string $status
 * @property int|null $billing_id
 * @property string|null $billing_status
 * @property \Cake\I18n\FrozenTime|null $called_at
 * @property \Cake\I18n\FrozenTime|null $start_time
 * @property \Cake\I18n\FrozenTime|null $end_time
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\OutpatientAction[] $outpatient_actions
 * @property \App\Model\Entity\OutpatientVisitEmr $outpatient_visit_emr
 */
class OutpatientVisit extends Entity
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
        'registration_id' => true,
        'registration_no' => true,
        'patient_id' => true,
        'doctor_id' => true,
        'queue_number' => true,
        'polyclinic_name' => true,
        'room_name' => true,
        'visit_date' => true,
        'visit_time' => true,
        'status' => true,
        'billing_id' => true,
        'billing_status' => true,
        'called_at' => true,
        'start_time' => true,
        'end_time' => true,
        'created_by' => true,
        'updated_by' => true,
        'created' => true,
        'modified' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
        'outpatient_actions' => true,
        'outpatient_visit_emr' => true,
    ];
}