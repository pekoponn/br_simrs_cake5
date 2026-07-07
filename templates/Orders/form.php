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

/*
 * Dropdown Operator Bedah custom seperti SIMRS:
 * tampil 2 kolom terpisah: Nama Dokter dan Kode Dokter.
 * Tetap aman: kalau kolom kode dokter tidak ada, kode dikosongkan.
 */
$operatorDoctorRows = [];
$operatorDoctorList = $doctorList ?? [];

try {
    $DoctorsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Doctors');
    $doctorSchema = $DoctorsTable->getSchema();

    $doctorNameField = $doctorSchema->hasColumn('doctor_name') ? 'doctor_name' : 'name';

    $doctorCodeField = null;
    foreach (['doctor_code', 'code', 'kode_dokter', 'dokter_code', 'kode'] as $field) {
        if ($doctorSchema->hasColumn($field)) {
            $doctorCodeField = $field;
            break;
        }
    }

    $selectFields = ['id', $doctorNameField];

    if (!empty($doctorCodeField)) {
        $selectFields[] = $doctorCodeField;
    }

    $doctorRows = $DoctorsTable->find()
        ->select($selectFields)
        ->order(['Doctors.' . $doctorNameField => 'ASC'])
        ->all();

    foreach ($doctorRows as $dr) {
        $doctorName = trim((string)($dr->{$doctorNameField} ?? ''));
        $doctorCode = !empty($doctorCodeField)
            ? trim((string)($dr->{$doctorCodeField} ?? ''))
            : '';

        $operatorDoctorRows[] = [
            'id' => (int)$dr->id,
            'name' => $doctorName,
            'code' => $doctorCode,
        ];

        $operatorDoctorList[(int)$dr->id] = trim($doctorName . ($doctorCode !== '' ? ' - ' . $doctorCode : ''));
    }
} catch (\Throwable $e) {
    $operatorDoctorRows = [];

    foreach (($doctorList ?? []) as $id => $name) {
        $operatorDoctorRows[] = [
            'id' => (int)$id,
            'name' => (string)$name,
            'code' => '',
        ];
    }
}

$nutritionDietOptions = [];

try {
    if (isset($this->Krs) && method_exists($this->Krs, 'nutritionDietOptions')) {
        $nutritionDietOptions = $this->Krs->nutritionDietOptions();
    }
} catch (\Throwable $e) {
    $nutritionDietOptions = [];
}

