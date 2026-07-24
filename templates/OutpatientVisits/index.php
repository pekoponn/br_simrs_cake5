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

$medicalRecordsByRegistration = $medicalRecordsByRegistration ?? [];

$getNoRekamMedis = function ($v) use ($medicalRecordsByRegistration) {
    $mr = !empty($v->registration_id) ? ($medicalRecordsByRegistration[$v->registration_id] ?? null) : null;
    if ($mr && !empty($mr->medical_record_no)) {
        return $mr->medical_record_no;
    }
    return $v->registration_no ?? ($v->patient->code ?? '-');
};

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

        <div class="row m-b-10">
            <?php
            $cards = [
                ['key' => 'total',       'label' => 'Total',       'val' => $summary['total'],       'bg' => '#1e3a5f', 'icon' => 'fa-users'],
                ['key' => 'waiting',     'label' => 'Menunggu',    'val' => $summary['waiting'],     'bg' => '#856404', 'icon' => 'fa-clock'],
                ['key' => 'called',      'label' => 'Dipanggil',   'val' => $summary['called'],      'bg' => '#0c5460', 'icon' => 'fa-bullhorn'],
                ['key' => 'in_progress', 'label' => 'Diperiksa',   'val' => $summary['in_progress'], 'bg' => '#155724', 'icon' => 'fa-stethoscope'],
                ['key' => 'done',        'label' => 'Selesai',     'val' => $summary['done'],        'bg' => '#495057', 'icon' => 'fa-check-circle'],
            ];
            foreach ($cards as $card): ?>
                <div class="col-md-2 col-xs-4" style="padding:0 5px; margin-bottom:8px;">
                    <div style="background:<?= $card['bg'] ?>; color:#fff; border-radius:8px;
                                padding:12px 14px; text-align:center;">
                        <div id="summary-<?= $card['key'] ?>" style="font-size:22px; font-weight:800;"><?= $card['val'] ?></div>
                        <div style="font-size:11px; opacity:.85;">
                            <i class="fa <?= $card['icon'] ?>"></i> <?= $card['label'] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Auto-refresh indicator -->
            <div class="col-md-2 col-xs-4" style="padding:0 5px; margin-bottom:8px;">
                <div class="auto-refresh-card">
                    <div class="auto-refresh-actions">
                        <button type="button"
                                id="btn-refresh"
                                class="btn-auto-refresh"
                                title="Refresh sekarang">
                            <i class="fa fa-sync-alt" id="icon-refresh"></i>
                        </button>

                        <button type="button"
                                id="btn-toggle-auto-refresh"
                                class="btn-auto-refresh btn-auto-refresh-stop"
                                title="Matikan auto refresh">
                            <i class="fa fa-pause" id="icon-auto-refresh-toggle"></i>
                        </button>
                    </div>

                    <div style="font-size:10px; color:#6c757d; margin-top:2px;">
                        <span id="auto-refresh-label">Auto</span>
                        <span id="countdown">30</span>s
                    </div>
                </div>
            </div>
        </div>

       <!-- ── FILTER BAR ── -->
        <div style="background:#f8f9fa; border:1px solid #dee2e6; border-radius:8px;
                    padding:10px 12px; margin-bottom:14px;">
            <?= $this->Form->create(null, ['type' => 'get', 'style' => 'margin:0;']) ?>

            <div class="row" style="display:flex; align-items:flex-end;">

                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-calendar"></i> Dari
                    </label>
                    <input type="date" name="date_from" class="form-control input-sm"
                        value="<?= h($filterDateFrom) ?>">
                </div>

                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-calendar"></i> Sampai
                    </label>
                    <input type="date" name="date_to" class="form-control input-sm"
                        value="<?= h($filterDateTo) ?>">
                </div>

                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-hospital"></i> Poli
                    </label>
                    <select name="poli" class="form-control input-sm">
                        <option value="">Semua Poli</option>

                        <option value="Poli Umum" <?= $filterPoli == 'Poli Umum' ? 'selected' : '' ?>>
                            Poli Umum
                        </option>

                        <option value="Poli Gigi" <?= $filterPoli == 'Poli Gigi' ? 'selected' : '' ?>>
                            Poli Gigi
                        </option>

                        <option value="Poli Anak" <?= $filterPoli == 'Poli Anak' ? 'selected' : '' ?>>
                            Poli Anak
                        </option>

                        <option value="Poli Kandungan" <?= $filterPoli == 'Poli Kandungan' ? 'selected' : '' ?>>
                            Poli Kandungan
                        </option>

                        <option value="Poli Penyakit Dalam" <?= $filterPoli == 'Poli Penyakit Dalam' ? 'selected' : '' ?>>
                            Poli Penyakit Dalam
                        </option>

                        <option value="Poli Mata" <?= $filterPoli == 'Poli Mata' ? 'selected' : '' ?>>
                            Poli Mata
                        </option>

                        <option value="Poli THT" <?= $filterPoli == 'Poli THT' ? 'selected' : '' ?>>
                            Poli THT
                        </option>

                        <option value="Poli Bedah" <?= $filterPoli == 'Poli Bedah' ? 'selected' : '' ?>>
                            Poli Bedah
                        </option>

                        <option value="Poli Saraf" <?= $filterPoli == 'Poli Saraf' ? 'selected' : '' ?>>
                            Poli Saraf
                        </option>

                        <option value="Poli Kulit" <?= $filterPoli == 'Poli Kulit' ? 'selected' : '' ?>>
                            Poli Kulit
                        </option>

                        <option value="Poli Jantung" <?= $filterPoli == 'Poli Jantung' ? 'selected' : '' ?>>
                            Poli Jantung
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-user-md"></i> Dokter
                    </label>
                    <select name="doctor_id" class="form-control input-sm">
                        <option value="">Semua Dokter</option>
                        <?php foreach ($doctors as $did => $dname): ?>
                            <option value="<?= h($did) ?>" <?= (string)$filterDoctor === (string)$did ? 'selected' : '' ?>>
                                <?= h($dname) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-1">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-filter"></i> Status
                    </label>
                    <select name="status" class="form-control input-sm">
                        <option value="">Semua</option>
                        <?php foreach ($statusCfg as $sval => $sc): ?>
                            <option value="<?= h($sval) ?>" <?= $filterStatus === $sval ? 'selected' : '' ?>>
                                <?= h($sc['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-search"></i> Cari
                    </label>
                    <input type="text" name="q" class="form-control input-sm"
                        placeholder="Nama / No reg..."
                        value="<?= h($q ?? '') ?>">
                </div>

                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <div style="display:flex; gap:3px;">
                        <button type="submit" class="btn btn-warning btn-sm" title="Search">
                            <i class="fa fa-search"></i>
                        </button>

                        <a href="<?= $this->Url->build(['action' => 'index']) ?>"
                        class="btn btn-default btn-sm" title="Reset">
                            <i class="fa fa-times"></i>
                        </a>
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
                        <th width="165">Dokter</th>
                        <th width="70">No Reg</th>
                        <th>Nama Pasien</th>
                        <th width="90">Tgl Masuk</th>
                        <th width="90">Poli</th>
                        <th width="110">Ruang</th>
                        <th width="95">Status</th>
                    </tr>
                </thead>
                <tbody id="tbody-visits">
                <?php if (empty($visits) || !count($visits)): ?>
                    <tr>
                        <td colspan="11" style="text-align:center; padding:40px; color:#9ca3af;">
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
                        $pCode  = $v->patient->code ?? '-';
                        $dName  = $v->doctor->doctor_name ?? '-';
                        $roomName = $v->room_name
                            ?? $v->registration->room_name
                            ?? $v->registration->room->room_name
                            ?? $v->registration->room
                            ?? '-';

                        $visitDateText = '-';
                        if (!empty($v->visit_date)) {
                            $visitDateText = is_object($v->visit_date)
                                ? $v->visit_date->format('d-m-Y')
                                : date('d-m-Y', strtotime((string)$v->visit_date));
                        }

                        // ID registrasi untuk membuka halaman E-Order.
                        // Prioritas: registration_id dari outpatient_visit, lalu relasi registration->id,
                        // terakhir fallback memakai nomor registrasi.
                        $orderRegistrationId = $v->registration_id
                            ?? ($v->registration->id ?? null);

                        $orderRegistrationNo = $v->registration_no
                            ?? ($v->registration->registration_no ?? null)
                            ?? ($v->registration->registration_number ?? null);
                    ?>
                    <tr style="background:<?= $rowBg ?>;"
                        data-visit-id="<?= $v->id ?>"
                        data-status="<?= $v->status ?>"
                        data-queue="<?= h($v->queue_number ?? '') ?>"
                        data-poli="<?= h($v->polyclinic_name ?? '') ?>"
                        data-room="<?= h($roomName !== '-' ? $roomName : '') ?>">

                        <!-- No Antri -->
                        <td class="text-center" style="font-weight:800; font-size:16px; color:#1e3a5f;">
                            <?= !empty($v->queue_number) ? h($v->queue_number) : '-' ?>
                        </td>

                        <!-- Resume Medis -->
                        <td class="text-center">
                            <?= $this->Html->link(
                                '<i class="fa fa-file-medical"></i>',
                                ['action' => 'resumeMedis', $v->id],
                                [
                                    'escape' => false,
                                    'class' => 'btn btn-xs btn-info',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Resume Medis'
                                ]
                            ) ?>
                        </td>

                        <!-- ── AKSI ── -->
                        <td class="text-center">
                            <div class="aksi-btn-group" style="display:flex; gap:2px; justify-content:center; flex-wrap:wrap;">

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

                                <?php if ($v->status === 'called'): ?>
                                    <button type="button"
                                            class="btn btn-xs btn-primary btn-panggil"
                                            data-id="<?= $v->id ?>"
                                            data-toggle="tooltip" title="Panggil Lagi">
                                        <i class="fa fa-bullhorn"></i> Panggil Lagi
                                    </button>
                                    <button type="button"
                                            class="btn btn-xs btn-teal btn-datang"
                                            data-id="<?= $v->id ?>"
                                            data-toggle="tooltip" title="Pasien Sudah Datang">
                                        <i class="fa fa-user-check"></i> Sudah Datang
                                    </button>
                                <?php endif; ?>

                                <?php if (!$isDone): ?>
                                    <?php if (!empty($orderRegistrationId)): ?>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-flask"></i> E-Order',
                                            [
                                                'controller' => 'Orders',
                                                'action' => 'form',
                                                $orderRegistrationId,
                                            ],
                                            [
                                                'escape' => false,
                                                'class' => 'btn btn-xs btn-info',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'E-Order Lab / Radiologi / Resep'
                                            ]
                                        ) ?>
                                    <?php elseif (!empty($orderRegistrationNo)): ?>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-flask"></i> E-Order',
                                            [
                                                'controller' => 'Orders',
                                                'action' => 'form',
                                                '?' => ['registration_no' => $orderRegistrationNo],
                                            ],
                                            [
                                                'escape' => false,
                                                'class' => 'btn btn-xs btn-info',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'E-Order Lab / Radiologi / Resep'
                                            ]
                                        ) ?>
                                    <?php else: ?>
                                        <button type="button"
                                                class="btn btn-xs btn-danger"
                                                data-toggle="tooltip"
                                                title="No Registrasi tidak ada"
                                                disabled>
                                            <i class="fa fa-exclamation-triangle"></i> E-Order
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </td>

                        <td class="text-center" style="font-size:11px; color:#6c757d;">
                            <?= h($getNoRekamMedis($v)) ?>
                        </td>

                        <td style="font-size:11px; color:#495057; white-space:normal; min-width:165px;" title="<?= h($dName) ?>">
                            <div style="font-weight:700; color:#1f2937; line-height:1.25;">
                                <?= h($dName) ?>
                            </div>
                        </td>

                        <td class="text-center" style="font-size:11px; color:#6c757d;">
                            <?= h($v->registration_no ?? '-') ?>
                        </td>

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

                        <td class="text-center" style="font-size:11px; white-space:normal; min-width:110px;">
                            <?php if (!empty($roomName) && $roomName !== '-'): ?>
                                <span style="background:#f3f4f6; color:#374151;
                                             border-radius:20px; padding:2px 8px;
                                             font-weight:600; font-size:10px;">
                                    <?= h($roomName) ?>
                                </span>
                            <?php else: ?>
                                <span style="color:#d1d5db;">—</span>
                            <?php endif; ?>
                        </td>

                        <!-- Status -->
                        <td class="text-center">
                            <span class="status-badge" style="background:<?= $sc['bg'] ?>; color:<?= $sc['color'] ?>;
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

