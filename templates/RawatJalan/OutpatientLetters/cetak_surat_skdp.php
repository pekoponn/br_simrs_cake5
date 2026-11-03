<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientLetter $letter
 * @var string $noRekamMedis
 */
$p = $letter->patient;
$d = $letter->doctor;
$v = $letter->outpatient_visit;

$namaPasien = trim((($p->title ?? '') !== '' ? $p->title . ' ' : '') . ($p->full_name ?? '-'));
$jk         = ($p->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan';

function skdpFmtTgl($val): string
{
    if (empty($val)) {
        return '-';
    }
    $s = is_object($val) && method_exists($val, 'format') ? $val->format('Y-m-d') : (string)$val;
    try {
        return (new DateTime($s))->format('d-m-Y');
    } catch (\Throwable $e) {
        return '-';
    }
}

$tglLahir = skdpFmtTgl($p->birth_date ?? null);
$umur     = '-';
if (!empty($p->birth_date)) {
    $bd   = is_object($p->birth_date) ? $p->birth_date->format('Y-m-d') : (string)$p->birth_date;
    $umur = (new DateTime())->diff(new DateTime($bd))->y . ' Tahun';
}

$tglPeriksa = !empty($v->visit_date)
    ? skdpFmtTgl($v->visit_date)
    : skdpFmtTgl($letter->examined_at ?? null);

$hospitalLogoPath = WWW_ROOT . 'img' . DS . 'logo_br2.png';
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
<title>Surat SKDP — <?= h($letter->letter_no ?? '') ?></title>
<style>
    @page { size: A5; margin: 16mm 16mm; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #1a1a1a; padding-left: 4mm; padding-right: 4mm; padding-top: 4mm; box-sizing: border-box; }

    table.letterhead { width: 100%; border-collapse: collapse; border-bottom: 2px solid #1e3a5f; padding-bottom: 6px; margin-bottom: 10px; }
    table.letterhead td { vertical-align: middle; padding-bottom: 8px; }
    table.letterhead .logo-cell { width: 55px; }
    table.letterhead .logo-cell img { width: 65px; height: auto; }
    table.letterhead .hospital-name { font-size: 14px; font-weight: 700; color: #1e3a5f; line-height: 1.2; }
    table.letterhead .hospital-addr { font-size: 8.5px; color: #555; line-height: 1.35; }

    h1.title { text-align: center; font-size: 13px; text-decoration: underline; text-transform: uppercase; margin: 8px 0 2px; letter-spacing: .5px; }
    .no-surat { text-align: center; font-size: 10px; margin-bottom: 12px; }

    table.identity { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 11px; }
    table.identity td { padding: 2px 4px; vertical-align: top; }
    table.identity td.lbl { width: 115px; color: #333; }
    table.identity td.sep { width: 10px; }
    table.identity td.val { font-weight: 700; }

    .box { border: 1px solid #333; margin-bottom: 8px; }
    .box .hd { background: #dbeafe; border-bottom: 1px solid #333; padding: 4px 8px; font-weight: 700; font-size: 10px; text-transform: uppercase; color: #1e3a5f; }
    .box .bd { padding: 7px 9px; min-height: 20px; font-size: 11px; white-space: pre-line; line-height: 1.4; }

    table.row2 { width: 100%; border-collapse: separate; border-spacing: 6px 0; margin-bottom: 8px; }
    table.row2 td { width: 50%; vertical-align: top; padding: 0; }
    table.row2 .box { margin-bottom: 0; }

    .footer { margin-top: 24px; width: 100%; }
    .footer .sign-block { float: right; text-align: center; width: 200px; font-size: 11px; }
    .footer .sign-space { height: 80px; }
    .footer .doctor-name { font-weight: 700; text-decoration: underline; }
    .clear { clear: both; }
    .gap { margin-left: 20px;}
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
            <td class="gap">
                <div class="hospital-name">RSU BHAKTI RAHAYU<br>SURABAYA</div>
                <div class="hospital-addr">
                    Jl. Ketintang Madya I No.16, Ketintang, Gayungan, Kota Surabaya, Jawa Timur 60232<br>
                    Telp/Fax: 0318295922 / 0318291799 &nbsp;·&nbsp; rsubhaktirahayusurabaya.com<br>
                    Email: rsubhaktirahayu.sby@gmail.com
                </div>
            </td>
        </tr>
    </table>

    <h1 class="title">Surat Keterangan Dalam Perawatan Spesialis (SKDP)</h1>
    <div class="no-surat">No. <?= h($letter->letter_no ?? '-') ?></div>

    <table class="identity">
        <tr>
            <td class="lbl">No. Rekam Medis</td><td class="sep">:</td><td class="val"><?= h($noRekamMedis) ?></td>
            <td class="lbl">No. Kartu BPJS</td><td class="sep">:</td><td class="val"><?= h($letter->bpjs_card_no ?: '-') ?></td>
        </tr>
        <tr>
            <td class="lbl">Nama Pasien</td><td class="sep">:</td><td class="val"><?= h($namaPasien) ?></td>
            <td class="lbl">Tanggal Periksa</td><td class="sep">:</td><td class="val"><?= h($tglPeriksa) ?></td>
        </tr>
        <tr>
            <td class="lbl">Tgl Lahir / Umur</td><td class="sep">:</td><td class="val"><?= h($tglLahir) ?> / <?= h($umur) ?></td>
            <td class="lbl">Jenis Kelamin</td><td class="sep">:</td><td class="val"><?= h($jk) ?></td>
        </tr>
        <tr>
            <td class="lbl">Dokter Pemeriksa (DPJP)</td><td class="sep">:</td>
            <td class="val" colspan="4">
                <?= h($d->doctor_name ?? '-') ?><?= !empty($d->specialist) ? ' (' . h($d->specialist) . ')' : '' ?>
            </td>
        </tr>
    </table>

    <div class="box">
        <div class="hd">Diagnosa Utama</div>
        <div class="bd"><?= nl2br(h($letter->diagnosis ?: '-')) ?></div>
    </div>

    <div class="box">
        <div class="hd">Terapi</div>
        <div class="bd"><?= nl2br(h($letter->prescription ?: '-')) ?></div>
    </div>

    <div class="box">
        <div class="hd">Alasan Belum Dikembalikan ke Perujuk</div>
        <div class="bd"><?= nl2br(h($letter->notes ?: '-')) ?></div>
    </div>

    <div class="box">
        <div class="hd">Rencana Tindak Lanjut Kunjungan Selanjutnya</div>
        <div class="bd"><?= nl2br(h($letter->advice_notes ?: '-')) ?></div>
    </div>

    <table class="row2">
        <tr>
            <td>
                <div class="box">
                    <div class="hd">Tgl Surat Rujukan / No Rujukan</div>
                    <div class="bd">
                        <?= h(skdpFmtTgl($letter->leave_from ?? null)) ?>
                        <?php if (!empty($letter->referral_doctor_name)): ?>
                            &nbsp;·&nbsp; No: <?= h($letter->referral_doctor_name) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="box">
                    <div class="hd">Alasan Kontrol / Tgl Kembali Kontrol</div>
                    <div class="bd">
                        <?= h($letter->diagnosis_secondary_text ?: '-') ?>
                        &nbsp;·&nbsp; <?= h(skdpFmtTgl($letter->leave_to ?? null)) ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <div class="sign-block">
            Surabaya, <?= h(skdpFmtTgl($letter->examined_at ?? date('Y-m-d'))) ?>
            <div class="sign-space"></div>
            <div class="doctor-name">( <?= h($d->doctor_name ?? '-') ?> )</div>
            <div>Dokter Pemeriksa</div>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>