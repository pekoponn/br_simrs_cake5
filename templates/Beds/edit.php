<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 * @var array $rooms
 * @var array $classList
 * @var array $statusList
 * @var array $activeList
 */

$fmtDate = function ($value, string $format = 'd-m-Y H:i') {
    if (empty($value)) {
        return null;
    }
    if ($value instanceof \Cake\I18n\FrozenTime || $value instanceof \Cake\I18n\Time) {
        return $value->format($format);
    }
    $timestamp = strtotime((string)$value);

    return $timestamp ? date($format, $timestamp) : null;
};

$currentPatientId = $bed->patient_id ?? null;
$currentPatientName = '';
if (!empty($bed->patient) && !empty($bed->patient->full_name)) {
    $currentPatientName = $bed->patient->full_name;
} elseif (!empty($bed->patient_name)) {
    $currentPatientName = $bed->patient_name;
}

$checkInDate = $fmtDate($bed->check_in_date ?? null);
$checkOutDate = $fmtDate($bed->check_out_date ?? null);
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Edit') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-edit"></i> Edit Bed - <?= h($bed->name) ?></h4>
    </div>

    <div class="panel-body">
        <?= $this->Form->create($bed) ?>
        <?= $this->Form->hidden('patient_id', ['id' => 'edit-patient-id', 'value' => $currentPatientId ?? '']) ?>
        <?= $this->Form->hidden('patient_name', ['id' => 'edit-patient-name-hidden', 'value' => $currentPatientName]) ?>

        <div class="row">
            <div class="col-md-6">
                <?= $this->Form->control('code', [
                    'label' => 'Code Bed',
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan code bed',
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $this->Form->control('room_id', [
                    'label' => 'Room',
                    'options' => $rooms,
                    'empty' => '-- Pilih Room --',
                    'class' => 'form-control',
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $this->Form->control('bed_no', [
                    'label' => 'Nomor TT',
                    'class' => 'form-control',
                    'placeholder' => 'Contoh: TT01',
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $this->Form->control('name', [
                    'label' => 'Nama Bed',
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan nama bed',
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $this->Form->control('class_name', [
                    'type' => 'select',
                    'label' => 'Class',
                    'options' => $classList,
                    'empty' => '-- Pilih Class --',
                    'class' => 'form-control',
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $this->Form->control('status', [
                    'type' => 'select',
                    'label' => 'Status Bed',
                    'options' => $statusList,
                    'empty' => '-- Pilih Status --',
                    'class' => 'form-control',
                    'id' => 'edit-status',
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $this->Form->control('is_active', [
                    'type' => 'select',
                    'label' => 'Status Active',
                    'options' => $activeList,
                    'class' => 'form-control',
                ]) ?>
            </div>
        </div>

        <hr>

        <div class="bed-info-box bed-info-muted">
            <i class="fa fa-info-circle"></i>
            <strong>Tanggal masuk dan keluar dikelola otomatis.</strong>
            Status Terisi mengisi tanggal masuk, perubahan dari Terisi ke status lain mengisi tanggal keluar.
            <?php if ($checkInDate || $checkOutDate): ?>
                <div class="bed-date-row">
                    <?php if ($checkInDate): ?>
                        <span><i class="fa fa-sign-in-alt"></i> <strong>Tgl Masuk:</strong> <?= h($checkInDate) ?> WIB</span>
                    <?php endif; ?>
                    <?php if ($checkOutDate): ?>
                        <span><i class="fa fa-sign-out-alt"></i> <strong>Tgl Keluar:</strong> <?= h($checkOutDate) ?> WIB</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div id="section-pasien" style="<?= (int)$bed->status === 1 ? '' : 'display:none;' ?>">
            <h5><i class="fa fa-user"></i> Data Pasien</h5>

            <div id="edit-search-group" class="form-group bed-search-group" style="<?= !empty($currentPatientId) ? 'display:none;' : '' ?>">
                <label>Cari Pasien <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" id="edit-patient-search" class="form-control" placeholder="Ketik nama / kode pasien..." autocomplete="off">
                </div>
                <div id="edit-patient-dropdown" class="bed-patient-dropdown"></div>
            </div>

            <div id="edit-selected-patient-box" style="<?= !empty($currentPatientName) ? '' : 'display:none;' ?>">
                <label>Pasien Terpilih</label>
                <div class="bed-selected-patient">
                    <span><i class="fa fa-user-check"></i> <strong id="edit-selected-patient-name"><?= h($currentPatientName) ?></strong></span>
                    <button type="button" id="edit-btn-clear-patient" title="Ganti pasien"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="bed-info-box bed-info-blue">
                <i class="fa fa-magic"></i>
                Catatan akan diisi otomatis saat status Terisi.
            </div>
            <hr>
        </div>

        <div id="section-tersedia" style="<?= (int)$bed->status === 0 ? '' : 'display:none;' ?>">
            <div class="bed-info-box bed-info-green">
                <i class="fa fa-magic"></i>
                Catatan akan diisi otomatis saat bed tersedia.
            </div>
            <hr>
        </div>

        <div id="section-notes" style="<?= in_array((int)$bed->status, [2, 3], true) ? '' : 'display:none;' ?>">
            <h5><i class="fa fa-clipboard"></i> Catatan Status</h5>
            <div class="form-group">
                <label>Catatan <span class="text-danger">*</span></label>
                <?= $this->Form->textarea('notes', [
                    'class' => 'form-control',
                    'rows' => 2,
                    'placeholder' => 'Contoh: sedang dibersihkan oleh petugas / kerusakan pada bed.',
                    'value' => $bed->notes ?? '',
                    'id' => 'edit-notes',
                ]) ?>
            </div>
            <hr>
        </div>

        <div class="text-right">
            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> Kembali', ['action' => 'index'], [
                'class' => 'btn btn-default',
                'escape' => false,
            ]) ?>
            <?= $this->Form->button('<i class="fa fa-save"></i> Simpan', [
                'class' => 'btn btn-success',
                'escapeTitle' => false,
            ]) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<style>
.bed-info-box { margin-bottom:14px; border-radius:6px; padding:10px 14px; font-size:12px; }
.bed-info-muted { background:#f8f9fa; border:1px solid #dee2e6; color:#495057; }
.bed-info-blue { background:#e8f4fd; border:1px solid #bee5eb; color:#0c5460; }
.bed-info-green { background:#e9f7ef; border:1px solid #28a745; color:#155724; }
.bed-date-row { margin-top:8px; display:flex; gap:20px; flex-wrap:wrap; }
.bed-search-group { position:relative; }
.bed-patient-dropdown { display:none; position:absolute; z-index:9999; width:100%; background:#fff; border:1px solid #ddd; border-radius:0 0 6px 6px; max-height:200px; overflow-y:auto; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
.bed-patient-dropdown .patient-item { padding:8px 12px; cursor:pointer; font-size:13px; border-bottom:1px solid #f0f0f0; }
.bed-patient-dropdown .patient-item:hover { background:#e9f7ef; }
.bed-patient-dropdown .patient-empty { padding:10px 12px; font-size:12px; color:#999; text-align:center; }
.bed-selected-patient { background:#e9f7ef; border:1px solid #28a745; border-radius:6px; padding:8px 12px; font-size:13px; color:#155724; display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
.bed-selected-patient button { background:none; border:none; color:#dc3545; cursor:pointer; font-size:14px; padding:0; }
</style>

<script>
var SEARCH_PATIENT_URL = '<?= $this->Url->build(['action' => 'searchPatients']) ?>';
var editSearchTimer = null;

function editSetSelectedPatient(id, name) {
    $('#edit-patient-id').val(id);
    $('#edit-patient-name-hidden').val(name);
    $('#edit-selected-patient-name').text(name);
    $('#edit-selected-patient-box').show();
    $('#edit-search-group').hide();
    $('#edit-patient-dropdown').hide();
    $('#edit-patient-search').val('');
}

function editClearSelectedPatient() {
    $('#edit-patient-id').val('');
    $('#edit-patient-name-hidden').val('');
    $('#edit-selected-patient-name').text('');
    $('#edit-selected-patient-box').hide();
    $('#edit-search-group').show();
    $('#edit-patient-dropdown').hide();
    $('#edit-patient-search').val('').focus();
}

function toggleEditSection(value) {
    value = parseInt(value, 10);
    if (value === 1) {
        $('#section-pasien').slideDown(200);
        $('#section-tersedia').slideUp(200);
        $('#section-notes').slideUp(200);
    } else if (value === 0) {
        $('#section-pasien').slideUp(200);
        $('#section-tersedia').slideDown(200);
        $('#section-notes').slideUp(200);
        editClearSelectedPatient();
    } else if (value === 2 || value === 3) {
        $('#section-pasien').slideUp(200);
        $('#section-tersedia').slideUp(200);
        $('#section-notes').slideDown(200);
        editClearSelectedPatient();
    } else {
        $('#section-pasien, #section-tersedia, #section-notes').slideUp(200);
        editClearSelectedPatient();
    }
}

$(function () {
    $('#edit-status').on('change', function () {
        toggleEditSection($(this).val());
    });

    $('#edit-patient-search').on('input', function () {
        var q = $(this).val().trim();
        clearTimeout(editSearchTimer);

        if (q.length < 2) {
            $('#edit-patient-dropdown').hide();
            return;
        }

        editSearchTimer = setTimeout(function () {
            $.ajax({
                url: SEARCH_PATIENT_URL,
                method: 'GET',
                data: { q: q },
                dataType: 'json',
                success: function (res) {
                    var html = '';
                    if (res.patients && res.patients.length) {
                        $.each(res.patients, function (i, patient) {
                            html += '<div class="patient-item" data-id="' + patient.id + '" data-name="' + $('<div>').text(patient.full_name).html() + '">'
                                + '<strong>' + $('<div>').text(patient.full_name).html() + '</strong>'
                                + ' <span style="color:#888;font-size:11px;">(' + $('<div>').text(patient.code).html() + ')</span>'
                                + '</div>';
                        });
                    } else {
                        html = '<div class="patient-empty">Pasien tidak ditemukan</div>';
                    }
                    $('#edit-patient-dropdown').html(html).show();
                },
                error: function () {
                    $('#edit-patient-dropdown').html('<div class="patient-empty">Gagal mencari pasien</div>').show();
                }
            });
        }, 300);
    });

    $(document).on('click', '#edit-patient-dropdown .patient-item', function () {
        editSetSelectedPatient($(this).data('id'), $(this).data('name'));
    });

    $(document).on('click', '#edit-btn-clear-patient', function () {
        editClearSelectedPatient();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#edit-search-group').length) {
            $('#edit-patient-dropdown').hide();
        }
    });
});
</script>
