<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount $accChartOfAccount
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 * @var \Cake\Collection\CollectionInterface|string[] $parentAccChartOfAccounts
 */
$dataChild = $this->Html->link('Perkiraan (Group/Level 1)', ['action' => 'index'], ['full_base'=>true]);
?>
<?= $this->Krs->breadcrumb('Accounting', $dataChild, 'Buat') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <?= $this->Form->create($accChartOfAccount) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body bg-warning-transparent-4">
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kode</label>
            <div class="col-md-4">
                <?php
                //echo $this->Form->input("code", array("class" => "form-control", "error" => false, "autocomplete"=>"off"));
                echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);

                ?>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <?php
                        echo $this->Form->hidden('check_coa', array('value' => 'N'));
                        echo $this->Form->input('check_coa', array('label' => false, 'hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'id'=>'chkCode'));
                        ?>
                        </div>
                    </div>
                    <?php
                    echo $this->Form->input('code', array('class' => 'form-control is-valid', 'placeholder'=>'Kode Otomatis..', 'id'=>'noCode', 'disabled'=>'disabled'));
                    ?>
                    <div class="valid-feedback">Centang bila tidak menggunakan Kode otomatis.</div>
                </div>
            </div>


        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Nama</label>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4">
                    <?php
                    echo $this->Form->input("name", array("class" => "form-control", "error" => false, "autocomplete"=>"off", 'placeholder'=>'Nama..', 'id'=>'checkName', 'autofocus'=>'autofocus'));
                    ?>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group m-b-5">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <?php
                                    echo $this->Form->checkbox('check_customer', ['value' => 'Y', 'hiddenField' => 'N', 'id'=>'chkCustomer']);

                                    // echo $this->Form->hidden('check_customer', array('value' => 'N'));
                                    // echo $this->Form->input('check_customer', array('label' => false, 'hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'id'=>'chkCustomer'));
                                ?></span>
                            </div>
                            <select class="form-control is-valid" id='checkCustomer' name="customer_id" disabled="disabled"></select>
                            <?php

                            // echo $this->Form->input("customer_id", array("empty" => true, "options"=>$data['rowCustomer'], "class"=>"form-control select2-clear is-valid", "data-placeholder"=>"Silakan pilih..", 'id'=>'checkCustomer', 'disabled'=>'disabled'));
                            ?>
                            <div class="valid-feedback">Centang bila menggunakan Nama Invoice.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    <div class="panel-footer text-right bg-orange">
    <?php
    echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add']);
    ?>
    </div>   
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    "use strict";
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix'=>false, 'controller'=>'acc_chart_of_accounts', 'action' => 'add_group'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccChartOfAccountAddForm', 'btn-add', confirmTitle, formAction);

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