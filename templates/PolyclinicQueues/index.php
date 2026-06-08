<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue[]|\Cake\Collection\CollectionInterface $polyclinicQueues
 */

$normalizeWhatsAppNumber = function ($phone): string {
    $number = preg_replace('/\D+/', '', (string)$phone);

    if ($number === '') {
        return '';
    }

    if (strpos($number, '0') === 0) {
        return '62' . substr($number, 1);
    }

    return $number;
};

$buildWhatsAppLink = function ($queue) use ($normalizeWhatsAppNumber): ?string {
    $phone = $normalizeWhatsAppNumber($queue->no_telp ?? '');

    if ($phone === '') {
        return null;
    }

    $message = 'Halo, nomor antrian Anda adalah ' . ($queue->code ?? '-') . ".\n"
        . 'Tujuan poli: ' . ($queue->poly_name ?? '-') . ".\n"
        . 'Silakan menunggu panggilan petugas.';

    return 'https://wa.me/' . $phone . '?text=' . rawurlencode($message);
};

$isMobileJknQueue = function ($queue): bool {
    return (string)($queue->source ?? '') === 'Mobile JKN';
};
?>

<?= $this->Krs->breadcrumb('Polyclinic Queue', 'Data Antrian') ?>

<style>
    .queue-index-page .alert-primary {
        padding: 12px 16px;
        border: 0;
        border-radius: 4px;
        background: #cfe5f8;
        color: #0b3d75;
        font-size: 13px;
    }

    .queue-toolbar {
        margin: 16px 0 18px;
    }

    .queue-toolbar .btn {
        margin-right: 8px;
    }

    .queue-filter {
        padding: 10px 12px;
        background: #49b6d6;
        border-radius: 0;
    }

    .queue-filter .form-control {
        height: 36px;
        border: 0;
        border-radius: 4px;
        font-size: 13px;
    }

    .queue-filter .btn {
        height: 36px;
        min-width: 48px;
        border-radius: 4px;
        font-size: 14px;
    }

    .queue-table {
        margin-bottom: 0;
        background: #fff;
    }

    .queue-table thead th {
        padding: 10px 9px;
        border-color: #2d353c !important;
        background: #2d353c;
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        vertical-align: middle;
    }

    .queue-table tbody td {
        padding: 9px 9px;
        border-top: 1px solid #e5e9ef;
        color: #172033;
        font-size: 13px;
        vertical-align: middle;
    }

    .queue-table tbody tr:nth-child(odd) td {
        background: #f1f3f5;
    }

    .queue-table tbody tr:nth-child(even) td {
        background: #fff;
    }

    .queue-code {
        color: #172033;
        font-weight: 800;
    }

    .queue-patient {
        font-weight: 700;
        line-height: 1.25;
    }

    .queue-subtle {
        display: block;
        margin-top: 2px;
        color: #6c757d;
        font-size: 11px;
        font-weight: 600;
    }

    .queue-actions {
        white-space: nowrap;
    }

    .queue-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        min-height: 30px;
        margin: 1px;
        border-radius: 4px;
        padding: 5px 8px;
    }

    .queue-actions .btn-text {
        padding-left: 10px;
        padding-right: 10px;
        gap: 6px;
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

    .queue-pagination {
        padding-top: 12px;
    }

    @media (max-width: 991px) {
        .queue-filter .row > div {
            margin-bottom: 10px;
        }

        .queue-toolbar .btn {
            margin-bottom: 8px;
        }
    }
</style>

<div class="panel panel-inverse queue-index-page">
    <div class="panel-heading">
        <h4 class="panel-title">
            Perincian
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;"
                class="btn btn-xs btn-icon btn-circle btn-default"
                data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="alert alert-primary">
            Halaman <strong>Data Antrian Poliklinik</strong>, digunakan untuk mengelola antrian Manual, WhatsApp, dan Mobile JKN.
        </div>

        <div class="portlet-body form">
            <div class="table-toolbar queue-toolbar">
                <div class="btn-group">
                    <?= $this->Html->link(
                        '<i class="fa fa-plus"> Tambah Antrian WA</i>',
                        ['action' => 'add'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Tambah Antrian WhatsApp'
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="fa fa-mobile-alt"> Tambah Antrian Mobile JKN</i>',
                        ['action' => 'mobileJkn'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Tambah Antrian Mobile JKN'
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="fa fa-desktop"> Mesin Anjungan</i>',
                        ['action' => 'kiosk'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Mesin Anjungan / Manual'
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="fa fa-tv"> Display TV</i>',
                        ['action' => 'display'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'target' => '_blank',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Tampilan layar TV antrian poli'
                        ]
                    ) ?>
                </div>
            </div>

            <?= $this->Form->create(null, ['type' => 'get']) ?>
                <div class="queue-filter">
                    <div class="row row-space-10">
                        <div class="col-md-3 m-b-10">
                            <?= $this->Form->text('key', [
                                'class' => 'form-control',
                                'placeholder' => 'Kode / booking...',
                                'value' => $this->request->getQuery('key')
                            ]) ?>
                        </div>

                        <div class="col-md-5 m-b-10">
                            <?= $this->Form->text('key_label', [
                                'class' => 'form-control',
                                'placeholder' => 'Nama pasien / poli / no HP / BPJS...',
                                'value' => $this->request->getQuery('key'),
                                'oninput' => 'document.getElementById("key").value = this.value;'
                            ]) ?>
                        </div>

                        <div class="col-md-1">
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?= $this->Form->end() ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-td-valign-middle queue-table">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="90">Kode</th>
                            <th width="110">Source</th>
                            <th>Pasien</th>
                            <th width="170">Poliklinik</th>
                            <th width="105">No Antrian</th>
                            <th width="145">No HP</th>
                            <th width="135">Status</th>
                            <th width="250" class="actions">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (count($polyclinicQueues) > 0): ?>
                            <?php foreach ($polyclinicQueues as $queue): ?>
                                <?php
                                $isMobileJkn = $isMobileJknQueue($queue);

                                if (in_array(strtolower((string)$queue->source), ['wa', 'whatsapp'], true)) {
                                    $sourceBadge = '<span class="label label-success">WhatsApp</span>';
                                } elseif ($isMobileJkn) {
                                    $sourceBadge = '<span class="label label-mobile-jkn">Mobile JKN</span>';
                                } else {
                                    $sourceBadge = '<span class="label label-primary">Manual</span>';
                                }

                                $registration = $queue->registration ?? null;
                                $isWhatsAppQueue = in_array(strtolower((string)$queue->source), ['wa', 'whatsapp'], true);
                                $whatsAppLink = $isWhatsAppQueue ? $buildWhatsAppLink($queue) : null;

                                if ($registration) {
                                    $activeBadge = '<span class="label label-success">Registered</span><span class="queue-subtle">' . h($registration->registration_no) . '</span>';
                                } elseif ($isMobileJkn) {
                                    $checkinStatus = $queue->checkin_status ?: 'Belum Check-in';

                                    if ($checkinStatus === 'Sudah Check-in') {
                                        $checkinClass = 'label-checkin-done';
                                    } elseif ($checkinStatus === 'Batal') {
                                        $checkinClass = 'label-checkin-cancel';
                                    } elseif ($checkinStatus === 'Selesai') {
                                        $checkinClass = 'label-success';
                                    } else {
                                        $checkinClass = 'label-checkin-pending';
                                    }

                                    $activeBadge = '<span class="label ' . $checkinClass . '">' . h($checkinStatus) . '</span>';

                                    if (!empty($queue->checkin_time)) {
                                        $activeBadge .= '<span class="queue-subtle">' . h($queue->checkin_time->format('d-m-Y H:i')) . '</span>';
                                    }
                                } elseif ($queue->is_active == 'Y') {
                                    $activeBadge = '<span class="label label-primary">Active</span>';
                                } else {
                                    $activeBadge = '<span class="label label-default">Non Active</span>';
                                }

                                if (!$registration && $queue->call_status === 'Dipanggil') {
                                    $activeBadge .= '<span class="queue-subtle">Dipanggil'
                                        . (!empty($queue->call_count) ? ' x' . h($queue->call_count) : '')
                                        . '</span>';
                                }

                                $classCondition = $queue->is_active == 'Y' ? '' : 'class="table-warning"';
                                ?>

                                <tr <?= $classCondition ?>>
                                    <td align="center">
                                        <span class="queue-code"><?= h($queue->code ?: '-') ?></span>
                                        <?php if ($isMobileJkn && !empty($queue->booking_code)): ?>
                                            <span class="queue-subtle"><?= h($queue->booking_code) ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td align="center"><?= $sourceBadge ?></td>

                                    <td>
                                        <div class="queue-patient"><?= h($queue->patients_name ?: '-') ?></div>
                                        <?php if ($isMobileJkn): ?>
                                            <span class="queue-subtle">
                                                NIK: <?= h($queue->identity_number ?: '-') ?> / BPJS: <?= h($queue->bpjs_number ?: '-') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= h($queue->poly_name ?: '-') ?></td>

                                    <td align="center">
                                        <span class="badge badge-info"><?= h($queue->queue_number ?: '-') ?></span>
                                    </td>

                                    <td><?= h($queue->no_telp ?: '-') ?></td>

                                    <td align="center"><?= $activeBadge ?></td>

                                    <td class="actions queue-actions" align="center">
                                        <?= $this->Html->link(
                                            '<i class="fa fa-eye"></i>',
                                            ['action' => 'view', $queue->id],
                                            [
                                                'class' => 'btn btn-info btn-sm',
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Lihat Detail Antrian'
                                            ]
                                        ) ?>

                                        <?= $this->Html->link(
                                            '<i class="fa fa-print"></i>',
                                            ['action' => 'pdf', $queue->id],
                                            [
                                                'class' => 'btn btn-danger btn-sm',
                                                'escape' => false,
                                                'target' => '_blank',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Cetak Nomor Antrian PDF'
                                            ]
                                        ) ?>

                                        <?php if (!empty($whatsAppLink)): ?>
                                            <?= $this->Html->link(
                                                '<i class="fab fa-whatsapp"></i>',
                                                $whatsAppLink,
                                                [
                                                    'class' => 'btn btn-success btn-sm',
                                                    'escape' => false,
                                                    'target' => '_blank',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Kirim WhatsApp'
                                                ]
                                            ) ?>
                                        <?php endif; ?>

                                        <?php if ($registration): ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-check"></i>',
                                                [
                                                    'controller' => 'Registrations',
                                                    'action' => 'view',
                                                    $registration->id,
                                                ],
                                                [
                                                    'class' => 'btn btn-success btn-sm',
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Lihat Registrasi'
                                                ]
                                            ) ?>
                                        <?php elseif ($queue->is_active == 'Y'): ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fa fa-volume-up"></i>',
                                                ['action' => 'callQueue', $queue->id],
                                                [
                                                    'class' => 'btn btn-warning btn-sm',
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Panggil pasien ke loket/poli',
                                                    'confirm' => 'Panggil nomor antrian ' . h($queue->code) . '?'
                                                ]
                                            ) ?>
                                        <?php endif; ?>

                                        <?php if ($registration): ?>
                                            <?php // Tombol registrasi sudah ditampilkan di atas. ?>
                                        <?php elseif ($isMobileJkn && $queue->is_active == 'Y'): ?>
                                            <?php if (in_array((string)$queue->checkin_status, ['Batal', 'Selesai'], true)): ?>
                                                <span class="btn btn-default btn-sm disabled" title="<?= h($queue->checkin_status) ?>">
                                                    <i class="fa fa-ban"></i>
                                                </span>
                                            <?php else: ?>
                                                <?php
                                                $checkinButtonLabel = $queue->checkin_status === 'Sudah Check-in'
                                                    ? '<i class="fa fa-clipboard"></i>'
                                                    : '<i class="fa fa-sign-in-alt"></i>';
                                                ?>
                                                <?= $this->Form->postLink(
                                                    $checkinButtonLabel,
                                                    ['action' => 'checkIn', $queue->id],
                                                    [
                                                        'class' => 'btn btn-inverse btn-sm',
                                                        'escape' => false,
                                                        'data-toggle' => 'tooltip',
                                                        'title' => 'Check-in lalu lanjut registrasi',
                                                        'confirm' => 'Check-in antrian Mobile JKN ini dan lanjut ke registrasi?'
                                                    ]
                                                ) ?>
                                            <?php endif; ?>
                                        <?php elseif ($queue->is_active == 'Y'): ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-clipboard"></i>',
                                                [
                                                    'controller' => 'Registrations',
                                                    'action' => 'add',
                                                    '?' => [
                                                        'queue_id' => $queue->id,
                                                        'queue_number' => $queue->queue_number,
                                                        'queue_code' => $queue->code,
                                                        'poly_name' => $queue->poly_name,
                                                    ]
                                                ],
                                                [
                                                    'class' => 'btn btn-primary btn-sm',
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Daftar Registrasi'
                                                ]
                                            ) ?>
                                        <?php else: ?>
                                            <span class="btn btn-default btn-sm disabled" title="Tidak Aktif">
                                                <i class="fa fa-ban"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div style="padding:20px;">
                                        <i class="fa fa-database fa-2x"></i>
                                        <br><br>
                                        Data antrian tidak ditemukan
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="row queue-pagination">
                <div class="col-md-6">
                    <p>
                        <?= $this->Paginator->counter('Menampilkan {{current}} data dari {{count}} total data') ?>
                    </p>
                </div>

                <div class="col-md-6 text-right">
                    <ul class="pagination pagination-sm m-t-0 m-b-0 pull-right">
                        <?= $this->Paginator->first('<<') ?>
                        <?= $this->Paginator->prev('<') ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('>') ?>
                        <?= $this->Paginator->last('>>') ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
