<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RencanaPembelian $rencanaPembelian
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Rencana Pembelian'), ['action' => 'edit', $rencanaPembelian->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Rencana Pembelian'), ['action' => 'delete', $rencanaPembelian->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rencanaPembelian->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Rencana Pembelians'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Rencana Pembelian'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="rencanaPembelians view content">
            <h3><?= h($rencanaPembelian->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('No Perencanaan') ?></th>
                    <td><?= h($rencanaPembelian->no_perencanaan) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Dokumen') ?></th>
                    <td><?= h($rencanaPembelian->no_dokumen) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($rencanaPembelian->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nama Supplier') ?></th>
                    <td><?= h($rencanaPembelian->nama_supplier) ?></td>
                </tr>
                <tr>
                    <th><?= __('Diminta Oleh') ?></th>
                    <td><?= h($rencanaPembelian->diminta_oleh) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($rencanaPembelian->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier Id') ?></th>
                    <td><?= $this->Number->format($rencanaPembelian->supplier_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Qty Permintaan') ?></th>
                    <td><?= $this->Number->format($rencanaPembelian->total_qty_permintaan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Permintaan') ?></th>
                    <td><?= $this->Number->format($rencanaPembelian->total_permintaan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Perencanaan') ?></th>
                    <td><?= h($rencanaPembelian->tgl_perencanaan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($rencanaPembelian->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($rencanaPembelian->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Rencana Pembelian Details') ?></h4>
                <?php if (!empty($rencanaPembelian->rencana_pembelian_details)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Rencana Pembelian Id') ?></th>
                            <th><?= __('Medicine Id') ?></th>
                            <th><?= __('Kode Barang') ?></th>
                            <th><?= __('Nama Barang') ?></th>
                            <th><?= __('Qty') ?></th>
                            <th><?= __('Harga') ?></th>
                            <th><?= __('Satuan') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Total Approv') ?></th>
                            <th><?= __('Is Obat') ?></th>
                            <th><?= __('Keterangan') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($rencanaPembelian->rencana_pembelian_details as $rencanaPembelianDetails) : ?>
                        <tr>
                            <td><?= h($rencanaPembelianDetails->id) ?></td>
                            <td><?= h($rencanaPembelianDetails->rencana_pembelian_id) ?></td>
                            <td><?= h($rencanaPembelianDetails->medicine_id) ?></td>
                            <td><?= h($rencanaPembelianDetails->kode_barang) ?></td>
                            <td><?= h($rencanaPembelianDetails->nama_barang) ?></td>
                            <td><?= h($rencanaPembelianDetails->qty) ?></td>
                            <td><?= h($rencanaPembelianDetails->harga) ?></td>
                            <td><?= h($rencanaPembelianDetails->satuan) ?></td>
                            <td><?= h($rencanaPembelianDetails->total) ?></td>
                            <td><?= h($rencanaPembelianDetails->total_approv) ?></td>
                            <td><?= h($rencanaPembelianDetails->is_obat) ?></td>
                            <td><?= h($rencanaPembelianDetails->keterangan) ?></td>
                            <td><?= h($rencanaPembelianDetails->created) ?></td>
                            <td><?= h($rencanaPembelianDetails->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'RencanaPembelianDetails', 'action' => 'view', $rencanaPembelianDetails->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'RencanaPembelianDetails', 'action' => 'edit', $rencanaPembelianDetails->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'RencanaPembelianDetails', 'action' => 'delete', $rencanaPembelianDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rencanaPembelianDetails->id)]) ?>
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
