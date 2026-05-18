<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\HealthFacility> $healthFacilities
 */

$pages = (empty($this->request->getQuery('page')))
    ? ''
    : $this->request->getQuery('page');
?>

<?= $this->Krs->breadcrumb('Master', 'Health Facility', 'Tampilkan') ?>

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
            Halaman <strong>Health Facility</strong>, digunakan untuk data fasilitas kesehatan.
        </div>

        <div class="table-toolbar">

            <div class="btn-group">

                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i>',
                    ['action' => 'add', $pages],
                    [
                        'class' => 'btn btn-inverse',
                        'escape' => false,
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'data-original-title' => 'Tambah Data'
                    ]
                ) ?>

            </div>

        </div>

        <br>

        <?= $this->Form->create(null, ['type' => 'get']) ?>

        <div class="panel-footer bg-aqua text-white p-t-10">

            <div class="row row-space-10">

                <div class="col-md-3 m-b-10">

                    <?= $this->Form->text('filterCode', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kode...',
                        'value' => $this->request->getQuery('filterCode')
                    ]); ?>

                </div>

                <div class="col-md-4 m-b-10">

                    <?= $this->Form->text('filterName', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nama...',
                        'value' => $this->request->getQuery('filterName')
                    ]); ?>

                </div>

                <div class="col-md-1">

                    <?= $this->Krs->btnSeach(); ?>

                </div>

            </div>

        </div>

        <?= $this->Form->end() ?>

        <div class="table-responsive">

            <table class="table table-striped table-hover table-td-valign-middle">

                <thead class="thead-dark text-center">

                    <tr>
                        <th width="80">Kode</th>
                        <th width="100">Kode Internal</th>
                        <th>Nama</th>
                        <th width="120">Type</th>
                        <th width="120">Code PPK</th>
                        <th width="120" class="actions">&nbsp;</th>
                    </tr>

                </thead>

                <tbody>

                    <?php
                    if (count($healthFacilities) > 0) {

                        foreach ($healthFacilities as $rowData) {

                            if ($rowData->is_active == 'Y') {
                                $classCondition = '';
                                $status = '<span class="badge badge-success">Aktif</span>';
                            } else {
                                $classCondition = 'class="table-warning"';
                                $status = '<span class="badge badge-danger">Nonaktif</span>';
                            }
                            ?>

                            <tr <?= $classCondition ?>>

                                <td align="center">
                                    <b><?= h($rowData->code) ?></b>
                                </td>

                                <td align="center">
                                    <?= h($rowData->code_int) ?>
                                </td>

                                <td>
                                    <?= h($rowData->name) ?>
                                </td>

                                <td align="center">
                                    <?= h($rowData->type) ?>
                                </td>

                                <td align="center">
                                    <?= h($rowData->code_ppk) ?>
                                </td>

                                <td class="actions">

                                    <?= $this->Krs->btn(
                                        'edit',
                                        ['action' => 'edit', $rowData->id]
                                    ) ?>

                                    <?= $this->Krs->btn(
                                        'delete',
                                        ['action' => 'delete', $rowData->id],
                                        $rowData->name
                                    ) ?>

                                </td>

                            </tr>

                            <?php
                        }
                    } else {

                        echo $this->Krs->dataNull();

                    }
                    ?>

                </tbody>

            </table>

        </div>

        <?= $this->Krs->paginators() ?>

    </div>

</div>