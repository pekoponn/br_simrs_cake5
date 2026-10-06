<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HrgaAttendances Model
 *
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\HrgaAttendanceLinesTable&\Cake\ORM\Association\HasMany $HrgaAttendanceLines
 *
 * @method \App\Model\Entity\HrgaAttendance newEmptyEntity()
 * @method \App\Model\Entity\HrgaAttendance newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\HrgaAttendance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HrgaAttendance get($primaryKey, $options = [])
 * @method \App\Model\Entity\HrgaAttendance findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\HrgaAttendance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HrgaAttendance[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\HrgaAttendance|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HrgaAttendance saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HrgaAttendance[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaAttendance[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaAttendance[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaAttendance[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HrgaAttendancesTable extends Table
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

        $this->setTable('hrga_attendances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('HrgaEmployees', [
            'foreignKey' => 'hrga_employee_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('HrgaAttendanceLines', [
            'foreignKey' => 'hrga_attendance_id',
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
            ->integer('qty')
            ->notEmptyString('qty');

        $validator
            ->integer('qty_lateness')
            ->notEmptyString('qty_lateness');

        $validator
            ->integer('qty_overtime')
            ->notEmptyString('qty_overtime');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->integer('jml')
            ->notEmptyString('jml');

        $validator
            ->integer('terlambat')
            ->notEmptyString('terlambat');

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
   /* public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['employee_id'], 'Employees'), ['errorField' => 'employee_id']);

        return $rules;
    }*/
}
