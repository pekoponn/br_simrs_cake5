<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $branch_id
 * @property string|null $code
 * @property string|null $user_id
 * @property int $marketing_id
 * @property int|null $data_invoice_id
 * @property int|null $data_tax_id
 * @property int|null $mou_id
 * @property string|null $title
 * @property string|null $title_old
 * @property string|null $nickname
 * @property string|null $nickname_old
 * @property string|null $name
 * @property string|null $name_old
 * @property string|null $name_fake
 * @property string|null $check_fake
 * @property string|null $deposit_mou
 * @property string|null $type
 * @property string|null $group
 * @property string|null $practice_day
 * @property string|null $practice_hours_start
 * @property string|null $practice_hours_end
 * @property string|null $tax
 * @property int $taxing
 * @property string|null $pph
 * @property string|null $va
 * @property string|null $treatment
 * @property string|null $contact_person
 * @property string|null $dept_person
 * @property string|null $telp_person
 * @property string|null $warehouse_address
 * @property string|null $warehouse_telp
 * @property string|null $address_penghasil
 * @property string|null $supplier
 * @property string|null $address_supplier
 * @property string|null $phone_supplier
 * @property string|null $fax_supplier
 * @property string|null $name_invoice
 * @property string|null $address_invoice
 * @property string|null $phone_invoice
 * @property string|null $fax_invoice
 * @property string|null $name_tax_invoice
 * @property string|null $address_tax_invoice
 * @property string|null $phone_tax_invoice
 * @property string|null $fax_tax_invoice
 * @property string|null $bank_an_ori
 * @property string|null $bank_name_ori
 * @property string|null $bank_norek_ori
 * @property string|null $bank_an
 * @property string|null $bank_name
 * @property string|null $bank_norek
 * @property string|null $va_an
 * @property string|null $va_name
 * @property string|null $va_no
 * @property string|null $giro_no
 * @property string|null $rek_name
 * @property string|null $rek_no
 * @property string|null $rek_bank
 * @property string|null $npwp
 * @property string|null $ppn
 * @property string|null $city
 * @property string|null $province
 * @property string|null $district
 * @property int|null $postal
 * @property string|null $country
 * @property string|null $phone3
 * @property string|null $phone4
 * @property string|null $phone5
 * @property string|null $email1
 * @property string|null $email2
 * @property string|null $email3
 * @property string|null $email4
 * @property string|null $email5
 * @property string|null $fb1
 * @property string|null $fb2
 * @property string|null $ym1
 * @property string|null $ym2
 * @property string|null $ym3
 * @property string|null $ym4
 * @property string|null $ym5
 * @property string|null $system
 * @property string|null $website
 * @property string|null $beginning_balance
 * @property string|null $platform
 * @property string $is_active
 * @property string|null $is_log
 * @property string|null $who_create
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $who_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $active
 * @property string|null $status
 * @property string|null $is_create
 * @property string|null $is_update
 * @property string|null $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Marketing $marketing
 * @property \App\Model\Entity\DataInvoice $data_invoice
 * @property \App\Model\Entity\DataTax $data_tax
 * @property \App\Model\Entity\Mous $mous
 * @property \App\Model\Entity\AccCash[] $acc_cashes
 * @property \App\Model\Entity\AccChartOfAccount[] $acc_chart_of_accounts
 * @property \App\Model\Entity\AccJournalBank[] $acc_journal_banks
 * @property \App\Model\Entity\AccJournalCash[] $acc_journal_cashes
 * @property \App\Model\Entity\AccJournalMemorial[] $acc_journal_memorials
 * @property \App\Model\Entity\AccJournal[] $acc_journals
 * @property \App\Model\Entity\Certificate[] $certificates
 * @property \App\Model\Entity\CommissionDetail[] $commission_details
 * @property \App\Model\Entity\InvoiceDeposit[] $invoice_deposits
 * @property \App\Model\Entity\InvoiceEntry[] $invoice_entries
 * @property \App\Model\Entity\InvoiceOut[] $invoice_outs
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\ManifestInside[] $manifest_insides
 * @property \App\Model\Entity\ManifestProcessor[] $manifest_processors
 * @property \App\Model\Entity\Manifest[] $manifests
 * @property \App\Model\Entity\Mouse[] $mouses
 * @property \App\Model\Entity\Offer[] $offers
 * @property \App\Model\Entity\Operational[] $operationals
 * @property \App\Model\Entity\OrderRegularLine[] $order_regular_lines
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Orders230129[] $orders230129
 * @property \App\Model\Entity\OrdersOri[] $orders_ori
 * @property \App\Model\Entity\Permit[] $permits
 * @property \App\Model\Entity\TruckSchedule[] $truck_schedules
 * @property \App\Model\Entity\UnidentifiedIncome[] $unidentified_incomes
 * @property \App\Model\Entity\WastePrice[] $waste_prices
 * @property \App\Model\Entity\Waste[] $wastes
 */
