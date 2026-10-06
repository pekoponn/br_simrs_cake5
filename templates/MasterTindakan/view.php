<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan $masterTindakan
 */

$shareLabelMap = ['rs_dr' => 'RS+DR', 'rs' => 'RS', 'dr' => 'DR'];

$priceGroups = [
    'umum'    => ['label' => 'Umum',      'color' => '#155724', 'bg' => '#d4edda'],
    'bpjs'    => ['label' => 'BPJS',      'color' => '#0c5460', 'bg' => '#cff4fc'],
    'reimbes' => ['label' => 'Reimburse', 'color' => '#856404', 'bg' => '#fff3cd'],
];
?>

<?= $this->Krs->breadcrumb('Master Data', 'Detail Master Tindakan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-clipboard-list"></i> Detail Master Tindakan
        </h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <div class="panel-body">

        <!-- Header ringkas -->
        <div class="mt-view-header">
            <div>
                <h3 class="mt-view-title"><?= h($masterTindakan->nama) ?></h3>
                <code class="mt-view-code"><?= h($masterTindakan->kode) ?></code>
            </div>
            <span class="label <?= $masterTindakan->is_active ? 'label-success' : 'label-default' ?>">
                <?= $masterTindakan->is_active ? 'Aktif' : 'Tidak Aktif' ?>
            </span>
        </div>

        <!-- Kategori & Keterangan -->
        <div class="table-responsive mt-detail-wrap">
            <table class="table table-bordered mt-detail-table">
                <tbody>
                    <tr>
                        <th><i class="fa fa-tags"></i> Kategori</th>
                        <td>
                            <span class="badge-category">
                                <?= h($masterTindakan->kategori ?: '-') ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-align-left"></i> Keterangan</th>
                        <td><?= nl2br(h($masterTindakan->keterangan ?: '-')) ?></td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-calendar-plus"></i> Dibuat</th>
                        <td class="text-muted">
                            <?= h($masterTindakan->created ? $masterTindakan->created->format('d F Y, H:i:s') : '-') ?>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-calendar-check"></i> Terakhir Diubah</th>
                        <td class="text-muted">
                            <?= h($masterTindakan->modified ? $masterTindakan->modified->format('d F Y, H:i:s') : '-') ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Harga per jenis jaminan -->
        <div class="row">
            <?php foreach ($priceGroups as $key => $g):
                $harga  = $masterTindakan->{'harga_' . $key} ?? 0;
                $persen = $masterTindakan->{'persen_dokter_' . $key} ?? 0;
                $share  = $masterTindakan->{'share_type_' . $key} ?? 'rs_dr';
                $komisi = $harga * $persen / 100;
                $jasaRs = $harga - $komisi;
            ?>
                <div class="col-md-4">
                    <div class="mt-price-card" style="border-top:3px solid <?= $g['color'] ?>;">
                        <div class="mt-price-card-title" style="color:<?= $g['color'] ?>;">
                            <?= h($g['label']) ?>
                        </div>

                        <div class="mt-price-main">
                            Rp <?= number_format((float)$harga, 0, ',', '.') ?>
                        </div>

                        <div class="mt-price-sub">
                            <span>% Dokter</span>
                            <strong><?= number_format((float)$persen, 0) ?>%</strong>
                        </div>
                        <div class="mt-price-sub">
                            <span>Share Type</span>
                            <strong style="background:<?= $g['bg'] ?>; color:<?= $g['color'] ?>;
                                         padding:1px 8px; border-radius:10px;">
                                <?= $shareLabelMap[$share] ?? $share ?>
                            </strong>
                        </div>

                        <div class="mt-price-result">
                            <div>
                                <span>Komisi Dokter</span>
                                <strong>Rp <?= number_format($komisi, 0, ',', '.') ?></strong>
                            </div>
                            <div>
                                <span>Jasa RS</span>
                                <strong>Rp <?= number_format($jasaRs, 0, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-actions">
            <?= $this->Form->postLink(
                '<i class="fa fa-ban"></i> Hapus',
                ['action' => 'delete', $masterTindakan->id],
                [
                    'escape'  => false,
                    'class'   => 'btn btn-danger btn-sm',
                    'confirm' => __('Hapus tindakan "{0}"?', $masterTindakan->nama),
                    'style'   => 'margin-right:auto;',
                ]
            ) ?>

            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali ke Daftar',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>

            <?= $this->Html->link(
                '<i class="fa fa-edit"></i> Edit Tindakan',
                ['action' => 'edit', $masterTindakan->id],
                ['escape' => false, 'class' => 'btn btn-inverse btn-sm']
            ) ?>
        </div>

    </div>
</div>

<style>
.mt-view-header {
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    padding-bottom:14px;
    margin-bottom:14px;
    border-bottom:1px solid #dee2e6;
}
.mt-view-title {
    margin:0 0 4px;
    color:#1e3a5f;
    font-weight:800;
}
.mt-view-code {
    background:#e9ecef;
    padding:3px 10px;
    border-radius:6px;
    font-size:12px;
    font-weight:700;
    color:#1e3a5f;
}
.mt-detail-wrap {
    border:1px solid #dee2e6;
    border-radius:6px;
    overflow:hidden;
    margin-bottom:16px;
}
.mt-detail-table {
    margin-bottom:0;
}
.mt-detail-table th {
    width:220px;
    background:#f8f9fa;
    color:#1e3a5f;
    font-weight:700;
    font-size:12px;
    vertical-align:middle;
}
.mt-detail-table td {
    vertical-align:middle;
    font-size:13px;
}
.badge-category {
    background:#e9ecef;
    border:1px solid #ced4da;
    color:#333;
    padding:3px 10px;
    border-radius:12px;
    font-size:11px;
    font-weight:600;
}
.label {
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
}
.label-success {
    background:#198754;
    color:#fff;
}
.label-default {
    background:#6c757d;
    color:#fff;
}
.mt-actions {
    display:flex;
    justify-content:flex-end;
    gap:6px;
    margin-top:16px;
}

.mt-price-card {
    background:#fff;
    border:1px solid #dee2e6;
    border-radius:6px;
    padding:12px 14px;
    margin-bottom:14px;
}
.mt-price-card-title {
    font-size:12px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.5px;
    margin-bottom:6px;
}
.mt-price-main {
    font-size:20px;
    font-weight:800;
    color:#1e3a5f;
    margin-bottom:8px;
}
.mt-price-sub {
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:12px;
    color:#6c757d;
    padding:3px 0;
}
.mt-price-sub strong {
    font-size:11px;
    font-weight:700;
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
</style>