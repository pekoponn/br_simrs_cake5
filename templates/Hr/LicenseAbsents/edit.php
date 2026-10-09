<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LicenseAbsent $licenseAbsent
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 */
echo $this->Html->script(['/plugins/tinymce/tinymce.min', '/plugins/tinymce/tinymce.setting'], ['fullBase' => true]);
$dataChild = $this->Html->link('Tidak Masuk', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Edit') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($licenseAbsent, ['type' => 'file']) ?>
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
                <div class="col-md-3">
                    <?php
                    echo $this->Krs->inputDateRange('date_from', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value'=>date_format($licenseAbsent['date_from'], 'd-m-Y')), 'date_end', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...', 'value'=>date_format($licenseAbsent['date_end'], 'd-m-Y')), 's/d', 'resetDate');
                    ?>
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-form-label col-md-1">Keperluan :</label>
                <div class="col-md-3">
                    <?php echo $this->Form->control('type', [
                        'label' => false,
                        'options' => $this->Krs->descLeaves(),
                        'class' => 'form-control types',
                        'empty' => '-- Pilih Keperluan --',
                        'value' => $licenseAbsent->type . '^' . $licenseAbsent->absent_days,
                    ]); ?>
                </div>
                <label class="col-form-label col-md-1">Berkas :</label>
                <div class="col-md-4">
                    <div class="form-group">
                        <?= $this->Form->control('files', [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'file',
                            'accept' => 'application/pdf',
                            'required' => false
                        ]); ?>
                        <?php if (!empty($licenseAbsent->files)) : ?>
                        <div class="mb-2">
                            <a href="<?= $this->Url->build('/files/' . h($licenseAbsent->files)) ?>"
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
            <?= $this->Form->control('description', ['label' => 'Deskripsi', 'class' => 'form-control', 'type' => 'textarea', 'value'=>$this->Krs->fDecode($licenseAbsent->description)]); ?>

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
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'LicenseAbsents', 'action' => 'edit', $licenseAbsent->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

    datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');

    $('.types').select2({
        placeholder: 'Pilih salah satu keperluan',
    });

    $('#div').select2({
        placeholder: 'Pilih Jenis',
    });

    $('.tanggal').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).datepicker('setDate', 'now');


    $('.timepicker').timepicker({
    });
    
});
</script>
