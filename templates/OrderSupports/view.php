<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderSupport $orderSupport
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Support'), ['action' => 'edit', $orderSupport->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Support'), ['action' => 'delete', $orderSupport->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderSupport->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Supports'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Support'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderSupports view content">
            <h3><?= h($orderSupport->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $orderSupport->has('order') ? $this->Html->link($orderSupport->order->id, ['controller' => 'Orders', 'action' => 'view', $orderSupport->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $orderSupport->has('registration') ? $this->Html->link($orderSupport->registration->id, ['controller' => 'Registrations', 'action' => 'view', $orderSupport->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $orderSupport->has('patient') ? $this->Html->link($orderSupport->patient->id, ['controller' => 'Patients', 'action' => 'view', $orderSupport->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $orderSupport->has('doctor') ? $this->Html->link($orderSupport->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $orderSupport->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Support Code') ?></th>
                    <td><?= h($orderSupport->support_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Support Name') ?></th>
                    <td><?= h($orderSupport->support_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($orderSupport->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approval Note') ?></th>
                    <td><?= h($orderSupport->approval_note) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($orderSupport->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderSupport->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tariff') ?></th>
                    <td><?= $this->Number->format($orderSupport->tariff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty') ?></th>
                    <td><?= $this->Number->format($orderSupport->qty) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($orderSupport->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($orderSupport->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($orderSupport->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $orderSupport->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $orderSupport->is_delete ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($orderSupport->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
