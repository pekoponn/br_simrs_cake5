<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $orders
 */
?>

<div class="orders content" style="font-size:12px;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
            <i class="fa fa-file-prescription"></i> E-Order — Daftar Order
        </h4>
    </div>

    <div class="panel panel-default">
        <div class="panel-body" style="padding:0;">
            <table class="table table-condensed table-hover table-bordered" style="font-size:11px; margin:0;">
                <thead>
                    <tr style="background:#1e3a5f; color:#fff;">
                        <th>No Order</th>
                        <th>Tgl Order</th>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>Dokter</th>
                        <th>Depo</th>
                        <th>Status</th>
                        <th style="width:80px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <?php $p = $order->patient ?? null; $d = $order->doctor ?? null; $s = $order->order_status ?? null; ?>
                    <tr>
                        <td style="font-family:monospace; font-weight:600; color:#1e3a5f;">
                            <?= h($order->no_order) ?>
                        </td>
                        <td><?= $order->tgl_order->format('d-m-Y H:i') ?></td>
                        <td><?= h($p->code ?? '-') ?></td>
                        <td><strong><?= h($p->full_name ?? '-') ?></strong></td>
                        <td><?= h($d->doctor_name ?? '-') ?></td>
                          <td style="font-size:10px;"><?= h($order->lokasi_depo ?? '-') ?></td>
                        <td>
                            <span class="label" style="background:<?= h($s->warna ?? '#6c757d') ?>; color:#fff;">
                                <?= h($s->nama ?? '-') ?>
                            </span>
                        </td>
                        <td>
                            <?= $this->Html->link('<i class="fa fa-eye"></i>',
                                ['action' => 'detail', $order->id],
                                ['escape' => false, 'class' => 'btn btn-xs btn-info',
                                 'title' => 'Detail', 'data-toggle' => 'tooltip']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (!count($orders)): ?>
                    <tr><td colspan="8" style="text-align:center; padding:20px; color:#aaa;">
                        <i class="fa fa-inbox"></i> Belum ada data order
                    </td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer" style="padding:6px 12px;">
            <?= $this->Paginator->numbers() ?>
        </div>
    </div>

</div>