<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OutpatientActionsFixture
 */
class OutpatientActionsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'outpatient_visit_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'master_tindakan_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'FK ke master_tindakan.id', 'precision' => null, 'autoIncrement' => null],
        'action_code' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'action_name' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'action_category' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'quantity' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unit_price' => ['type' => 'decimal', 'length' => 12, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'total_price' => ['type' => 'decimal', 'length' => 12, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => '0.00', 'comment' => ''],
        'notes' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'performed_by' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'performed_at' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'idx_outpatient_visit_id' => ['type' => 'index', 'columns' => ['outpatient_visit_id'], 'length' => []],
            'idx_master_tindakan' => ['type' => 'index', 'columns' => ['master_tindakan_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_outpatient_actions_visit' => ['type' => 'foreign', 'columns' => ['outpatient_visit_id'], 'references' => ['outpatient_visits', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_oa_master' => ['type' => 'foreign', 'columns' => ['master_tindakan_id'], 'references' => ['master_tindakan', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
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
                'master_tindakan_id' => 1,
                'action_code' => 'Lorem ipsum dolor ',
                'action_name' => 'Lorem ipsum dolor sit amet',
                'action_category' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1,
                'unit_price' => 1.5,
                'total_price' => 1.5,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'performed_by' => 'Lorem ipsum dolor sit amet',
                'performed_at' => '2026-06-09 08:31:49',
                'created' => '2026-06-09 08:31:49',
                'modified' => '2026-06-09 08:31:49',
            ],
        ];
        parent::init();
    }
}
