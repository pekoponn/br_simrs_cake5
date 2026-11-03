<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PharmacyItem $pharmacyItem
 */

$dataChild = $this->Html->link(
    'Pharmacy Item',
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

    <?= $this->Form->create($pharmacyItem, [
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
                Region
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('region', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Region...'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Type
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('type', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Type...'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Nama Obat
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama obat...',
                    'required' => true
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Purchase Unit
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('purchase_unit', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Purchase unit...'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Sale Unit
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('sale_unit', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Sale unit...'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                QJB
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('qjb', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'QJB...'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Therapy Class
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('therapy_class', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Therapy class...'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Group Name
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('group_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Group name...'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Producer
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('producer', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Producer...'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Medicine Type
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('medicine_type', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Medicine type...'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                CBG Rate
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('cbg_rate', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'CBG rate...'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Formula Name
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('formula_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Formula name...'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Formula Percentage
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('formula_percentage', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Formula percentage...'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                HPP
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('hpp', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'HPP...'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Sale Price
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('sale_price', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Sale price...'
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
            ['prefix' => 'Master', 'controller' => 'PharmacyItems', 'action' => 'edit', $pharmacyItem->id],
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