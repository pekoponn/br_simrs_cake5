<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\MarketingsTable&\Cake\ORM\Association\BelongsTo $Marketings
 * @property \App\Model\Table\DataInvoicesTable&\Cake\ORM\Association\BelongsTo $DataInvoices
 * @property \App\Model\Table\DataTaxesTable&\Cake\ORM\Association\BelongsTo $DataTaxes
 * @property \App\Model\Table\MousTable&\Cake\ORM\Association\BelongsTo $Mous
 * @property \App\Model\Table\AccCashesTable&\Cake\ORM\Association\HasMany $AccCashes
 * @property \App\Model\Table\AccChartOfAccountsTable&\Cake\ORM\Association\HasMany $AccChartOfAccounts
 * @property \App\Model\Table\AccJournalBanksTable&\Cake\ORM\Association\HasMany $AccJournalBanks
 * @property \App\Model\Table\AccJournalCashesTable&\Cake\ORM\Association\HasMany $AccJournalCashes
 * @property \App\Model\Table\AccJournalMemorialsTable&\Cake\ORM\Association\HasMany $AccJournalMemorials
 * @property \App\Model\Table\AccJournalsTable&\Cake\ORM\Association\HasMany $AccJournals
 * @property \App\Model\Table\CertificatesTable&\Cake\ORM\Association\HasMany $Certificates
 * @property \App\Model\Table\CommissionDetailsTable&\Cake\ORM\Association\HasMany $CommissionDetails
 * @property \App\Model\Table\InvoiceDepositsTable&\Cake\ORM\Association\HasMany $InvoiceDeposits
 * @property \App\Model\Table\InvoiceEntriesTable&\Cake\ORM\Association\HasMany $InvoiceEntries
 * @property \App\Model\Table\InvoiceOutsTable&\Cake\ORM\Association\HasMany $InvoiceOuts
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\HasMany $Invoices
 * @property \App\Model\Table\ManifestInsidesTable&\Cake\ORM\Association\HasMany $ManifestInsides
 * @property \App\Model\Table\ManifestProcessorsTable&\Cake\ORM\Association\HasMany $ManifestProcessors
 * @property \App\Model\Table\ManifestsTable&\Cake\ORM\Association\HasMany $Manifests
 * @property \App\Model\Table\MousesTable&\Cake\ORM\Association\HasMany $Mouses
 * @property \App\Model\Table\OffersTable&\Cake\ORM\Association\HasMany $Offers
 * @property \App\Model\Table\OperationalsTable&\Cake\ORM\Association\HasMany $Operationals
 * @property \App\Model\Table\OrderRegularLinesTable&\Cake\ORM\Association\HasMany $OrderRegularLines
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\Orders230129Table&\Cake\ORM\Association\HasMany $Orders230129
 * @property \App\Model\Table\OrdersOriTable&\Cake\ORM\Association\HasMany $OrdersOri
 * @property \App\Model\Table\PermitsTable&\Cake\ORM\Association\HasMany $Permits
 * @property \App\Model\Table\TruckSchedulesTable&\Cake\ORM\Association\HasMany $TruckSchedules
 * @property \App\Model\Table\UnidentifiedIncomesTable&\Cake\ORM\Association\HasMany $UnidentifiedIncomes
 * @property \App\Model\Table\WastePricesTable&\Cake\ORM\Association\HasMany $WastePrices
 * @property \App\Model\Table\WastesTable&\Cake\ORM\Association\HasMany $Wastes
 *
 * @method \App\Model\Entity\Customer newEmptyEntity()
 * @method \App\Model\Entity\Customer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Customer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersTable extends Table
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

        $this->setTable('customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'marketing_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Mouses', [
            'foreignKey' => 'mou_id',
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
            ->scalar('code_ori')
            ->maxLength('code_ori', 20)
            ->allowEmptyString('code_ori');

        $validator
            ->scalar('code')
            ->maxLength('code', 20)
            ->allowEmptyString('code');

        $validator
            ->scalar('title')
            ->maxLength('title', 50)
            ->allowEmptyString('title');

        $validator
            ->scalar('title_old')
            ->maxLength('title_old', 50)
            ->allowEmptyString('title_old');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 255)
            ->allowEmptyString('nickname');

        $validator
            ->scalar('nickname_old')
            ->maxLength('nickname_old', 255)
            ->allowEmptyString('nickname_old');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('name_old')
            ->maxLength('name_old', 255)
            ->allowEmptyString('name_old');

        $validator
            ->scalar('name_fake')
            ->maxLength('name_fake', 255)
            ->allowEmptyString('name_fake');

        $validator
            ->scalar('check_fake')
            ->allowEmptyString('check_fake');

        $validator
            ->scalar('deposit_mou')
            ->allowEmptyString('deposit_mou');

        $validator
            ->scalar('type')
            ->allowEmptyString('type');

        $validator
            ->scalar('group')
            ->allowEmptyString('group');

        $validator
            ->scalar('practice_day')
            ->maxLength('practice_day', 255)
            ->allowEmptyString('practice_day');

        $validator
            ->scalar('practice_hours_start')
            ->maxLength('practice_hours_start', 255)
            ->allowEmptyString('practice_hours_start');

        $validator
            ->scalar('practice_hours_end')
            ->maxLength('practice_hours_end', 255)
            ->allowEmptyString('practice_hours_end');

        $validator
            ->scalar('tax')
            ->allowEmptyString('tax');

        $validator
            ->integer('taxing')
            ->notEmptyString('taxing');

        $validator
            ->scalar('pph')
            ->allowEmptyString('pph');

        $validator
            ->scalar('va')
            ->maxLength('va', 100)
            ->allowEmptyString('va');

        $validator
            ->scalar('treatment')
            ->allowEmptyString('treatment');

        $validator
            ->scalar('contact_person')
            ->maxLength('contact_person', 255)
            ->allowEmptyString('contact_person');

        $validator
            ->scalar('dept_person')
            ->maxLength('dept_person', 255)
            ->allowEmptyString('dept_person');

        $validator
            ->scalar('telp_person')
            ->maxLength('telp_person', 255)
            ->allowEmptyString('telp_person');

        $validator
            ->scalar('warehouse_address')
            ->maxLength('warehouse_address', 255)
            ->allowEmptyString('warehouse_address');

        $validator
            ->scalar('warehouse_telp')
            ->maxLength('warehouse_telp', 255)
            ->allowEmptyString('warehouse_telp');

        $validator
            ->scalar('address_penghasil')
            ->allowEmptyString('address_penghasil');

        $validator
            ->scalar('supplier')
            ->maxLength('supplier', 255)
            ->allowEmptyString('supplier');

        $validator
            ->scalar('address_supplier')
            ->allowEmptyString('address_supplier');

        $validator
            ->scalar('phone_supplier')
            ->maxLength('phone_supplier', 30)
            ->allowEmptyString('phone_supplier');

        $validator
            ->scalar('fax_supplier')
            ->maxLength('fax_supplier', 30)
            ->allowEmptyString('fax_supplier');

        $validator
            ->scalar('name_invoice')
            ->maxLength('name_invoice', 100)
            ->allowEmptyString('name_invoice');

        $validator
            ->scalar('address_invoice')
            ->allowEmptyString('address_invoice');

        $validator
            ->scalar('phone_invoice')
            ->maxLength('phone_invoice', 30)
            ->allowEmptyString('phone_invoice');

        $validator
            ->scalar('fax_invoice')
            ->maxLength('fax_invoice', 30)
            ->allowEmptyString('fax_invoice');

        $validator
            ->scalar('name_tax_invoice')
            ->maxLength('name_tax_invoice', 100)
            ->allowEmptyString('name_tax_invoice');

        $validator
            ->scalar('address_tax_invoice')
            ->allowEmptyString('address_tax_invoice');

        $validator
            ->scalar('phone_tax_invoice')
            ->maxLength('phone_tax_invoice', 30)
            ->allowEmptyString('phone_tax_invoice');

        $validator
            ->scalar('fax_tax_invoice')
            ->maxLength('fax_tax_invoice', 30)
            ->allowEmptyString('fax_tax_invoice');

        $validator
            ->scalar('bank_an_ori')
            ->maxLength('bank_an_ori', 50)
            ->allowEmptyString('bank_an_ori');

        $validator
            ->scalar('bank_name_ori')
            ->maxLength('bank_name_ori', 50)
            ->allowEmptyString('bank_name_ori');

        $validator
            ->scalar('bank_norek_ori')
            ->maxLength('bank_norek_ori', 50)
            ->allowEmptyString('bank_norek_ori');

        $validator
            ->scalar('bank_an')
            ->maxLength('bank_an', 50)
            ->allowEmptyString('bank_an');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 50)
            ->allowEmptyString('bank_name');

        $validator
            ->scalar('bank_norek')
            ->maxLength('bank_norek', 50)
            ->allowEmptyString('bank_norek');

        $validator
            ->scalar('va_an')
            ->maxLength('va_an', 50)
            ->allowEmptyString('va_an');

        $validator
            ->scalar('va_name')
            ->maxLength('va_name', 50)
            ->allowEmptyString('va_name');

        $validator
            ->scalar('va_no')
            ->maxLength('va_no', 50)
            ->allowEmptyString('va_no');

        $validator
            ->scalar('giro_no')
            ->maxLength('giro_no', 50)
            ->allowEmptyString('giro_no');

        $validator
            ->scalar('rek_name')
            ->maxLength('rek_name', 50)
            ->allowEmptyString('rek_name');

        $validator
            ->scalar('rek_no')
            ->maxLength('rek_no', 50)
            ->allowEmptyString('rek_no');

        $validator
            ->scalar('rek_bank')
            ->maxLength('rek_bank', 50)
            ->allowEmptyString('rek_bank');

        $validator
            ->scalar('npwp')
            ->maxLength('npwp', 100)
            ->allowEmptyString('npwp');

        $validator
            ->scalar('ppn')
            ->allowEmptyString('ppn');

        $validator
            ->scalar('city')
            ->maxLength('city', 50)
            ->allowEmptyString('city');

        $validator
            ->scalar('province')
            ->maxLength('province', 100)
            ->allowEmptyString('province');

        $validator
            ->scalar('district')
            ->maxLength('district', 100)
            ->allowEmptyString('district');

        $validator
            ->integer('postal')
            ->allowEmptyString('postal');

        $validator
            ->scalar('country')
            ->maxLength('country', 50)
            ->allowEmptyString('country');

        $validator
            ->scalar('phone3')
            ->maxLength('phone3', 30)
            ->allowEmptyString('phone3');

        $validator
            ->scalar('phone4')
            ->maxLength('phone4', 30)
            ->allowEmptyString('phone4');

        $validator
            ->scalar('phone5')
            ->maxLength('phone5', 30)
            ->allowEmptyString('phone5');

        $validator
            ->scalar('email1')
            ->maxLength('email1', 255)
            ->allowEmptyString('email1');

        $validator
            ->scalar('email2')
            ->maxLength('email2', 255)
            ->allowEmptyString('email2');

        $validator
            ->scalar('email3')
            ->maxLength('email3', 255)
            ->allowEmptyString('email3');

        $validator
            ->scalar('email4')
            ->maxLength('email4', 255)
            ->allowEmptyString('email4');

        $validator
            ->scalar('email5')
            ->maxLength('email5', 255)
            ->allowEmptyString('email5');

        $validator
            ->scalar('fb1')
            ->maxLength('fb1', 30)
            ->allowEmptyString('fb1');

        $validator
            ->scalar('fb2')
            ->maxLength('fb2', 30)
            ->allowEmptyString('fb2');

        $validator
            ->scalar('ym1')
            ->maxLength('ym1', 30)
            ->allowEmptyString('ym1');

        $validator
            ->scalar('ym2')
            ->maxLength('ym2', 30)
            ->allowEmptyString('ym2');

        $validator
            ->scalar('ym3')
            ->maxLength('ym3', 30)
            ->allowEmptyString('ym3');

        $validator
            ->scalar('ym4')
            ->maxLength('ym4', 30)
            ->allowEmptyString('ym4');

        $validator
            ->scalar('ym5')
            ->maxLength('ym5', 30)
            ->allowEmptyString('ym5');

        $validator
            ->scalar('system')
            ->maxLength('system', 30)
            ->allowEmptyString('system');

        $validator
            ->scalar('website')
            ->maxLength('website', 50)
            ->allowEmptyString('website');

        $validator
            ->decimal('beginning_balance')
            ->allowEmptyString('beginning_balance');

        $validator
            ->decimal('platform')
            ->allowEmptyString('platform');

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        $validator
            ->scalar('who_create')
            ->maxLength('who_create', 50)
            ->allowEmptyString('who_create');

        $validator
            ->scalar('who_update')
            ->maxLength('who_update', 50)
            ->allowEmptyString('who_update');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['mou_id'], 'Mous'), ['errorField' => 'mou_id']);

        return $rules;
    }
}
