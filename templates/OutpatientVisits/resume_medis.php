<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit $visit
 * @var \App\Model\Entity\OutpatientVisitEmr $emr
 * @var \App\Model\Entity\MedicalResume|null $medicalResume
 * @var array $icd10Items
 * @var array $icd9Items
 * @var array $medicineItems
 */
$p = $visit->patient ?? null;
$d = $visit->doctor ?? null;
$r = $visit->registration ?? null;
$m = $medicalResume ?? null;
$isDone = in_array($visit->status ?? '', ['done', 'cancelled']);

function rmVal($obj, $field, $default = '') {
    return !empty($obj->{$field}) ? $obj->{$field} : $default;
}
function rmDate($value) {
    if (empty($value)) return '';
    return is_object($value) && method_exists($value, 'format') ? $value->format('Y-m-d') : substr((string)$value, 0, 10);
}
function rmText($value) {
    return h((string)($value ?? ''));
}

$mrNo       = $p->code ?? '';
$pTitleRm   = $p->title ?? '';
$namaPasien = ($pTitleRm !== '' ? $pTitleRm . ' ' : '') . ($p->full_name ?? '');
$tglMasuk   = rmDate($visit->visit_date ?? $r->registration_date ?? null);
$tglKeluar  = rmDate($visit->end_time ?? null) ?: date('Y-m-d');
$dpjp       = $d->doctor_name ?? '';
$kelas      = $r->class_name ?? $visit->class_name ?? '';
$alergi     = $visit->allergy ?? ($emr->allergy ?? ($p->allergy ?? ''));

$summaryHistory = rmVal($m, 'summary_history', $emr->illness_history ?? $emr->chief_complaint ?? '');
$physicalExam   = rmVal($m, 'physical_exam', trim(
    'TD : ' . ($emr->blood_pressure ?? '') . "\n" .
    'N  : ' . ($emr->pulse ?? '') . " x/menit\n" .
    'RR : ' . ($emr->respiratory_rate ?? '') . " x/menit\n" .
    'S  : ' . ($emr->temperature ?? '') . " °C\n" .
    'SpO2 : ' . ($emr->oxygen_saturation ?? '') . ' %'
));
$education = rmVal($m, 'education_instruction', $emr->doctor_notes ?? $emr->prescription_notes ?? '');

// ── AUTO FILL DARI EMR / RESUME ─────────────────────────────────────────────
// Dipindah ke atas supaya $icd10Items sudah tersedia sebelum dipakai untuk
// menghitung Diagnosa Utama / Diagnosa Sekunder di bawah.
$icd10Items = $icd10Items ?? [];
if (empty($icd10Items) && !empty($emr->icd10_items)) {
    $icd10Items = is_string($emr->icd10_items)
        ? (json_decode($emr->icd10_items, true) ?: [])
        : (array)$emr->icd10_items;
}
$icd9Items = $icd9Items ?? [];
if (empty($icd9Items) && !empty($emr->icd9_items)) {
    $icd9Items = is_string($emr->icd9_items)
        ? (json_decode($emr->icd9_items, true) ?: [])
        : (array)$emr->icd9_items;
}
$medicineItems = $medicineItems ?? [];
if (empty($medicineItems) && !empty($visit->resume_drugs)) {
    $medicineItems = is_string($visit->resume_drugs)
        ? (json_decode($visit->resume_drugs, true) ?: [])
        : (array)$visit->resume_drugs;
}

