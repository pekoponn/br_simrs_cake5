<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmergencyNursingAssessments Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\NursesTable&\Cake\ORM\Association\BelongsTo $Nurses
 *
 * @method \App\Model\Entity\EmergencyNursingAssessment newEmptyEntity()
 * @method \App\Model\Entity\EmergencyNursingAssessment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyNursingAssessment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmergencyNursingAssessmentsTable extends Table
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

        $this->setTable('emergency_nursing_assessments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
        ]);
        $this->belongsTo('MasterTenagaMedis', [
            'foreignKey' => 'nurse_id',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('nurse_name')
            ->maxLength('nurse_name', 255)
            ->allowEmptyString('nurse_name');

        $validator
            ->scalar('info_type')
            ->maxLength('info_type', 20)
            ->allowEmptyString('info_type');

        $validator
            ->scalar('info_name')
            ->maxLength('info_name', 255)
            ->allowEmptyString('info_name');

        $validator
            ->scalar('info_relation')
            ->maxLength('info_relation', 100)
            ->allowEmptyString('info_relation');

        $validator
            ->scalar('admission_mode')
            ->maxLength('admission_mode', 30)
            ->allowEmptyString('admission_mode');

        $validator
            ->scalar('admission_origin')
            ->maxLength('admission_origin', 20)
            ->allowEmptyString('admission_origin');

        $validator
            ->scalar('current_illness_history')
            ->allowEmptyString('current_illness_history');

        $validator
            ->scalar('past_illness_history')
            ->allowEmptyString('past_illness_history');

        $validator
            ->scalar('previous_treatment_history')
            ->allowEmptyString('previous_treatment_history');

        $validator
            ->decimal('weight')
            ->allowEmptyString('weight');

        $validator
            ->decimal('height')
            ->allowEmptyString('height');

        $validator
            ->allowEmptyString('pain_scale');

        $validator
            ->scalar('pain_frequency')
            ->maxLength('pain_frequency', 20)
            ->allowEmptyString('pain_frequency');

        $validator
            ->scalar('pain_duration')
            ->maxLength('pain_duration', 50)
            ->allowEmptyString('pain_duration');

        $validator
            ->scalar('pain_radiating')
            ->maxLength('pain_radiating', 10)
            ->allowEmptyString('pain_radiating');

        $validator
            ->scalar('pain_radiating_to')
            ->maxLength('pain_radiating_to', 100)
            ->allowEmptyString('pain_radiating_to');

        $validator
            ->scalar('pain_quality')
            ->maxLength('pain_quality', 20)
            ->allowEmptyString('pain_quality');

        $validator
            ->scalar('pain_trigger_factor')
            ->maxLength('pain_trigger_factor', 255)
            ->allowEmptyString('pain_trigger_factor');

        $validator
            ->scalar('pain_relieving_factor')
            ->maxLength('pain_relieving_factor', 255)
            ->allowEmptyString('pain_relieving_factor');

        $validator
            ->scalar('daily_activity')
            ->maxLength('daily_activity', 20)
            ->allowEmptyString('daily_activity');

        $validator
            ->scalar('fall_risk_recent')
            ->maxLength('fall_risk_recent', 10)
            ->allowEmptyString('fall_risk_recent');

        $validator
            ->scalar('fall_risk_device')
            ->maxLength('fall_risk_device', 10)
            ->allowEmptyString('fall_risk_device');

        $validator
            ->scalar('fall_risk_walk_difficulty')
            ->maxLength('fall_risk_walk_difficulty', 10)
            ->allowEmptyString('fall_risk_walk_difficulty');

        $validator
            ->scalar('fall_intervention')
            ->maxLength('fall_intervention', 255)
            ->allowEmptyString('fall_intervention');

        $validator
            ->scalar('decubitus_wheelchair')
            ->maxLength('decubitus_wheelchair', 10)
            ->allowEmptyString('decubitus_wheelchair');

        $validator
            ->scalar('decubitus_incontinence')
            ->maxLength('decubitus_incontinence', 10)
            ->allowEmptyString('decubitus_incontinence');

        $validator
            ->scalar('decubitus_history')
            ->maxLength('decubitus_history', 10)
            ->allowEmptyString('decubitus_history');

        $validator
            ->scalar('decubitus_over_65')
            ->maxLength('decubitus_over_65', 10)
            ->allowEmptyString('decubitus_over_65');

        $validator
            ->scalar('decubitus_extremity_mismatch')
            ->maxLength('decubitus_extremity_mismatch', 10)
            ->allowEmptyString('decubitus_extremity_mismatch');

        $validator
            ->scalar('decubitus_education')
            ->allowEmptyString('decubitus_education');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->allowEmptyString('status');

        $validator
            ->boolean('is_active')
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
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['nurse_id'], 'MasterTenagaMedis'), ['errorField' => 'nurse_id']);

        return $rules;
    }
}