<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PatientHistory Entity
 *
 * @property int $id
 * @property int $registration_id
 * @property string|null $status
 * @property int $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $delete_log
 * @property string $is_active
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\PatientHistoryDocument[] $patient_history_documents
 * @property \App\Model\Entity\PatientHistoryExamination[] $patient_history_examinations
 * @property \App\Model\Entity\PatientHistoryIcare[] $patient_history_icares
 * @property \App\Model\Entity\PatientHistoryIntegration[] $patient_history_integrations
 * @property \App\Model\Entity\PatientHistoryLaboratory[] $patient_history_laboratories
 * @property \App\Model\Entity\PatientHistoryPrescription[] $patient_history_prescriptions
 * @property \App\Model\Entity\PatientHistoryRadiology[] $patient_history_radiologies
 */
class PatientHistory extends Entity
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
    protected array $_accessible = [
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
        'patient_history_documents' => true,
        'patient_history_examinations' => true,
        'patient_history_icares' => true,
        'patient_history_integrations' => true,
        'patient_history_laboratories' => true,
        'patient_history_prescriptions' => true,
        'patient_history_radiologies' => true,
    ];
}
