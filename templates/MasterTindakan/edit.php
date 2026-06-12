<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan $masterTindakan
 */

$kategoriOptions = [
    'Administrasi' => 'Administrasi',
    'Konsultasi' => 'Konsultasi',
    'Tindakan Medis' => 'Tindakan Medis',
    'Laboratorium' => 'Laboratorium',
    'Radiologi' => 'Radiologi',
    'Farmasi' => 'Farmasi',
    'Operasi' => 'Operasi',
    'Rawat Inap' => 'Rawat Inap',
    'Rawat Jalan' => 'Rawat Jalan',
    'IGD' => 'IGD',
    'Lainnya' => 'Lainnya',
];

$currentCategory = trim((string)($masterTindakan->kategori ?? ''));
if ($currentCategory !== '' && !isset($kategoriOptions[$currentCategory])) {
    $kategoriOptions = [$currentCategory => $currentCategory] + $kategoriOptions;
}

$satuanOptions = [
    'Kali' => 'Kali',
    'Paket' => 'Paket',
    'Hari' => 'Hari',
    'Item' => 'Item',
    'Unit' => 'Unit',
    'Jahitan' => 'Jahitan',
    'Lembar' => 'Lembar',
];

$currentUnit = trim((string)($masterTindakan->satuan ?? ''));
if ($currentUnit !== '' && !isset($satuanOptions[$currentUnit])) {
    $satuanOptions = [$currentUnit => $currentUnit] + $satuanOptions;
}
?>

<?= $this->Krs->breadcrumb('Master', 'Tindakan', 'Ubah') ?>

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
        <?= $this->Form->create($masterTindakan, ['id' => 'form-edit-tindakan']) ?>

        <div class="row">
            <div class="col-md-3 form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <?= $this->Form->text('kode', [
                    'id' => 'kode',
                    'class' => 'form-control',
                    'placeholder' => 'Contoh: TND001',
                    'required' => true,
                    'maxlength' => 20,
                    'style' => 'font-family:monospace;',
                ]) ?>
            </div>

            <div class="col-md-9 form-group">
                <label>Nama Tindakan <span class="text-danger">*</span></label>
                <?= $this->Form->text('nama', [
                    'class' => 'form-control',
                    'placeholder' => 'Nama tindakan...',
                    'required' => true,
                    'maxlength' => 200,
                ]) ?>
            </div>

            <div class="col-md-4 form-group">
                <label>Kategori <span class="text-danger">*</span></label>
                <?= $this->Form->select('kategori', $kategoriOptions, [
                    'class' => 'form-control',
                    'empty' => 'Pilih Kategori',
                    'required' => true,
                ]) ?>
            </div>

            <div class="col-md-4 form-group">
                <label>Tarif <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input
                        type="text"
                        id="harga-display"
                        class="form-control"
                        value="<?= number_format((float)($masterTindakan->harga ?? 0), 0, ',', '.') ?>"
                        placeholder="0"
                        inputmode="numeric"
                        required
                    >
                </div>
                <?= $this->Form->hidden('harga', [
                    'id' => 'harga',
                    'value' => (float)($masterTindakan->harga ?? 0),
                ]) ?>
            </div>

            <div class="col-md-2 form-group">
                <label>Satuan</label>
                <?= $this->Form->select('satuan', $satuanOptions, [
                    'class' => 'form-control',
                    'empty' => 'Pilih Satuan',
                ]) ?>
            </div>

            <div class="col-md-2 form-group">
                <label>Status</label>
                <?= $this->Form->select('is_active', [
                    1 => 'Aktif',
                    0 => 'Nonaktif',
                ], [
                    'class' => 'form-control',
                    'value' => (int)$masterTindakan->is_active,
                ]) ?>
            </div>

            <div class="col-md-12 form-group">
                <label>Keterangan</label>
                <?= $this->Form->textarea('keterangan', [
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Keterangan tambahan (opsional)...',
                ]) ?>
            </div>
        </div>

        <div class="alert alert-secondary m-b-15" style="font-size:11px;">
            <strong>Dibuat:</strong>
            <?= !empty($masterTindakan->created) ? h($masterTindakan->created->format('d-m-Y H:i')) : '-' ?>
            <span class="m-l-15">
                <strong>Terakhir diubah:</strong>
                <?= !empty($masterTindakan->modified) ? h($masterTindakan->modified->format('d-m-Y H:i')) : '-' ?>
            </span>
        </div>

        <div class="m-t-10">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan Perubahan
            </button>
            <?= $this->Html->link(
                '<i class="fa fa-eye"></i> Lihat',
                ['action' => 'view', $masterTindakan->id],
                ['class' => 'btn btn-info', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default', 'escape' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<script>
(function () {
    var priceDisplay = document.getElementById('harga-display');
    var priceValue = document.getElementById('harga');

    function syncPrice() {
        var raw = priceDisplay.value.replace(/\D/g, '');
        priceDisplay.value = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
        priceValue.value = raw || '0';
    }

    priceDisplay.addEventListener('input', syncPrice);
    document.getElementById('form-edit-tindakan').addEventListener('submit', syncPrice);
})();
</script>
