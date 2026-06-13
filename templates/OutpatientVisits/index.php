<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit[]|\Cake\Collection\CollectionInterface $visits
 * @var array $summary
 * @var array $poliList
 * @var array $doctors
 * @var string $filterDateFrom
 * @var string $filterDateTo
 * @var string|null $filterPoli
 * @var string|null $filterDoctor
 * @var string|null $filterStatus
 * @var string|null $q
 */

$statusCfg = [
    'waiting'     => ['label' => 'Menunggu',   'bg' => '#fff3cd', 'color' => '#856404',  'dot' => '#ffc107'],
    'called'      => ['label' => 'Dipanggil',  'bg' => '#cff4fc', 'color' => '#0c5460',  'dot' => '#0dcaf0'],
    'in_progress' => ['label' => 'Diperiksa',  'bg' => '#d1ecf1', 'color' => '#0c5460',  'dot' => '#17a2b8'],
    'done'        => ['label' => 'Selesai',    'bg' => '#d4edda', 'color' => '#155724',  'dot' => '#28a745'],
    'cancelled'   => ['label' => 'Batal',      'bg' => '#f8d7da', 'color' => '#721c24',  'dot' => '#dc3545'],
];

// Helper: build URL dengan mempertahankan date_from & date_to
$urlParams = function(array $extra = []) use ($filterDateFrom, $filterDateTo, $filterPoli, $filterDoctor, $filterStatus, $q) {
    return array_filter(array_merge([
        'date_from' => $filterDateFrom,
        'date_to'   => $filterDateTo,
        'poli'      => $filterPoli,
        'doctor_id' => $filterDoctor,
        'status'    => $filterStatus,
        'q'         => $q,
    ], $extra), fn($v) => $v !== null && $v !== '');
};
?>

