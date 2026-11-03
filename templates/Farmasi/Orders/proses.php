<?php
$isResepLuar = $isResepLuar ?? empty($order->id);

$patient = $patient ?? ($order->patient ?? null);
$doctor = $doctor ?? ($order->doctor ?? null);
$registration = $registration ?? ($order->registration ?? null);

$serviceType = $registration->service_type ?? '-';
if ($serviceType === 'rawat_jalan') {
    $asalPasien = 'Rawat Jalan';
} elseif ($serviceType === 'igd') {
    $asalPasien = 'Rawat IGD';
} else {
    $asalPasien = $isResepLuar ? '-' : ucwords(str_replace('_', ' ', (string)$serviceType));
}

$umur = '-';
if (!empty($patient->birth_date)) {
    $birth = is_object($patient->birth_date) ? $patient->birth_date->format('Y-m-d') : $patient->birth_date;
    $umur = (new DateTime())->diff(new DateTime($birth))->y . ' Th';
}

// URL submit: kalau resep luar (belum ada order id) submit ke proses tanpa id,
// kalau sudah ada order (dari Antrian Farmasi) submit ke proses/{id} seperti biasa.
$submitUrl = $isResepLuar ? ['action' => 'proses'] : ['action' => 'proses', $order->id];
$formatDate = function ($value, string $format) {
    if (empty($value)) {
        return date($format);
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format($format);
    }
    $ts = strtotime((string)$value);
    return $ts ? date($format, $ts) : date($format);
};
?>
<div class="orders content proses-resep" style="font-size:12px;">

<?= $this->Form->create(null, ['url' => $submitUrl, 'id' => 'form-proses']) ?>

<!-- ============ HEADER BAR ============ -->
<div style="display:flex; justify-content:space-between; align-items:center; background:#1e3a5f; padding:8px 12px; border-radius:3px 3px 0 0;">
    <h4 style="margin:0; font-weight:700; color:#fff;">
        <i class="fa fa-flask"></i> PENJUALAN OBAT / RESEP
    </h4>
    <strong style="color:#ff5c5c; font-size:13px;">
        <?= $isResepLuar ? 'PENJUALAN RESEP LUAR (TANPA REGISTRASI)' : 'PENJUALAN RESEP PASIEN RJ/IGD' ?>
    </strong>
</div>

