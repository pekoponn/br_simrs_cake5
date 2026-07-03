<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBillingPayment[]|\Cake\Collection\CollectionInterface $outpatientBillingPayments
 */
?>
<div class="outpatientBillingPayments index content">
    <?= $this->Html->link(__('New Outpatient Billing Payment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Outpatient Billing Payments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('billing_id') ?></th>
                    <th><?= $this->Paginator->sort('payment_no') ?></th>
                    <th><?= $this->Paginator->sort('payment_method') ?></th>
                    <th><?= $this->Paginator->sort('bank_name') ?></th>
                    <th><?= $this->Paginator->sort('account_no') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('verified') ?></th>
                    <th><?= $this->Paginator->sort('verified_at') ?></th>
                    <th><?= $this->Paginator->sort('verified_by') ?></th>
                    <th><?= $this->Paginator->sort('notes') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($outpatientBillingPayments as $outpatientBillingPayment): ?>
                <tr>
                    <td><?= $this->Number->format($outpatientBillingPayment->id) ?></td>
                    <td><?= $outpatientBillingPayment->has('outpatient_billing') ? $this->Html->link($outpatientBillingPayment->outpatient_billing->id, ['controller' => 'OutpatientBillings', 'action' => 'view', $outpatientBillingPayment->outpatient_billing->id]) : '' ?></td>
                    <td><?= h($outpatientBillingPayment->payment_no) ?></td>
                    <td><?= h($outpatientBillingPayment->payment_method) ?></td>
                    <td><?= h($outpatientBillingPayment->bank_name) ?></td>
                    <td><?= h($outpatientBillingPayment->account_no) ?></td>
                    <td><?= $this->Number->format($outpatientBillingPayment->amount) ?></td>
                    <td><?= h($outpatientBillingPayment->verified) ?></td>
                    <td><?= h($outpatientBillingPayment->verified_at) ?></td>
                    <td><?= $this->Number->format($outpatientBillingPayment->verified_by) ?></td>
                    <td><?= h($outpatientBillingPayment->notes) ?></td>
                    <td><?= h($outpatientBillingPayment->created) ?></td>
                    <td><?= $this->Number->format($outpatientBillingPayment->created_by) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $outpatientBillingPayment->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $outpatientBillingPayment->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $outpatientBillingPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientBillingPayment->id)]) ?>
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
