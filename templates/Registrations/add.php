<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 * @var \Cake\Collection\CollectionInterface|string[] $doctors
 * @var \Cake\Collection\CollectionInterface|string[] $rooms
 * @var \Cake\Collection\CollectionInterface|string[] $beds
 */
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Registrations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column-responsive column-80">
        <div class="registrations form content">

            <?= $this->Form->create($registration) ?>

            <fieldset>
                <legend><?= __('Add Registration') ?></legend>

                <h4>Data Pasien</h4>

                <?= $this->Form->hidden('patient_id', ['id' => 'patient-id']) ?>

                <div class="row">
                    <div class="col-md-3">
                        <label>No Rekam Medis</label>
                        <div class="input-group">
                            <input type="text" id="view-code" class="form-control" readonly>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalSearchPatient">
                                    Cari
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>Jenis Identitas</label>
                        <input type="text" id="view-identity-type" name="patient[identity_type]" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>No Identitas</label>
                        <input type="text" id="view-identity-number" name="patient[identity_number]"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Gelar</label>

                        <select id="view-patient-title" name="patient_title" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Tn">Tn</option>
                            <option value="Ny">Ny</option>
                            <option value="Nn">Nn</option>
                            <option value="An">An</option>
                            <option value="By">By</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Nama Pasien</label>
                        <input type="text" id="view-full-name" name="patient[full_name]" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Jenis Kelamin</label>
                        <select id="view-gender" name="patient[gender]" class="form-control">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Male">Laki-laki</option>
                            <option value="Female">Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Golongan Darah</label>
                        <select id="view-blood-type" name="patient[blood_type]" class="form-control">
                            <option value="">-- Pilih Golongan Darah --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" id="view-birth-date" name="patient[birth_date]" class="form-control">
                    </div>

                    <div class="col-md-9">
                        <label>Alamat</label>
                        <input type="text" id="view-address" name="patient[address]" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Nama Ayah</label>
                        <input type="text" id="view-father-name" name="patient[father_name]" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Nama Ibu</label>
                        <input type="text" id="view-mother-name" name="patient[mother_name]" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>No Telepon</label>
                        <input type="text" id="view-phone-number" name="patient[phone_number]" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Kewarganegaraan</label>

                        <select id="view-nationality" name="patient[nationality]" class="form-control">
                            <option value="">-- Pilih Kewarganegaraan --</option>
                            <option value="WNI">WNI</option>
                            <option value="WNA">WNA</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Negara</label>

                        <select id="view-citizenship" name="patient[citizenship]" class="form-control">
                            <option value="">-- Pilih Negara --</option>
                            <option value="INDONESIA">INDONESIA</option>
                            <option value="MALAYSIA">MALAYSIA</option>
                            <option value="SINGAPURA">SINGAPURA</option>
                            <option value="THAILAND">THAILAND</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Provinsi</label>

                        <?= $this->Form->select(
                            'patient[id_prov]',
                            $provinces,
                            [
                                'empty' => '-- Pilih Provinsi --',
                                'id' => 'view-id-prov',
                                'class' => 'form-control'
                            ]
                        ) ?>
                    </div>

                    <div class="col-md-4">
                        <label>Kabupaten/Kota</label>

                        <select name="patient[id_kab]" id="view-id-kab" class="form-control">
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Kecamatan</label>

                        <select name="patient[id_kec]" id="view-id-kec" class="form-control">
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Kelurahan</label>

                        <select name="patient[id_kel]" id="view-id-kel" class="form-control">
                            <option value="">-- Pilih Kelurahan --</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Pekerjaan</label>

                        <select id="view-occupation" name="patient[occupation]" class="form-control">
                            <option value="">-- Pilih Pekerjaan --</option>
                            <option value="BELUM / TIDAK BEKERJA">BELUM / TIDAK BEKERJA</option>
                            <option value="PELAJAR / MAHASISWA">PELAJAR / MAHASISWA</option>
                            <option value="PNS">PNS</option>
                            <option value="TNI">TNI</option>
                            <option value="POLRI">POLRI</option>
                            <option value="PEGAWAI SWASTA">PEGAWAI SWASTA</option>
                            <option value="WIRASWASTA">WIRASWASTA</option>
                            <option value="PETANI">PETANI</option>
                            <option value="NELAYAN">NELAYAN</option>
                            <option value="BURUH">BURUH</option>
                            <option value="IBU RUMAH TANGGA">IBU RUMAH TANGGA</option>
                            <option value="PENSIUNAN">PENSIUNAN</option>
                            <option value="LAINNYA">LAINNYA</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Agama</label>

                        <select id="view-religion" name="patient[religion]" class="form-control">
                            <option value="">-- Pilih Agama --</option>
                            <option value="ISLAM">ISLAM</option>
                            <option value="KRISTEN">KRISTEN</option>
                            <option value="KATOLIK">KATOLIK</option>
                            <option value="HINDU">HINDU</option>
                            <option value="BUDDHA">BUDDHA</option>
                            <option value="KONGHUCU">KONGHUCU</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Pendidikan</label>

                        <select id="view-education" name="patient[education]" class="form-control">
                            <option value="">-- Pilih Pendidikan --</option>
                            <option value="TIDAK SEKOLAH">TIDAK SEKOLAH</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA / SMK">SMA / SMK</option>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Suku Bangsa</label>

                        <select id="view-ethnic-group" name="patient[ethnic_group]" class="form-control">
                            <option value="">-- Pilih Suku Bangsa --</option>
                            <option value="JAWA">JAWA</option>
                            <option value="SUNDA">SUNDA</option>
                            <option value="MADURA">MADURA</option>
                            <option value="BATAK">BATAK</option>
                            <option value="BUGIS">BUGIS</option>
                            <option value="DAYAK">DAYAK</option>
                            <option value="BANJAR">BANJAR</option>
                            <option value="MINANG">MINANG</option>
                            <option value="BETAWI">BETAWI</option>
                            <option value="LAINNYA">LAINNYA</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Status Nikah</label>

                        <select id="view-marital-status" name="patient[marital_status]" class="form-control">
                            <option value="">-- Pilih Status Nikah --</option>
                            <option value="BELUM MENIKAH">BELUM MENIKAH</option>
                            <option value="MENIKAH">MENIKAH</option>
                            <option value="CERAI HIDUP">CERAI HIDUP</option>
                            <option value="CERAI MATI">CERAI MATI</option>
                        </select>
                    </div>
                </div>

                <hr>

                <h4>Tujuan Berobat</h4>

                <?php
                echo $this->Form->control('registration_no', [
                    'label' => 'No Registrasi'
                ]);

                echo $this->Form->control('registration_date', [
                    'label' => 'Tanggal Registrasi',
                    'type' => 'date',
                    'value' => date('Y-m-d')
                ]);

                echo $this->Form->control('service_type', [
                    'label' => 'Pelayanan',
                    'type' => 'select',
                    'options' => [
                        'rawat_jalan' => 'Rawat Jalan',
                        'igd' => 'IGD',
                        'rawat_inap' => 'Rawat Inap'
                    ],
                    'empty' => '-- Pilih Pelayanan --'
                ]);

                echo $this->Form->control('doctor_id', [
                    'label' => 'Dokter',
                    'options' => $doctors,
                    'empty' => '-- Pilih Dokter --'
                ]);

                echo $this->Form->control('polyclinic_name', [
                    'label' => 'Poli'
                ]);

                echo $this->Form->control('room_id', [
                    'label' => 'Ruangan',
                    'options' => $rooms,
                    'empty' => '-- Pilih Ruangan --'
                ]);

                echo $this->Form->control('bed_id', [
                    'label' => 'Bed / Kamar',
                    'options' => $beds,
                    'empty' => '-- Pilih Bed --'
                ]);

                echo $this->Form->control('class_name', [
                    'label' => 'Kelas'
                ]);

                echo $this->Form->control('entry_process', [
                    'label' => 'Proses Masuk',
                    'type' => 'select',
                    'options' => [
                        'langsung_rawat_jalan' => 'Langsung Rawat Jalan',
                        'langsung_igd' => 'Langsung IGD',
                        'langsung_rawat_inap' => 'Langsung Rawat Inap'
                    ],
                    'empty' => '-- Pilih Proses Masuk --'
                ]);

                echo $this->Form->control('entry_method', [
                    'label' => 'Cara Masuk',
                    'type' => 'select',
                    'options' => [
                        'datang_sendiri' => 'Datang Sendiri',
                        'rujukan' => 'Rujukan',
                        'puskesmas' => 'Puskesmas',
                        'rs_lain' => 'RS Lain'
                    ],
                    'empty' => '-- Pilih Cara Masuk --'
                ]);
                ?>

                <hr>

                <h4>Cara Bayar</h4>

                <?php
                echo $this->Form->control('payment_method', [
                    'label' => 'Jenis Pasien',
                    'type' => 'select',
                    'options' => [
                        'umum' => 'Umum',
                        'asuransi' => 'Asuransi',
                        'bpjs' => 'BPJS'
                    ],
                    'empty' => '-- Pilih Jenis Pasien --'
                ]);

                echo $this->Form->control('insurance_type', [
                    'label' => 'Jenis Asuransi'
                ]);

                echo $this->Form->control('insurance_card_no', [
                    'label' => 'Nomor Kartu'
                ]);

                echo $this->Form->control('refferal_no', [
                    'label' => 'No Rujukan'
                ]);

                echo $this->Form->control('sep_no', [
                    'label' => 'No SEP'
                ]);

                echo $this->Form->control('treatment_type', [
                    'label' => 'Perawatan',
                    'type' => 'select',
                    'options' => [
                        'biasa' => 'Biasa',
                        'paket' => 'Paket'
                    ],
                    'empty' => '-- Pilih Perawatan --'
                ]);
                ?>

                <hr>

                <h4>Status</h4>

                <?php
                echo $this->Form->control('status', [
                    'type' => 'select',
                    'options' => [
                        'active' => 'Active',
                        'cancel' => 'Cancel',
                        'done' => 'Done'
                    ],
                    'empty' => '-- Pilih Status --'
                ]);

                echo $this->Form->control('is_active', [
                    'label' => 'Aktif',
                    'type' => 'checkbox',
                    'checked' => true
                ]);
                ?>

            </fieldset>

            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>

        </div>
    </div>