.auto-refresh-card {
    background:#f8f9fa;
    border:1px solid #dee2e6;
    border-radius:8px;
    padding:9px 10px;
    text-align:center;
}
.auto-refresh-actions {
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
}
.btn-auto-refresh {
    width:30px;
    height:26px;
    border:1px solid #d1d5db;
    background:#fff;
    color:#6c757d;
    border-radius:5px;
    padding:0;
    line-height:24px;
    text-align:center;
}
.btn-auto-refresh:hover,
.btn-auto-refresh:focus {
    background:#eef2f7;
    color:#1e3a5f;
}
.btn-auto-refresh-stop {
    color:#dc3545;
}
.btn-auto-refresh-play {
    color:#28a745;
}
.auto-refresh-off {
    background:#fff5f5 !important;
    border-color:#f5c2c7 !important;
}

@keyframes blink {
    0%, 100% { opacity:1; }
    50%       { opacity:.3; }
}
</style>

<script>
var PANGGIL_URL = '<?= $this->Url->build(['action' => 'panggil']) ?>';
var DATANG_URL  = '<?= $this->Url->build(['action' => 'datang']) ?>';

// ── Update kartu ringkasan (Total/Menunggu/Dipanggil/Diperiksa/Selesai) ──────
function bumpSummary(fromKey, toKey) {
    if (fromKey) {
        var $from = $('#summary-' + fromKey);
        var v = parseInt($from.text(), 10) || 0;
        $from.text(Math.max(0, v - 1));
    }
    if (toKey) {
        var $to = $('#summary-' + toKey);
        var v2 = parseInt($to.text(), 10) || 0;
        $to.text(v2 + 1);
    }
}

