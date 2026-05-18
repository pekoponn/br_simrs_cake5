<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicine $medicine
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 * @var string[]|\Cake\Collection\CollectionInterface $medicineMerks
 * @var string[]|\Cake\Collection\CollectionInterface $medicineGroups
 */
$dataChild = $this->Html->link('Obat', ['action' => 'index'], ['full_base'=>true]);
?>
<?= $this->Krs->breadcrumb('Master', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <?= $this->Form->create($medicine, ['data-parsley-validate'=>'true']) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body">        
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-1">Kode KFA</label>
            <div class="col-md-2">
                <div class="input-group m-b-2">
                    <?php
                    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]); 
                    echo $this->Form->control('codes', ['label' => false, 'class'=>'form-control', 'placeholder'=>'Kode KFA..', 'data-parsley-required-message'=>"Kode tidak boleh kosong!", 'required'=>true, 'autofocus'=>true, 'value'=>$medicine->code_kfa]);
                    ?>
                </div>
            </div>
            <label class="col-form-label col-md-2">Nama Barang</label>
            <div class="col-md-3">
                <?php   
                echo $this->Form->control('medicineGroup', ['label'=>false, 'class' => 'form-control', 'error' => false, 'placeholder'=>'Nama Barang..', 'value'=>$medicine->medicine_group_name]);
                //echo $this->Form->control('medicine_group_id', array('label' => false, 'empty'=>false, 'options'=>$medicineGroups, 'data-placeholder'=>'Nama Barang..', 'class'=>'form-control select2Form', 'id'=>'selectType', 'default'=>$medicine->medicine_group_id));
                ?>
            </div>
            <label class="col-form-label col-md-1">Merk</label>
            <div class="col-md-3">
                <?php   
                 echo $this->Form->control('medicineMerk', ['label'=>false, 'class' => 'form-control', 'error' => false, 'placeholder'=>'Merk..', 'value'=>$medicine->medicine_merk_name]);
                 // echo $this->Form->control('medicine_merk_id', array('label' => false, 'empty'=>false, 'options'=>$medicineMerks, 'data-placeholder'=>'Merk..', 'class'=>'form-control select2Form', 'default'=>$medicine->medicine_merk_id));
                ?>
            </div>
        </div>
        <div class="form-group row m-b-15">            
            <label class="col-form-label col-md-1">Nama*</label>
            <div class="col-md-7">
                <?php   
                echo $this->Form->control('name', ['label'=>false, 'class' => 'form-control', 'error' => false, 'placeholder'=>'Nama..', 'data-parsley-required-message'=>"Nama tidak boleh kosong!", 'required'=>true, 'value'=>$medicine->name]);
                //, 'id'=>'checkName'
                ?>
            </div>
            <label class="col-form-label col-md-1">Jenis</label>
            <div class="col-md-2">
                <?php   
                echo $this->Form->control('type', array('label' => false, 'empty'=>false, 'options'=>$this->Krs->typeScm(), 'data-placeholder'=>'Jenis..', 'class'=>'form-control select2Form', 'default'=>$medicine->type));
                ?>
            </div>
            <?php
            /*
            <label class="col-form-label col-md-1">Stock Awal</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->control('stockBeginning', ['label'=>false, 'class' => 'form-control qty', 'error' => false, 'autocomplete'=>'off', 'placeholder'=>'Stock Awal..']);
                ?>
            </div>
            */
            ?>
        </div>
        <div class="form-group row m-b-15">            
            <label class="col-form-label col-md-1">Satuan</label>
            <div class="col-md-4">
                <div class="input-group m-b-12">
                    <div class="input-group-prepend">
                    <?php
                    echo $this->Form->control('qtyUnit', ['label'=>false, 'class' => 'form-control qty', 'error' => false, 'placeholder'=>'Satuan..', 'value'=>$medicine->qty_unit]);
                    ?>
                    </div>
                    <?php
                    echo $this->Form->control('unit', array('label' => false, 'empty'=>false, 'options'=>$this->Krs->unitAsset(), 'data-placeholder'=>'Jenis..', 'class'=>'form-control select2Form', 'style'=>'width: 100px;', 'default'=>$medicine->unit));
                    ?>
                </div>
            </div>
            <label class="col-form-label col-md-1">Kemasan</label>
            <div class="col-md-4">
                <div class="input-group m-b-12">
                    <div class="input-group-prepend">
                    <?php
                    echo $this->Form->control('qtyPackaging', ['label'=>false, 'class' => 'form-control qty', 'error' => false, 'placeholder'=>'Kemasan..', 'value'=>$medicine->qty_packaging]);
                    ?>
                    </div>
                    <?php
                    echo $this->Form->control('packaging', array('label' => false, 'empty'=>false, 'options'=>$this->Krs->unitAsset(), 'data-placeholder'=>'Jenis..', 'class'=>'form-control select2Form', 'style'=>'width: 100px;', 'default'=>$medicine->packing));
                    ?>
                </div>
            </div>
            
        </div>
        <div class="form-group row m-b-15">            
            <label class="col-form-label col-md-1">Keterangan</label>
            <div class="col-md-11">
                <?php   
                echo $this->Form->control('desc', ['label'=>false, 'class' => 'form-control', 'error' => false, 'placeholder'=>'Keterangan..', 'value'=>$medicine->description]);
                //, 'title'=>"Keterangan tidak boleh kosong!", 'required'=>true
                //, 'id'=>'checkName'
                ?>
            </div>
        </div>
    </div>
    <?= $this->Krs->btnSave(); ?> 
    <?= $this->Form->end() ?>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'Medicines', 'action' => 'edit', $medicine->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('PlacementAddForm', 'btn-add', confirmTitle, formAction);

    $(".select2Form").select2();
    $(".select2FormClear").select2({ allowClear: true });
    
    $('#chkCode').change(function(){
        if ($('#chkCode').is(':checked') == true){
            $('#noCode').prop('disabled', false);
        } else {
            $('#noCode').prop('disabled', true);
        }
    });
});
</script>

<?php
/*
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $medicine->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $medicine->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Medicines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicines form content">
            <?= $this->Form->create($medicine) ?>
            <fieldset>
                <legend><?= __('Edit Medicine') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('medicine_merk_id', ['options' => $medicineMerks]);
                    echo $this->Form->control('medicine_group_id', ['options' => $medicineGroups]);
                    echo $this->Form->control('code');
                    echo $this->Form->control('code_kfa');
                    echo $this->Form->control('name');
                    echo $this->Form->control('code_ifrs');
                    echo $this->Form->control('merk');
                    echo $this->Form->control('type');
                    echo $this->Form->control('description');
                    echo $this->Form->control('img');
                    echo $this->Form->control('qty_unit');
                    echo $this->Form->control('unit');
                    echo $this->Form->control('qty_packaging');
                    echo $this->Form->control('packaging');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_print');
                    echo $this->Form->control('printed', ['empty' => true]);
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_log');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
*/
?>