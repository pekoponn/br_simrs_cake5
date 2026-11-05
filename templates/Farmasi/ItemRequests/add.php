<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Farmasi</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Permohonan Barang', ['action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Baru</li>
</ol>
<h1 class="page-header">Permohonan Permintaan Barang</h1>

<style>
    .rq-wrap { background:#fff; border:1px solid #cfd4e2; margin-bottom:10px; }
    .rq-top { display:grid; grid-template-columns:minmax(0,1.2fr) minmax(0,1fr); gap:24px; }
    .rq-left .rq-bar { background:#0a3d7c; color:#ffeb3b; font-weight:700; font-family:Georgia,serif; font-size:16px; padding:8px 14px; }
    .rq-left .rq-box { background:#c0c0c0; padding:10px 14px 14px; }
    .rq-left label { display:block; margin:0 0 3px; font-weight:700; font-size:12px; }
    .rq-left .form-control { height:30px; font-size:12px; margin-bottom:8px; }
    .rq-right { padding:10px 14px; }
    .rq-right .fld { display:grid; grid-template-columns:110px minmax(0,1fr); gap:8px; align-items:center; margin-bottom:8px; }
    .rq-right label { margin:0; font-weight:700; font-size:12px; }
    .rq-right .form-control { height:28px; font-size:12px; }
    .rq-right textarea.form-control { height:80px; }
    .rq-grid { margin:10px 14px 0; border:1px solid #9aa3b5; }
    #items-table { margin:0; font-size:12px; }
    #items-table thead th { background:#eef0f4; color:#000; font-weight:700; border-bottom:1px solid #9aa3b5; padding:4px; white-space:nowrap; }
    #items-table td { padding:2px !important; vertical-align:middle; background:#fff; border:0; border-bottom:1px solid #8b5a2b; border-right:1px solid #8b5a2b; }
    #items-table input { font-size:12px; height:26px; padding:2px 5px; border:0; background:transparent; width:100%; }
    #items-table input:focus { background:#fff8e1; outline:1px solid #0a3d7c; }
    .rq-foot { padding:10px 14px; }
    #item-dd { display:none; position:absolute; z-index:9999; background:#fff; border:1px solid #ced4da; max-height:240px; overflow-y:auto; box-shadow:0 4px 12px rgba(0,0,0,.15); font-size:12px; }
    #item-dd div { padding:6px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; }
    #item-dd div:hover { background:#e8f0fe; }
    @media (max-width: 992px) { .rq-top { grid-template-columns:1fr; } }
</style>

<?= $this->Form->create(null, ['id' => 'form-request']) ?>

<div class="rq-wrap">
    <div class="rq-top">
        <div class="rq-left">
            <div class="rq-bar">Permohonan Permintaan Barang</div>
            <div class="rq-box">
                <label>Dari Bagian [Depo]</label>
                <?= $this->Form->select('from_depo', array_combine($depos, $depos), ['class' => 'form-control', 'empty' => '-- Pilih --']) ?>
                <label>Ke bagian</label>
                <?= $this->Form->select('to_depo', array_combine($depos, $depos), ['class' => 'form-control', 'empty' => '-- Pilih --']) ?>
            </div>
        </div>
        <div class="rq-right">
            <div class="fld"><label>No. Mohon</label><input type="text" class="form-control" value="<?= h($nextNo) ?>" readonly></div>
            <div class="fld"><label>Tanggal</label><?= $this->Form->date('request_date', ['value' => date('Y-m-d'), 'class' => 'form-control']) ?></div>
            <div class="fld" style="align-items:start;"><label>Keterangan</label><?= $this->Form->textarea('notes', ['class' => 'form-control', 'maxlength' => 255]) ?></div>
        </div>
    </div>

    <div class="rq-grid">
        <div class="table-responsive" style="min-height:260px; max-height:340px; overflow-y:auto;">
            <table class="table table-sm mb-0" id="items-table">
                <thead>
                    <tr>
                        <th style="width:130px;">Kode barang</th>
                        <th style="min-width:260px;">Nama Barang</th>
                        <th style="width:80px;">Qty</th>
                        <th style="width:90px;">Unit</th>
                        <th style="min-width:200px;">Keterangan</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="items-body"></tbody>
            </table>
        </div>
    </div>

    <div class="rq-foot">
        <button type="button" class="btn btn-default btn-sm" id="btn-add-row"><i class="fa fa-plus"></i> Tambah Baris</button>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
        <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn btn-default btn-sm']) ?>
    </div>
</div>

<?= $this->Form->end() ?>

<div id="item-dd"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var SEARCH_ITEMS = '<?= $this->Url->build(['action' => 'searchItems']) ?>';
    var idx = 0, $activeRow = null, timer = null;

    function esc(s){ return $('<div>').text(String(s==null?'':s)).html(); }

    function addRow() {
        var i = idx++;
        $('#items-body').append(
            '<tr data-i="'+i+'">'
            + '<td><input type="hidden" name="items['+i+'][item_id]" class="it-id"><input type="text" name="items['+i+'][item_code]" class="it-code" readonly></td>'
            + '<td><input type="text" name="items['+i+'][item_name]" class="it-name" autocomplete="off" placeholder="Ketik nama barang..."></td>'
            + '<td><input type="number" name="items['+i+'][qty]" class="it-qty text-right" value="1" min="0" step="0.01"></td>'
            + '<td><input type="text" name="items['+i+'][unit]" class="it-unit"></td>'
            + '<td><input type="text" name="items['+i+'][notes]" maxlength="255"></td>'
            + '<td class="text-center"><button type="button" class="btn btn-xs btn-danger btn-del">&times;</button></td>'
            + '</tr>'
        );
    }

    $('#btn-add-row').on('click', addRow);
    $(document).on('click', '.btn-del', function(){ $(this).closest('tr').remove(); });

    // Baris kosong baru otomatis saat mengetik di baris terakhir
    $(document).on('input', '.it-name', function () {
        var $inp = $(this), q = $.trim($inp.val());
        $activeRow = $inp.closest('tr');
        if ($activeRow.is(':last-child') && q.length === 1) { addRow(); }
        clearTimeout(timer);
        if (q.length < 2) { $('#item-dd').hide(); return; }
        timer = setTimeout(function () {
            $.getJSON(SEARCH_ITEMS, {q: q}, function (rows) {
                var $dd = $('#item-dd').empty();
                if (!rows.length) { $dd.html('<div class="text-muted">Barang tidak ditemukan</div>'); }
                $.each(rows, function (_, r) {
                    $('<div>').html('<b>'+esc(r.name)+'</b> <small class="text-muted">'+esc(r.code)+'</small>')
                        .on('mousedown', function (e) {
                            e.preventDefault();
                            $activeRow.find('.it-id').val(r.id);
                            $activeRow.find('.it-code').val(r.code);
                            $activeRow.find('.it-name').val(r.name);
                            $activeRow.find('.it-unit').val(r.unit);
                            $dd.hide();
                        }).appendTo($dd);
                });
                var o = $inp.offset();
                $dd.css({top: o.top + $inp.outerHeight(), left: o.left, width: Math.max($inp.outerWidth(), 360)}).show();
            });
        }, 250);
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.it-name, #item-dd').length) $('#item-dd').hide();
    });

    // Cegah submit tidak sengaja dengan Enter di kolom isian
    $('#form-request').on('keydown', 'input', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); }
    });

    addRow();
});
</script>