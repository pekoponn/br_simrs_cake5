<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit $outpatientVisit
 * @var string[]|\Cake\Collection\CollectionInterface $registrations
 * @var string[]|\Cake\Collection\CollectionInterface $patients
 * @var string[]|\Cake\Collection\CollectionInterface $doctors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $outpatientVisit->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientVisit->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Outpatient Visits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientVisits form content">
            <?= $this->Form->create($outpatientVisit) ?>
            <fieldset>
                <legend><?= __('Edit Outpatient Visit') ?></legend>
                <?php
                    echo $this->Form->control('registration_id', ['options' => $registrations]);
                    echo $this->Form->control('registration_no');
                    echo $this->Form->control('patient_id', ['options' => $patients]);
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('queue_number');
                    echo $this->Form->control('polyclinic_name');
                    echo $this->Form->control('visit_date');
                    echo $this->Form->control('visit_time', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('called_at', ['empty' => true]);
                    echo $this->Form->control('start_time', ['empty' => true]);
                    echo $this->Form->control('end_time', ['empty' => true]);
                    echo $this->Form->control('blood_pressure');
                    echo $this->Form->control('pulse');
                    echo $this->Form->control('temperature');
                    echo $this->Form->control('respiratory_rate');
                    echo $this->Form->control('oxygen_saturation');
                    echo $this->Form->control('weight');
                    echo $this->Form->control('height');
                    echo $this->Form->control('bmi');
                    echo $this->Form->control('chief_complaint');
                    echo $this->Form->control('illness_history');
                    echo $this->Form->control('allergy');
                    echo $this->Form->control('pain_scale');
                    echo $this->Form->control('diagnosis_primary');
                    echo $this->Form->control('diagnosis_secondary');
                    echo $this->Form->control('diagnosis_desc');
                    echo $this->Form->control('action_notes');
                    echo $this->Form->control('doctor_notes');
                    echo $this->Form->control('prescription_notes');
                    echo $this->Form->control('follow_up_date', ['empty' => true]);
                    echo $this->Form->control('referral_to');
                    echo $this->Form->control('referral_reason');
                    echo $this->Form->control('payment_method');
                    echo $this->Form->control('total_fee');
                    echo $this->Form->control('paid');
                    echo $this->Form->control('created_by');
                    echo $this->Form->control('updated_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>