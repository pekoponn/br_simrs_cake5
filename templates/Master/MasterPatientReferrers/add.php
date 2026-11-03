<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterPatientReferrer $masterPatientReferrer
 */
?>

<?= $this->Krs->breadcrumb('Master', 'Perujuk Pasien', 'Buat') ?>

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

        <?= $this->Form->create($masterPatientReferrer, [
            'id' => 'form-add-patient-referrer'
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

                <label>Asal Rujuk</label>

                <?= $this->Form->text('referral_origin', [
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan asal rujuk',
                    'maxlength' => 255
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
                        'class' => 'form-control select2Form',
                        'value' => 'Y'
                    ]
                ) ?>

            </div>

            <div class="col-md-6 form-group">

                <label>Nama Perujuk <span class="text-danger">*</span></label>

                <?= $this->Form->text('name', [
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan nama perujuk',
                    'required' => true,
                    'maxlength' => 255
                ]) ?>

            </div>

            <div class="col-md-6 form-group">

                <label>Dokter Pengirim</label>

                <?= $this->Form->text('doctor_sender', [
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan dokter pengirim',
                    'maxlength' => 255
                ]) ?>

            </div>

        </div>

        <div class="m-t-10 text-right">

            <button
                type="submit"
                class="btn btn-primary">

                <i class="fa fa-save"></i>
                Simpan

            </button>

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
