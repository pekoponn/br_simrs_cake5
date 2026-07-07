<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit $visit
 * @var \Cake\Collection\CollectionInterface|\App\Model\Entity\OutpatientCpptNote[] $cpptNotes
 */
$p = $visit->patient ?? null;
$d = $visit->doctor ?? null;
$isDone = in_array($visit->status ?? '', ['done', 'cancelled']);

$nowDateTime = date('Y-m-d\TH:i');
$todayInput  = date('Y-m-d');
$todayLabel  = date('d-m-Y');
$nowTime     = date('H:i:s');

function cpptText($value) {
    $value = trim((string)($value ?? ''));
    return $value !== '' ? h($value) : '&nbsp;';
}
?>

<?= $this->Krs->breadcrumb('Outpatient Visits', 'CPPT — Catatan Perkembangan Pasien') ?>

<div class="outpatient-visits cppt content">

    <!-- Header sama nuansa EMR -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
            <i class="fa fa-clipboard-list"></i> CPPT — Catatan Perkembangan Pasien Terintegrasi
        </h4>
        <div style="display:flex; gap:6px;">
            <?= $this->Html->link(
                '<i class="fa fa-notes-medical"></i> EMR',
                ['action' => 'emr', $visit->id],
                ['escape' => false, 'class' => 'btn btn-info btn-sm']
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </div>
    </div>

    <?= $this->Form->create(null, ['url' => ['action' => 'addCppt', $visit->id]]) ?>

    <!-- Tata letak tetap seperti foto pertama: kiri data pasien, kanan tanggal/petugas -->
    <div class="panel panel-default cppt-main-panel">
        <div class="panel-heading cppt-heading">
            <strong><i class="fa fa-user-md"></i> Nama Dokter</strong>
        </div>

        <div class="panel-body cppt-body">
            <div class="row cppt-top-row">
                <!-- KIRI -->
                <div class="col-md-6">
                    <div class="row cppt-form-row">
                        <label class="col-xs-3">No. Urut</label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control input-sm" value="<?= h(str_pad((string)($visit->queue_number ?? '1'), 3, '0', STR_PAD_LEFT)) ?>" readonly>
                        </div>
                        <div class="col-xs-3">
                            <button type="button" id="btn-cppt-new-top" class="btn btn-xs btn-success btn-block"><i class="fa fa-plus"></i> Tambah</button>
                        </div>
                    </div>

                    <div class="row cppt-form-row">
                        <label class="col-xs-3">No. Registrasi</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control input-sm" value="<?= h($visit->registration_no ?? '-') ?>" readonly>
                        </div>
                        <div class="col-xs-5">
                            <input type="text" class="form-control input-sm" value="<?= h($p->code ?? '-') ?>" readonly>
                        </div>
                    </div>

                    <div class="row cppt-form-row">
                        <label class="col-xs-3">&nbsp;</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control input-sm" value="<?= h($p->full_name ?? '-') ?>" readonly>
                        </div>
                    </div>

                    <div class="row cppt-form-row">
                        <label class="col-xs-3">Dokter DPJP</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control input-sm" value="<?= h($d->doctor_name ?? '-') ?>" readonly>
                        </div>
                        <div class="col-xs-1 cppt-search-col"><i class="fa fa-search"></i></div>
                    </div>
                </div>

                <!-- KANAN -->
                <div class="col-md-6">
                    <div class="row cppt-form-row">
                        <label class="col-xs-3">Tanggal</label>
                        <div class="col-xs-4">
                            <input type="date" name="note_date" id="cppt-note-date" class="form-control input-sm cppt-entry-field" value="<?= h($todayInput) ?>" <?= $isDone ? 'readonly' : '' ?>>
                        </div>
                        <label class="col-xs-1 cppt-jam-label">Jam</label>
                        <div class="col-xs-4">
                            <input type="text" name="note_time" id="cppt-note-time" class="form-control input-sm cppt-entry-field" value="<?= h($nowTime) ?>" <?= $isDone ? 'readonly' : '' ?>>
                        </div>
                    </div>

                    <div class="row cppt-form-row">
                        <label class="col-xs-3">Tenaga Kesehatan</label>
                        <div class="col-xs-8">
                            <input type="text" name="health_worker_name" id="cppt-health-worker-name" class="form-control input-sm cppt-entry-field" placeholder="Nama tenaga kesehatan..." <?= $isDone ? 'readonly' : '' ?>>
                        </div>
                        <div class="col-xs-1 cppt-search-col"><i class="fa fa-search"></i></div>
                    </div>

                    <div class="row cppt-form-row">
                        <label class="col-xs-3">Dokter</label>
                        <div class="col-xs-8">
                            <input type="hidden" name="doctor_id" value="<?= h($visit->doctor_id ?? '') ?>">
                            <input type="text" name="doctor_name" id="cppt-doctor-name" class="form-control input-sm cppt-entry-field" value="<?= h($d->doctor_name ?? '') ?>" <?= $isDone ? 'readonly' : '' ?>>
                        </div>
                        <div class="col-xs-1 cppt-search-col"><i class="fa fa-search"></i></div>
                    </div>

                    <div class="row cppt-form-row">
                        <label class="col-xs-3">Perawat (PPJA)</label>
                        <div class="col-xs-8">
                            <input type="text" name="nurse_name" id="cppt-nurse-name" class="form-control input-sm cppt-entry-field" placeholder="Nama perawat..." <?= $isDone ? 'readonly' : '' ?>>
                        </div>
                        <div class="col-xs-1 cppt-search-col"><i class="fa fa-search"></i></div>
                    </div>
                </div>
            </div>

            <!-- Tengah: tetap 2 kolom seperti foto -->
            <div class="row cppt-middle-row">
                <div class="col-md-6">
                    <label class="cppt-section-title">Asesmen Pasien (SOAP &amp; SBAR)</label>
                    <textarea name="assessment_text" id="cppt-assessment-text" class="form-control cppt-big-text cppt-entry-field" rows="8" placeholder="S :&#10;O :&#10;A :&#10;P :" <?= $isDone ? 'readonly' : '' ?>><?= h($visit->doctor_notes ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <div class="cppt-instruksi-head">
                        <label class="cppt-section-title">Instruksi</label>
                        <button type="button" class="btn btn-xs btn-primary">konsulkan</button>
                        <label class="cppt-check"><input type="checkbox" name="fasting_instruction" id="cppt-fasting-instruction" value="1" <?= $isDone ? 'disabled' : '' ?>> Instruksikan Puasa</label>
                    </div>
                    <textarea name="instruction" id="cppt-instruction" class="form-control cppt-big-text cppt-entry-field" rows="8" placeholder="Instruksi dokter / terapi / obat..." <?= $isDone ? 'readonly' : '' ?>><?= h($visit->prescription_notes ?? '') ?></textarea>
                </div>
            </div>

            <div id="cppt-view-mode-info" class="cppt-view-mode-info">
                <i class="fa fa-eye"></i> Mode lihat riwayat. Data yang dipilih hanya bisa dilihat, tidak bisa diedit. Klik tombol <strong>Tambah</strong> untuk input catatan baru.
            </div>

            <!-- Bawah: riwayat tabel seperti foto -->
            <div class="table-responsive cppt-table-wrap">
                <table class="table table-bordered table-hover cppt-table">
                    <thead>
                        <tr>
                            <th style="width:45px;">No.</th>
                            <th style="width:85px;">Tanggal</th>
                            <th style="width:72px;">Jam</th>
                            <th style="width:145px;">Tenaga Kesehatan</th>
                            <th style="width:155px;">Dokter</th>
                            <th>Asesmen Pasien (SOAP_SBAR)</th>
                            <th style="width:260px;">Instruksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cpptNotes) || (method_exists($cpptNotes, 'count') && $cpptNotes->count() === 0)): ?>
                            <tr>
                                <td colspan="7" class="cppt-empty">
                                    <i class="fa fa-clipboard-list"></i> Belum ada catatan CPPT
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($cpptNotes as $note): ?>
                                <?php
                                    $dt = $note->noted_at ?? $note->created ?? null;
                                    $dtObj = is_object($dt) ? $dt : (!empty($dt) ? new \DateTime($dt) : null);
                                ?>
                                <tr class="cppt-history-row"
                                    data-note-date="<?= $dtObj ? h($dtObj->format('Y-m-d')) : '' ?>"
                                    data-note-time="<?= $dtObj ? h($dtObj->format('H:i:s')) : '' ?>"
                                    data-health-worker="<?= h($note->health_worker_name ?? '') ?>"
                                    data-doctor-name="<?= h($note->doctor_name ?? ($d->doctor_name ?? '')) ?>"
                                    data-nurse-name="<?= h($note->nurse_name ?? '') ?>"
                                    data-assessment="<?= h($note->assessment_text ?? '') ?>"
                                    data-instruction="<?= h($note->instruction ?? '') ?>"
                                    data-fasting="<?= !empty($note->fasting_instruction) ? '1' : '0' ?>">
                                    <td class="text-center"><?= str_pad((string)$no++, 3, '0', STR_PAD_LEFT) ?></td>
                                    <td class="text-center"><?= $dtObj ? $dtObj->format('d-m-y') : '-' ?></td>
                                    <td class="text-center"><?= $dtObj ? $dtObj->format('H:i:s') : '-' ?></td>
                                    <td><?= cpptText($note->health_worker_name ?? '') ?></td>
                                    <td><?= cpptText($note->doctor_name ?? ($d->doctor_name ?? '')) ?></td>
                                    <td class="cppt-scroll-td"><div class="cppt-cell-scroll"><?= cpptText($note->assessment_text ?? '') ?></div></td>
                                    <td class="cppt-scroll-td"><div class="cppt-cell-scroll"><?= cpptText($note->instruction ?? '') ?></div></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer tetap seperti foto -->
            <div class="cppt-footer row">
                <div class="col-md-6 cppt-allergy-wrap">
                    <div class="input-group input-group-sm cppt-allergy-group">
                        <span class="input-group-addon cppt-allergy-label">Alergi :</span>
                        <input type="text"
                               class="form-control cppt-allergy-input"
                               value="<?= h($visit->allergy ?? '-') ?>"
                               readonly>
                    </div>
                </div>

                <div class="col-md-6 text-right cppt-actions">
                    <?php if (!$isDone): ?>
                        <?= $this->Form->button(' Tambah', ['type' => 'button', 'id' => 'btn-cppt-new-bottom', 'class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
                        <?= $this->Form->button(' Simpan', ['type' => 'submit', 'id' => 'btn-cppt-save', 'class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                    <?php endif; ?>
                    <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn btn-default btn-sm']) ?>
                    <button type="button" class="btn btn-info btn-sm" onclick="window.print()"><i class="fa fa-print"></i> Cetak</button>
                    <?= $this->Html->link('<i class="fa fa-times"></i> Close', ['action' => 'emr', $visit->id], ['escape' => false, 'class' => 'btn btn-default btn-sm']) ?>
                </div>
            </div>

            <input type="hidden" name="noted_at" id="cppt-noted-at" value="<?= h($nowDateTime) ?>">
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>

<style>
/* =========================================================
   CPPT - BASE PANEL
   ========================================================= */
.cppt .cppt-main-panel {
    border: 1px solid #d8dde6;
    box-shadow: 0 1px 2px rgba(0,0,0,.06);
}

.cppt .cppt-heading {
    padding: 8px 12px;
    background: #1e3a5f;
    color: #fff;
    font-size: 12px;
}

.cppt .cppt-body {
    padding: 10px;
    background: #fff;
    font-size: 12px;
}

/* =========================================================
   TOP INFO FORM
   ========================================================= */
.cppt .cppt-top-row {
    margin: 0 0 8px;
    padding: 8px 6px 4px;
    background: #f8f9fa;
    border: 1px solid #e2e6ea;
    border-radius: 4px;
}

.cppt .cppt-form-row {
    margin-bottom: 5px;
}

.cppt .cppt-form-row label {
    margin: 0;
    padding-top: 5px;
    font-size: 11px;
    font-weight: 600;
    color: #555;
}

.cppt .form-control.input-sm {
    height: 27px;
    padding: 3px 6px;
    font-size: 12px;
}

.cppt input[readonly],
.cppt textarea[readonly] {
    background: #f5f5f5;
    cursor: not-allowed;
}

.cppt .cppt-search-col {
    padding-top: 5px;
    text-align: center;
    color: #1e3a5f;
}

.cppt .cppt-jam-label {
    padding-left: 0;
    padding-right: 0;
    text-align: center;
}

/* =========================================================
   MIDDLE SOAP / INSTRUKSI
   ========================================================= */
.cppt .cppt-middle-row {
    margin: 0 -5px 8px;
}

.cppt .cppt-middle-row > div {
    padding-left: 5px;
    padding-right: 5px;
}

.cppt .cppt-section-title {
    margin: 0 0 3px;
    font-size: 11px;
    font-weight: 700;
    color: #1e3a5f;
}

.cppt .cppt-big-text {
    min-height: 132px;
    resize: vertical;
    font-size: 12px;
    line-height: 1.35;
    background: #fff;
}

.cppt .cppt-instruksi-head {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 3px;
}

.cppt .cppt-check {
    margin-left: auto !important;
    margin-bottom: 0 !important;
    font-size: 11px;
    font-weight: 400 !important;
    color: #555;
}

/* =========================================================
   TABLE RIWAYAT CPPT
   ========================================================= */
.cppt .cppt-table-wrap {
    height: 260px;
    overflow-y: auto;
    overflow-x: auto;
    margin-bottom: 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    background: #fff;
}

.cppt .cppt-table {
    min-width: 1100px;
    margin: 0;
    table-layout: fixed;
    background: #fff;
    font-size: 11px;
}

.cppt .cppt-table th {
    position: sticky;
    top: 0;
    z-index: 5;
    padding: 5px;
    background: #dbeafe;
    color: #1e3a5f;
    text-align: center;
    font-weight: 700;
    vertical-align: middle;
}

.cppt .cppt-table td {
    height: 34px;
    padding: 5px;
    vertical-align: top;
}

.cppt .cppt-table tbody tr:hover {
    background: #e7f3ff;
}

.cppt .cppt-table tbody tr.active {
    background: #cfe8ff !important;
}

.cppt .cppt-pre {
    min-height: 35px;
    white-space: pre-wrap;
    word-break: break-word;
}

.cppt .cppt-empty {
    padding: 28px !important;
    text-align: center;
    color: #9ca3af;
    font-weight: 600;
}

/* =========================================================
   FOOTER: ALERGI + BUTTON
   ========================================================= */
.cppt .cppt-footer {
    display: flex;
    align-items: center;
    margin-top: 2px;
    padding-top: 8px;
    border-top: 1px solid #e5e7eb;
}

.cppt .cppt-allergy-wrap {
    display: flex;
    align-items: center;
    padding-right: 10px;
}

.cppt .cppt-allergy-group {
    width: 100%;
    margin-bottom: 0;
}

.cppt .cppt-allergy-label {
    width: 82px;
    min-width: 82px;
    height: 34px;
    padding: 6px 10px;
    line-height: 20px;
    background: #eef2f6;
    border: 1px solid #ced4da;
    color: #1e3a5f;
    font-size: 12px;
    font-weight: 600;
    text-align: left;
}

.cppt .cppt-allergy-input {
    height: 34px !important;
    background: #fff !important;
    border: 1px solid #ced4da;
    font-size: 12px;
    font-weight: 500;
}

.cppt .cppt-actions {
    white-space: nowrap;
}

.cppt .cppt-actions .btn {
    min-width: 88px;
    height: 34px;
    margin-left: 5px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
}

/* =========================================================
   RESPONSIVE
   ========================================================= */
@media (max-width: 991px) {
    .cppt .cppt-footer {
        display: block;
    }

    .cppt .cppt-allergy-wrap {
        padding-right: 15px;
        margin-bottom: 8px;
    }

    .cppt .cppt-actions {
        text-align: left;
    }

    .cppt .cppt-actions .btn {
        margin: 0 5px 5px 0;
    }
}

/* =========================================================
   PRINT MODE
   ========================================================= */
@media print {
    .breadcrumb,
    .side-nav,
    .cppt > div:first-child,
    .cppt-actions {
        display: none !important;
    }

    .cppt .cppt-main-panel {
        border: 1px solid #000;
        box-shadow: none;
    }

    .cppt .cppt-heading {
        background: #fff !important;
        color: #000 !important;
        border-bottom: 1px solid #000;
    }
}

.cppt-table td{
    vertical-align:top;
    padding:4px;
}

.cppt-cell-scroll{
    height:80px;
    overflow-y:auto;
    overflow-x:hidden;

    white-space:pre-wrap;
    word-break:break-word;
    line-height:1.35;

    display:block;
    padding:2px 4px;
}

.cppt-pre{
    margin:0;
    padding:0;
    min-height:unset;
}

/* =========================================================
   FIX CELL SCROLL - SOAP / INSTRUKSI HISTORY
   ========================================================= */
.cppt .cppt-table tbody tr {
    height: 92px !important;
}

.cppt .cppt-table td {
    height: 92px !important;
    max-height: 92px !important;
    padding: 4px !important;
    vertical-align: top !important;
    overflow: hidden !important;
}

.cppt .cppt-table td:not(.cppt-scroll-td) {
    white-space: normal;
}

.cppt .cppt-scroll-td {
    height: 92px !important;
    max-height: 92px !important;
    padding: 0 !important;
    overflow: hidden !important;
}

.cppt .cppt-cell-scroll {
    display: block !important;
    height: 92px !important;
    max-height: 92px !important;
    margin: 0 !important;
    padding: 6px 8px !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    white-space: pre-wrap !important;
    word-break: break-word !important;
    line-height: 1.35 !important;
    text-align: left !important;
    vertical-align: top !important;
}

.cppt .cppt-cell-scroll::-webkit-scrollbar {
    width: 8px;
}

.cppt .cppt-cell-scroll::-webkit-scrollbar-thumb {
    background: #9aa0a6;
    border-radius: 6px;
}

.cppt .cppt-cell-scroll::-webkit-scrollbar-track {
    background: #eef2f6;
}

</style>

<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    var isDone = <?= $isDone ? 'true' : 'false' ?>;
    var defaultDoctorName = <?= json_encode((string)($d->doctor_name ?? '')) ?>;
    var defaultNoteDate = <?= json_encode($todayInput) ?>;
    var defaultNoteTime = <?= json_encode($nowTime) ?>;
    var defaultNotedAt = <?= json_encode($nowDateTime) ?>;

    function setFormReadonly(readonly) {
        $('#cppt-note-date, #cppt-note-time, #cppt-health-worker-name, #cppt-doctor-name, #cppt-nurse-name, #cppt-assessment-text, #cppt-instruction')
            .prop('readonly', readonly || isDone);

        $('#cppt-fasting-instruction').prop('disabled', readonly || isDone);
        $('#btn-cppt-save').prop('disabled', readonly || isDone);
        $('#cppt-view-mode-info').toggle(readonly);
    }

    function clearFormForNew() {
        $('.cppt-history-row').removeClass('active');

        $('#cppt-note-date').val(defaultNoteDate);
        $('#cppt-note-time').val(defaultNoteTime);
        $('#cppt-health-worker-name').val('');
        $('#cppt-doctor-name').val(defaultDoctorName);
        $('#cppt-nurse-name').val('');
        $('#cppt-assessment-text').val('');
        $('#cppt-instruction').val('');
        $('#cppt-fasting-instruction').prop('checked', false);
        $('#cppt-noted-at').val(defaultNotedAt);

        setFormReadonly(false);
        $('#cppt-health-worker-name').focus();
    }

    $('#btn-cppt-new-top, #btn-cppt-new-bottom').on('click', function () {
        clearFormForNew();
    });

    $('.cppt-history-row').on('click', function () {
        var row = $(this);

        $('.cppt-history-row').removeClass('active');
        row.addClass('active');

        $('#cppt-note-date').val(row.data('note-date') || '');
        $('#cppt-note-time').val(row.data('note-time') || '');
        $('#cppt-health-worker-name').val(row.data('health-worker') || '');
        $('#cppt-doctor-name').val(row.data('doctor-name') || '');
        $('#cppt-nurse-name').val(row.data('nurse-name') || '');
        $('#cppt-assessment-text').val(row.data('assessment') || '');
        $('#cppt-instruction').val(row.data('instruction') || '');
        $('#cppt-fasting-instruction').prop('checked', String(row.data('fasting')) === '1');

        setFormReadonly(true);
    });
});
</script>