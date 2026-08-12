<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount $accChartOfAccount
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 * @var string[]|\Cake\Collection\CollectionInterface $parentAccChartOfAccounts
 */
$dataChild = $this->Html->link('Perkiraan', ['action' => 'index'], ['full_base'=>true]);
// pr($accChartOfAccount);
$COAParent = $accChartOfAccount['parent_account'];
$COACodes = $accChartOfAccount['code'];
$COALevel = $accChartOfAccount['level'];

$COACodeArray = explode('.', $COACodes);
$COACode = $COACodeArray[$COALevel-1];
$COACodeOld = $COACode;
// $COACode = implode('.', array_slice(explode('.', $COACodes)));
//pr($COACode);
// $COACode = ($COALevel==1) ? $COACodes : implode('.', array_slice(explode('.', $COACodes), -1));
$COAJournalType = $accChartOfAccount['journal_type'];
$COAGroup = $accChartOfAccount['groups'];
$COANormalBalance = $accChartOfAccount['normal_balance'];
$COABeginningBalanceDebet = (empty($accChartOfAccount["beginning_balance_debet"])) ? "" : $this->Krs->nom($accChartOfAccount["beginning_balance_debet"]);
$COABeginningBalanceCredit = (empty($accChartOfAccount["beginning_balance_credit"])) ? "" : $this->Krs->nom($accChartOfAccount["beginning_balance_credit"]);
$COABeginningBalanceDate = (empty($accChartOfAccount["beginning_balance_date"])) ? date('d-m-Y') : $this->Krs->fDate($accChartOfAccount["beginning_balance_date"]);
// pr($this->Krs->fDate($accChartOfAccount["beginning_balance_date"]));
// pr($accChartOfAccount['parent_id']);
$getParam = $this->request->getAttribute('params');
// pr($getParam);

