<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Branches Model
 *
 * @property \App\Model\Table\TransportersTable&\Cake\ORM\Association\BelongsTo $Transporters
 * @property \App\Model\Table\AccAccountMappingsTable&\Cake\ORM\Association\HasMany $AccAccountMappings
 * @property \App\Model\Table\AccAccountsTable&\Cake\ORM\Association\HasMany $AccAccounts
 * @property \App\Model\Table\AccBeginningBalancesTable&\Cake\ORM\Association\HasMany $AccBeginningBalances
 * @property \App\Model\Table\AccChartOfAccountsTable&\Cake\ORM\Association\HasMany $AccChartOfAccounts
 * @property \App\Model\Table\AccJournalBankLinesTable&\Cake\ORM\Association\HasMany $AccJournalBankLines
 * @property \App\Model\Table\AccJournalBanksTable&\Cake\ORM\Association\HasMany $AccJournalBanks
 * @property \App\Model\Table\AccJournalCashLinesTable&\Cake\ORM\Association\HasMany $AccJournalCashLines
 * @property \App\Model\Table\AccJournalCashesTable&\Cake\ORM\Association\HasMany $AccJournalCashes
 * @property \App\Model\Table\AccJournalLinesTable&\Cake\ORM\Association\HasMany $AccJournalLines
 * @property \App\Model\Table\AccJournalMappingsTable&\Cake\ORM\Association\HasMany $AccJournalMappings
 * @property \App\Model\Table\AccJournalMemorialLinesTable&\Cake\ORM\Association\HasMany $AccJournalMemorialLines
 * @property \App\Model\Table\AccJournalMemorialsTable&\Cake\ORM\Association\HasMany $AccJournalMemorials
 * @property \App\Model\Table\AccJournalsTable&\Cake\ORM\Association\HasMany $AccJournals
 * @property \App\Model\Table\CalksTable&\Cake\ORM\Association\HasMany $Calks
 * @property \App\Model\Table\CertificatesTable&\Cake\ORM\Association\HasMany $Certificates
 * @property \App\Model\Table\CommissionDetailsTable&\Cake\ORM\Association\HasMany $CommissionDetails
 * @property \App\Model\Table\CommissionsTable&\Cake\ORM\Association\HasMany $Commissions
 * @property \App\Model\Table\CreditorsTable&\Cake\ORM\Association\HasMany $Creditors
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\HasMany $Customers
 * @property \App\Model\Table\CustomersOriTable&\Cake\ORM\Association\HasMany $CustomersOri
 * @property \App\Model\Table\DataInvoicesTable&\Cake\ORM\Association\HasMany $DataInvoices
 * @property \App\Model\Table\DataTaxesTable&\Cake\ORM\Association\HasMany $DataTaxes
 * @property \App\Model\Table\DepositsTable&\Cake\ORM\Association\HasMany $Deposits
 * @property \App\Model\Table\DepreciationsTable&\Cake\ORM\Association\HasMany $Depreciations
 * @property \App\Model\Table\DepreciationseTable&\Cake\ORM\Association\HasMany $Depreciationse
 * @property \App\Model\Table\DepreciationssTable&\Cake\ORM\Association\HasMany $Depreciationss
 * @property \App\Model\Table\DriversTable&\Cake\ORM\Association\HasMany $Drivers
 * @property \App\Model\Table\InvoiceDepositsTable&\Cake\ORM\Association\HasMany $InvoiceDeposits
 * @property \App\Model\Table\InvoiceEntriesTable&\Cake\ORM\Association\HasMany $InvoiceEntries
 * @property \App\Model\Table\InvoiceHutangsTable&\Cake\ORM\Association\HasMany $InvoiceHutangs
 * @property \App\Model\Table\InvoiceOutsTable&\Cake\ORM\Association\HasMany $InvoiceOuts
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\HasMany $Invoices
 * @property \App\Model\Table\LogsTable&\Cake\ORM\Association\HasMany $Logs
 * @property \App\Model\Table\ManifestDirectsTable&\Cake\ORM\Association\HasMany $ManifestDirects
 * @property \App\Model\Table\ManifestInsidesTable&\Cake\ORM\Association\HasMany $ManifestInsides
 * @property \App\Model\Table\ManifestLogbooksTable&\Cake\ORM\Association\HasMany $ManifestLogbooks
 * @property \App\Model\Table\ManifestProcessorsTable&\Cake\ORM\Association\HasMany $ManifestProcessors
 * @property \App\Model\Table\ManifestsTable&\Cake\ORM\Association\HasMany $Manifests
 * @property \App\Model\Table\MouCsTable&\Cake\ORM\Association\HasMany $MouCs
 * @property \App\Model\Table\MousesTable&\Cake\ORM\Association\HasMany $Mouses
 * @property \App\Model\Table\NumbersTable&\Cake\ORM\Association\HasMany $Numbers
 * @property \App\Model\Table\OffersTable&\Cake\ORM\Association\HasMany $Offers
 * @property \App\Model\Table\OperationalLinesTable&\Cake\ORM\Association\HasMany $OperationalLines
 * @property \App\Model\Table\OperationalsTable&\Cake\ORM\Association\HasMany $Operationals
 * @property \App\Model\Table\OrderRegularsTable&\Cake\ORM\Association\HasMany $OrderRegulars
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\Orders230129Table&\Cake\ORM\Association\HasMany $Orders230129
 * @property \App\Model\Table\OrdersOriTable&\Cake\ORM\Association\HasMany $OrdersOri
 * @property \App\Model\Table\PaymentsTable&\Cake\ORM\Association\HasMany $Payments
 * @property \App\Model\Table\PermitsTable&\Cake\ORM\Association\HasMany $Permits
 * @property \App\Model\Table\PettyCashBankTopupsTable&\Cake\ORM\Association\HasMany $PettyCashBankTopups
 * @property \App\Model\Table\PettyCashBanksTable&\Cake\ORM\Association\HasMany $PettyCashBanks
 * @property \App\Model\Table\PettyCashTopupsTable&\Cake\ORM\Association\HasMany $PettyCashTopups
 * @property \App\Model\Table\PettyCashesTable&\Cake\ORM\Association\HasMany $PettyCashes
 * @property \App\Model\Table\ProcessorPricesTable&\Cake\ORM\Association\HasMany $ProcessorPrices
 * @property \App\Model\Table\ProcessorsTable&\Cake\ORM\Association\HasMany $Processors
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\HasMany $Projects
 * @property \App\Model\Table\RecipientPayersTable&\Cake\ORM\Association\HasMany $RecipientPayers
 * @property \App\Model\Table\SettingsTable&\Cake\ORM\Association\HasMany $Settings
 * @property \App\Model\Table\TemplatesTable&\Cake\ORM\Association\HasMany $Templates
 * @property \App\Model\Table\TransporterPricesTable&\Cake\ORM\Association\HasMany $TransporterPrices
 * @property \App\Model\Table\TransportersTable&\Cake\ORM\Association\HasMany $Transporters
 * @property \App\Model\Table\TruckInspectionsTable&\Cake\ORM\Association\HasMany $TruckInspections
 * @property \App\Model\Table\TruckSchedulesTable&\Cake\ORM\Association\HasMany $TruckSchedules
 * @property \App\Model\Table\TrucksTable&\Cake\ORM\Association\HasMany $Trucks
 * @property \App\Model\Table\TrucksOriTable&\Cake\ORM\Association\HasMany $TrucksOri
 * @property \App\Model\Table\UnidentifiedIncomesTable&\Cake\ORM\Association\HasMany $UnidentifiedIncomes
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @property \App\Model\Table\WastePricesTable&\Cake\ORM\Association\HasMany $WastePrices
 * @property \App\Model\Table\WasteTypesTable&\Cake\ORM\Association\HasMany $WasteTypes
 * @property \App\Model\Table\WastesTable&\Cake\ORM\Association\HasMany $Wastes
 *
 * @method \App\Model\Entity\Branch newEmptyEntity()
 * @method \App\Model\Entity\Branch newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Branch[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Branch get($primaryKey, $options = [])
 * @method \App\Model\Entity\Branch findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Branch patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Branch[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Branch|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Branch saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BranchesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('branches');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Transporters', [
            'foreignKey' => 'transporter_id',
        ]);
        $this->hasMany('AccAccountMappings', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccAccounts', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccBeginningBalances', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccChartOfAccounts', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournalBankLines', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournalBanks', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournalCashLines', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournalCashes', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournalLines', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournalMappings', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournalMemorialLines', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournalMemorials', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('AccJournals', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Calks', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Certificates', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('CommissionDetails', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Commissions', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Creditors', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Customers', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('CustomersOri', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('DataInvoices', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('DataTaxes', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Deposits', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Depreciations', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Depreciationse', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Depreciationss', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Drivers', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('InvoiceDeposits', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('InvoiceEntries', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('InvoiceHutangs', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('InvoiceOuts', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Invoices', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('ManifestDirects', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('ManifestInsides', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('ManifestLogbooks', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('ManifestProcessors', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Manifests', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('MouCs', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Mouses', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Numbers', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Offers', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('OperationalLines', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Operationals', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('OrderRegulars', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Orders230129', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('OrdersOri', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Permits', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('PettyCashBankTopups', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('PettyCashBanks', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('PettyCashTopups', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('PettyCashes', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('ProcessorPrices', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Processors', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Projects', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('RecipientPayers', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Settings', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Templates', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('TransporterPrices', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Transporters', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('TruckInspections', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('TruckSchedules', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Trucks', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('TrucksOri', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('UnidentifiedIncomes', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('WastePrices', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('WasteTypes', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Wastes', [
            'foreignKey' => 'branch_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->allowEmptyString('name');

        $validator
            ->scalar('company_name')
            ->maxLength('company_name', 255)
            ->allowEmptyString('company_name');

        $validator
            ->scalar('company_address')
            ->maxLength('company_address', 255)
            ->allowEmptyString('company_address');

        $validator
            ->scalar('business_fields')
            ->maxLength('business_fields', 255)
            ->allowEmptyString('business_fields');

        $validator
            ->scalar('company_telp')
            ->maxLength('company_telp', 255)
            ->allowEmptyString('company_telp');

        $validator
            ->scalar('company_fax')
            ->maxLength('company_fax', 255)
            ->allowEmptyString('company_fax');

        $validator
            ->scalar('company_npwp')
            ->maxLength('company_npwp', 255)
            ->allowEmptyString('company_npwp');

        $validator
            ->scalar('company_director')
            ->maxLength('company_director', 255)
            ->allowEmptyString('company_director');

        $validator
            ->scalar('company_director_1')
            ->maxLength('company_director_1', 255)
            ->allowEmptyString('company_director_1');

        $validator
            ->scalar('sign_title_1')
            ->maxLength('sign_title_1', 255)
            ->allowEmptyString('sign_title_1');

        $validator
            ->scalar('company_director_2')
            ->maxLength('company_director_2', 255)
            ->allowEmptyString('company_director_2');

        $validator
            ->scalar('sign_title_2')
            ->maxLength('sign_title_2', 255)
            ->allowEmptyString('sign_title_2');

        $validator
            ->scalar('company_director_3')
            ->maxLength('company_director_3', 255)
            ->allowEmptyString('company_director_3');

        $validator
            ->scalar('sign_title_3')
            ->maxLength('sign_title_3', 255)
            ->allowEmptyString('sign_title_3');

        $validator
            ->scalar('company_director_4')
            ->maxLength('company_director_4', 255)
            ->allowEmptyString('company_director_4');

        $validator
            ->scalar('sign_title_4')
            ->maxLength('sign_title_4', 255)
            ->allowEmptyString('sign_title_4');

        $validator
            ->scalar('warehouse_address')
            ->maxLength('warehouse_address', 255)
            ->allowEmptyString('warehouse_address');

        $validator
            ->scalar('warehouse_telp')
            ->maxLength('warehouse_telp', 255)
            ->allowEmptyString('warehouse_telp');

        $validator
            ->scalar('warehouse_fax')
            ->maxLength('warehouse_fax', 255)
            ->allowEmptyString('warehouse_fax');

        $validator
            ->scalar('manifest_number')
            ->maxLength('manifest_number', 255)
            ->allowEmptyString('manifest_number');

        $validator
            ->scalar('invoice_code')
            ->maxLength('invoice_code', 255)
            ->allowEmptyString('invoice_code');

        $validator
            ->scalar('invoice_number')
            ->maxLength('invoice_number', 255)
            ->allowEmptyString('invoice_number');

        $validator
            ->scalar('invoice_number_include')
            ->maxLength('invoice_number_include', 255)
            ->allowEmptyString('invoice_number_include');

        $validator
            ->scalar('invoice_evidence_email')
            ->maxLength('invoice_evidence_email', 255)
            ->allowEmptyString('invoice_evidence_email');

        $validator
            ->scalar('faktur_pajak_number')
            ->maxLength('faktur_pajak_number', 255)
            ->allowEmptyString('faktur_pajak_number');

        $validator
            ->scalar('berita_acara_number')
            ->maxLength('berita_acara_number', 255)
            ->allowEmptyString('berita_acara_number');

        $validator
            ->scalar('permit_number')
            ->maxLength('permit_number', 255)
            ->allowEmptyString('permit_number');

        $validator
            ->scalar('offer_number')
            ->maxLength('offer_number', 255)
            ->allowEmptyString('offer_number');

        $validator
            ->scalar('offer_year')
            ->maxLength('offer_year', 255)
            ->allowEmptyString('offer_year');

        $validator
            ->scalar('bank')
            ->maxLength('bank', 255)
            ->allowEmptyString('bank');

        $validator
            ->scalar('norek')
            ->maxLength('norek', 255)
            ->allowEmptyString('norek');

        $validator
            ->scalar('an')
            ->maxLength('an', 255)
            ->allowEmptyString('an');

        $validator
            ->scalar('bank_name_1')
            ->maxLength('bank_name_1', 255)
            ->allowEmptyString('bank_name_1');

        $validator
            ->scalar('bank_norek_1')
            ->maxLength('bank_norek_1', 255)
            ->allowEmptyString('bank_norek_1');

        $validator
            ->scalar('bank_an_1')
            ->maxLength('bank_an_1', 255)
            ->allowEmptyString('bank_an_1');

        $validator
            ->scalar('bank_name_2')
            ->maxLength('bank_name_2', 255)
            ->allowEmptyString('bank_name_2');

        $validator
            ->scalar('bank_norek_2')
            ->maxLength('bank_norek_2', 255)
            ->allowEmptyString('bank_norek_2');

        $validator
            ->scalar('bank_an_2')
            ->maxLength('bank_an_2', 255)
            ->allowEmptyString('bank_an_2');

        $validator
            ->scalar('bank_name_3')
            ->maxLength('bank_name_3', 255)
            ->allowEmptyString('bank_name_3');

        $validator
            ->scalar('bank_norek_3')
            ->maxLength('bank_norek_3', 255)
            ->allowEmptyString('bank_norek_3');

        $validator
            ->scalar('bank_an_3')
            ->maxLength('bank_an_3', 255)
            ->allowEmptyString('bank_an_3');

        $validator
            ->scalar('bank_name_4')
            ->maxLength('bank_name_4', 255)
            ->allowEmptyString('bank_name_4');

        $validator
            ->scalar('bank_norek_4')
            ->maxLength('bank_norek_4', 255)
            ->allowEmptyString('bank_norek_4');

        $validator
            ->scalar('bank_an_4')
            ->maxLength('bank_an_4', 255)
            ->allowEmptyString('bank_an_4');

        $validator
            ->scalar('bank_name_5')
            ->maxLength('bank_name_5', 255)
            ->allowEmptyString('bank_name_5');

        $validator
            ->scalar('bank_norek_5')
            ->maxLength('bank_norek_5', 255)
            ->allowEmptyString('bank_norek_5');

        $validator
            ->scalar('bank_an_5')
            ->maxLength('bank_an_5', 255)
            ->allowEmptyString('bank_an_5');

        $validator
            ->scalar('va_bank_an')
            ->maxLength('va_bank_an', 255)
            ->allowEmptyString('va_bank_an');

        $validator
            ->scalar('va_bank_name')
            ->maxLength('va_bank_name', 255)
            ->allowEmptyString('va_bank_name');

        $validator
            ->scalar('va_bank_branch')
            ->maxLength('va_bank_branch', 255)
            ->allowEmptyString('va_bank_branch');

        $validator
            ->scalar('va_bank_norek')
            ->maxLength('va_bank_norek', 255)
            ->allowEmptyString('va_bank_norek');

        $validator
            ->scalar('wa_invoice')
            ->maxLength('wa_invoice', 255)
            ->allowEmptyString('wa_invoice');

        $validator
            ->scalar('city_invoice')
            ->maxLength('city_invoice', 255)
            ->allowEmptyString('city_invoice');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('emergency_call')
            ->maxLength('emergency_call', 255)
            ->allowEmptyString('emergency_call');

        $validator
            ->scalar('offer_perihal')
            ->maxLength('offer_perihal', 255)
            ->allowEmptyString('offer_perihal');

        $validator
            ->scalar('offer_description')
            ->allowEmptyString('offer_description');

        $validator
            ->scalar('offer_info')
            ->maxLength('offer_info', 255)
            ->allowEmptyString('offer_info');

        $validator
            ->scalar('manifest_type')
            ->maxLength('manifest_type', 50)
            ->allowEmptyString('manifest_type');

        $validator
            ->scalar('manifest_code')
            ->maxLength('manifest_code', 50)
            ->allowEmptyString('manifest_code');

        $validator
            ->scalar('offer_code')
            ->maxLength('offer_code', 100)
            ->allowEmptyString('offer_code');

        $validator
            ->scalar('sign_1')
            ->maxLength('sign_1', 100)
            ->allowEmptyString('sign_1');

        $validator
            ->scalar('sign_2')
            ->maxLength('sign_2', 100)
            ->allowEmptyString('sign_2');

        $validator
            ->scalar('sign_3')
            ->maxLength('sign_3', 100)
            ->allowEmptyString('sign_3');

        $validator
            ->scalar('sign_4')
            ->maxLength('sign_4', 100)
            ->allowEmptyString('sign_4');

        $validator
            ->scalar('mou_code')
            ->maxLength('mou_code', 100)
            ->allowEmptyString('mou_code');

        $validator
            ->scalar('header')
            ->maxLength('header', 100)
            ->allowEmptyString('header');

        $validator
            ->scalar('footer')
            ->maxLength('footer', 100)
            ->allowEmptyString('footer');

        $validator
            ->scalar('desc')
            ->maxLength('desc', 255)
            ->allowEmptyString('desc');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 50)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 50)
            ->allowEmptyString('is_update');

        $validator
            ->scalar('is_delete')
            ->maxLength('is_delete', 50)
            ->allowEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->scalar('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['transporter_id'], 'Transporters'), ['errorField' => 'transporter_id']);

        return $rules;
    }
}
