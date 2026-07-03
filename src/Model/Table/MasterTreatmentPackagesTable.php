<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterTreatmentPackages Model
 *
 * @method \App\Model\Entity\MasterTreatmentPackage newEmptyEntity()
 * @method \App\Model\Entity\MasterTreatmentPackage newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterTreatmentPackage[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MasterTreatmentPackagesTable extends Table
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

        $this->setTable('master_treatment_packages');
        $this->setDisplayField('name');
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
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->decimal('price')
            ->allowEmptyString('price');

        $validator
            ->scalar('is_active')
            ->maxLength('is_active', 1)
            ->allowEmptyString('is_active');

        return $validator;
    }
}
