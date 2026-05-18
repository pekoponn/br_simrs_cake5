<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */

$dataChild = $this->Html->link('Patient', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">Perincian</h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <?= $this->Form->create($patient, ['data-parsley-validate' => 'true']) ?>

    <div class="panel-body">

        <!-- ROW 1 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Kode
            </label>

            <div class="col-md-2">
                <?=
                    $this->Form->control('code', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kode Pasien...',
                        'required' => true
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Nama
            </label>

            <div class="col-md-8">
                <?=
                    $this->Form->control('full_name', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nama Lengkap...',
                        'required' => true
                    ]);
                ?>
            </div>

        </div>

        <!-- ROW 2 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Identitas
            </label>

            <div class="col-md-2">
                <?=
                    $this->Form->control('identity_type', [
                        'label' => false,
                        'class' => 'form-control select2Form',
                        'options' => [
                            'KTP' => 'KTP',
                            'SIM' => 'SIM',
                            'PASSPORT' => 'Passport'
                        ],
                        'empty' => '-- Pilih --'
                    ]);
                ?>
            </div>

            <div class="col-md-3">
                <?=
                    $this->Form->control('identity_number', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nomor Identitas...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Gender
            </label>

            <div class="col-md-2">
                <?=
                    $this->Form->control('gender', [
                        'label' => false,
                        'class' => 'form-control select2Form',
                        'options' => [
                            'L' => 'Laki-laki',
                            'P' => 'Perempuan'
                        ],
                        'empty' => '-- Pilih --'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Gol. Darah
            </label>

            <div class="col-md-2">
                <?=
                    $this->Form->control('blood_type', [
                        'label' => false,
                        'class' => 'form-control select2Form',
                        'options' => [
                            'A' => 'A',
                            'B' => 'B',
                            'AB' => 'AB',
                            'O' => 'O'
                        ],
                        'empty' => '-- Pilih --'
                    ]);
                ?>
            </div>

        </div>

        <!-- ROW 3 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Tgl Lahir
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('birth_date', [
                        'type' => 'date',
                        'label' => false,
                        'class' => 'form-control'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Telepon
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('phone_number', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nomor Telepon...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Agama
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('religion', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Agama...'
                    ]);
                ?>
            </div>

        </div>

        <!-- ROW 4 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Ayah
            </label>

            <div class="col-md-5">
                <?=
                    $this->Form->control('father_name', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nama Ayah...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Ibu
            </label>

            <div class="col-md-5">
                <?=
                    $this->Form->control('mother_name', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Nama Ibu...'
                    ]);
                ?>
            </div>

        </div>

        <!-- ROW 5 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Kewarganegaraan
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('citizenship', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kewarganegaraan...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Negara
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('nationality', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Negara...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Status
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('marital_status', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Status Pernikahan...'
                    ]);
                ?>
            </div>

        </div>

        <!-- ROW 6 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Provinsi
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('province', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Provinsi...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Kota
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('city', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kota...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Kecamatan
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('district', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kecamatan...'
                    ]);
                ?>
            </div>

        </div>

        <!-- ROW 7 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Kelurahan
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('subdistrict', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kelurahan...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Pekerjaan
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('occupation', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Pekerjaan...'
                    ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Pendidikan
            </label>

            <div class="col-md-3">
                <?=
                    $this->Form->control('education', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Pendidikan...'
                    ]);
                ?>
            </div>

        </div>

        <!-- ROW 8 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Suku
            </label>

            <div class="col-md-11">
                <?=
                    $this->Form->control('ethnic_group', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Suku...'
                    ]);
                ?>
            </div>

        </div>

        <!-- ROW 9 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Alamat
            </label>

            <div class="col-md-11">
                <?=
                    $this->Form->control('address', [
                        'type' => 'textarea',
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Alamat...',
                        'rows' => 3
                    ]);
                ?>
            </div>

        </div>

        <!-- HIDDEN -->
        <?php
        echo $this->Form->hidden('is_create', ['value' => 1]);
        echo $this->Form->hidden('is_update', ['value' => 0]);
        echo $this->Form->hidden('is_delete', ['value' => 0]);
        echo $this->Form->hidden('is_active', ['value' => 'Y']);
        ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        $(".select2Form").select2();

        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?=
            $this->Url->build(
                ['controller' => 'Patients', 'action' => 'add'],
                ['fullBase' => true]
            );
        ?>";

        handleFormConfirmSubmitValid(
            'PatientAddForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });

</script>