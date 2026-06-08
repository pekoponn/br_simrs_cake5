<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 * @var array $doctors
 * @var array $rooms
 * @var array $beds
 * @var array $provinces
 * @var string $registrationNo
 * @var bool $fromQueue
 * @var int|null $queueId
 * @var int|null $queueNumber
 * @var string|null $queueCode
 * @var string|null $polyclinicName
 */
?>

<style>
    body {
        background: #eef2f7;
    }

    .registrations-wrapper {
        width: 100%;
        max-width: none;
        margin: 0 auto;
        /* padding: 10px 36px 30px; */
    }

    .registrations.form.content {
        background: transparent;
        margin-left: 0;
        padding: 0;
    }

    .form-card {
        background: #fff;
        border: 1px solid #dfe6ee;
        border-radius: 10px;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: 0.2s;
    }

    .form-card:hover {
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
    }

    .form-card-header {
        padding: 14px 18px;
        border-bottom: 1px solid #edf1f5;
        font-size: 16px;
        font-weight: 600;
        background: #fafbfd;
        color: #2f3542;
    }

    .form-card-header i {
        margin-right: 8px;
        color: #5c6bc0;
    }

    .form-card-body {
        padding: 20px;
    }

    .form-card-body .row>div {
        margin-bottom: 14px;
    }

    .form-card-body label {
        font-weight: 600;
        font-size: 12px;
        margin-bottom: 5px;
        color: #57606f;
        display: block;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ced6e0;
        height: 38px;
        font-size: 13px;
        box-shadow: none;
    }

    textarea.form-control {
        height: auto;
    }

    .form-control:focus {
        border-color: #5c6bc0;
        box-shadow: 0 0 0 2px rgba(92, 107, 192, 0.1);
    }

    .submit-card {
        background: #fff;
        border: 1px solid #dfe6ee;
        border-radius: 10px;
        padding: 18px 22px;
        text-align: right;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .queue-info-box {
        background: #fff;
        border: 1px solid #dfe6ee;
        border-radius: 10px;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .queue-info-header {
        padding: 14px 18px;
        border-bottom: 1px solid #edf1f5;
        font-size: 16px;
        font-weight: 600;
        background: #fafbfd;
    }

    .queue-info-body {
        padding: 18px 20px;
    }

    .queue-handoff-note {
        margin-top: 10px;
        padding: 10px 12px;
        border-left: 4px solid #28a745;
        background: #eefaf2;
        color: #27643a;
        font-size: 13px;
        font-weight: 600;
    }

    fieldset legend {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2f3542;
    }

    .btn-primary {
        border-radius: 6px;
        padding: 8px 18px;
        font-size: 13px;
        font-weight: 600;
    }

    .side-nav {
        display: none;
    }
</style>

<div class="registrations-wrapper">
    <div class="registrations form content">

            <?php if ($fromQueue): ?>
                <div class="queue-info-box">
                    <div class="queue-info-header">
                        <i class="fa fa-exchange"></i> Antrian Siap Menjadi Registrasi
                    </div>

                    <div class="queue-info-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label style="font-size:12px;margin-bottom:3px;">Kode Antrian</label>
                                <input type="text" class="form-control" value="<?= h($queueCode) ?>" readonly
                                    style="height:34px;font-size:13px;background:#f1f3f5;">
                            </div>

                            <div class="col-md-4">
                                <label style="font-size:12px;margin-bottom:3px;">Sumber Poli</label>
                                <input type="text" class="form-control" value="<?= h($polyclinicName) ?>" readonly
                                    style="height:34px;font-size:13px;background:#f1f3f5;">
                            </div>

                            <div class="col-md-3">
                                <label style="font-size:12px;margin-bottom:3px;">No Antrian</label>
                                <input type="text" class="form-control" value="<?= h($queueNumber) ?>" readonly
                                    style="height:34px;font-size:13px;background:#f1f3f5;">
                            </div>
                        </div>
                        <div class="queue-handoff-note">
                            Setelah registrasi berhasil disimpan, antrian ini otomatis ditandai tidak aktif dan terhubung ke nomor registrasi baru.
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?= $this->Form->create($registration) ?>

            <fieldset>
                <legend><?= __('Pendaftaran Pasien') ?></legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fa fa-user"></i> Data Pasien
                            </div>

                            <div class="form-card-body">
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
                                        <label>Kode Pasien</label>
                                        <input type="text" id="view-patient-code" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Identitas</label>
                                        <select id="view-identity-type" name="patient[identity_type]" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis Identitas --</option>
                                            <option value="KTP">KTP</option>
                                            <option value="SIM">SIM</option>
                                            <option value="PASPOR">PASPOR</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>No Identitas</label>
                                        <input type="text" id="view-identity-number" name="patient[identity_number]" class="form-control"
                                            value="<?= h($this->request->getData('patient.identity_number') ?? ($queueIdentityNumber ?? '')) ?>">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Gelar</label>
                                        <select id="view-patient-title" name="patient_title" class="form-control select2Form">
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
                                        <input type="text" id="view-full-name" name="patient[full_name]" class="form-control"
                                            value="<?= h($this->request->getData('patient.full_name') ?? ($queuePatientName ?? '')) ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Jenis Kelamin</label>
                                        <select id="view-gender" name="patient[gender]" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="Male">Laki-laki</option>
                                            <option value="Female">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Gol Darah</label>
                                        <select id="view-blood-type" name="patient[blood_type]" class="form-control select2Form">
                                            <option value="">-- Pilih Golongan Darah --</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Tanggal Lahir</label>
                                        <input type="text" id="view-birth-date" name="patient[birth_date]" class="form-control datepicker-autoclose" autocomplete="off">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Umur</label>
                                        <input type="text" id="view-age" name="patient[age]" class="form-control" readonly>
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
                                        <input type="text" id="view-phone-number" name="patient[phone_number]" class="form-control"
                                            value="<?= h($this->request->getData('patient.phone_number') ?? ($queuePhoneNumber ?? '')) ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kewarganegaraan</label>
                                        <select id="view-citizenship" name="patient[citizenship]" class="form-control select2Form">
                                            <option value="">-- Pilih Kewarganegaraan --</option>
                                            <option value="WNI">WNI</option>
                                            <option value="WNA">WNA</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Negara</label>
                                        <select id="view-nationality" name="patient[nationality]" class="form-control select2Form">
                                            <option value="">-- Pilih Negara --</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="INDONESIA">INDONESIA</option>
                                            <option value="Lainnya">Lainnya</option>
                                            <option value="MALAYSIA">MALAYSIA</option>
                                            <option value="SINGAPURA">SINGAPURA</option>
                                            <option value="THAILAND">THAILAND</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Provinsi</label>
                                        <select id="ui-prov" class="form-control select2Form">
                                            <option value="">-- Pilih Provinsi --</option>
                                            <?php foreach ($provinces as $prov): ?>
                                                <option value="<?= h($prov['id_prov']) ?>"><?= h($prov['nama']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="patient[id_prov]" id="hidden-province">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kabupaten/Kota</label>
                                        <select id="ui-kab" class="form-control select2Form" disabled>
                                            <option value="">-- Pilih Kabupaten/Kota --</option>
                                        </select>
                                        <input type="hidden" name="patient[id_kab]" id="hidden-city">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kecamatan</label>
                                        <select id="ui-kec" class="form-control select2Form" disabled>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                        <input type="hidden" name="patient[id_kec]" id="hidden-district">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kelurahan</label>
                                        <select id="ui-kel" class="form-control select2Form" disabled>
                                            <option value="">-- Pilih Kelurahan --</option>
                                        </select>
                                        <input type="hidden" name="patient[id_kel]" id="hidden-subdistrict">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Pekerjaan</label>
                                        <select id="view-occupation" name="patient[occupation]" class="form-control select2Form">
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
                                        <select id="view-religion" name="patient[religion]" class="form-control select2Form">
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
                                        <select id="view-education" name="patient[education]" class="form-control select2Form">
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
                                        <select id="view-ethnic-group" name="patient[ethnic_group]" class="form-control select2Form">
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
                                        <select id="view-marital-status" name="patient[marital_status]" class="form-control select2Form">
                                            <option value="">-- Pilih Status Nikah --</option>
                                            <option value="BELUM MENIKAH">BELUM MENIKAH</option>
                                            <option value="MENIKAH">MENIKAH</option>
                                            <option value="CERAI HIDUP">CERAI HIDUP</option>
                                            <option value="CERAI MATI">CERAI MATI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fa fa-users"></i> Penanggung Jawab Pasien
                            </div>

                            <div class="form-card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nama</label>
                                        <input type="text" name="person_responsible[name]" class="form-control">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Identitas</label>
                                        <select name="person_responsible[identity_type]" class="form-control select2Form">
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
                                        <select name="person_responsible[relation]" class="form-control select2Form">
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
                                        <select name="person_responsible[job]" class="form-control select2Form">
                                            <option value="">-- Pilih Pekerjaan --</option>
                                            <?php foreach ($this->Krs->occupations() as $value => $label): ?>
                                                <option value="<?= h($value) ?>"><?= h($label) ?></option>
                                            <?php endforeach; ?>
                                        </select>
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
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fa fa-hospital-o"></i> Tujuan Berobat
                            </div>

                            <div class="form-card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>
                                            No Registrasi
                                            <?php if ($fromQueue): ?>
                                                <small style="color:#888;">(otomatis)</small>
                                            <?php endif; ?>
                                        </label>
                                        <input type="text" name="registration_no" id="registration-no"
                                            class="form-control"
                                            value="<?= h($registrationNo ?? '') ?>"
                                            readonly
                                            style="background-color:#e9ecef; color:#6c757d; cursor:not-allowed;">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Tanggal Masuk</label>
                                        <input type="text" name="registration_date" class="form-control datepicker-autoclose" autocomplete="off"
                                            value="<?= date('Y-m-d') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Jam Masuk</label>
                                        <input type="time" name="admission_time" id="admission-time" class="form-control" autocomplete="off" step="60" onclick="if (this.showPicker) this.showPicker();" onfocus="if (this.showPicker) this.showPicker();"
                                            value="<?= date('H:i') ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label>Pelayanan</label><br>
                                        <label style="margin-right:20px;">
                                            <input type="radio" name="service_type" value="rawat_jalan" checked> Rawat Jalan
                                        </label>
                                        <label style="margin-right:20px;">
                                            <input type="radio" name="service_type" value="igd"> IGD
                                        </label>
                                        <label>
                                            <input type="radio" name="service_type" value="rawat_inap"> Rawat Inap
                                        </label>
                                    </div>

                                    <div class="col-md-4 rawat-jalan-field igd-field">
                                        <label>
                                            Poli / Unit
                                            <?php if ($fromQueue): ?>
                                                <small style="color:#888;">(dari antrian)</small>
                                            <?php endif; ?>
                                        </label>

                                        <?php if ($fromQueue): ?>

                                            <input type="text"
                                                name="polyclinic_name"
                                                id="polyclinic-name"
                                                class="form-control"
                                                value="<?= h($polyclinicName ?? '') ?>"
                                                readonly
                                                style="background-color:#e9ecef; color:#6c757d; cursor:not-allowed;">

                                        <?php else: ?>

                                            <?= $this->Form->select(
                                                'polyclinic_name',
                                                $this->Krs->polyclinics(),
                                                [
                                                    'empty' => '-- Pilih Poli / Unit --',
                                                    'id' => 'polyclinic-name',
                                                    'class' => 'form-control select2Form'
                                                ]
                                            ) ?>

                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label>
                                            Nomor Antri
                                            <?php if ($fromQueue): ?>
                                                <small style="color:#888;">(dari antrian)</small>
                                            <?php endif; ?>
                                        </label>
                                        <input type="text" name="queue_number" id="queue-number"
                                            class="form-control"
                                            value="<?= h($queueNumber ?? '') ?>"
                                            readonly
                                            style="background-color:#e9ecef; color:#6c757d; cursor:not-allowed;">
                                        <?php if ($fromQueue): ?>
                                            <input type="hidden" name="polyclinic_queue_id" value="<?= h($queueId) ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Dokter</label>
                                        <?= $this->Form->select('doctor_id', $doctors ?? [], [
                                            'empty' => '-- Pilih Dokter --',
                                            'id'    => 'doctor-id',
                                            'class' => 'form-control select2Form'
                                        ]) ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Jadwal Dokter</label>
                                        <select name="doctor_schedule_id" id="doctor-schedule-id" class="form-control select2Form">
                                            <option value="">-- Pilih Jadwal Dokter --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 rawat-inap-field" style="display:none;">
                                        <label>Ruangan</label>
                                        <?= $this->Form->select('room_id', $rooms ?? [], [
                                            'empty' => '-- Pilih Ruangan --',
                                            'id'    => 'room-id',
                                            'class' => 'form-control select2Form'
                                        ]) ?>
                                    </div>

                                    <div class="col-md-4 rawat-inap-field" style="display:none;">
                                        <label>
                                            Bed / Kamar
                                            <span id="bed-loading" style="display:none; font-size:12px; color:#888;"> &#8635; Memuat...</span>
                                        </label>
                                        <select name="bed_id" id="bed-id" class="form-control select2Form" disabled>
                                            <option value="">-- Pilih Ruangan Dulu --</option>
                                        </select>
                                        <small id="bed-info" style="color:#888;"></small>
                                    </div>

                                    <div class="col-md-4 rawat-inap-field" style="display:none;">
                                        <label>Kelas</label>
                                        <input type="text" name="class_name" id="class-name" class="form-control" readonly
                                            placeholder="Otomatis terisi saat pilih bed">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Proses Masuk</label>
                                        <select name="entry_process" class="form-control select2Form">
                                            <option value="">-- Pilih Proses Masuk --</option>
                                            <option value="Melalui Unit Rawat Jalan">Melalui Unit Rawat Jalan</option>
                                            <option value="Melalui IGD">Melalui IGD</option>
                                            <option value="Langsung Rawat Inap">Langsung Rawat Inap</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Cara Masuk</label>
                                        <select name="entry_method" class="form-control select2Form">
                                            <option value="">-- Pilih Cara Masuk --</option>
                                            <option value="Datang Sendiri">Datang Sendiri</option>
                                            <option value="Puskesmas">Puskesmas</option>
                                            <option value="Rujukan RS">Rujukan RS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fa fa-credit-card"></i> Cara Bayar
                            </div>

                            <div class="form-card-body">
                                <div class="row" id="payment-section">
                                    <div class="col-md-4">
                                        <label>Jenis Pasien</label>
                                        <?php
                                        $selectedPaymentMethod = $this->request->getData('payment_method')
                                            ?? (($queueSource ?? '') === 'Mobile JKN' ? 'ASURANSI' : '');
                                        ?>
                                        <select name="payment_method" id="payment-method" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis Pasien --</option>
                                            <option value="UMUM" <?= $selectedPaymentMethod === 'UMUM' ? 'selected' : '' ?>>UMUM</option>
                                            <option value="ASURANSI" <?= $selectedPaymentMethod === 'ASURANSI' ? 'selected' : '' ?>>ASURANSI</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 insurance-field" style="display:none;">
                                        <label>Penjamin</label>
                                        <?php
                                        $selectedInsuranceType = $this->request->getData('insurance_type')
                                            ?? (($queueSource ?? '') === 'Mobile JKN' ? 'BPJS KESEHATAN' : '');
                                        ?>
                                        <select name="insurance_type" id="insurance-type" class="form-control select2Form">
                                            <option value="">-- Pilih Penjamin --</option>
                                            <option value="BPJS KESEHATAN" <?= $selectedInsuranceType === 'BPJS KESEHATAN' ? 'selected' : '' ?>>BPJS KESEHATAN</option>
                                            <option value="ASURANSI LAIN" <?= $selectedInsuranceType === 'ASURANSI LAIN' ? 'selected' : '' ?>>ASURANSI LAIN</option>
                                            <option value="MANDIRI INHEALTH" <?= $selectedInsuranceType === 'MANDIRI INHEALTH' ? 'selected' : '' ?>>MANDIRI INHEALTH</option>
                                            <option value="PRUDENTIAL" <?= $selectedInsuranceType === 'PRUDENTIAL' ? 'selected' : '' ?>>PRUDENTIAL</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label>Kategori Asuransi</label>
                                        <select name="insurance_category" id="insurance-category" class="form-control select2Form">
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="PBI">PBI</option>
                                            <option value="NON PBI">NON PBI</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 insurance-field" style="display:none;">
                                        <label>Nomor Kartu</label>
                                        <input type="text" name="insurance_card_no" id="insurance-card-no" class="form-control"
                                            value="<?= h($this->request->getData('insurance_card_no') ?? ($queueBpjsNumber ?? '')) ?>">
                                    </div>

                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label>No Rujukan/Kontrol</label>
                                        <input type="text" name="refferal_no" id="refferal-no" class="form-control">
                                    </div>

                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label>SKDP/NO KONTROL</label>
                                        <input type="text" name="skdp_no" id="skdp-no" class="form-control">
                                    </div>

                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label>Jenis Referensi</label>
                                        <select name="reference_type" id="reference-type" class="form-control">
                                            <option value="">-- Pilih Jenis Referensi --</option>
                                            <option value="RUJUKAN">RUJUKAN</option>
                                            <option value="KONTROL">KONTROL</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label>No SEP</label>
                                        <input type="text" name="sep_no" id="sep-no" class="form-control">
                                    </div>

                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label>NIK/Bagian</label>
                                        <input type="text" name="bpjs_nik" id="bpjs-nik" class="form-control"
                                            value="<?= h($this->request->getData('bpjs_nik') ?? ($queueIdentityNumber ?? '')) ?>">
                                    </div>

                                    <div class="col-md-6 bpjs-field" style="display:none;">
                                        <label>Nama</label>
                                        <input type="text" name="bpjs_name" id="bpjs-name" class="form-control"
                                            value="<?= h($this->request->getData('bpjs_name') ?? ($queuePatientName ?? '')) ?>">
                                    </div>

                                    <div class="col-md-3 bpjs-field" style="display:none;">
                                        <label>Golongan</label>
                                        <input type="text" name="bpjs_group" id="bpjs-group" class="form-control">
                                    </div>

                                    <div class="col-md-3 bpjs-field" style="display:none;">
                                        <label>Jenis</label>
                                        <select name="bpjs_type" id="bpjs-type" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="PESERTA">PESERTA</option>
                                            <option value="KELUARGA">KELUARGA</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 bpjs-field" style="display:none;">
                                        <label>Kelas</label>
                                        <select name="bpjs_class" id="bpjs-class" class="form-control select2Form">
                                            <option value="">-- Pilih Kelas --</option>
                                            <option value="1">KELAS 1</option>
                                            <option value="2">KELAS 2</option>
                                            <option value="3">KELAS 3</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label>Provider</label>
                                        <input type="text" name="provider" id="provider" class="form-control">
                                    </div>

                                    <div class="col-md-12">
                                        <label>Perawatan</label><br>
                                        <label style="margin-right:20px;">
                                            <input type="radio" name="treatment_type" value="BIASA" checked> Biasa
                                        </label>
                                        <label>
                                            <input type="radio" name="treatment_type" value="PAKET"> Paket
                                        </label>
                                    </div>

                                    <div class="col-md-12 text-right" style="margin-top:10px;">
                                        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fa fa-clipboard"></i> Perujuk Pasien
                            </div>

                            <div class="form-card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Rujukan</label><br>
                                        <label style="margin-right:20px;">
                                            <input type="radio" name="referral_type" value="Intern"> Intern
                                        </label>
                                        <label style="margin-right:20px;">
                                            <input type="radio" name="referral_type" value="Extern"> Extern
                                        </label>
                                        <label>
                                            <input type="radio" name="referral_type" value="None" checked> None
                                        </label>
                                    </div>

                                    <div class="col-md-4 referral-field" style="display:none;">
                                        <label>Dokter Pengirim</label>
                                        <input type="text" name="referral_doctor" id="referral-doctor"
                                            class="form-control"
                                            placeholder="Nama dokter pengirim">
                                    </div>

                                    <div class="col-md-4 referral-field" style="display:none;">
                                        <label>Asal Rujuk</label>
                                        <input type="text" name="referral_origin" id="referral-origin"
                                            class="form-control"
                                            placeholder="RS / Klinik / Puskesmas asal">
                                    </div>

                                    <div class="col-md-4 referral-field" style="display:none;">
                                        <label>Nama Perujuk</label>
                                        <input type="text" name="referral_name" id="referral-name"
                                            class="form-control"
                                            placeholder="Nama perujuk">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>

            <div class="submit-card">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?= $this->Form->end() ?>

    </div>
</div>

<!-- Modal Cari Pasien -->
<div class="modal fade" id="modalSearchPatient" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cari Pasien</h4>
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
        if ($.fn.select2) {
            $('.select2Form, .select2form').select2({
                width: '100%'
            });
        }

        function normalizeSelectValue(value) {
            return String(value || '')
                .toLowerCase()
                .replace(/[^a-z0-9]/g, '');
        }

        function setSelectValue(selector, value) {
            var $select = $(selector);
            var rawValue = value || '';

            if (!rawValue) {
                $select.val('').trigger('change');
                return;
            }

            $select.val(rawValue);

            if ($select.val() === null) {
                var normalizedValue = normalizeSelectValue(rawValue);
                var matchedValue = '';

                $select.find('option').each(function() {
                    var optionValue = $(this).attr('value');
                    var optionText = $(this).text();

                    if (
                        normalizeSelectValue(optionValue) === normalizedValue ||
                        normalizeSelectValue(optionText) === normalizedValue
                    ) {
                        matchedValue = optionValue;
                        return false;
                    }
                });

                if (matchedValue !== '') {
                    $select.val(matchedValue);
                } else {
                    $select.append(
                        $('<option>', {
                            value: rawValue,
                            text: rawValue
                        })
                    );
                    $select.val(rawValue);
                }
            }

            $select.trigger('change');
        }

        function normalizePatientTitle(title) {
            var titles = {
                tn: 'Tn',
                ny: 'Ny',
                nn: 'Nn',
                an: 'An',
                by: 'By'
            };
            var key = String(title || '').replace('.', '').toLowerCase();
            return titles[key] || '';
        }

        function getPatientTitle(patient) {
            if (patient.title) {
                return normalizePatientTitle(patient.title);
            }

            var matches = /^(Tn|Ny|Nn|An|By)\.?\b/i.exec(patient.full_name || '');
            return matches ? normalizePatientTitle(matches[1]) : '';
        }

        // ── Provinsi → Kabupaten ──────────────────────────────────────────────────
        $('#ui-prov').on('change', function() {
            var selectedText = $(this).find('option:selected').text();
            var idProv = $(this).val();

            $('#hidden-province').val(selectedText !== '-- Pilih Provinsi --' ? selectedText : '');

            $('#ui-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);
            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-city').val('');
            $('#hidden-district').val('');
            $('#hidden-subdistrict').val('');

            if (!idProv) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getKabupatens']) ?>", {
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

            $('#hidden-city').val(idKab ? selectedText : '');

            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-district').val('');
            $('#hidden-subdistrict').val('');

            if (!idKab) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getKecamatans']) ?>", {
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

            $('#hidden-district').val(idKec ? selectedText : '');

            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-subdistrict').val('');

            if (!idKec) return;

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getKelurahans']) ?>", {
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
            $('#hidden-subdistrict').val(idKel ? selectedText : '');
        });

        // ── Search Pasien di Modal ────────────────────────────────────────────────
        var searchTimer;
        $('#modal-search-patient').on('keyup', function() {
            clearTimeout(searchTimer);
            var keyword = $(this).val();

            if (keyword.length < 2) {
                $('#modal-patient-result').html('');
                return;
            }

            searchTimer = setTimeout(function() {
                $.getJSON(
                    "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'searchPatients']) ?>", {
                        q: keyword
                    },
                    function(response) {
                        var html = '';
                        if (response.length > 0) {
                            html += '<table class="table table-bordered table-striped table-sm">';
                            html += '<thead><tr><th>No RM</th><th>Kode Pasien</th><th>Nama</th><th>Identitas</th><th>No Identitas</th><th></th></tr></thead><tbody>';
                            response.forEach(function(p) {
                                p.title = getPatientTitle(p);

                                html += '<tr>';
                                html += '<td>' + (p.medical_record_no || p.code || '-') + '</td>';
                                html += '<td>' + (p.code || '-') + '</td>';
                                html += '<td>' + (p.full_name || '-') + '</td>';
                                html += '<td>' + (p.identity_type || '-') + '</td>';
                                html += '<td>' + (p.identity_number || '-') + '</td>';
                                html += '<td><button type="button" class="btn btn-sm btn-success load-patient"';
                                var fields = ['id', 'code', 'medical_record_no', 'title', 'full_name', 'identity_type', 'identity_number', 'gender',
                                    'blood_type', 'birth_date', 'address', 'father_name', 'mother_name',
                                    'phone_number', 'nationality', 'citizenship',
                                    'id_prov', 'id_kab', 'id_kec', 'id_kel',
                                    'occupation', 'religion', 'education', 'ethnic_group', 'marital_status'
                                ];
                                fields.forEach(function(f) {
                                    html += ' data-' + f.replace(/_/g, '-') + '="' + (p[f] || '') + '"';
                                });
                                html += '>Pilih</button></td></tr>';
                            });
                            html += '</tbody></table>';
                        } else {
                            html = '<div class="alert alert-warning">Pasien tidak ditemukan</div>';
                        }
                        $('#modal-patient-result').html(html);
                    }
                ).fail(function() {
                    $('#modal-patient-result').html('<div class="alert alert-danger">Gagal mencari pasien</div>');
                });
            }, 300);
        });

        // ── Load Data Pasien ke Form ──────────────────────────────────────────────
        $(document).on('click', '.load-patient', function() {
            var $btn = $(this);

            $('#patient-id').val($btn.data('id'));
            $('#view-code').val($btn.data('medical-record-no') || $btn.data('code'));
            $('#view-patient-code').val($btn.data('code') || '');
            $('#view-full-name').val($btn.data('full-name'));
            setSelectValue('#view-patient-title', $btn.data('title'));
            setSelectValue('#view-identity-type', $btn.data('identity-type'));
            $('#view-identity-number').val($btn.data('identity-number'));
            setSelectValue('#view-gender', $btn.data('gender'));
            setSelectValue('#view-blood-type', $btn.data('blood-type'));
            $('#view-birth-date').val($btn.data('birth-date'));
            $('#view-age').val(calculateAge($btn.data('birth-date')));
            $('#view-address').val($btn.data('address'));
            $('#view-father-name').val($btn.data('father-name'));
            $('#view-mother-name').val($btn.data('mother-name'));
            $('#view-phone-number').val($btn.data('phone-number'));
            setSelectValue('#view-nationality', $btn.data('nationality'));
            setSelectValue('#view-citizenship', $btn.data('citizenship'));
            setSelectValue('#view-occupation', $btn.data('occupation'));
            setSelectValue('#view-religion', $btn.data('religion'));
            setSelectValue('#view-education', $btn.data('education'));
            setSelectValue('#view-ethnic-group', $btn.data('ethnic-group'));
            setSelectValue('#view-marital-status', $btn.data('marital-status'));

            var idProv = $btn.data('id-prov') || '';
            var idKab = $btn.data('id-kab') || '';
            var idKec = $btn.data('id-kec') || '';
            var idKel = $btn.data('id-kel') || '';

            $('#hidden-province').val(idProv);
            $('#hidden-city').val(idKab);
            $('#hidden-district').val(idKec);
            $('#hidden-subdistrict').val(idKel);

            // kalau data lama berupa nama wilayah
            if (isNaN(idProv)) {

                $('#ui-prov')
                    .html('<option value="' + idProv + '">' + idProv + '</option>')
                    .prop('disabled', false)
                    .trigger('change.select2');

                $('#ui-kab')
                    .html('<option value="' + idKab + '">' + idKab + '</option>')
                    .prop('disabled', false)
                    .trigger('change.select2');

                $('#ui-kec')
                    .html('<option value="' + idKec + '">' + idKec + '</option>')
                    .prop('disabled', false)
                    .trigger('change.select2');

                $('#ui-kel')
                    .html('<option value="' + idKel + '">' + idKel + '</option>')
                    .prop('disabled', false)
                    .trigger('change.select2');

            } else {

                // kalau data berupa kode wilayah
                $('#ui-prov').one('kabupaten:loaded', function() {
                    $('#ui-kab').one('kecamatan:loaded', function() {
                        $('#ui-kec').one('kelurahan:loaded', function() {
                            setSelectValue('#ui-kel', idKel);
                        });

                        setSelectValue('#ui-kec', idKec);
                    });

                    setSelectValue('#ui-kab', idKab);
                });

                setSelectValue('#ui-prov', idProv);
            }

            $('#modalSearchPatient').modal('hide');
            $('#modal-search-patient').val('');
            $('#modal-patient-result').html('');
        });

        // ── Hitung Umur ──────────────────────────────────────────────────────────
        function calculateAge(birthDate) {
            if (!birthDate) return '';
            var today = new Date(),
                birth = new Date(birthDate);
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
            return years + ' tahun ' + months + ' bulan ' + days + ' hari';
        }

        $('.datepicker-autoclose').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $('#view-birth-date').on('change changeDate', function() {
            $('#view-age').val(calculateAge($(this).val()));
        });

        // ── Toggle Pelayanan ──────────────────────────────────────────────────────
        function setServiceForm(type) {
            if (type === 'rawat_inap') {
                $('.rawat-inap-field').show();
            } else {
                $('.rawat-inap-field').hide();
                $('#room-id').val('');
                resetBedDropdown();
                $('#class-name').val('');
            }
        }
        setServiceForm('rawat_jalan');
        $('input[name="service_type"]').on('change', function() {
            setServiceForm($(this).val());
        });

        // ── Reset dropdown bed ────────────────────────────────────────────────────
        function resetBedDropdown() {
            $('#bed-id').html('<option value="">-- Pilih Ruangan Dulu --</option>').prop('disabled', true);
            $('#bed-info').text('');
            $('#class-name').val('');
        }

        // ── Pilih Ruangan → Load Bed Available via AJAX ───────────────────────────
        $('#room-id').on('change', function() {
            var roomId = $(this).val();
            resetBedDropdown();
            if (!roomId) return;
            $('#bed-loading').show();

            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getAvailableBeds']) ?>", {
                    room_id: roomId
                },
                function(data) {
                    $('#bed-loading').hide();
                    if (data.length === 0) {
                        $('#bed-id').html('<option value="">-- Tidak ada bed tersedia --</option>');
                        $('#bed-info').html('<span style="color:#c0392b;">&#9888; Semua bed di ruangan ini terisi.</span>');
                        return;
                    }
                    var options = '<option value="">-- Pilih Bed --</option>';
                    data.forEach(function(bed) {
                        options += '<option value="' + bed.id + '"' +
                            ' data-class="' + (bed.class_name || '') + '">' +
                            bed.name +
                            (bed.bed_no ? ' (' + bed.bed_no + ')' : '') +
                            (bed.class_name ? ' - ' + bed.class_name : '') +
                            '</option>';
                    });
                    $('#bed-id').html(options).prop('disabled', false);
                    $('#bed-info').html('<span style="color:#27ae60;">&#10003; ' + data.length + ' bed tersedia</span>');
                }
            ).fail(function() {
                $('#bed-loading').hide();
                $('#bed-id').html('<option value="">-- Gagal memuat bed --</option>');
            });
        });

        // ── Pilih Bed → Auto-fill Kelas ───────────────────────────────────────────
        $('#bed-id').on('change', function() {
            $('#class-name').val($(this).find('option:selected').data('class') || '');
        });

        // ── Toggle Asuransi / BPJS ───────────────────────────────────────────────
        $('#payment-method').on('change', function() {
            var v = $(this).val();
            if (v === 'UMUM') {
                $('.insurance-field, .bpjs-field').hide();
            } else if (v === 'ASURANSI') {
                $('.insurance-field').show();
                $('.bpjs-field').hide();
            } else {
                $('.insurance-field, .bpjs-field').show();
            }
        });

        $('#insurance-type').on('change', function() {
            $(this).val() === 'BPJS KESEHATAN' ? $('.bpjs-field').show() : $('.bpjs-field').hide();
        });

        // ── Jadwal Dokter ────────────────────────────────────────────────────────
        $('#payment-method').trigger('change');
        $('#insurance-type').trigger('change');

        $('#doctor-id').on('change', function() {
            var doctorId = $(this).val();
            $('#doctor-schedule-id').html('<option value="">-- Pilih Jadwal Dokter --</option>');
            if (!doctorId) return;
            $('#doctor-schedule-id').html('<option value="">Memuat jadwal...</option>');
            $.getJSON(
                "<?= $this->Url->build(['controller' => 'Registrations', 'action' => 'getDoctorSchedules']) ?>", {
                    doctor_id: doctorId
                },
                function(data) {
                    var options = '<option value="">-- Pilih Jadwal Dokter --</option>';

                    if (!data.length) {
                        $('#doctor-schedule-id').html('<option value="">-- Jadwal dokter belum tersedia --</option>');
                        return;
                    }

                    data.forEach(function(item) {
                        options +=
                            '<option value="' + item.id + '">' +
                            item.day + ' | ' + item.start_time + ' - ' + item.end_time +
                            ' (Kuota: ' + item.quota + ')' +
                            '</option>';
                    });

                    $('#doctor-schedule-id').html(options);
                }
            ).fail(function() {
                $('#doctor-schedule-id').html('<option value="">-- Gagal memuat jadwal --</option>');
            });
        });

        $('input[name="referral_type"]').on('change', function() {
            if ($(this).val() === 'None') {
                $('.referral-field').hide();
                $('#referral-doctor, #referral-origin, #referral-name').val('');
            } else {
                $('.referral-field').show();
            }
        });

    });
</script>
