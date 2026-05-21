<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 * @var array $rooms
 * @var array $classList
 * @var array $statusList
 * @var array $activeList
 */
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Tambah') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-bed"></i> Tambah Bed
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($bed) ?>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('code', [
                        'label' => 'Code Bed',
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan code bed',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('room_id', [
                        'label' => 'Room',
                        'options' => $rooms,
                        'empty' => '-- Pilih Room --',
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('bed_no', [
                        'label' => 'Nomor TT',
                        'class' => 'form-control',
                        'placeholder' => 'Contoh: TT01',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('name', [
                        'label' => 'Nama Bed',
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan nama bed',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('class_name', [
                        'type' => 'select',
                        'label' => 'Class',
                        'options' => $classList,
                        'empty' => '-- Pilih Class --',
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('status', [
                        'type' => 'select',
                        'label' => 'Status Bed',
                        'options' => $statusList,
                        'empty' => '-- Pilih Status --',
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('is_active', [
                        'type' => 'select',
                        'label' => 'Status Active',
                        'options' => $activeList,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

        </div>

        <hr>

        <div class="text-end">

            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                [
                    'class' => 'btn btn-default',
                    'escape' => false
                ]
            ) ?>

            <?= $this->Form->button(
                '<i class="fa fa-save"></i> Simpan',
                [
                    'class' => 'btn btn-success',
                    'escapeTitle' => false
                ]
            ) ?>

        </div>

        <?= $this->Form->end() ?>

    </div>

</div>