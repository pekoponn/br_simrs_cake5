<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBilling $billing
 * @var iterable $items
 * @var iterable $payments
 */
$p       = $billing->patient;
$d       = $billing->doctor;
$isPaid  = $billing->status === 'paid';
$isVoid  = in_array($billing->status, ['void','cancelled']);
$isLocked = $isPaid || $isVoid;

$addItemUrl    = $this->Url->build(['action' => 'tambahItem',  $billing->id]);
$hapusItemUrl  = $this->Url->build(['action' => 'hapusItem',   0]);
$prosesBayarUrl= $this->Url->build(['action' => 'prosesBayar', $billing->id]);
$csrfToken     = $this->request->getAttribute('csrfToken');

// ── DATA TAMBAHAN (mengikuti kolom-kolom pada aplikasi lama) ──
// Catatan: sebagian field di bawah ini mungkin belum ada di tabel
// outpatient_billings / patients. Gunakan fallback '-' dulu sampai
// kolomnya ditambahkan lewat migration, lalu ganti sesuai nama kolom aslinya.
$noUrut       = $billing->queue_no ?? $billing->registration_no ?? '-';
$noRegistrasi = $billing->registration_no ?? ($billing->registration->registration_no ?? '-');
$statusWarga  = $p->citizenship ?? 'WNI';
$tglPeriksa   = !empty($billing->exam_date)
    ? $billing->exam_date->format('d-m-Y')
    : ($billing->created ? $billing->created->format('d-m-Y') : '-');
$jamPeriksa   = !empty($billing->exam_time)
    ? $billing->exam_time
    : ($billing->created ? $billing->created->format('H:i:s') : '-');
$alergi        = $p->allergy ?? null;
$readyToTransfer = (bool)($billing->ready_to_transfer ?? false);

// ── Field jaminan / BPJS (mengikuti tampilan software lama) ──
// Kolom-kolom ini perlu ditambahkan lewat migration (lihat file SQL terpisah).
// Belum ada sumber data entry-nya, jadi nilainya masih fallback kosong/0.
$insurancePartnerName = $billing->insurance_partner_name ?? null;
$policyNo             = $billing->policy_no ?? null;
$receiptNo            = $billing->receipt_no ?? null;
$adminFee             = (float)($billing->admin_fee ?? 0);
$inacbgAmount         = (float)($billing->inacbg_amount ?? 0);
$cbgCode              = $billing->cbg_code ?? null;
$guarantor2Name       = $billing->guarantor2_name ?? null;
$guarantor2Amount     = (float)($billing->guarantor2_amount ?? 0);
$guarantor3Name       = $billing->guarantor3_name ?? null;
$guarantor3Amount     = (float)($billing->guarantor3_amount ?? 0);
$uncollectibleAmount  = (float)($billing->uncollectible_amount ?? 0);
$transferCardNo       = $billing->transfer_card_no ?? null;
$transferBankAuthNo   = $billing->transfer_bank_auth_no ?? null;
$transferCardType     = $billing->transfer_card_type ?? 'transfer';
$transferAdminPercent = (float)($billing->transfer_admin_percent ?? 0);
$transferBankDest     = $billing->transfer_bank_dest ?? null;
$paidByDefault        = $billing->paid_by
    ?? ($this->request->getAttribute('identity') ? $this->request->getAttribute('identity')->get('full_name') : null)
    ?? '-';
?>

<?= $this->Krs->breadcrumb('Kasir Rawat Jalan', 'Proses Pembayaran') ?>

<div class="outpatient-billings kasir">

<!-- ── HEADER ── -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
    <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
        <i class="fa fa-cash-register"></i> Kasir Rawat Jalan
    </h4>
    <div style="display:flex; gap:6px; flex-wrap:wrap;">
        <?php if (!$isLocked): ?>
            <button type="button" class="btn btn-default btn-sm" id="btn-e-order" title="E-Order">
                <i class="fa fa-file-medical"></i> E-Order
            </button>
            <button type="button" class="btn btn-default btn-sm" id="btn-alkes" title="Alkes yg Dibebankan Ke Pasien">
                <i class="fa fa-briefcase-medical"></i> Alkes Dibebankan
            </button>
            <button type="button" class="btn btn-default btn-sm" id="btn-riwayat-resep" title="Riwayat Resep">
                <i class="fa fa-history"></i> Riwayat Resep
            </button>
            <button type="button" class="btn btn-default btn-sm" id="btn-pemakaian-oksigen" title="Pemakaian Oksigen">
                <i class="fa fa-lungs"></i> Pemakaian Oksigen
            </button>
            <button type="button" class="btn btn-default btn-sm" id="btn-cetak-permohonan-rawat" title="Cetak Permohonan Rawat">
                <i class="fa fa-print"></i> Cetak Permohonan Rawat
            </button>
        <?php endif; ?>
        <?php if ($isPaid): ?>
            <button type="button" class="btn btn-success btn-sm"
                    onclick="printKwitansi('<?= $this->Url->build(['action' => 'kwitansi', $billing->id]) ?>')">
                <i class="fa fa-print"></i> Cetak Kwitansi
            </button>
        <?php endif; ?>
        <?= $this->Html->link(
            '<i class="fa fa-arrow-left"></i> Kembali',
            ['action' => 'index'],
            ['escape' => false, 'class' => 'btn btn-default btn-sm']
        ) ?>
    </div>
</div>

<!-- ── STATUS BADGE ── -->
<?php
$statusMap = [
    'draft'           => ['label'=>'Draft',           'class'=>'default'],
    'waiting_payment' => ['label'=>'Menunggu Bayar',  'class'=>'warning'],
    'paid'            => ['label'=>'LUNAS',            'class'=>'success'],
    'cancelled'       => ['label'=>'Dibatalkan',       'class'=>'danger'],
    'void'            => ['label'=>'Void',             'class'=>'danger'],
];
$st = $statusMap[$billing->status] ?? ['label'=>$billing->status,'class'=>'default'];
?>
<div style="margin-bottom:10px; display:flex; align-items:center; flex-wrap:wrap; gap:8px;">
    <span class="label label-<?= $st['class'] ?>" style="font-size:13px; padding:5px 14px;">
        <?= $st['label'] ?>
    </span>
    <small style="color:#888;">No. Tagihan: <strong><?= h($billing->billing_no) ?></strong></small>
    <small style="color:#888;">No. Registrasi: <strong><?= h($noRegistrasi) ?></strong></small>
    <small style="color:#888;">No. Urut: <strong><?= h($noUrut) ?></strong></small>
