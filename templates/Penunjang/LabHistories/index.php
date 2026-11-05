<?php
/**
 * templates/Penunjang/LabHistories/index.php
 *
 * @var \App\View\AppView $this
 */
$urlSearch = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabHistories', 'action' => 'searchPatient']);
$urlDetail = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabHistories', 'action' => 'detail']);
?>
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Laboratorium', ['prefix' => 'Penunjang', 'controller' => 'LabExaminations', 'action' => 'index']) ?></li>
    <li class="breadcrumb-item active">History Pemeriksaan</li>
</ol>
<h1 class="page-header">History Pemeriksaan Pasien <small>Laboratorium</small></h1>

<!-- ===== Data pasien ===== -->
<div class="panel panel-inverse">
    <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-history"></i> Pasien</h4></div>
    <div class="panel-body">
        <div class="form-row">
            <div class="form-group col-lg-3 col-md-6">
                <label class="mb-1">Rekmed</label>
                <div class="input-group">
                    <input type="text" id="hp-rm" class="form-control" placeholder="No. rekam medis" autocomplete="off">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-warning" id="hp-search" title="Cari"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-4 col-md-6">
                <label class="mb-1">Nama Pasien</label>
                <input type="text" id="hp-name" class="form-control" readonly>
            </div>
            <div class="form-group col-lg-2 col-md-6">
                <label class="mb-1">Tgl. Lahir</label>
                <input type="text" id="hp-birth" class="form-control" readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6 d-flex align-items-end">
                <button type="button" class="btn btn-success mr-1" id="hp-proses"><i class="fa fa-play"></i> Proses</button>
                <?= $this->Html->link('<i class="fa fa-times"></i> Tutup', ['prefix' => 'Penunjang', 'controller' => 'LabExaminations', 'action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-3 col-md-6 mb-0">
                <label class="mb-1 d-block">J. Kelamin</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="hp-g-l" name="hp_gender" class="custom-control-input" disabled>
                    <label class="custom-control-label" for="hp-g-l">Laki-laki</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="hp-g-p" name="hp_gender" class="custom-control-input" disabled>
                    <label class="custom-control-label" for="hp-g-p">Perempuan</label>
                </div>
            </div>
            <div class="form-group col-lg-9 col-md-6 mb-0">
                <label class="mb-1">Alamat</label>
                <input type="text" id="hp-address" class="form-control" readonly>
            </div>
        </div>
        <div id="hp-message" class="mt-3" style="display:none;"></div>
    </div>
</div>

<!-- ===== Tiga panel ===== -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-inverse">
            <div class="panel-heading"><h4 class="panel-title">Nama Pemeriksaan</h4></div>
            <div class="panel-body p-0" style="height:380px; overflow-y:auto;">
                <div class="list-group list-group-flush" id="hp-names">
                    <div class="text-center text-muted py-4">Belum ada data</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-inverse">
            <div class="panel-heading"><h4 class="panel-title">No. Pemeriksaan</h4></div>
            <div class="panel-body p-0" style="height:380px; overflow-y:auto;">
                <table class="table table-sm table-hover table-bordered mb-0">
                    <thead class="thead-dark" style="position:sticky; top:0;">
                        <tr><th>No. Pemeriksaan</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody id="hp-exams">
                        <tr><td colspan="2" class="text-center text-muted py-4">Belum ada data</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-inverse">
            <div class="panel-heading"><h4 class="panel-title">Hasil</h4></div>
            <div class="panel-body p-0" style="height:380px; overflow-y:auto;">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="thead-dark" style="position:sticky; top:0;">
                        <tr>
                            <th>Pemeriksaan</th>
                            <th>Hasil</th>
                            <th>Satuan</th>
                            <th>Nilai Rujukan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="hp-results">
                        <tr><td colspan="5" class="text-center text-muted py-4">Pilih nomor pemeriksaan</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-inverse">
    <div class="panel-body">
        <label class="mb-1">Catatan</label>
        <textarea id="hp-note" class="form-control" rows="3" readonly></textarea>
    </div>
</div>

<style>
#hp-exams tr { cursor: pointer; }
#hp-names .list-group-item { cursor: pointer; padding: .5rem .75rem; }
</style>

<script>
$(function () {
    var URL_SEARCH = <?= json_encode($urlSearch) ?>;
    var URL_DETAIL = <?= json_encode($urlDetail) ?>;
    var exams = [];
    var activeName = null;   // null = semua pemeriksaan

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[c];
        });
    }

    function showMessage(text, type) {
        $('#hp-message').attr('class', 'mt-3 alert alert-' + type).text(text).show();
    }

    function resetAll() {
        exams = []; activeName = null;
        $('#hp-name, #hp-birth, #hp-address').val('');
        $('#hp-g-l, #hp-g-p').prop('checked', false);
        $('#hp-names').html('<div class="text-center text-muted py-4">Belum ada data</div>');
        $('#hp-exams').html('<tr><td colspan="2" class="text-center text-muted py-4">Belum ada data</td></tr>');
        resetResults();
    }

    function resetResults() {
        $('#hp-results').html('<tr><td colspan="5" class="text-center text-muted py-4">Pilih nomor pemeriksaan</td></tr>');
        $('#hp-note').val('');
    }

    function renderNames() {
        var counts = {}, order = [];
        exams.forEach(function (e) {
            if (!(e.name in counts)) { counts[e.name] = 0; order.push(e.name); }
            counts[e.name]++;
        });
        var html = '<a href="javascript:;" class="list-group-item list-group-item-action hp-name' +
            (activeName === null ? ' active' : '') + '" data-name="">Semua (' + exams.length + ')</a>';
        order.forEach(function (n) {
            html += '<a href="javascript:;" class="list-group-item list-group-item-action hp-name' +
                (activeName === n ? ' active' : '') + '" data-name="' + esc(n) + '">' +
                esc(n || '(tanpa nama)') + ' <span class="badge badge-secondary float-right">' + counts[n] + '</span></a>';
        });
        $('#hp-names').html(html);
    }

    function renderExams() {
        var rows = exams.filter(function (e) { return activeName === null || e.name === activeName; });
        if (!rows.length) {
            $('#hp-exams').html('<tr><td colspan="2" class="text-center text-muted py-4">Tidak ada pemeriksaan</td></tr>');
            return;
        }
        var html = '';
        rows.forEach(function (e) {
            html += '<tr data-id="' + e.id + '"><td><code>' + esc(e.lab_no) + '</code></td><td>' + esc(e.date) + '</td></tr>';
        });
        $('#hp-exams').html(html);
    }

    function search() {
        var rm = $.trim($('#hp-rm').val());
        $('#hp-message').hide();
        resetAll();
        if (!rm) { showMessage('Isi nomor rekam medis terlebih dahulu.', 'warning'); return; }

        $.getJSON(URL_SEARCH, {rm: rm}).done(function (res) {
            if (!res.ok) { showMessage(res.message || 'Data tidak ditemukan.', 'warning'); return; }
            var p = res.patient;
            $('#hp-name').val(p.name);
            $('#hp-birth').val(p.birth_date);
            $('#hp-address').val(p.address);
            $('#hp-g-l').prop('checked', p.gender === 'L');
            $('#hp-g-p').prop('checked', p.gender === 'P');
            exams = res.exams || [];
            if (!exams.length) { showMessage('Pasien belum memiliki riwayat pemeriksaan laboratorium.', 'info'); }
            renderNames();
            renderExams();
        }).fail(function (xhr) {
            showMessage('Gagal memuat data (HTTP ' + xhr.status + ').', 'danger');
        });
    }

    $('#hp-search, #hp-proses').on('click', search);
    $('#hp-rm').on('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); search(); } });

    $('#hp-names').on('click', '.hp-name', function () {
        var n = $(this).attr('data-name');
        activeName = n === '' ? null : n;
        renderNames();
        renderExams();
        resetResults();
    });

    $('#hp-exams').on('click', 'tr[data-id]', function () {
        var $tr = $(this), id = $tr.data('id');
        $('#hp-exams tr').removeClass('table-active');
        $tr.addClass('table-active');
        $('#hp-results').html('<tr><td colspan="5" class="text-center text-muted py-4">Memuat...</td></tr>');

        $.getJSON(URL_DETAIL + '/' + id).done(function (res) {
            if (!res.ok) { showMessage(res.message || 'Gagal memuat hasil.', 'warning'); return; }
            if (!res.results.length) {
                $('#hp-results').html('<tr><td colspan="5" class="text-center text-muted py-4">Belum ada hasil</td></tr>');
            } else {
                var html = '';
                res.results.forEach(function (r) {
                    html += '<tr><td>' + esc(r.parameter) + '</td><td><b>' + esc(r.result) + '</b></td><td>' +
                        esc(r.unit) + '</td><td>' + esc(r.reference) + '</td><td>' + esc(r.remarks) + '</td></tr>';
                });
                $('#hp-results').html(html);
            }
            $('#hp-note').val(res.note);
        }).fail(function (xhr) {
            $('#hp-results').html('<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat (HTTP ' + xhr.status + ')</td></tr>');
        });
    });

    $('#hp-rm').trigger('focus');
});
</script>