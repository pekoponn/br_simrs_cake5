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

    .summary-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 14px;
    }

    .summary-item {
        padding: 12px;
        border-radius: 12px;
        background: #fff;
        border: 1px solid #dde6ef;
        box-shadow: 0 3px 12px rgba(31,45,61,.06);
    }

    .summary-item small {
        display: block;
        color: #6b7280;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .summary-item strong {
        display: block;
        margin-top: 4px;
        font-size: 28px;
        line-height: 1;
        font-weight: 900;
    }

    .summary-item.rooms strong { color: #2563eb; }
    .summary-item.beds strong { color: #7c3aed; }
    .summary-item.free strong { color: #059669; }
    .summary-item.used strong { color: #dc2626; }

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

    .class-header span {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        font-size: 11px;
        font-weight: 800;
    }

    .room-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .room-table th {
        padding: 9px 8px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        color: #475569;
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        text-align: left;
    }

    .room-table td {
        padding: 9px 8px;
        border-bottom: 1px solid #eef2f7;
        vertical-align: top;
        font-size: 12px;
    }

    .room-table tr:last-child td {
        border-bottom: none;
    }

    .room-name {
        color: #111827;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.2;
    }

    .room-code {
        display: block;
        margin-top: 2px;
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
    }

    .bed-count {
        font-weight: 900;
        white-space: nowrap;
    }

    .bed-count.free { color: #059669; }
    .bed-count.used { color: #dc2626; }

    .bed-row {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        max-width: 100%;
    }

    .bed-chip {
        min-width: 48px;
        padding: 5px 6px;
        border-radius: 7px;
        border: 1px solid #dbe5ef;
        background: #f8fafc;
        text-align: center;
        font-size: 10px;
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
        font-size: 12px;
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
        .summary-strip {
            grid-template-columns: repeat(2, 1fr);
        }

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

    <div class="summary-strip">
        <div class="summary-item rooms">
            <small>Total Ruangan</small>
            <strong><?= h($summary['rooms'] ?? 0) ?></strong>
        </div>
        <div class="summary-item beds">
            <small>Total Bed</small>
            <strong><?= h($summary['beds'] ?? 0) ?></strong>
        </div>
        <div class="summary-item free">
            <small>Bed Kosong</small>
            <strong><?= h($summary['free'] ?? 0) ?></strong>
        </div>
        <div class="summary-item used">
            <small>Bed Terisi</small>
            <strong><?= h($summary['used'] ?? 0) ?></strong>
        </div>
    </div>

    <?php if (!empty($roomGroups)): ?>
        <div class="class-grid">
            <?php foreach ($roomGroups as $className => $group): ?>
                <?php
                    $rooms = $group['rooms'] ?? [];
                    $totalBeds = (int)($group['beds'] ?? 0);
                    $usedBeds = (int)($group['used'] ?? 0);
                    $freeBeds = (int)($group['free'] ?? 0);
                ?>

                <div class="class-panel">
                    <div class="class-header">
                        <h3>Kelas <?= h($className ?: 'Tanpa Kelas') ?></h3>
                        <div>
                            <span><?= count($rooms) ?> Ruang</span>
                            <span><?= $freeBeds ?> Kosong</span>
                            <span><?= $usedBeds ?> Terisi</span>
                        </div>
                    </div>

                    <table class="room-table">
                        <thead>
                            <tr>
                                <th width="34%">Ruangan</th>
                                <th width="12%">Lt</th>
                                <th width="18%">Bed</th>
                                <th>Display Bed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rooms as $room): ?>
                                <?php
                                    $beds = $room->beds ?? [];
                                    $bedCount = 0;
                                    $bedUsed = 0;
                                    $bedFree = 0;

                                    foreach ($beds as $bed) {
                                        $bedCount++;
                                        if ((int)($bed->status ?? 0) === 1) {
                                            $bedUsed++;
                                        } else {
                                            $bedFree++;
                                        }
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <div class="room-name"><?= h($room->room_name ?? '-') ?></div>
                                        <span class="room-code"><?= h($room->room_code ?? '-') ?></span>
                                    </td>
                                    <td><?= h($room->floor ?? '-') ?></td>
                                    <td>
                                        <span class="bed-count free"><?= $bedFree ?> kosong</span><br>
                                        <span class="bed-count used"><?= $bedUsed ?> terisi</span>
                                    </td>
                                    <td>
                                        <?php if ($bedCount > 0): ?>
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
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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