<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 * @var array $provinces
 * @var array $queuePatientData
 */
?>

<?php  
$provinces = $provinces ?? [];
$queuePatientData = $queuePatientData ?? [];

$patientFieldValue = function (string $field, $fallback = '') use ($patient) {

    $posted = $this->request->getData($field);
    if ($posted !== null && $posted !== '') {
        return $posted;
    }

    $posted = $this->request->getData('patient.' . $field);
    if ($posted !== null && $posted !== '') {
        return $posted;
    }

    return $patient->{$field} ?? $fallback;
};
?>

<?= $this->Krs->breadcrumb('Pasien', 'Edit') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-edit"></i> Edit Pasien — <?= h($patient->full_name) ?>
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
                        'readonly' => true,
                    ]) ?>
                    <small class="text-muted">Rekam Medis otomatis, tidak bisa diubah.</small>
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
                    <label>Jenis Identitas</label>
                    <?= $this->Form->control('identity_type', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['KTP' => 'KTP', 'SIM' => 'SIM', 'Paspor' => 'Paspor',
                                      'KIA' => 'KIA', 'BPJS' => 'BPJS'],
                        'empty'   => '-- Pilih Jenis --',
                        'class'   => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Nomor Identitas</label>
                    <?= $this->Form->control('identity_number', [
                        'label' => false,
                        'class' => 'form-control',
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
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>No. Telepon</label>
                    <?= $this->Form->control('phone_number', [
                        'label' => false,
                        'class' => 'form-control',
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
                        'class'   => 'form-control select2Form',
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
                            'Lainnya' => 'Lainnya',
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
                        'label' => false,
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Kewarganegaraan</label>
                    <?= $this->Form->control('nationality', [
                        'label' => false,
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Citizenship</label>
                    <?= $this->Form->control('citizenship', [
                        'label' => false,
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Suku</label>
                    <?= $this->Form->control('ethnic_group', [
                        'label' => false,
                        'class' => 'form-control select2Form',
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
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Ayah</label>
                    <?= $this->Form->control('father_name', [
                        'label' => false,
                        'class' => 'form-control',
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
                        'type'  => 'textarea',
                        'label' => false,
                        'class' => 'form-control',
                        'rows'  => 2,
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
                '<i class="fa fa-save"></i> Simpan Perubahan',
                ['class' => 'btn btn-success', 'escapeTitle' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

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

    function fetchRegion(urls, params, done) {
        var index = 0;
        function request() {
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
                if (data && $.isArray(data.data)) {
                    done(data.data);
                    return;
                }
                index++;
                if (index < urls.length) {
                    request();
                    return;
                }
                done([]);
            }).fail(function() {
                index++;
                if (index < urls.length) {
                    request();
                    return;
                }
                done([]);
            });
        }
        request();
    }

    function fillSelect($select, data, idKey, placeholder, selectedValue) {
        var html = '<option value="">' + placeholder + '</option>';
        var found = false;

        data.forEach(function(item) {
            var value = item[idKey];
            var selected = selectedValue !== null &&
                           selectedValue !== undefined &&
                           String(selectedValue) === String(value);

            if (selected) {
                found = true;
            }

            html += '<option value="' + value + '"' +
                (selected ? ' selected' : '') +
                '>' + item.nama + '</option>';
        });

        $select.html(html).prop('disabled', data.length === 0);

        if (found) {
            $select.val(String(selectedValue));
        }

        refreshSelect2($select);
        return found;
    }

    function clearLowerLevels(level) {
        if (level === 'prov' || level === 'kab' || level === 'kec') {
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-subdistrict, #hidden-subdistrict-name').val('');
        }
        if (level === 'prov' || level === 'kab') {
            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#hidden-district, #hidden-district-name, #hidden-subdistrict, #hidden-subdistrict-name').val('');
        }
        if (level === 'prov') {
            $('#ui-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);
            $('#hidden-city, #hidden-city-name, #hidden-district, #hidden-district-name, #hidden-subdistrict, #hidden-subdistrict-name').val('');
        }
        refreshSelect2($('#ui-kab, #ui-kec, #ui-kel'));
    }

    function loadKabupaten(idProv, selectedKab, callback) {
        fetchRegion(regionUrls.kabupatens, { id_prov: idProv }, function(data) {
            fillSelect($('#ui-kab'), data, 'id_kab', '-- Pilih Kabupaten/Kota --', selectedKab);
            $('#ui-kab').prop('disabled', data.length === 0);
            if (data.length && selectedKab) {
                $('#ui-kab').val(String(selectedKab));
                refreshSelect2($('#ui-kab'));
                $('#ui-kab').trigger('change');
            }
            if (typeof callback === 'function') {
                callback();
            }
        });
    }

    function loadKecamatan(idKab, selectedKec, callback) {
        fetchRegion(regionUrls.kecamatans, { id_kab: idKab }, function(data) {
            fillSelect($('#ui-kec'), data, 'id_kec', '-- Pilih Kecamatan --', selectedKec);
            $('#ui-kec').prop('disabled', data.length === 0);
            if (data.length && selectedKec) {
                $('#ui-kec').val(String(selectedKec));
                refreshSelect2($('#ui-kec'));
                $('#ui-kec').trigger('change');
            }
            if (typeof callback === 'function') {
                callback();
            }
        });
    }

    function loadKelurahan(idKec, selectedKel) {
        fetchRegion(regionUrls.kelurahans, { id_kec: idKec }, function(data) {
            fillSelect($('#ui-kel'), data, 'id_kel', '-- Pilih Kelurahan --', selectedKel);
            $('#ui-kel').prop('disabled', data.length === 0);
            if (data.length && selectedKel) {
                $('#ui-kel').val(String(selectedKel));
                refreshSelect2($('#ui-kel'));
            }
        });
    }

    $(document).on('change.patientsRegion select2:select.patientsRegion', '#ui-prov', function() {
        var selectedText = $(this).find('option:selected').text();
        var idProv = $(this).val();

        $('#hidden-province').val(idProv || '');
        $('#hidden-province-name').val(idProv ? selectedText : '');
        clearLowerLevels('prov');

        if (!idProv) {
            return;
        }

        loadKabupaten(idProv, null);
    });

    $(document).on('change.patientsRegion select2:select.patientsRegion', '#ui-kab', function() {
        var selectedText = $(this).find('option:selected').text();
        var idKab = $(this).val();

        $('#hidden-city').val(idKab || '');
        $('#hidden-city-name').val(idKab ? selectedText : '');
        clearLowerLevels('kab');

        if (!idKab) {
            return;
        }

        loadKecamatan(idKab, null);
    });

    $(document).on('change.patientsRegion select2:select.patientsRegion', '#ui-kec', function() {
        var selectedText = $(this).find('option:selected').text();
        var idKec = $(this).val();

        $('#hidden-district').val(idKec || '');
        $('#hidden-district-name').val(idKec ? selectedText : '');
        clearLowerLevels('kec');

        if (!idKec) {
            return;
        }

        loadKelurahan(idKec, null);
    });

    $(document).on('change.patientsRegion select2:select.patientsRegion', '#ui-kel', function() {
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
        $('#ui-prov').val(String(initialRegion.prov));
        refreshSelect2($('#ui-prov'));
        loadKabupaten(initialRegion.prov, initialRegion.kab, function() {
            if (!initialRegion.kab) {
                return;
            }
            loadKecamatan(initialRegion.kab, initialRegion.kec, function() {
                if (!initialRegion.kec) {
                    return;
                }
                loadKelurahan(initialRegion.kec, initialRegion.kel);
            });
        });
    }
});
</script>