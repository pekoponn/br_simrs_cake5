<?php
/**
 * @var \App\View\AppView $this
 * @var string $title
 * @var array $queues
 * @var string $emptyMessage
 * @var callable $buildWhatsAppLink
 * @var callable $isMobileJknQueue
 * @var callable $isReferralQueue
 * @var callable $canRegisterQueue
 */
?>

<div class="queue-section">
    <div class="queue-section-heading">
        <h5><?= h($title) ?></h5>
        <span class="badge badge-info"><?= count($queues) ?> data</span>
    </div>

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
                <?php if (count($queues) > 0): ?>
                    <?php foreach ($queues as $queue): ?>
                        <?php
                        $isMobileJkn = $isMobileJknQueue($queue);
                        $isReferral = $isReferralQueue($queue);

                        if (in_array(strtolower(trim((string)$queue->source)), ['wa', 'whatsapp'], true)) {
                            $sourceBadge = '<span class="label label-success">WhatsApp</span>';
                        } elseif ($isMobileJkn) {
                            $sourceBadge = '<span class="label label-mobile-jkn">Mobile JKN</span>';
                        } elseif ($isReferral) {
                            $sourceBadge = '<span class="label label-info">Rujukan</span>';
                        } else {
                            $sourceBadge = '<span class="label label-primary">Manual</span>';
                        }

                        $registration = $queue->registration ?? null;
                        $canRegister = $canRegisterQueue($queue);
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
                                    '#modalViewQueue' . $queue->id,
                                    [
                                        'class' => 'btn btn-info btn-sm',
                                        'escape' => false,
                                        'data-toggle' => 'modal',
                                        'title' => 'Lihat Detail Antrian'
                                    ]
                                ) ?>
                                <?php if (!$registration): ?>
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

                                    <?php if ($canRegister): ?>
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

                                        <?php if ($queue->is_active == 'Y'): ?>
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

                                        <?php if ($isMobileJkn && $queue->is_active == 'Y'): ?>
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
                                                '<i class="fa fa-user-plus"></i>',
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
                                                    'escape' => false,
                                                    'class' => 'btn btn-success btn-sm'
                                                ]
                                            ) ?>
                                        <?php else: ?>
                                            <span class="btn btn-default btn-sm disabled" title="Tidak Aktif">
                                                <i class="fa fa-ban"></i>
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
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
                                <?= h($emptyMessage) ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
