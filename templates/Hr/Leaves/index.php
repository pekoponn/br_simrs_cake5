<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leave[]|\Cake\Collection\CollectionInterface $leaves
 */
// pr($leaves);
?>
<?= $this->Krs->breadcrumb('HRGA', 'Cuti', 'Tampilkan') ?>

<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                            <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-angle-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!-- <a class="dropdown-item" href="" target="_blank">Pdf File</a> -->
                                <!-- <a class="dropdown-item" href="">Excel File</a> -->
                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'excel']); ?>">Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                /*
                <div class="btn-group pull-right">
                    <div class="portlet-body">
                        <?= $this->Form->create(null, ['type' => 'get']) ?>
                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input class="form-control my-0 py-1" type="text" placeholder="Cari data ..." aria-label="Search" name="key" value="<?= $this->request->getQuery('key'); ?>">
                            <div class="input-group-append">
                                <button name="filter" class="btn btn-yellow" data-toggle="tooltip" data-placement="top" title="" type="submit" data-original-title="Cari"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
                */
                ?>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                 <div class="row row-space-10">
                    <div class="col-md-3">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value'=>$data['filterDateFrom']), 'filterDateEnd', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value'=>$data['filterDateEnd']), 's/d', 'resetDate');
                        ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Form->input('filterApplicant', array('class' => 'form-control', 'id' => 'maxlength_defaultconfig', 'required' => false, 'placeholder'=>'Pemohon..', 'empty'=>true, 'value'=>$data['filterApplicant']));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Form->input('filterDevision', ['empty'=>true, 'options'=>$this->Krs->devision(), 'data-placeholder'=>'Devisi..', 'class'=>'form-control select2FormClear', 'type'=>'select', 'default'=>$data['filterDevision']]);
                        //echo $this->Form->input('filterDevision', array('class' => 'form-control', 'id' => 'maxlength_defaultconfig', 'required' => false, 'placeholder'=>'Tujuan..', 'empty'=>true, 'value'=>$dataLink['filterDevision']));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                        <?= $this->Krs->btnSeach(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="bg-gradient-silver">
                        <tr class="text-center">
                            <th width="15%">Tanggal</th>
                            <th width="12%">Jenis Cuti</th>
                            <th>Pemohon</th>
                            <th width="12%">Devisi</th>                            
                            <th width="15%">Menyetujui</th>
                            <th width="15%">Mengetahui</th>
                            <th class="actions text-center" width="20%"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $no = 1;
                        if (count($dataRows) > 0) {
                            foreach ($dataRows as $index => $data) :
                                $dataId = $data->id;
                                $dataDevision = (empty($data->devision)) ? '':$this->Krs->devision($data->devision);
                                $dataApprove = $data->approved == null ? " - " : $data->menyetujui->code.' ('.date_format($data->approved_date, 'd-m-Y').')';
                                $dataKnowing = $data->knowing == null ? " - " : $data->mengetahui->code.' ('.date_format($data->knowing_date, 'd-m-Y').')';       

                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $linkApprove = array('action' => 'approve', $data->id);
                                $linkKnown = array('action' => 'knowing', $data->id);

                                
                        ?>
                                <tr <?php if ($data->is_cancel > 0) { echo 'style="background-color: #f8d7da;"'; } ?>>
                                   
                                    <td class="text-center">
                                    <?php
                                    if (!empty($data->date_1)) {
                                        echo $data->date_1->format('d M Y');
                                    } elseif (!empty($data->date_from) && !empty($data->date_end)) {
                                        echo $data->date_from->format('d M Y') . ' - ' . $data->date_end->format('d M Y');
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                    </td>
                                    <td class="text-center"><?= !empty($data->type) ? h($data->type) : '-' ?></td>
                                    <td><b><?= $data->user->name?></b><br><small><?= date_format($data->created, 'd M Y') ?></small></td>
                                    <td class="text-center"><?= $dataDevision ?></td>
                                    <td class="text-center">
                                        <?php if ($data->status_approve == 'Y') : ?>
                                            <i class="fa fa-check text-success"></i><br>
                                        <?php elseif ($data->status_approve == 'N') : ?>
                                            <i class="fa fa-times text-danger"></i><br>
                                        <?php endif; ?>
                                        <?= $data->approved == null ? "-" : $data->menyetujui->name.'<br><small>'.date_format($data->approved_date, 'd M Y').'</small>'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($data->status_knowing == 'Y') : ?>
                                            <i class="fa fa-check text-success"></i><br>
                                        <?php elseif ($data->status_knowing == 'N') : ?>
                                            <i class="fa fa-times text-danger"></i><br>
                                        <?php endif; ?>

                                        <?= $data->knowing == null ? "-" : $data->mengetahui->name.'<br><small>'.date_format($data->knowing_date, 'd M Y').'</small>'; ?>
                                    </td>
                                    <!-- <td><?= $data->knowing == null ? " - " : $data->mengetahui->name;?></td> -->
                                    <td class="actions text-right">
                                        <?= $this->Krs->btn('preview', 'javascript:void(0)', $data->id, 'set_dtl') ?>
                                        <?php
                                        if ($checkUrl['leaves']['approve'] == '1' && $data->approved == null && $data->is_cancel == 0) {
                                            echo $this->Krs->btn('approve', $linkApprove);
                                        }
                                        ?>
                                        <?php
                                        // if ($checkUrl['leaves']['knowing'] == '1' && $data->knowing == null && $data->is_cancel == 0) {
                                        if ($checkUrl['leaves']['knowing'] == '1' && $data->knowing == null && $data->approved != null && $data->is_cancel == 0) {
                                            echo $this->Krs->btn('knowing', $linkKnown);
                                        }
                                        ?>
                                        <?php
                                        // if ($checkUrl['leaves']['edit'] == '1' && ($data->approved_date == null || $data->knowing_date == null || $data->is_cancel == 0)) {
                                        if ($checkUrl['leaves']['edit'] == '1' && $data->approved == null && $data->is_cancel == 0) {
                                            echo $this->Krs->btn('edit', $linkEdit);
                                        }
                                        ?>
                                        <?php
                                        $today = date('Y-m-d');
                                        $dates = [];
                                        $dates = !empty($data->date_1)
                                            ? [$data->date_1]
                                            : [$data->date_from, $data->date_end];
                                        $canCancel = false;
                                        foreach ($dates as $date) {
                                            if (!empty($date) && $date->format('Y-m-d') >= $today) {
                                                $canCancel = true;
                                                break;
                                            }
                                        }
                                        if ($checkUrl['leaves']['cancel'] == '1' && $data->is_cancel == 0 && $canCancel) {
                                        ?>                                            
                                            <button class="btn btn-danger btn-sm m-r-5 p-l-15 p-r-15 open-cancel-modal" data-id="<?= $data->id ?>" data-toggle="modal" data-target="#cancelModal" title="Batal"><i class="fa fa-ban"></i></button>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php if ($data->is_cancel > 0) : ?>
                                <tr style="background-color: #f8d7da;">
                                    <td colspan="9"><strong>Alasan Cancel:</strong> <?= htmlspecialchars($data->cancel_reason) ?> <b>(<?= $data->canceled ? date_format($data->canceled, 'd M Y') : '' ?>)</b></td>
                                </tr>
                                <?php endif; ?>
                            <?php $no++;
                            endforeach;
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


<div class="modal fade" id="modal-detail" data-keyboard="true" tabindex="-1" role="dialog">
</div>
<!-- Modal Cancel -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <?= $this->Form->create(null, ['url' => ['prefix' => 'Hr', 'controller' => 'Leaves', 'action' => 'cancel'], 'id' => 'cancelForm']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Alasan Pembatalan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <?= $this->Form->hidden('id', ['id' => 'cancelOrderId']); ?>
                <div class="form-group">
                <?= $this->Form->control('cancel_reason', [
                    'label' => 'Alasan Pembatalan',
                    'class' => 'form-control',
                    'required' => true
                ]); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </div>
    <?= $this->Form->end(); ?>
    </div>
</div>

<?php
$urlGetData = $this->Url->build(['prefix' => 'Hr', 'controller' => 'Leaves', 'action' => 'view', '_full' => true]);
// pr($dataRows);
//pr($data);
?>
<script>
$(document).ready(function() {
    <?php
    if (count($dataRows) > 0) {
        foreach ($dataRows as $rowPreview) {
            //$linkData = $this->Krs->fEncode($rowPreview['id'].'^'.$rowPreview['date'].'^'.$getUser->id);
            $linkData = $this->Krs->fEncode($rowPreview['id'].'^'.$getUser->id);
            echo 'handleFormPreview("btn-preview' . $rowPreview['id'] . '", "' . $urlGetData . '/' . $linkData . '");';
        }
    }
    ?>
    datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');
    $(document).on('click', '.open-cancel-modal', function () {
        var orderId = $(this).data('id'); 
        // console.log(orderId);
        $('#cancelOrderId').val(orderId); 
    });
});
</script>
