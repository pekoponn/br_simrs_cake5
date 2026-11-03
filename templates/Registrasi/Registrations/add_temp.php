<?php
/**
 * TEMPORARY VIEW — Registrasi sementara untuk display antrian (kunjungan BPJS/JKN)
 * Simpan di: templates/Registrations/add_temp.php
 *
 * Ini DUPLIKAT dari add.php. add.php yang asli TIDAK diubah.
 * Nanti kalau sudah pindah ke HMS / sistem baru, file ini + action addTemp() bisa dihapus.
 *
 * Perbedaan dengan add.php:
 *  - No Rekam Medis   : diisi manual
 *  - Nama Pasien      : diisi manual
 *  - Poli / Unit      : dropdown (helper Krs->polyclinics())
 *  - Nomor Antrian Poli: diisi manual
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 */

$registration     = $registration ?? null;
$fromQueue        = $fromQueue ?? false;
$queueId          = $queueId ?? null;
$queueNumber      = $queueNumber ?? null;
$queueCode        = $queueCode ?? null;
$polyclinicName   = $polyclinicName ?? null;
$queueDoctorId    = $queueDoctorId ?? null;
$queueDoctorScheduleId = $queueDoctorScheduleId ?? null;
$registrationNo   = $registrationNo ?? '';

$currentPoli = $this->request->getData('polyclinic_name') ?? ($polyclinicName ?? '');
$currentQueueNo = $this->request->getData('queue_number') ?? '';
$currentRm = $this->request->getData('patient_code') ?? '';
$currentName = $this->request->getData('patient_name') ?? '';
$currentPaymentMethod = $this->request->getData('payment_method') ?? 'PERORANGAN';
?>

