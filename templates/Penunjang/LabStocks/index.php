<?php
/**
 * templates/Penunjang/LabStocks/index.php
 *
 * @var \App\View\AppView $this
 */
$urlWarehouses = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabStocks', 'action' => 'warehouses']);
$urlStock = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabStocks', 'action' => 'stock']);
$urlValidate = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabStocks', 'action' => 'validateDepot']);
$csrf = (string)$this->request->getAttribute('csrfToken');
?>
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Laboratorium', ['prefix' => 'Penunjang', 'controller' => 'LabExaminations', 'action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Informasi Stock</li>
</ol>
<h1 class="page-header">Informasi Stock <small>Persediaan Laboratorium</small></h1>

<!-- ===== Gudang ===== -->
<div class="panel panel-inverse">
    <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-warehouse"></i> Gudang</h4></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group mb-2">
                    <div class="input-group-prepend"><span class="input-group-text">Cari Gudang</span></div>
                    <input type="text" id="st-wh-q" class="form-control" placeholder="Kode / nama gudang" autocomplete="off">
                </div>
                <div class="table-responsive border" style="height:170px; overflow-y:auto;">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-dark" style="position:sticky; top:0;">
                            <tr><th style="width:120px;">Kode</th><th>Nama Gudang</th></tr>
                        </thead>
                        <tbody id="st-wh-rows">
                            <tr><td colspan="2" class="text-center text-muted py-3">Memuat...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-2">
                    <button type="button" class="btn btn-default" id="st-validate" disabled><i class="fa fa-check-double"></i> Validasi Depo Ini</button>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="st-nonzero">
                    <label class="custom-control-label" for="st-nonzero">Tampilkan Stock &gt; 0 Saja</label>
                </div>
                <div class="small text-muted" id="st-selected">Belum ada gudang dipilih.</div>
                <div id="st-validate-result" class="alert alert-info mt-2 mb-0 small" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ===== Stok barang ===== -->
<div class="panel panel-inverse">
    <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-boxes"></i> Stok Barang</h4></div>
    <div class="panel-body">
        <div class="row mb-3">
            <div class="col-lg-5">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Cari Barang</span></div>
                    <input type="text" id="st-item-q" class="form-control" placeholder="Kode / nama barang" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-7 text-lg-right mt-2 mt-lg-0">
                <button type="button" class="btn btn-default st-mode" data-mode="min"><i class="fa fa-arrow-down"></i> MINIMUM STOCK</button>
                <button type="button" class="btn btn-default st-mode" data-mode="minus"><i class="fa fa-minus-circle"></i> Validasi Saldo Minus</button>
            </div>
        </div>

        <div class="table-responsive border" style="height:420px; overflow:auto;">
            <table class="table table-sm table-bordered table-hover mb-0" style="min-width:1100px;">
                <thead class="thead-dark" style="position:sticky; top:0;">
                    <tr>
                        <th style="width:110px;">Kode Obat</th>
                        <th>Nama Obat</th>
                        <th style="width:80px;">Satuan</th>
                        <th style="width:105px;">Tgl SO Terakhir</th>
                        <th class="text-right">Hasil SO</th>
                        <th class="text-right">Adjustment</th>
                        <th class="text-right">Terima</th>
                        <th class="text-right">Keluar</th>
                        <th class="text-right">Saldo Akhir</th>
                        <th class="text-right">Min Stok</th>
                        <th class="text-right">Max Stok</th>
                    </tr>
                </thead>
                <tbody id="st-rows">
                    <tr><td colspan="11" class="text-center text-muted py-5">Pilih gudang terlebih dahulu</td></tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
            <div>
                <b class="mr-2">Urut</b>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="st-o-code" name="st_order" value="code" class="custom-control-input" checked>
                    <label class="custom-control-label" for="st-o-code">Kode barang</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="st-o-name" name="st_order" value="name" class="custom-control-input">
                    <label class="custom-control-label" for="st-o-name">Nama Barang</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="st-o-bal" name="st_order" value="balance" class="custom-control-input">
                    <label class="custom-control-label" for="st-o-bal">Saldo akhir stock</label>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <small class="text-muted mr-3" id="st-info"></small>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-default" id="st-prev" disabled>&laquo; Sebelumnya</button>
                    <button type="button" class="btn btn-default" id="st-next" disabled>Berikutnya &raquo;</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#st-wh-rows tr[data-id] { cursor: pointer; }
