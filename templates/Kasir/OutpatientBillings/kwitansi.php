<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBilling $billing
 * @var iterable $items
 */
$p = $billing->patient;
$d = $billing->doctor;

$itemsArr = is_array($items) ? $items : iterator_to_array($items);

// ── Terbilang: angka -> teks bahasa Indonesia ──
if (!function_exists('terbilang')) {
    function terbilang(int $angka): string
    {
        $angka = abs($angka);
        $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];

        if ($angka < 12) {
            $hasil = $huruf[$angka];
        } elseif ($angka < 20) {
            $hasil = terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $hasil = terbilang((int)($angka / 10)) . ' Puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = terbilang((int)($angka / 100)) . ' Ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = terbilang((int)($angka / 1000)) . ' Ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = terbilang((int)($angka / 1000000)) . ' Juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = terbilang((int)($angka / 1000000000)) . ' Milyar ' . terbilang($angka % 1000000000);
        } else {
            $hasil = terbilang((int)($angka / 1000000000000)) . ' Triliun ' . terbilang($angka % 1000000000000);
        }

        return trim(preg_replace('/\s+/', ' ', $hasil));
    }
}

if (!function_exists('terbilangRupiah')) {
    function terbilangRupiah($angka): string
    {
        $angka = (int)round((float)$angka);
        if ($angka <= 0) {
            return 'Nol Rupiah';
        }
        return terbilang($angka) . ' Rupiah';
    }
}

$clinicName    = \Cake\Core\Configure::read('App.clinic_name') ?? 'RSU BHAKTI RAHAYU SURABAYA';
$clinicAddress = \Cake\Core\Configure::read('App.clinic_address') ?? 'Jl. Ketintang Madya I No.16, Ketintang, Gayungan, Kota Surabaya, Provinsi Jawa Timur';
$clinicPhone   = \Cake\Core\Configure::read('App.clinic_phone') ?? '031 8295922 / 0318291799';

$noKwitansi   = $billing->receipt_no ?: $billing->billing_no;
$tglCetak     = $billing->paid_at ? $billing->paid_at->format('d-m-Y') : date('d-m-Y');
$jamCetak     = $billing->paid_at ? $billing->paid_at->format('H:i:s') : date('H:i:s');
$noRegistrasi = $billing->registration_no ?? ($billing->registration->registration_no ?? '-');

