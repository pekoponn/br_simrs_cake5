<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReturPembelian $returPembelian
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Retur Pembelian'), ['action' => 'edit', $returPembelian->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Retur Pembelian'), ['action' => 'delete', $returPembelian->id], ['confirm' => __('Are you sure you want to delete # {0}?', $returPembelian->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Retur Pembelians'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Retur Pembelian'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="returPembelians view content">
            <h3><?= h($returPembelian->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Retur No') ?></th>
                    <td><?= h($returPembelian->retur_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bapb No') ?></th>
                    <td><?= h($returPembelian->bapb_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Faktur') ?></th>
                    <td><?= h($returPembelian->no_faktur) ?></td>
                </tr>
                <tr>
                    <th><?= __('Gudang Depo') ?></th>
                    <td><?= h($returPembelian->gudang_depo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nama Supplier') ?></th>
                    <td><?= h($returPembelian->nama_supplier) ?></td>
                </tr>
                <tr>
                    <th><?= __('Catatan') ?></th>
                    <td><?= h($returPembelian->catatan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($returPembelian->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier Id') ?></th>
                    <td><?= $this->Number->format($returPembelian->supplier_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($returPembelian->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Retur') ?></th>
                    <td><?= h($returPembelian->tgl_retur) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($returPembelian->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($returPembelian->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Retur Pembelian Details') ?></h4>
                <?php if (!empty($returPembelian->retur_pembelian_details)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Retur Pembelian Id') ?></th>
                            <th><?= __('Medicine Id') ?></th>
                            <th><?= __('Kode Barang') ?></th>
                            <th><?= __('Nama Barang') ?></th>
                            <th><?= __('Qty') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Harga') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Ppn Rp') ?></th>
                            <th><?= __('Discount') ?></th>
                            <th><?= __('Total Harga') ?></th>
                            <th><?= __('Tgl Kadaluarsa') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($returPembelian->retur_pembelian_details as $returPembelianDetails) : ?>
                        <tr>
                            <td><?= h($returPembelianDetails->id) ?></td>
                            <td><?= h($returPembelianDetails->retur_pembelian_id) ?></td>
                            <td><?= h($returPembelianDetails->medicine_id) ?></td>
                            <td><?= h($returPembelianDetails->kode_barang) ?></td>
                            <td><?= h($returPembelianDetails->nama_barang) ?></td>
                            <td><?= h($returPembelianDetails->qty) ?></td>
                            <td><?= h($returPembelianDetails->unit) ?></td>
                            <td><?= h($returPembelianDetails->harga) ?></td>
                            <td><?= h($returPembelianDetails->tax) ?></td>
                            <td><?= h($returPembelianDetails->ppn_rp) ?></td>
                            <td><?= h($returPembelianDetails->discount) ?></td>
                            <td><?= h($returPembelianDetails->total_harga) ?></td>
                            <td><?= h($returPembelianDetails->tgl_kadaluarsa) ?></td>
                            <td><?= h($returPembelianDetails->created) ?></td>
                            <td><?= h($returPembelianDetails->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ReturPembelianDetails', 'action' => 'view', $returPembelianDetails->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ReturPembelianDetails', 'action' => 'edit', $returPembelianDetails->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ReturPembelianDetails', 'action' => 'delete', $returPembelianDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $returPembelianDetails->id)]) ?>
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
