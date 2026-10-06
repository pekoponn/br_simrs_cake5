<?php
/**
 * Simpan di: templates/EmergencyEntries/tindakan.php
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 * @var iterable $actions   Baris dari tabel emergency_actions milik registrasi ini
 */

$p = $registration->patient ?? null;
$d = $registration->doctor ?? null;

// Jika pemeriksaan sudah diselesaikan (tagihan sudah dibuat), halaman jadi tampilan saja.
$isLocked  = ($registration->status ?? '') === 'done';
$csrfToken = $this->request->getAttribute('csrfToken');

$fmt = function ($value, string $format = 'd-m-Y') {
    if (empty($value)) {
        return '-';
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format($format);
    }
    $time = strtotime((string)$value);
    return $time ? date($format, $time) : '-';
};

// Kunci = nilai yang disimpan di kolom emergency_actions.action_category
$categories = [
    'tindakan_medis'  => ['label' => 'Pemeriksaan & Tindakan Dokter', 'icon' => 'fa-stethoscope',       'full' => true],
    'obat'            => ['label' => 'Obat / Resep',                  'icon' => 'fa-pills',             'full' => true],
    'bedah'           => ['label' => 'Bedah / ODC',                   'icon' => 'fa-user-md',           'full' => false],
    'laboratorium'    => ['label' => 'Laboratorium',                  'icon' => 'fa-flask',             'full' => false],
    'radiologi'       => ['label' => 'Radiologi',                     'icon' => 'fa-x-ray',             'full' => false],
    'penunjang_medis' => ['label' => 'Penunjang Medis',               'icon' => 'fa-briefcase-medical', 'full' => false],
];

$grouped = array_fill_keys(array_keys($categories), []);
foreach ($actions as $a) {
    $cat = (string)($a->action_category ?? 'tindakan_medis');
    if (!isset($grouped[$cat])) {
        // Kategori lama / tidak dikenal tetap ditampilkan di kelompok tindakan
        $cat = 'tindakan_medis';
    }
    $grouped[$cat][] = $a;
}

$sums = [];
$grandTotal = 0.0;
foreach ($grouped as $cat => $rows) {
    $sum = 0.0;
    foreach ($rows as $r) {
        $sum += (float)$r->quantity * (float)$r->unit_price;
    }
    $sums[$cat] = $sum;
    $grandTotal += $sum;
}

$addUrl    = $this->Url->build(['action' => 'tambahTindakan', $registration->id]);
$deleteUrl = $this->Url->build(['action' => 'hapusTindakan', '__ID__']);
$indexUrl  = $this->Url->build(['action' => 'index']);
$searchUrl = $this->Url->build(['action' => 'cariMaster']);

// Jenis harga master tindakan mengikuti cara bayar pasien: bpjs / reimbes / umum
$payText = strtolower((string)($registration->payment_method ?? '') . ' ' . (string)($registration->insurance_type ?? ''));
if (strpos($payText, 'bpjs') !== false || strpos($payText, 'jkn') !== false) {
    $priceType = 'bpjs';
} elseif (strpos($payText, 'reimb') !== false || strpos($payText, 'asuransi') !== false) {
    $priceType = 'reimbes';
} else {
    $priceType = 'umum';
}

$patientName = trim(($p->title ?? '') . ' ' . ($p->full_name ?? '-'));
$payment = $registration->payment_method ?? '-';
if (!empty($registration->insurance_type)) {
    $payment .= ' - ' . $registration->insurance_type;
}
?>

<?= $this->Krs->breadcrumb('IGD', 'Tindakan IGD') ?>

