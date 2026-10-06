<?php
/**
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit $visit
 * @var \App\Model\Entity\OutpatientVisitEmr $emr
 */
$p = $visit->patient;
$d = $visit->doctor;
$isDone = !empty($isBillingLocked ?? false) || $visit->status === 'cancelled';

function safeProp($obj, $prop, $default = '') {
    return (is_object($obj) && isset($obj->{$prop})) ? $obj->{$prop} : $default;
}

$noRekamMedis = $p->code ?? '-';
try {
    $medicalRecordsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('MedicalRecords');
    $mrRow = $medicalRecordsTable->find()
        ->where(['registration_id' => $visit->registration_id ?? 0])
        ->first();
    if ($mrRow && !empty($mrRow->medical_record_no)) {
        $noRekamMedis = $mrRow->medical_record_no;
    }
} catch (\Throwable $e) {
}

$patientBirthDate = '-';
if (!empty($p->birth_date)) {
    if (is_object($p->birth_date) && method_exists($p->birth_date, 'format')) {
        $patientBirthDate = $p->birth_date->format('d-m-Y');
    } else {
        $patientBirthDate = h($p->birth_date);
    }
}

// Poliklinik untuk konsul/rujuk memakai AJAX supaya dropdown tidak memuat data terlalu banyak.
// Nomor Surat Pengantar Rawat Inap otomatis dan readonly.
// Untuk sementara dibuat dari ID kunjungan + tanggal; nanti bisa disimpan ke field khusus jika sudah disiapkan.
$inpatientReferralNo = $visit->inpatient_referral_no
    ?? $visit->referral_inpatient_letter_no
    ?? ('SPRI-' . date('Ymd') . '-' . str_pad((string)($visit->id ?? 0), 5, '0', STR_PAD_LEFT));

// ID registrasi untuk membuka halaman E-Order.
// Prioritas: registration_id dari outpatient_visit, lalu relasi registration->id, terakhir fallback visit id.
$orderRegistrationId = $visit->registration_id
    ?? ($visit->registration->id ?? null);

$orderRegistrationNo = $visit->registration_no
    ?? ($visit->registration->registration_no ?? null)
    ?? ($visit->registration->registration_number ?? null);
    $anatomyDefaultFrontUrl = $this->Url->build('/img/anatomy/anatomy-front.jpg');
    $anatomyDefaultBackUrl = $this->Url->build('/img/anatomy/anatomy-back.jpg');
    $anatomyFrontFile = (string)($emr->anatomy_front ?? '');
    $anatomyBackFile = (string)($emr->anatomy_back ?? '');
    $anatomyFrontExists = $anatomyFrontFile !== '' && is_file(WWW_ROOT . 'uploads' . DS . 'anatomy' . DS . $anatomyFrontFile);
    $anatomyBackExists = $anatomyBackFile !== '' && is_file(WWW_ROOT . 'uploads' . DS . 'anatomy' . DS . $anatomyBackFile);
    $anatomyFrontUrl = $anatomyFrontExists
        ? $this->Url->build('/uploads/anatomy/' . rawurlencode($anatomyFrontFile))
        : $anatomyDefaultFrontUrl;
    $anatomyBackUrl = $anatomyBackExists
        ? $this->Url->build('/uploads/anatomy/' . rawurlencode($anatomyBackFile))
        : $anatomyDefaultBackUrl;
?>

<?= $this->Krs->breadcrumb('Outpatient Visits', 'EMR — Pemeriksaan Pasien') ?>

<div class="outpatient-visits emr">

    <!-- ── Header ── -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
            <i class="fa fa-notes-medical"></i> EMR — Electronic Medical Record
        </h4>
        <div style="display:flex; gap:6px;">
            
            <?= $this->Html->link(
                '<i class="fa fa-clipboard-list"></i> Lihat CPPT',
                ['controller' => 'OutpatientVisits', 'action' => 'cppt', $visit->id],
                ['escape' => false, 'class' => 'btn btn-warning btn-sm',
                'data-toggle' => 'tooltip', 'title' => 'Catatan Perkembangan Pasien']
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['controller' => 'OutpatientVisits', 'action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </div>
    </div>

   <!-- ── Info Pasien ── -->
<div class="panel panel-default" style="margin-bottom:8px;">
    <div class="panel-body" style="padding:8px 10px; background:#f8f9fa; font-size:12px;">

        <div class="row" style="margin-bottom:5px;">
            <div class="col-md-2">
                <small>No Registrasi</small><br>
                <strong><?= h($visit->registration_no ?? '-') ?></strong>
            </div>
            <div class="col-md-2">
                <small>No RM</small><br>
                <strong><?= h($p->code ?? '-') ?></strong>
            </div>
            <div class="col-md-3">
                <small>Nama Pasien</small><br>
                <?php
                    $pTitle = $p->title ?? '';
                    $pDisplayName = ($pTitle !== '' ? $pTitle . ' ' : '') . ($p->full_name ?? '-');
                ?>
                <strong><?= h($pDisplayName) ?></strong>
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
                <small>No Antri</small><br>
                <strong style="font-size:16px; color:#1e3a5f;">
                    <?= h($visit->queue_number ?? '-') ?>
                </strong>
            </div>
        </div>

        <div class="row" style="margin-bottom:5px;">
            <div class="col-md-2">
                <small>Dokter</small><br>
                <strong><?= h($d->doctor_name ?? '-') ?></strong>
            </div>
            <div class="col-md-2">
                <small>Poli</small><br>
                <strong><?= h($visit->polyclinic_name ?? '-') ?></strong>
            </div>
            <div class="col-md-2">
                <small>Tgl Registrasi</small><br>
                <strong>
                    <?= is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : h($visit->visit_date) ?>
                </strong>
            </div>
            <div class="col-md-2">
                <small>Jam Periksa</small><br>
                <strong><?= !empty($visit->visit_time) ? h(substr($visit->visit_time, 0, 5)) : date('H:i') ?></strong>
            </div>
            <div class="col-md-2">
                <small>Telepon</small><br>
                <strong><?= h($p->phone_number ?? '-') ?></strong>
            </div>
            <div class="col-md-2">
                <small>Jaminan</small><br>
                <strong><?= h($visit->insurance_type ?? 'Umum') ?></strong>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <small>Alamat</small><br>
                <strong><?= h($p->address ?? '-') ?></strong>
            </div>
            <div class="col-md-2">
                <small>Status</small><br>
                <span class="label label-<?= h($visit->status_badge_class ?? 'default') ?>">
                    <?= h($visit->status_label ?? $visit->status) ?>
                </span>
            </div>
        </div>

    </div>
</div>

    <?php $displayAllergy = !empty($emr->allergy) ? $emr->allergy : ($p->allergy ?? ''); ?>
    <?php if (!empty($displayAllergy)): ?>
        <div class="alert alert-danger" style="padding:7px 12px; font-size:12px; margin-bottom:10px;">
            <strong><i class="fa fa-exclamation-triangle"></i> ALERGI:</strong> <?= h($displayAllergy) ?>
        </div>
    <?php endif; ?>

    <?= $this->Form->create($emr, ['url' => ['action' => 'emr', $visit->id]]) ?>

    <div id="emr-vital-warning" class="alert alert-warning"
        style="display:none; font-size:12px; padding:8px 12px; margin-bottom:10px;">
        <i class="fa fa-exclamation-triangle"></i>
        <strong>Isi dan Simpan Tanda Vital & Gizi terlebih dahulu.</strong>
        Field dan tombol lain akan aktif setelah Nadi, Pernapasan, Tekanan Darah, Suhu Badan, Berat Badan, dan Tinggi Badan diisi lalu ditekan tombol "Simpan Tanda Vital & Gizi".
    </div>

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
                            <?php if (!empty($visit->outpatient_actions)): ?>
                                <?php foreach ($visit->outpatient_actions as $i => $action): ?>
                                    <tr class="action-row">
                                        <td>
                                            <input type="text"
                                                   name="outpatient_actions[<?= $i ?>][action_code]"
                                                   class="form-control input-sm"
                                                   value="<?= h($action->action_code ?? '') ?>"
                                                   placeholder="Kode..."
                                                   <?= $isDone ? 'readonly' : '' ?>>
                                        </td>
                                        <td style="position:relative;">
                                            <input type="text"
                                                   name="outpatient_actions[<?= $i ?>][action_name]"
                                                   class="form-control input-sm action-name"
                                                   value="<?= h($action->action_name) ?>"
                                                   placeholder="Ketik nama tindakan..."
                                                   autocomplete="off"
                                                   <?= $isDone ? 'readonly' : 'required' ?>>
                                            <input type="hidden"
                                                   name="outpatient_actions[<?= $i ?>][action_category]"
                                                   value="<?= h($action->action_category ?? '') ?>">
                                            <input type="hidden"
                                                   name="outpatient_actions[<?= $i ?>][notes]"
                                                   value="<?= h($action->notes ?? '') ?>">
                                        </td>
                                        <td>
                                            <input type="number"
                                                   name="outpatient_actions[<?= $i ?>][quantity]"
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
                                                       name="outpatient_actions[<?= $i ?>][unit_price]"
                                                       class="action-unit-price"
                                                       value="<?= (float)($action->unit_price ?? 0) ?>">
                                            <?php else: ?>
                                                <input type="text"
                                                       class="form-control input-sm"
                                                       value="<?= number_format((float)($action->unit_price ?? 0), 0, ',', '.') ?>"
                                                       readonly
                                                       style="text-align:right; background:#f5f5f5;">
                                                <input type="hidden"
                                                       name="outpatient_actions[<?= $i ?>][unit_price]"
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
                                           value="<?= h((int)($emr->total_fee ?? 0)) ?>"
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

            <!-- Tombol aksi utama kiri (posisi disesuaikan seperti SIMRS client) -->
            <div class="row" style="margin-bottom:18px;">
                <div class="col-xs-6">
                <?php if (!empty($orderRegistrationId)): ?>
                        <?= $this->Html->link(
                            '<i class="fa fa-flask"></i> ORDER LAB/RADIO/RESEP',
                            [
                                'controller' => 'Orders',
                                'action' => 'form',
                                $orderRegistrationId,
                            ],
                            [
                                'escape' => false,
                                'class' => 'btn btn-sm btn-block',
                                'style' => 'background:#17a2b8; color:#fff; font-size:11px;',
                            ]
                        ) ?>
                    <?php elseif (!empty($orderRegistrationNo)): ?>
                        <?= $this->Html->link(
                            '<i class="fa fa-flask"></i> ORDER LAB/RADIO/RESEP',
                            [
                                'controller' => 'Orders',
                                'action' => 'form',
                                '?' => ['registration_no' => $orderRegistrationNo],
                            ],
                            [
                                'escape' => false,
                                'class' => 'btn btn-sm btn-block',
                                'style' => 'background:#17a2b8; color:#fff; font-size:11px;',
                            ]
                        ) ?>
                    <?php else: ?>
                        <button type="button" class="btn btn-sm btn-block btn-danger" disabled>
                            No Registrasi tidak ada
                        </button>
                    <?php endif; ?>
                </div>
                <?php /*
                <div class="col-xs-4">
                    <button type="button" class="btn btn-sm btn-block" id="btn-kajian-awal"
                            style="background:#6f42c1; color:#fff; font-size:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <i class="fa fa-file-medical" style="color:#fff;"></i> KAJIAN MEDIS AWAL
                    </button>
                </div>
                */ ?>
                <div class="col-xs-6">
                    <button type="button" class="btn btn-sm btn-block btn-inverse btn-surat-bukti-rajal"
                            style="font-size:11px;"
                            data-noreg="<?= h($visit->registration_no ?? '-') ?>"
                            data-nama="<?= h($p->full_name ?? '-') ?>"
                            data-dokter="<?= h($d->doctor_name ?? '-') ?>">
                        <i class="fa fa-receipt"></i> SURAT BUKTI RAWAT JALAN
                    </button>
                </div>
            </div>
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
                    </ul>
                </div>

                <div class="panel-body emr-tab-body" style="padding:14px 12px 12px 12px; margin-top:-1px; background:#fff;">
                    <div class="tab-content">

                        <!-- ══ TAB SURAT ══ -->
                        <div id="tab-surat" class="tab-pane active">
                            <div class="row" style="display:flex; align-items:stretch;">
                                <!-- Tombol surat di kiri -->
                                <div class="col-xs-4">
                                        <button type="button" class="btn btn-xs btn-default btn-block m-b-5 btn-surat-sakit"
                                                style="text-align:left; font-size:11px;"
                                                data-noreg="<?= h($visit->registration_no ?? '-') ?>"
                                                data-rekmed="<?= h($noRekamMedis) ?>"
                                                data-nama="<?= h($p->full_name ?? '-') ?>"
                                                data-alamat="<?= h($p->address ?? '-') ?>"
                                                data-jk="<?= ($p->gender ?? '') === 'Male' ? 'PRIA' : 'WANITA' ?>"
                                                data-goldar="<?= h($p->blood_type ?? '-') ?>"
                                                data-bb="<?= h($emr->weight ?? '') ?>"
                                                data-tb="<?= h($emr->height ?? '') ?>"
                                                data-td="<?= h($emr->blood_pressure ?? '') ?>"
                                                data-suhu="<?= h($emr->temperature ?? '') ?>"
                                                data-diagnosa="<?= h($emr->diagnosis_primary ?? '') ?>"
                                                data-dokter="<?= h($d->doctor_name ?? '-') ?>"
                                                data-tglperiksa="<?= is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : h($visit->visit_date ?? '-') ?>"
                                                <?php
                                                // hitung umur "X Th Y Bl Z Hr" seperti di foto
                                                $umurLengkap = '-';
                                                if (!empty($p->birth_date)) {
                                                    $bd = is_object($p->birth_date) ? $p->birth_date->format('Y-m-d') : $p->birth_date;
                                                    $diff = (new DateTime())->diff(new DateTime($bd));
                                                    $umurLengkap = $diff->y . ' Th ' . $diff->m . ' Bl ' . $diff->d . ' Hr';
                                                }
                                                ?>
                                                data-umur="<?= h($umurLengkap) ?>">
                                            <i class="fa fa-file-medical" style="color:#1e3a5f;"></i>
                                            Surat Keterangan Sakit
                                        </button>
                                        <button type="button" class="btn btn-xs btn-default btn-block m-b-5 btn-surat-konsultasi"
                                            style="text-align:left; font-size:11px;"
                                            data-noreg="<?= h($visit->registration_no ?? '-') ?>"
                                            data-rekmed="<?= h($noRekamMedis) ?>"
                                            data-nama="<?= h($p->full_name ?? '-') ?>"
                                            data-alamat="<?= h($p->address ?? '-') ?>"
                                            data-dokter="<?= h($d->doctor_name ?? '-') ?>"
                                            data-tglperiksa="<?= is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : h($visit->visit_date ?? '-') ?>"
                                            data-umur="<?= h($umurLengkap) ?>">
                                        <i class="fa fa-file-medical" style="color:#1e3a5f;"></i>
                                        Surat Konsultasi Pasien
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5 btn-surat-sehat"
                                            style="text-align:left; font-size:11px;"
                                            data-noreg="<?= h($visit->registration_no ?? '-') ?>"
                                            data-rekmed="<?= h($noRekamMedis) ?>"
                                            data-nama="<?= h($p->full_name ?? '-') ?>"
                                            data-alamat="<?= h($p->address ?? '-') ?>"
                                            data-jk="<?= ($p->gender ?? '') === 'Male' ? 'PRIA' : 'WANITA' ?>"
                                            data-goldar="<?= h($p->blood_type ?? '-') ?>"
                                            data-bb="<?= h($emr->weight ?? '') ?>"
                                            data-tb="<?= h($emr->height ?? '') ?>"
                                            data-td="<?= h($emr->blood_pressure ?? '') ?>"
                                            data-suhu="<?= h($emr->temperature ?? '') ?>"
                                            data-dokter="<?= h($d->doctor_name ?? '-') ?>"
                                            data-tglperiksa="<?= is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : h($visit->visit_date ?? '-') ?>"
                                            data-umur="<?= h($umurLengkap) ?>">
                                        <i class="fa fa-file-medical" style="color:#1e3a5f;"></i>
                                        Surat Keterangan Sehat
                                    <!-- </button>
                                        <button type="button" class="btn btn-xs btn-default btn-block m-b-5 btn-protokol-terapi"
                                                style="text-align:left; font-size:11px;"
                                                data-noreg="<?= h($visit->registration_no ?? '-') ?>"
                                                data-rekmed="<?= h($noRekamMedis) ?>"
                                                data-nama="<?= h($p->full_name ?? '-') ?>"
                                                data-alamat="<?= h($p->address ?? '-') ?>"
                                                data-jk="<?= ($p->gender ?? '') === 'Male' ? 'PRIA' : 'WANITA' ?>"
                                                data-bb="<?= h($emr->weight ?? '') ?>"
                                                data-tb="<?= h($emr->height ?? '') ?>"
                                                data-td="<?= h($emr->blood_pressure ?? '') ?>"
                                                data-suhu="<?= h($emr->temperature ?? '') ?>"
                                                data-diagnosa="<?= h($emr->diagnosis_primary ?? '') ?>"
                                                data-obat="<?= h($emr->prescription_notes ?? '') ?>"
                                                data-dokter="<?= h($d->doctor_name ?? '-') ?>"
                                                data-tglperiksa="<?= is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : h($visit->visit_date ?? '-') ?>"
                                                data-umur="<?= h($umurLengkap) ?>">
                                            <i class="fa fa-file-medical" style="color:#1e3a5f;"></i>
                                            Protokol Terapi
                                        </button> -->
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5 btn-surat-skdp"
                                            style="text-align:left; font-size:11px;"
                                            data-noreg="<?= h($visit->registration_no ?? '-') ?>"
                                            data-rekmed="<?= h($noRekamMedis) ?>"
                                            data-nama="<?= h($p->full_name ?? '-') ?>"
                                            data-alamat="<?= h($p->address ?? '-') ?>"
                                            data-dokter="<?= h($d->doctor_name ?? '-') ?>"
                                            data-tglperiksa="<?= is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : h($visit->visit_date ?? '-') ?>"
                                            data-umur="<?= h($umurLengkap) ?>"
                                            data-bpjs="<?= h(($visit->registration->insurance_card_no ?? null) ?? '') ?>">
                                        <i class="fa fa-file-medical" style="color:#1e3a5f;"></i>
                                        Surat SKDP
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5 btn-surat-kontrol-bpjs"
                                            style="text-align:left; font-size:11px;"
                                            data-noreg="<?= h($visit->registration_no ?? '-') ?>"
                                            data-rekmed="<?= h($noRekamMedis) ?>"
                                            data-nama="<?= h($p->full_name ?? '-') ?>"
                                            data-jk="<?= ($p->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan' ?>"
                                            data-tgllahir="<?= !empty($p->birth_date) ? (is_object($p->birth_date) ? $p->birth_date->format('d-m-Y') : h($p->birth_date)) : '-' ?>"
                                            data-dokter="<?= h($d->doctor_name ?? '-') ?>"
                                            data-tglperiksa="<?= is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : h($visit->visit_date ?? '-') ?>"
                                            data-bpjs="<?= h(safeProp($visit->registration ?? null, 'insurance_card_no', '')) ?>">
                                        <i class="fa fa-file-medical" style="color:#1e3a5f;"></i>
                                        Surat Kontrol BPJS
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default btn-block m-b-5"
                                            style="text-align:left; font-size:11px;">
                                        <i class="fa fa-file-medical" style="color:#1e3a5f;"></i>
                                        Fisioterapi
                                    </button>

                                    <div style="margin-top:6px;">
                                        <label style="font-size:10px; font-weight:600; color:#dc3545; margin-bottom:3px;">
                                            <i class="fa fa-exclamation-triangle"></i> ALERGI
                                        </label>
                                        <input type="text" name="allergy" class="form-control input-sm"
                                               value="<?= h($displayAllergy) ?>"
                                               placeholder="Tidak ada / nama obat / bahan makanan..."
                                               <?= $isDone ? 'readonly' : '' ?>>
                                    </div>
                                </div>

                                
                                <div class="col-xs-8">
                                        <div class="anatomy-tab-chart">
                                        <button type="button"
                                                class="anatomy-thumb js-open-anatomy"
                                                data-side="front"
                                                data-title="Anatomi Depan"
                                                data-image-url="<?= h($anatomyFrontUrl) ?>"
                                                data-default-url="<?= h($anatomyDefaultFrontUrl) ?>"
                                                data-field="anatomy_front">
                                            <span class="anatomy-thumb-title">Anatomi Depan</span>
                                            <img src="<?= h($anatomyFrontUrl) ?>" alt="Anatomi Depan">
                                            <span class="anatomy-thumb-status">
                                                <?= $anatomyFrontExists ? 'Sudah disimpan' : 'Default' ?>
                                            </span>
                                        </button>
                                        <button type="button"
                                                class="anatomy-thumb js-open-anatomy"
                                                data-side="back"
                                                data-title="Anatomi Belakang"
                                                data-image-url="<?= h($anatomyBackUrl) ?>"
                                                data-default-url="<?= h($anatomyDefaultBackUrl) ?>"
                                                data-field="anatomy_back">
                                            <span class="anatomy-thumb-title">Anatomi Belakang</span>
                                            <img src="<?= h($anatomyBackUrl) ?>" alt="Anatomi Belakang">
                                            <span class="anatomy-thumb-status">
                                                <?= $anatomyBackExists ? 'Sudah disimpan' : 'Default' ?>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /tab-surat -->

                        <div id="tab-rujuk" class="tab-pane">

<div class="row">

    <!-- PROSES KONSULTASI -->
    <div class="col-md-8">

        <div style="
            background:#eef4ff;
            border:1px solid #d6e4ff;
            border-radius:4px;
            padding:10px;
            min-height:220px;">

            <label style="font-size:12px;font-weight:bold;">
                Proses Konsultasi / Rujuk Ke Poli / Bagian Lain
            </label>

            <div class="form-group" style="margin-top:10px; position:relative;">
                <label>Ke Poliklinik</label>
                <input type="text"
                       id="referral-polyclinic-search"
                       class="form-control input-sm"
                       value="<?= h($visit->referral_polyclinic ?? '') ?>"
                       placeholder="Ketik nama poliklinik..."
                       autocomplete="off"
                       <?= $isDone ? 'readonly' : '' ?>>
                <input type="hidden"
                       name="referral_polyclinic"
                       id="referral-polyclinic-value"
                       value="<?= h($visit->referral_polyclinic ?? '') ?>">

                <div id="polyclinic-dropdown" style="
                    display:none;
                    position:absolute;
                    top:100%;
                    left:0;
                    right:0;
                    z-index:9999;
                    background:#fff;
                    border:1px solid #ced4da;
                    border-radius:4px;
                    box-shadow:0 4px 12px rgba(0,0,0,.12);
                    max-height:220px;
                    overflow-y:auto;
                    font-size:12px;
                "></div>
            </div>

            <div class="form-group" style="position:relative;">
                <label>Ke Dokter</label>
                <input type="text"
                       id="referral-doctor-search"
                       class="form-control input-sm"
                       value="<?= h($visit->referral_doctor ?? '') ?>"
                       placeholder="Pilih dokter sesuai poliklinik..."
                       autocomplete="off"
                       <?= $isDone ? 'readonly' : '' ?>>
                <input type="hidden"
                       name="referral_doctor"
                       id="referral-doctor-value"
                       value="<?= h($visit->referral_doctor ?? '') ?>">

                <div id="doctor-dropdown" style="
                    display:none;
                    position:absolute;
                    top:100%;
                    left:0;
                    right:0;
                    z-index:9999;
                    background:#fff;
                    border:1px solid #ced4da;
                    border-radius:4px;
                    box-shadow:0 4px 12px rgba(0,0,0,.12);
                    max-height:220px;
                    overflow-y:auto;
                    font-size:12px;
                "></div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Tanggal</label>
                    <input type="date"
                           name="referral_date"
                           class="form-control input-sm"
                           value="<?= h($visit->referral_date ?? date('Y-m-d')) ?>">
                </div>

                <div class="col-md-4">
                    <label>Jam</label>
                    <input type="time"
                           name="referral_time"
                           class="form-control input-sm"
                           value="<?= h($visit->referral_time ?? date('H:i')) ?>">
                </div>

                <div class="col-md-4">
                    <label>Nomor Antri</label>
                    <input type="number"
                           name="referral_queue_no"
                           id="referral-queue-no"
                           class="form-control input-sm"
                           value="<?= h($visit->referral_queue_no ?? 0) ?>"
                           readonly
                           style="background:#f5f5f5; font-weight:600; cursor:not-allowed;">
                </div>
            </div>

            <!-- <div style="margin-top:10px;">
                <label>
                    <input type="checkbox"
                           name="praktek2"
                           value="1">
                    Praktek 2
                </label>
            </div> -->

            <div style="margin-top:10px;">

                <button type="button"
                        id="btn-konsul-langsung"
                        class="btn btn-primary btn-sm">
                    Konsulkan Langsung
                </button>

                <button type="button"
                        id="btn-jadwal-kontrol"
                        class="btn btn-info btn-sm">
                    Jadwal Kontrol
                </button>

            </div>

        </div>

    </div>

    <!-- RAWAT INAP -->
        <div class="col-md-4">

            <div style="
                background:#fafafa;
                border:1px solid #ddd;
                border-radius:4px;
                padding:10px;
                min-height:220px;">

                <div class="form-group" style="margin-bottom:8px;">
                    <input type="text"
                        name="inpatient_referral_no"
                        class="form-control input-sm"
                        value="<?= h($inpatientReferralNo) ?>"
                        readonly
                        style="background:#f5f5f5; font-weight:600; cursor:not-allowed;">
                </div>

                <div class="form-group" style="margin-bottom:8px;">
                    <label style="font-size:11px; font-weight:600; color:#555; margin-bottom:3px; display:block;">
                        Alasan Rujukan Rawat Inap
                    </label>
                    <textarea id="spri-alasan"
                            class="form-control input-sm"
                            rows="3"
                            placeholder="Tuliskan alasan medis pasien perlu dirawat inap..."
                            <?= $isDone ? 'readonly' : '' ?>></textarea>
                </div>

                <button type="button"
                        id="btn-surat-pengantar-rawat"
                        class="btn btn-default btn-block">
                    <i class="fa fa-print"></i> Surat Pengantar Rawat Inap
                </button>

                <div style="margin-top:10px; <?= !empty($visit->is_planned_inpatient) ? '' : 'display:none;' ?>"
                    id="wrap-btn-rencana-rawat-inap">
                    <button type="button"
                            id="btn-rencana-rawat-inap"
                            class="btn btn-success btn-block"
                            <?= !empty($visit->is_planned_inpatient) ? 'disabled' : '' ?>>
                        <i class="fa <?= !empty($visit->is_planned_inpatient) ? 'fa-check' : 'fa-procedures' ?>"></i>
                        <?= !empty($visit->is_planned_inpatient) ? 'Sudah Direncanakan' : 'Rencanakan Pasien ke Rawat Inap' ?>
                    </button>
                </div>
            </div>
        </div>
</div>
</div>

                    </div>
                </div>
            </div>

            <!-- Diagnosa & ICD -->
            <div class="panel panel-default" style="margin-top:10px;">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-diagnoses"></i> Diagnosa & ICD</strong>
                </div>
            <div class="panel-body" style="padding:8px 12px;">
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

                        <!-- Tabel ICD-10: Kode + Nama Diagnosa saja -->
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
                                if (!empty($emr->icd10_items)) {
                                    $icd10Items = is_string($emr->icd10_items)
                                        ? json_decode($emr->icd10_items, true) ?? []
                                        : (array)$emr->icd10_items;
                                }
                                ?>
                                <?php foreach ($icd10Items as $idx => $item): ?>
                                    <tr class="icd10-row" data-idx="<?= $idx ?>">
                                        <input type="hidden"
                                               name="icd10_selected[<?= $idx ?>]"
                                               value="1">
                                        <td class="text-center" style="vertical-align:middle;">
                                            <input type="radio"
                                                   name="icd10_utama"
                                                   value="<?= $idx ?>"
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
                                                <button type="button" class="btn btn-xs btn-danger btn-remove-icd10">
                                                    &times;
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($icd10Items)): ?>
                                    <tr id="icd10-empty-row">
                                        <td colspan="<?= $isDone ? 3 : 4 ?>"
                                            style="text-align:center; color:#aaa; padding:10px; font-size:11px;">
                                            <i class="fa fa-diagnoses"></i>
                                            Belum ada diagnosa ICD-10.
                                            <?php if (!$isDone): ?>
                                                Klik <strong>Tambah ICD-10</strong> untuk menambahkan.
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /ICD-10 -->

                    <!-- ══════════════════════════════════════════════════════════
                         ICD-9 CM
                         Kolom centang & kategori DIHAPUS dari tampilan.
                         icd9_selected & icd9_kategori dikirim via hidden input.
                         ══════════════════════════════════════════════════════════ -->
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

                        <!-- Tabel ICD-9: Kode + Nama Tindakan saja -->
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
                                if (!empty($emr->icd9_items)) {
                                    $icd9Items = is_string($emr->icd9_items)
                                        ? json_decode($emr->icd9_items, true) ?? []
                                        : (array)$emr->icd9_items;
                                }
                                ?>
                                <?php foreach ($icd9Items as $idx => $item): ?>
                                    <tr class="icd9-row" data-idx="<?= $idx ?>">
                                        <input type="hidden"
                                               name="icd9_selected[<?= $idx ?>]"
                                               value="1">
                                        <input type="hidden"
                                               name="icd9_kategori[<?= $idx ?>]"
                                               value="<?= h($item['kategori'] ?? '') ?>">
                                        <td class="text-center" style="vertical-align:middle;">
                                            <input type="radio"
                                                   name="icd9_utama"
                                                   value="<?= $idx ?>"
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
                                                <button type="button" class="btn btn-xs btn-danger btn-remove-icd9">
                                                    &times;
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($icd9Items)): ?>
                                    <tr id="icd9-empty-row">
                                        <td colspan="<?= $isDone ? 3 : 4 ?>"
                                            style="text-align:center; color:#aaa; padding:10px; font-size:11px;">
                                            <i class="fa fa-clipboard-list"></i>
                                            Belum ada tindakan ICD-9.
                                            <?php if (!$isDone): ?>
                                                Klik <strong>Tambah ICD-9</strong> untuk menambahkan.
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /ICD-9 CM -->

                    <!-- Vital summary -->
                    <div id="vital-summary" style="margin-top:8px; background:#f8f9fa;
                                                    border-radius:4px; padding:6px 10px;
                                                    font-size:11px; color:#555; display:none;">
                        <i class="fa fa-info-circle" style="color:#17a2b8;"></i>
                        <span id="vital-summary-text"></span>
                    </div>

                    <!-- Follow-up dihapus: Tanggal Kontrol, Rujuk Ke, Alasan Rujukan dipindah/tidak ditampilkan di bawah ICD-9 -->
                </div>
            </div>

           


        </div><!-- /col kiri -->

        <!-- ════════════════════════════════════════════════════
             KOLOM KANAN
             ════════════════════════════════════════════════════ -->
        <div class="col-md-6">

            <!-- Tanda Vital -->
            <div class="panel panel-default" id="panel-tanda-vital">
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
                                           value="<?= h($emr->pulse ?? '') ?>"
                                           min="1" max="300" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">/Menit</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Pernapasan</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="respiratory_rate" class="form-control"
                                           value="<?= h($emr->respiratory_rate ?? '') ?>"
                                           min="1" max="60" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">/Menit</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Tekanan Darah</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="blood_pressure" class="form-control"
                                           value="<?= h($emr->blood_pressure ?? '') ?>"
                                           placeholder="120/80" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">mmHg</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Suhu Badan</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="temperature" class="form-control"
                                           value="<?= h($emr->temperature ?? '') ?>"
                                           step="0.1" min="30" max="45"
                                           <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">°C</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Sp O2</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="oxygen_saturation" class="form-control"
                                           value="<?= h($emr->oxygen_saturation ?? '') ?>"
                                           min="1" max="100" <?= $isDone ? 'readonly' : '' ?>>
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="vital-row">
                                <label>Skala Nyeri</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="pain_scale" class="form-control"
                                           value="<?= h($emr->pain_scale ?? '') ?>"
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
                                               value="<?= h($emr->weight ?? '') ?>"
                                               step="0.1" min="0.1" max="500"
                                               <?= $isDone ? 'readonly' : '' ?>>
                                        <span class="input-group-addon">Kg</span>
                                    </div>
                                </div>
                                <div class="vital-row">
                                    <label>Tinggi Badan</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="height" id="height" class="form-control"
                                               value="<?= h($emr->height ?? '') ?>"
                                               step="0.1" min="1" max="250"
                                               <?= $isDone ? 'readonly' : '' ?>>
                                        <span class="input-group-addon">CM</span>
                                    </div>
                                </div>
                                <div class="vital-row">
                                    <label>BMI</label>
                                    <input type="text" name="bmi" id="bmi-display" class="form-control input-sm"
                                           readonly
                                           value="<?= !empty($emr->bmi) ? number_format($emr->bmi, 2) : '' ?>"
                                           style="background:#fff; font-weight:700; color:#1e3a5f;">
                                </div>
                                <div class="vital-row">
                                    <label>BMI Result</label>
                                    <input type="text" name="bmi_category" id="bmi-result" class="form-control input-sm"
                                           readonly
                                           value="<?= h($emr->bmi_category ?? '') ?>"
                                           style="background:#fff;">
                                </div>
                            </div>
                        </div>

                        <div style="margin-left: 240px; margin-top:12px; padding-top:10px; border-top:1px solid #eee;
                                    display:flex; align-items:center; justify-content:space-between; gap:10px;">
                            <button type="button" id="btn-save-vital" class="btn btn-primary btn-sm" disabled
                                    style="min-width:220px; font-weight:600;">
                                <i class="fa fa-save"></i> Simpan Tanda Vital & Gizi
                            </button>
                            <span id="vital-saved-badge" style="display:none; font-size:12px; font-weight:700; color:#198754;
                                                                white-space:nowrap;">
                                <i class="fa fa-check-circle"></i> Sudah tersimpan
                            </span>
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
                              <?= $isDone ? 'readonly' : '' ?>><?= h($emr->chief_complaint ?? '') ?></textarea>
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
                              <?= $isDone ? 'readonly' : '' ?>><?= h($emr->illness_history ?? '') ?></textarea>
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
                              placeholder="Diagnosa awal saat pasien masuk..."
                              <?= $isDone ? 'readonly' : '' ?>><?= h($emr->admission_diagnosis ?? '') ?></textarea>
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
                              <?= $isDone ? 'readonly' : '' ?>><?= h($emr->prescription_notes ?? '') ?></textarea>
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
                              <?= $isDone ? 'readonly' : '' ?>><?= h($emr->doctor_notes ?? '') ?></textarea>
                </div>
            </div>



       </div><!-- /col kanan -->
    </div><!-- /row -->

    <!-- Toolbar aksi bawah — full width, footer -->
    <div class="panel panel-default" style="margin-top:10px;">
        <div class="panel-body" style="padding:10px; background:#fafafa;">
            <div class="row">

                <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                    <button type="button" class="btn btn-default btn-sm btn-block">
                        <i class="fa fa-id-card"></i> <br> ICARE-JKN
                    </button>
                </div>

                <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                    <button type="button" class="btn btn-info btn-sm btn-block">
                        <i class="fa fa-book-medical"></i> <br> REKAM MEDIS
                    </button>
                </div>

                <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                    <button type="button"
                            class="btn btn-success btn-sm btn-block btn-hasil-pemeriksaan-emr"
                            data-noreg="<?= h($visit->registration_no ?? '-') ?>"
                            data-rekmed="<?= h($noRekamMedis) ?>"
                            data-nama="<?= h($p->full_name ?? '-') ?>"
                            data-dokter="<?= h($d->doctor_name ?? '-') ?>"
                            data-tanggal="<?= !empty($visit->visit_date) && is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : h($visit->visit_date ?? '-') ?>"
                            data-hasil="<?= h(trim((string)($emr->illness_history ?? $emr->doctor_notes ?? $visit->diagnosis_primary ?? '')) ?: '-') ?>">
                        <i class="fa fa-stethoscope"></i> <br> HASIL PEMERIKSAAN
                    </button>
                </div>

                <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                    <button type="button"
                            id="btn-selesai-periksa"
                            class="btn btn-danger btn-sm btn-block"
                            data-url="<?= $this->Url->build([
                                'controller' => 'OutpatientVisits',
                                'action' => 'selesaiPeriksa',
                                $visit->id
                            ]) ?>">
                        <i class="fa fa-check-circle"></i> <br> SELESAI PERIKSA
                    </button>
                </div>

                <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                    <button type="submit" class="btn btn-primary btn-sm btn-block">
                        <i class="fa fa-save"></i> <br> SIMPAN
                    </button>
                </div>

                <div class="col-md-2 col-xs-6" style="margin-bottom:5px;">
                    <button type="button"
                            onclick="window.print();"
                            class="btn btn-default btn-sm btn-block">
                        <i class="fa fa-print"></i> <br> CETAK
                    </button>
                </div>

            </div>
        </div>
    </div>

    <?= $this->Form->end() ?>

    <div class="modal fade" id="modal-anatomy-editor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog anatomy-modal-dialog" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-pencil-alt"></i> <span id="anatomy-modal-title">Anatomi Tubuh Pasien</span></span>
                <button type="button" class="hasil-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="anatomy-toolbar">
                <button type="button" class="btn btn-sm btn-primary" id="btn-anatomy-pen">
                    <i class="fa fa-pen"></i> Pena
                </button>
                <button type="button" class="btn btn-sm btn-default" id="btn-anatomy-undo">
                    <i class="fa fa-undo"></i> Undo
                </button>
                <button type="button" class="btn btn-sm btn-warning" id="btn-anatomy-clear">
                    <i class="fa fa-trash"></i> Reset/Clear
                </button>
                <button type="button" class="btn btn-sm btn-success" id="btn-anatomy-save">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Batal
                </button>
                <span id="anatomy-save-message" class="anatomy-save-message"></span>
            </div>
            <div class="anatomy-canvas-wrap">
                <canvas id="anatomy-canvas" width="620" height="780"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-kajian-awal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-kajian-dialog" role="document">
        <div class="modal-content hasil-window kajian-window">
            <div class="hasil-title">
                <span><i class="fa fa-file-medical"></i> Kajian Medis Awal</span>
                <button type="button" class="hasil-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form id="form-kajian-awal">
                <input type="hidden" name="_csrfToken" value="<?= h($this->request->getAttribute('csrfToken')) ?>">
                <div class="kajian-header">
                    <div class="row">
                        <div class="col-sm-3"><label>No Registrasi</label><input type="text" class="form-control input-sm" id="kma-registration-no" value="<?= h($visit->registration_no ?? '-') ?>" readonly></div>
                        <div class="col-sm-3"><label>No Rek. Med</label><input type="text" class="form-control input-sm" id="kma-medical-record-no" value="<?= h($p->code ?? '-') ?>" readonly></div>
                        <div class="col-sm-3"><label>Nama Pasien</label><input type="text" class="form-control input-sm" id="kma-patient-name" value="<?= h($p->full_name ?? '-') ?>" readonly></div>
                        <div class="col-sm-3"><label>No Kajian</label><input type="text" class="form-control input-sm" id="kma-assessment-no" value="AUTO" readonly></div>
                    </div>
                    <div class="row" style="margin-top:6px;">
                        <div class="col-sm-3"><label>Tanggal</label><input type="date" class="form-control input-sm" name="assessment_date" id="kma-assessment-date" value="<?= date('Y-m-d') ?>"></div>
                        <div class="col-sm-2"><label>Jam</label><input type="time" class="form-control input-sm" name="assessment_time" id="kma-assessment-time" value="<?= date('H:i') ?>"></div>
                        <div class="col-sm-4"><label>Dokter</label><input type="text" class="form-control input-sm" id="kma-doctor-name" value="<?= h($d->doctor_name ?? '-') ?>" readonly></div>
                        <div class="col-sm-3"><label>Status Simpan</label><input type="text" class="form-control input-sm" id="kma-save-state" value="Belum dimuat" readonly></div>
                    </div>
                </div>

                <ul class="nav nav-tabs kajian-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#kma-tab-data-dasar" data-toggle="tab">Data Dasar</a></li>
                    <li role="presentation"><a href="#kma-tab-subjektif" data-toggle="tab">Subjektif</a></li>
                    <li role="presentation"><a href="#kma-tab-observasi" data-toggle="tab">Observasi</a></li>
                </ul>

                <div class="tab-content kajian-body">
                    <div id="kma-tab-data-dasar" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="kajian-section-title">Rujukan & Triase</div>
                                <div class="kajian-line"><label>Rujukan</label><label><input type="radio" name="data_dasar[rujukan]" value="Datang sendiri"> Datang sendiri</label><label><input type="radio" name="data_dasar[rujukan]" value="Rujukan"> Rujukan</label><label><input type="radio" name="data_dasar[rujukan]" value="Lain-lain"> Lain-lain</label></div>
                                <div class="kajian-line"><label>Triase</label><label><input type="radio" name="data_dasar[triase]" value="Emergency"> Emergency</label><label><input type="radio" name="data_dasar[triase]" value="Ya"> Ya</label><label><input type="radio" name="data_dasar[triase]" value="Tidak"> Tidak</label></div>
                                <div class="kajian-line"><label>Level</label><?php foreach (['I', 'II', 'III', 'IV'] as $level): ?><label><input type="radio" name="data_dasar[level]" value="<?= $level ?>"> <?= $level ?></label><?php endforeach; ?></div>
                                <div class="kajian-line kajian-tags-line">
                                    <label>Tags</label>
                                    <?php foreach (['merah' => '#e51f35', 'kuning' => '#f6e23a', 'hijau' => '#16c45b', 'hitam' => '#111111'] as $tag => $color): ?>
                                        <label class="kajian-tag-option">
                                            <input type="radio" name="data_dasar[tags]" value="<?= h($tag) ?>">
                                            <span class="kajian-tag-swatch" style="background:<?= h($color) ?>;"></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                                <div class="kajian-line"><label>Kasus</label><?php foreach (['Trauma', 'DOA', 'KLL', 'KLL tunggal', 'Self abuse', 'Kecelakaan lain'] as $case): ?><label><input type="checkbox" name="data_dasar[kasus][]" value="<?= h($case) ?>"> <?= h($case) ?></label><?php endforeach; ?></div>
                                <div class="kajian-line"><label>Pembayaran</label><?php foreach (['Pribadi', 'BPJS', 'COB', 'Lain-lain'] as $pay): ?><label><input type="radio" name="data_dasar[pembayaran]" value="<?= h($pay) ?>"> <?= h($pay) ?></label><?php endforeach; ?></div>
                                <div class="kajian-section-title">Survei Primer</div>
                                <div class="kajian-grid-2">
                                    <div><label>C: Nadi carotis</label><label><input type="radio" name="data_dasar[nadi_carotis]" value="Ya"> Ya</label><label><input type="radio" name="data_dasar[nadi_carotis]" value="Tidak"> Tidak</label></div>
                                    <div><label>A: Airway</label><?php foreach (['Bicara/Menangis', 'Suara tambahan', 'Diam'] as $v): ?><label><input type="radio" name="data_dasar[airway]" value="<?= h($v) ?>"> <?= h($v) ?></label><?php endforeach; ?></div>
                                    <div><label>B: Breathing</label><?php foreach (['Spontan', 'Takipneu', 'Dyspneu', 'Retraksi intercostal', 'Retraksi epigastrial', 'Lambat/tidak adekuat', 'Retraksi suprasternal'] as $v): ?><label><input type="checkbox" name="data_dasar[breathing][]" value="<?= h($v) ?>"> <?= h($v) ?></label><?php endforeach; ?></div>
                                    <div><label>D: Keadaan Umum</label><?php foreach (['Composmentis', 'Apatis', 'Somnolen', 'Soporus', 'Comatous'] as $v): ?><label><input type="radio" name="data_dasar[keadaan_umum]" value="<?= h($v) ?>"> <?= h($v) ?></label><?php endforeach; ?></div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="kajian-section-title">Non Trauma</div>
                                <div class="kajian-check-columns"><?php foreach (['Bedah Syaraf', 'Bedah Umum', 'Bedah Orthopedi', 'Bedah Urologi', 'Bedah Digestif', 'Peny. Dalam', 'Kesehatan Anak', 'Obgyn', 'Kulit & Kelamin', 'THT', 'Saraf', 'Mata', 'Jiwa'] as $nt): ?><label><input type="checkbox" name="data_dasar[non_trauma][]" value="<?= h($nt) ?>"> <?= h($nt) ?></label><?php endforeach; ?></div>
                                <div class="kajian-section-title">Polisi & VER</div>
                                <div class="kajian-line"><label>Kasus Polisi</label><label><input type="radio" name="data_dasar[kasus_polisi]" value="Ya"> Ya</label><label><input type="radio" name="data_dasar[kasus_polisi]" value="Tidak"> Tidak</label></div>
                                <div class="kajian-line"><label>VER</label><label><input type="radio" name="data_dasar[ver]" value="Ya"> Ya</label><label><input type="radio" name="data_dasar[ver]" value="Tidak"> Tidak</label><label><input type="checkbox" name="data_dasar[ver_belum_diminta]" value="1"> Belum ada permintaan</label></div>
                                <div class="kajian-section-title">Vital Sign</div>
                                <div class="kajian-vitals">
                                    <label>TD <input type="text" name="data_dasar[tekanan_darah]" class="form-control input-sm" value="<?= h($emr->blood_pressure ?? '') ?>"></label>
                                    <label>Nadi <input type="number" name="data_dasar[nadi]" class="form-control input-sm" value="<?= h($emr->pulse ?? '') ?>"></label>
                                    <label>Napas <input type="number" name="data_dasar[napas]" class="form-control input-sm" value="<?= h($emr->respiratory_rate ?? '') ?>"></label>
                                    <label>Suhu <input type="text" name="data_dasar[suhu]" class="form-control input-sm" value="<?= h($emr->temperature ?? '') ?>"></label>
                                    <label>BB <input type="text" name="data_dasar[bb]" class="form-control input-sm" value="<?= h($emr->weight ?? '') ?>"></label>
                                    <label>TB <input type="text" name="data_dasar[tb]" class="form-control input-sm" value="<?= h($emr->height ?? '') ?>"></label>
                                    <label>LLA <input type="text" name="data_dasar[lla]" class="form-control input-sm"></label>
                                    <label>Skala Nyeri <input type="text" name="data_dasar[skala_nyeri]" class="form-control input-sm" value="<?= h($emr->pain_scale ?? '') ?>"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="kma-tab-subjektif" class="tab-pane">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kajian-section-title">Data Subjektif</div>
                                <label>Keluhan Utama</label><textarea name="subjektif[keluhan_utama]" class="form-control kajian-textarea"><?= h($emr->chief_complaint ?? '') ?></textarea>
                                <label>Riwayat Penyakit Sekarang</label><textarea name="subjektif[riwayat_penyakit_sekarang]" class="form-control kajian-textarea"><?= h($emr->illness_history ?? '') ?></textarea>
                                <label>Riwayat Penyakit Dahulu / Operasi</label><textarea name="subjektif[riwayat_penyakit_dahulu]" class="form-control kajian-textarea"></textarea>
                                <label>Riwayat Penyakit Dalam Keluarga</label><textarea name="subjektif[riwayat_keluarga]" class="form-control kajian-textarea"></textarea>
                                <label>Obat Yang Diminum</label><textarea name="subjektif[obat_diminum]" class="form-control kajian-textarea"></textarea>
                                <label>Kebiasaan Hidup</label>
                                <div class="kajian-line"><label><input type="checkbox" name="subjektif[kebiasaan][]" value="Merokok"> Merokok</label><label><input type="checkbox" name="subjektif[kebiasaan][]" value="Minuman beralkohol"> Minuman beralkohol</label><label><input type="checkbox" name="subjektif[kebiasaan][]" value="Kontak dengan bahan berbahaya"> Kontak bahan berbahaya</label></div>
                                <input type="text" name="subjektif[kebiasaan_lain]" class="form-control input-sm" placeholder="Lain-lain...">
                            </div>
                            <div class="col-md-6">
                                <div class="kajian-section-title">Data Objektif</div>
                                <div class="row"><div class="col-xs-4"><label>GCS E</label><input type="number" name="subjektif[gcs_e]" class="form-control input-sm"></div><div class="col-xs-4"><label>M</label><input type="number" name="subjektif[gcs_m]" class="form-control input-sm"></div><div class="col-xs-4"><label>V</label><input type="number" name="subjektif[gcs_v]" class="form-control input-sm"></div></div>
                                <?php foreach (['kepala' => 'Kepala', 'leher' => 'Leher', 'thorax' => 'Thorax', 'abdomen' => 'Abdomen', 'genital' => 'Genital', 'ekstremitas' => 'Ekstremitas'] as $key => $label): ?>
                                    <label><?= h($label) ?></label><input type="text" name="subjektif[pemeriksaan_fisik][<?= h($key) ?>]" class="form-control input-sm">
                                <?php endforeach; ?>
                                <div class="kajian-section-title">Pemeriksaan Penunjang</div>
                                <div class="kajian-line"><?php foreach (['GDS', 'EKG', 'USG', 'X-FOTO', 'C SCAN', 'MRI', 'LABORAT', 'Lain-lain'] as $support): ?><label><input type="checkbox" name="subjektif[pemeriksaan_penunjang][]" value="<?= h($support) ?>"> <?= h($support) ?></label><?php endforeach; ?></div>
                            </div>
                        </div>
                    </div>
                    <div id="kma-tab-observasi" class="tab-pane">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kajian-section-title">Observasi</div>
                                <label>Waktu</label><input type="time" name="observasi[waktu]" class="form-control input-sm">
                                <label>Keluhan / Keadaan</label><textarea name="observasi[keluhan_keadaan]" class="form-control kajian-observasi-text"></textarea>
                                <label>Tanda Vital</label><textarea name="observasi[tanda_vital]" class="form-control kajian-observasi-text"></textarea>
                                <label>Penatalaksanaan</label><textarea name="observasi[penatalaksanaan]" class="form-control kajian-observasi-text"></textarea>
                                <div class="kajian-section-title">Alat Yang Terpasang</div>
                                <?php foreach (['iv_line' => 'IV Line', 'kateter' => 'Kateter (DC)', 'cvc' => 'CVC', 'ngt' => 'NGT', 'ett' => 'ETT', 'lain' => 'Lain-lain'] as $key => $label): ?>
                                    <div class="row kajian-device-row"><div class="col-xs-3"><label><input type="checkbox" name="observasi[alat][<?= h($key) ?>][checked]" value="1"> <?= h($label) ?></label></div><div class="col-xs-4"><input type="text" name="observasi[alat][<?= h($key) ?>][lokasi]" class="form-control input-sm" placeholder="Lokasi / ukuran"></div><div class="col-xs-5"><input type="text" name="observasi[alat][<?= h($key) ?>][keterangan]" class="form-control input-sm" placeholder="Keterangan"></div></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="kajian-section-title">Hasil Akhir</div>
                                <div class="kajian-line vertical"><label><input type="checkbox" name="observasi[hasil_akhir][]" value="Dipulangkan"> Dipulangkan</label><label><input type="checkbox" name="observasi[hasil_akhir][]" value="Dirawat"> Dirawat, ruangan</label><input type="text" name="observasi[ruangan]" class="form-control input-sm" placeholder="Nama ruangan..."><label><input type="checkbox" name="observasi[hasil_akhir][]" value="Dirujuk untuk tindakan"> Dirujuk untuk tindakan</label></div>
                                <div class="kajian-line vertical" style="margin-left:18px;"><?php foreach (['Kamar Bedah', 'Hemodialisa', 'Poli Bedah', 'Angiografi / Endoskopi', 'Kemoterapi', 'THC'] as $target): ?><label><input type="radio" name="observasi[target_tindakan]" value="<?= h($target) ?>"> <?= h($target) ?></label><?php endforeach; ?><input type="text" name="observasi[target_tindakan_lain]" class="form-control input-sm" placeholder="Lain-lain..."></div>
                                <div class="kajian-line vertical"><label><input type="checkbox" name="observasi[dirujuk_rs]" value="1"> Dirujuk ke Rumah Sakit</label><input type="text" name="observasi[rumah_sakit_tujuan]" class="form-control input-sm" placeholder="Rumah sakit tujuan..."><input type="text" name="observasi[alasan_rujuk]" class="form-control input-sm" placeholder="Alasan rujuk..."><label><input type="checkbox" name="observasi[meninggal]" value="1"> Meninggal, pukul</label><input type="time" name="observasi[jam_meninggal]" class="form-control input-sm"><input type="text" name="observasi[penyebab_meninggal]" class="form-control input-sm" placeholder="Penyebab..."></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kajian-footer">
                    <span id="kma-message"></span>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-save-kajian-awal"><i class="fa fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>


