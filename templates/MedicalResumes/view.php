<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalResume $medicalResume
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Medical Resume'), ['action' => 'edit', $medicalResume->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Medical Resume'), ['action' => 'delete', $medicalResume->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicalResume->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Medical Resumes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Medical Resume'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicalResumes view content">
            <h3><?= h($medicalResume->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Outpatient Visit') ?></th>
                    <td><?= $medicalResume->has('outpatient_visit') ? $this->Html->link($medicalResume->outpatient_visit->id, ['controller' => 'OutpatientVisits', 'action' => 'view', $medicalResume->outpatient_visit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $medicalResume->has('registration') ? $this->Html->link($medicalResume->registration->id, ['controller' => 'Registrations', 'action' => 'view', $medicalResume->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $medicalResume->has('patient') ? $this->Html->link($medicalResume->patient->id, ['controller' => 'Patients', 'action' => 'view', $medicalResume->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor2 Name') ?></th>
                    <td><?= h($medicalResume->doctor2_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor3 Name') ?></th>
                    <td><?= h($medicalResume->doctor3_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor4 Name') ?></th>
                    <td><?= h($medicalResume->doctor4_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Consultant1 Name') ?></th>
                    <td><?= h($medicalResume->consultant1_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Consultant2 Name') ?></th>
                    <td><?= h($medicalResume->consultant2_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Condition On Discharge') ?></th>
                    <td><?= h($medicalResume->condition_on_discharge) ?></td>
                </tr>
                <tr>
                    <th><?= __('Prognosis') ?></th>
                    <td><?= h($medicalResume->prognosis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Follow Up Treatment') ?></th>
                    <td><?= h($medicalResume->follow_up_treatment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($medicalResume->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor1 Id') ?></th>
                    <td><?= $this->Number->format($medicalResume->doctor1_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Control Date') ?></th>
                    <td><?= h($medicalResume->control_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($medicalResume->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($medicalResume->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Print Classic') ?></th>
                    <td><?= $medicalResume->print_classic ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Send Digital Claim') ?></th>
                    <td><?= $medicalResume->send_digital_claim ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Summary History') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->summary_history)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Inpatient Indication') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->inpatient_indication)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Physical Exam') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->physical_exam)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Supporting Exam') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->supporting_exam)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Therapy During Treatment') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->therapy_during_treatment)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Consultation Result') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->consultation_result)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Admission Diagnosis') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->admission_diagnosis)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Lab Unfinished') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->lab_unfinished)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Diet') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->diet)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Education Instruction') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->education_instruction)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Primary Diagnosis') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->primary_diagnosis)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Secondary Diagnosis') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->secondary_diagnosis)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Medical Action') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->medical_action)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Control Note') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->control_note)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Control Plan') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->control_plan)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Return Reason') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalResume->return_reason)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
