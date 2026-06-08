<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 * @var iterable<\App\Model\Entity\Registration> $registrations
 * @var array $detailData
 */

$registrations = is_array($registrations) ? $registrations : iterator_to_array($registrations);
$medicalRecordNo = $patient->medical_record_no ?? $patient->code ?? null;

$display = function ($value): string {
    if ($value === null || $value === '') {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return h($value->format('d-m-Y'));
    }

    return h((string)$value);
};

$formatDateTime = function ($date, $time = null) use ($display): string {
    $dateText = $display($date);
    $timeText = $display($time);

    return $timeText !== '-' ? $dateText . ' / ' . $timeText : $dateText;
};

$serviceLabels = [
    'rawat_jalan' => 'Rawat Jalan',
    'igd' => 'IGD',
    'rawat_inap' => 'Rawat Inap',
];

$rowValues = function ($row): array {
    if (is_object($row) && method_exists($row, 'toArray')) {
        return $row->toArray();
    }

    return is_array($row) ? $row : [];
};

$renderRows = function (array $rows, array $preferred = []) use ($rowValues) {
    if (empty($rows)) {
        echo '<div class="history-empty">Data belum tersedia</div>';
        return;
    }

    echo '<div class="history-list">';
    foreach ($rows as $row) {
        $values = $rowValues($row);
        $fields = !empty($preferred)
            ? array_intersect_key($values, array_flip($preferred))
            : $values;

        $fields = array_filter($fields, function ($value) {
            return $value !== null && $value !== '';
        });

        if (empty($fields) && !empty($preferred)) {
            $fields = array_filter($values, function ($value) {
                return $value !== null && $value !== '';
            });
        }

        if (empty($fields)) {
            echo '<div class="history-empty">Data belum tersedia</div>';
            continue;
        }

        echo '<div class="history-readonly-card">';
        foreach ($fields as $field => $value) {
            if (in_array($field, ['id', 'medical_record_id', 'registration_id', 'created', 'modified', 'deleted'], true)) {
                continue;
            }

            $label = ucwords(str_replace('_', ' ', (string)$field));
            $text = is_object($value) && method_exists($value, 'format') ? $value->format('d-m-Y H:i') : (string)$value;
            echo '<div class="readonly-field">';
            echo '<span>' . h($label) . '</span>';
            echo '<strong>' . h($text) . '</strong>';
            echo '</div>';
        }
        echo '</div>';
    }
    echo '</div>';
};