<!-- ── POPUP HASIL PEMERIKSAAN EMR ── -->
<div class="modal fade" id="modal-hasil-pemeriksaan-emr" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-hasil-dialog" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-list"></i> VIEW HASIL PEMERIKSAAN</span>
                <button type="button" class="hasil-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <div class="hasil-body">
                <div class="row hasil-row">
                    <label class="col-xs-2">No. Registrasi</label>
                    <div class="col-xs-3">
                        <input type="text" id="emr-hp-noreg" class="form-control input-sm" readonly>
                    </div>

                    <label class="col-xs-1">Rekmed</label>
                    <div class="col-xs-2">
                        <input type="text" id="emr-hp-rekmed" class="form-control input-sm" readonly>
                    </div>

                    <label class="col-xs-1">View By</label>
                    <div class="col-xs-3 hasil-radio">
                        <label><input type="radio" name="emr_hp_view_by" value="noreg" checked> Noreg</label>
                        <label><input type="radio" name="emr_hp_view_by" value="rekmed"> Rekmed</label>
                    </div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-2">Nama Pasien</label>
                    <div class="col-xs-6">
                        <input type="text" id="emr-hp-nama" class="form-control input-sm" readonly>
                    </div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-2">Hasil Pemeriksaan</label>
                    <div class="col-xs-5 hasil-radio">
                        <label><input type="radio" name="emr_hp_jenis" value="laboratorium" checked> Laboratorium</label>
                        <label><input type="radio" name="emr_hp_jenis" value="radiologi"> Radiologi</label>
                        <label><input type="radio" name="emr_hp_jenis" value="penunjang"> Penunjang</label>
                    </div>

                    <div class="col-xs-5 text-right hasil-actions">
                        <button type="button" class="btn btn-xs btn-default">
                            <i class="fa fa-cog"></i> Proses
                        </button>
                        <button type="button" class="btn btn-xs btn-default">
                            hasil dari upload
                        </button>
                        <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
                            <i class="fa fa-sign-out-alt"></i> KELUAR
                        </button>
                    </div>
                </div>

                <div class="table-responsive hasil-table-wrap">
                    <table class="table table-bordered hasil-table">
                        <thead>
                            <tr>
                                <th style="width:150px;">No. Pemeriksaan</th>
                                <th style="width:120px;">Tanggal</th>
                                <th>Hasil</th>
                                <th style="width:170px;">Nama Dokter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="emr-hp-no-pemeriksaan"></td>
                                <td id="emr-hp-tanggal"></td>
                                <td id="emr-hp-hasil"></td>
                                <td id="emr-hp-dokter"></td>
                            </tr>
                            <tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
                            <tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
                            <tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
                            <tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ── MODAL SURAT KETERANGAN SAKIT ── -->
