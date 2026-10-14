<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

$result = $result ?? [];
$notifications = $notifications ?? [];
$totalNotifications = $totalNotifications ?? 0;

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
<div class="row">
    <div class="col-xl-6">
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
    </div>
    <div class="col-sm-3">
    <div class="card border-0 text-truncate mb-3 bg-dark text-white">
        <div class="card-body">
            <div class="mb-3 text-grey">
                <b class="mb-3">ABSENSI HARI INI</b>
                <span class="ml-2 f-s-11" id="att-date"><?= h($todayAttendance['date']) ?></span>
            </div>
            <!-- <div class="mb-3">
                <h4 class="text-white mb-0"><?= h($todayAttendance['name']) ?></h4>
            </div> -->

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
    </div>
    <?php endif; ?>

</div>
<div class="row">
    
</div>

<div class="row">

    <div class="col-xl-12">

        <div class="card border-0 mb-3 overflow-hidden bg-dark text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="mb-3 text-grey">
                            <b>TOP 6 ORDER (per-UBS)</b>
                            <?php
                            // <span class="ml-2">
                            // <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Total sales" data-placement="top" data-content="Net sales (gross sales minus discounts and returns) plus taxes and shipping. Includes orders from all sales channels."></i>
                            // </span>
                            ?>
                        </div>

                        <div class="d-flex mb-1">
                            <h2 class="mb-0"><span data-animation="number" data-value="3000">0.00</span></h2>
                            <div class="ml-auto mt-n1 mb-n1"><div id="total-sales-sparkline"></div></div>
                        </div>


                        <div class="mb-3 text-grey">
                            <i class="fa fa-caret-up"></i> <span data-animation="number" data-value="24.61">0.00</span>% compare to last week
                        </div>

                        <hr class="bg-white-transparent-2" />

                        <div class="row text-truncate">
                            <div class="col-2">
                                <div class="f-s-12 text-grey">RSU-TABANAN</div>
                                <div class="f-s-18 m-b-5 f-w-600 p-b-1" data-animation="number" data-value="1200">0</div>
                                <div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
                                    <div class="progress-bar progress-bar-striped rounded-right bg-teal" data-animation="width" data-value="40%" style="width: 0%"></div>
                                    </div>
                            </div>
                            <div class="col-2">
                                <div class="f-s-12 text-grey">RSU-DENPASAR</div>
                                <div class="f-s-18 m-b-5 f-w-600 p-b-1"><span data-animation="number" data-value="860">0.00</span></div>
                                    <div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
                                        <div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="35%" style="width: 0%"></div>
                                    </div>
                            </div>
                            <div class="col-2">
                                <div class="f-s-12 text-grey">MBDU</div>
                                <div class="f-s-18 m-b-5 f-w-600 p-b-1"><span data-animation="number" data-value="300">0.00</span></div>
                                    <div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
                                        <div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="20%" style="width: 0%"></div>
                                    </div>
                            </div>
                            <div class="col-2">
                                <div class="f-s-12 text-grey">CTBL</div>
                                <div class="f-s-18 m-b-5 f-w-600 p-b-1"><span data-animation="number" data-value="240">0.00</span></div>
                                    <div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
                                        <div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="25%" style="width: 0%"></div>
                                    </div>
                            </div>
                            <div class="col-2">
                                <div class="f-s-12 text-grey">UNILAB</div>
                                <div class="f-s-18 m-b-5 f-w-600 p-b-1"><span data-animation="number" data-value="236">0.00</span></div>
                                    <div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
                                        <div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="20%" style="width: 0%"></div>
                                    </div>
                            </div>
                            <div class="col-2">
                                <div class="f-s-12 text-grey">KOPERASI</div>
                                <div class="f-s-18 m-b-5 f-w-600 p-b-1"><span data-animation="number" data-value="149">0.00</span></div>
                                    <div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
                                        <div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="15%" style="width: 0%"></div>
                                    </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-xl-3 col-lg-4 align-items-center d-flex justify-content-center">
                        <?php
                        echo $this->Html->image('/img/svg/img-1.svg', array('alt' => 'logo', 'border' => 0, 'height'=>'150px', 'class'=>'d-none d-lg-block', 'fullBase' => true)); 
                        ?>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<div class="row">
    <div class="col-xl-7">
        <div class="widget-chart with-sidebar inverse-mode">
            <div class="widget-chart-content bg-dark">
                <h4 class="chart-title">
                    Visitors Analytics
                    <small>Where do our visitors come from</small>
                </h4>
                <div id="visitors-line-chart" class="widget-chart-full-width nvd3-inverse-mode" style="height: 260px;"></div>
            </div>
            <div class="widget-chart-sidebar bg-dark-darker">
                <div class="chart-number">
                    1,225,729
                    <small>Total visitors</small>
                </div>
                <div class="flex-grow-1 d-flex align-items-center">
                    <div id="visitors-donut-chart" class="nvd3-inverse-mode" style="height: 180px"></div>
                </div>
                <ul class="chart-legend f-s-11">
                    <li><i class="fa fa-circle fa-fw text-blue f-s-9 m-r-5 t-minus-1"></i> 34.0% <span>New Visitors</span></li>
                    <li><i class="fa fa-circle fa-fw text-teal f-s-9 m-r-5 t-minus-1"></i> 56.0% <span>Return Visitors</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 text-truncate mb-2 bg-dark text-white">
                    <div class="card-body">
                        <div class="mb-2 text-grey"><b>TOP 5 SUPPLIER (Permintaan Barang)</b>
                        <?php
                        //<span class="ml-2"><i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Top products with units sold" data-placement="top" data-content="Products with the most individual units sold. Includes orders from all sales channels." data-original-title="" title=""></i></span>
                        ?>
                        </div>
                    </div>
                    <div class="card-body p-1">
                        <div style="height: 280px">
                            <div id="nv-donut-chart" class="height-sm nvd3-inverse-mode"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end panel -->
    </div>
