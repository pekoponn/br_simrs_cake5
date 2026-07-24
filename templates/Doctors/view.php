<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Doctor $doctor
 */

function fmtDoctorDate($val, $fmt = 'd-m-Y') {
    if (empty($val)) return '—';
    if ($val instanceof \Cake\I18n\FrozenDate || $val instanceof \Cake\I18n\Date) {
        return $val->format($fmt);
    }
    if ($val instanceof \Cake\I18n\FrozenTime || $val instanceof \Cake\I18n\Time) {
        return $val->format($fmt);
    }
    $ts = strtotime((string)$val);
    return $ts ? date($fmt, $ts) : '—';
}

function fmtDoctorTime($val) {
    if (empty($val)) return '—';
    if ($val instanceof \Cake\I18n\FrozenTime || $val instanceof \Cake\I18n\Time) {
        return $val->format('H:i');
    }
    $ts = strtotime((string)$val);
    return $ts ? date('H:i', $ts) : (string)$val;
}

$isMale  = strtolower($doctor->gender ?? '') === 'male';
$isAktif = ($doctor->is_active === 'Y' || $doctor->is_active === 1);
?>

<?= $this->Krs->breadcrumb('Dokter', 'Detail') ?>

<div class="row">

    <!-- ── Panel kiri: Info Utama ──────────────────────────────── -->
    <div class="col-md-5">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fa fa-user-md"></i> Detail Dokter
                </h4>
            </div>
            <div class="panel-body">

                <!-- Header nama + avatar -->
                <div style="text-align:center; padding:16px 0 20px;">
                    <div style="width:64px; height:64px; border-radius:50%;
                                background:<?= $isMale ? '#dbeafe' : '#fce7f3' ?>;
                                color:<?= $isMale ? '#1d4ed8' : '#be185d' ?>;
                                font-size:28px; display:flex; align-items:center;
                                justify-content:center; margin:0 auto 10px;">
                        <?= $isMale ? '♂' : '♀' ?>
                    </div>
                    <h5 style="margin:0 0 4px; font-weight:700; font-size:16px;">
                        <?= h($doctor->doctor_name) ?>
                    </h5>
                    <code style="font-size:12px; color:#6c757d;"><?= h($doctor->code) ?></code>
                    <div style="margin-top:8px;">
                        <?php if ($isAktif): ?>
                            <span class="label label-success">Active</span>
                        <?php else: ?>
                            <span class="label label-default">Non Active</span>
                        <?php endif; ?>
                        <span style="background:<?= $isMale ? '#dbeafe' : '#fce7f3' ?>;
                                     color:<?= $isMale ? '#1d4ed8' : '#be185d' ?>;
                                     padding:3px 10px; border-radius:12px;
                                     font-size:11px; font-weight:600; margin-left:4px;">
                            <?= $isMale ? '♂ Laki-laki' : '♀ Perempuan' ?>
                        </span>
                    </div>
                </div>

                <table class="table table-bordered" style="font-size:13px;">
                    <tr>
                        <td width="140"><strong>Kode Dokter</strong></td>
                        <td><code><?= h($doctor->code) ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Dokter</strong></td>
                        <td><strong><?= h($doctor->doctor_name) ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong>Region</strong></td>
                        <td><?= h($doctor->region) ?: '—' ?></td>
                    </tr>
                    <tr>
                        <td><strong>NIK</strong></td>
                        <td><?= h($doctor->nik) ?: '—' ?></td>
                    </tr>
                    <tr>
                        <td><strong>NIK Login</strong></td>
                        <td><?= h($doctor->nik_login) ?: '—' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Gender</strong></td>
                        <td>
                            <span style="background:<?= $isMale ? '#dbeafe' : '#fce7f3' ?>;
                                         color:<?= $isMale ? '#1d4ed8' : '#be185d' ?>;
                                         padding:2px 10px; border-radius:12px;
                                         font-size:11px; font-weight:600;">
                                <?= $isMale ? '♂ Laki-laki' : '♀ Perempuan' ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Spesialis</strong></td>
                        <td>
                            <?php if (!empty($doctor->specialist)): ?>
                                <span style="background:#e0f2fe; color:#0369a1; padding:2px 10px;
                                             border-radius:12px; font-size:12px; font-weight:600;">
                                    <?= h($doctor->specialist) ?>
                                </span>
                            <?php else: ?>—<?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Poliklinik</strong></td>
                        <td>
                            <?php if (!empty($doctor->polyclinic_name)): ?>
                                <span style="background:#fef3c7; color:#92400e; padding:2px 10px;
                                             border-radius:12px; font-size:12px; font-weight:600;">
                                    <?= h($doctor->polyclinic_name) ?>
                                </span>
                            <?php else: ?>—<?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>No. Telepon</strong></td>
                        <td>
                            <?php if (!empty($doctor->phone_number)): ?>
                                <i class="fa fa-phone" style="color:#28a745;"></i>
                                <?= h($doctor->phone_number) ?>
                            <?php else: ?>—<?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Agama</strong></td>
                        <td><?= h($doctor->religion) ?: '—' ?></td>
                    </tr>
                    <tr>
                        <td><strong>No. SIP</strong></td>
                        <td><?= h($doctor->sip_number) ?: '—' ?></td>
                    </tr>
                    <tr>
                        <td><strong>No. STR</strong></td>
                        <td><?= h($doctor->str_number) ?: '—' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tgl Terbit STR</strong></td>
                        <td><?= fmtDoctorDate($doctor->str_issue_date) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Masa Berlaku STR</strong></td>
                        <td>
                            <?php
                            $strExpiry = $doctor->str_expiry_date;
                            if (empty($strExpiry)) {
                                echo '—';
                            } elseif (strtolower((string)$strExpiry) === 'seumur hidup') {
                                echo 'Seumur Hidup';
                            } else {
                                echo fmtDoctorDate($strExpiry);
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Terdaftar</strong></td>
                        <td><?= fmtDoctorDate($doctor->created, 'd-m-Y H:i') ?></td>
                    </tr>
                </table>

                <div class="text-right" style="margin-top:10px;">
                    <?= $this->Html->link(
                        '<i class="fa fa-arrow-left"></i> Kembali',
                        ['action' => 'index'],
                        ['class' => 'btn btn-default btn-sm', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-edit"></i> Edit',
                        ['action' => 'edit', $doctor->id],
                        ['class' => 'btn btn-warning btn-sm', 'escape' => false]
                    ) ?>
                </div>

            </div>
        </div>
    </div>

    <!-- ── Panel kanan: Alamat + Jadwal Praktik ─────────── -->
    <div class="col-md-7">

        <!-- Alamat -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fa fa-map-marker-alt"></i> Alamat
                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered" style="font-size:13px;">
                    <tr>
                        <td width="130"><strong>Alamat</strong></td>
                        <td><?= !empty($doctor->address) ? nl2br(h($doctor->address)) : '—' ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Jadwal Praktik -->
        <?php if (!empty($doctor->doctor_schedules)): ?>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fa fa-calendar-alt"></i> Jadwal Praktik
                    <span class="badge" style="background:#e9ecef; color:#495057; margin-left:6px;">
                        <?= count($doctor->doctor_schedules) ?>
                    </span>
                </h4>
            </div>
            <div class="panel-body" style="padding:0;">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="font-size:12px; margin:0;">
                        <thead>
                            <tr style="background:#2c3e50; color:#fff;">
                                <th width="40">#</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Kuota</th>
                                <th>Catatan</th>
                                <th width="80">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sno = 1; foreach ($doctor->doctor_schedules as $sch): ?>
                            <?php $schAktif = ($sch->is_active === 'Y' || $sch->is_active === 1); ?>
                            <tr>
                                <td class="text-center"><?= $sno++ ?></td>
                                <td><?= h($sch->day) ?: '—' ?></td>
                                <td><?= fmtDoctorTime($sch->start_time) ?></td>
                                <td><?= fmtDoctorTime($sch->end_time) ?></td>
                                <td class="text-center"><?= h($sch->quota) ?: '—' ?></td>
                                <td><?= h($sch->note) ?: '—' ?></td>
                                <td class="text-center">
                                    <?php if ($schAktif): ?>
                                        <span class="label label-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="label label-default">Non</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fa fa-calendar-alt"></i> Jadwal Praktik
                </h4>
            </div>
            <div class="panel-body">
                <p style="color:#888; margin:0;">Belum ada jadwal praktik untuk dokter ini.</p>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<style>
.label { padding:4px 9px; border-radius:6px; font-size:11px; font-weight:600; display:inline-block; }
.label-success { background:#d1e7dd; color:#0f5132; }
.label-default { background:#e9ecef; color:#495057; }
</style>