</div>

<div class="modal fade" id="modalSearchPatient" tabindex="-1" role="dialog" aria-labelledby="modalSearchPatientLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="modalSearchPatientLabel">Cari Pasien</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="text" id="modal-search-patient" class="form-control"
                    placeholder="Cari No RM / No Identitas / Nama Pasien">

                <br>

                <div id="modal-patient-result"></div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#view-id-prov').on('change', function () {

            let idProv = $(this).val();

            $('#view-id-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
            $('#view-id-kec').html('<option value="">-- Pilih Kecamatan --</option>');
            $('#view-id-kel').html('<option value="">-- Pilih Kelurahan --</option>');

            if (idProv) {

                $.ajax({
                    url: "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getKabupatens']) ?>",
                    type: "GET",
                    dataType: "json",
                    data: {
                        id_prov: idProv
                    },
                    success: function (response) {

                        response.forEach(function (item) {

                            $('#view-id-kab').append(
                                '<option value="' + item.id_kab + '">' + item.nama + '</option>'
                            );
                        });
                    }
                });
            }
        });

        $('#view-id-kab').on('change', function () {

            let idKab = $(this).val();

            $('#view-id-kec').html('<option value="">-- Pilih Kecamatan --</option>');
            $('#view-id-kel').html('<option value="">-- Pilih Kelurahan --</option>');

            if (idKab) {

                $.ajax({
                    url: "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getKecamatans']) ?>",
                    type: "GET",
                    dataType: "json",
                    data: {
                        id_kab: idKab
                    },
                    success: function (response) {

                        response.forEach(function (item) {

                            $('#view-id-kec').append(
                                '<option value="' + item.id_kec + '">' + item.nama + '</option>'
                            );
                        });
                    }
                });
            }
        });

        $('#view-id-kec').on('change', function () {

            let idKec = $(this).val();

            $('#view-id-kel').html('<option value="">-- Pilih Kelurahan --</option>');

            if (idKec) {

                $.ajax({
                    url: "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getKelurahans']) ?>",
                    type: "GET",
                    dataType: "json",
                    data: {
                        id_kec: idKec
                    },
                    success: function (response) {

                        response.forEach(function (item) {

                            $('#view-id-kel').append(
                                '<option value="' + item.id_kel + '">' + item.nama + '</option>'
                            );
                        });
                    }
                });
            }
        });

        $('#modal-search-patient').on('keyup', function () {
            let keyword = $(this).val();

            if (keyword.length < 2) {
                $('#modal-patient-result').html('');
                return;
            }

            $.ajax({
                url: "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'searchPatients']) ?>",
                type: "GET",
                dataType: "json",
                data: {
                    q: keyword
                },
                success: function (response) {
                    let html = '';

                    if (response.length > 0) {
                        html += '<table class="table table-bordered table-striped">';
                        html += '<thead>';
                        html += '<tr>';
                        html += '<th>No RM</th>';
                        html += '<th>Nama Pasien</th>';
                        html += '<th>Identitas</th>';
                        html += '<th>No Identitas</th>';
                        html += '<th>Aksi</th>';
                        html += '</tr>';
                        html += '</thead>';
                        html += '<tbody>';

                        response.forEach(function (patient) {
                            html += '<tr>';
                            html += '<td>' + (patient.code ?? '-') + '</td>';
                            html += '<td>' + (patient.full_name ?? '-') + '</td>';
                            html += '<td>' + (patient.identity_type ?? '-') + '</td>';
                            html += '<td>' + (patient.identity_number ?? '-') + '</td>';
                            html += '<td>';
                            html += '<button type="button" class="btn btn-sm btn-success load-patient" ';

                            html += 'data-id="' + (patient.id ?? '') + '" ';
                            html += 'data-code="' + (patient.code ?? '') + '" ';
                            html += 'data-full-name="' + (patient.full_name ?? '') + '" ';
                            html += 'data-identity-type="' + (patient.identity_type ?? '') + '" ';
                            html += 'data-identity-number="' + (patient.identity_number ?? '') + '" ';
                            html += 'data-gender="' + (patient.gender ?? '') + '" ';
                            html += 'data-blood-type="' + (patient.blood_type ?? '') + '" ';
                            html += 'data-birth-date="' + (patient.birth_date ?? '') + '" ';
                            html += 'data-address="' + (patient.address ?? '') + '" ';
                            html += 'data-father-name="' + (patient.father_name ?? '') + '" ';
                            html += 'data-mother-name="' + (patient.mother_name ?? '') + '" ';
                            html += 'data-phone-number="' + (patient.phone_number ?? '') + '" ';
                            html += 'data-nationality="' + (patient.nationality ?? '') + '" ';
                            html += 'data-citizenship="' + (patient.citizenship ?? '') + '" ';
                            html += 'data-id-prov="' + (patient.id_prov ?? '') + '" ';
                            html += 'data-id-kab="' + (patient.id_kab ?? '') + '" ';
                            html += 'data-id-kec="' + (patient.id_kec ?? '') + '" ';
                            html += 'data-id-kel="' + (patient.id_kel ?? '') + '" ';
                            html += 'data-occupation="' + (patient.occupation ?? '') + '" ';
                            html += 'data-religion="' + (patient.religion ?? '') + '" ';
                            html += 'data-education="' + (patient.education ?? '') + '" ';
                            html += 'data-ethnic-group="' + (patient.ethnic_group ?? '') + '" ';
                            html += 'data-marital-status="' + (patient.marital_status ?? '') + '" ';

                            html += '>Load</button>';
                            html += '</td>';
                            html += '</tr>';
                        });

                        html += '</tbody>';
                        html += '</table>';
                    } else {
                        html = '<div class="alert alert-warning">Pasien tidak ditemukan</div>';
                    }

                    $('#modal-patient-result').html(html);
                },
                error: function () {
                    $('#modal-patient-result').html('<div class="alert alert-danger">Gagal mencari pasien</div>');
                }
            });
        });

        $(document).on('click', '.load-patient', function () {
            $('#patient-id').val($(this).data('id'));

            $('#view-code').val($(this).data('code'));
            $('#view-full-name').val($(this).data('full-name'));
            $('#view-identity-type').val($(this).data('identity-type'));
            $('#view-identity-number').val($(this).data('identity-number'));
            $('#view-gender').val($(this).data('gender'));
            $('#view-blood-type').val($(this).data('blood-type'));
            $('#view-birth-date').val($(this).data('birth-date'));
            $('#view-address').val($(this).data('address'));
            $('#view-father-name').val($(this).data('father-name'));
            $('#view-mother-name').val($(this).data('mother-name'));
            $('#view-phone-number').val($(this).data('phone-number'));
            $('#view-nationality').val($(this).data('nationality'));
            $('#view-citizenship').val($(this).data('citizenship'));
            $('#view-province').val($(this).data('province'));
            $('#view-city').val($(this).data('city'));
            $('#view-district').val($(this).data('district'));
            $('#view-subdistrict').val($(this).data('subdistrict'));
            $('#view-occupation').val($(this).data('occupation'));
            $('#view-religion').val($(this).data('religion'));
            $('#view-education').val($(this).data('education'));
            $('#view-ethnic-group').val($(this).data('ethnic-group'));
            $('#view-marital-status').val($(this).data('marital-status'));

            $('#modalSearchPatient').modal('hide');
            $('#modal-search-patient').val('');
            $('#modal-patient-result').html('');
        });

    });
</script>