</div>

<div class="row">
</div>
<div class="row">
    <div class="col-xl-7 col-lg-6">

        <div class="card border-0 mb-3 bg-dark text-white">
            <div class="card-body">
                <div class="mb-3 text-grey"><b>POINT TRANSACTION</b>
                <?php
                //<span class="ml-2"><i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Top products with units sold" data-placement="top" data-content="Products with the most individual units sold. Includes orders from all sales channels." data-original-title="" title=""></i></span>
                ?>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-4">
                        <h3 class="mb-1"><span data-animation="number" data-value="127.1">0</span>K</h3>
                        <div>RIBJKN</div>
                        <div class="text-grey f-s-11 text-truncate"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="25.5">0.00</span>% from previous 7 days</div>
                    </div>
                    <div class="col-xl-2 col-4">
                        <h3 class="mb-1"><span data-animation="number" data-value="179.9">0</span>K</h3>
                        <div>RIBUM</div>
                        <div class="text-grey f-s-11 text-truncate"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="5.33">0.00</span>% from previous 7 days</div>
                    </div>
                    <div class="col-xl-2 col-4">
                        <h3 class="mb-1"><span data-animation="number" data-value="568">0</span>K</h3>
                        <div>RINBJKN</div>
                        <div class="text-grey f-s-11 text-truncate"><i class="fa fa-caret-down"></i> <span data-animation="number" data-value="3.95">0.00</span>% from previous 7 days</div>
                    </div>
                    <div class="col-xl-2 col-4">
                        <h3 class="mb-1"><span data-animation="number" data-value="228">0</span>K</h3>
                        <div>RINBUM</div>
                        <div class="text-grey f-s-11 text-truncate"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="7.91">0.00</span>% from previous 7 days</div>
                    </div>
                    <div class="col-xl-2 col-4">
                        <h3 class="mb-1"><span data-animation="number" data-value="426">0</span>K</h3>
                        <div>RJJKN</div>
                        <div class="text-grey f-s-11 text-truncate"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="8.24">0.00</span>% from previous 7 days</div>
                    </div>
                    <div class="col-xl-2 col-4">
                        <h3 class="mb-1"><span data-animation="number" data-value="118">0</span>K</h3>
                        <div>RJUM</div>
                        <div class="text-grey f-s-11 text-truncate"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="14.3">0.00</span>% from previous 7 days</div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div style="height: 269px">
                    <div id="transaction-line-chart" class="widget-chart-full-width nvd3-inverse-mode" style="height: 254px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="card border-0 text-truncate mb-3 bg-dark text-white">
                    <div class="card-body">
                        <div class="mb-3 text-grey">
                            <b class="mb-3">TOP 5 OBAT</b>
                            <?php
                            //<span class="ml-2"><i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Conversion Rate" data-placement="top" data-content="Percentage of sessions that resulted in orders from total number of sessions." data-original-title="" title=""></i></span>
                            ?>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <h2 class="text-white mb-0"><span data-animation="number" data-value="100">0.00</span></h2>
                            <div class="ml-auto">
                                <div id="conversion-rate-sparkline"></div>
                            </div>
                        </div>
                        <div class="mb-4 text-grey">
                            <i class="fa fa-caret-down"></i> <span data-animation="number" data-value="0.50">0.00</span>% compare to last month
                        </div>
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-red f-s-8 mr-2"></i>Bronkodilator
                            </div>
                        <div class="d-flex align-items-center ml-auto">
                            <div class="text-grey f-s-11"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="18">0</span>%</div>
                            <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="24">0.00</span></div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-warning f-s-8 mr-2"></i>Antivirus
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-down"></i> <span data-animation="number" data-value="2">0</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="20">0.00</span></div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-lime f-s-8 mr-2"></i>Antasida
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-down"></i> <span data-animation="number" data-value="12">0</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="30">0.00</span></div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-teal f-s-8 mr-2"></i>Antipiretik
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="8">0</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="26">0.00</span></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-blue f-s-8 mr-2"></i>Antihipertensi
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="8">0</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="26">0.00</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card border-0 text-truncate mb-3 bg-dark text-white">
                    <div class="card-body">
                        <div class="mb-3 text-grey">
                            <b class="mb-3">TOP 5 ALKES</b>
                            <?php
                            //<span class="ml-2"><i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Store Sessions" data-placement="top" data-content="Number of sessions on your online store. A session is a period of continuous activity from a visitor." data-original-title="" title=""></i></span>
                            ?>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <h2 class="text-white mb-0"><span data-animation="number" data-value="1200">0</span></h2>
                            <div class="ml-auto">
                                <div id="store-session-sparkline"></div>
                            </div>
                        </div>
                        <div class="mb-4 text-grey">
                            <i class="fa fa-caret-down"></i> <span data-animation="number" data-value="3.50">0.00</span>% compare to last month
                        </div>
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-red f-s-8 mr-2"></i>Inhaler
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="25.7">0.00</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="53210">0</span></div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-warning f-s-8 mr-2"></i>Tensimeter
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="16.0">0.00</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="11959">0</span></div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-lime f-s-8 mr-2"></i>Glucometer
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="7.9">0.00</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="5545">0</span></div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-teal f-s-8 mr-2"></i>Timbangan
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="7.9">0.00</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="5545">0</span></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-circle text-blue f-s-8 mr-2"></i>USG
                            </div>
                            <div class="d-flex align-items-center ml-auto">
                                <div class="text-grey f-s-11"><i class="fa fa-caret-up"></i> <span data-animation="number" data-value="7.9">0.00</span>%</div>
                                <div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="5545">0</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<script type="text/javascript">
