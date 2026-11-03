<?php
/**
 * @var \App\View\AppView $this
 * @var array $roomGroups
 * @var array $summary
 * @var string|null $selectedClass
 * @var array $roomClasses
 */
?>

<style>
    html, body {
        background: #eef2f7 !important;
    }

    .bed-monitor {
        width: 100%;
        min-height: 100vh;
        padding: 16px;
        background: #eef2f7;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .monitor-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        padding: 14px 16px;
        background: #fff;
        border: 1px solid #dde6ef;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(31,45,61,.06);
    }

    .monitor-title {
        margin: 0;
        color: #1f2937;
        font-size: 22px;
        font-weight: 800;
    }

    .monitor-subtitle {
        margin-top: 3px;
        color: #6b7280;
        font-size: 12px;
        font-weight: 600;
    }

    .monitor-clock {
        min-width: 130px;
        padding: 8px 12px;
        border-radius: 10px;
        background: #111827;
        color: #fff;
        text-align: center;
        font-size: 18px;
        font-weight: 900;
    }

    .class-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(390px, 1fr));
        gap: 14px;
        align-items: start;
    }

    .class-panel {
        background: #fff;
        border: 1px solid #dde6ef;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(31,45,61,.06);
    }

    .class-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        padding: 12px 14px;
        background: #1f2937;
        color: #fff;
    }

    .class-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 900;
    }

    .room-list {
        display: flex;
        flex-direction: column;
    }

    .room-item {
        padding: 14px;
    }

    .bed-row {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        max-width: 100%;
    }

    .bed-chip {
        min-width: 52px;
        padding: 6px 8px;
        border-radius: 7px;
        border: 1px solid #dbe5ef;
        background: #f8fafc;
        text-align: center;
        font-size: 11px;
        font-weight: 900;
        line-height: 1.1;
    }

    .bed-chip.free {
        background: #ecfdf5;
        border-color: #a7f3d0;
        color: #047857;
    }

    .bed-chip.used {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #be123c;
    }

    .bed-chip i {
        display: block;
        margin-bottom: 2px;
        font-size: 13px;
    }

    .empty-bed {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 800;
    }

    .empty-data {
        padding: 35px 20px;
        border-radius: 12px;
        background: #fff;
        border: 1px dashed #cbd5e1;
        color: #64748b;
        font-weight: 800;
        text-align: center;
    }

    @media (max-width: 900px) {
        .class-grid {
            grid-template-columns: 1fr;
        }

        .monitor-topbar {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="bed-monitor">
    <div class="monitor-topbar">
        <div>
            <h2 class="monitor-title"><i class="fa fa-bed"></i> Monitoring Ruangan & Bed</h2>
            <div class="monitor-subtitle">Data ketersediaan bed per kelas ruangan</div>
        </div>
        <div class="monitor-clock" id="monitor-clock">--:--:--</div>
    </div>

    <?php
        // Ratakan semua ruangan dari semua kelas jadi satu daftar,
        // karena panel sekarang dikelompokkan per ruangan, bukan per kelas.
        $allRooms = [];
        if (!empty($roomGroups)) {
            foreach ($roomGroups as $group) {
                foreach (($group['rooms'] ?? []) as $room) {
                    $allRooms[] = $room;
                }
            }
        }
    ?>

    <?php if (!empty($allRooms)): ?>
        <div class="class-grid">
            <?php foreach ($allRooms as $room): ?>
                <?php $beds = $room->beds ?? []; ?>

                <div class="class-panel">
                    <div class="class-header">
                        <h3><?= h($room->room_name ?? '-') ?></h3>
                    </div>

                    <div class="room-list">
                        <div class="room-item">
                            <?php if (!empty($beds)): ?>
                                <div class="bed-row">
                                    <?php foreach ($beds as $bed): ?>
                                        <?php
                                            $isUsed = (int)($bed->status ?? 0) === 1;
                                            $bedClass = $isUsed ? 'used' : 'free';
                                        ?>
                                        <div class="bed-chip <?= $bedClass ?>" title="<?= $isUsed ? 'Terisi' : 'Kosong' ?>">
                                            <i class="fa fa-bed"></i>
                                            <?= h($bed->name ?? ($bed->bed_no ?? '-')) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <span class="empty-bed">Belum ada bed</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-data">
            <i class="fa fa-info-circle"></i> Data ruangan belum tersedia.
        </div>
    <?php endif; ?>
</div>

<script>
(function () {
    function pad(value) {
        return value < 10 ? '0' + value : String(value);
    }

    function updateClock() {
        var now = new Date();
        var clock = document.getElementById('monitor-clock');
        if (clock) {
            clock.textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
        }
    }

    updateClock();
    setInterval(updateClock, 1000);
})();
</script>