<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderRadiology[]|\Cake\Collection\CollectionInterface $orderRadiologies
 */
?>
<div class="orderRadiologies index content">
    <?= $this->Html->link(__('New Order Radiology'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Order Radiologies') ?></h3>
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
                <?php foreach ($orderRadiologies as $orderRadiology): ?>
                <tr>
                    <td><?= $this->Number->format($orderRadiology->id) ?></td>
                    <td><?= $orderRadiology->has('order') ? $this->Html->link($orderRadiology->order->id, ['prefix' => 'Farmasi', 'controller' => 'Orders', 'action' => 'view', $orderRadiology->order->id]) : '' ?></td>
                    <td><?= $orderRadiology->has('master_tindakan') ? $this->Html->link($orderRadiology->master_tindakan->id, ['prefix' => 'Master', 'controller' => 'MasterTindakan', 'action' => 'view', $orderRadiology->master_tindakan->id]) : '' ?></td>
                    <td><?= h($orderRadiology->code) ?></td>
                    <td><?= h($orderRadiology->examination_name) ?></td>
                    <td><?= $this->Number->format($orderRadiology->price) ?></td>
                    <td><?= h($orderRadiology->approval_note) ?></td>
                    <td><?= h($orderRadiology->created) ?></td>
                    <td><?= h($orderRadiology->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $orderRadiology->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderRadiology->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderRadiology->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderRadiology->id)]) ?>
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
