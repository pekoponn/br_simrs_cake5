<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBillingItem[]|\Cake\Collection\CollectionInterface $outpatientBillingItems
 */
?>
<div class="outpatientBillingItems index content">
    <?= $this->Html->link(__('New Outpatient Billing Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Outpatient Billing Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('billing_id') ?></th>
                    <th><?= $this->Paginator->sort('item_type') ?></th>
                    <th><?= $this->Paginator->sort('item_code') ?></th>
                    <th><?= $this->Paginator->sort('item_name') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('total_price') ?></th>
                    <th><?= $this->Paginator->sort('discount_amount') ?></th>
                    <th><?= $this->Paginator->sort('final_price') ?></th>
                    <th><?= $this->Paginator->sort('notes') ?></th>
                    <th><?= $this->Paginator->sort('is_covered') ?></th>
                    <th><?= $this->Paginator->sort('sort_order') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($outpatientBillingItems as $outpatientBillingItem): ?>
                <tr>
                    <td><?= $this->Number->format($outpatientBillingItem->id) ?></td>
                    <td><?= $outpatientBillingItem->has('outpatient_billing') ? $this->Html->link($outpatientBillingItem->outpatient_billing->id, ['controller' => 'OutpatientBillings', 'action' => 'view', $outpatientBillingItem->outpatient_billing->id]) : '' ?></td>
                    <td><?= h($outpatientBillingItem->item_type) ?></td>
                    <td><?= h($outpatientBillingItem->item_code) ?></td>
                    <td><?= h($outpatientBillingItem->item_name) ?></td>
                    <td><?= $this->Number->format($outpatientBillingItem->quantity) ?></td>
                    <td><?= h($outpatientBillingItem->unit) ?></td>
                    <td><?= $this->Number->format($outpatientBillingItem->unit_price) ?></td>
                    <td><?= $this->Number->format($outpatientBillingItem->total_price) ?></td>
                    <td><?= $this->Number->format($outpatientBillingItem->discount_amount) ?></td>
                    <td><?= $this->Number->format($outpatientBillingItem->final_price) ?></td>
                    <td><?= h($outpatientBillingItem->notes) ?></td>
                    <td><?= h($outpatientBillingItem->is_covered) ?></td>
                    <td><?= $this->Number->format($outpatientBillingItem->sort_order) ?></td>
                    <td><?= h($outpatientBillingItem->is_delete) ?></td>
                    <td><?= h($outpatientBillingItem->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $outpatientBillingItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $outpatientBillingItem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $outpatientBillingItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientBillingItem->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
