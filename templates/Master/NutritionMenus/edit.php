<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NutritionMenu $nutritionMenu 
 */

$dataChild = $this->Html->link(
    'Nutrition Menu',
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

    <?= $this->Form->create($nutritionMenu, [
        'id' => 'PlacementAddForm',
        'data-parsley-validate' => 'true'
    ]) ?>

    <div class="panel-body">

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Kode
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('code', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kode...',
                    'required' => true
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Nama
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama...'
                ]) ?>
            </div>

        </div>

        <?= $this->Form->control('is_active', [
            'type' => 'hidden'
        ]) ?>

        <?= $this->Form->control('is_create', [
            'type' => 'hidden'
        ]) ?>

        <?= $this->Form->control('is_update', [
            'type' => 'hidden'
        ]) ?>

        <?= $this->Form->control('is_delete', [
            'type' => 'hidden'
        ]) ?>

        <?= $this->Form->control('delete_log', [
            'type' => 'hidden'
        ]) ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">
    $(document).ready(function () {

        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?= $this->Url->build(
            ['prefix' => 'Master', 'controller' => 'NutritionMenus', 'action' => 'edit', $nutritionMenu->id],
            ['fullBase' => true]
        ); ?>";

        handleFormConfirmSubmitValid(
            'PlacementAddForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });
</script>