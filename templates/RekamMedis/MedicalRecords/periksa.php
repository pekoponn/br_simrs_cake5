<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit $visit
 * @var \App\Model\Entity\MedicalRecord $medicalRecord
 * @var array $details
 */

$patient = $visit->patient ?? null;
$registration = $visit->registration ?? null;
$doctor = $visit->doctor ?? null;

$display = function ($value): string {
    if ($value === null || $value === '') {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return h($value->format('d-m-Y'));
    }

    return h((string)$value);
};
?>

<?= $this->Krs->breadcrumb('Medical Record', 'Pemeriksaan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-stethoscope"></i> Pemeriksaan Pasien</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>
    <div class="panel-body">
        <div class="m-b-15">
            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> Kembali', ['action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="fa fa-history"></i> Riwayat Pasien', ['action' => 'history', $visit->patient_id], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
        </div>

        <div class="row">
            <div class="col-md-3"><label>No Registrasi</label><br><strong><?= $display($visit->registration_no ?? $registration->registration_no ?? null) ?></strong></div>
            <div class="col-md-3"><label>No RM</label><br><?= $display($patient->medical_record_no ?? $patient->code ?? null) ?></div>
            <div class="col-md-3"><label>Pasien</label><br><strong><?= $display($patient->full_name ?? null) ?></strong></div>
            <div class="col-md-3"><label>Medical Record</label><br>#<?= h($medicalRecord->id) ?> / <?= $display($medicalRecord->status ?? null) ?></div>
        </div>
        <hr>
        <div class="row m-b-20">
            <div class="col-md-3"><label>Tanggal</label><br><?= $display($visit->visit_date ?? null) ?></div>
            <div class="col-md-3"><label>Poli</label><br><?= $display($visit->polyclinic_name ?? null) ?></div>
            <div class="col-md-3"><label>Dokter</label><br><?= $display($doctor->doctor_name ?? null) ?></div>
            <div class="col-md-3"><label>Status Kunjungan</label><br><?= $display($visit->status ?? null) ?></div>
        </div>

        <?= $this->Form->create(null) ?>
        <input type="hidden" name="status" value="Draft">

        <h5>CPPT</h5>
        <div class="row">
            <div class="col-md-3 form-group">
                <label>Waktu Catatan</label>
                <input type="datetime-local" name="noted_at" class="form-control" value="<?= h(date('Y-m-d\TH:i')) ?>">
            </div>
            <div class="col-md-3 form-group">
                <label>Profesi</label>
                <input type="text" name="profession" class="form-control" value="Dokter">
            </div>
            <div class="col-md-3 form-group">
                <label>Nama Petugas</label>
                <input type="text" name="officer_name" class="form-control" value="<?= $display($doctor->doctor_name ?? null) ?>">
            </div>
            <div class="col-md-3 form-group">
                <label>No STR</label>
                <input type="text" name="str_number" class="form-control" value="<?= $display($doctor->str_number ?? null) ?>">
            </div>
        </div>

        <h5>SOAP</h5>
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Subjective</label>
                <textarea name="subjective" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-md-6 form-group">
                <label>Objective</label>
                <textarea name="objective" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-6 form-group">
                <label>Assessment</label>
                <textarea name="assessment" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-md-6 form-group">
                <label>Plan</label>
                <textarea name="plan" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <h5>Tanda Vital</h5>
        <div class="row">
            <div class="col-md-3 form-group">
                <label>Tekanan Darah</label>
                <input type="text" name="blood_pressure" class="form-control" placeholder="120/80 mmHg">
            </div>
            <div class="col-md-3 form-group">
                <label>Nadi</label>
                <input type="text" name="pulse" class="form-control" placeholder="80 x/menit">
            </div>
            <div class="col-md-3 form-group">
                <label>Respirasi</label>
                <input type="text" name="respiratory_rate" class="form-control" placeholder="20 x/menit">
            </div>
            <div class="col-md-3 form-group">
                <label>Suhu</label>
                <input type="text" name="temperature" class="form-control" placeholder="36.8 C">
            </div>
            <div class="col-md-3 form-group">
                <label>SpO2</label>
                <input type="text" name="oxygen_saturation" class="form-control" placeholder="98%">
            </div>
            <div class="col-md-3 form-group">
                <label>Berat Badan</label>
                <input type="text" name="weight" class="form-control" placeholder="60 kg">
            </div>
            <div class="col-md-3 form-group">
                <label>Tinggi Badan</label>
                <input type="text" name="height" class="form-control" placeholder="165 cm">
            </div>
            <div class="col-md-3 form-group">
                <label>Skala Nyeri</label>
                <input type="text" name="pain_scale" class="form-control" placeholder="0-10">
            </div>
        </div>

        <h5>Klinis</h5>
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Alergi</label>
                <input type="text" name="allergy" class="form-control" placeholder="Tidak ada / sebutkan alergi">
            </div>
            <div class="col-md-6 form-group">
                <label>Diagnosa Utama</label>
                <input type="text" name="diagnosis_primary" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label>Diagnosa Sekunder</label>
                <input type="text" name="diagnosis_secondary" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label>Tindakan</label>
                <input type="text" name="action_notes" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label>Catatan Dokter</label>
                <textarea name="doctor_notes" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-6 form-group">
                <label>Catatan Pemeriksaan</label>
                <textarea name="note" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <h5>Penunjang dan Terapi</h5>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Resep</label>
                <textarea name="prescription_notes" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-4 form-group">
                <label>Laboratorium</label>
                <textarea name="laboratory_note" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-4 form-group">
                <label>Radiologi</label>
                <textarea name="radiology_note" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <h5>Rujukan</h5>
        <div class="row">
            <div class="col-md-3 form-group">
                <label>No Rujukan</label>
                <input type="text" name="referral_no" class="form-control">
            </div>
            <div class="col-md-3 form-group">
                <label>Jenis Rujukan</label>
                <input type="text" name="referral_type" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label>Catatan Rujukan</label>
                <textarea name="referral_note" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan Pemeriksaan
        </button>
        <?= $this->Form->end() ?>

        <hr>
        <h5>Riwayat Catatan Pemeriksaan</h5>
        <?php $examinations = $details['examinations'] ?? []; ?>
        <?php if (empty($examinations)): ?>
            <div class="alert alert-secondary">Belum ada catatan pemeriksaan.</div>
        <?php else: ?>
            <?php foreach ($examinations as $row): ?>
                <div class="well">
                    <div class="text-muted small"><?= $display($row['created'] ?? null) ?> / <?= $display($row['status'] ?? null) ?></div>
                    <div><?= nl2br(h($row['note'] ?? '-')) ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php foreach (['prescriptions' => 'Resep', 'laboratories' => 'Laboratorium', 'radiologies' => 'Radiologi', 'referrals' => 'Rujukan'] as $key => $title): ?>
            <?php $rows = $details[$key] ?? []; ?>
            <?php if (!empty($rows)): ?>
                <h5><?= h($title) ?></h5>
                <?php foreach ($rows as $row): ?>
                    <div class="well">
                        <div class="text-muted small"><?= $display($row['created'] ?? null) ?> / <?= $display($row['status'] ?? null) ?></div>
                        <?php if ($key === 'referrals'): ?>
                            <div><strong><?= $display($row['referral_no'] ?? null) ?></strong> <?= $display($row['referral_type'] ?? null) ?></div>
                        <?php endif; ?>
                        <div><?= nl2br(h($row['note'] ?? '-')) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<script>
(function () {
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            var button = form.querySelector('button[type="submit"], input[type="submit"]');
            if (!button) {
                return;
            }

            button.disabled = true;
            if (button.tagName === 'BUTTON') {
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';
            } else {
                button.value = 'Menyimpan...';
            }
        });
    });
})();
</script>
