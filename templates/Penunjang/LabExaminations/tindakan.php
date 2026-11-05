<?php
/**
 * templates/LabExaminations/tindakan.php
 *
 * Variabel dari controller (semua opsional, ada default):
 *   $labNo, $titles, $payMethods, $classes, $responsibleDoctors, $senderDoctors,
 *   $officers, $officer, $exam (entity bila edit)
 */
$labNo = $labNo ?? '';
$titles = $titles ?? ['Tn' => 'Tn', 'Ny' => 'Ny', 'Nn' => 'Nn', 'An' => 'An', 'By' => 'By'];
$payMethods = $payMethods ?? [];
$classes = $classes ?? [];
$responsibleDoctors = $responsibleDoctors ?? [];
$senderDoctors = $senderDoctors ?? [];
$officers = $officers ?? [];
?>
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Laboratorium', ['action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Tindakan Laboratorium</li>
</ol>
<h1 class="page-header">Tindakan Laboratorium <small>Tindakan unit Laboratorium</small></h1>

<?= $this->Form->create(null, ['id' => 'form-tindakan']) ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-vial"></i> Laboratorium</h4>
    </div>
    <div class="panel-body">

        <!-- Jenis pasien + barcode -->
        <div class="form-row align-items-center mb-3">
            <div class="col-md-6">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="pt-rs" name="patient_origin" value="rs" class="custom-control-input" checked>
                    <label class="custom-control-label" for="pt-rs">Pasien RS</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="pt-luar" name="patient_origin" value="luar" class="custom-control-input">
                    <label class="custom-control-label" for="pt-luar">Pasien Luar</label>
                </div>
            </div>
            <div class="col-md-6">
                <input type="text" id="barcode" class="form-control form-control-sm" placeholder="Barcode Auto Scan" autocomplete="off">
            </div>
        </div>

        <div class="row">
            <!-- ===== KOLOM KIRI: data pasien ===== -->
            <div class="col-lg-7">
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label col-form-label-sm">No. Lab</label>
                    <div class="col-sm-5">
                        <input type="text" name="lab_no" value="<?= h($labNo) ?>" class="form-control form-control-sm" readonly placeholder="Otomatis">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label col-form-label-sm">No Registrasi</label>
                    <div class="col-sm-5">
                        <div class="input-group input-group-sm">
                            <input type="text" name="registration_no" id="registration_no" class="form-control">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-warning" id="btn-cari-reg" title="Cari registrasi"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-1 col-form-label col-form-label-sm text-right">No.</label>
                    <div class="col-sm-3">
                        <input type="text" name="queue_no" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="date" name="exam_date" value="<?= date('Y-m-d') ?>" class="form-control form-control-sm">
                    </div>
                    <label class="col-sm-2 col-form-label col-form-label-sm text-right">Jam</label>
                    <div class="col-sm-3">
                        <input type="time" name="exam_time" value="<?= date('H:i') ?>" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Nama</label>
                    <div class="col-sm-3">
                        <?= $this->Form->select('title', $titles, ['class' => 'form-control form-control-sm', 'empty' => '-']) ?>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="patient_name" id="patient_name" class="form-control form-control-sm" placeholder="Nama pasien">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Tgl Lahir</label>
                    <div class="col-sm-4">
                        <input type="date" name="birth_date" id="birth_date" class="form-control form-control-sm">
                    </div>
                    <label class="col-sm-1 col-form-label col-form-label-sm text-right">Umur</label>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm">
                            <input type="number" id="age_y" name="age_y" class="form-control text-right" value="0" readonly>
                            <div class="input-group-append"><span class="input-group-text">TH</span></div>
                            <input type="number" id="age_m" name="age_m" class="form-control text-right" value="0" readonly>
                            <div class="input-group-append"><span class="input-group-text">BL</span></div>
                            <input type="number" id="age_d" name="age_d" class="form-control text-right" value="0" readonly>
                            <div class="input-group-append"><span class="input-group-text">HR</span></div>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label col-form-label-sm">J. Kelamin</label>
                    <div class="col-sm-4">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sx-p" name="gender" value="L" class="custom-control-input" checked>
                            <label class="custom-control-label" for="sx-p">Pria</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sx-w" name="gender" value="P" class="custom-control-input">
                            <label class="custom-control-label" for="sx-w">Wanita</label>
                        </div>
                    </div>
                    <label class="col-sm-1 col-form-label col-form-label-sm text-right">Diagnosa</label>
                    <div class="col-sm-4">
                        <input type="text" name="diagnosis" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <label class="col-sm-3 col-form-label col-form-label-sm">Cara Bayar</label>
                    <div class="col-sm-4">
                        <?= $this->Form->select('pay_method_id', $payMethods, ['class' => 'form-control form-control-sm', 'empty' => '-']) ?>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="insurance_no" class="form-control form-control-sm" placeholder="No. kartu / penjamin">
                    </div>
                </div>
            </div>

            <!-- ===== KOLOM KANAN: pengirim ===== -->
            <div class="col-lg-5">
                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Dari</label>
                    <div class="col-sm-5">
                        <input type="text" name="origin_unit" class="form-control form-control-sm" placeholder="Poli / ruangan">
                    </div>
                    <div class="col-sm-3">
                        <?= $this->Form->select('class_id', $classes, ['class' => 'form-control form-control-sm', 'empty' => 'Kelas']) ?>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Dokter Pen. Jawab</label>
                    <div class="col-sm-8">
                        <?= $this->Form->select('responsible_doctor_id', $responsibleDoctors, ['class' => 'form-control form-control-sm', 'empty' => '-']) ?>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Dr. Pengirim</label>
                    <div class="col-sm-8">
                        <?= $this->Form->select('sender_doctor_id', $senderDoctors, ['class' => 'form-control form-control-sm', 'empty' => '-']) ?>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Petugas</label>
                    <div class="col-sm-8">
                        <?= $this->Form->select('officer_id', $officers, ['class' => 'form-control form-control-sm', 'empty' => '-']) ?>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label col-form-label-sm">Jenis</label>
                    <div class="col-sm-8">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="jn-dr" name="request_type" value="dokter" class="custom-control-input" checked>
                            <label class="custom-control-label" for="jn-dr">Dikirim Dr</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="jn-sendiri" name="request_type" value="sendiri" class="custom-control-input">
                            <label class="custom-control-label" for="jn-sendiri">Atas Permintaan Sendiri</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-4 col-form-label col-form-label-sm">System</label>
                    <div class="col-sm-8">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sy-dalam" name="system" value="dalam" class="custom-control-input" checked>
                            <label class="custom-control-label" for="sy-dalam">Lab dalam</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="sy-rujuk" name="system" value="dirujuk" class="custom-control-input">
                            <label class="custom-control-label" for="sy-rujuk">Dirujuk</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label class="col-sm-4 col-form-label col-form-label-sm">No. E-Order</label>
                    <div class="col-sm-8">
                        <input type="text" name="order_no" id="order_no" class="form-control form-control-sm" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-10">

        <!-- ===== Tabel pemeriksaan ===== -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-flask"></i> Pemeriksaan</h4>
                <div class="panel-heading-btn">
                    <button type="button" class="btn btn-xs btn-success" id="btn-add-exam"><i class="fa fa-plus"></i> Tambah</button>
                </div>
            </div>
            <div class="panel-body p-0">
                <div class="table-responsive" style="max-height:260px; overflow-y:auto;">
                    <table class="table table-bordered table-sm mb-0" id="tbl-exam">
                        <thead class="thead-dark" style="position:sticky; top:0;">
                            <tr>
                                <th style="width:110px;">Kode</th>
                                <th>Nama Pemeriksaan</th>
                                <th style="width:120px;">Jenis</th>
                                <th style="width:110px;" class="text-right">Tarif RS</th>
                                <th style="width:110px;" class="text-right">Jasa Dokter</th>
                                <th style="width:110px;" class="text-right">Insentif Rp</th>
                                <th style="width:100px;" class="text-right">Diskon RS</th>
                                <th style="width:100px;" class="text-right">Diskon dr</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer text-right">
                <b>Total :</b> <span class="h4 ml-2" id="grand-total">0,00</span>
            </div>
        </div>

        <!-- ===== Pemakaian inventory ===== -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-boxes"></i> Pemakaian Inventory</h4>
                <div class="panel-heading-btn">
                    <button type="button" class="btn btn-xs btn-success" id="btn-add-inv"><i class="fa fa-plus"></i> Tambah</button>
                </div>
            </div>
            <div class="panel-body p-0">
                <div class="table-responsive" style="max-height:180px; overflow-y:auto;">
                    <table class="table table-bordered table-sm mb-0" id="tbl-inv">
                        <thead class="thead-dark" style="position:sticky; top:0;">
                            <tr>
                                <th style="width:110px;">Kode</th>
                                <th>Nama Alkes / Obat</th>
                                <th style="width:80px;" class="text-right">Qty</th>
                                <th style="width:100px;">Satuan</th>
                                <th style="width:110px;" class="text-right">Harga</th>
                                <th style="width:120px;" class="text-right">Total Harga</th>
                                <th style="width:120px;">LOK/UNIT</th>
                                <th style="width:90px;" class="text-center">Dibebankan</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button type="button" class="btn btn-default" id="btn-bayar"><i class="fa fa-money-bill"></i> Bayar</button>
            <button type="button" class="btn btn-default" id="btn-label"><i class="fa fa-tag"></i> Label Pemeriksaan</button>
            <button type="button" class="btn btn-default" id="btn-hasil-lain">HASIL LAIN</button>
            <?= $this->Html->link('<i class="fa fa-times"></i> Batal', ['action' => 'index'], ['class' => 'btn btn-danger float-right', 'escape' => false]) ?>
        </div>
    </div>

    <!-- ===== Tombol aksi samping ===== -->
    <div class="col-lg-2">
        <div class="panel panel-inverse">
            <div class="panel-heading"><h4 class="panel-title">Aksi</h4></div>
            <div class="panel-body p-2">
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-syringe"></i> Pengambilan Spesimen</a>
                <a href="javascript:;" class="btn btn-primary btn-block text-left mb-1"><i class="fa fa-file-medical"></i> Isi Hasil</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-file-alt"></i> Hasil Text</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-upload"></i> Upload Hasil</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-print"></i> Cetak Hasil</a>
                <a href="javascript:;" class="btn btn-info btn-block text-left mb-1"><i class="fa fa-history"></i> History Hasil By Rekmed</a>
                <a href="javascript:;" class="btn btn-info btn-block text-left"><i class="fa fa-history"></i> History Hasil By No Reg</a>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->end() ?>

