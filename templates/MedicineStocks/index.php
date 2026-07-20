<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface $medicines
 * @var string $keyword
 * @var bool $onlyPositive
 * @var string $preset
 * @var string $sortBy
 */
?>

<div class="stock-info-report">
    <div class="report-window">

        <div class="report-titlebar">
            <div>Informasi Stock</div>
        </div>

        <div class="report-filter">
            <?= $this->Form->create(null, ['type' => 'get', 'id' => 'search-form-stockinfo']) ?>

            <div class="row">
                <div class="col-md-4">
                    <label>Cari Barang</label>
                    <input type="text"
                           name="key"
                           class="form-control input-sm"
                           placeholder="Cari kode / nama obat / generic..."
                           value="<?= h($keyword) ?>"
                           autocomplete="off"
                           id="search-q-stockinfo">
                </div>

                <div class="col-md-3">
                    <label>Gudang</label>
                    <?php
                    /**
                     * PLACEHOLDER: daftar gudang masih dari helper (data dummy),
                     * karena master Gudang/Depo belum dianalisis strukturnya.
                     * Filter berdasarkan gudang BELUM aktif -- tinggal
                     * disambungkan ke query controller begitu master gudang
                     * sudah fix (dan Informasi Stock sudah support multi-depo).
                     */
                    echo $this->Form->select('gudang', $this->Krs->gudangFarmasi(), [
                        'class' => 'form-control input-sm',
                        'empty' => 'Semua Gudang',
                        'disabled' => true,
                    ]);
                    ?>
                    <small class="text-muted">*sementara 1 gudang, belum aktif</small>
                </div>

                <div class="col-md-3" style="align-self:flex-end;">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="only_positive" value="1"
                               <?= $onlyPositive ? 'checked' : '' ?>>
                        Tampilkan Stock &gt; 0 Saja
                    </label>
                </div>

                <input type="hidden" name="preset" value="<?= h($preset) ?>">
                <input type="hidden" name="sort" value="<?= h($sortBy) ?>">
            </div>

            <div class="action-row">
                <button type="button" id="btn-tambah-stock" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Stock
                </button>

                <?= $this->Html->link(
                    '<i class="fa fa-exclamation-triangle"></i> Minimum Stock',
                    ['action' => 'index', '?' => ['preset' => 'min_stock', 'key' => $keyword]],
                    ['class' => 'btn btn-warning btn-sm', 'escape' => false]
                ) ?>

                <?= $this->Html->link(
                    '<i class="fa fa-minus-circle"></i> Validasi Saldo Minus',
                    ['action' => 'index', '?' => ['preset' => 'minus', 'key' => $keyword]],
                    ['class' => 'btn btn-danger btn-sm', 'escape' => false]
                ) ?>

                <?php if ($preset !== ''): ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-times"></i> Hapus Filter',
                        ['action' => 'index', '?' => ['key' => $keyword]],
                        ['class' => 'btn btn-default btn-sm', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>

            <?= $this->Form->end() ?>
        </div>

        <div class="report-paper">
            <div class="report-heading">
                <h4>INFORMASI STOCK OBAT</h4>
                <?php if ($preset === 'min_stock'): ?>
                    <div>Menampilkan obat dengan saldo &le; minimum stock</div>
                <?php elseif ($preset === 'minus'): ?>
                    <div>Menampilkan obat dengan saldo minus</div>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered report-table">
                    <thead>
                        <tr>
                            <th width="100">Kode Obat</th>
                            <th>Nama Obat</th>
                            <th width="70">Satuan</th>
                            <th width="90">Tgl SO Terakhir</th>
                            <th width="80">Hasil SO</th>
                            <th width="80">Adjustment</th>
                            <th width="70">Terima</th>
                            <th width="70">Keluar</th>
                            <th width="85">Saldo Akhir</th>
                            <th width="70">Min Stok</th>
                            <th width="70">Max Stok</th>
                            <th width="75">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $arr = is_array($medicines) ? $medicines : $medicines->toArray(); ?>

                        <?php if (empty($arr)): ?>
                            <tr>
                                <td colspan="12" class="text-center empty-row">
                                    Data obat tidak ditemukan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($medicines as $medicine): ?>
                                <?php
                                $stock = $medicine->medicine_stock ?? null;
                                $saldoAkhir = (float)($stock->saldo_akhir ?? 0);
                                $minStock = (float)($medicine->minimum_stock ?? 0);
                                $isMinus = $saldoAkhir < 0;
                                $isBelowMin = !$isMinus && $saldoAkhir <= $minStock;
                                $rowClass = $isMinus ? 'row-minus' : ($isBelowMin ? 'row-below-min' : '');
                                $isValid = ($stock->is_valid ?? 'N') === 'Y';
                                ?>
                                <tr class="<?= $rowClass ?>" data-medicine-id="<?= h($medicine->id) ?>">
                                    <td><?= h($medicine->code ?? '-') ?></td>
                                    <td><?= h($medicine->name ?? '-') ?></td>
                                    <td class="text-center"><?= h($medicine->unit_1 ?? '-') ?></td>
                                    <td class="text-center">
                                        <?= h($stock && $stock->last_so_date ? $stock->last_so_date->format('d-m-Y') : '-') ?>
                                    </td>
                                    <td class="text-right"><?= number_format((float)($stock->hasil_so ?? 0), 2, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format((float)($stock->adjustment ?? 0), 2, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format((float)($stock->terima ?? 0), 2, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format((float)($stock->keluar ?? 0), 2, ',', '.') ?></td>
                                    <td class="text-right"><strong><?= number_format($saldoAkhir, 2, ',', '.') ?></strong></td>
                                    <td class="text-right"><?= number_format($minStock, 2, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format((float)($stock->max_stock ?? 0), 2, ',', '.') ?></td>
                                    <td class="text-center">
                                        <button type="button"
                                                class="btn btn-xs btn-block btn-toggle-valid <?= $isValid ? 'btn-success' : 'btn-default' ?>"
                                                data-medicine-id="<?= h($medicine->id) ?>">
                                            <?= $isValid ? 'VALID' : 'BELUM' ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="report-footer">
                <div>
                    <?= $this->Paginator->counter(
                        'Menampilkan {{current}} dari {{count}} data (Halaman {{page}} / {{pages}})'
                    ) ?>
                </div>

                <ul class="pagination pagination-sm m-t-0 m-b-0">
                    <?= $this->Paginator->first('<<') ?>
                    <?= $this->Paginator->prev('<') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('>') ?>
                    <?= $this->Paginator->last('>>') ?>
                </ul>
            </div>

            <div class="sort-row">
                Urut berdasarkan:
                <label class="radio-inline">
                    <input type="radio" name="sort-radio" value="code" <?= $sortBy === 'code' ? 'checked' : '' ?>>
                    Kode Barang
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sort-radio" value="name" <?= $sortBy === 'name' ? 'checked' : '' ?>>
                    Nama Barang
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sort-radio" value="saldo_akhir" <?= $sortBy === 'saldo_akhir' ? 'checked' : '' ?>>
                    Saldo Akhir Stock
                </label>
            </div>
        </div>
    </div>
</div>

<style>
.stock-info-report {
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

.action-row {
    margin-top:12px;
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:8px;
}

.action-row .btn {
    font-weight:600;
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

.row-minus {
    background:#f8d7da !important;
}

.row-below-min {
    background:#fff3cd !important;
}

.empty-row {
    padding:30px !important;
    color:#777;
}

.report-footer {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:12px;
}

.sort-row {
    margin-top:10px;
    padding-top:10px;
    border-top:1px solid #e3e8f0;
    font-size:12px;
}

.sort-row label {
    font-weight:400;
    margin-left:10px;
}

.btn-toggle-valid {
    width:64px;
    font-weight:700;
}
</style>

<script>
$(document).ready(function () {

    // Search live (debounce) sama seperti halaman Medicines
    var searchTimer;
    $('#search-q-stockinfo').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            $('#search-form-stockinfo').submit();
        }, 700);
    });

    // checkbox "Tampilkan Stock > 0 Saja" langsung submit
    $('input[name="only_positive"]').on('change', function () {
        $('#search-form-stockinfo').submit();
    });

    // radio urut berdasarkan -> submit form dengan field sort tersembunyi
    $('input[name="sort-radio"]').on('change', function () {
        $('input[name="sort"]').val($(this).val());
        $('#search-form-stockinfo').submit();
    });

    // Toggle Valid / Belum via AJAX
    $(document).on('click', '.btn-toggle-valid', function () {
        var $btn = $(this);
        var medicineId = $btn.data('medicine-id');

        $btn.prop('disabled', true);

        $.post('<?= $this->Url->build(['action' => 'toggleValid']) ?>', { medicine_id: medicineId }, function (res) {
            if (res && res.success) {
                if (res.is_valid === 'Y') {
                    $btn.text('VALID').removeClass('btn-default').addClass('btn-success');
                } else {
                    $btn.text('BELUM').removeClass('btn-success').addClass('btn-default');
                }
            } else {
                alert('Gagal mengubah status valid.');
            }
        }, 'json').fail(function () {
            alert('Gagal menghubungi server.');
        }).always(function () {
            $btn.prop('disabled', false);
        });
    });

    // Placeholder: alur "Tambah Stock" (penerimaan/pembelian) belum
    // didefinisikan -- lihat catatan di KartuStokController.
    $('#btn-tambah-stock').on('click', function () {
        alert('Fitur Tambah Stock akan disambungkan setelah alur mutasi stok (penerimaan/pembelian) sudah ditentukan.');
    });
});
</script>