// ── Suara notifikasi panggilan pasien (chime + Text-to-Speech) ───────────────
function playCallChime() {
    try {
        var ctx = new (window.AudioContext || window.webkitAudioContext)();
        var notes = [880, 1108.73]; // dua nada pendek, mirip nada panggilan
        notes.forEach(function(freq, i) {
            var osc  = ctx.createOscillator();
            var gain = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.value = freq;
            var start = ctx.currentTime + i * 0.22;
            gain.gain.setValueAtTime(0.0001, start);
            gain.gain.exponentialRampToValueAtTime(0.3, start + 0.02);
            gain.gain.exponentialRampToValueAtTime(0.0001, start + 0.2);
            osc.connect(gain).connect(ctx.destination);
            osc.start(start);
            osc.stop(start + 0.22);
        });
    } catch (e) {
        // Web Audio tidak didukung / diblokir browser — abaikan saja
    }
}

// ── Cari suara Bahasa Indonesia yang tersedia di browser ─────────────────────
var idVoice = null;
function loadIndonesianVoice() {
    if (!('speechSynthesis' in window)) return;
    var voices = window.speechSynthesis.getVoices();
    idVoice = voices.find(function(v) { return v.lang === 'id-ID'; })
           || voices.find(function(v) { return v.lang && v.lang.toLowerCase().indexOf('id') === 0; })
           || null;
}
if ('speechSynthesis' in window) {
    loadIndonesianVoice();
    window.speechSynthesis.onvoiceschanged = loadIndonesianVoice;
}

