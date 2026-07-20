<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderPembelians Model
 *
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\OrderPembelianDetailsTable&\Cake\ORM\Association\HasMany $OrderPembelianDetails
 *
 * @method \App\Model\Entity\OrderPembelian newEmptyEntity()
 * @method \App\Model\Entity\OrderPembelian newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OrderPembelian[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderPembelian get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderPembelian findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OrderPembelian patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderPembelian[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderPembelian|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderPembelian saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderPembelian[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPembelian[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPembelian[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderPembelian[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderPembeliansTable extends Table
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

        $this->setTable('order_pembelians');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('OrderPembelianDetails', [
            'foreignKey' => 'order_pembelian_id',
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
            ->scalar('po_no')
            ->maxLength('po_no', 30)
            ->requirePresence('po_no', 'create')
            ->notEmptyString('po_no')
            ->add('po_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('tgl_po')
            ->requirePresence('tgl_po', 'create')
            ->notEmptyDate('tgl_po');

        $validator
            ->scalar('ref_no')
            ->maxLength('ref_no', 50)
            ->allowEmptyString('ref_no');

        $validator
            ->date('tgl_kirim')
            ->allowEmptyDate('tgl_kirim');

        $validator
            ->scalar('barang_dikirim_ke')
            ->allowEmptyString('barang_dikirim_ke');

        $validator
            ->scalar('kirim_via')
            ->maxLength('kirim_via', 50)
            ->allowEmptyString('kirim_via');

        $validator
            ->scalar('jenis')
            ->maxLength('jenis', 50)
            ->allowEmptyString('jenis');

        $validator
            ->decimal('total')
            ->notEmptyString('total');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->notEmptyString('status');

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
        $rules->add($rules->isUnique(['po_no']), ['errorField' => 'po_no']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);

        return $rules;
    }
}
