<?php
$dataChild = $this->Html->link('Cabang', ['action' => 'index'], ['full_base' => true]);?>
<?= $this->Krs->breadcrumb('Master', $dataChild, 'Buat') ?>
<?= $this->Form->create($branch, ['id' => 'GroupAddForm', 'data-parsley-validate' => 'true']) ?>

<div class="panel panel-inverse">
    <div class="panel-body">
        <?= $this->Form->control('is_create', [
            'type' => 'hidden',
            'value' => $getUser->id
        ]); ?>
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
    </div>
    <?= $this->Krs->btnSave(); ?>
</div>
<?= $this->Form->end(); ?>

<script>
$(document).ready(function () {

    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

    var formAction = "<?= $this->Url->build([
        'prefix' => 'Master',
        'controller' => 'Branches',
        'action' => 'add'
    ], ['fullBase' => true]); ?>";

    handleFormConfirmSubmitValid(
        'GroupAddForm',
        'btn-add',
        confirmTitle,
        formAction
    );

});
</script>