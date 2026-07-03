<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterLaboratory $masterLaboratory
 */

$kategoriPrefix = [
    'Hematologi' => 'HEM',
    'Kimia Klinik' => 'KIM',
    'Imunologi' => 'IMM',
    'Mikrobiologi' => 'MIK',
    'Patologi Anatomi' => 'PAT',
    'Urinalisa' => 'URI',
    'Serologi' => 'SER',
    'Lainnya' => 'LAB',
];

$kategoriOptions = [];
foreach ($kategoriPrefix as $key => $value) {
    $kategoriOptions[$key] = $key;
}
?>

<?= $this->Krs->breadcrumb('Master', 'Laboratory', 'Buat') ?>

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

        <?= $this->Form->create($masterLaboratory, ['id' => 'form-add-laboratory']) ?>

        <div class="row">

            <div class="col-md-4 form-group">
                <label>Kategori <span class="text-danger">*</span></label>

                <?= $this->Form->select('category', $kategoriOptions, [
                    'id' => 'category',
                    'class' => 'form-control',
                    'empty' => 'Pilih Kategori',
                    'required' => true,
                ]) ?>
            </div>

            <div class="col-md-4 form-group">

                <label>Kode <span class="text-danger">*</span></label>

                <div class="input-group">

                    <?= $this->Form->text('code', [
                        'id' => 'code',
                        'class' => 'form-control',
                        'placeholder' => 'Pilih kategori dahulu',
                        'readonly' => true,
                        'required' => true,
                    ]) ?>

                    <span class="input-group-btn">

                        <button class="btn btn-info" type="button" id="btn-generate">
                            <i class="fa fa-sync-alt"></i>
                        </button>

                        <button class="btn btn-default" type="button" id="btn-edit">
                            <i class="fa fa-edit"></i>
                        </button>

                    </span>

                </div>

            </div>

            <div class="col-md-4 form-group">

                <label>Status</label>

                <?= $this->Form->select('is_active', [
                    1 => 'Aktif',
                    0 => 'Nonaktif'
                ],[
                    'class'=>'form-control',
                    'value'=>1
                ]) ?>

            </div>

            <div class="col-md-8 form-group">

                <label>Nama Laboratorium <span class="text-danger">*</span></label>

                <?= $this->Form->text('name',[
                    'class'=>'form-control',
                    'placeholder'=>'Nama pemeriksaan laboratorium',
                    'required'=>true
                ]) ?>

            </div>

            <div class="col-md-4 form-group">

                <label>Tarif <span class="text-danger">*</span></label>

                <div class="input-group">

                    <span class="input-group-addon">Rp</span>

                    <input
                        type="text"
                        id="tariff-display"
                        class="form-control"
                        placeholder="0">

                </div>

                <?= $this->Form->hidden('tariff',[
                    'id'=>'tariff'
                ]) ?>

            </div>

        </div>

        <div class="m-t-15">

            <button class="btn btn-primary">

                <i class="fa fa-save"></i> Simpan

            </button>

            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action'=>'index'],
                [
                    'class'=>'btn btn-default',
                    'escape'=>false
                ]
            ) ?>

        </div>

        <?= $this->Form->end() ?>

    </div>

</div>

<script>

(function(){

var prefixMap = <?= json_encode($kategoriPrefix) ?>;

var category = document.getElementById('category');
var code = document.getElementById('code');

function pad(v){
    return v<10 ? '0'+v : v;
}

function generateCode(){

    var prefix = prefixMap[category.value];

    if(!prefix){
        code.value='';
        return;
    }

    var d = new Date();

    var no =
        String(d.getFullYear()).substr(2)+
        pad(d.getMonth()+1)+
        pad(d.getDate())+
        pad(d.getHours())+
        pad(d.getMinutes())+
        pad(d.getSeconds());

    code.value = prefix + '-' + no;

    code.readOnly = true;

}

category.onchange = generateCode;

document.getElementById('btn-generate').onclick = generateCode;

document.getElementById('btn-edit').onclick = function(){

    code.readOnly = false;
    code.focus();

};

var tarifDisplay = document.getElementById('tariff-display');
var tarif = document.getElementById('tariff');

function syncTarif(){

    var raw = tarifDisplay.value.replace(/\D/g,'');

    tarifDisplay.value = raw
        ? parseInt(raw).toLocaleString('id-ID')
        : '';

    tarif.value = raw;

}

tarifDisplay.addEventListener('input',syncTarif);

document.getElementById('form-add-laboratory').addEventListener('submit',function(){

    syncTarif();
    code.readOnly = false;

});

})();
</script>