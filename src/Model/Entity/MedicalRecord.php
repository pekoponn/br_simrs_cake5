<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class MedicalRecord extends Entity
{
    protected $_accessible = [
        'registration_id' => true,
        'status' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'delete_log' => true,
        'is_active' => true,
        'registration' => true,
        'medical_record_examinations' => true,
        'medical_record_prescriptions' => true,
        'medical_record_laboratories' => true,
        'medical_record_radiologies' => true,
        'medical_record_surgeries' => true,
        'medical_record_integrations' => true,
        'medical_record_icares' => true,
        'medical_record_documents' => true,
        'medical_record_referrals' => true,
    ];
}
