<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderMcus[]|\Cake\Collection\CollectionInterface $orderMcus
 */
?>
<div class="orderMcus index content">
    <?= $this->Html->link(__('New Order Mcus'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Order Mcus') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('order_id') ?></th>
                    <th><?= $this->Paginator->sort('registration_id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('doctor_id') ?></th>
                    <th><?= $this->Paginator->sort('mcu_date') ?></th>
                    <th><?= $this->Paginator->sort('mcu_time') ?></th>
                    <th><?= $this->Paginator->sort('mcu_type') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderMcus as $orderMcus): ?>
                <tr>
                    <td><?= $this->Number->format($orderMcus->id) ?></td>
                    <td><?= $orderMcus->has('order') ? $this->Html->link($orderMcus->order->id, ['controller' => 'Orders', 'action' => 'view', $orderMcus->order->id]) : '' ?></td>
                    <td><?= $orderMcus->has('registration') ? $this->Html->link($orderMcus->registration->id, ['controller' => 'Registrations', 'action' => 'view', $orderMcus->registration->id]) : '' ?></td>
                    <td><?= $orderMcus->has('patient') ? $this->Html->link($orderMcus->patient->id, ['controller' => 'Patients', 'action' => 'view', $orderMcus->patient->id]) : '' ?></td>
                    <td><?= $orderMcus->has('doctor') ? $this->Html->link($orderMcus->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $orderMcus->doctor->id]) : '' ?></td>
                    <td><?= h($orderMcus->mcu_date) ?></td>
                    <td><?= h($orderMcus->mcu_time) ?></td>
                    <td><?= h($orderMcus->mcu_type) ?></td>
                    <td><?= h($orderMcus->status) ?></td>
                    <td><?= h($orderMcus->is_active) ?></td>
                    <td><?= h($orderMcus->is_delete) ?></td>
                    <td><?= h($orderMcus->created) ?></td>
                    <td><?= h($orderMcus->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $orderMcus->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderMcus->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderMcus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderMcus->id)]) ?>
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
