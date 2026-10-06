<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Leaves Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 *
 * @method \App\Model\Entity\Leave newEmptyEntity()
 * @method \App\Model\Entity\Leave newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Leave[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Leave get($primaryKey, $options = [])
 * @method \App\Model\Entity\Leave findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Leave patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Leave[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Leave|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Leave saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Leave[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Leave[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Leave[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Leave[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeavesTable extends Table
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

        $this->setTable('leaves');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
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
            ->date('date_from')
            ->allowEmptyDate('date_from');

        $validator
            ->date('date_end')
            ->allowEmptyDate('date_end');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->integer('leave_days')
            ->allowEmptyString('leave_days');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('applicant')
            ->allowEmptyString('applicant');

        $validator
            ->integer('approved')
            ->allowEmptyString('approved');

        $validator
            ->dateTime('approved_date')
            ->allowEmptyDateTime('approved_date');

        $validator
            ->integer('knowing')
            ->allowEmptyString('knowing');

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

        return $rules;
    }
}
