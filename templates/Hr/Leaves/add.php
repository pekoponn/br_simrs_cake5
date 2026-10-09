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
                <div class="col-md-6" id="separateLeaveDates">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tanggal Cuti</label>
                            <div class="input-group">
                                <?= $this->Form->control('date_1', [
                                    'label' => false,
                                    'type' => 'text',
                                    'class' => 'form-control tanggal',
                                    'placeholder' => '-- Pilih Tanggal --',
                                    'readonly' => true,
                                ]) ?>

                                <span class="input-group-btn">
                                    <button
                                        class="btn btn-inverse resetSeparateDate"
                                        type="button"
                                        data-target="date_1">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <muted class="text-muted">*Pengajuan cuti minimal 14 hari sebelum tanggal cuti</muted>
                </div>
                <div class="col-md-5" id="rangeLeaveDates" style="display:none;">
                    <label>Tanggal Cuti</label>
                    <?php
                    echo $this->Krs->inputDateRange('date_from', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal mulai...'), 'date_end', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal selesai...'), 's/d', 'resetDate');
                    ?>
                    <muted class="text-muted">*Pengajuan cuti minimal 14 hari sebelum tanggal cuti</muted>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $this->Form->control('type', [
                        'label' => 'Jenis Cuti <span class="text-danger">*</span>',
                        'escape' => false,
                        'class' => 'form-control select2Form types',
                        'options' => $this->Krs->leaveTypes(),
                        'empty' => 'Pilih jenis cuti',
                        // 'required' => true,
                    ]); ?>
                </div>
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
    let minDate = new Date();
    minDate.setDate(minDate.getDate() + 14);

    $('.tanggal').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: minDate,
        todayHighlight: true
    });

    $('.resetSeparateDate').click(function () {
        $('input[name="' + $(this).data('target') + '"]').datepicker('update', '');
    });

    // Inisialisasi langsung pada field jenis cuti agar selalu tampil sebagai Select2.
    $('#type').select2({
        width: '100%',
        placeholder: 'Pilih jenis cuti',
        allowClear: true,
    });

    function toggleLeaveDateFields() {
        const hasLeaveType = $('#type').val() !== null && $('#type').val() !== '';
        $('#separateLeaveDates').toggle(!hasLeaveType);
        $('#rangeLeaveDates').toggle(hasLeaveType);
        $('.filterDate').prop('required', hasLeaveType);

        if (hasLeaveType) {
            $('.tanggal').datepicker('update', '');
        } else {
            $('.filterDate').datepicker('update', '');
        }
    }

    $('#type').on('change', toggleLeaveDateFields);
    toggleLeaveDateFields();

    $('#div').select2({
        placeholder: 'Pilih Jenis',
    });

    $('.filterDate').datepicker('destroy').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: '<?= $minLeaveDate ?>',
        todayHighlight: true
    });

    $('.timepicker').timepicker({
    });
    
});
</script>
