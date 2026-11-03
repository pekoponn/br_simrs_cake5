<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 * @var array $rooms
 * @var array $classList
 * @var array $statusList
 * @var array $activeList
 * @var array $roomDetails   — ['room_id' => ['room_name', 'room_class', 'capacity', 'bed_count']]
 * @var string $nextCode     — kode bed berikutnya (BED-XXXX)
 */

$checkCapacityUrl = $this->Url->build(['prefix' => 'Master', 'controller' => 'Rooms', 'action' => 'checkCapacity']);
$getNextTtUrl     = $this->Url->build(['prefix' => 'Master', 'controller' => 'Beds',  'action' => 'getNextTt']);
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Tambah') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-bed"></i> Tambah Bed
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($bed) ?>

        <!-- ═══════════════════ BARIS 1: Code Bed | Room | Nomor TT | Class ═══════════════════ -->
        <div class="row">

            <!-- CODE BED (auto, bisa diedit) -->
            <div class="col-md-3">
                <div class="form-group">
                    <label>Code Bed</label>
                    <div class="input-group">
                        <?= $this->Form->control('code', [
                            'label'    => false,
                            'class'    => 'form-control',
                            'id'       => 'field-code',
                            'value'    => $nextCode ?? '',
                            'readonly' => true,
                        ]) ?>
                        <span class="input-group-btn">
                            <button type="button" id="btn-toggle-code"
                                    class="btn btn-default"
                                    data-toggle="tooltip" title="Edit kode manual">
                                <i class="fa fa-lock" id="icon-lock-code"></i>
                            </button>
                        </span>
                    </div>
                    <small class="text-muted">Otomatis. Klik 🔒 untuk edit manual.</small>
                </div>
            </div>

            <!-- ROOM — pilih ini dulu, TT & class langsung auto -->
            <div class="col-md-3">
                <div class="form-group">
                    <label>Room <span class="text-danger">*</span></label>
                    <?= $this->Form->control('room_id', [
                        'label'   => false,
                        'options' => $rooms,
                        'empty'   => '-- Pilih Room --',
                        'class'   => 'form-control',
                        'id'      => 'field-room-id',
                    ]) ?>
                    <div id="room-capacity-info" style="display:none; margin-top:5px; font-size:12px;"></div>
                </div>
            </div>

            <!-- NOMOR TT (auto per room, bisa diedit) -->
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nomor TT <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <?= $this->Form->control('bed_no', [
                            'label'       => false,
                            'class'       => 'form-control',
                            'placeholder' => 'Pilih room dulu...',
                            'id'          => 'field-bed-no',
                            'readonly'    => true,
                        ]) ?>
                        <span class="input-group-btn">
                            <button type="button" id="btn-toggle-bedno"
                                    class="btn btn-default"
                                    data-toggle="tooltip" title="Edit nomor TT manual">
                                <i class="fa fa-lock" id="icon-lock-bedno"></i>
                            </button>
                        </span>
                    </div>
                    <small class="text-muted" id="bedno-hint">Otomatis berurutan per room.</small>
                </div>
            </div>

            <!-- CLASS (otomatis dari room_class, DIKUNCI — tidak bisa diubah) -->
            <div class="col-md-3">
                <div class="form-group">
                    <label>
                        Class <span class="text-danger">*</span>
                        <span id="class-auto-badge"
                              style="display:none; background:#d4edda; color:#155724;
                                     font-size:10px; padding:1px 6px; border-radius:10px;
                                     font-weight:600; margin-left:4px;">
                            <i class="fa fa-lock"></i> Otomatis
                        </span>
                    </label>

                    <!-- Tampilan readonly — tidak bisa diklik/diketik -->
                    <div class="input-group">
                        <input type="text"
                               id="display-class-name"
                               class="form-control"
                               value="<?= h($bed->class_name ?? '') ?>"
                               readonly
                               placeholder="Terisi otomatis dari room..."
                               style="background:#f5f5f5; color:#555; cursor:not-allowed; border-color:#ddd;">
                        <span class="input-group-addon"
                              style="background:#f5f5f5; color:#aaa; border-color:#ddd;"
                              data-toggle="tooltip" title="Kelas diisi otomatis dari room yang dipilih, tidak dapat diubah">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <!-- Hidden input — nilai ini yang dikirim ke server -->
                    <input type="hidden"
                           name="class_name"
                           id="hidden-class-name"
                           value="<?= h($bed->class_name ?? '') ?>">

                    <small class="text-muted" id="class-hint" style="display:none;">
                        <i class="fa fa-info-circle"></i> Diisi otomatis dari kelas room, tidak dapat diubah.
                    </small>
                </div>
            </div>

        </div>

        <!-- ═══════════════════ BARIS 2: Nama Bed | Status Bed | Status Active ═══════════════════ -->
        <div class="row">

            <!-- NAMA BED (otomatis dari room, DIKUNCI — tidak bisa diubah) -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>
                        Nama Bed
                        <span style="background:#d4edda; color:#155724;
                                     font-size:10px; padding:1px 6px; border-radius:10px;
                                     font-weight:600; margin-left:4px;">
                            <i class="fa fa-lock"></i> Otomatis
                        </span>
                    </label>

                    <!-- Tampilan readonly — tidak bisa diklik/diketik -->
                    <div class="input-group">
                        <input type="text"
                               id="field-name"
                               class="form-control"
                               value="<?= h($bed->name ?? '') ?>"
                               readonly
                               placeholder="Terisi otomatis dari room..."
                               style="background:#f5f5f5; color:#555; cursor:not-allowed; border-color:#ddd;">
                        <span class="input-group-addon"
                              style="background:#f5f5f5; color:#aaa; border-color:#ddd;"
                              data-toggle="tooltip" title="Nama bed diisi otomatis dari room yang dipilih, tidak dapat diubah">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <!-- Hidden input — nilai ini yang dikirim ke server -->
                    <input type="hidden"
                           name="name"
                           id="hidden-name"
                           value="<?= h($bed->name ?? '') ?>">

                    <small class="text-muted">
                        <i class="fa fa-info-circle"></i> Diisi otomatis dari nama room, tidak dapat diubah.
                    </small>
                </div>
            </div>

            <!-- STATUS BED -->
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status', [
                        'type'    => 'select',
                        'label'   => 'Status Bed',
                        'options' => $statusList,
                        'empty'   => '-- Pilih Status --',
                        'class'   => 'form-control select2Form',
                        'id'      => 'field-status',
                        'value'   => 0,
                    ]) ?>
                </div>
            </div>

            <!-- STATUS ACTIVE -->
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('is_active', [
                        'label' => 'Status',
                        'type' => 'select',
                        'options' => ['Y' => 'Aktif', 'N' => 'Tidak Aktif'],
                        'default' => 'Y',
                        'class' => 'form-control select2Form'
                    ]) ?>
                </div>
            </div>

        </div>

        <!-- PREVIEW sebelum simpan -->
        <div id="bed-preview" style="display:none; margin-bottom:14px;">
            <div style="background:#f0fff4; border:1px solid #c3e6cb; border-radius:8px;
                        padding:10px 16px; font-size:13px;">
                <i class="fa fa-eye" style="color:#28a745;"></i>
                <strong>Preview:</strong>
                <code id="prev-code" style="margin-left:6px;"></code>
                <span style="color:#ccc; margin:0 6px;">|</span>
                <strong id="prev-bedno" style="color:#2c3e50;"></strong>
                <span style="color:#ccc; margin:0 6px;">|</span>
                <span id="prev-class"
                      style="background:#e9ecef; padding:1px 8px; border-radius:10px; font-size:11px;"></span>
                <span style="color:#ccc; margin:0 6px;">|</span>
                <span id="prev-name" style="color:#495057;"></span>
            </div>
        </div>

        <hr>

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

