<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payrolls Model
 *
 * @property \App\Model\Table\HrgaEmployeesTable&\Cake\ORM\Association\BelongsTo $HrgaEmployees
 * @property \App\Model\Table\HrgaAttendancesTable&\Cake\ORM\Association\BelongsTo $HrgaAttendances
 *
 * @method \App\Model\Entity\Payroll newEmptyEntity()
 * @method \App\Model\Entity\Payroll newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Payroll[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payroll get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payroll findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Payroll patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payroll[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payroll|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payroll saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payroll[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payroll[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payroll[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payroll[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PayrollsTable extends Table
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

        $this->setTable('payrolls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('HrgaEmployees', [
            'foreignKey' => 'hrga_employee_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('HrgaAttendances', [
            'foreignKey' => 'hrga_attendance_id',
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
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->decimal('gaji_pokok')
            ->notEmptyString('gaji_pokok');

        $validator
            ->decimal('tunjangan_harian')
            ->notEmptyString('tunjangan_harian');

        $validator
            ->decimal('tunjangan_jabatan')
            ->notEmptyString('tunjangan_jabatan');

        $validator
            ->decimal('tunjangan_makan')
            ->notEmptyString('tunjangan_makan');

        $validator
            ->decimal('tunjangan_produktifitas')
            ->notEmptyString('tunjangan_produktifitas');

        $validator
            ->decimal('tunjangan_struktural')
            ->notEmptyString('tunjangan_struktural');

        $validator
            ->decimal('lembur')
            ->notEmptyString('lembur');

        $validator
            ->decimal('komisi')
            ->notEmptyString('komisi');

        $validator
            ->decimal('thr')
            ->notEmptyString('thr');

        $validator
            ->decimal('bpjs_kesehatan')
            ->notEmptyString('bpjs_kesehatan');

        $validator
            ->decimal('bpjs_ketenagakerjaan')
            ->notEmptyString('bpjs_ketenagakerjaan');

        $validator
            ->decimal('bpjs_pensiun')
            ->notEmptyString('bpjs_pensiun');

        $validator
            ->decimal('lain_lain')
            ->notEmptyString('lain_lain');

        $validator
            ->decimal('bpjs_medical')
            ->notEmptyString('bpjs_medical');

        $validator
            ->decimal('bpjs_naker')
            ->notEmptyString('bpjs_naker');

        $validator
            ->decimal('bpjs_pension')
            ->notEmptyString('bpjs_pension');

        $validator
            ->decimal('bpjs_ditanggung_perusahaan')
            ->notEmptyString('bpjs_ditanggung_perusahaan');

        $validator
            ->decimal('potongan_keterlambatan')
            ->notEmptyString('potongan_keterlambatan');

        $validator
            ->decimal('pph_21')
            ->notEmptyString('pph_21');

        $validator
            ->decimal('tabungan_pph_21')
            ->notEmptyString('tabungan_pph_21');

        $validator
            ->integer('qty')
            ->notEmptyString('qty');

        $validator
            ->integer('qty_lateness')
            ->notEmptyString('qty_lateness');

        $validator
            ->integer('qty_overtime')
            ->notEmptyString('qty_overtime');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->decimal('jml_pinjaman')
            ->notEmptyString('jml_pinjaman');

        $validator
            ->decimal('bonus')
            ->notEmptyString('bonus');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['hrga_employee_id'], 'HrgaEmployees'), ['errorField' => 'hrga_employee_id']);
        $rules->add($rules->existsIn(['hrga_attendance_id'], 'HrgaAttendances'), ['errorField' => 'hrga_attendance_id']);

        return $rules;
    }
}