<div class="igd-tindakan">

    <!-- ── HEADER ── -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
            <i class="fa fa-syringe"></i> Tindakan IGD
        </h4>
        <div style="display:flex; gap:6px;">
            <?= $this->Html->link(
                '<i class="fa fa-notes-medical"></i> EMR',
                ['action' => 'emr', $registration->id],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </div>
    </div>

    <?php if ($isLocked): ?>
        <div class="alert alert-warning" style="padding:8px 12px; font-size:12px; margin-bottom:10px;">
            <i class="fa fa-lock"></i> Pemeriksaan ini sudah diselesaikan dan tagihannya sudah dibuat. Halaman hanya untuk dilihat.
        </div>
    <?php endif; ?>

    <!-- ── INFO PASIEN ── -->
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:8px 12px; background:#f8f9fa; font-size:12px;">
            <div class="row">
                <div class="col-md-2">
                    <small>No Registrasi</small><br>
                    <strong style="font-family:monospace;"><?= h($registration->registration_no ?? '-') ?></strong>
                </div>
                <div class="col-md-2">
                    <small>No RM</small><br>
                    <strong><?= h($p->code ?? '-') ?></strong>
                </div>
                <div class="col-md-3">
                    <small>Nama Pasien</small><br>
                    <strong><?= h($patientName) ?></strong>
                </div>
                <div class="col-md-2">
                    <small>Dokter</small><br>
                    <strong><?= h($d->doctor_name ?? '-') ?></strong>
                </div>
                <div class="col-md-1">
                    <small>Cara Bayar</small><br>
                    <strong><?= h($payment) ?></strong>
                </div>
                <div class="col-md-2">
                    <small>Tgl Masuk</small><br>
                    <strong><?= h($fmt($registration->registration_date ?? null)) ?>
                        <?= h(!empty($registration->admission_time) ? substr((string)$registration->admission_time, 0, 5) : '') ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- ── KATEGORI TINDAKAN ── -->
    <?php
    $renderPanel = function (string $cat, array $info) use ($grouped, $sums, $isLocked) {
        $rows = $grouped[$cat];
        $colspan = $isLocked ? 5 : 6;
        ob_start();
        ?>
        <div class="panel panel-default tindakan-panel" data-cat="<?= h($cat) ?>">
            <div class="panel-heading" style="display:flex; justify-content:space-between; align-items:center; padding:6px 10px; background:#1e3a5f; border-color:#1e3a5f;">
                <strong style="font-size:12px; color:#fff;">
                    <i class="fa <?= h($info['icon']) ?>"></i> <?= h($info['label']) ?>
                </strong>
                <?php if (!$isLocked): ?>
                    <button type="button" class="btn btn-xs btn-success btn-tambah-item" data-cat="<?= h($cat) ?>">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                <?php endif; ?>
            </div>
            <div class="panel-body" style="padding:0;">
                <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:0;">
                    <thead style="background:#f0f4f8;">
                        <tr class="text-center">
                            <th style="width:80px;">Kode</th>
                            <th>Nama</th>
                            <th style="width:50px;">Qty</th>
                            <th style="width:95px;">Harga</th>
                            <th style="width:95px;">Total</th>
                            <?php if (!$isLocked): ?><th style="width:28px;"></th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rows)): ?>
                            <tr>
                                <td colspan="<?= $colspan ?>" class="text-center" style="color:#aaa; padding:12px;">
                                    Belum ada data
                                </td>
                            </tr>
                        <?php else: foreach ($rows as $row): ?>
                            <tr>
                                <td class="text-center" style="font-family:monospace;"><?= h($row->action_code ?: '-') ?></td>
                                <td>
                                    <?= h($row->action_name) ?>
                                    <?php if (!empty($row->notes)): ?>
                                        <br><small style="color:#888;"><?= h($row->notes) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= h($row->quantity) ?></td>
                                <td class="text-right"><?= number_format((float)$row->unit_price, 0, ',', '.') ?></td>
                                <td class="text-right" style="font-weight:600;"><?= number_format((float)$row->quantity * (float)$row->unit_price, 0, ',', '.') ?></td>
                                <?php if (!$isLocked): ?>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-danger btn-hapus-item" data-id="<?= (int)$row->id ?>">&times;</button>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                    <tfoot style="background:#f8f9fa; font-weight:700;">
                        <tr>
                            <td colspan="4" class="text-right" style="padding-right:10px;">Subtotal</td>
                            <td class="text-right"><?= number_format($sums[$cat], 0, ',', '.') ?></td>
                            <?php if (!$isLocked): ?><td></td><?php endif; ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <?php
        return ob_get_clean();
    };
    ?>

    <?php foreach ($categories as $cat => $info): ?>
        <?php if ($info['full']): ?>
            <?= $renderPanel($cat, $info) ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="row tindakan-grid">
        <?php foreach ($categories as $cat => $info): ?>
            <?php if (!$info['full']): ?>
                <div class="col-md-6">
                    <?= $renderPanel($cat, $info) ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- ── RINGKASAN ── -->
    <div class="panel panel-default">
        <div class="panel-heading" style="padding:8px 12px;">
            <strong style="font-size:12px;"><i class="fa fa-calculator"></i> Ringkasan Tindakan</strong>
        </div>
        <div class="panel-body" style="padding:14px;">
            <div class="row">
                <div class="col-md-7">
                    <table style="width:100%; font-size:12px;">
                        <?php foreach ($categories as $cat => $info): ?>
                            <tr>
                                <td style="padding:3px 0;"><?= h($info['label']) ?></td>
                                <td class="text-right" style="font-weight:700;"><?= number_format($sums[$cat], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="col-md-5" style="border-left:1px solid #eee;">
                    <div style="font-size:20px; font-weight:800; color:#1e3a5f; text-align:right;">
                        Rp <?= number_format($grandTotal, 0, ',', '.') ?>
                    </div>
                    <div style="font-size:11px; color:#888; text-align:right;">TOTAL TINDAKAN</div>
                    <div style="font-size:11px; color:#888; text-align:right; margin-top:6px;">
                        Halaman ini hanya untuk pencatatan. Tidak ada pembayaran di sini.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!$isLocked): ?>
    <!-- ── MODAL TAMBAH ITEM ── -->
    <div id="modal-tambah-item-overlay" class="krs-modal-overlay">
        <div class="krs-modal-box" style="max-width:460px;">
            <div class="krs-modal-head">
                <strong><i class="fa fa-plus"></i> Tambah Item Tindakan</strong>
                <button type="button" class="krs-modal-close" id="btn-cancel-item">&times;</button>
            </div>
            <div class="krs-modal-body">
                <div class="form-group">
                    <label style="font-size:11px;">Kategori</label>
                    <select id="new-item-cat" class="form-control input-sm">
                        <?php foreach ($categories as $cat => $info): ?>
                            <option value="<?= h($cat) ?>"><?= h($info['label']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" id="wrap-master-search" style="display:none; position:relative;">
                    <label style="font-size:11px;" id="master-search-label">Cari dari master</label>
                    <input type="text" id="master-search" class="form-control input-sm" placeholder="Ketik kode atau nama, lalu pilih..." autocomplete="off">
                    <div id="master-results" class="master-results"></div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label style="font-size:11px;">Kode</label>
                            <input type="text" id="new-item-code" class="form-control input-sm" placeholder="Opsional">
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <div class="form-group">
                            <label style="font-size:11px;">Nama Item <span style="color:red;">*</span></label>
                            <input type="text" id="new-item-name" class="form-control input-sm" placeholder="Nama tindakan / obat / pemeriksaan...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label style="font-size:11px;">Qty</label>
                            <input type="number" id="new-item-qty" class="form-control input-sm" value="1" min="1" step="1">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label style="font-size:11px;">Harga / Unit</label>
                            <input type="number" id="new-item-price" class="form-control input-sm" value="0" min="0" step="1000">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-size:11px;">Catatan</label>
                    <input type="text" id="new-item-notes" class="form-control input-sm" placeholder="Opsional">
                </div>
                <div style="display:flex; gap:6px;">
                    <button type="button" class="btn btn-success btn-sm" id="btn-save-item"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-default btn-sm" id="btn-cancel-item-2">Batal</button>
                </div>
                <div id="item-message" style="margin-top:8px; font-size:12px; font-weight:600;"></div>
            </div>
        </div>
    </div>

    <!-- ── MODAL PILIH DARI MASTER (gaya daftar tindakan & tarif) ── -->
    <div id="modal-pilih-master-overlay" class="krs-modal-overlay">
        <div class="krs-modal-box" style="max-width:960px;">
            <div class="krs-modal-head">
                <strong><i class="fa fa-search"></i> <span id="pm-modal-title">DAFTAR TINDAKAN &amp; TARIF</span></strong>
                <button type="button" class="krs-modal-close" id="btn-cancel-master">&times;</button>
            </div>
            <div class="krs-modal-body">
                <div class="form-group">
                    <label style="font-size:11px; font-weight:600;">Cari</label>
                    <input type="text" id="pm-search-input" class="form-control input-sm"
                           placeholder="Ketik kode / nama, lalu centang untuk memilih..." autocomplete="off">
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="pm-list-wrap">
                            <table class="table table-bordered table-sm" style="margin-bottom:0; font-size:12px;">
                                <thead>
                                    <tr class="pm-thead-row">
                                        <th style="width:34px; text-align:center;">Pilih</th>
                                        <th style="width:90px;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width:110px; text-align:right;">Tarif</th>
                                    </tr>
                                </thead>
                                <tbody id="pm-list-body">
                                    <tr><td colspan="4" style="text-align:center; color:#999; padding:14px;">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="pm-selected-wrap">
                            <div class="pm-selected-head">Tindakan Terpilih</div>
                            <table class="table table-bordered table-sm" style="margin-bottom:0; font-size:11px;">
                                <thead>
                                    <tr class="pm-thead-row-2">
                                        <th style="width:60px;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width:80px; text-align:right;">Tarif</th>
                                        <th style="width:24px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="pm-selected-body">
                                    <tr id="pm-selected-empty">
                                        <td colspan="4" style="text-align:center; color:#aaa; padding:12px; font-size:11px;">
                                            Belum ada yang dipilih.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
                    <a href="#" id="pm-link-manual" style="font-size:11px;">
                        <i class="fa fa-pencil-alt"></i> Item tidak ada di master? Input manual
                    </a>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-ok-pilih-master">
                            <i class="fa fa-check"></i> OK
                        </button>
                        <button type="button" class="btn btn-default btn-sm" id="btn-batal-pilih-master">
                            <i class="fa fa-times"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.tindakan-grid { display: flex; flex-wrap: wrap; }

.master-results {
    display: none;
    position: absolute;
    left: 0; right: 0; top: 100%;
    z-index: 20;
    background: #fff;
    border: 1px solid #ccd5e0;
    border-radius: 0 0 4px 4px;
    max-height: 210px;
    overflow-y: auto;
    box-shadow: 0 6px 14px rgba(0,0,0,.15);
}
.master-item {
    padding: 6px 10px;
    font-size: 12px;
    cursor: pointer;
    border-bottom: 1px solid #eef1f5;
}
.master-item:hover { background: #eef3fa; }
.tindakan-grid > [class*="col-"] { display: flex; flex-direction: column; }
.tindakan-grid > [class*="col-"] > .panel { flex: 1 1 auto; }

.pm-list-wrap {
    border: 1px solid #9eb2d1;
    background: #f7f9ff;
    max-height: 360px;
    overflow-y: auto;
}
.pm-thead-row th { background: #c8d8f0 !important; }
.pm-selected-wrap {
    border: 1px solid #9eb2d1;
    background: #eef3ff;
    max-height: 360px;
    min-height: 360px;
    overflow-y: auto;
}
.pm-selected-head {
    background: #c8d8f0;
    padding: 6px 10px;
    font-weight: 700;
    font-size: 11px;
}
.pm-thead-row-2 th { background: #dbe6fb !important; }
#pm-list-body tr.pm-row { cursor: pointer; }
#pm-list-body tr.pm-row:hover { background: #eef3ff; }
#pm-list-body tr.pm-row-selected { background: #dbe6fb; }
#pm-list-body tr.pm-row-selected:hover { background: #cddaf5; }
#pm-list-body tr.pm-row-disabled { background: #f5f5f5 !important; cursor: not-allowed; opacity: .55; }

.krs-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    z-index: 2000;
    align-items: flex-start;
    justify-content: center;
    padding: 30px 15px;
    overflow-y: auto;
}
.krs-modal-overlay.show { display: flex; }
.krs-modal-box {
    background: #fff;
    border-radius: 8px;
    width: 100%;
    box-shadow: 0 10px 40px rgba(0,0,0,.25);
    overflow: hidden;
}
.krs-modal-head {
    background: #1e3a5f;
    color: #fff;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}
.krs-modal-close {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 20px;
    line-height: 1;
    cursor: pointer;
    padding: 0 4px;
}
.krs-modal-close:hover { color: #fecaca; }
.krs-modal-body { padding: 16px; max-height: 80vh; overflow-y: auto; }
</style>

<?php if (!$isLocked): ?>
<script>
$(function () {
    var CSRF       = <?= json_encode($csrfToken) ?>;
    var ADD_URL    = <?= json_encode($addUrl) ?>;
    var DELETE_URL = <?= json_encode($deleteUrl) ?>;
    var SEARCH_URL = <?= json_encode($searchUrl) ?>;
    var PRICE_TYPE = <?= json_encode($priceType) ?>;
    var PRICE_LABEL = { bpjs: 'BPJS', reimbes: 'Reimbes', umum: 'Umum' };

    // Kategori yang punya master data untuk dipilih
    var MASTER_LABEL = {
        tindakan_medis: 'Cari dari master tindakan (harga ' + PRICE_LABEL[PRICE_TYPE] + ')',
        obat: 'Cari dari master obat'
    };
    var searchTimer = null;

    function resetMasterSearch() {
        $('#master-search').val('');
        $('#master-results').hide().empty();
    }

    function toggleMasterSearch() {
        var cat = $('#new-item-cat').val();
        if (MASTER_LABEL[cat]) {
            $('#master-search-label').text(MASTER_LABEL[cat]);
            $('#wrap-master-search').show();
        } else {
            $('#wrap-master-search').hide();
        }
        resetMasterSearch();
    }

    function showMasterMessage(text, color) {
        $('#master-results').empty()
            .append($('<div class="master-item">').css('color', color).text(text))
            .show();
    }

    $('#new-item-cat').on('change', toggleMasterSearch);

    $('#master-search').on('input', function () {
        var q = $.trim($(this).val());
        var cat = $('#new-item-cat').val();
        clearTimeout(searchTimer);

        if (q.length < 2) {
            $('#master-results').hide().empty();
            return;
        }

        searchTimer = setTimeout(function () {
            $.getJSON(SEARCH_URL, { type: cat, q: q, price_type: PRICE_TYPE }).done(function (res) {
                if (!res || !res.success) {
                    showMasterMessage((res && res.message) || 'Gagal mencari data master.', '#b91c1c');
                    return;
                }
                if (!res.data.length) {
                    showMasterMessage('Tidak ditemukan.', '#888');
                    return;
                }
                var $box = $('#master-results').empty();
                $.each(res.data, function (i, row) {
                    var text = (row.code ? row.code + ' - ' : '') + row.name +
                        '  (Rp ' + Number(row.price || 0).toLocaleString('id-ID') + ')';
                    $box.append($('<div class="master-item">').text(text).data('row', row));
                });
                $box.show();
            }).fail(function (xhr) {
                showMasterMessage('Gagal mencari data master (' + xhr.status + ').', '#b91c1c');
            });
        }, 250);
    });

    // Pilih hasil pencarian: isi kode, nama, dan harga otomatis
    $(document).on('click', '.master-item', function () {
        var row = $(this).data('row');
        if (!row) { return; }
        $('#new-item-code').val(row.code || '');
        $('#new-item-name').val(row.name || '');
        $('#new-item-price').val(row.price || 0);
        resetMasterSearch();
        $('#new-item-qty').focus().select();
    });

    function closeModal() {
        $('#modal-tambah-item-overlay').removeClass('show');
        $('#new-item-code, #new-item-name, #new-item-notes').val('');
        $('#new-item-qty').val(1);
        $('#new-item-price').val(0);
        $('#item-message').text('');
        resetMasterSearch();
    }

    // Tombol "Tambah" di tiap panel: kategori bermaster -> modal picker, selain itu -> modal manual
    $(document).on('click', '.btn-tambah-item', function () {
        var cat = $(this).data('cat');
        if (MASTER_LABEL[cat]) {
            openPickerModal(cat);
        } else {
            $('#new-item-cat').val(cat);
            toggleMasterSearch();
            $('#modal-tambah-item-overlay').addClass('show');
            $('#new-item-name').focus();
        }
    });

    $('#btn-cancel-item, #btn-cancel-item-2').on('click', closeModal);
    $('#modal-tambah-item-overlay').on('click', function (e) {
        if (e.target === this) { closeModal(); }
    });

    $('#btn-save-item').on('click', function () {
        var name = $.trim($('#new-item-name').val());
        if (!name) {
            $('#item-message').text('Nama item wajib diisi.').css('color', '#b91c1c');
            return;
        }

        var $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan');

        $.ajax({
            url: ADD_URL,
            method: 'POST',
            headers: { 'X-CSRF-Token': CSRF },
            dataType: 'json',
            data: {
                action_category: $('#new-item-cat').val(),
                action_code:     $.trim($('#new-item-code').val()),
                action_name:     name,
                quantity:        $('#new-item-qty').val(),
                unit_price:      $('#new-item-price').val(),
                notes:           $.trim($('#new-item-notes').val())
            }
        }).done(function (res) {
            if (res && res.success) {
                location.reload();
            } else {
                $('#item-message').text((res && res.message) || 'Gagal menyimpan item.').css('color', '#b91c1c');
                $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
            }
        }).fail(function (xhr) {
            $('#item-message').text('Gagal menyimpan (' + xhr.status + ').').css('color', '#b91c1c');
            $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
        });
    });

    $(document).on('click', '.btn-hapus-item', function () {
        if (!confirm('Hapus item ini?')) { return; }
        var $btn = $(this).prop('disabled', true);

        $.ajax({
            url: DELETE_URL.replace('__ID__', $btn.data('id')),
            method: 'POST',
            headers: { 'X-CSRF-Token': CSRF },
            dataType: 'json'
        }).done(function (res) {
            if (res && res.success) {
                location.reload();
            } else {
                alert((res && res.message) || 'Gagal menghapus item.');
                $btn.prop('disabled', false);
            }
        }).fail(function (xhr) {
            alert('Gagal menghapus (' + xhr.status + ').');
            $btn.prop('disabled', false);
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // MODAL PILIH DARI MASTER (gaya "Daftar Tindakan & Tarif")
    // ══════════════════════════════════════════════════════════════════
    var pmCategory = null;
    var pmSelected = {};   // key: code||name -> {code, name, price}
    var pmSearchTimer = null;
    var pmLastQuery = '';

    var PM_TITLE = {
        tindakan_medis: 'DAFTAR TINDAKAN & TARIF',
        obat: 'DAFTAR OBAT'
    };

    function pmEscHtml(str) { return $('<div>').text(String(str || '')).html(); }

    function pmExistingKeys() {
        var keys = {};
        $('.tindakan-panel[data-cat="' + pmCategory + '"] tbody tr').each(function () {
            var $tds = $(this).find('td');
            if ($tds.length < 2) { return; }
            var kode = $.trim($tds.eq(0).text());
            var nama = $.trim($tds.eq(1).text().split('\n')[0]);
            if (nama) { keys[(kode === '-' ? '' : kode) + '||' + nama] = true; }
        });
        return keys;
    }

    function pmRenderList(rows) {
        var $body = $('#pm-list-body').empty();

        if (!rows || !rows.length) {
            $body.html('<tr><td colspan="4" style="text-align:center; color:#aaa; padding:14px;">Tidak ditemukan.</td></tr>');
            return;
        }

        var existing = pmExistingKeys();

        $.each(rows, function (i, item) {
            var key = (item.code || '') + '||' + (item.name || '');
            var isPicked = !!pmSelected[key];
            var already = !!existing[key];
            var rowClass = 'pm-row';
            if (already) { rowClass += ' pm-row-disabled'; }
            else if (isPicked) { rowClass += ' pm-row-selected'; }

            var noteHtml = already
                ? ' <span style="color:#999; font-size:10px;">(sudah ditambahkan)</span>'
                : '';

            var $tr = $(
                '<tr class="' + rowClass + '" data-already="' + (already ? '1' : '0') + '">' +
                '<td class="text-center"><input type="checkbox" style="pointer-events:none;" ' +
                (isPicked ? 'checked' : '') + (already ? ' disabled' : '') + '></td>' +
                '<td style="font-family:monospace;">' + pmEscHtml(item.code || '-') + '</td>' +
                '<td>' + pmEscHtml(item.name || '') + noteHtml + '</td>' +
                '<td class="text-right">' + Number(item.price || 0).toLocaleString('id-ID') + '</td>' +
                '</tr>'
            );
            $tr.data('item', item);
            $body.append($tr);
        });
    }

    function pmRenderSelected() {
        var $body = $('#pm-selected-body').empty();
        var keys = Object.keys(pmSelected);

        if (!keys.length) {
            $body.html(
                '<tr id="pm-selected-empty"><td colspan="4" style="text-align:center; color:#aaa; padding:12px; font-size:11px;">' +
                'Belum ada yang dipilih.</td></tr>'
            );
            return;
        }

        $.each(keys, function (i, key) {
            var item = pmSelected[key];
            $body.append(
                '<tr>' +
                '<td>' + pmEscHtml(item.code || '-') + '</td>' +
                '<td>' + pmEscHtml(item.name || '') + '</td>' +
                '<td class="text-right">' + Number(item.price || 0).toLocaleString('id-ID') + '</td>' +
                '<td class="text-center"><button type="button" class="btn btn-xs btn-danger pm-remove" data-key="' +
                pmEscHtml(key) + '">&times;</button></td>' +
                '</tr>'
            );
        });
    }

    function pmSearch(q) {
        $('#pm-list-body').html(
            '<tr><td colspan="4" style="text-align:center; color:#999; padding:14px;"><i class="fa fa-spinner fa-spin"></i> Mencari...</td></tr>'
        );

        $.getJSON(SEARCH_URL, { type: pmCategory, q: q, price_type: PRICE_TYPE })
            .done(function (res) {
                pmLastQuery = q;
                if (!res || !res.success) {
                    $('#pm-list-body').html(
                        '<tr><td colspan="4" style="text-align:center; color:#b91c1c; padding:14px; font-size:11px;">' +
                        pmEscHtml((res && res.message) || 'Gagal mencari data.') + '</td></tr>'
                    );
                    return;
                }
                pmRenderList(res.data);
            })
            .fail(function (xhr) {
                $('#pm-list-body').html(
                    '<tr><td colspan="4" style="text-align:center; color:#b91c1c; padding:14px; font-size:11px;">' +
                    'Gagal menghubungi server (' + xhr.status + ').</td></tr>'
                );
            });
    }

    function openPickerModal(cat) {
        pmCategory = cat;
        pmSelected = {};
        pmRenderSelected();
        $('#pm-modal-title').text(PM_TITLE[cat] || 'DAFTAR MASTER');
        $('#pm-search-input').val('');
        $('#modal-pilih-master-overlay').addClass('show');
        pmSearch('');
        setTimeout(function () { $('#pm-search-input').focus(); }, 50);
    }

    $('#pm-search-input').on('input', function () {
        var q = $.trim($(this).val());
        clearTimeout(pmSearchTimer);
        pmSearchTimer = setTimeout(function () { pmSearch(q); }, 250);
    });

    $(document).on('click', '#pm-list-body tr.pm-row', function () {
        if ($(this).data('already') == '1' || $(this).attr('data-already') === '1') { return; }

        var item = $(this).data('item');
        if (!item) { return; }

        var key = (item.code || '') + '||' + (item.name || '');
        var nowSelected = !pmSelected[key];

        if (nowSelected) { pmSelected[key] = item; } else { delete pmSelected[key]; }

        $(this).find('input[type="checkbox"]').prop('checked', nowSelected);
        $(this).toggleClass('pm-row-selected', nowSelected);
        pmRenderSelected();
    });

    $(document).on('click', '.pm-remove', function () {
        var key = $(this).data('key');
        delete pmSelected[key];
        pmRenderSelected();
        $('#pm-list-body tr').each(function () {
            var item = $(this).data('item');
            if (item && ((item.code || '') + '||' + (item.name || '')) === key) {
                $(this).find('input[type="checkbox"]').prop('checked', false);
                $(this).removeClass('pm-row-selected');
            }
        });
    });

    function closePickerModal() {
        $('#modal-pilih-master-overlay').removeClass('show');
    }

    $('#btn-cancel-master, #btn-batal-pilih-master').on('click', closePickerModal);
    $('#modal-pilih-master-overlay').on('click', function (e) {
        if (e.target === this) { closePickerModal(); }
    });

    $('#pm-link-manual').on('click', function (e) {
        e.preventDefault();
        closePickerModal();
        $('#new-item-cat').val(pmCategory);
        toggleMasterSearch();
        $('#modal-tambah-item-overlay').addClass('show');
        $('#new-item-name').focus();
    });

    $('#btn-ok-pilih-master').on('click', function () {
        var keys = Object.keys(pmSelected);
        if (!keys.length) {
            alert('Pilih minimal satu item terlebih dahulu.');
            return;
        }

        var $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        var requests = $.map(keys, function (key) {
            var item = pmSelected[key];
            return $.ajax({
                url: ADD_URL,
                method: 'POST',
                headers: { 'X-CSRF-Token': CSRF },
                dataType: 'json',
                data: {
                    action_category: pmCategory,
                    action_code: item.code || '',
                    action_name: item.name || '',
                    quantity: 1,
                    unit_price: item.price || 0,
                    notes: ''
                }
            });
        });

        $.when.apply($, requests).always(function () {
            location.reload();
        });
    });
});
</script>
<?php endif; ?>