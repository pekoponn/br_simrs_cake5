<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HrgaEmployees Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\HrgaAttendancesTable&\Cake\ORM\Association\HasMany $HrgaAttendances
 *
 * @method \App\Model\Entity\HrgaEmployee newEmptyEntity()
 * @method \App\Model\Entity\HrgaEmployee newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployee get($primaryKey, $options = [])
 * @method \App\Model\Entity\HrgaEmployee findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\HrgaEmployee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployee[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\HrgaEmployee|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HrgaEmployee saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HrgaEmployee[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployee[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployee[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HrgaEmployee[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HrgaEmployeesTable extends Table
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

        $this->setTable('hrga_employees');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('HrgaAttendances', [
            'foreignKey' => 'hrga_employee_id',
        ]);
        $this->hasMany('Salaries', [
            'foreignKey' => 'hrga_employee_id',
        ]);
        $this->hasMany('HrgaEmployeeLines', ['dependent' => true])->setForeignKey('hrga_employee_id')->setDependent(true);

         $this->hasMany('HrgaEmployeeTrainings', ['dependent' => true])->setForeignKey('hrga_employee_id')->setDependent(true);
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
            ->scalar('branch')
            ->maxLength('branch', 255)
            ->allowEmptyString('branch');

        $validator
            ->scalar('pin')
            ->maxLength('pin', 32)
            ->allowEmptyString('pin');

        $validator
            ->scalar('grade')
            ->maxLength('grade', 32)
            ->allowEmptyString('grade');

        $validator
            ->scalar('golongan')
            ->maxLength('golongan', 32)
            ->allowEmptyString('golongan');

        $validator
            ->scalar('nip')
            ->maxLength('nip', 30)
            ->allowEmptyString('nip')
            ->add('nip', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('no_ktp')
            ->maxLength('no_ktp', 255)
            ->allowEmptyString('no_ktp');

        $validator
            ->scalar('no_kk')
            ->maxLength('no_kk', 255)
            ->allowEmptyString('no_kk');

        $validator
            ->scalar('address_ktp')
            ->maxLength('address_ktp', 255)
            ->allowEmptyString('address_ktp');

        $validator
            ->scalar('status_tanggungan')
            ->allowEmptyString('status_tanggungan');

        $validator
            ->scalar('pendidikan')
            ->maxLength('pendidikan', 255)
            ->allowEmptyString('pendidikan');

        $validator
            ->scalar('jurusan')
            ->maxLength('jurusan', 255)
            ->allowEmptyString('jurusan');

        $validator
            ->scalar('alias')
            ->maxLength('alias', 50)
            ->allowEmptyString('alias');

        $validator
            ->date('graduation_date')
            ->allowEmptyDate('graduation_date');

        $validator
            ->scalar('pwd')
            ->maxLength('pwd', 10)
            ->allowEmptyString('pwd');

        $validator
            ->scalar('rfid')
            ->maxLength('rfid', 32)
            ->allowEmptyString('rfid');

        $validator
            ->scalar('devisi')
            ->maxLength('devisi', 255)
            ->allowEmptyString('devisi');

        $validator
            ->scalar('sub_devisi')
            ->maxLength('sub_devisi', 255)
            ->allowEmptyString('sub_devisi');

        $validator
            ->scalar('position')
            ->maxLength('position', 255)
            ->allowEmptyString('position');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('privilege')
            ->maxLength('privilege', 50)
            ->notEmptyString('privilege');

        $validator
            ->scalar('telp')
            ->maxLength('telp', 20)
            ->allowEmptyString('telp');

        $validator
            ->scalar('place_of_birth')
            ->maxLength('place_of_birth', 50)
            ->allowEmptyString('place_of_birth');

        $validator
            ->scalar('business_unit')
            ->maxLength('business_unit', 255)
            ->allowEmptyString('business_unit');

        $validator
            ->date('date_of_birth')
            ->allowEmptyDate('date_of_birth');

        $validator
            ->date('work_date')
            ->allowEmptyDate('work_date');

        $validator
            ->date('resign_date')
            ->allowEmptyDate('resign_date');

        $validator
            ->scalar('gender')
            ->allowEmptyString('gender');

        $validator
            ->scalar('religion')
            ->maxLength('religion', 50)
            ->allowEmptyString('religion');

        $validator
            ->scalar('photo_path')
            ->maxLength('photo_path', 255)
            ->allowEmptyString('photo_path');

        $validator
            ->scalar('tmp_img')
            ->maxLength('tmp_img', 16777215)
            ->allowEmptyString('tmp_img');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 50)
            ->allowEmptyString('bank_name');

        $validator
            ->scalar('rek_name')
            ->maxLength('rek_name', 100)
            ->allowEmptyString('rek_name');

        $validator
            ->scalar('rek_no')
            ->maxLength('rek_no', 20)
            ->allowEmptyString('rek_no');

        $validator
            ->scalar('npwp')
            ->maxLength('npwp', 20)
            ->allowEmptyString('npwp');

        $validator
            ->scalar('bpjs_kesehatan')
            ->maxLength('bpjs_kesehatan', 20)
            ->allowEmptyString('bpjs_kesehatan');

        $validator
            ->scalar('bpjs_kesehatan_status')
            ->allowEmptyString('bpjs_kesehatan_status');

        $validator
            ->date('bpjs_kesehatan_date')
            ->allowEmptyDate('bpjs_kesehatan_date');

        $validator
            ->scalar('bpjs_ketenagakerjaan')
            ->maxLength('bpjs_ketenagakerjaan', 20)
            ->allowEmptyString('bpjs_ketenagakerjaan');

        $validator
            ->scalar('bpjs_ketenagakerjaan_status')
            ->allowEmptyString('bpjs_ketenagakerjaan_status');

        $validator
            ->date('bpjs_ketenagakerjaan_date')
            ->allowEmptyDate('bpjs_ketenagakerjaan_date');

        $validator
            ->scalar('str')
            ->maxLength('str', 255)
            ->allowEmptyString('str');

        $validator
            ->date('str_date')
            ->allowEmptyDate('str_date');

        $validator
            ->scalar('sip')
            ->maxLength('sip', 255)
            ->allowEmptyString('sip');

        $validator
            ->date('sip_date')
            ->allowEmptyDate('sip_date');

        $validator
            ->integer('jml_cuti')
            ->notEmptyString('jml_cuti');

        $validator
            ->scalar('berkas_surat_lamaran')
            ->maxLength('berkas_surat_lamaran', 255)
            ->allowEmptyString('berkas_surat_lamaran');

        $validator
            ->scalar('berkas_cv')
            ->maxLength('berkas_cv', 255)
            ->allowEmptyString('berkas_cv');

        $validator
            ->scalar('berkas_ktp')
            ->maxLength('berkas_ktp', 255)
            ->allowEmptyString('berkas_ktp');

        $validator
            ->scalar('berkas_ijasah')
            ->maxLength('berkas_ijasah', 255)
            ->allowEmptyString('berkas_ijasah');

        $validator
            ->scalar('berkas_kk')
            ->maxLength('berkas_kk', 255)
            ->allowEmptyString('berkas_kk');

        $validator
            ->scalar('berkas_skck')
            ->maxLength('berkas_skck', 255)
            ->allowEmptyString('berkas_skck');

        $validator
            ->scalar('berkas_foto')
            ->maxLength('berkas_foto', 255)
            ->allowEmptyString('berkas_foto');

        $validator
            ->scalar('berkas_surat_dokter')
            ->maxLength('berkas_surat_dokter', 255)
            ->allowEmptyString('berkas_surat_dokter');

        $validator
            ->scalar('berkas_kartu_vaksin_1')
            ->maxLength('berkas_kartu_vaksin_1', 255)
            ->allowEmptyString('berkas_kartu_vaksin_1');

        $validator
            ->scalar('berkas_kartu_vaksin_2')
            ->maxLength('berkas_kartu_vaksin_2', 255)
            ->allowEmptyString('berkas_kartu_vaksin_2');

        $validator
            ->scalar('berkas_kartu_vaksin_3')
            ->maxLength('berkas_kartu_vaksin_3', 255)
            ->allowEmptyString('berkas_kartu_vaksin_3');

        $validator
            ->scalar('berkas_kartu_vaksin_4')
            ->maxLength('berkas_kartu_vaksin_4', 255)
            ->allowEmptyString('berkas_kartu_vaksin_4');

        $validator
            ->scalar('berkas_kontrak_1')
            ->maxLength('berkas_kontrak_1', 255)
            ->allowEmptyString('berkas_kontrak_1');

        $validator
            ->scalar('berkas_kontrak_2')
            ->maxLength('berkas_kontrak_2', 255)
            ->allowEmptyString('berkas_kontrak_2');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->scalar('status')
            ->maxLength('status', 100)
            ->allowEmptyString('status');

        $validator
            ->date('contract_start_date')
            ->allowEmptyDate('contract_start_date');

        $validator
            ->date('contract_end_date')
            ->allowEmptyDate('contract_end_date');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

        $validator
            ->scalar('is_active')
            ->allowEmptyString('is_active');

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
        $rules->add($rules->isUnique(['nip']), ['errorField' => 'nip']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