<div class="modal fade" id="modal-surat-sakit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:640px; max-width:95%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-file-medical"></i> Surat Keterangan Sakit</span>
                <button type="button" class="hasil-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="hasil-body" style="max-height:75vh; overflow-y:auto;">
                <div class="row hasil-row">
                    <label class="col-xs-3">No Surat</label>
                    <div class="col-xs-9"><input type="text" id="sks-noSurat" class="form-control input-sm" value="AUTO" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">No Rekam Medis</label>
                    <div class="col-xs-9"><input type="text" id="sks-rekmed" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Nama Pasien</label>
                    <div class="col-xs-9"><input type="text" id="sks-nama" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Alamat</label>
                    <div class="col-xs-9"><textarea id="sks-alamat" class="form-control input-sm" rows="2" readonly></textarea></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Umur</label>
                    <div class="col-xs-4"><input type="text" id="sks-umur" class="form-control input-sm" readonly></div>
                    <label class="col-xs-2">Jenis Kelamin</label>
                    <div class="col-xs-3"><input type="text" id="sks-jk" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Berat Badan (Kg)</label>
                    <div class="col-xs-3"><input type="number" id="sks-bb" class="form-control input-sm"></div>
                    <label class="col-xs-3">Tinggi Badan (Cm)</label>
                    <div class="col-xs-3"><input type="number" id="sks-tb" class="form-control input-sm"></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Buta Warna</label>
                    <div class="col-xs-3"><input type="text" id="sks-butawarna" class="form-control input-sm" placeholder="-"></div>
                    <label class="col-xs-3">Golongan Darah</label>
                    <div class="col-xs-3"><input type="text" id="sks-goldar" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Tensi Darah</label>
                    <div class="col-xs-3"><input type="text" id="sks-td" class="form-control input-sm"></div>
                    <label class="col-xs-3">Suhu Badan (°C)</label>
                    <div class="col-xs-3"><input type="number" step="0.1" id="sks-suhu" class="form-control input-sm"></div>
                </div>
                <div class="row hasil-row" style="display:flex; align-items:center; gap:8px; flex-wrap:nowrap; margin-left:2px;">
                    <label style="flex:0 0 auto; margin:0; white-space:nowrap;">Ijin (Hari)</label>
                    <input type="number" id="sks-lama" class="form-control input-sm" min="0" value="0" style="width:60px; flex:0 0 auto;">
                    <label style="flex:0 0 auto; margin:0 0 0 30px; white-space:nowrap;">Dari</label>
                    <input type="date" id="sks-dari" class="form-control input-sm" style="width:150px; flex:0 0 auto;">
                    <label style="flex:0 0 auto; margin:0 0 0 6px; white-space:nowrap;">S/d</label>
                    <input type="date" id="sks-sampai" class="form-control input-sm" style="width:150px; flex:0 0 auto;">
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Diagnosa Sakit</label>
                    <div class="col-xs-9"><textarea id="sks-diagnosa" class="form-control" rows="3"></textarea></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Dokter Pemeriksa</label>
                    <div class="col-xs-6"><input type="text" id="sks-dokter" class="form-control input-sm" readonly></div>
                    <label class="col-xs-1">Tgl</label>
                    <div class="col-xs-2"><input type="text" id="sks-tglperiksa" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <div class="col-xs-12">
                        <label><input type="checkbox" id="sks-normal" checked> Normal</label>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-sks">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-default btn-sm" id="btn-cetak-sks" disabled>
                            <i class="fa fa-print"></i> Cetak
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── MODAL SURAT KONTROL BPJS ── -->
<div class="modal fade" id="modal-surat-kontrol-bpjs" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:640px; max-width:96%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-file-medical"></i> Surat Kontrol BPJS</span>
                <button type="button" class="hasil-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="hasil-body" style="max-height:75vh; overflow-y:auto;">
                <div class="row hasil-row">
                    <label class="col-xs-3">No Surat</label>
                    <div class="col-xs-9"><input type="text" id="skb-noSurat" class="form-control input-sm" value="AUTO" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">No Rekam Medis</label>
                    <div class="col-xs-9"><input type="text" id="skb-rekmed" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Nama Pasien</label>
                    <div class="col-xs-6"><input type="text" id="skb-nama" class="form-control input-sm" readonly></div>
                    <label class="col-xs-1">JK</label>
                    <div class="col-xs-2"><input type="text" id="skb-jk" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Tgl Lahir</label>
                    <div class="col-xs-4"><input type="text" id="skb-tgl-lahir" class="form-control input-sm" readonly></div>
                    <label class="col-xs-2">No Kartu BPJS</label>
                    <div class="col-xs-3"><input type="text" id="skb-no-kartu" class="form-control input-sm" placeholder="0001480121335"></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Kepada Yth (Dokter Tujuan)</label>
                    <div class="col-xs-9">
                        <select id="skb-dokter-tujuan" class="form-control input-sm">
                            <option value="">-- Pilih Dokter --</option>
                        </select>
                    </div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Diagnosa</label>
                    <div class="col-xs-9"><textarea id="skb-diagnosa" class="form-control input-sm" rows="2" placeholder="Otomatis dari ICD-10 (Utama)" readonly style="background:#f5f5f5;"></textarea></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Dokter Pemeriksa (DPJP)</label>
                    <div class="col-xs-6"><input type="text" id="skb-dokter" class="form-control input-sm" readonly></div>
                    <label class="col-xs-1">Tgl</label>
                    <div class="col-xs-2"><input type="text" id="skb-tglperiksa" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Tgl Kontrol Berikutnya</label>
                    <div class="col-xs-9"><input type="date" id="skb-tgl-kontrol" class="form-control input-sm"></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Catatan</label>
                    <div class="col-xs-9"><textarea id="skb-catatan" class="form-control" rows="3"
                        placeholder="Keterangan tambahan untuk surat kontrol BPJS..."></textarea></div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-skb">
                            <i class="fa fa-save"></i> Buat Surat Kontrol BPJS
                        </button>
                        <button type="button" class="btn btn-success btn-sm" id="btn-cetak-skb" disabled>
                            <i class="fa fa-print"></i> Cetak
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-surat-konsultasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:900px; max-width:95%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-file-medical"></i> Surat Konsultasi Dokter</span>
                <button type="button" class="hasil-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="hasil-body" style="max-height:75vh; overflow-y:auto;">
                <div class="row hasil-row">
                    <label class="col-xs-3">No Surat</label>
                    <div class="col-xs-9"><input type="text" id="ksl-noSurat" class="form-control input-sm" value="AUTO" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">No Rekam Medis</label>
                    <div class="col-xs-9"><input type="text" id="ksl-rekmed" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Nama</label>
                    <div class="col-xs-9"><input type="text" id="ksl-nama" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Alamat</label>
                    <div class="col-xs-9"><textarea id="ksl-alamat" class="form-control input-sm" rows="2" readonly></textarea></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Umur</label>
                    <div class="col-xs-9"><input type="text" id="ksl-umur" class="form-control input-sm" readonly></div>
                </div>
               <div class="row hasil-row" style="position:relative;">
                    <label class="col-xs-3">Diagnosa ICD X</label>
                    <div class="col-xs-9">
                        <textarea id="ksl-diagnosa" class="form-control input-sm" rows="3"
                                  placeholder="Otomatis dari ICD-10 EMR" readonly
                                  style="resize:none; font-family:monospace; font-size:12px;"></textarea>
                    </div>
                </div>
                <div class="row hasil-row">
                    <div class="col-sm-6">
                        <label>Keterangan Konsultasi</label>
                        <textarea id="ksl-catatan" class="form-control" rows="7"
                                  placeholder="Keterangan konsultasi..."></textarea>
                        <div id="ksl-catatan-status" class="text-muted" style="font-size:11px; margin-top:4px;">
                            Belum disimpan
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Saran / Jawaban Konsultasi</label>
                        <textarea id="ksl-jawaban" class="form-control" rows="7"
                                  placeholder="Saran atau jawaban konsultasi..."></textarea>
                        <div id="ksl-jawaban-status" class="text-muted" style="font-size:11px; margin-top:4px;">
                            Isi setelah keterangan konsultasi disimpan
                        </div>
                    </div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Dokter</label>
                    <div class="col-xs-6"><input type="text" id="ksl-dokter" class="form-control input-sm" readonly></div>
                    <label class="col-xs-1">Tgl</label>
                    <div class="col-xs-2"><input type="text" id="ksl-tglperiksa" class="form-control input-sm" readonly></div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-ksl">
                            <i class="fa fa-save"></i> Simpan Keterangan
                        </button>
                        <button type="button" class="btn btn-success btn-sm" id="btn-simpan-jkl">
                            <i class="fa fa-save"></i> Simpan Jawaban
                        </button>
                        <button type="button" class="btn btn-default btn-sm" id="btn-cetak-ksl" disabled>
                            <i class="fa fa-print"></i> Cetak Surat Konsultasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-surat-sehat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:640px; max-width:95%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-file-medical"></i> Surat Keterangan Dokter</span>
                <button type="button" class="hasil-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="hasil-body" style="max-height:75vh; overflow-y:auto;">
                <div class="row hasil-row">
                    <label class="col-xs-3">No Surat</label>
                    <div class="col-xs-9"><input type="text" id="skh-noSurat" class="form-control input-sm" value="AUTO" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">No Rekam Medis</label>
                    <div class="col-xs-9"><input type="text" id="skh-rekmed" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Nama Pasien</label>
                    <div class="col-xs-9"><input type="text" id="skh-nama" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Alamat</label>
                    <div class="col-xs-9"><textarea id="skh-alamat" class="form-control input-sm" rows="2" readonly></textarea></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Umur</label>
                    <div class="col-xs-4"><input type="text" id="skh-umur" class="form-control input-sm" readonly></div>
                    <label class="col-xs-2">Jenis Kelamin</label>
                    <div class="col-xs-3"><input type="text" id="skh-jk" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Berat Badan (Kg)</label>
                    <div class="col-xs-3"><input type="number" id="skh-bb" class="form-control input-sm"></div>
                    <label class="col-xs-3">Buta Warna</label>
                    <div class="col-xs-3"><input type="text" id="skh-butawarna" class="form-control input-sm" placeholder="-"></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Tinggi Badan (Cm)</label>
                    <div class="col-xs-3"><input type="number" id="skh-tb" class="form-control input-sm"></div>
                    <label class="col-xs-3">Golongan Darah</label>
                    <div class="col-xs-3"><input type="text" id="skh-goldar" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Tensi Darah</label>
                    <div class="col-xs-3"><input type="text" id="skh-td" class="form-control input-sm" placeholder="120/80"></div>
                    <label class="col-xs-3">Suhu Badan (°C)</label>
                    <div class="col-xs-3"><input type="number" step="0.1" id="skh-suhu" class="form-control input-sm"></div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-3">Hasil Periksa</label>
                    <div class="col-xs-9 hasil-radio">
                        <label><input type="radio" name="skh_hasil" id="skh-hasil-sehat" value="sehat" checked> SEHAT</label>
                        <label><input type="radio" name="skh_hasil" id="skh-hasil-tidak-sehat" value="tidak_sehat"> TIDAK SEHAT</label>
                    </div>
                </div>
                <div class="row hasil-row">
                    <div class="col-xs-12">
                        <textarea id="skh-hasil-detail" class="form-control" rows="3"
                                  placeholder="Catatan hasil pemeriksaan..."></textarea>
                    </div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-12" style="margin-bottom:4px;">
                        Surat keterangan dokter ini diberikan untuk menerangkan bahwa:
                    </label>
                    <div class="col-xs-12">
                        <textarea id="skh-keterangan" class="form-control" rows="3"
                                  placeholder="Keterangan tambahan..."></textarea>
                    </div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-3">Dokter Pemeriksa</label>
                    <div class="col-xs-6"><input type="text" id="skh-dokter" class="form-control input-sm" readonly></div>
                    <label class="col-xs-1">Tgl</label>
                    <div class="col-xs-2"><input type="text" id="skh-tglperiksa" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <div class="col-xs-12">
                        <label><input type="checkbox" id="skh-normal" checked> Normal</label>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-skh">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-default btn-sm" id="btn-cetak-skh" disabled>
                            <i class="fa fa-print"></i> Cetak
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-protokol-terapi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:640px; max-width:95%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-file-medical"></i> Protokol Terapi</span>
                <button type="button" class="hasil-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="hasil-body" style="max-height:75vh; overflow-y:auto;">
                <div class="row hasil-row">
                    <label class="col-xs-3">No Surat</label>
                    <div class="col-xs-9"><input type="text" id="spt-noSurat" class="form-control input-sm" value="AUTO" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">No Rekam Medis</label>
                    <div class="col-xs-9"><input type="text" id="spt-rekmed" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Nama Pasien</label>
                    <div class="col-xs-9"><input type="text" id="spt-nama" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Alamat</label>
                    <div class="col-xs-9"><textarea id="spt-alamat" class="form-control input-sm" rows="2" readonly></textarea></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Umur</label>
                    <div class="col-xs-4"><input type="text" id="spt-umur" class="form-control input-sm" readonly></div>
                    <label class="col-xs-2">Jenis Kelamin</label>
                    <div class="col-xs-3"><input type="text" id="spt-jk" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Berat Badan (Kg)</label>
                    <div class="col-xs-3"><input type="number" id="spt-bb" class="form-control input-sm"></div>
                    <label class="col-xs-3">Tinggi Badan (Cm)</label>
                    <div class="col-xs-3"><input type="number" id="spt-tb" class="form-control input-sm"></div>
                </div>
                <div class="row hasil-row">
                    <label class="col-xs-3">Tensi Darah</label>
                    <div class="col-xs-3"><input type="text" id="spt-td" class="form-control input-sm" placeholder="120/80"></div>
                    <label class="col-xs-3">Suhu Badan (°C)</label>
                    <div class="col-xs-3"><input type="number" step="0.1" id="spt-suhu" class="form-control input-sm"></div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-3">Diagnosa Sakit</label>
                    <div class="col-xs-9"><textarea id="spt-diagnosa" class="form-control" rows="2"></textarea></div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-3">Obat dan Dosis</label>
                    <div class="col-xs-9"><textarea id="spt-obat" class="form-control" rows="3"
                                                      placeholder="Nama obat, dosis, aturan pakai..."></textarea></div>
                </div>

                <div class="row hasil-row" style="display:flex; align-items:center; gap:8px; margin-left:2px;">
                    <label style="flex:0 0 auto; margin:0;">Selama</label>
                    <input type="number" id="spt-lama" class="form-control input-sm"
                           min="0" value="0" style="width:80px; flex:0 0 auto; margin-left:105px;">
                    <span style="flex:0 0 auto;">Hari</span>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-3">Alasan Pemberian</label>
                    <div class="col-xs-9"><textarea id="spt-alasan" class="form-control" rows="3"
                                                      placeholder="Alasan pemberian terapi..."></textarea></div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-3">Dokter Pemeriksa</label>
                    <div class="col-xs-6"><input type="text" id="spt-dokter" class="form-control input-sm" readonly></div>
                    <label class="col-xs-1">Tgl</label>
                    <div class="col-xs-2"><input type="text" id="spt-tglperiksa" class="form-control input-sm" readonly></div>
                </div>
                <div class="row hasil-row">
                    <div class="col-xs-12">
                        <label><input type="checkbox" id="spt-normal" checked> Normal</label>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-spt">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-default btn-sm" id="btn-cetak-spt" disabled>
                            <i class="fa fa-print"></i> Cetak
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-surat-bukti-rajal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:980px; max-width:97%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-receipt"></i> Bukti Pelayanan Kesehatan — Rawat Jalan</span>
                <button type="button" class="hasil-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="hasil-body" style="max-height:88vh; overflow-y:auto; padding:10px 14px; font-size:12px;">

                <div class="row">
                    <!-- ══ KOLOM KIRI ══ -->
                    <div class="col-xs-6" style="border-right:1px solid #c9d6ea; padding-right:14px;">

                        <div class="sbr-line">
                            <label>No Registrasi</label>
                            <input type="text" id="sbr-noreg" class="form-control input-sm" readonly>
                        </div>
                        <div class="sbr-line">
                            <label>No Surat</label>
                            <input type="text" id="sbr-noSurat" class="form-control input-sm" value="AUTO" readonly>
                        </div>
                        <div class="sbr-line">
                            <label>Nama Pasien</label>
                            <input type="text" id="sbr-nama" class="form-control input-sm" readonly>
                        </div>

                        <label class="sbr-label">Anamnesa</label>
                        <textarea id="sbr-anamnesa" class="form-control input-sm sbr-ta-1" placeholder="Keluhan / riwayat singkat..."></textarea>

                        <label class="sbr-label">Diagnosa Utama</label>
                        <textarea id="sbr-diagnosa-utama" class="form-control input-sm sbr-ta-1" placeholder="Otomatis dari ICD-10 (Utama)" readonly style="background:#f5f5f5;"></textarea>

                        <label class="sbr-label">Diagnosa Sekunder</label>
                        <textarea id="sbr-diagnosa-sekunder" class="form-control input-sm sbr-ta-1" placeholder="Otomatis dari ICD-10 (Sekunder)" readonly style="background:#f5f5f5;"></textarea>

                        <label class="sbr-label">Tindakan Utama</label>
                        <textarea id="sbr-tindakan-utama" class="form-control input-sm sbr-ta-1" placeholder="Otomatis dari ICD-9 (Utama)" readonly style="background:#f5f5f5;"></textarea>

                        <label class="sbr-label">Tindakan Sekunder</label>
                        <textarea id="sbr-tindakan-sekunder" class="form-control input-sm sbr-ta-1" placeholder="Otomatis dari ICD-9 (Sekunder)" readonly style="background:#f5f5f5;"></textarea>

                        <label class="sbr-label">Penunjang Diagnosa</label>
                        <div style="position:relative;">
                            <input type="text" id="sbr-penunjang-search" class="form-control input-sm"
                                   placeholder="Cari tindakan penunjang (Lab/Radiologi)..." autocomplete="off">
                            <div id="sbr-penunjang-dropdown" style="
                                display:none; position:absolute; z-index:9999; background:#fff;
                                border:1px solid #ced4da; border-radius:4px; box-shadow:0 4px 12px rgba(0,0,0,.12);
                                max-height:160px; overflow-y:auto; font-size:12px; width:100%;"></div>
                        </div>
                        <textarea id="sbr-penunjang" class="form-control input-sm sbr-ta-1" style="margin-top:4px;"
                                  placeholder="Daftar penunjang diagnosa terpilih..."></textarea>

                    </div>

                    <!-- ══ KOLOM KANAN ══ -->
                    <div class="col-xs-6" style="padding-left:14px;">

                        <div class="sbr-line">
                            <label>Otopsi</label>
                            <div style="display:flex; gap:14px; padding-top:6px;">
                                <label style="font-weight:400;"><input type="radio" name="sbr_otopsi" value="0" checked> Tidak</label>
                                <label style="font-weight:400;"><input type="radio" name="sbr_otopsi" value="1"> Ya</label>
                            </div>
                        </div>

                        <label class="sbr-label">Tindakan - Tindakan Khusus</label>
                        <div style="margin-bottom:6px;">
                            <label style="margin-right:12px; font-weight:400;"><input type="checkbox" class="sbr-special-action" value="Phaco"> Phaco</label>
                            <label style="margin-right:12px; font-weight:400;"><input type="checkbox" class="sbr-special-action" value="Hemodialisa"> Hemodialisa</label>
                            <label style="margin-right:12px; font-weight:400;"><input type="checkbox" class="sbr-special-action" value="CT-SCAN"> CT-SCAN</label>
                            <label style="font-weight:400;"><input type="checkbox" class="sbr-special-action" value="Kemoterapi"> Kemoterapi</label>
                            <br>
                            <label style="font-weight:400;"><input type="checkbox" class="sbr-special-action" value="Lainnya" id="sbr-special-lainnya-check"> Lainnya</label>
                            <input type="text" id="sbr-special-lainnya-text" class="form-control input-sm"
                                   placeholder="Sebutkan tindakan khusus lainnya..." style="margin-top:3px; display:none;">
                        </div>

                        <label class="sbr-label">Resep</label>
                        <textarea id="sbr-resep" class="form-control input-sm sbr-ta-2" placeholder="Nama obat, dosis, jumlah..."></textarea>

                        <label class="sbr-label">Saran / Anjuran</label>
                        <textarea id="sbr-saran" class="form-control input-sm sbr-ta-1" placeholder="Saran / anjuran untuk pasien..."></textarea>

                        <div class="sbr-line">
                            <label>Dipulangkan Oleh Dr</label>
                            <select id="sbr-dokter-pulang" class="form-control input-sm">
                                <option value="">-- Pilih Dokter --</option>
                            </select>
                        </div>

                        <div class="sbr-line">
                            <label>Dokter yg Melengkapi</label>
                            <select id="sbr-dokter-lengkap" class="form-control input-sm">
                                <option value="">-- Pilih Dokter --</option>
                            </select>
                        </div>

                        <div class="sbr-line">
                            <label>Nama Pasien / Keluarga</label>
                            <input type="text" id="sbr-nama-keluarga" class="form-control input-sm"
                                   placeholder="Nama pada surat (pasien / wali / keluarga)...">
                        </div>

                    </div>
                </div>

                <div class="row" style="margin-top:10px; border-top:1px solid #c9d6ea; padding-top:8px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-default btn-sm" id="btn-tambah-sbr">Tambah</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-sbr">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-default btn-sm" id="btn-edit-sbr">Edit</button>
                        <button type="button" class="btn btn-success btn-sm" id="btn-cetak-sbr" disabled>
                            <i class="fa fa-print"></i> Cetak
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.sbr-line {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 5px;
}
.sbr-line label {
    width: 130px;
    flex: 0 0 130px;
    margin: 0;
    font-weight: 600;
    font-size: 11px;
}
.sbr-line input,
.sbr-line select {
    flex: 1;
}
.sbr-label {
    display: block;
    font-weight: 600;
    font-size: 11px;
    margin: 5px 0 2px;
}
.sbr-ta-1 {
    height: 40px !important;
    min-height: 40px !important;
    resize: vertical;
    margin-bottom: 2px;
}
.sbr-ta-2 {
    height: 56px !important;
    min-height: 56px !important;
    resize: vertical;
    margin-bottom: 2px;
}
</style>

<!-- ── MODAL PILIH TINDAKAN & TARIF ── -->
<div class="modal fade" id="modal-pilih-tindakan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:960px; max-width:96%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-search"></i> DAFTAR TINDAKAN & TARIF</span>
                <button type="button" class="hasil-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="hasil-body" style="padding:14px;">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-xs-12">
                        <label style="font-weight:600;">Cari</label>
                        <input type="text" id="pt-search-input" class="form-control input-sm"
                               placeholder="Ketik kode / nama tindakan..." autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <!-- Daftar tindakan -->
                    <div class="col-xs-8">
                        <div style="border:1px solid #9eb2d1; background:#f7f9ff; max-height:360px; overflow-y:auto;">
                            <table class="table table-bordered table-sm" style="margin-bottom:0; font-size:12px;">
                                <thead>
                                    <tr style="background:#c8d8f0;">
                                        <th style="width:34px; text-align:center;">Pilih</th>
                                        <th style="width:80px;">Kode</th>
                                        <th>Nama Tindakan</th>
                                        <th style="width:110px;">Kategori</th>
                                        <th style="width:110px; text-align:right;">Tarif</th>
                                    </tr>
                                </thead>
                                <tbody id="pt-list-body">
                                    <tr>
                                        <td colspan="5" style="text-align:center; color:#999; padding:14px;">
                                            <i class="fa fa-spinner fa-spin"></i> Memuat data...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tindakan terpilih -->
                    <div class="col-xs-4">
                        <div style="border:1px solid #9eb2d1; background:#eef3ff; max-height:360px; overflow-y:auto; min-height:360px;">
                            <div style="background:#c8d8f0; padding:6px 10px; font-weight:700; font-size:11px;">
                                Tindakan Terpilih
                            </div>
                            <table class="table table-bordered table-sm" style="margin-bottom:0; font-size:11px;">
                                <thead>
                                    <tr style="background:#dbe6fb;">
                                        <th style="width:60px;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width:80px; text-align:right;">Tarif</th>
                                        <th style="width:24px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="pt-selected-body">
                                    <tr id="pt-selected-empty">
                                        <td colspan="4" style="text-align:center; color:#aaa; padding:12px; font-size:11px;">
                                            Belum ada tindakan dipilih.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:12px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-ok-pilih-tindakan">
                            <i class="fa fa-check"></i> OK
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── MODAL PILIH ICD-10 ── -->
<div class="modal fade" id="modal-pilih-icd10" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:900px; max-width:96%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-diagnoses"></i> DAFTAR ICD-10</span>
                <button type="button" class="hasil-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="hasil-body" style="padding:14px;">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-xs-12">
                        <label style="font-weight:600;">Cari</label>
                        <input type="text" id="i10-search-input" class="form-control input-sm"
                               placeholder="Ketik kode / nama diagnosa..." autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div style="border:1px solid #9eb2d1; background:#f7f9ff; max-height:360px; overflow-y:auto;">
                            <table class="table table-bordered table-sm" style="margin-bottom:0; font-size:12px;">
                                <thead>
                                    <tr style="background:#dbeafe;">
                                        <th style="width:34px; text-align:center;">Pilih</th>
                                        <th style="width:90px;">Kode</th>
                                        <th>Nama Diagnosa</th>
                                    </tr>
                                </thead>
                                <tbody id="i10-list-body">
                                    <tr><td colspan="3" style="text-align:center; color:#999; padding:14px;">
                                        <i class="fa fa-spinner fa-spin"></i> Memuat data...
                                    </td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div style="border:1px solid #9eb2d1; background:#eef3ff; max-height:360px; overflow-y:auto; min-height:360px;">
                            <div style="background:#dbeafe; padding:6px 10px; font-weight:700; font-size:11px;">
                                ICD-10 Terpilih
                            </div>
                            <table class="table table-bordered table-sm" style="margin-bottom:0; font-size:11px;">
                                <thead>
                                    <tr style="background:#e6efff;">
                                        <th style="width:70px;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width:24px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="i10-selected-body">
                                    <tr id="i10-selected-empty">
                                        <td colspan="3" style="text-align:center; color:#aaa; padding:12px; font-size:11px;">
                                            Belum ada dipilih.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:12px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-ok-pilih-icd10">
                            <i class="fa fa-check"></i> OK
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── MODAL PILIH ICD-9 ── -->
<div class="modal fade" id="modal-pilih-icd9" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:900px; max-width:96%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-clipboard-list"></i> DAFTAR ICD-9 CM</span>
                <button type="button" class="hasil-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="hasil-body" style="padding:14px;">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-xs-12">
                        <label style="font-weight:600;">Cari</label>
                        <input type="text" id="i9-search-input" class="form-control input-sm"
                               placeholder="Ketik kode / nama tindakan..." autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div style="border:1px solid #9eb2d1; background:#f7f9ff; max-height:360px; overflow-y:auto;">
                            <table class="table table-bordered table-sm" style="margin-bottom:0; font-size:12px;">
                                <thead>
                                    <tr style="background:#f3e8ff;">
                                        <th style="width:34px; text-align:center;">Pilih</th>
                                        <th style="width:90px;">Kode</th>
                                        <th>Nama Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody id="i9-list-body">
                                    <tr><td colspan="3" style="text-align:center; color:#999; padding:14px;">
                                        <i class="fa fa-spinner fa-spin"></i> Memuat data...
                                    </td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div style="border:1px solid #9eb2d1; background:#eef3ff; max-height:360px; overflow-y:auto; min-height:360px;">
                            <div style="background:#f3e8ff; padding:6px 10px; font-weight:700; font-size:11px;">
                                ICD-9 Terpilih
                            </div>
                            <table class="table table-bordered table-sm" style="margin-bottom:0; font-size:11px;">
                                <thead>
                                    <tr style="background:#f6efff;">
                                        <th style="width:70px;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width:24px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="i9-selected-body">
                                    <tr id="i9-selected-empty">
                                        <td colspan="3" style="text-align:center; color:#aaa; padding:12px; font-size:11px;">
                                            Belum ada dipilih.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:12px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-ok-pilih-icd9">
                            <i class="fa fa-check"></i> OK
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

