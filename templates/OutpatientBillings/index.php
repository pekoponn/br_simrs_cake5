<?php
$statusMap = [
    'draft' => ['label' => 'Draft', 'class' => 'default'],
    'waiting_payment' => ['label' => 'Menunggu Bayar', 'class' => 'warning'],
    'paid' => ['label' => 'Lunas', 'class' => 'success'],
    'cancelled' => ['label' => 'Batal', 'class' => 'danger'],
    'void' => ['label' => 'Void', 'class' => 'danger'],
];

function formatKasirDate($value, $format = 'd-m-Y H:i')
{
    if (empty($value)) {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format($format);
    }

    $time = strtotime((string)$value);
    return $time ? date($format, $time) : '-';
}

function formatKasirDateTime($dateValue, $timeValue = null, $format = 'd-m-Y H:i')
{
    if (empty($dateValue)) {
        return '-';
    }

    if (is_object($dateValue) && method_exists($dateValue, 'format')) {
        $dateText = $dateValue->format('Y-m-d');
        $timeText = $dateValue->format('H:i:s');

        if (($timeText === '00:00:00' || $timeText === '00:00') && !empty($timeValue)) {
            $timeText = is_object($timeValue) && method_exists($timeValue, 'format')
                ? $timeValue->format('H:i:s')
                : substr((string)$timeValue, 0, 8);
        }

        $time = strtotime(trim($dateText . ' ' . $timeText));
        return $time ? date($format, $time) : $dateValue->format($format);
    }

    $dateString = (string)$dateValue;
    $hasTime = preg_match('/\d{2}:\d{2}/', $dateString);

    if (!$hasTime && !empty($timeValue)) {
        $timeString = is_object($timeValue) && method_exists($timeValue, 'format')
            ? $timeValue->format('H:i:s')
            : substr((string)$timeValue, 0, 8);

        $dateString = trim($dateString . ' ' . $timeString);
    }

    $time = strtotime($dateString);
    return $time ? date($format, $time) : '-';
}

$kasirName = $this->request->getSession()->read('Auth.User.name')
    ?? $this->request->getSession()->read('Auth.User.full_name')
    ?? 'GR';
?>

