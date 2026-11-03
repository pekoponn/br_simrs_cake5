<?php
$dataChild = $this->Html->link('Cabang', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Edit') ?>

<?= $this->Form->create($branch, ['id' => 'GroupAddForm','data-parsley-validate' => 'true' , 'type' => 'file']) ?>

<div class="panel panel-inverse">

    <?= $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

    <div class="panel-body">

        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('code', [
                        'label' => 'Kode Cabang',
                        'class' => 'form-control',
                        'readonly' => true,
                        'escape' => false
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('name', [
                        'label' => 'Nama Cabang <span class="text-danger">*</span>',
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan nama cabang...',
                        'autocomplete' => 'off',
                        'escape' => false,
                        'required' => true
                    ]); ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('company_name', [
                        'label' => 'Nama Perusahaan <span class="text-danger">*</span>',
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan nama perusahaan...',
                        'autocomplete' => 'off',
                        'escape' => false,
                        'required' => true
                    ]); ?>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('company_telp', [
                        'label' => 'No. Telepon',
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan nomor telepon...',
                        'autocomplete' => 'off'
                    ]); ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('email', [
                        'label' => 'Email',
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan email...',
                        'autocomplete' => 'off'
                    ]); ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('company_address', [
                        'label' => 'Alamat Perusahaan',
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan alamat perusahaan...',
                        'autocomplete' => 'off'
                    ]); ?>
                </div>
            </div>
        </div>
        <div></div>
        <div class="form-group row m-b-15">
            <!-- <label class="col-form-label col-md-1">Tanda Tangan</label> -->
            <div class="col-md-2">
                <div class="form3-group">
                    <?= $this->Form->control('sign_1', [
                        'type' => 'file',
                        'label' => 'Tanda Tangan',
                        'class' => 'form-control',
                        'accept' => 'image/jpeg,image/png,image/jpg',
                        'required' => false
                    ]); ?>
                </div>
            </div>
            <?php if (!empty($branch->sign_1)) : ?>
                <div>
                    <a href="<?= $this->Url->build('/files/' . h($branch->sign_1)) ?>" target="_blank" class="btn btn-xs btn-info mt-1">Lihat</a>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <?= $this->Krs->btnSave(); ?>

</div>

<?= $this->Form->end(); ?>

<script>
$(document).ready(function () {

    var confirmTitle = "Apakah anda ingin menyimpan perubahan data tersebut ?";

    var formAction = "<?= $this->Url->build([
        'prefix' => 'Pengaturan',
        'controller' => 'Branches',
        'action' => 'edit',
        $branch->id
    ], ['fullBase' => true]); ?>";

    handleFormConfirmSubmitValid(
        'GroupAddForm',
        'btn-add',
        confirmTitle,
        formAction
    );

});
</script>