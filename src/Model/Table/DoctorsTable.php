<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Doctors Model
 *
 * @property \App\Model\Table\PolyclinicsTable&\Cake\ORM\Association\BelongsTo $Polyclinics
 * @property \App\Model\Table\DoctorSchedulesTable&\Cake\ORM\Association\HasMany $DoctorSchedules
 *
 * @method \App\Model\Entity\Doctor newEmptyEntity()
 * @method \App\Model\Entity\Doctor newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Doctor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Doctor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Doctor findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Doctor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Doctor[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Doctor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Doctor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Doctor[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Doctor[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Doctor[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Doctor[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DoctorsTable extends Table
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

        $this->setTable('doctors');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Polyclinics', [
            'foreignKey' => 'polyclinic_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DoctorSchedules', [
            'foreignKey' => 'doctor_id',
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
            ->scalar('code')
            ->maxLength('code', 50)
            ->notEmptyString('code');

        $validator
            ->scalar('region')
            ->maxLength('region', 50)
            ->notEmptyString('region');

        $validator
            ->scalar('nik_login')
            ->maxLength('nik_login', 50)
            ->requirePresence('nik_login', 'create')
            ->notEmptyString('nik_login');

        $validator
            ->scalar('nik')
            ->maxLength('nik', 50)
            ->requirePresence('nik', 'create')
            ->notEmptyString('nik');

        $validator
            ->scalar('doctor_name')
            ->maxLength('doctor_name', 255)
            ->requirePresence('doctor_name', 'create')
            ->notEmptyString('doctor_name');

        $validator
            ->scalar('specialist')
            ->maxLength('specialist', 255)
            ->requirePresence('specialist', 'create')
            ->notEmptyString('specialist');

        $validator
            ->scalar('religion')
            ->maxLength('religion', 255)
            ->requirePresence('religion', 'create')
            ->notEmptyString('religion');

        $validator
            ->scalar('sip_number')
            ->maxLength('sip_number', 100)
            ->requirePresence('sip_number', 'create')
            ->notEmptyString('sip_number');

        $validator
            ->scalar('str_number')
            ->maxLength('str_number', 100)
            ->requirePresence('str_number', 'create')
            ->notEmptyString('str_number');

        $validator
            ->date('str_issue_date')
            ->requirePresence('str_issue_date', 'create')
            ->notEmptyDate('str_issue_date');

        $validator
            ->scalar('str_expiry_date')
            ->maxLength('str_expiry_date', 50)
            ->requirePresence('str_expiry_date', 'create')
            ->notEmptyString('str_expiry_date');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 20)
            ->notEmptyString('phone_number');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('gender')
            ->allowEmptyString('gender');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['polyclinic_id'], 'Polyclinics'), ['errorField' => 'polyclinic_id']);

        return $rules;
    }
}
