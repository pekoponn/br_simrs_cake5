<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RencanaPembelianDetails Model
 *
 * @property \App\Model\Table\RencanaPembeliansTable&\Cake\ORM\Association\BelongsTo $RencanaPembelians
 * @property \App\Model\Table\MedicinesTable&\Cake\ORM\Association\BelongsTo $Medicines
 *
 * @method \App\Model\Entity\RencanaPembelianDetail newEmptyEntity()
 * @method \App\Model\Entity\RencanaPembelianDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RencanaPembelianDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RencanaPembelianDetailsTable extends Table
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

        $this->setTable('rencana_pembelian_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('RencanaPembelians', [
            'foreignKey' => 'rencana_pembelian_id',
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
            ->decimal('harga')
            ->notEmptyString('harga');

        $validator
            ->scalar('satuan')
            ->maxLength('satuan', 30)
            ->allowEmptyString('satuan');

        $validator
            ->decimal('total')
            ->notEmptyString('total');

        $validator
            ->decimal('total_approv')
            ->notEmptyString('total_approv');

        $validator
            ->scalar('is_obat')
            ->notEmptyString('is_obat');

        $validator
            ->scalar('keterangan')
            ->maxLength('keterangan', 255)
            ->allowEmptyString('keterangan');

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
        $rules->add($rules->existsIn(['rencana_pembelian_id'], 'RencanaPembelians'), ['errorField' => 'rencana_pembelian_id']);
        $rules->add($rules->existsIn(['medicine_id'], 'Medicines'), ['errorField' => 'medicine_id']);

        return $rules;
    }
}
