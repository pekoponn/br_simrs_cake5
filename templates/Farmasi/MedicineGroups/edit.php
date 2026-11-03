<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicineGroup $medicineGroup
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 */
$dataChild = $this->Html->link('Group', ['action' => 'index'], ['full_base'=>true]);
?>
<?= $this->Krs->breadcrumb('Master', $dataChild, 'Ubah') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <?= $this->Form->create($medicineGroup, ['data-parsley-validate'=>'true']) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body">        
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-1">Kode</label>
            <div class="col-md-4">
                <div class="input-group m-b-2">
                    <?php
                    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]); 
                    echo $this->Form->control('codes', ['label' => false, 'class'=>'form-control', 'placeholder'=>'Kode Otomatis..', 'id'=>'noCode', 'value'=>$medicineGroup->code, 'disabled'=>true]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group row m-b-15">            
            <label class="col-form-label col-md-1">Nama*</label>
            <div class="col-md-6">
                <?php   
                echo $this->Form->control('name', ['label'=>false, 'class' => 'form-control', 'error' => false, 'placeholder'=>'Nama..', 'data-parsley-required-message'=>"Nama tidak boleh kosong!", 'required'=>true, 'autofocus'=>true, 'value'=>$medicineGroup->name]);
                //, 'id'=>'checkName'
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
            <label class="col-form-label col-md-1">Keterangan</label>
            <div class="col-md-11">
                <?php   
                echo $this->Form->control('desc', ['label'=>false, 'class' => 'form-control', 'error' => false, 'placeholder'=>'Keterangan..', 'value'=>$medicineGroup->description]);
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
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Farmasi', 'controller' => 'MedicineGroups', 'action' => 'edit', $medicineGroup->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('FormAdd', 'btn-add', confirmTitle, formAction);

    $(".select2Form").select2();
    
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
                ['action' => 'delete', $medicineGroup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $medicineGroup->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Medicine Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicineGroups form content">
            <?= $this->Form->create($medicineGroup) ?>
            <fieldset>
                <legend><?= __('Edit Medicine Group') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('code');
                    echo $this->Form->control('name');
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