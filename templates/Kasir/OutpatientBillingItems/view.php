<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBillingItem $outpatientBillingItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Outpatient Billing Item'), ['action' => 'edit', $outpatientBillingItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Outpatient Billing Item'), ['action' => 'delete', $outpatientBillingItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientBillingItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Outpatient Billing Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Outpatient Billing Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientBillingItems view content">
            <h3><?= h($outpatientBillingItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Outpatient Billing') ?></th>
                    <td><?= $outpatientBillingItem->has('outpatient_billing') ? $this->Html->link($outpatientBillingItem->outpatient_billing->id, ['prefix' => 'Kasir', 'controller' => 'OutpatientBillings', 'action' => 'view', $outpatientBillingItem->outpatient_billing->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Type') ?></th>
                    <td><?= h($outpatientBillingItem->item_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Code') ?></th>
                    <td><?= h($outpatientBillingItem->item_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Name') ?></th>
                    <td><?= h($outpatientBillingItem->item_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($outpatientBillingItem->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Notes') ?></th>
                    <td><?= h($outpatientBillingItem->notes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($outpatientBillingItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($outpatientBillingItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $this->Number->format($outpatientBillingItem->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Price') ?></th>
                    <td><?= $this->Number->format($outpatientBillingItem->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Amount') ?></th>
                    <td><?= $this->Number->format($outpatientBillingItem->discount_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Final Price') ?></th>
                    <td><?= $this->Number->format($outpatientBillingItem->final_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sort Order') ?></th>
                    <td><?= $this->Number->format($outpatientBillingItem->sort_order) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($outpatientBillingItem->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Covered') ?></th>
                    <td><?= $outpatientBillingItem->is_covered ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $outpatientBillingItem->is_delete ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
