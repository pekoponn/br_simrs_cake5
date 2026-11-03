<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue $polyclinicQueue
 */

$registration = $polyclinicQueue->registration ?? null;
$isRegistered = !empty($registration);
$isActive = $polyclinicQueue->is_active === 'Y';
$isMobileJkn = $polyclinicQueue->source === 'Mobile JKN';

if (in_array(strtolower((string)$polyclinicQueue->source), ['wa', 'whatsapp'], true)) {
    $sourceLabel = 'WhatsApp';
    $sourceClass = 'label-success';
} elseif ($isMobileJkn) {
    $sourceLabel = 'Mobile JKN';
    $sourceClass = 'label-mobile-jkn';
} else {
    $sourceLabel = 'Manual';
    $sourceClass = 'label-primary';
}

if ($isRegistered) {
    $statusLabel = 'Registered';
    $statusClass = 'label-success';
} elseif ($isMobileJkn) {
    $statusLabel = $polyclinicQueue->checkin_status ?: 'Belum Check-in';

    if ($statusLabel === 'Sudah Check-in') {
        $statusClass = 'label-checkin-done';
    } elseif ($statusLabel === 'Batal') {
        $statusClass = 'label-checkin-cancel';
    } elseif ($statusLabel === 'Selesai') {
        $statusClass = 'label-success';
    } else {
        $statusClass = 'label-checkin-pending';
    }
} else {
    $statusLabel = $isActive ? 'Active' : 'Non Active';
    $statusClass = $isActive ? 'label-primary' : 'label-default';
}

$created = !empty($polyclinicQueue->created)
    ? $polyclinicQueue->created->format('d-m-Y H:i')
    : '-';
$visitDate = !empty($polyclinicQueue->visit_date)
    ? $polyclinicQueue->visit_date->format('d-m-Y')
    : '-';
$checkinTime = !empty($polyclinicQueue->checkin_time)
    ? $polyclinicQueue->checkin_time->format('d-m-Y H:i')
    : '-';
?>

<?= $this->Krs->breadcrumb('Polyclinic Queue', 'Detail Antrian') ?>

