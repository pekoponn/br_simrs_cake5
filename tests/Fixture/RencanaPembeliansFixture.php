<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RencanaPembeliansFixture
 */
class RencanaPembeliansFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'no_perencanaan' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'tgl_perencanaan' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'no_dokumen' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'draft', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'supplier_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'nama_supplier' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'diminta_oleh' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'total_qty_permintaan' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'total_permintaan' => ['type' => 'decimal', 'length' => 14, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uq_no_perencanaan' => ['type' => 'unique', 'columns' => ['no_perencanaan'], 'length' => []],
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
                'no_perencanaan' => 'Lorem ipsum dolor sit amet',
                'tgl_perencanaan' => '2026-07-20',
                'no_dokumen' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'supplier_id' => 1,
                'nama_supplier' => 'Lorem ipsum dolor sit amet',
                'diminta_oleh' => 'Lorem ipsum dolor sit amet',
                'total_qty_permintaan' => 1.5,
                'total_permintaan' => 1.5,
                'created' => '2026-07-20 13:48:49',
                'modified' => '2026-07-20 13:48:49',
            ],
        ];
        parent::init();
    }
}
