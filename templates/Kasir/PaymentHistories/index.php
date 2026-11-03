<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient|null $patient
 * @var iterable $billingHistory
 * @var \App\Model\Entity\OutpatientBilling|null $selectedBilling
 * @var array $groupedItems
 * @var array $typeLabels
 * @var int|null $billingId
 */

$historyArr = is_array($billingHistory) ? $billingHistory : iterator_to_array($billingHistory);

$urlWith = function (array $extra = []) use ($patient, $billingId) {
    return array_filter(array_merge([
        'patient_id' => $patient->id ?? null,
        'billing_id' => $billingId,
    ], $extra), fn($v) => $v !== null && $v !== '');
};
?>

<?= $this->Krs->breadcrumb('Kasir', 'Riwayat Kwitansi') ?>

<style>
.kw-titlebar{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
.kw-titlebar h4{margin:0;font-weight:700;color:#1e3a5f;font-size:16px;}
.kw-panel{border:1px solid #ddd;background:#fff;margin-bottom:10px;}
.kw-panel-heading{padding:8px 12px;background:#1e3a5f;color:#fff;font-weight:700;font-size:12px;}
.kw-panel-body{padding:10px 12px;background:#f8f9fa;}
.kw-layout{display:grid;grid-template-columns:310px minmax(0,1fr);gap:10px;align-items:start;}
.kw-history-table{font-size:11px;margin:0;background:#fff;}
.kw-history-table th{background:#e9ecef;color:#1e3a5f;font-weight:700;border:1px solid #ddd!important;padding:6px!important;}
.kw-history-table td{border:1px solid #ddd!important;padding:6px!important;vertical-align:middle!important;}
.kw-history-row{cursor:pointer;}
.kw-history-row.active td{background:#1e3a5f!important;color:#fff!important;}
.kw-head label{font-size:11px;margin-bottom:3px;color:#333;font-weight:700;}
.kw-head .form-control[readonly]{background:#fff;cursor:default;}

.kw-modal .modal-dialog{width:1120px;max-width:96%;}
.kw-modal .modal-content{border:2px solid #1e3a5f;border-radius:0;background:#d7e2f6;}
.kw-modal .modal-header{position:relative;padding:8px 40px 8px 12px;background:#1e3a5f;color:#fff;border-bottom:1px solid #10283f;}
.kw-modal .modal-header .modal-title{margin:0;}
.kw-modal .modal-header .close{position:absolute;top:50%;right:10px;transform:translateY(-50%);margin:0;color:#fff;opacity:.85;font-size:20px;line-height:1;}
.kw-modal .modal-header .close:hover{opacity:1;}
.kw-modal .modal-body{padding:10px;background:#dce6f8;}
.kw-modal .modal-footer{padding:8px 10px;background:#1e3a5f;border-top:1px solid #10283f;}
.kw-modal-filter{display:grid;grid-template-columns:95px 1fr;gap:6px;align-items:center;margin-bottom:8px;}
.kw-modal-filter label{margin:0;font-size:12px;font-weight:700;color:#1f355b;}
.kw-modal-table-wrap{height:330px;overflow:auto;border:1px solid #6f8ebc;background:#fff;}
.kw-modal-table{width:100%;margin:0;background:#fff;}
.kw-modal-table th,.kw-modal-table td{border:1px solid #9eaac0!important;padding:4px 6px!important;font-size:12px!important;white-space:nowrap;}
.kw-modal-table th{background:#c7d2e7;color:#1d2f57;text-align:center;}
.kw-modal-table tr:hover td{background:#dbeafe!important;}
.kw-modal-table .row-female td{background:#fde3ec!important;}
.kw-modal-table .row-female:hover td{background:#fbd2e0!important;}
.kw-modal-table .row-male td{background:#e2f0fd!important;}
.kw-modal-table .row-male:hover td{background:#cfe6fb!important;}
.kw-modal-row{cursor:pointer;}
</style>

<div class="kw-titlebar">
    <h4><i class="fa fa-receipt"></i> Riwayat Kwitansi</h4>
</div>

<div class="kw-layout">

    <!-- ══════════════ KIRI ══════════════ -->
    <div class="kw-left">

        <!-- Cari Pasien -->
        <div class="kw-panel">
            <div class="kw-panel-heading"><i class="fa fa-search"></i> Cari Pasien</div>
            <div class="kw-panel-body">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalCariPasienKwitansi">
                    <i class="fa fa-search"></i> Buka Modal Cari Pasien
                </button>
                <div style="font-size:10px; color:#888; margin-top:8px;">
                    Pencarian pasien memakai modal. Ketik Rekam Medis / nama / NIK / telepon / alamat, hasil langsung muncul di bawah.
                </div>
            </div>
        </div>

        <!-- History Kwitansi -->
        <div class="kw-panel">
            <div class="kw-panel-heading" style="display:flex; justify-content:space-between; align-items:center;">
                <span><i class="fa fa-history"></i> History Kwitansi Pasien</span>
                <?php if ($patient): ?>
                    <?= $this->Html->link('<i class="fa fa-times"></i>', ['action' => 'index'],
                        ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => 'Ganti Pasien']) ?>
                <?php endif; ?>
            </div>
            <div class="kw-panel-body" style="padding:0; max-height:520px; overflow-y:auto;">
                <?php if (!$patient): ?>
                    <div style="text-align:center; color:#9ca3af; padding:30px 15px; font-size:12px;">
                        <i class="fa fa-inbox" style="font-size:26px; display:block; margin-bottom:6px;"></i>
                        Belum ada pasien dipilih.
                    </div>
                <?php else: ?>
                    <table class="table kw-history-table">
                        <thead>
                            <tr>
                                <th>No Kwitansi</th>
                                <th style="width:100px;">No Pembayaran</th>
                                <th style="width:70px;">Tanggal</th>
                                <th style="width:50px;">Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($historyArr)): ?>
                                <tr>
                                    <td colspan="4" style="text-align:center; color:#9ca3af; padding:20px;">
                                        Belum ada history kwitansi
                                    </td>
                                </tr>
                            <?php else: foreach ($historyArr as $billing):
                                $isActive = (string)$billingId === (string)$billing->id;
                                $paidDate = $billing->paid_at ? $billing->paid_at->format('d-m-y') : '-';
                                $paidTime = $billing->paid_at ? $billing->paid_at->format('H:i:s') : '-';
                            ?>
                                <tr class="kw-history-row<?= $isActive ? ' active' : '' ?>"
                                    onclick="window.location.href='<?= h($this->Url->build(
                                        ['action' => 'index', '?' => $urlWith(['billing_id' => $billing->id])],
                                        ['escape' => false]
                                    )) ?>'">
                                    <td>
                                        <strong><?= h($billing->receipt_no ?: $billing->billing_no) ?></strong>
                                    </td>
                                    <td style="font-family:monospace; font-size:10px;">
                                        <?= h($paymentNoMap[$billing->id] ?? '-') ?>
                                    </td>
                                    <td><?= h($paidDate) ?></td>
                                    <td><?= h($paidTime) ?></td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ══════════════ KANAN ══════════════ -->
    <div class="kw-right">

        <!-- Head Riwayat / Info Patient -->
        <div class="panel panel-default kw-head" style="margin-bottom:10px;">
            <div class="panel-heading"><i class="fa fa-user"></i> Head Riwayat / Info Patient</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <label>Rekam Medis</label>
                        <input type="text" class="form-control input-sm" value="<?= h($patient->code ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Nama Pasien</label>
                        <input type="text" class="form-control input-sm" value="<?= h($patient->full_name ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>No Identitas</label>
                        <input type="text" class="form-control input-sm" value="<?= h($patient->identity_number ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>Telephone</label>
                        <input type="text" class="form-control input-sm" value="<?= h($patient->phone_number ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Jenis Kelamin</label>
                        <input type="text" class="form-control input-sm" value="<?= h($patient->gender ?? '-') ?>" readonly>
                    </div>
                </div>
                <div class="row" style="margin-top:8px;">
                    <div class="col-md-2">
                        <label>Tgl Lahir</label>
                        <input type="text" class="form-control input-sm"
                               value="<?= !empty($patient->birth_date) ? h($patient->birth_date->format('d-m-Y')) : '-' ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>Gol. Darah</label>
                        <input type="text" class="form-control input-sm" value="<?= h($patient->blood_type ?? '-') ?>" readonly>
                    </div>
                    <div class="col-md-8">
                        <label>Alamat</label>
                        <input type="text" class="form-control input-sm" value="<?= h($patient->address ?? '-') ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Kwitansi -->
        <?php if (!$selectedBilling): ?>
            <div class="panel panel-default">
                <div class="panel-body" style="text-align:center; color:#9ca3af; padding:50px 20px;">
                    <?= !$patient ? 'Pilih pasien terlebih dahulu.' : 'Pilih salah satu No Kwitansi di sebelah kiri.' ?>
                </div>
            </div>
        <?php else:
            $d = $selectedBilling->doctor;
        ?>
            <div class="panel panel-primary">
                <div class="panel-heading" style="background:#1e3a5f; border-color:#1e3a5f; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong style="color:#fff; font-size:12px; display:block;">
                            <i class="fa fa-file-invoice"></i> Kwitansi <?= h($selectedBilling->receipt_no ?: $selectedBilling->billing_no) ?>
                        </strong>
                        <span style="color:#cbd5e1; font-size:10px;">
                            No. Pembayaran: <?= h($paymentNoMap[$selectedBilling->id] ?? '-') ?>
                        </span>
                                        <div style="display:flex; gap:6px;">
                        <?php $isClosed = in_array($selectedBilling->status, ['paid', 'void', 'cancelled'], true); ?>
                        <?php if ($isClosed): ?>
                            <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalReopenBilling"
                                    title="Buka akses kembali untuk emergency">
                                <i class="fa fa-unlock"></i> Buka Akses
                            </button>
                        <?php endif; ?>
                        <?= $this->Html->link(
                            '<i class="fa fa-print"></i> Cetak',
                            ['prefix' => 'Kasir', 'controller' => 'OutpatientBillings', 'action' => 'kwitansi', $selectedBilling->id],
                            ['escape' => false, 'class' => 'btn btn-xs btn-success', 'target' => '_blank']
                        ) ?>
                    </div>
                </div>

                <?php if (!empty($selectedBilling->reopened_at)): ?>
                    <div style="background:#fff3cd; border-bottom:1px solid #ffc107; padding:6px 12px; font-size:11px; color:#856404;">
                        <i class="fa fa-exclamation-triangle"></i>
                        Tagihan ini pernah dibuka kembali (<?= (int)$selectedBilling->reopen_count ?>x) pada
                        <strong><?= $selectedBilling->reopened_at->format('d-m-Y H:i') ?></strong>.
                        Alasan terakhir: <em><?= h($selectedBilling->reopen_reason) ?></em>
                    </div>
                <?php endif; ?>
                <div class="panel-body" style="padding:0;">

                    <!-- Tindakan Poli -->
                    <div style="padding:10px 12px;">
                        <div style="background:#1e3a5f; color:#fff; padding:8px 12px; font-weight:700; font-size:12px;">
                            <i class="fa fa-stethoscope"></i> Pemeriksaan &amp; Tindakan Dokter Poli
                        </div>
                        <table class="table table-bordered table-condensed" style="font-size:11px; margin-bottom:0;">
                            <thead style="background:#f0f4f8;">
                                <tr class="text-center">
                                    <th style="width:70px;">Kode</th>
                                    <th>Tindakan</th>
                                    <th style="width:160px;">Dokter</th>
                                    <th style="width:45px;">Qty</th>
                                    <th style="width:90px;">Harga</th>
                                    <th style="width:90px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tindakanRows = $groupedItems['tindakan'] ?? []; ?>
                                <?php if (empty($tindakanRows)): ?>
                                    <tr><td colspan="6" style="text-align:center; color:#aaa; padding:14px;">Tidak ada tindakan poli.</td></tr>
                                <?php else: $subTindakan = 0; foreach ($tindakanRows as $item): $subTindakan += (float)$item->final_price; ?>
                                    <tr>
                                        <td class="text-center" style="font-family:monospace;"><?= h($item->item_code ?? '-') ?></td>
                                        <td><?= h($item->item_name) ?></td>
                                        <td style="font-size:10px;"><?= h($d->doctor_name ?? '-') ?></td>
                                        <td class="text-center"><?= h($item->quantity) ?></td>
                                        <td class="text-right"><?= number_format((float)$item->unit_price, 0, ',', '.') ?></td>
                                        <td class="text-right" style="font-weight:600;"><?= number_format((float)$item->final_price, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                            <?php if (!empty($tindakanRows)): ?>
                            <tfoot style="background:#f8f9fa; font-weight:700;">
                                <tr>
                                    <td colspan="5" style="text-align:right; padding-right:10px;">Subtotal Tindakan Poli</td>
                                    <td class="text-right"><?= number_format($subTindakan, 0, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                            <?php endif; ?>
                        </table>
                    </div>

                    <!-- Kategori lain: Obat/Resep, Bedah/ODC, Laboratorium, Radiologi -->
                    <div class="row" style="margin:0 8px 10px;">
                        <?php
                        $miniCategories = [
                            'obat'         => ['icon' => 'fa-pills',   'label' => 'Obat / Resep', 'colhead' => 'No. Resep'],
                            'lainnya'      => ['icon' => 'fa-user-md', 'label' => 'Bedah / ODC',  'colhead' => 'No. Transaksi'],
                            'laboratorium' => ['icon' => 'fa-flask',   'label' => 'Laboratorium', 'colhead' => 'No. Periksa'],
                            'radiologi'    => ['icon' => 'fa-x-ray',   'label' => 'Radiologi',    'colhead' => 'No. Periksa'],
                        ];
                        foreach ($miniCategories as $type => $cfg):
                            $rows = $groupedItems[$type] ?? [];
                        ?>
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <div style="background:#f0f4f8; padding:6px 10px; font-weight:700; font-size:11px; border:1px solid #dee2e6; border-bottom:none;">
                                <i class="fa <?= $cfg['icon'] ?>"></i> <?= $cfg['label'] ?>
                            </div>
                            <table class="table table-bordered table-condensed" style="font-size:10px; margin-bottom:0;">
                                <thead style="background:#f8f9fa;">
                                    <tr><th><?= $cfg['colhead'] ?></th><th class="text-right">Total Rp</th></tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($rows)): ?>
                                        <tr><td colspan="2" style="text-align:center; color:#bbb; padding:10px;">Belum ada sumber data</td></tr>
                                    <?php else: foreach ($rows as $item): ?>
                                        <tr>
                                            <td><?= h($item->item_name) ?></td>
                                            <td class="text-right"><?= number_format((float)$item->final_price, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Ringkasan -->
                    <div style="padding:12px 14px; background:#f8f9fa; border-top:1px solid #eee;">
                        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                            <span>Subtotal</span>
                            <span>Rp <?= number_format((float)$selectedBilling->subtotal, 0, ',', '.') ?></span>
                        </div>
                        <?php if ((float)$selectedBilling->discount_amount > 0): ?>
                        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:#dc2626;">
                            <span>Diskon</span>
                            <span>- Rp <?= number_format((float)$selectedBilling->discount_amount, 0, ',', '.') ?></span>
                        </div>
                        <?php endif; ?>
                        <hr style="margin:6px 0;">
                        <div style="display:flex; justify-content:space-between; font-size:15px; font-weight:800; color:#1e3a5f;">
                            <span>GRAND TOTAL</span>
                            <span>Rp <?= number_format((float)$selectedBilling->grand_total, 0, ',', '.') ?></span>
                        </div>
                    </div>

                    <div style="padding:12px 14px; text-align:center;">
                        <?= $this->Html->link(
                            '<i class="fa fa-print"></i> Cetak Kwitansi',
                            ['prefix' => 'Kasir', 'controller' => 'OutpatientBillings', 'action' => 'kwitansi', $selectedBilling->id],
                            ['escape' => false, 'class' => 'btn btn-success btn-block', 'target' => '_blank']
                        ) ?>
                    </div>

                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- ══════════════ MODAL CARI PASIEN (pola AJAX sama seperti Riwayat Pasien) ══════════════ -->
<div class="modal fade kw-modal" id="modalCariPasienKwitansi" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><i class="fa fa-search"></i> Cari Pasien</h4>
      </div>
      <div class="modal-body">
        <div class="kw-modal-filter">
          <label>Kata Kunci</label>
          <input type="text" id="kwPatientSearchInput" class="form-control input-sm"
                 placeholder="Kode / Nama / NIK / Telepon / Alamat" autocomplete="off">
        </div>
        <div class="kw-modal-table-wrap">
          <table class="table table-condensed kw-modal-table">
            <thead>
            <tr>
                <th>Kode</th><th>Nama</th><th>Tgl Lahir</th><th>JK</th>
                <th>No Identitas</th><th>Telepon</th><th>Alamat</th>
            </tr>
            </thead>
            <tbody id="kwPatientResultsBody">
              <tr><td colspan="7" style="text-align:center;color:#888;">Ketik kata kunci untuk mencari pasien</td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php if ($selectedBilling): ?>
<!-- ══════════════ MODAL BUKA AKSES KEMBALI (EMERGENCY) ══════════════ -->
<div class="modal fade" id="modalReopenBilling" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="max-width:480px;">
    <div class="modal-content">
      <?= $this->Form->create(null, [
          'url' => ['prefix' => 'Kasir', 'controller' => 'OutpatientBillings', 'action' => 'reopen', $selectedBilling->id],
          'method' => 'post',
      ]) ?>
      <div class="modal-header" style="background:#dc3545; color:#fff;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Buka Akses Kembali (Emergency)</h4>
      </div>
      <div class="modal-body">
        <p style="font-size:12px; color:#555;">
            Tindakan ini akan membuka akses EMR / CPPT / Resume Medis pasien untuk tagihan
            <strong><?= h($selectedBilling->receipt_no ?: $selectedBilling->billing_no) ?></strong>
            (status kasir tetap <strong>Lunas</strong> — tidak berubah menjadi belum bayar).
            Kalau nanti ada tindakan/obat baru yang ditambahkan dan menambah biaya,
            status kasir akan otomatis berubah jadi "Menunggu Bayar" untuk selisihnya saja.
        </p>
        <div class="form-group">
            <label style="font-size:12px; font-weight:700;">Alasan Pembukaan Akses <span style="color:red;">*</span></label>
            <textarea name="reopen_reason" class="form-control" rows="3" required
                      placeholder="Jelaskan alasan emergency / koreksi data..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="fa fa-unlock"></i> Ya, Buka Akses
        </button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
$(function () {
    var $modal = $('#modalCariPasienKwitansi');
    var $input = $('#kwPatientSearchInput');
    var $body = $('#kwPatientResultsBody');
    var searchTimer = null;

    function esc(v) { return $('<div>').text(v == null ? '' : v).html(); }

    function genderRowClass(gender) {
        var g = (gender == null ? '' : String(gender)).trim().toLowerCase();
        var female = ['w', 'wanita', 'f', 'female', 'perempuan'];
        var male = ['p', 'pria', 'l', 'male', 'laki-laki', 'm'];
        if (female.indexOf(g) !== -1) return 'row-female';
        if (male.indexOf(g) !== -1) return 'row-male';
        return '';
    }

    function renderRows(rows) {
        if (!rows || !rows.length) {
            $body.html('<tr><td colspan="7" style="text-align:center;color:#888;">Tidak ada pasien ditemukan</td></tr>');
            return;
        }
        var html = '';
        rows.forEach(function (p) {
            var rowClass = genderRowClass(p.gender);
            html += '<tr class="kw-modal-row ' + rowClass + '" data-id="' + esc(p.id) + '">'
                + '<td>' + esc(p.code) + '</td>'
                + '<td>' + esc(p.full_name) + '</td>'
                + '<td>' + esc(p.birth_date) + '</td>'
                + '<td>' + esc(p.gender) + '</td>'
                + '<td>' + esc(p.identity_number) + '</td>'
                + '<td>' + esc(p.phone_number) + '</td>'
                + '<td>' + esc(p.address) + '</td>'
                + '</tr>';
        });
        $body.html(html);
    }

    function doSearch(term) {
        $body.html('<tr><td colspan="7" style="text-align:center;color:#888;">Memuat data...</td></tr>');
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'searchPatients']) ?>',
            data: { term: term },
            dataType: 'json'
        }).done(function (resp) {
            renderRows(resp && resp.data ? resp.data : []);
        }).fail(function () {
            $body.html('<tr><td colspan="7" style="text-align:center;color:#c00;">Gagal memuat data</td></tr>');
        });
    }

    // Klik baris -> reload halaman dengan pasien terpilih
    $body.on('click', '.kw-modal-row', function () {
        var id = $(this).data('id');
        window.location.href = '<?= $this->Url->build(['action' => 'index']) ?>?patient_id=' + encodeURIComponent(id);
    });

    $input.on('keyup', function () {
        var term = $input.val().trim();
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { doSearch(term); }, 350);
    });

    // Saat modal dibuka: langsung load semua data (tanpa keyword)
    $modal.on('shown.bs.modal', function () {
        $input.val('').focus();
        doSearch('');
    });
});
</script>