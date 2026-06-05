<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 * @var array $statusLabel
 */

$statusColor = [
    0 => ['bg' => '#e9f7ef', 'border' => '#28a745', 'text' => '#155724', 'icon' => 'fa-check-circle', 'label' => 'Tersedia'],
    1 => ['bg' => '#fde8ea', 'border' => '#dc3545', 'text' => '#721c24', 'icon' => 'fa-user-injured', 'label' => 'Terisi'],
    2 => ['bg' => '#fff8e1', 'border' => '#ffc107', 'text' => '#856404', 'icon' => 'fa-broom', 'label' => 'Dibersihkan'],
    3 => ['bg' => '#f0f0f0', 'border' => '#6c757d', 'text' => '#383d41', 'icon' => 'fa-tools', 'label' => 'Maintenance'],
];
$currentStatus = $statusColor[(int)$bed->status] ?? $statusColor[0];

$fmtDate = function ($value, string $format = 'd-m-Y H:i') {
    if (empty($value)) {
        return '-';
    }
    if ($value instanceof \Cake\I18n\FrozenTime || $value instanceof \Cake\I18n\Time) {
        return $value->format($format);
    }
    $timestamp = strtotime((string)$value);

    return $timestamp ? date($format, $timestamp) : '-';
};

$patientName = '';
$patientFromHistory = false;
if (!empty($bed->patient) && !empty($bed->patient->full_name)) {
    $patientName = $bed->patient->full_name;
} elseif (!empty($bed->patient_name)) {
    $patientName = $bed->patient_name;
} elseif (!empty($bed->bed_histories)) {
    foreach ($bed->bed_histories as $history) {
        if ((int)$history->status_after === 1 && !empty($history->patient_name)) {
            $patientName = $history->patient_name;
            $patientFromHistory = true;
            break;
        }
    }
}

$histories = [];
if (!empty($bed->bed_histories)) {
    $histories = $bed->bed_histories;
    if (is_object($histories) && method_exists($histories, 'toArray')) {
        $histories = $histories->toArray();
    } elseif (!is_array($histories)) {
        $histories = iterator_to_array($histories);
    }
}

