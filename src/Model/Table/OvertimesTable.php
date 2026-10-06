<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Overtimes Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\WorkOrdersTable&\Cake\ORM\Association\BelongsTo $WorkOrders
 *
 * @method \App\Model\Entity\Overtime newEmptyEntity()
 * @method \App\Model\Entity\Overtime newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Overtime[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Overtime get($primaryKey, $options = [])
 * @method \App\Model\Entity\Overtime findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Overtime patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Overtime[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Overtime|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Overtime saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Overtime[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Overtime[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Overtime[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Overtime[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OvertimesTable extends Table
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

        $this->setTable('overtimes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('WorkOrders', [
            'foreignKey' => 'work_order_id',
            'joinType' => 'INNER',
        ]);
         $this->belongsTo('Users', [
            'foreignKey' => 'is_create',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Mengetahui', [
            'foreignKey' => 'knowing',
            'className' => 'Users',
            // 'joinType' => 'INNER',
        ]);

        $this->belongsTo('Menyetujui', [
            'foreignKey' => 'approved',
            'className' => 'Users',
            // 'joinType' => 'INNER',
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
            ->maxLength('code', 100)
            ->notEmptyString('code');

        $validator
            ->scalar('devision')
            ->maxLength('devision', 50)
            ->allowEmptyString('devision');

        $validator
            ->scalar('position')
            ->maxLength('position', 50)
            ->allowEmptyString('position');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('time_from')
            ->maxLength('time_from', 50)
            ->allowEmptyString('time_from');

        $validator
            ->scalar('time_end')
            ->maxLength('time_end', 50)
            ->allowEmptyString('time_end');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('knowing_description')
            ->allowEmptyString('knowing_description');

        $validator
            ->scalar('approved_description')
            ->allowEmptyString('approved_description');

        $validator
            ->integer('applicant')
            ->allowEmptyString('applicant');

        $validator
            ->integer('approved')
            ->allowEmptyString('approved');

        $validator
            ->scalar('status_approve')
            ->allowEmptyString('status_approve');

        $validator
            ->dateTime('approved_date')
            ->allowEmptyDateTime('approved_date');

        $validator
            ->integer('knowing')
            ->allowEmptyString('knowing');

        $validator
            ->scalar('status_knowing')
            ->allowEmptyString('status_knowing');

        $validator
            ->dateTime('knowing_date')
            ->allowEmptyDateTime('knowing_date');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 50)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 50)
            ->allowEmptyString('is_update');

        $validator
            ->scalar('is_delete')
            ->maxLength('is_delete', 50)
            ->allowEmptyString('is_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('is_log')
            ->allowEmptyString('is_log');

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
        $rules->add($rules->existsIn(['branch_id'], 'Branches'), ['errorField' => 'branch_id']);
        $rules->add($rules->existsIn(['work_order_id'], 'WorkOrders'), ['errorField' => 'work_order_id']);

        return $rules;
    }
}
