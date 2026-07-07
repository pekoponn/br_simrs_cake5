<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterSurgeryOperator Entity
 *
 * @property int $id
 * @property string $code
 * @property int|null $doctor_id
 * @property string $name
 * @property string|null $specialist
 * @property string|null $phone
 * @property string|null $notes
 * @property bool|null $is_active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Doctor $doctor
 */
class MasterSurgeryOperator extends Entity
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
        'code' => true,
        'doctor_id' => true,
        'name' => true,
        'specialist' => true,
        'phone' => true,
        'notes' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'doctor' => true,
    ];
}