</div>

<!-- ── INFO PASIEN ── -->
<div class="panel panel-default" style="margin-bottom:10px;">
    <div class="panel-body" style="padding:8px 12px; background:#f8f9fa; font-size:12px;">
        <div class="row">
            <div class="col-md-2">
                <small>No RM</small><br>
                <strong><?= h($p->code ?? '-') ?></strong>
            </div>
            <div class="col-md-3">
                <small>Nama Pasien</small><br>
                <strong><?= h($p->full_name ?? '-') ?></strong>
                <span class="label label-default" style="font-size:9px; vertical-align:middle;"><?= h($statusWarga) ?></span>
            </div>
            <div class="col-md-2">
                <small>Dokter</small><br>
                <strong><?= h($d->doctor_name ?? '-') ?></strong>
            </div>
            <div class="col-md-2">
                <small>Poli</small><br>
                <strong><?= h($billing->polyclinic_name ?? '-') ?></strong>
            </div>
            <div class="col-md-1">
                <small>Jaminan</small><br>
                <strong><?= h($billing->insurance_type ?? 'Umum') ?></strong>
            </div>
            <div class="col-md-2">
                <small>Tgl / Jam Periksa</small><br>
                <strong><?= h($tglPeriksa) ?> <?= h($jamPeriksa) ?></strong>
            </div>
        </div>
        <?php if (!empty($alergi)): ?>
        <div class="row" style="margin-top:6px;">
            <div class="col-md-12">
                <small>Alergi</small><br>
                <strong style="color:#dc3545;"><i class="fa fa-exclamation-triangle"></i> <?= h($alergi) ?></strong>
            </div>
        </div>
        <?php endif; ?>
        <?php if (!$isLocked): ?>
        <div class="row" style="margin-top:8px;">
            <div class="col-md-12">
                <label style="font-size:11px; font-weight:600; margin:0;">
                    <input type="checkbox" id="chk-ready-transfer" <?= $readyToTransfer ? 'checked' : '' ?>>
                    Sudah siap ditransfer ke rawat inap
                </label>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ── LAYOUT SATU KOLOM (mengikuti alur software lama) ── -->
<?php
$itemsArr = iterator_to_array($items, false);
$groupTindakan = array_values(array_filter($itemsArr, fn($i) => $i->item_type === 'tindakan'));
$groupObat     = array_values(array_filter($itemsArr, fn($i) => $i->item_type === 'obat'));
$groupLab      = array_values(array_filter($itemsArr, fn($i) => $i->item_type === 'laboratorium'));
$groupRad      = array_values(array_filter($itemsArr, fn($i) => $i->item_type === 'radiologi'));
$groupLain     = array_values(array_filter($itemsArr, fn($i) => !in_array($i->item_type, ['tindakan','obat','laboratorium','radiologi'])));

$sumTindakan = array_sum(array_map(fn($i) => (float)$i->final_price, $groupTindakan));
$sumObat     = array_sum(array_map(fn($i) => (float)$i->final_price, $groupObat));
$sumLab      = array_sum(array_map(fn($i) => (float)$i->final_price, $groupLab));
$sumRad      = array_sum(array_map(fn($i) => (float)$i->final_price, $groupRad));
$sumLain     = array_sum(array_map(fn($i) => (float)$i->final_price, $groupLain));
?>

