<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NutritionCombine $dataRows
 */

$nutritionContent = !empty($dataRows->nutrition_content_name)
    ? $this->Krs->nutritionContent($dataRows->nutrition_content_name)
    : '';

$nutritionValue = !empty($dataRows->nutritional_value)
    ? $dataRows->nutritional_value
    : '0';

$contentUnit = $dataRows->content_unit ?? '';
?>

<div class="modal-dialog modal-lg">

    <div class="modal-content">

        <div class="modal-header">

            <h4 class="modal-title">

                Detail Data :
                <?= h($dataRows->code . ' - ' . $dataRows->name) ?>

            </h4>

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

                ×

            </button>

        </div>

        <div class="modal-body">

            <div class="row m-b-15">

                <div class="col-sm-12">

                    <div class="row">

                        <div class="col-2 col-sm-2">

                            <b>Kode</b>

                        </div>

                        <div class="col-4 col-sm-4">

                            : <?= h($dataRows->code) ?>

                        </div>

                        <div class="col-2 col-sm-2">

                            <b>Status</b>

                        </div>

                        <div class="col-4 col-sm-4">

                            :
                            <?= ($dataRows->is_active == 'Y')
                                ? '<span class="badge badge-success">Aktif</span>'
                                : '<span class="badge badge-danger">Nonaktif</span>' ?>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-2 col-sm-2">

                            <b>Nama</b>

                        </div>

                        <div class="col-10 col-sm-10">

                            : <?= h($dataRows->name) ?>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row m-b-15">

                <div class="col-sm-12">

                    <div class="table-responsive">

                        <table class="table m-b-0 table-advance table-hover" cellspacing="0" cellpadding="1" border="0"
                            align="center">

                            <thead class="thead-dark text-center">

                                <tr>

                                    <th width="50">
                                        NO
                                    </th>

                                    <th>
                                        KANDUNGAN GIZI
                                    </th>

                                    <th width="150">
                                        NILAI
                                    </th>

                                    <th width="120">
                                        SATUAN
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td align="center">
                                        1
                                    </td>

                                    <td>
                                        <?= h($nutritionContent) ?>
                                    </td>

                                    <td align="center">
                                        <?= h($nutritionValue) ?>
                                    </td>

                                    <td align="center">
                                        <?= h($contentUnit) ?>
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="row m-b-15">

                <div class="col-sm-12">

                    <b>Keterangan :</b>
                    <br>

                    <?= !empty($dataRows->description)
                        ? nl2br(h($dataRows->description))
                        : '-' ?>

                </div>

            </div>

            <div class="row">

                <div class="col-sm-6">

                    <b>Dibuat :</b>

                    <?= !empty($dataRows->created)
                        ? $this->Krs->fDate($dataRows->created, 'd-m-Y H:i')
                        : '-' ?>

                </div>

                <div class="col-sm-6">

                    <b>Diupdate :</b>

                    <?= !empty($dataRows->modified)
                        ? $this->Krs->fDate($dataRows->modified, 'd-m-Y H:i')
                        : '-' ?>

                </div>

            </div>

        </div>

        <div class="modal-footer">

            <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">

                Tutup

            </a>

        </div>

    </div>

</div>