<?= $this->Krs->breadcrumb('Outpatient Visits', 'Antrian Rawat Jalan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fas fa-stethoscope"></i> Instalasi Rawat Jalan
        </h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <div class="panel-body">

        <!-- ── SUMMARY CARDS ── -->
        <div class="row m-b-10">
            <?php
            $cards = [
                ['key' => 'total', 'label' => 'Total',       'val' => $summary['total'],       'bg' => '#1e3a5f', 'icon' => 'fa-users'],
                ['key' => 'waiting', 'label' => 'Menunggu',    'val' => $summary['waiting'],     'bg' => '#856404', 'icon' => 'fa-clock'],
                ['key' => 'called', 'label' => 'Dipanggil',   'val' => $summary['called'],      'bg' => '#0c5460', 'icon' => 'fa-bullhorn'],
                ['key' => 'in_progress', 'label' => 'Diperiksa',   'val' => $summary['in_progress'], 'bg' => '#155724', 'icon' => 'fa-stethoscope'],
                ['key' => 'done', 'label' => 'Selesai',     'val' => $summary['done'],        'bg' => '#495057', 'icon' => 'fa-check-circle'],
            ];
            foreach ($cards as $card): ?>
                <div class="col-md-2 col-xs-4" style="padding:0 5px; margin-bottom:8px;">
                    <div style="background:<?= $card['bg'] ?>; color:#fff; border-radius:8px;
                                padding:12px 14px; text-align:center;">
                        <div style="font-size:22px; font-weight:800;" data-summary="<?= h($card['key']) ?>"><?= $card['val'] ?></div>
                        <div style="font-size:11px; opacity:.85;">
                            <i class="fa <?= $card['icon'] ?>"></i> <?= $card['label'] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Auto-refresh indicator -->
            <div class="col-md-2 col-xs-4" style="padding:0 5px; margin-bottom:8px;">
                <div style="background:#f8f9fa; border:1px solid #dee2e6; border-radius:8px;
                            padding:10px 14px; text-align:center; cursor:pointer;"
                     id="btn-refresh" title="Refresh data">
                    <div style="font-size:18px; color:#6c757d;">
                        <i class="fa fa-sync-alt" id="icon-refresh"></i>
                    </div>
                    <div style="font-size:10px; color:#6c757d; margin-top:2px;">
                        Live <span id="live-status">aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── FILTER BAR ── -->
        <div style="background:#f8f9fa; border:1px solid #dee2e6; border-radius:8px;
                    padding:12px 14px; margin-bottom:14px;">
            <?= $this->Form->create(null, ['type' => 'get', 'style' => 'margin:0;']) ?>
            <div class="row" style="align-items:flex-end;">

                <!-- Dari -->
                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-calendar"></i> Dari
                    </label>
                    <input type="date" name="date_from" class="form-control form-control-sm"
                           value="<?= h($filterDateFrom) ?>">
                </div>

                <!-- Sampai -->
                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-calendar"></i> Sampai
                    </label>
                    <input type="date" name="date_to" class="form-control form-control-sm"
                           value="<?= h($filterDateTo) ?>">
                </div>

                <!-- Poli -->
                <div class="col-md-3">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-hospital"></i> Poli
                    </label>
                    <div style="display:flex; flex-wrap:wrap; gap:4px;">
                        <a href="<?= $this->Url->build(['action' => 'index', '?' => $urlParams(['poli' => null])]) ?>"
                           class="btn btn-xs <?= empty($filterPoli) ? 'btn-primary' : 'btn-default' ?>">Semua</a>
                        <?php foreach ($poliList as $poli): ?>
                            <?php $pNm = is_array($poli) ? ($poli['polyclinic_name'] ?? '') : ($poli->polyclinic_name ?? '') ?>
                            <?php if (empty($pNm)) continue; ?>
                            <a href="<?= $this->Url->build(['action' => 'index', '?' => $urlParams(['poli' => $pNm])]) ?>"
                               class="btn btn-xs <?= $filterPoli === $pNm ? 'btn-info' : 'btn-default' ?>">
                                <?= h($pNm) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Dokter -->
                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-user-md"></i> Dokter
                    </label>
                    <select name="doctor_id" class="form-control form-control-sm">
                        <option value="">Semua Dokter</option>
                        <?php foreach ($doctors as $did => $dname): ?>
                            <option value="<?= $did ?>" <?= $filterDoctor == $did ? 'selected' : '' ?>>
                                <?= h($dname) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status -->
                <div class="col-md-1">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-filter"></i> Status
                    </label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">Semua</option>
                        <?php foreach ($statusCfg as $sval => $sc): ?>
                            <option value="<?= $sval ?>" <?= $filterStatus === $sval ? 'selected' : '' ?>>
                                <?= $sc['label'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Cari -->
                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-search"></i> Cari
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="hidden" name="poli" value="<?= h($filterPoli ?? '') ?>">
                        <input type="text" name="q" class="form-control"
                               placeholder="Nama / No reg..."
                               value="<?= h($q ?? '') ?>">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fa fa-search"></i>
                            </button>
                            <a href="<?= $this->Url->build(['action' => 'index']) ?>"
                               class="btn btn-default btn-sm" title="Reset semua filter">
                                <i class="fa fa-times"></i>
                            </a>
                        </span>
                    </div>
                </div>

            </div>
            <?= $this->Form->end() ?>
        </div>

        <!-- ── TOOLBAR TAMBAH ── -->
        <div style="margin-bottom:10px; display:flex; gap:8px; align-items:center;">
            <?= $this->Html->link(
                '<i class="fa fa-plus"></i> Tambah Kunjungan',
                ['action' => 'add'],
                ['class' => 'btn btn-inverse btn-sm', 'escape' => false]
            ) ?>
            <span style="font-size:12px; color:#6c757d;">
                <i class="fa fa-calendar-day"></i>
                <?php if ($filterDateFrom === $filterDateTo): ?>
                    Tanggal: <strong><?= date('l, d F Y', strtotime($filterDateFrom)) ?></strong>
                <?php else: ?>
                    Periode: <strong><?= date('d F Y', strtotime($filterDateFrom)) ?></strong>
                    &nbsp;—&nbsp;
                    <strong><?= date('d F Y', strtotime($filterDateTo)) ?></strong>
                <?php endif; ?>
            </span>
        </div>

        <!-- ── TABEL ANTRIAN ── -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-outpatient" style="font-size:12px;">
                <thead>
                    <tr class="text-center">
                        <th width="40">No<br>Antri</th>
                        <th width="45">Resume<br>Medis</th>
                        <th width="200">Aksi</th>
                        <th width="70">Rek<br>Medis</th>
                        <th width="80">Dokter</th>
                        <th width="70">No Reg</th>
                        <th>Nama Pasien</th>
                        <th width="90">Tgl Masuk</th>
                        <th width="90">Poli</th>
                        <th width="95">Status</th>
                    </tr>
                </thead>
                <tbody id="tbody-visits">
                <?php if (empty($visits) || !count($visits)): ?>
                    <tr>
                        <td colspan="10" style="text-align:center; padding:40px; color:#9ca3af;">
                            <div style="font-size:36px; margin-bottom:8px;">🏥</div>
                            <div style="font-weight:600;">Tidak ada kunjungan untuk periode ini</div>
                            <div style="font-size:11px; margin-top:4px;">
                                Tambah kunjungan baru atau ubah filter tanggal
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($visits as $v):
                        $sc     = $statusCfg[$v->status] ?? $statusCfg['waiting'];
                        $isDone = in_array($v->status, ['done', 'cancelled']);

                        $rowBgs = [
                            'waiting'     => '',
                            'called'      => '#fffde7',
                            'in_progress' => '#e8f4fd',
                            'done'        => '#f0fff4',
                            'cancelled'   => '#fff5f5',
                        ];
                        $rowBg = $rowBgs[$v->status] ?? '';

                        $pName  = $v->patient->full_name ?? '-';
                        $pCode  = $v->patient->medical_record_no ?? '-';
                        $dName  = $v->doctor->doctor_name ?? '-';
                        $dShort = implode(' ', array_slice(explode(' ', $dName), 0, 2));
                    ?>
                    <tr style="background:<?= $rowBg ?>;"
                        data-visit-id="<?= $v->id ?>"
                        data-status="<?= $v->status ?>">

                        <!-- No Antri -->
                        <td class="text-center" style="font-weight:800; font-size:16px; color:#1e3a5f;">
                            <?= $v->queue_number ?? '-' ?>
                        </td>

                        <!-- Resume Medis -->
                        <td class="text-center">
                            <?= $this->Html->link(
                                '<i class="fa fa-file-medical"></i>',
                                ['action' => 'view', $v->id],
                                ['escape' => false, 'class' => 'btn btn-xs btn-info',
                                 'data-toggle' => 'tooltip', 'title' => 'Resume Medis']
                            ) ?>
                        </td>

                        <!-- ── AKSI ── -->
                        <td class="text-center">
                            <div style="display:flex; gap:2px; justify-content:center; flex-wrap:wrap;">

                                <?php if (!$isDone): ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-notes-medical"></i> EMR',
                                        ['action' => 'emr', $v->id],
                                        ['escape' => false,
                                         'class'  => 'btn btn-xs btn-teal',
                                         'data-toggle' => 'tooltip',
                                         'title'  => 'Entry EMR / Pemeriksaan']
                                    ) ?>

                                    <?= $this->Html->link(
                                        '<i class="fa fa-clipboard-list"></i> CPPT',
                                        ['action' => 'cppt', $v->id],
                                        ['escape' => false,
                                         'class'  => 'btn btn-xs btn-warning',
                                         'data-toggle' => 'tooltip',
                                         'title'  => 'Catatan Perkembangan Pasien']
                                    ) ?>
                                <?php else: ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-notes-medical"></i> EMR',
                                        ['action' => 'emr', $v->id],
                                        ['escape' => false,
                                         'class'  => 'btn btn-xs btn-default',
                                         'data-toggle' => 'tooltip',
                                         'title'  => 'Lihat EMR']
                                    ) ?>
                                <?php endif; ?>

                                <?php if ($v->status === 'waiting'): ?>
                                    <button type="button"
                                            class="btn btn-xs btn-primary btn-panggil"
                                            data-id="<?= $v->id ?>"
                                            data-toggle="tooltip" title="Panggil Pasien">
                                        <i class="fa fa-bullhorn"></i> Panggil
                                    </button>
                                <?php endif; ?>

                                <?php if (in_array($v->status, ['called', 'in_progress'])): ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fa fa-check"></i> Selesai',
                                        ['action' => 'selesai', $v->id],
                                        ['escape' => false, 'class' => 'btn btn-xs btn-success',
                                         'confirm' => 'Tandai kunjungan ' . h($pName) . ' selesai?',
                                         'data-toggle' => 'tooltip', 'title' => 'Selesaikan']
                                    ) ?>
                                <?php endif; ?>

                                <?php if (!$isDone): ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fa fa-times"></i>',
                                        ['action' => 'batal', $v->id],
                                        ['escape' => false, 'class' => 'btn btn-xs btn-danger',
                                         'confirm' => 'Batalkan kunjungan ' . h($pName) . '?',
                                         'data-toggle' => 'tooltip', 'title' => 'Batalkan']
                                    ) ?>
                                <?php endif; ?>

                                <?php if (!$isDone): ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-edit"></i>',
                                        ['action' => 'edit', $v->id],
                                        ['escape' => false, 'class' => 'btn btn-xs btn-secondary',
                                         'data-toggle' => 'tooltip', 'title' => 'Edit']
                                    ) ?>
                                <?php endif; ?>

                            </div>
                        </td>

                        <!-- No Rekam Medis -->
                        <td class="text-center" style="font-size:11px; color:#6c757d;">
                            <?= h($pCode) ?>
                        </td>

                        <!-- Dokter (ringkas) -->
                        <td style="font-size:11px; color:#495057;" title="<?= h($dName) ?>">
                            <?= h($dShort) ?>
                        </td>

                        <!-- No Registrasi -->
                        <td class="text-center" style="font-size:11px; color:#6c757d;">
                            <?= h($v->registration_no ?? '-') ?>
                        </td>

                        <!-- Nama Pasien -->
                        <td>
                            <div style="font-weight:700; color:#1f2937;"><?= h($pName) ?></div>
                            <?php if (!empty($v->polyclinic_name)): ?>
                                <div style="font-size:10px; color:#9ca3af;">
                                    <i class="fa fa-hospital"></i> <?= h($v->polyclinic_name) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($v->chief_complaint)): ?>
                                <div style="font-size:10px; color:#6b7280; font-style:italic;">
                                    "<?= h(mb_strimwidth($v->chief_complaint, 0, 40, '...')) ?>"
                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- Tgl Masuk -->
                        <td class="text-center" style="font-size:11px;">
                            <?php
                            $vd = $v->visit_date;
                            if (!empty($vd)):
                                $vdStr = is_object($vd) ? $vd->format('d-m-Y') : date('d-m-Y', strtotime((string)$vd));
                            ?>
                                <div style="font-weight:600;"><?= $vdStr ?></div>
                            <?php endif; ?>
                            <?php if (!empty($v->visit_time)): ?>
                                <div style="color:#888; font-size:10px;">
                                    jam <?= h(substr($v->visit_time, 0, 5)) ?>
                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- Poli -->
                        <td class="text-center" style="font-size:11px;">
                            <?php if (!empty($v->polyclinic_name)): ?>
                                <span style="background:#e0f2fe; color:#0369a1;
                                             border-radius:20px; padding:2px 8px;
                                             font-weight:600; font-size:10px;">
                                    <?= h($v->polyclinic_name) ?>
                                </span>
                            <?php else: ?>
                                <span style="color:#d1d5db;">—</span>
                            <?php endif; ?>
                        </td>

                        <!-- Status -->
                        <td class="text-center">
                            <span style="background:<?= $sc['bg'] ?>; color:<?= $sc['color'] ?>;
                                         border-radius:20px; padding:3px 10px;
                                         font-size:11px; font-weight:700;
                                         display:inline-flex; align-items:center; gap:4px;">
                                <span style="width:7px; height:7px; border-radius:50%;
                                             background:<?= $sc['dot'] ?>; display:inline-block;
                                             <?= $v->status === 'called' ? 'animation:blink 1s infinite;' : '' ?>">
                                </span>
                                <?= $sc['label'] ?>
                            </span>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= $this->Krs->paginators() ?>

    </div>
