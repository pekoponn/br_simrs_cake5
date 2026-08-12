<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 */

$patient = $registration->patient ?? null;

// Penanggung jawab bisa singular (hasOne) atau plural (hasMany), jadi dicek dua-duanya
// supaya konsisten dengan pola yang sudah dipakai di add.php & edit.php.
$pr = $registration->person_responsible ?? null;
if (empty($pr) && !empty($registration->person_responsibles)) {
    $pr = is_array($registration->person_responsibles)
        ? ($registration->person_responsibles[0] ?? null)
        : $registration->person_responsibles;
}

$doctor = $registration->doctor ?? null;
$room = $registration->room ?? null;
$bed = $registration->bed ?? null;

/**
 * Helper kecil untuk menampilkan satu field readonly ala form (label + kotak abu-abu).
 * $value sudah otomatis di-escape, jangan pernah kirim HTML mentah ke sini.
 */
function regField($label, $value, $colClass = 'col-md-4')
{
    $display = ($value !== null && $value !== '')
        ? h($value)
        : '<span class="view-empty">-</span>';

    echo '<div class="' . $colClass . '">'
        . '<label>' . h($label) . '</label>'
        . '<div class="view-field">' . $display . '</div>'
        . '</div>';
}

/**
 * Sama seperti regField tapi untuk konten yang memang sudah berupa HTML aman (mis. badge).
 */
function regFieldRaw($label, $html, $colClass = 'col-md-4')
{
    echo '<div class="' . $colClass . '">'
        . '<label>' . h($label) . '</label>'
        . '<div class="view-field">' . ($html !== '' ? $html : '<span class="view-empty">-</span>') . '</div>'
        . '</div>';
}

function formatDateView($date, $withTime = false)
{
    if (empty($date)) {
        return '';
    }
    if (is_object($date) && method_exists($date, 'format')) {
        return $date->format($withTime ? 'd-m-Y H:i' : 'd-m-Y');
    }
    $ts = strtotime((string)$date);
    return $ts ? date($withTime ? 'd-m-Y H:i' : 'd-m-Y', $ts) : (string)$date;
}

function formatTimeView($time)
{
    if (empty($time)) {
        return '';
    }
    if (is_object($time) && method_exists($time, 'format')) {
        return $time->format('H:i');
    }
    return substr((string)$time, 0, 5);
}

function genderLabel($gender)
{
    if ($gender === 'Male') {
        return 'Laki-laki';
    }
    if ($gender === 'Female') {
        return 'Perempuan';
    }
    return $gender;
}

$serviceLabels = [
    'rawat_jalan' => 'Rawat Jalan',
    'igd' => 'IGD',
    'rawat_inap' => 'Rawat Inap',
];
$serviceClass = [
    'rawat_jalan' => 'badge-blue',
    'igd' => 'badge-red',
    'rawat_inap' => 'badge-purple',
];

$paymentLabels = [
    'PERORANGAN' => 'PERORANGAN',
    'ASURANSI' => 'ASURANSI',
    'PERUSAHAAN_AFILIASI' => 'PERUSAHAAN AFILIASI',
    'KARYAWAN' => 'KARYAWAN',
];

