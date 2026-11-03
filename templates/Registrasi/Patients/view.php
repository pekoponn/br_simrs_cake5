<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */

$dataChild = $this->Html->link('Patient', ['action' => 'index'], ['full_base' => true]);
$canViewPatientHistory = !empty($checkUrl['medicalrecords']['history']);

$display = function ($value, $empty = '-') {
    if ($value === null || $value === '') {
        return $empty;
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return h($value->format('d-m-Y'));
    }

    return h($value);
};

$formatDateTime = function ($value) use ($display) {
    if (empty($value)) {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return h($value->format('d-m-Y H:i'));
    }

    $timestamp = strtotime((string)$value);

    return $timestamp ? h(date('d-m-Y H:i', $timestamp)) : $display($value);
};

$medicalRecordNo = $patient->medical_record_no ?? $patient->code ?? null;
$patientCode = $patient->code ?? null;
$genderLabel = [
    'Male' => 'Laki-laki',
    'Female' => 'Perempuan',
    'L' => 'Laki-laki',
    'P' => 'Perempuan',
][$patient->gender ?? ''] ?? ($patient->gender ?? null);

$statusLabel = ($patient->is_active ?? 'Y') === 'Y' ? 'Aktif' : 'Tidak Aktif';
$statusClass = ($patient->is_active ?? 'Y') === 'Y' ? 'label-success' : 'label-danger';

$province = $patient->province ?? $patient->id_prov ?? null;
$city = $patient->city ?? $patient->id_kab ?? null;
$district = $patient->district ?? $patient->id_kec ?? null;
$subdistrict = $patient->subdistrict ?? $patient->id_kel ?? null;
$personResponsibles = [];

foreach (($patient->registrations ?? []) as $registration) {
    if (!empty($registration->person_responsible)) {
        $personResponsibles[$registration->person_responsible->id] = $registration->person_responsible;
    }
}

function fmtPatientDate($val, $fmt = 'd-m-Y') {
    if (empty($val)) return '—';
    if ($val instanceof \Cake\I18n\FrozenDate || $val instanceof \Cake\I18n\Date) {
        return $val->format($fmt);
    }
    if ($val instanceof \Cake\I18n\FrozenTime || $val instanceof \Cake\I18n\Time) {
        return $val->format($fmt);
    }
    $ts = strtotime((string)$val);
    return $ts ? date($fmt, $ts) : '—';
}
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Detail') ?>

