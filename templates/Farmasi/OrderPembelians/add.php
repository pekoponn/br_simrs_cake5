<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPembelian $orderPembelian
 * @var \App\Model\Entity\Medicine[]|\Cake\Datasource\ResultSetInterface $medicines
 *
 * CATATAN:
 * - Dropdown Supplier masih pakai input manual (bukan dropdown dari tabel
 *   referensi) karena tabel suppliers belum dibuat. Begitu tabelnya ada,
 *   ganti input supplier_id di bawah jadi <select> dari $suppliers.
 * - Kode Obat & Nama Obat pada grid detail SEKARANG diambil dari Master
 *   Data Obat ($medicines, lihat MedicinesController/Medicine model).
 *   Controller action add()/edit() WAJIB mengirim variabel $medicines,
 *   contoh:
 *     $medicines = $this->OrderPembelians->Medicines
 *         ->find('all')
 *         ->select(['id', 'code', 'name', 'unit_1', 'hna'])
 *         ->where(['is_active' => 'Y'])
 *         ->all();
 *     $this->set(compact('medicines'));
 *   Ketik kode/nama di kolom Obat akan mencari lewat datalist HTML; kalau
 *   datanya banyak (ratusan+), sebaiknya diganti AJAX search (mis. pakai
 *   Select2) daripada datalist statis.
 * - Tombol "Ambil dari list Rencana Pembelian" masih dinonaktifkan, butuh
 *   tabel rencana_pembelian yang belum dibuat.
 * - Style mengikuti tema Bootstrap 5 yang sudah dipakai halaman lain
 *   (mis. Antrian Rawat Jalan): breadcrumb kanan atas, judul halaman +
 *   subjudul abu-abu, card putih dengan header bar navy, tabel simpel,
 *   tombol aksi warna oranye. Sesuaikan variable warna di bawah kalau
 *   theme project sudah punya CSS variable sendiri.
 */

