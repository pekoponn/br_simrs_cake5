<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PolyclinicQueue Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $source
 * @property string|null $booking_code
 * @property string|null $bpjs_number
 * @property string|null $identity_number
 * @property \Cake\I18n\Date|null $visit_date
 * @property string|null $checkin_status
 * @property \Cake\I18n\DateTime|null $checkin_time
 * @property string|null $call_status
 * @property \Cake\I18n\DateTime|null $called_time
 * @property int|null $call_count
 * @property string|null $poly_name
 * @property string|null $patients_name
 * @property string|null $no_telp
 * @property int|null $queue_number
 * @property int|null $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int|null $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $delete_log
 * @property string|null $is_active
 */
class PolyclinicQueue extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'code' => true,
        'source' => true,
        'booking_code' => true,
        'bpjs_number' => true,
        'identity_number' => true,
        'visit_date' => true,
        'checkin_status' => true,
        'checkin_time' => true,
        'call_status' => true,
        'called_time' => true,
        'call_count' => true,
        'poly_name' => true,
        'patients_name' => true,
        'patient_id' => true,
        'medical_record_no' => true,
        'doctor_id' => true,
        'doctor_name' => true,
        'no_telp' => true,
        'queue_number' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
    ];
}
