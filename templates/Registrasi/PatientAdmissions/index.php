<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $admissions
 * @var string $dataSource
 * @var string $tab
 * @var string|null $q
 * @var string|null $dateFrom
 * @var string|null $dateTo
 * @var string|null $petugas
 */

$tab = $tab ?? 'jkn';
$dataSource = $dataSource ?? 'registrations';
$q = $q ?? '';
$dateFrom = $dateFrom ?? date('Y-m-d');
$dateTo = $dateTo ?? date('Y-m-d');
$petugas = $petugas ?? 'GR';

$rows = is_array($admissions) ? $admissions : iterator_to_array($admissions);
$totalRows = count($rows);

$displayDate = function ($value, string $format = 'd-m-Y') {
    if ($value === null || $value === '') {
        return '-';
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return h($value->format($format));
    }
    $time = strtotime((string)$value);
    return $time ? h(date($format, $time)) : h((string)$value);
};

$displayDateTime = function ($date, $time = null) use ($displayDate) {
    $text = $displayDate($date, 'd-m-Y');
    if (!empty($time)) {
        if (is_object($time) && method_exists($time, 'format')) {
            return $text . '<br><small>Jam ' . h($time->format('H:i')) . ' WIB</small>';
        }
        $parsed = strtotime((string)$time);
        return $text . '<br><small>Jam ' . h($parsed ? date('H:i', $parsed) : substr((string)$time, 0, 5)) . ' WIB</small>';
    }
    return $text;
};

$getNoReg = function ($r) {
    return $r->registration_no
        ?? $r->registration->registration_no
        ?? $r->registration->registration_number
        ?? $r->registration_number
        ?? $r->number
        ?? ('REG-' . ($r->id ?? ''));
};
$getRm = function ($r) {
    return $r->patient->code
        ?? $r->registration->patient->code
        ?? $r->patient_code
        ?? $r->rm_no
        ?? '';
};
$getPatientName = function ($r) {
    return $r->patient->full_name
        ?? $r->registration->patient->full_name
        ?? $r->patient_name
        ?? '';
};
$getPhone = function ($r) {
    return $r->patient->phone_number
        ?? $r->registration->patient->phone_number
        ?? $r->phone_number
        ?? '';
};
$getDoctor = function ($r) {
    return $r->doctor->doctor_name
        ?? $r->doctor->name
        ?? $r->registration->doctor->doctor_name
        ?? $r->registration->doctor->name
        ?? $r->doctor_name
        ?? '';
};
$getPayment = function ($r) {
    $payment = $r->payment_method
        ?? $r->registration->payment_method
        ?? '';
    $insurance = $r->insurance_type
        ?? $r->registration->insurance_type
        ?? $r->insurance_category
        ?? $r->registration->insurance_category
        ?? '';
    if ($payment !== '' && $insurance !== '') {
        return $payment . ' - ' . $insurance;
    }
    return $payment !== '' ? $payment : $insurance;
};
$getBirth = function ($r) use ($displayDate) {
    return $displayDate($r->patient->birth_date ?? $r->registration->patient->birth_date ?? null, 'd-m-Y');
};
$getFather = function ($r) {
    return $r->patient->father_name ?? $r->registration->patient->father_name ?? '';
};
$getSpouse = function ($r) {
    return $r->patient->spouse_name ?? $r->registration->patient->spouse_name ?? '';
};
$getGender = function ($r) {
    $gender = strtolower(trim((string)($r->patient->gender ?? $r->registration->patient->gender ?? '')));
    if (in_array($gender, ['l', 'male', 'laki-laki', 'lakilaki', 'pria'], true)) {
        return ['L', '#cfefff'];
    }
    if (in_array($gender, ['p', 'female', 'perempuan', 'wanita'], true)) {
        return ['P', '#ffd6ec'];
    }
    return ['-', '#ffffff'];
};
$getUsername = function ($r) {
    return $r->created_by ?? $r->username ?? $r->user_name ?? '';
};
$getUnit = function ($r) {
    return $r->polyclinic_name
        ?? $r->registration->polyclinic_name
        ?? $r->room_name
        ?? $r->registration->room_name
        ?? '';
};
$getRoom = function ($r) {
    return $r->room_name
        ?? $r->registration->room_name
        ?? $r->registration->room->room_name
        ?? $r->room->room_name
        ?? $r->room->name
        ?? '';
};
$getBed = function ($r) {
    return $r->bed->bed_no
        ?? $r->bed->bed_name
        ?? $r->bed->name
        ?? $r->bed_name
        ?? $r->bed_no
        ?? $r->bed_id
        ?? '';
};
$getClass = function ($r) {
    return $r->class_name
        ?? $r->bed->class_name
        ?? $r->room->room_class
        ?? '';
};

