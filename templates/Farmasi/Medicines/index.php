<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface $medicines
 * @var array $medicineGroups
 * @var string $filterGroup
 * @var string $filterActive
 * @var string $keyword
 */
?>

<div class="medicine-report">
    <div class="report-window">

        <div class="report-titlebar">
            <div>Master Data Obat</div>
            <div>
                <?= $this->Html->link(
                    'Tambah Obat',
                    ['action' => 'add'],
                    ['class' => 'btn btn-xs btn-light']
                ) ?>
            </div>
        </div>

        <div class="report-filter">
            <?= $this->Form->create(null, ['type' => 'get', 'id' => 'search-form-medicine']) ?>

            <div class="row">
                <div class="col-md-5">
                    <label>Pencarian</label>
                    <input type="text"
                           name="key"
                           class="form-control input-sm"
                           placeholder="Cari kode / nama obat / generic / KFA / IFRS..."
                           value="<?= h($keyword ?? '') ?>"
                           autocomplete="off"
                           id="search-q-med">
                </div>

                <div class="col-md-4">
                    <label>Kelompok</label>
                    <select name="medicine_group_id" class="form-control input-sm">
                        <option value="">Semua Kelompok</option>
                        <?php foreach (($medicineGroups ?? []) as $gId => $gName): ?>
                            <option value="<?= h($gId) ?>" <?= (($filterGroup ?? '') == $gId) ? 'selected' : '' ?>>
                                <?= h($gName) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Status</label>
                    <select name="is_active" class="form-control input-sm">
                        <option value="" <?= ($filterActive ?? '') === '' ? 'selected' : '' ?>>Semua</option>
                        <option value="Y" <?= ($filterActive ?? '') === 'Y' ? 'selected' : '' ?>>Aktif</option>
                        <option value="N" <?= ($filterActive ?? '') === 'N' ? 'selected' : '' ?>>Non Aktif</option>
                    </select>
                </div>
            </div>

            <div style="margin-top:8px; text-align:right;">
                <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                <?= $this->Html->link(
                    'Reset',
                    ['action' => 'index'],
                    ['class' => 'btn btn-default btn-sm']
                ) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>

        <div class="report-paper">
            <div class="report-heading">
                <h4>DAFTAR MASTER DATA OBAT</h4>
                <div>Semua Depo</div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered report-table">
                    <thead>
                        <tr>
                            <th width="35">No</th>
                            <th width="105">Kode Obat</th>
                            <th>Nama Obat</th>
                            <th width="130">Generic</th>
                            <th width="120">Kategori</th>
                            <th width="85">Satuan</th>
                            <th width="80">Qty</th>
                            <th width="110">HNA</th>
                            <th width="110">Harga Jual</th>
                            <th width="85">Min Stock</th>
                            <th width="85">Reorder</th>
                            <th width="75">Status</th>
                            <th width="95">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $arr = is_array($medicines) ? $medicines : $medicines->toArray();
                        $no = ($this->Paginator->current() - 1) * 20 + 1;
                        ?>

                        <?php if (empty($arr)): ?>
                            <tr>
                                <td colspan="13" class="text-center empty-row">
                                    Belum ada data obat.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($medicines as $medicine): ?>
                                <?php
                                $qty = (float)($medicine->unit_2_qty ?? 0);
                                $hna = (float)($medicine->hna ?? 0);
                                $hargaJual = (float)($medicine->harga_jual ?? 0);
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>

                                    <td><?= h($medicine->code ?? '-') ?></td>

                                    <td>
                                        <strong><?= h($medicine->name ?? '-') ?></strong>
                                        <?php if (!empty($medicine->code_kfa)): ?>
                                            <br><small>KFA: <?= h($medicine->code_kfa) ?></small>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= h($medicine->generic_name ?? '-') ?></td>

                                    <td><?= h($medicine->inventory_category ?? '-') ?></td>

                                    <td class="text-center"><?= h($medicine->unit_1 ?? '-') ?></td>

                                    <td class="text-right"><?= number_format($qty, 0, ',', '.') ?></td>

                                    <td class="text-right"><?= number_format($hna, 0, ',', '.') ?></td>

                                    <td class="text-right"><?= number_format($hargaJual, 0, ',', '.') ?></td>

                                    <td class="text-right"><?= number_format((float)($medicine->minimum_stock ?? 0), 0, ',', '.') ?></td>

                                    <td class="text-right"><?= number_format((float)($medicine->reorder_level ?? 0), 0, ',', '.') ?></td>

                                    <td class="text-center">
                                        <?php if ((string)($medicine->is_active ?? '') === 'Y' || (string)($medicine->is_active ?? '') === '1'): ?>
                                            <span class="status active">Aktif</span>
                                        <?php else: ?>
                                            <span class="status inactive">Non</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?= $this->Html->link(
                                            'View',
                                            ['action' => 'view', $medicine->id],
                                            ['class' => 'btn btn-info btn-xs']
                                        ) ?>

                                        <?= $this->Html->link(
                                            'Edit',
                                            ['action' => 'edit', $medicine->id],
                                            ['class' => 'btn btn-warning btn-xs']
                                        ) ?>
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
        </div>
    </div>
</div>

<style>
.medicine-report {
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
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-weight:700;
}

.btn-light {
    background:#f8f9fa;
    color:#333;
    border:1px solid #d9dee5;
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

.report-table small {
    color:#666;
}

.empty-row {
    padding:30px !important;
    color:#777;
}

.status {
    padding:2px 7px;
    border-radius:3px;
    font-size:10px;
    font-weight:700;
}

.status.active {
    background:#d1e7dd;
    color:#0f5132;
}

.status.inactive {
    background:#e9ecef;
    color:#495057;
}

.btn-xs {
    padding:2px 6px;
    font-size:11px;
}

.report-footer {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:12px;
}
</style>

<script>
$(document).ready(function () {
    var searchTimer;

    $('#search-q-med').on('input', function () {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(function () {
            $('#search-form-medicine').submit();
        }, 700);
    });
});
</script>