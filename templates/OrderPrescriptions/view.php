<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPrescription $orderPrescription
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Prescription'), ['action' => 'edit', $orderPrescription->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Prescription'), ['action' => 'delete', $orderPrescription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderPrescription->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Prescriptions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Prescription'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderPrescriptions view content">
            <h3><?= h($orderPrescription->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $orderPrescription->has('order') ? $this->Html->link($orderPrescription->order->id, ['controller' => 'Orders', 'action' => 'view', $orderPrescription->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Aturan Pakai') ?></th>
                    <td><?= h($orderPrescription->aturan_pakai) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderPrescription->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Medicine Id') ?></th>
                    <td><?= $this->Number->format($orderPrescription->medicine_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Medicine Unit') ?></th>
                    <td><?= h($orderPrescription->medicine_unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jml Per Hari') ?></th>
                    <td><?= $this->Number->format($orderPrescription->jml_per_hari) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty Min') ?></th>
                    <td><?= $this->Number->format($orderPrescription->qty_min) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jml Hari') ?></th>
                    <td><?= $this->Number->format($orderPrescription->jml_hari) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty Satuan') ?></th>
                    <td><?= $this->Number->format($orderPrescription->qty_satuan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Harga') ?></th>
                    <td><?= $this->Number->format($orderPrescription->harga) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Harga') ?></th>
                    <td><?= $this->Number->format($orderPrescription->total_harga) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($orderPrescription->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($orderPrescription->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Kronis') ?></th>
                    <td><?= $orderPrescription->is_kronis ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Keterangan') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($orderPrescription->keterangan)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
