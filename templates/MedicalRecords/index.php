<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $q
 * @var \App\Model\Entity\Patient|null $patient
 * @var array $registrations
 * @var array $medicalRecordsByRegistration
 * @var bool $notFound
 */

$q = $q ?? '';
$patient = $patient ?? null;
$registrations = $registrations ?? [];
$medicalRecordsByRegistration = $medicalRecordsByRegistration ?? [];
$notFound = $notFound ?? false;

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
        return h($value->format('H:i'));
    }
    $time = strtotime((string)$value);
    return $time ? h(date('H:i', $time)) : h((string)$value);
};

$genderText = function ($gender): string {
    $gender = strtolower((string)$gender);
    if (in_array($gender, ['female', 'f', 'p', 'perempuan', 'wanita'], true)) {
        return 'Wanita';
    }
    if (in_array($gender, ['male', 'm', 'l', 'laki-laki', 'pria'], true)) {
        return 'Pria';
    }
    return $gender !== '' ? ucfirst($gender) : '-';
};

$getRegDate = function ($registration) {
    return $registration->registration_date ?? $registration->visit_date ?? $registration->created ?? null;
};

$getRegTime = function ($registration) {
    return $registration->admission_time ?? $registration->visit_time ?? null;
};

$getNoKunjungan = function ($registration) {
    return $registration->registration_no
        ?? $registration->registration_number
        ?? $registration->number
        ?? $registration->code
        ?? ('REG-' . ($registration->id ?? ''));
};

$getMedicalRecord = function ($registration) use ($medicalRecordsByRegistration) {
    return $medicalRecordsByRegistration[$registration->id] ?? null;
};

// No Rekam Medis: diambil dari rekam medis (medical_record_no) yang otomatis dibuat saat
// registrasi disimpan. Kalau karena alasan tertentu rekam medis / medical_record_no belum
// ada (misal data lama), fallback ke No Registrasi supaya kolom tidak kosong.
$getNoRekamMedis = function ($registration) use ($getMedicalRecord, $getNoKunjungan) {
    $mr = $getMedicalRecord($registration);

    if ($mr && !empty($mr->medical_record_no)) {
        return $mr->medical_record_no;
    }

    return $getNoKunjungan($registration);
};

$getDoctor = function ($registration) {
    return $registration->doctor->doctor_name
        ?? $registration->doctor->name
        ?? $registration->doctor_name
        ?? '-';
};

$getPoli = function ($registration) {
    return $registration->polyclinic_name
        ?? $registration->room_name
        ?? $registration->class_name
        ?? '-';
};

$getFirst = function ($items) {
    if (empty($items)) {
        return null;
    }
    if (is_array($items)) {
        return reset($items);
    }
    if (is_object($items) && method_exists($items, 'first')) {
        return $items->first();
    }
    foreach ($items as $item) {
        return $item;
    }
    return null;
};

$getDiagnoses = function ($mr, string $type): array {
    if (empty($mr) || empty($mr->medical_record_diagnoses)) {
        return [];
    }
    $rows = [];
    foreach ($mr->medical_record_diagnoses as $row) {
        if (strtoupper((string)($row->type ?? '')) === strtoupper($type)) {
            $rows[] = $row;
        }
    }
    return $rows;
};

$getServiceType = function ($registration): string {
    $type = strtolower((string)($registration->service_type ?? ''));
    if ($type === 'rawat_inap') {
        return 'rawat-inap';
    }
    if (in_array($type, ['rawat_jalan', 'igd'], true)) {
        return 'rawat-jalan-igd';
    }
    return 'rawat-jalan-igd';
};

$getServiceTypeLabel = function ($registration): string {
    $type = strtolower((string)($registration->service_type ?? ''));
    $labelMap = [
        'rawat_jalan' => 'Rawat Jalan',
        'igd'         => 'IGD',
        'rawat_inap'  => 'Rawat Inap',
    ];
    return $labelMap[$type] ?? 'Rawat Jalan';
};

$getServiceTypeBadgeClass = function ($registration): string {
    $type = strtolower((string)($registration->service_type ?? ''));
    $classMap = [
        'rawat_jalan' => 'badge-rawat-jalan',
        'igd'         => 'badge-igd',
        'rawat_inap'  => 'badge-rawat-inap',
    ];
    return $classMap[$type] ?? 'badge-rawat-jalan';
};

$getServiceTypeBadgeClass = function ($registration): string {
    $type = strtolower((string)($registration->service_type ?? ''));
    $classMap = [
        'rawat_jalan' => 'badge-rawat-jalan',
        'igd'         => 'badge-igd',
        'rawat_inap'  => 'badge-rawat-inap',
    ];
    return $classMap[$type] ?? 'badge-rawat-jalan';
};

$firstRegistration = $registrations[0] ?? null;
$firstRegistrationId = $firstRegistration->id ?? null;
?>

