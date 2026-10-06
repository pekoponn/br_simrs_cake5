<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmergencyActions Model
 *
 * @property \App\Model\Table\RegistrationsTable&\Cake\ORM\Association\BelongsTo $Registrations
 *
 * @method \App\Model\Entity\EmergencyAction newEmptyEntity()
 * @method \App\Model\Entity\EmergencyAction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyAction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyAction get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmergencyAction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EmergencyAction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyAction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmergencyAction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmergencyAction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmergencyAction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyAction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyAction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmergencyAction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmergencyActionsTable extends Table
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

        $this->setTable('emergency_actions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('action_code')
            ->maxLength('action_code', 50)
            ->allowEmptyString('action_code');

        $validator
            ->scalar('action_name')
            ->maxLength('action_name', 255)
            ->requirePresence('action_name', 'create')
            ->notEmptyString('action_name');

        $validator
            ->scalar('action_category')
            ->maxLength('action_category', 30)
            ->notEmptyString('action_category');

        $validator
            ->integer('quantity')
            ->notEmptyString('quantity');

        $validator
            ->decimal('unit_price')
            ->notEmptyString('unit_price');

        $validator
            ->decimal('total_price')
            ->notEmptyString('total_price');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

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
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'), ['errorField' => 'registration_id']);

        return $rules;
    }
}