// ── Ucapkan teks lewat Text-to-Speech ─────────────────────────────────────────
function speakText(text) {
    if (!('speechSynthesis' in window) || !text) return;
    try {
        window.speechSynthesis.cancel(); // hentikan antrian suara sebelumnya
        var utter = new SpeechSynthesisUtterance(text);
        utter.lang = 'id-ID';
        if (idVoice) utter.voice = idVoice;
        utter.rate = 0.9;
        utter.pitch = 1;
        window.speechSynthesis.speak(utter);
    } catch (e) {
        // Text-to-Speech tidak didukung — abaikan saja
    }
}

// ── Gabungan: chime lalu ucapkan nomor antrian + poli + ruang ────────────────
function announceQueueCall(queue, poli, room) {
    playCallChime();

    var parts = [];
    parts.push(queue ? ('Nomor antrian ' + queue) : 'Pasien berikutnya');
    if (poli)  parts.push('silakan menuju ' + poli);
    if (room)  parts.push('ruang ' + room);

    var text = parts.join(', ') + '.';

    // Tunggu chime selesai dulu (~0.6 detik) baru suara bicara mulai,
    // biar tidak numpuk sama efek bunyi.
    setTimeout(function() {
        speakText(text);
    }, 600);
}

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

function renderCalledButtons(id) {
    return '<button type="button" class="btn btn-xs btn-primary btn-panggil" data-id="' + id + '" data-toggle="tooltip" title="Panggil Lagi">'
         + '<i class="fa fa-bullhorn"></i> Panggil Lagi</button>'
         + '<button type="button" class="btn btn-xs btn-teal btn-datang" data-id="' + id + '" data-toggle="tooltip" title="Pasien Sudah Datang">'
         + '<i class="fa fa-user-check"></i> Sudah Datang</button>';
}

