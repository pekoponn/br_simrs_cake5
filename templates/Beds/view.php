<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 */
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Detail') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            Detail Bed - <?= h($bed->name) ?>
        </h4>

        <div class="panel-heading-btn">

            <?= $this->Html->link(
                '<i class="fa fa-pencil"></i>',
                ['action' => 'edit', $bed->id],
                [
                    'class' => 'btn btn-xs btn-warning',
                    'escape' => false,
                    'data-toggle' => 'tooltip',
                    'data-original-title' => 'Edit'
                ]
            ) ?>

            <?= $this->Form->postLink(
                '<i class="fa fa-trash"></i>',
                ['action' => 'delete', $bed->id],
                [
                    'confirm' => __('Yakin ingin menghapus bed {0}?', $bed->name),
                    'class' => 'btn btn-xs btn-danger',
                    'escape' => false,
                    'data-toggle' => 'tooltip',
                    'data-original-title' => 'Delete'
                ]
            ) ?>

            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i>',
                ['action' => 'index'],
                [
                    'class' => 'btn btn-xs btn-default',
                    'escape' => false,
                    'data-toggle' => 'tooltip',
                    'data-original-title' => 'Kembali'
                ]
            ) ?>

        </div>
    </div>

    <div class="panel-body">

        <?php
        $statusBed = '';

        if ($bed->status == 0) {

            $statusBed =
                '<span class="label label-success">
                    Available / Kosong
                </span>';
        } else {

            $statusBed =
                '<span class="label label-danger">
                    Occupied / Terisi
                </span>';
        }

        $statusActive = '';

        if ($bed->is_active == 'Y') {

            $statusActive =
                '<span class="label label-primary">
                    Active
                </span>';
        } else {

            $statusActive =
                '<span class="label label-default">
                    Non Active
                </span>';
        }
        ?>

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <tr>
                    <th width="250">ID</th>
                    <td><?= h($bed->id) ?></td>
                </tr>

                <tr>
                    <th>Code Bed</th>
                    <td><?= h($bed->code) ?></td>
                </tr>

                <tr>
                    <th>Room</th>
                    <td>
                        <?= h($bed->room->room_name ?? '-') ?>
                    </td>
                </tr>

                <tr>
                    <th>Nomor Bed</th>
                    <td><?= h($bed->bed_no) ?></td>
                </tr>

                <tr>
                    <th>Nama Bed</th>
                    <td><?= h($bed->name) ?></td>
                </tr>

                <tr>
                    <th>Class</th>
                    <td><?= h($bed->class_name) ?></td>
                </tr>

                <tr>
                    <th>Status Bed</th>
                    <td><?= $statusBed ?></td>
                </tr>

                <tr>
                    <th>Status Active</th>
                    <td><?= $statusActive ?></td>
                </tr>

                <tr>
                    <th>Created</th>
                    <td>
                        <?= !empty($bed->created)
                            ? date_format($bed->created, 'd-m-Y H:i:s')
                            : '-' ?>
                    </td>
                </tr>

                <tr>
                    <th>Modified</th>
                    <td>
                        <?= !empty($bed->modified)
                            ? date_format($bed->modified, 'd-m-Y H:i:s')
                            : '-' ?>
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>