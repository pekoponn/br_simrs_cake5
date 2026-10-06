<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leave $leave
 */
$dataRows = $data['dataRows'];
$dataDateFrom = date_format($dataRows->date_from, 'd M Y');
$dataDateEnd = date_format($dataRows->date_end, 'd M Y');
// $dataApprove = $dataRows->approved == null ? " - " : '<b>'.$dataRows->menyetujui->name.'</b><br> (<i>'.date_format($dataRows->approved_date, 'd-m-Y').'</i>)';
// $dataKnowing = $dataRows->knowing == null ? " - " : '<b>'.$dataRows->mengetahui->name.'</b><br> (<i>'.date_format($dataRows->knowing_date, 'd-m-Y').'</i>)';

$statusKnowingIcon = '';
if ($dataRows->status_knowing == 'Y') {
    $statusKnowingIcon = '<i class="fa fa-check text-success"></i><br>';
} elseif ($dataRows->status_knowing == 'N') {
    $statusKnowingIcon = '<i class="fa fa-times text-danger"></i><br>';
}
$dataKnowing = $dataRows->knowing == null
    ? ' - '
    : $statusKnowingIcon .
      '<b>'.$dataRows->mengetahui->name.'</b><br>
      (<i>'.date_format($dataRows->knowing_date, 'd-m-Y').'</i>)';

$statusApproveIcon = '';
if ($dataRows->status_approve == 'Y') {
    $statusApproveIcon = '<i class="fa fa-check text-success"></i><br>';
} elseif ($dataRows->status_approve == 'N') {
    $statusApproveIcon = '<i class="fa fa-times text-danger"></i><br>';
}
$dataApprove = $dataRows->approved == null
    ? ' - '
    : $statusApproveIcon .
      '<b>'.$dataRows->menyetujui->name.'</b><br>
      (<i>'.date_format($dataRows->approved_date, 'd-m-Y').'</i>)';
?>
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Data : <?= $dataRows->user->name ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <h3 class="text-center"><strong>Ijin Tidak Masuk</strong></h3>
            <br>
            <div class="row m-b-5 m-b-5">
                <div class="col-2 col-sm-2">
                    <b> Pemohon</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= $dataRows->user->name ?></i></div>
                <div class="col-2 col-sm-2">
                    <b> Devisi</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= $this->Krs->devision($dataRows->devision) ?></i></div>
            </div>
            <div class="row m-b-5 m-b-5">
                <div class="col-2 col-sm-2">
                    <b>Tanggal Mulai</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= $dataDateFrom; ?></i></div>
                <div class="col-2 col-sm-2">
                    <b>Tanggal Akhir</b>
                </div>
                <div class="col-4 col-sm-4">: <i><i><?= $dataDateEnd; ?></i></div>
            </div>
            <div class="row m-b-5 m-b-5">
                <div class="col-2 col-sm-2">
                    <b>Tipe Ijin</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= $dataRows->type ?></i></div>
            </div>
            <div class="row m-b-5 m-b-5">
                <div class="col-2 col-sm-2">
                    <b>Keterangan</b>
                </div>
                <div class="col-2 col-sm-2">:</div>
            </div>
            <div class="row m-b-5 m-b-5">
                <div class="col-12 col-sm-12">
                    <?= $this->Krs->fDecode($dataRows->description) ?>
                </div>
            </div>
            <?php if (!empty ($dataRows->desc_approve)) : ?>
            <div class="row m-b-5 m-b-5">
                <div class="col-2 col-sm-3">
                    <b>Catatan Approve</b>
                </div>
                <div class="col-2 col-sm-2">:</div>
            </div>
            <div class="row m-b-5 m-b-5">
                <div class="col-12 col-sm-12">
                    <?= $dataRows->desc_approve ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty ($dataRows->desc_knowing)) : ?>
            <div class="row m-b-5 m-b-5">
                <div class="col-2 col-sm-3">
                    <b>Catatan Mengetahui</b>
                </div>
                <div class="col-2 col-sm-2">:</div>
            </div>
            <div class="row m-b-5 m-b-5">
                <div class="col-12 col-sm-12">
                    <?= $dataRows->desc_knowing ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50%">Menyetujui</th>
                            <th width="50%">Mengetahui</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dataMenyetujuiName = (!empty($dataRows->menyetujui)) ? $dataRows->menyetujui->name:'';
                        $dataMengetahuiName = (!empty($dataRows->mengetahui)) ? $dataRows->mengetahui->name:'';
                            echo '<tr>';
                            echo '<td align="center">'.$dataApprove.'</td>';
                            echo '<td align="center">'.$dataKnowing.'</td>';
                            echo '</tr>';
                       ?>

                       
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>