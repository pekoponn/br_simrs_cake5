<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 * @var string|null $previewCode
 * @var array $provinces
 * @var array $queuePatientData
 */
?>

<?php  
$provinces = $provinces ?? [];
$queuePatientData = $queuePatientData ?? [];

$patientFieldValue = function (string $field, $fallback = '') use ($queuePatientData) {
    $posted = $this->request->getData($field);
    if ($posted !== null && $posted !== '') {
        return $posted;
    }

    $posted = $this->request->getData('patient.' . $field);
    if ($posted !== null && $posted !== '') {
        return $posted;
    }
    return $queuePatientData[$field] ?? $fallback;
};
?>

<?= $this->Krs->breadcrumb('Pasien', 'Tambah') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-user-plus"></i> Tambah Pasien Baru
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($patient) ?>

        <!-- ── SECTION 1: Data Utama ─────────────────────────── -->
        <h5 style="color:#2c3e50; font-weight:700; margin-bottom:14px; padding-bottom:6px;
                   border-bottom:2px solid #e9ecef;">
            <i class="fa fa-id-card"></i> Data Utama
        </h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Rekam Medis</label>
                    <?= $this->Form->control('code', [
                        'label'    => false,
                        'class'    => 'form-control',
                        'id'       => 'patient-code',
                        'value'    => $previewCode ?? ($patient->code ?? ''),
                        'readonly' => true,
                        'placeholder' => 'Terisi otomatis setelah Tanggal Lahir diisi',
                    ]) ?>
                    <small class="text-muted">Nomor Rekam Medis otomatis dari Tanggal Lahir + Tanggal Dibuat (format YYMMDD+YYMMDD).</small>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Gelar</label>
                    <?= $this->Form->control('title', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['Tn' => 'Tn', 'Ny' => 'Ny', 'Nn' => 'Nn', 'An' => 'An', 'By' => 'By'],
                        'empty'   => '-- Pilih --',
                        'class'   => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <?= $this->Form->control('full_name', [
                        'label'       => false,
                        'class'       => 'form-control',
                        'placeholder' => 'Nama lengkap pasien',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Jenis Identitas</label>
                    <?= $this->Form->control('identity_type', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => [
                            'KTP' => 'KTP',
                            'SIM' => 'SIM',
                            'Paspor' => 'Paspor',
                            'KIA' => 'KIA',
                            'BPJS' => 'BPJS'
                        ],
                        'empty'   => '-- Pilih Jenis --',
                        'class'   => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Kartu (BPJS/Asuransi)</label>
                    <?= $this->Form->control('insurance_card_no', [
                        'label'       => false,
                        'class'       => 'form-control',
                        'placeholder' => 'Boleh dikosongkan',
                        'required'    => false,
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Nomor Identitas</label>
                    <?= $this->Form->control('identity_number', [
                        'label'       => false,
                        'class'       => 'form-control',
                        'placeholder' => 'Nomor KTP / SIM / Paspor',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Gender <span class="text-danger">*</span></label>
                    <?= $this->Form->control('gender', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['Male' => '♂ Laki-laki', 'Female' => '♀ Perempuan'],
                        'empty'   => '-- Pilih Gender --',
                        'class'   => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Golongan Darah</label>
                    <?= $this->Form->control('blood_type', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O'],
                        'empty'   => '-- Pilih --',
                        'class'   => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <?= $this->Form->control('birth_date', [
                        'type'  => 'date',
                        'label' => false,
                        'class' => 'form-control',
                        'id'    => 'birth_date',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>No. Telepon</label>
                    <?= $this->Form->control('phone_number', [
                        'label'       => false,
                        'class'       => 'form-control',
                        'placeholder' => '08xxxxxxxxxx',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Status Active</label>
                    <?= $this->Form->control('is_active', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['Y' => 'Active', 'N' => 'Non Active'],
                        'class'   => 'form-control',
                        'value'   => 'Y',
                    ]) ?>
                </div>
            </div>

        </div>

        <hr>

        <!-- ── SECTION 2: Data Sosial ─────────────────────────── -->
        <h5 style="color:#2c3e50; font-weight:700; margin-bottom:14px; padding-bottom:6px;
                   border-bottom:2px solid #e9ecef;">
            <i class="fa fa-users"></i> Data Sosial
        </h5>
        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label>Agama</label>
                    <?= $this->Form->control('religion', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => [
                            'ISLAM'     => 'Islam',
                            'KRISTEN'   => 'Kristen',
                            'KATOLIK'   => 'Katolik',
                            'HINDU'     => 'Hindu',
                            'BUDDHA'    => 'Buddha',
                            'KONGHUCU'  => 'Konghucu',
                        ],
                        'empty' => '-- Pilih --',
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Pendidikan</label>
                    <?= $this->Form->control('education', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => [
                            'TIDAK SEKOLAH' => 'Tidak Sekolah',
                            'SD'            => 'SD',
                            'SMP'           => 'SMP',
                            'SMA / SMK'     => 'SMA / SMK',
                            'D1'            => 'D1',
                            'D2'            => 'D2',
                            'D3'            => 'D3',
                            'D4'            => 'D4',
                            'S1'            => 'S1',
                            'S2'            => 'S2',
                            'S3'            => 'S3',
                        ],
                        'empty' => '-- Pilih --',
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Status Pernikahan</label>
                    <?= $this->Form->control('marital_status', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => [
                            'BELUM MENIKAH' => 'Belum Menikah',
                            'MENIKAH'       => 'Menikah',
                            'CERAI HIDUP'   => 'Cerai Hidup',
                            'CERAI MATI'    => 'Cerai Mati',
                        ],
                        'empty' => '-- Pilih --',
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <?= $this->Form->control('occupation', [
                        'label'       => false,
                        'class'       => 'form-control select2Form',
                        'placeholder' => 'Pekerjaan pasien',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Kewarganegaraan</label>
                    <?= $this->Form->control('nationality', [
                        'label'       => false,
                        'class'       => 'form-control select2Form',
                        'placeholder' => 'WNI / WNA',
                        'value'       => 'WNI',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Citizenship</label>
                    <?= $this->Form->control('citizenship', [
                        'label'       => false,
                        'class'       => 'form-control select2Form',
                        'placeholder' => 'Indonesia',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Suku</label>
                    <?= $this->Form->control('ethnic_group', [
                        'label'       => false,
                        'class'       => 'form-control select2Form',
                        'placeholder' => 'Jawa / Sunda / Batak / dll',
                    ]) ?>
                </div>
            </div>

        </div>

        <hr>

        <!-- ── SECTION 3: Data Keluarga ───────────────────────── -->
        <h5 style="color:#2c3e50; font-weight:700; margin-bottom:14px; padding-bottom:6px;
                   border-bottom:2px solid #e9ecef;">
            <i class="fa fa-user-friends"></i> Data Keluarga
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Ibu</label>
                    <?= $this->Form->control('mother_name', [
                        'label'       => false,
                        'class'       => 'form-control',
                        'placeholder' => 'Nama ibu kandung',
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Ayah</label>
                    <?= $this->Form->control('father_name', [
                        'label'       => false,
                        'class'       => 'form-control',
                        'placeholder' => 'Nama ayah kandung',
                    ]) ?>
                </div>
            </div>
        </div>

        <hr>

        <!-- ── SECTION 4: Alamat ──────────────────────────────── -->
        <h5 style="color:#2c3e50; font-weight:700; margin-bottom:14px; padding-bottom:6px;
                   border-bottom:2px solid #e9ecef;">
            <i class="fa fa-map-marker-alt"></i> Alamat
        </h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <?= $this->Form->control('address', [
                        'type'        => 'textarea',
                        'label'       => false,
                        'class'       => 'form-control',
                        'rows'        => 2,
                        'placeholder' => 'Jl. nama jalan, RT/RW, nomor rumah...',
                    ]) ?>
                </div>
            </div>
            <div class="col-md-4">
                <label>Provinsi</label>
                <?php $vIdProv = $patientFieldValue('id_prov'); ?>
                <select id="ui-prov" class="form-control select2Form">
                    <option value="">-- Pilih Provinsi --</option>
                    <?php foreach ($provinces as $prov): ?>
                        <option value="<?= h($prov['id_prov']) ?>" <?= (string)$vIdProv === (string)$prov['id_prov'] ? 'selected' : '' ?>><?= h($prov['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="id_prov" id="hidden-province" value="<?= h($vIdProv) ?>">
                <input type="hidden" name="province" id="hidden-province-name" value="<?= h($patientFieldValue('province')) ?>">
            </div>
            <div class="col-md-4">
                <label>Kabupaten/Kota</label>
                <select id="ui-kab" class="form-control select2Form" disabled>
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                </select>
                <input type="hidden" name="id_kab" id="hidden-city" value="<?= h($patientFieldValue('id_kab')) ?>">
                <input type="hidden" name="city" id="hidden-city-name" value="<?= h($patientFieldValue('city')) ?>">
            </div>
            <div class="col-md-4">
                <label>Kecamatan</label>
                <select id="ui-kec" class="form-control select2Form" disabled>
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
                <input type="hidden" name="id_kec" id="hidden-district" value="<?= h($patientFieldValue('id_kec')) ?>">
                <input type="hidden" name="district" id="hidden-district-name" value="<?= h($patientFieldValue('district')) ?>">
            </div>

            <div class="col-md-4">
                <label>Kelurahan</label>
                <select id="ui-kel" class="form-control select2Form" disabled>
                    <option value="">-- Pilih Kelurahan --</option>
                </select>
                <input type="hidden" name="id_kel" id="hidden-subdistrict" value="<?= h($patientFieldValue('id_kel')) ?>">
                <input type="hidden" name="subdistrict" id="hidden-subdistrict-name" value="<?= h($patientFieldValue('subdistrict')) ?>">
            </div>
        </div>

        <hr>

        <div class="text-right">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default', 'escape' => false]
            ) ?>
            <?= $this->Form->button(
                '<i class="fa fa-save"></i> Simpan',
                ['class' => 'btn btn-success', 'escapeTitle' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

<script>
    $('#ui-prov').on('change', function() {
            var selectedText = $(this).find('option:selected').text();
            var idProv = $(this).val();

            $('#hidden-province').val(idProv || '');
            $('#hidden-province-name').val(idProv ? selectedText : '');

            $('#ui-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);
            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-city').val('');
            $('#hidden-city-name').val('');
            $('#hidden-district').val('');
            $('#hidden-district-name').val('');
            $('#hidden-subdistrict').val('');
            $('#hidden-subdistrict-name').val('');

            if (!idProv) return;

            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'getKabupatens']) ?>", {
                    id_prov: idProv
                },
                function(data) {
                    data.forEach(function(item) {
                        $('#ui-kab').append('<option value="' + item.id_kab + '" data-nama="' + item.nama + '">' + item.nama + '</option>');
                    });
                    $('#ui-kab').prop('disabled', false);
                    $('#ui-prov').trigger('kabupaten:loaded');
                }
            );
        });

        // ── Kabupaten → Kecamatan ─────────────────────────────────────────────────
        $('#ui-kab').on('change', function() {
            var selectedText = $(this).find('option:selected').text();
            var idKab = $(this).val();

            $('#hidden-city').val(idKab || '');
            $('#hidden-city-name').val(idKab ? selectedText : '');

            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-district').val('');
            $('#hidden-district-name').val('');
            $('#hidden-subdistrict').val('');
            $('#hidden-subdistrict-name').val('');

            if (!idKab) return;

            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'getKecamatans']) ?>", {
                    id_kab: idKab
                },
                function(data) {
                    data.forEach(function(item) {
                        $('#ui-kec').append('<option value="' + item.id_kec + '" data-nama="' + item.nama + '">' + item.nama + '</option>');
                    });
                    $('#ui-kec').prop('disabled', false);
                    $('#ui-kab').trigger('kecamatan:loaded');
                }
            );
        });

        // ── Kecamatan → Kelurahan ─────────────────────────────────────────────────
        $('#ui-kec').on('change', function() {
            var selectedText = $(this).find('option:selected').text();
            var idKec = $(this).val();

            $('#hidden-district').val(idKec || '');
            $('#hidden-district-name').val(idKec ? selectedText : '');

            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-subdistrict').val('');
            $('#hidden-subdistrict-name').val('');

            if (!idKec) return;

            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'getKelurahans']) ?>", {
                    id_kec: idKec
                },
                function(data) {
                    data.forEach(function(item) {
                        $('#ui-kel').append('<option value="' + item.id_kel + '" data-nama="' + item.nama + '">' + item.nama + '</option>');
                    });
                    $('#ui-kel').prop('disabled', false);
                    $('#ui-kec').trigger('kelurahan:loaded');
                }
            );
        });

        // ── Kelurahan dipilih ─────────────────────────────────────────────────────
        $('#ui-kel').on('change', function() {
            var selectedText = $(this).find('option:selected').text();
            var idKel = $(this).val();
            $('#hidden-subdistrict').val(idKel || '');
            $('#hidden-subdistrict-name').val(idKel ? selectedText : '');
        });

        var initialRegion = {
            prov: <?= json_encode((string)$patientFieldValue('id_prov')) ?>,
            kab: <?= json_encode((string)$patientFieldValue('id_kab')) ?>,
            kec: <?= json_encode((string)$patientFieldValue('id_kec')) ?>,
            kel: <?= json_encode((string)$patientFieldValue('id_kel')) ?>
        };

        if (initialRegion.prov) {
            $('#ui-prov').one('kabupaten:loaded', function() {
                if (!initialRegion.kab) return;

                $('#ui-kab').val(initialRegion.kab);
                $('#ui-kab').one('kecamatan:loaded', function() {
                    if (!initialRegion.kec) return;

                    $('#ui-kec').val(initialRegion.kec);
                    $('#ui-kec').one('kelurahan:loaded', function() {
                        if (!initialRegion.kel) return;

                        $('#ui-kel').val(initialRegion.kel).trigger('change');
                    });
                    $('#ui-kec').trigger('change');
                });
                $('#ui-kab').trigger('change');
            });
            $('#ui-prov').trigger('change');
        }
</script>
<script>
$(function() {
    var regionUrls = {
        kabupatens: [
            "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'getKabupatens']) ?>",
            "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'getKabupatens']) ?>"
        ],
        kecamatans: [
            "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'getKecamatans']) ?>",
            "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'getKecamatans']) ?>"
        ],
        kelurahans: [
            "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'getKelurahans']) ?>",
            "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'getKelurahans']) ?>"
        ]
    };

    function refreshSelect2($select) {
        $select.trigger('change.select2');
    }

    function requestRegion(urls, params, done) {
        var index = 0;

        function tryRequest() {
            $.ajax({
                url: urls[index],
                data: params,
                dataType: 'json',
                method: 'GET'
            }).done(function(data) {
                if ($.isArray(data)) {
                    done(data);
                    return;
                }

                index++;
                if (index < urls.length) {
                    tryRequest();
                    return;
                }

                done([]);
            }).fail(function() {
                index++;
                if (index < urls.length) {
                    tryRequest();
                    return;
                }

                done([]);
            });
        }

        tryRequest();
    }

    $(document).off('change.patientsRegion select2:select.patientsRegion', '#ui-prov, #ui-kab, #ui-kec, #ui-kel');

    $(document).on('change.patientsRegion select2:select.patientsRegion', '#ui-prov', function() {
        var selectedText = $(this).find('option:selected').text();
        var idProv = $(this).val();

        $('#hidden-province').val(idProv || '');
        $('#hidden-province-name').val(idProv ? selectedText : '');
        $('#ui-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);
        $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
        $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
        refreshSelect2($('#ui-kab, #ui-kec, #ui-kel'));
        $('#hidden-city, #hidden-city-name, #hidden-district, #hidden-district-name, #hidden-subdistrict, #hidden-subdistrict-name').val('');

        if (!idProv) return;

        requestRegion(regionUrls.kabupatens, { id_prov: idProv }, function(data) {
            $('#ui-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
            data.forEach(function(item) {
                $('#ui-kab').append('<option value="' + item.id_kab + '">' + item.nama + '</option>');
            });
            $('#ui-kab').prop('disabled', false);
            refreshSelect2($('#ui-kab'));
            $('#ui-prov').trigger('kabupaten:loaded');
        });
    });

    $(document).on('change.patientsRegion select2:select.patientsRegion', '#ui-kab', function() {
        var selectedText = $(this).find('option:selected').text();
        var idKab = $(this).val();

        $('#hidden-city').val(idKab || '');
        $('#hidden-city-name').val(idKab ? selectedText : '');
        $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
        $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
        refreshSelect2($('#ui-kec, #ui-kel'));
        $('#hidden-district, #hidden-district-name, #hidden-subdistrict, #hidden-subdistrict-name').val('');

        if (!idKab) return;

        requestRegion(regionUrls.kecamatans, { id_kab: idKab }, function(data) {
            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>');
            data.forEach(function(item) {
                $('#ui-kec').append('<option value="' + item.id_kec + '">' + item.nama + '</option>');
            });
            $('#ui-kec').prop('disabled', false);
            refreshSelect2($('#ui-kec'));
            $('#ui-kab').trigger('kecamatan:loaded');
        });
    });

    $(document).on('change.patientsRegion select2:select.patientsRegion', '#ui-kec', function() {
        var selectedText = $(this).find('option:selected').text();
        var idKec = $(this).val();

        $('#hidden-district').val(idKec || '');
        $('#hidden-district-name').val(idKec ? selectedText : '');
        $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
        refreshSelect2($('#ui-kel'));
        $('#hidden-subdistrict, #hidden-subdistrict-name').val('');

        if (!idKec) return;

        requestRegion(regionUrls.kelurahans, { id_kec: idKec }, function(data) {
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>');
            data.forEach(function(item) {
                $('#ui-kel').append('<option value="' + item.id_kel + '">' + item.nama + '</option>');
            });
            $('#ui-kel').prop('disabled', false);
            refreshSelect2($('#ui-kel'));
            $('#ui-kec').trigger('kelurahan:loaded');
        });
    });

    $(document).on('change.patientsRegion select2:select.patientsRegion', '#ui-kel', function() {
        var selectedText = $(this).find('option:selected').text();
        var idKel = $(this).val();
        $('#hidden-subdistrict').val(idKel || '');
        $('#hidden-subdistrict-name').val(idKel ? selectedText : '');
    });

    function updateRmPreview() {
        var birth = $('#birth_date').val();
        if (!birth) {
            $('#patient-code').val('');
            return;
        }
        var parts = birth.split('-'); // format input date: YYYY-MM-DD
        if (parts.length !== 3) {
            $('#patient-code').val('');
            return;
        }

        var birthYear2 = parts[0].slice(-2);
        var birthMonth = parts[1];
        var birthDay = parts[2];
        var birthPart = birthYear2 + birthMonth + birthDay;
        
        var today = new Date();
        var createdYear2 = String(today.getFullYear()).slice(-2);
        var createdMonth = String(today.getMonth() + 1).padStart(2, '0');
        var createdDay = String(today.getDate()).padStart(2, '0');
        var createdPart = createdYear2 + createdMonth + createdDay;
        $('#patient-code').val(birthPart + createdPart);
    }

    $('#birth_date').on('change', updateRmPreview);
    updateRmPreview();
});
</script>
