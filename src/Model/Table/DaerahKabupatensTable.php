<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DaerahKabupatens Model
 *
 * @method \App\Model\Entity\DaerahKabupaten newEmptyEntity()
 * @method \App\Model\Entity\DaerahKabupaten newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKabupaten[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKabupaten get($primaryKey, $options = [])
 * @method \App\Model\Entity\DaerahKabupaten findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DaerahKabupaten patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKabupaten[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKabupaten|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahKabupaten saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahKabupaten[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKabupaten[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKabupaten[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKabupaten[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DaerahKabupatensTable extends Table
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

        $this->setTable('daerah_kabupatens');
        $this->setDisplayField('id_kab');
        $this->setPrimaryKey('id_kab');
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
            ->scalar('id_kab')
            ->maxLength('id_kab', 4)
            ->allowEmptyString('id_kab', null, 'create');

        $validator
            ->scalar('id_prov')
            ->maxLength('id_prov', 2)
            ->requirePresence('id_prov', 'create')
            ->notEmptyString('id_prov');

        $validator
            ->scalar('nama')
            ->maxLength('nama', 255)
            ->requirePresence('nama', 'create')
            ->notEmptyString('nama');

        $validator
            ->integer('id_jenis')
            ->requirePresence('id_jenis', 'create')
            ->notEmptyString('id_jenis');

        return $validator;
    }
}
