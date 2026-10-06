<?php $this->assign('title', 'Display Antrean');
$todayLabel = date('d F Y'); ?>
<script>
    document.body.classList.add('kiosk-mode');
</script>
<style>
    html,
    body {
        margin: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background: #edf7f8;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif
    }

    .kiosk-mode #header,
    .kiosk-mode #sidebar,
    .kiosk-mode #sidebar-bg,
    .kiosk-mode .sidebar,
    .kiosk-mode .page-sidebar,
    .kiosk-mode .page-sidebar-minify-btn,
    .kiosk-mode #footer {
        display: none !important
    }

    .kiosk-mode #page-container,
    .kiosk-mode #content.content {
        width: 100% !important;
        height: 100vh !important;
        min-height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        left: 0 !important
    }

    .display-page {
        height: 100vh;
        box-sizing: border-box;
        padding: 18px 28px;
        background: linear-gradient(135deg, #edf9f7, #edf3fc);
        color: #102a43
    }

    .display-shell {
        height: 100%;
        max-width: 1500px;
        margin: auto;
        display: flex;
        flex-direction: column
    }

    .kiosk-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px
    }

    .hospital-brand {
        display: flex;
        align-items: center;
        gap: 14px
    }

    .brand-mark {
        width: 54px;
        height: 54px;
        padding: 8px;
        box-sizing: border-box;
        border-radius: 14px;
        background: #fff;
        border: 1px solid #d8e3ec
    }

    .brand-mark img {
        width: 100%;
        height: 100%;
        object-fit: contain
    }

    .brand-name {
        margin: 0;
        font-size: 25px
    }

    .brand-subtitle {
        color: #52667a;
        font-size: 14px
    }

    .time-box {
        padding: 9px 18px;
        border: 1px solid #d5e1ea;
        border-radius: 14px;
        background: #fff;
        text-align: right
    }

    .time-box .date {
        color: #52667a;
        font-size: 12px
    }

    .time-box .clock {
        font-size: 23px;
        font-weight: 800
    }

    .display-card {
        flex: 1;
        min-height: 0;
        background: #fff;
        border: 1px solid #d8e3ec;
        border-radius: 24px;
        box-shadow: 0 16px 45px #1d405022;
        overflow: hidden
    }

    .display-heading {
        padding: 22px 30px;
        border-bottom: 1px solid #e5edf3
    }

    .display-heading h1 {
        margin: 0;
        font-size: 34px
    }

    .display-heading p {
        margin: 4px 0 0;
        color: #52667a;
        font-size: 16px
    }

    .display-table-wrap {
        height: calc(100% - 105px);
        overflow: auto;
        padding: 0 24px
    }

    .display-content {
        height: calc(100% - 105px);
        display: grid;
        grid-template-columns: 30% minmax(0, 1fr);
        gap: 22px;
        padding: 22px 24px;
        box-sizing: border-box;
    }

    .current-panel {
        background: #146cf5;
        color: #fff;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 24px;
        box-shadow: 0 8px 18px rgba(20, 108, 245, .25);
    }

    .current-panel .current-label {
        font-weight: 700;
        font-size: 18px;
    }

    .current-panel .current-number {
        font-size: clamp(60px, 8vw, 120px);
        line-height: 1;
        font-weight: 900;
        margin: 22px 0;
    }

    .current-panel .current-poli {
        font-weight: 800;
        font-size: 18px;
        text-transform: uppercase;
    }

    .current-detail {
        margin-top: 22px;
        background: #fff;
        color: #263746;
        border-radius: 10px;
        padding: 16px;
        width: 100%;
        box-sizing: border-box;
        font-size: 18px;
        font-weight: 700;
    }

    .current-detail small {
        display: block;
        color: #657786;
        font-weight: 600;
        margin-top: 6px;
    }

    .display-list-wrap {
        min-width: 0;
        overflow: auto;
    }

    .display-list-wrap .display-table {
        font-size: 24px;
    }

    .display-list-wrap .display-table th {
        padding: 20px 18px;
    }

    .display-list-wrap .display-table td {
        padding: 21px 18px;
    }

    .display-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 22px
    }

    .display-table th {
        position: sticky;
        top: 0;
        background: #123e59;
        color: #fff;
        padding: 16px;
        text-align: left
    }

    .display-table td {
        padding: 17px 16px;
        border-bottom: 1px solid #e5edf3
    }

    .display-table tbody tr:nth-child(even) {
        background: #f5fafc
    }

    .queue-number {
        font-weight: 900;
        color: #147d92;
        font-size: 30px
    }

    .empty-row {
        text-align: center;
        color: #8393a1;
        padding: 50px !important
    }

    @media(max-width:700px) {
        .display-page {
            padding: 10px
        }

        .brand-name {
            font-size: 18px
        }

        .brand-subtitle {
            font-size: 11px
        }

        .brand-mark {
            width: 44px;
            height: 44px
        }

        .time-box {
            padding: 6px 10px
        }

        .time-box .clock {
            font-size: 17px
        }

        .display-heading {
            padding: 16px
        }

        .display-heading h1 {
            font-size: 25px
        }

        .display-table-wrap,
        .display-content {
            padding: 0 10px
        }

        .display-content {
            height: calc(100% - 76px);
            display: block;
            padding-top: 10px;
        }

        .current-panel {
            min-height: 210px;
            margin-bottom: 12px;
        }

        .current-panel .current-number {
            margin: 10px 0;
            font-size: 58px;
        }

        .display-table {
            font-size: 16px
        }

        .display-table th,
        .display-table td {
            padding: 12px 8px
        }

        .queue-number {
            font-size: 22px
        }
    }
