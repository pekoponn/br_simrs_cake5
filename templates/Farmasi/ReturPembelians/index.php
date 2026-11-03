<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReturPembelian[]|\Cake\Collection\CollectionInterface $returPembelians
 */
?>
<div class="returPembelians index content">
    <?= $this->Html->link(__('New Retur Pembelian'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Retur Pembelians') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('retur_no') ?></th>
                    <th><?= $this->Paginator->sort('tgl_retur') ?></th>
                    <th><?= $this->Paginator->sort('bapb_no') ?></th>
                    <th><?= $this->Paginator->sort('no_faktur') ?></th>
                    <th><?= $this->Paginator->sort('gudang_depo') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('nama_supplier') ?></th>
                    <th><?= $this->Paginator->sort('catatan') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($returPembelians as $returPembelian): ?>
                <tr>
                    <td><?= $this->Number->format($returPembelian->id) ?></td>
                    <td><?= h($returPembelian->retur_no) ?></td>
                    <td><?= h($returPembelian->tgl_retur) ?></td>
                    <td><?= h($returPembelian->bapb_no) ?></td>
                    <td><?= h($returPembelian->no_faktur) ?></td>
                    <td><?= h($returPembelian->gudang_depo) ?></td>
                    <td><?= $this->Number->format($returPembelian->supplier_id) ?></td>
                    <td><?= h($returPembelian->nama_supplier) ?></td>
                    <td><?= h($returPembelian->catatan) ?></td>
                    <td><?= $this->Number->format($returPembelian->total) ?></td>
                    <td><?= h($returPembelian->created) ?></td>
                    <td><?= h($returPembelian->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $returPembelian->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $returPembelian->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $returPembelian->id], ['confirm' => __('Are you sure you want to delete # {0}?', $returPembelian->id)]) ?>
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