$(document).ready(function(){
    function loadAttendance() {
        $.getJSON('<?= $this->Url->build(['action' => 'todayAttendance']) ?>', function (res) {
            $('#att-date').text(res.date);
            $('#att-in').text(res.check_in || '-');
            $('#att-out').text(res.check_out || '-');
        });
    }
    setInterval(loadAttendance, 60000);
    if ($("#visitors-map").length !== 0) {
        var options = {
            map: "world_mill",
            scaleColors: [COLOR_BLACK_LIGHTER, COLOR_BLACK],
            container: $("#visitors-map"),
            normalizeFunction: "linear",
            hoverOpacity: 0.5,
            hoverColor: false,
            zoomOnScroll: false,
            zoomButtons: false,
            markerStyle: { initial: { fill: COLOR_BLACK, stroke: "transparent", r: 3 } },
            regions: [{ attribute: "fill" }],
            regionStyle: { initial: { fill: COLOR_DARK_LIGHTER, "fill-opacity": 1, stroke: "none", "stroke-width": 0.4, "stroke-opacity": 1 }, hover: { "fill-opacity": 0.8 }, selected: { fill: "yellow" } },
            series: { regions: [{ values: { IN: COLOR_TEAL, US: COLOR_BLUE, MN: COLOR_TEAL, RU: COLOR_GREY } }] },
            focusOn: { x: 0.7, y: 0.5, scale: 1 },
            backgroundColor: "transparent",
        };
        if ($("#visitors-map").length !== 0) {
            $("#visitors-map").vectorMap(options);
        }

        /*var color1 = $("#visitors-map").attr("data-color") == "black" ? "black" : "blue";
        var color2 = $("#visitors-map").attr("data-color") == "black" ? "rgba(black-rgb, .5)" : "teal";
        var scaleColor = $("#visitors-map").attr("data-color") ? ["rgba(black-rgb, .5)", "rgba(black-rgb, .75)"] : ["gray600", "dark"];
        var fillColor = $("#visitors-map").attr("data-color") == "black" ? "rgba(black-rgb, .25)" : "gray600";
        fillColor = $("#visitors-map").attr("data-color") == "white" ? "rgba(white-rgb, .25)" : fillColor;
        $("#visitors-map").vectorMap({
            map: "world_mill",
            scaleColors: scaleColor,
            container: $("#visitors-map"),
            normalizeFunction: "linear",
            hoverOpacity: 0.5,
            hoverColor: false,
            zoomOnScroll: false,
            markerStyle: { initial: { fill: "dark", stroke: "transparent", r: 3 } },
            regions: [{ attribute: "fill" }],
            regionStyle: { initial: { fill: fillColor, "fill-opacity": 1, stroke: "none", "stroke-width": 0.4, "stroke-opacity": 1 }, hover: { "fill-opacity": 0.8 }, selected: { fill: "yellow" } },
            series: { regions: [{ values: { IN: color1, US: color2, MN: "grey" } }] },
            focusOn: { x: 0.5, y: 0.5, scale: 1 },
            backgroundColor: "transparent",
        });*/
    }

    handleVisitorsDonutChart();
    function handleVisitorsDonutChart() {
        var visitorDonutChartData = [
            { 'label': 'Return Visitors', 'value' : 784466, 'color': COLOR_BLUE }, 
            { 'label': 'New Visitors', 'value' : 416747, 'color': COLOR_GREEN }
        ];
        var arcRadius = [
            { inner: 0.65, outer: 0.93 },
            { inner: 0.6, outer: 1 }
        ];

        nv.addGraph(function() {
        var donutChart = nv.models.pieChart()
            .x(function(d) { return d.label })
            .y(function(d) { return d.value })
            .margin({'left': 10,'right':  10,'top': 10,'bottom': 10})
            .showLegend(false)
            .donut(true) 
            .growOnHover(false)
            .arcsRadius(arcRadius)
            .donutRatio(0.5);
            
            //donutChart.labelFormat(d3.format(',.0f'));
            
            d3.select('#visitors-donut-chart').append('svg')
                .datum(visitorDonutChartData)
                .transition().duration(3000)
                .call(donutChart);
            
            return donutChart;
        });
    }


    handlePieAndDonutChart();
    function handlePieAndDonutChart() {
        "use strict";

        var pieChartData = [
            { 'label': 'PT. ABC', 'value' : 29, 'color': COLOR_RED }, 
            { 'label': 'PT. DEF', 'value' : 12, 'color': COLOR_ORANGE }, 
            { 'label': 'PT. GHI', 'value' : 32, 'color': COLOR_GREEN }, 
            { 'label': 'PT. JKL', 'value' : 196, 'color': COLOR_AQUA }, 
            { 'label': 'PT. MNJ', 'value' : 17, 'color': COLOR_BLUE }, 
            //{ 'label': 'Six', 'value' : 98, 'color': COLOR_PURPLE }, 
            //{ 'label': 'Seven', 'value' : 13, 'color': COLOR_GREY }, 
            //{ 'label': 'Eight', 'value' : 5, 'color': COLOR_BLACK }
        ];

        nv.addGraph(function() {
            var pieChart = nv.models.pieChart()
            .x(function(d) { return d.label })
            .y(function(d) { return d.value })
            .showLabels(true)
            .labelThreshold(.05);

            d3.select('#nv-pie-chart').append('svg')
            .datum(pieChartData)
            .transition().duration(350)
            .call(pieChart);

            return pieChart;
        });


        nv.addGraph(function() {
            var chart = nv.models.pieChart()
            .x(function(d) { return d.label })
            .y(function(d) { return d.value })
            .showLabels(true)
            .labelThreshold(.05)
            .labelType("percent")
            .donut(true) 
            .donutRatio(0.35);

            d3.select('#nv-donut-chart').append('svg')
            .datum(pieChartData)
            .transition().duration(350)
            .call(chart);

            return chart;
        });
    }

    var handleStoreSessionSparkline = function() {
        var options = {
            chart: {
                type: 'line',
                width: 160,
                height: 28,
                sparkline: {
                    enabled: true
                },
                stacked: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 1,
                    opacityTo: 1,
                    colorStops: [{
                        offset: 0,
                        color: COLOR_TEAL,
                        opacity: 1
                    },
                    {
                        offset: 50,
                        color: COLOR_BLUE,
                        opacity: 1
                    },
                    {
                        offset: 100,
                        color: COLOR_AQUA,
                        opacity: 1
                    }]
                },
            },
            series: [{
                data: [10812, 11393, 7311, 6834, 9612, 11200, 13557]
            }],
            labels: ['Jun 23', 'Jun 24', 'Jun 25', 'Jun 26', 'Jun 27', 'Jun 28', 'Jun 29'],
            xaxis: {
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function (seriesName) {
                            return ''
                        }
                    },
                    formatter: (value) => { return convertNumberWithCommas(value) },
                },
                marker: {
                    show: false
                }
            },
            responsive: [{
                breakpoint: 1500,
                options: {
                    chart: {
                        width: 120
                    }
                }
            },{
                breakpoint: 1300,
                options: {
                    chart: {
                        width: 100
                    }
                }
            },{
                breakpoint: 1200,
                options: {
                    chart: {
                        width: 160
                    }
                }
            },{
                breakpoint: 900,
                options: {
                    chart: {
                        width: 120
                    }
                }
            },{
                breakpoint: 576,
                options: {
                    chart: {
                        width: 180
                    }
                }
            },{
                breakpoint: 400,
                options: {
                    chart: {
                        width: 120
                    }
                }
            }]
        };
        if ($('#store-session-sparkline').length !== 0) {
            new ApexCharts(document.querySelector('#store-session-sparkline'), options).render();
        }
    };



    var handleGetDate = function (minusDate) {
        var d = new Date();
        d = d.setDate(d.getDate() - minusDate);
        return d;
    };
    var visitorAreaChartData = [
        {
            key: "RIBJKN",
            color: COLOR_RED,
            values: [
                [handleGetDate(77), 13],
                [handleGetDate(76), 13],
                [handleGetDate(75), 6],
                [handleGetDate(73), 6],
                [handleGetDate(72), 6],
                [handleGetDate(71), 5],
                [handleGetDate(70), 5],
                [handleGetDate(69), 5],
                [handleGetDate(68), 6],
                [handleGetDate(67), 7],
                [handleGetDate(66), 6],
                [handleGetDate(65), 9],
                [handleGetDate(64), 9],
                [handleGetDate(63), 8],
                [handleGetDate(62), 10],
                [handleGetDate(61), 10],
                [handleGetDate(60), 10],
                [handleGetDate(59), 10],
                [handleGetDate(58), 9],
                [handleGetDate(57), 9],
                [handleGetDate(56), 10],
                [handleGetDate(55), 9],
                [handleGetDate(54), 9],
                [handleGetDate(53), 8],
                [handleGetDate(52), 8],
                [handleGetDate(51), 8],
                [handleGetDate(50), 8],
                [handleGetDate(49), 8],
                [handleGetDate(48), 7],
                [handleGetDate(47), 7],
                [handleGetDate(46), 6],
                [handleGetDate(45), 6],
                [handleGetDate(44), 6],
                [handleGetDate(43), 6],
                [handleGetDate(42), 5],
                [handleGetDate(41), 5],
                [handleGetDate(40), 4],
                [handleGetDate(39), 4],
                [handleGetDate(38), 5],
                [handleGetDate(37), 5],
                [handleGetDate(36), 5],
                [handleGetDate(35), 7],
                [handleGetDate(34), 7],
                [handleGetDate(33), 7],
                [handleGetDate(32), 10],
                [handleGetDate(31), 9],
                [handleGetDate(30), 9],
                [handleGetDate(29), 10],
                [handleGetDate(28), 11],
                [handleGetDate(27), 11],
                [handleGetDate(26), 8],
                [handleGetDate(25), 8],
                [handleGetDate(24), 7],
                [handleGetDate(23), 8],
                [handleGetDate(22), 9],
                [handleGetDate(21), 8],
                [handleGetDate(20), 9],
                [handleGetDate(19), 10],
                [handleGetDate(18), 9],
                [handleGetDate(17), 10],
                [handleGetDate(16), 16],
                [handleGetDate(15), 17],
                [handleGetDate(14), 16],
                [handleGetDate(13), 17],
                [handleGetDate(12), 16],
                [handleGetDate(11), 15],
                [handleGetDate(10), 14],
                [handleGetDate(9), 24],
                [handleGetDate(8), 18],
                [handleGetDate(7), 15],
                [handleGetDate(6), 14],
                [handleGetDate(5), 16],
                [handleGetDate(4), 16],
                [handleGetDate(3), 17],
                [handleGetDate(2), 7],
                [handleGetDate(1), 7],
                [handleGetDate(0), 7],
            ],
        },
        {
            key: "RIBUM",
            color: COLOR_YELLOW,
            values: [
                [handleGetDate(77), 14],
                [handleGetDate(76), 13],
                [handleGetDate(75), 15],
                [handleGetDate(73), 14],
                [handleGetDate(72), 13],
                [handleGetDate(71), 15],
                [handleGetDate(70), 16],
                [handleGetDate(69), 16],
                [handleGetDate(68), 14],
                [handleGetDate(67), 14],
                [handleGetDate(66), 13],
                [handleGetDate(65), 12],
                [handleGetDate(64), 13],
                [handleGetDate(63), 13],
                [handleGetDate(62), 15],
                [handleGetDate(61), 16],
                [handleGetDate(60), 16],
                [handleGetDate(59), 17],
                [handleGetDate(58), 17],
                [handleGetDate(57), 18],
                [handleGetDate(56), 15],
                [handleGetDate(55), 15],
                [handleGetDate(54), 15],
                [handleGetDate(53), 19],
                [handleGetDate(52), 19],
                [handleGetDate(51), 18],
                [handleGetDate(50), 18],
                [handleGetDate(49), 17],
                [handleGetDate(48), 16],
                [handleGetDate(47), 18],
                [handleGetDate(46), 18],
                [handleGetDate(45), 18],
                [handleGetDate(44), 16],
                [handleGetDate(43), 14],
                [handleGetDate(42), 14],
                [handleGetDate(41), 13],
                [handleGetDate(40), 14],
                [handleGetDate(39), 13],
                [handleGetDate(38), 10],
                [handleGetDate(37), 9],
                [handleGetDate(36), 10],
                [handleGetDate(35), 11],
                [handleGetDate(34), 11],
                [handleGetDate(33), 11],
                [handleGetDate(32), 10],
                [handleGetDate(31), 9],
                [handleGetDate(30), 10],
                [handleGetDate(29), 13],
                [handleGetDate(28), 14],
                [handleGetDate(27), 14],
                [handleGetDate(26), 13],
                [handleGetDate(25), 12],
                [handleGetDate(24), 11],
                [handleGetDate(23), 13],
                [handleGetDate(22), 13],
                [handleGetDate(21), 13],
                [handleGetDate(20), 13],
                [handleGetDate(19), 14],
                [handleGetDate(18), 13],
                [handleGetDate(17), 13],
                [handleGetDate(16), 19],
                [handleGetDate(15), 21],
                [handleGetDate(14), 22],
                [handleGetDate(13), 25],
                [handleGetDate(12), 24],
                [handleGetDate(11), 24],
                [handleGetDate(10), 22],
                [handleGetDate(9), 16],
                [handleGetDate(8), 15],
                [handleGetDate(7), 12],
                [handleGetDate(6), 12],
                [handleGetDate(5), 15],
                [handleGetDate(4), 15],
                [handleGetDate(3), 15],
                [handleGetDate(2), 18],
                [handleGetDate(2), 18],
                [handleGetDate(0), 17],
            ],
        },
        {
            key: "RINBJKN",
            color: COLOR_LIME,
            values: [
                [handleGetDate(77), 18],
                [handleGetDate(76), 11],
                [handleGetDate(75), 15],
                [handleGetDate(73), 18],
                [handleGetDate(72), 11],
                [handleGetDate(71), 15],
                [handleGetDate(70), 9],
                [handleGetDate(69), 9],
                [handleGetDate(68), 18],
                [handleGetDate(67), 18],
                [handleGetDate(66), 11],
                [handleGetDate(65), 12],
                [handleGetDate(64), 11],
                [handleGetDate(63), 11],
                [handleGetDate(62), 15],
                [handleGetDate(61), 9],
                [handleGetDate(60), 9],
                [handleGetDate(59), 17],
                [handleGetDate(58), 17],
                [handleGetDate(57), 18],
                [handleGetDate(56), 15],
                [handleGetDate(55), 15],
                [handleGetDate(54), 15],
                [handleGetDate(53), 19],
                [handleGetDate(52), 19],
                [handleGetDate(51), 18],
                [handleGetDate(50), 18],
                [handleGetDate(49), 17],
                [handleGetDate(48), 9],
                [handleGetDate(47), 18],
                [handleGetDate(46), 18],
                [handleGetDate(45), 18],
                [handleGetDate(44), 9],
                [handleGetDate(43), 14],
                [handleGetDate(42), 14],
                [handleGetDate(41), 11],
                [handleGetDate(40), 14],
                [handleGetDate(39), 11],
                [handleGetDate(38), 10],
                [handleGetDate(37), 9],
                [handleGetDate(36), 10],
                [handleGetDate(35), 11],
                [handleGetDate(34), 11],
                [handleGetDate(33), 11],
                [handleGetDate(32), 10],
                [handleGetDate(31), 9],
                [handleGetDate(30), 10],
                [handleGetDate(29), 11],
                [handleGetDate(28), 14],
                [handleGetDate(27), 14],
                [handleGetDate(26), 11],
                [handleGetDate(25), 12],
                [handleGetDate(24), 11],
                [handleGetDate(23), 11],
                [handleGetDate(22), 11],
                [handleGetDate(21), 11],
                [handleGetDate(20), 11],
                [handleGetDate(19), 14],
                [handleGetDate(18), 11],
                [handleGetDate(17), 11],
                [handleGetDate(16), 19],
                [handleGetDate(15), 21],
                [handleGetDate(14), 22],
                [handleGetDate(13), 25],
                [handleGetDate(12), 24],
                [handleGetDate(11), 24],
                [handleGetDate(10), 22],
                [handleGetDate(9), 16],
                [handleGetDate(8), 15],
                [handleGetDate(7), 12],
                [handleGetDate(6), 12],
                [handleGetDate(5), 15],
                [handleGetDate(4), 15],
                [handleGetDate(3), 15],
                [handleGetDate(2), 18],
                [handleGetDate(2), 18],
                [handleGetDate(0), 17],
            ],
        },
        {
            key: "RINBUM",
            color: COLOR_TEAL,
            values: [
                [handleGetDate(77), 18],
                [handleGetDate(76), 11],
                [handleGetDate(75), 15],
                [handleGetDate(73), 18],
                [handleGetDate(72), 11],
                [handleGetDate(71), 15],
                [handleGetDate(70), 9],
                [handleGetDate(69), 9],
                [handleGetDate(68), 18],
                [handleGetDate(67), 18],
                [handleGetDate(66), 11],
                [handleGetDate(65), 12],
                [handleGetDate(64), 11],
                [handleGetDate(63), 11],
                [handleGetDate(62), 15],
                [handleGetDate(61), 9],
                [handleGetDate(60), 9],
                [handleGetDate(59), 17],
                [handleGetDate(58), 17],
                [handleGetDate(57), 18],
                [handleGetDate(56), 15],
                [handleGetDate(55), 15],
                [handleGetDate(54), 15],
                [handleGetDate(53), 19],
                [handleGetDate(52), 19],
                [handleGetDate(51), 18],
                [handleGetDate(50), 18],
                [handleGetDate(49), 17],
                [handleGetDate(48), 9],
                [handleGetDate(47), 18],
                [handleGetDate(46), 18],
                [handleGetDate(45), 18],
                [handleGetDate(44), 9],
                [handleGetDate(43), 14],
                [handleGetDate(42), 14],
                [handleGetDate(41), 11],
                [handleGetDate(40), 14],
                [handleGetDate(39), 11],
                [handleGetDate(38), 10],
                [handleGetDate(37), 9],
                [handleGetDate(36), 10],
                [handleGetDate(35), 11],
                [handleGetDate(34), 11],
                [handleGetDate(33), 11],
                [handleGetDate(32), 10],
                [handleGetDate(31), 9],
                [handleGetDate(30), 10],
                [handleGetDate(29), 11],
                [handleGetDate(28), 14],
                [handleGetDate(27), 14],
                [handleGetDate(26), 11],
                [handleGetDate(25), 12],
                [handleGetDate(24), 11],
                [handleGetDate(23), 11],
                [handleGetDate(22), 11],
                [handleGetDate(21), 11],
                [handleGetDate(20), 11],
                [handleGetDate(19), 14],
                [handleGetDate(18), 11],
                [handleGetDate(17), 11],
                [handleGetDate(16), 19],
                [handleGetDate(15), 21],
                [handleGetDate(14), 22],
                [handleGetDate(13), 25],
                [handleGetDate(12), 24],
                [handleGetDate(11), 24],
                [handleGetDate(10), 22],
                [handleGetDate(9), 16],
                [handleGetDate(8), 15],
                [handleGetDate(7), 12],
                [handleGetDate(6), 12],
                [handleGetDate(5), 15],
                [handleGetDate(4), 15],
                [handleGetDate(3), 15],
                [handleGetDate(2), 18],
                [handleGetDate(2), 18],
                [handleGetDate(0), 17],
            ],
        },
        {
            key: "RJJKN",
            color: COLOR_BLUE,
            values: [
                [handleGetDate(77), 18],
                [handleGetDate(76), 11],
                [handleGetDate(75), 15],
                [handleGetDate(73), 18],
                [handleGetDate(72), 11],
                [handleGetDate(71), 15],
                [handleGetDate(70), 9],
                [handleGetDate(69), 9],
                [handleGetDate(68), 18],
                [handleGetDate(67), 18],
                [handleGetDate(66), 11],
                [handleGetDate(65), 12],
                [handleGetDate(64), 11],
                [handleGetDate(63), 11],
                [handleGetDate(62), 15],
                [handleGetDate(61), 9],
                [handleGetDate(60), 9],
                [handleGetDate(59), 17],
                [handleGetDate(58), 17],
                [handleGetDate(57), 18],
                [handleGetDate(56), 15],
                [handleGetDate(55), 15],
                [handleGetDate(54), 15],
                [handleGetDate(53), 19],
                [handleGetDate(52), 19],
                [handleGetDate(51), 18],
                [handleGetDate(50), 18],
                [handleGetDate(49), 17],
                [handleGetDate(48), 9],
                [handleGetDate(47), 18],
                [handleGetDate(46), 18],
                [handleGetDate(45), 18],
                [handleGetDate(44), 9],
                [handleGetDate(43), 14],
                [handleGetDate(42), 14],
                [handleGetDate(41), 11],
                [handleGetDate(40), 14],
                [handleGetDate(39), 11],
                [handleGetDate(38), 10],
                [handleGetDate(37), 9],
                [handleGetDate(36), 10],
                [handleGetDate(35), 11],
                [handleGetDate(34), 11],
                [handleGetDate(33), 29],
                [handleGetDate(32), 10],
                [handleGetDate(31), 9],
                [handleGetDate(30), 10],
                [handleGetDate(29), 11],
                [handleGetDate(28), 14],
                [handleGetDate(27), 14],
                [handleGetDate(26), 11],
                [handleGetDate(25), 12],
                [handleGetDate(24), 11],
                [handleGetDate(23), 11],
                [handleGetDate(22), 11],
                [handleGetDate(21), 11],
                [handleGetDate(20), 11],
                [handleGetDate(19), 14],
                [handleGetDate(18), 11],
                [handleGetDate(17), 11],
                [handleGetDate(16), 19],
                [handleGetDate(15), 21],
                [handleGetDate(14), 22],
                [handleGetDate(13), 25],
                [handleGetDate(12), 18],
                [handleGetDate(11), 8],
                [handleGetDate(10), 7],
                [handleGetDate(9), 16],
                [handleGetDate(8), 15],
                [handleGetDate(7), 12],
                [handleGetDate(6), 12],
                [handleGetDate(5), 12],
                [handleGetDate(4), 22],
                [handleGetDate(3), 15],
                [handleGetDate(2), 10],
                [handleGetDate(2), 12],
                [handleGetDate(0), 3],
            ],
        },
        {
            key: "RJUM",
            color: COLOR_AQUA,
            values: [
                [handleGetDate(77), 18],
                [handleGetDate(76), 11],
                [handleGetDate(75), 15],
                [handleGetDate(73), 18],
                [handleGetDate(72), 11],
                [handleGetDate(71), 15],
                [handleGetDate(70), 9],
                [handleGetDate(69), 9],
                [handleGetDate(68), 18],
                [handleGetDate(67), 18],
                [handleGetDate(66), 11],
                [handleGetDate(65), 12],
                [handleGetDate(64), 11],
                [handleGetDate(63), 11],
                [handleGetDate(62), 15],
                [handleGetDate(61), 9],
                [handleGetDate(60), 9],
                [handleGetDate(59), 17],
                [handleGetDate(58), 17],
                [handleGetDate(57), 18],
                [handleGetDate(56), 15],
                [handleGetDate(55), 15],
                [handleGetDate(54), 15],
                [handleGetDate(53), 19],
                [handleGetDate(52), 19],
                [handleGetDate(51), 18],
                [handleGetDate(50), 18],
                [handleGetDate(49), 17],
                [handleGetDate(48), 9],
                [handleGetDate(47), 18],
                [handleGetDate(46), 18],
                [handleGetDate(45), 18],
                [handleGetDate(44), 9],
                [handleGetDate(43), 14],
                [handleGetDate(42), 14],
                [handleGetDate(41), 11],
                [handleGetDate(40), 14],
                [handleGetDate(39), 11],
                [handleGetDate(38), 10],
                [handleGetDate(37), 9],
                [handleGetDate(36), 10],
                [handleGetDate(35), 11],
                [handleGetDate(34), 11],
                [handleGetDate(33), 11],
                [handleGetDate(32), 10],
                [handleGetDate(31), 9],
                [handleGetDate(30), 10],
                [handleGetDate(29), 11],
                [handleGetDate(28), 14],
                [handleGetDate(27), 14],
                [handleGetDate(26), 11],
                [handleGetDate(25), 12],
                [handleGetDate(24), 11],
                [handleGetDate(23), 11],
                [handleGetDate(22), 11],
                [handleGetDate(21), 11],
                [handleGetDate(20), 11],
                [handleGetDate(19), 14],
                [handleGetDate(18), 11],
                [handleGetDate(17), 11],
                [handleGetDate(16), 19],
                [handleGetDate(15), 21],
                [handleGetDate(14), 22],
                [handleGetDate(13), 25],
                [handleGetDate(12), 24],
                [handleGetDate(11), 24],
                [handleGetDate(10), 22],
                [handleGetDate(9), 16],
                [handleGetDate(8), 15],
                [handleGetDate(7), 12],
                [handleGetDate(6), 12],
                [handleGetDate(5), 15],
                [handleGetDate(4), 15],
                [handleGetDate(3), 15],
                [handleGetDate(2), 18],
                [handleGetDate(2), 18],
                [handleGetDate(0), 17],
            ],
        },
    ];
    if ($("#visitors-line-chart").length !== 0) {
        nv.addGraph(function () {
            var stackedAreaChart = nv.models
                .stackedAreaChart()
                .useInteractiveGuideline(true)
                .x(function (d) {
                    return d[0];
                })
                .y(function (d) {
                    return d[1];
                })
                .pointSize(0.5)
                .margin({ left: 35, right: 25, top: 20, bottom: 20 })
                .controlLabels({ stacked: "Stacked" })
                .showControls(false)
                .duration(300);
            stackedAreaChart.xAxis.tickFormat(function (d) {
                var monthsName = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                d = new Date(d);
                d = monthsName[d.getMonth()] + " " + d.getDate();
                return d;
            });
            stackedAreaChart.yAxis.tickFormat(d3.format(",.0f"));
            d3.select("#visitors-line-chart")
                .append("svg")
                .datum(visitorAreaChartData)
                .transition()
                .duration(1000)
                .call(stackedAreaChart)
                .each("start", function () {
                    setTimeout(function () {
                        d3.selectAll("#visitors-line-chart *").each(function () {
                            if (this.__transition__) this.__transition__.duration = 1;
                        });
                    }, 0);
                });
            nv.utils.windowResize(stackedAreaChart.update);
            return stackedAreaChart;
        });
    }


    if ($("#transaction-line-chart").length !== 0) {
        nv.addGraph(function () {
            var stackedAreaChart = nv.models
                .stackedAreaChart()
                .useInteractiveGuideline(true)
                .x(function (d) {
                    return d[0];
                })
                .y(function (d) {
                    return d[1];
                })
                .pointSize(0.5)
                .margin({ left: 35, right: 25, top: 20, bottom: 20 })
                .controlLabels({ stacked: "Stacked" })
                .showControls(false)
                .duration(300);
            stackedAreaChart.xAxis.tickFormat(function (d) {
                var monthsName = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                d = new Date(d);
                d = monthsName[d.getMonth()] + " " + d.getDate();
                return d;
            });
            stackedAreaChart.yAxis.tickFormat(d3.format(",.0f"));
            d3.select("#transaction-line-chart")
                .append("svg")
                .datum(visitorAreaChartData)
                .transition()
                .duration(1000)
                .call(stackedAreaChart)
                .each("start", function () {
                    setTimeout(function () {
                        d3.selectAll("#transaction-line-chart *").each(function () {
                            if (this.__transition__) this.__transition__.duration = 1;
                        });
                    }, 0);
                });
            nv.utils.windowResize(stackedAreaChart.update);
            return stackedAreaChart;
        });
    }
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
