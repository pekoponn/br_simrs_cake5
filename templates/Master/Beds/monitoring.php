<?php

/**
 * @var \App\View\AppView $this
 * @var array $grouped
 * @var array $statusLabel
 */

$statusColor = [
    0 => ['bg' => '#e9f7ef', 'border' => '#28a745', 'text' => '#155724', 'icon' => 'fa-check-circle', 'label' => 'Tersedia'],
    1 => ['bg' => '#fde8ea', 'border' => '#dc3545', 'text' => '#721c24', 'icon' => 'fa-user-injured', 'label' => 'Terisi'],
    2 => ['bg' => '#fff8e1', 'border' => '#ffc107', 'text' => '#856404', 'icon' => 'fa-broom', 'label' => 'Dibersihkan'],
    3 => ['bg' => '#f0f0f0', 'border' => '#6c757d', 'text' => '#383d41', 'icon' => 'fa-tools', 'label' => 'Maintenance'],
];

$totalAll = 0;
$totalByStatus = [0 => 0, 1 => 0, 2 => 0, 3 => 0];
foreach ($grouped as $roomBeds) {
    foreach ($roomBeds as $bed) {
        $totalAll++;
        $status = (int)$bed->status;
        if (!isset($totalByStatus[$status])) {
            $totalByStatus[$status] = 0;
        }
        $totalByStatus[$status]++;
    }
}

