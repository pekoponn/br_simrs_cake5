<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPembelian[]|\Cake\Collection\CollectionInterface $orderPembelians
 */
?>
<div class="orderPembelians index content">
    <?= $this->Html->link(__('New Order Pembelian'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Order Pembelians') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('po_no') ?></th>
                    <th><?= $this->Paginator->sort('tgl_po') ?></th>
                    <th><?= $this->Paginator->sort('ref_no') ?></th>
                    <th><?= $this->Paginator->sort('tgl_kirim') ?></th>
                    <th><?= $this->Paginator->sort('kirim_via') ?></th>
                    <th><?= $this->Paginator->sort('jenis') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderPembelians as $orderPembelian): ?>
                <tr>
                    <td><?= $this->Number->format($orderPembelian->id) ?></td>
                    <td><?= $this->Number->format($orderPembelian->supplier_id) ?></td>
                    <td><?= h($orderPembelian->po_no) ?></td>
                    <td><?= h($orderPembelian->tgl_po) ?></td>
                    <td><?= h($orderPembelian->ref_no) ?></td>
                    <td><?= h($orderPembelian->tgl_kirim) ?></td>
                    <td><?= h($orderPembelian->kirim_via) ?></td>
                    <td><?= h($orderPembelian->jenis) ?></td>
                    <td><?= $this->Number->format($orderPembelian->total) ?></td>
                    <td><?= h($orderPembelian->status) ?></td>
                    <td><?= h($orderPembelian->created) ?></td>
                    <td><?= h($orderPembelian->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $orderPembelian->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderPembelian->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderPembelian->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderPembelian->id)]) ?>
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
