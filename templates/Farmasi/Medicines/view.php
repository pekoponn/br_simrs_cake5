<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicine $medicine
 */
?>

<div class="medicine-view">

    <div class="view-window">
        <div class="view-titlebar">
            <div>Detail Obat</div>
            <div>
                <?= $this->Html->link('EDIT', ['action' => 'edit', $medicine->id], ['class' => 'btn btn-warning btn-xs']) ?>
                <?= $this->Html->link('KEMBALI', ['action' => 'index'], ['class' => 'btn btn-default btn-xs']) ?>
            </div>
        </div>

        <div class="view-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="view-card">
                        <h5>Data Obat</h5>
                        <table class="table table-sm table-striped">
                            <tr><th>Kode Obat</th><td><?= h($medicine->code ?? '-') ?></td></tr>
                            <tr><th>Kode KFA</th><td><?= h($medicine->code_kfa ?? '-') ?></td></tr>
                            <tr><th>Kode IFRS</th><td><?= h($medicine->code_ifrs ?? '-') ?></td></tr>
                            <tr><th>Nama Obat</th><td><strong><?= h($medicine->name ?? '-') ?></strong></td></tr>
                            <tr><th>Nama Generic</th><td><?= h($medicine->generic_name ?? '-') ?></td></tr>
                            <tr><th>Kategori Inventory</th><td><?= h($medicine->inventory_category ?? '-') ?></td></tr>
                            <tr><th>Jenis</th><td><?= h($medicine->type ?? '-') ?></td></tr>
                            <tr><th>Gambar</th><td><?= h($medicine->img ?? '-') ?></td></tr>
                        </table>
                    </div>

                    <div class="view-card">
                        <h5>Satuan & Harga</h5>
                        <table class="table table-sm table-striped">
                            <tr><th>Satuan 1</th><td><?= h($medicine->unit_1 ?? '-') ?></td></tr>
                            <tr><th>Satuan 2</th><td><?= h($medicine->unit_2 ?? '-') ?> / <?= h($medicine->unit_2_qty ?? 0) ?> <?= h($medicine->unit_1 ?? '') ?></td></tr>
                            <tr><th>Satuan 3</th><td><?= h($medicine->unit_3 ?? '-') ?> / <?= h($medicine->unit_3_qty ?? 0) ?> <?= h($medicine->unit_1 ?? '') ?></td></tr>
                            <tr><th>HNA</th><td>Rp <?= number_format((float)($medicine->hna ?? 0), 0, ',', '.') ?> / <?= h($medicine->unit_1 ?? 'SATUAN') ?></td></tr>
                            <tr><th>PPN Status</th><td><?= ($medicine->ppn_status ?? 'N') === 'Y' ? 'Tidak Dikenakan PPN' : 'Dikenakan PPN' ?></td></tr>
                            <tr><th>HNA + PPN</th><td>Rp <?= number_format((float)($medicine->hna_ppn ?? 0), 0, ',', '.') ?> / <?= h($medicine->unit_1 ?? 'SATUAN') ?></td></tr>
                            <tr><th>Jenis Harga</th><td><?= h($medicine->jenis_harga ?? '-') ?></td></tr>
                            <tr><th>Harga Jual</th><td>Rp <?= number_format((float)($medicine->harga_jual ?? 0), 0, ',', '.') ?> / <?= h($medicine->unit_1 ?? 'SATUAN') ?></td></tr>
                            <tr><th>Harga Jual Jaminan</th><td>Rp <?= number_format((float)($medicine->harga_jual_jaminan ?? 0), 0, ',', '.') ?> / <?= h($medicine->unit_1 ?? 'SATUAN') ?></td></tr>
                            <tr><th>Nilai Persediaan</th><td>Rp <?= number_format((float)($medicine->nilai_persediaan_satuan ?? 0), 0, ',', '.') ?> / <?= h($medicine->unit_1 ?? 'SATUAN') ?></td></tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="view-card">
                        <h5>Informasi Farmasi</h5>
                        <table class="table table-sm table-striped">
                            <tr><th>Gol</th><td><?= h($medicine->gol ?? '-') ?></td></tr>
                            <tr><th>Kelas Terapi</th><td><?= h($medicine->therapy_class ?? '-') ?></td></tr>
                            <tr><th>Golongan</th><td><?= h($medicine->golongan ?? '-') ?></td></tr>
                            <tr><th>Pabrik</th><td><?= h($medicine->pabrik ?? '-') ?></td></tr>
                            <tr><th>Sediaan</th><td><?= h($medicine->sediaan ?? '-') ?></td></tr>
                            <tr><th>Supplier</th><td><?= h($medicine->supplier ?? '-') ?></td></tr>
                            <tr><th>Lead Time</th><td><?= h($medicine->lead_time ?? 0) ?></td></tr>
                            <tr><th>Depkes Link</th><td><?= h($medicine->depkes_link ?? '-') ?></td></tr>
                        </table>
                    </div>

                    <div class="view-card">
                        <h5>Stock Control</h5>
                        <table class="table table-sm table-striped">
                            <tr><th>Minimum Stock</th><td><?= number_format((float)($medicine->minimum_stock ?? 0), 0, ',', '.') ?> <?= h($medicine->unit_1 ?? 'SATUAN') ?></td></tr>
                            <tr><th>Reorder Level</th><td><?= number_format((float)($medicine->reorder_level ?? 0), 0, ',', '.') ?> <?= h($medicine->unit_1 ?? 'SATUAN') ?></td></tr>
                        </table>
                    </div>

                    <div class="view-card">
                        <h5>Status & Log</h5>
                        <table class="table table-sm table-striped">
                            <tr>
                                <th>Status Aktif</th>
                                <td>
                                    <?php if (($medicine->is_active ?? 'N') === 'Y' || (string)$medicine->is_active === '1'): ?>
                                        <span class="label label-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="label label-default">Non Aktif</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr><th>Is Create</th><td><?= h($medicine->is_create ?? 0) ?></td></tr>
                            <tr><th>Is Update</th><td><?= h($medicine->is_update ?? 0) ?></td></tr>
                            <tr><th>Is Print</th><td><?= h($medicine->is_print ?? 0) ?></td></tr>
                            <tr><th>Printed</th><td><?= !empty($medicine->printed) ? h($medicine->printed->format('d/m/Y H:i')) : '-' ?></td></tr>
                            <tr><th>Created</th><td><?= !empty($medicine->created) ? h($medicine->created->format('d/m/Y H:i')) : '-' ?></td></tr>
                            <tr><th>Modified</th><td><?= !empty($medicine->modified) ? h($medicine->modified->format('d/m/Y H:i')) : '-' ?></td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <?= $this->Form->postLink(
                    'HAPUS',
                    ['action' => 'delete', $medicine->id],
                    [
                        'class' => 'btn btn-danger btn-sm',
                        'confirm' => 'Yakin ingin menghapus obat "' . ($medicine->name ?? '') . '"?',
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>

<style>
.medicine-view { font-size:12px; }
.view-window {
    background:#fff;
    border:1px solid #dbe3ec;
    border-radius:8px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    overflow:hidden;
}
.view-titlebar {
    background:#1e3a5f;
    color:#fff;
    padding:11px 14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-weight:700;
}
.view-body {
    background:#eef3f8;
    padding:14px;
}
.view-card {
    background:#fff;
    border:1px solid #dbe3ec;
    border-radius:8px;
    padding:14px;
    margin-bottom:14px;
}
.view-card h5 {
    margin:0 0 10px;
    padding-bottom:8px;
    border-bottom:1px solid #dee2e6;
    color:#1e3a5f;
    font-weight:700;
}
.view-card table {
    margin-bottom:0;
}
.view-card th {
    width:38%;
    color:#495057;
}
.btn-xs {
    padding:2px 8px;
    font-size:11px;
}
</style>