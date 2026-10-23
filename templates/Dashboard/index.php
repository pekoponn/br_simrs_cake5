<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

$result = $result ?? [];
$notifications = $notifications ?? [];
$totalNotifications = $totalNotifications ?? 0;
$todaySummary = $todaySummary ?? [];
$todayPresence = $todayPresence ?? ['total' => 0, 'present' => 0, 'absent' => 0];
$presenceTotal = max(1, (int)$todayPresence['total']);

$labels = [];
$totalUsers = [];
$absensi = [];
$izin = [];
$cuti = [];

foreach ($result as $ubs => $data) {
    $labels[] = $ubs;
    $totalUsers[] = (int) ($data['total_users'] ?? 0);
    $absensi[] = (int) ($data['total_absent_today'] ?? 0);
    $izin[] = (int) ($data['total_izin'] ?? 0);
    $cuti[] = (int) ($data['total_cuti'] ?? 0);
}

$chartData = array_chunk(array_map(function ($label, $totalUser, $absen, $izinVal, $cutiVal) {return ['label' => $label, 'total_users' => $totalUser, 'absensi' => $absen, 'izin' => $izinVal, 'cuti' => $cutiVal];}, $labels, $totalUsers, $absensi, $izin, $cuti), 5);
?>
<style>
    .chart-container {
        position: relative;
        width: 100%;
        overflow-x: auto;
        background: #1a1a2e;
        border-radius: 10px;
        padding: 15px;
    }
    
    /* Font lebih besar untuk orang tua */
    .apexcharts-text,
    .apexcharts-legend-text {
        font-size: 12px !important;
        font-weight: bold !important;
    }
    
    /* Tooltip lebih besar */
    .apexcharts-tooltip {
        font-size: 14px !important;
    }

    #absensiChart {
        background: #1f2937;
        border-radius: 10px;
        padding: 12px 8px 0;
    }

    .dashboard-notif-item {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        margin-bottom: 10px;
        transition: all 0.2s ease;
    }

    .dashboard-notif-item:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
    }

    #attendance-donut-chart {
        height: 190px;
        margin: -10px 0 5px;
    }

    /* Samakan tinggi kartu pada baris dashboard pertama agar kartu
       Kehadiran Hari Ini memanjang sampai batas bawah baris. */
    .dashboard-top-row {
        align-items: stretch;
    }

    .dashboard-top-row > [class*="col-"] {
        display: flex;
        flex-direction: column;
    }

    .dashboard-top-row > [class*="col-"] > .card {
        width: 100%;
    }

    .dashboard-top-row > .dashboard-presence-col > .card {
        flex: 1 1 auto;
    }

    .dashboard-presence-col > .card > .card-body {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .dashboard-presence-col #attendance-donut-chart {
        margin-top: 28px;
    }

    .dashboard-presence-col #attendance-donut-chart + .d-flex {
        margin-top: auto;
    }
</style>
<h1 class="page-header mb-3">Dashboard</h1>
<?php //$this->Krs->breadcrumb('', ''); ?>

<?php
/*
<div class="panel panel-inverse">
    <div class="panel-body">
*/
?>
<!-- <div class="row">
    <div class="col-xl-4">
        <div class="card border-0 mb-3 overflow-hidden bg-dark text-white">
            <div class="card-body">
                <div class="mb-3">
                    <h3>Absensi Hari Ini</h3>
                    <p class="text-muted">
                        Tanggal: <?= date('d-m-Y') ?>
                    </p>
                </div>
                <?php $result = $result ?? []; ?>
                <?php foreach ($result as $ubs => $data): ?>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center align-middle mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>UBS</th>
                                                <th>Total User</th>
                                                <th>Absensi</th>
                                                <th>Ijin</th>
                                                <th>Cuti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-start"><?= h($ubs) ?></td>
                                                <td><?= $data['total_users'] ?></td>
                                                <td><?= $data['total_absent_today'] ?></td>
                                                <td><?= $data['total_izin'] ?? 0 ?></td>
                                                <td><?= $data['total_cuti'] ?? 0 ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div> -->
