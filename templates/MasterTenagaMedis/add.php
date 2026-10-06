<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTenagaMedi $masterTenagaMedi
 */
?>

<?= $this->Krs->breadcrumb('Master Data', 'Master Tenaga Medis', 'Tambah') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-user-plus"></i> Tambah Master Tenaga Medis
        </h4>
        <div class="panel-heading-btn">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </div>
    </div>

    <div class="panel-body">
        <?= $this->Form->create($masterTenagaMedi, ['class' => 'form-tenaga-medis']) ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Status / Kategori</label>
                    <?= $this->Form->select('status', $this->Krs->tenagaMedisKategori(), [
                        'id' => 'tm-status',
                        'class' => 'form-control select2Form',
                        'data-placeholder' => '-- Pilih Kategori --',
                        'empty' => '-- Pilih Kategori --',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Kode <span style="font-weight:400; color:#6c757d;">(otomatis)</span></label>
                    <?= $this->Form->control('kode', [
                        'label' => false,
                        'id' => 'tm-kode',
                        'class' => 'form-control',
                        'placeholder' => 'Pilih kategori terlebih dahulu...',
                        'readonly' => true,
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <?= $this->Form->control('nama', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan nama tenaga medis...',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Aktif</label>
                    <div style="padding-top:7px;">
                        <?= $this->Form->control('is_active', [
                            'label' => false,
                            'type' => 'checkbox',
                            'checked' => true,
                            'class' => 'form-checkbox-active',
                        ]) ?>
                        <span class="checkbox-hint">Centang jika tenaga medis ini aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?= $this->Form->button('Simpan', [
                'escape' => false,
                'class' => 'btn btn-inverse btn-sm',
            ]) ?>
            <?= $this->Html->link(
                '<i class="fa fa-times"></i> Batal',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<style>
.form-tenaga-medis .form-group {
    margin-bottom: 16px;
}

.form-tenaga-medis .form-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #555;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: .3px;
}

.form-tenaga-medis .form-control {
    height: 36px;
    font-size: 13px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 6px 10px;
}

.form-tenaga-medis .form-control:focus {
    border-color: #1e3a5f;
    box-shadow: 0 0 0 2px rgba(30,58,95,.15);
}

.form-checkbox-active {
    width: 18px;
    height: 18px;
    vertical-align: middle;
    margin-right: 6px;
}

.checkbox-hint {
    font-size: 11px;
    color: #6c757d;
    vertical-align: middle;
}

.form-actions {
    margin-top: 10px;
    padding-top: 14px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 8px;
}

.form-actions .btn {
    min-width: 90px;
}
</style>

<script>
$(function () {
    var NEXT_KODE_URL = <?= json_encode($this->Url->build(['controller' => 'MasterTenagaMedis', 'action' => 'nextKode'])) ?>;

    $('#tm-status').select2({
        width: '100%',
        placeholder: $('#tm-status').data('placeholder')
    });

    function fetchNextKode(kategori) {
        var $kode = $('#tm-kode');

        if (!kategori) {
            $kode.val('').prop('readonly', true).attr('placeholder', 'Pilih kategori terlebih dahulu...');
            return;
        }

        $kode.val('').prop('readonly', true).attr('placeholder', 'Memuat kode...');

        $.get(NEXT_KODE_URL, { kategori: kategori }, function (data) {
            if (data && data.kode) {
                $kode.val(data.kode).prop('readonly', true);
                return;
            }

            $kode.attr('placeholder', 'Gagal memuat kode, isi manual').prop('readonly', false);
        }, 'json').fail(function () {
            $kode.attr('placeholder', 'Gagal memuat kode, isi manual');
            $kode.prop('readonly', false);
        });
    }

    $('#tm-status').on('change', function () {
        var kategori = $(this).val();
        fetchNextKode(kategori);
    });

    if ($('#tm-status').val() && !$('#tm-kode').val()) {
        fetchNextKode($('#tm-status').val());
    }
});
</script>
