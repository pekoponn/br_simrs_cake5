<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BedHistory Entity
 *
 * @property int $id
 * @property int $bed_id
 * @property int $room_id
 * @property string|null $patient_name
 * @property string|null $registration_no
 * @property \Cake\I18n\Date|null $check_in_date
 * @property \Cake\I18n\Date|null $check_out_date
 * @property bool|null $status_before
 * @property bool|null $status_after
 * @property string|null $notes
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Bed $bed
 * @property \App\Model\Entity\Room $room
 */
class BedHistory extends Entity
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
        'bed_id' => true,
        'room_id' => true,
        'patient_name' => true,
        'registration_no' => true,
        'check_in_date' => true,
        'check_out_date' => true,
        'status_before' => true,
        'status_after' => true,
        'notes' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
        'bed' => true,
        'room' => true,
    ];
}
