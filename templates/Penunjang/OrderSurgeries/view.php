<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderSurgery $orderSurgery
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Surgery'), ['action' => 'edit', $orderSurgery->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Surgery'), ['action' => 'delete', $orderSurgery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderSurgery->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Surgeries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Surgery'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderSurgeries view content">
            <h3><?= h($orderSurgery->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $orderSurgery->has('order') ? $this->Html->link($orderSurgery->order->id, ['prefix' => 'Farmasi', 'controller' => 'Orders', 'action' => 'view', $orderSurgery->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $orderSurgery->has('registration') ? $this->Html->link($orderSurgery->registration->id, ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'view', $orderSurgery->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $orderSurgery->has('patient') ? $this->Html->link($orderSurgery->patient->id, ['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'view', $orderSurgery->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $orderSurgery->has('doctor') ? $this->Html->link($orderSurgery->doctor->doctor_name, ['prefix' => 'Master', 'controller' => 'Doctors', 'action' => 'view', $orderSurgery->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Operator Name') ?></th>
                    <td><?= h($orderSurgery->operator_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Surgery Code') ?></th>
                    <td><?= h($orderSurgery->surgery_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Surgery Name') ?></th>
                    <td><?= h($orderSurgery->surgery_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($orderSurgery->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approval Note') ?></th>
                    <td><?= h($orderSurgery->approval_note) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Queue No') ?></th>
                    <td><?= h($orderSurgery->approved_queue_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Operating Room') ?></th>
                    <td><?= h($orderSurgery->operating_room) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Operator') ?></th>
                    <td><?= h($orderSurgery->approved_operator) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Surgery Name') ?></th>
                    <td><?= h($orderSurgery->approved_surgery_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Anesthesia Type') ?></th>
                    <td><?= h($orderSurgery->anesthesia_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved By') ?></th>
                    <td><?= h($orderSurgery->approved_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($orderSurgery->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderSurgery->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Operator Id') ?></th>
                    <td><?= $this->Number->format($orderSurgery->operator_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Operation Type Id') ?></th>
                    <td><?= $this->Number->format($orderSurgery->operation_type_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tariff') ?></th>
                    <td><?= $this->Number->format($orderSurgery->tariff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Surgery Date') ?></th>
                    <td><?= h($orderSurgery->surgery_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Surgery Time') ?></th>
                    <td><?= h($orderSurgery->surgery_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Date') ?></th>
                    <td><?= h($orderSurgery->approved_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Time') ?></th>
                    <td><?= h($orderSurgery->approved_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($orderSurgery->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($orderSurgery->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $orderSurgery->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $orderSurgery->is_delete ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($orderSurgery->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
