<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutpatientBilling Entity
 *
 * @property int $id
 * @property string $billing_no
 * @property string|null $receipt_no
 * @property int $outpatient_visit_id
 * @property int|null $registration_id
 * @property int $patient_id
 * @property int|null $doctor_id
 * @property \Cake\I18n\Date $visit_date
 * @property string|null $polyclinic_name
 * @property string|null $insurance_type
 * @property string|null $insurance_no
 * @property string|null $insurance_partner_name
 * @property string|null $policy_no
 * @property string $status
 * @property string $total_action
 * @property string $total_medicine
 * @property string $total_lab
 * @property string $total_radiology
 * @property string $total_other
 * @property string $admin_fee
 * @property string $inacbg_amount
 * @property string|null $cbg_code
 * @property string|null $guarantor2_name
 * @property string $guarantor2_amount
 * @property string|null $guarantor3_name
 * @property string $guarantor3_amount
 * @property string $uncollectible_amount
 * @property string|null $transfer_card_no
 * @property string|null $transfer_bank_auth_no
 * @property string|null $transfer_card_type
 * @property string $transfer_admin_percent
 * @property string|null $transfer_bank_dest
 * @property string|null $payment_proof
 * @property string $subtotal
 * @property string $subtotal
 * @property string|null $discount_type
 * @property string $discount_value
 * @property string $discount_amount
 * @property string $grand_total
 * @property string|null $payment_method
 * @property string $paid_amount
 * @property string $change_amount
 * @property \Cake\I18n\DateTime|null $paid_at
 * @property int|null $cashier_id
 * @property string|null $cashier_name
 * @property string|null $paid_by
 * @property bool $is_referred
 * @property string|null $referred_to
 * @property bool $is_inpatient
 * @property bool $ready_to_transfer
 * @property string|null $inpatient_referral_no
 * @property string|null $notes
 * @property string|null $void_reason
 * @property \Cake\I18n\DateTime|null $voided_at
 * @property int|null $voided_by
 * @property bool|null $is_create
 * @property bool|null $is_update
 * @property bool|null $is_delete
 * @property string|null $is_active
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\OutpatientVisit $outpatient_visit
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\Cashier $cashier
 */
class OutpatientBilling extends Entity
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
        'billing_no' => true,
        'receipt_no' => true,
        'outpatient_visit_id' => true,
        'registration_id' => true,
        'patient_id' => true,
        'doctor_id' => true,
        'visit_date' => true,
        'polyclinic_name' => true,
        'insurance_type' => true,
        'insurance_no' => true,
        'insurance_partner_name' => true,
        'policy_no' => true,
        'status' => true,
        'total_action' => true,
        'total_medicine' => true,
        'total_lab' => true,
        'total_radiology' => true,
        'total_other' => true,
        'admin_fee' => true,
        'inacbg_amount' => true,
        'cbg_code' => true,
        'guarantor2_name' => true,
        'guarantor2_amount' => true,
        'guarantor3_name' => true,
        'guarantor3_amount' => true,
        'uncollectible_amount' => true,
        'transfer_card_no' => true,
        'transfer_bank_auth_no' => true,
        'transfer_card_type' => true,
        'transfer_admin_percent' => true,
        'transfer_bank_dest' => true,
        'payment_proof' => true,
        'reopen_reason' => true,
        'reopened_at' => true,
        'reopened_by' => true,
        'reopen_count' => true,
        'subtotal' => true,
        'discount_type' => true,
        'discount_value' => true,
        'discount_amount' => true,
        'grand_total' => true,
        'payment_method' => true,
        'paid_amount' => true,
        'change_amount' => true,
        'paid_at' => true,
        'cashier_id' => true,
        'cashier_name' => true,
        'paid_by' => true,
        'is_referred' => true,
        'referred_to' => true,
        'is_inpatient' => true,
        'ready_to_transfer' => true,
        'inpatient_referral_no' => true,
        'notes' => true,
        'void_reason' => true,
        'voided_at' => true,
        'voided_by' => true,
        'is_create' => true,
        'is_update' => true,
        'is_delete' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'outpatient_visit' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
        'cashier' => true,
    ];
}