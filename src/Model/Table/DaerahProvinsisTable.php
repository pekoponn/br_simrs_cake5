<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Hash; // Memanggil fungsi Hash, untuk filter

/**
 * DaerahProvinsis Model
 *
 * @method \App\Model\Entity\DaerahProvinsi newEmptyEntity()
 * @method \App\Model\Entity\DaerahProvinsi newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahProvinsi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DaerahProvinsi get($primaryKey, $options = [])
 * @method \App\Model\Entity\DaerahProvinsi findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DaerahProvinsi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahProvinsi[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DaerahProvinsi|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahProvinsi saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DaerahProvinsi[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahProvinsi[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahProvinsi[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DaerahProvinsi[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DaerahProvinsisTable extends Table
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

        $this->setTable('daerah_provinsis');
        $this->setDisplayField('id_prov');
        $this->setPrimaryKey('id_prov');
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
            ->scalar('id_prov')
            ->maxLength('id_prov', 2)
            ->allowEmptyString('id_prov', null, 'create');

        $validator
            ->scalar('nama')
            ->maxLength('nama', 255)
            ->requirePresence('nama', 'create')
            ->notEmptyString('nama');

        return $validator;
    }

    // Memanggil data getList pada table DaerahProvinsi
    public function getLists()
    {
        $dataRows = $this->find("all", [
                                "fields" => array('id_prov', 'nama'),
                                'order' => array('nama' => 'asc')]);
        $dataRows = $dataRows->toList();
        $result = Hash::combine($dataRows, ['%s^%s', '{n}.id_prov', '{n}.nama'], '{n}.nama');
        return $result;
    }
}
