<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReturPembelianDetails Model
 *
 * @property \App\Model\Table\ReturPembeliansTable&\Cake\ORM\Association\BelongsTo $ReturPembelians
 * @property \App\Model\Table\MedicinesTable&\Cake\ORM\Association\BelongsTo $Medicines
 *
 * @method \App\Model\Entity\ReturPembelianDetail newEmptyEntity()
 * @method \App\Model\Entity\ReturPembelianDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturPembelianDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReturPembelianDetailsTable extends Table
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

        $this->setTable('retur_pembelian_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ReturPembelians', [
            'foreignKey' => 'retur_pembelian_id',
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
            ->scalar('unit')
            ->maxLength('unit', 30)
            ->allowEmptyString('unit');

        $validator
            ->decimal('harga')
            ->notEmptyString('harga');

        $validator
            ->decimal('tax')
            ->notEmptyString('tax');

        $validator
            ->decimal('ppn_rp')
            ->notEmptyString('ppn_rp');

        $validator
            ->decimal('discount')
            ->notEmptyString('discount');

        $validator
            ->decimal('total_harga')
            ->notEmptyString('total_harga');

        $validator
            ->date('tgl_kadaluarsa')
            ->allowEmptyDate('tgl_kadaluarsa');

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
        $rules->add($rules->existsIn(['retur_pembelian_id'], 'ReturPembelians'), ['errorField' => 'retur_pembelian_id']);
        $rules->add($rules->existsIn(['medicine_id'], 'Medicines'), ['errorField' => 'medicine_id']);

        return $rules;
    }
}
