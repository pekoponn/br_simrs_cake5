<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NutritionMenu $nutritionMenu
 */

$dataChild = $this->Html->link(
    'NutritionMenu',
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

    <?= $this->Form->create($nutritionMenu, ['data-parsley-validate' => 'true']) ?>

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
                        'placeholder' => 'Kode Menu...',
                        'required' => true,
                        'data-parsley-required-message' => 'Kode tidak boleh kosong!'
                    ]
                ) ?>

            </div>

            <label class="col-form-label col-md-2">
                Nama Menu*
            </label>

            <div class="col-md-4">

                <?= $this->Form->control(
                    'name',
                    [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nama Menu...',
                        'required' => true,
                        'data-parsley-required-message' => 'Nama Menu tidak boleh kosong!'
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
                ['prefix' => 'Master', 'controller' => 'NutritionMenus',
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