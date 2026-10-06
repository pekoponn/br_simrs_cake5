<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leave $leave
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 */
echo $this->Html->script(['/plugins/tinymce/tinymce.min', '/plugins/tinymce/tinymce.setting'], ['fullBase' => true]);
$dataChild = $this->Html->link('Cuti', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Buat') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($leave) ?>
    <!-- panel head  -->
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="form-group row">
                <label class="col-form-label col-md-1">Divisi :</label>
                <div class="col-md-2">
                    <?php echo $this->Form->control('devision', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext', 'value' => $getUser->devision]); ?>
                </div>
                <label class="col-form-label col-md-1">Jabatan :</label>
                <div class="col-md-2">
                    <?php echo $this->Form->control('position', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext', 'value' => $getUser->staff]); ?>
                    <?php echo $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]); ?>
                    <?php echo $this->Form->control('position', ['type' => 'hidden', 'value' => $getUser->staff]); ?>
                    <?php echo $this->Form->control('devision', ['type' => 'hidden', 'value' => $getUser->devision]); ?>
                </div>
                <!-- <label class="col-form-label col-md-1">Tanggal :</label>
                <div class="col-md-4">                   
                    <?php
                    echo $this->Krs->inputDateRange('date_from', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...'), 'date_end', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...'), 's/d', 'resetDate');
                    ?>
                    <muted class="text-muted">*Pengajuan cuti minimal 14 hari sebelum tanggal cuti</muted>
                </div> -->
                <div class="col-md-4">

                    <label>Tanggal Cuti 1</label>
                    <div class="input-group m-b-10">
                        <?= $this->Form->control('date_1', [
                            'label' => false,
                            'class' => 'form-control leaveDate',
                            'readonly' => true,
                            'placeholder' => 'Tanggal...'
                        ]) ?>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default resetDate1">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <label>Tanggal Cuti 2</label>
                    <div class="input-group m-b-10">
                        <?= $this->Form->control('date_2', [
                            'label' => false,
                            'class' => 'form-control leaveDate',
                            'readonly' => true,
                            'placeholder' => 'Tanggal...'
                        ]) ?>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default resetDate2">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <label>Tanggal Cuti 3</label>
                    <div class="input-group">
                        <?= $this->Form->control('date_3', [
                            'label' => false,
                            'class' => 'form-control leaveDate',
                            'readonly' => true,
                            'placeholder' => 'Tanggal...'
                        ]) ?>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default resetDate3">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <small class="text-muted">
                        *Pengajuan cuti minimal 14 hari sebelum tanggal cuti
                    </small>

                </div>
            </div>
            <div class="row">
                
                <!-- <div class="col-md-6">
                    <?= $this->Form->control('type', ['label' => 'Keperluan', 'class' => 'form-control types', 'options' => $this->Krs->descLeaves(), 'default'=>'Lain Lain']); ?>
                </div> -->
                
            </div>
            <hr>
            <?= $this->Form->control('description', ['label' => 'Deskripsi', 'class' => 'form-control', 'type' => 'textarea']); ?>

        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<?php $minLeaveDate = date('d-m-Y', strtotime('+14 days'));?>
<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'Leaves', 'action' => 'add'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

    datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');
    // $('.filterDate').datepicker('destroy');
    // $('.filterDate').datepicker({
    //     autoclose: true,
    //     format: 'dd-mm-yyyy',
    //     startDate: '<?= $minLeaveDate ?>'
    // });
    // $('.filterDate').datepicker('destroy');
    // let minDate = new Date();
    // minDate.setDate(minDate.getDate() + 14);
    // $('input[name="date_1"]').datepicker({
    //     autoclose: true,
    //     format: 'dd-mm-yyyy',
    //     startDate: minDate
    // }).on('changeDate', function(e) {
    //     let startDate = e.date;
    //     let maxDate = new Date(startDate);
    //     maxDate.setDate(maxDate.getDate() + 2);
    //     let dd = String(startDate.getDate()).padStart(2, '0');
    //     let mm = String(startDate.getMonth() + 1).padStart(2, '0');
    //     let yyyy = startDate.getFullYear();
    //     let formattedStart = dd + '-' + mm + '-' + yyyy;
    //     $('input[name="date_end"]')
    //         .datepicker('setStartDate', startDate)
    //         .datepicker('setEndDate', maxDate)
    //         .datepicker('update', formattedStart);
    // });
    // $('input[name="date_end"]').datepicker({
    //     autoclose: true,
    //     format: 'dd-mm-yyyy',
    //     startDate: minDate
    // });

    $('.filterDate').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: minDate,
        todayHighlight: true
    });
    $('input[name="date_1"], input[name="date_2"], input[name="date_3"]').on('change', function () {
        let dates = [];
        $('input[name="date_1"], input[name="date_2"], input[name="date_3"]').each(function () {
            if ($(this).val() !== '') {
                dates.push($(this).val());
            }
        });
        // Cek tanggal tidak boleh sama
        if (new Set(dates).size !== dates.length) {
            alert('Tanggal cuti tidak boleh sama.');
            $(this).val('');
        }
    });
    $('.types').select2({
        placeholder: 'Pilih salah satu keperluan',
    });

    $('#div').select2({
        placeholder: 'Pilih Jenis',
    });

    $('.tanggal').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: '<?= $minLeaveDate ?>'
    });

    $('.timepicker').timepicker({
    });
    
});
</script>