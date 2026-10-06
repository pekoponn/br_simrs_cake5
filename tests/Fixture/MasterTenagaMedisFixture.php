<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MasterTenagaMedisFixture
 */
class MasterTenagaMedisFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'kode' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Kode pegawai, contoh: PWR0000101, PWT-00025, DRT-028', 'precision' => null],
        'nama' => ['type' => 'string', 'length' => 150, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Nama lengkap tenaga kesehatan', 'precision' => null],
        'status' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Jenis/profesi: PERAWAT/SUSTER, BIDAN, UMUM, PENUNJANG MEDIS, ANALYST LABORATORIUM, dst', 'precision' => null],
        'is_active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'idx_master_tenaga_medis_nama' => ['type' => 'index', 'columns' => ['nama'], 'length' => []],
            'idx_master_tenaga_medis_status' => ['type' => 'index', 'columns' => ['status'], 'length' => []],
            'idx_master_tenaga_medis_active' => ['type' => 'index', 'columns' => ['is_active'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uq_master_tenaga_medis_kode' => ['type' => 'unique', 'columns' => ['kode'], 'length' => []],
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
                'kode' => 'Lorem ipsum dolor sit amet',
                'nama' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'created' => '2026-08-14 09:09:07',
                'modified' => '2026-08-14 09:09:07',
            ],
        ];
        parent::init();
    }
}
