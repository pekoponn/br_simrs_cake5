<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan $masterTindakan
 */

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

<?= $this->Krs->breadcrumb('Master Data', 'Edit Master Tindakan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-edit"></i> Edit Master Tindakan
            <span class="mt-id-badge">ID #<?= h($masterTindakan->id) ?></span>
        </h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($masterTindakan, ['id' => 'form-edit-tindakan', 'autocomplete' => 'off']) ?>

        <div class="mt-form-box">
            <div class="row">

                <!-- Kategori -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-tags"></i> Kategori <span class="text-danger">*</span></label>
                    <?= $this->Form->select('kategori', $kategoriOptions, [
                        'id'           => 'kategori',
                        'required'     => true,
                        'class'        => 'form-control select2Form',
                        'value'        => $masterTindakan->kategori ?? '',
                        'data-current' => $masterTindakan->kategori ?? '',
                    ]) ?>
                </div>

                <!-- Kode -->
                <div class="col-md-4">
                    <label class="mt-label">
                        <i class="fa fa-barcode"></i> Kode
                        <span class="mt-hint">(ubah manual atau generate ulang)</span>
                    </label>
                    <div class="input-group">
                        <?= $this->Form->text('kode', [
                            'id'       => 'kode',
                            'class'    => 'form-control',
                            'style'    => 'font-family:monospace; letter-spacing:1px;',
                            'value'    => $masterTindakan->kode ?? '',
                            'required' => true,
                        ]) ?>
                        <span class="input-group-btn">
                            <button type="button" id="btn-regen-kode" class="btn btn-info" title="Generate ulang">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </span>
                    </div>
                    <div id="kode-preview" class="mt-hint" style="margin-top:4px;">
                        Kode lama: <strong id="kode-lama-label"><?= h($masterTindakan->kode) ?></strong>
                    </div>
                </div>

                <!-- Nama -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-file-signature"></i> Nama Tindakan <span class="text-danger">*</span></label>
                    <?= $this->Form->text('nama', [
                        'id'       => 'nama',
                        'required' => true,
                        'class'    => 'form-control',
                        'value'    => $masterTindakan->nama ?? '',
                    ]) ?>
                </div>

                <!-- Harga -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-money-bill-wave"></i> Harga</label>
                    <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" id="harga-display" class="form-control" placeholder="0"
                               value="<?= $masterTindakan->harga ? number_format($masterTindakan->harga, 0, ',', '.') : '0' ?>">
                    </div>
                    <?= $this->Form->hidden('harga', ['id' => 'harga', 'value' => $masterTindakan->harga ?? 0]) ?>
                </div>

                <!-- Satuan -->
                <div class="col-md-4">
                    <label class="mt-label"><i class="fa fa-balance-scale"></i> Satuan</label>
                    <?= $this->Form->select('satuan',
                        ['Kali' => 'Kali', 'Paket' => 'Paket', 'Hari' => 'Hari', 'Item' => 'Item', 'Unit' => 'Unit'],
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
                            <?= $this->Form->radio('is_active', [['value' => '1', 'text' => '']], ['hiddenField' => false, 'label' => false, 'value' => $masterTindakan->is_active]) ?>
                            <span class="mt-status-badge mt-status-on">Aktif</span>
                        </label>
                        <label class="mt-status-option">
                            <?= $this->Form->radio('is_active', [['value' => '0', 'text' => '']], ['hiddenField' => false, 'label' => false, 'value' => $masterTindakan->is_active]) ?>
                            <span class="mt-status-badge mt-status-off">Nonaktif</span>
                        </label>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="col-md-12">
                    <label class="mt-label"><i class="fa fa-align-left"></i> Keterangan</label>
                    <?= $this->Form->textarea('keterangan', [
                        'id'    => 'keterangan',
                        'rows'  => 3,
                        'class' => 'form-control',
                        'value' => $masterTindakan->keterangan ?? '',
                    ]) ?>
                </div>

            </div>
        </div>

        <div class="mt-meta-box">
            <i class="fa fa-info-circle"></i>
            <strong>Dibuat:</strong> <?= h($masterTindakan->created ? $masterTindakan->created->format('d/m/Y H:i:s') : '-') ?>
            &nbsp;|&nbsp;
            <strong>Terakhir diubah:</strong> <?= h($masterTindakan->modified ? $masterTindakan->modified->format('d/m/Y H:i:s') : '-') ?>
        </div>

        <div class="mt-actions">
            <?= $this->Form->postLink(
                '<i class="fa fa-ban"></i> Hapus',
                ['action' => 'delete', $masterTindakan->id],
                [
                    'escape'  => false,
                    'class'   => 'btn btn-danger btn-sm',
                    'confirm' => __('Hapus tindakan "{0}"? Tindakan ini tidak dapat dibatalkan.', $masterTindakan->nama),
                    'style'   => 'margin-right:auto;',
                ]
            ) ?>

            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Batal',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>

            <?= $this->Form->button(
                '<i class="fa fa-save"></i> Simpan Perubahan',
                ['class' => 'btn btn-inverse btn-sm', 'escapeTitle' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

<style>
.mt-id-badge {
    display:inline-block;
    background:rgba(255,255,255,.15);
    padding:2px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
    margin-left:8px;
    vertical-align:middle;
}
.mt-form-box {
    background:#f8f9fa;
    border:1px solid #dee2e6;
    border-radius:8px;
    padding:16px 16px 4px;
    margin-bottom:14px;
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
.mt-meta-box {
    background:#f8f9fa;
    border:1px solid #dee2e6;
    border-radius:8px;
    padding:10px 14px;
    font-size:12px;
    color:#6c757d;
    margin-bottom:14px;
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
    console.log('[DEBUG] Script master-tindakan/edit mulai jalan');

    var prefixMap   = <?= json_encode($kategoriPrefix) ?>;
    var nextKodeUrl = '<?= $this->Url->build(['action' => 'getNextKode']) ?>';

    var elKategori    = document.getElementById('kategori');
    var elKode        = document.getElementById('kode');
    var elKodePreview = document.getElementById('kode-preview');
    var btnRegen      = document.getElementById('btn-regen-kode');
    var elHargaDisp   = document.getElementById('harga-display');
    var elHarga       = document.getElementById('harga');
    var kodeLama      = elKode.value; // simpan kode asli sebelum diubah, untuk ditampilkan sbg referensi

    // Nilai kategori ASLI dari database (dikirim lewat data-current, bukan bergantung pada 'selected' option)
    var kategoriDb = elKategori.getAttribute('data-current') || '';
    console.log('[DEBUG] kategoriDb (dari database) =', JSON.stringify(kategoriDb));
    console.log('[DEBUG] elKategori.value (dari <option selected>) =', JSON.stringify(elKategori.value));

    // Generate kode berikutnya lewat AJAX ke server (format sama persis dgn halaman Add: PREFIX-001, PREFIX-002, dst)
    function fetchNextKode(kategori) {
        console.log('[DEBUG] fetchNextKode dipanggil dengan kategori =', kategori);

        if (!kategori || !prefixMap[kategori]) {
            console.log('[DEBUG] kategori kosong / tidak dikenal, batal generate');
            return;
        }

        elKode.disabled = true;
        btnRegen.disabled = true;
        elKodePreview.innerHTML = 'Menghitung nomor urut...';

        $.ajax({
            url: nextKodeUrl,
            method: 'GET',
            data: { kategori: kategori },
            dataType: 'json',
            success: function (res) {
                console.log('[DEBUG] AJAX success, response =', res);
                if (res.success) {
                    elKode.value = res.kode;
                    elKodePreview.innerHTML =
                        'Kode lama: <strong>' + kodeLama + '</strong> | Kode baru: prefix ' + res.prefix +
                        ', urutan ke-' + res.next_no;
                } else {
                    elKodePreview.innerHTML = res.message || 'Gagal mengambil kode baru.';
                }
            },
            error: function (xhr, status, err) {
                console.log('[DEBUG] AJAX error, status =', status, 'error =', err, 'responseText =', xhr.responseText);
                elKodePreview.innerHTML = 'Gagal terhubung ke server, coba lagi.';
            },
            complete: function () {
                elKode.disabled = false;
                btnRegen.disabled = false;
            }
        });
    }

    btnRegen.addEventListener('click', function () {
        var kat = $('#kategori').val();
        if (!kat) { alert('Pilih kategori terlebih dahulu.'); return; }
        if (!confirm('Generate kode baru dari server? Kode saat ini di kolom akan diganti (belum tersimpan sampai Anda klik "Simpan Perubahan").')) return;
        fetchNextKode(kat);
    });

    elHargaDisp.addEventListener('input', function () {
        var raw = this.value.replace(/\D/g, '');
        this.value    = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
        elHarga.value = raw || '0';
    });

    $(function () {
        $('.select2Form').each(function () {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2({
                    width: '100%',
                    minimumResultsForSearch: 0
                });
                console.log('[DEBUG] select2 di-init untuk', this.id);
            }
        });

        // ── Fallback: pastikan kategori ter-set walau ada mismatch huruf besar/kecil / spasi ──
        var valSekarang = $('#kategori').val();
        console.log('[DEBUG] value #kategori setelah select2 init =', JSON.stringify(valSekarang));

        if (kategoriDb && valSekarang !== kategoriDb) {
            console.log('[DEBUG] MISMATCH terdeteksi antara data DB dan opsi yg ter-set. Mencoba pencocokan case-insensitive...');

            var kategoriDbTrim = kategoriDb.trim().toLowerCase();
            var matchedKey = null;

            $('#kategori option').each(function () {
                var optVal = ($(this).val() || '').trim().toLowerCase();
                if (optVal === kategoriDbTrim) {
                    matchedKey = $(this).val();
                    return false; // break
                }
            });

            if (matchedKey) {
                console.log('[DEBUG] Ditemukan match case-insensitive ->', matchedKey, '. Menerapkan ke select2...');
                $('#kategori').val(matchedKey).trigger('change.select2');
            } else {
                console.warn('[DEBUG] TIDAK ada opsi kategori yang cocok dengan data DB "' + kategoriDb + '". ' +
                    'Kemungkinan nilai di database tidak ada di daftar $kategoriPrefix (typo/kategori lama yg sudah dihapus dari mapping). ' +
                    'Cek isi kolom kategori di database untuk baris ini.');
            }
        }
    });
})();
</script>