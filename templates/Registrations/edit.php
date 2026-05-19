<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 * @var string[]|\Cake\Collection\CollectionInterface $patients
 * @var string[]|\Cake\Collection\CollectionInterface $doctors
 * @var string[]|\Cake\Collection\CollectionInterface $rooms
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $registration->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $registration->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Registrations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="registrations form content">
            <?= $this->Form->create($registration) ?>
            <fieldset>
                <legend><?= __('Edit Registration') ?></legend>
                <?php
                    echo $this->Form->control('registration_no');
                    echo $this->Form->control('patient_id', ['options' => $patients]);
                    echo $this->Form->control('registration_date');
                    echo $this->Form->control('service_type');
                    echo $this->Form->control('doctor_id', ['options' => $doctors]);
                    echo $this->Form->control('polyclinic_name');
                    echo $this->Form->control('room_id', ['options' => $rooms]);
                    echo $this->Form->control('bed_id');
                    echo $this->Form->control('class_name');
                    echo $this->Form->control('entry_process');
                    echo $this->Form->control('entry_method');
                    echo $this->Form->control('payment_method');
                    echo $this->Form->control('insurance_type');
                    echo $this->Form->control('insurance_card_no');
                    echo $this->Form->control('refferal_no');
                    echo $this->Form->control('sep_no');
                    echo $this->Form->control('person_responsible_id');
                    echo $this->Form->control('treatment_type');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('delete_log');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
