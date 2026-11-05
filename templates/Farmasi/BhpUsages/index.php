<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Farmasi</a></li>
    <li class="breadcrumb-item active">Pemakaian BHP</li>
</ol>
<h1 class="page-header">Pemakaian Non Beban BHP <small>Daftar transaksi</small></h1>

<div class="panel panel-inverse">
    <div class="panel-body">
        <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
        <div class="form-row align-items-end mb-3">
            <div class="col-md-2"><label>Dari</label><?= $this->Form->date('date_from', ['value' => $from, 'class' => 'form-control']) ?></div>
            <div class="col-md-2"><label>Sampai</label><?= $this->Form->date('date_to', ['value' => $to, 'class' => 'form-control']) ?></div>
            <div class="col-md-3"><label>Cari</label><?= $this->Form->text('q', ['value' => $q, 'placeholder' => 'No TR / Nama / RM', 'class' => 'form-control']) ?></div>
            <div class="col-md-5">
                <button class="btn btn-warning"><i class="fa fa-search"></i> Cari</button>
                <?= $this->Html->link('<i class="fa fa-plus"></i> Pemakaian Baru', ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr><th>Tr No</th><th>Tanggal</th><th>Depo</th><th>Pembeli</th><th class="text-right">Total Net</th><th style="width:120px;">Aksi</th></tr>
            </thead>
            <tbody>
            <?php foreach ($usages as $u): ?>
                <tr>
                    <td><code><?= h($u->usage_no) ?></code></td>
                    <td><?= $u->usage_date->format('d-m-Y') ?></td>
                    <td><?= h($u->depo) ?></td>
                    <td><?= $u->buyer_type === 'pasien'
                        ? h($u->patient_name) . ' <small class="text-muted">(' . h($u->registration_no) . ')</small>'
                        : 'Unit: ' . h($u->unit_name) ?></td>
                    <td class="text-right"><?= number_format((float)$u->grand_total, 0, ',', '.') ?></td>
                    <td class="text-nowrap">
                        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $u->id], ['class' => 'btn btn-xs btn-info', 'escape' => false]) ?>
                        <?= $this->Form->postLink('<i class="fa fa-times"></i>', ['action' => 'delete', $u->id], ['class' => 'btn btn-xs btn-danger', 'escape' => false, 'confirm' => 'Hapus transaksi ini?']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($usages) === 0): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <small class="text-muted"><?= $this->Paginator->counter('Halaman {{page}} dari {{pages}}, total {{count}} data') ?></small>
            <ul class="pagination pagination-sm mb-0"><?= $this->Paginator->prev('«') ?><?= $this->Paginator->next('»') ?></ul>
        </div>
    </div>
</div>