<div class="row">
    <div class="col-md-12">

        <!-- ── PEMERIKSAAN & TINDAKAN DOKTER POLI ── -->
        <div class="panel panel-primary">
            <div class="panel-heading" style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#1e3a5f; border-color:#1e3a5f;">
                <strong style="font-size:12px; color:#fff;">
                    <i class="fa fa-stethoscope"></i> Pemeriksaan &amp; Tindakan Dokter Poli
                </strong>
                <?php if (!$isLocked): ?>
                    <button type="button" class="btn btn-xs btn-success" id="btn-tambah-item">
                        <i class="fa fa-plus"></i> Tambah Item
                    </button>
                <?php endif; ?>
            </div>
            <div class="panel-body" style="padding:0;">
                <table class="table table-bordered table-sm" id="billing-items-table"
                       style="font-size:11px; margin-bottom:0;">
                    <thead style="background:#f0f4f8;">
                        <tr class="text-center">
                            <th style="width:70px;">Kode</th>
                            <th>Tindakan</th>
                            <th style="width:160px;">Dokter</th>
                            <th style="width:50px;">Qty</th>
                            <th style="width:100px;">Harga</th>
                            <th style="width:100px;">Total</th>
                            <?php if (!$isLocked): ?><th style="width:28px;"></th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="items-body">
                        <?php if (empty($groupTindakan)): ?>
                            <tr id="empty-row">
                                <td colspan="<?= $isLocked ? 6 : 7 ?>" style="text-align:center; color:#aaa; padding:16px; font-size:12px;">
                                    <i class="fa fa-receipt"></i> Belum ada tindakan poli tercatat.
                                </td>
                            </tr>
                        <?php else: foreach ($groupTindakan as $item): ?>
                            <tr class="item-row" data-id="<?= $item->id ?>">
                                <td class="text-center" style="font-family:monospace;"><?= h($item->item_code ?? '-') ?></td>
                                <td><?= h($item->item_name) ?></td>
                                <td style="font-size:10px;"><?= h($d->doctor_name ?? '-') ?></td>
                                <td class="text-center"><?= h($item->quantity) ?></td>
                                <td class="text-right"><?= number_format($item->unit_price, 0, ',', '.') ?></td>
                                <td class="text-right" style="font-weight:600;"><?= number_format($item->final_price, 0, ',', '.') ?></td>
                                <?php if (!$isLocked): ?>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-danger btn-hapus-item" data-id="<?= $item->id ?>">&times;</button>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                    <tfoot style="background:#f8f9fa; font-weight:700;">
                        <tr>
                            <td colspan="5" style="text-align:right; padding-right:10px;">Subtotal Tindakan Poli</td>
                            <td class="text-right"><?= number_format($sumTindakan, 0, ',', '.') ?></td>
                            <?php if (!$isLocked): ?><td></td><?php endif; ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- ── KATEGORI LAIN (placeholder, belum ada sumber data) ── -->
        <div class="row">
            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:6px 10px;"><strong style="font-size:11px;"><i class="fa fa-pills"></i> Obat / Resep</strong></div>
                    <div class="panel-body" style="padding:0;">
                        <table class="table table-bordered table-sm" style="font-size:10px; margin-bottom:0;">
                            <thead style="background:#f0f4f8;"><tr><th>No. Resep</th><th class="text-right">Total Rp</th></tr></thead>
                            <tbody>
                                <?php if (empty($groupObat)): ?>
                                    <tr><td colspan="2" class="text-center" style="color:#bbb; padding:10px;">Belum ada sumber data</td></tr>
                                <?php else: foreach ($groupObat as $item): ?>
                                    <tr><td><?= h($item->item_name) ?></td><td class="text-right"><?= number_format($item->final_price, 0, ',', '.') ?></td></tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:6px 10px;"><strong style="font-size:11px;"><i class="fa fa-user-md"></i> Bedah / ODC</strong></div>
                    <div class="panel-body" style="padding:0;">
                        <table class="table table-bordered table-sm" style="font-size:10px; margin-bottom:0;">
                            <thead style="background:#f0f4f8;"><tr><th>No. Transaksi</th><th class="text-right">Total Rp</th></tr></thead>
                            <tbody>
                                <?php if (empty($groupLain)): ?>
                                    <tr><td colspan="2" class="text-center" style="color:#bbb; padding:10px;">Belum ada sumber data</td></tr>
                                <?php else: foreach ($groupLain as $item): ?>
                                    <tr><td><?= h($item->item_name) ?></td><td class="text-right"><?= number_format($item->final_price, 0, ',', '.') ?></td></tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:6px 10px;"><strong style="font-size:11px;"><i class="fa fa-flask"></i> Laboratorium</strong></div>
                    <div class="panel-body" style="padding:0;">
                        <table class="table table-bordered table-sm" style="font-size:10px; margin-bottom:0;">
                            <thead style="background:#f0f4f8;"><tr><th>No. Periksa</th><th class="text-right">Total</th></tr></thead>
                            <tbody>
                                <?php if (empty($groupLab)): ?>
                                    <tr><td colspan="2" class="text-center" style="color:#bbb; padding:10px;">Belum ada sumber data</td></tr>
                                <?php else: foreach ($groupLab as $item): ?>
                                    <tr><td><?= h($item->item_name) ?></td><td class="text-right"><?= number_format($item->final_price, 0, ',', '.') ?></td></tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:6px 10px;"><strong style="font-size:11px;"><i class="fa fa-x-ray"></i> Radiologi</strong></div>
                    <div class="panel-body" style="padding:0;">
                        <table class="table table-bordered table-sm" style="font-size:10px; margin-bottom:0;">
                            <thead style="background:#f0f4f8;"><tr><th>No. Periksa</th><th class="text-right">Total</th></tr></thead>
                            <tbody>
                                <?php if (empty($groupRad)): ?>
                                    <tr><td colspan="2" class="text-center" style="color:#bbb; padding:10px;">Belum ada sumber data</td></tr>
                                <?php else: foreach ($groupRad as $item): ?>
                                    <tr><td><?= h($item->item_name) ?></td><td class="text-right"><?= number_format($item->final_price, 0, ',', '.') ?></td></tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:6px 10px;"><strong style="font-size:11px;"><i class="fa fa-briefcase-medical"></i> Penunjang Medis</strong></div>
                    <div class="panel-body" style="padding:0;">
                        <table class="table table-bordered table-sm" style="font-size:10px; margin-bottom:0;">
                            <thead style="background:#f0f4f8;"><tr><th>No. Pemeriksaan</th><th class="text-right">Total</th></tr></thead>
                            <tbody>
                                <tr><td colspan="2" class="text-center" style="color:#bbb; padding:10px;">Belum ada sumber data</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── RINGKASAN TOTAL + AKSI ── -->
        <div class="panel panel-default">
            <div class="panel-heading" style="padding:8px 12px;">
                <strong style="font-size:12px;"><i class="fa fa-calculator"></i> Ringkasan Total</strong>
            </div>
            <div class="panel-body" style="padding:14px;">
                <div class="row">
                    <div class="col-md-7">
                        <table style="width:100%; font-size:12px;">
                            <tr><td style="padding:3px 0;">Total Poli (Tindakan)</td><td class="text-right" style="font-weight:700;"><?= number_format($sumTindakan, 2, ',', '.') ?></td></tr>
                            <tr style="color:#bbb;"><td style="padding:3px 0;">Total Laborat</td><td class="text-right" style="font-weight:700;"><?= number_format($sumLab, 2, ',', '.') ?></td></tr>
                            <tr style="color:#bbb;"><td style="padding:3px 0;">Total Radiologi</td><td class="text-right" style="font-weight:700;"><?= number_format($sumRad, 2, ',', '.') ?></td></tr>
                            <tr style="color:#bbb;"><td style="padding:3px 0;">Total Resep</td><td class="text-right" style="font-weight:700;"><?= number_format($sumObat, 2, ',', '.') ?></td></tr>
                            <tr style="color:#bbb;"><td style="padding:3px 0;">Total Bedah</td><td class="text-right" style="font-weight:700;">0,00</td></tr>
                            <tr style="color:#bbb;"><td style="padding:3px 0;">Total Penunjang</td><td class="text-right" style="font-weight:700;"><?= number_format($sumLain, 2, ',', '.') ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-5" style="border-left:1px solid #eee;">
                        <?php if ($isPaid): ?>
                            <div style="text-align:center; padding:10px 0;">
                                <i class="fa fa-check-circle" style="font-size:34px; color:#27ae60;"></i>
                                <div style="font-weight:800; color:#27ae60; margin-top:4px;">LUNAS</div>
                                <div style="font-size:11px; color:#555; margin-top:4px;">
                                    Dibayar: Rp <?= number_format($billing->paid_amount, 0, ',', '.') ?><br>
                                    Metode: <?= strtoupper($billing->payment_method) ?><br>
                                    <?= $billing->paid_at ? $billing->paid_at->format('d-m-Y H:i') : '-' ?>
                                </div>
                                <button type="button" class="btn btn-success btn-sm btn-block" style="margin-top:8px;"
                                        onclick="printKwitansi('<?= $this->Url->build(['action' => 'kwitansi', $billing->id]) ?>')">
                                    <i class="fa fa-print"></i> Cetak Kwitansi
                                </button>
                            </div>
                        <?php elseif ($isVoid): ?>
                            <div style="text-align:center; padding:10px 0; color:#dc3545; font-weight:700;">
                                Tagihan dibatalkan / void.
                            </div>
                        <?php else: ?>
                            <?php if (!empty($totalPaidSoFar)): ?>
                                <div style="font-size:11px; color:#27ae60; text-align:right;">
                                    Sudah Dibayar: Rp <?= number_format($totalPaidSoFar, 0, ',', '.') ?>
                                </div>
                            <?php endif; ?>
                            <div style="font-size:20px; font-weight:800; color:#dc3545; text-align:right;">
                                Rp <?= number_format($outstandingAmount, 0, ',', '.') ?>
                            </div>
                            <div style="font-size:11px; color:#888; text-align:right; margin-bottom:10px;">
                                <?= !empty($totalPaidSoFar) ? 'SISA TAGIHAN' : 'GRAND TOTAL' ?>
                            </div>
                            <div style="display:flex; gap:6px; justify-content:flex-end;">
                                <button type="button" class="btn btn-default btn-sm" id="btn-refresh-kasir" title="Refresh">
                                    <i class="fa fa-sync-alt"></i> Refresh
                                </button>
                                <button type="button" class="btn btn-default btn-sm" title="Jaminan (segera hadir)" disabled>
                                    <i class="fa fa-id-card"></i> Jaminan
                                </button>
                                <button type="button" class="btn btn-success btn-sm" id="btn-buka-bayar">
                                    <i class="fa fa-check-circle"></i> Bayar
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <?php if ($isPaid): ?>
        <div class="panel panel-success">
            <div class="panel-heading" style="padding:8px 12px;">
                <strong style="font-size:12px;"><i class="fa fa-check-circle"></i> Riwayat Pembayaran</strong>
            </div>
            <div class="panel-body" style="padding:0;">
                <table class="table table-sm" style="font-size:11px; margin:0;">
                    <thead><tr><th>No</th><th>Metode</th><th class="text-right">Jumlah</th><th>Waktu</th></tr></thead>
                    <tbody>
                        <?php foreach ($payments as $pay): ?>
                        <tr>
                            <td><?= h($pay->payment_no) ?></td>
                            <td><?= h(strtoupper($pay->payment_method)) ?></td>
                            <td class="text-right">Rp <?= number_format($pay->amount, 0, ',', '.') ?></td>
                            <td><?= $pay->created->format('d-m-Y H:i') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div><!-- /row -->

