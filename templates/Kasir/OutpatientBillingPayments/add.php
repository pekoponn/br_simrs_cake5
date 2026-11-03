<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBillingPayment $outpatientBillingPayment
 * @var \Cake\Collection\CollectionInterface|string[] $outpatientBillings
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Outpatient Billing Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientBillingPayments form content">
            <?= $this->Form->create($outpatientBillingPayment) ?>
            <fieldset>
                <legend><?= __('Add Outpatient Billing Payment') ?></legend>
                <?php
                    echo $this->Form->control('billing_id', ['options' => $outpatientBillings]);
                    echo $this->Form->control('payment_no');
                    echo $this->Form->control('payment_method');
                    echo $this->Form->control('bank_name');
                    echo $this->Form->control('account_no');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('verified');
                    echo $this->Form->control('verified_at', ['empty' => true]);
                    echo $this->Form->control('verified_by');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('created_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
