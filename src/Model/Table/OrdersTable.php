<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use ArrayObject;

class OrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setDisplayField('no_order');
        $this->setPrimaryKey('id');

        $this->belongsTo('Registrations', ['foreignKey' => 'registration_id']);
        $this->belongsTo('Patients', ['foreignKey' => 'patient_id']);
        $this->belongsTo('Doctors', ['foreignKey' => 'doctor_id']);
        $this->belongsTo('Users', ['foreignKey' => 'created_by']);
        $this->belongsTo('OrderStatuses', ['foreignKey' => 'status_id']);

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

        $this->hasMany('OrderSupports', [
            'foreignKey' => 'order_id',
            'dependent' => true,
        ]);

        $this->hasMany('OrderSurgeries', [
            'foreignKey' => 'order_id',
            'dependent' => true,
        ]);

        $this->hasMany('OrderMcus', [
            'foreignKey' => 'order_id',
            'dependent' => true,
        ]);

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('no_order')
            ->maxLength('no_order', 30)
            ->notEmptyString('no_order');

        $validator
            ->integer('registration_id')
            ->notEmptyString('registration_id');

        $validator
            ->integer('patient_id')
            ->notEmptyString('patient_id');

        $validator
            ->dateTime('tgl_order')
            ->notEmptyDateTime('tgl_order');

        return $validator;
    }

    public function beforeSave(EventInterface $event, $entity, ArrayObject $options): void
    {
        if ($entity->isNew() && empty($entity->no_order)) {
            $entity->no_order = $this->generateNoOrder();
        }
    }

    private function generateNoOrder(): string
    {
        $prefix = 'ORD/' . date('Y') . '/' . date('m') . '/';

        $last = $this->find()
            ->where(['no_order LIKE' => $prefix . '%'])
            ->orderBy(['no_order' => 'DESC'])
            ->first();

        $seq = $last ? (int)substr($last->no_order, -5) + 1 : 1;

        return $prefix . str_pad((string)$seq, 5, '0', STR_PAD_LEFT);
    }

    public function getHistoryByPatient(int $patientId): array
    {
        return $this->find()
            ->contain([
                'OrderStatuses',
                'Registrations',
                'OrderPrescriptions',
                'OrderLaboratories',
                'OrderRadiologies',
                'OrderSupports',
                'OrderSurgeries',
                'OrderMcus',
            ])
            ->where(['Orders.patient_id' => $patientId])
            ->orderBy(['Orders.tgl_order' => 'DESC'])
            ->toArray();
    }
}
