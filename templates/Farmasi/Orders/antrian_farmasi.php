<?php
$statusColor = '#1e3a5f';
?>
<div class="orders content" style="font-size:12px;">

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
    <h4 style="margin:0; font-weight:700; color:<?= $statusColor ?>;">
        <i class="fa fa-file-prescription"></i> Daftar Pasien E-Order Resep
    </h4>

    <?= $this->Form->create(null, ['type' => 'get', 'id' => 'form-filter-antrian']) ?>
    <div style="display:flex; align-items:center; gap:8px;">
        <label style="margin:0; font-weight:600;">Order &gt;= tanggal</label>
        <?= $this->Form->control('date_from', [
            'type' => 'date',
            'label' => false,
            'value' => $dateFrom,
            'class' => 'form-control input-sm',
            'onchange' => 'this.form.submit()',
        ]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<div class="row">

    <div class="col-md-2">
        <div class="panel panel-default">
            <div class="panel-body" style="padding:8px; display:flex; flex-direction:column; gap:8px;">

                <button type="button" class="btn btn-default btn-sm btn-block" disabled>
                    No Antrian
                </button>

                <button type="button" class="btn btn-default btn-sm btn-block" disabled>
                    Informasi Pasien RJ
                </button>

                <?= $this->Html->link(
                    'Refresh',
                    ['action' => 'antrianFarmasi', '?' => ['date_from' => $dateFrom]],
                    ['class' => 'btn btn-default btn-sm btn-block']
                ) ?>

                <?= $this->Html->link(
                    'Keluar',
                    ['prefix' => 'RawatJalan', 'controller' => 'OutpatientVisits', 'action' => 'index'],
                    ['class' => 'btn btn-danger btn-sm btn-block']
                ) ?>
            </div>
        </div>
    </div>

    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading" style="padding:8px 12px; background:<?= $statusColor ?>;">
                <strong style="font-size:12px; color:#fff;">
                    Antrian Farmasi - Rawat Jalan &amp; IGD
                </strong>
            </div>

            <div class="panel-body" style="padding:0;">
                <div style="overflow-x:auto;">
                    <table class="table table-bordered table-condensed" style="font-size:11px; margin:0;">
                        <thead>
                            <tr style="background:#dbeafe;">
                                <th style="width:75px;">No Antri</th>
                                <th style="width:110px;">No Order</th>
                                <th style="width:90px;">Rekmed</th>
                                <th style="width:90px;">Tgl Masuk</th>
                                <th style="width:70px;">Jam</th>
                                <th>Nama Pasien</th>
                                <th>Dokter Pengirim</th>
                                <th style="width:130px;">Asal Pasien</th>
                                <th>Pesan</th>
                                <th style="width:80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $row): ?>
                                    <?php
                                    $o = $row['order'];
                                    $patient = $o->patient ?? null;
                                    $doctor = $o->doctor ?? null;
                                    $registration = $o->registration ?? null;

                                    $asalPasien = $registration->polyclinic_name ?? null;
                                    if (empty($asalPasien)) {
                                        $serviceType = $registration->service_type ?? '-';
                                        if ($serviceType === 'rawat_jalan') {
                                            $asalPasien = 'Rawat Jalan';
                                        } elseif ($serviceType === 'igd') {
                                            $asalPasien = 'IGD';
                                        } else {
                                            $asalPasien = ucwords(str_replace('_', ' ', (string)$serviceType));
                                        }
                                    }
                                    ?>
                                    <tr style="background:#d9f7dc;">
                                        <td><strong><?= h($row['no_antri']) ?></strong></td>
                                        <td><?= h($o->no_order) ?></td>
                                        <td><?= h($row['medical_record_no'] ?? '-') ?></td>
                                        <td><?= $o->tgl_order ? $o->tgl_order->format('d-m-Y') : '-' ?></td>
                                        <td><?= $o->tgl_order ? $o->tgl_order->format('H:i:s') : '-' ?></td>
                                        <td><?= h($patient->full_name ?? '-') ?></td>
                                        <td><?= h($doctor->doctor_name ?? $doctor->name ?? '-') ?></td>
                                        <td><?= h($asalPasien) ?></td>
                                        <td><?= h($o->pesan ?? '') ?></td>
                                        <td style="text-align:center;">
                                            <?= $this->Html->link(
                                                '<i class="fa fa-play"></i> Proses',
                                                ['action' => 'proses', $o->id],
                                                ['escape' => false, 'class' => 'btn btn-info btn-xs']
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" style="text-align:center; color:#aaa; padding:24px;">
                                        <i class="fa fa-inbox"></i><br>
                                        Tidak ada antrian resep untuk tanggal ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div style="background:#dc3545; color:#fff; padding:8px 14px; font-weight:700; text-align:right;">
            Sisa e-order Resep : <?= $sisaResep ?>
        </div>
    </div>

</div>
</div>