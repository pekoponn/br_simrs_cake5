<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InpatientEntries Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\BelongsTo $Rooms
 * @property \App\Model\Table\BedsTable&\Cake\ORM\Association\BelongsTo $Beds
 *
 * @method \App\Model\Entity\InpatientEntry newEmptyEntity()
 * @method \App\Model\Entity\InpatientEntry newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\InpatientEntry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InpatientEntry get($primaryKey, $options = [])
 * @method \App\Model\Entity\InpatientEntry findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\InpatientEntry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InpatientEntry[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InpatientEntry|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InpatientEntry saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InpatientEntry[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InpatientEntry[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\InpatientEntry[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InpatientEntry[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InpatientEntriesTable extends Table
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

        $this->setTable('inpatient_entries');
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
        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
        ]);
        $this->belongsTo('Beds', [
            'foreignKey' => 'bed_id',
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
            ->scalar('patient_name')
            ->maxLength('patient_name', 255)
            ->allowEmptyString('patient_name');

        $validator
            ->scalar('patient_rm')
            ->maxLength('patient_rm', 50)
            ->allowEmptyString('patient_rm');

        $validator
            ->scalar('doctor_name')
            ->maxLength('doctor_name', 255)
            ->allowEmptyString('doctor_name');

        $validator
            ->scalar('room_name')
            ->maxLength('room_name', 100)
            ->allowEmptyString('room_name');

        $validator
            ->scalar('bed_no')
            ->maxLength('bed_no', 50)
            ->allowEmptyString('bed_no');

        $validator
            ->dateTime('check_in_date')
            ->allowEmptyDateTime('check_in_date');

        $validator
            ->date('planned_discharge_date')
            ->allowEmptyDate('planned_discharge_date');

        $validator
            ->dateTime('check_out_date')
            ->allowEmptyDateTime('check_out_date');

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
        $rules->add($rules->existsIn(['room_id'], 'Rooms'), ['errorField' => 'room_id']);
        $rules->add($rules->existsIn(['bed_id'], 'Beds'), ['errorField' => 'bed_id']);

        return $rules;
    }
}
