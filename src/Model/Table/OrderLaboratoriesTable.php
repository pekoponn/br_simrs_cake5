<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrderLaboratoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('order_laboratories');
        $this->setDisplayField('examination_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('MasterTindakan', [
            'foreignKey' => 'master_tindakan_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('order_id')
            ->requirePresence('order_id', 'create')
            ->notEmptyString('order_id');

        $validator
            ->integer('master_tindakan_id')
            ->allowEmptyString('master_tindakan_id');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('examination_name')
            ->maxLength('examination_name', 255)
            ->requirePresence('examination_name', 'create')
            ->notEmptyString('examination_name');

        $validator
            ->decimal('price')
            ->notEmptyString('price');

        $validator
            ->scalar('approval_note')
            ->maxLength('approval_note', 255)
            ->allowEmptyString('approval_note');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);
        $rules->add(
            $rules->existsIn(['master_tindakan_id'], 'MasterTindakan'),
            ['errorField' => 'master_tindakan_id']
        );

        return $rules;
    }
}
