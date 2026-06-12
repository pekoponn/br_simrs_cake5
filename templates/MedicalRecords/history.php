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

$statusLabels = [
    'waiting' => 'Menunggu',
    'called' => 'Dipanggil',
    'in_progress' => 'Diperiksa',
    'done' => 'Selesai',
    'cancelled' => 'Batal',
];

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

$formatIcdItems = function ($items): string {
    if (!is_array($items)) {
        return (string)$items;
    }

    $lines = [];
    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }

        $code = trim((string)($item['kode'] ?? ''));
        $name = trim((string)($item['nama'] ?? ''));
        if ($code === '' && $name === '') {
            continue;
        }

        $label = trim($code . ($code !== '' && $name !== '' ? ' - ' : '') . $name);
        $lines[] = !empty($item['utama']) ? '* ' . $label : '- ' . $label;
    }

    return implode("\n", $lines);
};

$renderSoapSections = function (array $rows) use ($findFirstValue, $formatIcdItems) {
    $vitals = [
        'Tekanan Darah' => ['blood_pressure', 'tekanan_darah'],
        'Nadi' => ['pulse', 'nadi'],
        'Pernapasan' => ['respiratory_rate', 'respiration', 'pernapasan'],
        'Suhu' => ['temperature', 'suhu'],
        'SpO2' => ['oxygen_saturation', 'spo2'],
        'Berat Badan' => ['weight', 'berat_badan'],
        'Tinggi Badan' => ['height', 'tinggi_badan'],
        'Skala Nyeri' => ['pain_scale', 'skala_nyeri'],
    ];

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
            'illness_history',
            'physical_examination',
            'status_lokalis',
            'clinical_examination',
        ],
        'Diagnosa' => [
            'diagnosa',
            'diagnosis',
            'assessment',
            'admission_diagnosis',
            'diagnosis_primary',
            'diagnosis_secondary',
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
            'doctor_notes',
        ],
        'Diagnosa / ICD10' => [
            'icd10_items',
            'diagnosa_icd10',
            'diagnosis_icd10',
            'icd10',
            'icd10_code',
            'icd10_nama',
            'diagnosis_code',
            'kode_diagnosa',
            'diagnosa_kode',
        ],
        'Tindakan / ICD-9 CM' => [
            'icd9_items',
            'icd9',
            'icd9_code',
            'icd9_nama',
            'action_notes',
            'procedure_code',
            'procedure_name',
        ],
    ];

    echo '<div class="soap-section-grid">';
    echo '<div class="soap-section vital-section">';
    echo '<div class="soap-section-title">Tanda Vital</div>';
    echo '<div class="soap-section-body">';
    $hasVital = false;
    foreach ($vitals as $label => $aliases) {
        $value = $findFirstValue($rows, $aliases);
        if ($value !== null && $value !== '') {
            $hasVital = true;
            echo '<span class="vital-chip">' . h($label) . ': ' . h((string)$value) . '</span> ';
        }
    }
    if (!$hasVital) {
        echo '<span class="text-muted">Data belum tersedia</span>';
    }
    echo '</div>';
    echo '</div>';

    foreach ($sections as $title => $aliases) {
        $value = $findFirstValue($rows, $aliases);
        if (is_array($value)) {
            $value = $formatIcdItems($value);
        }
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
        $drugDetail = $findFirstValue($rowSet, ['detail_obat', 'drug_detail', 'medicine_detail', 'obat', 'medicines', 'items', 'detail', 'description', 'notes', 'note']);

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

    echo '<div class="history-table-wrap integration-table-wrap">';
    echo '<table class="table table-striped table-hover table-td-valign-middle mb-0 support-table integration-table">';
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

$renderIntegrationTable = function (array $rows) {
    if (empty($rows)) {
        echo '<div class="history-empty">Data belum tersedia</div>';
        return;
    }

    $formatDate = function ($value, string $format): string {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_object($value) && method_exists($value, 'format')) {
            return h($value->format($format));
        }

        return h(date($format, strtotime((string)$value)));
    };

    echo '<div class="history-table-wrap">';
    echo '<table class="table table-striped table-hover table-td-valign-middle mb-0 support-table">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th width="105">Tanggal</th>';
    echo '<th width="75">Jam</th>';
    echo '<th width="180">Tenaga Kesehatan</th>';
    echo '<th width="190">Dokter</th>';
    echo '<th>SOAP SBAR</th>';
    echo '<th>Instruksi</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($rows as $row) {
        $values = is_object($row) && method_exists($row, 'toArray') ? $row->toArray() : (array)$row;
        $notedAt = $values['noted_at'] ?? $values['created'] ?? null;

        echo '<tr>';
        echo '<td>' . $formatDate($notedAt, 'd-m-Y') . '</td>';
        echo '<td>' . $formatDate($notedAt, 'H:i') . '</td>';
        echo '<td><strong>' . h((string)($values['health_worker_name'] ?? '-')) . '</strong>';
        if (!empty($values['profession'])) {
            echo '<br><small>' . h((string)$values['profession']) . '</small>';
        }
        echo '</td>';
        echo '<td>' . h((string)($values['doctor_name'] ?? '-')) . '</td>';
        echo '<td><div class="support-detail">' . nl2br(h((string)($values['soap_sbar'] ?? $values['note'] ?? '-'))) . '</div></td>';
        echo '<td><div class="support-detail">' . nl2br(h((string)($values['instruction'] ?? '-'))) . '</div></td>';
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
        overflow-x: auto;
        white-space: nowrap;
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
        background: #fff;
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
        max-height: 180px;
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
        padding: 6px 8px;
        border-radius: 6px;
        background: #eef7ff;
        border: 1px solid #d7ebff;
        color: #1e3a5f;
        font-size: 12px;
        font-weight: 700;
        margin: 3px;
        white-space: nowrap;
    }

    .soap-workspace {
        display: grid;
        grid-template-columns: minmax(420px, 44%) minmax(0, 1fr);
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
        background: #f5f7fa;
        color: #2d353c;
        font-size: 14px;
        font-weight: 700;
    }

    .soap-visit-row {
        cursor: pointer;
    }

    .soap-visit-row.active td {
        background: #eef7ff !important;
        border-color: #d6ebff !important;
        color: #1e3a5f;
    }

    .soap-detail-content {
        display: none;
        padding: 14px;
    }

    .soap-detail-content.active {
        display: block;
    }

    .soap-detail-title {
        margin: -14px -14px 12px;
        padding: 14px;
        border-bottom: 1px solid #edf1f5;
        background: #fbfcfe;
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
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .vital-section {
        grid-column: 1 / -1;
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
        background: #fff;
    }

    .history-visit-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .history-visit-meta span {
        display: inline-block;
        padding: 3px 7px;
        border-radius: 5px;
        background: #eef2f7;
        color: #495057;
        font-size: 11px;
        font-weight: 700;
    }

    .integration-table th {
        white-space: nowrap;
    }

    .integration-table td {
        line-height: 1.45;
    }

    .integration-table-wrap .support-detail {
        max-height: 240px;
        min-width: 260px;
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

        .soap-section-grid {
            grid-template-columns: 1fr;
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
                                                <th width="130">Tanggal</th>
                                                <th width="150">No Registrasi</th>
                                                <th>Nama Pasien</th>
                                                <th width="135">Poli</th>
                                                <th>Dokter</th>
                                                <th width="95">Status</th>
                                                <th width="75">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $first = true; ?>
                                            <?php foreach ($registrations as $registration): ?>
                                                <?php
                                                $serviceType = $registration->registration->service_type ?? null;
                                                $serviceLabel = $serviceLabels[$serviceType] ?? ($serviceType ?: 'Rawat Jalan');
                                                $statusLabel = $statusLabels[$registration->status] ?? ($registration->status ?: '-');
                                                ?>
                                                <tr class="soap-visit-row <?= $first ? 'active' : '' ?>" data-target="soap-detail-<?= h($registration->id) ?>">
                                                    <td><?= $formatDateTime($registration->visit_date ?? null, $registration->visit_time ?? null) ?></td>
                                                    <td><strong><?= $display($registration->registration_no ?? $registration->registration->registration_no ?? null) ?></strong></td>
                                                    <td><?= $display($registration->patient->full_name ?? $patient->full_name ?? null) ?></td>
                                                    <td>
                                                        <span class="label label-info"><?= h($serviceLabel) ?></span><br>
                                                        <small><?= $display($registration->polyclinic_name ?? null) ?></small>
                                                    </td>
                                                    <td><?= $display($registration->doctor->doctor_name ?? $registration->doctor->name ?? null) ?></td>
                                                    <td><?= h($statusLabel) ?></td>
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
                                    $serviceType = $registration->registration->service_type ?? null;
                                    $serviceLabel = $serviceLabels[$serviceType] ?? ($serviceType ?: 'Rawat Jalan');
                                    $soapRows = [];
                                    if (!empty($medicalRecord)) {
                                        $soapRows[] = $medicalRecord;
                                    }
                                    $soapRows = array_merge($soapRows, $registrationDetails['examinations'] ?? []);
                                    $medicalRecordStatus = is_array($medicalRecord)
                                        ? ($medicalRecord['status'] ?? null)
                                        : ($medicalRecord->status ?? null);
                                    $noteCount = count($registrationDetails['examinations'] ?? []);
                                    $recipeCount = count($registrationDetails['prescriptions'] ?? []);
                                    $integrationCount = count($registrationDetails['integrations'] ?? []);
                                    ?>
                                    <div class="soap-detail-content <?= $first ? 'active' : '' ?>" id="soap-detail-<?= h($registration->id) ?>">
                                        <div class="soap-detail-title">
                                            <h4><?= $display($registration->registration_no ?? $registration->registration->registration_no ?? null) ?></h4>
                                            <small>
                                                <?= $formatDateTime($registration->visit_date ?? null, $registration->visit_time ?? null) ?>
                                                &nbsp;|&nbsp; <?= h($serviceLabel) ?>
                                                &nbsp;|&nbsp; <?= $display($registration->doctor->doctor_name ?? $registration->doctor->name ?? null) ?>
                                            </small>
                                            <div class="history-visit-meta">
                                                <span>Status Kunjungan: <?= h($statusLabels[$registration->status] ?? ($registration->status ?: '-')) ?></span>
                                                <span>Medical Record: <?= $display($medicalRecordStatus) ?></span>
                                                <span>Catatan EMR: <?= h((string)$noteCount) ?></span>
                                                <span>Resep: <?= h((string)$recipeCount) ?></span>
                                                <span>Form Integrasi: <?= h((string)$integrationCount) ?></span>
                                            </div>
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
                    <?php $renderIntegrationTable($collectRows(['integrations'])); ?>
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
