<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DaerahKelurahans Model
 *
 * @method \App\Model\Entity\DaerahKelurahan newEmptyEntity()
 * @method \App\Model\Entity\DaerahKelurahan newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKelurahan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKelurahan get($primaryKey, $options = [])
 * @method \App\Model\Entity\DaerahKelurahan findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DaerahKelurahan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKelurahan[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKelurahan|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahKelurahan saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahKelurahan[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKelurahan[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKelurahan[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKelurahan[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DaerahKelurahansTable extends Table
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

        $this->setTable('daerah_kelurahans');
        $this->setDisplayField('id_kel');
        $this->setPrimaryKey('id_kel');
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
            ->scalar('id_kel')
            ->maxLength('id_kel', 10)
            ->allowEmptyString('id_kel', null, 'create');

        $validator
            ->scalar('id_kec')
            ->maxLength('id_kec', 6)
            ->allowEmptyString('id_kec');

        $validator
            ->scalar('nama')
            ->maxLength('nama', 255)
            ->allowEmptyString('nama');

        $validator
            ->integer('id_jenis')
            ->requirePresence('id_jenis', 'create')
            ->notEmptyString('id_jenis');

        return $validator;
    }
}