<!-- ── MODAL SKDP ── -->
<div class="modal fade" id="modal-surat-skdp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:920px; max-width:97%;" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-id-card-alt"></i> Surat Keterangan Dalam Perawatan Spesialis (SKDP)</span>
                <button type="button" class="hasil-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="hasil-body" style="padding:10px 14px; font-size:12px;">

                <!-- Baris info identitas: full width, ringkas -->
                <div class="row">
                    <div class="col-xs-3">
                        <label class="skdp-label">No SKDP</label>
                        <input type="text" id="skdp-noSurat" class="form-control input-sm" value="AUTO" readonly>
                    </div>
                    <div class="col-xs-3">
                        <label class="skdp-label">No Rekam Medis</label>
                        <input type="text" id="skdp-rekmed" class="form-control input-sm" readonly>
                    </div>
                    <div class="col-xs-4">
                        <label class="skdp-label">Nama Pasien</label>
                        <input type="text" id="skdp-nama" class="form-control input-sm" readonly>
                    </div>
                    <div class="col-xs-2">
                        <label class="skdp-label">Tgl Periksa</label>
                        <input type="text" id="skdp-tglperiksa" class="form-control input-sm" readonly>
                    </div>
                </div>

                <div class="row" style="margin-top:6px;">
                    <div class="col-xs-9">
                        <label class="skdp-label">Dokter</label>
                        <input type="text" id="skdp-dokter" class="form-control input-sm" readonly>
                    </div>
                    <div class="col-xs-3">
                        <label class="skdp-label">No Kartu BPJS</label>
                        <input type="text" id="skdp-no-kartu" class="form-control input-sm" placeholder="0001480121335">
                    </div>
                </div>

                <hr style="margin:10px 0;">

                <!-- Dua kolom: kiri klinis, kanan administratif -->
                <div class="row">
                    <!-- ══ KOLOM KIRI: Klinis ══ -->
                    <div class="col-xs-6" style="border-right:1px solid #c9d6ea; padding-right:14px;">
                        <label class="skdp-label">Diagnosa Utama</label>
                        <textarea id="skdp-diagnosa" class="form-control input-sm skdp-ta-1" placeholder="Otomatis dari ICD-10 (Utama)" readonly style="background:#f5f5f5;"></textarea>

                        <label class="skdp-label">Terapi</label>
                        <textarea id="skdp-terapi" class="form-control skdp-ta-2" placeholder="Nama obat, dosis, aturan pakai..."></textarea>

                        <label class="skdp-label">Alasan blm dikembalikan ke perujuk</label>
                        <textarea id="skdp-alasan" class="form-control skdp-ta-2"></textarea>

                        <label class="skdp-label">Rencana Tindak Lanjut Kunjungan Selanjutnya</label>
                        <textarea id="skdp-rencana" class="form-control skdp-ta-2"></textarea>
                    </div>

                    <!-- ══ KOLOM KANAN: Administratif ══ -->
                    <div class="col-xs-6" style="padding-left:14px;">
                        <label class="skdp-label">Tanggal Surat Rujukan</label>
                        <input type="date" id="skdp-tgl-rujukan" class="form-control input-sm">

                        <label class="skdp-label" style="margin-top:8px;">No Rujukan</label>
                        <input type="text" id="skdp-no-rujukan" class="form-control input-sm">

                        <label class="skdp-label" style="margin-top:8px;">Alasan Kontrol</label>
                        <input type="text" id="skdp-keterangan" class="form-control input-sm" placeholder="Misal: kontrol ulang">

                        <label class="skdp-label" style="margin-top:8px;">Tgl Kembali Kontrol</label>
                        <input type="date" id="skdp-tgl-kontrol" class="form-control input-sm">
                    </div>
                </div>

                <div class="row" style="margin-top:12px; border-top:1px solid #c9d6ea; padding-top:8px;">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-skdp">
                            <i class="fa fa-save"></i> Buat SKDP
                        </button>
                        <button type="button" class="btn btn-success btn-sm" id="btn-cetak-skdp" disabled>
                            <i class="fa fa-print"></i> Cetak SKDP
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.vital-row { margin-bottom: 6px; }
.vital-row label {
    font-size: 10px; color: #888; margin-bottom: 2px;
    display: block; font-weight: 600;
}
.emr-locked-field {
    background-color: #f5f5f5 !important;
    cursor: not-allowed !important;
}
a.emr-disabled-link {
    pointer-events: none !important;
    opacity: .5 !important;
    cursor: not-allowed !important;
}
.input-group-addon { font-size: 11px; padding: 4px 6px; }
.panel-heading strong { font-size: 12px; }

.anatomy-tab-chart {
    display: flex;
    gap: 10px;
    align-items: flex-start;
}
.anatomy-thumb {
    flex: 0 0 150px;
    width: 100%;
    border: 1px solid #d7dde5;
    background: #fff;
    padding: 8px;
    text-align: center;
    border-radius: 4px;
    cursor: pointer;
}
.anatomy-thumb:hover {
    border-color: #2d8cff;
    box-shadow: 0 2px 8px rgba(45, 140, 255, .18);
}
.anatomy-thumb-title {
    display: block;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 6px;
    color: #1e3a5f;
}
.anatomy-thumb img {
    width: 100%;
    height: 150px;
    object-fit: contain;
    background: #f8f9fa;
    border: 1px solid #eef1f4;
}
.anatomy-thumb-status {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    color: #6c757d;
}

/* Modal dan kanvas editor anatomi. */
.anatomy-modal-dialog {
    width: 760px;
    max-width: 96%;
}
.anatomy-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    padding: 10px;
    border-bottom: 1px solid #dce3ea;
    background: #f8f9fa;
}
.anatomy-save-message {
    margin-left: 6px;
    font-size: 12px;
    font-weight: 600;
}
.anatomy-canvas-wrap {
    padding: 10px;
    text-align: center;
    overflow: auto;
}
.anatomy-canvas-wrap canvas {
    border: 1px solid #ccd5df;
}
.anatomy-canvas-wrap .lower-canvas {
    background: #fff;
}
.anatomy-canvas-wrap .upper-canvas {
    background: transparent !important;
}

.emr-tab-panel {
    background:#fff;
    border:1px solid #ddd;
}
.emr-tab-panel > .panel-heading {
    background:#f5f7fa !important;
    border-bottom:1px solid #d9d9d9;
    min-height:42px;
}
#tab-surat-rujuk.emr-tabs {
    background:#f5f7fa;
    border-bottom:0 !important;
    padding-top:0;
}
#tab-surat-rujuk.emr-tabs > li > a {
    border-radius:0 !important;
    color:#333 !important;
    background:#f5f7fa !important;
    border:1px solid transparent !important;
    border-right:1px solid #d9d9d9 !important;
    padding:10px 18px !important;
    min-height:42px;
    font-size:12px !important;
    font-weight:600;
    line-height:20px;
    margin-right:0 !important;
}
#tab-surat-rujuk.emr-tabs > li.active > a,
#tab-surat-rujuk.emr-tabs > li.active > a:focus,
#tab-surat-rujuk.emr-tabs > li.active > a:hover {
    background:#1e3a5f !important;
    color:#fff !important;
    border-color:#1e3a5f !important;
}
#tab-surat-rujuk.emr-tabs > li > a:hover {
    background:#e9eef5 !important;
    color:#1e3a5f !important;
}
.emr-tab-body {
    border-top:0;
    min-height:245px;
}
.emr-tab-body .tab-content {
    margin-top:0;
}

.poly-dd-item {
    padding:7px 10px;
    cursor:pointer;
    border-bottom:1px solid #f0f0f0;
}
.poly-dd-item:hover {
    background:#e8f0fe;
}
.poly-dd-name {
    font-weight:600;
    color:#1e3a5f;
}
.poly-dd-empty,
.poly-dd-loading {
    padding:10px;
    text-align:center;
    color:#888;
    font-size:12px;
}

.doctor-dd-item {
    padding:7px 10px;
    cursor:pointer;
    border-bottom:1px solid #f0f0f0;
}
.doctor-dd-item:hover {
    background:#e8f0fe;
}
.doctor-dd-name {
    font-weight:600;
    color:#1e3a5f;
}
.doctor-dd-meta,
.doctor-dd-empty,
.doctor-dd-loading {
    padding:10px;
    color:#888;
    font-size:12px;
}
.doctor-dd-empty,
.doctor-dd-loading {
    text-align:center;
}

/* Hilangkan spinner qty */
input.action-qty::-webkit-outer-spin-button,
input.action-qty::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
input.action-qty { -moz-appearance: textfield; }

/* Tarif readonly */
input.action-unit-price-display {
    background: #f0f0f0 !important; cursor: default !important;
    color: #333 !important; font-weight: 600; text-align: right;
}
input.action-unit-price-display:focus {
    outline: none; box-shadow: none; border-color: #ced4da;
}

/* Autocomplete dropdown tindakan */
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
    text-transform: uppercase; letter-spacing: .5px;
    position: sticky; top: 0;
}
#tindakan-dropdown .dd-item-name { font-weight: 600; color: #1e3a5f; font-size: 12px; }
#tindakan-dropdown .dd-item-meta { font-size: 10px; color: #888; margin-top: 1px; }
#tindakan-dropdown .dd-item-harga { font-weight: 600; color: #27ae60; }
#tindakan-dropdown .dd-empty { padding: 12px; text-align: center; color: #aaa; font-size: 12px; }
#tindakan-dropdown .dd-loading { padding: 12px; text-align: center; color: #888; font-size: 12px; }
#tindakan-dropdown .dd-error { padding: 10px 12px; color: #721c24; background: #f8d7da; font-size: 11px; }

/* Popup Hasil Pemeriksaan EMR */
.modal-hasil-dialog {
    width: 760px;
    max-width: 95%;
    margin-top: 90px;
}
.hasil-window {
    border: 1px solid #5b78a5;
    background: #dfe8f7;
    box-shadow: 0 3px 12px rgba(0,0,0,.25);
    border-radius: 2px;
}
.hasil-title {
    background: #2c64b7;
    color: #fff;
    padding: 5px 8px;
    font-size: 12px;
    font-weight: 700;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.hasil-close {
    border: 0;
    background: transparent;
    color: #fff;
    font-size: 18px;
    line-height: 18px;
    padding: 0 4px;
    opacity: 1;
}
.hasil-body {
    padding: 10px;
    font-size: 12px;
}
.hasil-row {
    margin-bottom: 6px;
}
.hasil-row label {
    font-size: 12px;
    font-weight: 600;
    padding-top: 4px;
}
.hasil-radio label {
    margin-right: 10px;
    font-weight: 500;
}
.hasil-actions .btn {
    margin-left: 3px;
}
.hasil-table-wrap {
    max-height: 250px;
    overflow: auto;
    border: 1px solid #9eb2d1;
    background: #eef3ff;
}
.hasil-table {
    background: #eef3ff;
    margin: 0;
    font-size: 12px;
}
.hasil-table th {
    background: #c8d8f0 !important;
    text-align: center;
    font-weight: 700;
    padding: 5px;
    color: #1f2937;
}
.hasil-table td {
    height: 34px;
    background: #f7f9ff;
    vertical-align: top;
    padding: 5px;
}

#pt-list-body tr.pt-row:hover {
    background: #eef3ff;
}
#pt-list-body tr.pt-row-selected {
    background: #dbe6fb;
}
#pt-list-body tr.pt-row-selected:hover {
    background: #cddaf5;
}

#pt-list-body tr.pt-row-disabled {
    background: #f5f5f5 !important;
}
#pt-list-body tr.pt-row-disabled:hover {
    background: #f5f5f5 !important;
}

#i10-list-body tr.i10-row:hover, #i9-list-body tr.i9-row:hover { background:#eef3ff; }
#i10-list-body tr.i10-row-selected, #i9-list-body tr.i9-row-selected { background:#dbe6fb; }
#i10-list-body tr.i10-row-disabled, #i9-list-body tr.i9-row-disabled { background:#f5f5f5 !important; }
.modal-kajian-dialog {
    width: 1080px;
    max-width: 97%;
    margin-top: 28px;
}
.kajian-window {
    background: #dfe8f7;
}
.kajian-header {
    padding: 8px 10px;
    border-bottom: 1px solid #9eb2d1;
    font-size: 11px;
}
.kajian-header label,
.kajian-body label {
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 2px;
}
.kajian-tabs {
    display: flex;
    padding: 0;
    border-bottom: 1px solid #9eb2d1;
    background: #d7e2f2;
}
.kajian-tabs > li {
    flex: 1 1 0;
    text-align: center;
    margin-bottom: 0;
}
.kajian-tabs > li > a {
    display: block;
    margin-right: 0;
    border-radius: 0;
    border: 1px solid #9eb2d1;
    border-left: 0;
    border-bottom: 0;
    font-size: 12px;
    padding: 7px 14px;
    font-weight: 700;
    color: #1e3a5f;
    background: #c8d8f0;
    text-decoration: none;
}
.kajian-tabs > li:first-child > a {
    border-left: 1px solid #9eb2d1;
}
.kajian-tabs > li.active > a,
.kajian-tabs > li.active > a:focus,
.kajian-tabs > li.active > a:hover,
.kajian-tabs > li > a.active,
.kajian-tabs > li > a.active:focus,
.kajian-tabs > li > a.active:hover {
    background: #ffffff !important;
    color: #0f2f5f !important;
    border-top: 3px solid #2c64b7 !important;
    border-bottom: 1px solid #ffffff !important;
    font-weight: 800;
    text-decoration: none;
    box-shadow: inset 0 1px 0 #ffffff;
}
.kajian-tabs > li:not(.active) > a:hover {
    background: #dbe7f7;
    color: #0f2f5f;
    text-decoration: none;
}
.kajian-body {
    padding: 10px;
    min-height: 455px;
    max-height: 62vh;
    overflow-y: auto;
    font-size: 11px;
}
.kajian-section-title {
    background: #c8d8f0;
    border: 1px solid #9eb2d1;
    color: #1e3a5f;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 7px;
    margin: 6px 0;
}
.kajian-line {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 12px;
    align-items: center;
    margin-bottom: 6px;
}
.kajian-line > label:first-child {
    min-width: 82px;
    color: #1f2937;
}
.kajian-line.vertical {
    display: block;
}
.kajian-line.vertical label {
    display: block;
    margin-bottom: 5px;
}
.kajian-tags-line {
    gap: 10px;
}
.kajian-tag-option {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-right: 6px;
}
.kajian-tag-swatch {
    display: inline-block;
    width: 18px;
    height: 18px;
    border: 1px solid #7f8da3;
    vertical-align: middle;
}
.kajian-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 8px 14px;
}
.kajian-grid-2 label,
.kajian-check-columns label {
    display: block;
    font-weight: 500;
}
.kajian-check-columns {
    columns: 2;
}
.kajian-vitals {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 6px;
}
.kajian-vitals label {
    display: grid;
    grid-template-columns: 72px 1fr;
    gap: 5px;
    align-items: center;
}
.kajian-textarea {
    height: 46px !important;
    resize: vertical;
    margin-bottom: 5px;
    font-size: 11px;
}
.kajian-observasi-text {
    height: 66px !important;
    resize: vertical;
    margin-bottom: 6px;
    font-size: 11px;
}
.kajian-device-row {
    margin-bottom: 5px;
}
.kajian-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    border-top: 1px solid #9eb2d1;
}

.skdp-label {
    display: block;
    font-weight: 600;
    font-size: 11px;
    margin: 5px 0 2px;
}
.skdp-ta-1 {
    height: 44px !important;
    min-height: 44px !important;
    resize: vertical;
    margin-bottom: 2px;
}
.skdp-ta-2 {
    height: 56px !important;
    min-height: 56px !important;
    resize: vertical;
    margin-bottom: 2px;
}

#kma-message {
    font-size: 12px;
    font-weight: 600;
}
</style>

<script>
// Konfigurasi anatomi dibaca oleh webroot/js/outpatient_visit_emr_anatomy.js.
window.OUTPATIENT_ANATOMY_CONFIG = {
    saveUrl: <?= json_encode($this->Url->build([
        'controller' => 'OutpatientVisitEmr',
        'action' => 'saveAnatomy',
        $visit->id,
    ])) ?>,
    csrfToken: <?= json_encode($this->request->getAttribute('csrfToken')) ?>
};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
<script src="<?= h($this->Url->build('/js/outpatient_visit_emr_anatomy.js')) ?>?v=<?= (int)filemtime(WWW_ROOT . 'js' . DS . 'outpatient_visit_emr_anatomy.js') ?>"></script>

<script>
$(document).ready(function () {

var SIMPAN_SKS_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanSuratSakit',
    $visit->id,
])) ?>;
var CETAK_SKS_URL_BASE = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'cetakSuratSakit',
])) ?>;
var GET_SKS_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getSuratSakit',
    $visit->id,
])) ?>;
var GET_KAJIAN_AWAL_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientVisitEmr',
    'action'     => 'kajianAwal',
    $visit->id,
])) ?>;
var GET_SKH_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getSuratSehat',
    $visit->id,
])) ?>;
var SIMPAN_SKH_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanSuratSehat',
    $visit->id,
])) ?>;
var CETAK_SKH_URL_BASE = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'cetakSuratSehat',
])) ?>;
var SIMPAN_KAJIAN_AWAL_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientVisitEmr',
    'action'     => 'simpanKajianAwal',
    $visit->id,
])) ?>;

function kmaFindByName(name) {
    return $('#form-kajian-awal').find('[name]').filter(function () {
        return this.name === name;
    });
}

function kmaSetField(name, value) {
    var $fields = kmaFindByName(name);
    if (!$fields.length && $.isArray(value)) {
        $fields = kmaFindByName(name + '[]');
    }

    if (!$fields.length) {
        return;
    }

    var type = ($fields.first().attr('type') || '').toLowerCase();
    if (type === 'radio') {
        $fields.prop('checked', false).filter(function () {
            return String($(this).val()) === String(value);
        }).prop('checked', true);
        return;
    }

    if (type === 'checkbox') {
        $fields.prop('checked', false);
        if ($.isArray(value)) {
            $fields.each(function () {
                $(this).prop('checked', value.map(String).indexOf(String($(this).val())) !== -1);
            });
        } else {
            $fields.each(function () {
                var checked = String($(this).val()) === String(value) || String(value) === '1' || value === true;
                $(this).prop('checked', checked);
            });
        }
        return;
    }

    $fields.val(value == null ? '' : value);
}

function kmaFillSection(prefix, data) {
    if (!data) {
        return;
    }

    $.each(data, function (key, value) {
        var name = prefix + '[' + key + ']';
        if ($.isPlainObject(value)) {
            kmaFillSection(name, value);
        } else {
            kmaSetField(name, value);
        }
    });
}

function kmaActivateTab(selector) {
    var $tab = $('#modal-kajian-awal .kajian-tabs a[href="' + selector + '"]');
    $('#modal-kajian-awal .kajian-tabs li').removeClass('active');
    $('#modal-kajian-awal .kajian-tabs a').removeClass('active');
    $('#modal-kajian-awal .tab-pane').removeClass('active in');
    $tab.addClass('active').closest('li').addClass('active');
    $(selector).addClass('active in');
}

function kmaResetForm() {
    var form = document.getElementById('form-kajian-awal');
    if (form) {
        form.reset();
    }
    $('#kma-message').text('').css('color', '');
    $('#kma-save-state').val('Memuat...');
    kmaActivateTab('#kma-tab-data-dasar');
}

$('#modal-kajian-awal .kajian-tabs a[data-toggle="tab"]').on('click', function (e) {
    e.preventDefault();
    kmaActivateTab($(this).attr('href'));
});

$('#btn-kajian-awal').on('click', function () {
    kmaResetForm();
    $('#modal-kajian-awal').modal('show');

    $.getJSON(GET_KAJIAN_AWAL_URL)
        .done(function (res) {
            if (!res || !res.success) {
                $('#kma-save-state').val('Gagal dimuat');
                $('#kma-message').text('Gagal memuat kajian medis awal.').css('color', '#b91c1c');
                return;
            }

            var data = res.data || {};
            $('#kma-assessment-no').val(data.assessment_no || 'AUTO');
            $('#kma-assessment-date').val(data.assessment_date || <?= json_encode(date('Y-m-d')) ?>);
            $('#kma-assessment-time').val((data.assessment_time || <?= json_encode(date('H:i')) ?>).substring(0, 5));

            if (res.patient) {
                $('#kma-registration-no').val(res.patient.registration_no || '-');
                $('#kma-medical-record-no').val(res.patient.medical_record_no || '-');
                $('#kma-patient-name').val(res.patient.name || '-');
                $('#kma-doctor-name').val(res.patient.doctor || '-');
            }

            kmaFillSection('data_dasar', data.data_dasar || {});
            kmaFillSection('subjektif', data.subjektif || {});
            kmaFillSection('observasi', data.observasi || {});
            $('#kma-save-state').val(data.id ? 'Sudah tersimpan' : 'Baru');
        })
        .fail(function (xhr) {
            $('#kma-save-state').val('Gagal dimuat');
            $('#kma-message').text('Gagal memuat data (' + xhr.status + ').').css('color', '#b91c1c');
        });
});

$('#btn-save-kajian-awal').on('click', function () {
    var $btn = $(this);
    var csrf = $('#form-kajian-awal input[name="_csrfToken"]').val();

    $('#kma-message').text('Menyimpan...').css('color', '#1e3a5f');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan');

    $.ajax({
        url: SIMPAN_KAJIAN_AWAL_URL,
        method: 'POST',
        data: $('#form-kajian-awal').serialize(),
        dataType: 'json',
        headers: csrf ? {'X-CSRF-Token': csrf} : {}
    }).done(function (res) {
        if (res && res.success) {
            $('#kma-assessment-no').val(res.assessment_no || $('#kma-assessment-no').val());
            $('#kma-save-state').val('Sudah tersimpan');
            $('#kma-message').text(res.message || 'Kajian medis awal berhasil disimpan.').css('color', '#047857');
        } else {
            $('#kma-message').text((res && res.message) || 'Gagal menyimpan kajian medis awal.').css('color', '#b91c1c');
        }
    }).fail(function (xhr) {
        $('#kma-message').text('Gagal menyimpan (' + xhr.status + ').').css('color', '#b91c1c');
    }).always(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
    });
});

$(document).on('click', '.btn-surat-sakit', function () {
    var $b = $(this);

    // Isi dulu dari data pasien/EMR (nilai default)
    $('#sks-rekmed').val($b.data('rekmed'));
    $('#sks-nama').val($b.data('nama'));
    $('#sks-alamat').val($b.data('alamat'));
    $('#sks-umur').val($b.data('umur'));
    $('#sks-jk').val($b.data('jk'));
    $('#sks-bb').val($b.data('bb'));
    $('#sks-tb').val($b.data('tb'));
    $('#sks-td').val($b.data('td'));
    $('#sks-suhu').val($b.data('suhu'));
    $('#sks-goldar').val($b.data('goldar'));
    $('#sks-diagnosa').val($b.data('diagnosa'));
    $('#sks-dokter').val($b.data('dokter'));
    $('#sks-tglperiksa').val($b.data('tglperiksa'));
    $('#sks-dari').val(new Date().toISOString().slice(0, 10));
    $('#sks-sampai').val(new Date().toISOString().slice(0, 10));
    $('#sks-lama').val(1);
    $('#sks-butawarna').val('');  
    $('#sks-normal').prop('checked', true);
    $('#sks-noSurat').val('AUTO');
    currentSksLetterId = null;
    $('#btn-cetak-sks').prop('disabled', true);

    // Timpa dengan data yang sudah pernah disimpan sebelumnya (kalau ada)
    $.ajax({
        url: GET_SKS_URL,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res && res.success && res.data) {
                var d = res.data;
                currentSksLetterId = d.letter_id;
                $('#sks-noSurat').val(d.letter_no || 'AUTO');
                if (d.weight !== null)         $('#sks-bb').val(d.weight);
                if (d.height !== null)         $('#sks-tb').val(d.height);
                if (d.blood_pressure !== null) $('#sks-td').val(d.blood_pressure);
                if (d.temperature !== null)    $('#sks-suhu').val(d.temperature);
                if (d.color_blind !== null)    $('#sks-butawarna').val(d.color_blind);
                if (d.blood_type !== null)     $('#sks-goldar').val(d.blood_type);
                if (d.leave_days !== null)     $('#sks-lama').val(d.leave_days);
                if (d.leave_from)              $('#sks-dari').val(d.leave_from);
                if (d.leave_to)                $('#sks-sampai').val(d.leave_to);
                if (d.diagnosis !== null && d.diagnosis !== '') $('#sks-diagnosa').val(d.diagnosis);
                $('#sks-normal').prop('checked', !!d.is_normal);
                $('#btn-cetak-sks').prop('disabled', false);
            }
        }
    });

    $('#modal-surat-sakit').modal('show');
});

function parseDateInput(str) {
    if (!str) return null;
    var p = str.split('-');
    if (p.length !== 3) return null;
    var d = new Date(parseInt(p[0], 10), parseInt(p[1], 10) - 1, parseInt(p[2], 10));
    return isNaN(d) ? null : d;
}
function formatDateInput(d) {
    var y  = d.getFullYear();
    var m  = String(d.getMonth() + 1).padStart(2, '0');
    var da = String(d.getDate()).padStart(2, '0');
    return y + '-' + m + '-' + da;
}


function hitungSampaiSakit() {
    var dari = $('#sks-dari').val();
    var lama = parseInt($('#sks-lama').val(), 10);
    if (!dari || !lama || lama < 1) return;
    var d1 = parseDateInput(dari);
    if (!d1) return;
    var d2 = new Date(d1);
    d2.setDate(d2.getDate() + (lama - 1));
    $('#sks-sampai').val(formatDateInput(d2));
}

function hitungLamaSakit() {
    var d1 = parseDateInput($('#sks-dari').val());
    var d2 = parseDateInput($('#sks-sampai').val());
    if (d1 && d2 && d2 >= d1) {
        var days = Math.round((d2 - d1) / 86400000) + 1;
        $('#sks-lama').val(days);
    }
}

$('#sks-dari, #sks-lama').on('input change', hitungSampaiSakit);
$('#sks-sampai').on('change', hitungLamaSakit);

$('#btn-simpan-sks').on('click', function () {
    var csrf = $('input[name="_csrfToken"]').val();
    var payload = {
        _csrfToken: csrf,
        weight: $('#sks-bb').val(),
        height: $('#sks-tb').val(),
        blood_pressure: $('#sks-td').val(),
        temperature: $('#sks-suhu').val(),
        color_blind: $('#sks-butawarna').val(),
        blood_type: $('#sks-goldar').val(),
        leave_days: $('#sks-lama').val(),
        leave_from: $('#sks-dari').val(),
        leave_to: $('#sks-sampai').val(),
        diagnosis: $('#sks-diagnosa').val(),
        is_normal: $('#sks-normal').is(':checked') ? 1 : 0,
        examined_at: new Date().toISOString().slice(0, 10),
    };

    $.ajax({
        url: SIMPAN_SKS_URL,
        method: 'POST',
        data: payload,
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#sks-noSurat').val(res.letter_no || 'AUTO');
                currentSksLetterId = res.letter_id;
                $('#btn-cetak-sks').prop('disabled', false);
                alert('Surat berhasil disimpan: ' + res.letter_no);
            } else {
                alert(res.message || 'Gagal menyimpan surat.');
            }
        },
        error: function () {
            alert('Gagal menghubungi server.');
        }
    });
});

$('#btn-cetak-sks').on('click', function () {
    if (!currentSksLetterId) return;
    window.open(CETAK_SKS_URL_BASE + '/' + currentSksLetterId, '_blank');
});

var currentSkhLetterId = null;
 
$(document).on('click', '.btn-surat-sehat', function () {
    var $b = $(this);
 
    $('#skh-rekmed').val($b.data('rekmed'));
    $('#skh-nama').val($b.data('nama'));
    $('#skh-alamat').val($b.data('alamat'));
    $('#skh-umur').val($b.data('umur'));
    $('#skh-jk').val($b.data('jk'));
    $('#skh-bb').val($b.data('bb'));
    $('#skh-tb').val($b.data('tb'));
    $('#skh-td').val($b.data('td'));
    $('#skh-suhu').val($b.data('suhu'));
    $('#skh-goldar').val($b.data('goldar'));
    $('#skh-butawarna').val('');
    $('#skh-dokter').val($b.data('dokter'));
    $('#skh-tglperiksa').val($b.data('tglperiksa'));
    $('#skh-hasil-sehat').prop('checked', true);
    $('#skh-hasil-detail').val('');
    $('#skh-keterangan').val('');
    $('#skh-normal').prop('checked', true);
    $('#skh-noSurat').val('AUTO');
    currentSkhLetterId = null;
    $('#btn-cetak-skh').prop('disabled', true);
 
    $.ajax({
        url: GET_SKH_URL,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res && res.success && res.data) {
                var d = res.data;
                currentSkhLetterId = d.letter_id;
                $('#skh-noSurat').val(d.letter_no || 'AUTO');
                if (d.weight !== null)         $('#skh-bb').val(d.weight);
                if (d.height !== null)         $('#skh-tb').val(d.height);
                if (d.blood_pressure !== null) $('#skh-td').val(d.blood_pressure);
                if (d.temperature !== null)    $('#skh-suhu').val(d.temperature);
                if (d.color_blind !== null)    $('#skh-butawarna').val(d.color_blind);
                if (d.blood_type !== null)     $('#skh-goldar').val(d.blood_type);
                if (d.result === 'TIDAK SEHAT') {
                    $('#skh-hasil-tidak-sehat').prop('checked', true);
                } else {
                    $('#skh-hasil-sehat').prop('checked', true);
                }
                if (d.result_detail !== null)   $('#skh-hasil-detail').val(d.result_detail);
                if (d.statement_notes !== null) $('#skh-keterangan').val(d.statement_notes);
                $('#skh-normal').prop('checked', !!d.is_normal);
                $('#btn-cetak-skh').prop('disabled', false);
            }
        }
    });
 
    $('#modal-surat-sehat').modal('show');
});
 
