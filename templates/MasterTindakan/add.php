<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTindakan $masterTindakan
 */

$kategoriPrefix = [
    'Administrasi' => 'ADM',
    'Konsultasi' => 'KON',
    'Tindakan Medis' => 'TND',
    'Laboratorium' => 'LAB',
    'Radiologi' => 'RAD',
    'Farmasi' => 'FAR',
    'Operasi' => 'OPR',
    'Rawat Inap' => 'RIN',
    'Rawat Jalan' => 'RJL',
    'IGD' => 'IGD',
    'Lainnya' => 'LAN',
];

$kategoriOptions = [];
foreach (array_keys($kategoriPrefix) as $kategoriName) {
    $kategoriOptions[$kategoriName] = $kategoriName;
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
?>

<?= $this->Krs->breadcrumb('Master', 'Tindakan', 'Buat') ?>

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
        <?= $this->Form->create($masterTindakan, ['id' => 'form-add-tindakan']) ?>

        <div class="row">
            <div class="col-md-4 form-group">
                <label>Kategori <span class="text-danger">*</span></label>
                <?= $this->Form->select('kategori', $kategoriOptions, [
                    'id' => 'kategori',
                    'class' => 'form-control',
                    'empty' => 'Pilih Kategori',
                    'required' => true,
                ]) ?>
            </div>

            <div class="col-md-4 form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <div class="input-group">
                    <?= $this->Form->text('kode', [
                        'id' => 'kode',
                        'class' => 'form-control',
                        'placeholder' => 'Pilih kategori dahulu',
                        'required' => true,
                        'maxlength' => 20,
                        'readonly' => true,
                        'style' => 'font-family:monospace;',
                    ]) ?>
                    <span class="input-group-btn">
                        <button type="button" id="btn-generate-kode" class="btn btn-info" title="Generate kode">
                            <i class="fa fa-sync-alt"></i>
                        </button>
                        <button type="button" id="btn-edit-kode" class="btn btn-default" title="Edit kode manual">
                            <i class="fa fa-edit"></i>
                        </button>
                    </span>
                </div>
            </div>

            <div class="col-md-4 form-group">
                <label>Status</label>
                <?= $this->Form->select('is_active', [
                    1 => 'Aktif',
                    0 => 'Nonaktif',
                ], [
                    'class' => 'form-control',
                    'value' => $masterTindakan->is_active ?? 1,
                ]) ?>
            </div>

            <div class="col-md-8 form-group">
                <label>Nama Tindakan <span class="text-danger">*</span></label>
                <?= $this->Form->text('nama', [
                    'class' => 'form-control',
                    'placeholder' => 'Contoh: Konsultasi Dokter Spesialis',
                    'required' => true,
                    'maxlength' => 200,
                ]) ?>
            </div>

            <div class="col-md-2 form-group">
                <label>Tarif <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input
                        type="text"
                        id="harga-display"
                        class="form-control"
                        value="<?= !empty($masterTindakan->harga)
                            ? number_format((float)$masterTindakan->harga, 0, ',', '.')
                            : '' ?>"
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
                    'value' => $masterTindakan->satuan ?? 'Kali',
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

<script>
(function () {
    var prefixMap = <?= json_encode($kategoriPrefix, JSON_UNESCAPED_UNICODE) ?>;
    var categoryInput = document.getElementById('kategori');
    var codeInput = document.getElementById('kode');
    var generateButton = document.getElementById('btn-generate-kode');
    var editButton = document.getElementById('btn-edit-kode');
    var priceDisplay = document.getElementById('harga-display');
    var priceValue = document.getElementById('harga');
    var form = document.getElementById('form-add-tindakan');

    function pad(value) {
        return value < 10 ? '0' + value : String(value);
    }

    function generateCode() {
        var category = categoryInput.value;
        var prefix = prefixMap[category] || '';

        if (!prefix) {
            codeInput.value = '';
            codeInput.placeholder = 'Pilih kategori dahulu';
            return;
        }

        var now = new Date();
        var suffix = String(now.getFullYear()).slice(-2)
            + pad(now.getMonth() + 1)
            + pad(now.getDate())
            + pad(now.getHours())
            + pad(now.getMinutes())
            + pad(now.getSeconds());

        codeInput.value = prefix + '-' + suffix;
        codeInput.readOnly = true;
    }

    function syncPrice() {
        var raw = priceDisplay.value.replace(/\D/g, '');
        priceDisplay.value = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
        priceValue.value = raw || '0';
    }

    categoryInput.addEventListener('change', generateCode);
    generateButton.addEventListener('click', generateCode);
    editButton.addEventListener('click', function () {
        codeInput.readOnly = false;
        codeInput.focus();
    });
    priceDisplay.addEventListener('input', syncPrice);
    form.addEventListener('submit', function () {
        syncPrice();
        codeInput.readOnly = false;
    });

    if (categoryInput.value && !codeInput.value) {
        generateCode();
    }
})();
</script>
