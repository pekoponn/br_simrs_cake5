<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderStatus $orderStatus
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Status'), ['action' => 'edit', $orderStatus->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Status'), ['action' => 'delete', $orderStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderStatus->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Statuses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Status'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderStatuses view content">
            <h3><?= h($orderStatus->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Kode') ?></th>
                    <td><?= h($orderStatus->kode) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nama') ?></th>
                    <td><?= h($orderStatus->nama) ?></td>
                </tr>
                <tr>
                    <th><?= __('Warna') ?></th>
                    <td><?= h($orderStatus->warna) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderStatus->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Urutan') ?></th>
                    <td><?= $this->Number->format($orderStatus->urutan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($orderStatus->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($orderStatus->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
