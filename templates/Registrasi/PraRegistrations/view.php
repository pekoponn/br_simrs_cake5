<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PraRegistration $praRegistration
 */

$statusMap = [
    'sudah_diproses' => ['label' => 'Sudah Diproses', 'class' => 'status-done'],
];
$statusInfo = $statusMap[$praRegistration->registration_status ?? ''] ?? ['label' => 'Belum Diproses', 'class' => 'status-pending'];

$formatDateTime = function ($value): string {
    if (empty($value)) {
        return '-';
    }
    $ts = is_object($value) && method_exists($value, 'format') ? strtotime($value->format('Y-m-d H:i:s')) : strtotime((string)$value);
    return $ts ? date('d-m-Y H:i', $ts) : '-';
};

$formatDate = function ($value): string {
    if (empty($value)) {
        return '-';
    }
    $ts = is_object($value) && method_exists($value, 'format') ? strtotime($value->format('Y-m-d')) : strtotime((string)$value);
    return $ts ? date('d-m-Y', $ts) : '-';
};

$formatTime = function ($value): string {
    if (empty($value)) {
        return '-';
    }
    $ts = is_object($value) && method_exists($value, 'format') ? strtotime($value->format('H:i:s')) : strtotime((string)$value);
    return $ts ? date('H:i', $ts) : '-';
};
?>

<?= $this->Krs->breadcrumb('Pra Registrasi', 'Detail Pra Registrasi') ?>

<style>
    .praview-page,
    .praview-page * {
        box-sizing: border-box;
    }

    .praview-page {
        margin: -5px 0 20px;
        color: #172033;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .praview-shell {
        overflow: hidden;
        border: 1px solid #dfe8f1;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(31, 45, 61, 0.08);
    }

    .praview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 22px;
        border-bottom: 1px solid #e8eef4;
        background: linear-gradient(90deg, #f7fbfa, #f8fbff);
    }

    .praview-brand {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .praview-logo {
        width: 52px;
        height: 52px;
        padding: 3px;
        border: 1px solid #d8e3ec;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 18px rgba(15, 118, 110, 0.12);
    }

    .praview-logo img {
        display: block;
        width: 45px;
        height: 45px;
        object-fit: contain;
    }

    .praview-title {
        margin: 0;
        color: #112136;
        font-size: 22px;
        font-weight: 800;
    }

    .praview-subtitle {
        margin-top: 4px;
        color: #667085;
        font-size: 13px;
        font-weight: 700;
    }

    .praview-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
    }

    .praview-badge.status-pending {
        background: #fff4e0;
        color: #b45309;
    }

    .praview-badge.status-done {
        background: #ecfdf7;
        color: #0f766e;
    }

    .praview-body {
        padding: 22px 28px 26px;
    }

    .praview-section {
        margin-bottom: 22px;
    }

    .praview-section:last-child {
        margin-bottom: 0;
    }

    .praview-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 12px;
        color: #172033;
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .02em;
    }

    .praview-section-title i {
        color: #0f766e;
    }

    .praview-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px 18px;
    }

    .praview-item label {
        display: block;
        margin-bottom: 4px;
        color: #667085;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .02em;
    }

    .praview-item .praview-value {
        color: #172033;
        font-size: 14.5px;
        font-weight: 700;
        line-height: 1.4;
        word-break: break-word;
    }

    .praview-item .praview-value.empty {
        color: #b0b8c1;
        font-weight: 600;
    }

    .praview-divider {
        margin: 20px 0;
        border: 0;
        border-top: 1px dashed #dfe8f1;
    }

    .praview-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e8eef4;
    }

    .praview-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-praview {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 44px;
        padding: 0 18px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        border: 0;
    }

    .btn-praview-back {
        border: 1px solid #d9e2ec;
        background: #fff;
        color: #344054;
    }

    .btn-praview-back:hover {
        background: #f1f3f5;
        color: #344054;
    }

    .btn-praview-edit {
        background: #b45309;
        color: #fff;
    }

    .btn-praview-edit:hover {
        background: #92400e;
        color: #fff;
    }

    .btn-praview-delete {
        background: #dc2626;
        color: #fff;
    }

    .btn-praview-delete:hover {
        background: #b91c1c;
        color: #fff;
    }

    @media (max-width: 991px) {
        .praview-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575px) {
        .praview-header,
        .praview-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .praview-badge {
            width: 100%;
            justify-content: center;
        }

        .praview-grid {
            grid-template-columns: 1fr;
        }

        .praview-buttons {
            width: 100%;
        }

        .btn-praview {
            flex: 1 1 auto;
            justify-content: center;
        }
    }
