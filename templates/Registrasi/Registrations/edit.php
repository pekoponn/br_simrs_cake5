<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 * @var array $doctors
 * @var array $rooms
 * @var array $beds
 * @var array $provinces
 * @var array $masterPenjamins
 * @var array $masterTreatmentPackages
 * @var array $masterPatientReferrers
 */
?>

<?php
// Default variable agar edit.php tidak notice ketika data relasi belum ke-load.
$doctors = $doctors ?? [];
$rooms = $rooms ?? [];
$beds = $beds ?? [];
$provinces = $provinces ?? [];
$masterPenjamins = $masterPenjamins ?? [];
$masterTreatmentPackages = $masterTreatmentPackages ?? [];
$masterPatientReferrers = $masterPatientReferrers ?? [];
$patient = $registration->patient ?? null;
?>

<style>
    body {
        background: #eef2f7;
    }

    .registrations-wrapper {
        width: 100%;
        max-width: none;
        margin: 0 auto;
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

    .patient-search-content {
        border-radius: 6px;
        overflow: hidden;
    }

    .patient-search-header {
        background: #1e3a5f;
        color: #fff;
        padding: 10px 14px;
    }

    .patient-search-header .close {
        color: #fff;
        opacity: .9;
    }

    .patient-search-body {
        background: #eef2f7;
        padding: 12px;
    }

    .patient-search-topbar {
        background: #dfe6f1;
        border: 1px solid #b8c4d4;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .patient-search-label {
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #24364d;
    }

    .patient-search-input {
        height: 34px;
        border-radius: 3px;
        font-size: 13px;
    }

    .patient-search-help {
        display: block;
        margin-top: 5px;
        color: #52606d;
        font-size: 11px;
    }

    .patient-table-wrap {
        background: #fff;
        border: 1px solid #b8c4d4;
        max-height: 430px;
        overflow: auto;
    }

    .patient-search-table {
        margin-bottom: 0 !important;
        font-size: 12px;
        background: #fff;
    }

    .patient-search-table > thead > tr > th {
        background: #2f4050 !important;
        color: #fff !important;
        border-color: #1d2b38 !important;
        padding: 7px 6px !important;
        vertical-align: middle !important;
        white-space: nowrap;
        text-align: center;
    }

    .patient-search-table td {
        padding: 6px 6px !important;
        vertical-align: middle !important;
        white-space: nowrap;
    }

    .patient-search-table tbody tr.load-patient {
        cursor: pointer;
    }

    .patient-search-table tbody tr.load-patient:hover,
    .patient-search-table tbody tr.patient-row-active {
        background: #b8d7ff !important;
    }

    .patient-empty {
        padding: 28px !important;
        color: #7b8794;
        background: #fafafa;
    }

    .patient-search-footer {
        background: #e9edf3;
        padding: 8px 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .patient-search-count {
        font-size: 12px;
        font-weight: 700;
        color: #2f4050;
    }

    .referral-master-status {
        display: block;
        margin-top: 5px;
        font-size: 11px;
        font-weight: 600;
    }

    .referral-master-status.status-existing {
        color: #198754 !important;
    }

    .referral-master-status.status-new {
        color: #d97706 !important;
    }

    .referral-combination-status {
        display: none;
        margin-top: 2px;
        padding: 8px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.45;
        border: 1px solid transparent;
    }

    .referral-combination-status.status-existing {
        display: block;
        background: #eefaf2;
        border-color: #b7e4c7;
        color: #198754;
    }

    .referral-combination-status.status-new {
        display: block;
        background: #fff7ed;
        border-color: #fed7aa;
        color: #d97706;
    }

    .referral-combination-status.status-info {
        display: block;
        background: #eef6ff;
        border-color: #bfdbfe;
        color: #1e3a5f;
    }

    .referral-step-box {
        background: #f8f9fa;
        border: 1px solid #e1e7ef;
        border-radius: 8px;
        padding: 10px 12px;
    }

    .referral-manual-input[readonly] {
        background: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
    }

</style>

<div class="registrations-wrapper">
    <div class="registrations form content">

            <?php
            $flashMessages = $this->request->getSession()->read('Flash.flash') ?? [];
            if (!empty($flashMessages)):
            ?>
                <div style="margin-bottom:20px;">
                    <?php foreach ($flashMessages as $flashMessage): ?>
                        <?php
                            $isError = strpos((string)($flashMessage['element'] ?? ''), 'error') !== false;
                            $isWarning = strpos((string)($flashMessage['element'] ?? ''), 'warning') !== false;
                            $bg = $isError ? '#fdecea' : ($isWarning ? '#fff7ed' : '#eafaf1');
                            $border = $isError ? '#f5c6cb' : ($isWarning ? '#fed7aa' : '#b7e4c7');
                            $color = $isError ? '#611a15' : ($isWarning ? '#7c2d12' : '#1e4620');
                        ?>
                        <div style="padding:14px 18px;border-radius:8px;margin-bottom:10px;
                                    font-size:14px;font-weight:600;white-space:pre-wrap;word-break:break-word;
                                    background:<?= $bg ?>;border:1px solid <?= $border ?>;color:<?= $color ?>;">
                            <?= h($flashMessage['message'] ?? '') ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?= $this->Form->create($registration) ?>

            <fieldset>
                <legend><?= __('Edit Registrasi Pasien') ?></legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fa fa-user"></i> Data Pasien
                            </div>

                            <div class="form-card-body">
                                <?= $this->Form->hidden('patient_id', [
                                    'id' => 'patient-id',
                                    'value' => $registration->patient_id
                                ]) ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Rekam Medis</label>
                                        <div class="input-group">
                                            <input type="text" id="view-patient-code" class="form-control" readonly
                                                placeholder="Rekam Medis otomatis / cari pasien"
                                                value="<?= h($patient->code ?? '') ?>">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#modalSearchPatient">
                                                    Cari
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Identitas</label>
                                        <select id="view-identity-type" name="patient[identity_type]" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis Identitas --</option>
                                            <?php foreach (['KTP', 'SIM', 'PASPOR'] as $idt): ?>
                                                <option value="<?= $idt ?>" <?= ($patient->identity_type ?? '') === $idt ? 'selected' : '' ?>><?= $idt ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>No Identitas</label>
                                        <input type="text" id="view-identity-number" name="patient[identity_number]" class="form-control"
                                            placeholder="Masukkan nomor identitas pasien"
                                            value="<?= h($patient->identity_number ?? '') ?>">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Gelar</label>
                                        <select id="view-patient-title" name="patient_title" class="form-control select2Form">
                                            <option value="">-- Pilih --</option>
                                            <?php foreach (['Tn', 'Ny', 'Nn', 'An', 'By'] as $title): ?>
                                                <option value="<?= $title ?>" <?= ($patient->title ?? '') === $title ? 'selected' : '' ?>><?= $title ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Nama Pasien</label>
                                        <input type="text" id="view-full-name" name="patient[full_name]" class="form-control"
                                            placeholder="Masukkan nama lengkap pasien"
                                            value="<?= h($patient->full_name ?? '') ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Jenis Kelamin</label>
                                        <select id="view-gender" name="patient[gender]" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="Male"   <?= ($patient->gender ?? '') === 'Male'   ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="Female" <?= ($patient->gender ?? '') === 'Female' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Gol Darah</label>
                                        <select id="view-blood-type" name="patient[blood_type]" class="form-control select2Form">
                                            <option value="">-- Pilih Golongan Darah --</option>
                                            <?php foreach (['A', 'B', 'AB', 'O'] as $bt): ?>
                                                <option value="<?= $bt ?>" <?= ($patient->blood_type ?? '') === $bt ? 'selected' : '' ?>><?= $bt ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Tanggal Lahir</label>
                                        <input type="text" id="view-birth-date" name="patient[birth_date]" class="form-control datepicker-autoclose" autocomplete="off"
                                            placeholder="Pilih tanggal lahir"
                                            value="<?= $patient && $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '' ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Umur</label>
                                        <input type="text" id="view-age" name="patient[age]" class="form-control" readonly placeholder="Umur otomatis">
                                    </div>

                                    <div class="col-md-9">
                                        <label>Alamat</label>
                                        <input type="text" id="view-address" name="patient[address]" class="form-control" placeholder="Masukkan alamat lengkap pasien"
                                            value="<?= h($patient->address ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Nama Ayah</label>
                                        <input type="text" id="view-father-name" name="patient[father_name]" class="form-control" placeholder="Masukkan nama ayah"
                                            value="<?= h($patient->father_name ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Nama Ibu</label>
                                        <input type="text" id="view-mother-name" name="patient[mother_name]" class="form-control" placeholder="Masukkan nama ibu"
                                            value="<?= h($patient->mother_name ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>No Telepon</label>
                                        <input type="text" id="view-phone-number" name="patient[phone_number]" class="form-control"
                                            placeholder="Contoh: 081234567890"
                                            value="<?= h($patient->phone_number ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kewarganegaraan</label>
                                        <select id="view-citizenship" name="patient[citizenship]" class="form-control select2Form">
                                            <option value="">-- Pilih Kewarganegaraan --</option>
                                            <option value="WNI" <?= ($patient->citizenship ?? '') === 'WNI' ? 'selected' : '' ?>>WNI</option>
                                            <option value="WNA" <?= ($patient->citizenship ?? '') === 'WNA' ? 'selected' : '' ?>>WNA</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Negara</label>
                                        <select id="view-nationality" name="patient[nationality]" class="form-control select2Form">
                                            <option value="">-- Pilih Negara --</option>
                                            <?php foreach (['Indonesia', 'INDONESIA', 'Lainnya', 'MALAYSIA', 'SINGAPURA', 'THAILAND'] as $c): ?>
                                                <option value="<?= $c ?>" <?= ($patient->nationality ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Provinsi</label>
                                        <select id="ui-prov" class="form-control select2Form">
                                            <option value="__loaded__"><?= h($patient->province ?? '-- Pilih Provinsi --') ?></option>
                                            <?php foreach ($provinces as $prov): ?>
                                                <option value="<?= h($prov['id_prov']) ?>"><?= h($prov['nama']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="patient[id_prov]" id="hidden-province"
                                               value="<?= h($patient->id_prov ?? $patient->province ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kabupaten/Kota</label>
                                        <select id="ui-kab" class="form-control select2Form">
                                            <option value="__loaded__"><?= h($patient->city ?? '-- Pilih Kabupaten/Kota --') ?></option>
                                        </select>
                                        <input type="hidden" name="patient[id_kab]" id="hidden-city"
                                               value="<?= h($patient->id_kab ?? $patient->city ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kecamatan</label>
                                        <select id="ui-kec" class="form-control select2Form">
                                            <option value="__loaded__"><?= h($patient->district ?? '-- Pilih Kecamatan --') ?></option>
                                        </select>
                                        <input type="hidden" name="patient[id_kec]" id="hidden-district"
                                               value="<?= h($patient->id_kec ?? $patient->district ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kelurahan</label>
                                        <select id="ui-kel" class="form-control select2Form">
                                            <option value="__loaded__"><?= h($patient->subdistrict ?? '-- Pilih Kelurahan --') ?></option>
                                        </select>
                                        <input type="hidden" name="patient[id_kel]" id="hidden-subdistrict"
                                               value="<?= h($patient->id_kel ?? $patient->subdistrict ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Pekerjaan</label>
                                        <select id="view-occupation" name="patient[occupation]" class="form-control select2Form">
                                            <option value="">-- Pilih Pekerjaan --</option>
                                            <?php foreach ([
                                                'BELUM / TIDAK BEKERJA', 'PELAJAR / MAHASISWA', 'PNS', 'TNI', 'POLRI',
                                                'PEGAWAI SWASTA', 'WIRASWASTA', 'PETANI', 'NELAYAN', 'BURUH',
                                                'IBU RUMAH TANGGA', 'PENSIUNAN', 'LAINNYA'
                                            ] as $occ): ?>
                                                <option value="<?= $occ ?>" <?= ($patient->occupation ?? '') === $occ ? 'selected' : '' ?>><?= $occ ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Agama</label>
                                        <select id="view-religion" name="patient[religion]" class="form-control select2Form">
                                            <option value="">-- Pilih Agama --</option>
                                            <?php foreach (['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDDHA', 'KONGHUCU'] as $rel): ?>
                                                <option value="<?= $rel ?>" <?= ($patient->religion ?? '') === $rel ? 'selected' : '' ?>><?= $rel ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Pendidikan</label>
                                        <select id="view-education" name="patient[education]" class="form-control select2Form">
                                            <option value="">-- Pilih Pendidikan --</option>
                                            <?php foreach (['TIDAK SEKOLAH','SD','SMP','SMA / SMK','D1','D2','D3','D4','S1','S2','S3'] as $edu): ?>
                                                <option value="<?= $edu ?>" <?= ($patient->education ?? '') === $edu ? 'selected' : '' ?>><?= $edu ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Suku Bangsa</label>
                                        <select id="view-ethnic-group" name="patient[ethnic_group]" class="form-control select2Form">
                                            <option value="">-- Pilih Suku Bangsa --</option>
                                            <?php foreach (['JAWA','SUNDA','MADURA','BATAK','BUGIS','DAYAK','BANJAR','MINANG','BETAWI','LAINNYA'] as $eth): ?>
                                                <option value="<?= $eth ?>" <?= ($patient->ethnic_group ?? '') === $eth ? 'selected' : '' ?>><?= $eth ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Status Nikah</label>
                                        <select id="view-marital-status" name="patient[marital_status]" class="form-control select2Form">
                                            <option value="">-- Pilih Status Nikah --</option>
                                            <?php foreach (['BELUM MENIKAH','MENIKAH','CERAI HIDUP','CERAI MATI'] as $ms): ?>
                                                <option value="<?= $ms ?>" <?= ($patient->marital_status ?? '') === $ms ? 'selected' : '' ?>><?= $ms ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-card rawat-inap-field" style="<?= ($registration->service_type ?? '') === 'rawat_inap' ? '' : 'display:none;' ?>">
                            <div class="form-card-header">
                                <i class="fa fa-users"></i> Penanggung Jawab Pasien
                            </div>

                            <?php
                                $personResponsibleList = $registration->person_responsibles ?? [];
                                $pr = !empty($personResponsibleList) ? $personResponsibleList[0] : null;
                                ?>

                            <div class="form-card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nama</label>
                                        <input type="text" name="person_responsible[name]" class="form-control" placeholder="Masukkan nama penanggung jawab"
                                            value="<?= h($pr->name ?? '') ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Identitas</label>
                                        <select name="person_responsible[identity_type]" class="form-control select2Form">
                                            <option value="">-- Pilih --</option>
                                            <?php foreach (['KTP', 'SIM', 'PASPOR'] as $idt): ?>
                                                <option value="<?= $idt ?>" <?= ($pr->identity_type ?? '') === $idt ? 'selected' : '' ?>><?= $idt ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>No Identitas</label>
                                        <input type="text" name="person_responsible[identity_no]" class="form-control" placeholder="Masukkan nomor identitas penanggung jawab"
                                            value="<?= h($pr->identity_no ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Hubungan</label>
                                        <select name="person_responsible[relation]" class="form-control select2Form">
                                            <option value="">-- Pilih Hubungan --</option>
                                            <?php foreach (['AYAH','IBU','SUAMI','ISTRI','ANAK','SAUDARA','LAINNYA'] as $rel): ?>
                                                <option value="<?= $rel ?>" <?= ($pr->relation ?? '') === $rel ? 'selected' : '' ?>><?= $rel ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Umur</label>
                                        <input type="number" name="person_responsible[age]" class="form-control" placeholder="Masukkan umur"
                                            value="<?= h($pr->age ?? '') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Pekerjaan</label>
                                        <select name="person_responsible[job]" class="form-control select2Form">
                                            <option value="">-- Pilih Pekerjaan --</option>
                                            <?php foreach ($this->Krs->occupations() as $value => $label): ?>
                                                <option value="<?= h($value) ?>" <?= ($pr->job ?? '') === (string)$value ? 'selected' : '' ?>><?= h($label) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Alamat</label>
                                        <textarea name="person_responsible[address]" class="form-control" placeholder="Masukkan alamat penanggung jawab"><?= h($pr->address ?? '') ?></textarea>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Telepon</label>
                                        <input type="text" name="person_responsible[phone]" class="form-control" placeholder="Contoh: 081234567890"
                                            value="<?= h($pr->phone ?? '') ?>">
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
                                        <label>No Registrasi</label>
                                        <input type="text" name="registration_no" id="registration-no"
                                            class="form-control"
                                            value="<?= h($registration->registration_no) ?>"
                                            readonly
                                            style="background-color:#e9ecef; color:#6c757d; cursor:not-allowed;">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Tanggal Masuk</label>
                                        <input type="text" name="registration_date" class="form-control datepicker-autoclose" autocomplete="off"
                                            placeholder="Pilih tanggal masuk"
                                            value="<?= $registration->registration_date
                                                    ? $registration->registration_date->format('Y-m-d')
                                                    : date('Y-m-d') ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Jam Masuk</label>
                                        <input type="time" name="admission_time" id="admission-time" class="form-control" autocomplete="off" step="60"
                                            onclick="if (this.showPicker) this.showPicker();" onfocus="if (this.showPicker) this.showPicker();"
                                            placeholder="Pilih jam masuk"
                                            value="<?= h($registration->admission_time ?? date('H:i')) ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Pelayanan</label><br>
                                        <?php foreach (['rawat_jalan' => 'Rawat Jalan', 'igd' => 'IGD', 'rawat_inap' => 'Rawat Inap'] as $val => $label): ?>
                                            <label style="margin-right:20px;">
                                                <input type="radio" name="service_type" value="<?= $val ?>"
                                                    <?= ($registration->service_type ?? 'rawat_jalan') === $val ? 'checked' : '' ?>>
                                                <?= $label ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="col-md-4 rawat-jalan-field igd-field">
                                        <label>Poli / Unit</label>
                                        <?= $this->Form->select(
                                            'polyclinic_name',
                                            $this->Krs->polyclinics(),
                                            [
                                                'empty' => '-- Pilih Poli / Unit --',
                                                'id' => 'polyclinic-name',
                                                'class' => 'form-control select2Form',
                                                'value' => $registration->polyclinic_name,
                                            ]
                                        ) ?>
                                    </div>

                                    <div class="col-md-4 rawat-jalan-field igd-field">
                                        <label>Ruang</label>
                                        <?= $this->Form->select(
                                            'room_name',
                                            $this->Krs->outpatientRooms(),
                                            [
                                                'empty' => '-- Pilih Ruang --',
                                                'id' => 'outpatient-room-name',
                                                'class' => 'form-control select2Form',
                                                'value' => $registration->room_name ?? null,
                                            ]
                                        ) ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Nomor Antri</label>
                                        <input type="text" name="queue_number" id="queue-number"
                                            class="form-control"
                                            value="<?= h($registration->queue_no ?? $registration->queue_number ?? '') ?>"
                                            readonly
                                            style="background-color:#e9ecef; color:#6c757d; cursor:not-allowed;">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Dokter</label>
                                        <?= $this->Form->select('doctor_id', $doctors ?? [], [
                                            'empty'   => '-- Pilih Dokter --',
                                            'id'      => 'doctor-id',
                                            'class'   => 'form-control select2Form',
                                            'value'   => $registration->doctor_id,
                                        ]) ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Jadwal Dokter</label>
                                        <select name="doctor_schedule_id" id="doctor-schedule-id" class="form-control select2Form">
                                            <option value="">-- Pilih Jadwal Dokter --</option>
                                            <!-- Akan di-load via AJAX saat halaman siap atau dokter diganti -->
                                        </select>
                                    </div>

                                    <div class="col-md-4 rawat-inap-field" style="<?= ($registration->service_type ?? '') === 'rawat_inap' ? '' : 'display:none;' ?>">
                                        <label>Ruangan</label>
                                        <?= $this->Form->select('room_id', $rooms ?? [], [
                                            'empty' => '-- Pilih Ruangan --',
                                            'id'    => 'room-id',
                                            'class' => 'form-control select2Form',
                                            'value' => $registration->room_id,
                                        ]) ?>
                                    </div>

                                    <div class="col-md-4 rawat-inap-field" style="<?= ($registration->service_type ?? '') === 'rawat_inap' ? '' : 'display:none;' ?>">
                                        <label>
                                            Bed / Kamar
                                            <span id="bed-loading" style="display:none; font-size:12px; color:#888;"> &#8635; Memuat...</span>
                                        </label>
                                        <select name="bed_id" id="bed-id" class="form-control select2Form" disabled>
                                            <option value="">-- Pilih Ruangan Dulu --</option>
                                        </select>
                                        <small id="bed-info" style="color:#888;"></small>
                                    </div>

                                    <div class="col-md-4 rawat-inap-field" style="<?= ($registration->service_type ?? '') === 'rawat_inap' ? '' : 'display:none;' ?>">
                                        <label>Kelas</label>
                                        <input type="text" name="class_name" id="class-name" class="form-control" readonly
                                            value="<?= h($registration->class_name ?? '') ?>"
                                            placeholder="Otomatis terisi saat pilih bed">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Proses Masuk</label>
                                        <?= $this->Form->select('entry_process', $this->Krs->entryProcessOptions(), [
                                            'empty' => '-- Pilih Proses Masuk --',
                                            'class' => 'form-control select2Form',
                                            'value' => $this->request->getData('entry_process') ?? ($registration->entry_process ?? ''),
                                        ]) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Cara Masuk</label>
                                        <?= $this->Form->select('entry_method', $this->Krs->entryMethodOptions(), [
                                            'empty' => '-- Pilih Cara Masuk --',
                                            'class' => 'form-control select2Form',
                                            'value' => $this->request->getData('entry_method') ?? ($registration->entry_method ?? ''),
                                        ]) ?>
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
                                        <label>Jenis Pasien *</label>
                                        <select name="payment_method" id="payment-method" class="form-control select2Form" required>
                                            <option value="">-- Pilih Jenis Pasien --</option>
                                            <?php foreach (['PERORANGAN' => 'PERORANGAN', 'ASURANSI' => 'ASURANSI', 'PERUSAHAAN_AFILIASI' => 'PERUSAHAAN AFILIASI', 'KARYAWAN' => 'KARYAWAN'] as $val => $label): ?>
                                                <option value="<?= $val ?>" <?= ($registration->payment_method ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 payment-detail-field">
                                        <label>Jenis Asuransi</label>
                                        <select name="insurance_type" id="insurance-type" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis Asuransi --</option>
                                            <?php foreach (($masterPenjamins ?? []) as $value => $label): ?>
                                                <option value="<?= h($value) ?>" <?= ($registration->insurance_type ?? '') === (string)$value ? 'selected' : '' ?>><?= h($label) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 payment-detail-field">
                                        <label>Nomor Kartu *</label>
                                        <input type="text" name="insurance_card_no" id="insurance-card-no" class="form-control"
                                            placeholder="Masukkan nomor kartu"
                                            value="<?= h($registration->insurance_card_no ?? '') ?>">
                                    </div>

                                    <div class="col-md-4 payment-detail-field">
                                        <label>No Rujukan/Kontrol</label>
                                        <input type="text" name="refferal_no" id="refferal-no" class="form-control"
                                            placeholder="Masukkan nomor rujukan / kontrol"
                                            value="<?= h($registration->refferal_no ?? '') ?>">
                                    </div>

                                    <div class="col-md-4 payment-detail-field perorangan-field">
                                        <label>SKDP/NO KONTROL</label>
                                        <input type="text" name="skdp_no" id="skdp-no" class="form-control"
                                            placeholder="Masukkan nomor SKDP / kontrol"
                                            value="<?= h($registration->skdp_no ?? '') ?>">
                                    </div>

                                    <div class="col-md-4 payment-detail-field perorangan-field">
                                        <label>Jenis Referensi</label>
                                        <select name="reference_type" id="reference-type" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis Referensi --</option>
                                            <?php foreach (['RUJUKAN FKTP', 'RUJUKAN INTERNAL', 'KONTROL', 'RUJUKAN ANTAR RS'] as $rt): ?>
                                                <option value="<?= $rt ?>" <?= ($registration->reference_type ?? '') === $rt ? 'selected' : '' ?>><?= $rt ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 payment-detail-field">
                                        <label>NIK/Bagian *</label>
                                        <div class="input-group">
                                            <input type="text" name="bpjs_nik" id="bpjs-nik" class="form-control"
                                                placeholder="NIK / Bagian"
                                                value="<?= h($registration->bpjs_nik ?? '') ?>">
                                            <span class="input-group-addon" style="min-width:52px;">adm</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 payment-detail-field">
                                        <label>Nama</label>
                                        <input type="text" name="bpjs_name" id="bpjs-name" class="form-control"
                                            placeholder="Nama peserta"
                                            value="<?= h($registration->bpjs_name ?? '') ?>">
                                    </div>

                                    <div class="col-md-3 payment-detail-field">
                                        <label>Golongan</label>
                                        <select name="bpjs_group" id="bpjs-group" class="form-control select2Form">
                                            <option value="">-- Pilih Golongan --</option>
                                            <?php foreach (['I', 'II', 'III', 'ATE BPJS I', 'ATE BPJS II', 'ATE BPJS III', 'ATE BPJS VIP', 'Abses Genu 10.8', 'Abses Genu 11.8', 'Abses Genu 6.5'] as $bg): ?>
                                                <option value="<?= $bg ?>" <?= ($registration->bpjs_group ?? '') === $bg ? 'selected' : '' ?>><?= $bg ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3 payment-detail-field">
                                        <label>Kelas *</label>
                                        <select name="bpjs_class" id="bpjs-class" class="form-control select2Form">
                                            <option value="">-- Pilih Kelas --</option>
                                            <option value="1" <?= ($registration->bpjs_class ?? '') == '1' ? 'selected' : '' ?>>KELAS 1</option>
                                            <option value="2" <?= ($registration->bpjs_class ?? '') == '2' ? 'selected' : '' ?>>KELAS 2</option>
                                            <option value="3" <?= ($registration->bpjs_class ?? '') == '3' ? 'selected' : '' ?>>KELAS 3</option>
                                            <option value="VIP" <?= ($registration->bpjs_class ?? '') === 'VIP' ? 'selected' : '' ?>>VIP</option>
                                            <option value="VVIP" <?= ($registration->bpjs_class ?? '') === 'VVIP' ? 'selected' : '' ?>>VVIP</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 payment-detail-field">
                                        <label>Jenis *</label>
                                        <select name="bpjs_type" id="bpjs-type" class="form-control select2Form">
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="PESERTA"  <?= ($registration->bpjs_type ?? '') === 'PESERTA'  ? 'selected' : '' ?>>PESERTA</option>
                                            <option value="KELUARGA" <?= ($registration->bpjs_type ?? '') === 'KELUARGA' ? 'selected' : '' ?>>KELUARGA</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 payment-detail-field">
                                        <label>Provider</label>
                                        <input type="text" name="provider" id="provider" class="form-control"
                                            placeholder="Masukkan nama provider"
                                            value="<?= h($registration->provider ?? '') ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label>Perawatan</label><br>
                                        <label style="margin-right:20px;">
                                            <input type="radio" name="treatment_type" value="BIASA"
                                                <?= ($registration->treatment_type ?? 'BIASA') === 'BIASA' ? 'checked' : '' ?>> Biasa
                                        </label>
                                        <label>
                                            <input type="radio" name="treatment_type" value="PAKET"
                                                <?= ($registration->treatment_type ?? '') === 'PAKET' ? 'checked' : '' ?>> Paket
                                        </label>
                                    </div>

                                    <div class="col-md-8 package-field" style="<?= ($registration->treatment_type ?? '') === 'PAKET' ? '' : 'display:none;' ?>">
                                        <label>Paket</label>
                                        <select name="package_name" id="package-name" class="form-control select2Form">
                                            <option value="">-- Pilih Paket --</option>
                                            <?php foreach (($masterTreatmentPackages ?? []) as $value => $label): ?>
                                                <option value="<?= h($value) ?>" <?= ($registration->package_name ?? '') === (string)$value ? 'selected' : '' ?>><?= h($label) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fa fa-clipboard"></i> Perujuk Pasien
                            </div>

                            <div class="form-card-body">
                                <?php $referralType = $registration->referral_type ?? 'None'; ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Rujukan</label><br>
                                        <?php foreach (['Intern' => 'Intern', 'Extern' => 'Extern', 'None' => 'None'] as $val => $label): ?>
                                            <label style="margin-right:20px;">
                                                <input type="radio" name="referral_type" value="<?= $val ?>"
                                                    <?= $referralType === $val ? 'checked' : '' ?>>
                                                <?= $label ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="col-md-12 referral-field" style="<?= in_array($referralType, ['Intern', 'Extern']) ? '' : 'display:none;' ?>">
                                        <div class="referral-step-box">
                                            <label>1. Pilih Asal Rujuk / Rumah Sakit</label>
                                            <select id="referral-origin-select" class="form-control select2Form">
                                                <option value="">-- Pilih asal rujuk dari master --</option>
                                                <option value="__new__">+ Asal rujuk baru / ketik manual</option>
                                            </select>

                                            <input type="text" name="referral_origin" id="referral-origin"
                                                class="form-control referral-manual-input"
                                                autocomplete="off"
                                                placeholder="Ketik asal rujuk baru"
                                                value="<?= h($registration->referral_origin ?? '') ?>"
                                                style="<?= $registration->referral_origin ?? '' ? '' : 'display:none;' ?> margin-top:6px;">

                                            <small id="referral-origin-status" class="referral-master-status text-muted">
                                                Pilih asal rujuk terlebih dahulu.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 referral-field" style="<?= in_array($referralType, ['Intern', 'Extern']) ? '' : 'display:none;' ?>">
                                        <div class="referral-step-box">
                                            <label>2. Dokter Pengirim</label>
                                            <select id="referral-doctor-select" class="form-control select2Form" disabled>
                                                <option value="">-- Pilih asal rujuk dulu --</option>
                                            </select>

                                            <input type="text" name="referral_doctor" id="referral-doctor"
                                                class="form-control referral-manual-input"
                                                autocomplete="off"
                                                placeholder="Ketik dokter pengirim baru"
                                                value="<?= h($registration->referral_doctor ?? '') ?>"
                                                style="<?= $registration->referral_doctor ?? '' ? '' : 'display:none;' ?> margin-top:6px;">

                                            <small id="referral-doctor-status" class="referral-master-status text-muted">
                                                Dokter pengirim akan muncul sesuai asal rujuk.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 referral-field" style="<?= in_array($referralType, ['Intern', 'Extern']) ? '' : 'display:none;' ?>">
                                        <div class="referral-step-box">
                                            <label>3. Nama Perujuk</label>
                                            <select id="referral-name-select" class="form-control select2Form" disabled>
                                                <option value="">-- Pilih asal rujuk dulu --</option>
                                            </select>

                                            <input type="text" name="referral_name" id="referral-name"
                                                class="form-control referral-manual-input"
                                                autocomplete="off"
                                                placeholder="Ketik nama perujuk baru"
                                                value="<?= h($registration->referral_name ?? '') ?>"
                                                style="<?= $registration->referral_name ?? '' ? '' : 'display:none;' ?> margin-top:6px;">

                                            <small id="referral-name-status" class="referral-master-status text-muted">
                                                Nama perujuk akan muncul sesuai asal rujuk.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-12 referral-field" style="<?= in_array($referralType, ['Intern', 'Extern']) ? '' : 'display:none;' ?> margin-top:-6px;">
                                        <div id="referral-combination-status" class="referral-combination-status"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>

            <div class="submit-card">
                <?= $this->Form->button('Simpan', [
                    'type' => 'submit',
                    'escape' => false,
                    'class' => 'btn btn-primary',
                    'id' => 'btn-save-registration'
                ]) ?>
            </div>

            <?= $this->Form->end() ?>

    </div>
</div>

<!-- Modal Cari Pasien -->
<div class="modal fade patient-search-modal" id="modalSearchPatient" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:92%; max-width:1180px;">
        <div class="modal-content patient-search-content">
            <div class="modal-header patient-search-header">
                <h4 class="modal-title">
                    <i class="fa fa-search"></i> Cari Data Pasien
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body patient-search-body">
                <div class="patient-search-topbar">
                    <label class="patient-search-label">Cari Pasien</label>
                    <input type="text"
                           id="modal-search-patient"
                           class="form-control patient-search-input"
                           autocomplete="off"
                           placeholder="Ketik rekam medis / nama pasien / NIK / no telepon">
                    <small class="patient-search-help">
                        Klik 1x baris pasien untuk memilih dan mengisi form registrasi.
                    </small>
                </div>

                <div class="patient-table-wrap">
                    <table class="table table-bordered table-hover patient-search-table">
                        <thead>
                            <tr>
                                <th width="35">OK</th>
                                <th width="120">Rekam Medis</th>
                                <th>Nama Pasien</th>
                                <th width="90">Identitas</th>
                                <th width="155">No Identitas</th>
                                <th width="90">JK</th>
                                <th width="110">Tgl Lahir</th>
                                <th width="130">No Telepon</th>
                                <th width="220">Alamat</th>
                            </tr>
                        </thead>
                        <tbody id="modal-patient-result">
                            <tr>
                                <td colspan="9" class="text-center patient-empty">
                                    Ketik kata kunci pencarian pasien atau buka modal untuk menampilkan data terbaru.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer patient-search-footer">
                <span id="patient-search-count" class="patient-search-count">0 data</span>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                    <i class="fa fa-times"></i> Keluar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var masterPatientReferrers = <?= json_encode($masterPatientReferrers ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

        // ── Data registrasi tersimpan — dipakai untuk inisialisasi form ──────────
        var savedDoctorId       = '<?= h($registration->doctor_id ?? '') ?>';
        var savedScheduleId     = '<?= h($registration->doctor_schedule_id ?? '') ?>';
        var savedServiceType    = '<?= h($registration->service_type ?? 'rawat_jalan') ?>';
        var savedRoomId         = '<?= h($registration->room_id ?? '') ?>';
        var savedBedId          = '<?= h($registration->bed_id ?? '') ?>';
        var savedClassName      = '<?= h($registration->class_name ?? '') ?>';
        var savedPaymentMethod  = '<?= h($registration->payment_method ?? '') ?>';
        var savedInsuranceType  = '<?= h($registration->insurance_type ?? '') ?>';

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

            if (idProv === '__loaded__') return;

            $('#ui-kab').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);
            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-city').val('');
            $('#hidden-district').val('');
            $('#hidden-subdistrict').val('');

            if (!idProv) return;

            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'getKabupatens']) ?>", {
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

            if (idKab === '__loaded__') return;

            $('#ui-kec').html('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-district').val('');
            $('#hidden-subdistrict').val('');

            if (!idKab) return;

            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'getKecamatans']) ?>", {
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

            if (idKec === '__loaded__') return;

            $('#ui-kel').html('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
            $('#hidden-subdistrict').val('');

            if (!idKec) return;

            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'getKelurahans']) ?>", {
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
            if (idKel === '__loaded__') return;
            $('#hidden-subdistrict').val(idKel ? selectedText : '');
        });

        // ── Search Pasien di Modal berbentuk tabel popup ────────────────────────
        var searchTimer;

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function patientAttr(value) {
            return escapeHtml(value).replace(/`/g, '&#096;');
        }

        function renderPatientRows(response) {
            var html = '';
            var total = response && response.length ? response.length : 0;

            $('#patient-search-count').text(total + ' data');

            if (total < 1) {
                $('#modal-patient-result').html(
                    '<tr>' +
                        '<td colspan="9" class="text-center patient-empty">' +
                            '<div style="font-size:28px; margin-bottom:6px;">🔎</div>' +
                            '<div style="font-weight:700;">Pasien tidak ditemukan.</div>' +
                            '<div style="font-size:11px; margin-top:3px;">Coba cari dengan rekam medis, nama, NIK, atau no telepon lain.</div>' +
                        '</td>' +
                    '</tr>'
                );
                return;
            }

            response.forEach(function(p) {
                p.title = getPatientTitle(p);

                var genderText = p.gender || '';
                if (genderText === 'Male') genderText = 'Laki-laki';
                if (genderText === 'Female') genderText = 'Perempuan';

                html += '<tr class="load-patient" title="Klik untuk memilih pasien"';

                var fields = ['id', 'code', 'title', 'full_name', 'identity_type', 'identity_number', 'gender',
                    'blood_type', 'birth_date', 'address', 'father_name', 'mother_name',
                    'phone_number', 'nationality', 'citizenship',
                    'id_prov', 'id_kab', 'id_kec', 'id_kel',
                    'province', 'city', 'district', 'subdistrict',
                    'occupation', 'religion', 'education', 'ethnic_group', 'marital_status'
                ];

                fields.forEach(function(f) {
                    html += ' data-' + f.replace(/_/g, '-') + '="' + patientAttr(p[f] || '') + '"';
                });

                html += '>';
                html += '<td class="text-center"><input type="radio" name="modal_patient_choice"></td>';
                html += '<td style="font-family:monospace; font-weight:700; color:#1e3a5f;">' + escapeHtml(p.code || '-') + '</td>';
                html += '<td><strong>' + escapeHtml(p.full_name || '-') + '</strong></td>';
                html += '<td class="text-center">' + escapeHtml(p.identity_type || '-') + '</td>';
                html += '<td>' + escapeHtml(p.identity_number || '-') + '</td>';
                html += '<td class="text-center">' + escapeHtml(genderText || '-') + '</td>';
                html += '<td class="text-center">' + escapeHtml(p.birth_date || '-') + '</td>';
                html += '<td>' + escapeHtml(p.phone_number || '-') + '</td>';
                html += '<td>' + escapeHtml(p.address || '-') + '</td>';
                html += '</tr>';
            });

            $('#modal-patient-result').html(html);
        }

        function loadPatientSearch(keyword) {
            $('#modal-patient-result').html(
                '<tr><td colspan="9" class="text-center patient-empty">Memuat data pasien...</td></tr>'
            );

            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'searchPatients']) ?>", {
                    q: keyword || ''
                },
                function(response) {
                    renderPatientRows(response || []);
                }
            ).fail(function() {
                $('#patient-search-count').text('0 data');
                $('#modal-patient-result').html(
                    '<tr><td colspan="9" class="text-center patient-empty text-danger">Gagal mencari pasien.</td></tr>'
                );
            });
        }

        $('#modalSearchPatient').on('shown.bs.modal', function() {
            $('#modal-search-patient').focus();
            loadPatientSearch($('#modal-search-patient').val());
        });

        $('#modal-search-patient').on('keyup', function() {
            clearTimeout(searchTimer);
            var keyword = $(this).val();

            searchTimer = setTimeout(function() {
                loadPatientSearch(keyword);
            }, 300);
        });

        // ── Load Data Pasien ke Form ──────────────────────────────────────────────
        function loadPatientToRegistrationForm(patient) {
            patient = patient || {};

            $('#patient-id').val(patient.id || '');
            $('#view-patient-code').val(patient.code || '');
            $('#view-full-name').val(patient.full_name || '');
            setSelectValue('#view-patient-title', patient.title || getPatientTitle(patient));
            setSelectValue('#view-identity-type', patient.identity_type || '');
            $('#view-identity-number').val(patient.identity_number || '');
            setSelectValue('#view-gender', patient.gender || '');
            setSelectValue('#view-blood-type', patient.blood_type || '');
            $('#view-birth-date').val(patient.birth_date || '');
            $('#view-age').val(calculateAge(patient.birth_date || ''));
            $('#view-address').val(patient.address || '');
            $('#view-father-name').val(patient.father_name || '');
            $('#view-mother-name').val(patient.mother_name || '');
            $('#view-phone-number').val(patient.phone_number || '');
            setSelectValue('#view-nationality', patient.nationality || '');
            setSelectValue('#view-citizenship', patient.citizenship || '');
            setSelectValue('#view-occupation', patient.occupation || '');
            setSelectValue('#view-religion', patient.religion || '');
            setSelectValue('#view-education', patient.education || '');
            setSelectValue('#view-ethnic-group', patient.ethnic_group || '');
            setSelectValue('#view-marital-status', patient.marital_status || '');

            var idProv = patient.id_prov || patient.province || '';
            var idKab = patient.id_kab || patient.city || '';
            var idKec = patient.id_kec || patient.district || '';
            var idKel = patient.id_kel || patient.subdistrict || '';

            $('#hidden-province').val(idProv);
            $('#hidden-city').val(idKab);
            $('#hidden-district').val(idKec);
            $('#hidden-subdistrict').val(idKel);

            if (!idProv) {
                $('#ui-prov').val('').trigger('change');
            } else if (isNaN(idProv)) {

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

        }

        $(document).on('click', '.load-patient', function() {
            var $btn = $(this);
            $('.load-patient').removeClass('patient-row-active');
            $btn.addClass('patient-row-active');
            $btn.find('input[type=radio]').prop('checked', true);
            loadPatientToRegistrationForm({
                id: $btn.data('id'),
                code: $btn.data('code'),
                title: $btn.data('title'),
                full_name: $btn.data('full-name'),
                identity_type: $btn.data('identity-type'),
                identity_number: $btn.data('identity-number'),
                gender: $btn.data('gender'),
                blood_type: $btn.data('blood-type'),
                birth_date: $btn.data('birth-date'),
                address: $btn.data('address'),
                father_name: $btn.data('father-name'),
                mother_name: $btn.data('mother-name'),
                phone_number: $btn.data('phone-number'),
                nationality: $btn.data('nationality'),
                citizenship: $btn.data('citizenship'),
                id_prov: $btn.data('id-prov'),
                id_kab: $btn.data('id-kab'),
                id_kec: $btn.data('id-kec'),
                id_kel: $btn.data('id-kel'),
                province: $btn.data('province'),
                city: $btn.data('city'),
                district: $btn.data('district'),
                subdistrict: $btn.data('subdistrict'),
                occupation: $btn.data('occupation'),
                religion: $btn.data('religion'),
                education: $btn.data('education'),
                ethnic_group: $btn.data('ethnic-group'),
                marital_status: $btn.data('marital-status')
            });

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
        function setServiceForm(type, isInit) {
            var $poli = $('#polyclinic-name');
            var $queue = $('#queue-number');

            if (type === 'rawat_inap') {
                $('.rawat-inap-field').show();
                $('.rawat-jalan-field, .igd-field').hide();

                if (!isInit) {
                    $poli.val('').trigger('change');
                }
                $poli.prop('disabled', false);

                if (!isInit) {
                    $queue.val('');
                }
                $queue.prop('readonly', true);

                $('#igd-auto-note').remove();

            } else {
                $('.rawat-inap-field').hide();
                $('.rawat-jalan-field, .igd-field').show();

                if (!isInit) {
                    $('#room-id').val('');
                    resetBedDropdown();
                    $('#class-name').val('');
                }

                if (type === 'igd') {
                    if ($poli.find('option[value="IGD"]').length === 0) {
                        $poli.append('<option value="IGD">IGD</option>');
                    }

                    $poli.val('IGD').trigger('change');
                    $poli.prop('disabled', true);

                    if ($('#polyclinic-name-hidden-igd').length === 0) {
                        $poli.after('<input type="hidden" id="polyclinic-name-hidden-igd" name="polyclinic_name" value="IGD">');
                    } else {
                        $('#polyclinic-name-hidden-igd').val('IGD');
                    }

                    if (!isInit) {
                        $queue.val('');
                    }
                    $queue.prop('readonly', true);
                    $queue.prop('disabled', true);

                    if ($('#queue-number-hidden-igd').length === 0) {
                        $queue.after('<input type="hidden" id="queue-number-hidden-igd" name="queue_number" value="' + $queue.val() + '">');
                    }

                    if ($('#igd-auto-note').length === 0) {
                        $poli.closest('.col-md-4').append(
                            '<small id="igd-auto-note" style="display:block;margin-top:5px;color:#1e3a5f;font-weight:600;">IGD otomatis terisi ketika pelayanan IGD dipilih.</small>'
                        );
                    }

                } else {
                    $poli.prop('disabled', false);
                    $('#polyclinic-name-hidden-igd').remove();

                    if (!isInit && $poli.val() === 'IGD') {
                        $poli.val('').trigger('change');
                    }

                    $queue.prop('readonly', true);
                    $queue.prop('disabled', false);
                    $('#queue-number-hidden-igd').remove();
                    $('#igd-auto-note').remove();
                }
            }
        }

        // Inisialisasi sesuai data tersimpan (tidak mengosongkan field yang sudah terisi)
        setServiceForm(savedServiceType, true);

        $('input[name="service_type"]').on('change', function() {
            setServiceForm($(this).val(), false);
        });

        // ── Reset dropdown bed ────────────────────────────────────────────────────
        function resetBedDropdown() {
            $('#bed-id').html('<option value="">-- Pilih Ruangan Dulu --</option>').prop('disabled', true);
            $('#bed-info').text('');
        }

// ── Load Beds ─────────────────────────────────────────────────────────────
        function loadBeds(roomId, selectedBedId, selectedClassName) {
            resetBedDropdown();
            if (!roomId) return;
            $('#bed-loading').show();

            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'getAvailableBeds']) ?>", {
                    room_id: roomId,
                    current_bed_id: selectedBedId || ''
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
                            ' data-class="' + (bed.class_name || '') + '"' +
                            (String(bed.id) === String(selectedBedId) ? ' selected' : '') + '>' +
                            bed.name +
                            (bed.bed_no ? ' (' + bed.bed_no + ')' : '') +
                            (bed.class_name ? ' - ' + bed.class_name : '') +
                            '</option>';
                    });
                    $('#bed-id').html(options).prop('disabled', false);
                    $('#bed-info').html('<span style="color:#27ae60;">&#10003; ' + data.length + ' bed tersedia</span>');

                    if (selectedBedId) {
                        $('#class-name').val(selectedClassName || $('#bed-id option:selected').data('class') || '');
                    }
                }
            ).fail(function() {
                $('#bed-loading').hide();
                $('#bed-id').html('<option value="">-- Gagal memuat bed --</option>');
            });
        }

        // ── Pilih Ruangan → Load Bed ──────────────────────────────────────────────
        $('#room-id').on('change', function() {
            loadBeds($(this).val(), '', '');
        });

        // ── Pilih Bed → Auto-fill Kelas ───────────────────────────────────────────
        $('#bed-id').on('change', function() {
            $('#class-name').val($(this).find('option:selected').data('class') || '');
        });

        // Muat bed tersimpan jika rawat inap
        if (savedServiceType === 'rawat_inap' && savedRoomId) {
            loadBeds(savedRoomId, savedBedId, savedClassName);
        }

        // ── Toggle Cara Bayar sesuai Jenis Pasien ────────────────────────────────
        function resetPaymentRequired() {
            $('#insurance-card-no, #bpjs-nik, #bpjs-class, #bpjs-type').prop('required', false);
        }

        function clearPaymentDetailFields() {
            $('#insurance-type, #insurance-category, #insurance-card-no, #refferal-no, #bpjs-nik, #bpjs-name, #bpjs-group, #bpjs-type, #bpjs-class, #provider')
                .val('')
                .trigger('change');
        }

        function togglePaymentFields(isInit) {
            var jenis = $('#payment-method').val();

            $('.payment-detail-field, .perorangan-field').hide();
            resetPaymentRequired();

            if (jenis === 'PERORANGAN') {
                $('.perorangan-field').show();
                if (!isInit) { clearPaymentDetailFields(); }
                return;
            }

            if (jenis === 'ASURANSI' || jenis === 'PERUSAHAAN_AFILIASI' || jenis === 'KARYAWAN') {
                $('.payment-detail-field').show();
                $('#insurance-card-no, #bpjs-nik, #bpjs-class, #bpjs-type').prop('required', true);

                if (!isInit) {
                    if (jenis === 'PERUSAHAAN_AFILIASI' && !$('#insurance-type').val()) {
                        $('#insurance-type').val('PERUSAHAAN AFILIASI').trigger('change');
                    }

                    if (jenis === 'KARYAWAN' && !$('#insurance-type').val()) {
                        $('#insurance-type').val('KARYAWAN').trigger('change');
                    }

                    if (!$('#bpjs-name').val()) {
                        $('#bpjs-name').val($('#view-full-name').val());
                    }

                    if (!$('#bpjs-nik').val()) {
                        $('#bpjs-nik').val($('#view-identity-number').val());
                    }
                }
            }
        }

        $('#payment-method').on('change', function() {
            togglePaymentFields(false);
        });

        function togglePackageField(isInit) {
            var treatmentType = $('input[name="treatment_type"]:checked').val();

            if (treatmentType === 'PAKET') {
                $('.package-field').show();
                $('#package-name').prop('required', true);
            } else {
                $('.package-field').hide();
                $('#package-name').prop('required', false);
                if (!isInit) { $('#package-name').val('').trigger('change'); }
            }
        }

        $('input[name="treatment_type"]').on('change', function() {
            togglePackageField(false);
        });

        // ── Inisialisasi Cara Bayar & Paket sesuai data tersimpan ─────────────────
        togglePaymentFields(true);
        togglePackageField(true);

        // ── Jadwal Dokter ────────────────────────────────────────────────────────
        function loadDoctorSchedules(doctorId, selectedScheduleId) {
            $('#doctor-schedule-id').html('<option value="">-- Pilih Jadwal Dokter --</option>');
            if (!doctorId) return;
            $('#doctor-schedule-id').html('<option value="">Memuat jadwal...</option>');
            $.getJSON(
                "<?= $this->Url->build(['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'getDoctorSchedules']) ?>", {
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
                            '<option value="' + item.id + '"' +
                            (String(item.id) === String(selectedScheduleId) ? ' selected' : '') + '>' +
                            item.day + ' | ' + item.start_time + ' - ' + item.end_time +
                            ' (Kuota: ' + item.quota + ')' +
                            '</option>';
                    });

                    $('#doctor-schedule-id').html(options);
                }
            ).fail(function() {
                $('#doctor-schedule-id').html('<option value="">-- Gagal memuat jadwal --</option>');
            });
        }

        $('#doctor-id').on('change', function() {
            loadDoctorSchedules($(this).val(), '');
        });

        if (savedDoctorId) {
            loadDoctorSchedules(savedDoctorId, savedScheduleId);
        }

        function normalizeReferralValue(value) {
            return $.trim(String(value || ''))
                .toLowerCase()
                .replace(/\s+/g, ' ');
        }

        function getReferrerName(referrer) {
            return referrer.name || referrer.referral_name || '';
        }

        function getReferrerOrigin(referrer) {
            return referrer.referral_origin || referrer.origin || referrer.type || referrer.address || '';
        }

        function getReferrerDoctor(referrer) {
            return referrer.doctor_sender || referrer.referral_doctor || referrer.doctor || '';
        }

        function escapeReferralText(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function refreshReferralSelect($select) {
            if ($.fn.select2 && $select.hasClass('select2-hidden-accessible')) {
                $select.trigger('change.select2');
            }
        }

        function uniqueReferralValues(referrers, getter) {
            var map = {};
            var list = [];

            referrers.forEach(function(referrer) {
                var value = $.trim(String(getter(referrer) || ''));
                var key = normalizeReferralValue(value);

                if (value !== '' && !map[key]) {
                    map[key] = true;
                    list.push(value);
                }
            });

            list.sort(function(a, b) {
                return a.localeCompare(b);
            });

            return list;
        }

        function getReferrersByOrigin(origin) {
            var normalizedOrigin = normalizeReferralValue(origin);
            if (!normalizedOrigin) return [];

            return masterPatientReferrers.filter(function(referrer) {
                return normalizeReferralValue(getReferrerOrigin(referrer)) === normalizedOrigin;
            });
        }

        function buildReferrerOptions(values, emptyText, newText) {
            var html = '<option value="">' + escapeReferralText(emptyText) + '</option>';

            values.forEach(function(value) {
                html += '<option value="' + escapeReferralText(value) + '">' + escapeReferralText(value) + '</option>';
            });

            html += '<option value="__new__">+ ' + escapeReferralText(newText) + '</option>';

            return html;
        }

        function setReferralStatus(selector, statusClass, text) {
            $(selector)
                .removeClass('status-existing status-new text-muted')
                .addClass(statusClass || 'text-muted')
                .text(text || '');
        }

        function setReferralCombinationStatus(type, html) {
            $('#referral-combination-status')
                .removeClass('status-existing status-new status-info')
                .addClass(type)
                .html(html || '')
                .show();
        }

        function clearReferralCombinationStatus() {
            $('#referral-combination-status')
                .removeClass('status-existing status-new status-info')
                .html('')
                .hide();
        }

        function resetReferralAfterOrigin() {
            $('#referral-doctor-select')
                .html('<option value="">-- Pilih asal rujuk dulu --</option>')
                .prop('disabled', true);
            $('#referral-name-select')
                .html('<option value="">-- Pilih asal rujuk dulu --</option>')
                .prop('disabled', true);

            $('#referral-doctor, #referral-name').val('').hide();
            setReferralStatus('#referral-doctor-status', 'text-muted', 'Dokter pengirim akan muncul sesuai asal rujuk.');
            setReferralStatus('#referral-name-status', 'text-muted', 'Nama perujuk akan muncul sesuai asal rujuk.');
            clearReferralCombinationStatus();

            refreshReferralSelect($('#referral-doctor-select'));
            refreshReferralSelect($('#referral-name-select'));
        }

        function populateOriginSelect() {
            var origins = uniqueReferralValues(masterPatientReferrers, getReferrerOrigin);
            $('#referral-origin-select').html(
                buildReferrerOptions(origins, '-- Pilih asal rujuk dari master --', 'Asal rujuk baru / ketik manual')
            );
            refreshReferralSelect($('#referral-origin-select'));
        }

        function populateDoctorAndNameByOrigin(origin) {
            var referrers = getReferrersByOrigin(origin);
            var doctors = uniqueReferralValues(referrers, getReferrerDoctor);
            var names = uniqueReferralValues(referrers, getReferrerName);

            $('#referral-doctor-select')
                .html(buildReferrerOptions(doctors, '-- Pilih dokter pengirim --', 'Dokter pengirim baru / ketik manual'))
                .prop('disabled', false);

            $('#referral-name-select')
                .html(buildReferrerOptions(names, '-- Pilih nama perujuk --', 'Nama perujuk baru / ketik manual'))
                .prop('disabled', false);

            setReferralStatus('#referral-doctor-status', 'text-muted', 'Pilih dokter pengirim sesuai asal rujuk.');
            setReferralStatus('#referral-name-status', 'text-muted', 'Pilih nama perujuk sesuai asal rujuk.');

            refreshReferralSelect($('#referral-doctor-select'));
            refreshReferralSelect($('#referral-name-select'));
        }

        function updateReferralCombinationStatus() {
            var origin = $.trim($('#referral-origin').val());
            var doctor = $.trim($('#referral-doctor').val());
            var name = $.trim($('#referral-name').val());

            clearReferralCombinationStatus();

            if (!origin) {
                return;
            }

            var originReferrers = getReferrersByOrigin(origin);

            if (originReferrers.length < 1) {
                setReferralCombinationStatus(
                    'status-new',
                    'Asal rujuk baru. Dokter pengirim dan nama perujuk boleh diketik manual, lalu otomatis dianggap data master baru.'
                );
                return;
            }

            if (!doctor && !name) {
                setReferralCombinationStatus(
                    'status-info',
                    'Asal rujuk sudah ada. Lanjut pilih dokter pengirim dan nama perujuk dari data asal tersebut.'
                );
                return;
            }

            var normalizedOrigin = normalizeReferralValue(origin);
            var normalizedDoctor = normalizeReferralValue(doctor);
            var normalizedName = normalizeReferralValue(name);

            var exact = masterPatientReferrers.filter(function(referrer) {
                var sameOrigin = normalizeReferralValue(getReferrerOrigin(referrer)) === normalizedOrigin;
                var sameDoctor = !normalizedDoctor || normalizeReferralValue(getReferrerDoctor(referrer)) === normalizedDoctor;
                var sameName = !normalizedName || normalizeReferralValue(getReferrerName(referrer)) === normalizedName;

                return sameOrigin && sameDoctor && sameName;
            });

            if (doctor) {
                var doctorExists = originReferrers.some(function(referrer) {
                    return normalizeReferralValue(getReferrerDoctor(referrer)) === normalizedDoctor;
                });
                setReferralStatus('#referral-doctor-status', doctorExists ? 'status-existing' : 'status-new', doctorExists ? 'Dokter pengirim sudah ada' : 'Dokter pengirim baru');
            }

            if (name) {
                var nameExists = originReferrers.some(function(referrer) {
                    return normalizeReferralValue(getReferrerName(referrer)) === normalizedName;
                });
                setReferralStatus('#referral-name-status', nameExists ? 'status-existing' : 'status-new', nameExists ? 'Perujuk sudah ada' : 'Perujuk baru');
            }

            if (doctor && name) {
                if (exact.length > 0) {
                    setReferralCombinationStatus(
                        'status-existing',
                        'Data perujuk sudah ada di master untuk asal rujuk, dokter pengirim, dan nama perujuk ini.'
                    );
                } else {
                    setReferralCombinationStatus(
                        'status-new',
                        'Kombinasi asal rujuk + dokter pengirim + nama perujuk belum ada. Data ini akan dianggap master perujuk baru.'
                    );
                }
            }
        }

        $('#referral-origin-select').on('change', function() {
            var value = $(this).val();

            resetReferralAfterOrigin();

            if (!value) {
                $('#referral-origin').val('').hide();
                setReferralStatus('#referral-origin-status', 'text-muted', 'Pilih asal rujuk terlebih dahulu.');
                return;
            }

            if (value === '__new__') {
                $('#referral-origin').val('').show().focus();
                $('#referral-doctor-select, #referral-name-select').prop('disabled', false);
                $('#referral-doctor-select').html('<option value="__new__">+ Dokter pengirim baru / ketik manual</option>');
                $('#referral-name-select').html('<option value="__new__">+ Nama perujuk baru / ketik manual</option>');
                $('#referral-doctor, #referral-name').val('').show();
                setReferralStatus('#referral-origin-status', 'status-new', 'Asal perujuk baru');
                setReferralStatus('#referral-doctor-status', 'status-new', 'Dokter pengirim baru');
                setReferralStatus('#referral-name-status', 'status-new', 'Perujuk baru');
                refreshReferralSelect($('#referral-doctor-select'));
                refreshReferralSelect($('#referral-name-select'));
                updateReferralCombinationStatus();
                return;
            }

            $('#referral-origin').val(value).show().prop('readonly', true);
            setReferralStatus('#referral-origin-status', 'status-existing', 'Asal perujuk sudah ada');
            populateDoctorAndNameByOrigin(value);
            updateReferralCombinationStatus();
        });

        $('#referral-origin').on('keyup change blur', function() {
            if ($('#referral-origin-select').val() === '__new__') {
                updateReferralCombinationStatus();
            }
        });

        $('#referral-doctor-select').on('change', function() {
            var value = $(this).val();

            if (!value) {
                $('#referral-doctor').val('').hide();
                setReferralStatus('#referral-doctor-status', 'text-muted', 'Pilih dokter pengirim sesuai asal rujuk.');
                updateReferralCombinationStatus();
                return;
            }

            if (value === '__new__') {
                $('#referral-doctor').val('').show().prop('readonly', false).focus();
                setReferralStatus('#referral-doctor-status', 'status-new', 'Dokter pengirim baru');
                updateReferralCombinationStatus();
                return;
            }

            $('#referral-doctor').val(value).show().prop('readonly', true);
            setReferralStatus('#referral-doctor-status', 'status-existing', 'Dokter pengirim sudah ada');
            updateReferralCombinationStatus();
        });

        $('#referral-name-select').on('change', function() {
            var value = $(this).val();

            if (!value) {
                $('#referral-name').val('').hide();
                setReferralStatus('#referral-name-status', 'text-muted', 'Pilih nama perujuk sesuai asal rujuk.');
                updateReferralCombinationStatus();
                return;
            }

            if (value === '__new__') {
                $('#referral-name').val('').show().prop('readonly', false).focus();
                setReferralStatus('#referral-name-status', 'status-new', 'Perujuk baru');
                updateReferralCombinationStatus();
                return;
            }

            $('#referral-name').val(value).show().prop('readonly', true);
            setReferralStatus('#referral-name-status', 'status-existing', 'Perujuk sudah ada');
            updateReferralCombinationStatus();
        });

        $('#referral-doctor, #referral-name').on('keyup change blur', function() {
            updateReferralCombinationStatus();
        });

        $('input[name="referral_type"]').on('change', function() {
            if ($(this).val() === 'None') {
                $('.referral-field').hide();
                $('#referral-origin-select, #referral-doctor-select, #referral-name-select').val('').trigger('change.select2');
                $('#referral-origin, #referral-doctor, #referral-name').val('').hide().prop('readonly', false);
                resetReferralAfterOrigin();
            } else {
                $('.referral-field').show();
            }
        });

        // ── Inisialisasi Perujuk sesuai data tersimpan ────────────────────────────
        populateOriginSelect();

        var savedReferralOrigin = '<?= h($registration->referral_origin ?? '') ?>';
        var savedReferralDoctor = '<?= h($registration->referral_doctor ?? '') ?>';
        var savedReferralName   = '<?= h($registration->referral_name ?? '') ?>';

        if (savedReferralOrigin) {
            var originExists = getReferrersByOrigin(savedReferralOrigin).length > 0;
            setSelectValue('#referral-origin-select', originExists ? savedReferralOrigin : '__new__');
            $('#referral-origin').val(savedReferralOrigin).show();
            setReferralStatus('#referral-origin-status', originExists ? 'status-existing' : 'status-new', originExists ? 'Asal perujuk sudah ada' : 'Asal perujuk baru');

            if (originExists) {
                populateDoctorAndNameByOrigin(savedReferralOrigin);
            } else {
                $('#referral-doctor-select, #referral-name-select').prop('disabled', false)
                    .html('<option value="__new__">+ Ketik manual</option>');
            }

            if (savedReferralDoctor) {
                var doctorExists = getReferrersByOrigin(savedReferralOrigin).some(function(r) {
                    return normalizeReferralValue(getReferrerDoctor(r)) === normalizeReferralValue(savedReferralDoctor);
                });
                setSelectValue('#referral-doctor-select', doctorExists ? savedReferralDoctor : '__new__');
                $('#referral-doctor').val(savedReferralDoctor).show();
            }

            if (savedReferralName) {
                var nameExists = getReferrersByOrigin(savedReferralOrigin).some(function(r) {
                    return normalizeReferralValue(getReferrerName(r)) === normalizeReferralValue(savedReferralName);
                });
                setSelectValue('#referral-name-select', nameExists ? savedReferralName : '__new__');
                $('#referral-name').val(savedReferralName).show();
            }

            updateReferralCombinationStatus();
        } else {
            resetReferralAfterOrigin();
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('btn-save-registration');
    if (!btn) return;

    btn.closest('form').addEventListener('submit', function () {
        btn.disabled = true;
        btn.innerHTML = 'Menyimpan...';
    });
});
</script>