<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HrgaEmployeeLines Model
 *
 * @property \App\Model\Table\HrgaEmployeesTable&\Cake\ORM\Association\BelongsTo $HrgaEmployees
 *
 * @method \App\Model\Entity\HrgaEmployeeLine newEmptyEntity()
 * @method \App\Model\Entity\HrgaEmployeeLine newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine get($primaryKey, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeLine[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HrgaEmployeeLinesTable extends Table
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

        $this->setTable('hrga_employee_lines');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('HrgaEmployees', [
            'foreignKey' => 'hrga_employee_id',
            'joinType' => 'INNER',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('status_family')
            ->allowEmptyString('status_family');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('no_ktp')
            ->maxLength('no_ktp', 255)
            ->allowEmptyString('no_ktp');

        $validator
            ->scalar('telp')
            ->maxLength('telp', 255)
            ->allowEmptyString('telp');

        $validator
            ->scalar('pekerjaan')
            ->maxLength('pekerjaan', 255)
            ->allowEmptyString('pekerjaan');

        $validator
            ->scalar('bpjs_kesehatan')
            ->maxLength('bpjs_kesehatan', 20)
            ->allowEmptyString('bpjs_kesehatan');

        $validator
            ->scalar('bpjs_kesehatan_status')
            ->allowEmptyString('bpjs_kesehatan_status');

        $validator
            ->date('bpjs_kesehatan_date')
            ->allowEmptyDate('bpjs_kesehatan_date');

        $validator
            ->date('birthday')
            ->allowEmptyDate('birthday');

        $validator
            ->scalar('status_kesehatan')
            ->maxLength('status_kesehatan', 255)
            ->allowEmptyString('status_kesehatan');

        $validator
            ->scalar('place_of_birth')
            ->maxLength('place_of_birth', 255)
            ->allowEmptyString('place_of_birth');

        $validator
            ->scalar('riwayat_sakit')
            ->maxLength('riwayat_sakit', 255)
            ->allowEmptyString('riwayat_sakit');

        $validator
            ->scalar('clothes_size')
            ->maxLength('clothes_size', 255)
            ->allowEmptyString('clothes_size');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        $validator
            ->scalar('is_active')
            ->allowEmptyString('is_active');

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
        $rules->add($rules->existsIn(['hrga_employee_id'], 'HrgaEmployees'), ['errorField' => 'hrga_employee_id']);

        return $rules;
    }
}
