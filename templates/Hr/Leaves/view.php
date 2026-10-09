<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leave $leave
 */
$dataRows = $data['dataRows'];
// $dataDateFrom = date_format($dataRows->date_from, 'd M Y');
// $dataDateEnd = date_format($dataRows->date_end, 'd M Y');
// $dataApprove = $dataRows->approved == null ? " - " : '<b>'.$dataRows->menyetujui->name.'</b> (<i>'.date_format($dataRows->approved_date, 'd-m-Y').'</i>)';
// $dataKnowing = $dataRows->knowing == null ? " - " : '<b>'.$dataRows->mengetahui->name.'</b> (<i>'.date_format($dataRows->knowing_date, 'd-m-Y').'</i>)';

if (!empty($dataRows->date_1)) {
    $tanggalCuti = $dataRows->date_1->format('d M Y');
} elseif (!empty($dataRows->date_from) && !empty($dataRows->date_end)) {
    $tanggalCuti = $dataRows->date_from->format('d M Y') . ' - ' . $dataRows->date_end->format('d M Y');
} else {
    $tanggalCuti = '-';
}

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
            <h3 class="text-center"><strong>Ijin Cuti</strong></h3>
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
                    <b>Tanggal Cuti</b>
                </div>
                <div class="col-4 col-sm-4">: <i><?= $tanggalCuti; ?></i></div>
                <!-- <div class="col-2 col-sm-2">
                    <b>Tanggal Akhir</b>
                </div>
                <div class="col-4 col-sm-4">: <i><i><?= $dataDateEnd; ?></i></div> -->
            </div>
            <div class="row m-b-5">
                <div class="col-2 col-sm-2"><b>Jenis Cuti</b></div>
                <div class="col-4 col-sm-4">: <i><?= !empty($dataRows->type) ? h($dataRows->type) : '-' ?></i></div>
            </div>
            <!-- <div class="row m-b-5 m-b-5">
                <div class="col-2 col-sm-2">
                    <b>Jenis</b>
                </div> 
                <div class="col-6 col-sm-6">: <?= $dataRows->type?></div>
            </div> -->
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
                    <b>Catatan Approve</b>
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
<?php
/*
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Leave'), ['action' => 'edit', $leave->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Leave'), ['action' => 'delete', $leave->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leave->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Leaves'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Leave'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="leaves view content">
            <h3><?= h($leave->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $leave->has('branch') ? $this->Html->link($leave->branch->name, ['controller' => 'Branches', 'action' => 'view', $leave->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($leave->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Devision') ?></th>
                    <td><?= h($leave->devision) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= h($leave->position) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($leave->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($leave->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($leave->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($leave->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($leave->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($leave->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Applicant') ?></th>
                    <td><?= $this->Number->format($leave->applicant) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved') ?></th>
                    <td><?= $this->Number->format($leave->approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Knowing') ?></th>
                    <td><?= $this->Number->format($leave->knowing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date From') ?></th>
                    <td><?= h($leave->date_from) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date End') ?></th>
                    <td><?= h($leave->date_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Date') ?></th>
                    <td><?= h($leave->approved_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Knowing Date') ?></th>
                    <td><?= h($leave->knowing_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($leave->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($leave->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($leave->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($leave->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($leave->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
*/
?>
