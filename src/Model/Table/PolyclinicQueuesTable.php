<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PolyclinicQueues Model
 *
 * @method \App\Model\Entity\PolyclinicQueue newEmptyEntity()
 * @method \App\Model\Entity\PolyclinicQueue newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PolyclinicQueue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PolyclinicQueue get($primaryKey, $options = [])
 * @method \App\Model\Entity\PolyclinicQueue findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PolyclinicQueue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PolyclinicQueue[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PolyclinicQueue|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PolyclinicQueue saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PolyclinicQueue[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PolyclinicQueue[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PolyclinicQueue[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PolyclinicQueue[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PolyclinicQueuesTable extends Table
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

        $this->setTable('polyclinic_queues');
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
            ->scalar('code')
            ->maxLength('code', 50)
            ->notEmptyString('code');

        $validator
            ->scalar('source')
            ->maxLength('source', 255)
            ->requirePresence('source', 'create')
            ->notEmptyString('source');

        $validator
            ->scalar('poly_name')
            ->maxLength('poly_name', 255)
            ->requirePresence('poly_name', 'create')
            ->notEmptyString('poly_name');

        $validator
            ->scalar('patients_name')
            ->maxLength('patients_name', 255)
            ->requirePresence('patients_name', 'create')
            ->notEmptyString('patients_name');

        $validator
            ->scalar('no_telp')
            ->maxLength('no_telp', 255)
            ->requirePresence('no_telp', 'create')
            ->notEmptyString('no_telp');

        $validator
            ->integer('queue_number')
            ->requirePresence('queue_number', 'create')
            ->notEmptyString('queue_number');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->integer('is_delete')
            ->notEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('delete_log')
            ->allowEmptyString('delete_log');

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

        return $validator;
    }
}
