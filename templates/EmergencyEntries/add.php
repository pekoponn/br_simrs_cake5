<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmergencyEntry $emergencyEntry
 * @var \Cake\Collection\CollectionInterface|string[] $registrations
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 * @var \Cake\Collection\CollectionInterface|string[] $doctors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Emergency Entries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="emergencyEntries form content">
            <?= $this->Form->create($emergencyEntry) ?>
            <fieldset>
                <legend><?= __('Add Emergency Entry') ?></legend>
                <?php
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('registration_no');
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('patient_rm');
                    echo $this->Form->control('patient_name');
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('doctor_name');
                    echo $this->Form->control('service_date', ['empty' => true]);
                    echo $this->Form->control('service_time', ['empty' => true]);
                    echo $this->Form->control('chief_complaint');
                    echo $this->Form->control('triage_category');
                    echo $this->Form->control('triage_notes');
                    echo $this->Form->control('blood_pressure');
                    echo $this->Form->control('temperature');
                    echo $this->Form->control('pulse');
                    echo $this->Form->control('respiration');
                    echo $this->Form->control('spo2');
                    echo $this->Form->control('diagnosis');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
