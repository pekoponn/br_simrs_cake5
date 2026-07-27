<?php
$patient = $letter->patient ?? null;
$visit = $letter->outpatient_visit ?? null;
$doctor = $letter->doctor ?? null;

$birthDate = '-';
if (!empty($patient->birth_date)) {
    $birthDate = is_object($patient->birth_date) ? $patient->birth_date->format('d-m-Y') : (string)$patient->birth_date;
}

$gender = '-';
if (($patient->gender ?? '') === 'Male') {
    $gender = 'Pria';
} elseif (($patient->gender ?? '') === 'Female') {
    $gender = 'Wanita';
} elseif (!empty($patient->gender)) {
    $gender = (string)$patient->gender;
}

$visitDate = '-';
if (!empty($visit->visit_date)) {
    $visitDate = is_object($visit->visit_date) ? $visit->visit_date->format('d-m-Y') : (string)$visit->visit_date;
}

$visitTime = !empty($visit->visit_time) ? substr((string)$visit->visit_time, 0, 8) : '-';
$logoPath = WWW_ROOT . 'img' . DS . 'logo_br1.png';
?>

<style>
    body {
        font-family: "Courier New", Courier, monospace;
        color: #1f1f1f;
        font-size: 13px;
    }
    .print-page {
        width: 190mm;
        min-height: 270mm;
        margin: 8mm auto;
        padding: 0;
    }
    .kop {
        display: table;
        width: 100%;
        border-bottom: 2px solid #333;
        padding-bottom: 5px;
        margin-bottom: 5px;
    }
    .kop-left,
    .kop-right {
        display: table-cell;
        vertical-align: top;
    }
    .kop-left {
        width: 58%;
    }
    .kop-right {
        width: 42%;
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.35;
        padding-top: 4px;
    }
    .logo {
        float: left;
        width: 88px;
        margin-right: 12px;
    }
    .rs-name {
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
        font-weight: bold;
        color: #000000;
        line-height: 1.05;
        padding-top: 15px;
    }
    .rs-city {
        font-family: Arial, sans-serif;
        font-size: 22px;
        font-weight: bold;
        color: #000000;
    }
    .title {
        text-align: center;
        font-size: 19px;
        font-weight: bold;
        text-decoration: underline;
        margin: 8px 0 10px;
    }
    .meta {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
    }
    .meta td {
        padding: 2px 4px;
        vertical-align: top;
    }
    .label {
        width: 170px;
        font-weight: bold;
    }
    .sep {
        width: 12px;
    }
    .print-count {
        text-align: right;
        font-style: italic;
        font-weight: bold;
    }
    .box {
        border: 1px solid #333;
        padding: 8px 10px;
        min-height: 70px;
        white-space: pre-wrap;
        line-height: 1.45;
        margin-bottom: 10px;
    }
    .section-title {
        font-weight: bold;
        margin: 10px 0 3px;
    }
    .signature {
        width: 240px;
        margin-left: auto;
        margin-top: 26px;
        text-align: center;
        line-height: 1.5;
    }
    .signature-space {
        height: 58px;
    }
</style>

<div class="print-page">
    <div class="kop">
        <div class="kop-left">
            <?php if (is_file($logoPath)): ?>
                <img src="<?= h($this->Url->image('logo_br1.png')) ?>" class="logo" alt="RSU Bhakti Rahayu">
            <?php endif; ?>
            <div class="rs-name">RSU BHAKTI RAHAYU</div>
            <div class="rs-city">Surabaya</div>
        </div>
        <div class="kop-right">
            Jl. Ketintang Madya I No.16, Ketintang,<br>
            Gayungan, Kota Surabaya, Jawa Timur 60232<br>
            Telp/Fax: 0318295922 / 0318291799<br>
            Web: https://rsubhaktirahayusurabaya.com<br>
            E-Mail: rsubhaktirahayu.sby@gmail.com
        </div>
    </div>

    <div class="title">SURAT JAWABAN KONSULTASI</div>

    <table class="meta">
        <tr>
            <td class="label">No. Surat</td>
            <td class="sep">:</td>
            <td><?= h($letter->letter_no ?? '-') ?></td>
            <!-- <td class="print-count">Cetak Ke : 1</td> -->
        </tr>
        <tr>
            <td class="label">No. RM</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($patient->code ?? $patient->medical_record_no ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($patient->full_name ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Tanggal Lahir</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($birthDate) ?></td>
            <!-- <?= h($patient->birth_place ?? '-') ?> /  -->
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($gender) ?></td>
        </tr>
        <tr>
            <td class="label">Alamat Pasien</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($patient->address ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Kab / Kota</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($patient->city ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Poliklinik</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($visit->polyclinic_name ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Tanggal Kunjungan</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($visitDate) ?> <?= h($visitTime) ?></td>
        </tr>
        <tr>
            <td class="label">Dokter</td>
            <td class="sep">:</td>
            <td colspan="2"><?= h($doctor->doctor_name ?? '-') ?></td>
        </tr>
    </table>

    <div class="section-title">DIAGNOSA ICD X</div>
    <div class="box"><?= h($letter->diagnosis ?: '-') ?></div>

    <div class="section-title">KETERANGAN KONSULTASI</div>
    <div class="box"><?= h($letter->notes ?: '-') ?></div>

    <div class="section-title">SARAN / JAWABAN KONSULTASI</div>
    <div class="box"><?= h($letter->consultation_answer ?: '-') ?></div>

    <div class="signature">
        Surabaya, <?= h(date('d-m-Y')) ?><br>
        Dokter Pemeriksa,
        <div class="signature-space"></div>
        <strong><?= h($doctor->doctor_name ?? '-') ?></strong>
    </div>
</div>
