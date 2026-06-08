<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Doctor $doctor
 * @var array $polyclinics
 * @var array $religions
 */

$dataChild = $this->Html->link('Doctor', ['action' => 'index'], ['full_base' => true]);
$polyclinics = $polyclinics ?? $this->Krs->polyclinics();
$religions = $religions ?? $this->Krs->religions();
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Buat') ?>

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

    <?= $this->Form->create($doctor, ['data-parsley-validate' => 'true']) ?>

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
                    'placeholder' => 'Kosongkan untuk auto-generate'
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
                    'placeholder' => 'Region...'
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
                    'placeholder' => 'NIK...'
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
                    'data-parsley-required-message' => "Nama dokter tidak boleh kosong!"
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
                    'placeholder' => 'Specialist...'
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
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $polyclinics,
                    'empty' => '-- Pilih Polyclinic --',
                    'required' => true
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
                    'empty' => '-- Pilih Religion --'
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
                        'Male' => 'Laki-laki',
                        'Female' => 'Perempuan'
                    ],
                    'empty' => '-- Pilih Gender --'
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
                    'placeholder' => 'SIP Number...'
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
                    'placeholder' => 'STR Number...'
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
                    'placeholder' => 'Phone Number...'
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
                    'class' => 'form-control'
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Expired STR
            </label>

            <div class="col-md-2">

                <select id="str-expiry-type" class="form-control select2Form">
                    <option value="date">Pilih Tanggal</option>
                    <option value="lifetime">Seumur Hidup</option>
                </select>

            </div>

            <div class="col-md-2">

                <input type="date" id="str-expiry-date-picker" class="form-control">

                <?php
                echo $this->Form->hidden('str_expiry_date', [
                    'id' => 'str-expiry-date'
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
                    'placeholder' => 'NIK Login...'
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
                ['controller' => 'Doctors', 'action' => 'add'],
                ['fullBase' => true]
            );
        ?>";

    handleFormConfirmSubmitValid(
        'DoctorAddForm',
        'btn-add',
        confirmTitle,
        formAction
    );

    function toggleStrExpiry() {

        let value = $('#str-expiry-type').val();

        if (value == 'lifetime') {

            $('#str-expiry-date-picker').hide();

            $('#str-expiry-date').val('Seumur Hidup');

        } else {

            $('#str-expiry-date-picker').show();

            $('#str-expiry-date').val(
                $('#str-expiry-date-picker').val()
            );

        }

    }

    toggleStrExpiry();

    $('#str-expiry-type').change(function () {

        toggleStrExpiry();

    });

    $('#str-expiry-date-picker').change(function () {

        $('#str-expiry-date').val($(this).val());

    });

    });

</script>
