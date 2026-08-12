<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount $accChartOfAccount
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 * @var \Cake\Collection\CollectionInterface|string[] $parentAccChartOfAccounts
 */
$dataChild = $this->Html->link('Perkiraan', ['action' => 'index'], ['full_base'=>true]);
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

                echo $this->Form->input('journal_type', ['empty'=>false, 'options'=>$this->Krs->selectCOAType(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'type'=>'select']);
                ?>
            </div>
            <label class="col-form-label col-md-2">Saldo Normal</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->input('normal_balance', ['empty'=>false, 'options'=>$this->Krs->statusDC(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'type'=>'select']);
                ?>
            </div>
            <label class="col-form-label col-md-2">Post</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->input('groups', ['empty'=>false, 'options'=>$this->Krs->statusPost(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'type'=>'select']);
                ?>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kelompok</label>
            <div class="col-md-10">
                <?php
                // required
                ?>
                <select id="selGroup" class="form-control" name="parent">
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kode</label>
            <div class="col-md-4">
                <?php
                //echo $this->Form->input("code", array("class" => "form-control", "error" => false, "autocomplete"=>"off"));
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
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Saldo Awal</label>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group m-b-5">
                          <span class="input-group-text">Debit</span>
                          <?php
                            echo $this->Form->input("beginning_balance_debets", array("class" => "form-control auto", "error" => false, "autocomplete"=>"off", 'placeholder'=>'Saldo Awal Debit..'));
                            ?>
                        </div>
                        <div class="input-group m-b-5">
                          <span class="input-group-text">Kredit</span>
                          <?php
                            echo $this->Form->input("beginning_balance_credits", array("class" => "form-control auto", "error" => false, "autocomplete"=>"off", 'placeholder'=>'Saldo Awal Kredit..'));
                            ?>
                        </div>
                    </div>
                    <label class="col-form-label col-md-1">Per tgl</label>
                    <div class="col-md-2">
                        <div class="input-group" id="default-daterange">
                            <?php
                            $dateStartAcc = (empty($data['sessionSetting']['acc_start_date'])) ? null : $this->Time->format( $format = 'd-m-Y', $data['sessionSetting']['acc_start_date']);
                            echo $this->Form->input('beginning_balance_dates', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>date('d-m-Y'), 'readonly'=>true));
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
    var formAction = "<?php echo $this->Url->build(['controller'=>'acc_chart_of_accounts', 'action' => 'add'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccChartOfAccountAddForm', 'btn-add', confirmTitle, formAction);

    var checkCOAbyName = "<?php echo $this->Url->build(['controller'=>'acc_chart_of_accounts', 'action' => 'getCoa']); ?>";
    var checkCustomerbyName = "<?php echo $this->Url->build(['controller'=>'customers', 'action' => 'getSelect', 'Y']); ?>";
    //var checkCustomerbyName = "<?php echo $this->Url->build(['controller'=>'customers', 'action' => 'getSearch', 'Y']); ?>";
    
    handleFormSelect2Search('selGroup', 'Masukkan Nama Kelompok', 2, checkCOAbyName);
    handleFormSelect2Search('checkCustomer', 'Masukkan Nama Invoice', 2, checkCustomerbyName);

    $("#datepicker-autoClose").datepicker({
        todayHighlight: true,
        autoclose: true
    });

    $(".select2Form").select2();

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