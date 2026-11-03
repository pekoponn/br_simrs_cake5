<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan $masterTindakan
 */

$kategoriConfig = [
    'Konsultasi'            => ['prefix' => 'KON', 'rj' => 1, 'ri' => 0, 'igd' => 0],
    'Tindakan Rawat Jalan'  => ['prefix' => 'TRJ', 'rj' => 1, 'ri' => 0, 'igd' => 0],
    'Tindakan Rawat Inap'   => ['prefix' => 'TRI', 'rj' => 0, 'ri' => 1, 'igd' => 0],
];

$kategoriOptions = array_merge(['' => '-- Pilih Kategori --'], array_combine(
    array_keys($kategoriConfig),
    array_keys($kategoriConfig)
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
                    <div class="mt-hint" style="margin-top:4px;">
                        Menentukan format kode & jenis kunjungan (RJ/RI/IGD) secara otomatis.
                    </div>
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

                <?php
                $priceGroups = [
                    'umum'    => ['label' => 'Umum',      'color' => '#155724'],
                    'bpjs'    => ['label' => 'BPJS',      'color' => '#0c5460'],
                    'reimbes' => ['label' => 'Reimburse', 'color' => '#856404'],
                ];
                ?>
                <div class="col-md-12">
                    <div class="row">
                    <?php foreach ($priceGroups as $key => $g): ?>
                        <div class="col-md-4">
                            <div class="mt-price-card" style="border-top:3px solid <?= $g['color'] ?>;">
                                <div class="mt-price-card-title" style="color:<?= $g['color'] ?>;">
                                    <?= h($g['label']) ?>
                                </div>

                                <label class="mt-label" style="margin-top:6px;">Harga (Cost ke Pasien)</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="text" id="harga-<?= $key ?>-display" class="form-control mt-harga-input" placeholder="0"
                                           value="<?= $masterTindakan->{'harga_' . $key} ? number_format($masterTindakan->{'harga_' . $key}, 0, ',', '.') : '' ?>">
                                </div>
                                <?= $this->Form->hidden('harga_' . $key, ['id' => 'harga_' . $key, 'value' => $masterTindakan->{'harga_' . $key} ?? 0]) ?>

                                <label class="mt-label" style="margin-top:8px;">% Dokter</label>
                                <div class="input-group">
                                    <?= $this->Form->number('persen_dokter_' . $key, [
                                        'id'    => 'persen_dokter_' . $key,
                                        'class' => 'form-control mt-persen-input',
                                        'min'   => 0,
                                        'max'   => 100,
                                        'step'  => 0.01,
                                        'value' => $masterTindakan->{'persen_dokter_' . $key} ?? 0,
                                    ]) ?>
                                    <span class="input-group-addon">%</span>
                                </div>

                                <label class="mt-label" style="margin-top:8px;">Share Type</label>
                                <div class="mt-share-toggle">
                                    <?php
                                    $shareOptions = ['rs_dr' => 'RS+DR', 'rs' => 'RS', 'dr' => 'DR'];
                                    $shareValue   = $masterTindakan->{'share_type_' . $key} ?? 'rs_dr';
                                    foreach ($shareOptions as $sval => $slabel):
                                    ?>
                                        <label class="mt-share-option">
                                            <input type="radio"
                                                   name="share_type_<?= $key ?>"
                                                   value="<?= $sval ?>"
                                                   <?= $shareValue === $sval ? 'checked' : '' ?>>
                                            <span class="mt-share-badge"><?= $slabel ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>

                                <div class="mt-price-result">
                                    <div>
                                        <span>Komisi Dokter</span>
                                        <strong id="komisi-<?= $key ?>-display">Rp 0</strong>
                                    </div>
                                    <div>
                                        <span>Jasa RS</span>
                                        <strong id="jasars-<?= $key ?>-display">Rp 0</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
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

.mt-price-card {
    background:#fff;
    border:1px solid #dee2e6;
    border-radius:6px;
    padding:10px 12px;
    margin-bottom:10px;
}
.mt-price-card-title {
    font-size:12px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.5px;
}
.mt-price-result {
    margin-top:10px;
    background:#f8f9fa;
    border-radius:4px;
    padding:6px 8px;
    font-size:11px;
}
.mt-price-result div {
    display:flex;
    justify-content:space-between;
    padding:2px 0;
}
.mt-price-result span { color:#6c757d; }
.mt-price-result strong { color:#1e3a5f; }

.mt-persen-input[readonly] {
    background:#f1f3f5;
    color:#495057;
    cursor:not-allowed;
}

.mt-share-toggle {
    display:flex;
    gap:6px;
    margin-top:6px;
}
.mt-share-option {
    cursor:pointer;
    margin:0;
    flex:1;
}
.mt-share-option input {
    display:none;
}
.mt-share-badge {
    display:block;
    text-align:center;
    padding:5px 4px;
    border-radius:14px;
    font-size:10px;
    font-weight:700;
    color:#6c757d;
    background:#f1f3f5;
    border:1px solid #dee2e6;
    transition:all .15s ease;
}
.mt-share-option input:checked + .mt-share-badge {
    background:#1e3a5f;
    color:#fff;
    border-color:#1e3a5f;
}
</style>

<script>
(function () {
    console.log('[DEBUG] Script master-tindakan/add mulai jalan');

    var kategoriConfig = <?= json_encode($kategoriConfig) ?>;
    var nextKodeUrl     = '<?= $this->Url->build(['action' => 'getNextKode']) ?>';

    console.log('[DEBUG] nextKodeUrl =', nextKodeUrl);

    var elKategori    = document.getElementById('kategori');
    var elKode        = document.getElementById('kode');
    var elKodePreview = document.getElementById('kode-preview');
    var priceKeys = ['umum', 'bpjs', 'reimbes'];

    function formatRupiah(n) {
        return 'Rp ' + Math.round(n).toLocaleString('id-ID');
    }

    function recalcCommission(key) {
        var harga  = parseFloat(document.getElementById('harga_' + key).value) || 0;
        var persen = parseFloat(document.getElementById('persen_dokter_' + key).value) || 0;
        var komisi = harga * persen / 100;
        var jasaRs = harga - komisi;

        document.getElementById('komisi-' + key + '-display').textContent = formatRupiah(komisi);
        document.getElementById('jasars-' + key + '-display').textContent = formatRupiah(jasaRs);
    }

    // Terapkan aturan otomatis %Dokter berdasarkan Share Type yang dipilih:
    // - DR    -> %Dokter dikunci 100 (komisi dokter = harga penuh)
    // - RS    -> %Dokter dikunci 0   (jasa RS = harga penuh)
    // - RS+DR -> %Dokter kembali bisa diisi manual oleh user
    function applyShareTypeToPersen(key, shareValue) {
        var elPersen = document.getElementById('persen_dokter_' + key);

        if (shareValue === 'dr') {
            elPersen.value = 100;
            elPersen.readOnly = true;
        } else if (shareValue === 'rs') {
            elPersen.value = 0;
            elPersen.readOnly = true;
        } else {
            // rs_dr -> bebas diisi manual
            elPersen.readOnly = false;
        }

        recalcCommission(key);
    }

    priceKeys.forEach(function (key) {
        var elDisplay = document.getElementById('harga-' + key + '-display');
        var elHidden  = document.getElementById('harga_' + key);
        var elPersen  = document.getElementById('persen_dokter_' + key);
        var elShareRadios = document.querySelectorAll('input[name="share_type_' + key + '"]');

        elDisplay.addEventListener('input', function () {
            var raw = this.value.replace(/\D/g, '');
            this.value      = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
            elHidden.value   = raw || '0';
            recalcCommission(key);
        });

        elPersen.addEventListener('input', function () {
            recalcCommission(key);
        });

        elShareRadios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    applyShareTypeToPersen(key, this.value);
                }
            });
        });

        var checkedRadio = document.querySelector('input[name="share_type_' + key + '"]:checked');
        if (checkedRadio) {
            applyShareTypeToPersen(key, checkedRadio.value);
        } else {
            recalcCommission(key);
        }
    });

    console.log('[DEBUG] elKategori ditemukan?', !!elKategori, 'value awal =', elKategori ? elKategori.value : null);
    console.log('[DEBUG] elKode ditemukan?', !!elKode);

    function fetchNextKode(kategori) {
        console.log('[DEBUG] fetchNextKode dipanggil dengan kategori =', kategori);

        if (!kategori || !kategoriConfig[kategori]) {
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