<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue|null $calledQueue
 * @var \App\Model\Entity\PolyclinicQueue|null $nextOnlineQueue
 * @var \App\Model\Entity\PolyclinicQueue|null $nextOnsiteQueue
 * @var int $onlineTotal
 * @var int $onsiteTotal
 * @var int $onlineWaiting
 * @var int $onsiteWaiting
 * @var array|\Cake\Collection\CollectionInterface $waitingQueueList
 * @var string $todayLabel
 */

$queueCode = function ($queue): string {
    return $queue ? (string)($queue->code ?: '-') : '-';
};

$queuePoly = function ($queue): string {
    return $queue ? (string)($queue->poly_name ?: '-') : '-';
};

$queueSource = function ($queue): string {
    if (!$queue) {
        return 'Belum ada panggilan';
    }

    return $queue->source === 'Mobile JKN' ? 'Mobile JKN' : 'Loket Rumah Sakit';
};

$currentStatus = $calledQueue ? 'Sedang dipanggil' : 'Belum ada panggilan';

// Sebelum jam 14:00 tampilkan antrian A, mulai jam 14:00 tampilkan antrian B.
$queueShiftPrefix = ((int)date('G') >= 14) ? 'B' : 'A';

$waitingQueueList = array_values(array_filter(
    !empty($waitingQueueList)
        ? (is_array($waitingQueueList) ? $waitingQueueList : $waitingQueueList->toList())
        : [],
    function ($item) use ($queueShiftPrefix) {
        return strtoupper(substr((string)($item->code ?? ''), 0, 1)) === $queueShiftPrefix;
    }
));
?>

<script>
    document.body.classList.add('queue-display-mode');
</script>

<style>
    .queue-display-mode #header,
    .queue-display-mode .header,
    .queue-display-mode #sidebar,
    .queue-display-mode #sidebar-bg,
    .queue-display-mode .sidebar-bg,
    .queue-display-mode .sidebar,
    .queue-display-mode .page-sidebar,
    .queue-display-mode .page-sidebar-minify-btn,
    .queue-display-mode #footer,
    .queue-display-mode .footer,
    .queue-display-mode .btn-scroll-to-top {
        display: none !important;
    }

    html:has(body.queue-display-mode),
    body.queue-display-mode {
        width: 100% !important;
        height: 100vh !important;
        min-height: 100vh !important;
        overflow: hidden !important;
        background: #edf3f7 !important;
    }

    .queue-display-mode #page-container,
    .queue-display-mode #content.content {
        position: static !important;
        width: 100% !important;
        height: 100vh !important;
        min-height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        background: #edf3f7 !important;
    }

    .queue-display-page,
    .queue-display-page * {
        box-sizing: border-box;
    }

    .queue-display-page {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
        padding: 10px 28px;
        color: #172033;
        background:
            linear-gradient(135deg, rgba(232, 245, 241, 0.96), rgba(236, 243, 252, 0.96)),
            radial-gradient(circle at 0% 0%, rgba(15, 118, 110, 0.14), transparent 30%),
            radial-gradient(circle at 100% 0%, rgba(29, 78, 216, 0.14), transparent 30%);
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .display-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex: 0 0 auto;
    }

    .display-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .brand-logo {
    width: 52px;
    height: 52px;
    padding: 5px;
    border: 1px solid #d8e3ec;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 10px 24px rgba(15, 118, 110, 0.16);
}

