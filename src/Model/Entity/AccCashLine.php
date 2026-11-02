<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccCashLine Entity
 *
 * @property int $id
 * @property int $acc_cash_id
 * @property int|null $acc_account_id
 * @property string $acc_account_code
 * @property string|null $name
 * @property string|null $debet
 * @property int|null $credit
 * @property string $job
 * @property string|null $who_create
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $who_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $who_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $status
 *
 * @property \App\Model\Entity\AccCash $acc_cash
 * @property \App\Model\Entity\AccAccount $acc_account
 */
class AccCashLine extends Entity
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
        'acc_cash_id' => true,
        'acc_account_id' => true,
        'acc_account_code' => true,
        'name' => true,
        'debet' => true,
        'credit' => true,
        'job' => true,
        'who_create' => true,
        'created' => true,
        'who_update' => true,
        'modified' => true,
        'who_delete' => true,
        'deleted' => true,
        'status' => true,
        'acc_cash' => true,
        'acc_account' => true,
    ];
}