$medicineList = [];
foreach (($medicines ?? []) as $med) {
    $medicineList[] = [
        'id'     => $med->id ?? '',
        'code'   => $med->code ?? '',
        'name'   => $med->name ?? '',
        'unit'   => $med->unit_1 ?? '',
        'price'  => (float)($med->hna ?? 0),
    ];
}
?>
<style>
    :root {
        --op-navy: #1b2a4a;
        --op-navy-dark: #15213a;
        --op-orange: #fd7e14;
        --op-orange-dark: #e8690b;
        --op-border: #e5e9f0;
    }

    .op-breadcrumb {
        font-size: .85rem;
        color: #8a93a3;
    }
    .op-breadcrumb a {
        color: #8a93a3;
        text-decoration: none;
    }
    .op-breadcrumb a:hover { color: var(--op-navy); }

    .op-page-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0;
        line-height: 1.2;
    }
    .op-page-subtitle {
        font-size: .78rem;
        color: #9aa2b1;
    }

    .op-card {
        background: #fff;
        border-radius: .5rem;
        border: 1px solid var(--op-border);
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .04);
    }

    .op-card-header {
        background: var(--op-navy);
        color: #fff;
        padding: .5rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 600;
        font-size: .88rem;
    }
    .op-card-header .op-header-icon {
        opacity: .7;
        cursor: pointer;
    }

    .op-card-body { padding: .9rem 1rem; }

    .op-label {
        font-size: .76rem;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: .2rem;
        display: block;
    }
    .op-hint {
        font-size: .68rem;
        color: #b0512c;
        margin-top: .1rem;
        line-height: 1.3;
    }

    .form-control, .form-select, textarea.form-control {
        border-color: var(--op-border);
        font-size: .9rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--op-navy);
        box-shadow: 0 0 0 .2rem rgba(27, 42, 74, .1);
    }

    .op-btn-outline {
        width: 100%;
        border: 1px dashed #c7cedb;
        background: #f8f9fc;
        color: #6b7280;
        border-radius: .4rem;
        padding: .4rem;
        font-size: .8rem;
    }
    .op-btn-outline:disabled { cursor: not-allowed; opacity: .7; }

    .op-table {
        margin-bottom: 0;
        font-size: .85rem;
    }
    .op-table thead th {
        background: #f8f9fc;
        border-bottom: 2px solid var(--op-border);
        color: #4b5563;
        font-weight: 600;
        white-space: nowrap;
        vertical-align: middle;
        padding: .5rem .6rem;
    }
    .op-table td { vertical-align: middle; padding: .35rem .6rem; }
    .op-table input {
        border: 1px solid var(--op-border);
        border-radius: .3rem;
        font-size: .82rem;
        padding: .3rem .5rem;
        width: 100%;
    }
    .op-total-label { text-align: right; font-weight: 600; color: #4b5563; }
    .op-total-value {
        font-weight: 700;
        color: #d63333;
    }

    .btn-op-primary {
        background: var(--op-orange);
        border-color: var(--op-orange);
        color: #fff;
        font-weight: 600;
    }
    .btn-op-primary:hover {
        background: var(--op-orange-dark);
        border-color: var(--op-orange-dark);
        color: #fff;
    }
    .btn-op-secondary {
        background: #fff;
        border: 1px solid var(--op-border);
        color: #4b5563;
        font-weight: 600;
    }

    .btn-hapus-baris {
        border: none;
        background: #fdecea;
        color: #d63333;
        width: 26px;
        height: 26px;
        border-radius: .3rem;
        line-height: 1;
    }
    .btn-hapus-baris:hover { background: #fbd6d3; }

    .op-table input.nama-obat[readonly] {
        background: #f8f9fc;
        color: #4b5563;
    }
    .op-table input.kode-obat.is-invalid {
        border-color: #d63333;
    }
    #pilih-obat-tbody tr,
    #pilih-obat-selected-tbody tr { cursor: pointer; }
    .pilih-obat-row:hover td { background: #f1f4fb; }
    .pilih-obat-row-active td { background: #dbe4ff !important; font-weight: 600; }
</style>

<div class="order-pembelians form content">

    <!-- Breadcrumb ala halaman lain -->
    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
        <div>
            <h1 class="op-page-title">Order Pembelian</h1>
            <div class="op-page-subtitle">Buat order pembelian baru ke supplier</div>
        </div>
        <nav class="op-breadcrumb">
            <a href="<?= $this->Url->build(['controller' => 'Logistik']) ?>">Logistik</a>
            /
            <a href="<?= $this->Url->build(['prefix' => 'Farmasi', 'controller' => 'OrderPembelians', 'action' => 'index']) ?>">Order Pembelian</a>
            / Tambah
        </nav>
    </div>

    <?= $this->Form->create($orderPembelian) ?>

    <div class="op-card mb-2">
        <div class="op-card-header">
            <span><i class="bi bi-cart3 me-2"></i>Order Pembelian</span>
            <i class="bi bi-gear op-header-icon" title="Pengaturan"></i>
        </div>

        <div class="op-card-body">
            <div class="row g-3">
                <!-- Kolom kiri: Supplier -->
                <div class="col-lg-4">
                    <label class="op-label">Nama Supplier</label>
                    <?php // TODO: ganti jadi dropdown/select2 setelah tabel suppliers ada ?>
                    <?= $this->Form->control('supplier_id', [
                        'label' => false,
                        'type' => 'number',
                        'class' => 'form-control',
                        'templateVars' => ['size' => ''],
                    ]) ?>
                    <div class="op-hint">Sementara input manual (ID supplier) — akan diganti dropdown pencarian supplier.</div>
                </div>

                <!-- Kolom tengah: data PO -->
                <div class="col-lg-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="op-label">PO No</label>
                            <?= $this->Form->control('po_no', ['label' => false, 'class' => 'form-control']) ?>
                        </div>
                        <div class="col-6">
                            <label class="op-label">Tgl PO</label>
                            <?= $this->Form->control('tgl_po', ['label' => false, 'class' => 'form-control']) ?>
                        </div>
                        <div class="col-6">
                            <label class="op-label">Ref No</label>
                            <?= $this->Form->control('ref_no', ['label' => false, 'class' => 'form-control']) ?>
                        </div>
                        <div class="col-6">
                            <label class="op-label">Tgl Kirim</label>
                            <?= $this->Form->control('tgl_kirim', ['label' => false, 'class' => 'form-control']) ?>
                        </div>
                    </div>
                </div>

                <!-- Kolom kanan: pengiriman -->
                <div class="col-lg-4">
                    <label class="op-label">Barang Dikirim Ke</label>
                    <?= $this->Form->control('barang_dikirim_ke', [
                        'label' => false,
                        'type' => 'textarea',
                        'class' => 'form-control',
                        'rows' => 2,
                    ]) ?>
                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <label class="op-label">Kirim Via</label>
                            <?= $this->Form->control('kirim_via', [
                                'label' => false,
                                'class' => 'form-select',
                                'type' => 'select',
                                'options' => $this->Krs->kirimVia(),
                                'empty' => '-- Pilih --',
                            ]) ?>
                        </div>
                        <div class="col-6">
                            <label class="op-label">Jenis</label>
                            <?= $this->Form->control('jenis', [
                                'label' => false,
                                'class' => 'form-select',
                                'type' => 'select',
                                'options' => $this->Krs->jenisOrderPembelian(),
                                'empty' => '-- Pilih --',
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <?php // TODO: aktifkan setelah tabel rencana_pembelian dibuat ?>
                <button type="button" class="op-btn-outline" disabled title="Butuh data Rencana Pembelian">
                    <i class="bi bi-clipboard-check me-1"></i> Ambil dari list Rencana Pembelian
                </button>
            </div>
        </div>
    </div>

    <!-- Card grid detail barang -->
    <div class="op-card mb-2">
        <div class="op-card-header">
            <span><i class="bi bi-box-seam me-2"></i>Detail Barang</span>
        </div>
        <div class="op-card-body p-0">
            <div class="table-responsive">
                <table id="grid-detail" class="table op-table mb-0">
                    <thead>
                        <tr>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Qty Rencana</th>
                            <th>Qty PO</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Discount</th>
                            <th>Tax (%)</th>
                            <th>Total Harga</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="grid-detail-body">
                        <!-- baris ditambahkan lewat JS, template row ada di bawah -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="op-total-label">Total</td>
                            <td id="grand-total" class="op-total-value">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="p-2 border-top">
                <button type="button" id="btn-tambah-obat" class="btn btn-op-secondary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-3">
        <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn btn-op-secondary']) ?>
        <?= $this->Form->button(__('Simpan'), ['class' => 'btn btn-op-primary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<!-- Sumber pencarian Obat: diisi dari Master Data Obat ($medicines) -->
<datalist id="obat-datalist">
    <?php foreach ($medicineList as $m): ?>
        <option value="<?= h($m['code']) ?>" label="<?= h($m['name']) ?>"></option>
    <?php endforeach; ?>
</datalist>

<!-- Modal Pilih Obat (multi-select, seperti di e-order Resep) -->
<div class="modal fade" id="modal-pilih-obat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--op-navy); color:#fff;">
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
                        <div class="table-responsive" style="max-height:360px; overflow:auto; border:1px solid var(--op-border);">
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
                        <div class="table-responsive" style="max-height:360px; overflow:auto; border:1px solid var(--op-border);">
                            <table class="table table-sm mb-0">
                                <thead style="position:sticky; top:0; background:#f8f9fc;">
                                    <tr>
                                        <th style="width:90px;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width:30px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="pilih-obat-selected-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-op-primary btn-sm" id="btn-pilih-obat-ok">
                    <i class="bi bi-check-lg me-1"></i>OK
                </button>
                <button type="button" class="btn btn-op-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Template satu baris grid, di-clone lewat JS -->
<table style="display:none">
    <tbody>
        <tr id="row-template">
            <td>
                <input type="text" class="kode-obat" placeholder="Cari Kode Obat" list="obat-datalist" autocomplete="off">
            </td>
            <td>
                <input type="text" class="nama-obat" placeholder="Nama Obat" readonly>
                <input type="hidden" class="medicine-id">
            </td>
            <td><input type="number" step="0.01" class="qty-rencana"></td>
            <td><input type="number" step="0.01" class="qty-po" value="0"></td>
            <td><input type="text" class="satuan"></td>
            <td><input type="number" step="0.01" class="harga" value="0"></td>
            <td><input type="number" step="0.01" class="discount" value="0"></td>
            <td><input type="number" step="0.01" class="tax" value="0"></td>
            <td class="total-harga-display">0.00</td>
            <td><button type="button" class="btn-hapus-baris">✕</button></td>
        </tr>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let rowIndex = 0;
    const tbody = document.getElementById('grid-detail-body');
    const rowTemplate = document.getElementById('row-template');

    // Data master obat dikirim dari controller lewat $medicines
    const medicineListData = <?= json_encode($medicineList) ?>;

    function formatNumber(n) {
        return (Math.round(n * 100) / 100).toFixed(2);
    }

    function escHtml(str) {
        const div = document.createElement('div');
        div.textContent = str == null ? '' : String(str);
        return div.innerHTML;
    }

    function updateEmptyState() {
        if (!tbody.querySelector('tr')) {
            tbody.innerHTML = '<tr id="grid-empty-row"><td colspan="10" class="text-center text-muted py-3">'
                + 'Belum ada obat. Klik tombol "Tambah" untuk memilih obat.</td></tr>';
        }
    }

    function recalcRow(tr) {
        const qty = parseFloat(tr.querySelector('.qty-po').value) || 0;
        const harga = parseFloat(tr.querySelector('.harga').value) || 0;
        const discount = parseFloat(tr.querySelector('.discount').value) || 0;
        const tax = parseFloat(tr.querySelector('.tax').value) || 0;

        let subtotal = (qty * harga) - discount;
        subtotal += subtotal * (tax / 100);

        tr.querySelector('.total-harga-display').textContent = formatNumber(subtotal);
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

    // prefill = { id, code, name, unit, price } hasil pilihan dari modal obat
    function addRow(prefill) {
        prefill = prefill || {};

        const emptyRow = document.getElementById('grid-empty-row');
        if (emptyRow) emptyRow.remove();

        const newRow = rowTemplate.cloneNode(true);
        newRow.id = '';
        newRow.dataset.index = rowIndex;
        newRow.dataset.total = 0;

        newRow.querySelector('.kode-obat').name = `order_pembelian_details[${rowIndex}][kode_obat]`;
        newRow.querySelector('.nama-obat').name = `order_pembelian_details[${rowIndex}][nama_obat]`;
        newRow.querySelector('.medicine-id').name = `order_pembelian_details[${rowIndex}][medicine_id]`;
        newRow.querySelector('.qty-rencana').name = `order_pembelian_details[${rowIndex}][qty_rencana]`;
        newRow.querySelector('.qty-po').name = `order_pembelian_details[${rowIndex}][qty_po]`;
        newRow.querySelector('.satuan').name = `order_pembelian_details[${rowIndex}][satuan]`;
        newRow.querySelector('.harga').name = `order_pembelian_details[${rowIndex}][harga]`;
        newRow.querySelector('.discount').name = `order_pembelian_details[${rowIndex}][discount]`;
        newRow.querySelector('.tax').name = `order_pembelian_details[${rowIndex}][tax]`;

        if (prefill.code) {
            newRow.querySelector('.kode-obat').value = prefill.code || '';
            newRow.querySelector('.nama-obat').value = prefill.name || '';
            newRow.querySelector('.medicine-id').value = prefill.id || '';
            newRow.querySelector('.satuan').value = prefill.unit || '';
            newRow.querySelector('.harga').value = prefill.price || 0;
        }

        // Kode obat masih bisa diketik ulang manual untuk cari via datalist
        newRow.querySelector('.kode-obat').addEventListener('input', function () {
            const found = medicineListData.find(m => m.code === this.value.trim());
            const namaObat = newRow.querySelector('.nama-obat');
            const medicineId = newRow.querySelector('.medicine-id');
            const satuan = newRow.querySelector('.satuan');
            const harga = newRow.querySelector('.harga');

            if (found) {
                namaObat.value = found.name;
                medicineId.value = found.id;
                this.classList.remove('is-invalid');
                if (!satuan.value) satuan.value = found.unit;
                if (!harga.value || parseFloat(harga.value) === 0) harga.value = found.price;
            } else {
                namaObat.value = '';
                medicineId.value = '';
                if (this.value.trim()) this.classList.add('is-invalid');
            }

            recalcRow(newRow);
        });

        newRow.querySelectorAll('input').forEach(input => {
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

    // ================== Modal Pilih Obat ==================
    let selectedObatList = [];
    const modalPilihObatEl = document.getElementById('modal-pilih-obat');
    const modalPilihObat = new bootstrap.Modal(modalPilihObatEl);
    const tbodyPilihObat = document.getElementById('pilih-obat-tbody');
    const tbodySelectedObat = document.getElementById('pilih-obat-selected-tbody');
    const inputSearchObat = document.getElementById('pilih-obat-search');

    function isObatSelected(code) {
        return selectedObatList.some(d => d.code === code);
    }

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
            html += '<tr>'
                + '<td>' + escHtml(d.code) + '</td>'
                + '<td>' + escHtml(d.name) + '</td>'
                + '<td class="text-center"><button type="button" class="btn btn-sm btn-hapus-baris btn-remove-selected-obat" data-code="' + escHtml(d.code) + '">&times;</button></td>'
                + '</tr>';
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

        const filtered = medicineListData.filter(function (d) {
            if (!q) return true;
            return (d.code || '').toLowerCase().includes(q) || (d.name || '').toLowerCase().includes(q);
        });

        renderPilihObatRows(filtered);
    }

    tbodyPilihObat.addEventListener('click', function (e) {
        const tr = e.target.closest('.pilih-obat-row');
        if (!tr) return;
        toggleObatRow(tr.dataset.code);
    });

    tbodySelectedObat.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-remove-selected-obat');
        if (!btn) return;
        toggleObatRow(btn.dataset.code);
    });

    inputSearchObat.addEventListener('input', function () {
        filterObatModal(this.value);
    });

    document.getElementById('btn-tambah-obat').addEventListener('click', function () {
        selectedObatList = [];
        inputSearchObat.value = '';
        renderSelectedObatTable();
        filterObatModal('');
        modalPilihObat.show();

        setTimeout(() => inputSearchObat.focus(), 300);
    });

    document.getElementById('btn-pilih-obat-ok').addEventListener('click', function () {
        if (!selectedObatList.length) {
            alert('Pilih minimal 1 obat terlebih dahulu.');
            return;
        }

        selectedObatList.forEach(function (d) {
            addRow(d);
        });

        modalPilihObat.hide();
    });
    // ================== /Modal Pilih Obat ==================
});
</script>