$historyPatientMap = [];
if ($histories) {
    $lastPatient = '';
    foreach (array_reverse($histories) as $history) {
        if ((int)$history->status_after === 1 && !empty($history->patient_name)) {
            $lastPatient = $history->patient_name;
        }
        if (!empty($history->id)) {
            $historyPatientMap[$history->id] = $lastPatient;
        }
    }
}
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Detail') ?>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-bed"></i> Detail Bed</h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered bed-detail-table">
                    <tr>
                        <td width="140"><strong>Code</strong></td>
                        <td><code><?= h($bed->code) ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Room</strong></td>
                        <td><?= h($bed->room->room_name ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>No TT</strong></td>
                        <td><?= h($bed->bed_no) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Bed</strong></td>
                        <td><?= h($bed->name) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Class</strong></td>
                        <td><?= h($bed->class_name) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <span class="bed-status-pill" style="background:<?= $currentStatus['bg'] ?>; color:<?= $currentStatus['text'] ?>; border-color:<?= $currentStatus['border'] ?>;">
                                <i class="fa <?= $currentStatus['icon'] ?>"></i> <?= h($currentStatus['label']) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Pasien</strong></td>
                        <td>
                            <?php if ($patientName): ?>
                                <i class="fa fa-user" style="color:<?= $patientFromHistory ? '#6c757d' : '#dc3545' ?>;"></i>
                                <strong><?= h($patientName) ?></strong>
                                <?php if ($patientFromHistory): ?>
                                    <small class="text-muted">(terakhir menempati)</small>
                                <?php endif; ?>
                                <?php if (!empty($bed->patient) && !empty($bed->patient->code)): ?>
                                    <br><small class="text-muted">Kode: <?= h($bed->patient->code) ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tgl Masuk</strong></td>
                        <td>
                            <?php if (!empty($bed->check_in_date)): ?>
                                <strong class="text-success"><i class="fa fa-sign-in-alt"></i> <?= h($fmtDate($bed->check_in_date, 'd-m-Y')) ?></strong><br>
                                <small class="text-muted"><?= h($fmtDate($bed->check_in_date, 'H:i')) ?> WIB</small>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tgl Keluar</strong></td>
                        <td>
                            <?php if (!empty($bed->check_out_date)): ?>
                                <strong class="text-danger"><i class="fa fa-sign-out-alt"></i> <?= h($fmtDate($bed->check_out_date, 'd-m-Y')) ?></strong><br>
                                <small class="text-muted"><?= h($fmtDate($bed->check_out_date, 'H:i')) ?> WIB</small>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if (!empty($bed->notes)): ?>
                        <tr>
                            <td><strong>Catatan</strong></td>
                            <td><?= nl2br(h($bed->notes)) ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Status Active</strong></td>
                        <td>
                            <?= $bed->is_active === 'Y' ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Non Active</span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat</strong></td>
                        <td><?= h($fmtDate($bed->created ?? null)) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Diubah</strong></td>
                        <td><?= h($fmtDate($bed->modified ?? null)) ?></td>
                    </tr>
                </table>

                <div class="text-right">
                    <?= $this->Html->link('<i class="fa fa-arrow-left"></i> Kembali', ['action' => 'index'], [
                        'class' => 'btn btn-default btn-sm',
                        'escape' => false,
                    ]) ?>
                    <?= $this->Html->link('<i class="fa fa-edit"></i> Edit', ['action' => 'edit', $bed->id], [
                        'class' => 'btn btn-warning btn-sm',
                        'escape' => false,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-history"></i> Riwayat Perubahan Status</h4>
            </div>
            <div class="panel-body">
                <?php if ($histories): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered bed-history-table">
                            <thead>
                                <tr>
                                    <th width="40">#</th>
                                    <th>Dari Status</th>
                                    <th>Ke Status</th>
                                    <th>Pasien</th>
                                    <th>Tgl Masuk</th>
                                    <th>Tgl Keluar</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($histories as $history): ?>
                                    <?php
                                    $before = $statusColor[(int)$history->status_before] ?? null;
                                    $after = $statusColor[(int)$history->status_after] ?? null;
                                    $historyPatient = $history->patient_name ?? '';
                                    if ((int)$history->status_after !== 1 && (int)$history->status_before === 1) {
                                        $historyPatient = $historyPatientMap[$history->id] ?? $historyPatient;
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $before ? '<i class="fa ' . h($before['icon']) . '"></i> ' . h($before['label']) : '-' ?></td>
                                        <td><?= $after ? '<i class="fa ' . h($after['icon']) . '"></i> ' . h($after['label']) : '-' ?></td>
                                        <td>
                                            <?php if ($historyPatient): ?>
                                                <i class="fa fa-user text-danger"></i> <?= h($historyPatient) ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= h($fmtDate($history->check_in_date ?? null)) ?></td>
                                        <td><?= h($fmtDate($history->check_out_date ?? null)) ?></td>
                                        <td><?= h($history->notes ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="bed-empty-history">
                        <i class="fa fa-inbox fa-2x"></i>
                        <span>Belum ada riwayat perubahan status.</span>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.bed-detail-table { font-size:13px; }
.bed-status-pill { border:1px solid; padding:3px 12px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }
.bed-history-table { font-size:12px; }
.bed-history-table thead tr { background:#2c3e50; color:#fff; }
.label { padding:4px 9px; border-radius:6px; font-size:11px; font-weight:600; display:inline-block; }
.label-success { background:#d1e7dd; color:#0f5132; }
.label-default { background:#e9ecef; color:#495057; }
.bed-empty-history { color:#6c757d; text-align:center; padding:20px; }
.bed-empty-history i { display:block; margin-bottom:8px; }
</style>
