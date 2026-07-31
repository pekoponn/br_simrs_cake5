<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Patient Entity
 *
 * @property int $id
 * @property string $code
 * @property string|null $medical_record_no
 * @property string $full_name
 * @property string $identity_type
 * @property string $identity_number
 * @property string $gender
 * @property string $blood_type
 * @property \Cake\I18n\FrozenDate|null $birth_date
 * @property string $age
 * @property string|null $address
 * @property string $mother_name
 * @property string $father_name
 * @property string $phone_number
 * @property string $nationality
 * @property string $citizenship
 * @property string $id_prov
 * @property string $id_kab
 * @property string $id_kec
 * @property string $id_kel
 * @property string $occupation
 * @property string $religion
 * @property string $education
 * @property string $ethnic_group
 * @property string $marital_status
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Registration[] $registrations
 */
class Patient extends Entity
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
        'medical_record_no' => true,
        'title' => true,
        'full_name' => true,
        'identity_type' => true,
        'identity_number' => true,
        'gender' => true,
        'blood_type' => true,
        'allergy' => true,
        'birth_date' => true,
        'age' => true,
        'address' => true,
        'mother_name' => true,
        'father_name' => true,
        'phone_number' => true,
        'nationality' => true,
        'citizenship' => true,
        'province' => true,
        'city' => true,
        'district' => true,
        'subdistrict' => true,
        'id_prov' => true,
        'id_kab' => true,
        'id_kec' => true,
        'id_kel' => true,
        'occupation' => true,
        'religion' => true,
        'education' => true,
        'ethnic_group' => true,
        'marital_status' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'is_log' => true,
        'registrations' => true,
    ];
}
