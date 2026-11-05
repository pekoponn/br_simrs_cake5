<?php
/**
 * templates/Penunjang/LabRequisitions/view.php
 *
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $requisition
 */
?>
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Permohonan Logistik', ['action' => 'index']) ?></li>
    <li class="breadcrumb-item active"><?= h($requisition->request_no) ?></li>
</ol>
<h1 class="page-header">Permohonan <?= h($requisition->request_no) ?></h1>

<div class="panel panel-inverse">
    <div class="panel-body">
        <div class="row mb-3">
            <div class="col-md-4"><b>Tanggal:</b> <?= $requisition->request_date->format('d-m-Y') ?></div>
            <div class="col-md-4"><b>Dari Bagian [Depo]:</b> <?= h($requisition->from_dept) ?></div>
            <div class="col-md-4"><b>Ke Bagian:</b> <?= h($requisition->to_dept) ?></div>
        </div>
        <p><b>Keterangan:</b> <?= h($requisition->notes) ?: '<span class="text-muted">-</span>' ?></p>

        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr><th style="width:140px;">Kode</th><th>Nama Barang</th><th class="text-right" style="width:100px;">Qty</th><th style="width:100px;">Unit</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
            <?php foreach ($requisition->lab_requisition_items as $i): ?>
                <tr>
                    <td><?= h($i->item_code) ?></td>
                    <td><?= h($i->item_name) ?></td>
                    <td class="text-right"><?= h(rtrim(rtrim(number_format((float)$i->qty, 2, '.', ''), '0'), '.')) ?></td>
                    <td><?= h($i->unit) ?></td>
                    <td><?= h($i->notes) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->Html->link('Kembali', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        <?= $this->Html->link('Permohonan Baru', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>