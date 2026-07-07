<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MedicalResumes Model
 *
 * @property \App\Model\Table\OutpatientVisitsTable&\Cake\ORM\Association\BelongsTo $OutpatientVisits
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\Doctor1sTable&\Cake\ORM\Association\BelongsTo $Doctor1s
 *
 * @method \App\Model\Entity\MedicalResume newEmptyEntity()
 * @method \App\Model\Entity\MedicalResume newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalResume[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalResume get($primaryKey, $options = [])
 * @method \App\Model\Entity\MedicalResume findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MedicalResume patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalResume[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalResume|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalResume saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalResume[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalResume[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalResume[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalResume[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MedicalResumesTable extends Table
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

        $this->setTable('medical_resumes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OutpatientVisits', [
            'foreignKey' => 'outpatient_visit_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
        ]);
        $this->belongsTo('Doctor1s', [
            'foreignKey' => 'doctor1_id',
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
            ->scalar('doctor2_name')
            ->maxLength('doctor2_name', 150)
            ->allowEmptyString('doctor2_name');

        $validator
            ->scalar('doctor3_name')
            ->maxLength('doctor3_name', 150)
            ->allowEmptyString('doctor3_name');

        $validator
            ->scalar('doctor4_name')
            ->maxLength('doctor4_name', 150)
            ->allowEmptyString('doctor4_name');

        $validator
            ->scalar('consultant1_name')
            ->maxLength('consultant1_name', 150)
            ->allowEmptyString('consultant1_name');

        $validator
            ->scalar('consultant2_name')
            ->maxLength('consultant2_name', 150)
            ->allowEmptyString('consultant2_name');

        $validator
            ->scalar('summary_history')
            ->allowEmptyString('summary_history');

        $validator
            ->scalar('inpatient_indication')
            ->allowEmptyString('inpatient_indication');

        $validator
            ->scalar('physical_exam')
            ->allowEmptyString('physical_exam');

        $validator
            ->scalar('supporting_exam')
            ->allowEmptyString('supporting_exam');

        $validator
            ->scalar('therapy_during_treatment')
            ->allowEmptyString('therapy_during_treatment');

        $validator
            ->scalar('consultation_result')
            ->allowEmptyString('consultation_result');

        $validator
            ->scalar('admission_diagnosis')
            ->allowEmptyString('admission_diagnosis');

        $validator
            ->scalar('lab_unfinished')
            ->allowEmptyString('lab_unfinished');

        $validator
            ->scalar('diet')
            ->allowEmptyString('diet');

        $validator
            ->scalar('education_instruction')
            ->allowEmptyString('education_instruction');

        $validator
            ->scalar('primary_diagnosis')
            ->allowEmptyString('primary_diagnosis');

        $validator
            ->scalar('secondary_diagnosis')
            ->allowEmptyString('secondary_diagnosis');

        $validator
            ->scalar('medical_action')
            ->allowEmptyString('medical_action');

        $validator
            ->scalar('condition_on_discharge')
            ->maxLength('condition_on_discharge', 100)
            ->allowEmptyString('condition_on_discharge');

        $validator
            ->scalar('prognosis')
            ->maxLength('prognosis', 100)
            ->allowEmptyString('prognosis');

        $validator
            ->scalar('follow_up_treatment')
            ->maxLength('follow_up_treatment', 100)
            ->allowEmptyString('follow_up_treatment');

        $validator
            ->date('control_date')
            ->allowEmptyDate('control_date');

        $validator
            ->scalar('control_note')
            ->allowEmptyString('control_note');

        $validator
            ->scalar('control_plan')
            ->allowEmptyString('control_plan');

        $validator
            ->scalar('return_reason')
            ->allowEmptyString('return_reason');

        $validator
            ->boolean('print_classic')
            ->notEmptyString('print_classic');

        $validator
            ->boolean('send_digital_claim')
            ->notEmptyString('send_digital_claim');

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
        $rules->add($rules->existsIn(['outpatient_visit_id'], 'OutpatientVisits'), ['errorField' => 'outpatient_visit_id']);
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor1_id'], 'Doctor1s'), ['errorField' => 'doctor1_id']);

        return $rules;
    }
}