<script>
// ── Data room dari PHP (room_id => {room_name, room_class, capacity, bed_count}) ──
var ROOM_DETAILS    = <?= json_encode($roomDetails ?? [], JSON_UNESCAPED_UNICODE) ?>;
var CHECK_CAP_URL   = '<?= $checkCapacityUrl ?>';
var GET_NEXT_TT_URL = '<?= $getNextTtUrl ?>';

// ── Init Select2 untuk dropdown Status & Active ──
$(document).ready(function () {
    $('.select2Form').select2({
        width: '100%',
        minimumResultsForSearch: 0
    });

    var $room = $('#field-room-id');
    if ($room.hasClass('select2-hidden-accessible') || $room.data('select2')) {
        try { $room.select2('destroy'); } catch (e) {}
    }
    $room.select2({
        width: '100%',
        minimumResultsForSearch: 0
    });

    // Pasang handler change SETELAH select2 di-init.
    $room.off('change.roomAutofill').on('change.roomAutofill', function () {
        handleRoomChange();
    });

    $('[data-toggle="tooltip"]').tooltip();
    updatePreview();
});

// ── Toggle lock code ──────────────────────────────────────────
var codeLocked = true;
$('#btn-toggle-code').on('click', function () {
    codeLocked = !codeLocked;
    $('#field-code').prop('readonly', codeLocked);
    $('#icon-lock-code').toggleClass('fa-lock fa-lock-open');
    if (!codeLocked) $('#field-code').focus();
});

