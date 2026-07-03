<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OutpatientBillingPaymentsFixture
 */
class OutpatientBillingPaymentsFixture extends TestFixture
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
        'payment_no' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Nomor transaksi pembayaran', 'precision' => null],
        'payment_method' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'tunai', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'bank_name' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Nama bank jika transfer/debit/kredit', 'precision' => null],
        'account_no' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'No rekening / no kartu (masked)', 'precision' => null],
        'amount' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'verified' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'verified_at' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'verified_by' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'notes' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'created_by' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'idx_billing' => ['type' => 'index', 'columns' => ['billing_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uq_payment_no' => ['type' => 'unique', 'columns' => ['payment_no'], 'length' => []],
            'fk_billing_payments_billing' => ['type' => 'foreign', 'columns' => ['billing_id'], 'references' => ['outpatient_billings', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'payment_no' => 'Lorem ipsum dolor sit amet',
                'payment_method' => 'Lorem ipsum dolor sit amet',
                'bank_name' => 'Lorem ipsum dolor sit amet',
                'account_no' => 'Lorem ipsum dolor sit amet',
                'amount' => 1.5,
                'verified' => 1,
                'verified_at' => '2026-06-25 14:39:41',
                'verified_by' => 1,
                'notes' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-06-25 14:39:41',
                'created_by' => 1,
            ],
        ];
        parent::init();
    }
}
