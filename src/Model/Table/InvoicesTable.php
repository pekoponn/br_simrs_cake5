<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invoices Model
 *
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\InvoiceDetailsTable&\Cake\ORM\Association\HasMany $InvoiceDetails
 *
 * @method \App\Model\Entity\Invoice newEmptyEntity()
 * @method \App\Model\Entity\Invoice newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invoice findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvoicesTable extends Table
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

        $this->setTable('invoices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
        ]);
        $this->hasMany('InvoiceDetails', [
            'foreignKey' => 'invoice_id',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('bapb_no')
            ->maxLength('bapb_no', 30)
            ->requirePresence('bapb_no', 'create')
            ->notEmptyString('bapb_no')
            ->add('bapb_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('nama_supplier')
            ->maxLength('nama_supplier', 150)
            ->allowEmptyString('nama_supplier');

        $validator
            ->date('tgl_terima')
            ->requirePresence('tgl_terima', 'create')
            ->notEmptyDate('tgl_terima');

        $validator
            ->scalar('no_faktur')
            ->maxLength('no_faktur', 50)
            ->allowEmptyString('no_faktur');

        $validator
            ->scalar('sj_no')
            ->maxLength('sj_no', 50)
            ->allowEmptyString('sj_no');

        $validator
            ->date('tgl_tukar_faktur')
            ->allowEmptyDate('tgl_tukar_faktur');

        $validator
            ->scalar('kurs')
            ->maxLength('kurs', 10)
            ->notEmptyString('kurs');

        $validator
            ->decimal('rate')
            ->notEmptyString('rate');

        $validator
            ->scalar('pembayaran')
            ->notEmptyString('pembayaran');

        $validator
            ->date('tgl_jatuh_tempo')
            ->allowEmptyDate('tgl_jatuh_tempo');

        $validator
            ->scalar('diterima_lokasi_gudang')
            ->maxLength('diterima_lokasi_gudang', 100)
            ->allowEmptyString('diterima_lokasi_gudang');

        $validator
            ->scalar('materai')
            ->notEmptyString('materai');

        $validator
            ->decimal('discount_percent')
            ->notEmptyString('discount_percent');

        $validator
            ->decimal('discount_rp')
            ->notEmptyString('discount_rp');

        $validator
            ->decimal('ongkos_kirim')
            ->notEmptyString('ongkos_kirim');

        $validator
            ->decimal('total')
            ->notEmptyString('total');

        $validator
            ->decimal('grand_total')
            ->notEmptyString('grand_total');

        $validator
            ->scalar('catatan')
            ->maxLength('catatan', 255)
            ->allowEmptyString('catatan');

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
        $rules->add($rules->isUnique(['bapb_no']), ['errorField' => 'bapb_no']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);

        return $rules;
    }
}
