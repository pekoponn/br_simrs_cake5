<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Laboratorium', ['controller' => 'LabExaminations', 'action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Pemakaian Logistik</li>
</ol>
<h1 class="page-header">Pemakaian Logistik / Bahan Umum</h1>

<style>
    .lg-box { background:#fff; border:1px solid #cfd4e2; padding:10px 12px; margin-bottom:10px; }
    .lg-row { display:grid; grid-template-columns:130px 1fr; gap:8px; align-items:center; margin-bottom:6px; }
    .lg-row label { margin:0; font-weight:700; font-size:12px; }
    .lg-row .form-control { height:28px; font-size:12px; padding:2px 6px; }
    #items-table td { padding:3px !important; vertical-align:middle; background:#fff; }
    #items-table input { font-size:12px; height:27px; padding:2px 5px; }
    #item-dd, #reg-dd { display:none; position:absolute; z-index:9999; background:#fff; border:1px solid #ced4da; max-height:240px; overflow-y:auto; box-shadow:0 4px 12px rgba(0,0,0,.15); font-size:12px; }
    #item-dd div, #reg-dd div { padding:6px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; }
    #item-dd div:hover, #reg-dd div:hover { background:#e8f0fe; }
</style>

<?= $this->Form->create(null, ['id' => 'form-usage']) ?>

<div class="row">
    <div class="col-lg-6">
        <div class="lg-box">
            <div class="lg-row"><label>Gudang / Bagian</label>
                <?= $this->Form->select('warehouse', array_combine($warehouses, $warehouses), ['class' => 'form-control', 'empty' => '-- Pilih --']) ?></div>
            <div class="lg-row"><label>Cost Centre</label>
                <?= $this->Form->select('cost_centre', array_combine($costCentres, $costCentres), ['class' => 'form-control', 'empty' => '-- Pilih --']) ?></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="lg-box">
            <div class="lg-row"><label>Tr No</label><input type="text" class="form-control" value="<?= h($nextNo) ?>" readonly></div>
            <div class="lg-row"><label>Tanggal</label><?= $this->Form->date('usage_date', ['value' => date('Y-m-d'), 'class' => 'form-control']) ?></div>
            <div class="lg-row"><label>Keterangan</label><?= $this->Form->text('notes', ['class' => 'form-control']) ?></div>
        </div>
    </div>
</div>

<div class="lg-box">
    <div class="text-muted mb-2" style="font-size:12px;">Diisi bila item akan dibebankan ke pasien</div>
    <div class="row">
        <div class="col-lg-8">
            <div class="lg-row"><label>No Registrasi</label>
                <div style="position:relative;">
                    <input type="text" id="reg-search" name="registration_no" class="form-control" placeholder="Ketik no registrasi / nama pasien..." autocomplete="off">
                    <div id="reg-dd"></div>
                </div></div>
            <div class="lg-row"><label>Rek medis</label><input type="text" name="medical_record_no" id="reg-rm" class="form-control" readonly></div>
            <div class="lg-row"><label>Nama pasien</label><input type="text" name="patient_name" id="reg-name" class="form-control" readonly></div>
            <div class="lg-row"><label>Asal</label><input type="text" name="origin" id="reg-origin" class="form-control" readonly></div>
        </div>
        <div class="col-lg-4">
            <label class="text-danger" style="font-size:12px; font-weight:700;">
                <input type="checkbox" name="charge_to_patient" value="1" id="chk-charge"> Ceklist jika akan dibebankan ke pasien
            </label>
        </div>
    </div>
</div>

<div class="lg-box p-0">
    <div class="table-responsive" style="min-height:230px;">
        <table class="table table-bordered table-sm mb-0" id="items-table" style="font-size:12px;">
            <thead class="thead-dark">
                <tr>
                    <th style="width:130px;">Kode barang</th>
                    <th>Nama Barang</th>
                    <th style="width:90px;">Qty</th>
                    <th style="width:90px;">Unit</th>
                    <th style="width:120px;">Harga</th>
                    <th style="width:130px;">Total Harga</th>
                    <th style="width:36px;"></th>
                </tr>
            </thead>
            <tbody id="items-body"></tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <button type="button" class="btn btn-default" id="btn-add-row"><i class="fa fa-plus"></i> Tambah Baris</button>
        <button type="button" class="btn btn-default" id="btn-charge" title="Centang dan isi No Registrasi di atas">Dibebankan ke Pasien</button>
    </div>
    <div class="d-flex align-items-center" style="gap:10px;">
        <b>Total</b>
        <input type="text" id="grand-total" class="form-control text-right" style="width:160px;" value="0" readonly>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        <?= $this->Html->link('Daftar Transaksi', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        <?= $this->Html->link('Batal', ['controller' => 'LabExaminations', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
</div>

<?= $this->Form->end() ?>

<div id="item-dd"></div>

<script>
(function () {
    var SEARCH_ITEMS = '<?= $this->Url->build(['action' => 'searchItems']) ?>';
    var SEARCH_REG = '<?= $this->Url->build(['action' => 'searchRegistration']) ?>';
    var idx = 0, $activeRow = null, timer = null;

    function fmt(n){ return (parseFloat(n)||0).toLocaleString('id-ID'); }
    function esc(s){ return $('<div>').text(String(s==null?'':s)).html(); }

    function addRow() {
        var i = idx++;
        $('#items-body').append(
            '<tr data-i="'+i+'">'
            + '<td><input type="hidden" name="items['+i+'][item_id]" class="it-id"><input type="text" name="items['+i+'][item_code]" class="form-control it-code" readonly></td>'
            + '<td><input type="text" name="items['+i+'][item_name]" class="form-control it-name" autocomplete="off" placeholder="Ketik nama barang..."></td>'
            + '<td><input type="number" name="items['+i+'][qty]" class="form-control it-qty text-right" value="1" min="0" step="0.01"></td>'
            + '<td><input type="text" name="items['+i+'][unit]" class="form-control it-unit"></td>'
            + '<td><input type="number" name="items['+i+'][price]" class="form-control it-price text-right" value="0" min="0" step="0.01"></td>'
            + '<td><input type="text" class="form-control it-total text-right" value="0" readonly></td>'
            + '<td class="text-center"><button type="button" class="btn btn-xs btn-danger btn-del">&times;</button></td>'
            + '</tr>'
        );
    }

    function calc() {
        var g = 0;
        $('#items-body tr').each(function () {
            var t = (parseFloat($(this).find('.it-qty').val())||0) * (parseFloat($(this).find('.it-price').val())||0);
            $(this).find('.it-total').val(fmt(t));
            g += t;
        });
        $('#grand-total').val(fmt(g));
    }

    $('#btn-add-row').on('click', addRow);
    $('#btn-charge').on('click', function(){ $('#chk-charge').prop('checked', true); $('#reg-search').focus(); });
    $(document).on('click', '.btn-del', function(){ $(this).closest('tr').remove(); calc(); });
    $(document).on('input', '.it-qty, .it-price', calc);

    // autocomplete barang
    $(document).on('input', '.it-name', function () {
        var $inp = $(this), q = $.trim($inp.val());
        $activeRow = $inp.closest('tr');
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
                            $activeRow.find('.it-price').val(r.price || 0);
                            $dd.hide(); calc();
                        }).appendTo($dd);
                });
                var o = $inp.offset();
                $dd.css({top: o.top + $inp.outerHeight(), left: o.left, width: Math.max($inp.outerWidth(), 360)}).show();
            });
        }, 250);
    });

    // autocomplete registrasi
    var rtimer = null;
    $('#reg-search').on('input', function () {
        var $inp = $(this), q = $.trim($inp.val());
        clearTimeout(rtimer);
        if (q.length < 2) { $('#reg-dd').hide(); return; }
        rtimer = setTimeout(function () {
            $.getJSON(SEARCH_REG, {q: q}, function (rows) {
                var $dd = $('#reg-dd').empty();
                if (!rows.length) { $dd.html('<div class="text-muted">Tidak ditemukan</div>'); }
                var map = {rawat_jalan:'Rawat Jalan', rawat_inap:'Rawat Inap', igd:'IGD'};
                $.each(rows, function (_, r) {
                    $('<div>').html('<b>'+esc(r.registration_no)+'</b> - '+esc(r.patient_name)+' <small class="text-muted">'+esc(r.rm)+'</small>')
                        .on('mousedown', function (e) {
                            e.preventDefault();
                            $('#reg-search').val(r.registration_no);
                            $('#reg-rm').val(r.rm);
                            $('#reg-name').val(r.patient_name);
                            $('#reg-origin').val(map[r.service_type] || r.service_type || '');
                            $('#chk-charge').prop('checked', true);
                            $dd.hide();
                        }).appendTo($dd);
                });
                $dd.css({top: $inp.outerHeight(), left: 0, width: Math.max($inp.outerWidth(), 360)}).show();
            });
        }, 250);
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.it-name, #item-dd').length) $('#item-dd').hide();
        if (!$(e.target).closest('#reg-search, #reg-dd').length) $('#reg-dd').hide();
    });

    addRow();
})();
</script>