$('#btn-simpan-skh').on('click', function () {
    var csrf = $('input[name="_csrfToken"]').val();
    var payload = {
        _csrfToken: csrf,
        weight: $('#skh-bb').val(),
        height: $('#skh-tb').val(),
        blood_pressure: $('#skh-td').val(),
        temperature: $('#skh-suhu').val(),
        color_blind: $('#skh-butawarna').val(),
        blood_type: $('#skh-goldar').val(),
        result: $('input[name="skh_hasil"]:checked').val() === 'tidak_sehat' ? 'TIDAK SEHAT' : 'SEHAT',
        result_detail: $('#skh-hasil-detail').val(),
        statement_notes: $('#skh-keterangan').val(),
        is_normal: $('#skh-normal').is(':checked') ? 1 : 0,
        examined_at: new Date().toISOString().slice(0, 10),
    };
 
    $.ajax({
        url: SIMPAN_SKH_URL,
        method: 'POST',
        data: payload,
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#skh-noSurat').val(res.letter_no);
                currentSkhLetterId = res.letter_id;
                $('#btn-cetak-skh').prop('disabled', false);
                alert('Surat berhasil disimpan: ' + res.letter_no);
            } else {
                alert(res.message || 'Gagal menyimpan surat.');
            }
        },
        error: function () {
            alert('Gagal menghubungi server.');
        }
    });
});
 
$('#btn-cetak-skh').on('click', function () {
    if (!currentSkhLetterId) return;
    window.open(CETAK_SKH_URL_BASE + '/' + currentSkhLetterId, '_blank');
});

var GET_KSL_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getSuratKonsultasi',
    $visit->id,
])) ?>;
var SIMPAN_KSL_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanSuratKonsultasi',
    $visit->id,
])) ?>;
var KSL_ICD_SEARCH_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientVisits',
    'action'     => 'searchIcd10',
])) ?>;
var GET_JKL_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getSuratJawabanKonsultasi',
    $visit->id,
])) ?>;
var SIMPAN_JKL_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanSuratJawabanKonsultasi',
    $visit->id,
])) ?>;
var CETAK_KSL_URL_BASE = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'cetakSuratKonsultasi',
])) ?>;
var currentKslLetterId = null;

function getIcd10SemuaText() {
    var lines = [];
    $('#icd10-body tr.icd10-row').each(function () {
        var $row  = $(this);
        var kode  = $.trim($row.find('input[name^="icd10_code"]').val());
        var nama  = $.trim($row.find('input[name^="icd10_nama"]').val());
        if (!kode && !nama) return; // skip baris kosong

        var isUtama = $row.find('input[name="icd10_utama"]').is(':checked');
        var line = (kode ? kode + ' - ' : '') + nama;
        if (isUtama) line += ' (Utama)';
        lines.push(line);
    });
    return lines.join('\n');
}

function setKonsultasiReadonlyState(konsultasiLocked, jawabanLocked) {
    $('#ksl-catatan')
        .prop('readonly', konsultasiLocked)
        .css({
            background: konsultasiLocked ? '#f5f5f5' : '',
            cursor: konsultasiLocked ? 'default' : ''
        });
    $('#btn-simpan-ksl').prop('disabled', konsultasiLocked);
    $('#ksl-catatan-status')
        .text(konsultasiLocked ? 'Keterangan sudah disimpan dan terkunci' : 'Belum disimpan')
        .toggleClass('text-success', konsultasiLocked)
        .toggleClass('text-muted', !konsultasiLocked);

    $('#ksl-jawaban')
        .prop('readonly', !konsultasiLocked || jawabanLocked)
        .css({
            background: (!konsultasiLocked || jawabanLocked) ? '#f5f5f5' : '',
            cursor: (!konsultasiLocked || jawabanLocked) ? 'default' : ''
        });
    $('#btn-simpan-jkl').prop('disabled', !konsultasiLocked || jawabanLocked);
    $('#btn-cetak-ksl').prop('disabled', !konsultasiLocked);
    $('#ksl-jawaban-status')
        .text(!konsultasiLocked ? 'Isi setelah keterangan konsultasi disimpan' : (jawabanLocked ? 'Jawaban sudah disimpan dan terkunci' : 'Siap diisi'))
        .toggleClass('text-success', konsultasiLocked && jawabanLocked)
        .toggleClass('text-muted', !konsultasiLocked || !jawabanLocked);
}

$(document).on('click', '.btn-surat-konsultasi', function () {
    var $b = $(this);

    $('#ksl-rekmed').val($b.data('rekmed'));
    $('#ksl-nama').val($b.data('nama'));
    $('#ksl-alamat').val($b.data('alamat'));
    $('#ksl-umur').val($b.data('umur'));
    $('#ksl-dokter').val($b.data('dokter'));
    $('#ksl-tglperiksa').val($b.data('tglperiksa'));
    $('#ksl-diagnosa').val(getIcd10SemuaText());
    $('#ksl-catatan').val('');
    $('#ksl-jawaban').val('');
    $('#ksl-noSurat').val('AUTO');
    currentKslLetterId = null;
    setKonsultasiReadonlyState(false, false);

    $.ajax({
        url: GET_KSL_URL,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res && res.success && res.data) {
                var d = res.data;
                $('#ksl-noSurat').val(d.letter_no || 'AUTO');
                currentKslLetterId = d.letter_id || null;
                if (d.notes !== null) $('#ksl-catatan').val(d.notes);
                if (d.consultation_answer !== null) $('#ksl-jawaban').val(d.consultation_answer);
                setKonsultasiReadonlyState(!!d.is_consultation_locked, !!d.is_answer_locked);
                // Diagnosa sengaja tidak ditimpa dari data tersimpan —
                // selalu ikut ICD-10 EMR terbaru saat modal dibuka.
            }
        }
    });

    $('#modal-surat-konsultasi').modal('show');
});

$('#btn-simpan-ksl').on('click', function () {
    var csrf = $('input[name="_csrfToken"]').val();

    $.ajax({
        url: SIMPAN_KSL_URL,
        method: 'POST',
        data: {
            _csrfToken: csrf,
            diagnosis: $('#ksl-diagnosa').val(),
            notes: $('#ksl-catatan').val(),
        },
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#ksl-noSurat').val(res.letter_no);
                currentKslLetterId = res.letter_id || currentKslLetterId;
                setKonsultasiReadonlyState(!!res.is_consultation_locked, !!res.is_answer_locked);
                alert('Keterangan konsultasi berhasil disimpan: ' + res.letter_no);
            } else {
                alert(res.message || 'Gagal menyimpan surat konsultasi.');
            }
        },
        error: function () {
            alert('Gagal menghubungi server.');
        }
    });
});

$(document).on('click', '.btn-surat-jawaban-konsultasi-legacy-disabled', function () {
    var $b = $(this);

    $('#jkl-rekmed').val($b.data('rekmed'));
    $('#jkl-nama').val($b.data('nama'));
    $('#jkl-alamat').val($b.data('alamat'));
    $('#jkl-umur').val($b.data('umur'));
    $('#jkl-dokter').val($b.data('dokter'));
    $('#jkl-tglperiksa').val($b.data('tglperiksa'));
    $('#jkl-diagnosa').val(getIcd10SemuaText());
    $('#jkl-saran').val('');
    $('#jkl-noSurat').val('AUTO');

    $.ajax({
        url: GET_JKL_URL,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res && res.success && res.data) {
                var d = res.data;
                $('#jkl-noSurat').val(d.letter_no || 'AUTO');
                if (d.saran !== null) $('#jkl-saran').val(d.saran);
                // Diagnosa sengaja tidak ditimpa — selalu ikut ICD-10 EMR terbaru
            }
        }
    });

    $('#modal-surat-jawaban-konsultasi').modal('show');
});

$('#btn-simpan-jkl').on('click', function () {
    var csrf = $('input[name="_csrfToken"]').val();
    $.ajax({
        url: SIMPAN_JKL_URL,
        method: 'POST',
        data: {
            _csrfToken: csrf,
            diagnosis: $('#ksl-diagnosa').val(),
            saran: $('#ksl-jawaban').val(),
        },
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#ksl-noSurat').val(res.letter_no);
                currentKslLetterId = res.letter_id || currentKslLetterId;
                setKonsultasiReadonlyState(!!res.is_consultation_locked, !!res.is_answer_locked);
                alert('Jawaban konsultasi berhasil disimpan: ' + res.letter_no);
            } else {
                alert(res.message || 'Gagal menyimpan surat.');
            }
        },
        error: function () {
            alert('Gagal menghubungi server.');
        }
    });
});

$('#btn-cetak-ksl').on('click', function () {
    if (!currentKslLetterId) return;
    window.open(CETAK_KSL_URL_BASE + '/' + currentKslLetterId, '_blank');
});
var GET_SKDP_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getSuratSkdp',
    $visit->id,
])) ?>;
var SIMPAN_SKDP_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanSuratSkdp',
    $visit->id,
])) ?>;
var CETAK_SKDP_URL_BASE = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'cetakSuratSkdp',
])) ?>;
var currentSkdpLetterId = null;

var GET_SKB_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getSuratKontrolBpjs',
    $visit->id,
])) ?>;
var SIMPAN_SKB_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanSuratKontrolBpjs',
    $visit->id,
])) ?>;
var CETAK_SKB_URL_BASE = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'cetakSuratKontrolBpjs',
])) ?>;
var currentSkbLetterId = null;

function getIcd10UtamaOnlyText() {
    var text = '';
    $('#icd10-body tr.icd10-row').each(function () {
        var $row = $(this);
        if (!$row.find('input[name="icd10_utama"]').is(':checked')) return;
        var kode = $.trim($row.find('input[name^="icd10_code"]').val());
        var nama = $.trim($row.find('input[name^="icd10_nama"]').val());
        if (kode || nama) {
            text = (kode ? kode + ' - ' : '') + nama;
        }
    });
    return text;
}

function skbLoadDoctorOptions(selectedId) {
    var $s = $('#skb-dokter-tujuan');
    $s.html('<option value="">-- Pilih Dokter --</option>');
    $.ajax({
        url: DOCTORS_LIST_URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (!data || !data.length) return;
            $.each(data, function (_, item) {
                var name = item.doctor_name || item.name || '';
                var id = item.id || '';
                var specialist = item.specialist || '';
                if (!id) return;
                var label = name + (specialist ? ' (' + specialist + ')' : '');
                $s.append(
                    '<option value="' + id + '" data-nama="' + htmlEscape(name) + '" data-spesialis="' + htmlEscape(specialist) + '">' +
                    htmlEscape(label) + '</option>'
                );
            });
            if (selectedId) $s.val(selectedId);
        },
        error: function () {
            $s.append('<option value="">-- Gagal memuat dokter --</option>');
        }
    });
}

$(document).on('click', '.btn-surat-kontrol-bpjs', function () {
    var $b = $(this);
    $('#skb-rekmed').val($b.data('rekmed'));
    $('#skb-nama').val($b.data('nama'));
    $('#skb-jk').val($b.data('jk'));
    $('#skb-tgl-lahir').val($b.data('tgllahir'));
    $('#skb-dokter').val($b.data('dokter'));
    $('#skb-tglperiksa').val($b.data('tglperiksa'));
    $('#skb-diagnosa').val(getIcd10UtamaOnlyText());
    $('#skb-no-kartu').val($b.data('bpjs') || '');
    $('#skb-noSurat').val('AUTO');
    $('#skb-tgl-kontrol').val('');
    $('#skb-catatan').val('');
    currentSkbLetterId = null;
    $('#btn-cetak-skb').prop('disabled', true);

    skbLoadDoctorOptions();

    $.ajax({
        url: GET_SKB_URL,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res && res.success && res.data) {
                var d = res.data;
                currentSkbLetterId = d.letter_id;
                $('#skb-noSurat').val(d.letter_no || 'AUTO');
                if (d.control_date)  $('#skb-tgl-kontrol').val(d.control_date);
                if (d.notes)         $('#skb-catatan').val(d.notes);
                if (d.bpjs_card_no)  $('#skb-no-kartu').val(d.bpjs_card_no);
                if (d.diagnosis)     $('#skb-diagnosa').val(d.diagnosis);
                if (d.referral_doctor_id) {
                    setTimeout(function () { $('#skb-dokter-tujuan').val(d.referral_doctor_id); }, 400);
                }
                $('#btn-cetak-skb').prop('disabled', false);
            }
        }
    });

    $('#modal-surat-kontrol-bpjs').modal('show');
});

$('#btn-simpan-skb').on('click', function () {
    var csrf = $('input[name="_csrfToken"]').val();
    var $opt  = $('#skb-dokter-tujuan option:selected');

    $.ajax({
        url: SIMPAN_SKB_URL,
        method: 'POST',
        data: {
            _csrfToken: csrf,
            control_date: $('#skb-tgl-kontrol').val(),
            notes: $('#skb-catatan').val(),
            bpjs_card_no: $('#skb-no-kartu').val(),
            diagnosis: $('#skb-diagnosa').val(),
            referral_doctor_id: $('#skb-dokter-tujuan').val(),
            referral_doctor_name: $opt.data('nama') || '',
            referral_doctor_specialist: $opt.data('spesialis') || '',
            examined_at: new Date().toISOString().slice(0, 10),
        },
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#skb-noSurat').val(res.letter_no);
                currentSkbLetterId = res.letter_id;
                $('#btn-cetak-skb').prop('disabled', false);
                alert('Surat Kontrol BPJS berhasil disimpan: ' + res.letter_no);
            } else {
                alert(res.message || 'Gagal menyimpan surat.');
            }
        },
        error: function () { alert('Gagal menghubungi server.'); }
    });
});

$('#btn-cetak-skb').on('click', function () {
    if (!currentSkbLetterId) return;
    window.open(CETAK_SKB_URL_BASE + '/' + currentSkbLetterId, '_blank');
});

function skdpGetIcd10UtamaText() {
    var text = '';
    $('#icd10-body tr.icd10-row').each(function () {
        var $row = $(this);
        if (!$row.find('input[name="icd10_utama"]').is(':checked')) return;
        var kode = $.trim($row.find('input[name^="icd10_code"]').val());
        var nama = $.trim($row.find('input[name^="icd10_nama"]').val());
        if (kode || nama) {
            text = (kode ? kode + ' - ' : '') + nama;
        }
    });
    return text;
}

$(document).on('click', '.btn-surat-skdp', function () {
    var $b = $(this);
    $('#skdp-rekmed').val($b.data('rekmed'));
    $('#skdp-nama').val($b.data('nama'));
    $('#skdp-dokter').val($b.data('dokter'));
    $('#skdp-tglperiksa').val($b.data('tglperiksa'));
    $('#skdp-diagnosa').val(skdpGetIcd10UtamaText());
    $('#skdp-terapi').val(<?= json_encode($emr->prescription_notes ?? '') ?>);
    $('#skdp-noSurat').val('AUTO');
    $('#skdp-tgl-rujukan').val('');
    $('#skdp-no-kartu').val($b.data('bpjs') || '');
    $('#skdp-no-rujukan').val('');
    $('#skdp-alasan').val('');
    $('#skdp-rencana').val('');
    $('#skdp-keterangan').val('');
    $('#skdp-tgl-kontrol').val('');
    currentSkdpLetterId = null;
    $('#btn-cetak-skdp').prop('disabled', true);
    $.ajax({
        url: GET_SKDP_URL,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res && res.success && res.data) {
                var d = res.data;
                currentSkdpLetterId = d.letter_id;
                $('#skdp-noSurat').val(d.letter_no || 'AUTO');
                if (d.therapy)          $('#skdp-terapi').val(d.therapy);
                if (d.referral_date)    $('#skdp-tgl-rujukan').val(d.referral_date);
                if (d.bpjs_card_no)     $('#skdp-no-kartu').val(d.bpjs_card_no);
                if (d.referral_no)      $('#skdp-no-rujukan').val(d.referral_no);
                if (d.reason)           $('#skdp-alasan').val(d.reason);
                if (d.control_plan)     $('#skdp-rencana').val(d.control_plan);
                if (d.control_notes)    $('#skdp-keterangan').val(d.control_notes);
                if (d.control_date)     $('#skdp-tgl-kontrol').val(d.control_date);
                $('#btn-cetak-skdp').prop('disabled', false);
            }
        }
    });
    $('#modal-surat-skdp').modal('show');
});
$('#btn-simpan-skdp').on('click', function () {
    var csrf = $('input[name="_csrfToken"]').val();
    $.ajax({
        url: SIMPAN_SKDP_URL,
        method: 'POST',
        data: {
            _csrfToken: csrf,
            diagnosis: $('#skdp-diagnosa').val(),
            therapy: $('#skdp-terapi').val(),
            referral_date: $('#skdp-tgl-rujukan').val(),
            bpjs_card_no: $('#skdp-no-kartu').val(),
            referral_no: $('#skdp-no-rujukan').val(),
            reason: $('#skdp-alasan').val(),
            control_plan: $('#skdp-rencana').val(),
            control_notes: $('#skdp-keterangan').val(),
            control_date: $('#skdp-tgl-kontrol').val(),
        },
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#skdp-noSurat').val(res.letter_no);
                currentSkdpLetterId = res.letter_id;
                $('#btn-cetak-skdp').prop('disabled', false);
                alert('SKDP berhasil disimpan: ' + res.letter_no);
            } else {
                alert(res.message || 'Gagal menyimpan SKDP.');
            }
        },
        error: function () { alert('Gagal menghubungi server.'); }
    });
});
$('#btn-cetak-skdp').on('click', function () {
    if (!currentSkdpLetterId) return;
    window.open(CETAK_SKDP_URL_BASE + '/' + currentSkdpLetterId, '_blank');
});

var GET_SPT_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getProtokolTerapi',
    $visit->id,
])) ?>;
var SIMPAN_SPT_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanProtokolTerapi',
    $visit->id,
])) ?>;
var CETAK_SPT_URL_BASE = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'cetakProtokolTerapi',
])) ?>;

var currentSptLetterId = null;

$(document).on('click', '.btn-protokol-terapi', function () {
    var $b = $(this);

    $('#spt-rekmed').val($b.data('rekmed'));
    $('#spt-nama').val($b.data('nama'));
    $('#spt-alamat').val($b.data('alamat'));
    $('#spt-umur').val($b.data('umur'));
    $('#spt-jk').val($b.data('jk'));
    $('#spt-bb').val($b.data('bb'));
    $('#spt-tb').val($b.data('tb'));
    $('#spt-td').val($b.data('td'));
    $('#spt-suhu').val($b.data('suhu'));
    $('#spt-diagnosa').val($b.data('diagnosa'));
    $('#spt-obat').val($b.data('obat'));
    $('#spt-dokter').val($b.data('dokter'));
    $('#spt-tglperiksa').val($b.data('tglperiksa'));
    $('#spt-lama').val(0);
    $('#spt-alasan').val('');
    $('#spt-normal').prop('checked', true);
    $('#spt-noSurat').val('AUTO');
    currentSptLetterId = null;
    $('#btn-cetak-spt').prop('disabled', true);

    $.ajax({
        url: GET_SPT_URL,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res && res.success && res.data) {
                var d = res.data;
                currentSptLetterId = d.letter_id;
                $('#spt-noSurat').val(d.letter_no || 'AUTO');
                if (d.weight !== null)         $('#spt-bb').val(d.weight);
                if (d.height !== null)         $('#spt-tb').val(d.height);
                if (d.blood_pressure !== null) $('#spt-td').val(d.blood_pressure);
                if (d.temperature !== null)    $('#spt-suhu').val(d.temperature);
                if (d.diagnosis !== null && d.diagnosis !== '') $('#spt-diagnosa').val(d.diagnosis);
                if (d.drug_dosage !== null)    $('#spt-obat').val(d.drug_dosage);
                if (d.therapy_days !== null)   $('#spt-lama').val(d.therapy_days);
                if (d.therapy_reason !== null) $('#spt-alasan').val(d.therapy_reason);
                $('#spt-normal').prop('checked', !!d.is_normal);
                $('#btn-cetak-spt').prop('disabled', false);
            }
        }
    });

    $('#modal-protokol-terapi').modal('show');
});

$('#btn-simpan-spt').on('click', function () {
    var csrf = $('input[name="_csrfToken"]').val();
    var payload = {
        _csrfToken: csrf,
        weight: $('#spt-bb').val(),
        height: $('#spt-tb').val(),
        blood_pressure: $('#spt-td').val(),
        temperature: $('#spt-suhu').val(),
        diagnosis: $('#spt-diagnosa').val(),
        drug_dosage: $('#spt-obat').val(),
        therapy_days: $('#spt-lama').val(),
        therapy_reason: $('#spt-alasan').val(),
        is_normal: $('#spt-normal').is(':checked') ? 1 : 0,
        examined_at: new Date().toISOString().slice(0, 10),
    };

    $.ajax({
        url: SIMPAN_SPT_URL,
        method: 'POST',
        data: payload,
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#spt-noSurat').val(res.letter_no);
                currentSptLetterId = res.letter_id;
                $('#btn-cetak-spt').prop('disabled', false);
                alert('Protokol terapi berhasil disimpan: ' + res.letter_no);
            } else {
                alert(res.message || 'Gagal menyimpan protokol terapi.');
            }
        },
        error: function () {
            alert('Gagal menghubungi server.');
        }
    });
});

