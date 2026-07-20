<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OutpatientLettersFixture
 */
class OutpatientLettersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'outpatient_visit_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'registration_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'patient_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'doctor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'letter_type' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => 'sakit', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'letter_no' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'weight' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'height' => ['type' => 'decimal', 'length' => 5, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'blood_pressure' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'temperature' => ['type' => 'decimal', 'length' => 4, 'precision' => 1, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'color_blind' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'blood_type' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'leave_days' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'leave_from' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'leave_to' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'diagnosis' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'is_normal' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null],
        'examined_at' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'outpatient_visit_id' => ['type' => 'index', 'columns' => ['outpatient_visit_id'], 'length' => []],
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
                'outpatient_visit_id' => 1,
                'registration_id' => 1,
                'patient_id' => 1,
                'doctor_id' => 1,
                'letter_type' => 'Lorem ipsum dolor sit amet',
                'letter_no' => 'Lorem ipsum dolor sit amet',
                'weight' => 1.5,
                'height' => 1.5,
                'blood_pressure' => 'Lorem ipsum dolor ',
                'temperature' => 1.5,
                'color_blind' => 'Lorem ipsum dolor ',
                'blood_type' => 'Lor',
                'leave_days' => 1,
                'leave_from' => '2026-07-18',
                'leave_to' => '2026-07-18',
                'diagnosis' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_normal' => 1,
                'examined_at' => '2026-07-18',
                'created' => '2026-07-18 12:36:44',
                'modified' => '2026-07-18 12:36:44',
            ],
        ];
        parent::init();
    }
}
