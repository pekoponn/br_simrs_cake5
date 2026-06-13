<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutpatientActions Model
 *
 * @property \App\Model\Table\OutpatientVisitsTable&\Cake\ORM\Association\BelongsTo $OutpatientVisits
 * @property \App\Model\Table\MasterTindakanTable&\Cake\ORM\Association\BelongsTo $MasterTindakan
 *
 * @method \App\Model\Entity\OutpatientAction newEmptyEntity()
 * @method \App\Model\Entity\OutpatientAction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientAction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientAction get($primaryKey, $options = [])
 * @method \App\Model\Entity\OutpatientAction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OutpatientAction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientAction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OutpatientAction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientAction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OutpatientAction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientAction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientAction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OutpatientAction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutpatientActionsTable extends Table
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

        $this->setTable('outpatient_actions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OutpatientVisits', [
            'foreignKey' => 'outpatient_visit_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('MasterTindakan', [
            'foreignKey' => 'master_tindakan_id',
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
            ->maxLength('action_code', 20)
            ->allowEmptyString('action_code');

        $validator
            ->scalar('action_name')
            ->maxLength('action_name', 200)
            ->requirePresence('action_name', 'create')
            ->notEmptyString('action_name');

        $validator
            ->scalar('action_category')
            ->maxLength('action_category', 50)
            ->allowEmptyString('action_category');

        $validator
            ->integer('quantity')
            ->notEmptyString('quantity');

        $validator
            ->decimal('unit_price')
            ->allowEmptyString('unit_price');

        $validator
            ->decimal('total_price')
            ->allowEmptyString('total_price');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('performed_by')
            ->maxLength('performed_by', 100)
            ->allowEmptyString('performed_by');

        $validator
            ->dateTime('performed_at')
            ->allowEmptyDateTime('performed_at');

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
        $rules->add($rules->existsIn(['outpatient_visit_id'], 'OutpatientVisits'), ['errorField' => 'outpatient_visit_id']);
        $rules->add($rules->existsIn(['master_tindakan_id'], 'MasterTindakan'), ['errorField' => 'master_tindakan_id']);

        return $rules;
    }
}
