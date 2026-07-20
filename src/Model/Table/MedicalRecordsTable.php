<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MedicalRecords Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\OutpatientVisitsTable&\Cake\ORM\Association\BelongsTo $OutpatientVisits
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\MedicalRecordDiagnosesTable&\Cake\ORM\Association\HasMany $MedicalRecordDiagnoses
 * @property \App\Model\Table\MedicalRecordDocumentsTable&\Cake\ORM\Association\HasMany $MedicalRecordDocuments
 * @property \App\Model\Table\MedicalRecordExaminationsTable&\Cake\ORM\Association\HasMany $MedicalRecordExaminations
 * @property \App\Model\Table\MedicalRecordIcaresTable&\Cake\ORM\Association\HasMany $MedicalRecordIcares
 * @property \App\Model\Table\MedicalRecordInpatientsTable&\Cake\ORM\Association\HasMany $MedicalRecordInpatients
 * @property \App\Model\Table\MedicalRecordIntegrationsTable&\Cake\ORM\Association\HasMany $MedicalRecordIntegrations
 * @property \App\Model\Table\MedicalRecordLaboratoriesTable&\Cake\ORM\Association\HasMany $MedicalRecordLaboratories
 * @property \App\Model\Table\MedicalRecordOutpatientIgdsTable&\Cake\ORM\Association\HasMany $MedicalRecordOutpatientIgds
 * @property \App\Model\Table\MedicalRecordPrescriptionsTable&\Cake\ORM\Association\HasMany $MedicalRecordPrescriptions
 * @property \App\Model\Table\MedicalRecordRadiologiesTable&\Cake\ORM\Association\HasMany $MedicalRecordRadiologies
 *
 * @method \App\Model\Entity\MedicalRecord newEmptyEntity()
 * @method \App\Model\Entity\MedicalRecord newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecord[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecord get($primaryKey, $options = [])
 * @method \App\Model\Entity\MedicalRecord findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MedicalRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecord[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecord|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalRecord[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecord[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecord[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecord[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MedicalRecordsTable extends Table
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

        $this->setTable('medical_records');
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
        $this->belongsTo('OutpatientVisits', [
            'foreignKey' => 'outpatient_visit_id',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
        ]);
        $this->hasMany('MedicalRecordDiagnoses', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordDocuments', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordExaminations', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordIcares', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordInpatients', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordIntegrations', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordLaboratories', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordOutpatientIgds', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordPrescriptions', [
            'foreignKey' => 'medical_record_id',
        ]);
        $this->hasMany('MedicalRecordRadiologies', [
            'foreignKey' => 'medical_record_id',
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
            ->scalar('medical_record_no')
            ->maxLength('medical_record_no', 50)
            ->allowEmptyString('medical_record_no');

        $validator
            ->scalar('service_type')
            ->maxLength('service_type', 50)
            ->allowEmptyString('service_type');

        $validator
            ->scalar('allergy')
            ->allowEmptyString('allergy');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);

        // FIX: patient_id, outpatient_visit_id, doctor_id itu NULLABLE di database
        // (rekam medis boleh dibuat tanpa data ini dulu, diisi belakangan).
        // Tanpa 'allowNullValue' => true, rule existsIn bawaan CakePHP akan GAGAL
        // setiap kali nilainya null — bukan cuma di-skip. Ini yang bikin
        // MedicalRecords->save() selalu return false dan memicu
        // NestedTransactionRollbackException waktu dipanggil di dalam
        // transaction registrasi.
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), [
            'errorField' => 'patient_id',
            'allowNullValue' => true,
        ]);
        $rules->add($rules->existsIn(['outpatient_visit_id'], 'OutpatientVisits'), [
            'errorField' => 'outpatient_visit_id',
            'allowNullValue' => true,
        ]);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), [
            'errorField' => 'doctor_id',
            'allowNullValue' => true,
        ]);

        return $rules;
    } 

    public function generateMedicalRecordNo()
{
    $last = $this->find()
        ->select(['medical_record_no'])
        ->where(['medical_record_no LIKE' => 'RM%'])
        ->order(['id' => 'DESC'])
        ->first();

    if ($last && !empty($last->medical_record_no)) {
        $lastNumber = (int)str_replace('RM', '', $last->medical_record_no);
        $next = $lastNumber + 1;
    } else {
        $next = 1;
    }

    return 'RM' . str_pad((string)$next, 6, '0', STR_PAD_LEFT);
}
}
