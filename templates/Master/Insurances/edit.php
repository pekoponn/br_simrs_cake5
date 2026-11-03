<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Insurance $insurance
 */

$dataChild = $this->Html->link('Insurance', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Edit') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">Perincian</h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <?= $this->Form->create($insurance, ['data-parsley-validate' => 'true']) ?>

    <div class="panel-body">

        <!-- ROW 1 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">Kode*</label>

            <div class="col-md-2">
                <?php
                echo $this->Form->control('code', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kode...',
                    'required' => true,
                    'data-parsley-required-message' => 'Kode tidak boleh kosong!',
                    'value' => $insurance->code
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">Region</label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('region', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Region...',
                    'value' => $insurance->region
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">Tipe</label>

            <div class="col-md-4">
                <?php
                echo $this->Form->control('type', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Tipe Insurance...',
                    'value' => $insurance->type
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 2 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">Nama*</label>

            <div class="col-md-11">
                <?php
                echo $this->Form->control('name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Insurance...',
                    'required' => true,
                    'data-parsley-required-message' => 'Nama insurance tidak boleh kosong!',
                    'value' => $insurance->name
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 3 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">Bank</label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('bank_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Bank...',
                    'value' => $insurance->bank_name
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-2">No Rekening</label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('bank_account_number', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nomor Rekening...',
                    'value' => $insurance->bank_account_number
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">Atas Nama</label>

            <div class="col-md-2">
                <?php
                echo $this->Form->control('bank_account_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Atas Nama...',
                    'value' => $insurance->bank_account_name
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 4 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">Phone RS</label>

            <div class="col-md-5">
                <?php
                echo $this->Form->control('phone_number_rs', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Phone Number RS...',
                    'value' => $insurance->phone_number_rs
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">Email RS</label>

            <div class="col-md-5">
                <?php
                echo $this->Form->control('email_rs', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Email RS...',
                    'value' => $insurance->email_rs
                ]);
                ?>
            </div>

        </div>

        <!-- HIDDEN -->
        <?php
        echo $this->Form->hidden('is_create', ['value' => $insurance->is_create]);
        echo $this->Form->hidden('is_update', ['value' => 1]);
        echo $this->Form->hidden('is_delete', ['value' => $insurance->is_delete]);
        echo $this->Form->hidden('is_active', ['value' => $insurance->is_active]);
        ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        var confirmTitle = "Apakah anda ingin menyimpan perubahan data tersebut ?";

        var formAction = "<?= $this->Url->build(
            ['prefix' => 'Master', 'controller' => 'Insurances', 'action' => 'edit', $insurance->id],
            ['fullBase' => true]
        ); ?>";

        handleFormConfirmSubmitValid(
            'InsuranceEditForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });

</script>