<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PersonResponsible Entity
 *
 * @property int $id
 * @property int $registration_id
 * @property string $name
 * @property string $identity_type
 * @property string $identity_no
 * @property string $relation
 * @property int $age
 * @property string $job
 * @property string $address
 * @property string $phone
 * @property int $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 *
 * @property \App\Model\Entity\Registration[] $registrations
 */
class PersonResponsible extends Entity
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
        'registration_id' => true,
        'name' => true,
        'identity_type' => true,
        'identity_no' => true,
        'relation' => true,
        'age' => true,
        'job' => true,
        'address' => true,
        'phone' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'registrations' => true,
    ];
}
