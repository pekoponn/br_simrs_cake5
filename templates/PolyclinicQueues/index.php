<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue[]|\Cake\Collection\CollectionInterface $polyclinicQueues
 */

$pages = (empty($this->request->getQuery('page')))
    ? ''
    : $this->request->getQuery('page');
?>

<?= $this->Krs->breadcrumb('Pendaftaran', 'Polyclinic Queues', 'Tampilkan') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">

        <h4 class="panel-title">
            Perincian
        </h4>

        <div class="panel-heading-btn">

            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">

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

                        <!-- ADD WA -->
                        <?= $this->Html->link(
                            '<i class="fa fa-plus"> Tambah Antrian WA</i>',
                            ['action' => 'add', $pages],
                            [
                                'class' => 'btn btn-inverse',
                                'escape' => false,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Tambah Antrian WA'
                            ]
                        ) ?>

                        <!-- KIOSK -->
                        <?= $this->Html->link(
                            '<i class="fa fa-desktop"> Mesin Anjungan</i>',
                            ['action' => 'kiosk'],
                            [
                                'class' => 'btn btn-success',
                                'escape' => false,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Kiosk / Anjungan'
                            ]
                        ) ?>

                    </div>

                </div>

            </div>

            <br>

            <!-- SEARCH -->
            <?= $this->Form->create(null, ['type' => 'get']) ?>

            <div class="panel-footer bg-aqua text-white p-t-10">

                <div class="row row-space-10">

                    <div class="col-md-2 m-b-10">

                        <?= $this->Form->text(
                            'filterCode',
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Kode...',
                                'value' => $this->request->getQuery('filterCode')
                            ]
                        ) ?>

                    </div>

                    <div class="col-md-3 m-b-10">

                        <?= $this->Form->text(
                            'filterPatient',
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Nama Pasien...',
                                'value' => $this->request->getQuery('filterPatient')
                            ]
                        ) ?>

                    </div>

                    <div class="col-md-3 m-b-10">

                        <?= $this->Form->text(
                            'filterPoly',
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Nama Poli...',
                                'value' => $this->request->getQuery('filterPoly')
                            ]
                        ) ?>

                    </div>

                    <div class="col-md-1">

                        <?= $this->Krs->btnSeach(); ?>

                    </div>

                </div>

            </div>

            <?= $this->Form->end() ?>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-striped table-hover table-td-valign-middle">

                    <thead class="thead-dark text-center">

                        <tr>

                            <th width="80">
                                Kode
                            </th>

                            <th width="100">
                                Source
                            </th>

                            <th>
                                Poli
                            </th>

                            <th>
                                Nama Pasien
                            </th>

                            <th width="150">
                                No. Telp
                            </th>

                            <th width="100">
                                Queue
                            </th>

                            <th width="150">
                                Created
                            </th>

                            <th width="80">
                                Aktif
                            </th>

                            <th width="120" class="actions">
                                &nbsp;
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        if (count($polyclinicQueues) > 0) {

                            foreach ($polyclinicQueues as $rowData) {

                                $statusHiddenActive =
                                    ($rowData->is_active == 'Y')
                                    ? ''
                                    : ' style="display:none;"';

                                $statusHiddenInactive =
                                    ($rowData->is_active == 'N')
                                    ? ''
                                    : ' style="display:none;"';

                                $btnActive = "";

                                $btnActive .=
                                    "<div id='statusActive" . $rowData->id . "'" . $statusHiddenActive . ">" .
                                    $this->Html->link(
                                        '<i class=\"fa fa-check\"></i>',
                                        'javascript:;',
                                        [
                                            'escape' => false,
                                            'class' =>
                                                'btn btn-lime btn-icon btn-circle btn-sm'
                                        ]
                                    ) .
                                    "</div>";

                                $btnActive .=
                                    "<div id='statusInactive" . $rowData->id . "'" . $statusHiddenInactive . ">" .
                                    $this->Html->link(
                                        '<i class=\"fa fa-times\"></i>',
                                        'javascript:;',
                                        [
                                            'escape' => false,
                                            'class' =>
                                                'btn btn-danger btn-icon btn-circle btn-sm'
                                        ]
                                    ) .
                                    "</div>";

                                if ($rowData->is_active == 'Y') {
                                    $classCondition = "";
                                } else {
                                    $classCondition = 'class="table-warning"';
                                }

                                $linkEdit = [
                                    'action' => 'edit',
                                    $rowData->id
                                ];

                                $linkDelete = [
                                    'action' => 'delete',
                                    $rowData->id
                                ];
                                ?>

                                <tr <?= $classCondition ?>>

                                    <td>
                                        <b><?= h($rowData->code) ?></b>
                                    </td>

                                    <td>
                                        <?= h($rowData->source) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->poly_name) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->patients_name) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->no_telp) ?>
                                    </td>

                                    <td align="center">
                                        <?= h($rowData->queue_number) ?>
                                    </td>

                                    <td>
                                        <?= $this->Krs->fDate(
                                            $rowData->created,
                                            'd-m-Y H:i'
                                        ) ?>
                                    </td>

                                    <td align="center">
                                        <?= $btnActive ?>
                                    </td>

                                    <td class="actions">

                                        <?= $this->Krs->btn(
                                            'edit',
                                            $linkEdit
                                        ) ?>

                                        <?= $this->Krs->btn(
                                            'delete',
                                            $linkDelete,
                                            $rowData->code
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

</div>