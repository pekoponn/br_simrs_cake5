<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutpatientVisitEmr Model
 *
 * @property \App\Model\Table\OutpatientVisitsTable&\Cake\ORM\Association\BelongsTo $OutpatientVisits
 *
 * @method \App\Model\Entity\OutpatientVisitEmr newEmptyEntity()
 * @method \App\Model\Entity\OutpatientVisitEmr newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr get($primaryKey, $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientVisitEmr[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutpatientVisitEmrTable extends Table
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

        $this->setTable('outpatient_visit_emr');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OutpatientVisits', [
            'foreignKey' => 'outpatient_visit_id',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('blood_pressure')
            ->maxLength('blood_pressure', 20)
            ->allowEmptyString('blood_pressure');

        $validator
            ->nonNegativeInteger('pulse')
            ->allowEmptyString('pulse');

        $validator
            ->decimal('temperature')
            ->greaterThanOrEqual('temperature', 0)
            ->allowEmptyString('temperature');

        $validator
            ->nonNegativeInteger('respiratory_rate')
            ->allowEmptyString('respiratory_rate');

        $validator
            ->nonNegativeInteger('oxygen_saturation')
            ->allowEmptyString('oxygen_saturation');

        $validator
            ->decimal('weight')
            ->greaterThanOrEqual('weight', 0)
            ->allowEmptyString('weight');

        $validator
            ->decimal('height')
            ->greaterThanOrEqual('height', 0)
            ->allowEmptyString('height');

        $validator
            ->decimal('bmi')
            ->greaterThanOrEqual('bmi', 0)
            ->allowEmptyString('bmi');

        $validator
            ->scalar('chief_complaint')
            ->allowEmptyString('chief_complaint');

        $validator
            ->scalar('illness_history')
            ->allowEmptyString('illness_history');

        $validator
            ->scalar('admission_diagnosis')
            ->maxLength('admission_diagnosis', 255)
            ->allowEmptyString('admission_diagnosis');

        $validator
            ->scalar('allergy')
            ->maxLength('allergy', 255)
            ->allowEmptyString('allergy');

        $validator
            ->nonNegativeInteger('pain_scale')
            ->allowEmptyString('pain_scale');

        $validator
            ->scalar('diagnosis_primary')
            ->maxLength('diagnosis_primary', 100)
            ->allowEmptyString('diagnosis_primary');

        $validator
            ->scalar('diagnosis_secondary')
            ->maxLength('diagnosis_secondary', 255)
            ->allowEmptyString('diagnosis_secondary');

        $validator
            ->scalar('diagnosis_desc')
            ->allowEmptyString('diagnosis_desc');

        $validator
            ->scalar('icd10_items')
            ->allowEmptyString('icd10_items');

        $validator
            ->scalar('icd9_items')
            ->allowEmptyString('icd9_items');

        $validator
            ->scalar('anatomy_front')
            ->maxLength('anatomy_front', 255)
            ->allowEmptyString('anatomy_front');

        $validator
            ->scalar('anatomy_back')
            ->maxLength('anatomy_back', 255)
            ->allowEmptyString('anatomy_back');

        $validator
            ->scalar('action_notes')
            ->allowEmptyString('action_notes');

        $validator
            ->scalar('doctor_notes')
            ->allowEmptyString('doctor_notes');

        $validator
            ->scalar('prescription_notes')
            ->allowEmptyString('prescription_notes');

        $validator
            ->date('follow_up_date')
            ->allowEmptyDate('follow_up_date');

        $validator
            ->scalar('referral_to')
            ->maxLength('referral_to', 100)
            ->allowEmptyString('referral_to');

        $validator
            ->scalar('referral_reason')
            ->allowEmptyString('referral_reason');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 30)
            ->allowEmptyString('payment_method');

        $validator
            ->decimal('total_fee')
            ->notEmptyString('total_fee');

        $validator
            ->boolean('paid')
            ->notEmptyString('paid');

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

        return $rules;
    }
}
