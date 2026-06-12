<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan $masterTindakan
 */
?>

<?= $this->Krs->breadcrumb('Master', 'Tindakan', 'Detail') ?>

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
        <div class="m-b-15">
            <?= $this->Html->link(
                '<i class="fa fa-edit"></i> Edit',
                ['action' => 'edit', $masterTindakan->id],
                ['class' => 'btn btn-primary btn-sm', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default btn-sm', 'escape' => false]
            ) ?>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th width="220">Kode</th>
                    <td><strong><?= h($masterTindakan->kode) ?></strong></td>
                </tr>
                <tr>
                    <th>Nama Tindakan</th>
                    <td><?= h($masterTindakan->nama) ?></td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>
                        <span class="label label-info">
                            <?= h($masterTindakan->kategori ?: '-') ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tarif</th>
                    <td><strong>Rp <?= number_format((float)$masterTindakan->harga, 0, ',', '.') ?></strong></td>
                </tr>
                <tr>
                    <th>Satuan</th>
                    <td><?= h($masterTindakan->satuan ?: '-') ?></td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td><?= nl2br(h($masterTindakan->keterangan ?: '-')) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if ((int)$masterTindakan->is_active === 1): ?>
                            <span class="label label-success">
                                <i class="fa fa-check"></i> Aktif
                            </span>
                        <?php else: ?>
                            <span class="label label-danger">
                                <i class="fa fa-times"></i> Nonaktif
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Dibuat</th>
                    <td>
                        <?= !empty($masterTindakan->created)
                            ? h($masterTindakan->created->format('d-m-Y H:i'))
                            : '-' ?>
                    </td>
                </tr>
                <tr>
                    <th>Diubah</th>
                    <td>
                        <?= !empty($masterTindakan->modified)
                            ? h($masterTindakan->modified->format('d-m-Y H:i'))
                            : '-' ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