<div class="row dashboard-top-row">
    <div class="col-lg-3">
        <div class="card border-0 mb-3 overflow-hidden bg-dark text-white">
            <div class="card-body">
                <h3><i class="fab fa-telegram-plane text-info"></i> Telegram</h3>
                <?php if(empty($telegramChatId)): ?>
                    <p class="text-warning">Belum terhubung ke Telegram.</p>
                    <a href="<?= h($telegramLink) ?>" target="_blank" rel="noopener" class="btn btn-info">Hubungkan Telegram</a>
                <?php else: ?>
                    <p class="text-success">
                        <i class="fa fa-check-circle"></i>
                        Akun Telegram sudah terhubung.
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="card border-0 text-truncate mb-3 bg-dark text-white">
            <div class="card-body">
                <div class="mb-3 text-grey">
                    <b class="mb-3">ABSENSI HARI INI</b>
                    <span class="ml-2 f-s-11" id="att-date"><?= h($todayAttendance['date']) ?></span>
                </div>
                <div id="att-list" style="max-height:230px; overflow-y:auto;">
                    <?php if (empty($todayAttendance['logs'])): ?>
                        <div class="text-grey">Belum ada absen hari ini.</div>
                    <?php else: ?>
                        <?php foreach ($todayAttendance['logs'] as $log): ?>
                            <div class="d-flex mb-2">
                                <div class="d-flex align-items-center" style="flex:1">
                                    <i class="fa fa-circle <?= $log['type'] === 'I' ? 'text-lime' : 'text-red' ?> f-s-8 mr-2"></i><?= h($log['mode']) ?>
                                </div>
                                <div class="f-w-600"><?= h($log['time']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 dashboard-presence-col">
        <div class="card border-0 text-truncate mb-3 bg-dark text-white">
            <div class="card-body">
                <div class="mb-3 text-grey"><b>KEHADIRAN HARI INI</b></div>
                <div id="attendance-donut-chart" class="nvd3-inverse-mode"></div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fa fa-circle text-teal f-s-8 mr-2"></i>Hadir</span>
                    <strong><?= (int)$todayPresence['present'] ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span><i class="fa fa-circle text-secondary f-s-8 mr-2"></i>Tidak hadir</span>
                    <strong><?= (int)$todayPresence['absent'] ?></strong>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($workOrderNotifications)): ?>
    <div class="col-xl-6">
        <div class="card border-0 mb-3 overflow-hidden bg-dark text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5><i class="fa fa-briefcase"></i> Surat Tugas Aktif</h5>
                    </div>
                </div>

                <?php foreach ($workOrderNotifications as $workOrder): ?>
                    <a href="<?= $this->Url->build(['prefix' => 'Hr', 'controller' => 'Overtimes', 'action' => 'index', $workOrder['id']]) ?>"
                       class="dashboard-notif-item d-flex align-items-center justify-content-between text-white text-decoration-none p-3">
                        <div>
                            <div class="f-w-600">Anda memiliki tugas surat perintah lembur dengan nomor
                        <strong><?= h($workOrder->code) ?></strong></div>
                            <small class="text-muted">Klik untuk buka lembur tugas</small>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="card border-0 text-truncate mb-3 bg-dark text-white">
            <div class="card-body">
                <div class="mb-3 text-grey"><b class="mb-3 text-white">ABSENSI HARI INI </b><b><?= h(date('d-m-Y')) ?></b></div>
                <h2 class="text-white mb-0"><span data-animation="number" data-value="<?= (int)($todaySummary['late'] ?? 0) ?>">0</span></h2>
                <div class="text-grey mb-3">Terlambat absen hari ini</div>
                <?php $summaryRows = [
                    ['Cuti', 'text-red', 'cuti'],
                    ['Tidak Masuk', 'text-warning', 'izin_tidak_masuk'],
                    ['Izin Terlambat', 'text-lime', 'izin_terlambat'],
                    ['Pulang Cepat', 'text-teal', 'pulang_cepat'],
                ]; ?>
                <?php foreach ($summaryRows as [$label, $color, $key]): ?>
                    <div class="d-flex mb-2">
                        <div class="d-flex align-items-center" style="flex:1"><i class="fa fa-circle <?= h($color) ?> f-s-8 mr-2"></i><?= h($label) ?></div>
                        <div class="width-50 text-right pl-2 f-w-600"><?= (int)($todaySummary[$key] ?? 0) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<div class="row">
    <?php if ($hasApprovalAccess && !empty($notifications)): ?>
    <div class="col-xl-6">
        <div class="card border-0 mb-3 overflow-hidden bg-dark text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h3 class="mb-1">Notifikasi Approval</h3>
                        <p class="text-muted mb-0">Pengajuan tim yang menunggu knowing/approve</p>
                    </div>
                    <span class="badge badge-warning px-2 py-1" style="font-size: 14px;">
                        <?= (int)$totalNotifications ?>
                    </span>
                </div>

                <?php foreach ($notifications as $notification): ?>
                    <a href="<?= $this->Url->build($notification['route']) ?>"
                       class="dashboard-notif-item d-flex align-items-center justify-content-between text-white text-decoration-none p-3">
                        <div>
                            <div class="f-w-600"><?= h($notification['title']) ?></div>
                            <small class="text-muted">Klik untuk buka daftar pengajuan</small>
                        </div>
                        <span class="badge badge-info px-2 py-1" style="font-size: 14px;">
                            <?= (int)$notification['count'] ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<script type="text/javascript">
    // Donut interaktif: hover menampilkan label dan jumlah kehadiran.
    function initAttendanceDonut() {
      if (typeof nv !== 'undefined' && $('#attendance-donut-chart').length && !$('#attendance-donut-chart svg').length) {
        nv.addGraph(function () {
            var attendanceChart = nv.models.pieChart()
                .x(function (d) { return d.label; })
                .y(function (d) { return d.value; })
                .showLabels(true)
                .labelType('percent')
                .labelThreshold(0.01)
                .donut(true)
                .donutRatio(0.45)
                .color(['#00acac', '#6c757d']);

            d3.select('#attendance-donut-chart').append('svg')
                .datum([
                    { label: 'Hadir', value: <?= (int)$todayPresence['present'] ?> },
                    { label: 'Tidak hadir', value: <?= (int)$todayPresence['absent'] ?> }
                ])
                .transition().duration(350)
                .call(attendanceChart);
            nv.utils.windowResize(attendanceChart.update);
            return attendanceChart;
        });
      }
    }
    // NVD3 dimuat dari layout; tunggu sampai seluruh asset selesai dimuat.
    $(window).on('load', initAttendanceDonut);
    $(function () { setTimeout(initAttendanceDonut, 0); });

