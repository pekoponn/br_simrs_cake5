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
                        'required' => false,
                        'data-parsley-excluded' => 'true',
                        'data-parsley-required' => 'false',
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
                    'placeholder' => 'Otomatis..',
                    'disabled' => true,
                    'required' => false,
                    'data-parsley-excluded' => 'true',
                    'data-parsley-required' => 'false'
                ]); ?>
            </div>

            <label class="col-form-label col-md-1">Nama</label>

            <div class="col-md-5">
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
                        'Male' => 'Laki-laki',
                        'Female' => 'Perempuan'
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
                Tanggal Lahir
            </label>

            <div class="col-md-3">
                <?= $this->Form->control('birth_date', [
                    'type' => 'text',
                    'label' => false,
                    'class' => 'form-control datepicker-autoclose',
                    'id' => 'birth-date',
                    'autocomplete' => 'off'
                ]); ?>
            </div>

            <label class="col-form-label col-md-1">
                Umur
            </label>

            <div class="col-md-2">
                <?= $this->Form->control('age', [
                    'label' => false,
                    'class' => 'form-control',
                    'id' => 'age',
                    'readonly' => true
                ]); ?>
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

        </div>

        <!-- ROW 4 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Agama
            </label>

            <div class="col-md-3">
                <?=
                $this->Form->control('religion', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'Islam' => 'Islam',
                        'Kristen' => 'Kristen',
                        'Katolik' => 'Katolik',
                        'Hindu' => 'Hindu',
                        'Buddha' => 'Buddha',
                        'Konghucu' => 'Konghucu',
                        'Lainnya' => 'Lainnya',
                    ],
                    'empty' => '-- Pilih --'
                ]);
                ?>
            </div>

            <label class="col-form-label col-md-1">
                Ayah
            </label>

            <div class="col-md-3">
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

            <div class="col-md-3">
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
                <?= $this->Form->control('citizenship', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'WNI' => 'WNI',
                        'WNA' => 'WNA'
                    ],
                    'empty' => '-- Pilih --',
                    'value' => 'WNI'
                ]); ?>
            </div>

            <label class="col-form-label col-md-1">
                Negara
            </label>

            <div class="col-md-3">
                <?= $this->Form->control('nationality', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'Indonesia' => 'Indonesia',
                        'Lainnya' => 'Lainnya'
                    ],
                    'empty' => '-- Pilih --',
                    'value' => 'Indonesia'
                ]); ?>
            </div>

            <label class="col-form-label col-md-1">
                Status
            </label>

            <div class="col-md-3">
                <?= $this->Form->control('marital_status', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'Belum Menikah' => 'Belum Menikah',
                        'Menikah' => 'Menikah',
                        'Cerai Hidup' => 'Cerai Hidup',
                        'Cerai Mati' => 'Cerai Mati'
                    ],
                    'empty' => '-- Pilih --'
                ]); ?>
            </div>

        </div>

        <!-- ROW 6 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Provinsi
            </label>

            <div class="col-md-3">
                <select id="ui-prov" class="form-control select2Form">
                    <option value="">-- Pilih Provinsi --</option>
                    <?php foreach ($provinces as $prov): ?>
                        <option value="<?= h($prov['id_prov']) ?>"><?= h($prov['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="id_prov" id="hidden-province">
            </div>

            <label class="col-form-label col-md-1">
                Kota
            </label>

            <div class="col-md-3">
                <select id="ui-kab" class="form-control select2Form" disabled>
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                </select>
                <input type="hidden" name="id_kab" id="hidden-city">
            </div>

            <label class="col-form-label col-md-1">
                Kecamatan
            </label>

            <div class="col-md-3">
                <select id="ui-kec" class="form-control select2Form" disabled>
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
                <input type="hidden" name="id_kec" id="hidden-district">
            </div>

        </div>
        <!-- ROW 7 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Kelurahan
            </label>

            <div class="col-md-3">
                <select id="ui-kel" class="form-control select2Form" disabled>
                    <option value="">-- Pilih Kelurahan --</option>
                </select>
                <input type="hidden" name="id_kel" id="hidden-subdistrict">
            </div>

            <label class="col-form-label col-md-1">
                Pekerjaan
            </label>

            <div class="col-md-3">
                <?= $this->Form->control('occupation', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'BELUM/TIDAK BEKERJA' => 'BELUM/TIDAK BEKERJA',
                        'PELAJAR/MAHASISWA' => 'PELAJAR/MAHASISWA',
                        'PNS' => 'PNS',
                        'TNI' => 'TNI',
                        'POLRI' => 'POLRI',
                        'PEGAWAI SWASTA' => 'PEGAWAI SWASTA',
                        'WIRASWASTA' => 'WIRASWASTA',
                        'PETANI' => 'PETANI',
                        'NELAYAN' => 'NELAYAN',
                        'BURUH' => 'BURUH',
                        'IBU RUMAH TANGGA' => 'IBU RUMAH TANGGA',
                        'PENSIUNAN' => 'PENSIUNAN',
                        'PENDETA' => 'PENDETA',
                        'USTADZ' => 'USTADZ',
                        'DOKTER' => 'DOKTER',
                        'PERAWAT' => 'PERAWAT',
                        'BIDAN' => 'BIDAN',
                        'APOTEKER' => 'APOTEKER',
                        'GURU' => 'GURU',
                        'DOSEN' => 'DOSEN',
                        'LAINNYA' => 'LAINNYA'
                    ],
                    'empty' => '-- Pilih Pekerjaan --'
                ]); ?>
            </div>

            <label class="col-form-label col-md-1">
                Pendidikan
            </label>

            <div class="col-md-3">
                <?= $this->Form->control('education', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA/SMK' => 'SMA/SMK',
                        'D3' => 'D3',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                        'Lainnya' => 'Lainnya'
                    ],
                    'empty' => '-- Pilih --'
                ]); ?>
            </div>

        </div>

        <!-- ROW 8 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Suku
            </label>

            <div class="col-md-3">
                <?= $this->Form->control('ethnic_group', [
                    'type' => 'select',
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'JAWA' => 'JAWA',
                        'SUNDA' => 'SUNDA',
                        'MADURA' => 'MADURA',
                        'BATAK' => 'BATAK',
                        'MINANGKABAU' => 'MINANGKABAU',
                        'BETAWI' => 'BETAWI',
                        'BUGIS' => 'BUGIS',
                        'MAKASSAR' => 'MAKASSAR',
                        'DAYAK' => 'DAYAK',
                        'BANJAR' => 'BANJAR',
                        'ACEH' => 'ACEH',
                        'MELAYU' => 'MELAYU',
                        'PAPUA' => 'PAPUA',
                        'AMBON' => 'AMBON',
                        'TIMOR' => 'TIMOR',
                        'BALI' => 'BALI',
                        'SASAK' => 'SASAK',
                        'TIONGHOA' => 'TIONGHOA',
                        'ARAB' => 'ARAB',
                        'LAINNYA' => 'LAINNYA'
                    ],
                    'empty' => '-- Pilih Suku --'
                ]); ?>
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
    $(document).ready(function() {

        $(".select2Form").select2();

        $('#ui-prov').on('change', function() {
            var idProv = $(this).val();
            var selectedText = $(this).find('option:selected').text();

            $('#hidden-province').val(idProv ? selectedText : '');

            $('#ui-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);
            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);

            $('#hidden-city').val('');
            $('#hidden-district').val('');
            $('#hidden-subdistrict').val('');

            if (!idProv) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Patients', 'action' => 'getKabupatens']) ?>", {
                    id_prov: idProv
                },
                function(data) {
                    data.forEach(function(item) {
                        $('#ui-kab').append(
                            '<option value="' + item.id_kab + '">' + item.nama + '</option>'
                        );
                    });

                    $('#ui-kab').prop('disabled', false).trigger('change.select2');
                }
            );
        });

        $('#ui-kab').on('change', function() {
            var idKab = $(this).val();
            var selectedText = $(this).find('option:selected').text();

            $('#hidden-city').val(idKab ? selectedText : '');

            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);

            $('#hidden-district').val('');
            $('#hidden-subdistrict').val('');

            if (!idKab) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Patients', 'action' => 'getKecamatans']) ?>", {
                    id_kab: idKab
                },
                function(data) {
                    data.forEach(function(item) {
                        $('#ui-kec').append(
                            '<option value="' + item.id_kec + '">' + item.nama + '</option>'
                        );
                    });

                    $('#ui-kec').prop('disabled', false).trigger('change.select2');
                }
            );
        });

        $('#ui-kec').on('change', function() {
            var idKec = $(this).val();
            var selectedText = $(this).find('option:selected').text();

            $('#hidden-district').val(idKec ? selectedText : '');

            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-subdistrict').val('');

            if (!idKec) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Patients', 'action' => 'getKelurahans']) ?>", {
                    id_kec: idKec
                },
                function(data) {
                    data.forEach(function(item) {
                        $('#ui-kel').append(
                            '<option value="' + item.id_kel + '">' + item.nama + '</option>'
                        );
                    });

                    $('#ui-kel').prop('disabled', false).trigger('change.select2');
                }
            );
        });

        $('#ui-kel').on('change', function() {
            var idKel = $(this).val();
            var selectedText = $(this).find('option:selected').text();

            $('#hidden-subdistrict').val(idKel ? selectedText : '');
        });

        $('#auto-code').change(function() {

            if ($(this).is(':checked')) {

                $('#patient-code')
                    .prop('disabled', true)
                    .val('')
                    .attr('placeholder', 'Kode Otomatis..')
                    .removeAttr('required')
                    .attr('data-parsley-excluded', 'true')
                    .attr('data-parsley-required', 'false');

            } else {

                $('#patient-code')
                    .prop('disabled', false)
                    .attr('placeholder', 'Masukkan Kode Pasien')
                    .removeAttr('required')
                    .removeAttr('data-parsley-excluded')
                    .attr('data-parsley-required', 'false');

            }

            if ($('#patient-code').parsley) {
                $('#patient-code').parsley().reset();
            }

        });

        $('#auto-code').trigger('change');

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

        $('#birth-date').on('change changeDate', function() {
            $('#age').val(calculateAge($(this).val()));
        });
        $('.datepicker-autoclose').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?= $this->Url->build(['controller' => 'Patients', 'action' => 'add'], ['fullBase' => true]); ?>";

        handleFormConfirmSubmitValid(
            'PatientAddForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });
</script>
