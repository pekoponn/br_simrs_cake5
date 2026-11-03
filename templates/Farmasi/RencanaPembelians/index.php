<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RencanaPembelian[]|\Cake\Collection\CollectionInterface $rencanaPembelians
 */
?>
<div class="rencanaPembelians index content">
    <?= $this->Html->link(__('New Rencana Pembelian'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Rencana Pembelians') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('no_perencanaan') ?></th>
                    <th><?= $this->Paginator->sort('tgl_perencanaan') ?></th>
                    <th><?= $this->Paginator->sort('no_dokumen') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('nama_supplier') ?></th>
                    <th><?= $this->Paginator->sort('diminta_oleh') ?></th>
                    <th><?= $this->Paginator->sort('total_qty_permintaan') ?></th>
                    <th><?= $this->Paginator->sort('total_permintaan') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rencanaPembelians as $rencanaPembelian): ?>
                <tr>
                    <td><?= $this->Number->format($rencanaPembelian->id) ?></td>
                    <td><?= h($rencanaPembelian->no_perencanaan) ?></td>
                    <td><?= h($rencanaPembelian->tgl_perencanaan) ?></td>
                    <td><?= h($rencanaPembelian->no_dokumen) ?></td>
                    <td><?= h($rencanaPembelian->status) ?></td>
                    <td><?= $this->Number->format($rencanaPembelian->supplier_id) ?></td>
                    <td><?= h($rencanaPembelian->nama_supplier) ?></td>
                    <td><?= h($rencanaPembelian->diminta_oleh) ?></td>
                    <td><?= $this->Number->format($rencanaPembelian->total_qty_permintaan) ?></td>
                    <td><?= $this->Number->format($rencanaPembelian->total_permintaan) ?></td>
                    <td><?= h($rencanaPembelian->created) ?></td>
                    <td><?= h($rencanaPembelian->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $rencanaPembelian->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rencanaPembelian->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rencanaPembelian->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rencanaPembelian->id)]) ?>
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