$tabs = [
    'jkn' => ['label' => 'JKN REG', 'icon' => 'fa-id-card'],
    'rawat_jalan' => ['label' => 'Instalasi Rawat Jalan', 'icon' => 'fa-stethoscope'],
    'igd' => ['label' => 'Instalasi Gawat Darurat', 'icon' => 'fa-ambulance'],
    'rawat_inap' => ['label' => 'Instalasi Rawat Inap', 'icon' => 'fa-bed'],
    'tutup_sementara' => ['label' => 'Pasien Tutup Sementara', 'icon' => 'fa-pause-circle'],
    'rencana_rawat_inap' => ['label' => 'Pasien Rencana Rawat Inap', 'icon' => 'fa-calendar-check'],
];

$baseUrl = ['prefix' => 'Registrasi', 'controller' => 'PatientAdmissions', 'action' => 'index'];
?>

<?= $this->Krs->breadcrumb('Patient Admissions', 'Pendaftaran Pasien') ?>

<div class="patient-admission patient-admission-index">
    <div class="pa-header">
        <div>
            <h4><i class="fa fa-user-plus"></i> Pendaftaran Pasien</h4>
            <small>Data dipanggil dari instansi Rawat Jalan, IGD, Rawat Inap, dan JKN setelah registrasi.</small>
        </div>
        <button type="button" class="btn btn-default btn-sm" onclick="window.location.reload()">
            <i class="fa fa-sync"></i> Refresh
        </button>
    </div>

    <div class="pa-filter-card">
        <div class="pa-info-row">
            <div><small>Petugas</small><strong><?= h($petugas) ?></strong></div>
            <div><small>Shift</small><strong>0</strong></div>
            <div><small>Jam</small><strong id="pa-clock"><?= date('H:i:s') ?></strong></div>
        </div>

        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'pa-form']) ?>
            <?= $this->Form->hidden('tab', ['value' => $tab]) ?>
            <div class="row" style="display:flex;align-items:flex-end;flex-wrap:wrap;">
                <div class="col-md-2">
                    <label>Cari Pasien</label>
                    <?= $this->Form->select('search_by', [
                        'name' => 'Nama pasien',
                        'rm'   => 'No RM',
                        'reg'  => 'No Registrasi',
                        'bpjs' => 'No BPJS',
                    ], [
                        'id'    => 'search-by',
                        'value' => $this->request->getQuery('search_by', 'name'),
                        'empty' => false,
                        'class' => 'form-control select2Form',
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <?= $this->Form->control('q', ['label' => false, 'value' => $q, 'placeholder' => 'Nama pasien / No RM / No Registrasi / No BPJS', 'class' => 'form-control input-sm']) ?>
                </div>
                <div class="col-md-2">
                    <label>Tanggal Dari</label>
                    <?= $this->Form->control('date_from', [
                        'label' => false,
                        'type' => 'text',
                        'value' => $dateFrom,
                        'class' => 'form-control input-sm datepicker-pa',
                        'autocomplete' => 'off'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <label>Sampai</label>
                    <?= $this->Form->control('date_to', [
                        'label' => false,
                        'type' => 'text',
                        'value' => $dateTo,
                        'class' => 'form-control input-sm datepicker-pa',
                        'autocomplete' => 'off'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Tampilkan</button>
                    <?= $this->Html->link('<i class="fa fa-times"></i>', ['action' => 'index', '?' => ['tab' => $tab]], ['escape' => false, 'class' => 'btn btn-default btn-sm']) ?>
                </div>
            </div>
        <?= $this->Form->end() ?>
    </div>

    <div class="pa-tabs-wrap">
        <ul class="nav nav-tabs pa-tabs">
            <?php foreach ($tabs as $key => $info): ?>
                <li class="<?= $tab === $key ? 'active' : '' ?>">
                    <?= $this->Html->link(
                        '<i class="fa ' . $info['icon'] . '"></i> ' . h($info['label']),
                        $baseUrl + ['?' => ['tab' => $key, 'q' => $q, 'date_from' => $dateFrom, 'date_to' => $dateTo]],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="pa-body-card">
        <div class="pa-table-wrap">
            <table class="table table-bordered pa-table">
                <thead>
                    <?php if ($tab === 'jkn'): ?>
                        <tr>
                            <th>S E P</th><th>Token</th><th>Antrino</th><th>No Rujukan</th><th>NO BPJS</th><th>RM</th><th>Nama Pasien</th><th>NO HP</th><th>Tgl Daftar</th><th>Poli</th><th>Dokter</th><th>Status</th>
                        </tr>
                    <?php elseif ($tab === 'rawat_jalan'): ?>
                        <tr>
                            <th class="pa-col-noantri">No Antri</th><th>Rek Medis</th><th>Dokter</th><th>No Reg</th><th class="pa-col-namapasien">Nama Pasien</th><th>Tgl Masuk</th><th>Poli</th><th>Ruang</th><th>Status</th><th class="pa-col-aksi">Aksi</th>
                        </tr>
                    <?php elseif ($tab === 'igd'): ?>
                        <tr>
                            <th>No Antri</th><th>Resume</th><th>Aksi</th><th>No RM</th><th>No Registrasi</th><th>Nama Pasien</th><th>Gender</th><th>Tgl Masuk</th><th>Tgl Selesai</th><th>Cara Bayar</th><th>Dokter</th>
                        </tr>
                    <?php elseif ($tab === 'rawat_inap' || $tab === 'tutup_sementara'): ?>
                        <tr>
                            <th>No</th><th>No. Registrasi</th><th>No. RM</th><th>Nama Pasien</th><th>Gender</th><th>Tanggal Masuk</th><th>Ruang</th><th>Kelas</th><th>Bed</th><th>Jenis Pasien</th><th>Tanggal Lahir</th><th>Nama Ayah</th><th>Nama Suami/Istri</th><th>Dokter Inap</th><th>Username</th>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <th>Proses</th><th>No. Reg</th><th>Rekmed</th><th>Nama Pasien</th><th>Tgl Masuk</th><th>Unit</th><th>Dokter</th><th>Status</th>
                        </tr>
                    <?php endif; ?>
                </thead>
                <tbody>
                    <?php if ($totalRows === 0): ?>
                        <?php
                        $colspan = 8;
                        if ($tab === 'jkn') {
                            $colspan = 12;
                        } elseif ($tab === 'rawat_jalan') {
                            $colspan = 10;
                        } elseif ($tab === 'igd') {
                            $colspan = 11;
                        } elseif ($tab === 'rawat_inap' || $tab === 'tutup_sementara') {
                            $colspan = 15;
                        }
                        ?>
                        <tr><td colspan="<?= $colspan ?>" class="text-center text-muted" style="padding:28px;">Belum ada data untuk filter ini.</td></tr>
                    <?php else: ?>
                        <?php $i = 1; ?>
                        <?php foreach ($rows as $r): ?>
                            <?php [$genderLabel, $rowColor] = $getGender($r); ?>

                            <?php if ($tab === 'jkn'): ?>
                                <tr>
                                    <td class="text-center"><a href="#" class="btn btn-xs btn-info">SEP</a></td>
                                    <td><?= h($r->polyclinic_queue_id ?? '') ?></td>
                                    <td><?= h($r->queue_no ?? $r->polyclinic_queue->queue_number ?? '') ?></td>
                                    <td><?= h($r->refferal_no ?? $r->reference_type ?? '') ?></td>
                                    <td><?= h($r->insurance_card_no ?? $r->bpjs_nik ?? '') ?></td>
                                    <td><?= h($getRm($r)) ?></td>
                                    <td><strong><?= h($getPatientName($r)) ?></strong></td>
                                    <td><?= h($getPhone($r)) ?></td>
                                    <td><?= $displayDate($r->registration_date ?? null) ?></td>
                                    <td><?= h($getUnit($r)) ?></td>
                                    <td><?= h($getDoctor($r)) ?></td>
                                    <td><span class="label label-default"><?= h($r->status ?? '') ?></span></td>
                                </tr>

                            <?php elseif ($tab === 'rawat_jalan'): ?>
                                <?php
                                $isBelumRegistrasi = ($r->status ?? '') === 'Belum Registrasi';
                                $admissionUrl = $r->_url ?? null;
                                $callQueueId = $r->_call_queue_id ?? null;
                                $callFormId = $callQueueId ? ('call-form-' . $callQueueId) : '';
                                $callCode = $r->queue_number ?? ($r->registration_no ?? '');
                                ?>
                                <?php if ($isBelumRegistrasi && $callQueueId): ?>
                                    <?= $this->Form->create(null, [
                                        'url' => ['prefix' => 'Registrasi', 'controller' => 'PolyclinicQueues', 'action' => 'callQueue', $callQueueId],
                                        'id' => $callFormId,
                                        'style' => 'display:none;',
                                    ]) ?>
                                    <?= $this->Form->end() ?>
                                <?php endif; ?>
                                <tr<?= ($isBelumRegistrasi && $admissionUrl)
                                    ? ' style="cursor:pointer;background:#fff8e6;" onclick="if($(event.target).closest(\'.queue-actions\').length){return;} window.location.href=\'' . h($admissionUrl) . '\';"'
                                    : '' ?>>
                                    <td class="text-center big-queue pa-col-noantri"><?= h($r->queue_number ?? '-') ?></td>
                                    <td><?= h($getRm($r)) ?></td>
                                    <td><?= h($getDoctor($r)) ?></td>
                                    <td><?= h($getNoReg($r) ?: '-') ?></td>
                                    <td class="pa-col-namapasien"><strong><?= h($getPatientName($r)) ?></strong></td>
                                    <td><?= $displayDateTime($r->visit_date ?? null, $r->visit_time ?? null) ?></td>
                                    <td><?= h($r->polyclinic_name ?? '') ?></td>
                                    <td><?= h($r->room_name ?? '') ?></td>
                                    <td>
                                        <span class="label <?= $isBelumRegistrasi ? 'label-warning' : 'label-success' ?>">
                                            <?= h($r->status ?? '') ?>
                                        </span>
                                    </td>
                                    <td class="text-center queue-actions pa-col-aksi">
                                        <?php if ($isBelumRegistrasi): ?>
                                            <?php if ($callQueueId): ?>
                                                <button
                                                    type="button"
                                                    class="btn btn-xs btn-primary btn-panggil-admisi"
                                                    data-queue-code="<?= h($callCode) ?>"
                                                    data-form-id="<?= h($callFormId) ?>">
                                                    <i class="fa fa-bullhorn"></i> Panggil
                                                </button>
                                            <?php else: ?>
                                                <span class="label label-default" title="Belum ada nomor antrian aktif untuk booking ini">
                                                    <i class="fa fa-clock"></i> Menunggu Antrian
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($admissionUrl): ?>
                                                <a href="<?= h($admissionUrl) ?>" class="btn btn-xs btn-success">Lengkapi Registrasi</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php elseif ($tab === 'igd'): ?>
                                <tr style="background:<?= h($rowColor) ?>;">
                                    <td class="text-center big-queue"><?= h($r->queue_no ?? $r->polyclinic_queue->queue_number ?? '-') ?></td>
                                    <td class="text-center"><a href="#" class="btn btn-xs btn-info"><i class="fa fa-file-medical"></i></a></td>
                                    <td class="text-center"><a href="#" class="btn btn-xs btn-teal">EMR</a> <a href="#" class="btn btn-xs btn-warning">CPPT</a> <a href="#" class="btn btn-xs btn-danger">Triase</a></td>
                                    <td><?= h($getRm($r)) ?></td>
                                    <td><?= h($getNoReg($r)) ?></td>
                                    <td><strong><?= h($getPatientName($r)) ?></strong></td>
                                    <td class="text-center"><span class="label label-default"><?= h($genderLabel) ?></span></td>
                                    <td><?= $displayDateTime($r->registration_date ?? null, $r->created ?? null) ?></td>
                                    <td><?= $displayDate($r->modified ?? null, 'd-m-Y H:i') ?></td>
                                    <td><?= h($getPayment($r)) ?></td>
                                    <td><?= h($getDoctor($r)) ?></td>
                                </tr>

                            <?php elseif ($tab === 'rawat_inap' || $tab === 'tutup_sementara'): ?>
                                <tr style="background:<?= h($rowColor) ?>;">
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?= h($getNoReg($r)) ?></td>
                                    <td><?= h($getRm($r)) ?></td>
                                    <td><strong><?= h($getPatientName($r)) ?></strong></td>
                                    <td class="text-center"><span class="label label-default"><?= h($genderLabel) ?></span></td>
                                    <td><?= $displayDateTime($r->registration_date ?? null, $r->created ?? null) ?></td>
                                    <td><?= h($getRoom($r)) ?></td>
                                    <td><?= h($getClass($r)) ?></td>
                                    <td><?= h($getBed($r)) ?></td>
                                    <td><?= h($getPayment($r)) ?></td>
                                    <td><?= $getBirth($r) ?></td>
                                    <td><?= h($getFather($r)) ?></td>
                                    <td><?= h($getSpouse($r)) ?></td>
                                    <td><?= h($getDoctor($r)) ?></td>
                                    <td><?= h($getUsername($r)) ?></td>
                                </tr>

                            <?php else: ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $this->Html->link(
                                            'Proses',
                                            ['prefix' => 'Registrasi', 'controller' => 'Registrations',
                                                'action' => 'add',
                                                '?' => [
                                                    'from_planned_inpatient' => 1,
                                                    'source_registration_id' => $r->id ?? '',
                                                ],
                                            ],
                                            ['class' => 'btn btn-xs btn-info', 'escape' => false]
                                        ) ?>
                                    </td>
                                    <td><?= h($getNoReg($r)) ?></td>
                                    <td><?= h($getRm($r)) ?></td>
                                    <td><strong><?= h($getPatientName($r)) ?></strong></td>
                                    <td><?= $displayDateTime($r->registration_date ?? null, $r->created ?? null) ?></td>
                                    <td><?= h($getUnit($r)) ?></td>
                                    <td><?= h($getDoctor($r)) ?></td>
                                    <td><span class="label label-default"><?= h($r->status ?? '') ?></span></td>
                                </tr>
                            <?php endif; ?>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pa-footer">
            <div class="pa-footer-actions">
                <a href="#" class="btn btn-default btn-sm">Get Jadwal dr HFIS</a>
                <a href="#" class="btn btn-default btn-sm">Jadwal dokter</a>
                <a href="#" class="btn btn-default btn-sm">Surat Kontrol dan SPRI</a>
                <a href="#" class="btn btn-default btn-sm">Dashboard JKN</a>
                <a href="#" class="btn btn-default btn-sm">Antrian Online dan Task</a>
                <a href="#" class="btn btn-default btn-sm">JKN Master</a>
            </div>
            <div class="pa-pagination">
                <?php if (!empty($paCustomPagination)): ?>
                    Halaman <?= h($paCustomPagination['page']) ?> / <?= h($paCustomPagination['pages']) ?>, total <?= h($paCustomPagination['count']) ?> data
                    <?= $this->Html->link('‹', $baseUrl + ['?' => ['tab' => $tab, 'q' => $q, 'date_from' => $dateFrom, 'date_to' => $dateTo, 'page' => max(1, $paCustomPagination['page'] - 1)]], ['class' => 'btn btn-default btn-xs']) ?>
                    <?= $this->Html->link('›', $baseUrl + ['?' => ['tab' => $tab, 'q' => $q, 'date_from' => $dateFrom, 'date_to' => $dateTo, 'page' => min($paCustomPagination['pages'], $paCustomPagination['page'] + 1)]], ['class' => 'btn btn-default btn-xs']) ?>
                <?php else: ?>
                    <?= $this->Paginator->counter(
                        'Halaman {{page}} / {{pages}}, total {{count}} data',
                        ['model' => 'Registrations']
                    ) ?>
                    <?= $this->Paginator->prev('‹', ['class' => 'btn btn-default btn-xs']) ?>
                    <?= $this->Paginator->next('›', ['class' => 'btn btn-default btn-xs']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><!-- /.patient-admission -->
<style>
html, body {
    height: 100%;
}
.patient-admission-index {
    font-size: 12px;
    color: #1e293b;
    display: flex;
    flex-direction: column;
    min-height: calc(90vh - 65px); /* 65px = tinggi topbar biru di atas */
    overflow: hidden; /* jaga-jaga supaya halaman tidak ikut scroll */
}

/* ── Header ── */
.pa-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.pa-header h4 {
    margin: 0;
    font-weight: 800;
    color: #1e3a5f;
}
.pa-header small {
    color: #6b7280;
}

/* ── Filter Card ── */
.pa-filter-card {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 10px;
}
.pa-info-row {
    display: flex;
    gap: 28px;
    margin-bottom: 8px;
}
.pa-info-row small {
    display: block;
    color: #6b7280;
    font-size: 11px;
}
.pa-info-row strong {
    color: #1e3a5f;
}
.pa-form label {
    font-size: 11px;
    color: #555;
    font-weight: 600;
}

/* ── Tabs ── */
.pa-tabs-wrap {
    border: 1px solid #dee2e6;
    border-bottom: none;
    background: #fff;
    border-radius: 6px 6px 0 0;
    overflow: hidden;
}
.pa-tabs {
    display: flex;
    justify-content: space-between;
    margin: 0;
    width: 100%;
}
.pa-tabs > li {
    float: none;
    flex: 1 1 auto;
    text-align: center;
}
.pa-tabs > li > a {
    display: block;
    font-size: 11px;
    font-weight: 700;
    padding: 9px 12px;
    color: #1e3a5f;
    white-space: nowrap;
}
.pa-tabs > li.active > a,
.pa-tabs > li.active > a:hover {
    background: #1e3a5f !important;
    color: #fff !important;
}

.pa-body-card {
    display: flex;
    flex-direction: column;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0 0 6px 6px;
    flex: 1 1 auto;
    min-height: 0;  
}

.pa-table-wrap {
    flex: 1 1 auto;
    overflow: auto;
    background: #fff;
}
.pa-table {
    margin-bottom: 0 !important;
    font-size: 11px;
    min-width: 1200px;
}
.pa-table > thead > tr > th {
    background: #1e3a5f !important;
    color: #fff !important;
    border-color: #2d4f7f !important;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    padding: 6px 5px !important;
}
.pa-table td {
    vertical-align: middle !important;
    white-space: nowrap;
    padding: 4px 5px !important;
    border-color: #9fb6c8 !important;
}
.pa-table tbody tr:hover {
    background: #fff3cd !important;
}
.big-queue {
    font-weight: 800;
    font-size: 16px;
    color: #1e3a5f;
}

/* ── Footer nempel di bawah kartu, bukan fixed/sticky ── */
.pa-footer {
    flex: 0 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 6px;
    flex-wrap: nowrap;
    background: #fff;
    border-top: 1px solid #dee2e6;
    padding: 14px 20px;
}
.pa-footer-actions {
    display: flex;
    gap: 6px;
    flex-wrap: nowrap;
}
.pa-footer-actions > a.btn {
    flex: 0 0 auto;
    white-space: nowrap;
}
.pa-pagination {
    font-size: 11px;
    color: #555;
    display: flex;
    gap: 6px;
    align-items: center;
    flex: 0 0 auto;
    white-space: nowrap;
}

.pa-table > thead > tr > th {
    background: #1e3a5f !important;
    color: #fff !important;
    border-color: #2d4f7f !important;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    padding: 6px 5px !important;
}
.pa-table td {
    vertical-align: middle !important;
    white-space: nowrap;
    padding: 4px 5px !important;
    border-color: #9fb6c8 !important;
}
.pa-table tbody tr:hover {
    background: #fff3cd !important;
}
.big-queue {
    font-weight: 800;
    font-size: 16px;
    color: #1e3a5f;
}
.pa-col-noantri {
    width: 90px;
    text-align: center;
}
.pa-col-namapasien {
    min-width: 240px;
    white-space: normal;
}
.pa-col-aksi {
    width: 190px;
    text-align: center;
    white-space: nowrap;
}

.btn-xs {
    padding: 3px 7px;
    font-size: 11px;
    line-height: 1.5;
    border-radius: 4px;
}

.btn-panggil-admisi.is-calling,
.btn-panggil-admisi:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}
.btn-teal {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: #fff !important;
}

.pa-footer-actions {
    display: flex;
    gap: 6px;
    flex-wrap: nowrap;
}
.pa-footer-actions > a.btn {
    flex: 0 0 auto;
    white-space: nowrap;
}


/* ── Responsive ── */
@media (max-width: 1200px) {
    .pa-header {
        display: block;
    }
    .pa-table-wrap {
        max-height: 430px;
    }
    .pa-footer {
        left: 0;
        flex-wrap: wrap;
        position: static; /* di layar sempit biarkan mengalir normal, tidak fixed */
        box-shadow: none;
    }
    .pa-table-wrap {
        margin-bottom: 10px;
    }
}
</style>

<script>
(function(){
    function tick(){
        var el = document.getElementById('pa-clock');
        if (!el) return;
        var d = new Date();
        el.textContent = String(d.getHours()).padStart(2,'0') + ':' + String(d.getMinutes()).padStart(2,'0') + ':' + String(d.getSeconds()).padStart(2,'0');
    }
    setInterval(tick, 1000);
    tick();
})();
</script>

<script>
$(function () {
    $('.datepicker-pa').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        orientation: 'bottom auto'
    });
});
</script>

<script>
$(function () {
    var idVoice = null;
    function loadIndonesianVoice() {
        if (!('speechSynthesis' in window)) return;
        var voices = window.speechSynthesis.getVoices();
        idVoice = voices.find(function (v) { return v.lang === 'id-ID'; })
               || voices.find(function (v) { return v.lang && v.lang.toLowerCase().indexOf('id') === 0; })
               || null;
    }
    if ('speechSynthesis' in window) {
        loadIndonesianVoice();
        window.speechSynthesis.onvoiceschanged = loadIndonesianVoice;
    }

    function speakText(text, onDone) {
        if (!('speechSynthesis' in window) || !text) {
            if (onDone) onDone();
            return;
        }
        try {
            window.speechSynthesis.cancel();
            var utter = new SpeechSynthesisUtterance(text);
            utter.lang = 'id-ID';
            if (idVoice) utter.voice = idVoice;
            utter.rate = 0.9;
            utter.pitch = 1;
            utter.onend = function () { if (onDone) onDone(); };
            utter.onerror = function () { if (onDone) onDone(); };
            window.speechSynthesis.speak(utter);
        } catch (e) {
            if (onDone) onDone();
        }
    }

    function playCallChime() {
        try {
            var ctx = new (window.AudioContext || window.webkitAudioContext)();
            var notes = [880, 1108.73];
            notes.forEach(function (freq, i) {
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
        } catch (e) {}
    }

    var ADMISSION_DESTINATION = 'admisi satu';
    var CALL_LOCK_DURATION = 7000;
    var isAdmissionCallLocked = false;

    function announceAdmissionCall(queueCode, onDone) {
        playCallChime();
        var text = queueCode
            ? ('Nomor ' + queueCode + ', silakan menuju ' + ADMISSION_DESTINATION + '.')
            : ('Pasien berikutnya, silakan menuju ' + ADMISSION_DESTINATION + '.');
        setTimeout(function () {
            speakText(text, onDone);
        }, 600);
    }

    function lockAdmissionCallButtons() {
        isAdmissionCallLocked = true;
        $('.btn-panggil-admisi')
            .addClass('is-calling')
            .prop('disabled', true)
            .attr('aria-disabled', 'true');
    }

    function unlockAdmissionCallButtons() {
        isAdmissionCallLocked = false;
        $('.btn-panggil-admisi')
            .removeClass('is-calling')
            .prop('disabled', false)
            .removeAttr('aria-disabled');
    }

    $(document).on('click', '.btn-panggil-admisi', function (e) {
        e.preventDefault();

        if (isAdmissionCallLocked) {
            return;
        }

        var $btn = $(this);
        var queueCode = $btn.data('queue-code');
        var formId = $btn.data('form-id');

        if (!confirm('Panggil nomor ' + queueCode + '?')) {
            return;
        }

        lockAdmissionCallButtons();

        var $form = formId ? $('#' + formId) : $();
        var hasSubmitted = false;

        function submitOnce() {
            if (hasSubmitted) return;
            hasSubmitted = true;
            if ($form.length) {
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    dataType: 'text'
                }).fail(function () {
                    console.error('Gagal memanggil nomor antrian.');
                });
            }
        }

        announceAdmissionCall(queueCode, submitOnce);
        setTimeout(submitOnce, 6000);

        setTimeout(unlockAdmissionCallButtons, CALL_LOCK_DURATION);
    });
});
</script>