</div>

<style>
.table-outpatient > thead > tr > th {
    background: #1e3a5f !important;
    color: #fff !important;
    border-color: #2d4f7f !important;
    padding: 8px 6px;
    vertical-align: middle;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
}
.table-outpatient > tbody > tr:hover { background:#f0f9ff !important; }
.btn-xs { padding:3px 7px; font-size:11px; line-height:1.5; border-radius:4px; }

.btn-teal {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: #fff;
}
.btn-teal:hover, .btn-teal:focus {
    background-color: #138496;
    border-color: #117a8b;
    color: #fff;
}

@keyframes blink {
    0%, 100% { opacity:1; }
    50%       { opacity:.3; }
}
</style>

<script>
var PANGGIL_URL = '<?= $this->Url->build(['action' => 'panggil']) ?>';
var LIVE_DATA_URL = '<?= $this->Url->build(['action' => 'liveData']) ?>';
var VIEW_URL = '<?= $this->Url->build(['action' => 'view']) ?>';
var EMR_URL = '<?= $this->Url->build(['action' => 'emr']) ?>';
var CPPT_URL = '<?= $this->Url->build(['action' => 'cppt']) ?>';
var EDIT_URL = '<?= $this->Url->build(['action' => 'edit']) ?>';
var SELESAI_URL = '<?= $this->Url->build(['action' => 'selesai']) ?>';
var BATAL_URL = '<?= $this->Url->build(['action' => 'batal']) ?>';

function getCsrfToken() {
    var m = $('meta[name="csrfToken"]').attr('content');
    if (m) return m;
    var inp = $('input[name="_csrfToken"]').first().val();
    if (inp) return inp;
    var cv = '';
    document.cookie.split(';').forEach(function(c) {
        c = c.trim();
        if (c.indexOf('csrfToken=') === 0)
            cv = decodeURIComponent(c.substring('csrfToken='.length));
    });
    return cv;
}

$.ajaxSetup({
    beforeSend: function(xhr) {
        var t = getCsrfToken();
        if (t) xhr.setRequestHeader('X-CSRF-Token', t);
    }
});

// ── Validasi date range ─────────────────────────────────────
$('input[name="date_from"], input[name="date_to"]').on('change', function() {
    var from = $('input[name="date_from"]').val();
    var to   = $('input[name="date_to"]').val();
    if (from && to && to < from) {
        if ($(this).attr('name') === 'date_from') {
            $('input[name="date_to"]').val(from);
        } else {
            $('input[name="date_from"]').val(to);
        }
    }
});

// ── Tombol Panggil ──────────────────────────────────────────
$(document).on('click', '.btn-panggil', function() {
    var $btn = $(this);
    var id   = $btn.data('id');

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

    $.ajax({
        url:      PANGGIL_URL + '/' + id,
        method:   'POST',
        data:     { '_csrfToken': getCsrfToken() },
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                var $row = $btn.closest('tr');
                $row.css('background', '#fffde7');
                $btn.closest('td').find('.btn-panggil').remove();
                $row.find('span[style*="border-radius:20px"]').last()
                    .css({'background':'#cff4fc','color':'#0c5460'})
                    .html('<span style="width:7px;height:7px;border-radius:50%;background:#0dcaf0;display:inline-block;animation:blink 1s infinite;"></span> Dipanggil');
            } else {
                alert(res.message || 'Gagal memanggil pasien.');
                $btn.prop('disabled', false).html('<i class="fa fa-bullhorn"></i> Panggil');
            }
        },
        error: function() {
            alert('Gagal memanggil pasien. Coba lagi.');
            $btn.prop('disabled', false).html('<i class="fa fa-bullhorn"></i> Panggil');
        }
    });
});

