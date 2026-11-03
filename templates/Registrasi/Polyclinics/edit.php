<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Polyclinic $polyclinic
 */

$dataChild = $this->Html->link('Polyclinic', ['action' => 'index'], ['full_base' => true]);
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

    <?= $this->Form->create($polyclinic, ['data-parsley-validate' => 'true']) ?>

    <div class="panel-body">

        <!-- ROW 1 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Nama Polyclinic
            </label>

            <div class="col-md-4">

                <?= $this->Form->control('name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Polyclinic...',
                    'required' => true,
                    'value' => $polyclinic->name
                ]) ?>

            </div>

            <label class="col-form-label col-md-2">
                Kode
            </label>

            <div class="col-md-4">

                <?= $this->Form->control('code', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kode...',
                    'required' => true,
                    'value' => $polyclinic->code
                ]) ?>

            </div>

        </div>

        <!-- ROW 2 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Deskripsi
            </label>

            <div class="col-md-10">

                <?= $this->Form->control('description', [
                    'type' => 'textarea',
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Deskripsi...',
                    'rows' => 4,
                    'value' => $polyclinic->description
                ]) ?>

            </div>

        </div>

        <!-- ROW 3 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Status Active
            </label>

            <div class="col-md-3">

                <?= $this->Form->control('is_active', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'Y' => 'Active',
                        'N' => 'Inactive'
                    ],
                    'default' => $polyclinic->is_active
                ]) ?>

            </div>

        </div>

        <!-- HIDDEN -->
        <?php
        echo $this->Form->hidden('is_create', ['value' => $polyclinic->is_create]);
        echo $this->Form->hidden('is_update', ['value' => 1]);
        echo $this->Form->hidden('is_delete', ['value' => $polyclinic->is_delete]);
        ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        $(".select2Form").select2();

        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?=
            $this->Url->build(
                ['controller' => 'Polyclinics', 'action' => 'edit', $polyclinic->id],
                ['fullBase' => true]
            );
        ?>";

        handleFormConfirmSubmitValid(
            'PolyclinicEditForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });

</script>