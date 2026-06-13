<?php
$p = $patient;
$r = $registration;

$serviceType = $r->service_type ?? '-';
$asalPasien = '-';

if ($serviceType === 'rawat_jalan') {
    $asalPasien = 'Rawat Jalan';
} elseif ($serviceType === 'rawat_inap') {
    $asalPasien = 'Rawat Inap';
} elseif ($serviceType === 'igd') {
    $asalPasien = 'Rawat IGD';
} else {
    $asalPasien = ucwords(str_replace('_', ' ', (string)$serviceType));
}
?>

<div class="orders content" style="font-size:12px;">

<?= $this->Form->create($order, [
    'url' => ['action' => 'form', $r->id ?? null],
    'id' => 'form-order',
    'novalidate' => true,
]) ?>

<?= $this->Form->hidden('registration_id', ['value' => $r->id ?? '']) ?>
<?= $this->Form->hidden('patient_id', ['value' => $p->id ?? '']) ?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
    <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
        <i class="fa fa-file-prescription"></i> Form E-Order Obat &amp; Pemeriksaan
    </h4>
    <?= $this->Html->link(
        '<i class="fa fa-arrow-left"></i> Kembali',
        ['action' => 'index'],
        ['escape' => false, 'class' => 'btn btn-default btn-sm']
    ) ?>
</div>

<div class="row">

<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading" style="padding:8px 12px; background:#1e3a5f;">
            <strong style="font-size:12px; color:#fff;">
                <i class="fa fa-search"></i> Cari Pasien
            </strong>
        </div>
        <div class="panel-body" style="padding:8px;">
            <div class="input-group input-group-sm">
                <input type="text" id="search-patient-input"
                       class="form-control"
                       placeholder="No RM / Nama pasien..."
                       autocomplete="off">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="btn-search-patient">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
            <div id="patient-search-results" style="display:none; margin-top:6px;
                 border:1px solid #ddd; border-radius:4px; background:#fff;
                 max-height:200px; overflow-y:auto; font-size:11px; z-index:999;">
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" style="padding:8px 12px; background:#1e3a5f;">
            <strong style="font-size:12px; color:#fff;">
                <i class="fa fa-history"></i> History Order Pasien
            </strong>
        </div>
        <div class="panel-body" style="padding:0;">
            <table class="table table-condensed table-hover" style="font-size:11px; margin:0;">
                <thead>
                    <tr style="background:#e9ecef;">
                        <th>No Order</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="history-tbody">
                    <?php if (!empty($historyOrders) && count($historyOrders) > 0): ?>
                        <?php foreach ($historyOrders as $h): ?>
                            <tr class="history-order-row"
                                data-id="<?= $h->id ?>"
                                data-detail-url="<?= h($this->Url->build([
                                    'action' => 'historyOrderDetail',
                                    $h->id,
                                ])) ?>"
                                style="cursor:pointer;">

                                <td>
                                    <strong style="color:#1e3a5f;">
                                        <?= h($h->no_order) ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= $h->tgl_order->format('d-m-Y') ?>
                                </td>

                                <td>
                                    <span class="label"
                                        style="background:<?= h($h->order_status->warna ?? '#6c757d') ?>;">
                                        <?= h($h->order_status->nama ?? '-') ?>
                                    </span>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="history-empty">
                            <td colspan="3" style="text-align:center; color:#aaa; padding:16px; font-size:11px;">
                                <i class="fa fa-inbox"></i><br>
                                Belum ada history order
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-9">

<div id="mode-history"
     style="display:none; background:#fff3cd; border:1px solid #ffeeba; color:#856404; padding:8px 12px; margin-bottom:8px; font-weight:700;">
    MODE HISTORY ORDER - HANYA UNTUK MELIHAT
</div>

<div class="panel panel-default">
    <div class="panel-heading" style="padding:8px 12px; background:#1e3a5f;">
        <strong style="font-size:12px; color:#fff;">
            <i class="fa fa-file-prescription"></i> Head Order / Info Patient
        </strong>
    </div>

    <div class="panel-body" style="padding:10px 12px; background:#f8f9fa;">
        <div class="row" style="margin-bottom:6px;">
            <div class="col-md-2">
                <label>No Order</label>
                <input type="text" id="info-no-order" class="form-control input-sm" value="AUTO" readonly>
            </div>

            <div class="col-md-2">
                <label>No Registrasi</label>
                <input type="text" id="info-no-registrasi" class="form-control input-sm"
                       value="<?= h($r->registration_no ?? $r->registration_number ?? '-') ?>" readonly>
            </div>

            <div class="col-md-2">
                <label>No RM</label>
                <input type="text" id="info-no-rm" class="form-control input-sm"
                       value="<?= h($p->code ?? '-') ?>" readonly>
            </div>

            <div class="col-md-3">
                <label>Nama Pasien</label>
                <input type="text" id="info-nama-pasien" class="form-control input-sm"
                       value="<?= h($p->full_name ?? '-') ?>" readonly>
            </div>

            <div class="col-md-3">
                <label>Jaminan</label>
                <input type="text" id="info-jaminan" class="form-control input-sm"
                       value="<?= h($r->insurance_type ?? $r->payment_method ?? 'UMUM') ?>" readonly>
            </div>
        </div>

        <div class="row" style="margin-bottom:6px;">
            <div class="col-md-2">
                <label>Tgl Order</label>
                <input type="text" id="info-tgl-order" class="form-control input-sm" value="<?= date('d-m-Y') ?>" readonly>
            </div>

            <div class="col-md-2">
                <label>Jam Order</label>
                <input type="text" id="info-jam-order" class="form-control input-sm" value="<?= date('H:i:s') ?>" readonly>
            </div>

            <div class="col-md-2">
                <label>Umur</label>
                <input type="text" id="info-umur" class="form-control input-sm"
                       value="<?php
                       if (!empty($p->birth_date)) {
                           $birth = is_object($p->birth_date) ? $p->birth_date->format('Y-m-d') : $p->birth_date;
                           echo h((new DateTime())->diff(new DateTime($birth))->y . ' Th');
                       } else {
                           echo '-';
                       }
                       ?>" readonly>
            </div>

            <div class="col-md-3">
                <label>Dokter</label>
                <?= $this->Form->control('doctor_id', [
                    'type' => 'select',
                    'label' => false,
                    'options' => $doctorList,
                    'empty' => '-- Pilih Dokter --',
                    'class' => 'form-control input-sm input-new-order',
                    'id' => 'info-dokter',
                    'required' => true,
                    'value' => $order->doctor_id ?? null,
                ]) ?>
            </div>

            <div class="col-md-3">
                <label>Dibuat Oleh</label>
                <input type="text" class="form-control input-sm"
                       value="<?= h($createdByName ?? 'Admin') ?>" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <label>Asal Pasien</label>
                <input type="text"
                       id="info-asal-pasien"
                       class="form-control input-sm"
                       value="<?= h($asalPasien) ?>"
                       readonly>
            </div>

            <div class="col-md-9">
                <label>Pesan</label>
                <?= $this->Form->control('pesan', [
                    'type' => 'text',
                    'label' => false,
                    'id' => 'info-pesan',
                    'class' => 'form-control input-sm input-new-order',
                    'placeholder' => 'Pesan dokter / instruksi khusus...',
                    'value' => $order->pesan ?? ''
                ]) ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
