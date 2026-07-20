<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DoctorSchedule[]|\Cake\Collection\CollectionInterface $doctorSchedules
 */
?>

<style>
    .ds-page {
        background: #f4f7fb;
        padding: 18px;
        border-radius: 16px;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    /* Header - kembali seperti sebelumnya (kartu putih) */
    .ds-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .ds-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ds-header-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(145deg, #2563eb, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #ffffff;
        box-shadow: 0 6px 14px rgba(37, 99, 235, .30);
    }

    .ds-title {
        margin: 0;
        font-weight: 800;
        color: #1f2d3d;
        font-size: 19px;
    }

    .ds-subtitle {
        color: #64748b;
        font-size: 12.5px;
        font-weight: 600;
        margin-top: 2px;
    }

    .ds-btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #2563eb;
        border: none;
        color: #fff !important;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 10px 16px;
        box-shadow: 0 6px 14px rgba(37, 99, 235, .35);
        transition: background .15s ease, transform .15s ease;
    }

    .ds-btn-add:hover {
        background: #1d4ed8;
        color: #fff;
        transform: translateY(-1px);
    }

    /* Filter card */
    .ds-card {
        background: #ffffff;
        border: 1px solid #e3e8ef;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(31, 45, 61, .06);
        padding: 16px;
        margin-bottom: 18px;
    }

    .ds-filter-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr auto;
        gap: 12px;
        align-items: end;
    }

    .ds-filter-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 5px;
        display: block;
    }

    .ds-input-wrap {
        position: relative;
    }

    .ds-input-wrap .ds-input-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        display: flex;
    }

    .ds-input-wrap input.ds-input {
        padding-left: 32px;
    }

    .ds-input {
        height: 38px;
        width: 100%;
        border-radius: 10px !important;
        border: 1px solid #d7dee8 !important;
        font-size: 13px;
    }

    .ds-input:focus {
        border-color: #93b4fb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        outline: none;
    }

    .ds-actions {
        display: flex;
        gap: 6px;
        white-space: nowrap;
    }

    .ds-actions .btn {
        height: 38px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .ds-active-filters {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed #e5e9f0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .ds-active-filters-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 700;
    }

    .ds-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 999px;
        padding: 4px 11px;
        font-size: 12px;
        font-weight: 700;
    }

    /* Info banner */
    .ds-info {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #edf6ff;
        border-left: 5px solid #2563eb;
        color: #1e3a8a;
        border-radius: 12px;
        padding: 11px 14px;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .ds-info svg {
        flex-shrink: 0;
        color: #2563eb;
    }

    /* Table */
    .ds-table-wrap {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e3e8ef;
        background: #fff;
    }

    .ds-table {
        margin: 0;
        font-size: 13px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .ds-table thead,
    .ds-table thead tr {
        background: #111827 !important;
        color: #fff;
    }

    .ds-table th {
        background: #111827 !important;
        color: #fff !important;
        vertical-align: middle !important;
        white-space: nowrap;
        padding: 12px 10px !important;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: .03em;
        border: none !important;
        border-bottom: 2px solid #111827 !important;
    }

    .ds-table th a {
        color: #fff !important;
        text-decoration: none;
    }

    /* Paginator->sort() menambahkan class sorting/asc/desc yang bawaannya
       punya background putih dari tema/datatable. Paksa tetap hitam. */
    .ds-table th.sorting,
    .ds-table th.sorting_asc,
    .ds-table th.sorting_desc,
    .ds-table th.asc,
    .ds-table th.desc,
    .ds-table th[class*="sort"] {
        background: #111827 !important;
        background-image: none !important;
        color: #fff !important;
    }

    .ds-table th a.sorting_asc,
    .ds-table th a.sorting_desc,
    .ds-table th a.asc,
    .ds-table th a.desc,
    .ds-table th a[class*="sort"] {
        background: transparent !important;
        background-image: none !important;
        color: #fff !important;
    }

    /* Penetral: kalau ada input/select/div lain yang disisipkan ke header
       (misalnya oleh script DataTables di layout), paksa transparan +
       teks putih supaya tidak lagi terlihat kotak putih. */
    .ds-table thead th * {
        background: transparent !important;
        background-color: transparent !important;
        background-image: none !important;
        border: none !important;
        box-shadow: none !important;
        color: #fff !important;
    }

    .ds-table thead th input,
    .ds-table thead th select,
    .ds-table thead th textarea {
        all: unset;
        display: inline-block;
        color: #fff !important;
        font-size: 11.5px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .03em;
        cursor: pointer;
    }

    .ds-table thead th input::placeholder {
        color: rgba(255, 255, 255, .75) !important;
        opacity: 1;
    }

    .ds-table td {
        vertical-align: middle !important;
        padding: 11px 10px !important;
        border-top: 1px solid #eef2f7 !important;
        border-left: none !important;
        border-right: none !important;
    }

    .ds-table tbody tr:hover {
        background: #f8fafc;
    }

    .ds-today-row,
    .ds-today-row:hover {
        background: #eff6ff !important;
    }

    .ds-code {
        background: #eef4ff;
        color: #1d4ed8;
        padding: 4px 9px;
        border-radius: 8px;
        font-weight: 700;
    }

    .ds-status-active {
        background: #dcfce7;
        color: #166534;
    }

    .ds-status-off {
        background: #e5e7eb;
        color: #4b5563;
    }

    .ds-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
        background: currentColor;
    }

    .ds-time {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        color: #334155;
        font-weight: 600;
    }

    .ds-time svg {
        color: #64748b;
        flex-shrink: 0;
    }

    .ds-quota-track {
        height: 10px;
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
        min-width: 90px;
    }

    .ds-quota-fill {
        height: 100%;
        border-radius: 999px;
    }

    /* Tombol aksi - pakai svg inline supaya selalu tampil */
    .ds-row-actions {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .ds-icon-btn {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: transform .12s ease, background .12s ease;
    }

    .ds-icon-btn:hover {
        transform: translateY(-1px);
    }

    .ds-icon-btn.view {
        background: #eff6ff;
        color: #2563eb;
        border-color: #dbe8fe;
    }

    .ds-icon-btn.edit {
        background: #fff7ed;
        color: #c2410c;
        border-color: #fde3c8;
    }

    .ds-icon-btn.delete {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecdd3;
    }

    .ds-icon-btn svg {
        pointer-events: none;
    }

    .ds-empty-state {
        text-align: center;
        padding: 42px 20px;
        color: #64748b;
    }

    .ds-empty-state svg {
        display: block;
        margin: 0 auto 10px;
        color: #cbd5e1;
    }

    .ds-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 16px;
    }

    @media (max-width: 900px) {
        .ds-filter-grid {
            grid-template-columns: 1fr;
        }

        .ds-actions {
            width: 100%;
        }

        .ds-actions .btn {
            flex: 1;
            justify-content: center;
        }

        .ds-header {
            align-items: flex-start;
        }
    }
</style>

<div class="doctorSchedules index content ds-page">

    <?php
    $q = $this->request->getQuery('q');
    $dayFilter = $this->request->getQuery('day');
    $activeFilter = $this->request->getQuery('is_active');

    $todayName = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu',
    ][date('l')] ?? '';

    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    $dayColors = [
        'Senin'  => '#2563eb',
        'Selasa' => '#7c3aed',
        'Rabu'   => '#16a34a',
        'Kamis'  => '#ea580c',
        'Jumat'  => '#dc2626',
        'Sabtu'  => '#0891b2',
        'Minggu' => '#475569',
    ];

    $hasActiveFilter = $q || ($dayFilter !== null && $dayFilter !== '') || ($activeFilter !== null && $activeFilter !== '');
    ?>

    <div class="ds-header">
        <div class="ds-header-left">
            <div class="ds-header-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="3"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div>
                <h3 class="ds-title">Jadwal Dokter</h3>
                <div class="ds-subtitle">Kelola jadwal praktik dokter, hari, jam, kuota, dan status aktif</div>
            </div>
        </div>

        <?= $this->Html->link(
            '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Tambah Jadwal',
            ['action' => 'add'],
            ['class' => 'ds-btn-add', 'escape' => false]
        ) ?>
    </div>

    <div class="ds-card">
        <form method="get">
            <div class="ds-filter-grid">
                <div>
                    <label class="ds-filter-label">Search</label>
                    <div class="ds-input-wrap">
                        <span class="ds-input-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <circle cx="11" cy="11" r="7"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="q"
                            value="<?= h($q) ?>"
                            class="form-control ds-input"
                            placeholder="Cari kode, nama dokter, atau poli..."
                        >
                    </div>
                </div>

                <div>
                    <label class="ds-filter-label">Filter Hari</label>
                    <select name="day" class="form-control ds-input">
                        <option value="">Semua Hari</option>
                        <?php foreach ($days as $d): ?>
                            <option value="<?= h($d) ?>" <?= $dayFilter === $d ? 'selected' : '' ?>>
                                <?= h($d) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="ds-filter-label">Filter Status</label>
                    <select name="is_active" class="form-control ds-input">
                        <option value="">Semua Status</option>
                        <option value="1" <?= $activeFilter === '1' ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $activeFilter === '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>

                <div class="ds-actions">
                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>

                    <?= $this->Html->link(
                        'Reset',
                        ['action' => 'index'],
                        ['class' => 'btn btn-secondary', 'escape' => false]
                    ) ?>
                </div>
            </div>

            <?php if ($hasActiveFilter): ?>
                <div class="ds-active-filters">
                    <span class="ds-active-filters-label">Filter aktif:</span>

                    <?php if ($q): ?>
                        <span class="ds-badge" style="background:#e0f2fe; color:#075985;">Search: <?= h($q) ?></span>
                    <?php endif; ?>

                    <?php if ($dayFilter): ?>
                        <span class="ds-badge" style="background:#ede9fe; color:#5b21b6;">Hari: <?= h($dayFilter) ?></span>
                    <?php endif; ?>

                    <?php if ($activeFilter !== null && $activeFilter !== ''): ?>
                        <span class="ds-badge" style="background:#ecfdf5; color:#166534;">
                            Status: <?= $activeFilter === '1' ? 'Aktif' : 'Tidak Aktif' ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <div class="ds-info">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="3"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        <span>
            Hari ini: <strong><?= h($todayName) ?>, <?= date('d F Y') ?></strong>.
            Jadwal hari ini akan diberi background biru muda.
        </span>
    </div>

    <div class="table-responsive ds-table-wrap">
        <table class="table table-hover ds-table">
            <thead>
                <tr>
                    <th style="width:50px; text-align:center;">No</th>
                    <th><?= $this->Paginator->sort('code', 'Kode') ?></th>
                    <th>Dokter</th>
                    <th>Poli</th>
                    <th><?= $this->Paginator->sort('day', 'Hari') ?></th>
                    <th>Jam Praktik</th>
                    <th style="min-width:190px;">Kuota</th>
                    <th><?= $this->Paginator->sort('is_active', 'Status') ?></th>
                    <th style="text-align:center; width:125px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($doctorSchedules) && $doctorSchedules->count() > 0): ?>
                    <?php
                    $page = (int)$this->request->getQuery('page', 1);
                    $limit = 20;
                    $no = (($page - 1) * $limit) + 1;
                    ?>

                    <?php foreach ($doctorSchedules as $ds): ?>
                        <?php
                        $isToday = ($ds->day === $todayName);
                        $isActive = (int)($ds->is_active ?? 0) === 1;

                        $quotaTotal = (int)($ds->quota ?? 0);
                        $quotaUsed = (int)($ds->quota_used ?? 0);
                        $quotaLeft = max(0, $quotaTotal - $quotaUsed);
                        $pct = $quotaTotal > 0 ? min(100, round($quotaUsed / $quotaTotal * 100)) : 0;

                        if ($pct >= 100) {
                            $barColor = '#dc2626';
                            $barText = 'Penuh';
                        } elseif ($pct >= 75) {
                            $barColor = '#ea580c';
                            $barText = 'Hampir Penuh';
                        } elseif ($pct >= 50) {
                            $barColor = '#ca8a04';
                            $barText = 'Sisa ' . $quotaLeft;
                        } else {
                            $barColor = '#16a34a';
                            $barText = 'Sisa ' . $quotaLeft;
                        }

                        $dayColor = $dayColors[$ds->day] ?? '#64748b';
                        ?>

                        <tr class="<?= $isToday ? 'ds-today-row' : '' ?>">
                            <td style="text-align:center; color:#64748b; font-weight:700;">
                                <?= $no++ ?>
                            </td>

                            <td>
                                <span class="ds-code"><?= h($ds->code ?? '-') ?></span>

                                <?php if ($isToday): ?>
                                    <span class="ds-badge" style="background:#2563eb; color:#fff; margin-left:5px; font-size:10px;">
                                        Hari Ini
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($ds->has('doctor') && $ds->doctor): ?>
                                    <strong><?= h($ds->doctor->doctor_name ?? $ds->doctor->name ?? '-') ?></strong>
                                <?php else: ?>
                                    <span style="color:#94a3b8;">-</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($ds->has('doctor') && $ds->doctor && !empty($ds->doctor->polyclinic_name)): ?>
                                    <span class="ds-badge" style="background:#eef4ff; color:#1d4ed8;">
                                        <?= h($ds->doctor->polyclinic_name) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color:#94a3b8;">-</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="ds-badge" style="background:<?= h($dayColor) ?>; color:#fff;">
                                    <?= h($ds->day ?? '-') ?>
                                </span>
                            </td>

                            <td>
                                <span class="ds-time">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <polyline points="12 7 12 12 15.5 14"></polyline>
                                    </svg>
                                    <?= h(substr((string)($ds->start_time ?? ''), 0, 5)) ?>
                                    &ndash;
                                    <?= h(substr((string)($ds->end_time ?? ''), 0, 5)) ?>
                                </span>
                            </td>

                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="ds-quota-track">
                                        <div class="ds-quota-fill" style="width:<?= $pct ?>%; background:<?= h($barColor) ?>;"></div>
                                    </div>

                                    <span style="white-space:nowrap; font-size:12px; font-weight:800; color:<?= h($barColor) ?>;">
                                        <?= $quotaUsed ?>/<?= $quotaTotal ?> - <?= h($barText) ?>
                                    </span>
                                </div>
                            </td>

                            <td style="text-align:center;">
                                <?php if ($isActive): ?>
                                    <span class="ds-badge ds-status-active">
                                        <span class="ds-dot"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="ds-badge ds-status-off">
                                        <span class="ds-dot"></span> Tidak Aktif
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="ds-row-actions">
                                    <?= $this->Html->link(
                                        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
                                        ['action' => 'view', $ds->id],
                                        ['escape' => false, 'class' => 'ds-icon-btn view', 'title' => 'Lihat']
                                    ) ?>

                                    <?= $this->Html->link(
                                        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg>',
                                        ['action' => 'edit', $ds->id],
                                        ['escape' => false, 'class' => 'ds-icon-btn edit', 'title' => 'Edit']
                                    ) ?>

                                    <?= $this->Form->postLink(
                                        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
                                        ['action' => 'delete', $ds->id],
                                        [
                                            'escape' => false,
                                            'class' => 'ds-icon-btn delete',
                                            'title' => 'Hapus',
                                            'confirm' => __('Yakin hapus jadwal # {0}?', $ds->id),
                                        ]
                                    ) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="9">
                            <div class="ds-empty-state">
                                <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="3"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                    <line x1="9" y1="16" x2="15" y2="16"></line>
                                </svg>
                                Data jadwal dokter tidak ditemukan.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="ds-pagination">
        <p style="margin:0; font-size:13px; color:#64748b;">
            <?= $this->Paginator->counter('Menampilkan {{current}} dari {{count}} data | Halaman {{page}} dari {{pages}}') ?>
        </p>

        <ul class="pagination pagination-sm" style="margin:0;">
            <?= $this->Paginator->first('<< Pertama') ?>
            <?= $this->Paginator->prev('< Sebelumnya') ?>
            <?= $this->Paginator->numbers(['modulus' => 4]) ?>
            <?= $this->Paginator->next('Berikutnya >') ?>
            <?= $this->Paginator->last('Terakhir >>') ?>
        </ul>
    </div>

</div>