<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration[]|\Cake\Collection\CollectionInterface $registrations
 */

$svcMap = [
    'rawat_jalan' => ['label' => 'Rawat Jalan', 'color' => '#0d6efd', 'bg' => '#e7f1ff'],
    'igd'         => ['label' => 'IGD',         'color' => '#dc3545', 'bg' => '#fde8ea'],
    'rawat_inap'  => ['label' => 'Rawat Inap',  'color' => '#198754', 'bg' => '#e6f4ea'],
];

$payMap = [
    'UMUM'     => ['color' => '#856404', 'bg' => '#fff3cd'],
    'ASURANSI' => ['color' => '#0f5132', 'bg' => '#d1e7dd'],
];

$statusMap = [
    // Nilai status yang dipakai di form
    'aktif'   => ['label' => 'Aktif',   'badge' => 'success', 'icon' => 'fa-circle-dot',   'row' => ''],
    'selesai' => ['label' => 'Selesai', 'badge' => 'default', 'icon' => 'fa-check-circle', 'row' => 'opacity:0.65;'],
    'batal'   => ['label' => 'Batal',   'badge' => 'danger',  'icon' => 'fa-times-circle', 'row' => 'opacity:0.5;'],
    // Fallback untuk data lama yang belum punya status
    ''        => ['label' => 'Aktif',   'badge' => 'success', 'icon' => 'fa-circle-dot',   'row' => ''],
    'y'       => ['label' => 'Aktif',   'badge' => 'success', 'icon' => 'fa-circle-dot',   'row' => ''],
    'n'       => ['label' => 'Non Aktif','badge'=> 'default', 'icon' => 'fa-circle',        'row' => 'opacity:0.65;'],
];

// URL untuk AJAX summary — dipakai di JS
$summaryUrl = $this->Url->build(['action' => 'getSummary']);
?>

<?= $this->Krs->breadcrumb('Registrations', 'Daftar Registrasi Pasien') ?>