class Customer extends Entity
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
        'code' => true,
        'user_id' => true,
        'marketing_id' => true,
        'data_invoice_id' => true,
        'data_tax_id' => true,
        'mou_id' => true,
        'title' => true,
        'title_old' => true,
        'nickname' => true,
        'nickname_old' => true,
        'name' => true,
        'name_old' => true,
        'name_fake' => true,
        'check_fake' => true,
        'deposit_mou' => true,
        'type' => true,
        'group' => true,
        'practice_day' => true,
        'practice_hours_start' => true,
        'practice_hours_end' => true,
        'tax' => true,
        'taxing' => true,
        'pph' => true,
        'va' => true,
        'treatment' => true,
        'contact_person' => true,
        'dept_person' => true,
        'telp_person' => true,
        'warehouse_address' => true,
        'warehouse_telp' => true,
        'address_penghasil' => true,
        'supplier' => true,
        'address_supplier' => true,
        'phone_supplier' => true,
        'fax_supplier' => true,
        'name_invoice' => true,
        'address_invoice' => true,
        'phone_invoice' => true,
        'fax_invoice' => true,
        'name_tax_invoice' => true,
        'address_tax_invoice' => true,
        'phone_tax_invoice' => true,
        'fax_tax_invoice' => true,
        'bank_an_ori' => true,
        'bank_name_ori' => true,
        'bank_norek_ori' => true,
        'bank_an' => true,
        'bank_name' => true,
        'bank_norek' => true,
        'va_an' => true,
        'va_name' => true,
        'va_no' => true,
        'giro_no' => true,
        'rek_name' => true,
        'rek_no' => true,
        'rek_bank' => true,
        'npwp' => true,
        'ppn' => true,
        'city' => true,
        'province' => true,
        'district' => true,
        'postal' => true,
        'country' => true,
        'phone3' => true,
        'phone4' => true,
        'phone5' => true,
        'email1' => true,
        'email2' => true,
        'email3' => true,
        'email4' => true,
        'email5' => true,
        'fb1' => true,
        'fb2' => true,
        'ym1' => true,
        'ym2' => true,
        'ym3' => true,
        'ym4' => true,
        'ym5' => true,
        'system' => true,
        'website' => true,
        'beginning_balance' => true,
        'platform' => true,
        'is_active' => true,
        'is_log' => true,
        'who_create' => true,
        'created' => true,
        'who_update' => true,
        'modified' => true,
        'active' => true,
        'status' => true,
        'is_create' => true,
        'is_update' => true,
        'is_delete' => true,
        'deleted' => true,
        'branch' => true,
        'user' => true,
        // 'marketing' => true,
        // 'data_invoice' => true,
        // 'data_tax' => true,
        //'mous' => true,
        // 'acc_cashes' => true,
        // 'acc_chart_of_accounts' => true,
        // // 'acc_journal_banks' => true,
        // // 'acc_journal_cashes' => true,
        // // 'acc_journal_memorials' => true,
        // 'acc_journals' => true,
        // 'certificates' => true,
        // 'commission_details' => true,
        // 'invoice_deposits' => true,
        // 'invoice_entries' => true,
        // 'invoice_outs' => true,
        // 'invoices' => true,
        // 'manifest_insides' => true,
        // 'manifest_processors' => true,
        // 'manifests' => true,
        'mouses' => true,
        // 'offers' => true,
        // 'operationals' => true,
        // 'order_regular_lines' => true,
        // 'orders' => true,
        // // 'orders230129' => true,
        // // 'orders_ori' => true,
        // 'permits' => true,
        // 'truck_schedules' => true,
        // 'unidentified_incomes' => true,
        // 'waste_prices' => true,
        // 'wastes' => true,
    ];
}
