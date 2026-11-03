<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicine $medicine
 * @var string $createdByName
 */

$inventoryCategories = [
    'FARMASI / OBAT' => 'FARMASI / OBAT',
    'ALKES' => 'ALKES',
    'BMHP' => 'BMHP',
    'VITAMIN' => 'VITAMIN',
    'ANTIBIOTIK' => 'ANTIBIOTIK',
    'ANALGESIK' => 'ANALGESIK',
    'OBAT BATUK' => 'OBAT BATUK',
    'OBAT LAMBUNG' => 'OBAT LAMBUNG',
    'SALEP / KRIM' => 'SALEP / KRIM',
];

$units = [
    'TABLET' => 'TABLET',
    'KAPSUL' => 'KAPSUL',
    'BOTOL' => 'BOTOL',
    'BOX' => 'BOX',
    'STRIP' => 'STRIP',
    'PCS' => 'PCS',
    'TUBE' => 'TUBE',
    'AMPUL' => 'AMPUL',
    'VIAL' => 'VIAL',
    'SACHET' => 'SACHET',
    'ML' => 'ML',
];

$kelasTerapi = [
    'GENERIK' => 'GENERIK',
    'NON GENERIK' => 'NON GENERIK',
    'FORMULARIUM' => 'FORMULARIUM',
    'NON FORMULARIUM' => 'NON FORMULARIUM',
];

$depkesOptions = [
    'OBAT GENERIC FORMULARIUM' => 'Obat Generic Formularium',
    'OBAT GENERIC NON FORMULARIUM' => 'Obat Generic Non Formularium',
    'OBAT NON GENERIC FORMULARIUM' => 'Obat Non Generic Formularium',
    'OBAT NON GENERIC NON FORMULARIUM' => 'Obat Non Generic Non Formularium',
];
?>