<div class="panel panel-inverse">

    <!-- PANEL HEADER -->
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-clipboard-list" style="margin-right:6px;"></i>
            Registrasi Pasien
            <span style="display:inline-flex; align-items:center; gap:5px;
                         font-size:12px; font-weight:400; color:#28a745;
                         background:#e9f7ef; border-radius:20px;
                         padding:2px 10px; margin-left:10px; vertical-align:middle;">
                <span id="live-dot" style="width:8px; height:8px; background:#28a745; border-radius:50%;
                             display:inline-block; animation:pulse 1.5s infinite;"></span>
                Live
            </span>
        </h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">

        <!-- TOOLBAR — semua filter dalam satu baris -->
        <div class="table-toolbar" style="margin-bottom:16px;">
            <?= $this->Form->create(null, ['type' => 'get', 'id' => 'search-form']) ?>

            <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">

                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i> Registrasi Baru',
                    ['action' => 'add'],
                    ['class' => 'btn btn-primary btn-sm', 'escape' => false]
                ) ?>

                <?php $currentStatus = $this->request->getQuery('status', ''); ?>
                <select name="status" class="form-control form-control-sm"
                        style="width:130px;" onchange="this.form.submit()">
                    <option value=""        <?= $currentStatus === ''        ? 'selected' : '' ?>>Semua Status</option>
                    <option value="aktif"   <?= $currentStatus === 'aktif'   ? 'selected' : '' ?>>Aktif</option>
                    <option value="selesai" <?= $currentStatus === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="batal"   <?= $currentStatus === 'batal'   ? 'selected' : '' ?>>Batal</option>
                </select>

                <?php $currentSvc = $this->request->getQuery('service_type', ''); ?>
                <select name="service_type" class="form-control form-control-sm"
                        style="width:150px;" onchange="this.form.submit()">
                    <option value=""             <?= $currentSvc === ''             ? 'selected' : '' ?>>Semua Layanan</option>
                    <option value="rawat_jalan"  <?= $currentSvc === 'rawat_jalan'  ? 'selected' : '' ?>>Rawat Jalan</option>
                    <option value="igd"          <?= $currentSvc === 'igd'          ? 'selected' : '' ?>>IGD</option>
                    <option value="rawat_inap"   <?= $currentSvc === 'rawat_inap'   ? 'selected' : '' ?>>Rawat Inap</option>
                </select>

                <input type="date"
                    name="date_from"
                    class="form-control form-control-sm"
                    style="width:150px;"
                    value="<?= h($this->request->getQuery('date_from', date('Y-m-d'))) ?>">

                <span>-</span>

                <input type="date"
                    name="date_to"
                    class="form-control form-control-sm"
                    style="width:150px;"
                    value="<?= h($this->request->getQuery('date_to', date('Y-m-d'))) ?>">

                <select name="payment_method" class="form-control form-control-sm"
                        style="width:130px;" onchange="this.form.submit()">
                    <option value="">Cara Bayar</option>
                    <option value="UMUM"
                        <?= $this->request->getQuery('payment_method') === 'UMUM' ? 'selected' : '' ?>>
                        UMUM
                    </option>
                    <option value="ASURANSI"
                        <?= $this->request->getQuery('payment_method') === 'ASURANSI' ? 'selected' : '' ?>>
                        ASURANSI
                    </option>
                </select>

                <div class="input-group" style="flex:1 1 200px; min-width:200px; max-width:320px;">
                    <input type="text" id="search-q" name="q" class="form-control"
                           placeholder="Cari no registrasi / nama pasien..."
                           value="<?= h($this->request->getQuery('q')) ?>"
                           autocomplete="off">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning" id="btn-search">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="<?= $this->Url->build(['action' => 'index']) ?>"
                           class="btn btn-default" title="Reset filter">
                            <i class="fa fa-rotate-left"></i>
                        </a>
                    </span>
                </div>

            </div>

            <?= $this->Form->end() ?>
        </div>

        <!-- SUMMARY CARDS — diisi via AJAX polling -->
        <div class="row" style="margin-bottom:20px;">
            <?php
            $cards = [
                ['key' => 'aktif',       'label' => 'Aktif',       'icon' => 'fa-circle-dot',    'color' => '#28a745', 'bg' => '#e9f7ef'],
                ['key' => 'rawat_jalan', 'label' => 'Rawat Jalan', 'icon' => 'fa-person-walking', 'color' => '#0d6efd', 'bg' => '#e7f1ff'],
                ['key' => 'igd',         'label' => 'IGD',         'icon' => 'fa-truck-medical',  'color' => '#dc3545', 'bg' => '#fde8ea'],
                ['key' => 'rawat_inap',  'label' => 'Rawat Inap',  'icon' => 'fa-bed-pulse',      'color' => '#198754', 'bg' => '#e6f4ea'],
            ];
            foreach ($cards as $card):
            ?>
            <div class="col-xs-6 col-md-3" style="margin-bottom:10px;">
                <div style="background:<?= $card['bg'] ?>; border-radius:14px;
                            padding:14px 18px; display:flex; align-items:center;
                            gap:14px; border-left:4px solid <?= $card['color'] ?>;
                            box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                    <i class="fa-solid <?= $card['icon'] ?>"
                       style="font-size:26px; color:<?= $card['color'] ?>;"></i>
                    <div>
                        <div id="cnt-<?= $card['key'] ?>"
                             style="font-size:26px; font-weight:700;
                                    color:<?= $card['color'] ?>; line-height:1;">
                            <i class="fa fa-spinner fa-spin" style="font-size:16px;"></i>
                        </div>
                        <div style="font-size:12px; color:#6c757d;"><?= $card['label'] ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" style="font-size:13px;">
                <thead>
                    <tr class="text-center" style="background:#2c3e50; color:#fff;">
                        <th width="40">No</th>
                        <th width="130"><?= $this->Paginator->sort('registration_no', 'No Registrasi') ?></th>
                        <th width="90"><?= $this->Paginator->sort('registration_date', 'Tgl Masuk') ?></th>
                        <th>Pasien</th>
                        <th width="95"><?= $this->Paginator->sort('service_type', 'Pelayanan') ?></th>
                        <th width="110">Poli / Unit</th>
                        <th width="140">Dokter</th>
                        <th width="85"><?= $this->Paginator->sort('payment_method', 'Cara Bayar') ?></th>
                        <th width="90">Penjamin</th>
                        <th width="80"><?= $this->Paginator->sort('status', 'Status') ?></th>
                        <th width="90">Aksi</th>
                    </tr>
                </thead>
                <tbody id="reg-tbody">
                    <?php if (empty($registrations) || iterator_count($registrations) === 0): ?>
                    <tr>
                        <td colspan="11" class="text-center" style="padding:36px; color:#6c757d;">
                            <i class="fa fa-inbox fa-3x" style="display:block; margin-bottom:10px;"></i>
                            Tidak ada data registrasi ditemukan.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php $no = $this->Paginator->counter('{{start}}');
                    foreach ($registrations as $registration): ?>
                    <?php
                        $rawStatus = strtolower($registration->status ?? '');
                        $st  = $statusMap[$rawStatus]
                            ?? ['label' => h($registration->status ?? '-'), 'badge' => 'default', 'icon' => 'fa-circle', 'row' => ''];
                        $svc = $svcMap[$registration->service_type]
                            ?? ['label' => h($registration->service_type), 'color' => '#6c757d', 'bg' => '#f0f0f0'];
                        $pay = $payMap[$registration->payment_method]
                            ?? ['color' => '#6c757d', 'bg' => '#f0f0f0'];
                    ?>
                    <tr data-status="<?= h($rawStatus) ?>"
                        data-svc="<?= h($registration->service_type) ?>"
                        style="<?= $st['row'] ?>">

                        <td class="text-center" style="color:#6c757d;"><?= $no++ ?></td>

                        <td class="text-center">
                            <strong style="font-size:13px; color:#1a56db; letter-spacing:0.5px;">
                                <?= h($registration->registration_no) ?>
                            </strong>
                        </td>

                        <td class="text-center" style="white-space:nowrap; color:#6c757d; font-size:12px;">
                            <i class="fa fa-calendar" style="margin-right:3px;"></i>
                            <?= $registration->registration_date
                                ? date('d-m-Y', strtotime($registration->registration_date))
                                : '—' ?>
                        </td>

                        <td>
                            <?php if ($registration->has('patient') && $registration->patient): ?>
                                <i class="fa fa-user" style="color:#6c757d; margin-right:4px;"></i>
                                <strong><?= h($registration->patient->full_name ?? '-') ?></strong>
                                <br>
                                <small style="color:#6c757d; font-size:11px;">
                                    <?= h($registration->patient->code ?? '') ?>
                                </small>
                            <?php else: ?>
                                <span style="color:#bbb;">—</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <span class="label-badge"
                                  style="color:<?= $svc['color'] ?>; background:<?= $svc['bg'] ?>;">
                                <?= $svc['label'] ?>
                            </span>
                        </td>

                        <td style="font-size:12px;"><?= h($registration->polyclinic_name ?? '—') ?></td>

                        <td style="font-size:12px;">
                            <?php if ($registration->has('doctor') && $registration->doctor): ?>
                                <i class="fa fa-user-doctor" style="color:#6c757d; margin-right:3px;"></i>
                                <?= h($registration->doctor->doctor_name ?? '—') ?>
                            <?php else: ?>
                                <span style="color:#bbb;">—</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <span class="label-badge"
                                  style="color:<?= $pay['color'] ?>; background:<?= $pay['bg'] ?>;">
                                <?= h($registration->payment_method ?? '—') ?>
                            </span>
                        </td>

                        <td style="font-size:12px; color:#495057;">
                            <?= h($registration->insurance_type ?? '—') ?>
                        </td>

                        <td class="text-center">
                            <span class="label label-<?= $st['badge'] ?>"
                                  style="font-size:11px; padding:4px 9px;">
                                <i class="fa-solid <?= $st['icon'] ?>"></i>
                                <?= $st['label'] ?>
                            </span>
                        </td>

                        <td class="text-center">
                            <div style="display:flex; gap:4px; justify-content:center; flex-wrap:wrap;">

                                <?= $this->Html->link('<i class="fa fa-eye"></i>',
                                    ['action' => 'view', $registration->id],
                                    ['escape' => false, 'class' => 'btn btn-info btn-xs',
                                     'title' => 'Lihat Detail', 'data-toggle' => 'tooltip']) ?>

                                <?= $this->Html->link('<i class="fa fa-edit"></i>',
                                    ['action' => 'edit', $registration->id],
                                    ['escape' => false, 'class' => 'btn btn-warning btn-xs',
                                     'title' => 'Edit', 'data-toggle' => 'tooltip']) ?>

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="row" style="margin-top:14px;">
            <div class="col-md-6">
                <p style="color:#6c757d; font-size:13px; margin:0;">
                    <?= $this->Paginator->counter(
                        'Menampilkan {{current}} dari {{count}} data (Halaman {{page}} / {{pages}})'
                    ) ?>
                </p>
            </div>
            <div class="col-md-6 text-right">
                <ul class="pagination pagination-sm m-t-0 m-b-0 pull-right">
                    <?= $this->Paginator->first('<<') ?>
                    <?= $this->Paginator->prev('<') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('>') ?>
                    <?= $this->Paginator->last('>>') ?>
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- TOAST notifikasi data baru -->
<div id="toast-notif"
     style="display:none; position:fixed; bottom:30px; right:30px; z-index:9999;
            background:#2c3e50; color:#fff; padding:14px 22px; border-radius:12px;
            font-size:14px; box-shadow:0 4px 20px rgba(0,0,0,0.3); cursor:pointer;"
     onclick="location.reload()">
    <i class="fa fa-clipboard-list" style="margin-right:8px;"></i>
    <span id="toast-msg">Ada data baru — klik untuk refresh</span>
