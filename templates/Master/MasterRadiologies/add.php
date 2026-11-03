<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterRadiology $masterRadiology
 */

$kategoriPrefix = [
    'X-Ray' => 'XR',
    'CT Scan' => 'CT',
    'MRI' => 'MRI',
    'USG' => 'USG',
    'Mammografi' => 'MMG',
    'Fluoroscopy' => 'FLR',
    'Lainnya' => 'RAD',
];

$kategoriOptions = [];
foreach ($kategoriPrefix as $key => $val) {
    $kategoriOptions[$key] = $key;
}
?>

<?= $this->Krs->breadcrumb('Master', 'Radiologi', 'Buat') ?>

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
            'id' => 'form-add-radiology'
        ]) ?>

        <div class="row">

            <div class="col-md-4 form-group">

                <label>Kategori <span class="text-danger">*</span></label>

                <?= $this->Form->select(
                    'category',
                    $kategoriOptions,
                    [
                        'id' => 'category',
                        'class' => 'form-control',
                        'empty' => 'Pilih Kategori',
                        'required' => true
                    ]
                ) ?>

            </div>

            <div class="col-md-4 form-group">

                <label>Kode <span class="text-danger">*</span></label>

                <div class="input-group">

                    <?= $this->Form->text('code',[
                        'id'=>'code',
                        'class'=>'form-control',
                        'placeholder'=>'Pilih kategori dahulu',
                        'readonly'=>true,
                        'required'=>true,
                        'maxlength'=>20,
                        'style'=>'font-family:monospace;'
                    ]) ?>

                    <span class="input-group-btn">

                        <button
                            type="button"
                            id="btn-generate"
                            class="btn btn-info">

                            <i class="fa fa-sync-alt"></i>

                        </button>

                        <button
                            type="button"
                            id="btn-edit"
                            class="btn btn-default">

                            <i class="fa fa-edit"></i>

                        </button>

                    </span>

                </div>

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
                        'value'=>1
                    ]
                ) ?>

            </div>

            <div class="col-md-8 form-group">

                <label>Nama Radiologi <span class="text-danger">*</span></label>

                <?= $this->Form->text('name',[
                    'class'=>'form-control',
                    'placeholder'=>'Nama tindakan radiologi',
                    'required'=>true,
                    'maxlength'=>200
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
                        placeholder="0"
                        inputmode="numeric"
                        required>

                </div>

                <?= $this->Form->hidden('tariff',[
                    'id'=>'tariff',
                    'value'=>0
                ]) ?>

            </div>

        </div>

        <div class="m-t-10">

            <button
                type="submit"
                class="btn btn-primary">

                <i class="fa fa-save"></i>
                Simpan

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

var prefixMap = <?= json_encode($kategoriPrefix,JSON_UNESCAPED_UNICODE) ?>;

var category = document.getElementById('category');
var code = document.getElementById('code');

var btnGenerate = document.getElementById('btn-generate');
var btnEdit = document.getElementById('btn-edit');

var tariffDisplay = document.getElementById('tariff-display');
var tariff = document.getElementById('tariff');

function pad(v){
    return v < 10 ? '0'+v : String(v);
}

function generateCode(){

    var prefix = prefixMap[category.value] || '';

    if(!prefix){
        code.value='';
        return;
    }

    var d = new Date();

    var no =
        String(d.getFullYear()).slice(-2)+
        pad(d.getMonth()+1)+
        pad(d.getDate())+
        pad(d.getHours())+
        pad(d.getMinutes())+
        pad(d.getSeconds());

    code.value = prefix + '-' + no;

    code.readOnly = true;

}

function syncTariff(){

    var raw = tariffDisplay.value.replace(/\D/g,'');

    tariffDisplay.value = raw
        ? parseInt(raw,10).toLocaleString('id-ID')
        : '';

    tariff.value = raw || '0';

}

category.addEventListener('change',generateCode);

btnGenerate.addEventListener('click',generateCode);

btnEdit.addEventListener('click',function(){

    code.readOnly=false;
    code.focus();

});

tariffDisplay.addEventListener('input',syncTariff);

document.getElementById('form-add-radiology').addEventListener('submit',function(){

    syncTariff();

    code.readOnly=false;

});

})();
</script>