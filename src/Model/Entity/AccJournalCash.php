<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccJournalCash Entity
 *
 * @property int $id
 * @property string $branch_id
 * @property string|null $number
 * @property string|null $code
 * @property int|null $customer_id_old
 * @property string|null $customer_id
 * @property string|null $journal_type
 * @property string|null $name
 * @property string|null $subject
 * @property string|null $cek_bg
 * @property int|null $recipient_payer_id
 * @property string|null $recipient_payer_code
 * @property \Cake\I18n\Date|null $date
 * @property string|null $payment_type
 * @property string|null $no_cek
 * @property string|null $no_ref
 * @property \Cake\I18n\Date|null $warkat_date
 * @property string|null $job
 * @property int|null $balance
 * @property string|null $grand_total
 * @property string|null $description
 * @property string|null $status
 * @property string|null $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $is_active
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\RecipientPayer $recipient_payer
 * @property \App\Model\Entity\AccJournalCashLine[] $acc_journal_cash_lines
 */
class AccJournalCash extends Entity
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
        'number' => true,
        'code' => true,
        'customer_id_old' => true,
        'customer_id' => true,
        'journal_type' => true,
        'name' => true,
        'subject' => true,
        'cek_bg' => true,
        'recipient_payer_id' => true,
        'recipient_payer_code' => true,
        'date' => true,
        'payment_type' => true,
        'no_cek' => true,
        'no_ref' => true,
        'warkat_date' => true,
        'job' => true,
        'balance' => true,
        'grand_total' => true,
        'description' => true,
        'status' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'branch' => true,
        'customer' => true,
        'recipient_payer' => true,
        'acc_journal_cash_lines' => true,
    ];
}
