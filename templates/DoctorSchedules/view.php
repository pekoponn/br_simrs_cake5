<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DoctorSchedule $doctorSchedule
 */

function fmtDsTime($val) {
    if (empty($val)) return '—';
    if ($val instanceof \Cake\I18n\FrozenTime || $val instanceof \Cake\I18n\Time) {
        return $val->format('H:i');
    }
    $ts = strtotime((string)$val);
    return $ts ? date('H:i', $ts) : (string)$val;
}

function fmtDsDate($val, $fmt = 'd-m-Y H:i') {
    if (empty($val)) return '—';
    if ($val instanceof \Cake\I18n\FrozenTime || $val instanceof \Cake\I18n\Time
        || $val instanceof \Cake\I18n\FrozenDate || $val instanceof \Cake\I18n\Date) {
        return $val->format($fmt);
    }
    $ts = strtotime((string)$val);
    return $ts ? date($fmt, $ts) : '—';
}

$dayColors = [
    'Senin'  => '#2563eb',
    'Selasa' => '#7c3aed',
    'Rabu'   => '#16a34a',
    'Kamis'  => '#ea580c',
    'Jumat'  => '#dc2626',
    'Sabtu'  => '#0891b2',
    'Minggu' => '#475569',
];
$dayColor = $dayColors[$doctorSchedule->day] ?? '#64748b';
$isActive = (int)($doctorSchedule->is_active ?? 0) === 1
    || $doctorSchedule->is_active === 'Y'
    || $doctorSchedule->is_active === '1';
?>

