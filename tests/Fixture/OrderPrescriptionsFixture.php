<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderPrescriptionsFixture
 */
class OrderPrescriptionsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'order_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK ke orders', 'precision' => null, 'autoIncrement' => null],
        'medicine_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK ke tabel medicines', 'precision' => null, 'autoIncrement' => null],
        'medicine_unit' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'is_kronis' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '1=kronis, 0=akut', 'precision' => null],
        'jml_per_hari' => ['type' => 'decimal', 'length' => 8, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => 'jumlah obat per hari'],
        'qty_min' => ['type' => 'decimal', 'length' => 8, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => 'qty minimum'],
        'jml_hari' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => 'jumlah hari pemakaian', 'precision' => null, 'autoIncrement' => null],
        'qty_satuan' => ['type' => 'decimal', 'length' => 8, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => 'qty per satuan'],
        'aturan_pakai' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'ex: 3x1 sesudah makan', 'precision' => null],
        'harga' => ['type' => 'decimal', 'length' => 12, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'total_harga' => ['type' => 'decimal', 'length' => 12, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'keterangan' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'idx_op_order' => ['type' => 'index', 'columns' => ['order_id'], 'length' => []],
            'idx_op_medicine' => ['type' => 'index', 'columns' => ['medicine_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'order_prescriptions_ibfk_1' => ['type' => 'foreign', 'columns' => ['order_id'], 'references' => ['orders', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'order_id' => 1,
                'medicine_id' => 1,
                'medicine_unit' => 'TABLET',
                'is_kronis' => 1,
                'jml_per_hari' => 1.5,
                'qty_min' => 1.5,
                'jml_hari' => 1,
                'qty_satuan' => 1.5,
                'aturan_pakai' => 'Lorem ipsum dolor sit amet',
                'harga' => 1.5,
                'total_harga' => 1.5,
                'keterangan' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-06-11 09:51:54',
                'modified' => '2026-06-11 09:51:54',
            ],
        ];
        parent::init();
    }
}
