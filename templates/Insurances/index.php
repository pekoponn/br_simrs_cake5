<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Insurance> $insurances
 */

$pages = (empty($this->request->getQuery('page')))
    ? ''
    : $this->request->getQuery('page');
?>

<?= $this->Krs->breadcrumb('Master', 'Insurance', 'Tampilkan') ?>

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

        <div class="alert alert-primary">
            Halaman <strong>Insurance</strong>, digunakan untuk data asuransi pasien
            dan kebutuhan transaksi pelayanan rumah sakit.
        </div>

        <div class="portlet-body form">

            <!-- BUTTON -->
            <div class="table-toolbar">

                <div class="btn-group">

                    <div class="portlet-body">

                        <?= $this->Html->link(
                            '<i class="fa fa-plus"></i>',
                            ['action' => 'add', $pages],
                            [
                                'class' => 'btn btn-inverse',
                                'escape' => false,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Add'
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

                    <div class="col-md-4 m-b-10">

                        <?= $this->Form->text(
                            'filterName',
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Nama Insurance...',
                                'value' => $this->request->getQuery('filterName')
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
                            <th width="80">Kode</th>
                            <th width="100">Region</th>
                            <th>Nama</th>
                            <th width="120">Tipe</th>
                            <th width="150">Bank</th>
                            <th width="150">No Rekening</th>
                            <th width="150">Atas Nama</th>
                            <th width="120">Phone RS</th>
                            <th width="180">Email RS</th>
                            <th width="80">Aktif</th>
                            <th width="120" class="actions">&nbsp;</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        if (count($insurances) > 0) {

                            foreach ($insurances as $rowData) {

                                $statusHiddenActive = ($rowData->is_active == 'Y')
                                    ? ""
                                    : ' style="display:none;"';

                                $statusHiddenInactive = ($rowData->is_active == 'N')
                                    ? ""
                                    : ' style="display:none;"';

                                $btnActive = "<div id='statusSpin" . $rowData->id . "'></div>";

                                $btnActive .= "
                                    <div id='statusActive" . $rowData->id . "' " . $statusHiddenActive . ">
                                        " . $this->Html->link(
                                            '<i class="fa fa-check"></i>',
                                            'javascript:;',
                                            [
                                                'escape' => false,
                                                'class' => 'btn btn-lime btn-icon btn-circle btn-sm'
                                            ]
                                        ) . "
                                    </div>
                                ";

                                $btnActive .= "
                                    <div id='statusInactive" . $rowData->id . "' " . $statusHiddenInactive . ">
                                        " . $this->Html->link(
                                            '<i class="fa fa-times"></i>',
                                            'javascript:;',
                                            [
                                                'escape' => false,
                                                'class' => 'btn btn-danger btn-icon btn-circle btn-sm'
                                            ]
                                        ) . "
                                    </div>
                                ";

                                $linkEdit = ['action' => 'edit', $rowData->id];
                                $linkDelete = ['action' => 'delete', $rowData->id];

                                if ($rowData->is_active == 'Y') {
                                    $classCondition = "";
                                } else {
                                    $classCondition = 'class="table-warning"';
                                }
                                ?>

                                <tr <?= $classCondition ?>>

                                    <td align="center">
                                        <b><?= h($rowData->code) ?></b>
                                    </td>

                                    <td align="center">
                                        <?= h($rowData->region) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->name) ?>
                                    </td>

                                    <td align="center">
                                        <?= h($rowData->type) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->bank_name) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->bank_account_number) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->bank_account_name) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->phone_number_rs) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->email_rs) ?>
                                    </td>

                                    <td align="center">
                                        <?= $btnActive ?>
                                    </td>

                                    <td class="actions" width="100">

                                        <?= $this->Krs->btn('edit', $linkEdit) ?>

                                        <?= $this->Krs->btn(
                                            'delete',
                                            $linkDelete,
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

</div>