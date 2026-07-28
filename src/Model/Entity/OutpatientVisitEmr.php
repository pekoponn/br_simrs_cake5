<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class OutpatientVisitEmr extends Entity
{
    protected $_accessible = [
        'outpatient_visit_id' => true,
        'blood_pressure' => true,
        'pulse' => true,
        'temperature' => true,
        'respiratory_rate' => true,
        'oxygen_saturation' => true,
        'weight' => true,
        'height' => true,
        'bmi' => true,
        'chief_complaint' => true,
        'illness_history' => true,
        'admission_diagnosis' => true,
        'allergy' => true,
        'pain_scale' => true,
        'diagnosis_primary' => true,
        'diagnosis_secondary' => true,
        'diagnosis_desc' => true,
        'icd10_items' => true,
        'icd9_items' => true,
        'anatomy_front' => true,
        'anatomy_back' => true,
        'action_notes' => true,
        'doctor_notes' => true,
        'prescription_notes' => true,
        'follow_up_date' => true,
        'referral_to' => true,
        'referral_reason' => true,
        'payment_method' => true,
        'total_fee' => true,
        'paid' => true,
        'outpatient_visit' => true,
    ];

       // Migration baru, contoh: AddTherapyFieldsToOutpatientVisitEmrs.php
    public function change()
    {
        $table = $this->table('outpatient_visit_emrs');
        $table->addColumn('therapy_days', 'integer', [
                'null' => true,
                'default' => 0,
                'comment' => 'Lama pemberian terapi/obat (hari) - Protokol Terapi',
            ])
            ->addColumn('therapy_reason', 'text', [
                'null' => true,
                'comment' => 'Alasan pemberian terapi - Protokol Terapi',
            ])
            ->update();
    }
}