$('#btn-cetak-spt').on('click', function () {
    if (!currentSptLetterId) return;
    window.open(CETAK_SPT_URL_BASE + '/' + currentSptLetterId, '_blank');
});

    // ══════════════════════════════════════════════════════════════════════════
    // KONFIGURASI URL
    // ══════════════════════════════════════════════════════════════════════════
    var SEARCH_URL = <?= json_encode($this->Url->build([
        'controller' => 'MasterTindakan',
        'action'     => 'search',
    ])) ?>;

    var DEBUG_URL = <?= json_encode($this->Url->build([
        'controller' => 'MasterTindakan',
        'action'     => 'searchDebug',
    ])) ?>;

    var ICD9_SEARCH_URL = <?= json_encode($this->Url->build([
        'controller' => 'MasterIcd9',
        'action'     => 'search',
    ])) ?>;

    var ICD10_SEARCH_URL = <?= json_encode($this->Url->build([
        'controller' => 'MasterIcd10',
        'action'     => 'search',
    ])) ?>;

    var POLYCLINIC_SEARCH_URL = <?= json_encode($this->Url->build([
        'controller' => 'PolyclinicQueues',
        'action'     => 'searchPolyQueue',
    ])) ?>;

    var CURRENT_POLY_NAME = <?= json_encode($visit->polyclinic_name ?? '') ?>;

    var CREATE_REFERRAL_QUEUE_URL = <?= json_encode($this->Url->build([
        'controller' => 'PolyclinicQueues',
        'action'     => 'createReferralQueue',
    ])) ?>;

    var DOCTOR_BY_POLY_URL = <?= json_encode($this->Url->build([
        'controller' => 'Doctors',
        'action'     => 'searchByPolyclinic',
    ])) ?>;

    // ══════════════════════════════════════════════════════════════════════════
    // HELPER
    // ══════════════════════════════════════════════════════════════════════════
    function escHtml(str) { return $('<div>').text(String(str || '')).html(); }
    function setDebug(msg) { $('#debug-text').text(msg); }


    // ── Popup Hasil Pemeriksaan EMR ─────────────────────────────────────────
    $(document).on('click', '.btn-hasil-pemeriksaan-emr', function (e) {
        e.preventDefault();

        var $btn = $(this);

        $('#emr-hp-noreg').val($btn.data('noreg') || '-');
        $('#emr-hp-rekmed').val($btn.data('rekmed') || '-');
        $('#emr-hp-nama').val($btn.data('nama') || '-');
        $('#emr-hp-dokter').text($btn.data('dokter') || '-');
        $('#emr-hp-tanggal').text($btn.data('tanggal') || '-');
        $('#emr-hp-no-pemeriksaan').text($btn.data('noreg') || '-');
        $('#emr-hp-hasil').text($btn.data('hasil') || '-');

        $('#modal-hasil-pemeriksaan-emr').modal('show');
    });

    var polyclinicTimer = null;
    var $polyInput = $('#referral-polyclinic-search');
    var $polyValue = $('#referral-polyclinic-value');
    var $polyQueue = $('#referral-queue-no');
    var $polyDropdown = $('#polyclinic-dropdown');

    function closePolyclinicDropdown() {
        $polyDropdown.hide().empty();
    }

    function renderPolyclinicDropdown(data) {
        $polyDropdown.empty();

        // Buang poliklinik yang sama dengan poli pasien saat ini
        if (data && Array.isArray(data) && CURRENT_POLY_NAME) {
            data = data.filter(function (item) {
                var nama = item.poly_name || item.name || item.nama || item.polyclinic_name || '';
                return $.trim(nama).toLowerCase() !== $.trim(CURRENT_POLY_NAME).toLowerCase();
            });
        }

        if (!data || !Array.isArray(data) || data.length === 0) {
            $polyDropdown.html(
                '<div class="poly-dd-empty">' +
                '<i class="fa fa-search"></i> Poliklinik tidak ditemukan' +
                '</div>'
            ).show();
            return;
        }

        $.each(data, function (_, item) {
            var nama = item.poly_name || item.name || item.nama || item.polyclinic_name || '';
            var nextQueue = item.next_queue_number || item.next_queue_no || item.queue_number || item.queue_no || 0;
            var label = nama;
            var meta = nextQueue ? 'No antrian berikutnya: ' + nextQueue : 'No antrian akan dibuat otomatis';

            var $item = $(
                '<div class="poly-dd-item" ' +
                    'data-name="' + escHtml(nama) + '" ' +
                    'data-queue="' + escHtml(nextQueue) + '">' +
                    '<div class="poly-dd-name">' + escHtml(label) + '</div>' +
                    '<div style="font-size:10px;color:#777;margin-top:2px;">' + escHtml(meta) + '</div>' +
                '</div>'
            );

            $item.on('mousedown', function (e) {
                e.preventDefault();
                $polyInput.val(nama);
                $polyValue.val(nama);
                $polyQueue.val(nextQueue || 0);

                $('#referral-doctor-search').val('');
                $('#referral-doctor-value').val('');
                $('#doctor-dropdown').hide().empty();

                closePolyclinicDropdown();
            });

            $polyDropdown.append($item);
        });

        $polyDropdown.show();
    }

    function searchPolyclinic(q) {
        $polyDropdown.html(
            '<div class="poly-dd-loading"><i class="fa fa-spinner fa-spin"></i> Mencari poliklinik...</div>'
        ).show();

        $.ajax({
            url: POLYCLINIC_SEARCH_URL,
            method: 'GET',
            data: { q: q, exclude_poly: CURRENT_POLY_NAME },
            dataType: 'json',
            timeout: 5000,
            success: function (data) {
                renderPolyclinicDropdown(data);
            },
            error: function () {
                $polyDropdown.html(
                    '<div class="poly-dd-empty">Endpoint PolyclinicQueues/searchPolyQueue belum tersedia.</div>'
                ).show();
            }
        });
    }

    $polyInput.on('input', function () {
        var q = $.trim($(this).val());
        $polyValue.val(q);
        $polyQueue.val(0);
        $('#referral-doctor-search').val('');
        $('#referral-doctor-value').val('');
        clearTimeout(polyclinicTimer);

        polyclinicTimer = setTimeout(function () {
            searchPolyclinic(q);
        }, 250);
    });

    $polyInput.on('focus click', function () {
        if (!$polyDropdown.is(':visible')) {
            searchPolyclinic($.trim($(this).val()));
        }
    });

    $polyInput.on('blur', function () {
        setTimeout(closePolyclinicDropdown, 150);
    });

    $(document).on('mousedown', function (e) {
        if (!$(e.target).closest('#referral-polyclinic-search, #polyclinic-dropdown').length) {
            closePolyclinicDropdown();
        }
    });

    // ══════════════════════════════════════════════════════════════════════════
    // AJAX DOKTER BERDASARKAN POLIKLINIK
    // Data dokter diambil dari tabel doctors berdasarkan doctors.polyclinic_name.
    // Endpoint yang dipakai: /doctors/search-by-polyclinic?poly_name=...
    // ══════════════════════════════════════════════════════════════════════════
    var doctorTimer = null;
    var $doctorInput = $('#referral-doctor-search');
    var $doctorValue = $('#referral-doctor-value');
    var $doctorDropdown = $('#doctor-dropdown');

    function closeDoctorDropdown() {
        $doctorDropdown.hide().empty();
    }

    function renderDoctorDropdown(data) {
        $doctorDropdown.empty();

        if (!data || !Array.isArray(data) || data.length === 0) {
            $doctorDropdown.html(
                '<div class="doctor-dd-empty">' +
                '<i class="fa fa-user-md"></i> Dokter tidak ditemukan untuk poli ini' +
                '</div>'
            ).show();
            return;
        }

        $.each(data, function (_, item) {
            var doctorName = item.doctor_name || item.name || '';
            var specialist = item.specialist || '';
            var polyName = item.polyclinic_name || '';

            var $item = $(
                '<div class="doctor-dd-item" data-name="' + escHtml(doctorName) + '">' +
                    '<div class="doctor-dd-name">' + escHtml(doctorName) + '</div>' +
                    '<div style="font-size:10px;color:#777;margin-top:2px;">' +
                        escHtml((specialist ? specialist : 'Dokter') + (polyName ? ' · ' + polyName : '')) +
                    '</div>' +
                '</div>'
            );

            $item.on('mousedown', function (e) {
                e.preventDefault();
                $doctorInput.val(doctorName);
                $doctorValue.val(doctorName);
                closeDoctorDropdown();
            });

            $doctorDropdown.append($item);
        });

        $doctorDropdown.show();
    }

    function searchDoctorByPolyclinic() {
        var polyName = $.trim($polyValue.val() || $polyInput.val());
        var q = $.trim($doctorInput.val());

        if (!polyName) {
            $doctorDropdown.html(
                '<div class="doctor-dd-empty">Pilih poliklinik terlebih dahulu</div>'
            ).show();
            return;
        }

        $doctorDropdown.html(
            '<div class="doctor-dd-loading"><i class="fa fa-spinner fa-spin"></i> Mencari dokter...</div>'
        ).show();

$.ajax({
        url: DOCTORS_LIST_URL,
        method: 'GET',
        data: { poly_name: '', q: '' },
        dataType: 'json',
        success: function (data) {
                renderDoctorDropdown(data);
            },
            error: function () {
                $doctorDropdown.html(
                    '<div class="doctor-dd-empty">Endpoint Doctors/searchByPolyclinic belum tersedia.</div>'
                ).show();
            }
        });
    }

    $doctorInput.on('focus input', function () {
        clearTimeout(doctorTimer);
        doctorTimer = setTimeout(searchDoctorByPolyclinic, 200);
    });

    $doctorInput.on('blur', function () {
        setTimeout(closeDoctorDropdown, 150);
    });

    $(document).on('mousedown', function (e) {
        if (!$(e.target).closest('#referral-doctor-search, #doctor-dropdown').length) {
            closeDoctorDropdown();
        }
    });

    var POLYCLINIC_QUEUES_INDEX_URL = <?= json_encode($this->Url->build([
        'controller' => 'PolyclinicQueues',
        'action'     => 'index',
    ])) ?>;

    var SELESAI_PERIKSA_URL = <?= json_encode($this->Url->build([
        'controller' => 'OutpatientVisits',
        'action'     => 'selesaiPeriksa',
        $visit->id,
    ])) ?>;

    $('#btn-konsul-langsung').on('click', function () {
        var $btn = $(this);
        var polyName = $.trim($('#referral-polyclinic-value').val() || $('#referral-polyclinic-search').val());
        var doctorName = $.trim($('#referral-doctor-value').val() || $('#referral-doctor-search').val());
        var patientName = <?= json_encode($p->full_name ?? '') ?>;
        var phoneNumber = <?= json_encode($p->phone_number ?? '') ?>;
        var visitDate = $('input[name="referral_date"]').val() || <?= json_encode(date('Y-m-d')) ?>;
        var csrfToken = $('input[name="_csrfToken"]').val() || $('meta[name="csrfToken"]').attr('content') || '';

        if (!polyName) {
            alert('Pilih poliklinik tujuan dulu.');
            $('#referral-polyclinic-search').focus();
            return;
        }

        if (!doctorName) {
            alert('Pilih dokter tujuan dulu.');
            $('#referral-doctor-search').focus();
            return;
        }

        if (!confirm('Konsulkan pasien langsung ke ' + polyName + ' (' + doctorName + ')? Kunjungan di poli saat ini akan otomatis ditandai selesai.')) {
            return;
        }

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');

        // Langkah 1: buat antrian konsul di poli tujuan
        $.ajax({
            url: CREATE_REFERRAL_QUEUE_URL,
            method: 'POST',
            dataType: 'json',
            headers: csrfToken ? { 'X-CSRF-Token': csrfToken } : {},
            data: {
                poly_name: polyName,
                doctor_name: doctorName,
                patient_name: patientName,
                phone_number: phoneNumber,
                visit_date: visitDate
            },
            success: function (res) {
                if (!res || !res.success) {
                    alert((res && res.message) ? res.message : 'Gagal membuat antrian konsul.');
                    $btn.prop('disabled', false).html('Konsulkan Langsung');
                    return;
                }

                var queueCode = res.code || '-';

                // Langkah 2: tandai kunjungan poli saat ini sebagai selesai
                $.ajax({
                    url: SELESAI_PERIKSA_URL,
                    method: 'POST',
                    dataType: 'json',
                    headers: csrfToken ? { 'X-CSRF-Token': csrfToken } : {},
                    data: { _csrfToken: csrfToken },
                    complete: function () {
                        // Baik berhasil maupun tidak, tetap arahkan ke daftar antrian
                        // supaya pengguna tidak terjebak; jika gagal, EMR masih bisa
                        // diselesaikan manual lewat tombol SELESAI PERIKSA.
                        alert('Antrian konsul berhasil dibuat: ' + queueCode + '. Kunjungan poli saat ini ditandai selesai.');
                        window.location.href = POLYCLINIC_QUEUES_INDEX_URL;
                    }
                });
            },
            error: function (xhr) {
                var message = 'Gagal menghubungi server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                alert(message);
                $btn.prop('disabled', false).html('Konsulkan Langsung');
            }
        });
    });

    // ══════════════════════════════════════════════════════════════════════════
    // BMI OTOMATIS
    // ══════════════════════════════════════════════════════════════════════════
    function calcBMI() {
        var w = parseFloat($('#weight').val());
        var h = parseFloat($('#height').val());
        if (w > 0 && h > 0) {
            var hm  = h / 100;
            var bmi = (w / (hm * hm)).toFixed(2);
            $('#bmi-display').val(bmi);
            var cat = bmi < 18.5 ? 'Underweight'
                    : bmi < 25.0 ? 'NormalWeight'
                    : bmi < 30.0 ? 'Overweight'
                    : 'Obese';
            $('#bmi-result').val(cat);
            updateVitalSummary();
        } else {
            $('#bmi-display').val('');
            $('#bmi-result').val('');
        }
    }

    function updateVitalSummary() {
        var parts  = [];
        var bp     = $('input[name="blood_pressure"]').val();
        var bmiRes = $('#bmi-result').val();
        var temp   = $('input[name="temperature"]').val();
        if (bp) {
            var sys = parseInt(bp.split('/')[0]) || 0;
            parts.push(sys < 90 ? 'Tensi: Hipotensi' : sys > 140 ? 'Tensi: Hipertensi' : 'Tensi: Normal');
        }
        if (bmiRes) parts.push('Gizi: ' + bmiRes);
        if (temp) {
            var t = parseFloat(temp);
            parts.push(t >= 37.5 ? 'Suhu: Demam' : t < 36 ? 'Suhu: Hipotermia' : 'Suhu: Normal');
        }
        if (parts.length > 0) {
            $('#vital-summary-text').text(parts.join(' · '));
            $('#vital-summary').show();
        } else {
            $('#vital-summary').hide();
        }
    }

    $('#weight, #height').on('input', calcBMI);
    $('input[name="blood_pressure"], input[name="temperature"]').on('input', updateVitalSummary);
    calcBMI();
    updateVitalSummary();

$('#weight, #height').on('input', calcBMI);
    $('input[name="blood_pressure"], input[name="temperature"]').on('input', updateVitalSummary);
    calcBMI();
    updateVitalSummary();

    // ══════════════════════════════════════════════════════════════════════════
    // HITUNG TOTAL TINDAKAN
    // ══════════════════════════════════════════════════════════════════════════
    function calcGrandTotal() {
        var grand = 0;
        $('.action-row').each(function () {
            var qty   = parseFloat($(this).find('.action-qty').val())        || 0;
            var price = parseFloat($(this).find('.action-unit-price').val()) || 0;
            var total = qty * price;
            grand += total;
            $(this).find('.action-total').val(
                total > 0 ? Math.round(total).toLocaleString('id-ID') : '0'
            );
        });
        $('#total-fee').val(Math.round(grand));
    }

    $(document).on('input', '.action-qty', calcGrandTotal);

    var actionIndex = <?= !empty($visit->outpatient_actions) ? count($visit->outpatient_actions) : 0 ?>;

var ptSelected  = {}; 
var ptAllData   = []; 
var ptSearchTimer = null;

function ptRenderList(data) {
    var $body = $('#pt-list-body');
    $body.empty();

    data = (data || []).map(function (item) {
        return {
            kode: item.kode ?? item.code ?? '',
            nama: item.nama ?? item.name ?? '',
            kategori: item.kategori ?? item.category ?? '',
            harga: item.harga ?? item.price ?? item.tarif ?? 0
        };
    });

    if (!data.length) {
        $body.html('<tr><td colspan="5" style="text-align:center;color:#aaa;padding:14px;">Tindakan tidak ditemukan</td></tr>');
        return;
    }

    var existingCodes = ptGetExistingCodes();

    $.each(data, function (_, item) {
        var key         = item.kode + '||' + item.nama;
        var isPicked    = !!ptSelected[key];
        var alreadyAdded = !!existingCodes[key];
        var checked     = isPicked ? 'checked' : '';
        var harga       = parseFloat(item.harga) || 0;

        var rowClass = 'pt-row';
        var rowStyle = 'cursor:pointer;';
        var extraNote = '';

        if (alreadyAdded) {
            rowClass += ' pt-row-disabled';
            rowStyle = 'cursor:not-allowed; opacity:0.5;';
            extraNote = ' <span style="color:#999; font-size:10px;">(sudah ditambahkan)</span>';
        } else if (isPicked) {
            rowClass += ' pt-row-selected';
        }

        var $tr = $(
            '<tr class="' + rowClass + '" data-already-added="' + (alreadyAdded ? '1' : '0') + '" style="' + rowStyle + '">' +
            '<td class="text-center"><input type="checkbox" class="pt-checkbox" style="pointer-events:none;" ' + checked + (alreadyAdded ? ' disabled' : '') + '></td>' +
            '<td>' + escHtml(item.kode || '') + '</td>' +
            '<td>' + escHtml(item.nama || '') + extraNote + '</td>' +
            '<td>' + escHtml(item.kategori || '') + '</td>' +
            '<td style="text-align:right;">' + harga.toLocaleString('id-ID') + '</td>' +
            '</tr>'
        );
        $tr.data('item', item);
        $body.append($tr);
    });
}

function ptRenderSelected() {
    var $body = $('#pt-selected-body');
    $body.empty();
    var keys = Object.keys(ptSelected);
    if (!keys.length) {
        $body.html(
            '<tr id="pt-selected-empty"><td colspan="4" style="text-align:center;color:#aaa;padding:12px;font-size:11px;">' +
            'Belum ada tindakan dipilih.</td></tr>'
        );
        return;
    }
    $.each(keys, function (_, key) {
        var item  = ptSelected[key];
        var harga = parseFloat(item.harga) || 0;
        var $tr = $(
            '<tr>' +
            '<td>' + escHtml(item.kode || '') + '</td>' +
            '<td>' + escHtml(item.nama || '') + '</td>' +
            '<td style="text-align:right;">' + harga.toLocaleString('id-ID') + '</td>' +
            '<td class="text-center"><button type="button" class="btn btn-xs btn-danger pt-remove" data-key="' + escHtml(key) + '">&times;</button></td>' +
            '</tr>'
        );
        $body.append($tr);
    });
}

function ptFilterAndRender(q) {
    q = $.trim(q || '').toLowerCase();

    if (q === '') {
        ptRenderList(ptAllData);
        return;
    }

    var scored = [];
    $.each(ptAllData, function (_, item) {
        var kode = String(item.kode || '').toLowerCase();
        var nama = String(item.nama || '').toLowerCase();

        var score = -1;
        if (kode === q || nama === q)                 score = 0;
        else if (kode.indexOf(q) === 0 || nama.indexOf(q) === 0) score = 1;
        else if (kode.indexOf(q) !== -1 || nama.indexOf(q) !== -1) score = 2;

        if (score !== -1) scored.push({ item: item, score: score });
    });

    scored.sort(function (a, b) {
        if (a.score !== b.score) return a.score - b.score;
        return String(a.item.nama || '').localeCompare(String(b.item.nama || ''));
    });

    ptRenderList($.map(scored, function (s) { return s.item; }));
}

function ptGetExistingCodes() {
    var codes = {};
    $('#actions-body tr.action-row').each(function () {
        var kode = $.trim($(this).find('input[name$="[action_code]"]').val());
        var nama = $.trim($(this).find('input[name$="[action_name]"]').val());
        if (kode || nama) {
            codes[kode + '||' + nama] = true;
        }
    });
    return codes;
}

function ptLoadAll() {
    $('#pt-list-body').html(
        '<tr><td colspan="5" style="text-align:center;color:#999;padding:14px;"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>'
    );
    $.ajax({
        url: SEARCH_URL, method: 'GET', data: { q: '' },
        dataType: 'json', timeout: 8000,
        success: function (res) {
            var rows = [];
            if (Array.isArray(res)) {
                rows = res;
            } else if (res && Array.isArray(res.data)) {
                rows = res.data;
            } else if (res && Array.isArray(res.results)) {
                rows = res.results;
            }

            ptAllData = rows;

            if (!rows.length) {
                console.warn('[pt-modal] Endpoint tindakan mengembalikan data kosong untuk q="".', res);
                $('#pt-list-body').html(
                    '<tr><td colspan="5" style="text-align:center;color:#dc3545;padding:14px; font-size:11px;">' +
                    'Data tindakan kosong dari server. Cek console (F12) untuk detail respon.</td></tr>'
                );
                return;
            }

            ptRenderList(ptAllData);
        },
        error: function (xhr, status, err) {
            console.error('[pt-modal] Gagal ambil data tindakan:', status, err, xhr.responseText);
            $('#pt-list-body').html(
                '<tr><td colspan="5" style="text-align:center;color:#dc3545;padding:14px;">' +
                'Gagal memuat data tindakan (' + (xhr.status || status) + '). Cek console (F12) untuk detail.' +
                '</td></tr>'
            );
        }
    });
}

$('#btn-add-action').on('click', function () {
    ptSelected = {};
    ptRenderSelected();
    $('#pt-search-input').val('');
    ptLoadAll();
    $('#modal-pilih-tindakan').modal('show');
});

$('#pt-search-input').on('input', function () {
    clearTimeout(ptSearchTimer);
    var q = $(this).val();
    ptSearchTimer = setTimeout(function () { ptFilterAndRender(q); }, 120);
});

$(document).on('click', '#pt-list-body tr.pt-row', function () {
    if ($(this).data('already-added') == '1' || $(this).attr('data-already-added') === '1') {
        return; // sudah ada di tabel Tindakan & Tarif, tidak bisa dipilih lagi
    }

    var item = $(this).data('item');
    if (!item) return;

    var key   = item.kode + '||' + item.nama;
    var $chk  = $(this).find('.pt-checkbox');
    var newlyChecked = !ptSelected[key];

    if (newlyChecked) {
        ptSelected[key] = item;
    } else {
        delete ptSelected[key];
    }

    $chk.prop('checked', newlyChecked);
    $(this).toggleClass('pt-row-selected', newlyChecked);
    ptRenderSelected();
});

$(document).on('click', '.pt-remove', function () {
    var key = $(this).data('key');
    delete ptSelected[key];
    ptRenderSelected();
    $('#pt-list-body tr').each(function () {
        var item = $(this).data('item');
        if (item && (item.kode + '||' + item.nama) === key) {
            $(this).find('.pt-checkbox').prop('checked', false);
        }
    });
});

$('#btn-ok-pilih-tindakan').on('click', function () {
    var keys = Object.keys(ptSelected);
    if (!keys.length) {
        alert('Pilih minimal satu tindakan.');
        return;
    }
    $.each(keys, function (_, key) {
        var item = ptSelected[key];
        addActionRow({
            kode: item.kode,
            nama: item.nama,
            kategori: item.kategori || 'tindakan_medis',
            harga: item.harga
        });
    });
    $('#modal-pilih-tindakan').modal('hide');
});

    function addActionRow(prefill) {
    prefill = prefill || {};
    var i            = actionIndex++;
    var hargaRaw     = parseFloat(prefill.harga) || 0;
    var hargaDisplay = hargaRaw > 0 ? hargaRaw.toLocaleString('id-ID') : '0';
    var isLocked     = !!(prefill.kode || prefill.nama); // terkunci kalau berasal dari pilihan modal

    var row = '<tr class="action-row">'
        + '<td>'
        +   '<input type="text" name="outpatient_actions[' + i + '][action_code]"'
        +   ' class="form-control input-sm" placeholder="Kode..."'
        +   (isLocked ? ' readonly style="background:#f0f0f0; cursor:default; color:#333; font-weight:600;"' : '')
        +   ' value="' + escHtml(prefill.kode || '') + '">'
        + '</td>'
        + '<td style="position:relative;">'
        +   '<input type="text" name="outpatient_actions[' + i + '][action_name]"'
        +   ' class="form-control input-sm action-name"'
        +   ' placeholder="Ketik nama tindakan..." autocomplete="off" required'
        +   (isLocked ? ' readonly style="background:#f0f0f0; cursor:default; color:#333; font-weight:600;"' : '')
        +   ' value="' + escHtml(prefill.nama || '') + '">'
        +   '<input type="hidden" name="outpatient_actions[' + i + '][action_category]"'
        +   ' value="' + escHtml(prefill.kategori || 'tindakan_medis') + '">'
        +   '<input type="hidden" name="outpatient_actions[' + i + '][notes]" value="">'
        + '</td>'
        + '<td>'
        +   '<input type="number" name="outpatient_actions[' + i + '][quantity]"'
        +   ' class="form-control input-sm action-qty" value="1" min="1"'
        +   ' style="text-align:center; -moz-appearance:textfield;">'
        + '</td>'
        + '<td>'
        +   '<input type="text" class="form-control input-sm action-unit-price-display"'
        +   ' value="' + hargaDisplay + '" readonly'
        +   ' style="text-align:right; background:#f0f0f0; cursor:default; color:#333; font-weight:600;">'
        +   '<input type="hidden" name="outpatient_actions[' + i + '][unit_price]"'
        +   ' class="action-unit-price" value="' + hargaRaw + '">'
        + '</td>'
        + '<td>'
        +   '<input type="text" class="form-control input-sm action-total" readonly value="0"'
        +   ' style="background:#f5f5f5; text-align:right;">'
        + '</td>'
        + '<td class="text-center">'
        +   '<button type="button" class="btn btn-xs btn-danger btn-remove-action">&times;</button>'
        + '</td>'
        + '</tr>';

    $('#actions-body').append(row);
    if (!isLocked) {
        $('#actions-body tr:last .action-name').focus();
    }
    calcGrandTotal();
}

    $(document).on('click', '.btn-remove-action', function () {
        $(this).closest('tr').remove();
        closeDropdown();
        calcGrandTotal();
    });

    // ══════════════════════════════════════════════════════════════════════════
    // HAPUS ICD-10 baris
    // ══════════════════════════════════════════════════════════════════════════
    $(document).on('click', '.btn-remove-icd10', function () {
        $(this).closest('tr.icd10-row').remove();
        if (!$('#icd10-body .icd10-row').length) {
            var c = <?= $isDone ? 3 : 4 ?>;
            $('#icd10-body').append(
                '<tr id="icd10-empty-row"><td colspan="' + c + '"'
                + ' style="text-align:center;color:#aaa;padding:10px;font-size:11px;">'
                + '<i class="fa fa-diagnoses"></i> Belum ada diagnosa ICD-10.</td></tr>'
            );
        } else if (!$('input[name="icd10_utama"]:checked').length) {
            $('#icd10-body .icd10-row:first input[name="icd10_utama"]').prop('checked', true);
        }
    });

    // ══════════════════════════════════════════════════════════════════════════
    // HAPUS ICD-9 baris
    // ══════════════════════════════════════════════════════════════════════════
    $(document).on('click', '.btn-remove-icd9', function () {
        $(this).closest('tr.icd9-row').remove();
        if (!$('#icd9-body .icd9-row').length) {
            var c = <?= $isDone ? 3 : 4 ?>;
            $('#icd9-body').append(
                '<tr id="icd9-empty-row"><td colspan="' + c + '"'
                + ' style="text-align:center;color:#aaa;padding:10px;font-size:11px;">'
                + '<i class="fa fa-clipboard-list"></i> Belum ada tindakan ICD-9.</td></tr>'
            );
        } else if (!$('input[name="icd9_utama"]:checked').length) {
            $('#icd9-body .icd9-row:first input[name="icd9_utama"]').prop('checked', true);
        }
    });

    // ══════════════════════════════════════════════════════════════════════════
    // SIMPAN TAB AKTIF
    // ══════════════════════════════════════════════════════════════════════════
    var tabKey    = 'emr_tab_surat_<?= (int)$visit->id ?>';
    var activeTab = localStorage.getItem(tabKey);
    if (activeTab) {
        $('#tab-surat-rujuk a[href="' + activeTab + '"]').tab('show');
    }
    $('#tab-surat-rujuk a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr('href');
        localStorage.setItem(tabKey, target);

        $('#tab-surat-rujuk li').removeClass('active');
        $(e.target).closest('li').addClass('active');
    });

    $('#tab-surat-rujuk li.active a[data-toggle="tab"]').tab('show');

    calcGrandTotal();

    // ══════════════════════════════════════════════════════════════════════════
    // AUTOCOMPLETE MASTER TINDAKAN
    // ══════════════════════════════════════════════════════════════════════════
    var $dropdown         = $('#tindakan-dropdown');
    var $activeInput      = null;
    var autocompleteTimer = null;
    var lastQuery         = '';
    var isSearching       = false;

    $(document).on('mousedown', function (e) {
        if (!$(e.target).closest('#tindakan-dropdown').length &&
            !$(e.target).hasClass('action-name')) {
            closeDropdown();
        }
    });

    function closeDropdown() {
        $dropdown.hide().empty();
        $activeInput = null;
        lastQuery    = '';
    }

    $(document).on('keydown', '.action-name', function (e) {
        if (!$dropdown.is(':visible')) return;
        var $items  = $dropdown.find('.dd-item');
        var $active = $items.filter('.active');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            var $next = $active.length ? $active.nextAll('.dd-item').first() : $items.first();
            $items.removeClass('active'); $next.addClass('active'); scrollToActive($next);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            var $prev = $active.length ? $active.prevAll('.dd-item').first() : $items.last();
            $items.removeClass('active'); $prev.addClass('active'); scrollToActive($prev);
        } else if (e.key === 'Enter') {
            if ($active.length) { e.preventDefault(); $active.trigger('mousedown'); }
        } else if (e.key === 'Escape') {
            closeDropdown();
        }
    });

    function scrollToActive($item) {
        if (!$item.length) return;
        var itemTop    = $item.position().top;
        var itemBottom = itemTop + $item.outerHeight();
        var ddHeight   = $dropdown.height();
        var scrollTop  = $dropdown.scrollTop();
        if (itemTop < 0)              $dropdown.scrollTop(scrollTop + itemTop);
        else if (itemBottom > ddHeight) $dropdown.scrollTop(scrollTop + (itemBottom - ddHeight));
    }

