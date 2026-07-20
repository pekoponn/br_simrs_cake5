<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReturPembelian $returPembelian
 * @var \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface $medicines
 * @var array $depoList
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
        --rt-navy: #1b2a4a;
        --rt-orange: #fd7e14;
        --rt-orange-dark: #e8690b;
        --rt-border: #e5e9f0;
    }
    .rt-breadcrumb { font-size:.85rem; color:#8a93a3; }
    .rt-breadcrumb a { color:#8a93a3; text-decoration:none; }
    .rt-breadcrumb a:hover { color: var(--rt-navy); }
    .rt-page-title { font-size:1.15rem; font-weight:700; color:#1f2937; margin-bottom:0; }
    .rt-page-subtitle { font-size:.78rem; color:#9aa2b1; }
    .rt-card { background:#fff; border-radius:.5rem; border:1px solid var(--rt-border); overflow:hidden; box-shadow:0 1px 2px rgba(16,24,40,.04); }
    .rt-card-header { background: var(--rt-navy); color:#fff; padding:.5rem 1rem; font-weight:600; font-size:.88rem; }
    .rt-card-body { padding:.9rem 1rem; }
    .rt-label { font-size:.76rem; font-weight:600; color:#4b5563; margin-bottom:.2rem; display:block; }
    .form-control, .form-select { border-color: var(--rt-border); font-size:.9rem; }
    .rt-input-search { display:flex; gap:4px; }
    .rt-input-search .form-control { flex:1; }
    .rt-input-search .btn { width:34px; padding:0; }
    .rt-table { margin-bottom:0; font-size:.85rem; }
    .rt-table thead th { background:#f8f9fc; border-bottom:2px solid var(--rt-border); color:#4b5563; font-weight:600; white-space:nowrap; padding:.5rem .6rem; }
    .rt-table td { vertical-align:middle; padding:.35rem .6rem; }
    .rt-table input { border:1px solid var(--rt-border); border-radius:.3rem; font-size:.82rem; padding:.3rem .5rem; width:100%; }
    .rt-total-label { text-align:right; font-weight:600; color:#4b5563; }
    .rt-total-value { font-weight:700; color:#d63333; }
    .btn-rt-primary { background: var(--rt-orange); border-color: var(--rt-orange); color:#fff; font-weight:600; }
    .btn-rt-primary:hover { background: var(--rt-orange-dark); border-color: var(--rt-orange-dark); color:#fff; }
    .btn-rt-secondary { background:#fff; border:1px solid var(--rt-border); color:#4b5563; font-weight:600; }
    .btn-hapus-baris { border:none; background:#fdecea; color:#d63333; width:26px; height:26px; border-radius:.3rem; line-height:1; }
    .btn-hapus-baris:hover { background:#fbd6d3; }
    .pilih-obat-row:hover td { background:#f1f4fb; }
    .pilih-obat-row-active td { background:#dbe4ff !important; font-weight:600; }
</style>

<div class="retur-pembelians form content">

    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
        <div>
            <h1 class="rt-page-title">Retur Pembelian</h1>
            <div class="rt-page-subtitle">Buat retur barang / obat ke supplier</div>
        </div>
        <nav class="rt-breadcrumb">
            <a href="<?= $this->Url->build(['controller' => 'Logistik']) ?>">Logistik</a>
            /
            <a href="<?= $this->Url->build(['controller' => 'ReturPembelians', 'action' => 'index']) ?>">Retur Pembelian</a>
            / Tambah
        </nav>
    </div>

    <?= $this->Form->create($returPembelian) ?>

    <div class="rt-card mb-2">
        <div class="rt-card-header"><i class="bi bi-arrow-return-left me-2"></i>Retur Pembelian</div>
        <div class="rt-card-body">
            <div class="row g-3">
                <div class="col-lg-4">
                    <label class="rt-label">Nama Supplier</label>
                    <?= $this->Form->control('nama_supplier', ['label' => false, 'class' => 'form-control']) ?>
                    <div class="mt-1" style="font-size:.68rem;color:#b0512c;">
                        Sementara input manual — akan diganti dropdown pencarian supplier.
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="rt-label">Tgl Retur</label>
                            <?= $this->Form->control('tgl_retur', ['label' => false, 'class' => 'form-control', 'value' => date('Y-m-d')]) ?>
                        </div>
                        <div class="col-6">
                            <label class="rt-label">No. Faktur</label>
                            <?= $this->Form->control('no_faktur', ['label' => false, 'class' => 'form-control']) ?>
                        </div>
                        <div class="col-12">
                            <label class="rt-label">BAPB No</label>
                            <div class="rt-input-search">
                                <?= $this->Form->control('bapb_no', ['label' => false, 'class' => 'form-control', 'id' => 'bapb-no-input']) ?>
                                <button type="button" class="btn btn-rt-secondary btn-sm" disabled title="Butuh data Berita Acara Penerimaan Barang">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <label class="rt-label">Gudang/Depo</label>
                    <?= $this->Form->control('gudang_depo', [
                        'label' => false,
                        'type' => 'select',
                        'options' => $depoList,
                        'empty' => '-- Pilih Gudang/Depo --',
                        'class' => 'form-select',
                    ]) ?>

                    <label class="rt-label mt-2">Catatan</label>
                    <?= $this->Form->control('catatan', [
                        'label' => false,
                        'type' => 'textarea',
                        'class' => 'form-control',
                        'rows' => 2,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="rt-card mb-2">
        <div class="rt-card-header"><i class="bi bi-box-seam me-2"></i>Detail Barang</div>
        <div class="rt-card-body p-0">
            <div class="table-responsive">
                <table id="grid-detail" class="table rt-table mb-0">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Harga</th>
                            <th>Tax (%)</th>
                            <th>PPN Rp</th>
                            <th>Discount</th>
                            <th>Total Harga</th>
                            <th>Tgl Kadaluarsa</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="grid-detail-body"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="rt-total-label">Total</td>
                            <td id="grand-total" class="rt-total-value">0.00</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="p-2 border-top">
                <button type="button" id="btn-tambah-obat" class="btn btn-rt-secondary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-3">
        <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn btn-rt-secondary']) ?>
        <?= $this->Form->button(__('Simpan'), ['class' => 'btn btn-rt-primary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<!-- Modal Pilih Obat -->
<div class="modal fade" id="modal-pilih-obat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--rt-navy); color:#fff;">
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
                        <div class="table-responsive" style="max-height:360px; overflow:auto; border:1px solid var(--rt-border);">
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
                        <div class="table-responsive" style="max-height:360px; overflow:auto; border:1px solid var(--rt-border);">
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
                <button type="button" class="btn btn-rt-primary btn-sm" id="btn-pilih-obat-ok">
                    <i class="bi bi-check-lg me-1"></i>OK
                </button>
                <button type="button" class="btn btn-rt-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
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
            <td><input type="text" class="unit"></td>
            <td><input type="number" step="0.01" class="harga" value="0"></td>
            <td><input type="number" step="0.01" class="tax" value="0"></td>
            <td><input type="number" step="0.01" class="ppn-rp" value="0"></td>
            <td><input type="number" step="0.01" class="discount" value="0"></td>
            <td class="total-display">0.00</td>
            <td><input type="date" class="tgl-kadaluarsa"></td>
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
            tbody.innerHTML = '<tr id="grid-empty-row"><td colspan="11" class="text-center text-muted py-3">Belum ada barang. Klik tombol "Tambah" untuk memilih obat.</td></tr>';
        }
    }

    function recalcRow(tr) {
        const qty = parseFloat(tr.querySelector('.qty').value) || 0;
        const harga = parseFloat(tr.querySelector('.harga').value) || 0;
        const tax = parseFloat(tr.querySelector('.tax').value) || 0;
        const ppn = parseFloat(tr.querySelector('.ppn-rp').value) || 0;
        const discount = parseFloat(tr.querySelector('.discount').value) || 0;

        let subtotal = (qty * harga) - discount;
        subtotal += subtotal * (tax / 100);
        subtotal += ppn;

        tr.querySelector('.total-display').textContent = formatNumber(subtotal);
        tr.dataset.total = subtotal;
        recalcGrandTotal();
    }

    function recalcGrandTotal() {
        let grand = 0;
        tbody.querySelectorAll('tr[data-index]').forEach(tr => {
            grand += parseFloat(tr.dataset.total) || 0;
        });
        document.getElementById('grand-total').textContent = formatNumber(grand);
    }

    function addRow(prefill) {
        prefill = prefill || {};
        const emptyRow = document.getElementById('grid-empty-row');
        if (emptyRow) emptyRow.remove();

        const newRow = rowTemplate.cloneNode(true);
        newRow.id = '';
        newRow.dataset.index = rowIndex;
        newRow.dataset.total = 0;

        newRow.querySelector('.kode-obat').name = `retur_pembelian_details[${rowIndex}][kode_barang]`;
        newRow.querySelector('.nama-obat').name = `retur_pembelian_details[${rowIndex}][nama_barang]`;
        newRow.querySelector('.medicine-id').name = `retur_pembelian_details[${rowIndex}][medicine_id]`;
        newRow.querySelector('.qty').name = `retur_pembelian_details[${rowIndex}][qty]`;
        newRow.querySelector('.unit').name = `retur_pembelian_details[${rowIndex}][unit]`;
        newRow.querySelector('.harga').name = `retur_pembelian_details[${rowIndex}][harga]`;
        newRow.querySelector('.tax').name = `retur_pembelian_details[${rowIndex}][tax]`;
        newRow.querySelector('.ppn-rp').name = `retur_pembelian_details[${rowIndex}][ppn_rp]`;
        newRow.querySelector('.discount').name = `retur_pembelian_details[${rowIndex}][discount]`;
        newRow.querySelector('.tgl-kadaluarsa').name = `retur_pembelian_details[${rowIndex}][tgl_kadaluarsa]`;

        if (prefill.code) {
            newRow.querySelector('.kode-obat').value = prefill.code || '';
            newRow.querySelector('.nama-obat').value = prefill.name || '';
            newRow.querySelector('.medicine-id').value = prefill.id || '';
            newRow.querySelector('.unit').value = prefill.unit || '';
            newRow.querySelector('.harga').value = prefill.price || 0;
        }

        newRow.querySelectorAll('.qty, .harga, .tax, .ppn-rp, .discount').forEach(input => {
            input.addEventListener('input', () => recalcRow(newRow));
        });

        newRow.querySelector('.btn-hapus-baris').addEventListener('click', function () {
            newRow.remove();
            recalcGrandTotal();
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