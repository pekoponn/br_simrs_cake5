<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class OutpatientInitialMedicalAssessment extends Entity
{
    protected $_accessible = [
        'outpatient_visit_id' => true,
        'registration_id' => true,
        'patient_id' => true,
        'doctor_id' => true,
        'assessment_no' => true,
        'assessment_date' => true,
        'assessment_time' => true,
        'data_dasar' => true,
        'subjektif' => true,
        'observasi' => true,
        'created_by_user_id' => true,
        'modified_by_user_id' => true,
        'created' => true,
        'modified' => true,
        'outpatient_visit' => true,
        'registration' => true,
        'patient' => true,
        'doctor' => true,
    ];
}
