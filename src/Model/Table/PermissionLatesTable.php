<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PermissionLates Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 *
 * @method \App\Model\Entity\PermissionLate newEmptyEntity()
 * @method \App\Model\Entity\PermissionLate newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PermissionLate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PermissionLate get($primaryKey, $options = [])
 * @method \App\Model\Entity\PermissionLate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PermissionLate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PermissionLate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PermissionLate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermissionLate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermissionLate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PermissionLate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PermissionLate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PermissionLate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PermissionLatesTable extends Table
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

        $this->setTable('permission_lates');
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
            'foreignKey' => 'is_knowing',
            'className' => 'Users',
            // 'joinType' => 'INNER',
        ]);

        $this->belongsTo('Menyetujui', [
            'foreignKey' => 'is_approved',
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
            ->scalar('time_in')
            ->maxLength('time_in', 50)
            ->allowEmptyString('time_in');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->scalar('files')
            ->maxLength('files', 255)
            ->allowEmptyFile('files');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('is_approved')
            ->allowEmptyString('is_approved');

        $validator
            ->scalar('status_approve')
            ->allowEmptyString('status_approve');

        $validator
            ->dateTime('approved')
            ->allowEmptyDateTime('approved');

        $validator
            ->scalar('desc_approve')
            ->maxLength('desc_approve', 255)
            ->allowEmptyString('desc_approve');

        $validator
            ->integer('is_knowing')
            ->allowEmptyString('is_knowing');

        $validator
            ->scalar('status_knowing')
            ->allowEmptyString('status_knowing');

        $validator
            ->dateTime('knowing')
            ->allowEmptyDateTime('knowing');

        $validator
            ->scalar('desc_knowing')
            ->maxLength('desc_knowing', 255)
            ->allowEmptyString('desc_knowing');

        $validator
            ->scalar('is_create')
            ->maxLength('is_create', 11)
            ->allowEmptyString('is_create');

        $validator
            ->scalar('is_update')
            ->maxLength('is_update', 11)
            ->allowEmptyString('is_update');

        $validator
            ->scalar('is_delete')
            ->maxLength('is_delete', 11)
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