<style>
    .patient-view-hero {
        border: 1px solid #e5ebf2;
        border-radius: 8px;
        background: #fff;
        padding: 22px 24px;
        margin-bottom: 18px;
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: flex-start;
    }

    .patient-view-hero h3 {
        margin: 4px 0 6px;
        font-size: 26px;
        font-weight: 700;
        color: #1f2d3d;
    }

    .patient-view-hero .rm {
        color: #348fe2;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: .2px;
    }

    .patient-view-hero .meta {
        color: #6c7a89;
        font-size: 13px;
    }

    .patient-action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: flex-end;
    }

    .patient-summary-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(130px, 1fr));
        gap: 10px;
        margin-top: 18px;
    }

    .patient-summary-item {
        border: 1px solid #e8edf3;
        border-radius: 6px;
        background: #fafbfc;
        padding: 12px 14px;
    }

    .patient-summary-item .label-text,
    .patient-detail-item .label-text {
        color: #6c757d;
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .patient-summary-item .value,
    .patient-detail-item .value {
        color: #1f2d3d;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
        word-break: break-word;
    }

    .patient-section {
        border: 1px solid #e5ebf2;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 18px;
        overflow: hidden;
    }

    .patient-section-header {
        padding: 14px 16px;
        border-bottom: 1px solid #edf1f5;
        background: #fafbfd;
        font-size: 15px;
        font-weight: 700;
        color: #1f2d3d;
    }

    .patient-section-header i {
        margin-right: 7px;
        color: #348fe2;
    }

    .patient-section-body {
        padding: 16px;
    }

    .patient-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(170px, 1fr));
        gap: 12px;
    }

    .patient-detail-grid.two {
        grid-template-columns: repeat(2, minmax(170px, 1fr));
    }

    .patient-detail-grid.one {
        grid-template-columns: 1fr;
    }

    .patient-detail-item {
        border-bottom: 1px solid #f0f2f5;
        padding: 4px 0 10px;
    }

    .patient-empty {
        border: 1px dashed #cfd8e3;
        border-radius: 6px;
        color: #6c757d;
        text-align: center;
        padding: 22px;
        font-weight: 600;
        background: #fbfcfd;
    }

    .patient-related-table th {
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .patient-view-hero {
            display: block;
        }

        .patient-action-bar {
            justify-content: flex-start;
            margin-top: 14px;
        }

        .patient-summary-grid,
        .patient-detail-grid,
        .patient-detail-grid.two {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-user"></i> Detail Master Patient
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="patient-view-hero">
            <div>
                <div class="rm"><?= $display($medicalRecordNo) ?></div>
                <h3><?= $display($patient->full_name) ?></h3>
                <div class="meta">
                   Kode Pasien: <?= $display($patientCode) ?> |
                    <?= $display($patient->identity_type) ?>
                    <?= !empty($patient->identity_number) ? ' - ' . h($patient->identity_number) : '' ?>
                    |
                    <span class="label <?= $statusClass ?>"><?= h($statusLabel) ?></span>
                </div>

                <div class="patient-summary-grid">
                    <div class="patient-summary-item">
                        <div class="label-text">No Rekam Medis</div>
                        <div class="value"><?= $display($medicalRecordNo) ?></div>
                    </div>
                    <div class="patient-summary-item">
                        <div class="label-text">Rekam Medis</div>
                        <div class="value"><?= $display($patientCode) ?></div>
                    </div>
                    <div class="patient-summary-item">
                        <div class="label-text">Telepon</div>
                        <div class="value"><?= $display($patient->phone_number) ?></div>
                    </div>
                    <div class="patient-summary-item">
                        <div class="label-text">Jenis Kelamin</div>
                        <div class="value"><?= $display($genderLabel) ?></div>
                    </div>
                    <div class="patient-summary-item">
                        <div class="label-text">Tanggal Lahir</div>
                        <div class="value"><?= $display($patient->birth_date) ?></div>
                    </div>
                </div>
            </div>

            <div class="patient-action-bar">
                <?= $this->Html->link(
                    '<i class="fa fa-arrow-left"></i> Kembali',
                    ['action' => 'index'],
                    ['class' => 'btn btn-default btn-sm', 'escape' => false]
                ) ?>

                <?= $this->Html->link(
                    '<i class="fa fa-pencil-alt"></i> Ubah',
                    ['action' => 'edit', $patient->id],
                    ['class' => 'btn btn-info btn-sm', 'escape' => false]
                ) ?>

                <?php if ($canViewPatientHistory): ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-history"></i> Riwayat Pasien',
                        ['prefix' => 'RekamMedis', 'controller' => 'MedicalRecords', 'action' => 'history', $patient->id],
                        ['class' => 'btn btn-primary btn-sm', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="patient-section">
                    <div class="patient-section-header">
                        <i class="fa fa-id-card"></i> Biodata Pasien
                    </div>
                    <div class="patient-section-body">
                        <div class="patient-detail-grid">
                            <div class="patient-detail-item">
                                <div class="label-text">Identitas</div>
                                <div class="value">
                                    <?= $display($patient->identity_type) ?>
                                    <?= !empty($patient->identity_number) ? ' - ' . h($patient->identity_number) : '' ?>
                                </div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">No Kartu BPJS</div>
                                <div class="value"><?= $display($patient->insurance_card_no) ?></div>
                            <div class="patient-detail-item">
                                <div class="label-text">Golongan Darah</div>
                                <div class="value"><?= $display($patient->blood_type) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Umur</div>
                                <div class="value"><?= $display($patient->age) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Kewarganegaraan</div>
                                <div class="value"><?= $display($patient->citizenship) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Negara</div>
                                <div class="value"><?= $display($patient->nationality) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Status Nikah</div>
                                <div class="value"><?= $display($patient->marital_status) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Pekerjaan</div>
                                <div class="value"><?= $display($patient->occupation) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Agama</div>
                                <div class="value"><?= $display($patient->religion) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Pendidikan</div>
                                <div class="value"><?= $display($patient->education) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Suku Bangsa</div>
                                <div class="value"><?= $display($patient->ethnic_group) ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="patient-section">
                    <div class="patient-section-header">
                        <i class="fa fa-map-marker-alt"></i> Alamat
                    </div>
                    <div class="patient-section-body">
                        <div class="patient-detail-grid two">
                            <div class="patient-detail-item" style="grid-column: 1 / -1;">
                                <div class="label-text">Alamat Lengkap</div>
                                <div class="value"><?= $display($patient->address) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Provinsi</div>
                                <div class="value"><?= $display($province) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Kabupaten/Kota</div>
                                <div class="value"><?= $display($city) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Kecamatan</div>
                                <div class="value"><?= $display($district) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Kelurahan</div>
                                <div class="value"><?= $display($subdistrict) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="patient-section">
                    <div class="patient-section-header">
                        <i class="fa fa-users"></i> Keluarga
                    </div>
                    <div class="patient-section-body">
                        <div class="patient-detail-grid one">
                            <div class="patient-detail-item">
                                <div class="label-text">Nama Ayah</div>
                                <div class="value"><?= $display($patient->father_name) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Nama Ibu</div>
                                <div class="value"><?= $display($patient->mother_name) ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="patient-section">
                    <div class="patient-section-header">
                        <i class="fa fa-info-circle"></i> Informasi Sistem
                    </div>
                    <div class="patient-section-body">
                        <div class="patient-detail-grid one">
                            <div class="patient-detail-item">
                                <div class="label-text">Dibuat</div>
                                <div class="value"><?= $formatDateTime($patient->created) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Diubah</div>
                                <div class="value"><?= $formatDateTime($patient->modified) ?></div>
                            </div>
                            <div class="patient-detail-item">
                                <div class="label-text">Status</div>
                                <div class="value"><span class="label <?= $statusClass ?>"><?= h($statusLabel) ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($personResponsibles)): ?>
                    <div class="patient-section">
                        <div class="patient-section-header">
                            <i class="fa fa-address-book"></i> Penanggung Jawab
                        </div>
                        <div class="patient-section-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm patient-related-table">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Hubungan</th>
                                            <th>Identitas</th>
                                            <th>Telepon</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($personResponsibles as $personResponsible): ?>
                                            <tr>
                                                <td><?= $display($personResponsible->name ?? null) ?></td>
                                                <td><?= $display($personResponsible->relation ?? null) ?></td>
                                                <td>
                                                    <?= $display($personResponsible->identity_type ?? null) ?>
                                                    <?= !empty($personResponsible->identity_no) ? ' - ' . h($personResponsible->identity_no) : '' ?>
                                                </td>
                                                <td><?= $display($personResponsible->phone ?? null) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="patient-section">
            <div class="patient-section-header">
                <i class="fa fa-list-alt"></i> Riwayat Registrasi
            </div>
            <div class="patient-section-body">
                <?php if (!empty($patient->registrations)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm patient-related-table">
                            <thead>
                                <tr>
                                    <th>No Registrasi</th>
                                    <th>Tanggal</th>
                                    <th>Layanan</th>
                                    <th>Poli/Unit</th>
                                    <th>Status</th>
                                    <th width="80">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $rno = 1; foreach ($patient->registrations as $reg): ?>
                            <tr>
                                <td class="text-center"><?= $rno++ ?></td>
                                <td><code style="font-size:11px;"><?= h($reg->registration_no) ?: '—' ?></code></td>
                                <td><?= fmtPatientDate($reg->registration_date) ?></td>
                                <td><?= h($reg->service_type) ?: '—' ?></td>
                                <td><?= !empty($reg->doctor) ? h($reg->doctor->doctor_name) : '—' ?></td>
                                <td>
                                    <span style="background:#e9ecef; color:#495057; padding:2px 8px;
                                                border-radius:10px; font-size:11px;">
                                        <?= h($reg->status) ?: '—' ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="patient-empty">Data registrasi belum tersedia.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
