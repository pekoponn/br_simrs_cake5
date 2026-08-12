<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccCashes Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\AccCashLinesTable&\Cake\ORM\Association\HasMany $AccCashLines
 *
 * @method \App\Model\Entity\AccCash newEmptyEntity()
 * @method \App\Model\Entity\AccCash newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccCash[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccCash get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccCash findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccCash patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccCash[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccCash|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccCash saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccCash[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccCash[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccCash[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccCash[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccCashesTable extends Table
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

        $this->setTable('acc_cashes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
        ]);
        $this->hasMany('AccCashLines', [
            'foreignKey' => 'acc_cash_id',
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
            ->scalar('number')
            ->maxLength('number', 50)
            ->allowEmptyString('number');

        $validator
            ->scalar('cash_type')
            ->allowEmptyString('cash_type');

        $validator
            ->scalar('penyetor_penerima')
            ->maxLength('penyetor_penerima', 50)
            ->allowEmptyString('penyetor_penerima');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('payment_type')
            ->maxLength('payment_type', 50)
            ->allowEmptyString('payment_type');

        $validator
            ->scalar('no_cek')
            ->maxLength('no_cek', 50)
            ->allowEmptyString('no_cek');

        $validator
            ->date('warkat_date')
            ->allowEmptyDate('warkat_date');

        $validator
            ->integer('balance')
            ->allowEmptyString('balance');

        $validator
            ->decimal('total')
            ->allowEmptyString('total');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('who_create')
            ->maxLength('who_create', 50)
            ->allowEmptyString('who_create');

        $validator
            ->scalar('who_update')
            ->maxLength('who_update', 50)
            ->allowEmptyString('who_update');

        $validator
            ->scalar('who_delete')
            ->maxLength('who_delete', 50)
            ->allowEmptyString('who_delete');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);

        return $rules;
    }
}