// ── Toggle lock nomor TT ──────────────────────────────────────
var bednoLocked = true;
$('#btn-toggle-bedno').on('click', function () {
    bednoLocked = !bednoLocked;
    $('#field-bed-no').prop('readonly', bednoLocked);
    $('#icon-lock-bedno').toggleClass('fa-lock fa-lock-open');
    if (!bednoLocked) $('#field-bed-no').focus();
});

// ── Helper: set class display + hidden sekaligus ──────────────
function setClassValue(val) {
    $('#display-class-name').val(val || '');
    $('#hidden-class-name').val(val || '');
}

// ── Helper: set nama bed display + hidden sekaligus ───────────
function setNameValue(val) {
    $('#field-name').val(val || '');
    $('#hidden-name').val(val || '');
}

// ── Saat room dipilih ───────────────────────────────────────────
function handleRoomChange() {
    var roomId = $('#field-room-id').val();

    if (!roomId) {
        $('#field-bed-no').val('').prop('placeholder', 'Pilih room dulu...');
        setClassValue('');
        setNameValue('');
        $('#room-capacity-info').hide();
        $('#class-auto-badge, #class-hint').hide();
        updatePreview();
        return;
    }

    var roomData = ROOM_DETAILS[roomId];

    // ── 1. Isi kelas dari room_class (dikunci, tidak bisa diubah) ──
    if (roomData && roomData.room_class) {
        setClassValue(roomData.room_class);
        $('#class-auto-badge').show();
        $('#class-hint').show();
    } else {
        setClassValue('');
        $('#class-auto-badge').hide();
        $('#class-hint').hide();
    }

    // ── 2. Nomor TT berikutnya via AJAX ──────────────────────
    $.ajax({
        url:      GET_NEXT_TT_URL + '/' + roomId,
        method:   'GET',
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                if (bednoLocked) {
                    $('#field-bed-no').val(res.next_tt);
                }
                $('#bedno-hint').html(
                    '<i class="fa fa-check-circle" style="color:#28a745;"></i> ' +
                    'Nomor berikutnya: <strong>' + res.next_tt + '</strong>' +
                    ' (sudah ada ' + res.existing_count + ' TT di room ini)'
                );
            }
            updatePreview();
        },
        error: function () {
            if (bednoLocked) $('#field-bed-no').val('TT01');
            updatePreview();
        }
    });

    // ── 3. Nama bed otomatis (dikunci, tidak bisa diubah) ────────
    if (roomData && roomData.room_name) {
        var nextNum  = (roomData.bed_count || 0) + 1;
        var autoName = roomData.room_name + ' ' + String(nextNum).padStart(2, '0');
        setNameValue(autoName);
    }

    // ── 4. Cek kapasitas room ─────────────────────────────────
    $.ajax({
        url:      CHECK_CAP_URL + '/' + roomId,
        method:   'GET',
        dataType: 'json',
        success: function (res) {
            var html = '';
            if (!res || res.capacity === 0) {
                html = '<span style="color:#6c757d;">'
                     + '<i class="fa fa-infinity"></i> Kapasitas tidak dibatasi</span>';
            } else if (res.available) {
                html = '<span style="color:#28a745;">'
                     + '<i class="fa fa-check-circle"></i> '
                     + res.used + '/' + res.capacity
                     + ' bed terisi (sisa <strong>' + res.sisa + '</strong> slot)</span>';
            } else {
                html = '<span style="color:#dc3545;">'
                     + '<i class="fa fa-exclamation-circle"></i> '
                     + 'Room penuh! ' + res.used + '/' + res.capacity + ' bed</span>';
            }
            $('#room-capacity-info').html(html).show();
        }
    });

    updatePreview();
}

// ── Update preview ────────────────────────────────────────────
function updatePreview() {
    var code  = $('#field-code').val();
    var bedno = $('#field-bed-no').val();
    var cls   = $('#display-class-name').val();
    var name  = $('#field-name').val();

    if (bedno || name) {
        $('#prev-code').text(code || '—');
        $('#prev-bedno').text(bedno || '—');
        $('#prev-class').text(cls || '—');
        $('#prev-name').text(name || '—');
        $('#bed-preview').show();
    } else {
        $('#bed-preview').hide();
    }
}

// Hanya trigger update preview dari field yang masih bisa diedit
$('#field-code, #field-bed-no').on('input change', updatePreview);
</script>