if (empty($nutritionDietOptions)) {
    $nutritionDietOptions = [
        'Diet Energi Tinggi Protein Tinggi' => 'Diet Energi Tinggi Protein Tinggi',
        'Diet Rendah Garam' => 'Diet Rendah Garam',
        'Diet Diabetes Mellitus' => 'Diet Diabetes Mellitus',
        'Diet Lambung' => 'Diet Lambung',
        'Diet Tinggi Serat' => 'Diet Tinggi Serat',
        'Diet Rendah Serat' => 'Diet Rendah Serat',
        'Diet Sindrom Nefrotik' => 'Diet Sindrom Nefrotik',
        'Diet Rendah Lemak' => 'Diet Rendah Lemak',
        'Diet Purin Rendah' => 'Diet Purin Rendah',
        'Diet Protein Rendah' => 'Diet Protein Rendah',
        'Diet Rendah Kalori' => 'Diet Rendah Kalori',
        'Diet Hiperemesis' => 'Diet Hiperemesis',
        'Diet Pre eklamsi' => 'Diet Pre eklamsi',
        'Diet Dislipidemia' => 'Diet Dislipidemia',
    ];
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
    'Kembali',
    !empty($outpatientVisit->id)
        ? ['controller' => 'OutpatientVisits', 'action' => 'emr', $outpatientVisit->id]
        : ['controller' => 'OutpatientVisits', 'action' => 'index'],
    ['class' => 'btn btn-default btn-sm']
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

<div class="panel-body" style="padding:8px 10px; min-height:300px; margin:10px; overflow:hidden;">
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
               placeholder="Ketik minimal 4 karakter nama obat atau generic..."
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

    <div class="lab-topbar">
        <button type="button" class="btn btn-xs btn-default input-new-order" id="btn-add-lab-row">
            <i class="fa fa-plus"></i> Tindakan Laboratorium
        </button>
        <span style="font-size:11px; color:#777;">
            Ketik nama pemeriksaan, lalu pilih dari master laboratorium.
        </span>
    </div>

    <div class="lab-searchbar">
        <input type="text" id="lab-search-input"
               class="form-control input-sm input-new-order"
               placeholder="Ketik kode / nama pemeriksaan laboratorium..."
               autocomplete="off">
        <button type="button" class="btn btn-xs btn-info input-new-order" id="btn-search-lab">
            <i class="fa fa-search"></i> Cari
        </button>
    </div>

    <div id="lab-dropdown"></div>

    <div style="overflow-x:auto;">
        <table class="table table-bordered table-sm" id="lab-table"
               style="font-size:11px; min-width:850px;">
            <thead>
                <tr style="background:#dbeafe;">
                    <th style="width:28px;">No</th>
                    <th style="width:120px;">Kode</th>
                    <th>Nama Pemeriksaan</th>
                    <th style="width:130px; text-align:right;">Tarif Rp</th>
                    <th style="width:260px;">Keterangan (Approval)</th>
                    <th style="width:32px;"></th>
                </tr>
            </thead>
            <tbody id="lab-tbody">
            </tbody>
            <tfoot>
                <tr style="background:#f8f9fa;">
                    <td colspan="3" style="text-align:right; font-weight:700; padding-right:8px;">
                        Total Laboratorium
                    </td>
                    <td style="text-align:right; font-weight:700;" id="lab-grand-total">
                        Rp 0
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row" style="margin-top:8px;">
        <div class="col-md-10">
            <label>Catatan</label>
            <textarea name="lab_catatan" id="lab-catatan"
                      class="form-control input-sm input-new-order"
                      rows="3"
                      placeholder="Catatan order laboratorium..."></textarea>
        </div>
        <div class="col-md-2" style="padding-top:24px;">
            <button type="button" class="btn btn-default btn-sm btn-block input-new-order" id="btn-clear-lab">
                Bersihkan
            </button>
        </div>
    </div>
</div>
<div id="tab-radio" class="tab-pane">

    <div class="radio-topbar">
        <button type="button" class="btn btn-xs btn-default input-new-order" id="btn-add-radio-row">
            <i class="fa fa-plus"></i> Tindakan Radiologi
        </button>
        <span style="font-size:11px; color:#777;">
            Ketik nama pemeriksaan radiologi, lalu pilih dari master radiologi.
        </span>
    </div>

    <div class="radio-searchbar">
        <input type="text" id="radio-search-input"
               class="form-control input-sm input-new-order"
               placeholder="Ketik kode / nama pemeriksaan radiologi..."
               autocomplete="off">
        <button type="button" class="btn btn-xs btn-info input-new-order" id="btn-search-radio">
            <i class="fa fa-search"></i> Cari
        </button>
    </div>

    <div id="radio-dropdown"></div>

    <div style="overflow-x:auto;">
        <table class="table table-bordered table-sm" id="radio-table"
               style="font-size:11px; min-width:980px;">
            <thead>
                <tr style="background:#dbeafe;">
                    <th style="width:28px;">No</th>
                    <th style="width:120px;">Kode</th>
                    <th>Nama Pemeriksaan</th>
                    <th style="width:130px; text-align:right;">Tarif Rp</th>
                    <th style="width:70px; text-align:center;">Qty</th>
                    <th style="width:130px; text-align:right;">Total</th>
                    <th style="width:260px;">Keterangan (Approval)</th>
                    <th style="width:32px;"></th>
                </tr>
            </thead>
            <tbody id="radio-tbody">
            </tbody>
            <tfoot>
                <tr style="background:#f8f9fa;">
                    <td colspan="5" style="text-align:right; font-weight:700; padding-right:8px;">
                        Total Radiologi
                    </td>
                    <td style="text-align:right; font-weight:700;" id="radio-grand-total">
                        Rp 0
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row" style="margin-top:8px;">
        <div class="col-md-10">
            <label>Catatan</label>
            <textarea name="radiology_catatan" id="radio-catatan"
                      class="form-control input-sm input-new-order"
                      rows="3"
                      placeholder="Catatan order radiologi..."></textarea>
        </div>
        <div class="col-md-2" style="padding-top:24px;">
            <button type="button" class="btn btn-default btn-sm btn-block input-new-order" id="btn-clear-radio">
                Bersihkan
            </button>
        </div>
    </div>
</div>
<div id="tab-penunjang" class="tab-pane">

    <div class="support-topbar">
        <button type="button" class="btn btn-xs btn-default input-new-order" id="btn-add-support-row">
            <i class="fa fa-plus"></i> Penunjang Medis
        </button>
        <span style="font-size:11px; color:#777;">
            Ketik nama pemeriksaan penunjang, lalu pilih dari master penunjang.
        </span>
    </div>

    <div class="support-searchbar">
        <input type="text" id="support-search-input"
               class="form-control input-sm input-new-order"
               placeholder="Ketik kode / nama pemeriksaan penunjang..."
               autocomplete="off">
        <button type="button" class="btn btn-xs btn-info input-new-order" id="btn-search-support">
            <i class="fa fa-search"></i> Cari
        </button>
    </div>

    <div id="support-dropdown"></div>

    <div style="overflow-x:auto;">
        <table class="table table-bordered table-sm" id="support-table"
               style="font-size:11px; min-width:980px;">
            <thead>
                <tr style="background:#dbeafe;">
                    <th style="width:28px;">No</th>
                    <th style="width:120px;">Kode</th>
                    <th>Nama Pemeriksaan</th>
                    <th style="width:130px; text-align:right;">Tarif Rp</th>
                    <th style="width:80px;">Unit</th>
                    <th style="width:70px; text-align:center;">Qty</th>
                    <th style="width:130px; text-align:right;">Total</th>
                    <th style="width:260px;">Keterangan (Approval)</th>
                    <th style="width:32px;"></th>
                </tr>
            </thead>
            <tbody id="support-tbody">
            </tbody>
            <tfoot>
                <tr style="background:#f8f9fa;">
                    <td colspan="6" style="text-align:right; font-weight:700; padding-right:8px;">
                        Total Penunjang
                    </td>
                    <td style="text-align:right; font-weight:700;" id="support-grand-total">
                        Rp 0
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row" style="margin-top:8px;">
        <div class="col-md-10">
            <label>Catatan</label>
            <textarea name="support_catatan" id="support-catatan"
                      class="form-control input-sm input-new-order"
                      rows="3"
                      placeholder="Catatan order penunjang..."></textarea>
        </div>
        <div class="col-md-2" style="padding-top:24px;">
            <button type="button" class="btn btn-default btn-sm btn-block input-new-order" id="btn-clear-support">
                Bersihkan
            </button>
        </div>
    </div>
</div>
<div id="tab-bedah" class="tab-pane">

    <div class="bedah-box bedah-compact">
        <div class="bedah-grid">
            <!-- KIRI: ORDER JADWAL BEDAH -->
            <div class="bedah-card">
                <div class="bedah-section-title">Order Jadwal Bedah</div>

                <div class="bedah-line">
                    <label>Tgl Bedah</label>
                    <input type="date"
                           name="surgery[surgery_date]"
                           id="surgery-date"
                           class="form-control input-sm input-new-order bedah-date"
                           value="<?= date('Y-m-d') ?>"
                           readonly
                           title="Otomatis mengikuti tanggal order dibuat">
                </div>

                <div class="bedah-line">
                    <label>Jam</label>
                    <input type="time"
                           name="surgery[surgery_time]"
                           id="surgery-time"
                           class="form-control input-sm input-new-order bedah-time"
                           value="<?= date('H:i') ?>"
                           readonly
                           title="Otomatis mengikuti jam order dibuat">
                </div>

                <div class="bedah-line">
                    <label>Operator</label>
                    <div>
                        <?= $this->Form->hidden('surgery.operator_name', [
                            'id' => 'surgery-operator-name',
                            'value' => ''
                        ]) ?>

                        <input type="hidden"
                               name="surgery[operator_id]"
                               id="surgery-operator"
                               class="input-new-order"
                               value="">

                        <div class="operator-combo" id="operator-combo">
                            <button type="button"
                                    class="operator-combo-toggle input-new-order"
                                    id="operator-combo-toggle">
                                <span id="operator-combo-text">-- Pilih Operator / Dokter --</span>
                                <span class="operator-combo-arrow">▾</span>
                            </button>

                            <div class="operator-combo-dropdown" id="operator-combo-dropdown">
                                <div class="operator-combo-search-wrap">
                                    <input type="text"
                                           id="operator-combo-search"
                                           class="form-control input-sm"
                                           placeholder="Cari nama dokter / kode dokter..."
                                           autocomplete="off">
                                </div>

                                <div class="operator-combo-table-wrap">
                                    <table class="operator-combo-table">
                                        <thead>
                                            <tr>
                                                <th>Nama Dokter</th>
                                                <th style="width:115px;">Kode Dokter</th>
                                            </tr>
                                        </thead>
                                        <tbody id="operator-combo-tbody">
                                            <?php if (!empty($operatorDoctorRows)): ?>
                                                <?php foreach ($operatorDoctorRows as $op): ?>
                                                    <tr class="operator-option-row"
                                                        data-id="<?= h($op['id']) ?>"
                                                        data-name="<?= h($op['name']) ?>"
                                                        data-code="<?= h($op['code']) ?>"
                                                        data-search="<?= h(strtolower(($op['name'] ?? '') . ' ' . ($op['code'] ?? ''))) ?>">
                                                        <td><?= h($op['name'] ?: '-') ?></td>
                                                        <td class="operator-code-cell"><?= h($op['code'] ?: '-') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="2" class="operator-empty">Data dokter tidak ditemukan.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bedah-line">
                    <label>Jenis Operasi</label>
                    <div class="bedah-input-search">
                        <input type="hidden" name="surgery[operation_type_id]" id="surgery-operation-type-id">
                        <input type="hidden" name="surgery[surgery_code]" id="surgery-code">
                        <input type="hidden" name="surgery[surgery_name]" id="surgery-name">
                        <input type="hidden" name="surgery[tariff]" id="surgery-tariff">
                        <input type="hidden" name="surgery[jasa_rs]" id="surgery-jasa-rs">
                        <input type="hidden" name="surgery[jasa_dr]" id="surgery-jasa-dr">
                        <input type="hidden" name="surgery[jasa_paramedis]" id="surgery-jasa-paramedis">
                        <input type="hidden" name="surgery[unit]" id="surgery-unit">

                        <input type="text"
                               name="surgery[operation_type]"
                               id="surgery-operation-type"
                               class="form-control input-sm input-new-order"
                               placeholder="Klik cari untuk memilih jenis operasi..."
                               readonly>
                        <button type="button"
                                class="btn btn-xs btn-default input-new-order"
                                id="btn-open-operation-modal"
                                title="Cari Jenis Operasi">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="bedah-line bedah-line-textarea">
                    <label>Keterangan</label>
                    <textarea name="surgery[notes]"
                              id="surgery-notes"
                              class="form-control input-sm input-new-order"
                              rows="3"
                              placeholder="Keterangan order jadwal bedah..."></textarea>
                </div>
            </div>

            <!-- KANAN: JADWAL DISETUJUI -->
            <div class="bedah-card bedah-card-approved">
                <div class="bedah-section-title">Jadwal Bedah Disetujui</div>

                <div class="bedah-line">
                    <label>No. Urut</label>
                    <input type="text"
                           name="surgery[approval_queue_no]"
                           id="surgery-approval-queue-no"
                           class="form-control input-sm input-new-order bedah-small"
                           placeholder="No urut">
                </div>

                <div class="bedah-line">
                    <label>Tgl Disetujui</label>
                    <input type="date"
                           name="surgery[approval_date]"
                           id="surgery-approval-date"
                           class="form-control input-sm input-new-order bedah-date">
                </div>

                <div class="bedah-line">
                    <label>Jam</label>
                    <input type="time"
                           name="surgery[approval_time]"
                           id="surgery-approval-time"
                           class="form-control input-sm input-new-order bedah-time">
                </div>

                <div class="bedah-line">
                    <label>Ruang Operasi</label>
                    <input type="text"
                           name="surgery[operating_room]"
                           id="surgery-operating-room"
                           class="form-control input-sm input-new-order"
                           placeholder="Ruang operasi...">
                </div>

                <div class="bedah-line">
                    <label>Operator</label>
                    <input type="text"
                           name="surgery[approved_operator]"
                           id="surgery-approved-operator"
                           class="form-control input-sm input-new-order"
                           placeholder="Operator disetujui...">
                </div>

                <div class="bedah-line">
                    <label>Jenis Operasi</label>
                    <input type="text"
                           name="surgery[approved_operation_type]"
                           id="surgery-approved-operation-type"
                           class="form-control input-sm input-new-order"
                           placeholder="Jenis operasi disetujui...">
                </div>

                <div class="bedah-line">
                    <label>Jenis Pembiusan</label>
                    <input type="text"
                           name="surgery[anesthesia_type]"
                           id="surgery-anesthesia-type"
                           class="form-control input-sm input-new-order"
                           placeholder="Jenis pembiusan...">
                </div>

                <div class="bedah-line">
                    <label>Dibuat Oleh</label>
                    <input type="text"
                           name="surgery[approved_by]"
                           id="surgery-approved-by"
                           class="form-control input-sm input-new-order"
                           value="<?= h($createdByName ?? 'Admin') ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tab-mcu" class="tab-pane">

    <div class="mcu-simple-box">
        <div class="mcu-simple-row">
            <label>Tgl MCU</label>
            <div>
                <input type="hidden"
                       name="mcu[mcu_date]"
                       id="mcu-date"
                       value="<?= date('Y-m-d') ?>">
                <input type="text"
                       id="mcu-date-display"
                       class="form-control input-sm input-new-order mcu-simple-date"
                       value="<?= date('d-m-Y') ?>"
                       readonly
                       title="Otomatis mengikuti tanggal order dibuat">
            </div>
        </div>

        <div class="mcu-simple-row">
            <label>Jam</label>
            <div>
                <input type="hidden"
                       name="mcu[mcu_time]"
                       id="mcu-time"
                       value="<?= date('H:i:s') ?>">
                <input type="text"
                       id="mcu-time-display"
                       class="form-control input-sm input-new-order mcu-simple-time"
                       value="<?= date('H:i:s') ?>"
                       readonly
                       title="Otomatis mengikuti jam order dibuat">
            </div>
        </div>

        <div class="mcu-simple-row">
            <label>Jenis</label>
            <div class="mcu-type-picker">
                <input type="hidden"
                       name="mcu[mcu_type]"
                       id="mcu-type"
                       value="">
                <input type="text"
                       id="mcu-type-display"
                       class="form-control input-sm input-new-order mcu-simple-type"
                       placeholder="Klik cari untuk memilih jenis MCU..."
                       readonly>
                <button type="button"
                        class="btn btn-xs btn-default input-new-order"
                        id="btn-open-mcu-type-modal"
                        title="Cari Jenis MCU">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <div class="mcu-simple-row mcu-simple-row-notes">
            <label>Keterangan</label>
            <textarea name="mcu[notes]"
                      id="mcu-notes"
                      class="form-control input-sm input-new-order mcu-simple-notes"
                      rows="6"></textarea>
        </div>
    </div>
</div>
<div id="tab-gizi" class="tab-pane">
    <div class="gizi-order-box">
        <div class="gizi-order-grid">

    <div class="gizi-card gizi-pagi">
        <div class="gizi-card-title">Menu Makan Pagi</div>
        <div class="gizi-row">
            <label>Diet</label>
            <div class="gizi-diet-stack">
                <?= $this->Form->select('nutrition[morning][diet_1]', $nutritionDietOptions, ['empty' => '-- Pilih Diet --', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-morning-diet-1']) ?>
                <?= $this->Form->select('nutrition[morning][diet_2]', $nutritionDietOptions, ['empty' => '', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-morning-diet-2', 'disabled' => true]) ?>
                <?= $this->Form->select('nutrition[morning][diet_3]', $nutritionDietOptions, ['empty' => '', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-morning-diet-3', 'disabled' => true]) ?>
            </div>
            <label class="gizi-menu-label">Menu Makan</label>
            <div class="gizi-picker">
                <input type="hidden" name="nutrition[morning][menu_code]" id="gizi-morning-menu-code">
                <input type="text" name="nutrition[morning][menu_name]" id="gizi-morning-menu-name" class="form-control input-sm input-new-order gizi-menu-input" readonly>
                <button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="morning" data-target-type="menu"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="gizi-row gizi-nutrition-row">
            <label></label>
            <div></div>
            <label>Energi</label><input type="text" name="nutrition[morning][energy]" id="gizi-morning-energy" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Protein</label><input type="text" name="nutrition[morning][protein]" id="gizi-morning-protein" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Lemak</label><input type="text" name="nutrition[morning][fat]" id="gizi-morning-fat" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Karbohidrat</label><input type="text" name="nutrition[morning][carbohydrate]" id="gizi-morning-carbohydrate" class="form-control input-sm input-new-order gizi-small-number" value="0">
        </div>
        <div class="gizi-row gizi-component-row">
            <label>Komponen Tambahan</label>
            <div class="gizi-component-stack">
                <div class="gizi-picker"><input type="text" name="nutrition[morning][component_1]" id="gizi-morning-component-1" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="morning" data-target-field="component-1" data-target-type="component"><i class="fa fa-search"></i></button></div>
                <div class="gizi-picker"><input type="text" name="nutrition[morning][component_2]" id="gizi-morning-component-2" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="morning" data-target-field="component-2" data-target-type="component"><i class="fa fa-search"></i></button></div>
                <div class="gizi-picker"><input type="text" name="nutrition[morning][component_3]" id="gizi-morning-component-3" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="morning" data-target-field="component-3" data-target-type="component"><i class="fa fa-search"></i></button></div>
            </div>
            <textarea name="nutrition[morning][notes]" class="form-control input-sm input-new-order gizi-period-notes"></textarea>
        </div>
    </div>
    <div class="gizi-card gizi-siang">
        <div class="gizi-card-title">Menu Makan Siang</div>
        <div class="gizi-row">
            <label>Diet</label>
            <div class="gizi-diet-stack">
                <?= $this->Form->select('nutrition[lunch][diet_1]', $nutritionDietOptions, ['empty' => '-- Pilih Diet --', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-lunch-diet-1']) ?>
                <?= $this->Form->select('nutrition[lunch][diet_2]', $nutritionDietOptions, ['empty' => '', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-lunch-diet-2', 'disabled' => true]) ?>
                <?= $this->Form->select('nutrition[lunch][diet_3]', $nutritionDietOptions, ['empty' => '', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-lunch-diet-3', 'disabled' => true]) ?>
            </div>
            <label class="gizi-menu-label">Menu Makan</label>
            <div class="gizi-picker">
                <input type="hidden" name="nutrition[lunch][menu_code]" id="gizi-lunch-menu-code">
                <input type="text" name="nutrition[lunch][menu_name]" id="gizi-lunch-menu-name" class="form-control input-sm input-new-order gizi-menu-input" readonly>
                <button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="lunch" data-target-type="menu"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="gizi-row gizi-nutrition-row">
            <label></label>
            <div></div>
            <label>Energi</label><input type="text" name="nutrition[lunch][energy]" id="gizi-lunch-energy" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Protein</label><input type="text" name="nutrition[lunch][protein]" id="gizi-lunch-protein" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Lemak</label><input type="text" name="nutrition[lunch][fat]" id="gizi-lunch-fat" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Karbohidrat</label><input type="text" name="nutrition[lunch][carbohydrate]" id="gizi-lunch-carbohydrate" class="form-control input-sm input-new-order gizi-small-number" value="0">
        </div>
        <div class="gizi-row gizi-component-row">
            <label>Komponen Tambahan</label>
            <div class="gizi-component-stack">
                <div class="gizi-picker"><input type="text" name="nutrition[lunch][component_1]" id="gizi-lunch-component-1" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="lunch" data-target-field="component-1" data-target-type="component"><i class="fa fa-search"></i></button></div>
                <div class="gizi-picker"><input type="text" name="nutrition[lunch][component_2]" id="gizi-lunch-component-2" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="lunch" data-target-field="component-2" data-target-type="component"><i class="fa fa-search"></i></button></div>
                <div class="gizi-picker"><input type="text" name="nutrition[lunch][component_3]" id="gizi-lunch-component-3" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="lunch" data-target-field="component-3" data-target-type="component"><i class="fa fa-search"></i></button></div>
            </div>
            <textarea name="nutrition[lunch][notes]" class="form-control input-sm input-new-order gizi-period-notes"></textarea>
        </div>
    </div>
    <div class="gizi-card gizi-malam">
        <div class="gizi-card-title">Menu Makan Malam</div>
        <div class="gizi-row">
            <label>Diet</label>
            <div class="gizi-diet-stack">
                <?= $this->Form->select('nutrition[night][diet_1]', $nutritionDietOptions, ['empty' => '-- Pilih Diet --', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-night-diet-1']) ?>
                <?= $this->Form->select('nutrition[night][diet_2]', $nutritionDietOptions, ['empty' => '', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-night-diet-2', 'disabled' => true]) ?>
                <?= $this->Form->select('nutrition[night][diet_3]', $nutritionDietOptions, ['empty' => '', 'value' => '', 'class' => 'form-control input-sm input-new-order gizi-diet-select', 'id' => 'gizi-night-diet-3', 'disabled' => true]) ?>
            </div>
            <label class="gizi-menu-label">Menu Makan</label>
            <div class="gizi-picker">
                <input type="hidden" name="nutrition[night][menu_code]" id="gizi-night-menu-code">
                <input type="text" name="nutrition[night][menu_name]" id="gizi-night-menu-name" class="form-control input-sm input-new-order gizi-menu-input" readonly>
                <button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="night" data-target-type="menu"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="gizi-row gizi-nutrition-row">
            <label></label>
            <div></div>
            <label>Energi</label><input type="text" name="nutrition[night][energy]" id="gizi-night-energy" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Protein</label><input type="text" name="nutrition[night][protein]" id="gizi-night-protein" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Lemak</label><input type="text" name="nutrition[night][fat]" id="gizi-night-fat" class="form-control input-sm input-new-order gizi-small-number" value="0">
            <label>Karbohidrat</label><input type="text" name="nutrition[night][carbohydrate]" id="gizi-night-carbohydrate" class="form-control input-sm input-new-order gizi-small-number" value="0">
        </div>
        <div class="gizi-row gizi-component-row">
            <label>Komponen Tambahan</label>
            <div class="gizi-component-stack">
                <div class="gizi-picker"><input type="text" name="nutrition[night][component_1]" id="gizi-night-component-1" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="night" data-target-field="component-1" data-target-type="component"><i class="fa fa-search"></i></button></div>
                <div class="gizi-picker"><input type="text" name="nutrition[night][component_2]" id="gizi-night-component-2" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="night" data-target-field="component-2" data-target-type="component"><i class="fa fa-search"></i></button></div>
                <div class="gizi-picker"><input type="text" name="nutrition[night][component_3]" id="gizi-night-component-3" class="form-control input-sm input-new-order" readonly><button type="button" class="btn btn-xs btn-default input-new-order btn-open-gizi-modal" data-target-period="night" data-target-field="component-3" data-target-type="component"><i class="fa fa-search"></i></button></div>
            </div>
            <textarea name="nutrition[night][notes]" class="form-control input-sm input-new-order gizi-period-notes"></textarea>
        </div>
    </div>
            <div class="gizi-family-box">
                <label>Order Menu Keluarga Pasien</label>
                <textarea name="nutrition[family_menu]" class="form-control input-sm input-new-order gizi-family-text"></textarea>
                <label style="margin-top:12px;">Catatan</label>
                <textarea name="nutrition[notes]" class="form-control input-sm input-new-order gizi-catatan-text"></textarea>
            </div>
        </div>
    </div>
</div>

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

</div>
</div>
</div>


<div class="modal fade" id="modal-jenis-operasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-operation-dialog">
        <div class="modal-content modal-operation-content">
            <div class="modal-operation-title">
                <span><i class="fa fa-search"></i> DAFTAR JENIS OPERASI</span>
                <button type="button" class="close modal-operation-close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-operation-body">
                <div class="operation-search-row">
                    <label>Cari Tindakan</label>
                    <input type="text"
                           id="operation-modal-search"
                           class="form-control input-sm"
                           placeholder="Ketik kode / nama tindakan operasi..."
                           autocomplete="off">
                </div>

                <div class="operation-table-wrap">
                    <table class="table table-bordered table-condensed operation-table">
                        <thead>
                            <tr>
                                <th style="width:34px;">Ok</th>
                                <th style="width:95px;">Kode</th>
                                <th>Tindakan</th>
                                <th style="width:95px;">Jasa RS</th>
                                <th style="width:95px;">Jasa DR</th>
                                <th style="width:110px;">Jasa Paramedis</th>
                                <th style="width:95px;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="operation-modal-tbody">
                            <tr>
                                <td colspan="7" class="operation-empty">Ketik pencarian atau klik tombol cari.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="operation-selected-box">
                    <table class="table table-bordered table-condensed operation-selected-table">
                        <thead>
                            <tr>
                                <th style="width:105px;">Kodetarif</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="operation-selected-tbody">
                            <tr>
                                <td colspan="2" class="operation-empty">Belum ada tindakan dipilih.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="operation-footer">
                    <label style="font-weight:500;margin-right:12px;">
                        <input type="radio" name="operation_filter_type" checked> Umum
                    </label>
                    <label style="font-weight:500;margin-right:12px;">
                        <input type="radio" name="operation_filter_type"> Penjamin
                    </label>
                    <label style="font-weight:500;margin-right:12px;">
                        <input type="radio" name="operation_filter_type"> Kelompok
                    </label>

                    <button type="button" class="btn btn-primary btn-sm" id="btn-operation-ok">
                        <i class="fa fa-check"></i> OK
                    </button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-jenis-mcu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-mcu-dialog">
        <div class="modal-content modal-mcu-content">
            <div class="modal-mcu-title">
                <span><i class="fa fa-search"></i> DAFTAR JENIS MCU</span>
                <button type="button" class="close modal-mcu-close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-mcu-body">
                <div class="mcu-modal-search-row">
                    <label>Cari Jenis</label>
                    <input type="text"
                           id="mcu-type-modal-search"
                           class="form-control input-sm"
                           placeholder="Ketik kode / nama jenis MCU..."
                           autocomplete="off">
                    <button type="button"
                            class="btn btn-primary btn-sm"
                            id="btn-search-mcu-type">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>

                <div class="mcu-type-table-wrap">
                    <table class="table table-bordered table-condensed mcu-type-table">
                        <thead>
                            <tr>
                                <th style="width:45px;">Ok</th>
                                <th style="width:110px;">Kode</th>
                                <th>Jenis MCU</th>
                                <th style="width:260px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="mcu-type-modal-tbody">
                            <tr>
                                <td colspan="4" class="mcu-type-empty">Ketik pencarian atau klik tombol cari.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mcu-type-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="btn-mcu-type-ok">
                        <i class="fa fa-check"></i> OK
                    </button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-gizi-master" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-gizi-dialog">
        <div class="modal-content modal-gizi-content">
            <div class="modal-gizi-title">
                <span><i class="fa fa-search"></i> DAFTAR MASTER GIZI</span>
                <button type="button" class="close modal-gizi-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-gizi-body">
                <div class="gizi-modal-search-row">
                    <label>Cari</label>
                    <input type="text" id="gizi-modal-search" class="form-control input-sm" placeholder="Ketik kode / nama menu / kandungan..." autocomplete="off">
                    <button type="button" class="btn btn-primary btn-sm" id="btn-search-gizi-master"><i class="fa fa-search"></i> Cari</button>
                </div>
                <div class="gizi-master-table-wrap">
                    <table class="table table-bordered table-condensed gizi-master-table">
                        <thead>
                            <tr>
                                <th style="width:42px;">Ok</th>
                                <th style="width:90px;">Kode</th>
                                <th>Nama Menu</th>
                                <th style="width:160px;">Kandungan</th>
                                <th style="width:90px;">Nilai</th>
                                <th style="width:80px;">Satuan</th>
                            </tr>
                        </thead>
                        <tbody id="gizi-master-tbody">
                            <tr><td colspan="6" class="gizi-master-empty">Ketik pencarian atau klik tombol cari.</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="gizi-master-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="btn-gizi-master-ok"><i class="fa fa-check"></i> OK</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Keluar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.panel-heading strong { font-size:12px; }
/* TAB ORDER - aktif mengikuti halaman yang sedang dibuka */
#order-tabs{
    display:flex!important;
    width:100%!important;
    border-bottom:0!important;
    margin:0!important;
}
#order-tabs > li{
    flex:1!important;
    float:none!important;
    margin:0!important;
    text-align:center!important;
}
#order-tabs > li > a{
    display:block!important;
    width:100%!important;
    margin:0!important;
    border-radius:0!important;
    font-size:11px!important;
    font-weight:700!important;
    padding:10px 8px!important;
    color:#1e3a5f!important;
    background:#f4f6f9!important;
    border:1px solid #d8dde6!important;
    border-right:0!important;
    text-align:center!important;
    transition:all .15s ease!important;
}
#order-tabs > li:last-child > a{
    border-right:1px solid #d8dde6!important;
}
#order-tabs > li > a:hover{
    background:#315b8f!important;
    color:#fff!important;
    border-color:#315b8f!important;
}
#order-tabs > li.active > a,
#order-tabs > li.active > a:hover,
#order-tabs > li.active > a:focus{
    background:#1e3a5f!important;
    color:#fff!important;
    border-color:#1e3a5f!important;
}
.tab-content > .tab-pane{
    display:none;
}
.tab-content > .tab-pane.active{
    display:block;
}
.gizi-diet-select:disabled,
.gizi-diet-select.gizi-diet-locked{
    background:#e9ecef!important;
    color:#9aa3ad!important;
    cursor:not-allowed!important;
}
.gizi-diet-select:not(:disabled),
.gizi-diet-select.gizi-diet-open{
    background:#fff!important;
    color:#333!important;
    cursor:pointer!important;
}

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

.lab-topbar { display:flex; align-items:center; gap:8px; margin-bottom:7px; }
.lab-searchbar { display:flex; align-items:center; gap:6px; margin-bottom:8px; }
#lab-search-input { width:430px; }
.lab-row td { vertical-align:middle; padding:3px 4px !important; }
.lab-row input.form-control { height:26px; padding:2px 5px; font-size:11px; }
#lab-dropdown { display:none; position:fixed; z-index:99999; background:#fff; border:1px solid #ced4da; border-radius:4px; box-shadow:0 4px 16px rgba(0,0,0,.15); max-height:300px; overflow-y:auto; width:520px; font-size:12px; }
#lab-dropdown .lab-dd-item { padding:7px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; line-height:1.4; }
#lab-dropdown .lab-dd-item:hover { background:#e8f0fe; }
#lab-dropdown .lab-name { font-weight:600; color:#1e3a5f; font-size:12px; }
#lab-dropdown .lab-meta { font-size:10px; color:#888; }
#lab-dropdown .lab-price { color:#27ae60; font-weight:600; }
#lab-dropdown .lab-empty, #lab-dropdown .lab-loading { padding:12px; text-align:center; color:#888; font-size:12px; }


.radio-topbar { display:flex; align-items:center; gap:8px; margin-bottom:7px; }
.radio-searchbar { display:flex; align-items:center; gap:6px; margin-bottom:8px; }
#radio-search-input { width:430px; }
.radio-row td { vertical-align:middle; padding:3px 4px !important; }
.radio-row input.form-control { height:26px; padding:2px 5px; font-size:11px; }
#radio-dropdown { display:none; position:fixed; z-index:99999; background:#fff; border:1px solid #ced4da; border-radius:4px; box-shadow:0 4px 16px rgba(0,0,0,.15); max-height:300px; overflow-y:auto; width:520px; font-size:12px; }
#radio-dropdown .radio-dd-item { padding:7px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; line-height:1.4; }
#radio-dropdown .radio-dd-item:hover { background:#e8f0fe; }
#radio-dropdown .radio-name { font-weight:600; color:#1e3a5f; font-size:12px; }
#radio-dropdown .radio-meta { font-size:10px; color:#888; }
#radio-dropdown .radio-price { color:#27ae60; font-weight:600; }
#radio-dropdown .radio-empty, #radio-dropdown .radio-loading { padding:12px; text-align:center; color:#888; font-size:12px; }


.support-topbar { display:flex; align-items:center; gap:8px; margin-bottom:7px; }
.support-searchbar { display:flex; align-items:center; gap:6px; margin-bottom:8px; }
#support-search-input { width:430px; }
.support-row td { vertical-align:middle; padding:3px 4px !important; }
.support-row input.form-control { height:26px; padding:2px 5px; font-size:11px; }
#support-dropdown { display:none; position:fixed; z-index:99999; background:#fff; border:1px solid #ced4da; border-radius:4px; box-shadow:0 4px 16px rgba(0,0,0,.15); max-height:300px; overflow-y:auto; width:520px; font-size:12px; }
#support-dropdown .support-dd-item { padding:7px 10px; cursor:pointer; border-bottom:1px solid #f0f0f0; line-height:1.4; }
#support-dropdown .support-dd-item:hover { background:#e8f0fe; }
#support-dropdown .support-name { font-weight:600; color:#1e3a5f; font-size:12px; }
#support-dropdown .support-meta { font-size:10px; color:#888; }
#support-dropdown .support-price { color:#27ae60; font-weight:600; }
#support-dropdown .support-empty, #support-dropdown .support-loading { padding:12px; text-align:center; color:#888; font-size:12px; }


.bedah-box {
    background:#f7f7fb;
    border:1px solid #d7dce5;
    padding:9px 10px;
    min-height:0;
}
.bedah-compact { margin:0; }
.bedah-grid {
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:14px;
    align-items:start;
}
.bedah-card {
    background:#fbfcff;
    border:1px solid #e0e5ef;
    padding:10px 12px 8px;
    min-height:214px;
}
.bedah-section-title {
    font-size:12px;
    font-weight:800;
    color:#1e3a5f;
    margin:0 0 8px 0;
    padding-bottom:5px;
    border-bottom:1px solid #e3e7ef;
}
.bedah-line {
    display:grid;
    grid-template-columns:105px 1fr;
    gap:8px;
    align-items:center;
    margin-bottom:5px;
}
.bedah-card-approved .bedah-line { grid-template-columns:118px 1fr; }
.bedah-line label {
    margin:0;
    font-size:12px;
    font-weight:600;
    color:#444;
    line-height:1.2;
}
.bedah-line .form-control {
    height:27px;
    padding:3px 7px;
    font-size:12px;
}
.bedah-line-textarea { align-items:start; }
.bedah-line textarea.form-control {
    height:70px;
    min-height:70px;
    resize:vertical;
}
.bedah-date { max-width:150px; }
.bedah-time { max-width:118px; }
.bedah-small { max-width:120px; }
.bedah-input-search {
    display:flex;
    gap:4px;
    align-items:center;
}
.bedah-input-search .form-control { flex:1; }
.bedah-input-search .btn {
    width:27px;
    height:27px;
    padding:2px 0;
}

.operator-combo {
    position:relative;
    width:100%;
}
.operator-combo-toggle {
    width:100%;
    height:27px;
    border:1px solid #ccc;
    background:#fff;
    border-radius:3px;
    padding:3px 28px 3px 7px;
    text-align:left;
    font-size:12px;
    line-height:20px;
    position:relative;
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
}
.operator-combo-arrow {
    position:absolute;
    right:7px;
    top:3px;
    font-size:13px;
    color:#333;
}
.operator-combo-dropdown {
    display:none;
    position:absolute;
    top:29px;
    left:0;
    width:390px;
    max-width:calc(100vw - 40px);
    background:#fff;
    border:1px solid #5b5b9b;
    box-shadow:0 4px 12px rgba(0,0,0,.25);
    z-index:100000;
}
.operator-combo-search-wrap {
    padding:5px;
    border-bottom:1px solid #d7d7ef;
    background:#eeeeff;
}
.operator-combo-search-wrap input {
    height:26px;
    font-size:12px;
}
.operator-combo-table-wrap {
    max-height:205px;
    overflow:auto;
}
.operator-combo-table {
    width:100%;
    border-collapse:collapse;
    font-size:11px;
    table-layout:fixed;
}
.operator-combo-table th {
    background:#c7c7f1;
    color:#111;
    border:1px solid #9999ca;
    padding:4px 6px;
    font-weight:700;
}
.operator-combo-table td {
    border:1px solid #d0d0e8;
    padding:3px 6px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    cursor:pointer;
}
.operator-option-row:hover td,
.operator-option-row.operator-active td {
    background:#315be8 !important;
    color:#fff !important;
}
.operator-code-cell {
    font-family:monospace;
}
.operator-empty {
    text-align:center;
    color:#888;
    padding:12px !important;
    cursor:default !important;
}
@media (max-width: 991px) {
    .bedah-grid { grid-template-columns:1fr; }
}

.mcu-simple-box{
    width: 900px;
    margin: 0;              /* jangan auto */
    padding: 5px 0;
}

.mcu-simple-row{
    display:flex;
    align-items:flex-start;
    margin-bottom:10px;
}

.mcu-simple-row label{
    width:90px;
    text-align:right;
    margin-right:12px;
    font-weight:600;
    padding-top:6px;
    flex-shrink:0;
}

.mcu-simple-row > div{
    flex:1;
}

.mcu-simple-date{
    width:240px !important;
}

.mcu-simple-time{
    width:180px !important;
}

.mcu-simple-type{
    width:760px !important;
}

.mcu-simple-notes{
    width:760px !important;
    height:190px;
    resize:none;
}
.mcu-simple-row-notes label {
    padding-top:8px;
}
.mcu-simple-notes {
    width:100% !important;
    max-width:100%;
    height:155px !important;
    min-height:155px !important;
    resize:vertical;
    display:block;
}
@media (max-width: 991px) {
    .mcu-simple-box {
        max-width:100%;
        margin:0;
        padding:12px 0 18px 0;
    }
    .mcu-simple-row {
        grid-template-columns:100px minmax(0, 1fr);
    }
    .mcu-simple-date,
    .mcu-simple-time,
    .mcu-simple-type,
    .mcu-simple-notes {
        width:100% !important;
    }
}
@media (max-width: 600px) {
    .mcu-simple-row {
        grid-template-columns:1fr;
        gap:4px;
    }
    .mcu-simple-row label {
        text-align:left;
    }
}


.mcu-type-picker {
    display:flex;
    align-items:center;
    gap:4px;
    width:760px;
    max-width:100%;
}
.mcu-type-picker .mcu-simple-type {
    flex:1;
    width:auto !important;
}
.mcu-type-picker .btn {
    width:30px;
    height:28px;
    padding:3px 0;
}
.modal-mcu-dialog{width:760px;max-width:96%;}
.modal-mcu-content{border:1px solid #394f90;background:#d9d9ef;box-shadow:0 5px 18px rgba(0,0,0,.35);}
.modal-mcu-title{background:#122d91;color:#fff;padding:6px 9px;font-size:12px;font-weight:700;display:flex;justify-content:space-between;align-items:center;}
.modal-mcu-close{color:#fff;opacity:1;font-size:18px;line-height:18px;}
.modal-mcu-body{padding:10px;font-size:12px;}
.mcu-modal-search-row{display:flex;align-items:center;gap:8px;margin-bottom:8px;}
.mcu-modal-search-row label{margin:0;width:75px;font-size:12px;color:#222;}
.mcu-modal-search-row input{max-width:430px;}
.mcu-type-table-wrap{height:340px;overflow:auto;border:1px solid #8892b5;background:#fff;}
.mcu-type-table{font-size:11px;margin:0;background:#fff;}
.mcu-type-table th{background:#c5c9e8!important;color:#111!important;text-align:center;vertical-align:middle;padding:4px!important;}
.mcu-type-table td{padding:4px 6px!important;vertical-align:middle;}
.mcu-type-row{cursor:pointer;}
.mcu-type-row:hover td{background:#e6efff!important;}
.mcu-type-row.mcu-type-active td{background:#315be8!important;color:#fff!important;}
.mcu-type-empty{text-align:center;color:#888;padding:28px!important;}
.mcu-type-code{font-family:monospace;font-weight:700;}
.mcu-type-footer{padding-top:9px;text-align:right;}
@media (max-width: 991px) {
    .mcu-type-picker {
        width:100%;
    }
}


.gizi-order-box{
    width:100%;
    padding:0;
    overflow:hidden;
    box-sizing:border-box;
}
.gizi-order-grid{
    display:grid;
    grid-template-columns:calc(50% - 6px) calc(50% - 6px);
    grid-template-rows:auto auto;
    gap:10px 12px;
    width:100%;
    box-sizing:border-box;
    align-items:start;
}
.gizi-card{
    border:1px solid #4b4b9a;
    padding:8px 10px 9px;
    color:#07315c;
    box-sizing:border-box;
    min-width:0;
    overflow:hidden;
    min-height:286px;
}
.gizi-pagi{
    background:#13c94e;
    grid-column:1;
    grid-row:1;
}
.gizi-siang{
    background:#10aeb8;
    grid-column:2;
    grid-row:1;
}
.gizi-malam{
    background:#163cff;
    grid-column:1;
    grid-row:2;
}
.gizi-card-title{
    font-weight:700;
    font-size:12px;
    line-height:16px;
    margin:0 0 7px;
    color:#07315c;
}

/* Baris Diet + Menu Makan dibuat rapi: judul di atas input */
.gizi-row{
    display:grid;
    grid-template-columns:58% 42%;
    grid-template-rows:auto auto;
    column-gap:10px;
    row-gap:3px;
    align-items:start;
    margin-bottom:7px;
    min-width:0;
}
.gizi-row label{
    font-size:11px;
    font-weight:700;
    margin:0;
    color:#07315c;
    white-space:nowrap;
}
.gizi-row > label:first-child{
    grid-column:1;
    grid-row:1;
}
.gizi-diet-stack{
    grid-column:1;
    grid-row:2;
    display:flex;
    flex-direction:column;
    gap:3px;
    min-width:0;
}
.gizi-menu-label{
    grid-column:2;
    grid-row:1;
    text-align:left;
    padding-left:0;
}
.gizi-row > .gizi-picker{
    grid-column:2;
    grid-row:2;
}
.gizi-diet-select{
    width:100%!important;
    height:24px!important;
    padding:2px 5px!important;
    font-size:11px!important;
}
.gizi-picker{
    display:flex;
    align-items:center;
    gap:3px;
    width:100%;
    min-width:0;
}
.gizi-picker .form-control{
    height:24px!important;
    padding:2px 5px!important;
    font-size:11px!important;
    min-width:0;
}
.gizi-picker .btn{
    width:28px!important;
    height:24px!important;
    padding:1px 0!important;
    flex:0 0 28px;
}
.gizi-menu-input{
    width:100%!important;
}

/* Energi/Protein/Lemak/Karbohidrat dipindah ke bawah Menu Makan.
   Label di atas, input di bawah supaya tidak kepotong. */
.gizi-nutrition-row{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    grid-template-rows:14px 26px;
    gap:2px 8px;
    align-items:center;
    margin:4px 0 8px 0;
    width:100%;
}
.gizi-nutrition-row > label:first-child,
.gizi-nutrition-row > div{
    display:none!important;
}
.gizi-nutrition-row label{
    font-size:11px;
    font-weight:700;
    margin:0;
    color:#07315c;
    text-align:left;
    line-height:13px;
    white-space:nowrap;
}
.gizi-nutrition-row input{
    width:100%!important;
    min-width:0!important;
    height:24px!important;
    text-align:right;
    padding:2px 5px!important;
    font-size:11px!important;
    box-sizing:border-box;
}
.gizi-nutrition-row label:nth-of-type(2){grid-column:1;grid-row:1;}
.gizi-nutrition-row input:nth-of-type(1){grid-column:1;grid-row:2;}
.gizi-nutrition-row label:nth-of-type(3){grid-column:2;grid-row:1;}
.gizi-nutrition-row input:nth-of-type(2){grid-column:2;grid-row:2;}
.gizi-nutrition-row label:nth-of-type(4){grid-column:3;grid-row:1;}
.gizi-nutrition-row input:nth-of-type(3){grid-column:3;grid-row:2;}
.gizi-nutrition-row label:nth-of-type(5){grid-column:4;grid-row:1;}
.gizi-nutrition-row input:nth-of-type(4){grid-column:4;grid-row:2;}
.gizi-small-number{
    width:100%!important;
}

/* Komponen tambahan: judul di atas, kiri input komponen, kanan catatan menu */
.gizi-component-row{
    display:grid;
    grid-template-columns:58% 42%;
    grid-template-rows:auto auto;
    column-gap:10px;
    row-gap:3px;
    align-items:start;
    margin:0;
    min-width:0;
}
.gizi-component-row > label{
    grid-column:1 / span 2;
    grid-row:1;
    font-size:11px;
    font-weight:700;
    margin:0;
    color:#07315c;
}
.gizi-component-stack{
    grid-column:1;
    grid-row:2;
    display:flex;
    flex-direction:column;
    gap:3px;
    min-width:0;
}
.gizi-component-stack .gizi-picker{
    width:100%;
}
.gizi-period-notes{
    grid-column:2;
    grid-row:2;
    width:100%!important;
    height:75px!important;
    min-height:75px!important;
    resize:none;
    padding:3px 5px!important;
    font-size:11px!important;
    box-sizing:border-box;
}
.gizi-family-box{
    grid-column:2;
    grid-row:2;
    padding:0 8px;
    box-sizing:border-box;
    min-width:0;
}
.gizi-family-box label{
    display:block;
    font-size:12px;
    font-weight:700;
    color:#07315c;
    margin:2px 0 5px;
}
.gizi-family-text{
    width:100%!important;
    height:108px!important;
    resize:none;
    font-size:11px!important;
    box-sizing:border-box;
}
.gizi-catatan-text{
    width:100%!important;
    height:106px!important;
    resize:none;
    font-size:11px!important;
    box-sizing:border-box;
}
@media(max-width:1200px){
    .gizi-card{
        padding:7px 8px 8px;
    }
    .gizi-row,
    .gizi-component-row{
        grid-template-columns:56% 44%;
        column-gap:8px;
    }
    .gizi-nutrition-row{
        gap:2px 6px;
    }
}
@media(max-width:1100px){
    .gizi-order-grid{
        grid-template-columns:1fr;
    }
    .gizi-pagi,
    .gizi-siang,
    .gizi-malam,
    .gizi-family-box{
        grid-column:1;
        grid-row:auto;
    }
}
@media(max-width:991px){
    .gizi-row,
    .gizi-component-row{
        grid-template-columns:1fr!important;
    }
    .gizi-menu-label,
    .gizi-row > .gizi-picker,
    .gizi-component-row > label,
    .gizi-component-stack,
    .gizi-period-notes{
        grid-column:1!important;
        grid-row:auto!important;
    }
    .gizi-nutrition-row{
        grid-template-columns:repeat(2, 1fr);
        grid-template-rows:14px 26px 14px 26px;
    }
    .gizi-nutrition-row label:nth-of-type(4){grid-column:1;grid-row:3;}
    .gizi-nutrition-row input:nth-of-type(3){grid-column:1;grid-row:4;}
    .gizi-nutrition-row label:nth-of-type(5){grid-column:2;grid-row:3;}
    .gizi-nutrition-row input:nth-of-type(4){grid-column:2;grid-row:4;}
}
.modal-gizi-dialog{
    width:860px;
    max-width:96%;
}
.modal-gizi-content{
    border:1px solid #394f90;
    background:#d9d9ef;
    box-shadow:0 5px 18px rgba(0,0,0,.35);
}
.modal-gizi-title{
    background:#122d91;
    color:#fff;
    padding:6px 9px;
    font-size:12px;
    font-weight:700;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.modal-gizi-close{
    color:#fff;
    opacity:1;
    font-size:18px;
    line-height:18px;
}
.modal-gizi-body{
    padding:10px;
    font-size:12px;
}
.gizi-modal-search-row{
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:8px;
}
.gizi-modal-search-row label{
    width:45px;
    margin:0;
    font-size:12px;
}
.gizi-modal-search-row input{
    max-width:420px;
}
.gizi-master-table-wrap{
    height:330px;
    overflow:auto;
    border:1px solid #8892b5;
    background:#fff;
}
.gizi-master-table{
    font-size:11px;
    margin:0;
    background:#fff;
}
.gizi-master-table th{
    background:#c5c9e8!important;
    color:#111!important;
    text-align:center;
    vertical-align:middle;
    padding:4px!important;
}
.gizi-master-table td{
    padding:3px 5px!important;
    vertical-align:middle;
}
.gizi-master-row{
    cursor:pointer;
}
.gizi-master-row:hover td,
.gizi-master-row.gizi-master-active td{
    background:#bfdbfe!important;
    font-weight:700;
}
.gizi-master-empty{
    text-align:center;
    color:#888;
    padding:28px!important;
}
.gizi-master-footer{
    padding-top:8px;
    text-align:right;
}
@media(max-width:1100px){
    .gizi-order-grid{
        grid-template-columns:1fr;
    }
    .gizi-pagi,
    .gizi-siang,
    .gizi-malam,
    .gizi-family-box{
        grid-column:1;
        grid-row:auto;
    }
}
@media(max-width:991px){
    .gizi-row,
    .gizi-component-row{
        grid-template-columns:1fr!important;
    }
    .gizi-menu-label{
        text-align:left!important;
        padding-left:0!important;
    }
    .gizi-nutrition-row{
        margin-left:0!important;
    }
}
.modal-operation-dialog{width:980px;max-width:96%;}
.modal-operation-content{border:1px solid #394f90;background:#d9d9ef;box-shadow:0 5px 18px rgba(0,0,0,.35);}
.modal-operation-title{background:#122d91;color:#fff;padding:6px 9px;font-size:12px;font-weight:700;display:flex;justify-content:space-between;align-items:center;}
.modal-operation-close{color:#fff;opacity:1;font-size:18px;line-height:18px;}
.modal-operation-body{padding:10px;font-size:12px;}
.operation-search-row{display:flex;align-items:center;gap:10px;margin-bottom:8px;}
.operation-search-row label{margin:0;width:85px;font-size:12px;color:#222;}
.operation-search-row input{max-width:470px;}
.operation-table-wrap{float:left;width:72%;height:360px;overflow:auto;border:1px solid #8892b5;background:#fff;}
.operation-selected-box{float:right;width:27%;height:360px;overflow:auto;border:1px solid #8892b5;background:#fff;}
.operation-table,.operation-selected-table{font-size:11px;margin:0;background:#fff;}
.operation-table th,.operation-selected-table th{background:#c5c9e8!important;color:#111!important;text-align:center;vertical-align:middle;padding:4px!important;}
.operation-table td,.operation-selected-table td{padding:3px 5px!important;vertical-align:middle;}
.operation-row{cursor:pointer;}
.operation-row:hover td{background:#e6efff!important;}
.operation-row.operation-active td{background:#bfdbfe!important;font-weight:700;}
.operation-empty{text-align:center;color:#888;padding:28px!important;}
.operation-footer{clear:both;padding-top:9px;text-align:right;}
.operation-footer label{float:left;margin-top:6px;}
.operation-money{text-align:right;font-family:monospace;}

/* TAB ORDER FULL WIDTH - background pindah sesuai tab aktif */
#order-tabs{
    display:flex!important;
    width:100%!important;
    border-bottom:0!important;
    margin:0!important;
}

#order-tabs > li{
    flex:1!important;
    float:none!important;
    margin:0!important;
    text-align:center!important;
}

#order-tabs > li > a{
    display:block!important;
    width:100%!important;
    text-align:center!important;
    padding:10px 8px!important;
    margin:0!important;
    border-radius:0!important;
    background:#f4f6f9!important;
    color:#1e3a5f!important;
    border:1px solid #d8dde6!important;
    border-right:0!important;
    font-weight:700!important;
    transition:all .15s ease!important;
}

#order-tabs > li:last-child > a{
    border-right:1px solid #d8dde6!important;
}

#order-tabs > li > a:hover{
    background:#315b8f!important;
    color:#fff!important;
    border-color:#315b8f!important;
}

#order-tabs > li.active > a,
#order-tabs > li.active > a:hover,
#order-tabs > li.active > a:focus{
    background:#1e3a5f!important;
    color:#fff!important;
    border-color:#1e3a5f!important;
}

.tab-content > .tab-pane{
    display:none;
}
.tab-content > .tab-pane.active{
    display:block;
}

#tab-gizi .gizi-order-box{
    width:100%!important;
    padding:0!important;
    overflow:visible!important;
    box-sizing:border-box!important;
}
#tab-gizi .gizi-order-grid{
    display:grid!important;
    grid-template-columns:minmax(0, 1fr) minmax(0, 1fr)!important;
    grid-template-rows:auto auto!important;
    gap:18px!important;
    width:100%!important;
    align-items:stretch!important;
    box-sizing:border-box!important;
}
#tab-gizi .gizi-card{
    border:1px solid #cfd8e3!important;
    border-radius:6px!important;
    padding:15px!important;
    color:#1e3a5f!important;
    box-sizing:border-box!important;
    min-width:0!important;
    min-height:365px!important;
    overflow:hidden!important;
    box-shadow:0 1px 3px rgba(30,58,95,.08)!important;
}
#tab-gizi .gizi-pagi{
    background:#ffffff!important;
    grid-column:1!important;
    grid-row:1!important;
}
#tab-gizi .gizi-siang{
    background:#f7fbff!important;
    grid-column:2!important;
    grid-row:1!important;
}
#tab-gizi .gizi-malam{
    background:#eef5ff!important;
    grid-column:1!important;
    grid-row:2!important;
}
#tab-gizi .gizi-card-title{
    background:#1e3a5f!important;
    color:#fff!important;
    padding:8px 10px!important;
    margin:-15px -15px 12px!important;
    font-size:12px!important;
    line-height:16px!important;
    font-weight:800!important;
    border-radius:6px 6px 0 0!important;
}
#tab-gizi .gizi-row,
#tab-gizi .gizi-component-row{
    grid-template-columns:minmax(0, 56%) minmax(0, 44%)!important;
    column-gap:12px!important;
    row-gap:5px!important;
    margin-bottom:10px!important;
}
#tab-gizi .gizi-row label,
#tab-gizi .gizi-component-row > label,
#tab-gizi .gizi-family-box label{
    color:#1e3a5f!important;
    font-size:11px!important;
    font-weight:800!important;
}
#tab-gizi .gizi-diet-select,
#tab-gizi .gizi-picker .form-control,
#tab-gizi .gizi-nutrition-row input,
#tab-gizi .gizi-period-notes,
#tab-gizi .gizi-family-text,
#tab-gizi .gizi-catatan-text{
    border-radius:4px!important;
    border:1px solid #ced4da!important;
    background:#fff!important;
    color:#333!important;
    box-shadow:none!important;
}
#tab-gizi .gizi-picker .btn{
    background:#1e3a5f!important;
    color:#fff!important;
    border-color:#1e3a5f!important;
    border-radius:4px!important;
}
#tab-gizi .gizi-picker .btn:hover,
#tab-gizi .gizi-picker .btn:focus{
    background:#16304f!important;
    border-color:#16304f!important;
    color:#fff!important;
}
#tab-gizi .gizi-nutrition-row{
    display:grid!important;
    grid-template-columns:repeat(4, minmax(0, 1fr))!important;
    grid-template-rows:16px 28px!important;
    gap:4px 8px!important;
    margin:8px 0 12px!important;
    width:100%!important;
}
#tab-gizi .gizi-nutrition-row label{
    color:#1e3a5f!important;
    font-size:10.5px!important;
    line-height:14px!important;
    white-space:nowrap!important;
}
#tab-gizi .gizi-nutrition-row input{
    height:26px!important;
    padding:3px 5px!important;
    font-size:11px!important;
    text-align:right!important;
}
#tab-gizi .gizi-component-stack{
    gap:5px!important;
}
#tab-gizi .gizi-period-notes{
    height:86px!important;
    min-height:86px!important;
    resize:vertical!important;
    font-size:11px!important;
}
#tab-gizi .gizi-family-box{
    grid-column:2!important;
    grid-row:2!important;
    border:1px solid #cfd8e3!important;
    border-radius:6px!important;
    padding:14px!important;
    background:#fff!important;
    min-height:365px!important;
    box-sizing:border-box!important;
    box-shadow:0 1px 3px rgba(30,58,95,.08)!important;
}
#tab-gizi .gizi-family-box label{
    margin:0 0 6px!important;
}
#tab-gizi .gizi-family-text{
    height:145px!important;
    min-height:145px!important;
    resize:vertical!important;
}
#tab-gizi .gizi-catatan-text{
    height:145px!important;
    min-height:145px!important;
    resize:vertical!important;
}
@media(max-width:1100px){
    #tab-gizi .gizi-order-grid{
        grid-template-columns:1fr!important;
    }
    #tab-gizi .gizi-pagi,
    #tab-gizi .gizi-siang,
    #tab-gizi .gizi-malam,
    #tab-gizi .gizi-family-box{
        grid-column:1!important;
        grid-row:auto!important;
    }
}
@media(max-width:991px){
    #order-tabs{
        flex-wrap:wrap!important;
    }
    #order-tabs > li{
        flex:1 1 33.333%!important;
    }
    #tab-gizi .gizi-row,
    #tab-gizi .gizi-component-row{
        grid-template-columns:1fr!important;
    }
    #tab-gizi .gizi-menu-label,
    #tab-gizi .gizi-row > .gizi-picker,
    #tab-gizi .gizi-component-row > label,
    #tab-gizi .gizi-component-stack,
    #tab-gizi .gizi-period-notes{
        grid-column:1!important;
        grid-row:auto!important;
    }
    #tab-gizi .gizi-nutrition-row{
        grid-template-columns:repeat(2, minmax(0, 1fr))!important;
        grid-template-rows:16px 28px 16px 28px!important;
    }
}

