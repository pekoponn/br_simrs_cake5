<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient[]|\Cake\Collection\CollectionInterface $patients
 */

$pages = (empty($this->request->getQuery('page'))) ? '' : $this->request->getQuery('page');
$canViewPatients = !empty($checkUrl['patients']['view']);
$canViewPatientHistory = !empty($checkUrl['medicalrecords']['history']);
?>

<?= $this->Krs->breadcrumb('Master', 'Patient', 'Tampilkan') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">

        <h4 class="panel-title">
            Perincian
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;"
                class="btn btn-xs btn-icon btn-circle btn-default"
                data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>

    </div>

    <div class="panel-body">

        <div class="alert alert-primary">
            Halaman <strong>Patient</strong>, digunakan untuk data master pasien rumah sakit.
        </div>

        <div class="portlet-body form">

            <div class="table-toolbar">

                <div class="btn-group">

                    <div class="portlet-body">

                        <?= $this->Html->link(
                            '<i class="fa fa-plus"></i>',
                            ['action' => 'add', $pages],
                            [
                                'class' => 'btn btn-inverse',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Add',
                                'escape' => false,
                                'fullBase' => true
                            ]
                        ) ?>

                    </div>

                </div>

            </div>

            <br>

            <?= $this->Form->create(null, ['type' => 'get']) ?>

            <div class="panel-footer bg-aqua text-white p-t-10">

                <div class="row row-space-10">

                    <div class="col-md-2 m-b-10">

                        <?= $this->Form->text(
                            'filterCode',
                            [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'No RM / Kode...',
                                'value' => $filterCode ?? $this->request->getQuery('filterCode')
                            ]
                        ); ?>

                    </div>

                    <div class="col-md-3 m-b-10">

                        <?= $this->Form->text(
                            'filterName',
                            [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Nama Pasien...',
                                'value' => $filterName ?? $this->request->getQuery('filterName')
                            ]
                        ); ?>

                    </div>

                    <div class="col-md-2 m-b-10">

                        <?= $this->Form->text(
                            'filterIdentity',
                            [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'No Identitas...',
                                'value' => $filterIdentity ?? $this->request->getQuery('filterIdentity')
                            ]
                        ); ?>

                    </div>

                    <div class="col-md-2 m-b-10">

                        <?= $this->Form->text(
                            'filterPhone',
                            [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Telepon...',
                                'value' => $filterPhone ?? $this->request->getQuery('filterPhone')
                            ]
                        ); ?>

                    </div>

                    <div class="col-md-2 m-b-10">

                        <?= $this->Form->select(
                            'filterStatus',
                            [
                                'Y' => 'Aktif',
                                'N' => 'Tidak Aktif',
                            ],
                            [
                                'empty' => 'Semua Status',
                                'class' => 'form-control',
                                'value' => $filterStatus ?? $this->request->getQuery('filterStatus')
                            ]
                        ); ?>

                    </div>

                    <div class="col-md-1">

                        <?= $this->Krs->btnSeach(); ?>

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
                                'data-original-title' => 'Reset Filter'
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

                            <th width="105">
                                Kode Pasien
                            </th>

                            <th width="120">
                                No RM
                            </th>

                            <th>
                                Nama Pasien
                            </th>

                            <th width="120">
                                Identitas
                            </th>

                            <th width="150">
                                No Identitas
                            </th>

                            <th width="80">
                                Gender
                            </th>

                            <th width="80">
                                Gol. Darah
                            </th>

                            <th width="120">
                                Tgl Lahir
                            </th>

                            <th width="150">
                                Phone
                            </th>

                            <th width="120">
                                Agama
                            </th>

                            <th width="120">
                                Status
                            </th>

                            <th width="220" class="actions">
                                &nbsp;
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        if (count($patients) > 0) {

                            foreach ($patients as $rowData) {

                                $statusHiddenActive = ($rowData->is_active == 'Y') ? "" : ' style="display:none;"';
                                $statusHiddenInactive = ($rowData->is_active == 'N') ? "" : ' style="display:none;"';

                                $btnActive = "<div id='statusSpin" . $rowData->id . "'></div>";

                                $btnActive .= "<div id='statusActive" . $rowData->id . "'" . $statusHiddenActive . ">" .
                                    $this->Html->link(
                                        '<i class="fa fa-check"></i>',
                                        'javascript:;',
                                        [
                                            "escape" => false,
                                            "class" => "btn btn-lime btn-icon btn-circle btn-sm"
                                        ]
                                    ) .
                                    "</div>";

                                $btnActive .= "<div id='statusInactive" . $rowData->id . "'" . $statusHiddenInactive . ">" .
                                    $this->Html->link(
                                        '<i class="fa fa-times"></i>',
                                        'javascript:;',
                                        [
                                            "escape" => false,
                                            "class" => "btn btn-danger btn-icon btn-circle btn-sm"
                                        ]
                                    ) .
                                    "</div>";

                                if ($rowData->is_active == 'Y') {

                                    $classCondition = "";
                                } else {

                                    $classCondition = 'class="table-warning"';
                                }

                                $linkEdit = ['action' => 'edit', $rowData->id];
                                $linkView = ['action' => 'view', $rowData->id];
                                $linkDelete = ['action' => 'delete', $rowData->id];
                                $linkHistory = ['controller' => 'MedicalRecords', 'action' => 'history', $rowData->id];
                        ?>

                                <tr <?= $classCondition ?>>

                                    <td align="center">
                                        <b><?= h($rowData->code) ?></b>
                                    </td>

                                    <td align="center">
                                        <b><?= h($rowData->medical_record_no ?? $rowData->code ?? '-') ?></b>
                                    </td>

                                    <td>
                                        <?= h($rowData->full_name) ?>
                                    </td>

                                    <td align="center">
                                        <?= h($rowData->identity_type) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->identity_number) ?>
                                    </td>

                                    <td align="center">
                                        <?= h($rowData->gender) ?>
                                    </td>

                                    <td align="center">
                                        <?= h($rowData->blood_type) ?>
                                    </td>

                                    <td align="center">
                                        <?= !empty($rowData->birth_date) ? $rowData->birth_date->format('Y-m-d') : '-' ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->phone_number) ?>
                                    </td>

                                    <td align="center">
                                        <?= h($rowData->religion) ?>
                                    </td>

                                    <td align="center">
                                        <?= $btnActive ?>
                                    </td>

                                    <td class="actions text-center" style="white-space: nowrap;">

                                        <?php if ($canViewPatients): ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-eye"></i>',
                                                $linkView,
                                                [
                                                    'class' => 'btn btn-yellow btn-sm m-r-5 p-l-15 p-r-15',
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'data-original-title' => 'Lihat'
                                                ]
                                            ) ?>
                                        <?php endif; ?>

                                        <?= $this->Krs->btn('edit', $linkEdit) ?>

                                        <?php if ($canViewPatientHistory): ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-history"></i>',
                                                $linkHistory,
                                                [
                                                    'class' => 'btn btn-primary btn-sm m-r-5 p-l-15 p-r-15',
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'data-original-title' => 'Riwayat Pasien'
                                                ]
                                            ) ?>
                                        <?php endif; ?>

                                        <?= $this->Krs->btn('delete', $linkDelete, $rowData->full_name) ?>

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
