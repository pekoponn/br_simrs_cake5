<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterIcd9 $masterIcd9
 */
?>

<?= $this->Krs->breadcrumb('Master', 'ICD-9 CM', 'Detail') ?>

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
                ['action' => 'edit', $masterIcd9->id],
                ['class' => 'btn btn-primary btn-sm', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default btn-sm', 'escape' => false]
            ) ?>
        </div>

        <table class="table table-bordered table-striped">
            <tr>
                <th width="220">Kode</th>
                <td><strong><?= h($masterIcd9->kode) ?></strong></td>
            </tr>
            <tr>
                <th>Nama ICD-9 CM</th>
                <td><?= h($masterIcd9->nama) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <?php if ((int)$masterIcd9->is_active === 1): ?>
                        <span class="label label-success">Aktif</span>
                    <?php else: ?>
                        <span class="label label-danger">Nonaktif</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Dibuat</th>
                <td><?= !empty($masterIcd9->created) ? h($masterIcd9->created->format('d-m-Y H:i')) : '-' ?></td>
            </tr>
            <tr>
                <th>Diubah</th>
                <td><?= !empty($masterIcd9->modified) ? h($masterIcd9->modified->format('d-m-Y H:i')) : '-' ?></td>
            </tr>
        </table>
    </div>
</div>
