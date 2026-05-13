<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Branch Entity
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $company_name
 * @property string|null $company_address
 * @property string|null $business_fields
 * @property string|null $company_telp
 * @property string|null $company_fax
 * @property string|null $company_npwp
 * @property string|null $company_director
 * @property string|null $company_director_1
 * @property string|null $sign_title_1
 * @property string|null $company_director_2
 * @property string|null $sign_title_2
 * @property string|null $company_director_3
 * @property string|null $sign_title_3
 * @property string|null $company_director_4
 * @property string|null $sign_title_4
 * @property string|null $warehouse_address
 * @property string|null $warehouse_telp
 * @property string|null $warehouse_fax
 * @property string|null $manifest_number
 * @property string|null $invoice_code
 * @property string|null $invoice_number
 * @property string|null $invoice_number_include
 * @property string|null $invoice_evidence_email
 * @property string|null $faktur_pajak_number
 * @property string|null $berita_acara_number
 * @property string|null $permit_number
 * @property string|null $offer_number
 * @property string|null $offer_year
 * @property string|null $bank
 * @property string|null $norek
 * @property string|null $an
 * @property string|null $bank_name_1
 * @property string|null $bank_norek_1
 * @property string|null $bank_an_1
 * @property string|null $bank_name_2
 * @property string|null $bank_norek_2
 * @property string|null $bank_an_2
 * @property string|null $bank_name_3
 * @property string|null $bank_norek_3
 * @property string|null $bank_an_3
 * @property string|null $bank_name_4
 * @property string|null $bank_norek_4
 * @property string|null $bank_an_4
 * @property string|null $bank_name_5
 * @property string|null $bank_norek_5
 * @property string|null $bank_an_5
 * @property string|null $va_bank_an
 * @property string|null $va_bank_name
 * @property string|null $va_bank_branch
 * @property string|null $va_bank_norek
 * @property string|null $wa_invoice
 * @property string|null $city_invoice
 * @property string|null $email
 * @property string|null $emergency_call
 * @property string|null $offer_perihal
 * @property string|null $offer_description
 * @property string|null $offer_info
 * @property string|null $manifest_type
 * @property string|null $manifest_code
 * @property string|null $offer_code
 * @property string|null $sign_1
 * @property string|null $sign_2
 * @property string|null $sign_3
 * @property string|null $sign_4
 * @property string|null $mou_code
 * @property int|null $transporter_id
 * @property string|null $header
 * @property string|null $footer
 * @property string|null $desc
 * @property string|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $status
 * @property string|null $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Transporter[] $transporters
 * @property \App\Model\Entity\AccAccountMapping[] $acc_account_mappings
 * @property \App\Model\Entity\AccAccount[] $acc_accounts
 * @property \App\Model\Entity\AccBeginningBalance[] $acc_beginning_balances
 * @property \App\Model\Entity\AccChartOfAccount[] $acc_chart_of_accounts
 * @property \App\Model\Entity\AccJournalBankLine[] $acc_journal_bank_lines
 * @property \App\Model\Entity\AccJournalBank[] $acc_journal_banks
 * @property \App\Model\Entity\AccJournalCashLine[] $acc_journal_cash_lines
 * @property \App\Model\Entity\AccJournalCash[] $acc_journal_cashes
 * @property \App\Model\Entity\AccJournalLine[] $acc_journal_lines
 * @property \App\Model\Entity\AccJournalMapping[] $acc_journal_mappings
 * @property \App\Model\Entity\AccJournalMemorialLine[] $acc_journal_memorial_lines
 * @property \App\Model\Entity\AccJournalMemorial[] $acc_journal_memorials
 * @property \App\Model\Entity\AccJournal[] $acc_journals
 * @property \App\Model\Entity\Calk[] $calks
 * @property \App\Model\Entity\Certificate[] $certificates
 * @property \App\Model\Entity\CommissionDetail[] $commission_details
 * @property \App\Model\Entity\Commission[] $commissions
 * @property \App\Model\Entity\Creditor[] $creditors
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\CustomersOri[] $customers_ori
 * @property \App\Model\Entity\DataInvoice[] $data_invoices
 * @property \App\Model\Entity\DataTax[] $data_taxes
 * @property \App\Model\Entity\Deposit[] $deposits
 * @property \App\Model\Entity\Depreciation[] $depreciations
 * @property \App\Model\Entity\Depreciationse[] $depreciationse
 * @property \App\Model\Entity\Depreciations[] $depreciationss
 * @property \App\Model\Entity\Driver[] $drivers
 * @property \App\Model\Entity\InvoiceDeposit[] $invoice_deposits
 * @property \App\Model\Entity\InvoiceEntry[] $invoice_entries
 * @property \App\Model\Entity\InvoiceHutang[] $invoice_hutangs
 * @property \App\Model\Entity\InvoiceOut[] $invoice_outs
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\Log[] $logs
 * @property \App\Model\Entity\ManifestDirect[] $manifest_directs
 * @property \App\Model\Entity\ManifestInside[] $manifest_insides
 * @property \App\Model\Entity\ManifestLogbook[] $manifest_logbooks
 * @property \App\Model\Entity\ManifestProcessor[] $manifest_processors
 * @property \App\Model\Entity\Manifest[] $manifests
 * @property \App\Model\Entity\MouC[] $mou_cs
 * @property \App\Model\Entity\Mouse[] $mouses
 * @property \App\Model\Entity\Number[] $numbers
 * @property \App\Model\Entity\Offer[] $offers
 * @property \App\Model\Entity\OperationalLine[] $operational_lines
 * @property \App\Model\Entity\Operational[] $operationals
 * @property \App\Model\Entity\OrderRegular[] $order_regulars
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Orders230129[] $orders230129
 * @property \App\Model\Entity\OrdersOri[] $orders_ori
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\Permit[] $permits
 * @property \App\Model\Entity\PettyCashBankTopup[] $petty_cash_bank_topups
 * @property \App\Model\Entity\PettyCashBank[] $petty_cash_banks
 * @property \App\Model\Entity\PettyCashTopup[] $petty_cash_topups
 * @property \App\Model\Entity\PettyCash[] $petty_cashes
 * @property \App\Model\Entity\ProcessorPrice[] $processor_prices
 * @property \App\Model\Entity\Processor[] $processors
 * @property \App\Model\Entity\Project[] $projects
 * @property \App\Model\Entity\RecipientPayer[] $recipient_payers
 * @property \App\Model\Entity\Setting[] $settings
 * @property \App\Model\Entity\Template[] $templates
 * @property \App\Model\Entity\TransporterPrice[] $transporter_prices
 * @property \App\Model\Entity\TruckInspection[] $truck_inspections
 * @property \App\Model\Entity\TruckSchedule[] $truck_schedules
 * @property \App\Model\Entity\Truck[] $trucks
 * @property \App\Model\Entity\TrucksOri[] $trucks_ori
 * @property \App\Model\Entity\UnidentifiedIncome[] $unidentified_incomes
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\WastePrice[] $waste_prices
 * @property \App\Model\Entity\WasteType[] $waste_types
 * @property \App\Model\Entity\Waste[] $wastes
 */
