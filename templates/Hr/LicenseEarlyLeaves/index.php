<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leave[]|\Cake\Collection\CollectionInterface $leaves
 */
// pr($leaves);
?>
<?= $this->Krs->breadcrumb('HRGA', 'Ijin Pulang', 'Tampilkan') ?>

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
                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'excel']); ?>">Excel File</a>
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
                            <th width="10%">Tanggal</th>
                            <th width="10%">Jam Pulang</th>
                            <th width="10%">Jenis</th>
                            <th>Pemohon</th>
                            <th width="12%">Devisi</th>                            
                            <th width="12%">Menyetujui</th>
                            <th width="12%">Mengetahui</th>
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
                                $dataApprove = $data->is_approved == null ? " - " : '<b>' . $data->menyetujui->name . '</b><br> (' . date_format($data->approved, 'd-m-Y') . ')';
                                $dataKnowing = $data->is_knowing == null ? " - " : '<b>' . $data->mengetahui->name . '</b><br> (' . date_format($data->knowing, 'd-m-Y') . ')<br>' . $data->check_status;

                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $linkApprove = array('action' => 'approve', $data->id);
                                $linkKnown = array('action' => 'knowing', $data->id);
                        ?>
                                <tr>
                                    <td class="text-center"><?=  date_format($data->date, 'd M Y')?></td>
                                    <td class="text-center"><?= $data->time_from ?></td>
                                    <td class="text-center"><?= $data->type ?></td>
                                    <td><b><?= $data->user->name?></b><br><small><?= date_format($data->created, 'd M Y') ?></small></td>
                                    <td class="text-center"><?= $dataDevision ?></td>
                                    <td class="text-center">
                                        <?php if ($data->status_approve == 'Y') : ?>
                                            <i class="fa fa-check text-success"></i><br>
                                        <?php elseif ($data->status_approve == 'N') : ?>
                                            <i class="fa fa-times text-danger"></i><br>
                                        <?php endif; ?>
                                        <?= $data->approved == null ? "-" : $data->menyetujui->name.'<br><small>'.date_format($data->approved, 'd M Y').'</small>'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($data->status_knowing == 'Y') : ?>
                                            <i class="fa fa-check text-success"></i><br>
                                        <?php elseif ($data->status_knowing == 'N') : ?>
                                            <i class="fa fa-times text-danger"></i><br>
                                        <?php endif; ?>

                                        <?= $data->knowing == null ? "-" : $data->mengetahui->name.'<br><small>'.date_format($data->knowing, 'd M Y').'</small>'; ?>
                                    </td>
                                    <td class="actions text-right">
                                        <?= $this->Krs->btn('preview', 'javascript:void(0)', $data->id, 'set_dtl') ?>
                                        <?php
                                        if ($checkUrl['licenseearlyleaves']['approve'] == '1' && $data->approved == null) {
                                            echo $this->Krs->btn('approve', $linkApprove);
                                        }
                                        ?>
                                        <?php
                                        if ($checkUrl['licenseearlyleaves']['knowing'] == '1' && $data->knowing == null && $data->approved != null) {
                                            echo $this->Krs->btn('knowing', $linkKnown);
                                        }
                                        ?>
                                        <?php                                      
                                        if ($checkUrl['licenseearlyleaves']['edit'] == '1' && $data->approved == null && $data->knowing == null) {
                                            echo $this->Krs->btn('edit', $linkEdit);
                                        }
                                        ?>
                                        <!-- <?= $this->Krs->btn('edit', $linkEdit) ?> -->
                                    </td>
                                </tr>
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

<?php
$urlGetData = $this->Url->build(['prefix' => 'Hr', 'controller' => 'LicenseEarlyLeaves', 'action' => 'view', '_full' => true]);
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

    <?php
    /*
    var id = '';
    $(document).on('click', '#set_dtl', function() {
        id = $(this).data('id');
        $.ajax({
            url: "echo $this->url->build(['prefix' => 'Hr', 'controller' => 'Overtimes', 'action' => 'view']);",
            method: "get",
            data: {
                id: id
            },
            success: function(data) {
                $('#modal-detail').modal('show');
                $('.code').text(data[0].code);
                $('.code').text(data[0].code);
            }
        });
    });
    */
    ?>
});
</script>