<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PraRegistrationsFixture
 */
class PraRegistrationsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'reservation_code' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'patient_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'nanti di-FK ke patients.id', 'precision' => null, 'autoIncrement' => null],
        'medical_record_no' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'No. RM', 'precision' => null],
        'patient_name' => ['type' => 'string', 'length' => 150, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'birth_date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'address' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'phone_number' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'nik' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'doctor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'nanti di-FK ke doctors.id / doctor_schedules.id', 'precision' => null, 'autoIncrement' => null],
        'doctor_name' => ['type' => 'string', 'length' => 150, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'poly_name' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Tujuan / Pelayanan', 'precision' => null],
        'appointment_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Tanggal', 'precision' => null],
        'appointment_day' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Hari, disimpan biar gampang ditampilkan', 'precision' => null],
        'appointment_time' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Jam', 'precision' => null],
        'patient_queue_number' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'Nomor Antri Pasien', 'precision' => null, 'autoIncrement' => null],
        'guarantor' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Penjamin, kosong = tunai', 'precision' => null],
        'planned_action' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Rencana Tindakan', 'precision' => null],
        'referral_type' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'card_number' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'No Kartu (BPJS dll)', 'precision' => null],
        'referral_number' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'No Rujukan / Kontrol', 'precision' => null],
        'channel' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'wa', 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Melalui', 'precision' => null],
        'notes' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => 'Keterangan', 'precision' => null],
        'registration_status' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'belum_diproses', 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'registered_at' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => 'diisi saat tombol Daftarkan ditekan'],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'created_by' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'modified_by' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'idx_pra_registrations_appointment_date' => ['type' => 'index', 'columns' => ['appointment_date'], 'length' => []],
            'idx_pra_registrations_status' => ['type' => 'index', 'columns' => ['registration_status'], 'length' => []],
            'idx_pra_registrations_patient_name' => ['type' => 'index', 'columns' => ['patient_name'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uq_pra_registrations_reservation_code' => ['type' => 'unique', 'columns' => ['reservation_code'], 'length' => []],
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
                'reservation_code' => 'Lorem ipsum dolor sit amet',
                'patient_id' => 1,
                'medical_record_no' => 'Lorem ipsum dolor ',
                'patient_name' => 'Lorem ipsum dolor sit amet',
                'birth_date' => '2026-08-13',
                'address' => 'Lorem ipsum dolor sit amet',
                'phone_number' => 'Lorem ipsum dolor ',
                'nik' => 'Lorem ipsum dolor ',
                'doctor_id' => 1,
                'doctor_name' => 'Lorem ipsum dolor sit amet',
                'poly_name' => 'Lorem ipsum dolor sit amet',
                'appointment_date' => '2026-08-13',
                'appointment_day' => 'Lorem ipsum d',
                'appointment_time' => '10:12:10',
                'patient_queue_number' => 1,
                'guarantor' => 'Lorem ipsum dolor sit amet',
                'planned_action' => 'Lorem ipsum dolor sit amet',
                'referral_type' => 'Lorem ipsum dolor sit amet',
                'card_number' => 'Lorem ipsum dolor sit amet',
                'referral_number' => 'Lorem ipsum dolor sit amet',
                'channel' => 'Lorem ipsum dolor sit amet',
                'notes' => 'Lorem ipsum dolor sit amet',
                'registration_status' => 'Lorem ipsum dolor sit amet',
                'registered_at' => '2026-08-13 10:12:10',
                'created' => '2026-08-13 10:12:10',
                'created_by' => 'Lorem ipsum dolor sit amet',
                'modified' => '2026-08-13 10:12:10',
                'modified_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
