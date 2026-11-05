<h1 class="page-header">Pemakaian BHP <?= h($usage->usage_no) ?></h1>
<div class="panel panel-inverse"><div class="panel-body">
    <p><b>Tanggal:</b> <?= $usage->usage_date->format('d-m-Y') ?> <?= $usage->usage_time ? $usage->usage_time->format('H:i') : '' ?>
       &nbsp; <b>Depo:</b> <?= h($usage->depo) ?>
       &nbsp; <b>Antri:</b> <?= h($usage->queue_no) ?></p>
    <?php if ($usage->buyer_type === 'pasien'): ?>
        <p><b>Pasien:</b> <?= h($usage->patient_name) ?> (<?= h($usage->registration_no) ?>, RM <?= h($usage->medical_record_no) ?>)
           &nbsp; <b>Dokter:</b> <?= h($usage->doctor_name) ?>
           &nbsp; <b>Kelas:</b> <?= h($usage->class_name) ?>
           &nbsp; <b>Dari:</b> <?= h($usage->origin) ?>
           &nbsp; <b>Phone:</b> <?= h($usage->phone) ?></p>
    <?php else: ?>
        <p><b>Unit:</b> <?= h($usage->unit_name) ?></p>
    <?php endif; ?>
    <table class="table table-bordered table-sm">
        <thead class="thead-dark">
            <tr><th>Kode</th><th>Nama Barang</th><th class="text-right">Qty</th><th>Satuan</th><th class="text-right">Harga</th>
                <th class="text-right">Disc %</th><th class="text-right">PPN Rp</th><th class="text-right">Total</th>
                <th>Kadaluarsa</th><th>Aturan Pakai</th><th>Rak</th></tr>
        </thead>
        <tbody>
        <?php foreach ($usage->bhp_usage_items as $i): ?>
            <tr>
                <td><?= h($i->item_code) ?></td><td><?= h($i->item_name) ?></td>
                <td class="text-right"><?= h($i->qty) ?></td><td><?= h($i->unit) ?></td>
                <td class="text-right"><?= number_format((float)$i->price, 0, ',', '.') ?></td>
                <td class="text-right"><?= h($i->disc_percent) ?></td>
                <td class="text-right"><?= number_format((float)$i->ppn_amount, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format((float)$i->total, 0, ',', '.') ?></td>
                <td><?= $i->expired_date ? $i->expired_date->format('d-m-Y') : '-' ?></td>
                <td><?= h($i->usage_rule) ?></td><td><?= h($i->shelf_no) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><th colspan="7" class="text-right">Subtotal</th><th class="text-right"><?= number_format((float)$usage->subtotal, 0, ',', '.') ?></th><th colspan="3"></th></tr>
            <tr><th colspan="7" class="text-right">Diskon</th><th class="text-right"><?= number_format((float)$usage->discount_total, 0, ',', '.') ?></th><th colspan="3"></th></tr>
            <tr><th colspan="7" class="text-right">Pajak</th><th class="text-right"><?= number_format((float)$usage->tax_total, 0, ',', '.') ?></th><th colspan="3"></th></tr>
            <tr><th colspan="7" class="text-right">Total Net</th><th class="text-right"><?= number_format((float)$usage->grand_total, 0, ',', '.') ?></th><th colspan="3"></th></tr>
        </tfoot>
    </table>
    <?= $this->Html->link('Kembali', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
</div></div>