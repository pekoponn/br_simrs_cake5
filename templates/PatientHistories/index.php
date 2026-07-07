<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $q
 * @var \App\Model\Entity\Patient|null $patient
 * @var iterable $registrations
 * @var array $detailData
 * @var bool $notFound
 */

$q = $q ?? '';
$patient = $patient ?? null;
$registrations = $registrations ?? [];
$registrations = is_array($registrations) ? $registrations : iterator_to_array($registrations);
$detailData = $detailData ?? [];
$notFound = $notFound ?? false;
$patientSearch = $patientSearch ?? '';
$patientResults = $patientResults ?? [];
$patientResults = is_array($patientResults) ? $patientResults : iterator_to_array($patientResults);

$display = function ($value): string {
    if ($value === null || $value === '') {
        return '-';
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return h($value->format('d-m-Y'));
    }
    return h((string)$value);
};

$displayTime = function ($value): string {
    if ($value === null || $value === '') {
        return '-';
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return h($value->format('H:i:s'));
    }
    $time = strtotime((string)$value);
    return $time ? h(date('H:i:s', $time)) : h((string)$value);
};

$rowValues = function ($row): array {
    if (is_object($row) && method_exists($row, 'toArray')) {
        $values = $row->toArray();
    } else {
        $values = is_array($row) ? $row : [];
    }

    if (!empty($values['payload_json'])) {
        $payload = json_decode((string)$values['payload_json'], true);
        if (is_array($payload)) {
            $values = $payload + $values;
        }
    }
    return $values;
};

$findFirstValue = function (array $rows, array $aliases) use ($rowValues) {
    foreach ($rows as $row) {
        $values = $rowValues($row);
        foreach ($aliases as $alias) {
            if (isset($values[$alias]) && $values[$alias] !== null && $values[$alias] !== '') {
                return $values[$alias];
            }
        }
    }
    return null;
};

$getRegDate = function ($registration) {
    return $registration->registration_date ?? $registration->visit_date ?? $registration->created ?? null;
};

$getRegTime = function ($registration) {
    return $registration->admission_time ?? $registration->visit_time ?? null;
};

$getNoPemeriksaan = function ($registration) {
    $visit = $registration->outpatient_visit ?? null;
    return $visit->visit_no
        ?? $visit->registration_no
        ?? $registration->registration_no
        ?? $registration->number
        ?? $registration->code
        ?? ('REG-' . ($registration->id ?? ''));
};

$getPoli = function ($registration) {
    $visit = $registration->outpatient_visit ?? null;
    return $visit->polyclinic_name
        ?? $registration->polyclinic_name
        ?? $registration->room_name
        ?? $registration->class_name
        ?? '-';
};

$getDoctor = function ($registration) {
    return $registration->doctor->doctor_name
        ?? $registration->doctor->name
        ?? $registration->doctor_name
        ?? '-';
};

$genderText = function ($gender): string {
    $gender = strtolower((string)$gender);
    if (in_array($gender, ['male', 'm', 'l', 'laki-laki', 'pria'], true)) {
        return 'Pria';
    }
    if (in_array($gender, ['female', 'f', 'p', 'perempuan', 'wanita'], true)) {
        return 'Wanita';
    }
    return $gender !== '' ? ucfirst($gender) : '-';
};

$formatIcdItems = function ($items): string {
    if (!is_array($items)) {
        return (string)$items;
    }
    $lines = [];
    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }
        $code = trim((string)($item['kode'] ?? $item['code'] ?? ''));
        $name = trim((string)($item['nama'] ?? $item['name'] ?? ''));
        if ($code === '' && $name === '') {
            continue;
        }
        $lines[] = trim($code . ($code !== '' && $name !== '' ? ' - ' : '') . $name);
    }
    return implode("\n", $lines);
};

$renderEmpty = function ($text = 'Data belum tersedia') {
    echo '<div class="history-empty">' . h($text) . '</div>';
};

