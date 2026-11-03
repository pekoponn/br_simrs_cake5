<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientLetter $letter
 */

$p = $letter->patient;
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
$fmtTglSlash = function ($value) {
    if (empty($value)) {
        return '-';
    }
    $ts = is_object($value) ? $value->getTimestamp() : strtotime((string)$value);
    return $ts ? date('d-m-Y', $ts) : '-';
};

$jk = ($p->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan';
$sip = $d->sip_number ?? $d->str_number ?? '';

$patientNameDisplay = mb_convert_case((string)($p->full_name ?? '-'), MB_CASE_TITLE, 'UTF-8');

$refDoctorNameRaw = trim((string)($letter->referral_doctor_name ?? ($d->doctor_name ?? '-')));
$refDoctorName = preg_replace('/^dr\.?\s*/i', '', $refDoctorNameRaw);

if (!empty($letter->referral_doctor_specialist)) {
    $refDoctorName = preg_replace('/,\s*.*$/', '', $refDoctorName);
}

$refDoctorName = trim($refDoctorName);
$refDoctorName = mb_convert_case($refDoctorName, MB_CASE_TITLE, 'UTF-8');

$bpjsLogoPath = WWW_ROOT . 'img' . DS . 'bpjs-logo.png';
$bpjsLogoExists = is_file($bpjsLogoPath);
$bpjsLogoDataUri = null;
if ($bpjsLogoExists) {
    $imgData = @file_get_contents($bpjsLogoPath);
    if ($imgData !== false) {
        $bpjsLogoDataUri = 'data:image/png;base64,' . base64_encode($imgData);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Rencana Kontrol — <?= h($letter->letter_no ?? '') ?></title>
<style>
    @page { size: A5; margin: 14mm 16mm; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #1a1a1a; padding-left: 5mm; box-sizing: border-box; }

    table.header { width: 100%; border-collapse: collapse; border-bottom: 1px solid #000; margin-bottom: 12px; padding-right: 8mm; box-sizing: border-box; }
    table.header td { vertical-align: middle; padding-bottom: 8px; }
    table.header .brand-cell { width: 150px; vertical-align: middle; }
    table.header .brand-cell img { margin-top: 10px; width: 160px; height: auto; }
    table.header .no-surat-cell { text-align: right; font-size: 11px; white-space: nowrap; vertical-align: middle; padding-right: 2mm; }
    .header-title-wrap { text-align: center; margin-top: -6px; margin-bottom: 12px; }
    .header-title-wrap .judul { font-size: 14px; font-weight: 700; margin-top: 2px; }
    .header-title-wrap .rs { font-size: 12px; font-weight: 700; }

    table.bio { width: 100%; border-collapse: collapse; margin: 10px 0; }
    table.bio td { padding: 2px 0; vertical-align: top; font-size: 12px; }
    table.bio td.label { width: 140px; }
    table.bio td.colon { width: 12px; }

    p.statement { margin: 10px 0; line-height: 1.5; }

    .footer { margin-top: 10px; width: 100%; padding-right: 15px; box-sizing: border-box; }
    .footer .place-date { margin-left: 355px; margin-bottom: 2px; }
    .footer .sign-block { float: right; text-align: center; width: 220px; }
    .footer .sign-space { height: 70px; }
    .footer .doctor-name { font-weight: 700; text-decoration: underline; }
    .clear { clear: both; }
    .print-meta { margin-top: 40px; font-size: 9px; color: #888; }
</style>
</head>
<body>

    <table class="header">
        <tr>
            <td class="brand-cell">
                <?php if ($bpjsLogoDataUri): ?>
                    <img src="<?= h($bpjsLogoDataUri) ?>" alt="">
                <?php endif; ?>
            </td>
            <td class="no-surat-cell">No. <?= h($letter->letter_no ?? '-') ?></td>
        </tr>
    </table>

    <div class="header-title-wrap">
        <div class="judul">SURAT RENCANA KONTROL</div>
        <div class="rs">RS BHAKTI RAHAYU</div>
    </div>
    <table class="bio">
        <tr>
            <td class="label">Kepada Yth</td><td class="colon">:</td>
            <td>dr. <?= h($refDoctorName) ?></td>
        </tr>
        <?php if (!empty($letter->referral_doctor_specialist)): ?>
        <tr>
            <td class="label"></td><td class="colon"></td>
            <td>Sp./Sub. <?= h($letter->referral_doctor_specialist) ?></td>
        </tr>
        <?php endif; ?>
    </table>

    <p class="statement">Mohon Pemeriksaan dan Penanganan Lebih Lanjut :</p>

    <table class="bio">
        <tr>
            <td class="label">No. Kartu</td><td class="colon">:</td>
            <td><?= h($letter->bpjs_card_no ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Nama Peserta</td><td class="colon">:</td>
            <td><?= h($patientNameDisplay) ?> (<?= h($jk) ?>)</td>
        </tr>
        <tr>
            <td class="label">Tgl. Lahir</td><td class="colon">:</td>
            <td><?= $fmtTgl($p->birth_date ?? null) ?></td>
        </tr>
        <tr>
            <td class="label">Diagnosa</td><td class="colon">:</td>
            <td><?= h($letter->diagnosis ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Rencana Kontrol</td><td class="colon">:</td>
            <td><?= $fmtTgl($letter->leave_from ?? null) ?></td>
        </tr>
    </table>

    <p class="statement">Demikian atas bantuannya, diucapkan banyak terima kasih.</p>

    <div class="footer">
        <div class="place-date">Surabaya, <?= $fmtTgl($letter->examined_at ?? date('Y-m-d')) ?></div>
        <div class="sign-block">
            Mengetahui DPJP,
            <div class="sign-space"></div>
            <div class="doctor-name">( <?= h($d->doctor_name ?? '-') ?>, dr. )</div>
            <?php if ($sip !== ''): ?>
                <div>SIP: <?= h($sip) ?></div>
            <?php endif; ?>
        </div>
        <div class="clear"></div>
    </div>

    <div class="print-meta">
        Tgl.Entri: <?= $letter->created ? $fmtTglSlash($letter->created) . ' ' . $letter->created->format('h:i A') : '-' ?>
        &nbsp;|&nbsp;
        Tgl.Cetak: <?= date('d-m-Y h:i A') ?>
    </div>

</body>
</html>