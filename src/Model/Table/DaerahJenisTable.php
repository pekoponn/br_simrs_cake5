<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DaerahJenis Model
 *
 * @method \App\Model\Entity\DaerahJeni newEmptyEntity()
 * @method \App\Model\Entity\DaerahJeni newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahJeni[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahJeni get($primaryKey, $options = [])
 * @method \App\Model\Entity\DaerahJeni findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DaerahJeni patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahJeni[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahJeni|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahJeni saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahJeni[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahJeni[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahJeni[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahJeni[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DaerahJenisTable extends Table
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

        $this->setTable('daerah_jenis');
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
            ->integer('id_jenis')
            ->requirePresence('id_jenis', 'create')
            ->notEmptyString('id_jenis');

        $validator
            ->scalar('nama')
            ->maxLength('nama', 255)
            ->requirePresence('nama', 'create')
            ->notEmptyString('nama');

        return $validator;
    }
}
