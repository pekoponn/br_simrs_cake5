<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPrescription[]|\Cake\Collection\CollectionInterface $orderPrescriptions
 */
?>
<div class="orderPrescriptions index content">
    <?= $this->Html->link(__('New Order Prescription'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Order Prescriptions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('order_id') ?></th>
                    <th><?= $this->Paginator->sort('medicine_id') ?></th>
                    <th><?= $this->Paginator->sort('medicine_unit') ?></th>
                    <th><?= $this->Paginator->sort('is_kronis') ?></th>
                    <th><?= $this->Paginator->sort('jml_per_hari') ?></th>
                    <th><?= $this->Paginator->sort('qty_min') ?></th>
                    <th><?= $this->Paginator->sort('jml_hari') ?></th>
                    <th><?= $this->Paginator->sort('qty_satuan') ?></th>
                    <th><?= $this->Paginator->sort('aturan_pakai') ?></th>
                    <th><?= $this->Paginator->sort('harga') ?></th>
                    <th><?= $this->Paginator->sort('total_harga') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderPrescriptions as $orderPrescription): ?>
                <tr>
                    <td><?= $this->Number->format($orderPrescription->id) ?></td>
                    <td><?= $orderPrescription->has('order') ? $this->Html->link($orderPrescription->order->id, ['controller' => 'Orders', 'action' => 'view', $orderPrescription->order->id]) : '' ?></td>
                    <td><?= $this->Number->format($orderPrescription->medicine_id) ?></td>
                    <td><?= h($orderPrescription->medicine_unit) ?></td>
                    <td><?= h($orderPrescription->is_kronis) ?></td>
                    <td><?= $this->Number->format($orderPrescription->jml_per_hari) ?></td>
                    <td><?= $this->Number->format($orderPrescription->qty_min) ?></td>
                    <td><?= $this->Number->format($orderPrescription->jml_hari) ?></td>
                    <td><?= $this->Number->format($orderPrescription->qty_satuan) ?></td>
                    <td><?= h($orderPrescription->aturan_pakai) ?></td>
                    <td><?= $this->Number->format($orderPrescription->harga) ?></td>
                    <td><?= $this->Number->format($orderPrescription->total_harga) ?></td>
                    <td><?= h($orderPrescription->created) ?></td>
                    <td><?= h($orderPrescription->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $orderPrescription->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderPrescription->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderPrescription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderPrescription->id)]) ?>
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
