<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvoicesFixture
 */
class InvoicesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'bapb_no' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'nama_supplier' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'supplier_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tgl_terima' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'no_faktur' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'sj_no' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'tgl_tukar_faktur' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'kurs' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => 'IDR', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'rate' => ['type' => 'decimal', 'length' => 14, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => '1.0000', 'comment' => ''],
        'pembayaran' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'cash', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'tgl_jatuh_tempo' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'diterima_lokasi_gudang' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'materai' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'tanpa', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'discount_percent' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'discount_rp' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'ongkos_kirim' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'total' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'grand_total' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'catatan' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uq_bapb_no' => ['type' => 'unique', 'columns' => ['bapb_no'], 'length' => []],
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
                'bapb_no' => 'Lorem ipsum dolor sit amet',
                'nama_supplier' => 'Lorem ipsum dolor sit amet',
                'supplier_id' => 1,
                'tgl_terima' => '2026-07-20',
                'no_faktur' => 'Lorem ipsum dolor sit amet',
                'sj_no' => 'Lorem ipsum dolor sit amet',
                'tgl_tukar_faktur' => '2026-07-20',
                'kurs' => 'Lorem ip',
                'rate' => 1.5,
                'pembayaran' => 'Lorem ipsum dolor sit amet',
                'tgl_jatuh_tempo' => '2026-07-20',
                'diterima_lokasi_gudang' => 'Lorem ipsum dolor sit amet',
                'materai' => 'Lorem ipsum dolor sit amet',
                'discount_percent' => 1.5,
                'discount_rp' => 1.5,
                'ongkos_kirim' => 1.5,
                'total' => 1.5,
                'grand_total' => 1.5,
                'catatan' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-07-20 13:47:39',
                'modified' => '2026-07-20 13:47:39',
            ],
        ];
        parent::init();
    }
}
