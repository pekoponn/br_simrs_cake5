<?php
$this->assign('title', 'Menu Dokter - Antrean Pasien');
$statusLabel = ['waiting' => 'Menunggu', 'called' => 'Dipanggil', 'in_progress' => 'Sedang Diperiksa'];
?>
<?= $this->Krs->breadcrumb('Outpatient Visits', 'Menu Dokter') ?>

<style>
    .doctor-queue-card { border:1px solid #e5e7eb; border-radius:10px; background:#fff; margin-bottom:12px; padding:16px 18px; box-shadow:0 2px 8px rgba(15,23,42,.06); }
    .doctor-queue-number { font-size:30px; font-weight:800; color:#123e59; }
    .doctor-queue-name { font-size:17px; font-weight:700; color:#1f2937; }
    .doctor-queue-meta { color:#6b7280; font-size:12px; margin-top:4px; }
    .doctor-queue-actions { display:flex; gap:7px; justify-content:flex-end; flex-wrap:wrap; }
    .doctor-queue-filter { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .doctor-queue-filter .select2-container { min-width:280px; }
    @media(max-width:700px) { .doctor-queue-actions { justify-content:flex-start; margin-top:12px; } }
</style>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-user-md"></i> Menu Dokter - Daftar Pasien</h4>
    </div>
    <div class="panel-body">
        <form method="get" class="doctor-queue-filter" style="margin-bottom:18px;">
            <label for="doctor-queue-poli" style="margin:0;">Poli</label>
            <select id="doctor-queue-poli" class="form-control select2Form" name="poli" data-placeholder="Pilih poli" style="width:280px;">
                <option value=""></option>
                <?php foreach ($this->Krs->polyclinics() as $poliValue => $poliLabel): ?>
                    <option value="<?= h($poliValue) ?>"<?= $polyclinic === $poliValue ? ' selected' : '' ?>><?= h($poliLabel) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i> Tampilkan</button>
        </form>

        <?php if (!$visits->count()): ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Belum ada pasien aktif untuk poli ini hari ini.</div>
        <?php else: ?>
            <?php foreach ($visits as $visit): ?>
                <div class="doctor-queue-card row">
                    <div class="col-sm-2"><div class="doctor-queue-number"><?= h($visit->queue_number ?? '-') ?></div><div class="doctor-queue-meta">Nomor antrean</div></div>
                    <div class="col-sm-5"><div class="doctor-queue-name"><?= h($visit->patient->full_name ?? '-') ?></div><div class="doctor-queue-meta">No. RM: <?= h($visit->patient->code ?? '-') ?></div></div>
                    <div class="col-sm-2"><span class="label label-default"><?= h($statusLabel[$visit->status] ?? $visit->status) ?></span></div>
                    <div class="col-sm-3 doctor-queue-actions">
                        <?php if (in_array($visit->status, ['waiting', 'called'], true)): ?>
                            <?= $this->Form->create(null, [
                                'url' => ['action' => 'panggil', $visit->id, '?' => ['return' => 'doctorQueue', 'poli' => $polyclinic]],
                                'style' => 'display:inline-block;margin:0;',
                            ]) ?>
                            <button
                                type="submit"
                                class="btn btn-primary btn-sm doctor-action doctor-call-action"
                                data-queue-number="<?= h($visit->queue_number ?? '-') ?>"
                                data-polyclinic="<?= h($polyclinic) ?>">
                                <i class="fa fa-bullhorn"></i>
                                <?= $visit->status === 'called' ? 'Panggil Lagi' : 'Panggil' ?>
                            </button>
                            <?= $this->Form->end() ?>
                        <?php endif; ?>
                        <?php if ($visit->status === 'called'): ?>
                            <?= $this->Form->postLink('<i class="fa fa-user-check"></i> Sudah Datang', ['action' => 'datang', $visit->id, '?' => ['return' => 'doctorQueue', 'poli' => $polyclinic]], ['escape' => false, 'class' => 'btn btn-info btn-sm doctor-action']) ?>
                        <?php endif; ?>
                        <?php if (in_array($visit->status, ['called', 'in_progress'], true)): ?>
                            <?= $this->Form->postLink('<i class="fa fa-check"></i> Selesai', ['action' => 'selesai', $visit->id, '?' => ['return' => 'doctorQueue', 'poli' => $polyclinic]], ['escape' => false, 'class' => 'btn btn-success btn-sm doctor-action']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function announceDoctorQueue(button) {
    return new Promise(function (resolve) {
        if (!button.classList.contains('doctor-call-action') || !('speechSynthesis' in window)) {
            resolve();
            return;
        }

        var queueNumber = button.getAttribute('data-queue-number') || '-';
        var polyclinic = button.getAttribute('data-polyclinic') || '';
        var text = 'Nomor antrean ' + queueNumber + ', ' + polyclinic + ', silakan menuju ruang pemeriksaan.';
        var finished = false;
        var finish = function () {
            if (finished) return;
            finished = true;
            resolve();
        };

        window.speechSynthesis.cancel();
        var utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'id-ID';
        utterance.rate = 0.9;
        utterance.volume = 1;
        utterance.onend = finish;
        utterance.onerror = finish;
        window.speechSynthesis.speak(utterance);

        // Jangan menahan proses apabila engine suara browser tidak memberi callback.
        window.setTimeout(finish, 7000);
    });
}

function submitDoctorQueueAction(form, button) {
    if (button) button.disabled = true;

    var request = fetch(form.action, {
        method: 'POST',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        body: new FormData(form)
    });

    Promise.all([request, announceDoctorQueue(button)]).then(function () {
        window.location.reload();
    }).catch(function () {
        window.location.reload();
    });
}

document.addEventListener('click', function (event) {
    var button = event.target.closest('button.doctor-action');
    if (!button) return;
    event.preventDefault();
    var form = button.closest('form');
    if (!form) return;
    if (button.textContent.indexOf('Selesai') !== -1 && !window.confirm('Tandai pasien ini selesai diperiksa?')) return;
    submitDoctorQueueAction(form, button);
});
document.addEventListener('submit', function (event) {
    var form = event.target;
    var action = (form.getAttribute('action') || '').toLowerCase();
    if (!/(panggil|datang|selesai)/.test(action)) return;
    event.preventDefault();
    var button = form.querySelector('button');
    if (button && button.disabled) return;
    if (button && button.textContent.indexOf('Selesai') !== -1 && !window.confirm('Tandai pasien ini selesai diperiksa?')) return;
    submitDoctorQueueAction(form, button);
});
</script>
<script>
$(function () {
    $('#doctor-queue-poli').select2({
        width: '280px',
        placeholder: 'Pilih poli',
        allowClear: false
    });
});
</script>
