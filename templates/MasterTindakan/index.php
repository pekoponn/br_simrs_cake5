<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan[]|\Cake\Collection\CollectionInterface $masterTindakan
 * @var array $kategoriList
 * @var string $q
 * @var string $kategori
 * @var string $isActive
 */

$q = $q ?? $this->request->getQuery('q', '');
$kategori = $kategori ?? $this->request->getQuery('kategori', '');
$isActive = $isActive ?? $this->request->getQuery('is_active', '');
$csrfToken = $this->request->getAttribute('csrfToken');

$kategoriOptions = ['' => 'Semua Kategori'];
foreach ($kategoriList as $kategoriRow) {
    $kategoriName = trim((string)($kategoriRow['kategori'] ?? ''));
    if ($kategoriName !== '') {
        $kategoriOptions[$kategoriName] = $kategoriName;
    }
}
?>

<?= $this->Krs->breadcrumb('Master', 'Tindakan', 'Tampilkan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="alert alert-primary">
            Halaman <strong>Master Tindakan</strong>, digunakan untuk mengelola tindakan, tarif, dan satuan pelayanan.
        </div>

        <div class="portlet-body form">
            <div class="table-toolbar">
                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i>',
                    ['action' => 'add'],
                    [
                        'class' => 'btn btn-inverse',
                        'escape' => false,
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'data-original-title' => 'Tambah',
                    ]
                ) ?>
            </div>

            <br>

            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                <div class="row row-space-10">
                    <div class="col-md-4 m-b-10">
                        <?= $this->Form->text('q', [
                            'class' => 'form-control',
                            'placeholder' => 'Cari kode, nama, atau keterangan...',
                            'value' => $q,
                        ]) ?>
                    </div>
                    <div class="col-md-3 m-b-10">
                        <?= $this->Form->select('kategori', $kategoriOptions, [
                            'class' => 'form-control',
                            'value' => $kategori,
                        ]) ?>
                    </div>
                    <div class="col-md-2 m-b-10">
                        <?= $this->Form->select('is_active', [
                            '' => 'Semua Status',
                            '1' => 'Aktif',
                            '0' => 'Nonaktif',
                        ], [
                            'class' => 'form-control',
                            'value' => $isActive,
                        ]) ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Krs->btnSeach() ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Html->link(
                            '<i class="fa fa-undo"></i>',
                            ['action' => 'index'],
                            [
                                'class' => 'btn btn-default',
                                'escape' => false,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Reset Filter',
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-td-valign-middle">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="110"><?= $this->Paginator->sort('kode', 'Kode') ?></th>
                            <th><?= $this->Paginator->sort('nama', 'Nama Tindakan') ?></th>
                            <th width="150"><?= $this->Paginator->sort('kategori', 'Kategori') ?></th>
                            <th width="130"><?= $this->Paginator->sort('harga', 'Tarif') ?></th>
                            <th width="100"><?= $this->Paginator->sort('satuan', 'Satuan') ?></th>
                            <th width="115"><?= $this->Paginator->sort('is_active', 'Status') ?></th>
                            <th width="145"><?= $this->Paginator->sort('modified', 'Diubah') ?></th>
                            <th width="150" class="actions">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($masterTindakan) > 0): ?>
                            <?php foreach ($masterTindakan as $rowData): ?>
                                <?php $rowClass = (int)$rowData->is_active === 1 ? '' : 'class="table-warning"'; ?>
                                <tr <?= $rowClass ?>>
                                    <td align="center"><b><?= h($rowData->kode) ?></b></td>
                                    <td>
                                        <b><?= h($rowData->nama) ?></b>
                                        <?php if (!empty($rowData->keterangan)): ?>
                                            <span class="text-muted" style="display:block; font-size:11px;">
                                                <?= h($rowData->keterangan) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td align="center">
                                        <span class="label label-info"><?= h($rowData->kategori ?: '-') ?></span>
                                    </td>
                                    <td align="right">
                                        <b>Rp <?= number_format((float)$rowData->harga, 0, ',', '.') ?></b>
                                    </td>
                                    <td align="center"><?= h($rowData->satuan ?: '-') ?></td>
                                    <td align="center">
                                        <button
                                            type="button"
                                            class="btn btn-xs toggle-active-btn <?= (int)$rowData->is_active === 1 ? 'btn-lime' : 'btn-danger' ?>"
                                            data-id="<?= h($rowData->id) ?>"
                                            data-active="<?= (int)$rowData->is_active ?>"
                                        >
                                            <i class="fa <?= (int)$rowData->is_active === 1 ? 'fa-check' : 'fa-times' ?>"></i>
                                            <?= (int)$rowData->is_active === 1 ? 'Aktif' : 'Nonaktif' ?>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <?= !empty($rowData->modified) ? h($rowData->modified->format('d-m-Y H:i')) : '-' ?>
                                    </td>
                                    <td class="actions text-center" style="white-space:nowrap;">
                                        <?= $this->Html->link(
                                            '<i class="fa fa-eye"></i>',
                                            ['action' => 'view', $rowData->id],
                                            [
                                                'class' => 'btn btn-yellow btn-sm m-r-5 p-l-15 p-r-15',
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'data-original-title' => 'Lihat',
                                            ]
                                        ) ?>
                                        <?= $this->Krs->btn('edit', ['action' => 'edit', $rowData->id]) ?>
                                        <?= $this->Krs->btn('delete', ['action' => 'delete', $rowData->id], $rowData->kode) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?= $this->Krs->dataNull() ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-active-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var currentButton = this;

            fetch('<?= $this->Url->build(['action' => 'toggleActive']) ?>/' + currentButton.dataset.id, {
                method: 'POST',
                headers: {
                    'X-CSRF-Token': '<?= h($csrfToken) ?>',
                    'Content-Type': 'application/json'
                }
            })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (!data.success) {
                    return;
                }

                var active = parseInt(data.is_active, 10) === 1;
                currentButton.dataset.active = active ? '1' : '0';
                currentButton.classList.toggle('btn-lime', active);
                currentButton.classList.toggle('btn-danger', !active);
                currentButton.innerHTML = '<i class="fa ' + (active ? 'fa-check' : 'fa-times') + '"></i> '
                    + (active ? 'Aktif' : 'Nonaktif');
            });
        });
    });
});
</script>