$(document).ready(function(){
    function loadAttendance() {
        $.getJSON('<?= $this->Url->build(['action' => 'todayAttendance']) ?>', function (res) {
            $('#att-date').text(res.date);
            $('#att-in').text(res.check_in || '-');
            $('#att-out').text(res.check_out || '-');
        });
    }
    setInterval(loadAttendance, 60000);
    <?php 
    /*
    var fillColor = $("#visitors-map").attr("data-theme") ? "rgba(" + app.color.componentColorRgb + ", .25)" : app.color.gray700;
    var options = {
        map: "world_mill",
        scaleColors: [app.color.black, app.color.black],
        container: $("#visitors-map"),
        normalizeFunction: "linear",
        hoverOpacity: 0.5,
        hoverColor: false,
        zoomOnScroll: false,
        zoomButtons: false,
        markerStyle: { initial: { fill: app.color.black, stroke: "transparent", r: 3 } },
        regions: [{ attribute: "fill" }],
        regionStyle: { initial: { fill: fillColor, "fill-opacity": 1, stroke: "none", "stroke-width": 0.4, "stroke-opacity": 1 }, hover: { "fill-opacity": 0.8 }, selected: { fill: "yellow" } },
        series: { regions: [{ values: { IN: app.color.teal, US: app.color.teal, MN: app.color.teal, RU: app.color.teal } }] },
        focusOn: { x: 0.7, y: 0.5, scale: 1 },
        backgroundColor: "transparent",
    };
    if ($("#visitors-map").length !== 0) {
        $("#visitors-map").vectorMap(options);
    }
    */
    ?>
    const labels = <?= json_encode($labels, JSON_UNESCAPED_UNICODE) ?>;
    const totalUsersData = <?= json_encode($totalUsers, JSON_NUMERIC_CHECK) ?>;
    const absensiData = <?= json_encode($absensi, JSON_NUMERIC_CHECK) ?>;
    const izinData = <?= json_encode($izin, JSON_NUMERIC_CHECK) ?>;
    const cutiData = <?= json_encode($cuti, JSON_NUMERIC_CHECK) ?>;
    const chartChunks = <?= json_encode($chartData, JSON_UNESCAPED_UNICODE) ?>;

    if (typeof ApexCharts !== 'undefined') {
        // new ApexCharts(document.querySelector("#absensiChart"), {
        //     chart: {
        //         type: 'bar',
        //         height: 400,
        //         background: 'transparent',
        //         toolbar: { show: false },
        //         foreColor: '#fff'
        //     },

        //     theme: {
        //         mode: 'light',
        //     },
            
        //     series: [
        //         { name: 'Total User', data: totalUsersData, color: '#F6F3C2' },
        //         { name: 'Absensi', data: absensiData, color: '#B5BAFF' },
        //         { name: 'Izin', data: izinData, color: '#CBF3BB' },
        //         { name: 'Cuti', data: cutiData, color: '#FF8F8F' },
        //     ],
            
        //     xaxis: {
        //         categories: labels,
        //         labels: { style: { fontSize: '12px', colors: '#FFF' } }
        //     },
            
        //     yaxis: {
        //         labels: { style: { fontSize: '12px', colors: '#FFF' } }
        //     },
            
        //     plotOptions: {
        //         bar: {
        //             horizontal: false,
        //             columnWidth: '55%',
        //             borderRadius: 4
        //         }
        //     },
            
        //     dataLabels: {
        //         enabled: true,
        //         offsetY: -10,
        //         style: { fontSize: '12px', colors: ['#FFF'] }
        //     },
            
        //     legend: {
        //         position: 'top',
        //         labels: { colors: '#FFF' }
        //     },

        //     grid: {
        //         show: true,
        //         borderColor: 'rgba(255,255,255,0.18)',
        //         strokeDashArray: 4,
        //         xaxis: {
        //             lines: {
        //                 show: true
        //             }
        //         },
        //         yaxis: {
        //             lines: {
        //                 show: true
        //             }
        //         }
        //     },
            
        //     tooltip: { theme: 'dark' }
        // }).render();
        chartChunks.forEach((chunk, index) => {

            const labels = chunk.map(x => x.label);
            const totalUsersData = chunk.map(x => x.total_users);
            const absensiData = chunk.map(x => x.absensi);
            const izinData = chunk.map(x => x.izin);
            const cutiData = chunk.map(x => x.cuti);
            new ApexCharts(document.querySelector("#absensiChart" + index), {
                chart: {
                    type: 'bar',
                    height: 400,
                    background: 'transparent',
                    toolbar: { show: false },
                    foreColor: '#fff'
                },
                theme: {
                    mode: 'light'
                },
                series: [
                    { name: 'Total User', data: totalUsersData, color: '#F6F3C2' },
                    { name: 'Absensi', data: absensiData, color: '#B5BAFF' },
                    { name: 'Izin', data: izinData, color: '#CBF3BB' },
                    { name: 'Cuti', data: cutiData, color: '#FF8F8F' }
                ],
                xaxis: {
                    categories: labels,
                    labels: {
                        style: {
                            fontSize: '12px',
                            colors: '#FFF'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '12px',
                            colors: '#FFF'
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -10,
                    style: {
                        fontSize: '12px',
                        colors: ['#FFF']
                    }
                },
                legend: {
                    position: 'top',
                    labels: {
                        colors: '#FFF'
                    }
                },
                grid: {
                    show: true,
                    borderColor: 'rgba(255,255,255,0.18)',
                    strokeDashArray: 4
                },
                tooltip: {
                    theme: 'dark'
                }
            }).render();

        });
    }

});
</script>
