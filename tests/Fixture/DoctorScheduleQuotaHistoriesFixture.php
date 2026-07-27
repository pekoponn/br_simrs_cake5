<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DoctorScheduleQuotaHistoriesFixture
 */
class DoctorScheduleQuotaHistoriesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'doctor_schedule_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cycle_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Tanggal praktik pada minggu tsb (mis. Senin 20-07-2026)', 'precision' => null],
        'quota' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quota_used' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'idx_schedule_cycle' => ['type' => 'index', 'columns' => ['doctor_schedule_id', 'cycle_date'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'doctor_schedule_id' => 1,
                'cycle_date' => '2026-07-27',
                'quota' => 1,
                'quota_used' => 1,
                'created' => '2026-07-27 15:45:50',
                'modified' => '2026-07-27 15:45:50',
            ],
        ];
        parent::init();
    }
}
