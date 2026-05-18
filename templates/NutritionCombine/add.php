<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NutritionCombine $nutritionCombine
 */

$dataChild = $this->Html->link(
    'Nutrition Combine',
    ['action' => 'index'],
    ['full_base' => true]
);

$nutritionUnits = json_encode($this->Krs->nutritionContentUnit());
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">Perincian</h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <?= $this->Form->create($nutritionCombine, [
        'id' => 'NutritionCombineAddForm',
        'data-parsley-validate' => 'true'
    ]) ?>

    <div class="panel-body">

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">Kode</label>

            <div class="col-md-2">
                <?= $this->Form->control('code', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kode...',
                    'required' => true,
                    'data-parsley-required-message' => 'Kode tidak boleh kosong!'
                ]) ?>
            </div>

            <label class="col-form-label col-md-1">Nama</label>

            <div class="col-md-8">
                <?= $this->Form->control('name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama...',
                    'required' => true,
                    'data-parsley-required-message' => 'Nama tidak boleh kosong!'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">Kandungan</label>

            <div class="col-md-4">
                <?= $this->Form->control('nutrition_content_name', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $this->Krs->nutritionContent(),
                    'empty' => '-- Pilih Kandungan --',
                    'id' => 'nutrition-content',
                    'required' => true
                ]) ?>
            </div>

            <label class="col-form-label col-md-1">Nilai</label>

            <div class="col-md-2">
                <?= $this->Form->control('nutritional_value', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => '0.00',
                    'required' => true
                ]) ?>
            </div>

            <label class="col-form-label col-md-1">Satuan</label>

            <div class="col-md-3">
                <?= $this->Form->control('content_unit', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Satuan...',
                    'readonly' => true,
                    'id' => 'content-unit'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">Keterangan</label>

            <div class="col-md-11">
                <?= $this->Form->control('description', [
                    'type' => 'textarea',
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Keterangan...',
                    'rows' => 3
                ]) ?>
            </div>

        </div>

        <?= $this->Form->hidden('is_create', ['value' => 1]) ?>
        <?= $this->Form->hidden('is_update', ['value' => 0]) ?>
        <?= $this->Form->hidden('is_print', ['value' => 0]) ?>
        <?= $this->Form->hidden('is_active', ['value' => 'Y']) ?>
        <?= $this->Form->hidden('is_log', ['value' => 0]) ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        $(".select2Form").select2();

        var nutritionUnits = <?= $nutritionUnits ?>;

        $('#nutrition-content').change(function () {

            var selected = $(this).val();

            if (selected && nutritionUnits[selected]) {
                $('#content-unit').val(nutritionUnits[selected]);
            } else {
                $('#content-unit').val('');
            }

        });

        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?= $this->Url->build(
            ['controller' => 'NutritionCombine', 'action' => 'add'],
            ['fullBase' => true]
        ); ?>";

        handleFormConfirmSubmitValid(
            'NutritionCombineAddForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });

</script>