<div class="panel-heading" style="padding:0; background:#f5f7fa;">
    <ul class="nav nav-tabs" id="order-tabs" style="border-bottom:0; margin:0;">
        <li class="active"><a href="#tab-resep" data-toggle="tab">Resep</a></li>
        <li><a href="#tab-lab" data-toggle="tab">Laboratorium</a></li>
        <li><a href="#tab-radio" data-toggle="tab">Radiologi</a></li>
        <li><a href="#tab-penunjang" data-toggle="tab">Penunjang</a></li>
        <li><a href="#tab-bedah" data-toggle="tab">Bedah</a></li>
        <li><a href="#tab-mcu" data-toggle="tab">MCU</a></li>
        <li><a href="#tab-gizi" data-toggle="tab">Gizi</a></li>
    </ul>
</div>

<div class="panel-body" style="padding:8px 10px; min-height:300px; margin:10px;">
<div class="tab-content">

<div id="tab-resep" class="tab-pane active">

    <div class="resep-topbar">
        <button type="button" class="btn btn-xs btn-default input-new-order">Tambah Puyer / Racikan</button>
        <button type="button" class="btn btn-xs btn-default input-new-order">Ambil Resep Sebelumnya</button>
        <button type="button" class="btn btn-xs btn-default input-new-order">Template Resep</button>
        <label class="alkes-label input-new-order">
            <input type="checkbox" id="chk-alkes"> ALKES
        </label>
    </div>

    <div class="resep-searchbar">
        <input type="text" id="drug-search-input"
               class="form-control input-sm input-new-order"
               placeholder="Ketik minimal 2 karakter nama obat atau generic..."
               autocomplete="off">

        <label class="depo-label">Lokasi DEPO</label>

        <?= $this->Form->select(
            'lokasi_depo',
            array_combine($depoList, $depoList),
            [
                'class' => 'form-control input-sm depo-select input-new-order',
                'id' => 'info-lokasi-depo',
                'value' => $order->lokasi_depo ?? 'FARMASI 2 RAJAL DEPO',
            ]
        ) ?>
    </div>

    <div id="drug-dropdown"></div>

    <div style="overflow-x:auto;">
        <table class="table table-bordered table-sm" id="resep-table"
               style="font-size:11px; min-width:980px;">
            <thead>
                <tr style="background:#dbeafe;">
                    <th style="width:20px;"></th>
                    <th style="width:90px;">Kode</th>
                    <th style="width:55px;">Kronis</th>
                    <th style="min-width:210px;">Nama Obat</th>
                    <th style="width:80px; text-align:center;">Jml Obat / Hari</th>
                    <th style="width:80px; text-align:center;">Qty Minum</th>
                    <th style="width:70px; text-align:center;">Jml Hari</th>
                    <th style="width:75px; text-align:center;">QtySatuan</th>
                    <th style="width:65px;">Satuan</th>
                    <th style="width:130px;">Aturan Pakai</th>
                    <th style="width:95px; text-align:right;">Harga</th>
                    <th style="width:95px; text-align:right;">Total Harga</th>
                    <th style="width:28px;"></th>
                </tr>
            </thead>
            <tbody id="resep-tbody"></tbody>
            <tfoot>
                <tr style="background:#f8f9fa;">
                    <td colspan="11" style="text-align:right; font-weight:700; padding-right:8px;">
                        Grand Total
                    </td>
                    <td style="text-align:right; font-weight:700;" id="resep-grand-total">
                        Rp 0
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row resep-bottom">
        <div class="col-md-5">
            <label>Obat Lain</label>
            <?= $this->Form->textarea('obat_lain', [
                'class' => 'form-control input-sm input-new-order',
                'id' => 'obat-lain',
                'rows' => 3,
                'placeholder' => 'Isi obat lain bila tidak ada di master obat...',
            ]) ?>
        </div>

        <div class="col-md-5">
            <label>Catatan</label>
            <?= $this->Form->textarea('catatan', [
                'class' => 'form-control input-sm input-new-order',
                'id' => 'catatan-order',
                'rows' => 3,
                'placeholder' => 'Catatan order...',
            ]) ?>
        </div>

        <div class="col-md-2" style="padding-top:24px;">
            <button type="button" class="btn btn-default btn-sm btn-block input-new-order">
                Tambah Template
            </button>
        </div>
    </div>
</div>

<div id="tab-lab" class="tab-pane">
    <div class="lab-toolbar">
        <span class="text-muted">Pilih pemeriksaan dari master tindakan laboratorium.</span>
        <button type="button" class="btn btn-sm btn-primary input-new-order" id="btn-open-lab-master">
            <i class="fa fa-flask"></i> Tindakan Laboratorium
        </button>
    </div>

    <div class="lab-table-wrap">
        <table class="table table-bordered order-examination-table" id="laboratory-table">
            <thead>
                <tr>
                    <th style="width:35px;">No</th>
                    <th style="width:130px;">Kode</th>
                    <th>Nama Pemeriksaan</th>
                    <th style="width:150px; text-align:right;">Tarif Rp</th>
                    <th style="width:260px;">Keterangan (Approval)</th>
                    <th style="width:38px;"></th>
                </tr>
            </thead>
            <tbody id="laboratory-tbody">
                <tr class="laboratory-empty">
                    <td colspan="6" style="text-align:center;color:#999;padding:35px;">
                        Belum ada tindakan laboratorium yang dipilih.
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right; font-weight:700;">Total Laboratorium</td>
                    <td id="laboratory-total" style="text-align:right; font-weight:700;">Rp 0</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="form-group lab-note">
        <label>Catatan</label>
        <?= $this->Form->textarea('laboratory_note', [
            'class' => 'form-control input-new-order',
            'id' => 'laboratory-note',
            'rows' => 3,
            'placeholder' => 'Catatan tambahan pemeriksaan laboratorium...',
        ]) ?>
    </div>