// ── Auto-refresh countdown ──────────────────────────────────
function esc(value) {
    return $('<div>').text(value == null || value === '' ? '-' : value).html();
}

function shortDoctor(name) {
    if (!name || name === '-') return '-';
    return name.split(/\s+/).slice(0, 2).join(' ');
}

function statusConfig(status) {
    var cfg = {
        waiting: {label:'Menunggu', bg:'#fff3cd', color:'#856404', dot:'#ffc107'},
        called: {label:'Dipanggil', bg:'#cff4fc', color:'#0c5460', dot:'#0dcaf0'},
        in_progress: {label:'Diperiksa', bg:'#d1ecf1', color:'#0c5460', dot:'#17a2b8'},
        done: {label:'Selesai', bg:'#d4edda', color:'#155724', dot:'#28a745'},
        cancelled: {label:'Batal', bg:'#f8d7da', color:'#721c24', dot:'#dc3545'}
    };
    return cfg[status] || cfg.waiting;
}

function actionUrl(base, id) {
    return base + '/' + id;
}

function renderStatus(status) {
    var sc = statusConfig(status);
    var blink = status === 'called' ? 'animation:blink 1s infinite;' : '';
    return '<span style="background:' + sc.bg + '; color:' + sc.color + '; border-radius:20px; padding:3px 10px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">'
        + '<span style="width:7px; height:7px; border-radius:50%; background:' + sc.dot + '; display:inline-block; ' + blink + '"></span>'
        + sc.label
        + '</span>';
}

