<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterRadiology $masterRadiology
 */

$kategoriOptions = [
    'X-Ray' => 'X-Ray',
    'CT Scan' => 'CT Scan',
    'MRI' => 'MRI',
    'USG' => 'USG',
    'Mammografi' => 'Mammografi',
    'Fluoroscopy' => 'Fluoroscopy',
    'Lainnya' => 'Lainnya',
];

$currentCategory = trim((string)($masterRadiology->category ?? ''));

if ($currentCategory !== '' && !isset($kategoriOptions[$currentCategory])) {
    $kategoriOptions = [$currentCategory => $currentCategory] + $kategoriOptions;
}
?>

<?= $this->Krs->breadcrumb('Master', 'Radiologi', 'Ubah') ?>

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

        <?= $this->Form->create($masterRadiology, [
            'id' => 'form-edit-radiology'
        ]) ?>

        <div class="row">

            <div class="col-md-3 form-group">

                <label>Kode <span class="text-danger">*</span></label>

                <?= $this->Form->text('code',[
                    'class'=>'form-control',
                    'required'=>true,
                    'maxlength'=>20,
                    'style'=>'font-family:monospace;'
                ]) ?>

            </div>

            <div class="col-md-9 form-group">

                <label>Nama Radiologi <span class="text-danger">*</span></label>

                <?= $this->Form->text('name',[
                    'class'=>'form-control',
                    'required'=>true,
                    'maxlength'=>200,
                    'placeholder'=>'Nama tindakan radiologi'
                ]) ?>

            </div>

            <div class="col-md-4 form-group">

                <label>Kategori <span class="text-danger">*</span></label>

                <?= $this->Form->select(
                    'category',
                    $kategoriOptions,
                    [
                        'class'=>'form-control',
                        'empty'=>'Pilih Kategori',
                        'required'=>true
                    ]
                ) ?>

            </div>

            <div class="col-md-4 form-group">

                <label>Tarif <span class="text-danger">*</span></label>

                <div class="input-group">

                    <span class="input-group-addon">Rp</span>

                    <input
                        type="text"
                        id="tariff-display"
                        class="form-control"
                        value="<?= number_format((float)($masterRadiology->tariff ?? 0),0,',','.') ?>"
                        placeholder="0"
                        inputmode="numeric"
                        required>

                </div>

                <?= $this->Form->hidden('tariff',[
                    'id'=>'tariff',
                    'value'=>(float)($masterRadiology->tariff ?? 0)
                ]) ?>

            </div>

            <div class="col-md-4 form-group">

                <label>Status</label>

                <?= $this->Form->select(
                    'is_active',
                    [
                        1=>'Aktif',
                        0=>'Nonaktif'
                    ],
                    [
                        'class'=>'form-control',
                        'value'=>(int)$masterRadiology->is_active
                    ]
                ) ?>

            </div>

        </div>

        <div class="alert alert-secondary m-b-15" style="font-size:11px;">

            <strong>Dibuat :</strong>

            <?= !empty($masterRadiology->created)
                ? h($masterRadiology->created->format('d-m-Y H:i'))
                : '-' ?>

            <span class="m-l-15">

                <strong>Terakhir diubah :</strong>

                <?= !empty($masterRadiology->modified)
                    ? h($masterRadiology->modified->format('d-m-Y H:i'))
                    : '-' ?>

            </span>

        </div>

        <div class="m-t-10">

            <?= $this->Html->link(
                '<i class="fa fa-arrow-left "></i> Kembali',
                ['action'=>'index'],
                [
                    'class'=>'btn btn-default',
                    'escape'=>false
                ]
            ) ?>

            <button
                type="submit"
                class="btn btn-primary pull-right m-l-5">

                <i class="fa fa-save"></i>
                Simpan Perubahan

            </button>

            <!-- <?= $this->Html->link(
                '<i class="fa fa-eye"></i> Lihat',
                ['action'=>'view',$masterRadiology->id],
                [
                    'class'=>'btn btn-info',
                    'escape'=>false
                ]
            ) ?> -->

            

        </div>

        <?= $this->Form->end() ?>

    </div>

</div>

<script>

(function(){

var tariffDisplay = document.getElementById('tariff-display');
var tariff = document.getElementById('tariff');

function syncTariff(){

    var raw = tariffDisplay.value.replace(/\D/g,'');

    tariffDisplay.value = raw
        ? parseInt(raw,10).toLocaleString('id-ID')
        : '';

    tariff.value = raw || '0';

}

tariffDisplay.addEventListener('input',syncTariff);

document.getElementById('form-edit-radiology').addEventListener('submit',function(){

    syncTariff();

});

})();
</script>