$fmtDate = function ($value, string $format = 'd/m/Y') {
    if (empty($value)) {
        return '';
    }
    if ($value instanceof \Cake\I18n\FrozenTime || $value instanceof \Cake\I18n\Time) {
        return $value->format($format);
    }
    $timestamp = strtotime((string)$value);

    return $timestamp ? date($format, $timestamp) : '';
};
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Monitoring') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-desktop"></i> Monitoring Bed Realtime
            <span class="bed-live-badge"><span id="live-dot"></span> Live</span>
        </h4>
        <div class="panel-heading-btn">
            <?= $this->Html->link('<i class="fa fa-list"></i> Tabel', ['action' => 'index'], [
                'class' => 'btn btn-xs btn-default',
                'escape' => false,
            ]) ?>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="row bed-summary-row">
            <div class="col-xs-6 col-md-3">
                <div class="bed-summary-card bed-total-card">
                    <div class="bed-summary-number"><?= h($totalAll) ?></div>
                    <div class="bed-summary-label">Total Bed</div>
                </div>
            </div>

            <?php foreach ($totalByStatus as $status => $count): ?>
                <?php $style = $statusColor[$status] ?? $statusColor[0]; ?>
                <div class="col-xs-6 col-md-3">
                    <div class="bed-summary-card" style="background:<?= $style['bg'] ?>; border-left-color:<?= $style['border'] ?>;">
                        <div class="bed-summary-number" style="color:<?= $style['text'] ?>;"><?= h($count) ?></div>
                        <div class="bed-summary-label" style="color:<?= $style['text'] ?>;">
                            <i class="fa <?= $style['icon'] ?>"></i> <?= h($style['label']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($grouped)): ?>
            <p class="bed-empty-monitoring">
                <i class="fa fa-inbox fa-2x"></i>
                <span>Belum ada bed aktif untuk dimonitor.</span>
            </p>
        <?php endif; ?>

        <?php foreach ($grouped as $roomName => $beds): ?>
            <div class="bed-room-section">
                <h5 class="bed-room-title">
                    <i class="fa fa-door-open"></i>
                    <?= h($roomName) ?>
                    <span><?= count($beds) ?> bed</span>
                </h5>

                <div class="bed-card-grid">
                    <?php foreach ($beds as $bed): ?>
                        <?php
                        $style = $statusColor[(int)$bed->status] ?? $statusColor[0];
                        $patientName = '';
                        if (!empty($bed->patient) && !empty($bed->patient->full_name)) {
                            $patientName = $bed->patient->full_name;
                        } elseif (!empty($bed->patient_name)) {
                            $patientName = $bed->patient_name;
                        }
                        ?>
                        <button type="button"
                            class="bed-monitor-card"
                            style="background:<?= $style['bg'] ?>; border-color:<?= $style['border'] ?>; color:<?= $style['text'] ?>;"
                            data-id="<?= h($bed->id) ?>"
                            data-status="<?= (int)$bed->status ?>"
                            data-patient-id="<?= (int)($bed->patient_id ?? 0) ?>"
                            data-patient-name="<?= h($patientName) ?>">
                            <span class="bed-monitor-icon"><i class="fa <?= $style['icon'] ?>"></i></span>
                            <strong><?= h($bed->bed_no) ?></strong>
                            <small><?= h($bed->name) ?></small>
                            <span class="bed-monitor-status"><?= h($style['label']) ?></span>
                            <?php if ($patientName): ?>
                                <em><i class="fa fa-user"></i> <?= h($patientName) ?></em>
                            <?php endif; ?>
                            <?php if (!empty($bed->check_in_date)): ?>
                                <small>Masuk: <?= h($fmtDate($bed->check_in_date)) ?></small>
                            <?php endif; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="modalStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-exchange-alt"></i> Update Status Bed</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal-bed-id">

                <div class="form-group">
                    <label>Status Bed <span class="text-danger">*</span></label>
                    <select id="modal-status" class="form-control">
                        <?php foreach ($statusColor as $value => $style): ?>
                            <option value="<?= h($value) ?>"><?= h($style['label']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="modal-section-pasien">
                    <hr>
                    <p class="bed-modal-title"><i class="fa fa-user"></i> Pilih Pasien</p>
                    <div class="form-group bed-search-group">
                        <label>Cari Pasien <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" id="modal-patient-search" class="form-control" placeholder="Ketik nama / kode pasien..." autocomplete="off">
                        </div>
                        <div id="patient-dropdown" class="bed-patient-dropdown"></div>
                        <input type="hidden" id="modal-patient-id">
                    </div>
                    <div id="selected-patient-box" style="display:none;">
                        <div class="bed-selected-patient">
                            <span><i class="fa fa-user-check"></i> <strong id="selected-patient-name"></strong></span>
                            <button type="button" id="btn-clear-patient" title="Ganti pasien"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>

                <div id="modal-section-notes-manual">
                    <hr>
                    <p class="bed-modal-title"><i class="fa fa-clipboard"></i> Catatan Status <span class="text-danger">*</span></p>
                    <textarea id="modal-notes" class="form-control" rows="2" placeholder="Contoh: sedang dibersihkan / maintenance."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-save-status"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.35} }
.bed-live-badge { display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:400; color:#28a745; background:#e9f7ef; border-radius:20px; padding:2px 10px; margin-left:10px; vertical-align:middle; }
#live-dot { width:8px; height:8px; background:#28a745; border-radius:50%; display:inline-block; animation:pulse 1.5s infinite; }
.bed-summary-row { margin-bottom:20px; }
.bed-summary-row > div { margin-bottom:10px; }
.bed-summary-card { border-radius:8px; padding:14px 18px; border-left:4px solid #6c757d; text-align:center; min-height:86px; }
.bed-total-card { background:#f8f9fa; }
.bed-summary-number { font-size:28px; font-weight:700; color:#2c3e50; line-height:1.2; }
.bed-summary-label { font-size:12px; color:#6c757d; }
.bed-room-section { margin-bottom:24px; }
.bed-room-title { background:#2c3e50; color:#fff; padding:8px 16px; border-radius:8px; margin-bottom:12px; font-size:14px; }
.bed-room-title span { float:right; font-size:12px; font-weight:400; }
.bed-card-grid { display:flex; flex-wrap:wrap; gap:12px; }
.bed-monitor-card { border:2px solid; border-radius:8px; padding:14px 16px; width:160px; min-height:150px; cursor:pointer; transition:transform 0.15s, box-shadow 0.15s; text-align:center; }
.bed-monitor-card:hover { transform:scale(1.03); box-shadow:0 4px 10px rgba(0,0,0,0.12); }
.bed-monitor-card strong, .bed-monitor-card small, .bed-monitor-card em, .bed-monitor-card span { display:block; }
.bed-monitor-icon { font-size:22px; margin-bottom:6px; }
.bed-monitor-card strong { font-size:14px; margin-bottom:4px; }
.bed-monitor-card small { font-size:11px; opacity:0.85; margin-bottom:4px; }
.bed-monitor-card em { font-size:11px; margin-top:6px; opacity:0.9; font-style:italic; overflow-wrap:anywhere; }
.bed-monitor-status { font-size:11px; font-weight:600; background:rgba(255,255,255,0.5); border-radius:20px; padding:2px 8px; margin-top:6px; }
.bed-empty-monitoring { color:#6c757d; text-align:center; padding:20px; }
.bed-empty-monitoring i { display:block; margin-bottom:8px; }
.bed-modal-title { font-weight:600; margin-bottom:10px; }
.bed-search-group { position:relative; }
.bed-patient-dropdown { display:none; position:absolute; z-index:9999; width:100%; background:#fff; border:1px solid #ddd; border-radius:0 0 6px 6px; max-height:200px; overflow-y:auto; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
.bed-patient-dropdown .patient-item { padding:8px 12px; cursor:pointer; font-size:13px; border-bottom:1px solid #f0f0f0; }
.bed-patient-dropdown .patient-item:hover { background:#e9f7ef; }
.bed-patient-dropdown .patient-empty { padding:10px 12px; font-size:12px; color:#999; text-align:center; }
.bed-selected-patient { background:#e9f7ef; border:1px solid #28a745; border-radius:6px; padding:8px 12px; font-size:13px; color:#155724; display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
.bed-selected-patient button { background:none; border:none; color:#dc3545; cursor:pointer; font-size:14px; padding:0; }
</style>

<script>
var UPDATE_URL = '<?= $this->Url->build(['action' => 'updateStatus']) ?>';
var SEARCH_PATIENT_URL = '<?= $this->Url->build(['action' => 'searchPatients']) ?>';
var searchTimer = null;

function getCsrfToken() {
    var meta = $('meta[name="csrfToken"]').attr('content');
    if (meta) return meta;
    var input = $('input[name="_csrfToken"]').first().val();
    if (input) return input;
    return '';
}

$.ajaxSetup({
    beforeSend: function (xhr) {
        var token = getCsrfToken();
        if (token) {
            xhr.setRequestHeader('X-CSRF-Token', token);
        }
    }
});

function toggleModalSection(value) {
    value = parseInt(value, 10);
    $('#modal-section-pasien, #modal-section-notes-manual').hide();
    if (value === 1) {
        $('#modal-section-pasien').slideDown(150);
    } else if (value === 2 || value === 3) {
        $('#modal-section-notes-manual').slideDown(150);
    }
}

function setSelectedPatient(id, name) {
    $('#modal-patient-id').val(id);
    $('#selected-patient-name').text(name);
    $('#selected-patient-box').show();
    $('#modal-patient-search').val('').closest('.form-group').hide();
    $('#patient-dropdown').hide();
}

function clearSelectedPatient() {
    $('#modal-patient-id').val('');
    $('#selected-patient-name').text('');
    $('#selected-patient-box').hide();
    $('#modal-patient-search').val('').closest('.form-group').show();
    $('#patient-dropdown').hide();
}

$(function () {
    $('.bed-monitor-card').on('click', function () {
        var status = parseInt($(this).data('status'), 10);
        var patientId = parseInt($(this).data('patient-id') || 0, 10);
        var patientName = $(this).data('patient-name') || '';

        $('#modal-bed-id').val($(this).data('id'));
        $('#modal-status').val(status);
        $('#modal-notes').val('');
        clearSelectedPatient();

        if (status === 1 && patientId > 0) {
            setSelectedPatient(patientId, patientName);
        } else if (status === 1 && patientName) {
            $('#modal-patient-search').val(patientName);
        }

        toggleModalSection(status);
        $('#btn-save-status').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
        $('#modalStatus').modal('show');
    });

    $('#modal-status').on('change', function () {
        toggleModalSection($(this).val());
        if (parseInt($(this).val(), 10) !== 1) {
            clearSelectedPatient();
        }
    });

    $('#modal-patient-search').on('input', function () {
        var q = $(this).val().trim();
        clearTimeout(searchTimer);
        if (q.length < 2) {
            $('#patient-dropdown').hide();
            return;
        }
        searchTimer = setTimeout(function () {
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
                    $('#patient-dropdown').html(html).show();
                },
                error: function () {
                    $('#patient-dropdown').html('<div class="patient-empty">Gagal mencari pasien</div>').show();
                }
            });
        }, 300);
    });

    $(document).on('click', '#patient-dropdown .patient-item', function () {
        setSelectedPatient($(this).data('id'), $(this).data('name'));
    });

    $(document).on('click', '#btn-clear-patient', function () {
        clearSelectedPatient();
    });

    $('#btn-save-status').on('click', function () {
        var bedId = $('#modal-bed-id').val();
        var statusValue = parseInt($('#modal-status').val(), 10);
        var csrfToken = getCsrfToken();
        var postData = { status: statusValue };

        if (csrfToken) {
            postData._csrfToken = csrfToken;
        }
        if (statusValue === 1) {
            postData.patient_id = $('#modal-patient-id').val();
            postData.patient_name = $('#selected-patient-name').text() || $('#modal-patient-search').val();
        } else if (statusValue === 2 || statusValue === 3) {
            postData.notes = $('#modal-notes').val();
        }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: UPDATE_URL + '/' + bedId,
            method: 'POST',
            data: postData,
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $('#modalStatus').modal('hide');
                    location.reload();
                } else {
                    alert(res.message || 'Gagal menyimpan.');
                    $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
                }
            },
            error: function () {
                alert('Terjadi kesalahan. Refresh halaman lalu coba lagi.');
                $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
            }
        });
    });

    setInterval(function () {
        location.reload();
    }, 20000);
});
</script>
