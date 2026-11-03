<?php $this->assign('title', 'Kiosk Antrean');
$todayLabel = date('d F Y'); ?>
<script>
    document.body.classList.add('kiosk-mode');
</script>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        overflow: hidden
    }

    body {
        background: #eef8fa;
        font-family: Arial, sans-serif
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
    .kiosk-mode #page-container.page-sidebar-minified,
    .kiosk-mode #page-container.page-sidebar-fixed,
    .kiosk-mode #page-container.page-header-fixed,
    .kiosk-mode #content.content {
        width: 100% !important;
        height: 100vh !important;
        min-height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        padding-left: 0 !important;
        left: 0 !important;
        position: static !important;
        overflow: hidden !important
    }

    .kiosk-new {
        height: 100vh;
        overflow: hidden;
        padding: 10px 22px;
        box-sizing: border-box;
        background: #eef8fa
    }

    .kiosk-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1100px;
        margin: 0 auto 8px
    }

    .hospital-brand {
        display: flex;
        align-items: center;
        gap: 12px
    }

    .brand-mark {
        width: 46px;
        height: 46px;
        padding: 7px;
        box-sizing: border-box;
        border-radius: 12px;
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
        color: #102a43;
        font-size: 22px
    }

    .brand-subtitle {
        color: #52667a;
        font-size: 13px;
        margin-top: 2px
    }

    .time-box {
        padding: 7px 14px;
        border: 1px solid #d5e1ea;
        border-radius: 12px;
        background: #fff;
        text-align: right
    }

    .time-box .date {
        color: #52667a;
        font-size: 11px
    }

    .time-box .clock {
        color: #102a43;
        font-size: 19px;
        font-weight: bold
    }

    .kiosk-panel {
        width: min(820px, 100%);
        margin: 20px auto 0;
        padding: 28px 34px;
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 16px 45px #1d405022;
        text-align: center
    }

    .kiosk-panel h1 {
        margin: 0 0 5px;
        color: #102a43;
        font-size: 30px
    }

    .kiosk-panel p {
        margin: 0 0 20px;
        color: #52667a;
        font-size: 16px
    }

    .kiosk-buttons {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px
    }

    .kiosk-button {
        min-height: 145px;
        border: 0;
        border-radius: 18px;
        color: #fff;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        font-weight: 800;
        box-shadow: 0 10px 20px #153b5c2e
    }

    .kiosk-button small {
        margin-top: 7px;
        font-size: 16px;
        font-weight: 600;
        opacity: .9
    }

    .mjkn {
        background: #147d92
    }

    .onsite {
        background: #1769aa
    }

    .morning {
        background: #15966c
    }

    .afternoon {
        background: #d77b22
    }

    .queue-modal {
        position: fixed;
        inset: 0;
        background: #122033cc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px
    }

    .queue-card {
        background: #fff;
        border-radius: 24px;
        padding: 38px;
        text-align: center;
        min-width: min(500px, 90vw)
    }

    .queue-code {
        font-size: 84px;
        font-weight: 900;
        color: #1769aa;
        margin: 18px
    }

    .finish {
        border: 0;
        border-radius: 12px;
        background: #102a43;
        color: #fff;
        padding: 14px 36px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer
    }

    @media(max-width:600px) {
        .kiosk-new {
            padding: 8px
        }

        .kiosk-top {
            align-items: flex-start
        }

        .brand-name {
            font-size: 17px
        }

        .brand-subtitle {
            font-size: 11px
        }

        .brand-mark {
            width: 40px;
            height: 40px
        }

        .time-box {
            padding: 5px 8px
        }

        .time-box .clock {
            font-size: 15px
        }

        .kiosk-panel {
            margin-top: 14px;
            padding: 20px 14px
        }

        .kiosk-panel h1 {
            font-size: 25px
        }

        .kiosk-buttons {
            gap: 10px
        }

        .kiosk-button {
            min-height: 120px;
            font-size: 19px
        }

        .kiosk-button small {
            font-size: 13px
        }
    }

    <style>

    /* Warna tombol berdasarkan sumber antrean: MJKN satu warna, ONSITE satu warna. */
    .kiosk-button.mjkn,
    .kiosk-button.mjkn.morning,
    .kiosk-button.mjkn.afternoon {
        background: #147d92 !important;
    }

    .kiosk-button.onsite,
    .kiosk-button.onsite.morning,
    .kiosk-button.onsite.afternoon {
        background: #1769aa !important;
    }