</style>
<style>
    body.kiosk-mode #page-container,
    body.kiosk-mode #page-container.page-sidebar-minified,
    body.kiosk-mode #page-container.page-sidebar-fixed,
    body.kiosk-mode #page-container.page-header-fixed,
    body.kiosk-mode #content,
    body.kiosk-mode #content.content {
        margin: 0 !important;
        padding: 0 !important;
        left: 0 !important;
        transform: none !important
    }

    body.kiosk-mode .display-page {
        position: fixed !important;
        inset: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: 1050 !important;
        padding: 10px 18px !important
    }

    .kiosk-top {
        margin-bottom: 8px !important
    }

    .brand-mark {
        width: 44px !important;
        height: 44px !important;
        padding: 7px !important
    }

    .brand-name {
        font-size: 21px !important
    }

    .brand-subtitle {
        font-size: 12px !important
    }

    .time-box {
        padding: 6px 13px !important;
        border-radius: 11px !important
    }

    .time-box .date {
        font-size: 11px !important
    }

    .time-box .clock {
        font-size: 18px !important
    }

    .display-card {
        border-radius: 18px !important
    }

    .display-heading {
        padding: 14px 22px !important
    }

    .display-heading h1 {
        font-size: 25px !important
    }

    .display-heading p {
        font-size: 13px !important;
        margin-top: 2px !important
    }

    .display-table-wrap {
        height: calc(100% - 76px) !important;
        padding: 0 18px !important
    }

    .display-table {
        font-size: 20px !important
    }

    .display-table th {
        padding: 16px 14px !important
    }

    .display-table td {
        padding: 17px 14px !important
    }

    .display-list-wrap .display-table {
        font-size: 24px !important
    }

    .display-list-wrap .display-table th {
        padding: 20px 18px !important
    }

    .display-list-wrap .display-table td {
        padding: 21px 18px !important
    }

    .queue-number {
        font-size: 25px !important
    }

    .empty-row {
        padding: 30px !important;
        font-size: 20px !important
    }
