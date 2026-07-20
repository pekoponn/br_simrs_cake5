<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderPembelianDetails Model
 *
 * @property \App\Model\Table\OrderPembeliansTable&\Cake\ORM\Association\BelongsTo $OrderPembelians
 * @property \App\Model\Table\BarangsTable&\Cake\ORM\Association\BelongsTo $Barangs
 *
 * @method \App\Model\Entity\OrderPembelianDetail newEmptyEntity()
 * @method \App\Model\Entity\OrderPembelianDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPembelianDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderPembelianDetailsTable extends Table
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

        $this->setTable('order_pembelian_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OrderPembelians', [
            'foreignKey' => 'order_pembelian_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Barangs', [
            'foreignKey' => 'barang_id',
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
            ->maxLength('kode_barang', 30)
            ->allowEmptyString('kode_barang');

        $validator
            ->scalar('nama_barang')
            ->maxLength('nama_barang', 200)
            ->allowEmptyString('nama_barang');

        $validator
            ->decimal('qty_rencana')
            ->notEmptyString('qty_rencana');

        $validator
            ->decimal('qty_po')
            ->notEmptyString('qty_po');

        $validator
            ->scalar('satuan')
            ->maxLength('satuan', 20)
            ->allowEmptyString('satuan');

        $validator
            ->decimal('harga')
            ->notEmptyString('harga');

        $validator
            ->decimal('discount')
            ->notEmptyString('discount');

        $validator
            ->decimal('tax')
            ->notEmptyString('tax');

        $validator
            ->decimal('total_harga')
            ->notEmptyString('total_harga');

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
        $rules->add($rules->existsIn(['order_pembelian_id'], 'OrderPembelians'), ['errorField' => 'order_pembelian_id']);
        $rules->add($rules->existsIn(['barang_id'], 'Barangs'), ['errorField' => 'barang_id']);

        return $rules;
    }
}
