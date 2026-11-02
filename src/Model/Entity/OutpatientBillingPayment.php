<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutpatientBillingPayment Entity
 *
 * @property int $id
 * @property int $billing_id
 * @property string $payment_no
 * @property string $payment_method
 * @property string|null $bank_name
 * @property string|null $account_no
 * @property string $amount
 * @property bool $verified
 * @property \Cake\I18n\DateTime|null $verified_at
 * @property int|null $verified_by
 * @property string|null $notes
 * @property \Cake\I18n\DateTime $created
 * @property int|null $created_by
 *
 * @property \App\Model\Entity\OutpatientBilling $outpatient_billing
 */
class OutpatientBillingPayment extends Entity
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
        'billing_id' => true,
        'payment_no' => true,
        'payment_method' => true,
        'bank_name' => true,
        'account_no' => true,
        'amount' => true,
        'verified' => true,
        'verified_at' => true,
        'verified_by' => true,
        'notes' => true,
        'created' => true,
        'created_by' => true,
        'outpatient_billing' => true,
    ];
}
