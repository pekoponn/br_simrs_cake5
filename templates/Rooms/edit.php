<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room $room
 */

$dataChild = $this->Html->link(
    'Rooms',
    ['action' => 'index'],
    ['full_base' => true]
);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Edit') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Edit Room</h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" 
               class="btn btn-xs btn-icon btn-circle btn-default" 
               data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <?= $this->Form->create($room, ['data-parsley-validate' => 'true']) ?>

    <div class="panel-body">

        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Nama Ruangan *</label>
            <div class="col-md-4">
                <?= $this->Form->control('room_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Ruangan..',
                    'required' => true
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">Kode Ruangan *</label>
            <div class="col-md-4">
                <?= $this->Form->control('room_code', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kode Ruangan..',
                    'required' => true
                ]) ?>
            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kelas</label>
            <div class="col-md-4">
                <?= $this->Form->control('room_class', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kelas Ruangan..'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">Kapasitas</label>
            <div class="col-md-4">
                <?= $this->Form->control('capacity', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kapasitas..'
                ]) ?>
            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Lantai</label>
            <div class="col-md-4">
                <?= $this->Form->control('floor', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Lantai..'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">Status Aktif</label>
            <div class="col-md-4">
                <?= $this->Form->control('is_active', [
                    'label' => false,
                    'type' => 'select',
                    'options' => [
                        'Y' => 'Aktif',
                        'N' => 'Tidak Aktif'
                    ],
                    'class' => 'form-control select2Form',
                ]) ?>
            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Keterangan</label>
            <div class="col-md-10">
                <?= $this->Form->control('description', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'rows' => 3,
                    'placeholder' => 'Keterangan..'
                ]) ?>
            </div>
        </div>

    </div>

    <div class="panel-footer text-right">
        <?= $this->Html->link(
            '<i class="fa fa-arrow-left"></i> Kembali',
            ['action' => 'index'],
            ['escape' => false, 'class' => 'btn btn-default']
        ) ?>

        <?= $this->Form->postLink(
            '<i class="fa fa-trash"></i> Hapus',
            ['action' => 'delete', $room->id],
            [
                'escape' => false,
                'confirm' => 'Yakin ingin menghapus data ini?',
                'class' => 'btn btn-danger'
            ]
        ) ?>

        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Update
        </button>
    </div>

    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
$(document).ready(function () {

    var confirmTitle = "Apakah anda ingin mengupdate data tersebut ?";

    var formAction = "<?=
        $this->Url->build(
            ['controller' => 'Rooms', 'action' => 'edit', $room->id],
            ['fullBase' => true]
        );
    ?>";

    handleFormConfirmSubmitValid(
        'RoomEditForm',
        'btn-add',
        confirmTitle,
        formAction
    );

});
</script>