<style>
    .ds-page {
        background: #f4f7fb;
        padding: 18px;
        border-radius: 16px;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .ds-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
        max-width: 680px;
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

    .ds-btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid #d7dee8;
        color: #334155 !important;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 10px 16px;
        transition: background .15s ease;
    }

    .ds-btn-back:hover {
        background: #f1f5f9;
        color: #334155;
    }

    .ds-btn-edit {
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
    }

    .ds-btn-edit:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .ds-btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fef2f2;
        border: 1px solid #fecdd3;
        color: #dc2626 !important;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 10px 16px;
    }

    .ds-btn-delete:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .ds-card {
        background: #ffffff;
        border: 1px solid #e3e8ef;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(31, 45, 61, .06);
        padding: 22px;
        margin-bottom: 18px;
    }

    .ds-detail-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eef2f7;
    }

    .ds-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 999px;
        padding: 5px 13px;
        font-size: 12.5px;
        font-weight: 700;
    }

    .ds-code-big {
        background: #eef4ff;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 15px;
    }

    .ds-status-active { background: #dcfce7; color: #166534; }
    .ds-status-off { background: #e5e7eb; color: #4b5563; }

    .ds-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
        background: currentColor;
    }

    .ds-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .ds-info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .ds-info-label {
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .ds-info-value {
        font-size: 14.5px;
        font-weight: 600;
        color: #1f2d3d;
    }

    .ds-time-box {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #334155;
        font-weight: 700;
    }

    .ds-time-box svg {
        color: #64748b;
        flex-shrink: 0;
    }

    .ds-quota-track {
        height: 10px;
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
        max-width: 220px;
        margin-top: 6px;
    }

    .ds-quota-fill {
        height: 100%;
        border-radius: 999px;
    }

    .ds-note-box {
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 13.5px;
        color: #334155;
        line-height: 1.6;
    }

    @media (max-width: 700px) {
        .ds-info-grid {
            grid-template-columns: 1fr;
        }
        .ds-header {
            max-width: 100%;
        }
    }
</style>

<div class="ds-page">

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
                <h3 class="ds-title">Detail Jadwal Dokter</h3>
                <div class="ds-subtitle">Informasi lengkap jadwal praktik</div>
            </div>
        </div>
    </div>

    <div class="ds-card">

        <div class="ds-detail-head">
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <span class="ds-code-big"><?= h($doctorSchedule->code ?? '-') ?></span>
                <span class="ds-badge" style="background:<?= h($dayColor) ?>; color:#fff;">
                    <?= h($doctorSchedule->day ?? '-') ?>
                </span>
                <?php if ($isActive): ?>
                    <span class="ds-badge ds-status-active"><span class="ds-dot"></span> Aktif</span>
                <?php else: ?>
                    <span class="ds-badge ds-status-off"><span class="ds-dot"></span> Tidak Aktif</span>
                <?php endif; ?>
            </div>

            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <?= $this->Html->link(
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><path d="M12 19l-7-7 7-7"></path></svg> Kembali',
                    ['action' => 'index'],
                    ['class' => 'ds-btn-back', 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg> Edit',
                    ['action' => 'edit', $doctorSchedule->id],
                    ['class' => 'ds-btn-edit', 'escape' => false]
                ) ?>
                <?= $this->Form->postLink(
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Hapus',
                    ['action' => 'delete', $doctorSchedule->id],
                    [
                        'escape' => false,
                        'class' => 'ds-btn-delete',
                        'confirm' => __('Yakin hapus jadwal # {0}?', $doctorSchedule->id),
                    ]
                ) ?>
            </div>
        </div>

        <div class="ds-info-grid">

            <div class="ds-info-item">
                <span class="ds-info-label">Dokter</span>
                <span class="ds-info-value">
                    <?php if ($doctorSchedule->has('doctor') && $doctorSchedule->doctor): ?>
                        <?= h($doctorSchedule->doctor->doctor_name ?? '-') ?>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </span>
            </div>

            <div class="ds-info-item">
                <span class="ds-info-label">Poliklinik</span>
                <span class="ds-info-value">
                    <?php if ($doctorSchedule->has('doctor') && !empty($doctorSchedule->doctor->polyclinic_name)): ?>
                        <span class="ds-badge" style="background:#fef3c7; color:#92400e;">
                            <?= h($doctorSchedule->doctor->polyclinic_name) ?>
                        </span>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </span>
            </div>

            <div class="ds-info-item">
                <span class="ds-info-label">Hari Praktik</span>
                <span class="ds-info-value">
                    <span class="ds-badge" style="background:<?= h($dayColor) ?>; color:#fff;">
                        <?= h($doctorSchedule->day ?? '-') ?>
                    </span>
                </span>
            </div>

            <div class="ds-info-item">
                <span class="ds-info-label">Jam Praktik</span>
                <span class="ds-info-value">
                    <span class="ds-time-box">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"></circle>
                            <polyline points="12 7 12 12 15.5 14"></polyline>
                        </svg>
                        <?= fmtDsTime($doctorSchedule->start_time) ?> &ndash; <?= fmtDsTime($doctorSchedule->end_time) ?>
                    </span>
                </span>
            </div>

            <div class="ds-info-item">
                <span class="ds-info-label">Kuota</span>
                <span class="ds-info-value">
                    <?= h($doctorSchedule->quota ?? '-') ?> pasien
                    <div class="ds-quota-track">
                        <div class="ds-quota-fill" style="width:0%; background:#16a34a;"></div>
                    </div>
                </span>
            </div>

            <div class="ds-info-item">
                <span class="ds-info-label">Status</span>
                <span class="ds-info-value">
                    <?php if ($isActive): ?>
                        <span class="ds-badge ds-status-active"><span class="ds-dot"></span> Aktif</span>
                    <?php else: ?>
                        <span class="ds-badge ds-status-off"><span class="ds-dot"></span> Tidak Aktif</span>
                    <?php endif; ?>
                </span>
            </div>

            <div class="ds-info-item">
                <span class="ds-info-label">Dibuat</span>
                <span class="ds-info-value"><?= fmtDsDate($doctorSchedule->created) ?></span>
            </div>

            <div class="ds-info-item">
                <span class="ds-info-label">Diubah</span>
                <span class="ds-info-value"><?= fmtDsDate($doctorSchedule->modified) ?></span>
            </div>

        </div>

        <?php if (!empty($doctorSchedule->note)): ?>
        <div style="margin-top:18px;">
            <span class="ds-info-label">Catatan</span>
            <div class="ds-note-box" style="margin-top:6px;">
                <?= nl2br(h($doctorSchedule->note)) ?>
            </div>
        </div>
        <?php endif; ?>

    </div>

</div>