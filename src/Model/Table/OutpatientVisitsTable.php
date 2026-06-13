<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutpatientVisits Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\PolyclinicQueuesTable&\Cake\ORM\Association\BelongsTo $PolyclinicQueues
 * @property \App\Model\Table\OutpatientActionsTable&\Cake\ORM\Association\HasMany $OutpatientActions
 *
 * @method \App\Model\Entity\OutpatientVisit newEmptyEntity()
 * @method \App\Model\Entity\OutpatientVisit newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientVisit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientVisit get($primaryKey, $options = [])
 * @method \App\Model\Entity\OutpatientVisit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OutpatientVisit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientVisit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientVisit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientVisit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientVisit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientVisit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientVisit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientVisit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutpatientVisitsTable extends Table
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

        $this->setTable('outpatient_visits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
        ]);
        $this->belongsTo('PolyclinicQueues', [
            'foreignKey' => 'queue_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('OutpatientActions', [
            'foreignKey' => 'outpatient_visit_id',
        ]);
    }

    public function syncFromRegistration($registration)
    {
        if (empty($registration->id) || empty($registration->patient_id)) {
            return false;
        }

        $visit = $this->find()
            ->where(['registration_id' => (int)$registration->id])
            ->first() ?: $this->newEmptyEntity();

        $visitDate = $this->formatVisitDate($registration->registration_date ?? null);
        $data = [
            'registration_id' => (int)$registration->id,
            'registration_no' => $registration->registration_no ?? null,
            'patient_id' => (int)$registration->patient_id,
            'doctor_id' => !empty($registration->doctor_id) ? (int)$registration->doctor_id : null,
            'queue_number' => !empty($registration->queue_number) ? (int)$registration->queue_number : null,
            'polyclinic_name' => $registration->polyclinic_name ?? null,
            'visit_date' => $visitDate,
            'visit_time' => $visit->visit_time ?? $this->formatVisitTime($registration->admission_time ?? null),
            'status' => $visit->status ?? 'waiting',
            'payment_method' => $registration->payment_method ?? null,
            'total_fee' => $visit->total_fee ?? '0',
            'paid' => $visit->paid ?? '0',
        ];

        if ($this->getSchema()->hasColumn('queue_id')) {
            $data['queue_id'] = !empty($registration->polyclinic_queue_id)
                ? (int)$registration->polyclinic_queue_id
                : null;
        }

        $visit = $this->patchEntity($visit, $data);

        return $this->save($visit);
    }

    private function formatVisitDate($date): string
    {
        if (empty($date)) {
            return date('Y-m-d');
        }

        if (is_object($date) && method_exists($date, 'format')) {
            return $date->format('Y-m-d');
        }

        return date('Y-m-d', strtotime((string)$date));
    }

    private function formatVisitTime($time): string
    {
        if (empty($time)) {
            return date('H:i:s');
        }

        if (is_object($time) && method_exists($time, 'format')) {
            return $time->format('H:i:s');
        }

        return date('H:i:s', strtotime((string)$time));
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
            ->scalar('registration_no')
            ->maxLength('registration_no', 50)
            ->requirePresence('registration_no', 'create')
            ->notEmptyString('registration_no');

        $validator
            ->integer('registration_id')
            ->requirePresence('registration_id', 'create')
            ->notEmptyString('registration_id');

        $validator
            ->integer('patient_id')
            ->requirePresence('patient_id', 'create')
            ->notEmptyString('patient_id');

        $validator
            ->integer('doctor_id')
            ->allowEmptyString('doctor_id');

        $validator
            ->integer('queue_id')
            ->allowEmptyString('queue_id');

        $validator
            ->integer('queue_number')
            ->allowEmptyString('queue_number');

        $validator
            ->scalar('polyclinic_name')
            ->maxLength('polyclinic_name', 100)
            ->allowEmptyString('polyclinic_name');

        $validator
            ->date('visit_date')
            ->requirePresence('visit_date', 'create')
            ->notEmptyDate('visit_date');

        $validator
            ->time('visit_time')
            ->allowEmptyTime('visit_time');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->notEmptyString('status');

        $validator
            ->dateTime('called_at')
            ->allowEmptyDateTime('called_at');

        $validator
            ->dateTime('start_time')
            ->allowEmptyDateTime('start_time');

        $validator
            ->dateTime('end_time')
            ->allowEmptyDateTime('end_time');

        $validator
            ->scalar('blood_pressure')
            ->maxLength('blood_pressure', 20)
            ->allowEmptyString('blood_pressure');

        $validator
            ->integer('pulse')
            ->allowEmptyString('pulse');

        $validator
            ->decimal('temperature')
            ->allowEmptyString('temperature');

        $validator
            ->integer('respiratory_rate')
            ->allowEmptyString('respiratory_rate');

        $validator
            ->integer('oxygen_saturation')
            ->allowEmptyString('oxygen_saturation');

        $validator
            ->decimal('weight')
            ->allowEmptyString('weight');

        $validator
            ->decimal('height')
            ->allowEmptyString('height');

        $validator
            ->decimal('bmi')
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
            ->integer('pain_scale')
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

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 50)
            ->allowEmptyString('created_by');

        $validator
            ->scalar('updated_by')
            ->maxLength('updated_by', 50)
            ->allowEmptyString('updated_by');

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
        $rules->add($rules->isUnique(['registration_id']), [
            'errorField' => 'registration_id',
            'message' => 'Kunjungan rawat jalan untuk registrasi ini sudah ada.',
        ]);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);
        $rules->add($rules->existsIn(['queue_id'], 'PolyclinicQueues'), ['errorField' => 'queue_id']);

        return $rules;
    }
}
