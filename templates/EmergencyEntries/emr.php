<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 *
 * Template EMR IGD — identik dengan EMR Rawat Jalan.
 * Variabel utama: $registration (entity dari tabel registrations, service_type = 'igd')
 * Relasi yang dibutuhkan di controller: contain(['Patients', 'Doctors', 'EmergencyActions'])
 */

$p      = $registration->patient;
$d      = $registration->doctor;

// Status selesai/batal — sesuaikan nama status IGD Anda jika berbeda
$isDone = in_array($registration->status ?? '', ['done', 'cancelled', 'selesai', 'pulang']);

// Nomor Surat Pengantar Rawat Inap
$inpatientReferralNo = $registration->inpatient_referral_no
    ?? $registration->referral_inpatient_letter_no
    ?? ('SPRI-' . date('Ymd') . '-' . str_pad((string)($registration->id ?? 0), 5, '0', STR_PAD_LEFT));

// ID / No Registrasi untuk E-Order
$orderRegistrationId = $registration->id ?? null;

$orderRegistrationNo = $registration->registration_no
    ?? $registration->registration_number
    ?? null;
?>

<?= $this->Krs->breadcrumb('Emergency Entries', 'EMR IGD — Pemeriksaan Pasien') ?>

<div class="emergency-entries emr content">

    <!-- ── Header ── -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h4 style="margin:0; font-weight:700; color:#7b1c1c;">
            <i class="fa fa-procedures"></i> EMR IGD — Electronic Medical Record
        </h4>
        <div style="display:flex; gap:6px;">
            <?= $this->Html->link(
                '<i class="fa fa-clipboard-list"></i> Lihat CPPT',
                ['action' => 'cppt', $registration->id],
                ['escape' => false, 'class' => 'btn btn-warning btn-sm',
                 'data-toggle' => 'tooltip', 'title' => 'Catatan Perkembangan Pasien']
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </div>
    </div>

    <!-- ── Info Pasien ── -->
    <div class="panel panel-default" style="margin-bottom:8px;">
        <div class="panel-body" style="padding:8px 10px; background:#fff5f5; font-size:12px;">

            <div class="row" style="margin-bottom:5px;">
                <div class="col-md-2">
                    <small>No Registrasi</small><br>
                    <strong><?= h($registration->registration_no ?? $registration->registration_number ?? '-') ?></strong>
                </div>
                <div class="col-md-2">
                    <small>No RM</small><br>
                    <strong><?= h($p->code ?? '-') ?></strong>
                </div>
                <div class="col-md-3">
                    <small>Nama Pasien</small><br>
                    <strong><?= h($p->full_name ?? '-') ?></strong>
                </div>
                <div class="col-md-2">
                    <small>Tgl Lahir / Umur</small><br>
                    <strong>
                        <?= !empty($p->birth_date) ? $p->birth_date->format('d-m-Y') : '-' ?>
                        /
                        <?= !empty($p->birth_date) ? (new DateTime())->diff(new DateTime($p->birth_date->format('Y-m-d')))->y . ' th' : '-' ?>
                    </strong>
                </div>
                <div class="col-md-1">
                    <small>JK</small><br>
                    <strong><?= ($p->gender ?? '') === 'Male' ? 'Pria' : 'Wanita' ?></strong>
                </div>
                <div class="col-md-2">
                    <small>No Antri / Triase</small><br>
                    <strong style="font-size:16px; color:#7b1c1c;">
                        <?= h($registration->queue_number ?? $registration->triage_level ?? '-') ?>
                    </strong>
                </div>
            </div>

            <div class="row" style="margin-bottom:5px;">
                <div class="col-md-2">
                    <small>Dokter IGD</small><br>
                    <strong><?= h($d->doctor_name ?? $d->name ?? '-') ?></strong>
                </div>
                <div class="col-md-2">
                    <small>Unit / Ruang</small><br>
                    <strong><?= h($registration->room_name ?? $registration->unit_name ?? 'IGD') ?></strong>
                </div>
                <div class="col-md-2">
                    <small>Tgl Masuk</small><br>
                    <strong>
                        <?php
                        $vDate = $registration->visit_date ?? $registration->registration_date ?? $registration->created ?? null;
                        echo $vDate ? (is_object($vDate) ? $vDate->format('d-m-Y') : h($vDate)) : '-';
                        ?>
                    </strong>
                </div>
                <div class="col-md-2">
                    <small>Jam Masuk</small><br>
                    <strong>
                        <?php
                        $vTime = $registration->visit_time ?? $registration->arrival_time ?? null;
                        echo $vTime ? h(substr($vTime, 0, 5)) : date('H:i');
                        ?>
                    </strong>
                </div>
                <div class="col-md-2">
                    <small>Telepon</small><br>
                    <strong><?= h($p->phone_number ?? '-') ?></strong>
                </div>
                <div class="col-md-2">
                    <small>Jaminan</small><br>
                    <strong><?= h($registration->insurance_type ?? 'Umum') ?></strong>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <small>Alamat</small><br>
                    <strong><?= h($p->address ?? '-') ?></strong>
                </div>
                <div class="col-md-2">
                    <small>Status</small><br>
                    <span class="label label-<?= h($registration->status_badge_class ?? 'default') ?>">
                        <?= h($registration->status_label ?? $registration->status ?? '-') ?>
                    </span>
                </div>
            </div>

        </div>
    </div>

    <?php if (!empty($registration->allergy)): ?>
        <div class="alert alert-danger" style="padding:7px 12px; font-size:12px; margin-bottom:10px;">
            <strong><i class="fa fa-exclamation-triangle"></i> ALERGI:</strong> <?= h($registration->allergy) ?>
        </div>
    <?php endif; ?>

    <?= $this->Form->create($registration, ['url' => ['action' => 'emr', $registration->id]]) ?>

    <!-- ── LAYOUT 2 KOLOM ── -->
    <div class="row">

        <!-- ════════════════════════════════════════════════════
             KOLOM KIRI
             ════════════════════════════════════════════════════ -->
        <div class="col-md-6">

            <!-- Tindakan & Tarif -->
            <div class="panel panel-default">
                <div class="panel-heading" style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-procedures"></i> Tindakan & Tarif</strong>
                    <?php if (!$isDone): ?>
                        <button type="button" class="btn btn-xs btn-success" id="btn-add-action">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                    <?php endif; ?>
                </div>
                <div class="panel-body" style="padding:8px;">
                    <table class="table table-bordered table-sm" id="actions-table"
                           style="font-size:11px; margin-bottom:4px;">
                        <thead>
                            <tr>
                                <th style="width:72px;">Kode</th>
                                <th>Tindakan</th>
                                <th style="width:60px; text-align:center;">Qty</th>
                                <th style="width:88px;">Tarif/Unit</th>
                                <th style="width:88px;">Total</th>
                                <?php if (!$isDone): ?>
                                    <th style="width:28px;"></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="actions-body">
                            <?php if (!empty($registration->emergency_actions)): ?>
                                <?php foreach ($registration->emergency_actions as $i => $action): ?>
                                    <tr class="action-row">
                                        <td>
                                            <input type="text"
                                                   name="emergency_actions[<?= $i ?>][action_code]"
                                                   class="form-control input-sm"
                                                   value="<?= h($action->action_code ?? '') ?>"
                                                   placeholder="Kode..."
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                        </td>
                                        <td style="position:relative;">
                                            <input type="text"
                                                   name="emergency_actions[<?= $i ?>][action_name]"
                                                   class="form-control input-sm action-name"
                                                   value="<?= h($action->action_name ?? '') ?>"
                                                   placeholder="Ketik nama tindakan..."
                                                   autocomplete="off"
                                                   <?= $isDone ? 'readonly' : 'required' ?>>
                                            <input type="hidden"
                                                   name="emergency_actions[<?= $i ?>][action_category]"
                                                   value="<?= h($action->action_category ?? '') ?>">
                                            <input type="hidden"
                                                   name="emergency_actions[<?= $i ?>][notes]"
                                                   value="<?= h($action->notes ?? '') ?>">
                                        </td>
                                        <td>
                                            <input type="number"
                                                   name="emergency_actions[<?= $i ?>][quantity]"
                                                   class="form-control input-sm action-qty"
                                                   value="<?= (int)($action->quantity ?? 1) ?>"
                                                   min="1"
                                                   style="text-align:center; -moz-appearance:textfield;"
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                        </td>
                                        <td>
                                            <?php if (!$isDone): ?>
                                                <input type="text"
                                                       class="form-control input-sm action-unit-price-display"
                                                       value="<?= number_format((float)($action->unit_price ?? 0), 0, ',', '.') ?>"
                                                       readonly
                                                       style="text-align:right; background:#f0f0f0; cursor:default; color:#333;">
                                                <input type="hidden"
                                                       name="emergency_actions[<?= $i ?>][unit_price]"
                                                       class="action-unit-price"
                                                       value="<?= (float)($action->unit_price ?? 0) ?>">
                                            <?php else: ?>
                                                <input type="text"
                                                       class="form-control input-sm"
                                                       value="<?= number_format((float)($action->unit_price ?? 0), 0, ',', '.') ?>"
                                                       readonly
                                                       style="text-align:right; background:#f5f5f5;">
                                                <input type="hidden"
                                                       name="emergency_actions[<?= $i ?>][unit_price]"
                                                       value="<?= (float)($action->unit_price ?? 0) ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control input-sm action-total"
                                                   readonly
                                                   value="<?= number_format((float)(($action->unit_price ?? 0) * ($action->quantity ?? 1)), 0, ',', '.') ?>"
                                                   style="background:#f5f5f5; text-align:right;">
                                        </td>
                                        <?php if (!$isDone): ?>
                                            <td class="text-center">
                                                <button type="button"
                                                        class="btn btn-xs btn-danger btn-remove-action">
                                                    &times;
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align:right; font-weight:600; font-size:11px; padding-right:8px;">
                                    Grand Total
                                </td>
                                <td colspan="<?= $isDone ? 1 : 2 ?>">
                                    <input type="number" name="total_fee" id="total-fee"
                                           class="form-control input-sm"
                                           value="<?= h((int)($registration->total_fee ?? 0)) ?>"
                                           step="1" min="0"
                                           style="text-align:right; font-weight:600;"
                                           <?= $isDone ? 'readonly' : '' ?>>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Debug info -->
                    <div id="debug-autocomplete" style="display:none; background:#fff3cd; border:1px solid #ffc107;
                         border-radius:4px; padding:6px 10px; font-size:10px; margin-top:4px; color:#856404;">
                        <strong><i class="fa fa-bug"></i> Debug:</strong>
                        <span id="debug-text">-</span>
                        <button type="button" onclick="testAutocomplete()"
                                class="btn btn-xs btn-warning" style="margin-left:6px;">
                            Test Koneksi
                        </button>
                        <button type="button" onclick="$('#debug-autocomplete').hide()"
                                class="btn btn-xs btn-default" style="margin-left:4px;">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tombol aksi utama kiri -->
            <div class="row" style="margin-bottom:18px;">
                <div class="col-xs-4">
                    <?php if (!empty($orderRegistrationId)): ?>
                        <?= $this->Html->link(
                            '<i class="fa fa-flask"></i> ORDER LAB/RADIO/RESEP',
                            ['controller' => 'Orders', 'action' => 'form', $orderRegistrationId],
                            ['escape' => false, 'class' => 'btn btn-sm btn-block',
                             'style' => 'background:#17a2b8; color:#fff; font-size:11px;']
                        ) ?>
                    <?php elseif (!empty($orderRegistrationNo)): ?>
                        <?= $this->Html->link(
                            '<i class="fa fa-flask"></i> ORDER LAB/RADIO/RESEP',
                            ['controller' => 'Orders', 'action' => 'form',
                             '?' => ['registration_no' => $orderRegistrationNo]],
                            ['escape' => false, 'class' => 'btn btn-sm btn-block',
                             'style' => 'background:#17a2b8; color:#fff; font-size:11px;']
                        ) ?>
                    <?php else: ?>
                        <button type="button" class="btn btn-sm btn-block btn-danger" disabled>
                            No Registrasi tidak ada
                        </button>
                    <?php endif; ?>
                </div>
                <div class="col-xs-4">
                    <button type="button" class="btn btn-sm btn-block"
                            style="background:#6f42c1; color:#fff; font-size:11px;">
                        <i class="fa fa-nurse"></i> LEMBAR PERAWAT
                    </button>
                </div>
                <div class="col-xs-4">
                    <button type="button" class="btn btn-sm btn-block btn-inverse"
                            style="font-size:11px;">
                        <i class="fa fa-receipt"></i> SURAT BUKTI RAWAT IGD
                    </button>
                </div>
            </div>

            <!-- ════════════════════════════
                 PANEL SURAT / RUJUK / SKDP
                 ════════════════════════════ -->
            <div class="panel panel-default emr-tab-panel" style="margin-top:2px;">
                <div class="panel-heading" style="padding:0;">
                    <ul class="nav nav-tabs emr-tabs" id="tab-surat-rujuk" role="tablist"
                        style="border-bottom:none; margin:0;">
                        <li role="presentation" class="active">
                            <a href="#tab-surat" data-toggle="tab"
                               style="font-size:11px; padding:7px 12px; font-weight:600;">
                                <i class="fa fa-file-alt"></i> Surat
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tab-rujuk" data-toggle="tab"
                               style="font-size:11px; padding:7px 12px; font-weight:600;">
                                <i class="fa fa-share-square"></i> Dirujuk / Konsultan
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tab-skdp" data-toggle="tab"
                               style="font-size:11px; padding:7px 12px; font-weight:600;">
                                <i class="fa fa-id-card-alt"></i> SKDP
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="panel-body emr-tab-body" style="padding:14px 12px 12px 12px; margin-top:-1px; background:#fff;">
                    <div class="tab-content">

                        <!-- ══ TAB SURAT ══ -->
                        <div id="tab-surat" class="tab-pane active">
                            <div class="row" style="display:flex; align-items:stretch;">
                                <div class="col-xs-4">
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5"
                                            style="text-align:left; font-size:11px;">
                                        <i class="fa fa-file-medical" style="color:#7b1c1c;"></i>
                                        Surat Keterangan Sakit
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5"
                                            style="text-align:left; font-size:11px;">
                                        <i class="fa fa-file-medical" style="color:#7b1c1c;"></i>
                                        Surat Konsultasi Pasien
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5"
                                            style="text-align:left; font-size:11px;">
                                        <i class="fa fa-file-medical" style="color:#7b1c1c;"></i>
                                        Jawaban Konsultasi Pasien
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5"
                                            style="text-align:left; font-size:11px;">
                                        <i class="fa fa-file-medical" style="color:#7b1c1c;"></i>
                                        Surat Keterangan Sehat
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5"
                                            style="text-align:left; font-size:11px;">
                                        <i class="fa fa-file-medical" style="color:#7b1c1c;"></i>
                                        Protokol Terapi
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5"
                                            style="text-align:left; font-size:11px;">
                                        <i class="fa fa-file-medical" style="color:#7b1c1c;"></i>
                                        Fisioterapi
                                    </button>

                                    <div style="margin-top:6px;">
                                        <label style="font-size:10px; font-weight:600; color:#dc3545; margin-bottom:3px;">
                                            <i class="fa fa-exclamation-triangle"></i> ALERGI
                                        </label>
                                        <input type="text" name="allergy" class="form-control input-sm"
                                               value="<?= h($registration->allergy ?? '') ?>"
                                               placeholder="Tidak ada / nama obat / bahan makanan..."
                                               <?= $isDone ? 'readonly' : '' ?>>
                                    </div>
                                </div>

                                <div class="col-xs-8">
                                    <div style="display:flex; gap:10px; align-items:flex-start;">
                                        <div style="flex:0 0 130px; text-align:center;">
                                            <div style="border:1px solid #dee2e6; border-radius:6px; padding:10px;
                                                        background:#f8f9fa; height:150px;
                                                        display:flex; align-items:center; justify-content:center;">
                                                <i class="fa fa-male" style="font-size:58px; color:#ccc;"></i>
                                            </div>
                                            <div style="display:flex; gap:4px; margin-top:6px;">
                                                <button type="button" class="btn btn-xs btn-default btn-block"
                                                        style="font-size:10px; margin-top:0;">Reset Gambar</button>
                                                <button type="button" class="btn btn-xs btn-default btn-block"
                                                        style="font-size:10px; margin-top:0;">Pilih Gambar</button>
                                            </div>
                                        </div>
                                        <div style="flex:0 0 130px; text-align:center;">
                                            <div style="border:1px solid #dee2e6; border-radius:6px; padding:10px;
                                                        background:#f8f9fa; height:150px;
                                                        display:flex; align-items:center; justify-content:center;">
                                                <i class="fa fa-male" style="font-size:58px; color:#ccc;"></i>
                                            </div>
                                            <div style="display:flex; gap:4px; margin-top:6px;">
                                                <button type="button" class="btn btn-xs btn-default btn-block"
                                                        style="font-size:10px; margin-top:0;">Reset Gambar</button>
                                                <button type="button" class="btn btn-xs btn-default btn-block"
                                                        style="font-size:10px; margin-top:0;">Image Viewer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /tab-surat -->

                        <!-- ══ TAB RUJUK ══ -->
                        <div id="tab-rujuk" class="tab-pane">
                            <div class="row">

                                <!-- PROSES KONSULTASI -->
                                <div class="col-md-8">
                                    <div style="background:#eef4ff; border:1px solid #d6e4ff;
                                                border-radius:4px; padding:10px; min-height:220px;">

                                        <label style="font-size:12px; font-weight:bold;">
                                            Proses Konsultasi / Rujuk Ke Poli / Bagian Lain
                                        </label>

                                        <div class="form-group" style="margin-top:10px; position:relative;">
                                            <label>Ke Poliklinik</label>
                                            <input type="text"
                                                   id="referral-polyclinic-search"
                                                   class="form-control input-sm"
                                                   value="<?= h($registration->referral_polyclinic ?? '') ?>"
                                                   placeholder="Ketik nama poliklinik..."
                                                   autocomplete="off"
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                            <input type="hidden"
                                                   name="referral_polyclinic"
                                                   id="referral-polyclinic-value"
                                                   value="<?= h($registration->referral_polyclinic ?? '') ?>">
                                            <div id="polyclinic-dropdown" style="display:none; position:absolute;
                                                top:100%; left:0; right:0; z-index:9999; background:#fff;
                                                border:1px solid #ced4da; border-radius:4px;
                                                box-shadow:0 4px 12px rgba(0,0,0,.12);
                                                max-height:220px; overflow-y:auto; font-size:12px;"></div>
                                        </div>

                                        <div class="form-group" style="position:relative;">
                                            <label>Ke Dokter</label>
                                            <input type="text"
                                                   id="referral-doctor-search"
                                                   class="form-control input-sm"
                                                   value="<?= h($registration->referral_doctor ?? '') ?>"
                                                   placeholder="Pilih dokter sesuai poliklinik..."
                                                   autocomplete="off"
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                            <input type="hidden"
                                                   name="referral_doctor"
                                                   id="referral-doctor-value"
                                                   value="<?= h($registration->referral_doctor ?? '') ?>">
                                            <div id="doctor-dropdown" style="display:none; position:absolute;
                                                top:100%; left:0; right:0; z-index:9999; background:#fff;
                                                border:1px solid #ced4da; border-radius:4px;
                                                box-shadow:0 4px 12px rgba(0,0,0,.12);
                                                max-height:220px; overflow-y:auto; font-size:12px;"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tanggal</label>
                                                <input type="date" name="referral_date"
                                                       class="form-control input-sm"
                                                       value="<?= h($registration->referral_date ?? date('Y-m-d')) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Jam</label>
                                                <input type="time" name="referral_time"
                                                       class="form-control input-sm"
                                                       value="<?= h($registration->referral_time ?? date('H:i')) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Nomor Antri</label>
                                                <input type="number" name="referral_queue_no"
                                                       id="referral-queue-no"
                                                       class="form-control input-sm"
                                                       value="<?= h($registration->referral_queue_no ?? 0) ?>"
                                                       readonly
                                                       style="background:#f5f5f5; font-weight:600; cursor:not-allowed;">
                                            </div>
                                        </div>

                                        <div style="margin-top:10px;">
                                            <label>
                                                <input type="checkbox" name="praktek2" value="1">
                                                Praktek 2
                                            </label>
                                        </div>

                                        <div style="margin-top:10px;">
                                            <button type="button" class="btn btn-primary btn-sm">
                                                Konsulkan Langsung
                                            </button>
                                            <button type="button" id="btn-jadwal-kontrol"
                                                    class="btn btn-info btn-sm">
                                                Jadwal Kontrol
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- RAWAT INAP -->
                                <div class="col-md-4">
                                    <div style="background:#fafafa; border:1px solid #ddd;
                                                border-radius:4px; padding:10px; min-height:220px;">

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="referral_inpatient" value="1"
                                                       <?= !empty($registration->referral_inpatient) ? 'checked' : '' ?>>
                                                Dilakukan Rawat Inap
                                            </label>
                                        </div>

                                        <div class="form-group" style="margin-bottom:8px;">
                                            <input type="text" name="inpatient_referral_no"
                                                   class="form-control input-sm"
                                                   value="<?= h($inpatientReferralNo) ?>"
                                                   readonly
                                                   style="background:#f5f5f5; font-weight:600; cursor:not-allowed;">
                                        </div>

                                        <button type="button" class="btn btn-default btn-block">
                                            Surat Pengantar Rawat
                                        </button>

                                        <div style="margin-top:15px;">
                                            <label>Note</label>
                                            <textarea name="referral_note" class="form-control"
                                                      rows="5"><?= h($registration->referral_note ?? '') ?></textarea>
                                        </div>

                                        <div style="margin-top:10px;">
                                            <button type="button" class="btn btn-default btn-block"
                                                    style="font-size:12px; font-weight:600;
                                                           border:1px solid #b5b5b5; background:#f8f8f8;">
                                                <i class="fa fa-print"></i> Cetak Antrian (Konsul)
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- /tab-rujuk -->

                        <!-- ══ TAB SKDP ══ -->
                        <div id="tab-skdp" class="tab-pane">
                            <div style="background:#fafafa; border:1px solid #ddd;
                                        border-radius:4px; padding:12px;">

                                <div style="margin-bottom:10px;">
                                    <button type="button" class="btn btn-primary btn-xs">
                                        <i class="fa fa-file-medical"></i> BUAT SURAT KONTROL BPJS
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-size:11px; font-weight:600;">TGL KEMBALI KONTROL</label>
                                            <input type="date" class="form-control input-sm"
                                                   name="bpjs_control_date"
                                                   value="<?= h($registration->bpjs_control_date ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:11px; font-weight:600;">KETERANGAN KONTROL</label>
                                            <input type="text" class="form-control input-sm"
                                                   name="bpjs_control_notes"
                                                   value="<?= h($registration->bpjs_control_notes ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:11px; font-weight:600;">RENCANA TINDAKAN SAAT KONTROL</label>
                                            <input type="text" class="form-control input-sm"
                                                   name="bpjs_control_plan"
                                                   value="<?= h($registration->bpjs_control_plan ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label style="font-size:11px; font-weight:600;">Alasan blm dikembalikan ke perujuk</label>
                                            <textarea class="form-control" rows="4"
                                                      name="skdp_notes"><?= h($registration->skdp_notes ?? '') ?></textarea>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-8">
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fa fa-save"></i> BUAT SKDP
                                                </button>
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <i class="fa fa-print"></i> CETAK SKDP
                                                </button>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <label style="margin-top:6px;">
                                                    <input type="checkbox" name="skdp_print_classic" value="1">
                                                    Print Classic
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- /tab-skdp -->

                    </div><!-- /tab-content -->
                </div>
            </div><!-- /panel surat-rujuk-skdp -->

            <!-- Diagnosa & ICD -->
            <div class="panel panel-default" style="margin-top:10px;">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-diagnoses"></i> Diagnosa & ICD</strong>
                </div>
                <div class="panel-body" style="padding:8px 12px;">
                    <input type="hidden" name="diagnosis_primary" id="diagnosis_primary_hidden"
                        value="<?= h($emr->diagnosis_primary ?? '') ?>">
                    <input type="hidden" name="diagnosis_secondary" id="diagnosis_secondary_hidden"
                        value="<?= h($emr->diagnosis_secondary ?? '') ?>">
                    <input type="hidden" name="action_notes" id="action_notes_hidden"
                        value="<?= h($emr->action_notes ?? '') ?>">

                    <!-- ICD-10 -->
                    <div style="margin-top:10px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                            <label style="font-size:11px; font-weight:700; color:#1e3a5f; margin:0;">
                                <i class="fa fa-diagnoses" style="color:#1e3a5f;"></i> ICD-10
                            </label>
                            <?php if (!$isDone): ?>
                                <button type="button" class="btn btn-xs btn-default" id="btn-add-icd10"
                                        style="font-size:10px; color:#1e3a5f; border-color:#1e3a5f;">
                                    <i class="fa fa-search"></i> Tambah ICD-10
                                </button>
                            <?php endif; ?>
                        </div>

                        <?php if (!$isDone): ?>
                        <div id="icd10-search-bar" style="display:none; margin-bottom:6px; position:relative;">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="background:#1e3a5f; color:#fff;">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" id="icd10-search-input" class="form-control"
                                       placeholder="Ketik kode (A09) atau nama diagnosa..."
                                       autocomplete="off">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-default" id="btn-close-icd10-search">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </div>
                            <div id="icd10-dropdown" style="display:none; position:absolute; z-index:9999;
                                background:#fff; border:1px solid #ced4da; border-radius:6px;
                                box-shadow:0 4px 16px rgba(0,0,0,.12); max-height:240px; overflow-y:auto;
                                width:100%; font-size:12px; top:100%; left:0;"></div>
                        </div>
                        <?php endif; ?>

                        <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:0;">
                            <thead>
                                <tr style="background:#dbeafe;">
                                    <th style="width:55px; text-align:center;">Utama</th>
                                    <th style="width:80px;">Kode</th>
                                    <th>Nama Diagnosa (ICD-10)</th>
                                    <?php if (!$isDone): ?><th style="width:28px;"></th><?php endif; ?>
                                </tr>
                            </thead>
                            <tbody id="icd10-body">
                                <?php
                                $icd10Items = [];
                                if (!empty($registration->icd10_items)) {
                                    $icd10Items = is_string($registration->icd10_items)
                                        ? json_decode($registration->icd10_items, true) ?? []
                                        : (array)$registration->icd10_items;
                                } elseif (!empty($registration->diagnosis_primary)) {
                                    $icd10Items = [[
                                        'kode' => $registration->diagnosis_primary,
                                        'nama' => $registration->diagnosis_desc ?? '',
                                    ]];
                                }
                                ?>
                                <?php foreach ($icd10Items as $idx => $item): ?>
                                    <tr class="icd10-row" data-idx="<?= $idx ?>">
                                        <input type="hidden" name="icd10_selected[<?= $idx ?>]" value="1">
                                        <td class="text-center" style="vertical-align:middle;">
                                            <input type="radio" name="icd10_utama" value="<?= $idx ?>"
                                                   <?= (!empty($item['utama']) || $idx === 0) ? 'checked' : '' ?>
                                                   <?= $isDone ? 'disabled' : '' ?>>
                                        </td>
                                        <td>
                                            <input type="text" name="icd10_code[<?= $idx ?>]"
                                                   class="form-control input-sm"
                                                   value="<?= h($item['kode'] ?? '') ?>"
                                                   style="font-family:monospace; font-weight:700;"
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                        </td>
                                        <td>
                                            <input type="text" name="icd10_nama[<?= $idx ?>]"
                                                   class="form-control input-sm"
                                                   value="<?= h($item['nama'] ?? '') ?>"
                                                   placeholder="Nama diagnosa..."
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                        </td>
                                        <?php if (!$isDone): ?>
                                            <td class="text-center" style="vertical-align:middle;">
                                                <button type="button" class="btn btn-xs btn-danger btn-remove-icd10">&times;</button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($icd10Items)): ?>
                                    <tr id="icd10-empty-row">
                                        <td colspan="<?= $isDone ? 3 : 4 ?>"
                                            style="text-align:center; color:#aaa; padding:10px; font-size:11px;">
                                            <i class="fa fa-diagnoses"></i> Belum ada diagnosa ICD-10.
                                            <?php if (!$isDone): ?>Klik <strong>Tambah ICD-10</strong> untuk menambahkan.<?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div><!-- /ICD-10 -->

                    <!-- ICD-9 CM -->
                    <div style="margin-top:8px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                            <label style="font-size:11px; font-weight:700; color:#1e3a5f; margin:0;">
                                <i class="fa fa-clipboard-list" style="color:#6f42c1;"></i> ICD-9 CM
                            </label>
                            <?php if (!$isDone): ?>
                                <button type="button" class="btn btn-xs btn-default" id="btn-add-icd9"
                                        style="font-size:10px; color:#6f42c1; border-color:#6f42c1;">
                                    <i class="fa fa-search"></i> Tambah ICD-9
                                </button>
                            <?php endif; ?>
                        </div>

                        <?php if (!$isDone): ?>
                        <div id="icd9-search-bar" style="display:none; margin-bottom:6px; position:relative;">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="background:#6f42c1; color:#fff;">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" id="icd9-search-input" class="form-control"
                                       placeholder="Ketik kode (47.09) atau nama tindakan..."
                                       autocomplete="off">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-default" id="btn-close-icd9-search">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </div>
                            <div id="icd9-dropdown" style="display:none; position:absolute; z-index:9999;
                                background:#fff; border:1px solid #ced4da; border-radius:6px;
                                box-shadow:0 4px 16px rgba(0,0,0,.12); max-height:240px; overflow-y:auto;
                                width:100%; font-size:12px; top:100%; left:0;"></div>
                        </div>
                        <?php endif; ?>

                        <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:0;">
                            <thead>
                                <tr style="background:#f3e8ff;">
                                    <th style="width:55px; text-align:center;">Utama</th>
                                    <th style="width:80px;">Kode</th>
                                    <th>Nama Tindakan (ICD-9)</th>
                                    <?php if (!$isDone): ?><th style="width:28px;"></th><?php endif; ?>
                                </tr>
                            </thead>
                            <tbody id="icd9-body">
                                <?php
                                $icd9Items = [];
                                if (!empty($registration->icd9_items)) {
                                    $icd9Items = is_string($registration->icd9_items)
                                        ? json_decode($registration->icd9_items, true) ?? []
                                        : (array)$registration->icd9_items;
                                } elseif (!empty($registration->diagnosis_secondary)) {
                                    $icd9Items = [[
                                        'kode'     => $registration->diagnosis_secondary,
                                        'nama'     => $registration->diagnosis_secondary,
                                        'kategori' => '',
                                    ]];
                                }
                                ?>
                                <?php foreach ($icd9Items as $idx => $item): ?>
                                    <tr class="icd9-row" data-idx="<?= $idx ?>">
                                        <input type="hidden" name="icd9_selected[<?= $idx ?>]" value="1">
                                        <input type="hidden" name="icd9_kategori[<?= $idx ?>]"
                                               value="<?= h($item['kategori'] ?? '') ?>">
                                        <td class="text-center" style="vertical-align:middle;">
                                            <input type="radio" name="icd9_utama" value="<?= $idx ?>"
                                                   <?= (!empty($item['utama']) || $idx === 0) ? 'checked' : '' ?>
                                                   <?= $isDone ? 'disabled' : '' ?>>
                                        </td>
                                        <td>
                                            <input type="text" name="icd9_code[<?= $idx ?>]"
                                                   class="form-control input-sm"
                                                   value="<?= h($item['kode'] ?? '') ?>"
                                                   style="font-family:monospace; font-weight:700;"
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                        </td>
                                        <td>
                                            <input type="text" name="icd9_nama[<?= $idx ?>]"
                                                   class="form-control input-sm"
                                                   value="<?= h($item['nama'] ?? '') ?>"
                                                   placeholder="Nama tindakan..."
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                        </td>
                                        <?php if (!$isDone): ?>
                                            <td class="text-center" style="vertical-align:middle;">
                                                <button type="button" class="btn btn-xs btn-danger btn-remove-icd9">&times;</button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($icd9Items)): ?>
                                    <tr id="icd9-empty-row">
                                        <td colspan="<?= $isDone ? 3 : 4 ?>"
                                            style="text-align:center; color:#aaa; padding:10px; font-size:11px;">
                                            <i class="fa fa-clipboard-list"></i> Belum ada tindakan ICD-9.
                                            <?php if (!$isDone): ?>Klik <strong>Tambah ICD-9</strong> untuk menambahkan.<?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div><!-- /ICD-9 CM -->

                    <!-- Vital summary -->
                    <div id="vital-summary" style="margin-top:8px; background:#f8f9fa; border-radius:4px;
                                                    padding:6px 10px; font-size:11px; color:#555; display:none;">
                        <i class="fa fa-info-circle" style="color:#17a2b8;"></i>
                        <span id="vital-summary-text"></span>
                    </div>
                </div>
            </div>

            <!-- Toolbar aksi bawah -->
            <div class="panel panel-default" style="margin-top:10px;">
                <div class="panel-body" style="padding:10px; background:#fafafa;">
                    <div class="row">
                        <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                            <button type="button" class="btn btn-default btn-sm btn-block">
                                <i class="fa fa-id-card"></i> ICARE-JKN
                            </button>
                        </div>
                        <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                            <button type="button" class="btn btn-info btn-sm btn-block">
                                <i class="fa fa-book-medical"></i> REKAM MEDIS
                            </button>
                        </div>
                        <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                            <button type="button" class="btn btn-success btn-sm btn-block">
                                <i class="fa fa-stethoscope"></i> HASIL PEMERIKSAAN
                            </button>
                        </div>
                        <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                            <button type="button"
                                    id="btn-selesai-periksa"
                                    class="btn btn-danger btn-sm btn-block"
                                    data-url="<?= $this->Url->build([
                                        'controller' => 'EmergencyEntries',
                                        'action'     => 'selesaiPeriksa',
                                        $registration->id,
                                    ]) ?>">
                                <i class="fa fa-check-circle"></i> SELESAI PERIKSA
                            </button>
                        </div>
                        <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                <i class="fa fa-save"></i> SIMPAN
                            </button>
                        </div>
                        <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                            <button type="button" onclick="window.print();"
                                    class="btn btn-default btn-sm btn-block">
                                <i class="fa fa-print"></i> CETAK
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /col kiri -->

        <!-- ════════════════════════════════════════════════════
             KOLOM KANAN
             ════════════════════════════════════════════════════ -->
        <div class="col-md-6">

            <!-- Tanda Vital -->
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-heartbeat"></i> Tanda Vital</strong>
                </div>
                <div class="panel-body" style="padding:8px 12px;">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="vital-row">
                                <label>Nadi</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="pulse" class="form-control"
                                           value="<?= h($registration->pulse ?? '') ?>"
                                           min="1" max="300" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">/Menit</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Pernapasan</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="respiratory_rate" class="form-control"
                                           value="<?= h($registration->respiratory_rate ?? '') ?>"
                                           min="1" max="60" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">/Menit</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Tekanan Darah</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="blood_pressure" class="form-control"
                                           value="<?= h($registration->blood_pressure ?? '') ?>"
                                           placeholder="120/80" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">mmHg</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Suhu Badan</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="temperature" class="form-control"
                                           value="<?= h($registration->temperature ?? '') ?>"
                                           step="0.1" min="30" max="45"
                                           <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">°C</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Sp O2</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="oxygen_saturation" class="form-control"
                                           value="<?= h($registration->oxygen_saturation ?? '') ?>"
                                           min="1" max="100" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Skala Nyeri</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="pain_scale" class="form-control"
                                           value="<?= h($registration->pain_scale ?? '') ?>"
                                           min="0" max="10" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">0-10</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div style="background:#f0f9ff; border-radius:6px; padding:8px; border:1px solid #bee3f8;">
                                <div style="font-size:10px; font-weight:700; color:#2b6cb0; margin-bottom:6px;">
                                    <i class="fa fa-weight"></i> GIZI
                                </div>
                                <div class="vital-row">
                                    <label>Berat Badan</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="weight" id="weight" class="form-control"
                                               value="<?= h($registration->weight ?? '') ?>"
                                               step="0.1" min="0.1" max="500"
                                               <?= $isDone ? 'readonly' : '' ?>>
                                        <span class="input-group-addon">Kg</span>
                                    </div>
                                </div>
                                <div class="vital-row">
                                    <label>Tinggi Badan</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="height" id="height" class="form-control"
                                               value="<?= h($registration->height ?? '') ?>"
                                               step="0.1" min="1" max="250"
                                               <?= $isDone ? 'readonly' : '' ?>>
                                        <span class="input-group-addon">CM</span>
                                    </div>
                                </div>
                                <div class="vital-row">
                                    <label>BMI</label>
                                    <input type="text" name="bmi" id="bmi-display" class="form-control input-sm"
                                           readonly
                                           value="<?= !empty($registration->bmi) ? number_format($registration->bmi, 2) : '' ?>"
                                           style="background:#fff; font-weight:700; color:#1e3a5f;">
                                </div>
                                <div class="vital-row">
                                    <label>BMI Result</label>
                                    <input type="text" name="bmi_category" id="bmi-result"
                                           class="form-control input-sm" readonly
                                           value="<?= h($registration->bmi_category ?? '') ?>"
                                           style="background:#fff;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keluhan Awal -->
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-comment-medical"></i> Keluhan Awal</strong>
                </div>
                <div class="panel-body" style="padding:8px 12px;">
                    <textarea name="chief_complaint" class="form-control" rows="3"
                              style="font-size:12px; resize:none;"
                              placeholder="Keluhan utama yang disampaikan pasien..."
                              <?= $isDone ? 'readonly' : '' ?>><?= h($registration->chief_complaint ?? '') ?></textarea>
                </div>
            </div>

            <!-- Pemeriksaan -->
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-stethoscope"></i> Pemeriksaan</strong>
                </div>
                <div class="panel-body" style="padding:8px 12px;">
                    <textarea name="illness_history" class="form-control" rows="3"
                              style="font-size:12px; resize:none;"
                              placeholder="Hasil pemeriksaan fisik, riwayat penyakit..."
                              <?= $isDone ? 'readonly' : '' ?>><?= h($registration->illness_history ?? '') ?></textarea>
                </div>
            </div>

            <!-- Diagnosa Saat Masuk -->
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-stethoscope"></i> Diagnosa Saat Masuk</strong>
                </div>
                <div class="panel-body" style="padding:8px 12px;">
                    <textarea name="admission_diagnosis" class="form-control input-sm" rows="3"
                              style="font-size:12px; resize:none;"
                              placeholder="Diagnosa awal saat pasien masuk IGD..."
                              <?= $isDone ? 'readonly' : '' ?>><?= h($registration->admission_diagnosis ?? '') ?></textarea>
                </div>
            </div>

            <!-- Obat / Resep -->
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-pills"></i> Obat / Resep</strong>
                </div>
                <div class="panel-body" style="padding:8px 12px;">
                    <textarea name="prescription_notes" class="form-control" rows="3"
                              style="font-size:12px; resize:none;"
                              placeholder="Nama obat, dosis, aturan pakai..."
                              <?= $isDone ? 'readonly' : '' ?>><?= h($registration->prescription_notes ?? '') ?></textarea>
                </div>
            </div>

            <!-- Saran / Anjuran -->
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-lightbulb"></i> Saran / Anjuran</strong>
                </div>
                <div class="panel-body" style="padding:8px 12px;">
                    <textarea name="doctor_notes" class="form-control" rows="2"
                              style="font-size:12px; resize:none;"
                              placeholder="Saran, anjuran, edukasi pasien..."
                              <?= $isDone ? 'readonly' : '' ?>><?= h($registration->doctor_notes ?? '') ?></textarea>
                </div>
            </div>

        </div><!-- /col kanan -->
    </div><!-- /row -->

    <?= $this->Form->end() ?>

