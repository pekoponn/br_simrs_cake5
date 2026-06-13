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
 * Patients Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\HasMany $Registrations
 *
 * @method \App\Model\Entity\Patient newEmptyEntity()
 * @method \App\Model\Entity\Patient newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Patient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Patient get($primaryKey, $options = [])
 * @method \App\Model\Entity\Patient findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Patient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Patient[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Patient|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Patient saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Patient[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Patient[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Patient[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Patient[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PatientsTable extends Table
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

        $this->setTable('patients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Registrations', [
            'foreignKey' => 'patient_id',
        ]);
    }

    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
    {
        foreach ($data as $field => $value) {
            if (is_string($value)) {
                $data[$field] = trim($value);
            }
        }

        if (!empty($data['birth_date']) && is_string($data['birth_date']) && strpos($data['birth_date'], '/') !== false) {
            $parts = explode('/', $data['birth_date']);
            if (count($parts) === 3) {
                $data['birth_date'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }

        if (array_key_exists('birth_date', $data) && $data['birth_date'] === '') {
            $data['birth_date'] = null;
        }
    }

    public function generateCode()
    {
        $lastPatient = $this->find()
            ->select(['code'])
            ->where(['code LIKE' => 'PAT-%'])
            ->order(['id' => 'DESC'])
            ->first();

        if ($lastPatient && !empty($lastPatient->code)) {
            $lastNumber = (int) str_replace('PAT-', '', $lastPatient->code);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'PAT-' . str_pad((string)$newNumber, 5, '0', STR_PAD_LEFT);
    }

    public function generateMedicalRecordNo()
    {
        $lastPatient = $this->find()
            ->select(['medical_record_no'])
            ->where(['medical_record_no LIKE' => 'RM%'])
            ->order(['id' => 'DESC'])
            ->first();

        if ($lastPatient && !empty($lastPatient->medical_record_no)) {
            $lastNumber = (int) str_replace('RM', '', $lastPatient->medical_record_no);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'RM' . str_pad((string) $newNumber, 6, '0', STR_PAD_LEFT);
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['code']), [
            'errorField' => 'code',
            'message' => 'Kode pasien sudah terdaftar.'
        ]);

        if ($this->getSchema()->hasColumn('medical_record_no')) {
            $rules->add($rules->isUnique(['medical_record_no']), [
                'errorField' => 'medical_record_no',
                'message' => 'No rekam medis sudah terdaftar.'
            ]);
        }

        $rules->add(function ($entity) {
            if (empty($entity->identity_number)) {
                return true;
            }

            $conditions = ['identity_number' => $entity->identity_number];
            if (!empty($entity->id)) {
                $conditions['id !='] = $entity->id;
            }

            return !$this->exists($conditions);
        }, 'uniqueIdentityNumber', [
            'errorField' => 'identity_number',
            'message' => 'No identitas sudah terdaftar.',
        ]);

        return $rules;
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
            ->scalar('code')
            ->maxLength('code', 50)
            ->notEmptyString('code');

        if ($this->getSchema()->hasColumn('medical_record_no')) {
            $validator
                ->scalar('medical_record_no')
                ->maxLength('medical_record_no', 50)
                ->allowEmptyString('medical_record_no');
        }

        $validator
            ->scalar('full_name')
            ->maxLength('full_name', 255)
            ->notEmptyString('full_name');

        $validator
            ->scalar('identity_type')
            ->maxLength('identity_type', 50)
            ->allowEmptyString('identity_type');

        $validator
            ->scalar('identity_number')
            ->maxLength('identity_number', 50)
            ->allowEmptyString('identity_number');

        $validator
            ->scalar('gender')
            ->allowEmptyString('gender');

        $validator
            ->scalar('blood_type')
            ->maxLength('blood_type', 5)
            ->allowEmptyString('blood_type');

        $validator
            ->date('birth_date')
            ->allowEmptyDate('birth_date');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('mother_name')
            ->maxLength('mother_name', 255)
            ->allowEmptyString('mother_name');

        $validator
            ->scalar('father_name')
            ->maxLength('father_name', 255)
            ->allowEmptyString('father_name');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 20)
            ->allowEmptyString('phone_number');

        $validator
            ->scalar('nationality')
            ->maxLength('nationality', 100)
            ->allowEmptyString('nationality');

        $validator
            ->scalar('citizenship')
            ->maxLength('citizenship', 100)
            ->allowEmptyString('citizenship');

        $validator
            ->scalar('province')
            ->maxLength('province', 100)
            ->allowEmptyString('province');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->allowEmptyString('city');

        $validator
            ->scalar('district')
            ->maxLength('district', 100)
            ->allowEmptyString('district');

        $validator
            ->scalar('subdistrict')
            ->maxLength('subdistrict', 100)
            ->allowEmptyString('subdistrict');

        $validator
            ->scalar('occupation')
            ->maxLength('occupation', 100)
            ->allowEmptyString('occupation');

        $validator
            ->scalar('religion')
            ->maxLength('religion', 50)
            ->allowEmptyString('religion');

        $validator
            ->scalar('education')
            ->maxLength('education', 100)
            ->allowEmptyString('education');

        $validator
            ->scalar('ethnic_group')
            ->maxLength('ethnic_group', 100)
            ->allowEmptyString('ethnic_group');

        $validator
            ->scalar('marital_status')
            ->maxLength('marital_status', 50)
            ->allowEmptyString('marital_status');

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

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        return $validator;
    }
}
