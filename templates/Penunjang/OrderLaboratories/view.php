<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderLaboratory $orderLaboratory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Laboratory'), ['action' => 'edit', $orderLaboratory->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Laboratory'), ['action' => 'delete', $orderLaboratory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderLaboratory->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Laboratories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Laboratory'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderLaboratories view content">
            <h3><?= h($orderLaboratory->examination_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $orderLaboratory->has('order') ? $this->Html->link($orderLaboratory->order->id, ['prefix' => 'Farmasi', 'controller' => 'Orders', 'action' => 'view', $orderLaboratory->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Master Tindakan') ?></th>
                    <td><?= $orderLaboratory->has('master_tindakan') ? $this->Html->link($orderLaboratory->master_tindakan->id, ['prefix' => 'Master', 'controller' => 'MasterTindakan', 'action' => 'view', $orderLaboratory->master_tindakan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($orderLaboratory->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Examination Name') ?></th>
                    <td><?= h($orderLaboratory->examination_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approval Note') ?></th>
                    <td><?= h($orderLaboratory->approval_note) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderLaboratory->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($orderLaboratory->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($orderLaboratory->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($orderLaboratory->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
