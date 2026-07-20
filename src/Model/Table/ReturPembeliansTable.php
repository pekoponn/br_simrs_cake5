<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReturPembelians Model
 *
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\ReturPembelianDetailsTable&\Cake\ORM\Association\HasMany $ReturPembelianDetails
 *
 * @method \App\Model\Entity\ReturPembelian newEmptyEntity()
 * @method \App\Model\Entity\ReturPembelian newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ReturPembelian[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReturPembelian get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReturPembelian findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ReturPembelian patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReturPembelian[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReturPembelian|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturPembelian saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReturPembelian[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturPembelian[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturPembelian[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReturPembelian[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReturPembeliansTable extends Table
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

        $this->setTable('retur_pembelians');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
        ]);
        $this->hasMany('ReturPembelianDetails', [
            'foreignKey' => 'retur_pembelian_id',
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
            ->scalar('retur_no')
            ->maxLength('retur_no', 30)
            ->requirePresence('retur_no', 'create')
            ->notEmptyString('retur_no')
            ->add('retur_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('tgl_retur')
            ->requirePresence('tgl_retur', 'create')
            ->notEmptyDate('tgl_retur');

        $validator
            ->scalar('bapb_no')
            ->maxLength('bapb_no', 50)
            ->allowEmptyString('bapb_no');

        $validator
            ->scalar('no_faktur')
            ->maxLength('no_faktur', 50)
            ->allowEmptyString('no_faktur');

        $validator
            ->scalar('gudang_depo')
            ->maxLength('gudang_depo', 100)
            ->allowEmptyString('gudang_depo');

        $validator
            ->scalar('nama_supplier')
            ->maxLength('nama_supplier', 150)
            ->allowEmptyString('nama_supplier');

        $validator
            ->scalar('catatan')
            ->maxLength('catatan', 255)
            ->allowEmptyString('catatan');

        $validator
            ->decimal('total')
            ->notEmptyString('total');

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
        $rules->add($rules->isUnique(['retur_no']), ['errorField' => 'retur_no']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);

        return $rules;
    }
}