<?php if (!$isLocked): ?>
<!-- ── OVERLAY MODAL: PROSES PEMBAYARAN (muncul saat tombol Bayar diklik) ── -->
<div id="modal-bayar-overlay" class="krs-modal-overlay">
    <div class="krs-modal-box" style="max-width:640px;">
        <div class="krs-modal-head">
            <strong><i class="fa fa-cash-register"></i> Proses Pembayaran</strong>
            <button type="button" class="krs-modal-close" id="btn-tutup-bayar">&times;</button>
        </div>
        <div class="krs-modal-body">

            <div class="row" style="margin-bottom:10px; font-size:12px;">
                <div class="col-xs-6">
                    <small>Pemegang Polis / Pasien</small><br>
                    <strong><?= h($p->full_name ?? '-') ?></strong>
                </div>
                <div class="col-xs-6">
                    <small>Jaminan</small><br>
                    <strong><?= h($billing->insurance_type ?? 'Umum') ?></strong>
                </div>
            </div>

                        <!-- ── Info Rekanan/Polis (mengikuti tampilan software lama) ── -->
            <div class="row" style="margin-bottom:8px; font-size:12px;">
                <div class="col-xs-6">
                    <label style="font-size:11px; margin-bottom:2px;">No. Polis / No. SEP <small style="color:#888; font-weight:400;">(terisi otomatis)</small></label>
                    <input type="text" name="policy_no" class="form-control input-sm" value="<?= h($policyNo) ?>" readonly
                           style="background-color:#e9ecef; color:#6c757d; cursor:not-allowed;">
                </div>
                <div class="col-xs-6">
                    <label style="font-size:11px; margin-bottom:2px;">Tanggal Transaksi</label>
                    <input type="text" class="form-control input-sm" value="<?= date('d-m-Y H:i:s') ?>" disabled>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px; font-size:12px;">
                <div class="col-xs-12">
                    <label style="font-size:11px; margin-bottom:2px;">No. Kwitansi</label>
                    <input type="text" name="receipt_no" class="form-control input-sm" value="<?= h($receiptNo) ?>" placeholder="Dibuat otomatis setelah bayar" readonly
                           style="background-color:#e9ecef; color:#6c757d; cursor:not-allowed;">
                </div>
            </div>

            <!-- ── Tabel breakdown: Kategori Rp | Diskon Rp (per baris, seperti foto lama) ── -->
            <table style="width:100%; font-size:12px; margin-bottom:8px;" id="tabel-breakdown-bayar">
                <thead>
                    <tr style="color:#888; font-size:10px;">
                        <td></td>
                        <td class="text-right" style="width:110px;">Jumlah Rp</td>
                        <td class="text-right" style="width:110px; padding-left:8px;">Diskon Rp</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:3px 0;">Adm Rp</td>
                        <td class="text-right"><input type="number" name="admin_fee" id="jaminan-admin-fee" class="form-control input-sm text-right kategori-jumlah" value="<?= (int)$adminFee ?>" min="0" step="1000"></td>
                        <td class="text-right" style="padding-left:8px;"><input type="number" class="form-control input-sm text-right kategori-diskon" data-kategori="adm" value="0" min="0" step="1000"></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0;">Poli Rp (Tindakan)</td>
                        <td class="text-right" id="cat-poli-rp"><?= number_format($sumTindakan, 0, ',', '.') ?></td>
                        <td class="text-right" style="padding-left:8px;"><input type="number" class="form-control input-sm text-right kategori-diskon" data-kategori="poli" value="0" min="0" step="1000"></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0;">Laborat Rp</td>
                        <td class="text-right" id="cat-lab-rp"><?= number_format($sumLab, 0, ',', '.') ?></td>
                        <td class="text-right" style="padding-left:8px;"><input type="number" class="form-control input-sm text-right kategori-diskon" data-kategori="lab" value="0" min="0" step="1000"></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0;">Radiologi Rp</td>
                        <td class="text-right" id="cat-rad-rp"><?= number_format($sumRad, 0, ',', '.') ?></td>
                        <td class="text-right" style="padding-left:8px;"><input type="number" class="form-control input-sm text-right kategori-diskon" data-kategori="rad" value="0" min="0" step="1000"></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0;">Bedah Rp</td>
                        <td class="text-right" id="cat-bedah-rp">0</td>
                        <td class="text-right" style="padding-left:8px;"><input type="number" class="form-control input-sm text-right kategori-diskon" data-kategori="bedah" value="0" min="0" step="1000"></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0;">Resep Rp</td>
                        <td class="text-right" id="cat-resep-rp"><?= number_format($sumObat, 0, ',', '.') ?></td>
                        <td class="text-right" style="padding-left:8px;"><input type="number" class="form-control input-sm text-right kategori-diskon" data-kategori="resep" value="0" min="0" step="1000"></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0;">Penunjang Medis Rp</td>
                        <td class="text-right" id="cat-penunjang-rp"><?= number_format($sumLain, 0, ',', '.') ?></td>
                        <td class="text-right" style="padding-left:8px;"><input type="number" class="form-control input-sm text-right kategori-diskon" data-kategori="penunjang" value="0" min="0" step="1000"></td>
                    </tr>
                    <tr style="border-top:1px solid #ddd; font-weight:700;">
                        <td style="padding:5px 0;">Total Rp</td>
                        <td class="text-right" id="cat-total-rp"><?= number_format($billing->subtotal, 0, ',', '.') ?></td>
                        <td class="text-right" style="padding-left:8px;" id="cat-tot-diskon-rp">0</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0;">Diskon Total Rp</td>
                        <td class="text-right" colspan="2">
                            <input type="number" id="diskon-total-manual" class="form-control input-sm text-right" value="0" min="0" step="1000" placeholder="Diskon tambahan (opsional)">
                        </td>
                    </tr>
                    <tr style="font-weight:800; color:#1e3a5f;">
                        <td style="padding:6px 0;">Total Net Rp</td>
                        <td class="text-right" colspan="2" id="cat-total-net-rp">
                            <?= number_format($billing->grand_total, 0, ',', '.') ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Hidden fields: tetap kirim ke backend yang sudah ada (discount_type/discount_value global) -->
            <input type="hidden" name="discount_type" id="discount-type" value="nominal">
            <input type="hidden" name="discount_value" id="discount-value" value="0">

            <div style="font-size:10px; color:#888; margin-bottom:12px;">
                <i class="fa fa-info-circle"></i> Diskon per kategori di atas dijumlahkan otomatis jadi satu nilai diskon total (sistem saat ini menyimpan diskon sebagai satu nilai global, belum per kategori).
            </div>

            <?= $this->Form->create(null, ['url' => ['action' => 'prosesBayar', $billing->id], 'method' => 'post', 'id' => 'form-bayar', 'type' => 'file']) ?>

            <div class="form-group">
                <label style="font-size:12px; font-weight:700;">Metode Pembayaran</label>
                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <?php
                    $methods = [
                        'tunai'    => ['label'=>'Tunai',    'icon'=>'fa-money-bill-wave', 'color'=>'#27ae60'],
                        'transfer' => ['label'=>'Transfer', 'icon'=>'fa-university',      'color'=>'#2980b9'],
                        'qris'     => ['label'=>'QRIS',     'icon'=>'fa-qrcode',          'color'=>'#e67e22'],
                    ];
                    foreach ($methods as $val => $m):
                    ?>
                    <label class="payment-method-btn" style="cursor:pointer; border:2px solid #dee2e6; border-radius:6px; padding:7px 12px; text-align:center; min-width:72px; font-size:11px; font-weight:600;" data-value="<?= $val ?>" data-color="<?= $m['color'] ?>">
                        <input type="radio" name="payment_method" value="<?= $val ?>" style="display:none;" <?= $val === 'tunai' ? 'checked' : '' ?>>
                        <i class="fa <?= $m['icon'] ?>" style="display:block; font-size:16px; margin-bottom:3px; color:<?= $m['color'] ?>;"></i>
                        <?= $m['label'] ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

                        <!-- ── Detail Transfer / Kartu (muncul jika metode = Transfer) ── -->
            <div id="wrap-transfer-fields" style="display:none; background:#f8f9fa; border:1px solid #e2e6ea; border-radius:6px; padding:10px; margin-bottom:12px;">
                <div style="font-size:11px; font-weight:700; color:#1e3a5f; margin-bottom:8px;">
                    <i class="fa fa-university"></i> Detail Transfer / Kartu
                </div>

                <div class="row" style="margin-bottom:8px;">
                    <div class="col-xs-6">
                        <label style="font-size:11px; margin-bottom:2px;">No Ref / No Card / Rek Asal</label>
                        <input type="text" name="transfer_card_no" class="form-control input-sm"
                               value="<?= h($transferCardNo) ?>" placeholder="Nomor referensi / kartu / rekening asal">
                    </div>
                    <div class="col-xs-6">
                        <label style="font-size:11px; margin-bottom:2px;">No Otorisasi / Bank</label>
                        <input type="text" name="transfer_bank_auth_no" class="form-control input-sm"
                               value="<?= h($transferBankAuthNo) ?>" placeholder="Nomor otorisasi bank">
                    </div>
                </div>

                <div class="row" style="margin-bottom:8px;">
                    <div class="col-xs-12">
                        <label style="font-size:11px; margin-bottom:4px; display:block;">Card Type</label>
                        <label style="margin-right:16px; font-weight:400; font-size:12px;">
                            <input type="radio" name="transfer_card_type" value="credit_card" <?= $transferCardType === 'credit_card' ? 'checked' : '' ?>>
                            Credit Card
                        </label>
                        <label style="margin-right:16px; font-weight:400; font-size:12px;">
                            <input type="radio" name="transfer_card_type" value="debit_card" <?= $transferCardType === 'debit_card' ? 'checked' : '' ?>>
                            Debit Card
                        </label>
                        <label style="font-weight:400; font-size:12px;">
                            <input type="radio" name="transfer_card_type" value="transfer" <?= $transferCardType === 'transfer' ? 'checked' : '' ?>>
                            Transfer
                        </label>
                    </div>
                </div>

                <table style="width:100%; font-size:12px; margin-bottom:8px;">
                    <tr>
                        <td style="padding:3px 0; width:33%;">Total Credit/Debit/TR Rp</td>
                        <td class="text-right" id="transfer-total-cdtr" style="font-weight:700; width:34%;">0</td>
                        <td style="padding:3px 0 3px 8px; width:15%;">Adm %</td>
                        <td class="text-right" style="width:18%;">
                            <input type="number" name="transfer_admin_percent" id="transfer-admin-percent"
                                   class="form-control input-sm text-right" value="<?= $transferAdminPercent ?>"
                                   min="0" max="100" step="0.1">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight:700; padding-top:8px;">Grand Total Rp</td>
                        <td colspan="2" class="text-right" id="transfer-grand-total" style="font-weight:700; color:#1e3a5f; padding-top:8px;">0</td>
                    </tr>
                </table>

                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-size:11px;">EDC / Tujuan Bank</label>
                    <input type="text" name="transfer_bank_dest" class="form-control input-sm"
                           value="<?= h($transferBankDest) ?>" placeholder="cth. Bank Mandiri">
                </div>
            </div>

            <div style="background:#f8f9fa; border-radius:6px; padding:10px; margin-bottom:12px; font-size:12px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;"><span>Subtotal</span><span>Rp <strong id="calc-subtotal"><?= number_format($billing->subtotal, 0, ',', '.') ?></strong></span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:4px; color:#dc2626;"><span>Diskon</span><span>- Rp <strong id="calc-diskon">0</strong></span></div>
                <?php if (!empty($totalPaidSoFar)): ?>
                <div style="display:flex; justify-content:space-between; margin-bottom:4px; color:#27ae60;"><span>Sudah Dibayar Sebelumnya</span><span>- Rp <strong><?= number_format($totalPaidSoFar, 0, ',', '.') ?></strong></span></div>
                <?php endif; ?>
                <hr style="margin:6px 0;">
                <div style="display:flex; justify-content:space-between; font-size:14px; font-weight:700; color:#1e3a5f;"><span><?= !empty($totalPaidSoFar) ? 'Sisa yang Dibayar' : 'Total Bayar' ?></span><span>Rp <span id="calc-total"><?= number_format($outstandingAmount, 0, ',', '.') ?></span></span></div>
            </div>

            <div class="form-group" id="wrap-jumlah-bayar">
                <label style="font-size:12px; font-weight:700;">Jumlah Dibayar (Tunai)</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">Rp</span>
                    <input type="number" name="paid_amount" id="paid-amount" class="form-control" value="<?= (int)$outstandingAmount ?>" min="0" step="1000" style="font-size:14px; font-weight:700; text-align:right;">
                </div>
                <div style="display:flex; gap:4px; margin-top:6px; flex-wrap:wrap;">
                    <?php foreach ([50000,100000,200000,500000] as $nom): ?>
                    <button type="button" class="btn btn-xs btn-default btn-nominal" data-value="<?= $nom ?>" style="font-size:10px;"><?= number_format($nom/1000,0)?>rb</button>
                    <?php endforeach; ?>
                    <button type="button" class="btn btn-xs btn-info btn-nominal-exact" style="font-size:10px;">Pas</button>
                </div>
            </div>

            <div style="background:#fff3cd; border-radius:6px; padding:10px; margin-bottom:12px; font-size:13px; font-weight:700; text-align:center; display:none;" id="wrap-kembalian">
                Kembalian: Rp <span id="calc-kembalian" style="font-size:16px; color:#1e3a5f;">0</span>
            </div>

            <div class="form-group">
                <label style="font-size:12px; font-weight:700;">Dibayar Oleh</label>
                <input type="text" name="paid_by" class="form-control input-sm" value="<?= h($paidByDefault) ?>">
            </div>

            <div class="form-group">
                <label style="font-size:12px; font-weight:700;">Catatan</label>
                <textarea name="notes" class="form-control" rows="2" style="font-size:12px; resize:none;" placeholder="Catatan pembayaran..."></textarea>
            </div>

            <div class="form-group">
                <label style="font-size:12px; font-weight:700;">Bukti Pembayaran <small style="color:#888; font-weight:400;">(foto, opsional)</small></label>
                <input type="file" name="payment_proof" id="payment-proof-input" class="form-control input-sm" accept="image/*">
                <div id="payment-proof-preview" style="margin-top:8px; display:none;">
                    <img id="payment-proof-preview-img" src="" alt="Preview bukti pembayaran"
                         style="max-width:100%; max-height:180px; border-radius:6px; border:1px solid #dee2e6;">
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-block btn-lg" style="font-size:13px; font-weight:700;">
                <i class="fa fa-check-circle"></i> BAYAR SEKARANG
            </button>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- ── OVERLAY MODAL: TAMBAH ITEM ── -->
