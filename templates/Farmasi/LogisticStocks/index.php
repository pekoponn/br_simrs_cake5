<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Farmasi</a></li>
    <li class="breadcrumb-item active">Stock Logistik</li>
</ol>
<h1 class="page-header">Stock Logistik dan Umum</h1>

<style>
    .sl-wrap { background:#c9c9c9; border:1px solid #9aa3b5; padding:12px 14px; }
    .sl-row { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
    .sl-row label { margin:0; font-size:12px; min-width:80px; }
    .sl-row .form-control { height:26px; font-size:12px; }
    .sl-grid { background:#fff; border:1px solid #9aa3b5; overflow:auto; }
    .sl-grid table { margin:0; font-size:12px; }
    .sl-grid thead th { position:sticky; top:0; background:#eef0f4; color:#000; font-weight:700; padding:3px 6px; white-space:nowrap; border-bottom:1px solid #9aa3b5; z-index:1; }
    .sl-grid td { padding:2px 6px !important; border-top:0; border-bottom:1px solid #d9cbb8; white-space:nowrap; }
    .sl-grid tbody tr { cursor:pointer; }
    .sl-grid tbody tr.sel td { background:#fff176 !important; color:#c62828; }
    .sl-grid tbody tr:hover td { background:#fff9c4; }
    .low td.bal { color:#c62828; font-weight:700; }
    .sl-btn { background:#d4d0c8; border:1px solid #888; font-size:12px; padding:3px 14px; }
    .sl-info { background:#fff; border:1px solid #9aa3b5; padding:4px 8px; font-size:12px; margin-top:8px; }
    #it-dd { display:none; position:absolute; z-index:2000; left:0; right:0; top:100%; background:#fff; border:1px solid #ced4da; max-height:220px; overflow-y:auto; box-shadow:0 4px 12px rgba(0,0,0,.15); font-size:12px; }
    #it-dd div { padding:6px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; }
    #it-dd div:hover { background:#e8f0fe; }
</style>

<div class="sl-wrap">
    <div class="sl-row">
        <label>Cari Gudang</label>
        <input type="text" id="wh-search" class="form-control" style="max-width:370px;" autocomplete="off">
    </div>
    <div class="sl-grid" style="max-width:520px; height:105px; margin-bottom:12px;">
        <table class="table table-sm">
            <thead><tr><th style="width:110px;">Kode</th><th>Nama gudang</th></tr></thead>
            <tbody id="wh-body"></tbody>
        </table>
    </div>

    <div class="sl-row">
        <label>Cari Barang</label>
        <input type="text" id="item-search" class="form-control" style="max-width:310px;" autocomplete="off">
        <button type="button" class="sl-btn ml-3" id="btn-add" style="min-width:230px;">TAMBAH STOCK</button>
        <span class="flex-grow-1"></span>
        <button type="button" class="sl-btn" id="btn-validate" style="min-width:160px;">Validasi stock</button>
    </div>

    <div class="sl-grid" style="height:300px;">
        <table class="table table-sm" id="st-table">
            <thead>
                <tr>
                    <th>Kode barang</th><th style="min-width:240px;">Nama Barang</th><th>Satuan</th>
                    <th>Tgl SO terakhir</th>
                    <th class="text-right">Hasil SO</th><th class="text-right">Adjustment</th>
                    <th class="text-right">Terima</th><th class="text-right">Keluar</th>
                    <th class="text-right">Saldo akhir</th><th class="text-right">Min Stok</th><th class="text-right">Max stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="st-body"><tr><td colspan="12" class="text-muted text-center py-4">Pilih gudang di atas.</td></tr></tbody>
        </table>
    </div>
    <div class="sl-info" id="st-info">&nbsp;</div>
</div>
<p class="text-muted mt-2" style="font-size:12px;">Klik gudang untuk menampilkan stok. Klik dua kali pada baris barang untuk mengubah Hasil SO, Adjustment, Min dan Max. Terima dan Keluar diisi oleh modul lain.</p>

<!-- Modal tambah / ubah stok -->
<div class="modal fade" id="modal-stock" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Tambah / Ubah Stock</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button></div>
        <div class="modal-body">
            <div class="form-group"><label>Gudang</label><input type="text" id="m-wh" class="form-control" readonly></div>
            <div class="form-group position-relative"><label>Barang</label>
                <input type="text" id="m-name" class="form-control" placeholder="Ketik nama / kode barang..." autocomplete="off">
                <input type="hidden" id="m-id"><div id="it-dd"></div></div>
            <div class="form-row">
                <div class="form-group col-6"><label>Kode</label><input type="text" id="m-code" class="form-control" readonly></div>
                <div class="form-group col-6"><label>Satuan</label><input type="text" id="m-unit" class="form-control"></div>
            </div>
            <div class="form-row">
                <div class="form-group col-6"><label>Hasil SO</label><input type="number" step="0.01" id="m-so" class="form-control text-right" value="0"></div>
                <div class="form-group col-6"><label>Adjustment</label><input type="number" step="0.01" id="m-adj" class="form-control text-right" value="0"></div>
                <div class="form-group col-6"><label>Min Stok</label><input type="number" step="0.01" min="0" id="m-min" class="form-control text-right" value="0"></div>
                <div class="form-group col-6"><label>Max Stok</label><input type="number" step="0.01" min="0" id="m-max" class="form-control text-right" value="0"></div>
            </div>
            <div class="text-danger small" id="m-err"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="m-save"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var URL_WH = '<?= $this->Url->build(['action' => 'warehouses']) ?>';
    var URL_ST = '<?= $this->Url->build(['action' => 'stocks']) ?>';
    var URL_SAVE = '<?= $this->Url->build(['action' => 'save']) ?>';
    var URL_VAL = '<?= $this->Url->build(['action' => 'validateStock']) ?>';
    var URL_ITEMS = '<?= $this->Url->build(['action' => 'searchItems']) ?>';
    var CSRF = <?= json_encode((string)$this->request->getAttribute('csrfToken')) ?>;
    var curWh = null, curWhName = '', t1 = null, t2 = null, t3 = null;

    function esc(s){ return $('<div>').text(String(s==null?'':s)).html(); }
    function num(n){ return (parseFloat(n)||0).toLocaleString('id-ID', {minimumFractionDigits:2, maximumFractionDigits:2}); }
    function dt(s){ if(!s) return '-'; var p=String(s).substr(0,10).split('-'); return p.length===3 ? p[2]+'-'+p[1]+'-'+p[0] : s; }
    function post(url, data){
        return $.ajax({url:url, type:'POST', data:data, dataType:'json', headers:{'X-CSRF-Token':CSRF}});
    }
    function errMsg(xhr){ return (xhr.responseJSON && xhr.responseJSON.message) || 'Terjadi kesalahan.'; }

    // --- gudang ---
    function loadWh() {
        $.getJSON(URL_WH, {q: $.trim($('#wh-search').val())}, function (rows) {
            var $b = $('#wh-body').empty();
            if (!rows.length) { $b.html('<tr><td colspan="2" class="text-muted">Gudang tidak ditemukan</td></tr>'); return; }
            $.each(rows, function (_, r) {
                var $tr = $('<tr class="wh-row">').data('r', r)
                    .append('<td>'+esc(r.code)+'</td><td>'+esc(r.name)+'</td>');
                if (curWh === r.code) $tr.addClass('sel');
                $b.append($tr);
            });
        });
    }
    $('#wh-search').on('input', function(){ clearTimeout(t1); t1 = setTimeout(loadWh, 250); });
    $(document).on('click', '.wh-row', function () {
        $('.wh-row').removeClass('sel'); $(this).addClass('sel');
        var r = $(this).data('r'); curWh = r.code; curWhName = r.name;
        $('#item-search').val('');
        loadStocks();
    });

    // --- stok ---
    function loadStocks() {
        if (!curWh) return;
        $.getJSON(URL_ST, {warehouse_code: curWh, q: $.trim($('#item-search').val())}, function (rows) {
            var $b = $('#st-body').empty();
            if (!rows.length) { $b.html('<tr><td colspan="12" class="text-muted text-center py-4">Belum ada stok di gudang ini.</td></tr>'); }
            $.each(rows, function (_, r) {
                var low = (parseFloat(r.min_stock)||0) > 0 && (parseFloat(r.balance)||0) < (parseFloat(r.min_stock)||0);
                var $tr = $('<tr class="st-row'+(low?' low':'')+'">').data('r', r).append(
                    '<td>'+esc(r.item_code)+'</td><td>'+esc(r.item_name)+'</td><td>'+esc(r.unit)+'</td>'
                    + '<td>'+dt(r.last_so_date)+'</td>'
                    + '<td class="text-right">'+num(r.so_qty)+'</td><td class="text-right">'+num(r.adjustment)+'</td>'
                    + '<td class="text-right">'+num(r.received)+'</td><td class="text-right">'+num(r.issued)+'</td>'
                    + '<td class="text-right bal">'+num(r.balance)+'</td>'
                    + '<td class="text-right">'+num(r.min_stock)+'</td><td class="text-right">'+num(r.max_stock)+'</td>'
                    + '<td>'+(String(r.is_valid)==='1' ? '<span class="badge badge-success">VALID</span>' : '<span class="badge badge-secondary">BELUM</span>')+'</td>'
                );
                $b.append($tr);
            });
            $('#st-info').text(curWh + ' - ' + curWhName + ' : ' + rows.length + ' barang');
        });
    }
    $('#item-search').on('input', function(){ clearTimeout(t2); t2 = setTimeout(loadStocks, 250); });
    $(document).on('click', '.st-row', function () { $('.st-row').removeClass('sel'); $(this).addClass('sel'); });
    $(document).on('dblclick', '.st-row', function () { openModal($(this).data('r')); });

    // --- modal ---
    function openModal(r) {
        if (!curWh) { alert('Pilih gudang dulu.'); return; }
        $('#m-err').text('');
        $('#m-wh').val(curWh + ' - ' + curWhName);
        $('#m-id').val(r ? (r.item_id || '') : '');
        $('#m-name').val(r ? r.item_name : '').prop('readonly', !!r);
        $('#m-code').val(r ? r.item_code : '');
        $('#m-unit').val(r ? r.unit : '');
        $('#m-so').val(r ? r.so_qty : 0); $('#m-adj').val(r ? r.adjustment : 0);
        $('#m-min').val(r ? r.min_stock : 0); $('#m-max').val(r ? r.max_stock : 0);
        $('#it-dd').hide();
        $('#modal-stock').modal('show');
    }
    $('#btn-add').on('click', function(){ openModal(null); });

    $('#m-name').on('input', function () {
        var q = $.trim($(this).val());
        clearTimeout(t3);
        if (q.length < 2) { $('#it-dd').hide(); return; }
        t3 = setTimeout(function () {
            $.getJSON(URL_ITEMS, {q: q}, function (rows) {
                var $dd = $('#it-dd').empty();
                if (!rows.length) { $dd.html('<div class="text-muted">Barang tidak ditemukan</div>'); }
                $.each(rows, function (_, r) {
                    $('<div>').html('<b>'+esc(r.name)+'</b> <small class="text-muted">'+esc(r.code)+'</small>')
                        .on('mousedown', function (e) {
                            e.preventDefault();
                            $('#m-id').val(r.id); $('#m-code').val(r.code);
                            $('#m-name').val(r.name); $('#m-unit').val(r.unit || '');
                            $dd.hide();
                        }).appendTo($dd);
                });
                $dd.show();
            });
        }, 250);
    });
    $(document).on('click', function (e) { if (!$(e.target).closest('#m-name, #it-dd').length) $('#it-dd').hide(); });

    $('#m-save').on('click', function () {
        post(URL_SAVE, {
            warehouse_code: curWh, item_id: $('#m-id').val(), item_code: $('#m-code').val(),
            item_name: $('#m-name').val(), unit: $('#m-unit').val(),
            so_qty: $('#m-so').val(), adjustment: $('#m-adj').val(),
            min_stock: $('#m-min').val(), max_stock: $('#m-max').val()
        }).done(function () { $('#modal-stock').modal('hide'); loadStocks(); })
          .fail(function (xhr) { $('#m-err').text(errMsg(xhr)); });
    });

    // --- validasi ---
    $('#btn-validate').on('click', function () {
        if (!curWh) { alert('Pilih gudang dulu.'); return; }
        if (!confirm('Validasi semua stok di gudang ' + curWh + '? Tgl SO terakhir akan diisi hari ini.')) return;
        post(URL_VAL, {warehouse_code: curWh}).done(loadStocks).fail(function (xhr) { alert(errMsg(xhr)); });
    });

    loadWh();
});
</script>