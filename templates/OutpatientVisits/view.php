<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit $visit
 */
$p = $visit->patient;
$d = $visit->doctor;

// Helper format tanggal aman (handle null, string, FrozenTime)
function fmtOv($val, $fmt = 'd-m-Y H:i') {
    if (empty($val)) return '-';
    if (is_object($val) && method_exists($val, 'format')) return $val->format($fmt);
    $ts = strtotime((string)$val);
    return $ts ? date($fmt, $ts) : '-';
}
?>

<?= $this->Krs->breadcrumb('Outpatient Visits', 'Detail') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-file-medical"></i> Resume Medis Rawat Jalan
        </h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">

        <!-- TOOLBAR AKSI -->
        <div style="display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap;">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default btn-sm', 'escape' => false]
            ) ?>
            <?php if (!in_array($visit->status, ['done', 'cancelled'])): ?>
                <?= $this->Html->link(
                    '<i class="fa fa-edit"></i> Edit CPPT',
                    ['action' => 'cppt', $visit->id],
                    ['class' => 'btn btn-warning btn-sm', 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fa fa-edit"></i> Edit Data',
                    ['action' => 'edit', $visit->id],
                    ['class' => 'btn btn-info btn-sm', 'escape' => false]
                ) ?>
            <?php endif; ?>
        </div>

        <!-- ── Info Pasien ── -->
        <div class="panel panel-primary">
            <div class="panel-heading"><strong><i class="fa fa-user"></i> Identitas Pasien</strong></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <label>No Registrasi</label><br>
                        <strong><?= h($visit->registration_no ?? '-') ?></strong>
                    </div>
                    <div class="col-md-3">
                        <label>No Rekam Medis</label><br>
                        <?= h($p->code ?? '-') ?>
                    </div>
                    <div class="col-md-4">
                        <label>Nama Pasien</label><br>
                        <strong><?= h($p->full_name ?? '-') ?></strong>
                    </div>
                    <div class="col-md-2">
                        <label>Status</label><br>
                        <?php
                        $statusCfg = [
                            'waiting'     => ['label' => 'Menunggu',     'class' => 'default'],
                            'called'      => ['label' => 'Dipanggil',    'class' => 'warning'],
                            'in_progress' => ['label' => 'Diperiksa',    'class' => 'info'],
                            'done'        => ['label' => 'Selesai',      'class' => 'success'],
                            'cancelled'   => ['label' => 'Dibatalkan',   'class' => 'danger'],
                        ];
                        $sc = $statusCfg[$visit->status] ?? ['label' => $visit->status, 'class' => 'default'];
                        ?>
                        <span class="label label-<?= $sc['class'] ?>" style="font-size:12px; padding:5px 10px;">
                            <?= $sc['label'] ?>
                        </span>
                    </div>
                </div>
                <div class="row" style="margin-top:8px;">
                    <div class="col-md-2">
                        <label>Jenis Kelamin</label><br>
                        <?php if (!empty($p->gender)): ?>
                            <?= $p->gender === 'Male' ? 'Laki-laki' : 'Perempuan' ?>
                        <?php else: ?>-<?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <label>Umur</label><br>
                        <?php if (!empty($p->birth_date)): ?>
                            <?php
                            $bd = is_object($p->birth_date) ? $p->birth_date->format('Y-m-d') : (string)$p->birth_date;
                            echo (new \DateTime($bd))->diff(new \DateTime())->y;
                            ?> tahun
                        <?php else: ?>-<?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label>Cara Bayar</label><br>
                        <?= h($visit->registration->payment_method ?? '-') ?>
                    </div>
                    <div class="col-md-4">
                        <label>Dokter</label><br>
                        <?= h($d->doctor_name ?? '-') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Tanda Vital ── -->
        <div class="panel panel-default">
            <div class="panel-heading" style="background:#34495e; color:#fff;">
                <strong><i class="fa fa-heartbeat"></i> Tanda Vital</strong>
            </div>
            <div class="panel-body">
                <div class="row" style="text-align:center;">
                    <?php
                    $vitals = [
                        'Tekanan Darah' => ($visit->blood_pressure ?? '-') . ' mmHg',
                        'Nadi'          => ($visit->pulse ?? '-') . ' bpm',
                        'Suhu'          => ($visit->temperature ?? '-') . ' °C',
                        'Pernapasan'    => ($visit->respiratory_rate ?? '-') . ' /mnt',
                        'SpO2'          => ($visit->oxygen_saturation ?? '-') . ' %',
                        'BB / TB'       => ($visit->weight ?? '-') . ' kg / ' . ($visit->height ?? '-') . ' cm',
                        'Skala Nyeri'   => ($visit->pain_scale !== null ? $visit->pain_scale . '/10' : '-'),
                    ];
                    foreach ($vitals as $lbl => $val): ?>
                        <div class="col-md-3 col-xs-6" style="margin-bottom:8px;">
                            <div style="border:1px solid #dee2e6; border-radius:6px; padding:10px;">
                                <div style="font-size:11px; color:#888;"><?= $lbl ?></div>
                                <div style="font-size:16px; font-weight:700;"><?= h($val) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- ── Anamnesis & Diagnosa ── -->
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background:#2980b9; color:#fff;">
                        <strong><i class="fa fa-comment-medical"></i> Anamnesis</strong>
                    </div>
                    <div class="panel-body">
                        <label>Keluhan Utama</label>
                        <p><?= nl2br(h($visit->chief_complaint ?? '-')) ?></p>
                        <label>Riwayat Penyakit</label>
                        <p><?= nl2br(h($visit->illness_history ?? '-')) ?></p>
                        <?php if (!empty($visit->allergy)): ?>
                            <div class="alert alert-danger" style="padding:6px 10px; font-size:12px;">
                                <strong>⚠ Alergi:</strong> <?= h($visit->allergy) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background:#8e44ad; color:#fff;">
                        <strong><i class="fa fa-notes-medical"></i> Diagnosa</strong>
                    </div>
                    <div class="panel-body">
                        <label>Diagnosa Primer</label>
                        <p><strong><?= h($visit->diagnosis_primary ?? '-') ?></strong></p>
                        <?php if (!empty($visit->diagnosis_secondary)): ?>
                            <label>Diagnosa Sekunder</label>
                            <p><?= h($visit->diagnosis_secondary) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($visit->diagnosis_desc)): ?>
                            <label>Uraian</label>
                            <p><?= nl2br(h($visit->diagnosis_desc)) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Tindakan Medis ── -->
        <?php if (!empty($visit->outpatient_actions)): ?>
            <div class="panel panel-default">
                <div class="panel-heading" style="background:#16a085; color:#fff;">
                    <strong><i class="fa fa-procedures"></i> Tindakan Medis</strong>
                </div>
                <div class="panel-body" style="padding:0;">
                    <table class="table table-bordered table-sm" style="margin:0; font-size:13px;">
                        <thead style="background:#1e3a5f; color:#fff;">
                            <tr>
                                <th>#</th><th>Kategori</th><th>Kode</th>
                                <th>Nama Tindakan</th><th>Qty</th><th>Harga</th><th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($visit->outpatient_actions as $i => $action): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= h($action->action_category ?? '-') ?></td>
                                    <td><?= h($action->action_code ?? '-') ?></td>
                                    <td><?= h($action->action_name) ?></td>
                                    <td><?= h($action->quantity) ?></td>
                                    <td style="text-align:right;">
                                        <?= !empty($action->unit_price) ? 'Rp ' . number_format($action->unit_price, 0, ',', '.') : '-' ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?= !empty($action->total_price) ? 'Rp ' . number_format($action->total_price, 0, ',', '.') : '-' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr style="background:#f8f9fa; font-weight:700;">
                                <td colspan="6" style="text-align:right;">TOTAL</td>
                                <td style="text-align:right;">
                                    Rp <?= number_format($visit->total_fee ?? 0, 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- ── Catatan & Resep ── -->
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><i class="fa fa-sticky-note"></i> Catatan Dokter</strong></div>
                    <div class="panel-body">
                        <p><?= nl2br(h($visit->doctor_notes ?? '-')) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><i class="fa fa-prescription"></i> Resep</strong></div>
                    <div class="panel-body">
                        <p style="white-space:pre-wrap;"><?= nl2br(h($visit->prescription_notes ?? '-')) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Follow-up & Rujukan ── -->
        <?php if (!empty($visit->follow_up_date) || !empty($visit->referral_to)): ?>
            <div class="panel panel-info">
                <div class="panel-heading"><strong><i class="fa fa-calendar-check"></i> Follow-up &amp; Rujukan</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <?php if (!empty($visit->follow_up_date)): ?>
                            <div class="col-md-3">
                                <label>Tanggal Kontrol</label><br>
                                <?= fmtOv($visit->follow_up_date, 'd-m-Y') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($visit->referral_to)): ?>
                            <div class="col-md-4">
                                <label>Rujuk Ke</label><br>
                                <?= h($visit->referral_to) ?>
                            </div>
                            <div class="col-md-5">
                                <label>Alasan</label><br>
                                <?= h($visit->referral_reason ?? '-') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ── Timeline ── -->
        <div class="panel panel-default">
            <div class="panel-heading"><strong><i class="fa fa-clock"></i> Timeline Kunjungan</strong></div>
            <div class="panel-body">
                <div class="row" style="text-align:center;">
                    <div class="col-md-3">
                        <div style="font-size:12px; color:#888;">Check-in</div>
                        <div style="font-weight:600;">
                            <?= fmtOv($visit->visit_date, 'd-m-Y') ?>
                            <?= h($visit->visit_time ?? '') ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="font-size:12px; color:#888;">Dipanggil</div>
                        <div style="font-weight:600;"><?= fmtOv($visit->called_at, 'H:i') ?></div>
                    </div>
                    <div class="col-md-3">
                        <div style="font-size:12px; color:#888;">Mulai Periksa</div>
                        <div style="font-weight:600;"><?= fmtOv($visit->start_time, 'H:i') ?></div>
                    </div>
                    <div class="col-md-3">
                        <div style="font-size:12px; color:#888;">Selesai</div>
                        <div style="font-weight:600;"><?= fmtOv($visit->end_time, 'H:i') ?></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>