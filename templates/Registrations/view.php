<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 */

$patient = $registration->patient ?? null;
$doctor = $registration->doctor ?? null;
$room = $registration->room ?? null;
$bed = $registration->bed ?? null;
$personResponsible = $registration->person_responsible ?? null;
$queue = $registration->polyclinic_queue ?? null;

$serviceLabels = [
    'rawat_jalan' => 'Rawat Jalan',
    'igd' => 'IGD',
    'rawat_inap' => 'Rawat Inap',
];
$serviceLabel = $serviceLabels[$registration->service_type] ?? ($registration->service_type ?: '-');
$statusLabel = $registration->status ?: 'aktif';
$statusClass = $statusLabel === 'aktif' ? 'label-success' : 'label-default';

$registrationDate = !empty($registration->registration_date)
    ? h($registration->registration_date)
    : '-';
$admissionTime = !empty($registration->admission_time)
    ? h($registration->admission_time)
    : '-';

$display = function ($value): string {
    if ($value === null || $value === '') {
        return '-';
    }

    return h((string)$value);
};
$canViewPatientHistory = !empty($checkUrl['medicalrecords']['history']);
?>

<?= $this->Krs->breadcrumb('Registration', 'Detail') ?>

<style>
    .registration-view-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border: 1px solid #e2e7ef;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 18px;
    }

    .registration-title h3 {
        margin: 0 0 8px;
        font-size: 22px;
        font-weight: 700;
        color: #2d353c;
    }

    .registration-title .meta {
        color: #6c757d;
        font-size: 13px;
    }

    .registration-no-box {
        min-width: 190px;
        padding: 13px 16px;
        border: 1px solid #cfe7ff;
        border-radius: 8px;
        background: #eef7ff;
        text-align: center;
    }

    .registration-no-box .caption {
        display: block;
        margin-bottom: 6px;
        color: #6c757d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .registration-no-box .number {
        display: block;
        color: #2f80ed;
        font-size: 18px;
        font-weight: 700;
    }

    .section-box {
        border: 1px solid #e2e7ef;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 18px;
        overflow: hidden;
    }

    .section-box-header {
        padding: 12px 15px;
        border-bottom: 1px solid #edf1f5;
        background: #fafbfd;
        font-size: 15px;
        font-weight: 700;
        color: #2d353c;
    }

    .section-box-header i {
        margin-right: 7px;
        color: #5c6bc0;
    }

    .section-box-body {
        padding: 15px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .detail-grid.one-col {
        grid-template-columns: 1fr;
    }

    .detail-item {
        padding: 12px 13px;
        border: 1px solid #e8edf3;
        border-radius: 8px;
        background: #fbfcfe;
    }

    .detail-item .label-text {
        margin-bottom: 5px;
        color: #6c757d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .detail-item .value {
        color: #2d353c;
        font-size: 14px;
        min-height: 20px;
        word-break: break-word;
    }

    .person-empty {
        padding: 13px;
        border: 1px solid #ece3ce;
        border-radius: 8px;
        background: #fff9eb;
        color: #7a5b16;
    }

    @media (max-width: 767px) {
        .registration-view-hero {
            align-items: stretch;
            flex-direction: column;
        }

        .registration-no-box {
            min-width: 0;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-file-text-o"></i> Detail Registrasi
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="registration-view-hero">
            <div class="registration-title">
                <h3><?= $display($patient->full_name ?? null) ?></h3>
                <div class="meta">
                    No RM: <?= $display($patient->medical_record_no ?? $patient->code ?? null) ?>
                    <?php if (!empty($patient->code)): ?>
                        - Kode Pasien: <?= h($patient->code) ?>
                    <?php endif; ?>
                    -
                    <?= h($serviceLabel) ?> -
                    <span class="label <?= $statusClass ?>"><?= h($statusLabel) ?></span>
                </div>
            </div>

            <div class="registration-no-box">
                <span class="caption">No Registrasi</span>
                <span class="number"><?= $display($registration->registration_no) ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="section-box">
                    <div class="section-box-header">
                        <i class="fa fa-user"></i> Data Pasien
                    </div>
                    <div class="section-box-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="label-text">No Rekam Medis</div>
                                <div class="value"><?= $display($patient->medical_record_no ?? $patient->code ?? null) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Kode Pasien</div>
                                <div class="value"><?= $display($patient->code ?? null) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Nama Pasien</div>
                                <div class="value"><?= $display($patient->full_name ?? null) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Identitas</div>
                                <div class="value">
                                    <?= $display($patient->identity_type ?? null) ?>
                                    <?= !empty($patient->identity_number) ? ' - ' . h($patient->identity_number) : '' ?>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Jenis Kelamin</div>
                                <div class="value"><?= $display($patient->gender ?? null) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Tanggal Lahir</div>
                                <div class="value"><?= $display($patient->birth_date ?? null) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">No Telepon</div>
                                <div class="value"><?= $display($patient->phone_number ?? null) ?></div>
                            </div>
                            <div class="detail-item" style="grid-column:1 / -1;">
                                <div class="label-text">Alamat</div>
                                <div class="value"><?= $display($patient->address ?? null) ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-box">
                    <div class="section-box-header">
                        <i class="fa fa-stethoscope"></i> Pelayanan
                    </div>
                    <div class="section-box-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="label-text">Tanggal Masuk</div>
                                <div class="value"><?= $registrationDate ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Jam Masuk</div>
                                <div class="value"><?= $admissionTime ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Jenis Pelayanan</div>
                                <div class="value"><?= h($serviceLabel) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Poli / Unit</div>
                                <div class="value"><?= $display($registration->polyclinic_name) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Dokter</div>
                                <div class="value"><?= $display($doctor->doctor_name ?? null) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Status</div>
                                <div class="value"><span class="label <?= $statusClass ?>"><?= h($statusLabel) ?></span></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Ruangan</div>
                                <div class="value"><?= $display($room->room_name ?? null) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Bed / Kamar</div>
                                <div class="value">
                                    <?= $display($bed->name ?? null) ?>
                                    <?= !empty($bed->bed_no) ? ' (' . h($bed->bed_no) . ')' : '' ?>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Kelas</div>
                                <div class="value"><?= $display($registration->class_name) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Proses / Cara Masuk</div>
                                <div class="value">
                                    <?= $display($registration->entry_process) ?>
                                    <?= !empty($registration->entry_method) ? ' - ' . h($registration->entry_method) : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="section-box">
                    <div class="section-box-header">
                        <i class="fa fa-ticket"></i> Sumber Antrian
                    </div>
                    <div class="section-box-body">
                        <div class="detail-grid one-col">
                            <div class="detail-item">
                                <div class="label-text">Kode Antrian</div>
                                <div class="value"><?= $display($queue->code ?? null) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Nomor Antrian</div>
                                <div class="value"><?= $display($registration->queue_number) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Sumber</div>
                                <div class="value"><?= !empty($queue) ? $display($queue->source) : 'Registrasi langsung' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-box">
                    <div class="section-box-header">
                        <i class="fa fa-credit-card"></i> Pembayaran
                    </div>
                    <div class="section-box-body">
                        <div class="detail-grid one-col">
                            <div class="detail-item">
                                <div class="label-text">Jenis Pasien</div>
                                <div class="value"><?= $display($registration->payment_method) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">Penjamin</div>
                                <div class="value"><?= $display($registration->insurance_type) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">No Kartu</div>
                                <div class="value"><?= $display($registration->insurance_card_no) ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="label-text">SEP / Rujukan</div>
                                <div class="value">
                                    <?= $display($registration->sep_no) ?>
                                    <?= !empty($registration->refferal_no) ? ' - ' . h($registration->refferal_no) : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-box">
                    <div class="section-box-header">
                        <i class="fa fa-users"></i> Penanggung Jawab
                    </div>
                    <div class="section-box-body">
                        <?php if (!empty($personResponsible)): ?>
                            <div class="detail-grid one-col">
                                <div class="detail-item">
                                    <div class="label-text">Nama</div>
                                    <div class="value"><?= $display($personResponsible->name) ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">Hubungan</div>
                                    <div class="value"><?= $display($personResponsible->relation) ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">Identitas</div>
                                    <div class="value">
                                        <?= $display($personResponsible->identity_type) ?>
                                        <?= !empty($personResponsible->identity_no) ? ' - ' . h($personResponsible->identity_no) : '' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">Umur / Pekerjaan</div>
                                    <div class="value">
                                        <?= $display($personResponsible->age) ?>
                                        <?= !empty($personResponsible->job) ? ' - ' . h($personResponsible->job) : '' ?>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">Telepon</div>
                                    <div class="value"><?= $display($personResponsible->phone) ?></div>
                                </div>
                                <div class="detail-item">
                                    <div class="label-text">Alamat</div>
                                    <div class="value"><?= $display($personResponsible->address) ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="person-empty">Data penanggung jawab belum diisi.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="text-right">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default', 'escape' => false]
            ) ?>

            <?php if ($canViewPatientHistory): ?>
                <?= $this->Html->link(
                    '<i class="fa fa-history"></i> Riwayat Pasien',
                    ['controller' => 'MedicalRecords', 'action' => 'history', $registration->patient_id],
                    ['class' => 'btn btn-info', 'escape' => false]
                ) ?>
            <?php endif; ?>

            <?= $this->Html->link(
                '<i class="fa fa-pencil"></i> Edit',
                ['action' => 'edit', $registration->id],
                ['class' => 'btn btn-warning', 'escape' => false]
            ) ?>
        </div>
    </div>
</div>
