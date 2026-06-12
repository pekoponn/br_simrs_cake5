<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterIcd9 $masterIcd9
 */
?>

<?= $this->Krs->breadcrumb('Master', 'ICD-9 CM', 'Buat') ?>

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
        <?= $this->Form->create($masterIcd9) ?>

        <div class="row">
            <div class="col-md-3 form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <?= $this->Form->text('kode', [
                    'class' => 'form-control',
                    'placeholder' => 'Contoh: 99.04',
                    'required' => true,
                    'style' => 'font-family: monospace;',
                ]) ?>
            </div>
            <div class="col-md-9 form-group">
                <label>Nama ICD-9 CM <span class="text-danger">*</span></label>
                <?= $this->Form->text('nama', [
                    'class' => 'form-control',
                    'placeholder' => 'Nama tindakan/prosedur...',
                    'required' => true,
                ]) ?>
            </div>
            <div class="col-md-3 form-group">
                <label>Status</label>
                <?= $this->Form->select('is_active', [
                    1 => 'Aktif',
                    0 => 'Nonaktif',
                ], [
                    'class' => 'form-control',
                    'value' => $masterIcd9->is_active ?? 1,
                ]) ?>
            </div>
        </div>

        <div class="m-t-10">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan
            </button>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default', 'escape' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
