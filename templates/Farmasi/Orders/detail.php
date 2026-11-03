<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
$p = $order->patient ?? null;
$d = $order->doctor ?? null;
$s = $order->order_status ?? null;
$r = $order->registration ?? null;
?>

<div class="orders content" style="font-size:12px;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
            <i class="fa fa-file-prescription"></i>
            Detail E-Order — <span style="font-family:monospace;"><?= h($order->no_order ?? '-') ?></span>
        </h4>
        <div style="display:flex; gap:6px;">
            <button onclick="window.print()" class="btn btn-default btn-sm">
                <i class="fa fa-print"></i> Cetak
            </button>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </div>
    </div>

    <div class="panel panel-default" style="margin-bottom:8px;">
        <div class="panel-body" style="padding:8px 12px; background:#f8f9fa; font-size:12px;">
            <div class="row">
                <div class="col-md-2">
                    <small style="color:#888;">No Order</small><br>
                    <strong style="font-family:monospace; color:#1e3a5f;"><?= h($order->no_order ?? '-') ?></strong>
                </div>

                <div class="col-md-2">
                    <small style="color:#888;">Tgl Order</small><br>
                    <strong>
                        <?= !empty($order->tgl_order) ? h($order->tgl_order->format('d-m-Y H:i')) : '-' ?>
                    </strong>
                </div>

                <div class="col-md-2">
                    <small style="color:#888;">No Registrasi</small><br>
                    <strong><?= h($r->registration_no ?? $r->registration_number ?? '-') ?></strong>
                </div>

                <div class="col-md-2">
                    <small style="color:#888;">No RM</small><br>
                    <strong><?= h($p->code ?? $p->medical_record_no ?? '-') ?></strong>
                </div>

                <div class="col-md-2">
                    <small style="color:#888;">Nama Pasien</small><br>
                    <strong><?= h($p->full_name ?? $p->nama ?? '-') ?></strong>
                </div>

                <div class="col-md-1">
                    <small style="color:#888;">Jaminan</small><br>
                    <strong style="color:#1e3a5f;">
                        <?= h($r->insurance_type ?? $r->payment_method ?? $p->jaminan ?? 'Umum') ?>
                    </strong>
                </div>

                <div class="col-md-1">
                    <small style="color:#888;">Status</small><br>
                    <span class="label" style="background:<?= h($s->warna ?? '#6c757d') ?>; color:#fff; font-size:11px; padding:3px 8px;">
                        <?= h($s->nama ?? '-') ?>
                    </span>
                </div>
            </div>

            <div class="row" style="margin-top:6px;">
                <div class="col-md-3">
                    <small style="color:#888;">Dokter</small><br>
                    <strong><?= h($d->doctor_name ?? $d->name ?? $d->nama ?? '-') ?></strong>
                </div>

                <div class="col-md-3">
                    <small style="color:#888;">Lokasi Depo</small><br>
                    <strong><?= h($order->lokasi_depo ?? '-') ?></strong>
                </div>

                <div class="col-md-6">
                    <small style="color:#888;">Pesan</small><br>
                    <strong><?= nl2br(h($order->pesan ?? '-')) ?></strong>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" style="padding:8px 12px; background:#1e3a5f;">
            <strong style="font-size:12px; color:#fff;">
                <i class="fa fa-pills"></i> Detail Resep
            </strong>
        </div>

        <div class="panel-body" style="padding:0;">
            <div style="overflow-x:auto;">
                <table class="table table-bordered table-sm" style="font-size:11px; min-width:900px; margin:0;">
                    <thead>
                        <tr style="background:#dbeafe;">
                            <th style="width:30px; text-align:center;">No</th>
                            <th style="width:90px;">Kode</th>
                            <th>Nama Obat</th>
                            <th style="width:40px; text-align:center;">K</th>
                            <th style="width:70px; text-align:center;">Jml/Hari</th>
                            <th style="width:60px; text-align:center;">Jml Hr</th>
                            <th style="width:70px; text-align:center;">Qty/Sat</th>
                            <th style="width:70px; text-align:center;">Satuan</th>
                            <th style="width:130px;">Aturan Pakai</th>
                            <th style="width:95px; text-align:right;">Harga</th>
                            <th style="width:100px; text-align:right;">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($order->order_prescriptions)): ?>
                            <?php $grandTotal = 0; ?>

                            <?php foreach ($order->order_prescriptions as $idx => $rx): ?>
                                <?php
                                    $medicine = $rx->medicine ?? null;
                                    $grandTotal += (float)($rx->total_harga ?? 0);
                                ?>
                                <tr>
                                    <td style="text-align:center; color:#888;"><?= $idx + 1 ?></td>

                                    <td style="font-family:monospace; font-size:10px;">
                                        <?= h($medicine->code ?? '-') ?>
                                    </td>

                                    <td>
                                        <strong><?= h($medicine->name ?? '-') ?></strong>

                                        <?php if (!empty($medicine->generic_name)): ?>
                                            <br>
                                            <span style="color:#888; font-size:10px;">
                                                <?= h($medicine->generic_name) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td style="text-align:center;">
                                        <?= !empty($rx->is_kronis) ? '<span class="label label-warning" style="font-size:9px;">K</span>' : '' ?>
                                    </td>

                                    <td style="text-align:center;"><?= h($rx->jml_per_hari ?? 0) ?></td>

                                    <td style="text-align:center;"><?= h($rx->jml_hari ?? 0) ?></td>

                                    <td style="text-align:center;"><?= h($rx->qty_satuan ?? 0) ?></td>

                                    <td style="text-align:center; font-size:10px;">
                                        <?= h($rx->medicine_unit ?? $medicine->unit_1 ?? '-') ?>
                                    </td>

                                    <td style="font-size:10px;"><?= h($rx->aturan_pakai ?? '-') ?></td>

                                    <td style="text-align:right;">
                                        Rp <?= number_format((float)($rx->harga ?? 0), 0, ',', '.') ?>
                                    </td>

                                    <td style="text-align:right; font-weight:600; color:#1e3a5f;">
                                        Rp <?= number_format((float)($rx->total_harga ?? 0), 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr style="background:#f8f9fa;">
                                <td colspan="10" style="text-align:right; font-weight:700; padding-right:10px;">
                                    Grand Total
                                </td>
                                <td style="text-align:right; font-weight:700; color:#1e3a5f; font-size:13px;">
                                    Rp <?= number_format($grandTotal ?? 0, 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" style="text-align:center; padding:20px; color:#aaa;">
                                    <i class="fa fa-pills"></i> Belum ada item resep
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