</style>

<script>
$(document).ready(function () {
    var CARI_OBAT_URL = '<?= $this->Url->build(['action' => 'cariObat']) ?>';
    var CARI_LAB_URL = '<?= $this->Url->build(['action' => 'cariLaboratorium']) ?>';
    var CARI_RADIOLOGI_URL = '<?= $this->Url->build(['action' => 'cariRadiologi']) ?>';
    var CARI_PENUNJANG_URL = '<?= $this->Url->build(['action' => 'cariPenunjang']) ?>';
    var CARI_JENIS_OPERASI_URL = '<?= $this->Url->build(['action' => 'cariJenisOperasi']) ?>';
    var CARI_JENIS_MCU_URL = '<?= $this->Url->build(['action' => 'cariJenisMcu']) ?>';
    var CARI_NUTRITION_COMBINE_URL = '<?= $this->Url->build(['action' => 'cariNutritionCombine']) ?>';
    var HISTORY_DETAIL_URL = '<?= $this->Url->build(['action' => 'historyOrderDetail']) ?>';
    var drugRowIndex = 0;
    var labRowIndex = 0;
        radioRowIndex = 0;
    var radioRowIndex = 0;
    var supportRowIndex = 0;
    var isHistoryMode = false;

    /*
     * Perbaikan tab Order:
     * Bootstrap kadang tidak memindahkan class active pada template ini,
     * jadi active tab dan tab-pane dipindahkan manual agar warna background
     * ikut halaman yang sedang dibuka, misalnya Gizi bukan tetap Resep.
     */
    function setOrderActiveTab(targetTab) {
        if (!targetTab || $(targetTab).length === 0) {
            targetTab = '#tab-resep';
        }

        $('#order-tabs > li').removeClass('active');
        $('#order-tabs > li > a[href="' + targetTab + '"]').parent().addClass('active');

        $('.tab-content > .tab-pane').removeClass('active in').hide();
        $(targetTab).addClass('active in').show();
    }

    $('#order-tabs > li > a').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        setOrderActiveTab($(this).attr('href'));
    });

    $('#order-tabs > li > a').on('shown.bs.tab', function (e) {
        setOrderActiveTab($(e.target).attr('href'));
    });

    setOrderActiveTab($('#order-tabs > li.active > a').attr('href') || '#tab-resep');

    var defaultInfo = {
        no_order: 'AUTO',
        medical_record_no: '<?= h($p->code ?? '-') ?>',
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
        $('#lab-tbody').empty();
        $('#radio-tbody').empty();
        $('#support-tbody').empty();
        drugRowIndex = 0;
        labRowIndex = 0;
        supportRowIndex = 0;
        calcResepTotal();
        calcLabTotal();
        calcRadioTotal();
        calcSupportTotal();

        $('#info-no-order').val(defaultInfo.no_order);
        $('#info-no-rm').val(defaultInfo.medical_record_no);
        $('#info-nama-pasien').val(defaultInfo.nama);
        $('#info-jaminan').val(defaultInfo.jaminan);
        $('#info-tgl-order').val(defaultInfo.tgl_order);
        $('#info-jam-order').val(defaultInfo.jam_order);
        $('#info-asal-pasien').val(defaultInfo.asal_pasien);
        $('#info-pesan').val(defaultInfo.pesan);
        $('#info-dokter').val(defaultInfo.doctor_id);
        $('#obat-lain').val('');
        $('#catatan-order').val('');
        $('#lab-catatan').val('');
        $('#radio-catatan').val('');
        $('#support-catatan').val('');
        clearSurgeryForm();
        clearMcuForm();
    }

    $(document).on('click', '.history-order-row', function () {
    var orderId = $(this).data('id');

    $('.history-order-row').removeClass('history-active');
    $(this).addClass('history-active');

        isHistoryMode = true;
        $('#mode-history').show().text('MODE HISTORY ORDER - HANYA UNTUK MELIHAT');
        $('#btn-simpan').hide();
        $('.input-new-order').prop('disabled', true);

        $('#resep-tbody').html('<tr><td colspan="13" style="text-align:center;color:#888;">Memuat history order...</td></tr>');
        $('#lab-tbody').html('<tr><td colspan="6" style="text-align:center;color:#888;">Memuat history laboratorium...</td></tr>');
        $('#support-tbody').html('<tr><td colspan="9" style="text-align:center;color:#888;">Memuat history penunjang...</td></tr>');

        $.getJSON(HISTORY_DETAIL_URL + '/' + orderId, function (res) {
            if (!res.success) {
                $('#resep-tbody').html('<tr><td colspan="13" style="text-align:center;color:#a00;">History order gagal dimuat.</td></tr>');
                return;
            }

            $('#info-no-order').val(res.order.no_order || '-');
            $('#info-no-rm').val(res.patient.medical_record_no || '-');
            $('#info-nama-pasien').val(res.patient.nama || '-');
            $('#info-jaminan').val(res.patient.jaminan || '-');
            $('#info-tgl-order').val(res.order.tgl_order || '-');
            $('#info-jam-order').val(res.order.jam_order || '-');
            $('#info-asal-pasien').val(res.patient.asal_pasien || '-');
            $('#info-pesan').val(res.order.pesan || '');
            $('#info-dokter').val(res.order.doctor_id || '');
            $('#info-lokasi-depo').val(res.order.lokasi_depo || '');
            fillSurgeryForm(res.surgery || null);

            $('#resep-tbody').empty();

            if (!res.items || !res.items.length) {
                $('#resep-tbody').html('<tr><td colspan="13" style="text-align:center;color:#999;">Tidak ada item resep.</td></tr>');
                calcResepTotal();
                return;
            }

            $.each(res.items, function (i, item) {
                addHistoryRow(item, i);
            });

            $('#lab-tbody').empty();

            if (res.labs && res.labs.length) {
                $.each(res.labs, function (i, lab) {
                    addLabHistoryRow(lab, i);
                });
            } else {
                $('#lab-tbody').html('<tr><td colspan="6" style="text-align:center;color:#999;">Tidak ada order laboratorium.</td></tr>');
            }

            $('#support-tbody').empty();

            if (res.supports && res.supports.length) {
                $.each(res.supports, function (i, support) {
                    addSupportHistoryRow(support, i);
                });
            } else {
                $('#support-tbody').html('<tr><td colspan="9" style="text-align:center;color:#999;">Tidak ada order penunjang.</td></tr>');
            }

            calcResepTotal();
            calcLabTotal();
            calcSupportTotal();
        }).fail(function () {
            $('#resep-tbody').html('<tr><td colspan="13" style="text-align:center;color:#a00;">Gagal memuat history order.</td></tr>');
            $('#lab-tbody').html('<tr><td colspan="6" style="text-align:center;color:#a00;">Gagal memuat history laboratorium.</td></tr>');
            $('#support-tbody').html('<tr><td colspan="9" style="text-align:center;color:#a00;">Gagal memuat history penunjang.</td></tr>');
        });
    });

    $('#btn-add-drug-row-footer').on('click', function () {
        if (isHistoryMode) {
            setNewOrderMode();
            return;
        }

        var activeTab = $('#order-tabs li.active a').attr('href');

        if (activeTab === '#tab-lab') {
            addLabRow(null);
            return;
        }

        if (activeTab === '#tab-radio') {
            addRadioRow(null);
            return;
        }

        if (activeTab === '#tab-penunjang') {
            addSupportRow(null);
            return;
        }

        if (activeTab === '#tab-bedah') {
            $('#surgery-date').focus();
            return;
        }

        addDrugRow(null);
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

        if (q.length < 4) {
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
    var labTimer = null;
    var $labDD = $('#lab-dropdown');
    var $activeLabRow = null;

    $('#lab-search-input, #btn-search-lab').on('input click', function () {
        if (isHistoryMode) return;

        clearTimeout(labTimer);
        var q = $.trim($('#lab-search-input').val());
        $activeLabRow = null;

        if (q.length < 2) {
            $labDD.hide().empty();
            return;
        }

        $labDD.html('<div class="lab-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        positionLabDD($('#lab-search-input'));
        $labDD.show();

        labTimer = setTimeout(function () {
            fetchLabs(q, null);
        }, 250);
    });

    $(document).on('input', '.lab-name-input', function () {
        if (isHistoryMode) return;

        clearTimeout(labTimer);
        var q = $.trim($(this).val());
        $activeLabRow = $(this).closest('tr');

        if (q.length < 2) {
            $labDD.hide().empty();
            return;
        }

        $labDD.html('<div class="lab-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        positionLabDD($(this));
        $labDD.show();

        labTimer = setTimeout(function () {
            fetchLabs(q, $(this));
        }, 250);
    });

    function fetchLabs(q, $inp) {
        $.getJSON(CARI_LAB_URL, { q: q }, function (data) {
            renderLabDD(data, $inp);
        }).fail(function () {
            $labDD.html('<div class="lab-empty" style="color:#a00;">Gagal memuat data laboratorium.</div>').show();
        });
    }

    function renderLabDD(data, $inp) {
        $labDD.empty();

        if (!data || !data.length) {
            $labDD.html('<div class="lab-empty"><i class="fa fa-search"></i> Pemeriksaan tidak ditemukan</div>').show();
            return;
        }

        $.each(data, function (_, d) {
            var tarifHtml = d.tarif > 0 ? '<span class="lab-price">Rp ' + fmt(d.tarif) + '</span>' : '<span style="color:#aaa;">-</span>';

            $('<div class="lab-dd-item"></div>')
                .html('<div class="lab-name">' + escHtml(d.nama)
                    + (d.kode ? ' <span style="font-size:10px;background:#e9ecef;padding:0 4px;border-radius:2px;font-family:monospace;">' + escHtml(d.kode) + '</span>' : '') + '</div>'
                    + '<div class="lab-meta">' + (d.kategori ? 'Kategori: ' + escHtml(d.kategori) + ' · ' : '') + tarifHtml + '</div>')
                .data('lab', d)
                .on('mousedown', function (e) {
                    e.preventDefault();

                    if ($activeLabRow) {
                        fillLabRow($activeLabRow, d);
                    } else {
                        addLabRow(d);
                    }

                    $labDD.hide().empty();
                    $('#lab-search-input').val('');
                    $activeLabRow = null;
                })
                .appendTo($labDD);
        });

        $labDD.show();
    }

    function positionLabDD($input) {
        if (!$input || !$input.length) return;

        var rect = $input[0].getBoundingClientRect();
        var width = $input.outerWidth();

        if (width < 420) width = 520;

        var left = rect.left;
        var top = rect.bottom + 2;

        if (left + width > $(window).width() - 20) {
            left = $(window).width() - width - 20;
        }

        if (left < 10) left = 10;

        $labDD.css({ top: top, left: left, width: width });
    }

    $(window).on('scroll resize', function () {
        if ($labDD.is(':visible')) {
            var $input = $activeLabRow ? $activeLabRow.find('.lab-name-input') : $('#lab-search-input');
            positionLabDD($input);
        }
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#lab-search-input, #lab-dropdown, .lab-name-input, #btn-search-lab').length) {
            $labDD.hide();
        }
    });

    $('#btn-add-lab-row').on('click', function () {
        if (isHistoryMode) return;
        addLabRow(null);
    });

    $('#btn-clear-lab').on('click', function () {
        if (isHistoryMode) return;
        $('#lab-tbody').empty();
        labRowIndex = 0;
        calcLabTotal();
    });

    function addLabRow(lab) {
        var i = labRowIndex++;
        var d = lab || {};
        var tarif = parseFloat(d.tarif) || 0;

        var html = '<tr class="lab-row" data-i="' + i + '">'
            + '<td style="text-align:center; color:#777; font-size:10px;">' + labRowIndex + '</td>'
            + '<td><input type="text" name="laboratories[' + i + '][lab_code]" class="form-control lab-code-input" value="' + escHtml(d.kode || '') + '" style="font-family:monospace; font-size:10px;" placeholder="Kode"></td>'
            + '<td><input type="text" name="laboratories[' + i + '][lab_name]" class="form-control lab-name-input" value="' + escHtml(d.nama || '') + '" placeholder="Nama pemeriksaan..." autocomplete="off"></td>'
            + '<td><input type="text" name="laboratories[' + i + '][tariff]" class="form-control lab-tariff-input" value="' + tarif + '" style="text-align:right;"><span class="lab-tariff-display" style="display:block; font-size:10px; text-align:right; color:#888;">' + fmt(tarif) + '</span></td>'
            + '<td><input type="text" name="laboratories[' + i + '][approval_note]" class="form-control" placeholder="Keterangan approval..."></td>'
            + '<td style="text-align:center;"><button type="button" class="btn btn-xs btn-danger btn-remove-lab">&times;</button></td>'
            + '</tr>';

        $('#lab-tbody').append(html);
        calcLabTotal();

        if (!lab) {
            $('#lab-tbody tr:last').find('.lab-name-input').focus();
        }
    }

    function addLabHistoryRow(lab, i) {
        var tarif = parseFloat(lab.tarif || 0);

        var html = '<tr class="history-readonly-row lab-row">'
            + '<td style="text-align:center; color:#aaa; font-size:10px;">' + (i + 1) + '</td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(lab.kode || '') + '" readonly></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(lab.nama || '') + '" readonly></td>'
            + '<td><input type="text" class="form-control lab-tariff-input" value="' + tarif + '" readonly style="text-align:right;"></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(lab.approval || '') + '" readonly></td>'
            + '<td></td>'
            + '</tr>';

        $('#lab-tbody').append(html);
    }

    function fillLabRow($row, lab) {
        $row.find('.lab-code-input').val(lab.kode || '');
        $row.find('.lab-name-input').val(lab.nama || '');

        var tarif = parseFloat(lab.tarif) || 0;

        $row.find('.lab-tariff-input').val(tarif);
        $row.find('.lab-tariff-display').text(fmt(tarif));

        calcLabTotal();
    }

    $(document).on('click', '.btn-remove-lab', function () {
        if (isHistoryMode) return;

        $(this).closest('tr').remove();

        $('#lab-tbody tr').each(function (idx) {
            $(this).find('td:first').text(idx + 1);
        });

        calcLabTotal();
    });

    $(document).on('input', '.lab-tariff-input', function () {
        if (isHistoryMode) return;

        var val = parseFloat(String($(this).val() || '0').replace(/\./g, '').replace(',', '.')) || 0;
        $(this).closest('td').find('.lab-tariff-display').text(fmt(val));

        calcLabTotal();
    });

    function calcLabTotal() {
        var grand = 0;

        $('#lab-tbody tr').each(function () {
            var val = $(this).find('.lab-tariff-input').val();
            var total = parseFloat(String(val || '0').replace(/\./g, '').replace(',', '.')) || 0;
            grand += total;
        });

        $('#lab-grand-total').text('Rp ' + fmt(grand));
    }


    var radioTimer = null;
    var $radioDD = $('#radio-dropdown');
    var $activeRadioRow = null;

    $('#radio-search-input, #btn-search-radio').on('input click', function () {
        if (isHistoryMode) return;

        clearTimeout(radioTimer);
        var q = $.trim($('#radio-search-input').val());
        $activeRadioRow = null;

        if (q.length < 2) {
            $radioDD.hide().empty();
            return;
        }

        $radioDD.html('<div class="radio-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        positionRadioDD($('#radio-search-input'));
        $radioDD.show();

        radioTimer = setTimeout(function () {
            fetchRadios(q, null);
        }, 250);
    });

    $(document).on('input', '.radio-name-input', function () {
        if (isHistoryMode) return;

        clearTimeout(radioTimer);
        var q = $.trim($(this).val());
        $activeRadioRow = $(this).closest('tr');

        if (q.length < 2) {
            $radioDD.hide().empty();
            return;
        }

        $radioDD.html('<div class="radio-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        positionRadioDD($(this));
        $radioDD.show();

        radioTimer = setTimeout(function () {
            fetchRadios(q, $(this));
        }, 250);
    });

    function fetchRadios(q, $inp) {
        $.getJSON(CARI_RADIOLOGI_URL, { q: q }, function (data) {
            renderRadioDD(data, $inp);
        }).fail(function () {
            $radioDD.html('<div class="radio-empty" style="color:#a00;">Gagal memuat data radiologi.</div>').show();
        });
    }

    function renderRadioDD(data, $inp) {
        $radioDD.empty();

        if (!data || !data.length) {
            $radioDD.html('<div class="radio-empty"><i class="fa fa-search"></i> Pemeriksaan radiologi tidak ditemukan</div>').show();
            return;
        }

        $.each(data, function (_, d) {
            var tarifHtml = d.tarif > 0 ? '<span class="radio-price">Rp ' + fmt(d.tarif) + '</span>' : '<span style="color:#aaa;">-</span>';

            $('<div class="radio-dd-item"></div>')
                .html('<div class="radio-name">' + escHtml(d.nama)
                    + (d.kode ? ' <span style="font-size:10px;background:#e9ecef;padding:0 4px;border-radius:2px;font-family:monospace;">' + escHtml(d.kode) + '</span>' : '') + '</div>'
                    + '<div class="radio-meta">' + (d.kategori ? 'Kategori: ' + escHtml(d.kategori) + ' · ' : '') + (d.modality ? 'Modality: ' + escHtml(d.modality) + ' · ' : '') + tarifHtml + '</div>')
                .data('radio', d)
                .on('mousedown', function (e) {
                    e.preventDefault();

                    if ($activeRadioRow) {
                        fillRadioRow($activeRadioRow, d);
                    } else {
                        addRadioRow(d);
                    }

                    $radioDD.hide().empty();
                    $('#radio-search-input').val('');
                    $activeRadioRow = null;
                })
                .appendTo($radioDD);
        });

        $radioDD.show();
    }

    function positionRadioDD($input) {
        if (!$input || !$input.length) return;

        var rect = $input[0].getBoundingClientRect();
        var width = $input.outerWidth();

        if (width < 420) width = 520;

        var left = rect.left;
        var top = rect.bottom + 2;

        if (left + width > $(window).width() - 20) {
            left = $(window).width() - width - 20;
        }

        if (left < 10) left = 10;

        $radioDD.css({ top: top, left: left, width: width });
    }

    $(window).on('scroll resize', function () {
        if ($radioDD.is(':visible')) {
            var $input = $activeRadioRow ? $activeRadioRow.find('.radio-name-input') : $('#radio-search-input');
            positionRadioDD($input);
        }
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#radio-search-input, #radio-dropdown, .radio-name-input, #btn-search-radio').length) {
            $radioDD.hide();
        }
    });

    $('#btn-add-radio-row').on('click', function () {
        if (isHistoryMode) return;
        addRadioRow(null);
    });

    $('#btn-clear-radio').on('click', function () {
        if (isHistoryMode) return;
        $('#radio-tbody').empty();
        radioRowIndex = 0;
        calcRadioTotal();
    });

    function addRadioRow(radio) {
        var i = radioRowIndex++;
        var d = radio || {};
        var tarif = parseFloat(d.tarif) || 0;
        var qty = 1;
        var total = tarif * qty;

        var html = '<tr class="radio-row" data-i="' + i + '">'
            + '<td style="text-align:center; color:#777; font-size:10px;">' + radioRowIndex + '</td>'
            + '<td><input type="text" name="radiologies[' + i + '][code]" class="form-control radio-code-input" value="' + escHtml(d.kode || '') + '" style="font-family:monospace; font-size:10px;" placeholder="Kode"></td>'
            + '<td><input type="text" name="radiologies[' + i + '][examination_name]" class="form-control radio-name-input" value="' + escHtml(d.nama || '') + '" placeholder="Nama pemeriksaan..." autocomplete="off"></td>'
            + '<td><input type="text" name="radiologies[' + i + '][tariff]" class="form-control radio-tariff-input" value="' + tarif + '" style="text-align:right;"><span class="radio-tariff-display" style="display:block; font-size:10px; text-align:right; color:#888;">' + fmt(tarif) + '</span></td>'
            + '<td><input type="number" name="radiologies[' + i + '][qty]" class="form-control radio-qty-input" value="1" min="1" step="1" style="text-align:center;"></td>'
            + '<td><input type="text" name="radiologies[' + i + '][total]" class="form-control radio-total-input" value="' + fmt(total) + '" readonly style="text-align:right; background:#f5f5f5; font-weight:600;"></td>'
            + '<td><input type="text" name="radiologies[' + i + '][approval_note]" class="form-control" placeholder="Keterangan approval..."></td>'
            + '<td style="text-align:center;"><button type="button" class="btn btn-xs btn-danger btn-remove-radio">&times;</button></td>'
            + '</tr>';

        $('#radio-tbody').append(html);
        calcRadioTotal();

        if (!radio) {
            $('#radio-tbody tr:last').find('.radio-name-input').focus();
        }
    }

    function fillRadioRow($row, radio) {
        $row.find('.radio-code-input').val(radio.kode || '');
        $row.find('.radio-name-input').val(radio.nama || '');

        var tarif = parseFloat(radio.tarif) || 0;

        $row.find('.radio-tariff-input').val(tarif);
        $row.find('.radio-tariff-display').text(fmt(tarif));

        calcRadioRowTotal($row);
        calcRadioTotal();
    }

    $(document).on('click', '.btn-remove-radio', function () {
        if (isHistoryMode) return;

        $(this).closest('tr').remove();

        $('#radio-tbody tr').each(function (idx) {
            $(this).find('td:first').text(idx + 1);
        });

        calcRadioTotal();
    });

    $(document).on('input', '.radio-tariff-input, .radio-qty-input', function () {
        if (isHistoryMode) return;

        var $row = $(this).closest('tr');
        var tarif = parseFloat(String($row.find('.radio-tariff-input').val() || '0').replace(/\./g, '').replace(',', '.')) || 0;
        $row.find('.radio-tariff-display').text(fmt(tarif));

        calcRadioRowTotal($row);
        calcRadioTotal();
    });

    function calcRadioRowTotal($row) {
        var tarif = parseFloat(String($row.find('.radio-tariff-input').val() || '0').replace(/\./g, '').replace(',', '.')) || 0;
        var qty = parseFloat($row.find('.radio-qty-input').val()) || 0;
        var total = tarif * qty;

        $row.find('.radio-total-input').val(fmt(total));
        $row.data('total', total);
    }

    function calcRadioTotal() {
        var grand = 0;

        $('#radio-tbody tr').each(function () {
            var totalText = $(this).find('.radio-total-input').val();
            var total = parseFloat(String(totalText || '0').replace(/\./g, '').replace(',', '.')) || 0;

            if (total <= 0) {
                var tarif = parseFloat(String($(this).find('.radio-tariff-input').val() || '0').replace(/\./g, '').replace(',', '.')) || 0;
                var qty = parseFloat($(this).find('.radio-qty-input').val()) || 0;
                total = tarif * qty;
            }

            grand += total;
        });

        $('#radio-grand-total').text('Rp ' + fmt(grand));
    }

    var supportTimer = null;
    var $supportDD = $('#support-dropdown');
    var $activeSupportRow = null;

    $('#support-search-input, #btn-search-support').on('input click', function () {
        if (isHistoryMode) return;

        clearTimeout(supportTimer);
        var q = $.trim($('#support-search-input').val());
        $activeSupportRow = null;

        if (q.length < 2) {
            $supportDD.hide().empty();
            return;
        }

        $supportDD.html('<div class="support-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        positionSupportDD($('#support-search-input'));
        $supportDD.show();

        supportTimer = setTimeout(function () {
            fetchSupports(q, null);
        }, 250);
    });

    $(document).on('input', '.support-name-input', function () {
        if (isHistoryMode) return;

        clearTimeout(supportTimer);
        var q = $.trim($(this).val());
        $activeSupportRow = $(this).closest('tr');

        if (q.length < 2) {
            $supportDD.hide().empty();
            return;
        }

        $supportDD.html('<div class="support-loading"><i class="fa fa-spinner fa-spin"></i> Mencari...</div>');
        positionSupportDD($(this));
        $supportDD.show();

        supportTimer = setTimeout(function () {
            fetchSupports(q, $(this));
        }, 250);
    });

    function fetchSupports(q, $inp) {
        $.getJSON(CARI_PENUNJANG_URL, { q: q }, function (data) {
            renderSupportDD(data, $inp);
        }).fail(function () {
            $supportDD.html('<div class="support-empty" style="color:#a00;">Gagal memuat data penunjang.</div>').show();
        });
    }

    function renderSupportDD(data, $inp) {
        $supportDD.empty();

        if (!data || !data.length) {
            $supportDD.html('<div class="support-empty"><i class="fa fa-search"></i> Pemeriksaan penunjang tidak ditemukan</div>').show();
            return;
        }

        $.each(data, function (_, d) {
            var tarifHtml = d.tarif > 0 ? '<span class="support-price">Rp ' + fmt(d.tarif) + '</span>' : '<span style="color:#aaa;">-</span>';

            $('<div class="support-dd-item"></div>')
                .html('<div class="support-name">' + escHtml(d.nama)
                    + (d.kode ? ' <span style="font-size:10px;background:#e9ecef;padding:0 4px;border-radius:2px;font-family:monospace;">' + escHtml(d.kode) + '</span>' : '') + '</div>'
                    + '<div class="support-meta">' + (d.kategori ? 'Kategori: ' + escHtml(d.kategori) + ' · ' : '') + (d.unit ? 'Unit: ' + escHtml(d.unit) + ' · ' : '') + tarifHtml + '</div>')
                .data('support', d)
                .on('mousedown', function (e) {
                    e.preventDefault();

                    if ($activeSupportRow) {
                        fillSupportRow($activeSupportRow, d);
                    } else {
                        addSupportRow(d);
                    }

                    $supportDD.hide().empty();
                    $('#support-search-input').val('');
                    $activeSupportRow = null;
                })
                .appendTo($supportDD);
        });

        $supportDD.show();
    }

    function positionSupportDD($input) {
        if (!$input || !$input.length) return;

        var rect = $input[0].getBoundingClientRect();
        var width = $input.outerWidth();

        if (width < 420) width = 520;

        var left = rect.left;
        var top = rect.bottom + 2;

        if (left + width > $(window).width() - 20) {
            left = $(window).width() - width - 20;
        }

        if (left < 10) left = 10;

        $supportDD.css({ top: top, left: left, width: width });
    }

    $(window).on('scroll resize', function () {
        if ($supportDD.is(':visible')) {
            var $input = $activeSupportRow ? $activeSupportRow.find('.support-name-input') : $('#support-search-input');
            positionSupportDD($input);
        }
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#support-search-input, #support-dropdown, .support-name-input, #btn-search-support').length) {
            $supportDD.hide();
        }
    });

    $('#btn-add-support-row').on('click', function () {
        if (isHistoryMode) return;
        addSupportRow(null);
    });

    $('#btn-clear-support').on('click', function () {
        if (isHistoryMode) return;
        $('#support-tbody').empty();
        supportRowIndex = 0;
        calcSupportTotal();
    });

    function addSupportRow(support) {
        var i = supportRowIndex++;
        var d = support || {};
        var tarif = parseFloat(d.tarif) || 0;
        var qty = 1;
        var total = tarif * qty;

        var html = '<tr class="support-row" data-i="' + i + '">'
            + '<td style="text-align:center; color:#777; font-size:10px;">' + supportRowIndex + '</td>'
            + '<td><input type="text" name="supports[' + i + '][support_code]" class="form-control support-code-input" value="' + escHtml(d.kode || '') + '" style="font-family:monospace; font-size:10px;" placeholder="Kode"></td>'
            + '<td><input type="text" name="supports[' + i + '][support_name]" class="form-control support-name-input" value="' + escHtml(d.nama || '') + '" placeholder="Nama pemeriksaan..." autocomplete="off"></td>'
            + '<td><input type="text" name="supports[' + i + '][tariff]" class="form-control support-tariff-input" value="' + tarif + '" style="text-align:right;"><span class="support-tariff-display" style="display:block; font-size:10px; text-align:right; color:#888;">' + fmt(tarif) + '</span></td>'
            + '<td><input type="text" name="supports[' + i + '][unit]" class="form-control support-unit-input" value="' + escHtml(d.unit || '') + '" placeholder="Unit"></td>'
            + '<td><input type="number" name="supports[' + i + '][qty]" class="form-control support-qty-input" value="1" min="1" step="1" style="text-align:center;"></td>'
            + '<td><input type="text" name="supports[' + i + '][total]" class="form-control support-total-input" value="' + fmt(total) + '" readonly style="text-align:right; background:#f5f5f5; font-weight:600;"></td>'
            + '<td><input type="text" name="supports[' + i + '][approval_note]" class="form-control" placeholder="Keterangan approval..."></td>'
            + '<td style="text-align:center;"><button type="button" class="btn btn-xs btn-danger btn-remove-support">&times;</button></td>'
            + '</tr>';

        $('#support-tbody').append(html);
        calcSupportTotal();

        if (!support) {
            $('#support-tbody tr:last').find('.support-name-input').focus();
        }
    }

    function addSupportHistoryRow(support, i) {
        var tarif = parseFloat(support.tarif || 0);
        var qty = parseFloat(support.qty || 1);
        var total = parseFloat(support.total || (tarif * qty));

        var html = '<tr class="history-readonly-row support-row">'
            + '<td style="text-align:center; color:#aaa; font-size:10px;">' + (i + 1) + '</td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(support.kode || '') + '" readonly></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(support.nama || '') + '" readonly></td>'
            + '<td><input type="text" class="form-control support-tariff-input" value="' + tarif + '" readonly style="text-align:right;"></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(support.unit || '') + '" readonly></td>'
            + '<td><input type="text" class="form-control support-qty-input" value="' + qty + '" readonly style="text-align:center;"></td>'
            + '<td><input type="text" class="form-control support-total-input" value="' + fmt(total) + '" readonly style="text-align:right;font-weight:600;"></td>'
            + '<td><input type="text" class="form-control" value="' + escHtml(support.approval || '') + '" readonly></td>'
            + '<td></td>'
            + '</tr>';

        $('#support-tbody').append(html);
    }

    function fillSupportRow($row, support) {
        $row.find('.support-code-input').val(support.kode || '');
        $row.find('.support-name-input').val(support.nama || '');
        $row.find('.support-unit-input').val(support.unit || '');

        var tarif = parseFloat(support.tarif) || 0;

        $row.find('.support-tariff-input').val(tarif);
        $row.find('.support-tariff-display').text(fmt(tarif));

        calcSupportRowTotal($row);
        calcSupportTotal();
    }

    $(document).on('click', '.btn-remove-support', function () {
        if (isHistoryMode) return;

        $(this).closest('tr').remove();

        $('#support-tbody tr').each(function (idx) {
            $(this).find('td:first').text(idx + 1);
        });

        calcSupportTotal();
    });

    $(document).on('input', '.support-tariff-input, .support-qty-input', function () {
        if (isHistoryMode) return;

        var $row = $(this).closest('tr');
        var tarif = parseFloat(String($row.find('.support-tariff-input').val() || '0').replace(/\./g, '').replace(',', '.')) || 0;
        $row.find('.support-tariff-display').text(fmt(tarif));

        calcSupportRowTotal($row);
        calcSupportTotal();
    });

    function calcSupportRowTotal($row) {
        var tarif = parseFloat(String($row.find('.support-tariff-input').val() || '0').replace(/\./g, '').replace(',', '.')) || 0;
        var qty = parseFloat($row.find('.support-qty-input').val()) || 0;
        var total = tarif * qty;

        $row.find('.support-total-input').val(fmt(total));
        $row.data('total', total);
    }

    function calcSupportTotal() {
        var grand = 0;

        $('#support-tbody tr').each(function () {
            var totalText = $(this).find('.support-total-input').val();
            var total = parseFloat(String(totalText || '0').replace(/\./g, '').replace(',', '.')) || 0;

            if (total <= 0) {
                var tarif = parseFloat(String($(this).find('.support-tariff-input').val() || '0').replace(/\./g, '').replace(',', '.')) || 0;
                var qty = parseFloat($(this).find('.support-qty-input').val()) || 0;
                total = tarif * qty;
            }

            grand += total;
        });

        $('#support-grand-total').text('Rp ' + fmt(grand));
    }






    var selectedMcuType = null;
    var mcuTypeSearchTimer = null;

    $('#btn-open-mcu-type-modal, #mcu-type-display').on('click', function () {
        if (isHistoryMode) return;

        selectedMcuType = null;
        $('#mcu-type-modal-search').val('');
        $('#mcu-type-modal-tbody').html('<tr><td colspan="4" class="mcu-type-empty"><i class="fa fa-spinner fa-spin"></i> Memuat jenis MCU...</td></tr>');
        $('#modal-jenis-mcu').modal('show');

        setTimeout(function () {
            $('#mcu-type-modal-search').focus();
            searchMcuTypes('');
        }, 350);
    });

    $('#btn-search-mcu-type').on('click', function () {
        searchMcuTypes($('#mcu-type-modal-search').val());
    });

    $('#mcu-type-modal-search').on('input', function () {
        clearTimeout(mcuTypeSearchTimer);
        var q = $.trim($(this).val());

        mcuTypeSearchTimer = setTimeout(function () {
            searchMcuTypes(q);
        }, 250);
    });

    function searchMcuTypes(q) {
        $('#mcu-type-modal-tbody').html('<tr><td colspan="4" class="mcu-type-empty"><i class="fa fa-spinner fa-spin"></i> Memuat jenis MCU...</td></tr>');

        $.getJSON(CARI_JENIS_MCU_URL, { q: q }, function (rows) {
            renderMcuTypeRows(rows || []);
        }).fail(function () {
            $('#mcu-type-modal-tbody').html('<tr><td colspan="4" class="mcu-type-empty" style="color:#a00;">Gagal memuat jenis MCU.</td></tr>');
        });
    }

    function renderMcuTypeRows(rows) {
        if (!rows.length) {
            $('#mcu-type-modal-tbody').html('<tr><td colspan="4" class="mcu-type-empty">Jenis MCU tidak ditemukan.</td></tr>');
            return;
        }

        var html = '';

        $.each(rows, function (_, row) {
            html += '<tr class="mcu-type-row"'
                + ' data-id="' + escHtml(row.id || '') + '"'
                + ' data-kode="' + escHtml(row.kode || '') + '"'
                + ' data-nama="' + escHtml(row.nama || '') + '"'
                + ' data-description="' + escHtml(row.description || '') + '">'
                + '<td class="text-center"><input type="checkbox" class="mcu-type-check"></td>'
                + '<td><span class="mcu-type-code">' + escHtml(row.kode || '') + '</span></td>'
                + '<td>' + escHtml(row.nama || '') + '</td>'
                + '<td>' + escHtml(row.description || '') + '</td>'
                + '</tr>';
        });

        $('#mcu-type-modal-tbody').html(html);
    }

    $(document).on('click', '.mcu-type-row', function () {
        $('.mcu-type-row').removeClass('mcu-type-active');
        $('.mcu-type-check').prop('checked', false);

        $(this).addClass('mcu-type-active');
        $(this).find('.mcu-type-check').prop('checked', true);

        selectedMcuType = {
            id: $(this).data('id'),
            kode: $(this).data('kode'),
            nama: $(this).data('nama'),
            description: $(this).data('description')
        };
    });

    $(document).on('dblclick', '.mcu-type-row', function () {
        $(this).trigger('click');
        chooseMcuType();
    });

    $('#btn-mcu-type-ok').on('click', function () {
        chooseMcuType();
    });

    function chooseMcuType() {
        if (!selectedMcuType) {
            alert('Pilih jenis MCU terlebih dahulu.');
            return;
        }

        $('#mcu-type').val(selectedMcuType.nama || '');
        $('#mcu-type-display').val(selectedMcuType.nama || '');

        $('#modal-jenis-mcu').modal('hide');
    }

    function clearMcuForm() {
        $('#mcu-type').val('');
        $('#mcu-type-display').val('');
        $('#mcu-notes').val('');
    }



    var selectedGiziMaster = null;
    var giziTarget = { period: '', field: '', type: '' };

    $('.btn-open-gizi-modal').on('click', function () {
        if (isHistoryMode) return;

        giziTarget.period = String($(this).data('target-period') || '');
        giziTarget.field = String($(this).data('target-field') || 'menu');
        giziTarget.type = String($(this).data('target-type') || 'menu');
        selectedGiziMaster = null;

        $('#gizi-modal-search').val('');
        $('#gizi-master-tbody').html('<tr><td colspan="6" class="gizi-master-empty"><i class="fa fa-spinner fa-spin"></i> Memuat data gizi...</td></tr>');
        $('#modal-gizi-master').modal('show');
        searchGiziMaster('');

        setTimeout(function () { $('#gizi-modal-search').focus(); }, 300);
    });

    $('#btn-search-gizi-master').on('click', function () {
        searchGiziMaster($('#gizi-modal-search').val());
    });

    var giziSearchTimer = null;
    $('#gizi-modal-search').on('input', function () {
        clearTimeout(giziSearchTimer);
        var q = $(this).val();
        giziSearchTimer = setTimeout(function () {
            searchGiziMaster(q);
        }, 250);
    });

    $('#gizi-modal-search').on('keyup', function (e) {
        if (e.keyCode === 13) {
            searchGiziMaster($(this).val());
        }
    });

    function searchGiziMaster(q) {
        $('#gizi-master-tbody').html('<tr><td colspan="6" class="gizi-master-empty"><i class="fa fa-spinner fa-spin"></i> Memuat data gizi...</td></tr>');

        $.getJSON(CARI_NUTRITION_COMBINE_URL, { q: q, mode: giziTarget.type }, function (rows) {
            renderGiziMasterRows(rows || []);
        }).fail(function () {
            $('#gizi-master-tbody').html('<tr><td colspan="6" class="gizi-master-empty" style="color:#a00;">Gagal memuat master gizi.</td></tr>');
        });
    }

    function renderGiziMasterRows(rows) {
        if (!rows.length) {
            $('#gizi-master-tbody').html('<tr><td colspan="6" class="gizi-master-empty">Data gizi tidak ditemukan.</td></tr>');
            return;
        }

        var html = '';
        $.each(rows, function (_, row) {
            html += '<tr class="gizi-master-row"'
                + ' data-code="' + escHtml(row.code || '') + '"'
                + ' data-name="' + escHtml(row.name || '') + '"'
                + ' data-content="' + escHtml(row.nutrition_content || '') + '"'
                + ' data-value="' + escHtml(row.nutritional_value || '') + '"'
                + ' data-unit="' + escHtml(row.content_unit || '') + '"'
                + ' data-energy="' + escHtml(row.energy || 0) + '"'
                + ' data-protein="' + escHtml(row.protein || 0) + '"'
                + ' data-fat="' + escHtml(row.fat || 0) + '"'
                + ' data-carbohydrate="' + escHtml(row.carbohydrate || 0) + '">'
                + '<td class="text-center"><input type="checkbox" class="gizi-master-check"></td>'
                + '<td><strong class="mono">' + escHtml(row.code || '') + '</strong></td>'
                + '<td>' + escHtml(row.name || '') + '</td>'
                + '<td>' + escHtml(row.nutrition_content || '') + '</td>'
                + '<td style="text-align:right;">' + escHtml(row.nutritional_value || '') + '</td>'
                + '<td>' + escHtml(row.content_unit || '') + '</td>'
                + '</tr>';
        });
        $('#gizi-master-tbody').html(html);
    }

    $(document).on('click', '.gizi-master-row', function () {
        $('.gizi-master-row').removeClass('gizi-master-active');
        $('.gizi-master-check').prop('checked', false);
        $(this).addClass('gizi-master-active');
        $(this).find('.gizi-master-check').prop('checked', true);

        selectedGiziMaster = {
            code: $(this).data('code') || '',
            name: $(this).data('name') || '',
            content: $(this).data('content') || '',
            value: $(this).data('value') || '',
            unit: $(this).data('unit') || '',
            energy: $(this).data('energy') || 0,
            protein: $(this).data('protein') || 0,
            fat: $(this).data('fat') || 0,
            carbohydrate: $(this).data('carbohydrate') || 0
        };
    });

    $(document).on('dblclick', '.gizi-master-row', function () {
        $(this).trigger('click');
        chooseGiziMaster();
    });

    $('#btn-gizi-master-ok').on('click', function () {
        chooseGiziMaster();
    });

    function chooseGiziMaster() {
        if (!selectedGiziMaster) {
            alert('Pilih data gizi terlebih dahulu.');
            return;
        }

        var period = giziTarget.period;
        if (!period) return;

        if (giziTarget.type === 'menu') {
            $('#gizi-' + period + '-menu-code').val(selectedGiziMaster.code);
            $('#gizi-' + period + '-menu-name').val(selectedGiziMaster.name);
            $('#gizi-' + period + '-energy').val(selectedGiziMaster.energy || 0);
            $('#gizi-' + period + '-protein').val(selectedGiziMaster.protein || 0);
            $('#gizi-' + period + '-fat').val(selectedGiziMaster.fat || 0);
            $('#gizi-' + period + '-carbohydrate').val(selectedGiziMaster.carbohydrate || 0);
        } else {
            $('#gizi-' + period + '-' + giziTarget.field).val(selectedGiziMaster.name);
        }

        var content = String(selectedGiziMaster.content || '').toLowerCase();
        if (content.indexOf('energi') !== -1) $('#gizi-' + period + '-energy').val(selectedGiziMaster.value || 0);
        if (content.indexOf('protein') !== -1) $('#gizi-' + period + '-protein').val(selectedGiziMaster.value || 0);
        if (content.indexOf('lemak') !== -1) $('#gizi-' + period + '-fat').val(selectedGiziMaster.value || 0);
        if (content.indexOf('karbo') !== -1) $('#gizi-' + period + '-carbohydrate').val(selectedGiziMaster.value || 0);

        $('#modal-gizi-master').modal('hide');
    }

    var selectedOperation = null;
    var operationSearchTimer = null;

    $('#btn-open-operation-modal, #surgery-operation-type').on('click', function () {
        if (isHistoryMode) return;

        selectedOperation = null;
        $('#operation-modal-search').val('');
        $('#operation-selected-tbody').html('<tr><td colspan="2" class="operation-empty">Belum ada tindakan dipilih.</td></tr>');
        $('#operation-modal-tbody').html('<tr><td colspan="7" class="operation-empty">Ketik pencarian atau klik tombol cari.</td></tr>');
        $('#modal-jenis-operasi').modal('show');

        setTimeout(function () {
            $('#operation-modal-search').focus();
            searchOperationTypes('');
        }, 350);
    });

    $('#operation-modal-search').on('input', function () {
        clearTimeout(operationSearchTimer);
        var q = $.trim($(this).val());

        operationSearchTimer = setTimeout(function () {
            searchOperationTypes(q);
        }, 250);
    });

    function searchOperationTypes(q) {
        $('#operation-modal-tbody').html('<tr><td colspan="7" class="operation-empty"><i class="fa fa-spinner fa-spin"></i> Memuat jenis operasi...</td></tr>');

        $.getJSON(CARI_JENIS_OPERASI_URL, { q: q }, function (rows) {
            renderOperationRows(rows || []);
        }).fail(function () {
            $('#operation-modal-tbody').html('<tr><td colspan="7" class="operation-empty" style="color:#a00;">Gagal memuat jenis operasi.</td></tr>');
        });
    }

    function renderOperationRows(rows) {
        if (!rows.length) {
            $('#operation-modal-tbody').html('<tr><td colspan="7" class="operation-empty">Jenis operasi tidak ditemukan.</td></tr>');
            return;
        }

        var html = '';

        $.each(rows, function (_, row) {
            html += '<tr class="operation-row"'
                + ' data-id="' + escHtml(row.id || '') + '"'
                + ' data-kode="' + escHtml(row.kode || '') + '"'
                + ' data-nama="' + escHtml(row.nama || '') + '"'
                + ' data-tarif="' + (parseFloat(row.tarif || 0)) + '"'
                + ' data-jasa-rs="' + (parseFloat(row.jasa_rs || 0)) + '"'
                + ' data-jasa-dr="' + (parseFloat(row.jasa_dr || 0)) + '"'
                + ' data-jasa-paramedis="' + (parseFloat(row.jasa_paramedis || 0)) + '"'
                + ' data-unit="' + escHtml(row.unit || '') + '">'
                + '<td class="text-center"><input type="checkbox" class="operation-check"></td>'
                + '<td><strong class="mono">' + escHtml(row.kode || '') + '</strong></td>'
                + '<td>' + escHtml(row.nama || '') + '</td>'
                + '<td class="operation-money">' + fmt(row.jasa_rs || 0) + '</td>'
                + '<td class="operation-money">' + fmt(row.jasa_dr || 0) + '</td>'
                + '<td class="operation-money">' + fmt(row.jasa_paramedis || 0) + '</td>'
                + '<td class="operation-money"><strong>' + fmt(row.tarif || 0) + '</strong></td>'
                + '</tr>';
        });

        $('#operation-modal-tbody').html(html);
    }

    $(document).on('click', '.operation-row', function () {
        $('.operation-row').removeClass('operation-active');
        $('.operation-check').prop('checked', false);

        $(this).addClass('operation-active');
        $(this).find('.operation-check').prop('checked', true);

        selectedOperation = {
            id: $(this).data('id'),
            kode: $(this).data('kode'),
            nama: $(this).data('nama'),
            tarif: parseFloat($(this).data('tarif')) || 0,
            jasa_rs: parseFloat($(this).data('jasa-rs')) || 0,
            jasa_dr: parseFloat($(this).data('jasa-dr')) || 0,
            jasa_paramedis: parseFloat($(this).data('jasa-paramedis')) || 0,
            unit: $(this).data('unit') || '',
            energy: $(this).data('energy') || 0,
            protein: $(this).data('protein') || 0,
            fat: $(this).data('fat') || 0,
            carbohydrate: $(this).data('carbohydrate') || 0
        };

        $('#operation-selected-tbody').html(
            '<tr><td><strong class="mono">' + escHtml(selectedOperation.kode) + '</strong></td>'
            + '<td>' + escHtml(selectedOperation.nama) + '</td></tr>'
        );
    });

    $(document).on('dblclick', '.operation-row', function () {
        $(this).trigger('click');
        chooseOperationType();
    });

    $('#btn-operation-ok').on('click', function () {
        chooseOperationType();
    });

    function chooseOperationType() {
        if (!selectedOperation) {
            alert('Pilih jenis operasi terlebih dahulu.');
            return;
        }

        $('#surgery-operation-type-id').val(selectedOperation.id);
        $('#surgery-code').val(selectedOperation.kode);
        $('#surgery-name').val(selectedOperation.nama);
        $('#surgery-operation-type').val(selectedOperation.nama);
        $('#surgery-tariff').val(selectedOperation.tarif);
        $('#surgery-jasa-rs').val(selectedOperation.jasa_rs);
        $('#surgery-jasa-dr').val(selectedOperation.jasa_dr);
        $('#surgery-jasa-paramedis').val(selectedOperation.jasa_paramedis);
        $('#surgery-unit').val(selectedOperation.unit);

        $('#surgery-approved-operation-type').val(selectedOperation.nama);

        $('#modal-jenis-operasi').modal('hide');
    }


    function closeOperatorDropdown() {
        $('#operator-combo-dropdown').hide();
    }

    function openOperatorDropdown() {
        if (isHistoryMode) return;

        $('#operator-combo-dropdown').show();
        $('#operator-combo-search').val('').focus();
        filterOperatorRows('');
    }

    function setOperatorValue(id, name, code) {
        id = id || '';
        name = name || '';
        code = code || '';

        $('#surgery-operator').val(id);
        $('#surgery-operator-name').val(name);

        if (id) {
            $('#operator-combo-text').text(name + (code ? '   ' + code : ''));
        } else {
            $('#operator-combo-text').text('-- Pilih Operator / Dokter --');
        }

        $('.operator-option-row').removeClass('operator-active');
        if (id) {
            $('.operator-option-row[data-id="' + id + '"]').addClass('operator-active');
        }
    }

    function filterOperatorRows(q) {
        q = $.trim(String(q || '').toLowerCase());

        var shown = 0;

        $('.operator-option-row').each(function () {
            var search = String($(this).data('search') || '');

            if (q === '' || search.indexOf(q) !== -1) {
                $(this).show();
                shown++;
            } else {
                $(this).hide();
            }
        });

        $('#operator-combo-tbody .operator-empty-filter').remove();

        if (shown === 0) {
            $('#operator-combo-tbody').append(
                '<tr class="operator-empty-filter"><td colspan="2" class="operator-empty">Dokter tidak ditemukan.</td></tr>'
            );
        }
    }

    $('#operator-combo-toggle').on('click', function (e) {
        e.preventDefault();

        if ($('#operator-combo-dropdown').is(':visible')) {
            closeOperatorDropdown();
        } else {
            openOperatorDropdown();
        }
    });

    $('#operator-combo-search').on('input', function () {
        filterOperatorRows($(this).val());
    });

    $(document).on('mousedown', '.operator-option-row', function (e) {
        e.preventDefault();

        setOperatorValue(
            String($(this).data('id') || ''),
            String($(this).data('name') || ''),
            String($(this).data('code') || '')
        );

        closeOperatorDropdown();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#operator-combo').length) {
            closeOperatorDropdown();
        }
    });

    $('#form-order').on('submit', function () {
        if (!$('#surgery-operator').val()) {
            $('#surgery-operator-name').val('');
        }
    });

    function clearSurgeryForm() {
        $('#surgery-date').val('<?= date('Y-m-d') ?>');
        $('#surgery-time').val('<?= date('H:i') ?>');
        setOperatorValue('', '', '');
        $('#surgery-operation-type-id').val('');
        $('#surgery-code').val('');
        $('#surgery-name').val('');
        $('#surgery-operation-type').val('');
        $('#surgery-tariff').val('');
        $('#surgery-jasa-rs').val('');
        $('#surgery-jasa-dr').val('');
        $('#surgery-jasa-paramedis').val('');
        $('#surgery-unit').val('');
        $('#surgery-notes').val('');
        $('#surgery-approval-queue-no').val('');
        $('#surgery-approval-date').val('');
        $('#surgery-approval-time').val('');
        $('#surgery-operating-room').val('');
        $('#surgery-approved-operator').val('');
        $('#surgery-approved-operation-type').val('');
        $('#surgery-anesthesia-type').val('');
        $('#surgery-approved-by').val('<?= h($createdByName ?? 'Admin') ?>');
    }

    function fillSurgeryForm(surgery) {
        if (!surgery) {
            clearSurgeryForm();
            return;
        }

        $('#surgery-date').val(surgery.surgery_date || '');
        $('#surgery-time').val(surgery.surgery_time || '');
        var surgeryOperatorId = surgery.operator_id || surgery.doctor_id || '';
        var surgeryOperatorName = surgery.operator_name || '';
        var $surgeryOperatorRow = $('.operator-option-row[data-id="' + surgeryOperatorId + '"]');

        if ($surgeryOperatorRow.length) {
            setOperatorValue(
                surgeryOperatorId,
                String($surgeryOperatorRow.data('name') || surgeryOperatorName),
                String($surgeryOperatorRow.data('code') || '')
            );
        } else {
            setOperatorValue(surgeryOperatorId, surgeryOperatorName, '');
        }
        $('#surgery-operation-type-id').val(surgery.operation_type_id || '');
        $('#surgery-code').val(surgery.surgery_code || '');
        $('#surgery-name').val(surgery.surgery_name || surgery.operation_type || '');
        $('#surgery-operation-type').val(surgery.operation_type || surgery.surgery_name || '');
        $('#surgery-tariff').val(surgery.tariff || '');
        $('#surgery-jasa-rs').val(surgery.jasa_rs || '');
        $('#surgery-jasa-dr').val(surgery.jasa_dr || '');
        $('#surgery-jasa-paramedis').val(surgery.jasa_paramedis || '');
        $('#surgery-unit').val(surgery.unit || '');
        $('#surgery-notes').val(surgery.notes || '');
        $('#surgery-approval-queue-no').val(surgery.approval_queue_no || '');
        $('#surgery-approval-date').val(surgery.approval_date || '');
        $('#surgery-approval-time').val(surgery.approval_time || '');
        $('#surgery-operating-room').val(surgery.operating_room || '');
        $('#surgery-approved-operator').val(surgery.approved_operator || '');
        $('#surgery-approved-operation-type').val(surgery.approved_operation_type || '');
        $('#surgery-anesthesia-type').val(surgery.anesthesia_type || '');
        $('#surgery-approved-by').val(surgery.approved_by || '');
    }


    /*
     * Diet bertingkat:
     * Diet 1 selalu aktif.
     * Diet 2 baru aktif setelah Diet 1 dipilih.
     * Diet 3 baru aktif setelah Diet 2 dipilih.
     */
    function setNativeSelectEmptyText($select, text) {
        var $emptyOption = $select.find('option[value=""]').first();

        if (!$emptyOption.length) {
            $select.prepend('<option value=""></option>');
            $emptyOption = $select.find('option[value=""]').first();
        }

        $emptyOption.text(text);
        $emptyOption.html(text);
        $emptyOption.attr('label', text);

        if (!$select.val()) {
            $emptyOption.prop('selected', true);
            $select.prop('selectedIndex', 0);
        }

        $select.attr('data-placeholder', text);
    }

    function lockNativeDiet($select) {
        setNativeSelectEmptyText($select, '');
        $select.val('');
        $select.prop('selectedIndex', 0);
        $select.prop('disabled', true);
        $select.addClass('gizi-diet-locked').removeClass('gizi-diet-open');

        if ($.fn.select2 && $select.data('select2')) {
            $select.trigger('change.select2');
        }
    }

    function unlockNativeDiet($select) {
        $select.prop('disabled', false);
        setNativeSelectEmptyText($select, '-- Pilih Diet --');
        $select.addClass('gizi-diet-open').removeClass('gizi-diet-locked');

        if (!$select.val()) {
            $select.val('');
            $select.prop('selectedIndex', 0);
        }

        if ($.fn.select2 && $select.data('select2')) {
            $select.trigger('change.select2');
        }
    }

    function refreshGiziDietStep(period) {
        var $diet1 = $('#gizi-' + period + '-diet-1');
        var $diet2 = $('#gizi-' + period + '-diet-2');
        var $diet3 = $('#gizi-' + period + '-diet-3');

        if (!$diet1.length || !$diet2.length || !$diet3.length) {
            return;
        }

        $diet1.addClass('gizi-diet-open').removeClass('gizi-diet-locked');

        if ($diet1.val()) {
            unlockNativeDiet($diet2);
        } else {
            lockNativeDiet($diet2);
            lockNativeDiet($diet3);
            return;
        }

        if ($diet2.val()) {
            unlockNativeDiet($diet3);
        } else {
            lockNativeDiet($diet3);
        }
    }

    function initGiziDietStep(period) {
        refreshGiziDietStep(period);

        $(document).off('change.giziDietStep-' + period, '#gizi-' + period + '-diet-1, #gizi-' + period + '-diet-2');
        $(document).on('change.giziDietStep-' + period, '#gizi-' + period + '-diet-1, #gizi-' + period + '-diet-2', function () {
            refreshGiziDietStep(period);
        });
    }

    initGiziDietStep('morning');
    initGiziDietStep('lunch');
    initGiziDietStep('night');

    /*
     * Cadangan untuk browser lama / plugin select yang tidak memicu event change normal.
     * Saat user memilih Diet 1, maksimal 0.2 detik kemudian Diet 2 akan aktif,
     * background berubah putih, dan placeholder "-- Pilih Diet --" muncul.
     */
    setTimeout(function () {
        refreshGiziDietStep('morning');
        refreshGiziDietStep('lunch');
        refreshGiziDietStep('night');
    }, 200);


});
</script>