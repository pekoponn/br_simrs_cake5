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

                    <div class="col-md-3">
                        <label>Umur</label>
                        <input type="text" id="view-age" class="form-control" readonly>
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
                            $provinces ?? [],
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

                <div class="row">
                    <div class="col-md-4">
                        <label>No Registrasi</label>
                        <input type="text" name="registration_no" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="registration_date" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Jam Masuk</label>
                        <input type="time" name="admission_time" class="form-control" value="<?= date('H:i') ?>">
                    </div>

                    <div class="col-md-12">
                        <label>Pelayanan</label><br>

                        <label style="margin-right:20px;">
                            <input type="radio" name="service_type" value="rawat_jalan" checked>
                            Rawat Jalan
                        </label>

                        <label style="margin-right:20px;">
                            <input type="radio" name="service_type" value="igd">
                            IGD
                        </label>

                        <label>
                            <input type="radio" name="service_type" value="rawat_inap">
                            Rawat Inap
                        </label>
                    </div>

                    <div class="col-md-4 rawat-jalan-field igd-field">
                        <label>Poli / Unit</label>
                        <input type="text" name="polyclinic_name" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Dokter</label>
                        <?= $this->Form->select('doctor_id', $doctors, [
                            'empty' => '-- Pilih Dokter --',
                            'id' => 'doctor-id',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="col-md-4">
                        <label>Jadwal Dokter</label>
                        <select name="doctor_schedule_id" id="doctor-schedule-id" class="form-control">
                            <option value="">-- Pilih Jadwal Dokter --</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Nomor Antri</label>
                        <input type="text" name="queue_number" id="queue-number" class="form-control" readonly>
                        <input type="hidden" name="polyclinic_queue_id" id="polyclinic-queue-id">
                    </div>

                    <div class="col-md-4 rawat-inap-field">
                        <label>Ruangan</label>
                        <?= $this->Form->select('room_id', $rooms, [
                            'empty' => '-- Pilih Ruangan --',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="col-md-4 rawat-inap-field">
                        <label>Bed / Kamar</label>
                        <?= $this->Form->select('bed_id', $beds, [
                            'empty' => '-- Pilih Bed --',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="col-md-4 rawat-inap-field">
                        <label>Kelas</label>
                        <input type="text" name="class_name" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Proses Masuk</label>
                        <select name="entry_process" class="form-control">
                            <option value="">-- Pilih Proses Masuk --</option>
                            <option value="Melalui Unit Rawat Jalan">Melalui Unit Rawat Jalan</option>
                            <option value="Melalui IGD">Melalui IGD</option>
                            <option value="Langsung Rawat Inap">Langsung Rawat Inap</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Cara Masuk</label>
                        <select name="entry_method" class="form-control">
                            <option value="">-- Pilih Cara Masuk --</option>
                            <option value="Datang Sendiri">Datang Sendiri</option>
                            <option value="Puskesmas">Puskesmas</option>
                            <option value="Rujukan RS">Rujukan RS</option>
                        </select>
                    </div>
                </div>

                <hr>

                <h4>Cara Bayar</h4>

                <div class="row" id="payment-section">

                    <div class="col-md-4">
                        <label>Jenis Pasien</label>
                        <select name="payment_method" id="payment-method" class="form-control">
                            <option value="">-- Pilih Jenis Pasien --</option>
                            <option value="UMUM">UMUM</option>
                            <option value="ASURANSI">ASURANSI</option>
                        </select>
                    </div>

                    <div class="col-md-4 insurance-field">
                        <label>Penjamin</label>
                        <select name="insurance_type" id="insurance-type" class="form-control">
                            <option value="">-- Pilih Penjamin --</option>
                            <option value="BPJS KESEHATAN">BPJS KESEHATAN</option>
                            <option value="ASURANSI LAIN">ASURANSI LAIN</option>
                            <option value="MANDIRI INHEALTH">MANDIRI INHEALTH</option>
                            <option value="PRUDENTIAL">PRUDENTIAL</option>
                        </select>
                    </div>

                    <div class="col-md-4 bpjs-field">
                        <label>Kategori Asuransi</label>
                        <select name="insurance_category" id="insurance-category" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="PBI">PBI</option>
                            <option value="NON PBI">NON PBI</option>
                        </select>
                    </div>

                    <div class="col-md-4 insurance-field">
                        <label>Nomor Kartu</label>
                        <input type="text" name="insurance_card_no" id="insurance-card-no" class="form-control">
                    </div>

                    <div class="col-md-4 bpjs-field">
                        <label>No Rujukan/Kontrol</label>
                        <input type="text" name="refferal_no" id="refferal-no" class="form-control">
                    </div>

                    <div class="col-md-4 bpjs-field">
                        <label>SKDP/NO KONTROL</label>
                        <input type="text" name="skdp_no" id="skdp-no" class="form-control">
                    </div>

                    <div class="col-md-4 bpjs-field">
                        <label>Jenis Referensi</label>
                        <select name="reference_type" id="reference-type" class="form-control">
                            <option value="">-- Pilih Jenis Referensi --</option>
                            <option value="RUJUKAN">RUJUKAN</option>
                            <option value="KONTROL">KONTROL</option>
                        </select>
                    </div>

                    <div class="col-md-4 bpjs-field">
                        <label>No SEP</label>
                        <input type="text" name="sep_no" id="sep-no" class="form-control">
                    </div>

                    <div class="col-md-4 bpjs-field">
                        <label>NIK/Bagian</label>
                        <input type="text" name="bpjs_nik" id="bpjs-nik" class="form-control">
                    </div>

                    <div class="col-md-6 bpjs-field">
                        <label>Nama</label>
                        <input type="text" name="bpjs_name" id="bpjs-name" class="form-control">
                    </div>

                    <div class="col-md-3 bpjs-field">
                        <label>Golongan</label>
                        <input type="text" name="bpjs_group" id="bpjs-group" class="form-control">
                    </div>

                    <div class="col-md-3 bpjs-field">
                        <label>Jenis</label>
                        <select name="bpjs_type" id="bpjs-type" class="form-control">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="PESERTA">PESERTA</option>
                            <option value="KELUARGA">KELUARGA</option>
                        </select>
                    </div>

                    <div class="col-md-3 bpjs-field">
                        <label>Kelas</label>
                        <select name="bpjs_class" id="bpjs-class" class="form-control">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="1">KELAS 1</option>
                            <option value="2">KELAS 2</option>
                            <option value="3">KELAS 3</option>
                        </select>
                    </div>

                    <div class="col-md-4 bpjs-field">
                        <label>Provider</label>
                        <input type="text" name="provider" id="provider" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label>Perawatan</label><br>

                        <label style="margin-right:20px;">
                            <input type="radio" name="treatment_type" value="BIASA" checked>
                            Biasa
                        </label>

                        <label>
                            <input type="radio" name="treatment_type" value="PAKET">
                            Paket
                        </label>
                    </div>

                </div>

                <hr>

                <h4>Penanggung Jawab Pasien</h4>

                <div class="row">
                    <div class="col-md-6">
                        <label>Nama</label>
                        <input type="text" name="person_responsible[name]" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Identitas</label>
                        <select name="person_responsible[identity_type]" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="KTP">KTP</option>
                            <option value="SIM">SIM</option>
                            <option value="PASPOR">PASPOR</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>No Identitas</label>
                        <input type="text" name="person_responsible[identity_no]" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Hubungan</label>
                        <select name="person_responsible[relation]" class="form-control">
                            <option value="">-- Pilih Hubungan --</option>
                            <option value="AYAH">AYAH</option>
                            <option value="IBU">IBU</option>
                            <option value="SUAMI">SUAMI</option>
                            <option value="ISTRI">ISTRI</option>
                            <option value="ANAK">ANAK</option>
                            <option value="SAUDARA">SAUDARA</option>
                            <option value="LAINNYA">LAINNYA</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Umur</label>
                        <input type="number" name="person_responsible[age]" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Pekerjaan</label>
                        <input type="text" name="person_responsible[job]" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label>Alamat</label>
                        <textarea name="person_responsible[address]" class="form-control"></textarea>
                    </div>

                    <div class="col-md-4">
                        <label>Telepon</label>
                        <input type="text" name="person_responsible[phone]" class="form-control">
                    </div>
                </div>

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
    $(document).ready(function() {

        $('#view-id-prov').on('change', function() {

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
                    success: function(response) {

                        response.forEach(function(item) {

                            $('#view-id-kab').append(
                                '<option value="' + item.id_kab + '">' + item.nama + '</option>'
                            );
                        });
                    }
                });
            }
        });

        $('#view-id-kab').on('change', function() {

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
                    success: function(response) {

                        response.forEach(function(item) {

                            $('#view-id-kec').append(
                                '<option value="' + item.id_kec + '">' + item.nama + '</option>'
                            );
                        });
                    }
                });
            }
        });

        $('#view-id-kec').on('change', function() {

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
                    success: function(response) {

                        response.forEach(function(item) {

                            $('#view-id-kel').append(
                                '<option value="' + item.id_kel + '">' + item.nama + '</option>'
                            );
                        });
                    }
                });
            }
        });

        $('#modal-search-patient').on('keyup', function() {
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
                success: function(response) {
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

                        response.forEach(function(patient) {
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
                error: function() {
                    $('#modal-patient-result').html('<div class="alert alert-danger">Gagal mencari pasien</div>');
                }
            });
        });

        $(document).on('click', '.load-patient', function() {
            $('#patient-id').val($(this).data('id'));

            $('#view-code').val($(this).data('code'));
            $('#view-full-name').val($(this).data('full-name'));
            $('#view-identity-type').val($(this).data('identity-type'));
            $('#view-identity-number').val($(this).data('identity-number'));
            $('#view-gender').val($(this).data('gender'));
            $('#view-blood-type').val($(this).data('blood-type'));
            $('#view-birth-date').val($(this).data('birth-date'));
            $('#view-age').val(calculateAge($(this).data('birth-date')));
            $('#view-address').val($(this).data('address'));
            $('#view-father-name').val($(this).data('father-name'));
            $('#view-mother-name').val($(this).data('mother-name'));
            $('#view-phone-number').val($(this).data('phone-number'));
            $('#view-nationality').val($(this).data('nationality'));
            $('#view-citizenship').val($(this).data('citizenship'));
            let idProv = $(this).data('id-prov');
            let idKab = $(this).data('id-kab');
            let idKec = $(this).data('id-kec');
            let idKel = $(this).data('id-kel');

            $('#view-id-prov').val(idProv).trigger('change');

            setTimeout(function() {
                $('#view-id-kab').val(idKab).trigger('change');

                setTimeout(function() {
                    $('#view-id-kec').val(idKec).trigger('change');

                    setTimeout(function() {
                        $('#view-id-kel').val(idKel);
                    }, 500);

                }, 500);

            }, 500);
            $('#view-occupation').val($(this).data('occupation'));
            $('#view-religion').val($(this).data('religion'));
            $('#view-education').val($(this).data('education'));
            $('#view-ethnic-group').val($(this).data('ethnic-group'));
            $('#view-marital-status').val($(this).data('marital-status'));

            $('#modalSearchPatient').modal('hide');
            $('#modal-search-patient').val('');
            $('#modal-patient-result').html('');
        });

        function calculateAge(birthDate) {
            if (!birthDate) {
                return '';
            }

            let today = new Date();
            let birth = new Date(birthDate);

            let years = today.getFullYear() - birth.getFullYear();
            let months = today.getMonth() - birth.getMonth();
            let days = today.getDate() - birth.getDate();

            if (days < 0) {
                months--;
                let previousMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                days += previousMonth.getDate();
            }

            if (months < 0) {
                years--;
                months += 12;
            }

            return years + ' tahun ' + months + ' bulan ' + days + ' hari';
        }

        $('#view-birth-date').on('change', function() {
            $('#view-age').val(calculateAge($(this).val()));
        });

        function clearInsuranceFields() {
            $('#insurance-type').val('');
            $('#insurance-category').val('');
            $('#insurance-card-no').val('');
            $('#refferal-no').val('');
            $('#skdp-no').val('');
            $('#reference-type').val('');
            $('#sep-no').val('');
            $('#bpjs-nik').val('');
            $('#bpjs-name').val('');
            $('#bpjs-group').val('');
            $('#bpjs-type').val('');
            $('#bpjs-class').val('');
            $('#provider').val('');
        }

        function clearBpjsFields() {
            $('#insurance-category').val('');
            $('#refferal-no').val('');
            $('#skdp-no').val('');
            $('#reference-type').val('');
            $('#sep-no').val('');
            $('#bpjs-nik').val('');
            $('#bpjs-name').val('');
            $('#bpjs-group').val('');
            $('#bpjs-type').val('');
            $('#bpjs-class').val('');
            $('#provider').val('');
        }

        $('#payment-method').on('change', function() {
            let paymentMethod = $(this).val();

            clearInsuranceFields();

            if (paymentMethod === 'UMUM') {
                $('.insurance-field').hide();
                $('.bpjs-field').hide();
            } else if (paymentMethod === 'ASURANSI') {
                $('.insurance-field').show();
                $('.bpjs-field').hide();
            } else {
                $('.insurance-field').show();
                $('.bpjs-field').show();
            }
        });

        $('#insurance-type').on('change', function() {
            let insuranceType = $(this).val();

            clearBpjsFields();

            if (insuranceType === 'BPJS KESEHATAN') {
                $('.bpjs-field').show();
            } else {
                $('.bpjs-field').hide();
            }
        });

        $('#service-type').change(function() {

            let value = $(this).val();

            $('#general-fields').hide();
            $('#rawat-inap-fields').hide();

            if (value == "rawat_jalan" || value == "igd") {
                $('#general-fields').show();
            }

            if (value == "rawat_inap") {
                $('#general-fields').show();
                $('#rawat-inap-fields').show();
            }
        });

        // FIXED: AJAX bed class sekarang pakai action 'getBedClass' yang sudah diperbaiki di controller
        $('#bed-id').change(function() {

            let bedId = $(this).val();

            $('#class-name').val('');

            if (bedId) {

                $.ajax({
                    url: "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getBedClass']) ?>",
                    type: "GET",
                    data: {
                        bed_id: bedId
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#class-name').val(response.class_name ?? '');
                    },
                    error: function() {
                        $('#class-name').val('');
                    }
                });
            }
        });

        function setServiceForm(serviceType) {
            $('.rawat-inap-field').hide();

            if (serviceType === 'rawat_inap') {
                $('.rawat-inap-field').show();
            }
        }

        setServiceForm('rawat_jalan');

        $('input[name="service_type"]').on('change', function() {
            setServiceForm($(this).val());
        });

        $('#doctor-id').on('change', function() {
            let doctorId = $(this).val();

            $('#doctor-schedule-id').html('<option value="">-- Pilih Jadwal Dokter --</option>');

            if (doctorId) {
                $.ajax({
                    url: "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getDoctorSchedules']) ?>",
                    type: "GET",
                    dataType: "json",
                    data: {
                        doctor_id: doctorId
                    },
                    success: function(response) {
                        console.log(response);

                        response.forEach(function(item) {
                            $('#doctor-schedule-id').append(
                                '<option value="' + item.id + '">' +
                                item.day + ' | ' + item.start_time + ' - ' + item.end_time +
                                '</option>'
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });

    });
</script>