<div class="panel panel-default" style="border-top:none; margin-bottom:10px;">
    <div class="panel-body" style="padding:10px 12px; background:#f8f9fa;">

        <!-- Row 1: No Order / Nama Depo -->
        <div class="row" style="margin-bottom:6px;">
            <div class="col-md-3">
                <label>No Order</label>
                <input type="text" class="form-control input-sm" value="<?= $isResepLuar ? 'AUTO (saat posting)' : h($order->no_order) ?>" readonly>
            </div>
            <div class="col-md-3">
                <label>Nama Depo</label>
                <input type="text" class="form-control input-sm" value="<?= h($order->lokasi_depo ?? 'FARMASI 2 RAJAL DEPO') ?>" readonly>
            </div>
            <div class="col-md-3">
                <label>Dari</label>
                <input type="text" class="form-control input-sm" value="<?= $isResepLuar ? '-' : h($doctor->doctor_name ?? $doctor->name ?? '-') ?>" readonly>
            </div>
            <div class="col-md-3">
                <label>Cara Bayar</label>
                <input type="text" class="form-control input-sm" value="<?= $isResepLuar ? 'UMUM (Tunai)' : h($registration->insurance_type ?? $registration->payment_method ?? 'UMUM') ?>" readonly>
            </div>
        </div>

        <!-- Row 2: No Resep / Tanggal / Jam / Jam Selesai -->
        <div class="row" style="margin-bottom:6px;">
            <div class="col-md-2">
                <label>No. Resep</label>
                <input type="text" class="form-control input-sm" value="AUTO" readonly>
            </div>
            <div class="col-md-2">
                <label>Tanggal</label>
                <input type="text" class="form-control input-sm" value="<?= h($formatDate($order->tgl_order, 'd-m-Y')) ?>" readonly>
            </div>
            <div class="col-md-2">
                <label>Jam</label>
                <input type="text" class="form-control input-sm" value="<?= h($formatDate($order->tgl_order, 'H:i:s')) ?>" readonly>
            </div>
            <div class="col-md-2">
                <label>Jam Selesai Resep</label>
                <input type="text" class="form-control input-sm" value="" readonly>
            </div>
            <div class="col-md-2">
                <label>Kelas</label>
                <input type="text" class="form-control input-sm" value="" readonly>
            </div>
            <div class="col-md-2">
                <label>Telepon</label>
                <input type="text" class="form-control input-sm" value="" readonly>
            </div>
        </div>

        <!-- Row 3: Pembeli radio / No Registrasi / No RM / Resep dari -->
        <div class="row" style="margin-bottom:6px;">
            <div class="col-md-2">
                <label>Pembeli</label>
                <div style="padding-top:6px;">
                    <label class="radio-inline" style="margin-right:10px;">
                        <input type="radio" name="pembeli" value="pasien" <?= !$isResepLuar ? 'checked' : '' ?> <?= $isResepLuar ? 'disabled' : '' ?>> Pasien
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="pembeli" value="luar" <?= $isResepLuar ? 'checked' : '' ?>> Resep Luar
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <label>No Registrasi</label>
                <input type="text" class="form-control input-sm" value="<?= $isResepLuar ? '-' : h($registration->registration_no ?? $registration->registration_number ?? '-') ?>" readonly>
            </div>
            <div class="col-md-2">
                <label>No RM</label>
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" value="<?= $isResepLuar ? '-' : h($medicalRecordNo) ?>" readonly>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-sm" type="button" <?= $isResepLuar ? 'disabled' : '' ?>><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <label>Resep dari</label>
                <input type="text" class="form-control input-sm" value="<?= $isResepLuar ? 'Pembelian Langsung' : '' ?>" readonly>
            </div>
            <div class="col-md-2">
                <label>SEP</label>
                <input type="text" class="form-control input-sm" value="" readonly>
            </div>
        </div>

        <!-- Row 4: Nama Pasien/Pembeli / Umur / status BELUM POSTING -->
        <div class="row">
            <div class="col-md-6">
                <?php if ($isResepLuar): ?>
                    <label>Nama Pembeli <span style="color:#c00;">*</span></label>
                    <input type="text" name="nama_pembeli" class="form-control input-sm" placeholder="Nama pembeli / karyawan..." required>
                <?php else: ?>
                    <label>Nama Pasien</label>
                    <input type="text" class="form-control input-sm" value="<?= h($patient->full_name ?? '-') ?>" readonly>
                <?php endif; ?>
            </div>
            <div class="col-md-2">
                <label>Umur Pasien</label>
                <input type="text" class="form-control input-sm" value="<?= $isResepLuar ? '-' : h($umur) ?>" readonly>
            </div>
            <div class="col-md-4" style="display:flex; align-items:flex-end; justify-content:flex-end;">
                <strong style="color:#ff0000; font-size:13px;">
                    <?= ((int)($order->status_id ?? 1) === 1) ? 'BELUM POSTING' : 'SUDAH POSTING' ?>
                </strong>
            </div>
        </div>

    </div>
</div>

<?php if ($isResepLuar): ?>
<!-- ============ CARI & TAMBAH OBAT (khusus Resep Luar) ============ -->
<div class="panel panel-default">
    <div class="panel-heading" style="padding:8px 12px; background:#dbeafe;">
        <strong style="font-size:12px;">Cari & Tambah Obat</strong>
    </div>
    <div class="panel-body" style="padding:10px 12px;">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <input type="text" id="obat-search-input" class="form-control" placeholder="Ketik kode/nama obat, min 2 huruf...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary" id="obat-search-btn"><i class="fa fa-search"></i> Cari</button>
                    </span>
                </div>
                <ul id="obat-search-results" class="list-group" style="position:relative; z-index:10; max-height:220px; overflow-y:auto; margin-top:2px; display:none;"></ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ============ TABLE DETAIL RESEP ============ -->