</div>

<!-- ══════════════════════════════════════════════
     AUTOCOMPLETE DROPDOWN TINDAKAN (fixed to body)
     ══════════════════════════════════════════════ -->
<div id="tindakan-dropdown" style="
    display:none;
    position:fixed;
    z-index:99999;
    background:#fff;
    border:1px solid #ced4da;
    border-radius:6px;
    box-shadow:0 6px 20px rgba(0,0,0,.15);
    max-height:260px;
    overflow-y:auto;
    min-width:320px;
    font-size:12px;
"></div>

<style>
.vital-row { margin-bottom: 6px; }
.vital-row label { font-size: 10px; color: #888; margin-bottom: 2px; display: block; font-weight: 600; }
.input-group-addon { font-size: 11px; padding: 4px 6px; }
.panel-heading strong { font-size: 12px; }

.emr-tab-panel { background:#fff; border:1px solid #ddd; }
.emr-tab-panel > .panel-heading { background:#f5f7fa !important; border-bottom:1px solid #d9d9d9; min-height:42px; }
#tab-surat-rujuk.emr-tabs { background:#f5f7fa; border-bottom:0 !important; padding-top:0; }
#tab-surat-rujuk.emr-tabs > li > a {
    border-radius:0 !important; color:#333 !important; background:#f5f7fa !important;
    border:1px solid transparent !important; border-right:1px solid #d9d9d9 !important;
    padding:10px 18px !important; min-height:42px; font-size:12px !important;
    font-weight:600; line-height:20px; margin-right:0 !important;
}
#tab-surat-rujuk.emr-tabs > li.active > a,
#tab-surat-rujuk.emr-tabs > li.active > a:focus,
#tab-surat-rujuk.emr-tabs > li.active > a:hover {
    background:#7b1c1c !important; color:#fff !important; border-color:#7b1c1c !important;
}
#tab-surat-rujuk.emr-tabs > li > a:hover { background:#e9eef5 !important; color:#7b1c1c !important; }
.emr-tab-body { border-top:0; min-height:245px; }
.emr-tab-body .tab-content { margin-top:0; }

.poly-dd-item { padding:7px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; }
.poly-dd-item:hover { background:#e8f0fe; }
.poly-dd-name { font-weight:600; color:#7b1c1c; }
.poly-dd-empty, .poly-dd-loading { padding:10px; text-align:center; color:#888; font-size:12px; }

.doctor-dd-item { padding:7px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; }
.doctor-dd-item:hover { background:#e8f0fe; }
.doctor-dd-name { font-weight:600; color:#7b1c1c; }
.doctor-dd-meta, .doctor-dd-empty, .doctor-dd-loading { padding:10px; color:#888; font-size:12px; }
.doctor-dd-empty, .doctor-dd-loading { text-align:center; }

input.action-qty::-webkit-outer-spin-button,
input.action-qty::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
input.action-qty { -moz-appearance: textfield; }

input.action-unit-price-display {
    background: #f0f0f0 !important; cursor: default !important;
    color: #333 !important; font-weight: 600; text-align: right;
}
input.action-unit-price-display:focus { outline: none; box-shadow: none; border-color: #ced4da; }

#tindakan-dropdown .dd-item {
    padding: 7px 12px; cursor: pointer;
    border-bottom: 1px solid #f0f0f0; line-height: 1.4; transition: background .1s;
}
#tindakan-dropdown .dd-item:hover,
#tindakan-dropdown .dd-item.active { background: #e8f0fe !important; }
#tindakan-dropdown .dd-item:last-child { border-bottom: none; }
#tindakan-dropdown .dd-header {
    padding: 4px 10px; font-size: 10px; font-weight: 700; color: #888;
    background: #f8f9fa; border-bottom: 1px solid #eee;
    text-transform: uppercase; letter-spacing: .5px; position: sticky; top: 0;
}
#tindakan-dropdown .dd-item-name { font-weight: 600; color: #7b1c1c; font-size: 12px; }
#tindakan-dropdown .dd-item-meta { font-size: 10px; color: #888; margin-top: 1px; }
#tindakan-dropdown .dd-item-harga { font-weight: 600; color: #27ae60; }
#tindakan-dropdown .dd-empty { padding: 12px; text-align: center; color: #aaa; font-size: 12px; }
#tindakan-dropdown .dd-loading { padding: 12px; text-align: center; color: #888; font-size: 12px; }
#tindakan-dropdown .dd-error { padding: 10px 12px; color: #721c24; background: #f8d7da; font-size: 11px; }
</style>

<script>
$(document).ready(function () {

    // ── URL Config ──────────────────────────────────────────────────────────
    var SEARCH_URL = <?= json_encode($this->Url->build(['controller' => 'MasterTindakan', 'action' => 'search'])) ?>;
    var DEBUG_URL  = <?= json_encode($this->Url->build(['controller' => 'MasterTindakan', 'action' => 'searchDebug'])) ?>;
    var ICD9_SEARCH_URL  = <?= json_encode($this->Url->build(['controller' => 'MasterIcd9',  'action' => 'search'])) ?>;
    var ICD10_SEARCH_URL = <?= json_encode($this->Url->build(['controller' => 'MasterIcd10', 'action' => 'search'])) ?>;
    var POLYCLINIC_SEARCH_URL    = <?= json_encode($this->Url->build(['controller' => 'PolyclinicQueues', 'action' => 'searchPolyQueue'])) ?>;
    var CREATE_REFERRAL_QUEUE_URL = <?= json_encode($this->Url->build(['controller' => 'PolyclinicQueues', 'action' => 'createReferralQueue'])) ?>;
    var DOCTOR_BY_POLY_URL = <?= json_encode($this->Url->build(['controller' => 'Doctors', 'action' => 'searchByPolyclinic'])) ?>;

    // ── Helper ───────────────────────────────────────────────────────────────
    function escHtml(str) { return $('<div>').text(String(str || '')).html(); }
    function setDebug(msg) { $('#debug-text').text(msg); }

    // ── AJAX Poliklinik ──────────────────────────────────────────────────────
    var polyclinicTimer = null;
    var $polyInput    = $('#referral-polyclinic-search');
    var $polyValue    = $('#referral-polyclinic-value');
    var $polyQueue    = $('#referral-queue-no');
    var $polyDropdown = $('#polyclinic-dropdown');

    function closePolyclinicDropdown() { $polyDropdown.hide().empty(); }

    function renderPolyclinicDropdown(data) {
        $polyDropdown.empty();
        if (!data || !data.length) {
            $polyDropdown.html('<div class="poly-dd-empty"><i class="fa fa-search"></i> Poliklinik tidak ditemukan</div>').show();
            return;
        }
        $.each(data, function (_, item) {
            var nama      = item.poly_name || item.name || item.nama || item.polyclinic_name || '';
            var nextQueue = item.next_queue_number || item.next_queue_no || item.queue_number || item.queue_no || 0;
            var meta      = nextQueue ? 'No antrian berikutnya: ' + nextQueue : 'No antrian akan dibuat otomatis';
            $('<div class="poly-dd-item" data-name="' + escHtml(nama) + '" data-queue="' + escHtml(nextQueue) + '">'
                + '<div class="poly-dd-name">' + escHtml(nama) + '</div>'
                + '<div style="font-size:10px;color:#777;margin-top:2px;">' + escHtml(meta) + '</div>'
                + '</div>')
                .on('mousedown', function (e) {
                    e.preventDefault();
                    $polyInput.val(nama); $polyValue.val(nama); $polyQueue.val(nextQueue || 0);
                    $('#referral-doctor-search').val(''); $('#referral-doctor-value').val('');
                    $('#doctor-dropdown').hide().empty();
                    closePolyclinicDropdown();
                }).appendTo($polyDropdown);
        });
        $polyDropdown.show();
    }

    $polyInput.on('input', function () {
        var q = $.trim($(this).val());
        $polyValue.val(q); $polyQueue.val(0);
        $('#referral-doctor-search').val(''); $('#referral-doctor-value').val('');
        clearTimeout(polyclinicTimer);
        if (q.length < 1) { closePolyclinicDropdown(); return; }
        $polyDropdown.html('<div class="poly-dd-loading"><i class="fa fa-spinner fa-spin"></i> Mencari poliklinik...</div>').show();
        polyclinicTimer = setTimeout(function () {
            $.ajax({ url: POLYCLINIC_SEARCH_URL, method: 'GET', data: { q: q }, dataType: 'json', timeout: 5000,
                success: function (data) { renderPolyclinicDropdown(data); },
                error: function () { $polyDropdown.html('<div class="poly-dd-empty">Endpoint belum tersedia.</div>').show(); }
            });
        }, 250);
    });

    $polyInput.on('blur', function () { setTimeout(closePolyclinicDropdown, 150); });
    $(document).on('mousedown', function (e) {
        if (!$(e.target).closest('#referral-polyclinic-search, #polyclinic-dropdown').length) closePolyclinicDropdown();
    });

    // ── AJAX Dokter ──────────────────────────────────────────────────────────
    var doctorTimer = null;
    var $doctorInput    = $('#referral-doctor-search');
    var $doctorValue    = $('#referral-doctor-value');
    var $doctorDropdown = $('#doctor-dropdown');

    function closeDoctorDropdown() { $doctorDropdown.hide().empty(); }

    function renderDoctorDropdown(data) {
        $doctorDropdown.empty();
        if (!data || !data.length) {
            $doctorDropdown.html('<div class="doctor-dd-empty"><i class="fa fa-user-md"></i> Dokter tidak ditemukan</div>').show();
            return;
        }
        $.each(data, function (_, item) {
            var doctorName = item.doctor_name || item.name || '';
            var specialist = item.specialist || '';
            var polyName   = item.polyclinic_name || '';
            $('<div class="doctor-dd-item" data-name="' + escHtml(doctorName) + '">'
                + '<div class="doctor-dd-name">' + escHtml(doctorName) + '</div>'
                + '<div style="font-size:10px;color:#777;margin-top:2px;">' + escHtml((specialist || 'Dokter') + (polyName ? ' · ' + polyName : '')) + '</div>'
                + '</div>')
                .on('mousedown', function (e) {
                    e.preventDefault(); $doctorInput.val(doctorName); $doctorValue.val(doctorName);
                    closeDoctorDropdown();
                }).appendTo($doctorDropdown);
        });
        $doctorDropdown.show();
    }

    function searchDoctorByPolyclinic() {
        var polyName = $.trim($polyValue.val() || $polyInput.val());
        if (!polyName) { $doctorDropdown.html('<div class="doctor-dd-empty">Pilih poliklinik terlebih dahulu</div>').show(); return; }
        $doctorDropdown.html('<div class="doctor-dd-loading"><i class="fa fa-spinner fa-spin"></i> Mencari dokter...</div>').show();
        $.ajax({ url: DOCTOR_BY_POLY_URL, method: 'GET', data: { poly_name: polyName, q: $.trim($doctorInput.val()) },
            dataType: 'json', timeout: 5000,
            success: function (data) { renderDoctorDropdown(data); },
            error: function () { $doctorDropdown.html('<div class="doctor-dd-empty">Endpoint belum tersedia.</div>').show(); }
        });
    }

    $doctorInput.on('focus input', function () { clearTimeout(doctorTimer); doctorTimer = setTimeout(searchDoctorByPolyclinic, 200); });
    $doctorInput.on('blur', function () { setTimeout(closeDoctorDropdown, 150); });
    $(document).on('mousedown', function (e) {
        if (!$(e.target).closest('#referral-doctor-search, #doctor-dropdown').length) closeDoctorDropdown();
    });

    // ── Jadwal Kontrol ───────────────────────────────────────────────────────
    $('#btn-jadwal-kontrol').on('click', function () {
        var $btn      = $(this);
        var polyName  = $.trim($('#referral-polyclinic-value').val() || $('#referral-polyclinic-search').val());
        var patientName = <?= json_encode($p->full_name ?? '') ?>;
        var phoneNumber = <?= json_encode($p->phone_number ?? '') ?>;
        var visitDate   = $('input[name="referral_date"]').val() || <?= json_encode(date('Y-m-d')) ?>;
        var csrfToken   = $('input[name="_csrfToken"]').val() || $('meta[name="csrfToken"]').attr('content') || '';

        if (!polyName) { alert('Pilih poliklinik dulu.'); $('#referral-polyclinic-search').focus(); return; }
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Membuat...');

        $.ajax({ url: CREATE_REFERRAL_QUEUE_URL, method: 'POST', dataType: 'json',
            headers: csrfToken ? { 'X-CSRF-Token': csrfToken } : {},
            data: { poly_name: polyName, patient_name: patientName, phone_number: phoneNumber, visit_date: visitDate },
            success: function (res) {
                if (res && res.success) { $('#referral-queue-no').val(res.queue_number || 0); alert('Antrian berhasil dibuat: ' + (res.code || '-')); }
                else { alert((res && res.message) ? res.message : 'Gagal membuat antrian.'); }
            },
            error: function (xhr) {
                alert(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Endpoint createReferralQueue belum tersedia.');
            },
            complete: function () { $btn.prop('disabled', false).html('Jadwal Kontrol'); }
        });
    });

    // ── BMI ──────────────────────────────────────────────────────────────────
    function calcBMI() {
        var w = parseFloat($('#weight').val()), h = parseFloat($('#height').val());
        if (w > 0 && h > 0) {
            var hm = h / 100, bmi = (w / (hm * hm)).toFixed(2);
            $('#bmi-display').val(bmi);
            $('#bmi-result').val(bmi < 18.5 ? 'Underweight' : bmi < 25 ? 'NormalWeight' : bmi < 30 ? 'Overweight' : 'Obese');
            updateVitalSummary();
        } else { $('#bmi-display').val(''); $('#bmi-result').val(''); }
    }

    function updateVitalSummary() {
        var parts = [], bp = $('input[name="blood_pressure"]').val(), bmiRes = $('#bmi-result').val(), temp = $('input[name="temperature"]').val();
        if (bp) { var sys = parseInt(bp.split('/')[0]) || 0; parts.push(sys < 90 ? 'Tensi: Hipotensi' : sys > 140 ? 'Tensi: Hipertensi' : 'Tensi: Normal'); }
        if (bmiRes) parts.push('Gizi: ' + bmiRes);
        if (temp) { var t = parseFloat(temp); parts.push(t >= 37.5 ? 'Suhu: Demam' : t < 36 ? 'Suhu: Hipotermia' : 'Suhu: Normal'); }
        if (parts.length) { $('#vital-summary-text').text(parts.join(' · ')); $('#vital-summary').show(); }
        else { $('#vital-summary').hide(); }
    }

    $('#weight, #height').on('input', calcBMI);
    $('input[name="blood_pressure"], input[name="temperature"]').on('input', updateVitalSummary);
    calcBMI(); updateVitalSummary();

    // ── Grand Total ──────────────────────────────────────────────────────────
    function calcGrandTotal() {
        var grand = 0;
        $('.action-row').each(function () {
            var qty = parseFloat($(this).find('.action-qty').val()) || 0;
            var price = parseFloat($(this).find('.action-unit-price').val()) || 0;
            var total = qty * price;
            grand += total;
            $(this).find('.action-total').val(total > 0 ? Math.round(total).toLocaleString('id-ID') : '0');
        });
        $('#total-fee').val(Math.round(grand));
    }

    $(document).on('input', '.action-qty', calcGrandTotal);

    // ── Tambah / Hapus Tindakan ──────────────────────────────────────────────
    var actionIndex = <?= !empty($registration->emergency_actions) ? count($registration->emergency_actions) : 0 ?>;

    $('#btn-add-action').on('click', function () { addActionRow(); });

    function addActionRow(prefill) {
        prefill = prefill || {};
        var i = actionIndex++, hargaRaw = parseFloat(prefill.harga) || 0;
        var hargaDisplay = hargaRaw > 0 ? hargaRaw.toLocaleString('id-ID') : '0';
        var row = '<tr class="action-row">'
            + '<td><input type="text" name="emergency_actions[' + i + '][action_code]" class="form-control input-sm" placeholder="Kode..." value="' + escHtml(prefill.kode || '') + '"></td>'
            + '<td style="position:relative;">'
            +   '<input type="text" name="emergency_actions[' + i + '][action_name]" class="form-control input-sm action-name" placeholder="Ketik nama tindakan..." autocomplete="off" required value="' + escHtml(prefill.nama || '') + '">'
            +   '<input type="hidden" name="emergency_actions[' + i + '][action_category]" value="' + escHtml(prefill.kategori || 'tindakan_medis') + '">'
            +   '<input type="hidden" name="emergency_actions[' + i + '][notes]" value="">'
            + '</td>'
            + '<td><input type="number" name="emergency_actions[' + i + '][quantity]" class="form-control input-sm action-qty" value="1" min="1" style="text-align:center; -moz-appearance:textfield;"></td>'
            + '<td>'
            +   '<input type="text" class="form-control input-sm action-unit-price-display" value="' + hargaDisplay + '" readonly style="text-align:right; background:#f0f0f0; cursor:default; color:#333; font-weight:600;">'
            +   '<input type="hidden" name="emergency_actions[' + i + '][unit_price]" class="action-unit-price" value="' + hargaRaw + '">'
            + '</td>'
            + '<td><input type="text" class="form-control input-sm action-total" readonly value="0" style="background:#f5f5f5; text-align:right;"></td>'
            + '<td class="text-center"><button type="button" class="btn btn-xs btn-danger btn-remove-action">&times;</button></td>'
            + '</tr>';
        $('#actions-body').append(row);
        $('#actions-body tr:last .action-name').focus();
        calcGrandTotal();
    }

    $(document).on('click', '.btn-remove-action', function () { $(this).closest('tr').remove(); closeDropdown(); calcGrandTotal(); });

    // ── Hapus ICD-10 ─────────────────────────────────────────────────────────
    $(document).on('click', '.btn-remove-icd10', function () {
        $(this).closest('tr.icd10-row').remove();
        if (!$('#icd10-body .icd10-row').length) {
            $('#icd10-body').append('<tr id="icd10-empty-row"><td colspan="<?= $isDone ? 3 : 4 ?>" style="text-align:center;color:#aaa;padding:10px;font-size:11px;"><i class="fa fa-diagnoses"></i> Belum ada diagnosa ICD-10.</td></tr>');
        } else if (!$('input[name="icd10_utama"]:checked').length) {
            $('#icd10-body .icd10-row:first input[name="icd10_utama"]').prop('checked', true);
        }
    });

    // ── Hapus ICD-9 ──────────────────────────────────────────────────────────
    $(document).on('click', '.btn-remove-icd9', function () {
        $(this).closest('tr.icd9-row').remove();
        if (!$('#icd9-body .icd9-row').length) {
            $('#icd9-body').append('<tr id="icd9-empty-row"><td colspan="<?= $isDone ? 3 : 4 ?>" style="text-align:center;color:#aaa;padding:10px;font-size:11px;"><i class="fa fa-clipboard-list"></i> Belum ada tindakan ICD-9.</td></tr>');
        } else if (!$('input[name="icd9_utama"]:checked').length) {
            $('#icd9-body .icd9-row:first input[name="icd9_utama"]').prop('checked', true);
        }
    });

    // ── Simpan Tab Aktif ─────────────────────────────────────────────────────
    var tabKey = 'emr_igd_tab_<?= (int)$registration->id ?>';
    var activeTab = localStorage.getItem(tabKey);
    if (activeTab) { $('#tab-surat-rujuk a[href="' + activeTab + '"]').tab('show'); }
    $('#tab-surat-rujuk a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr('href');
        localStorage.setItem(tabKey, target);
        $('#tab-surat-rujuk li').removeClass('active');
        $(e.target).closest('li').addClass('active');
    });
    $('#tab-surat-rujuk li.active a[data-toggle="tab"]').tab('show');
    calcGrandTotal();

    // ── Autocomplete Tindakan ────────────────────────────────────────────────
    var $dropdown = $('#tindakan-dropdown'), $activeInput = null, autocompleteTimer = null, lastQuery = '', isSearching = false;

    $(document).on('mousedown', function (e) {
        if (!$(e.target).closest('#tindakan-dropdown').length && !$(e.target).hasClass('action-name')) closeDropdown();
    });

    function closeDropdown() { $dropdown.hide().empty(); $activeInput = null; lastQuery = ''; }

    $(document).on('keydown', '.action-name', function (e) {
        if (!$dropdown.is(':visible')) return;
        var $items = $dropdown.find('.dd-item'), $active = $items.filter('.active');
        if (e.key === 'ArrowDown') { e.preventDefault(); var $n = $active.length ? $active.nextAll('.dd-item').first() : $items.first(); $items.removeClass('active'); $n.addClass('active'); scrollToActive($n); }
        else if (e.key === 'ArrowUp') { e.preventDefault(); var $p = $active.length ? $active.prevAll('.dd-item').first() : $items.last(); $items.removeClass('active'); $p.addClass('active'); scrollToActive($p); }
        else if (e.key === 'Enter' && $active.length) { e.preventDefault(); $active.trigger('mousedown'); }
        else if (e.key === 'Escape') { closeDropdown(); }
    });

    function scrollToActive($item) {
        if (!$item.length) return;
        var it = $item.position().top, ib = it + $item.outerHeight(), dh = $dropdown.height(), st = $dropdown.scrollTop();
        if (it < 0) $dropdown.scrollTop(st + it); else if (ib > dh) $dropdown.scrollTop(st + (ib - dh));
    }

    $(document).on('input', '.action-name', function () {
        var $input = $(this); $activeInput = $input;
        clearTimeout(autocompleteTimer);
        var q = $.trim($input.val());
        if (q.length < 1) { closeDropdown(); return; }
        if (q === lastQuery && $dropdown.is(':visible')) return;
        showLoading($input);
        autocompleteTimer = setTimeout(function () { doSearch(q, $input); }, 200);
    });

    $(document).on('focus', '.action-name', function () {
        var $input = $(this), q = $.trim($input.val());
        if (q.length >= 1 && !$dropdown.is(':visible')) { $activeInput = $input; doSearch(q, $input); }
    });

    function doSearch(q, $input) {
        if (isSearching) return; isSearching = true;
        $.ajax({ url: SEARCH_URL, method: 'GET', data: { q: q }, dataType: 'json', timeout: 5000,
            success: function (data) {
                isSearching = false; lastQuery = q;
                if (data && data._error) { showError($input, 'Server error: ' + (data._message || 'Unknown')); return; }
                if ($activeInput && $.trim($activeInput.val()) === q) renderDropdown(data, $input);
            },
            error: function (xhr, status, error) {
                isSearching = false;
                var msg = status === 'timeout' ? 'Timeout' : xhr.status === 404 ? '404 — URL tidak ditemukan' : 'Error ' + xhr.status + ': ' + error;
                showError($input, msg); setDebug(msg); $('#debug-autocomplete').show();
            }
        });
    }

    function showLoading($input) { positionDropdown($input); $dropdown.html('<div class="dd-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>'); $dropdown.show(); }
    function showError($input, msg) { positionDropdown($input); $dropdown.html('<div class="dd-error"><i class="fa fa-exclamation-triangle"></i> ' + escHtml(msg) + '</div>'); $dropdown.show(); }

    function renderDropdown(data, $input) {
        $dropdown.empty();
        if (!data || !data.length) { $dropdown.html('<div class="dd-empty"><i class="fa fa-search"></i> Tindakan tidak ditemukan</div>'); positionDropdown($input); $dropdown.show(); return; }
        var grouped = {}, order = [];
        $.each(data, function (_, item) { var cat = item.kategori || 'Lainnya'; if (!grouped[cat]) { grouped[cat] = []; order.push(cat); } grouped[cat].push(item); });
        var catLabels = { 'Konsultasi': '<i class="fa fa-user-md"></i> Konsultasi', 'Tindakan Medis': '<i class="fa fa-syringe"></i> Tindakan Medis', 'Administrasi': '<i class="fa fa-file-alt"></i> Administrasi' };
        $.each(order, function (_, cat) {
            $('<div class="dd-header">' + (catLabels[cat] || '<i class="fa fa-tag"></i> ' + escHtml(cat)) + '</div>').appendTo($dropdown);
            $.each(grouped[cat], function (_, item) {
                var harga = parseFloat(item.harga) > 0 ? 'Rp ' + parseFloat(item.harga).toLocaleString('id-ID') : '<span style="color:#aaa;">Gratis</span>';
                var kodeHtml = item.kode ? '<span style="background:#e9ecef;border-radius:3px;padding:1px 5px;margin-right:4px;font-family:monospace;">' + escHtml(item.kode) + '</span>' : '';
                $('<div class="dd-item"></div>')
                    .html('<div class="dd-item-name">' + kodeHtml + escHtml(item.nama) + '</div><div class="dd-item-meta"><span class="dd-item-harga">' + harga + '</span> / ' + escHtml(item.satuan || 'Kali') + '</div>')
                    .data('item', item)
                    .on('mousedown', function (e) { e.preventDefault(); fillActionRow($input, item); closeDropdown(); })
                    .appendTo($dropdown);
            });
        });
        positionDropdown($input); $dropdown.show();
    }

    function positionDropdown($input) {
        var offset = $input.offset(), height = $input.outerHeight(), winH = $(window).height(), winW = $(window).width();
        var ddW = Math.max($input.outerWidth(), 320), top = offset.top + height + 2, left = offset.left;
        if (top + 260 > winH + $(window).scrollTop()) top = offset.top - Math.min($dropdown.outerHeight() || 200, 260) - 4;
        if (left + ddW > winW - 10) left = winW - ddW - 10;
        $dropdown.css({ top: top, left: left, width: ddW });
    }

    function fillActionRow($input, item) {
        var $row = $input.closest('tr.action-row'), nameAttr = $input.attr('name'), match = nameAttr ? nameAttr.match(/\[(\d+)\]/) : null;
        if (!match) return;
        var idx = match[1], hargaRaw = parseFloat(item.harga) || 0, hargaDisplay = hargaRaw > 0 ? hargaRaw.toLocaleString('id-ID') : '0';
        $row.find('input[name="emergency_actions[' + idx + '][action_name]"]').val(item.nama || '');
        $row.find('input[name="emergency_actions[' + idx + '][action_code]"]').val(item.kode || '');
        $row.find('input[name="emergency_actions[' + idx + '][action_category]"]').val(item.kategori || 'tindakan_medis');
        $row.find('input[name="emergency_actions[' + idx + '][unit_price]"].action-unit-price').val(hargaRaw);
        $row.find('.action-unit-price-display').val(hargaDisplay);
        calcGrandTotal();
    }

    $(window).on('scroll resize', function () { if ($activeInput && $dropdown.is(':visible')) positionDropdown($activeInput); });

    window.testAutocomplete = function () {
        setDebug('Mengecek koneksi...');
        $.ajax({ url: DEBUG_URL, method: 'GET', dataType: 'json', timeout: 5000,
            success: function (data) { setDebug(data.status === 'ok' ? 'OK ✓ — Total: ' + data.total_records : 'Error: ' + (data.message || JSON.stringify(data))); },
            error: function (xhr) { setDebug('Koneksi gagal: HTTP ' + xhr.status); }
        });
    };

    // ── Autocomplete ICD-10 ──────────────────────────────────────────────────
    var icd10Index = <?= !empty($registration->icd10_items) ? count((array)(is_string($registration->icd10_items ?? null) ? json_decode($registration->icd10_items, true) : [])) : 0 ?>;
    var icd10Timer = null, $icd10DD = $('#icd10-dropdown');

    $('#btn-add-icd10').on('click', function () { $('#icd10-search-bar').slideDown(150); $('#icd10-search-input').focus(); $(this).hide(); });
    $('#btn-close-icd10-search').on('click', function () { $('#icd10-search-bar').slideUp(150); $icd10DD.hide().empty(); $('#btn-add-icd10').show(); $('#icd10-search-input').val(''); });

    $('#icd10-search-input').on('input', function () {
        clearTimeout(icd10Timer); var q = $.trim($(this).val());
        if (q.length < 1) { $icd10DD.hide().empty(); return; }
        $icd10DD.html('<div style="padding:10px;text-align:center;color:#888;font-size:12px;"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>').show();
        icd10Timer = setTimeout(function () {
            $.ajax({ url: ICD10_SEARCH_URL, method: 'GET', data: { q: q }, dataType: 'json', timeout: 5000,
                success: function (data) { renderIcd10DD(data, q); },
                error: function (xhr) { $icd10DD.html('<div style="padding:10px;color:#721c24;font-size:11px;"><i class="fa fa-exclamation-triangle"></i> Gagal: HTTP ' + xhr.status + '</div>').show(); }
            });
        }, 250);
    });

    $('#icd10-search-input').on('keydown', function (e) {
        var $items = $icd10DD.find('.icd10-dd-item'), $act = $items.filter('.active');
        if (e.key === 'ArrowDown') { e.preventDefault(); $items.removeClass('active'); ($act.length ? $act.nextAll('.icd10-dd-item').first() : $items.first()).addClass('active'); }
        else if (e.key === 'ArrowUp') { e.preventDefault(); $items.removeClass('active'); ($act.length ? $act.prevAll('.icd10-dd-item').first() : $items.last()).addClass('active'); }
        else if (e.key === 'Enter' && $act.length) { e.preventDefault(); $act.trigger('mousedown'); }
        else if (e.key === 'Escape') { $('#btn-close-icd10-search').trigger('click'); }
    });

    function renderIcd10DD(data, q) {
        $icd10DD.empty();
        if (!data || !data.length) { $icd10DD.html('<div style="padding:12px;text-align:center;color:#aaa;font-size:12px;"><i class="fa fa-search"></i> Tidak ditemukan: <strong>' + escHtml(q) + '</strong></div>').show(); return; }
        $.each(data, function (_, item) {
            var kHtml = item.kode ? '<span style="font-family:monospace;font-weight:700;background:#dbeafe;padding:1px 5px;border-radius:3px;margin-right:5px;">' + escHtml(item.kode) + '</span>' : '';
            $('<div class="icd10-dd-item"></div>').html(kHtml + '<strong>' + escHtml(item.nama) + '</strong>')
                .css({ padding:'7px 12px', cursor:'pointer', borderBottom:'1px solid #f0f0f0', fontSize:'12px', lineHeight:'1.4' })
                .data('item', item)
                .hover(function(){ $(this).css('background','#dbeafe'); }, function(){ $(this).css('background',''); })
                .on('mousedown', function (e) { e.preventDefault(); addIcd10Row($(this).data('item')); $('#icd10-search-input').val('').focus(); $icd10DD.hide().empty(); })
                .appendTo($icd10DD);
        });
        $icd10DD.show();
    }

    function addIcd10Row(item) {
        var dup = false;
        $('#icd10-body .icd10-row').each(function () { if ($(this).find('input[name^="icd10_code"]').val() === item.kode) dup = true; });
        if (dup) { alert('Kode ICD-10 ' + item.kode + ' sudah ada.'); return; }
        var isFirst = !$('#icd10-body .icd10-row').length;
        $('#icd10-empty-row').remove();
        var idx = icd10Index++;
        var $tr = $('<tr class="icd10-row" data-idx="' + idx + '"></tr>').html(
            '<input type="hidden" name="icd10_selected[' + idx + ']" value="1">'
            + '<td class="text-center" style="vertical-align:middle;"><input type="radio" name="icd10_utama" value="' + idx + '" ' + (isFirst ? 'checked' : '') + '></td>'
            + '<td><input type="text" name="icd10_code[' + idx + ']" class="form-control input-sm" value="' + escHtml(item.kode || '') + '" style="font-family:monospace;font-weight:700;"></td>'
            + '<td><input type="text" name="icd10_nama[' + idx + ']" class="form-control input-sm" value="' + escHtml(item.nama || '') + '" placeholder="Nama diagnosa..."></td>'
            + '<td class="text-center" style="vertical-align:middle;"><button type="button" class="btn btn-xs btn-danger btn-remove-icd10">&times;</button></td>'
        );
        $tr.css('background','#dbeafe'); $('#icd10-body').append($tr); setTimeout(function(){ $tr.css('background',''); }, 700);
    }

    $(document).on('mousedown', function (e) { if (!$(e.target).closest('#icd10-dropdown, #icd10-search-bar').length) $icd10DD.hide(); });

    // ── Autocomplete ICD-9 ───────────────────────────────────────────────────
    var icd9Index = <?= !empty($registration->icd9_items) ? count((array)(is_string($registration->icd9_items ?? null) ? json_decode($registration->icd9_items, true) : [])) : 0 ?>;
    var icd9Timer = null, $icd9DD = $('#icd9-dropdown');

    $('#btn-add-icd9').on('click', function () { $('#icd9-search-bar').slideDown(150); $('#icd9-search-input').focus(); $(this).hide(); });
    $('#btn-close-icd9-search').on('click', function () { $('#icd9-search-bar').slideUp(150); $icd9DD.hide().empty(); $('#btn-add-icd9').show(); $('#icd9-search-input').val(''); });

    $('#icd9-search-input').on('input', function () {
        clearTimeout(icd9Timer); var q = $.trim($(this).val());
        if (q.length < 1) { $icd9DD.hide().empty(); return; }
        $icd9DD.html('<div style="padding:10px;text-align:center;color:#888;font-size:12px;"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>').show();
        icd9Timer = setTimeout(function () {
            $.ajax({ url: ICD9_SEARCH_URL, method: 'GET', data: { q: q }, dataType: 'json', timeout: 5000,
                success: function (data) { renderIcd9DD(data, q); },
                error: function (xhr) { $icd9DD.html('<div style="padding:10px;color:#721c24;font-size:11px;"><i class="fa fa-exclamation-triangle"></i> Gagal: HTTP ' + xhr.status + '</div>').show(); }
            });
        }, 250);
    });

    $('#icd9-search-input').on('keydown', function (e) {
        var $items = $icd9DD.find('.icd9-dd-item'), $act = $items.filter('.active');
        if (e.key === 'ArrowDown') { e.preventDefault(); $items.removeClass('active'); ($act.length ? $act.nextAll('.icd9-dd-item').first() : $items.first()).addClass('active'); }
        else if (e.key === 'ArrowUp') { e.preventDefault(); $items.removeClass('active'); ($act.length ? $act.prevAll('.icd9-dd-item').first() : $items.last()).addClass('active'); }
        else if (e.key === 'Enter' && $act.length) { e.preventDefault(); $act.trigger('mousedown'); }
        else if (e.key === 'Escape') { $('#btn-close-icd9-search').trigger('click'); }
    });

    function renderIcd9DD(data, q) {
        $icd9DD.empty();
        if (!data || !data.length) { $icd9DD.html('<div style="padding:12px;text-align:center;color:#aaa;font-size:12px;"><i class="fa fa-search"></i> Tidak ditemukan: <strong>' + escHtml(q) + '</strong></div>').show(); return; }
        var grouped = {}, order = [], bgMap = { 'Diagnostik Umum':'#dbeafe','Laboratorium':'#fef9c3','Radiologi':'#fce7f3','Kardiologi':'#fee2e2','Bedah Umum':'#dcfce7','Ortopedi':'#f3e8ff','Kebidanan':'#fdf4ff','Tindakan Umum':'#f8fafc','THT':'#eff6ff','Oftalmologi':'#ecfdf5','Paru & Pernapasan':'#f0fdf4','Endoskopi':'#fff1f2','Urologi':'#fefce8','Bedah Kulit':'#fff7ed' };
        $.each(data, function (_, item) { var cat = item.kategori || 'Lainnya'; if (!grouped[cat]) { grouped[cat] = []; order.push(cat); } grouped[cat].push(item); });
        $.each(order, function (_, cat) {
            $('<div style="padding:3px 10px;font-size:10px;font-weight:700;color:#555;background:' + (bgMap[cat] || '#f8f9fa') + ';border-bottom:1px solid #eee;text-transform:uppercase;position:sticky;top:0;">' + escHtml(cat) + '</div>').appendTo($icd9DD);
            $.each(grouped[cat], function (_, item) {
                var kHtml = item.kode ? '<span style="font-family:monospace;font-weight:700;background:#e9ecef;padding:1px 5px;border-radius:3px;margin-right:5px;">' + escHtml(item.kode) + '</span>' : '';
                var enHtml = item.nama_en ? '<span style="font-size:10px;color:#aaa;"> — ' + escHtml(item.nama_en) + '</span>' : '';
                $('<div class="icd9-dd-item"></div>').html(kHtml + '<strong>' + escHtml(item.nama) + '</strong>' + enHtml)
                    .css({ padding:'7px 12px', cursor:'pointer', borderBottom:'1px solid #f0f0f0', fontSize:'12px', lineHeight:'1.4' })
                    .data('item', item)
                    .hover(function(){ $(this).css('background','#ede9fe'); }, function(){ $(this).css('background',''); })
                    .on('mousedown', function (e) { e.preventDefault(); addIcd9Row($(this).data('item')); $('#icd9-search-input').val('').focus(); $icd9DD.hide().empty(); })
                    .appendTo($icd9DD);
            });
        });
        $icd9DD.show();
    }

    function addIcd9Row(item) {
        var dup = false;
        $('#icd9-body .icd9-row').each(function () { if ($(this).find('input[name^="icd9_code"]').val() === item.kode) dup = true; });
        if (dup) { alert('Kode ICD-9 ' + item.kode + ' sudah ada.'); return; }
        var isFirst = !$('#icd9-body .icd9-row').length;
        $('#icd9-empty-row').remove();
        var idx = icd9Index++;
        var $tr = $('<tr class="icd9-row" data-idx="' + idx + '"></tr>').html(
            '<input type="hidden" name="icd9_selected[' + idx + ']" value="1">'
            + '<input type="hidden" name="icd9_kategori[' + idx + ']" value="' + escHtml(item.kategori || '') + '">'
            + '<td class="text-center" style="vertical-align:middle;"><input type="radio" name="icd9_utama" value="' + idx + '" ' + (isFirst ? 'checked' : '') + '></td>'
            + '<td><input type="text" name="icd9_code[' + idx + ']" class="form-control input-sm" value="' + escHtml(item.kode || '') + '" style="font-family:monospace;font-weight:700;"></td>'
            + '<td><input type="text" name="icd9_nama[' + idx + ']" class="form-control input-sm" value="' + escHtml(item.nama || '') + '" placeholder="Nama tindakan..."></td>'
            + '<td class="text-center" style="vertical-align:middle;"><button type="button" class="btn btn-xs btn-danger btn-remove-icd9">&times;</button></td>'
        );
        $tr.css('background','#ede9fe'); $('#icd9-body').append($tr); setTimeout(function(){ $tr.css('background',''); }, 700);
    }

    $(document).on('mousedown', function (e) { if (!$(e.target).closest('#icd9-dropdown, #icd9-search-bar').length) $icd9DD.hide(); });

}); // end document.ready

// ── Selesai Periksa IGD ──────────────────────────────────────────────────────
$('#btn-selesai-periksa').on('click', function () {
    if (!confirm('Pemeriksaan selesai dan buat tagihan kasir?')) return false;
    var url = $(this).data('url'), csrf = $('input[name="_csrfToken"]').val();
    var form = $('<form>', { method: 'POST', action: url });
    form.append($('<input>', { type: 'hidden', name: '_csrfToken', value: csrf }));
    $('body').append(form); form.submit();
});
</script>