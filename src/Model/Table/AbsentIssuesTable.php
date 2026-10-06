<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AbsentIssues Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\AbsentIssue newEmptyEntity()
 * @method \App\Model\Entity\AbsentIssue newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AbsentIssue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AbsentIssue get($primaryKey, $options = [])
 * @method \App\Model\Entity\AbsentIssue findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AbsentIssue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AbsentIssue[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AbsentIssue|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AbsentIssue saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AbsentIssue[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AbsentIssue[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AbsentIssue[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AbsentIssue[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AbsentIssuesTable extends Table
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

        $this->setTable('absent_issues');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('IsCreateUser', [
            'className' => 'Users',
            'foreignKey' => 'is_create',
            'propertyName' => 'is_create_user'
        ]);
        $this->belongsTo('IsDoneUser', [
            'className' => 'Users',
            'foreignKey' => 'is_done',
            'propertyName' => 'is_done_user' // Tentukan nama properti relasi
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
            ->scalar('file_1')
            ->maxLength('file_1', 255)
            ->allowEmptyFile('file_1');

        $validator
            ->scalar('file_2')
            ->maxLength('file_2', 255)
            ->allowEmptyFile('file_2');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmptyString('status');

        $validator
            ->integer('is_done')
            ->allowEmptyString('is_done');

        $validator
            ->dateTime('doned')
            ->allowEmptyDateTime('doned');

        $validator
            ->integer('is_create')
            ->notEmptyString('is_create');

        $validator
            ->integer('is_update')
            ->notEmptyString('is_update');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
