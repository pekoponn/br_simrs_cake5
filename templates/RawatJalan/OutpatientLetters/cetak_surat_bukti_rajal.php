<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientLetter $letter
 * @var \App\Model\Entity\Doctor|null $dischargedByDoctor
 * @var \App\Model\Entity\Doctor|null $completingDoctor
 * @var \App\Model\Entity\OutpatientVisitEmr|null $emr
 * @var string $noRekamMedis
 */

$p = $letter->patient;
$v = $letter->outpatient_visit ?? null;
$d = $letter->doctor;

$bulanId = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
];
$fmtTgl = function ($value) use ($bulanId) {
    if (empty($value)) {
        return '-';
    }
    $ts = is_object($value) ? $value->getTimestamp() : strtotime((string)$value);
    if (!$ts) {
        return '-';
    }
    return (int)date('d', $ts) . ' ' . $bulanId[(int)date('n', $ts)] . ' ' . date('Y', $ts);
};
$fmtTglSingkat = function ($value) {
    if (empty($value)) return '-';
    $ts = is_object($value) ? $value->getTimestamp() : strtotime((string)$value);
    return $ts ? date('d-m-Y', $ts) : '-';
};

$jk = ($p->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan';
$jamKunjungan = $v && !empty($v->visit_time) ? substr((string)$v->visit_time, 0, 5) : '';

if (!isset($icd10Lookup) || !is_array($icd10Lookup)) {
    $icd10Lookup = [];
}
if (!isset($icd9Lookup) || !is_array($icd9Lookup)) {
    $icd9Lookup = [];
}
if (!isset($ensureCode) || !is_callable($ensureCode)) {
    $ensureCode = function ($line, $lookup) {
        return trim((string)$line);
    };
}

$diagnosaUtamaText = $ensureCode($letter->diagnosis_primary_text ?? '', $icd10Lookup);
$tindakanUtamaText = $ensureCode($letter->action_primary_text ?? '', $icd9Lookup);

$diagnosaSekunderList = array_filter(array_map(
    fn($line) => $ensureCode($line, $icd10Lookup),
    array_map('trim', explode("\n", (string)($letter->diagnosis_secondary_text ?? '')))
));
$tindakanSekunderList = array_filter(array_map(
    fn($line) => $ensureCode($line, $icd9Lookup),
    array_map('trim', explode("\n", (string)($letter->action_secondary_text ?? '')))
));

$baris1 = [];
$baris1[] = 'KU: ' . '-';
$baris1[] = 'GCS: ' . '-';
if (!empty($emr->blood_pressure))    $baris1[] = 'TD: ' . h($emr->blood_pressure);
if (!empty($emr->pulse))             $baris1[] = 'HR: ' . h($emr->pulse) . 'X/I';
if (!empty($emr->respiratory_rate))  $baris1[] = 'RR: ' . h($emr->respiratory_rate) . 'X/I';
if (!empty($emr->temperature))       $baris1[] = 'T: ' . h($emr->temperature);
if (!empty($emr->oxygen_saturation)) $baris1[] = 'SPO2: ' . h($emr->oxygen_saturation) . '%';
$baris1Text = implode(', ', $baris1);

$baris2 = [];
if ($emr && $emr->pain_scale !== null && $emr->pain_scale !== '') {
    $baris2[] = 'VAS: ' . h($emr->pain_scale) . '/10';
}
if (!empty($emr->weight)) $baris2[] = 'BB: ' . h($emr->weight) . ' kg';
$baris2Text = implode(', ', $baris2);

$baris3 = 'KEP : -';
$baris4 = 'TRX : -';
$baris5 = 'ABD : -'; 
$baris6 = 'EKS : -';  

$giziParts = [];
if (!empty($emr->height)) $giziParts[] = 'TB ' . h($emr->height) . 'Cm';
if (!empty($emr->weight)) $giziParts[] = 'BB ' . h($emr->weight) . ' kg';
if (!empty($emr->bmi)) {
    $bmiVal = (float)$emr->bmi;
    $bmiCategory = $bmiVal < 18.5 ? 'Underweight'
        : ($bmiVal < 25.0 ? 'NormalWeight'
        : ($bmiVal < 30.0 ? 'Overweight'
        : 'Obese'));
    $giziParts[] = 'Bmi ' . number_format($bmiVal, 0) . ' ' . $bmiCategory;
}
$giziLine = implode(' ', $giziParts);

$pemeriksaanFisikText = trim(
    $baris1Text
    . ($baris2Text ? "\n" . $baris2Text : '')
    . "\n" . $baris3
    . "\n" . $baris4
    . "\n" . $baris5
    . "\n" . $baris6
    . ($giziLine ? "\n\n" . $giziLine : '')
);

$specialActions = !empty($letter->special_actions) ? (json_decode($letter->special_actions, true) ?: []) : [];

$hospitalLogoPath = WWW_ROOT . 'img' . DS . 'logo_br1.png';
$hospitalLogoExists = is_file($hospitalLogoPath);
$hospitalLogoDataUri = null;
if ($hospitalLogoExists) {
    $imgData = @file_get_contents($hospitalLogoPath);
    if ($imgData !== false) {
        $hospitalLogoDataUri = 'data:image/png;base64,' . base64_encode($imgData);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Bukti Pelayanan Kesehatan — <?= h($letter->letter_no ?? '') ?></title>
<style>
   @page { size: A5; margin: 16mm 16mm; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #1a1a1a; padding-left: 4mm; padding-right: 4mm; padding-top: 4mm; box-sizing: border-box; }

    /* dompdf tidak dukung flexbox — pakai table untuk letterhead */
    table.letterhead { width: 100%; border-collapse: collapse; border-bottom: 2px solid #1e3a5f; padding-bottom: 6px; margin-bottom: 10px; margin-top: 4px; }
    table.letterhead td { vertical-align: middle; padding-bottom: 8px; }
    table.letterhead .logo-cell { width: 65px; }
    table.letterhead .logo-cell img { width: 55px; height: auto; }
    table.letterhead .hospital-name { font-size: 16px; font-weight: 700; color: #1e3a5f; line-height: 1.2; }
    table.letterhead .hospital-addr { font-size: 9.5px; color: #555; line-height: 1.35; }

    h1.title { text-align: center; font-size: 14px; text-decoration: underline; margin: 8px 0 2px; letter-spacing: .5px; }
    .no-surat { text-align: center; font-size: 11px; margin-bottom: 12px; }
    .cetak-ke { text-align: right; font-size: 10px; margin-bottom: -6px; }

    table.bio { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    table.bio td { padding: 2px 0; vertical-align: top; font-size: 11px; }
    table.bio td.label { width: 130px; }
    table.bio td.colon { width: 12px; }
    table.bio td.label2 { width: 130px; padding-left: 20px; }

    table.isi { width: 100%; border-collapse: collapse; margin-top: 6px; }
    table.isi td.section-label {
        width: 150px; font-weight: 700; vertical-align: top;
        padding: 6px 8px 6px 0; border-top: 1px solid #ccc; font-size: 11px;
    }
    table.isi td.section-value {
        vertical-align: top; padding: 6px 0 6px 8px;
        border-top: 1px solid #ccc; border-left: 1px solid #ccc; font-size: 11px;
    }
    ul.plain { margin: 0; padding: 0; list-style: none; }
    ul.plain li { margin-bottom: 2px; }

    .footer { margin-top: 30px; width: 100%; }
    .footer table.ttd { width: 100%; border-collapse: collapse; }
    .footer table.ttd td { width: 50%; text-align: center; font-size: 11px; vertical-align: top; }
    .sign-space { height: 65px; }
    .doctor-name { font-weight: 700; text-decoration: underline; }
</style>
</head>
<body>

    <table class="letterhead">
        <tr>
            <td class="logo-cell">
                <?php if ($hospitalLogoDataUri): ?>
                    <img src="<?= h($hospitalLogoDataUri) ?>" alt="">
                <?php endif; ?>
            </td>
            <td>
                <div class="hospital-name">RSU BHAKTI RAHAYU</div>
                <div class="hospital-addr">
                    Jl. Kebonsari Raya No.1, Kebonsari, Kec. Jambangan, Surabaya, Jawa Timur 60232<br>
                    Telp: (031) 8282922 &nbsp;|&nbsp; Email: rsubhaktirahayu.sby@gmail.com
                </div>
            </td>
        </tr>
    </table>

    <h1 class="title">SURAT BUKTI PELAYANAN KESEHATAN</h1>
    <div class="no-surat">Nomor : <?= h($letter->letter_no ?? '-') ?></div>

    <table class="bio">
        <tr>
            <td class="label">No. Registrasi</td><td class="colon">:</td>
            <td><?= h($v->registration_no ?? '-') ?></td>
            <td class="label2">No. RM</td><td class="colon">:</td>
            <td><?= h($noRekamMedis) ?></td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td><td class="colon">:</td>
            <td><?= h($p->full_name ?? '-') ?></td>
            <td class="label2">Poliklinik</td><td class="colon">:</td>
            <td><?= h($v->polyclinic_name ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td><td class="colon">:</td>
            <td><?= h($jk) ?></td>
            <td class="label2">Tanggal Kunjungan</td><td class="colon">:</td>
            <td>
                <?= $v && !empty($v->visit_date) ? h($fmtTglSingkat($v->visit_date)) : '-' ?>
                <?= $jamKunjungan ? ' ' . h($jamKunjungan) : '' ?>
            </td>
        </tr>
        <tr>
            <td class="label">Alamat</td><td class="colon">:</td>
            <td colspan="4"><?= h($p->address ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Dokter</td><td class="colon">:</td>
            <td colspan="4"><?= h($d->doctor_name ?? '-') ?></td>
        </tr>
    </table>

    <table class="isi">
        <tr>
            <td class="section-label">ANAMNESA</td>
            <td class="section-value"><?= nl2br(h($letter->anamnesa ?: '-')) ?></td>
        </tr>
        <tr>
            <td class="section-label">PEMERIKSAAN FISIK</td>
            <td class="section-value" style="white-space:pre-line;"><?= h($pemeriksaanFisikText) ?: '-' ?></td>
        </tr>
        <tr>
            <td class="section-label">DIAGNOSA UTAMA</td>
            <td class="section-value"><?= h($diagnosaUtamaText ?: '-') ?></td>
        </tr>
        <tr>
            <td class="section-label">DIAGNOSA SEKUNDER</td>
            <td class="section-value">
                <?php if (!empty($diagnosaSekunderList)): ?>
                    <ul class="plain">
                        <?php foreach ($diagnosaSekunderList as $line): ?>
                            <li><?= h($line) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>-<?php endif; ?>
            </td>
        </tr>
        <tr>
            <td class="section-label">TINDAKAN UTAMA</td>
            <td class="section-value"><?= h($tindakanUtamaText ?: '-') ?></td>
        </tr>
        <tr>
            <td class="section-label">TINDAKAN SEKUNDER</td>
            <td class="section-value">
                <?php if (!empty($tindakanSekunderList)): ?>
                    <ul class="plain">
                        <?php foreach ($tindakanSekunderList as $line): ?>
                            <li><?= h($line) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>-<?php endif; ?>
            </td>
        </tr>
        <tr>
            <td class="section-label">PENUNJANG DIAGNOSA</td>
            <td class="section-value"><?= nl2br(h($letter->supporting_diagnosis ?: '-')) ?></td>
        </tr>
        <?php if (!empty($specialActions)): ?>
        <tr>
            <td class="section-label">TINDAKAN KHUSUS</td>
            <td class="section-value"><?= h(implode(', ', $specialActions)) ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td class="section-label">RESEP</td>
            <td class="section-value"><?= nl2br(h($letter->prescription ?: '-')) ?></td>
        </tr>
        <tr>
            <td class="section-label">SARAN / ANJURAN</td>
            <td class="section-value"><?= nl2br(h($letter->advice_notes ?: '-')) ?></td>
        </tr>
    </table>

    <div class="footer">
        <table class="ttd">
            <tr>
                <td>
                    Dipulangkan oleh,
                    <div class="sign-space"></div>
                    <div class="doctor-name">( <?= h($dischargedByDoctor->doctor_name ?? '...........................') ?> )</div>
                </td>
                <td>
                    Dokter yang Melengkapi,
                    <div class="sign-space"></div>
                    <div class="doctor-name">( <?= h($completingDoctor->doctor_name ?? '...........................') ?> )</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>