<?php

declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Registrations Model
 *
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\BelongsTo $Rooms
 * @property \App\Model\Table\BedsTable&\Cake\ORM\Association\BelongsTo $Beds
 * @property \App\Model\Table\PersonResponsiblesTable&\Cake\ORM\Association\BelongsTo $PersonResponsibles
 * @property \App\Model\Table\PersonResponsiblesTable&\Cake\ORM\Association\HasMany $PersonResponsible
 *
 * @method \App\Model\Entity\Registration newEmptyEntity()
 * @method \App\Model\Entity\Registration newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Registration[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Registration get($primaryKey, $options = [])
 * @method \App\Model\Entity\Registration findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Registration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Registration[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Registration|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Registration saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Registration[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RegistrationsTable extends Table
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

        $this->setTable('registrations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Beds', [
            'foreignKey' => 'bed_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('PersonResponsibles', [
            'foreignKey' => 'person_responsible_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('PolyclinicQueues', [
            'foreignKey' => 'polyclinic_queue_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasOne('MedicalRecords', [
            'foreignKey' => 'registration_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('PersonResponsible', [
            'className' => 'PersonResponsibles',
            'foreignKey' => 'registration_id',
        ]);
    }

    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
    {
        foreach ($data as $field => $value) {
            if (is_string($value)) {
                $data[$field] = trim($value);
            }
        }

        foreach (['registration_date'] as $field) {
            if (!empty($data[$field]) && is_string($data[$field]) && strpos($data[$field], '/') !== false) {
                $parts = explode('/', $data[$field]);
                if (count($parts) === 3) {
                    $data[$field] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                }
            }
        }

        foreach ($this->nullableFields() as $field) {
            if (array_key_exists($field, $data) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        $data['treatment_type'] = $data['treatment_type'] ?? 'BIASA';
        $data['status'] = $data['status'] ?? 'aktif';
        $data['is_create'] = $data['is_create'] ?? 1;
        $data['is_update'] = $data['is_update'] ?? 0;
        $data['is_delete'] = $data['is_delete'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? 'Y';
    }

    private function nullableFields(): array
    {
        return [
            'admission_time',
            'doctor_id',
            'doctor_schedule_id',
            'polyclinic_queue_id',
            'queue_number',
            'polyclinic_name',
            'room_name',
            'room_id',
            'bed_id',
            'class_name',
            'insurance_type',
            'insurance_category',
            'insurance_card_no',
            'refferal_no',
            'skdp_no',
            'reference_type',
            'sep_no',
            'bpjs_nik',
            'bpjs_name',
            'bpjs_group',
            'bpjs_type',
            'bpjs_class',
            'provider',
            'person_responsible_id',
            'referral_type',
            'referral_doctor',
            'referral_origin',
            'referral_name',
            'deleted',
            'delete_log',
        ];
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
            ->requirePresence('registration_no', 'create')
            ->notEmptyString('registration_no');

        $validator
            ->date('registration_date')
            ->requirePresence('registration_date', 'create')
            ->notEmptyDate('registration_date');

        $validator
            ->scalar('service_type')
            ->maxLength('service_type', 255)
            ->requirePresence('service_type', 'create')
            ->notEmptyString('service_type');

        $validator
            ->integer('patient_id')
            ->requirePresence('patient_id', 'create')
            ->notEmptyString('patient_id');

        $validator
            ->integer('doctor_id')
            ->allowEmptyString('doctor_id');

        $validator
            ->integer('doctor_schedule_id')
            ->allowEmptyString('doctor_schedule_id');

        $validator
            ->integer('polyclinic_queue_id')
            ->allowEmptyString('polyclinic_queue_id');

        $validator
            ->scalar('polyclinic_name')
            ->maxLength('polyclinic_name', 255)
            ->allowEmptyString('polyclinic_name')
            ->add('polyclinic_name', 'requiredForOutpatient', [
                'rule' => function ($value, $context) {
                    return ($context['data']['service_type'] ?? '') !== 'rawat_jalan' || !empty($value);
                },
                'message' => 'Poli wajib diisi untuk rawat jalan',
            ]);

        $validator
            ->scalar('room_name')
            ->maxLength('room_name', 100)
            ->allowEmptyString('room_name');

        $validator
            ->integer('room_id')
            ->allowEmptyString('room_id');

        $validator
            ->integer('bed_id')
            ->allowEmptyString('bed_id');

        $validator
            ->scalar('class_name')
            ->maxLength('class_name', 100)
            ->allowEmptyString('class_name')
            ->add('class_name', 'requiredForRawatInap', [
                'rule' => function ($value, $context) {
                    if (($context['data']['service_type'] ?? '') === 'rawat_inap') {
                        return !empty($value);
                    }

                    return true;
                },
                'message' => 'Kelas wajib diisi untuk rawat inap'
            ]);

        $validator
            ->scalar('entry_process')
            ->maxLength('entry_process', 255)
            ->requirePresence('entry_process', 'create')
            ->notEmptyString('entry_process');

        $validator
            ->scalar('entry_method')
            ->maxLength('entry_method', 255)
            ->requirePresence('entry_method', 'create')
            ->notEmptyString('entry_method');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 255)
            ->requirePresence('payment_method', 'create')
            ->notEmptyString('payment_method');

        $validator
            ->scalar('insurance_type')
            ->maxLength('insurance_type', 255)
            ->allowEmptyString('insurance_type');

        $validator
            ->scalar('insurance_card_no')
            ->maxLength('insurance_card_no', 30)
            ->allowEmptyString('insurance_card_no');

        $validator
            ->scalar('refferal_no')
            ->maxLength('refferal_no', 30)
            ->allowEmptyString('refferal_no');

        $validator
            ->scalar('sep_no')
            ->maxLength('sep_no', 50)
            ->allowEmptyString('sep_no');

        $validator
            ->scalar('treatment_type')
            ->maxLength('treatment_type', 50)
            ->requirePresence('treatment_type', 'create')
            ->notEmptyString('treatment_type');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

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

        foreach ([
            'insurance_category',
            'skdp_no',
            'reference_type',
            'bpjs_nik',
            'bpjs_name',
            'bpjs_group',
            'bpjs_type',
            'bpjs_class',
            'provider',
            'referral_type',
            'referral_doctor',
            'referral_origin',
            'referral_name',
        ] as $field) {
            if ($this->getSchema()->hasColumn($field)) {
                $validator
                    ->scalar($field)
                    ->allowEmptyString($field);
            }
        }

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
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add(function ($entity) {
            if (empty($entity->doctor_id)) {
                return true;
            }

            return $this->Doctors->exists(['Doctors.id' => (int)$entity->doctor_id]);
        }, 'doctorExists', [
            'errorField' => 'doctor_id',
            'message' => 'Dokter tidak ditemukan.',
        ]);
        // $rules->add($rules->existsIn(['room_id'], 'Rooms'), ['errorField' => 'room_id']);
        // $rules->add($rules->existsIn(['bed_id'], 'Beds'), ['errorField' => 'bed_id']);
        $rules->add(function ($entity) {
            if (empty($entity->person_responsible_id)) {
                return true;
            }

            return $this->PersonResponsibles->exists(['PersonResponsibles.id' => (int)$entity->person_responsible_id]);
        }, 'personResponsibleExists', [
            'errorField' => 'person_responsible_id',
            'message' => 'Penanggung jawab tidak ditemukan.',
        ]);

        return $rules;
    }
}
