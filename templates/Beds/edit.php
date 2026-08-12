<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 * @var array $rooms
 * @var array $classList
 * @var array $statusList
 * @var array $activeList
 */

function fmtEditDate($val, $fmt = 'd-m-Y H:i') {
    if (empty($val)) return null;
    if ($val instanceof \Cake\I18n\FrozenTime || $val instanceof \Cake\I18n\Time) {
        return $val->format($fmt);
    }
    $ts = strtotime((string)$val);
    return $ts ? date($fmt, $ts) : null;
}

// Nama pasien saat ini (dari relasi atau kolom)
$currentPatientId   = $bed->patient_id ?? null;
$currentPatientName = '';
if (!empty($bed->patient) && !empty($bed->patient->full_name)) {
    $currentPatientName = $bed->patient->full_name;
} elseif (!empty($bed->patient_name)) {
    $currentPatientName = $bed->patient_name;
}

// Nama room saat ini
$currentRoomName = '';
if (!empty($bed->room) && !empty($bed->room->room_name)) {
    $currentRoomName = $bed->room->room_name;
} elseif (!empty($rooms[$bed->room_id ?? 0])) {
    $currentRoomName = $rooms[$bed->room_id];
}
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Edit') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-edit"></i> Edit Bed — <?= h($bed->name) ?>
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($bed) ?>

        <!-- Hidden: patient_id terpilih -->
        <?= $this->Form->hidden('patient_id', ['id' => 'edit-patient-id', 'value' => $currentPatientId ?? '']) ?>

        <!-- ═══════════════════════════════════════════════════════
             INFO READONLY — Code, Nomor TT, Room, Kelas
             (ditampilkan tapi tidak bisa diubah)
        ════════════════════════════════════════════════════════ -->
        <div style="background:#f8f9fa; border:1px solid #dee2e6; border-radius:6px;
                    padding:14px 16px; margin-bottom:18px;">
            <div style="font-size:12px; color:#6c757d; margin-bottom:10px;">
                <i class="fa fa-lock"></i>
                <strong>Informasi berikut tidak dapat diubah</strong> — diatur otomatis oleh sistem saat bed dibuat.
            </div>
            <div class="row">

                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom:8px;">
                        <label class="control-label" style="font-size:12px; color:#495057;">
                            Code Bed
                        </label>
                        <input type="text"
                               class="form-control"
                               value="<?= h($bed->code) ?>"
                               readonly
                               style="background:#e9ecef; color:#495057; cursor:not-allowed; font-weight:600;">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom:8px;">
                        <label class="control-label" style="font-size:12px; color:#495057;">
                            Nomor TT
                        </label>
                        <input type="text"
                               class="form-control"
                               value="<?= h($bed->bed_no) ?>"
                               readonly
                               style="background:#e9ecef; color:#495057; cursor:not-allowed; font-weight:600;">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom:8px;">
                        <label class="control-label" style="font-size:12px; color:#495057;">
                            Room
                        </label>
                        <input type="text"
                               class="form-control"
                               value="<?= h($currentRoomName ?: ('ID: ' . ($bed->room_id ?? '-'))) ?>"
                               readonly
                               style="background:#e9ecef; color:#495057; cursor:not-allowed;">
                        <!-- Hidden agar room_id tetap dikirim ke server (diperlukan untuk relasi) -->
                        <?= $this->Form->hidden('room_id') ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom:8px;">
                        <label class="control-label" style="font-size:12px; color:#495057;">
                            Kelas
                        </label>
                        <input type="text"
                               class="form-control"
                               value="<?= h($bed->class_name) ?>"
                               readonly
                               style="background:#e9ecef; color:#495057; cursor:not-allowed;">
                        <!-- Hidden agar class_name tetap dikirim ke server -->
                        <?= $this->Form->hidden('class_name') ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             FIELD YANG BISA DIUBAH
        ════════════════════════════════════════════════════════ -->
        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('name', [
                        'label'       => 'Nama Bed',
                        'class'       => 'form-control',
                        'placeholder' => 'Masukkan nama bed',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status', [
                        'type'    => 'select',
                        'label'   => 'Status Bed',
                        'options' => $statusList,
                        'empty'   => '-- Pilih Status --',
                        'class'   => 'form-control select2Form',
                        'id'      => 'edit-status',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('is_active', [
                        'type'    => 'select',
                        'label'   => 'Status Active',
                        'options' => $activeList,
                        'class'   => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

        </div>

        <hr>

        <!-- INFO TANGGAL OTOMATIS -->
        <?php
        $tglMasuk  = fmtEditDate($bed->check_in_date);
        $tglKeluar = fmtEditDate($bed->check_out_date);
        ?>
        <div style="margin-bottom:14px;">
            <div style="background:#f8f9fa; border:1px solid #dee2e6; border-radius:6px;
                        padding:10px 14px; font-size:12px; color:#495057;">
                <i class="fa fa-info-circle" style="color:#17a2b8;"></i>
                <strong>Tanggal Masuk &amp; Tanggal Keluar</strong> dikelola otomatis oleh sistem:
                <ul style="margin:6px 0 0 18px; padding:0;">
                    <li>Saat status diubah ke <strong>Terisi</strong> → Tanggal Masuk otomatis diisi waktu sekarang</li>
                    <li>Saat status diubah dari Terisi ke status lain → Tanggal Keluar otomatis diisi waktu sekarang</li>
                </ul>
                <?php if ($tglMasuk || $tglKeluar): ?>
                <div style="margin-top:8px; display:flex; gap:20px; flex-wrap:wrap;">
                    <?php if ($tglMasuk): ?>
                    <span>
                        <i class="fa fa-sign-in-alt" style="color:#28a745;"></i>
                        <strong>Tgl Masuk:</strong>
                        <span style="color:#155724;"><?= h($tglMasuk) ?> WIB</span>
                    </span>
                    <?php endif; ?>
                    <?php if ($tglKeluar): ?>
                    <span>
                        <i class="fa fa-sign-out-alt" style="color:#dc3545;"></i>
                        <strong>Tgl Keluar:</strong>
                        <span style="color:#721c24;"><?= h($tglKeluar) ?> WIB</span>
                    </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- SECTION PASIEN — muncul saat status = Terisi (1) -->
        <div id="section-pasien" style="<?= in_array($bed->status, [1]) ? '' : 'display:none;' ?>">
            <h5 style="color:#2c3e50; margin-bottom:14px;">
                <i class="fa fa-user"></i> Data Pasien
            </h5>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="edit-search-group"
                         style="position:relative; <?= !empty($currentPatientId) ? 'display:none;' : '' ?>">
                        <label>Cari Pasien <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" id="edit-patient-search" class="form-control"
                                   placeholder="Ketik nama / kode pasien..."
                                   autocomplete="off"
                                   value="<?= (!empty($currentPatientId) ? '' : h($currentPatientName)) ?>">
                        </div>
                        <div id="edit-patient-dropdown"
                             style="display:none; position:absolute; z-index:9999; width:100%;
                                    background:#fff; border:1px solid #ddd; border-radius:0 0 6px 6px;
                                    max-height:200px; overflow-y:auto; box-shadow:0 4px 8px rgba(0,0,0,0.1);">
                        </div>
                    </div>

                    <!-- Pasien terpilih -->
                    <div id="edit-selected-patient-box"
                         style="<?= !empty($currentPatientId) ? '' : 'display:none;' ?> margin-bottom:10px;">
                        <label>Pasien Terpilih</label>
                        <div style="background:#e9f7ef; border:1px solid #28a745; border-radius:6px;
                                    padding:8px 12px; font-size:13px; color:#155724;
                                    display:flex; align-items:center; justify-content:space-between;">
                            <span>
                                <i class="fa fa-user-check"></i>
                                <strong id="edit-selected-patient-name"><?= h($currentPatientName) ?></strong>
                            </span>
                            <button type="button" id="edit-btn-clear-patient"
                                    style="background:none; border:none; color:#dc3545;
                                           cursor:pointer; font-size:14px; padding:0;"
                                    title="Ganti pasien">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?= $this->Form->hidden('patient_name', [
                'id'    => 'edit-patient-name-hidden',
                'value' => $currentPatientName,
            ]) ?>

            <div style="background:#e8f4fd; border:1px solid #bee5eb; border-radius:6px;
                        padding:8px 12px; font-size:12px; color:#0c5460; margin-bottom:10px;">
                <i class="fa fa-magic"></i>
                <strong>Catatan</strong> akan diisi otomatis oleh sistem:
                <em>"Pasien [nama] masuk pada [tanggal jam] WIB"</em>
            </div>

            <hr>
        </div>

        <!-- SECTION TERSEDIA -->
        <div id="section-tersedia" style="<?= (int)$bed->status === 0 ? '' : 'display:none;' ?>">
            <div style="background:#e9f7ef; border:1px solid #28a745; border-radius:6px;
                        padding:8px 12px; font-size:12px; color:#155724; margin-bottom:14px;">
                <i class="fa fa-magic"></i>
                <strong>Catatan</strong> akan diisi otomatis oleh sistem:
                <em>"Bed tersedia sejak [tanggal jam] WIB"</em>
                (atau <em>"Pasien [nama] keluar pada [tanggal jam] WIB"</em> jika sebelumnya Terisi)
            </div>
            <hr>
        </div>

        <!-- SECTION CATATAN MANUAL — Dibersihkan (2) / Maintenance (3) -->
        <div id="section-notes" style="<?= in_array($bed->status, [2, 3]) ? '' : 'display:none;' ?>">
            <h5 style="color:#856404; margin-bottom:14px;">
                <i class="fa fa-clipboard"></i> Catatan Status
            </h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Catatan <span class="text-danger">*</span></label>
                        <?= $this->Form->textarea('notes', [
                            'class'       => 'form-control',
                            'rows'        => 2,
                            'placeholder' => 'Contoh: Sedang dibersihkan oleh petugas / Kerusakan pada...',
                            'value'       => $bed->notes ?? '',
                            'id'          => 'edit-notes',
                        ]) ?>
                    </div>
                </div>
            </div>
            <hr>
        </div>

        <div class="text-right">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default', 'escape' => false]
            ) ?>
            <?= $this->Form->button(
                '<i class="fa fa-save"></i> Simpan',
                ['class' => 'btn btn-success', 'escapeTitle' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

<style>
#edit-patient-dropdown .patient-item {
    padding: 8px 12px;
    cursor: pointer;
    font-size: 13px;
    border-bottom: 1px solid #f0f0f0;
}
#edit-patient-dropdown .patient-item:hover { background: #e9f7ef; }
#edit-patient-dropdown .patient-item:last-child { border-bottom: none; }
#edit-patient-dropdown .patient-empty {
    padding: 10px 12px;
    font-size: 12px;
    color: #999;
    text-align: center;
}
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

function toggleSection(val) {
    val = parseInt(val);
    if (val === 1) {
        $('#section-pasien').slideDown(200);
        $('#section-tersedia').slideUp(200);
        $('#section-notes').slideUp(200);
    } else if (val === 0) {
        $('#section-pasien').slideUp(200);
        $('#section-tersedia').slideDown(200);
        $('#section-notes').slideUp(200);
        editClearSelectedPatient();
    } else if (val === 2 || val === 3) {
        $('#section-pasien').slideUp(200);
        $('#section-tersedia').slideUp(200);
        $('#section-notes').slideDown(200);
        editClearSelectedPatient();
    } else {
        $('#section-pasien').slideUp(200);
        $('#section-tersedia').slideUp(200);
        $('#section-notes').slideUp(200);
        editClearSelectedPatient();
    }
}

$(document).ready(function () {

    $('.select2Form').select2({
        width: '100%',
        minimumResultsForSearch: 0
    });

    $('#edit-status').on('change', function () {
        toggleSection($(this).val());
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
                url:      SEARCH_PATIENT_URL,
                method:   'GET',
                data:     { q: q },
                dataType: 'json',
                success: function (res) {
                    var html = '';
                    if (res.patients && res.patients.length > 0) {
                        $.each(res.patients, function (i, p) {
                            html += '<div class="patient-item"'
                                  + ' data-id="'   + p.id + '"'
                                  + ' data-name="' + $('<div>').text(p.full_name).html() + '">'
                                  + '<strong>' + $('<div>').text(p.full_name).html() + '</strong>'
                                  + ' <span style="color:#888;font-size:11px;">('
                                  + $('<div>').text(p.code).html() + ')</span>'
                                  + '</div>';
                        });
                    } else {
                        html = '<div class="patient-empty">'
                             + '<i class="fa fa-info-circle"></i> Pasien tidak ditemukan</div>';
                    }
                    $('#edit-patient-dropdown').html(html).show();
                },
                error: function () {
                    $('#edit-patient-dropdown')
                        .html('<div class="patient-empty"><i class="fa fa-exclamation-circle"></i> Gagal mencari pasien</div>')
                        .show();
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