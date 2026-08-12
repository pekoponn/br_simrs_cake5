<?= $this->Krs->breadcrumb('Acc', 'Dana Masuk', 'Tampilkan') ?>

<div class="panel panel-inverse" data-sortable-id="table-basic-2">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                            <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!-- <a class="dropdown-item" href="" target="_blank">Pdf File</a> -->
                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'xls',  '?' => $this->request->getQueryParams()]); ?>">Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                <div class="row row-space-10">
                    <div class="col-md-3">
                        <div class="form-group m-b-10">
                        <?= $this->Form->control('filterName', ['label' => false, 'class' => 'form-control select2FormClear', 'data-placeholder' => 'Nama Bank...', 'empty' => 'Pilih salah satu', 'options' => $this->Krs->bankName(), 'value' => $this->request->getQuery('filterName')]); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                        <?= $this->Form->control('filterTujuan', ['label' => false, 'class' => 'form-control', 'placeholder' => 'COA Dana Masuk...', 'value' => $this->request->getQuery('filterTujuan'), 'type' => 'text']); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal Transaksi...', 'value'=>$this->request->getQuery('filterDateFrom')), 'filterDateEnd', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal Transaksi...', 'value'=>$this->request->getQuery('filterDateEnd')), 's/d', 'resetDate');
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
                <table class="table table-striped m-b-5 table-advance table-hover">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="20">No</th>
                            <!-- <th width="120">UBS</th> -->
                            <th width="120">Nama Bank</th>
                            <th width="120">COA Dana Masuk</th>
                            <th width="100">Nominal</th>
                            <th width="100">Tanggal Transaksi</th>  
                            <th width="100">Bukti Transfer</th>                          
                            <th width="100">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($bankIncomes) > 0) {
                            
                            foreach ($bankIncomes as $index => $data) {
                                $linkPreview = array('action' => 'view', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $isView = ($data->is_view=='Y') ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>";
                                $created = $data->user->name. ' <br> '. date_format($data->created, 'd-m-Y H:i:s');
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <!-- <td><?= $data->ubs ?? '-' ?></td> -->
                                <td><?= $data->payment_type ?></td>
                                <td><?= $data->acc_chart_of_account->code. ' - ' . $data->acc_chart_of_account->name ?></td>
                                <td class="text-center"><?= $this->Krs->nom($data->nominal) ?></td>
                                <td class="text-center"><?= $created ?></td>
                                <td class="text-center">
                                    <?php
                                    $hasImage = false;
                                    for ($i = 1; $i <= 2; $i++):
                                        $file = "file_$i";
                                        if (!empty($data->$file)):
                                            $hasImage = true;
                                            $fileUrl = $this->Url->assetUrl('files/' . $data->$file);
                                    ?>
                                        <a href="<?= $fileUrl ?>" data-lightbox="buktiTransfer-<?= $data->id ?>" style="margin:2px;display:inline-block;">
                                            <img src="<?= $fileUrl ?>" alt="Dokumentasi" style="max-width:48px;max-height:48px;border:1px solid #ccc;">
                                        </a>
                                    <?php
                                        endif;
                                    endfor;
                                    if (!$hasImage) echo '-';
                                    ?>
                                </td>
                                <td class="text-center" nowrap>
                                    <?= $this->Krs->btn('preview', 'javascript:void(0)', $data->id, 'set_dtl') ?>
                                    <!-- <?= $this->Krs->btn('edit', $linkEdit) ?> -->
                                </td>
                            </tr>
                        <?php
                                //$this->Krs->btn('delete', $linkDelete, $data->name)
                                $no++;
                            }
                        } else {
                            echo $this->Krs->dataNull();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- pagination -->
            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>

<!-- modal view -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<?php
$urlGetData = $this->Url->build(['controller' => 'BankIncomes', 'action' => 'view', '_full' => true]);
?>
<script>
$(document).ready(function() {
    $('.resetDate').on('click', function(e) {
        e.preventDefault();
        $('.filterDate').val('');
        $('.filterDate').datepicker('clearDates');
    });
    $('.select2FormClear').select2({
        allowClear: true,
        width: '100%'
    });
    <?php
    foreach ($bankIncomes as $rowJavascript) {
        echo 'handleFormPreview("btn-preview' . $rowJavascript->id . '", "' . $urlGetData . '/' . $rowJavascript->id . '");';
    }
    ?>
});
</script>