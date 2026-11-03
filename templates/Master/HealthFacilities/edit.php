<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HealthFacility $healthFacility
 */

$dataChild = $this->Html->link(
    'Fasilitas Kesehatan',
    ['action' => 'index'],
    ['full_base' => true]
);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Edit') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">

        <h4 class="panel-title">
            Perincian
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>

    </div>

    <?= $this->Form->create($healthFacility, [
        'data-parsley-validate' => 'true'
    ]) ?>

    <div class="panel-body">

        <!-- ROW 1 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Kode*
            </label>

            <div class="col-md-2">

                <?=
                    $this->Form->control('code', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kode...',
                        'required' => true,
                        'value' => $healthFacility->code
                    ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Kode Int
            </label>

            <div class="col-md-2">

                <?=
                    $this->Form->control('code_int', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kode Internal...',
                        'value' => $healthFacility->code_int
                    ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Kode PPK
            </label>

            <div class="col-md-5">

                <?=
                    $this->Form->control('code_ppk', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kode PPK...',
                        'value' => $healthFacility->code_ppk
                    ]);
                ?>

            </div>

        </div>

        <!-- ROW 2 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Nama*
            </label>

            <div class="col-md-5">

                <?=
                    $this->Form->control('name', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nama Fasilitas...',
                        'required' => true,
                        'value' => $healthFacility->name
                    ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Tipe*
            </label>

            <div class="col-md-5">

                <?=
                    $this->Form->control('type', [
                        'label' => false,
                        'class' => 'form-control select2Form',
                        'options' => [
                            'Rumah Sakit' => 'Rumah Sakit',
                            'Klinik' => 'Klinik',
                            'Puskesmas' => 'Puskesmas',
                            'Laboratorium' => 'Laboratorium'
                        ],
                        'empty' => '-- Pilih Tipe --',
                        'default' => $healthFacility->type
                    ]);
                ?>

            </div>

        </div>

        <!-- ROW 3 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Alamat
            </label>

            <div class="col-md-11">

                <?=
                    $this->Form->control('address', [
                        'type' => 'textarea',
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Alamat...',
                        'rows' => 3,
                        'value' => $healthFacility->address
                    ]);
                ?>

            </div>

        </div>

        <!-- HIDDEN -->
        <?php

        echo $this->Form->hidden('is_create', [
            'value' => $healthFacility->is_create
        ]);

        echo $this->Form->hidden('is_update', [
            'value' => 1
        ]);

        echo $this->Form->hidden('is_delete', [
            'value' => $healthFacility->is_delete
        ]);

        echo $this->Form->hidden('is_active', [
            'value' => $healthFacility->is_active
        ]);

        ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        $(".select2Form").select2();

        var confirmTitle =
            "Apakah anda ingin menyimpan data tersebut ?";

        var formAction =
            "<?= $this->Url->build(
                ['prefix' => 'Master', 'controller' => 'HealthFacilities',
                    'action' => 'edit',
                    $healthFacility->id
                ],
                ['fullBase' => true]
            ); ?>";

        handleFormConfirmSubmitValid(
            'HealthFacilityEditForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });

</script>