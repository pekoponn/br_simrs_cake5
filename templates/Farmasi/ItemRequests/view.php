<h1 class="page-header">Permohonan <?= h($request->request_no) ?></h1>
<div class="panel panel-inverse"><div class="panel-body">
    <p><b>Tanggal:</b> <?= $request->request_date->format('d-m-Y') ?>
       &nbsp; <b>Dari Bagian:</b> <?= h($request->from_depo) ?>
       &nbsp; <b>Ke Bagian:</b> <?= h($request->to_depo) ?>
       &nbsp; <b>Status:</b> <?= h($request->status) ?></p>
    <p><b>Keterangan:</b> <?= h($request->notes) ?></p>
    <table class="table table-bordered table-sm">
        <thead class="thead-dark"><tr><th>Kode</th><th>Nama Barang</th><th class="text-right">Qty</th><th>Unit</th><th>Keterangan</th></tr></thead>
        <tbody>
        <?php foreach ($request->item_request_items as $i): ?>
            <tr>
                <td><?= h($i->item_code) ?></td>
                <td><?= h($i->item_name) ?></td>
                <td class="text-right"><?= h($i->qty) ?></td>
                <td><?= h($i->unit) ?></td>
                <td><?= h($i->notes) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->Html->link('Kembali', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
</div></div>