.st-mode.active { background:#f59c1a; border-color:#f59c1a; color:#fff; }
</style>

<script>
$(function () {
    var URL_WH = <?= json_encode($urlWarehouses) ?>;
    var URL_STOCK = <?= json_encode($urlStock) ?>;
    var URL_VALIDATE = <?= json_encode($urlValidate) ?>;
    var CSRF = <?= json_encode($csrf) ?>;

    var warehouses = [], warehouse = null, page = 1, lastTotal = 0, perPage = 100, mode = '', t1 = null, t2 = null;

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[c];
        });
    }
    function num(n) { return Number(n).toLocaleString('id-ID', {maximumFractionDigits: 2}); }

    /* ---------- Gudang ---------- */
    function loadWarehouses() {
        $.getJSON(URL_WH, {q: $.trim($('#st-wh-q').val())}).done(function (res) {
            warehouses = res.ok ? res.rows : [];
            var html = '';
            warehouses.forEach(function (w) {
                html += '<tr data-id="' + w.id + '"' + (warehouse && warehouse.id === w.id ? ' class="table-active"' : '') + '>' +
                    '<td>' + esc(w.code) + '</td><td>' + esc(w.name) + '</td></tr>';
            });
            $('#st-wh-rows').html(html || '<tr><td colspan="2" class="text-center text-muted py-3">Gudang tidak ditemukan</td></tr>');
        }).fail(function (xhr) {
            $('#st-wh-rows').html('<tr><td colspan="2" class="text-center text-danger py-3">Gagal memuat (HTTP ' + xhr.status + ')</td></tr>');
        });
    }

    $('#st-wh-q').on('input', function () { clearTimeout(t1); t1 = setTimeout(loadWarehouses, 300); });

    $('#st-wh-rows').on('click', 'tr[data-id]', function () {
        var id = $(this).data('id');
        warehouse = warehouses.filter(function (w) { return w.id === id; })[0] || null;
        $('#st-wh-rows tr').removeClass('table-active');
        $(this).addClass('table-active');
        if (!warehouse) { return; }
        $('#st-validate').prop('disabled', false);
        $('#st-validate-result').hide();
        $('#st-selected').html('Gudang: <b>' + esc(warehouse.code) + ' — ' + esc(warehouse.name) + '</b>' +
            (warehouse.validated_at ? ' &middot; divalidasi ' + esc(warehouse.validated_at) + (warehouse.validated_by ? ' oleh ' + esc(warehouse.validated_by) : '') : ' &middot; belum pernah divalidasi'));
        page = 1;
        loadStock();
    });

    /* ---------- Stok ---------- */
    function loadStock() {
        if (!warehouse) { return; }
        $('#st-rows').html('<tr><td colspan="11" class="text-center text-muted py-5">Memuat...</td></tr>');
        $.getJSON(URL_STOCK, {
            warehouse_id: warehouse.id,
            q: $.trim($('#st-item-q').val()),
            nonzero: $('#st-nonzero').is(':checked') ? 1 : 0,
            mode: mode,
            order: $('input[name=st_order]:checked').val(),
            page: page
        }).done(function (res) {
            if (!res.ok) {
                $('#st-rows').html('<tr><td colspan="11" class="text-center text-warning py-5">' + esc(res.message) + '</td></tr>');
                return;
            }
            lastTotal = res.total; perPage = res.per_page;
            if (!res.rows.length) {
                $('#st-rows').html('<tr><td colspan="11" class="text-center text-muted py-5">Tidak ada data stok</td></tr>');
            } else {
                var html = '';
                res.rows.forEach(function (r) {
                    var cls = r.balance < 0 ? 'table-danger' : (r.min > 0 && r.balance <= r.min ? 'table-warning' : '');
                    html += '<tr class="' + cls + '"><td>' + esc(r.code) + '</td><td>' + esc(r.name) + '</td><td>' + esc(r.unit) +
                        '</td><td>' + esc(r.so_date) + '</td><td class="text-right">' + num(r.so) + '</td><td class="text-right">' + num(r.adj) +
                        '</td><td class="text-right">' + num(r.in) + '</td><td class="text-right">' + num(r.out) +
                        '</td><td class="text-right"><b' + (r.balance < 0 ? ' class="text-danger"' : '') + '>' + num(r.balance) + '</b></td><td class="text-right">' +
                        num(r.min) + '</td><td class="text-right">' + num(r.max) + '</td></tr>';
                });
                $('#st-rows').html(html);
            }
            var from = res.total ? (res.page - 1) * perPage + 1 : 0;
            var to = Math.min(res.page * perPage, res.total);
            $('#st-info').text(from + '–' + to + ' dari ' + res.total + ' barang');
            $('#st-prev').prop('disabled', res.page <= 1);
            $('#st-next').prop('disabled', res.page * perPage >= res.total);
        }).fail(function (xhr) {
            $('#st-rows').html('<tr><td colspan="11" class="text-center text-danger py-5">Gagal memuat (HTTP ' + xhr.status + ')</td></tr>');
        });
    }

    function reload() { page = 1; loadStock(); }

    $('#st-item-q').on('input', function () { clearTimeout(t2); t2 = setTimeout(reload, 300); });
    $('#st-nonzero, input[name=st_order]').on('change', reload);
    $('#st-prev').on('click', function () { if (page > 1) { page--; loadStock(); } });
    $('#st-next').on('click', function () { page++; loadStock(); });

    $('.st-mode').on('click', function () {
        var m = $(this).data('mode');
        mode = (mode === m) ? '' : m;
        $('.st-mode').removeClass('active');
        if (mode) { $(this).addClass('active'); }
        reload();
    });

    /* ---------- Validasi depo ---------- */
    $('#st-validate').on('click', function () {
        if (!warehouse) { return; }
        var $btn = $(this).prop('disabled', true);
        $.ajax({
            url: URL_VALIDATE, type: 'POST', dataType: 'json',
            headers: {'X-CSRF-Token': CSRF},
            data: {warehouse_id: warehouse.id}
        }).done(function (res) {
            if (!res.ok) { $('#st-validate-result').attr('class', 'alert alert-warning mt-2 mb-0 small').text(res.message).show(); return; }
            $('#st-validate-result').attr('class', 'alert alert-info mt-2 mb-0 small').html(
                'Validasi selesai ' + esc(res.validated_at) + ': <b>' + res.total + '</b> barang, <b>' +
                res.minus + '</b> saldo minus, <b>' + res.below_min + '</b> di bawah/sama dengan stok minimum.').show();
            warehouse.validated_at = res.validated_at;
        }).fail(function (xhr) {
            $('#st-validate-result').attr('class', 'alert alert-danger mt-2 mb-0 small').text('Gagal memvalidasi (HTTP ' + xhr.status + ').').show();
        }).always(function () { $btn.prop('disabled', false); });
    });

    loadWarehouses();
});
</script>