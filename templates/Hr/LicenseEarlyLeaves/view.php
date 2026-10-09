<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leave $leave
 */
$dataRows = $data['dataRows'];
$dataDate = date_format($dataRows->date, 'd M Y');
$statusApprove = ($dataRows->status_approve == 'Y') ? '<i class="fas fa-check text-success"></i> ' : '<i class="fas fa-times text-danger"></i> ';
$dataApprove = $dataRows->approved == null ? " - " : $statusApprove . '<br><b>'.$dataRows->menyetujui->name.'</b><br>(<i>'.date_format($dataRows->approved, 'd-m-Y').'</i>)';
$statusKnowing = ($dataRows->status_knowing == 'Y') ? '<i class="fas fa-check text-success"></i> ' : '<i class="fas fa-times text-danger"></i> ';
$dataKnowing = $dataRows->knowing == null ? " - " : $statusKnowing . '<br><b>'.$dataRows->mengetahui->name.'</b> <br>(<i>'.date_format($dataRows->knowing, 'd-m-Y').'</i>)';
$dataJamKeluar = $dataRows->time_from == null ? " - " : $dataRows->time_from;
?>
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Data : <?= $dataRows->user->name ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <h3 class="text-center"><strong>Ijin Pulang Cepat</strong></h3>
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
                <div class="col-4 col-sm-4">: <i><?= $dataDate; ?></i></div>
                <div class="col-2 col-sm-2">
                    <b>Jam Keluar</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= $dataJamKeluar; ?></i></div>
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
            <?php if (!empty($dataRows->desc_approve)) : ?>
            <div class="row m-b-5">
                <div class="col-3 col-sm-3">
                    <b>Catatan Penyetuju</b>
                </div>
                <div class="col-1 col-sm-1">:</div>
            </div>
            <div class="row m-b-5">
                <div class="col-12 col-sm-12">
                    <?= nl2br(h($dataRows->desc_approve)) ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($dataRows->desc_knowing)) : ?>
            <div class="row m-b-5">
                <div class="col-3 col-sm-3">
                    <b>Catatan Mengetahui</b>
                </div>
                <div class="col-1 col-sm-1">:</div>
            </div>
            <div class="row m-b-5">
                <div class="col-12 col-sm-12">
                    <?= nl2br(h($dataRows->desc_knowing)) ?>
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