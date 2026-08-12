<?= $this->Krs->breadcrumb('Master', 'Akun Bank', 'Tampilkan') ?>

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
                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'templateExcel']); ?>">Template Excel</a>
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
                        <?= $this->Form->control('filterNamaRekening', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama Rekening...', 'value' => $this->request->getQuery('filterNamaRekening'), 'type' => 'text']); ?>
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
                            <th width="200">Nama Bank</th>
                            <th width="120">Nama Pemilik</th>
                            <th width="100">Nomor Rekening</th>
                            <th width="100">Aktif</th>                            
                            <th width="100">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($bankAccounts) > 0) {
                            
                            foreach ($bankAccounts as $index => $data) {
                                // pr($data); die;
                                $linkPreview = array('action' => 'view', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $isView = ($data->is_view=='Y') ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>";
                                $isActive = ($data->is_active=='Y') ? "<i class='fa fa-check text-success'></i>" : "<i class='fa fa-times text-danger'></i>";
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $data->bank_name?></td>
                                <td class="text-center"><?= $data->account_holder ?></td>
                                <td class="text-center"><?= $data->account_number ?></td>
                                <td class="text-center"><?= $isActive ?></td>
                                 <!-- with-btn -->
                                <td class="text-center" nowrap>
                                    <?= $this->Krs->btn('preview', 'javascript:void(0)', $data->id, 'set_dtl') ?>
                                    <?= $this->Krs->btn('edit', $linkEdit) ?>
                                    <!-- <?= $this->Krs->btn('delete', $linkDelete) ?> -->
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

<div class="table-toolbar">
    <div class="btn-group">
        <?= $this->Form->create(null, ['type' => 'file', 'url' => ['action' => 'importExcel']]) ?>
        <?php //echo $this->Form->create('UploadExcel',array('id'=>'fileupload', 'type'=>'file', 'enctype'=>'multipart/form-data', 'url' => array('controller' => 'acc_chart_of_accounts', 'action' => 'export_import_saldo_awal/save'))); ?>
        <div class="portlet-body">
            <div class="note note-cyan">
                <div class="note-icon"><i class="fas fa-upload"></i></div>
                <div class="note-content text-end">                             
                    <h4><b>Upload <u>Data Akun Bank</u> melalui file Excel...</b></h4>
                    <?php
                    // echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                    echo $this->Form->file('filename', array('label' => false, 'size' => '50'));                            
                    
                    echo $this->Form->button('Upload', ['class' => 'btn btn-primary', 'type' => 'submit', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);
                    ?>
                    <!-- <div class="btn-group dropdown">
                        <a href="javascript:(void);" class="btn btn-inverse"><i class="fa fa-download"></i></a>
                        <a href="javascript:(void);" class="btn btn-inverse dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?= $this->Html->link('Contoh Excel', ['controller' => 'BankAccounts', 'action' => 'importExcel'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                        </div>

                    </div> -->
                    <div class="stats-desc text-danger"><i>Perhatian: Proses data akan disimpan langsung tanpa melalui filter.</i></div>
                    <?php
                    // }
                    ?>
                </div>
            </div> 
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
$urlGetData = $this->Url->build(['controller' => 'BankAccounts', 'action' => 'view', '_full' => true]);
?>
<script>
$(document).ready(function() {
    $('.select2FormClear').select2({
        allowClear: true,
        width: '100%'
    });
    <?php
    foreach ($bankAccounts as $rowJavascript) {
        echo 'handleFormPreview("btn-preview' . $rowJavascript->id . '", "' . $urlGetData . '/' . $rowJavascript->id . '");';
    }
    ?>
});
</script>