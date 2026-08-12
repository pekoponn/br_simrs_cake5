<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccCash Entity
 *
 * @property int $id
 * @property string|null $number
 * @property int|null $customer_id
 * @property string|null $cash_type
 * @property string|null $penyetor_penerima
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $payment_type
 * @property string|null $no_cek
 * @property \Cake\I18n\FrozenDate|null $warkat_date
 * @property int|null $balance
 * @property string|null $total
 * @property string|null $description
 * @property string|null $who_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $who_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $who_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $status
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\AccCashLine[] $acc_cash_lines
 */
class AccCash extends Entity
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
        'number' => true,
        'customer_id' => true,
        'cash_type' => true,
        'penyetor_penerima' => true,
        'date' => true,
        'payment_type' => true,
        'no_cek' => true,
        'warkat_date' => true,
        'balance' => true,
        'total' => true,
        'description' => true,
        'who_create' => true,
        'created' => true,
        'who_update' => true,
        'modified' => true,
        'who_delete' => true,
        'deleted' => true,
        'status' => true,
        'customer' => true,
        'acc_cash_lines' => true,
    ];
}
