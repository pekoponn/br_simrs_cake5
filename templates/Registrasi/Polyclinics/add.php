<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Polyclinic $polyclinic
 */

$dataChild = $this->Html->link(
    'Polyclinic',
    ['action' => 'index'],
    ['full_base' => true]
);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Buat') ?>

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

    <?= $this->Form->create($polyclinic, ['data-parsley-validate' => 'true']) ?>

    <div class="panel-body">

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Kode*
            </label>

            <div class="col-md-4">

                <?= $this->Form->control(
                    'code',
                    [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kode Poliklinik...',
                        'required' => true,
                        'data-parsley-required-message' => 'Kode tidak boleh kosong!'
                    ]
                ) ?>

            </div>

            <label class="col-form-label col-md-2">
                Nama Poliklinik*
            </label>

            <div class="col-md-4">

                <?= $this->Form->control(
                    'name',
                    [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nama Poliklinik...',
                        'required' => true,
                        'data-parsley-required-message' => 'Nama Poliklinik tidak boleh kosong!'
                    ]
                ) ?>

            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Keterangan
            </label>

            <div class="col-md-10">

                <?= $this->Form->control(
                    'description',
                    [
                        'type' => 'textarea',
                        'label' => false,
                        'class' => 'form-control',
                        'rows' => 4,
                        'placeholder' => 'Keterangan...'
                    ]
                ) ?>

            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Status Active
            </label>

            <div class="col-md-3">

                <?= $this->Form->control(
                    'is_active',
                    [
                        'label' => false,
                        'class' => 'form-control select2Form',
                        'options' => [
                            'Y' => 'Active',
                            'N' => 'Inactive'
                        ],
                        'default' => 'Y'
                    ]
                ) ?>

            </div>

        </div>

        <?=
            $this->Form->hidden(
                'is_create',
                [
                    'value' => 1
                ]
            )
            ?>

        <?=
            $this->Form->hidden(
                'is_update',
                [
                    'value' => 0
                ]
            )
            ?>

        <?=
            $this->Form->hidden(
                'is_delete',
                [
                    'value' => 0
                ]
            )
            ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?=
            $this->Url->build(
                [
                    'controller' => 'Polyclinics',
                    'action' => 'add'
                ],
                ['fullBase' => true]
            );
        ?>";

    handleFormConfirmSubmitValid(
        'PlacementAddForm',
        'btn-add',
        confirmTitle,
        formAction
    );

    $(".select2Form").select2();

});

</script>