$renderSoap = function (array $rows) use ($findFirstValue, $formatIcdItems, $renderEmpty) {
    if (empty($rows)) {
        $renderEmpty();
        return;
    }

    $items = [
        'Keluhan Awal' => ['chief_complaint', 'keluhan_awal', 'complaint', 'keluhan', 'subjective'],
        'Pemeriksaan' => ['objective', 'pemeriksaan', 'examination', 'illness_history', 'physical_examination', 'note'],
        'Diagnosa' => ['assessment', 'diagnosis_primary', 'diagnosis_secondary', 'diagnosa', 'diagnosis'],
        'Saran / Anjuran' => ['plan', 'doctor_notes', 'saran', 'anjuran', 'therapy', 'terapi'],
        'Diagnosa / ICD10' => ['icd10_items', 'icd10', 'icd10_code', 'diagnosis_code'],
        'Tindakan / ICD-9 CM' => ['icd9_items', 'icd9', 'icd9_code', 'action_notes'],
    ];
    $vitals = [
        'TD' => ['blood_pressure', 'tekanan_darah'],
        'Nadi' => ['pulse', 'nadi'],
        'RR' => ['respiratory_rate', 'pernapasan'],
        'Suhu' => ['temperature', 'suhu'],
        'SpO2' => ['oxygen_saturation', 'spo2'],
        'BB' => ['weight', 'berat_badan'],
        'TB' => ['height', 'tinggi_badan'],
    ];

    echo '<div class="soap-box">';
    echo '<div class="soap-title">Tanda Vital</div><div class="soap-body">';
    $hasVital = false;
    foreach ($vitals as $label => $aliases) {
        $value = $findFirstValue($rows, $aliases);
        if ($value !== null && $value !== '') {
            $hasVital = true;
            echo '<span class="vital-chip">' . h($label) . ': ' . h((string)$value) . '</span>';
        }
    }
    if (!$hasVital) {
        echo '<span class="text-muted">Data belum tersedia</span>';
    }
    echo '</div>';

    foreach ($items as $title => $aliases) {
        $value = $findFirstValue($rows, $aliases);
        if (is_array($value)) {
            $value = $formatIcdItems($value);
        }
        echo '<div class="soap-title">' . h($title) . '</div>';
        echo '<div class="soap-body">' . (($value === null || $value === '') ? '<span class="text-muted">Data belum tersedia</span>' : nl2br(h((string)$value))) . '</div>';
    }
    echo '</div>';
};