<div class="medicine-page">

    <?= $this->Form->create($medicine, ['id' => 'form-medicine']) ?>

    <div class="emr-window">
        <div class="emr-titlebar">
            <div>Master Data Obat</div>
            <div>
                <?= $this->Html->link('KEMBALI', ['action' => 'index'], ['class' => 'btn btn-xs btn-light']) ?>
            </div>
        </div>

        <div class="emr-body">
            <div class="row">

                <div class="col-md-6 medicine-left">
                    <div class="medicine-card">
                        <h5 class="section-title">Data Obat</h5>

                        <div class="form-row-line">
                            <label>Kode Obat</label>
                            <?= $this->Form->control('code', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'value' => 'AUTO',
                                'readonly' => true,
                            ]) ?>

                            <label class="check-label">
                                <?= $this->Form->checkbox('is_active', [
                                    'hiddenField' => 'N',
                                    'value' => 'Y',
                                    'checked' => true,
                                ]) ?>
                                Aktif
                            </label>
                        </div>

                        <div class="form-row-line">
                            <label>Nama Obat</label>
                            <?= $this->Form->control('name', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Nama obat',
                            ]) ?>
                            <button type="button" class="btn btn-default btn-sm btn-mims">MIMS</button>
                        </div>

                        <div class="form-row-line">
                            <label>Nama Generic</label>
                            <?= $this->Form->control('generic_name', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Nama generic',
                            ]) ?>
                        </div>

                        <div class="form-row-line">
                            <label>Kategori Inventory</label>
                            <?= $this->Form->control('inventory_category', [
                                'label' => false,
                                'type' => 'select',
                                'options' => $inventoryCategories,
                                'empty' => '-- Pilih Kategori --',
                                'class' => 'form-control input-sm',
                            ]) ?>
                        </div>

                        <div class="unit-row">
                            <label>Satuan 1</label>
                            <?= $this->Form->control('unit_1', [
                                'label' => false,
                                'type' => 'select',
                                'options' => $units,
                                'empty' => '-- Satuan --',
                                'class' => 'form-control input-sm',
                                'id' => 'unit-1',
                            ]) ?>
                            <span class="unit-default">Default</span>
                        </div>

                        <div class="unit-row">
                            <label>Satuan 2</label>
                            <?= $this->Form->control('unit_2', [
                                'label' => false,
                                'type' => 'select',
                                'options' => $units,
                                'empty' => '-- Satuan --',
                                'class' => 'form-control input-sm',
                            ]) ?>
                            <?= $this->Form->control('unit_2_qty', [
                                'label' => false,
                                'type' => 'number',
                                'value' => 10,
                                'class' => 'form-control input-sm qty-mini',
                            ]) ?>
                            <span class="unit-follow">/ <span class="label-unit-1">SATUAN</span></span>
                        </div>

                        <div class="unit-row">
                            <label>Satuan 3</label>
                            <?= $this->Form->control('unit_3', [
                                'label' => false,
                                'type' => 'select',
                                'options' => $units,
                                'empty' => '-- Satuan --',
                                'class' => 'form-control input-sm',
                            ]) ?>
                            <?= $this->Form->control('unit_3_qty', [
                                'label' => false,
                                'type' => 'number',
                                'value' => 100,
                                'class' => 'form-control input-sm qty-mini',
                            ]) ?>
                            <span class="unit-follow">/ <span class="label-unit-1">SATUAN</span></span>
                        </div>

                        <div class="price-space"></div>

                        <div class="form-row-line">
                            <label>HNA</label>
                            <?= $this->Form->control('hna', [
                                'label' => false,
                                'class' => 'form-control input-sm price-input',
                                'placeholder' => '0',
                            ]) ?>
                            <span class="unit-follow">/ <span class="label-unit-1">SATUAN</span></span>
                        </div>

                        <div class="form-row-line">
                            <label></label>
                            <label class="check-label long">
                                <?= $this->Form->checkbox('ppn_status', [
                                    'hiddenField' => 'N',
                                    'value' => 'Y',
                                    'checked' => true,
                                ]) ?>
                                Tidak Dikenakan PPN
                            </label>
                        </div>

                        <div class="form-row-line">
                            <label>HNA + PPN</label>
                            <?= $this->Form->control('hna_ppn', [
                                'label' => false,
                                'class' => 'form-control input-sm price-input',
                                'placeholder' => '0',
                            ]) ?>
                            <span class="unit-follow"><span class="label-unit-1">SATUAN</span></span>
                        </div>

                        <div class="form-row-line">
                            <label>Jenis Harga</label>
                            <div class="radio-box-inline">
                                <?= $this->Form->radio(
                                    'jenis_harga',
                                    [
                                        'PROSENTASE' => 'Prosentase',
                                        'MANUAL' => 'Manual',
                                    ],
                                    [
                                        'value' => 'PROSENTASE',
                                        'legend' => false,
                                    ]
                                ) ?>
                            </div>
                        </div>

                        <div class="form-row-line">
                            <label>Harga Jual</label>
                            <?= $this->Form->control('harga_jual', [
                                'label' => false,
                                'class' => 'form-control input-sm price-input',
                                'placeholder' => '0',
                            ]) ?>
                            <span class="unit-follow">/ <span class="label-unit-1">SATUAN</span></span>
                        </div>

                        <div class="form-row-line">
                            <label>Harga Jual Jaminan</label>
                            <?= $this->Form->control('harga_jual_jaminan', [
                                'label' => false,
                                'class' => 'form-control input-sm price-input',
                                'placeholder' => '0',
                            ]) ?>
                            <span class="unit-follow">/ <span class="label-unit-1">SATUAN</span></span>
                        </div>

                        <div class="form-row-line">
                            <label>Nilai Persediaan Satuan</label>
                            <?= $this->Form->control('nilai_persediaan_satuan', [
                                'label' => false,
                                'class' => 'form-control input-sm price-input',
                                'placeholder' => '0',
                            ]) ?>
                            <span class="unit-follow">/ <span class="label-unit-1">SATUAN</span></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 medicine-right">
                    <div class="medicine-card">
                        <h5 class="section-title">Informasi Farmasi</h5>

                        <div class="form-row-line">
                            <label>Gol</label>
                            <?= $this->Form->control('gol', [
                                'label' => false,
                                'type' => 'select',
                                'options' => $kelasTerapi,
                                'empty' => '-- Pilih Gol --',
                                'class' => 'form-control input-sm',
                            ]) ?>
                        </div>

                        <div class="form-row-line">
                            <label>Kelas Terapi</label>
                            <?= $this->Form->control('therapy_class', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Kelas terapi',
                            ]) ?>
                        </div>

                        <div class="form-row-line">
                            <label>Golongan</label>
                            <?= $this->Form->control('golongan', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Golongan obat',
                            ]) ?>
                        </div>

                        <div class="form-row-line">
                            <label>Pabrik</label>
                            <?= $this->Form->control('pabrik', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Pabrik',
                            ]) ?>
                        </div>

                        <div class="form-row-line">
                            <label>Sediaan</label>
                            <?= $this->Form->control('sediaan', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Sediaan',
                            ]) ?>
                        </div>

                        <div class="form-row-line">
                            <label>Jenis</label>
                            <?= $this->Form->control('type', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Jenis obat',
                            ]) ?>
                        </div>

                        <div class="form-row-line">
                            <label>Supplier</label>
                            <?= $this->Form->control('supplier', [
                                'label' => false,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Supplier',
                            ]) ?>
                        </div>

                        <div class="form-row-line">
                            <label>Lead Time</label>
                            <?= $this->Form->control('lead_time', [
                                'label' => false,
                                'type' => 'number',
                                'value' => 0,
                                'class' => 'form-control input-sm lead-input',
                            ]) ?>
                        </div>

                        <div class="form-row-line depkes-row">
                            <label>Depkes Link</label>
                            <div class="depkes-box">
                                <?= $this->Form->radio(
                                    'depkes_link',
                                    $depkesOptions,
                                    [
                                        'legend' => false,
                                    ]
                                ) ?>
                            </div>
                        </div>

                        <div class="history-buttons">
                            <button type="button" class="btn btn-default btn-sm">History Hpp</button>
                            <button type="button" class="btn btn-default btn-sm">History Pembelian</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="stock-footer">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-info">
                        <div><label>Dibuat Oleh</label> <span><?= date('d-m-y') ?></span></div>
                        <div><label>Diedit Oleh</label> <span><?= h($createdByName ?? 'Admin') ?></span></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label>Minimum stock</label>
                    <div class="input-group input-group-sm">
                        <?= $this->Form->control('minimum_stock', [
                            'label' => false,
                            'type' => 'number',
                            'class' => 'form-control',
                            'value' => 0,
                        ]) ?>
                        <span class="input-group-addon label-unit-1">SATUAN</span>
                    </div>
                    <button type="button" class="btn btn-default btn-sm btn-block" style="margin-top:6px;">
                        Update Minimum Stock
                    </button>
                </div>

                <div class="col-md-4">
                    <label>Reorder Level</label>
                    <div class="input-group input-group-sm">
                        <?= $this->Form->control('reorder_level', [
                            'label' => false,
                            'type' => 'number',
                            'class' => 'form-control',
                            'value' => 0,
                        ]) ?>
                        <span class="input-group-addon label-unit-1">SATUAN</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="emr-actions">
            <?= $this->Html->link('BATAL', ['action' => 'index'], ['class' => 'btn btn-default btn-sm']) ?>
            <?= $this->Form->button('SIMPAN', ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>

<style>
.medicine-page { font-size:12px; }

.emr-window {
    border:1px solid #dbe3ec;
    background:#fff;
    border-radius:8px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    overflow:hidden;
}

.emr-titlebar {
    background:#1e3a5f;
    color:#fff;
    padding:11px 14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-weight:700;
    font-size:14px;
}

.emr-body {
    background:#eef3f8;
    padding:14px;
}

.medicine-card {
    background:#fff;
    border:1px solid #dbe3ec;
    border-radius:8px;
    padding:14px;
    min-height:520px;
    box-shadow:0 1px 4px rgba(0,0,0,.04);
}

.section-title {
    margin:0 0 14px;
    padding-bottom:8px;
    border-bottom:1px solid #dee2e6;
    color:#1e3a5f;
    font-size:13px;
    font-weight:700;
}

.form-row-line,
.unit-row {
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:9px;
}

.form-row-line > label:first-child,
.unit-row label {
    width:145px;
    margin:0;
    color:#495057;
    font-weight:600;
    font-size:12px;
}

.form-row-line .form-control,
.unit-row .form-control {
    flex:1;
    height:32px;
    font-size:12px;
    background:#fff;
    border:1px solid #ced4da;
    border-radius:4px;
    box-shadow:none;
}

.form-row-line .form-control:focus,
.unit-row .form-control:focus {
    border-color:#1e88e5;
    box-shadow:0 0 0 2px rgba(30,136,229,.12);
}

.check-label {
    width:auto !important;
    display:flex;
    align-items:center;
    gap:4px;
    color:#495057;
    font-weight:600;
    white-space:nowrap;
}

.check-label.long {
    width:220px !important;
}

.btn-mims {
    min-width:95px;
    height:32px;
    padding:5px 8px;
}

.qty-mini {
    max-width:75px;
    text-align:right;
}

.unit-default {
    padding:4px 8px;
    background:#e8f1ff;
    color:#1e3a5f;
    border-radius:12px;
    font-size:11px;
    font-weight:600;
    white-space:nowrap;
}

.unit-follow {
    min-width:70px;
    color:#495057;
    font-size:12px;
    font-weight:600;
    white-space:nowrap;
}

.price-input {
    max-width:170px;
    text-align:right;
}

.price-space {
    height:22px;
}

.radio-box-inline {
    background:#fff;
    border:1px solid #dee2e6;
    border-radius:4px;
    padding:5px 8px;
    min-width:210px;
}

.radio-box-inline label {
    margin-right:10px;
    font-weight:400;
}

.depkes-row {
    align-items:flex-start;
}

.depkes-box {
    background:#fff;
    border:1px solid #dee2e6;
    border-radius:4px;
    padding:8px 10px;
    width:270px;
}

.depkes-box label {
    display:block;
    margin:3px 0;
    color:#495057;
    font-weight:400;
}

.lead-input {
    max-width:170px;
}

.history-buttons {
    margin-top:105px;
    text-align:center;
}

.history-buttons .btn {
    width:180px;
    margin:0 4px;
}

.stock-footer {
    background:#f8f9fa;
    padding:14px;
    border-top:1px solid #dee2e6;
    color:#495057;
}

.stock-footer label,
.footer-info label {
    color:#495057;
    font-weight:600;
}

.footer-info label {
    width:100px;
    margin:0;
}

.footer-info div {
    margin-bottom:6px;
}

.emr-actions {
    background:#fff;
    border-top:1px solid #dee2e6;
    padding:12px 14px;
    text-align:right;
}

.emr-actions .btn {
    min-width:110px;
}

.btn-light {
    background:#f8f9fa;
    color:#333;
    border:1px solid #d9dee5;
}
</style>

<script>
$(function () {
    function toNum(v) {
        v = String(v || '0').replace(/\./g, '').replace(',', '.');
        return parseFloat(v) || 0;
    }

    function fmt(n) {
        return Number(n || 0).toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function updateUnitLabel() {
        var unit = $('[name="unit_1"]').val();

        if (!unit) {
            unit = 'SATUAN';
        }

        $('.label-unit-1').text(unit);
    }

    $('[name="unit_1"]').on('change input', function () {
        updateUnitLabel();
    });

    $('[name="hna"]').on('input', function () {
        var hna = toNum($(this).val());
        var ppnStatus = $('[name="ppn_status"]').is(':checked');
        var hnaPpn = ppnStatus ? hna : hna * 1.1;
        var hargaJual = hna * 1.375;
        var nilai = hna * 1.03;

        $('[name="hna_ppn"]').val(fmt(hnaPpn));
        $('[name="harga_jual"]').val(fmt(hargaJual));
        $('[name="harga_jual_jaminan"]').val(fmt(hargaJual));
        $('[name="nilai_persediaan_satuan"]').val(fmt(nilai));
    });

    $('[name="ppn_status"]').on('change', function () {
        $('[name="hna"]').trigger('input');
    });

    updateUnitLabel();
});
</script>