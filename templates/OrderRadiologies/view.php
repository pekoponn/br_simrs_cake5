<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderRadiology $orderRadiology
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Radiology'), ['action' => 'edit', $orderRadiology->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Radiology'), ['action' => 'delete', $orderRadiology->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderRadiology->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Radiologies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Radiology'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderRadiologies view content">
            <h3><?= h($orderRadiology->examination_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $orderRadiology->has('order') ? $this->Html->link($orderRadiology->order->id, ['controller' => 'Orders', 'action' => 'view', $orderRadiology->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Master Tindakan') ?></th>
                    <td><?= $orderRadiology->has('master_tindakan') ? $this->Html->link($orderRadiology->master_tindakan->id, ['controller' => 'MasterTindakan', 'action' => 'view', $orderRadiology->master_tindakan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($orderRadiology->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Examination Name') ?></th>
                    <td><?= h($orderRadiology->examination_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approval Note') ?></th>
                    <td><?= h($orderRadiology->approval_note) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderRadiology->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($orderRadiology->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($orderRadiology->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($orderRadiology->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
