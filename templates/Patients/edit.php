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

            <label class="col-form-label col-md-1">Kode</label>

            <div class="col-md-2">

                <div class="input-group">

                    <span class="input-group-addon">
                        <input type="checkbox" id="auto-code" checked>
                    </span>

                    <?= $this->Form->control('code', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Kode Otomatis..',
                        'disabled' => true,
                        'id' => 'patient-code'
                    ]); ?>

                </div>

                <small class="text-muted">
                    Centang bila menggunakan kode otomatis.
                </small>

            </div>

            <label class="col-form-label col-md-1">No RM</label>

            <div class="col-md-2">
                <?= $this->Form->control('medical_record_no', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'No Rekam Medis',
                    'value' => $patient->medical_record_no ?? $patient->code ?? '',
                    'readonly' => true
                ]); ?>
            </div>

            <label class="col-form-label col-md-2">Nama Pasien</label>

            <div class="col-md-4">

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

                <?= $this->Form->control('birth_date', [
                    'type' => 'text',
                    'label' => false,
                    'class' => 'form-control datepicker-autoclose',
                    'id' => 'birth-date',
                    'autocomplete' => 'off',
                    'value' => !empty($patient->birth_date) ? $patient->birth_date->format('Y-m-d') : ''
                ]); ?>

            </div>

        </div>

        <!-- ROW 4 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Umur
            </label>

            <div class="col-md-2">
                <?= $this->Form->control('age', [
                    'label' => false,
                    'class' => 'form-control',
                    'id' => 'age',
                    'readonly' => true,
                    'value' => $patient->age
                ]); ?>
            </div>
            <label class="col-form-label col-md-1">
                Ibu
            </label>

            <div class="col-md-3">

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

            <div class="col-md-3">

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

            <label class="col-form-label col-md-1">Provinsi</label>
            <div class="col-md-3">
                <select name="id_prov" id="ui-prov" class="form-control select2Form">
                    <option value="">-- Pilih Provinsi --</option>
                    <?php foreach (($provinces ?? []) as $prov): ?>
                        <option value="<?= h($prov['id_prov']) ?>"
                            <?= ($patient->id_prov == $prov['id_prov']) ? 'selected' : '' ?>>
                            <?= h($prov['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label class="col-form-label col-md-1">Kota</label>
            <div class="col-md-3">
                <select name="id_kab" id="ui-kab" class="form-control select2Form">
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                </select>
            </div>

            <label class="col-form-label col-md-1">Kecamatan</label>
            <div class="col-md-3">
                <select name="id_kec" id="ui-kec" class="form-control select2Form">
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
            </div>

        </div>

        <!-- ROW 7 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">Kelurahan</label>
            <div class="col-md-3">
                <select name="id_kel" id="ui-kel" class="form-control select2Form">
                    <option value="">-- Pilih Kelurahan --</option>
                </select>
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
    $(document).ready(function() {

        $(".select2Form").select2();

        var selectedKab = "<?= h($patient->id_kab ?? '') ?>";
        var selectedKec = "<?= h($patient->id_kec ?? '') ?>";
        var selectedKel = "<?= h($patient->id_kel ?? '') ?>";

        function loadKabupatens(idProv, selectedValue = '') {
            $('#ui-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>');
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>');

            if (!idProv) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Patients', 'action' => 'getKabupatens']) ?>", {
                    id_prov: idProv
                },
                function(data) {
                    $.each(data, function(index, item) {
                        var selected = item.id_kab == selectedValue ? 'selected' : '';
                        $('#ui-kab').append('<option value="' + item.id_kab + '" ' + selected + '>' + item.nama + '</option>');
                    });

                    $('#ui-kab').trigger('change.select2');

                    if (selectedValue) {
                        loadKecamatans(selectedValue, selectedKec);
                    }
                }
            );
        }

        function loadKecamatans(idKab, selectedValue = '') {
            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>');
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>');

            if (!idKab) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Patients', 'action' => 'getKecamatans']) ?>", {
                    id_kab: idKab
                },
                function(data) {
                    $.each(data, function(index, item) {
                        var selected = item.id_kec == selectedValue ? 'selected' : '';
                        $('#ui-kec').append('<option value="' + item.id_kec + '" ' + selected + '>' + item.nama + '</option>');
                    });

                    $('#ui-kec').trigger('change.select2');

                    if (selectedValue) {
                        loadKelurahans(selectedValue, selectedKel);
                    }
                }
            );
        }

        function loadKelurahans(idKec, selectedValue = '') {
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>');

            if (!idKec) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Patients', 'action' => 'getKelurahans']) ?>", {
                    id_kec: idKec
                },
                function(data) {
                    $.each(data, function(index, item) {
                        var selected = item.id_kel == selectedValue ? 'selected' : '';
                        $('#ui-kel').append('<option value="' + item.id_kel + '" ' + selected + '>' + item.nama + '</option>');
                    });

                    $('#ui-kel').trigger('change.select2');
                }
            );
        }

        $('#ui-prov').on('change', function() {
            loadKabupatens($(this).val());
        });

        $('#ui-kab').on('change', function() {
            loadKecamatans($(this).val());
        });

        $('#ui-kec').on('change', function() {
            loadKelurahans($(this).val());
        });

        if ($('#ui-prov').val()) {
            loadKabupatens($('#ui-prov').val(), selectedKab);
        }

        function calculateAge(birthDate) {
            if (!birthDate) return '';

            var today = new Date();
            var birth = new Date(birthDate);

            var years = today.getFullYear() - birth.getFullYear();
            var months = today.getMonth() - birth.getMonth();
            var days = today.getDate() - birth.getDate();

            if (days < 0) {
                months--;
                days += new Date(today.getFullYear(), today.getMonth(), 0).getDate();
            }

            if (months < 0) {
                years--;
                months += 12;
            }

            return years + ' Tahun ' + months + ' Bulan ' + days + ' Hari';
        }

        $('.datepicker-autoclose').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $('#birth-date').on('change changeDate', function() {
            $('#age').val(calculateAge($(this).val()));
        });

        if ($('#birth-date').val() && !$('#age').val()) {
            $('#age').val(calculateAge($('#birth-date').val()));
        }

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
