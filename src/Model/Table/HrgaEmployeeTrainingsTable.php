<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HrgaEmployeeTrainings Model
 *
 * @property \App\Model\Table\HrgaEmployeesTable&\Cake\ORM\Association\BelongsTo $HrgaEmployees
 *
 * @method \App\Model\Entity\HrgaEmployeeTraining newEmptyEntity()
 * @method \App\Model\Entity\HrgaEmployeeTraining newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining get($primaryKey, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployeeTraining[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HrgaEmployeeTrainingsTable extends Table
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

        $this->setTable('hrga_employee_trainings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('HrgaEmployees', [
            'foreignKey' => 'hrga_employee_id',
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
            ->scalar('skill')
            ->maxLength('skill', 255)
            ->allowEmptyString('skill');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->scalar('grade')
            ->allowEmptyString('grade');

        $validator
            ->scalar('organizer')
            ->maxLength('organizer', 255)
            ->allowEmptyString('organizer');

        $validator
            ->integer('is_create')
            ->allowEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->allowEmptyString('is_update');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

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
