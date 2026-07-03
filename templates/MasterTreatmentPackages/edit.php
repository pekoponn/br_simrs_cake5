<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTreatmentPackage $masterTreatmentPackage
 */
?>

<?= $this->Krs->breadcrumb('Master', 'Paket Treatment', 'Ubah') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">Perincian</h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($masterTreatmentPackage, [
            'id' => 'form-edit-treatment-package'
        ]) ?>

        <div class="row">

            <div class="col-md-4 form-group">

                <label>Kode <span class="text-danger">*</span></label>

                <?= $this->Form->text('code', [
                    'class' => 'form-control',
                    'readonly' => true,
                    'required' => true,
                    'style' => 'font-family:monospace;',
                ]) ?>

            </div>

            <div class="col-md-4 form-group">

                <label>Harga</label>

                <?= $this->Form->number('price', [
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan harga paket',
                    'min' => 0,
                    'step' => '0.01'
                ]) ?>

            </div>

            <div class="col-md-4 form-group">

                <label>Status</label>

                <?= $this->Form->select(
                    'is_active',
                    [
                        'Y' => 'Aktif',
                        'N' => 'Nonaktif'
                    ],
                    [
                        'class' => 'form-control',
                        'value' => $masterTreatmentPackage->is_active
                    ]
                ) ?>

            </div>

            <div class="col-md-12 form-group">

                <label>Nama Paket <span class="text-danger">*</span></label>

                <?= $this->Form->text('name', [
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan nama paket treatment',
                    'required' => true,
                    'maxlength' => 255
                ]) ?>

            </div>

        </div>

        <div class="alert alert-secondary m-b-15" style="font-size:11px;">

            <strong>Dibuat :</strong>

            <?= !empty($masterTreatmentPackage->created)
                ? h($masterTreatmentPackage->created->format('d-m-Y H:i'))
                : '-' ?>

            <span class="m-l-15">

                <strong>Terakhir diubah :</strong>

                <?= !empty($masterTreatmentPackage->modified)
                    ? h($masterTreatmentPackage->modified->format('d-m-Y H:i'))
                    : '-' ?>

            </span>

        </div>

        <div class="m-t-10 text-right">

            <button
                type="submit"
                class="btn btn-primary">

                <i class="fa fa-save"></i>
                Simpan Perubahan

            </button>

            <?= $this->Html->link(
                '<i class="fa fa-eye"></i> Lihat',
                ['action' => 'view', $masterTreatmentPackage->id],
                [
                    'class' => 'btn btn-info',
                    'escape' => false
                ]
            ) ?>

            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                [
                    'class' => 'btn btn-default',
                    'escape' => false
                ]
            ) ?>

        </div>

        <?= $this->Form->end() ?>

    </div>

</div>