$adminFee    = (float)($billing->admin_fee ?? 0);
$doctorName  = (!empty($d) && !empty($d->doctor_name)) ? $d->doctor_name : null;
$kasirName   = $billing->paid_by
    ?? ($this->request->getAttribute('identity') ? $this->request->getAttribute('identity')->get('full_name') : null)
    ?? '-';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kwitansi <?= h($noKwitansi) ?></title>
    <style>
        /* ── Semua style di-scope ke dalam .kwitansi-doc supaya aman
           kalau nanti disuntikkan ke halaman lain (mis. modal preview),
           tidak akan menimpa tampilan halaman tersebut. ── */
        .kwitansi-doc, .kwitansi-doc * { margin:0; padding:0; box-sizing:border-box; }
        .kwitansi-doc {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
            width: 190mm;
            max-width: 100%;
            margin: 0 auto;
            padding: 8mm;
            background: #fff;
        }
        @page { margin: 12mm; }
        .kwitansi-doc .header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2px solid #000; padding-bottom:8px; margin-bottom:12px; }
        .kwitansi-doc .clinic-logo-block { max-width:400px; display:flex; align-items:flex-start; gap:10px; }
        .kwitansi-doc .clinic-logo-block img { width:48px; height:48px; object-fit:contain; flex-shrink:0; margin-top:2px; }
        .kwitansi-doc .clinic-text { flex:1; }
        .kwitansi-doc .clinic-name { font-size:16px; font-weight:bold; letter-spacing:.5px; }
        .kwitansi-doc .clinic-addr { font-size:10px; margin-top:2px; line-height:1.4; }
        .kwitansi-doc .title-box { text-align:right; font-size:11px; white-space:nowrap; }
        .kwitansi-doc .title-box .judul { font-weight:bold; font-size:12px; margin-bottom:6px; }
        .kwitansi-doc .title-box table { margin-left:auto; }
        .kwitansi-doc .title-box table td { padding:1px 0; text-align:left; }
        .kwitansi-doc .title-box table td.k { padding-right:6px; white-space:nowrap; }
        .kwitansi-doc table.info-table { width:100%; margin-bottom:6px; border-collapse:collapse; }
        .kwitansi-doc table.info-table td { padding:2px 0; font-size:12px; vertical-align:top; }
        .kwitansi-doc table.info-table td.label { width:150px; white-space:nowrap; }
        .kwitansi-doc table.info-table td.sep { width:12px; }
        .kwitansi-doc .banyaknya-box {
            border:1px solid #000; padding:6px 8px; margin:8px 0; font-weight:bold; text-align:center; font-size:12px;
        }
        .kwitansi-doc .banyaknya-box .caption { font-weight:normal; font-size:10px; margin-bottom:2px; }
        .kwitansi-doc table.rincian { width:100%; border-collapse:collapse; margin-top:8px; }
        .kwitansi-doc table.rincian th, .kwitansi-doc table.rincian td { border:1px solid #000; padding:4px 6px; font-size:11px; }
        .kwitansi-doc table.rincian th { background:#f0f0f0; text-align:center; }
        .kwitansi-doc table.rincian td.no { text-align:center; width:30px; }
        .kwitansi-doc table.rincian td.jumlah { text-align:right; width:110px; }
        .kwitansi-doc table.summary { width:280px; margin-left:auto; margin-top:10px; }
        .kwitansi-doc table.summary td { padding:2px 0; font-size:12px; }
        .kwitansi-doc table.summary td.val { text-align:right; }
        .kwitansi-doc table.summary tr.grand td { font-weight:bold; border-top:1px solid #000; padding-top:4px; }
        .kwitansi-doc .ttd { margin-top:40px; display:flex; justify-content:flex-end; }
        .kwitansi-doc .ttd .box { text-align:center; width:180px; font-size:12px; }
        .kwitansi-doc .ttd .box .space { height:50px; }
        .kwitansi-doc .btn-print {
            display:block; text-align:center; margin:16px auto; padding:8px 20px;
            background:#1e3a5f; color:#fff; border:none; border-radius:4px; cursor:pointer; font-size:13px;
        }
        @media print {
            .kwitansi-doc .btn-print, .kwitansi-doc .btn-back { display:none !important; }
        }
    </style>
</head>
<body>

<div class="kwitansi-doc">

    <div class="header">
        <div class="clinic-logo-block">
            <img src="<?= $this->Url->image('logo_br1.png') ?>" alt="Logo">
            <div class="clinic-text">
                <div class="clinic-name"><?= h($clinicName) ?></div>
                <div class="clinic-addr"><?= h($clinicAddress) ?></div>
                <div class="clinic-addr"><?= h($clinicPhone) ?></div>
            </div>
        </div>
        <div class="title-box">
            <div class="judul">KWITANSI PEMBAYARAN<br>PASIEN RAWAT JALAN</div>
            <table>
                <tr><td class="k">No. Kwitansi</td><td>: <?= h($noKwitansi) ?></td></tr>
                <tr><td class="k">Tanggal</td><td>: <?= h($tglCetak) ?></td></tr>
                <tr><td class="k">Jam</td><td>: <?= h($jamCetak) ?> WIB</td></tr>
            </table>
        </div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">No. Registrasi</td><td class="sep">:</td><td><?= h($noRegistrasi) ?></td>
        </tr>
        <tr>
            <td class="label">No. RM</td><td class="sep">:</td><td><?= h($p->code ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td><td class="sep">:</td><td><?= h($p->full_name ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label">Sudah diterima dari</td><td class="sep">:</td><td><?= h($p->full_name ?? '-') ?></td>
        </tr>
    </table>

    <div class="banyaknya-box">
        <div class="caption">Banyaknya Uang</div>
        <?= h(strtoupper(terbilangRupiah($billing->grand_total))) ?>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Untuk Pembayaran</td><td class="sep">:</td>
            <td>
                Pemeriksaan &amp; Tindakan Dokter<?= !empty($billing->polyclinic_name) ? ' ' . h($billing->polyclinic_name) : '' ?><?= $doctorName ? ' — ' . h($doctorName) : '' ?>
            </td>
        </tr>
    </table>
    <div style="height:6px;"></div>

    <table class="rincian">
        <thead>
            <tr><th style="width:30px;">No.</th><th>Keterangan</th><th style="width:110px;">Jumlah Rp</th></tr>
        </thead>
        <tbody>
            <?php if (empty($itemsArr)): ?>
                <tr><td colspan="3" style="text-align:center; padding:10px; color:#888;">Tidak ada rincian item.</td></tr>
            <?php else: $no = 1; foreach ($itemsArr as $item): ?>
                <tr>
                    <td class="no"><?= $no++ ?></td>
                    <td>
                        <?= h($item->item_name) ?><?= ($item->item_type === 'tindakan' && $doctorName) ? ' — ' . h($doctorName) : '' ?>
                    </td>
                    <td class="jumlah"><?= number_format((float)$item->final_price, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <table class="summary">
        <tr><td>Total Rp</td><td class="val"><?= number_format((float)$billing->subtotal, 0, ',', '.') ?></td></tr>
        <tr><td>Adm Kartu Rp</td><td class="val"><?= number_format($adminFee, 0, ',', '.') ?></td></tr>
        <tr><td>Diskon Rp</td><td class="val"><?= number_format((float)$billing->discount_amount, 0, ',', '.') ?></td></tr>
        <tr class="grand"><td>Total Net Rp</td><td class="val"><?= number_format((float)$billing->grand_total, 0, ',', '.') ?></td></tr>
        <tr><td>Jumlah Bayar Rp (<?= h(strtoupper((string)$billing->payment_method)) ?>)</td><td class="val"><?= number_format((float)$billing->paid_amount, 0, ',', '.') ?></td></tr>
        <tr><td>Kembali Rp</td><td class="val"><?= number_format((float)$billing->change_amount, 0, ',', '.') ?></td></tr>
    </table>

    <div class="ttd">
        <div class="box">
            Surabaya, <?= h($tglCetak) ?><br>
            KASIR,
            <div class="space"></div>
            <div style="border-top:1px solid #000; padding-top:2px;">
                <?= $kasirName !== '-' ? h($kasirName) : '&nbsp;' ?>
            </div>
        </div>
    </div>

    <button class="btn-print" onclick="window.print()">🖨️ Cetak Kwitansi</button>
    <a href="<?= $this->Url->build(['prefix' => 'Kasir', 'controller' => 'OutpatientBillings', 'action' => 'kasir', $billing->id]) ?>"
       class="btn-back"
       style="display:block; text-align:center; margin-top:6px; font-size:12px; color:#1e3a5f;">
        ← Kembali ke Kasir
    </a>

</div>

</body>
</html>