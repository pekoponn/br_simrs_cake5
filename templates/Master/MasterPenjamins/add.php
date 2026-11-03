<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterPenjamin $masterPenjamin
 */

$typeOptions = [
    'BPJS' => 'BPJS',
    'Asuransi' => 'Asuransi',
    'Perusahaan' => 'Perusahaan',
    'Pribadi' => 'Pribadi',
    'Lainnya' => 'Lainnya',
];
?>

<?= $this->Krs->breadcrumb('Master', 'Penjamin', 'Buat') ?>

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

        <?= $this->Form->create($masterPenjamin, [
            'id' => 'form-add-penjamin'
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

                <label>Jenis Penjamin <span class="text-danger">*</span></label>

                <?= $this->Form->select(
                    'type',
                    $typeOptions,
                    [
                        'class' => 'form-control select2Form',
                        'empty' => 'Pilih Jenis',
                        'required' => true
                    ]
                ) ?>

            </div>

            <div class="col-md-4 form-group">

                <label>Status</label>

                <?= $this->Form->select(
                    'is_active',
                    [
                        1 => 'Aktif',
                        0 => 'Nonaktif'
                    ],
                    [
                        'class' => 'form-control select2Form',
                        'value' => 1
                    ]
                ) ?>

            </div>

            <div class="col-md-12 form-group">

                <label>Nama Penjamin <span class="text-danger">*</span></label>

                <?= $this->Form->text('name', [
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan nama penjamin',
                    'required' => true,
                    'maxlength' => 200
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


<script>
$(document).ready(function () {
    $('.select2Form').select2({
        width: '100%',
        minimumResultsForSearch: 0
    });
});
</script>