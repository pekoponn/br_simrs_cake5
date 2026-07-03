<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBilling $outpatientBilling
 * @var \Cake\Collection\CollectionInterface|string[] $outpatientVisits
 * @var \Cake\Collection\CollectionInterface|string[] $registrations
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 * @var \Cake\Collection\CollectionInterface|string[] $doctors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Outpatient Billings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientBillings form content">
            <?= $this->Form->create($outpatientBilling) ?>
            <fieldset>
                <legend><?= __('Add Outpatient Billing') ?></legend>
                <?php
                    echo $this->Form->control('billing_no');
                    echo $this->Form->control('outpatient_visit_id', ['options' => $outpatientVisits]);
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('patient_id', ['options' => $patients]);
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('visit_date');
                    echo $this->Form->control('polyclinic_name');
                    echo $this->Form->control('insurance_type');
                    echo $this->Form->control('insurance_no');
                    echo $this->Form->control('status');
                    echo $this->Form->control('total_action');
                    echo $this->Form->control('total_medicine');
                    echo $this->Form->control('total_lab');
                    echo $this->Form->control('total_radiology');
                    echo $this->Form->control('total_other');
                    echo $this->Form->control('subtotal');
                    echo $this->Form->control('discount_type');
                    echo $this->Form->control('discount_value');
                    echo $this->Form->control('discount_amount');
                    echo $this->Form->control('grand_total');
                    echo $this->Form->control('payment_method');
                    echo $this->Form->control('paid_amount');
                    echo $this->Form->control('change_amount');
                    echo $this->Form->control('paid_at', ['empty' => true]);
                    echo $this->Form->control('cashier_id');
                    echo $this->Form->control('cashier_name');
                    echo $this->Form->control('is_referred');
                    echo $this->Form->control('referred_to');
                    echo $this->Form->control('is_inpatient');
                    echo $this->Form->control('inpatient_referral_no');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('void_reason');
                    echo $this->Form->control('voided_at', ['empty' => true]);
                    echo $this->Form->control('voided_by');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('created_by');
                    echo $this->Form->control('modified_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