<div id="modal-tambah-item-overlay" class="krs-modal-overlay">
    <div class="krs-modal-box" style="max-width:420px;">
        <div class="krs-modal-head">
            <strong><i class="fa fa-plus"></i> Tambah Item Tagihan</strong>
            <button type="button" class="krs-modal-close" id="btn-cancel-item">&times;</button>
        </div>
        <div class="krs-modal-body">
            <div class="form-group">
                <label style="font-size:11px;">Tipe</label>
                <select id="new-item-type" class="form-control input-sm">
                    <option value="tindakan">Tindakan</option>
                    <option value="obat">Obat</option>
                    <option value="laboratorium">Laboratorium</option>
                    <option value="radiologi">Radiologi</option>
                    <option value="administrasi">Administrasi</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label style="font-size:11px;">Nama Item <span style="color:red;">*</span></label>
                <input type="text" id="new-item-name" class="form-control input-sm" placeholder="Nama item...">
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label style="font-size:11px;">Qty</label>
                        <input type="number" id="new-item-qty" class="form-control input-sm" value="1" min="1" step="1">
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label style="font-size:11px;">Harga/Unit</label>
                        <input type="number" id="new-item-price" class="form-control input-sm" value="0" min="0" step="1000">
                    </div>
                </div>
            </div>
            <div style="display:flex; gap:6px;">
                <button type="button" class="btn btn-success btn-sm" id="btn-save-item"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-default btn-sm" id="btn-cancel-item-2">Batal</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