// ── Diagnosa Utama & Sekunder — diambil dari tabel ICD-10 di EMR:
//    item yang radio "Utama"-nya dicentang -> Diagnosa Utama,
//    item yang tidak dicentang -> Diagnosa Sekunder. ──
$icd10PrimaryLines = [];
$icd10SecondaryLines = [];
foreach ($icd10Items as $icd) {
    $kode = trim((string)($icd['kode'] ?? $icd['code'] ?? ''));
    $nama = trim((string)($icd['nama'] ?? $icd['name'] ?? ''));
    if ($kode === '' && $nama === '') {
        continue;
    }
    $line = trim($kode . ($kode !== '' && $nama !== '' ? ' - ' : '') . $nama);
    if (!empty($icd['utama']) || !empty($icd['is_primary'])) {
        $icd10PrimaryLines[] = $line;
    } else {
        $icd10SecondaryLines[] = $line;
    }
}
$icd10PrimaryText   = implode("\n", $icd10PrimaryLines);
$icd10SecondaryText = implode("\n", $icd10SecondaryLines);

// ── Diagnosa & Tindakan — sumber utama adalah tabel ICD-10 EMR, dengan
//    fallback ke kolom diagnosis_primary/secondary lama kalau ICD-10 kosong. ──
$primaryDx   = rmVal($m, 'primary_diagnosis', $icd10PrimaryText !== '' ? $icd10PrimaryText : ($emr->diagnosis_primary ?? $visit->diagnosis_primary ?? ''));
$secondaryDx = rmVal($m, 'secondary_diagnosis', $icd10SecondaryText !== '' ? $icd10SecondaryText : ($emr->diagnosis_secondary ?? $visit->diagnosis_secondary ?? ''));