$collectRows = function (array $keys) use ($registrations, $detailData): array {
    $rows = [];

    foreach ($registrations as $registration) {
        foreach ($keys as $key) {
            foreach (($detailData[$registration->id][$key] ?? []) as $row) {
                $rows[] = $row;
            }
        }
    }

    return $rows;
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

$renderSoapSections = function (array $rows) use ($findFirstValue) {
    $sections = [
        'Keluhan Awal' => [
            'keluhan_awal',
            'initial_complaint',
            'chief_complaint',
            'complaint',
            'keluhan',
            'anamnesis',
            'subjective',
        ],
        'Pemeriksaan' => [
            'pemeriksaan',
            'examination',
            'objective',
            'physical_examination',
            'status_lokalis',
            'clinical_examination',
        ],
        'Diagnosa' => [
            'diagnosa',
            'diagnosis',
            'assessment',
            'clinical_diagnosis',
        ],
        'Saran / Anjuran' => [
            'saran_anjuran',
            'saran',
            'anjuran',
            'advice',
            'recommendation',
            'plan',
            'therapy',
            'terapi',
        ],
        'Diagnosa / ICD10' => [
            'diagnosa_icd10',
            'diagnosis_icd10',
            'icd10',
            'icd10_code',
            'diagnosis_code',
            'kode_diagnosa',
            'diagnosa_kode',
        ],
    ];

    echo '<div class="soap-section-grid">';
    foreach ($sections as $title => $aliases) {
        $value = $findFirstValue($rows, $aliases);
        $text = $value === null || $value === ''
            ? '<span class="text-muted">Data belum tersedia</span>'
            : nl2br(h((string)$value));

        echo '<div class="soap-section">';
        echo '<div class="soap-section-title">' . h($title) . '</div>';
        echo '<div class="soap-section-body">' . $text . '</div>';
        echo '</div>';
    }
    echo '</div>';
};

$renderPrescriptionTable = function (array $rows) use ($findFirstValue) {
    if (empty($rows)) {
        echo '<div class="history-empty">Data belum tersedia</div>';
        return;
    }

    $formatPrescriptionValue = function ($value): string {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_object($value) && method_exists($value, 'format')) {
            return h($value->format('d-m-Y'));
        }

        return h((string)$value);
    };

    echo '<div class="history-table-wrap">';
    echo '<table class="table table-striped table-hover table-td-valign-middle mb-0 prescription-table">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th width="150">No Resep</th>';
    echo '<th width="115">Tgl Resep</th>';
    echo '<th width="95">Jam</th>';
    echo '<th width="180">Dokter</th>';
    echo '<th>Detail Obat</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($rows as $row) {
        $rowSet = [$row];
        $prescriptionNo = $findFirstValue($rowSet, ['no_resep', 'prescription_no', 'recipe_no', 'resep_no', 'nomor_resep', 'number', 'code']);
        $prescriptionDate = $findFirstValue($rowSet, ['tgl_resep', 'tanggal_resep', 'prescription_date', 'recipe_date', 'date', 'created']);
        $prescriptionTime = $findFirstValue($rowSet, ['jam', 'jam_resep', 'prescription_time', 'recipe_time', 'time']);
        $doctor = $findFirstValue($rowSet, ['dokter', 'doctor', 'doctor_name', 'nama_dokter']);
        $drugDetail = $findFirstValue($rowSet, ['detail_obat', 'drug_detail', 'medicine_detail', 'obat', 'medicines', 'items', 'detail', 'description', 'notes']);

        echo '<tr>';
        echo '<td><strong>' . $formatPrescriptionValue($prescriptionNo) . '</strong></td>';
        echo '<td>' . $formatPrescriptionValue($prescriptionDate) . '</td>';
        echo '<td>' . $formatPrescriptionValue($prescriptionTime) . '</td>';
        echo '<td>' . $formatPrescriptionValue($doctor) . '</td>';
        echo '<td><div class="prescription-detail">' . ($drugDetail === null || $drugDetail === '' ? '<span class="text-muted">Data belum tersedia</span>' : nl2br(h((string)$drugDetail))) . '</div></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
};

$renderLaboratoryTable = function (array $rows) use ($findFirstValue) {
    if (empty($rows)) {
        echo '<div class="history-empty">Data belum tersedia</div>';
        return;
    }

    $formatValue = function ($value): string {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_object($value) && method_exists($value, 'format')) {
            return h($value->format('d-m-Y'));
        }

        return h((string)$value);
    };

    echo '<div class="history-table-wrap">';
    echo '<table class="table table-striped table-hover table-td-valign-middle mb-0 support-table">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th width="150">No Lab</th>';
    echo '<th width="115">Tgl Lab</th>';
    echo '<th width="95">Jam</th>';
    echo '<th width="180">Dokter</th>';
    echo '<th width="220">Pemeriksaan</th>';
    echo '<th>Hasil</th>';
    echo '<th width="150">Nilai Normal</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($rows as $row) {
        $rowSet = [$row];
        $labNo = $findFirstValue($rowSet, ['no_lab', 'laboratory_no', 'lab_no', 'nomor_lab', 'number', 'code']);
        $labDate = $findFirstValue($rowSet, ['tgl_lab', 'tanggal_lab', 'laboratory_date', 'lab_date', 'date', 'created']);
        $labTime = $findFirstValue($rowSet, ['jam', 'jam_lab', 'laboratory_time', 'lab_time', 'time']);
        $doctor = $findFirstValue($rowSet, ['dokter', 'doctor', 'doctor_name', 'nama_dokter', 'pengirim']);
        $examination = $findFirstValue($rowSet, ['pemeriksaan', 'jenis_pemeriksaan', 'examination', 'test_name', 'item_name', 'parameter', 'service_name']);
        $result = $findFirstValue($rowSet, ['hasil', 'result', 'result_value', 'nilai', 'description', 'notes']);
        $normalValue = $findFirstValue($rowSet, ['nilai_normal', 'normal_value', 'reference_value', 'reference_range', 'satuan', 'unit']);

        echo '<tr>';
        echo '<td><strong>' . $formatValue($labNo) . '</strong></td>';
        echo '<td>' . $formatValue($labDate) . '</td>';
        echo '<td>' . $formatValue($labTime) . '</td>';
        echo '<td>' . $formatValue($doctor) . '</td>';
        echo '<td>' . $formatValue($examination) . '</td>';
        echo '<td><div class="support-detail">' . ($result === null || $result === '' ? '<span class="text-muted">Data belum tersedia</span>' : nl2br(h((string)$result))) . '</div></td>';
        echo '<td>' . $formatValue($normalValue) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
};

