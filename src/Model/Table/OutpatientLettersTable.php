<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutpatientLetters Model
 *
 * @property \App\Model\Table\OutpatientVisitsTable&\Cake\ORM\Association\BelongsTo $OutpatientVisits
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 *
 * @method \App\Model\Entity\OutpatientLetter newEmptyEntity()
 * @method \App\Model\Entity\OutpatientLetter newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientLetter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientLetter get($primaryKey, $options = [])
 * @method \App\Model\Entity\OutpatientLetter findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OutpatientLetter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientLetter[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientLetter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientLetter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientLetter[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientLetter[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientLetter[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientLetter[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutpatientLettersTable extends Table
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

        $this->setTable('outpatient_letters');
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
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
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
            ->scalar('letter_type')
            ->maxLength('letter_type', 30)
            ->notEmptyString('letter_type');

        $validator
            ->scalar('letter_no')
            ->maxLength('letter_no', 50)
            ->allowEmptyString('letter_no');

        $validator
            ->decimal('weight')
            ->allowEmptyString('weight');

        $validator
            ->decimal('height')
            ->allowEmptyString('height');

        $validator
            ->scalar('blood_pressure')
            ->maxLength('blood_pressure', 20)
            ->allowEmptyString('blood_pressure');

        $validator
            ->decimal('temperature')
            ->allowEmptyString('temperature');

        $validator
            ->scalar('color_blind')
            ->maxLength('color_blind', 20)
            ->allowEmptyString('color_blind');

        $validator
            ->scalar('blood_type')
            ->maxLength('blood_type', 5)
            ->allowEmptyString('blood_type');

        $validator
            ->integer('leave_days')
            ->allowEmptyString('leave_days');

        $validator
            ->date('leave_from')
            ->allowEmptyDate('leave_from');

        $validator
            ->date('leave_to')
            ->allowEmptyDate('leave_to');

        $validator
            ->scalar('diagnosis')
            ->allowEmptyString('diagnosis');

        $validator
            ->boolean('is_normal')
            ->allowEmptyString('is_normal');

        $validator
            ->date('examined_at')
            ->allowEmptyDate('examined_at');

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
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);

        return $rules;
    }
}