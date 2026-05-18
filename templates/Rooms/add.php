<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room $room
 */

$dataChild = $this->Html->link(
    'Ruangan',
    ['action' => 'index'],
    ['full_base' => true]
);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">Tambah Ruangan</h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <?= $this->Form->create($room, [
        'data-parsley-validate' => 'true'
    ]) ?>

    <div class="panel-body">

        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">
                Nama Ruangan *
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('room_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Ruangan..',
                    'required' => true
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Kode Ruangan *
            </label>

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

            <label class="col-form-label col-md-2">
                Kelas Ruangan
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('room_class', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Contoh: VIP / Kelas 1'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Kapasitas
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('capacity', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kapasitas..'
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Lantai
            </label>

            <div class="col-md-4">
                <?= $this->Form->control('floor', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Lantai..'
                ]) ?>
            </div>

            <label class="col-form-label col-md-2">
                Status Aktif
            </label>

            <div class="col-md-4 pt-2">
                <?= $this->Form->control('is_active', [
                    'type' => 'checkbox',
                    'label' => 'Aktif',
                    'hiddenField' => 0
                ]) ?>
            </div>

        </div>

        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-2">
                Deskripsi
            </label>

            <div class="col-md-10">
                <?= $this->Form->control('description', [
                    'type' => 'textarea',
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Deskripsi ruangan..',
                    'rows' => 4
                ]) ?>
            </div>

        </div>

        <?= $this->Form->hidden('is_create', [
            'value' => 1
        ]) ?>

    </div>

    <div class="panel-footer text-right">
        <?= $this->Form->button(__('Simpan'), [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>

    <?= $this->Form->end() ?>

</div>