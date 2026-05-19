<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RegistrationsFixture
 */
class RegistrationsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'registration_no' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '0', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'nomor registrasi', 'precision' => null],
        'patient_id' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'patient id FK ke patients', 'precision' => null],
        'registration_date' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'tanggal masuk', 'precision' => null],
        'service_type' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'pelayanan', 'precision' => null],
        'doctor_id' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'doctor id', 'precision' => null],
        'polyclinic_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'nama poli', 'precision' => null],
        'room_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ruangan id', 'precision' => null, 'autoIncrement' => null],
        'bed_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'bed id', 'precision' => null, 'autoIncrement' => null],
        'class_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'nama kelas', 'precision' => null],
        'entry_process' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'proses masuk', 'precision' => null],
        'entry_method' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'cara masuk', 'precision' => null],
        'payment_method' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'jenis pembayaran', 'precision' => null],
        'insurance_type' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_as_ci', 'comment' => 'tipe asuransi', 'precision' => null],
        'insurance_card_no' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'Nomor kartu asuransi', 'precision' => null],
        'refferal_no' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'nomor rujukan', 'precision' => null],
        'sep_no' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'nomor sep', 'precision' => null],
        'person_responsible_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'id penanggung jawab pasien', 'precision' => null, 'autoIncrement' => null],
        'treatment_type' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => 'tipe perawatan', 'precision' => null],
        'status' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'is_create' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_update' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_delete' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'delete_log' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'is_active' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'Y', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
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
                'registration_no' => 'Lorem ipsum dolor sit amet',
                'patient_id' => 'Lorem ipsum dolor sit amet',
                'registration_date' => 'Lorem ipsum dolor sit amet',
                'service_type' => 'Lorem ipsum dolor sit amet',
                'doctor_id' => 'Lorem ipsum dolor sit amet',
                'polyclinic_name' => 'Lorem ipsum dolor sit amet',
                'room_id' => 1,
                'bed_id' => 1,
                'class_name' => 'Lorem ipsum dolor sit amet',
                'entry_process' => 'Lorem ipsum dolor sit amet',
                'entry_method' => 'Lorem ipsum dolor sit amet',
                'payment_method' => 'Lorem ipsum dolor sit amet',
                'insurance_type' => 'Lorem ipsum dolor sit amet',
                'insurance_card_no' => 'Lorem ipsum dolor sit amet',
                'refferal_no' => 'Lorem ipsum dolor sit amet',
                'sep_no' => 'Lorem ipsum dolor sit amet',
                'person_responsible_id' => 1,
                'treatment_type' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'is_create' => 1,
                'created' => '2026-05-19 08:18:00',
                'is_update' => 1,
                'modified' => '2026-05-19 08:18:00',
                'is_delete' => 1,
                'deleted' => '2026-05-19 08:18:00',
                'delete_log' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_active' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