</div>
<div id="tab-radio" class="tab-pane">
    <div class="lab-toolbar">
        <span class="text-muted">Pilih pemeriksaan dari master tindakan radiologi.</span>
        <button type="button" class="btn btn-sm btn-primary input-new-order" id="btn-open-radiology-master">
            <i class="fa fa-picture-o"></i> Tindakan Radiologi
        </button>
    </div>

    <div class="lab-table-wrap">
        <table class="table table-bordered order-examination-table" id="radiology-table">
            <thead>
                <tr>
                    <th style="width:35px;">No</th>
                    <th style="width:130px;">Kode</th>
                    <th>Nama Pemeriksaan</th>
                    <th style="width:150px; text-align:right;">Tarif Rp</th>
                    <th style="width:260px;">Keterangan (Approval)</th>
                    <th style="width:38px;"></th>
                </tr>
            </thead>
            <tbody id="radiology-tbody">
                <tr class="radiology-empty">
                    <td colspan="6" style="text-align:center;color:#999;padding:35px;">
                        Belum ada tindakan radiologi yang dipilih.
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right; font-weight:700;">Total Radiologi</td>
                    <td id="radiology-total" style="text-align:right; font-weight:700;">Rp 0</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="form-group lab-note">
        <label>Catatan</label>
        <?= $this->Form->textarea('radiology_note', [
            'class' => 'form-control input-new-order',
            'id' => 'radiology-note',
            'rows' => 3,
            'placeholder' => 'Catatan tambahan pemeriksaan radiologi...',
        ]) ?>
    </div>
</div>
<div id="tab-penunjang" class="tab-pane"><div style="text-align:center; padding:40px; color:#aaa;">Tab Penunjang — akan dikembangkan selanjutnya</div></div>
<div id="tab-bedah" class="tab-pane"><div style="text-align:center; padding:40px; color:#aaa;">Tab Bedah — akan dikembangkan selanjutnya</div></div>
<div id="tab-mcu" class="tab-pane"><div style="text-align:center; padding:40px; color:#aaa;">Tab MCU — akan dikembangkan selanjutnya</div></div>
<div id="tab-gizi" class="tab-pane"><div style="text-align:center; padding:40px; color:#aaa;">Tab Gizi — akan dikembangkan selanjutnya</div></div>

</div>
</div>
</div>

<div class="panel panel-default">
    <div class="panel-body" style="padding:10px; background:#fafafa;">
        <div class="row">
            <div class="col-md-2 col-xs-4" style="margin-bottom:5px;">
                <button type="button" id="btn-add-drug-row-footer"
                        class="btn btn-default btn-sm btn-block">
                    <i class="fa fa-plus"></i> TAMBAH
                </button>
             </div>
            <div class="col-md-2 col-xs-4" style="margin-bottom:5px;">
                <button type="submit" id="btn-simpan" name="action_btn" value="SUBMITTED"
                        class="btn btn-primary btn-sm btn-block">
                    <i class="fa fa-save"></i> SIMPAN
                </button>
            </div>
            <div class="col-md-2 col-xs-4" style="margin-bottom:5px;">
                <button type="button" class="btn btn-warning btn-sm btn-block"
                        onclick="window.print()">
                    <i class="fa fa-print"></i> CETAK
                </button>
            </div>
            <div class="col-md-2 col-xs-4 col-md-offset-4" style="margin-bottom:5px;">
                <?= $this->Html->link(
                    '<i class="fa fa-times"></i> KELUAR',
                    ['action' => 'index'],
                    ['escape' => false, 'class' => 'btn btn-danger btn-sm btn-block']
                ) ?>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->end() ?>

<div class="modal fade" id="laboratory-master-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#1e3a5f;color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup" style="color:#fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-flask"></i> Master Tindakan Laboratorium</h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm" style="margin-bottom:8px;">
                    <input type="text" id="laboratory-master-search" class="form-control"
                           placeholder="Cari kode atau nama pemeriksaan...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default" id="btn-search-laboratory-master">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>

                <div class="lab-master-list-wrap">
                    <table class="table table-bordered table-condensed" id="laboratory-master-table">
                        <thead>
                            <tr>
                                <th style="width:38px;"></th>
                                <th style="width:120px;">Kode</th>
                                <th>Nama Pemeriksaan</th>
                                <th style="width:140px;text-align:right;">Tarif</th>
                            </tr>
                        </thead>
                        <tbody id="laboratory-master-tbody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-select-laboratory-master">
                    <i class="fa fa-check"></i> Tambahkan ke Order
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="radiology-master-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#1e3a5f;color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup" style="color:#fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-picture-o"></i> Master Tindakan Radiologi</h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm" style="margin-bottom:8px;">
                    <input type="text" id="radiology-master-search" class="form-control"
                           placeholder="Cari kode atau nama pemeriksaan...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default" id="btn-search-radiology-master">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>

                <div class="lab-master-list-wrap">
                    <table class="table table-bordered table-condensed" id="radiology-master-table">
                        <thead>
                            <tr>
                                <th style="width:38px;"></th>
                                <th style="width:120px;">Kode</th>
                                <th>Nama Pemeriksaan</th>
                                <th style="width:140px;text-align:right;">Tarif</th>
                            </tr>
                        </thead>
                        <tbody id="radiology-master-tbody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-select-radiology-master">
                    <i class="fa fa-check"></i> Tambahkan ke Order
                </button>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>

