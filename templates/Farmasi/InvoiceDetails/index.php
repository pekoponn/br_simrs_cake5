<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceDetail[]|\Cake\Collection\CollectionInterface $invoiceDetails
 */
?>
<div class="invoiceDetails index content">
    <?= $this->Html->link(__('New Invoice Detail'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invoice Details') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('invoice_id') ?></th>
                    <th><?= $this->Paginator->sort('medicine_id') ?></th>
                    <th><?= $this->Paginator->sort('kode_barang') ?></th>
                    <th><?= $this->Paginator->sort('nama_barang') ?></th>
                    <th><?= $this->Paginator->sort('qty') ?></th>
                    <th><?= $this->Paginator->sort('satuan') ?></th>
                    <th><?= $this->Paginator->sort('harga') ?></th>
                    <th><?= $this->Paginator->sort('discount_percent') ?></th>
                    <th><?= $this->Paginator->sort('discount_rp') ?></th>
                    <th><?= $this->Paginator->sort('tax') ?></th>
                    <th><?= $this->Paginator->sort('total_harga') ?></th>
                    <th><?= $this->Paginator->sort('tgl_kadaluarsa') ?></th>
                    <th><?= $this->Paginator->sort('po_no') ?></th>
                    <th><?= $this->Paginator->sort('histori') ?></th>
                    <th><?= $this->Paginator->sort('nilai_diskon') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoiceDetails as $invoiceDetail): ?>
                <tr>
                    <td><?= $this->Number->format($invoiceDetail->id) ?></td>
                    <td><?= $invoiceDetail->has('invoice') ? $this->Html->link($invoiceDetail->invoice->id, ['prefix' => 'Farmasi', 'controller' => 'Invoices', 'action' => 'view', $invoiceDetail->invoice->id]) : '' ?></td>
                    <td><?= $invoiceDetail->has('medicine') ? $this->Html->link($invoiceDetail->medicine->name, ['prefix' => 'Farmasi', 'controller' => 'Medicines', 'action' => 'view', $invoiceDetail->medicine->id]) : '' ?></td>
                    <td><?= h($invoiceDetail->kode_barang) ?></td>
                    <td><?= h($invoiceDetail->nama_barang) ?></td>
                    <td><?= $this->Number->format($invoiceDetail->qty) ?></td>
                    <td><?= h($invoiceDetail->satuan) ?></td>
                    <td><?= $this->Number->format($invoiceDetail->harga) ?></td>
                    <td><?= $this->Number->format($invoiceDetail->discount_percent) ?></td>
                    <td><?= $this->Number->format($invoiceDetail->discount_rp) ?></td>
                    <td><?= $this->Number->format($invoiceDetail->tax) ?></td>
                    <td><?= $this->Number->format($invoiceDetail->total_harga) ?></td>
                    <td><?= h($invoiceDetail->tgl_kadaluarsa) ?></td>
                    <td><?= h($invoiceDetail->po_no) ?></td>
                    <td><?= h($invoiceDetail->histori) ?></td>
                    <td><?= $this->Number->format($invoiceDetail->nilai_diskon) ?></td>
                    <td><?= h($invoiceDetail->created) ?></td>
                    <td><?= h($invoiceDetail->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invoiceDetail->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoiceDetail->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoiceDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceDetail->id)]) ?>
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
