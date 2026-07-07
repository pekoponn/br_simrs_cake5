<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalResume $medicalResume
 * @var \Cake\Collection\CollectionInterface|string[] $outpatientVisits
 * @var \Cake\Collection\CollectionInterface|string[] $registrations
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Medical Resumes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicalResumes form content">
            <?= $this->Form->create($medicalResume) ?>
            <fieldset>
                <legend><?= __('Add Medical Resume') ?></legend>
                <?php
                    echo $this->Form->control('outpatient_visit_id', ['options' => $outpatientVisits]);
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('doctor1_id');
                    echo $this->Form->control('doctor2_name');
                    echo $this->Form->control('doctor3_name');
                    echo $this->Form->control('doctor4_name');
                    echo $this->Form->control('consultant1_name');
                    echo $this->Form->control('consultant2_name');
                    echo $this->Form->control('summary_history');
                    echo $this->Form->control('inpatient_indication');
                    echo $this->Form->control('physical_exam');
                    echo $this->Form->control('supporting_exam');
                    echo $this->Form->control('therapy_during_treatment');
                    echo $this->Form->control('consultation_result');
                    echo $this->Form->control('admission_diagnosis');
                    echo $this->Form->control('lab_unfinished');
                    echo $this->Form->control('diet');
                    echo $this->Form->control('education_instruction');
                    echo $this->Form->control('primary_diagnosis');
                    echo $this->Form->control('secondary_diagnosis');
                    echo $this->Form->control('medical_action');
                    echo $this->Form->control('condition_on_discharge');
                    echo $this->Form->control('prognosis');
                    echo $this->Form->control('follow_up_treatment');
                    echo $this->Form->control('control_date', ['empty' => true]);
                    echo $this->Form->control('control_note');
                    echo $this->Form->control('control_plan');
                    echo $this->Form->control('return_reason');
                    echo $this->Form->control('print_classic');
                    echo $this->Form->control('send_digital_claim');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