$statusLower = strtolower((string)($registration->status ?? ''));
$isAktif = $statusLower === 'aktif' || $statusLower === '';
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

    .registrations.view.content {
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

    .form-card-body .row > div {
        margin-bottom: 14px;
    }

    .form-card-body label {
        font-weight: 600;
        font-size: 12px;
        margin-bottom: 5px;
        color: #57606f;
        display: block;
    }

    .view-field {
        min-height: 38px;
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #e4e9f0;
        background: #f7f9fc;
        font-size: 13px;
        color: #2f3542;
        word-break: break-word;
    }

    .view-empty {
        color: #adb5bd;
        font-style: italic;
    }

    .side-nav {
        display: none;
    }

    fieldset legend {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #2f3542;
    }

    .registration-header-card {
        background: #fff;
        border: 1px solid #dfe6ee;
        border-radius: 10px;
        padding: 18px 22px;
        margin-bottom: 22px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
    }

    .registration-header-card h3 {
        margin: 0 0 6px 0;
        font-size: 20px;
        font-weight: 700;
        color: #1e3a5f;
    }

    .registration-header-card .reg-meta {
        font-size: 12px;
        color: #7b8794;
    }

    .header-actions .btn {
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        margin-left: 8px;
    }

    .badge-pill {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .3px;
    }

    .badge-green {
        background: #eafaf0;
        color: #198754;
        border: 1px solid #b7e4c7;
    }

    .badge-gray {
        background: #f1f3f5;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .badge-blue {
        background: #eef6ff;
        color: #1e3a5f;
        border: 1px solid #bfdbfe;
    }

    .badge-red {
        background: #fdeeee;
        color: #c0392b;
        border: 1px solid #f5c2c0;
    }

    .badge-purple {
        background: #f3eefc;
        color: #6f42c1;
        border: 1px solid #d9c8f5;
    }

    .badge-orange {
        background: #fff7ed;
        color: #d97706;
        border: 1px solid #fed7aa;
    }

    .empty-card-note {
        padding: 20px;
        text-align: center;
        color: #adb5bd;
        font-size: 13px;
    }
</style>

<div class="registrations-wrapper">
    <div class="registrations view content">

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

        <div class="registration-header-card">
            <div>
                <h3><?= h($registration->registration_no ?: ('Registrasi #' . $registration->id)) ?></h3>
                <div class="reg-meta">
                    Dibuat <?= h(formatDateView($registration->created, true) ?: '-') ?>
                    <?php if (!empty($registration->modified)): ?>
                        &middot; Diubah terakhir <?= h(formatDateView($registration->modified, true)) ?>
                    <?php endif; ?>
                </div>
                <div style="margin-top:8px;">
                    <span class="badge-pill <?= $isAktif ? 'badge-green' : 'badge-gray' ?>">
                        <?= h($isAktif ? 'AKTIF' : strtoupper((string)$registration->status)) ?>
                    </span>
                    <span class="badge-pill <?= $serviceClass[$registration->service_type ?? ''] ?? 'badge-gray' ?>">
                        <?= h($serviceLabels[$registration->service_type ?? ''] ?? ($registration->service_type ?? '-')) ?>
                    </span>
                    <?php if (!empty($registration->payment_method)): ?>
                        <span class="badge-pill badge-orange">
                            <?= h($paymentLabels[$registration->payment_method] ?? $registration->payment_method) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="header-actions">
                <?= $this->Html->link(
                    '<i class="fa fa-arrow-left"></i> Kembali',
                    ['action' => 'index'],
                    ['class' => 'btn btn-default', 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fa fa-pencil"></i> Edit',
                    ['action' => 'edit', $registration->id],
                    ['class' => 'btn btn-primary', 'escape' => false]
                ) ?>
                <?= $this->Form->postLink(
                    '<i class="fa fa-trash"></i> Hapus',
                    ['action' => 'delete', $registration->id],
                    [
                        'confirm' => __('Yakin ingin menghapus registrasi {0}?', $registration->registration_no ?: $registration->id),
                        'class' => 'btn btn-danger',
                        'escape' => false,
                    ]
                ) ?>
            </div>
        </div>

        <fieldset>
            <div class="row">
                <div class="col-md-6">

                    <!-- Data Pasien -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fa fa-user"></i> Data Pasien
                        </div>
                        <div class="form-card-body">
                            <?php if ($patient): ?>
                                <div class="row">
                                    <?php regField('Kode Pasien', $patient->code ?? '', 'col-md-4') ?>
                                    <?php regField('Identitas', $patient->identity_type ?? '', 'col-md-3') ?>
                                    <?php regField('No Identitas', $patient->identity_number ?? '', 'col-md-5') ?>

                                    <?php regField('Gelar', $registration->patient_title ?? ($patient->title ?? ''), 'col-md-2') ?>
                                    <?php regField('Nama Pasien', $patient->full_name ?? '', 'col-md-6') ?>
                                    <?php regField('Jenis Kelamin', genderLabel($patient->gender ?? ''), 'col-md-4') ?>

                                    <?php regField('Gol Darah', $patient->blood_type ?? '', 'col-md-3') ?>
                                    <?php regField('Tanggal Lahir', formatDateView($patient->birth_date ?? null), 'col-md-4') ?>
                                    <?php regField('No Telepon', $patient->phone_number ?? '', 'col-md-5') ?>

                                    <?php regField('Alamat', $patient->address ?? '', 'col-md-12') ?>

                                    <?php regField('Nama Ayah', $patient->father_name ?? '', 'col-md-6') ?>
                                    <?php regField('Nama Ibu', $patient->mother_name ?? '', 'col-md-6') ?>

                                    <?php regField('Kewarganegaraan', $patient->citizenship ?? '', 'col-md-4') ?>
                                    <?php regField('Negara', $patient->nationality ?? '', 'col-md-4') ?>
                                    <?php regField('Pekerjaan', $patient->occupation ?? '', 'col-md-4') ?>

                                    <?php regField('Provinsi', $patient->province ?? '', 'col-md-3') ?>
                                    <?php regField('Kabupaten/Kota', $patient->city ?? '', 'col-md-3') ?>
                                    <?php regField('Kecamatan', $patient->district ?? '', 'col-md-3') ?>
                                    <?php regField('Kelurahan', $patient->subdistrict ?? '', 'col-md-3') ?>

                                    <?php regField('Agama', $patient->religion ?? '', 'col-md-3') ?>
                                    <?php regField('Pendidikan', $patient->education ?? '', 'col-md-3') ?>
                                    <?php regField('Suku Bangsa', $patient->ethnic_group ?? '', 'col-md-3') ?>
                                    <?php regField('Status Nikah', $patient->marital_status ?? '', 'col-md-3') ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-card-note">Data pasien tidak ditemukan.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Penanggung Jawab -->
                    <div class="form-card rawat-inap-field" style="<?= ($registration->service_type ?? '') === 'rawat_inap' ? '' : 'display:none;' ?>">
                        <div class="form-card-header">
                            <i class="fa fa-users"></i> Penanggung Jawab Pasien
                        </div>
                        <div class="form-card-body">
                            <?php if ($pr): ?>
                                <div class="row">
                                    <?php regField('Nama', $pr->name ?? '', 'col-md-6') ?>
                                    <?php regField('Identitas', $pr->identity_type ?? '', 'col-md-3') ?>
                                    <?php regField('No Identitas', $pr->identity_no ?? '', 'col-md-3') ?>

                                    <?php regField('Hubungan', $pr->relation ?? '', 'col-md-4') ?>
                                    <?php regField('Umur', $pr->age ?? '', 'col-md-2') ?>
                                    <?php regField('Pekerjaan', $pr->job ?? '', 'col-md-6') ?>

                                    <?php regField('Alamat', $pr->address ?? '', 'col-md-8') ?>
                                    <?php regField('Telepon', $pr->phone ?? '', 'col-md-4') ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-card-note">Belum ada data penanggung jawab.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <!-- Tujuan Berobat -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fa fa-hospital-o"></i> Tujuan Berobat
                        </div>
                        <div class="form-card-body">
                            <div class="row">
                                <?php regField('No Registrasi', $registration->registration_no ?? '', 'col-md-4') ?>
                                <?php regField('Tanggal Masuk', formatDateView($registration->registration_date ?? null), 'col-md-4') ?>
                                <?php regField('Jam Masuk', formatTimeView($registration->admission_time ?? null), 'col-md-4') ?>

                                <?php regFieldRaw(
                                    'Pelayanan',
                                    '<span class="badge-pill ' . ($serviceClass[$registration->service_type ?? ''] ?? 'badge-gray') . '">'
                                        . h($serviceLabels[$registration->service_type ?? ''] ?? ($registration->service_type ?? '-'))
                                        . '</span>',
                                    'col-md-12'
                                ) ?>

                                <?php if (($registration->service_type ?? '') !== 'rawat_inap'): ?>
                                    <?php regField('Poli / Unit', $registration->polyclinic_name ?? '', 'col-md-4') ?>
                                    <?php regField('Ruang', $registration->room_name ?? '', 'col-md-4') ?>
                                    <?php regField('Nomor Antri', $registration->queue_no ?? ($registration->queue_number ?? ''), 'col-md-4') ?>
                                <?php else: ?>
                                    <?php regField('Ruangan', $room->room_name ?? '', 'col-md-4') ?>
                                    <?php regField('Bed / Kamar', $bed ? trim(($bed->name ?? '') . (!empty($bed->bed_no) ? ' (' . $bed->bed_no . ')' : '')) : '', 'col-md-4') ?>
                                    <?php regField('Kelas', $registration->class_name ?? '', 'col-md-4') ?>
                                <?php endif; ?>

                                <?php regField('Dokter', $doctor->doctor_name ?? '', 'col-md-6') ?>
                                <?php regField('Proses Masuk', $registration->entry_process ?? '', 'col-md-3') ?>
                                <?php regField('Cara Masuk', $registration->entry_method ?? '', 'col-md-3') ?>
                            </div>
                        </div>
                    </div>

                    <!-- Cara Bayar -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fa fa-credit-card"></i> Cara Bayar
                        </div>
                        <div class="form-card-body">
                            <div class="row">
                                <?php regFieldRaw(
                                    'Jenis Pasien',
                                    !empty($registration->payment_method)
                                        ? '<span class="badge-pill badge-orange">' . h($paymentLabels[$registration->payment_method] ?? $registration->payment_method) . '</span>'
                                        : '',
                                    'col-md-4'
                                ) ?>

                                <?php if (($registration->payment_method ?? '') === 'PERORANGAN'): ?>
                                    <?php regField('SKDP/No Kontrol', $registration->skdp_no ?? '', 'col-md-4') ?>
                                    <?php regField('Jenis Referensi', $registration->reference_type ?? '', 'col-md-4') ?>
                                <?php elseif (!empty($registration->payment_method)): ?>
                                    <?php regField('Penjamin', $registration->insurance_type ?? '', 'col-md-4') ?>
                                    <?php regField('Kategori Asuransi', $registration->insurance_category ?? '', 'col-md-4') ?>
                                    <?php regField('Nomor Kartu', $registration->insurance_card_no ?? '', 'col-md-4') ?>
                                    <?php regField('No Rujukan/Kontrol', $registration->refferal_no ?? '', 'col-md-4') ?>
                                    <?php regField('NIK/Bagian', $registration->bpjs_nik ?? '', 'col-md-4') ?>
                                    <?php regField('Nama Peserta', $registration->bpjs_name ?? '', 'col-md-4') ?>
                                    <?php regField('Golongan', $registration->bpjs_group ?? '', 'col-md-4') ?>
                                    <?php regField('Kelas', $registration->bpjs_class ?? '', 'col-md-4') ?>
                                    <?php regField('Jenis', $registration->bpjs_type ?? '', 'col-md-4') ?>
                                    <?php regField('Provider', $registration->provider ?? '', 'col-md-4') ?>
                                <?php endif; ?>

                                <?php regField('Perawatan', $registration->treatment_type ?? 'BIASA', 'col-md-4') ?>
                                <?php if (($registration->treatment_type ?? '') === 'PAKET'): ?>
                                    <?php regField('Paket', $registration->package_name ?? '', 'col-md-8') ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Perujuk Pasien -->
                    <?php if (!empty($registration->referral_type) && $registration->referral_type !== 'None'): ?>
                        <div class="form-card">
                            <div class="form-card-header">
                                <i class="fa fa-clipboard"></i> Perujuk Pasien
                            </div>
                            <div class="form-card-body">
                                <div class="row">
                                    <?php regField('Rujukan', $registration->referral_type ?? '', 'col-md-4') ?>
                                    <?php regField('Asal Rujuk', $registration->referral_origin ?? '', 'col-md-8') ?>
                                    <?php regField('Dokter Pengirim', $registration->referral_doctor ?? '', 'col-md-6') ?>
                                    <?php regField('Nama Perujuk', $registration->referral_name ?? '', 'col-md-6') ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Info Sistem -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fa fa-info-circle"></i> Info Sistem
                        </div>
                        <div class="form-card-body">
                            <div class="row">
                                <?php regField('ID', $registration->id ?? '', 'col-md-3') ?>
                                <?php regField('Dibuat', formatDateView($registration->created, true), 'col-md-4') ?>
                                <?php regField('Diubah', formatDateView($registration->modified, true), 'col-md-4') ?>
                                <?php if (!empty($registration->delete_log)): ?>
                                    <?php regField('Delete Log', $registration->delete_log, 'col-md-12') ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </fieldset>

    </div>
</div>