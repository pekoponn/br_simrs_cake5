<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LabExamination $labExamination
 * @var string[]|\Cake\Collection\CollectionInterface $registrations
 * @var string[]|\Cake\Collection\CollectionInterface $patients
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $labExamination->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $labExamination->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Lab Examinations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="labExaminations form content">
            <?= $this->Form->create($labExamination) ?>
            <fieldset>
                <legend><?= __('Edit Lab Examination') ?></legend>
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
