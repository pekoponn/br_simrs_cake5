<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Overtime $overtime
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 */
echo $this->Html->script(['/plugins/tinymce/tinymce.min', '/plugins/tinymce/tinymce.setting'], ['fullBase' => true]);
$dataChild = $this->Html->link('Lembur', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Buat') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($overtime) ?>
   
    <!-- panel head  -->
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="form-group row m-b-15">
                <label class="col-form-label col-md-1">Divisi :</label>
                <div class="col-md-5">
                    <?php echo $this->Form->control('devision', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext', 'value' => $getUser->devision]); ?>
                </div>
                <label class="col-form-label col-md-1">Jabatan :</label>
                <div class="col-md-5">
                   <?php echo $this->Form->control('position', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext', 'value' => $getUser->position]); ?>
                    <?php echo $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
                    <?php echo $this->Form->control('position', ['type' => 'hidden', 'value' => $getUser->position]); ?>
                    <?php echo $this->Form->control('devision', ['type' => 'hidden', 'value' => $getUser->devision]); ?>
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-form-label col-md-1">Tanggal :</label>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-5">
                        <?= $this->Form->control('date', ['label' => false, 'class' => 'form-control tanggal', 'type' => 'text', 'autocomplete' => 'off', 'value' => $overtime->date == '' ? '' : date_format($overtime->date, 'd-m-Y')]); ?>
                        </div>
                    </div>
                </div>
                <label class="col-form-label col-md-1">Jam :</label>
                <div class="col-md-4">
                    <div class="row">
                       <div class="col-md-5">
                            <div class="input-group ">
                                <?php
                                echo $this->Form->input('time_from', array('class' => 'form-control clockpicker', 'error' => false, 'placeholder' => 'Jam..', 'value'=>$overtime->time_from, 'readonly'=>true));
                                ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2" align="center"><input type="text" readonly class="form-control-plaintext" value="Sampai"></div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <?php
                                echo $this->Form->input('time_end', array('class' => 'form-control clockpicker', 'error' => false, 'placeholder' => 'Jam..', 'value'=>$overtime->time_end, 'readonly'=>true));

                                ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>


            <hr>
            <?= $this->Form->control('description', ['label' => 'Deskripsi', 'class' => 'form-control', 'type' => 'textarea', 'value' => base64_decode($overtime->description)]); ?>

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
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'overtimes', 'action' => 'edit',$overtime->id ], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('.clockpicker').clockpicker({
            'default': 'now',
            vibrate: true,
            placement: "bottom",
            align: "left",
            autoclose: true,
        });
        
        $('#div').select2({
            placeholder: 'Pilih Jenis',
        });

        $('.tgl').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });


        $('.waktu').timepicker({
        });
        
    });
</script>