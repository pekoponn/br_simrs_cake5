<?php
/** @var \App\View\AppView $this */
/** @var \App\Model\Entity\MasterLaboratory $masterLaboratory */
?>
<?= $this->Krs->breadcrumb('Master Laboratories', 'Tambah Data') ?>
<div class="panel panel-inverse">
    <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-plus"></i> Tambah Master Laboratory</h4></div>
    <div class="panel-body">
        <?= $this->Form->create($masterLaboratory) ?>
        <div class="panel panel-default">
            <div class="panel-heading" style="background:#1e3a5f;color:#fff;"><strong><i class="fa fa-flask"></i> Form Pemeriksaan Laboratorium</strong></div>
            <div class="panel-body" style="background:#f8f9fa;">
                <div class="row">
                    <div class="col-md-3">
                        <label>Kode</label>
                        <?= $this->Form->control('code', [
                            'label' => false,
                            'class' => 'form-control input-sm',
                            'value' => 'AUTO',
                            'readonly' => true,
                            'style' => 'background:#eef1f5;font-weight:700;',
                        ]) ?>
                        <small style="color:#888;">Kode dibuat otomatis oleh sistem saat disimpan.</small>
                    </div>
                    <div class="col-md-5">
                        <label>Nama Pemeriksaan <span style="color:red;">*</span></label>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control input-sm', 'placeholder' => 'Contoh: Hemoglobin', 'required' => true]) ?>
                    </div>
                    <div class="col-md-4">
                        <label>Kategori</label>
                        <?= $this->Form->control('category', [
                            'label' => false,
                            'type' => 'select',
                            'options' => $this->Krs->laboratoryCategories(),
                            'empty' => '-- Pilih Kategori --',
                            'class' => 'form-control select2Form',
                            'id' => 'add-lab-category',
                        ]) ?>
                    </div>
                </div>

                <div class="row" style="margin-top:8px;">
                    <div class="col-md-3">
                        <label>Jasa RS <span style="color:red;">*</span></label>
                        <?= $this->Form->control('jasa_rs', [
                            'label' => false,
                            'type' => 'number',
                            'id' => 'input-jasa-rs',
                            'class' => 'form-control input-sm lab-jasa-input',
                            'placeholder' => '0',
                            'min' => 0,
                            'step' => 100,
                            'default' => 0,
                        ]) ?>
                    </div>
                    <div class="col-md-3">
                        <label>Jasa DR</label>
                        <?= $this->Form->control('jasa_dr', [
                            'label' => false,
                            'type' => 'number',
                            'id' => 'input-jasa-dr',
                            'class' => 'form-control input-sm lab-jasa-input',
                            'placeholder' => '0',
                            'min' => 0,
                            'step' => 100,
                            'default' => 0,
                        ]) ?>
                    </div>
                    <div class="col-md-3">
                        <label>Perawat</label>
                        <?= $this->Form->control('jasa_perawat', [
                            'label' => false,
                            'type' => 'number',
                            'id' => 'input-jasa-perawat',
                            'class' => 'form-control input-sm lab-jasa-input',
                            'placeholder' => '0',
                            'min' => 0,
                            'step' => 100,
                            'default' => 0,
                        ]) ?>
                    </div>
                    <div class="col-md-3">
                        <label>Tarif Rp (Total)</label>
                        <?= $this->Form->control('tariff', [
                            'label' => false,
                            'type' => 'number',
                            'id' => 'input-tariff-total',
                            'class' => 'form-control input-sm',
                            'placeholder' => '0',
                            'min' => 0,
                            'step' => 100,
                            'readonly' => true,
                            'style' => 'background:#eef1f5;font-weight:700;',
                        ]) ?>
                        <small style="color:#888;">Otomatis = Jasa RS + Jasa DR + Perawat.</small>
                    </div>
                </div>

                <div class="row" style="margin-top:8px;">
                    <div class="col-md-2">
                        <label>Status</label>
                        <?= $this->Form->control('is_active', [
                            'label' => false,
                            'type' => 'select',
                            'options' => [1 => 'Aktif', 0 => 'Tidak Aktif'],
                            'default' => 1,
                            'class' => 'form-control select2Form',
                            'id' => 'add-lab-is-active',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:6px;">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> Kembali', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-default btn-sm']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function recalcTariffTotal() {
        var jasaRs = parseFloat(document.getElementById('input-jasa-rs').value) || 0;
        var jasaDr = parseFloat(document.getElementById('input-jasa-dr').value) || 0;
        var jasaPerawat = parseFloat(document.getElementById('input-jasa-perawat').value) || 0;

        document.getElementById('input-tariff-total').value = jasaRs + jasaDr + jasaPerawat;
    }

    document.querySelectorAll('.lab-jasa-input').forEach(function (el) {
        el.addEventListener('input', recalcTariffTotal);
    });

    recalcTariffTotal();
});
</script>