$(document).on('input', '.action-name', function () {
    if (this.readOnly) return;
    var $input = $(this);
    $activeInput = $input;
        clearTimeout(autocompleteTimer);
        var q = $.trim($input.val());
        if (q.length < 1) { closeDropdown(); return; }
        if (q === lastQuery && $dropdown.is(':visible')) return;
        showLoading($input);
        autocompleteTimer = setTimeout(function () { doSearch(q, $input); }, 200);
    });

    $(document).on('focus', '.action-name', function () {
        if (this.readOnly) return;
        var $input = $(this);
        var q = $.trim($input.val());
        if (q.length >= 1 && !$dropdown.is(':visible')) {
            $activeInput = $input;
            doSearch(q, $input);
        }
    });

    function doSearch(q, $input) {
        if (isSearching) return;
        isSearching = true;
        $.ajax({
            url: SEARCH_URL, method: 'GET', data: { q: q },
            dataType: 'json', timeout: 5000,
            success: function (data) {
                isSearching = false; lastQuery = q;
                if (data && data._error) {
                    showError($input, 'Server error: ' + (data._message || 'Unknown'));
                    setDebug('Server error: ' + (data._message || 'Unknown')); return;
                }
                if ($activeInput && $.trim($activeInput.val()) === q) {
                    renderDropdown(data, $input);
                    setDebug('OK — ' + (data ? data.length : 0) + ' hasil untuk "' + q + '"');
                }
            },
            error: function (xhr, status, error) {
                isSearching = false;
                var msg = status === 'timeout'   ? 'Timeout — server tidak merespons'
                        : xhr.status === 404     ? '404 — URL tidak ditemukan: ' + SEARCH_URL
                        : (xhr.status === 403 || xhr.status === 401) ? xhr.status + ' — Akses ditolak'
                        : xhr.status === 500     ? '500 — Server error'
                        : 'Error ' + xhr.status + ': ' + error;
                showError($input, msg); setDebug(msg);
                $('#debug-autocomplete').show();
            }
        });
    }

    function showLoading($input) {
        positionDropdown($input);
        $dropdown.html('<div class="dd-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        $dropdown.show();
    }

    function showError($input, msg) {
        positionDropdown($input);
        $dropdown.html(
            '<div class="dd-error"><i class="fa fa-exclamation-triangle"></i> ' + escHtml(msg) + '<br>'
            + '<small>Cek <a href="' + DEBUG_URL + '" target="_blank">debug endpoint</a> untuk detail.</small></div>'
        );
        $dropdown.show();
    }

    function renderDropdown(data, $input) {
        $dropdown.empty();
        if (!data || !Array.isArray(data) || data.length === 0) {
            $dropdown.html('<div class="dd-empty"><i class="fa fa-search"></i> Tindakan tidak ditemukan</div>');
            positionDropdown($input); $dropdown.show(); return;
        }
        var grouped = {}, order = [];
        $.each(data, function (_, item) {
            var cat = item.kategori || 'Lainnya';
            if (!grouped[cat]) { grouped[cat] = []; order.push(cat); }
            grouped[cat].push(item);
        });
        var catLabels = {
            'Konsultasi'     : '<i class="fa fa-user-md"></i> Konsultasi',
            'Tindakan Medis' : '<i class="fa fa-syringe"></i> Tindakan Medis',
            'Administrasi'   : '<i class="fa fa-file-alt"></i> Administrasi',
        };
        $.each(order, function (_, cat) {
            var catLabel = catLabels[cat] || ('<i class="fa fa-tag"></i> ' + escHtml(cat));
            $('<div class="dd-header">' + catLabel + '</div>').appendTo($dropdown);
            $.each(grouped[cat], function (_, item) {
                var harga = parseFloat(item.harga) > 0
                    ? 'Rp ' + parseFloat(item.harga).toLocaleString('id-ID')
                    : '<span style="color:#aaa;">Gratis</span>';
                var kodeHtml = item.kode
                    ? '<span style="background:#e9ecef;border-radius:3px;padding:1px 5px;'
                    + 'margin-right:4px;font-family:monospace;">' + escHtml(item.kode) + '</span>'
                    : '';
                var ketHtml = item.keterangan
                    ? '<span style="color:#aaa;"> · ' + escHtml(item.keterangan) + '</span>' : '';
                $('<div class="dd-item"></div>')
                    .html('<div class="dd-item-name">' + kodeHtml + escHtml(item.nama) + '</div>'
                        + '<div class="dd-item-meta"><span class="dd-item-harga">' + harga + '</span>'
                        + ' / ' + escHtml(item.satuan || 'Kali') + ketHtml + '</div>')
                    .data('item', item)
                    .on('mousedown', function (e) {
                        e.preventDefault(); fillActionRow($input, item); closeDropdown();
                    })
                    .appendTo($dropdown);
            });
        });
        positionDropdown($input); $dropdown.show();
    }

    function positionDropdown($input) {
    var offset     = $input.offset();
    var height     = $input.outerHeight();
    var scrollTop  = $(window).scrollTop();
    var scrollLeft = $(window).scrollLeft();
    var winH       = $(window).height();
    var winW       = $(window).width();
    var ddW        = Math.max($input.outerWidth(), 320);
    var top        = offset.top - scrollTop + height + 2;
    var left       = offset.left - scrollLeft;
    if (top + 260 > winH)
        top = offset.top - scrollTop - Math.min($dropdown.outerHeight() || 200, 260) - 4;
    if (left + ddW > winW - 10) left = winW - ddW - 10;
    $dropdown.css({ top: top, left: left, width: ddW });
}

    function fillActionRow($input, item) {
        var $row     = $input.closest('tr.action-row');
        var nameAttr = $input.attr('name');
        var match    = nameAttr ? nameAttr.match(/\[(\d+)\]/) : null;
        if (!match) return;
        var idx          = match[1];
        var hargaRaw     = parseFloat(item.harga) || 0;
        var hargaDisplay = hargaRaw > 0 ? hargaRaw.toLocaleString('id-ID') : '0';
        $row.find('input[name="outpatient_actions[' + idx + '][action_name]"]').val(item.nama || '');
        $row.find('input[name="outpatient_actions[' + idx + '][action_code]"]').val(item.kode || '');
        $row.find('input[name="outpatient_actions[' + idx + '][action_category]"]').val(item.kategori || 'tindakan_medis');
        $row.find('input[name="outpatient_actions[' + idx + '][unit_price]"].action-unit-price').val(hargaRaw);
        $row.find('.action-unit-price-display').val(hargaDisplay);
        calcGrandTotal();
    }

    $(window).on('scroll resize', function () {
        if ($activeInput && $dropdown.is(':visible')) positionDropdown($activeInput);
    });

    window.testAutocomplete = function () {
        setDebug('Mengecek koneksi...');
        $.ajax({
            url: DEBUG_URL, method: 'GET', dataType: 'json', timeout: 5000,
            success: function (data) {
                if (data.status === 'ok') {
                    setDebug('OK ✓ — Total: ' + data.total_records + ' | Aktif: ' + data.aktif_records
                        + ' | Kolom: ' + (data.columns || []).join(', '));
                } else {
                    setDebug('Error: ' + (data.message || JSON.stringify(data)));
                }
            },
            error: function (xhr) {
                setDebug('Koneksi gagal: HTTP ' + xhr.status
                    + ' — ' + (xhr.status === 404 ? 'Route searchDebug belum ada' : xhr.responseText.substr(0, 100)));
            }
        });
    };

    // ══════════════════════════════════════════════════════════════════════════
    // AUTOCOMPLETE ICD-10
    // ══════════════════════════════════════════════════════════════════════════
    var icd10Index = <?= !empty($emr->icd10_items)
        ? count((array)(is_string($emr->icd10_items ?? null)
            ? json_decode($emr->icd10_items, true) : []))
        : 0 ?>;
    var icd10Timer = null;
    var $icd10DD   = $('#icd10-dropdown');

    $('#btn-add-icd10').on('click', function () {
        $('#icd10-search-bar').slideDown(150);
        $('#icd10-search-input').focus();
        $(this).hide();
    });

    $('#btn-close-icd10-search').on('click', function () {
        $('#icd10-search-bar').slideUp(150);
        $icd10DD.hide().empty();
        $('#btn-add-icd10').show();
        $('#icd10-search-input').val('');
    });

    $('#icd10-search-input').on('input', function () {
        clearTimeout(icd10Timer);
        var q = $.trim($(this).val());
        if (q.length < 1) { $icd10DD.hide().empty(); return; }
        $icd10DD.html('<div style="padding:10px;text-align:center;color:#888;font-size:12px;">'
            + '<i class="fa fa-spinner fa-spin"></i> Mencari...</div>').show();
        icd10Timer = setTimeout(function () {
            $.ajax({
                url: ICD10_SEARCH_URL, method: 'GET', data: { q: q },
                dataType: 'json', timeout: 5000,
                success: function (data) { renderIcd10DD(data, q); },
                error: function (xhr) {
                    $icd10DD.html('<div style="padding:10px;color:#721c24;font-size:11px;">'
                        + '<i class="fa fa-exclamation-triangle"></i> Gagal: HTTP ' + xhr.status + '</div>').show();
                }
            });
        }, 250);
    });

    $('#icd10-search-input').on('keydown', function (e) {
        var $items = $icd10DD.find('.icd10-dd-item');
        var $act   = $items.filter('.active');
        if (e.key === 'ArrowDown') {
            e.preventDefault(); $items.removeClass('active');
            ($act.length ? $act.nextAll('.icd10-dd-item').first() : $items.first()).addClass('active');
        } else if (e.key === 'ArrowUp') {
            e.preventDefault(); $items.removeClass('active');
            ($act.length ? $act.prevAll('.icd10-dd-item').first() : $items.last()).addClass('active');
        } else if (e.key === 'Enter' && $act.length) {
            e.preventDefault(); $act.trigger('mousedown');
        } else if (e.key === 'Escape') {
            $('#btn-close-icd10-search').trigger('click');
        }
    });

    function renderIcd10DD(data, q) {
        $icd10DD.empty();
        if (!data || !data.length) {
            $icd10DD.html('<div style="padding:12px;text-align:center;color:#aaa;font-size:12px;">'
                + '<i class="fa fa-search"></i> Tidak ditemukan: <strong>' + escHtml(q) + '</strong></div>').show();
            return;
        }
        $.each(data, function (_, item) {
            var kHtml = item.kode
                ? '<span style="font-family:monospace;font-weight:700;background:#dbeafe;'
                + 'padding:1px 5px;border-radius:3px;margin-right:5px;">' + escHtml(item.kode) + '</span>'
                : '';
            $('<div class="icd10-dd-item"></div>')
                .html(kHtml + '<strong>' + escHtml(item.nama) + '</strong>')
                .css({ padding:'7px 12px', cursor:'pointer', borderBottom:'1px solid #f0f0f0',
                       fontSize:'12px', lineHeight:'1.4' })
                .data('item', item)
                .hover(function(){ $(this).css('background','#dbeafe'); },
                       function(){ $(this).css('background',''); })
                .on('mousedown', function (e) {
                    e.preventDefault();
                    addIcd10Row($(this).data('item'));
                    $('#icd10-search-input').val('').focus();
                    $icd10DD.hide().empty();
                })
                .appendTo($icd10DD);
        });
        $icd10DD.show();
    }

    function addIcd10Row(item) {
        // Cek duplikat
        var dup = false;
        $('#icd10-body .icd10-row').each(function () {
            if ($(this).find('input[name^="icd10_code"]').val() === item.kode) dup = true;
        });
        if (dup) { alert('Kode ICD-10 ' + item.kode + ' sudah ada.'); return; }

        var isFirstIcd10 = !$('#icd10-body .icd10-row').length;
        $('#icd10-empty-row').remove();
        var idx = icd10Index++;
        var $tr = $('<tr class="icd10-row" data-idx="' + idx + '"></tr>');
        $tr.html(
            '<input type="hidden" name="icd10_selected[' + idx + ']" value="1">'
            + '<td class="text-center" style="vertical-align:middle;">'
            + '<input type="radio" name="icd10_utama" value="' + idx + '" ' + (isFirstIcd10 ? 'checked' : '') + '></td>'
            + '<td><input type="text" name="icd10_code[' + idx + ']"'
            + ' class="form-control input-sm"'
            + ' value="' + escHtml(item.kode || '') + '"'
            + ' style="font-family:monospace;font-weight:700;"></td>'
            + '<td><input type="text" name="icd10_nama[' + idx + ']"'
            + ' class="form-control input-sm"'
            + ' value="' + escHtml(item.nama || '') + '"'
            + ' placeholder="Nama diagnosa..."></td>'
            + '<td class="text-center" style="vertical-align:middle;">'
            + '<button type="button" class="btn btn-xs btn-danger btn-remove-icd10">&times;</button></td>'
        );
        $tr.css('background','#dbeafe');
        $('#icd10-body').append($tr);
        setTimeout(function(){ $tr.css('background',''); }, 700);
    }

    // Tutup dropdown ICD-10 saat klik di luar
    $(document).on('mousedown', function (e) {
        if (!$(e.target).closest('#icd10-dropdown, #icd10-search-bar').length) {
            $icd10DD.hide();
        }
    });

    // ══════════════════════════════════════════════════════════════════════════
    // AUTOCOMPLETE ICD-9 CM
    // ══════════════════════════════════════════════════════════════════════════
    var icd9Index = <?= !empty($emr->icd9_items)
        ? count((array)(is_string($emr->icd9_items ?? null)
            ? json_decode($emr->icd9_items, true) : []))
        : 0 ?>;
    var icd9Timer = null;
    var $icd9DD   = $('#icd9-dropdown');

    $('#btn-add-icd9').on('click', function () {
        $('#icd9-search-bar').slideDown(150);
        $('#icd9-search-input').focus();
        $(this).hide();
    });

    $('#btn-close-icd9-search').on('click', function () {
        $('#icd9-search-bar').slideUp(150);
        $icd9DD.hide().empty();
        $('#btn-add-icd9').show();
        $('#icd9-search-input').val('');
    });

    $('#icd9-search-input').on('input', function () {
        clearTimeout(icd9Timer);
        var q = $.trim($(this).val());
        if (q.length < 1) { $icd9DD.hide().empty(); return; }
        $icd9DD.html('<div style="padding:10px;text-align:center;color:#888;font-size:12px;">'
            + '<i class="fa fa-spinner fa-spin"></i> Mencari...</div>').show();
        icd9Timer = setTimeout(function () {
            $.ajax({
                url: ICD9_SEARCH_URL, method: 'GET', data: { q: q },
                dataType: 'json', timeout: 5000,
                success: function (data) { renderIcd9DD(data, q); },
                error: function (xhr) {
                    $icd9DD.html('<div style="padding:10px;color:#721c24;font-size:11px;">'
                        + '<i class="fa fa-exclamation-triangle"></i> Gagal: HTTP ' + xhr.status + '</div>').show();
                }
            });
        }, 250);
    });

    $('#icd9-search-input').on('keydown', function (e) {
        var $items = $icd9DD.find('.icd9-dd-item');
        var $act   = $items.filter('.active');
        if (e.key === 'ArrowDown') {
            e.preventDefault(); $items.removeClass('active');
            ($act.length ? $act.nextAll('.icd9-dd-item').first() : $items.first()).addClass('active');
        } else if (e.key === 'ArrowUp') {
            e.preventDefault(); $items.removeClass('active');
            ($act.length ? $act.prevAll('.icd9-dd-item').first() : $items.last()).addClass('active');
        } else if (e.key === 'Enter' && $act.length) {
            e.preventDefault(); $act.trigger('mousedown');
        } else if (e.key === 'Escape') {
            $('#btn-close-icd9-search').trigger('click');
        }
    });

    function renderIcd9DD(data, q) {
        $icd9DD.empty();
        if (!data || !data.length) {
            $icd9DD.html('<div style="padding:12px;text-align:center;color:#aaa;font-size:12px;">'
                + '<i class="fa fa-search"></i> Tidak ditemukan: <strong>' + escHtml(q) + '</strong></div>').show();
            return;
        }
        var grouped = {}, order = [];
        $.each(data, function (_, item) {
            var cat = item.kategori || 'Lainnya';
            if (!grouped[cat]) { grouped[cat] = []; order.push(cat); }
            grouped[cat].push(item);
        });
        var bgMap = {
            'Diagnostik Umum':'#dbeafe','Laboratorium':'#fef9c3','Radiologi':'#fce7f3',
            'Kardiologi':'#fee2e2','Bedah Umum':'#dcfce7','Ortopedi':'#f3e8ff',
            'Kebidanan':'#fdf4ff','Tindakan Umum':'#f8fafc','THT':'#eff6ff',
            'Oftalmologi':'#ecfdf5','Paru & Pernapasan':'#f0fdf4','Endoskopi':'#fff1f2',
            'Urologi':'#fefce8','Bedah Kulit':'#fff7ed',
        };
        $.each(order, function (_, cat) {
            $('<div style="padding:3px 10px;font-size:10px;font-weight:700;color:#555;'
                + 'background:' + (bgMap[cat] || '#f8f9fa')
                + ';border-bottom:1px solid #eee;text-transform:uppercase;position:sticky;top:0;">'
                + escHtml(cat) + '</div>').appendTo($icd9DD);
            $.each(grouped[cat], function (_, item) {
                var kHtml = item.kode
                    ? '<span style="font-family:monospace;font-weight:700;background:#e9ecef;'
                    + 'padding:1px 5px;border-radius:3px;margin-right:5px;">' + escHtml(item.kode) + '</span>'
                    : '';
                var enHtml = item.nama_en
                    ? '<span style="font-size:10px;color:#aaa;"> — ' + escHtml(item.nama_en) + '</span>' : '';
                $('<div class="icd9-dd-item"></div>')
                    .html(kHtml + '<strong>' + escHtml(item.nama) + '</strong>' + enHtml)
                    .css({ padding:'7px 12px', cursor:'pointer', borderBottom:'1px solid #f0f0f0',
                           fontSize:'12px', lineHeight:'1.4' })
                    .data('item', item)
                    .hover(function(){ $(this).css('background','#ede9fe'); },
                           function(){ $(this).css('background',''); })
                    .on('mousedown', function (e) {
                        e.preventDefault();
                        addIcd9Row($(this).data('item'));
                        $('#icd9-search-input').val('').focus();
                        $icd9DD.hide().empty();
                    })
                    .appendTo($icd9DD);
            });
        });
        $icd9DD.show();
    }

    function addIcd9Row(item) {
        // Cek duplikat
        var dup = false;
        $('#icd9-body .icd9-row').each(function () {
            if ($(this).find('input[name^="icd9_code"]').val() === item.kode) dup = true;
        });
        if (dup) { alert('Kode ICD-9 ' + item.kode + ' sudah ada.'); return; }

        var isFirstIcd9 = !$('#icd9-body .icd9-row').length;
        $('#icd9-empty-row').remove();
        var idx = icd9Index++;
        var $tr = $('<tr class="icd9-row" data-idx="' + idx + '"></tr>');
        $tr.html(
            '<input type="hidden" name="icd9_selected[' + idx + ']" value="1">'
            + '<input type="hidden" name="icd9_kategori[' + idx + ']" value="' + escHtml(item.kategori || '') + '">'
            + '<td class="text-center" style="vertical-align:middle;">'
            + '<input type="radio" name="icd9_utama" value="' + idx + '" ' + (isFirstIcd9 ? 'checked' : '') + '></td>'
            + '<td><input type="text" name="icd9_code[' + idx + ']"'
            + ' class="form-control input-sm"'
            + ' value="' + escHtml(item.kode || '') + '"'
            + ' style="font-family:monospace;font-weight:700;"></td>'
            + '<td><input type="text" name="icd9_nama[' + idx + ']"'
            + ' class="form-control input-sm"'
            + ' value="' + escHtml(item.nama || '') + '"'
            + ' placeholder="Nama tindakan..."></td>'
            + '<td class="text-center" style="vertical-align:middle;">'
            + '<button type="button" class="btn btn-xs btn-danger btn-remove-icd9">&times;</button></td>'
        );
        $tr.css('background','#ede9fe');
        $('#icd9-body').append($tr);
        setTimeout(function(){ $tr.css('background',''); }, 700);
    }

    // Tutup dropdown ICD-9 saat klik di luar
    $(document).on('mousedown', function (e) {
        if (!$(e.target).closest('#icd9-dropdown, #icd9-search-bar').length) {
            $icd9DD.hide();
        }
    });

}); // end document.ready

$('#btn-selesai-periksa').on('click', function () {
    if (!confirm('Pemeriksaan selesai dan buat tagihan kasir?')) {
        return false;
    }

    var url = $(this).data('url');
    var csrf = $('input[name="_csrfToken"]').val();

    var form = $('<form>', {
        method: 'POST',
        action: url
    });

    form.append($('<input>', {
        type: 'hidden',
        name: '_csrfToken',
        value: csrf
    }));

    $('body').append(form);
    form.submit();
});

var ICD10_SEARCH_URL = <?= json_encode($this->Url->build([
    'controller' => 'MasterIcd10',
    'action'     => 'search',
])) ?>;
var ICD9_SEARCH_URL  = <?= json_encode($this->Url->build([
    'controller' => 'MasterIcd9',
    'action'     => 'search',
])) ?>;

function htmlEscape(s) {
    return String(s || '').replace(/[&<>"]/g, function(c) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c];
    });
}

function nextIcdIndex(type) {
    return $('#' + type + '-body tr.' + type + '-row').length;
}

function addIcd10Row(kodeOrItem, namaMaybe) {
    var isObj = kodeOrItem !== null && typeof kodeOrItem === 'object';
    var kode  = $.trim(isObj ? (kodeOrItem.kode || kodeOrItem.code || '') : (kodeOrItem || ''));
    var nama  = $.trim(isObj ? (kodeOrItem.nama || kodeOrItem.name || '') : (namaMaybe || ''));

    if (!kode || !nama) return;

    var dup = false;
    $('#icd10-body tr.icd10-row').each(function () {
        if ($.trim($(this).find('input[name^="icd10_code"]').val()) === kode) dup = true;
    });
    if (dup) { alert('Kode ICD-10 ' + kode + ' sudah ada.'); return; }

    // Bersihkan SEMUA baris placeholder (bukan cuma yang ber-id icd10-empty-row),
    // supaya tidak ada teks "Belum ada diagnosa..." yang tersisa dobel.
    $('#icd10-body tr:not(.icd10-row)').remove();

    var i = nextIcdIndex('icd10');
    var checked = i === 0 ? 'checked' : '';
    var row = '' +
        '<tr class="icd10-row" data-idx="' + i + '">' +
        '<input type="hidden" name="icd10_selected[' + i + ']" value="1">' +
        '<td class="text-center" style="vertical-align:middle;">' +
        '<input type="radio" name="icd10_utama" value="' + i + '" ' + checked + '>' +
        '</td>' +
        '<td><input type="text" name="icd10_code[' + i + ']" class="form-control input-sm" value="' + htmlEscape(kode) + '" readonly style="font-family:monospace;font-weight:700;"></td>' +
        '<td><input type="text" name="icd10_nama[' + i + ']" class="form-control input-sm" value="' + htmlEscape(nama) + '" readonly></td>' +
        '<td class="text-center" style="vertical-align:middle;"><button type="button" class="btn btn-xs btn-danger btn-remove-icd10">&times;</button></td>' +
        '</tr>';
    $('#icd10-body').append(row);
}

function addIcd9Row(kodeOrItem, namaMaybe) {
    var isObj = kodeOrItem !== null && typeof kodeOrItem === 'object';
    var kode  = $.trim(isObj ? (kodeOrItem.kode || kodeOrItem.code || '') : (kodeOrItem || ''));
    var nama  = $.trim(isObj ? (kodeOrItem.nama || kodeOrItem.name || '') : (namaMaybe || ''));

    if (!kode || !nama) return;

    var dup = false;
    $('#icd9-body tr.icd9-row').each(function () {
        if ($.trim($(this).find('input[name^="icd9_code"]').val()) === kode) dup = true;
    });
    if (dup) { alert('Kode ICD-9 ' + kode + ' sudah ada.'); return; }

    $('#icd9-body tr:not(.icd9-row)').remove();

    var i = nextIcdIndex('icd9');
    var checked = i === 0 ? 'checked' : '';
    var row = '' +
        '<tr class="icd9-row" data-idx="' + i + '">' +
        '<input type="hidden" name="icd9_selected[' + i + ']" value="1">' +
        '<input type="hidden" name="icd9_kategori[' + i + ']" value="tindakan">' +
        '<td class="text-center" style="vertical-align:middle;">' +
        '<input type="radio" name="icd9_utama" value="' + i + '" ' + checked + '>' +
        '</td>' +
        '<td><input type="text" name="icd9_code[' + i + ']" class="form-control input-sm" value="' + htmlEscape(kode) + '" readonly style="font-family:monospace;font-weight:700;"></td>' +
        '<td><input type="text" name="icd9_nama[' + i + ']" class="form-control input-sm" value="' + htmlEscape(nama) + '" readonly></td>' +
        '<td class="text-center" style="vertical-align:middle;"><button type="button" class="btn btn-xs btn-danger btn-remove-icd9">&times;</button></td>' +
        '</tr>';
    $('#icd9-body').append(row);
}

function renderIcdDropdown($drop, rows, type) {
    if (!rows || !rows.length) {
        $drop.html('<div style="padding:8px;color:#999;">Data tidak ditemukan</div>').show();
        return;
    }

    var html = '';
    rows.forEach(function(row) {
        html += '<div class="icd-option" data-type="' + type + '" data-kode="' + htmlEscape(row.kode) + '" data-nama="' + htmlEscape(row.nama) + '" style="padding:7px 9px;cursor:pointer;border-bottom:1px solid #eee;">' +
            '<strong>' + htmlEscape(row.kode) + '</strong> - ' + htmlEscape(row.nama) +
            '</div>';
    });
    $drop.html(html).show();
}

$('#btn-add-icd10').on('click', function() {
    $('#icd10-search-bar').toggle();
    $('#icd10-search-input').val('').focus();
    $('#icd10-dropdown').hide().empty();
});

$('#btn-close-icd10-search').on('click', function() {
    $('#icd10-search-bar, #icd10-dropdown').hide();
});

$('#btn-add-icd9').on('click', function() {
    $('#icd9-search-bar').toggle();
    $('#icd9-search-input').val('').focus();
    $('#icd9-dropdown').hide().empty();
});

$('#btn-close-icd9-search').on('click', function() {
    $('#icd9-search-bar, #icd9-dropdown').hide();
});

var icd10Timer = null;
$('#icd10-search-input').on('keyup', function() {
    clearTimeout(icd10Timer);
    var q = $.trim($(this).val());
    if (q.length < 2) { $('#icd10-dropdown').hide().empty(); return; }
    icd10Timer = setTimeout(function() {
        $.getJSON(ICD10_SEARCH_URL, {q:q}, function(res) {
            renderIcdDropdown($('#icd10-dropdown'), res.results || [], 'icd10');
        });
    }, 250);
});

var icd9Timer = null;
$('#icd9-search-input').on('keyup', function() {
    clearTimeout(icd9Timer);
    var q = $.trim($(this).val());
    if (q.length < 2) { $('#icd9-dropdown').hide().empty(); return; }
    icd9Timer = setTimeout(function() {
        $.getJSON(ICD9_SEARCH_URL, {q:q}, function(res) {
            renderIcdDropdown($('#icd9-dropdown'), res.results || [], 'icd9');
        });
    }, 250);
});

$(document).on('click', '.icd-option', function() {
    var type = $(this).data('type');
    var kode = $(this).data('kode');
    var nama = $(this).data('nama');
    if (type === 'icd10') {
        addIcd10Row(kode, nama);
        $('#icd10-search-input').val('').focus();
        $('#icd10-dropdown').hide().empty();
    } else {
        addIcd9Row(kode, nama);
        $('#icd9-search-input').val('').focus();
        $('#icd9-dropdown').hide().empty();
    }
});

$(document).on('click', '.btn-remove-icd10', function() {
    $(this).closest('tr').remove();
});
$(document).on('click', '.btn-remove-icd9', function() {
    $(this).closest('tr').remove();
});

