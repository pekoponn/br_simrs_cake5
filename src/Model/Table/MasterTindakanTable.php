<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterTindakan Model
 *
 * @property \App\Model\Table\OutpatientActionsTable&\Cake\ORM\Association\HasMany $OutpatientActions
 *
 * @method \App\Model\Entity\MasterTindakan newEmptyEntity()
 * @method \App\Model\Entity\MasterTindakan newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MasterTindakan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterTindakan get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterTindakan findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MasterTindakan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterTindakan[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterTindakan|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterTindakan saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterTindakan[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterTindakan[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterTindakan[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterTindakan[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MasterTindakanTable extends Table
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

        $this->setTable('master_tindakan');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('OutpatientActions', [
            'foreignKey' => 'master_tindakan_id',
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
            ->scalar('kode')
            ->maxLength('kode', 20)
            ->requirePresence('kode', 'create')
            ->notEmptyString('kode')
            ->add('kode', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('nama')
            ->maxLength('nama', 200)
            ->requirePresence('nama', 'create')
            ->notEmptyString('nama');

        $validator
            ->scalar('kategori')
            ->notEmptyString('kategori');

        $validator
            ->decimal('harga')
            ->notEmptyString('harga');

        $validator
            ->scalar('satuan')
            ->maxLength('satuan', 30)
            ->allowEmptyString('satuan');

        $validator
            ->scalar('keterangan')
            ->allowEmptyString('keterangan');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

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
        $rules->add($rules->isUnique(['kode']), ['errorField' => 'kode']);

        return $rules;
    }
}
