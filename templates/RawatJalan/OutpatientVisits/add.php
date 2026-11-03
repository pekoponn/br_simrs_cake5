<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit $visit
 * @var array $doctors
 * @var \App\Model\Entity\Registration|null $registration
 * @var int|null $registrationId
 */

$isEdit    = !empty($visit->id);
$pageTitle = $isEdit ? 'Edit Kunjungan Rawat Jalan' : 'Tambah Kunjungan Rawat Jalan';

// Pre-fill dari registrasi jika ada
$prefillPatientId   = $registration->patient_id   ?? $visit->patient_id   ?? '';
$prefillPatientName = $registration->patient->full_name ?? $visit->patient->full_name ?? '';
$prefillPatientCode = $registration->patient->code ?? $visit->patient->code ?? '';
$prefillRegNo       = $registration->registration_no ?? $visit->registration_no ?? '';
$prefillDoctorId    = $registration->doctor_id  ?? $visit->doctor_id  ?? '';
$prefillPoliName    = $registration->polyclinic_name ?? $visit->polyclinic_name ?? '';
$prefillPayment     = $registration->payment_method  ?? $visit->registration->payment_method ?? '';
?>

<?= $this->Krs->breadcrumb('Outpatient Visits', $pageTitle) ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-stethoscope"></i> <?= $pageTitle ?>
        </h4>
    </div>
    <div class="panel-body">

        <?= $this->Form->create($visit, ['id' => 'form-outpatient']) ?>

        <!-- ── HIDDEN FIELDS ── -->
        <input type="hidden" name="patient_id"       value="<?= h($prefillPatientId) ?>">
        <input type="hidden" name="registration_id"  value="<?= h($registrationId ?? $visit->registration_id ?? '') ?>">
        <?php if (!empty($prefillRegNo)): ?>
            <input type="hidden" name="registration_no" value="<?= h($prefillRegNo) ?>">
        <?php endif; ?>

        <!-- ════════════════════════════════════════════════════
             STEP 1 — INFO PASIEN
             ════════════════════════════════════════════════════ -->
        <div class="panel panel-primary" style="border-radius:8px;">
            <div class="panel-heading" style="border-radius:8px 8px 0 0;">
                <strong><i class="fa fa-user"></i> Identitas Pasien</strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>No Rekam Medis</label>
                            <input type="text" class="form-control" value="<?= h($prefillPatientCode) ?>" readonly
                                   style="background:#f5f5f5;">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Nama Pasien</label>
                            <input type="text" class="form-control" value="<?= h($prefillPatientName) ?>" readonly
                                   style="background:#f5f5f5; font-weight:600;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>No Registrasi</label>
                            <?php if (empty($prefillRegNo)): ?>
                                <?= $this->Form->control('registration_no', [
                                    'label' => false, 'class' => 'form-control',
                                    'placeholder' => 'No registrasi...',
                                ]) ?>
                            <?php else: ?>
                                <input type="text" class="form-control" value="<?= h($prefillRegNo) ?>" readonly
                                       style="background:#f5f5f5;">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal Kunjungan <span class="text-danger">*</span></label>
                            <input type="date" name="visit_date" class="form-control"
                                   value="<?= h(!empty($visit->visit_date) ? (is_object($visit->visit_date) ? $visit->visit_date->format('Y-m-d') : $visit->visit_date) : date('Y-m-d')) ?>"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Jam</label>
                            <input type="time" name="visit_time" class="form-control"
                                   value="<?= h($visit->visit_time ?? date('H:i')) ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Poli / Klinik <span class="text-danger">*</span></label>
                            <input type="text" name="polyclinic_name" class="form-control"
                                   placeholder="Contoh: Poli Umum, Poli Anak..."
                                   value="<?= h($prefillPoliName) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Dokter</label>
                            <select name="doctor_id" class="form-control">
                                <option value="">-- Pilih Dokter --</option>
                                <?php foreach ($doctors as $did => $dname): ?>
                                    <option value="<?= $did ?>"
                                        <?= ($prefillDoctorId == $did) ? 'selected' : '' ?>>
                                        <?= h($dname) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cara Bayar</label>
                            <input type="text" class="form-control" value="<?= h($prefillPayment) ?>" readonly
                                   style="background:#f5f5f5;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>No Antrian</label>
                            <?= $this->Form->control('queue_number', [
                                'label' => false, 'class' => 'form-control',
                                'type' => 'number', 'min' => 1,
                                'placeholder' => 'Auto...',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <?php
                                $statusOpts = [
                                    'waiting'     => '⏳ Menunggu',
                                    'called'      => '📢 Dipanggil',
                                    'in_progress' => '🩺 Sedang Diperiksa',
                                    'done'        => '✅ Selesai',
                                    'cancelled'   => '❌ Dibatalkan',
                                ];
                                foreach ($statusOpts as $sval => $slabel): ?>
                                    <option value="<?= $sval ?>"
                                        <?= ($visit->status ?? 'waiting') === $sval ? 'selected' : '' ?>>
                                        <?= $slabel ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             STEP 2 — TANDA VITAL
             ════════════════════════════════════════════════════ -->
        <div class="panel panel-default" style="border-radius:8px;">
            <div class="panel-heading" style="background:#34495e; color:#fff; border-radius:8px 8px 0 0;">
                <strong><i class="fa fa-heartbeat"></i> Tanda Vital</strong>
                <small style="color:rgba(255,255,255,.7); margin-left:8px;">(opsional)</small>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tekanan Darah</label>
                            <div class="input-group">
                                <?= $this->Form->control('blood_pressure', [
                                    'label' => false, 'class' => 'form-control',
                                    'placeholder' => '120/80',
                                ]) ?>
                                <span class="input-group-addon">mmHg</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Nadi</label>
                            <div class="input-group">
                                <?= $this->Form->control('pulse', [
                                    'label' => false, 'class' => 'form-control',
                                    'type' => 'number', 'placeholder' => '80',
                                ]) ?>
                                <span class="input-group-addon">bpm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Suhu</label>
                            <div class="input-group">
                                <?= $this->Form->control('temperature', [
                                    'label' => false, 'class' => 'form-control',
                                    'type' => 'number', 'step' => '0.1', 'placeholder' => '36.5',
                                ]) ?>
                                <span class="input-group-addon">°C</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Pernapasan</label>
                            <div class="input-group">
                                <?= $this->Form->control('respiratory_rate', [
                                    'label' => false, 'class' => 'form-control',
                                    'type' => 'number', 'placeholder' => '18',
                                ]) ?>
                                <span class="input-group-addon">/mnt</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>SpO2</label>
                            <div class="input-group">
                                <?= $this->Form->control('oxygen_saturation', [
                                    'label' => false, 'class' => 'form-control',
                                    'type' => 'number', 'placeholder' => '98',
                                ]) ?>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Skala Nyeri</label>
                            <select name="pain_scale" class="form-control">
                                <option value="">--</option>
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"
                                        <?= ($emr->pain_scale ?? '') == $i ? 'selected' : '' ?>>
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Berat Badan</label>
                            <div class="input-group">
                                <?= $this->Form->control('weight', [
                                    'label' => false, 'class' => 'form-control',
                                    'type' => 'number', 'step' => '0.1', 'placeholder' => '60',
                                ]) ?>
                                <span class="input-group-addon">kg</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tinggi Badan</label>
                            <div class="input-group">
                                <?= $this->Form->control('height', [
                                    'label' => false, 'class' => 'form-control',
                                    'type' => 'number', 'step' => '0.1', 'placeholder' => '165',
                                ]) ?>
                                <span class="input-group-addon">cm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Alergi</label>
                            <?= $this->Form->control('allergy', [
                                'label' => false, 'class' => 'form-control',
                                'placeholder' => 'Contoh: Penisilin, seafood...',
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             STEP 3 — ANAMNESIS
             ════════════════════════════════════════════════════ -->
        <div class="panel panel-default" style="border-radius:8px;">
            <div class="panel-heading" style="background:#2980b9; color:#fff; border-radius:8px 8px 0 0;">
                <strong><i class="fa fa-comment-medical"></i> Anamnesis</strong>
                <small style="color:rgba(255,255,255,.7); margin-left:8px;">(opsional)</small>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Keluhan Utama</label>
                            <?= $this->Form->control('chief_complaint', [
                                'label' => false, 'class' => 'form-control',
                                'type' => 'textarea', 'rows' => 3,
                                'placeholder' => 'Keluhan yang dirasakan pasien...',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Riwayat Penyakit</label>
                            <?= $this->Form->control('illness_history', [
                                'label' => false, 'class' => 'form-control',
                                'type' => 'textarea', 'rows' => 3,
                                'placeholder' => 'Riwayat penyakit sekarang / dahulu...',
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             STEP 4 — DIAGNOSA
             ════════════════════════════════════════════════════ -->
        <div class="panel panel-default" style="border-radius:8px;">
            <div class="panel-heading" style="background:#8e44ad; color:#fff; border-radius:8px 8px 0 0;">
                <strong><i class="fa fa-notes-medical"></i> Diagnosa</strong>
                <small style="color:rgba(255,255,255,.7); margin-left:8px;">(opsional)</small>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Diagnosa Primer (ICD-10)</label>
                            <?= $this->Form->control('diagnosis_primary', [
                                'label' => false, 'class' => 'form-control',
                                'placeholder' => 'Contoh: J06.9 - ISPA',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Diagnosa Sekunder</label>
                            <?= $this->Form->control('diagnosis_secondary', [
                                'label' => false, 'class' => 'form-control',
                                'placeholder' => 'Diagnosis penyerta (opsional)',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Uraian Diagnosa</label>
                            <?= $this->Form->control('diagnosis_desc', [
                                'label' => false, 'class' => 'form-control',
                                'type' => 'textarea', 'rows' => 2,
                                'placeholder' => 'Keterangan tambahan...',
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             STEP 5 — CATATAN & RESEP
             ════════════════════════════════════════════════════ -->
        <div class="panel panel-default" style="border-radius:8px;">
            <div class="panel-heading" style="background:#16a085; color:#fff; border-radius:8px 8px 0 0;">
                <strong><i class="fa fa-prescription"></i> Catatan Dokter &amp; Resep</strong>
                <small style="color:rgba(255,255,255,.7); margin-left:8px;">(opsional)</small>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Catatan Dokter</label>
                            <?= $this->Form->control('doctor_notes', [
                                'label' => false, 'class' => 'form-control',
                                'type' => 'textarea', 'rows' => 3,
                                'placeholder' => 'Instruksi / catatan dokter...',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Resep</label>
                            <?= $this->Form->control('prescription_notes', [
                                'label' => false, 'class' => 'form-control',
                                'type' => 'textarea', 'rows' => 3,
                                'placeholder' => 'Daftar obat yang diresepkan...',
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Catatan Tindakan</label>
                            <?= $this->Form->control('action_notes', [
                                'label' => false, 'class' => 'form-control',
                                'type' => 'textarea', 'rows' => 2,
                                'placeholder' => 'Tindakan yang dilakukan...',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal Kontrol</label>
                            <input type="date" name="follow_up_date" class="form-control"
                                   value="<?= h(!empty($visit->follow_up_date) ? (is_object($visit->follow_up_date) ? $visit->follow_up_date->format('Y-m-d') : $visit->follow_up_date) : '') ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Total Biaya (Rp)</label>
                            <input type="text" id="field-total-fee" name="total_fee" class="form-control"
                                   placeholder="0"
                                   value="<?= !empty($visit->total_fee) ? number_format((float)$visit->total_fee, 0, ',', '.') : '' ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             STEP 6 — RUJUKAN (opsional)
             ════════════════════════════════════════════════════ -->
        <div class="panel panel-default" style="border-radius:8px;">
            <div class="panel-heading" style="background:#e67e22; color:#fff; border-radius:8px 8px 0 0;
                cursor:pointer;" data-toggle="collapse" data-target="#panel-rujukan">
                <strong><i class="fa fa-ambulance"></i> Rujukan</strong>
                <small style="color:rgba(255,255,255,.7); margin-left:8px;">
                    (klik untuk buka/tutup — opsional)
                </small>
                <span class="pull-right"><i class="fa fa-chevron-down"></i></span>
            </div>
            <div id="panel-rujukan" class="collapse <?= !empty($visit->referral_to) ? 'in' : '' ?>">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Rujuk Ke</label>
                                <?= $this->Form->control('referral_to', [
                                    'label' => false, 'class' => 'form-control',
                                    'placeholder' => 'Nama RS / Faskes tujuan rujukan...',
                                ]) ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Alasan Rujukan</label>
                                <?= $this->Form->control('referral_reason', [
                                    'label' => false, 'class' => 'form-control',
                                    'type' => 'textarea', 'rows' => 2,
                                    'placeholder' => 'Alasan / indikasi rujukan...',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOMBOL AKSI -->
        <hr>
        <div class="text-right" style="display:flex; gap:8px; justify-content:flex-end;">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default', 'escape' => false]
            ) ?>
            <?= $this->Form->button(
                '<i class="fa fa-save"></i> ' . ($isEdit ? 'Update Kunjungan' : 'Simpan Kunjungan'),
                ['class' => 'btn btn-success btn-lg', 'escapeTitle' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

<script>
// Format ribuan untuk field total biaya
document.getElementById('field-total-fee').addEventListener('input', function() {
    var raw = this.value.replace(/\D/g, '');
    if (raw) {
        this.value = parseInt(raw, 10).toLocaleString('id-ID');
    }
});

// Sebelum submit — bersihkan format ribuan dari total_fee
document.getElementById('form-outpatient').addEventListener('submit', function() {
    var f = document.getElementById('field-total-fee');
    f.value = f.value.replace(/\./g, '').replace(/,/g, '');
});
</script>