// ── Tombol Panggil / Panggil Lagi ────────────────────────────
$(document).on('click', '.btn-panggil', function() {
    var $btn  = $(this);
    var id    = $btn.data('id');
    var $row  = $btn.closest('tr');
    var $group = $btn.closest('.aksi-btn-group');
    var originalHtml = $btn.html();

    // Simpan status baris SEBELUM di-overwrite, supaya kita tahu ini klik
    // "Panggil" pertama kali (dari waiting) atau "Panggil Lagi" (sudah called).
    var wasWaiting = $row.attr('data-status') === 'waiting';

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

    $.ajax({
        url:      PANGGIL_URL + '/' + id,
        method:   'POST',
        data:     { '_csrfToken': getCsrfToken() },
        dataType: 'json',
        success: function(res) {
            if (res.success) {

                announceQueueCall(
                    $row.data('queue'),
                    $row.data('poli'),
                    $row.data('room')
                );

                $row.css('background', '#fffde7').attr('data-status', 'called');
                $row.find('.status-badge').css({'background':'#cff4fc','color':'#0c5460'})
                    .html('<span style="width:7px;height:7px;border-radius:50%;background:#0dcaf0;display:inline-block;animation:blink 1s infinite;"></span> Dipanggil');

                // Kartu ringkasan hanya digeser sekali saat transisi waiting → called.
                // Kalau ini "Panggil Lagi" (status sudah called sebelumnya), tidak usah digeser lagi.
                if (wasWaiting) {
                    bumpSummary('waiting', 'called');
                }

                // Normalisasi tombol: selalu jadi "Panggil Lagi" + "Sudah Datang"
                $group.find('.btn-panggil, .btn-datang').remove();
                $group.prepend(renderCalledButtons(id));
            } else {
                alert(res.message || 'Gagal memanggil pasien.');
                $btn.prop('disabled', false).html(originalHtml);
            }
        },
        error: function() {
            alert('Gagal memanggil pasien. Coba lagi.');
            $btn.prop('disabled', false).html(originalHtml);
        }
    });
});

