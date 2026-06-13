<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use RuntimeException;

/**
 * Orders Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\DoctorsTable&\Cake\ORM\Association\BelongsTo $Doctors
 * @property \App\Model\Table\OrderStatusesTable&\Cake\ORM\Association\BelongsTo $OrderStatuses
 * @property \App\Model\Table\OrderPrescriptionsTable&\Cake\ORM\Association\HasMany $OrderPrescriptions
 *
 * @method \App\Model\Entity\Order newEmptyEntity()
 * @method \App\Model\Entity\Order newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
{
    private const ORDER_NUMBER_LOCK = 'simrs_orders_number';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
        ]);
        $this->belongsTo('OrderStatuses', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('OrderPrescriptions', [
            'foreignKey' => 'order_id',
            'dependent' => true,
        ]);
        $this->hasMany('OrderLaboratories', [
            'foreignKey' => 'order_id',
            'dependent' => true,
        ]);
        $this->hasMany('OrderRadiologies', [
            'foreignKey' => 'order_id',
            'dependent' => true,
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
            ->scalar('no_order')
            ->maxLength('no_order', 30)
            ->requirePresence('no_order', 'create')
            ->notEmptyString('no_order')
            ->add('no_order', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->dateTime('tgl_order')
            ->requirePresence('tgl_order', 'create')
            ->notEmptyDateTime('tgl_order');

        $validator
            ->scalar('lokasi_depo')
            ->maxLength('lokasi_depo', 50)
            ->allowEmptyString('lokasi_depo');

        $validator
            ->scalar('catatan')
            ->allowEmptyString('catatan');

        $validator
            ->scalar('laboratory_note')
            ->allowEmptyString('laboratory_note');

        $validator
            ->scalar('radiology_note')
            ->allowEmptyString('radiology_note');

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
        $rules->add($rules->isUnique(['no_order']), ['errorField' => 'no_order']);
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['doctor_id'], 'Doctors'), ['errorField' => 'doctor_id']);
        $rules->add($rules->existsIn(['status_id'], 'OrderStatuses'), ['errorField' => 'status_id']);

        return $rules;
    }

    public function acquireOrderNumberLock(int $timeoutSeconds = 10): void
    {
        $row = $this->getConnection()
            ->execute(
                'SELECT GET_LOCK(:lock_name, :timeout_seconds) AS acquired',
                [
                    'lock_name' => self::ORDER_NUMBER_LOCK,
                    'timeout_seconds' => $timeoutSeconds,
                ]
            )
            ->fetch('assoc');

        if ((int)($row['acquired'] ?? 0) !== 1) {
            throw new RuntimeException('Tidak dapat memperoleh lock untuk nomor order.');
        }
    }

    public function releaseOrderNumberLock(): void
    {
        $this->getConnection()->execute(
            'SELECT RELEASE_LOCK(:lock_name)',
            ['lock_name' => self::ORDER_NUMBER_LOCK]
        );
    }

    public function generateOrderNumber(): string
    {
        $prefix = 'ORD/' . date('Y') . '/' . date('m') . '/';
        $last = $this->find()
            ->select(['no_order'])
            ->where(['no_order LIKE' => $prefix . '%'])
            ->order(['no_order' => 'DESC'])
            ->first();

        $seq = $last ? (int)substr($last->no_order, -5) + 1 : 1;

        return $prefix . str_pad((string)$seq, 5, '0', STR_PAD_LEFT);
    }

    // History order by patient - untuk panel kiri di form
    public function getHistoryByPatient(int $patientId): array
    {
        return $this->find()
            ->contain(['OrderStatuses', 'Registrations'])
            ->where(['Orders.patient_id' => $patientId])
            ->order(['Orders.tgl_order' => 'DESC'])
            ->toArray();
    }
}
