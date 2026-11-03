<?= $this->Krs->breadcrumb('Master', 'Cabang', 'Daftar') ?>

<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link(
                            '<i class="fa fa-plus"></i>',
                            ['action' => 'add'],
                            [
                                'class' => 'btn btn-inverse',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Add',
                                'escape' => false,
                                'fullBase' => true
                            ]
                        ) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime">
                                Download
                            </a>
                            <a href="javascript:(void);"
                            class="btn btn-lime dropdown-toggle"
                            id="dropdownMenuButton"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                                <i class="fa fa-download"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                href="<?= $this->Url->build(['action' => 'excel']); ?>">
                                    Excel File
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-aqua">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->control('filtercode', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Kode...',
                            'value' => $this->request->getQuery('filtercode')
                        ]) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtername', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Nama Cabang...',
                            'value' => $this->request->getQuery('filtername')
                        ]) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtercompany', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Nama Perusahaan...',
                            'value' => $this->request->getQuery('filtercompany')
                        ]) ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Krs->btnSeach() ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle cs">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Kode</th>
                            <th>Nama Cabang</th>
                            <th>Perusahaan</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php if (!empty($branches)) : ?>
                            <?php foreach ($branches as $branch) : ?>
                                <?php
                                    $id = $branch->id;
                                    $linkPreview = ['action' => 'view', $id];
                                    $linkEdit = ['action' => 'edit', $id];
                                    $linkDelete = ['action' => 'delete', $id];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= h($branch->code) ?></td>
                                    <td><?= h($branch->name) ?></td>
                                    <td><?= h($branch->company_name) ?></td>
                                    <td class="text-center">
                                        <?= $this->Krs->btn('preview', $linkPreview, $id); ?>   
                                        <?= $this->Krs->btn('edit', $linkEdit); ?>
                                        <?= $this->Krs->btn('delete', $linkDelete, $branch->name); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    Data tidak ditemukan
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<?php
$urlGetData = $this->Url->build(['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', '_full' => true]);
$urlStatusData = $this->Url->build(['prefix' => 'Pengaturan' , 'controller' => 'Branches', 'action' => 'changestatus', '_full' => true])
?>

<script>
$(document).ready(function() {

    <?php foreach ($branches as $rs) { ?>

        handleFormPreview(
            "btn-preview<?= $rs->id ?>",
            "<?= $urlGetData . '/' . $rs->id ?>"
        );

    <?php } ?>

});
</script>