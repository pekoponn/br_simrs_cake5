<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invoice'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="invoices view content">
            <h3><?= h($invoice->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Bapb No') ?></th>
                    <td><?= h($invoice->bapb_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nama Supplier') ?></th>
                    <td><?= h($invoice->nama_supplier) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Faktur') ?></th>
                    <td><?= h($invoice->no_faktur) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sj No') ?></th>
                    <td><?= h($invoice->sj_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Kurs') ?></th>
                    <td><?= h($invoice->kurs) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pembayaran') ?></th>
                    <td><?= h($invoice->pembayaran) ?></td>
                </tr>
                <tr>
                    <th><?= __('Diterima Lokasi Gudang') ?></th>
                    <td><?= h($invoice->diterima_lokasi_gudang) ?></td>
                </tr>
                <tr>
                    <th><?= __('Materai') ?></th>
                    <td><?= h($invoice->materai) ?></td>
                </tr>
                <tr>
                    <th><?= __('Catatan') ?></th>
                    <td><?= h($invoice->catatan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($invoice->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier Id') ?></th>
                    <td><?= $this->Number->format($invoice->supplier_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rate') ?></th>
                    <td><?= $this->Number->format($invoice->rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Percent') ?></th>
                    <td><?= $this->Number->format($invoice->discount_percent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Rp') ?></th>
                    <td><?= $this->Number->format($invoice->discount_rp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ongkos Kirim') ?></th>
                    <td><?= $this->Number->format($invoice->ongkos_kirim) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($invoice->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grand Total') ?></th>
                    <td><?= $this->Number->format($invoice->grand_total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Terima') ?></th>
                    <td><?= h($invoice->tgl_terima) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Tukar Faktur') ?></th>
                    <td><?= h($invoice->tgl_tukar_faktur) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Jatuh Tempo') ?></th>
                    <td><?= h($invoice->tgl_jatuh_tempo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($invoice->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($invoice->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Invoice Details') ?></h4>
                <?php if (!empty($invoice->invoice_details)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Medicine Id') ?></th>
                            <th><?= __('Kode Barang') ?></th>
                            <th><?= __('Nama Barang') ?></th>
                            <th><?= __('Qty') ?></th>
                            <th><?= __('Satuan') ?></th>
                            <th><?= __('Harga') ?></th>
                            <th><?= __('Discount Percent') ?></th>
                            <th><?= __('Discount Rp') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Total Harga') ?></th>
                            <th><?= __('Tgl Kadaluarsa') ?></th>
                            <th><?= __('Po No') ?></th>
                            <th><?= __('Histori') ?></th>
                            <th><?= __('Nilai Diskon') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($invoice->invoice_details as $invoiceDetails) : ?>
                        <tr>
                            <td><?= h($invoiceDetails->id) ?></td>
                            <td><?= h($invoiceDetails->invoice_id) ?></td>
                            <td><?= h($invoiceDetails->medicine_id) ?></td>
                            <td><?= h($invoiceDetails->kode_barang) ?></td>
                            <td><?= h($invoiceDetails->nama_barang) ?></td>
                            <td><?= h($invoiceDetails->qty) ?></td>
                            <td><?= h($invoiceDetails->satuan) ?></td>
                            <td><?= h($invoiceDetails->harga) ?></td>
                            <td><?= h($invoiceDetails->discount_percent) ?></td>
                            <td><?= h($invoiceDetails->discount_rp) ?></td>
                            <td><?= h($invoiceDetails->tax) ?></td>
                            <td><?= h($invoiceDetails->total_harga) ?></td>
                            <td><?= h($invoiceDetails->tgl_kadaluarsa) ?></td>
                            <td><?= h($invoiceDetails->po_no) ?></td>
                            <td><?= h($invoiceDetails->histori) ?></td>
                            <td><?= h($invoiceDetails->nilai_diskon) ?></td>
                            <td><?= h($invoiceDetails->created) ?></td>
                            <td><?= h($invoiceDetails->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['prefix' => 'Farmasi', 'controller' => 'InvoiceDetails', 'action' => 'view', $invoiceDetails->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['prefix' => 'Farmasi', 'controller' => 'InvoiceDetails', 'action' => 'edit', $invoiceDetails->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['prefix' => 'Farmasi', 'controller' => 'InvoiceDetails', 'action' => 'delete', $invoiceDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceDetails->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
