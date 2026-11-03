<?= $this->Krs->breadcrumb('HRGA', 'Kehadiran', 'Tampilkan') ?>
<?php
$isSearch = (
    !empty($this->request->getQuery('filterEmployee')) ||
    !empty($this->request->getQuery('filterDateFrom')) ||
    !empty($this->request->getQuery('filterDateEnd'))
);
// pr($dataRows);
?>

<div class="table-toolbar">
    <div class="btn-group">
        <?= $this->Form->create($dataRows, ['type' => 'file', 'url' => ['action' => 'deliveryImportSave', 'save']]) ?>
        <?php //echo $this->Form->create('UploadExcel',array('id'=>'fileupload', 'type'=>'file', 'enctype'=>'multipart/form-data', 'url' => array('controller' => 'acc_chart_of_accounts', 'action' => 'export_import_saldo_awal/save'))); ?>
        <div class="portlet-body">
            <div class="note note-cyan">
                <div class="note-icon"><i class="fas fa-upload"></i></div>
                <div class="note-content text-end">                             
                    <h4><b>Upload <u>Data Pengiriman</u> melalui file Excel...</b></h4>
                    
                    <div class="form-group row m-b-15">
                        <div class="col-md-6">
                        <?php
                        echo $this->Form->control('datePeriode', array('label' => 'Tanggal Periode', 'empty'=>false, 'placeholder'=>'Tanggal Periode..', 'class'=>'form-control dateRange', 'type'=>'text', 'readonly'=>true));
                        //<input type="text" class="form-control range" name="date" placeholder="Tanggal libur">

                        //, 'id' => 'selectForPurchasePass', 'title'=>"Surat Jalan Penerimaan tidak boleh kosong!", 'data-parsley-errors-container' => '#check-item', 'data-parsley-required-message'=>"Surat Jalan Penerimaan tidak boleh kosong!", 'required'=>true
                        ?>                                          
                        </div>
                    </div>

                    <?php
                    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                    echo $this->Form->file('filename', array('label' => false, 'size' => '50'));                            
                    
                    echo $this->Form->button('Upload', ['class' => 'btn btn-primary', 'type' => 'button', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);
                    // echo $this->Form->button('Upload', ['class'=>'btn btn-primary', 'type'=>'submit', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);

                    // echo $this->Form->button('Upload', array('class'=>'btn btn-success', 'type'=>'button', 'escape' => false, 'id'=> 'btn-upload'));
                    // if(count($invoices) != 0){
                    //, $data['filterLink']
                    ?>
                    <div class="btn-group dropdown">
                        <a href="javascript:(void);" class="btn btn-inverse"><i class="fa fa-download"></i></a>
                        <a href="javascript:(void);" class="btn btn-inverse dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?= $this->Html->link('Contoh Excel', ['prefix' => 'Hr', 'controller' => 'HrgaAttendances', 'action' => 'importExcel'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                        </div>

                    </div>
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
                                <a class="dropdown-item" href="">Excel File</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                <div class="row row-space-10">
                    <div class="col-md-3 m-b-10">
                        <?= $this->Form->control('filterEmployee', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Pegawai...', 'value' => $this->request->getQuery('filterEmployee')]); ?>
                    </div>
                    <div class="col-md-3 m-b-10">
                        <div class="input-group">
                            <?php
                            echo $this->Krs->inputDateRange('filterDateFrom', array("class" => "form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value' => $this->request->getQuery('filterDateFrom')), 'filterDateEnd', array("class" => "form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value' => $this->request->getQuery('filterDateEnd')), 's/d', 'resetDate');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Krs->btnSeach(); ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>

            <?php if ($isSearch): ?>
            <?= $this->Form->create(null, [
                'url' => ['action' => 'edit']
            ]) ?>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th width="180">Pegawai</th>
                            <th width="200">Periode</th>
                            <th width="80">Kehadiran</th>
                            <th width="80">Terlambat</th>
                            <th width="80">Lembur</th>
                            <th>Deskripsi</th>
                            <th class="actions text-center" width="120"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($dataRows) > 0) {                            
                            foreach ($dataRows as $index => $data){
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $dataSts = ($data->is_active == 'Y') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';
                                // pr($data);
                        ?>
                                <tr>
                                    <?php if ($isSearch): ?>
                                        <?= $this->Form->hidden("rows.$index.id", ['value' => $data->id]) ?>
                                    <?php endif; ?>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td><?= $data->hrga_employee->name ?></td>
                                    <td><?= date_format($data->start_date, 'd F Y') . ' - ' . date_format($data->end_date, 'd F Y') ?></td>
                                    <!-- <td align="right"><?= $data->qty ?></td> -->
                                     <td align="right">
                                        <?php if ($isSearch): ?>
                                            <?= $this->Form->control("rows.$index.qty", [
                                                'label' => false,
                                                'class' => 'form-control text-right',
                                                'value' => $data->qty
                                            ]) ?>
                                        <?php else: ?>
                                            <?= $data->qty ?>
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td align="right"><?= $data->qty_lateness ?></td> -->
                                     <td align="right">
                                        <?php if ($isSearch): ?>
                                            <?= $this->Form->control("rows.$index.qty_lateness", [
                                                'label' => false,
                                                'class' => 'form-control text-right',
                                                'value' => $data->qty_lateness
                                            ]) ?>
                                        <?php else: ?>
                                            <?= $data->qty_lateness ?>
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td align="right"><?= $data->qty_overtime ?></td> -->
                                     <td align="right">
                                        <?php if ($isSearch): ?>
                                            <?= $this->Form->control("rows.$index.qty_overtime", [
                                                'label' => false,
                                                'class' => 'form-control text-right',
                                                'value' => $data->qty_overtime
                                            ]) ?>
                                        <?php else: ?>
                                            <?= $data->qty_overtime ?>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= $data->description ?></td>
                                    <td class="actions text-center">
                                        <!-- <?= $this->Krs->btn('edit', $linkEdit) ?> -->
                                        <?= $this->Krs->btn('delete', $linkDelete, $data->name) ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            }
                        } else {
                            echo $this->Krs->dataNull();
                        }
                        ?>
                    </tbody>
                </table>
                <?php if ($isSearch): ?>
                <div class="text-right mt-3">
                    <?= $this->Form->button('Simpan Perubahan', [
                        'class' => 'btn btn-success',
                        'id' => 'btn-save-changes',
                        'type' => 'button'
                    ]) ?>
                </div>
                <?= $this->Form->end() ?>
                <?php endif; ?>
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var confirmTitleUpload = "Apakah anda ingin mengupload data tersebut ?";
    var formActionUpload = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'HrgaAttendances', 'action' => 'importExcelSave', 'save'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupUploadForm', 'btn-upload', confirmTitleUpload, formActionUpload);

    $('.dateRange').daterangepicker({
        startDate: moment(),
        endDate: moment().add(30, 'day'),
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
    datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');
    bindSaveConfirm();
    
    function bindSaveConfirm() {
        $('#btn-save-changes')
        .off('click.saveConfirm')
        .on('click.saveConfirm', function (e) {
            e.preventDefault();

            var $form = $(this).closest('form');

            SwalHelper.confirm('Apakah Anda yakin ingin menyimpan?', '', 'Ya, simpan', 'Batal')
            .then(function (result) {
                if (result.isConfirmed) {
                    $form.submit();
                }
            });
        });
    }
});
</script>