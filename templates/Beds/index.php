<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed[]|\Cake\Collection\CollectionInterface $beds
 * @var array $rooms
 * @var array $classList
 * @var array $statusList
 * @var array $statusLabel
 */

$statusColor = [
    0 => ['bg' => '#e9f7ef', 'border' => '#28a745', 'text' => '#155724', 'icon' => 'fa-check-circle', 'label' => 'Tersedia'],
    1 => ['bg' => '#fde8ea', 'border' => '#dc3545', 'text' => '#721c24', 'icon' => 'fa-user-injured', 'label' => 'Terisi'],
    2 => ['bg' => '#fff8e1', 'border' => '#ffc107', 'text' => '#856404', 'icon' => 'fa-broom', 'label' => 'Dibersihkan'],
    3 => ['bg' => '#f0f0f0', 'border' => '#6c757d', 'text' => '#383d41', 'icon' => 'fa-tools', 'label' => 'Maintenance'],
];

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

$resolvePatientName = function ($bed) {
    if (!empty($bed->patient) && !empty($bed->patient->full_name)) {
        return [$bed->patient->full_name, false];
    }
    if (!empty($bed->patient_name)) {
        return [$bed->patient_name, false];
    }
    if (!empty($bed->bed_histories)) {
        foreach ($bed->bed_histories as $history) {
            if ((int)$history->status_after === 1 && !empty($history->patient_name)) {
                return [$history->patient_name, true];
            }
        }
    }

    return ['', false];
};
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Tampilkan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-bed"></i> Data Bed Management</h4>
        <div class="panel-heading-btn">
            <?= $this->Html->link('<i class="fa fa-desktop"></i> Monitoring', ['action' => 'monitoring'], [
                'class' => 'btn btn-xs btn-success',
                'escape' => false,
            ]) ?>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="row m-b-10 align-items-end">
            <div class="col-md-6 bed-toolbar-left">
                <?= $this->Html->link('<i class="fa fa-plus"></i> Tambah', ['action' => 'add'], [
                    'class' => 'btn btn-inverse btn-sm',
                    'escape' => false,
                ]) ?>

                <div class="btn-group btn-group-sm">
                    <?php
                    $filterStatus = [
                        '' => ['label' => 'Semua', 'class' => 'btn-default'],
                        '0' => ['label' => 'Tersedia', 'class' => 'btn-success'],
                        '1' => ['label' => 'Terisi', 'class' => 'btn-danger'],
                        '2' => ['label' => 'Dibersihkan', 'class' => 'btn-warning'],
                        '3' => ['label' => 'Maintenance', 'class' => 'btn-default'],
                    ];
                    $currentStatus = $this->request->getQuery('status', '');
                    foreach ($filterStatus as $value => $option):
                        $active = (string)$currentStatus === (string)$value ? 'active' : '';
                    ?>
                        <a href="<?= $this->Url->build(['action' => 'index', '?' => [
                            'status' => $value,
                            'key' => $this->request->getQuery('key'),
                            'room_id' => $this->request->getQuery('room_id'),
                            'class_name' => $this->request->getQuery('class_name'),
                        ]]) ?>" class="btn <?= $option['class'] ?> <?= $active ?>">
                            <?= h($option['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-6">
                <?= $this->Form->create(null, ['type' => 'get']) ?>
                <div class="input-group pull-right bed-search-bar">
                    <select name="room_id" class="form-control">
                        <option value="">Semua Room</option>
                        <?php foreach ($rooms as $roomId => $roomName): ?>
                            <option value="<?= h($roomId) ?>" <?= $this->request->getQuery('room_id') == $roomId ? 'selected' : '' ?>>
                                <?= h($roomName) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="key" class="form-control" placeholder="Cari kode / nama / pasien..." value="<?= h($this->request->getQuery('key')) ?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-default" title="Reset">
                            <i class="fa fa-rotate-left"></i>
                        </a>
                    </span>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-beds">
                <thead>
                    <tr class="text-center">
                        <th width="40">#</th>
                        <th width="90">Code</th>
                        <th width="130">Room</th>
                        <th width="70">No TT</th>
                        <th>Nama Bed</th>
                        <th width="90">Class</th>
                        <th width="120">Status</th>
                        <th width="130">Tgl Masuk</th>
                        <th width="130">Tgl Keluar</th>
                        <th width="160">Pasien</th>
                        <th width="70">Active</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($beds as $bed): ?>
                        <?php
                        $status = $statusColor[(int)$bed->status] ?? $statusColor[0];
                        [$patientName, $fromHistory] = $resolvePatientName($bed);
                        $checkInDate = $fmtDate($bed->check_in_date ?? null, 'd-m-Y');
                        $checkInTime = $fmtDate($bed->check_in_date ?? null, 'H:i');
                        $checkOutDate = $fmtDate($bed->check_out_date ?? null, 'd-m-Y');
                        $checkOutTime = $fmtDate($bed->check_out_date ?? null, 'H:i');
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><code><?= h($bed->code) ?></code></td>
                            <td><?= h($bed->room->room_name ?? '-') ?></td>
                            <td class="text-center"><strong><?= h($bed->bed_no) ?></strong></td>
                            <td><?= h($bed->name) ?></td>
                            <td class="text-center"><span class="bed-class-pill"><?= h($bed->class_name) ?></span></td>
                            <td class="text-center">
                                <span class="bed-status-pill" style="background:<?= $status['bg'] ?>; color:<?= $status['text'] ?>; border-color:<?= $status['border'] ?>;">
                                    <i class="fa <?= $status['icon'] ?>"></i> <?= h($status['label']) ?>
                                </span>
                            </td>
                            <td class="text-center bed-date-cell">
                                <?php if ($checkInDate): ?>
                                    <strong><?= h($checkInDate) ?></strong><br>
                                    <small><?= h($checkInTime) ?> WIB</small>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center bed-date-cell">
                                <?php if ($checkOutDate): ?>
                                    <strong><?= h($checkOutDate) ?></strong><br>
                                    <small><?= h($checkOutTime) ?> WIB</small>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="bed-patient-cell">
                                <?php if ($patientName): ?>
                                    <i class="fa fa-user" style="color:<?= $fromHistory ? '#6c757d' : '#dc3545' ?>;"></i>
                                    <?= h($patientName) ?>
                                    <?php if ($fromHistory): ?>
                                        <small>(terakhir)</small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?= $bed->is_active === 'Y' ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Non</span>' ?>
                            </td>
                            <td class="text-center">
                                <div class="bed-action-row">
                                    <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $bed->id], [
                                        'escape' => false,
                                        'class' => 'btn btn-info btn-xs',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Detail',
                                    ]) ?>
                                    <?= $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $bed->id], [
                                        'escape' => false,
                                        'class' => 'btn btn-warning btn-xs',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Edit',
                                    ]) ?>
                                    <button type="button"
                                        class="btn btn-success btn-xs btn-update-status"
                                        data-toggle="tooltip"
                                        title="Update Status"
                                        data-id="<?= h($bed->id) ?>"
                                        data-status="<?= (int)$bed->status ?>"
                                        data-patient-id="<?= (int)($bed->patient_id ?? 0) ?>"
                                        data-patient-name="<?= h($patientName) ?>"
                                        data-notes="<?= h($bed->notes ?? '') ?>">
                                        <i class="fa fa-exchange-alt"></i>
                                    </button>
                                    <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $bed->id], [
                                        'escape' => false,
                                        'class' => 'btn btn-danger btn-xs',
                                        'confirm' => __('Yakin hapus bed {0}?', $bed->name),
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Hapus',
                                    ]) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?= $this->Krs->paginators() ?>
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
                        <?php foreach ($statusList as $value => $label): ?>
                            <option value="<?= h($value) ?>"><?= h($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="modal-info-auto-terisi" class="bed-modal-info bed-info-blue">
                    <i class="fa fa-magic"></i> Catatan dan tanggal masuk akan diisi otomatis oleh sistem.
                </div>

                <div id="modal-info-auto-tersedia" class="bed-modal-info bed-info-green">
                    <i class="fa fa-magic"></i> Catatan akan diisi otomatis oleh sistem.
                    <div id="modal-info-checkout" class="bed-modal-subinfo">
                        <i class="fa fa-clock"></i> Tanggal keluar akan otomatis diisi saat disimpan.
                    </div>
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
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                <button type="button" class="btn btn-primary" id="btn-save-status"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<style>
.bed-toolbar-left { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
.bed-search-bar { max-width:440px; width:100%; }
.bed-search-bar select { width:140px; flex:none; }
.table-beds { font-size:13px; }
.table-beds > thead > tr > th { background:#2c3e50 !important; color:#fff !important; border-color:#3d5166 !important; padding:10px 8px; vertical-align:middle; font-size:12px; font-weight:600; }
.bed-class-pill { background:#e9ecef; padding:2px 8px; border-radius:12px; font-size:11px; font-weight:600; }
.bed-status-pill { border:1px solid; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
.bed-date-cell { font-size:11px; color:#495057; }
.bed-date-cell small { color:#888; font-size:10px; }
.bed-patient-cell { font-size:12px; }
.bed-patient-cell small { color:#888; font-style:italic; }
.bed-action-row { display:flex; gap:3px; justify-content:center; }
.btn-xs { padding:3px 8px; font-size:12px; line-height:1.5; border-radius:4px; }
.label { padding:4px 9px; border-radius:6px; font-size:11px; font-weight:600; display:inline-block; }
.label-success { background:#d1e7dd; color:#0f5132; }
.label-default { background:#e9ecef; color:#495057; }
.bed-modal-info { display:none; margin-bottom:10px; border-radius:6px; padding:8px 12px; font-size:12px; }
.bed-info-blue { background:#e8f4fd; border:1px solid #bee5eb; color:#0c5460; }
.bed-info-green { background:#e9f7ef; border:1px solid #28a745; color:#155724; }
.bed-modal-subinfo { display:none; margin-top:6px; background:#fff3cd; border:1px solid #ffc107; border-radius:6px; padding:8px 12px; color:#856404; }
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

function toggleModalSection(value, statusBefore) {
    value = parseInt(value, 10);
    statusBefore = parseInt(statusBefore || 99, 10);

    $('#modal-section-pasien, #modal-section-notes-manual, #modal-info-auto-terisi, #modal-info-auto-tersedia, #modal-info-checkout').hide();

    if (value === 1) {
        $('#modal-section-pasien, #modal-info-auto-terisi').slideDown(150);
    } else if (value === 0) {
        $('#modal-info-auto-tersedia').slideDown(150);
        if (statusBefore === 1) {
            $('#modal-info-checkout').slideDown(150);
        }
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
    $(document).on('click', '.btn-update-status', function () {
        var $btn = $(this);
        var id = $btn.data('id');
        var status = parseInt($btn.data('status'), 10);
        var patientId = parseInt($btn.data('patient-id') || 0, 10);
        var patientName = $btn.data('patient-name') || '';

        $('#modal-bed-id').val(id).data('status-before', status);
        $('#modal-status').val(status);
        $('#modal-notes').val('');
        clearSelectedPatient();

        if (status === 1 && patientId > 0) {
            setSelectedPatient(patientId, patientName);
        } else if (status === 1 && patientName) {
            $('#modal-patient-search').val(patientName);
        }

        toggleModalSection(status, status);
        $('#btn-save-status').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
        $('#modalStatus').modal('show');
    });

    $('#modal-status').on('change', function () {
        var statusBefore = parseInt($('#modal-bed-id').data('status-before') || 99, 10);
        toggleModalSection($(this).val(), statusBefore);
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

        if (!bedId) {
            alert('ID bed tidak ditemukan.');
            return;
        }

        if (statusValue === 1 && !$('#modal-patient-id').val() && !$('#selected-patient-name').text()) {
            alert('Pilih pasien terlebih dahulu untuk status Terisi.');
            $('#modal-patient-search').focus();
            return;
        }

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

    $('[data-toggle="tooltip"]').tooltip();
});
</script>