<style>
    body { background: #eef2f7; }
    .temp-wrapper { width: auto; max-width: none; margin: 0 10px; }
    .form-card {
        background: #fff; border: 1px solid #dfe6ee; border-radius: 10px;
        margin-bottom: 22px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }
    .form-card-header {
        padding: 14px 18px; border-bottom: 1px solid #edf1f5; font-size: 16px;
        font-weight: 600; background: #fafbfd; color: #2f3542;
    }
    .form-card-header i { margin-right: 8px; color: #5c6bc0; }
    .form-card-body { padding: 20px; }
    .form-card-body .row > div { margin-bottom: 14px; }
    .form-card-body label { font-weight: 600; font-size: 12px; margin-bottom: 5px; color: #57606f; display: block; }
    .form-control { border-radius: 6px; border: 1px solid #ced6e0; height: 38px; font-size: 13px; box-shadow: none; }
    .form-control:focus { border-color: #5c6bc0; box-shadow: 0 0 0 2px rgba(92,107,192,.1); }
    .queue-info-box {
        background: #fff; border: 1px solid #dfe6ee; border-radius: 10px;
        margin-bottom: 22px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }
    .queue-info-header { padding: 14px 18px; border-bottom: 1px solid #edf1f5; font-size: 16px; font-weight: 600; background: #fafbfd; }
    .queue-info-body { padding: 18px 20px; }
    .temp-note {
        margin-top: 10px; padding: 10px 12px; border-left: 4px solid #f59e0b;
        background: #fffbeb; color: #92400e; font-size: 13px; font-weight: 600;
    }
    .queue-handoff-note {
        margin-top: 10px; padding: 10px 12px; border-left: 4px solid #28a745;
        background: #eefaf2; color: #27643a; font-size: 13px; font-weight: 600;
    }
    .submit-card {
        background: #fff; border: 1px solid #dfe6ee; border-radius: 10px;
        padding: 18px 22px; text-align: right; margin-bottom: 20px;
    }
    .big-input { font-size: 20px !important; font-weight: 800; color: #1e3a5f; height: 46px !important; text-align: center; }
    fieldset legend { font-size: 22px; font-weight: 700; margin-bottom: 20px; color: #2f3542; }
</style>

<div class="temp-wrapper">
    <div class="registrations form content">

        <?php if ($fromQueue): ?>
            <div class="queue-info-box">
                <div class="queue-info-header"><i class="fa fa-exchange"></i> Antrian Admisi</div>
                <div class="queue-info-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label style="font-size:12px;margin-bottom:3px;">Kode Antrian</label>
                            <input type="text" class="form-control" value="<?= h($queueCode) ?>" readonly style="background:#f1f3f5;">
                        </div>
                        <div class="col-md-5">
                            <label style="font-size:12px;margin-bottom:3px;">Sumber Poli</label>
                            <input type="text" class="form-control" value="<?= h($polyclinicName) ?>" readonly style="background:#f1f3f5;">
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:12px;margin-bottom:3px;">No Antrian Admisi</label>
                            <input type="text" class="form-control" value="<?= h($queueNumber) ?>" readonly style="background:#f1f3f5;">
                        </div>
                    </div>
                    <div class="temp-note">
                        Form sementara untuk display antrian (kunjungan BPJS). No. RM, nama pasien, poli, dan nomor antrian poli diisi manual.
                    </div>
                    <div class="queue-handoff-note">
                        Setelah disimpan, antrian admisi otomatis ditandai tidak aktif dan terhubung ke nomor registrasi baru.
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        $flashMessages = $this->request->getSession()->read('Flash.flash') ?? [];
        if (!empty($flashMessages)):
        ?>
            <div style="margin-bottom:20px;">
                <?php foreach ($flashMessages as $flashMessage): ?>
                    <?php
                        $isError = strpos((string)($flashMessage['element'] ?? ''), 'error') !== false;
                        $bg = $isError ? '#fdecea' : '#eafaf1';
                        $border = $isError ? '#f5c6cb' : '#b7e4c7';
                        $color = $isError ? '#611a15' : '#1e4620';
                    ?>
                    <div style="padding:14px 18px;border-radius:8px;margin-bottom:10px;font-size:14px;font-weight:600;
                                background:<?= $bg ?>;border:1px solid <?= $border ?>;color:<?= $color ?>;">
                        <?= h($flashMessage['message'] ?? '') ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?= $this->Form->create($registration, [
            'type' => 'post',
            'url' => ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'addTemp', '?' => $this->request->getQueryParams()],
        ]) ?>

        <fieldset>
            <legend>Registrasi Sementara (Display Antrian)</legend>

            <div class="form-card">
                <div class="form-card-header"><i class="fa fa-user"></i> Data Pasien</div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>No Rekam Medis <span style="color:#dc3545;">*</span></label>
                            <input type="text" name="patient_code" id="patient-code" class="form-control"
                                   placeholder="Isi No RM manual" autocomplete="off" required
                                   value="<?= h($currentRm) ?>">
                        </div>
                        <div class="col-md-8">
                            <label>Nama Pasien <span style="color:#dc3545;">*</span></label>
                            <input type="text" name="patient_name" id="patient-name" class="form-control"
                                   placeholder="Isi nama lengkap pasien" autocomplete="off" required
                                   value="<?= h($currentName) ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Poli / Unit <span style="color:#dc3545;">*</span></label>
                            <?= $this->Form->select('polyclinic_name', $this->Krs->polyclinics(), [
                                'empty' => '-- Pilih Poli / Unit --',
                                'id' => 'polyclinic-name',
                                'value' => $currentPoli,
                                'class' => 'form-control select2Form',
                                'required' => true,
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <label>Nomor Antrian Poli <span style="color:#dc3545;">*</span> <small style="color:#888;">(isi manual)</small></label>
                            <input type="number" min="1" step="1" name="queue_number" id="queue-number" class="form-control big-input"
                                   placeholder="Contoh: 12 (angka saja)" autocomplete="off" required
                                   value="<?= h($currentQueueNo) ?>">
                            <input type="hidden" name="queue_no" id="queue-no-hidden" value="<?= h($currentQueueNo) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-header"><i class="fa fa-hospital-o"></i> Tujuan Berobat</div>
                <div class="form-card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>No Registrasi <small style="color:#888;">(otomatis)</small></label>
                            <input type="text" name="registration_no" id="registration-no" class="form-control"
                                   value="<?= h($registrationNo) ?>" readonly
                                   style="background:#e9ecef;color:#6c757d;cursor:not-allowed;">
                        </div>
                        <div class="col-md-4">
                            <label>Tanggal Masuk</label>
                            <input type="text" name="registration_date" class="form-control datepicker-autoclose" autocomplete="off"
                                   value="<?= h($this->request->getData('registration_date') ?? date('Y-m-d')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Jam Masuk</label>
                            <input type="time" name="admission_time" class="form-control" step="60"
                                   value="<?= h($this->request->getData('admission_time') ?? date('H:i')) ?>">
                        </div>

                        <div class="col-md-4">
                            <label>Jenis Pasien</label>
                            <select name="payment_method" class="form-control select2Form">
                                <option value="PERORANGAN" <?= $currentPaymentMethod === 'PERORANGAN' ? 'selected' : '' ?>>PERORANGAN</option>
                                <option value="ASURANSI" <?= $currentPaymentMethod === 'ASURANSI' ? 'selected' : '' ?>>ASURANSI (BPJS/JKN)</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="service_type" value="rawat_jalan">
                    <?php if ($fromQueue): ?>
                        <input type="hidden" name="polyclinic_queue_id" value="<?= h($queueId) ?>">
                        <input type="hidden" name="doctor_id" value="<?= h($queueDoctorId) ?>">
                        <input type="hidden" name="doctor_schedule_id" value="<?= h($queueDoctorScheduleId) ?>">
                    <?php endif; ?>
                </div>
            </div>
        </fieldset>

        <div class="submit-card">
            <?= $this->Html->link('Batal', ['prefix' => 'Registrasi', 'controller' => 'PatientAdmissions', 'action' => 'index', '?' => ['tab' => 'rawat_jalan']], ['class' => 'btn btn-default']) ?>
            <?= $this->Form->button('Simpan Registrasi', [
                'type' => 'submit',
                'class' => 'btn btn-primary',
                'id' => 'btn-save-registration',
            ]) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<script>
$(document).ready(function () {
    if ($.fn.select2) {
        $('.select2Form').select2({ width: '100%' });
    }
    $('.datepicker-autoclose').datepicker({ format: 'yyyy-mm-dd', autoclose: true, todayHighlight: true });

    $('#queue-number').on('input change', function () {
        $('#queue-no-hidden').val($(this).val());
    });

    $('#btn-save-registration').closest('form').on('submit', function () {
        $('#btn-save-registration').prop('disabled', true).text('Menyimpan...');
    });
});
</script>
