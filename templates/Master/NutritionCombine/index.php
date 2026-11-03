<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\NutritionCombine> $nutritionCombine
 */

$pages = (empty($this->request->getQuery('page')))
    ? ''
    : $this->request->getQuery('page');
?>

<?= $this->Krs->breadcrumb('Master', 'Nutrition Combine', 'Tampilkan') ?>

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

            Halaman <strong>Nutrition Combine</strong>,
            digunakan untuk data kombinasi kandungan gizi.

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
                                'placeholder' => 'Kode...',
                                'value' => $this->request->getQuery('filterCode')
                            ]
                        ); ?>

                    </div>

                    <div class="col-md-4 m-b-10">

                        <?= $this->Form->text(
                            'filterName',
                            [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Nama...',
                                'value' => $this->request->getQuery('filterName')
                            ]
                        ); ?>

                    </div>

                    <div class="col-md-3 m-b-10">

                        <?= $this->Form->select(
                            'filterContent',
                            $this->Krs->nutritionContent(),
                            [
                                'empty' => '-- Pilih Kandungan --',
                                'label' => false,
                                'class' => 'form-control select2Form',
                                'value' => $this->request->getQuery('filterContent')
                            ]
                        ); ?>

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

                            <th width="100">
                                Kode
                            </th>

                            <th>
                                Nama
                            </th>

                            <th width="180">
                                Kandungan Gizi
                            </th>

                            <th width="120">
                                Nilai
                            </th>

                            <th width="100">
                                Satuan
                            </th>

                            <th width="100">
                                Status
                            </th>

                            <th width="120" class="actions">
                                &nbsp;
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        if (count($nutritionCombine) > 0) {

                            foreach ($nutritionCombine as $rowData) {

                                $statusHiddenActive =
                                    ($rowData->is_active == 'Y')
                                    ? ""
                                    : ' style="display:none;"';

                                $statusHiddenInactive =
                                    ($rowData->is_active == 'N')
                                    ? ""
                                    : ' style="display:none;"';

                                $btnActive =
                                    "<div id='statusSpin" . $rowData->id . "'></div>";

                                $btnActive .=
                                    "<div id='statusActive" . $rowData->id . "'" . $statusHiddenActive . ">" .
                                    $this->Html->link(
                                        '<i class="fa fa-check"></i>',
                                        'javascript:;',
                                        [
                                            "escape" => false,
                                            "class" =>
                                                "btn btn-lime btn-icon btn-circle btn-sm"
                                        ]
                                    ) .
                                    "</div>";

                                $btnActive .=
                                    "<div id='statusInactive" . $rowData->id . "'" . $statusHiddenInactive . ">" .
                                    $this->Html->link(
                                        '<i class="fa fa-times"></i>',
                                        'javascript:;',
                                        [
                                            "escape" => false,
                                            "class" =>
                                                "btn btn-danger btn-icon btn-circle btn-sm"
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

                                    <td align="center">

                                        <b>
                                            <?= h($rowData->code) ?>
                                        </b>

                                    </td>

                                    <td>

                                        <?= h($rowData->name) ?>

                                    </td>

                                    <td align="center">

                                        <?= $this->Krs->nutritionContent(
                                            $rowData->nutrition_content_name
                                        ) ?>

                                    </td>

                                    <td align="center">

                                        <?= h($rowData->nutritional_value) ?>

                                    </td>

                                    <td align="center">

                                        <?= h($rowData->content_unit) ?>

                                    </td>

                                    <td align="center">

                                        <?= $btnActive ?>

                                    </td>

                                    <td class="actions" width="100">

                                        <?= $this->Krs->btn(
                                            'edit',
                                            $linkEdit
                                        ) ?>

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

<script type="text/javascript">

    $(document).ready(function () {

        $(".select2Form").select2();

    });

</script>