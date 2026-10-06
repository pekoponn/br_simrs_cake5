<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Assignments Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 *
 * @method \App\Model\Entity\Assignment newEmptyEntity()
 * @method \App\Model\Entity\Assignment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Assignment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Assignment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Assignment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Assignment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Assignment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Assignment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Assignment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Assignment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Assignment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Assignment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Assignment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssignmentsTable extends Table
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

        $this->setTable('assignments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('IsCreateUser', [
            'className' => 'Users',
            'foreignKey' => 'is_create',
            'propertyName' => 'is_create_user' // Tentukan nama properti relasi
        ]);
        $this->belongsTo('IsKnowingUser', [
            'className' => 'Users',
            'foreignKey' => 'is_knowing',
            'propertyName' => 'is_knowing_user' // Tentukan nama properti relasi
        ]);
        $this->belongsTo('IsApproveUser', [
            'className' => 'Users',
            'foreignKey' => 'is_approve',
            'propertyName' => 'is_approve_user' // Tentukan nama properti relasi
        ]);
        // $this->belongsTo('IsCancelUser', [
        //     'className' => 'Users',
        //     'foreignKey' => 'is_cancel',
        //     'propertyName' => 'is_cancel_user' // Tentukan nama properti relasi
        // ]);
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
            ->integer('is_approve')
            ->allowEmptyString('is_approve');

        $validator
            ->scalar('status_approve')
            ->allowEmptyString('status_approve');

        $validator
            ->dateTime('approved')
            ->allowEmptyDateTime('approved');

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
