<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DaerahKecamatans Model
 *
 * @method \App\Model\Entity\DaerahKecamatan newEmptyEntity()
 * @method \App\Model\Entity\DaerahKecamatan newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKecamatan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKecamatan get($primaryKey, $options = [])
 * @method \App\Model\Entity\DaerahKecamatan findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DaerahKecamatan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKecamatan[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahKecamatan|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahKecamatan saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahKecamatan[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKecamatan[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKecamatan[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahKecamatan[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DaerahKecamatansTable extends Table
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

        $this->setTable('daerah_kecamatans');
        $this->setDisplayField('id_kec');
        $this->setPrimaryKey('id_kec');
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
            ->scalar('id_kec')
            ->maxLength('id_kec', 6)
            ->allowEmptyString('id_kec', null, 'create');

        $validator
            ->scalar('id_kab')
            ->maxLength('id_kab', 4)
            ->requirePresence('id_kab', 'create')
            ->notEmptyString('id_kab');

        $validator
            ->scalar('nama')
            ->maxLength('nama', 255)
            ->requirePresence('nama', 'create')
            ->notEmptyString('nama');

        return $validator;
    }
}
