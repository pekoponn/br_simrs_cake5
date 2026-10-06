<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LicenseAbsents Model
 *
 * @method \App\Model\Entity\LicenseAbsent newEmptyEntity()
 * @method \App\Model\Entity\LicenseAbsent newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LicenseAbsent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LicenseAbsent get($primaryKey, $options = [])
 * @method \App\Model\Entity\LicenseAbsent findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LicenseAbsent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LicenseAbsent[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LicenseAbsent|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LicenseAbsent saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LicenseAbsent[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LicenseAbsent[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LicenseAbsent[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LicenseAbsent[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LicenseAbsentsTable extends Table
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

        $this->setTable('license_absents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->scalar('files')
            ->maxLength('files', 255)
            ->allowEmptyFile('files');

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
}
