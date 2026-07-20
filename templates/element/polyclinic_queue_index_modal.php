<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue $queue
 * @var callable $isMobileJknQueue
 * @var callable $isReferralQueue
 */

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
?>

<div class="modal fade" id="modalViewQueue<?= $queue->id ?>" tabindex="-1" role="dialog" aria-labelledby="modalViewQueueTitle<?= $queue->id ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title" id="modalViewQueueTitle<?= $queue->id ?>">
                    Detail Antrian <?= h($queue->code ?: '-') ?>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th width="220">Kode Antrian</th>
                                <td><?= h($queue->code ?: '-') ?></td>
                            </tr>
                            <tr>
                                <th>Source</th>
                                <td><?= $sourceBadge ?></td>
                            </tr>
                            <tr>
                                <th>Nama Pasien</th>
                                <td><?= h($queue->patients_name ?: '-') ?></td>
                            </tr>
                            <?php if ($isMobileJkn): ?>
                                <tr>
                                    <th>NIK</th>
                                    <td><?= h($queue->identity_number ?: '-') ?></td>
                                </tr>
                                <tr>
                                    <th>No BPJS</th>
                                    <td><?= h($queue->bpjs_number ?: '-') ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th>Poliklinik</th>
                                <td><?= h($queue->poly_name ?: '-') ?></td>
                            </tr>
                            <tr>
                                <th>No Antrian</th>
                                <td><?= h($queue->queue_number ?: '-') ?></td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td><?= h($queue->no_telp ?: '-') ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?= $activeBadge ?></td>
                            </tr>
                            <?php if ($isMobileJkn): ?>
                                <tr>
                                    <th>Booking Code</th>
                                    <td><?= h($queue->booking_code ?: '-') ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th>Call Status</th>
                                <td><?= h($queue->call_status ?: '-') ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Dipanggil</th>
                                <td><?= h($queue->call_count ?: '0') ?></td>
                            </tr>
                            <?php if ($isMobileJkn): ?>
                                <tr>
                                    <th>Waktu Check-in</th>
                                    <td>
                                        <?= !empty($queue->checkin_time)
                                            ? h($queue->checkin_time->format('d-m-Y H:i'))
                                            : '-' ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
