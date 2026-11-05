<?php
/**
 * templates/Penunjang/LabRequisitions/add.php
 *
 * @var \App\View\AppView $this
 * @var string $nextNo
 * @var array $depotList
 * @var array $destList
 * @var array $old
 * @var array $oldItems
 */
$urlSearch = $this->Url->build(['prefix' => 'Penunjang', 'controller' => 'LabRequisitions', 'action' => 'searchItems']);
$selFrom = (string)($old['from_dept'] ?? '');
$selTo = (string)($old['to_dept'] ?? 'LABORATORIUM');
?>
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Laboratorium', ['controller' => 'LabExaminations', 'action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Permohonan Logistik</li>
</ol>
<h1 class="page-header">Permohonan Pengambilan Barang <small>Permohonan Logistik</small></h1>

<style>
    .rq-box { background:#fff; border:1px solid #cfd4e2; padding:10px 12px; margin-bottom:10px; }
    .rq-row { display:grid; grid-template-columns:140px 1fr; gap:8px; align-items:center; margin-bottom:6px; }
    .rq-row label { margin:0; font-weight:700; font-size:12px; }
    .rq-row .form-control { font-size:12px; }
    #rq-items td { padding:3px !important; vertical-align:middle; background:#fff; }
    #rq-items input { font-size:12px; height:27px; padding:2px 5px; }
    #rq-dd { display:none; position:absolute; z-index:9999; background:#fff; border:1px solid #ced4da; max-height:240px; overflow-y:auto; box-shadow:0 4px 12px rgba(0,0,0,.15); font-size:12px; }
    #rq-dd div { padding:6px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; }
    #rq-dd div:hover { background:#e8f0fe; }
</style>

<?= $this->Flash->render() ?>
<?= $this->Form->create(null, ['id' => 'form-rq']) ?>

<div class="row">
    <div class="col-lg-7">
        <div class="rq-box">
            <div class="rq-row"><label>Dari Bagian [Depo]</label>
                <?= $this->Form->select('from_dept', array_combine($depotList, $depotList), ['class' => 'form-control form-control-sm', 'empty' => '-- Pilih --', 'value' => $selFrom]) ?></div>
            <div class="rq-row"><label>Ke bagian</label>
                <?= $this->Form->select('to_dept', array_combine($destList, $destList), ['class' => 'form-control form-control-sm', 'empty' => '-- Pilih --', 'value' => $selTo]) ?></div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="rq-box">
            <div class="rq-row"><label>No. Mohon</label><input type="text" class="form-control form-control-sm" value="<?= h($nextNo) ?>" readonly></div>
            <div class="rq-row"><label>Tanggal</label><?= $this->Form->date('request_date', ['value' => $old['request_date'] ?? date('Y-m-d'), 'class' => 'form-control form-control-sm']) ?></div>
            <div class="rq-row" style="align-items:start;"><label>Keterangan</label><?= $this->Form->textarea('notes', ['rows' => 2, 'class' => 'form-control', 'value' => $old['notes'] ?? '']) ?></div>
        </div>
    </div>
</div>

<div class="rq-box p-0">
    <div class="table-responsive" style="min-height:300px;">
        <table class="table table-bordered table-sm mb-0" id="rq-items" style="font-size:12px;">
            <thead class="thead-dark">
                <tr>
                    <th style="width:140px;">Kode barang</th>
                    <th>Nama Barang</th>
                    <th style="width:90px;">Qty</th>
                    <th style="width:90px;">Unit</th>
                    <th style="width:30%;">Keterangan</th>
                    <th style="width:36px;"></th>
                </tr>
            </thead>
            <tbody id="rq-body"></tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <button type="button" class="btn btn-default" id="rq-add-row"><i class="fa fa-plus"></i> Tambah Baris</button>
    <div>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        <?= $this->Html->link('Daftar Permohonan', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        <?= $this->Html->link('Batal', ['controller' => 'LabExaminations', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
</div>

<?= $this->Form->end() ?>

<div id="rq-dd"></div>

<script>
$(function () {
    var URL_SEARCH = <?= json_encode($urlSearch) ?>;
    var OLD_ITEMS = <?= json_encode($oldItems, JSON_UNESCAPED_UNICODE) ?>;
    var idx = 0, timer = null, $activeRow = null;

    function esc(s) { return $('<div>').text(String(s == null ? '' : s)).html(); }

    function addRow(d) {
        d = d || {};
        var i = idx++;
        var $tr = $(
            '<tr>'
            + '<td><input type="hidden" name="items[' + i + '][item_id]" class="it-id"><input type="text" name="items[' + i + '][item_code]" class="form-control it-code" readonly></td>'
            + '<td><input type="text" name="items[' + i + '][item_name]" class="form-control it-name" autocomplete="off" placeholder="Ketik nama barang..."></td>'
            + '<td><input type="number" name="items[' + i + '][qty]" class="form-control it-qty text-right" min="0" step="0.01"></td>'
            + '<td><input type="text" name="items[' + i + '][unit]" class="form-control it-unit"></td>'
            + '<td><input type="text" name="items[' + i + '][notes]" class="form-control it-notes"></td>'
            + '<td class="text-center"><button type="button" class="btn btn-xs btn-danger rq-del">&times;</button></td>'
            + '</tr>'
        );
        $tr.find('.it-id').val(d.item_id || '');
        $tr.find('.it-code').val(d.item_code || '');
        $tr.find('.it-name').val(d.item_name || '');
        $tr.find('.it-qty').val(d.qty || '');
        $tr.find('.it-unit').val(d.unit || '');
        $tr.find('.it-notes').val(d.notes || '');
        $('#rq-body').append($tr);
    }

    $('#rq-add-row').on('click', function () { addRow(); });
    $(document).on('click', '.rq-del', function () { $(this).closest('tr').remove(); });

    $(document).on('input', '.it-name', function () {
        var $inp = $(this), q = $.trim($inp.val());
        $activeRow = $inp.closest('tr');
        $activeRow.find('.it-id, .it-code').val('');   // ketik ulang = pilihan sebelumnya batal
        clearTimeout(timer);
        if (q.length < 2) { $('#rq-dd').hide(); return; }
        timer = setTimeout(function () {
            $.getJSON(URL_SEARCH, {q: q}).done(function (rows) {
                var $dd = $('#rq-dd').empty();
                if (!rows.length) { $dd.html('<div class="text-muted">Barang tidak ditemukan</div>'); }
                $.each(rows, function (_, r) {
                    $('<div>').html('<b>' + esc(r.name) + '</b> <small class="text-muted">' + esc(r.code) + '</small>')
                        .on('mousedown', function (e) {
                            e.preventDefault();
                            $activeRow.find('.it-id').val(r.id);
                            $activeRow.find('.it-code').val(r.code);
                            $activeRow.find('.it-name').val(r.name);
                            $activeRow.find('.it-unit').val(r.unit);
                            if (!$activeRow.find('.it-qty').val()) { $activeRow.find('.it-qty').val(1); }
                            $dd.hide();
                            $activeRow.find('.it-qty').trigger('focus');
                        }).appendTo($dd);
                });
                var o = $inp.offset();
                $dd.css({top: o.top + $inp.outerHeight(), left: o.left, width: Math.max($inp.outerWidth(), 360)}).show();
            }).fail(function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : ('HTTP ' + xhr.status);
                var o = $inp.offset();
                $('#rq-dd').html('<div class="text-danger">Gagal mencari barang: ' + esc(msg) + '</div>')
                    .css({top: o.top + $inp.outerHeight(), left: o.left, width: 420}).show();
            });
        }, 250);
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.it-name, #rq-dd').length) { $('#rq-dd').hide(); }
    });

    if (OLD_ITEMS.length) {
        OLD_ITEMS.forEach(function (d) { addRow(d); });
    } else {
        for (var n = 0; n < 5; n++) { addRow(); }
    }
});
</script>