<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Farmasi</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Pemakaian BHP', ['action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Non Beban</li>
</ol>
<h1 class="page-header">Pemakaian Non Beban BHP</h1>

<style>
    .lg-box { background:#fff; border:1px solid #cfd4e2; padding:10px 12px; margin-bottom:10px; }
    .lg-head { background:#0a3d7c; color:#fff; padding:8px 12px; margin:-10px -12px 10px; font-weight:700; font-style:italic; }
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

<div class="lg-box">
    <div class="lg-head d-flex justify-content-between align-items-center">
        <span>Pemakaian Non Beban BHP</span>
        <span style="font-style:normal;">Antri
            <input type="number" name="queue_no" value="0" min="0" class="text-right" style="width:70px; color:#000;">
        </span>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="lg-row"><label>No. TR</label><input type="text" class="form-control" value="<?= h($nextNo) ?>" readonly></div>
            <div class="lg-row"><label>Depo</label>
                <?= $this->Form->select('depo', array_combine($depos, $depos), ['class' => 'form-control', 'empty' => '-- Pilih --']) ?></div>
            <div class="lg-row"><label>Pembeli</label>
                <div>
                    <label class="mr-3"><input type="radio" name="buyer_type" value="pasien" checked> Pasien</label>
                    <label><input type="radio" name="buyer_type" value="unit"> Unit</label>
                </div></div>
            <div class="lg-row" id="row-unit" style="display:none;"><label>Unit / Cost Centre</label>
                <?= $this->Form->select('unit_name', array_combine($units, $units), ['class' => 'form-control', 'empty' => '-- Pilih --']) ?></div>
        </div>
        <div class="col-lg-6">
            <div class="lg-row"><label>Tanggal</label><?= $this->Form->date('usage_date', ['value' => date('Y-m-d'), 'class' => 'form-control']) ?></div>
            <div class="lg-row"><label>Jam</label><?= $this->Form->time('usage_time', ['value' => date('H:i'), 'class' => 'form-control']) ?></div>
            <div class="lg-row"><label>Dari</label><?= $this->Form->text('origin', ['id' => 'f-origin', 'class' => 'form-control']) ?></div>
            <div class="lg-row"><label>Kelas</label><?= $this->Form->text('class_name', ['class' => 'form-control']) ?></div>
        </div>
    </div>
</div>

<div class="lg-box" id="box-patient">
    <div class="row">
        <div class="col-lg-6">
            <div class="lg-row"><label>No Registrasi</label>
                <div style="position:relative;">
                    <input type="text" id="reg-search" name="registration_no" class="form-control" placeholder="Ketik no registrasi / nama pasien..." autocomplete="off">
                    <input type="hidden" name="registration_id" id="reg-id">
                    <div id="reg-dd"></div>
                </div></div>
            <div class="lg-row"><label>Nama Pasien</label><input type="text" name="patient_name" id="reg-name" class="form-control" readonly></div>
        </div>
        <div class="col-lg-6">
            <div class="lg-row"><label>Rek</label><input type="text" name="medical_record_no" id="reg-rm" class="form-control" readonly></div>
            <div class="lg-row"><label>Dokter</label><input type="text" name="doctor_name" id="reg-doctor" class="form-control"></div>
            <div class="lg-row"><label>Phone</label><?= $this->Form->text('phone', ['class' => 'form-control']) ?></div>
        </div>
    </div>
</div>

<div class="lg-box p-0">
    <div class="table-responsive" style="min-height:230px;">
        <table class="table table-bordered table-sm mb-0" id="items-table" style="font-size:12px;">
            <thead class="thead-dark">
                <tr>
                    <th style="width:120px;">Kode barang</th>
                    <th style="min-width:200px;">Nama barang</th>
                    <th style="width:75px;">Qty</th>
                    <th style="width:80px;">Satuan</th>
                    <th style="width:100px;">Harga</th>
                    <th style="width:65px;">Disc %</th>
                    <th style="width:65px;">PPN %</th>
                    <th style="width:90px;">PPN Rp</th>
                    <th style="width:110px;">Total harga</th>
                    <th style="width:130px;">Tgl kadaluarsa</th>
                    <th style="min-width:140px;">Aturan pakai</th>
                    <th style="width:80px;">No. rak</th>
                    <th style="width:36px;"></th>
                </tr>
            </thead>
            <tbody id="items-body"></tbody>
        </table>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-8">
        <button type="button" class="btn btn-default" id="btn-add-row"><i class="fa fa-plus"></i> Tambah Baris</button>
    </div>
    <div class="col-lg-4">
        <table class="table table-sm mb-2">
            <tr><th>Subtotal</th><td class="text-right" id="t-sub">0</td></tr>
            <tr><th>Diskon</th><td class="text-right" id="t-disc">0</td></tr>
            <tr><th>Pajak</th><td class="text-right" id="t-tax">0</td></tr>
            <tr><th>Total Net</th><td class="text-right"><b id="t-net">0</b></td></tr>
        </table>
        <div class="text-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<?= $this->Form->end() ?>

<div id="item-dd"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var SEARCH_ITEMS = '<?= $this->Url->build(['action' => 'searchItems']) ?>';
    var SEARCH_REG = '<?= $this->Url->build(['action' => 'searchRegistration']) ?>';
    var idx = 0, $activeRow = null, timer = null, rtimer = null;

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
            + '<td><input type="number" name="items['+i+'][disc_percent]" class="form-control it-disc text-right" value="0" min="0" max="100" step="0.01"></td>'
            + '<td><input type="number" name="items['+i+'][ppn_percent]" class="form-control it-ppn text-right" value="0" min="0" max="100" step="0.01"></td>'
            + '<td><input type="text" class="form-control it-ppnrp text-right" value="0" readonly></td>'
            + '<td><input type="text" class="form-control it-total text-right" value="0" readonly></td>'
            + '<td><input type="date" name="items['+i+'][expired_date]" class="form-control"></td>'
            + '<td><input type="text" name="items['+i+'][usage_rule]" class="form-control"></td>'
            + '<td><input type="text" name="items['+i+'][shelf_no]" class="form-control it-shelf"></td>'
            + '<td class="text-center"><button type="button" class="btn btn-xs btn-danger btn-del">&times;</button></td>'
            + '</tr>'
        );
    }

    // Hanya tampilan; angka final dihitung ulang di controller
    function calc() {
        var sub = 0, disc = 0, tax = 0;
        $('#items-body tr').each(function () {
            var $r = $(this);
            var q = parseFloat($r.find('.it-qty').val())||0, p = parseFloat($r.find('.it-price').val())||0;
            var d = parseFloat($r.find('.it-disc').val())||0, t = parseFloat($r.find('.it-ppn').val())||0;
            var gross = q*p, da = gross*d/100, pp = (gross-da)*t/100;
            $r.find('.it-ppnrp').val(fmt(pp));
            $r.find('.it-total').val(fmt(gross-da+pp));
            sub += gross; disc += da; tax += pp;
        });
        $('#t-sub').text(fmt(sub)); $('#t-disc').text(fmt(disc));
        $('#t-tax').text(fmt(tax)); $('#t-net').text(fmt(sub-disc+tax));
    }

    $('#btn-add-row').on('click', addRow);
    $(document).on('click', '.btn-del', function(){ $(this).closest('tr').remove(); calc(); });
    $(document).on('input', '.it-qty, .it-price, .it-disc, .it-ppn', calc);

    // pasien / unit
    $('input[name=buyer_type]').on('change', function () {
        var isUnit = $('input[name=buyer_type]:checked').val() === 'unit';
        $('#box-patient').toggle(!isUnit);
        $('#row-unit').toggle(isUnit);
    });

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
                            $('#reg-id').val(r.id);
                            $('#reg-search').val(r.registration_no);
                            $('#reg-rm').val(r.rm);
                            $('#reg-name').val(r.patient_name);
                            $('#reg-doctor').val(r.doctor_name || '');
                            $('#f-origin').val(map[r.service_type] || r.service_type || '');
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
});
</script>