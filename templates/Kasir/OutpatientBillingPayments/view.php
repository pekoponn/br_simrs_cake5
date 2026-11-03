<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBillingPayment $outpatientBillingPayment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Outpatient Billing Payment'), ['action' => 'edit', $outpatientBillingPayment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Outpatient Billing Payment'), ['action' => 'delete', $outpatientBillingPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientBillingPayment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Outpatient Billing Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Outpatient Billing Payment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientBillingPayments view content">
            <h3><?= h($outpatientBillingPayment->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Outpatient Billing') ?></th>
                    <td><?= $outpatientBillingPayment->has('outpatient_billing') ? $this->Html->link($outpatientBillingPayment->outpatient_billing->id, ['prefix' => 'Kasir', 'controller' => 'OutpatientBillings', 'action' => 'view', $outpatientBillingPayment->outpatient_billing->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment No') ?></th>
                    <td><?= h($outpatientBillingPayment->payment_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Method') ?></th>
                    <td><?= h($outpatientBillingPayment->payment_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name') ?></th>
                    <td><?= h($outpatientBillingPayment->bank_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account No') ?></th>
                    <td><?= h($outpatientBillingPayment->account_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Notes') ?></th>
                    <td><?= h($outpatientBillingPayment->notes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($outpatientBillingPayment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($outpatientBillingPayment->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Verified By') ?></th>
                    <td><?= $this->Number->format($outpatientBillingPayment->verified_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= $this->Number->format($outpatientBillingPayment->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Verified At') ?></th>
                    <td><?= h($outpatientBillingPayment->verified_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($outpatientBillingPayment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Verified') ?></th>
                    <td><?= $outpatientBillingPayment->verified ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