<?= $this->Krs->breadcrumb('Kasir', 'Kasir Central') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-cash-register"></i> Kasir Central
        </h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <div class="panel-body">

        <!-- INFO BAR -->
        <div class="kasir-info-bar">
            <div>
                <strong>Kasir :</strong> <?= h($kasirName) ?><br>
                <strong>DAFTAR PASIEN RJ / IGD</strong>
            </div>
            <div>
                <strong>Shift :</strong> 0
            </div>
            <div>
                <strong>Jam :</strong> <span id="kasir-clock"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="row m-b-10">
            <?php
            $cards = [
                ['label' => 'Total Tagihan',   'val' => $summary['total'] ?? 0,   'bg' => '#1e3a5f', 'icon' => 'fa-file-invoice-dollar'],
                ['label' => 'Menunggu Bayar',  'val' => $summary['waiting'] ?? 0, 'bg' => '#856404', 'icon' => 'fa-clock'],
                ['label' => 'Lunas',           'val' => $summary['paid'] ?? 0,    'bg' => '#155724', 'icon' => 'fa-check-circle'],
                ['label' => 'Pendapatan',      'val' => 'Rp ' . number_format((float)($summary['revenue'] ?? 0), 0, ',', '.'), 'bg' => '#495057', 'icon' => 'fa-money-bill-wave'],
            ];
            foreach ($cards as $card): ?>
                <div class="col-md-3 col-xs-6" style="padding:0 5px; margin-bottom:8px;">
                    <div class="kasir-summary-card" style="background:<?= h($card['bg']) ?>;">
                        <div class="kasir-summary-value"><?= h($card['val']) ?></div>
                        <div class="kasir-summary-label">
                            <i class="fa <?= h($card['icon']) ?>"></i> <?= h($card['label']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
        // Split billings jadi Rawat Jalan vs IGD berdasarkan prefix billing_no
        $billingsRJ  = [];
        $billingsIGD = [];
        foreach (($billings ?? []) as $b) {
            if (stripos($b->billing_no ?? '', 'IGD-') === 0) {
                $billingsIGD[] = $b;
            } else {
                $billingsRJ[] = $b;
            }
        }
        ?>

        <div class="kasir-tabs">
            <button type="button" class="kasir-tab-btn active" data-target="tab-rj">
                <i class="fa fa-hospital-user"></i> Rawat Jalan
            </button>
            <button type="button" class="kasir-tab-btn" data-target="tab-igd">
                <i class="fa fa-briefcase-medical"></i> IGD
            </button>
            <button type="button" class="kasir-tab-btn" data-target="tab-ranap">
                <i class="fa fa-bed"></i> Rawat Inap
            </button>
            <button type="button" class="kasir-tab-btn" data-target="tab-tutup">
                <i class="fa fa-pause-circle"></i> Tutup Sementara
            </button>
        </div>

        <!-- FILTER BAR -->
        <div class="kasir-filter-box">
            <?= $this->Form->create(null, ['type' => 'get', 'style' => 'margin:0;']) ?>

            <div class="row" style="display:flex; align-items:flex-end; flex-wrap:wrap;">

                <div class="col-md-2 col-sm-6">
                    <label class="kasir-filter-label">
                        <i class="fa fa-calendar"></i> Dari Selesai
                    </label>
                    <input type="date" name="date_from" class="form-control input-sm"
                           value="<?= h($dateFrom ?? date('Y-m-d')) ?>">
                </div>

                <div class="col-md-2 col-sm-6">
                    <label class="kasir-filter-label">
                        <i class="fa fa-calendar"></i> Sampai Selesai
                    </label>
                    <input type="date" name="date_to" class="form-control input-sm"
                           value="<?= h($dateTo ?? date('Y-m-d')) ?>">
                </div>

                <div class="col-md-2 col-sm-6">
                    <label class="kasir-filter-label">
                        <i class="fa fa-filter"></i> Status
                    </label>
                    <select name="status" class="form-control input-sm">
                        <option value="">Semua Status</option>
                        <?php foreach ($statusMap as $key => $cfg): ?>
                            <option value="<?= h($key) ?>" <?= ($status ?? '') === $key ? 'selected' : '' ?>>
                                <?= h($cfg['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-5 col-sm-6">
                    <label class="kasir-filter-label">
                        <i class="fa fa-search"></i> Cari Pasien / No Reg / No Billing
                    </label>
                    <input type="text" name="q" class="form-control input-sm"
                           placeholder="Nama pasien / No Reg / No Billing"
                           value="<?= h($q ?? '') ?>">
                </div>

                <div class="col-md-1 col-sm-12">
                    <label>&nbsp;</label>
                    <div style="display:flex; gap:3px;">
                        <button type="submit" class="btn btn-warning btn-sm" title="Search">
                            <i class="fa fa-search"></i>
                        </button>

                        <?= $this->Html->link(
                            '<i class="fa fa-times"></i>',
                            ['action' => 'index'],
                            ['escape' => false, 'class' => 'btn btn-default btn-sm', 'title' => 'Reset']
                        ) ?>
                    </div>
                </div>

            </div>

            <?= $this->Form->end() ?>
        </div>

        <?php
    function renderKasirRows($list, array $statusMap)
    {
        foreach ($list as $billing) {
            $patient = $billing->patient ?? null;
            $registration = $billing->registration ?? null;

            $st = $statusMap[$billing->status ?? 'draft'] ?? [
                'label' => $billing->status ?? '-',
                'class' => 'default'
            ];

            $regNo = $registration->registration_no
                ?? $registration->registration_number
                ?? $billing->registration_id
                ?? '-';

            $visitRaw = $billing->visit_date
                ?? $registration->registration_date
                ?? $registration->created
                ?? null;

            $visitTimeRaw = $billing->visit_time
                ?? $registration->admission_time
                ?? null;

            $visitDate = formatKasirDateTime($visitRaw, $visitTimeRaw, 'd-m-Y H:i');

            $finishedRaw = $billing->finished_at
                ?? $billing->finish_date
                ?? $billing->completed_at
                ?? $billing->selesai_periksa_at
                ?? $billing->created
                ?? null;

            $finishedDate = formatKasirDate($finishedRaw, 'd-m-Y H:i');
            $billingNo = $billing->billing_no ?? '-';
            $isIgd = stripos($billingNo, 'IGD-') === 0;
            $rowBg = $isIgd ? '#fff5f5' : '';
            ?>
            <tr style="background:<?= h($rowBg) ?>; cursor:pointer;"
                class="kasir-row-clickable"
                data-href="/br_prototype/outpatient-billings/kasir/<?= (int)$billing->id ?>"
                title="Klik untuk proses kasir">
                <td style="font-family:monospace; font-weight:700;"><?= h($billingNo) ?></td>
                <td class="text-center"><?= h($regNo) ?></td>
                <td class="text-center" style="font-size:11px; color:#6c757d;"><?= h($patient->code ?? '-') ?></td>
                <td>
                    <div style="font-weight:700; color:#1f2937;"><?= h($patient->full_name ?? '-') ?></div>
                    <?php if (!empty($billing->polyclinic_name)): ?>
                        <div style="font-size:10px; color:#9ca3af;">
                            <i class="fa fa-hospital"></i> <?= h($billing->polyclinic_name) ?>
                        </div>
                    <?php endif; ?>
                </td>
                <td class="text-center" style="font-size:11px;"><?= h($visitDate) ?></td>
                <td class="text-center" style="font-size:11px;"><?= h($finishedDate) ?></td>
                <td class="text-center" style="font-size:11px;">
                    <?php if (!empty($billing->polyclinic_name)): ?>
                        <span class="poli-badge"><?= h($billing->polyclinic_name) ?></span>
                    <?php else: ?>
                        <span style="color:#d1d5db;">—</span>
                    <?php endif; ?>
                </td>
                <td class="text-center"><?= h($billing->insurance_type ?? 'Umum') ?></td>
                <td class="text-right" style="font-weight:800; color:#1e3a5f;">
                    Rp <?= number_format((float)($billing->grand_total ?? 0), 0, ',', '.') ?>
                </td>
                <td class="text-center">
                    <span class="label label-<?= h($st['class']) ?>"><?= h($st['label']) ?></span>
                </td>
            </tr>
            <?php
        }
    }
    ?>

    <!-- PANE: RAWAT JALAN -->
    <div id="tab-rj" class="kasir-tab-pane active">
        <div class="kasir-toolbar">
            <h5 class="section-title">
                <i class="fa fa-hospital-user"></i> DAFTAR PASIEN RAWAT JALAN
            </h5>
            <span class="kasir-period">
                <i class="fa fa-calendar-day"></i>
                Periode Tgl Selesai:
                <strong><?= h(formatKasirDate($dateFrom ?? date('Y-m-d'), 'd-m-Y')) ?></strong>
                -
                <strong><?= h(formatKasirDate($dateTo ?? date('Y-m-d'), 'd-m-Y')) ?></strong>
            </span>
        </div>

        <div class="table-responsive kasir-table-wrap">
            <table class="table table-hover table-bordered table-kasir" style="font-size:12px;">
                <thead>
                    <tr class="text-center">
                        <th width="145">No Billing</th>
                        <th width="135">No Registrasi</th>
                        <th width="90">Rek<br>Medis</th>
                        <th>Nama Pasien</th>
                        <th width="125">Tgl Masuk<br><small>Jam</small></th>
                        <th width="130">Tgl Selesai</th>
                        <th width="125">Poli / Unit</th>
                        <th width="110">Cara Bayar</th>
                        <th width="115">Total</th>
                        <th width="110">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($billingsRJ)): ?>
                    <tr>
                        <td colspan="10" class="text-center kasir-empty">
                            <div style="font-size:34px; margin-bottom:8px;">💳</div>
                            <div style="font-weight:600;">Belum ada tagihan rawat jalan.</div>
                            <div style="font-size:11px; margin-top:4px;">Ubah filter tanggal atau cari data pasien lain.</div>
                        </td>
                    </tr>
                <?php else: renderKasirRows($billingsRJ, $statusMap); endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PANE: IGD -->
    <div id="tab-igd" class="kasir-tab-pane">
        <div class="kasir-toolbar">
            <h5 class="section-title">
                <i class="fa fa-briefcase-medical"></i> DAFTAR PASIEN IGD
            </h5>
            <span class="kasir-period">
                <i class="fa fa-calendar-day"></i>
                Periode Tgl Selesai:
                <strong><?= h(formatKasirDate($dateFrom ?? date('Y-m-d'), 'd-m-Y')) ?></strong>
                -
                <strong><?= h(formatKasirDate($dateTo ?? date('Y-m-d'), 'd-m-Y')) ?></strong>
            </span>
        </div>

        <div class="table-responsive kasir-table-wrap">
            <table class="table table-hover table-bordered table-kasir" style="font-size:12px;">
                <thead>
                    <tr class="text-center">
                        <th width="145">No Billing</th>
                        <th width="135">No Registrasi</th>
                        <th width="90">Rek<br>Medis</th>
                        <th>Nama Pasien</th>
                        <th width="125">Tgl Masuk<br><small>Jam</small></th>
                        <th width="130">Tgl Selesai</th>
                        <th width="125">Poli / Unit</th>
                        <th width="110">Cara Bayar</th>
                        <th width="115">Total</th>
                        <th width="110">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($billingsIGD)): ?>
                    <tr>
                        <td colspan="10" class="text-center kasir-empty">
                            <div style="font-size:34px; margin-bottom:8px;">🚑</div>
                            <div style="font-weight:600;">Belum ada tagihan IGD.</div>
                            <div style="font-size:11px; margin-top:4px;">Ubah filter tanggal atau cari data pasien lain.</div>
                        </td>
                    </tr>
                <?php else: renderKasirRows($billingsIGD, $statusMap); endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PANE: RAWAT INAP -->
    <div id="tab-ranap" class="kasir-tab-pane">
        <h5 class="section-title">
            <i class="fa fa-bed"></i> DAFTAR PASIEN RAWAT INAP (OPNAME)
        </h5>
        <div class="table-responsive kasir-table-wrap">
            <table class="table table-hover table-bordered table-kasir" style="font-size:12px;">
                <thead>
                    <tr class="text-center">
                        <th width="60">No</th>
                        <th width="150">Tgl Rencana Pulang</th>
                        <th width="150">No Registrasi</th>
                        <th width="100">Rek Medis</th>
                        <th>Nama Pasien</th>
                        <th width="130">Tgl Masuk</th>
                        <th width="160">Ruang / Kamar</th>
                        <th width="130">Cara Bayar</th>
                        <th width="120">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="text-center kasir-empty">
                            <div style="font-size:28px; margin-bottom:5px;">🛏️</div>
                            Data pasien rawat inap dikosongkan dulu. Nanti tinggal diisi setelah analisis.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PANE: TUTUP SEMENTARA -->
    <div id="tab-tutup" class="kasir-tab-pane">
        <h5 class="section-title">
            <i class="fa fa-pause-circle"></i> DAFTAR PASIEN TUTUP SEMENTARA
        </h5>
        <div class="table-responsive kasir-table-wrap">
            <table class="table table-hover table-bordered table-kasir" style="font-size:12px;">
                <thead>
                    <tr class="text-center">
                        <th width="60">No</th>
                        <th width="150">No Registrasi</th>
                        <th width="100">Rek Medis</th>
                        <th>Nama Pasien</th>
                        <th width="130">Tgl Masuk</th>
                        <th width="160">Poli / Ruang</th>
                        <th width="130">Cara Bayar</th>
                        <th width="120">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center kasir-empty">
                            <div style="font-size:28px; margin-bottom:5px;">⏸️</div>
                            Data pasien tutup sementara dikosongkan dulu. Nanti tinggal diisi setelah analisis.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

        <?= $this->Krs->paginators() ?>

    </div>
</div>

<style>
.kasir-info-bar {
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:12px;
    background:#f8f9fa;
    border:1px solid #dee2e6;
    border-radius:8px;
    color:#17233d;
    padding:10px 12px;
    margin-bottom:10px;
    font-size:12px;
}
.kasir-summary-card {
    color:#fff;
    border-radius:8px;
    padding:12px 14px;
    text-align:center;
}
.kasir-summary-value {
    font-size:21px;
    font-weight:800;
    line-height:1.15;
}
.kasir-summary-label {
    font-size:11px;
    opacity:.9;
    margin-top:3px;
}
.kasir-filter-box {
    background:#f8f9fa;
    border:1px solid #dee2e6;
    border-radius:8px;
    padding:10px 12px;
    margin-bottom:14px;
}
.kasir-filter-label {
    font-size:11px;
    font-weight:600;
    color:#555;
}
.kasir-toolbar {
    margin-bottom:8px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:8px;
    flex-wrap:wrap;
}
.section-title {
    font-weight:800;
    color:#1e3a5f;
    margin:0;
    text-transform:uppercase;
    font-size:13px;
}
.section-title-space {
    margin-top:15px;
    margin-bottom:8px;
}
.kasir-period {
    font-size:12px;
    color:#6c757d;
}
.kasir-table-wrap {
    max-height:260px;
    overflow:auto;
    border:1px solid #dee2e6;
    border-radius:6px;
}
.kasir-empty-table-wrap {
    max-height:155px;
}
.table-kasir {
    margin-bottom:0 !important;
    background:#fff;
}
.table-kasir > thead > tr > th {
    background:#1e3a5f !important;
    color:#fff !important;
    border-color:#2d4f7f !important;
    padding:8px 6px !important;
    vertical-align:middle !important;
    font-size:11px;
    font-weight:600;
    text-align:center;
    white-space:nowrap;
}
.table-kasir td {
    vertical-align:middle !important;
    padding:6px 6px !important;
    white-space:nowrap;
}
.table-kasir > tbody > tr:hover {
    background:#f0f9ff !important;
}
.kasir-row-clickable:hover {
    background:#dbeafe !important;
}
.kasir-empty {
    padding:34px !important;
    color:#9ca3af !important;
}
.btn-xs {
    padding:3px 7px;
    font-size:11px;
    line-height:1.5;
    border-radius:4px;
}
.instalasi-badge {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:38px;
    padding:3px 8px;
    border-radius:20px;
    font-size:10px;
    font-weight:800;
}
.instalasi-rj {
    background:#e0f2fe;
    color:#0369a1;
}
.instalasi-igd {
    background:#fee2e2;
    color:#7f1d1d;
}
.poli-badge {
    background:#e0f2fe;
    color:#0369a1;
    border-radius:20px;
    padding:2px 8px;
    font-weight:600;
    font-size:10px;
}
.label {
    padding:3px 9px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
}
.label-warning {
    background:#ffc107;
    color:#5c4300;
}
.label-success {
    background:#28a745;
    color:#fff;
}
.label-danger {
    background:#dc3545;
    color:#fff;
}
.label-default {
    background:#6c757d;
    color:#fff;
}

@media (max-width:768px) {
    .kasir-info-bar {
        display:block;
    }
    .kasir-filter-box .row {
        display:block !important;
    }
    .kasir-filter-box .col-md-1,
    .kasir-filter-box .col-md-2,
    .kasir-filter-box .col-md-5 {
        margin-bottom:7px;
    }
}

.kasir-tabs {
    display:flex;
    align-items:stretch;
    gap:6px;
    margin-bottom:12px;
}
.kasir-tab-btn {
    flex:1;
    text-align:center;
    padding:10px 14px;
    background:#e0f2fe;
    color:#0369a1;
    font-weight:700;
    font-size:13px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    transition:.15s;
}
.kasir-tab-btn:hover {
    background:#bae6fd;
}
.kasir-tab-btn.active {
    background:#1e3a5f;
    color:#fff;
}
.kasir-tab-pane {
    display:none;
}
.kasir-tab-pane.active {
    display:block;
}
</style>

<script>
(function () {
    function updateKasirClock() {
        var el = document.getElementById('kasir-clock');
        if (!el) return;

        var now = new Date();
        var h = String(now.getHours()).padStart(2, '0');
        var m = String(now.getMinutes()).padStart(2, '0');
        var s = String(now.getSeconds()).padStart(2, '0');

        el.innerHTML = h + ':' + m + ':' + s;
    }

    setInterval(updateKasirClock, 1000);
    updateKasirClock();

    document.querySelectorAll('.kasir-row-clickable').forEach(function (row) {
        row.addEventListener('click', function () {
            var url = row.getAttribute('data-href');
            if (url) {
                window.location.href = url;
            }
        });
    });

    // Switch tab pelayanan (Rawat Jalan/IGD, Rawat Inap, Tutup Sementara)
    var tabButtons = document.querySelectorAll('.kasir-tab-btn');
    var tabPanes = document.querySelectorAll('.kasir-tab-pane');

    tabButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            tabButtons.forEach(function (b) { b.classList.remove('active'); });
            tabPanes.forEach(function (p) { p.classList.remove('active'); });

            btn.classList.add('active');
            var target = document.getElementById(btn.getAttribute('data-target'));
            if (target) target.classList.add('active');
        });
    });
})();
</script>