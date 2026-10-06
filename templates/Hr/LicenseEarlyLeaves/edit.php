<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LicenseEarlyLeave $licenseEarlyLeave
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 */
echo $this->Html->script(['/plugins/tinymce/tinymce.min', '/plugins/tinymce/tinymce.setting'], ['fullBase' => true]);
$dataChild = $this->Html->link('Ijin Pulang', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Edit') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($licenseEarlyLeave, ['type' => 'file']) ?>
    <!-- panel head  -->
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="form-group row m-b-15">
                <label class="col-form-label col-md-1">Divisi :</label>
                <div class="col-md-2">
                    <?php echo $this->Form->control('devision', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext', 'value' => $getUser->devision]); ?>
                </div>
                <label class="col-form-label col-md-1">Jabatan :</label>
                <div class="col-md-3">
                    <?php echo $this->Form->control('position', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext', 'value' => $getUser->position]); ?>
                    <?php echo $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
                    <?php echo $this->Form->control('position', ['type' => 'hidden', 'value' => $getUser->position]); ?>
                    <?php echo $this->Form->control('devision', ['type' => 'hidden', 'value' => $getUser->devision]); ?>
                </div>
                <label class="col-form-label col-md-1">Tanggal :</label>
                <div class="col-md-2">
                    <?php 
                    echo $this->Form->control('date', ['label' => false,'class' => 'form-control tanggal', 'type' => 'text', 'empty' => '-- Pilih Tanggal --', 'value' => date_format($licenseEarlyLeave['date'], 'd-m-Y')
                    ]); 
                    ?>
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-form-label col-md-1">Jam Pulang :</label>
                <div class="col-md-2">
                    <?php echo $this->Form->control('time_from', ['label' => false, 'class' => 'form-control clockpicker', 'type'=>'text', 'placeholder' => '-- Pilih Jam --']); ?>
                </div>
                <label class="col-form-label col-md-1">Keperluan :</label>
                <div class="col-md-3">
                    <?php echo $this->Form->control('type', ['label' => false, 'options' => ['Sakit' => 'Sakit', 'Keperluan Pribadi' => 'Keperluan Pribadi', 'Lain-lain' => 'Lain-lain'], 'class' => 'form-control types', 'empty' => '-- Pilih Keperluan --']); ?>
                </div>
                <label class="col-form-label col-md-1">Berkas :</label>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= $this->Form->control('files', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'file',
                            'accept' => 'application/pdf',
                            'required' => false
                        ]); ?>
                        <?php if (!empty($licenseEarlyLeave->files)) : ?>
                        <div class="mb-2">
                            <a href="<?= $this->Url->build('/files/' . h($licenseEarlyLeave->files)) ?>"
                            target="_blank"
                            class="btn btn-xs btn-info">
                                <i class="fa fa-eye"></i> Lihat File
                            </a>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <hr>
            <?= $this->Form->control('description', ['label' => 'Deskripsi', 'class' => 'form-control', 'type' => 'textarea', 'value'=>$this->Krs->fDecode($licenseEarlyLeave->description)]); ?>

        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'LicenseEarlyLeaves', 'action' => 'edit', $licenseEarlyLeave->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

    datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');

    $('.types').select2({
        placeholder: 'Pilih salah satu keperluan',
    });

    $('#div').select2({
        placeholder: 'Pilih Jenis',
    });

    $('.clockpicker').clockpicker({
        'default': 'now',
        vibrate: true,
        placement: "bottom",
        align: "left",
        autoclose: true,
    });

    $('.tanggal').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).datepicker('setDate', 'now');


    $('.timepicker').timepicker({
    });
    
});
</script>