<div class="panel panel-default">
    <div class="panel-body" style="padding:0;">
        <div style="overflow-x:auto;">
            <table class="table table-bordered table-condensed" style="font-size:11px; margin:0;" id="proses-table">
                <thead>
                    <tr style="background:#dbeafe;">
                        <th style="width:80px;">Kode</th>
                        <th style="min-width:160px;">Nama</th>
                        <th style="width:70px; text-align:center;">Qty Order</th>
                        <th style="width:60px; text-align:center;">Qty</th>
                        <th style="width:70px; text-align:center;">Qty Pasien</th>
                        <th style="width:80px; text-align:center;">Qty Tagih</th>
                        <th style="width:65px;">Satuan</th>
                        <th style="width:85px; text-align:right;">Harga</th>
                        <th style="width:75px; text-align:center;">Disc %/PPN</th>
                        <th style="width:75px; text-align:right;">PPN Rp</th>
                        <th style="width:100px; text-align:right;">Total Harga</th>
                        <th style="width:100px;">Tgl Kadaluarsa</th>
                        <th style="min-width:110px;">Aturan Pakai</th>
                        <th style="width:100px;">Waktu Minum</th>
                        <th style="width:60px; text-align:center;">Etiket</th>
                        <th style="width:80px; text-align:center;">Kronis/Kemo</th>
                        <?php if ($isResepLuar): ?>
                        <th style="width:40px;"></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="proses-table-body">
                    <?php $subtotal = 0; ?>
                    <?php if (!empty($order->order_prescriptions)): ?>
                        <?php foreach ($order->order_prescriptions as $rx): ?>
                            <?php
                            $medicine = $rx->medicine ?? null;
                            $qtyOrder = (float)($rx->qty_satuan ?? 0);
                            $harga = (float)($rx->harga ?? 0);
                            $totalHarga = (float)($rx->total_harga ?? ($qtyOrder * $harga));
                            $subtotal += $totalHarga;
                            ?>
                            <tr>
                                <td><?= h($medicine->code ?? '-') ?></td>
                                <td>
                                    <?= h($medicine->name ?? '-') ?>
                                </td>
                                <td style="text-align:center;"><?= h($qtyOrder) ?></td>
                                <td style="text-align:center;"><?= h($qtyOrder) ?></td>
                                <td style="text-align:center;"><?= h($qtyOrder) ?></td>
                                <td>
                                    <input type="number"
                                           name="prescriptions[<?= $rx->id ?>][qty_tagih]"
                                           class="form-control input-sm qty-tagih-input"
                                           data-harga="<?= h($harga) ?>"
                                           value="<?= h($qtyOrder) ?>"
                                           step="0.5"
                                           min="0"
                                           style="text-align:center;">
                                </td>
                                <td><?= h($medicine->unit_1 ?? '-') ?></td>
                                <td style="text-align:right;"><?= number_format($harga, 0, ',', '.') ?></td>
                                <td style="text-align:center;">0 %</td>
                                <td style="text-align:right;">0</td>
                                <td class="total-harga-cell" style="text-align:right; font-weight:600;">
                                    <?= number_format($totalHarga, 0, ',', '.') ?>
                                <td>-</td>
                                <td><?= h($rx->aturan_pakai ?? '') ?></td>
                                <td>
                                    <select name="prescriptions[<?= $rx->id ?>][waktu_minum]"
                                            class="form-control input-sm waktu-minum-select"
                                            style="font-size:10px; padding:2px 4px;">
                                        <option value="">-- Pilih --</option>
                                        <?php
                                        $waktuOptions = ['Sebelum Makan', 'Sesudah Makan', 'Pagi', 'Siang', 'Sore', 'Malam', 'Sebelum Tidur'];
                                        $waktuTerpilih = $rx->waktu_minum ?? '';
                                        foreach ($waktuOptions as $wo):
                                        ?>
                                            <option value="<?= h($wo) ?>" <?= $waktuTerpilih === $wo ? 'selected' : '' ?>>
                                                <?= h($wo) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="text-align:center;">
                                    <input type="checkbox">
                                </td>
                                <td style="text-align:center;">
                                    <label style="margin:0; cursor:pointer; white-space:nowrap;">
                                        <input type="checkbox"
                                               name="prescriptions[<?= $rx->id ?>][is_kronis]"
                                               value="1"
                                               class="kronis-chk"
                                               <?= !empty($rx->is_kronis) ? 'checked' : '' ?>>
                                        Kronis
                                    </label>
                                </td>
                                <?php if ($isResepLuar): ?>
                                <td></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php elseif (!$isResepLuar): ?>
                        <tr>
                            <td colspan="16" style="text-align:center; color:#aaa; padding:20px;">
                                Tidak ada item resep pada order ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($isResepLuar && empty($order->order_prescriptions)): ?>
                        <tr id="proses-empty-row">
                            <td colspan="17" style="text-align:center; color:#aaa; padding:20px;">
                                Belum ada obat. Cari obat di atas lalu klik hasil pencarian untuk menambahkan baris.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Template baris obat untuk Resep Luar (dipakai oleh JS, tidak ditampilkan) -->