<?= $this->Krs->breadcrumb('Medical Record', 'Rekam Medis Pasien') ?>

    <!-- ── Header ── -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
            <i class="fa fa-folder-open"></i> Rekam Medis Pasien
        </h4>
        <div style="display:flex; gap:6px;">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCariPasien" id="btn-cari-pasien">
                <i class="fa fa-search"></i> Cari Pasien
            </button>
            <?php if (!empty($patient)): ?>
                <?= $this->Html->link(
                    '<i class="fa fa-notes-medical"></i> EMR History',
                    ['controller' => 'PatientHistories', 'action' => 'index', '?' => ['q' => $patient->code ?? '']],
                    ['escape' => false, 'class' => 'btn btn-warning btn-sm']
                ) ?>
            <?php endif; ?>
            <button type="button" class="btn btn-default btn-sm" onclick="window.location.reload()">
                <i class="fa fa-sync"></i> Refresh
            </button>
        </div>
    </div>

    <?php if ($q !== '' && $notFound): ?>
        <div class="alert alert-warning" style="padding:7px 12px; font-size:12px; margin-bottom:10px;">
            <i class="fa fa-exclamation-triangle"></i>
            Pasien dengan kode / nama <strong><?= h($q) ?></strong> tidak ditemukan.
        </div>
    <?php endif; ?>

    <!-- ── Info Pasien ── -->
    <div class="panel panel-default" style="margin-bottom:8px;">
        <div class="panel-body" style="padding:8px 10px; background:#f8f9fa; font-size:12px;">
            <?php if (empty($patient)): ?>
                <div style="text-align:center; color:#999; padding:6px 0;">
                    <i class="fa fa-user"></i> Belum ada pasien dipilih. Klik <strong>Cari Pasien</strong> untuk memulai.
                </div>
            <?php else: ?>
                <div class="row" style="margin-bottom:5px;">
                    <div class="col-md-2">
                        <small>Kode Pasien</small><br>
                        <strong><?= h($patient->code ?? '-') ?></strong>
                    </div>
                    <div class="col-md-3">
                        <small>Nama Pasien</small><br>
                        <strong><?= h($patient->full_name ?? '-') ?></strong>
                    </div>
                    <div class="col-md-2">
                        <small>Tgl Lahir</small><br>
                        <strong><?= $display($patient->birth_date ?? null) ?></strong>
                    </div>
                    <div class="col-md-1">
                        <small>JK</small><br>
                        <strong><?= $genderText($patient->gender ?? null) ?></strong>
                    </div>
                    <div class="col-md-2">
                        <small>Telepon</small><br>
                        <strong><?= h($patient->phone_number ?? '-') ?></strong>
                    </div>
                    <div class="col-md-2">
                        <small>Jumlah Kunjungan</small><br>
                        <strong style="font-size:16px; color:#1e3a5f;"><?= count($registrations) ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <small>Alamat</small><br>
                        <strong><?= h($patient->address ?? '-') ?></strong>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($registrations)): ?>

        <div class="panel panel-default">
            <div class="panel-body" style="padding:40px; text-align:center; color:#999;">
                <i class="fa fa-folder-open" style="font-size:34px; opacity:.3;"></i><br><br>
                Pilih pasien dari tombol <strong>Cari Pasien</strong> untuk menampilkan riwayat rekam medis.
            </div>
        </div>

    <?php else: ?>

    <div class="row">

        <!-- ════════════════════════════════════════════════════
             KOLOM KIRI — Riwayat Kunjungan
             ════════════════════════════════════════════════════ -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:8px 12px;">
                    <strong style="font-size:12px;"><i class="fa fa-calendar-alt"></i> Riwayat Kunjungan</strong>
                </div>
                <div class="panel-body" style="padding:8px;">
                    <div style="max-height:560px; overflow-y:auto;">
                        <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:0;">
                            <thead>
                                <tr style="background:#dbeafe;">
                                    <th>No Rekam Medis</th>
                                    <th style="width:78px;">Tgl Masuk</th>
                                    <th style="width:78px;">Tgl Keluar</th>
                                    <th>Dokter</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registrations as $i => $registration): ?>
                                    <tr class="mr-history-row <?= $i === 0 ? 'active' : '' ?>"
                                        data-history-id="<?= h($registration->id) ?>"
                                        data-service-type="<?= h($getServiceType($registration)) ?>"
                                        style="cursor:pointer;">
                                        <td>
                                            <strong><?= h($getNoRekamMedis($registration)) ?></strong>
                                            <br>
                                            <span class="mr-service-type-badge <?= h($getServiceTypeBadgeClass($registration)) ?>"><?= h($getServiceTypeLabel($registration)) ?></span>
                                        </td>
                                        <td><?= $display($getRegDate($registration)) ?></td>
                                        <td><?= $display($registration->discharge_date ?? $registration->check_out ?? null) ?></td>
                                        <td><?= h($getDoctor($registration)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             KOLOM KANAN — Detail Rekam Medis (tab per jenis layanan)
             ════════════════════════════════════════════════════ -->
        <div class="col-md-8">

            <div class="panel panel-default mr-tab-panel">
                <div class="panel-heading" style="padding:0;">
                    <ul class="nav nav-tabs mr-tabs" id="mr-service-tabs" role="tablist" style="border-bottom:none; margin:0;">
                        <li role="presentation" class="active" id="tab-li-rawat-inap">
                            <a href="#" data-tab="rawat-inap" style="font-size:11px; padding:9px 14px; font-weight:600;">
                                <i class="fa fa-bed"></i> Rawat Inap
                            </a>
                        </li>
                        <li role="presentation" id="tab-li-rawat-jalan-igd">
                            <a href="#" data-tab="rawat-jalan-igd" style="font-size:11px; padding:9px 14px; font-weight:600;">
                                <i class="fa fa-walking"></i> Rawat Jalan &amp; IGD
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#" data-tab="penunjang" style="font-size:11px; padding:9px 14px; font-weight:600;">
                                <i class="fa fa-flask"></i> Penunjang Medis
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="panel-body mr-tab-body" style="padding:12px; background:#fff;">

                    <?php foreach ($registrations as $i => $registration): ?>
                        <?php
                        $mr = $getMedicalRecord($registration);
                        $inpatient = $mr ? $getFirst($mr->medical_record_inpatients ?? []) : null;
                        $outIgd = $mr ? $getFirst($mr->medical_record_outpatient_igds ?? []) : null;
                        $icd10s = $getDiagnoses($mr, 'ICD10');
                        $icd9s = $getDiagnoses($mr, 'ICD9');
                        ?>
                        <div class="mr-panel <?= $i === 0 ? 'active' : '' ?>" data-panel-history-id="<?= h($registration->id) ?>" data-service-type="<?= h($getServiceType($registration)) ?>" style="<?= $i === 0 ? '' : 'display:none;' ?>">

                            <!-- ══ RAWAT INAP ══ -->
                            <div class="mr-tab-content <?= $i === 0 ? 'active' : '' ?>" data-tab-content="rawat-inap" style="<?= $i === 0 ? '' : 'display:none;' ?>">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="mr-field-label">Jenis</label>
                                        <div class="mr-radio-row">
                                            <label><input type="radio" disabled <?= ($inpatient->jenis ?? '') === 'Umum' ? 'checked' : '' ?>> Umum</label>
                                            <label><input type="radio" disabled <?= ($inpatient->jenis ?? '') === 'Obstetri' ? 'checked' : '' ?>> Obstetri</label>
                                            <label><input type="radio" disabled <?= ($inpatient->jenis ?? '') === 'Perinatologi' ? 'checked' : '' ?>> Perinatologi</label>
                                        </div>

                                        <div class="mr-field"><label>Tgl Masuk</label><input class="form-control input-sm" readonly value="<?= $display($inpatient->tgl_masuk ?? $getRegDate($registration)) ?>"></div>
                                        <div class="mr-field"><label>Tgl Operasi/Tindakan</label><input class="form-control input-sm" readonly value="<?= $display($inpatient->tgl_operasi ?? null) ?>"></div>
                                        <div class="mr-field"><label>Tgl Keluar</label><input class="form-control input-sm" readonly value="<?= $display($inpatient->tgl_keluar ?? $registration->discharge_date ?? $registration->check_out ?? null) ?>"></div>
                                        <div class="mr-field"><label>Nama Dokter</label><input class="form-control input-sm" readonly value="<?= h($inpatient->nama_dokter ?? $getDoctor($registration)) ?>"></div>
                                        <div class="mr-field"><label>Operasi/Tindakan</label><input class="form-control input-sm" readonly value="<?= h($inpatient->operasi ?? '') ?>"></div>
                                        <div class="mr-field"><label>Golongan Operasi</label><input class="form-control input-sm" readonly value="<?= h($inpatient->golongan_operasi ?? '') ?>"></div>
                                        <div class="mr-field"><label>Tempat Operasi</label><input class="form-control input-sm" readonly value="<?= h($inpatient->tempat_operasi ?? '') ?>"></div>

                                        <label class="mr-field-label">Infeksi Nosokomial</label>
                                        <div class="mr-radio-row">
                                            <label><input type="radio" disabled <?= ($inpatient->infeksi_nosokomial ?? '') === 'Ada' ? 'checked' : '' ?>> Ada</label>
                                            <label><input type="radio" disabled <?= ($inpatient->infeksi_nosokomial ?? '') === 'Tidak Ada' ? 'checked' : '' ?>> Tidak Ada</label>
                                        </div>
                                        <div class="mr-field"><label>Penyebab Infeksi</label><input class="form-control input-sm" readonly value="<?= h($inpatient->penyebab_infeksi ?? '') ?>"></div>
                                        <div class="mr-radio-row" style="margin-bottom:6px;">
                                            <label><input type="radio" disabled <?= ($inpatient->jenis_infeksi ?? '') === 'Kateter' ? 'checked' : '' ?>> Kateter</label>
                                            <label><input type="radio" disabled <?= ($inpatient->jenis_infeksi ?? '') === 'Operasi' ? 'checked' : '' ?>> Operasi</label>
                                            <label><input type="radio" disabled <?= ($inpatient->jenis_infeksi ?? '') === 'Injeksi' ? 'checked' : '' ?>> Injeksi</label>
                                            <label><input type="radio" disabled <?= ($inpatient->jenis_infeksi ?? '') === 'Beresiko' ? 'checked' : '' ?>> Beresiko</label>
                                        </div>
                                        <div class="mr-field"><label>Keturunan Ketidakmampuan &amp; Kelainan</label><input class="form-control input-sm" readonly value="<?= h($inpatient->keturunan_kelainan ?? '') ?>"></div>

                                        <label class="mr-field-label">Transfusi Darah</label>
                                        <div class="mr-radio-row">
                                            <label><input type="radio" disabled <?= ($inpatient->transfusi ?? '') === 'Tidak' ? 'checked' : '' ?>> Tidak</label>
                                            <label><input type="radio" disabled <?= ($inpatient->transfusi ?? '') === 'Ya' ? 'checked' : '' ?>> Ya</label>
                                        </div>
                                        <div class="mr-field"><input class="form-control input-sm" readonly placeholder="Keterangan transfusi" value="<?= h($inpatient->transfusi_keterangan ?? '') ?>"></div>
                                    </div>

                                    <div class="col-md-8">
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div style="background:#f0f9ff; border:1px solid #bee3f8; border-radius:6px; padding:8px;">
                                            <div style="font-size:10px; font-weight:700; color:#2b6cb0; margin-bottom:6px;">
                                                <i class="fa fa-hospital"></i> DATA RUANG &amp; KELUAR
                                            </div>
                                            <div class="mr-field"><label>Ruang</label><input class="form-control input-sm" readonly value="<?= h($inpatient->ruang ?? $registration->room->room_name ?? $registration->room_name ?? '') ?>"></div>
                                            <div class="mr-field"><label>Bed / Kamar</label><input class="form-control input-sm" readonly value="<?= h($inpatient->bed ?? $registration->bed->name ?? $registration->bed->bed_no ?? '') ?>"></div>
                                            <div class="mr-field"><label>Kelas</label><input class="form-control input-sm" readonly value="<?= h($inpatient->kelas ?? $registration->class_name ?? '') ?>"></div>
                                            <div class="mr-field"><label>Prosedur Masuk</label><input class="form-control input-sm" readonly value="<?= h($inpatient->prosedur_masuk ?? $inpatient->cara_masuk ?? '') ?>"></div>
                                            <div class="mr-field"><label>Cara Masuk</label><input class="form-control input-sm" readonly value="<?= h($inpatient->cara_masuk ?? '') ?>"></div>
                                            <div class="mr-field"><label>Keadaan Keluar</label><input class="form-control input-sm" readonly value="<?= h($inpatient->keadaan_keluar_rs ?? '') ?>"></div>
                                            <div class="mr-field"><label>Cara Keluar</label><input class="form-control input-sm" readonly value="<?= h($inpatient->cara_keluar ?? '') ?>"></div>
                                            <div class="mr-field"><label>Cara Bayar</label><input class="form-control input-sm" readonly value="<?= h($inpatient->cara_bayar ?? $registration->payment_method ?? '') ?>"></div>
                                            <div class="mr-field" style="margin-bottom:0;"><label>Rekanan</label><input class="form-control input-sm" readonly value="<?= h($inpatient->rekanan ?? '') ?>"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div style="background:#fdf4ff; border:1px solid #f3e8ff; border-radius:6px; padding:8px; margin-bottom:10px;">
                                            <div style="font-size:10px; font-weight:700; color:#6f42c1; margin-bottom:6px;">
                                                <i class="fa fa-baby"></i> DATA KEBIDANAN
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label class="mr-field-label">Tempat Melahirkan</label>
                                                    <div class="mr-radio-row" style="flex-direction:column; gap:2px;">
                                                        <label><input type="radio" disabled <?= ($inpatient->tempat_melahirkan ?? '') === 'DRS' ? 'checked' : '' ?>> DRS</label>
                                                        <label><input type="radio" disabled <?= ($inpatient->tempat_melahirkan ?? '') === 'DI/luar RS' ? 'checked' : '' ?>> Di luar RS</label>
                                                    </div>
                                                    <label class="mr-field-label">Pelayanan Antenatal</label>
                                                    <div class="mr-radio-row" style="flex-direction:column; gap:2px;">
                                                        <label><input type="radio" disabled <?= ($inpatient->pelayanan_antenatal ?? '') === 'Tidak ada' ? 'checked' : '' ?>> Tidak ada</label>
                                                        <label><input type="radio" disabled <?= ($inpatient->pelayanan_antenatal ?? '') === 'Ada 1-3x' ? 'checked' : '' ?>> Ada 1-3x</label>
                                                        <label><input type="radio" disabled <?= ($inpatient->pelayanan_antenatal ?? '') === 'Ada >4x' ? 'checked' : '' ?>> Ada 4x+</label>
                                                    </div>
                                                    <label class="mr-field-label">Asal</label>
                                                    <div class="mr-radio-row" style="flex-direction:column; gap:2px;">
                                                        <label><input type="radio" disabled <?= ($inpatient->asal_pasien ?? '') === 'Pasien RS' ? 'checked' : '' ?>> Pasien RS</label>
                                                        <label><input type="radio" disabled <?= ($inpatient->asal_pasien ?? '') === 'Rujukan' ? 'checked' : '' ?>> Rujukan</label>
                                                        <label><input type="radio" disabled <?= ($inpatient->asal_pasien ?? '') === 'Dirujuk' ? 'checked' : '' ?>> Dirujuk</label>
                                                    </div>
                                                    <label class="mr-field-label">Persalinan Ke</label>
                                                    <div class="mr-radio-row" style="flex-direction:column; gap:2px;">
                                                        <label><input type="radio" disabled <?= ($inpatient->persalinan_ke ?? '') === 'Tunggal' ? 'checked' : '' ?>> Tunggal</label>
                                                        <label><input type="radio" disabled <?= ($inpatient->persalinan_ke ?? '') === 'Kembar' ? 'checked' : '' ?>> Kembar</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="mr-field"><label>Cara Melahirkan</label><input class="form-control input-sm" readonly value="<?= h($inpatient->cara_melahirkan ?? '') ?>"></div>
                                                    <div class="mr-field"><label>Penyebab Abortus</label><input class="form-control input-sm" readonly value="<?= h($inpatient->penyebab_abortus ?? '') ?>"></div>
                                                    <div class="mr-field"><label>Masa Gestasi</label><input class="form-control input-sm" readonly value="<?= h($inpatient->masa_gestasi ?? '') ?>"></div>
                                                    <div class="mr-field"><label>Tgl Melahirkan</label><input class="form-control input-sm" readonly value="<?= $display($inpatient->tgl_melahirkan ?? null) ?>"></div>
                                                    <div class="mr-field"><label>Jumlah Bayi</label><input class="form-control input-sm" readonly value="<?= h($inpatient->jumlah_bayi ?? '') ?>"></div>
                                                    <div class="mr-field">
                                                        <label>Keadaan Lahir</label>
                                                        <input class="form-control input-sm" readonly value="<?= h($inpatient->keadaan_lahir ?? '') ?>">
                                                        <label style="margin-top:3px; font-weight:400;"><input type="checkbox" disabled <?= !empty($inpatient->bayi_neonatal) ? 'checked' : '' ?>> Mati Neonatal &lt; 7 Hari</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-bordered table-sm" style="font-size:10px; margin-bottom:0;">
                                                <tr><td>Berat Lahir</td><td><?= h($inpatient->berat_lahir ?? '0.00') ?></td><td>Panjang</td><td><?= h($inpatient->panjang_lahir ?? '0.00') ?></td></tr>
                                                <tr><td>Lahir Hidup</td><td><?= h($inpatient->jumlah_lahir_hidup ?? '0') ?></td><td colspan="2"><input type="checkbox" disabled <?= !empty($inpatient->imunisasi_tti) ? 'checked' : '' ?>> Imunisasi TTI</td></tr>
                                                <tr><td>Lahir Mati</td><td><?= h($inpatient->jumlah_lahir_mati ?? '0') ?></td><td colspan="2"><input type="checkbox" disabled <?= !empty($inpatient->imunisasi_tt2) ? 'checked' : '' ?>> Imunisasi TT2</td></tr>
                                                <tr><td>Abortus</td><td colspan="3"><?= h($inpatient->jumlah_abortus ?? '0') ?></td></tr>
                                            </table>
                                        </div>
                                    </div>
                                    </div><!-- /row data ruang & kebidanan -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label style="font-size:11px; font-weight:700; color:#1e3a5f;">
                                                <i class="fa fa-diagnoses"></i> ICD-10
                                            </label>
                                            <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:0;">
                                                <thead>
                                                    <tr style="background:#dbeafe;">
                                                        <th style="width:70px;">Kode</th>
                                                        <th>Diagnosa</th>
                                                        <th style="width:60px; text-align:center;">Utama</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (empty($icd10s)): ?>
                                                        <tr><td colspan="3" style="text-align:center; color:#aaa; padding:20px;">Belum ada diagnosa ICD-10.</td></tr>
                                                    <?php else: ?>
                                                        <?php foreach ($icd10s as $d): ?>
                                                            <tr>
                                                                <td style="font-family:monospace; font-weight:700;"><?= h($d->code ?? '') ?></td>
                                                                <td><?= h($d->diagnosis ?? '') ?></td>
                                                                <td class="text-center"><input type="checkbox" disabled <?= !empty($d->is_primary) ? 'checked' : '' ?>></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-6">
                                            <label style="font-size:11px; font-weight:700; color:#6f42c1;">
                                                <i class="fa fa-clipboard-list"></i> ICD-9 CM
                                            </label>
                                            <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:0;">
                                                <thead>
                                                    <tr style="background:#f3e8ff;">
                                                        <th style="width:70px;">Kode</th>
                                                        <th>Diagnosa</th>
                                                        <th style="width:60px; text-align:center;">Utama</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (empty($icd9s)): ?>
                                                        <tr><td colspan="3" style="text-align:center; color:#aaa; padding:20px;">Belum ada tindakan ICD-9.</td></tr>
                                                    <?php else: ?>
                                                        <?php foreach ($icd9s as $d): ?>
                                                            <tr>
                                                                <td style="font-family:monospace; font-weight:700;"><?= h($d->code ?? '') ?></td>
                                                                <td><?= h($d->diagnosis ?? '') ?></td>
                                                                <td class="text-center"><input type="checkbox" disabled <?= !empty($d->is_primary) ? 'checked' : '' ?>></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- /row icd10 icd9 -->

                                    </div><!-- /col-md-8 wrapper -->
                                </div>
                            </div><!-- /rawat-inap -->

                            <!-- ══ RAWAT JALAN & IGD ══ -->
                            <div class="mr-tab-content" data-tab-content="rawat-jalan-igd" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mr-field"><label>Tgl Masuk</label><input class="form-control input-sm" readonly value="<?= $display($getRegDate($registration)) ?>"></div>
                                        <div class="mr-field"><label>Tgl Operasi/Tindakan</label><input class="form-control input-sm" readonly value="<?= $display($outIgd->tgl_operasi ?? null) ?>"></div>
                                        <div class="mr-field"><label>Tgl Keluar</label><input class="form-control input-sm" readonly value="<?= $display($outIgd->tgl_keluar ?? $registration->discharge_date ?? $registration->check_out ?? null) ?>"></div>
                                        <div class="mr-field"><label>Pelayanan RJ</label><input class="form-control input-sm" readonly value="<?= h($getPoli($registration)) ?>"></div>
                                        <div class="mr-field"><label>Pelayanan Gawat Darurat</label><input class="form-control input-sm" readonly value="<?= h($outIgd->pelayanan_gawat_darurat ?? '') ?>"></div>
                                        <div class="mr-field"><label>Prosedur Masuk RS</label><input class="form-control input-sm" readonly value="<?= h($outIgd->prosedur_masuk_rs ?? '') ?>"></div>
                                        <div class="mr-field"><label>Cara Masuk RS</label><input class="form-control input-sm" readonly value="<?= h($outIgd->cara_masuk ?? '') ?>"></div>
                                        <div class="mr-field"><label>Operasi/Tindakan</label><input class="form-control input-sm" readonly value="<?= h($outIgd->operasi_tindakan ?? '') ?>"></div>
                                        <div class="mr-field"><label>Golongan Operasi</label><input class="form-control input-sm" readonly value="<?= h($outIgd->golongan_operasi ?? '') ?>"></div>
                                        <div class="mr-field"><label>Tempat Operasi</label><input class="form-control input-sm" readonly value="<?= h($outIgd->tempat_operasi ?? '') ?>"></div>

                                        <label class="mr-field-label">Infeksi Nosokomial</label>
                                        <div class="mr-radio-row">
                                            <label><input type="radio" disabled <?= ($outIgd->infeksi_nosokomial ?? '') === 'Ada' ? 'checked' : '' ?>> Ada</label>
                                            <label><input type="radio" disabled <?= ($outIgd->infeksi_nosokomial ?? '') === 'Tidak Ada' ? 'checked' : '' ?>> Tidak Ada</label>
                                        </div>
                                        <div class="mr-field"><label>Penyebab Infeksi</label><input class="form-control input-sm" readonly value="<?= h($outIgd->penyebab_infeksi ?? '') ?>"></div>
                                        <div class="mr-radio-row" style="margin-bottom:6px;">
                                            <label><input type="radio" disabled> Kateter</label>
                                            <label><input type="radio" disabled> Operasi</label>
                                            <label><input type="radio" disabled> Injeksi</label>
                                            <label><input type="radio" disabled> Beresiko</label>
                                        </div>
                                        <div class="mr-field"><label>Keturunan Ketidakmampuan &amp; Kelainan</label><input class="form-control input-sm" readonly value="<?= h($outIgd->keturunan_kelainan ?? '') ?>"></div>
                                        <div class="mr-field" style="margin-bottom:0;"><label>Transfusi</label><input class="form-control input-sm" readonly value="<?= h($outIgd->transfusi ?? '') ?>"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mr-field"><label>Triage</label><input class="form-control input-sm" readonly value="<?= h($outIgd->triage ?? '') ?>"></div>
                                        <div class="mr-field"><label>Keadaan Keluar</label><input class="form-control input-sm" readonly value="<?= h($outIgd->keadaan_keluar ?? '') ?>"></div>
                                        <div class="mr-field"><label>Penyebab Kematian (bila pasien meninggal)</label><input class="form-control input-sm" readonly value="<?= h($outIgd->penyebab_kematian ?? '') ?>"></div>
                                        <div class="mr-field"><label>Cara Keluar</label><input class="form-control input-sm" readonly value="<?= h($outIgd->cara_keluar ?? '') ?>"></div>
                                        <div class="mr-field"><label>Cara Bayar</label><input class="form-control input-sm" readonly value="<?= h($outIgd->cara_bayar ?? $registration->payment_method ?? '') ?>"></div>
                                        <div class="mr-field"><label>Rekanan</label><input class="form-control input-sm" readonly value="<?= h($outIgd->rekanan ?? '') ?>"></div>

                                        <label style="font-size:11px; font-weight:700; color:#1e3a5f;"><i class="fa fa-diagnoses"></i> ICD-10</label>
                                        <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:10px;">
                                            <thead><tr style="background:#dbeafe;"><th style="width:60px;">Kode</th><th>Diagnosa</th><th style="width:52px; text-align:center;">Utama</th></tr></thead>
                                            <tbody>
                                                <?php if (empty($icd10s)): ?>
                                                    <tr><td colspan="3" style="text-align:center; color:#aaa; padding:8px;">Belum ada diagnosa ICD-10.</td></tr>
                                                <?php else: ?>
                                                    <?php foreach ($icd10s as $d): ?>
                                                        <tr>
                                                            <td style="font-family:monospace; font-weight:700;"><?= h($d->code ?? '') ?></td>
                                                            <td><?= h($d->diagnosis ?? '') ?></td>
                                                            <td class="text-center"><input type="checkbox" disabled <?= !empty($d->is_primary) ? 'checked' : '' ?>></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>

                                        <label style="font-size:11px; font-weight:700; color:#6f42c1;"><i class="fa fa-clipboard-list"></i> ICD-9 CM</label>
                                        <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:0;">
                                            <thead><tr style="background:#f3e8ff;"><th style="width:60px;">Kode</th><th>Diagnosa</th><th style="width:52px; text-align:center;">Utama</th></tr></thead>
                                            <tbody>
                                                <?php if (empty($icd9s)): ?>
                                                    <tr><td colspan="3" style="text-align:center; color:#aaa; padding:8px;">Belum ada tindakan ICD-9.</td></tr>
                                                <?php else: ?>
                                                    <?php foreach ($icd9s as $d): ?>
                                                        <tr>
                                                            <td style="font-family:monospace; font-weight:700;"><?= h($d->code ?? '') ?></td>
                                                            <td><?= h($d->diagnosis ?? '') ?></td>
                                                            <td class="text-center"><input type="checkbox" disabled <?= !empty($d->is_primary) ? 'checked' : '' ?>></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /rawat-jalan-igd -->

                            <!-- ══ PENUNJANG MEDIS ══ -->
                            <div class="mr-tab-content" data-tab-content="penunjang" style="display:none;">
                                <div style="text-align:center; color:#999; padding:40px 10px; background:#f8f9fa; border-radius:6px;">
                                    <i class="fa fa-flask" style="font-size:30px; opacity:.3;"></i><br><br>
                                    Penunjang medis akan menampilkan data dari order lab, radiologi, resep, bedah, gizi, dan dokumen terkait.
                                </div>
                            </div><!-- /penunjang -->

                        </div><!-- /mr-panel -->
                    <?php endforeach; ?>

                </div>
            </div><!-- /mr-tab-panel -->

            <!-- ── Alergi ── -->
            <?php
            $activeMr = $firstRegistrationId ? $getMedicalRecord($firstRegistration) : null;
            ?>
            <div class="panel panel-default" style="margin-top:10px;">
                <div class="panel-body" style="padding:8px 12px; background:#fff5f5;">
                    <label style="font-size:11px; font-weight:700; color:#dc3545; margin-bottom:4px;">
                        <i class="fa fa-exclamation-triangle"></i> Alergi
                    </label>
                    <textarea class="form-control" rows="2" readonly
                              style="font-size:12px; resize:none;"><?= h($activeMr->allergy ?? '') ?></textarea>
                </div>
            </div>

        </div><!-- /col kanan -->
    </div><!-- /row -->

    <?php endif; ?>

</div>

<!-- ── MODAL CARI PASIEN ── -->
<div class="modal fade" id="modalCariPasien" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:4px;">
            <div class="modal-header" style="background:#1e3a5f; color:#fff; padding:10px 15px; display:flex; align-items:center; justify-content:space-between;">
                <h4 class="modal-title" style="font-size:14px; font-weight:700; margin:0;">
                    <i class="fa fa-search"></i> Cari Pasien
                </h4>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:.9; margin:0; float:none; background:none; border:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding:12px;">
                <div class="input-group input-group-sm" style="margin-bottom:10px;">
                    <span class="input-group-addon" style="background:#1e3a5f; color:#fff; border-color:#1e3a5f;">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" id="patient-search-modal-input" class="form-control"
                           placeholder="Ketik kode pasien / nama / NIK / telepon / alamat" autocomplete="off">
                </div>
                <div style="max-height:360px; overflow-y:auto; border:1px solid #dee2e6; border-radius:4px;">
                    <table class="table table-bordered table-sm" style="font-size:11px; margin-bottom:0;">
                        <thead>
                            <tr style="background:#dbeafe;">
                                <th style="width:90px;">No Pasien</th>
                                <th>Nama Pasien</th>
                                <th style="width:80px;">Tgl Lahir</th>
                                <th style="width:45px;">JK</th>
                                <th>Alamat</th>
                                <th style="width:105px;">Phone</th>
                                <th style="width:55px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="patient-result-body">
                            <tr><td colspan="7" style="text-align:center; color:#aaa; padding:14px;">Ketik kata kunci pasien, hasil langsung muncul di bawah.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.mr-field { margin-bottom: 6px; }
.mr-field label {
    font-size: 10px; color: #888; margin-bottom: 2px;
    display: block; font-weight: 600;
}
.mr-field-label {
    font-size: 10px; color: #888; font-weight: 700;
    display: block; margin: 6px 0 3px;
}
.mr-radio-row { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 6px; font-size: 12px; }
.mr-radio-row label { font-weight: 400; margin: 0; }

.mr-history-row:hover td { background: #eef4ff; }
.mr-history-row.active td { background: #1e3a5f !important; color: #fff !important; font-weight: 600; }

.mr-service-type-badge {
    display: inline-block;
    font-size: 9px;
    font-weight: 700;
    border-radius: 3px;
    padding: 1px 6px;
    margin-top: 2px;
}

/* Rawat Jalan = hijau */
.mr-service-type-badge.badge-rawat-jalan {
    color: #198754;
    background: #e6f7ec;
}

/* IGD = merah/oranye (darurat) */
.mr-service-type-badge.badge-igd {
    color: #dc3545;
    background: #fdecea;
}

/* Rawat Inap = ungu */
.mr-service-type-badge.badge-rawat-inap {
    color: #6f42c1;
    background: #f3e8ff;
}

/* Saat baris riwayat lagi aktif/dipilih (background biru tua) */
.mr-history-row.active .mr-service-type-badge {
    background: rgba(255,255,255,0.2);
    color: #fff;
}

.mr-tab-panel { background: #fff; border: 1px solid #ddd; }
.mr-tab-panel > .panel-heading { background: #f5f7fa !important; border-bottom: 1px solid #d9d9d9; min-height: 42px; }
#mr-service-tabs.mr-tabs {
    background: #f5f7fa; border-bottom: 0 !important; padding-top: 0;
}
#mr-service-tabs.mr-tabs > li > a {
    border-radius: 0 !important; color: #333 !important; background: #f5f7fa !important;
    border: 1px solid transparent !important; border-right: 1px solid #d9d9d9 !important;
    min-height: 42px; line-height: 22px; margin-right: 0 !important; cursor: pointer;
}
#mr-service-tabs.mr-tabs > li.active > a,
#mr-service-tabs.mr-tabs > li.active > a:hover,
#mr-service-tabs.mr-tabs > li.active > a:focus {
    background: #1e3a5f !important; color: #fff !important; border-color: #1e3a5f !important;
}
#mr-service-tabs.mr-tabs > li > a:hover { background: #e9eef5 !important; color: #1e3a5f !important; }
.mr-tab-body { border-top: 0; min-height: 300px; }

.panel-heading strong { font-size: 12px; }
</style>

<script>
$(document).ready(function () {

    // ── Toggle tab sesuai jenis pelayanan registrasi ──
    function applyServiceTypeTabs(serviceType) {
        if (serviceType === 'rawat-inap') {
            $('#tab-li-rawat-inap').show();
            $('#tab-li-rawat-jalan-igd').hide();
            $('#mr-service-tabs a[data-tab="rawat-inap"]').trigger('click');
        } else {
            $('#tab-li-rawat-jalan-igd').show();
            $('#tab-li-rawat-inap').hide();
            $('#mr-service-tabs a[data-tab="rawat-jalan-igd"]').trigger('click');
        }
    }

    // ── Toggle riwayat kunjungan ──
    $(document).on('click', '.mr-history-row', function () {
        var historyId = $(this).data('history-id').toString();
        var serviceType = $(this).data('service-type');

        $('.mr-history-row').removeClass('active');
        $(this).addClass('active');

        $('.mr-panel').hide().removeClass('active');
        $('.mr-panel[data-panel-history-id="' + historyId + '"]').show().addClass('active');

        applyServiceTypeTabs(serviceType);
    });

    // ── Toggle tab layanan (berlaku untuk panel riwayat yang sedang aktif) ──
    $('#mr-service-tabs a').on('click', function (e) {
        e.preventDefault();
        var tab = $(this).data('tab');

        $('#mr-service-tabs li').removeClass('active');
        $('#mr-service-tabs a').removeClass('active-tab-link');
        $(this).closest('li').addClass('active');
        $(this).addClass('active-tab-link');

        var $activePanel = $('.mr-panel.active');
        $activePanel.find('.mr-tab-content').hide().removeClass('active');
        $activePanel.find('.mr-tab-content[data-tab-content="' + tab + '"]').show().addClass('active');
    });
    $('#mr-service-tabs a').first().addClass('active-tab-link');

    var $firstHistoryRow = $('.mr-history-row').first();
    if ($firstHistoryRow.length) {
        applyServiceTypeTabs($firstHistoryRow.data('service-type'));
    }

    // ── Cari pasien (AJAX) ──
    function escapeHtml(text) {
        return String(text || '')
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    function renderPatientRows(rows, term) {
        var $tbody = $('#patient-result-body');
        if (!rows || rows.length === 0) {
            $tbody.html('<tr><td colspan="7" style="text-align:center;color:#aaa;padding:14px;">Data pasien tidak ditemukan.</td></tr>');
            return;
        }
        var html = '';
        $.each(rows, function (_, p) {
            var code = p.code || '';
            var url = <?= json_encode($this->Url->build(['action' => 'index'])) ?> + '?q=' + encodeURIComponent(code);
            html += '<tr>'
                + '<td><a href="' + escapeHtml(url) + '"><strong>' + escapeHtml(code || '-') + '</strong></a></td>'
                + '<td><a href="' + escapeHtml(url) + '">' + escapeHtml(p.full_name || '-') + '</a></td>'
                + '<td><a href="' + escapeHtml(url) + '">' + escapeHtml(p.birth_date || '-') + '</a></td>'
                + '<td><a href="' + escapeHtml(url) + '">' + escapeHtml(p.gender || '-') + '</a></td>'
                + '<td><a href="' + escapeHtml(url) + '">' + escapeHtml(p.address || '-') + '</a></td>'
                + '<td><a href="' + escapeHtml(url) + '">' + escapeHtml(p.phone_number || '-') + '</a></td>'
                + '<td class="text-center"><a href="' + escapeHtml(url) + '" class="btn btn-primary btn-xs"><i class="fa fa-check"></i></a></td>'
                + '</tr>';
        });
        $tbody.html(html);
    }

    var searchTimer = null;
    var searchXhr = null;

    function doSearchPatients(term) {
        if (searchXhr && searchXhr.abort) { searchXhr.abort(); }
        $('#patient-result-body').html('<tr><td colspan="7" style="text-align:center;color:#aaa;padding:14px;"><i class="fa fa-spinner fa-spin"></i> Memuat data pasien...</td></tr>');

        var url = <?= json_encode($this->Url->build(['action' => 'searchPatients'])) ?> + '?term=' + encodeURIComponent(term) + '&limit=50';
        searchXhr = $.ajax({
            url: url,
            dataType: 'json',
            success: function (res) {
                renderPatientRows(res && res.data ? res.data : [], term);
            },
            error: function (xhr, status) {
                if (status !== 'abort') {
                    console.error('searchPatients gagal:', status, xhr && xhr.responseText);
                    renderPatientRows([], term);
                }
            }
        });
    }

    // ── Trigger utama: saat modal Bootstrap selesai tampil ──
    $('#modalCariPasien').on('shown.bs.modal', function () {
        $('#patient-search-modal-input').val('').focus();
        doSearchPatients(''); // tampilkan semua data begitu modal dibuka
    });

    // ── Trigger cadangan: langsung saat tombol "Cari Pasien" diklik ──
    // Ini jaga-jaga kalau event shown.bs.modal tidak konsisten terpanggil
    // (misal karena versi Bootstrap/plugin modal yang dipakai berbeda).
    $(document).on('click', '#btn-cari-pasien', function () {
        setTimeout(function () {
            $('#patient-search-modal-input').val('').focus();
            doSearchPatients('');
        }, 150);
    });

    $('#patient-search-modal-input').on('input', function () {
        clearTimeout(searchTimer);
        var term = $.trim($(this).val());
        searchTimer = setTimeout(function () {
            doSearchPatients(term); // semakin banyak diketik, semakin spesifik hasilnya
        }, 250);
    });

});
</script>