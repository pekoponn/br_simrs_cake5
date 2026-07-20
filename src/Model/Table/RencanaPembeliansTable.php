<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RencanaPembelians Model
 *
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\RencanaPembelianDetailsTable&\Cake\ORM\Association\HasMany $RencanaPembelianDetails
 *
 * @method \App\Model\Entity\RencanaPembelian newEmptyEntity()
 * @method \App\Model\Entity\RencanaPembelian newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RencanaPembelian[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RencanaPembelian get($primaryKey, $options = [])
 * @method \App\Model\Entity\RencanaPembelian findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RencanaPembelian patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RencanaPembelian[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RencanaPembelian|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RencanaPembelian saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RencanaPembelian[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RencanaPembelian[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RencanaPembelian[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RencanaPembelian[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RencanaPembeliansTable extends Table
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

        $this->setTable('rencana_pembelians');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
        ]);
        $this->hasMany('RencanaPembelianDetails', [
            'foreignKey' => 'rencana_pembelian_id',
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
            ->scalar('no_perencanaan')
            ->maxLength('no_perencanaan', 30)
            ->requirePresence('no_perencanaan', 'create')
            ->notEmptyString('no_perencanaan')
            ->add('no_perencanaan', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('tgl_perencanaan')
            ->requirePresence('tgl_perencanaan', 'create')
            ->notEmptyDate('tgl_perencanaan');

        $validator
            ->scalar('no_dokumen')
            ->maxLength('no_dokumen', 50)
            ->allowEmptyString('no_dokumen');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->scalar('nama_supplier')
            ->maxLength('nama_supplier', 150)
            ->allowEmptyString('nama_supplier');

        $validator
            ->scalar('diminta_oleh')
            ->maxLength('diminta_oleh', 150)
            ->allowEmptyString('diminta_oleh');

        $validator
            ->decimal('total_qty_permintaan')
            ->notEmptyString('total_qty_permintaan');

        $validator
            ->decimal('total_permintaan')
            ->notEmptyString('total_permintaan');

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
        $rules->add($rules->isUnique(['no_perencanaan']), ['errorField' => 'no_perencanaan']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);

        return $rules;
    }
}