<template id="obat-row-template">
    <tr class="obat-luar-row">
        <td class="cell-kode"></td>
        <td class="cell-nama">
            <input type="hidden" class="input-medicine-id" name="">
        </td>
        <td style="text-align:center;">-</td>
        <td style="text-align:center;">-</td>
        <td style="text-align:center;">-</td>
        <td>
            <input type="number" class="form-control input-sm qty-tagih-input input-qty" value="1" step="0.5" min="0.5" style="text-align:center;">
        </td>
        <td class="cell-satuan"></td>
        <td class="cell-harga" style="text-align:right;"></td>
        <td style="text-align:center;">0 %</td>
        <td style="text-align:right;">0</td>
        <td class="total-harga-cell" style="text-align:right; font-weight:600;">0</td>
        <td>-</td>
        <td>
            <input type="text" class="form-control input-sm input-aturan" placeholder="Aturan pakai...">
        </td>
        <td>
            <select class="form-control input-sm input-waktu-minum" style="font-size:10px; padding:2px 4px;">
                <option value="">-- Pilih --</option>
                <option value="Sebelum Makan">Sebelum Makan</option>
                <option value="Sesudah Makan">Sesudah Makan</option>
                <option value="Pagi">Pagi</option>
                <option value="Siang">Siang</option>
                <option value="Sore">Sore</option>
                <option value="Malam">Malam</option>
                <option value="Sebelum Tidur">Sebelum Tidur</option>
            </select>
        </td>
        <td style="text-align:center;"><input type="checkbox"></td>
        <td style="text-align:center;">
            <label style="margin:0; cursor:pointer; white-space:nowrap;">
                <input type="checkbox" class="input-kronis" value="1"> Kronis
            </label>
        </td>
        <td style="text-align:center;">
            <button type="button" class="btn btn-danger btn-xs btn-remove-row"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
</template>

<!-- ============ BUTTON ROW + ALERGI/OBAT LAIN/CATATAN + TOTALS ============ -->
<div class="panel panel-default">
    <div class="panel-body" style="padding:10px 12px; background:#fafafa;">
        <div class="row">
            <!-- Left: action buttons -->
            <div class="col-md-6">
                <div style="margin-bottom:6px;">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-check"></i> Posting
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                        Resep Sebagian
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                        <i class="fa fa-file"></i> Kertas/Kapsul/Pot
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                        <i class="fa fa-copy"></i> Copy Resep
                    </button>
                </div>
                <div style="margin-bottom:10px;">
                    <button type="button" class="btn btn-default btn-sm">
                        <i class="fa fa-history"></i> History
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                        <i class="fa fa-tag"></i> Etiket
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                        <i class="fa fa-tags"></i> Label BPJS
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                        Tebus Resep
                    </button>
                </div>

                <label style="color:#c00;">Alergi</label>
                <input type="text" class="form-control input-sm" placeholder="Alergi pasien..." <?= $isResepLuar ? 'disabled' : '' ?>>

                <label style="margin-top:8px;">Obat Lain</label>
                <textarea class="form-control input-sm" rows="2" placeholder="Obat lain di luar resep..."></textarea>

                <label style="margin-top:8px;">Catatan Order</label>
                <textarea class="form-control input-sm" rows="2" placeholder="Catatan order..."></textarea>
            </div>

            <!-- Right: totals -->
            <div class="col-md-6">
                <table class="table table-condensed" style="font-size:12px; margin-bottom:10px;">
                    <tr>
                        <td style="width:60%; text-align:right; font-weight:600;">Subtotal</td>
                        <td style="text-align:right; font-weight:700;" id="proses-subtotal">
                            Rp <?= number_format($subtotal, 0, ',', '.') ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Jasa/Embal/Kapsul</td>
                        <td style="text-align:right;">0</td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Diskon</td>
                        <td style="text-align:right;">0</td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Pajak</td>
                        <td style="text-align:right;">0</td>
                    </tr>
                    <tr style="border-top:2px solid #1e3a5f;">
                        <td style="text-align:right; font-weight:700; font-size:14px;">Total</td>
                        <td style="text-align:right; font-weight:700; font-size:14px;">
                            Rp <?= number_format($subtotal, 0, ',', '.') ?>
                        </td>
                    </tr>
                </table>

                <div style="text-align:right;">
                    <?= $this->Html->link(
                        '<i class="fa fa-times"></i> Kembali ke Antrian',
                        ['action' => 'antrianFarmasi'],
                        ['escape' => false, 'class' => 'btn btn-danger btn-sm']
                    ) ?>
                    <button type="button" class="btn btn-warning btn-sm" onclick="window.print()">
                        <i class="fa fa-print"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============ FOOTER: function keys + status bar ============ -->