<style>
#tbl-exam input, #tbl-inv input { border: 0; background: transparent; width: 100%; padding: 2px 4px; }
#tbl-exam input:focus, #tbl-inv input:focus { background: #fffbe6; outline: 1px solid #f59c1a; }
#tbl-exam td, #tbl-inv td { padding: 0; vertical-align: middle; }
</style>

<script>
(function () {
    var fmt = function (n) { return (n || 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2}); };
    var num = function (v) { return parseFloat(v) || 0; };

    // ---------- Umur dari tanggal lahir ----------
    var birth = document.getElementById('birth_date');
    birth.addEventListener('change', function () {
        if (!birth.value) return;
        var b = new Date(birth.value), n = new Date();
        var y = n.getFullYear() - b.getFullYear(), m = n.getMonth() - b.getMonth(), d = n.getDate() - b.getDate();
        if (d < 0) { m--; d += new Date(n.getFullYear(), n.getMonth(), 0).getDate(); }
        if (m < 0) { y--; m += 12; }
        document.getElementById('age_y').value = Math.max(y, 0);
        document.getElementById('age_m').value = m;
        document.getElementById('age_d').value = d;
    });

    // ---------- Tabel pemeriksaan ----------
    var examBody = document.querySelector('#tbl-exam tbody');
    var examIdx = 0;
    function addExam() {
        var i = examIdx++;
        var tr = document.createElement('tr');
        tr.innerHTML =
            '<td><input name="items[' + i + '][code]"></td>' +
            '<td><input name="items[' + i + '][name]"></td>' +
            '<td><input name="items[' + i + '][type]"></td>' +
            '<td><input name="items[' + i + '][price]" class="text-right calc" type="number" step="any" value="0"></td>' +
            '<td><input name="items[' + i + '][doctor_fee]" class="text-right calc" type="number" step="any" value="0"></td>' +
            '<td><input name="items[' + i + '][incentive]" class="text-right calc" type="number" step="any" value="0"></td>' +
            '<td><input name="items[' + i + '][disc_rs]" class="text-right calc" type="number" step="any" value="0"></td>' +
            '<td><input name="items[' + i + '][disc_dr]" class="text-right calc" type="number" step="any" value="0"></td>' +
            '<td class="text-center"><a href="javascript:;" class="text-danger btn-del"><i class="fa fa-times"></i></a></td>';
        examBody.appendChild(tr);
        tr.querySelector('input').focus();
    }
    function calcTotal() {
        var total = 0;
        examBody.querySelectorAll('tr').forEach(function (tr) {
            var v = function (k) { return num(tr.querySelector('[name$="[' + k + ']"]').value); };
            total += v('price') + v('doctor_fee') + v('incentive') - v('disc_rs') - v('disc_dr');
        });
        document.getElementById('grand-total').textContent = fmt(total);
    }
    examBody.addEventListener('input', function (e) { if (e.target.classList.contains('calc')) calcTotal(); });
    examBody.addEventListener('click', function (e) {
        var del = e.target.closest('.btn-del');
        if (del) { del.closest('tr').remove(); calcTotal(); }
    });
    document.getElementById('btn-add-exam').addEventListener('click', addExam);

    // ---------- Tabel inventory ----------
    var invBody = document.querySelector('#tbl-inv tbody');
    var invIdx = 0;
    function addInv() {
        var i = invIdx++;
        var tr = document.createElement('tr');
        tr.innerHTML =
            '<td><input name="inventory[' + i + '][code]"></td>' +
            '<td><input name="inventory[' + i + '][name]"></td>' +
            '<td><input name="inventory[' + i + '][qty]" class="text-right inv-calc" type="number" step="any" value="0"></td>' +
            '<td><input name="inventory[' + i + '][unit]"></td>' +
            '<td><input name="inventory[' + i + '][price]" class="text-right inv-calc" type="number" step="any" value="0"></td>' +
            '<td><input name="inventory[' + i + '][total]" class="text-right" readonly value="0"></td>' +
            '<td><input name="inventory[' + i + '][location]"></td>' +
            '<td class="text-center"><input type="checkbox" name="inventory[' + i + '][charge_patient]" value="1" style="width:auto"></td>' +
            '<td class="text-center"><a href="javascript:;" class="text-danger btn-del"><i class="fa fa-times"></i></a></td>';
        invBody.appendChild(tr);
        tr.querySelector('input').focus();
    }
    invBody.addEventListener('input', function (e) {
        if (!e.target.classList.contains('inv-calc')) return;
        var tr = e.target.closest('tr');
        var q = num(tr.querySelector('[name$="[qty]"]').value), p = num(tr.querySelector('[name$="[price]"]').value);
        tr.querySelector('[name$="[total]"]').value = (q * p).toFixed(2);
    });
    invBody.addEventListener('click', function (e) {
        var del = e.target.closest('.btn-del');
        if (del) del.closest('tr').remove();
    });
    document.getElementById('btn-add-inv').addEventListener('click', addInv);

    // baris awal
    addExam(); addInv();
})();
</script>