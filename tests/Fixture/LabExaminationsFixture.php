<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LabExaminationsFixture
 */
class LabExaminationsFixture extends TestFixture
{
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
                'lab_no' => 'Lorem ipsum dolor sit amet',
                'registration_id' => 1,
                'patient_id' => 1,
                'medical_record_no' => 'Lorem ipsum dolor sit amet',
                'patient_name' => 'Lorem ipsum dolor sit amet',
                'examination_name' => 'Lorem ipsum dolor sit amet',
                'patient_type' => 'Lorem ipsum dolor sit amet',
                'sender_doctor' => 'Lorem ipsum dolor sit amet',
                'origin' => 'Lorem ipsum dolor sit amet',
                'received_at' => '2026-11-03 14:11:00',
                'finished_at' => '2026-11-03 14:11:00',
                'status' => 'Lorem ipsum dolor sit amet',
                'integration_status' => 1,
                'is_create' => 1,
                'is_update' => 1,
                'is_delete' => 1,
                'is_active' => '',
                'created' => '2026-11-03 14:11:00',
                'modified' => '2026-11-03 14:11:00',
            ],
        ];
        parent::init();
    }
}