<div style="background:#eee; border:1px solid #ccc; padding:6px 12px; font-size:11px; color:#333;">
    F2=CETAK LABEL &nbsp;&nbsp; F3=BARU &nbsp;&nbsp; F6=CETAK RESEP &nbsp;&nbsp; F7=CARI DATA &nbsp;&nbsp; F8=CEK HARGA
</div>
<div style="background:#c00000; color:#fff; text-align:center; padding:4px; font-size:11px; font-weight:600;">
    <?= $isResepLuar ? 'Mode Resep Luar - Pembelian Langsung Tanpa Registrasi' : 'Sisa e-order Resep: ' . (int)(count($order->order_prescriptions ?? [])) . ' item' ?>
</div>

<?= $this->Form->end() ?>
</div>

<script>
$(document).ready(function () {
    function fmt(n) { return parseFloat(n || 0).toLocaleString('id-ID'); }

    function recalcSubtotal() {
        var grand = 0;
        $('.qty-tagih-input').each(function () {
            var qty = parseFloat($(this).val()) || 0;
            var harga = parseFloat($(this).data('harga')) || 0;
            var total = qty * harga;
            $(this).closest('tr').find('.total-harga-cell').text(fmt(total));
            grand += total;
        });
        $('#proses-subtotal').text('Rp ' + fmt(grand));
    }

    $(document).on('input', '.qty-tagih-input', recalcSubtotal);

    <?php if ($isResepLuar): ?>
    // ── Resep Luar: cari obat & tambah baris langsung ke tabel ──
    var rowIndex = 0;

    function doSearchObat() {
        var q = $('#obat-search-input').val().trim();
        if (q.length < 2) {
            $('#obat-search-results').hide().empty();
            return;
        }

        $.ajax({
            url: '<?= $this->Url->build(['prefix' => 'Farmasi', 'controller' => 'Orders', 'action' => 'cariObat']) ?>',
            data: { q: q },
            dataType: 'json'
        }).done(function (results) {
            var $list = $('#obat-search-results').empty();

            if (!results || !results.length) {
                $list.append('<li class="list-group-item">Tidak ditemukan.</li>').show();
                return;
            }

            results.forEach(function (item) {
                var $li = $('<li class="list-group-item" style="cursor:pointer;"></li>')
                    .text(item.kode + ' - ' + item.nama + ' (Rp ' + fmt(item.harga) + ' / ' + item.unit + ')')
                    .on('click', function () {
                        addObatRow(item);
                        $('#obat-search-results').hide().empty();
                        $('#obat-search-input').val('').focus();
                    });
                $list.append($li);
            });

            $list.show();
        });
    }

    $('#obat-search-btn').on('click', doSearchObat);
    $('#obat-search-input').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            doSearchObat();
        }
    });

    function addObatRow(item) {
        $('#proses-empty-row').remove();

        rowIndex++;

        var $tpl = document.getElementById('obat-row-template');
        var $row = $($tpl.content ? $tpl.content.firstElementChild.cloneNode(true) : $tpl).clone();

        $row.find('.cell-kode').text(item.kode);
        $row.find('.cell-nama').prepend(document.createTextNode(item.nama + ' '));
        $row.find('.input-medicine-id')
            .attr('name', 'prescriptions[new_' + rowIndex + '][medicine_id]')
            .val(item.id);
        $row.find('.cell-satuan').text(item.unit || '-');
        $row.find('.cell-harga').text(fmt(item.harga));
        $row.find('.input-qty')
            .attr('name', 'prescriptions[new_' + rowIndex + '][qty_tagih]')
            .attr('data-harga', item.harga);
        $row.find('.input-aturan')
            .attr('name', 'prescriptions[new_' + rowIndex + '][aturan_pakai]');
        $row.find('.input-waktu-minum')
            .attr('name', 'prescriptions[new_' + rowIndex + '][waktu_minum]');

        $row.find('.input-kronis')
            .attr('name', 'prescriptions[new_' + rowIndex + '][is_kronis]');

        // input harga tersembunyi supaya ikut terkirim ke server
        $row.find('.cell-nama').append(
            '<input type="hidden" name="prescriptions[new_' + rowIndex + '][harga]" value="' + item.harga + '">'
        );

        $row.find('.btn-remove-row').on('click', function () {
            $(this).closest('tr').remove();
            recalcSubtotal();
        });

        $('#proses-table-body').append($row);
        recalcSubtotal();
    }
    <?php endif; ?>
});
</script>