</style>

<div class="praview-page">
    <div class="praview-shell">
        <div class="praview-header">
            <div class="praview-brand">
                <div class="praview-logo">
                    <?= $this->Html->image('logo_br2.png', ['alt' => 'Logo Rumah Sakit Bhakti Rahayu']) ?>
                </div>
                <div>
                    <h1 class="praview-title">Detail Pra Registrasi</h1>
                    <div class="praview-subtitle"><?= h($praRegistration->reservation_code ?? '-') ?></div>
                </div>
            </div>

            <div class="praview-badge <?= h($statusInfo['class']) ?>">
                <i class="fa fa-circle" style="font-size:8px;"></i>
                <?= h($statusInfo['label']) ?>
            </div>
        </div>

        <div class="praview-body">
            <?= $this->Flash->render() ?>

            <div class="praview-section">
                <h4 class="praview-section-title"><i class="fa fa-user"></i> Data Pasien</h4>
                <div class="praview-grid">
                    <div class="praview-item">
                        <label>Nama Pasien</label>
                        <div class="praview-value"><?= h($praRegistration->patient_name ?? '-') ?></div>
                    </div>
                    <div class="praview-item">
                        <label>No. Rekam Medis</label>
                        <div class="praview-value<?= empty($praRegistration->medical_record_no) ? ' empty' : '' ?>">
                            <?= h($praRegistration->medical_record_no ?? '-') ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>Tanggal Lahir</label>
                        <div class="praview-value"><?= h($formatDate($praRegistration->birth_date ?? null)) ?></div>
                    </div>
                    <div class="praview-item">
                        <label>No. HP / WhatsApp</label>
                        <div class="praview-value"><?= h($praRegistration->phone_number ?? '-') ?></div>
                    </div>
                    <div class="praview-item">
                        <label>NIK</label>
                        <div class="praview-value<?= empty($praRegistration->nik) ? ' empty' : '' ?>">
                            <?= h($praRegistration->nik ?? '-') ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>Alamat</label>
                        <div class="praview-value<?= empty($praRegistration->address) ? ' empty' : '' ?>">
                            <?= h($praRegistration->address ?? '-') ?>
                        </div>
                    </div>
                    <?php if ($praRegistration->has('patient')): ?>
                    <div class="praview-item">
                        <label>Master Pasien</label>
                        <div class="praview-value">
                            <?= $this->Html->link('Lihat Data Pasien', ['controller' => 'Patients', 'action' => 'view', $praRegistration->patient->id]) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="praview-divider">

            <div class="praview-section">
                <h4 class="praview-section-title"><i class="fa fa-stethoscope"></i> Jadwal &amp; Tujuan</h4>
                <div class="praview-grid">
                    <div class="praview-item">
                        <label>Hari / Tanggal</label>
                        <div class="praview-value">
                            <?= h($praRegistration->appointment_day ?? '-') ?>,
                            <?= h($formatDate($praRegistration->appointment_date ?? null)) ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>Jam</label>
                        <div class="praview-value"><?= h($formatTime($praRegistration->appointment_time ?? null)) ?></div>
                    </div>
                    <div class="praview-item">
                        <label>Dokter</label>
                        <div class="praview-value"><?= h($praRegistration->doctor_name ?? '-') ?></div>
                    </div>
                    <div class="praview-item">
                        <label>Poli Tujuan</label>
                        <div class="praview-value"><?= h($praRegistration->poly_name ?? '-') ?></div>
                    </div>
                    <div class="praview-item">
                        <label>Nomor Antrian</label>
                        <div class="praview-value<?= empty($praRegistration->patient_queue_number) ? ' empty' : '' ?>">
                            <?= $praRegistration->patient_queue_number ? h($praRegistration->patient_queue_number) : '-' ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>Rencana Tindakan</label>
                        <div class="praview-value<?= empty($praRegistration->planned_action) ? ' empty' : '' ?>">
                            <?= h($praRegistration->planned_action ?? '-') ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="praview-divider">

            <div class="praview-section">
                <h4 class="praview-section-title"><i class="fa fa-file-medical"></i> Rujukan &amp; Penjamin</h4>
                <div class="praview-grid">
                    <div class="praview-item">
                        <label>Penjamin</label>
                        <div class="praview-value<?= empty($praRegistration->guarantor) ? ' empty' : '' ?>">
                            <?= h($praRegistration->guarantor ?? '-') ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>No. Kartu</label>
                        <div class="praview-value<?= empty($praRegistration->card_number) ? ' empty' : '' ?>">
                            <?= h($praRegistration->card_number ?? '-') ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>Jenis Rujukan</label>
                        <div class="praview-value<?= empty($praRegistration->referral_type) ? ' empty' : '' ?>">
                            <?= h($praRegistration->referral_type ?? '-') ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>No. Rujukan / Kontrol</label>
                        <div class="praview-value<?= empty($praRegistration->referral_number) ? ' empty' : '' ?>">
                            <?= h($praRegistration->referral_number ?? '-') ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>Melalui</label>
                        <div class="praview-value<?= empty($praRegistration->channel) ? ' empty' : '' ?>">
                            <?= h($this->Krs->referralChannels()[$praRegistration->channel ?? ''] ?? ($praRegistration->channel ?? '-')) ?>
                        </div>
                    </div>
                    <div class="praview-item">
                        <label>Keterangan</label>
                        <div class="praview-value<?= empty($praRegistration->notes) ? ' empty' : '' ?>">
                            <?= h($praRegistration->notes ?? '-') ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="praview-divider">

            <div class="praview-section">
                <h4 class="praview-section-title"><i class="fa fa-clock"></i> Riwayat</h4>
                <div class="praview-grid">
                    <div class="praview-item">
                        <label>Dibuat</label>
                        <div class="praview-value"><?= h($formatDateTime($praRegistration->created ?? null)) ?></div>
                    </div>
                    <div class="praview-item">
                        <label>Terakhir Diubah</label>
                        <div class="praview-value"><?= h($formatDateTime($praRegistration->modified ?? null)) ?></div>
                    </div>
                    <div class="praview-item">
                        <label>Terdaftar Pada</label>
                        <div class="praview-value<?= empty($praRegistration->registered_at) ? ' empty' : '' ?>">
                            <?= h($formatDateTime($praRegistration->registered_at ?? null)) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="praview-actions">
                <?= $this->Html->link(
                    '<i class="fa fa-arrow-left"></i> Kembali',
                    ['action' => 'index'],
                    ['class' => 'btn-praview btn-praview-back', 'escape' => false]
                ) ?>

                <div class="praview-buttons">
                    <?= $this->Html->link(
                        '<i class="fa fa-edit"></i> Edit',
                        ['action' => 'edit', $praRegistration->id],
                        ['class' => 'btn-praview btn-praview-edit', 'escape' => false]
                    ) ?>
                    <?= $this->Form->postLink(
                        '<i class="fa fa-trash"></i> Hapus',
                        ['action' => 'delete', $praRegistration->id],
                        [
                            'class' => 'btn-praview btn-praview-delete',
                            'escape' => false,
                            'confirm' => __('Yakin hapus pra registrasi {0}?', $praRegistration->patient_name ?? ''),
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>