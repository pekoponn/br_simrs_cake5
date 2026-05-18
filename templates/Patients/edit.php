<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */

$dataChild = $this->Html->link('Patient', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Edit') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">

        <h4 class="panel-title">
            Perincian
        </h4>

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

                <?php
                echo $this->Form->control('code', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kode...',
                    'required' => true,
                    'value' => $patient->code
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-2">
                Nama Pasien
            </label>

            <div class="col-md-7">

                <?php
                echo $this->Form->control('full_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Pasien...',
                    'required' => true,
                    'value' => $patient->full_name
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 2 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Identitas
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('identity_type', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'KTP' => 'KTP',
                        'SIM' => 'SIM',
                        'PASSPORT' => 'Passport'
                    ],
                    'empty' => '-- Pilih --',
                    'default' => $patient->identity_type
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-2">
                No Identitas
            </label>

            <div class="col-md-6">

                <?php
                echo $this->Form->control('identity_number', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'No Identitas...',
                    'value' => $patient->identity_number
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 3 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Gender
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('gender', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'Male' => 'Laki-laki',
                        'Female' => 'Perempuan'
                    ],
                    'empty' => '-- Pilih Gender --',
                    'default' => $patient->gender
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-2">
                Gol Darah
            </label>

            <div class="col-md-2">

                <?php
                echo $this->Form->control('blood_type', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'A' => 'A',
                        'B' => 'B',
                        'AB' => 'AB',
                        'O' => 'O'
                    ],
                    'empty' => '-- Pilih --',
                    'default' => $patient->blood_type
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Lahir
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('birth_date', [
                    'type' => 'date',
                    'label' => false,
                    'class' => 'form-control',
                    'value' => $patient->birth_date
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 4 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Ibu
            </label>

            <div class="col-md-5">

                <?php
                echo $this->Form->control('mother_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Ibu...',
                    'value' => $patient->mother_name
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Ayah
            </label>

            <div class="col-md-5">

                <?php
                echo $this->Form->control('father_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Ayah...',
                    'value' => $patient->father_name
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 5 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Phone
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('phone_number', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Phone Number...',
                    'value' => $patient->phone_number
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-2">
                Kewarganegaraan
            </label>

            <div class="col-md-2">

                <?php
                echo $this->Form->control('citizenship', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'WNI/WNA...',
                    'value' => $patient->citizenship
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Negara
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('nationality', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nationality...',
                    'value' => $patient->nationality
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

                <?php
                echo $this->Form->control('province', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Provinsi...',
                    'value' => $patient->province
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Kota
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('city', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kota...',
                    'value' => $patient->city
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Kecamatan
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('district', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kecamatan...',
                    'value' => $patient->district
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

                <?php
                echo $this->Form->control('subdistrict', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kelurahan...',
                    'value' => $patient->subdistrict
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Pekerjaan
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('occupation', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Pekerjaan...',
                    'value' => $patient->occupation
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Agama
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('religion', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Agama...',
                    'value' => $patient->religion
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 8 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Pendidikan
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('education', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Pendidikan...',
                    'value' => $patient->education
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Suku
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('ethnic_group', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Suku...',
                    'value' => $patient->ethnic_group
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Status
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('marital_status', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'Belum Menikah' => 'Belum Menikah',
                        'Menikah' => 'Menikah',
                        'Cerai' => 'Cerai'
                    ],
                    'empty' => '-- Pilih Status --',
                    'default' => $patient->marital_status
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

                <?php
                echo $this->Form->control('address', [
                    'type' => 'textarea',
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Alamat...',
                    'rows' => 3,
                    'value' => $patient->address
                ]);
                ?>

            </div>

        </div>

        <!-- HIDDEN -->
        <?php
        echo $this->Form->hidden('is_create', ['value' => $patient->is_create]);
        echo $this->Form->hidden('is_update', ['value' => 1]);
        echo $this->Form->hidden('is_delete', ['value' => $patient->is_delete]);
        echo $this->Form->hidden('is_active', ['value' => $patient->is_active]);
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
                ['controller' => 'Patients', 'action' => 'edit', $patient->id],
                ['fullBase' => true]
            );
        ?>";

    handleFormConfirmSubmitValid(
        'PatientEditForm',
        'btn-add',
        confirmTitle,
        formAction
    );

});
</script>