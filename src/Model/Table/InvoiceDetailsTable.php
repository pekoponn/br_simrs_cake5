<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InvoiceDetails Model
 *
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\BelongsTo $Invoices
 * @property \App\Model\Table\MedicinesTable&\Cake\ORM\Association\BelongsTo $Medicines
 *
 * @method \App\Model\Entity\InvoiceDetail newEmptyEntity()
 * @method \App\Model\Entity\InvoiceDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\InvoiceDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\InvoiceDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InvoiceDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InvoiceDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InvoiceDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\InvoiceDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InvoiceDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvoiceDetailsTable extends Table
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

        $this->setTable('invoice_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Medicines', [
            'foreignKey' => 'medicine_id',
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
            ->scalar('kode_barang')
            ->maxLength('kode_barang', 50)
            ->allowEmptyString('kode_barang');

        $validator
            ->scalar('nama_barang')
            ->maxLength('nama_barang', 200)
            ->allowEmptyString('nama_barang');

        $validator
            ->decimal('qty')
            ->notEmptyString('qty');

        $validator
            ->scalar('satuan')
            ->maxLength('satuan', 30)
            ->allowEmptyString('satuan');

        $validator
            ->decimal('harga')
            ->notEmptyString('harga');

        $validator
            ->decimal('discount_percent')
            ->notEmptyString('discount_percent');

        $validator
            ->decimal('discount_rp')
            ->notEmptyString('discount_rp');

        $validator
            ->decimal('tax')
            ->notEmptyString('tax');

        $validator
            ->decimal('total_harga')
            ->notEmptyString('total_harga');

        $validator
            ->date('tgl_kadaluarsa')
            ->allowEmptyDate('tgl_kadaluarsa');

        $validator
            ->scalar('po_no')
            ->maxLength('po_no', 50)
            ->allowEmptyString('po_no');

        $validator
            ->scalar('histori')
            ->maxLength('histori', 100)
            ->allowEmptyString('histori');

        $validator
            ->decimal('nilai_diskon')
            ->notEmptyString('nilai_diskon');

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
        $rules->add($rules->existsIn(['invoice_id'], 'Invoices'), ['errorField' => 'invoice_id']);
        $rules->add($rules->existsIn(['medicine_id'], 'Medicines'), ['errorField' => 'medicine_id']);

        return $rules;
    }
}
