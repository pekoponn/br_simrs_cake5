<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MedicalRecord Entity
 *
 * @property int $id
 * @property int $registration_id
 * @property int|null $patient_id
 * @property int|null $outpatient_visit_id
 * @property int|null $doctor_id
 * @property string|null $medical_record_no
 * @property string|null $service_type
 * @property string|null $allergy
 * @property string|null $status
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\OutpatientVisit $outpatient_visit
 * @property \App\Model\Entity\Doctor $doctor
 * @property \App\Model\Entity\MedicalRecordDiagnosis[] $medical_record_diagnoses
 * @property \App\Model\Entity\MedicalRecordDocument[] $medical_record_documents
 * @property \App\Model\Entity\MedicalRecordExamination[] $medical_record_examinations
 * @property \App\Model\Entity\MedicalRecordIcare[] $medical_record_icares
 * @property \App\Model\Entity\MedicalRecordInpatient[] $medical_record_inpatients
 * @property \App\Model\Entity\MedicalRecordIntegration[] $medical_record_integrations
 * @property \App\Model\Entity\MedicalRecordLaboratory[] $medical_record_laboratories
 * @property \App\Model\Entity\MedicalRecordOutpatientIgd[] $medical_record_outpatient_igds
 * @property \App\Model\Entity\MedicalRecordPrescription[] $medical_record_prescriptions
 * @property \App\Model\Entity\MedicalRecordRadiology[] $medical_record_radiologies
 */
class MedicalRecord extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id' => true,
        'registration_id' => true,
        'patient_id' => true,
        'outpatient_visit_id' => true,
        'doctor_id' => true,
        'medical_record_no' => true,
        'service_type' => true,
        'allergy' => true,
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
        'patient' => true,
        'outpatient_visit' => true,
        'doctor' => true,
        'medical_record_diagnoses' => true,
        'medical_record_documents' => true,
        'medical_record_examinations' => true,
        'medical_record_icares' => true,
        'medical_record_inpatients' => true,
        'medical_record_integrations' => true,
        'medical_record_laboratories' => true,
        'medical_record_outpatient_igds' => true,
        'medical_record_prescriptions' => true,
        'medical_record_radiologies' => true,
    ];
}