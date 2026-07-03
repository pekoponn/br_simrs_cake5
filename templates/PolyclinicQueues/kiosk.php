<!-- templates/PolyclinicQueues/kiosk.php -->
<?php
$polyclinics = $polyclinicButtonData ?? [];
$selectedPoly = $this->request->getData('poly_name') ?? 'Poli Umum';
$todayLabel = date('d F Y');
?>

<script>
    document.body.classList.add('kiosk-mode');
</script>

<style>
    .kiosk-mode #header,
    .kiosk-mode .header,
    .kiosk-mode #sidebar,
    .kiosk-mode #sidebar-bg,
    .kiosk-mode .sidebar-bg,
    .kiosk-mode .sidebar,
    .kiosk-mode .page-sidebar,
    .kiosk-mode .page-sidebar-minify-btn,
    .kiosk-mode .page-sidebar-minified #sidebar,
    .kiosk-mode #footer,
    .kiosk-mode .footer,
    .kiosk-mode .btn-scroll-to-top {
        display: none !important;
    }

    html:has(body.kiosk-mode),
    body.kiosk-mode {
        width: 100% !important;
        height: 100vh !important;
        min-height: 100vh !important;
        overflow: hidden !important;
        background: #edf3f7 !important;
    }

    .kiosk-mode #page-container {
        position: static !important;
        width: 100% !important;
        height: 100vh !important;
        min-height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        background: #edf3f7 !important;
    }

    .kiosk-mode #page-container.page-sidebar-minified,
    .kiosk-mode #page-container.page-sidebar-fixed,
    .kiosk-mode #page-container.page-header-fixed {
        padding-left: 0 !important;
        padding-top: 0 !important;
    }

    .kiosk-mode #content.content {
        position: static !important;
        left: 0 !important;
        right: auto !important;
        top: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        height: 100vh !important;
        min-height: 100vh;
        overflow: hidden !important;
        background: #edf3f7;
    }

    .kiosk-page,
    .kiosk-page * {
        box-sizing: border-box;
    }

    .kiosk-page {
        height: 100vh;
        min-height: 100vh;
        overflow: hidden;
        padding: 10px 18px;
        color: #172033;
        background:
            linear-gradient(135deg, rgba(232, 245, 241, 0.96), rgba(236, 243, 252, 0.96)),
            radial-gradient(circle at 10% 10%, rgba(15, 118, 110, 0.12), transparent 34%),
            radial-gradient(circle at 90% 0%, rgba(29, 78, 216, 0.13), transparent 30%);
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .kiosk-shell {
        width: 100%;
        max-width: 1180px;
        height: 100%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .kiosk-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 8px;
    }

    .hospital-brand {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .brand-mark {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #fff;
        border: 1px solid #d8e3ec;
        padding: 8px;
        box-shadow: 0 12px 24px rgba(15, 118, 110, 0.20);
    }

    .brand-mark img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .brand-name {
        margin: 0;
        font-size: 19px;
        font-weight: 800;
        line-height: 1.2;
        color: #112136;
        letter-spacing: 0;
    }

    .brand-subtitle {
        margin-top: 2px;
        color: #667085;
        font-size: 12px;
        font-weight: 600;
    }

    .time-box {
        min-width: 170px;
        padding: 7px 12px;
        border: 1px solid #d8e3ec;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.82);
        text-align: right;
    }

    .time-box .date {
        color: #667085;
        font-size: 11px;
        font-weight: 700;
    }

    .time-box .clock {
        margin-top: 2px;
        color: #112136;
        font-size: 19px;
        font-weight: 800;
        line-height: 1.1;
    }

    .kiosk-card {
        overflow: hidden;
        border: 1px solid rgba(214, 226, 236, 0.92);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 18px 42px rgba(31, 45, 61, 0.12);
        flex: 0 1 auto;
    }

    .kiosk-card-header {
        padding: 14px 22px 12px;
        border-bottom: 1px solid #e8eef4;
        background: linear-gradient(90deg, #ffffff, #f8fbfc);
    }

    .kiosk-title {
        margin: 0;
        color: #112136;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: 0;
    }

    .kiosk-description {
        margin: 4px 0 0;
        color: #5f6f82;
        font-size: 13px;
        line-height: 1.3;
    }

    .kiosk-card-body {
        padding: 12px 22px 14px;
    }

    .section-label {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        color: #112136;
        font-size: 15px;
        font-weight: 800;
    }

    .section-label i {
        color: #0f766e;
    }

    .poli-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
    }

    .poli-card {
        min-height: 66px;
        width: 100%;
        padding: 9px 11px;
        border: 2px solid #dce6ef;
        border-radius: 12px;
        background: #fff;
        color: #172033;
        text-align: left;
        cursor: pointer;
        transition: border-color 0.16s ease, box-shadow 0.16s ease, transform 0.16s ease, background 0.16s ease;
    }

    .poli-card:hover,
    .poli-card:focus {
        border-color: #0f766e;
        box-shadow: 0 10px 22px rgba(15, 118, 110, 0.12);
        outline: none;
        transform: translateY(-1px);
    }

    .poli-card.is-active {
        border-color: #0f766e;
        background: #ecfdf7;
        box-shadow: 0 12px 28px rgba(15, 118, 110, 0.16);
    }

    .poli-card.is-featured {
        grid-column: span 2;
        min-height: 66px;
        border-color: #bfe4d8;
        background: linear-gradient(135deg, #ecfdf7, #ffffff);
    }

    .poli-card-name {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.15;
    }

    .poli-card-doctor {
        display: block;
        margin-top: 4px;
        color: #344054;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.15;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .poli-card-name i {
        display: none;
        color: #0f766e;
        font-size: 18px;
    }

    .poli-card.is-active .poli-card-name i {
        display: inline-block;
    }

    .poli-card-help {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 5px;
        padding: 3px 7px;
        border-radius: 999px;
        background: #f2f7fb;
        color: #667085;
        font-size: 11px;
        font-weight: 800;
    }

    .kiosk-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e8eef4;
    }

    .help-text {
        max-width: 420px;
        color: #667085;
        font-size: 12px;
        line-height: 1.3;
    }

    .help-text i {
        margin-right: 7px;
        color: #1d4ed8;
    }

    .queue-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-queue {
        min-width: 190px;
        height: 48px;
        padding: 0 22px;
        border: 0;
        border-radius: 12px;
        background: #149966;
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        box-shadow: 0 16px 28px rgba(20, 153, 102, 0.24);
        cursor: pointer;
        transition: background 0.16s ease, opacity 0.16s ease, transform 0.16s ease;
    }

    .btn-queue:hover,
    .btn-queue:focus {
        background: #0f8557;
        outline: none;
    }

    .btn-queue-afternoon {
        background: #1d4ed8;
        box-shadow: 0 16px 28px rgba(29, 78, 216, 0.22);
    }

    .btn-queue-afternoon:hover,
    .btn-queue-afternoon:focus {
        background: #1e40af;
    }

    .btn-queue:disabled {
        background: #a8b5c2;
        box-shadow: none;
        cursor: not-allowed;
        opacity: 0.78;
    }

    .queue-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(17, 24, 39, 0.70);
    }

    .queue-modal-card {
        width: min(620px, 100%);
        padding: 36px;
        border-radius: 24px;
        background: #fff;
        text-align: center;
        box-shadow: 0 24px 70px rgba(0, 0, 0, 0.28);
    }

    .queue-modal-icon {
        width: 72px;
        height: 72px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        border-radius: 20px;
        background: #ecfdf7;
        color: #0f766e;
        font-size: 34px;
    }

    .queue-modal-title {
        margin: 0;
        color: #112136;
        font-size: 30px;
        font-weight: 800;
    }

    .queue-modal-code {
        margin: 18px 0 20px;
        color: #1d4ed8;
        font-size: 86px;
        font-weight: 900;
        line-height: 1;
    }

    .queue-modal-label {
        margin: 0 0 6px;
        color: #667085;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .queue-modal-poli {
        margin: 0 0 18px;
        color: #112136;
        font-size: 24px;
        font-weight: 800;
    }

    .queue-modal-note {
        margin: 0;
        color: #667085;
        font-size: 20px;
        line-height: 1.45;
    }

    .btn-finish {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 190px;
        height: 58px;
        margin-top: 28px;
        border-radius: 14px;
        background: #172033;
        color: #fff;
        font-size: 18px;
        font-weight: 800;
        text-decoration: none;
    }

    .btn-finish:hover,
    .btn-finish:focus {
        color: #fff;
        background: #0f172a;
        text-decoration: none;
    }

    @media (max-width: 1200px) {
        .poli-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        body.kiosk-mode,
        .kiosk-mode #page-container,
        .kiosk-mode #content.content,
        .kiosk-page {
            height: auto !important;
            min-height: 100vh !important;
            overflow: auto !important;
        }

        .kiosk-page {
            padding: 18px;
        }

        .kiosk-top {
            align-items: flex-start;
            flex-direction: column;
        }

        .time-box {
            width: 100%;
            text-align: left;
        }

        .kiosk-card-header,
        .kiosk-card-body {
            padding-left: 22px;
            padding-right: 22px;
        }

        .kiosk-title {
            font-size: 28px;
        }

        .poli-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .poli-card.is-featured {
            grid-column: span 2;
        }

        .kiosk-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .btn-queue {
            width: 100%;
            min-width: 0;
        }

        .queue-buttons {
            flex-direction: column;
            width: 100%;
        }
    }

    @media (max-width: 575px) {
        .kiosk-page {
            padding: 12px;
        }

        .brand-mark {
            width: 50px;
            height: 50px;
        }

        .brand-name {
            font-size: 20px;
        }

        .kiosk-title {
            font-size: 24px;
        }

        .kiosk-description {
            font-size: 16px;
        }

        .poli-grid {
            grid-template-columns: 1fr;
        }

        .poli-card.is-featured {
            grid-column: span 1;
        }

        .poli-card-name {
            font-size: 18px;
        }

        .queue-modal-code {
            font-size: 64px;
        }
    }
</style>

<div class="kiosk-page">
    <div class="kiosk-shell">
        <div class="kiosk-top">
            <div class="hospital-brand">
                <div class="brand-mark">
                    <?= $this->Html->image('logo_br.png', ['alt' => 'Logo Rumah Sakit Bhakti Rahayu']) ?>
                </div>
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

        <div class="kiosk-card">
            <div class="kiosk-card-header">
                <h2 class="kiosk-title">Ambil Nomor Antrian</h2>
                <p class="kiosk-description">Pilih poli tujuan lalu tekan tombol antrian sesuai sesi kunjungan.</p>
            </div>

            <div class="kiosk-card-body">
                <?= $this->Flash->render() ?>

                <?= $this->Form->create(null, ['id' => 'kiosk-queue-form']) ?>
                    <input type="hidden" name="poly_name" id="selected-poly" value="<?= h($selectedPoly) ?>">

                    <div class="section-label">
                        <i class="fa fa-clinic-medical"></i>
                        Pilih Poli Tujuan
                    </div>

                    <div class="poli-grid" role="listbox" aria-label="Pilihan poli tujuan">
                        <?php foreach ($polyclinics as $poly): ?>
                            <?php
                            $polyValue = (string)$poly['value'];
                            $polyLabel = (string)$poly['label'];
                            $doctorName = (string)$poly['doctor'];
                            $queueTotal = (int)$poly['total'];
                            $isFeatured = !empty($poly['is_featured']);
                            $isActive = $selectedPoly !== '' && $selectedPoly === $polyValue;
                            ?>
                            <button
                                type="button"
                                class="poli-card<?= $isActive ? ' is-active' : '' ?><?= $isFeatured ? ' is-featured' : '' ?>"
                                data-poly-value="<?= h($polyValue) ?>"
                                aria-pressed="<?= $isActive ? 'true' : 'false' ?>">
                                <span class="poli-card-name">
                                    <?= h($polyLabel) ?>
                                    <i class="fa fa-check-circle"></i>
                                </span>
                                <span class="poli-card-doctor"><?= h($doctorName) ?></span>
                                <span class="poli-card-help">
                                    <i class="fa fa-users"></i>
                                    Total Antrian: <?= h($queueTotal) ?>
                                </span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <div class="kiosk-actions">
                        <div class="help-text">
                            <i class="fa fa-info-circle"></i>
                            Jika mengalami kesulitan, hubungi petugas loket.
                        </div>

                        <div class="queue-buttons">
                            <?= $this->Form->button('Antrian Pagi (A)', [
                                'class' => 'btn-queue',
                                'name' => 'queue_session',
                                'value' => 'morning',
                                'disabled' => $selectedPoly === '',
                            ]) ?>

                            <?= $this->Form->button('Antrian Sore (B)', [
                                'class' => 'btn-queue btn-queue-afternoon',
                                'name' => 'queue_session',
                                'value' => 'afternoon',
                                'disabled' => $selectedPoly === '',
                            ]) ?>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <?php if (!empty($queueNumber)): ?>
        <div class="queue-modal" role="dialog" aria-modal="true" aria-labelledby="queue-modal-title">
            <div class="queue-modal-card">
                <div class="queue-modal-icon">
                    <i class="fa fa-ticket-alt"></i>
                </div>
                <h2 class="queue-modal-title" id="queue-modal-title">Nomor Antrian Anda</h2>
                <div class="queue-modal-code"><?= h($queueCode) ?></div>
                <div class="queue-modal-label">Tujuan Poli</div>
                <div class="queue-modal-poli"><?= h($this->request->getData('poly_name')) ?></div>
                <?php if (!empty($queueVisitDate)): ?>
                    <div class="queue-modal-label">Tanggal Kunjungan</div>
                    <div class="queue-modal-poli"><?= h(date('d-m-Y', strtotime((string)$queueVisitDate))) ?></div>
                <?php endif; ?>
                <p class="queue-modal-note">Silakan menunggu panggilan petugas.</p>
                <button type="button" class="btn-finish" id="btn-finish-queue">Selesai</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    (function() {
        var selectedPolyInput = document.getElementById('selected-poly');
        var submitButtons = document.querySelectorAll('.btn-queue');
        var poliCards = document.querySelectorAll('.poli-card');
        var clock = document.getElementById('kiosk-clock');
        var queueModal = document.querySelector('.queue-modal');
        var finishButton = document.getElementById('btn-finish-queue');

        function updateClock() {
            if (!clock) {
                return;
            }

            var now = new Date();
            clock.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        function selectPoly(card) {
            poliCards.forEach(function(item) {
                item.classList.remove('is-active');
                item.setAttribute('aria-pressed', 'false');
            });

            card.classList.add('is-active');
            card.setAttribute('aria-pressed', 'true');
            selectedPolyInput.value = card.getAttribute('data-poly-value') || '';
            setSubmitButtonsDisabled(selectedPolyInput.value === '');
        }

        function setSubmitButtonsDisabled(isDisabled) {
            submitButtons.forEach(function(button) {
                button.disabled = isDisabled;
            });
        }

        function resetSelection() {
            var defaultCard = document.querySelector('.poli-card[data-poly-value="Poli Umum"]');

            poliCards.forEach(function(item) {
                item.classList.remove('is-active');
                item.setAttribute('aria-pressed', 'false');
            });

            if (defaultCard) {
                defaultCard.classList.add('is-active');
                defaultCard.setAttribute('aria-pressed', 'true');
                selectedPolyInput.value = 'Poli Umum';
                setSubmitButtonsDisabled(false);
                return;
            }

            selectedPolyInput.value = '';
            setSubmitButtonsDisabled(true);
        }

        function closeQueueModal() {
            if (queueModal) {
                queueModal.remove();
            }

            resetSelection();

            if (window.history.replaceState) {
                window.history.replaceState(null, '', "<?= $this->Url->build(['action' => 'kiosk']) ?>");
            }
        }

        poliCards.forEach(function(card) {
            card.addEventListener('click', function() {
                selectPoly(card);
            });
        });

        updateClock();
        setInterval(updateClock, 1000);

        if (finishButton) {
            finishButton.addEventListener('click', closeQueueModal);
        }

        if (queueModal) {
            setTimeout(closeQueueModal, 10000);
        }
    })();
</script>
