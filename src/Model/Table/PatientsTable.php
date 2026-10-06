<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Patients Model
 *
 * @property \App\Model\Table\PatientPicsTable&\Cake\ORM\Association\HasMany $PatientPics
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

        $this->hasMany('PatientPics', [
            'foreignKey' => 'patient_id',
        ]);
        $this->hasMany('Registrations', [
            'foreignKey' => 'patient_id',
        ]);
    }

    /**
     * @deprecated Sudah tidak dipakai. No. Rekam Medis (patients.code)
     * sekarang di-generate lewat generatePatientCode() (format Ymd+Ymd,
     * tanpa dash), bukan format "P000001" seperti method ini. Dibiarkan
     * di sini (tidak dihapus) supaya tidak memutus kode lain yang mungkin
     * masih memanggilnya, tapi jangan dipakai untuk generate code baru.
     */
    public function generateCode()
    {
        $lastPatient = $this->find()
            ->select(['code'])
            ->where(['code LIKE' => 'P%'])
            ->order(['id' => 'DESC'])
            ->first();

        if ($lastPatient && !empty($lastPatient->code)) {
            $lastNumber = (int) str_replace('P', '', $lastPatient->code);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'P' . str_pad((string) $newNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate No. Rekam Medis (disimpan sebagai patients.code) dari
     * gabungan tanggal lahir + tanggal data pasien dibuat, format ymd+ymd
     * (2 digit tahun) tanpa pemisah -> total 12 digit.
     * Contoh: lahir 29-04-2008, didaftarkan 11-08-2026 -> "080429260811"
     * (080429 = tahun/bulan/tanggal lahir, 260811 = tahun/bulan/tanggal dibuat).
     * Kalau kombinasi ini sudah dipakai pasien lain (lahir & didaftarkan di
     * hari yang sama), ditambah angka urut di belakang tanpa dash supaya
     * tetap unik.
     *
     * Dipanggil dari PatientsController (tambah/edit pasien langsung) dan
     * dari RegistrationsController (saat bikin pasien baru sambil
     * registrasi), supaya logic-nya satu sumber, tidak dobel.
     *
     * @param string|null $birthDate Tanggal lahir pasien, format Y-m-d.
     * @return string
     */
    public function generatePatientCode(?string $birthDate): string
    {
        $birthPart = '000000';
        if (!empty($birthDate)) {
            $ts = strtotime($birthDate);
            if ($ts !== false) {
                $birthPart = date('ymd', $ts);
            }
        }

        $createdPart = date('ymd');
        $base = $birthPart . $createdPart;

        $code = $base;
        $suffix = 1;

        while ($this->exists(['code' => $code])) {
            $suffix++;
            $code = $base . $suffix;
        }

        return $code;
    }

    public function buildRules(\Cake\ORM\RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add(
            $rules->isUnique(
                ['identity_number'],
                'No identitas sudah terdaftar'
            )
        );

        $rules->add(
            $rules->isUnique(
                ['code'],
                'No. Rekam Medis ini sudah dipakai pasien lain'
            )
        );

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

        $validator
            ->scalar('full_name')
            ->maxLength('full_name', 255)
            ->notEmptyString('full_name');

        $validator
            ->scalar('identity_type')
            ->maxLength('identity_type', 50)
            ->notEmptyString('identity_type');

        $validator
            ->scalar('identity_number')
            ->maxLength('identity_number', 50)
            ->notEmptyString('identity_number');

        $validator
            ->scalar('insurance_card_no')
            ->maxLength('insurance_card_no', 30)
            ->allowEmptyString('insurance_card_no');

        $validator
            ->scalar('gender')
            ->notEmptyString('gender');

        $validator
            ->scalar('blood_type')
            ->maxLength('blood_type', 5)
            ->notEmptyString('blood_type');

        $validator
            ->scalar('allergy')
            ->maxLength('allergy', 255)
            ->allowEmptyString('allergy');

        $validator
            ->date('birth_date')
            ->allowEmptyDate('birth_date');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('mother_name')
            ->maxLength('mother_name', 255)
            ->notEmptyString('mother_name');

        $validator
            ->scalar('father_name')
            ->maxLength('father_name', 255)
            ->notEmptyString('father_name');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 20)
            ->notEmptyString('phone_number');

        $validator
            ->scalar('nationality')
            ->maxLength('nationality', 100)
            ->notEmptyString('nationality');

        $validator
            ->scalar('citizenship')
            ->maxLength('citizenship', 100)
            ->notEmptyString('citizenship');

        $validator
            ->scalar('province')
            ->maxLength('province', 100)
            ->notEmptyString('province');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->notEmptyString('city');

        $validator
            ->scalar('district')
            ->maxLength('district', 100)
            ->notEmptyString('district');

        $validator
            ->scalar('subdistrict')
            ->maxLength('subdistrict', 100)
            ->notEmptyString('subdistrict');

        $validator
            ->scalar('occupation')
            ->maxLength('occupation', 100)
            ->notEmptyString('occupation');

        $validator
            ->scalar('religion')
            ->maxLength('religion', 50)
            ->notEmptyString('religion');

        $validator
            ->scalar('education')
            ->maxLength('education', 100)
            ->notEmptyString('education');

        $validator
            ->scalar('ethnic_group')
            ->maxLength('ethnic_group', 100)
            ->notEmptyString('ethnic_group');

        $validator
            ->scalar('marital_status')
            ->maxLength('marital_status', 50)
            ->notEmptyString('marital_status');

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