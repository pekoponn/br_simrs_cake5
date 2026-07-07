<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderSurgery[]|\Cake\Collection\CollectionInterface $orderSurgeries
 */
?>
<div class="orderSurgeries index content">
    <?= $this->Html->link(__('New Order Surgery'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Order Surgeries') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('order_id') ?></th>
                    <th><?= $this->Paginator->sort('registration_id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('doctor_id') ?></th>
                    <th><?= $this->Paginator->sort('surgery_date') ?></th>
                    <th><?= $this->Paginator->sort('surgery_time') ?></th>
                    <th><?= $this->Paginator->sort('operator_id') ?></th>
                    <th><?= $this->Paginator->sort('operator_name') ?></th>
                    <th><?= $this->Paginator->sort('operation_type_id') ?></th>
                    <th><?= $this->Paginator->sort('surgery_code') ?></th>
                    <th><?= $this->Paginator->sort('surgery_name') ?></th>
                    <th><?= $this->Paginator->sort('tariff') ?></th>
                    <th><?= $this->Paginator->sort('unit') ?></th>
                    <th><?= $this->Paginator->sort('approval_note') ?></th>
                    <th><?= $this->Paginator->sort('approved_queue_no') ?></th>
                    <th><?= $this->Paginator->sort('approved_date') ?></th>
                    <th><?= $this->Paginator->sort('approved_time') ?></th>
                    <th><?= $this->Paginator->sort('operating_room') ?></th>
                    <th><?= $this->Paginator->sort('approved_operator') ?></th>
                    <th><?= $this->Paginator->sort('approved_surgery_name') ?></th>
                    <th><?= $this->Paginator->sort('anesthesia_type') ?></th>
                    <th><?= $this->Paginator->sort('approved_by') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderSurgeries as $orderSurgery): ?>
                <tr>
                    <td><?= $this->Number->format($orderSurgery->id) ?></td>
                    <td><?= $orderSurgery->has('order') ? $this->Html->link($orderSurgery->order->id, ['controller' => 'Orders', 'action' => 'view', $orderSurgery->order->id]) : '' ?></td>
                    <td><?= $orderSurgery->has('registration') ? $this->Html->link($orderSurgery->registration->id, ['controller' => 'Registrations', 'action' => 'view', $orderSurgery->registration->id]) : '' ?></td>
                    <td><?= $orderSurgery->has('patient') ? $this->Html->link($orderSurgery->patient->id, ['controller' => 'Patients', 'action' => 'view', $orderSurgery->patient->id]) : '' ?></td>
                    <td><?= $orderSurgery->has('doctor') ? $this->Html->link($orderSurgery->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $orderSurgery->doctor->id]) : '' ?></td>
                    <td><?= h($orderSurgery->surgery_date) ?></td>
                    <td><?= h($orderSurgery->surgery_time) ?></td>
                    <td><?= $this->Number->format($orderSurgery->operator_id) ?></td>
                    <td><?= h($orderSurgery->operator_name) ?></td>
                    <td><?= $this->Number->format($orderSurgery->operation_type_id) ?></td>
                    <td><?= h($orderSurgery->surgery_code) ?></td>
                    <td><?= h($orderSurgery->surgery_name) ?></td>
                    <td><?= $this->Number->format($orderSurgery->tariff) ?></td>
                    <td><?= h($orderSurgery->unit) ?></td>
                    <td><?= h($orderSurgery->approval_note) ?></td>
                    <td><?= h($orderSurgery->approved_queue_no) ?></td>
                    <td><?= h($orderSurgery->approved_date) ?></td>
                    <td><?= h($orderSurgery->approved_time) ?></td>
                    <td><?= h($orderSurgery->operating_room) ?></td>
                    <td><?= h($orderSurgery->approved_operator) ?></td>
                    <td><?= h($orderSurgery->approved_surgery_name) ?></td>
                    <td><?= h($orderSurgery->anesthesia_type) ?></td>
                    <td><?= h($orderSurgery->approved_by) ?></td>
                    <td><?= h($orderSurgery->status) ?></td>
                    <td><?= h($orderSurgery->is_active) ?></td>
                    <td><?= h($orderSurgery->is_delete) ?></td>
                    <td><?= h($orderSurgery->created) ?></td>
                    <td><?= h($orderSurgery->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $orderSurgery->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderSurgery->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderSurgery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderSurgery->id)]) ?>
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
