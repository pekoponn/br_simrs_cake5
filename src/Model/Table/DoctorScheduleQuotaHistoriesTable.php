<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DoctorScheduleQuotaHistories Model
 *
 * @property \App\Model\Table\DoctorSchedulesTable&\Cake\ORM\Association\BelongsTo $DoctorSchedules
 *
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory newEmptyEntity()
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DoctorScheduleQuotaHistory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DoctorScheduleQuotaHistoriesTable extends Table
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

        $this->setTable('doctor_schedule_quota_histories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('DoctorSchedules', [
            'foreignKey' => 'doctor_schedule_id',
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
            ->date('cycle_date')
            ->requirePresence('cycle_date', 'create')
            ->notEmptyDate('cycle_date');

        $validator
            ->integer('quota')
            ->notEmptyString('quota');

        $validator
            ->integer('quota_used')
            ->notEmptyString('quota_used');

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
        $rules->add($rules->existsIn(['doctor_schedule_id'], 'DoctorSchedules'), ['errorField' => 'doctor_schedule_id']);

        return $rules;
    }
}
