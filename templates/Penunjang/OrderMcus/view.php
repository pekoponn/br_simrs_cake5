<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderMcus $orderMcus
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Mcus'), ['action' => 'edit', $orderMcus->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Mcus'), ['action' => 'delete', $orderMcus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderMcus->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Mcus'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Mcus'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderMcus view content">
            <h3><?= h($orderMcus->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $orderMcus->has('order') ? $this->Html->link($orderMcus->order->id, ['prefix' => 'Farmasi', 'controller' => 'Orders', 'action' => 'view', $orderMcus->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $orderMcus->has('registration') ? $this->Html->link($orderMcus->registration->id, ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'view', $orderMcus->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $orderMcus->has('patient') ? $this->Html->link($orderMcus->patient->id, ['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'view', $orderMcus->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $orderMcus->has('doctor') ? $this->Html->link($orderMcus->doctor->doctor_name, ['prefix' => 'Master', 'controller' => 'Doctors', 'action' => 'view', $orderMcus->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Mcu Type') ?></th>
                    <td><?= h($orderMcus->mcu_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($orderMcus->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderMcus->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mcu Date') ?></th>
                    <td><?= h($orderMcus->mcu_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mcu Time') ?></th>
                    <td><?= h($orderMcus->mcu_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($orderMcus->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($orderMcus->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $orderMcus->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $orderMcus->is_delete ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($orderMcus->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
