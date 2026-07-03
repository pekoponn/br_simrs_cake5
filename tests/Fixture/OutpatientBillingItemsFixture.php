<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OutpatientBillingItemsFixture
 */
class OutpatientBillingItemsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'billing_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'item_type' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'tindakan', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'item_code' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'item_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'quantity' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '1.00', 'comment' => ''],
        'unit' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => 'kali', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'unit_price' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'total_price' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'discount_amount' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'final_price' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'notes' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'is_covered' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '1=ditanggung asuransi/BPJS', 'precision' => null],
        'sort_order' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_delete' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'idx_billing' => ['type' => 'index', 'columns' => ['billing_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_billing_items_billing' => ['type' => 'foreign', 'columns' => ['billing_id'], 'references' => ['outpatient_billings', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'billing_id' => 1,
                'item_type' => 'Lorem ipsum dolor sit amet',
                'item_code' => 'Lorem ipsum dolor sit amet',
                'item_name' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1.5,
                'unit' => 'Lorem ipsum dolor ',
                'unit_price' => 1.5,
                'total_price' => 1.5,
                'discount_amount' => 1.5,
                'final_price' => 1.5,
                'notes' => 'Lorem ipsum dolor sit amet',
                'is_covered' => 1,
                'sort_order' => 1,
                'is_delete' => 1,
                'created' => '2026-06-25 14:39:28',
            ],
        ];
        parent::init();
    }
}
