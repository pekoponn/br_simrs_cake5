<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Registration> $registrations
 */

$pages = (empty($this->request->getQuery('page')))
    ? ''
    : $this->request->getQuery('page');
$canViewPatientHistory = !empty($checkUrl['medicalrecords']['history']);
?>

<?= $this->Krs->breadcrumb('Registrasi', 'Registrasi Pasien', 'Tampilkan') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            Daftar Registrasi Pasien
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">

        <div class="alert alert-primary">
            Halaman <strong>Registrasi Pasien</strong>,
            digunakan untuk menampilkan data registrasi pasien.
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

                    <div class="col-md-4 m-b-10">
                        <?= $this->Form->text('q', [
                            'class' => 'form-control',
                            'placeholder' => 'Cari No Registrasi / Nama Pasien...',
                            'value' => $this->request->getQuery('q')
                        ]) ?>
                    </div>

                    <div class="col-md-2 m-b-10">
                        <?= $this->Form->text('date', [
                            'type' => 'date',
                            'class' => 'form-control',
                            'value' => $this->request->getQuery('date')
                        ]) ?>
                    </div>

                    <div class="col-md-2 m-b-10">
                        <?= $this->Form->select('service_type', [
                            'rawat_jalan' => 'Rawat Jalan',
                            'igd' => 'IGD',
                            'rawat_inap' => 'Rawat Inap',
                        ], [
                            'empty' => '-- Semua Pelayanan --',
                            'class' => 'form-control',
                            'value' => $this->request->getQuery('service_type')
                        ]) ?>
                    </div>

                    <div class="col-md-2 m-b-10">
                        <?= $this->Form->select('payment_method', [
                            'UMUM' => 'UMUM',
                            'ASURANSI' => 'ASURANSI',
                        ], [
                            'empty' => '-- Semua Bayar --',
                            'class' => 'form-control',
                            'value' => $this->request->getQuery('payment_method')
                        ]) ?>
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
                            <th width="50">No</th>
                            <th width="130">
                                <?= $this->Paginator->sort('registration_no', 'No Registrasi') ?>
                            </th>
                            <th width="120">Antrian</th>
                            <th width="110">
                                <?= $this->Paginator->sort('registration_date', 'Tgl Masuk') ?>
                            </th>
                            <th>Pasien</th>
                            <th width="120">
                                <?= $this->Paginator->sort('service_type', 'Pelayanan') ?>
                            </th>
                            <th width="130">Poli / Unit</th>
                            <th width="180">Dokter</th>
                            <th width="110">
                                <?= $this->Paginator->sort('payment_method', 'Cara Bayar') ?>
                            </th>
                            <th width="130">Penjamin</th>
                            <th width="90">
                                <?= $this->Paginator->sort('status', 'Status') ?>
                            </th>
                            <th width="220" class="actions">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (count($registrations) > 0) : ?>

                            <?php
                            $no = 1;

                            foreach ($registrations as $rowData) :

                                $serviceType = strtolower($rowData->service_type ?? '');

                                if ($serviceType == 'rawat_jalan') {
                                    $serviceLabel = 'Rawat Jalan';
                                } elseif ($serviceType == 'igd') {
                                    $serviceLabel = 'IGD';
                                } elseif ($serviceType == 'rawat_inap') {
                                    $serviceLabel = 'Rawat Inap';
                                } else {
                                    $serviceLabel = $rowData->service_type ?? '-';
                                }

                                $status = strtolower($rowData->status ?? '');

                                if ($status == 'aktif') {
                                    $statusBtn = '<span class="btn btn-lime btn-icon btn-circle btn-sm"><i class="fa fa-check"></i></span>';
                                    $classCondition = '';
                                } elseif ($status == 'batal') {
                                    $statusBtn = '<span class="btn btn-danger btn-icon btn-circle btn-sm"><i class="fa fa-times"></i></span>';
                                    $classCondition = 'class="table-warning"';
                                } elseif ($status == 'selesai') {
                                    $statusBtn = '<span class="btn btn-secondary btn-icon btn-circle btn-sm"><i class="fa fa-check"></i></span>';
                                    $classCondition = '';
                                } else {
                                    $statusBtn = '<span class="btn btn-default btn-icon btn-circle btn-sm"><i class="fa fa-minus"></i></span>';
                                    $classCondition = '';
                                }

                                $linkView = [
                                    'action' => 'view',
                                    $rowData->id
                                ];

                                $linkEdit = [
                                    'action' => 'edit',
                                    $rowData->id
                                ];

                                $linkDelete = [
                                    'action' => 'delete',
                                    $rowData->id
                                ];

                                $linkHistory = [
                                    'controller' => 'MedicalRecords',
                                    'action' => 'history',
                                    $rowData->patient_id
                                ];
                            ?>

                                <tr <?= $classCondition ?>>

                                    <td align="center">
                                        <?= $no++ ?>
                                    </td>

                                    <td align="center">
                                        <b>
                                            <?= h($rowData->registration_no ?? '-') ?>
                                        </b>
                                    </td>

                                    <td align="center">
                                        <?php if (!empty($rowData->polyclinic_queue_id)): ?>
                                            <span class="label label-success">Dari Antrian</span>
                                            <br>
                                            <small>
                                                <?= h($rowData->polyclinic_queue->code ?? '-') ?>
                                                <?php if (!empty($rowData->queue_number)): ?>
                                                    / No <?= h($rowData->queue_number) ?>
                                                <?php endif; ?>
                                            </small>
                                        <?php else: ?>
                                            <span class="label label-default">Langsung</span>
                                        <?php endif; ?>
                                    </td>

                                    <td align="center">
                                        <?php
                                        if (!empty($rowData->registration_date)) {
                                            echo date('d-m-Y', strtotime($rowData->registration_date));
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <b>
                                            <?= h($rowData->patient->full_name ?? $rowData->patient->name ?? '-') ?>
                                        </b>
                                        <br>
                                        <small>
                                            No RM: <?= h($rowData->patient->medical_record_no ?? $rowData->patient->code ?? '') ?>
                                            <?php if (!empty($rowData->patient->code)): ?>
                                                / Kode: <?= h($rowData->patient->code) ?>
                                            <?php endif; ?>
                                        </small>
                                    </td>

                                    <td align="center">
                                        <span class="label label-info">
                                            <?= h($serviceLabel) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= h(
                                            $rowData->polyclinic->polyclinic_name
                                                ?? $rowData->polyclinic->polyclinicname
                                                ?? $rowData->polyclinic_name
                                                ?? '-'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= h(
                                            $rowData->doctor->doctor_name
                                                ?? $rowData->doctor->name
                                                ?? '-'
                                        ) ?>
                                    </td>

                                    <td align="center">
                                        <span class="label label-warning">
                                            <?= h($rowData->payment_method ?? '-') ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= h(
                                            $rowData->insurance->name
                                                ?? $rowData->insurance_type
                                                ?? '-'
                                        ) ?>
                                    </td>

                                    <td align="center">
                                        <?= $statusBtn ?>
                                    </td>

                                    <td class="actions text-center" style="white-space: nowrap;">

                                        <!-- <?= $this->Html->link(
                                            '<i class="fa fa-eye"></i>',
                                            $linkView,
                                            [
                                                'class' => 'btn btn-info btn-icon btn-circle btn-sm',
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'data-original-title' => 'View'
                                            ]
                                        ) ?> -->

                                        <?= $this->Krs->btn(
                                            'edit',
                                            $linkEdit
                                        ) ?>

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

                                        <?= $this->Krs->btn(
                                            'delete',
                                            $linkDelete,
                                            $rowData->registration_no
                                        ) ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else : ?>

                            <?= $this->Krs->dataNull(); ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <?= $this->Krs->paginators() ?>

        </div>

    </div>

</div>
