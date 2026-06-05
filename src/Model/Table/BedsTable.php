<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Beds Model
 *
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\BelongsTo $Rooms
 */
class BedsTable extends Table
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

        // TABLE
        $this->setTable('beds');

        // DISPLAY FIELD
        $this->setDisplayField('name');

        // PRIMARY KEY
        $this->setPrimaryKey('id');

        // TIMESTAMP
        $this->addBehavior('Timestamp');

        /**
         * RELATION ROOMS
         */
        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
            'joinType' => 'INNER',
        ]);

        if ($this->getSchema()->hasColumn('patient_id')) {
            $this->belongsTo('Patients', [
                'foreignKey' => 'patient_id',
                'joinType' => 'LEFT',
            ]);
        }

        if ($this->tableExists('bed_histories')) {
            $this->hasMany('BedHistories', [
                'foreignKey' => 'bed_id',
            ]);
        }
    }

    /**
     * Validation rules
     *
     * @param \Cake\Validation\Validator $validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        /**
         * ID
         */
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        /**
         * CODE BED
         */
        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->requirePresence('code', 'create')
            ->notEmptyString(
                'code',
                'Code Bed tidak boleh kosong'
            );

        /**
         * ROOM
         */
        $validator
            ->integer('room_id')
            ->requirePresence('room_id', 'create')
            ->notEmptyString(
                'room_id',
                'Room wajib dipilih'
            );

        /**
         * BED NUMBER
         */
        $validator
            ->scalar('bed_no')
            ->maxLength('bed_no', 50)
            ->requirePresence('bed_no', 'create')
            ->notEmptyString(
                'bed_no',
                'Nomor TT wajib diisi'
            );

        /**
         * BED NAME
         */
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString(
                'name',
                'Nama Bed wajib diisi'
            );

        /**
         * CLASS
         */
        $validator
            ->scalar('class_name')
            ->maxLength('class_name', 100)
            ->requirePresence('class_name', 'create')
            ->notEmptyString(
                'class_name',
                'Class wajib dipilih'
            );

        /**
         * STATUS BED
         */
        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmptyString(
                'status',
                'Status Bed wajib dipilih'
            );

        /**
         * ACTIVE STATUS
         */
        $validator
            ->scalar('is_active')
            ->maxLength('is_active', 1)
            ->requirePresence('is_active', 'create')
            ->notEmptyString(
                'is_active',
                'Status Active wajib dipilih'
            )
            ->inList(
                'is_active',
                ['Y', 'N'],
                'Status Active tidak valid'
            );

        return $validator;
    }

    /**
     * Build Rules
     *
     * @param \Cake\ORM\RulesChecker $rules
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        /**
         * CODE UNIQUE
         */
        $rules->add(
            $rules->isUnique(['code']),
            [
                'errorField' => 'code',
                'message' => 'Code Bed sudah digunakan'
            ]
        );

        /**
         * ROOM EXIST
         */
        $rules->add(
            $rules->existsIn(['room_id'], 'Rooms'),
            [
                'errorField' => 'room_id',
                'message' => 'Room tidak ditemukan'
            ]
        );

        /**
         * BED NUMBER TIDAK BOLEH SAMA
         * DALAM ROOM YANG SAMA
         */
        $rules->add(function ($entity, $options) {

            $query = $this->find()
                ->where([
                    'room_id' => $entity->room_id,
                    'bed_no' => $entity->bed_no,
                ]);

            /**
             * JIKA EDIT DATA
             */
            if (!empty($entity->id)) {

                $query->where([
                    'id !=' => $entity->id
                ]);
            }

            return $query->count() === 0;
        }, [
            'errorField' => 'bed_no',
            'message' =>
            'Nomor TT sudah digunakan pada room ini'
        ]);

        return $rules;
    }

    /**
     * STATUS BED
     *
     * @return array
     */
    public function getStatusList(): array
    {
        return [
            0 => 'Tersedia',
            1 => 'Terisi',
            2 => 'Dibersihkan',
            3 => 'Maintenance',
        ];
    }

    public function getStatusLabel(): array
    {
        return [
            0 => '<span class="label label-success">Tersedia</span>',
            1 => '<span class="label label-danger">Terisi</span>',
            2 => '<span class="label label-warning">Dibersihkan</span>',
            3 => '<span class="label label-default">Maintenance</span>',
        ];
    }

    /**
     * STATUS ACTIVE
     *
     * @return array
     */
    public function getActiveList(): array
    {
        return [
            'Y' => 'Active',
            'N' => 'Non Active',
        ];
    }

    /**
     * CLASS LIST
     *
     * @return array
     */
    public function getClassList(): array
    {
        return [
            'VIP' => 'VIP',
            'VVIP' => 'VVIP',
            'Kelas 1' => 'Kelas 1',
            'Kelas 2' => 'Kelas 2',
            'Kelas 3' => 'Kelas 3',
            'ICU' => 'ICU',
            'NICU' => 'NICU',
            'PICU' => 'PICU',
            'HCU' => 'HCU',
            'Isolasi' => 'Isolasi',
        ];
    }

    /**
     * SEARCH FILTER
     *
     * @param string|null $key
     * @return \Cake\ORM\Query
     */
    public function findSearch(Query $query, array $options)
    {
        $key = $options['key'] ?? null;

        if (!empty($key)) {

            $query->contain(['Rooms']);

            $query->where([
                'OR' => [

                    'Beds.code LIKE' =>
                    '%' . $key . '%',

                    'Beds.bed_no LIKE' =>
                    '%' . $key . '%',

                    'Beds.name LIKE' =>
                    '%' . $key . '%',

                    'Beds.class_name LIKE' =>
                    '%' . $key . '%',

                    'Rooms.room_name LIKE' =>
                    '%' . $key . '%',
                ]
            ]);
        }

        return $query;
    }

    private function tableExists(string $tableName): bool
    {
        try {
            return in_array($tableName, ConnectionManager::get('default')->getSchemaCollection()->listTables(), true);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
