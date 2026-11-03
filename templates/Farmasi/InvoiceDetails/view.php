<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceDetail $invoiceDetail
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invoice Detail'), ['action' => 'edit', $invoiceDetail->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice Detail'), ['action' => 'delete', $invoiceDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceDetail->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoice Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invoice Detail'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="invoiceDetails view content">
            <h3><?= h($invoiceDetail->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Invoice') ?></th>
                    <td><?= $invoiceDetail->has('invoice') ? $this->Html->link($invoiceDetail->invoice->id, ['prefix' => 'Farmasi', 'controller' => 'Invoices', 'action' => 'view', $invoiceDetail->invoice->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Medicine') ?></th>
                    <td><?= $invoiceDetail->has('medicine') ? $this->Html->link($invoiceDetail->medicine->name, ['prefix' => 'Farmasi', 'controller' => 'Medicines', 'action' => 'view', $invoiceDetail->medicine->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Kode Barang') ?></th>
                    <td><?= h($invoiceDetail->kode_barang) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nama Barang') ?></th>
                    <td><?= h($invoiceDetail->nama_barang) ?></td>
                </tr>
                <tr>
                    <th><?= __('Satuan') ?></th>
                    <td><?= h($invoiceDetail->satuan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Po No') ?></th>
                    <td><?= h($invoiceDetail->po_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Histori') ?></th>
                    <td><?= h($invoiceDetail->histori) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($invoiceDetail->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty') ?></th>
                    <td><?= $this->Number->format($invoiceDetail->qty) ?></td>
                </tr>
                <tr>
                    <th><?= __('Harga') ?></th>
                    <td><?= $this->Number->format($invoiceDetail->harga) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Percent') ?></th>
                    <td><?= $this->Number->format($invoiceDetail->discount_percent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Rp') ?></th>
                    <td><?= $this->Number->format($invoiceDetail->discount_rp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tax') ?></th>
                    <td><?= $this->Number->format($invoiceDetail->tax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Harga') ?></th>
                    <td><?= $this->Number->format($invoiceDetail->total_harga) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nilai Diskon') ?></th>
                    <td><?= $this->Number->format($invoiceDetail->nilai_diskon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Kadaluarsa') ?></th>
                    <td><?= h($invoiceDetail->tgl_kadaluarsa) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($invoiceDetail->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($invoiceDetail->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
