<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WorkOrders Model
 *
 * @property \App\Model\Table\WorkOrderLinesTable&\Cake\ORM\Association\HasMany $WorkOrderLines
 *
 * @method \App\Model\Entity\WorkOrder newEmptyEntity()
 * @method \App\Model\Entity\WorkOrder newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\WorkOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WorkOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\WorkOrder findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\WorkOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WorkOrder[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\WorkOrder|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkOrder saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkOrder[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkOrder[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkOrder[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkOrder[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WorkOrdersTable extends Table
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

        $this->setTable('work_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('WorkOrderLines', [
            'foreignKey' => 'work_order_id',
        ]);
        $this->belongsTo('ApproveUsers', [
            'className' => 'Users',
            'foreignKey' => 'is_approve',
        ]);
        $this->belongsTo('CreateUsers', [
            'className' => 'Users',
            'foreignKey' => 'is_create',
        ]);
        $this->belongsTo('CancelUsers', [
            'className' => 'Users',
            'foreignKey' => 'is_cancel',
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
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmptyString('code');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('is_approve')
            ->notEmptyString('is_approve');

        $validator
            ->dateTime('approved')
            ->allowEmptyDateTime('approved');

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
