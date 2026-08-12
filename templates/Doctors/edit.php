<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Doctor $doctor
 * @var array $polyclinics
 * @var array $religions
 * @var array $specialists
 * @var array $regions
 */

$dataChild = $this->Html->link('Doctor', ['action' => 'index'], ['full_base'=>true]);
$polyclinics = $polyclinics ?? $this->Krs->polyclinics();
$religions = $religions ?? $this->Krs->religions();
$specialists = $specialists ?? $this->Krs->specialists();
$regions = $regions ?? $this->Krs->regions();
$selectedPolyclinic = $this->request->getData('polyclinic_name')
    ?? ($doctor->polyclinic_name ?? '');
$selectedSpecialist = $this->request->getData('specialist')
    ?? ($doctor->specialist ?? '');
$selectedRegion = $this->request->getData('region')
    ?? ($doctor->region ?? '');
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Edit') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">Perincian</h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" 
               class="btn btn-xs btn-icon btn-circle btn-default" 
               data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <?= $this->Form->create($doctor, ['data-parsley-validate'=>'true']) ?>

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
                    'data-parsley-required-message' => "Kode tidak boleh kosong!",
                    'value' => $doctor->code
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Region
            </label>

            <div class="col-md-2">
                <?php
                echo $this->Form->control('region', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Region...',
                    'value' => $doctor->region
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                NIK
            </label>

            <div class="col-md-5">
                <?php
                echo $this->Form->control('nik', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'NIK...',
                    'value' => $doctor->nik
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 2 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Nama*
            </label>

            <div class="col-md-5">
                <?php
                echo $this->Form->control('doctor_name', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nama Dokter...',
                    'required' => true,
                    'data-parsley-required-message' => "Nama dokter tidak boleh kosong!",
                    'value' => $doctor->doctor_name
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Specialist
            </label>

            <div class="col-md-5">
                <?php
                echo $this->Form->control('specialist', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Specialist...',
                    'value' => $doctor->specialist
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 3 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Polyclinic
            </label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('polyclinic_name', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $polyclinics,
                    'empty' => '-- Pilih Polyclinic --',
                    'value' => $selectedPolyclinic
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Religion
            </label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('religion', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $religions,
                    'empty' => '-- Pilih Religion --',
                    'value' => $doctor->religion
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Gender
            </label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('gender', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'Male' => 'Male',
                        'Female' => 'Female'
                    ],
                    'empty' => '-- Pilih Gender --',
                    'default' => $doctor->gender
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 4 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                SIP
            </label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('sip_number', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'SIP Number...',
                    'value' => $doctor->sip_number
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                STR
            </label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('str_number', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'STR Number...',
                    'value' => $doctor->str_number
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Phone
            </label>

            <div class="col-md-3">
                <?php
                echo $this->Form->control('phone_number', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Phone Number...',
                    'value' => $doctor->phone_number
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 5 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Tgl STR
            </label>

            <div class="col-md-2">
                <?php
                echo $this->Form->control('str_issue_date', [
                    'type' => 'date',
                    'label' => false,
                    'class' => 'form-control',
                    'value' => $doctor->str_issue_date
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Expired STR
            </label>

            <div class="col-md-2">
                <?php
                echo $this->Form->control('str_expiry_type', [
                    'label' => false,
                    'type' => 'select',
                    'options' => [
                        'date' => 'Pilih Tanggal',
                        'lifetime' => 'Seumur Hidup'
                    ],
                    'class' => 'form-control select2Form',
                    'id' => 'str-expiry-type',
                    'default' => ($doctor->str_expiry_date == 'Seumur Hidup') ? 'lifetime' : 'date'
                ]);
                ?>
            </div>

            <div class="col-md-2">
                <?php
                echo $this->Form->control('str_expiry_date', [
                    'type' => 'text',
                    'label' => false,
                    'class' => 'form-control',
                    'id' => 'str-expiry-date',
                    'placeholder' => 'Expired STR...',
                    'value' => $doctor->str_expiry_date
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 6 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Login NIK
            </label>

            <div class="col-md-5">
                <?php
                echo $this->Form->control('nik_login', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'NIK Login...',
                    'value' => $doctor->nik_login
                ]);
                ?>
            </div>

        </div>

        <!-- ROW 7 -->
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
                    'value' => $doctor->address
                ]);
                ?>
            </div>

        </div>

        <!-- HIDDEN -->
        <?php
        echo $this->Form->hidden('is_create', ['value' => $doctor->is_create]);
        echo $this->Form->hidden('is_update', ['value' => 1]);
        echo $this->Form->hidden('is_delete', ['value' => $doctor->is_delete]);
        echo $this->Form->hidden('is_active', ['value' => $doctor->is_active]);
        ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

$(document).ready(function() {

    $(".select2Form").select2();

    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

    var formAction = "<?=
        $this->Url->build(
            ['controller'=>'Doctors', 'action' => 'edit', $doctor->id],
            ['fullBase' => true]
        );
    ?>";

    handleFormConfirmSubmitValid(
        'DoctorEditForm',
        'btn-add',
        confirmTitle,
        formAction
    );

    function toggleStrExpiry() {

        let value = $('#str-expiry-type').val();

        if (value == 'lifetime') {

            $('#str-expiry-date')
                .attr('type', 'text')
                .val('Seumur Hidup');

        } else {

            $('#str-expiry-date')
                .attr('type', 'date');

            if ($('#str-expiry-date').val() == 'Seumur Hidup') {
                $('#str-expiry-date').val('');
            }

        }

    }

    toggleStrExpiry();

    $('#str-expiry-type').change(function () {

        toggleStrExpiry();

    });

});
</script>
