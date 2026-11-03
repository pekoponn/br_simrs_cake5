<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPembelian $orderPembelian
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Pembelian'), ['action' => 'edit', $orderPembelian->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Pembelian'), ['action' => 'delete', $orderPembelian->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderPembelian->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Pembelians'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Pembelian'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderPembelians view content">
            <h3><?= h($orderPembelian->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Po No') ?></th>
                    <td><?= h($orderPembelian->po_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ref No') ?></th>
                    <td><?= h($orderPembelian->ref_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Kirim Via') ?></th>
                    <td><?= h($orderPembelian->kirim_via) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jenis') ?></th>
                    <td><?= h($orderPembelian->jenis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($orderPembelian->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderPembelian->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier Id') ?></th>
                    <td><?= $this->Number->format($orderPembelian->supplier_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($orderPembelian->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Po') ?></th>
                    <td><?= h($orderPembelian->tgl_po) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Kirim') ?></th>
                    <td><?= h($orderPembelian->tgl_kirim) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($orderPembelian->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($orderPembelian->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Barang Dikirim Ke') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($orderPembelian->barang_dikirim_ke)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Order Pembelian Details') ?></h4>
                <?php if (!empty($orderPembelian->order_pembelian_details)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Order Pembelian Id') ?></th>
                            <th><?= __('Barang Id') ?></th>
                            <th><?= __('Kode Barang') ?></th>
                            <th><?= __('Nama Barang') ?></th>
                            <th><?= __('Qty Rencana') ?></th>
                            <th><?= __('Qty Po') ?></th>
                            <th><?= __('Satuan') ?></th>
                            <th><?= __('Harga') ?></th>
                            <th><?= __('Discount') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Total Harga') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($orderPembelian->order_pembelian_details as $orderPembelianDetails) : ?>
                        <tr>
                            <td><?= h($orderPembelianDetails->id) ?></td>
                            <td><?= h($orderPembelianDetails->order_pembelian_id) ?></td>
                            <td><?= h($orderPembelianDetails->barang_id) ?></td>
                            <td><?= h($orderPembelianDetails->kode_barang) ?></td>
                            <td><?= h($orderPembelianDetails->nama_barang) ?></td>
                            <td><?= h($orderPembelianDetails->qty_rencana) ?></td>
                            <td><?= h($orderPembelianDetails->qty_po) ?></td>
                            <td><?= h($orderPembelianDetails->satuan) ?></td>
                            <td><?= h($orderPembelianDetails->harga) ?></td>
                            <td><?= h($orderPembelianDetails->discount) ?></td>
                            <td><?= h($orderPembelianDetails->tax) ?></td>
                            <td><?= h($orderPembelianDetails->total_harga) ?></td>
                            <td><?= h($orderPembelianDetails->created) ?></td>
                            <td><?= h($orderPembelianDetails->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OrderPembelianDetails', 'action' => 'view', $orderPembelianDetails->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OrderPembelianDetails', 'action' => 'edit', $orderPembelianDetails->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrderPembelianDetails', 'action' => 'delete', $orderPembelianDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderPembelianDetails->id)]) ?>
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
