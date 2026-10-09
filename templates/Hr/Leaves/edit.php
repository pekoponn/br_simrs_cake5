<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leave $leave
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 */
echo $this->Html->script(['/plugins/tinymce/tinymce.min', '/plugins/tinymce/tinymce.setting'], ['fullBase' => true]);
$dataChild = $this->Html->link('Cuti', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Ubah') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($leave) ?>
    <!-- panel head  -->
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="form-group row m-b-15">
                <label class="col-form-label col-md-1">Divisi :</label>
                <div class="col-md-2">
                    <?php echo $this->Form->control('devision', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext', 'value' => $getUser->devision]); ?>
                </div>
                <label class="col-form-label col-md-1">Jabatan :</label>
                <div class="col-md-2">
                    <?php echo $this->Form->control('position', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext', 'value' => $getUser->position]); ?>
                    <?php echo $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
                    <?php echo $this->Form->control('position', ['type' => 'hidden', 'value' => $getUser->position]); ?>
                    <?php echo $this->Form->control('devision', ['type' => 'hidden', 'value' => $getUser->devision]); ?>
                </div>

                <!-- Tanggal 1 hari (jenis cuti kosong) -->
                <div class="col-md-6" id="separateLeaveDates">
                    <div class="row">
                        <label class="col-form-label col-md-3">Tanggal Cuti :</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <?= $this->Form->control('date_1', [
                                    'label' => false,
                                    'type' => 'text',
                                    'class' => 'form-control separateDate',
                                    'placeholder' => '-- Pilih Tanggal --',
                                    'readonly' => true,
                                    'value' => !empty($leave->date_1) ? $leave->date_1->format('d-m-Y') : '',
                                ]) ?>
                                <span class="input-group-btn"><button class="btn btn-inverse resetSeparateDate" type="button" data-target="date_1"><i class="fa fa-times"></i></button></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanggal rentang (jenis cuti dipilih) -->
                <div class="col-md-6" id="rangeLeaveDates" style="display:none;">
                    <div class="row">
                        <label class="col-form-label col-md-3">Tanggal Cuti :</label>
                        <div class="col-md-9">
                            <?= $this->Krs->inputDateRange(
                                'date_from',
                                ['class' => 'form-control date-picker rangeDate', 'readonly' => true, 'placeholder' => 'Tanggal mulai...', 'value' => $leave->date_from ? $leave->date_from->format('d-m-Y') : ''],
                                'date_end',
                                ['class' => 'form-control date-picker rangeDate', 'readonly' => true, 'placeholder' => 'Tanggal selesai...', 'value' => $leave->date_end ? $leave->date_end->format('d-m-Y') : ''],
                                's/d',
                                'resetDateRange'
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $leaveTypeOptions = $this->Krs->leaveTypes();
            $selectedLeaveType = '';
            foreach ($leaveTypeOptions as $leaveTypeValue => $leaveTypeLabel) {
                if (explode('^', $leaveTypeValue, 2)[0] === $leave->type) {
                    $selectedLeaveType = $leaveTypeValue;
                    break;
                }
            }
            ?>
            <div class="row">
                <div class="col-md-4">
                    <?= $this->Form->control('type', [
                        'label' => 'Jenis Cuti',
                        'class' => 'form-control types',
                        'options' => $leaveTypeOptions,
                        'empty' => 'Pilih jenis cuti',
                        'value' => $selectedLeaveType,
                    ]) ?>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-3">
                    <label for="type">Tanggal</label>
                    <br><span class="text-danger">Pengajuan cuti wajib dilakukan minimal H-14 sebelum tanggal cuti.</span>
                    <?php
                    echo $this->Krs->inputDateRange('date_from', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value'=>date_format($leave['date_from'], 'd-m-Y')), 'date_end', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value'=>date_format($leave['date_end'], 'd-m-Y')), 's/d', 'resetDate');
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('type', ['label' => 'Keperluan', 'class' => 'form-control types', 'options' => $this->Krs->descLeaves(), 'default'=>'Lain Lain', 'value' => $leave->type . '^' . $leave->leave_days]); ?>
                </div>                
            </div>             -->
            <hr>
            <?= $this->Form->control('description', ['label' => 'Deskripsi', 'class' => 'form-control', 'type' => 'textarea', 'value'=>$this->Krs->fDecode($leave->description)]); ?>

        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<?php
$minLeaveDate = date('d-m-Y', strtotime($leave->created . ' +14 days'));
?>
<script>
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'Leaves', 'action' => 'edit', $leave->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
        $('.separateDate, .rangeDate').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            startDate: '<?= $minLeaveDate ?>'
        });

        $('.types').select2({
            placeholder: 'Pilih jenis cuti',
            allowClear: true,
            width: '100%'
        });

        $('.resetSeparateDate').on('click', function () {
            $('input[name="' + $(this).data('target') + '"]').datepicker('update', '');
        });

        function toggleLeaveDateFields(clearOppositeFields) {
            const hasLeaveType = $('#type').val() !== null && $('#type').val() !== '';
            $('#separateLeaveDates').toggle(!hasLeaveType);
            $('#rangeLeaveDates').toggle(hasLeaveType);
            $('.rangeDate').prop('required', hasLeaveType);

            if (clearOppositeFields) {
                if (hasLeaveType) {
                    $('.separateDate').datepicker('update', '');
                } else {
                    $('.rangeDate').datepicker('update', '');
                }
            }
        }

        $('#type').on('change', function () {
            toggleLeaveDateFields(true);
        });
        toggleLeaveDateFields(false);

        $('#div').select2({
            placeholder: 'Pilih Jenis',
        });

        $('.timepicker').timepicker({
        });
        
    });
</script>
