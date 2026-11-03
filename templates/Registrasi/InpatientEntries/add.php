<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InpatientEntry $inpatientEntry
 * @var \Cake\Collection\CollectionInterface|string[] $registrations
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 * @var \Cake\Collection\CollectionInterface|string[] $doctors
 * @var \Cake\Collection\CollectionInterface|string[] $rooms
 * @var \Cake\Collection\CollectionInterface|string[] $beds
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Inpatient Entries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="inpatientEntries form content">
            <?= $this->Form->create($inpatientEntry) ?>
            <fieldset>
                <legend><?= __('Add Inpatient Entry') ?></legend>
                <?php
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('registration_no');
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('patient_name');
                    echo $this->Form->control('patient_rm');
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('doctor_name');
                    echo $this->Form->control('room_id', ['options' => $rooms, 'empty' => true]);
                    echo $this->Form->control('room_name');
                    echo $this->Form->control('bed_id', ['options' => $beds, 'empty' => true]);
                    echo $this->Form->control('bed_no');
                    echo $this->Form->control('check_in_date', ['empty' => true]);
                    echo $this->Form->control('planned_discharge_date', ['empty' => true]);
                    echo $this->Form->control('check_out_date', ['empty' => true]);
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