$renderGenericTable = function (array $rows, array $columns) use ($rowValues, $renderEmpty) {
    if (empty($rows)) {
        $renderEmpty();
        return;
    }
    echo '<div class="history-table-scroll"><table class="table table-bordered table-hover table-condensed history-detail-table"><thead><tr>';
    foreach ($columns as $title => $aliases) {
        echo '<th>' . h($title) . '</th>';
    }
    echo '</tr></thead><tbody>';
    foreach ($rows as $row) {
        $values = $rowValues($row);
        echo '<tr>';
        foreach ($columns as $title => $aliases) {
            $value = null;
            foreach ((array)$aliases as $alias) {
                if (isset($values[$alias]) && $values[$alias] !== null && $values[$alias] !== '') {
                    $value = $values[$alias];
                    break;
                }
            }
            if (is_object($value) && method_exists($value, 'format')) {
                $value = $value->format('d-m-Y H:i');
            }
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
            echo '<td>' . (($value === null || $value === '') ? '-' : nl2br(h((string)$value))) . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>';
};

$patientCode = $patient ? ($patient->code ?? null) : null;
?>

<?= $this->Krs->breadcrumb('Medical Record', 'Riwayat Pasien') ?>

<style>
.mr-wrap{font-size:12px;}
.mr-titlebar{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
.mr-titlebar h4{margin:0;font-weight:700;color:#1e3a5f;font-size:16px;}
.mr-panel{border:1px solid #ddd;background:#fff;margin-bottom:10px;}
.mr-panel-heading{padding:8px 12px;background:#1e3a5f;color:#fff;font-weight:700;font-size:12px;}
.mr-panel-body{padding:8px;background:#f8f9fa;}
.mr-search-results{display:none;margin-top:6px;border:1px solid #ddd;border-radius:4px;background:#fff;max-height:230px;overflow-y:auto;font-size:11px;z-index:999;}
.mr-search-item{padding:6px 8px;border-bottom:1px solid #eee;cursor:pointer;color:#333;}
.mr-search-item:hover,.mr-search-item.active{background:#dbeafe;}
.mr-search-item strong{color:#1e3a5f;display:block;}
.mr-search-item small{color:#666;display:block;line-height:1.35;}
.mr-layout{display:grid;grid-template-columns:310px minmax(0,1fr);gap:10px;}
.mr-history-table{font-size:11px;margin:0;background:#fff;}
.mr-history-table th{background:#e9ecef;color:#1e3a5f;font-weight:700;border:1px solid #ddd!important;padding:6px!important;}
.mr-history-table td{border:1px solid #ddd!important;padding:6px!important;vertical-align:middle!important;}
.mr-history-row{cursor:pointer;}
.mr-history-row.active td{background:#1e3a5f!important;color:#fff!important;}
.mr-history-row.active strong{color:#fff!important;}
.mr-head .panel-heading{padding:8px 12px;background:#1e3a5f;color:#fff;font-size:12px;font-weight:700;}
.mr-head .panel-body{padding:10px 12px;background:#f8f9fa;}
.mr-head label{font-size:11px;margin-bottom:3px;color:#333;font-weight:700;}
.mr-head .form-control[readonly]{background:#fff;cursor:default;}
.mr-tabs.panel{border:1px solid #ddd;}
.mr-tabs .panel-heading{padding:0;background:#1e3a5f;overflow:hidden;}
.mr-tabs .nav-tabs{border-bottom:0;margin:0;display:flex;width:100%;background:#1e3a5f;}
.mr-tabs .nav-tabs>li{float:none;display:flex;flex:1 1 0;text-align:center;margin:0;}
.mr-tabs .nav-tabs>li>a{display:flex;align-items:center;justify-content:center;width:100%;min-height:38px;font-size:12px;font-weight:700;color:#fff!important;padding:8px 10px;border-radius:0;margin-right:0;border:0;border-right:1px solid rgba(255,255,255,.25);background:#1e3a5f;text-decoration:none;white-space:nowrap;}
.mr-tabs .nav-tabs>li>a:hover{background:#2b4f7f;color:#fff!important;border:0;border-right:1px solid rgba(255,255,255,.25);}
.mr-tabs .nav-tabs>li.active>a,.mr-tabs .nav-tabs>li.active>a:hover,.mr-tabs .nav-tabs>li.active>a:focus{background:#2f80d8!important;color:#fff!important;border:0;border-right:1px solid rgba(255,255,255,.25);box-shadow:inset 0 -3px 0 rgba(255,255,255,.65);}
.mr-tabs .panel-body{padding:8px 10px;min-height:350px;margin:10px;overflow:hidden;background:#fff;}
.detail-panel{display:none;}
.detail-panel.active{display:block;}
.detail-heading{display:flex;justify-content:space-between;gap:10px;margin-bottom:8px;padding:6px 8px;background:#f8f9fa;border:1px solid #ddd;}
.detail-heading strong{color:#1e3a5f;}
.soap-box{border:1px solid #ddd;background:#fff;}
.soap-title{background:#dbeafe;border-top:1px solid #ddd;border-bottom:1px solid #ddd;padding:6px 8px;font-weight:700;color:#1e3a5f;}
.soap-title:first-child{border-top:0;}
.soap-body{min-height:42px;padding:8px;line-height:1.45;}
.vital-chip{display:inline-block;background:#edf4ff;border:1px solid #b8c8e6;border-radius:2px;padding:4px 7px;margin:2px 4px 2px 0;font-weight:700;}
.history-empty{padding:25px 14px;border:1px dashed #ccc;background:#fafafa;color:#777;text-align:center;font-weight:700;}
.history-detail-table{width:100%;margin:0;background:#fff;font-size:11px;}
.history-detail-table th{background:#dbeafe;color:#1e3a5f;text-align:center;font-weight:700;border:1px solid #ddd!important;padding:6px!important;}
.history-detail-table td{border:1px solid #ddd!important;padding:6px!important;}
.history-table-scroll{overflow:auto;max-height:430px;}
.patient-modal .modal-dialog{width:1120px;max-width:96%;}
.patient-modal .modal-content{border:2px solid #1e3a5f;border-radius:0;background:#d7e2f6;}
.patient-modal .modal-header{padding:6px 10px;background:#1e3a5f;color:#fff;border-bottom:1px solid #10283f;}
.patient-modal .modal-title{font-size:13px;font-weight:700;}
.patient-modal .modal-body{padding:10px;background:#dce6f8;}
.patient-modal .modal-footer{padding:8px 10px;background:#1e3a5f;border-top:1px solid #10283f;}
.patient-modal-filter{display:grid;grid-template-columns:95px 1fr;gap:6px;align-items:center;margin-bottom:8px;}
.patient-modal-filter label{margin:0;font-size:12px;font-weight:700;color:#1f355b;}
.patient-modal-table-wrap{height:330px;overflow:auto;border:1px solid #6f8ebc;background:#fff;}
.patient-modal-table{width:100%;margin:0;background:#fff;}
.patient-modal-table th,.patient-modal-table td{border:1px solid #9eaac0!important;padding:4px 6px!important;font-size:12px!important;white-space:nowrap;}
.patient-modal-table th{background:#c7d2e7;color:#1d2f57;text-align:center;}
.patient-modal-table tr:hover td{background:#dbeafe!important;}
.patient-modal-table .selected-row td{background:#2f6fd4!important;color:#fff!important;}
.patient-pilih-link{display:block;color:inherit;text-decoration:none;}
.patient-pilih-link:hover{text-decoration:none;color:inherit;}
@media(max-width:1200px){.mr-layout{grid-template-columns:1fr;}.mr-tabs .panel-body{margin:0;}}
</style>

<div class="mr-wrap">
    <div class="mr-titlebar">
        <h4><i class="fa fa-history"></i> Riwayat Pasien</h4>
    </div>

    <?php if ($q !== '' && $notFound): ?>
        <div class="alert alert-warning">Pasien dengan kode / nama <strong><?= h($q) ?></strong> tidak ditemukan.</div>
    <?php endif; ?>

    <div class="mr-layout">
        <div class="mr-left">
            <div class="mr-panel">
                <div class="mr-panel-heading"><i class="fa fa-search"></i> Cari Pasien</div>
                <div class="mr-panel-body">
                    <button type="button" class="btn btn-primary btn-sm btn-block btn-open-patient-modal" data-toggle="modal" data-target="#modalCariPasien">
                        <i class="fa fa-search"></i> Buka Modal Cari Pasien
                    </button>
                    <div style="font-size:11px;color:#777;margin-top:6px;line-height:1.4;">
                        Pencarian pasien tetap memakai modal. Ketik kode pasien / nama / NIK / telepon / alamat, hasil langsung muncul di bawah.
                    </div>
                </div>
            </div>

            <div class="mr-panel">
                <div class="mr-panel-heading"><i class="fa fa-history"></i> History Pemeriksaan Pasien</div>
                <div class="mr-panel-body" style="padding:0;background:#fff;">
                    <table class="table table-condensed table-hover mr-history-table">
                        <thead>
                            <tr>
                                <th>No Pemeriksaan</th>
                                <th width="82">Tanggal</th>
                                <th width="60">Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($registrations)): ?>
                                <tr>
                                    <td colspan="3" style="text-align:center;color:#aaa;padding:16px;font-size:11px;">
                                        <i class="fa fa-inbox"></i><br>Belum ada history pemeriksaan
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $first = true; ?>
                                <?php foreach ($registrations as $registration): ?>
                                    <tr class="mr-history-row <?= $first ? 'active' : '' ?>" data-history-id="<?= h($registration->id) ?>">
                                        <td><strong><?= h($getNoPemeriksaan($registration)) ?></strong></td>
                                        <td><?= $display($getRegDate($registration)) ?></td>
                                        <td><?= $displayTime($getRegTime($registration)) ?></td>
                                    </tr>
                                    <?php $first = false; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mr-right">
            <div class="panel panel-default mr-head">
                <div class="panel-heading"><i class="fa fa-user"></i> Head Riwayat / Info Patient</div>
                <div class="panel-body">
                    <div class="row" style="margin-bottom:6px;">
                        <div class="col-md-2">
                            <label>Kode Pasien</label>
                            <input type="text" class="form-control input-sm" value="<?= h($patient->code ?? '-') ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Nama Pasien</label>
                            <input type="text" class="form-control input-sm" value="<?= h($patient->full_name ?? '-') ?>" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>No Identitas</label>
                            <input type="text" class="form-control input-sm" value="<?= h($patient->identity_number ?? '-') ?>" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Telephone</label>
                            <input type="text" class="form-control input-sm" value="<?= h($patient->phone_number ?? '-') ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Jenis Kelamin</label>
                            <input type="text" class="form-control input-sm" value="<?= h($genderText($patient->gender ?? null)) ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Tgl Lahir</label>
                            <input type="text" class="form-control input-sm" value="<?= $display($patient->birth_date ?? null) ?>" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Gol. Darah</label>
                            <input type="text" class="form-control input-sm" value="<?= h($patient->blood_type ?? '-') ?>" readonly>
                        </div>
                        <div class="col-md-8">
                            <label>Alamat</label>
                            <input type="text" class="form-control input-sm" value="<?= h($patient->address ?? '-') ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default mr-tabs">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="medical-record-tabs">
                        <li class="active"><a href="#tab-soap" data-toggle="tab" data-tab="soap">SOAP, TANDAVITAL &amp; DIAGNOSA</a></li>
                        <li><a href="#tab-resep" data-toggle="tab" data-tab="resep">RESEP</a></li>
                        <li><a href="#tab-penunjang" data-toggle="tab" data-tab="penunjang">PENUNJANG MEDIS</a></li>
                        <li><a href="#tab-lab" data-toggle="tab" data-tab="laboratorium">LABORATORIUM</a></li>
                        <li><a href="#tab-radio" data-toggle="tab" data-tab="radiologi">RADIOLOGI</a></li>
                        <li><a href="#tab-bedah" data-toggle="tab" data-tab="bedah">TINDAKAN BEDAH</a></li>
                        <li><a href="#tab-integrasi" data-toggle="tab" data-tab="integrasi">FORM INTEGRASI</a></li>
                        <li><a href="#tab-icare" data-toggle="tab" data-tab="icare">ICare</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <?php
                        $tabs = [
                            'soap' => 'tab-soap',
                            'resep' => 'tab-resep',
                            'penunjang' => 'tab-penunjang',
                            'laboratorium' => 'tab-lab',
                            'radiologi' => 'tab-radio',
                            'bedah' => 'tab-bedah',
                            'integrasi' => 'tab-integrasi',
                            'icare' => 'tab-icare',
                        ];
                        foreach ($tabs as $tabName => $tabId):
                        ?>
                            <div id="<?= h($tabId) ?>" class="tab-pane <?= $tabName === 'soap' ? 'active' : '' ?>" data-tab-content="<?= h($tabName) ?>">
                                <?php if (empty($registrations)): ?>
                                    <?php $renderEmpty('Pilih pasien terlebih dahulu atau belum ada riwayat registrasi.'); ?>
                                <?php else: ?>
                                    <?php $firstPanel = true; ?>
                                    <?php foreach ($registrations as $registration): ?>
                                        <?php
                                        $details = $detailData[$registration->id] ?? [];
                                        $PatientHistory = $registration->medical_record ?? null;
                                        $soapRows = [];
                                        if (!empty($PatientHistory)) {
                                            $soapRows[] = $PatientHistory;
                                        }
                                        $soapRows = array_merge($soapRows, $details['examinations'] ?? []);
                                        ?>
                                        <div class="detail-panel <?= $firstPanel ? 'active' : '' ?>" data-panel-history-id="<?= h($registration->id) ?>">
                                            <div class="detail-heading">
                                                <div>
                                                    <strong><?= h($getNoPemeriksaan($registration)) ?></strong><br>
                                                    <small><?= $display($getRegDate($registration)) ?> <?= $displayTime($getRegTime($registration)) ?> | <?= h($getPoli($registration)) ?> | <?= h($getDoctor($registration)) ?></small>
                                                </div>
                                                <div><small>Status: <?= $display($registration->status ?? '-') ?></small></div>
                                            </div>

                                            <?php if ($tabName === 'soap'): ?>
                                                <?php $renderSoap($soapRows); ?>
                                            <?php elseif ($tabName === 'resep'): ?>
                                                <?php $renderGenericTable($details['prescriptions'] ?? [], [
                                                    'No Resep' => ['no_resep', 'prescription_no', 'recipe_no', 'number', 'code'],
                                                    'Tanggal' => ['tgl_resep', 'tanggal_resep', 'prescription_date', 'date', 'created'],
                                                    'Jam' => ['jam', 'prescription_time', 'time'],
                                                    'Dokter' => ['dokter', 'doctor', 'doctor_name', 'nama_dokter'],
                                                    'Detail Obat' => ['detail_obat', 'drug_detail', 'medicine_detail', 'obat', 'items', 'note', 'notes'],
                                                ]); ?>
                                            <?php elseif ($tabName === 'penunjang'): ?>
                                                <div class="soap-title">Laboratorium</div>
                                                <?php $renderGenericTable($details['laboratories'] ?? [], [
                                                    'Pemeriksaan' => ['pemeriksaan', 'jenis_pemeriksaan', 'examination', 'test_name', 'item_name'],
                                                    'Hasil' => ['hasil', 'result', 'result_value', 'nilai', 'note', 'notes'],
                                                    'Satuan' => ['satuan', 'unit'],
                                                    'Nilai Rujukan' => ['nilai_rujukan', 'nilai_normal', 'reference_range', 'normal_value'],
                                                    'Keterangan' => ['keterangan', 'remark', 'status'],
                                                ]); ?>
                                                <br>
                                                <div class="soap-title">Radiologi</div>
                                                <?php $renderGenericTable($details['radiologies'] ?? [], [
                                                    'Pemeriksaan' => ['pemeriksaan', 'jenis_pemeriksaan', 'examination', 'study_name', 'item_name'],
                                                    'Hasil / Kesan' => ['hasil', 'result', 'kesan', 'impression', 'note', 'notes'],
                                                    'Keterangan' => ['keterangan', 'remark', 'status'],
                                                ]); ?>
                                            <?php elseif ($tabName === 'laboratorium'): ?>
                                                <?php $renderGenericTable($details['laboratories'] ?? [], [
                                                    'Pemeriksaan' => ['pemeriksaan', 'jenis_pemeriksaan', 'examination', 'test_name', 'item_name', 'parameter'],
                                                    'Hasil' => ['hasil', 'result', 'result_value', 'nilai', 'note', 'notes'],
                                                    'Satuan' => ['satuan', 'unit'],
                                                    'Nilai Rujukan' => ['nilai_rujukan', 'nilai_normal', 'reference_range', 'normal_value'],
                                                    'Keterangan' => ['keterangan', 'remark', 'status'],
                                                ]); ?>
                                            <?php elseif ($tabName === 'radiologi'): ?>
                                                <?php $renderGenericTable($details['radiologies'] ?? [], [
                                                    'Pemeriksaan' => ['pemeriksaan', 'jenis_pemeriksaan', 'examination', 'study_name', 'item_name'],
                                                    'Hasil / Kesan' => ['hasil', 'result', 'kesan', 'impression', 'note', 'notes'],
                                                    'Keterangan' => ['keterangan', 'remark', 'status'],
                                                ]); ?>
                                            <?php elseif ($tabName === 'bedah'): ?>
                                                <?php $renderGenericTable($details['surgeries'] ?? [], [
                                                    'Tanggal' => ['date', 'surgery_date', 'created'],
                                                    'Tindakan' => ['tindakan', 'action', 'procedure_name', 'name'],
                                                    'Dokter' => ['dokter', 'doctor_name', 'doctor'],
                                                    'Keterangan' => ['note', 'notes', 'remark', 'description'],
                                                ]); ?>
                                            <?php elseif ($tabName === 'integrasi'): ?>
                                                <?php $renderGenericTable($details['integrations'] ?? [], [
                                                    'Tanggal' => ['noted_at', 'date', 'created'],
                                                    'Tenaga Kesehatan' => ['health_worker_name', 'officer_name', 'petugas'],
                                                    'Dokter' => ['doctor_name', 'dokter'],
                                                    'SOAP SBAR' => ['soap_sbar', 'note', 'notes'],
                                                    'Instruksi' => ['instruction', 'instruksi'],
                                                ]); ?>
                                            <?php elseif ($tabName === 'icare'): ?>
                                                <?php $renderGenericTable($details['icares'] ?? [], [
                                                    'Tanggal' => ['date', 'created'],
                                                    'Nomor' => ['number', 'code', 'no_icare'],
                                                    'Keterangan' => ['note', 'notes', 'description', 'remark'],
                                                    'Status' => ['status'],
                                                ]); ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php $firstPanel = false; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade patient-modal" id="modalCariPasien" tabindex="-1" role="dialog" aria-labelledby="modalCariPasienLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalCariPasienLabel"><i class="fa fa-search"></i> Cari pasien</h4>
            </div>
            <div class="modal-body">
                <div class="patient-modal-filter">
                    <label>Cari Pasien</label>
                    <input type="text" id="patient-search-modal-input" class="form-control input-sm" value="<?= h($patientSearch) ?>" placeholder="Ketik kode pasien / nama / NIK / telepon / alamat">
                </div>
                <div class="patient-modal-table-wrap">
                    <table class="patient-modal-table">
                        <thead>
                            <tr>
                                <th width="105">No Pasien</th>
                                <th width="220">Nama Pasien</th>
                                <th width="90">Tgl Lahir</th>
                                <th width="55">J.Kel</th>
                                <th width="260">Alamat</th>
                                <th width="125">Phone</th>
                                <th width="150">No Identitas</th>
                                <th width="120">No. Kartu</th>
                                <th width="70">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="patient-result-body">
                            <?php if ($patientSearch === ''): ?>
                                <tr><td colspan="9" class="text-center text-muted">Ketik kata kunci pasien, hasil langsung muncul di bawah.</td></tr>
                            <?php elseif (empty($patientResults)): ?>
                                <tr><td colspan="9" class="text-center text-muted">Data pasien tidak ditemukan.</td></tr>
                            <?php else: ?>
                                <?php foreach ($patientResults as $rowPatient): ?>
                                    <?php
                                    $rowCode = $rowPatient->code ?? '';
                                    $rowGender = $genderText($rowPatient->gender ?? null);
                                    $rowCard = $rowPatient->card_no
                                        ?? $rowPatient->no_kartu
                                        ?? $rowPatient->insurance_card_no
                                        ?? $rowPatient->bpjs_card_no
                                        ?? $rowPatient->bpjs_number
                                        ?? null;
                                    $selectUrl = $this->Url->build(['action' => 'index', '?' => ['q' => $rowCode]]);
                                    ?>
                                    <tr class="patient-select-row" data-url="<?= h($selectUrl) ?>">
                                        <td><a class="patient-pilih-link" href="<?= h($selectUrl) ?>"><strong><?= $display($rowCode) ?></strong></a></td>
                                        <td><a class="patient-pilih-link" href="<?= h($selectUrl) ?>"><?= $display($rowPatient->full_name ?? null) ?></a></td>
                                        <td><a class="patient-pilih-link" href="<?= h($selectUrl) ?>"><?= $display($rowPatient->birth_date ?? null) ?></a></td>
                                        <td><a class="patient-pilih-link" href="<?= h($selectUrl) ?>"><?= h(substr($rowGender, 0, 1)) ?></a></td>
                                        <td><a class="patient-pilih-link" href="<?= h($selectUrl) ?>"><?= $display($rowPatient->address ?? null) ?></a></td>
                                        <td><a class="patient-pilih-link" href="<?= h($selectUrl) ?>"><?= $display($rowPatient->phone_number ?? null) ?></a></td>
                                        <td><a class="patient-pilih-link" href="<?= h($selectUrl) ?>"><?= $display($rowPatient->identity_number ?? null) ?></a></td>
                                        <td><a class="patient-pilih-link" href="<?= h($selectUrl) ?>"><?= $display($rowCard) ?></a></td>
                                        <td class="text-center"><a href="<?= h($selectUrl) ?>" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> Pilih</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="btn-modal-ok"><i class="fa fa-check"></i> Ok</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var activeHistoryId = document.querySelector('.mr-history-row.active') ? document.querySelector('.mr-history-row.active').getAttribute('data-history-id') : null;

    function showHistory(historyId) {
        activeHistoryId = historyId;
        document.querySelectorAll('.mr-history-row').forEach(function (row) {
            row.classList.toggle('active', row.getAttribute('data-history-id') === historyId);
        });
        document.querySelectorAll('.detail-panel').forEach(function (panel) {
            panel.classList.toggle('active', panel.getAttribute('data-panel-history-id') === historyId);
        });
    }

    document.querySelectorAll('.mr-history-row').forEach(function (row) {
        row.addEventListener('click', function () {
            showHistory(row.getAttribute('data-history-id'));
        });
    });

    function escapeHtml(text) {
        return String(text || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function bindPatientRows() {
        document.querySelectorAll('.patient-select-row').forEach(function (row) {
            row.addEventListener('click', function () {
                document.querySelectorAll('.patient-select-row').forEach(function (otherRow) {
                    otherRow.classList.remove('selected-row');
                });
                row.classList.add('selected-row');
                selectedPatientUrl = row.getAttribute('data-url');
            });
            row.addEventListener('dblclick', function () {
                var url = row.getAttribute('data-url');
                if (url) { window.location.href = url; }
            });
        });
    }

    var selectedPatientUrl = null;
    bindPatientRows();

    document.querySelectorAll('.btn-open-patient-modal').forEach(function (button) {
        button.addEventListener('click', function () {
            if (window.jQuery && jQuery.fn.modal) {
                jQuery('#modalCariPasien').modal('show');
                setTimeout(function () {
                    var input = document.getElementById('patient-search-modal-input');
                    if (input) { input.focus(); input.select(); }
                }, 300);
            }
        });
    });

    var okButton = document.getElementById('btn-modal-ok');
    if (okButton) {
        okButton.addEventListener('click', function () {
            if (selectedPatientUrl) {
                window.location.href = selectedPatientUrl;
            } else {
                var firstRow = document.querySelector('.patient-select-row');
                if (firstRow && firstRow.getAttribute('data-url')) {
                    window.location.href = firstRow.getAttribute('data-url');
                }
            }
        });
    }

    function renderPatientRows(rows, term) {
        var tbody = document.getElementById('patient-result-body');
        if (!tbody) { return; }

        if (!term) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">Ketik kata kunci pasien, hasil langsung muncul di bawah.</td></tr>';
            return;
        }

        if (!rows || rows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">Data pasien tidak ditemukan.</td></tr>';
            return;
        }

        var html = '';
        rows.forEach(function (patient) {
            var code = patient.code || '';
            var url = '<?= $this->Url->build(['action' => 'index']) ?>?q=' + encodeURIComponent(code);
            html += '<tr class="patient-select-row" data-url="' + escapeHtml(url) + '">';
            html += '<td><a class="patient-pilih-link" href="' + escapeHtml(url) + '"><strong>' + escapeHtml(code || '-') + '</strong></a></td>';
            html += '<td><a class="patient-pilih-link" href="' + escapeHtml(url) + '">' + escapeHtml(patient.full_name || '-') + '</a></td>';
            html += '<td><a class="patient-pilih-link" href="' + escapeHtml(url) + '">' + escapeHtml(patient.birth_date || '-') + '</a></td>';
            html += '<td><a class="patient-pilih-link" href="' + escapeHtml(url) + '">' + escapeHtml(patient.gender || '-') + '</a></td>';
            html += '<td><a class="patient-pilih-link" href="' + escapeHtml(url) + '">' + escapeHtml(patient.address || '-') + '</a></td>';
            html += '<td><a class="patient-pilih-link" href="' + escapeHtml(url) + '">' + escapeHtml(patient.phone_number || '-') + '</a></td>';
            html += '<td><a class="patient-pilih-link" href="' + escapeHtml(url) + '">' + escapeHtml(patient.identity_number || '-') + '</a></td>';
            html += '<td><a class="patient-pilih-link" href="' + escapeHtml(url) + '">' + escapeHtml(patient.card_no || '-') + '</a></td>';
            html += '<td class="text-center"><a href="' + escapeHtml(url) + '" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> Pilih</a></td>';
            html += '</tr>';
        });

        tbody.innerHTML = html;
        bindPatientRows();
    }

    var patientSearchTimer = null;
    var patientSearchRequest = null;

    function liveSearchPatients() {
        var input = document.getElementById('patient-search-modal-input');
        if (!input) { return; }

        var term = input.value.trim();
        if (term === '') {
            renderPatientRows([], '');
            return;
        }

        var tbody = document.getElementById('patient-result-body');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i> Mencari pasien...</td></tr>';
        }

        if (patientSearchRequest && patientSearchRequest.abort) {
            patientSearchRequest.abort();
        }

        var url = '<?= $this->Url->build(['action' => 'searchPatients']) ?>?term=' + encodeURIComponent(term) + '&limit=50';

        if (window.jQuery) {
            patientSearchRequest = jQuery.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    renderPatientRows(response && response.data ? response.data : [], term);
                },
                error: function (xhr, status) {
                    if (status !== 'abort') { renderPatientRows([], term); }
                }
            });
        } else {
            fetch(url)
                .then(function (response) { return response.json(); })
                .then(function (response) { renderPatientRows(response && response.data ? response.data : [], term); })
                .catch(function () { renderPatientRows([], term); });
        }
    }

    var modalInput = document.getElementById('patient-search-modal-input');
    if (modalInput) {
        modalInput.addEventListener('input', function () {
            clearTimeout(patientSearchTimer);
            patientSearchTimer = setTimeout(liveSearchPatients, 250);
        });
        modalInput.addEventListener('keyup', function () {
            clearTimeout(patientSearchTimer);
            patientSearchTimer = setTimeout(liveSearchPatients, 250);
        });
    }
})();
</script>