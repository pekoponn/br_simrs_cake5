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

$renderSoap = function (array $rows) use ($findFirstValue, $formatIcdItems) {
    $items = [
        'Keluhan Awal' => ['chief_complaint', 'keluhan_awal', 'complaint', 'keluhan', 'subjective'],
        'Pemeriksaan' => ['objective', 'pemeriksaan', 'examination', 'illness_history', 'physical_examination', 'note'],
        'Diagnosa' => ['assessment', 'diagnosis_primary', 'diagnosis_secondary', 'diagnosa', 'diagnosis'],
        'Saran / Anjuran' => ['plan', 'doctor_notes', 'saran', 'anjuran', 'therapy', 'terapi'],
        'Diagnosa / ICD10' => ['icd10_items', 'icd10', 'icd10_code', 'diagnosis_code'],
        'Skala Nyeri' => ['pain_scale', 'skala_nyeri', 'nyeri', 'pain_score'],
    ];
    $vitals = [
        'NADI' => ['pulse', 'nadi'],
        'T/D' => ['blood_pressure', 'tekanan_darah'],
        'SUHU' => ['temperature', 'suhu'],
        'PERNAFAS' => ['respiratory_rate', 'pernapasan', 'pernafasan'],
        'BB' => ['weight', 'berat_badan'],
        'BMI' => ['bmi'],
        'BMI RESULT' => ['bmi_result', 'bmi_category', 'bmi_status'],
    ];

    echo '<div class="soap-layout">';

    echo '<div class="soap-left">';
    echo '<table class="table table-bordered table-condensed vital-table"><tbody>';
    foreach ($vitals as $label => $aliases) {
        $value = $findFirstValue($rows, $aliases);
        echo '<tr><th>' . h($label) . '</th><td>' . (($value === null || $value === '') ? '-' : h((string)$value)) . '</td></tr>';
    }
    echo '</tbody></table>';
    echo '<div class="vital-actions">';
    echo '<button type="button" class="btn btn-default btn-sm vital-action-btn">Askep</button>';
    echo '<button type="button" class="btn btn-default btn-sm vital-action-btn">Resume</button>';
    echo '</div>';
    echo '</div>';

    echo '<div class="soap-right">';
    foreach ($items as $title => $aliases) {
        $value = $findFirstValue($rows, $aliases);

        if (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed !== '' && ($trimmed[0] === '[' || $trimmed[0] === '{')) {
                $decoded = json_decode($trimmed, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $value = $decoded;
                }
            }
        }

        if (is_array($value)) {
            $value = $formatIcdItems($value);
        }
        echo '<div class="soap-title">' . h($title) . '</div>';
        echo '<div class="soap-body">' . (($value === null || $value === '') ? '' : nl2br(h((string)$value))) . '</div>';
    }
    echo '</div>';

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