// ── Tombol Pasien Sudah Datang ───────────────────────────────
$(document).on('click', '.btn-datang', function() {
    var $btn   = $(this);
    var id     = $btn.data('id');
    var $row   = $btn.closest('tr');
    var $group = $btn.closest('.aksi-btn-group');

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
    $group.find('.btn-panggil').prop('disabled', true);

    $.ajax({
        url:      DATANG_URL + '/' + id,
        method:   'POST',
        data:     { '_csrfToken': getCsrfToken() },
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                $row.css('background', '#e8f4fd').attr('data-status', 'in_progress');

                $row.find('.status-badge').css({'background':'#d1ecf1','color':'#0c5460'})
                    .html('<span style="width:7px;height:7px;border-radius:50%;background:#17a2b8;display:inline-block;"></span> Diperiksa');

                // Kartu ringkasan: satu pasien pindah dari "Dipanggil" ke "Diperiksa"
                bumpSummary('called', 'in_progress');

                // Pasien sudah diperiksa: tombol panggil & sudah-datang tidak diperlukan lagi
                $group.find('.btn-panggil').remove();
                $group.find('.btn-datang').remove();
            } else {
                alert(res.message || 'Gagal memperbarui status pasien.');
                $btn.prop('disabled', false).html('<i class="fa fa-user-check"></i> Sudah Datang');
                $group.find('.btn-panggil').prop('disabled', false);
            }
        },
        error: function() {
            alert('Gagal memperbarui status pasien. Coba lagi.');
            $btn.prop('disabled', false).html('<i class="fa fa-user-check"></i> Sudah Datang');
            $group.find('.btn-panggil').prop('disabled', false);
        }
    });
});

// ── Auto-refresh countdown ──────────────────────────────────
var countdown = 30;
var autoRefreshActive = true;
var timer = null;

function startAutoRefreshTimer() {
    clearInterval(timer);

    if (!autoRefreshActive) {
        $('#auto-refresh-label').text('Off');
        $('#countdown').text('--');
        return;
    }

    timer = setInterval(function() {
        countdown--;
        $('#countdown').text(countdown);

        if (countdown <= 0) {
            clearInterval(timer);
            location.reload();
        }
    }, 1000);
}

function stopAutoRefreshTimer() {
    autoRefreshActive = false;
    clearInterval(timer);
    $('#auto-refresh-label').text('Off');
    $('#countdown').text('--');
    $('#btn-toggle-auto-refresh')
        .removeClass('btn-auto-refresh-stop')
        .addClass('btn-auto-refresh-play')
        .attr('title', 'Nyalakan auto refresh');
    $('#icon-auto-refresh-toggle')
        .removeClass('fa-pause')
        .addClass('fa-play');
    $('.auto-refresh-card').addClass('auto-refresh-off');
}

function resumeAutoRefreshTimer() {
    autoRefreshActive = true;
    countdown = 30;
    $('#auto-refresh-label').text('Auto');
    $('#countdown').text(countdown);
    $('#btn-toggle-auto-refresh')
        .removeClass('btn-auto-refresh-play')
        .addClass('btn-auto-refresh-stop')
        .attr('title', 'Matikan auto refresh');
    $('#icon-auto-refresh-toggle')
        .removeClass('fa-play')
        .addClass('fa-pause');
    $('.auto-refresh-card').removeClass('auto-refresh-off');
    startAutoRefreshTimer();
}

startAutoRefreshTimer();

$('#btn-toggle-auto-refresh').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();

    if (autoRefreshActive) {
        stopAutoRefreshTimer();
    } else {
        resumeAutoRefreshTimer();
    }
});

$('#btn-refresh').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();

    clearInterval(timer);
    $('#icon-refresh').addClass('fa-spin');
    location.reload();
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>