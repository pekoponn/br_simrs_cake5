<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OutpatientBillingsFixture
 */
class OutpatientBillingsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'billing_no' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Nomor tagihan, contoh: BILL-20260613-00001', 'precision' => null],
        'outpatient_visit_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'registration_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'patient_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'doctor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'visit_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'polyclinic_name' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'insurance_type' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => 'Umum', 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Umum, BPJS, Asuransi, dll', 'precision' => null],
        'insurance_no' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'No kartu BPJS / asuransi', 'precision' => null],
        'status' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'draft', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'total_action' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => 'Total biaya tindakan'],
        'total_medicine' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => 'Total biaya obat/resep'],
        'total_lab' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => 'Total biaya laboratorium'],
        'total_radiology' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => 'Total biaya radiologi'],
        'total_other' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => 'Biaya lain-lain'],
        'subtotal' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'discount_type' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'nominal', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'discount_value' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'discount_amount' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => 'Hasil kalkulasi diskon'],
        'grand_total' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'payment_method' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'tunai', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'paid_amount' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => 'Jumlah yang dibayarkan'],
        'change_amount' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => 'Kembalian'],
        'paid_at' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'cashier_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'User kasir yang memproses', 'precision' => null, 'autoIncrement' => null],
        'cashier_name' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'is_referred' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'referred_to' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'is_inpatient' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'inpatient_referral_no' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'notes' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'void_reason' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'voided_at' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'voided_by' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_create' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null],
        'is_update' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'is_delete' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'is_active' => ['type' => 'char', 'length' => 1, 'null' => true, 'default' => 'Y', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'created_by' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modified_by' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'idx_visit' => ['type' => 'index', 'columns' => ['outpatient_visit_id'], 'length' => []],
            'idx_patient' => ['type' => 'index', 'columns' => ['patient_id'], 'length' => []],
            'idx_billing_no' => ['type' => 'index', 'columns' => ['billing_no'], 'length' => []],
            'idx_status' => ['type' => 'index', 'columns' => ['status'], 'length' => []],
            'idx_visit_date' => ['type' => 'index', 'columns' => ['visit_date'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uq_billing_no' => ['type' => 'unique', 'columns' => ['billing_no'], 'length' => []],
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
                'billing_no' => 'Lorem ipsum dolor sit amet',
                'outpatient_visit_id' => 1,
                'registration_id' => 1,
                'patient_id' => 1,
                'doctor_id' => 1,
                'visit_date' => '2026-06-25',
                'polyclinic_name' => 'Lorem ipsum dolor sit amet',
                'insurance_type' => 'Lorem ipsum dolor sit amet',
                'insurance_no' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'total_action' => 1.5,
                'total_medicine' => 1.5,
                'total_lab' => 1.5,
                'total_radiology' => 1.5,
                'total_other' => 1.5,
                'subtotal' => 1.5,
                'discount_type' => 'Lorem ipsum dolor sit amet',
                'discount_value' => 1.5,
                'discount_amount' => 1.5,
                'grand_total' => 1.5,
                'payment_method' => 'Lorem ipsum dolor sit amet',
                'paid_amount' => 1.5,
                'change_amount' => 1.5,
                'paid_at' => '2026-06-25 14:38:44',
                'cashier_id' => 1,
                'cashier_name' => 'Lorem ipsum dolor sit amet',
                'is_referred' => 1,
                'referred_to' => 'Lorem ipsum dolor sit amet',
                'is_inpatient' => 1,
                'inpatient_referral_no' => 'Lorem ipsum dolor sit amet',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'void_reason' => 'Lorem ipsum dolor sit amet',
                'voided_at' => '2026-06-25 14:38:44',
                'voided_by' => 1,
                'is_create' => 1,
                'is_update' => 1,
                'is_delete' => 1,
                'is_active' => '',
                'created' => '2026-06-25 14:38:44',
                'modified' => '2026-06-25 14:38:44',
                'created_by' => 1,
                'modified_by' => 1,
            ],
        ];
        parent::init();
    }
}
