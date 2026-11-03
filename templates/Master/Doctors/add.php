<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Doctor $doctor
 * @var array $polyclinics
 * @var array $religions
 * @var array $specialists
 * @var array $regions
 */

$dataChild = $this->Html->link('Doctor', ['action' => 'index'], ['full_base' => true]);
$polyclinics = $polyclinics ?? $this->Krs->polyclinics();
$religions = $religions ?? $this->Krs->religions();
$regions = $regions ?? $this->Krs->regions();
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
                    'placeholder' => 'Otomatis',
                    'readonly' => true,
                    'value' => 'Otomatis'
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Wilayah
            </label>

            <div class="col-md-2">

                <?php
                echo $this->Form->control('region', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $regions,
                    'empty' => '-- Pilih Wilayah --'
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

            <div class="col-md-11">

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

        </div>

        <!-- ROW 3 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Poliklinik
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('polyclinic_name', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $polyclinics,
                    'empty' => '-- Pilih Poliklinik --',
                    'required' => true
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Agama
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('religion', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $religions,
                    'empty' => '-- Pilih Agama --'
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Jenis Kelamin
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
                    'empty' => '-- Pilih Jenis Kelamin --'
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
                    'placeholder' => 'Nomor SIP...'
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
                    'placeholder' => 'Nomor STR...'
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Telepon
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('phone_number', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Nomor Telepon...'
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
                    'type' => 'text',
                    'label' => false,
                    'class' => 'form-control datepicker',
                    'placeholder' => 'dd/mm/yyyy',
                    'autocomplete' => 'off'
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Kadaluarsa STR
            </label>

            <div class="col-md-2">

                <select id="str-expiry-type" class="form-control select2Form">
                    <option value="date">Pilih Tanggal</option>
                    <option value="lifetime">Seumur Hidup</option>
                </select>

            </div>

            <div class="col-md-2">

                <input type="text" id="str-expiry-date-picker" class="form-control datepicker" placeholder="dd/mm/yyyy" autocomplete="off">

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
                NIK Login
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

        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            orientation: 'bottom auto'
        });

        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?=
            $this->Url->build(
                ['prefix' => 'Master', 'controller' => 'Doctors', 'action' => 'add'],
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

        $('#str-expiry-date-picker').on('changeDate', function () {

        $('#str-expiry-date').val($(this).val());

    });

    });

</script>