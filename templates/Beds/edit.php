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

<?= $this->Krs->breadcrumb('Bed Management', 'Edit') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            Edit Bed - <?= h($bed->name) ?>
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($bed) ?>

        <div class="row">

            <!-- CODE -->
            <div class="col-md-6">

                <?= $this->Form->control('code', [
                    'label' => 'Code Bed',
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan code bed'
                ]) ?>

            </div>

            <!-- ROOM -->
            <div class="col-md-6">

                <?= $this->Form->control('room_id', [
                    'label' => 'Room',
                    'options' => $rooms,
                    'empty' => '-- Pilih Room --',
                    'class' => 'form-control'
                ]) ?>

            </div>

            <!-- BED NO -->
            <div class="col-md-6">

                <?= $this->Form->control('bed_no', [
                    'label' => 'Nomor Bed',
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan nomor bed'
                ]) ?>

            </div>

            <!-- NAMA BED -->
            <div class="col-md-6">

                <?= $this->Form->control('name', [
                    'label' => 'Nama Bed',
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan nama bed'
                ]) ?>

            </div>

            <!-- CLASS -->
            <div class="col-md-6">

                <?= $this->Form->control('class_name', [
                    'label' => 'Class',
                    'options' => $classList,
                    'empty' => '-- Pilih Class --',
                    'class' => 'form-control'
                ]) ?>

            </div>

            <!-- STATUS -->
            <div class="col-md-6">

                <?= $this->Form->control('status', [
                    'label' => 'Status Bed',
                    'options' => $statusList,
                    'class' => 'form-control'
                ]) ?>

            </div>

            <!-- ACTIVE -->
            <div class="col-md-6">

                <?= $this->Form->control('is_active', [
                    'label' => 'Status Active',
                    'options' => $activeList,
                    'class' => 'form-control'
                ]) ?>

            </div>

        </div>

        <br>

        <div class="text-end">

            <!-- BACK -->
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                [
                    'class' => 'btn btn-default',
                    'escape' => false
                ]
            ) ?>

            <!-- DELETE -->
            <?= $this->Form->postLink(
                '<i class="fa fa-trash"></i> Delete',
                ['action' => 'delete', $bed->id],
                [
                    'confirm' => __('Yakin ingin menghapus bed {0}?', $bed->name),
                    'class' => 'btn btn-danger',
                    'escape' => false
                ]
            ) ?>

            <!-- SAVE -->
            <?= $this->Form->button(
                '<i class="fa fa-save"></i> Update',
                [
                    'class' => 'btn btn-success',
                    'escapeTitle' => false
                ]
            ) ?>

        </div>

        <?= $this->Form->end() ?>

    </div>

</div>