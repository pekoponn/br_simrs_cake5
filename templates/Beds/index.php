<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed[]|\Cake\Collection\CollectionInterface $beds
 */
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Tampilkan') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">Data Bed Management</h4>

        <div class="panel-heading-btn">
            <a href="javascript:;"
                class="btn btn-xs btn-icon btn-circle btn-default"
                data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">

        <div class="portlet-body form">

            <!-- TOOLBAR -->
            <div class="table-toolbar">

                <div class="btn-group">
                    <div class="portlet-body">

                        <?= $this->Html->link(
                            '<i class="fa fa-plus"></i>',
                            ['controller' => 'Beds', 'action' => 'add'],
                            [
                                'class' => 'btn btn-inverse',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Tambah Bed',
                                'escape' => false,
                                'fullBase' => true
                            ]
                        ) ?>

                    </div>
                </div>

                <!-- SEARCH -->
                <div class="btn-group pull-right">
                    <div class="portlet-body">

                        <?= $this->Form->create(null, ['type' => 'get']) ?>

                        <div class="input-group">

                            <input
                                type="text"
                                class="form-control"
                                placeholder="Cari Bed / Room / Class..."
                                name="key"
                                value="<?= $this->request->getQuery('key'); ?>">

                            <button
                                name="filter"
                                class="btn btn-yellow"
                                type="submit"
                                data-toggle="tooltip"
                                data-placement="top"
                                data-original-title="Cari">
                                <i class="fa fa-search"></i>
                            </button>

                        </div>

                        <?= $this->Form->end() ?>

                    </div>
                </div>

            </div>

            <br>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-striped table-hover table-bordered table-td-valign-middle">

                    <thead class="thead-dark text-center">

                        <tr>
                            <th width="80">Code</th>
                            <th width="150">Room</th>
                            <th width="100">No Bed</th>
                            <th width="200">Nama Bed</th>
                            <th width="120">Class</th>
                            <th width="120">Status Bed</th>
                            <th width="100">Active</th>
                            <th width="150">Created</th>
                            <th width="170">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($beds as $bed): ?>

                            <?php

                            $linkView = ['action' => 'view', $bed->id];
                            $linkEdit = ['action' => 'edit', $bed->id];
                            $linkDelete = ['action' => 'delete', $bed->id];

                            $statusBed = '';

                            if ($bed->status == 1) {

                                $statusBed = '<span class="label label-success">Available</span>';
                            } else {

                                $statusBed = '<span class="label label-danger">Occupied</span>';
                            }

                            $statusActive = '';

                            if ($bed->is_active == 'Y') {

                                $statusActive = '<span class="label label-primary">Active</span>';
                            } else {

                                $statusActive = '<span class="label label-default">Non Active</span>';
                            }

                            $btnAction = '';

                            $btnAction .= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                $linkView,
                                [
                                    'class' => 'btn btn-info btn-sm',
                                    'escape' => false,
                                    'data-toggle' => 'tooltip',
                                    'data-original-title' => 'Detail'
                                ]
                            );

                            $btnAction .= $this->Html->link(
                                '<i class="fa fa-edit"></i>',
                                $linkEdit,
                                [
                                    'class' => 'btn btn-warning btn-sm',
                                    'escape' => false,
                                    'data-toggle' => 'tooltip',
                                    'data-original-title' => 'Edit'
                                ]
                            );

                            $btnAction .= ' ';

                            $btnAction .= $this->Form->postLink(
                                '<i class="fa fa-trash"></i>',
                                $linkDelete,
                                [
                                    'confirm' => __('Yakin ingin menghapus bed {0}?', $bed->name),
                                    'class' => 'btn btn-danger btn-sm',
                                    'escape' => false,
                                    'data-toggle' => 'tooltip',
                                    'data-original-title' => 'Delete'
                                ]
                            );

                            ?>

                            <tr>

                                <td align="center">
                                    <?= h($bed->code) ?>
                                </td>

                                <td>
                                    <?= h($bed->room->room_name ?? '-') ?>
                                </td>

                                <td align="center">
                                    <?= h($bed->bed_no) ?>
                                </td>

                                <td>
                                    <?= h($bed->name) ?>
                                </td>

                                <td align="center">
                                    <?= h($bed->class_name) ?>
                                </td>

                                <td align="center">
                                    <?= $statusBed ?>
                                </td>

                                <td align="center">
                                    <?= $statusActive ?>
                                </td>

                                <td align="center">
                                    <?= !empty($bed->created) ? date_format($bed->created, 'd-m-Y H:i') : '-' ?>
                                </td>

                                <td class="actions text-center">
                                    <?= $btnAction ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <?= $this->Krs->paginators() ?>

        </div>

    </div>

</div>