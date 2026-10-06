<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Absences Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Absence newEmptyEntity()
 * @method \App\Model\Entity\Absence newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Absence[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Absence get($primaryKey, $options = [])
 * @method \App\Model\Entity\Absence findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Absence patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Absence[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Absence|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Absence saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Absence[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Absence[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Absence[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Absence[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AbsencesTable extends Table
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

        $this->setTable('absences');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('LicenseEarlyLeaves', [
            // 'foreignKey' => 'user_id',
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
            ->scalar('latitude')
            ->maxLength('latitude', 100)
            ->allowEmptyString('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 100)
            ->allowEmptyString('longitude');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmptyString('location');

        $validator
            ->scalar('expression')
            ->allowEmptyString('expression');

        $validator
            ->scalar('inout_mode')
            ->notEmptyString('inout_mode');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('time_in')
            ->maxLength('time_in', 11)
            ->allowEmptyString('time_in');

        $validator
            ->scalar('time_out')
            ->maxLength('time_out', 11)
            ->allowEmptyString('time_out');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('device')
            ->maxLength('device', 255)
            ->allowEmptyString('device');

        $validator
            ->scalar('browser_type')
            ->maxLength('browser_type', 255)
            ->allowEmptyString('browser_type');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}

class AniTable extends Table
{
    public static function defaultConnectionName(): string
    {
        return 'db_ani';
    }
}

// Untuk table yang menggunakan database app
class AppTable extends Table
{
    public static function defaultConnectionName(): string
    {
        return 'app';
    }
}