$(function () {
    function escHtml(str) { return $('<div>').text(String(str || '')).html(); }

    var i10Selected = {}, i10AllData = [], i10SearchTimer = null;
    var i9Selected  = {}, i9AllData  = [], i9SearchTimer  = null;

    function i10GetExistingCodes() {
        var codes = {};
        $('#icd10-body tr.icd10-row').each(function () {
            var kode = $.trim($(this).find('input[name^="icd10_code"]').val());
            if (kode) codes[kode] = true;
        });
        return codes;
    }

    function i9GetExistingCodes() {
        var codes = {};
        $('#icd9-body tr.icd9-row').each(function () {
            var kode = $.trim($(this).find('input[name^="icd9_code"]').val());
            if (kode) codes[kode] = true;
        });
        return codes;
    }

    function i10RenderList(data) {
        var $body = $('#i10-list-body');
        $body.empty();
        data = (data || []).map(function (item) {
            return { kode: item.kode || item.code || '', nama: item.nama || item.name || '' };
        });
        if (!data.length) {
            $body.html('<tr><td colspan="3" style="text-align:center;color:#aaa;padding:14px;">Data tidak ditemukan</td></tr>');
            return;
        }
        var existing = i10GetExistingCodes();
        $.each(data, function (_, item) {
            var isPicked     = !!i10Selected[item.kode];
            var alreadyAdded = !!existing[item.kode];
            var rowClass = 'i10-row';
            var rowStyle = 'cursor:pointer;';
            var note = '';
            if (alreadyAdded) {
                rowClass += ' i10-row-disabled';
                rowStyle = 'cursor:not-allowed; opacity:0.5;';
                note = ' <span style="color:#999; font-size:10px;">(sudah ditambahkan)</span>';
            } else if (isPicked) {
                rowClass += ' i10-row-selected';
            }
            var $tr = $(
                '<tr class="' + rowClass + '" data-already-added="' + (alreadyAdded ? '1' : '0') + '" style="' + rowStyle + '">' +
                '<td class="text-center"><input type="checkbox" style="pointer-events:none;" ' + (isPicked ? 'checked' : '') + (alreadyAdded ? ' disabled' : '') + '></td>' +
                '<td style="font-family:monospace;font-weight:700;">' + escHtml(item.kode) + '</td>' +
                '<td>' + escHtml(item.nama) + note + '</td>' +
                '</tr>'
            );
            $tr.data('item', item);
            $body.append($tr);
        });
    }

    function i10RenderSelected() {
        var $body = $('#i10-selected-body');
        $body.empty();
        var keys = Object.keys(i10Selected);
        if (!keys.length) {
            $body.html('<tr id="i10-selected-empty"><td colspan="3" style="text-align:center;color:#aaa;padding:12px;font-size:11px;">Belum ada dipilih.</td></tr>');
            return;
        }
        $.each(keys, function (_, kode) {
            var item = i10Selected[kode];
            $body.append(
                '<tr><td>' + escHtml(item.kode) + '</td><td>' + escHtml(item.nama) + '</td>' +
                '<td class="text-center"><button type="button" class="btn btn-xs btn-danger i10-remove" data-kode="' + escHtml(kode) + '">&times;</button></td></tr>'
            );
        });
    }

    function i10FilterAndRender(q) {
        q = $.trim(q || '').toLowerCase();
        if (q === '') { i10RenderList(i10AllData); return; }
        var scored = [];
        $.each(i10AllData, function (_, item) {
            var kode = String(item.kode || item.code || '').toLowerCase();
            var nama = String(item.nama || item.name || '').toLowerCase();
            var score = -1;
            if (kode === q || nama === q) score = 0;
            else if (kode.indexOf(q) === 0 || nama.indexOf(q) === 0) score = 1;
            else if (kode.indexOf(q) !== -1 || nama.indexOf(q) !== -1) score = 2;
            if (score !== -1) scored.push({ item: item, score: score });
        });
        scored.sort(function (a, b) {
            if (a.score !== b.score) return a.score - b.score;
            return String(a.item.nama || '').localeCompare(String(b.item.nama || ''));
        });
        i10RenderList($.map(scored, function (s) { return s.item; }));
    }

    function i10LoadAll() {
        $('#i10-list-body').html('<tr><td colspan="3" style="text-align:center;color:#999;padding:14px;"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');
        $.ajax({
            url: ICD10_SEARCH_URL, method: 'GET', data: { q: '' },
            dataType: 'json', timeout: 8000,
            success: function (res) {
                var rows = Array.isArray(res) ? res : (res && res.results ? res.results : (res && res.data ? res.data : []));
                i10AllData = rows;
                i10RenderList(i10AllData);
            },
            error: function () {
                $('#i10-list-body').html('<tr><td colspan="3" style="text-align:center;color:#dc3545;padding:14px;">Gagal memuat data ICD-10.</td></tr>');
            }
        });
    }

    $('#btn-add-icd10').off('click').on('click', function () {
        i10Selected = {};
        i10RenderSelected();
        $('#i10-search-input').val('');
        i10LoadAll();
        $('#modal-pilih-icd10').modal('show');
    });

    $('#i10-search-input').on('input', function () {
        clearTimeout(i10SearchTimer);
        var q = $(this).val();
        i10SearchTimer = setTimeout(function () { i10FilterAndRender(q); }, 120);
    });

    $(document).on('click', '#i10-list-body tr.i10-row', function () {
        if ($(this).attr('data-already-added') === '1') return;
        var item = $(this).data('item');
        if (!item) return;
        var newlyChecked = !i10Selected[item.kode];
        if (newlyChecked) i10Selected[item.kode] = item; else delete i10Selected[item.kode];
        $(this).find('input[type="checkbox"]').prop('checked', newlyChecked);
        $(this).toggleClass('i10-row-selected', newlyChecked);
        i10RenderSelected();
    });

    $(document).on('click', '.i10-remove', function () {
        var kode = $(this).data('kode');
        delete i10Selected[kode];
        i10RenderSelected();
        $('#i10-list-body tr').each(function () {
            var item = $(this).data('item');
            if (item && item.kode === kode) $(this).find('input[type="checkbox"]').prop('checked', false);
        });
    });

    $('#btn-ok-pilih-icd10').on('click', function () {
        var keys = Object.keys(i10Selected);
        if (!keys.length) { alert('Pilih minimal satu diagnosa ICD-10.'); return; }
        $.each(keys, function (_, kode) {
            addIcd10Row(i10Selected[kode]);
        });
        $('#modal-pilih-icd10').modal('hide');
    });

    // ══ ICD-9 (pola sama persis) ══
    function i9RenderList(data) {
        var $body = $('#i9-list-body');
        $body.empty();
        data = (data || []).map(function (item) {
            return { kode: item.kode || item.code || '', nama: item.nama || item.name || '', kategori: item.kategori || '' };
        });
        if (!data.length) {
            $body.html('<tr><td colspan="3" style="text-align:center;color:#aaa;padding:14px;">Data tidak ditemukan</td></tr>');
            return;
        }
        var existing = i9GetExistingCodes();
        $.each(data, function (_, item) {
            var isPicked     = !!i9Selected[item.kode];
            var alreadyAdded = !!existing[item.kode];
            var rowClass = 'i9-row';
            var rowStyle = 'cursor:pointer;';
            var note = '';
            if (alreadyAdded) {
                rowClass += ' i9-row-disabled';
                rowStyle = 'cursor:not-allowed; opacity:0.5;';
                note = ' <span style="color:#999; font-size:10px;">(sudah ditambahkan)</span>';
            } else if (isPicked) {
                rowClass += ' i9-row-selected';
            }
            var $tr = $(
                '<tr class="' + rowClass + '" data-already-added="' + (alreadyAdded ? '1' : '0') + '" style="' + rowStyle + '">' +
                '<td class="text-center"><input type="checkbox" style="pointer-events:none;" ' + (isPicked ? 'checked' : '') + (alreadyAdded ? ' disabled' : '') + '></td>' +
                '<td style="font-family:monospace;font-weight:700;">' + escHtml(item.kode) + '</td>' +
                '<td>' + escHtml(item.nama) + note + '</td>' +
                '</tr>'
            );
            $tr.data('item', item);
            $body.append($tr);
        });
    }

    function i9RenderSelected() {
        var $body = $('#i9-selected-body');
        $body.empty();
        var keys = Object.keys(i9Selected);
        if (!keys.length) {
            $body.html('<tr id="i9-selected-empty"><td colspan="3" style="text-align:center;color:#aaa;padding:12px;font-size:11px;">Belum ada dipilih.</td></tr>');
            return;
        }
        $.each(keys, function (_, kode) {
            var item = i9Selected[kode];
            $body.append(
                '<tr><td>' + escHtml(item.kode) + '</td><td>' + escHtml(item.nama) + '</td>' +
                '<td class="text-center"><button type="button" class="btn btn-xs btn-danger i9-remove" data-kode="' + escHtml(kode) + '">&times;</button></td></tr>'
            );
        });
    }

    function i9FilterAndRender(q) {
        q = $.trim(q || '').toLowerCase();
        if (q === '') { i9RenderList(i9AllData); return; }
        var scored = [];
        $.each(i9AllData, function (_, item) {
            var kode = String(item.kode || item.code || '').toLowerCase();
            var nama = String(item.nama || item.name || '').toLowerCase();
            var score = -1;
            if (kode === q || nama === q) score = 0;
            else if (kode.indexOf(q) === 0 || nama.indexOf(q) === 0) score = 1;
            else if (kode.indexOf(q) !== -1 || nama.indexOf(q) !== -1) score = 2;
            if (score !== -1) scored.push({ item: item, score: score });
        });
        scored.sort(function (a, b) {
            if (a.score !== b.score) return a.score - b.score;
            return String(a.item.nama || '').localeCompare(String(b.item.nama || ''));
        });
        i9RenderList($.map(scored, function (s) { return s.item; }));
    }

    function i9LoadAll() {
        $('#i9-list-body').html('<tr><td colspan="3" style="text-align:center;color:#999;padding:14px;"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');
        $.ajax({
            url: ICD9_SEARCH_URL, method: 'GET', data: { q: '' },
            dataType: 'json', timeout: 8000,
            success: function (res) {
                var rows = Array.isArray(res) ? res : (res && res.results ? res.results : (res && res.data ? res.data : []));
                i9AllData = rows;
                i9RenderList(i9AllData);
            },
            error: function () {
                $('#i9-list-body').html('<tr><td colspan="3" style="text-align:center;color:#dc3545;padding:14px;">Gagal memuat data ICD-9.</td></tr>');
            }
        });
    }

    $('#btn-add-icd9').off('click').on('click', function () {
        i9Selected = {};
        i9RenderSelected();
        $('#i9-search-input').val('');
        i9LoadAll();
        $('#modal-pilih-icd9').modal('show');
    });

    $('#i9-search-input').on('input', function () {
        clearTimeout(i9SearchTimer);
        var q = $(this).val();
        i9SearchTimer = setTimeout(function () { i9FilterAndRender(q); }, 120);
    });

    $(document).on('click', '#i9-list-body tr.i9-row', function () {
        if ($(this).attr('data-already-added') === '1') return;
        var item = $(this).data('item');
        if (!item) return;
        var newlyChecked = !i9Selected[item.kode];
        if (newlyChecked) i9Selected[item.kode] = item; else delete i9Selected[item.kode];
        $(this).find('input[type="checkbox"]').prop('checked', newlyChecked);
        $(this).toggleClass('i9-row-selected', newlyChecked);
        i9RenderSelected();
    });

    $(document).on('click', '.i9-remove', function () {
        var kode = $(this).data('kode');
        delete i9Selected[kode];
        i9RenderSelected();
        $('#i9-list-body tr').each(function () {
            var item = $(this).data('item');
            if (item && item.kode === kode) $(this).find('input[type="checkbox"]').prop('checked', false);
        });
    });

    $('#btn-ok-pilih-icd9').on('click', function () {
        var keys = Object.keys(i9Selected);
        if (!keys.length) { alert('Pilih minimal satu tindakan ICD-9.'); return; }
        $.each(keys, function (_, kode) {
            addIcd9Row(i9Selected[kode]);
        });
        $('#modal-pilih-icd9').modal('hide');
    });
});

function updateDiagnosisSummary() {
    var primary10 = '', secondary10 = [];
    $('#icd10-body tr.icd10-row').each(function () {
        var kode = $.trim($(this).find('input[name^="icd10_code"]').val());
        var nama = $.trim($(this).find('input[name^="icd10_nama"]').val());
        if (!kode && !nama) return;
        var label = (kode ? kode + ' - ' : '') + nama;
        if ($(this).find('input[name="icd10_utama"]').is(':checked')) {
            primary10 = label;
        } else {
            secondary10.push(label);
        }
    });
    $('#diagnosis_primary_hidden').val(primary10);
    $('#diagnosis_secondary_hidden').val(secondary10.join(', '));

    var primary9 = '';
    $('#icd9-body tr.icd9-row').each(function () {
        var kode = $.trim($(this).find('input[name^="icd9_code"]').val());
        var nama = $.trim($(this).find('input[name^="icd9_nama"]').val());
        if (!kode && !nama) return;
        var label = (kode ? kode + ' - ' : '') + nama;
        if ($(this).find('input[name="icd9_utama"]').is(':checked')) {
            primary9 = label;
        }
    });
    $('#action_notes_hidden').val(primary9);
}

// Update tiap kali radio "utama" berubah, teks kode/nama diedit, atau baris ditambah/dihapus
$(document).on('change', 'input[name="icd10_utama"], input[name="icd9_utama"]', updateDiagnosisSummary);
$(document).on('input', '#icd10-body input, #icd9-body input', updateDiagnosisSummary);

if (document.getElementById('icd10-body')) {
    new MutationObserver(updateDiagnosisSummary)
        .observe(document.getElementById('icd10-body'), { childList: true });
}
if (document.getElementById('icd9-body')) {
    new MutationObserver(updateDiagnosisSummary)
        .observe(document.getElementById('icd9-body'), { childList: true });
}

updateDiagnosisSummary();

var GET_SPRI_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getSuratPengantarRawat',
    $visit->id,
])) ?>;
var SIMPAN_SPRI_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanSuratPengantarRawat',
    $visit->id,
])) ?>;
var CETAK_SPRI_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'cetakSuratPengantarRawat',
    $visit->id,
])) ?>;
var RENCANA_RAWAT_INAP_URL = <?= json_encode($this->Url->build([
    'controller' => 'PatientAdmissions',
    'action'     => 'planInpatient',
    $visit->id,
])) ?>;

var GET_SBR_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'getSuratBuktiRajal',
    $visit->id,
])) ?>;
var SIMPAN_SBR_URL = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'simpanSuratBuktiRajal',
    $visit->id,
])) ?>;
var CETAK_SBR_URL_BASE = <?= json_encode($this->Url->build([
    'controller' => 'OutpatientLetters',
    'action'     => 'cetakSuratBuktiRajal',
])) ?>;
var DOCTORS_LIST_URL = <?= json_encode($this->Url->build([
    'controller' => 'Doctors',
    'action'     => 'listActive',
])) ?>;

var currentSbrLetterId = null;

function sbrGetIcdText(bodySelector, wantUtama) {
    var isIcd10   = bodySelector === '#icd10-body';
    var rowClass  = isIcd10 ? 'icd10-row' : 'icd9-row';
    var codeField = isIcd10 ? 'icd10_code' : 'icd9_code';
    var nameField = isIcd10 ? 'icd10_nama' : 'icd9_nama';
    var utamaField = isIcd10 ? 'icd10_utama' : 'icd9_utama';

    var lines = [];
    $(bodySelector + ' tr.' + rowClass).each(function () {
        var $row = $(this);
        var kode = $.trim($row.find('input[name^="' + codeField + '"]').val());
        var nama = $.trim($row.find('input[name^="' + nameField + '"]').val());
        if (!kode && !nama) return;

        var isUtama = $row.find('input[name="' + utamaField + '"]').is(':checked');
        if (wantUtama && !isUtama) return;
        if (!wantUtama && isUtama) return;

        lines.push((kode ? kode + ' - ' : '') + nama);
    });
    return lines.join('\n');
}

function sbrFillIcdFields() {
    $('#sbr-diagnosa-utama').val(sbrGetIcdText('#icd10-body', true));
    $('#sbr-diagnosa-sekunder').val(sbrGetIcdText('#icd10-body', false));
    $('#sbr-tindakan-utama').val(sbrGetIcdText('#icd9-body', true));
    $('#sbr-tindakan-sekunder').val(sbrGetIcdText('#icd9-body', false));
}

function sbrLoadDoctorOptions() {
    var $selects = $('#sbr-dokter-pulang, #sbr-dokter-lengkap');
    $selects.each(function () {
        var $s = $(this);
        $s.html('<option value="">-- Pilih Dokter --</option>');
    });

    $.ajax({
        url: DOCTORS_LIST_URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (!data || !data.length) return;
            $.each(data, function (_, item) {
                var name = item.doctor_name || item.name || '';
                var id = item.id || '';
                if (!id) return;
                var label = name + (item.specialist ? ' (' + item.specialist + ')' : '');
                $('#sbr-dokter-pulang, #sbr-dokter-lengkap').append(
                    '<option value="' + id + '">' + htmlEscape(label) + '</option>'
                );
            });
        },
        error: function () {
            $('#sbr-dokter-pulang, #sbr-dokter-lengkap').append(
                '<option value="">-- Gagal memuat dokter --</option>'
            );
        }
    });
}

$('#sbr-special-lainnya-check').on('change', function () {
    $('#sbr-special-lainnya-text').toggle(this.checked);
});

function sbrSetFieldLock(selector, isLocked) {
    var $field = $(selector);
    $field.prop('readonly', isLocked);
    $field.css({
        background: isLocked ? '#f5f5f5' : '',
        cursor: isLocked ? 'not-allowed' : ''
    });
}

function sbrLockFilledFields() {
    sbrSetFieldLock('#sbr-anamnesa', $.trim($('#sbr-anamnesa').val()) !== '');
    sbrSetFieldLock('#sbr-resep', $.trim($('#sbr-resep').val()) !== '');
    sbrSetFieldLock('#sbr-saran', $.trim($('#sbr-saran').val()) !== '');
    sbrSetFieldLock('#sbr-nama-keluarga', $.trim($('#sbr-nama-keluarga').val()) !== '');
}

$(document).on('click', '.btn-surat-bukti-rajal', function () {
    $('#sbr-noreg').val(<?= json_encode($visit->registration_no ?? '-') ?>);
    $('#sbr-nama').val(<?= json_encode($p->full_name ?? '-') ?>);
    $('#sbr-nama-keluarga').val(<?= json_encode($p->full_name ?? '') ?>);
    $('#sbr-anamnesa').val(<?= json_encode(trim((string)($emr->chief_complaint ?? $emr->illness_history ?? ''))) ?>);
    $('#sbr-resep').val(<?= json_encode($emr->prescription_notes ?? '') ?>);
    $('#sbr-saran').val(<?= json_encode($emr->doctor_notes ?? '') ?>);
    $('#sbr-penunjang').val('');
    $('input[name="sbr_otopsi"][value="0"]').prop('checked', true);
    $('.sbr-special-action').prop('checked', false);
    $('#sbr-special-lainnya-text').val('').hide();
    $('#sbr-noSurat').val('AUTO');
    currentSbrLetterId = null;
    $('#btn-cetak-sbr').prop('disabled', true);

    // Kunci dulu berdasarkan data awal dari EMR/pasien
    sbrLockFilledFields();

    sbrFillIcdFields();
    sbrLoadDoctorOptions();

    $.ajax({
        url: GET_SBR_URL,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res && res.success && res.data) {
                var d = res.data;
                currentSbrLetterId = d.letter_id;
                $('#sbr-noSurat').val(d.letter_no || 'AUTO');
                if (d.anamnesa)                $('#sbr-anamnesa').val(d.anamnesa);
                if (d.supporting_diagnosis)     $('#sbr-penunjang').val(d.supporting_diagnosis);
                if (d.prescription)             $('#sbr-resep').val(d.prescription);
                if (d.advice_notes)             $('#sbr-saran').val(d.advice_notes);
                if (d.patient_or_family_name)   $('#sbr-nama-keluarga').val(d.patient_or_family_name);
                $('input[name="sbr_otopsi"][value="' + (d.is_autopsy ? '1' : '0') + '"]').prop('checked', true);

                if (Array.isArray(d.special_actions)) {
                    $.each(d.special_actions, function (_, val) {
                        $('.sbr-special-action[value="' + val + '"]').prop('checked', true);
                        if (val !== 'Phaco' && val !== 'Hemodialisa' && val !== 'CT-SCAN' && val !== 'Kemoterapi') {
                            $('#sbr-special-lainnya-check').prop('checked', true);
                            $('#sbr-special-lainnya-text').val(val).show();
                        }
                    });
                }

                setTimeout(function () {
                    if (d.discharged_by_doctor_id) $('#sbr-dokter-pulang').val(d.discharged_by_doctor_id);
                    if (d.completing_doctor_id) $('#sbr-dokter-lengkap').val(d.completing_doctor_id);
                }, 400);

                $('#btn-cetak-sbr').prop('disabled', false);

                // Kunci ulang setelah nilai dari data tersimpan ikut ditimpakan
                sbrLockFilledFields();
            }
        }
    });

    $('#modal-surat-bukti-rajal').modal('show');
});

$('#btn-simpan-sbr, #btn-tambah-sbr, #btn-edit-sbr').on('click', function () {
    var csrf = $('input[name="_csrfToken"]').val();

    var specialActions = [];
    $('.sbr-special-action:checked').each(function () {
        var val = $(this).val();
        if (val === 'Lainnya') {
            var teks = $.trim($('#sbr-special-lainnya-text').val());
            if (teks) specialActions.push(teks);
        } else {
            specialActions.push(val);
        }
    });

    var payload = {
        _csrfToken: csrf,
        anamnesa: $('#sbr-anamnesa').val(),
        diagnosis_primary_text: $('#sbr-diagnosa-utama').val(),
        diagnosis_secondary_text: $('#sbr-diagnosa-sekunder').val(),
        action_primary_text: $('#sbr-tindakan-utama').val(),
        action_secondary_text: $('#sbr-tindakan-sekunder').val(),
        supporting_diagnosis: $('#sbr-penunjang').val(),
        is_autopsy: $('input[name="sbr_otopsi"]:checked').val(),
        special_actions: specialActions,
        prescription: $('#sbr-resep').val(),
        advice_notes: $('#sbr-saran').val(),
        discharged_by_doctor_id: $('#sbr-dokter-pulang').val(),
        completing_doctor_id: $('#sbr-dokter-lengkap').val(),
        patient_or_family_name: $('#sbr-nama-keluarga').val(),
        examined_at: new Date().toISOString().slice(0, 10),
    };

    $.ajax({
        url: SIMPAN_SBR_URL,
        method: 'POST',
        data: payload,
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#sbr-noSurat').val(res.letter_no);
                currentSbrLetterId = res.letter_id;
                $('#btn-cetak-sbr').prop('disabled', false);
                alert('Surat berhasil disimpan: ' + res.letter_no);
            } else {
                alert(res.message || 'Gagal menyimpan surat.');
            }
        },
        error: function () {
            alert('Gagal menghubungi server.');
        }
    });
});

$('#btn-cetak-sbr').on('click', function () {
    if (!currentSbrLetterId) return;
    window.open(CETAK_SBR_URL_BASE + '/' + currentSbrLetterId, '_blank');
});

var sbrPenunjangTimer = null;
$('#sbr-penunjang-search').on('input', function () {
    clearTimeout(sbrPenunjangTimer);
    var q = $.trim($(this).val());
    if (q.length < 1) { $('#sbr-penunjang-dropdown').hide().empty(); return; }
    sbrPenunjangTimer = setTimeout(function () {
        $.ajax({
            url: SEARCH_URL,
            method: 'GET',
            data: { q: q },
            dataType: 'json',
            success: function (data) {
                var $dd = $('#sbr-penunjang-dropdown');
                $dd.empty();
                if (!data || !data.length) {
                    $dd.html('<div style="padding:8px;color:#aaa;">Tidak ditemukan</div>').show();
                    return;
                }
                $.each(data, function (_, item) {
                    var nama = item.nama || item.name || '';
                    var kode = item.kode || item.code || '';
                    $('<div class="poly-dd-item"></div>')
                        .html('<strong>' + escHtml(nama) + '</strong>' + (kode ? ' (' + escHtml(kode) + ')' : ''))
                        .on('mousedown', function (e) {
                            e.preventDefault();
                            var current = $.trim($('#sbr-penunjang').val());
                            var line = (kode ? kode + ' - ' : '') + nama;
                            $('#sbr-penunjang').val(current ? current + '\n' + line : line);
                            $('#sbr-penunjang-search').val('');
                            $dd.hide().empty();
                        })
                        .appendTo($dd);
                });
                $dd.show();
            }
        });
    }, 250);
});

$(document).on('mousedown', function (e) {
    if (!$(e.target).closest('#sbr-penunjang-search, #sbr-penunjang-dropdown').length) {
        $('#sbr-penunjang-dropdown').hide();
    }
});

$.ajax({
    url: GET_SPRI_URL,
    method: 'GET',
    dataType: 'json',
    success: function (res) {
        if (res && res.success && res.data && res.data.reason) {
            $('#spri-alasan').val(res.data.reason);
        }
    }
});

$('#btn-surat-pengantar-rawat').on('click', function () {
    var $btn = $(this);
    var csrf = $('input[name="_csrfToken"]').val();
    var alasan = $.trim($('#spri-alasan').val());

    if (!alasan) {
        alert('Isi alasan rujukan rawat inap terlebih dahulu.');
        $('#spri-alasan').focus();
        return;
    }

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
        url: SIMPAN_SPRI_URL,
        method: 'POST',
        data: { _csrfToken: csrf, reason: alasan },
        dataType: 'json',
        success: function (res) {
            $btn.prop('disabled', false).html('<i class="fa fa-print"></i> Surat Pengantar Rawat');
            if (res && res.success) {
                window.open(CETAK_SPRI_URL, '_blank');
                $('#wrap-btn-rencana-rawat-inap').slideDown(150);
            } else {
                alert((res && res.message) || 'Gagal menyimpan alasan rujukan.');
            }
        },
        error: function () {
            $btn.prop('disabled', false).html('<i class="fa fa-print"></i> Surat Pengantar Rawat');
            alert('Gagal menghubungi server.');
        }
    });
});

$('#btn-rencana-rawat-inap').on('click', function () {
    var $btn = $(this);
    if (!confirm('Rencanakan pasien ini masuk daftar Rencana Rawat Inap?')) return;

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');

    $.ajax({
        url: RENCANA_RAWAT_INAP_URL,
        method: 'POST',
        dataType: 'json',
        data: { _csrfToken: $('input[name="_csrfToken"]').val() },
        success: function (res) {
            if (res && res.success) {
                alert('Pasien berhasil masuk daftar Rencana Rawat Inap.');
                $btn.html('<i class="fa fa-check"></i> Sudah Direncanakan').prop('disabled', true);
            } else {
                alert((res && res.message) || 'Gagal menambahkan ke Rencana Rawat Inap.');
                $btn.prop('disabled', false).html('<i class="fa fa-procedures"></i> Rencanakan Pasien ke Rawat Inap');
            }
        },
        error: function () {
            alert('Gagal menghubungi server.');
            $btn.prop('disabled', false).html('<i class="fa fa-procedures"></i> Rencanakan Pasien ke Rawat Inap');
        }
    });
});

(function () {
    var requiredVitalFieldNames = ['pulse', 'respiratory_rate', 'blood_pressure', 'temperature', 'weight', 'height'];

    function getForm() {
        return $('.outpatient-visits.emr form').first();
    }

    function isVitalsFilledClientSide() {
        var $form = getForm();
        var complete = true;
        $.each(requiredVitalFieldNames, function (_, name) {
            var val = $.trim($form.find('[name="' + name + '"]').val() || '');
            if (val === '') complete = false;
        });
        return complete;
    }

    function getLockableElements() {
        var $form = getForm();
        var $vitalPanel = $('#panel-tanda-vital');
        return $form.find('input, textarea, select, button, a.btn')
            .not($vitalPanel.find('input, textarea, select, button, a.btn'));
    }

    function lockOthers() {
        getLockableElements().each(function () {
            var $el = $(this);
            if ($el.is('a')) {
                if (!$el.data('emr-href-backup') && $el.attr('href')) {
                    $el.data('emr-href-backup', $el.attr('href')).removeAttr('href');
                }
                $el.addClass('emr-disabled-link');
            } else {
                if ($el.data('emr-orig-disabled') === undefined) {
                    $el.data('emr-orig-disabled', $el.prop('disabled') || false);
                }
                $el.prop('disabled', true);
            }
            $el.addClass('emr-locked-field');
        });
        $('#emr-vital-warning').show();
    }

    function unlockOthers() {
        getLockableElements().each(function () {
            var $el = $(this);
            if ($el.is('a')) {
                var href = $el.data('emr-href-backup');
                if (href) $el.attr('href', href);
                $el.removeClass('emr-disabled-link');
            } else {
                $el.prop('disabled', !!$el.data('emr-orig-disabled'));
            }
            $el.removeClass('emr-locked-field');
        });
        $('#emr-vital-warning').hide();
    }

    var vitalsSavedToServer = <?= json_encode(
        !empty($emr->pulse) && !empty($emr->respiratory_rate) && !empty($emr->blood_pressure)
        && !empty($emr->temperature) && !empty($emr->weight) && !empty($emr->height)
    ) ?>;

    function refreshVitalLockState() {
        var $saveVitalBtn = $('#btn-save-vital');
        if (vitalsSavedToServer) {
            unlockOthers();
            $('#vital-saved-badge').show();
        } else {
            lockOthers();
            $('#vital-saved-badge').hide();
        }
        $saveVitalBtn.prop('disabled', !isVitalsFilledClientSide());
    }

    // Event delegation: tidak peduli kapan elemen dibuat, tetap kepasang.
    $(document).on('input change',
        requiredVitalFieldNames.map(function (n) { return '[name="' + n + '"]'; }).join(','),
        function () {
            $('#btn-save-vital').prop('disabled', !isVitalsFilledClientSide());
            if (vitalsSavedToServer) {
                vitalsSavedToServer = false;
                $('#vital-saved-badge').hide();
            }
        }
    );

    $(document).on('click', '#btn-save-vital', function () {
        if (!isVitalsFilledClientSide()) {
            alert('Lengkapi semua Tanda Vital (Nadi, Pernapasan, Tekanan Darah, Suhu Badan) dan Gizi (Berat Badan, Tinggi Badan) terlebih dahulu.');
            return;
        }

        var $btn = $(this);
        var $form = getForm();
        var csrf = $form.find('input[name="_csrfToken"]').val();
        var payload = { _csrfToken: csrf };
        $.each(['pulse', 'respiratory_rate', 'blood_pressure', 'temperature', 'oxygen_saturation', 'pain_scale', 'weight', 'height'], function (_, name) {
            payload[name] = $form.find('[name="' + name + '"]').val();
        });

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: <?= json_encode($this->Url->build(['action' => 'saveVitalSigns', $visit->id])) ?>,
            method: 'POST',
            data: payload,
            dataType: 'json',
            headers: csrf ? { 'X-CSRF-Token': csrf } : {}
        }).done(function (res) {
            if (res && res.success) {
                vitalsSavedToServer = true;
                if (res.bmi) $('#bmi-display').val(res.bmi);
                if (res.bmi_category) $('#bmi-result').val(res.bmi_category);
                refreshVitalLockState();
                $btn.html('<i class="fa fa-check"></i> Tersimpan').prop('disabled', true);
                setTimeout(function () {
                    $btn.html('<i class="fa fa-save"></i> Simpan Tanda Vital & Gizi').prop('disabled', false);
                }, 1200);
            } else {
                alert((res && res.message) || 'Gagal menyimpan tanda vital.');
                $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Tanda Vital & Gizi');
            }
        }).fail(function (xhr) {
            alert('Gagal menghubungi server (' + xhr.status + ').');
            $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Tanda Vital & Gizi');
        });
    });

    $(document).ready(function () {
        refreshVitalLockState();
    });
})();
</script>