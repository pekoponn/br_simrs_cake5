<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LabExamination $labExamination
 * @var \Cake\Collection\CollectionInterface|string[] $registrations
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Lab Examinations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="labExaminations form content">
            <?= $this->Form->create($labExamination) ?>
            <fieldset>
                <legend><?= __('Add Lab Examination') ?></legend>
                <?php
                    echo $this->Form->control('lab_no');
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('medical_record_no');
                    echo $this->Form->control('patient_name');
                    echo $this->Form->control('examination_name');
                    echo $this->Form->control('patient_type');
                    echo $this->Form->control('sender_doctor');
                    echo $this->Form->control('origin');
                    echo $this->Form->control('received_at', ['empty' => true]);
                    echo $this->Form->control('finished_at', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('integration_status');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
