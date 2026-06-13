<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 */
class OrdersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'no_order' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'generate otomatis, ex: ORD/2026/06/00001', 'precision' => null],
        'registration_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK ke tabel registrations', 'precision' => null, 'autoIncrement' => null],
        'patient_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK ke tabel patients', 'precision' => null, 'autoIncrement' => null],
        'doctor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK ke tabel doctors', 'precision' => null, 'autoIncrement' => null],
        'created_by' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK ke tabel users', 'precision' => null, 'autoIncrement' => null],
        'status_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => 'FK ke order_statuses', 'precision' => null, 'autoIncrement' => null],
        'tgl_order' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => 'tanggal & jam order dibuat'],
        'lokasi_depo' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'ex: FARMASI 2 RAJAL DEPO', 'precision' => null],
        'catatan' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'status_id' => ['type' => 'index', 'columns' => ['status_id'], 'length' => []],
            'idx_orders_registration' => ['type' => 'index', 'columns' => ['registration_id'], 'length' => []],
            'idx_orders_patient' => ['type' => 'index', 'columns' => ['patient_id'], 'length' => []],
            'idx_orders_tgl' => ['type' => 'index', 'columns' => ['tgl_order'], 'length' => []],
            'idx_orders_no' => ['type' => 'index', 'columns' => ['no_order'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'no_order' => ['type' => 'unique', 'columns' => ['no_order'], 'length' => []],
            'orders_ibfk_1' => ['type' => 'foreign', 'columns' => ['status_id'], 'references' => ['order_statuses', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'no_order' => 'Lorem ipsum dolor sit amet',
                'registration_id' => 1,
                'patient_id' => 1,
                'doctor_id' => 1,
                'created_by' => 1,
                'status_id' => 1,
                'tgl_order' => '2026-06-11 09:52:22',
                'lokasi_depo' => 'Lorem ipsum dolor sit amet',
                'catatan' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-06-11 09:52:22',
                'modified' => '2026-06-11 09:52:22',
            ],
        ];
        parent::init();
    }
}
