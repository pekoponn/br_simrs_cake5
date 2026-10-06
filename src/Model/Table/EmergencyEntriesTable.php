<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmergencyEntries Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\MasterTenagaMedisTable&\Cake\ORM\Association\BelongsTo $MasterTenagaMedis
 *
 * @method \App\Model\Entity\EmergencyEntry newEmptyEntity()
 * @method \App\Model\Entity\EmergencyEntry newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyEntry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyEntry get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmergencyEntry findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EmergencyEntry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyEntry[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyEntry|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmergencyEntry saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyEntry[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmergencyEntriesTable extends Table
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

        $this->setTable('emergency_entries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('registration_no')
            ->maxLength('registration_no', 50)
            ->allowEmptyString('registration_no');

        $validator
            ->scalar('triase_no')
            ->maxLength('triase_no', 50)
            ->allowEmptyString('triase_no');

        $validator
            ->scalar('patient_rm')
            ->maxLength('patient_rm', 50)
            ->allowEmptyString('patient_rm');

        $validator
            ->scalar('patient_name')
            ->maxLength('patient_name', 255)
            ->allowEmptyString('patient_name');

        $validator
            ->scalar('doctor_name')
            ->maxLength('doctor_name', 255)
            ->allowEmptyString('doctor_name');

        $validator
            ->scalar('nurse_name')
            ->maxLength('nurse_name', 255)
            ->allowEmptyString('nurse_name');

        $validator
            ->scalar('allergy_status')
            ->maxLength('allergy_status', 10)
            ->allowEmptyString('allergy_status');

        $validator
            ->scalar('allergy_detail')
            ->maxLength('allergy_detail', 255)
            ->allowEmptyString('allergy_detail');

        $validator
            ->scalar('perilaku')
            ->maxLength('perilaku', 255)
            ->allowEmptyString('perilaku');

        $validator
            ->integer('gcs_e')
            ->allowEmptyString('gcs_e');

        $validator
            ->integer('gcs_v')
            ->allowEmptyString('gcs_v');

        $validator
            ->integer('gcs_m')
            ->allowEmptyString('gcs_m');

        $validator
            ->scalar('pupil_kanan')
            ->maxLength('pupil_kanan', 20)
            ->allowEmptyString('pupil_kanan');

        $validator
            ->scalar('pupil_kiri')
            ->maxLength('pupil_kiri', 20)
            ->allowEmptyString('pupil_kiri');

        $validator
            ->scalar('reflex_kanan')
            ->maxLength('reflex_kanan', 20)
            ->allowEmptyString('reflex_kanan');

        $validator
            ->scalar('reflex_kiri')
            ->maxLength('reflex_kiri', 20)
            ->allowEmptyString('reflex_kiri');

        $validator
            ->scalar('nadi_jenis')
            ->maxLength('nadi_jenis', 20)
            ->allowEmptyString('nadi_jenis');

        $validator
            ->scalar('akral')
            ->maxLength('akral', 50)
            ->allowEmptyString('akral');

        $validator
            ->integer('pain_scale')
            ->allowEmptyString('pain_scale');

        $validator
            ->integer('flacc_wajah')
            ->allowEmptyString('flacc_wajah');

        $validator
            ->integer('flacc_kaki')
            ->allowEmptyString('flacc_kaki');

        $validator
            ->integer('flacc_aktifitas')
            ->allowEmptyString('flacc_aktifitas');

        $validator
            ->integer('flacc_menangis')
            ->allowEmptyString('flacc_menangis');

        $validator
            ->integer('flacc_bersuara')
            ->allowEmptyString('flacc_bersuara');

        $validator
            ->integer('flacc_total')
            ->allowEmptyString('flacc_total');

        $validator
            ->date('service_date')
            ->allowEmptyDate('service_date');

        $validator
            ->time('service_time')
            ->allowEmptyTime('service_time');

        $validator
            ->scalar('chief_complaint')
            ->allowEmptyString('chief_complaint');

        $validator
            ->scalar('triage_category')
            ->maxLength('triage_category', 50)
            ->allowEmptyString('triage_category');

        $validator
            ->scalar('triage_notes')
            ->allowEmptyString('triage_notes');

        $validator
            ->scalar('blood_pressure')
            ->maxLength('blood_pressure', 50)
            ->allowEmptyString('blood_pressure');

        $validator
            ->scalar('temperature')
            ->maxLength('temperature', 50)
            ->allowEmptyString('temperature');

        $validator
            ->scalar('pulse')
            ->maxLength('pulse', 50)
            ->allowEmptyString('pulse');

        $validator
            ->scalar('respiration')
            ->maxLength('respiration', 50)
            ->allowEmptyString('respiration');

        $validator
            ->scalar('spo2')
            ->maxLength('spo2', 50)
            ->allowEmptyString('spo2');

        $validator
            ->scalar('diagnosis')
            ->allowEmptyString('diagnosis');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->boolean('is_active')
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
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);
        $rules->add($rules->existsIn(['nurse_id'], 'MasterTenagaMedis'), ['errorField' => 'nurse_id']);

        return $rules;
    }
}