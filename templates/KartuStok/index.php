<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicine|null $medicine
 * @var string $dateFrom
 * @var string $dateTo
 * @var array $stockMovements
 */
?>

<div class="stock-card-report">
    <div class="report-window">

        <div class="report-titlebar">
            <div>Kartu Stock</div>
        </div>

        <div class="report-filter no-print">
            <?= $this->Form->create(null, ['type' => 'get', 'id' => 'search-form-stockcard']) ?>

            <div class="row">
                <div class="col-md-5">
                    <label>Obat</label>
                    <div class="obat-picker-group">
                        <input type="text"
                               id="selected-obat-display"
                               class="form-control input-sm obat-picker-display"
                               placeholder="Belum ada obat dipilih"
                               readonly
                               value="<?= h(isset($medicine) ? $medicine->name . ' (' . $medicine->code . ')' : '') ?>">
                        <button type="button" id="btn-open-obat-modal" class="btn btn-primary btn-sm obat-picker-btn">
                            <i class="fa fa-search"></i> Cari Obat
                        </button>
                    </div>
                    <input type="hidden" name="medicine_id" id="medicine-id-input"
                           value="<?= h($medicine->id ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label>Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control input-sm"
                           value="<?= h($dateFrom) ?>">
                </div>

                <div class="col-md-3">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control input-sm"
                           value="<?= h($dateTo) ?>">
                </div>
            </div>

            <div style="margin-top:8px; text-align:right;">
                <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>

                <?php if (!empty($medicine)): ?>
                    <button type="button" id="btn-print-stockcard" class="btn btn-success btn-sm">
                        Cetak Kartu Stock
                    </button>
                <?php endif; ?>

                <?= $this->Html->link(
                    'Reset',
                    ['action' => 'index'],
                    ['class' => 'btn btn-default btn-sm']
                ) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>

        <!-- MODAL CARI OBAT -->
        <div id="obat-modal-overlay" class="obat-modal-overlay no-print">
            <div class="obat-modal-box">

                <div class="obat-modal-header">
                    <span>Cari Barang</span>
                    <button type="button" id="obat-modal-close-x" class="obat-modal-close-x">&times;</button>
                </div>

                <div class="obat-modal-body">
                    <input type="text"
                           id="obat-modal-search"
                           class="form-control input-sm"
                           placeholder="Ketik kode / nama obat / generic untuk mencari..."
                           autocomplete="off">

                    <div class="obat-modal-table-wrap">
                        <table class="table table-bordered table-hover obat-modal-table">
                            <thead>
                                <tr>
                                    <th width="120">Kode</th>
                                    <th>Nama Barang</th>
                                    <th width="100">Satuan</th>
                                </tr>
                            </thead>
                            <tbody id="obat-modal-tbody">
                                <tr>
                                    <td colspan="3" class="text-center empty-row">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="obat-modal-footer">
                    <button type="button" id="obat-modal-ok" class="btn btn-primary btn-sm">
                        <i class="fa fa-check"></i> Ok
                    </button>
                    <button type="button" id="obat-modal-close" class="btn btn-default btn-sm">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                </div>

            </div>
        </div>

        <div class="report-paper" id="printable-area">

            <div class="report-heading">
                <h4>KARTU STOCK</h4>
                <div><?= h($dateFrom) ?> s/d <?= h($dateTo) ?></div>
            </div>

            <?php if (empty($medicine)): ?>

                <div class="empty-state">
                    Silakan cari dan pilih obat terlebih dahulu untuk menampilkan kartu stock-nya.
                </div>

            <?php else: ?>

                <div class="stock-card-meta">
                    <table class="meta-table">
                        <tr>
                            <td class="meta-label">Kode Barang</td>
                            <td>: <?= h($medicine->code ?? '-') ?></td>
                            <td class="meta-label">Satuan</td>
                            <td>: <?= h($medicine->unit_1 ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="meta-label">Nama Barang</td>
                            <td>: <?= h($medicine->name ?? '-') ?></td>
                            <td class="meta-label">Hal</td>
                            <td>: 1 dari 1</td>
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered report-table">
                        <thead>
                            <tr>
                                <th rowspan="2" width="35">No</th>
                                <th rowspan="2" width="120">No. Bukti</th>
                                <th rowspan="2" width="85">Tanggal</th>
                                <th rowspan="2">Keterangan</th>
                                <th rowspan="2" width="150">Nama Dokter/Distributor</th>
                                <th rowspan="2" width="100">Nilai Pembelian</th>
                                <th rowspan="2" width="70">Adjust</th>
                                <th rowspan="2" width="70">Terima</th>
                                <th rowspan="2" width="70">Keluar</th>
                                <th rowspan="2" width="85">Saldo akhir</th>
                                <th colspan="2">Persediaan</th>
                            </tr>
                            <tr>
                                <th width="90">Nilai</th>
                                <th width="100">Total Nilai</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($stockMovements)): ?>
                                <tr>
                                    <td colspan="12" class="text-center empty-row">
                                        Belum ada data pergerakan stok untuk obat ini.<br>
                                        <small>(Alur transaksi terima/keluar stok belum diimplementasikan)</small>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; ?>
                                <?php foreach ($stockMovements as $row): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= h($row['no_bukti'] ?? '-') ?></td>
                                        <td class="text-center"><?= h($row['tanggal'] ?? '-') ?></td>
                                        <td><?= h($row['keterangan'] ?? '-') ?></td>
                                        <td><?= h($row['nama_dokter_distributor'] ?? '-') ?></td>
                                        <td class="text-right"><?= number_format((float)($row['nilai_pembelian'] ?? 0), 2, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format((float)($row['adjust'] ?? 0), 2, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format((float)($row['terima'] ?? 0), 2, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format((float)($row['keluar'] ?? 0), 2, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format((float)($row['saldo_akhir'] ?? 0), 2, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format((float)($row['persediaan_nilai'] ?? 0), 2, ',', '.') ?></td>
                                        <td class="text-right"><?= number_format((float)($row['persediaan_total_nilai'] ?? 0), 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<style>
.stock-card-report {
    font-size:12px;
}

.report-window {
    background:#d7e5f5;
    border:1px solid #9bb3cf;
}

.report-titlebar {
    background:#1e3a5f;
    color:#fff;
    padding:10px 12px;
    font-weight:700;
}

.report-filter {
    background:#eef4fb;
    padding:10px;
    border-bottom:1px solid #c7d4e5;
}

.report-filter label {
    font-weight:600;
    color:#1e3a5f;
}

.obat-picker-group {
    display:flex;
    align-items:stretch;
}

.obat-picker-display {
    border-top-right-radius:0 !important;
    border-bottom-right-radius:0 !important;
    background:#eceff3 !important;
    cursor:default;
}

.obat-picker-btn {
    flex-shrink:0;
    border-top-left-radius:0 !important;
    border-bottom-left-radius:0 !important;
    white-space:nowrap;
    font-weight:600;
}

/* ===== MODAL CARI OBAT ===== */
.obat-modal-overlay {
    display:none;
    position:fixed;
    top:0; left:0; right:0; bottom:0;
    background:rgba(0,0,0,.45);
    z-index:1050;
    align-items:center;
    justify-content:center;
}

.obat-modal-overlay.is-open {
    display:flex;
}

.obat-modal-box {
    background:#eef4fb;
    width:600px;
    max-width:92%;
    max-height:85vh;
    border:1px solid #7c93b3;
    box-shadow:0 8px 24px rgba(0,0,0,.35);
    display:flex;
    flex-direction:column;
    border-radius:2px;
    overflow:hidden;
}

.obat-modal-header {
    background:linear-gradient(#3a6ea5, #1e3a5f);
    color:#fff;
    padding:8px 12px;
    font-weight:700;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:13px;
}

.obat-modal-close-x {
    background:none;
    border:none;
    color:#fff;
    font-size:18px;
    line-height:1;
    cursor:pointer;
}

.obat-modal-body {
    padding:10px 12px;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    gap:8px;
}

.obat-modal-table-wrap {
    overflow-y:auto;
    max-height:360px;
    background:#fff;
    border:1px solid #c7d4e5;
}

.obat-modal-table {
    font-size:11px;
    margin-bottom:0;
    width:100%;
}

.obat-modal-table thead th {
    position:sticky;
    top:0;
    background:#dbe6f4;
    text-align:center;
    border:1px solid #b9c9dd !important;
    padding:5px 6px;
    z-index:1;
}

.obat-modal-table tbody td {
    border:1px solid #e3e8f0 !important;
    padding:4px 6px;
    cursor:pointer;
}

.obat-modal-table tbody tr:hover {
    background:#eef4fb;
}

.obat-modal-table tbody tr.selected {
    background:#a9c6ea !important;
}

.obat-modal-footer {
    padding:8px 12px;
    background:#eef4fb;
    border-top:1px solid #c7d4e5;
    text-align:right;
}

.obat-modal-footer .btn {
    margin-left:6px;
}

.report-paper {
    background:#fff;
    margin:12px;
    padding:18px;
    border:1px solid #bfc7d1;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.report-heading {
    text-align:center;
    margin-bottom:12px;
}

.report-heading h4 {
    margin:0 0 4px;
    font-weight:700;
}

.stock-card-meta {
    margin-bottom:12px;
}

.meta-table {
    font-size:12px;
}

.meta-table td {
    padding:2px 6px;
    border:none !important;
}

.meta-label {
    font-weight:600;
    width:110px;
}

.report-table {
    font-size:11px;
    color:#111;
}

.report-table thead tr {
    background:#f3f5f8;
}

.report-table th {
    text-align:center;
    vertical-align:middle !important;
    border:1px solid #333 !important;
}

.report-table td {
    border:1px solid #333 !important;
    vertical-align:middle !important;
    padding:5px 6px !important;
}

.empty-row {
    padding:30px !important;
    color:#777;
}

.empty-state {
    padding:40px;
    text-align:center;
    color:#777;
}

@media print {
    .no-print {
        display:none !important;
    }

    .report-titlebar {
        background:#fff !important;
        color:#000 !important;
        border-bottom:1px solid #000;
    }

    .report-window {
        background:#fff !important;
        border:none !important;
    }

    .report-paper {
        margin:0 !important;
        border:none !important;
        box-shadow:none !important;
    }
}
</style>

<script>
$(document).ready(function () {
    var searchUrl = '<?= $this->Url->build(['action' => 'searchMedicine']) ?>';
    var searchTimer;
    var selectedRow = null; // { id, code, name, unit_1 }

    var $overlay   = $('#obat-modal-overlay');
    var $tbody     = $('#obat-modal-tbody');
    var $modalSearch = $('#obat-modal-search');
    var $display   = $('#selected-obat-display');
    var $hiddenId  = $('#medicine-id-input');

    function loadObatList(keyword) {
        $tbody.html('<tr><td colspan="3" class="text-center empty-row">Memuat data...</td></tr>');

        $.getJSON(searchUrl, { key: keyword || '' }, function (data) {
            $tbody.empty();
            selectedRow = null;

            if (!data.length) {
                $tbody.html('<tr><td colspan="3" class="text-center empty-row">Data tidak ditemukan.</td></tr>');
                return;
            }

            $.each(data, function (i, item) {
                var $tr = $('<tr></tr>')
                    .attr('data-id', item.id)
                    .attr('data-code', item.code)
                    .attr('data-name', item.name)
                    .attr('data-unit', item.unit_1 || '');

                $tr.append($('<td></td>').text(item.code));
                $tr.append($('<td></td>').text(item.name));
                $tr.append($('<td class="text-center"></td>').text(item.unit_1 || '-'));

                $tr.on('click', function () {
                    $tbody.find('tr').removeClass('selected');
                    $(this).addClass('selected');
                    selectedRow = {
                        id: item.id,
                        code: item.code,
                        name: item.name,
                        unit_1: item.unit_1
                    };
                });

                $tr.on('dblclick', function () {
                    $(this).trigger('click');
                    confirmSelection();
                });

                $tbody.append($tr);
            });
        });
    }

    function openModal() {
        $overlay.addClass('is-open');
        $modalSearch.val('').trigger('focus');
        loadObatList('');
    }

    function closeModal() {
        $overlay.removeClass('is-open');
    }

    function confirmSelection() {
        if (!selectedRow) {
            return;
        }

        $display.val(selectedRow.name + ' (' + selectedRow.code + ')');
        $hiddenId.val(selectedRow.id);
        closeModal();
        $('#search-form-stockcard').submit();
    }

    $('#btn-open-obat-modal').on('click', openModal);
    $('#obat-modal-close').on('click', closeModal);
    $('#obat-modal-close-x').on('click', closeModal);
    $('#obat-modal-ok').on('click', confirmSelection);

    // klik di luar box (di area overlay) juga menutup modal
    $overlay.on('mousedown', function (e) {
        if (e.target === this) {
            closeModal();
        }
    });

    $modalSearch.on('input', function () {
        var keyword = $(this).val();
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            loadObatList(keyword);
        }, 350);
    });

    $('#btn-print-stockcard').on('click', function () {
        window.print();
    });
});
</script>