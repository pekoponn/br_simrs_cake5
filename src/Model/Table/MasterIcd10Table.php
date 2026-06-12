<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterIcd10 Model
 *
 * @method \App\Model\Entity\MasterIcd10 newEmptyEntity()
 * @method \App\Model\Entity\MasterIcd10 newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MasterIcd10[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterIcd10 get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterIcd10 findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MasterIcd10 patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterIcd10[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterIcd10|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterIcd10 saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterIcd10[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterIcd10[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterIcd10[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterIcd10[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MasterIcd10Table extends Table
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

        $this->setTable('master_icd10');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('kode')
            ->maxLength('kode', 10)
            ->requirePresence('kode', 'create')
            ->notEmptyString('kode')
            ->add('kode', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('nama')
            ->requirePresence('nama', 'create')
            ->notEmptyString('nama');

        $validator
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