<style>
    .queue-hero {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border: 1px solid #e2e7ef;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 18px;
    }

    .queue-title h3 {
        margin: 0 0 8px;
        font-size: 22px;
        font-weight: 700;
        color: #2d353c;
    }

    .queue-title .meta {
        color: #6c757d;
        font-size: 13px;
    }

    .queue-code-box {
        min-width: 150px;
        padding: 14px 16px;
        border: 1px solid #cfe7ff;
        border-radius: 8px;
        background: #eef7ff;
        text-align: center;
    }

    .queue-code-box .caption {
        display: block;
        margin-bottom: 7px;
        color: #6c757d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .queue-code-box .code {
        display: block;
        color: #1f6feb;
        font-size: 28px;
        font-weight: 800;
        line-height: 1;
    }

    .section-box {
        border: 1px solid #e2e7ef;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 18px;
        overflow: hidden;
    }

    .section-box-header {
        padding: 12px 15px;
        border-bottom: 1px solid #edf1f5;
        background: #fafbfd;
        color: #2d353c;
        font-size: 15px;
        font-weight: 700;
    }

    .section-box-header i {
        margin-right: 7px;
        color: #5c6bc0;
    }

    .section-box-body {
        padding: 15px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .detail-grid.one-col {
        grid-template-columns: 1fr;
    }

    .detail-item {
        padding: 12px 13px;
        border: 1px solid #e8edf3;
        border-radius: 8px;
        background: #fbfcfe;
    }

    .detail-item .label-text {
        margin-bottom: 5px;
        color: #6c757d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .detail-item .value {
        min-height: 20px;
        color: #2d353c;
        font-size: 14px;
        word-break: break-word;
    }

    .registration-card {
        padding: 14px;
        border: 1px solid #d5ecd9;
        border-radius: 8px;
        background: #f3fbf5;
    }

    .registration-card.empty {
        border-color: #ece3ce;
        background: #fff9eb;
    }

    .action-bar .btn {
        margin-left: 4px;
        margin-bottom: 4px;
    }

    .label-mobile-jkn {
        background: #4338ca;
        color: #fff;
    }

    .label-checkin-pending {
        background: #f59c1a;
        color: #fff;
    }

    .label-checkin-done {
        background: #00acac;
        color: #fff;
    }

    .label-checkin-cancel {
        background: #ff5b57;
        color: #fff;
    }

    @media (max-width: 767px) {
        .queue-hero {
            flex-direction: column;
        }

        .queue-code-box {
            min-width: 0;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-list-ol"></i> Detail Antrian Poliklinik
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="queue-hero">
            <div class="queue-title">
                <h3><?= h($polyclinicQueue->patients_name ?: '-') ?></h3>
                <div class="meta">
                    <?= h($polyclinicQueue->poly_name ?: '-') ?> -
                    <span class="label <?= $sourceClass ?>"><?= h($sourceLabel) ?></span>
                    <span class="label <?= $statusClass ?>"><?= h($statusLabel) ?></span>
                </div>
            </div>

            <div class="queue-code-box">
                <span class="caption">Nomor Antrian</span>
                <span class="code"><?= h($polyclinicQueue->code ?: '-') ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="section-box">
                    <div class="section-box-header">
                        <i class="fa fa-ticket-alt"></i> Informasi Antrian
                    </div>
                    <div class="section-box-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="label-text">Kode Antrian</div>
                                <div class="value"><?= h($polyclinicQueue->code ?: '-') ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Nomor Urut</div>
                                <div class="value"><?= h($polyclinicQueue->queue_number ?: '-') ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Sumber</div>
                                <div class="value"><span class="label <?= $sourceClass ?>"><?= h($sourceLabel) ?></span></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Status</div>
                                <div class="value"><span class="label <?= $statusClass ?>"><?= h($statusLabel) ?></span></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Poliklinik</div>
                                <div class="value"><?= h($polyclinicQueue->poly_name ?: '-') ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Waktu Dibuat</div>
                                <div class="value"><?= h($created) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Nama Pasien</div>
                                <div class="value"><?= h($polyclinicQueue->patients_name ?: '-') ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">No HP</div>
                                <div class="value"><?= h($polyclinicQueue->no_telp ?: '-') ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($isMobileJkn): ?>
                    <div class="section-box">
                        <div class="section-box-header">
                            <i class="fa fa-mobile-alt"></i> Informasi Mobile JKN
                        </div>
                        <div class="section-box-body">
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="label-text">Kode Booking</div>
                                    <div class="value"><?= h($polyclinicQueue->booking_code ?: '-') ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">Tanggal Periksa</div>
                                    <div class="value"><?= h($visitDate) ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">NIK</div>
                                    <div class="value"><?= h($polyclinicQueue->identity_number ?: '-') ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">No Kartu BPJS</div>
                                    <div class="value"><?= h($polyclinicQueue->bpjs_number ?: '-') ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">Status Check-in</div>
                                    <div class="value"><span class="label <?= $statusClass ?>"><?= h($statusLabel) ?></span></div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">Waktu Check-in</div>
                                    <div class="value"><?= h($checkinTime) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <div class="section-box">
                    <div class="section-box-header">
                        <i class="fa fa-file-text-o"></i> Registrasi
                    </div>
                    <div class="section-box-body">
                        <div class="registration-card <?= $isRegistered ? '' : 'empty' ?>">
                            <?php if ($isRegistered): ?>
                                <p style="margin-bottom:12px;">
                                    Antrian ini sudah menjadi registrasi:
                                    <br>
                                    <strong><?= h($registration->registration_no) ?></strong>
                                </p>

                                <?= $this->Html->link(
                                    '<i class="fa fa-check"></i> Lihat Registrasi',
                                    [
                                        'controller' => 'Registrations',
                                        'action' => 'view',
                                        $registration->id,
                                    ],
                                    [
                                        'class' => 'btn btn-success btn-sm',
                                        'escape' => false,
                                    ]
                                ) ?>
                            <?php else: ?>
                                <p style="margin-bottom:12px;">Antrian ini belum dibuatkan registrasi.</p>

                                <?php if ($isActive): ?>
                                    <?php if ($isMobileJkn && !in_array((string)$polyclinicQueue->checkin_status, ['Batal', 'Selesai'], true)): ?>
                                        <?php
                                        $checkinButtonLabel = $polyclinicQueue->checkin_status === 'Sudah Check-in'
                                            ? '<i class="fa fa-clipboard"></i> Daftar Registrasi'
                                            : '<i class="fa fa-sign-in-alt"></i> Check-in';
                                        ?>
                                        <?= $this->Form->postLink(
                                            $checkinButtonLabel,
                                            ['action' => 'checkIn', $polyclinicQueue->id],
                                            [
                                                'class' => 'btn btn-inverse btn-sm',
                                                'escape' => false,
                                                'confirm' => 'Check-in antrian Mobile JKN ini dan lanjut ke registrasi?'
                                            ]
                                        ) ?>
                                    <?php elseif (!$isMobileJkn): ?>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-clipboard"></i> Daftar Registrasi',
                                            [
                                                'controller' => 'Registrations',
                                                'action' => 'add',
                                                '?' => [
                                                    'queue_id' => $polyclinicQueue->id,
                                                    'queue_number' => $polyclinicQueue->queue_number,
                                                    'queue_code' => $polyclinicQueue->code,
                                                    'poly_name' => $polyclinicQueue->poly_name,
                                                ],
                                            ],
                                            [
                                                'class' => 'btn btn-primary btn-sm',
                                                'escape' => false,
                                            ]
                                        ) ?>
                                    <?php else: ?>
                                        <span class="btn btn-default btn-sm disabled">
                                            <i class="fa fa-ban"></i> <?= h($polyclinicQueue->checkin_status) ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="section-box">
                    <div class="section-box-header">
                        <i class="fa fa-print"></i> Cetak
                    </div>
                    <div class="section-box-body">
                        <?= $this->Html->link(
                            '<i class="fa fa-download"></i> Download Nomor Antrian',
                            ['action' => 'pdf', $polyclinicQueue->id],
                            [
                                'class' => 'btn btn-danger btn-block',
                                'escape' => false,
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="text-right action-bar">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default', 'escape' => false]
            ) ?>

            <?= $this->Html->link(
                '<i class="fa fa-pencil"></i> Edit',
                ['action' => 'edit', $polyclinicQueue->id],
                ['class' => 'btn btn-warning', 'escape' => false]
            ) ?>
        </div>
    </div>
</div>