</style>
</style>
<div class="kiosk-new">
    <div class="kiosk-top">
        <div class="hospital-brand">
            <div class="brand-mark"><?= $this->Html->image('logo_br2.png', ['alt' => 'Logo Rumah Sakit Bhakti Rahayu']) ?></div>
            <div>
                <h1 class="brand-name">Rumah Sakit Bhakti Rahayu</h1>
                <div class="brand-subtitle">Mesin Antrian Loket SIMRS</div>
            </div>
        </div>
        <div class="time-box">
            <div class="date"><?= h($todayLabel) ?></div>
            <div class="clock" id="kiosk-clock">--:--:--</div>
        </div>
    </div>
    <div class="kiosk-panel">
        <h1>Ambil Nomor Antrean</h1>
        <p>Pilih jenis antrean dan sesi kunjungan</p><?= $this->Flash->render() ?><?= $this->Form->create(null, ['id' => 'kiosk-new-form']) ?><input type="hidden" name="queue_source" id="queue-source"><input type="hidden" name="queue_session" id="queue-session">
        <div class="kiosk-buttons"><button class="kiosk-button mjkn morning" type="button" data-source="MJKN" data-session="morning"> <i class="fas fa-mobile-alt"></i> MJKN Pagi<small>Antrean pagi</small></button><button class="kiosk-button mjkn afternoon" type="button" data-source="MJKN" data-session="afternoon"> <i class="fas fa-mobile-alt"></i> MJKN Sore<small>Antrean sore</small></button><button class="kiosk-button onsite morning" type="button" data-source="ONSITE" data-session="morning"> <i class="fas fa-hospital"></i> ONSITE Pagi<small>Antrean pagi</small></button><button class="kiosk-button onsite afternoon" type="button" data-source="ONSITE" data-session="afternoon"> <i class="fas fa-hospital"></i> ONSITE Sore<small>Antrean sore</small></button></div><?= $this->Form->end() ?>
    </div>
</div>
<?php if (!empty($queueCode)): ?><div class="queue-modal">
        <div class="queue-card">
            <h2>Nomor Antrean Anda</h2>
            <div class="queue-code"><?= h($queueCode) ?></div>
            <p>Silakan menunggu panggilan petugas.</p><button class="finish" type="button" onclick="window.location.href='<?= h($this->Url->build(['action' => 'kioskNew'])) ?>'">Selesai</button>
        </div>
    </div><?php endif; ?>
<script>
    (function() {
        var f = document.getElementById('kiosk-new-form'),
            c = document.getElementById('kiosk-clock');

        function tick() {
            c.textContent = new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
        document.querySelectorAll('.kiosk-button').forEach(function(b) {
            b.onclick = function() {
                document.getElementById('queue-source').value = b.dataset.source;
                document.getElementById('queue-session').value = b.dataset.session;
                f.submit();
            };
        });
        tick();
        setInterval(tick, 1000);
    })();
</script>
<style>
    .kiosk-button.mjkn,
    .kiosk-button.mjkn.morning,
    .kiosk-button.mjkn.afternoon {
        background: #147d92 !important
    }

    .kiosk-button.onsite,
    .kiosk-button.onsite.morning,
    .kiosk-button.onsite.afternoon {
        background: #d77b22 !important
    }
</style>
<script>
    (function() {
        document.querySelectorAll('.kiosk-button[data-session="morning"]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                var now = new Date();
                var minutes = now.getHours() * 60 + now.getMinutes();
                if (minutes > (14 * 60)) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Waktu Sudah Terlewat',
                            text: 'Waktu antrean pagi sudah terlewat. Silakan pilih antrean sore.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#d77b22'
                        });
                    } else {
                        alert('Waktu antrean pagi sudah terlewat. Silakan pilih antrean sore.');
                    }
                    return false;
                }
            }, true);
        });
    }());
</script>
<style>
    html:has(body.kiosk-mode),
    body.kiosk-mode {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        min-width: 100% !important;
    }

    body.kiosk-mode #page-container,
    body.kiosk-mode #page-container.page-sidebar-minified,
    body.kiosk-mode #page-container.page-sidebar-fixed,
    body.kiosk-mode #page-container.page-header-fixed,
    body.kiosk-mode #content,
    body.kiosk-mode #content.content {
        margin-left: 0 !important;
        padding-left: 0 !important;
        border-left: 0 !important;
    }

    body.kiosk-mode #page-container,
    body.kiosk-mode #content,
    body.kiosk-mode #content.content {
        transform: none !important;
        filter: none !important;
    }

    body.kiosk-mode #sidebar,
    body.kiosk-mode #sidebar-bg,
    body.kiosk-mode .sidebar-bg,
    body.kiosk-mode .page-sidebar,
    body.kiosk-mode .page-sidebar-bg,
    body.kiosk-mode .page-sidebar-minify-btn {
        display: none !important;
        width: 0 !important;
        min-width: 0 !important;
    }

    body.kiosk-mode .kiosk-new {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        z-index: 1050 !important;
        width: 100vw !important;
        height: 100vh !important;
        max-width: none !important;
        margin: 0 !important;
    }

    body.kiosk-mode .queue-modal {
        z-index: 1060 !important;
    }
</style>