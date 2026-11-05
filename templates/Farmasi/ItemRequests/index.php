<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Farmasi</a></li>
    <li class="breadcrumb-item active">Permohonan Barang</li>
</ol>
<h1 class="page-header">Permohonan Permintaan Barang <small>Daftar</small></h1>

<div class="panel panel-inverse">
    <div class="panel-body">
        <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
        <div class="form-row align-items-end mb-3">
            <div class="col-md-2"><label>Dari</label><?= $this->Form->date('date_from', ['value' => $from, 'class' => 'form-control']) ?></div>
            <div class="col-md-2"><label>Sampai</label><?= $this->Form->date('date_to', ['value' => $to, 'class' => 'form-control']) ?></div>
            <div class="col-md-3"><label>Cari</label><?= $this->Form->text('q', ['value' => $q, 'placeholder' => 'No Mohon / Bagian', 'class' => 'form-control']) ?></div>
            <div class="col-md-5">
                <button class="btn btn-warning"><i class="fa fa-search"></i> Cari</button>
                <?= $this->Html->link('<i class="fa fa-plus"></i> Permohonan Baru', ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr><th>No. Mohon</th><th>Tanggal</th><th>Dari Bagian</th><th>Ke Bagian</th><th>Keterangan</th><th>Status</th><th style="width:100px;">Aksi</th></tr>
            </thead>
            <tbody>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td><code><?= h($r->request_no) ?></code></td>
                    <td><?= $r->request_date->format('d-m-Y') ?></td>
                    <td><?= h($r->from_depo) ?></td>
                    <td><?= h($r->to_depo) ?></td>
                    <td><?= h($r->notes) ?></td>
                    <td><span class="badge badge-info"><?= h($r->status) ?></span></td>
                    <td class="text-nowrap">
                        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $r->id], ['class' => 'btn btn-xs btn-info', 'escape' => false]) ?>
                        <?= $this->Form->postLink('<i class="fa fa-times"></i>', ['action' => 'delete', $r->id], ['class' => 'btn btn-xs btn-danger', 'escape' => false, 'confirm' => 'Hapus permohonan ini?']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($requests) === 0): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <small class="text-muted"><?= $this->Paginator->counter('Halaman {{page}} dari {{pages}}, total {{count}} data') ?></small>
            <ul class="pagination pagination-sm mb-0"><?= $this->Paginator->prev('«') ?><?= $this->Paginator->next('»') ?></ul>
        </div>
    </div>
</div>