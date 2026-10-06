<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Overtime $overtime
 */
$dataRows = $data['dataRows'];
$dataDate = date_format($dataRows->date, 'd M Y');
$statusApprove = ($dataRows->status_approve == 'Y') ? '<i class="fas fa-check text-success"></i> ' : '<i class="fas fa-times text-danger"></i> ';
$dataApprove = $dataRows->approved == null ? " - " : $statusApprove . '<br><b>'.$dataRows->menyetujui->name.'</b><br>(<i>'.date_format($dataRows->approved_date, 'd-m-Y').'</i>)';
$statusKnowing = ($dataRows->status_knowing == 'Y') ? '<i class="fas fa-check text-success"></i> ' : '<i class="fas fa-times text-danger"></i> ';
$dataKnowing = $dataRows->knowing == null ? " - " : $statusKnowing . '<br><b>'.$dataRows->mengetahui->name.'</b> <br>(<i>'.date_format($dataRows->knowing_date, 'd-m-Y').'</i>)';
?>
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Data : <?= $dataDate ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <h3 class="text-center"><strong>Lembur</strong></h3>
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
                    <b>Tanggal</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= date('d M Y', strtotime($dataRows->date)) ?></i></div>
                <!-- <div class="col-2 col-sm-2">
                    <b>Jam</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= $dataRows->time_from.'-'.$dataRows->time_end ?></i></div> -->
            </div>
            <hr>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <h5 class="card-title">Detail Jam Lembur</h5>
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="2">SPKL</th>
                                <th colspan="2">Realisasi</th>
                                <th colspan="2">Jam yang di Approve</th>
                            </tr>
                            <tr>
                                <th>Jam Mulai</th>
                                <th>Jam Akhir</th>
                                <th>Jam Mulai</th>
                                <th>Jam Akhir</th>
                                <th>Jam Mulai</th>
                                <th>Jam Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= !empty($dataRows->work_order->work_order_lines) ? $dataRows->work_order->work_order_lines[0]->time_from : '-' ?></td>
                                <td><?= !empty($dataRows->work_order->work_order_lines) ? $dataRows->work_order->work_order_lines[0]->time_end : '-' ?></td>

                                <td><?=  $dataRows->time_from ?></td>
                                <td><?=  $dataRows->time_end ?></td>

                                <td><?= $dataRows->time_from_approve ?></td>
                                <td><?= $dataRows->time_end_approve ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row m-b-5 m-b-5">
                <div class="col-2 col-sm-3">
                    <b>Keterangan</b>
                </div>
                <div class="col-2 col-sm-2">:</div>
            </div>
            <div class="row m-b-5 m-b-5">
                <div class="col-12 col-sm-12">
                    <?= $this->Krs->fDecode($dataRows->description) ?>
                </div>
            </div>
            <?php if (!empty($dataRows->approved_description)) : ?>
                <div class="row m-b-5">
                    <div class="col-2 col-sm-3">
                        <b>Catatan Menyetujui</b>
                    </div>
                    <div class="col-2 col-sm-2">:</div>
                </div>
                <div class="row m-b-5">
                    <div class="col-12 col-sm-12">
                        <?= h($dataRows->approved_description) ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($dataRows->knowing_description)) : ?>
                <div class="row m-b-5">
                    <div class="col-2 col-sm-3">
                        <b>Catatan Mengetahui</b>
                    </div>
                    <div class="col-2 col-sm-2">:</div>
                </div>
                <div class="row m-b-5">
                    <div class="col-12 col-sm-12">
                        <?= h($dataRows->knowing_description) ?>
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
