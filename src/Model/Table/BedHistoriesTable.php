<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BedHistories Model
 *
 * @property \App\Model\Table\BedsTable&\Cake\ORM\Association\BelongsTo $Beds
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\BelongsTo $Rooms
 *
 * @method \App\Model\Entity\BedHistory newEmptyEntity()
 * @method \App\Model\Entity\BedHistory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BedHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BedHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\BedHistory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BedHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BedHistory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BedHistory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BedHistory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BedHistory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BedHistory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BedHistory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BedHistory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BedHistoriesTable extends Table
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

        $this->setTable('bed_histories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Beds', [
            'foreignKey' => 'bed_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
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
            ->scalar('patient_name')
            ->maxLength('patient_name', 255)
            ->allowEmptyString('patient_name');

        $validator
            ->scalar('registration_no')
            ->maxLength('registration_no', 100)
            ->allowEmptyString('registration_no');

        $validator
            ->date('check_in_date')
            ->allowEmptyDate('check_in_date');

        $validator
            ->date('check_out_date')
            ->allowEmptyDate('check_out_date');

        $validator
            ->boolean('status_before')
            ->allowEmptyString('status_before');

        $validator
            ->boolean('status_after')
            ->allowEmptyString('status_after');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 100)
            ->allowEmptyString('created_by');

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
        $rules->add($rules->existsIn(['bed_id'], 'Beds'), ['errorField' => 'bed_id']);
        $rules->add($rules->existsIn(['room_id'], 'Rooms'), ['errorField' => 'room_id']);

        return $rules;
    }
}