$renderResepTable = function (array $rows) use ($rowValues, $renderEmpty, $display, $displayTime) {
    if (empty($rows)) {
        $renderEmpty('Belum ada riwayat resep');
        return;
    }

    echo '<div class="history-table-scroll"><table class="table resep-table"><thead><tr>';
    echo '<th class="col-tanggal">Tgl Resep</th>';
    echo '<th class="col-jam">Jam</th>';
    echo '<th>Detail Obat</th>';
    echo '</tr></thead><tbody>';

    foreach ($rows as $row) {
        $v = $rowValues($row);

        $tgl   = $v['tgl_resep'] ?? $v['tanggal_resep'] ?? $v['prescription_date'] ?? $v['date'] ?? $v['created'] ?? null;
        $jam   = $v['jam'] ?? $v['prescription_time'] ?? $v['time'] ?? $tgl;
        $items = $v['items'] ?? null;

        echo '<tr>';
        echo '<td class="col-tanggal">' . $display($tgl) . '</td>';
        echo '<td class="col-jam">' . $displayTime($jam) . '</td>';
        echo '<td>';

        if (is_array($items) && !empty($items)) {
            foreach ($items as $item) {
                $name = is_array($item) ? ($item['name'] ?? '') : (string)$item;
                $qty  = is_array($item) ? ($item['qty'] ?? '') : '';
                echo '<div class="resep-obat-line">';
                echo '<span class="resep-obat-name">' . h($name) . '</span>';
                echo '<span class="resep-obat-qty">' . h((string)$qty) . '</span>';
                echo '</div>';
            }
        } else {
            $detail = $v['detail_obat'] ?? $v['drug_detail'] ?? $v['medicine_detail'] ?? $v['obat'] ?? $v['note'] ?? $v['notes'] ?? '-';
            echo nl2br(h((string)$detail));
        }

        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
};

$renderPenunjangMedis = function (array $rows) use ($rowValues) {
    echo '<div class="penunjang-layout">';

    echo '<div class="penunjang-left">';
    echo '<table class="table table-bordered table-condensed penunjang-list-table"><thead><tr>';
    echo '<th>No Pemeriksaan</th><th width="80">Tanggal</th><th width="60">Jam</th>';
    echo '</tr></thead><tbody>';
    if (empty($rows)) {
        echo '<tr><td colspan="3" class="penunjang-empty-row">Belum ada data</td></tr>';
    } else {
        foreach ($rows as $row) {
            $v = $rowValues($row);
            echo '<tr class="penunjang-list-row">';
            echo '<td>' . h((string)($v['no_pemeriksaan'] ?? $v['number'] ?? $v['code'] ?? '-')) . '</td>';
            echo '<td>' . h((string)($v['tanggal'] ?? $v['date'] ?? '-')) . '</td>';
            echo '<td>' . h((string)($v['jam'] ?? $v['time'] ?? '-')) . '</td>';
            echo '</tr>';
        }
    }
    echo '</tbody></table>';
    echo '</div>';

    echo '<div class="penunjang-right">';
    echo '<table class="table table-bordered table-condensed penunjang-detail-table"><thead><tr>';
    echo '<th>Pemeriksaan</th><th>Hasil</th><th width="110">Tgl Expertise</th><th width="110">Jam Expertise</th>';
    echo '</tr></thead><tbody>';
    echo '<tr><td colspan="4" class="penunjang-empty-row">Data belum tersedia</td></tr>';
    echo '</tbody></table>';
    echo '</div>';

    echo '</div>';
};

$renderLaboratorium = function (array $listRows, array $detailRows) use ($rowValues, $display, $displayTime) {
    echo '<div class="lab-layout">';

    echo '<div class="lab-left">';
    echo '<table class="table table-bordered table-condensed lab-list-table"><thead><tr>';
    echo '<th>No Pemeriksaan</th><th width="80">Tanggal</th><th width="60">Jam</th>';
    echo '</tr></thead><tbody>';
    if (empty($listRows)) {
        echo '<tr><td colspan="3" class="lab-empty-row">Belum ada data</td></tr>';
    } else {
        foreach ($listRows as $i => $row) {
            $v = $rowValues($row);
            $active = $i === 0 ? ' active' : '';
            echo '<tr class="lab-list-row' . $active . '">';
            echo '<td>' . h((string)($v['no_pemeriksaan'] ?? $v['number'] ?? $v['code'] ?? '-')) . '</td>';
            echo '<td>' . $display($v['tanggal'] ?? $v['date'] ?? null) . '</td>';
            echo '<td>' . $displayTime($v['jam'] ?? $v['time'] ?? null) . '</td>';
            echo '</tr>';
        }
    }
    echo '</tbody></table>';
    echo '</div>';

    echo '<div class="lab-right">';
    echo '<table class="table table-bordered table-condensed lab-detail-table"><thead><tr>';
    echo '<th>Pemeriksaan</th><th width="100">Hasil</th><th width="80">Satuan</th><th width="100">Nilai Rujukan</th><th width="90">Keterangan</th>';
    echo '</tr></thead><tbody>';

    if (empty($detailRows)) {
        echo '<tr><td colspan="5" class="lab-empty-row">Data belum tersedia</td></tr>';
    } else {
        foreach ($detailRows as $row) {
            $v = $rowValues($row);
            $isCategory = !empty($v['is_category']);
            $keterangan = strtolower((string)($v['keterangan'] ?? $v['remark'] ?? ''));
            $ketClass = $keterangan === 'high' ? 'lab-flag-high' : ($keterangan === 'low' ? 'lab-flag-low' : '');

            echo '<tr class="' . ($isCategory ? 'lab-category-row' : 'lab-sub-row') . '">';
            echo '<td>' . h((string)($v['pemeriksaan'] ?? $v['nama'] ?? '-')) . '</td>';
            echo '<td>' . h((string)($v['hasil'] ?? $v['result'] ?? '')) . '</td>';
            echo '<td>' . h((string)($v['satuan'] ?? $v['unit'] ?? '')) . '</td>';
            echo '<td>' . h((string)($v['nilai_rujukan'] ?? $v['reference_range'] ?? '')) . '</td>';
            echo '<td class="' . $ketClass . '">' . h((string)($v['keterangan'] ?? $v['remark'] ?? '')) . '</td>';
            echo '</tr>';
        }
    }

    echo '</tbody></table>';
    echo '</div>';

    echo '</div>';
};
$renderRadiologi = function (array $listRows, array $detailRows) use ($rowValues, $display, $displayTime) {
    echo '<div class="radio-layout">';

    echo '<div class="radio-left">';
    echo '<table class="table table-bordered table-condensed radio-list-table"><thead><tr>';
    echo '<th>No Pemeriksaan</th><th width="80">Tanggal</th><th width="60">Jam</th>';
    echo '</tr></thead><tbody>';
    if (empty($listRows)) {
        echo '<tr><td colspan="3" class="radio-empty-row">Belum ada data</td></tr>';
    } else {
        foreach ($listRows as $i => $row) {
            $v = $rowValues($row);
            $active = $i === 0 ? ' active' : '';
            echo '<tr class="radio-list-row' . $active . '">';
            echo '<td>' . h((string)($v['no_pemeriksaan'] ?? $v['number'] ?? $v['code'] ?? '-')) . '</td>';
            echo '<td>' . $display($v['tanggal'] ?? $v['date'] ?? null) . '</td>';
            echo '<td>' . $displayTime($v['jam'] ?? $v['time'] ?? null) . '</td>';
            echo '</tr>';
        }
    }
    echo '</tbody></table>';
    echo '</div>';

    echo '<div class="radio-right">';
    echo '<table class="table table-bordered table-condensed radio-detail-table"><thead><tr>';
    echo '<th width="160">Pemeriksaan</th><th>Hasil</th><th width="100">Tgl Expertise</th><th width="90">Jam Expertise</th>';
    echo '</tr></thead><tbody>';

    if (empty($detailRows)) {
        echo '<tr><td colspan="4" class="radio-empty-row">Data belum tersedia</td></tr>';
    } else {
        foreach ($detailRows as $row) {
            $v = $rowValues($row);
            $hasil = $v['hasil'] ?? $v['result'] ?? '';
            $kesimpulan = $v['kesimpulan'] ?? $v['impression'] ?? '';
            $hasilText = trim($hasil . ($kesimpulan !== '' ? "\n\nKesimpulan : " . $kesimpulan : ''));

            echo '<tr>';
            echo '<td>' . h((string)($v['pemeriksaan'] ?? $v['nama'] ?? '-')) . '</td>';
            echo '<td class="radio-hasil-cell">' . nl2br(h((string)$hasilText)) . '</td>';
            echo '<td>' . $display($v['tgl_expertise'] ?? $v['expertise_date'] ?? null) . '</td>';
            echo '<td>' . $displayTime($v['jam_expertise'] ?? $v['expertise_time'] ?? null) . '</td>';
            echo '</tr>';
        }
    }

    echo '</tbody></table>';
    echo '</div>';

    echo '</div>';
};

$renderFormIntegrasi = function (array $rows) use ($rowValues) {
    if (empty($rows)) {
        echo '<div class="history-empty">Belum ada catatan CPPT</div>';
        return;
    }

    echo '<div class="integrasi-table-wrap"><table class="table table-bordered integrasi-table"><thead><tr>';
    echo '<th style="width:40px;">No</th>';
    echo '<th style="width:80px;">Tanggal</th>';
    echo '<th style="width:70px;">Jam</th>';
    echo '<th style="width:150px;">Tenaga Kesehatan</th>';
    echo '<th style="width:160px;">Dokter</th>';
    echo '<th>Asesmen Pasien (SOAP_SBAR)</th>';
    echo '<th style="width:260px;">Instruksi</th>';
    echo '</tr></thead><tbody>';

    $no = 1;
    foreach ($rows as $row) {
        $v = $rowValues($row);

        $dt = $v['noted_at'] ?? $v['created'] ?? null;
        $dtObj = null;
        if (is_object($dt) && method_exists($dt, 'format')) {
            $dtObj = $dt;
        } elseif (!empty($dt)) {
            try {
                $dtObj = new \DateTime((string)$dt);
            } catch (\Throwable $e) {
                $dtObj = null;
            }
        }

        $tenaga  = trim((string)($v['health_worker_name'] ?? ''));
        $dokter  = trim((string)($v['doctor_name'] ?? ''));
        $asesmen = trim((string)($v['assessment_text'] ?? ''));
        $instruksi = trim((string)($v['instruction'] ?? ''));

        echo '<tr>';
        echo '<td class="text-center">' . str_pad((string)$no++, 3, '0', STR_PAD_LEFT) . '</td>';
        echo '<td class="text-center">' . ($dtObj ? h($dtObj->format('d-m-y')) : '-') . '</td>';
        echo '<td class="text-center">' . ($dtObj ? h($dtObj->format('H:i:s')) : '-') . '</td>';
        echo '<td>' . ($tenaga !== '' ? h($tenaga) : '&nbsp;') . '</td>';
        echo '<td>' . ($dokter !== '' ? h($dokter) : '&nbsp;') . '</td>';
        echo '<td class="integrasi-scroll-td"><div class="integrasi-cell-scroll">' . ($asesmen !== '' ? nl2br(h($asesmen)) : '&nbsp;') . '</div></td>';
        echo '<td class="integrasi-scroll-td"><div class="integrasi-cell-scroll">' . ($instruksi !== '' ? nl2br(h($instruksi)) : '&nbsp;') . '</div></td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
};

$renderBedah = function (array $rows) use ($rowValues) {
    $columns = [
        'No Operasi' => ['no_operasi', 'surgery_no', 'number', 'code'],
        'Tindakan Operasi' => ['tindakan_operasi', 'tindakan', 'action', 'procedure_name', 'name'],
        'Operator' => ['operator', 'doctor_name', 'dokter'],
        'Anastesi' => ['anastesi', 'anestesi', 'anesthesia'],
        'Jenis Pembiusan' => ['jenis_pembiusan', 'anesthesia_type', 'jenis_anestesi'],
        'Diagnosa' => ['diagnosa', 'diagnosis'],
        'Header1' => ['header1', 'catatan', 'note', 'notes'],
    ];

    echo '<div class="bedah-layout">';

    echo '<div class="bedah-table-wrap"><table class="table table-bordered table-condensed bedah-table"><thead><tr>';
    foreach ($columns as $title => $aliases) {
        echo '<th>' . h($title) . '</th>';
    }
    echo '</tr></thead><tbody>';

    if (empty($rows)) {
        for ($i = 0; $i < 8; $i++) {
            echo '<tr>';
            foreach ($columns as $title => $aliases) {
                echo '<td>&nbsp;</td>';
            }
            echo '</tr>';
        }
    } else {
        foreach ($rows as $row) {
            $v = $rowValues($row);
            echo '<tr>';
            foreach ($columns as $title => $aliases) {
                $value = null;
                foreach ($aliases as $alias) {
                    if (isset($v[$alias]) && $v[$alias] !== null && $v[$alias] !== '') {
                        $value = $v[$alias];
                        break;
                    }
                }
                echo '<td>' . (($value === null || $value === '') ? '&nbsp;' : nl2br(h((string)$value))) . '</td>';
            }
            echo '</tr>';
        }
    }
    echo '</tbody></table></div>';

    echo '<div class="bedah-bottom">';
    echo '<div class="bedah-detail-box"></div>';
    echo '<div class="bedah-actions">';
    echo '<button type="button" class="btn btn-default bedah-action-btn">Pra Operasi</button>';
    echo '<button type="button" class="btn btn-default bedah-action-btn">Anestasi</button>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
};

$patientCode = $patient ? ($patient->code ?? null) : null;
$historyGroups = $historyGroups ?? [];
$rwtCodeByRegistration = [];
$rwtCodeByType = [];
foreach ($historyGroups as $group) {
    $firstEntry = $group['entries'][0] ?? null;
    $rwtCodeByRegistration[$group['reg_id']] = $firstEntry['history_no'] ?? $group['reg_code'];
    foreach ($group['entries'] as $entry) {
        $rwtCodeByType[$group['reg_id']][$entry['type']] = $entry['history_no'];
    }
}

// Baris riwayat yang di-highlight AKTIF secara default adalah entri bertipe
// 'soap' pada grup REG paling atas (paling baru) — karena tab yang tampil
// pertama kali memang SOAP. Kalau grup REG paling baru itu tidak punya entri
// soap sama sekali, fallback ke entri pertamanya saja supaya tetap ada 1
// baris yang aktif.
$defaultActiveEntryKey = null;
foreach ($historyGroups as $group) {
    if (empty($group['entries'])) {
        continue;
    }
    $fallbackEntry = null;
    foreach ($group['entries'] as $entry) {
        if ($fallbackEntry === null) {
            $fallbackEntry = $entry;
        }
        if ($entry['type'] === 'soap') {
            $defaultActiveEntryKey = $group['reg_id'] . '|' . $entry['type'] . '|' . $entry['history_no'];
            break 2;
        }
    }
    $defaultActiveEntryKey = $group['reg_id'] . '|' . $fallbackEntry['type'] . '|' . $fallbackEntry['history_no'];
    break;
}
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
.mr-layout{display:grid;grid-template-columns:310px minmax(0,1fr);gap:10px;align-items:start;}
.mr-left{display:flex;flex-direction:column;}
.mr-history-panel{display:flex;flex-direction:column;flex:1;min-height:0;}
.mr-history-panel .mr-panel-body{flex:1;min-height:0;}
.mr-history-scroll{max-height:560px;overflow-y:auto;}
.mr-history-table{font-size:11px;margin:0;background:#fff;}
.mr-history-table thead th{position:sticky;top:0;z-index:2;}
.mr-history-table th{background:#e9ecef;color:#1e3a5f;font-weight:700;border:1px solid #ddd!important;padding:6px!important;}
.mr-history-table td{border:1px solid #ddd!important;padding:6px!important;vertical-align:middle!important;}
.mr-history-row{cursor:pointer;}
.mr-history-row.active td{background:#1e3a5f!important;color:#fff!important;}
.mr-history-row.active strong{color:#fff!important;}
.mr-history-type{font-weight:400;color:#7a869a;font-size:10px;}
.mr-history-row.active .mr-history-type{color:#dbe6f7;}
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
.soap-layout{display:grid;grid-template-columns:230px minmax(0,1fr);gap:10px;align-items:start;}
.soap-left{border:1px solid #ddd;background:#fff;padding:8px;}
.vital-table{margin:0 0 8px 0;font-size:11px;}
.vital-table th{background:#dbeafe;color:#1e3a5f;font-weight:700;width:45%;border:1px solid #ddd!important;padding:5px 6px!important;text-align:left;}
.vital-table td{border:1px solid #ddd!important;padding:5px 6px!important;}
.vital-actions{display:flex;gap:6px;}
.vital-action-btn{flex:1;border:1px solid #9eaac0;background:#e9eef7;color:#1e3a5f;font-weight:700;}
.vital-action-btn:hover{background:#dbeafe;}
.soap-right{border:1px solid #ddd;background:#fff;}
.soap-right .soap-title:first-child{border-top:0;}
@media(max-width:900px){.soap-layout{grid-template-columns:1fr;}}
.history-empty{padding:25px 14px;border:1px dashed #ccc;background:#fafafa;color:#777;text-align:center;font-weight:700;}
.history-detail-table{width:100%;margin:0;background:#fff;font-size:11px;}
.history-detail-table th{background:#dbeafe;color:#1e3a5f;text-align:center;font-weight:700;border:1px solid #ddd!important;padding:6px!important;}
.history-detail-table td{border:1px solid #ddd!important;padding:6px!important;}
.history-table-scroll{overflow:auto;max-height:430px;}
.resep-table{width:100%;border-collapse:collapse;font-size:12px;background:#fff;}
.resep-table thead th{background:#dbeafe;color:#1e3a5f;font-weight:700;border:1px solid #b8c8e6!important;padding:6px!important;text-align:center;position:sticky;top:0;z-index:2;}
.resep-table tbody td{border:1px solid #ddd!important;padding:6px 8px!important;vertical-align:top!important;}
.resep-table tbody tr:nth-child(even) td{background:#fafbfd;}
.resep-table tbody tr:hover td{background:#eef4ff;}
.resep-table .col-noresep{width:120px;}
.resep-table .col-tanggal{width:85px;text-align:center;}
.resep-table .col-jam{width:70px;text-align:center;}
.resep-table .col-dokter{width:140px;}
.resep-obat-line{display:flex;justify-content:space-between;gap:10px;padding:1px 0;line-height:1.4;}
.resep-obat-name{flex:1;}
.resep-obat-qty{white-space:nowrap;font-weight:700;color:#333;}
.penunjang-layout{display:grid;grid-template-columns:260px minmax(0,1fr);gap:10px;align-items:start;}
.penunjang-left,.penunjang-right{border:1px solid #ddd;background:#fff;}
.penunjang-list-table,.penunjang-detail-table{width:100%;margin:0;font-size:11px;}
.penunjang-list-table thead th,.penunjang-detail-table thead th{background:#dbeafe;color:#1e3a5f;font-weight:700;border:1px solid #b8c8e6!important;padding:6px!important;text-align:center;}
.penunjang-list-table tbody td,.penunjang-detail-table tbody td{border:1px solid #ddd!important;padding:6px!important;vertical-align:top!important;}
.penunjang-list-row{cursor:pointer;}
.penunjang-list-row:hover td{background:#eef4ff;}
.penunjang-empty-row{text-align:center;color:#999;padding:20px!important;font-style:italic;}
@media(max-width:900px){.penunjang-layout{grid-template-columns:1fr;}}
.lab-layout{display:grid;grid-template-columns:260px minmax(0,1fr);gap:10px;align-items:start;}
.lab-left,.lab-right{border:1px solid #ddd;background:#fff;}
.lab-list-table,.lab-detail-table{width:100%;margin:0;font-size:11px;}
.lab-list-table thead th,.lab-detail-table thead th{background:#dbeafe;color:#1e3a5f;font-weight:700;border:1px solid #b8c8e6!important;padding:6px!important;text-align:center;}
.lab-list-table tbody td,.lab-detail-table tbody td{border:1px solid #ddd!important;padding:6px!important;vertical-align:top!important;}
.lab-list-row{cursor:pointer;}
.lab-list-row:hover td{background:#eef4ff;}
.lab-list-row.active td{background:#1e3a5f!important;color:#fff!important;}
.lab-empty-row{text-align:center;color:#999;padding:20px!important;font-style:italic;}
.lab-category-row td{background:#f1f4f9!important;font-weight:700;color:#1e3a5f;}
.lab-sub-row td:first-child{padding-left:18px!important;}
.lab-flag-high{color:#b02a2a;font-weight:700;}
.lab-flag-low{color:#1a6fb0;font-weight:700;}
@media(max-width:900px){.lab-layout{grid-template-columns:1fr;}}
.radio-layout{display:grid;grid-template-columns:260px minmax(0,1fr);gap:10px;align-items:start;}
.radio-left,.radio-right{border:1px solid #ddd;background:#fff;}
.radio-list-table,.radio-detail-table{width:100%;margin:0;font-size:11px;}
.radio-list-table thead th,.radio-detail-table thead th{background:#dbeafe;color:#1e3a5f;font-weight:700;border:1px solid #b8c8e6!important;padding:6px!important;text-align:center;}
.radio-list-table tbody td,.radio-detail-table tbody td{border:1px solid #ddd!important;padding:6px!important;vertical-align:top!important;}
.radio-list-row{cursor:pointer;}
.radio-list-row:hover td{background:#eef4ff;}
.radio-list-row.active td{background:#1e3a5f!important;color:#fff!important;}
.radio-empty-row{text-align:center;color:#999;padding:20px!important;font-style:italic;}
.radio-hasil-cell{white-space:pre-wrap;line-height:1.5;max-height:180px;overflow-y:auto;}
@media(max-width:900px){.radio-layout{grid-template-columns:1fr;}}
.bedah-layout{display:flex;flex-direction:column;gap:10px;}
.bedah-table-wrap{border:1px solid #ddd;background:#fff;overflow:auto;max-height:360px;}
.bedah-table{width:100%;margin:0;font-size:11px;}
.bedah-table thead th{background:#dbeafe;color:#1e3a5f;font-weight:700;border:1px solid #b8c8e6!important;padding:6px!important;text-align:center;position:sticky;top:0;z-index:2;}
.bedah-table tbody td{border:1px solid #ddd!important;padding:6px!important;height:26px;vertical-align:top!important;}
.bedah-bottom{display:flex;gap:10px;align-items:flex-start;}
.bedah-detail-box{flex:1;min-height:110px;border:1px solid #ddd;background:#f8f9fa;}
.bedah-actions{display:flex;gap:8px;padding-top:4px;}
.bedah-action-btn{border:1px solid #9eaac0;background:#e9eef7;color:#1e3a5f;font-weight:700;min-width:120px;}
.bedah-action-btn:hover{background:#dbeafe;}
@media(max-width:900px){.bedah-bottom{flex-direction:column;}}
.integrasi-table-wrap{border:1px solid #ddd;background:#fff;overflow:auto;max-height:430px;}
.integrasi-table{width:100%;margin:0;table-layout:fixed;font-size:11px;}
.integrasi-table thead th{position:sticky;top:0;z-index:2;background:#dbeafe;color:#1e3a5f;font-weight:700;border:1px solid #b8c8e6!important;padding:6px!important;text-align:center;}
.integrasi-table tbody td{border:1px solid #ddd!important;padding:4px!important;vertical-align:top!important;height:92px;max-height:92px;overflow:hidden;}
.integrasi-scroll-td{padding:0!important;}
.integrasi-cell-scroll{display:block;height:92px;max-height:92px;padding:6px 8px;overflow-y:auto;overflow-x:hidden;white-space:pre-wrap;word-break:break-word;line-height:1.35;text-align:left;}
.integrasi-cell-scroll::-webkit-scrollbar{width:8px;}
.integrasi-cell-scroll::-webkit-scrollbar-thumb{background:#9aa0a6;border-radius:6px;}
.integrasi-cell-scroll::-webkit-scrollbar-track{background:#eef2f6;}
.patient-modal .modal-dialog{width:1120px;max-width:96%;}
.patient-modal .modal-content{border:2px solid #1e3a5f;border-radius:0;background:#d7e2f6;}
.patient-modal .modal-header{position:relative;padding:8px 40px 8px 12px;background:#1e3a5f;color:#fff;border-bottom:1px solid #10283f;}
.patient-modal .modal-header .modal-title{margin:0;}
.patient-modal .modal-header .close{position:absolute;top:50%;right:10px;transform:translateY(-50%);margin:0;color:#fff;opacity:.85;font-size:20px;line-height:1;}
.patient-modal .modal-header .close:hover{opacity:1;}
.patient-modal .modal-body{padding:10px;background:#dce6f8;}
.patient-modal .modal-footer{padding:8px 10px;background:#1e3a5f;border-top:1px solid #10283f;}
.patient-modal-filter{display:grid;grid-template-columns:95px 1fr;gap:6px;align-items:center;margin-bottom:8px;}
.patient-modal-filter label{margin:0;font-size:12px;font-weight:700;color:#1f355b;}
.patient-modal-table-wrap{height:330px;overflow:auto;border:1px solid #6f8ebc;background:#fff;}
.patient-modal-table{width:100%;margin:0;background:#fff;}
.patient-modal-table th,.patient-modal-table td{border:1px solid #9eaac0!important;padding:4px 6px!important;font-size:12px!important;white-space:nowrap;}
.patient-modal-table th{background:#c7d2e7;color:#1d2f57;text-align:center;}
.patient-modal-table tr:hover td{background:#dbeafe!important;}
.patient-modal-table .row-female td{background:#fde3ec!important;}
.patient-modal-table .row-female:hover td{background:#fbd2e0!important;}
.patient-modal-table .row-male td{background:#e2f0fd!important;}
.patient-modal-table .row-male:hover td{background:#cfe6fb!important;}
.patient-modal-table .selected-row td{background:#2f6fd4!important;color:#fff!important;}
.patient-modal-table .selected-row.row-female td,
.patient-modal-table .selected-row.row-male td{background:#2f6fd4!important;color:#fff!important;}
.patient-modal-row{cursor:pointer;}
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

            <div class="mr-panel mr-history-panel">
                <div class="mr-panel-heading"><i class="fa fa-history"></i> History Pemeriksaan Pasien</div>
                <div class="mr-panel-body" style="padding:0;background:#fff;">
                    <div class="mr-history-scroll">
                    <table class="table table-condensed table-hover mr-history-table">
                        <thead>
                            <tr>
                                <th>No Pemeriksaan</th>
                                <th width="82">Tanggal</th>
                                <th width="60">Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($historyGroups)): ?>
                                <tr>
                                    <td colspan="3" style="text-align:center;color:#aaa;padding:16px;font-size:11px;">
                                        <i class="fa fa-inbox"></i><br>Belum ada history pemeriksaan
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($historyGroups as $group): ?>
                                    <tr>
                                        <td colspan="3" style="background:#eef2f7;font-weight:700;color:#1e3a5f;padding:6px 8px;">
                                            <?= h($group['reg_code']) ?>
                                        </td>
                                    </tr>
                                    <?php if (empty($group['entries'])): ?>
                                        <tr>
                                            <td colspan="3" style="text-align:center;color:#bbb;padding:8px;font-size:10px;font-style:italic;">
                                                Belum ada isian pada registrasi ini
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php foreach ($group['entries'] as $entry): ?>
                                        <?php
                                        $entryKey = $group['reg_id'] . '|' . $entry['type'] . '|' . $entry['history_no'];
                                        $isActive = ($entryKey === $defaultActiveEntryKey);
                                        ?>
                                        <tr class="mr-history-row <?= $isActive ? 'active' : '' ?>" data-history-id="<?= h($entry['id']) ?>" data-tab="<?= h($entry['type']) ?>">
                                            <td style="padding-left:18px;"><strong><?= h($entry['history_no']) ?></strong><br><span class="mr-history-type">(<?= h($entry['type_label']) ?>)</span></td>
                                            <td><?= $display($entry['date']) ?></td>
                                            <td><?= $displayTime($entry['time']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>
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
                                        $visitEmr = $registration->outpatient_visit_emr ?? null;
                                        $PatientHistory = $registration->medical_record ?? null;
                                        $soapRows = [];
                                        if (!empty($visitEmr)) {
                                            $soapRows[] = $visitEmr;
                                        }
                                        if (!empty($PatientHistory)) {
                                            $soapRows[] = $PatientHistory;
                                        }
                                        $soapRows = array_merge($soapRows, $details['examinations'] ?? []);
                                        $emrPrescriptionRows = [];
                                        if (!empty($visitEmr) && !empty($visitEmr->prescription_notes ?? null)) {
                                            $emrLines = preg_split('/\r\n|\r|\n/', (string)$visitEmr->prescription_notes);
                                            $emrItems = [];
                                            foreach ($emrLines as $emrLine) {
                                                $emrLine = trim($emrLine);
                                                if ($emrLine !== '') {
                                                    $emrItems[] = ['name' => $emrLine, 'qty' => ''];
                                                }
                                            }
                                            if (!empty($emrItems)) {
                                                $emrPrescriptionRows[] = [
                                                    'no_resep' => $rwtCodeByRegistration[$registration->id] ?? $getNoPemeriksaan($registration),
                                                    'tgl_resep' => $getRegDate($registration),
                                                    'jam' => $getRegTime($registration),
                                                    'dokter' => $getDoctor($registration),
                                                    'items' => $emrItems,
                                                ];
                                            }
                                        }
                                        ?>
                                        <div class="detail-panel <?= $firstPanel ? 'active' : '' ?>" data-panel-history-id="<?= h($registration->id) ?>">
                                            <div class="detail-heading">
                                            <div>
                                                <strong><?= h($rwtCodeByType[$registration->id][$tabName] ?? ($rwtCodeByRegistration[$registration->id] ?? $getNoPemeriksaan($registration))) ?></strong><br>
                                                <small><?= $display($getRegDate($registration)) ?> <?= $displayTime($getRegTime($registration)) ?> | <?= h($getPoli($registration)) ?> | <?= h($getDoctor($registration)) ?></small>
                                            </div>
                                            <div>
                                                <small>Status: <?= $display($registration->status ?? '-') ?></small><br>
                                                <small>Dibuat oleh: <?= h($registration->history_created_by ?? '-') ?></small>
                                            </div>
                                        </div>

                                            <?php if ($tabName === 'soap'): ?>
                                                <?php $renderSoap($soapRows); ?>
                                       <?php elseif ($tabName === 'resep'): ?>
                                                <?php
                                                $resepRows = !empty($details['prescriptions'])
                                                    ? $details['prescriptions']
                                                    : (!empty($emrPrescriptionRows) ? $emrPrescriptionRows : []);
                                                $renderResepTable($resepRows);
                                                ?>
                                            <?php elseif ($tabName === 'penunjang'): ?>
                                                <?php $renderPenunjangMedis($details['penunjang'] ?? []); ?>
                                            <?php elseif ($tabName === 'laboratorium'): ?>
                                                <?php $renderLaboratorium($details['lab_orders'] ?? [], $details['laboratories'] ?? []); ?>
                                            <?php elseif ($tabName === 'radiologi'): ?>
                                                <?php $renderRadiologi($details['radio_orders'] ?? [], $details['radiologies'] ?? []); ?>
                                            <?php elseif ($tabName === 'bedah'): ?>
                                                <?php $renderBedah($details['surgeries'] ?? []); ?>
                                            <?php elseif ($tabName === 'integrasi'): ?>
                                                <?php $renderFormIntegrasi($details['cppt'] ?? []); ?>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalCariPasienLabel"><i class="fa fa-search"></i> Cari Pasien</h4>
      </div>
      <div class="modal-body">
        <div class="patient-modal-filter">
          <label>Kata Kunci</label>
          <input type="text" id="patientModalSearchInput" class="form-control input-sm"
                 placeholder="Kode / Nama / NIK / Telepon / Alamat" autocomplete="off">
        </div>
        <div class="patient-modal-table-wrap">
          <table class="table table-condensed patient-modal-table">
            <thead>
            <tr>
                <!-- <th width="60">Pilih</th> -->
                <th>Kode</th><th>Nama</th><th>Tgl Lahir</th><th>JK</th>
                <th>No Identitas</th><th>Telepon</th><th>Alamat</th>
            </tr>
            </thead>
            <tbody id="patientModalResultsBody">
              <tr><td colspan="7" style="text-align:center;color:#888;">Ketik kata kunci untuk mencari pasien</td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function () {
    var $modal = $('#modalCariPasien');
    var $input = $('#patientModalSearchInput');
    var $body = $('#patientModalResultsBody');
    var searchTimer = null;

    function esc(v) { return $('<div>').text(v == null ? '' : v).html(); }

    function genderRowClass(gender) {
        var g = (gender == null ? '' : String(gender)).trim().toLowerCase();
        var female = ['w', 'wanita', 'f', 'female', 'perempuan'];
        var male = ['p', 'pria', 'l', 'male', 'laki-laki', 'm'];
        if (female.indexOf(g) !== -1) return 'row-female';
        if (male.indexOf(g) !== -1) return 'row-male';
        return '';
    }

    function renderRows(rows) {
        if (!rows || !rows.length) {
            $body.html('<tr><td colspan="7" style="text-align:center;color:#888;">Tidak ada pasien ditemukan</td></tr>');
            return;
        }
        var html = '';
        rows.forEach(function (p) {
             var rowClass = genderRowClass(p.gender);
            html += '<tr class="patient-modal-row ' + rowClass + '" data-code="' + esc(p.code) + '">'
                + '<td>' + esc(p.code) + '</td>'
                + '<td>' + esc(p.full_name) + '</td>'
                + '<td>' + esc(p.birth_date) + '</td>'
                + '<td>' + esc(p.gender) + '</td>'
                + '<td>' + esc(p.identity_number) + '</td>'
                + '<td>' + esc(p.phone_number) + '</td>'
                + '<td>' + esc(p.address) + '</td>'
                + '</tr>';
        });
        $body.html(html);
    }

    function doSearch(term) {
        $body.html('<tr><td colspan="7" style="text-align:center;color:#888;">Memuat data...</td></tr>');
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'searchPatients']) ?>',
            data: { term: term },
            dataType: 'json'
        }).done(function (resp) {
            renderRows(resp && resp.data ? resp.data : []);
        }).fail(function () {
            $body.html('<tr><td colspan="7" style="text-align:center;color:#c00;">Gagal memuat data</td></tr>');
        });
    }

     // Klik baris -> reload halaman dengan patient terpilih
    $body.on('click', '.patient-modal-row', function () {
        var code = $(this).data('code');
        window.location.href = '?q=' + encodeURIComponent(code);
    });

    $input.on('keyup', function () {
        var term = $input.val().trim();
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { doSearch(term); }, 350);
    });

    // Saat modal dibuka: langsung load semua data (tanpa keyword)
    $modal.on('shown.bs.modal', function () {
        $input.val('').focus();
        doSearch('');
    });

    // Aktifkan tab secara manual: pindahkan class "active" di <li> menu atas
    // DAN di .tab-pane yang sesuai. Tidak mengandalkan .tab('show') bawaan
    // Bootstrap supaya highlight menu atas selalu ikut pindah.
    function activateTab(tab) {
        var $link = $('#medical-record-tabs a[data-tab="' + tab + '"]');
        if (!$link.length) {
            return;
        }

        $('#medical-record-tabs li').removeClass('active');
        $link.closest('li').addClass('active');

        $('.tab-pane').removeClass('active');
        $($link.attr('href')).addClass('active');
    }

    // Klik salah satu baris di History Pemeriksaan Pasien (kiri):
    // - highlight baris itu jadi aktif
    // - tampilkan panel detail registrasi yang sesuai
    // - pindah ke TAB yang sesuai dengan jenis data baris itu (soap/resep/dst)
    $('.mr-history-row').on('click', function () {
        var $row = $(this);
        var regId = $row.data('history-id');
        var tab = $row.data('tab');

        $('.mr-history-row').removeClass('active');
        $row.addClass('active');

        $('.detail-panel').removeClass('active');
        $('.detail-panel[data-panel-history-id="' + regId + '"]').addClass('active');

        if (tab) {
            activateTab(tab);
        }
    });

    // Klik tab langsung dari menu atas -> aktifkan tab + sinkronkan
    // highlight baris kiri supaya ikut pindah ke baris yang sesuai.
    $('#medical-record-tabs a[data-toggle="tab"]').on('click', function (e) {
        e.preventDefault();

        var tab = $(this).data('tab');
        activateTab(tab);

        var $activePane = $($(this).attr('href'));
        var currentRegId = $activePane.find('.detail-panel.active').data('panel-history-id');

        if (currentRegId !== undefined) {
            var $targetRow = $('.mr-history-row[data-history-id="' + currentRegId + '"][data-tab="' + tab + '"]');
            if ($targetRow.length) {
                $('.mr-history-row').removeClass('active');
                $targetRow.addClass('active');
            }
        }
    });
});
</script>