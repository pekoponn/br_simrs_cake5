<h1 class="page-header">Pemakaian <?= h($usage->usage_no) ?></h1>
<div class="panel panel-inverse"><div class="panel-body">
    <p><b>Tanggal:</b> <?= $usage->usage_date->format('d-m-Y') ?> &nbsp; <b>Gudang:</b> <?= h($usage->warehouse) ?> &nbsp; <b>Cost Centre:</b> <?= h($usage->cost_centre) ?></p>
    <?php if ($usage->charge_to_patient): ?>
        <p><b>Dibebankan ke:</b> <?= h($usage->patient_name) ?> (<?= h($usage->registration_no) ?>, RM <?= h($usage->medical_record_no) ?>)</p>
    <?php endif; ?>
    <p><b>Keterangan:</b> <?= h($usage->notes) ?></p>
    <table class="table table-bordered table-sm">
        <thead class="thead-dark"><tr><th>Kode</th><th>Nama Barang</th><th class="text-right">Qty</th><th>Unit</th><th class="text-right">Harga</th><th class="text-right">Total</th></tr></thead>
        <tbody>
        <?php foreach ($usage->lab_usage_items as $i): ?>
            <tr><td><?= h($i->item_code) ?></td><td><?= h($i->item_name) ?></td>
                <td class="text-right"><?= h($i->qty) ?></td><td><?= h($i->unit) ?></td>
                <td class="text-right"><?= number_format((float)$i->price, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format((float)$i->total, 0, ',', '.') ?></td></tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot><tr><th colspan="5" class="text-right">Total</th><th class="text-right"><?= number_format((float)$usage->grand_total, 0, ',', '.') ?></th></tr></tfoot>
    </table>
    <?= $this->Html->link('Kembali', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
</div></div>