<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice[]|\Cake\Collection\CollectionInterface $invoices
 */
?>
<div class="invoices index content">
    <?= $this->Html->link(__('New Invoice'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invoices') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('bapb_no') ?></th>
                    <th><?= $this->Paginator->sort('nama_supplier') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('tgl_terima') ?></th>
                    <th><?= $this->Paginator->sort('no_faktur') ?></th>
                    <th><?= $this->Paginator->sort('sj_no') ?></th>
                    <th><?= $this->Paginator->sort('tgl_tukar_faktur') ?></th>
                    <th><?= $this->Paginator->sort('kurs') ?></th>
                    <th><?= $this->Paginator->sort('rate') ?></th>
                    <th><?= $this->Paginator->sort('pembayaran') ?></th>
                    <th><?= $this->Paginator->sort('tgl_jatuh_tempo') ?></th>
                    <th><?= $this->Paginator->sort('diterima_lokasi_gudang') ?></th>
                    <th><?= $this->Paginator->sort('materai') ?></th>
                    <th><?= $this->Paginator->sort('discount_percent') ?></th>
                    <th><?= $this->Paginator->sort('discount_rp') ?></th>
                    <th><?= $this->Paginator->sort('ongkos_kirim') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('grand_total') ?></th>
                    <th><?= $this->Paginator->sort('catatan') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td><?= $this->Number->format($invoice->id) ?></td>
                    <td><?= h($invoice->bapb_no) ?></td>
                    <td><?= h($invoice->nama_supplier) ?></td>
                    <td><?= $this->Number->format($invoice->supplier_id) ?></td>
                    <td><?= h($invoice->tgl_terima) ?></td>
                    <td><?= h($invoice->no_faktur) ?></td>
                    <td><?= h($invoice->sj_no) ?></td>
                    <td><?= h($invoice->tgl_tukar_faktur) ?></td>
                    <td><?= h($invoice->kurs) ?></td>
                    <td><?= $this->Number->format($invoice->rate) ?></td>
                    <td><?= h($invoice->pembayaran) ?></td>
                    <td><?= h($invoice->tgl_jatuh_tempo) ?></td>
                    <td><?= h($invoice->diterima_lokasi_gudang) ?></td>
                    <td><?= h($invoice->materai) ?></td>
                    <td><?= $this->Number->format($invoice->discount_percent) ?></td>
                    <td><?= $this->Number->format($invoice->discount_rp) ?></td>
                    <td><?= $this->Number->format($invoice->ongkos_kirim) ?></td>
                    <td><?= $this->Number->format($invoice->total) ?></td>
                    <td><?= $this->Number->format($invoice->grand_total) ?></td>
                    <td><?= h($invoice->catatan) ?></td>
                    <td><?= h($invoice->created) ?></td>
                    <td><?= h($invoice->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invoice->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoice->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?>
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
