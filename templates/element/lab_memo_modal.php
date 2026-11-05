<?php
/**
 * templates/element/lab_memo_modal.php
 * Pemakaian: <?= $this->element('lab_memo_modal') ?>
 * Tombol pembuka: data-toggle="modal" data-target="#modal-lab-memo"
 *
 * @var \App\View\AppView $this
 */
$urlList = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabMemos', 'action' => 'index']);
$urlAdd = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabMemos', 'action' => 'add']);
$urlDelete = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabMemos', 'action' => 'delete']);
$csrf = (string)$this->request->getAttribute('csrfToken');
?>
<div class="modal fade" id="modal-lab-memo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-sticky-note"></i> Internal Memo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="d-flex mb-2">
                    <div class="input-group mr-2" style="max-width:340px;">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                        <input type="text" id="memo-q" class="form-control" placeholder="Cari noreg / rekmed / nama / isi memo..." autocomplete="off">
                    </div>
                    <button type="button" class="btn btn-default mr-1" id="memo-refresh" title="Muat ulang"><i class="fa fa-sync"></i></button>
                    <button type="button" class="btn btn-success ml-auto" id="memo-toggle-add"><i class="fa fa-plus"></i> Tambah Memo</button>
                </div>

                <!-- Form tambah memo -->
                <div id="memo-add-box" class="border rounded p-3 mb-3" style="display:none;">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="mb-1">Noreg</label>
                            <input type="text" id="memo-f-noreg" class="form-control form-control-sm" maxlength="50">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="mb-1">Rekmed</label>
                            <input type="text" id="memo-f-rm" class="form-control form-control-sm" maxlength="50">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="mb-1">Nama Pasien</label>
                            <input type="text" id="memo-f-name" class="form-control form-control-sm" maxlength="150">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="mb-1">Isi Memo <span class="text-danger">*</span></label>
                        <textarea id="memo-f-text" class="form-control" rows="3"></textarea>
                    </div>
                    <div id="memo-add-error" class="text-danger small mb-2" style="display:none;"></div>
                    <button type="button" class="btn btn-primary btn-sm" id="memo-save"><i class="fa fa-save"></i> Simpan Memo</button>
                    <button type="button" class="btn btn-default btn-sm" id="memo-cancel-add">Batal</button>
                </div>

                <!-- Tabel memo -->
                <div class="table-responsive" style="height:300px; overflow-y:auto;">
                    <table class="table table-bordered table-hover table-sm mb-0">
                        <thead class="thead-dark" style="position:sticky; top:0;">
                            <tr>
                                <th style="width:150px;">Noreg</th>
                                <th style="width:120px;">Rekmed</th>
                                <th>Nama Pasien</th>
                                <th style="width:150px;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody id="memo-rows">
                            <tr><td colspan="4" class="text-center text-muted py-4">Memuat...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Isi memo terpilih -->
                <div id="memo-detail" class="border rounded p-3 mt-3" style="display:none;">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted" id="memo-detail-meta"></small>
                        <a href="javascript:;" class="text-danger small" id="memo-delete"><i class="fa fa-trash"></i> Hapus</a>
                    </div>
                    <div id="memo-detail-text" style="white-space:pre-wrap;" class="mt-1"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
#memo-rows tr[data-id] { cursor: pointer; }
</style>

<script>
$(function () {
    var URL_LIST = <?= json_encode($urlList) ?>;
    var URL_ADD = <?= json_encode($urlAdd) ?>;
    var URL_DELETE = <?= json_encode($urlDelete) ?>;
    var CSRF = <?= json_encode($csrf) ?>;
    var rows = [], selectedId = null, timer = null;

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[c];
        });
    }

    function render() {
        if (!rows.length) {
            $('#memo-rows').html('<tr><td colspan="4" class="text-center text-muted py-4">Tidak ada memo</td></tr>');
            return;
        }
        var html = '';
        rows.forEach(function (r) {
            html += '<tr data-id="' + r.id + '"' + (r.id === selectedId ? ' class="table-active"' : '') + '>' +
                '<td>' + esc(r.noreg) + '</td><td>' + esc(r.rm) + '</td><td><b>' + esc(r.name) + '</b></td><td>' + esc(r.date) + '</td></tr>';
        });
        $('#memo-rows').html(html);
    }

    function hideDetail() { selectedId = null; $('#memo-detail').hide(); }

    function load() {
        $('#memo-rows').html('<tr><td colspan="4" class="text-center text-muted py-4">Memuat...</td></tr>');
        $.getJSON(URL_LIST, {q: $.trim($('#memo-q').val())}).done(function (res) {
            rows = res.ok ? res.rows : [];
            if (selectedId !== null && !rows.some(function (r) { return r.id === selectedId; })) { hideDetail(); }
            render();
        }).fail(function (xhr) {
            $('#memo-rows').html('<tr><td colspan="4" class="text-center text-danger py-4">Gagal memuat (HTTP ' + xhr.status + ')</td></tr>');
        });
    }

    function resetForm() {
        $('#memo-f-noreg, #memo-f-rm, #memo-f-name, #memo-f-text').val('');
        $('#memo-add-error').hide();
    }

    $('#modal-lab-memo').on('show.bs.modal', function () { hideDetail(); load(); });

    $('#memo-q').on('input', function () { clearTimeout(timer); timer = setTimeout(load, 300); });
    $('#memo-refresh').on('click', load);

    $('#memo-rows').on('click', 'tr[data-id]', function () {
        selectedId = $(this).data('id');
        var r = rows.filter(function (x) { return x.id === selectedId; })[0];
        if (!r) { return; }
        $('#memo-rows tr').removeClass('table-active');
        $(this).addClass('table-active');
        $('#memo-detail-meta').text(r.date + (r.by ? ' — ' + r.by : ''));
        $('#memo-detail-text').text(r.memo);
        $('#memo-detail').show();
    });

    $('#memo-toggle-add').on('click', function () { $('#memo-add-box').slideToggle(120); });
    $('#memo-cancel-add').on('click', function () { $('#memo-add-box').slideUp(120); resetForm(); });

    $('#memo-save').on('click', function () {
        var $btn = $(this);
        $('#memo-add-error').hide();
        $btn.prop('disabled', true);
        $.ajax({
            url: URL_ADD, type: 'POST', dataType: 'json',
            headers: {'X-CSRF-Token': CSRF},
            data: {
                registration_no: $('#memo-f-noreg').val(),
                medical_record_no: $('#memo-f-rm').val(),
                patient_name: $('#memo-f-name').val(),
                memo: $('#memo-f-text').val()
            }
        }).done(function (res) {
            if (!res.ok) { $('#memo-add-error').text(res.message || 'Gagal menyimpan.').show(); return; }
            resetForm();
            $('#memo-add-box').slideUp(120);
            load();
        }).fail(function (xhr) {
            $('#memo-add-error').text('Gagal menyimpan (HTTP ' + xhr.status + ').').show();
        }).always(function () { $btn.prop('disabled', false); });
    });

    $('#memo-delete').on('click', function () {
        if (selectedId === null || !confirm('Hapus memo ini?')) { return; }
        $.ajax({
            url: URL_DELETE + '/' + selectedId, type: 'POST', dataType: 'json',
            headers: {'X-CSRF-Token': CSRF}
        }).done(function (res) {
            if (!res.ok) { alert(res.message || 'Gagal menghapus.'); return; }
            hideDetail();
            load();
        }).fail(function (xhr) { alert('Gagal menghapus (HTTP ' + xhr.status + ').'); });
    });
});
</script>