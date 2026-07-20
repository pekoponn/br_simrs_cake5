<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RencanaPembelianDetailsFixture
 */
class RencanaPembelianDetailsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'rencana_pembelian_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'medicine_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'kode_barang' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'nama_barang' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'qty' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'harga' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'satuan' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'total' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'total_approv' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'is_obat' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'Y', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'keterangan' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'idx_rencana_pembelian_id' => ['type' => 'index', 'columns' => ['rencana_pembelian_id'], 'length' => []],
            'idx_medicine_id' => ['type' => 'index', 'columns' => ['medicine_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_rpd_rencana' => ['type' => 'foreign', 'columns' => ['rencana_pembelian_id'], 'references' => ['rencana_pembelians', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_0900_ai_ci'
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
                'rencana_pembelian_id' => 1,
                'medicine_id' => 1,
                'kode_barang' => 'Lorem ipsum dolor sit amet',
                'nama_barang' => 'Lorem ipsum dolor sit amet',
                'qty' => 1.5,
                'harga' => 1.5,
                'satuan' => 'Lorem ipsum dolor sit amet',
                'total' => 1.5,
                'total_approv' => 1.5,
                'is_obat' => 'Lorem ipsum dolor sit amet',
                'keterangan' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-07-20 13:49:33',
                'modified' => '2026-07-20 13:49:33',
            ],
        ];
        parent::init();
    }
}
