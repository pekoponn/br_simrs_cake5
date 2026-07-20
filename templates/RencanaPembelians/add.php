<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RencanaPembelian $rencanaPembelian
 * @var \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface $medicines
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

$statusOptions = [
    'draft' => 'Draft',
    'diajukan' => 'Diajukan',
    'disetujui' => 'Disetujui',
    'ditolak' => 'Ditolak',
];
?>
<style>
    :root {
        --rp-navy: #1b2a4a;
        --rp-orange: #fd7e14;
        --rp-orange-dark: #e8690b;
        --rp-border: #e5e9f0;
    }
    .rp-breadcrumb { font-size:.85rem; color:#8a93a3; }
    .rp-breadcrumb a { color:#8a93a3; text-decoration:none; }
    .rp-breadcrumb a:hover { color: var(--rp-navy); }
    .rp-page-title { font-size:1.15rem; font-weight:700; color:#1f2937; margin-bottom:0; }
    .rp-page-subtitle { font-size:.78rem; color:#9aa2b1; }
    .rp-card { background:#fff; border-radius:.5rem; border:1px solid var(--rp-border); overflow:hidden; box-shadow:0 1px 2px rgba(16,24,40,.04); }
    .rp-card-header { background: var(--rp-navy); color:#fff; padding:.5rem 1rem; font-weight:600; font-size:.88rem; }
    .rp-card-body { padding:.9rem 1rem; }
    .rp-label { font-size:.76rem; font-weight:600; color:#4b5563; margin-bottom:.2rem; display:block; }
    .form-control, .form-select { border-color: var(--rp-border); font-size:.9rem; }
    .rp-btn-outline { width:100%; border:1px dashed #c7cedb; background:#f8f9fc; color:#6b7280; border-radius:.4rem; padding:.4rem; font-size:.8rem; }
    .rp-table { margin-bottom:0; font-size:.85rem; }
    .rp-table thead th { background:#f8f9fc; border-bottom:2px solid var(--rp-border); color:#4b5563; font-weight:600; white-space:nowrap; padding:.5rem .6rem; }
    .rp-table td { vertical-align:middle; padding:.35rem .6rem; }
    .rp-table input, .rp-table select { border:1px solid var(--rp-border); border-radius:.3rem; font-size:.82rem; padding:.3rem .5rem; width:100%; }
    .rp-total-label { text-align:right; font-weight:600; color:#4b5563; }
    .rp-total-value { font-weight:700; color:#d63333; }
    .btn-rp-primary { background: var(--rp-orange); border-color: var(--rp-orange); color:#fff; font-weight:600; }
    .btn-rp-primary:hover { background: var(--rp-orange-dark); border-color: var(--rp-orange-dark); color:#fff; }
    .btn-rp-secondary { background:#fff; border:1px solid var(--rp-border); color:#4b5563; font-weight:600; }
    .btn-hapus-baris { border:none; background:#fdecea; color:#d63333; width:26px; height:26px; border-radius:.3rem; line-height:1; }
    .btn-hapus-baris:hover { background:#fbd6d3; }
    .pilih-obat-row:hover td { background:#f1f4fb; }
    .pilih-obat-row-active td { background:#dbe4ff !important; font-weight:600; }
</style>

<div class="rencana-pembelians form content">

    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
        <div>
            <h1 class="rp-page-title">Rencana Pembelian</h1>
            <div class="rp-page-subtitle">Buat rencana pembelian barang / obat ke supplier</div>
        </div>
        <nav class="rp-breadcrumb">
            <a href="<?= $this->Url->build(['controller' => 'Logistik']) ?>">Logistik</a>
            /
            <a href="<?= $this->Url->build(['controller' => 'RencanaPembelians', 'action' => 'index']) ?>">Rencana Pembelian</a>
            / Tambah
        </nav>
    </div>

    <?= $this->Form->create($rencanaPembelian) ?>

    <div class="rp-card mb-2">
        <div class="rp-card-header"><i class="bi bi-clipboard-check me-2"></i>Rencana Pembelian</div>
        <div class="rp-card-body">
            <div class="row g-3">
                <div class="col-lg-4">
                    <label class="rp-label">Nama Supplier</label>
                    <?= $this->Form->control('nama_supplier', ['label' => false, 'class' => 'form-control']) ?>
                    <div class="mt-1" style="font-size:.68rem;color:#b0512c;">
                        Sementara input manual — akan diganti dropdown pencarian supplier setelah tabel Suppliers ada.
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="rp-label">Tgl Perencanaan</label>
                            <?= $this->Form->control('tgl_perencanaan', ['label' => false, 'class' => 'form-control', 'value' => date('Y-m-d')]) ?>
                        </div>
                        <div class="col-6">
                            <label class="rp-label">No Dokumen</label>
                            <?= $this->Form->control('no_dokumen', ['label' => false, 'class' => 'form-control']) ?>
                        </div>
                        <div class="col-12">
                            <label class="rp-label">Status</label>
                            <?= $this->Form->control('status', [
                                'label' => false,
                                'type' => 'select',
                                'options' => $statusOptions,
                                'value' => $rencanaPembelian->status ?? 'draft',
                                'class' => 'form-select',
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <label class="rp-label">Diminta Oleh</label>
                    <?= $this->Form->control('diminta_oleh', ['label' => false, 'class' => 'form-control']) ?>
                    <div class="mt-1" style="font-size:.68rem;color:#b0512c;">
                        Sementara input manual — akan diganti dropdown staff/user.
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="rp-btn-outline" disabled title="Butuh data Kontrak Pembelian">
                    <i class="bi bi-file-earmark-text me-1"></i> Ambil dari Kontrak Pembelian
                </button>
            </div>
        </div>
    </div>

    <div class="rp-card mb-2">
        <div class="rp-card-header"><i class="bi bi-box-seam me-2"></i>Detail Barang</div>
        <div class="rp-card-body p-0">
            <div class="table-responsive">
                <table id="grid-detail" class="table rp-table mb-0">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Total</th>
                            <th>Total Approv</th>
                            <th style="width:70px;">K. Obat</th>
                            <th>Keterangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="grid-detail-body"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="rp-total-label">Total Qty</td>
                            <td id="grand-qty" class="rp-total-value">0.00</td>
                            <td colspan="3" class="rp-total-label">Total Permintaan (Rp)</td>
                            <td id="grand-total" class="rp-total-value" colspan="2">0.00</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="p-2 border-top">
                <button type="button" id="btn-tambah-obat" class="btn btn-rp-secondary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-3">
        <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn btn-rp-secondary']) ?>
        <?= $this->Form->button(__('Simpan'), ['class' => 'btn btn-rp-primary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<!-- Modal Pilih Obat -->
<div class="modal fade" id="modal-pilih-obat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--rp-navy); color:#fff;">
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
                        <div class="table-responsive" style="max-height:360px; overflow:auto; border:1px solid var(--rp-border);">
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
                        <div class="table-responsive" style="max-height:360px; overflow:auto; border:1px solid var(--rp-border);">
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
                <button type="button" class="btn btn-rp-primary btn-sm" id="btn-pilih-obat-ok">
                    <i class="bi bi-check-lg me-1"></i>OK
                </button>
                <button type="button" class="btn btn-rp-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
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
            <td><input type="number" step="0.01" class="harga" value="0"></td>
            <td><input type="text" class="satuan"></td>
            <td class="total-display">0.00</td>
            <td><input type="number" step="0.01" class="total-approv" value="0"></td>
            <td class="text-center"><input type="checkbox" class="is-obat" checked></td>
            <td><input type="text" class="keterangan"></td>
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
            tbody.innerHTML = '<tr id="grid-empty-row"><td colspan="10" class="text-center text-muted py-3">Belum ada barang. Klik tombol "Tambah" untuk memilih obat.</td></tr>';
        }
    }

    function recalcRow(tr) {
        const qty = parseFloat(tr.querySelector('.qty').value) || 0;
        const harga = parseFloat(tr.querySelector('.harga').value) || 0;
        const total = qty * harga;
        tr.querySelector('.total-display').textContent = formatNumber(total);
        tr.dataset.total = total;
        tr.dataset.qty = qty;
        recalcGrandTotal();
    }

    function recalcGrandTotal() {
        let grandQty = 0, grandTotal = 0;
        tbody.querySelectorAll('tr[data-index]').forEach(tr => {
            grandQty += parseFloat(tr.dataset.qty) || 0;
            grandTotal += parseFloat(tr.dataset.total) || 0;
        });
        document.getElementById('grand-qty').textContent = formatNumber(grandQty);
        document.getElementById('grand-total').textContent = formatNumber(grandTotal);
    }

    function addRow(prefill) {
        prefill = prefill || {};
        const emptyRow = document.getElementById('grid-empty-row');
        if (emptyRow) emptyRow.remove();

        const newRow = rowTemplate.cloneNode(true);
        newRow.id = '';
        newRow.dataset.index = rowIndex;
        newRow.dataset.total = 0;
        newRow.dataset.qty = 1;

        newRow.querySelector('.kode-obat').name = `rencana_pembelian_details[${rowIndex}][kode_barang]`;
        newRow.querySelector('.nama-obat').name = `rencana_pembelian_details[${rowIndex}][nama_barang]`;
        newRow.querySelector('.medicine-id').name = `rencana_pembelian_details[${rowIndex}][medicine_id]`;
        newRow.querySelector('.qty').name = `rencana_pembelian_details[${rowIndex}][qty]`;
        newRow.querySelector('.harga').name = `rencana_pembelian_details[${rowIndex}][harga]`;
        newRow.querySelector('.satuan').name = `rencana_pembelian_details[${rowIndex}][satuan]`;
        newRow.querySelector('.total-approv').name = `rencana_pembelian_details[${rowIndex}][total_approv]`;
        newRow.querySelector('.keterangan').name = `rencana_pembelian_details[${rowIndex}][keterangan]`;

        const isObatCheck = newRow.querySelector('.is-obat');
        isObatCheck.name = `rencana_pembelian_details[${rowIndex}][is_obat]`;
        isObatCheck.value = 'Y';
        isObatCheck.checked = true;
        isObatCheck.addEventListener('change', function () {
            this.value = this.checked ? 'Y' : 'N';
        });

        if (prefill.code) {
            newRow.querySelector('.kode-obat').value = prefill.code || '';
            newRow.querySelector('.nama-obat').value = prefill.name || '';
            newRow.querySelector('.medicine-id').value = prefill.id || '';
            newRow.querySelector('.satuan').value = prefill.unit || '';
            newRow.querySelector('.harga').value = prefill.price || 0;
        }

        newRow.querySelectorAll('.qty, .harga').forEach(input => {
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