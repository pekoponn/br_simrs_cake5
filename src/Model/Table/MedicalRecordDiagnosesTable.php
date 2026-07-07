<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MedicalRecordDiagnoses Model
 *
 * @property \App\Model\Table\MedicalRecordsTable&\Cake\ORM\Association\BelongsTo $MedicalRecords
 *
 * @method \App\Model\Entity\MedicalRecordDiagnosis newEmptyEntity()
 * @method \App\Model\Entity\MedicalRecordDiagnosis newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis get($primaryKey, $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordDiagnosis[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MedicalRecordDiagnosesTable extends Table
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

        $this->setTable('medical_record_diagnoses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MedicalRecords', [
            'foreignKey' => 'medical_record_id',
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
            ->scalar('type')
            ->maxLength('type', 50)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('diagnosis')
            ->allowEmptyString('diagnosis');

        $validator
            ->boolean('is_primary')
            ->allowEmptyString('is_primary');

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
        $rules->add($rules->existsIn(['medical_record_id'], 'MedicalRecords'), ['errorField' => 'medical_record_id']);

        return $rules;
    }
}
