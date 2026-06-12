<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MasterTindakanFixture
 */
class MasterTindakanFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'master_tindakan';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'kode' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Kode unik tindakan', 'precision' => null],
        'nama' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Nama tindakan', 'precision' => null],
        'kategori' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'Tindakan Medis', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'harga' => ['type' => 'decimal', 'length' => 12, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'satuan' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => 'Kali', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'keterangan' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'is_active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'idx_kategori' => ['type' => 'index', 'columns' => ['kategori'], 'length' => []],
            'idx_is_active' => ['type' => 'index', 'columns' => ['is_active'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uq_kode' => ['type' => 'unique', 'columns' => ['kode'], 'length' => []],
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
                'kode' => 'Lorem ipsum dolor ',
                'nama' => 'Lorem ipsum dolor sit amet',
                'kategori' => 'Lorem ipsum dolor sit amet',
                'harga' => 1.5,
                'satuan' => 'Lorem ipsum dolor sit amet',
                'keterangan' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_active' => 1,
                'created' => '2026-06-09 08:31:08',
                'modified' => '2026-06-09 08:31:08',
            ],
        ];
        parent::init();
    }
}