function renderActions(row) {
    var isDone = row.status === 'done' || row.status === 'cancelled';
    var html = '<div style="display:flex; gap:2px; justify-content:center; flex-wrap:wrap;">';
    html += '<a href="' + actionUrl(EMR_URL, row.id) + '" class="btn btn-xs ' + (isDone ? 'btn-default' : 'btn-teal') + '"><i class="fa fa-notes-medical"></i> EMR</a>';
    if (!isDone) html += '<a href="' + actionUrl(CPPT_URL, row.id) + '" class="btn btn-xs btn-warning"><i class="fa fa-clipboard-list"></i> CPPT</a>';
    if (row.status === 'waiting') html += '<button type="button" class="btn btn-xs btn-primary btn-panggil" data-id="' + row.id + '"><i class="fa fa-bullhorn"></i> Panggil</button>';
    if (row.status === 'called' || row.status === 'in_progress') html += '<button type="button" class="btn btn-xs btn-success btn-live-post" data-url="' + actionUrl(SELESAI_URL, row.id) + '" data-confirm="Tandai kunjungan ' + esc(row.patient_name) + ' selesai?"><i class="fa fa-check"></i> Selesai</button>';
    if (!isDone) {
        html += '<button type="button" class="btn btn-xs btn-danger btn-live-post" data-url="' + actionUrl(BATAL_URL, row.id) + '" data-confirm="Batalkan kunjungan ' + esc(row.patient_name) + '?"><i class="fa fa-times"></i></button>';
        html += '<a href="' + actionUrl(EDIT_URL, row.id) + '" class="btn btn-xs btn-secondary"><i class="fa fa-edit"></i></a>';
    }
    html += '</div>';
    return html;
}

