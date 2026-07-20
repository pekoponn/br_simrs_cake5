<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MedicineStocksFixture
 */
class MedicineStocksFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'branch_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'medicine_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'last_so_date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Tgl SO terakhir', 'precision' => null],
        'hasil_so' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'adjustment' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'terima' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'keluar' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'saldo_akhir' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'max_stock' => ['type' => 'decimal', 'length' => 12, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'is_valid' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'N', 'collate' => 'latin1_swedish_ci', 'comment' => 'Status validasi stock', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_medicine_stocks_medicine' => ['type' => 'index', 'columns' => ['medicine_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uniq_branch_medicine' => ['type' => 'unique', 'columns' => ['branch_id', 'medicine_id'], 'length' => []],
            'fk_medicine_stocks_medicine' => ['type' => 'foreign', 'columns' => ['medicine_id'], 'references' => ['medicines', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
                'branch_id' => 1,
                'medicine_id' => 1,
                'last_so_date' => '2026-07-20',
                'hasil_so' => 1.5,
                'adjustment' => 1.5,
                'terima' => 1.5,
                'keluar' => 1.5,
                'saldo_akhir' => 1.5,
                'max_stock' => 1.5,
                'is_valid' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-07-20 10:59:56',
                'modified' => '2026-07-20 10:59:56',
            ],
        ];
        parent::init();
    }
}
