<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientLetter $letter
 */

$p = $letter->patient;
$d = $letter->doctor;
$v = $letter->outpatient_visit;

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

$umur = '-';
if (!empty($p->birth_date)) {
    $bd = is_object($p->birth_date) ? $p->birth_date->format('Y-m-d') : $p->birth_date;
    $umur = (new DateTime())->diff(new DateTime($bd))->y . ' Tahun';
}

$jk = ($p->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan';
$sip = $d->sip_number ?? $d->str_number ?? '';

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
<title>Surat Keterangan Sakit — <?= h($letter->letter_no ?? '') ?></title>
<style>
    @page { size: A5; margin: 16mm 16mm; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #1a1a1a; padding-left: 6mm; padding-right: 6mm; box-sizing: border-box; }

    /* dompdf tidak dukung flexbox — pakai table untuk letterhead */
    table.letterhead { width: 100%; border-collapse: collapse; border-bottom: 2px solid #1e3a5f; padding-bottom: 6px; margin-bottom: 10px; margin-top: 10px; }
    table.letterhead td { vertical-align: middle; padding-bottom: 8px; }
    table.letterhead .logo-cell { width: 60px; }
    table.letterhead .logo-cell img { width: 50px; height: auto; }
    table.letterhead .hospital-name { font-size: 15px; font-weight: 700; color: #1e3a5f; line-height: 1.2; }
    table.letterhead .hospital-addr { font-size: 9.5px; color: #555; line-height: 1.35; }

    h1.title { text-align: center; font-size: 14px; text-decoration: underline; margin: 10px 0 2px; letter-spacing: .5px; }
    .no-surat { text-align: center; font-size: 11px; margin-bottom: 14px; }
    table.bio { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    table.bio td { padding: 2px 0; vertical-align: top; font-size: 12px; }
    table.bio td.label { width: 130px; }
    table.bio td.colon { width: 12px; }
    .vitals { width: 100%; border-collapse: collapse; margin: 8px 0 12px; }
    .vitals td { padding: 2px 0; font-size: 12px; }
    .vitals td.label { width: 130px; }
    .vitals td.colon { width: 12px; }
    p.statement { text-align: justify; margin: 10px 0; line-height: 1.5; }
    .diagnosis-box { margin: 8px 0; font-size: 12px; }
    .footer { margin-top: 26px; width: 100%; }
    .footer .place-date { margin-left: 335px; margin-bottom: 4px; }
    .footer .sign-block { float: right; text-align: center; width: 220px; }
    .footer .sign-space { height: 55px; }
    .footer .doctor-name { font-weight: 700; text-decoration: underline; }
    .clear { clear: both; }
    .isisurat {margin-left: 30px; margin-bottom: 10px;}
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

    <h1 class="title">SURAT KETERANGAN SAKIT</h1>
    <div class="no-surat">Nomor : <?= h($letter->letter_no ?? '-') ?></div>

    <div class="isisurat">
    <p>Yang bertanda tangan dibawah ini menerangkan bahwa :</p>

    <table class="bio">
        <tr>
            <td class="label">Nama</td><td class="colon">:</td>
            <td><?= h($p->full_name ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin / Umur</td><td class="colon">:</td>
            <td><?= h($jk) ?> / <?= h($umur) ?></td>
        </tr>
        <tr>
            <td class="label">Alamat</td><td class="colon">:</td>
            <td><?= h($p->address ?? '-') ?></td>
        </tr>
    </table>

    <table class="vitals">
        <tr>
            <td class="label">Tinggi Badan</td><td class="colon">:</td>
            <td><?= $letter->height !== null && $letter->height !== '' ? h($letter->height) . ' cm' : '-' ?></td>
        </tr>
        <tr>
            <td class="label">Berat Badan</td><td class="colon">:</td>
            <td><?= $letter->weight !== null && $letter->weight !== '' ? h($letter->weight) . ' kg' : '-' ?></td>
        </tr>
        <tr>
            <td class="label">Suhu Tubuh</td><td class="colon">:</td>
            <td><?= $letter->temperature !== null && $letter->temperature !== '' ? h($letter->temperature) . ' °C' : '-' ?></td>
        </tr>
    </table>
    </div>

    <?php if (!empty($letter->diagnosis)): ?>
        <div class="diagnosis-box">
            <strong>Diagnosa Sakit</strong> : <?= h($letter->diagnosis) ?>
        </div>
    <?php endif; ?>

    <p class="statement">
        Berhubung dengan penyakitnya maka yang bersangkutan memerlukan istirahat selama
        <strong><?= (int)($letter->leave_days ?? 0) ?> hari</strong>,
        terhitung mulai tanggal <strong><?= $fmtTgl($letter->leave_from) ?></strong>
        sampai dengan tanggal <strong><?= $fmtTgl($letter->leave_to) ?></strong>.
    </p>

    <p>Demikian, surat keterangan ini dipergunakan seperlunya untuk kepentingan yang bersangkutan.</p>
    

    <div class="footer">
        <div class="place-date">Surabaya, <?= $fmtTgl($letter->examined_at ?? date('Y-m-d')) ?></div>
        <div class="sign-block">
            Dokter Pemeriksa,
            <div class="sign-space"></div>
            <div class="doctor-name">( <?= h($d->doctor_name ?? '-') ?>, dr. )</div>
            <?php if ($sip !== ''): ?>
                <div>SIP: <?= h($sip) ?></div>
            <?php endif; ?>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>