class Branch extends Entity
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
        'code' => true,
        'name' => true,
        'company_name' => true,
        'company_address' => true,
        'business_fields' => true,
        'company_telp' => true,
        'company_fax' => true,
        'company_npwp' => true,
        'company_director' => true,
        'company_director_1' => true,
        'sign_title_1' => true,
        'company_director_2' => true,
        'sign_title_2' => true,
        'company_director_3' => true,
        'sign_title_3' => true,
        'company_director_4' => true,
        'sign_title_4' => true,
        'warehouse_address' => true,
        'warehouse_telp' => true,
        'warehouse_fax' => true,
        'manifest_number' => true,
        'invoice_code' => true,
        'invoice_number' => true,
        'invoice_number_include' => true,
        'invoice_evidence_email' => true,
        'faktur_pajak_number' => true,
        'berita_acara_number' => true,
        'permit_number' => true,
        'offer_number' => true,
        'offer_year' => true,
        'bank' => true,
        'norek' => true,
        'an' => true,
        'bank_name_1' => true,
        'bank_norek_1' => true,
        'bank_an_1' => true,
        'bank_name_2' => true,
        'bank_norek_2' => true,
        'bank_an_2' => true,
        'bank_name_3' => true,
        'bank_norek_3' => true,
        'bank_an_3' => true,
        'bank_name_4' => true,
        'bank_norek_4' => true,
        'bank_an_4' => true,
        'bank_name_5' => true,
        'bank_norek_5' => true,
        'bank_an_5' => true,
        'va_bank_an' => true,
        'va_bank_name' => true,
        'va_bank_branch' => true,
        'va_bank_norek' => true,
        'wa_invoice' => true,
        'city_invoice' => true,
        'email' => true,
        'emergency_call' => true,
        'offer_perihal' => true,
        'offer_description' => true,
        'offer_info' => true,
        'manifest_type' => true,
        'manifest_code' => true,
        'offer_code' => true,
        'sign_1' => true,
        'sign_2' => true,
        'sign_3' => true,
        'sign_4' => true,
        'mou_code' => true,
        'transporter_id' => true,
        'header' => true,
        'footer' => true,
        'desc' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'status' => true,
        'is_active' => true,
        'is_log' => true,
        'transporters' => true,
        'acc_account_mappings' => true,
        'acc_accounts' => true,
        'acc_beginning_balances' => true,
        'acc_chart_of_accounts' => true,
        'acc_journal_bank_lines' => true,
        'acc_journal_banks' => true,
        'acc_journal_cash_lines' => true,
        'acc_journal_cashes' => true,
        'acc_journal_lines' => true,
        'acc_journal_mappings' => true,
        'acc_journal_memorial_lines' => true,
        'acc_journal_memorials' => true,
        'acc_journals' => true,
        'calks' => true,
        'certificates' => true,
        'commission_details' => true,
        'commissions' => true,
        'creditors' => true,
        'customers' => true,
        'customers_ori' => true,
        'data_invoices' => true,
        'data_taxes' => true,
        'deposits' => true,
        'depreciations' => true,
        'depreciationse' => true,
        'depreciationss' => true,
        'drivers' => true,
        'invoice_deposits' => true,
        'invoice_entries' => true,
        'invoice_hutangs' => true,
        'invoice_outs' => true,
        'invoices' => true,
        'logs' => true,
        'manifest_directs' => true,
        'manifest_insides' => true,
        'manifest_logbooks' => true,
        'manifest_processors' => true,
        'manifests' => true,
        'mou_cs' => true,
        'mouses' => true,
        'numbers' => true,
        'offers' => true,
        'operational_lines' => true,
        'operationals' => true,
        'order_regulars' => true,
        'orders' => true,
        'orders230129' => true,
        'orders_ori' => true,
        'payments' => true,
        'permits' => true,
        'petty_cash_bank_topups' => true,
        'petty_cash_banks' => true,
        'petty_cash_topups' => true,
        'petty_cashes' => true,
        'processor_prices' => true,
        'processors' => true,
        'projects' => true,
        'recipient_payers' => true,
        'settings' => true,
        'templates' => true,
        'transporter_prices' => true,
        'truck_inspections' => true,
        'truck_schedules' => true,
        'trucks' => true,
        'trucks_ori' => true,
        'unidentified_incomes' => true,
        'users' => true,
        'waste_prices' => true,
        'waste_types' => true,
        'wastes' => true,
    ];
}
