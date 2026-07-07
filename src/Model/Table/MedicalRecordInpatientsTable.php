<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MedicalRecordInpatients Model
 *
 * @property \App\Model\Table\MedicalRecordsTable&\Cake\ORM\Association\BelongsTo $MedicalRecords
 *
 * @method \App\Model\Entity\MedicalRecordInpatient newEmptyEntity()
 * @method \App\Model\Entity\MedicalRecordInpatient newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient get($primaryKey, $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MedicalRecordInpatient[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MedicalRecordInpatientsTable extends Table
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

        $this->setTable('medical_record_inpatients');
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
            ->scalar('jenis')
            ->maxLength('jenis', 100)
            ->allowEmptyString('jenis');

        $validator
            ->scalar('pelayanan')
            ->maxLength('pelayanan', 100)
            ->allowEmptyString('pelayanan');

        $validator
            ->scalar('kelas')
            ->maxLength('kelas', 100)
            ->allowEmptyString('kelas');

        $validator
            ->scalar('ruang')
            ->maxLength('ruang', 150)
            ->allowEmptyString('ruang');

        $validator
            ->date('tgl_masuk')
            ->allowEmptyDate('tgl_masuk');

        $validator
            ->date('tgl_keluar')
            ->allowEmptyDate('tgl_keluar');

        $validator
            ->date('tgl_operasi')
            ->allowEmptyDate('tgl_operasi');

        $validator
            ->scalar('nama_dokter')
            ->maxLength('nama_dokter', 150)
            ->allowEmptyString('nama_dokter');

        $validator
            ->scalar('keadaan_keluar_rs')
            ->maxLength('keadaan_keluar_rs', 150)
            ->allowEmptyString('keadaan_keluar_rs');

        $validator
            ->scalar('cara_keluar')
            ->maxLength('cara_keluar', 150)
            ->allowEmptyString('cara_keluar');

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