</style>
<div class="display-page">
    <div class="display-shell">
        <div class="kiosk-top">
            <div class="hospital-brand">
                <div class="brand-mark"><?= $this->Html->image('logo_br2.png', ['alt' => 'Logo Rumah Sakit Bhakti Rahayu']) ?></div>
                <div>
                    <h2 class="brand-name">Rumah Sakit Bhakti Rahayu</h2>
                    <div class="brand-subtitle">Display Antrean Rawat Jalan</div>
                </div>
            </div>
            <div class="time-box">
                <div class="date"><?= h($todayLabel) ?></div>
                <div class="clock" id="display-clock">--:--:--</div>
            </div>
        </div>
        <div class="display-card">
            <div class="display-heading">
                <h1 id="display-polyclinic-name"><?= h($polyclinic) ?></h1>
                <p>Daftar antrean pasien hari ini</p>
            </div>
            <div class="display-content">
                <div class="current-panel">
                    <div class="current-label">Nomor Antrian</div>
                    <div class="current-number" id="current-queue-number"><?= h($currentVisit->queue_number ?? '-') ?></div>
                    <div class="current-poli" id="current-poli-name"><?= h($polyclinic) ?></div>
                    <div class="current-detail" id="current-detail">
                        <?= h($currentVisit->patient->full_name ?? 'Belum ada panggilan') ?>
                        <small><?= h($currentVisit->patient->code ?? '-') ?></small>
                    </div>
                </div>
                <div class="display-list-wrap">
                    <table class="display-table">
                        <thead>
                            <tr>
                                <th>No Antri</th>
                                <th>No RM</th>
                                <th>Nama Pasien</th>
                            </tr>
                        </thead>
                        <tbody id="display-rows"><?php if (!$visits->count()): ?><tr>
                                    <td colspan="3" class="empty-row">Belum ada antrean.</td>
                                </tr><?php else: ?><?php foreach ($visits as $visit): ?><tr>
                                    <td class="queue-number"><?= h($visit->queue_number ?? '-') ?></td>
                                    <td><?= h($visit->patient->code ?? '-') ?></td>
                                    <td><?= h($visit->patient->full_name ?? '-') ?></td>
                                </tr><?php endforeach; ?><?php endif; ?></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function() {
        var c = document.getElementById('display-clock');
        var lastAnnouncementKey = null;

        function announce(current, poli) {
            if (!current || !current.called_at) return;
            var key = String(current.queue_number) + '|' + String(current.called_at);
            if (lastAnnouncementKey === null) {
                lastAnnouncementKey = key;
                return;
            }
            if (lastAnnouncementKey === key) return;
            lastAnnouncementKey = key;
            if (!window.speechSynthesis) return;
            window.speechSynthesis.cancel();
            var text = 'Nomor antrean ' + current.queue_number + ', ' + poli + ', silakan menuju ruang pemeriksaan.';
            var utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            utterance.volume = 1;
            window.speechSynthesis.speak(utterance);
        }

        function tick() {
            c.textContent = new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
        tick();
        setInterval(tick, 1000);
        setInterval(function() {
            fetch('<?= h($this->Url->build(['action' => 'display'])) ?>?<?= $deviceCode !== '' ? 'device=' . rawurlencode($deviceCode) : 'poli=' . rawurlencode($polyclinic) ?>&ajax=1').then(function(r) {
                return r.json()
            }).then(function(d) {
                var t = document.getElementById('display-rows');
                document.getElementById('display-polyclinic-name').textContent = d.polyclinic;
                var current = d.current;
                announce(current, d.polyclinic);
                document.getElementById('current-queue-number').textContent = current ? (current.queue_number || '-') : '-';
                document.getElementById('current-poli-name').textContent = d.polyclinic;
                document.getElementById('current-detail').innerHTML = current ?
                    current.patient_name + '<small>' + (current.medical_record_no || '-') + '</small>' :
                    'Belum ada panggilan<small>-</small>';
                t.innerHTML = d.rows.length ? d.rows.map(function(x) {
                    return '<tr><td class="queue-number">' + (x.queue_number || '-') + '</td><td>' + x.medical_record_no + '</td><td>' + x.patient_name + '</td></tr>'
                }).join('') : '<tr><td colspan="3" class="empty-row">Belum ada antrean.</td></tr>';
            });
        }, 3000);
    })();
</script>
