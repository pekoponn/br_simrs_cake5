<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientLetter $letter
 * @var \App\Model\Entity\OutpatientVisit $visit
 */
$p = $letter->patient ?? $visit->patient ?? null;
$d = $letter->doctor ?? $visit->doctor ?? null;
$v = $letter->outpatient_visit ?? $visit;

$umur = '-';
if (!empty($p->birth_date)) {
    $bd = is_object($p->birth_date) ? $p->birth_date->format('Y-m-d') : $p->birth_date;
    $diff = (new DateTime())->diff(new DateTime($bd));
    $umur = $diff->y . ' Tahun';
}

$tglSurat = !empty($letter->created)
    ? (is_object($letter->created) ? $letter->created->format('d-m-Y') : date('d-m-Y'))
    : date('d-m-Y');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pengantar Rawat Inap - <?= h($letter->letter_no) ?></title>
    <style>
        @page { size: A4; margin: 20mm 18mm; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
            line-height: 1.5;
        }
        .kop {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 8px;
            margin-bottom: 14px;
        }
        .kop img { height: 60px; margin-right: 14px; }
        .kop .nama-rs { font-size: 18px; font-weight: 700; color: #1e3a5f; margin: 0; }
        .kop .alamat-rs { font-size: 11px; color: #444; margin: 2px 0 0; }

        .judul {
            text-align: center;
            margin: 10px 0 4px;
        }
        .judul h3 {
            text-decoration: underline;
            font-size: 14px;
            margin: 0;
            text-transform: uppercase;
        }
        .judul .no-surat { font-size: 11px; margin-top: 2px; }

        .pembuka { margin: 16px 0 10px; text-align: justify; }

        table.identitas {
            width: 100%;
            margin: 10px 0 14px;
            font-size: 12px;
        }
        table.identitas td { padding: 2px 0; vertical-align: top; }
        table.identitas td.label { width: 160px; }
        table.identitas td.titik { width: 14px; }

        .diagnosis-box {
            border: 1px solid #999;
            padding: 8px 10px;
            margin: 10px 0;
            background: #f8f9fa;
        }
        .diagnosis-box .label {
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            color: #1e3a5f;
            margin-bottom: 4px;
        }

        .penutup { margin: 14px 0; text-align: justify; }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }
        .ttd .kanan {
            float: right;
            text-align: center;
            width: 240px;
        }
        .ttd .kanan .ruang-ttd { height: 60px; }
        .ttd .kanan .nama-dokter { font-weight: 700; text-decoration: underline; }

        .footer-note {
            clear: both;
            margin-top: 50px;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 6px;
        }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="kop">
        <div>
            <p class="nama-rs">RUMAH SAKIT [NAMA RUMAH SAKIT]</p>
            <p class="alamat-rs">
                Jl. [Alamat Rumah Sakit], [Kota] — Telp. [No. Telp] — Email: [email]
            </p>
        </div>
    </div>

    <div class="judul">
        <h3>Surat Pengantar Rawat Inap</h3>
        <div class="no-surat">No: <?= h($letter->letter_no) ?></div>
    </div>

    <div class="pembuka">
        Yang bertanda tangan di bawah ini, dokter yang bertugas di
        <?= h($v->polyclinic_name ?? '-') ?>, dengan ini menerangkan bahwa pasien berikut
        perlu menjalani perawatan rawat inap:
    </div>

    <table class="identitas">
        <tr>
            <td class="label">No. Rekam Medis</td><td class="titik">:</td>
            <td><?= h($p->code ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td><td class="titik">:</td>
            <td><strong><?= h($p->full_name ?? '-') ?></strong></td>
        </tr>
        <tr>
            <td class="label">Tanggal Lahir / Umur</td><td class="titik">:</td>
            <td>
                <?= !empty($p->birth_date)
                    ? (is_object($p->birth_date) ? $p->birth_date->format('d-m-Y') : h($p->birth_date))
                    : '-' ?>
                / <?= h($umur) ?>
            </td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td><td class="titik">:</td>
            <td><?= ($p->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan' ?></td>
        </tr>
        <tr>
            <td class="label">Alamat</td><td class="titik">:</td>
            <td><?= h($p->address ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">No. Registrasi</td><td class="titik">:</td>
            <td><?= h($v->registration_no ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Jaminan</td><td class="titik">:</td>
            <td><?= h($v->insurance_type ?? 'Umum') ?></td>
        </tr>
    </table>

    <div class="diagnosis-box">
        <div class="label">Diagnosis</div>
        <div><?= nl2br(h($letter->diagnosis ?? $v->diagnosis_primary ?? '-')) ?></div>
    </div>

    <div class="diagnosis-box">
        <div class="label">Alasan Rujukan Rawat Inap</div>
        <div><?= nl2br(h($letter->notes ?? '-')) ?></div>
    </div>

    <div class="penutup">
        Mohon kiranya pasien tersebut di atas dapat diterima untuk mendapatkan perawatan
        dan penanganan lebih lanjut sesuai indikasi medis. Atas perhatian dan kerja samanya,
        kami ucapkan terima kasih.
    </div>

    <div class="ttd">
        <div class="kanan">
            <div>[Kota], <?= h($tglSurat) ?></div>
            <div>Dokter Pemeriksa,</div>
            <div class="ruang-ttd"></div>
            <div class="nama-dokter"><?= h($d->doctor_name ?? '-') ?></div>
        </div>
    </div>

    <div class="footer-note">
        Dicetak melalui sistem SIMRS pada <?= date('d-m-Y H:i') ?>. Surat ini sah tanpa
        cap dan tanda tangan basah untuk keperluan administratif internal, kecuali diminta
        sebaliknya oleh pihak terkait.
    </div>

</body>
</html>