.brand-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

    .brand-title {
        margin: 0;
        color: #112136;
        font-size: clamp(17px, 1.5vw, 24px);
        font-weight: 900;
        line-height: 1.05;
        letter-spacing: 0;
    }

    .brand-subtitle {
        margin-top: 4px;
        color: #667085;
        font-size: clamp(11px, 0.9vw, 14px);
        font-weight: 800;
    }

    .time-panel {
        min-width: 160px;
        padding: 6px 12px;
        border: 1px solid #d8e3ec;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.86);
        text-align: right;
        box-shadow: 0 10px 22px rgba(31, 45, 61, 0.08);
    }

    .time-date {
        color: #667085;
        font-size: 13px;
        font-weight: 900;
    }

    .time-clock {
        margin-top: 3px;
        color: #112136;
        font-size: clamp(18px, 1.7vw, 26px);
        font-weight: 900;
        line-height: 1;
    }

    .display-center {
        display: flex;
        align-items: stretch;
        justify-content: center;
        flex: 1 1 auto;
        min-height: 0;
        padding: 8px 0;
    }

    .display-layout {
        display: grid;
        grid-template-columns: minmax(560px, 1fr) 410px;
        gap: 20px;
        width: 100%;
        min-height: 0;
        align-items: stretch;
    }

    .display-left {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 0;
        min-height: 0;
    }

    .queue-board {
        display: grid;
        grid-template-columns: repeat(2, minmax(260px, 1fr));
        grid-template-areas:
            "current current"
            "online onsite";
        gap: 14px 20px;
        width: min(900px, 100%);
        align-items: center;
        justify-items: center;
    }

    .display-card {
        width: 100%;
        min-height: 200px;
        padding: 20px 22px;
        border: 1px solid rgba(214, 226, 236, 0.94);
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.94);
        box-shadow: 0 10px 24px rgba(31, 45, 61, 0.1);
        text-align: center;
    }

    .summary-card.online {
        grid-area: online;
    }

    .summary-card.online {
        border-top: 6px solid #0f766e;
    }

    .summary-card.onsite {
        grid-area: onsite;
    }

    .summary-card.onsite {
        border-top: 6px solid #1d4ed8;
    }

    .current-card {
        grid-area: current;
        width: min(460px, 100%);
        min-height: 250px;
        border-top: 6px solid #dc2626;
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(255, 251, 251, 0.96));
    }

    .card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        color: #fff;
        font-size: 16px;
        box-shadow: 0 8px 16px rgba(31, 45, 61, 0.12);
    }

    .online .card-icon {
        background: linear-gradient(135deg, #0f766e, #13a88e);
    }

    .onsite .card-icon {
        background: linear-gradient(135deg, #1d4ed8, #2563eb);
    }

    .current-card .card-icon {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .card-kicker {
        margin-top: 8px;
        color: #667085;
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
    }

    .card-title {
        margin: 4px 0 0;
        color: #112136;
        font-size: clamp(16px, 1.35vw, 21px);
        font-weight: 900;
        line-height: 1.1;
        letter-spacing: 0;
    }

    .total-number {
        margin: 8px 0 0;
        font-size: clamp(44px, 4vw, 64px);
        font-weight: 900;
        line-height: 0.95;
    }

    .online .total-number {
        color: #0f766e;
    }

    .onsite .total-number {
        color: #1d4ed8;
    }

    .total-label {
        color: #667085;
        font-size: 13px;
        font-weight: 800;
    }

    .mini-info {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 8px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f7fbfd;
        border: 1px solid #dfeaf2;
        color: #475467;
        font-size: 12px;
        font-weight: 900;
    }

    .current-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-top: 7px;
        padding: 5px 10px;
        border-radius: 999px;
        background: #fee2e2;
        color: #b91c1c;
        font-size: 12px;
        font-weight: 900;
    }

    .current-status.empty {
        background: #eef2ff;
        color: #475467;
    }

    .current-number {
        margin: 6px 0 3px;
        color: #dc2626;
        font-size: clamp(56px, 5.5vw, 84px);
        font-weight: 900;
        line-height: 0.95;
        letter-spacing: 0;
    }

    .current-poly {
        color: #112136;
        font-size: clamp(15px, 1.3vw, 20px);
        font-weight: 900;
        line-height: 1.15;
    }

    .current-source {
        margin-top: 5px;
        color: #667085;
        font-size: 13px;
        font-weight: 900;
    }

    .queue-list-panel {
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
        border: 1px solid rgba(214, 226, 236, 0.94);
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 10px 24px rgba(31, 45, 61, 0.10);
    }

    .queue-list-header {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 14px 16px;
        border-bottom: 1px solid #e5edf4;
        background: linear-gradient(90deg, #f8fbff, #ecfdf7);
    }

    .queue-list-title {
        margin: 0;
        color: #112136;
        font-size: 18px;
        font-weight: 900;
        line-height: 1.1;
    }

    .queue-list-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        border-radius: 999px;
        background: #0f766e;
        color: #fff;
        font-size: 15px;
        font-weight: 900;
    }

    .queue-list-body {
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto;
        padding: 10px;
    }

    .queue-list-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .queue-list-table th {
        padding: 0 8px 4px;
        color: #667085;
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .queue-list-table td {
        padding: 10px 8px;
        background: #f8fbfd;
        border-top: 1px solid #e5edf4;
        border-bottom: 1px solid #e5edf4;
        color: #172033;
        font-size: 13px;
        font-weight: 800;
        vertical-align: middle;
    }

    .queue-list-table td:first-child {
        border-left: 1px solid #e5edf4;
        border-radius: 12px 0 0 12px;
    }

    .queue-list-table td:last-child {
        border-right: 1px solid #e5edf4;
        border-radius: 0 12px 12px 0;
    }

    .queue-list-code {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 54px;
        padding: 7px 8px;
        border-radius: 10px;
        background: #1d4ed8;
        color: #fff;
        font-size: 16px;
        font-weight: 900;
        line-height: 1;
    }

    .queue-list-patient {
        display: block;
        max-width: 150px;
        overflow: hidden;
        color: #112136;
        font-weight: 900;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .queue-list-poly {
        display: block;
        max-width: 140px;
        overflow: hidden;
        color: #667085;
        font-size: 12px;
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .queue-list-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        background: #ecfdf7;
        color: #0f766e;
        font-size: 11px;
        font-weight: 900;
        white-space: nowrap;
    }

    .queue-list-empty {
        padding: 28px 14px;
        color: #667085;
        font-size: 14px;
        font-weight: 900;
        text-align: center;
    }

    .display-help {
        flex: 0 0 auto;
        padding-top: 4px;
        color: #667085;
        font-size: 13px;
        font-weight: 800;
        text-align: center;
    }

    @media (max-width: 1000px) {
        body.queue-display-mode {
            overflow: auto !important;
        }

        .queue-display-mode #page-container,
        .queue-display-mode #content.content {
            height: auto !important;
            min-height: 100vh !important;
            overflow: visible !important;
        }

        .queue-display-page {
            height: auto;
            min-height: 100vh;
            overflow: visible;
            padding: 18px;
        }

        .display-top {
            align-items: flex-start;
        }

        .time-panel {
            min-width: 180px;
        }

        .display-layout {
            grid-template-columns: 1fr;
        }

        .display-left {
            align-items: stretch;
        }

        .queue-list-panel {
            min-height: 360px;
        }

        .queue-board {
            grid-template-columns: 1fr;
            grid-template-areas:
                "current"
                "online"
                "onsite";
            gap: 16px;
        }

        .display-card {
            min-height: 200px;
        }

        .current-card {
            width: 100%;
        }
    }
</style>

<div class="queue-display-page">
    <div class="display-top">
        <div class="display-brand">
            <div class="brand-logo">
                <?= $this->Html->image('logo_br2.png', ['alt' => 'Logo Rumah Sakit Bhakti Rahayu']) ?>
            </div>
            <div>
                <h1 class="brand-title">Antrian Loket Pendaftaran</h1>
                <div class="brand-subtitle">Rumah Sakit Bhakti Rahayu</div>
            </div>
        </div>

        <div class="time-panel">
            <div class="time-date"><?= h($todayLabel) ?></div>
            <div class="time-clock" id="display-clock">--:--:--</div>
        </div>
    </div>

    <main class="display-center">
        <div class="display-layout">
            <div class="display-left">
                <div class="queue-board">
                    <section class="display-card summary-card online">
                        <div class="card-icon">
                            <i class="fa fa-mobile"></i>
                        </div>
                        <div class="card-kicker">Online</div>
                        <h2 class="card-title">Mobile JKN</h2>
                        <div class="total-number" id="online-total"><?= h($onlineTotal ?? 0) ?></div>
                        <div class="total-label">Total antrian hari ini</div>
                        <div class="mini-info">
                            <i class="fa fa-clock-o"></i>
                            Menunggu: <span id="online-waiting"><?= h($onlineWaiting ?? 0) ?></span>
                        </div>
                    </section>

                    <section class="display-card current-card">
                        <div class="card-icon">
                            <i class="fa fa-volume-up"></i>
                        </div>
                        <div class="card-kicker">Antrian Saat Ini</div>
                        <h2 class="card-title">Sedang Dipanggil</h2>
                        <div class="current-status<?= $calledQueue ? '' : ' empty' ?>" id="current-status">
                            <?= h($currentStatus) ?>
                        </div>
                        <div class="current-number" id="current-code"><?= h($queueCode($calledQueue)) ?></div>
                        <div class="current-source">
                        </div>
                    </section>

                    <section class="display-card summary-card onsite">
                        <div class="card-icon">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <div class="card-kicker">Onsite</div>
                        <h2 class="card-title">Loket Rumah Sakit</h2>
                        <div class="total-number" id="onsite-total"><?= h($onsiteTotal ?? 0) ?></div>
                        <div class="total-label">Total antrian hari ini</div>
                        <div class="mini-info">
                            <i class="fa fa-clock-o"></i>
                            Menunggu: <span id="onsite-waiting"><?= h($onsiteWaiting ?? 0) ?></span>
                        </div>
                    </section>
                </div>
            </div>

            <aside class="queue-list-panel">
                <div class="queue-list-header">
                    <h2 class="queue-list-title">Daftar Nomor Antrian</h2>
                    <div class="queue-list-badge" id="waiting-list-count"><?= h(!empty($waitingQueueList) ? count($waitingQueueList) : 0) ?></div>
                </div>

                <div class="queue-list-body">
                    <table class="queue-list-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pasien / Poli</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="waiting-queue-table-body">
                            <?php if (!empty($waitingQueueList)): ?>
                                <?php foreach ($waitingQueueList as $queueItem): ?>
                                    <tr>
                                        <td>
                                            <span class="queue-list-code"><?= h($queueItem->code ?: '-') ?></span>
                                        </td>
                                        <td>
                                            <span class="queue-list-patient"><?= h($queueItem->patients_name ?: '-') ?></span>
                                            <span class="queue-list-poly"><?= h($queueItem->poly_name ?: '-') ?></span>
                                        </td>
                                        <td>
                                            <span class="queue-list-status">
                                                <i class="fa fa-clock-o"></i>
                                                <?= h($queueItem->call_status ?: 'Menunggu') ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">
                                        <div class="queue-list-empty">Tidak ada antrian belum registrasi</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </aside>
        </div>
    </main>
</div>

<div class="display-help">
    Silakan menunggu sampai nomor antrian Anda dipanggil oleh petugas.
</div>

<script>
    (function() {
        function pad(value) {
            return value < 10 ? '0' + value : String(value);
        }

        function updateClock() {
            var now = new Date();
            var text = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
            var clock = document.getElementById('display-clock');
            if (clock) {
                clock.textContent = text;
            }
        }

        function setText(id, value) {
            var element = document.getElementById(id);
            if (element) {
                element.textContent = value;
            }
        }

        function escapeHtml(value) {
            return String(value === null || value === undefined ? '' : value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function renderWaitingQueueList(items) {
            var tbody = document.getElementById('waiting-queue-table-body');
            var count = document.getElementById('waiting-list-count');

            if (!tbody) {
                return;
            }


            items = Array.isArray(items) ? items : [];

            var shiftPrefix = (new Date().getHours() >= 14) ? 'B' : 'A';
            items = items.filter(function(item) {
                return String(item.code || '').charAt(0).toUpperCase() === shiftPrefix;
            });

            if (count) {
                count.textContent = items.length;
            }

            if (!items.length) {
                tbody.innerHTML = '<tr><td colspan="3"><div class="queue-list-empty">Tidak ada antrian belum registrasi</div></td></tr>';
                return;
            }

            tbody.innerHTML = items.map(function(item) {
                var code = escapeHtml(item.code || '-');
                var patient = escapeHtml(item.patients_name || '-');
                var poly = escapeHtml(item.poly_name || '-');
                var status = escapeHtml(item.call_status || 'Menunggu');

                return '' +
                    '<tr>' +
                        '<td><span class="queue-list-code">' + code + '</span></td>' +
                        '<td>' +
                            '<span class="queue-list-patient">' + patient + '</span>' +
                            '<span class="queue-list-poly">' + poly + '</span>' +
                        '</td>' +
                        '<td>' +
                            '<span class="queue-list-status"><i class="fa fa-clock-o"></i> ' + status + '</span>' +
                        '</td>' +
                    '</tr>';
            }).join('');
        }

        function updateQueueData() {
            fetch(window.location.pathname + '?ajax=1', {
                cache: 'no-store',
                credentials: 'same-origin'
            })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data display');
                    }

                    return response.json();
                })
                .then(function(data) {
                    setText('online-total', data.onlineTotal || 0);
                    setText('online-waiting', data.onlineWaiting || 0);
                    setText('onsite-total', data.onsiteTotal || 0);
                    setText('onsite-waiting', data.onsiteWaiting || 0);
                    setText('current-code', data.currentCode || '-');
                    setText('current-poly', data.currentPoly || '-');
                    setText('current-source', data.currentSource || 'Belum ada panggilan');
                    setText('current-status', data.currentStatus || 'Belum ada panggilan');

                    var status = document.getElementById('current-status');
                    if (status) {
                        status.classList.toggle('empty', !data.hasCurrent);
                    }

                    renderWaitingQueueList(data.waitingQueueList || []);
                })
                .catch(function() {
                    // Display tetap dibiarkan apa adanya kalau jaringan/data sedang belum siap.
                });
        }

        updateClock();
        setInterval(updateClock, 1000);
        setInterval(updateQueueData, 5000);
    })();
</script>