</div>

<style>
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }
.label { padding:4px 9px; border-radius:6px; font-size:12px; font-weight:600; display:inline-block; }
.label-success { background:#d1e7dd; color:#0f5132; }
.label-danger  { background:#f8d7da; color:#842029; }
.label-info    { background:#cff4fc; color:#055160; }
.label-default { background:#e9ecef; color:#495057; }
.label-badge   { display:inline-block; padding:2px 10px; border-radius:20px; font-size:11px; font-weight:600; }
.btn-xs        { padding:3px 8px; font-size:12px; line-height:1.5; border-radius:4px; }
table thead th {
    background: #2c3e50 !important;
    color: #fff !important;
    border-color: #2c3e50 !important;
}

.table thead th a,
.table thead th a:hover,
.table thead th a:focus,
.table thead th a:visited {
    background: transparent !important;
    color: #fff !important;
    text-decoration: none !important;
    box-shadow: none !important;
    border: none !important;
    padding: 0 !important;
}
</style>

<script>
// ── URL summary endpoint ──────────────────────────────────────────────────────
var SUMMARY_URL = '<?= $summaryUrl ?>';
var summaryParams = {
    date_from: '<?= h($this->request->getQuery('date_from', date('Y-m-d'))) ?>',
    date_to:   '<?= h($this->request->getQuery('date_to', date('Y-m-d'))) ?>'
};
var initialTotal = <?= iterator_count($registrations) ?>;
var lastKnownTotal = null;

function fetchSummary() {
    $.getJSON(SUMMARY_URL, summaryParams, function (data) {

        // Update kartu angka
        $.each(['aktif', 'rawat_jalan', 'igd', 'rawat_inap'], function (i, key) {
            var el  = $('#cnt-' + key);
            var val = data[key] !== undefined ? data[key] : 0;

            // Animasi highlight jika angka berubah
            if (el.text() !== String(val) && !el.find('.fa-spinner').length) {
                el.css('transition', 'color 0.3s');
                el.css('color', '#ffc107');
                setTimeout(function () { el.css('color', ''); }, 600);
            }

            el.text(val);
        });

        // Deteksi data baru → tampilkan toast
        if (lastKnownTotal !== null && data.total > lastKnownTotal) {
            showToast('Ada ' + (data.total - lastKnownTotal) + ' registrasi baru — klik untuk refresh');
        }
        lastKnownTotal = data.total;

    }).fail(function () {
        // Jika gagal, matikan animasi pulse agar user tahu koneksi bermasalah
        $('#live-dot').css('animation', 'none').css('background', '#dc3545');
    });
}

// ── Toast helper ──────────────────────────────────────────────────────────────
function showToast(msg) {
    $('#toast-msg').text(msg);
    $('#toast-notif').fadeIn(300);
    setTimeout(function () { $('#toast-notif').fadeOut(400); }, 6000);
}

// ── Search live dengan debounce — submit form ke server ───────────────────────
var searchTimer;
$('#search-q').on('input', function () {
    clearTimeout(searchTimer);
    var q = $(this).val().trim();

    // Tampilkan spinner kecil di tombol saat menunggu
    $('#btn-search').html('<i class="fa fa-spinner fa-spin"></i>');

    searchTimer = setTimeout(function () {
        $('#search-form').submit();
    }, 500); // tunggu 500ms setelah user berhenti mengetik
});

// Restore icon tombol saat form di-submit normal
$('#search-form').on('submit', function () {
    $('#btn-search').html('<i class="fa fa-search"></i>');
});

// ── Init ──────────────────────────────────────────────────────────────────────
$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    // Langsung fetch summary pertama kali
    fetchSummary();

    // Polling setiap 15 detik
    setInterval(fetchSummary, 15000);
});
</script>