$renderRadiologyTable = function (array $rows) use ($findFirstValue) {
    if (empty($rows)) {
        echo '<div class="history-empty">Data belum tersedia</div>';
        return;
    }

    $formatValue = function ($value): string {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_object($value) && method_exists($value, 'format')) {
            return h($value->format('d-m-Y'));
        }

        return h((string)$value);
    };

    echo '<div class="history-table-wrap">';
    echo '<table class="table table-striped table-hover table-td-valign-middle mb-0 support-table">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th width="150">No Radiologi</th>';
    echo '<th width="115">Tgl Radiologi</th>';
    echo '<th width="95">Jam</th>';
    echo '<th width="180">Dokter</th>';
    echo '<th width="220">Pemeriksaan</th>';
    echo '<th>Hasil / Kesan</th>';
    echo '<th width="160">Keterangan</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($rows as $row) {
        $rowSet = [$row];
        $radiologyNo = $findFirstValue($rowSet, ['no_radiologi', 'radiology_no', 'rad_no', 'nomor_radiologi', 'number', 'code']);
        $radiologyDate = $findFirstValue($rowSet, ['tgl_radiologi', 'tanggal_radiologi', 'radiology_date', 'rad_date', 'date', 'created']);
        $radiologyTime = $findFirstValue($rowSet, ['jam', 'jam_radiologi', 'radiology_time', 'rad_time', 'time']);
        $doctor = $findFirstValue($rowSet, ['dokter', 'doctor', 'doctor_name', 'nama_dokter', 'radiologist', 'pengirim']);
        $examination = $findFirstValue($rowSet, ['pemeriksaan', 'jenis_pemeriksaan', 'examination', 'study_name', 'item_name', 'service_name']);
        $result = $findFirstValue($rowSet, ['hasil', 'result', 'kesan', 'impression', 'description', 'notes']);
        $remark = $findFirstValue($rowSet, ['keterangan', 'remark', 'catatan', 'note', 'status']);

        echo '<tr>';
        echo '<td><strong>' . $formatValue($radiologyNo) . '</strong></td>';
        echo '<td>' . $formatValue($radiologyDate) . '</td>';
        echo '<td>' . $formatValue($radiologyTime) . '</td>';
        echo '<td>' . $formatValue($doctor) . '</td>';
        echo '<td>' . $formatValue($examination) . '</td>';
        echo '<td><div class="support-detail">' . ($result === null || $result === '' ? '<span class="text-muted">Data belum tersedia</span>' : nl2br(h((string)$result))) . '</div></td>';
        echo '<td>' . $formatValue($remark) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
};
?>

<?= $this->Krs->breadcrumb('Medical Record', 'Riwayat Pasien') ?>

