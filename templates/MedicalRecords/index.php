<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\OutpatientVisit> $visits
 * @var string $dateFrom
 * @var string $dateTo
 * @var string|null $q
 * @var string|null $status
 */

$statusLabels = [
    'waiting' => 'Menunggu',
    'called' => 'Dipanggil',
    'in_progress' => 'Diperiksa',
    'done' => 'Selesai',
    'cancelled' => 'Batal',
];

$formatDate = function ($value): string {
    if (empty($value)) {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format('d-m-Y');
    }

    return date('d-m-Y', strtotime((string)$value));
};
?>

<?= $this->Krs->breadcrumb('Medical Record', 'Pemeriksaan') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-stethoscope"></i> Pemeriksaan Rawat Jalan</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>
    <div class="panel-body">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'm-b-15']) ?>
        <div class="row">
            <div class="col-md-2">
                <label>Dari</label>
                <input type="date" name="date_from" class="form-control" value="<?= h($dateFrom) ?>">
            </div>
            <div class="col-md-2">
                <label>Sampai</label>
                <input type="date" name="date_to" class="form-control" value="<?= h($dateTo) ?>">
            </div>
            <div class="col-md-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    <?php foreach ($statusLabels as $key => $label): ?>
                        <option value="<?= h($key) ?>" <?= $status === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Cari</label>
                <input type="text" name="q" class="form-control" value="<?= h($q ?? '') ?>" placeholder="No registrasi / pasien / dokter">
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-search"></i> Filter
                </button>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-td-valign-middle">
                <thead class="thead-dark">
                    <tr>
                        <th width="95">Tanggal</th>
                        <th width="120">No Reg</th>
                        <th>Pasien</th>
                        <th width="160">Poli</th>
                        <th width="180">Dokter</th>
                        <th width="100">Status</th>
                        <th width="90">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($visits) || !count($visits)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted p-20">Belum ada kunjungan rawat jalan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($visits as $visit): ?>
                            <tr>
                                <td><?= h($formatDate($visit->visit_date ?? null)) ?></td>
                                <td><strong><?= h($visit->registration_no ?? '-') ?></strong></td>
                                <td>
                                    <strong><?= h($visit->patient->full_name ?? '-') ?></strong><br>
                                    <small class="text-muted"><?= h($visit->patient->medical_record_no ?? $visit->patient->code ?? '-') ?></small>
                                </td>
                                <td><?= h($visit->polyclinic_name ?? '-') ?></td>
                                <td><?= h($visit->doctor->doctor_name ?? '-') ?></td>
                                <td><?= h($statusLabels[$visit->status] ?? $visit->status ?? '-') ?></td>
                                <td>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-stethoscope"></i> Periksa',
                                        ['action' => 'periksa', $visit->id],
                                        ['class' => 'btn btn-xs btn-primary', 'escape' => false]
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= $this->Krs->paginators() ?>
    </div>
</div>
