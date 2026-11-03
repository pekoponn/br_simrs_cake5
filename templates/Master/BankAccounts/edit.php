<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BankAccount $bankAccount
 */
$dataChild = $this->Html->link('Akun Bank', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('Akun Bank', $dataChild, 'Ubah') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($bankAccount, ['type' => 'file']) ?>
    <!-- panel head  -->
    <input type="hidden" name="is_update" value="<?= $getUser->id ?>">
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="btn-group">
                <div class="portlet-body">
                <h4 class="text-inverse">DATA BANK ACCOUNT</h4>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                <?= $this->Form->control('bank_name', ['label' => 'Nama Bank<span class="text-danger">*</span>', 'class' => 'form-control select2', 'empty' => 'Nama bank', 'autocomplete' => 'off', 'escape' => false, 'options' => $this->Krs->bankName()]); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('account_holder', ['label' => 'Nama Rekening <span class="text-danger">*</span>', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'Nama Rekening', 'autocomplete' => 'off', 'escape'=>false]); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('account_number', ['label' => 'Nomor Rekening <span class="text-danger">*</span>', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'Nomor Rekening', 'autocomplete' => 'off', 'escape'=>false]); ?>
                </div>
            </div>
            <!-- <div class="col-md-2">
                <div class="form-group">
                    <?= $this->Form->control('opening_balance', ['label' => 'Saldo Awal', 'class' => 'form-control auto', 'type' => 'text', 'placeholder' => 'Saldo Awal', 'autocomplete' => 'off', 'escape'=>false, 'readonly' => true, 'value'=> $this->Krs->nom($bankAccount->opening_balance)]); ?>
                </div>
            </div> -->
        </div>  
        <div class="row">
            <div class="form-group">
                <div class="form-check">
                    <?= $this->Form->checkbox('is_active', ['value' => 'Y', 'hiddenField' => 'N','id' => 'checkbox-approve', 'class' => 'form-check-input', 'label' => false]); ?>
                     <!-- 'checked' => true,  -->
                    <label for="checkbox-approve" class="form-check-label ml-1">
                        Nonaktifkan akun bank ini
                    </label>
                </div>
                <small class="text-muted d-block ml-4 mt-1">
                    Centang untuk aktif, hapus centang untuk nonaktifkan akun bank ini. Nonaktifkan akun bank ini jika tidak digunakan lagi.
                </small>
            </div>
        </div>
        <?= $this->Form->control('description', ['label' => 'Deskripsi', 'type' => 'textarea', 'class' => 'form-control', 'id' => 'form-control', 'escape'=>false, 'placeholder' => 'Deskripsi']); ?>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'submit', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Master', 'controller' => 'BankAccounts', 'action' => 'edit', $bankAccount->id ], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

    $(".satuan").select2({
      placeholder: "Pilih salah satu satuan"
    });
    $('.select2').select2({ autoclose: true });
    $('.tgl').datepicker({format: 'dd-mm-yyyy', autoclose: true, todayHighlight: true});

    function autoNumber() {
        $('input.auto').autoNumeric({aSep: '.', aDec: ','});
        //, mDec: 0
        $('input.qty').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000'});
        $('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});
    }
    autoNumber();

    function hotkeyEnter(){
        $('input').keydown( function(e) {
            var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
            if(key == 13) {
                e.preventDefault();
                var inputs = $(this).closest('form').find(':input:visible');
                inputs.eq( inputs.index(this)+ 1 ).focus();
            }
        });
    }
 });

</script>