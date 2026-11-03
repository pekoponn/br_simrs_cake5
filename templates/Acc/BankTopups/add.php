<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BankTopup $bankTopup
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 */
$dataChild = $this->Html->link('Perpindahan Buku', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('Acc', $dataChild, 'Buat') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($bankTopup, ['type' => 'file']) ?>
    <!-- panel head  -->
    <input type="hidden" name="is_create" value="<?= $getUser->id ?>">
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="btn-group">
                <div class="portlet-body">
                <h4 class="text-inverse">DATA PERPINDAHAN BUKU</h4>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <!-- <div class="col-md-2">
                <div class="form-group">
                
                <?php
                $allProjects = $this->Krs->businessUnit();
                $optionsProject = [];
                $disabled = false;
                if ($getUser->project_status == 'Y') {
                    $optionsProject = $allProjects;
                } elseif (!empty($getUser->pettycash_devision)) {
                    // Tidak full akses -> hanya project user + project tambahan
                    $allowedProjects = array_filter(array_map('trim', explode(',', $getUser->pettycash_devision)));
                    if (!empty($getUser->project)) {
                        $allowedProjects[] = $getUser->project;
                    }
                    $allowedProjects = array_unique($allowedProjects);
                    foreach ($allowedProjects as $project) {
                        if (isset($allProjects[$project])) {
                            $optionsProject[$project] = $allProjects[$project];
                        }
                    }
                } else {
                    // Tidak full akses & tidak punya tambahan project
                    $optionsProject = [
                        $getUser->project => $allProjects[$getUser->project] ?? $getUser->project
                    ];
                    $disabled = true;
                } 
                echo $this->Form->control('ubs', ['type' => 'select', 'options' => $optionsProject, 'class' => 'form-control select2Form', 'default' => $getUser->project, 'disabled' => $disabled, 'label' => 'UBS <span class="text-danger">*</span>', 'data-placeholder' => 'Silakan pilih..', 'empty' => false, 'required' => true, 'escape' => false]);
                if ($disabled) {
                    echo $this->Form->hidden('ubs', ['value' => $getUser->project]);
                } ?>
                </div>
            </div> -->
            <div class="col-md-2">
                <div class="form-group">
                <?= $this->Form->control('payment_type', ['label' => 'Bank Asal <span class="text-danger">*</span>', 'class' => 'form-control select2Form', 'empty' => 'Nama bank', 'autocomplete' => 'off', 'escape' => false, 'options' => $this->Krs->bankName()]); ?>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <?= $this->Form->control('nominal', ['label' => 'Nominal <span class="text-danger">*</span>', 'class' => 'form-control auto', 'type' => 'text', 'placeholder' => 'Nominal', 'autocomplete' => 'off', 'escape'=>false, 'empty' => true]); ?>
                </div>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                     <?= $this->Form->control('acc_coa_id', ['label' => 'COA Penyetor <span class="text-danger">*</span>', 'empty' => true, 'class' => 'form-control', 'id'=>'checkCOACash', 'placeholder' => 'Masukkan nama Perkiraan Kas', 'type'=>'select', 'data-parsley-errors-container' => '#check-item', 'data-parsley-required-message'=>"Dari Kas tidak boleh kosong!", 'required'=>true, 'escape'=>false]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                     <?= $this->Form->control('acc_coa_to_id', ['label' => 'COA Tujuan <span class="text-danger">*</span>', 'empty' => true, 'class' => 'form-control', 'id'=>'checkCOATo', 'placeholder' => 'Masukkan nama Perkiraan Kas', 'type'=>'select', 'data-parsley-errors-container' => '#check-item', 'data-parsley-required-message'=>"Dari Kas tidak boleh kosong!", 'required'=>true, 'escape'=>false]); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php for ($i = 1; $i <= 2; $i++) : ?>
                <div class="col-md-2">
                    <div class="form3-group">
                        <?= $this->Form->control('file_' . $i, [
                            'type' => 'file',
                            'label' => 'Bukti Transfer ' . $i,
                            'class' => 'form-control',
                            'accept' => 'image/jpeg,image/png,image/jpg',
                            'required' => false
                        ]); ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <?= $this->Form->control('description', ['label' => 'Deskripsi', 'type' => 'textarea', 'class' => 'form-control', 'escape'=>false, 'placeholder' => 'Deskripsi']); ?>
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
    // var formAction = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'BankTopups', 'action' => 'add'], ['fullBase' => true]); ?>";
    // handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
    var checkListCoaCash = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'BankTopups', 'action' => 'getList']); ?>";
	handleFormSelect2Search('checkCOACash', 'Masukkan Nama Perkiraan Kas', 2, checkListCoaCash);
    var checkListCoaTo = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'BankTopups', 'action' => 'getList']); ?>";
	handleFormSelect2Search('checkCOATo', 'Masukkan Nama Perkiraan Kas', 2, checkListCoaTo);

    $('.select2Form').select2({ autoclose: true });
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
    const nominal = ($('input[name="nominal"]').val() || '').trim();
    const bank = $('select[name="payment_type"]').val();
    // const ubs = $('select[name="ubs"]').val();
    const coa = $('select[name="acc_coa_id"]').val();
    const file1 = $('input[name="file_1"]').val();
    const file2 = $('input[name="file_2"]').val();

    if (!nominal) {
        SwalHelper.warning('Nominal wajib diisi!');
        return false;
    }
    // if (!ubs) {
    //     SwalHelper.warning('UBS wajib diisi!');
    //     return false;
    // }
    if (!bank) {
        SwalHelper.warning('Bank wajib diisi!');
        return false;
    }
    if (!coa) {
        SwalHelper.warning('COA wajib diisi!');
        return false;
    }
    if (!file1 && !file2) {
        SwalHelper.warning('Minimal upload 1 Bukti Transfer!');
        return false;
    }
    // if (!saldo) {
    //     SwalHelper.warning('Saldo wajib diisi!');
    //     return false;
    // }

    return true;
}
</script>