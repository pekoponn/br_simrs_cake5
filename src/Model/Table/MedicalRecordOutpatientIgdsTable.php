<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MedicalRecordOutpatientIgds Model
 *
 * @property \App\Model\Table\MedicalRecordsTable&\Cake\ORM\Association\BelongsTo $MedicalRecords
 *
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd newEmptyEntity()
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd get($primaryKey, $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordOutpatientIgd[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MedicalRecordOutpatientIgdsTable extends Table
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

        $this->setTable('medical_record_outpatient_igds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MedicalRecords', [
            'foreignKey' => 'medical_record_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('triage')
            ->maxLength('triage', 100)
            ->allowEmptyString('triage');

        $validator
            ->scalar('keadaan_keluar')
            ->maxLength('keadaan_keluar', 150)
            ->allowEmptyString('keadaan_keluar');

        $validator
            ->scalar('cara_bayar')
            ->maxLength('cara_bayar', 100)
            ->allowEmptyString('cara_bayar');

        $validator
            ->scalar('cara_masuk')
            ->maxLength('cara_masuk', 100)
            ->allowEmptyString('cara_masuk');

        $validator
            ->scalar('catatan')
            ->allowEmptyString('catatan');

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
        $rules->add($rules->existsIn(['medical_record_id'], 'MedicalRecords'), ['errorField' => 'medical_record_id']);

        return $rules;
    }
}
