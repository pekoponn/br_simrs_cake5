<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Insurance Entity
 *
 * @property int $id
 * @property string $code
 * @property string $region
 * @property string $name
 * @property string $type
 * @property string $bank_name
 * @property string $bank_account_number
 * @property string $bank_account_name
 * @property string $phone_number_rs
 * @property string $email_rs
 * @property int $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 */
class Insurance extends Entity
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
        'code' => true,
        'region' => true,
        'name' => true,
        'type' => true,
        'bank_name' => true,
        'bank_account_number' => true,
        'bank_account_name' => true,
        'phone_number_rs' => true,
        'email_rs' => true,
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
