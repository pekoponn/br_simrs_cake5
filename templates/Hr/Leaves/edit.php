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
                <!-- <label class="col-form-label col-md-1">Tanggal :</label>
                <div class="col-md-4">                   
                    <?php
                    echo $this->Krs->inputDateRange('date_from', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value'=>date_format($leave['date_from'], 'd-m-Y')), 'date_end', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value'=>date_format($leave['date_end'], 'd-m-Y')), 's/d', 'resetDate');
                    ?>
                    <muted class="text-muted">*Pengajuan cuti minimal 14 hari sebelum tanggal cuti</muted>
                </div> -->
                <div class="col-md-2">
                    <label>Tanggal Cuti 1</label>
                    <div class="input-group">
                        <?= $this->Form->control('date_1', ['label' => false, 'type' => 'text', 'class' => 'form-control filterDate', 'placeholder' => '-- Pilih Tanggal --', 'readonly' => true, 'value'=>!empty($leave->date_1) ? $leave->date_1->format('d-m-Y') : '' ]); ?>
                        <span class="input-group-btn">
                            <button class="btn btn-inverse resetDate" type="button" data-target="date_1"><i class="fa fa-times"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Tanggal Cuti 2</label>
                    <div class="input-group">
                        <?= $this->Form->control('date_2', ['label' => false, 'type' => 'text', 'class' => 'form-control filterDate', 'placeholder' => '-- Pilih Tanggal --', 'readonly' => true, 'value'=>!empty($leave->date_2) ? $leave->date_2->format('d-m-Y') : ''
                        ]); ?>
                        <span class="input-group-btn">
                            <button class="btn btn-inverse resetDate" type="button" data-target="date_2"><i class="fa fa-times"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Tanggal Cuti 3</label>
                    <div class="input-group">
                        <?= $this->Form->control('date_3', ['label' => false, 'type' => 'text', 'class' => 'form-control filterDate', 'placeholder' => '-- Pilih Tanggal --', 'readonly' => true, 'value'=>!empty($leave->date_3) ? $leave->date_3->format('d-m-Y') : ''
                        ]); ?>
                        <span class="input-group-btn">
                            <button class="btn btn-inverse resetDate" type="button" data-target="date_3"><i class="fa fa-times"></i></button>
                        </span>
                    </div>
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
        datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');
        $('.filterDate').datepicker('destroy');

        $('.filterDate').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            startDate: '<?= $minLeaveDate ?>'
        });

        $('.types').select2({
            // placeholder: 'Pilih salah satu keperluan',
        });

        $('#div').select2({
            placeholder: 'Pilih Jenis',
        });

        $('.tanggal').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });


        $('.timepicker').timepicker({
        });
        
    });
</script>