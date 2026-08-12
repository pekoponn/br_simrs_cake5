<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BankAccount Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string $code
 * @property string $bank_name
 * @property string $account_holder
 * @property string $account_number
 * @property string $opening_balance
 * @property string|null $description
 * @property int|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Branch $branch
 */
class BankAccount extends Entity
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
        'branch_id' => true,
        'code' => true,
        'bank_name' => true,
        'account_holder' => true,
        'account_number' => true,
        'opening_balance' => true,
        'ending_balance' => true,
        'description' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'branch' => true,
    ];
}