<style>
.panel-heading strong { font-size:12px; }
#order-tabs > li > a { border-radius:0 !important; font-size:11px; font-weight:600; padding:8px 14px; color:#555; background:#f5f7fa; border:1px solid transparent; border-right:1px solid #ddd; margin-right:0; }
#order-tabs > li.active > a, #order-tabs > li.active > a:focus, #order-tabs > li.active > a:hover { background:#1e3a5f !important; color:#fff !important; border-color:#1e3a5f !important; }
#order-tabs > li > a:hover { background:#e9eef5 !important; color:#1e3a5f !important; }
.resep-topbar { display:flex; align-items:center; gap:6px; margin-bottom:6px; }
.resep-searchbar { display:flex; align-items:center; gap:8px; margin-bottom:8px; }
#drug-search-input { width:430px; }
.depo-label { margin:0 4px 0 8px; font-size:12px; font-weight:600; }
.depo-select { width:240px !important; display:inline-block; font-weight:700; }
.alkes-label { margin-left:4px; margin-bottom:0; font-size:11px; font-weight:600; }
.resep-row td { vertical-align:middle; padding:3px 4px !important; }
.resep-row input.form-control { height:26px; padding:2px 5px; font-size:11px; }
.resep-row input[type="number"]::-webkit-inner-spin-button, .resep-row input[type="number"]::-webkit-outer-spin-button { -webkit-appearance:none; }
.resep-row input[type="number"] { -moz-appearance:textfield; }
.resep-bottom { margin-top:8px; }
#patient-search-results .ps-item { padding:7px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; }
#patient-search-results .ps-item:hover { background:#e8f0fe; }
#patient-search-results .ps-item strong { color:#1e3a5f; }
#drug-dropdown { display:none; position:fixed; z-index:99999; background:#fff; border:1px solid #ced4da; border-radius:4px; box-shadow:0 4px 16px rgba(0,0,0,.15); max-height:300px; overflow-y:auto; width:500px; font-size:12px; }
#drug-dropdown .dd-item { padding:7px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; line-height:1.4; }
#drug-dropdown .dd-item:hover { background:#e8f0fe; }
#drug-dropdown .dd-item .d-name { font-weight:600; color:#1e3a5f; font-size:12px; }
#drug-dropdown .dd-item .d-meta { font-size:10px; color:#888; }
#drug-dropdown .dd-item .d-harga { color:#27ae60; font-weight:600; }
#drug-dropdown .dd-empty, #drug-dropdown .dd-loading { padding:12px; text-align:center; color:#888; font-size:12px; }
.history-row:hover td { background:#e8f0fe !important; }
.btn-history-order:hover { text-decoration:underline; }
.history-readonly-row td { background:#fffdf3 !important; }
.lab-toolbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; }
.lab-table-wrap { min-height:245px; overflow:auto; border:1px solid #cfd8e3; }
.order-examination-table { margin:0; min-width:850px; font-size:11px; }
.order-examination-table thead th { background:#dbeafe; border-color:#b8c9de; padding:6px; }
.order-examination-table td { padding:2px 4px; height:29px; vertical-align:middle; }
.order-examination-table input.form-control { height:25px; padding:2px 5px; font-size:11px; border-color:transparent; box-shadow:none; }
.order-examination-table input.form-control:focus { border-color:#66afe9; background:#fffef0; }
.order-examination-table tfoot td { background:#f8f9fa; padding:6px; }
.lab-note { margin-top:8px; max-width:620px; }
.lab-master-list-wrap { max-height:360px; overflow:auto; border:1px solid #d7dee8; }
#laboratory-master-table, #radiology-master-table { margin:0; font-size:11px; }
#laboratory-master-table thead th, #radiology-master-table thead th { background:#dbeafe; position:sticky; top:0; z-index:1; }
#laboratory-master-table tbody tr, #radiology-master-table tbody tr { cursor:pointer; }
#laboratory-master-table tbody tr:hover td, #radiology-master-table tbody tr:hover td { background:#eef5ff; }
.history-order-row {
    cursor: pointer;
    transition: all .15s ease;
}

.history-order-row:hover td {
    background: #dbeafe !important;
}

.history-order-row td {
    cursor: pointer;
}

.history-active td {
    background: #bfdbfe !important;
    font-weight: 600;
}
</style>

<script>
$(document).ready(function () {
    var CARI_OBAT_URL = '<?= $this->Url->build(['action' => 'cariObat']) ?>';
    var CARI_LAB_URL = '<?= $this->Url->build(['action' => 'searchLaboratoryActions']) ?>';
    var CARI_RADIOLOGY_URL = '<?= $this->Url->build(['action' => 'searchRadiologyActions']) ?>';
    var drugRowIndex = 0;
    var laboratoryRowIndex = 0;
    var radiologyRowIndex = 0;
    var isHistoryMode = false;

    $('#order-tabs a[data-toggle="tab"]').on('click shown.bs.tab', function () {
        $('#order-tabs > li').removeClass('active');
        $(this).closest('li').addClass('active');
    });

    var defaultInfo = {
        no_order: 'AUTO',
        no_rm: '<?= h($p->code ?? '-') ?>',
        nama: '<?= h($p->full_name ?? '-') ?>',
        jaminan: '<?= h($r->insurance_type ?? $r->payment_method ?? 'UMUM') ?>',
        tgl_order: '<?= date('d-m-Y') ?>',
        jam_order: '<?= date('H:i:s') ?>',
        asal_pasien: '<?= h($asalPasien) ?>',
        pesan: '',
        doctor_id: ''
    };

    function fmt(n) { return parseFloat(n || 0).toLocaleString('id-ID'); }
    function escHtml(str) { return $('<div>').text(String(str || '')).html(); }

    function setNewOrderMode() {
        isHistoryMode = false;
        $('#mode-history').hide();
        $('#btn-simpan').show();
        $('.input-new-order').prop('disabled', false);
        $('#resep-tbody').empty();
        drugRowIndex = 0;
        calcResepTotal();
        $('#laboratory-tbody').empty();
        laboratoryRowIndex = 0;
        renderLaboratoryEmptyState();
        calcLaboratoryTotal();
        $('#radiology-tbody').empty();
        radiologyRowIndex = 0;
        renderRadiologyEmptyState();
        calcRadiologyTotal();

        $('#info-no-order').val(defaultInfo.no_order);
        $('#info-no-rm').val(defaultInfo.no_rm);
        $('#info-nama-pasien').val(defaultInfo.nama);
        $('#info-jaminan').val(defaultInfo.jaminan);
        $('#info-tgl-order').val(defaultInfo.tgl_order);
        $('#info-jam-order').val(defaultInfo.jam_order);
        $('#info-asal-pasien').val(defaultInfo.asal_pasien);
        $('#info-pesan').val(defaultInfo.pesan);
        $('#info-dokter').val(defaultInfo.doctor_id);
        $('#obat-lain').val('');
        $('#catatan-order').val('');
        $('#laboratory-note').val('');
        $('#radiology-note').val('');
    }

    $(document).on('click', '.history-order-row', function () {
        var detailUrl = $(this).attr('data-detail-url');

        $('.history-order-row').removeClass('history-active');
        $(this).addClass('history-active');

        isHistoryMode = true;
        $('#mode-history').show().text('MODE HISTORY ORDER - HANYA UNTUK MELIHAT');
        $('#btn-simpan').hide();
        $('.input-new-order').prop('disabled', true);

        $('#resep-tbody').html('<tr><td colspan="13" style="text-align:center;color:#888;">Memuat history order...</td></tr>');

        $.getJSON(detailUrl, function (res) {
            if (!res.success) {
                $('#resep-tbody').html('<tr><td colspan="13" style="text-align:center;color:#a00;">History order gagal dimuat.</td></tr>');
                return;
            }

            $('#info-no-order').val(res.order.no_order || '-');
            $('#info-no-rm').val(res.patient.no_rm || '-');
            $('#info-nama-pasien').val(res.patient.nama || '-');
            $('#info-jaminan').val(res.patient.jaminan || '-');
            $('#info-tgl-order').val(res.order.tgl_order || '-');
            $('#info-jam-order').val(res.order.jam_order || '-');
            $('#info-asal-pasien').val(res.patient.asal_pasien || '-');
            $('#info-pesan').val(res.order.pesan || '');
            $('#info-dokter').val(res.order.doctor_id || '');
            $('#info-lokasi-depo').val(res.order.lokasi_depo || '');

            $('#resep-tbody').empty();
            $('#laboratory-tbody').empty();
            laboratoryRowIndex = 0;
            $('#laboratory-note').val(res.order.laboratory_note || '');
            $('#radiology-tbody').empty();
            radiologyRowIndex = 0;
            $('#radiology-note').val(res.order.radiology_note || '');

            if (!res.items || !res.items.length) {
                $('#resep-tbody').html('<tr><td colspan="13" style="text-align:center;color:#999;">Tidak ada item resep.</td></tr>');
                calcResepTotal();
            } else {
                $.each(res.items, function (i, item) {
                    addHistoryRow(item, i);
                });
            }

            calcResepTotal();

            if (res.laboratories && res.laboratories.length) {
                $.each(res.laboratories, function (_, laboratory) {
                    addLaboratoryRow(laboratory, true);
                });
            } else {
                $('#laboratory-tbody').html(
                    '<tr><td colspan="6" style="text-align:center;color:#999;padding:18px;">'
                    + 'Tidak ada pemeriksaan laboratorium.</td></tr>'
                );
            }

            calcLaboratoryTotal();

            if (res.radiologies && res.radiologies.length) {
                $.each(res.radiologies, function (_, radiology) {
                    addRadiologyRow(radiology, true);
                });
            } else {
                $('#radiology-tbody').html(
                    '<tr><td colspan="6" style="text-align:center;color:#999;padding:18px;">'
                    + 'Tidak ada pemeriksaan radiologi.</td></tr>'
                );
            }

            calcRadiologyTotal();
        }).fail(function (xhr) {
            var message = 'Gagal memuat history order';
            if (xhr.status) {
                message += ' (HTTP ' + xhr.status + ')';
            }
            $('#resep-tbody').html(
                '<tr><td colspan="13" style="text-align:center;color:#a00;">' +
                escHtml(message) +
                '.</td></tr>'
            );
        });
    });

    $('#btn-add-drug-row-footer').on('click', function () {
        if (isHistoryMode) {
            setNewOrderMode();
            return;
        }

        if ($('#tab-lab').hasClass('active')) {
            openLaboratoryMaster();
        } else if ($('#tab-radio').hasClass('active')) {
            openRadiologyMaster();
        } else {
            addDrugRow(null);
        }
    });

    $('#btn-open-lab-master').on('click', function () {
        if (isHistoryMode) return;
        openLaboratoryMaster();
    });

    $('#btn-open-radiology-master').on('click', function () {
        if (isHistoryMode) return;
        openRadiologyMaster();
    });

    function addHistoryRow(item, i) {
        var html = '<tr class="history-readonly-row resep-row">'
            + '<td style="text-align:center; color:#aaa; font-size:10px;">' + (i + 1) + '</td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(item.kode || '') + '" readonly></td>'
            + '<td style="text-align:center;">' + (parseInt(item.is_kronis || 0) === 1 ? '<span class="label label-warning">K</span>' : '') + '</td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(item.nama || '') + '" readonly></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(item.jml_per_hari || 0) + '" readonly style="text-align:center;"></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(item.qty_min || 0) + '" readonly style="text-align:center;"></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(item.jml_hari || 0) + '" readonly style="text-align:center;"></td>'
            + '<td><input type="text" class="form-control qty-satuan-input" value="' + escHtml(item.qty_satuan || 0) + '" readonly style="text-align:center;"></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(item.satuan || '') + '" readonly></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(item.aturan_pakai || '') + '" readonly></td>'
            + '<td><input type="text" class="form-control harga-input" value="' + (parseFloat(item.harga || 0)) + '" readonly style="text-align:right;"></td>'
            + '<td><input type="text" class="form-control total-input" value="' + fmt(item.total_harga || 0) + '" readonly style="text-align:right;font-weight:600;"></td>'
            + '<td></td>'
            + '</tr>';

        $('#resep-tbody').append(html);
    }

    var drugTimer = null;
    var $drugDD = $('#drug-dropdown');
    var $activeDrugRow = null;

    $('#drug-search-input').on('input', function () {
        if (isHistoryMode) return;

        clearTimeout(drugTimer);
        var q = $.trim($(this).val());
        $activeDrugRow = null;

        if (q.length < 2) {
            $drugDD.hide().empty();
            return;
        }

        $drugDD.html('<div class="dd-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        positionDrugDD($('#drug-search-input'));
        $drugDD.show();

        drugTimer = setTimeout(function () {
            fetchDrugs(q, null);
        }, 250);
    });

    $(document).on('input', '.drug-name-input', function () {
        if (isHistoryMode) return;

        clearTimeout(drugTimer);
        var q = $.trim($(this).val());
        $activeDrugRow = $(this).closest('tr');

        if (q.length < 2) {
            $drugDD.hide().empty();
            return;
        }

        $drugDD.html('<div class="dd-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        positionDrugDD($(this));
        $drugDD.show();

        drugTimer = setTimeout(function () {
            fetchDrugs(q, $(this));
        }, 250);
    });

    function fetchDrugs(q, $inp) {
        $.getJSON(CARI_OBAT_URL, { q: q }, function (data) {
            renderDrugDD(data, $inp);
        }).fail(function () {
            $drugDD.html('<div class="dd-empty" style="color:#a00;">Gagal memuat data obat.</div>').show();
        });
    }

    function renderDrugDD(data, $inp) {
        $drugDD.empty();

        if (!data || !data.length) {
            $drugDD.html('<div class="dd-empty"><i class="fa fa-search"></i> Obat tidak ditemukan</div>').show();
            return;
        }

        $.each(data, function (_, d) {
            var hargaHtml = d.harga > 0 ? '<span class="d-harga">Rp ' + fmt(d.harga) + '</span>' : '<span style="color:#aaa;">-</span>';

            $('<div class="dd-item"></div>')
                .html('<div class="d-name">' + escHtml(d.nama)
                    + (d.kode ? ' <span style="font-size:10px;background:#e9ecef;padding:0 4px;border-radius:2px;font-family:monospace;">' + escHtml(d.kode) + '</span>' : '') + '</div>'
                    + '<div class="d-meta">' + (d.generic ? 'Generic: ' + escHtml(d.generic) + ' · ' : '') + hargaHtml + '</div>')
                .data('drug', d)
                .on('mousedown', function (e) {
                    e.preventDefault();

                    if ($activeDrugRow) {
                        fillDrugRow($activeDrugRow, d);
                    } else {
                        addDrugRow(d);
                    }

                    $drugDD.hide().empty();
                    $('#drug-search-input').val('');
                    $activeDrugRow = null;
                })
                .appendTo($drugDD);
        });

        $drugDD.show();
    }

    function positionDrugDD($input) {
        if (!$input || !$input.length) return;

        var rect = $input[0].getBoundingClientRect();
        var width = $input.outerWidth();

        if (width < 420) width = 500;

        var left = rect.left;
        var top = rect.bottom + 2;

        if (left + width > $(window).width() - 20) {
            left = $(window).width() - width - 20;
        }

        if (left < 10) left = 10;

        $drugDD.css({ top: top, left: left, width: width });
    }

    $(window).on('scroll resize', function () {
        if ($drugDD.is(':visible')) {
            var $input = $activeDrugRow ? $activeDrugRow.find('.drug-name-input') : $('#drug-search-input');
            positionDrugDD($input);
        }
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#drug-search-input, #drug-dropdown, .drug-name-input').length) {
            $drugDD.hide();
        }
    });

    function addDrugRow(drug) {
        var i = drugRowIndex++;
        var d = drug || {};
        var harga = parseFloat(d.harga) || 0;

        var html = '<tr class="resep-row" data-i="' + i + '">'
            + '<td style="text-align:center; color:#aaa; font-size:10px;">' + drugRowIndex + '</td>'
            + '<td><input type="hidden" name="prescriptions[' + i + '][medicine_id]" class="medicine-id-input" value="' + (d.id || '') + '">'
            + '<input type="text" name="prescriptions[' + i + '][kode]" class="form-control drug-kode-input" value="' + escHtml(d.kode || '') + '" readonly style="background:#f5f5f5; font-family:monospace; font-size:10px;"></td>'
            + '<td style="text-align:center;"><input type="checkbox" name="prescriptions[' + i + '][is_kronis]" value="1" class="kronis-chk"></td>'
            + '<td style="position:relative;"><input type="text" name="prescriptions[' + i + '][nama_obat]" class="form-control drug-name-input" value="' + escHtml(d.nama || '') + '" placeholder="Nama obat..." autocomplete="off"></td>'
            + '<td><input type="number" name="prescriptions[' + i + '][jml_per_hari]" class="form-control jml-hari-input" value="0" min="0" step="0.5" style="text-align:center;"></td>'
            + '<td><input type="number" name="prescriptions[' + i + '][qty_min]" class="form-control" value="0" min="0" step="0.5" style="text-align:center;"></td>'
            + '<td><input type="number" name="prescriptions[' + i + '][jml_hari]" class="form-control jml-hari-dur-input" value="0" min="0" style="text-align:center;"></td>'
            + '<td><input type="number" name="prescriptions[' + i + '][qty_satuan]" class="form-control qty-satuan-input" value="0" step="0.5" style="text-align:center; background:#fefce8;"></td>'
            + '<td><input type="text" name="prescriptions[' + i + '][medicine_unit]" class="form-control" value="' + escHtml(d.unit || 'TUBE') + '" style="font-size:10px;" placeholder="Satuan"></td>'
            + '<td><input type="text" name="prescriptions[' + i + '][aturan_pakai]" class="form-control" placeholder="3x1 sesudah makan..." style="font-size:10px;"></td>'
            + '<td><input type="text" name="prescriptions[' + i + '][harga]" class="form-control harga-input" value="' + harga + '" readonly style="text-align:right; background:#f5f5f5;"><span class="harga-display" style="display:block; font-size:10px; text-align:right; color:#888;">' + fmt(harga) + '</span></td>'
            + '<td><input type="text" name="prescriptions[' + i + '][total_harga]" class="form-control total-input" value="0" readonly style="text-align:right; background:#f5f5f5; font-weight:600;"></td>'
            + '<td style="text-align:center;"><button type="button" class="btn btn-xs btn-danger btn-remove-drug">&times;</button></td>'
            + '</tr>';

        $('#resep-tbody').append(html);
        calcResepTotal();

        if (!drug) {
            $('#resep-tbody tr:last').find('.drug-name-input').focus();
        }
    }

    function fillDrugRow($row, drug) {
        $row.find('.medicine-id-input').val(drug.id || '');
        $row.find('.drug-kode-input').val(drug.kode || '');
        $row.find('.drug-name-input').val(drug.nama || '');
        $row.find('[name$="[medicine_unit]"]').val(drug.unit || '');

        var harga = parseFloat(drug.harga) || 0;

        $row.find('.harga-input').val(harga);
        $row.find('.harga-display').text(fmt(harga));

        calcRowTotal($row);
        calcResepTotal();
    }

    $(document).on('click', '.btn-remove-drug', function () {
        if (isHistoryMode) return;

        $(this).closest('tr').remove();
        calcResepTotal();

        $('#resep-tbody tr').each(function (idx) {
            $(this).find('td:first').text(idx + 1);
        });
    });

    $(document).on('input', '.jml-hari-input, .jml-hari-dur-input', function () {
        if (isHistoryMode) return;

        var $row = $(this).closest('tr');
        var perHari = parseFloat($row.find('.jml-hari-input').val()) || 0;
        var durasi = parseFloat($row.find('.jml-hari-dur-input').val()) || 0;

        $row.find('.qty-satuan-input').val(perHari * durasi || 0);

        calcRowTotal($row);
        calcResepTotal();
    });

    $(document).on('input', '.qty-satuan-input', function () {
        if (isHistoryMode) return;

        var $row = $(this).closest('tr');
        calcRowTotal($row);
        calcResepTotal();
    });

    function calcRowTotal($row) {
        var qty = parseFloat($row.find('.qty-satuan-input').val()) || 0;
        var harga = parseFloat($row.find('.harga-input').val()) || 0;
        var total = qty * harga;

        $row.find('.total-input').val(fmt(total));
        $row.data('total', total);
    }

    function calcResepTotal() {
        var grand = 0;

        $('#resep-tbody tr').each(function () {
            var totalText = $(this).find('.total-input').val();
            var total = parseFloat(String(totalText || '0').replace(/\./g, '').replace(',', '.')) || 0;

            if (total <= 0) {
                var qty = parseFloat($(this).find('.qty-satuan-input').val()) || 0;
                var harga = parseFloat($(this).find('.harga-input').val()) || 0;
                total = qty * harga;
            }

            grand += total;
        });

        $('#resep-grand-total').text('Rp ' + fmt(grand));
    }

    function addLaboratoryRow(laboratory, readonly) {
        var i = laboratoryRowIndex++;
        var item = laboratory || {};
        var masterId = item.id || item.master_tindakan_id || '';
        var code = item.code || item.kode || '';
        var name = item.examination_name || item.nama || '';
        var price = item.price || item.harga || 0;
        var approvalNote = item.approval_note || item.keterangan || '';
        var disabled = ' readonly';
        var removeButton = readonly
            ? ''
            : '<button type="button" class="btn btn-xs btn-danger btn-remove-laboratory">&times;</button>';

        $('#laboratory-tbody .laboratory-empty').remove();

        var html = '<tr class="laboratory-row">'
            + '<td class="laboratory-number" style="text-align:center;color:#777;">' + (i + 1) + '</td>'
            + '<td><input type="hidden" name="laboratories[' + i + '][master_tindakan_id]"'
            + ' class="laboratory-master-id" value="' + escHtml(masterId) + '">'
            + '<input type="text" name="laboratories[' + i + '][code]" class="form-control input-new-order"'
            + ' value="' + escHtml(code) + '" placeholder="Kode"' + disabled + '></td>'
            + '<td><input type="text" name="laboratories[' + i + '][examination_name]"'
            + ' class="form-control input-new-order" value="' + escHtml(name) + '"'
            + ' placeholder="Nama pemeriksaan laboratorium"' + disabled + '></td>'
            + '<td><input type="text" name="laboratories[' + i + '][price]"'
            + ' class="form-control laboratory-price input-new-order" value="' + escHtml(price) + '"'
            + ' style="text-align:right;"' + disabled + '></td>'
            + '<td><input type="text" name="laboratories[' + i + '][approval_note]"'
            + ' class="form-control input-new-order" value="' + escHtml(approvalNote) + '"'
            + ' placeholder="Keterangan / approval"' + disabled + '></td>'
            + '<td style="text-align:center;">' + removeButton + '</td>'
            + '</tr>';

        $('#laboratory-tbody').append(html);
        renumberLaboratoryRows();
        calcLaboratoryTotal();
    }

    $(document).on('click', '.btn-remove-laboratory', function () {
        if (isHistoryMode) return;
        $(this).closest('tr').remove();
        renumberLaboratoryRows();
        renderLaboratoryEmptyState();
        calcLaboratoryTotal();
    });

    $(document).on('input', '.laboratory-price', calcLaboratoryTotal);

    function renumberLaboratoryRows() {
        $('#laboratory-tbody .laboratory-row').each(function (index) {
            $(this).find('.laboratory-number').text(index + 1);
        });
    }

    function calcLaboratoryTotal() {
        var total = 0;

        $('#laboratory-tbody .laboratory-price').each(function () {
            var value = String($(this).val() || '0').replace(/\./g, '').replace(',', '.');
            total += parseFloat(value) || 0;
        });

        $('#laboratory-total').text('Rp ' + fmt(total));
    }

    function renderLaboratoryEmptyState() {
        if ($('#laboratory-tbody .laboratory-row').length) return;

        $('#laboratory-tbody').html(
            '<tr class="laboratory-empty"><td colspan="6"'
            + ' style="text-align:center;color:#999;padding:35px;">'
            + 'Belum ada tindakan laboratorium yang dipilih.</td></tr>'
        );
    }

    function openLaboratoryMaster() {
        $('#laboratory-master-search').val('');
        loadLaboratoryMaster('');
        $('#laboratory-master-modal').modal('show');
    }

    function loadLaboratoryMaster(query) {
        $('#laboratory-master-tbody').html(
            '<tr><td colspan="4" style="text-align:center;padding:20px;">'
            + '<i class="fa fa-spinner fa-spin"></i> Memuat master...</td></tr>'
        );

        $.getJSON(CARI_LAB_URL, { q: query || '' }, function (rows) {
            renderLaboratoryMaster(rows || []);
        }).fail(function () {
            $('#laboratory-master-tbody').html(
                '<tr><td colspan="4" style="text-align:center;color:#a00;padding:20px;">'
                + 'Master laboratorium gagal dimuat.</td></tr>'
            );
        });
    }

    function renderLaboratoryMaster(rows) {
        var $body = $('#laboratory-master-tbody').empty();

        if (!rows.length) {
            $body.html(
                '<tr><td colspan="4" style="text-align:center;color:#999;padding:25px;">'
                + 'Belum ada master tindakan laboratorium.</td></tr>'
            );
            return;
        }

        $.each(rows, function (_, item) {
            var alreadySelected = $('#laboratory-tbody .laboratory-master-id').filter(function () {
                return String($(this).val()) === String(item.id);
            }).length > 0;

            var $row = $('<tr></tr>').data('laboratory', item);
            $('<td style="text-align:center;"></td>')
                .append($('<input type="checkbox" class="laboratory-master-check">').prop('disabled', alreadySelected))
                .appendTo($row);
            $('<td style="font-family:monospace;"></td>').text(item.kode || '').appendTo($row);
            $('<td></td>').text(item.nama || '').appendTo($row);
            $('<td style="text-align:right;"></td>').text('Rp ' + fmt(item.harga || 0)).appendTo($row);

            if (alreadySelected) {
                $row.css('opacity', '.55').attr('title', 'Sudah ditambahkan ke order');
            }

            $row.on('click', function (event) {
                if ($(event.target).is('input') || alreadySelected) return;
                var $checkbox = $(this).find('.laboratory-master-check');
                $checkbox.prop('checked', !$checkbox.prop('checked'));
            });

            $body.append($row);
        });
    }

    $('#btn-search-laboratory-master').on('click', function () {
        loadLaboratoryMaster($.trim($('#laboratory-master-search').val()));
    });

    $('#laboratory-master-search').on('keypress', function (event) {
        if (event.which !== 13) return;
        event.preventDefault();
        loadLaboratoryMaster($.trim($(this).val()));
    });

    $('#btn-select-laboratory-master').on('click', function () {
        $('#laboratory-master-tbody .laboratory-master-check:checked').each(function () {
            addLaboratoryRow($(this).closest('tr').data('laboratory'), false);
        });

        $('#laboratory-master-modal').modal('hide');
    });

    function addRadiologyRow(radiology, readonly) {
        var i = radiologyRowIndex++;
        var item = radiology || {};
        var masterId = item.id || item.master_tindakan_id || '';
        var code = item.code || item.kode || '';
        var name = item.examination_name || item.nama || '';
        var price = item.price || item.harga || 0;
        var approvalNote = item.approval_note || item.keterangan || '';
        var disabled = ' readonly';
        var removeButton = readonly
            ? ''
            : '<button type="button" class="btn btn-xs btn-danger btn-remove-radiology">&times;</button>';

        $('#radiology-tbody .radiology-empty').remove();

        var html = '<tr class="radiology-row">'
            + '<td class="radiology-number" style="text-align:center;color:#777;">' + (i + 1) + '</td>'
            + '<td><input type="hidden" name="radiologies[' + i + '][master_tindakan_id]"'
            + ' class="radiology-master-id" value="' + escHtml(masterId) + '">'
            + '<input type="text" name="radiologies[' + i + '][code]" class="form-control input-new-order"'
            + ' value="' + escHtml(code) + '" placeholder="Kode"' + disabled + '></td>'
            + '<td><input type="text" name="radiologies[' + i + '][examination_name]"'
            + ' class="form-control input-new-order" value="' + escHtml(name) + '"'
            + ' placeholder="Nama pemeriksaan radiologi"' + disabled + '></td>'
            + '<td><input type="text" name="radiologies[' + i + '][price]"'
            + ' class="form-control radiology-price input-new-order" value="' + escHtml(price) + '"'
            + ' style="text-align:right;"' + disabled + '></td>'
            + '<td><input type="text" name="radiologies[' + i + '][approval_note]"'
            + ' class="form-control input-new-order" value="' + escHtml(approvalNote) + '"'
            + ' placeholder="Keterangan / approval"' + disabled + '></td>'
            + '<td style="text-align:center;">' + removeButton + '</td>'
            + '</tr>';

        $('#radiology-tbody').append(html);
        renumberRadiologyRows();
        calcRadiologyTotal();
    }

    $(document).on('click', '.btn-remove-radiology', function () {
        if (isHistoryMode) return;
        $(this).closest('tr').remove();
        renumberRadiologyRows();
        renderRadiologyEmptyState();
        calcRadiologyTotal();
    });

    $(document).on('input', '.radiology-price', calcRadiologyTotal);

    function renumberRadiologyRows() {
        $('#radiology-tbody .radiology-row').each(function (index) {
            $(this).find('.radiology-number').text(index + 1);
        });
    }

    function calcRadiologyTotal() {
        var total = 0;

        $('#radiology-tbody .radiology-price').each(function () {
            var value = String($(this).val() || '0').replace(/\./g, '').replace(',', '.');
            total += parseFloat(value) || 0;
        });

        $('#radiology-total').text('Rp ' + fmt(total));
    }

    function renderRadiologyEmptyState() {
        if ($('#radiology-tbody .radiology-row').length) return;

        $('#radiology-tbody').html(
            '<tr class="radiology-empty"><td colspan="6"'
            + ' style="text-align:center;color:#999;padding:35px;">'
            + 'Belum ada tindakan radiologi yang dipilih.</td></tr>'
        );
    }

    function openRadiologyMaster() {
        $('#radiology-master-search').val('');
        loadRadiologyMaster('');
        $('#radiology-master-modal').modal('show');
    }

    function loadRadiologyMaster(query) {
        $('#radiology-master-tbody').html(
            '<tr><td colspan="4" style="text-align:center;padding:20px;">'
            + '<i class="fa fa-spinner fa-spin"></i> Memuat master...</td></tr>'
        );

        $.getJSON(CARI_RADIOLOGY_URL, { q: query || '' }, function (rows) {
            renderRadiologyMaster(rows || []);
        }).fail(function () {
            $('#radiology-master-tbody').html(
                '<tr><td colspan="4" style="text-align:center;color:#a00;padding:20px;">'
                + 'Master radiologi gagal dimuat.</td></tr>'
            );
        });
    }

    function renderRadiologyMaster(rows) {
        var $body = $('#radiology-master-tbody').empty();

        if (!rows.length) {
            $body.html(
                '<tr><td colspan="4" style="text-align:center;color:#999;padding:25px;">'
                + 'Belum ada master tindakan radiologi.</td></tr>'
            );
            return;
        }

        $.each(rows, function (_, item) {
            var alreadySelected = $('#radiology-tbody .radiology-master-id').filter(function () {
                return String($(this).val()) === String(item.id);
            }).length > 0;

            var $row = $('<tr></tr>').data('radiology', item);
            $('<td style="text-align:center;"></td>')
                .append($('<input type="checkbox" class="radiology-master-check">').prop('disabled', alreadySelected))
                .appendTo($row);
            $('<td style="font-family:monospace;"></td>').text(item.kode || '').appendTo($row);
            $('<td></td>').text(item.nama || '').appendTo($row);
            $('<td style="text-align:right;"></td>').text('Rp ' + fmt(item.harga || 0)).appendTo($row);

            if (alreadySelected) {
                $row.css('opacity', '.55').attr('title', 'Sudah ditambahkan ke order');
            }

            $row.on('click', function (event) {
                if ($(event.target).is('input') || alreadySelected) return;
                var $checkbox = $(this).find('.radiology-master-check');
                $checkbox.prop('checked', !$checkbox.prop('checked'));
            });

            $body.append($row);
        });
    }

    $('#btn-search-radiology-master').on('click', function () {
        loadRadiologyMaster($.trim($('#radiology-master-search').val()));
    });

    $('#radiology-master-search').on('keypress', function (event) {
        if (event.which !== 13) return;
        event.preventDefault();
        loadRadiologyMaster($.trim($(this).val()));
    });

    $('#btn-select-radiology-master').on('click', function () {
        $('#radiology-master-tbody .radiology-master-check:checked').each(function () {
            addRadiologyRow($(this).closest('tr').data('radiology'), false);
        });

        $('#radiology-master-modal').modal('hide');
    });

    renderLaboratoryEmptyState();
    calcLaboratoryTotal();
    renderRadiologyEmptyState();
    calcRadiologyTotal();
});
</script>