$getParamCode = (isset($getParam['pass']['1'])) ? $getParam['pass']['1'] : '';
// pr($data['dataParentId']);
?>
<?= $this->Krs->breadcrumb('Accounting', $dataChild, 'Buat') ?>
<div class="panel panel-inverse">
    <?= $this->Krs->heading('Data COA'); ?>

    <?= $this->Form->create($accChartOfAccount) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body bg-gray-100">
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Jenis Jurnal</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);

                echo $this->Form->input('journal_type', ['empty'=>false, 'options'=>$this->Krs->selectCOAType(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'type'=>'select', 'default'=>$COAJournalType]);
                ?>
            </div>
            <label class="col-form-label col-md-2">Saldo Normal</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->input('normal_balance', ['empty'=>false, 'options'=>$this->Krs->statusDC(), 'data-placeholder'=>'Saldo Normal..', 'class'=>'form-control select2Form', 'type'=>'select', 'default'=>$COANormalBalance]);
                ?>
            </div>
            <label class="col-form-label col-md-2">Post</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->input('groups', ['empty'=>false, 'options'=>$this->Krs->statusPost(), 'data-placeholder'=>'Post..', 'class'=>'form-control select2Form', 'type'=>'select', 'default'=>$COAGroup]);
                ?>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kelompok</label>
            <div class="col-md-10">
                <select class="form-control" id='selGroup' name="parent">
                    <option value="<?php echo $data['dataParentId']; ?>" selected="selected"><?php echo $data['dataParentData']; ?></option>
                </select>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kode</label>
            <div class="col-md-4">
                <?php
                //echo $this->Form->input("code", array("class" => "form-control", "error" => false, "autocomplete"=>"off"));
                ?>
                <div class="input-group m-b-5">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                        <?php
                            echo $this->Form->hidden('check_coa', array('value' => 'N'));
                            echo $this->Form->input('check_coa', array('label' => false, 'hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'id'=>'chkCode'));
                        ?></span>
                    </div>
                    <?php
                    
                    echo $this->Form->hidden('level', array('value' => $COALevel));
                    echo $this->Form->hidden('code_old', array('value' => $COACode));
                    echo $this->Form->input('code', array('class' => 'form-control is-valid', 'placeholder'=>'Kode Otomatis..', 'id'=>'masked-input-code', 'value'=>$COACode));
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <?php
                                echo $this->Form->checkbox('check_customer', ['value' => 'Y', 'hiddenField' => 'N', 'id'=>'chkCustomer']);
                                
                                    // echo $this->Form->hidden('check_customer', array('value' => 'N'));
                                    // echo $this->Form->input('check_customer', array('label' => false, 'hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'id'=>'chkCustomer'));
                                ?></span>
                            </div>
                            <select class="form-control is-valid" id='checkCustomer' name="customer_ids" disabled="disabled"></select>
                            <?php

                            // echo $this->Form->input("customer_id", array("empty" => true, "options"=>$data['rowCustomer'], "class"=>"form-control select2-clear is-valid", "data-placeholder"=>"Silakan pilih..", 'id'=>'checkCustomer', 'disabled'=>'disabled'));
                            ?>
                            <div class="valid-feedback">Centang bila menggunakan Nama Invoice.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        if($COALevel=='5') {
        ?>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Saldo Awal</label>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group m-b-5">
                          <span class="input-group-text">Debit</span>
                          <?php
                          echo $this->Form->input("beginning_balance_debets", array("class" => "form-control auto", "error" => false, "autocomplete"=>"off", 'placeholder'=>'Saldo Awal Debit..', 'value'=>$COABeginningBalanceDebet));
                            ?>
                        </div>
                        <div class="input-group m-b-5">
                          <span class="input-group-text">Kredit</span>
                          <?php
                            echo $this->Form->input("beginning_balance_credits", array("class" => "form-control auto", "error" => false, "autocomplete"=>"off", 'placeholder'=>'Saldo Awal Kredit..', 'value'=>$COABeginningBalanceCredit));
                            ?>
                        </div>
                    </div>
                    <label class="col-form-label col-md-1">Per tgl</label>
                    <div class="col-md-2">
                        <div class="input-group" id="default-daterange">
                            <?php
                            //$dateStartAcc = (empty($data['sessionSetting']['acc_start_date'])) ? null : $this->Time->format( $format = 'd-m-Y', $data['sessionSetting']['acc_start_date']);
                            echo $this->Form->input('beginning_balance_dates', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>$COABeginningBalanceDate, 'readonly'=>true));
                            ?>
                            <span class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </span>
                        </div>

                    <?php
                    // echo $this->Form->input('beginning_balance_dates', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>$dateStartAcc, 'readonly'=>true));
                    ?>
                    </div>
                </div>
            </div>
        </div>        
        <?php } ?>
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
    var formAction = "<?php echo $this->Url->build(['controller'=>'acc_chart_of_accounts', 'action' => 'edit', $accChartOfAccount->id, $getParamCode], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccChartOfAccountAddForm', 'btn-add', confirmTitle, formAction);

    var checkCOAbyName = "<?php echo $this->Url->build(['controller'=>'acc_chart_of_accounts', 'action' => 'getCoa']); ?>";
    var checkCustomerbyName = "<?php echo $this->Url->build(['controller'=>'customers', 'action' => 'getSelect', 'Y']); ?>";
    handleFormSelect2Search('selGroup', 'Masukkan Nama Kelompok', 2, checkCOAbyName);
    handleFormSelect2Search('checkCustomer', 'Masukkan Nama Invoice', 2, checkCustomerbyName);

    /*$('#selGroup').select2({
        placeholder: 'Masukkan Nama Kelompok',
        minimumInputLength: 2,
        ajax: {
            dataType: 'json',
            url: checkCOAbyName,
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                }
            },
            processResults: function(data, page) {
                return {
                    results: data
                };
            },
            cache: true,
        }
    });*/


    $("#datepicker-autoClose").datepicker({
        todayHighlight: true,
        autoclose: true
    });

    $(".select2Form").select2();
    
    // $("#masked-input-code").mask("9.99.9.99.9999");

    $('input.auto').autoNumeric({aSep: '.', aDec: ',', vMin: '-9999999999999.99', vMax: '9999999999999.99'});

    $('#chkCustomer').change(function(){
        if ($('#chkCustomer').is(':checked') == true){
            $('#checkCustomer').prop('disabled', false);
            $('#checkName').prop('disabled', true);
            $('#checkName').prop('value', "");
        } else {
            $('#checkCustomer').prop('disabled', true);
            $('#checkName').prop('disabled', false);        
        }
    });

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
                ['action' => 'delete', $accChartOfAccount->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $accChartOfAccount->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Acc Chart Of Accounts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accChartOfAccounts form content">
            <?= $this->Form->create($accChartOfAccount) ?>
            <fieldset>
                <legend><?= __('Edit Acc Chart Of Account') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('parent_id', ['options' => $parentAccChartOfAccounts]);
                    echo $this->Form->control('level');
                    echo $this->Form->control('parent_account');
                    echo $this->Form->control('header_account');
                    echo $this->Form->control('sub_header_account');
                    echo $this->Form->control('code');
                    echo $this->Form->control('name');
                    echo $this->Form->control('type');
                    echo $this->Form->control('contra_account');
                    echo $this->Form->control('mapping');
                    echo $this->Form->control('group');
                    echo $this->Form->control('sub_group');
                    echo $this->Form->control('sub_group_no');
                    echo $this->Form->control('default');
                    echo $this->Form->control('journal_type');
                    echo $this->Form->control('transaction');
                    echo $this->Form->control('description');
                    echo $this->Form->control('character');
                    echo $this->Form->control('code_additional');
                    echo $this->Form->control('additional');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
*/
?>