<style>
    .history-patient-header {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 16px;
        border: 1px solid #e4e9f0;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 14px;
    }

    .patient-main h3 {
        margin: 0 0 4px;
        color: #2d353c;
        font-size: 20px;
        font-weight: 700;
    }

    .patient-main .rm-code {
        color: #348fe2;
        font-weight: 700;
        letter-spacing: 0;
    }

    .patient-meta-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(110px, 1fr));
        gap: 10px;
        margin-top: 12px;
    }

    .patient-meta-item {
        padding: 10px;
        border: 1px solid #edf1f5;
        border-radius: 8px;
        background: #fbfcfe;
        min-width: 0;
    }

    .patient-meta-item span,
    .readonly-field span {
        display: block;
        color: #6c757d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .patient-meta-item strong,
    .readonly-field strong {
        display: block;
        color: #2d353c;
        font-size: 13px;
        font-weight: 600;
        word-break: break-word;
    }

    .history-card {
        border: 1px solid #e4e9f0;
        border-radius: 8px;
        background: #fff;
        overflow: hidden;
    }

    .history-tabs {
        padding: 10px 12px 0;
        border-bottom: 1px solid #dee2e6;
        background: #fafbfd;
    }

    .history-tabs .nav-link {
        padding: 8px 10px;
        font-size: 12px;
        font-weight: 700;
        color: #495057;
    }

    .history-tab-body {
        padding: 14px;
        min-height: 360px;
    }

    .history-table-wrap {
        overflow: auto;
    }

    .prescription-table th,
    .prescription-table td,
    .support-table th,
    .support-table td {
        vertical-align: top !important;
    }

    .prescription-detail,
    .support-detail {
        max-height: 150px;
        min-height: 44px;
        overflow: auto;
        white-space: normal;
        line-height: 1.5;
    }

    .support-section-title {
        margin: 0 0 10px;
        color: #2d353c;
        font-size: 14px;
        font-weight: 700;
    }

    .support-section + .support-section {
        margin-top: 18px;
    }

    .vital-chip {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 4px;
        background: #f2f3f4;
        color: #495057;
        font-size: 11px;
        margin: 1px;
        white-space: nowrap;
    }

    .soap-workspace {
        display: grid;
        grid-template-columns: minmax(430px, 48%) minmax(0, 1fr);
        gap: 14px;
        align-items: start;
    }

    .soap-visit-list,
    .soap-detail-panel {
        border: 1px solid #e4e9f0;
        border-radius: 8px;
        background: #fff;
        overflow: hidden;
    }

    .soap-panel-header {
        padding: 11px 13px;
        border-bottom: 1px solid #edf1f5;
        background: #fafbfd;
        color: #2d353c;
        font-size: 14px;
        font-weight: 700;
    }

    .soap-visit-row {
        cursor: pointer;
    }

    .soap-visit-row.active td {
        background: #eef7ff;
        border-color: #d6ebff;
    }

    .soap-detail-content {
        display: none;
        padding: 14px;
    }

    .soap-detail-content.active {
        display: block;
    }

    .soap-detail-title {
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid #edf1f5;
    }

    .soap-detail-title h4 {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 700;
    }

    .soap-detail-title small {
        color: #6c757d;
    }

    .soap-section-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .soap-section {
        border: 1px solid #edf1f5;
        border-radius: 8px;
        background: #fbfcfe;
        overflow: hidden;
    }

    .soap-section-title {
        padding: 9px 11px;
        border-bottom: 1px solid #edf1f5;
        background: #f5f7fa;
        color: #2d353c;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .soap-section-body {
        min-height: 48px;
        padding: 11px;
        color: #2d353c;
        font-size: 13px;
        line-height: 1.55;
        word-break: break-word;
    }

    .history-readonly-card {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        padding: 12px;
        border: 1px solid #edf1f5;
        border-radius: 8px;
        background: #fbfcfe;
        margin-bottom: 10px;
    }

    .readonly-field {
        min-width: 0;
    }

    .history-empty {
        padding: 26px 14px;
        border: 1px dashed #ced4da;
        border-radius: 8px;
        background: #fbfcfe;
        color: #6c757d;
        text-align: center;
        font-weight: 600;
    }

    @media (max-width: 991px) {
        .soap-workspace {
            grid-template-columns: 1fr;
        }

        .patient-meta-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575px) {
        .history-patient-header {
            flex-direction: column;
        }

        .patient-meta-grid,
        .history-readonly-card {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-history"></i> Riwayat Pasien</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="history-patient-header">
            <div class="patient-main">
                <div class="rm-code"><?= $display($medicalRecordNo) ?></div>
                <h3><?= $display($patient->full_name ?? null) ?></h3>

                <div class="patient-meta-grid">
                    <div class="patient-meta-item"><span>No Rekam Medis</span><strong><?= $display($medicalRecordNo) ?></strong></div>
                    <div class="patient-meta-item"><span>Kode Pasien</span><strong><?= $display($patient->code ?? null) ?></strong></div>
                    <div class="patient-meta-item"><span>Telephone</span><strong><?= $display($patient->phone_number ?? null) ?></strong></div>
                    <div class="patient-meta-item"><span>Alamat</span><strong><?= $display($patient->address ?? null) ?></strong></div>
                    <div class="patient-meta-item"><span>Jenis Kelamin</span><strong><?= $display($patient->gender ?? null) ?></strong></div>
                    <div class="patient-meta-item"><span>Tanggal Lahir</span><strong><?= $display($patient->birth_date ?? null) ?></strong></div>
                    <!-- <div class="patient-meta-item"><span>Identitas</span><strong><?= $display($patient->identity_number ?? null) ?></strong></div> -->
                </div>
            </div>

            <div>
                <?= $this->Html->link(
                    '<i class="fa fa-arrow-left"></i> Tutup / Kembali',
                    $this->request->referer(true),
                    ['class' => 'btn btn-default', 'escape' => false]
                ) ?>
            </div>
        </div>

        <div class="history-card">
            <ul class="nav nav-tabs history-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-soap-history" role="tab">
                        SOAP, Tanda Vital & Diagnosa
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-prescriptions" role="tab">Resep</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-support" role="tab">Penunjang Medis</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-laboratories" role="tab">Laboratorium</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-radiologies" role="tab">Radiologi</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-surgeries" role="tab">Tindakan Bedah</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-integrations" role="tab">Form Integrasi</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-icares" role="tab">I-Care</a></li>
            </ul>

            <div class="tab-content history-tab-body">
                <div class="tab-pane fade show active" id="tab-soap-history" role="tabpanel">
                    <?php if (count($registrations) === 0): ?>
                        <div class="history-empty">Data belum tersedia</div>
                    <?php else: ?>
                        <div class="soap-workspace">
                            <div class="soap-visit-list">
                                <div class="soap-panel-header">Daftar Riwayat Kunjungan</div>
                                <div class="history-table-wrap">
                                    <table class="table table-striped table-hover table-td-valign-middle mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th width="150">No Kunjungan / No Registrasi</th>
                                                <th width="130">Tanggal/Jam</th>
                                                <th width="135">Layanan/Poli</th>
                                                <th>Dokter</th>
                                                <th width="75">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $first = true; ?>
                                            <?php foreach ($registrations as $registration): ?>
                                                <?php
                                                $serviceLabel = $serviceLabels[$registration->service_type] ?? ($registration->service_type ?: '-');
                                                ?>
                                                <tr class="soap-visit-row <?= $first ? 'active' : '' ?>" data-target="soap-detail-<?= h($registration->id) ?>">
                                                    <td><strong><?= $display($registration->registration_no ?? $registration->registration_number ?? null) ?></strong></td>
                                                    <td><?= $formatDateTime($registration->registration_date ?? null, $registration->admission_time ?? null) ?></td>
                                                    <td>
                                                        <span class="label label-info"><?= h($serviceLabel) ?></span><br>
                                                        <small><?= $display($registration->polyclinic_name ?? $registration->room->room_name ?? null) ?></small>
                                                    </td>
                                                    <td><?= $display($registration->doctor->doctor_name ?? $registration->doctor->name ?? null) ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn-view-soap" data-target="soap-detail-<?= h($registration->id) ?>">
                                                            Lihat
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $first = false; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="soap-detail-panel">
                                <div class="soap-panel-header">SOAP, Tanda Vital & Diagnosa</div>
                                <?php $first = true; ?>
                                <?php foreach ($registrations as $registration): ?>
                                    <?php
                                    $medicalRecord = $registration->medical_record ?? null;
                                    $registrationDetails = $detailData[$registration->id] ?? [];
                                    $serviceLabel = $serviceLabels[$registration->service_type] ?? ($registration->service_type ?: '-');
                                    $soapRows = [];
                                    if (!empty($medicalRecord)) {
                                        $soapRows[] = $medicalRecord;
                                    }
                                    $soapRows = array_merge($soapRows, $registrationDetails['examinations'] ?? []);
                                    ?>
                                    <div class="soap-detail-content <?= $first ? 'active' : '' ?>" id="soap-detail-<?= h($registration->id) ?>">
                                        <div class="soap-detail-title">
                                            <h4><?= $display($registration->registration_no ?? $registration->registration_number ?? null) ?></h4>
                                            <small>
                                                <?= $formatDateTime($registration->registration_date ?? null, $registration->admission_time ?? null) ?>
                                                &nbsp;|&nbsp; <?= h($serviceLabel) ?>
                                                &nbsp;|&nbsp; <?= $display($registration->doctor->doctor_name ?? $registration->doctor->name ?? null) ?>
                                            </small>
                                        </div>

                                        <?php $renderSoapSections($soapRows); ?>
                                    </div>
                                    <?php $first = false; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="tab-pane fade" id="tab-prescriptions" role="tabpanel">
                    <?php $renderPrescriptionTable($collectRows(['prescriptions'])); ?>
                </div>

                <div class="tab-pane fade" id="tab-support" role="tabpanel">
                    <div class="support-section">
                        <h4 class="support-section-title">Laboratorium</h4>
                        <?php $renderLaboratoryTable($collectRows(['laboratories'])); ?>
                    </div>
                    <div class="support-section">
                        <h4 class="support-section-title">Radiologi</h4>
                        <?php $renderRadiologyTable($collectRows(['radiologies'])); ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-laboratories" role="tabpanel">
                    <?php $renderLaboratoryTable($collectRows(['laboratories'])); ?>
                </div>

                <div class="tab-pane fade" id="tab-radiologies" role="tabpanel">
                    <?php $renderRadiologyTable($collectRows(['radiologies'])); ?>
                </div>

                <div class="tab-pane fade" id="tab-surgeries" role="tabpanel">
                    <?php $renderRows($collectRows(['surgeries'])); ?>
                </div>

                <div class="tab-pane fade" id="tab-integrations" role="tabpanel">
                    <?php $renderRows($collectRows(['integrations'])); ?>
                </div>

                <div class="tab-pane fade" id="tab-icares" role="tabpanel">
                    <?php $renderRows($collectRows(['icares'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var items = document.querySelectorAll('.soap-visit-row, .btn-view-soap');
        items.forEach(function (item) {
            item.addEventListener('click', function (event) {
                var targetId = item.getAttribute('data-target');
                var target = document.getElementById(targetId);
                if (!target) {
                    return;
                }

                document.querySelectorAll('.soap-visit-row').forEach(function (row) {
                    row.classList.toggle('active', row.getAttribute('data-target') === targetId);
                });

                document.querySelectorAll('.soap-detail-content').forEach(function (detail) {
                    detail.classList.toggle('active', detail.id === targetId);
                });

                event.stopPropagation();
            });
        });
    })();
</script>
