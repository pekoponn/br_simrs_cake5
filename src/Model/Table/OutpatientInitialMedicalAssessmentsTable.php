<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OutpatientInitialMedicalAssessmentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('outpatient_initial_medical_assessments');
        $this->setDisplayField('assessment_no');
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
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('outpatient_visit_id')
            ->requirePresence('outpatient_visit_id', 'create')
            ->notEmptyString('outpatient_visit_id');

        $validator
            ->scalar('assessment_no')
            ->maxLength('assessment_no', 50)
            ->allowEmptyString('assessment_no');

        $validator
            ->date('assessment_date')
            ->allowEmptyDate('assessment_date');

        $validator
            ->time('assessment_time')
            ->allowEmptyTime('assessment_time');

        foreach (['data_dasar', 'subjektif', 'observasi'] as $field) {
            $validator
                ->scalar($field)
                ->allowEmptyString($field);
        }

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['outpatient_visit_id'], 'OutpatientVisits'), ['errorField' => 'outpatient_visit_id']);

        return $rules;
    }
}
