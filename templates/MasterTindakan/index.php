<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan[]|\Cake\Collection\CollectionInterface $masterTindakan
 * @var array $kategoriList
 * @var string $q
 * @var string $kategori
 * @var string $isActive
 */

$kategoriOptions = ['' => 'Semua Kategori'] + $this->Krs->tindakanKategori();

$csrfToken = $this->request->getAttribute('csrfToken');
?>

<?= $this->Krs->breadcrumb('Master Data', 'Master Tindakan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-clipboard-list"></i> Master Tindakan
        </h4>
    </div>

    <div class="panel-body">

        <div class="filter-bar">
            <?= $this->Form->create(null, [
                'type' => 'get',
                'url' => ['action' => 'index'],
                'class' => 'filter-form',
                'style' => 'margin:0;',
            ]) ?>

            <div class="row" style="display:flex; align-items:flex-end;">
                <div class="col-md-4">
                    <label class="filter-label">
                        <i class="fa fa-search"></i> Cari
                    </label>
                    <?= $this->Form->text('q', [
                        'value' => $q,
                        'placeholder' => 'Nama / kode / keterangan...',
                        'class' => 'form-control input-sm',
                    ]) ?>
                </div>

                <div class="col-md-3">
                    <label class="filter-label">
                        <i class="fa fa-tags"></i> Kategori
                    </label>
                    <?= $this->Form->select('kategori', $kategoriOptions, [
                        'value' => $kategori,
                        'id' => 'filter-kategori',
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>

                <div class="col-md-2">
                    <label class="filter-label">
                        <i class="fa fa-toggle-on"></i> Status
                    </label>
                    <?= $this->Form->select('is_active', [
                        '' => 'Semua Status',
                        '1' => 'Aktif',
                        '0' => 'Nonaktif',
                    ], [
                        'value' => $isActive,
                        'id' => 'filter-is-active',
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>

                <div class="col-md-3">
                    <label>&nbsp;</label>
                    <div style="display:flex; gap:5px;">
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="fa fa-search"></i> Filter
                        </button>

                        <?= $this->Html->link(
                            '<i class="fa fa-times"></i> Reset',
                            ['action' => 'index'],
                            ['escape' => false, 'class' => 'btn btn-default btn-sm']
                        ) ?>

                        <?= $this->Html->link(
                            '<i class="fa fa-plus"></i> Tambah',
                            ['action' => 'add'],
                            ['escape' => false, 'class' => 'btn btn-inverse btn-sm']
                        ) ?>
                    </div>
                </div>
            </div>

            <?= $this->Form->end() ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-master" style="font-size:12px;">
                <thead>
                    <tr>
                        <th width="110"><?= $this->Paginator->sort('kode', 'Kode') ?></th>
                        <th><?= $this->Paginator->sort('nama', 'Nama Tindakan') ?></th>
                        <th width="150"><?= $this->Paginator->sort('kategori', 'Kategori') ?></th>
                        <th width="120"><?= $this->Paginator->sort('harga', 'Harga') ?></th>
                        <th width="90"><?= $this->Paginator->sort('satuan', 'Satuan') ?></th>
                        <th width="90"><?= $this->Paginator->sort('is_active', 'Status') ?></th>
                        <th width="130"><?= $this->Paginator->sort('modified', 'Diubah') ?></th>
                        <th width="95">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (empty($masterTindakan) || !count($masterTindakan)): ?>
                    <tr>
                        <td colspan="8" class="text-center" style="padding:30px; color:#777;">
                            Data tindakan tidak ditemukan
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($masterTindakan as $item): ?>
                        <tr class="tindakan-row">
                            <td class="text-center" style="font-family:monospace; font-weight:700;">
                                <?= h($item->kode) ?>
                            </td>

                            <td>
                                <div style="font-weight:600; color:#1f2937;">
                                    <?= h($item->nama) ?>
                                </div>

                                <?php if (!empty($item->keterangan)): ?>
                                    <div style="font-size:10px; color:#6b7280; margin-top:2px;">
                                        <?= h($item->keterangan) ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <span class="badge-category">
                                    <?= h($item->kategori ?: '-') ?>
                                </span>
                            </td>

                            <td class="text-right" style="font-weight:700;">
                                Rp <?= number_format((float)$item->harga, 0, ',', '.') ?>
                            </td>

                            <td class="text-center">
                                <?= h($item->satuan ?: '-') ?>
                            </td>

                            <td class="text-center">
                                <button type="button"
                                        class="toggle-active-btn <?= $item->is_active ? 'status-on' : 'status-off' ?>"
                                        data-id="<?= h($item->id) ?>"
                                        data-active="<?= (int)$item->is_active ?>">
                                    <?= $item->is_active ? 'Aktif' : 'Nonaktif' ?>
                                </button>
                            </td>

                            <td class="text-center" style="font-size:11px; color:#6c757d;">
                                <?= h($item->modified ? $item->modified->format('d/m/Y H:i') : '-') ?>
                            </td>

                            <td class="text-center" style="white-space:nowrap;">
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye"></i>',
                                    ['action' => 'view', $item->id],
                                    ['escape' => false, 'title' => 'Lihat', 'class' => 'btn-action']
                                ) ?>

                                <?= $this->Html->link(
                                    '<i class="fa fa-edit"></i>',
                                    ['action' => 'edit', $item->id],
                                    ['escape' => false, 'title' => 'Edit', 'class' => 'btn-action']
                                ) ?>

                                <?= $this->Form->postLink(
                                    '<i class="fa fa-trash"></i>',
                                    ['action' => 'delete', $item->id],
                                    [
                                        'escape' => false,
                                        'confirm' => __('Hapus tindakan "{0}"?', $item->nama),
                                        'title' => 'Hapus',
                                        'class' => 'btn-action btn-action-danger',
                                    ]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="paginator" style="margin-top:12px;">
            <ul class="pagination">
                <?= $this->Paginator->first('<< Awal') ?>
                <?= $this->Paginator->prev('< Sebelumnya') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('Berikutnya >') ?>
                <?= $this->Paginator->last('Akhir >>') ?>
            </ul>
            <p style="font-size:12px; color:#6c757d;">
                <?= $this->Paginator->counter('Halaman {{page}} dari {{pages}}, menampilkan {{current}} dari {{count}} data') ?>
            </p>
        </div>

    </div>
</div>

<style>
.filter-bar {
    background:#f8f9fa;
    border:1px solid #dee2e6;
    border-radius:8px;
    padding:12px 14px;
    margin-bottom:14px;
}

.filter-label {
    font-size:11px;
    font-weight:600;
    color:#555;
}

.table-master {
    margin-bottom:0;
}

.table-master > thead > tr > th {
    background:#1e3a5f !important;
    color:#fff !important;
    border-color:#2d4f7f !important;
    padding:8px 6px !important;
    vertical-align:middle !important;
    font-size:11px !important;
    font-weight:600 !important;
    text-align:center;
    white-space:nowrap;
}

/* tambahan ini yang menghilangkan kotak putih pada link sort */
.table-master > thead > tr > th a,
.table-master > thead > tr > th a:link,
.table-master > thead > tr > th a:visited {
    background:transparent !important;
    background-color:transparent !important;
    color:#fff !important;
    text-decoration:none !important;
    box-shadow:none !important;
    border:none !important;
    padding:0 !important;
    display:inline;
}

.table-master > thead > tr > th a:hover,
.table-master > thead > tr > th a:focus {
    background:transparent !important;
    color:#fff !important;
    text-decoration:underline !important;
}

/* jaga-jaga kalau Paginator menambahkan span/icon sort */
.table-master > thead > tr > th .asc,
.table-master > thead > tr > th .desc,
.table-master > thead > tr > th a.asc,
.table-master > thead > tr > th a.desc {
    background:transparent !important;
    color:#fff !important;
}

.table-master td {
    vertical-align:middle !important;
    padding:6px 8px !important;
    font-size:12px;
    border-color:#dee2e6 !important;
}

.table-master > tbody > tr:hover {
    background:#f0f9ff !important;
}

.badge-category {
    background:#e9ecef;
    border:1px solid #ced4da;
    color:#333;
    padding:2px 8px;
    border-radius:12px;
    font-size:11px;
    font-weight:600;
}

.toggle-active-btn {
    border:none;
    cursor:pointer;
    padding:3px 12px;
    border-radius:12px;
    font-size:11px;
    font-weight:700;
    color:#fff;
    min-width:70px;
}

.status-on {
    background:#198754;
}

.status-off {
    background:#6c757d;
}

.btn-action {
    display:inline-block;
    min-width:25px;
    width:25px;
    height:23px;
    line-height:21px;
    padding:0;
    margin:0 2px;
    text-align:center;
    font-size:11px;
    font-weight:600;
    border-radius:2px;
    border:1px solid #7d7d7d;
    background:#ececec;
    color:#333 !important;
    text-decoration:none !important;
}

.btn-action:hover {
    background:#dcdcdc;
    color:#000 !important;
}

.btn-action-danger {
    color:#8a1f1f !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-active-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = this.dataset.id;
            var el = this;

            fetch('/master-tindakan/toggle-active/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-Token': '<?= h($csrfToken) ?>',
                    'Content-Type': 'application/json'
                }
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    var isNowActive = parseInt(data.is_active) === 1;

                    el.dataset.active = isNowActive ? 1 : 0;
                    el.textContent = isNowActive ? 'Aktif' : 'Nonaktif';

                    if (isNowActive) {
                        el.classList.remove('status-off');
                        el.classList.add('status-on');
                    } else {
                        el.classList.remove('status-on');
                        el.classList.add('status-off');
                    }
                }
            });
        });
    });
});

$(document).ready(function () {
    $('.select2Form').select2({
        width: '100%',
        minimumResultsForSearch: 0
    });

    $(document).on('change', '.filter-form select', function () {
        $(this).closest('form').submit();
    });
});
</script>