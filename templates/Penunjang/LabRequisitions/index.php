<?php
/**
 * templates/Penunjang/LabRequisitions/index.php
 *
 * @var \App\View\AppView $this
 * @var iterable $requisitions
 * @var string $from
 * @var string $to
 */
$badges = ['diajukan' => ['badge-warning', 'Diajukan'], 'disetujui' => ['badge-info', 'Disetujui'], 'selesai' => ['badge-success', 'Selesai']];
?>
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Laboratorium', ['controller' => 'LabExaminations', 'action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Permohonan Logistik</li>
</ol>
<h1 class="page-header">Permohonan Logistik <small>Daftar permohonan</small></h1>

<?= $this->Flash->render() ?>
<div class="panel panel-inverse">
    <div class="panel-body">
        <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
        <div class="form-row align-items-end mb-3">
            <div class="col-md-3"><label>Dari</label><?= $this->Form->date('date_from', ['value' => $from, 'class' => 'form-control']) ?></div>
            <div class="col-md-3"><label>Sampai</label><?= $this->Form->date('date_to', ['value' => $to, 'class' => 'form-control']) ?></div>
            <div class="col-md-6">
                <button class="btn btn-warning"><i class="fa fa-search"></i> Cari</button>
                <?= $this->Html->link('<i class="fa fa-plus"></i> Permohonan Baru', ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>No. Mohon</th><th>Tanggal</th><th>Dari Bagian [Depo]</th><th>Ke Bagian</th>
                        <th class="text-center">Jml Barang</th><th>Status</th><th style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $any = false; foreach ($requisitions as $r): $any = true;
                    [$cls, $lbl] = $badges[$r->status] ?? ['badge-secondary', (string)$r->status]; ?>
                    <tr>
                        <td><code><?= h($r->request_no) ?></code></td>
                        <td><?= $r->request_date->format('d-m-Y') ?></td>
                        <td><?= h($r->from_dept) ?></td>
                        <td><?= h($r->to_dept) ?></td>
                        <td class="text-center"><?= (int)$r->item_count ?></td>
                        <td><span class="badge <?= $cls ?>"><?= h($lbl) ?></span></td>
                        <td class="text-nowrap">
                            <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $r->id], ['class' => 'btn btn-xs btn-info', 'escape' => false, 'title' => 'Lihat']) ?>
                            <?= $this->Form->postLink('<i class="fa fa-times"></i>', ['action' => 'delete', $r->id], ['class' => 'btn btn-xs btn-danger', 'escape' => false, 'title' => 'Hapus', 'confirm' => 'Hapus permohonan ini?']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$any): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada permohonan</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <small class="text-muted"><?= $this->Paginator->counter('Halaman {{page}} dari {{pages}}, total {{count}} data') ?></small>
            <ul class="pagination pagination-sm mb-0"><?= $this->Paginator->prev('«') ?><?= $this->Paginator->next('»') ?></ul>
        </div>
    </div>
</div>