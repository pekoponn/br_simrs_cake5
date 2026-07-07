<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderSupport[]|\Cake\Collection\CollectionInterface $orderSupports
 */
?>
<div class="orderSupports index content">
    <?= $this->Html->link(__('New Order Support'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Order Supports') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('order_id') ?></th>
                    <th><?= $this->Paginator->sort('registration_id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('doctor_id') ?></th>
                    <th><?= $this->Paginator->sort('support_code') ?></th>
                    <th><?= $this->Paginator->sort('support_name') ?></th>
                    <th><?= $this->Paginator->sort('tariff') ?></th>
                    <th><?= $this->Paginator->sort('qty') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('unit') ?></th>
                    <th><?= $this->Paginator->sort('approval_note') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderSupports as $orderSupport): ?>
                <tr>
                    <td><?= $this->Number->format($orderSupport->id) ?></td>
                    <td><?= $orderSupport->has('order') ? $this->Html->link($orderSupport->order->id, ['controller' => 'Orders', 'action' => 'view', $orderSupport->order->id]) : '' ?></td>
                    <td><?= $orderSupport->has('registration') ? $this->Html->link($orderSupport->registration->id, ['controller' => 'Registrations', 'action' => 'view', $orderSupport->registration->id]) : '' ?></td>
                    <td><?= $orderSupport->has('patient') ? $this->Html->link($orderSupport->patient->id, ['controller' => 'Patients', 'action' => 'view', $orderSupport->patient->id]) : '' ?></td>
                    <td><?= $orderSupport->has('doctor') ? $this->Html->link($orderSupport->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $orderSupport->doctor->id]) : '' ?></td>
                    <td><?= h($orderSupport->support_code) ?></td>
                    <td><?= h($orderSupport->support_name) ?></td>
                    <td><?= $this->Number->format($orderSupport->tariff) ?></td>
                    <td><?= $this->Number->format($orderSupport->qty) ?></td>
                    <td><?= $this->Number->format($orderSupport->total) ?></td>
                    <td><?= h($orderSupport->unit) ?></td>
                    <td><?= h($orderSupport->approval_note) ?></td>
                    <td><?= h($orderSupport->status) ?></td>
                    <td><?= h($orderSupport->is_active) ?></td>
                    <td><?= h($orderSupport->is_delete) ?></td>
                    <td><?= h($orderSupport->created) ?></td>
                    <td><?= h($orderSupport->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $orderSupport->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderSupport->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderSupport->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderSupport->id)]) ?>
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
