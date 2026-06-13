<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientVisit $visit
 * @var array $cpptNotes
 * @var array $doctors
 * @var string $currentUserName
 */

$patient = $visit->patient ?? null;
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

<?= $this->Krs->breadcrumb('Outpatient Visits', 'CPPT') ?>

<div class="outpatient-visits cppt content">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h4 style="margin:0; font-weight:700; color:#1e3a5f;">
            <i class="fa fa-clipboard-list"></i> CPPT - Form Integrasi
        </h4>
        <div style="display:flex; gap:6px;">
            <?= $this->Html->link(
                '<i class="fa fa-notes-medical"></i> EMR',
                ['action' => 'emr', $visit->id],
                ['escape' => false, 'class' => 'btn btn-info btn-sm']
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-history"></i> Riwayat Rekam Medis',
                ['controller' => 'MedicalRecords', 'action' => 'history', $visit->patient_id],
                ['escape' => false, 'class' => 'btn btn-primary btn-sm']
            ) ?>
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </div>
    </div>

    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:10px 14px; background:#f8f9fa;">
            <div class="row">
                <div class="col-md-2">
                    <small>No Registrasi</small><br>
                    <strong><?= $display($visit->registration_no ?? $visit->registration->registration_no ?? null) ?></strong>
                </div>
                <div class="col-md-2">
                    <small>No Rekam Medis</small><br>
                    <strong><?= $display($patient->medical_record_no ?? $patient->code ?? null) ?></strong>
                </div>
                <div class="col-md-4">
                    <small>Nama Pasien</small><br>
                    <strong><?= $display($patient->full_name ?? null) ?></strong>
                </div>
                <div class="col-md-2">
                    <small>Dokter Kunjungan</small><br>
                    <strong><?= $display($doctor->doctor_name ?? null) ?></strong>
                </div>
                <div class="col-md-1">
                    <small>Poli</small><br>
                    <strong><?= $display($visit->polyclinic_name ?? null) ?></strong>
                </div>
                <div class="col-md-1">
                    <small>No Antri</small><br>
                    <strong style="font-size:20px; color:#1e3a5f;"><?= $display($visit->queue_number ?? null) ?></strong>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="margin-bottom:14px;">
        <div class="panel-heading" style="padding:8px 14px; background:#1e3a5f;">
            <strong style="color:#fff; font-size:12px;">
                <i class="fa fa-history"></i> Riwayat Catatan Form Integrasi
            </strong>
        </div>
        <div class="panel-body" style="padding:0;">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" style="font-size:11px; margin-bottom:0;">
                    <thead>
                        <tr style="background:#f8f9fa;">
                            <th width="95" style="text-align:center;">Tanggal</th>
                            <th width="70" style="text-align:center;">Jam</th>
                            <th width="170">Tenaga Kesehatan</th>
                            <th width="190">Dokter</th>
                            <th>SOAP SBAR</th>
                            <th>Instruksi</th>
                            <th width="60" style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cpptNotes)): ?>
                            <tr>
                                <td colspan="7" style="text-align:center; padding:30px; color:#9ca3af;">
                                    <div style="font-size:28px; margin-bottom:6px;"><i class="fa fa-clipboard"></i></div>
                                    <div style="font-weight:600;">Belum ada catatan CPPT</div>
                                    <div style="font-size:10px; margin-top:3px;">Tambah catatan pertama di bawah</div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($cpptNotes as $note): ?>
                                <?php
                                $notedAt = $note['noted_at'] ?? $note['created'] ?? null;
                                $notedAt = $notedAt ? new DateTime((string)$notedAt) : null;
                                ?>
                                <tr>
                                    <td style="text-align:center; white-space:nowrap;"><?= $notedAt ? h($notedAt->format('d-m-Y')) : '-' ?></td>
                                    <td style="text-align:center; white-space:nowrap;"><?= $notedAt ? h($notedAt->format('H:i')) : '-' ?></td>
                                    <td>
                                        <strong><?= $display($note['health_worker_name'] ?? null) ?></strong>
                                        <?php if (!empty($note['profession'])): ?>
                                            <br><small><?= h($note['profession']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $display($note['doctor_name'] ?? null) ?></td>
                                    <td style="max-width:380px;"><div style="white-space:pre-wrap; word-break:break-word;"><?= h($note['soap_sbar'] ?? '-') ?></div></td>
                                    <td style="max-width:320px;"><div style="white-space:pre-wrap; word-break:break-word;"><?= h($note['instruction'] ?? '-') ?></div></td>
                                    <td style="text-align:center;">
                                        <?= $this->Form->postLink(
                                            '<i class="fa fa-trash"></i>',
                                            ['action' => 'deleteCppt', $note['id']],
                                            [
                                                'escape' => false,
                                                'class' => 'btn btn-xs btn-danger',
                                                'confirm' => 'Hapus catatan ini?',
                                            ]
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if (!in_array($visit->status, ['done', 'cancelled'], true)): ?>
        <div class="panel panel-default">
            <div class="panel-heading" style="padding:8px 14px; background:#495057;">
                <strong style="color:#fff; font-size:12px;">
                    <i class="fa fa-plus-circle"></i> Tambah Catatan Baru
                </strong>
            </div>
            <div class="panel-body" style="padding:14px;">
                <?= $this->Form->create(null, ['url' => ['action' => 'addCppt', $visit->id]]) ?>

                <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-3">
                        <label>Tanggal & Jam</label>
                        <input type="datetime-local" name="noted_at" class="form-control" value="<?= h(date('Y-m-d\TH:i')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Tenaga Kesehatan</label>
                        <input type="text" class="form-control" value="<?= h($currentUserName ?: '-') ?>" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Dokter</label>
                        <select name="doctor_id" class="form-control" required>
                            <option value="">-- Pilih Dokter --</option>
                            <?php foreach ($doctors as $doctorId => $doctorName): ?>
                                <option value="<?= h($doctorId) ?>" <?= (int)$doctorId === (int)($visit->doctor_id ?? 0) ? 'selected' : '' ?>>
                                    <?= h($doctorName) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Status</label>
                        <input type="text" class="form-control" value="Draft" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>SOAP SBAR</label>
                        <textarea name="soap_sbar" class="form-control" rows="8" required placeholder="S: Keluhan pasien...
O: Tanda vital / hasil pemeriksaan...
A: Asesmen / diagnosa...
P: Rencana terapi...
SBAR: Situation, Background, Assessment, Recommendation..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Instruksi</label>
                        <textarea name="instruction" class="form-control" rows="8" placeholder="Instruksi dokter / tindakan / edukasi / observasi / kolaborasi..."></textarea>
                    </div>
                </div>

                <div style="display:flex; gap:8px; margin-top:12px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Catatan
                    </button>
                    <?= $this->Html->link(
                        '<i class="fa fa-arrow-left"></i> Kembali ke Antrian',
                        ['action' => 'index'],
                        ['escape' => false, 'class' => 'btn btn-default']
                    ) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Kunjungan ini sudah <?= $visit->status === 'done' ? 'selesai' : 'dibatalkan' ?>.
            Catatan baru tidak dapat ditambahkan.
        </div>
    <?php endif; ?>
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
            button.dataset.originalText = button.innerHTML || button.value;
            if (button.tagName === 'BUTTON') {
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';
            } else {
                button.value = 'Menyimpan...';
            }
        });
    });
})();
</script>
