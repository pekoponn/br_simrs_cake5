<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvoiceDetailsFixture
 */
class InvoiceDetailsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'invoice_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'medicine_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'kode_barang' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'nama_barang' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'qty' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'satuan' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'harga' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'discount_percent' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'discount_rp' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'tax' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'total_harga' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'tgl_kadaluarsa' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'po_no' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'histori' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'nilai_diskon' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'idx_invoice_id' => ['type' => 'index', 'columns' => ['invoice_id'], 'length' => []],
            'idx_medicine_id' => ['type' => 'index', 'columns' => ['medicine_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_invd_invoice' => ['type' => 'foreign', 'columns' => ['invoice_id'], 'references' => ['invoices', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
                'invoice_id' => 1,
                'medicine_id' => 1,
                'kode_barang' => 'Lorem ipsum dolor sit amet',
                'nama_barang' => 'Lorem ipsum dolor sit amet',
                'qty' => 1.5,
                'satuan' => 'Lorem ipsum dolor sit amet',
                'harga' => 1.5,
                'discount_percent' => 1.5,
                'discount_rp' => 1.5,
                'tax' => 1.5,
                'total_harga' => 1.5,
                'tgl_kadaluarsa' => '2026-07-20',
                'po_no' => 'Lorem ipsum dolor sit amet',
                'histori' => 'Lorem ipsum dolor sit amet',
                'nilai_diskon' => 1.5,
                'created' => '2026-07-20 13:47:44',
                'modified' => '2026-07-20 13:47:44',
            ],
        ];
        parent::init();
    }
}