$actionTextFromActions = '';
if (!empty($visit->outpatient_actions)) {
    $actionLines = [];
    foreach ($visit->outpatient_actions as $oa) {
        $name = trim((string)($oa->action_name ?? ''));
        $code = trim((string)($oa->action_code ?? ''));
        $qty  = (int)($oa->quantity ?? 1);
        if ($qty < 1) {
            $qty = 1;
        }
        if ($name !== '') {
            $actionLines[] = ($code !== '' ? $code . ' - ' : '') . $name . ' - ' . $qty . 'x';
        }
    }
    $actionTextFromActions = implode("
", $actionLines);
}
$action = rmVal($m, 'medical_action', $emr->action_notes ?? $visit->action_notes ?? $actionTextFromActions);

$medicineRowCount = max(7, count($medicineItems));
$icd10RowCount    = max(1, count($icd10Items));
$icd9RowCount     = max(1, count($icd9Items));
?>

<?= $this->Krs->breadcrumb('Outpatient Visits', 'Resume Medis Rawat Jalan') ?>

<div class="outpatient-visits resume-medis">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
            <i class="fa fa-file-medical"></i> Resume Medis Rawat Jalan
        </h4>
        <div style="display:flex; gap:6px;">
            <?= $this->Html->link('<i class="fa fa-notes-medical"></i> EMR', ['action' => 'emr', $visit->id], ['escape' => false, 'class' => 'btn btn-info btn-sm']) ?>
            <?= $this->Html->link('<i class="fa fa-clipboard-list"></i> CPPT', ['action' => 'cppt', $visit->id], ['escape' => false, 'class' => 'btn btn-warning btn-sm']) ?>
            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> Kembali', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-default btn-sm']) ?>
        </div>
    </div>

    <?= $this->Form->create($m, ['url' => ['action' => 'resumeMedis', $visit->id]]) ?>

    <div class="panel panel-default rm-panel">
        <div class="panel-heading rm-heading">
            <strong>RESUME MEDIS RAWAT JALAN</strong>
        </div>

        <div class="panel-body rm-body">
            <div class="row rm-top-row">
                <div class="col-md-6">
                    <div class="row rm-form-row">
                        <label class="col-xs-3">No Medical Record</label>
                        <div class="col-xs-3"><input type="text" class="form-control input-sm" value="<?= h($mrNo) ?>" readonly></div>
                        <label class="col-xs-2">Nama</label>
                        <div class="col-xs-4"><input type="text" class="form-control input-sm" value="<?= h($namaPasien) ?>" readonly></div>
                    </div>
                    <div class="row rm-form-row">
                        <label class="col-xs-3">Tgl Masuk</label>
                        <div class="col-xs-3"><input type="date" class="form-control input-sm" value="<?= h($tglMasuk) ?>" readonly></div>
                        <label class="col-xs-2">Kelas</label>
                        <div class="col-xs-4"><input type="text" class="form-control input-sm" value="<?= h($kelas) ?>" readonly></div>
                    </div>
                    <div class="row rm-form-row">
                        <label class="col-xs-3">DR DPJP UTAMA</label>
                        <div class="col-xs-8"><input type="text" class="form-control input-sm" value="<?= h($dpjp) ?>" readonly></div>
                        <div class="col-xs-1 rm-search"><i class="fa fa-search"></i></div>
                    </div>
                    <?php for ($i = 2; $i <= 4; $i++): ?>
                    <div class="row rm-form-row">
                        <label class="col-xs-3">Dokter Rawat <?= $i ?></label>
                        <div class="col-xs-8"><input type="text" name="doctor<?= $i ?>_name" class="form-control input-sm" value="<?= h($m->{'doctor' . $i . '_name'} ?? '') ?>"></div>
                        <div class="col-xs-1 rm-search"><i class="fa fa-search"></i></div>
                    </div>
                    <?php endfor; ?>
                </div>

                <div class="col-md-6">
                    <div class="row rm-form-row">
                        <label class="col-xs-3">Tgl Rencana Pulang</label>
                        <div class="col-xs-3"><input type="date" name="planned_discharge_date" class="form-control input-sm" value="<?= h(rmDate($m->planned_discharge_date ?? null)) ?>"></div>
                        <label class="col-xs-2">Tgl Keluar</label>
                        <div class="col-xs-4"><input type="date" class="form-control input-sm" value="<?= h($tglKeluar) ?>" readonly></div>
                    </div>
                    <div class="row rm-form-row">
                        <label class="col-xs-3">Dokter Rawat 5</label>
                        <div class="col-xs-8"><input type="text" name="doctor5_name" class="form-control input-sm" value="<?= h($m->doctor5_name ?? '') ?>"></div>
                        <div class="col-xs-1 rm-search"><i class="fa fa-search"></i></div>
                    </div>
                    <div class="row rm-form-row">
                        <label class="col-xs-3">Dr Konsultan I</label>
                        <div class="col-xs-8"><input type="text" name="consultant1_name" class="form-control input-sm" value="<?= h($m->consultant1_name ?? '') ?>"></div>
                        <div class="col-xs-1 rm-search"><i class="fa fa-search"></i></div>
                    </div>
                    <div class="row rm-form-row">
                        <label class="col-xs-3">Dr Konsultan II</label>
                        <div class="col-xs-8"><input type="text" name="consultant2_name" class="form-control input-sm" value="<?= h($m->consultant2_name ?? '') ?>"></div>
                        <div class="col-xs-1 rm-search"><i class="fa fa-search"></i></div>
                    </div>
                    <div class="row rm-form-row">
                        <label class="col-xs-3">Pengirim</label>
                        <div class="col-xs-8"><input type="text" name="sender_name" class="form-control input-sm" value="<?= h($m->sender_name ?? '') ?>"></div>
                        <div class="col-xs-1 rm-search"><i class="fa fa-search"></i></div>
                    </div>
                    <label class="col-xs-3 rm-risk-label">
                        <input type="checkbox"
                            id="chk-risk"
                            name="has_risk"
                            value="1"
                            <?= !empty($m->risk_note) ? 'checked' : '' ?>>
                        RISIKO / KELAINAN
                    </label>

                    <div class="col-xs-5">
                        <input type="text"
                            id="risk-note"
                            name="risk_note"
                            class="form-control input-sm"
                            value="<?= h($m->risk_note ?? '') ?>"
                            <?= empty($m->risk_note) ? 'readonly' : '' ?>>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs rm-tabs" role="tablist">
                <li class="active"><a href="#rm-hal1" data-toggle="tab">RESUME MEDIS 1</a></li>
                <li><a href="#rm-hal2" data-toggle="tab">RESUME MEDIS HAL 2</a></li>
                <li><a href="#rm-ttd" data-toggle="tab">TTD DOKTER</a></li>
            </ul>

            <div class="tab-content rm-tab-content">
                <div id="rm-hal1" class="tab-pane active">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Ringkasan Riwayat Penyakit</label>
                            <textarea name="summary_history" class="form-control rm-textarea" readonly style="background:#f5f5f5;"><?= rmText($summaryHistory) ?></textarea>

                            <label>Indikasi RI</label>
                            <textarea name="inpatient_indication" class="form-control rm-textarea small"><?= rmText($m->inpatient_indication ?? '') ?></textarea>

                            <label>Pemeriksaan Fisik (anamnemis)</label>
                            <textarea name="physical_exam" class="form-control rm-textarea" readonly style="background:#f5f5f5;"><?= rmText($physicalExam) ?></textarea>

                            <label>Pemeriksaan penunjang diagnosis terpenting</label>
                            <textarea name="supporting_exam" class="form-control rm-textarea"><?= rmText($m->supporting_exam ?? '') ?></textarea>

                            <label>Terapi/Pengobatan selama di RS</label>
                            <textarea name="therapy_during_treatment" class="form-control rm-textarea"><?= rmText($m->therapy_during_treatment ?? '') ?></textarea>

                            <label>Hasil Konsultasi</label>
                            <textarea name="consultation_result" class="form-control rm-textarea"><?= rmText($m->consultation_result ?? '') ?></textarea>

                            <label>Diagnosa saat masuk</label>
                            <textarea name="admission_diagnosis" class="form-control rm-textarea small" readonly style="background:#f5f5f5;"><?= rmText($m->admission_diagnosis ?? $emr->admission_diagnosis ?? '') ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="rm-allergy-title"><input type="checkbox"id="chk-allergy"name="has_allergy"value="1"<?= !empty($alergi) ? 'checked' : '' ?> disabled>ALERGI</label>
                            <textarea id="allergy-text"name="allergy"class="form-control rm-textarea small" readonly style="background:#f5f5f5;"><?= rmText($alergi) ?></textarea>

                            <label>Hasil Laboratorium yang belum selesai</label>
                            <textarea name="lab_unfinished" class="form-control rm-textarea"><?= rmText($m->lab_unfinished ?? '') ?></textarea>

                            <label>Diet</label>
                            <textarea name="diet" class="form-control rm-textarea"><?= rmText($m->diet ?? '') ?></textarea>

                            <label>Intruksi/anjuran/edukasi</label>
                            <textarea name="education_instruction" class="form-control rm-textarea" readonly style="background:#f5f5f5;"><?= rmText($education) ?></textarea>

                            <label>Diagnosa Utama</label>
                            <textarea name="primary_diagnosis" class="form-control rm-textarea" readonly style="background:#f5f5f5;"><?= rmText($primaryDx) ?></textarea>

                            <label>Diagnosa Sekunder</label>
                            <textarea name="secondary_diagnosis" class="form-control rm-textarea" readonly style="background:#f5f5f5;"><?= rmText($secondaryDx) ?></textarea>

                            <label>Tindakan</label>
                            <textarea name="medical_action" class="form-control rm-textarea" readonly style="background:#f5f5f5;"><?= rmText($action) ?></textarea>
                        </div>
                    </div>
                </div>

                <div id="rm-hal2" class="tab-pane">
                    <div class="row">
                        <div class="col-md-7">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                                <label>Obat/Terapi Lanjutan</label>
                            </div>
                            <table class="table table-bordered rm-table">
                                <thead><tr><th>Obat / Resep (dari EMR)</th></tr></thead>
                                <tbody>
                                    <?php if (empty($medicineItems)): ?>
                                        <tr>
                                            <td style="color:#999; font-style:italic;">
                                                Belum ada resep pada EMR kunjungan ini.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($medicineItems as $i => $drug): ?>
                                        <tr>
                                            <td>
                                                <input type="text"
                                                       name="resume_drugs[<?= $i ?>][name]"
                                                       class="form-control input-sm"
                                                       value="<?= h($drug['name'] ?? '') ?>"
                                                       readonly
                                                       style="background:#f5f5f5;">
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <table class="table table-bordered rm-table">
                                <thead><tr><th style="width:80px;">Kode</th><th>Diagnosa</th><th style="width:70px;">Utama</th><th style="width:45px;"></th></tr></thead>
                                <tbody>
                                    <?php for ($i = 0; $i < $icd10RowCount; $i++): ?>
                                    <?php $icd = $icd10Items[$i] ?? []; ?>
                                    <tr>
                                        <td>
                                            <input class="form-control input-sm"
                                                   name="icd10_code[<?= $i ?>]"
                                                   value="<?= h($icd['kode'] ?? $icd['code'] ?? $icd['icd_code'] ?? '') ?>"
                                                   readonly style="background:#f5f5f5;">
                                        </td>
                                        <td>
                                            <input class="form-control input-sm"
                                                   name="icd10_name[<?= $i ?>]"
                                                   value="<?= h($icd['nama'] ?? $icd['name'] ?? $icd['diagnosa'] ?? $icd['diagnosis'] ?? $icd['description'] ?? '') ?>"
                                                   readonly style="background:#f5f5f5;">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox"
                                                   name="icd10_utama[<?= $i ?>]"
                                                   value="1"
                                                   disabled
                                                   style="filter:grayscale(1); opacity:.6;"
                                                   <?= (!empty($icd['utama']) || !empty($icd['is_primary']) || $i === 0) ? 'checked' : '' ?>>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>

                            <table class="table table-bordered rm-table">
                               <thead><tr><th style="width:80px;">Kode</th><th>Diagnosa</th><th style="width:70px;">Utama</th></tr></thead>
                                <tbody>
                                    <?php for ($i = 0; $i < $icd9RowCount; $i++): ?>
                                    <?php $icd = $icd9Items[$i] ?? []; ?>
                                    <tr>
                                        <td>
                                            <input class="form-control input-sm"
                                                   name="icd9_code[<?= $i ?>]"
                                                   value="<?= h($icd['kode'] ?? $icd['code'] ?? $icd['icd_code'] ?? '') ?>"
                                                   readonly style="background:#f5f5f5;">
                                        </td>
                                        <td>
                                            <input class="form-control input-sm"
                                                   name="icd9_name[<?= $i ?>]"
                                                   value="<?= h($icd['nama'] ?? $icd['name'] ?? $icd['diagnosa'] ?? $icd['diagnosis'] ?? $icd['description'] ?? '') ?>"
                                                   readonly style="background:#f5f5f5;">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox"
                                                   name="icd9_utama[<?= $i ?>]"
                                                   value="1"
                                                   disabled
                                                   style="filter:grayscale(1); opacity:.6;"
                                                   <?= (!empty($icd['utama']) || !empty($icd['is_primary']) || $i === 0) ? 'checked' : '' ?>>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-5">
                            <label>Keadaan keluar RS</label>
                            <select name="condition_on_discharge" class="form-control input-sm">
                            <option value="">-- Pilih --</option>
                                <?php foreach (['Membaik', 'Sembuh', 'Belum Sembuh', 'Dirujuk'] as $opt): ?>
                                    <option value="<?= h($opt) ?>" <?= ($m->condition_on_discharge ?? '') === $opt ? 'selected' : '' ?>><?= h($opt) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label>Prognosis</label>
                            <input type="text" name="prognosis" class="form-control input-sm" value="<?= h($m->prognosis ?? '') ?>">

                            <label>Pengobatan Lanjutan</label>
                            <select name="follow_up_treatment" class="form-control input-sm">
                            <option value="">-- Pilih --</option>
                                <?php foreach (['Rawat Jalan', 'Kontrol', 'Rujuk'] as $opt): ?>
                                    <option value="<?= h($opt) ?>" <?= ($m->follow_up_treatment ?? '') === $opt ? 'selected' : '' ?>><?= h($opt) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label>TGL KEMBALI KONTROL</label>
                            <input type="date" name="control_date" class="form-control input-sm" value="<?= h(rmDate($m->control_date ?? null)) ?>">

                            <label>KETERANGAN KONTROL</label>
                            <input type="text" name="control_note" class="form-control input-sm" value="<?= h($m->control_note ?? '') ?>">

                            <label>RENCANA TINDAKAN SAAT KONTROL</label>
                            <input type="text" name="control_plan" class="form-control input-sm" value="<?= h($m->control_plan ?? '') ?>">

                            <label>Alasan blm dikembalikan ke perujuk</label>
                            <textarea name="return_reason" class="form-control rm-textarea small"><?= rmText($m->return_reason ?? '') ?></textarea>

                            <div class="rm-checks">
                                <label><input type="radio" name="letter_type" value="surat_keterangan" <?= ($m->letter_type ?? '') !== 'skdp' ? 'checked' : '' ?>> Surat keterangan</label>
                                <label><input type="radio" name="letter_type" value="skdp" <?= ($m->letter_type ?? '') === 'skdp' ? 'checked' : '' ?>> S K D P</label>
                                <button type="button" class="btn btn-xs btn-default">CETAK</button><br>
                                <label><input type="hidden" name="print_classic" value="0"><input type="checkbox" name="print_classic" value="1" <?= !empty($m->print_classic) ? 'checked' : '' ?>> Print classic</label>
                                <label><input type="hidden" name="send_digital_claim" value="0"><input type="checkbox" name="send_digital_claim" value="1" <?= !empty($m->send_digital_claim) ? 'checked' : '' ?>> Kirim ke digital klaim</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="rm-ttd" class="tab-pane">
                    <div class="rm-sign-box">
                        <p>TTD DOKTER</p>
                        <div class="rm-sign-area"></div>
                        <strong><?= h($dpjp) ?></strong>
                    </div>
                </div>
            </div>

            <div class="rm-footer text-right">
                <?= $this->Form->button(' Simpan', ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                <button type="button" class="btn btn-info btn-sm" onclick="window.print()"><i class="fa fa-print"></i> Cetak</button>
                <?= $this->Html->link('<i class="fa fa-times"></i> Close', ['action' => 'emr', $visit->id], ['escape' => false, 'class' => 'btn btn-default btn-sm']) ?>
            </div>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>

<script>
$(function () {

    function toggleRisk() {
        if ($('#chk-risk').is(':checked')) {
            $('#risk-note').prop('readonly', false);
        } else {
            $('#risk-note').val('');
            $('#risk-note').prop('readonly', true);
        }
    }

    function toggleAllergy() {
        if ($('#chk-allergy').is(':checked')) {
            $('#allergy-text').prop('disabled', false);
        } else {
            $('#allergy-text').val('');
            $('#allergy-text').prop('disabled', true);
        }
    }

    toggleRisk();
    toggleAllergy();

    $('#chk-risk').change(toggleRisk);
    $('#chk-allergy').change(toggleAllergy);

    // ── Sinkronkan tombol tab (RESUME MEDIS 1 / HAL 2 / TTD DOKTER) ──
    // Bootstrap bawaan kadang hanya memindahkan konten (.tab-pane) tapi
    // tidak ikut memindahkan class "active" pada tombol (<li>) di project
    // ini, jadi tombol yang menyala bisa tidak sesuai tab yang sedang
    // ditampilkan. Sinkronkan manual di sini.
    $('.rm-tabs a[data-toggle="tab"]').on('click', function () {
        var $link = $(this);
        $('.rm-tabs li').removeClass('active');
        $link.closest('li').addClass('active');
    });

});
</script>

<style>
.resume-medis .rm-panel{border:1px solid #b8c2d1;box-shadow:0 1px 2px rgba(0,0,0,.06)}
.resume-medis .rm-heading{padding:6px 10px;background:#1e3a5f;color:#fff;font-size:12px}
.resume-medis .rm-body{padding:8px;background:#f4f6fb;font-size:12px}
.resume-medis .rm-top-row{background:#eef2f7;border:1px solid #d4dbe6;padding:6px;margin:0 0 6px}
.resume-medis .rm-form-row{margin-bottom:4px}
.resume-medis .rm-form-row label{font-size:11px;font-weight:600;color:#333;padding-top:4px;margin:0}
.resume-medis .form-control.input-sm{height:26px;padding:3px 6px;font-size:12px}
.resume-medis .rm-search{padding-top:4px;color:#1e3a5f;text-align:center}
.resume-medis .rm-risk-label{background:#c2b342;color:#111!important;text-align:center;padding:4px!important;margin-left:15px!important}
.resume-medis .rm-tabs{margin-top:5px;border-bottom:1px solid #9daac0}
.resume-medis .rm-tabs>li>a{font-size:12px;font-weight:700;padding:6px 28px;background:#dbe4f2;border:1px solid #9daac0;color:#1e3a5f}
.resume-medis .rm-tabs>li.active>a{background:#fff;color:#1e3a5f}
.resume-medis .rm-tab-content{background:#fff;border:1px solid #9daac0;border-top:0;padding:8px;min-height:390px}
.resume-medis label{font-size:11px;color:#37516f;margin-bottom:2px}
.resume-medis .rm-textarea{height:54px;resize:vertical;font-size:12px;line-height:1.3;padding:4px 6px;margin-bottom:5px}
.resume-medis .rm-textarea.small{height:38px}
.resume-medis .rm-allergy-title{display:block;background:#c00040;color:#fff!important;padding:3px 8px;margin-bottom:0;font-weight:700}
.resume-medis .rm-table{font-size:11px;margin-bottom:6px;background:#fff}
.resume-medis .rm-table th{background:#dbeafe;text-align:center;padding:4px;color:#1e3a5f}
.resume-medis .rm-table td{padding:2px}
.resume-medis .rm-checks{margin-top:8px;font-size:11px}
.resume-medis .rm-checks label{margin-right:8px;color:#333}
.resume-medis .rm-sign-box{width:360px;margin:40px auto;text-align:center;border:1px solid #ddd;padding:15px;background:#fff}
.resume-medis .rm-sign-area{height:130px;border:1px dashed #aaa;margin:10px 0;background:#fafafa}
.resume-medis .rm-footer{border-top:1px solid #d8dde6;margin-top:8px;padding-top:8px}
.resume-medis .rm-footer .btn{min-width:90px;margin-left:5px;font-size:12px;font-weight:600}
@media print{.breadcrumb,.resume-medis>div:first-child,.rm-footer{display:none!important}.resume-medis .rm-body{background:#fff}.resume-medis .rm-panel{box-shadow:none;border:1px solid #000}}
.resume-medis .tab-pane .col-md-5 label,
.resume-medis .tab-pane .col-md-6 label{
    margin-top:2px;
    margin-bottom:2px;
    font-weight:600;
}

.resume-medis .tab-pane .col-md-5 .form-control,
.resume-medis .tab-pane .col-md-6 .form-control{
    margin-bottom:5px;
}

.resume-medis .tab-pane .col-md-5 textarea,
.resume-medis .tab-pane .col-md-6 textarea{
    width:100%;
}

</style>