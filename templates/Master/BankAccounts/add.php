<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BankAccount $bankAccount
 */
$dataChild = $this->Html->link('Akun Bank', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('Akun Bank', $dataChild, 'Buat') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($bankAccount, ['type' => 'file']) ?>
    <!-- panel head  -->
    <input type="hidden" name="is_create" value="<?= $getUser->id ?>">
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
                    <?= $this->Form->control('opening_balance', ['label' => 'Saldo Awal', 'class' => 'form-control auto', 'type' => 'text', 'placeholder' => 'Saldo Awal', 'autocomplete' => 'off', 'escape'=>false]); ?>
                </div>
            </div> -->
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
    // var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    // var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'BankAccounts', 'action' => 'add'], ['fullBase' => true]); ?>";
    // handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

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

    $('form').on('submit', function (e) {
        e.preventDefault(); // cegah submit langsung

        if (!validation()) return;

        SwalHelper.warning('Apakah Anda yakin ingin menyimpan?', '', 'Ya, Simpan', 'Batal')
            .then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // submit form jika lolos validasi dan dikonfirmasi
                }
            });
    });
 });
function validation() {
    const norek = ($('input[name="account_number"]').val() || '').trim();
    const namaRekening = ($('input[name="account_holder"]').val() || '').trim();
    // const saldo = ($('input[name="opening_balance"]').val() || '').trim();
    const name = $('select[name="bank_name"]').val();
    // const unit = $('select[name="unit"]').val();
    // const code = ($('input[name="code"]').val() || '').trim();

    if (!name) {
        SwalHelper.warning('Nomor Rekening wajib diisi!');
        return false;
    }

    if (!norek) {
        SwalHelper.warning('Nomor Rekening wajib diisi!');
        return false;
    }

    if (!namaRekening) {
        SwalHelper.warning('Nama Rekening wajib diisi!');
        return false;
    }

    // if (!saldo) {
    //     SwalHelper.warning('Saldo wajib diisi!');
    //     return false;
    // }

    return true;
}
</script>