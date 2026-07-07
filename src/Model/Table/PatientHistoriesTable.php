<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PatientHistories Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientHistoryDocumentsTable&\Cake\ORM\Association\HasMany $PatientHistoryDocuments
 * @property \App\Model\Table\PatientHistoryExaminationsTable&\Cake\ORM\Association\HasMany $PatientHistoryExaminations
 * @property \App\Model\Table\PatientHistoryIcaresTable&\Cake\ORM\Association\HasMany $PatientHistoryIcares
 * @property \App\Model\Table\PatientHistoryIntegrationsTable&\Cake\ORM\Association\HasMany $PatientHistoryIntegrations
 * @property \App\Model\Table\PatientHistoryLaboratoriesTable&\Cake\ORM\Association\HasMany $PatientHistoryLaboratories
 * @property \App\Model\Table\PatientHistoryPrescriptionsTable&\Cake\ORM\Association\HasMany $PatientHistoryPrescriptions
 * @property \App\Model\Table\PatientHistoryRadiologiesTable&\Cake\ORM\Association\HasMany $PatientHistoryRadiologies
 *
 * @method \App\Model\Entity\PatientHistory newEmptyEntity()
 * @method \App\Model\Entity\PatientHistory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PatientHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PatientHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\PatientHistory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PatientHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PatientHistory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PatientHistory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PatientHistory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PatientHistory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PatientHistory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PatientHistory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PatientHistory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PatientHistoriesTable extends Table
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

        $this->setTable('patient_histories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PatientHistoryDocuments', [
            'foreignKey' => 'patient_history_id',
        ]);
        $this->hasMany('PatientHistoryExaminations', [
            'foreignKey' => 'patient_history_id',
        ]);
        $this->hasMany('PatientHistoryIcares', [
            'foreignKey' => 'patient_history_id',
        ]);
        $this->hasMany('PatientHistoryIntegrations', [
            'foreignKey' => 'patient_history_id',
        ]);
        $this->hasMany('PatientHistoryLaboratories', [
            'foreignKey' => 'patient_history_id',
        ]);
        $this->hasMany('PatientHistoryPrescriptions', [
            'foreignKey' => 'patient_history_id',
        ]);
        $this->hasMany('PatientHistoryRadiologies', [
            'foreignKey' => 'patient_history_id',
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
        $rules->add(function ($entity) {
            if (empty($entity->registration_id)) {
                return false;
            }

            $conditions = [
                'registration_id' => (int)$entity->registration_id,
                'OR' => [
                    ['is_delete' => 0],
                    ['is_delete IS' => null],
                ],
            ];

            if (!empty($entity->id)) {
                $conditions['id !='] = (int)$entity->id;
            }

            return !$this->exists($conditions);
        }, 'uniqueActiveRegistration', [
            'errorField' => 'registration_id',
            'message' => 'Medical record untuk registrasi ini sudah ada.',
        ]);

        return $rules;
    }
}
