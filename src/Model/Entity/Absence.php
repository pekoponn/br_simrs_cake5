<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Absence Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int $user_id
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $address
 * @property string|null $location
 * @property string|null $expression
 * @property string $inout_mode
 * @property \Cake\I18n\Date|null $date
 * @property string|null $time_in
 * @property string|null $time_out
 * @property string|null $description
 * @property string|null $device
 * @property string|null $browser_type
 * @property int $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\User $user
 */
class Absence extends Entity
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
        'branch_id' => true,
        'user_id' => true,
        'latitude' => true,
        'longitude' => true,
        'address' => true,
        'location' => true,
        'expression' => true,
        'inout_mode' => true,
        'conditions' => true,
        'date' => true,
        'time_in' => true,
        'time_out' => true,
        'zona' => true,
        'description' => true,
        'device' => true,
        'browser_type' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'is_log' => true,
        'branch' => true,
        'user' => true,
    ];
}
