<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 * @var \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface $medicines
 * @var array $lokasiList
 * @var array $kursList
 */

$medicineList = [];
foreach (($medicines ?? []) as $med) {
    $medicineList[] = [
        'id'    => $med->id ?? '',
        'code'  => $med->code ?? '',
        'name'  => $med->name ?? '',
        'unit'  => $med->unit_1 ?? '',
        'price' => (float)($med->hna ?? 0),
    ];
}
?>
<style>
    :root {
        --iv-navy: #1b2a4a;
        --iv-orange: #fd7e14;
        --iv-orange-dark: #e8690b;
        --iv-border: #e5e9f0;
    }
    .iv-breadcrumb { font-size:.85rem; color:#8a93a3; }
    .iv-breadcrumb a { color:#8a93a3; text-decoration:none; }
    .iv-breadcrumb a:hover { color: var(--iv-navy); }
    .iv-page-title { font-size:1.15rem; font-weight:700; color:#1f2937; margin-bottom:0; }
    .iv-page-subtitle { font-size:.78rem; color:#9aa2b1; }
    .iv-card { background:#fff; border-radius:.5rem; border:1px solid var(--iv-border); overflow:hidden; box-shadow:0 1px 2px rgba(16,24,40,.04); }
    .iv-card-header { background: var(--iv-navy); color:#fff; padding:.5rem 1rem; font-weight:600; font-size:.88rem; display:flex; justify-content:space-between; align-items:center; }
    .iv-card-body { padding:.9rem 1rem; }
    .iv-label { font-size:.76rem; font-weight:600; color:#4b5563; margin-bottom:.2rem; display:block; }
    .form-control, .form-select { border-color: var(--iv-border); font-size:.9rem; width:100%; box-sizing:border-box; }
    .iv-table { margin-bottom:0; font-size:.83rem; }
    .iv-table thead th { background:#f8f9fc; border-bottom:2px solid var(--iv-border); color:#4b5563; font-weight:600; white-space:nowrap; padding:.5rem .5rem; }
    .iv-table td { vertical-align:middle; padding:.3rem .5rem; }
    .iv-table input { border:1px solid var(--iv-border); border-radius:.3rem; font-size:.8rem; padding:.28rem .45rem; width:100%; }
    .iv-total-label { text-align:right; font-weight:600; color:#4b5563; }
    .iv-total-value { font-weight:700; color:#d63333; }
    .btn-iv-primary { background: var(--iv-orange); border-color: var(--iv-orange); color:#fff; font-weight:600; }
    .btn-iv-primary:hover { background: var(--iv-orange-dark); border-color: var(--iv-orange-dark); color:#fff; }
    .btn-iv-secondary { background:#fff; border:1px solid var(--iv-border); color:#4b5563; font-weight:600; }
    .btn-hapus-baris { border:none; background:#fdecea; color:#d63333; width:26px; height:26px; border-radius:.3rem; line-height:1; }
    .btn-hapus-baris:hover { background:#fbd6d3; }
    .pilih-obat-row:hover td { background:#f1f4fb; }
    .pilih-obat-row-active td { background:#dbe4ff !important; font-weight:600; }
    .iv-materai-opt { font-weight:500; margin-right:10px; font-size:.85rem; white-space:nowrap; }
    .iv-materai-group { display:flex; align-items:center; height:calc(1.5em + .75rem + 2px); }
    .iv-footer-box { background:#f8f9fc; border-top:1px solid var(--iv-border); padding:.8rem 1rem; }
    .iv-hint { font-size:.68rem; color:#b0512c; margin-top:.2rem; }
</style>

<div class="invoices form content">

    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
        <div>
            <h1 class="iv-page-title">Berita Acara Penerimaan Barang / Invoice</h1>
            <div class="iv-page-subtitle">Catat penerimaan barang dari supplier</div>
        </div>
        <nav class="iv-breadcrumb">
            <a href="<?= $this->Url->build(['controller' => 'Logistik']) ?>">Logistik</a>
            /
            <a href="<?= $this->Url->build(['controller' => 'Invoices', 'action' => 'index']) ?>">Invoice</a>
            / Tambah
        </nav>
    </div>

    <?= $this->Form->create($invoice) ?>

    <div class="iv-card mb-2">
        <div class="iv-card-header">
            <span><i class="bi bi-receipt me-2"></i>Berita Acara Penerimaan Barang / Invoice</span>
        </div>

        <div class="iv-card-body">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Nama Supplier</label>
                    <?= $this->Form->control('nama_supplier', ['label' => false, 'class' => 'form-control']) ?>
                    <div class="iv-hint">Sementara input manual — akan diganti dropdown pencarian supplier.</div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Bapb No</label>
                    <input type="text" class="form-control" value="AUTO" readonly>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Tgl Terima</label>
                    <?= $this->Form->control('tgl_terima', ['label' => false, 'class' => 'form-control', 'value' => date('Y-m-d')]) ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">No Faktur</label>
                    <?= $this->Form->control('no_faktur', ['label' => false, 'class' => 'form-control']) ?>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Sj No</label>
                    <?= $this->Form->control('sj_no', ['label' => false, 'class' => 'form-control']) ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Tgl. Tukar Faktur</label>
                    <?= $this->Form->control('tgl_tukar_faktur', ['label' => false, 'class' => 'form-control']) ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Pembayaran</label>
                    <?= $this->Form->control('pembayaran', [
                        'label' => false,
                        'type' => 'select',
                        'options' => ['cash' => 'Cash', 'kredit' => 'Kredit'],
                        'value' => $invoice->pembayaran ?? 'cash',
                        'class' => 'form-select',
                    ]) ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Tgl Jatuh Tempo</label>
                    <?= $this->Form->control('tgl_jatuh_tempo', ['label' => false, 'class' => 'form-control']) ?>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Diterima di lokasi / gudang</label>
                    <?= $this->Form->control('diterima_lokasi_gudang', [
                        'label' => false,
                        'type' => 'select',
                        'options' => $lokasiList,
                        'empty' => '-- Pilih Lokasi --',
                        'class' => 'form-select',
                    ]) ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Kurs</label>
                    <?= $this->Form->select('kurs', $kursList, [
                        'value' => $invoice->kurs ?? 'IDR',
                        'class' => 'form-select',
                    ]) ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Rate</label>
                    <?= $this->Form->control('rate', [
                        'label' => false,
                        'value' => $invoice->rate ?? 1,
                        'class' => 'form-control',
                    ]) ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="iv-label">Materai</label>
                    <?php $materaiValue = $invoice->materai ?? 'tanpa'; ?>
                    <div class="iv-materai-group">
                        <label class="iv-materai-opt">
                            <input type="radio" name="materai" value="3000" <?= $materaiValue === '3000' ? 'checked' : '' ?>> 3000
                        </label>
                        <label class="iv-materai-opt">
                            <input type="radio" name="materai" value="6000" <?= $materaiValue === '6000' ? 'checked' : '' ?>> 6000
                        </label>
                        <label class="iv-materai-opt">
                            <input type="radio" name="materai" value="tanpa" <?= $materaiValue === 'tanpa' ? 'checked' : '' ?>> Tanpa
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="iv-card mb-2">
        <div class="iv-card-header">
            <span><i class="bi bi-box-seam me-2"></i>Detail Barang</span>
            <button type="button" class="btn btn-iv-secondary btn-sm" disabled title="Fitur cek obat menyusul">
                <i class="bi bi-check2-square me-1"></i> Cek Obat
            </button>
        </div>
        <div class="iv-card-body p-0">
            <div class="table-responsive">
                <table id="grid-detail" class="table iv-table mb-0">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Discount%</th>
                            <th>Discount Rp</th>
                            <th>Tax</th>
                            <th>Total Harga</th>
                            <th>Tgl Kadaluarsa</th>
                            <th>Po No</th>
                            <th>Histori</th>
                            <th>Nilai D</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="grid-detail-body"></tbody>
                </table>
            </div>
            <div class="p-2 border-top">
                <button type="button" id="btn-tambah-obat" class="btn btn-iv-secondary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </button>
            </div>
        </div>

        <div class="iv-footer-box">
            <div class="row g-3 align-items-end">
                <div class="col-lg-2">
                    <label class="iv-label">Discount %</label>
                    <?= $this->Form->control('discount_percent', ['label' => false, 'class' => 'form-control', 'id' => 'invoice-discount-percent', 'value' => $invoice->discount_percent ?? 0]) ?>
                </div>
                <div class="col-lg-2">
                    <label class="iv-label">Discount Rp</label>
                    <?= $this->Form->control('discount_rp', ['label' => false, 'class' => 'form-control', 'id' => 'invoice-discount-rp', 'value' => $invoice->discount_rp ?? 0]) ?>
                </div>
                <div class="col-lg-2">
                    <label class="iv-total-label mb-1 d-block">Total</label>
                    <div id="grand-subtotal" class="iv-total-value">0.00</div>
                </div>
                <div class="col-lg-3">
                    <label class="iv-label">Ongkos Kirim Rp</label>
                    <?= $this->Form->control('ongkos_kirim', ['label' => false, 'class' => 'form-control', 'id' => 'invoice-ongkos-kirim', 'value' => $invoice->ongkos_kirim ?? 0]) ?>
                </div>
                <div class="col-lg-3">
                    <label class="iv-total-label mb-1 d-block">Nilai Akhir</label>
                    <div id="grand-final" class="iv-total-value">0.00</div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <label class="iv-label">Catatan</label>
                    <?= $this->Form->control('catatan', ['label' => false, 'type' => 'textarea', 'class' => 'form-control', 'rows' => 2]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-3">
        <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn btn-iv-secondary']) ?>
        <button type="button" class="btn btn-warning" onclick="window.print()"><i class="bi bi-printer me-1"></i>Print</button>
        <?= $this->Form->button(__('Simpan'), ['class' => 'btn btn-iv-primary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<!-- Modal Pilih Obat -->
<div class="modal fade" id="modal-pilih-obat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--iv-navy); color:#fff;">
                <h6 class="modal-title mb-0"><i class="bi bi-search me-2"></i>Pilih Obat</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <input type="text" id="pilih-obat-search" class="form-control form-control-sm"
                           placeholder="Ketik kode / nama obat..." autocomplete="off">
                </div>
                <div class="row g-2">
                    <div class="col-lg-8">
                        <div class="table-responsive" style="max-height:360px; overflow:auto; border:1px solid var(--iv-border);">
                            <table class="table table-sm table-hover mb-0">
                                <thead style="position:sticky; top:0; background:#f8f9fc;">
                                    <tr>
                                        <th style="width:34px;">Pilih</th>
                                        <th style="width:110px;">Kode</th>
                                        <th>Nama Obat</th>
                                        <th style="width:80px;">Satuan</th>
                                        <th style="width:110px;" class="text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody id="pilih-obat-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="fw-semibold small mb-1">Obat Terpilih</div>
                        <div class="table-responsive" style="max-height:360px; overflow:auto; border:1px solid var(--iv-border);">
                            <table class="table table-sm mb-0">
                                <thead style="position:sticky; top:0; background:#f8f9fc;">
                                    <tr><th style="width:90px;">Kode</th><th>Nama</th><th style="width:30px;"></th></tr>
                                </thead>
                                <tbody id="pilih-obat-selected-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-iv-primary btn-sm" id="btn-pilih-obat-ok">
                    <i class="bi bi-check-lg me-1"></i>OK
                </button>
                <button type="button" class="btn btn-iv-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Template baris grid -->
<table style="display:none">
    <tbody>
        <tr id="row-template">
            <td><input type="text" class="kode-obat" readonly></td>
            <td><input type="text" class="nama-obat" readonly><input type="hidden" class="medicine-id"></td>
            <td><input type="number" step="0.01" class="qty" value="1"></td>
            <td><input type="text" class="satuan"></td>
            <td><input type="number" step="0.01" class="harga" value="0"></td>
            <td><input type="number" step="0.01" class="discount-percent" value="0"></td>
            <td><input type="number" step="0.01" class="discount-rp" value="0"></td>
            <td><input type="number" step="0.01" class="tax" value="0"></td>
            <td class="total-display">0.00</td>
            <td><input type="date" class="tgl-kadaluarsa"></td>
            <td><input type="text" class="po-no"></td>
            <td><input type="text" class="histori"></td>
            <td><input type="number" step="0.01" class="nilai-diskon" value="0"></td>
            <td><button type="button" class="btn-hapus-baris">✕</button></td>
        </tr>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let rowIndex = 0;
    const tbody = document.getElementById('grid-detail-body');
    const rowTemplate = document.getElementById('row-template');
    const medicineListData = <?= json_encode($medicineList) ?>;

    function formatNumber(n) { return (Math.round(n * 100) / 100).toFixed(2); }
    function escHtml(str) { const d = document.createElement('div'); d.textContent = str == null ? '' : String(str); return d.innerHTML; }

    function updateEmptyState() {
        if (!tbody.querySelector('tr')) {
            tbody.innerHTML = '<tr id="grid-empty-row"><td colspan="14" class="text-center text-muted py-3">Belum ada barang. Klik tombol "Tambah" untuk memilih obat.</td></tr>';
        }
    }

    function recalcRow(tr) {
        const qty = parseFloat(tr.querySelector('.qty').value) || 0;
        const harga = parseFloat(tr.querySelector('.harga').value) || 0;
        const discountPercent = parseFloat(tr.querySelector('.discount-percent').value) || 0;
        const discountRp = parseFloat(tr.querySelector('.discount-rp').value) || 0;
        const tax = parseFloat(tr.querySelector('.tax').value) || 0;

        let subtotal = qty * harga;
        subtotal -= subtotal * (discountPercent / 100);
        subtotal -= discountRp;
        subtotal += subtotal * (tax / 100);

        tr.querySelector('.total-display').textContent = formatNumber(subtotal);
        tr.dataset.total = subtotal;
        recalcFooterTotal();
    }

    function recalcFooterTotal() {
        let subGrand = 0;
        tbody.querySelectorAll('tr[data-index]').forEach(tr => {
            subGrand += parseFloat(tr.dataset.total) || 0;
        });

        const discountPercentInvoice = parseFloat(document.getElementById('invoice-discount-percent').value) || 0;
        const discountRpInvoice = parseFloat(document.getElementById('invoice-discount-rp').value) || 0;
        const ongkosKirim = parseFloat(document.getElementById('invoice-ongkos-kirim').value) || 0;

        let finalTotal = subGrand;
        finalTotal -= finalTotal * (discountPercentInvoice / 100);
        finalTotal -= discountRpInvoice;
        finalTotal += ongkosKirim;

        document.getElementById('grand-subtotal').textContent = formatNumber(subGrand);
        document.getElementById('grand-final').textContent = formatNumber(finalTotal);
    }

    ['invoice-discount-percent', 'invoice-discount-rp', 'invoice-ongkos-kirim'].forEach(function (id) {
        document.getElementById(id).addEventListener('input', recalcFooterTotal);
    });

    function addRow(prefill) {
        prefill = prefill || {};
        const emptyRow = document.getElementById('grid-empty-row');
        if (emptyRow) emptyRow.remove();

        const newRow = rowTemplate.cloneNode(true);
        newRow.id = '';
        newRow.dataset.index = rowIndex;
        newRow.dataset.total = 0;

        newRow.querySelector('.kode-obat').name = `invoice_details[${rowIndex}][kode_barang]`;
        newRow.querySelector('.nama-obat').name = `invoice_details[${rowIndex}][nama_barang]`;
        newRow.querySelector('.medicine-id').name = `invoice_details[${rowIndex}][medicine_id]`;
        newRow.querySelector('.qty').name = `invoice_details[${rowIndex}][qty]`;
        newRow.querySelector('.satuan').name = `invoice_details[${rowIndex}][satuan]`;
        newRow.querySelector('.harga').name = `invoice_details[${rowIndex}][harga]`;
        newRow.querySelector('.discount-percent').name = `invoice_details[${rowIndex}][discount_percent]`;
        newRow.querySelector('.discount-rp').name = `invoice_details[${rowIndex}][discount_rp]`;
        newRow.querySelector('.tax').name = `invoice_details[${rowIndex}][tax]`;
        newRow.querySelector('.tgl-kadaluarsa').name = `invoice_details[${rowIndex}][tgl_kadaluarsa]`;
        newRow.querySelector('.po-no').name = `invoice_details[${rowIndex}][po_no]`;
        newRow.querySelector('.histori').name = `invoice_details[${rowIndex}][histori]`;
        newRow.querySelector('.nilai-diskon').name = `invoice_details[${rowIndex}][nilai_diskon]`;

        if (prefill.code) {
            newRow.querySelector('.kode-obat').value = prefill.code || '';
            newRow.querySelector('.nama-obat').value = prefill.name || '';
            newRow.querySelector('.medicine-id').value = prefill.id || '';
            newRow.querySelector('.satuan').value = prefill.unit || '';
            newRow.querySelector('.harga').value = prefill.price || 0;
        }

        newRow.querySelectorAll('.qty, .harga, .discount-percent, .discount-rp, .tax').forEach(input => {
            input.addEventListener('input', () => recalcRow(newRow));
        });

        newRow.querySelector('.btn-hapus-baris').addEventListener('click', function () {
            newRow.remove();
            recalcFooterTotal();
            updateEmptyState();
        });

        tbody.appendChild(newRow);
        rowIndex++;
        recalcRow(newRow);
    }

    updateEmptyState();

    // ============ Modal Pilih Obat ============
    let selectedObatList = [];
    const modalPilihObat = new bootstrap.Modal(document.getElementById('modal-pilih-obat'));
    const tbodyPilihObat = document.getElementById('pilih-obat-tbody');
    const tbodySelectedObat = document.getElementById('pilih-obat-selected-tbody');
    const inputSearchObat = document.getElementById('pilih-obat-search');

    function isObatSelected(code) { return selectedObatList.some(d => d.code === code); }

    function renderPilihObatRows(list) {
        if (!list.length) {
            tbodyPilihObat.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-3">Obat tidak ditemukan.</td></tr>';
            return;
        }
        let html = '';
        list.forEach(function (d) {
            const active = isObatSelected(d.code) ? ' pilih-obat-row-active' : '';
            const checked = isObatSelected(d.code) ? ' checked' : '';
            html += '<tr class="pilih-obat-row' + active + '" data-code="' + escHtml(d.code) + '">'
                + '<td class="text-center"><input type="checkbox" class="pilih-obat-check"' + checked + '></td>'
                + '<td>' + escHtml(d.code) + '</td>'
                + '<td>' + escHtml(d.name) + '</td>'
                + '<td>' + escHtml(d.unit) + '</td>'
                + '<td class="text-end">' + formatNumber(d.price) + '</td>'
                + '</tr>';
        });
        tbodyPilihObat.innerHTML = html;
    }

    function renderSelectedObatTable() {
        if (!selectedObatList.length) {
            tbodySelectedObat.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-3">Belum ada obat dipilih.</td></tr>';
            return;
        }
        let html = '';
        selectedObatList.forEach(function (d) {
            html += '<tr><td>' + escHtml(d.code) + '</td><td>' + escHtml(d.name) + '</td>'
                + '<td class="text-center"><button type="button" class="btn btn-sm btn-hapus-baris btn-remove-selected-obat" data-code="' + escHtml(d.code) + '">&times;</button></td></tr>';
        });
        tbodySelectedObat.innerHTML = html;
    }

    function toggleObatRow(code) {
        const idx = selectedObatList.findIndex(d => d.code === code);
        if (idx >= 0) {
            selectedObatList.splice(idx, 1);
        } else {
            const found = medicineListData.find(d => d.code === code);
            if (found) selectedObatList.push(found);
        }
        renderSelectedObatTable();
        filterObatModal(inputSearchObat.value);
    }

    function filterObatModal(q) {
        q = (q || '').trim().toLowerCase();
        const filtered = medicineListData.filter(d => !q || (d.code || '').toLowerCase().includes(q) || (d.name || '').toLowerCase().includes(q));
        renderPilihObatRows(filtered);
    }

    tbodyPilihObat.addEventListener('click', function (e) {
        const tr = e.target.closest('.pilih-obat-row');
        if (tr) toggleObatRow(tr.dataset.code);
    });
    tbodySelectedObat.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-remove-selected-obat');
        if (btn) toggleObatRow(btn.dataset.code);
    });
    inputSearchObat.addEventListener('input', function () { filterObatModal(this.value); });

    document.getElementById('btn-tambah-obat').addEventListener('click', function () {
        selectedObatList = [];
        inputSearchObat.value = '';
        renderSelectedObatTable();
        filterObatModal('');
        modalPilihObat.show();
        setTimeout(() => inputSearchObat.focus(), 300);
    });

    document.getElementById('btn-pilih-obat-ok').addEventListener('click', function () {
        if (!selectedObatList.length) { alert('Pilih minimal 1 obat terlebih dahulu.'); return; }
        selectedObatList.forEach(function (d) { addRow(d); });
        modalPilihObat.hide();
    });
});
</script>