function renderRows(rows) {
    if (!rows || !rows.length) {
        return '<tr><td colspan="10" style="text-align:center; padding:40px; color:#9ca3af;">'
            + '<div style="font-size:36px; margin-bottom:8px;">&#127973;</div>'
            + '<div style="font-weight:600;">Tidak ada kunjungan untuk periode ini</div>'
            + '<div style="font-size:11px; margin-top:4px;">Tambah kunjungan baru atau ubah filter tanggal</div>'
            + '</td></tr>';
    }

    return rows.map(function(row) {
        var bg = {waiting:'', called:'#fffde7', in_progress:'#e8f4fd', done:'#f0fff4', cancelled:'#fff5f5'}[row.status] || '';
        var poli = row.polyclinic_name
            ? '<span style="background:#e0f2fe; color:#0369a1; border-radius:20px; padding:2px 8px; font-weight:600; font-size:10px;">' + esc(row.polyclinic_name) + '</span>'
            : '<span style="color:#d1d5db;">-</span>';
        var complaint = row.chief_complaint
            ? '<div style="font-size:10px; color:#6b7280; font-style:italic;">"' + esc(row.chief_complaint).substring(0, 40) + '"</div>'
            : '';

        return '<tr style="background:' + bg + ';" data-visit-id="' + row.id + '" data-status="' + esc(row.status) + '">'
            + '<td class="text-center" style="font-weight:800; font-size:16px; color:#1e3a5f;">' + esc(row.queue_number) + '</td>'
            + '<td class="text-center"><a href="' + actionUrl(VIEW_URL, row.id) + '" class="btn btn-xs btn-info"><i class="fa fa-file-medical"></i></a></td>'
            + '<td class="text-center">' + renderActions(row) + '</td>'
            + '<td class="text-center" style="font-size:11px; color:#6c757d;">' + esc(row.patient_medical_record_no) + '</td>'
            + '<td style="font-size:11px; color:#495057;" title="' + esc(row.doctor_name) + '">' + esc(shortDoctor(row.doctor_name)) + '</td>'
            + '<td class="text-center" style="font-size:11px; color:#6c757d;">' + esc(row.registration_no) + '</td>'
            + '<td><div style="font-weight:700; color:#1f2937;">' + esc(row.patient_name) + '</div>'
            + (row.polyclinic_name ? '<div style="font-size:10px; color:#9ca3af;"><i class="fa fa-hospital"></i> ' + esc(row.polyclinic_name) + '</div>' : '')
            + complaint + '</td>'
            + '<td class="text-center" style="font-size:11px;"><div style="font-weight:600;">' + esc(row.visit_date) + '</div>'
            + (row.visit_time ? '<div style="color:#888; font-size:10px;">jam ' + esc(row.visit_time) + '</div>' : '') + '</td>'
            + '<td class="text-center" style="font-size:11px;">' + poli + '</td>'
            + '<td class="text-center">' + renderStatus(row.status) + '</td>'
            + '</tr>';
    }).join('');
}

