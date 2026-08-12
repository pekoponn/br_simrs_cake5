<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan $masterTindakan
 */

// Mapping kategori → prefix kode
$kategoriPrefix = [
    'Konsultasi'    => 'KON',
    'Tindakan'      => 'TIN',
    'Laboratorium'  => 'LAB',
    'Radiologi'     => 'RAD',
    'Farmasi'       => 'FAR',
    'Operasi'       => 'OPR',
    'Rawat Inap'    => 'RIN',
    'Rawat Jalan'   => 'RJL',
    'IGD'           => 'IGD',
    'Lainnya'       => 'LAN',
];

$kategoriOptions = array_merge(['' => '-- Pilih Kategori --'], array_combine(
    array_keys($kategoriPrefix),
    array_keys($kategoriPrefix)
));
?>

<?= $this->Krs->breadcrumb('Master Data', 'Tambah Master Tindakan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-plus-circle"></i> Tambah Master Tindakan
        </h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($masterTindakan, ['id' => 'form-add-tindakan', 'autocomplete' => 'off']) ?>

        <div class="mt-form-box">
            <div class="row">

                <!-- Kategori -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-tags"></i> Kategori <span class="text-danger">*</span></label>
                    <?= $this->Form->select('kategori', $kategoriOptions, [
                        'id'       => 'kategori',
                        'required' => true,
                        'class'    => 'form-control select2Form',
                        'value'    => $masterTindakan->kategori ?? '',
                    ]) ?>
                </div>

                <!-- Kode -->
                <div class="col-md-4">
                    <label class="mt-label">
                        <i class="fa fa-barcode"></i> Kode
                        <span id="kode-hint" class="mt-hint">(otomatis setelah pilih kategori)</span>
                    </label>
                    <?= $this->Form->text('kode', [
                        'id'          => 'kode',
                        'class'       => 'form-control',
                        'placeholder' => 'Pilih kategori dulu...',
                        'style'       => 'font-family:monospace; letter-spacing:1px; background:#f5f5f5;',
                        'readonly'    => true,
                        'value'       => $masterTindakan->kode ?? '',
                    ]) ?>
                    <div id="kode-preview" class="mt-hint" style="margin-top:4px;"></div>
                </div>

                <!-- Nama -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-file-signature"></i> Nama Tindakan <span class="text-danger">*</span></label>
                    <?= $this->Form->text('nama', [
                        'id'          => 'nama',
                        'required'    => true,
                        'class'       => 'form-control',
                        'placeholder' => 'Contoh: Konsultasi Dokter Spesialis',
                        'value'       => $masterTindakan->nama ?? '',
                    ]) ?>
                </div>

                <!-- Harga -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-money-bill-wave"></i> Harga</label>
                    <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" id="harga-display" class="form-control" placeholder="0"
                               value="<?= $masterTindakan->harga ? number_format($masterTindakan->harga, 0, ',', '.') : '' ?>">
                    </div>
                    <?= $this->Form->hidden('harga', ['id' => 'harga', 'value' => $masterTindakan->harga ?? 0]) ?>
                </div>

                <!-- Satuan -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-balance-scale"></i> Satuan</label>
                    <?= $this->Form->select('satuan',
                        ['' => '-- Pilih Satuan --', 'Kali' => 'Kali', 'Paket' => 'Paket', 'Hari' => 'Hari', 'Item' => 'Item', 'Unit' => 'Unit'],
                        [
                            'id'    => 'satuan',
                            'class' => 'form-control select2Form',
                            'value' => $masterTindakan->satuan ?? 'Kali',
                        ]
                    ) ?>
                </div>

                <!-- Status -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-toggle-on"></i> Status</label>
                    <div class="mt-status-toggle">
                        <label class="mt-status-option">
                            <?= $this->Form->radio('is_active', [['value' => '1', 'text' => '']], ['hiddenField' => false, 'label' => false, 'value' => $masterTindakan->is_active ?? 1]) ?>
                            <span class="mt-status-badge mt-status-on">Aktif</span>
                        </label>
                        <label class="mt-status-option">
                            <?= $this->Form->radio('is_active', [['value' => '0', 'text' => '']], ['hiddenField' => false, 'label' => false, 'value' => $masterTindakan->is_active ?? 1]) ?>
                            <span class="mt-status-badge mt-status-off">Nonaktif</span>
                        </label>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="col-md-12">
                    <label class="mt-label"><i class="fa fa-align-left"></i> Keterangan</label>
                    <?= $this->Form->textarea('keterangan', [
                        'id'          => 'keterangan',
                        'rows'        => 3,
                        'class'       => 'form-control',
                        'value'       => $masterTindakan->keterangan ?? '',
                        'placeholder' => 'Deskripsi singkat (opsional)',
                    ]) ?>
                </div>

            </div>
        </div>

        <div class="mt-actions">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>

            <?= $this->Form->button(
                '<i class="fa fa-save"></i> Simpan Tindakan',
                ['class' => 'btn btn-inverse btn-sm', 'escapeTitle' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

<style>
.mt-form-box {
    background:#f8f9fa;
    border:1px solid #dee2e6;
    border-radius:8px;
    padding:16px 16px 4px;
    margin-bottom:16px;
}
.mt-label {
    font-size:12px;
    font-weight:700;
    color:#1e3a5f;
    display:block;
    margin-bottom:6px;
}
.mt-hint {
    font-size:11px;
    color:#888;
    font-weight:400;
}
.mt-status-toggle {
    display:flex;
    gap:10px;
    margin-top:6px;
}
.mt-status-option {
    cursor:pointer;
    margin:0;
}
.mt-status-option input {
    display:none;
}
.mt-status-badge {
    display:inline-block;
    padding:6px 16px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
    color:#fff;
    background:#ced4da;
    transition:all .15s ease;
}
.mt-status-option input:checked + .mt-status-on {
    background:#198754;
}
.mt-status-option input:checked + .mt-status-off {
    background:#6c757d;
}
.mt-actions {
    display:flex;
    justify-content:flex-end;
    gap:6px;
    border-top:1px solid #dee2e6;
    padding-top:14px;
}
</style>

<script>
(function () {
    console.log('[DEBUG] Script master-tindakan/add mulai jalan');

    var prefixMap   = <?= json_encode($kategoriPrefix) ?>;
    var nextKodeUrl = '<?= $this->Url->build(['action' => 'getNextKode']) ?>';

    console.log('[DEBUG] nextKodeUrl =', nextKodeUrl);
    console.log('[DEBUG] prefixMap =', prefixMap);

    var elKategori    = document.getElementById('kategori');
    var elKode        = document.getElementById('kode');
    var elKodePreview = document.getElementById('kode-preview');
    var elHargaDisp   = document.getElementById('harga-display');
    var elHarga       = document.getElementById('harga');

    console.log('[DEBUG] elKategori ditemukan?', !!elKategori, 'value awal =', elKategori ? elKategori.value : null);
    console.log('[DEBUG] elKode ditemukan?', !!elKode);

    function fetchNextKode(kategori) {
        console.log('[DEBUG] fetchNextKode dipanggil dengan kategori =', kategori);

        if (!kategori || !prefixMap[kategori]) {
            console.log('[DEBUG] kategori kosong atau tidak ada di prefixMap, keluar');
            elKode.value = '';
            elKodePreview.textContent = '';
            return;
        }

        elKodePreview.textContent = 'Menghitung nomor urut...';

        $.ajax({
            url: nextKodeUrl,
            method: 'GET',
            data: { kategori: kategori },
            dataType: 'json',
            success: function (res) {
                console.log('[DEBUG] AJAX success, response =', res);
                if (res.success) {
                    elKode.value = res.kode;
                    elKodePreview.textContent =
                        'Prefix: ' + res.prefix + ' | Nomor urut ke-' + res.next_no + ' untuk kategori ini';
                } else {
                    elKode.value = '';
                    elKodePreview.textContent = res.message || 'Gagal mengambil kode.';
                }
            },
            error: function (xhr, status, err) {
                console.log('[DEBUG] AJAX error, status =', status, 'error =', err, 'responseText =', xhr.responseText);
                elKode.value = '';
                elKodePreview.textContent = 'Gagal terhubung ke server, coba lagi.';
            }
        });
    }

    // Bind change langsung ke elemen #kategori (dipasang ulang setelah select2 di-init di bawah)
    function bindKategoriChange() {
        $('#kategori').on('change', function () {
            console.log('[DEBUG] kategori berubah ->', this.value);
            fetchNextKode(this.value);
        });
    }

    elHargaDisp.addEventListener('input', function () {
        var raw = this.value.replace(/\D/g, '');
        this.value    = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
        elHarga.value = raw || '0';
    });

    $(function () {
        console.log('[DEBUG] $(document).ready jalan, elKategori.value =', elKategori.value, 'elKode.value =', elKode.value);

        $('.select2Form').each(function () {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2({
                    width: '100%',
                    minimumResultsForSearch: 0
                });
                console.log('[DEBUG] select2 di-init untuk', this.id);
            } else {
                console.log('[DEBUG] select2 SUDAH ter-init sebelumnya untuk', this.id, '- di-skip');
            }
        });

        // Bind event change SETELAH select2 selesai di-init supaya lebih pasti nyambung
        bindKategoriChange();

        // Cek ulang value AKTUAL via jQuery (bukan getElementById) setelah select2 render,
        // supaya kalau kategori sudah terisi (restore browser / mode edit) tetap trigger fetch
        var currentKategori = $('#kategori').val();
        console.log('[DEBUG] value kategori setelah select2 init =', currentKategori, '| elKode.value =', elKode.value);

        if (currentKategori && !elKode.value) {
            console.log('[DEBUG] trigger fetchNextKode karena kategori terisi tapi kode masih kosong');
            fetchNextKode(currentKategori);
        } else {
            console.log('[DEBUG] TIDAK trigger fetchNextKode awal. currentKategori =', currentKategori, 'elKode.value =', elKode.value);
        }
    });
})();
</script>