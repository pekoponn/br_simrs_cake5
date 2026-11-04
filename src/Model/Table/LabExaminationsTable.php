<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabExaminations Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 *
 * @method \App\Model\Entity\LabExamination newEmptyEntity()
 * @method \App\Model\Entity\LabExamination newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LabExamination> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LabExamination get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LabExamination findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LabExamination patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LabExamination> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LabExamination|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LabExamination saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LabExamination>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LabExamination>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LabExamination>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LabExamination> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LabExamination>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LabExamination>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LabExamination>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LabExamination> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LabExaminationsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('lab_examinations');
        $this->setDisplayField('lab_no');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
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
            ->scalar('lab_no')
            ->maxLength('lab_no', 30)
            ->requirePresence('lab_no', 'create')
            ->notEmptyString('lab_no')
            ->add('lab_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->nonNegativeInteger('registration_id')
            ->allowEmptyString('registration_id');

        $validator
            ->nonNegativeInteger('order_id')
            ->allowEmptyString('order_id');

        $validator
            ->nonNegativeInteger('patient_id')
            ->allowEmptyString('patient_id');

        $validator
            ->scalar('medical_record_no')
            ->maxLength('medical_record_no', 30)
            ->allowEmptyString('medical_record_no');

        $validator
            ->scalar('patient_name')
            ->maxLength('patient_name', 150)
            ->requirePresence('patient_name', 'create')
            ->notEmptyString('patient_name');

        $validator
            ->scalar('examination_name')
            ->maxLength('examination_name', 255)
            ->requirePresence('examination_name', 'create')
            ->notEmptyString('examination_name');

        $validator
            ->scalar('patient_type')
            ->maxLength('patient_type', 50)
            ->allowEmptyString('patient_type');

        $validator
            ->scalar('sender_doctor')
            ->maxLength('sender_doctor', 150)
            ->allowEmptyString('sender_doctor');

        $validator
            ->scalar('origin')
            ->maxLength('origin', 100)
            ->allowEmptyString('origin');

        $validator
            ->dateTime('received_at')
            ->allowEmptyDateTime('received_at');

        $validator
            ->dateTime('finished_at')
            ->allowEmptyDateTime('finished_at');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->boolean('integration_status')
            ->notEmptyString('integration_status');

        $validator
            ->boolean('is_create')
            ->notEmptyString('is_create');

        $validator
            ->boolean('is_update')
            ->notEmptyString('is_update');

        $validator
            ->boolean('is_delete')
            ->notEmptyString('is_delete');

        $validator
            ->scalar('is_active')
            ->maxLength('is_active', 1)
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
        $rules->add($rules->isUnique(['lab_no']), ['errorField' => 'lab_no']);
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);

        return $rules;
    }
}