</div>

<iframe id="print-kwitansi-frame" style="display:none;"></iframe>

<style>
.content {
    margin-left: 60px !important;
}

.payment-method-btn.active {
    border-width: 2px !important;
    background: #f0f9ff;
}

/* ── Modal overlay ala software lama ── */
.krs-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    z-index: 2000;
    align-items: flex-start;
    justify-content: center;
    padding: 30px 15px;
    overflow-y: auto;
}
.krs-modal-overlay.show {
    display: flex;
}
.krs-modal-box {
    background: #fff;
    border-radius: 8px;
    width: 100%;
    box-shadow: 0 10px 40px rgba(0,0,0,.25);
    overflow: hidden;
}
.krs-modal-head {
    background: #1e3a5f;
    color: #fff;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}
.krs-modal-close {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 20px;
    line-height: 1;
    cursor: pointer;
    padding: 0 4px;
}
.krs-modal-close:hover {
    color: #fecaca;
}
.krs-modal-body {
    padding: 16px;
    max-height: 80vh;
    overflow-y: auto;
}
</style>

<script>
$(document).ready(function () {

    var CSRF        = '<?= $csrfToken ?>';
    var SUBTOTAL    = <?= !empty($totalPaidSoFar) ? (float)$outstandingAmount : (float)$billing->subtotal ?>;
    var ADD_URL     = '<?= $addItemUrl ?>';
    var HAPUS_BASE  = '<?= $this->Url->build(['action' => 'hapusItem', 0]) ?>'.replace('/0', '/');
    var BILLING_ID  = <?= (int)$billing->id ?>;

    window.printKwitansi = function (url) {
        var $frame = $('#print-kwitansi-frame');
        $frame.off('load').on('load', function () {
            var win = this.contentWindow;
            win.focus();
            win.print();
        });
        $frame.attr('src', url);
    };

    // ── Buka/tutup modal Bayar ──────────────────────────────────────────
    $('#btn-buka-bayar').on('click', function () {
        $('#modal-bayar-overlay').addClass('show');
    });
    $('#btn-tutup-bayar').on('click', function () {
        $('#modal-bayar-overlay').removeClass('show');
    });
    $('#modal-bayar-overlay').on('click', function (e) {
        if (e.target === this) { $(this).removeClass('show'); }
    });

    // ── Buka/tutup modal Tambah Item ────────────────────────────────────
    $('#btn-tambah-item').on('click', function () {
        $('#modal-tambah-item-overlay').addClass('show');
        $('#new-item-name').focus();
    });
    $('#btn-cancel-item, #btn-cancel-item-2').on('click', function () {
        $('#modal-tambah-item-overlay').removeClass('show');
        resetItemForm();
    });
    $('#modal-tambah-item-overlay').on('click', function (e) {
        if (e.target === this) { $(this).removeClass('show'); resetItemForm(); }
    });

    // ── Tombol Refresh di panel Ringkasan Total ─────────────────────────
    $('#btn-refresh-kasir').on('click', function () {
        location.reload();
    });

    // ── Tombol-tombol tambahan ala software lama (E-Order, Alkes, dst) ──
    // NOTE: endpoint di bawah ini masih placeholder. Sambungkan ke action
    // controller yang sesuai setelah fitur backend-nya dibuat.
    $('#btn-e-order').on('click', function () {
        alert('Fitur E-Order belum terhubung ke backend.');
    });
    $('#btn-alkes').on('click', function () {
        alert('Fitur Alkes yg Dibebankan Ke Pasien belum terhubung ke backend.');
    });
    $('#btn-riwayat-resep').on('click', function () {
        alert('Fitur Riwayat Resep belum terhubung ke backend.');
    });
    $('#btn-pemakaian-oksigen').on('click', function () {
        alert('Fitur Pemakaian Oksigen belum terhubung ke backend.');
    });
    $('#btn-cetak-permohonan-rawat').on('click', function () {
        alert('Fitur Cetak Permohonan Rawat belum terhubung ke backend.');
    });

    // ── Checkbox "Sudah siap ditransfer ke rawat inap" ───────────────────
    $('#chk-ready-transfer').on('change', function () {
        var checked = $(this).is(':checked');
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'toggleReadyTransfer', 0]) ?>'.replace('/0', '/' + BILLING_ID),
            method: 'POST',
            headers: { 'X-CSRF-Token': CSRF },
            data: { ready_to_transfer: checked ? 1 : 0 },
            dataType: 'json',
            error: function () {
                alert('Gagal menyimpan status. Pastikan action toggleReadyTransfer sudah dibuat di controller.');
            }
        });
    });

    // ── Metode bayar visual ───────────────────────────────────────────────
    $('.payment-method-btn').on('click', function () {
        $('.payment-method-btn').removeClass('active').css('border-color', '#dee2e6');
        $(this).addClass('active').css('border-color', $(this).data('color'));
        $(this).find('input[type=radio]').prop('checked', true);

        var val = $(this).data('value');
        if (val === 'tunai') {
            $('#wrap-jumlah-bayar').show();
        } else {
            $('#wrap-jumlah-bayar').hide();
            $('#wrap-kembalian').hide();
        }

        // Field jaminan hanya relevan untuk BPJS / Asuransi
        if (val === 'bpjs' || val === 'asuransi') {
            $('#wrap-jaminan-fields').show();
        } else {
            $('#wrap-jaminan-fields').hide();
        }

        if (val === 'transfer') {
            $('#wrap-transfer-fields').show();
        } else {
            $('#wrap-transfer-fields').hide();
        }

        calcTotal();
    });
    // Aktifkan default
    $('.payment-method-btn[data-value="tunai"]').trigger('click');

        // ── Diskon per kategori → dijumlahkan otomatis jadi satu nilai diskon global ──
    function calcTotal() {
        var diskonKategori = 0;
        $('.kategori-diskon').each(function () {
            diskonKategori += parseFloat($(this).val()) || 0;
        });

        var adminFee    = parseFloat($('#jaminan-admin-fee').val()) || 0;
        var diskonManual = parseFloat($('#diskon-total-manual').val()) || 0;
        var totalDiskon  = diskonKategori + diskonManual;

        var totalRp = SUBTOTAL + adminFee;
        var totalNet = Math.max(0, totalRp - totalDiskon);

        // Update tampilan tabel breakdown
        $('#cat-total-rp').text(totalRp.toLocaleString('id-ID'));
        $('#cat-tot-diskon-rp').text(totalDiskon.toLocaleString('id-ID'));
        $('#cat-total-net-rp').text('Rp ' + totalNet.toLocaleString('id-ID'));
        $('#jaminan-total-1').text(totalNet.toLocaleString('id-ID'));

        // Kirim sebagai satu nilai diskon nominal ke backend (schema saat ini
        // hanya mendukung satu discount_type/discount_value global)
        $('#discount-type').val('nominal');
        $('#discount-value').val(totalDiskon);

        $('#calc-diskon').text(totalDiskon.toLocaleString('id-ID'));
        $('#calc-total').text(totalNet.toLocaleString('id-ID'));
        $('#paid-amount').val(totalNet);
        calcKembalian();
        calcTransferGrandTotal(totalNet);
    }

    function calcTransferGrandTotal(totalNet) {
        var adminPercent = parseFloat($('#transfer-admin-percent').val()) || 0;
        var adminAmount = Math.round(totalNet * adminPercent / 100);
        var grandTotal = totalNet + adminAmount;

        $('#transfer-total-cdtr').text(totalNet.toLocaleString('id-ID'));
        $('#transfer-grand-total').text(grandTotal.toLocaleString('id-ID'));
    }

    $(document).on('input change', '#transfer-admin-percent', function () {
        var totalNet = parseInt($('#calc-total').text().replace(/\./g, '')) || 0;
        calcTransferGrandTotal(totalNet);
    });

    $(document).on('input change', '.kategori-diskon, #jaminan-admin-fee, #diskon-total-manual', calcTotal);

    // ── Kembalian ─────────────────────────────────────────────────────────
    function calcKembalian() {
        var total  = parseInt($('#calc-total').text().replace(/\./g, '')) || 0;
        var bayar  = parseFloat($('#paid-amount').val()) || 0;
        var kembali = Math.max(0, bayar - total);
        $('#calc-kembalian').text(kembali.toLocaleString('id-ID'));
        if (kembali >= 0 && bayar > 0) {
            $('#wrap-kembalian').show();
        } else {
            $('#wrap-kembalian').hide();
        }
    }

    $('#paid-amount').on('input', calcKembalian);

    // Nominal cepat
    $('.btn-nominal').on('click', function () {
        var cur = parseFloat($('#paid-amount').val()) || 0;
        $('#paid-amount').val(cur + parseInt($(this).data('value')));
        calcKembalian();
    });

    $('.btn-nominal-exact').on('click', function () {
        var total = parseInt($('#calc-total').text().replace(/\./g, '')) || 0;
        $('#paid-amount').val(total);
        calcKembalian();
    });

        // ── Simpan Item ───────────────────────────────────────────────────────
        $('#btn-save-item').on('click', function () {
        var name = $.trim($('#new-item-name').val());
        if (!name) { alert('Nama item wajib diisi.'); return; }

        var $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: ADD_URL, method: 'POST',
            headers: { 'X-CSRF-Token': CSRF },
            data: {
                item_type:  $('#new-item-type').val(),
                item_name:  name,
                quantity:   $('#new-item-qty').val(),
                unit_price: $('#new-item-price').val(),
            },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $('#modal-tambah-item-overlay').removeClass('show');
                    location.reload();
                } else {
                    alert(res.message || 'Gagal menyimpan.');
                    $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
                }
            },
            error: function () {
                alert('Terjadi kesalahan.');
                $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
            }
        });
    });

    function resetItemForm() {
        $('#new-item-type').val('tindakan');
        $('#new-item-name').val('');
        $('#new-item-qty').val(1);
        $('#new-item-price').val(0);
    }

    // ── Hapus Item ────────────────────────────────────────────────────────
    $(document).on('click', '.btn-hapus-item', function () {
        if (!confirm('Hapus item ini?')) return;
        var itemId = $(this).data('id');
        var $row   = $(this).closest('tr');
        var $btn   = $(this).prop('disabled', true);

        $.ajax({
            url: HAPUS_BASE + itemId,
            method: 'POST',
            headers: { 'X-CSRF-Token': CSRF },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $row.fadeOut(200, function() { $(this).remove(); });
                    location.reload();
                } else {
                    alert(res.message || 'Gagal menghapus.');
                    $btn.prop('disabled', false);
                }
            },
            error: function () {
                alert('Terjadi kesalahan.');
                $btn.prop('disabled', false);
            }
        });
    });

    $('#payment-proof-input').on('change', function () {
        var file = this.files[0];
        if (!file) {
            $('#payment-proof-preview').hide();
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#payment-proof-preview-img').attr('src', e.target.result);
            $('#payment-proof-preview').show();
        };
        reader.readAsDataURL(file);
    });

    calcTotal();
});
</script>