function currentFilters() {
    return {
        date_from: $('input[name="date_from"]').val(),
        date_to: $('input[name="date_to"]').val(),
        poli: $('input[name="poli"]').val(),
        doctor_id: $('select[name="doctor_id"]').val(),
        status: $('select[name="status"]').val(),
        q: $('input[name="q"]').val()
    };
}

function loadLiveData() {
    $('#icon-refresh').addClass('fa-spin');
    $('#live-status').text('sync');

    $.ajax({
        url: LIVE_DATA_URL,
        method: 'GET',
        data: currentFilters(),
        dataType: 'json',
        success: function(res) {
            Object.keys(res.summary || {}).forEach(function(key) {
                $('[data-summary="' + key + '"]').text(res.summary[key]);
            });
            $('#tbody-visits').html(renderRows(res.rows || []));
            $('#live-status').text(res.server_time || 'aktif');
        },
        error: function() {
            $('#live-status').text('gagal');
        },
        complete: function() {
            $('#icon-refresh').removeClass('fa-spin');
        }
    });
}

$('#btn-refresh').on('click', loadLiveData);
setInterval(loadLiveData, 5000);

$(document).on('click', '.btn-live-post', function() {
    var $btn = $(this);
    var msg = $btn.data('confirm');
    if (msg && !confirm(msg)) return;

    $btn.prop('disabled', true);
    $.ajax({
        url: $btn.data('url'),
        method: 'POST',
        data: { '_csrfToken': getCsrfToken() },
        dataType: 'json',
        success: function(res) {
            if (!res.success) alert(res.message || 'Aksi gagal.');
            loadLiveData();
        },
        error: function() {
            alert('Aksi gagal. Coba lagi.');
            loadLiveData();
        }
    });
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
