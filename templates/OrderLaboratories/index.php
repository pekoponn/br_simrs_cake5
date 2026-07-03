<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderLaboratory[]|\Cake\Collection\CollectionInterface $orderLaboratories
 */
?>
<div class="orderLaboratories index content">
    <?= $this->Html->link(__('New Order Laboratory'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Order Laboratories') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('order_id') ?></th>
                    <th><?= $this->Paginator->sort('master_tindakan_id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('examination_name') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('approval_note') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderLaboratories as $orderLaboratory): ?>
                <tr>
                    <td><?= $this->Number->format($orderLaboratory->id) ?></td>
                    <td><?= $orderLaboratory->has('order') ? $this->Html->link($orderLaboratory->order->id, ['controller' => 'Orders', 'action' => 'view', $orderLaboratory->order->id]) : '' ?></td>
                    <td><?= $orderLaboratory->has('master_tindakan') ? $this->Html->link($orderLaboratory->master_tindakan->id, ['controller' => 'MasterTindakan', 'action' => 'view', $orderLaboratory->master_tindakan->id]) : '' ?></td>
                    <td><?= h($orderLaboratory->code) ?></td>
                    <td><?= h($orderLaboratory->examination_name) ?></td>
                    <td><?= $this->Number->format($orderLaboratory->price) ?></td>
                    <td><?= h($orderLaboratory->approval_note) ?></td>
                    <td><?= h($orderLaboratory->created) ?></td>
                    <td><?= h($orderLaboratory->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $orderLaboratory->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderLaboratory->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderLaboratory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderLaboratory->id)]) ?>
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
